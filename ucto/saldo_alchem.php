<HTML>
<?php
//VYTLACI SALDOKONTO VO FORMATE PDF
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
$vsetko=1;
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

//echo $h_spl." ".$h_dsp;

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$pol30 = 1*$_REQUEST['pol30']; 

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/saldo_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/saldo_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

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
   dau         DATE
);
prsaldo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prsaldoicofaknesp'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

if( $copern == 12 ) { $h_obd=0; $vsetko=1; $drupoh=2; }

if( $copern == 14 ) { $h_obd=0; $vsetko=1; $drupoh=4; }

if ( $h_obd == 0 ) { $datpod = ""; }
if ( $h_obd == 100 ) { $datpod = "AND ( drupoh = 7 OR drupoh = 8 )"; }
if ( $h_obd > 0 AND $h_obd < 13 ) { $datpod ="AND ( ( dat != '0000-00-00' AND dat <= '".$datk_dph."' ) OR ( dau <= '".$datk_dph."' AND dau != '0000-00-00' ) )"; }
if ( $uhr == 1 ) { 
$h_damp=SqlDatum($h_datp);
$h_damk=SqlDatum($h_datk);
$h_obd=1;
$vsetko=1;
$datpod ="AND ( ( dat != '0000-00-00' AND dat <= '".$h_damk."' ) OR ( dau >= '".$h_damp."' AND dau <= '".$h_damk."' ) )"; 
                 }

//ak vsetky obdobia zober priamo zo prsaldoicofak
if ( $h_obd == 0 ) { 

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" SELECT drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid".
" WHERE uce > 0 ".
" GROUP BY uce,ico,fak";
$dsql = mysql_query("$dsqlt");

                   }

//ak vybrane obdobia vyrob nove prsaldoicofak
if ( $h_obd != 0 AND $uhr == 0 ) { 

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" SELECT drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldo$kli_uzid".
" WHERE uce = $h_uce ".$datpod." ".
" GROUP BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

                   }

if ( $h_obd != 0 AND $uhr == 1 ) { 

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" SELECT drupoh,uce,999,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,0,0,0,uhr,0,dau".
" FROM F$kli_vxcf"."_prsaldo$kli_uzid".
" WHERE uce = $h_uce ".$datpod." ".
" ORDER BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_prsaldoicofakp$kli_uzid SET hdp=uhr WHERE drupoh = 13 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prsaldoicofakp$kli_uzid SET hdu=uhr  WHERE drupoh = 11 OR drupoh = 12 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prsaldoicofakp$kli_uzid SET hod=uhr WHERE drupoh = 14 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prsaldoicofakp$kli_uzid SET zos=hdp+hdu+hod WHERE drupoh >= 11 AND drupoh <= 14 ";
$oznac = mysql_query("$sqtoz");

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" SELECT drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,MAX(ssy),SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),MAX(dau)".
" FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" WHERE puc = 999 AND uce = $h_uce ".
" GROUP BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid WHERE puc=999 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid WHERE dau < '".$h_damp."' OR dau > '".$h_damk."' ";
$dsql = mysql_query("$dsqlt");

//exit;

if( $h_deal > 0 ) {
$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid WHERE ssy != $h_deal ";
$dsql = mysql_query("$dsqlt");
                  }

//if( $kli_uzid == 17 ) exit;
                   }
//koniec vyrobenia noveho saldoicofak podla obdobia


//zober vsetky
if ( $drupoh == 1 AND $vsetko == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1,drupoh,uce,0,ume,MAX(dat),MAX(das),MAX(daz),dok,ico,fak,".
"poz,MAX(ksy),MAX(ssy),SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" WHERE uce != 0 ".$datpod.
" GROUP BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;

}
//koniec zober vsetky

//uprava ak len nesparovane vsetko=0
if ( $drupoh == 1 AND $vsetko == 0 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1,drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" WHERE zos != 0 AND uce = $h_uce ".$datpod.
" GROUP BY uce,ico,fak";
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;
}
//koniec uprava ak len nesparovane vsetko=0

//ak je zadane ico vymaz ostatne
if ( $h_icox > 0  )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE ico != $h_icox ";
$dsql = mysql_query("$dsqlt");
}
////////////////////////////////////////////////////////////koniec nastavenia co brat


////////////////////////////////////////////////////////////kolko po splatnosti

