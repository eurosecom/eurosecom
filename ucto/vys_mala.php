<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 1000;
$analyzy = 1*$_REQUEST['analyzy']; 
if( $analyzy == 1 ) { $sys='ANA'; $urov=1000; }
$copern = $_REQUEST['copern'];
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

$vyb_ume = 1*$_REQUEST['vyb_ume'];
$synt = 1*$_REQUEST['synt'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


$cit_nas = include("../cis/citaj_nas.php");
$cit_fir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$h_obdp = 1*$_REQUEST['h_obdp'];
$h_obdk = 1*$_REQUEST['h_obdk'];
if( $h_obdp == 0 ) $h_obdp=1;
if( $h_obdk == 0 ) $h_obdk=12;

$mes_obdp=$h_obdp.".".$kli_vrok;
$mes_obdk=$h_obdk.".".$kli_vrok;
//zmaz < $obdp len ak je z mesacnych

$obdx = 1*$_REQUEST['obdx'];

if( $alchem == 1 AND $kli_uzid == 17 AND $kli_vxcf == 513 )
{
$uprtxt = "UPDATE F513_uctpokuct,F513_uctpopisy SET ".
" F513_uctpokuct.pop=F513_uctpopisy.pop ".
" WHERE F513_uctpokuct.dok=F513_uctpopisy.dok AND F513_uctpokuct.ucm=F513_uctpopisy.ucm AND ".
" F513_uctpokuct.ucd=F513_uctpopisy.ucd AND F513_uctpokuct.hod=F513_uctpopisy.hod AND F513_uctpokuct.pop = '' "; 
//$upravene = mysql_query("$uprtxt");
}

if (File_Exists ("../tmp/uobrat.$kli_uzid.pdf")) { $soubor = unlink("../tmp/uobrat.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


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


//zober pociatocny stav uctov
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" 0,1,0,$ume_pcc,'$dat_pcc',0,F$kli_vxcf"."_uctosnova.uce,1,0,F$kli_vxcf"."_uctosnova.uce,".
"0,0,0,0,0,0,F$kli_vxcf"."_uctosnova.pmd,F$kli_vxcf"."_uctosnova.pmd,0,0,'poèiatoèný stav',1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pmd != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" 0,1,0,$ume_pcc,'$dat_pcc',0,F$kli_vxcf"."_uctosnova.uce,1,0,0,F$kli_vxcf"."_uctosnova.uce,".
"0,0,0,0,0,F$kli_vxcf"."_uctosnova.pda,0,F$kli_vxcf"."_uctosnova.pda,0,'poèiatoèný stav',1,0,0,0,0,0,0,0,0".
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

//echo $vyb_ume;

if( $psys <= 6 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,F$kli_vxcf"."_$uctovanie.dok,ucm,1,ucd,ucm,ucd,rdp,F$kli_vxcf"."_$uctovanie.ico,F$kli_vxcf"."_$uctovanie.fak,".
"F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak,sum(F$kli_vxcf"."_$uctovanie.hod),SUM(F$kli_vxcf"."_$uctovanie.hod),".
"0,0,F$kli_vxcf"."_$doklad.txp,1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ( ucm > 0 OR ucd > 0 ) AND ume <= $vyb_ume GROUP BY ume,ucm,ucd";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,dok,ucm,1,ucd,ucm,ucd,rdp,ico,fak,".
"str,zak,SUM(hod),SUM(hod),".
"0,0,pop,1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE ume <= $vyb_ume  GROUP BY ume,ucm,ucd";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }

//exit;

if( $obdx == 1 AND $h_obdp > 1 )
{

$dsqlt = "DELETE FROM F$kli_vxcf"."_prcuobrats$kli_uzid  WHERE ume < $mes_obdp ";
$dsql = mysql_query("$dsqlt");

}


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
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
if( $typ == 'HTML' )
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
" psys,1,0,ume,dat,dok,ucd,1,ucm,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),0,SUM(hod),0,pop,pox,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE ume <= $vyb_ume AND psys > 0 GROUP BY ume,ucm,ucd";
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
" GROUP BY uce".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//vypocitaj zmd,zdl
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid SET zdl=-zmd, zmd=0 WHERE cpl >= 0 AND ur1 = 999 AND zmd < 0 ";
$dsql = mysql_query("$dsqlt");

//sumar za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsy$kli_uzid "." SELECT".
" psys,1999,0,ume,dat,dok,0,1,puc,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,1999,".
"SUM(pmd),SUM(pdl),0,SUM(bdl-bmd),SUM(omd),SUM(odl),0,SUM(zdl-zmd)".
" FROM F$kli_vxcf"."_prcuobratsy$kli_uzid".
" WHERE ur1 = 999".
" GROUP BY pox".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//hosp vysledok pred zdanenim
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsy$kli_uzid "." SELECT".
" psys,1888,0,ume,dat,dok,0,1,puc,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,1888,".
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl)".
" FROM F$kli_vxcf"."_prcuobratsy$kli_uzid".
" WHERE ur1 = 999 AND LEFT(uce,2) != 59 ".
" GROUP BY pox".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//sumar za naklady 5,8
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsy$kli_uzid "." SELECT".
" psys,997,0,ume,dat,dok,0,1,puc,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,997,".
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl)".
" FROM F$kli_vxcf"."_prcuobratsy$kli_uzid".
" WHERE ur1 = 999 AND ( LEFT(uce,1) = 5 OR LEFT(uce,1) = 8 )".
" GROUP BY pox".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//sumar za vynosy 6,9
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsy$kli_uzid "." SELECT".
" psys,998,0,ume,dat,dok,0,1,puc,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,998,".
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl)".
" FROM F$kli_vxcf"."_prcuobratsy$kli_uzid".
" WHERE ur1 = 999 AND ( LEFT(uce,1) = 6 OR LEFT(uce,1) = 9 )".
" GROUP BY pox".
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
" GROUP BY fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

