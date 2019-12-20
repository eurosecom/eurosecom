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

$cislo_dok = 1*$_REQUEST['cislo_dok'];

$zregpok = 1*$_REQUEST['zregpok'];
$akakasa = 1*$_REQUEST['akakasa'];


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
$citkuch = include("citaj_ubyt.php");

$citfir = include("../doprava/citaj_reg.php");

$skusobny=0;
if( $reg_id5 = 9999 ) { 
$skusobny=1; ;
//echo "Skusobny ".$skusobny;
//exit;
}


if( $kli_uzid != $reg_id1 AND $kli_uzid != $reg_id2 AND $kli_uzid != $reg_id3 AND $kli_uzid != $reg_id4 AND $kli_uzid != $reg_id5 )
{
?>
<script type="text/javascript" > 
alert ("ºutujem , nem·te prÌstupovÈ pr·va pre pr·cu s RegistraËnou pokladnicou .");
window.close();
</script>
exit;
<?php
}

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

//skakal som do regpok ale trvalo dlhsie
if( $ajregistracka == 11111 AND $zregpok == 0 )
{

//echo "idem na registracku";
//exit;
?> 

<script type="text/javascript">
  var okno = window.open("../doprava/regpok_pdf.php?copern=20&drupoh=42&page=1&sysx=INE&cislo_dok=<?php echo $cislo_dok; ?>&regpok=3","_self");
</script>


<?php
}
//koniec idem na registracku
//skakal som do regpok ale trvalo dlhsie

$polozky="ubytpredp";
$hlavicka="ubytpredh";
$hotelucet=0;
$ajubytovani=1;
if( $akakasa == 1 AND $drupoh == 2 )
{
$polozky="restpredp";
$hlavicka="restpredh";
$ajubytovani=0;
}
if( $akakasa == 1 AND $drupoh == 4 )
{
$polozky="restdodp";
$hlavicka="restdodh";
$hotelucet=1;
$ajregistracka=0;
}

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_ubytprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

if( $akakasa == 0 )
  {
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_ubytprc'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_ubytpredp WHERE dok=$cislo_dok ";
$vytvor = mysql_query("$vsql");
  }

