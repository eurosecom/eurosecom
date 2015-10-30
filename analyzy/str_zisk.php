<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];
$typ = $_REQUEST['typ'];
$druhana = 1*$_REQUEST['druhana'];
$csv = 1*$_REQUEST['csv'];

$zana = 1*$_REQUEST['zana'];
if( $zana == 1 ) $sys="ANA";

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

$vyb_ume = 1*$_REQUEST['vyb_ume'];
$cislo_zak = 1*$_REQUEST['cislo_zak'];
$vsetkystr = 1*$_REQUEST['vsetkystr'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


$cit_nas = include("../cis/citaj_nas.php");
$cit_fir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;
if (File_Exists ("../tmp/uobrat.$kli_uzid.pdf")) { $soubor = unlink("../tmp/uobrat.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$h_obdp = 1*$_REQUEST['h_obdp'];
$h_obdk = 1*$_REQUEST['h_obdk'];

$ume_obdp = $h_obdp.".".$kli_vrok;
$ume_obdk = $h_obdk.".".$kli_vrok;


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcuobrats
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
   pmd          DECIMAL(10,2),
   pdl          DECIMAL(10,2),
   bmd          DECIMAL(10,2),
   bdl          DECIMAL(10,2),
   omd          DECIMAL(10,2),
   odl          DECIMAL(10,2),
   zmd          DECIMAL(10,2),
   zdl          DECIMAL(10,2),
   PRIMARY KEY(cpl)
);
prcuobrats;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcuobratsx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $vyb_ume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vrkp=1*$kli_vrok-1;
$dat_poc=$kli_vrok."-01-01";
$ume_poc="01.".$kli_vrok;
$dat_pcc=$kli_vrkp."-12-31";
$ume_pcc="0";


$podmobd="ume <= ".$vyb_ume;
if( $h_obdp > 0 AND $h_obdk > 0  ) { $podmobd="ume >= ".$ume_obdp." AND ume <= ".$ume_obdk; }

$podmumetext=$vyb_ume;
if( $h_obdp > 0 AND $h_obdk > 0  ) { $podmumetext=" ".$ume_obdp." / ".$ume_obdk; }

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
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,F$kli_vxcf"."_$uctovanie.dok,ucm,1,ucd,ucm,ucd,rdp,F$kli_vxcf"."_$uctovanie.ico,F$kli_vxcf"."_$uctovanie.fak,".
"F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak,F$kli_vxcf"."_$uctovanie.hod,F$kli_vxcf"."_$uctovanie.hod,".
"0,0,F$kli_vxcf"."_$doklad.txp,1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ( ucm > 0 OR ucd > 0 ) AND  $podmobd";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,dok,ucm,1,ucd,ucm,ucd,rdp,ico,fak,".
"str,zak,hod,hod,".
"0,0,pop,1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE  $podmobd";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }

//exit;

$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET fak=0  ";
$dsql = mysql_query("$dsqlt");

if( $druhana == 1 )
  {

$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid,F$kli_vxcf"."_zak  ".
" SET fak=sku  ".
" WHERE F$kli_vxcf"."_prcuobrats$kli_uzid.str=F$kli_vxcf"."_zak.str AND F$kli_vxcf"."_prcuobrats$kli_uzid.zak=F$kli_vxcf"."_zak.zak";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET str=fak  ";
$dsql = mysql_query("$dsqlt");

  }

if( $druhana == 2 )
  {

$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid,F$kli_vxcf"."_zak  ".
" SET fak=stv  ".
" WHERE F$kli_vxcf"."_prcuobrats$kli_uzid.str=F$kli_vxcf"."_zak.str AND F$kli_vxcf"."_prcuobrats$kli_uzid.zak=F$kli_vxcf"."_zak.zak";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET str=fak  ";
$dsql = mysql_query("$dsqlt");

  }

//echo "cislo_zak".$cislo_zak;
//exit;

if( $vsetkystr == 0 ) { 

$dsqlt = "DELETE FROM F$kli_vxcf"."_prcuobrats$kli_uzid WHERE str != $cislo_zak ";
$dsql = mysql_query("$dsqlt");
                                   }



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Výsledovka</title>
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
if( $typ == 'HTML' OR $csv == 1 )
{
//#252,170,18
?>
<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Výsledovka PU</td>
<td align="right"><span class="login"><?php echo "UME $vyb_ume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
<?php
}
?>

<?php
//vloz stranu dal
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" psys,1,0,ume,dat,dok,ucd,1,ucm,ucm,ucd,rdp,ico,fak,str,zak,hod,0,hod,0,pop,pox,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE ume <= $vyb_ume AND psys > 0 ";
" ";
$dsql = mysql_query("$dsqlt");

//rozdel do omd,odl
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET pmd=mdt, pdl=dal WHERE cpl >= 0 AND psys = 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET omd=mdt, odl=dal WHERE cpl >= 0 AND psys > 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET bmd=mdt, bdl=dal WHERE cpl >= 0 AND psys > 0  AND ume = $vyb_ume ";
$dsql = mysql_query("$dsqlt");

//vypocitaj zmd,zdl
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zmd=pmd-pdl+omd-odl, zdl=0 WHERE cpl >= 0 ";
$dsql = mysql_query("$dsqlt");

//sumar za ucty
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsy$kli_uzid "." SELECT".
" psys,1,0,ume,dat,dok,uce,999,puc,ucm,ucd,rdp,1,fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,1,".
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl)".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE cpl >= 0 AND ".
" ( LEFT(uce,1) = 5 OR LEFT(uce,1) = 6 OR LEFT(uce,1) = 8 OR LEFT(uce,1) = 9 ) ".
" GROUP BY str,uce".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//vypocitaj zmd,zdl
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid SET zdl=-zmd, zmd=0 WHERE cpl >= 0 AND ur1 = 999 AND zmd < 0 ";
$dsql = mysql_query("$dsqlt");

