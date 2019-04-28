<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {

$zmtz=1*$_REQUEST['zmtz'];

$sys = 'SKL';
$urov = 2000;
$clsm = 960;
$uziv = include("../uziv.php");
if( !$uziv ) exit;


// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$html = 1*$_REQUEST['html'];
$bezcen = 1*$_REQUEST['bezcen'];
$bezcen = 1;

$plux = 1*$_REQUEST['plux'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$citwebs = include("../funkcie/citaj_webs.php");
$kli_vxcf=$webs_fir;
if( $kli_vxcf == 0 ) exit;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");
$citfir = include("../cis/citaj_fir.php");

//dodaci_tlac.php?copern=1&drupoh=1&page=1&cislo_dok=' + plux + '&ffd=0&tlacobj=1&zmtz=1'
//vytlacit dodaci a oznacit objednavku dodanu
if( $copern == 1 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete vytlaËiù dodacÌ list k objedn·vke  Ë.<?php echo $cislo_dok; ?> a oznaËiù objedn·vku ako dodan˙ ?") )
         {  var okno = window.close();  }
else
  var okno = window.open("dodaci_tlac.php?copern=2&drupoh=1&page=1&plux=<?php echo $cislo_dok; ?>&cislo_dok=<?php echo $cislo_dok; ?>&zmtz=1","_self");
</script>
<?php
exit;
}
if( $copern == 2 )
{


$tlacobj = 1;
$html=0;
$copern=1;
}
//koniec vytlacit dodaci a oznacit objednavku dodanu

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>
KoöÌk
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
<td>EuroSecom  -  DodacÌ list 

</td>
</tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/mzdtlac$kli_uzid.pdf")) { $soubor = unlink("../tmp/mzdtlac$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$sqlt = <<<mzdprc
(
   pox          decimal(10,0) DEFAULT 0,
   xdok         int DEFAULT 0,
   xice         decimal(10,0) DEFAULT 0,
   xodbm        decimal(10,0) DEFAULT 0,
   xsx1         decimal(10,0) DEFAULT 0,
   xcpl         int(10) DEFAULT 0,
   xcis         varchar(15) NOT NULL,
   xnat         VARCHAR(50) NOT NULL,
   xdph         DECIMAL(2,0) DEFAULT 20,
   xcep         decimal(10,4) DEFAULT 0,
   xced         decimal(10,2) DEFAULT 0,
   xmno         decimal(10,3) DEFAULT 0,
   xhdb         decimal(10,2) DEFAULT 0,
   xhdd         decimal(10,2) DEFAULT 0,
   xid          INT DEFAULT 0,
   xdatm        TIMESTAMP(14)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");



if( $copern == 1 ) {
$dsqlt = "UPDATE F$kli_vxcf"."_kosikobj SET xsx1=10000*$kli_vrok+$cislo_dok WHERE xdok = $cislo_dok ";
$dsql = mysql_query("$dsqlt");
                   }

if( $tlacobj == 1 )
  {
//zober z objednavok
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,xdok,xice,xodbm,xsx1,xcpl,xcis,xnat,xdph,xcep,xced,xmno,xhdb,xhdd,xid,xdatm FROM F$kli_vxcf"."_kosikobj ".
" WHERE xdok = $cislo_dok ".
"";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
//exit;
  }

//group vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 10,xdok,xice,xodbm,0,xcpl,xcis,xnat,xdph,xcep,xced,SUM(xmno),SUM(xhdb),SUM(xhdd),xid,xdatm  FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE xdok > 0 GROUP BY xdok".
"";
$dsql = mysql_query("$dsqlt");

if ( $drupoh == 1 )
  {
$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_mzdprcx".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_mzdprcx".$kli_uzid.".xcis=F$kli_vxcf"."_sklcis.cis".
" WHERE ( xdok > 0 ) ORDER BY pox,xcpl ";
  }



//echo $sqltt;
//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);


$strana=0;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);

if( $i == 0 )
  {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $riadok->xice ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$ico = $fir_riadok->ico; $dic = $fir_riadok->dic; $icd = $fir_riadok->icd;
$nai = $fir_riadok->nai; $na2 = $fir_riadok->na2; $uli = $fir_riadok->uli;
$psc = $fir_riadok->psc; $mes = $fir_riadok->mes; $tel = $fir_riadok->tel; $fax = $fir_riadok->fax; $em1 = $fir_riadok->em1;

$sqlfir = "SELECT * FROM ezak WHERE ez_id = $riadok->xid ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$ekto = $fir_riadok->ez_kto; $etel = $fir_riadok->ez_tel; $email = $fir_riadok->ez_ema; $odbx = 1*$fir_riadok->cxx1; $icoezak = 1*$fir_riadok->ez_ico;
$icox=$riadok->xice;

if( $icoezak == 99999999 ) { $odbx=1*$riadok->xodbm; }
  }

//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$chcemhlavicku=1;
//hlavicka
if( $html == 0  )
          {
if (File_Exists ('../dokumenty/FIR'.$kli_vxcf.'/hlavicka.jpg') AND $chcemhlavicku == 1 )
{
$rozmerhlv1="15"; $rozmerhlv2="10"; $rozmerhlv3="185"; $rozmerhlv4="20"; 

$pdf->Image('../dokumenty/FIR'.$kli_vxcf.'/hlavicka.jpg',$rozmerhlv1,$rozmerhlv2,$rozmerhlv3,$rozmerhlv4);
}
          }
//koniec hlavicka

$posun=$rozmerhlv2+$rozmerhlv4+5;

if( $chcemhlavicku == 1 ) { $pdf->SetY($posun); }

$pdf->SetFont('arial','',9);

if ( $copern == 1 AND $drupoh == 1 AND $tlacobj == 1 )  
{ 
$pdf->Cell(90,6,"DodacÌ list ËÌslo $riadok->xsx1 k objedn·vke Ë.$riadok->xdok ","LBT",0,"L"); 
$pdf->Cell(0,6,"DODACÕ LIST NIE JE DA“OV› DOKLAD.","RBT",1,"R");
}



$pdf->Cell(0,2," ","0",1,"R");
$pdf->Cell(30,5,"Dod·vateæ:","1",0,"L");$pdf->Cell(0,5,"$fir_fnaz, $fir_fuli, $fir_fmes, $fir_fpsc ","0",1,"L");
$pdf->Cell(0,5,"I»O: $fir_fico, DI»: $fir_fdic, I»DPH: $fir_ficd ","0",1,"L");

$pdf->Cell(0,1," ","T",1,"R");

$pdf->Cell(0,2," ","0",1,"R");
$pdf->Cell(30,5,"Odberateæ:","1",0,"L");$pdf->Cell(0,5,"$nai $na2, $uli, $mes, $psc ","0",1,"L");

if( $odbx > 0 ) { 

$sqlfir = "SELECT * FROM F$kli_vxcf"."_icoodbm WHERE ico = $icox AND odbm = $odbx ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$onai = $fir_riadok->onai; $ona2 = $fir_riadok->ona2; $ouli = $fir_riadok->ouli;
$opsc = $fir_riadok->opsc; $omes = $fir_riadok->omes; 

$pdf->Cell(30,5,"OdbernÈ miesto::","0",0,"L");$pdf->Cell(0,5,"$onai $ona2, $ouli, $omes, $opsc ","0",1,"L");

                }

$pdf->Cell(0,5,"I»O: $ico, DI»: $dic, I»DPH: $icd ","0",1,"L");

$pdf->Cell(0,1," ","T",1,"R");

$skdatum=SkDatum($riadok->xdatm);

$pdf->Cell(30,5,"Objednal:","0",0,"L");$pdf->Cell(0,5,"$ekto, Tel: $etel, Email: $email ","0",1,"L");
$pdf->Cell(30,5,"D·tum obj.:","0",0,"L");$pdf->Cell(0,5,"$skdatum","0",1,"L");

$pdf->Cell(0,2," ","0",1,"R");

$pdf->SetFont('arial','',9);

if ( $copern == 1 AND $drupoh == 1 )  {
$pdf->Cell(80,5,"Poloûka","1",0,"L");$pdf->Cell(30,5,"Mnoûstvo","1",0,"R");$pdf->Cell(30,5,"Cena bez/s DPH","1",0,"R");
$pdf->Cell(0,5,"Hodnota bez/s DPH","1",1,"R");
                                      }



     }
//koniec hlavicky j=0



if( $riadok->pox == 1 AND $drupoh == 1 )
{

$pdf->SetFont('arial','',8);

$nat=$riadok->nat;
$xcis=1*$riadok->xcis;
if( $riadok->xsx3 == 1 )
  {
$sqlttt = "SELECT * FROM F$kli_vxcf"."_sluzby WHERE slu = $xcis ORDER BY slu LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $natx=$riaddok->nsl;
 $xcisx=$riaddok->slu;
 }
$nat=$natx;
$xcis=$xcisx;

if( $xcis == 0 ) { $nat=$riadok->xnat; $xcis=0; }
  }

$ceny=$riadok->xcep." / ".$riadok->xced;
$hodn=$riadok->xhdb." / ".$riadok->xhdd;
if( $bezcen == 1 ) { $ceny=""; $hodn=""; }

$pdf->Cell(80,5,"$xcis $nat ","B",0,"L");$pdf->Cell(30,5,"$riadok->xmno","B",0,"R");$pdf->Cell(30,5,"$ceny","B",0,"R");
$pdf->Cell(0,5,"$hodn","B",1,"R");


}


