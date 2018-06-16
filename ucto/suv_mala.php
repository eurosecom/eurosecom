<HTML>
<?php
$zandroidu=1*$_REQUEST['zandroidu'];

if( $zandroidu == 1 )
  {
error_reporting(0);
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
$analyzy = 1*$_REQUEST['analyzy']; 
if( $analyzy == 1 ) { $sys='ANA'; $urov=1000; }
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

$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/suvaha_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/suvaha_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

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
   fak          VARCHAR(10),
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
"0,0,0,0,0,0,F$kli_vxcf"."_uctosnova.pmd,F$kli_vxcf"."_uctosnova.pmd,0,0,'poËiatoËn˝ stav',1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pmd != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" 0,1,0,$ume_pcc,'$dat_pcc',0,F$kli_vxcf"."_uctosnova.uce,1,0,0,F$kli_vxcf"."_uctosnova.uce,".
"0,0,0,0,0,F$kli_vxcf"."_uctosnova.pda,0,F$kli_vxcf"."_uctosnova.pda,0,'poËiatoËn˝ stav',1,0,0,0,0,0,0,0,0".
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
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,F$kli_vxcf"."_$uctovanie.dok,ucm,1,ucd,ucm,ucd,rdp,F$kli_vxcf"."_$uctovanie.ico,F$kli_vxcf"."_$uctovanie.fak,".
"F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak,F$kli_vxcf"."_$uctovanie.hod,F$kli_vxcf"."_$uctovanie.hod,".
"0,0,F$kli_vxcf"."_$doklad.txp,1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ( ucm > 0 OR ucd > 0 ) AND ume <= $vyb_ume";
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
" WHERE ume <= $vyb_ume";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>S˙vaha</title>
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
<td>EuroSecom  -  S˙vaha PU</td>
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
" ( LEFT(uce,1) != 5 AND LEFT(uce,1) != 6 AND LEFT(uce,1) != 8 AND LEFT(uce,1) != 9 ) ".
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
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl)".
" FROM F$kli_vxcf"."_prcuobratsy$kli_uzid".
" WHERE ur1 = 999".
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
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobratsx$kli_uzid SET odl=zmd-zdl WHERE cpl >= 0";
$dsql = mysql_query("$dsqlt");

$osnova=5;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ( ur1 = 999 AND uce > 99999 ) ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
if( $pol > 20 ) $osnova=6;

if( $osnova == 5 AND $synt == 1 )
{
$sqltt = "UPDATE F$kli_vxcf"."_prcuobratsx$kli_uzid SET fak=100*fak WHERE ( ur1 = 998 ) ";
$sql = mysql_query("$sqltt");

$dsqlt = "UPDATE F$kli_vxcf"."_prcuobratsx$kli_uzid SET fak=CONCAT('0', fak) WHERE ur1 = 998 AND fak >= 1111 AND fak <= 9999 ";
$dsql = mysql_query("$dsqlt");
}
if( $osnova == 6 AND $synt == 1 )
{
$sqltt = "UPDATE F$kli_vxcf"."_prcuobratsx$kli_uzid SET fak=1000*fak WHERE ( ur1 = 998 ) ";
$sql = mysql_query("$sqltt");

$dsqlt = "UPDATE F$kli_vxcf"."_prcuobratsx$kli_uzid SET fak=CONCAT('0', fak) WHERE ur1 = 998 AND fak >= 11111 AND fak <= 99999 ";
$dsql = mysql_query("$dsqlt");
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

$pdf->Cell(110,5,"S˙vaha za $vyb_ume","LTB",0,"L");
$pdf->Cell(167,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',8);
$pdf->Cell(19,4,"⁄Ëet","1",0,"R");
$pdf->Cell(128,4,"Popis","1",0,"L");
$pdf->Cell(30,4,"Beûn˝ mesiac M·Daù","1",0,"R");$pdf->Cell(30,4,"Beûn˝ mesiac Dal","1",0,"R");
$pdf->Cell(35,4,"Zostatok M·Daù","1",0,"R");$pdf->Cell(35,4,"Zostatok Dal","1",1,"R");

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

$h_hod=$polozka->hod;
if( $polozka->hod == 0 ) $h_hod="";

//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $polozka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);

//zaciatok analyticka
if( $typ == 'PDF' AND $synt == 0 )
{
if( $polozka->ur1 == 999 )
   {
//tlac sumaz za ucet
$pdf->Cell(19,4,"$polozka->uce","0",0,"R");
$pdf->Cell(128,4,"$polozka->nuc","0",0,"L");
$pdf->Cell(30,4,"$polozka->bmd","0",0,"R");$pdf->Cell(30,4,"$polozka->bdl","0",0,"R");
$pdf->Cell(35,4,"$polozka->zmd","0",0,"R");$pdf->Cell(35,4,"$polozka->zdl","0",1,"R");
$j = $j + 1;
   }

if( $polozka->ur1 == 998 AND $polozka->ico > 1 )
   {
//tlac sumar za SU
$pdf->Cell(19,4," ","T",0,"R");
$pdf->Cell(128,4,"SU$polozka->fak","T",0,"L");
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
$pdf->Cell(49,4,"Celkom vöetky ˙Ëty","LTB",0,"L");
$pdf->Cell(98,4," ","RTB",0,"R");
$pdf->Cell(30,4,"$polozka->bmd","1",0,"R");$pdf->Cell(30,4,"$polozka->bdl","1",0,"R");
$pdf->Cell(35,4,"$polozka->zmd","1",0,"R");$pdf->Cell(35,4,"$polozka->zdl","1",1,"R");
$pdf->Cell(35,4," ","0",1,"R");
$pdf->Cell(70,4,"Hospod·rsky v˝sledok : ","1",0,"L");$pdf->Cell(40,4,"$polozka->odl","1",1,"R");
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


if( $polozka->uro == 1888 )
   {
//tlac sumare VSETKO
$hvpz=$polozka->odl;

   }

if( $polozka->uro == 1999 )
   {
//tlac sumare VSETKO
$pdf->Cell(277,2," ","0",1,"R");
$pdf->Cell(49,4,"Celkom vöetky ˙Ëty","LTB",0,"L");
$pdf->Cell(98,4," ","RTB",0,"R");
$pdf->Cell(30,4,"$polozka->bmd","1",0,"R");$pdf->Cell(30,4,"$polozka->bdl","1",0,"R");
$pdf->Cell(35,4,"$polozka->zmd","1",0,"R");$pdf->Cell(35,4,"$polozka->zdl","1",1,"R");
$pdf->Cell(35,4," ","0",1,"R");
$pdf->Cell(70,4,"Hospod·rsky v˝sledok : ","1",0,"L");$pdf->Cell(40,4,"$polozka->odl","1",1,"R");
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
if( $j >= 36 )
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
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsx'.$kli_uzid;
if( $analyzy == 10 ) { $vysledok = mysql_query("$sqlt"); }
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
