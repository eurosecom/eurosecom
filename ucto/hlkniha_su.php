<HTML>
<?php

do
{
//hl.kniha sumarna za synteticke ucty

$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];
$typ = $_REQUEST['typ'];

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

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


$cit_nas = include("../cis/citaj_nas.php");
$cit_fir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;
if (File_Exists ("../tmp/hlkniha.$kli_uzid.pdf")) { $soubor = unlink("../tmp/hlkniha.$kli_uzid.pdf"); }

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
$prac_subor = include("prac_hlkniha.php");

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
   fak          DECIMAL(10,0),
   str          INT,
   zak          INT,
   hod          DECIMAL(10,2),
   mdt          DECIMAL(12,2),
   dal          DECIMAL(12,2),
   zos          DECIMAL(12,2),
   pop          VARCHAR(80),
   pox          INT(10),
   pmdt          DECIMAL(12,2),
   pdal          DECIMAL(12,2),
   omdt          DECIMAL(12,2),
   odal          DECIMAL(12,2),
   zmdt          DECIMAL(12,2),
   zdal          DECIMAL(12,2),
   PRIMARY KEY(cpl)
);
prchlknihas;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prchlknihasxx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihasxx$kli_uzid"." SELECT".
" psys,uro,0,ume,dat,dok,uce,ur1,puc,ucm,ucd,rdp,ico,fak,str,zak,hod,mdt,dal,zos,pop,pox,0,0,0,0,0,0".
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
" psys,778,0,$vyb_ume,dat,0,uce,0,0,ucm,ucd,rdp,0,0,0,0,0,SUM(mdt),SUM(dal),0,'',1,".
"SUM(pmdt),SUM(pdal),SUM(omdt),SUM(odal),SUM(zmdt),SUM(zdal)".
" FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid".
" WHERE cpl >= 0 ".
" GROUP BY uce".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid WHERE uro != 778 ";
$dsql = mysql_query("$dsqlt");

//uprav synteticky ucet
$dsqlt = "UPDATE F$kli_vxcf"."_prchlknihasxx$kli_uzid SET uce=LEFT(uce,3) WHERE uro = 778 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihasxx$kli_uzid "." SELECT".
" psys,777,0,$vyb_ume,dat,0,uce,0,0,ucm,ucd,rdp,0,0,0,0,0,SUM(mdt),SUM(dal),0,'',1,".
"SUM(pmdt),SUM(pdal),SUM(omdt),SUM(odal),SUM(zmdt),SUM(zdal)".
" FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid".
" WHERE cpl >= 0 ".
" GROUP BY uce".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid WHERE uro != 777 ";
$dsql = mysql_query("$dsqlt");