if( $akakasa == 1 AND $drupoh == 2 )
  {
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_ubytprc'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_restpredp WHERE dok=$cislo_dok ";
$vytvor = mysql_query("$vsql");

$sqltt = "SELECT * FROM F$kli_vxcf"."_ubytprc".$kli_uzid." WHERE dok=$cislo_dok ";
$tov = mysql_query("$sqltt");
if( $tov) { $pcpol = mysql_num_rows($tov); }

if( $pcpol == 0 ) 
      { 
//echo "Pr·zdny doklad Ë.".$cislo_dok; 
?>
<script type="text/javascript">
window.open('../restauracia/vsob_u.php?sysx=INE&hladaj_uce=2&rozuct=NIE&copern=8&drupoh=2&cislo_dok=<?php echo $cislo_dok; ?>&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT',
 '_self', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
</script>
<?php
exit; 
      } 
  }

if( $akakasa == 1 AND $drupoh == 4 )
  {
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_ubytprc'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_restdodp WHERE dok=$cislo_dok ";
$vytvor = mysql_query("$vsql");
  }

$sql = "ALTER TABLE F".$kli_vxcf."_ubytprc".$kli_uzid." ADD dmxb DECIMAL(10,0) DEFAULT 0 AFTER cpl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_ubytprc".$kli_uzid." ADD sced DECIMAL(10,2) DEFAULT 0 AFTER rced";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_ubytprc".$kli_uzid." ADD sdph DECIMAL(10,2) DEFAULT 0 AFTER rced";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_ubytprc".$kli_uzid." ADD scep DECIMAL(10,2) DEFAULT 0 AFTER rced";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_ubytprc".$kli_uzid." ADD sce0 DECIMAL(10,2) DEFAULT 0 AFTER sced";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_ubytprc".$kli_uzid." ADD sce2 DECIMAL(10,2) DEFAULT 0 AFTER sce0";
$vysledek = mysql_query("$sql");


$sqlttt = 'DROP TABLE F'.$kli_vxcf.'_rozpdph'.$kli_uzid;
$vysledok = mysql_query("$sqlttt");

$sqlt = <<<restprac
(
   zk2          DECIMAL(10,2) DEFAULT 0,
   dn2          DECIMAL(10,2) DEFAULT 0,
   sp2          DECIMAL(10,2) DEFAULT 0,
   zk1          DECIMAL(10,2) DEFAULT 0,
   dn1          DECIMAL(10,2) DEFAULT 0,
   dsp1          DECIMAL(10,2) DEFAULT 0,
   zk0          DECIMAL(10,2) DEFAULT 0
);
restprac;

$sqlttt = 'CREATE TABLE F'.$kli_vxcf.'_rozpdph'.$kli_uzid.$sqlt;
$vysledok = mysql_query("$sqlttt");

$sqlttt = "INSERT INTO F".$kli_vxcf."_rozpdph$kli_uzid ( zk2 ) VALUES ( 0 ) ";
$vysledok = mysql_query("$sqlttt");

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Doklad PDF</title>
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
<?php if( $drupoh == 2 ) { echo "Predajn˝ doklad PDF "; } ?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/restpre_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/restpre_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$neparne=1;


if ( $copern == 20 )
  {

//sumar pred
$dsqlt = "UPDATE F$kli_vxcf"."_ubytprc$kli_uzid "." SET dmxb=25, sced=jmno*rced ";
$dsql = mysql_query("$dsqlt");


//sumar za vsetko 
$dsqlt = "INSERT INTO F$kli_vxcf"."_ubytprc$kli_uzid "." SELECT".
" dok,0,29,'',999999,'','',0,'','',$fir_dph2,0,0,0,0,0,SUM(hodd),0,0,0,0,id,datm,0,0 ".
" FROM F$kli_vxcf"."_$hlavicka ".
" WHERE dok=$cislo_dok".
" GROUP BY dok".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

//precitaj datm z dokladu
$sqlpoktt = "SELECT datm, denna FROM F$kli_vxcf"."_$hlavicka WHERE dok = $cislo_dok";
$sqlpok = mysql_query("$sqlpoktt"); 
  if (@$zaznam=mysql_data_seek($sqlpok,0))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
  $datmx = $riadokpok->datm;
  $ruc = 1*$riadokpok->denna;
  }

$datcas=$datmx;
$pole = explode(" ", $datcas);
$datdat=$pole[0];
$cascas=substr($pole[1],0,5);
$pole = explode("-", $datdat);
$datcas_sk=$pole[2].".".$pole[1].".".$pole[0]." ".$cascas;

$akydoklad=1;
$plkarta=0;
$regpok=3;
$pcpol=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_ubytprc".$kli_uzid." WHERE rcis = $reg_vklad ";
$tov = mysql_query("$sqltt");
if( $tov) { $pcpol = mysql_num_rows($tov); }
if( $pcpol > 0 ) $akydoklad=2;
$pcpol=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_ubytprc".$kli_uzid." WHERE rcis = $reg_vyber ";
$tov = mysql_query("$sqltt");
if( $tov) { $pcpol = mysql_num_rows($tov); }
if( $pcpol > 0 ) $akydoklad=3;
$pcpol=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_ubytprc".$kli_uzid." WHERE rcis = $reg_uhrfa ";
$tov = mysql_query("$sqltt");
if( $tov) { $pcpol = mysql_num_rows($tov); }
if( $pcpol > 0 ) $akydoklad=4;
$pcpol=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_ubytprc".$kli_uzid." WHERE rcis = $reg_plkar ";
$tov = mysql_query("$sqltt");
if( $tov) { $pcpol = mysql_num_rows($tov); }
if( $pcpol > 0 ) $plkarta=1;

$plkartatext = "";
if( $plkarta == 1 )
  {
$sqlfirx = "SELECT * FROM F$kli_vxcf"."_ubytprc".$kli_uzid." WHERE rcis = $reg_plkar ";
$reg_vysledokx = mysql_query($sqlfirx);
$reg_riadokx=mysql_fetch_object($reg_vysledokx);

$plkartatext = $reg_riadokx->rnaz;

  }


$sqltt = "DELETE FROM F$kli_vxcf"."_ubytprc".$kli_uzid." WHERE rcis = $reg_plkar ";
$tov = mysql_query("$sqltt");

//$akydoklad=1;

if( $akakasa == 0 ) {
$sqltt = "SELECT * FROM F$kli_vxcf"."_ubytprc$kli_uzid ".
" LEFT JOIN F$kli_vxcf"."_$hlavicka".
" ON F$kli_vxcf"."_ubytprc$kli_uzid.dok=F$kli_vxcf"."_$hlavicka.dok".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$hlavicka.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN klienti".
" ON F$kli_vxcf"."_$hlavicka.id=klienti.id_klienta".
" WHERE F$kli_vxcf"."_ubytprc$kli_uzid.dok = $cislo_dok ".
" ORDER BY dmxb,cpl ";
                    }

if( $akakasa == 1 ) {
$sqltt = "SELECT * FROM F$kli_vxcf"."_ubytprc$kli_uzid ".
" LEFT JOIN F$kli_vxcf"."_$hlavicka".
" ON F$kli_vxcf"."_ubytprc$kli_uzid.dok=F$kli_vxcf"."_$hlavicka.dok".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$hlavicka.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN klienti".
" ON F$kli_vxcf"."_$hlavicka.id=klienti.id_klienta".
" WHERE F$kli_vxcf"."_ubytprc$kli_uzid.dok = $cislo_dok ".
" ORDER BY dmxb,dfak,cpl ";
                    }

  }


