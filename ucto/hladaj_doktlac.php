<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 1000;
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

//tlacove okno
$tlcuwin="width=700, height=900, top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


$cit_nas = include("../cis/citaj_nas.php");
$cit_fir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;
if (File_Exists ("../tmp/penden.$kli_uzid.pdf")) { $soubor = unlink("../tmp/penden.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$navysku = 1*$_REQUEST['navysku'];
if( $navysku == 0 ) $pdf=new FPDF("L","mm","A4");
if( $navysku == 1 ) $pdf=new FPDF("P","mm","A4"); 

$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$vyb_ume=$kli_vume;
$vyb_umep=$kli_vume;
$vyb_umek=$kli_vume;
$h_obdp=$kli_vmes;
$h_obdk=$kli_vmes;

//if( $copern == 32 OR $copern == 22 OR $copern == 12 ) { $copern=$copern-2; }
if( $copern == 31 OR $copern == 21 OR $copern == 11 ) { 
$h_obdp = 1*$_REQUEST['h_obdp'];
$h_obdk = 1*$_REQUEST['h_obdk'];
if( $h_obdp == 0 ) $h_obdp=1;
if( $h_obdk == 0 ) $h_obdk=12;
$vyb_ume=$h_obdk.".".$kli_vrok;
$vyb_umep=$h_obdp.".".$kli_vrok;
$vyb_umek=$h_obdk.".".$kli_vrok;
$copern=$copern-1;
                    }

$cislo_uce = 1*$_REQUEST['cislo_uce'];
$h_ucenula = $_REQUEST['cislo_uce'];
$cislo_ucm = 1*$_REQUEST['cislo_ucm'];
$cislo_ucd = 1*$_REQUEST['cislo_ucd'];
$h_ico = 1*$_REQUEST['h_ico'];
$h_fak = 1*$_REQUEST['h_fak'];
$h_dok = 1*$_REQUEST['h_dok'];
$h_do2 = 1*$_REQUEST['h_do2'];
$h_txt = $_REQUEST['h_txt'];
$h_hop = 1*$_REQUEST['h_hop'];
$h_hopnula = $_REQUEST['h_hop'];
$h_hok = 1*$_REQUEST['h_hok'];
$h_hoco = 1*$_REQUEST['h_hoco'];
$h_hocd = 1*$_REQUEST['h_hocd'];
$h_hoc = 1*$_REQUEST['h_hoc'];
$h_rdp = 1*$_REQUEST['h_rdp'];
$h_datp = $_REQUEST['h_datp'];
$h_datk = $_REQUEST['h_datk'];
$h_datp = SqlDatum($h_datp);
$h_datk = SqlDatum($h_datk);
$h_datps = SkDatum($h_datp);
$h_datks = SkDatum($h_datk);
$cislo_udo = 1*$_REQUEST['cislo_udo'];
$h_str = 1*$_REQUEST['h_str'];
$h_zak = 1*$_REQUEST['h_zak'];
$h_sys = 1*$_REQUEST['h_sys'];
$h_strtxt = $_REQUEST['h_str'];
$strdlzka=1*strlen($h_strtxt);
//echo $strdlzka;

//echo $h_hopnula." ".$h_ucenula;

//vytvorenie pracovneho suboru pre hlavnu knihu a pohyby na ucte polozkovite

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihas'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihasx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihasy'.$kli_uzid;
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
   mdt          DECIMAL(10,2),
   dal          DECIMAL(10,2),
   zos          DECIMAL(10,2),
   pop          VARCHAR(80),
   pox          INT(10),
   cel          DECIMAL(10,2),
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

//ak h_hoc == 0 nehladam cudziu menu
if( $h_hoc == 0 )
          {
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

//rychle podmienky
$pox1="";
$pox2="";

if( $h_ico > 0 ) $podico1=" AND ( F$kli_vxcf"."_$uctovanie.ico = ".$h_ico." ) ";
if( $h_fak > 0 ) $podfak1=" AND ( F$kli_vxcf"."_$uctovanie.fak = ".$h_fak." ) ";
if( $h_str >= 0 AND $strdlzka > 0 ) $podstr1=" AND ( F$kli_vxcf"."_$uctovanie.str = ".$h_str." ) ";
if( $h_zak > 0 ) $podzak1=" AND ( F$kli_vxcf"."_$uctovanie.zak = ".$h_zak." ) ";

if( $h_dok > 0 AND $h_do2 == 0 ) $poddok1=" AND ( F$kli_vxcf"."_$uctovanie.dok = ".$h_dok." ) ";
if( $h_dok > 0 AND $h_do2 > 0 ) $poddok1=" AND ( F$kli_vxcf"."_$uctovanie.dok >= ".$h_dok." AND F$kli_vxcf"."_$uctovanie.dok <= ".$h_do2." ) ";

if( $h_ico > 0 ) $podico2=" AND ( ico = ".$h_ico." ) ";
if( $h_fak > 0 ) $podfak2=" AND ( fak = ".$h_fak." ) ";
if( $h_str >= 0 AND $strdlzka > 0 ) $podstr2=" AND ( str = ".$h_str." ) ";
if( $h_zak > 0 ) $podzak2=" AND ( zak = ".$h_zak." ) ";

if( $h_dok > 0 AND $h_do2 == 0 ) $poddok2=" AND ( dok = ".$h_dok." ) ";
if( $h_dok > 0 AND $h_do2 > 0 ) $poddok2=" AND ( dok >= ".$h_dok." AND dok <= ".$h_do2." ) ";


$pox1=$pox1.$podfak1.$podico1.$poddok1.$podstr1.$podzak1;
$pox2=$pox2.$podfak2.$podico2.$poddok2.$podstr2.$podzak2;
//koniec rychle podmienky

if( $psys <= 6 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,F$kli_vxcf"."_$uctovanie.dok,ucm,1,ucd,ucm,ucd,rdp,F$kli_vxcf"."_$uctovanie.ico,F$kli_vxcf"."_$uctovanie.fak,".
"F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak,F$kli_vxcf"."_$uctovanie.hod,F$kli_vxcf"."_$uctovanie.hod,0,0,CONCAT(txp, ' ', pop),1,F$kli_vxcf"."_$doklad.hodu".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ume >= $vyb_umep AND ume <= $vyb_umek $pox1";
$dsql = mysql_query("$dsqlt");
}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,dok,ucm,1,ucd,ucm,ucd,rdp,ico,fak,".
"str,zak,hod,hod,0,0,pop,1,0".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE  ume >= $vyb_umep AND ume <= $vyb_umek $pox2";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
}
$psys=$psys+1;
  }

          }
