<HTML>
<?php

do
{
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

//zapis do statistickej TABLE a prepni do stat zostavy modul 1003,1004
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 1003 )
{
$r01=0; $r02=0; $r03=0; $r04=0; $r05=0; $r06=0; $r07=0; $r08=0; $r09=0; $r10=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid WHERE uro = 777 AND ( LEFT(uce,3) = 601 OR LEFT(uce,3) = 602 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02=$r02+$polozka->odal-$polozka->omdt; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid WHERE uro = 777 AND ( LEFT(uce,3) = 604 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r03=$r03+$polozka->odal-$polozka->omdt; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid WHERE uro = 777 AND ( LEFT(uce,3) = 621 OR LEFT(uce,3) = 622 OR LEFT(uce,3) = 623 OR LEFT(uce,3) = 624 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r05=$r05+$polozka->odal-$polozka->omdt; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid WHERE uro = 777 AND ( LEFT(uce,3) = 611 OR LEFT(uce,3) = 612 OR LEFT(uce,3) = 613 OR LEFT(uce,3) = 614 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r06=$r06+$polozka->odal-$polozka->omdt; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid WHERE uro = 777 AND ( LEFT(uce,3) = 504 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r07=$r07-$polozka->odal+$polozka->omdt; }
$i=$i+1;                   }

$x01=0; $x02=0; $x03=0; $x04=0; $x05=0; $x06=0; $x07=0; $x08=0; $x09=0; $x10=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid WHERE uro = 777 AND ( LEFT(uce,3) = 501 OR LEFT(uce,3) = 502 OR LEFT(uce,3) = 503 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $x02=$x02-$polozka->odal+$polozka->omdt; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid WHERE uro = 777 AND ".
" ( LEFT(uce,3) = 511 OR LEFT(uce,3) = 512 OR LEFT(uce,3) = 513 OR LEFT(uce,3) = 514 OR LEFT(uce,3) = 515  OR LEFT(uce,3) = 516  OR LEFT(uce,3) = 517  OR LEFT(uce,3) = 518 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $x03=$x03-$polozka->odal+$polozka->omdt; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid WHERE uro = 777 AND ( LEFT(uce,3) = 549 OR LEFT(uce,3) = 582 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $x05=$x05-$polozka->odal+$polozka->omdt; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid WHERE uro = 777 AND ( LEFT(uce,3) = 551 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $x06=$x06-$polozka->odal+$polozka->omdt; }
$i=$i+1;                   }


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod1003s02='$r02', mod1003s03='$r03', mod1003s05='$r05', mod1003s06='$r06', mod1003s07='$r07', ".
" mod1004s02='$x02', mod1004s03='$x03', mod1004s05='$x05', mod1004s06='$x06', ".
" mod1004s07=mod5r15, mod1004s08=mod5r22, mod1004s09=mod5r02 ". 
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");  
?>
<script type="text/javascript">

window.open('../ucto/statistika_p304.php?copern=401&drupoh=1&page=1&modul=1003', '_self' )

</script>
<?php
}


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Hlavn· kniha</title>
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
<?php if( $drupoh == 1 ) { echo "EuroSecom  -  Hlavn· kniha - poloûkovit· PU"; } ?>
<?php if( $drupoh == 2 ) { echo "EuroSecom  -  Hlavn· kniha - sum·rna PU"; } ?>
  <a href="#" onClick="window.open('../ucto/hlkniha.php?copern=11&drupoh=<?php echo $drupoh;?>&page=1&typ=PDF&h_obdp=<?php echo $h_obdp;?>
&h_obdk=<?php echo $h_obdk;?>', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='VytlaËiù vo form·te PDF' ></a>

 <a href="#" onClick="window.open('../ucto/hlkniha.php?copern=11&drupoh=<?php echo $drupoh;?>&page=1&typ=HTML&h_obdk=<?php echo $h_obdk;?>', '_self' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 alt='PrepoËet po ˙prav·ch knihy' ></a>
</td>
<td align="right">
<?php
$prev_obdk=$h_obdk-1; $next_obdk=$h_obdk+1;
if( $prev_obdk == 0 ) { $prev_obdk=12; }
if( $next_obdk == 13 ) { $next_obdk=1; }
$coperp=$copern+1;
      if( $copern == 30 OR $copern == 20 OR $copern == 10 ) { ?>
<a href="#" onClick="window.open('../ucto/hlkniha.php?copern=<?php echo $coperp;?>&drupoh=<?php echo $drupoh;?>&h_obdk=<?php echo $prev_obdk;?>
&h_obdp=<?php echo $prev_obdk;?>&page=1&typ=HTML', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 alt='Obdobie <?php echo $prev_obdk.".".$kli_vrok; ?>' ></a>
<a href="#" onClick="window.open('../ucto/hlkniha.php?copern=<?php echo $coperp;?>&drupoh=<?php echo $drupoh;?>&h_obdk=<?php echo $next_obdk;?>
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
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prchlknihasx$kli_uzid".".uce=F$kli_vxcf"."_uctosnova.uce".
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

if( $typ == 'PDF' AND $drupoh == 1 )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

$pdf->Cell(110,5,"Hlavn· kniha za $vyb_ume","LTB",0,"L");
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");


$pdf->Cell(15,4,"Poloûka","1",0,"R");$pdf->Cell(15,4,"⁄Ë.mes.","1",0,"R");$pdf->Cell(20,4,"D·tum","1",0,"R");
$pdf->Cell(20,4,"Doklad","1",0,"R");$pdf->Cell(20,4,"⁄Ëet","1",0,"R");
$pdf->Cell(25,4,"M·Daù","1",0,"R");$pdf->Cell(25,4,"Dal","1",0,"R");$pdf->Cell(25,4,"Zostatok","1",0,"R");
$pdf->Cell(15,4,"Proti","1",0,"R");$pdf->Cell(15,4,"STR","1",0,"R");$pdf->Cell(0,4,"Popis","1",1,"L");

}
//koniec PDF a $drupoh 1


if( $typ == 'PDF' AND $drupoh == 2 )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

$pdf->Cell(110,5,"Hlavn· kniha za $vyb_umep / $vyb_umek","LTB",0,"L");
$pdf->Cell(100,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(210,4,"⁄Ëet Popis","1",1,"L");
$pdf->Cell(35,4,"PoËiatok M·Daù","1",0,"R");$pdf->Cell(35,4,"PoËiatok Dal","1",0,"R");
$pdf->Cell(35,4,"Obraty M·Daù","1",0,"R");$pdf->Cell(35,4,"Obraty Dal","1",0,"R");
$pdf->Cell(35,4,"Zostatok M·Daù","1",0,"R");$pdf->Cell(35,4,"Zostatok Dal","1",1,"R");

}
//koniec PDF a $drupoh 2

if( $typ == 'HTML' AND $drupoh == 1 )
{
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" colspan="5"><?php echo "Hlavn· kniha za $vyb_ume"; ?></td>
<td class="bmenu" colspan="6" align="right"><?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?></td>
</tr>

<tr>
<td class="bmenu" width="5%">Poloûka</td>
<td class="bmenu" width="5%">⁄Ë.mes.</td>
<td class="bmenu" width="6%">D·tum</td>
<td class="bmenu" width="10%">Doklad</td>

<td class="bmenu" width="5%">⁄Ëet</td>
<td class="hvstup_zlte" width="6%" align="right">M·Daù</td>
<td class="hvstup_zlte" width="6%" align="right">Dal</td>
<td class="hvstup_zlte" width="6%" align="right">Zostatok</td>
<td class="bmenu" width="5%">Proti</td>
<td class="bmenu" width="3%" align="right">STR</td>

<td class="bmenu" width="28%">Popis</td>
</tr>

<?php
}
//koniec html a drupoh 1

if( $typ == 'HTML' AND $drupoh == 2 )
{
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" colspan="3"><?php echo "Hlavn· kniha za $vyb_umep / $vyb_umek"; ?></td>
<td class="bmenu" colspan="3" align="right"><?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?></td>
</tr>

<tr><td class="bmenu" colspan="1">⁄Ëet</td><td class="bmenu" colspan="5">N·zov ˙Ëtu</td></tr>

<td class="bmenu" width="15%" align="right">PoËiatok M·Daù</td>
<td class="bmenu" width="15%" align="right">PoËiatok Dal</td>

<td class="bmenu" width="20%" align="right">Obraty M·Daù</td>
<td class="bmenu" width="20%" align="right">Obraty Dal</td>

<td class="bmenu" width="15%" align="right">Zostatok M·Daù</td>
<td class="bmenu" width="15%" align="right">Zostatok Dal</td>
</tr>

<?php
}
//koniec html a drupoh 1


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


if( $typ == 'PDF' AND $drupoh == 1 )
         {
if( $polozka->uro == 1 AND $polozka->ur1 == 0 )
   {
$pdf->Cell(90,5,"PoËiatok $polozka->uce za obdobie $vyb_ume","0",0,"L");
$pdf->Cell(25,5,"$polozka->mdt","0",0,"R"); 
$pdf->Cell(25,5,"$polozka->dal","0",0,"R"); 
$pdf->Cell(25,5,"$polozka->zos","0",0,"R"); 
$pdf->Cell(0,5,"$polozka->nuc","0",1,"L");
   }
if( $polozka->uro == 1 AND $polozka->ur1 == 1 )
   {
$pdf->Cell(15,5,"POH$polozka->psys","0",0,"R");$pdf->Cell(15,5,"$polozka->ume","0",0,"R");$pdf->Cell(20,5,"$datsk","0",0,"R");
$pdf->Cell(20,5,"$polozka->dok","0",0,"R");$pdf->Cell(20,5,"$polozka->uce","0",0,"R");
$pdf->Cell(25,5,"$polozka->mdt","0",0,"R");$pdf->Cell(25,5,"$polozka->dal","0",0,"R");$pdf->Cell(25,5,"$polozka->zost","0",0,"R");
$pdf->Cell(15,5,"$polozka->puc","0",0,"R");$pdf->Cell(15,5,"$polozka->str","0",0,"R");$pdf->Cell(0,5,"$polozka->pop","0",1,"L");
   }
if( $polozka->ur1 == 999 )
   {
//tlac sumare
$pdf->Cell(90,5,"Zostatok $polozka->uce za obdobie $vyb_ume","B",0,"L");
$pdf->Cell(25,5,"$polozka->mdt","B",0,"R"); 
$pdf->Cell(25,5,"$polozka->dal","B",0,"R"); 
$pdf->Cell(25,5,"$polozka->zos","B",0,"R"); 
$pdf->Cell(0,5," ","B",1,"L");
   }
if( $polozka->uro == 999 )
   {
//tlac sumare
$pdf->Cell(90,5,"Celkom","1",0,"R");
$pdf->Cell(25,5,"$polozka->mdt","1",0,"R"); 
$pdf->Cell(25,5,"$polozka->dal","1",0,"R"); 
$pdf->Cell(25,5,"$polozka->zos","1",0,"R"); 
$pdf->Cell(0,5," ","1",1,"L");
   }
         }
//koniec PDF a drupoh 1

if( $typ == 'PDF' AND $drupoh == 2 )
         {
if( $polozka->uro == 777 )
   {
$pdf->Cell(210,5,"$polozka->uce $polozka->nuc","0",1,"L");
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

if( $typ == 'HTML' AND $drupoh == 1 )
     {
$hvstup="hvstup";
if( $par == 1 ) { $hvstup="hvstup_bsede"; }

//pociatok mesiaca
if( $polozka->uro == 1 AND $polozka->ur1 == 0 )
   {
?>
<tr>

<td class="hvstup_zlte" align="left" colspan="5">PoËiatok <?php echo $polozka->uce; ?> za obdobie <?php echo $vyb_ume; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->mdt; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->dal; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->zos; ?></td>
<td class="hvstup_zlte" align="left" colspan="3"><?php echo $polozka->nuc; ?></td>

</tr>
<?php
//koniec uro=1,ur1=0 pociatok mesiaca
   }

//
if( $polozka->uro == 1 AND $polozka->ur1 == 1 )
   {
?>

<tr>
<td class="<?php echo $hvstup; ?>">POH<?php echo $polozka->psys; ?></td>
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

<td class="<?php echo $hvstup; ?>">
<a href="#" onClick="window.open('zosuce.php?copern=31&drupoh=<?php echo $drupoh;?>&h_obdk=<?php echo $h_obdk;?>&page=1&typ=HTML&cislo_uce=<?php echo $polozka->uce;?>', '_blank', 
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<?php echo $polozka->uce; ?></a>
</td>

<td class="hvstup_zlte" align="right"><?php echo $polozka->mdt; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->dal; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $zost; ?></td>
<td class="<?php echo $hvstup; ?>"><?php echo $polozka->puc; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $polozka->str; ?></td>
<td class="<?php echo $hvstup; ?>"><?php echo $polozka->pop; ?></td>
</tr>

<?php
//koniec uro=1 a ur1=1
   }
if( $polozka->ur1 == 999 )
   {
?>
<tr>

<td class="hvstup_tzlte" align="left" colspan="5">Zostatok <?php echo $polozka->uce; ?> za obdobie <?php echo $vyb_ume; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->mdt; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->dal; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->zos; ?></td>
<td class="hvstup_tzlte" align="left" colspan="2"></td>
</tr>
<?php
//koniec ur1=999
   }
if( $polozka->uro == 999 )
   {
?>
<tr>
<td class="bmenu" colspan="3"></td>

<td class="bmenu" align="right" colspan="2">Celkom</td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->mdt; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->dal; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->zos; ?></td>

</tr>

</table>
<?php
//koniec uro=999
   }

//koniec html AND drupoh == 1 
     }

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
<td class="hvstup_zlte" colspan="6">
<a href="#" onClick="window.open('zosuce.php?copern=31&drupoh=<?php echo $drupoh;?>&h_obdk=<?php echo $h_obdk;?>&page=1&typ=HTML&cislo_uce=<?php echo $polozka->uce;?>', '_blank', 
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<?php echo $polozka->uce; ?> </a> <?php echo $polozka->nuc; ?> </td>
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