//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//exit;

$strana=0;
$j=0;           
$i=0;

$js=0;
$stranast=1;
$novastrana=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);


$dat_sk=SkDatum($riadok->dat);
$dap_sk=SkDatum($riadok->dap);
$dak_sk=SkDatum($riadok->dak);
if( $dap_sk == '00.00.0000' ) $dap_sk="";
if( $dak_sk == '00.00.0000' ) $dak_sk="";

//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$pdf->SetFont('arial','',12);


$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$niejehlavicka=1;
if (File_Exists ('../dokumenty/FIR'.$kli_vxcf.'/hlavicka.jpg'))
{
$niejehlavicka=0;
$rozmerhlv1="15"; $rozmerhlv2="10"; $rozmerhlv3="180"; $rozmerhlv4="20"; 
if( $esoplast == 1 ) { $rozmerhlv1="15"; $rozmerhlv2="10"; $rozmerhlv3="180"; $rozmerhlv4="14";  }

$pdf->Image('../dokumenty/FIR'.$kli_vxcf.'/hlavicka.jpg',$rozmerhlv1,$rozmerhlv2,$rozmerhlv3,$rozmerhlv4);
}


$mini=0;
$pdf->SetY(30);
if( $mini == 0 )
          {
if( $hotelucet == 0 )
  {
$pdf->Cell(45,6,"Predajn˝ doklad","1",0,"L");$pdf->Cell(45,6,"»Ìslo: $riadok->dencis / $riadok->dok","1",0,"L");$pdf->Cell(90,6,"zo dÚa : $datcas_sk ","1",1,"L");
$pdf->Cell(180,3,"     ","0",1,"L");
  }
if( $hotelucet == 1 )
  {
$pdf->Cell(45,6,"Hotelov˝ ˙Ëet","1",0,"L");$pdf->Cell(45,6,"»Ìslo: $riadok->dok","1",0,"L");$pdf->Cell(90,6,"zo dÚa : $datcas_sk ","1",1,"L");
$pdf->Cell(180,3,"     ","0",1,"L");
  }
$pdf->Cell(180,6,"$fir_fnaz, $fir_fuli $fir_fcdm, $fir_fpsc $fir_fmes","0",1,"L");
$pdf->Cell(180,6,"I»O: $fir_fico, DI»: $fir_fdic, I»DPH: $fir_ficd","0",1,"L");
$pdf->Cell(90,6,"Registrovan˝: $fir_obreg","0",1,"L");



$pdf->Cell(90,6,"Prev·dzka: $reg_prv","0",1,"L");
if( $hotelucet == 0 )
  {
if( $riadok->udr <= 1 AND $plkarta == 0 ) { $pdf->Cell(90,6,"DKP: $reg_dkp ZAPLATEN… v HOTOVOSTI.","0",1,"L"); }
if( $riadok->udr <= 1 AND $plkarta == 1 ) { $pdf->Cell(90,6,"DKP: $reg_dkp ZAPLATEN… PLATOBNOU KARTOU.","0",1,"L"); }
if( $riadok->udr == 2 ) { $pdf->Cell(90,6,"DKP: $reg_dkp PLATBA KARTOU.","0",1,"L"); }
  }

if( $riadok->chst != 0 )
   {

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_ubythostia WHERE oc = $riadok->chst ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie=$riaddok->prie;
  $meno=$riaddok->meno;
  }

$pdf->Cell(180,1,"","B",1,"L");
$pdf->Cell(90,6,"UbytovanÌ hostia - Ë.izby $riadok->cizb v obdobÌ od $dap_sk do $dak_sk","0",1,"L"); 
$pdf->Cell(90,6,"1. $prie $meno ","0",1,"L"); 

$ubythostia1="Ë.izby $riadok->cizb od $dap_sk do $dak_sk";
$ubythostia2="1. $prie $meno ";

$sqltth = "SELECT * FROM F$kli_vxcf"."_ubytdalsihostia ".
" LEFT JOIN F$kli_vxcf"."_ubythostia".
" ON F$kli_vxcf"."_ubytdalsihostia.dhst=F$kli_vxcf"."_ubythostia.oc".
" WHERE dok = $riadok->dok ORDER BY dhst";
$sqlh = mysql_query("$sqltth");

$cpolh = mysql_num_rows($sqlh);
$ih=0;
$dc=2;

   while ($ih < $cpolh )
   {
  if (@$zaznam=mysql_data_seek($sqlh,$ih))
  {
$riadokh=mysql_fetch_object($sqlh);

$pdf->Cell(90,6,"$dc. $riadokh->prie $riadokh->meno ","0",1,"L"); 

  }
$ih=$ih+1;
$dc=$dc+1;
   }


   }
