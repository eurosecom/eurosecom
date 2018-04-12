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

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$typ = $_REQUEST['typ'];

$cit_nas = include("../cis/citaj_nas.php");
$cit_fir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$vyb_ume=$kli_vume;

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
$vyb_umep=$h_obdk.".".$kli_vrok;
$vyb_umek=$h_obdk.".".$kli_vrok;
$copern=$copern-1;
}

$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/penden_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/penden_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }
   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendens'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendensx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendensy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcpendens
(
   uro          INT(1),
   cpl          int not null auto_increment,
   ume          FLOAT(8,4),
   dat          DATE,
   pox          INT(1),
   poh          INT(10),
   zdn          INT(2), 
   dok          INT(8),
   ucm          VARCHAR(10),
   ucd          VARCHAR(10),
   rdp          INT(2),
   dph          INT(2),
   ico          INT(10),
   fak          INT(10),
   hod          DECIMAL(10,2),
   pokc         VARCHAR(10),
   hotp         DECIMAL(10,2),
   hotv         DECIMAL(10,2),
   prbp         DECIMAL(10,2),
   prbv         DECIMAL(10,2),
   ucbc         VARCHAR(10),
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
   PRIMARY KEY(cpl)
);
prcpendens;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcpendens'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcpendensx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcpendensy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $vyb_ume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$dat_poc="2000-01-01";
$ume_poc=1;

//zober pociatocny stav pokladnica a ucty
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendens$kli_uzid"." SELECT".
" 1,0,'$ume_poc','$dat_poc',0,0,0,1,uce,0,1,0,0,0,pmd,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'' FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pmd != 0";
$dsql = mysql_query("$dsqlt");

//zober prijemky
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendens$kli_uzid"." SELECT".
" 1,0,ume,dat,1,0,0,F$kli_vxcf"."_uctpokuct.dok,ucm,ucd,rdp,dph,F$kli_vxcf"."_uctpokuct.ico,fak,F$kli_vxcf"."_uctpokuct.hod,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,pop FROM F$kli_vxcf"."_uctpokuct,F$kli_vxcf"."_pokpri".
" WHERE F$kli_vxcf"."_uctpokuct.dok=F$kli_vxcf"."_pokpri.dok AND ume <= $vyb_ume AND F$kli_vxcf"."_uctpokuct.hod != 0";
$dsql = mysql_query("$dsqlt");

//zober vydajky
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendens$kli_uzid"." SELECT".
" 1,0,ume,dat,2,0,0,F$kli_vxcf"."_uctpokuct.dok,ucm,ucd,rdp,dph,F$kli_vxcf"."_uctpokuct.ico,fak,F$kli_vxcf"."_uctpokuct.hod,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,pop FROM F$kli_vxcf"."_uctpokuct,F$kli_vxcf"."_pokvyd".
" WHERE F$kli_vxcf"."_uctpokuct.dok=F$kli_vxcf"."_pokvyd.dok AND ume <= $vyb_ume AND F$kli_vxcf"."_uctpokuct.hod != 0";
$dsql = mysql_query("$dsqlt");

//zober bankove vypisy
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendens$kli_uzid"." SELECT".
" 1,0,ume,dat,4,0,0,F$kli_vxcf"."_uctban.dok,ucm,ucd,rdp,dph,F$kli_vxcf"."_uctban.ico,fak,F$kli_vxcf"."_uctban.hod,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,pop FROM F$kli_vxcf"."_uctban,F$kli_vxcf"."_banvyp".
" WHERE F$kli_vxcf"."_uctban.dok=F$kli_vxcf"."_banvyp.dok AND ume <= $vyb_ume AND F$kli_vxcf"."_uctban.hod != 0";
$dsql = mysql_query("$dsqlt");

//zober vseobecne bez pohybu penazi vydaj
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendens$kli_uzid"." SELECT".
" 1,0,ume,dat,5,ucm,0,F$kli_vxcf"."_uctvsdp.dok,ucm,0,rdp,dph,F$kli_vxcf"."_uctvsdp.ico,fak,F$kli_vxcf"."_uctvsdp.hod,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,pop FROM F$kli_vxcf"."_uctvsdp,F$kli_vxcf"."_uctvsdh".
" WHERE F$kli_vxcf"."_uctvsdp.dok=F$kli_vxcf"."_uctvsdh.dok AND ume <= $vyb_ume AND F$kli_vxcf"."_uctvsdp.hod != 0 AND F$kli_vxcf"."_uctvsdp.ucm > 0";
$dsql = mysql_query("$dsqlt");

