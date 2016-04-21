<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 2000;
$clsm = 920;
$cslm=402102;
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

//copern=10 mesacna zostava pohybov
//copern=20 zostava pohybov z informacii


if ( $copern == 10 OR $copern == 20 )
    {

//urob pracovnu sklprc zjednotenie pri,vyd,pre,poc

if ( $copern == 10 ) $podm_poc = "ume < ".$kli_vume;
if ( $copern == 10 ) $podm_obd = "ume = ".$kli_vume;
if ( $copern == 20 ) $podm_poc = "ume < 1.".$kli_vrok;
if ( $copern == 20 ) $podm_obd = "ume >= 1.".$kli_vrok." AND ume <= 12.".$kli_vrok;

//echo 'pociatok'.$podm_poc;
//echo 'obdobie'.$podm_obd;

//urob pracovnu sklprc zjednotenie pri,vyd,pre,poc

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc2';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<sklprc
(
   pox         INT,
   pox1        INT,
   ume         FLOAT(8,4),
   dat         DATE,
   skl         INT,
   poh         INT,
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


//poc.stav
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,ume,dat,skl,poh,cis,mno,cen,(mno*cen),'0','0','0','0',(mno*cen) FROM F$kli_vxcf"."_sklpoc WHERE NOT ( cis = 0 )".
" ORDER BY skl,poh,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//prijem minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,ume,dat,skl,poh,cis,mno,cen,(mno*cen),'0','0','0','0',(mno*cen) FROM F$kli_vxcf"."_sklpri WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,poh,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//vydaj minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,ume,dat,skl,poh,cis,mno,cen,-(mno*cen),'0','0','0','0',-(mno*cen) FROM F$kli_vxcf"."_sklvyd WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,poh,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//faktury minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,ume,dat,skl,poh,cis,mno,cen,-(mno*cen),'0','0','0','0',-(mno*cen) FROM F$kli_vxcf"."_sklfak WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,poh,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//presun- minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,ume,dat,skl,poh,cis,mno,cen,-(mno*cen),'0','0','0','0',-(mno*cen) FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,poh,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//presun+ minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,ume,dat,sk2,poh,cis,mno,cen,(mno*cen),'0','0','0','0',(mno*cen) FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,poh,cis,cen".
"";
//echo $dsqlt."<br />";
$dsql = mysql_query("$dsqlt");

//nastav vsetko ako poc stav.
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc SET poh=1 ";
$dsql = mysql_query("$dsqlt");

//prijem mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,ume,dat,skl,poh,cis,mno,cen,(mno*cen),'0','0','0',(mno*cen),'0' FROM F$kli_vxcf"."_sklpri WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,poh,cis,cen".
"";
//echo $dsqlt."<br />";
$dsql = mysql_query("$dsqlt");
//exit;

//vydaj mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,ume,dat,skl,poh,cis,mno,cen,-(mno*cen),'0','0',-(mno*cen),'0','0' FROM F$kli_vxcf"."_sklvyd WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,poh,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//faktury mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,ume,dat,skl,poh,cis,mno,cen,-(mno*cen),'0',-(mno*cen),'0','0','0' FROM F$kli_vxcf"."_sklfak WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,poh,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//presun- mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,ume,dat,skl,poh,cis,mno,cen,-(mno*cen),-(mno*cen),'0','0','0','0' FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,poh,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//presun+ mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,ume,dat,sk2,poh,cis,mno,cen,(mno*cen),(mno*cen),'0','0','0','0' FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,poh,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//group za skl,poh
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2".
" SELECT 0,0,ume,dat,skl,poh,cis,mno,cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprc ".
" GROUP BY skl,poh".
"";
$dsql = mysql_query("$dsqlt");

//group za druh pohybu 1-4=prijem,5=presum+ , >=6 vydaj
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2,F$kli_vxcf"."_sklcph ".
" SET pox1=drp ".
" WHERE F$kli_vxcf"."_sklprc2.poh=F$kli_vxcf"."_sklcph.poh ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 SET pox1=1 WHERE pox1 <= 5 AND poh > 1 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 SET pox1=6 WHERE pox1 >= 6 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2".
" SELECT 0,pox1,ume,dat,skl,999999,cis,mno,cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprc2 ".
" GROUP BY skl,pox1".
"";
$dsql = mysql_query("$dsqlt");

//group za skl
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2".
" SELECT 10,0,ume,dat,skl,poh,cis,mno,cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprc ".
" GROUP BY skl".
"";
$dsql = mysql_query("$dsqlt");

//group za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2".
" SELECT 20,0,ume,dat,99999999,poh,cis,mno,cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprc ".
" GROUP BY pox".
"";
$dsql = mysql_query("$dsqlt");

//zmaz pracovnu sklprc
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc';
$vysledok = mysql_query("$sqlt");

//uloz stav na skladoch pre prepocitavanie pri priemernych cenach v zas je hodnota skladu skl v Eur

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklstvskl'.$kli_uzid.' ';
$vysledok = mysql_query("$sqlt");

$vsql = "CREATE TABLE F".$kli_vxcf."_sklstvskl".$kli_uzid." SELECT * FROM F$kli_vxcf"."_sklprc2 WHERE pox = 10 ";
$vytvor = mysql_query("$vsql");

$sql = "ALTER TABLE F$kli_vxcf"."_sklstvskl".$kli_uzid." ADD datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER pcs ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_sklstvskl".$kli_uzid." SET datm=now() ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_sklstvskl".$kli_uzid." ADD datt timestamp AFTER datm ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklstvskl".$kli_uzid." ADD rozd DECIMAL(10,0) DEFAULT 0 AFTER datt ";
$vysledek = mysql_query("$sql");

    }


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Zostava pohybov PDF</title>
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
<td>EuroSecom  -  Zostava pohybov 

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
$sqltt = "SELECT F$kli_vxcf"."_sklprc2.skl, F$kli_vxcf"."_sklprc2.poh, F$kli_vxcf"."_sklprc2.zas, F$kli_vxcf"."_sklprc2.pox,  ".
" F$kli_vxcf"."_sklprc2.pox1, F$kli_vxcf"."_sklcph.nph, F$kli_vxcf"."_skl.nas ".
" FROM F$kli_vxcf"."_sklprc2".
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklprc2.skl=F$kli_vxcf"."_skl.skl".
" LEFT JOIN F$kli_vxcf"."_sklcph".
" ON F$kli_vxcf"."_sklprc2.poh=F$kli_vxcf"."_sklcph.poh".
" ORDER by F$kli_vxcf"."_sklprc2.skl,pox,pox1,F$kli_vxcf"."_sklprc2.poh".
"";
  }


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