//koniec ak h_hoc == 0

//ak h_hoc > 0 hladam cudziu menu
if( $h_hoc > 0 )
          {
$pox1="AND hodm = $h_hoc ";
$pox2="AND hodm = $h_hoc ";
$psys=1;
while ($psys <= 6 ) 
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

if( $psys == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" $psys,1,0,0,'',dok,ucm,1,0,ucm,ucd,1,ico,fak,".
"0,0,hodm,hodm,0,0,pop,1,0".
" FROM F$kli_vxcf"."_$uctovanie ".
" WHERE poh = 1 $pox2  ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" $psys,1,0,0,'',dok,uce,1,0,uce,0,1,ico,0,".
"0,0,hodm,hodm,0,0,txp,1,0".
" FROM F$kli_vxcf"."_$doklad ".
" WHERE dok > 0 $pox2  ";
$dsql = mysql_query("$dsqlt");
}
if( $psys == 2 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" $psys,1,0,0,'',dok,ucd,1,0,ucm,ucd,1,ico,fak,".
"0,0,hodm,hodm,0,0,pop,1,0".
" FROM F$kli_vxcf"."_$uctovanie ".
" WHERE poh = 2 $pox2";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" $psys,1,0,0,'',dok,uce,1,0,0,uce,1,ico,0,".
"0,0,hodm,hodm,0,0,txp,1,0".
" FROM F$kli_vxcf"."_$doklad ".
" WHERE dok > 0 $pox2  ";
$dsql = mysql_query("$dsqlt");
}
if( $psys == 3 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" $psys,1,0,0,'',dok,ucd,1,0,ucm,ucd,1,ico,fak,".
"0,0,hodm,hodm,0,0,pop,1,0".
" FROM F$kli_vxcf"."_$uctovanie ".
" WHERE $pox2";
$dsql = mysql_query("$dsqlt");
}
if( $psys == 5 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,dok,uce,1,0,0,0,1,ico,fak,".
"0,0,hodm,hodm,0,0,txp,1,0".
" FROM F$kli_vxcf"."_$doklad ".
" WHERE  ume >= $vyb_umep AND ume <= $vyb_umek $pox2";
$dsql = mysql_query("$dsqlt");
}
if( $psys == 6 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,dok,uce,1,0,0,uce,1,ico,fak,".
"0,0,hodm,hodm,0,0,txp,1,0".
" FROM F$kli_vxcf"."_$doklad ".
" WHERE  ume >= $vyb_umep AND ume <= $vyb_umek $pox2";
$dsql = mysql_query("$dsqlt");
}
$psys=$psys+1;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_prchlknihas$kli_uzid,F$kli_vxcf"."_pokpri "." SET".
" F$kli_vxcf"."_prchlknihas$kli_uzid.ume=F$kli_vxcf"."_pokpri.ume, F$kli_vxcf"."_prchlknihas$kli_uzid.dat=F$kli_vxcf"."_pokpri.dat ".
" WHERE F$kli_vxcf"."_prchlknihas$kli_uzid.dok=F$kli_vxcf"."_pokpri.dok ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_prchlknihas$kli_uzid,F$kli_vxcf"."_pokvyd "." SET".
" F$kli_vxcf"."_prchlknihas$kli_uzid.ume=F$kli_vxcf"."_pokvyd.ume, F$kli_vxcf"."_prchlknihas$kli_uzid.dat=F$kli_vxcf"."_pokvyd.dat ".
" WHERE F$kli_vxcf"."_prchlknihas$kli_uzid.dok=F$kli_vxcf"."_pokvyd.dok ";
$dsql = mysql_query("$dsqlt");

          }
