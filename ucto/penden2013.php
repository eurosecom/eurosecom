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
$copern = $_REQUEST['copern'];
$typ = $_REQUEST['typ'];

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

$h_dap = $_REQUEST['h_dap'];
$h_dak = $_REQUEST['h_dak'];
$h_stp = 1*$_REQUEST['h_stp'];
$h_stk = 1*$_REQUEST['h_stk'];
$h_aky = $_REQUEST['h_aky'];

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

$sirka_vyska="150,140";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("L","mm", A4 );
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
   s13          DECIMAL(10,2),
   s14          DECIMAL(10,2),
   s15          DECIMAL(10,2),
   s16          DECIMAL(10,2),
   s17          DECIMAL(10,2),
   s18          DECIMAL(10,2),
   s19          DECIMAL(10,2),
   s20          DECIMAL(10,2),
   s21          DECIMAL(10,2),
   s22          DECIMAL(10,2),
   s23          DECIMAL(10,2),
   s24          DECIMAL(10,2),
   s25          DECIMAL(10,2),
   s26          DECIMAL(10,2),
   s27          DECIMAL(10,2),
   s28          DECIMAL(10,2),
   s29          DECIMAL(10,2),
   s30          DECIMAL(10,2),
   s31          DECIMAL(10,2),
   s32          DECIMAL(10,2),
   strana       INT(4),
   polovica     VARCHAR(1),
   zosp         DECIMAL(10,2),
   zosu         DECIMAL(10,2),
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
" 0,0,'$ume_poc','$dat_poc',0,0,0,1,uce,0,1,0,0,0,0,".
" 0,pmd,0,0,0,0,0,0,0,0,0,0,0,0,0,'PRENESENÉ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'A',0,0 FROM F$kli_vxcf"."_uctosnova".
" WHERE LEFT(uce,3) = 211";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendens$kli_uzid"." SELECT".
" 0,0,'$ume_poc','$dat_poc',0,0,0,1,uce,0,1,0,0,0,0,".
" 0,0,0,0,0,0,pmd,0,0,0,0,0,0,0,0,'PRENESENÉ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'A',0,0 FROM F$kli_vxcf"."_uctosnova".
" WHERE LEFT(uce,3) = 221";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendens$kli_uzid "." SELECT".
" 1,0,ume,dat,pox,poh,zdn,dok,ucm,ucd,rdp,dph,ico,fak,hod,pokc,SUM(hotp),SUM(hotv),SUM(prbp),SUM(prbv),ucbc,SUM(ucbp),SUM(ucbv),".
"SUM(priu),SUM(vydu),SUM(prid),SUM(vydd),SUM(zakd),SUM(dphp),SUM(dphv),pop".
",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,strana,'A',zosp,zosu ".
" FROM F$kli_vxcf"."_prcpendens$kli_uzid".
" WHERE cpl > 0".
" GROUP BY strana".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcpendens$kli_uzid  WHERE uro = 0";
$oznac = mysql_query("$sqtoz");


//zober prijemky
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendens$kli_uzid"." SELECT".
" 2,0,ume,dat,1,0,0,F$kli_vxcf"."_uctpokuct.dok,ucm,ucd,rdp,dph,F$kli_vxcf"."_uctpokuct.ico,fak,F$kli_vxcf"."_uctpokuct.hod,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,txp,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'A',0,0 FROM F$kli_vxcf"."_uctpokuct,F$kli_vxcf"."_pokpri".
" WHERE F$kli_vxcf"."_uctpokuct.dok=F$kli_vxcf"."_pokpri.dok AND ume <= $vyb_ume AND F$kli_vxcf"."_uctpokuct.hod != 0";
$dsql = mysql_query("$dsqlt");

//zober vydajky
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendens$kli_uzid"." SELECT".
" 2,0,ume,dat,2,0,0,F$kli_vxcf"."_uctpokuct.dok,ucm,ucd,rdp,dph,F$kli_vxcf"."_uctpokuct.ico,fak,F$kli_vxcf"."_uctpokuct.hod,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,txp,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'A',0,0 FROM F$kli_vxcf"."_uctpokuct,F$kli_vxcf"."_pokvyd".
" WHERE F$kli_vxcf"."_uctpokuct.dok=F$kli_vxcf"."_pokvyd.dok AND ume <= $vyb_ume AND F$kli_vxcf"."_uctpokuct.hod != 0";
$dsql = mysql_query("$dsqlt");

//zober bankove vypisy
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendens$kli_uzid"." SELECT".
" 2,0,ume,dat,4,0,0,F$kli_vxcf"."_uctban.dok,ucm,ucd,rdp,dph,F$kli_vxcf"."_uctban.ico,fak,F$kli_vxcf"."_uctban.hod,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,pop,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'A',0,0 FROM F$kli_vxcf"."_uctban,F$kli_vxcf"."_banvyp".
" WHERE F$kli_vxcf"."_uctban.dok=F$kli_vxcf"."_banvyp.dok AND ume <= $vyb_ume AND F$kli_vxcf"."_uctban.hod != 0";
$dsql = mysql_query("$dsqlt");

