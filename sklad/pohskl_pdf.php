<HTML>
<?php

do
{
$sys = 'SKL';
$urov = 1000;
$cslm=403203;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


$copern = $_REQUEST['copern'];
$druh = 1*$_REQUEST['druh'];

$cit_nas = include("../cis/citaj_nas.php");


if ( $copern == 10 OR $copern == 20 )
    {
if ( $copern == 10 ) $podm_poc = "ume < ".$vyb_ume;
if ( $copern == 10 ) $podm_obd = "ume = ".$vyb_ume;
if ( $copern == 20 ) $podm_poc = "ume < 1.".$vyb_rok;
if ( $copern == 20 ) $podm_obd = "ume >= 1.".$vyb_rok." AND ume <= 12.".$vyb_rok;

//echo 'pociatok'.$podm_poc;
//echo 'obdobie'.$podm_obd;

//urob pracovnu sklprc zjednotenie pri,vyd,pre,poc

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid.' ';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc2x'.$kli_uzid.' ';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<sklprc
(
   pox         DECIMAL(10,0) default 0,
   pox1        DECIMAL(10,0) default 0,
   ume         FLOAT(8,4) default 0,
   dat         DATE,
   skl         INT,
   cis         DECIMAL(15,0) default 0,
   mno         DECIMAL(10,3) default 0,
   cen         DECIMAL(10,4) default 0,
   zas         DECIMAL(10,2) default 0,
   prs         DECIMAL(10,2) default 0,
   pdj         DECIMAL(10,2) default 0,
   vdj         DECIMAL(10,2) default 0,
   prj         DECIMAL(10,2) default 0,
   pcs         DECIMAL(10,2) default 0
);
sklprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc2x'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


//poc.stav
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,ume,dat,skl,cis,mno,cen,(mno*cen),'0','0','0','0',(mno*cen) FROM F$kli_vxcf"."_sklpoc WHERE NOT ( cis = 0 )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//prijem minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,ume,dat,skl,cis,mno,cen,(mno*cen),'0','0','0','0',(mno*cen) FROM F$kli_vxcf"."_sklpri WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//vydaj minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,ume,dat,skl,cis,mno,cen,-(mno*cen),'0','0','0','0',-(mno*cen) FROM F$kli_vxcf"."_sklvyd WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//faktury minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,ume,dat,skl,cis,mno,cen,-(mno*cen),'0','0','0','0',-(mno*cen) FROM F$kli_vxcf"."_sklfak WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//presun- minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,ume,dat,skl,cis,mno,cen,-(mno*cen),'0','0','0','0',-(mno*cen) FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//presun+ minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,ume,dat,sk2,cis,mno,cen,(mno*cen),'0','0','0','0',(mno*cen) FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");


//prijem mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,ume,dat,skl,cis,mno,cen,(mno*cen),'0','0','0',(mno*cen),'0' FROM F$kli_vxcf"."_sklpri WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//vydaj mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,ume,dat,skl,cis,mno,cen,-(mno*cen),'0','0',-(mno*cen),'0','0' FROM F$kli_vxcf"."_sklvyd WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//faktury mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,ume,dat,skl,cis,mno,cen,-(mno*cen),'0',-(mno*cen),'0','0','0' FROM F$kli_vxcf"."_sklfak WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//presun- mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,ume,dat,skl,cis,mno,cen,-(mno*cen),-(mno*cen),'0','0','0','0' FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//presun+ mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,ume,dat,sk2,cis,mno,cen,(mno*cen),(mno*cen),'0','0','0','0' FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");


if( $druh == 0 )
  {
//group za skl 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2x$kli_uzid".
" SELECT 1,0,ume,dat,skl,cis,mno,cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprc$kli_uzid ".
" GROUP BY skl".
"";

$dsql = mysql_query("$dsqlt");
  }


if( $druh == 1 )
  {
//dopln drs do pox1 podla skladu
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc$kli_uzid,F$kli_vxcf"."_skl".
" SET F$kli_vxcf"."_sklprc$kli_uzid.pox1 = F$kli_vxcf"."_skl.drs ".
" WHERE F$kli_vxcf"."_sklprc$kli_uzid.skl = F$kli_vxcf"."_skl.skl".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//group za druh 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2x$kli_uzid".
" SELECT 9,pox1,ume,dat,skl,cis,mno,cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprc$kli_uzid ".
" GROUP BY pox1".
"";

$dsql = mysql_query("$dsqlt");
  }

//group za vsetko 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2x$kli_uzid".
" SELECT 10,0,ume,dat,skl,cis,mno,cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprc$kli_uzid ".
" GROUP BY pox".
"";
$dsql = mysql_query("$dsqlt");

//zmaz pohyby nechaj sklad
$dsqlt = "DELETE FROM F$kli_vxcf"."_sklprc2x$kli_uzid WHERE pox = 0 ";
$dsql = mysql_query("$dsqlt");


//zmaz pracovnu sklprc
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
    }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Tlaè-V</title>
  <style type="text/css">

  </style>

<SCRIPT Language="JavaScript">
    <!--

     
    // -->
</SCRIPT>

</HEAD>
<BODY class="white" >
<?php
// nastavenie vzhladu stranky v IE zahlavie= &d &t &b Strana è. &p z &P pata=prazdna
// na vysku okraje vl=15 vp=15 hr=15 dl=15 poloziek 43    

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

if (File_Exists ("../tmp/podklad$kli_uzid.pdf")) { $soubor = unlink("../tmp/podklad$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

if( $druh == 0 )
    {
if ( $copern == 10 OR $copern == 20 )
  {
$sqlt = "SELECT F$kli_vxcf"."_sklprc2x$kli_uzid.skl,pcs,prj,vdj,pdj,prs,zas,pox ".
" FROM F$kli_vxcf"."_sklprc2x$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklprc2x$kli_uzid.skl=F$kli_vxcf"."_skl.skl".
" WHERE pcs != 0 OR prj != 0 OR prs != 0 OR zas != 0 OR vdj != 0 OR pdj != 0".
" ORDER by pox,skl".
"";

//echo $sqlt;
//exit;

$sql = mysql_query("$sqlt");
  }
    }  

if( $druh == 1 )
    {
if ( $copern == 10 OR $copern == 20 )
  {
$sqlt = "SELECT F$kli_vxcf"."_sklprc2x$kli_uzid.skl,pcs,prj,vdj,pdj,prs,zas,pox,pox1 ".
" FROM F$kli_vxcf"."_sklprc2x$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklprc2x$kli_uzid.skl=F$kli_vxcf"."_skl.skl".
" WHERE pcs != 0 OR prj != 0 OR prs != 0 OR zas != 0 OR vdj != 0 OR pdj != 0".
" ORDER by pox,pox1".
"";

//echo $sqlt;
//exit;

$sql = mysql_query("$sqlt");
  }
    } 

// celkom poloziek
$cpol = mysql_num_rows($sql);
?>

<tr>
<td class="tlac" width="10%" >&nbsp;<?php echo $riadok->skl;?></td>
<td class="tlac" align="right" width="15%" align="right" >&nbsp;<?php echo $riadok->pcs;?></td>
<td class="tlac" align="right" width="15%" >&nbsp;<?php echo $riadok->prj;?></td>
<td class="tlac" align="right" width="15%" >&nbsp;<?php echo $riadok->vdj;?></td>
<td class="tlac" align="right" width="15%" >&nbsp;<?php echo $riadok->pdj;?></td>
<td class="tlac" align="right" width="15%" >&nbsp;<?php echo $riadok->prs;?></td>
<td class="tlac" align="right" width="15%" >&nbsp;<?php echo $riadok->zas;?></td>

<?php
$strana=0;
$j=0;           
$i=0;
  while ($i <= $cpol )
  {

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$riadok=mysql_fetch_object($sql);


//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$pdf->SetFont('arial','',10);

if( $druh == 0 )
    {
if ( $copern == 10 )  { $pdf->Cell(90,6,"Pohyb materiálu v skladoch $kli_vume ","LTB",0,"L"); }
if ( $copern == 20 )  { $pdf->Cell(90,6,"Pohyb materiálu v skladoch - okamžitý stav celé úètovné obdobie","LTB",0,"L"); }

$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");
    
$pdf->SetFont('arial','',6);


$pdf->Cell(37,5,"SKL","1",0,"L");$pdf->Cell(24,5,"Poè.stav","1",0,"R");
$pdf->Cell(24,5,"Príjem","1",0,"R");$pdf->Cell(24,5,"Výdaj","1",0,"R");
$pdf->Cell(24,5,"Predaj","1",0,"R");$pdf->Cell(24,5,"Presun","1",0,"R");$pdf->Cell(0,5,"Zostatok","1",1,"R");
    }
if( $druh == 1 )
    {
if ( $copern == 10 )  { $pdf->Cell(90,6,"Pohyb materiálu za druhy $kli_vume ","LTB",0,"L"); }
if ( $copern == 20 )  { $pdf->Cell(90,6,"Pohyb materiálu za druhy  - okamžitý stav celé úètovné obdobie","LTB",0,"L"); }
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");
    
$pdf->SetFont('arial','',6);


$pdf->Cell(37,5,"Druh","1",0,"L");$pdf->Cell(24,5,"Poè.stav","1",0,"R");
$pdf->Cell(24,5,"Príjem","1",0,"R");$pdf->Cell(24,5,"Výdaj","1",0,"R");
$pdf->Cell(24,5,"Predaj","1",0,"R");$pdf->Cell(24,5,"Presun","1",0,"R");$pdf->Cell(0,5,"Zostatok","1",1,"R");
    }


     }
//koniec hlavicky j=0



if( $riadok->pox == 1 )
{

$pdf->SetFont('arial','',8);


$pdf->Cell(37,5,"$riadok->skl","0",0,"L");$pdf->Cell(24,5,"$riadok->pcs","0",0,"R");
$pdf->Cell(24,5,"$riadok->prj","0",0,"R");$pdf->Cell(24,5,"$riadok->vdj","0",0,"R");
$pdf->Cell(24,5,"$riadok->pdj","0",0,"R");$pdf->Cell(24,5,"$riadok->prs","0",0,"R");$pdf->Cell(0,5,"$riadok->zas","0",1,"R");

}

if( $riadok->pox == 9 )
{

$pdf->SetFont('arial','',8);


$pdf->Cell(37,5,"$riadok->pox1","0",0,"L");$pdf->Cell(24,5,"$riadok->pcs","0",0,"R");
$pdf->Cell(24,5,"$riadok->prj","0",0,"R");$pdf->Cell(24,5,"$riadok->vdj","0",0,"R");
$pdf->Cell(24,5,"$riadok->pdj","0",0,"R");$pdf->Cell(24,5,"$riadok->prs","0",0,"R");$pdf->Cell(0,5,"$riadok->zas","0",1,"R");

}

if( $riadok->pox == 10 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(37,5,"CELKOM všetky sklady","1",0,"L");$pdf->Cell(24,5,"$riadok->pcs","1",0,"R");
$pdf->Cell(24,5,"$riadok->prj","1",0,"R");$pdf->Cell(24,5,"$riadok->vdj","1",0,"R");
$pdf->Cell(24,5,"$riadok->pdj","1",0,"R");$pdf->Cell(24,5,"$riadok->prs","1",0,"R");$pdf->Cell(0,5,"$riadok->zas","1",1,"R");
}

}
$i = $i + 1;
$j = $j + 1;
if( $j > 50 ) $j=0;

  }


$pdf->Output("../tmp/podklad.$kli_uzid.pdf");

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/podklad.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
//zmaz pracovnu sklprc
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc2x';
$vysledok = mysql_query("$sqlt");

mysql_free_result($sql);
} while (false);
?>
</BODY>
</HTML>