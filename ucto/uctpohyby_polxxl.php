<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];
$typ = $_REQUEST['typ'];
$cislo_uce = $_REQUEST['cislo_uce'];
$cislo_dok = $_REQUEST['cislo_dok'];
$ucedlzka=strlen($cislo_uce);
//echo $ucedlzka;
$dajcsv = 1*$_REQUEST['dajcsv'];

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


$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if( $dajcsv == 0 AND $typ == 'PDF' )
    {
 $outfilexdel="../tmp/pohyby_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/pohyby_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }
    }

if( $dajcsv == 1 AND $typ == 'PDF' )
    {

 $outfilexdel="../tmp/pohcsv_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/pohcsv_".$kli_uzid."_".$hhmmss.".csv";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

$nazsub=$outfilex;
$soubor = fopen("$nazsub", "a+");

    }


   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

if ( $copern != 80 )
      {
$navysku = 1*$_REQUEST['navysku'];
if( $navysku == 0 ) $pdf=new FPDF("L","mm","A4");
if( $navysku == 1 ) $pdf=new FPDF("P","mm","A4"); 
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
      }
if ( $copern == 80 )
      {
$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
      }

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$vyb_ume=$kli_vume;
$vyb_umep=$kli_vume;
$vyb_umek=$kli_vume;
$h_obdp=$kli_vmes;
$h_obdk=$kli_vmes;

if( $copern == 32 OR $copern == 22 OR $copern == 12 ) { $vyb_ume=$_REQUEST['tlac_ume']; $copern=$copern-1; }
if( $copern == 31 OR $copern == 21 OR $copern == 11 ) { 
$h_obdp = 1*$_REQUEST['h_obdp'];
$h_obdk = 1*$_REQUEST['h_obdk'];
if( $h_obdp == 0 ) $h_obdp=1;
if( $h_obdk == 0 ) $h_obdk=12;
$vyb_ume=$h_obdk.".".$kli_vrok;
$vyb_umep=$h_obdp.".".$kli_vrok;
$vyb_umek=$h_obdk.".".$kli_vrok;

$h_datp = $_REQUEST['h_datp'];
$h_datk = $_REQUEST['h_datk'];
$h_datpsql = SqlDatum($h_datp);
$h_datksql = SqlDatum($h_datk);
$jedatum=0;
$pocroka="01.01.".$kli_vrok;
$konroka="31.12.".$kli_vrok;
if( $h_datp != '' AND $h_datp != $pocroka ) $jedatum=1;
if( $h_datk != '' AND $h_datk != $konroka ) $jedatum=1;

//echo $h_datp." ".$h_datk." ".$jedatum;
//echo $h_datpsql." ".$h_datksql." ".$jedatum;

//pracovny subor
//$prac_subor = include("prac_hlkniha.php");
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
   fak          INT(10),
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

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_ume', '$datk_ume', 0 )";
$ttqq = mysql_query("$ttvv");

$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp=SUBDATE('$datp_ume',1),  datk=LAST_DAY('$datk_ume')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

if( $jedatum == 1 ) 
{
$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$h_datpsql',  datk='$h_datksql' ".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

}

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_ume=$riadok->datp;
  $datk_ume=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$datp_umesk=SkDatum($datp_ume);
$datk_umesk=SkDatum($datk_ume);

$dat_pcc=$datp_ume;
$ume_pcc="0";

//echo $datp_ume." ".$datk_ume;

$podmuce="uce = ".$cislo_uce;
$podmucmucd="ucm = ".$cislo_uce." OR ucd = ".$cislo_uce;
$podmucenie="uce != ".$cislo_uce;
if( $ucedlzka == 3 AND $kli_vduj == 0 )
{
$podmuce="LEFT(uce,3) = ".$cislo_uce;
$podmucmucd="LEFT(ucm,3) = ".$cislo_uce." OR LEFT(ucd,3) = ".$cislo_uce;
$podmucenie="LEFT(uce,3) != ".$cislo_uce;
}

//zober pociatocny stav uctov
$dat_pcx=$vyb_rume.'-01-01';

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" 0,1,0,$ume_pcc,'$dat_pcx',0,F$kli_vxcf"."_uctosnova.uce,1,0,F$kli_vxcf"."_uctosnova.uce,".
"0,0,0,0,0,0,F$kli_vxcf"."_uctosnova.pmd,F$kli_vxcf"."_uctosnova.pmd,0,0,'',1".
" FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pmd != 0 AND ".$podmuce." ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" 0,1,0,$ume_pcc,'$dat_pcx',0,F$kli_vxcf"."_uctosnova.uce,1,0,0,F$kli_vxcf"."_uctosnova.uce,".
"0,0,0,0,0,F$kli_vxcf"."_uctosnova.pda,0,F$kli_vxcf"."_uctosnova.pda,0,'',1".
" FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pda != 0 AND ".$podmuce." ";
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
" $psys,1,0,ume,dat,F$kli_vxcf"."_$uctovanie.dok,ucm,1,ucd,ucm,ucd,rdp,F$kli_vxcf"."_$uctovanie.ico,F$kli_vxcf"."_$uctovanie.fak,".
"F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak,F$kli_vxcf"."_$uctovanie.hod,F$kli_vxcf"."_$uctovanie.hod,0,0,CONCAT(txp, ' ', pop),1".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ( ".$podmucmucd." ) AND ume <= $vyb_umek";
$dsql = mysql_query("$dsqlt");
}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,dok,ucm,1,ucd,ucm,ucd,rdp,ico,fak,".
"str,zak,hod,hod,0,0,pop,1".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE ume <= $vyb_umek AND ( ".$podmucmucd." ) ";
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
" WHERE ume <= $vyb_umek AND ( ".$podmucmucd." ) AND psys > 0";
" ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prchlknihas$kli_uzid WHERE  ".$podmucenie." ";
$dsql = mysql_query("$dsqlt");