//zober vseobecne bez pohybu penazi vydaj
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendens$kli_uzid"." SELECT".
" 2,0,ume,dat,5,ucm,0,F$kli_vxcf"."_uctvsdp.dok,ucm,0,rdp,dph,F$kli_vxcf"."_uctvsdp.ico,fak,F$kli_vxcf"."_uctvsdp.hod,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,pop,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'A',0,0 FROM F$kli_vxcf"."_uctvsdp,F$kli_vxcf"."_uctvsdh".
" WHERE F$kli_vxcf"."_uctvsdp.dok=F$kli_vxcf"."_uctvsdh.dok AND ume <= $vyb_ume AND F$kli_vxcf"."_uctvsdp.hod != 0 AND F$kli_vxcf"."_uctvsdp.ucm > 0";
$dsql = mysql_query("$dsqlt");

//zober vseobecne bez pohybu penazi prijem
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendens$kli_uzid"." SELECT".
" 2,0,ume,dat,6,ucd,0,F$kli_vxcf"."_uctvsdp.dok,0,ucd,rdp,dph,F$kli_vxcf"."_uctvsdp.ico,fak,F$kli_vxcf"."_uctvsdp.hod,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,pop,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'A',0,0 FROM F$kli_vxcf"."_uctvsdp,F$kli_vxcf"."_uctvsdh".
" WHERE F$kli_vxcf"."_uctvsdp.dok=F$kli_vxcf"."_uctvsdh.dok AND ume <= $vyb_ume AND F$kli_vxcf"."_uctvsdp.hod != 0 AND F$kli_vxcf"."_uctvsdp.ucd > 0";
$dsql = mysql_query("$dsqlt");


//prijem do pokladnice
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET hotp=hod, pokc=ucm, poh=ucd WHERE LEFT(ucm,3)=211 AND uro = 2";
$oznac = mysql_query("$sqtoz");
//vydaj z pokladnice
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET hotv=hod, pokc=ucd, poh=ucm WHERE LEFT(ucd,3)=211 AND uro = 2";
$oznac = mysql_query("$sqtoz");
//prijem priebezna
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET prbp=hod WHERE LEFT(ucm,3)=261 AND uro = 2";
$oznac = mysql_query("$sqtoz");
//vydaj priebezna
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET prbv=hod WHERE LEFT(ucd,3)=261 AND uro = 2";
$oznac = mysql_query("$sqtoz");
//prijem na ucet
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET ucbp=hod, ucbc=ucm, poh=ucd WHERE LEFT(ucm,3)=221 AND uro = 2";
$oznac = mysql_query("$sqtoz");
//vydaj z uctu
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET ucbv=hod, ucbc=ucd, poh=ucm WHERE LEFT(ucd,3)=221 AND uro = 2";
$oznac = mysql_query("$sqtoz");
//dph vstup
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET dphv=hod, poh=ucm WHERE LEFT(ucm,3)=343 AND uro = 2";
$oznac = mysql_query("$sqtoz");
//dph vystup
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET dphp=hod, poh=ucd WHERE LEFT(ucd,3)=343 AND uro = 2";
$oznac = mysql_query("$sqtoz");

//exit;

//dopln ci je zdanitelne alebo nie zdn=1 zapocitatelne, zdn=2 alebo !=1 nezapocitatelne
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid ,F$kli_vxcf"."_uctosnova".
" SET zdn=prm2".
" WHERE F$kli_vxcf"."_prcpendens$kli_uzid".".poh=F$kli_vxcf"."_uctosnova.ucc AND uro = 2";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
//zdanitelny prijem
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET prid=hod WHERE ( pox=1 AND zdn = 1 ) AND uro = 2";
$oznac = mysql_query("$sqtoz");
//zdanitelny vydaj
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET vydd=hod WHERE ( pox=2 AND zdn = 1 ) AND uro = 2";
$oznac = mysql_query("$sqtoz");
//zdanitelny prijem banka
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET prid=ucbp WHERE ( pox=4 AND zdn = 1 AND ucbp != 0 ) AND uro = 2";
$oznac = mysql_query("$sqtoz");
//zdanitelny vydaj banka
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET vydd=ucbv WHERE ( pox=4 AND zdn = 1 AND ucbv != 0 ) AND uro = 2";
$oznac = mysql_query("$sqtoz");

//zdanitelny vseobecny bez penazi
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET prid=hod WHERE ( pox=6 AND zdn = 1 )";
$oznac = mysql_query("$sqtoz");
//zdanitelny vseobecny bez penazi
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET vydd=hod WHERE ( pox=5 AND zdn = 1 )";
$oznac = mysql_query("$sqtoz");

//zaklad dane vydaj
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET zakd=prid-vydd WHERE zdn = 1 AND uro = 2";
$oznac = mysql_query("$sqtoz");

//exit;

//dopln cislo stlpca
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET ucm=0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid,F$kli_vxcf"."_uctpohybpenden2013".
" SET F$kli_vxcf"."_prcpendens$kli_uzid.ucm=F$kli_vxcf"."_uctpohybpenden2013.hod ".
" WHERE F$kli_vxcf"."_prcpendens$kli_uzid".".poh=F$kli_vxcf"."_uctpohybpenden2013.dok";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//nastav podla stlpca
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s13=hod WHERE ucm = 13 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s14=hod WHERE ucm = 14 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s15=hod WHERE ucm = 15 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s16=hod WHERE ucm = 16 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s17=hod WHERE ucm = 17 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s18=hod WHERE ucm = 18 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s19=hod WHERE ucm = 19 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s20=hod WHERE ucm = 20 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s21=hod WHERE ucm = 21 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s22=hod WHERE ucm = 22 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s23=hod WHERE ucm = 23 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s24=hod WHERE ucm = 24 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s25=hod WHERE ucm = 25 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s26=hod WHERE ucm = 26 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s27=hod WHERE ucm = 27 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s28=hod WHERE ucm = 28 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s29=hod WHERE ucm = 29 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s30=hod WHERE ucm = 30 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s31=hod WHERE ucm = 31 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s32=hod WHERE ucm = 32 ";
$oznac = mysql_query("$sqtoz");

