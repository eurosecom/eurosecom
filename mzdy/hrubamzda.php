<HTML>
<?php

do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if(!isset($fort)) $fort = 1;

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

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];





$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$nastav = $_REQUEST['nastav'];

$cislo_oc = $_REQUEST['cislo_oc'];
$h_obdp = 1*$_REQUEST['h_obdp'];
$h_obdk = 1*$_REQUEST['h_obdk'];
if( $h_obdp == 0 ) $h_obdp=1;
if( $h_obdk == 0 ) $h_obdk=12;
$vyb_ume=$h_obdk.".".$kli_vrok;
$vyb_umep=$h_obdp.".".$kli_vrok;
$vyb_umek=$h_obdk.".".$kli_vrok;


//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";



//pre vypocet vytvor pracovny subor
if( $copern == 10 OR $copern == 20 OR $copern == 30 )
{

//prac.subor
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   dni          DECIMAL(10,2) DEFAULT 0,
   dnn          DECIMAL(10,2) DEFAULT 0,
   hru          DECIMAL(10,2) DEFAULT 0,
   nem          DECIMAL(10,2) DEFAULT 0,
   fon          DECIMAL(10,2) DEFAULT 0,
   fo2          DECIMAL(10,2) DEFAULT 0,
   spo          DECIMAL(10,2) DEFAULT 0,
   stx          DECIMAL(10,0) DEFAULT 0,
   umx          DECIMAL(10,4) DEFAULT 0,
   konx2        DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid.$sqlt;
//$vytvor = mysql_query("$vsql");


//zober z mzdkun
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
" 0,0,0,0,0,0,0,0,'$vyb_umep',".
" 1".
" FROM F$kli_vxcf"."_mzdkun".
" WHERE oc > 0 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober dni odpracovane
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
" dni,0,0,0,0,0,0,0,ume,".
" 1".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume >= $vyb_umep AND ume <= $vyb_umek AND dm >= 101 AND dm <= 109 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober dni neodpracovane
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
" 0,dni,0,kc,0,0,0,0,ume,".
" 1".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume >= $vyb_umep AND ume <= $vyb_umek AND ( dm >= 801 AND dm <= 804 ) ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober dni neodpracovane
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
" 0,dni,0,kc,0,0,0,0,ume,".
" 1".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume >= $vyb_umep AND ume <= $vyb_umek AND dm = 812 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober dni neodpracovane
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
" 0,dni,0,0,0,0,0,0,ume,".
" 1".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume >= $vyb_umep AND ume <= $vyb_umek AND ( dm >= 506 AND dm <= 520  )".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//zober hrubu a fondy
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
" 0,0,sum_hru,0,(ofir_np+ofir_sp+ofir_ip+ofir_pn+ofir_up+ofir_rf+ofir_gf),ofir_zp,0,0,ume,".
" 1".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE ume >= $vyb_umep AND ume <= $vyb_umek ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET spo=hru+nem+fon+fo2 ";
$oznac = mysql_query("$sqtoz");

$ajstx=0;
if( $merkfood == 1 ) { $ajstx=1; }
if( $ajstx == 0 )
  {
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET umx=0 ";
$dsql = mysql_query("$dsqlt");
  }

//sumarizuj za oc
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
" SUM(dni),SUM(dnn),SUM(hru),SUM(nem),SUM(fon),SUM(fo2),SUM(spo),0,umx,".
"0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE konx2 = 1 ".
" GROUP BY oc,umx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx2 > 0";
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE dni = 0 AND dnn = 0 AND hru = 0 AND nem = 0 AND fon = 0 AND spo = 0 ";
$oznac = mysql_query("$sqtoz");

//sumarizuj za stx
if( $ajstx == 1 )
  {
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdzalkun ".
" SET stx=stz ".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc=F$kli_vxcf"."_mzdzalkun.oc AND F$kli_vxcf"."_mzdprcvypl$kli_uzid.umx=F$kli_vxcf"."_mzdzalkun.ume ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET konx2=1 ";
$dsql = mysql_query("$dsqlt");

//sumarizuj za oc
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
" SUM(dni),SUM(dnn),SUM(hru),SUM(nem),SUM(fon),SUM(fo2),SUM(spo),stx,0,".
"0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE konx2 = 1 ".
" GROUP BY oc,stx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx2 > 0";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
" SUM(dni),SUM(dnn),SUM(hru),SUM(nem),SUM(fon),SUM(fo2),SUM(spo),stx,0,".
"1998".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc > 0 AND konx2 = 0".
" GROUP BY stx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT 0,".
" SUM(dni),SUM(dnn),SUM(hru),SUM(nem),SUM(fon),SUM(fo2),SUM(spo),stx,0,".
"0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc > 0 AND konx2 = 0".
" GROUP BY stx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
  }

//sumarizuj za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
" SUM(dni),SUM(dnn),SUM(hru),SUM(nem),SUM(fon),SUM(fo2),SUM(spo),9999999999,0,".
"1999".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc > 0 AND konx2 = 0".
" GROUP BY konx2".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");



}
//koniec pracovneho suboru 


