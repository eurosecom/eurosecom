<HTML>
<?php

// celkovy zaciatok dokumentu Zostava obratov DRM 26
       do
       {
$sys = 'SKL';
$urov = 2000;
$clsm = 920;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
//drupoh=1 mesacne drupoh=2 rocne obraty

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

//copern=10 obraty
//copern=20 rekapitulacia


if ( $copern == 10 OR $copern == 20 )
    {

//urob pracovnu sklprc zjednotenie pri,vyd,pre,poc

if ( $copern == 10 OR $copern == 20 ) $podm_poc = "ume < ".$kli_vume;
if ( $copern == 10 OR $copern == 20 ) $podm_obd = "ume = ".$kli_vume;
if ( $copern == 10 OR $copern == 20 ) $podm_obm = "ume <= ".$kli_vume;
//rocne obraty
if ( $drupoh == 2 )
{
if ( $copern == 10 OR $copern == 20 ) $podm_poc = "ume < 1.".$kli_vrok;
if ( $copern == 10 OR $copern == 20 ) $podm_obd = "ume = ".$kli_vume;
if ( $copern == 10 OR $copern == 20 ) $podm_obm = "ume <= ".$kli_vume;
}

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
   ume         DECIMAL(10,4),
   dat         DATE,
   skl         DECIMAL(15,0),
   poh         INT,
   cis         DECIMAL(15,0),
   mno         DECIMAL(10,3),
   cen         DECIMAL(10,4),
   zas         DECIMAL(10,2),
   prs         DECIMAL(10,2),
   pdj         DECIMAL(10,2),
   vdj         DECIMAL(10,2),
   prj         DECIMAL(10,2),
   pcs         DECIMAL(10,2),
   mn2         DECIMAL(10,3),
   krd         DECIMAL(10,0)
);
sklprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc'.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc2'.$sqlt;
$vytvor = mysql_query("$vsql");

$ume1="1.".$kli_vrok;
$dat1=$kli_vrok."-01-01";
$majmaj1="majmaj_1_".$kli_vrok;

//poc.stav
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,'$ume1','$dat1',2401,1,drm,mno,cen,(mno*cen),'0','0','0','0',(mno*cen),1,0 FROM F$kli_vxcf"."_$majmaj1 WHERE ( drm = 26 OR drm = 27 ) ";
$dsql = mysql_query("$dsqlt");

if( $drupoh != 2 )
    {
//prijem minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,'$ume1','$dat1',2401,20,drm,mno,cen,(mno*cen),'0','0','0',(mno*cen),'0',1,0 FROM F$kli_vxcf"."_majpoh ".
" WHERE ( drm = 26 OR drm = 27 ) AND poh = 2 AND $podm_obm ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;

//vydaj minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,'$ume1','$dat1',2401,50,drm,-mno,cen,(-mno*cen),'0','0',(-mno*cen),'0','0',-1,0 FROM F$kli_vxcf"."_majpoh ".
" WHERE ( drm = 26 OR drm = 27 ) AND poh = 3 AND $podm_obm ";
$dsql = mysql_query("$dsqlt");
    }

if( $kli_uzid == 1177 )
{

$sqltt = "SELECT * FROM F$kli_vxcf"."_sklprc WHERE mno > 0 ";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
echo $sqltt.$tvpol."<br />";
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);

echo $rtov->skl.";".$rtov->cis.";".$rtov->mno.";".$rtov->cen.";".$rtov->pcs.";".$rtov->poh."<br />";

  

 }

$i=$i+1;
   }

exit;
}

//mesacne obraty krmne dni nedavaj do pociatku mnozstvo
if( $drupoh != 2 AND $copern == 10 )
{
//echo "idem1";
$dsqlt = "DELETE FROM F$kli_vxcf"."_sklprc WHERE poh = 92 ";
$dsql = mysql_query("$dsqlt");
}

//rekapitulacia krmne dni pociatok do krd
if( $copern == 20 )
{
//echo "idem2";
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc SET krd=mn2, mn2=0 WHERE poh = 92 ";
$dsql = mysql_query("$dsqlt");
}

