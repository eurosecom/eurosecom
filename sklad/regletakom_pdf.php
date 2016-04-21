<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 2000;
$clsm = 920;
$cslm=403211;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

$cislo_skl = 1*$_REQUEST['cislo_skl'];

//copern=10 okamzity stav, 20-mesacny stav, 30=pociatocny stav

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$reko = include("skl_rekonstrukcia.php");

$zadod = 1*$_REQUEST['zadod'];

////////////////////////////////////////////////////////datum pociatku a konca pohybov


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

$h_obdp = $_REQUEST['h_obdp'];
$h_obdk = $_REQUEST['h_obdk'];


$h_obdpume=$h_obdp.".".$kli_vrok;
$pole = explode(".", $h_obdpume);
$mesp_dph=$pole[0];
$rokp_dph=$pole[1];

$datp_dph=$rokp_dph.'-'.$mesp_dph.'-01';



$h_obdkume=$h_obdk.".".$kli_vrok;
$pole = explode(".", $h_obdkume);
$mesk_dph=$pole[0];
$rokk_dph=$pole[1];

$datk_dph=$rokk_dph.'-'.$mesk_dph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datk_dph', 0 )";
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

////////////////////////////////////////////////////////koniec datum pociatku a konca pohybov

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Stav komisionálnych zásob PDF</title>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
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
<td>EuroSecom  -  Stav komisionálnych zásob PDF 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/podklad$kli_uzid.pdf")) { $soubor = unlink("../tmp/podklad$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

if ( $copern == 20 OR $copern == 10 OR $copern == 30 )
    {

//urob pracovnu sklprc zjednotenie pri,vyd,pre,poc

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcdx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<sklprc
(
   druh        DECIMAL(15,0),
   pox1        INT,
   pox         INT,
   ume         FLOAT(8,4),
   dat         DATE,
   skl         INT,
   ico         DECIMAL(15,0),
   cis         DECIMAL(15,0),
   mno         DECIMAL(10,3),
   cen         DECIMAL(10,4),
   zas         DECIMAL(10,3),
   hod         DECIMAL(10,2),
   vdj         DECIMAL(10,3),
   prj         DECIMAL(10,3),
   pcs         DECIMAL(10,3)
);
sklprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprcdx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

//poc.stav
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,0,ume,dat,skl,0,cis,mno,cen,(mno),'0','0','0',mno FROM F$kli_vxcf"."_sklpoc WHERE NOT ( cis = 0 )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");


if( $copern === 20 )
{
//prijem 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,0,ume,dat,skl,ico,cis,mno,cen,(mno),'0','0',mno,0 FROM F$kli_vxcf"."_sklpri WHERE ( cis > 0 AND dat <= '$datk_dph' )".
" ORDER BY skl,cis,cen".
"";
//echo $dsqlt; exit;
$dsql = mysql_query("$dsqlt");
//vydaj 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,0,ume,dat,skl,ico,cis,mno,cen,-(mno),'0',mno,'0',0 FROM F$kli_vxcf"."_sklvyd WHERE ( cis > 0 AND dat <= '$datk_dph' )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//faktury 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,0,ume,dat,skl,0,cis,mno,cen,-(mno),'0',mno,'0',0 FROM F$kli_vxcf"."_sklfak WHERE ( cis > 0 AND dat <= '$datk_dph' )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//presun- 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,0,ume,dat,skl,0,cis,mno,cen,-(mno),'0',mno,'0',0 FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND dat <= '$datk_dph' )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//presun+ 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,0,ume,dat,sk2,0,cis,mno,cen,(mno),'0','0',mno,0 FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND dat <= '$datk_dph' )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

}
//koniec copern=20

//daj prec nie komisiu
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc$kli_uzid SET skl=1, druh='' "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc$kli_uzid,F$kli_vxcf"."_sklcisudaje SET druh=1*xnat3 ".
" WHERE F$kli_vxcf"."_sklprc$kli_uzid.cis=F$kli_vxcf"."_sklcisudaje.xcis ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklprc$kli_uzid WHERE druh != 1 "; $dsql = mysql_query("$dsqlt");

//ak nie za dodavatela vynuluj ico
if( $zadod == 0 )
  {
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc$kli_uzid  SET ico=0 "; 
$dsql = mysql_query("$dsqlt");
  }

//stare pohyby do pociatku
$sqlt = "UPDATE F".$kli_vxcf."_sklprc".$kli_uzid." SET pcs=pcs+prj-vdj WHERE dat < '$datp_dph' ";
$vysledok = mysql_query("$sqlt");
$sqlt = "UPDATE F".$kli_vxcf."_sklprc".$kli_uzid." SET prj=0, vdj=0 WHERE dat < '$datp_dph' ";
$vysledok = mysql_query("$sqlt");


//group za skl,cis,cen
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 0,0,0,ume,dat,skl,0,cis,mno,cen,SUM(zas),SUM(hod),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprc$kli_uzid ".
" GROUP BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

if( $zadod == 1 )
  {
//group za skl,cis,cen,ico
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcdx$kli_uzid".
" SELECT 0,0,0,ume,dat,skl,ico,cis,mno,cen,0,0,SUM(vdj),SUM(prj),0 FROM F$kli_vxcf"."_sklprc$kli_uzid WHERE ico >= 0".
" GROUP BY skl,cis,ico".
"";
$dsql = mysql_query("$dsqlt");
  }

    }