//zober vseobecne bez pohybu penazi prijem
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendens$kli_uzid"." SELECT".
" 1,0,ume,dat,6,ucd,0,F$kli_vxcf"."_uctvsdp.dok,0,ucd,rdp,dph,F$kli_vxcf"."_uctvsdp.ico,fak,F$kli_vxcf"."_uctvsdp.hod,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,pop FROM F$kli_vxcf"."_uctvsdp,F$kli_vxcf"."_uctvsdh".
" WHERE F$kli_vxcf"."_uctvsdp.dok=F$kli_vxcf"."_uctvsdh.dok AND ume <= $vyb_ume AND F$kli_vxcf"."_uctvsdp.hod != 0 AND F$kli_vxcf"."_uctvsdp.ucd > 0";
$dsql = mysql_query("$dsqlt");

//prijem do pokladnice
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET hotp=hod, pokc=ucm, poh=ucd WHERE LEFT(ucm,3)=211 ";
$oznac = mysql_query("$sqtoz");
//vydaj z pokladnice
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET hotv=hod, pokc=ucd, poh=ucm WHERE LEFT(ucd,3)=211 ";
$oznac = mysql_query("$sqtoz");
//prijem priebezna
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET prbp=hod WHERE LEFT(ucm,3)=261 ";
$oznac = mysql_query("$sqtoz");
//vydaj priebezna
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET prbv=hod WHERE LEFT(ucd,3)=261 ";
$oznac = mysql_query("$sqtoz");
//prijem na ucet
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET ucbp=hod, ucbc=ucm, poh=ucd WHERE LEFT(ucm,3)=221 ";
$oznac = mysql_query("$sqtoz");
//vydaj z uctu
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET ucbv=hod, ucbc=ucd, poh=ucm WHERE LEFT(ucd,3)=221 ";
$oznac = mysql_query("$sqtoz");
//dph vstup
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET dphp=hod, poh=ucm WHERE ( ucm=34300 AND rdp > 11 )";
$oznac = mysql_query("$sqtoz");
//dph vystup
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET dphv=hod, poh=ucd WHERE ( ucd=34300 AND rdp > 11 )";
$oznac = mysql_query("$sqtoz");


//dopln ci je zdanitelne alebo nie zdn=1 zapocitatelne, zdn=2 alebo !=1 nezapocitatelne
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid ,F$kli_vxcf"."_uctosnova".
" SET zdn=prm2".
" WHERE F$kli_vxcf"."_prcpendens$kli_uzid".".poh=F$kli_vxcf"."_uctosnova.ucc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
//zdanitelny prijem
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET prid=hod WHERE ( pox=1 AND zdn = 1 )";
$oznac = mysql_query("$sqtoz");
//zdanitelny vydaj
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET vydd=hod WHERE ( pox=2 AND zdn = 1 )";
$oznac = mysql_query("$sqtoz");
//zdanitelny prijem banka
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET prid=ucbp WHERE ( pox=4 AND zdn = 1 AND ucbp != 0 )";
$oznac = mysql_query("$sqtoz");
//zdanitelny vydaj banka
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET vydd=ucbv WHERE ( pox=4 AND zdn = 1 AND ucbv != 0 )";
$oznac = mysql_query("$sqtoz");

//zdanitelny vseobecny bez penazi
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET prid=hod WHERE ( pox=6 AND zdn = 1 )";
$oznac = mysql_query("$sqtoz");
//zdanitelny vseobecny bez penazi
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET vydd=hod WHERE ( pox=5 AND zdn = 1 )";
$oznac = mysql_query("$sqtoz");

//exit;