//koniec uprav synteticky ucet

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
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Hlavná kniha</title>
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
if( $typ == 'HTML' )
{
//#252,170,18
?>
<table class="h2" width="100%" >
<tr>
<td>
<?php if( $drupoh == 1 ) { echo "EuroSecom  -  Hlavná kniha - položkovitá PU"; } ?>
<?php if( $drupoh == 2 ) { echo "EuroSecom  -  Hlavná kniha - sumárna PU"; } ?>
  <a href="#" onClick="window.open('../ucto/hlkniha_su.php?copern=11&drupoh=<?php echo $drupoh;?>&page=1&typ=PDF&h_obdp=<?php echo $h_obdp;?>
&h_obdk=<?php echo $h_obdk;?>', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>

 <a href="#" onClick="window.open('../ucto/hlkniha_su.php?copern=11&drupoh=<?php echo $drupoh;?>&page=1&typ=HTML&h_obdk=<?php echo $h_obdk;?>', '_self' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 alt='Prepoèet po úpravách knihy' ></a>
</td>
<td align="right">
<?php
$prev_obdk=$h_obdk-1; $next_obdk=$h_obdk+1;
if( $prev_obdk == 0 ) { $prev_obdk=12; }
if( $next_obdk == 13 ) { $next_obdk=1; }
$coperp=$copern+1;
      if( $copern == 30 OR $copern == 20 OR $copern == 10 ) { ?>
<a href="#" onClick="window.open('../ucto/hlkniha_su.php?copern=<?php echo $coperp;?>&drupoh=<?php echo $drupoh;?>&h_obdk=<?php echo $prev_obdk;?>
&h_obdp=<?php echo $prev_obdk;?>&page=1&typ=HTML', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 alt='Obdobie <?php echo $prev_obdk.".".$kli_vrok; ?>' ></a>
<a href="#" onClick="window.open('../ucto/hlkniha_su.php?copern=<?php echo $coperp;?>&drupoh=<?php echo $drupoh;?>&h_obdk=<?php echo $next_obdk;?>
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

if( $drupoh == 1 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_prchlknihasx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prchlknihasx$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_uctdrdp".
" ON F$kli_vxcf"."_prchlknihasx$kli_uzid".".rdp=F$kli_vxcf"."_uctdrdp.rdp".
" WHERE cpl > 0 ".
" ORDER BY cpl";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
}

if( $drupoh == 2 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prchlknihasxx$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_uctdrdp".
" ON F$kli_vxcf"."_prchlknihasxx$kli_uzid".".rdp=F$kli_vxcf"."_uctdrdp.rdp".
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

$pdf->Cell(140,5,"Hlavná kniha za syntetické úèty obdobie $vyb_umep / $vyb_umek","LTB",0,"L");
$pdf->Cell(135,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");


$pdf->Cell(30,4,"Úèet","1",0,"L");$pdf->Cell(35,4,"Poèiatok MáDa","1",0,"R");$pdf->Cell(35,4,"Poèiatok Dal","1",0,"R");
$pdf->Cell(35,4,"Obraty MáDa","1",0,"R");$pdf->Cell(35,4,"Obraty Dal","1",0,"R");$pdf->Cell(35,4,"Rozdiel MD-DL","1",0,"R");
$pdf->Cell(35,4,"Zostatok MáDa","1",0,"R");$pdf->Cell(35,4,"Zostatok Dal","1",1,"R");

}
//koniec PDF a $drupoh 2


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

$rozdiel=$polozka->omdt-$polozka->odal;
$Cislo=$rozdiel+"";
$srozdiel=sprintf("%0.2f", $Cislo);

if( $typ == 'PDF' AND $drupoh == 2 )
         {
if( $polozka->uro == 777 )
   {

$pdf->Cell(30,5,"$polozka->uce","0",0,"L");$pdf->Cell(35,5,"$polozka->pmdt","0",0,"R");$pdf->Cell(35,5,"$polozka->pdal","0",0,"R"); 
$pdf->Cell(35,5,"$polozka->omdt","0",0,"R");$pdf->Cell(35,5,"$polozka->odal","0",0,"R");$pdf->Cell(35,5,"$srozdiel","0",0,"R");
$pdf->Cell(35,5,"$polozka->zmdt","0",0,"R");$pdf->Cell(35,5,"$polozka->zdal","0",1,"R");
   }
if( $polozka->uro == 778 )
   {
$pdf->Cell(30,5,"CELKOM","T",0,"L");
$pdf->Cell(35,5,"$polozka->pmdt","T",0,"R");$pdf->Cell(35,5,"$polozka->pdal","T",0,"R"); 
$pdf->Cell(35,5,"$polozka->omdt","T",0,"R");$pdf->Cell(35,5,"$polozka->odal","T",0,"R");$pdf->Cell(35,5,"$srozdiel","T",0,"R");
$pdf->Cell(35,5,"$polozka->zmdt","T",0,"R");$pdf->Cell(35,5,"$polozka->zdal","T",1,"R");
   }
$j=$j+1;
         }
//koniec PDF a drupoh 2





}
$i = $i + 1;

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
if( $j > 32 AND $drupoh == 2 )
      {
$strana=$strana+1;
$j=0;
      }
//koniec bloku na koniec stranky


  }
//koniec polozky


if( $typ == 'PDF' )
{

$pdf->Output("../tmp/hlkniha.$kli_uzid.pdf");
?> 
<script type="text/javascript">
  var okno = window.open("../tmp/hlkniha.<?php echo $kli_uzid; ?>.pdf","_self");
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
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