//koniec ak h_hoc > 0

//urob podmienku
$podnul="pox = 1";
$poduce="";
$poducm="";
$poducd="";
$podico="";
$podfak="";
$poddok="";
$podhod="";
$podcel="";
$podrdp="";
$poddat="";
$podstr="";

if( $kli_vduj != 9 ) {
    if( $cislo_udo == 0 ) {
if( $cislo_uce > 0 AND $cislo_uce < 999 ) $poduce=" AND ( LEFT(ucm,3) = ".$cislo_uce." OR LEFT(ucd,3) = ".$cislo_uce." ) ";
if( $cislo_uce > 0 AND $cislo_uce >= 999 ) $poduce=" AND ( ucm = ".$cislo_uce." OR ucd = ".$cislo_uce." ) ";
                          }
    if( $cislo_udo > 0 )  {
                       $poduce=" AND ( ( ucm >= ".$cislo_uce." AND ucm <= ".$cislo_udo." ) OR ( ucd >= ".$cislo_uce." AND ucd <= ".$cislo_udo." ) ) ";
                          }
if( $cislo_ucm > 0 AND $cislo_ucm < 999 ) $poducm=" AND ( LEFT(ucm,3) = ".$cislo_ucm." ) ";
if( $cislo_ucm > 0 AND $cislo_ucm >= 999 ) $poducm=" AND ( ucm = ".$cislo_ucm." ) ";
if( $cislo_ucd > 0 AND $cislo_ucd < 999 ) $poducd=" AND ( LEFT(ucd,3) = ".$cislo_ucd." ) ";
if( $cislo_ucd > 0 AND $cislo_ucd >= 999 ) $poducd=" AND ( ucd = ".$cislo_ucd." ) ";

}
if( $kli_vduj == 9 ) {
if( $cislo_uce > 0 ) $poduce=" AND ( ucm = ".$cislo_uce." OR ucd = ".$cislo_uce." ) ";
if( $cislo_ucm > 0 ) $poducm=" AND ( ucm = ".$cislo_ucm." ) ";
if( $cislo_ucd > 0 ) $poducd=" AND ( ucd = ".$cislo_ucd." ) ";

}