//sumare
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s25=s25+dphp ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s30=s30+dphv ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s13=s13+s14+s15+s16 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendens$kli_uzid SET s17=s18+s19+s20+s21+s22+s23 ";
$oznac = mysql_query("$sqtoz");

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Peòažný denník</title>
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
<table class="h2" width="100%" >
<tr>
<td>
<?php if( $zandroidu == 0 ) { echo "EuroSecom "; } ?> 
<?php if( $zandroidu == 1 ) { echo "Zostava PDF prebraná, tlaèidlo Spä - do úètovných zostáv"; } ?> 
</td>
<td align="right"> </td>
</tr>
</table>
<br />


<?php

//ak sumy za doklady
if( $h_aky == 2 )
     {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendens$kli_uzid "." SELECT".
" uro,0,ume,dat,pox,poh,9999,dok,ucm,ucd,rdp,dph,ico,fak,hod,pokc,SUM(hotp),SUM(hotv),SUM(prbp),SUM(prbv),ucbc,SUM(ucbp),SUM(ucbv),".
"SUM(priu),SUM(vydu),SUM(prid),SUM(vydd),SUM(zakd),SUM(dphp),SUM(dphv),'PREVOD'".
",SUM(s13),SUM(s14),SUM(s15),SUM(s16),SUM(s17),SUM(s18),SUM(s19)".
",SUM(s20),SUM(s21),SUM(s22),SUM(s23),SUM(s24),SUM(s25),SUM(s26),SUM(s27),SUM(s28),SUM(s29),SUM(s30),SUM(s31),SUM(s32),strana,polovica,zosp,zosu ".
" FROM F$kli_vxcf"."_prcpendens$kli_uzid".
" WHERE cpl > 0".
" GROUP BY dok".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcpendens$kli_uzid WHERE zdn != 9999 ";
$oznac = mysql_query("$sqtoz");

     }
//koniec ak sumy za doklady


//vloz pre ocislovanie poloziek uro=10 bez poc.stavu dennika
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendensx$kli_uzid"." SELECT".
" uro,0,ume,dat,pox,poh,zdn,dok,ucm,ucd,rdp,dph,ico,fak,hod,pokc,hotp,hotv,prbp,prbv,ucbc,ucbp,ucbv,priu,vydu,prid,vydd,zakd,dphp,dphv,pop".
",s13,s14,s15,s16,s17,s18,s19,s20,s21,s22,s23,s24,s25,s26,s27,s28,s29,s30,s31,s32,strana,polovica,zosp,zosu ".
" FROM F$kli_vxcf"."_prcpendens$kli_uzid".
" WHERE cpl > 0 AND uro = 2".
" ORDER BY dat,dok,hod";
$dsql = mysql_query("$dsqlt");

//vypocitaj stranu
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendensx$kli_uzid SET strana=CEILING(cpl/22) ";
$oznac = mysql_query("$sqtoz");


//vloz pre ocislovanie poloziek uro=10 poc.stav dennika
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendensx$kli_uzid"." SELECT".
" uro,0,ume,dat,pox,poh,zdn,dok,ucm,ucd,rdp,dph,ico,fak,hod,pokc,hotp,hotv,prbp,prbv,ucbc,ucbp,ucbv,priu,vydu,prid,vydd,zakd,dphp,dphv,pop".
",s13,s14,s15,s16,s17,s18,s19,s20,s21,s22,s23,s24,s25,s26,s27,s28,s29,s30,s31,s32,1,polovica,zosp,zosu ".
" FROM F$kli_vxcf"."_prcpendens$kli_uzid".
" WHERE cpl > 0 AND uro = 1".
" ORDER BY dat,dok,hod";
$dsql = mysql_query("$dsqlt");

//vypocitaj zostatok
$sqtoz = "UPDATE F$kli_vxcf"."_prcpendensx$kli_uzid SET zosp=hotp-hotv, zosu=ucbp-ucbv";
$oznac = mysql_query("$sqtoz");

//exit;