//zaklad dane vydaj
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET zakd=prid-vydd WHERE zdn = 1 ";
$oznac = mysql_query("$sqtoz");

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>PeÚaûn˝ dennÌk</title>
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
<?php if( $zandroidu == 1 ) { ?> 
<table class="h2" width="100%" >
<tr>
<td>
<?php echo "Zostava PDF prebran·, tlaËidlo Sp‰ù - do ˙Ëtovn˝ch zost·v"; ?> 
</td>
<td align="right"> </td>
</tr>
</table>
<br />
<?php                       } ?>
<?php
if( $typ == 'HTML' )
{
//#252,170,18
?>
<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  PeÚaûn˝ dennÌk JU
  <a href="#" onClick="window.open('../ucto/penden.php?copern=11&drupoh=1&page=1&typ=PDF&h_obdk=<?php echo $h_obdk;?>', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='VytlaËiù vo form·te PDF' ></a>

 <a href="#" onClick="window.open('../ucto/penden.php?copern=11&drupoh=1&page=1&typ=HTML&h_obdk=<?php echo $h_obdk;?>', '_self' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 alt='PrepoËet po ˙prav·ch peÚaûnÈho dennÌka' ></a>
</td>
<td align="right">
<?php
$prev_obdk=$h_obdk-1; $next_obdk=$h_obdk+1;
if( $prev_obdk == 0 ) { $prev_obdk=12; }
if( $next_obdk == 13 ) { $next_obdk=1; }
$coperp=$copern+1;
      if( $copern == 30 OR $copern == 20 OR $copern == 10 ) { ?>
<a href="#" onClick="window.open('../ucto/penden.php?copern=<?php echo $coperp;?>&drupoh=<?php echo $drupoh;?>&h_obdk=<?php echo $prev_obdk;?>
&page=1&typ=HTML', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 alt='Obdobie <?php echo $prev_obdk.".".$kli_vrok; ?>' ></a>
<a href="#" onClick="window.open('../ucto/penden.php?copern=<?php echo $coperp;?>&drupoh=<?php echo $drupoh;?>&h_obdk=<?php echo $next_obdk;?>
&page=1&typ=HTML', '_self' )">
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
//pociatok mesiaca pox=0 ume=$vyb_ume
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendens$kli_uzid "." SELECT".
" 0,0,$vyb_ume,dat,0,1,zdn,dok,ucm,ucd,rdp,dph,ico,fak,hod,pokc,SUM(hotp),SUM(hotv),SUM(prbp),SUM(prbv),".
"ucbc,SUM(ucbp),SUM(ucbv),SUM(priu),SUM(vydu),SUM(prid),SUM(vydd),SUM(zakd),SUM(dphp),SUM(dphv),pop".
" FROM F$kli_vxcf"."_prcpendens$kli_uzid".
" WHERE ume < $vyb_ume".
" GROUP BY uro".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//vloz pre ocislovanie poloziek
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendensx$kli_uzid"." SELECT".
" uro,0,ume,dat,pox,poh,zdn,dok,ucm,ucd,rdp,dph,ico,fak,hod,pokc,hotp,hotv,prbp,prbv,ucbc,ucbp,ucbv,priu,vydu,prid,vydd,zakd,dphp,dphv,pop".
" FROM F$kli_vxcf"."_prcpendens$kli_uzid".
" WHERE ume = $vyb_ume".
" ORDER BY uro,dat,pox,dok,poh,hod";
$dsql = mysql_query("$dsqlt");

//nacitaj dkk z knihy faktur
$sql = "ALTER TABLE F$kli_vxcf"."_prcpendensx$kli_uzid ADD dkk DECIMAL(10,0) DEFAULT 0 AFTER pop";
$vysledek = mysql_query("$sql");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendensx$kli_uzid,F$kli_vxcf"."_fakodb SET dkk=F$kli_vxcf"."_fakodb.dok ".
" WHERE F$kli_vxcf"."_prcpendensx$kli_uzid.fak=F$kli_vxcf"."_fakodb.fak AND F$kli_vxcf"."_prcpendensx$kli_uzid.ico=F$kli_vxcf"."_fakodb.ico ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendensx$kli_uzid,F$kli_vxcf"."_fakodbpoc SET dkk=F$kli_vxcf"."_fakodbpoc.dok ".
" WHERE F$kli_vxcf"."_prcpendensx$kli_uzid.fak=F$kli_vxcf"."_fakodbpoc.fak AND F$kli_vxcf"."_prcpendensx$kli_uzid.ico=F$kli_vxcf"."_fakodbpoc.ico ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendensx$kli_uzid,F$kli_vxcf"."_fakdod SET dkk=F$kli_vxcf"."_fakdod.dok ".
" WHERE F$kli_vxcf"."_prcpendensx$kli_uzid.fak=F$kli_vxcf"."_fakdod.fak AND F$kli_vxcf"."_prcpendensx$kli_uzid.ico=F$kli_vxcf"."_fakdod.ico ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendensx$kli_uzid,F$kli_vxcf"."_fakdodpoc SET dkk=F$kli_vxcf"."_fakdodpoc.dok ".
" WHERE F$kli_vxcf"."_prcpendensx$kli_uzid.fak=F$kli_vxcf"."_fakdodpoc.fak AND F$kli_vxcf"."_prcpendensx$kli_uzid.ico=F$kli_vxcf"."_fakdodpoc.ico ";
$oznac = mysql_query("$sqtoz");


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcpendensx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcpendensx$kli_uzid".".poh=F$kli_vxcf"."_uctosnova.ucc".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcpendensx$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_uctdrdp".
" ON F$kli_vxcf"."_prcpendensx$kli_uzid".".rdp=F$kli_vxcf"."_uctdrdp.rdp".
" WHERE cpl > 0 "."ORDER BY cpl";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

//sumare napocet
$hotp = 0.00;
$hotv = 0.00;
$hotz = 0.00;
$prbp = 0.00;
$prbv = 0.00;
$prbz = 0.00;
$ucbp = 0.00;
$ucbv = 0.00;
$ucbz = 0.00;
$prid = 0.00;
$vydd = 0.00;
$zakd = 0.00;
$dphp = 0.00;
$dphv = 0.00;
$dphz = 0.00;


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

$pdf->Cell(110,5,"PeÚaûn˝ dennÌk za $vyb_ume","LTB",0,"L");
$pdf->Cell(167,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',8);
$pdf->Cell(12,4,"Pohyb","1",0,"R");$pdf->Cell(29,4,"Popis","1",0,"L");

$pdf->Cell(48,4,"Hotovosù","1",0,"C");
$pdf->Cell(36,4,"PriebeûnÈ poloûky","1",0,"C");
$pdf->Cell(48,4,"BankovÈ ˙Ëty","1",0,"C");
$pdf->Cell(36,4,"Zdaniteæn˝","1",0,"C");

$pdf->Cell(26,4,"DaÚ z prÌjmov","1",0,"C");
$pdf->Cell(42,4,"DaÚ z pridanej hodnoty","1",1,"C");


$pdf->Cell(12,4,"Poloûka","1",0,"R");$pdf->Cell(14,4,"D·tum","1",0,"R");$pdf->Cell(15,4,"Doklad","1",0,"R");

$pdf->Cell(12,4,"ËÌslo","1",0,"R");$pdf->Cell(18,4,"PrÌjem","1",0,"R");$pdf->Cell(18,4,"V˝davok","1",0,"R");
$pdf->Cell(18,4,"PrÌjem","1",0,"R");$pdf->Cell(18,4,"V˝davok","1",0,"R");
$pdf->Cell(12,4,"ËÌslo","1",0,"R");$pdf->Cell(18,4,"PrÌjem","1",0,"R");$pdf->Cell(18,4,"V˝davok","1",0,"R");
$pdf->Cell(18,4,"PrÌjem","1",0,"R");$pdf->Cell(18,4,"V˝davok","1",0,"R");

$pdf->Cell(26,4,"Z·klad dane","1",0,"R");
$pdf->Cell(22,4,"DPH vstup","1",0,"R");$pdf->Cell(20,4,"DPH v˝stup","1",1,"R");

if ( $k > 0 )
      {
//prevedene zostatky za stranu
$pdf->Cell(41,4,"PREVEDEN…","1",0,"LB");

$pdf->Cell(12,4," ","LB",0,"R");$pdf->Cell(18,4,"Zostatok hotovosù","RB",0,"R");$pdf->Cell(18,4,"$str_shotz","1",0,"R");
$pdf->Cell(18,4," ","1",0,"R");$pdf->Cell(18,4," ","1",0,"R");
$pdf->Cell(12,4," ","LB",0,"R");$pdf->Cell(18,4,"Zostatok banky","RB",0,"R");$pdf->Cell(18,4,"$str_sucbz","1",0,"R");

$pdf->Cell(18,4," ","LB",0,"R");$pdf->Cell(18,4,"Z·klad dane z prÌjmov","RB",0,"R");
$pdf->Cell(26,4,"$szakd","LRB",0,"R");
$pdf->Cell(22,4,"Odvod DPH","RB",0,"R");$pdf->Cell(20,4,"$str_sdphz","1",1,"R");
      }
$k=1;


}


if( $typ == 'HTML' )
{
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" colspan="8"><?php echo "PeÚaûn˝ dennÌk za $vyb_ume"; ?></td>
<td class="bmenu" colspan="8" align="right"><?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?></td>
</tr>
<tr>
<td class="bmenu" colspan="1" align="right">Pohyb</td>
<td class="bmenu" colspan="2">Popis</td>

<td class="hvstup_zlte" colspan="3" align="center">Hotovosù</td>
<td class="bmenu" colspan="2" align="center">PriebeûnÈ poloûky</td>
<td class="hvstup_zlte" colspan="3" align="center">BankovÈ ˙Ëty</td>
<td class="bmenu" colspan="3" align="center">DaÚ z prÌjmu</td>
<td class="hvstup_zlte" colspan="2" align="center">DaÚ z pridanej hodnoty</td>
</tr>

<tr>
<td class="bmenu" width="8%">Poloûka</td>
<td class="bmenu" width="8%">D·tum</td>
<td class="bmenu" width="8%">Doklad</td>

<td class="hvstup_zlte" width="5%">ËÌslo</td>
<td class="hvstup_zlte" width="6%" align="right">PrÌjem</td>
<td class="hvstup_zlte" width="6%" align="right">V˝davok</td>

<td class="bmenu" width="6%" align="right">PrÌjem</td>
<td class="bmenu" width="6%" align="right">V˝davok</td>

<td class="hvstup_zlte" width="5%">ËÌslo</td>
<td class="hvstup_zlte" width="6%" align="right">PrÌjem</td>
<td class="hvstup_zlte" width="6%" align="right">V˝davok</td>

<td class="bmenu" width="6%" align="right">PrÌjem</td>
<td class="bmenu" width="6%" align="right">V˝davok</td>
<td class="bmenu" width="6%" align="right">Z·klad</td>

<td class="hvstup_zlte" width="6%" align="right">Vstup</td>
<td class="hvstup_zlte" width="6%" align="right">V˝stup</td>

</tr>

<?php
}

$str_hotp = 0.00;
$str_hotv = 0.00;
$str_hotz = 0.00;
$str_prbp = 0.00;
$str_prbv = 0.00;
$str_prbz = 0.00;
$str_ucbp = 0.00;
$str_ucbv = 0.00;
$str_ucbz = 0.00;
$str_prid = 0.00;
$str_vydd = 0.00;
$str_zakd = 0.00;
$str_dphp = 0.00;
$str_dphv = 0.00;
$str_dphz = 0.00;

      }
//koniec j=0

//html nestrankuj
if( $typ == 'HTML' ) $j=1;

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);

