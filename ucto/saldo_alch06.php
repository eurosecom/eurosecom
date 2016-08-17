<HTML>
<?php
//VYHODNOTENIE UHRAD v akej dobe pred alebo po splatnosti
$sys = 'UCT';
$urov = 1000;
$analyzy = 1*$_REQUEST['analyzy']; 
if( $analyzy == 1 ) { $sys='ANA'; $urov=1000; }
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

// cislo operacie
$copern = 1*$_REQUEST['copern'];
if( $copern == 11 ) { $copern=10; $vsetko=0; }
$drupoh = 1*$_REQUEST['drupoh'];
$h_uce = $_REQUEST['h_uce'];
$h_obd = $_REQUEST['h_obd'];

$h_icox = 1*$_REQUEST['h_ico'];
$h_ico=0;
$cislo_fak = 1*$_REQUEST['cislo_fak'];
//ci tlacit len sumy za ico alebo aj polozky
$sumico = 1*$_REQUEST['sumico'];

$h_spl = 1*$_REQUEST['h_spl'];
$h_dsp = strip_tags($_REQUEST['h_dsp']);

$pol = 1*$_REQUEST['pol'];
$dea = 1*$_REQUEST['dea'];
$h_deal = 1*$_REQUEST['h_deal'];
$uhr = 1*$_REQUEST['uhr'];
$h_datp = $_REQUEST['h_datp'];
$h_datk = $_REQUEST['h_datk'];

$vsetko=1;

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");


$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/saldo_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/saldo_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


////////////////////////////////////////////////////////datum pociatku a konca salda

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

$h_obdcel=$h_obd.".".$kli_vrok;
$pole = explode(".", $h_obdcel);
$mesp_dph=$pole[0];
$mesk_dph=$pole[0];
$rokp_dph=$pole[1];

$datp_dph=$rokp_dph.'-'.$mesp_dph.'-01';
$datk_dph=$rokp_dph.'-'.$mesk_dph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datp_dph', 0 )";
$ttqq = mysql_query("$ttvv");

$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$datp_dph',  datk=LAST_DAY('$datk_dph')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

//exit;

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

////////////////////////////////////////////////////////koniec datum pociatku a konca salda


////////////////////////////////////////////////////////////nastavenia co brat vsetky/nesparovane , obdobie

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofaknesp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_prsaldoicofakp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prsaldo
(
   pox1        INT,
   pox2        INT,
   pox         INT,
   drupoh      INT,
   uce         VARCHAR(10),
   puc         DECIMAL(10,0),
   ume         FLOAT(8,4),
   dat         DATE,
   das         DATE,
   daz         DATE,
   dok         INT(8),
   ico         DECIMAL(10,0),
   fak         DECIMAL(10,0),
   poz         VARCHAR(80),
   ksy         VARCHAR(10),
   ssy         DECIMAL(10,0),
   hdp         DECIMAL(10,2),
   hdu         DECIMAL(10,2),
   hod         DECIMAL(10,2),
   uhr         DECIMAL(10,2),
   zos         DECIMAL(10,2),
   dau         DATE,
   pox3        INT
);
prsaldo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prsaldoicofaknesp'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

if( $copern == 12 ) { $h_obd=0; $vsetko=1; $drupoh=2; }

if( $copern == 14 ) { $h_obd=0; $vsetko=1; $drupoh=4; }

if ( $h_obd == 0 ) { $datpod = ""; $daupod = ""; }
if ( $h_obd == 100 ) { $datpod = "AND ( drupoh = 7 OR drupoh = 8 )"; }
if ( $h_obd > 0 AND $h_obd < 13 ) { $datpod ="AND ( ( dat != '0000-00-00' AND dat <= '".$datk_dph."' ) OR ( dau <= '".$datk_dph."' AND dau != '0000-00-00' ) )"; }
if ( $h_obd > 0 AND $h_obd < 13 ) { $daupod ="AND ( dat != '0000-00-00' AND dat <= '".$datk_dph."' ) "; }
if ( $uhr == 1 ) { 
$h_damp=SqlDatum($h_datp);
$h_damk=SqlDatum($h_datk);
$h_obd=1;
$vsetko=1;
$datpod ="AND ( ( dat != '0000-00-00' AND dat <= '".$h_damk."' ) OR ( dau >= '".$h_damp."' AND dau <= '".$h_damk."' ) )"; 
                 }

