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
//pdf ÈŒ¼¾šèžýáí
  }

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

$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];
$typ = $_REQUEST['typ'];

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

$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/jukniha_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/jukniha_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$vyb_ume=$kli_vume;
$vyb_umep=$kli_vume;
$vyb_umek=$kli_vume;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$h_obdp=$kli_vmes;
$h_obdk=$kli_vmes;

if( $copern == 11 )
{
$h_obdp = 1*$_REQUEST['h_obdp'];
$h_obdk = 1*$_REQUEST['h_obdk'];
if( $h_obdp == 0 ) $h_obdp=1;
if( $h_obdk == 0 ) $h_obdk=12;
$vyb_ume=$h_obdk.".".$kli_vrok;
$vyb_umep=$h_obdp.".".$kli_vrok;
$vyb_umek=$h_obdk.".".$kli_vrok;
$copern=$copern-1;
}
$prac_subor = include("prac_jukniha.php");

//urob pracovny pre sumarnu knihu
if( $drupoh == 2 )
{

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihasxx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prchlknihas
(
   psys         INT,
   uro          INT(8),
   cpl          int not null auto_increment,
   ume          FLOAT(8,4),
   dat          DATE,
   dok          INT(8),
   uce          VARCHAR(10),
   ur1          INT(10),
   puc          VARCHAR(10),
   ucm          VARCHAR(10),
   ucd          VARCHAR(10),
   rdp          INT(2),
   ico          INT(10),
   fak          INT(10),
   str          INT,
   zak          INT,
   hod          DECIMAL(10,2),
   mdt          DECIMAL(10,2),
   dal          DECIMAL(10,2),
   zos          DECIMAL(10,2),
   pop          VARCHAR(80),
   pox          INT(10),
   pmdt          DECIMAL(10,2),
   pdal          DECIMAL(10,2),
   omdt          DECIMAL(10,2),
   odal          DECIMAL(10,2),
   zmdt          DECIMAL(10,2),
   zdal          DECIMAL(10,2),
   PRIMARY KEY(cpl)
);
prchlknihas;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prchlknihasxx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihasxx$kli_uzid"." SELECT".
" psys,uro,0,ume,dat,dok,1*uce,ur1,1*uce,1*ucm,1*ucd,rdp,ico,fak,str,zak,hod,mdt,dal,zos,pop,pox,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_prchlknihasx$kli_uzid".
" WHERE uro >= 0 ".
" ORDER BY uce";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prchlknihasxx$kli_uzid SET pmdt=mdt, pdal=dal WHERE uro = 1 AND ur1 = 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prchlknihasxx$kli_uzid SET omdt=mdt, odal=dal WHERE uro = 1 AND ur1 = 1 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prchlknihasxx$kli_uzid SET zmdt=mdt, zdal=dal WHERE ur1 = 999 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihasxx$kli_uzid "." SELECT".
" psys,777,0,$vyb_ume,dat,dok,uce,0,puc,ucm,ucd,rdp,0,0,0,0,0,SUM(mdt),SUM(dal),0,'',1,".
"SUM(pmdt),SUM(pdal),SUM(omdt),SUM(odal),SUM(zmdt),SUM(zdal)".
" FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid".
" WHERE cpl >= 0 ".
" GROUP BY uce".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid WHERE uro != 777 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prchlknihasxx$kli_uzid SET hod=pmdt-pdal, zos=zmdt-zdal WHERE uro >= 777 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_prchlknihasxx$kli_uzid SET pmdt=hod, pdal=0 WHERE uro >= 777 AND hod >= 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_prchlknihasxx$kli_uzid SET zmdt=zos, zdal=0 WHERE uro >= 777 AND zos >= 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_prchlknihasxx$kli_uzid SET pdal=-hod, pmdt=0 WHERE uro >= 777 AND hod < 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_prchlknihasxx$kli_uzid SET zdal=-zos, zmdt=0 WHERE uro >= 777 AND zos < 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihasxx$kli_uzid "." SELECT".
" psys,778,0,$vyb_ume,dat,0,uce,0,0,ucm,ucd,rdp,0,0,0,0,0,SUM(mdt),SUM(dal),0,'',1,".
"SUM(pmdt),SUM(pdal),SUM(omdt),SUM(odal),SUM(zmdt),SUM(zdal)".
" FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid".
" WHERE cpl >= 0 ".
" GROUP BY uro".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}
//koniec pracovneho pre sumarnu

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Úètovné pohyby</title>
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
<?php
if( $typ == 'PDF' )
{
?>
<table class="h2" width="100%" >
<tr>
<td>
<?php if( $zandroidu == 1 ) { echo "Zostava PDF prebraná, tlaèidlo Spä - do úètovných zostáv"; } ?> 
</td>
</tr>
</table>
<br />
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
<td>
<?php if( $zandroidu == 0 ) 
{ 
if( $drupoh == 1 ) { echo "EuroSecom  -  Úètovné pohyby - položkovité JU"; } 
if( $drupoh == 2 ) { echo "EuroSecom  -  Úètovné pohyby - sumárne JU"; } 
} ?> 
  <a href="#" onClick="window.open('../ucto/juknihapoh.php?copern=11&drupoh=<?php echo $drupoh;?>&page=1&typ=PDF&h_obdp=<?php echo $h_obdp;?>
&h_obdk=<?php echo $h_obdk;?>', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>

 <a href="#" onClick="window.open('../ucto/juknihapoh.php?copern=11&drupoh=<?php echo $drupoh;?>&page=1&typ=HTML&h_obdk=<?php echo $h_obdk;?>', '_self' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 alt='Prepoèet po úpravách' ></a>
</td>
<td align="right">
<?php
$prev_obdk=$h_obdk-1; $next_obdk=$h_obdk+1;
if( $prev_obdk == 0 ) { $prev_obdk=12; }
if( $next_obdk == 13 ) { $next_obdk=1; }
$coperp=$copern+1;
      if( $copern == 30 OR $copern == 20 OR $copern == 10 ) { ?>
<a href="#" onClick="window.open('../ucto/juknihapoh.php?copern=<?php echo $coperp;?>&drupoh=<?php echo $drupoh;?>&h_obdk=<?php echo $prev_obdk;?>
&h_obdp=<?php echo $prev_obdk;?>&page=1&typ=HTML', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 alt='Obdobie <?php echo $prev_obdk.".".$kli_vrok; ?>' ></a>
<a href="#" onClick="window.open('../ucto/juknihapoh.php?copern=<?php echo $coperp;?>&drupoh=<?php echo $drupoh;?>&h_obdk=<?php echo $next_obdk;?>
&h_obdp=<?php echo $next_obdk;?>&page=1&typ=HTML', '_self' )">
<img src='../obr/next.png' width=10 height=10 border=0 alt='Obdobie <?php echo $next_obdk.".".$kli_vrok; ?>' ></a>
<?php                                                       } ?>
<span class="login"><?php echo "UME $vyb_ume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
<?php
}
?>