//nastav vsetko ako poc stav.
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc SET poh=1 ";
$dsql = mysql_query("$dsqlt");

if( $drupoh == 2 )
    {
//prijem mesiaca nakup
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,ume,dob,2401,20,drm,mno,cen,(mno*cen),'0','0','0',(mno*cen),'0',1,0 FROM F$kli_vxcf"."_majpoh ".
" WHERE ( drm = 26 OR drm = 27 ) AND poh = 2 AND $podm_obm AND dph = 2 ";
$dsql = mysql_query("$dsqlt");

//prijem mesiaca ine
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,ume,dob,2401,42,drm,mno,cen,(mno*cen),'0','0','0',(mno*cen),'0',1,0 FROM F$kli_vxcf"."_majpoh ".
" WHERE ( drm = 26 OR drm = 27 ) AND poh = 2 AND $podm_obm AND dph != 2 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;

//vydaj mesiaca predaj
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,ume,dob,2401,50,drm,-mno,cen,(-mno*cen),'0','0',(-mno*cen),'0','0',-1,0 FROM F$kli_vxcf"."_majpoh ".
" WHERE ( drm = 26 OR drm = 27 ) AND poh = 3 AND $podm_obm AND dph = 2  ";
$dsql = mysql_query("$dsqlt");

//vydaj mesiaca ine
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,0,ume,dob,2401,70,drm,-mno,cen,(-mno*cen),'0','0',(-mno*cen),'0','0',-1,0 FROM F$kli_vxcf"."_majpoh ".
" WHERE ( drm = 26 OR drm = 27 ) AND poh = 3 AND $podm_obm AND dph != 2 ";
$dsql = mysql_query("$dsqlt");

//exit;
    }

//rekapitulacia krmne dni bezneho do krd
if( $copern == 20 )
{
//echo "idem2";
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc SET krd=mn2, mn2=0 WHERE poh = 92 ";
$dsql = mysql_query("$dsqlt");
}

//vymaz nie 2mj
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc ".
" SET pox1=999 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc ".
" SET pox1=0 ".
" WHERE skl = 2401 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklprc WHERE pox1 = 999 ";
$dsql = mysql_query("$dsqlt");

//group za skl,cis,poh,ume
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2".
" SELECT 0,0,ume,dat,skl,poh,cis,SUM(mno),cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs),SUM(mn2),SUM(krd) FROM F$kli_vxcf"."_sklprc ".
" GROUP BY skl,cis,poh,ume".
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
" SELECT 0,pox1,ume,dat,skl,999999,cis,SUM(mno),cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs),SUM(mn2),SUM(krd) FROM F$kli_vxcf"."_sklprc2 ".
"  WHERE poh != 92 GROUP BY skl,cis,pox1".
"";
$dsql = mysql_query("$dsqlt");

//rekapitulacia nie
if( $copern != 20 )
{
//group za cis
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2".
" SELECT 0,8,ume,dat,skl,999999,cis,SUM(mno),cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs),SUM(mn2),SUM(krd) FROM F$kli_vxcf"."_sklprc ".
"  WHERE poh != 92 GROUP BY skl,cis".
"";
$dsql = mysql_query("$dsqlt");
}
//rekapitulacia ano
if( $copern == 20 )
{
//group za cis
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2".
" SELECT 0,8,ume,dat,skl,999999,cis,SUM(mno),cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs),SUM(mn2),SUM(krd) FROM F$kli_vxcf"."_sklprc ".
"  WHERE poh >= 0 GROUP BY skl,cis".
"";
$dsql = mysql_query("$dsqlt");
}

//group za skl
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2".
" SELECT 10,0,ume,dat,skl,poh,999999999999999,SUM(mno),cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs),SUM(mn2),SUM(krd) FROM F$kli_vxcf"."_sklprc ".
"  WHERE poh != 92 GROUP BY skl".
"";
$dsql = mysql_query("$dsqlt");

