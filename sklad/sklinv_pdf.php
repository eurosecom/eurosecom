<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 2000;
$clsm = 920;
$cslm=403300;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

$cislo_skl = 1*$_REQUEST['cislo_skl'];



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
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Inventúra skladov PDF</title>
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
<td>EuroSecom  -  Inventúra skladov PDF 

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
   ume         FLOAT(8,4),
   dat         DATE,
   skl         INT,
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


//poc.stav
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,ume,dat,skl,cis,mno,cen,(mno),'0','0','0',0 FROM F$kli_vxcf"."_sklpoc WHERE NOT ( cis = 0 )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//prijem 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,ume,dat,skl,cis,mno,cen,(mno),'0','0','0',0 FROM F$kli_vxcf"."_sklpri WHERE ( cis > 0 AND ume <= $kli_vume )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//vydaj 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,ume,dat,skl,cis,mno,cen,-(mno),'0','0','0',0 FROM F$kli_vxcf"."_sklvyd WHERE ( cis > 0 AND ume <= $kli_vume )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//faktury 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,ume,dat,skl,cis,mno,cen,-(mno),'0','0','0',0 FROM F$kli_vxcf"."_sklfak WHERE ( cis > 0 AND ume <= $kli_vume )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//presun- 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,ume,dat,skl,cis,mno,cen,-(mno),'0','0','0',0 FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND ume <= $kli_vume )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//presun+ 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,ume,dat,sk2,cis,mno,cen,(mno),'0','0','0',0 FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND ume <= $kli_vume )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");




//ak okamzity stav zober rovno z sklzas
if( $copern == 10 )
{
$sqlt = "DELETE FROM F".$kli_vxcf."_sklprc".$kli_uzid." WHERE pox = 0";
$vysledok = mysql_query("$sqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,'0000-00-00',skl,cis,zas,cen,(zas),'0','0',(zas),'0' FROM F$kli_vxcf"."_sklzas WHERE ( cis > 0 )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

}


//group za skl,cis,cen
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 0,ume,dat,skl,cis,mno,cen,SUM(zas),SUM(hod),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprc$kli_uzid ".
" GROUP BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");


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
" SELECT 1,ume,dat,skl,cis,mno,cen,SUM(zas),SUM(hod),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprcd$kli_uzid ".
" GROUP BY skl,cis".
"";
$dsql = mysql_query("$dsqlt");

$sqlt = "DELETE FROM F".$kli_vxcf."_sklprcd".$kli_uzid." WHERE pox = 0";
$vysledok = mysql_query("$sqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid  SET pox=0 "; 
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid  SET cen=hod/zas WHERE zas != 0 "; 
$dsql = mysql_query("$dsqlt");
}
//koniec priemerne ceny


//ulozeny stav na skladoch v mesacnej zostave za pohyby pre prepocitavanie pri priemernych cenach v zas je hodnota skladu skl v Eur
if( $fir_xsk04 == 1 ) 
{ 

$sqltt = "UPDATE F$kli_vxcf"."_sklstvskl$kli_uzid SET rozd=UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(datm), prs=0, pdj=0, vdj=0 ";
$sql = mysql_query("$sqltt");

$pocets=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklstvskl$kli_uzid ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $pocets=1*$riaddok->rozd;
  }

if( $pocets > 0 AND $pocets < 180 )
  {
//echo "Porovnam stav v zostave pohybov a stave zasob ".$pocets;

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklstvsklx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<sklprc
(
   pox         INT,
   skl         INT,
   zax         DECIMAL(10,2)
);
sklprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklstvsklx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklstvsklx$kli_uzid".
" SELECT 0,skl,SUM(hod) FROM F$kli_vxcf"."_sklprcd$kli_uzid ".
" GROUP BY skl ".
"";
$dsql = mysql_query("$dsqlt");

$ulozttt = "UPDATE F$kli_vxcf"."_sklstvskl$kli_uzid,F$kli_vxcf"."_sklstvsklx$kli_uzid ".
" SET F$kli_vxcf"."_sklstvskl$kli_uzid.prs=zax ".
" WHERE F$kli_vxcf"."_sklstvskl$kli_uzid.skl=F$kli_vxcf"."_sklstvsklx$kli_uzid.skl "; 
$ulozene = mysql_query("$ulozttt");

$ulozttt = "UPDATE F$kli_vxcf"."_sklstvskl$kli_uzid SET pdj=zas-prs ";
$ulozene = mysql_query("$ulozttt");

$skluprav=0; $rozd=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklstvskl$kli_uzid ORDER BY skl ");
$sklpol = mysql_num_rows($sqldok);
$iskl=0;
while ($iskl < $sklpol )
{

  if (@$zaznam=mysql_data_seek($sqldok,0))
     {
  $riaddok=mysql_fetch_object($sqldok);
  $skluprav=1*$riaddok->skl;
  $rozd=1*$riaddok->pdj;
  $zas=1*$riaddok->zas;
  $prs=1*$riaddok->prs;

//echo "zas".$zas." prs".$prs;

$sqldok1 = mysql_query("SELECT * FROM F$kli_vxcf"."_sklprcd$kli_uzid WHERE skl = $skluprav ORDER BY cen DESC");
  if (@$zaznam=mysql_data_seek($sqldok1,0))
  {
  $riaddok1=mysql_fetch_object($sqldok1);
  $skl=1*$riaddok1->skl;
  $cis=1*$riaddok1->cis;
  $cen=1*$riaddok1->cen;
$ulozttt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid SET cen=cen+($rozd/mno), hod=hod+($rozd)  WHERE skl = $skl AND cen = $cen AND cis = $cis ";
//echo $ulozttt;
//exit;
$ulozene = mysql_query("$ulozttt");
  }

     }
$iskl = $iskl + 1;

}


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklstvsklx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//exit;
  }
}
//koniec if( $fir_xsk04 == 1 ) 


