<HTML>
<?php
$sys = 'HIM';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

//copern=10 drupoh=12 mesacne pohyby DIM drupoh=22 rocne pohyby DIM
if( $copern != 10 AND $copern != 20 AND $copern != 30 ) exit;


require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");


if (File_Exists ("../tmp/$kli_vxcf.mespoh.$kli_vmes.pdf")) { $soubor = unlink("../tmp/$kli_vxcf.mespoh.$kli_vmes.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$pdf->AddPage();
$pdf->SetFont('arial','',7);
$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

//0=vsetkypohyby,1=zaradenia len,2=len vyradenia
$akep = 1*$_REQUEST['akep'];
$podmakep="";
$nazovzos="pohybov";
if( $akep == 1 ) { $podmakep=" AND poh = 2 "; $nazovzos="zaradeného"; }
if( $akep == 2 ) { $podmakep=" AND poh = 3 "; $nazovzos="vyradeného"; }


//zostava pohybov
if( $copern == 10 )
          {

$strana=1;
$pdf->Cell(100,5," ","0",1,"R");


if( $drupoh == 12 )
{
$vsql = "DROP TABLE F".$kli_vxcf."_majpohprc$kli_uzid ";
$vytvor = mysql_query("$vsql");

$vsql = "CREATE TABLE F".$kli_vxcf."_majpohprc$kli_uzid SELECT * FROM F$kli_vxcf"."_majpohdim WHERE inv > 0 ";
$vytvor = mysql_query("$vsql");

$vsql = "UPDATE F".$kli_vxcf."_majpohprc$kli_uzid SET hx5=0, hx4=1 ";
$vytvor = mysql_query("$vsql");

$vsql = "UPDATE F".$kli_vxcf."_majpohprc$kli_uzid SET ops=mno*cen ";
$vytvor = mysql_query("$vsql");

$vsql = "INSERT INTO F$kli_vxcf"."_majpohprc$kli_uzid"." SELECT ".
" cpl,ume,druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,drh1,drh2,SUM(mno),".
" dob,dox,zar,rzv,str,zak,oc,kanc,spo,sku,perc,meso,SUM(cen),SUM(ops),0,zss,mes,0,rop,spo_dan,sku_dan,".
" perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,xmax,cen_max,ops_max,zos_max,zss_max,".
" mes_max,ros_max,rop_max,poh,dph,dap,dvp,dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,sum(hx4),9,id,datm  ".
" FROM F$kli_vxcf"."_majpohprc$kli_uzid"." WHERE ume = $kli_vume GROUP BY poh";
//echo $sqltt;
$vytvor = mysql_query("$vsql");

$sqltt = "SELECT * FROM F$kli_vxcf"."_majpohprc$kli_uzid"." WHERE ume = $kli_vume $podmakep ORDER BY poh,hx5,inv";
//echo $sqltt;

$pdf->Cell(120,5,"Zostava $nazovzos drobného majetku $kli_vume","LTB",0,"L");
$pdf->Cell(125,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}


if( $drupoh == 22 )
{
$vsql = "DROP TABLE F".$kli_vxcf."_majpohprc$kli_uzid ";
$vytvor = mysql_query("$vsql");

$vsql = "CREATE TABLE F".$kli_vxcf."_majpohprc$kli_uzid SELECT * FROM F$kli_vxcf"."_majpohdim WHERE inv > 0 ";
$vytvor = mysql_query("$vsql");

$vsql = "UPDATE F".$kli_vxcf."_majpohprc$kli_uzid SET hx5=0, hx4=1 ";
$vytvor = mysql_query("$vsql");

$vsql = "UPDATE F".$kli_vxcf."_majpohprc$kli_uzid SET ops=mno*cen ";
$vytvor = mysql_query("$vsql");

$vsql = "INSERT INTO F$kli_vxcf"."_majpohprc$kli_uzid"." SELECT ".
" cpl,ume,druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,drh1,drh2,SUM(mno),".
" dob,dox,zar,rzv,str,zak,oc,kanc,spo,sku,perc,meso,SUM(cen),SUM(ops),0,zss,mes,0,rop,spo_dan,sku_dan,".
" perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,xmax,cen_max,ops_max,zos_max,zss_max,".
" mes_max,ros_max,rop_max,poh,dph,dap,dvp,dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,sum(hx4),9,id,datm  ".
" FROM F$kli_vxcf"."_majpohprc$kli_uzid"." WHERE ume != 0 GROUP BY poh";
//echo $sqltt;
$vytvor = mysql_query("$vsql");

$sqltt = "SELECT * FROM F$kli_vxcf"."_majpohprc$kli_uzid"." WHERE ume != 0 $podmakep ORDER BY poh,hx5,inv";
//echo $sqltt;

$pdf->Cell(120,5,"Zostava $nazovzos drobného majetku za rok $kli_vrok","LTB",0,"L");
$pdf->Cell(125,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}

if( $drupoh == 32 )
{
$vsql = "DROP TABLE F".$kli_vxcf."_majpohprc$kli_uzid ";
$vytvor = mysql_query("$vsql");

$vsql = "CREATE TABLE F".$kli_vxcf."_majpohprc$kli_uzid SELECT * FROM F$kli_vxcf"."_majpohdim WHERE inv > 0 ";
$vytvor = mysql_query("$vsql");

$vsql = "UPDATE F".$kli_vxcf."_majpohprc$kli_uzid SET hx5=0, hx4=1 ";
$vytvor = mysql_query("$vsql");

$vsql = "UPDATE F".$kli_vxcf."_majpohprc$kli_uzid SET ops=mno*cen ";
$vytvor = mysql_query("$vsql");

$vsql = "INSERT INTO F$kli_vxcf"."_majpohprc$kli_uzid"." SELECT ".
" cpl,ume,druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,drh1,drh2,SUM(mno),".
" dob,dox,zar,rzv,str,zak,oc,kanc,spo,sku,perc,meso,SUM(cen),SUM(ops),0,zss,mes,0,rop,spo_dan,sku_dan,".
" perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,xmax,cen_max,ops_max,zos_max,zss_max,".
" mes_max,ros_max,rop_max,poh,dph,dap,dvp,dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,sum(hx4),9,id,datm  ".
" FROM F$kli_vxcf"."_majpohprc$kli_uzid"." WHERE ume != 0 GROUP BY ume,poh";
//echo $sqltt;
$vytvor = mysql_query("$vsql");

$sqltt = "SELECT * FROM F$kli_vxcf"."_majpohprc$kli_uzid"." WHERE ume != 0 $podmakep ORDER BY ume,poh,hx5,inv";
//echo $sqltt;

$pdf->Cell(120,5,"Zostava $nazovzos drobného majetku za rok $kli_vrok pod¾a mesiacov","LTB",0,"L");
$pdf->Cell(125,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}

if( $drupoh == 11 )
{
$vsql = "DROP TABLE F".$kli_vxcf."_majpohprc$kli_uzid ";
$vytvor = mysql_query("$vsql");

$vsql = "CREATE TABLE F".$kli_vxcf."_majpohprc$kli_uzid SELECT * FROM F$kli_vxcf"."_majpoh WHERE inv > 0 ";
$vytvor = mysql_query("$vsql");

$vsql = "UPDATE F".$kli_vxcf."_majpohprc$kli_uzid SET hx5=0, hx4=1 ";
$vytvor = mysql_query("$vsql");

$vsql = "INSERT INTO F$kli_vxcf"."_majpohprc$kli_uzid"." SELECT ".
" cpl,ume,druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,drh1,drh2,SUM(mno),".
" dob,dox,zar,rzv,str,zak,oc,kanc,spo,sku,perc,meso,SUM(cen),SUM(ops),SUM(zos),zss,mes,SUM(ros),rop,spo_dan,sku_dan,".
" perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,xmax,cen_max,ops_max,zos_max,zss_max,".
" mes_max,ros_max,rop_max,poh,dph,dap,dvp,dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,sum(hx4),9,id,datm  ".
" FROM F$kli_vxcf"."_majpohprc$kli_uzid"." WHERE ume = $kli_vume GROUP BY poh";
//echo $sqltt;
$vytvor = mysql_query("$vsql");

$sqltt = "SELECT * FROM F$kli_vxcf"."_majpohprc$kli_uzid"." WHERE ume = $kli_vume $podmakep ORDER BY poh,hx5,inv";
//echo $sqltt;

$pdf->Cell(120,5,"Zostava $nazovzos dlhodobého majetku $kli_vume","LTB",0,"L");
$pdf->Cell(125,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}


if( $drupoh == 21 )
{
$vsql = "DROP TABLE F".$kli_vxcf."_majpohprc$kli_uzid ";
$vytvor = mysql_query("$vsql");

$vsql = "CREATE TABLE F".$kli_vxcf."_majpohprc$kli_uzid SELECT * FROM F$kli_vxcf"."_majpoh WHERE inv > 0 ";
$vytvor = mysql_query("$vsql");

$vsql = "UPDATE F".$kli_vxcf."_majpohprc$kli_uzid SET hx5=0, hx4=1 ";
$vytvor = mysql_query("$vsql");

$vsql = "INSERT INTO F$kli_vxcf"."_majpohprc$kli_uzid"." SELECT ".
" cpl,ume,druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,drh1,drh2,SUM(mno),".
" dob,dox,zar,rzv,str,zak,oc,kanc,spo,sku,perc,meso,SUM(cen),SUM(ops),SUM(zos),zss,mes,0,rop,spo_dan,sku_dan,".
" perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,xmax,cen_max,ops_max,zos_max,zss_max,".
" mes_max,ros_max,rop_max,poh,dph,dap,dvp,dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,sum(hx4),9,id,datm  ".
" FROM F$kli_vxcf"."_majpohprc$kli_uzid"." WHERE ume != 0 GROUP BY poh";
//echo $sqltt;
$vytvor = mysql_query("$vsql");

$sqltt = "SELECT * FROM F$kli_vxcf"."_majpohprc$kli_uzid"." WHERE ume != 0 $podmakep ORDER BY poh,hx5,inv";
//echo $sqltt;

$pdf->Cell(120,5,"Zostava $nazovzos dlhodobého majetku za rok $kli_vrok","LTB",0,"L");
$pdf->Cell(125,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}


$pdf->SetFont('arial','',6);

if( $drupoh == 11 OR $drupoh == 21 )
{
$pdf->Cell(20,5,"POH","1",0,"C");$pdf->Cell(20,5,"Dátum","1",0,"R");$pdf->Cell(80,5,"Položka","1",0,"L");$pdf->Cell(25,5,"Množstvo","1",0,"R");
$pdf->Cell(25,5,"Cena obstarania","1",0,"R");$pdf->Cell(25,5,"Oprávky","1",0,"R");$pdf->Cell(25,5,"Zostatková cena","1",0,"R");
$pdf->Cell(25,5,"Roèný odpis","1",1,"R");
$pdf->SetFont('arial','',7);
}
if( $drupoh == 12 OR $drupoh == 22 OR $drupoh == 32 )
{
$pdf->Cell(20,5,"POH","1",0,"C");$pdf->Cell(20,5,"Dátum","1",0,"R");$pdf->Cell(80,5,"Položka","1",0,"L");$pdf->Cell(25,5,"Množstvo","1",0,"R");
$pdf->Cell(25,5,"Cena obstarania","1",0,"R");$pdf->Cell(25,5,"Hodnota","1",0,"R");$pdf->Cell(25,5,"Zaradené","1",0,"R");
$pdf->Cell(25,5," ","1",1,"R");
$pdf->SetFont('arial','',7);
}

$sql = mysql_query("$sqltt");

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

$j=0;           
$i=0;
$ccen=0;
$cops=0;
$czos=0;
$cros=0;
$cmno=0;

  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);
$sk_dap = SkDatum($rtov->dap);

$pdf->SetFont('arial','',8);

if ($rtov->poh == 2 AND $rtov->hx5 == 0 )
{
$pdf->Cell(20,5,"$rtov->poh/$rtov->dph zaradenie","LRTB",0,"C");
$sk_dap = SkDatum($rtov->dob);
$cen=($rtov->cen)*($rtov->mno);
$ops=($rtov->ops);
$zos=($rtov->zos);
$ros=($rtov->ros);
$mno=($rtov->mno);
}
if ($rtov->poh == 3 AND $rtov->hx5 == 0 )
{
$pdf->Cell(20,5,"$rtov->poh/$rtov->dph vyradenie","LRTB",0,"C");
$cen=-($rtov->cen)*($rtov->mno);
$ops=-($rtov->ops);
$zos=-($rtov->zos);
$ros=-($rtov->ros);
$mno=-($rtov->mno);
}
if ($rtov->poh == 4 AND $rtov->hx5 == 0 )
{
$pdf->Cell(20,5,"$rtov->poh/$rtov->dph zvýš.ceny","LRTB",0,"C");
$cen=($rtov->hd1);
$ops=0;
$zos=($rtov->hd1);
$ros=0;
$mno=0;
}
if ($rtov->poh == 5 AND $rtov->hx5 == 0 )
{
$pdf->Cell(20,5,"$rtov->poh/$rtov->dph rozdelenie","LRTB",0,"C");
$cen=0;
$ops=0;
$zos=0;
$ros=0;
$mno=1;
}
if ( $rtov->hx5 == 9 )
{
$pdf->Cell(20,5,"Celkom poh $rtov->poh ","LRTB",0,"L");
}

if ( $rtov->hx5 == 0 )
  {
$ccen=$ccen+$cen;
$cops=$cops+$ops;
$czos=$czos+$zos;
$cros=$cros+$ros;
$cmno=$cmno+$mno;
  }

$Cislo=$cen+"";
$sCen=sprintf("%0.2f", $Cislo);
$Cislo=$ops+"";
$sOps=sprintf("%0.2f", $Cislo);
$Cislo=$zos+"";
$sZos=sprintf("%0.2f", $Cislo);
$Cislo=$ros+"";
$sRos=sprintf("%0.2f", $Cislo);
$Cislo=$mno+"";
$sMno=sprintf("%0.2f", $Cislo);

if ( $rtov->hx5 == 0 AND ( $drupoh == 11 OR $drupoh == 21 ) )
  {
//exit;
$pdf->Cell(20,5,"$sk_dap","TB",0,"R");$pdf->Cell(80,5,"$rtov->inv $rtov->naz","LTB",0,"L");$pdf->Cell(25,5,"$sMno","LRTB",0,"R");
$pdf->Cell(25,5,"$sCen","LRTB",0,"R");$pdf->Cell(25,5,"$sOps","LRTB",0,"R");$pdf->Cell(25,5,"$sZos","LTB",0,"R");
$pdf->Cell(25,5,"$sRos","LRTB",1,"R");
  }
if ( $rtov->hx5 == 0 AND ( $drupoh == 12 OR $drupoh == 22 ) )
  {

$dobsk=SkDatum($rtov->dob);

$pdf->Cell(20,5,"$sk_dap","TB",0,"R");$pdf->Cell(80,5,"$rtov->inv $rtov->naz","LTB",0,"L");$pdf->Cell(25,5,"$rtov->mno","LRTB",0,"R");
$pdf->Cell(25,5,"$rtov->cen","LRTB",0,"R");$pdf->Cell(25,5,"$rtov->ops","LRTB",0,"R");$pdf->Cell(25,5,"$dobsk","LTB",0,"R");
$pdf->Cell(25,5," ","LRTB",1,"R");
  }
if ( $rtov->hx5 == 0 AND $drupoh == 32 )
  {
$pdf->Cell(20,5,"$sk_dap","TB",0,"R");$pdf->Cell(80,5,"$rtov->inv $rtov->naz","LTB",0,"L");$pdf->Cell(25,5,"$rtov->mno","LRTB",0,"R");
$pdf->Cell(25,5,"$rtov->cen","LRTB",0,"R");$pdf->Cell(25,5,"$rtov->ops","LRTB",0,"R");$pdf->Cell(25,5,"ume $rtov->ume ","LTB",0,"L");
$pdf->Cell(25,5," ","LRTB",1,"R");
  }
if ( $rtov->hx5 == 9 )
  {

if( $rtov->zos == 0 ) { $rtov->zos=""; } 
if( $rtov->ros == 0 ) { $rtov->ros=""; }


$pdf->Cell(100,5,"položiek $rtov->hx4","LTB",0,"L");$pdf->Cell(25,5,"$rtov->mno","LRTB",0,"R");
$pdf->Cell(25,5,"$rtov->cen","LRTB",0,"R");$pdf->Cell(25,5,"$rtov->ops","LRTB",0,"R");$pdf->Cell(25,5,"$rtov->zos","LTB",0,"R");
$pdf->Cell(25,5,"$rtov->ros","LRTB",1,"R");
  }

}
$i = $i + 1;
$j = $j + 1;
  }

$Cislo=$ccen+"";
$scCen=sprintf("%0.2f", $Cislo);
$Cislo=$cops+"";
$scOps=sprintf("%0.2f", $Cislo);
$Cislo=$czos+"";
$scZos=sprintf("%0.2f", $Cislo);
$Cislo=$cros+"";
$scRos=sprintf("%0.2f", $Cislo);
$Cislo=$cmno+"";
$scMno=sprintf("%0.2f", $Cislo);

if( $scZos == 0 ) { $scZos=""; } 
if( $scRos == 0 ) { $scRos=""; } 

$pdf->Cell(120,5,"CELKOM","LRTB",0,"L");$pdf->Cell(25,5,"$scMno","LRTB",0,"R");
$pdf->Cell(25,5,"$scCen","LRTB",0,"R");$pdf->Cell(25,5,"$scOps","LRTB",0,"R");$pdf->Cell(25,5,"$scZos","LTB",0,"R");
$pdf->Cell(25,5,"$scRos","LRTB",1,"R");

          }
//zostava pohybov koniec


$pdf->SetFont('arial','',6);
$pdf->Cell(180,3,"Vytlaèil(a): $kli_uzmeno $kli_uzprie / $kli_uzid ","0",1,"L");

if( $copern == 10 )
          {
$pdf->Output("../tmp/$kli_vxcf.mespoh.$kli_vmes.pdf");
?> 
<script type="text/javascript">
  var okno = window.open("../tmp/<?php echo $kli_vxcf; ?>.mespoh.<?php echo $kli_vmes; ?>.pdf","_self");
</script>
<?php
          }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Mesaèné pohyby majetku</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    
</script>
</HEAD>
<BODY class="white" >

<?php 



?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Mesaèné pohyby majetku</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