//echo $h_obd;
//exit;

//ak vsetky obdobia zober priamo zo prsaldoicofak
if ( $h_obd == 0 ) { 

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" SELECT drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid".
" WHERE uce = $h_uce ".
" GROUP BY uce,ico,fak";
$dsql = mysql_query("$dsqlt");

                   }

//ak vybrane obdobia vyrob nove prsaldoicofak
if ( $h_obd != 0 ) { 

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" SELECT drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldo$kli_uzid".
" WHERE uce = $h_uce ".$datpod." ".
" GROUP BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

                   }


//ak je vybrany dealer vymaz ostatnych
if( $h_deal > 0 ) {
$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid WHERE ssy != $h_deal ";
$dsql = mysql_query("$dsqlt");
                  }


//zober vsetky
if ( $drupoh == 1 AND $vsetko == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1,drupoh,uce,0,ume,MAX(dat),MAX(das),MAX(daz),dok,ico,fak,".
"poz,MAX(ksy),MAX(ssy),SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau,0".
" FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" WHERE uce != 0 ".$datpod.
" GROUP BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;

}
//koniec zober vsetky


//ak je zadane ico vymaz ostatne
if ( $h_icox > 0  )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE ico != $h_icox ";
$dsql = mysql_query("$dsqlt");
}
////////////////////////////////////////////////////////////koniec nastavenia co brat

////////////////////////////////////////////////////////////uhradove doklady

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_pruhrady'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prsaldo
(
   udru         INT,
   uuce         VARCHAR(10),
   upuc         VARCHAR(10),
   uduh         DATE,
   udok         INT(8),
   uico         INT(10),
   ufak         DECIMAL(10,0),
   uhdu         DECIMAL(10,2),
   udas         DATE,
   upos         DECIMAL(10,0),
   ussy         DECIMAL(10,0),
   uodk         DECIMAL(2,0),
   uzdp         DECIMAL(2,0),
   uzcl         DECIMAL(2,0),
   upx1         DECIMAL(2,0),
   upx2         DECIMAL(2,0),
   uhod         DECIMAL(10,2),
   udph         DECIMAL(10,2),
   uuhr         DECIMAL(10,2),
   roz1         DECIMAL(10,2),
   roz2         DECIMAL(10,2),
   roz3         DECIMAL(10,2),
   udat         DATE
);
prsaldo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_pruhrady'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$psys=11;
while ($psys <= 14 ) 
  {
//zober prijmove pokl
if( $psys == 11 ) { $uctovanie="uctpokuct"; $doklad="pokpri"; }
//zober vydavkove pokl
if( $psys == 12 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psys == 13 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psys == 14 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }

if( $psys <= 14 )
{


$dsqlt = "INSERT INTO F$kli_vxcf"."_pruhrady$kli_uzid".
" SELECT 0,ucd,ucm,dat,F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.ico,fak,F$kli_vxcf"."_$uctovanie.hod,'0000-00-00',0,0 ".
" ,0,0,0,0,0,0,0,0,0,0,0,'0000-00-00' FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucd = $h_uce ".$daupod." ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt."<br />";
}

$psys=$psys+1;

  }

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_pruhrady$kli_uzid".
" SELECT 0,ucd,ucm,dat,dok,ico,fak,hod,'0000-00-00',0,0 ".
" ,0,0,0,0,0,0,0,0,0,0,0,'0000-00-00' FROM F$kli_vxcf"."_uctsklsaldo".
" WHERE ucd = $h_uce ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_pruhrady$kli_uzid".
" SELECT 0,ucd,ucm,dat,dok,ico,fak,hod,'0000-00-00',0,0 ".
" ,0,0,0,0,0,0,0,0,0,0,0,'0000-00-00' FROM F$kli_vxcf"."_uctuhradpoc".
" WHERE ucd = $h_uce ";
$dsql = mysql_query("$dsqlt");