//sumar za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsy$kli_uzid "." SELECT".
" psys,1999,0,ume,dat,dok,0,1,puc,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,1999,".
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl)".
" FROM F$kli_vxcf"."_prcuobratsy$kli_uzid".
" WHERE ur1 = 999".
" GROUP BY str,pox".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//hosp vysledok pred zdanenim
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsy$kli_uzid "." SELECT".
" psys,1888,0,ume,dat,dok,0,1,puc,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,1888,".
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl)".
" FROM F$kli_vxcf"."_prcuobratsy$kli_uzid".
" WHERE ur1 = 999 AND LEFT(uce,3) != 591".
" GROUP BY str,pox".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//sumar za naklady 5,8
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsy$kli_uzid "." SELECT".
" psys,997,0,ume,dat,dok,0,1,puc,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,997,".
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl)".
" FROM F$kli_vxcf"."_prcuobratsy$kli_uzid".
" WHERE ur1 = 999 AND ( LEFT(uce,1) = 5 OR LEFT(uce,1) = 8 )".
" GROUP BY str,pox".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//sumar za vynosy 6,9
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsy$kli_uzid "." SELECT".
" psys,998,0,ume,dat,dok,0,1,puc,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,998,".
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl)".
" FROM F$kli_vxcf"."_prcuobratsy$kli_uzid".
" WHERE ur1 = 999 AND ( LEFT(uce,1) = 6 OR LEFT(uce,1) = 9 )".
" GROUP BY str,pox".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//SU do fak
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid SET fak=0, fak=LEFT(uce,3) WHERE cpl >= 0";
$dsql = mysql_query("$dsqlt");

