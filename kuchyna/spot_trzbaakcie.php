<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'VYR';
$urov = 1000;
$clsm = 820;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$stravny = 1*$_REQUEST['stravny'];

$cislo_dok = 1*$_REQUEST['cislo_dok'];
$pds = 1*$_REQUEST['pds'];
//pds=1 za dni,2 za akcie,3 za jedla
$finlim = 1*$_REQUEST['finlim'];

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
$citkuch = include("citaj_kuch.php");

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

//pristup podla prihlasenia
if( $fir_xku01 == 1 )
     {
//echo "idem";

$nemapristup=0;
if( $kuch_xpozobj != 1 ) { $nemapristup=1; }

//takto zakazem pristup
if( $nemapristup == 1 )
{
$zakazkuch=1;
$citkuch = include("../kuchyna/citaj_kuch.php");
exit;
}

     }
//koniec pristup podla prihlasenia

//Tabulka kuchprc
$sql = "DROP TABLE F$kli_vxcf"."_kuchprc".$kli_uzid;
$vysledok = mysql_query("$sql");



$sqlt = <<<kuchdodh
(
   dok         int not null,
   dat         DATE,
   dmxb        DECIMAL(10,0) DEFAULT 0,
   druhp       DECIMAL(10,0) DEFAULT 0,
   spot        DECIMAL(10,2) DEFAULT 0,
   pjed        DECIMAL(10,0) DEFAULT 0,
   doda        DECIMAL(10,4) DEFAULT 0,
   fakt        DECIMAL(10,2) DEFAULT 0,
   zisk        DECIMAL(10,2) DEFAULT 0,
   cjed        DECIMAL(10,2) DEFAULT 0
);
kuchdodh;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_kuchprc'.$kli_uzid.$sqlt;
$vysledek = mysql_query("$sql");


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

$datp_ume="01.".$kli_vume;
$datp_ume=SqlDatum($datp_ume);
$datk_ume=SqlDatum($datp_ume);

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_ume', '$datk_ume', 0 )";
$ttqq = mysql_query("$ttvv");

$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp=SUBDATE('$datp_ume',0),  datk=LAST_DAY(datp)".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_ume=$riadok->datp;
  $datk_ume=$riadok->datk;
  }

$dat11=$kli_vrok."-01-01";

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$podmobdobie=" AND dat >= '$datp_ume' AND dat <= '$datk_ume' ";
$podmobdobieume=" AND dat >= '$datp_ume' AND dat <= '$datk_ume' ";
if( $finlim == 1 )
{
$podmobdobie=" AND dat >= '$dat11' AND dat <= '$datk_ume' ";
$podmobdobieume=" AND dat >= '$datp_ume' AND dat <= '$datk_ume' ";
}
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Spotreba a Tržby PDF</title>
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
<td>EuroSecom  -  
<?php if( $copern == 10 ) { echo "Spotreba a Tržby  PDF "; } ?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/doch$kli_uzid.pdf")) { $soubor = unlink("../tmp/doch$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$neparne=1;


if ( $copern == 10 )
  {

//spotreba
if( $finlim == 1 )
{
$radavydajky=($kli_vxcf*10000);
$dsqlt = "INSERT INTO F$kli_vxcf"."_kuchprc$kli_uzid"." SELECT".
" (dok-$radavydajky),dat,1,0,(mno*cen),0,0,0,0,0 ".
" FROM F$kli_vxcfskl"."_sklvyd".
" WHERE skl = $fir_xkuskv $podmobdobie AND str = $fir_xkustr AND zak = $fir_xkuzak AND cis > 0 AND dok > $radavydajky ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt"); 
//exit;
}
if( $finlim == 0 )
{
$radavydajky=($kli_vxcf*10000);
$dsqlt = "INSERT INTO F$kli_vxcf"."_kuchprc$kli_uzid"." SELECT".
" (dok-$radavydajky),dat,1,0,(mno*cen),0,0,0,0,0 ".
" FROM F$kli_vxcfskl"."_sklvyd".
" WHERE skl = $fir_xkuskv $podmobdobie AND str = $fir_xkustr AND zak = $fir_xkuzak AND cis > 0 ";
$dsql = mysql_query("$dsqlt"); 
}

//echo $dsqlt;
//exit;