$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid,F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SET F$kli_vxcf"."_pruhrady$kli_uzid.udas=F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.das, udru=99, ".
"     F$kli_vxcf"."_pruhrady$kli_uzid.ussy=F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.ssy, ".
"     F$kli_vxcf"."_pruhrady$kli_uzid.uuhr=F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.uhr, ".
"     F$kli_vxcf"."_pruhrady$kli_uzid.udat=F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.dat, ".
"     F$kli_vxcf"."_pruhrady$kli_uzid.uhod=F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.hod ".
" WHERE F$kli_vxcf"."_pruhrady$kli_uzid.uuce=F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.uce ".
" AND F$kli_vxcf"."_pruhrady$kli_uzid.uico=F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.ico ".
" AND F$kli_vxcf"."_pruhrady$kli_uzid.ufak=F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.fak ".
"";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$dsqlt = "DELETE FROM F$kli_vxcf"."_pruhrady$kli_uzid WHERE udru != 99 ";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET upos=TO_DAYS(uduh)-TO_DAYS(udas) ";
$oznac = mysql_query("$sqtoz");

//rozdel uhrady do druhov

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET uzdp=1, udru=99 ";
$oznac = mysql_query("$sqtoz");


$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=1 ".
" WHERE udru = 99 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 ) AND uzdp = 1 AND upos < 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=2 ".
" WHERE udru = 99 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 ) AND uzdp = 1 AND upos >= 1 AND upos <= 5 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=3 ".
" WHERE udru = 99 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 ) AND uzdp = 1 AND upos >= 6 AND upos <= 10 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=4 ".
" WHERE udru = 99 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 ) AND uzdp = 1 AND upos >= 11 AND upos <= 14 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=5 ".
" WHERE udru = 99 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 ) AND uzdp = 1 AND upos >= 15 AND upos <= 30 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=6 ".
" WHERE udru = 99 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 ) AND uzdp = 1 AND upos >= 31 AND upos <= 60 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=7 ".
" WHERE udru = 99 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 ) AND uzdp = 1 AND upos >= 61 AND upos <= 90 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=8 ".
" WHERE udru = 99 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 ) AND uzdp = 1 AND upos >= 91 AND upos <= 180 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=99 ".
" WHERE udru = 99 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 ) AND uzdp = 1 AND upos >= 181 ";
$oznac = mysql_query("$sqtoz");

$dat11=$kli_vrok."-01-01";

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=199 ".
" WHERE udru = 99 AND uduh < '$dat11' ";
$oznac = mysql_query("$sqtoz");

//if( $kli_uzid == 17 ) { exit; }

///////////////////////////////////////////////////////////koniec rozdelenia do druhov


////////////////////////////////////////////////////////////kolko po splatnosti

$dnes = SqlDatum($h_dsp);
if( $dnes == '0000-00-00' ) $dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$sqtoz = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET puc=TO_DAYS('$dnes')-TO_DAYS(das) WHERE hod != 0";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET puc=0 WHERE puc < 0 ";
$oznac = mysql_query("$sqtoz");


$nulovazostava=1;


//////////////////////////////////////////////////////////////uprava ak za vsetky ico daj sucty polehotne,dolehotne
if ( $drupoh == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,991,drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau,0".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE pox = 1 ".
" GROUP BY uce,ssy,ico";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 1,0,995,drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau,0".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE pox = 1 ".
" GROUP BY ssy";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,1,999,drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau,0".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE pox = 1 ".
" GROUP BY uce";
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;
$sumico=0;
}
//koniec uprava ak za vsetky ICO daj sucty vsetko=0

//vloz uhradove doklady
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1,20,uuce,upos,0,uduh,uduh,uduh,udok,uico,ufak,".
"'',udru,ussy,0,0,uhdu,0,0,uduh,1".
" FROM F$kli_vxcf"."_pruhrady$kli_uzid".
" WHERE uuce = $h_uce ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

if ( $h_deal > 0  )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE pox = 999 ";
$dsql = mysql_query("$dsqlt");
}

//exit;