//koniec pracovneho suboru zjednotenie

//vypocitaj hodnotu
$sqlt = "UPDATE F".$kli_vxcf."_sklprcd".$kli_uzid." SET hod=zas*cen";
//echo $sqlt;
$vysledok = mysql_query("$sqlt");

//priemerne ceny pox1=1 a potom vynuluj
if( $fir_xsk04 == 1 ) 
{ 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 0,1,0,ume,dat,skl,0,cis,mno,cen,SUM(zas),SUM(hod),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprcd$kli_uzid ".
" GROUP BY skl,cis".
"";
$dsql = mysql_query("$dsqlt");

$sqlt = "DELETE FROM F".$kli_vxcf."_sklprcd".$kli_uzid." WHERE pox1 = 0";
$vysledok = mysql_query("$sqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid  SET pox1=0 "; 
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid  SET cen=hod/zas WHERE zas != 0 "; 
$dsql = mysql_query("$dsqlt");
}
//koniec priemerne ceny

//sumy



//sumar vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 999,999,999,ume,dat,skl,ico,999999999999999,mno,cen,SUM(zas),SUM(hod),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprcd$kli_uzid ".
" WHERE pox = 0 GROUP BY skl,druh ".
"";
$dsql = mysql_query("$dsqlt");


if( $zadod == 1 )
  {
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 1,0,0,ume,dat,skl,ico,cis,mno,cen,0,0,vdj,prj,0 FROM F$kli_vxcf"."_sklprcdx$kli_uzid ".
" GROUP BY skl,cis,cen,ico".
"";
$dsql = mysql_query("$dsqlt");
  }



$neparne=1;

if ( $copern == 20 OR $copern == 10 OR $copern == 30 )
  {
$sqltt = "SELECT * FROM F$kli_vxcf"."_sklprcd$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.skl=F$kli_vxcf"."_skl.skl".
" WHERE ( pcs != 0 OR prj != 0 OR vdj != 0 OR zas != 0 )".
" ORDER BY F$kli_vxcf"."_sklprcd$kli_uzid.skl,pox,F$kli_vxcf"."_sklprcd$kli_uzid.cis,druh,ico ";
  }




//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//exit;

$strana=0;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);


//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$pdf->SetFont('arial','',10);
if ( $copern == 20 )  { $pdf->Cell(90,6,"Stav komisionálnych zásob od $h_obdp.$kli_vrok do $h_obdk.$kli_vrok    ","LTB",0,"L"); }
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);