//ak nieje zadany datum
if( $jedatum == 0 ) 
{
//sumar za ucty
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid "." SELECT".
" psys,1,0,$vyb_ume,dat,dok,uce,999,puc,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,1".
" FROM F$kli_vxcf"."_prchlknihas$kli_uzid".
" WHERE cpl >= 0".
" GROUP BY uce".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//sumar za vsetko=zostatok
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid "." SELECT".
" psys,999,0,$vyb_ume,dat,dok,uce,1,puc,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,999".
" FROM F$kli_vxcf"."_prchlknihas$kli_uzid".
" WHERE uro = 1 AND ur1 = 1 AND psys > 0".
" GROUP BY pox".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//pociatocny stav mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid "." SELECT".
" psys,1,0,$vyb_ume,dat,0,uce,0,0,ucm,ucd,rdp,0,0,0,0,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),'PoËiatoËn˝ stav',1".
" FROM F$kli_vxcf"."_prchlknihas$kli_uzid".
" WHERE cpl >= 0 AND ume < $vyb_umep".
" GROUP BY uce".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

//ak je zadany datum
if( $jedatum == 1 ) 
{
$pole = explode("-", $datp_ume);
$datp_rok=$pole[0];
$datp_mes=$pole[1];
$datp_obd=$datp_mes.".".$datp_rok;

//pociatocny stav mesiaca 
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid "." SELECT".
" psys,1,0,$datp_obd,'$datp_ume',0,uce,0,0,ucm,ucd,rdp,0,0,0,0,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),'PoËiatoËn˝ stav',1".
" FROM F$kli_vxcf"."_prchlknihas$kli_uzid".
" WHERE cpl >= 0 AND dat < '$datp_ume' ".
" GROUP BY uce".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

$dsqlt = "DELETE FROM F$kli_vxcf"."_prchlknihas$kli_uzid WHERE dat > '$datk_ume' OR dat < '$datp_ume' ";
$dsql = mysql_query("$dsqlt");
}

//vloz pre ocislovanie poloziek
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihasx$kli_uzid"." SELECT".
" psys,uro,0,ume,dat,dok,uce,ur1,puc,ucm,ucd,rdp,ico,fak,str,zak,hod,mdt,dal,zos,pop,pox".
" FROM F$kli_vxcf"."_prchlknihas$kli_uzid".
" WHERE ume >= $vyb_umep AND ume <= $vyb_umek ".
" ORDER BY uro,uce,ur1,dat,dok,hod";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");



//koniec pracovny subor
$copern=$copern-1;
//echo " ".$copern;
                    }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>PoloûkovitÈ pohyby na ˙Ëte</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
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
<td>EuroSecom 
<?php $copert=$copern+2; ?>
  <a href="#" onClick="window.open('uctpohyby_polxxl.php?copern=<?php echo $copert; ?>&drupoh=1&page=1&typ=PDF&tlac_ume=<?php echo $vyb_ume; ?>&h_obdk=<?php echo $h_obdk;?>
&h_obdp=<?php echo $h_obdp;?>&h_datp=<?php echo $h_datp;?>&h_datk=<?php echo $h_datk;?>&cislo_uce=<?php echo $cislo_uce; ?>', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=25 height=15 border=0 title='VytlaËiù vo form·te PDF na öÌrku' ></a>

  <a href="#" onClick="window.open('uctpohyby_polxxl.php?copern=<?php echo $copert; ?>&drupoh=1&page=1&typ=PDF&tlac_ume=<?php echo $vyb_ume; ?>&h_obdk=<?php echo $h_obdk;?>