<?php


if( $drupoh == 2 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prchlknihasxx$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_uctdrdp".
" ON F$kli_vxcf"."_prchlknihasxx$kli_uzid".".rdp=F$kli_vxcf"."_uctdrdp.rdp".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prchlknihasxx$kli_uzid".".uce=F$kli_vxcf"."_uctosnova.uce".
" WHERE cpl > 0 ".
" ORDER BY uro,F$kli_vxcf"."_prchlknihasxx$kli_uzid.uce";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
}

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


if( $typ == 'PDF' AND $drupoh == 2 )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

$pdf->Cell(110,5,"Úètovné pohyby za $vyb_umep / $vyb_umek","LTB",0,"L");
$pdf->Cell(100,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(210,4,"Úèet Popis","1",1,"L");
$pdf->Cell(35,4,"Prenos Výdavok","1",0,"R");$pdf->Cell(35,4,"Prenos Príjem","1",0,"R");
$pdf->Cell(35,4,"Obraty Výdavok","1",0,"R");$pdf->Cell(35,4,"Obraty Príjem","1",0,"R");
$pdf->Cell(35,4,"Zostatok Výdavok","1",0,"R");$pdf->Cell(35,4,"Zostatok Príjem","1",1,"R");

}
//koniec PDF a $drupoh 1