$dnes = SqlDatum($h_dsp);
if( $dnes == '0000-00-00' ) $dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$sqtoz = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET puc=TO_DAYS('$dnes')-TO_DAYS(das) WHERE hod != 0";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET puc=0 WHERE puc < 0 ";
$oznac = mysql_query("$sqtoz");


if( $pol == 9 ) {
$tovtt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE puc > 0 AND pox = 1";
$tov = mysql_query("$tovtt");
                }

if( $pol == 1 ) {
$tovtt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE puc = 0 AND pox = 1";
$tov = mysql_query("$tovtt");
                }

if( $pol30 == 1 ) {

$tovtt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE dat < '2016-02-01' ";
$tov = mysql_query("$tovtt");

$tovtt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE puc < 30 ";
$tov = mysql_query("$tovtt");

                  }


$nulovazostava=1;

//uprava ak za vsetky ico daj sucty polehotne,dolehotne
if ( $drupoh == 1 AND $h_ico == 0 AND $pol > 0 AND $dea == 0 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,991,drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE uce != 0 ".
" GROUP BY uce,ico";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,1,999,drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE pox = 1 ".
" GROUP BY uce";
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;
$sumico=0;
}
//koniec uprava ak za vsetky ICO daj sucty vsetko=0


if( $dea == 1 AND $uhr == 0 ) {

$podmssy="( ssy = 2 AND ssy = 3 )";
if( $h_deal > 0 ) $podmssy="( ssy != ".$h_deal." )";

$tovtt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE $podmssy AND pox = 1";
$tov = mysql_query("$tovtt");
                }

if( $dea == 1 AND $uhr == 1 ) {

$tovtt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE uhr = 0 ";
$tov = mysql_query("$tovtt");
                }


//uprava ak za vsetky ico daj sucty polehotne,dolehotne
if ( $drupoh == 1 AND $h_ico == 0 AND $dea > 0 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,991,drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE pox = 1 ".
" GROUP BY uce,ssy,ico";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 1,0,995,drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE pox = 1 ".
" GROUP BY ssy";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,1,999,drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE pox = 1 ".
" GROUP BY uce";
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;
$sumico=0;
}
//koniec uprava ak za vsetky ICO daj sucty vsetko=0

if( $dea == 1 AND $uhr == 1 ) {

$tovtt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE pox = 1";
$tov = mysql_query("$tovtt");
                }

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

if ( $pol > 0 )
{
$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE uce = $h_uce ".
" ORDER BY pox2,nai,F$kli_vxcf"."_$uctpol.ico,pox,dat,dok";
}

if ( $pol > 0 AND $emotrans == 1 )
{
$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE uce = $h_uce ".
" ORDER BY pox2,nai,F$kli_vxcf"."_$uctpol.ico,pox,puc DESC,dok";
}

if ( $dea > 0 )
{
$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_dealeri".
" ON F$kli_vxcf"."_$uctpol.ssy=F$kli_vxcf"."_dealeri.deal".
" WHERE uce = $h_uce ".
" ORDER BY pox2,ssy,pox1,nai,F$kli_vxcf"."_$uctpol.ico,pox";
}

$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
if( $tvpol > 0 ) $jetovar=1;

if( $tvpol > 0 ) $nulovazostava=0;

//exit;

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

$akesal="Poh¾adávky";
if( substr($h_uce,0,2) == '32' ) $akesal="Záväzky";
if( $vsetko == 0 AND $pol == 9 AND $dea == 0 ) { $pdf->Cell(90,5,"$akesal dolehotné k $h_dsp","0",0,"L"); }
if( $vsetko == 0 AND $pol == 1 AND $dea == 0 ) { $pdf->Cell(90,5,"$akesal polehotné k $h_dsp","0",0,"L"); }
if( $vsetko == 0 AND $pol == 9 AND $dea == 1 ) { $pdf->Cell(90,5,"$akesal dolehotné za dealerov k $h_dsp","0",0,"L"); }
if( $vsetko == 0 AND $pol == 1 AND $dea == 1 ) { $pdf->Cell(90,5,"$akesal polehotné za dealerov k $h_dsp","0",0,"L"); }
if( $vsetko == 0 AND $dea == 1 AND $uhr == 0 AND $pol == 0 ) { $pdf->Cell(90,5,"$akesal za dealerov k $h_dsp","0",0,"L"); }
if( $vsetko == 1 AND $dea == 1 AND $uhr == 1 ) { $pdf->Cell(90,5,"Úhrady za dealerov od $h_datp do $h_datk","0",0,"L"); }
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","0",1,"R");

