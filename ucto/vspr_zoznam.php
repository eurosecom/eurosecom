<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
if( $_SERVER['SERVER_NAME'] == "www.stavoimpexsro.sk" ) { $sys = 'MZD'; }
$urov = 2000;
$clsm = 920;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

$cislo_dok = 1*$_REQUEST['cislo_dok'];

//echo $cislo_dok;

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




?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Prikaz na uhradu zoznam</title>
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
<td>EuroSecom  -  Príkaz na úhradu zoznam 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
$hhmmss = Date ("is", MkTime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")) );

 $outfilexdel="../tmp/priku_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/priku_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

if ( $copern == 20 OR $copern == 10 )
    {

//urob pracovnu sklprc zjednotenie pri,vyd,pre,poc

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<sklprc
(
   pox         INT,
   pox1        INT,
   dok         int,
   cpl         int PRIMARY KEY not null auto_increment,
   uceb        VARCHAR(30),
   numb        VARCHAR(4),
   iban        VARCHAR(30),
   twib        VARCHAR(30),
   vsy         decimal(11,0),
   ksy         varchar(4) NOT NULL,
   ssy         varchar(10) NOT NULL,
   hodp        DECIMAL(10,2) DEFAULT 0,
   hodm        decimal(10,2) DEFAULT 0,
   uce         int,
   ico         INT(10),
   id          INT,
   datm        TIMESTAMP(14)
);
sklprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


//pohyby
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,dok,0,uceb,numb,iban,twib,vsy,ksy,ssy,hodp,hodm,uce,ico,id,datm FROM F$kli_vxcf"."_uctprikp WHERE dok = $cislo_dok".
" ORDER BY dok,ico,vsy".
"";
$dsql = mysql_query("$dsqlt");



//group za ico
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 1,0,dok,0,uceb,numb,iban,twib,99999999999,ksy,ssy,SUM(hodp),hodm,uce,ico,id,datm FROM F$kli_vxcf"."_sklprc$kli_uzid ".
" GROUP BY ico".
"";
$dsql = mysql_query("$dsqlt");

//group za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 9,9,dok,0,uceb,numb,iban,twib,vsy,ksy,ssy,SUM(hodp),hodm,uce,ico,id,datm FROM F$kli_vxcf"."_sklprc$kli_uzid WHERE pox = 0 ".
" GROUP BY pox".
"";
$dsql = mysql_query("$dsqlt");

    }
//koniec pracovneho suboru zjednotenie




$neparne=1;

if ( $copern == 20 OR $copern == 10 )
  {
$sqltt = "SELECT F$kli_vxcf"."_sklprc$kli_uzid.dok,F$kli_vxcf"."_sklprc$kli_uzid.ico,F$kli_vxcf"."_sklprc$kli_uzid.hodp,".
" F$kli_vxcf"."_sklprc$kli_uzid.vsy,F$kli_vxcf"."_sklprc$kli_uzid.ksy,F$kli_vxcf"."_sklprc$kli_uzid.ssy,".
" F$kli_vxcf"."_sklprc$kli_uzid.uceb,F$kli_vxcf"."_sklprc$kli_uzid.numb,".
" F$kli_vxcf"."_sklprc$kli_uzid.pox,F$kli_vxcf"."_uctpriku.dat,F$kli_vxcf"."_uctpriku.uce,".
" F$kli_vxcf"."_ico.nai,F$kli_vxcf"."_ico.mes,F$kli_vxcf"."_fakdod.dok AS dox,F$kli_vxcf"."_fakdodpoc.dok AS doz ".
" FROM F$kli_vxcf"."_sklprc$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_sklprc$kli_uzid.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_uctpriku".
" ON F$kli_vxcf"."_sklprc$kli_uzid.dok=F$kli_vxcf"."_uctpriku.dok".
" LEFT JOIN F$kli_vxcf"."_fakdod".
" ON F$kli_vxcf"."_sklprc$kli_uzid.ico=F$kli_vxcf"."_fakdod.ico AND F$kli_vxcf"."_sklprc$kli_uzid.vsy=F$kli_vxcf"."_fakdod.fak ".
" LEFT JOIN F$kli_vxcf"."_fakdodpoc".
" ON F$kli_vxcf"."_sklprc$kli_uzid.ico=F$kli_vxcf"."_fakdodpoc.ico AND F$kli_vxcf"."_sklprc$kli_uzid.vsy=F$kli_vxcf"."_fakdodpoc.fak ".
" WHERE F$kli_vxcf"."_sklprc$kli_uzid.hodp != 0".
" ORDER BY pox1,nai,F$kli_vxcf"."_sklprc$kli_uzid.ico,pox,vsy";
  }



//echo $sqltt;
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
$dat_sk=SkDatum($riadok->dat);

//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$pdf->SetFont('arial','',10);
$pdf->Cell(90,6,"Príkaz na úhradu èíslo - $cislo_dok z $dat_sk BU$riadok->uce","LTB",0,"L"); 
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);


$pdf->Cell(40,6,"Úèet príjemcu","LRB",0,"R");$pdf->Cell(20,6,"NumKód","LRB",0,"R");
$pdf->Cell(30,6,"Sumy","LRB",0,"R");$pdf->Cell(35,6,"Variabilný","1",0,"R");
$pdf->Cell(20,6,"Konštantný","1",0,"R");$pdf->Cell(20,6,"Doklad","1",0,"L");$pdf->Cell(0,6,"Špecifický","1",1,"R");

     }
//koniec hlavicky j=0





if( $riadok->pox == 0 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(40,6,"$riadok->uceb","0",0,"R");$pdf->Cell(20,6,"$riadok->numb","0",0,"R");$pdf->Cell(30,6,"$riadok->hodp","0",0,"R");
$pdf->Cell(35,6,"$riadok->vsy","0",0,"R");$pdf->Cell(20,6,"$riadok->ksy","0",0,"R");$pdf->Cell(20,6,"$riadok->dox $riadok->doz","0",0,"L");
$pdf->Cell(0,6,"$riadok->ssy","0",1,"R");

}


if( $riadok->pox == 1 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(40,6,"CELKOM IÈO $riadok->ico","T",0,"R");$pdf->Cell(20,6," ","T",0,"R");$pdf->Cell(30,6,"$riadok->hodp","T",0,"R");
$pdf->Cell(0,6,"$riadok->nai $riadok->mes","T",1,"L");
$pdf->Cell(0,6," ","T",1,"L");
$j=$j+1;
}

if( $riadok->pox == 9 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(60,6,"CELKOM všetko","1",0,"L");$pdf->Cell(30,6,"$riadok->hodp","1",0,"R");
$pdf->Cell(0,6," ","1",1,"R");
}

}
$i = $i + 1;
$j = $j + 1;
if( $j > 30 ) $j=0;

  }


$pdf->Output("$outfilex");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

?> 

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
