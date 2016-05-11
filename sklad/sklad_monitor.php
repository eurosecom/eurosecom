<HTML>
<?php

do
{
$sys = 'SKL';
$urov = 1000;
$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];
$h_drp = $_REQUEST['h_drp'];
$h_dap = $_REQUEST['h_dap'];

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$datum = $_REQUEST['datum'];
$datumsql=SqlDatum($datum);
$datumsql00=$datumsql." 00:00";
$datumsql24=$datumsql." 23:59";
//echo $datum;

$sqlt = "DROP TABLE F".$kli_vxcf."_prcsklmon".$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = "DROP TABLE F".$kli_vxcf."_prcsklmonx".$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = "DROP TABLE F".$kli_vxcf."_prcsklmony".$kli_uzid;
$vysledok = mysql_query("$sqlt");

$vsql = "CREATE TABLE F".$kli_vxcf."_prcsklmon".$kli_uzid." SELECT * FROM F".$kli_vxcf."_sklpri WHERE cis > 0 AND datm >= '$datumsql00' AND datm <= '$datumsql24' ";
$vytvor = mysql_query("$vsql");
//echo $vsql;

$vsql = "INSERT INTO F".$kli_vxcf."_prcsklmon".$kli_uzid." SELECT * FROM F".$kli_vxcf."_sklvyd WHERE cis > 0 AND datm >= '$datumsql00' AND datm <= '$datumsql24' ";
$vytvor = mysql_query("$vsql");

$vsql = "INSERT INTO F".$kli_vxcf."_prcsklmon".$kli_uzid." SELECT * FROM F".$kli_vxcf."_sklpre WHERE cis > 0 AND datm >= '$datumsql00' AND datm <= '$datumsql24' ";
$vytvor = mysql_query("$vsql");

$vsql = "INSERT INTO F".$kli_vxcf."_prcsklmon".$kli_uzid." SELECT ".
" cpl, ume, dat, dok, doq, skl, poh, ico, fak, unk, poz, str, zak, ". 
" cis, mno, cep, id, sk2, datm, me2, mn2 ".
" FROM F".$kli_vxcf."_sklfak WHERE cis > 0 AND datm >= '$datumsql00' AND datm <= '$datumsql24' ";
$vytvor = mysql_query("$vsql");

$vsql = "INSERT INTO F".$kli_vxcf."_prcsklmon".$kli_uzid." SELECT ".
" cpl, ume, dat, dok, doq, skl, 999, ico, fak, unk, poz, str, zak, ". 
" cis, mno, cen, id, sk2, datm, me2, mn2 ".
" FROM F".$kli_vxcf."_sklpohall WHERE cis > 0 AND datm >= '$datumsql00' AND datm <= '$datumsql24' AND LEFT(poz,6) = 'DELETE' ";
$vytvor = mysql_query("$vsql");


$vsql = "UPDATE F".$kli_vxcf."_prcsklmon".$kli_uzid.",F".$kli_vxcf."_sklcph ".
" SET doq=drp WHERE  F".$kli_vxcf."_prcsklmon".$kli_uzid.".poh=F".$kli_vxcf."_sklcph.poh ";
$vytvor = mysql_query("$vsql");

//faktura
$vsql = "UPDATE F".$kli_vxcf."_prcsklmon".$kli_uzid." SET doq=21 WHERE poh = 51 ";
$vytvor = mysql_query("$vsql");

//dodak
$vsql = "UPDATE F".$kli_vxcf."_prcsklmon".$kli_uzid." SET doq=22 WHERE poh = 61 ";
$vytvor = mysql_query("$vsql");

//erp
$vsql = "UPDATE F".$kli_vxcf."_prcsklmon".$kli_uzid." SET doq=23 WHERE poh = 92 ";
$vytvor = mysql_query("$vsql");

//vymazane polozky
$vsql = "UPDATE F".$kli_vxcf."_prcsklmon".$kli_uzid." SET doq=999 WHERE poh = 999 ";
$vytvor = mysql_query("$vsql");