//ak je nulova polozka daj medzeru
$h_pokc=$polozka->pokc;
if( $polozka->pokc == 0 ) $h_pokc="";
$h_hotp=$polozka->hotp;
if( $polozka->hotp == 0 ) $h_hotp="";
$h_hotv=$polozka->hotv;
if( $polozka->hotv == 0 ) $h_hotv="";
$h_prbp=$polozka->prbp;
if( $polozka->prbp == 0 ) $h_prbp="";
$h_prbv=$polozka->prbv;
if( $polozka->prbv == 0 ) $h_prbv="";
$h_ucbc=$polozka->ucbc;
if( $polozka->ucbc == 0 ) $h_ucbc="";
$h_ucbp=$polozka->ucbp;
if( $polozka->ucbp == 0 ) $h_ucbp="";
$h_ucbv=$polozka->ucbv;
if( $polozka->ucbv == 0 ) $h_ucbv="";
$h_prid=$polozka->prid;
if( $polozka->prid == 0 ) $h_prid="";
$h_vydd=$polozka->vydd;
if( $polozka->vydd == 0 ) $h_vydd="";
$h_dphp=$polozka->dphp;
if( $polozka->dphp == 0 ) $h_dphp="";
$h_dphv=$polozka->dphv;
if( $polozka->dphv == 0 ) $h_dphv="";
$h_zakd=$polozka->zakd;
if( $polozka->zakd == 0 ) $h_zakd="";
$h_poh=$polozka->poh;
if( $polozka->poh == 0 ) $h_poh="";