//pocet jedal
$dsqlt = "INSERT INTO F$kli_vxcf"."_kuchprc$kli_uzid"." SELECT".
" F$kli_vxcf"."_kuchdodh.kto,dat,2,druhp,0,jmno,0,0,0,0 ".
" FROM F$kli_vxcf"."_kuchdodh,F$kli_vxcf"."_kuchdodp".
" WHERE F$kli_vxcf"."_kuchdodh.dok=F$kli_vxcf"."_kuchdodp.dok $podmobdobie AND druhp >= 11 AND druhp <= 19 ";
$dsql = mysql_query("$dsqlt"); 

//if( $kli_uzid == 17 ) { exit; }


$dsqlt = "INSERT INTO F$kli_vxcf"."_kuchprc$kli_uzid"." SELECT".
" dok,dat,1,0,0,MAX(pjed),0,0,0,0 ".
" FROM F$kli_vxcf"."_kuchprc$kli_uzid ".
" WHERE dmxb = 2 GROUP BY dok,druhp";
$dsql = mysql_query("$dsqlt"); 

$dsqlt = "DELETE FROM F$kli_vxcf"."_kuchprc$kli_uzid WHERE dmxb = 2 ";
$dsql = mysql_query("$dsqlt"); 

if ( $copern == 10 AND $pds == 2 AND $finlim == 0 )  
      { 
//dodane
$dsqlt = "INSERT INTO F$kli_vxcf"."_kuchprc$kli_uzid"." SELECT".
" F$kli_vxcf"."_kuchdodh.kto,dat,1,0,0,0,(jmno*rcep),0,0,0 ".
" FROM F$kli_vxcf"."_kuchdodh,F$kli_vxcf"."_kuchdodp".
" WHERE F$kli_vxcf"."_kuchdodh.dok=F$kli_vxcf"."_kuchdodp.dok $podmobdobie ";
$dsql = mysql_query("$dsqlt"); 
//echo $dsqlt;
//exit;

//fakturovane
$dsqlt = "INSERT INTO F$kli_vxcf"."_kuchprc$kli_uzid"." SELECT".
" F$kli_vxcf"."_dopfak.dok,dat,1,0,0,0,0,(cep*mno),0,0 ".
" FROM F$kli_vxcf"."_dopfak,F$kli_vxcf"."_dopslu".
" WHERE F$kli_vxcf"."_dopfak.dok=F$kli_vxcf"."_dopslu.dok $podmobdobie AND slu > 0";
$dsql = mysql_query("$dsqlt"); 
//echo $dsqlt;
//exit;

//sumar pred
$dsqlt = "UPDATE F$kli_vxcf"."_kuchprc$kli_uzid "." SET dmxb=0 ";
$dsql = mysql_query("$dsqlt");


//sumar za dok 
$dsqlt = "INSERT INTO F$kli_vxcf"."_kuchprc$kli_uzid "." SELECT".
" dok,dat,25,0,sum(spot),sum(pjed),sum(doda),sum(fakt),0,0 ".
" FROM F$kli_vxcf"."_kuchprc$kli_uzid".
" WHERE dmxb=0 ".
" GROUP BY dok".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//sumar za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_kuchprc$kli_uzid "." SELECT".
" 0,dat,27,0,sum(spot),sum(pjed),sum(doda),sum(fakt),0,0 ".
" FROM F$kli_vxcf"."_kuchprc$kli_uzid".
" WHERE dmxb=0 ".
" GROUP BY dmxb".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
      }

if ( $copern == 10 AND $pds == 2 AND $finlim == 1 )  
      { 
//dodane
$dsqlt = "INSERT INTO F$kli_vxcf"."_kuchprc$kli_uzid"." SELECT".
" F$kli_vxcf"."_kuchdodh.kto,dat,1,0,0,0,kurz,(jmno*kurz),0,0 ".
" FROM F$kli_vxcf"."_kuchdodh,F$kli_vxcf"."_kuchdodp".
" WHERE F$kli_vxcf"."_kuchdodh.dok=F$kli_vxcf"."_kuchdodp.dok $podmobdobie AND druhp >= 11 AND druhp <= 19 ";
$dsql = mysql_query("$dsqlt"); 
//echo $dsqlt;
//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_kuchprc$kli_uzid"." SELECT".
" F$kli_vxcf"."_kuchdodh.kto,dat,1,0,0,0,kurz,0,0,0 ".
" FROM F$kli_vxcf"."_kuchdodh,F$kli_vxcf"."_kuchdodp".
" WHERE F$kli_vxcf"."_kuchdodh.dok=F$kli_vxcf"."_kuchdodp.dok $podmobdobie AND ( druhp < 11 OR druhp > 19 )";
$dsql = mysql_query("$dsqlt"); 

//sumar pred
$dsqlt = "UPDATE F$kli_vxcf"."_kuchprc$kli_uzid "." SET dmxb=0 ";
$dsql = mysql_query("$dsqlt");

//Vypis datum 5.5.2019 kontrola 2
if( $kli_uzid == 1717171717171 )
{


$sqltt = "SELECT * FROM F$kli_vxcf"."_kuchprc$kli_uzid WHERE dok > 0 AND dat > '2019-04-30' ORDER BY dat ";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
echo $sqltt.$tvpol."<br />";
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);

$zisk=$rtov->fakt-$rtov->spot;

echo "dok ".$rtov->dok." dat".$rtov->dat." spot".$rtov->spot." pjed".$rtov->pjed." doda".$rtov->doda." fakt".$rtov->fakt." zisk".$zisk."<br />";

 }

