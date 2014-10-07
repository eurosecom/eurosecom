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

//drupoh=1 polozkovita, drupoh=2 sumarna

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


//vytvorenie pracovneho suboru pre hlavnu knihu a pohyby na ucte polozkovite

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihas'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihasx'.$kli_uzid;
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
   hod          DECIMAL(12,2),
   mdt          DECIMAL(12,2),
   dal          DECIMAL(12,2),
   zos          DECIMAL(12,2),
   pop          VARCHAR(80),
   pox          INT(10),
   PRIMARY KEY(cpl)
);
prchlknihas;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prchlknihas'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prchlknihasx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prchlknihasy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $vyb_ume);
$vyb_mume=$pole[0];
$vyb_rume=$pole[1];
if( $vyb_mume < 10 ) $vyb_mume="0".$vyb_mume;

$pole = explode(".", $vyb_umep);
$vyb_mumep=$pole[0];
$vyb_rumep=$pole[1];
if( $vyb_mumep < 10 ) $vyb_mumep="0".$vyb_mumep;

$pole = explode(".", $vyb_umek);
$vyb_mumek=$pole[0];
$vyb_rumek=$pole[1];
if( $vyb_mumek < 10 ) $vyb_mumek="0".$vyb_mumek;

$ume_poc=$vyb_umep;
$datp_ume=$vyb_rumep.'-'.$vyb_mumep.'-01';
$datk_ume=$vyb_rumek.'-'.$vyb_mumek.'-01';
if( $cele == 1 ) { $datp_ume=$vyb_rume.'-01-01'; $ume_poc="1.2009"; }

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_ume', '$datk_ume', 0 )";
$ttqq = mysql_query("$ttvv");


$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp=SUBDATE('$datp_ume',1),  datk=LAST_DAY('$datk_ume')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_ume=$riadok->datp;
  $datk_ume=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$datp_umesk=SkDatum($datp_dph);
$datk_umesk=SkDatum($datk_dph);

$dat_pcc=$datp_ume;
$ume_pcc="0";

//zober pociatocny stav uctov
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" 0,1,0,$ume_pcc,'$dat_pcc',0,F$kli_vxcf"."_uctosnova.uce,1,0,F$kli_vxcf"."_uctosnova.uce,".
"0,0,0,0,0,0,F$kli_vxcf"."_uctosnova.pmd,F$kli_vxcf"."_uctosnova.pmd,0,0,'',1".
" FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pmd != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" 0,1,0,$ume_pcc,'$dat_pcc',0,F$kli_vxcf"."_uctosnova.uce,1,0,0,F$kli_vxcf"."_uctosnova.uce,".
"0,0,0,0,0,F$kli_vxcf"."_uctosnova.pda,0,F$kli_vxcf"."_uctosnova.pda,0,'',1".
" FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pda != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

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
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,F$kli_vxcf"."_$uctovanie.dok,ucm,1,ucd,ucm,ucd,rdp,F$kli_vxcf"."_$uctovanie.ico,0,".
"F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak,F$kli_vxcf"."_$uctovanie.hod,F$kli_vxcf"."_$uctovanie.hod,0,0,CONCAT(txp, ' ', pop),1".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ( ucm > 0 OR ucd > 0 ) AND ume <= $vyb_umek";
$dsql = mysql_query("$dsqlt");
}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,dok,ucm,1,ucd,ucm,ucd,rdp,ico,0,".
"str,zak,hod,hod,0,0,pop,1".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE ume <= $vyb_umek";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }

//echo $vyb_umep;
//echo $vyb_umek;
//exit;

//vloz stranu dal
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" psys,1,0,ume,dat,dok,ucd,1,ucm,ucm,ucd,rdp,ico,fak,str,zak,hod,0,hod,0,pop,pox".
" FROM F$kli_vxcf"."_prchlknihas$kli_uzid".
" WHERE ume <= $vyb_umek AND psys > 0";
" ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prchlknihas$kli_uzid "." SET fak=1 WHERE ume = $vyb_umek";
$dsql = mysql_query("$dsqlt");

//sumar za ucty
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid "." SELECT".
" psys,1,0,$vyb_ume,dat,dok,uce,999,puc,ucm,ucd,rdp,ico,SUM(fak),str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,1".
" FROM F$kli_vxcf"."_prchlknihas$kli_uzid".
" WHERE cpl >= 0".
" GROUP BY uce".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prchlknihas$kli_uzid WHERE fak = 0 AND ur1 = 999 ";
$dsql = mysql_query("$dsqlt");

//sumar za vsetko=zostatok
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid "." SELECT".
" psys,999,0,$vyb_ume,dat,dok,uce,1,puc,ucm,ucd,rdp,ico,0,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,999".
" FROM F$kli_vxcf"."_prchlknihas$kli_uzid".
" WHERE uro = 1 AND ur1 = 1 AND psys > 0".
" GROUP BY pox".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//pociatocny stav mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid "." SELECT".
" psys,1,0,$vyb_ume,dat,0,uce,0,0,ucm,ucd,rdp,0,0,0,0,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),'Poèiatoèný stav',1".
" FROM F$kli_vxcf"."_prchlknihas$kli_uzid".
" WHERE cpl >= 0 AND ume < $vyb_umep".
" GROUP BY uce".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//vloz pre ocislovanie poloziek
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihasx$kli_uzid"." SELECT".
" psys,uro,0,ume,dat,dok,uce,ur1,puc,ucm,ucd,rdp,ico,fak,str,zak,hod,mdt,dal,zos,pop,pox".
" FROM F$kli_vxcf"."_prchlknihas$kli_uzid".
" WHERE ume >= $vyb_umep AND ume <= $vyb_umek ".
" ORDER BY uro,uce,ur1,dat,dok,hod";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;


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

