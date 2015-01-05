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
if( $drupoh == 2 )
{
$tabl = "majmaj";
}


//uloz nastavenie
if( $copern == 1059 )
{

$h_mail = $_REQUEST['h_mail'];
$h_dovv = $_REQUEST['h_dovv'];
$h_mdov = $_REQUEST['h_mdov'];
$h_dovv2 = $_REQUEST['h_dovv2'];
$h_dovv3 = $_REQUEST['h_dovv3'];

$sqty = "DELETE FROM F$kli_vxcf"."_majinventuraset WHERE ocx = 1  ";
$ulozene = mysql_query("$sqty");

$sqty = "INSERT INTO F$kli_vxcf"."_majinventuraset ( ocx,mail,mdov,dovv,dovv2,dovv3 )".
" VALUES ( '1', '$h_mail', '$h_mdov', '$h_dovv', '$h_dovv2', '$h_dovv3'  );"; 
$ulozene = mysql_query("$sqty");

//echo $sqty;
//exit;
$copern=1;
}
//koniec uloz nastavenie



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


$sql = "SELECT dovv3 FROM F".$kli_vxcf."_majinventuraset ";
$vysledok = mysql_query($sql);
if (!$vysledok AND $copern == 1 ){

$sql = "DROP TABLE F".$kli_vxcf."_majinventuraset ";
$vysledok = mysql_query($sql);

$sqlt = <<<uctcrv
(
   ocx           DECIMAL(5,0) DEFAULT 0,
   mail          VARCHAR(30) NOT NULL,
   mdov          VARCHAR(30) NOT NULL,
   dovv          VARCHAR(30) NOT NULL,
   dovv2         VARCHAR(30) NOT NULL,
   dovv3         VARCHAR(30) NOT NULL
);
uctcrv;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_majinventuraset'.$sqlt;
$vytvor = mysql_query("$vsql");


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
   pol          DECIMAL(10,0),
   druh         DECIMAL(10,0),
   drm          DECIMAL(10,0),
   inv          DECIMAL(15,0),
   naz          VARCHAR(40),
   zar          DATE,
   rzv          INT(4),
   str          DECIMAL(10,0),
   zak          DECIMAL(10,0),
   cen          DECIMAL(12,2),
   ops          DECIMAL(12,2),
   zos          DECIMAL(12,2),
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
" SELECT 1,1,drm,inv,naz,zar,rzv,str,zak,cen,ops,zos,spo,sku,perc,meso".
" FROM F$kli_vxcf"."_$tabl".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");
}
if( $drupoh == 2 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprc$kli_uzid".
" SELECT 1,1,drm,inv,naz,zar,rzv,str,zak,cen_dan,ops_dan,zos_dan,spo_dan,sku_dan,perc_dan,roco_dan".
" FROM F$kli_vxcf"."_$tabl".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");
}