///////////////////////////////////////////////////////////////////////////////pre vsetky ICO
if ( $copern == 10 AND $drupoh == 1 AND $h_ico == 0 )
{

$strana=0;
//zaciatok vypisu tovaru


$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_dealeri".
" ON F$kli_vxcf"."_$uctpol.ssy=F$kli_vxcf"."_dealeri.deal".
" WHERE uce = $h_uce ".
" ORDER BY pox2,ssy,pox1,nai,F$kli_vxcf"."_$uctpol.ico,pox,fak,pox3";

//echo $tovtt;
//exit;

$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
if( $tvpol > 0 ) $jetovar=1;

if( $tvpol > 0 ) $nulovazostava=0;


//Ak je tovar
if( $jetovar == 1 )
           {
$i=0;
$j=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);


if ( $j == 0 )
      {
$strana=$strana+1;

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

$pdf->Cell(90,5,"Vyhodnotenie úhrad faktúr ","0",0,"L");
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","0",1,"R");

$pdf->Cell(180,2," ","0",1,"R");


$datkdph_sk=SkDatum($datk_dph);
if( $h_obd == 0 ) $h_obdn="Všetko";
if( $h_obd > 0 AND $h_obd < 13 ) $h_obdn="do ".$datkdph_sk;
if( $h_obd == 100 ) $h_obdn="Poèiatoèný stav";

$pdf->SetFont('arial','',8);


$pdf->Cell(20,4,"Úèet: $h_uce","0",0,"L");
$pdf->Cell(25,4,"Obdobie: $h_obdn","0",0,"L");
if( $dea > 0 ) { $pdf->Cell(20,4,"Dealer: $rtov->ssy $rtov->ndea","0",0,"L"); }
$pdf->Cell(0,4," ","0",1,"L");

$pdf->Cell(6,4,"D","B",0,"L");
$pdf->Cell(20,4,"Fak/VS","B",0,"R");
$pdf->Cell(17,4,"Splatná","B",0,"L");$pdf->Cell(17,4,"Zaplatená","B",0,"L");$pdf->Cell(18,4,"Doklad","B",0,"R");
$pdf->Cell(47,4,"Firma  ","B",0,"L");
$pdf->Cell(20,4,"Faktúra","B",0,"R");$pdf->Cell(20,4,"Uhradené","B",0,"R");$pdf->Cell(0,4,"Zostatok","B",1,"R");


      }
//koniec j=0



$dat_sk=SkDatum($rtov->dat);
if( $dat_sk == '00.00.0000' ) $dat_sk=SkDatum($rtov->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk="";

$das_sk=SkDatum($rtov->das);
if( $das_sk == '00.00.0000' ) $das_sk="";

$pospl=$rtov->puc;
//if( $pospl == 0 ) $pospl="";
if( $pospl == '' ) $pospl="0";

//sumare napocet
if( $rtov->pox == 1 AND $rtov->pox3 == 0 )
           {
$hod = $hod + $rtov->hod;
$Cislo=$hod+"";
$Shod=sprintf("%0.2f", $Cislo);
$uhrad = $uhrad + $rtov->uhr;
$Cislo=$uhrad+"";
$Suhr=sprintf("%0.2f", $Cislo);
$zos = $zos + $rtov->zos;
$Cislo=$zos+"";
$Szos=sprintf("%0.2f", $Cislo);
           }

if( $rtov->pox == 1 )
           {
if( $rtov->pox3 == 0 )
{
$pdf->Cell(6,4," ","0",0,"L");
$pdf->Cell(20,5,"$rtov->fak","0",0,"R");
$pdf->Cell(17,5,"$das_sk","0",0,"L");$pdf->Cell(17,4,"$dau_sk","0",0,"L");$pdf->Cell(18,4,"$rtov->dok","0",0,"R");
$pdf->Cell(47,5,"$rtov->nai","0",0,"L");
$pdf->Cell(20,5,"$rtov->hod","0",0,"R");$pdf->Cell(20,4,"$rtov->uhr","0",0,"R");$pdf->Cell(0,4,"$rtov->zos","0",1,"R");
}

if( $rtov->pox3 == 1 )
           {
$pdf->Cell(6,4,"$rtov->ksy","0",0,"L");$pdf->Cell(20,5,"$rtov->fak","0",0,"R");$pdf->Cell(17,4," ","0",0,"L");
$pdf->Cell(17,4,"$dat_sk","0",0,"L");$pdf->Cell(17,4,"$rtov->dok","0",0,"R");
$pdf->Cell(66,4,"Po splatnosti $pospl dní","0",0,"L");$pdf->Cell(20,5,"$rtov->hod","0",1,"R");
           }

if( $rtov->pox3 == 1) { 
     $druhuhr=1*$rtov->ksy;

     if( $druhuhr == 1 ) $stlp1=$stlp1+$rtov->hod;
     if( $druhuhr == 2 ) $stlp2=$stlp2+$rtov->hod;
     if( $druhuhr == 3 ) $stlp3=$stlp3+$rtov->hod;
     if( $druhuhr == 4 ) $stlp4=$stlp4+$rtov->hod;
     if( $druhuhr == 5 ) $stlp5=$stlp5+$rtov->hod;
     if( $druhuhr == 6 ) $stlp6=$stlp6+$rtov->hod;
     if( $druhuhr == 7 ) $stlp7=$stlp7+$rtov->hod;
     if( $druhuhr == 8 ) $stlp8=$stlp8+$rtov->hod;
     if( $druhuhr == 9 ) $stlp9=$stlp9+$rtov->hod;
     if( $druhuhr == 99 ) $stlp10=$stlp10+$rtov->hod;
     if( $druhuhr == 199 ) $stlp20=$stlp20+$rtov->hod;
     if( $druhuhr != '' ) $stlp11=$stlp11+$rtov->hod;

     if( $druhuhr == 1 ) $prem1=$prem1+$rtov->hdp;
     if( $druhuhr == 2 ) $prem2=$prem2+$rtov->hdp;
     if( $druhuhr == 3 ) $prem3=$prem3+$rtov->hdp;
     if( $druhuhr == 4 ) $prem4=$prem4+$rtov->hdp;
     if( $druhuhr == 5 ) $prem5=$prem5+$rtov->hdp;
     if( $druhuhr == 6 ) $prem6=$prem6+$rtov->hdp;
     if( $druhuhr == 7 ) $prem7=$prem7+$rtov->hdp;
     if( $druhuhr == 8 ) $prem8=$prem8+$rtov->hdp;
     if( $druhuhr == 9 ) $prem9=$prem9+$rtov->hdp;
     if( $druhuhr == 99 ) $prem10=$prem10+$rtov->hdp;
     if( $druhuhr != '' ) $prem11=$prem11+$rtov->hdp;
                  }

           }

if( $rtov->pox == 991 )
           {
if( $sumico == 0 AND $uhr == 0 )
{
$pdf->Cell(25,4,"spolu za IÈO:","T",0,"L");$pdf->Cell(100,4,"$rtov->ico, $rtov->nai, $rtov->mes","0",0,"L");
$pdf->Cell(20,4,"$rtov->hod","T",0,"R");$pdf->Cell(20,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1," ","0",1,"L");
}
if( $sumico == 1 AND $uhr == 0 )
{
$pdf->Cell(25,4,"spolu za IÈO:","T",0,"L");$pdf->Cell(100,4,"$rtov->ico, $rtov->nai, $rtov->mes","0",0,"L");
$pdf->Cell(20,4,"$rtov->hod","T",0,"R");$pdf->Cell(20,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1," ","0",1,"L");
}
           }

$dealery=0;
if( $rtov->pox == 995 )
           {
if( $sumico == 0 AND $uhr == 0 AND $dealery == 1 )
{
$pdf->Cell(25,4,"SPOLU DEALER $rtov->ssy $rtov->ndea ","T",0,"L");$pdf->Cell(100,4," ","T",0,"L");
$pdf->Cell(20,4,"$rtov->hod","T",0,"R");$pdf->Cell(20,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1,"","0",1,"L");
}
if( $sumico == 1 AND $uhr == 0 AND $dealery == 1 )
{
$pdf->Cell(25,4,"SPOLU DEALER $rtov->ssy $rtov->ndea ","T",0,"L");$pdf->Cell(100,4," ","T",0,"L");
$pdf->Cell(20,4,"$rtov->hod","T",0,"R");$pdf->Cell(20,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1,"","0",1,"L");
}

$prem1=2*$stlp1/100;
$prem2=1*$stlp2/100;
$prem3=0.25*$stlp3/100;
$prem4=0.5*$stlp4/100;
$prem5=-1*$stlp5/100;
$prem6=-2*$stlp6/100;
$prem7=1*$stlp7/100;
$prem8=-1*$stlp8/100;
$prem9=0;

$prem11=$prem1+$prem2+$prem3+$prem4+$prem5+$prem6+$prem7+$prem8+$prem9;

$Cislo=$stlp1+"";
$Sstlp1=sprintf("%0.2f", $Cislo);
$Cislo=$prem1+"";
$Sprem1=sprintf("%0.2f", $Cislo);

$Cislo=$stlp2+"";
$Sstlp2=sprintf("%0.2f", $Cislo);
$Cislo=$prem2+"";
$Sprem2=sprintf("%0.2f", $Cislo);

$Cislo=$stlp3+"";
$Sstlp3=sprintf("%0.2f", $Cislo);
$Cislo=$prem3+"";
$Sprem3=sprintf("%0.2f", $Cislo);

$Cislo=$stlp4+"";
$Sstlp4=sprintf("%0.2f", $Cislo);
$Cislo=$prem4+"";
$Sprem4=sprintf("%0.2f", $Cislo);

$Cislo=$stlp5+"";
$Sstlp5=sprintf("%0.2f", $Cislo);
$Cislo=$prem5+"";
$Sprem5=sprintf("%0.2f", $Cislo);

$Cislo=$stlp6+"";
$Sstlp6=sprintf("%0.2f", $Cislo);
$Cislo=$prem6+"";
$Sprem6=sprintf("%0.2f", $Cislo);

$Cislo=$stlp7+"";
$Sstlp7=sprintf("%0.2f", $Cislo);
$Cislo=$prem7+"";
$Sprem7=sprintf("%0.2f", $Cislo);

$Cislo=$stlp8+"";
$Sstlp8=sprintf("%0.2f", $Cislo);
$Cislo=$prem8+"";
$Sprem8=sprintf("%0.2f", $Cislo);

$Cislo=$stlp10+"";
$Sstlp10=sprintf("%0.2f", $Cislo);
$Cislo=$prem10+"";
$Sprem10=sprintf("%0.2f", $Cislo);

$Cislo=$stlp11+"";
$Sstlp11=sprintf("%0.2f", $Cislo);
$Cislo=$prem11+"";
$Sprem11=sprintf("%0.2f", $Cislo);

$Cislo=$stlp20+"";
$Sstlp20=sprintf("%0.2f", $Cislo);


$pdf->Cell(100,4," ","0",1,"L");
$pdf->Cell(60,4,"Druh","B",0,"L");$pdf->Cell(15,4," ","B",0,"R");$pdf->Cell(40,4,"Uhradené","B",0,"R");$pdf->Cell(40,4," ","0",1,"R");

$pdf->Cell(60,4,"01 Zaplatená v splatnosti","T",0,"L");$pdf->Cell(15,4," ","B",0,"R");$pdf->Cell(40,4,"$Sstlp1","0",0,"R");$pdf->Cell(40,4," ","0",1,"R");
$pdf->Cell(60,4,"02 Zaplatená do 5dní po splatnosti","T",0,"L");$pdf->Cell(15,4," ","B",0,"R");$pdf->Cell(40,4,"$Sstlp2","T",0,"R");$pdf->Cell(40,4," ","0",1,"R");
$pdf->Cell(60,4,"03 Zaplatená do 10dní po splatnosti","T",0,"L");$pdf->Cell(15,4," ","B",0,"R");$pdf->Cell(40,4,"$Sstlp3","T",0,"R");$pdf->Cell(40,4," ","0",1,"R");
$pdf->Cell(60,4,"04 Zaplatená do 14dní po splatnosti","T",0,"L");$pdf->Cell(15,4," ","B",0,"R");$pdf->Cell(40,4,"$Sstlp4","T",0,"R");$pdf->Cell(40,4," ","0",1,"R");
$pdf->Cell(60,4,"05 Zaplatená do 30dní po splatnosti","T",0,"L");$pdf->Cell(15,4," ","B",0,"R");$pdf->Cell(40,4,"$Sstlp5","T",0,"R");$pdf->Cell(40,4," ","0",1,"R");
$pdf->Cell(60,4,"06 Zaplatená do 60dní po splatnosti","T",0,"L");$pdf->Cell(15,4," ","B",0,"R");$pdf->Cell(40,4,"$Sstlp6","T",0,"R");$pdf->Cell(40,4," ","0",1,"R");
$pdf->Cell(60,4,"07 Zaplatená do 90dní po splatnosti","T",0,"L");$pdf->Cell(15,4," ","B",0,"R");$pdf->Cell(40,4,"$Sstlp7","T",0,"R");$pdf->Cell(40,4," ","0",1,"R");
$pdf->Cell(60,4,"08 Zaplatená do 180dní po splatnosti","T",0,"L");$pdf->Cell(15,4," ","B",0,"R");$pdf->Cell(40,4,"$Sstlp8","T",0,"R");$pdf->Cell(40,4," ","0",1,"R");
$pdf->Cell(60,4,"99 Zaplatená nad 180dní po splatnosti","T",0,"L");$pdf->Cell(15,4," ","B",0,"R");$pdf->Cell(40,4,"$Sstlp10","T",0,"R");$pdf->Cell(40,4," ","0",1,"R");
$pdf->Cell(60,4,"199 Úhrady z minulých období","T",0,"L");$pdf->Cell(15,4," ","B",0,"R");$pdf->Cell(40,4,"$Sstlp20","T",0,"R");$pdf->Cell(40,4," ","0",1,"R");

$pdf->Cell(60,4,"Spolu","T",0,"L");$pdf->Cell(15,4," ","T",0,"R");$pdf->Cell(40,4,"$Sstlp11","T",0,"R");$pdf->Cell(40,4," ","0",1,"R");


$stlp1=0; $stlp2=0; $stlp3=0; $stlp4=0; $stlp5=0; $stlp6=0; $stlp7=0; $stlp8=0; $stlp9=0; $stlp10=0; $stlp11=0; $stlp20=0; 
$prem1=0; $prem2=0; $prem3=0; $prem4=0; $prem5=0; $prem6=0; $prem7=0; $prem8=0; $prem9=0; $prem10=0; $prem11=0; 

           }


if( $rtov->pox == 999 )
           {
$pdf->Cell(90,3,"","0",1,"L");

if( $sumico == 0 AND $uhr == 0 )
{
$pdf->Cell(25,4,"SPOLU všetky IÈO:","T",0,"L");$pdf->Cell(100,4," ","T",0,"L");
$pdf->Cell(20,4,"$rtov->hod","T",0,"R");$pdf->Cell(20,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1,"","0",1,"L");
}
if( $sumico == 1 AND $uhr == 0 )
{
$pdf->Cell(25,4,"SPOLU všetky IÈO:","T",0,"L");$pdf->Cell(100,4," ","T",0,"L");
$pdf->Cell(20,4,"$rtov->hod","T",0,"R");$pdf->Cell(20,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1,"","0",1,"L");
}

           }

$rtovpox=$rtov->pox;
}
$i = $i + 1;
$j = $j + 1; 
if( $j >= 54 ) { $j=0; }
  }

           }
