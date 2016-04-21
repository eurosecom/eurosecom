<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 2000;
$clsm = 920;
$cslm=402105;
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

//copern=10 mesacna zostava
//copern=20 zostava vydaja z informacii


if ( $copern == 10 OR $copern == 20 )
    {

//urob pracovnu sklprc zjednotenie pri,vyd,pre,poc

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc2';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<sklprc
(
   pox         INT,
   ume         FLOAT(8,4),
   dat         DATE,
   skl         INT,
   dok         INT,
   poh         INT,
   ico         INT,
   fak         INT,
   str         INT,
   zak         INT,
   cis         DECIMAL(15,0),
   mno         DECIMAL(10,3),
   cen         DECIMAL(10,4),
   zas         DECIMAL(10,2),
   prs         DECIMAL(10,2),
   pdj         DECIMAL(10,2),
   vdj         DECIMAL(10,2),
   prj         DECIMAL(10,2),
   pcs         DECIMAL(10,2)
);
sklprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc'.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc2'.$sqlt;
$vytvor = mysql_query("$vsql");

if ( $copern == 20 )
    {
//prijem minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,ume,dat,skl,dok,poh,ico,fak,str,zak,cis,mno,cen,(mno*cen),'0','0',(mno*cen),'0','0' FROM F$kli_vxcf"."_sklvyd WHERE ( cis > 0 AND ume < $vyb_ume )".
" ORDER BY skl,dok".
"";
$dsql = mysql_query("$dsqlt");
    }

//prijem mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,ume,dat,skl,dok,poh,ico,fak,str,zak,cis,mno,cen,(mno*cen),'0','0',(mno*cen),'0','0' FROM F$kli_vxcf"."_sklvyd WHERE ( cis > 0 AND ume = $vyb_ume )".
" ORDER BY skl,dok".
"";
$dsql = mysql_query("$dsqlt");


//group za skl,dok,cen
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2".
" SELECT 0,ume,dat,skl,dok,poh,ico,fak,str,zak,cis,mno,cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprc ".
" GROUP BY skl,dok".
"";

$dsql = mysql_query("$dsqlt");

//group za skl
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2".
" SELECT 10,ume,dat,skl,dok,poh,ico,fak,str,zak,cis,mno,cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprc ".
" GROUP BY skl".
"";

$dsql = mysql_query("$dsqlt");

//group za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2".
" SELECT 20,ume,dat,99999999,dok,poh,ico,fak,str,zak,cis,mno,cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprc ".
" GROUP BY pox".
"";

$dsql = mysql_query("$dsqlt");

//zmaz pracovnu sklprc
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc';
$vysledok = mysql_query("$sqlt");
    }


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Zostava výdaja PDF</title>
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
<td>EuroSecom  -  Zostava výdaja 

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



$neparne=1;

if ( $copern == 20 OR $copern == 10 )
  {
$sqltt = "SELECT * FROM F$kli_vxcf"."_sklprc2".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_sklprc2.ico=F$kli_vxcf"."_ico.ico".
" WHERE pox >= 0 ".
" ORDER BY skl,pox,dok ";
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
if ( $copern == 10 )  { $pdf->Cell(90,6,"Zostava výdaja za $kli_vume ","LTB",0,"L"); }

$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);

//Sklad Doklad Dátum  IÈO Odberate¾ - STR - ZÁK POH Faktúra  Suma  

$pdf->Cell(10,5,"SKL","1",0,"R");$pdf->Cell(20,5,"Doklad","1",0,"R");$pdf->Cell(20,5,"Dátum","1",0,"L");

$pdf->Cell(60,5,"Odberate¾","1",0,"L");
$pdf->Cell(10,5,"STR","1",0,"R");$pdf->Cell(20,5,"ZÁK","1",0,"R");$pdf->Cell(10,5,"POH","1",0,"R");
$pdf->Cell(16,5,"Faktúra","1",0,"R");$pdf->Cell(0,5,"Hodnota","1",1,"R");

     }
//koniec hlavicky j=0



$datsk=SkDatum($riadok->dat);



if( $riadok->pox == 0 )
{

$pdf->SetFont('arial','',8);

if( $sZostatok == '0' ) $sZostatok="";

$pdf->Cell(10,5,"$riadok->skl","0",0,"R");$pdf->Cell(20,5,"$riadok->dok","0",0,"R");$pdf->Cell(20,5,"$datsk","0",0,"L");
$pdf->Cell(60,5,"$riadok->ico $riadok->nai","0",0,"L");
$pdf->Cell(10,5,"$riadok->str","0",0,"R");$pdf->Cell(20,5,"$riadok->zak","0",0,"R");$pdf->Cell(10,5,"$riadok->poh","0",0,"R");
$pdf->Cell(16,5,"$riadok->fak","0",0,"R");$pdf->Cell(0,5,"$riadok->vdj","0",1,"R");

}

if( $riadok->pox == 10 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(170,5,"CELKOM sklad $riadok->skl","LTB",0,"L");
$pdf->Cell(0,5,"$riadok->vdj","RTB",1,"R");

$pdf->Cell(0,5," ","0",1,"R");
$j=$j+1;
}


if( $riadok->pox == 20 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(170,5,"CELKOM všetky sklady ","LTB",0,"L");
$pdf->Cell(0,5,"$riadok->vdj","RTB",1,"R");
}

}
$i = $i + 1;
$j = $j + 1;
if( $j > 48 ) $j=0;

  }


$pdf->Output("../tmp/podklad.$kli_uzid.pdf");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc2';
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