$pdf->Cell(10,5,"SKL","1",0,"R");$pdf->Cell(20,5,"MAT","1",0,"R");$pdf->Cell(50,5,"Názov","1",0,"L");
$pdf->Cell(15,5,"Cena za MJ","1",0,"R");$pdf->Cell(10,5,"MJ","1",0,"L");
$pdf->Cell(15,5,"Poèiatok MJ","1",0,"R");$pdf->Cell(15,5,"Príjem MJ","1",0,"R");$pdf->Cell(15,5,"Výdaj MJ","1",0,"R");
$pdf->Cell(15,5,"Zostatok MJ","1",0,"R");$pdf->Cell(0,5,"Hodnota","1",1,"R");

     }
//koniec hlavicky j=0


$nassklad = $riadok->nas;
$pocstavCelkom = $pocstavCelkom + $riadok->pcs;
$Cislo=$pocstavCelkom+"";
$sPocstavCelkom=sprintf("%0.2f", $Cislo);

$prijemCelkom = $prijemCelkom + $riadok->prj;
$Cislo=$prijemCelkom+"";
$sPrijemCelkom=sprintf("%0.2f", $Cislo);


//koniec celkom zaciatok riadku






if( $riadok->pox == 0 AND $riadok->pox1 == 0 AND $riadok->druh == 0 )
{

$pdf->SetFont('arial','',6);

$pcs = $riadok->pcs;
$Cislo=$pcs+"";
$spcs=sprintf("%0.3f", $Cislo);
if( $riadok->pcs == 0 ) $spcs="";
$prj = $riadok->prj;
$Cislo=$prj+"";
$sprj=sprintf("%0.3f", $Cislo);
if( $riadok->prj == 0 ) $sprj="";
$vdj = $riadok->vdj;
$Cislo=$vdj+"";
$svdj=sprintf("%0.3f", $Cislo);
if( $riadok->vdj == 0 ) $svdj="";
$zas = $riadok->zas;
$Cislo=$zas+"";
$szas=sprintf("%0.3f", $Cislo);
if( $riadok->zas == 0 ) $szas="";
$hod = $riadok->hod;
$Cislo=$hod+"";
$shod=sprintf("%0.3f", $Cislo);
if( $riadok->hod == 0 ) $shod="";

$okraje=0;
if( $zadod == 1 ) { $okraje="T"; }

$pdf->Cell(10,5,"$riadok->skl","$okraje",0,"R");$pdf->Cell(20,5,"$riadok->cis","$okraje",0,"R");$pdf->Cell(50,5,"$riadok->nat","$okraje",0,"L");
$pdf->Cell(15,5,"$riadok->cen","$okraje",0,"R");$pdf->Cell(10,5,"$riadok->mer","$okraje",0,"L");
$pdf->Cell(15,5,"$spcs","$okraje",0,"R");$pdf->Cell(15,5,"$sprj","$okraje",0,"R");$pdf->Cell(15,5,"$svdj","$okraje",0,"R");
$pdf->Cell(15,5,"$szas","$okraje",0,"R");$pdf->Cell(0,5,"$shod","$okraje",1,"R");

}

if( $riadok->pox == 0 AND $riadok->pox1 == 0 AND $riadok->druh == 1 )
{

$pdf->SetFont('arial','',6);
$prj = $riadok->prj;
$Cislo=$prj+"";
$sprj=sprintf("%0.3f", $Cislo);
if( $riadok->prj == 0 ) $sprj="";
$vdj = $riadok->vdj;
$Cislo=$vdj+"";
$svdj=sprintf("%0.3f", $Cislo);
if( $riadok->vdj == 0 ) $svdj="";

$okraje=0;

$dodavatel="Predaj";
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $riadok->ico ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); if( $riadok->ico > 0 ) { $dodavatel = $fir_riadok->nai." ".$fir_riadok->mes; } }

$pdf->Cell(119,5,"$dodavatel","$okraje",0,"R");$pdf->Cell(15,5,"$sprj","$okraje",0,"R");$pdf->Cell(15,5,"$svdj","$okraje",1,"R");

}