$i=$i+1;
   }

exit;
}

//sumar za dok
$dsqlt = "INSERT INTO F$kli_vxcf"."_kuchprc$kli_uzid "." SELECT".
" dok,dat,25,0,sum(spot),sum(pjed),max(doda),sum(fakt),0,0 ".
" FROM F$kli_vxcf"."_kuchprc$kli_uzid".
" WHERE dmxb=0 $podmobdobieume ".
" GROUP BY dok".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//Vypis dm 25 kontrola 1
if( $kli_uzid == 1717171717171717 )
{


$sqltt = "SELECT * FROM F$kli_vxcf"."_kuchprc$kli_uzid WHERE dmxb = 25 ORDER BY dat ";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
echo $sqltt.$tvpol."<br />";
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);

$zisk=$rtov->fakt-$rtov->spot;

echo "dok ".$rtov->dok." dat".$rtov->dat." spot".$rtov->spot." pjed".$rtov->pjed." doda".$rtov->doda." fakt".$rtov->fakt." zisk".$zisk."<br />";

 }

$i=$i+1;
   }

exit;
}

//oprava 5.2019 gastrobene fy è.679 nie je 5.5.2019 na finanaènom limite pozri Trello Bugs
//oprava 6.2019 gastrobene fy è.679 nie je 24.6.2019 na finanaènom limite pozri Trello Bugs
if( $kli_vxcf == 679 AND $kli_vume >= 5.2019 )
  {
$dsqlt = "UPDATE F$kli_vxcf"."_kuchprc$kli_uzid SET pjed=24 WHERE dat = '2019-05-05' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_kuchprc$kli_uzid SET pjed=943 WHERE dat = '2019-06-24' ";
$dsql = mysql_query("$dsqlt");

  }

//vymaz ak nema mnozstvo jedla a hodnotu limitu = jedla mimo sledovnia limitu
$dsqlt = "DELETE FROM F$kli_vxcf"."_kuchprc$kli_uzid WHERE dmxb = 25 AND pjed = 0 ";
$dsql = mysql_query("$dsqlt");

//sumar za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_kuchprc$kli_uzid "." SELECT".
" 0,dat,27,0,sum(spot),sum(pjed),0,sum(fakt),0,0 ".
" FROM F$kli_vxcf"."_kuchprc$kli_uzid".
" WHERE dmxb=25  $podmobdobieume ".
" GROUP BY dmxb".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_kuchprc$kli_uzid ( dok,dat,dmxb,pjed )
 VALUES ( 1, '0000-00-00', 0, 1 ); "); 

//exit;

//sumar za minule obdobie
$dsqlt = "INSERT INTO F$kli_vxcf"."_kuchprc$kli_uzid "." SELECT".
" dok,dat,121,0,sum(spot),sum(pjed),0,sum(fakt),0,0 ".
" FROM F$kli_vxcf"."_kuchprc$kli_uzid".
" WHERE dmxb=0 AND dat < '$datp_ume' ".
" GROUP BY dok".
"";
$dsql = mysql_query("$dsqlt");


$dsqlt = "DELETE FROM F$kli_vxcf"."_kuchprc$kli_uzid WHERE dmxb = 121 AND pjed = 0 ";
$dsql = mysql_query("$dsqlt");

if( $kli_uzid == 171717171717 )
{


$sqltt = "SELECT * FROM F$kli_vxcf"."_kuchprc$kli_uzid WHERE dat >= '2019-01-01' AND dat <= '2017-04-30' AND dmxb = 121 ORDER BY dat ";
$zisks=0;
$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
echo $sqltt.$tvpol."<br />";
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);

