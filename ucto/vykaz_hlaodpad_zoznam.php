<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 1000;
$clsm = 820;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

$stvrtrok = 1*$_REQUEST['stvrtrok'];


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

if( $stvrtrok == 0 ) $stvrtrok=1;
if( $stvrtrok == 1 ) { $datum="31.03.".$kli_vrok; $mesiac="03"; $kli_vume="3.".$kli_vrok; $kli_pume="1.".$kli_vrok; $kli_kume="3.".$kli_vrok; }
if( $stvrtrok == 2 ) { $datum="30.06.".$kli_vrok; $mesiac="06"; $kli_vume="6.".$kli_vrok; $kli_pume="4.".$kli_vrok; $kli_kume="6.".$kli_vrok; }
if( $stvrtrok == 3 ) { $datum="30.09.".$kli_vrok; $mesiac="09"; $kli_vume="9.".$kli_vrok; $kli_pume="7.".$kli_vrok; $kli_kume="9.".$kli_vrok; }
if( $stvrtrok == 4 ) { $datum="31.12.".$kli_vrok; $mesiac="12"; $kli_vume="12.".$kli_vrok; $kli_pume="10.".$kli_vrok; $kli_kume="12.".$kli_vrok; }


//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

include("vykaz_hlaodpad_nazovkomodity.php");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid.' ';
$vysledok = mysql_query("$sqlt");

$pocdes="10,3";

