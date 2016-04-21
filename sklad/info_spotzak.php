<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 2000;

$zana = 1*$_REQUEST['zana'];
if( $zana == 1 ) $sys="ANA";

$clsm = 960;
$cslm=403202;
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


if( $agrostav == 1 AND $kli_vxcf == 109 ) { $kli_vxcf=2; }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Spotreba na zakazkach PDF</title>
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
<td>EuroSecom  -  Spotreba na vybranú zákazku za vybrané obdobie 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/spotzak$kli_uzid.pdf")) { $soubor = unlink("../tmp/spotzak$kli_uzid.pdf"); }

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
   dok         INT,
   poh         DECIMAL(10,0),
   str         DECIMAL(10,0),
   ico         DECIMAL(10,0),
   fak         DECIMAL(10,0),
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

     }
//koniec copern 10,20

////////////////////////////////////////////////////////datum pociatku a konca vzdaja


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

$h_obdp = 1*$_REQUEST['h_obdp'];
$h_obdk = 1*$_REQUEST['h_obdk'];


$h_obdpume=$h_obdp.".".$kli_vrok;
$pole = explode(".", $h_obdpume);
$mesp_dph=$pole[0];
$rokp_dph=$pole[1];

$datp_dph=$rokp_dph.'-'.$mesp_dph.'-01';

//echo $h_obdp;
//echo $h_obdp;

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

////////////////////////////////////////////////////////koniec datum pociatku a konca vzdaja

$vsetky=0;
$cislo_zak = 1*$_REQUEST['cislo_zak'];
if( $cislo_zak == 999999999999 ) { $vsetky=1; }

if ( $copern == 10 AND ( $drupoh == 1 OR $drupoh == 3 ) )
    {

$cislo_zak = 1*$_REQUEST['cislo_zak'];
$podmzak=" zak = ".$cislo_zak;
if( $cislo_zak == 999999999999 ) $podmzak=" zak >= 0 ";


//faktury 
//sklfak cpl  ume  dat  dok  doq  skl  poh  ico  fak  unk  dol  prf  poz  str  zak  cis  nat  dph  mer  pop  mno  cen  cep  ced  id  sk2  datm  me2  mn2 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 0,ume,dat,skl,dok,poh,str,zak,dok,cis,mno,cen,(mno),'0','0','0',0 FROM F$kli_vxcf"."_sklfak WHERE cis > 0 ".
" AND dat >= '$datp_dph' AND dat <= '$datk_dph' AND $podmzak ".
" ORDER BY skl,cis,cen".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

//vydaj 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 0,ume,dat,skl,dok,poh,str,zak,fak,cis,mno,cen,(mno),'0','0','0',0 FROM F$kli_vxcf"."_sklvyd WHERE cis > 0 ".
" AND dat >= '$datp_dph' AND dat <= '$datk_dph' AND $podmzak ".
" ORDER BY skl,cis,cen".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;


//vypocitaj hodnotu
$sqlt = "UPDATE F".$kli_vxcf."_sklprcd".$kli_uzid." SET hod=zas*cen";
//echo $sqlt;
$vysledok = mysql_query("$sqlt");

//sumy
if ( $drupoh == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 9,ume,dat,skl,dok,poh,str,ico,fak,cis,SUM(mno),cen,SUM(zas),SUM(hod),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprcd$kli_uzid ".
" GROUP BY cis".
"";
$dsql = mysql_query("$dsqlt");
}

if ( $drupoh == 3 )
{
$sqlt = "UPDATE F".$kli_vxcf."_sklprcd".$kli_uzid." SET mno=-mno, zas=-zas, hod=-hod, vdj=-vdj, prj=-prj, pcs=-pcs ";
//echo $sqlt;
$vysledok = mysql_query("$sqlt");
}

if ( $drupoh == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 10,ume,dat,99999999,dok,poh,str,ico,fak,999999999999999,SUM(mno),cen,SUM(zas),SUM(hod),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprcd$kli_uzid ".
" WHERE pox = 9 GROUP BY pox ".
"";
$dsql = mysql_query("$dsqlt");
}

     }
