<HTML>
<?php

do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if(!isset($fort)) $fort = 1;

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

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$nastav = $_REQUEST['nastav'];

$cislo_oc = $_REQUEST['cislo_oc'];
$umep="1.".$kli_vrok;
$umek="3.".$kli_vrok;
if( $cislo_oc == 2 ) { $umep="4.".$kli_vrok; $umek="6.".$kli_vrok; }
if( $cislo_oc == 3 ) { $umep="7.".$kli_vrok; $umek="9.".$kli_vrok; }
if( $cislo_oc == 4 ) { $umep="10.".$kli_vrok; $umek="12.".$kli_vrok; }

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$sql = "DELETE FROM F$kli_vxcf"."_mzdprnahset WHERE cpl = 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprnahset MODIFY cpl int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM F$kli_vxcf"."_mzdprnahdelene WHERE cpl = 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprnahdelene MODIFY cpl int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");

//nacitaj delitelne casti
if( $copern == 1001 )
{
$umetento="1.".$kli_vrok;
$sqltt = "SELECT * FROM F".$kli_vxcf."_mzdprnahset WHERE ume >= $umetento AND ucm > 0 AND ucd > 0";
$pol=0;
$sql = mysql_query("$sqltt");
if( $sql ) { $pol = mysql_num_rows($sql); }
if( $pol > 0 ) {
//echo "nacitaj deleny";

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprnahdelene  WHERE ( ume = 01.$kli_vrok OR ume = 02.$kli_vrok OR ume = 03.$kli_vrok ".
" OR ume = 04.$kli_vrok OR ume = 05.$kli_vrok OR ume = 06.$kli_vrok OR ume = 07.$kli_vrok OR ume = 08.$kli_vrok OR ume = 09.$kli_vrok".
" OR ume = 10.$kli_vrok OR ume = 11.$kli_vrok OR ume = 12.$kli_vrok )";
$dsql = mysql_query("$dsqlt");

$sqltt = "SELECT * FROM F".$kli_vxcf."_mzdprnahset WHERE ucm > 0 AND ucd > 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {

if (@$zaznam=mysql_data_seek($sql,$i)) { 

$polozka=mysql_fetch_object($sql); 

//ume  dat  dok  poh  cpl  ucm  ucd  rdp  dph  hod  ico  fak  pop  str  zak  unk  id  datm  
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprnahdelene".
" SELECT ume,dat,oc,0,0,$polozka->ucm,$polozka->ucd,0,0,kc,0,0,'',0,0,'',$kli_uzid,now() ".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE dm = $polozka->ucm AND ume = $polozka->ume ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

                                       }

$i=$i+1;                   }


               }


$h_ycf=0;
if ( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");

$kli_mrok=$kli_vrok-1;
$umeminul="12.".$kli_mrok;
$sqltt = "SELECT * FROM F".$kli_vxcf."_mzdprnahset WHERE ume <= $umeminul AND ucm > 0 AND ucd > 0";
$pol=0;
$sql = mysql_query("$sqltt");
if( $sql ) { $pol = mysql_num_rows($sql); }
if( $pol > 0 ) {
//echo "nacitaj deleny";

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprnahdelene  WHERE ( ume = 01.$kli_mrok OR ume = 02.$kli_mrok OR ume = 03.$kli_mrok ".
" OR ume = 04.$kli_mrok OR ume = 05.$kli_mrok OR ume = 06.$kli_mrok OR ume = 07.$kli_mrok OR ume = 08.$kli_mrok OR ume = 09.$kli_mrok".
" OR ume = 10.$kli_mrok OR ume = 11.$kli_mrok OR ume = 12.$kli_mrok )";
$dsql = mysql_query("$dsqlt");

$sqltt = "SELECT * FROM F".$kli_vxcf."_mzdprnahset WHERE ucm > 0 AND ucd > 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {

if (@$zaznam=mysql_data_seek($sql,$i)) { 

$polozka=mysql_fetch_object($sql); 

//ume  dat  dok  poh  cpl  ucm  ucd  rdp  dph  hod  ico  fak  pop  str  zak  unk  id  datm  
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprnahdelene".
" SELECT ume,dat,oc,0,0,$polozka->ucm,$polozka->ucd,0,0,kc,0,0,'',0,0,'',$kli_uzid,now() ".
" FROM ".$databaza."F$h_ycf"."_mzdzalvy".
" WHERE dm = $polozka->ucm AND ume = $polozka->ume ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

                                       }

$i=$i+1;                   }


               }

//exit;

?>
<script type="text/javascript">

window.open('../ucto/oprsys.php?copern=308&drupoh=46&page=1&sysx=UCT', '_self' );
  
</script>
<?php
}
//koniec naciatania delitelnej casti

//pre vypocet vytvor pracovny subor
if( $copern == 10 OR $copern == 20 OR $copern == 30 )
{

//prac.subor
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   pomx         INT(7) DEFAULT 0,
   dohx         INT(7) DEFAULT 0,
   dmx          INT(7) DEFAULT 0,
   dni          DECIMAL(10,2) DEFAULT 0,
   hod          DECIMAL(10,2) DEFAULT 0,
   kc           DECIMAL(10,2) DEFAULT 0,
   prnx         INT(7) DEFAULT 0,
   hodx         INT(7) DEFAULT 0,
   priemer      DECIMAL(10,4) DEFAULT 0,
   kc107        DECIMAL(10,2) DEFAULT 0,
   kc510        DECIMAL(10,2) DEFAULT 0,
   hd510        DECIMAL(10,2) DEFAULT 0,
   konxx        DECIMAL(10,0) DEFAULT 0,
   konx1        DECIMAL(10,0) DEFAULT 0,
   konx2        DECIMAL(10,0) DEFAULT 0,
   hddx         DECIMAL(10,2) DEFAULT 0,
   hddx1         DECIMAL(10,4) DEFAULT 0,
   hddx2         DECIMAL(10,2) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid.$sqlt;
//$vytvor = mysql_query("$vsql");


//zober kc zloziek mzdy z mzdzalvy
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,vpom,0,".
" dm,dni,hod,kc,0,0,0,".
"0,0,0,".
"0,0,0,0,0,0".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume >= $umep AND ume <= $umek AND ( ( dm > 0 AND dm < 500 ) OR dm = 510 OR dm = 517 )  ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln z dmn 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzddmn SET ".
" prnx=prn, hodx=ho".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.dmx=F$kli_vxcf"."_mzddmn.dm";
$oznac = mysql_query("$sqtoz");

//dopln z pomer 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdpomer SET ".
" dohx=pm_doh".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.pomx=F$kli_vxcf"."_mzdpomer.pm";
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE prnx = 0 AND dmx != 510 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET ".
" hod=0".
" WHERE hodx = 0 AND dmx != 510 ";
$oznac = mysql_query("$sqtoz");

//ak ma dm 101,107 tak sa pripocita aj dm 510 hodiny aj kc len pre ekorobot
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET ".
" kc107=kc".
" WHERE dmx = 107 OR dmx = 101";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET ".
" kc510=kc, hd510=hod, kc=0, hod=0".
" WHERE dmx = 510";
$oznac = mysql_query("$sqtoz");

//deleny prijem
$sqltt = "SELECT * FROM F".$kli_vxcf."_mzdprnahdelene WHERE hod > 0 ";
$pol=0;
$sql = mysql_query("$sqltt");
if( $sql ) { $pol = mysql_num_rows($sql); }
if( $pol > 0 ) {
//echo "mame deleny";

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT dok,0,0,".
" ucm,0,0,0,0,0,0,".
"0,0,0,".
"0,0,0,(F$kli_vxcf"."_mzdprnahdelene.hod/ucd),0,0".
" FROM F$kli_vxcf"."_mzdprnahdelene".
" WHERE F$kli_vxcf"."_mzdprnahdelene.hod > 0 AND ucd > 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;
               }
//koniec deleny prijem


//sumarizuj za oc
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,pomx,0,".
" dmx,dni,SUM(hod),SUM(kc),0,0,0,".
"SUM(kc107),SUM(kc510),SUM(hd510),".
"999,0,0,SUM(hddx),0,0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE dohx = 0 ".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln uvazok z kun do hddx2
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdkun SET ".
" hddx2=uva".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc=F$kli_vxcf"."_mzdkun.oc";
$oznac = mysql_query("$sqtoz");

//koeficient na deleny prijem
if( $cislo_oc == 1 ) { $fondpracdobydni=62; }
if( $cislo_oc == 2 ) { $fondpracdobydni=61; }
if( $cislo_oc == 3 ) { $fondpracdobydni=64; }
if( $cislo_oc == 4 ) { $fondpracdobydni=66; }

if( $kli_vrok == 2010 ) {
if( $cislo_oc == 1 ) { $fondpracdobydni=64; }
if( $cislo_oc == 2 ) { $fondpracdobydni=65; }
if( $cislo_oc == 3 ) { $fondpracdobydni=66; }
if( $cislo_oc == 4 ) { $fondpracdobydni=66; }
                        }

if( $kli_vrok == 2011 ) {
if( $cislo_oc == 1 ) { $fondpracdobydni=64; }
if( $cislo_oc == 2 ) { $fondpracdobydni=65; }
if( $cislo_oc == 3 ) { $fondpracdobydni=66; }
if( $cislo_oc == 4 ) { $fondpracdobydni=65; }
                        }

if( $kli_vrok == 2012 ) {
if( $cislo_oc == 1 ) { $fondpracdobydni=65; }
if( $cislo_oc == 2 ) { $fondpracdobydni=65; }
if( $cislo_oc == 3 ) { $fondpracdobydni=65; }
if( $cislo_oc == 4 ) { $fondpracdobydni=66; }
                        }

if( $kli_vrok > 2012 ) {

if( $cislo_oc == 1 ) { $datpp=$kli_vrok."-01-01";  $datkk=$kli_vrok."-03-31"; }
if( $cislo_oc == 2 ) { $datpp=$kli_vrok."-04-01";  $datkk=$kli_vrok."-06-30"; }
if( $cislo_oc == 3 ) { $datpp=$kli_vrok."-07-01";  $datkk=$kli_vrok."-09-30"; }
if( $cislo_oc == 4 ) { $datpp=$kli_vrok."-10-01";  $datkk=$kli_vrok."-12-31"; }

$fondpracdobydni=65;
$sqltt = "SELECT * FROM kalendar WHERE dat >= '$datpp' AND dat <= '$datkk' AND akyden < 6 ";
$sql = mysql_query("$sqltt");
if( $sql ) { $fondpracdobydni = 1*mysql_num_rows($sql); }

                        }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET hddx1=hod/($fondpracdobydni*hddx2) WHERE hddx2 > 0";
$oznac = mysql_query("$sqtoz");

//exit;

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET hddx1=1 WHERE hddx1 <= 0 OR hddx1 > 1";
$oznac = mysql_query("$sqtoz");


if( $agrostav == 0 AND $alchem == 0 AND $medo == 0 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET ".
" kc=kc+kc510, hod=hod+hd510 ".
" WHERE kc107 > 0 ";
$oznac = mysql_query("$sqtoz");
}


$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konxx = 0";
$oznac = mysql_query("$sqtoz");

//exit;

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET ".
" priemer=(kc+(hddx1*hddx))/hod".
" WHERE hod > 0";
$oznac = mysql_query("$sqtoz");

if( $nastav == 1 )
{
//nastav do mzdkun
$sqtoz = "UPDATE F$kli_vxcf"."_mzdkun,F$kli_vxcf"."_mzdprcvypl$kli_uzid SET ".
" znah=priemer".
" WHERE F$kli_vxcf"."_mzdkun.oc=F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc";
$oznac = mysql_query("$sqtoz");
}

}
//koniec pracovneho suboru 


/////////////////////////////////////////////////VYTLAC PRIEMERY NA NAHRADY
if( $copern == 10 )
{

$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/priemery_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/priemery_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc > 0 ORDER BY F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc";


$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
$pocpol=$tvpol-1;
//exit;

$strana=0;
$j=0;           
$i=0;
$pcislo=1;
  while ($i <= $pocpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

$zzam_zp=$rtov->zzam_zp;
if( $rtov->zzam_zp == 0 ) $zzam_zp="";

$hddx=$rtov->hddx;
if( $rtov->hddx == 0 ) $hddx="";

//hlavicka strany
if ( $j == 0 )
     {

$strana=$strana+1;
$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$pdf->SetFont('arial','',10);
$pdf->Cell(90,6,"Priemery na n·hrady miezd za $cislo_oc.ötvrùrok $kli_vrok","LTB",0,"L");
$pdf->Cell(90,6,"$kli_nxcf strana $strana","RTB",1,"R");


$pdf->Cell(60,5,"OsË. Priezvisko,meno ","1",0,"L");$pdf->Cell(30,5,"Z·klad Ä","1",0,"R");
$pdf->Cell(30,5,"Delen˝ prÌjem Ä","1",0,"R");
$pdf->Cell(30,5,"Hodiny","1",0,"R");
$pdf->Cell(30,5,"Priemer Ä/hod.","1",1,"R");

     }
//koniec hlavicky j=0



$pdf->Cell(60,5,"$rtov->oc $rtov->prie $rtov->meno ","0",0,"L");$pdf->Cell(30,5,"$rtov->kc","0",0,"R");$pdf->Cell(30,5,"$hddx","0",0,"R");
$pdf->Cell(30,5,"$rtov->hod","0",0,"R");$pdf->Cell(30,5,"$rtov->priemer","0",1,"R");


}
$i = $i + 1;
$j = $j + 1;
$pcislo=$pcislo+1;

if( $j >= 45 ) $j=0;

  }


$pdf->Output("$outfilex");


?>

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>


<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA PRIEMEROV NA NAHRADY copern=10



?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>V˝poËet priemerov</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;


function TlacPrnah()
                {
var h_oc = document.forms.formp1.h_oc.value;
var nastav = document.forms.formp1.nastav.value;

window.open('../mzdy/priemery.php?cislo_oc=' + h_oc + '&nastav=' + nastav + '&copern=10&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacPrnem()
                {

var nastav = document.forms.formp2.nastav.value;

window.open('../mzdy/priemery_nemoc.php?nastav=' + nastav + '&copern=10&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function SetPrnah()
                {

var nastav = document.forms.formp2.nastav.value;

window.open('../ucto/oprsys.php?copern=308&drupoh=45&page=1&sysx=UCT',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DajPrnah()
                {

window.open('../mzdy/priemery.php?copern=1001&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function EditPrnah()
                {

window.open('../ucto/oprsys.php?copern=308&drupoh=46&page=1&sysx=UCT',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }
   
</script>
</HEAD>
<BODY class="white" id="white" onload="" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  V˝poËet priemerov zamestnancov

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//zakladna ponuka
if( $copern == 1 )
{
?>

<table class="vstup" width="100%" >
<FORM name="formp1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPrnah();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VypoËÌtaù priemery' ></a>
</td>
<td class="bmenu" width="86%">
<select size="1" name="h_oc" id="h_oc" >
<option value="1" >za 1.ötvrùrok</option>
<option value="2" >za 2.ötvrùrok</option>
<option value="3" >za 3.ötvrùrok</option>
<option value="4" >za 4.ötvrùrok</option>
</select>
 Priemery na n·hrady mzdy 
<select size="1" name="nastav" id="nastav" >
<option value="0" >nenastaviù do kmeÚov˝ch ˙dajov</option>
<option value="1" >nastaviù do kmeÚov˝ch ˙dajov</option>
</select>
</td>
<td class="bmenu" width="12%" align="right">
<a href="#" onClick="SetPrnah();">
<img src='../obr/naradie.png' width=20 height=15 border=1 title='Nastavenie deliteæn˝ch ËastÌ priemerov na n·hrady' ></a>
<a href="#" onClick="DajPrnah();">
<img src='../obr/vlozit.png' width=20 height=15 border=1 title='NaËÌtanie deliteæn˝ch ËastÌ priemerov na n·hrady' ></a>
<a href="#" onClick="EditPrnah();">
<img src='../obr/uprav.png' width=20 height=15 border=1 title='⁄prava deliteæn˝ch ËastÌ priemerov na n·hrady' ></a>
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formp2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPrnem();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VypoËÌtaù priemery' ></a>
</td>
<td class="bmenu" width="98%">
 Priemery na n·hrady prÌjmu pri doËasnej pracovnej neschopnosti
<select size="1" name="nastav" id="nastav" >
<option value="0" >nenastaviù do kmeÚov˝ch ˙dajov</option>
<option value="1" >nastaviù do kmeÚov˝ch ˙dajov</option>
</select>
</td>
</tr>
</FORM>
</table>

<?php
}
//koniec zakladnej ponuky
?>



<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu

$cislista = include("mzd_lista.php");

       } while (false);
?>
</BODY>
</HTML>