$sqlt = <<<mzdprc
(
   cpl          int not null auto_increment,
   pxy06        DECIMAL($pocdes) DEFAULT 0,
   oc           INT(7) DEFAULT 0,
   druh         DECIMAL(10,0) DEFAULT 0,
   daz          DECIMAL(10,4) DEFAULT 0,
   kor          INT DEFAULT 0,
   prx          INT DEFAULT 0,
   hod          DECIMAL($pocdes) DEFAULT 0,
   vyroba       DECIMAL($pocdes) DEFAULT 0,
   dovoz        DECIMAL($pocdes) DEFAULT 0,
   vyvoz        DECIMAL($pocdes) DEFAULT 0,
   reexport     DECIMAL($pocdes) DEFAULT 0,
   ico          DECIMAL(10,0) DEFAULT 0,
   komodita     DECIMAL(10,0) DEFAULT 0,
   dox          DECIMAL(10,0) DEFAULT 0,
   s01          DECIMAL(10,3) DEFAULT 0,
   s02          DECIMAL(10,3) DEFAULT 0,
   s03          DECIMAL(10,3) DEFAULT 0,
   s04          DECIMAL(10,3) DEFAULT 0,
   s05          DECIMAL(10,3) DEFAULT 0,
   s06          DECIMAL(10,3) DEFAULT 0,
   s07          DECIMAL(10,3) DEFAULT 0,
   s08          DECIMAL(10,3) DEFAULT 0,
   s09          DECIMAL(10,3) DEFAULT 0,
   s10          DECIMAL(10,3) DEFAULT 0,
   s11          DECIMAL(10,3) DEFAULT 0,
   s12          DECIMAL(10,3) DEFAULT 0,
   s13          DECIMAL(10,3) DEFAULT 0,
   s14          DECIMAL(10,3) DEFAULT 0,
   s15          DECIMAL(10,3) DEFAULT 0,
   s16          DECIMAL(10,3) DEFAULT 0,
   s17          DECIMAL(10,3) DEFAULT 0,
   s18          DECIMAL(10,3) DEFAULT 0,
   s19          DECIMAL(10,3) DEFAULT 0,
   s20          DECIMAL(10,3) DEFAULT 0,
   s21          DECIMAL(10,3) DEFAULT 0,
   s22          DECIMAL(10,3) DEFAULT 0,
   s23          DECIMAL(10,3) DEFAULT 0,
   s24          DECIMAL(10,3) DEFAULT 0,
   s25          DECIMAL(10,3) DEFAULT 0,
   PRIMARY KEY(cpl)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


$vsql = "INSERT INTO F".$kli_vxcf."_uctprcvykaz".$kli_uzid." ".
" SELECT 0,0,0,druh,daz,kor,0,hod,vyroba,dovoz,vyvoz,reexport,ico,komodita,dox, ".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".
" FROM F$kli_vxcf"."_uctvykaz_hlaodpadd2 WHERE daz >= $kli_pume AND daz <= $kli_kume ";
$vytvor = mysql_query("$vsql");

$nadpis="";
if( $drupoh != 5 )
  {
$h_o = 1*$_REQUEST['h_o'];
$h_n = 1*$_REQUEST['h_n'];
if( $h_o == 0 AND $h_n == 0 ) { $h_o=1; $h_n=1; }
$nadpis="O,N";

if( $h_o == 1 AND $h_n == 0 )
{
$sqtoz = "DELETE FROM F$kli_vxcf"."_uctprcvykaz$kli_uzid WHERE komodita > 100"; $oznac = mysql_query("$sqtoz");
$nadpis="O";
}

if( $h_o == 0 AND $h_n == 1 )
{
$sqtoz = "DELETE FROM F$kli_vxcf"."_uctprcvykaz$kli_uzid WHERE komodita < 100"; $oznac = mysql_query("$sqtoz");
$nadpis="N";
}

$dsqlt = "UPDATE F".$kli_vxcf."_uctprcvykaz".$kli_uzid." SET komodita=komodita-100 WHERE komodita > 100 ";
$dsql = mysql_query("$dsqlt");

  }

if( $drupoh == 1 ) { $sqtoz = "DELETE FROM F$kli_vxcf"."_uctprcvykaz$kli_uzid WHERE druh != 0"; $oznac = mysql_query("$sqtoz"); }
if( $drupoh == 2 ) { $sqtoz = "DELETE FROM F$kli_vxcf"."_uctprcvykaz$kli_uzid WHERE druh != 1"; $oznac = mysql_query("$sqtoz"); }
if( $drupoh == 3 ) { $sqtoz = "DELETE FROM F$kli_vxcf"."_uctprcvykaz$kli_uzid WHERE druh != 2"; $oznac = mysql_query("$sqtoz"); }
if( $drupoh == 4 ) { $sqtoz = "DELETE FROM F$kli_vxcf"."_uctprcvykaz$kli_uzid WHERE druh != 3"; $oznac = mysql_query("$sqtoz"); }

if( $drupoh != 5 )
{
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s01=hod WHERE komodita=01 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s02=hod WHERE komodita=02 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s03=hod WHERE komodita=03 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s04=hod WHERE komodita=04 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s05=hod WHERE komodita=05 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s06=hod WHERE komodita=06 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s07=hod WHERE komodita=07 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s08=hod WHERE komodita=08 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s09=hod WHERE komodita=09 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s10=hod WHERE komodita=10 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s11=hod WHERE komodita=11 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s12=hod WHERE komodita=12 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s13=hod WHERE komodita=13 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s14=hod WHERE komodita=14 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s15=hod WHERE komodita=15 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s16=hod WHERE komodita=16 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s17=hod WHERE komodita=17 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s18=hod WHERE komodita=18 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s19=hod WHERE komodita=19 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s20=hod WHERE komodita=20 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s21=hod WHERE komodita=21 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s22=hod WHERE komodita=22 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s23=hod WHERE komodita=23 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s24=hod WHERE komodita=24 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET s25=hod WHERE komodita=25 "; $vysledek = mysql_query("$sql");
}

$dsqlt = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET vyroba=hod WHERE druh=0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET dovoz=hod WHERE druh=1 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET vyvoz=hod WHERE druh=2 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET reexport=hod WHERE druh=3 ";
$dsql = mysql_query("$dsqlt");

if( $drupoh == 5 )
{
$vsql = "INSERT INTO F".$kli_vxcf."_uctprcvykaz".$kli_uzid." ".
" SELECT 0,0,0,druh,daz,kor,9,hod,sum(vyroba),sum(dovoz),sum(vyvoz),sum(reexport),ico,komodita,dox, ".
" sum(s01),sum(s02),sum(s03),sum(s04),sum(s05),sum(s06),sum(s07),sum(s08),sum(s09),sum(s10), ".
" sum(s11),sum(s12),sum(s13),sum(s14),sum(s15),sum(s16),sum(s17),sum(s18),sum(s19),sum(s20), ".
" sum(s21),sum(s22),sum(s23),sum(s24),sum(s25)  ".
" FROM F".$kli_vxcf."_uctprcvykaz$kli_uzid WHERE prx = 0 GROUP BY komodita";
$vytvor = mysql_query("$vsql");

if( $drupoh == 5 ) { $sqtoz = "DELETE FROM F$kli_vxcf"."_uctprcvykaz$kli_uzid WHERE prx = 0 "; $oznac = mysql_query("$sqtoz"); }

$dsqlt = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET prx=5 ";
$dsql = mysql_query("$dsqlt");

}

if( $drupoh != 5 )
{
//suma za vsetko
$vsql = "INSERT INTO F".$kli_vxcf."_uctprcvykaz".$kli_uzid." ".
" SELECT 0,0,0,druh,daz,kor,10,hod,sum(vyroba),sum(dovoz),sum(vyvoz),sum(reexport),ico,komodita,dox, ".
" sum(s01),sum(s02),sum(s03),sum(s04),sum(s05),sum(s06),sum(s07),sum(s08),sum(s09),sum(s10), ".
" sum(s11),sum(s12),sum(s13),sum(s14),sum(s15),sum(s16),sum(s17),sum(s18),sum(s19),sum(s20), ".
" sum(s21),sum(s22),sum(s23),sum(s24),sum(s25)  ".
" FROM F".$kli_vxcf."_uctprcvykaz$kli_uzid WHERE prx = 0 GROUP BY prx";
$vytvor = mysql_query("$vsql");
}

if( $drupoh == 5 )
{
//suma za vsetko
$vsql = "INSERT INTO F".$kli_vxcf."_uctprcvykaz".$kli_uzid." ".
" SELECT 0,0,0,druh,daz,kor,10,hod,sum(vyroba),sum(dovoz),sum(vyvoz),sum(reexport),ico,komodita,dox, ".
" sum(s01),sum(s02),sum(s03),sum(s04),sum(s05),sum(s06),sum(s07),sum(s08),sum(s09),sum(s10), ".
" sum(s11),sum(s12),sum(s13),sum(s14),sum(s15),sum(s16),sum(s17),sum(s18),sum(s19),sum(s20), ".
" sum(s21),sum(s22),sum(s23),sum(s24),sum(s25)  ".
" FROM F".$kli_vxcf."_uctprcvykaz$kli_uzid WHERE prx = 5 GROUP BY prx";
$vytvor = mysql_query("$vsql");
}

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Hlasenie PDF</title>
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
<td>EuroSecom  -  Hlásenie PDF 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
$hhmmss = Date ("His", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/hlodp_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/hlodp_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }


   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$neparne=1;

if ( $copern == 10 AND $drupoh < 5 )
  {
 

$sqltt = "SELECT * FROM F$kli_vxcf"."_uctprcvykaz$kli_uzid ".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_uctprcvykaz$kli_uzid.ico=F$kli_vxcf"."_ico.ico".
" WHERE oc >= 0 ".
" ORDER BY prx,F$kli_vxcf"."_uctprcvykaz$kli_uzid.ico,daz,dox ";

  }

if ( $copern == 10 AND $drupoh == 5 )
  {
 

$sqltt = "SELECT * FROM F$kli_vxcf"."_uctprcvykaz$kli_uzid ".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_uctprcvykaz$kli_uzid.ico=F$kli_vxcf"."_ico.ico".
" WHERE oc >= 0 ".
" ORDER BY prx,komodita  ";

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


$nassklad = $riadok->nas;
$pocstavCelkom = $pocstavCelkom + $riadok->pcs;
$Cislo=$pocstavCelkom+"";
$sPocstavCelkom=sprintf("%0.2f", $Cislo);

$prijemCelkom = $prijemCelkom + $riadok->prj;
$Cislo=$prijemCelkom+"";
$sPrijemCelkom=sprintf("%0.2f", $Cislo);

$pocstav = $riadok->pcs;
$Cislo=$pocstav+"";
$sPocstav=sprintf("%0.2f", $Cislo);

$daod_sk=SkDatum($riadok->daod);
$dado_sk=SkDatum($riadok->dado);

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 

//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);


if ( $copern == 10 AND $drupoh == 1 )  { $pdf->Cell(90,6,"HLÁSENIE ( v tonách ) o objeme VÝROBY za $stvrtrok.štvrrok $kli_vrok $nadpis","LTB",0,"L"); }
if ( $copern == 10 AND $drupoh == 2 )  { $pdf->Cell(90,6,"HLÁSENIE ( v tonách ) o objeme DOVOZU za $stvrtrok.štvrrok $kli_vrok $nadpis","LTB",0,"L"); }
if ( $copern == 10 AND $drupoh == 3 )  { $pdf->Cell(90,6,"HLÁSENIE ( v tonách ) o objeme VÝVOZU za $stvrtrok.štvrrok $kli_vrok $nadpis","LTB",0,"L"); }
if ( $copern == 10 AND $drupoh == 4 )  { $pdf->Cell(90,6,"HLÁSENIE ( v tonách ) o objeme REEXPORTU za $stvrtrok.štvrrok $kli_vrok $nadpis","LTB",0,"L"); }
if ( $copern == 10 AND $drupoh == 5 )  { $pdf->Cell(90,6,"HLÁSENIE ( v tonách ) o pohyboch výrobkov za $stvrtrok.štvrrok $kli_vrok ","LTB",0,"L"); }

$pdf->Cell(0,6,"$kli_nxcf","RTB",1,"R");

$pdf->SetFont('arial','',6);

if( $copern == 10 AND $drupoh != 5 )
{


$pdf->Cell(12,5,"MM.RRRR","LBR",0,"R");$pdf->Cell(20,5,"Doklad","LBR",0,"R");$pdf->Cell(0,5,"IÈO, obchodné meno","LBR",1,"L");

$pdf->Cell(11,3,"obaly","LTR",0,"C");$pdf->Cell(11,3,"obaly","LTR",0,"C");$pdf->Cell(11,3,"obaly","LTR",0,"C");
$pdf->Cell(11,3,"obaly","LTR",0,"C");$pdf->Cell(11,3,"obaly","LTR",0,"C");$pdf->Cell(11,3,"viacvrst.","LTR",0,"C");
$pdf->Cell(11,3,"elektrozar.","LTR",0,"C");$pdf->Cell(11,3,"elektrozar.","LTR",0,"C");$pdf->Cell(11,3,"elektrozar.","LTR",0,"C");
$pdf->Cell(11,3,"elektrozar.","LTR",0,"C");$pdf->Cell(11,3,"elektrozar.","LTR",0,"C");$pdf->Cell(11,3,"elektrozar.","LTR",0,"C");
$pdf->Cell(11,3,"elektrozar.","LTR",0,"C");$pdf->Cell(11,3,"elektrozar.","LTR",0,"C");$pdf->Cell(11,3,"elektrozar.","LTR",0,"C");
$pdf->Cell(11,3,"batérie","LTR",0,"C");$pdf->Cell(11,3,"batérie","LTR",0,"C");$pdf->Cell(11,3,"batérie","LTR",0,"C");
$pdf->Cell(10,3,"pneu","LTR",0,"C");$pdf->Cell(11,3," ","LTR",0,"C");
$pdf->Cell(11,3,"sklo","LTR",0,"C");$pdf->Cell(11,3,"viacvrst.","LTR",0,"C");$pdf->Cell(11,3,"papier","LTR",0,"C");
$pdf->Cell(11,3,"plasty","LTR",0,"C");$pdf->Cell(0,3,"elektrozar.","LTR",1,"C");



$pdf->Cell(11,3,"z papiera","LBR",0,"C");$pdf->Cell(11,3,"z plastov","LBR",0,"C");$pdf->Cell(11,3,"z kovu Al","LBR",0,"C");
$pdf->Cell(11,3,"z kovu Fe","LBR",0,"C");$pdf->Cell(11,3,"zo skla","LBR",0,"C");$pdf->Cell(11,3,"obaly","LBR",0,"C");
$pdf->Cell(11,3,"trieda 1","LBR",0,"C");$pdf->Cell(11,3,"trieda 2","LBR",0,"C");$pdf->Cell(11,3,"trieda 3","LBR",0,"C");
$pdf->Cell(11,3,"trieda 4","LBR",0,"C");$pdf->Cell(11,3,"trieda 5","LBR",0,"C");$pdf->Cell(11,3,"trieda 6","LBR",0,"C");
$pdf->Cell(11,3,"trieda 7","LBR",0,"C");$pdf->Cell(11,3,"trieda 8","LBR",0,"C");$pdf->Cell(11,3,"trieda 9","LBR",0,"C");
$pdf->Cell(11,3,"prenosné","LBR",0,"C");$pdf->Cell(11,3,"priemysel","LBR",0,"C");$pdf->Cell(11,3,"auto","LBR",0,"C");
$pdf->Cell(10,3,"matiky","LBR",0,"C");$pdf->Cell(11,3,"oleje","LBR",0,"C");
$pdf->Cell(11,3,"tovar","LBR",0,"C");$pdf->Cell(11,3,"materiály","LBR",0,"C");$pdf->Cell(11,3,"tovar","LBR",0,"C");
$pdf->Cell(11,3,"tovar","LBR",0,"C");$pdf->Cell(0,3,"trieda x","LBR",1,"C");

}

if( $copern == 10 AND $drupoh == 5 )
{
$pdf->SetFont('arial','',9);

$pdf->Cell(77,6,"Výrobok","1",0,"L");
$pdf->Cell(50,6,"výroba","1",0,"R");$pdf->Cell(50,6,"dovoz","1",0,"R");$pdf->Cell(50,6,"vývoz","1",0,"R");$pdf->Cell(50,6,"reexport","1",1,"R");

}


     }
//koniec hlavicky j=0

$s01=$riadok->s01;
if( $s01 == 0 ) $s01="";
$s02=$riadok->s02;
if( $s02 == 0 ) $s02="";
$s03=$riadok->s03;
if( $s03 == 0 ) $s03="";
$s04=$riadok->s04;
if( $s04 == 0 ) $s04="";
$s05=$riadok->s05;
if( $s05 == 0 ) $s05="";
$s06=$riadok->s06;
if( $s06 == 0 ) $s06="";
$s07=$riadok->s07;
if( $s07 == 0 ) $s07="";
$s08=$riadok->s08;
if( $s08 == 0 ) $s08="";
$s09=$riadok->s09;
if( $s09 == 0 ) $s09="";
$s10=$riadok->s10;
if( $s10 == 0 ) $s10="";
$s11=$riadok->s11;
if( $s11 == 0 ) $s11="";
$s12=$riadok->s12;
if( $s12 == 0 ) $s12="";
$s13=$riadok->s13;
if( $s13 == 0 ) $s13="";
$s14=$riadok->s14;
if( $s14 == 0 ) $s14="";
$s15=$riadok->s15;
if( $s15 == 0 ) $s15="";
$s16=$riadok->s16;
if( $s16 == 0 ) $s16="";
$s17=$riadok->s17;
if( $s17 == 0 ) $s17="";
$s18=$riadok->s18;
if( $s18 == 0 ) $s18="";
$s19=$riadok->s19;
if( $s19 == 0 ) $s19="";
$s20=$riadok->s20;
if( $s20 == 0 ) $s20="";
$s21=$riadok->s21;
if( $s21 == 0 ) $s21="";
$s22=$riadok->s22;
if( $s22 == 0 ) $s22="";
$s23=$riadok->s23;
if( $s23 == 0 ) $s23="";
$s24=$riadok->s24;
if( $s24 == 0 ) $s24="";
$s25=$riadok->s25;
if( $s25 == 0 ) $s25="";

$dox=$riadok->dox;
if( $dox == 0 ) $dox="";

$vyroba=$riadok->vyroba;
if( $vyroba == 0 ) $vyroba="";
$dovoz=$riadok->dovoz;
if( $dovoz == 0 ) $dovoz="";
$vyvoz=$riadok->vyvoz;
if( $vyvoz == 0 ) $vyvoz="";
$reexport=$riadok->reexport;
if( $reexport == 0 ) $reexport="";


if( $riadok->prx == 0 AND $drupoh != 5 )
{

$pdf->SetFont('arial','',7);

$pdf->Cell(12,5,"$riadok->daz","0",0,"R");$pdf->Cell(20,5,"$dox","0",0,"R");$pdf->Cell(0,5,"$riadok->ico $riadok->nai $riadok->mes","0",1,"L");
$pdf->Cell(11,5,"$s01","B",0,"R");$pdf->Cell(11,5,"$s02","B",0,"R");$pdf->Cell(11,5,"$s03","B",0,"R");
$pdf->Cell(11,5,"$s04","B",0,"R");$pdf->Cell(11,5,"$s05","B",0,"R");$pdf->Cell(11,5,"$s06","B",0,"R");
$pdf->Cell(11,5,"$s07","B",0,"R");$pdf->Cell(11,5,"$s08","B",0,"R");$pdf->Cell(11,5,"$s09","B",0,"R");
$pdf->Cell(11,5,"$s10","B",0,"R");
$pdf->Cell(11,5,"$s11","B",0,"R");$pdf->Cell(11,5,"$s12","B",0,"R");$pdf->Cell(11,5,"$s13","B",0,"R");
$pdf->Cell(11,5,"$s14","B",0,"R");$pdf->Cell(11,5,"$s15","B",0,"R");$pdf->Cell(11,5,"$s16","B",0,"R");
$pdf->Cell(11,5,"$s17","B",0,"R");$pdf->Cell(11,5,"$s18","B",0,"R");$pdf->Cell(10,5,"$s19","B",0,"R");
$pdf->Cell(11,5,"$s20","B",0,"R");
$pdf->Cell(11,5,"$s21","B",0,"R");$pdf->Cell(11,5,"$s22","B",0,"R");$pdf->Cell(11,5,"$s23","B",0,"R");
$pdf->Cell(11,5,"$s24","B",0,"R");$pdf->Cell(0,5,"$s25","B",1,"R");


}


if( $riadok->prx == 5 AND $drupoh == 5 )
{
$text_komodita=NazovKomodity($riadok->komodita);


$pdf->SetFont('arial','',9);

$pdf->Cell(77,6,"$riadok->komodita $text_komodita","0",0,"L");
$pdf->Cell(50,6,"$vyroba","0",0,"R");$pdf->Cell(50,6,"$dovoz","0",0,"R");$pdf->Cell(50,6,"$vyvoz","0",0,"R");$pdf->Cell(50,6,"$reexport","0",1,"R");


}


if( $riadok->prx == 10 AND $drupoh != 5 )
{

$pdf->SetFont('arial','',7);

$pdf->Cell(0,2," ","BT",1,"L");
$pdf->Cell(0,5,"SPOLU","0",1,"L");
$pdf->Cell(11,5,"$s01","B",0,"R");$pdf->Cell(11,5,"$s02","B",0,"R");$pdf->Cell(11,5,"$s03","B",0,"R");
$pdf->Cell(11,5,"$s04","B",0,"R");$pdf->Cell(11,5,"$s05","B",0,"R");$pdf->Cell(11,5,"$s06","B",0,"R");
$pdf->Cell(11,5,"$s07","B",0,"R");$pdf->Cell(11,5,"$s08","B",0,"R");$pdf->Cell(11,5,"$s09","B",0,"R");
$pdf->Cell(11,5,"$s10","B",0,"R");
$pdf->Cell(11,5,"$s11","B",0,"R");$pdf->Cell(11,5,"$s12","B",0,"R");$pdf->Cell(11,5,"$s13","B",0,"R");
$pdf->Cell(11,5,"$s14","B",0,"R");$pdf->Cell(11,5,"$s15","B",0,"R");$pdf->Cell(11,5,"$s16","B",0,"R");
$pdf->Cell(11,5,"$s17","B",0,"R");$pdf->Cell(11,5,"$s18","B",0,"R");$pdf->Cell(10,5,"$s19","B",0,"R");
$pdf->Cell(11,5,"$s20","B",0,"R");
$pdf->Cell(11,5,"$s21","B",0,"R");$pdf->Cell(11,5,"$s22","B",0,"R");$pdf->Cell(11,5,"$s23","B",0,"R");
$pdf->Cell(11,5,"$s24","B",0,"R");$pdf->Cell(0,5,"$s25","B",1,"R");


}

if( $riadok->prx == 10 AND $drupoh == 5 )
{

$pdf->SetFont('arial','',9);

$pdf->Cell(0,2," ","BT",1,"L");
$pdf->Cell(77,6,"SPOLU","0",0,"L");
$pdf->Cell(50,6,"$vyroba","0",0,"R");$pdf->Cell(50,6,"$dovoz","0",0,"R");$pdf->Cell(50,6,"$vyvoz","0",0,"R");$pdf->Cell(50,6,"$reexport","0",1,"R");


}


}
$i = $i + 1;
$j = $j + 1;
if( $j >= 16 ) $j=0;

  }

//echo $mail;

$pdf->Output("$outfilex");


if( $copern == 10 ) { 
?> 

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>

<?php
                 }



?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