//group za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2".
" SELECT 20,0,ume,dat,99999999,poh,cis,SUM(mno),cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs),SUM(mn2),SUM(krd) FROM F$kli_vxcf"."_sklprc ".
"  WHERE poh != 92 GROUP BY pox".
"";
$dsql = mysql_query("$dsqlt");

//zmaz pracovnu sklprc
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc';
$vysledok = mysql_query("$sqlt");

    }


if( $kli_uzid == 171717 )
{

$sqltt = "SELECT * FROM F$kli_vxcf"."_sklprc2 WHERE mno > 0 ";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
echo $sqltt.$tvpol."<br />";
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);

echo $rtov->ume.";".$rtov->cis.";".$rtov->mno.";".$rtov->cen.";".$rtov->pcs.";".$rtov->poh."<br />";

  

 }

$i=$i+1;
   }

exit;
}


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>
<title>
<?php if( $polno == 0 AND $copern == 10 ) { echo "Obraty 2MJ položiek"; } ?>
<?php if( $polno == 1 AND $copern == 10 ) { echo "Obraty zvierat"; } ?>
<?php if( $polno == 0 AND $copern == 20 ) { echo "Rekapitulácia 2MJ položiek"; } ?>
<?php if( $polno == 1 AND $copern == 20 ) { echo "Rekapitulácia zvierat"; } ?>
</title>

</title>
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