if( $riadok->pox == 999 AND $riadok->pox1 == 999 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(135,5,"CELKOM komisionálne zásoby ","T",0,"L");
$pdf->Cell(0,5,"$riadok->hod","T",1,"R");

}



}
$i = $i + 1;
$j = $j + 1;
if( $j > 48 ) $j=0;

  }


//export csv
$docsv = 1*$_REQUEST['docsv'];
if( $docsv == 1 )
{
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="stavzasobkomisia";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");

$sqltt = "SELECT * FROM F$kli_vxcf"."_sklprcd$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.skl=F$kli_vxcf"."_skl.skl".
" WHERE ( pcs != 0 OR prj != 0 OR vdj != 0 OR zas != 0 ) AND pox = 0 AND pox1 = 0 AND druh = 0 ".
" ORDER BY F$kli_vxcf"."_sklprcd$kli_uzid.skl,pox,F$kli_vxcf"."_sklprcd$kli_uzid.cis,druh,ico ";


//echo $sqltt;
$sql = mysql_query("$sqltt");
if($sql)                                                    
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$datsk=SkDatum($hlavicka->dat);




//$pdf->Cell(10,5,"$hlavicka->skl","$okraje",0,"R");$pdf->Cell(20,5,"$hlavicka->cis","$okraje",0,"R");$pdf->Cell(50,5,"$hlavicka->nat","$okraje",0,"L");
//$pdf->Cell(15,5,"$hlavicka->cen","$okraje",0,"R");$pdf->Cell(10,5,"$hlavicka->mer","$okraje",0,"L");
//$pdf->Cell(15,5,"$spcs","$okraje",0,"R");$pdf->Cell(15,5,"$sprj","$okraje",0,"R");$pdf->Cell(15,5,"$svdj","$okraje",0,"R");
//$pdf->Cell(15,5,"$szas","$okraje",0,"R");$pdf->Cell(0,5,"$shod","$okraje",1,"R");

//$pdf->Cell(10,5,"SKL","1",0,"R");$pdf->Cell(20,5,"MAT","1",0,"R");$pdf->Cell(50,5,"Názov","1",0,"L");
//$pdf->Cell(15,5,"Cena za MJ","1",0,"R");$pdf->Cell(10,5,"MJ","1",0,"L");
//$pdf->Cell(15,5,"Poèiatok MJ","1",0,"R");$pdf->Cell(15,5,"Príjem MJ","1",0,"R");$pdf->Cell(15,5,"Výdaj MJ","1",0,"R");
//$pdf->Cell(15,5,"Zostatok MJ","1",0,"R");$pdf->Cell(0,5,"Hodnota","1",1,"R");

$xcen=$hlavicka->cen; $cen=str_replace(".",",",$xcen); 
$xpoc=$hlavicka->pcs; $poc=str_replace(".",",",$xpoc);
$xprj=$hlavicka->prj; $prj=str_replace(".",",",$xprj);
$xvdj=$hlavicka->vdj; $vdj=str_replace(".",",",$xvdj);
$xzas=$hlavicka->zas; $zas=str_replace(".",",",$xzas);

$xhod=$hlavicka->hod; $hod=str_replace(".",",",$xhod);


if( $i == 0 )
     {
  $text = "sklad".";"."cislo".";"."nazov".";"."cena".";"."mj"; 
  $text = $text.";"."pociatok mj".";"."prijem mj".";"."vydaj mj".";"."zostatok mj".";"."hodnota eur"."\r\n"; 

  fwrite($soubor, $text);

     }



  $text = $hlavicka->skl.";".$hlavicka->cis.";"."$hlavicka->nat".";"."$cen".";"."$hlavicka->mer"; 
  $text = $text.";"."$poc".";"."$prj".";"."$vdj".";"."$zas".";"."$hod"."\r\n";  

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>

<?php
exit;
}
//koniec export csv


$pdf->Output("../tmp/podklad.$kli_uzid.pdf");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcdx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
?> 

<script type="text/javascript">
  var okno = window.open("../tmp/podklad.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