$pdf->Cell(180,2," ","0",1,"R");


$datkdph_sk=SkDatum($datk_dph);
if( $h_obd == 0 ) $h_obdn="Všetko";
if( $h_obd > 0 AND $h_obd < 13 ) $h_obdn="do ".$datkdph_sk;
if( $h_obd == 100 ) $h_obdn="Poèiatoèný stav";

$pdf->SetFont('arial','',8);

if( $uhr == 0 )
{
$pdf->Cell(20,4,"Úèet: $h_uce","0",0,"L");
$pdf->Cell(25,4,"Obdobie: $h_obdn","0",0,"L");
if( $dea > 0 ) { $pdf->Cell(20,4,"Dealer: $rtov->ssy $rtov->ndea","0",0,"L"); }
$pdf->Cell(0,4," ","0",1,"L");

$pdf->Cell(20,4,"Fak/VS","B",0,"R");
$pdf->Cell(17,4,"Vystavená","B",0,"L");$pdf->Cell(17,4,"Splatná","B",0,"L");$pdf->Cell(6,4,"po","B",0,"L");$pdf->Cell(18,4,"Doklad","B",0,"R");
$pdf->Cell(47,4,"Firma  ","B",0,"L");
$pdf->Cell(20,4,"Faktúra","B",0,"R");$pdf->Cell(20,4,"Uhradené","B",0,"R");$pdf->Cell(0,4,"Zostatok","B",1,"R");
}
if( $uhr == 1 )
{
$pdf->Cell(20,4,"Úèet: $h_uce","0",0,"L");
if( $dea > 0 ) { $pdf->Cell(20,4,"Dealer: $rtov->ssy $rtov->ndea","0",0,"L"); }
$pdf->Cell(0,4," ","0",1,"L");

$pdf->Cell(60,4,"Firma","B",0,"L");
$pdf->Cell(18,4," ","B",0,"R");
$pdf->Cell(27,4," ","B",0,"L");
$pdf->Cell(20,4,"Uhradené","B",0,"R");
$pdf->Cell(20,4,"Cez banku","B",0,"R");$pdf->Cell(20,4,"V hotovosti","B",0,"R");$pdf->Cell(0,4,"Iné","B",1,"R");
}

if( $sumico == 1 ) $j=1;
      }
//koniec j=0