$zisk=$rtov->fakt-$rtov->spot;
$zisks=$zisks+$zisk;

echo "dok ".$rtov->dok." dat".$rtov->dat." spot".$rtov->spot." pjed".$rtov->pjed." doda".$rtov->doda." fakt".$rtov->fakt." zisk".$zisk."<br />";

 }

$i=$i+1;
   }

echo " pol ".$i." zisk ".$zisks;
exit;
}

$dsqlt = "INSERT INTO F$kli_vxcf"."_kuchprc$kli_uzid "." SELECT".
" 0,dat,21,0,sum(spot),sum(pjed),0,sum(fakt),0,0 ".
" FROM F$kli_vxcf"."_kuchprc$kli_uzid".
" WHERE dmxb=121 ".
" GROUP BY dmxb".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_kuchprc$kli_uzid WHERE dmxb = 121 ";
$dsql = mysql_query("$dsqlt");

if( $kli_uzid == 17171717171771 )
{


$sqltt = "SELECT * FROM F$kli_vxcf"."_kuchprc$kli_uzid WHERE dmxb = 25 ORDER BY dat ";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
echo $sqltt.$tvpol."<br />";
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);

$zisk=$rtov->fakt-$rtov->spot;

echo "dok ".$rtov->dok." dat".$rtov->dat." spot".$rtov->spot." pjed".$rtov->pjed." doda".$rtov->doda." fakt".$rtov->fakt." zisk".$zisk."<br />";

 }

$i=$i+1;
   }

exit;
}


//sumar za cely rok
$dsqlt = "INSERT INTO F$kli_vxcf"."_kuchprc$kli_uzid "." SELECT".
" 0,dat,29,0,sum(spot),sum(pjed),0,sum(fakt),0,0 ".
" FROM F$kli_vxcf"."_kuchprc$kli_uzid".
" WHERE dmxb=25 OR dmxb=21 ".
" GROUP BY druhp".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

      }





$dsqlt = "UPDATE F$kli_vxcf"."_kuchprc$kli_uzid "." SET cjed=spot/pjed WHERE pjed != 0 ";
$dsql = mysql_query("$dsqlt");

if ( $copern == 10 AND $pds == 2 AND $finlim == 0 )  
      { 
$dsqlt = "UPDATE F$kli_vxcf"."_kuchprc$kli_uzid "." SET zisk=doda-spot ";
$dsql = mysql_query("$dsqlt");
      }
if ( $copern == 10 AND $pds == 2 AND $finlim == 1 )  
      { 
$dsqlt = "UPDATE F$kli_vxcf"."_kuchprc$kli_uzid "." SET zisk=fakt-spot ";
$dsql = mysql_query("$dsqlt");
      }


$sqltt = "SELECT * FROM F$kli_vxcf"."_kuchprc$kli_uzid  WHERE dmxb > 20  ORDER BY dmxb,dat,dok";


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


$dat_sk=SkDatum($riadok->dat);


//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$pdf->SetFont('arial','',12);




if ( $copern == 10 AND $pds == 2 AND $finlim == 0 )  
  { 
$pdf->Cell(90,6,"Výrobné náklady a tržby v kuchyni pod¾a akcií za $kli_vume","LTB",0,"L"); 
$pdf->Cell(0,6,"FIR$kli_vxcf $kli_nxcf","RTB",1,"R");


$pdf->SetFont('arial','',10);
$pdf->Cell(25,5,"Dátum","1",0,"R");$pdf->Cell(30,5,"Norm.Doklad","1",0,"R");$pdf->Cell(30,5,"Spotreba EUR","1",0,"R");
$pdf->Cell(30,5,"Poèet Jedál ks","1",0,"R");
$pdf->Cell(30,5,"Pr.cena Jedla","1",0,"R");
$pdf->Cell(30,5,"Dodané EUR","1",0,"R");
$pdf->Cell(30,5,"Faktúrované EUR","1",0,"R");
$pdf->Cell(30,5,"Zisk z dod.EUR","1",0,"R");
$pdf->Cell(0,5," ","1",1,"R");
  }