if( $h_ico > 0 ) $podico=" AND ( ico = ".$h_ico." ) ";
if( $h_fak > 0 ) $podfak=" AND ( fak = ".$h_fak." ) ";
if( $h_str >= 0 AND $strdlzka > 0 ) $podstr=" AND ( str = ".$h_str." ) ";
if( $h_zak > 0 ) $podzak=" AND ( zak = ".$h_zak." ) ";

if( $h_dok > 0 AND $h_do2 == 0 ) $poddok=" AND ( dok = ".$h_dok." ) ";
if( $h_dok > 0 AND $h_do2 > 0 ) $poddok=" AND ( dok >= ".$h_dok." AND dok <= ".$h_do2." ) ";

if( $h_txt != '' ) $podtxt=" AND ( pop LIKE '%".$h_txt."%' ) ";
if( $h_hop != 0 AND $h_hok == 0 ) $podhod=" AND ( hod = ".$h_hop." ) ";
if( $h_hop != 0 AND $h_hok != 0 ) $podhod=" AND ( hod >= ".$h_hop." AND hod <= ".$h_hok." ) ";
if( $h_hoco != 0 AND $h_hocd == 0 ) $podcel=" AND ( cel = ".$h_hoco." ) ";
if( $h_hoco != 0 AND $h_hocd != 0 ) $podcel=" AND ( cel >= ".$h_hoco." AND cel <= ".$h_hocd." ) ";
if( $h_rdp != 0 ) $podrdp=" AND ( rdp = ".$h_rdp." ) ";

if( $h_datp != '2009-01-01' OR $h_datk != '2009-12-31' ) $poddat=" AND ( dat >= '".$h_datp."' AND dat <= '".$h_datk."' ) ";

$podmienka=$podnul.$poduce.$poducm.$poducd.$podfak.$podico.$poddok.$podtxt.$podhod.$podcel.$podrdp.$poddat.$podstr.$podzak;
if( $h_ucenula == '0' ) $podmienka="( ucm = '0' OR ucd = '0' ) ";
if( $h_hopnula == '0' ) $podmienka="( hod = 0 ) ";

//echo $podmienka;
//exit;

//tu vyberieme polozky
$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" psys,1,0,ume,dat,dok,ucm,1,ucd,ucm,ucd,rdp,ico,fak,".
"str,zak,hod,hod,0,0,pop,2,cel".
" FROM F$kli_vxcf"."_prchlknihas$kli_uzid".
" WHERE $podmienka";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//aaaa
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Vypis hæadan˝ch dokladov</title>
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
   