//urob prevod za strany
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendensx$kli_uzid "." SELECT".
" 20,0,ume,dat,pox,poh,zdn,dok,ucm,ucd,rdp,dph,ico,fak,hod,pokc,SUM(hotp),SUM(hotv),SUM(prbp),SUM(prbv),ucbc,SUM(ucbp),SUM(ucbv),".
"SUM(priu),SUM(vydu),SUM(prid),SUM(vydd),SUM(zakd),SUM(dphp),SUM(dphv),'PREVOD'".
",SUM(s13),SUM(s14),SUM(s15),SUM(s16),SUM(s17),SUM(s18),SUM(s19)".
",SUM(s20),SUM(s21),SUM(s22),SUM(s23),SUM(s24),SUM(s25),SUM(s26),SUM(s27),SUM(s28),SUM(s29),SUM(s30),SUM(s31),SUM(s32),strana,polovica,zosp,zosu ".
" FROM F$kli_vxcf"."_prcpendensx$kli_uzid".
" WHERE cpl > 0".
" GROUP BY strana".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//urob z prevodu prenesene
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendensx$kli_uzid "." SELECT".
" 0,0,ume,dat,pox,poh,zdn,dok,ucm,ucd,rdp,dph,ico,fak,hod,pokc,SUM(hotp),SUM(hotv),SUM(prbp),SUM(prbv),ucbc,SUM(ucbp),SUM(ucbv),".
"SUM(priu),SUM(vydu),SUM(prid),SUM(vydd),SUM(zakd),SUM(dphp),SUM(dphv),'PREVOD'".
",SUM(s13),SUM(s14),SUM(s15),SUM(s16),SUM(s17),SUM(s18),SUM(s19)".
",SUM(s20),SUM(s21),SUM(s22),SUM(s23),SUM(s24),SUM(s25),SUM(s26),SUM(s27),SUM(s28),SUM(s29),SUM(s30),SUM(s31),SUM(s32),(strana+1),polovica,zosp,zosu ".
" FROM F$kli_vxcf"."_prcpendensx$kli_uzid".
" WHERE uro = 20".
" GROUP BY strana".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//vloz polovicu B
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcpendensx$kli_uzid"." SELECT".
" uro,0,ume,dat,pox,poh,zdn,dok,ucm,ucd,rdp,dph,ico,fak,hod,pokc,hotp,hotv,prbp,prbv,ucbc,ucbp,ucbv,priu,vydu,prid,vydd,zakd,dphp,dphv,pop".
",s13,s14,s15,s16,s17,s18,s19,s20,s21,s22,s23,s24,s25,s26,s27,s28,s29,s30,s31,s32,strana,'B',zosp,zosu ".
" FROM F$kli_vxcf"."_prcpendensx$kli_uzid".
" WHERE cpl > 0".
" ORDER BY dat,dok,hod";
$dsql = mysql_query("$dsqlt");

//vymaz poslednu stranu kde nie su polozky
$sqlmax = mysql_query("SELECT * FROM F$kli_vxcf"."_prcpendensx$kli_uzid ORDER by strana DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $poslstrana=$riadmax->strana;
  }

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcpendensx$kli_uzid  WHERE strana = $poslstrana";
$oznac = mysql_query("$sqtoz");

$h_zosp=0;
$h_zosu=0;
//exit;


if( $h_stp > 1 )
  {

$sqlttt = "SELECT SUM(hotp) AS shotp, SUM(hotv) AS shotv, SUM(ucbp) AS sucbp, SUM(ucbv) AS sucbv, SUM(prbp) AS sprbp, SUM(prbv) AS sprbv,  ".
"  SUM(s13) AS ss13, SUM(s14) AS ss14, SUM(s15) AS ss15 ".
" FROM F$kli_vxcf"."_prcpendensx$kli_uzid WHERE strana < $h_stp AND polovica = 'A' AND uro = 2 ";
$sqlmax = mysql_query("$sqlttt");

  if (@$zaznam=mysql_data_seek($sqlmax,0))
    {
  $polozka=mysql_fetch_object($sqlmax);
$h_zoshotp=$h_zoshotp+$polozka->shotp;
$h_zoshotv=$h_zoshotv+$polozka->shotv;
$h_zosucbp=$h_zosucbp+$polozka->sucbp;
$h_zosucbv=$h_zosucbv+$polozka->sucbv;
$h_zosprbp=$h_zosprbp+$polozka->sprbp;
$h_zosprbv=$h_zosprbv+$polozka->sprbv;
$h_zos13=$h_zos13+$polozka->ss13;
$h_zos14=$h_zos14+$polozka->ss14;
$h_zos15=$h_zos15+$polozka->ss15;
//echo "ideme ".$h_zoshotp; exit;
$Cislo=$h_zoshotp+""; $sh_hotp=sprintf("%0.2f", $Cislo);
$Cislo=$h_zoshotv+""; $sh_hotv=sprintf("%0.2f", $Cislo);
$Cislo=$h_zosucbp+""; $sh_ucbp=sprintf("%0.2f", $Cislo);
$Cislo=$h_zosucbv+""; $sh_ucbv=sprintf("%0.2f", $Cislo);
$Cislo=$h_zosprbp+""; $sh_prbp=sprintf("%0.2f", $Cislo);
$Cislo=$h_zosprbv+""; $sh_prbv=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos13+""; $sh_s13=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos14+""; $sh_s14=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos15+""; $sh_s15=sprintf("%0.2f", $Cislo);

if( $h_zoshotp == 0 ) $sh_hotp="";
if( $h_zoshotv == 0 ) $sh_hotv="";
if( $h_zosucbp == 0 ) $sh_ucbp="";
if( $h_zosucbv == 0 ) $sh_ucbv="";
if( $h_zosprbp == 0 ) $sh_prbp="";
if( $h_zosprbv == 0 ) $sh_prbv="";
if( $h_zos13 == 0 ) $sh_s13="";
if( $h_zos14 == 0 ) $sh_s14="";
if( $h_zos15 == 0 ) $sh_s15="";
    }
$sqlttt = "SELECT SUM(s16) AS s16, SUM(s17) AS s17, SUM(s18) AS s18, SUM(s19) AS s19, ".
" SUM(s20) AS s20, SUM(s21) AS s21, SUM(s22) AS s22, SUM(s23) AS s23, SUM(s24) AS s24, SUM(s25) AS s25, SUM(s26) AS s26, SUM(s27) AS s27, ".
" SUM(s28) AS s28, SUM(s29) AS s29, SUM(s30) AS s30, SUM(s31) AS s31, SUM(s32) AS s32 ".
" FROM F$kli_vxcf"."_prcpendensx$kli_uzid WHERE strana < $h_stp AND polovica = 'B' AND uro = 2 ";
$sqlmax = mysql_query("$sqlttt");

  if (@$zaznam=mysql_data_seek($sqlmax,0))
    {
  $polozka=mysql_fetch_object($sqlmax);
$h_zos16=$h_zos16+$polozka->s16;
$h_zos17=$h_zos17+$polozka->s17;
$h_zos18=$h_zos18+$polozka->s18;
$h_zos19=$h_zos19+$polozka->s19;
$h_zos20=$h_zos20+$polozka->s20;
$h_zos21=$h_zos21+$polozka->s21;
$h_zos22=$h_zos22+$polozka->s22;
$h_zos23=$h_zos23+$polozka->s23;
$h_zos24=$h_zos24+$polozka->s24;
$h_zos25=$h_zos25+$polozka->s25;
$h_zos26=$h_zos26+$polozka->s26;
$h_zos27=$h_zos27+$polozka->s27;
$h_zos28=$h_zos28+$polozka->s28;
$h_zos29=$h_zos29+$polozka->s29;
$h_zos30=$h_zos30+$polozka->s30;
$h_zos31=$h_zos31+$polozka->s31;
$h_zos32=$h_zos32+$polozka->s32;

$Cislo=$h_zos16+""; $sh_s16=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos17+""; $sh_s17=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos18+""; $sh_s18=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos19+""; $sh_s19=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos20+""; $sh_s20=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos21+""; $sh_s21=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos22+""; $sh_s22=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos23+""; $sh_s23=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos24+""; $sh_s24=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos25+""; $sh_s25=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos26+""; $sh_s26=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos27+""; $sh_s27=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos28+""; $sh_s28=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos29+""; $sh_s29=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos30+""; $sh_s30=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos31+""; $sh_s31=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos32+""; $sh_s32=sprintf("%0.2f", $Cislo);

if( $h_zos16 == 0 ) $sh_s16="";
if( $h_zos17 == 0 ) $sh_s17="";
if( $h_zos18 == 0 ) $sh_s18="";
if( $h_zos19 == 0 ) $sh_s19="";
if( $h_zos20 == 0 ) $sh_s20="";
if( $h_zos21 == 0 ) $sh_s21="";
if( $h_zos22 == 0 ) $sh_s22="";
if( $h_zos23 == 0 ) $sh_s23="";
if( $h_zos24 == 0 ) $sh_s24="";
if( $h_zos25 == 0 ) $sh_s25="";
if( $h_zos26 == 0 ) $sh_s26="";
if( $h_zos27 == 0 ) $sh_s27="";
if( $h_zos28 == 0 ) $sh_s28="";
if( $h_zos29 == 0 ) $sh_s29="";
if( $h_zos30 == 0 ) $sh_s30="";
if( $h_zos31 == 0 ) $sh_s31="";
if( $h_zos32 == 0 ) $sh_s32="";
    }

  }  