//sklpri 	cpl	ume	dat	dok	doq	skl	poh	ico	fak	unk	poz	str	zak	
//cis	mno	cen	id	sk2	datm	me2	mn2

//sklfak	cpl	ume	dat	dok	doq	skl	poh	ico	fak	unk	dol	prf	poz	str	zak	
//cis	nat	dph	mer	pop	mno	cen	cep	ced	id	sk2	datm	me2	mn2 

//sklpohall	cpl	ume	dat	dok	doq	skl	poh	ico	fak	unk	poz	str	zak	
//cis	mno	cen	id	sk2	datm	me2	mn2

?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Skladové kontroly</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
td.hvstup_bred { background-color:#ff6c6c; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
  </style>
<script type="text/javascript">

    function DokladPDF(doklad, drupoh)
    {
    window.open('poldok.php?copern=101&cislo_dok=' + doklad + '&drupoh=' + drupoh + '&page=1&page=1&tlacitR=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
    }

    function VytlacFakt(doklad)
    {
    var cislo_dok = doklad;
    window.open('../faktury/vstf_pdf.php?sysx=INE&rozuct=NIE&hladaj_dok=' + cislo_dok + '&copern=20&drupoh=1&page=&cislo_dok=' + cislo_dok + '&fff=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

    }

    function VytlacDod(doklad)
    {
    var cislo_dok = doklad;
    window.open('../faktury/vstf_pdf.php?sysx=INE&rozuct=NIE&hladaj_dok=' + cislo_dok + '&copern=20&drupoh=11&page=&cislo_dok=' + cislo_dok + '&fff=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

    }

    function VytlacErp(doklad)
    {
    var cislo_dok = doklad;
    window.open('../doprava/regpok_pdf.php?copern=20&drupoh=42&page=1&sysx=INE&cislo_dok=' + cislo_dok + '&regpok=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

    }
    
</script>
</HEAD>
<BODY class="white" >

<?php

if (File_Exists ("../tmp/prizdph$kli_vume.$kli_uzid.pdf")) { $soubor = unlink("../tmp/prizdph$kli_vume.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


if( $copern >= 40 OR $copern == 50 )
{
$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
}


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsklmon".$kli_uzid." WHERE dok > 0 ORDER BY dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);


$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$par=0;
$strana=1;
  while ($i <= $pol )
  {

//hlavicka
if ( $j == 0 )
{



if( $copern >= 40 AND $drupoh == 1) //html;
   {
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" colspan="3"><?php echo "Skladový monitor ".$datum; ?></td>
<td class="bmenu" colspan="3" align="right">
<?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?>
</td>
</tr>

<tr>
<td class="bmenu" width="10%">Dátum</td>
<td class="bmenu" width="10%" align="right">Doklad</td>
<td class="bmenu" width="10%" align="right">Pohyb</td>
<td class="bmenu" width="50%">Položka</td>
<td class="bmenu" width="10%" align="right">Cena</td>
<td class="bmenu" width="10%" align="right">Množstvo</td>
</tr>
<?php
   }



}
//koniec hlavicka j=0

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$datsk=SkDatum($hlavicka->dat);

$nat="";
$sqltt2 = "SELECT * FROM F$kli_vxcf"."_sklcis WHERE cis = $hlavicka->cis "; 
$sqldo2 = mysql_query("$sqltt2");
 if (@$zaznam=mysql_data_seek($sqldo2,0))
 {
 $riaddo2=mysql_fetch_object($sqldo2);
 $nat=$riaddo2->nat;
 }

?>


<?php

if( $copern >= 40 AND $drupoh == 1) //html;
     {

$hvstup="hvstup";
if( $par == 1 ) { $hvstup="hvstup_bsede"; }
?>
<tr>
<td class="<?php echo $hvstup; ?>" ><?php echo $datsk; ?></td>
<td class="<?php echo $hvstup; ?>" align="right">
<?php echo $hlavicka->dok; ?>
<?php if( $hlavicka->doq <= 4 )
  { ?>
<img src='../obr/zoznam.png' onClick="DokladPDF(<?php echo $hlavicka->dok;?>, 1)" width=15 height=10 border=0 title="Tlaè vybranej príjemky" >
<?php 
  } ?>
<?php if( $hlavicka->doq > 5 AND $hlavicka->doq < 20 )
  { ?>
<img src='../obr/zoznam.png' onClick="DokladPDF(<?php echo $hlavicka->dok;?>, 2)" width=15 height=10 border=0 title="Tlaè vybranej výdajky" ></a>

<?php 
  } ?>
<?php if( $hlavicka->doq == 5 )
  { ?>
<img src='../obr/zoznam.png' onClick="DokladPDF(<?php echo $hlavicka->dok;?>, 3)" width=15 height=10 border=0 title="Tlaè vybranej presunky " ></a>
<?php 
  } ?>

<?php if( $hlavicka->doq == 21 )
  { ?>
<img src='../obr/zoznam.png' onClick="VytlacFakt(<?php echo $hlavicka->dok;?>)" width=15 height=10 border=0 title="Tlaè vybranej faktúry " ></a>
<?php 
  } ?>

<?php if( $hlavicka->doq == 22 )
  { ?>
<img src='../obr/zoznam.png' onClick="VytlacDod(<?php echo $hlavicka->dok;?>)" width=15 height=10 border=0 title="Tlaè vybraného dodacieho listu " ></a>
<?php 
  } ?>

<?php if( $hlavicka->doq == 23 )
  { ?>
<img src='../obr/zoznam.png' onClick="" width=15 height=10 border=0 title="Doklad z ERP nemôžete znovu tlaèi" ></a>
<?php 
  } ?>

<?php if( $hlavicka->doq == 999 )
  { ?>
<img src='../obr/zoznam.png' onClick="" width=15 height=10 border=0 title="Vymazaná položka z dokladu <?php echo $hlavicka->dok;?>, nemôžete znovu tlaèi" ></a>
<?php 
  } ?>

/ <?php echo $hlavicka->id; ?>
</td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $hlavicka->poh; ?></td>
<td class="<?php echo $hvstup; ?>" ><?php echo $hlavicka->cis; ?> <?php echo $nat; ?>

<?php 

if( $hlavicka->doq == 21 )
    { 

$ico=0;
$sqltt2 = "SELECT * FROM F$kli_vxcf"."_fakodb WHERE dok = $hlavicka->dok "; 
$sqldo2 = mysql_query("$sqltt2");
 if (@$zaznam=mysql_data_seek($sqldo2,0))
 {
 $riaddo2=mysql_fetch_object($sqldo2);
 $ico=$riaddo2->ico;
 }

    }
if( $hlavicka->doq == 22 )
    { 

$ico=0;
$sqltt2 = "SELECT * FROM F$kli_vxcf"."_fakdol WHERE dok = $hlavicka->dok "; 
$sqldo2 = mysql_query("$sqltt2");
 if (@$zaznam=mysql_data_seek($sqldo2,0))
 {
 $riaddo2=mysql_fetch_object($sqldo2);
 $ico=$riaddo2->ico;
 }

    }

if( $hlavicka->doq == 21 OR $hlavicka->doq == 22 )
         { 

$nai="";
$sqltt2 = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $ico "; 
$sqldo2 = mysql_query("$sqltt2");
 if (@$zaznam=mysql_data_seek($sqldo2,0))
 {
 $riaddo2=mysql_fetch_object($sqldo2);
 $nai=$riaddo2->nai;
 }
?>
 / odberate¾ <?php echo $ico; ?> <?php echo $nai; ?>
<?php

         }

?>

</td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $hlavicka->cen; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $hlavicka->mno; ?></td>
</tr>
<?php
     }
//koniec copern>=40 html


}
$i = $i + 1;
$j = $j + 1;

if( $par == 0 )
{
$par=1;
}
else
{
$par=0;
}

//nebudem strankovat if( $j == 27 ) $j=0;

  }
//koniec hlavicky


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsklmon'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsklmonx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsklmony'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
