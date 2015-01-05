<HTML>
<?php
$sys = 'HIM';
$urov = 1000;
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
$drupoh = 1*$_REQUEST['drupoh'];
$cislo_dok = $_REQUEST['cislo_dok'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";


$h_trd = 1*$_REQUEST['h_trd'];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

if( $drupoh == 1 )
{
$tabl = "majmaj";
}


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];


//tlac inventura
if( $copern == 10 )
{


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprcneu'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprxneu'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<zozprc
(
   pol          INT,
   kat          INT(2),
   druh         INT(2),
   drm          INT(7),
   inv          DECIMAL(15,0),
   naz          VARCHAR(40),
   zar          DATE,
   rzv          INT(4),
   str          INT,
   zak          INT,
   cen          DECIMAL(12,2),
   ops          DECIMAL(12,2),
   zos          DECIMAL(12,2),
   ros          DECIMAL(12,2),
   cend          DECIMAL(12,2),
   opsd          DECIMAL(12,2),
   zosd          DECIMAL(12,2),
   rosd          DECIMAL(12,2),
   ceneu          DECIMAL(12,2),
   opseu          DECIMAL(12,2),
   zoseu          DECIMAL(12,2),
   roseu          DECIMAL(12,2),
   censr          DECIMAL(12,2),
   opssr          DECIMAL(12,2),
   zossr          DECIMAL(12,2),
   rossr          DECIMAL(12,2),
   spo          INT,
   sku          INT,
   perc         DECIMAL(10,2),
   meso         DECIMAL(10,2),
   zosux          DECIMAL(12,2),
   rosux          DECIMAL(12,2),
   zosdx          DECIMAL(12,2),
   rosdx          DECIMAL(12,2)
)
zozprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_zozprcneu'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_zozprxneu'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$zar1=$kli_vrok."-01-01";
$zar2=$kli_vrok."-12-31";
$prvyume="1.".$kli_vrok;

//pol,kat,druh,drm
//kat 1=stav k 1.1. bez ubytkov, 2=prirastky, 3=ubytky, 4-celkom stav k 31.12. aktualny _majmaj
if( $drupoh == 1 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprcneu$kli_uzid (pol,kat,druh,drm,inv) VALUES (1,2,1,'22',0) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprcneu$kli_uzid (pol,kat,druh,drm,inv) VALUES (1,3,1,'22',0) ";
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprcneu$kli_uzid".
" SELECT 1,1,1,drm,inv,naz,zar,rzv,str,zak,cen,ops,zos,rop,0,0,0,0,0,0,0,0,0,0,0,0,spo,sku,perc,meso,0,0,0,0 ".
" FROM F$kli_vxcf"."_majodpisy WHERE inv >= 0 AND ume = $prvyume AND zar < '$zar1' ".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_zozprcneu$kli_uzid".
" SET ros=zss WHERE ros > zss ";
//$dsql = mysql_query("$dsqlt");

//zar
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprcneu$kli_uzid".
" SELECT 1,2,1,drm,inv,naz,zar,rzv,str,zak,cen,ops,zos,ros,0,0,0,0,0,0,0,0,0,0,0,0,spo,sku,perc,meso,0,0,0,0 ".
" FROM F$kli_vxcf"."_majpoh WHERE inv >= 0 AND poh = 2 ".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");

//vyr
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprcneu$kli_uzid".
" SELECT 1,3,1,drm,inv,naz,zar,rzv,str,zak,cen,ops,zos,zss,0,0,0,0,0,0,0,0,0,0,0,0,spo,sku,perc,meso,0,0,0,0 ".
" FROM F$kli_vxcf"."_majpoh WHERE inv >= 0 AND poh = 3 ".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprcneu$kli_uzid".
" SELECT 1,4,1,drm,inv,naz,zar,rzv,str,zak,cen,ops,zos,ros,0,0,0,0,0,0,0,0,0,0,0,0,spo,sku,perc,meso,0,0,0,0 ".
" FROM F$kli_vxcf"."_majmaj WHERE inv >= 0 ".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");

//dopln k zaradeniu odpisy z majmaj
$dsqlt = "UPDATE F$kli_vxcf"."_zozprcneu$kli_uzid, F$kli_vxcf"."_majmaj ".
" SET F$kli_vxcf"."_zozprcneu$kli_uzid.ros=F$kli_vxcf"."_majmaj.ros ".
" WHERE F$kli_vxcf"."_zozprcneu$kli_uzid.inv=F$kli_vxcf"."_majmaj.inv AND F$kli_vxcf"."_zozprcneu$kli_uzid.kat = 2 ";
$dsql = mysql_query("$dsqlt");


}



//group za skupinu
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprxneu$kli_uzid ".
" SELECT SUM(pol),kat,1,9999,inv,naz,zar,rzv,str,zak,SUM(cen),SUM(ops),SUM(zos),SUM(ros),SUM(cend),SUM(opsd),SUM(zosd),SUM(rosd),".
"SUM(ceneu),SUM(opseu),SUM(zoseu),SUM(roseu),SUM(censr),SUM(opssr),SUM(zossr),SUM(rossr),spo,sku,perc,meso,SUM(zosux),SUM(rosux),SUM(zosdx),SUM(rosdx) ".
" FROM F$kli_vxcf"."_zozprcneu$kli_uzid WHERE druh = 1".
" GROUP BY kat,sku ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//group za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprxneu$kli_uzid ".
" SELECT SUM(pol),kat,999,9999,inv,naz,zar,rzv,str,zak,SUM(cen),SUM(ops),SUM(zos),SUM(ros),SUM(cend),SUM(opsd),SUM(zosd),SUM(rosd),".
"SUM(ceneu),SUM(opseu),SUM(zoseu),SUM(roseu),SUM(censr),SUM(opssr),SUM(zossr),SUM(rossr),spo,999,perc,meso,SUM(zosux),SUM(rosux),SUM(zosdx),SUM(rosdx) ".
" FROM F$kli_vxcf"."_zozprcneu$kli_uzid WHERE druh = 1".
" GROUP BY kat,druh".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

if (File_Exists ("../tmp/invmaj.$kli_uzid.pdf")) { $soubor = unlink("../tmp/invmaj.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$strana=0;


if( $h_trd == 0 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_zozprxneu$kli_uzid".
" WHERE inv >= 0 ORDER BY kat,druh,sku ";
}



//echo $sqltt;
$sql = mysql_query("$sqltt");

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

$j=0;           
$j=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);
$sk_zar = SkDatum($rtov->zar);


//nova strana j=0
if( $j == 0 )
{
if( $i > 0 ) { $pdf->Cell(180,0," ","T",1,"R"); }

$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 
$strana=$strana+1;


$pdf->Cell(80,5,"Odpisový plán majetku","LTB",0,"L");
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");


$h_ycf=0;
if ( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");
$kli_mrok=$kli_vrok-1;

$jemin=0; $id=0;
$sqldok = mysql_query("SELECT * FROM ".$databaza."F$h_ycf"."_majdrm ORDER BY cdrm ");
$pold = mysql_num_rows($sqldok);
  while( $id < $pold )
  {
  $riaddok=mysql_fetch_object($sqldok);

if( $id == 0 ) {
$pdf->Cell(30,5," ","0",1,"R");
$pdf->Cell(80,5,"Odpisové sadzby k 31.12. $kli_mrok ","1",1,"L");
$pdf->Cell(40,5,"Druh majetku","1",0,"L");$pdf->Cell(40,5,"Rokov","1",1,"R");
               }

$akesku=""; $is=0; $akedrm=$riaddok->cdrm;
$sqltts = "SELECT drm,sku FROM ".$databaza."F$h_ycf"."_majmaj WHERE drm = ".$akedrm." GROUP BY sku ";
$sqldos = mysql_query("$sqltts");
//echo $sqltts;
$pols = mysql_num_rows($sqldos);
    while( $is <= $pols )
    {
    $riaddos=mysql_fetch_object($sqldos);

	$sqlico = mysql_query("SELECT * FROM ".$databaza."F$h_ycf"."_majsodp ");
  	if (@$zaznam=mysql_data_seek($sqlico,0))
  	{
  	$riadico=mysql_fetch_object($sqlico);

	$oddx="";
        if( $id == 0 ) { $oddx=""; }

  	//if( $riaddos->sku == 1 ) { $akesku=$akesku." sku".$riaddos->sku."/".$riadico->rdoba1; }
  	//if( $riaddos->sku == 2 ) { $akesku=$akesku." sku".$riaddos->sku."/".$riadico->rdoba2; }
  	//if( $riaddos->sku == 3 ) { $akesku=$akesku." sku".$riaddos->sku."/".$riadico->rdoba3; }
  	//if( $riaddos->sku == 4 ) { $akesku=$akesku." sku".$riaddos->sku."/".$riadico->rdoba4; }
  	//if( $riaddos->sku == 5 ) { $akesku=$akesku." sku".$riaddos->sku."/".$riadico->rdoba5; }
  	//if( $riaddos->sku == 6 ) { $akesku=$akesku." sku".$riaddos->sku."/".$riadico->rdoba6; }
  	if( $riaddos->sku == 1 ) { $akesku=$akesku." ".$oddx.$riadico->rdoba1; }
  	if( $riaddos->sku == 2 ) { $akesku=$akesku." ".$oddx.$riadico->rdoba2; }
  	if( $riaddos->sku == 3 ) { $akesku=$akesku." ".$oddx.$riadico->rdoba3; }
  	if( $riaddos->sku == 4 ) { $akesku=$akesku." ".$oddx.$riadico->rdoba4; }
  	if( $riaddos->sku == 5 ) { $akesku=$akesku." ".$oddx.$riadico->rdoba5; }
  	if( $riaddos->sku == 6 ) { $akesku=$akesku." ".$oddx.$riadico->rdoba6; }
  	}

    $is=$is+1;
    }


$pdf->Cell(40,5,"$riaddok->ndrm","1",0,"L");$pdf->Cell(40,5,"$akesku","1",1,"R");


  $id=$id+1;
  }


//odpisove sadzby aktualny rok
$pdf->SetY(15);

$jemin=0; $id=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_majdrm ORDER BY cdrm ");
$pold = mysql_num_rows($sqldok);
  while( $id < $pold )
  {
  $riaddok=mysql_fetch_object($sqldok);

if( $id == 0 ) {
$pdf->SetX(110);$pdf->Cell(30,5," ","0",1,"R");
$pdf->SetX(110);$pdf->Cell(80,5,"Odpisové sadzby k 31.12. $kli_vrok ","1",1,"L");
$pdf->SetX(110);$pdf->Cell(40,5,"Druh majetku","1",0,"L");$pdf->Cell(40,5,"Rokov","1",1,"R");
               }

$akesku=""; $is=0; $akedrm=$riaddok->cdrm;
$sqltts = "SELECT drm,sku FROM F$kli_vxcf"."_majmaj WHERE drm = ".$akedrm." GROUP BY sku ";
$sqldos = mysql_query("$sqltts");
//echo $sqltts;
$pols = mysql_num_rows($sqldos);
    while( $is <= $pols )
    {
    $riaddos=mysql_fetch_object($sqldos);

	$sqlico = mysql_query("SELECT * FROM ".$databaza."F$h_ycf"."_majsodp ");
  	if (@$zaznam=mysql_data_seek($sqlico,0))
  	{
  	$riadico=mysql_fetch_object($sqlico);

	$oddx="";
        if( $is == 0 ) { $oddx=""; }
  	if( $riaddos->sku == 1 ) { $akesku=$akesku." ".$oddx.$riadico->rdoba1; }
  	if( $riaddos->sku == 2 ) { $akesku=$akesku." ".$oddx.$riadico->rdoba2; }
  	if( $riaddos->sku == 3 ) { $akesku=$akesku." ".$oddx.$riadico->rdoba3; }
  	if( $riaddos->sku == 4 ) { $akesku=$akesku." ".$oddx.$riadico->rdoba4; }
  	if( $riaddos->sku == 5 ) { $akesku=$akesku." ".$oddx.$riadico->rdoba5; }
  	if( $riaddos->sku == 6 ) { $akesku=$akesku." ".$oddx.$riadico->rdoba6; }
  	}

    $is=$is+1;
    }


$pdf->SetX(110);$pdf->Cell(40,5,"$riaddok->ndrm","1",0,"L");$pdf->Cell(40,5,"$akesku","1",1,"R");


  $id=$id+1;
  }


$pdf->SetFont('arial','',8);
$pdf->Cell(30,5," ","0",1,"R");
$pdf->Cell(130,5,"Odpisy z odpisovaného majetku v stave k 1.1. $kli_vrok (bez úbytkov majetku)","0",1,"L");
$pdf->Cell(20,5,"SKU","1",0,"R");
$pdf->Cell(30,5,"Cena obstarania","1",0,"R");$pdf->Cell(30,5,"Oprávky","1",0,"R");$pdf->Cell(30,5,"Zostatková cena","1",0,"R");
$pdf->Cell(30,5,"Roèný odpis Celý","1",1,"R");


}
//koniec j=0


if ( $rtov->druh == 1 )
{
$pdf->Cell(20,4,"$rtov->sku","1",0,"R");
$pdf->Cell(30,4,"$rtov->cen","1",0,"R");$pdf->Cell(30,4,"$rtov->ops","1",0,"R");$pdf->Cell(30,4,"$rtov->zos","1",0,"R");
$pdf->Cell(30,4,"$rtov->ros","1",1,"R");

}



if ( $rtov->druh == 999 AND $rtov->kat == 1 )
{
$pdf->Cell(20,4,"Spolu","T",0,"L");
$pdf->Cell(30,4,"$rtov->cen","T",0,"R");$pdf->Cell(30,4,"$rtov->ops","T",0,"R");$pdf->Cell(30,4,"$rtov->zos","T",0,"R");
$pdf->Cell(30,4,"$rtov->ros","T",1,"R");

$pdf->Cell(30,5," ","0",1,"R");
$pdf->Cell(130,5,"Odpisy z prírastkov v roku $kli_vrok ","0",1,"L");
$pdf->Cell(20,5,"SKU","1",0,"R");
$pdf->Cell(30,5,"Cena obstarania","1",0,"R");$pdf->Cell(30,5,"Oprávky","1",0,"R");$pdf->Cell(30,5,"Zostatková cena","1",0,"R");
$pdf->Cell(30,5,"Roèný odpis Celý","1",1,"R");

}

if ( $rtov->druh == 999 AND $rtov->kat == 2 )
{
$pdf->Cell(20,4,"Spolu","T",0,"L");
$pdf->Cell(30,4,"$rtov->cen","T",0,"R");$pdf->Cell(30,4,"$rtov->ops","T",0,"R");$pdf->Cell(30,4,"$rtov->zos","T",0,"R");
$pdf->Cell(30,4,"$rtov->ros","T",1,"R");

$pdf->Cell(30,5," ","0",1,"R");
$pdf->Cell(130,5,"Odpisy z úbytkov v roku $kli_vrok ","0",1,"L");
$pdf->Cell(20,5,"SKU","1",0,"R");
$pdf->Cell(30,5,"Cena obstarania","1",0,"R");$pdf->Cell(30,5,"Oprávky","1",0,"R");$pdf->Cell(30,5,"Zostatková cena","1",0,"R");
$pdf->Cell(30,5,"Roèný odpis Celý","1",1,"R");

}

if ( $rtov->druh == 999 AND $rtov->kat == 3 )
{
$pdf->Cell(20,4,"Spolu","T",0,"L");
$pdf->Cell(30,4,"$rtov->cen","T",0,"R");$pdf->Cell(30,4,"$rtov->ops","T",0,"R");$pdf->Cell(30,4,"$rtov->zos","T",0,"R");
$pdf->Cell(30,4,"$rtov->ros","T",1,"R");

$pdf->Cell(30,5," ","0",1,"R");
$pdf->Cell(130,5,"Odpisy celkom v roku $kli_vrok ","0",1,"L");
$pdf->Cell(20,5,"SKU","1",0,"R");
$pdf->Cell(30,5,"Cena obstarania","1",0,"R");$pdf->Cell(30,5,"Oprávky","1",0,"R");$pdf->Cell(30,5,"Zostatková cena","1",0,"R");
$pdf->Cell(30,5,"Roèný odpis Celý","1",1,"R");

}

if ( $rtov->druh == 999 AND $rtov->kat == 4 )
{
$pdf->Cell(20,4,"Spolu","T",0,"L");
$pdf->Cell(30,4,"$rtov->cen","T",0,"R");$pdf->Cell(30,4,"$rtov->ops","T",0,"R");$pdf->Cell(30,4,"$rtov->zos","T",0,"R");
$pdf->Cell(30,4,"$rtov->ros","T",1,"R");


}

}
$i = $i + 1;
$j = $j + 1;
  }



$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprcneu'.$kli_uzid;
if( $kli_vmes != 12 ) { $vysledok = mysql_query("$sqlt"); }
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprxneu'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$pdf->Output("../tmp/invmaj.$kli_uzid.pdf");

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/invmaj.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
//koniec tlac inventura
}
?>




<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Inventúra majetku</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;


    
</script>
</HEAD>
<BODY class="white" >

<?php 



?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Inventúra MAJETKU</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />




<?php
// celkovy koniec dokumentu

if( $copern == 1 ) { $cislista = include("maj_lista.php"); }
       } while (false);
?>
</BODY>
</HTML>
