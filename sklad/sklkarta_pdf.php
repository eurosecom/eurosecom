<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 2000;
$clsm = 920;
$cslm=403101;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

$h_skl = 1*$_REQUEST['h_skl'];
$h_cis = 1*$_REQUEST['h_cis'];
$h_min = 1*$_REQUEST['h_min'];

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

$databaza="";
$mintext="";
if( $h_min == 1 )
{
$kli_vxcf=$fir_allx11;
$mintext=" - minulý rok ";

$dtbzx = include("../cis/oddel_dtbz1.php");

}


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Skladová karta PDF</title>
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
<td>EuroSecom  -  Skladová karta 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/sklkarta$kli_uzid.pdf")) { $soubor = unlink("../tmp/sklkarta$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

if ( $copern == 20 OR $copern == 10 )
    {

$vsql = 'DROP TABLE '.$databaza.'F'.$kli_vxcf.'_sklprcx'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$sqlt = <<<sklprc
(
   pox         INT,
   drp         INT,
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT,
   skl         INT,
   poh         INT,
   ico         INT,
   cis         DECIMAL(15,0),
   mno         DECIMAL(10,3),
   cen         DECIMAL(10,4),
   zas         DECIMAL(10,3),
   vdj         DECIMAL(10,3),
   prj         DECIMAL(10,3),
   zoseur      DECIMAL(10,2)
);
sklprc;

$vsql = 'CREATE TABLE '.$databaza.'F'.$kli_vxcf.'_sklprcx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$podmskl = "skl > 0";
if( $h_skl > 0 ) $podmskl = "skl = ".$h_skl;
$podmcis = "".$databaza."F$kli_vxcf"."_sklprckar".$kli_uzid.".cis > 0";
if( $copern == 10 ) $podmcis = "".$databaza."F$kli_vxcf"."_sklprckar".$kli_uzid.".cis  = ".$h_cis;


//zober zo sklprckar
$dsqlt = "INSERT INTO ".$databaza."F$kli_vxcf"."_sklprcx".$kli_uzid.
" SELECT 0,drp,ume,dat,dok,skl,poh,ico,cis,mno,cen,zas,vdj,prj,0 FROM ".$databaza."F$kli_vxcf"."_sklprckar".$kli_uzid." ".
" WHERE $podmcis AND $podmskl ".
"";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
//exit;

$dsqlt = "UPDATE ".$databaza."F$kli_vxcf"."_sklprcx$kli_uzid SET zoseur=zas*cen WHERE pox >= 0 ";
$dsql = mysql_query("$dsqlt");

//group za cis
$dsqlt = "INSERT INTO ".$databaza."F$kli_vxcf"."_sklprcx".$kli_uzid.
" SELECT 8,drp,ume,dat,dok,skl,poh,ico,cis,mno,cen,SUM(zas),SUM(vdj),SUM(prj),SUM(zoseur) FROM ".$databaza."F$kli_vxcf"."_sklprcx".$kli_uzid." ".
" GROUP BY cis".
"";
$dsql = mysql_query("$dsqlt");

//group za vsetko
$dsqlt = "INSERT INTO ".$databaza."F$kli_vxcf"."_sklprcx".$kli_uzid.
" SELECT 9,drp,ume,dat,dok,skl,poh,ico,999999999999999,mno,cen,SUM(zas),SUM(vdj),SUM(prj),SUM(zoseur) FROM ".$databaza."F$kli_vxcf"."_sklprcx".$kli_uzid." WHERE pox = 0".
" GROUP BY pox".
"";
$dsql = mysql_query("$dsqlt");


    }
//koniec pracovneho suboru zjednotenie


if ( $copern == 20 OR $copern == 10 )
  {
$podmskl = "skl > 0";
if( $h_skl > 0 ) $podmskl = "skl = ".$h_skl;
$podmcis = "".$databaza."F$kli_vxcf"."_sklprcx".$kli_uzid.".cis > 0";
if( $copern == 10 ) $podmcis = "".$databaza."F$kli_vxcf"."_sklprcx".$kli_uzid.".cis  = ".$h_cis;

$sqltt = "SELECT * ".
" FROM ".$databaza."F$kli_vxcf"."_sklprcx".$kli_uzid.
" LEFT JOIN ".$databaza."F$kli_vxcf"."_sklcis".
" ON ".$databaza."F$kli_vxcf"."_sklprcx".$kli_uzid.".cis=".$databaza."F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN ".$databaza."F$kli_vxcf"."_ico".
" ON ".$databaza."F$kli_vxcf"."_sklprcx".$kli_uzid.".ico=".$databaza."F$kli_vxcf"."_ico.ico".
" WHERE $podmcis AND $podmskl ORDER BY ".$databaza."F$kli_vxcf"."_sklprcx".$kli_uzid.".cis,pox,dat,dok,poh";

  }



//echo $sqltt;
//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//exit;