&h_obdp=<?php echo $h_obdp;?>&h_datp=<?php echo $h_datp;?>&h_datk=<?php echo $h_datk;?>&cislo_uce=<?php echo $cislo_uce; ?>&navysku=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=15 height=20 border=0 title='VytlaËiù vo form·te PDF na v˝öku' ></a>

  <a href="#" onClick="window.open('uctpohyby_polxxl.php?dajcsv=1&copern=<?php echo $copert; ?>&drupoh=1&page=1&typ=PDF&tlac_ume=<?php echo $vyb_ume; ?>&h_obdk=<?php echo $h_obdk;?>
&h_obdp=<?php echo $h_obdp;?>&h_datp=<?php echo $h_datp;?>&h_datk=<?php echo $h_datk;?>&cislo_uce=<?php echo $cislo_uce; ?>&navysku=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/export.png' width=20 height=15 border=0 title='VytlaËiù s˙bor vo form·te CSV' ></a>



</td>
<td align="right">
<?php
$prev_obdk=$h_obdk-1; $next_obdk=$h_obdk+1;
if( $prev_obdk == 0 ) { $prev_obdk=12; }
if( $next_obdk == 13 ) { $next_obdk=1; }
$coperp=$copern+1;
      if( $copern == 30 OR $copern == 20 OR $copern == 10 ) { ?>
<a href="#" onClick="window.open('uctpohyby_polxxl.php?copern=<?php echo $coperp;?>&drupoh=<?php echo $drupoh;?>&h_obdk=<?php echo $prev_obdk;?>
&page=1&typ=HTML&cislo_uce=<?php echo $cislo_uce;?>', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 title='Obdobie <?php echo $prev_obdk.".".$kli_vrok; ?>' ></a>
<a href="#" onClick="window.open('uctpohyby_polxxl.php?copern=<?php echo $coperp;?>&drupoh=<?php echo $drupoh;?>&h_obdk=<?php echo $next_obdk;?>
&page=1&typ=HTML&cislo_uce=<?php echo $cislo_uce;?>', '_self' )">
<img src='../obr/next.png' width=10 height=10 border=0 title='Obdobie <?php echo $next_obdk.".".$kli_vrok; ?>' ></a>
<?php                  } ?>
<span class="login"><?php echo "UME $vyb_ume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
<?php
}
?>

<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendensy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcpendens
(
   psys         INT(10),
   cpl          int not null auto_increment,
   ume          FLOAT(8,4),
   dat          DATE,
   pox          INT(1),
   poh          INT(10),
   zdn          INT(2), 
   dok          INT(8),
   ucm          INT(10),
   ucd          INT(10),
   rdp          INT(2),
   dph          INT(2),
   ico          INT(10),
   fak          INT(10),
   hod          DECIMAL(10,2),
   pokc         INT(10),
   hotp         DECIMAL(10,2),
   hotv         DECIMAL(10,2),
   prbp         DECIMAL(10,2),
   prbv         DECIMAL(10,2),
   ucbc         INT(10),
   ucbp         DECIMAL(10,2),
   ucbv         DECIMAL(10,2),
   priu         DECIMAL(10,2),
   vydu         DECIMAL(10,2),
   prid         DECIMAL(10,2),
   vydd         DECIMAL(10,2),
   zakd         DECIMAL(10,2),
   dphp         DECIMAL(10,2),
   dphv         DECIMAL(10,2),
   pop          VARCHAR(80),
   str          INT,
   zak          INT,
   PRIMARY KEY(cpl)
);
prcpendens;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcpendensy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


//copern=10 penden 20 udennik 30 hlkniha 

if ( $copern == 10 )
      {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendensy$kli_uzid"." SELECT".
" pox,0,ume,dat,pox,ucd,zdn,dok,ucm,ucd,rdp,dph,ico,fak,(hotp-hotv+ucbp-ucbv),ucm,(hotp+ucbp),(hotv+ucbv),prbp,prbv,ucbc,ucbp,ucbv,priu,vydu,prid,vydd,zakd,dphp,dphv,pop,str,zak".
" FROM F$kli_vxcf"."_prcpendens$kli_uzid".
" WHERE ucm = $cislo_uce AND ume <= $vyb_umek AND uro = 1 "."ORDER BY dat,pox,dok,poh,hod";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendensy$kli_uzid"." SELECT".
" pox,0,ume,dat,pox,ucm,zdn,dok,ucm,ucd,rdp,dph,ico,fak,(hotp-hotv+ucbp-ucbv),ucd,(hotp+ucbp),(hotv+ucbv),prbp,prbv,ucbc,ucbp,ucbv,priu,vydu,prid,vydd,zakd,dphp,dphv,pop,str,zak".
" FROM F$kli_vxcf"."_prcpendens$kli_uzid".
" WHERE ucd = $cislo_uce AND ume <= $vyb_umek AND uro = 1 "."ORDER BY dat,pox,dok,poh,hod";
$dsql = mysql_query("$dsqlt");
      }

//exit;