$dat_sk=SkDatum($rtov->dat);
if( $dat_sk == '00.00.0000' ) $dat_sk=SkDatum($rtov->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk="";

$das_sk=SkDatum($rtov->das);
if( $das_sk == '00.00.0000' ) $das_sk="";

$pospl=$rtov->puc;
if( $pospl == 0 ) $pospl="";

//sumare napocet
if( $rtov->pox == 1 )
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
if( $sumico == 0 )
{
$pdf->Cell(20,5,"$rtov->fak","0",0,"R");
$pdf->Cell(17,5,"$dat_sk","0",0,"L");$pdf->Cell(17,4,"$das_sk","0",0,"L");$pdf->Cell(6,4,"$pospl","0",0,"L");$pdf->Cell(18,4,"$rtov->dok","0",0,"R");
$pdf->Cell(47,5,"$rtov->nai","0",0,"L");
$pdf->Cell(20,5,"$rtov->hod","0",0,"R");$pdf->Cell(20,4,"$rtov->uhr","0",0,"R");$pdf->Cell(0,4,"$rtov->zos","0",1,"R");

}
if( $h_spl == 1 ) { 
     if( $pospl <  1 ) $stlp1=$stlp1+$rtov->zos;
     if( $pospl == 1 ) $stlp2=$stlp2+$rtov->zos;
     if( $pospl == 2 ) $stlp3=$stlp3+$rtov->zos;
     if( $pospl == 3 ) $stlp4=$stlp4+$rtov->zos;
     if( $pospl == 4 ) $stlp5=$stlp5+$rtov->zos;
     if( $pospl == 5 ) $stlp6=$stlp6+$rtov->zos;
     if( $pospl >  5 ) $stlp7=$stlp7+$rtov->zos;
     if( $pospl >  0 ) $stlp8=$stlp8+$rtov->zos;
                  }
if( $h_spl == 2 ) { 
     if( $pospl <  1 ) $stlp1=$stlp1+$rtov->zos;
     if( $pospl >  0 AND $pospl <=  5 ) $stlp2=$stlp2+$rtov->zos;
     if( $pospl >  5 AND $pospl <= 14 ) $stlp3=$stlp3+$rtov->zos;
     if( $pospl > 14 AND $pospl <= 30 ) $stlp4=$stlp4+$rtov->zos;
     if( $pospl > 30 AND $pospl <= 60 ) $stlp5=$stlp5+$rtov->zos;
     if( $pospl > 60 AND $pospl <= 90 ) $stlp6=$stlp6+$rtov->zos;
     if( $pospl > 90 ) $stlp7=$stlp7+$rtov->zos;
     if( $pospl >  0 ) $stlp8=$stlp8+$rtov->zos;
                  }
if( $h_spl == 3 ) { 
     if( $pospl <   1 ) $stlp1=$stlp1+$rtov->zos;
     if( $pospl >   0 AND $pospl <=  30 ) $stlp2=$stlp2+$rtov->zos;
     if( $pospl >  30 AND $pospl <=  60 ) $stlp3=$stlp3+$rtov->zos;
     if( $pospl >  60 AND $pospl <=  90 ) $stlp4=$stlp4+$rtov->zos;
     if( $pospl >  90 AND $pospl <= 180 ) $stlp5=$stlp5+$rtov->zos;
     if( $pospl > 180 AND $pospl <= 360 ) $stlp6=$stlp6+$rtov->zos;
     if( $pospl > 360 ) $stlp7=$stlp7+$rtov->zos;
     if( $pospl >  0 ) $stlp8=$stlp8+$rtov->zos;
                  }
if( $h_spl == 4 ) { 
     if( $pospl <    1 ) $stlp1=$stlp1+$rtov->zos;
     if( $pospl >    0 AND $pospl <=  180 ) $stlp2=$stlp2+$rtov->zos;
     if( $pospl >  180 AND $pospl <=  360 ) $stlp3=$stlp3+$rtov->zos;
     if( $pospl >  360 AND $pospl <=  720 ) $stlp4=$stlp4+$rtov->zos;
     if( $pospl >  720 AND $pospl <= 1080 ) $stlp5=$stlp5+$rtov->zos;
     if( $pospl > 1080 AND $pospl <= 1440 ) $stlp6=$stlp6+$rtov->zos;
     if( $pospl > 1440 ) $stlp7=$stlp7+$rtov->zos;
     if( $pospl >  0 ) $stlp8=$stlp8+$rtov->zos;
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
if( $uhr == 1 )
{
$pdf->Cell(25,4,"spolu za IÈO:","T",0,"L");$pdf->Cell(80,4,"$rtov->ico, $rtov->nai, $rtov->mes","0",0,"L");
$pdf->Cell(20,4,"$rtov->zos","T",0,"R");
$pdf->Cell(20,4,"$rtov->hdp","T",0,"R");$pdf->Cell(20,4,"$rtov->hdu","T",0,"R");$pdf->Cell(0,4,"$rtov->hod ","T",1,"R");
$pdf->Cell(90,1," ","0",1,"L");
}
           }

if( $rtov->pox == 995 )
           {
if( $sumico == 0 AND $uhr == 0 )
{
$pdf->Cell(25,4,"SPOLU DEALER $rtov->ssy $rtov->ndea ","T",0,"L");$pdf->Cell(100,4," ","T",0,"L");
$pdf->Cell(20,4,"$rtov->hod","T",0,"R");$pdf->Cell(20,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1,"","0",1,"L");
}
if( $sumico == 1 AND $uhr == 0 )
{
$pdf->Cell(25,4,"SPOLU DEALER $rtov->ssy $rtov->ndea ","T",0,"L");$pdf->Cell(100,4," ","T",0,"L");
$pdf->Cell(20,4,"$rtov->hod","T",0,"R");$pdf->Cell(20,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1,"","0",1,"L");
}
if( $uhr == 1 )
{
$pdf->Cell(25,4,"SPOLU DEALER $rtov->ssy $rtov->ndea ","T",0,"L");$pdf->Cell(80,4," ","T",0,"L");
$pdf->Cell(20,4,"$rtov->zos","T",0,"R");
$pdf->Cell(20,4,"$rtov->hdp","T",0,"R");$pdf->Cell(20,4,"$rtov->hdu","T",0,"R");$pdf->Cell(0,4,"$rtov->hod ","T",1,"R");
$pdf->Cell(90,1,"","0",1,"L");
}
$j=-1;
           }


if( $rtov->pox == 999 )
           {
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
if( $uhr == 1 )
{
$pdf->Cell(25,4,"SPOLU všetky IÈO:","T",0,"L");$pdf->Cell(80,4," ","T",0,"L");
$pdf->Cell(20,4,"$rtov->zos","T",0,"R");
$pdf->Cell(20,4,"$rtov->hdp","T",0,"R");$pdf->Cell(20,4,"$rtov->hdu","T",0,"R");$pdf->Cell(0,4,"$rtov->hod ","T",1,"R");
$pdf->Cell(90,1,"","0",1,"L");
}
           }

$rtovpox=$rtov->pox;
}
$i = $i + 1;
//if( $sumico == 0 ) { $j = $j + 1; }
$j = $j + 1; 
//if( $sumico == 0 AND $rtovpox == 991 ) { $j = $j + 1; }
if( $j >= 56 AND $sumico == 0 ) { $j=0; }
//if( $sumico == 1 AND $rtovpox == 991 ) { $j = $j + 1; }
if( $j >= 32 AND $sumico == 1 ) { $j=0; }
  }

           }