//koniec tlac ubytovanych

if( $riadok->cstl != 0 AND $drupoh == 2 )
   {

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_reststoly WHERE cstl = $riadok->cstl ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $nazstola=$riaddok->nstl;
  }

$pdf->Cell(180,1,"","B",1,"L");
$pdf->Cell(90,6,"StÙl: $nazstola Obsluha: $kli_uzprie","0",1,"L"); 

   }
//koniec tlac stola

if( $reg_txtp != '' )
  {

$pdf->Cell(180,2,""," ",1,"L");

$pole = explode("\r\n", $reg_txtp);

$ipole=1;
foreach( $pole as $hodnota ) { 
if( $hodnota != '' ) { $pdf->Cell(70,5,"$hodnota","0",1,"L"); }
$ipole=$ipole+1;
}

$pdf->Cell(180,2,""," ",1,"L");

  }

$pdf->Cell(180,1,"","B",1,"L");
$pdf->Cell(180,1,"","0",1,"L");

$pdf->SetFont('arial','',6);

$pdf->Cell(90,5,"Poloûka","0",0,"L");$pdf->Cell(10,5,"%DPH","0",0,"R");
$pdf->Cell(20,5,"JCsDPH","0",0,"R");$pdf->Cell(15,5,"Mnoûstvo","0",0,"R");$pdf->Cell(40,5,"SPOLUsDPH","0",1,"R");

$pdf->Cell(180,1,"","B",1,"L");
$pdf->Cell(180,1,"","0",1,"L");


$cislo_dokhl=$riadok->dok;


          }
//koniec mini=0

$pdf->SetFont('arial','',6);


if( $copern == 20 )
{

}

if( $akakasa == 1 AND $drupoh == 4 ) { $ruc=1; }

//vymaz pracovne subory a stary blocek
if( $ruc == 0 )
   {
$kamsubor=$reg_adreg."blocek.txt";
$nazsub="registruj";
$infoful=$reg_adreg."info.ful";
if (File_Exists ("../tmp/$nazsub")) { $soubor = unlink("../tmp/$nazsub"); }
if (File_Exists ("$kamsubor")) { $soubor = unlink("$kamsubor"); }
if (File_Exists ("$infoful")) { $soubor = unlink("$infoful"); }
$soubor = fopen("../tmp/$nazsub", "a+");
   }

     }
//koniec hlavicky j=0