$zostatokeur=0;
$zostatok=0;
$new=0;
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
if ( $copern == 20 )  { $pdf->Cell(90,6,"Skladová karta $mintext","LTB",0,"L"); }
if ( $copern == 10 )  { $pdf->Cell(90,6,"Skladová karta $mintext","LTB",0,"L"); }
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);


$pdf->Cell(10,5,"SKL","1",0,"R");$pdf->Cell(20,5,"Dátum","1",0,"R");$pdf->Cell(20,5,"Doklad","1",0,"R");
$pdf->Cell(20,5,"Pohyb","1",0,"R");$pdf->Cell(60,5,"Dodávate¾/Odberate¾","1",0,"L");
$pdf->Cell(20,5,"Množstvo MJ","1",0,"R");$pdf->Cell(20,5,"Cena/MJ","1",0,"R");
$pdf->Cell(20,5,"Príjem MJ","1",0,"R");$pdf->Cell(20,5,"Výdaj MJ","1",0,"R");
$pdf->Cell(20,5,"Zostatok Eur","1",0,"R");$pdf->Cell(0,5,"Zostatok MJ","1",1,"R");

$pdf->SetFont('arial','',9);
$pdf->Cell(0,5,"Materiál $riadok->cis $riadok->nat v $riadok->mer ","1",1,"L");

$new=0;
     }
//koniec hlavicky j=0



if( $riadok->pox == 0 )
{

$pdf->SetFont('arial','',9);

$zostatok=$zostatok+$riadok->zas;
$zostatokeur=$zostatokeur+$riadok->zoseur;

$Cislo=$zostatok+"";
$szostatok=sprintf("%0.3f", $Cislo);
$Cislo=$zostatokeur+"";
$szostatokeur=sprintf("%0.2f", $Cislo);

$dat_sk=SkDatum($riadok->dat);
$prj=$riadok->prj;
if( $riadok->prj == 0 ) $prj="";
$vdj=$riadok->vdj;
if( $riadok->vdj == 0 ) $vdj="";

if( $new == 1 ) { $pdf->Cell(0,5,"Materiál $riadok->cis $riadok->nat v $riadok->mer ","1",1,"L"); $j=$j+1; $new=0; }

$pdf->Cell(10,5,"$riadok->skl","0",0,"R");$pdf->Cell(20,5,"$dat_sk","0",0,"R");$pdf->Cell(20,5,"$riadok->dok","0",0,"R");
$pdf->Cell(20,5,"$riadok->poh","0",0,"R");$pdf->Cell(60,5,"$riadok->nai","0",0,"L");
$pdf->Cell(20,5,"$riadok->mno","0",0,"R");$pdf->Cell(20,5,"$riadok->cen","0",0,"R");
$pdf->Cell(20,5,"$prj","0",0,"R");$pdf->Cell(20,5,"$vdj","0",0,"R");
$pdf->Cell(20,5,"$szostatokeur","0",0,"R");$pdf->Cell(0,5,"$szostatok","0",1,"R");

}

if( $riadok->pox == 8 )
{

$pdf->SetFont('arial','',9);

$pdf->Cell(170,5,"CELKOM Materiál $riadok->cis $riadok->nat v $riadok->mer ","LTB",0,"L");
$pdf->Cell(20,5,"$riadok->prj","TB",0,"R");$pdf->Cell(20,5,"$riadok->vdj","TB",0,"R");
$pdf->Cell(20,5,"$riadok->zoseur","TB",0,"R");$pdf->Cell(0,5,"$riadok->zas","RTB",1,"R");

$zostatok=0;
$zostatokeur=0;
$new=1;
$pdf->Cell(0,5," ","0",1,"R");
$j=$j+1;
}


if( $riadok->pox == 9 )
{

$pdf->SetFont('arial','',9);

$pdf->Cell(210,5,"CELKOM všetko","LTB",0,"L");
$pdf->Cell(20,5,"$riadok->zoseur","TB",0,"R");$pdf->Cell(0,5,"$riadok->zas","RTB",1,"R");
$j=$j+1;
}



}
$i = $i + 1;
$j = $j + 1;
if( $j > 30 ) $j=0;

  }


$pdf->Output("../tmp/sklkarta.$kli_uzid.pdf");


$sqlt = 'DROP TABLE '.$databaza.'F'.$kli_vxcf.'_sklprc'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE '.$databaza.'F'.$kli_vxcf.'_sklprcd'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

if( $h_min == 1 AND $copern == 20 )
{
$sqlt = 'DROP TABLE '.$databaza.'F'.$kli_vxcf.'_sklprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$vsql = "CREATE TABLE ".$databaza."F".$kli_vxcf."_sklprc".$kli_uzid." SELECT * FROM ".$databaza."F".$kli_vxcf."_sklprcx".$kli_uzid." ";
$vytvor = mysql_query("$vsql");
}
?> 

<script type="text/javascript">
  var okno = window.open("../tmp/sklkarta.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