//koniec copern=10 a vydaj

if ( $copern == 10 AND ( $drupoh == 2 OR $drupoh == 3 ) )
    {

$cislo_zak = 1*$_REQUEST['cislo_zak'];
$podmzak=" zak = ".$cislo_zak;
if( $cislo_zak == 999999999999 ) $podmzak=" zak >= 0 ";

//prijem 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 0,ume,dat,skl,dok,poh,str,zak,fak,cis,mno,cen,(mno),'0','0','0',0 FROM F$kli_vxcf"."_sklpri WHERE cis > 0 ".
" AND dat >= '$datp_dph' AND dat <= '$datk_dph' AND $podmzak ".
" ORDER BY skl,cis,cen".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

//vypocitaj hodnotu
$sqlt = "UPDATE F".$kli_vxcf."_sklprcd".$kli_uzid." SET hod=zas*cen";
//echo $sqlt;
$vysledok = mysql_query("$sqlt");

//sumy

if ( $drupoh == 2 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 9,ume,dat,skl,dok,poh,str,ico,fak,cis,SUM(mno),cen,SUM(zas),SUM(hod),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprcd$kli_uzid ".
" GROUP BY cis".
"";
$dsql = mysql_query("$dsqlt");
}

//sumy

if ( $drupoh == 3 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 8,ume,dat,skl,0,poh,str,ico,0,cis,SUM(mno),cen,SUM(zas),SUM(hod),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprcd$kli_uzid ".
" GROUP BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
}

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 10,ume,dat,99999999,dok,poh,str,ico,fak,999999999999999,SUM(mno),cen,SUM(zas),SUM(hod),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprcd$kli_uzid ".
" WHERE ( pox = 8 OR pox = 9 )  GROUP BY pox ".
"";
$dsql = mysql_query("$dsqlt");


     }
//koniec copern=10 a prijem

$neparne=1;

//exit;