//sumar za SU 
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsy$kli_uzid "." SELECT".
" psys,1,0,ume,dat,dok,999999999,998,puc,ucm,ucd,rdp,SUM(ico),fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,1,".
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl)".
" FROM F$kli_vxcf"."_prcuobratsy$kli_uzid".
" WHERE ur1 = 999".
" GROUP BY str,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//vloz pre ocislovanie poloziek
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsx$kli_uzid"." SELECT".
" psys,uro,0,ume,dat,dok,uce,ur1,puc,ucm,ucd,rdp,ico,fak,str,zak,hod,mdt,dal,zos,pop,pox,".
"pmd,pdl,bmd,bdl,omd,odl,zmd,zdl".
" FROM F$kli_vxcf"."_prcuobratsy$kli_uzid".
" WHERE ume <= $vyb_ume ".
" ORDER BY str,pox,fak,uce";
$dsql = mysql_query("$dsqlt");

//HV zisk
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobratsx$kli_uzid SET odl=zdl-zmd WHERE cpl >= 0";
$dsql = mysql_query("$dsqlt");

if( $druhana == 0 )
  {
$sqltt = "SELECT ".
" F$kli_vxcf"."_prcuobratsx$kli_uzid.uce, F$kli_vxcf"."_uctosnova.nuc, F$kli_vxcf"."_prcuobratsx$kli_uzid.pmd, pdl,".
" bmd,bdl,omd,odl,zmd,zdl,ur1,uro,ico,fak, F$kli_vxcf"."_prcuobratsx$kli_uzid.str, F$kli_vxcf"."_str.nst ".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".uce=F$kli_vxcf"."_uctosnova.uce".
" LEFT JOIN F$kli_vxcf"."_str".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".str=F$kli_vxcf"."_str.str".
" WHERE ( ur1 = 999 OR ur1 = 998 OR uro = 998 OR uro = 997 OR uro = 1999 OR uro = 1888 ) ";
" ORDER BY cpl";
  }

if( $druhana == 1 )
  {
$sqltt = "SELECT ".
" F$kli_vxcf"."_prcuobratsx$kli_uzid.uce, F$kli_vxcf"."_uctosnova.nuc, F$kli_vxcf"."_prcuobratsx$kli_uzid.pmd, pdl,".
" bmd,bdl,omd,odl,zmd,zdl,ur1,uro,ico,fak, F$kli_vxcf"."_prcuobratsx$kli_uzid.str, F$kli_vxcf"."_sku.nsu AS nst ".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".uce=F$kli_vxcf"."_uctosnova.uce".
" LEFT JOIN F$kli_vxcf"."_sku".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".str=F$kli_vxcf"."_sku.sku".
" WHERE ( ur1 = 999 OR ur1 = 998 OR uro = 998 OR uro = 997 OR uro = 1999 OR uro = 1888 ) ";
" ORDER BY cpl";
  }

if( $druhana == 2 )
  {
$sqltt = "SELECT ".
" F$kli_vxcf"."_prcuobratsx$kli_uzid.uce, F$kli_vxcf"."_uctosnova.nuc, F$kli_vxcf"."_prcuobratsx$kli_uzid.pmd, pdl,".
" bmd,bdl,omd,odl,zmd,zdl,ur1,uro,ico,fak, F$kli_vxcf"."_prcuobratsx$kli_uzid.str, F$kli_vxcf"."_stv.nsv AS nst ".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".uce=F$kli_vxcf"."_uctosnova.uce".
" LEFT JOIN F$kli_vxcf"."_stv".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".str=F$kli_vxcf"."_stv.stv".
" WHERE ( ur1 = 999 OR ur1 = 998 OR uro = 998 OR uro = 997 OR uro = 1999 OR uro = 1888 ) ";
" ORDER BY cpl";
  }

//echo $druhana.$sqltt;
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