//koniec ak je tovar




}
//////////////////////////////////////////////////////////////////////////////////////////////////koniec pre vsetky ICO








if( $nulovazostava == 1 )
{
   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

if( $h_ico > 0 ) $pdf=new FPDF("P","mm","A4");
if( $h_ico == 0 ) $pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

if( $vsetko == 1 ) { $pdf->Cell(90,5,"Saldokonto","LTB",0,"L"); }
if( $vsetko == 0 AND $pol == 0 ) { $pdf->Cell(90,5,"Saldokonto dolehotné","LTB",0,"L"); }
if( $vsetko == 0 AND $pol == 1 ) { $pdf->Cell(90,5,"Saldokonto polehotné","LTB",0,"L"); }
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(180,2," ","0",1,"R");

$pdf->Cell(105,4,"Prázdna zostava","0",1,"R");

}



$pdf->Output("$outfilex");


?> 

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Saldo PDF</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    
</script>
</HEAD>
<BODY class="white" >

<?php 



?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Saldokonto PDF formát</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php 

if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 4 )
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_pruhrady'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofaknesp'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_prsaldoicofakp'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
}

?>


<a href="../tmp/test<?php echo $kli_uzid; ?>.pdf">../tmp/test<?php echo $kli_uzid; ?>.pdf</a>


<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