if( $synt == 1 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid SET zmd=zmd-zdl, zdl=0 WHERE cpl >= 0 AND ur1 = 998 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid SET zdl=-zmd, zmd=0 WHERE cpl >= 0 AND ur1 = 998 AND zmd < 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid SET bmd=bmd-bdl, bdl=0 WHERE cpl >= 0 AND ur1 = 998 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid SET bdl=-bmd, bmd=0 WHERE cpl >= 0 AND ur1 = 998 AND bmd < 0 ";
$dsql = mysql_query("$dsqlt");
}

//vloz pre ocislovanie poloziek
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsx$kli_uzid"." SELECT".
" psys,uro,0,ume,dat,dok,uce,ur1,puc,ucm,ucd,rdp,ico,fak,str,zak,hod,mdt,dal,zos,pop,pox,".
"pmd,pdl,bmd,bdl,omd,odl,zmd,zdl".
" FROM F$kli_vxcf"."_prcuobratsy$kli_uzid".
" WHERE ume <= $vyb_ume ".
" ORDER BY pox,fak,uce";
$dsql = mysql_query("$dsqlt");

//HV zisk
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobratsx$kli_uzid SET odl=zdl-zmd WHERE cpl >= 0";
$dsql = mysql_query("$dsqlt");

//zapis do statistickej zostavy rocny r101
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 10101 )
{
?>
<script type="text/javascript">

window.open('../ucto/statistika_r101nacitaj.php?copern=1&drupoh=1&page=1&zvysl=1', '_self' )

</script>
<?php
exit;
}
//koniec zapis do statistickej zostavy rocny r101