if ( $copern == 10 )
  {

if ( $drupoh == 2 OR $drupoh == 1 )
  {
$sqltt = "SELECT * FROM F$kli_vxcf"."_sklprcd$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.skl=F$kli_vxcf"."_skl.skl".
" LEFT JOIN F$kli_vxcf"."_zak".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.ico=F$kli_vxcf"."_zak.zak AND F$kli_vxcf"."_sklprcd$kli_uzid.str=F$kli_vxcf"."_zak.str".
" WHERE hod != 0".
" ORDER BY F$kli_vxcf"."_sklprcd$kli_uzid.cis,pox,F$kli_vxcf"."_sklprcd$kli_uzid.dok";
  }

if ( $drupoh == 3 )
  {
$sqltt = "SELECT * FROM F$kli_vxcf"."_sklprcd$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.skl=F$kli_vxcf"."_skl.skl".
" LEFT JOIN F$kli_vxcf"."_zak".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.ico=F$kli_vxcf"."_zak.zak AND F$kli_vxcf"."_sklprcd$kli_uzid.str=F$kli_vxcf"."_zak.str".
" WHERE hod != 0 AND ( pox = 8 OR pox = 10 ) ".
" ORDER BY F$kli_vxcf"."_sklprcd$kli_uzid.cis,pox,F$kli_vxcf"."_sklprcd$kli_uzid.dok";
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
if ( $copern == 10 AND $drupoh == 1 )  { $pdf->Cell(90,6,"Výdaj na zákazku za obdobie $h_obdpume / $h_obdkume","LTB",0,"L"); }
if ( $copern == 10 AND $drupoh == 2 )  { $pdf->Cell(90,6,"Príjem na zákazku za obdobie $h_obdpume / $h_obdkume","LTB",0,"L"); }
if ( $copern == 10 AND $drupoh == 3 )  { $pdf->Cell(90,6,"Zostatok na zákazke za obdobie $h_obdpume / $h_obdkume","LTB",0,"L"); }

$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

if( $vsetky == 0 ) { $pdf->Cell(0,6,"Zákazka $riadok->ico $riadok->nza","0",1,"L"); }
if( $vsetky == 1 ) { $pdf->Cell(0,6,"Všetky zákazky","0",1,"L"); }

$pdf->SetFont('arial','',6);

if ( $drupoh == 1 )
  {
$pdf->Cell(15,5,"Doklad","1",0,"R");$pdf->Cell(20,5,"SKL","1",0,"R");$pdf->Cell(10,5,"POH","1",0,"R");$pdf->Cell(70,5,"Materiál","1",0,"L");
$pdf->Cell(20,5,"Cena za MJ","1",0,"R");$pdf->Cell(10,5,"MJ","1",0,"L");
$pdf->Cell(20,5,"Výdaj MJ","1",0,"R");$pdf->Cell(0,5,"Hodnota","1",1,"R");
  }
if ( $drupoh == 2 )
  {
$pdf->Cell(15,5,"Doklad","1",0,"R");$pdf->Cell(20,5,"SKL","1",0,"R");$pdf->Cell(10,5,"POH","1",0,"R");$pdf->Cell(70,5,"Materiál","1",0,"L");
$pdf->Cell(20,5,"Cena za MJ","1",0,"R");$pdf->Cell(10,5,"MJ","1",0,"L");
$pdf->Cell(20,5,"Príjem MJ","1",0,"R");$pdf->Cell(0,5,"Hodnota","1",1,"R");
  }
if ( $drupoh == 3 )
  {
$pdf->Cell(20,5,"SKL","1",0,"R");$pdf->Cell(95,5,"Materiál","1",0,"L");
$pdf->Cell(20,5,"Cena za MJ","1",0,"R");$pdf->Cell(10,5,"MJ","1",0,"L");
$pdf->Cell(20,5,"Zostatok MJ","1",0,"R");$pdf->Cell(0,5,"Hodnota","1",1,"R");
  }

     }
//koniec hlavicky j=0


if( $riadok->pox == 0 )
{

$pdf->SetFont('arial','',7);

if( $sZostatok == '0' ) $sZostatok="";

$pdf->Cell(15,5,"$riadok->dok","0",0,"R");$pdf->Cell(20,5,"$riadok->skl","0",0,"R");$pdf->Cell(10,5,"$riadok->poh","0",0,"R");
$pdf->Cell(70,5,"$riadok->cis $riadok->nat","0",0,"L");
$pdf->Cell(20,5,"$riadok->cen","0",0,"R");$pdf->Cell(10,5,"$riadok->mer","0",0,"L");
$pdf->Cell(20,5,"$riadok->mno","0",0,"R");$pdf->Cell(0,5,"$riadok->hod","0",1,"R");

}


if( $riadok->pox == 8 )
{

$pdf->SetFont('arial','',7);

if( $sZostatok == '0' ) $sZostatok="";

$pdf->Cell(20,5,"$riadok->skl","0",0,"R");$pdf->Cell(95,5,"$riadok->cis $riadok->nat","0",0,"L");
$pdf->Cell(20,5,"$riadok->cen","0",0,"R");$pdf->Cell(10,5,"$riadok->mer","0",0,"L");
$pdf->Cell(20,5,"$riadok->mno","0",0,"R");$pdf->Cell(0,5,"$riadok->hod","0",1,"R");

}


if( $riadok->pox == 9 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(145,5,"CELKOM materiál $riadok->cis ","T",0,"L");
$pdf->Cell(20,5,"$riadok->mno","T",0,"R");$pdf->Cell(0,5,"$riadok->hod","T",1,"R");
$pdf->Cell(0,5," ","T",1,"R");
$j = $j + 1;
}

if( $riadok->pox == 10 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(145,5,"CELKOM všetko ","1",0,"L");
$pdf->Cell(0,5,"$riadok->hod","1",1,"R");
$j=-1;
}


}
$i = $i + 1;
$j = $j + 1;
if( $j > 46 ) $j=0;

  }

     }
//koniec copern=10

$pdf->Output("../tmp/spotzak.$kli_uzid.pdf");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/spotzak.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