if ( $copern == 20 )
      {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendensy$kli_uzid"." SELECT".
" psys,0,ume,dat,pox,9999,0,dok,ucm,ucd,0,0,ico,fak,hod,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,pop,str,zak".
" FROM F$kli_vxcf"."_prcudenniksx$kli_uzid".
" WHERE ( ucm = $cislo_uce OR ucd = $cislo_uce ) AND uro = 1 "."ORDER BY dat,pox,dok,hod";
$dsql = mysql_query("$dsqlt");
      }


if ( $copern == 30 )
      {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendensy$kli_uzid"." SELECT".
" psys,0,ume,dat,pox,puc,0,dok,ucm,ucd,0,0,ico,fak,(mdt-dal),uce,mdt,dal,0,0,0,0,0,0,0,0,0,0,0,0,pop,str,zak".
" FROM F$kli_vxcf"."_prchlknihasx$kli_uzid".
" WHERE ( ".$podmuce." AND ume <= $vyb_umek AND uro = 1 AND ur1 != 999 ) "."ORDER BY dat,pox,dok,hod";
$dsql = mysql_query("$dsqlt");
      }


if ( $copern == 80 )
      {
//zostatok bankoveho uctu

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendensy$kli_uzid"." SELECT".
" 3,0,0,'0000-00-00',0,uce,0,0,uce,0,0,0,0,0,".
"(pmd-pda),uce,(pmd-pda),0,0,0,0,0,0,0,0,0,0,0,0,0,'',0,0".
" FROM F$kli_vxcf"."_uctosnova".
" WHERE uce = $cislo_uce ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendensy$kli_uzid"." SELECT".
" 3,0,F$kli_vxcf"."_banvyp.ume,F$kli_vxcf"."_banvyp.dat,0,ucd,0,F$kli_vxcf"."_banvyp.dok,ucm,ucd,0,0,F$kli_vxcf"."_uctban.ico,F$kli_vxcf"."_uctban.fak,".
"(F$kli_vxcf"."_uctban.hod),ucm,F$kli_vxcf"."_uctban.hod,0,0,F$kli_vxcf"."_uctban.cpl,0,0,0,0,0,0,0,0,0,0,F$kli_vxcf"."_uctban.pop,0,0".
" FROM F$kli_vxcf"."_uctban,F$kli_vxcf"."_banvyp".
" WHERE F$kli_vxcf"."_uctban.dok=F$kli_vxcf"."_banvyp.dok ".
" AND F$kli_vxcf"."_banvyp.dok < $cislo_dok AND F$kli_vxcf"."_uctban.ucm = $cislo_uce ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendensy$kli_uzid"." SELECT".
" 3,0,F$kli_vxcf"."_banvyp.ume,F$kli_vxcf"."_banvyp.dat,0,ucm,0,F$kli_vxcf"."_banvyp.dok,ucm,ucd,0,0,F$kli_vxcf"."_uctban.ico,F$kli_vxcf"."_uctban.fak,".
"(F$kli_vxcf"."_uctban.hod),ucd,0,F$kli_vxcf"."_uctban.hod,0,0,F$kli_vxcf"."_uctban.cpl,0,0,0,0,0,0,0,0,0,F$kli_vxcf"."_uctban.pop,0,0".
" FROM F$kli_vxcf"."_uctban,F$kli_vxcf"."_banvyp".
" WHERE F$kli_vxcf"."_uctban.dok=F$kli_vxcf"."_banvyp.dok ".
" AND F$kli_vxcf"."_banvyp.dok < $cislo_dok AND F$kli_vxcf"."_uctban.ucd = $cislo_uce ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendensy$kli_uzid"." SELECT".
" 3,0,ume,'0000-00-00',1,0,0,0,ucm,ucd,0,0,ico,fak,".
"hod,pokc,SUM(hotp),SUM(hotv),0,0,0,0,0,0,0,0,0,0,0,0,'poËiatoËn˝ stav',0,0".
" FROM F$kli_vxcf"."_prcpendensy$kli_uzid".
" WHERE pox = 0 GROUP BY pox";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prcpendensy$kli_uzid WHERE pox = 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendensy$kli_uzid"." SELECT".
" 3,0,F$kli_vxcf"."_banvyp.ume,F$kli_vxcf"."_banvyp.dat,1,ucd,0,F$kli_vxcf"."_banvyp.dok,ucm,ucd,0,0,F$kli_vxcf"."_uctban.ico,F$kli_vxcf"."_uctban.fak,".
"(F$kli_vxcf"."_uctban.hod),ucm,F$kli_vxcf"."_uctban.hod,0,0,0,F$kli_vxcf"."_uctban.cpl,0,0,0,0,0,0,0,0,0,F$kli_vxcf"."_uctban.pop,0,0".
" FROM F$kli_vxcf"."_uctban,F$kli_vxcf"."_banvyp".
" WHERE F$kli_vxcf"."_uctban.dok=F$kli_vxcf"."_banvyp.dok ".
" AND F$kli_vxcf"."_banvyp.dok = $cislo_dok AND F$kli_vxcf"."_uctban.ucm = $cislo_uce ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendensy$kli_uzid"." SELECT".
" 3,0,F$kli_vxcf"."_banvyp.ume,F$kli_vxcf"."_banvyp.dat,1,ucm,0,F$kli_vxcf"."_banvyp.dok,ucm,ucd,0,0,F$kli_vxcf"."_uctban.ico,F$kli_vxcf"."_uctban.fak,".
"(F$kli_vxcf"."_uctban.hod),ucd,0,F$kli_vxcf"."_uctban.hod,0,0,F$kli_vxcf"."_uctban.cpl,0,0,0,0,0,0,0,0,0,F$kli_vxcf"."_uctban.pop,0,0".
" FROM F$kli_vxcf"."_uctban,F$kli_vxcf"."_banvyp".
" WHERE F$kli_vxcf"."_uctban.dok=F$kli_vxcf"."_banvyp.dok ".
" AND F$kli_vxcf"."_banvyp.dok = $cislo_dok AND F$kli_vxcf"."_uctban.ucd = $cislo_uce ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

      }