if( $h_trd == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprx$kli_uzid ".
" SELECT SUM(pol),99,drm,inv,naz,zar,rzv,str,zak,SUM(cen),SUM(ops),SUM(zos),spo,sku,perc,meso".
" FROM F$kli_vxcf"."_zozprc$kli_uzid WHERE druh = 1".
" GROUP BY drm".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

if( $h_trd == 2 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprx$kli_uzid ".
" SELECT SUM(pol),98,drm,inv,naz,zar,rzv,str,zak,SUM(cen),SUM(ops),SUM(zos),spo,sku,perc,meso".
" FROM F$kli_vxcf"."_zozprc$kli_uzid WHERE druh = 1".
" GROUP BY str".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

$sql = "ALTER TABLE F".$kli_vxcf."_zozprc$kli_uzid ADD kcpax VARCHAR(15) not null AFTER meso ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_zozprx$kli_uzid ADD kcpax VARCHAR(15) not null AFTER meso ";
$vysledek = mysql_query("$sql");

if( $h_trd == 3 )
{

$dsqlt = "UPDATE F$kli_vxcf"."_zozprc$kli_uzid,F$kli_vxcf"."_majtextmaj SET kcpax=kcpa ".
" WHERE F$kli_vxcf"."_zozprc$kli_uzid.inv=F$kli_vxcf"."_majtextmaj.invt ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprx$kli_uzid ".
" SELECT SUM(pol),97,drm,inv,naz,zar,rzv,str,zak,SUM(cen),SUM(ops),SUM(zos),spo,sku,perc,meso,kcpax".
" FROM F$kli_vxcf"."_zozprc$kli_uzid WHERE druh = 1".
" GROUP BY kcpax".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

$sql = "ALTER TABLE F$kli_vxcf"."_zozprc$kli_uzid ADD meds DECIMAL(10,0) DEFAULT 0 AFTER kcpax";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_zozprx$kli_uzid ADD meds DECIMAL(10,0) DEFAULT 0 AFTER kcpax";
$vysledek = mysql_query("$sql");

if( $h_trd == 4 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprx$kli_uzid ".
" SELECT SUM(pol),98,9999,inv,naz,zar,rzv,str,zak,SUM(cen),SUM(ops),SUM(zos),spo,sku,perc,meso,kcpax,0".
" FROM F$kli_vxcf"."_zozprc$kli_uzid WHERE druh = 1".
" GROUP BY str ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprx$kli_uzid ".
" SELECT SUM(pol),92,drm,inv,naz,zar,rzv,str,zak,SUM(cen),SUM(ops),SUM(zos),spo,sku,perc,meso,kcpax,1".
" FROM F$kli_vxcf"."_zozprc$kli_uzid WHERE druh = 1".
" GROUP BY str,drm".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

if( $h_trd == 5 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprx$kli_uzid ".
" SELECT SUM(pol),91,9999,inv,naz,zar,rzv,str,zak,SUM(cen),SUM(ops),SUM(zos),spo,sku,perc,meso,kcpax,0".
" FROM F$kli_vxcf"."_zozprc$kli_uzid WHERE druh = 1".
" GROUP BY zak ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

}

//group za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprx$kli_uzid ".
" SELECT SUM(pol),999,9999,inv,naz,zar,rzv,99999999,9999999999,SUM(cen),SUM(ops),SUM(zos),spo,sku,perc,meso,999999999999,1".
" FROM F$kli_vxcf"."_zozprc$kli_uzid WHERE druh = 1".
" GROUP BY druh".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprc$kli_uzid".
" SELECT pol,druh,drm,inv,naz,zar,rzv,str,zak,cen,ops,zos,spo,sku,perc,meso,kcpax,meds".
" FROM F$kli_vxcf"."_zozprx$kli_uzid".
"";
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
$sqltt = "SELECT * FROM F$kli_vxcf"."_zozprc$kli_uzid"." WHERE inv >= 0 ORDER BY druh,inv";
}
if( $h_trd == 1 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_zozprc$kli_uzid"." WHERE inv >= 0 ORDER BY drm,druh,inv";
}
if( $h_trd == 2 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_zozprc$kli_uzid"." WHERE inv >= 0 ORDER BY str,druh,inv";
}
if( $h_trd == 3 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_zozprc$kli_uzid"." WHERE inv >= 0 ORDER BY kcpax,druh,inv";
}
if( $h_trd == 4 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_zozprc$kli_uzid"." WHERE inv >= 0 ORDER BY str,drm,meds,druh,inv";
}
if( $h_trd == 5 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_zozprc$kli_uzid"." WHERE inv >= 0 ORDER BY zak,druh,inv";
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

//nova strana j=0
if( $j == 0 )
{
if( $i > 0 ) { $pdf->Cell(180,0," ","T",1,"R"); }

$pdf->AddPage();
$pdf->SetFont('arial','',7);
$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 
$strana=$strana+1;

if (File_Exists ('../dokumenty/FIR'.$kli_vxcf.'/logo.jpg'))
{
$pdf->Image('../dokumenty/FIR'.$kli_vxcf.'/logo.jpg',15,5,10,10);
}
if( $drupoh == 1 )
{
$pdf->SetY(5);$pdf->Cell(10,10," ","1",0,"R");$pdf->Cell(80,5,"Inventúrna zostava dlhodobého majetku ÚÈTOVNÝ stav $kli_vume ","LTB",0,"L");
$pdf->Cell(90,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}
if( $drupoh == 2 )
{
$pdf->SetY(5);$pdf->Cell(10,5," ","0",0,"R");$pdf->Cell(80,5,"Inventúrna zostava dlhodobého majetku DAÒOVÝ stav $kli_vume","LTB",0,"L");
$pdf->Cell(90,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}
$pdf->SetFont('arial','',6);
$pdf->Cell(10,5," ","0",0,"R");
$pdf->Cell(7,5,"Inv.è.","1",0,"R");$pdf->Cell(45,5,"Popis","1",0,"L");
$pdf->Cell(8,5,"STR","1",0,"L");$pdf->Cell(12,5,"ZÁK","1",0,"L");$pdf->Cell(9,5,"DRM","1",0,"L");
$pdf->Cell(15,5,"SKU-SPO-%","1",0,"L");
$pdf->Cell(20,5,"Cena obstarania","1",0,"R");$pdf->Cell(20,5,"Oprávky","1",0,"R");$pdf->Cell(20,5,"Zostatková cena","1",0,"R");
$pdf->Cell(14,5,"Zaradené","1",1,"L");
$pdf->SetFont('arial','',7);
}
//koniec j=0


if ( $rtov->druh == 1 )
{
$pdf->Cell(17,4,"$rtov->inv","L",0,"R");$pdf->Cell(45,4,"$rtov->naz","0",0,"L");
$pdf->Cell(8,4,"$rtov->str","0",0,"L");$pdf->Cell(12,4,"$rtov->zak","0",0,"L");$pdf->Cell(9,4,"$rtov->drm","0",0,"L");
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
$pdf->Cell(20,4,"$rtov->cen","0",0,"R");$pdf->Cell(20,4,"$rtov->ops","0",0,"R");$pdf->Cell(20,4,"$zostatok","0",0,"R");
$pdf->Cell(14,4,"$sk_zar","R",1,"L");
}

if ( $rtov->druh == 97 )
{
$pdf->SetFont('arial','',8);
$pdf->Cell(70,4,"CELKOM CPA $rtov->kcpax = $rtov->pol položiek","LTB",0,"R");
$pdf->Cell(8,4," ","TB",0,"L");$pdf->Cell(12,4," ","TB",0,"L");$pdf->Cell(16,4," ","TB",0,"L");
$pdf->Cell(20,4,"$rtov->cen","LRTB",0,"R");$pdf->Cell(20,4,"$rtov->ops","LRTB",0,"R");$pdf->Cell(20,4,"$zostatok","LTB",0,"R");
$pdf->Cell(14,4," ","RTB",1,"L");
$pdf->SetFont('arial','',7);
$pdf->Cell(180,4," ","B",1,"L");
$j=$j+1;
}

if ( $rtov->druh == 91 )
{
$pdf->SetFont('arial','',8);
$pdf->Cell(70,4,"CELKOM zak$rtov->zak = $rtov->pol položiek","LTB",0,"R");
$pdf->Cell(8,4," ","TB",0,"L");$pdf->Cell(12,4," ","TB",0,"L");$pdf->Cell(16,4," ","TB",0,"L");
$pdf->Cell(20,4,"$rtov->cen","LRTB",0,"R");$pdf->Cell(20,4,"$rtov->ops","LRTB",0,"R");$pdf->Cell(20,4,"$zostatok","LTB",0,"R");
$pdf->Cell(14,4," ","RTB",1,"L");
$pdf->SetFont('arial','',7);
$pdf->Cell(180,4," ","B",1,"L");
$j=$j+1;
}

if ( $rtov->druh == 92 )
{
$pdf->SetFont('arial','',8);
$pdf->Cell(70,4,"CELKOM DRM$rtov->drm v str$rtov->str = $rtov->pol položiek","LTB",0,"R");
$pdf->Cell(8,4," ","TB",0,"L");$pdf->Cell(12,4," ","TB",0,"L");$pdf->Cell(16,4," ","TB",0,"L");
$pdf->Cell(20,4,"$rtov->cen","LRTB",0,"R");$pdf->Cell(20,4,"$rtov->ops","LRTB",0,"R");$pdf->Cell(20,4,"$zostatok","LTB",0,"R");
$pdf->Cell(14,4," ","RTB",1,"L");
$pdf->SetFont('arial','',7);
$pdf->Cell(180,4," ","B",1,"L");
$j=$j+1;
}

if ( $rtov->druh == 99 )
{
$pdf->SetFont('arial','',8);
$pdf->Cell(70,4,"CELKOM DRM$rtov->drm = $rtov->pol položiek","LTB",0,"R");
$pdf->Cell(8,4," ","TB",0,"L");$pdf->Cell(12,4," ","TB",0,"L");$pdf->Cell(16,4," ","TB",0,"L");
$pdf->Cell(20,4,"$rtov->cen","LRTB",0,"R");$pdf->Cell(20,4,"$rtov->ops","LRTB",0,"R");$pdf->Cell(20,4,"$zostatok","LTB",0,"R");
$pdf->Cell(14,4," ","RTB",1,"L");
$pdf->SetFont('arial','',7);
$pdf->Cell(180,4," ","B",1,"L");
$j=$j+1;
}

if ( $rtov->druh == 98 )
{
$pdf->SetFont('arial','',8);
$pdf->Cell(70,4,"CELKOM STR$rtov->str = $rtov->pol položiek","LTB",0,"R");
$pdf->Cell(8,4," ","TB",0,"L");$pdf->Cell(12,4," ","TB",0,"L");$pdf->Cell(16,4," ","TB",0,"L");
$pdf->Cell(20,4,"$rtov->cen","LRTB",0,"R");$pdf->Cell(20,4,"$rtov->ops","LRTB",0,"R");$pdf->Cell(20,4,"$zostatok","LTB",0,"R");
$pdf->Cell(14,4," ","RTB",1,"L");
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
$pdf->Cell(70,5,"CELKOM MAJETOK = $rtov->pol položiek","LTB",0,"R");
$pdf->Cell(8,5," ","TB",0,"L");$pdf->Cell(12,5," ","TB",0,"L");$pdf->Cell(16,5," ","TB",0,"L");
$pdf->Cell(20,5,"$rtov->cen","LRTB",0,"R");$pdf->Cell(20,5,"$rtov->ops","LRTB",0,"R");$pdf->Cell(20,5,"$zostatok","LTB",0,"R");
$pdf->Cell(14,5," ","RTB",1,"L");
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


$koniec=270;
$pdf->SetY($koniec);
$pdf->Line(15, $koniec, 195, $koniec); 
$pdf->SetY($koniec+2);
$pdf->SetFont('arial','',6);
$pdf->Cell(180,3,"Vytlaèil(a): $kli_uzmeno $kli_uzprie / $kli_uzid ","0",1,"L");



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

function InvZar()
                {
var h_trd = 0;

window.open('../majetok/zarad_maj.php?h_trd=' + h_trd + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function InvEU()
                {
var h_trd = document.forms.formpe3.h_trd.value;

window.open('../majetok/inveu.php?h_trd=' + h_trd + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function InvDar()
                {
var h_trd = document.forms.formpe33.h_trd.value;

window.open('../majetok/invdar.php?h_trd=' + h_trd + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function InvMaj()
                {
var h_trd = document.forms.formp2.h_trd.value;

window.open('../majetok/invmaj.php?h_trd=' + h_trd + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function InvDim()
                {
var h_trd = document.forms.formp3.h_trd.value;

window.open('../majetok/invdim.php?h_trd=' + h_trd + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

  function tlacmaj()
  { 
  var okno = window.open("../majetok/tlac_maj.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $tlcswin; ?>');
  }


//uprav komisiu

  function zobraz_upravmail()
  { 
    var toprobotmenu2 = 200;
    var leftrobotmenu2 = 400;
    var widthrobotmenu2 = 600;

    var htmlmenu2 = "<table  class='ponuka' width='100%'><tr><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td>" +
    "<td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td></tr>";  


    htmlmenu2 += "<tr><td colspan='8'>";
    htmlmenu2 += "<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='zhasni_upravmail();' alt='Zhasni menu' > "; 
    htmlmenu2 += "Nastavenie inventúry ";

    htmlmenu2 += " </td>";

    htmlmenu2 += "<td colspan='2' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='zhasni_upravmail();' alt='Zhasni menu' ></td></tr>";  

    htmlmenu2 += "<tr><FORM name='fkoef2' method='post' action='#' ><td class='ponuka' colspan='2'>";
htmlmenu2 += "Vykonaná dòa ";
    htmlmenu2 += "<td class='ponuka' colspan='8'><input type='text' name='h_mail' id='h_mail' size='10' maxlenght='10' value='<?php echo $h_mail; ?>' >"; 
    htmlmenu2 += "</td></tr>";

    htmlmenu2 += "<tr><td class='ponuka' colspan='2'>";
htmlmenu2 += " Zodpovedný ";
    htmlmenu2 += "<td class='ponuka' colspan='8'><input type='text' name='h_mdov' id='h_mdov' size='30' maxlenght='30' value='<?php echo $h_mdov; ?>' >";

    htmlmenu2 += "<tr><td class='ponuka' colspan='2'>";
htmlmenu2 += " Komisia 1 ";
    htmlmenu2 += "<td class='ponuka' colspan='8'><input type='text' name='h_dovv' id='h_dovv' size='30' maxlenght='30' value='<?php echo $h_dovv; ?>' >"; 

    htmlmenu2 += "</td></tr>";


    htmlmenu2 += "<tr><td class='ponuka' colspan='2'>";
htmlmenu2 += " Komisia 2 ";
    htmlmenu2 += "<td class='ponuka' colspan='8'><input type='text' name='h_dovv2' id='h_dovv2' size='30' maxlenght='30' value='<?php echo $h_dovv2; ?>' >"; 

    htmlmenu2 += "</td></tr>";


    htmlmenu2 += "<tr><td class='ponuka' colspan='2'>";
htmlmenu2 += " Komisia 3 ";
    htmlmenu2 += "<td class='ponuka' colspan='8'><input type='text' name='h_dovv3' id='h_dovv3' size='30' maxlenght='30' value='<?php echo $h_dovv3; ?>' >"; 

    htmlmenu2 += "</td></tr>";



    htmlmenu2 += "<tr><td colspan='10'>";

    htmlmenu2 += " <img border=0 src='../obr/ok.png' style='width:15; height:15;' onClick='uloz_upravmail();' alt='Uloži nastavenie' >";  


    htmlmenu2 += "</td></tr>";


    htmlmenu2 += "<tr><td></td></FORM></tr></table>"; 


  myRobotmenu2 = document.getElementById("robotmenu2");
  myRobotmenu2.style.top = toprobotmenu2;
  myRobotmenu2.style.left = leftrobotmenu2;
  myRobotmenu2.style.width = widthrobotmenu2;
  myRobotmenu2.innerHTML = htmlmenu2;
  robotmenu2.style.display='';

  }

  function zhasni_upravmail()
  { 
  robotmenu2.style.display='none';
  }

  function uloz_upravmail()
  { 
  robotmenu2.style.display='none';

  var h_mail = document.forms.fkoef2.h_mail.value;
  var h_dovv = document.forms.fkoef2.h_dovv.value;
  var h_dovv2 = document.forms.fkoef2.h_dovv2.value;
  var h_dovv3 = document.forms.fkoef2.h_dovv3.value;
  var h_mdov = document.forms.fkoef2.h_mdov.value;

  window.open('invmaj.php?cislo_oc=1&h_mail=' + h_mail + '&h_dovv=' + h_dovv + '&h_mdov=' + h_mdov + '&h_dovv2=' + h_dovv2 + '&h_dovv3=' + h_dovv3 + '&copern=1059&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function OdpisPlan()
  { 

  window.open('odpisplan_sku.php?h_trd=0&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }


    
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

//ponuka
if( $copern == 1 )
{

?>

<div id="robotmenu2" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 160; left: 90; width:200; height:100;">
zobrazene menu
</div>

<table class="vstup" width="100%" >
<FORM name="formp2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="InvMaj();">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="38%">Inventúrna zostava dlhodobého majetku 
<td class="bmenu" width="50%">
 triedenie
<select size="1" name="h_trd" id="h_trd" >
<option value="0" >pod¾a inventárneho èísla</option>
<option value="1" >pod¾a druhu majetku</option>
<option value="2" >pod¾a strediska</option>
<option value="3" >pod¾a kódu CPA</option>
<option value="4" >pod¾a strediska a druhu majetku</option>
<option value="5" >pod¾a zákazky</option>
</select>
</td>

<td class="bmenu" width="10%" align="right" >
<img src='../obr/naradie.png'  onClick="zobraz_upravmail();" width=15 height=15 border=0 alt='Nastavi komisiu a dátum inventúry, platí aj pre DIM' >

</td>

</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formp3" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="InvDim();">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="38%">Inventúrna zostava drobného majetku 

<td class="bmenu" width="60%">
 triedenie
<select size="1" name="h_trd" id="h_trd" >
<option value="0" >pod¾a inventárneho èísla</option>
<option value="1" >pod¾a druhu majetku</option>
<option value="2" >pod¾a strediska</option>
</select>



</td>

</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formpe3" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="InvEU();">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="38%">Inventúrna zostava majetku obstaraného zo zdrojov EU a iných cudzích zdrojov

<td class="bmenu" width="60%">
 triedenie
<select size="1" name="h_trd" id="h_trd" >
<option value="0" >pod¾a inventárneho èísla</option>
<option value="1" >pod¾a druhu majetku</option>
<option value="2" >pod¾a strediska</option>
</select>



</td>

</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formpe33" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="InvDar();">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="38%">Inventúrna zostava majetku darovaného a bezplatne nadobudnutého

<td class="bmenu" width="60%">
 triedenie
<select size="1" name="h_trd" id="h_trd" >
<option value="0" >pod¾a inventárneho èísla</option>
<option value="1" >pod¾a druhu majetku</option>
<option value="2" >pod¾a strediska</option>
</select>



</td>

</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formtm3" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="tlacmaj();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 alt='Definovanie a tlaè zostáv vo formáte PDF' ></a>
</td>
<td class="bmenu" width="38%">Preddefinované zostavy z majetku

<td class="bmenu" width="60%"> </td>

</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formneu1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="InvZar();">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="38%">Zostava zaradeného majetku a stavu odpisov v roku zaradenia

<td class="bmenu" width="60%">

</td>

</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formodp1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="OdpisPlan();">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="38%">Odpisový plán majetku pod¾a odpisových skupín

<td class="bmenu" width="60%">

</td>

</tr>
</FORM>
</table>

<?php
//koniec ponuka
}

?>




<?php
// celkovy koniec dokumentu

if( $copern == 1 ) { $cislista = include("maj_lista.php"); }
       } while (false);
?>
</BODY>
</HTML>