if( $riadok->dmxb == 25 )
{

$pdf->SetFont('arial','',8);
//dok  cpl  rnaz  druhp  iban  twib  jmno  ksy  rcis  hodp  rcep  uce  ico  id  datm   

$vaha=1*$riadok->rmno;
$mnozstvo=1*$riadok->jmno;

if( $riadok->xdph == $fir_dph2 ) { $dsqlt = "UPDATE F$kli_vxcf"."_rozpdph$kli_uzid "." SET sp2=sp2+($riadok->rced*$riadok->jmno) "; }
if( $riadok->xdph == $fir_dph1 ) { $dsqlt = "UPDATE F$kli_vxcf"."_rozpdph$kli_uzid "." SET dsp1=dsp1+($riadok->rced*$riadok->jmno) "; }
if( $riadok->xdph == 0         ) { $dsqlt = "UPDATE F$kli_vxcf"."_rozpdph$kli_uzid "." SET zk0=zk0+($riadok->rced*$riadok->jmno) "; }
$dsql = mysql_query("$dsqlt");

$pdf->Cell(90,5,"$riadok->rnaz","0",0,"L");$pdf->Cell(10,5,"$riadok->xdph","0",0,"R");

$pdf->Cell(20,5,"$riadok->rced","0",0,"R");$pdf->Cell(15,5,"$mnozstvo ks","0",0,"R");$pdf->Cell(40,5,"$riadok->sced","0",1,"R"); 

$js=$js+1;

//zaregistruj uhrada faktury akydoklad=4
if( $ruc == 0 AND $akydoklad == 4 )
     {
//echo "po polozke";

if( $j == 0 )
  {
$text = "B";
fwrite($soubor, $text);
  }

$Cislo=$riadok->sced+"";
$sHodnota=sprintf("%0.2f", $Cislo);
$sHodnota9=strrev("         ".$sHodnota);
$sHodnota9=substr($sHodnota9,0,9);
$sHodnota9=strrev($sHodnota9);

$nsl=$riadok->rnaz."                                                                    ";                                     
$nsl38=substr($nsl,0,38);

if( $riadok->sced > 0 )
  {
  $text = "0"."    ".$sHodnota9."Eur";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = $nsl38;
  $text = $text."\r\n";
  fwrite($soubor, $text);
  }
if( $riadok->sced < 0 )
  {
  $text = "9A"."    ".$sHodnota9."Eur";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = $nsl38;
  $text = $text."\r\n";
  fwrite($soubor, $text);
  }
     }
//koniec uhrada faktury akydoklad=4


//zaregistruj vyber z pokladnice akydoklad=3
if( $ruc == 0 AND $akydoklad == 3 )
     {
//echo "po polozke";

if( $j == 0 )
  {
$text = "v";
fwrite($soubor, $text);
  }

$Cislo=$riadok->sced+"";
$sHodnota=sprintf("%0.2f", $Cislo);
$sHodnota9=strrev("         ".$sHodnota);
$sHodnota9=substr($sHodnota9,0,9);
$sHodnota9=strrev($sHodnota9);


if( $riadok->sced != 0 )
  {
  $text = "P1"."    ".$sHodnota9."Eur";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "V˝ber z pokladnice.                 ";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  }
     }
//koniec zaregistruj vyber z pokladnice akydoklad=3

//zaregistruj vklad do pokladnice akydoklad=2
if( $ruc == 0 AND $akydoklad == 2 )
     {
//echo "po polozke";

if( $j == 0 )
  {
$text = "V";
fwrite($soubor, $text);
  }

$Cislo=$riadok->sced+"";
$sHodnota=sprintf("%0.2f", $Cislo);
$sHodnota9=strrev("         ".$sHodnota);
$sHodnota9=substr($sHodnota9,0,9);
$sHodnota9=strrev($sHodnota9);


if( $riadok->sced != 0 )
  {
  $text = "P1"."    ".$sHodnota9."Eur";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "Vklad do pokladnice.                 ";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  }
     }
//koniec zaregistruj vklad do pokladnice akydoklad=2

//zaregistruj polozku dokladu akydoklad=1
if( $ruc == 0 AND $akydoklad == 1 )
     {
//echo "po polozke";

if( $j == 0 )
  {
$text = "b";
fwrite($soubor, $text);

if( $ajubytovani == 1 )
     {
  $text = $ubythostia1;
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = $ubythostia2;
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "                                        ";
  $text = $text."\r\n";
  fwrite($soubor, $text);
     }    

if( $ajubytovani == 0 )
     {
  $text = "StÙl: ".$nazstola." Obsluha: ".$kli_uzprie." ";
  $text = $text."\r\n";
  fwrite($soubor, $text);
     } 


  $text = "Mnoûstvo        jCsDph DPH  Hodnota Eur";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

$nsl=$riadok->rnaz."                                                                    ";                                     
$nsl38=substr($nsl,0,38);


$mer="ks           ";                                     
$mer2=substr($mer,0,2);

$Cislo=$riadok->sced+"";
$sHodnota=sprintf("%0.2f", $Cislo);
$sHodnota9=strrev("         ".$sHodnota);
$sHodnota9=substr($sHodnota9,0,9);
$sHodnota9=strrev($sHodnota9);

$Cislo=$riadok->rced+"";
$sCed=sprintf("%0.4f", $Cislo);
$sCed12=strrev("         ".$sCed);
$sCed12=substr($sCed12,0,12);
$sCed12=strrev($sCed12);

$Cislo=$mnozstvo+"          ";
$sMno=sprintf("%0.3f", $Cislo);
$sMno10=strrev("         ".$sMno);
$sMno10=substr($sMno10,0,8);
$sMno8=strrev($sMno10);


if( $mnozstvo > 0 )
  {
  if( $riadok->xdph == $fir_dph2 ) { $text = $nsl38."\r\n".$sMno8.$mer2.$sCed12."1"."    ".$sHodnota9; }
  if( $riadok->xdph == $fir_dph1 ) { $text = $nsl38."\r\n".$sMno8.$mer2.$sCed12."2"."    ".$sHodnota9; }
  if( $riadok->xdph == 0         ) { $text = $nsl38."\r\n".$sMno8.$mer2.$sCed12."3"."    ".$sHodnota9; }
  $text = $text."\r\n";
  fwrite($soubor, $text);
  }
if( $mnozstvo < 0 )
  {
  if( $riadok->xdph == $fir_dph2 ) { $text = $nsl38."\r\n".$sMno8.$mer2.$sCed12."4C"."    ".$sHodnota9; }
  if( $riadok->xdph == $fir_dph1 ) { $text = $nsl38."\r\n".$sMno8.$mer2.$sCed12."5C"."    ".$sHodnota9; }
  if( $riadok->xdph == 0         ) { $text = $nsl38."\r\n".$sMno8.$mer2.$sCed12."6C"."    ".$sHodnota9; }
  $text = $text."\r\n";
  fwrite($soubor, $text);
  }
     }
//koniec zaregistruj polozku dokladu akydoklad=1

}
//koniec dmxb=25


if( $riadok->dmxb == 29 )
{

$dsqlt = "UPDATE F$kli_vxcf"."_rozpdph$kli_uzid "." SET zk2=100*(sp2/(100+$fir_dph2)) "; 
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_rozpdph$kli_uzid "." SET dn2=sp2-zk2 "; 
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_rozpdph$kli_uzid "." SET zk1=100*(dsp1/(100+$fir_dph1)) "; 
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_rozpdph$kli_uzid "." SET dn1=dsp1-zk1 "; 
$dsql = mysql_query("$dsqlt");

$pdf->SetFont('arial','',10);
$pdf->Cell(20,5," ","0",1,"R");

//rozpis dph 
$zk2=1; $dn2=0; $sp2=0; $zk0=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_rozpdph$kli_uzid ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);

$pdf->Cell(72,5,"Rozpis DPH","T",0,"L");$pdf->Cell(15,5,"%DPH","T",0,"R");
$pdf->Cell(31,5,"Z·klad","T",0,"R");$pdf->Cell(31,5,"DaÚ","T",0,"R");$pdf->Cell(31,5,"Spolu","T",1,"R");


if( $riaddok->zk2 != 0 )
 {
$pdf->Cell(72,5,"","0",0,"L");$pdf->Cell(15,5,"$fir_dph2","0",0,"R");
$pdf->Cell(31,5,"$riaddok->zk2","0",0,"R");$pdf->Cell(31,5,"$riaddok->dn2","0",0,"R");$pdf->Cell(31,5,"$riaddok->sp2","0",1,"R");

 }
if( $riaddok->zk1 != 0 )
 {
$pdf->Cell(72,5,"","0",0,"L");$pdf->Cell(15,5,"$fir_dph1","0",0,"R");
$pdf->Cell(31,5,"$riaddok->zk1","0",0,"R");$pdf->Cell(31,5,"$riaddok->dn1","0",0,"R");$pdf->Cell(31,5,"$riaddok->dsp1","0",1,"R");

 }
if( $riaddok->zk0 != 0 )
 {
$pdf->Cell(72,5,"","0",0,"L");$pdf->Cell(15,5,"0","0",0,"R");
$pdf->Cell(31,5,"$riaddok->zk0","0",0,"R");$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5,"$riaddok->zk0","0",1,"R");

 }

  }