/////////////////////////////////////////////////VYTLAC ODPRAC DNI
if( $copern == 10 )
{

$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/stat_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/stat_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }


   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


//vytlac
if( $ajstx == 0 )
  {
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE oc = 0";
$oznac = mysql_query("$sqtoz");
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx2 != 0 AND konx2 != 1999 ";
$oznac = mysql_query("$sqtoz");

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc > 0 ORDER BY stx,konx2,prie";
  }
if( $ajstx == 1 )
  {
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_str".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".stx=F$kli_vxcf"."_str.str".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc >= 0 ORDER BY stx,konx2,prie";
  }

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
$pocpol=$tvpol-1;
//exit;

$strana=0;
$j=0;           
$i=0;
$pcislo=1;
  while ($i <= $pocpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

$zzam_zp=$rtov->zzam_zp;
if( $rtov->zzam_zp == 0 ) $zzam_zp="";

$dni=$rtov->dni;
if( $rtov->dni == 0 ) $dni="";
$dnn=$rtov->dnn;
if( $rtov->dnn == 0 ) $dnn="";

//hlavicka strany
if ( $j == 0 )
     {
$strana=$strana+1;

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$pdf->SetFont('arial','',8);
$pdf->Cell(90,6,"Hrubá mzda a celková cena práce zamestnancov za $vyb_umep / $vyb_umek","LTB",0,"L");
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");


$pdf->Cell(50,5,"Priezvisko,meno Osè. ","1",0,"L");$pdf->Cell(20,5,"Odprac.dni","1",0,"R");
$pdf->Cell(20,5,"Neodpr.dni","1",0,"R");$pdf->Cell(20,5,"Hrubá mzda","1",0,"R");
$pdf->Cell(20,5,"Nemoc","1",0,"R");$pdf->Cell(20,5,"SpZamtel","1",0,"R");$pdf->Cell(20,5,"ZpZamtel","1",0,"R");
$pdf->Cell(0,5,"Spolu","1",1,"R");

     }
//koniec hlavicky j=0

if( $rtov->konx2 == 0 AND $rtov->oc > 0 )
     {
$pdf->Cell(50,5,"$rtov->prie $rtov->meno osè$rtov->oc ","0",0,"L");$pdf->Cell(20,5,"$dni","0",0,"R");
$pdf->Cell(20,5,"$dnn","0",0,"R");$pdf->Cell(20,5,"$rtov->hru","0",0,"R");
$pdf->Cell(20,5,"$rtov->nem","0",0,"R");$pdf->Cell(20,5,"$rtov->fon","0",0,"R");$pdf->Cell(20,5,"$rtov->fo2","0",0,"R");
$pdf->Cell(0,5,"$rtov->spo","0",1,"R");
     }

if( $rtov->konx2 == 0 AND $rtov->oc == 0 AND $ajstx == 1 )
     {
$pdf->Cell(0,5,"STR $rtov->stx $rtov->nst","B",1,"L");
$j=$j+1;
     }

if( $rtov->konx2 == 1998 )
     {
$pdf->Cell(50,5,"SPOLU STR $rtov->stx $rtov->nst","1",0,"L");
$pdf->Cell(20,5,"$rtov->dni","1",0,"R");
$pdf->Cell(20,5,"$rtov->dnn","1",0,"R");$pdf->Cell(20,5,"$rtov->hru","1",0,"R");
$pdf->Cell(20,5,"$rtov->nem","1",0,"R");$pdf->Cell(20,5,"$rtov->fon","1",0,"R");$pdf->Cell(20,5,"$rtov->fo2","1",0,"R");
$pdf->Cell(0,5,"$rtov->spo","1",1,"R");
$pdf->Cell(0,5," ","0",1,"R");
$j=$j+1;
     }

if( $rtov->konx2 == 1999 )
     {
$pdf->Cell(50,5,"SPOLU všetko","1",0,"L");
$pdf->Cell(20,5,"$rtov->dni","1",0,"R");
$pdf->Cell(20,5,"$rtov->dnn","1",0,"R");$pdf->Cell(20,5,"$rtov->hru","1",0,"R");
$pdf->Cell(20,5,"$rtov->nem","1",0,"R");$pdf->Cell(20,5,"$rtov->fon","1",0,"R");$pdf->Cell(20,5,"$rtov->fo2","1",0,"R");
$pdf->Cell(0,5,"$rtov->spo","1",1,"R");
     }

}
$i = $i + 1;
$j = $j + 1;
$pcislo=$pcislo+1;