if( $h_stp != 1 OR $h_stk != 999 )
  {

$sqlmax = mysql_query("SELECT SUM(zosp) AS zosp, SUM(zosu) AS zosu FROM F$kli_vxcf"."_prcpendensx$kli_uzid WHERE strana < $h_stp AND polovica = 'A' AND ( uro = 1 OR uro = 2 ) ");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
    {
  $riadmax=mysql_fetch_object($sqlmax);
  $h_zosp=1*$riadmax->zosp;
  $h_zosu=1*$riadmax->zosu;
    }

//echo "idem";
$sqtoz = "DELETE FROM F$kli_vxcf"."_prcpendensx$kli_uzid  WHERE strana < $h_stp ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcpendensx$kli_uzid  WHERE strana > $h_stk ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

  }  


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcpendensx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcpendensx$kli_uzid".".poh=F$kli_vxcf"."_uctosnova.ucc".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcpendensx$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_uctdrdp".
" ON F$kli_vxcf"."_prcpendensx$kli_uzid".".rdp=F$kli_vxcf"."_uctdrdp.rdp".
" WHERE cpl > 0 "."ORDER BY strana,polovica,uro,cpl";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);



$cpol=0;
$strana=1;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$k=0; //zaciatok dennika nedaj prevedene
$par=0; //parne nedam biele ale sede
  while ($i <= $pol )
  {

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);


if ( $j == 0 )
      {

if( $typ == 'PDF' AND $polozka->polovica == 'A' )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

if (File_Exists ('../dokumenty/penazny_dennik2013/ekonspo1.jpg') AND $j == 0 )
{
$pdf->Image('../dokumenty/penazny_dennik2013/ekonspo1.jpg',5,5,282,185); 
}

$pdf->SetY(5);$pdf->SetX(230);$pdf->Cell(20,7,"strana $polozka->strana$polozka->polovica","0",1,"L");
$pdf->SetY(10);$pdf->SetX(0);

$pdf->Cell(0,19,"","0",1,"R");
}

if( $typ == 'PDF' AND $polozka->polovica == 'B' )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

