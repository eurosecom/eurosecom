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
$keyf=$poleu[8];

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

$newfntz=1*$_REQUEST['newfntz'];
if( $newfntz == 1 )
  {
$dajidk=0;
$sqldok = mysql_query("SELECT * FROM ".$databazaez."idxklizuid WHERE idxx = '".$keyf."' ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $dajidk=$riaddok->kliuzid;
    }
$kli_uzid=$dajidk;

//$kli_uzid=17;

require_once("../androidfantozzi/setpdf_charset.php");
//pdf »åºæöËùû˝·Ì
  }

if( $kli_uzid == 0 ) { exit; }

$_REQUEST['h_obdp'] = 1;
$_REQUEST['h_obdk'] = 12;
$kli_vume=$_REQUEST['kli_vume'];
$copern = $_REQUEST['copern'];
$typ = "PDF";
  }
//koniec zandroidu=1

if( $zandroidu == 0 )
  {
$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];
$typ = $_REQUEST['typ'];
$cslm=100020;
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

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


$cit_nas = include("../cis/citaj_nas.php");
$cit_fir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;


$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/udenn_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/udenn_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcudenniks'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcudenniksx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcudenniks
(
   psys         INT,
   uro          INT(8),
   cpl          int not null auto_increment,
   ume          FLOAT(8,4),
   dat          DATE,
   dok          INT(8),
   ucm          VARCHAR(10),
   ucd          VARCHAR(10),
   rdp          INT(2),
   ico          INT(10),
   fak          DECIMAL(10,0),
   str          INT,
   zak          INT,
   hod          DECIMAL(12,2),
   pop          VARCHAR(80),
   pox          INT(10),
   PRIMARY KEY(cpl)
);
prcudenniks;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcudenniks'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcudenniksx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcudenniksy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$dat_poc=$kli_vrok."-01-01";
$ume_poc="01.".$kli_vrok;

$psys=1;
 while ($psys <= 9 ) 
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
//zober majetok
if( $psys == 7 ) { $uctovanie="uctmaj"; }
//zober majetok
if( $psys == 8 ) { $uctovanie="uctskl"; }
//zober mzdy
if( $psys == 9 ) { $uctovanie="uctmzd"; }

if( $psys <= 6 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcudenniks$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,F$kli_vxcf"."_$uctovanie.dok,ucm,ucd,rdp,F$kli_vxcf"."_$uctovanie.ico,".
"F$kli_vxcf"."_$uctovanie.fak,F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak,F$kli_vxcf"."_$uctovanie.hod,CONCAT(txp, ' ', pop),1".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ( ucm > 0 OR ucd > 0 ) AND ume = $kli_vume".
" ORDER BY F$kli_vxcf"."_$doklad.dok";
$dsql = mysql_query("$dsqlt");
}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcudenniks$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,dok,ucm,ucd,rdp,ico,".
"fak,str,zak,hod,pop,1".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE ume = $kli_vume";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>⁄Ëtovn˝ dennÌk</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    
</script>
</HEAD>
<BODY class="white" >

<?php if( $zandroidu == 1 ) 
    { 
?> 
<table class="h2" width="100%" >
<tr>
<td>Zostava PDF prebran·, tlaËidlo Sp‰ù - do ˙Ëtovn˝ch zost·v </td>
<td align="right"> </td>
</tr>
</table>
<?php 
    } 
?> 

<?php
if( $typ == 'HTML' )
{
//#252,170,18
?>
<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  ⁄Ëtovn˝ dennÌk PU
  <a href="#" onClick="window.open('../ucto/udennik.php?copern=10&drupoh=1&page=1&typ=PDF', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='VytlaËiù vo form·te PDF' ></a>

 <a href="#" onClick="window.open('../ucto/udennik.php?copern=10&drupoh=1&page=1&typ=HTML', '_self' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 alt='PrepoËet po ˙prav·ch dennÌka' ></a>
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
<?php
}
?>