if( $j >= 50 ) $j=0;

  }


$csv = 1*$_REQUEST['csv'];
//echo $csv;
//exit;
if( $csv == 0 ) 
{ 
$pdf->Output("$outfilex");

?> 
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
?>
<?php
}
if( $csv == 1 ) 
{ 
$nazsub="hruba_mzda";

if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }
$soubor = fopen("../tmp/$nazsub.csv", "a+");

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc > 0 AND konx2 = 0 ORDER BY stx,konx2,prie";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$dob_sk=SkDatum($hlavicka->dob);

//$pdf->Cell(60,5,"$rtov->prie $rtov->meno osè$rtov->oc ","0",0,"L");$pdf->Cell(20,5,"$dni","0",0,"R");
//$pdf->Cell(20,5,"$dnn","0",0,"R");$pdf->Cell(20,5,"$rtov->hru","0",0,"R");
//$pdf->Cell(20,5,"$rtov->nem","0",0,"R");$pdf->Cell(20,5,"$rtov->fon","0",0,"R");
//$pdf->Cell(0,5,"$rtov->spo","0",1,"R");


if( $i == 0 )
     {
  $text = "osc;prie,meno,titl;odprac.dni;neodprac.dni;hru.mzda;nemoc.Eur;SpZtel;ZpZtel;Spolu"."\r\n"; 
  fwrite($soubor, $text);

     }


$dnixx=$hlavicka->dni; $dnixx=str_replace(".",",",$dnixx); 
$dnnxx=$hlavicka->dnn; $dnnxx=str_replace(".",",",$dnnxx); 
$hruxx=$hlavicka->hru; $hruxx=str_replace(".",",",$hruxx); 
$nemxx=$hlavicka->nem; $nemxx=str_replace(".",",",$nemxx); 
$fonxx=$hlavicka->fon; $fonxx=str_replace(".",",",$fonxx); 
$fo2xx=$hlavicka->fo2; $fo2xx=str_replace(".",",",$fo2xx); 
$spoxx=$hlavicka->spo; $spoxx=str_replace(".",",",$spoxx); 

  $text = $hlavicka->oc.";".$hlavicka->prie." ".$hlavicka->meno." ".$hlavicka->titl.";";
  $text = $text.$dnixx.";".$dnnxx.";".$hruxx.";".$nemxx.";".$fonxx.";".$fo2xx.";".$spoxx."\r\n";

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);
?>
<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>
<?php
}



}
/////////////////////////////////////////KONIEC VYTLACENIA ODPRAC DNI copern=10

?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Odpracované dni</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;


</script>
</HEAD>
<BODY class="white" id="white" onload="" >




<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu

       } while (false);
?>
</BODY>
</HTML>