//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $polozka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);

//sumare napocet
$hotp = $hotp + $polozka->hotp;
$Cislo=$hotp+"";
$shotp=sprintf("%0.2f", $Cislo);
$hotv = $hotv + $polozka->hotv;
$Cislo=$hotv+"";
$shotv=sprintf("%0.2f", $Cislo);
$prbp = $prbp + $polozka->prbp;
$Cislo=$prbp+"";
$sprbp=sprintf("%0.2f", $Cislo);
$prbv = $prbv + $polozka->prbv;
$Cislo=$prbv+"";
$sprbv=sprintf("%0.2f", $Cislo);
$ucbp = $ucbp + $polozka->ucbp;
$Cislo=$ucbp+"";
$sucbp=sprintf("%0.2f", $Cislo);
$ucbv = $ucbv + $polozka->ucbv;
$Cislo=$ucbv+"";
$sucbv=sprintf("%0.2f", $Cislo);
$dphp = $dphp + $polozka->dphp;
$Cislo=$dphp+"";
$sdphp=sprintf("%0.2f", $Cislo);
$dphv = $dphv + $polozka->dphv;
$Cislo=$dphv+"";
$sdphv=sprintf("%0.2f", $Cislo);
$prid = $prid + $polozka->prid;
$Cislo=$prid+"";
$sprid=sprintf("%0.2f", $Cislo);
$vydd = $vydd + $polozka->vydd;
$Cislo=$vydd+"";
$svydd=sprintf("%0.2f", $Cislo);
$zakd = $zakd + $polozka->zakd;
$Cislo=$zakd+"";
$szakd=sprintf("%0.2f", $Cislo);

$str_hotp = $str_hotp + $polozka->hotp;
$str_Cislo=$str_hotp+"";
$str_shotp=sprintf("%0.2f", $str_Cislo);
$str_hotv = $str_hotv + $polozka->hotv;
$str_Cislo=$str_hotv+"";
$str_shotv=sprintf("%0.2f", $str_Cislo);
$str_prbp = $str_prbp + $polozka->prbp;
$str_Cislo=$str_prbp+"";
$str_sprbp=sprintf("%0.2f", $str_Cislo);
$str_prbv = $str_prbv + $polozka->prbv;
$str_Cislo=$str_prbv+"";
$str_sprbv=sprintf("%0.2f", $str_Cislo);
$str_ucbp = $str_ucbp + $polozka->ucbp;
$str_Cislo=$str_ucbp+"";
$str_sucbp=sprintf("%0.2f", $str_Cislo);
$str_ucbv = $str_ucbv + $polozka->ucbv;
$str_Cislo=$str_ucbv+"";
$str_sucbv=sprintf("%0.2f", $str_Cislo);
$str_dphp = $str_dphp + $polozka->dphp;
$str_Cislo=$str_dphp+"";
$str_sdphp=sprintf("%0.2f", $str_Cislo);
$str_dphv = $str_dphv + $polozka->dphv;
$str_Cislo=$str_dphv+"";
$str_sdphv=sprintf("%0.2f", $str_Cislo);
$str_prid = $str_prid + $polozka->prid;
$str_Cislo=$str_prid+"";
$str_sprid=sprintf("%0.2f", $str_Cislo);
$str_vydd = $str_vydd + $polozka->vydd;
$str_Cislo=$str_vydd+"";
$str_svydd=sprintf("%0.2f", $str_Cislo);
$str_zakd = $str_zakd + $polozka->zakd;
$str_Cislo=$str_zakd+"";
$str_szakd=sprintf("%0.2f", $str_Cislo);