if( $riadok->pox == 10 AND $drupoh == 1 )
{

$pdf->SetFont('arial','',9);

$hodns=$riadok->xhdb." / ".$riadok->xhdd;
if( $bezcen == 1 ) { $hodns=""; }

$pdf->Cell(140,5,"Celkom bez/s DPH","1",0,"L");
$pdf->Cell(0,5,"$hodns EUR","1",1,"R");


}





}
$i = $i + 1;
$j = $j + 1;
if( $j > 30 AND $html == 0 ) $j=0;

  }


if( $html == 0 ) { 

$poznx="";
$sqlfir = "SELECT * FROM F$kli_vxcf"."_kosiktext WHERE invt = $riadok->xdok ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $poznx = $fir_riadok->itxt; }

$polestr2 = explode("\r\n", $poznx);

if( $polestr2[0] != ''  )
    {
$rmc=0;
$ipole=1;
foreach( $polestr2 as $hodnota ) {

if( $ipole == 1 ) { $pdf->Cell(150,2," ","$rmc",1,"L"); $pdf->Cell(150,5,"Pozn·mka:","$rmc",1,"L"); }

$pdf->Cell(150,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }


if ( $copern == 1 AND $drupoh == 1 AND $tlacobj == 1 )  
{ 
$pdf->Cell(0,5," ","0",1,"R");
$pdf->Cell(90,18," ","LRT",1,"L");
$pdf->Cell(90,4,"TOVAR za odberateæa prevzal :d·tum, meno, peËiatka, podpis","LRB",1,"L");

}


$pdf->Output("../tmp/mzdtlac.$kli_uzid.pdf"); }


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

if( $html == 0 ) {
?> 

<script type="text/javascript">
  var okno = window.open("../tmp/mzdtlac.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
       
<?php
                 }
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