//koniec rozpis dph


$sqlttt = 'DROP TABLE F'.$kli_vxcf.'_rozpdph'.$kli_uzid;
$vysledok = mysql_query("$sqlttt");

$pdf->Cell(180,2," ","0",1,"R");

$pdf->SetFont('arial','B',12);
$pdf->Cell(180,5," ","T",1,"R");
$pdf->Cell(72,5,"Celkom hodnota $mena1 ","0",0,"L");$pdf->Cell(15,5," ","0",0,"R");
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5,"$riadok->sced $mena1","0",1,"R");

$reghodnota=1*$riadok->sced;

}
//koniec dmxb=29



}
$i = $i + 1;
$j = $j + 1;


//nova strana
if( $js >= 20 AND $stranast == 1 ) { $novastrana=1; }
if( $js >= 40 AND $stranast > 1 ) { $novastranna=1; }
if( $novastrana == 1 ) 
{
$stranast=$stranast+1;
$pdf->Cell(180,2," ","0",1,"L");
$pdf->Cell(180,5,"PokraËovanie dokladu na $stranast.strane","0",1,"L");

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$pdf->Cell(180,5,"$stranast.strana dokladu Ë. $rsluz->dok","0",1,"L");
$pdf->Cell(180,2," ","0",1,"L");

$js=0;
$novastrana=0;
}
//koniec nova strana


  }