$popis=$polozka->nuc;
if( $polozka->pop != ''  ) $popis=$polozka->nuc.", ".$polozka->pop;
$pohc=1*$polozka->poh;
if( $pohc >= 34300 AND $pohc <= 34399  ) $popis=$popis." RDP".$polozka->rdp." ".$polozka->nrd;

if( $polozka->fak != 0 ) $popis=$popis." ËKF: ".$polozka->dkk." Fakt˙ra: ".$polozka->fak." I»O: ".$polozka->ico." ".$polozka->nai." ".$polozka->mes;

if( $typ == 'PDF' )
{
if( $polozka->pox == 0 ) //pociatocny stav
   {
$pdf->Cell(12,4," ","0",0,"R");$pdf->Cell(204,4,"PoËiatoËn˝ stav","0",0,"L");
$pdf->Cell(0,4,"","0",1,"R");

$pdf->Cell(12,4,"$polozka->cpl","B",0,"R");$pdf->Cell(14,4," ","B",0,"R");$pdf->Cell(15,4," ","B",0,"R");

$pdf->Cell(12,4," ","B",0,"R");$pdf->Cell(18,4,"$h_hotp","B",0,"R");$pdf->Cell(18,4,"$h_hotv","B",0,"R");
$pdf->Cell(18,4,"$h_prbp","B",0,"R");$pdf->Cell(18,4,"$h_prbv","B",0,"R");
$pdf->Cell(12,4," ","B",0,"R");$pdf->Cell(18,4,"$h_ucbp","B",0,"R");$pdf->Cell(18,4,"$h_ucbv","B",0,"R");

$pdf->Cell(18,4,"$h_prid","B",0,"R");$pdf->Cell(18,4,"$h_vydd","B",0,"R");
$pdf->Cell(26,4,"$h_zakd","B",0,"R");
$pdf->Cell(22,4,"$h_dphp","B",0,"R");$pdf->Cell(20,4,"$h_dphv","B",1,"R");
   }

if( $polozka->pox > 0 )
   {
$pdf->Cell(12,4,"$h_poh","0",0,"R");$pdf->Cell(204,4,"$popis","0",0,"L");
$pdf->Cell(0,4,"","0",1,"R");

$pdf->Cell(12,4,"$polozka->cpl","B",0,"R");$pdf->Cell(14,4,"$datsk","B",0,"R");$pdf->Cell(15,4,"$polozka->dok","B",0,"R");

$pdf->Cell(12,4,"$h_pokc","B",0,"R");$pdf->Cell(18,4,"$h_hotp","B",0,"R");$pdf->Cell(18,4,"$h_hotv","B",0,"R");
$pdf->Cell(18,4,"$h_prbp","B",0,"R");$pdf->Cell(18,4,"$h_prbv","B",0,"R");
$pdf->Cell(12,4,"$h_ucbc","B",0,"R");$pdf->Cell(18,4,"$h_ucbp","B",0,"R");$pdf->Cell(18,4,"$h_ucbv","B",0,"R");

$pdf->Cell(18,4,"$h_prid","B",0,"R");$pdf->Cell(18,4,"$h_vydd","B",0,"R");
$pdf->Cell(26,4,"$h_zakd","B",0,"R");
$pdf->Cell(22,4,"$h_dphp","B",0,"R");$pdf->Cell(20,4,"$h_dphv","B",1,"R");
   }

}

