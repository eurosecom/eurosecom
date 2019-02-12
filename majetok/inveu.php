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




if( $copern == 1 OR $copern == 10  )
     {
//nacitaj komisiu
$h_mail="";
$h_mdov="";
$h_dovv="";
$h_dovv2="";
$h_dovv3="";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_majinventuraset WHERE ocx = 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_mail=$riaddok->mail;
  $h_mdov=$riaddok->mdov;
  $h_dovv=$riaddok->dovv;
  $h_dovv2=$riaddok->dovv2;
  $h_dovv3=$riaddok->dovv3;
  }
//koniec nacitaj komisiu
     }




//tlac inventura
if( $copern == 10 )
{


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<zozprc
(
   pol          INT,
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
   meso         DECIMAL(10,2)
);
zozprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_zozprc'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_zozprx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

if( $drupoh == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprc$kli_uzid".
" SELECT 1,1,drm,inv,naz,zar,rzv,str,zak,cen,ops,zos,ros,0,0,0,0,0,0,0,0,spo,sku,perc,meso".
" FROM F$kli_vxcf"."_$tabl".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_zozprc$kli_uzid,F$kli_vxcf"."_majtextmaj ".
" SET druh=99, ceneu=cene, censr=cens ".
" WHERE F$kli_vxcf"."_zozprc$kli_uzid.inv=F$kli_vxcf"."_majtextmaj.invt AND F$kli_vxcf"."_majtextmaj.zdro = 2 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_zozprc$kli_uzid WHERE druh != 99  ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_zozprc$kli_uzid,F$kli_vxcf"."_majtextmaj SET roseu=ros*pere/100, opseu=ops*pere/100 ".
" WHERE F$kli_vxcf"."_zozprc$kli_uzid.inv=F$kli_vxcf"."_majtextmaj.invt ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_zozprc$kli_uzid,F$kli_vxcf"."_majtextmaj SET rossr=ros*peru/100, opssr=ops*peru/100 ".
" WHERE F$kli_vxcf"."_zozprc$kli_uzid.inv=F$kli_vxcf"."_majtextmaj.invt ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_zozprc$kli_uzid  SET druh=1 ";
$dsql = mysql_query("$dsqlt");

}

if( $kli_vxcf == 909 AND $_SERVER['SERVER_NAME'] == "www.europkse.sk" ) 
{
$dsqlt = "UPDATE F$kli_vxcf"."_zozprc$kli_uzid SET opseu=53514.53 WHERE inv=156 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_zozprc$kli_uzid SET opssr=849.91   WHERE inv=159 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_zozprc$kli_uzid SET opseu=24381.71 WHERE inv=177 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_zozprc$kli_uzid SET opssr=3733.31  WHERE inv=178 ";
$dsql = mysql_query("$dsqlt");
}

if( $h_trd == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprx$kli_uzid ".
" SELECT SUM(pol),99,drm,inv,naz,zar,rzv,str,zak,SUM(cen),SUM(ops),SUM(zos),SUM(ros),".
"SUM(ceneu),SUM(opseu),SUM(zoseu),SUM(roseu),SUM(censr),SUM(opssr),SUM(zossr),SUM(rossr),spo,sku,perc,meso".
" FROM F$kli_vxcf"."_zozprc$kli_uzid WHERE druh = 1".
" GROUP BY drm".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

if( $h_trd == 2 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprx$kli_uzid ".
" SELECT SUM(pol),98,drm,inv,naz,zar,rzv,str,zak,SUM(cen),SUM(ops),SUM(zos),SUM(ros),".
"SUM(ceneu),SUM(opseu),SUM(zoseu),SUM(roseu),SUM(censr),SUM(opssr),SUM(zossr),SUM(rossr),spo,sku,perc,meso".
" FROM F$kli_vxcf"."_zozprc$kli_uzid WHERE druh = 1".
" GROUP BY str".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

//group za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprx$kli_uzid ".
" SELECT SUM(pol),999,9999,inv,naz,zar,rzv,str,zak,SUM(cen),SUM(ops),SUM(zos),SUM(ros),".
"SUM(ceneu),SUM(opseu),SUM(zoseu),SUM(roseu),SUM(censr),SUM(opssr),SUM(zossr),SUM(rossr),spo,sku,perc,meso".
" FROM F$kli_vxcf"."_zozprc$kli_uzid WHERE druh = 1".
" GROUP BY druh".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprc$kli_uzid".
" SELECT pol,druh,drm,inv,naz,zar,rzv,str,zak,cen,ops,zos,ros,ceneu,opseu,zoseu,roseu,censr,opssr,zossr,rossr,spo,sku,perc,meso".
" FROM F$kli_vxcf"."_zozprx$kli_uzid".
"";
$dsql = mysql_query("$dsqlt");

$hhmmss = Date ("His", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/invmaj_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/invmaj_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }


   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$strana=0;

//spolu eu a sr
$dsqlt = "ALTER TABLE F$kli_vxcf"."_zozprc$kli_uzid ADD rossx DECIMAL(10,2) DEFAULT 0 AFTER meso ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "ALTER TABLE F$kli_vxcf"."_zozprc$kli_uzid ADD zossx DECIMAL(10,2) DEFAULT 0 AFTER meso ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "ALTER TABLE F$kli_vxcf"."_zozprc$kli_uzid ADD opssx DECIMAL(10,2) DEFAULT 0 AFTER meso ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "ALTER TABLE F$kli_vxcf"."_zozprc$kli_uzid ADD censx DECIMAL(10,2) DEFAULT 0 AFTER meso ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_zozprc$kli_uzid SET censx=ceneu+censr,opssx=opseu+opssr,rossx=roseu+rossr ";
$dsql = mysql_query("$dsqlt");


if( $h_trd == 0 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_zozprc$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_majtextmaj".
" ON F$kli_vxcf"."_zozprc$kli_uzid.inv=F$kli_vxcf"."_majtextmaj.invt".
" WHERE inv >= 0 ORDER BY druh,inv";
}
if( $h_trd == 1 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_zozprc$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_majtextmaj".
" ON F$kli_vxcf"."_zozprc$kli_uzid.inv=F$kli_vxcf"."_majtextmaj.invt".
" WHERE inv >= 0 ORDER BY drm,druh,inv";
}
if( $h_trd == 2 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_zozprc$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_majtextmaj".
" ON F$kli_vxcf"."_zozprc$kli_uzid.inv=F$kli_vxcf"."_majtextmaj.invt".
" WHERE inv >= 0 ORDER BY str,druh,inv";
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
$zostatok=$rtov->zos;
if( $zostatok == 0 ) $zostatok="";
$zostatokeu=$rtov->ceneu-$rtov->opseu;
if( $zostatokeu == 0 ) $zostatokeu="";
$zostatoksr=$rtov->censr-$rtov->opssr;
if( $zostatoksr == 0 ) $zostatoksr="";
$zostatoksx=$rtov->censx-$rtov->opssx;
if( $zostatoksx == 0 ) $zostatoksx="";

//nova strana j=0
if( $j == 0 )
{
if( $i > 0 ) { $pdf->Cell(180,0," ","T",1,"R"); }

$pdf->AddPage();
$pdf->SetFont('arial','',7);
$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 
$strana=$strana+1;


if( $drupoh == 1 )
{
$pdf->Cell(80,5,"Inventúrna zostava majetku obstaraného z prostriedkov EU $kli_vume ","LTB",0,"L");
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}

$pdf->SetFont('arial','',6);
$pdf->Cell(20,5,"Inv.è.","1",0,"R");$pdf->Cell(63,5,"Popis","1",0,"L");
$pdf->Cell(10,5,"STR","1",0,"L");$pdf->Cell(20,5,"ZÁK","1",0,"L");$pdf->Cell(9,5,"DRM","1",0,"L");
$pdf->Cell(15,5,"SKU-SPO-%","1",0,"L");
$pdf->Cell(30,5,"Cena obstarania","1",0,"R");$pdf->Cell(30,5,"Oprávky","1",0,"R");$pdf->Cell(30,5,"Zostatková cena","1",0,"R");$pdf->Cell(30,5,"Roèný odpis","1",0,"R");
$pdf->Cell(14,5,"Zaradené","TB",0,"L");
$pdf->Cell(0,5," ","RTB",1,"L");
$pdf->SetFont('arial','',7);
}
//koniec j=0


if ( $rtov->druh == 1 )
{
$pdf->Cell(20,4,"$rtov->inv","0",0,"R");$pdf->Cell(63,4,"$rtov->naz","0",0,"L");
$pdf->Cell(10,4,"$rtov->str","0",0,"L");$pdf->Cell(20,4,"$rtov->zak","0",0,"L");$pdf->Cell(9,4,"$rtov->drm","0",0,"L");
if( $rtov->perc == 0 AND $rtov->meso == 0 )
{
$pdf->Cell(15,4,"$rtov->sku-$rtov->spo ","0",0,"L");
}
if( $rtov->perc != 0 AND $rtov->meso == 0 )
{
$pdf->Cell(15,4,"$rtov->perc%","0",0,"L");
}
if( $rtov->perc == 0 AND $rtov->meso != 0 )
{
$pdf->Cell(15,4,"$rtov->meso $mena1","0",0,"L");
}
if( $rtov->perc != 0 AND $rtov->meso != 0 )
{
$pdf->Cell(15,4,"$rtov->sku-$rtov->spo/$rtov->meso ","0",0,"L");
}
$pdf->Cell(30,4,"$rtov->cen","0",0,"R");$pdf->Cell(30,4,"$rtov->ops","0",0,"R");$pdf->Cell(30,4,"$zostatok","0",0,"R");$pdf->Cell(30,4,"$rtov->ros","0",0,"R");
$pdf->Cell(14,4,"$sk_zar","0",0,"L");
$pdf->Cell(0,4," ","0",1,"L");

$pdf->Cell(83,4,"obstarané z prostriedkov EU","0",0,"L");
$pdf->Cell(10,4,"$rtov->stre","0",0,"L");$pdf->Cell(20,4,"$rtov->zake","0",0,"L");$pdf->Cell(24,4," ","0",0,"L");
$pdf->Cell(30,4,"$rtov->ceneu","0",0,"R");$pdf->Cell(30,4,"$rtov->opseu","0",0,"R");$pdf->Cell(30,4,"$zostatokeu","0",0,"R");$pdf->Cell(30,4,"$rtov->roseu","0",1,"R");

$pdf->Cell(83,4,"obstarané z prostriedkov SR","0",0,"L");
$pdf->Cell(10,4,"$rtov->stru","0",0,"L");$pdf->Cell(20,4,"$rtov->zaku","0",0,"L");$pdf->Cell(24,4," ","0",0,"L");
$pdf->Cell(30,4,"$rtov->censr","B",0,"R");$pdf->Cell(30,4,"$rtov->opssr","B",0,"R");$pdf->Cell(30,4,"$zostatoksr","B",0,"R");$pdf->Cell(30,4,"$rtov->rossr","B",1,"R");

$pdf->Cell(83,4,"Spolu EU + SR","B",0,"L");
$pdf->Cell(10,4," ","B",0,"L");$pdf->Cell(20,4," ","B",0,"L");$pdf->Cell(24,4," ","B",0,"L");
$pdf->Cell(30,4,"$rtov->censx","B",0,"R");$pdf->Cell(30,4,"$rtov->opssx","B",0,"R");$pdf->Cell(30,4,"$zostatoksx","B",0,"R");$pdf->Cell(30,4,"$rtov->rossx","B",1,"R");


}

if ( $rtov->druh == 99 )
{
$pdf->SetFont('arial','',8);
$pdf->Cell(91,4,"CELKOM DRM$rtov->drm = $rtov->pol položiek","LTB",0,"R");
$pdf->Cell(10,4," ","TB",0,"L");$pdf->Cell(20,4," ","TB",0,"L");$pdf->Cell(16,4," ","TB",0,"L");
$pdf->Cell(30,4,"$rtov->cen","LRTB",0,"R");$pdf->Cell(30,4,"$rtov->ops","LRTB",0,"R");$pdf->Cell(30,4,"$zostatok","LTB",0,"R");$pdf->Cell(30,4,"$rtov->ros","LRTB",0,"R");
$pdf->Cell(0,4," ","RTB",1,"L");
$pdf->SetFont('arial','',7);
$pdf->Cell(180,4," ","B",1,"L");
$j=$j+1;
}

if ( $rtov->druh == 98 )
{
$pdf->SetFont('arial','',8);
$pdf->Cell(91,4,"CELKOM STR$rtov->str = $rtov->pol položiek","LTB",0,"R");
$pdf->Cell(10,4," ","TB",0,"L");$pdf->Cell(20,4," ","TB",0,"L");$pdf->Cell(16,4," ","TB",0,"L");
$pdf->Cell(30,4,"$rtov->cen","LRTB",0,"R");$pdf->Cell(30,4,"$rtov->ops","LRTB",0,"R");$pdf->Cell(30,4,"$zostatok","LTB",0,"R");$pdf->Cell(30,4,"$rtov->ros","LRTB",0,"R");
$pdf->Cell(0,4," ","RTB",1,"L");
$pdf->SetFont('arial','',7);
//$pdf->Cell(180,4," ","B",1,"L");
$j=-1;

$pdf->Cell(0,10," ","0",1,"R");



$pdf->Cell(70,6,"Inventúra vykonaná dòa: $h_mail","1",1,"L");
$pdf->Cell(0,2," ","0",1,"L");
$pdf->Cell(70,6,"Zodpovedný pracovník: $h_mdov","1",1,"L");
$pdf->Cell(0,2," ","0",1,"L");
$pdf->Cell(40,6,"Èlenovia komisie:","1",0,"L");$pdf->Cell(30,6,"$h_dovv","1",0,"L");$pdf->Cell(30,6,"$h_dovv2","1",0,"L");$pdf->Cell(30,6,"$h_dovv3","1",1,"L");
}

if ( $rtov->druh == 999 )
{
$pdf->SetFont('arial','',8);
$pdf->Cell(91,5,"CELKOM MAJETOK = $rtov->pol položiek","LT",0,"R");
$pdf->Cell(10,5," ","T",0,"L");$pdf->Cell(20,5," ","T",0,"L");$pdf->Cell(16,5," ","T",0,"L");
$pdf->Cell(30,5,"$rtov->cen","T",0,"R");$pdf->Cell(30,5,"$rtov->ops","T",0,"R");$pdf->Cell(30,5,"$zostatok","T",0,"R");$pdf->Cell(30,5,"$rtov->ros","TR",1,"R");

$pdf->Cell(83,5,"obstarané z prostriedkov EU","L",0,"L");
$pdf->Cell(10,5,"$rtov->stre","0",0,"L");$pdf->Cell(20,5,"$rtov->zake","0",0,"L");$pdf->Cell(24,5," ","0",0,"L");
$pdf->Cell(30,5,"$rtov->ceneu","0",0,"R");$pdf->Cell(30,5,"$rtov->opseu","0",0,"R");$pdf->Cell(30,5,"$zostatokeu","0",0,"R");$pdf->Cell(30,5,"$rtov->roseu","R",1,"R");

$pdf->Cell(83,5,"obstarané z prostriedkov SR","L",0,"L");
$pdf->Cell(10,5,"$rtov->stru","0",0,"L");$pdf->Cell(20,5,"$rtov->zaku","0",0,"L");$pdf->Cell(24,5," ","0",0,"L");
$pdf->Cell(30,5,"$rtov->censr","0",0,"R");$pdf->Cell(30,5,"$rtov->opssr","0",0,"R");$pdf->Cell(30,5,"$zostatoksr","0",0,"R");$pdf->Cell(30,5,"$rtov->rossr","R",1,"R");


$pdf->Cell(83,5,"Spolu EU + SR","LB",0,"L");
$pdf->Cell(10,5," ","B",0,"L");$pdf->Cell(20,5," ","B",0,"L");$pdf->Cell(24,5," ","B",0,"L");
$pdf->Cell(30,5,"$rtov->censx","B",0,"R");$pdf->Cell(30,5,"$rtov->opssx","B",0,"R");$pdf->Cell(30,5,"$zostatoksx","B",0,"R");$pdf->Cell(30,5,"$rtov->rossx","BR",1,"R");


$pdf->SetFont('arial','',7);
}



}
$i = $i + 1;
$j = $j + 1;
if( $j > 64 ) $j=0;
  }

$pdf->Cell(0,10," ","0",1,"R");


$pdf->Cell(70,6,"Inventúra vykonaná dòa: $h_mail","1",1,"L");
$pdf->Cell(0,2," ","0",1,"L");
$pdf->Cell(70,6,"Zodpovedný pracovník: $h_mdov","1",1,"L");
$pdf->Cell(0,2," ","0",1,"L");
$pdf->Cell(40,6,"Èlenovia komisie:","1",0,"L");$pdf->Cell(30,6,"$h_dovv","1",0,"L");$pdf->Cell(30,6,"$h_dovv2","1",0,"L");$pdf->Cell(30,6,"$h_dovv3","1",1,"L");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$koniec=184;
$pdf->SetY($koniec);
$pdf->Line(15, $koniec, 195, $koniec); 
$pdf->SetY($koniec+2);
$pdf->SetFont('arial','',6);
$pdf->Cell(180,3,"Vytlaèil(a): $kli_uzmeno $kli_uzprie / $kli_uzid ","0",1,"L");




$pdf->Output("$outfilex");

?> 

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
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