//sumy

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 9,ume,dat,skl,cis,mno,cen,SUM(zas),SUM(hod),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprcd$kli_uzid ".
" GROUP BY skl".
"";
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 10,ume,dat,99999999,cis,mno,cen,SUM(zas),SUM(hod),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprcd$kli_uzid ".
" WHERE pox = 9 GROUP BY pox ".
"";
$dsql = mysql_query("$dsqlt");



$neparne=1;

if ( $copern == 20 OR $copern == 10 )
  {
$sqltt = "SELECT * FROM F$kli_vxcf"."_sklprcd$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.skl=F$kli_vxcf"."_skl.skl".
" WHERE hod != 0".
" ORDER BY F$kli_vxcf"."_sklprcd$kli_uzid.skl,pox,F$kli_vxcf"."_sklprcd$kli_uzid.cis,F$kli_vxcf"."_sklprcd$kli_uzid.cen";
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
if ( $copern == 10 )  { $pdf->Cell(90,6,"Inventúrna zostava $kli_vume Sklad $riadok->skl $riadok->nas","LTB",0,"L"); }
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);


$pdf->Cell(10,5,"SKL","1",0,"R");$pdf->Cell(20,5,"MAT","1",0,"R");$pdf->Cell(75,5,"Názov","1",0,"L");
$pdf->Cell(18,5,"Cena za MJ","1",0,"R");$pdf->Cell(8,5,"MJ","1",0,"L");
$pdf->Cell(20,5,"Zásoba MJ","1",0,"R");$pdf->Cell(20,5,"Hodnota","1",0,"R");$pdf->Cell(0,5,"Skutoènos","1",1,"R");

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

$pocstav = $riadok->pcs;
$Cislo=$pocstav+"";
$sPocstav=sprintf("%0.2f", $Cislo);





if( $riadok->pox == 0 )
{

$pdf->SetFont('arial','',8);

if( $sZostatok == '0' ) $sZostatok="";

$pdf->Cell(10,5,"$riadok->skl","0",0,"R");$pdf->Cell(20,5,"$riadok->cis","0",0,"R");$pdf->Cell(75,5,"$riadok->nat","0",0,"L");
$pdf->Cell(18,5,"$riadok->cen","0",0,"R");$pdf->Cell(8,5,"$riadok->mer","0",0,"L");
$pdf->Cell(20,5,"$riadok->zas","0",0,"R");$pdf->Cell(20,5,"$riadok->hod","0",0,"R");$pdf->Cell(0,5," ","B",1,"R");

}


if( $riadok->pox == 9 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(151,5,"CELKOM Sklad $riadok->skl $riadok->nas","LTB",0,"L");
$pdf->Cell(20,5,"$riadok->hod","RTB",0,"R");$pdf->Cell(0,5," ","RTB",1,"R");

$pdf->Cell(0,10," ","0",1,"R");


$pdf->Cell(70,6,"Inventúra vykonaná dòa:","1",1,"L");
$pdf->Cell(0,2," ","0",1,"R");
$pdf->Cell(70,6,"Zodpovedný pracovník:","1",1,"L");
$pdf->Cell(0,2," ","0",1,"R");
$pdf->Cell(40,6,"Èlenovia komisie:","1",0,"L");$pdf->Cell(30,6," ","1",0,"L");$pdf->Cell(30,6," ","1",0,"L");$pdf->Cell(30,6," ","1",1,"L");



$j=-1;
}

if( $riadok->pox == 10 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(151,5,"CELKOM všetky sklady ","LTB",0,"L");
$pdf->Cell(20,5,"$riadok->hod","RTB",0,"R");$pdf->Cell(0,5," ","RTB",1,"R");
$j=-1;
}

}
$i = $i + 1;
$j = $j + 1;
if( $j > 48 ) $j=0;

  }


$pdf->Output("../tmp/podklad.$kli_uzid.pdf");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

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