<?php
//suma za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcudenniks$kli_uzid "." SELECT".
" psys,999,0,ume,dat,dok,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),pop,999".
" FROM F$kli_vxcf"."_prcudenniks$kli_uzid".
" WHERE cpl >= 0".
" GROUP BY pox".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//vloz pre ocislovanie poloziek
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcudenniksx$kli_uzid"." SELECT".
" psys,uro,0,ume,dat,dok,ucm,ucd,rdp,ico,fak,str,zak,hod,pop,pox".
" FROM F$kli_vxcf"."_prcudenniks$kli_uzid".
" WHERE ume <= $kli_vume";
" ORDER BY uro,dok,ucm,ucd,hod";
$dsql = mysql_query("$dsqlt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcudenniksx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcudenniksx$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_uctdrdp".
" ON F$kli_vxcf"."_prcudenniksx$kli_uzid".".rdp=F$kli_vxcf"."_uctdrdp.rdp".
" WHERE cpl > 0 ";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

//sumare napocet
$hod = 0.00;

$strana=1;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$k=0; //zaciatok dennika nedaj prevedene
$par=0; //parne nedam biele ale sede
  while ($i <= $pol )
  {

if ( $j == 0 )
      {

if( $typ == 'PDF' )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

$pdf->Cell(110,5,"⁄Ëtovn˝ dennÌk za $kli_vume","LTB",0,"L");
$pdf->Cell(167,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");


$pdf->Cell(15,4,"Poloûka","1",0,"R");$pdf->Cell(15,4,"⁄Ë.mes.","1",0,"R");$pdf->Cell(19,4,"D·tum","1",0,"R");$pdf->Cell(19,4,"Doklad","1",0,"R");
$pdf->Cell(19,4,"M·Daù","1",0,"R");$pdf->Cell(19,4,"Dal","1",0,"R");;$pdf->Cell(10,4,"DRD","1",0,"R");
$pdf->Cell(17,4,"I»O","1",0,"R");$pdf->Cell(20,4,"Fakt˙ra","1",0,"R");$pdf->Cell(15,4,"STR","1",0,"R");$pdf->Cell(15,4,"Z¡K","1",0,"R");

$pdf->Cell(25,4,"Suma","1",0,"R");$pdf->Cell(0,4,"Popis","1",1,"L");

}


if( $typ == 'HTML' )
{
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" colspan="7"><?php echo "⁄Ëtovn˝ dennÌk za $kli_vume"; ?></td>
<td class="bmenu" colspan="6" align="right"><?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?></td>
</tr>

<tr>
<td class="bmenu" width="5%">Poloûka</td>
<td class="bmenu" width="5%">⁄Ë.mes.</td>
<td class="bmenu" width="6%">D·tum</td>
<td class="bmenu" width="10%">Doklad</td>

<td class="hvstup_zlte" width="6%">M·Daù</td>
<td class="hvstup_zlte" width="6%">Dal</td>

<td class="bmenu" width="4%">DRD</td>
<td class="bmenu" width="6%">I»O</td>
<td class="bmenu" width="6%">FAK</td>
<td class="bmenu" width="6%">STR</td>
<td class="bmenu" width="6%">Z¡K</td>

<td class="hvstup_zlte" width="6%" align="right">Suma</td>
<td class="bmenu" width="28%">Popis</td>
</tr>

<?php
}

$str_hod = 0.00;

      }
//koniec j=0

//html nestrankuj
if( $typ == 'HTML' ) $j=1;

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);

//ak je nulova polozka daj medzeru

$h_hod=$polozka->hod;
if( $polozka->hod == 0 ) $h_hod="";

//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $polozka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);

//sumare napocet
$hod = $hod + $polozka->hod;
$Cislo=$hod+"";
$shod=sprintf("%0.2f", $Cislo);


$str_hod = $str_hod + $polozka->hod;
$str_Cislo=$str_hod+"";
$str_shod=sprintf("%0.2f", $str_Cislo);



if( $typ == 'PDF' )
{
if( $polozka->uro == 1 )
  {

$pdf->Cell(15,4,"$polozka->cpl","0",0,"R");$pdf->Cell(15,4,"$polozka->ume","0",0,"R");$pdf->Cell(19,4,"$datsk","0",0,"R");
$pdf->Cell(19,4,"$polozka->dok","0",0,"R");
$pdf->Cell(19,4,"$polozka->ucm","0",0,"R");$pdf->Cell(19,4,"$polozka->ucd","0",0,"R");;$pdf->Cell(10,4,"$polozka->rdp","0",0,"R");
$pdf->Cell(17,4,"$polozka->ico","0",0,"R");$pdf->Cell(20,4,"$polozka->fak","0",0,"R");
$pdf->Cell(15,4,"$polozka->str","0",0,"R");$pdf->Cell(15,4,"$polozka->zak","0",0,"R");
$pdf->Cell(25,4,"$polozka->hod","0",0,"R");$pdf->Cell(0,4,"$polozka->pop","0",1,"L");
  }

if( $polozka->uro == 999 )
  {
//tlac sumare
$pdf->Cell(155,5," ","1",0,"R");
$pdf->Cell(30,5,"Spolu celkom","1",0,"L");
$pdf->Cell(25,5,"$polozka->hod","1",0,"R"); 
$pdf->Cell(0,5," ","1",1,"L"); 
  }
}

if( $typ == 'HTML' )
{
$hvstup="hvstup";
if( $par == 1 ) { $hvstup="hvstup_bsede"; }
if( $polozka->uro == 1 )
  {
?>

<tr>
<td class="<?php echo $hvstup; ?>"><?php echo $polozka->cpl; ?></td>
<td class="<?php echo $hvstup; ?>"><?php echo $polozka->ume; ?></td>
<td class="<?php echo $hvstup; ?>"><?php echo $datsk; ?></td>
<td class="<?php echo $hvstup; ?>">

<?php if( $polozka->psys == 1 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranÈho pokladniËnÈho prÌjmovÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranÈho pokladniËnÈho prÌjmovÈho dokladu" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 2 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranÈho pokladniËnÈho v˝davkovÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranÈho pokladniËnÈho v˝davkovÈho dokladu" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 3 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=4&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranÈho bankovÈho v˝pisu " ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=4&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranÈho bankovÈho v˝pisu " ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 4 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=5&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranÈho vöeobecnÈho ˙ËtovnÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=5&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranÈho vöeobecnÈho ˙ËtovnÈho dokladu" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 5 )
  { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranej odberateæskej fakt˙ry" ></a>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=NIE&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranej odberateæskej fakt˙ry" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 6 )
  { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranej dod·vateæskej fakt˙ry" ></a>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=NIE&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranej dod·vateæskej fakt˙ry" ></a>
<?php 
  } ?>


<?php echo $polozka->dok;?>
</td>

<td class="hvstup_zlte">
<?php echo $polozka->ucm; ?>
</td>
<td class="hvstup_zlte">
<?php echo $polozka->ucd; ?>
</td>

<td class="<?php echo $hvstup; ?>"><?php echo $polozka->rdp; ?></td>
<td class="<?php echo $hvstup; ?>"><?php echo $polozka->ico; ?></td>
<td class="<?php echo $hvstup; ?>"><?php echo $polozka->fak; ?></td>
<td class="<?php echo $hvstup; ?>"><?php echo $polozka->str; ?></td>
<td class="<?php echo $hvstup; ?>"><?php echo $polozka->zak; ?></td>

<td class="hvstup_zlte" align="right"><?php echo $h_hod; ?></td>
<td class="<?php echo $hvstup; ?>"><?php echo $polozka->pop; ?></td>
</tr>

<?php
//koniec ak uro=1
  }

if( $polozka->uro == 999 )
  {
?>

<tr>
<td class="bmenu" colspan="9"></td>

<td class="hvstup_tzlte" align="right" colspan="2">Celkom</td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->hod; ?></td>

</tr>

</table>

<?php
//koniec ak uro=999
  }

//koniec verzia html
}


}
$i = $i + 1;
$j = $j + 1;

if( $par == 0 )
{
$par=1;
}
else
{
$par=0;
}

//koniec stranky
if( $j == 40 )
      {
$strana=$strana+1;
$j=0;
      }
//koniec bloku na koniec stranky


  }
//koniec polozky


if( $typ == 'PDF' )
{

$pdf->Output("$outfilex");

?> 
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<?php
}


if( $typ == 'HTML' )
{
?>


<?php
}

?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcudenniks'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcudenniksx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