if (File_Exists ('../dokumenty/penazny_dennik2013/ekonspo2.jpg') AND $j == 0 )
{
$pdf->Image('../dokumenty/penazny_dennik2013/ekonspo2.jpg',5,5,282,185); 
}
$pdf->SetFont('arial','B',8);
$pdf->SetY(29);$pdf->SetX(45);$pdf->Cell(20,4,"zásob","0",1,"C");
$pdf->SetY(29);$pdf->SetX(60);$pdf->Cell(20,4,"služieb","0",1,"C");
$pdf->SetY(25);$pdf->SetX(105);$pdf->Cell(20,4,"Ostatné","0",1,"C");
$pdf->SetY(29);$pdf->SetX(105);$pdf->Cell(20,4,"výdavky","0",1,"C");

$pdf->SetFont('arial','',10);
$pdf->SetY(5);$pdf->SetX(260);$pdf->Cell(20,7,"strana $polozka->strana$polozka->polovica","0",1,"L");
$pdf->SetY(10);$pdf->SetX(0);

$pdf->Cell(0,19,"","0",1,"R");
}

      }
//koniec j=0


//ak je nulova polozka daj medzeru

$h_hotp=$polozka->hotp;
if( $polozka->hotp == 0 ) $h_hotp="";
$h_hotv=$polozka->hotv;
if( $polozka->hotv == 0 ) $h_hotv="";
$h_prbp=$polozka->prbp;
if( $polozka->prbp == 0 ) $h_prbp="";
$h_prbv=$polozka->prbv;
if( $polozka->prbv == 0 ) $h_prbv="";
$h_ucbp=$polozka->ucbp;
if( $polozka->ucbp == 0 ) $h_ucbp="";
$h_ucbv=$polozka->ucbv;
if( $polozka->ucbv == 0 ) $h_ucbv="";

$h_dphp=$polozka->dphp;
if( $polozka->dphp == 0 ) $h_dphp="";
$h_dphv=$polozka->dphv;
if( $polozka->dphv == 0 ) $h_dphv="";

$h_s13=$polozka->s13;
if( $polozka->s13 == 0 ) $h_s13="";
$h_s14=$polozka->s14;
if( $polozka->s14 == 0 ) $h_s14="";
$h_s15=$polozka->s15;
if( $polozka->s15 == 0 ) $h_s15="";
$h_s16=$polozka->s16;
if( $polozka->s16 == 0 ) $h_s16="";
$h_s17=$polozka->s17;
if( $polozka->s17 == 0 ) $h_s17="";
$h_s18=$polozka->s18;
if( $polozka->s18 == 0 ) $h_s18="";
$h_s19=$polozka->s19;
if( $polozka->s19 == 0 ) $h_s19="";
$h_s20=$polozka->s20;
if( $polozka->s20 == 0 ) $h_s20="";
$h_s21=$polozka->s21;
if( $polozka->s21 == 0 ) $h_s21="";
$h_s22=$polozka->s22;
if( $polozka->s22 == 0 ) $h_s22="";
$h_s23=$polozka->s23;
if( $polozka->s23 == 0 ) $h_s23="";
$h_s24=$polozka->s24;
if( $polozka->s24 == 0 ) $h_s24="";
$h_s25=$polozka->s25;
if( $polozka->s25 == 0 ) $h_s25="";
$h_s26=$polozka->s26;
if( $polozka->s26 == 0 ) $h_s26="";
$h_s27=$polozka->s27;
if( $polozka->s27 == 0 ) $h_s27="";
$h_s28=$polozka->s28;
if( $polozka->s28 == 0 ) $h_s28="";
$h_s29=$polozka->s29;
if( $polozka->s29 == 0 ) $h_s29="";
$h_s30=$polozka->s30;
if( $polozka->s30 == 0 ) $h_s30="";
$h_s31=$polozka->s31;
if( $polozka->s31 == 0 ) $h_s31="";
$h_s32=$polozka->s32;
if( $polozka->s32 == 0 ) $h_s32="";


if( ( $polozka->uro == 1 OR $polozka->uro == 2 ) AND $polozka->polovica == 'A' )
     {
$h_zosp=$h_zosp+$polozka->zosp;
$h_zosu=$h_zosu+$polozka->zosu;
     }

$Cislo=$h_zosp+"";
$sh_zosp=sprintf("%0.2f", $Cislo);
$Cislo=$h_zosu+"";
$sh_zosu=sprintf("%0.2f", $Cislo);

if( $polozka->uro == 2 AND $polozka->polovica == 'A' )
     {
$h_zoshotp=$h_zoshotp+$polozka->hotp;
$h_zoshotv=$h_zoshotv+$polozka->hotv;
$h_zosucbp=$h_zosucbp+$polozka->ucbp;
$h_zosucbv=$h_zosucbv+$polozka->ucbv;
$h_zosprbp=$h_zosprbp+$polozka->prbp;
$h_zosprbv=$h_zosprbv+$polozka->prbv;
$h_zos13=$h_zos13+$polozka->s13;
$h_zos14=$h_zos14+$polozka->s14;
$h_zos15=$h_zos15+$polozka->s15;

$Cislo=$h_zoshotp+""; $sh_hotp=sprintf("%0.2f", $Cislo);
$Cislo=$h_zoshotv+""; $sh_hotv=sprintf("%0.2f", $Cislo);
$Cislo=$h_zosucbp+""; $sh_ucbp=sprintf("%0.2f", $Cislo);
$Cislo=$h_zosucbv+""; $sh_ucbv=sprintf("%0.2f", $Cislo);
$Cislo=$h_zosprbp+""; $sh_prbp=sprintf("%0.2f", $Cislo);
$Cislo=$h_zosprbv+""; $sh_prbv=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos13+""; $sh_s13=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos14+""; $sh_s14=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos15+""; $sh_s15=sprintf("%0.2f", $Cislo);

if( $h_zoshotp == 0 ) $sh_hotp="";
if( $h_zoshotv == 0 ) $sh_hotv="";
if( $h_zosucbp == 0 ) $sh_ucbp="";
if( $h_zosucbv == 0 ) $sh_ucbv="";
if( $h_zosprbp == 0 ) $sh_prbp="";
if( $h_zosprbv == 0 ) $sh_prbv="";
if( $h_zos13 == 0 ) $sh_s13="";
if( $h_zos14 == 0 ) $sh_s14="";
if( $h_zos15 == 0 ) $sh_s15="";

//$pdf->Cell(1,5,"x","0",0,"R");
     }