if( $typ == 'HTML' )
{
$hvstup="hvstup";
if( $par == 1 ) { $hvstup="hvstup_bsede"; }
?>

<tr>
<?php
if( $polozka->pox == 0 )
        {
?>
<td class="<?php echo $hvstup; ?>" colspan="1" align="right"> </td>
<td class="<?php echo $hvstup; ?>" colspan="15">PoËiatoËn˝ stav</td>
</tr>
<tr>
<td class="<?php echo $hvstup; ?>"><?php echo $polozka->cpl; ?></td>
<td class="<?php echo $hvstup; ?>"></td>
<td class="<?php echo $hvstup; ?>"></td>
<td class="hvstup_zlte"></td>
<td class="hvstup_zlte" align="right"><?php echo $h_hotp; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $h_hotv; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $h_prbp; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $h_prbv; ?></td>
<td class="hvstup_zlte"></td>
<td class="hvstup_zlte" align="right"><?php echo $h_ucbp; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $h_ucbv; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $h_prid; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $h_vydd; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $h_zakd; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $h_dphp; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $h_dphv; ?></td>
</tr>
<?php
        }
?>

<?php
if( $polozka->pox > 0 )
        {
?>
<td class="<?php echo $hvstup; ?>" colspan="1" align="right">
<a href="#" onClick="window.open('zosuce.php?copern=10&drupoh=1&page=1&typ=HTML&cislo_uce=<?php echo $h_poh; ?>', '_blank', 
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<?php echo $h_poh; ?></a>
</td>
<td class="<?php echo $hvstup; ?>" colspan="15"><?php echo $popis; ?></td>
</tr>
<tr>
<td class="<?php echo $hvstup; ?>"><?php echo $polozka->cpl; ?></td>
<td class="<?php echo $hvstup; ?>"><?php echo $datsk; ?></td>
<td class="<?php echo $hvstup; ?>">
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=<?php echo $polozka->pox;?>
&h_ico=<?php echo $polozka->ico;?>
<?php if( $polozka->pox == 1 OR $polozka->pox == 2 )  { echo "&h_uce=$h_pokc"; } ?>
<?php if( $polozka->pox == 4 )  { echo "&h_uce=$h_ucbc"; } ?>
&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=<?php echo $polozka->pox;?>
&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranÈho dokladu" ></a>
<?php echo $polozka->dok;?>
</td>
<td class="hvstup_zlte">
<a href="#" onClick="window.open('zosuce.php?copern=10&drupoh=1&page=1&typ=HTML&cislo_uce=<?php echo $h_pokc; ?>', '_blank', 
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<?php echo $h_pokc; ?></a>
<?php
if( $h_pokc > 0 )
{
?>
<a href="#" onClick="window.open('pokl_kniha.php?copern=40&drupoh=1&page=1&typ=HTML&cislo_uce=<?php echo $h_pokc; ?>&page=1', '_blank', '<?php echo $tlcswin; ?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=10 height=10 border=0 alt="PokladniËn· kniha" ></a>
<?php
}
?>
</td>
<td class="hvstup_zlte" align="right"><?php echo $h_hotp; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $h_hotv; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $h_prbp; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $h_prbv; ?></td>
<td class="hvstup_zlte">
<a href="#" onClick="window.open('zosuce.php?copern=10&drupoh=1&page=1&typ=HTML&cislo_uce=<?php echo $h_ucbc; ?>', '_blank', 
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<?php echo $h_ucbc; ?></a>
<?php
if( $h_ucbc > 0 )
{
?>
<a href="#" onClick="window.open('pokl_kniha.php?copern=40&drupoh=4&page=1&typ=HTML&cislo_uce=<?php echo $h_ucbc; ?>&page=1', '_blank', '<?php echo $tlcswin; ?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=10 height=10 border=0 alt="Zostatok na B⁄" ></a>
<?php
}
?>
</td>
<td class="hvstup_zlte" align="right"><?php echo $h_ucbp; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $h_ucbv; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $h_prid; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $h_vydd; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $h_zakd; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $h_dphp; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $h_dphv; ?></td>
</tr>
<?php
        }
?>

<?php
}

$hotz=$hotz+$polozka->hotp-($polozka->hotv);
$Cislo=$hotz+"";
$shotz=sprintf("%0.2f", $Cislo);
$ucbz=$ucbz+$polozka->ucbp-($polozka->ucbv);
$Cislo=$ucbz+"";
$sucbz=sprintf("%0.2f", $Cislo);
$dphz=$dphz+$polozka->dphp-($polozka->dphv);
$Cislo=$dphz+"";
$sdphz=sprintf("%0.2f", $Cislo);

