<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 2000;
$clsm = 920;
$cslm=403210;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

$cislo_skl = 1*$_REQUEST['cislo_skl'];

//copern=10 okamzity stav, 20-mesacny stav, 30=pociatocny stav

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

$reko = include("skl_rekonstrukcia.php");

$objdod = 1*$_REQUEST['objdod'];

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Vyhodnotenie minimálnych zásob PDF</title>
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
<td>EuroSecom  -  Vyhodnotenie minimálnych zásob  

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


//urob pracovnu sklprc zjednotenie pri,vyd,pre,poc

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<sklprc
(
   druh        VARCHAR(15) not null,
   pox1        INT,
   pox         INT,
   ume         FLOAT(8,4),
   dat         DATE,
   skl         INT,
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


//ak okamzity stav zober rovno z sklzas
if( $copern == 10 )
{
$sqlt = "DELETE FROM F".$kli_vxcf."_sklprc".$kli_uzid." WHERE pox = 0";
$vysledok = mysql_query("$sqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,0,0,'0000-00-00',skl,cis,zas,cen,(zas),'0','0','0','0' FROM F$kli_vxcf"."_sklzas WHERE ( cis > 0 )".
" ORDER BY cis".
"";
$dsql = mysql_query("$dsqlt");

}

//odpocitaj od zasob objednavky a dodacie v eshope
if( $objdod == 1 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,0,0,'0000-00-00',0,xcis,-xmno,xcep,-(xmno),'0','0','0','0' FROM F$kli_vxcf"."_kosikobj WHERE xcis > 0 AND xsx3 = 0 AND xfak = 0 ".
" ORDER BY xcis".
"";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
}


//ak nie su v sklzas zober z sklcis
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,0,0,'0000-00-00',0,cis,0,0,0,'0','0','0','0' FROM F$kli_vxcf"."_sklcis WHERE ( cis > 0 )".
" ORDER BY cis".
"";
$dsql = mysql_query("$dsqlt");

//group za cis
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT druh,0,0,ume,dat,skl,cis,mno,cen,SUM(zas),0,0,0,0 FROM F$kli_vxcf"."_sklprc$kli_uzid ".
" GROUP BY cis".
"";
$dsql = mysql_query("$dsqlt");




//dopln min.zasobu z cisudaje do hod
$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid SET hod=0 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid,F$kli_vxcf"."_sklcisudaje SET hod=cxc01 ".
" WHERE F$kli_vxcf"."_sklprcd$kli_uzid.cis=F$kli_vxcf"."_sklcisudaje.xcis ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid SET vdj=hod-zas ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid SET vdj=0 WHERE vdj < 0 ";
$dsql = mysql_query("$dsqlt");

$neparne=1;

//exit;

if ( $copern == 20 OR $copern == 10 OR $copern == 30 )
  {
$sqltt = "SELECT * FROM F$kli_vxcf"."_sklprcd$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.cis=F$kli_vxcf"."_sklcis.cis".
" WHERE hod > 0 ".
" ORDER BY pox,F$kli_vxcf"."_sklprcd$kli_uzid.cis ";
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

$textpop="";
if( $objdod == 1 ) { $textpop=" - odpoèítané objednávky a nevybavené dodacie listy z eshopu"; }

$pdf->SetFont('arial','',9);
if ( $copern == 10 )  { $pdf->Cell(90,6,"Vyhodnotenie minimálnych zásob$textpop","LTB",0,"L"); }
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);


$pdf->Cell(30,5,"MAT","1",0,"R");$pdf->Cell(80,5,"Názov","1",0,"L");
$pdf->Cell(10,5,"MJ","1",0,"L");
$pdf->Cell(20,5,"Zásoba MJ","1",0,"R");$pdf->Cell(20,5,"Minimálna zás.","1",0,"R");$pdf->Cell(0,5,"Objedna","1",1,"R");

     }
//koniec hlavicky j=0





if( $riadok->pox == 0 AND $riadok->pox1 == 0 )
{

$pdf->SetFont('arial','',8);

if( $sZostatok == '0' ) $sZostatok="";

$objednat=$riadok->vdj;
if( $objednat == '0' ) $objednat="";

$pdf->Cell(30,5,"$riadok->cis","0",0,"R");$pdf->Cell(80,5,"$riadok->nat","0",0,"L");
$pdf->Cell(10,5,"$riadok->mer","0",0,"L");
$pdf->Cell(20,5,"$riadok->zas","0",0,"R");$pdf->Cell(20,5,"$riadok->hod","0",0,"R");$pdf->Cell(0,5,"$objednat","0",1,"R");

}



}
$i = $i + 1;
$j = $j + 1;
if( $j > 48 ) $j=0;

  }


//export csv
$docsv = 1*$_REQUEST['docsv'];
if( $docsv == 1 )
{
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="stavminzasob";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");

$sqltt = "SELECT * FROM F$kli_vxcf"."_sklprcd$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.cis=F$kli_vxcf"."_sklcis.cis".
" WHERE hod > 0 AND pox = 0 AND pox1 = 0 ".
" ORDER BY pox,F$kli_vxcf"."_sklprcd$kli_uzid.cis ";

//echo $sqltt;
$sql = mysql_query("$sqltt");
if($sql)                                                    
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$datsk=SkDatum($hlavicka->dat);

$objednat=$hlavicka->vdj;
if( $objednat == '0' ) $objednat="";

//$pdf->Cell(30,5,"$riadok->cis","0",0,"R");$pdf->Cell(80,5,"$riadok->nat","0",0,"L");
//$pdf->Cell(10,5,"$riadok->mer","0",0,"L");
//$pdf->Cell(20,5,"$riadok->zas","0",0,"R");$pdf->Cell(20,5,"$riadok->hod","0",0,"R");$pdf->Cell(0,5,"$objednat","0",1,"R");

$xobj=$objednat; $obj=str_replace(".",",",$xobj); 
$xzas=$hlavicka->zas; $zas=str_replace(".",",",$xzas);
$xhod=$hlavicka->hod; $hod=str_replace(".",",",$xhod);


if( $i == 0 )
     {
  $text = "sklad".";"."cislo".";"."nazov".";"."mj".";"."zasoba"; 
  $text = $text.";"."hodnota".";"."objednat"."\r\n"; 

  fwrite($soubor, $text);

     }



  $text = $hlavicka->skl.";".$hlavicka->cis.";"."$hlavicka->nat".";"."$hlavicka->mer".";"."$zas"; 
  $text = $text.";"."$hod".";"."$obj"."\r\n";  

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>

<?php
exit;
}
//koniec export csv

$pdf->Output("../tmp/podklad.$kli_uzid.pdf");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid;
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