function VytlacPokl(drupoh, uce, doklad)
    {
    var hladaj_dok = uce;
    var drupohx = drupoh;
    var cislo_dok = doklad;
    window.open('vspk_pdf.php?sysx=UCT&rozuct=ANO&hladaj_dok=' + hladaj_dok + '&copern=20&drupoh=' + drupohx + '&page=&cislo_dok=' + cislo_dok + '&fff=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

    }

function TlacRozuctPDF(drupoh, uce, doklad)
                {    
    var hladaj_dok = uce;
    var drupohx = drupoh;
    var cislo_dok = doklad;

window.open('../faktury/vstf_pdf.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=' + drupohx + '&hladaj_uce=' + hladaj_dok + '&page=1&cislo_dok=' + cislo_dok + '&tlacitR=1&fff=1&mini=1','_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');

                }
 
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
<?php
if( $h_hopnula == "" ) $h_hop="";
if( $h_ucenula == "" ) $cislo_uce="";

$podmienkay=urlencode($podmienka);
?>
  <a href="#" onClick="window.open('hladaj_doktlac.php?copern=31&drupoh=1&page=1&cislo_uce=<?php echo $cislo_uce; ?>&h_do2=<?php echo $h_do2; ?>
&h_obdk=<?php echo $h_obdk; ?>&h_obdp=<?php echo $h_obdp; ?>&cislo_ucm=<?php echo $cislo_ucm; ?>&cislo_ucd=<?php echo $cislo_ucd; ?>
&h_ico=<?php echo $h_ico; ?>&h_fak=<?php echo $h_fak; ?>&h_dok=<?php echo $h_dok; ?>&h_txt=<?php echo $h_txt; ?>&h_hop=<?php echo $h_hop; ?>
&h_hok=<?php echo $h_hok; ?>&h_hoco=<?php echo $h_hoco; ?>&h_hocd=<?php echo $h_hocd; ?>&h_rdp=<?php echo $h_rdp; ?>&h_sys=<?php echo $h_sys; ?>
&h_datp=<?php echo $h_datps; ?>&h_datk=<?php echo $h_datks; ?>&h_str=<?php echo $h_strtxt; ?>&h_zak=<?php echo $h_zak; ?>&cislo_udo=<?php echo $cislo_udo; ?>
&typ=PDF&podmienkax=<?php echo $podmienkay; ?>', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=25 height=15 border=0 title='VytlaËiù vo form·te PDF na öÌrku' ></a>

  <a href="#" onClick="window.open('hladaj_doktlac.php?copern=31&drupoh=1&page=1&cislo_uce=<?php echo $cislo_uce; ?>&h_do2=<?php echo $h_do2; ?>
&h_obdk=<?php echo $h_obdk; ?>&h_obdp=<?php echo $h_obdp; ?>&cislo_ucm=<?php echo $cislo_ucm; ?>&cislo_ucd=<?php echo $cislo_ucd; ?>
&h_ico=<?php echo $h_ico; ?>&h_fak=<?php echo $h_fak; ?>&h_dok=<?php echo $h_dok; ?>&h_txt=<?php echo $h_txt; ?>&h_hop=<?php echo $h_hop; ?>
&h_hok=<?php echo $h_hok; ?>&h_hoco=<?php echo $h_hoco; ?>&h_hocd=<?php echo $h_hocd; ?>&h_rdp=<?php echo $h_rdp; ?>&h_sys=<?php echo $h_sys; ?>
&h_datp=<?php echo $h_datps; ?>&h_datk=<?php echo $h_datks; ?>&h_str=<?php echo $h_strtxt; ?>&h_zak=<?php echo $h_zak; ?>&cislo_udo=<?php echo $cislo_udo; ?>
&typ=PDF&podmienkax=<?php echo $podmienkay; ?>&navysku=1', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=20 border=0 title='VytlaËiù vo form·te PDF na v˝öku' ></a>


</td>
<td align="right">
<span class="login"><?php echo "UME $vyb_ume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
<?php
}
?>

<?php


$sqltt = "SELECT * FROM F$kli_vxcf"."_prchlknihas$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prchlknihas$kli_uzid.ico=F$kli_vxcf"."_ico.ico".
" WHERE cpl > 0 AND pox = 2 "."ORDER BY dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

//exit;

//sumare napocet
$hotz = 0.00;

//////////////////////////////////////////////////////////////////
if ( $copern == 30 OR copern == 40 OR copern == 20 )
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
$podmienkax = $_REQUEST['podmienkax'];
$pole = explode("ox = 1 AND", $podmienkax);
$ppp1=$pole[0];
$ppp2=$pole[1];