//exit;



$sqltt = "SELECT * FROM F$kli_vxcf"."_prcpendensy$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcpendensy$kli_uzid".".poh=F$kli_vxcf"."_uctosnova.ucc".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcpendensy$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_uctdrdp".
" ON F$kli_vxcf"."_prcpendensy$kli_uzid".".rdp=F$kli_vxcf"."_uctdrdp.rdp".
" WHERE cpl > 0 "."ORDER BY dat,pox,dok,poh,hod";
//echo $sqltt;

if ( $copern == 80 )
      {
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcpendensy$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcpendensy$kli_uzid".".poh=F$kli_vxcf"."_uctosnova.ucc".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcpendensy$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_uctdrdp".
" ON F$kli_vxcf"."_prcpendensy$kli_uzid".".rdp=F$kli_vxcf"."_uctdrdp.rdp".
" WHERE cpl > 0 "."ORDER BY pox,dok,ucbc";
//echo $sqltt;
      }
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

//sumare napocet
$hotp = 0.00;
$hotv = 0.00;
$hotz = 0.00;

//////////////////////////////////////////////////////////////////z hlavnej knihy,dennika,obrat PODVOJNE
if ( $copern == 30 OR $copern == 40 OR $copern == 20 OR $copern == 80 )
      {

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctosnova WHERE uce = $cislo_uce");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $nazuce=$riaddok->nuc;
  }

$strana=1;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);