if( $polozka->uro == 2 AND $polozka->polovica == 'B' )
     {
$h_zos16=$h_zos16+$polozka->s16;
$h_zos17=$h_zos17+$polozka->s17;
$h_zos18=$h_zos18+$polozka->s18;
$h_zos19=$h_zos19+$polozka->s19;
$h_zos20=$h_zos20+$polozka->s20;
$h_zos21=$h_zos21+$polozka->s21;
$h_zos22=$h_zos22+$polozka->s22;
$h_zos23=$h_zos23+$polozka->s23;
$h_zos24=$h_zos24+$polozka->s24;
$h_zos25=$h_zos25+$polozka->s25;
$h_zos26=$h_zos26+$polozka->s26;
$h_zos27=$h_zos27+$polozka->s27;
$h_zos28=$h_zos28+$polozka->s28;
$h_zos29=$h_zos29+$polozka->s29;
$h_zos30=$h_zos30+$polozka->s30;
$h_zos31=$h_zos31+$polozka->s31;
$h_zos32=$h_zos32+$polozka->s32;

$Cislo=$h_zos16+""; $sh_s16=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos17+""; $sh_s17=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos18+""; $sh_s18=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos19+""; $sh_s19=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos20+""; $sh_s20=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos21+""; $sh_s21=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos22+""; $sh_s22=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos23+""; $sh_s23=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos24+""; $sh_s24=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos25+""; $sh_s25=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos26+""; $sh_s26=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos27+""; $sh_s27=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos28+""; $sh_s28=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos29+""; $sh_s29=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos30+""; $sh_s30=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos31+""; $sh_s31=sprintf("%0.2f", $Cislo);
$Cislo=$h_zos32+""; $sh_s32=sprintf("%0.2f", $Cislo);

if( $h_zos16 == 0 ) $sh_s16="";
if( $h_zos17 == 0 ) $sh_s17="";
if( $h_zos18 == 0 ) $sh_s18="";
if( $h_zos19 == 0 ) $sh_s19="";
if( $h_zos20 == 0 ) $sh_s20="";
if( $h_zos21 == 0 ) $sh_s21="";
if( $h_zos22 == 0 ) $sh_s22="";
if( $h_zos23 == 0 ) $sh_s23="";
if( $h_zos24 == 0 ) $sh_s24="";
if( $h_zos25 == 0 ) $sh_s25="";
if( $h_zos26 == 0 ) $sh_s26="";
if( $h_zos27 == 0 ) $sh_s27="";
if( $h_zos28 == 0 ) $sh_s28="";
if( $h_zos29 == 0 ) $sh_s29="";
if( $h_zos30 == 0 ) $sh_s30="";
if( $h_zos31 == 0 ) $sh_s31="";
if( $h_zos32 == 0 ) $sh_s32="";

//$pdf->Cell(1,5,"x","0",0,"R");
     }




//urob slovensky datum na 8miest
list ($rok, $mes, $den) = split ('[-]', $polozka->dat, 3);
$rok=$rok-2000;
$datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);
$datsk4 = sprintf("%02d.%02d.", $den, $mes );


$popis=$polozka->pop.$polozka->nuc;

if( $j == 0 ) { $pdf->Cell(37,5,"","0",0,"R");$pdf->Cell(50,5," ","0",0,"L");$pdf->Cell(0,5,"","0",1,"R");
$pdf->Cell(0,7,"","0",1,"R");
}