if( $drupoh == 2 )
         {
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


}
//koniec pracovneho pre sumarnu



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Hlavná kniha položkovitá</title>
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
  <a href="#" onClick="window.open('../ucto/hlkniha.php?copern=11&drupoh=<?php echo $drupoh;?>&page=1&typ=PDF&h_obdp=<?php echo $h_obdp;?>
&h_obdk=<?php echo $h_obdk;?>', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>

 <a href="#" onClick="window.open('../ucto/hlkniha.php?copern=11&drupoh=<?php echo $drupoh;?>&page=1&typ=HTML&h_obdk=<?php echo $h_obdk;?>', '_self' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 alt='Prepoèet po úpravách knihy' ></a>
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
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prchlknihasx$kli_uzid".".uce=F$kli_vxcf"."_uctosnova.uce".
" WHERE ( uro = 1 AND ur1 = 0 ) OR ( uro = 1 AND ur1 = 1 ) OR ur1 = 999 OR uro = 999 ".
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
//$pol=11000;
//echo "pol ".$pol;
//exit;

  while ( $i <= $pol )
  {

$maxstrana=150;
$minstrana=1;
$h_s200 = $_REQUEST['h_s200'];
if( $h_s200 == 2 ) { $maxstrana=300; $minstrana=150; }
if( $h_s200 == 3 ) { $maxstrana=450; $minstrana=300; }
if( $h_s200 == 4 ) { $maxstrana=600; $minstrana=450; }
$tlac=0;
if ( $strana >= $minstrana AND $strana <= $maxstrana ) { $tlac=1; }

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);


if ( $j == 0 )
      {

if( $typ == 'PDF' AND $drupoh == 1 )
{
if( $tlac == 1 ) {

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

$pdf->Cell(110,5,"Hlavná kniha za $vyb_ume","LTB",0,"L");
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");


$pdf->Cell(15,4,"Položka","1",0,"R");$pdf->Cell(15,4,"Úè.mes.","1",0,"R");$pdf->Cell(20,4,"Dátum","1",0,"R");
$pdf->Cell(20,4,"Doklad","1",0,"R");$pdf->Cell(20,4,"Úèet","1",0,"R");
$pdf->Cell(25,4,"MáDa","1",0,"R");$pdf->Cell(25,4,"Dal","1",0,"R");$pdf->Cell(25,4,"Zostatok","1",0,"R");
$pdf->Cell(15,4,"Proti","1",0,"R");$pdf->Cell(15,4,"STR","1",0,"R");$pdf->Cell(0,4,"Popis","1",1,"L");

                  }
}
//koniec PDF a $drupoh 1


      }
//koniec j=0


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
if( $tlac == 1 ) {
$pdf->Cell(90,5,"Poèiatok $polozka->uce za obdobie $vyb_ume","T",0,"L");
$pdf->Cell(25,5,"$polozka->mdt","T",0,"R"); 
$pdf->Cell(25,5,"$polozka->dal","T",0,"R"); 
$pdf->Cell(25,5,"$polozka->zos","T",0,"R"); 
$pdf->Cell(0,5,"$polozka->nuc","T",1,"L");
                 }
$polozky=0;
$j = $j + 1;
   }
if( $polozka->uro == 1 AND $polozka->ur1 == 1 )
   {
if( $tlac == 1 ) {
$pdf->Cell(15,5,"POH$polozka->psys","0",0,"R");$pdf->Cell(15,5,"$polozka->ume","0",0,"R");$pdf->Cell(20,5,"$datsk","0",0,"R");
$pdf->Cell(20,5,"$polozka->dok","0",0,"R");$pdf->Cell(20,5,"$polozka->uce","0",0,"R");
$pdf->Cell(25,5,"$polozka->mdt","0",0,"R");$pdf->Cell(25,5,"$polozka->dal","0",0,"R");$pdf->Cell(25,5,"$polozka->zost","0",0,"R");
$pdf->Cell(15,5,"$polozka->puc","0",0,"R");$pdf->Cell(15,5,"$polozka->str","0",0,"R");$pdf->Cell(0,5,"$polozka->pop","0",1,"L");
                 }
$polozky=$polozky+1;
$j = $j + 1;
   }

if( $polozka->ur1 == 999 AND $polozka->fak > 0 )
   {
if( $tlac == 1 ) {
//tlac sumare
$pdf->Cell(90,5,"Zostatok $polozka->uce za obdobie $vyb_ume","0",0,"L");
$pdf->Cell(25,5,"$polozka->mdt","0",0,"R"); 
$pdf->Cell(25,5,"$polozka->dal","0",0,"R"); 
$pdf->Cell(25,5,"$polozka->zos","0",0,"R"); 
$pdf->Cell(0,5," ","0",1,"L");
                 }
$j = $j + 1;
   }
if( $polozka->uro == 999 )
   {
if( $tlac == 1 ) {
//tlac sumare
$pdf->Cell(90,5,"Celkom","1",0,"R");
$pdf->Cell(25,5,"$polozka->mdt","1",0,"R"); 
$pdf->Cell(25,5,"$polozka->dal","1",0,"R"); 
$pdf->Cell(25,5,"$polozka->zos","1",0,"R"); 
$pdf->Cell(0,5," ","1",1,"L");
                 }
$j = $j + 1;
   }


         }
//koniec PDF a drupoh 1


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
if( $j >= 34 AND $drupoh == 1 )
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