if ( $copern == 10 AND $pds == 2 AND $finlim == 1 )  
  { 
$pdf->Cell(90,6,"Preh¾ad o èerpaní finanèného limitu za $kli_vume","LTB",0,"L"); 
$pdf->Cell(0,6,"FIR$kli_vxcf $kli_nxcf","RTB",1,"R");


$pdf->SetFont('arial','',10);
$pdf->Cell(25,5,"Dátum","1",0,"R");$pdf->Cell(30,5,"Norm.Doklad","1",0,"R");$pdf->Cell(30,5,"C.Skut.Spotreba","1",0,"R");
$pdf->Cell(30,5,"Poèet Jedál ks","1",0,"R");
$pdf->Cell(30,5,"Skut.spot./Porciu","1",0,"R");
$pdf->Cell(30,5,"Fin.limit/Porciu","1",0,"R");
$pdf->Cell(30,5,"C.Lim.Spotreba","1",0,"R");
$pdf->Cell(30,5,"Rozdiel","1",0,"R");
$pdf->Cell(0,5," ","1",1,"R");
  }

     }
//koniec hlavicky j=0




if( $riadok->dmxb == 25 )
{


$pdf->SetFont('arial','',10);
$pdf->Cell(25,5,"$dat_sk","B",0,"R");$pdf->Cell(30,5,"$riadok->dok","B",0,"R");$pdf->Cell(30,5,"$riadok->spot","B",0,"R");
$pdf->Cell(30,5,"$riadok->pjed","B",0,"R");
$pdf->Cell(30,5,"$riadok->cjed","B",0,"R");
$pdf->Cell(30,5,"$riadok->doda","B",0,"R");
$pdf->Cell(30,5,"$riadok->fakt","B",0,"R");
$pdf->Cell(30,5,"$riadok->zisk","B",0,"R");
$pdf->Cell(0,5," ","B",1,"R");


}

if( $riadok->dmxb == 27 AND $finlim == 0 )
{
$doda=$riadok->doda;
if( $riadok->doda == 0 ) $doda="";

$zisk=$riadok->zisk;
if( $riadok->zisk == 0 ) $zisk="0";

$pdf->SetFont('arial','',10);
$pdf->Cell(55,5,"SPOLU $kli_vume","1",0,"L");$pdf->Cell(30,5,"$riadok->spot","1",0,"R");
$pdf->Cell(30,5,"$riadok->pjed","1",0,"R");
$pdf->Cell(30,5,"$riadok->cjed","1",0,"R");
$pdf->Cell(30,5,"$doda","1",0,"R");
$pdf->Cell(30,5,"$riadok->fakt","1",0,"R");
$pdf->Cell(30,5,"$zisk","1",1,"R");

}

if( $riadok->dmxb == 27 AND $finlim == 1 )
{
$doda=$riadok->doda;
if( $riadok->doda == 0 ) $doda="";

$zisk=$riadok->zisk;
$Cislo=$zisk+"";
$szisk=sprintf("%0.2f", $Cislo);

$pdf->SetFont('arial','',10);
$pdf->Cell(55,5,"SPOLU za $kli_vume","1",0,"L");$pdf->Cell(30,5,"$riadok->spot","1",0,"R");
$pdf->Cell(30,5,"$riadok->pjed","1",0,"R");
$pdf->Cell(30,5,"$riadok->cjed","1",0,"R");
$pdf->Cell(30,5,"$doda","1",0,"R");
$pdf->Cell(30,5,"$riadok->fakt","1",0,"R");
$pdf->Cell(30,5,"$szisk","1",1,"R");

}

if( $riadok->dmxb == 21 AND $finlim == 1 )
{
$zisk=$riadok->zisk+$fir_xkulir;
$Cislo=$zisk+"";
$szisk=sprintf("%0.2f", $Cislo);

$pdf->SetFont('arial','',10);
$pdf->Cell(205,5,"SPOLU poèiatoèný stav $kli_vume ","1",0,"L");
$pdf->Cell(30,5,"$szisk","1",1,"R");


}


if( $riadok->dmxb == 29 AND $finlim == 1 )
{
$zisk=$riadok->zisk+$fir_xkulir;
$Cislo=$zisk+"";
$szisk=sprintf("%0.2f", $Cislo);

$pdf->SetFont('arial','',10);
$pdf->Cell(205,5,"SPOLU zostatok $kli_vume ","1",0,"L");
$pdf->Cell(30,5,"$szisk","1",1,"R");


}


}
$i = $i + 1;
$j = $j + 1;
if( $j > 32 ) $j=0;

  }


$pdf->Output("../tmp/doch.$kli_uzid.pdf");


?> 

<script type="text/javascript">
  var okno = window.open("../tmp/doch.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