$dnesoktime = Date ("d.m.Y H:i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
if ( $copern == 10 )  { $pdf->Cell(90,6,"Zostava pohybov za $kli_vume ","LTB",0,"L"); }
if ( $copern == 20 )  { $pdf->Cell(90,6,"Zostava pohybov za $kli_vrok ","LTB",0,"L"); }



$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);

//Sklad Pohyb Nazov pohybu  Suma  

$pdf->Cell(30,5,"SKL","1",0,"R");$pdf->Cell(30,5,"Pohyb","1",0,"R");$pdf->Cell(90,5,"Popis pohybu ","1",0,"L");
$pdf->Cell(0,5,"Hodnota","1",1,"R");

     }
//koniec hlavicky j=0



$datsk=SkDatum($riadok->dat);



if( $riadok->pox == 0 AND $riadok->poh != 999999 )
{

$pdf->SetFont('arial','',8);

if( $sZostatok == '0' ) $sZostatok="";
$nazpoh=$riadok->nph;
$cpoh=1*$riadok->poh;
if( $riadok->poh <= 1 ) $nazpoh="Poèiatoèný stav";

$pdf->Cell(30,5,"$riadok->skl","0",0,"R");$pdf->Cell(30,5,"$riadok->poh","0",0,"R");$pdf->Cell(90,5,"$nazpoh","0",0,"L");
$pdf->Cell(0,5,"$riadok->zas","0",1,"R");

}

if( $riadok->pox == 0 AND $riadok->poh == 999999 AND $riadok->pox1 == 1 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(60,5," ","0",0,"R");
$pdf->Cell(90,5,"CELKOM príjem","T",0,"R");
$pdf->Cell(0,5,"$riadok->zas","T",1,"R");

}

if( $riadok->pox == 0 AND $riadok->poh == 999999 AND $riadok->pox1 == 6 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(60,5," ","0",0,"R");
$pdf->Cell(90,5,"CELKOM výdaj","T",0,"R");
$pdf->Cell(0,5,"$riadok->zas","T",1,"R");

}


if( $riadok->pox == 10 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(150,5,"CELKOM sklad $riadok->skl -  $riadok->nas","T",0,"L");
$pdf->Cell(0,5,"$riadok->zas","T",1,"R");

$pdf->Cell(0,5," ","0",1,"R");
$j=$j+1;
}


if( $riadok->pox == 20 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(150,5,"CELKOM všetky sklady $dnesoktime","LTB",0,"L");
$pdf->Cell(0,5,"$riadok->zas","RTB",1,"R");
}

}
$i = $i + 1;
$j = $j + 1;
if( $j > 48 ) $j=0;

  }


$pdf->Output("../tmp/podklad.$kli_uzid.pdf");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc2';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc';
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