if( $typ == 'HTML' AND $drupoh == 2 )
{
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" colspan="3"><?php echo "Úètovné pohyby za $vyb_umep / $vyb_umek"; ?></td>
<td class="bmenu" colspan="3" align="right"><?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?></td>
</tr>

<tr><td class="bmenu" colspan="1">Úèet</td><td class="bmenu" colspan="5">Názov úètu</td></tr>

<td class="bmenu" width="15%" align="right">Poèiatok Výdavok</td>
<td class="bmenu" width="15%" align="right">Poèiatok Príjem</td>

<td class="bmenu" width="20%" align="right">Obraty Výdavok</td>
<td class="bmenu" width="20%" align="right">Obraty Príjem</td>

<td class="bmenu" width="15%" align="right">Zostatok Výdavok</td>
<td class="bmenu" width="15%" align="right">Zostatok Príjem</td>
</tr>

<?php
}
//koniec html a drupoh 2


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



if( $typ == 'PDF' AND $drupoh == 2 )
         {
if( $polozka->uro == 777 )
   {
$pdf->Cell(210,5,"$polozka->puc $polozka->nuc ","0",1,"L");
$pdf->Cell(35,5,"$polozka->pmdt","0",0,"R");$pdf->Cell(35,5,"$polozka->pdal","0",0,"R"); 
$pdf->Cell(35,5,"$polozka->omdt","0",0,"R");$pdf->Cell(35,5,"$polozka->odal","0",0,"R");
$pdf->Cell(35,5,"$polozka->zmdt","0",0,"R");$pdf->Cell(35,5,"$polozka->zdal","0",1,"R");
   }
if( $polozka->uro == 778 )
   {
$pdf->Cell(210,5,"CELKOM","T",1,"L");
$pdf->Cell(35,5,"$polozka->pmdt","B",0,"R");$pdf->Cell(35,5,"$polozka->pdal","B",0,"R"); 
$pdf->Cell(35,5,"$polozka->omdt","B",0,"R");$pdf->Cell(35,5,"$polozka->odal","B",0,"R");
$pdf->Cell(35,5,"$polozka->zmdt","B",0,"R");$pdf->Cell(35,5,"$polozka->zdal","B",1,"R");
   }
         }
//koniec PDF a drupoh 2



if( $typ == 'HTML' AND $drupoh == 2 )
     {
$hvstup="hvstup";
if( $par == 1 ) { $hvstup="hvstup_bsede"; }
?>


<?php
if( $polozka->uro == 777 )
   {
?>
<tr>
<td class="hvstup_zlte" colspan="4">
<a href="#" onClick="window.open('zosuce_ju.php?copern=31&drupoh=<?php echo $drupoh;?>&h_obdk=<?php echo $h_obdk;?>&page=1&typ=HTML&cislo_uce=<?php echo $polozka->uce;?>', '_blank', 
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<?php echo $polozka->puc; ?> </a> <?php echo $polozka->nuc; ?> </td>
<td class="hvstup_zlte" colspan="2">
ÈRVPV=<?php echo $polozka->crv; ?> ÈRVMZ=<?php echo $polozka->crs; ?></td>
</tr>

<tr>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->pmdt; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->pdal; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->omdt; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->odal; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->zmdt; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->zdal; ?></td>
</tr>
<?php
   }
?>

<?php
if( $polozka->uro == 778 )
   {
?>
<tr>
<td class="bmenu" colspan="6">CELKOM</td>
</tr>

<tr>
<td class="bmenu" align="right"><?php echo $polozka->pmdt; ?></td>
<td class="bmenu" align="right"><?php echo $polozka->pdal; ?></td>
<td class="bmenu" align="right"><?php echo $polozka->omdt; ?></td>
<td class="bmenu" align="right"><?php echo $polozka->odal; ?></td>
<td class="bmenu" align="right"><?php echo $polozka->zmdt; ?></td>
<td class="bmenu" align="right"><?php echo $polozka->zdal; ?></td>
</tr>
<?php
   }
?>

<?php

//koniec html AND drupoh == 2 
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
if( $j == 34 AND $drupoh == 1 )
      {
$strana=$strana+1;
$j=0;
      }
if( $j == 16 AND $drupoh == 2 )
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
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihas'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihasx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihasxx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