//zapis do statistickej TABLE a prepni do stat zostavy modul 82
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 1304 )
{
$r01=0; $r02=0; $r03=0; $r04=0; $r05=0; $r06=0; $r07=0; $r08=0; $r09=0; $r10=0; $r99=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE uro = 998 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
if (@$zaznam=mysql_data_seek($sql,0)) { $polozka=mysql_fetch_object($sql); $r01=$polozka->zdl-$polozka->zmd; }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 601 OR LEFT(uce,3) = 602 OR LEFT(uce,3) = 606 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02=$r02+$polozka->zdl-$polozka->zmd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 604 OR LEFT(uce,3) = 607 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r03=$r03+$polozka->zdl-$polozka->zmd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND LEFT(uce,1) = 5 AND LEFT(uce,2) != 59 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r04=$r04+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND (  LEFT(uce,3) = 501 OR LEFT(uce,3) = 502 OR LEFT(uce,3) = 503 OR LEFT(uce,2) = 51 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r05=$r05+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND (  LEFT(uce,3) = 549 OR LEFT(uce,3) = 582 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r06=$r06+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 504 OR LEFT(uce,3) = 507 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r07=$r07+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND  LEFT(uce,3) = 551 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r08=$r08+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ".
" ( LEFT(uce,3) = 601 OR LEFT(uce,3) = 602 OR LEFT(uce,3) = 604 OR LEFT(uce,3) = 606 OR LEFT(uce,3) = 607 ".
" OR LEFT(uce,3) = 504 OR LEFT(uce,2) = 61 OR LEFT(uce,2) = 62 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r09=$r09+$polozka->zdl-$polozka->zmd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE uro = 1888 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
if (@$zaznam=mysql_data_seek($sql,0)) { $polozka=mysql_fetch_object($sql); $r10=$polozka->zdl-$polozka->zmd; }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p1304 SET ".
" mod82r01='$r01', mod82r02='$r02', mod82r03='$r03', mod82r04='$r04', mod82r05='$r05', mod82r06='$r06', mod82r07='$r07', mod82r08='$r08', ".
" mod82r09='$r09', mod82r10='$r10',".
" mod82r99=mod82r01+mod82r02+mod82r03+mod82r04+mod82r05+mod82r06+mod82r07+mod82r08+mod82r09+mod82r10".
" WHERE ico >= 0"; 
//echo $uprtxt;
//exit;
$upravene = mysql_query("$uprtxt");

$rok1304="";
if( $kli_vrok < 2016 ) $rok1304="_2015";
if( $kli_vrok < 2014 ) $rok1304="_2013";
if( $kli_vrok < 2012 ) $rok1304="_2011";  
?>
<script type="text/javascript">

window.open('../ucto/statistika_p1304<?php echo $rok1304; ?>.php?copern=1&drupoh=1&page=1&modul=82', '_self' )

</script>
<?php
}

//zapis do statistickej TABLE a prepni do stat zostavy modul 145(82)
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 304 )
{
$r01=0; $r02=0; $r03=0; $r04=0; $r05=0; $r06=0; $r07=0; $r08=0; $r09=0; $r10=0; $r99=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE uro = 998 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
if (@$zaznam=mysql_data_seek($sql,0)) { $polozka=mysql_fetch_object($sql); $r01=$polozka->zdl-$polozka->zmd; }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 601 OR LEFT(uce,3) = 602 OR LEFT(uce,3) = 604 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02=$r02+$polozka->zdl-$polozka->zmd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND (  LEFT(uce,1) = 5 AND LEFT(uce,2) != 59 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r03=$r03+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE uro = 1888 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
if (@$zaznam=mysql_data_seek($sql,0)) { $polozka=mysql_fetch_object($sql); $r04=$polozka->zdl-$polozka->zmd; }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 601 OR LEFT(uce,3) = 602 OR LEFT(uce,3) = 604 ".
"  OR LEFT(uce,2) = 61 OR LEFT(uce,2) = 62 OR LEFT(uce,3) = 504 OR LEFT(uce,3) = 501 OR LEFT(uce,3) = 502 OR LEFT(uce,3) = 503 OR LEFT(uce,2) = 51 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r05=$r05+$polozka->zdl-$polozka->zmd; }
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod82r01='$r01', mod82r02='$r02', mod82r03='$r03', mod82r04='$r04', mod82r05='$r05', mod82r06='$r06', mod82r07='$r07', mod82r08='$r08', ".
" mod82r09='$r09', mod82r10='$r10',".
" mod82r99=mod82r01+mod82r02+mod82r03+mod82r04+mod82r05+mod82r06+mod82r07+mod82r08+mod82r09+mod82r10, mod82r04=mod82r01-mod82r03 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");  

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod82r04=mod82r01-mod82r03 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod82r99=mod82r01+mod82r02+mod82r03+mod82r04+mod82r05+mod82r06+mod82r07+mod82r08+mod82r09+mod82r10 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");  
?>
<script type="text/javascript">

window.open('../ucto/statistika_p304.php?copern=1&drupoh=1&page=1&modul=82', '_self' )

</script>
<?php
}

$osnova=5;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ( ur1 = 999 AND uce > 99999 ) ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
if( $pol > 20 ) $osnova=6;

if( $osnova == 5 AND $synt == 1 )
{
$sqltt = "UPDATE F$kli_vxcf"."_prcuobratsx$kli_uzid SET fak=100*fak WHERE ( ur1 = 998 ) ";
$sql = mysql_query("$sqltt");
}
if( $osnova == 6 AND $synt == 1 )
{
$sqltt = "UPDATE F$kli_vxcf"."_prcuobratsx$kli_uzid SET fak=1000*fak WHERE ( ur1 = 998 ) ";
$sql = mysql_query("$sqltt");
}

if( $synt == 0 )
{
$sqltt = "SELECT ".
" F$kli_vxcf"."_prcuobratsx$kli_uzid.uce, F$kli_vxcf"."_uctosnova.nuc, F$kli_vxcf"."_prcuobratsx$kli_uzid.pmd, pdl,".
" bmd,bdl,omd,odl,zmd,zdl,ur1,uro,ico,fak ".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".uce=F$kli_vxcf"."_uctosnova.uce".
" WHERE ( ur1 = 999 OR ur1 = 998 OR uro = 998 OR uro = 997 OR uro = 1999 OR uro = 1888 ) ";
" ORDER BY cpl";
//echo $sqltt;
}
if( $synt == 1 )
{
$sqltt = "SELECT ".
" F$kli_vxcf"."_prcuobratsx$kli_uzid.uce, F$kli_vxcf"."_uctosnova.nuc, F$kli_vxcf"."_prcuobratsx$kli_uzid.pmd, pdl,".
" bmd,bdl,omd,odl,zmd,zdl,ur1,uro,ico,fak ".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".fak=F$kli_vxcf"."_uctosnova.uce".
" WHERE ( ur1 = 999 OR ur1 = 998 OR uro = 998 OR uro = 997 OR uro = 1999 OR uro = 1888 ) ";
" ORDER BY cpl";
//echo $sqltt;
}

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

if( $synt == 0 )
{
$pdf->Cell(110,5,"Výsledovka za $mes_obdp / $mes_obdk","LTB",0,"L");
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',8);
$pdf->Cell(15,4,"Úèet","1",0,"R");
$pdf->Cell(110,4,"Popis","1",0,"L");
$pdf->Cell(30,4,"$vyb_ume MáDa","1",0,"R");$pdf->Cell(30,4,"$vyb_ume Dal","1",0,"R");$pdf->Cell(30,4,"$vyb_ume Rozdiel","1",0,"R");
$pdf->Cell(32,4,"Celý rok MáDa","1",0,"R");$pdf->Cell(0,4,"Celý rok Dal","1",1,"R");
}

if( $synt == 1 )
{
$pdf->Cell(110,5,"Výsledovka za $mes_obdp / $mes_obdk","LTB",0,"L");
$pdf->Cell(167,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',8);
$pdf->Cell(19,4,"Úèet","1",0,"R");
$pdf->Cell(128,4,"Popis","1",0,"L");
$pdf->Cell(30,4,"Bežný mesiac MáDa","1",0,"R");$pdf->Cell(30,4,"Bežný mesiac Dal","1",0,"R");
$pdf->Cell(35,4,"Celý rok MáDa","1",0,"R");$pdf->Cell(35,4,"Celý rok Dal","1",1,"R");
}


$j=1;
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

$mesroz=$polozka->bmd-$polozka->bdl;
$Cislo=$mesroz+"";
$mesroz=sprintf("%0.2f", $Cislo);
if( $mesroz == 0 ) $mesroz="";

$h_hod=$polozka->hod;
if( $polozka->hod == 0 ) $h_hod="";

//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $polozka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);

$nuc=substr($polozka->nuc,0,110);

//zaciatok analyticka
if( $typ == 'PDF' AND $synt == 0 )
{
if( $polozka->ur1 == 999 )
   {
//tlac sumaz za ucet
$pdf->Cell(15,4,"$polozka->uce","0",0,"R");
$pdf->Cell(110,4,"$nuc","0",0,"L");
$pdf->Cell(30,4,"$polozka->bmd","0",0,"R");$pdf->Cell(30,4,"$polozka->bdl","0",0,"R");$pdf->Cell(30,4,"$mesroz","0",0,"R");
$pdf->Cell(32,4,"$polozka->zmd","0",0,"R");$pdf->Cell(0,4,"$polozka->zdl","0",1,"R");
$j = $j + 1;
   }

if( $polozka->ur1 == 998 AND $polozka->ico > 1 )
   {
//tlac sumar za SU
$pdf->Cell(15,4," ","T",0,"R");
$pdf->Cell(110,4,"SU$polozka->fak","T",0,"L");
$pdf->Cell(30,4,"$polozka->bmd","T",0,"R");$pdf->Cell(30,4,"$polozka->bdl","T",0,"R");$pdf->Cell(30,4,"$mesroz","T",0,"R");
$pdf->Cell(32,4,"$polozka->zmd","T",0,"R");$pdf->Cell(0,4,"$polozka->zdl","T",1,"R");
$j = $j + 1;
   }


if( $polozka->uro == 997 )
   {
//tlac sumare trieda 5
$pdf->Cell(277,2," ","0",1,"R");
$pdf->Cell(50,4,"Celkom trieda 5","T",0,"L");
$pdf->Cell(75,4," ","T",0,"R");
$pdf->Cell(30,4,"$polozka->bmd","T",0,"R");$pdf->Cell(30,4,"$polozka->bdl","T",0,"R");$pdf->Cell(30,4,"$mesroz","T",0,"R");
$pdf->Cell(32,4,"$polozka->zmd","T",0,"R");$pdf->Cell(0,4,"$polozka->zdl","T",1,"R");
$j = $j + 1;
   }

if( $polozka->uro == 998 )
   {
//tlac sumare trieda 6
$pdf->Cell(277,2," ","0",1,"R");
$pdf->Cell(50,4,"Celkom trieda 6","T",0,"L");
$pdf->Cell(75,4," ","T",0,"R");
$pdf->Cell(30,4,"$polozka->bmd","T",0,"R");$pdf->Cell(30,4,"$polozka->bdl","T",0,"R");$pdf->Cell(30,4,"$mesroz","T",0,"R");
$pdf->Cell(32,4,"$polozka->zmd","T",0,"R");$pdf->Cell(0,4,"$polozka->zdl","T",1,"R");
$j = $j + 1;
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
$pdf->Cell(50,4,"Celkom všetky úèty","LTB",0,"L");
$pdf->Cell(75,4," ","RTB",0,"R");
$pdf->Cell(30,4,"$polozka->bmd","1",0,"R");$pdf->Cell(30,4,"$polozka->bdl","1",0,"R");$pdf->Cell(30,4," ","1",0,"R");
$pdf->Cell(32,4,"$polozka->zmd","1",0,"R");$pdf->Cell(0,4,"$polozka->zdl","1",1,"R");

$pdf->Cell(70,4,"Hospodársky výsledok pred zdanením: ","1",0,"L");$pdf->Cell(40,4,"$hvpz","1",1,"R");
$pdf->Cell(70,4,"Hospodársky výsledok po zdanení: ","1",0,"L");$pdf->Cell(40,4,"$polozka->odl","1",1,"R");
$j = $j + 1;
   }
}
//koniec analyticka

//zaciatok synteticka
if( $typ == 'PDF' AND $synt == 1 )
{

if( $polozka->ur1 == 998 )
   {
//tlac sumar za SU
$pdf->Cell(19,4,"$polozka->fak","T",0,"R");
$pdf->Cell(128,4,"$polozka->nuc","T",0,"L");
$pdf->Cell(30,4,"$polozka->bmd","T",0,"R");$pdf->Cell(30,4,"$polozka->bdl","T",0,"R");
$pdf->Cell(35,4,"$polozka->zmd","T",0,"R");$pdf->Cell(35,4,"$polozka->zdl","T",1,"R");
$j = $j + 1;
   }


if( $polozka->uro == 997 )
   {
//tlac sumare trieda 5
$pdf->Cell(277,2," ","0",1,"R");
$pdf->Cell(49,4,"Celkom trieda 5","T",0,"L");
$pdf->Cell(98,4," ","T",0,"R");
$pdf->Cell(30,4,"$polozka->bmd","T",0,"R");$pdf->Cell(30,4,"$polozka->bdl","T",0,"R");
$pdf->Cell(35,4,"$polozka->zmd","T",0,"R");$pdf->Cell(35,4,"$polozka->zdl","T",1,"R");
$j = $j + 1;
   }

if( $polozka->uro == 998 )
   {
//tlac sumare trieda 6
$pdf->Cell(277,2," ","0",1,"R");
$pdf->Cell(49,4,"Celkom trieda 6","T",0,"L");
$pdf->Cell(98,4," ","T",0,"R");
$pdf->Cell(30,4,"$polozka->bmd","T",0,"R");$pdf->Cell(30,4,"$polozka->bdl","T",0,"R");
$pdf->Cell(35,4,"$polozka->zmd","T",0,"R");$pdf->Cell(35,4,"$polozka->zdl","T",1,"R");
$j = $j + 1;
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
$j = $j + 1;
   }
}
//koniec synteticka




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
if( $j >= 34 )
      {
$strana=$strana+1;
$j=0;
      }
//koniec bloku na koniec stranky


  }
//koniec polozky


if( $typ == 'PDF' )
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

?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsx'.$kli_uzid;
if( $analyzy == 0 ) { $vysledok = mysql_query("$sqlt"); }
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