//koniec ak je tovar


//vyhodnotenie splatnosti
if( $h_spl > 0 )
     {
$pdf->Cell(90,5,"","0",1,"L");
$pdf->Cell(160,5,"Neuhradené faktúry rozdelené pod¾a doby po splatnosti k $h_dsp","0",1,"L");
if( $h_spl == 1 ) { 
$pdf->Cell(23,4,"Do lehoty","1",0,"R");$pdf->Cell(23,4,"Po lehote","1",0,"R");
$pdf->Cell(23,4,"1deò po","1",0,"R");$pdf->Cell(23,4,"2dni po","1",0,"R");$pdf->Cell(23,4,"3dni po","1",0,"R");
$pdf->Cell(23,4,"4dni po","1",0,"R");$pdf->Cell(23,4,"5dní po","1",0,"R");$pdf->Cell(23,4,"Viacdní po","1",1,"R");
                  }
if( $h_spl == 2 ) { 
$pdf->Cell(23,4,"Do lehoty","1",0,"R");$pdf->Cell(23,4,"Po lehote","1",0,"R");
$pdf->Cell(23,4,"do 5dní po","1",0,"R");$pdf->Cell(23,4,"do 14dní po","1",0,"R");$pdf->Cell(23,4,"do 30dní po","1",0,"R");
$pdf->Cell(23,4,"do 60dní po","1",0,"R");$pdf->Cell(23,4,"do 90dní po","1",0,"R");$pdf->Cell(23,4,"Viacdní po","1",1,"R");
                  }
if( $h_spl == 3 ) { 
$pdf->Cell(23,4,"Do lehoty","1",0,"R");$pdf->Cell(23,4,"Po lehote","1",0,"R");
$pdf->Cell(23,4,"do 30dní po","1",0,"R");$pdf->Cell(23,4,"do 60dní po","1",0,"R");$pdf->Cell(23,4,"do 90dní po","1",0,"R");
$pdf->Cell(23,4,"do 180dní po","1",0,"R");$pdf->Cell(23,4,"do 360dní po","1",0,"R");$pdf->Cell(23,4,"Viacdní po","1",1,"R");
                  }
if( $h_spl == 4 ) { 
$pdf->Cell(23,4,"Do lehoty","1",0,"R");$pdf->Cell(23,4,"Po lehote","1",0,"R");
$pdf->Cell(23,4,"do 180dní po","1",0,"R");$pdf->Cell(23,4,"do 360dní po","1",0,"R");$pdf->Cell(23,4,"do 720dní po","1",0,"R");
$pdf->Cell(23,4,"do 1080dní po","1",0,"R");$pdf->Cell(23,4,"do 1440dní po","1",0,"R");$pdf->Cell(23,4,"nad 1440dní po","1",1,"R");
                  }

$pdf->Cell(23,4,"$stlp1","1",0,"R");$pdf->Cell(23,4,"$stlp8","1",0,"R");
$pdf->Cell(23,4,"$stlp2","1",0,"R");$pdf->Cell(23,4,"$stlp3","1",0,"R");$pdf->Cell(23,4,"$stlp4","1",0,"R");
$pdf->Cell(23,4,"$stlp5","1",0,"R");$pdf->Cell(23,4,"$stlp6","1",0,"R");$pdf->Cell(23,4,"$stlp7","1",1,"R");
     }
//koniec vyhodnotenie splatnosti


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



$pdf->Output("$outfilex")


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