$str_hotz=$str_hotz+$polozka->hotp-($polozka->hotv);
$str_Cislo=$str_hotz+"";
$str_shotz=sprintf("%0.2f", $str_Cislo);
$str_ucbz=$str_ucbz+$polozka->ucbp-($polozka->ucbv);
$str_Cislo=$str_ucbz+"";
$str_sucbz=sprintf("%0.2f", $str_Cislo);
$str_dphz=$str_dphz+$polozka->dphp-($polozka->dphv);
$str_Cislo=$str_dphz+"";
$str_sdphz=sprintf("%0.2f", $str_Cislo);
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
if( $j == 19 )
      {

if( $typ == 'PDF' )
{
//tlac sumare za stranu
$pdf->Cell(41,4,"Spolu za stranu","1",0,"L");
 
$pdf->Cell(12,4," ","1",0,"R");$pdf->Cell(18,4,"$str_shotp","1",0,"R");$pdf->Cell(18,4,"$str_shotv","1",0,"R");
$pdf->Cell(18,4,"$str_sprbp","1",0,"R");$pdf->Cell(18,4,"$str_sprbv","1",0,"R");
$pdf->Cell(12,4," ","1",0,"R");$pdf->Cell(18,4,"$str_sucbp","1",0,"R");$pdf->Cell(18,4,"$str_sucbv","1",0,"R");

$pdf->Cell(18,4,"$str_sprid","1",0,"R");$pdf->Cell(18,4,"$str_svydd","1",0,"R");
$pdf->Cell(26,4,"$str_szakd","1",0,"R");
$pdf->Cell(22,4,"$str_sdphp","1",0,"R");$pdf->Cell(20,4,"$str_sdphv","1",1,"R");

//zostatky za stranu
$pdf->Cell(41,4,"PREVOD","1",0,"LB");

$pdf->Cell(12,4," ","LB",0,"R");$pdf->Cell(18,4,"Zostatok hotovosù","RB",0,"R");$pdf->Cell(18,4,"$str_shotz","1",0,"R");
$pdf->Cell(18,4," ","1",0,"R");$pdf->Cell(18,4," ","1",0,"R");
$pdf->Cell(12,4," ","LB",0,"R");$pdf->Cell(18,4,"Zostatok banky","RB",0,"R");$pdf->Cell(18,4,"$str_sucbz","1",0,"R");

$pdf->Cell(18,4," ","LB",0,"R");$pdf->Cell(18,4,"Z·klad dane z prÌjmov","RB",0,"R");
$pdf->Cell(26,4,"$szakd","LRB",0,"R");
$pdf->Cell(22,4,"Odvod DPH","RB",0,"R");$pdf->Cell(20,4,"$str_sdphz","1",1,"R");
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
 
$pdf->Cell(12,5," ","1",0,"R");$pdf->Cell(18,5,"$shotp","1",0,"R");$pdf->Cell(18,5,"$shotv","1",0,"R");
$pdf->Cell(18,5,"$sprbp","1",0,"R");$pdf->Cell(18,5,"$sprbv","1",0,"R");
$pdf->Cell(12,5," ","1",0,"R");$pdf->Cell(18,5,"$sucbp","1",0,"R");$pdf->Cell(18,5,"$sucbv","1",0,"R");

$pdf->Cell(18,5,"$sprid","1",0,"R");$pdf->Cell(18,5,"$svydd","1",0,"R");
$pdf->Cell(26,5,"$szakd","1",0,"R");
$pdf->Cell(22,5,"$sdphp","1",0,"R");$pdf->Cell(20,5,"$sdphv","1",1,"R");

//zostatky
$pdf->Cell(41,5," ","1",0,"LB");

$pdf->Cell(12,5," ","LB",0,"R");$pdf->Cell(18,5,"Zostatok hotovosù","RB",0,"R");$pdf->Cell(18,5,"$shotz","1",0,"R");
$pdf->Cell(18,5," ","1",0,"R");$pdf->Cell(18,5," ","1",0,"R");
$pdf->Cell(12,5," ","LB",0,"R");$pdf->Cell(18,5,"Zostatok banky","RB",0,"R");$pdf->Cell(18,5,"$sucbz","1",0,"R");

$pdf->Cell(18,5," ","LB",0,"R");$pdf->Cell(18,5,"Z·klad dane z prÌjmov","RB",0,"R");
$pdf->Cell(26,5,"$szakd","LRB",0,"R");
$pdf->Cell(22,5,"Odvod DPH","RB",0,"R");$pdf->Cell(20,5,"$sdphz","1",1,"R");

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

<tr>
<td class="bmenu" colspan="3">Spolu celkom</td>

<td class="hvstup_tzlte"></td>
<td class="hvstup_tzlte" align="right"><?php echo $shotp; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $shotv; ?></td>

<td class="bmenu" align="right"><?php echo $sprbp; ?></td>
<td class="bmenu" align="right"><?php echo $sprbv; ?></td>

<td class="hvstup_tzlte"></td>
<td class="hvstup_tzlte" align="right"><?php echo $sucbp; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $sucbv; ?></td>

<td class="bmenu" align="right"><?php echo $sprid; ?></td>
<td class="bmenu" align="right"><?php echo $svydd; ?></td>
<td class="bmenu" align="right"><?php echo $szakd; ?></td>

<td class="hvstup_tzlte" align="right"><?php echo $sdphp; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $sdphv; ?></td>

</tr>

<tr>
<td class="bmenu" colspan="3"></td>

<td class="hvstup_tzlte" align="right" colspan="2">Zostatok hotovosù</td>
<td class="hvstup_tzlte" align="right"><?php echo $shotz; ?></td>

<td class="bmenu" align="right"> </td>
<td class="bmenu" align="right"> </td>

<td class="hvstup_tzlte" align="right" colspan="2">Zostatok banky</td>
<td class="hvstup_tzlte" align="right"><?php echo $sucbz; ?></td>

<td class="bmenu" align="right" colspan="2">Z·klad dane</td>
<td class="bmenu" align="right"><?php echo $szakd; ?></td>

<td class="hvstup_tzlte" align="right">Odvod DPH</td>
<td class="hvstup_tzlte" align="right"><?php echo $sdphz; ?></td>

</tr>

</table>
<?php
}

?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendens'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendensx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