if ( $j == 0 )
      {

if( $typ == 'PDF' )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

if ( $copern != 80 )
      {
$pdf->Cell(80,5,"Pohyby na ˙Ëte $cislo_uce $nazuce za $vyb_ume","LTB",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(0,3,"FIR$kli_vxcf $kli_nxcf strana $strana","RT",1,"R");
$pdf->SetFont('arial','',6);
$dnesoktime = Date ("d.m.Y H:i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$pdf->Cell(0,2,"$dnesoktime","RB",1,"R");
      }
if ( $copern == 80 )
      {
$pdf->Cell(80,5,"Bankov˝ v˝pis $cislo_dok ˙Ëet $cislo_uce za $vyb_ume","LTB",0,"L");
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
      }

$pdf->SetFont('arial','',8);

$pdf->Cell(12,4,"Poloûka","1",0,"R");$pdf->Cell(14,4,"D·tum","1",0,"R");$pdf->Cell(15,4,"Doklad","1",0,"R");
$pdf->Cell(12,4,"⁄Ëet","1",0,"R");$pdf->Cell(7,4,"STR","1",0,"L");$pdf->Cell(11,4,"ZAK","1",0,"R");
$pdf->Cell(18,4,"M·Daù","1",0,"R");$pdf->Cell(18,4,"Dal","1",0,"R");$pdf->Cell(18,4,"Zostatok","1",0,"R");
$pdf->Cell(18,4,"Proti","1",0,"R");$pdf->Cell(0,4,"Popis","1",1,"L");


if ( $dajcsv == 1 )
      {
$text = "polozka;datum;doklad;ucet;str;zak;madat;dal;zostatok;proti;faktura;ico;nazov;popis"."\r\n";
fwrite($soubor, $text);
      }

}


if( $typ == 'HTML' )
{
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" colspan="8"><?php echo "Pohyby na ˙Ëte ".$cislo_uce." ".$nazuce." za ".$vyb_ume; ?></td>
<td class="bmenu" colspan="8" align="right"><?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?></td>
</tr>

<tr>
<td class="bmenu" width="7%">Poloûka</td>
<td class="bmenu" width="7%">D·tum</td>
<td class="bmenu" width="10%">Doklad</td>

<td class="hvstup_zlte" width="8%">⁄Ëet</td>
<td class="hvstup_zlte" width="10%" align="right">M·Daù</td>
<td class="hvstup_zlte" width="10%" align="right">Dal</td>
<td class="hvstup_zlte" width="10%" align="right">Zostatok</td>

<td class="bmenu" width="8%" align="right">Proti</td>
<td class="bmenu" width="8%" align="left">STR/ZAK</td>
<td class="bmenu" width="22%" >Popis</td>

</tr>
<?php
}

      }
//koniec j=0

//html nestrankuj
if( $typ == 'HTML' ) $j=1;

$h_hotp=0;
$h_hotv=0;
$h_hotp=$polozka->hotp;
$h_hotv=$polozka->hotv;

//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $polozka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);
if( $polozka->dat == '0000-00-00' ) $datsk="";

//sumare napocet
$hotp = $hotp + $h_hotp;
$Cislo=$hotp+"";
$shotp=sprintf("%0.2f", $Cislo);
$hotv = $hotv + $h_hotv;
$Cislo=$hotv+"";
$shotv=sprintf("%0.2f", $Cislo);
$hotz=$hotz+$h_hotp-($h_hotv);
$Cislo=$hotz+"";
$shotz=sprintf("%0.2f", $Cislo);

//sumare za obdobie napocet
//echo $datp_ume." ".$polozka->dat;
if( $polozka->dat >= $datp_ume AND $polozka->dok > 0)
{
$ohotp = $ohotp + $h_hotp;
$Cislo=$ohotp+"";
$sohotp=sprintf("%0.2f", $Cislo);
$ohotv = $ohotv + $h_hotv;
$Cislo=$ohotv+"";
$sohotv=sprintf("%0.2f", $Cislo);
}

$popis=$polozka->pop;

if( $typ == 'PDF' )
{
$ip=$i+1;

$pdf->Cell(12,4,"$ip","0",0,"R");$pdf->Cell(14,4,"$datsk","0",0,"R");$pdf->Cell(15,4,"$polozka->dok","0",0,"R");

$pdf->Cell(12,4,"$polozka->pokc","0",0,"R");$pdf->Cell(7,4,"$polozka->str","0",0,"L");$pdf->Cell(11,4,"$polozka->zak","0",0,"R");
$pdf->Cell(18,4,"$h_hotp","0",0,"R");$pdf->Cell(18,4,"$h_hotv","0",0,"R");$pdf->Cell(18,4,"$shotz","0",0,"R");

$pdf->Cell(18,4,"$polozka->poh","0",0,"R");$pdf->Cell(0,4,"$popis","0",1,"L");


if ( $dajcsv == 1 )
      {
$ehotpcsv = $h_hotp;
$ehotvcsv = $h_hotv;
$ehotscsv = $shotz;

$hotpcsv=str_replace(".",",",$ehotpcsv);
$hotvcsv=str_replace(".",",",$ehotvcsv);
$hotscsv=str_replace(".",",",$ehotscsv);

$text = $ip.";".$datsk.";".$polozka->dok.";".$polozka->pokc.";".$polozka->str.";".$polozka->zak.";".$hotpcsv.";".$hotvcsv.";".$hotscsv.";".$polozka->poh;
$text = $text.";".$polozka->fak.";".$polozka->ico.";".$polozka->nai.";".$popis."\r\n";
fwrite($soubor, $text);
      }


}

if( $typ == 'HTML' )
{
?>

<tr>
<td class="hvstup"><?php echo $polozka->cpl; ?></td>
<td class="hvstup"><?php echo $datsk; ?></td>
<td class="hvstup">
<?php
if( $polozka->pox > 0 AND $polozka->dok > 0  )
{
?>
<?php if( $polozka->psys == 1 )
  { ?>
<?php if( substr($polozka->ucm,0,3) == 211 ) { $hladaj_ucex=$polozka->ucm; $h_ucex=$polozka->ucm; } ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&hladaj_uce=<?php echo $hladaj_ucex;?>&h_uce=<?php echo $h_ucex;?>&rozuct=ANO&copern=8&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranÈho pokladniËnÈho prÌjmovÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho pokladniËnÈho prÌjmovÈho dokladu" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 2 )
  { ?>
<?php if( substr($polozka->ucd,0,3) == 211 ) { $hladaj_ucex=$polozka->ucd; $h_ucex=$polozka->ucd; } ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&hladaj_uce=<?php echo $hladaj_ucex;?>&h_uce=<?php echo $h_ucex;?>&rozuct=ANO&copern=8&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranÈho pokladniËnÈho v˝davkovÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho pokladniËnÈho v˝davkovÈho dokladu" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 3 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=4&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranÈho bankovÈho v˝pisu " ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=4&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho bankovÈho v˝pisu " ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 4 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=5&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranÈho vöeobecnÈho ˙ËtovnÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=5&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho vöeobecnÈho ˙ËtovnÈho dokladu" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 5 )
  { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranej odberateæskej fakt˙ry" ></a>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=NIE&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranej odberateæskej fakt˙ry" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 6 )
  { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranej dod·vateæskej fakt˙ry" ></a>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=NIE&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranej dod·vateæskej fakt˙ry" ></a>
<?php 
  } ?>
<?php
}
?>
<?php echo $polozka->dok;?>

</td>

<td class="hvstup_zlte"><?php echo $polozka->pokc; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $h_hotp; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $h_hotv; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $shotz; ?></td>

<td class="hvstup" align="right"><?php echo $polozka->poh; ?></td>
<td class="hvstup" align="left"><?php echo $polozka->str; ?>/<?php echo $polozka->zak; ?></td>
<td class="hvstup" ><?php echo $popis; ?></td>

</tr>
<?php
}


}
$i = $i + 1;
$j = $j + 1;

//koniec stranky
if( $navysku == 0 ) $konstr=40;
if( $navysku == 1 ) $konstr=60;
if( $j == $konstr )
      {

if( $typ == 'PDF' )
{
//tlac sumare za stranu


}

$strana=$strana+1;
$j=0;
      }
//koniec bloku na koniec stranky



  }