<?php if( $polno == 0 AND $copern == 10 ) { echo "Obraty 2MJ položiek"; } ?>
<?php if( $polno == 1 AND $copern == 10 ) { echo "Obraty zvierat"; } ?> 
<?php if( $polno == 0 AND $copern == 20 ) { echo "Rekapitulácia 2MJ položiek"; } ?>
<?php if( $polno == 1 AND $copern == 20 ) { echo "Rekapitulácia zvierat"; } ?> 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
$hhmmss = Date ("is", MkTime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")) );

 $outfilexdel="../tmp/maj2mj_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/maj2mj_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }


   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');



$neparne=1;

if ( $copern == 10 )
  {
$sqltt = "SELECT F$kli_vxcf"."_sklprc2.skl, F$kli_vxcf"."_sklprc2.poh, F$kli_vxcf"."_sklprc2.zas, F$kli_vxcf"."_sklprc2.pox,  ".
" F$kli_vxcf"."_sklprc2.pox1, F$kli_vxcf"."_sklcph.nph, F$kli_vxcf"."_skl.nas, F$kli_vxcf"."_sklprc2.cis, F$kli_vxcf"."_sklcis.nat, ".
" F$kli_vxcf"."_sklcis.mer, F$kli_vxcf"."_sklcisudaje.xmer2, F$kli_vxcf"."_sklprc2.mno, F$kli_vxcf"."_sklprc2.mn2, F$kli_vxcf"."_sklprc2.ume  ".
" FROM F$kli_vxcf"."_sklprc2".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklprc2.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_sklcisudaje".
" ON F$kli_vxcf"."_sklprc2.cis=F$kli_vxcf"."_sklcisudaje.xcis".
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklprc2.skl=F$kli_vxcf"."_skl.skl".
" LEFT JOIN F$kli_vxcf"."_sklcph".
" ON F$kli_vxcf"."_sklprc2.poh=F$kli_vxcf"."_sklcph.poh".
" WHERE ( pox = 0 OR pox = 8 OR pox = 10 OR pox = 20 ) ".
" ORDER by F$kli_vxcf"."_sklprc2.skl,cis,pox,pox1,F$kli_vxcf"."_sklprc2.poh,F$kli_vxcf"."_sklprc2.ume".
"";
  }

if ( $copern == 20  )
  {
//uprava krmne dni od zaciatku roka ak sa prenasa v priebehu

$sqltt = "SELECT F$kli_vxcf"."_sklprc2.skl, F$kli_vxcf"."_sklprc2.poh, F$kli_vxcf"."_sklprc2.zas, F$kli_vxcf"."_sklprc2.pox, F$kli_vxcf"."_sklprc2.pcs,  ".
" F$kli_vxcf"."_sklprc2.pox1, F$kli_vxcf"."_sklcph.nph, F$kli_vxcf"."_skl.nas, F$kli_vxcf"."_sklprc2.cis, F$kli_vxcf"."_sklcis.nat, ".
" F$kli_vxcf"."_sklprc2.krd,F$kli_vxcf"."_sklcis.mer, F$kli_vxcf"."_sklcisudaje.xmer2, F$kli_vxcf"."_sklprc2.mno, F$kli_vxcf"."_sklprc2.mn2, F$kli_vxcf"."_sklprc2.ume  ".
" FROM F$kli_vxcf"."_sklprc2".
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklprc2.skl=F$kli_vxcf"."_skl.skl".
" LEFT JOIN F$kli_vxcf"."_sklcph".
" ON F$kli_vxcf"."_sklprc2.poh=F$kli_vxcf"."_sklcph.poh".
" WHERE ( pox1 = 8 OR pox = 10 OR pox = 20 ) ".
" ORDER by F$kli_vxcf"."_sklprc2.skl,cis,pox,pox1,F$kli_vxcf"."_sklprc2.poh,F$kli_vxcf"."_sklprc2.ume".
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


$dnesoktime = Date ("d.m.Y H.s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
if ( $copern == 10 AND $polno == 0 AND $drupoh == 1 )  { $pdf->Cell(90,6,"Zostava obratov 2MJ položiek za $kli_vume ","LTB",0,"L"); }
if ( $copern == 10 AND $polno == 0 AND $drupoh == 2 )  { $pdf->Cell(90,6,"Zostava roèných obratov 2MJ položiek za 1.$kli_vrok až $kli_vume ","LTB",0,"L"); }
if ( $copern == 10 AND $polno == 1 AND $drupoh == 1 )  { $pdf->Cell(90,6,"Zostava obratov zvierat za $kli_vume ","LTB",0,"L"); }
if ( $copern == 10 AND $polno == 1 AND $drupoh == 2 )  { $pdf->Cell(90,6,"Zostava roèných obratov zvierat za 1.$kli_vrok až $kli_vume","LTB",0,"L"); }

if ( $copern == 20 AND $polno == 0 )  { $pdf->Cell(90,6,"Rekapitulácia 2MJ položiek za $kli_vume ","LTB",0,"L"); }
if ( $copern == 20 AND $polno == 1 )  { $pdf->Cell(90,6,"Rekapitulácia zvierat za $kli_vume ","LTB",0,"L"); }

$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);

//Sklad Pohyb Nazov pohybu  Suma  

if ( $copern == 10  )  { 
$pdf->Cell(30,5,"SKL - CIS","1",0,"L");$pdf->Cell(10,5,"Pohyb","1",0,"R");$pdf->Cell(60,5,"Popis pohybu ","1",0,"L");
$pdf->Cell(15,5,"Ume","1",0,"R");$pdf->Cell(27,5,"Množstvo ","1",0,"R");$pdf->Cell(0,5,"Hodnota Eur","1",1,"R");
                       }

if ( $copern == 20  )  { 
$xtxt="KrmneZaRok";
if( $polno == 0 ) $xtxt="";
$pdf->Cell(80,5,"SKL - CIS","1",0,"L");
$pdf->Cell(20,5,"$xtxt","1",0,"R");
$pdf->Cell(15,5,"Ume","1",0,"R");
$pdf->Cell(27,5,"Množstvo ","1",0,"R");$pdf->Cell(0,5,"Hodnota Eur","1",1,"R");
                       }

     }
//koniec hlavicky j=0



$datsk=SkDatum($riadok->dat);

//zaciatok obraty zvierat
if ( $copern == 10  )  { 

if( $riadok->pox == 0 AND $riadok->poh != 999999 )
{

$pdf->SetFont('arial','',8);

if( $sZostatok == '0' ) $sZostatok="";
$nazpoh=$riadok->nph;
$cpoh=1*$riadok->poh;
if( $riadok->poh <= 1 ) $nazpoh="Poèiatoèný stav";

$pdf->Cell(30,5,"$riadok->skl- $riadok->cis","0",0,"L");$pdf->Cell(10,5,"$riadok->poh","0",0,"R");
$pdf->SetFont('arial','',6);
$pdf->Cell(60,5,"$nazpoh","0",0,"L");
$pdf->SetFont('arial','',8);

$pdf->Cell(15,5,"$riadok->ume","0",0,"R");
$pdf->Cell(27,5,"$riadok->mn2 ks","0",0,"R");
$pdf->Cell(0,5,"$riadok->zas","0",1,"R");
$j=$j+1;
}

if( $riadok->pox == 0 AND $riadok->poh == 999999 AND $riadok->pox1 == 1 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(30,5," ","0",0,"R");
$pdf->Cell(85,5,"CELKOM príjem","T",0,"R");
$pdf->Cell(27,5,"$riadok->mn2 ks","T",0,"R");
$pdf->Cell(0,5,"$riadok->zas","T",1,"R");
$j=$j+1;
}

if( $riadok->pox == 0 AND $riadok->poh == 999999 AND $riadok->pox1 == 6 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(30,5," ","0",0,"R");
$pdf->Cell(85,5,"CELKOM výdaj","T",0,"R");
$pdf->Cell(27,5,"$riadok->mn2 ks","T",0,"R");
$pdf->Cell(0,5,"$riadok->zas","T",1,"R");
$j=$j+1;
}

if( $riadok->pox == 0 AND $riadok->poh == 999999 AND $riadok->pox1 == 8 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(115,5,"CELKOM  $riadok->cis -  $riadok->nat","T",0,"L");
$pdf->Cell(27,5,"$riadok->mn2 ks","T",0,"R");
$pdf->Cell(0,5,"$riadok->zas","T",1,"R");

$pdf->Cell(0,5," ","0",1,"R");
$j=$j+2;
}


if( $riadok->pox == 10 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(165,5,"CELKOM sklad $riadok->skl -  $riadok->nas","1",0,"L");
$pdf->Cell(0,5,"$riadok->zas","1",1,"R");

$pdf->Cell(0,5," ","0",1,"R");
$j=$j+2;
}


if( $riadok->pox == 20 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(150,5,"CELKOM všetky sklady $dnesoktime","LTB",0,"L");
$pdf->Cell(0,5,"$riadok->zas","RTB",1,"R");
}


                     } 
//koniec obraty zvierat

//zaciatok rekapitulacia zvierat
if ( $copern == 20  )  { 



if( $riadok->pox == 0 AND $riadok->poh == 999999 AND $riadok->pox1 == 8 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(80,5,"$riadok->skl -  $riadok->cis -  $riadok->nat","T",0,"L");
$pdf->Cell(20,5,"$riadok->krd","T",0,"R");
$pdf->Cell(27,5,"$riadok->mno$riadok->mer","T",0,"R");$pdf->Cell(27,5,"$riadok->mn2$riadok->xmer2","T",0,"R");
$pdf->Cell(0,5,"$riadok->zas","T",1,"R");

$j=$j+1;
}


if( $riadok->pox == 10 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(150,5,"CELKOM sklad $riadok->skl -  $riadok->nas","LBT",0,"L");
$pdf->Cell(0,5,"$riadok->zas","RBT",1,"R");

$pdf->Cell(0,5," ","0",1,"R");
$j=$j+2;
}


if( $riadok->pox == 20 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(150,5,"CELKOM všetky sklady $dnesoktime","LTB",0,"L");
$pdf->Cell(0,5,"$riadok->zas","RTB",1,"R");
}


                     } 
//koniec rekapitulacia zvierat




}
$i = $i + 1;

if( $j > 44 ) $j=0;

  }


$pdf->Output("$outfilex");

$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc2';
if( $kli_vmesx != 12 ) { $vysledok = mysql_query("$sqlt"); }
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc';
$vysledok = mysql_query("$sqlt");

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
