<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

//vytlacit zapocet

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
$vsetko=0;
if( $copern == 11 ) { $copern=10; $vsetko=0; }
$drupoh = 1*$_REQUEST['drupoh'];
$h_uce = $_REQUEST['h_uce'];
$h_obd = 1*$_REQUEST['h_obd'];
$h_ico = 1*$_REQUEST['h_ico'];
$cislo_fak = 1*$_REQUEST['cislo_fak'];
//ci tlacit len sumy za ico alebo aj polozky
$sumico = 1*$_REQUEST['sumico'];

$h_spl = 1*$_REQUEST['h_spl'];
$h_dsp = strip_tags($_REQUEST['h_dsp']);

$pohladavky=1;
$uce3=substr($h_uce,0,3);
if( $uce3 == 321 OR $uce3 == 379 ) $pohladavky=0;

$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));


$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");



if (File_Exists ("../tmp/inventura$cislo_dok.$kli_uzid.pdf")) { $soubor = unlink("../tmp/inventura$cislo_dok.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//pracovny subor zo salda

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

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];


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
   puc         VARCHAR(10),
   ume         FLOAT(8,4),
   dat         DATE,
   das         DATE,
   daz         DATE,
   dok         INT(8),
   ico         INT(10),
   fak         DECIMAL(10,0),
   poz         VARCHAR(80),
   ksy         VARCHAR(10),
   ssy         VARCHAR(10),
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


if ( $h_obd == 0 ) { $datpod = ""; }
if ( $h_obd == 100 ) { $datpod = "AND ( drupoh = 7 OR drupoh = 8 )"; }
if ( $h_obd > 0 AND $h_obd < 13 ) { $datpod = "AND ( ( dat != '0000-00-00' AND dat <= '".$datk_dph."' ) OR ( dau <= '".$datk_dph."' AND dau != '0000-00-00' ) )"; }

//ak vsetky obdobia zober priamo zo prsaldoicofak
if ( $h_obd == 0 ) { 

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" SELECT drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid".
" WHERE uce = $h_uce ".
" GROUP BY uce,ico,fak";
$dsql = mysql_query("$dsqlt");
                   }

//ak vybrane obdobia vyrob nove prsaldoicofak
if ( $h_obd != 0 ) { 

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" SELECT drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldo$kli_uzid".
" WHERE uce = $h_uce ".$datpod." ".
" GROUP BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;
                   }
//koniec vyrobenia noveho saldoicofak podla obdobia



if ( $h_ico > 0 ) { 

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid WHERE ico != $h_ico ";
$dsql = mysql_query("$dsqlt");
                  }


//uprava ak len nesparovane vsetko=0
if ( $drupoh == 1 AND $vsetko == 0 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1,drupoh,uce,puc,ume,MAX(dat),MAX(das),MAX(daz),dok,ico,fak,".
"poz,MAX(ksy),MAX(ssy),SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" WHERE zos != 0 ".$datpod.
" GROUP BY uce,ico,fak";
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;
}
//koniec uprava ak len nesparovane vsetko=0

//exit;

//sumar za ico
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,998,drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE uce != 0 ".
" GROUP BY uce,ico";
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;


//suma za ucet
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 999,0,999,drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE uce != 0 AND pox = 1 ".
" GROUP BY uce";
$dsql = mysql_query("$dsqlt");


//koniec pracovny subor zo salda

//zacni tlacit

$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE pox >= 0 ".
" ORDER BY pox1,nai,mes,pox,fak";
//echo $tovtt;

if( $uce3 == 324 AND $alchem == 1 ) { $pohladavky=0; }

//////////////////////////////////////////////////////ak nie je email
if ( $posem != 1 )
          {

$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
$koniec=$tvpol-1;
if( $tvpol > 0 ) $jetovar=1;
$jednapolozka=0;
if( $tvpol == 1 ) $jednapolozka=1;

//Ak su polozky
if( $jetovar == 1 )
           {
$j=0;
$i=0;
  while ($i <= $koniec )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

$dat_sk=SkDatum($rtov->dat);
if( $dat_sk == "00.00.0000" ) $dat_sk="";
$das_sk=SkDatum($rtov->das);
if( $das_sk == "00.00.0000" ) $das_sk="";
$dad_sk=SkDatum($dnes);
if( $dad_sk == "00.00.0000" ) $dad_sk="";

$uhr=$rtov->uhr;
if( $uhr == 0 ) $uhr="";

if( $j == 0 AND $rtov->pox1 != 999 )
    {
$celkomstrana=0;

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15);

$sety=10;
$pdf->SetY($sety);


$pdf->SetFont('arial','',10);


$pdf->Cell(130,6,"$fir_fnaz, $fir_fuli $fir_fcdm, $fir_fpsc, $fir_fmes ","B",0,"L");
$pdf->Cell(50,6,"I�O: $fir_fico DI�: $fir_fdic","B",1,"R");

$pdf->SetFont('arial','',10);

$pdf->Cell(180,5,"     ","0",1,"L");

$metalcomimor=0;
if( $kli_vume == 8.2011 AND $metalco == 1 ) { $metalcomimor=1; }
$amagro=0;
//if( $alchem == 1 AND $kli_vxcf != 543 AND $kli_vxcf != 553 AND $kli_vxcf != 563 AND $kli_vxcf != 573 ) { $alchem=0; $amagro=1; }

if( $pohladavky == 1 AND $metalcomimor == 1 ) { $pdf->Cell(180,13," ","0",1,"L"); }

$pdf->Cell(90,6,"$fir_fmes d�a: $dnes","0",0,"L");$pdf->Cell(180,6,"$rtov->nai $rtov->na2","0",1,"L");
$pdf->Cell(90,6,"                     ","0",0,"L");$pdf->Cell(180,6,"$rtov->uli","0",1,"L");
$pdf->Cell(90,6,"                     ","0",0,"L");$pdf->Cell(180,6,"$rtov->psc $rtov->mes","0",1,"L");
$pdf->Cell(180,2,"     ","0",1,"L");
$pdf->Cell(90,6,"                      ","0",0,"L");$pdf->Cell(180,6,"I�O: $rtov->ico","0",1,"L");
$pdf->Cell(180,5,"     ","0",1,"L");

if( $pohladavky == 1 AND $metalcomimor == 0 AND $alchem == 0 ) {
$pdf->Cell(180,6,"Vec: Inventariz�cia poh�ad�vok k $h_dsp","B",1,"L");
$pdf->Cell(180,2,"     ","0",1,"L");
$pdf->Cell(180,6,"     V zmysle �29,30 odst.1 z�kona �.431/2002 Z.z. V�s �iadame o ods�hlasenie zostatku z�v�zkov k  $h_dsp.","0",1,"L");
$pdf->Cell(180,6,"�iadame V�s, aby ste na origin�le s�pisu potvrdili zhodnos� na��ch z�znamov so stavom Va�ej ��tovnej evidencie","0",1,"L");
$pdf->Cell(180,6,"a potvrdenie n�m obratom zaslali sp�.","0",1,"L");
$pdf->Cell(180,6,"Ak potvrdenie neobdr��me do 14 dn�, pova�ujeme n� stav poh�ad�vok za platn�.","0",1,"L");
                       }

if( $pohladavky == 1 AND $alchem == 1 ) {
$pdf->Cell(180,6,"Vec: Inventariz�cia poh�ad�vok k $h_dsp","B",1,"L");
$pdf->Cell(180,2,"     ","0",1,"L");
$pdf->Cell(180,6,"     V zmysle � 29,30 z�kona �. 431/2002 Z.z. V�s �iadame o ods�hlasenie zostatku z�v�zkov k  $h_dsp.","0",1,"L");
$pdf->Cell(180,6,"Na �iados� aud�tora na�ej spolo�nosti Ing. Vincencie O�vold�kovej, ktor� vykon�va overenie ��tovnej z�vierky","0",1,"L");
$pdf->Cell(180,6,"k 31.12.$kli_vrok, V�s pros�me, aby ste na origin�le s�pisu potvrdili zhodnos� na�ich z�znamov so stavom Va�ej","0",1,"L");
$pdf->Cell(180,6,"��tovnej evidencie a potvrdenie n�m obratom zaslali sp�.","0",1,"L");
$pdf->Cell(180,6,"Ak potvrdenie neobdr��me do 14 dn�, pova�ujeme n� stav poh�ad�vok za platn�.","0",1,"L");
                       }

if( $pohladavky == 1 AND $metalcomimor == 1 ) {
$pdf->Cell(180,6,"Vec: Mimoriadna inventariz�cia poh�ad�vok k $h_dsp","B",1,"L");
$pdf->Cell(180,2,"     ","0",1,"L");
$pdf->Cell(180,6,"V�en� obchodn� partneri,","0",1,"L");
$pdf->Cell(180,6,"     z d�vodu vykon�vania mimoriadnej inventariz�cie majetku V�s �iadame","0",1,"L");
$pdf->Cell(180,6,"o ods�hlasenie zostatkov na�ich poh�ad�vok vo�i Va�ej firme k 31.8.2011.","0",1,"L");
$pdf->Cell(180,6,"     Potvrden� saldokonto a zostatok pros�me zasla� obratom sp�.","0",1,"L");
$pdf->Cell(180,6,"     V pr�pade, ak do 14 dn� neobdr��me Va�e potvrdenie, budeme pova�ova�","0",1,"L");
$pdf->Cell(180,6,"zostatok za Vami ods�hlasen� a potvrden�.","0",1,"L");
$pdf->Cell(180,6,"     Za pochopenie �akujeme a te��me sa na �al�iu spolupr�cu.","0",1,"L");
                       }

if( $pohladavky != 1 AND $alchem == 0 AND $medo == 0 AND $amagro == 0 ) {
$pdf->Cell(180,6,"Vec: Inventariz�cia z�v�zkov k $h_dsp","B",1,"L");
$pdf->Cell(180,2,"     ","0",1,"L");
$pdf->Cell(180,6,"     V zmysle � 29,30 z�kona �. 431/2002 Z.z. V�m oznamujeme, �e pod�a �dajov na�ej ��tovnej evidencie evidujeme","0",1,"L");
$pdf->Cell(180,6,"Va�e fakt�ry ako je uveden� v pr�lohe tohoto pr�pisu.","0",1,"L");
                       }


if( $pohladavky != 1 AND $alchem == 1 ) {
$pdf->Cell(180,6,"Vec: Inventariz�cia z�v�zkov k $h_dsp","B",1,"L");
$pdf->Cell(180,2,"     ","0",1,"L");
$pdf->Cell(180,6,"     V zmysle � 29,30 z�kona �. 431/2002 Z.z. V�m oznamujeme, �e pod�a �dajov na�ej ��tovnej evidencie evidujeme","0",1,"L");
$pdf->Cell(180,6,"Va�e fakt�ry pod�a prilo�en�ho zoznamu.","0",1,"L");
$pdf->Cell(180,6,"Na �iados� aud�tora na�ej spolo�nosti Ing. Vincencie O�vold�kovej, ktor� vykon�va overenie ��tovnej z�vierky","0",1,"L");
$pdf->Cell(180,6,"k 31.12.$kli_vrok, pros�me o ods�hlasenie na�ich z�v�zkov a zaslanie potvrdenia obratom sp� n�m.","0",1,"L");
                       }

if( $pohladavky != 1 AND $amagro == 1 ) {
$pdf->Cell(180,6,"Vec: Inventariz�cia z�v�zkov k $h_dsp","B",1,"L");
$pdf->Cell(180,2,"     ","0",1,"L");
$pdf->Cell(180,6,"     V zmysle � 29,30 z�kona �. 431/2002 Z.z. V�m oznamujeme, �e pod�a �dajov na�ej ��tovnej evidencie evidujeme","0",1,"L");
$pdf->Cell(180,6,"Va�e fakt�ry pod�a prilo�en�ho zoznamu.","0",1,"L");
$pdf->Cell(180,6,"     �iadame V�s o ods�hlasenie na�ich z�v�zkov a zaslanie potvrdenia obratom sp� n�m.","0",1,"L");
                       }

if( $pohladavky != 1 AND $medo == 1 ) {
$pdf->Cell(180,6,"Vec: Inventariz�cia z�v�zkov k $h_dsp","B",1,"L");
$pdf->Cell(180,2,"     ","0",1,"L");
$pdf->Cell(180,6,"    V zmysle vykonania inventariz�cie poh�ad�vok a z�v�zkov pod�a �29 a 30 z�kona �.431/2002 Zb. o ��tovn�ctve","0",1,"L");
$pdf->Cell(180,6,"si V�s dovo�ujeme po�iada� o ods�hlasenie zostatkov ku d�u $h_dsp.","0",1,"L");
$pdf->Cell(180,6,"�iadame V�s, aby ste na origin�le s�pisu potvrdili zhodnos� na�ich z�znamov so stavom Va�ej ��tovnej evidencie ","0",1,"L");
$pdf->Cell(180,6,"a potvrdenie n�m obratom zaslali sp�.","0",1,"L");
$pdf->Cell(180,6,"Ak potvrdenie neobdr��me do 14 dn�, pova�ujeme n� stav z�v�zkov za platn�.","0",1,"L");
                       }



$pdf->Cell(180,2,"     ","0",1,"L");
$pdf->Cell(30,6,"Fakt�ra","B",0,"R");$pdf->Cell(25,6,"Vystaven�","B",0,"L");$pdf->Cell(25,6,"Splatn�","B",0,"L");
$pdf->Cell(30,6,"Hodnota fakt�ry","B",0,"R");$pdf->Cell(30,6,"Uhraden�","B",0,"R");
$pdf->Cell(40,6,"Zostatok Eur","B",1,"R");

}
//koniec if j=0


if( $rtov->pox == 1 )
     {
$pdf->Cell(30,6,"$rtov->fak","0",0,"R");$pdf->Cell(25,6,"$dat_sk","0",0,"L");$pdf->Cell(25,6,"$das_sk","0",0,"L");
$pdf->Cell(30,6,"$rtov->hod","0",0,"R");$pdf->Cell(30,6,"$uhr","0",0,"R");
$pdf->Cell(40,6,"$rtov->zos","0",1,"R");
     }


if( $rtov->pox == 998 )
     {
$pdf->Cell(100,6,"","0",0,"R");$pdf->Cell(40,6,"Spolu:","T",0,"R");
$pdf->Cell(40,6,"$rtov->zos","T",1,"R");

$pdf->Cell(180,20,"     ","0",1,"L");

if( $medo == 1 ) { $fir_uctt05=$kli_uzprie." ".$kli_uzmeno; $fir_uctt04=$fir_ftel; }

$pdf->Cell(60,6,"Vybavuje: $fir_uctt05 $fir_uctt04","0",0,"L");$pdf->Cell(60,6," ","0",0,"L");
$pdf->Cell(60,6,"pe�iatka, podpis","T",1,"L");
$pdf->Cell(60,4,"$fir_fem1","0",1,"L");
$pdf->Cell(180,2,"     ","0",1,"L");

if( $pohladavky == 1 ) {
$pdf->Cell(180,6,"     ","0",1,"L");

$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",1,"L");

$pdf->Cell(180,20,"     ","0",1,"L");
$pdf->Cell(180,6,"Potvrdzujem so s�hlasom z��tovanie na��ch z�v�zkov vo�i $fir_fnaz $fir_fmes k $h_dsp.","0",1,"L");
$pdf->Cell(180,20,"     ","0",1,"L");
$pdf->Cell(60,6,"miesto a d�tum podpisu","T",0,"L");$pdf->Cell(60,6," ","0",0,"L");
$pdf->Cell(60,6,"pe�iatka, podpis","T",1,"L");
                        }

if( $pohladavky != 1 AND $alchem == 1 ) {
$pdf->Cell(180,6,"     ","0",1,"L");

$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",1,"L");

$pdf->Cell(180,20,"     ","0",1,"L");
$pdf->Cell(30,6,"Odpove�:","B",1,"L");
$pdf->Cell(30,2," ","0",1,"L");
$pdf->Cell(75,4,"V��ka na��ch poh�ad�vok s�hlas� ","0",0,"L");$pdf->Cell(80,4," ","B",1,"L");
$pdf->Cell(30,6," ","0",1,"L");
$pdf->Cell(75,4,"V��ka na��ch poh�ad�vok nes�hlas� ( d�vod ) ","0",0,"L");$pdf->Cell(80,4," ","B",1,"L");


$pdf->Cell(180,20,"     ","0",1,"L");
$pdf->Cell(60,6," ","0",0,"L");$pdf->Cell(60,6," ","0",0,"L");
$pdf->Cell(60,6,"pe�iatka, �itate�n� podpis","T",1,"L");


                        }

if( $pohladavky != 1 AND $amagro == 1 ) {
$pdf->Cell(180,6,"     ","0",1,"L");

$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",1,"L");

$pdf->Cell(180,20,"     ","0",1,"L");
$pdf->Cell(30,6,"Odpove�:","B",1,"L");
$pdf->Cell(30,2," ","0",1,"L");
$pdf->Cell(75,4,"V��ka na��ch poh�ad�vok s�hlas� ","0",0,"L");$pdf->Cell(80,4," ","B",1,"L");
$pdf->Cell(30,6," ","0",1,"L");
$pdf->Cell(75,4,"V��ka na��ch poh�ad�vok nes�hlas� ( d�vod ) ","0",0,"L");$pdf->Cell(80,4," ","B",1,"L");


$pdf->Cell(180,20,"     ","0",1,"L");
$pdf->Cell(60,6," ","0",0,"L");$pdf->Cell(60,6," ","0",0,"L");
$pdf->Cell(60,6,"pe�iatka, �itate�n� podpis","T",1,"L");


                        }

if( $pohladavky != 1 AND $medo == 1 ) {
$pdf->Cell(180,6,"     ","0",1,"L");

$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");
$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",0,"L");$pdf->Cell(10,1,"- - - - - ","0",1,"L");

$pdf->Cell(180,20,"     ","0",1,"L");
$pdf->Cell(180,6,"Potvrdzujem so s�hlasom z��tovanie na��ch poh�ad�vok vo�i $fir_fnaz, $fir_fmes k $h_dsp.","0",1,"L");

$pdf->Cell(180,20,"     ","0",1,"L");
$pdf->Cell(60,6,"miesto a d�tum podpisu","T",0,"L");$pdf->Cell(60,6," ","0",0,"L");
$pdf->Cell(60,6,"pe�iatka, podpis","T",1,"L");


                        }

$j=-1;
     }

if( $rtov->pox1 == 999 AND $h_ico == 0 )
     {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15);

$sety=10;
$pdf->SetY($sety);

$pdf->Cell(100,6,"Celkom ��et $h_uce $rtov->zos","0",1,"L");
     }


}
$i = $i + 1;
$j = $j + 1;


  }
//koniec while
           }
//koniec ak su polozky





$pdf->Output("../tmp/inventura$cislo_dok.$kli_uzid.pdf")


?> 

<script type="text/javascript">
  var okno = window.open("../tmp/inventura<?php echo $cislo_dok; ?>.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php 
//////////////////////////////////////////////////////ak nie je email
          }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Inventariz�cia saldokonta PDF</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    
</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Inventariz�cia saldokonta </td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php 

$sqltt = "DROP TABLE F".$kli_vxcf."_prcvzp".$kli_uzid;
//$sql = mysql_query("$sqltt");

?>


<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