//zaregistruj po doklade
if( $ruc == 0 AND $akydoklad >= 1 )
     {
//echo "po doklade";
//exit;

$Cislo=$reghodnota+"";
$sCHodnota=sprintf("%0.2f", $Cislo);

$Cislo=$reghodnota+"";
$sHodnota=sprintf("%0.2f", $Cislo);
$sHodnota16=strrev("                   ".$sHodnota);
$sHodnota16=substr($sHodnota16,0,16);
$sHodnota16=strrev($sHodnota16);


//pokl.doklad
if( $regpok >= 0 AND $akydoklad == 1 )
  {
  $text = "k".$sHodnota16;
  $text = $text."\r\n";
  fwrite($soubor, $text);

if( $plkarta == 1 ) { 

  $text = $plkartatext;   $text = $text."\r\n";   fwrite($soubor, $text); 

  $text = "P2".$sHodnota16;
  $text = $text."\r\n";
  fwrite($soubor, $text);

                    }

  $text = $reg_txtz;
  $text = $text."\r\n";
  fwrite($soubor, $text);

  $text = "e";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

//vklad
if( $regpok >= 0 AND $akydoklad == 2 )
  {
  $text = "e";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

//vyber
if( $regpok >= 0 AND $akydoklad == 3 )
  {
  $text = "e";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

//faktura
if( $regpok >= 0 AND $akydoklad == 4 )
  {
  $text = "k".$sHodnota16;
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "e";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

  fclose($soubor);
  if (File_Exists ("../tmp/registruj$cislo_dok")) { $soubor = unlink("../tmp/registruj$cislo_dok"); }
  copy("../tmp/registruj", "../tmp/registruj$cislo_dok");
  if (File_Exists ("../tmp/registruj$cislo_dok")) { copy("../tmp/registruj$cislo_dok", "$kamsubor"); }

     }
//koniec zaregistruj po doklade

$pdf->Cell(31,5," ","0",1,"L");
if( $plkarta == 1 ) { $pdf->Cell(31,5,"$plkartatext.","0",1,"L"); }

//ak zaregistroval
$jeinfoful=0;
$cakaj=1;
$netestinfo=1;
//$ajregistracka=0;
  while ( $cakaj <= 100000 AND $ruc == 0 AND $ajregistracka == 1 AND $netestinfo == 0 )
    {
exit;
if (File_Exists ("$infoful")) 
{
$cakaj=100000;
$jeinfoful=1;

$x_dok=0; 
$x_datcas=Date ("Y-m-d H:i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$isubor = fopen("$infoful", "r");
$ii=1;
while (! feof($isubor))
  {
  $riadok = fgets($isubor, 500);

  if( $ii == 2  ) { $x_dok = 1*trim($riadok); }
  if( $ii == 21 ) { $x_dat = trim($riadok); }
  if( $ii == 22 ) { $x_cas = trim($riadok); }

$ii=$ii+1;
}

$pole = explode(",", $x_dat);
$x_datcas=$pole[2]."-".$pole[1]."-".$pole[0]." ".$x_cas;


if( $x_dok > 0 OR $akydok > 1 )
  {
$regcbl = mysql_query("UPDATE F$kli_vxcf"."_$hlavicka SET dencis='$x_dok', denna='$reg_cdu', datm='$x_datcas' WHERE dok = $cislo_dok"); 

$regcbl = mysql_query("UPDATE F$kli_vxcf"."_dopdkp SET cbl='$x_dok'+1 "); 
  }

$pdf->Cell(31,5,"Doklad zaregistrovan˝ do FM.","0",1,"L");

}
//existuje infoful

if( $cakaj > 20000 AND $jeinfoful == 0 )
{
if (File_Exists ("$kamsubor")) { $soubor = unlink("$kamsubor"); }

$oznam=0;
if( $oznam == 1 )   {
?>
<script type="text/javascript">
alert ("ProblÈm s tlaËou alebo registr·ciou poslednÈho dokladu !\r 1.Zapnite fiök·lnu tlaËiareÚ.\r 2.Sk˙ste vytlaËiù kÛpiu poslednÈho dokladu kPD.");
window.close();
</script>
<?php
exit;
                    }
if( $oznam == 1 )   {
$jeinfoful=1;
$regcbl = mysql_query("UPDATE F$kli_vxcf"."_$hlavicka SET  dencis='$reg_cbl', denna='$reg_cdu'  WHERE dok = $cislo_dok"); 
$regcbl = mysql_query("UPDATE F$kli_vxcf"."_dopdkp SET cbl=cbl+1 ");
//echo "vvvvvv";
//exit;
                    }
}
//neexistuje infoful

$cakaj = $cakaj + 1;
exit;
     }
//koniec ak zaregistroval testovanie info



if( $reg_txtz != '' )
  {
$pdf->SetFont('arial','',12);

$pdf->Cell(180,2,""," ",1,"L");

$pole = explode("\r\n", $reg_txtz);

$ipole=1;
foreach( $pole as $hodnota ) { 
if( $hodnota != '' ) { $pdf->Cell(70,5,"$hodnota","0",1,"L"); }
$ipole=$ipole+1;
}

$pdf->Cell(180,2,""," ",1,"L");

  }

//ak hotelovy ucet
if( $hotelucet == 1 )
  {
$pdf->SetFont('arial','',10);
$pdf->Cell(90,6," ","0",1,"L"); 
$pdf->Cell(60,6,"Hotelov˝ ˙Ëet - Ë.izby $riadok->cizb ","1",0,"L");$pdf->Cell(60,6,"      ","LRT",1,"L"); 
$pdf->Cell(60,6,"$prie $meno ","1",0,"L");$pdf->Cell(60,6,"podpis ","LRB",1,"L"); 

  
  }

//ked mam skusobny rezim lebo vtedy neda info.ful
if( ( $skusobny == 1 OR $netestinfo == 1 ) AND $ruc == 0 )
  {
//echo "idem";
$regcbl = mysql_query("UPDATE F$kli_vxcf"."_$hlavicka SET  dencis='$reg_cbl', denna='$reg_cdu'  WHERE dok = $cislo_dok"); 
$regcbl = mysql_query("UPDATE F$kli_vxcf"."_dopdkp SET cbl=cbl+1 ");
$pdf->Cell(31,5,"Doklad zaregistrovan˝ do FM.","0",1,"L");
  }

$pdf->Output("$outfilex");


$hnedtlac = 1*$_REQUEST['hnedtlac'];
if( $hnedtlac == 1 )
{
?> 
<script type="text/javascript">
window.open('../restauracia/resttouchme.php?copern=1&drupoh=1&page=1&spo=0&pds=0&zhs=1&bolaplatba=1', '_self' );
</script>
<?php
exit;
}
if( $hnedtlac == 0 )
{
?>
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<?php
}

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