//html nestrankuj
if( $typ == 'HTML' ) $j=1;

  if (@$zaznam=mysql_data_seek($sql,$i) OR $i == 0 )
{
$polozka=mysql_fetch_object($sql);

//ak je nulova polozka daj medzeru

$h_hod=$polozka->hod;
if( $polozka->hod == 0 ) $h_hod="";

//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $polozka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);

if ( $j == 0 )
      {

if( $typ == 'PDF' )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

if( $druhana == 0 )
  {
$pdf->Cell(110,5,"Výsledovka za STREDISKÁ za $podmumetext","LTB",0,"L");
$pdf->Cell(167,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
  }
if( $druhana == 1 )
  {
$pdf->Cell(110,5,"Výsledovka za SKUPINY za $podmumetext","LTB",0,"L");
$pdf->Cell(167,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
  }
if( $druhana == 2 )
  {
$pdf->Cell(110,5,"Výsledovka za STAVBY za $podmumetext","LTB",0,"L");
$pdf->Cell(167,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
  }

$pdf->SetFont('arial','',8);
$pdf->Cell(19,4,"Úèet","1",0,"R");
$pdf->Cell(128,4,"Popis","1",0,"L");
$pdf->Cell(30,4,"Bežný mesiac MáDa","1",0,"R");$pdf->Cell(30,4,"Bežný mesiac Dal","1",0,"R");
$pdf->Cell(35,4,"Celý rok MáDa","1",0,"R");$pdf->Cell(35,4,"Celý rok Dal","1",1,"R");

$pdf->Cell(35,2," ","0",1,"R");
$pdf->Cell(110,4,"Stredisko $polozka->str $polozka->nst","B",1,"L");
$pdf->Cell(35,2," ","0",1,"R");

}

$strana=$strana+1;

$str_hod = 0.00;

      }
//koniec j=0


if( $typ == 'PDF' )
{

if( $polozka->ur1 == 999 )
   {
//tlac sumaz za ucet
$pdf->Cell(19,4,"$polozka->uce","0",0,"R");
$pdf->Cell(128,4,"$polozka->nuc","0",0,"L");
$pdf->Cell(30,4,"$polozka->bmd","0",0,"R");$pdf->Cell(30,4,"$polozka->bdl","0",0,"R");
$pdf->Cell(35,4,"$polozka->zmd","0",0,"R");$pdf->Cell(35,4,"$polozka->zdl","0",1,"R");
   }

if( $polozka->ur1 == 998 AND $polozka->ico > 1 )
   {
//tlac sumar za SU
$pdf->Cell(19,4," ","T",0,"R");
$pdf->Cell(128,4,"SU$polozka->fak","T",0,"L");
$pdf->Cell(30,4,"$polozka->bmd","T",0,"R");$pdf->Cell(30,4,"$polozka->bdl","T",0,"R");
$pdf->Cell(35,4,"$polozka->zmd","T",0,"R");$pdf->Cell(35,4,"$polozka->zdl","T",1,"R");
   }


if( $polozka->uro == 997 )
   {
//tlac sumare trieda 5
$pdf->Cell(277,2," ","0",1,"R");
$pdf->Cell(49,4,"Celkom trieda 5","T",0,"L");
$pdf->Cell(98,4," ","T",0,"R");
$pdf->Cell(30,4,"$polozka->bmd","T",0,"R");$pdf->Cell(30,4,"$polozka->bdl","T",0,"R");
$pdf->Cell(35,4,"$polozka->zmd","T",0,"R");$pdf->Cell(35,4,"$polozka->zdl","T",1,"R");

   }

if( $polozka->uro == 998 )
   {
//tlac sumare trieda 6
$pdf->Cell(277,2," ","0",1,"R");
$pdf->Cell(49,4,"Celkom trieda 6","T",0,"L");
$pdf->Cell(98,4," ","T",0,"R");
$pdf->Cell(30,4,"$polozka->bmd","T",0,"R");$pdf->Cell(30,4,"$polozka->bdl","T",0,"R");
$pdf->Cell(35,4,"$polozka->zmd","T",0,"R");$pdf->Cell(35,4,"$polozka->zdl","T",1,"R");

   }

if( $polozka->uro == 1888 )
   {
//tlac sumare VSETKO
$hvpz=$polozka->odl;

   }

if( $polozka->uro == 1999 )
   {
//tlac sumare VSETKO
$pdf->Cell(277,2," ","0",1,"R");
$pdf->Cell(49,4,"Celkom všetky úèty","LTB",0,"L");
$pdf->Cell(98,4," ","RTB",0,"R");
$pdf->Cell(30,4,"$polozka->bmd","1",0,"R");$pdf->Cell(30,4,"$polozka->bdl","1",0,"R");
$pdf->Cell(35,4,"$polozka->zmd","1",0,"R");$pdf->Cell(35,4,"$polozka->zdl","1",1,"R");
$pdf->Cell(35,4," ","0",1,"R");
$pdf->Cell(70,4,"Hospodársky výsledok pred zdanením: ","1",0,"L");$pdf->Cell(40,4,"$hvpz","1",1,"R");
$pdf->Cell(70,4,"Hospodársky výsledok po zdanení: ","1",0,"L");$pdf->Cell(40,4,"$polozka->odl","1",1,"R");
$j=-1;
$zisk=$polozka->odl;
   }
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

$j=0;
      }
//koniec bloku na koniec stranky


  }
//koniec polozky


if( $typ == 'PDF' AND $html == 0 AND $cislo_zak > 0 )
  {

//ekonomicke ukazovatele
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcekonukaz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcuobrats
(
   psys         INT DEFAULT 0,
   prid         DECIMAL(10,2) DEFAULT 0,
   odph         DECIMAL(10,2) DEFAULT 0,
   nakl         DECIMAL(10,2) DEFAULT 0,
   vyko         DECIMAL(10,2) DEFAULT 0,
   matn         DECIMAL(10,2) DEFAULT 0,
   mzdn         DECIMAL(10,2) DEFAULT 0,
   naklx        DECIMAL(10,2) DEFAULT 0,
   matx         DECIMAL(10,2) DEFAULT 0,
   mzdx         DECIMAL(10,2) DEFAULT 0,
   prdp         DECIMAL(10,2) DEFAULT 0,
   prdh         DECIMAL(10,2) DEFAULT 0,
   rentd        DECIMAL(10,2) DEFAULT 0,
   renth        DECIMAL(10,2) DEFAULT 0,
   rent         DECIMAL(10,2) DEFAULT 0,
   prmzd        DECIMAL(10,2) DEFAULT 0,
   vyrsp        DECIMAL(10,2) DEFAULT 0,
   mzdp         DECIMAL(10,2) DEFAULT 0,
   icx          INT DEFAULT 0
);
prcuobrats;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcekonukaz'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$ttvv = "INSERT INTO F$kli_vxcf"."_prcekonukaz".$kli_uzid." ( psys,icx  ) VALUES ( 0,0 )";
$ttqq = mysql_query("$ttvv");

$prid=0;

$sqltttvyb = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid ".
" WHERE ( ur1 = 999 AND ( LEFT(uce,1) = 6 OR LEFT(uce,3) = 900 OR LEFT(uce,3) = 501 OR LEFT(uce,3) = 504 OR LEFT(uce,3) = 518 OR LEFT(uce,3) = 800 ) ) ";
$sqlvyb = mysql_query("$sqltttvyb");
$ivyb=0;
$polvyb = mysql_num_rows($sqlvyb);

while ($ivyb <= $polvyb )  {
  if (@$zaznamvyb=mysql_data_seek($sqlvyb,$ivyb))
{
$vyblozka=mysql_fetch_object($sqlvyb);
$prid=$prid+$vyblozka->zdl-$vyblozka->zmd;
} $ivyb = $ivyb + 1;       }


$renth=0;

$sqltttvyb = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid ".
" WHERE ( ur1 = 999 AND ( LEFT(uce,1) = 6 OR LEFT(uce,1) = 5 OR LEFT(uce,3) = 900 OR LEFT(uce,3) = 800 ) ) ";
$sqlvyb = mysql_query("$sqltttvyb");
$ivyb=0;
$polvyb = mysql_num_rows($sqlvyb);

while ($ivyb <= $polvyb )  {
  if (@$zaznamvyb=mysql_data_seek($sqlvyb,$ivyb))
{
$vyblozka=mysql_fetch_object($sqlvyb);
$renth=$renth+$vyblozka->zdl-$vyblozka->zmd;
} $ivyb = $ivyb + 1;       }

$rentd=0;

$sqltttvyb = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid ".
" WHERE ( ur1 = 999 AND ( LEFT(uce,1) = 6 OR LEFT(uce,3) = 900 ) ) ";
$sqlvyb = mysql_query("$sqltttvyb");
$ivyb=0;
$polvyb = mysql_num_rows($sqlvyb);

while ($ivyb <= $polvyb )  {
  if (@$zaznamvyb=mysql_data_seek($sqlvyb,$ivyb))
{
$vyblozka=mysql_fetch_object($sqlvyb);
$rentd=$rentd+$vyblozka->zdl-$vyblozka->zmd;
} $ivyb = $ivyb + 1;       }

$nakl=0;

$sqltttvyb = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid ".
" WHERE ( ur1 = 999 AND ( LEFT(uce,1) = 5 OR LEFT(uce,3) = 800 ) ) ";
$sqlvyb = mysql_query("$sqltttvyb");
$ivyb=0;
$polvyb = mysql_num_rows($sqlvyb);

while ($ivyb <= $polvyb )  {
  if (@$zaznamvyb=mysql_data_seek($sqlvyb,$ivyb))
{
$vyblozka=mysql_fetch_object($sqlvyb);
$nakl=$nakl+$vyblozka->zmd-$vyblozka->zdl;
} $ivyb = $ivyb + 1;       }

$matn=0;

$sqltttvyb = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid ".
" WHERE ( ur1 = 999 AND LEFT(uce,3) = 501 ) ";
$sqlvyb = mysql_query("$sqltttvyb");
$ivyb=0;
$polvyb = mysql_num_rows($sqlvyb);

while ($ivyb <= $polvyb )  {
  if (@$zaznamvyb=mysql_data_seek($sqlvyb,$ivyb))
{
$vyblozka=mysql_fetch_object($sqlvyb);
$matn=$matn+$vyblozka->zmd-$vyblozka->zdl;
} $ivyb = $ivyb + 1;       }

$mzdn=0;

$sqltttvyb = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid ".
" WHERE ( ur1 = 999 AND ( LEFT(uce,3) = 521 OR LEFT(uce,3) = 522 ) ) ";
$sqlvyb = mysql_query("$sqltttvyb");
$ivyb=0;
$polvyb = mysql_num_rows($sqlvyb);

while ($ivyb <= $polvyb )  {
  if (@$zaznamvyb=mysql_data_seek($sqlvyb,$ivyb))
{
$vyblozka=mysql_fetch_object($sqlvyb);
$mzdn=$mzdn+$vyblozka->zmd-$vyblozka->zdl;
} $ivyb = $ivyb + 1;       }


$vyrsp=0;

$sqltttvyb = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid ".
" WHERE ( ur1 = 999 AND ( LEFT(uce,3) = 501 OR LEFT(uce,3) = 518 OR LEFT(uce,3) = 800 ) ) ";
$sqlvyb = mysql_query("$sqltttvyb");
$ivyb=0;
$polvyb = mysql_num_rows($sqlvyb);

while ($ivyb <= $polvyb )  {
  if (@$zaznamvyb=mysql_data_seek($sqlvyb,$ivyb))
{
$vyblozka=mysql_fetch_object($sqlvyb);
$vyrsp=$vyrsp+$vyblozka->zmd-$vyblozka->zdl;
} $ivyb = $ivyb + 1;       }

$odph=0;

$sqltttvyb = "SELECT * FROM F$kli_vxcf"."_mzdzalvy ".
" WHERE str = $cislo_zak AND dm >= 100 AND dm <= 599 ";
//echo $sqltttvyb;
//exit;
$sqlvyb = mysql_query("$sqltttvyb");
$ivyb=0;
$polvyb = mysql_num_rows($sqlvyb);

while ($ivyb <= $polvyb )  {
  if (@$zaznamvyb=mysql_data_seek($sqlvyb,$ivyb))
{
$vyblozka=mysql_fetch_object($sqlvyb);
$odph=$odph+$vyblozka->hod;
} $ivyb = $ivyb + 1;       }

//vypocty

$sqlupr = "UPDATE F$kli_vxcf"."_prcekonukaz$kli_uzid SET ".
" prid='$prid', rentd='$rentd', renth='$renth', vyko='$rentd', nakl='$nakl', matn='$matn', mzdn='$mzdn', odph='$odph', vyrsp=$vyrsp ";
$sqlupx = mysql_query("$sqlupr");

$sqlupr = "UPDATE F$kli_vxcf"."_prcekonukaz$kli_uzid SET rent=renth/rentd WHERE rentd != 0 ";
$sqlupx = mysql_query("$sqlupr");

$sqlupr = "UPDATE F$kli_vxcf"."_prcekonukaz$kli_uzid SET naklx=(nakl/vyko)*100, matx=(matn/vyko)*100, mzdx=(mzdn/vyko)*100  WHERE vyko != 0 ";
$sqlupx = mysql_query("$sqlupr");

$sqlupr = "UPDATE F$kli_vxcf"."_prcekonukaz$kli_uzid SET prdp=vyko/odph, prdh=prid/odph, prmzd=mzdn/odph WHERE odph != 0 ";
$sqlupx = mysql_query("$sqlupr");

$sqlupr = "UPDATE F$kli_vxcf"."_prcekonukaz$kli_uzid SET mzdp=mzdn/prid  WHERE odph != 0 ";
$sqlupx = mysql_query("$sqlupr");

//este vypocitaj
//prdp=(vyko/poch)
//prhp=(prdh/poch)
//prmz=(m521/poch)


$sqlttteko = "SELECT * FROM F$kli_vxcf"."_prcekonukaz$kli_uzid ";
$sqleko = mysql_query("$sqlttteko");

  if (@$zaznameko=mysql_data_seek($sqleko,0))
{
$ekolozka=mysql_fetch_object($sqleko);

$pdf->Cell(0,5," ","0",1,"R");
$pdf->Cell(110,4,"Ekonomické ukazovatele ","1",1,"L");
$pdf->Cell(70,4," 1. Tržby z predaja  ","1",0,"L");$pdf->Cell(40,4,"$ekolozka->vyko","1",1,"R");
$pdf->Cell(70,4," 2. Náklady spolu  ","1",0,"L");$pdf->Cell(40,4,"$ekolozka->nakl","1",1,"R");
$pdf->Cell(70,4," 3. Mzdové náklady  ","1",0,"L");$pdf->Cell(40,4,"$ekolozka->mzdn","1",1,"R");
$pdf->Cell(70,4," 4. Materiálové náklady  ","1",0,"L");$pdf->Cell(40,4,"$ekolozka->matn","1",1,"R");
$pdf->Cell(70,4," 5. Výrobná spotreba  ","1",0,"L");$pdf->Cell(40,4,"$ekolozka->vyrsp","1",1,"R");
$pdf->Cell(70,4," 6. Pridaná hodnota ","1",0,"L");$pdf->Cell(40,4,"$ekolozka->prid","1",1,"R");
$pdf->Cell(70,4," 7. Zisk ","1",0,"L");$pdf->Cell(40,4,"$zisk","1",1,"R");
$pdf->Cell(70,4," 8. Rentabilita ","1",0,"L");$pdf->Cell(40,4,"$ekolozka->rent","1",1,"R");
$pdf->Cell(70,4," 9. Poèet odpracovaných hodín ","1",0,"L");$pdf->Cell(40,4,"$ekolozka->odph","1",1,"R");
$pdf->Cell(70,4,"10. Náklady na 100Eur výkonov ","1",0,"L");$pdf->Cell(40,4,"$ekolozka->naklx","1",1,"R");
$pdf->Cell(70,4,"11. Materiálové Náklady na 100Eur výkonov ","1",0,"L");$pdf->Cell(40,4,"$ekolozka->matx","1",1,"R");
$pdf->Cell(70,4,"12. Mzdové Náklady na 100Eur výkonov ","1",0,"L");$pdf->Cell(40,4,"$ekolozka->mzdx","1",1,"R");
$pdf->Cell(70,4,"13. Produktivita práce ","1",0,"L");$pdf->Cell(40,4,"$ekolozka->prdp","1",1,"R");
$pdf->Cell(70,4,"14. Produktivita práce z pridanej hodnoty ","1",0,"L");$pdf->Cell(40,4,"$ekolozka->prdh","1",1,"R");
$pdf->Cell(70,4,"15. Mzdové Náklady na pridanú hodnotu ","1",0,"L");$pdf->Cell(40,4,"$ekolozka->mzdp","1",1,"R");
$pdf->Cell(70,4,"16. Priemerné mzdové náklady na hodinu ","1",0,"L");$pdf->Cell(40,4,"$ekolozka->prmzd","1",1,"R");
}

  }
//koniec ekonomicke ukazovatele


if( $typ == 'PDF' AND $csv == 0  )
{

$pdf->Output("../tmp/uobrat.$kli_uzid.pdf");
?> 
<script type="text/javascript">
  var okno = window.open("../tmp/uobrat.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php
}


if( $typ == 'HTML' )
{
?>

<?php
}

//export csv
if( $csv == 1 )
{

$nazsub="vyslstr";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");


$sqltt = "SELECT ".
" F$kli_vxcf"."_prcuobratsx$kli_uzid.uce, F$kli_vxcf"."_uctosnova.nuc, F$kli_vxcf"."_prcuobratsx$kli_uzid.pmd, pdl,".
" bmd,bdl,omd,odl,zmd,zdl,ur1,uro,ico,fak, F$kli_vxcf"."_prcuobratsx$kli_uzid.str, F$kli_vxcf"."_str.nst ".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".uce=F$kli_vxcf"."_uctosnova.uce".
" LEFT JOIN F$kli_vxcf"."_str".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".str=F$kli_vxcf"."_str.str".
" WHERE ur1 = 999 ";
" ORDER BY cpl";


$sql = mysql_query("$sqltt");
if($sql)                                                      
      {
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$das_sk=SkDatum($hlavicka->das);
$dat_sk=SkDatum($hlavicka->dat);
$dau_sk=SkDatum($hlavicka->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk=$dau_sk;

if( $i == 0 )
     {
  $text = "stredisko".";"."str nazov".";"."ucet".";"."nazov".";"."zostatok madat".";"."zostatok dal"."\r\n"; 

  fwrite($soubor, $text);

     }

$zmd=$hlavicka->zmd; $ezmd=str_replace(".",",",$zmd); 
$zdl=$hlavicka->zdl; $ezdl=str_replace(".",",",$zdl);
$zos=$hlavicka->zos; $ezos=str_replace(".",",",$zos);

  $text = $hlavicka->str.";".$hlavicka->nst.";".$hlavicka->uce.";".$hlavicka->nuc.";".$ezmd.";".$ezdl."\r\n"; 

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }
      }

fclose($soubor);


?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>


<?php
//koniec export csv
}

?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