//koniec polozky


if( $typ == 'PDF' )
{
//tlac sumare
$pdf->Cell(71,5,"Spolu za vybranÈ obdobie $vyb_umep / $vyb_umek","1",0,"L");
$pdf->Cell(18,5,"$sohotp","1",0,"R");$pdf->Cell(18,5,"$sohotv","1",1,"R");

$pdf->Cell(71,5,"Spolu celkom","1",0,"L");
$pdf->Cell(18,5,"$shotp","1",0,"R");$pdf->Cell(18,5,"$shotv","1",0,"R");$pdf->Cell(18,5,"$shotz","1",1,"R");


//tlac textu na zostavy
$zostxx = include("../cis/zostxx.php");
//koniec tlac textu na zostavy


if( $dajcsv == 0 )
  {
$pdf->Output("$outfilex");

?> 
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<?php
  }

if( $dajcsv == 1 )
  {
fclose($soubor);
?> 
<br />
<br />
Stiahnite si niûöie uveden˝ s˙bor na V·ö lok·lny disk :
<br />
<br />
  <a href="<?php echo $outfilex; ?>"><?php echo $outfilex; ?></a>
<?php

  }

}
//koniec typ pdf

if( $typ == 'HTML' )
{
?>
<tr>
<td class="bmenu" colspan="4">Spolu za vybranÈ obdobie <?php echo $vyb_umep; ?> / <?php echo $vyb_umek; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $sohotp; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $sohotv; ?></td>
</tr>

<tr>
<td class="bmenu" colspan="3">Spolu celkom</td>
<td class="hvstup_tzlte"></td>
<td class="hvstup_tzlte" align="right"><?php echo $shotp; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $shotv; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $shotz; ?></td>
</tr>

</table>
<?php
}
?>

<?php
//////////////////////////////////////////////////////////////////koniec z PODVOJNEHO
      }
?>

<?php
//////////////////////////////////////////////////////////////////z penazneho JEDNODUCHE
if ( $copern == 10 )
      {

$strana=1;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

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


$pdf->Cell(80,5,"Pohyby $cislo_uce za $vyb_ume","LTB",0,"L");
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',8);

$pdf->Cell(12,4,"Poloûka","1",0,"R");$pdf->Cell(14,4,"D·tum","1",0,"R");$pdf->Cell(15,4,"Doklad","1",0,"R");
$pdf->Cell(12,4,"Pohyb","1",0,"R");$pdf->Cell(18,4,"PrÌjem","1",0,"R");$pdf->Cell(18,4,"V˝davok","1",0,"R");$pdf->Cell(18,4,"Zostatok","1",0,"R");
$pdf->Cell(18,4,"Proti","1",0,"R");$pdf->Cell(0,4,"Popis","1",1,"L");
}


if( $typ == 'HTML' )
{
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" colspan="8"><?php echo "Pohyby ".$cislo_uce." za ".$vyb_ume; ?></td>
<td class="bmenu" colspan="8" align="right"><?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?></td>
</tr>

<tr>
<td class="bmenu" width="7%">Poloûka</td>
<td class="bmenu" width="7%">D·tum</td>
<td class="bmenu" width="10%">Doklad</td>

<td class="hvstup_zlte" width="8%">Pohyb</td>
<td class="hvstup_zlte" width="10%" align="right">PrÌjem</td>
<td class="hvstup_zlte" width="10%" align="right">V˝davok</td>
<td class="hvstup_zlte" width="10%" align="right">Zostatok</td>

<td class="bmenu" width="8%" align="right">Proti</td>
<td class="bmenu" width="30%" >Popis</td>

</tr>
<?php
}

      }