$pdf->Cell(80,5,"VyhæadanÈ poloûky ","LTB",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(0,3,"FIR$kli_vxcf $kli_nxcf strana $strana","RT",1,"R");
$pdf->SetFont('arial','',6);
$dnesoktime = Date ("d.m.Y H:i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$pdf->Cell(0,2,"$dnesoktime","RB",1,"R");


$pdf->Cell(0,5,"Podmienka: $ppp2","0",1,"L");
$pdf->SetFont('arial','',8);

$pdf->Cell(12,4,"Poloûka","1",0,"R");$pdf->Cell(14,4,"D·tum","1",0,"R");$pdf->Cell(15,4,"Doklad","1",0,"R");
$pdf->Cell(12,4,"M·Daù","1",0,"R");$pdf->Cell(12,4,"Dal","1",0,"R");$pdf->Cell(24,4,"Hodnota","1",0,"R");
$pdf->Cell(8,4,"DRD","1",0,"R");$pdf->Cell(18,4,"Fakt˙ra","1",0,"R");
$pdf->Cell(18,4,"I»O","1",0,"R");$pdf->Cell(6,4,"STR","LTB",0,"L");$pdf->Cell(9,4,"ZAK","RTB",0,"R");
$pdf->Cell(0,4,"Popis","1",1,"L");
}


if( $typ == 'HTML' )
{
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" colspan="8"><?php echo "VyhæadanÈ poloûky x"; ?>
 <img src='../obr/help.png' width=12 height=12 border=0 title="Podmienka <?php echo $podmienka; ?> ">
</td>
<td class="bmenu" colspan="8" align="right"><?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?></td>
</tr>

<tr>
<td class="bmenu" width="7%">Poloûka</td>
<td class="bmenu" width="7%">D·tum</td>
<td class="bmenu" width="10%">Doklad</td>

<td class="hvstup_zlte" width="8%">M·Daù</td>
<td class="hvstup_zlte" width="8%" align="right">Dal</td>
<td class="hvstup_zlte" width="9%" align="right">Hodnota</td>
<td class="hvstup_zlte" width="2%" align="right">DRD</td>
<td class="hvstup_zlte" width="8%" align="right">Fakt˙ra</td>

<td class="bmenu" width="8%" align="right">I»O</td>
<td class="bmenu" width="5%" align="right">STR/ZAK</td>
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


$h_hotz=$polozka->hod;

//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $polozka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);

//sumare napocet
$hotz=$hotz+$h_hotz;
$Cislo=$hotz+"";
$shotz=sprintf("%0.2f", $Cislo);


$popis=$polozka->pop;
if( $polozka->nai != '' ) $popis=$popis.$polozka->nai.$polozka->mes;

if( $typ == 'PDF' )
{

$pdf->Cell(12,4,"$polozka->cpl","0",0,"R");$pdf->Cell(14,4,"$datsk","0",0,"R");$pdf->Cell(15,4,"$polozka->dok","0",0,"R");

$pdf->Cell(12,4,"$polozka->ucm","0",0,"R");$pdf->Cell(12,4,"$polozka->ucd","0",0,"R");$pdf->Cell(24,4,"$polozka->hod","0",0,"R");
$pdf->Cell(8,4,"$polozka->rdp","0",0,"R");$pdf->Cell(18,4,"$polozka->fak","0",0,"R");

$pdf->Cell(18,4,"$polozka->ico","0",0,"R");$pdf->Cell(6,4,"$polozka->str","0",0,"L");$pdf->Cell(9,4,"$polozka->zak","0",0,"R");
$pdf->Cell(0,4,"$popis","0",1,"L");

}
//aaaa
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
 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranÈho pokladniËnÈho prÌjmovÈho dokladu" ></a>
<a href="#" onClick="VytlacPokl(1, <?php echo $polozka->ucm;?>, <?php echo $polozka->dok;?>);">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho pokladniËnÈho prÌjmovÈho dokladu" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 2 )
  { ?>
<?php if( substr($polozka->ucd,0,3) == 211 ) { $hladaj_ucex=$polozka->ucd; $h_ucex=$polozka->ucd; } ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&hladaj_uce=<?php echo $hladaj_ucex;?>&h_uce=<?php echo $h_ucex;?>&rozuct=ANO&copern=8&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranÈho pokladniËnÈho v˝davkovÈho dokladu" ></a>
<a href="#" onClick="VytlacPokl(2, <?php echo $polozka->ucd;?>, <?php echo $polozka->dok;?>);">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho pokladniËnÈho v˝davkovÈho dokladu" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 3 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=4&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranÈho bankovÈho v˝pisu " ></a>
<a href="#" onClick="VytlacPokl(4, <?php echo $polozka->ucm;?>, <?php echo $polozka->dok;?>);">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho bankovÈho v˝pisu " ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 4 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=5&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranÈho vöeobecnÈho ˙ËtovnÈho dokladu" ></a>
<a href="#" onClick="VytlacPokl(5, <?php echo $polozka->ucm;?>, <?php echo $polozka->dok;?>);">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho vöeobecnÈho ˙ËtovnÈho dokladu" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 5 )
  { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranej odberateæskej fakt˙ry" ></a>
<a href="#" onClick="TlacRozuctPDF(1, <?php echo $polozka->ucm;?>, <?php echo $polozka->dok;?>);">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranej odberateæskej fakt˙ry" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 6 )
  { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranej dod·vateæskej fakt˙ry" ></a>
<a href="#" onClick="TlacRozuctPDF(2, <?php echo $polozka->ucm;?>, <?php echo $polozka->dok;?>);">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranej dod·vateæskej fakt˙ry" ></a>
<?php 
  } ?>
<?php
}
?>
<?php echo $polozka->dok;?>

</td>

<td class="hvstup_zlte"><?php echo $polozka->ucm; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->ucd; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->hod; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->rdp; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->fak; ?></td>

<td class="hvstup" align="right"><?php echo $polozka->ico; ?></td>
<td class="hvstup" align="right"><?php echo $polozka->str; ?>/<?php echo $polozka->zak; ?></td>
<td class="hvstup" ><?php echo $popis; ?></td>

</tr>
<?php
}


}
$i = $i + 1;
$j = $j + 1;

//koniec stranky
$maxpocetriadkov=40;
if( $navysku == 1 ) $maxpocetriadkov=58;
if( $j >= $maxpocetriadkov )
      {


$strana=$strana+1;
$j=0;
      }
//koniec bloku na koniec stranky



  }
//koniec polozky


if( $typ == 'PDF' )
{
//tlac sumare
$pdf->Cell(41,5,"Spolu hodnota","1",0,"L");
 
$pdf->Cell(12,5," ","1",0,"R");$pdf->Cell(12,5," ","1",0,"R");$pdf->Cell(24,5,"$shotz","1",0,"R");$pdf->Cell(26,5,"","1",1,"R");

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
<td class="hvstup_tzlte" align="right"> </td>
<td class="hvstup_tzlte" align="right"><?php echo $shotz; ?></td>
<td class="hvstup_tzlte" align="right"> </td>
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
$pdf->SetFont('arial','',8);
$pdf->Cell(0,3,"FIR$kli_vxcf $kli_nxcf strana $strana","RT",1,"R");
$pdf->SetFont('arial','',6);
$dnesoktime = Date ("d.m.Y H:i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$pdf->Cell(0,2,"$dnesoktime","RB",1,"R");

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
//////////////////////////////////////////////////////////////////koniec tlace
      }
?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihas'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihasx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihasy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


// celkovy koniec dokumentu
$cislista = include("uct_lista.php");

       } while (false);
?>
</BODY>
</HTML>