if( $typ == 'PDF' AND $polozka->polovica == 'A' )
{
$cpol=$cpol+1;
$spol=$j+1;
$pdf->SetFont('arial','',8);

if( $polozka->uro == 0 )
     {
$pdf->Cell(10,6,"$cpol","0",0,"R");$pdf->Cell(12,6," ","0",0,"R");$pdf->Cell(14,6," ","0",0,"R");
$pdf->SetFont('arial','',8);
$pdf->Cell(48,6,"PRENOS na stranu $polozka->strana$polozka->polovica","0",0,"L");
$pdf->SetFont('arial','',8);
     }

if( $polozka->uro == 1 )
     {
$pdf->Cell(10,6,"$cpol","0",0,"R");$pdf->Cell(12,6," ","0",0,"R");$pdf->Cell(14,6," ","0",0,"R");
$pdf->SetFont('arial','',8);
$pdf->Cell(48,6,"PRENOS na stranu $polozka->strana$polozka->polovica","0",0,"L");
$pdf->SetFont('arial','',8);
     }

if( $polozka->uro == 2 )
     {
$pdf->Cell(10,6,"$cpol","0",0,"R");$pdf->Cell(12,6,"$datsk4","0",0,"R");$pdf->Cell(14,6,"$polozka->dok","0",0,"R");
$pdf->SetFont('arial','',6);
$pdf->Cell(48,6,"$popis","0",0,"L");
$pdf->SetFont('arial','',8);
     }

if( $polozka->uro == 20 )
     {
$pdf->Cell(10,6,"$cpol","0",0,"R");$pdf->Cell(12,6," ","0",0,"R");$pdf->Cell(14,6," ","0",0,"R");
$pdf->SetFont('arial','',8);
$pdf->Cell(48,6,"PREVOD zo strany $polozka->strana$polozka->polovica","0",0,"L");
$pdf->SetFont('arial','',8);
$j=-1;
     }

if( $polozka->uro == 2 )
     {
$pdf->Cell(16,6,"$h_hotp","0",0,"R");$pdf->Cell(16,6,"$h_hotv","0",0,"R");$pdf->Cell(16,6,"$sh_zosp","0",0,"R");
$pdf->Cell(16,6,"$h_ucbp","0",0,"R");$pdf->Cell(16,6,"$h_ucbv","0",0,"R");$pdf->Cell(16,6,"$sh_zosu","0",0,"R");
$pdf->Cell(15,6,"$h_prbp","0",0,"R");$pdf->Cell(16,6,"$h_prbv","0",0,"R");

$pdf->Cell(20,6,"$h_s13","0",0,"R");$pdf->Cell(20,6,"$h_s14","0",0,"R");$pdf->Cell(21,6,"$h_s15","0",1,"R");
     }

if( $polozka->uro != 2 )
     {
$pdf->Cell(16,6,"$sh_hotp","0",0,"R");$pdf->Cell(16,6,"$sh_hotv","0",0,"R");$pdf->Cell(16,6,"$sh_zosp","0",0,"R");
$pdf->Cell(16,6,"$sh_ucbp","0",0,"R");$pdf->Cell(16,6,"$sh_ucbv","0",0,"R");$pdf->Cell(16,6,"$sh_zosu","0",0,"R");
$pdf->Cell(15,6,"$sh_prbp","0",0,"R");$pdf->Cell(16,6,"$sh_prbv","0",0,"R");

$pdf->Cell(20,6,"$sh_s13","0",0,"R");$pdf->Cell(20,6,"$sh_s14","0",0,"R");$pdf->Cell(21,6,"$sh_s15","0",1,"R");
     }

if( $spol == 5 OR $spol == 10 OR $spol == 15 OR $spol == 20 ) $pdf->Cell(20,1," ","0",1,"R");

}
//koniec polovice A

if( $typ == 'PDF' AND $polozka->polovica == 'B' )
{
$spol=$j+1;
$pdf->SetFont('arial','',8);


if( $polozka->uro == 20 )
     {
$j=-1;
     }

if( $polozka->uro == 2 )
     {
$pdf->Cell(20,6,"$h_s16","0",0,"R");$pdf->Cell(16,6,"$h_s17","0",0,"R");$pdf->Cell(16,6,"$h_s18","0",0,"R");
$pdf->Cell(16,6,"$h_s19","0",0,"R");$pdf->Cell(15,6,"$h_s20","0",0,"R");$pdf->Cell(15,6,"$h_s21","0",0,"R");
$pdf->Cell(15,6,"$h_s22","0",0,"R");$pdf->Cell(15,6,"$h_s23","0",0,"R");$pdf->Cell(15,6,"$h_s24","0",0,"R");
$pdf->Cell(15,6,"$h_s25","0",0,"R");$pdf->Cell(18,6,"$h_s26","0",0,"R");$pdf->Cell(16,6,"$h_s27","0",0,"R");
$pdf->Cell(16,6,"$h_s28","0",0,"R");$pdf->Cell(15,6,"$h_s29","0",0,"R");$pdf->Cell(15,6,"$h_s30","0",0,"R");
$pdf->Cell(18,6,"$h_s31","0",0,"R");$pdf->Cell(16,6,"$h_s32","0",1,"R");
     }

if( $polozka->uro != 2 )
     {
$pdf->Cell(20,6,"$sh_s16","0",0,"R");$pdf->Cell(16,6,"$sh_s17","0",0,"R");$pdf->Cell(16,6,"$sh_s18","0",0,"R");
$pdf->Cell(16,6,"$sh_s19","0",0,"R");$pdf->Cell(15,6,"$sh_s20","0",0,"R");$pdf->Cell(15,6,"$sh_s21","0",0,"R");
$pdf->Cell(15,6,"$sh_s22","0",0,"R");$pdf->Cell(15,6,"$sh_s23","0",0,"R");$pdf->Cell(15,6,"$sh_s24","0",0,"R");
$pdf->Cell(15,6,"$sh_s25","0",0,"R");$pdf->Cell(18,6,"$sh_s26","0",0,"R");$pdf->Cell(16,6,"$sh_s27","0",0,"R");
$pdf->Cell(16,6,"$sh_s28","0",0,"R");$pdf->Cell(15,6,"$sh_s29","0",0,"R");$pdf->Cell(15,6,"$sh_s30","0",0,"R");
$pdf->Cell(18,6,"$sh_s31","0",0,"R");$pdf->Cell(16,6,"$sh_s32","0",1,"R");
     }

if( $spol == 4 OR $spol == 8 OR $spol == 12 OR $spol == 16 ) $pdf->Cell(20,1," ","0",1,"R");

}
//koniec polovice B


}
$i = $i + 1;
$j = $j + 1;

if( $j > 23 ) $j=0;

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



$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendens'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendensx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