//koniec j=0

//html nestrankuj
if( $typ == 'HTML' ) $j=1;

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);

$h_hotp=0;
$h_hotv=0;
$h_hotp=$polozka->hotp;
$h_hotv=$polozka->hotv;

//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $polozka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);

//sumare napocet
$hotp = $hotp + $h_hotp;
$Cislo=$hotp+"";
$shotp=sprintf("%0.2f", $Cislo);
$hotv = $hotv + $h_hotv;
$Cislo=$hotv+"";
$shotv=sprintf("%0.2f", $Cislo);
$hotz=$hotz+$h_hotp-($h_hotv);
$Cislo=$hotz+"";
$shotz=sprintf("%0.2f", $Cislo);

$popis=$polozka->pop;

if( $typ == 'PDF' )
{

$pdf->Cell(12,4,"$polozka->cpl","0",0,"R");$pdf->Cell(14,4,"$datsk","0",0,"R");$pdf->Cell(15,4,"$polozka->dok","0",0,"R");

$pdf->Cell(12,4,"$polozka->uce","0",0,"R");$pdf->Cell(18,4,"$h_hotp","0",0,"R");$pdf->Cell(18,4,"$h_hotv","0",0,"R");$pdf->Cell(18,4,"$shotz","0",0,"R");

$pdf->Cell(18,4,"$polozka->puc","0",0,"R");$pdf->Cell(0,4,"$popis","0",1,"L");

}

if( $typ == 'HTML' )
{
?>

<tr>
<td class="hvstup"><?php echo $polozka->cpl; ?></td>
<td class="hvstup"><?php echo $datsk; ?></td>
<td class="hvstup">
<?php
if( $polozka->pox > 0 AND $polozka->dok > 0  )
{
?>
<?php if( $polozka->psys == 1 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranÈho pokladniËnÈho prÌjmovÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho pokladniËnÈho prÌjmovÈho dokladu" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 2 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranÈho pokladniËnÈho v˝davkovÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho pokladniËnÈho v˝davkovÈho dokladu" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 3 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=4&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranÈho bankovÈho v˝pisu " ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=4&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho bankovÈho v˝pisu " ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 4 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=5&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranÈho vöeobecnÈho ˙ËtovnÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=5&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho vöeobecnÈho ˙ËtovnÈho dokladu" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 5 )
  { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranej odberateæskej fakt˙ry" ></a>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=NIE&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranej odberateæskej fakt˙ry" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 6 )
  { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranej dod·vateæskej fakt˙ry" ></a>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=NIE&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranej dod·vateæskej fakt˙ry" ></a>
<?php 
  } ?>
<?php
}
?>
<?php echo $polozka->dok;?>

</td>

<td class="hvstup_zlte"><?php echo $polozka->pokc; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $h_hotp; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $h_hotv; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $shotz; ?></td>

<td class="hvstup" align="right"><?php echo $polozka->poh; ?></td>
<td class="hvstup" ><?php echo $popis; ?></td>

</tr>
<?php
}


}
$i = $i + 1;
$j = $j + 1;

//koniec stranky
if( $j == 40 )
      {

if( $typ == 'PDF' )
{
//tlac sumare za stranu


}

$strana=$strana+1;
$j=0;
      }
//koniec bloku na koniec stranky



  }
//koniec polozky


if( $typ == 'PDF' )
{
//tlac sumare
$pdf->Cell(41,5,"Spolu celkom","1",0,"L");
 
$pdf->Cell(12,5," ","1",0,"R");$pdf->Cell(18,5,"$shotp","1",0,"R");$pdf->Cell(18,5,"$shotv","1",0,"R");$pdf->Cell(18,5,"$shotz","1",1,"R");


//tlac textu na zostavy
$zostxx = include("../cis/zostxx.php");
//koniec tlac textu na zostavy

$pdf->Output("../tmp/penden.$kli_uzid.pdf");
?> 
<script type="text/javascript">
  var okno = window.open("../tmp/penden.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php
}


if( $typ == 'HTML' )
{
?>

<tr>
<td class="bmenu" colspan="3">Spolu celkom</td>
<td class="hvstup_tzlte"></td>
<td class="hvstup_tzlte" align="right"><?php echo $shotp; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $shotv; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $shotz; ?></td>
</tr>

</table>
<?php
}
?>

<?php
//////////////////////////////////////////////////////////////////koniec z penazneho JEDNODUCHE
      }
?>


<?php

// celkovy koniec dokumentu

if( $dajcsv == 0 )
{
$cislista = include("uct_lista.php");
}

       } while (false);
?>
</BODY>
</HTML>
