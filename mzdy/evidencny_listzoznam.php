<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 2000;
$clsm = 930;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];


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




?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>
Zoznam evidenèných listov PDF
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
<td>EuroSecom  -  Zoznam evidenèných listov PDF 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/mzdtlac$kli_uzid.pdf")) { $soubor = unlink("../tmp/mzdtlac$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

if ( $copern == 10 )
    {

//prac.subor a subor vytvorenych potvrdeni
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdevidencny'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   kr01         DECIMAL(10,0) DEFAULT 0,
   kr02         DECIMAL(10,0) DEFAULT 0,
   kr03         DECIMAL(10,0) DEFAULT 0,
   kr04         DECIMAL(10,0) DEFAULT 0,
   kr05         DECIMAL(10,0) DEFAULT 0,
   kr06         DECIMAL(10,0) DEFAULT 0,
   kr07         DECIMAL(10,0) DEFAULT 0,
   kr08         DECIMAL(10,0) DEFAULT 0,
   kr09         DECIMAL(10,0) DEFAULT 0,
   kr10         DECIMAL(10,0) DEFAULT 0,
   kr11         DECIMAL(10,0) DEFAULT 0,
   kr12         DECIMAL(10,0) DEFAULT 0,
   kr13         DECIMAL(10,0) DEFAULT 0,
   zp01         VARCHAR(5) NOT NULL,
   zp02         VARCHAR(5) NOT NULL,
   zp03         VARCHAR(5) NOT NULL,
   zp04         VARCHAR(5) NOT NULL,
   zp05         VARCHAR(5) NOT NULL,
   zp06         VARCHAR(5) NOT NULL,
   zp07         VARCHAR(5) NOT NULL,
   zp08         VARCHAR(5) NOT NULL,
   zp09         VARCHAR(5) NOT NULL,
   zp10         VARCHAR(5) NOT NULL,
   zp11         VARCHAR(5) NOT NULL,
   zp12         VARCHAR(5) NOT NULL,
   zp13         VARCHAR(5) NOT NULL,
   dp01         DATE,
   dp02         DATE,
   dp03         DATE,
   dp04         DATE,
   dp05         DATE,
   dp06         DATE,
   dp07         DATE,
   dp08         DATE,
   dp09         DATE,
   dp10         DATE,
   dp11         DATE,
   dp12         DATE,
   dp13         DATE,
   dk01         DATE,
   dk02         DATE,
   dk03         DATE,
   dk04         DATE,
   dk05         DATE,
   dk06         DATE,
   dk07         DATE,
   dk08         DATE,
   dk09         DATE,
   dk10         DATE,
   dk11         DATE,
   dk12         DATE,
   dk13         DATE,
   vz01         DECIMAL(10,2) DEFAULT 0,
   vz02         DECIMAL(10,2) DEFAULT 0,
   vz03         DECIMAL(10,2) DEFAULT 0,
   vz04         DECIMAL(10,2) DEFAULT 0,
   vz05         DECIMAL(10,2) DEFAULT 0,
   vz06         DECIMAL(10,2) DEFAULT 0,
   vz07         DECIMAL(10,2) DEFAULT 0,
   vz08         DECIMAL(10,2) DEFAULT 0,
   vz09         DECIMAL(10,2) DEFAULT 0,
   vz10         DECIMAL(10,2) DEFAULT 0,
   vz11         DECIMAL(10,2) DEFAULT 0,
   vz12         DECIMAL(10,2) DEFAULT 0,
   vz13         DECIMAL(10,2) DEFAULT 0,
   vv01         DECIMAL(10,2) DEFAULT 0,
   vv02         DECIMAL(10,2) DEFAULT 0,
   vv03         DECIMAL(10,2) DEFAULT 0,
   vv04         DECIMAL(10,2) DEFAULT 0,
   vv05         DECIMAL(10,2) DEFAULT 0,
   vv06         DECIMAL(10,2) DEFAULT 0,
   vv07         DECIMAL(10,2) DEFAULT 0,
   vv08         DECIMAL(10,2) DEFAULT 0,
   vv09         DECIMAL(10,2) DEFAULT 0,
   vv10         DECIMAL(10,2) DEFAULT 0,
   vv11         DECIMAL(10,2) DEFAULT 0,
   vv12         DECIMAL(10,2) DEFAULT 0,
   vv13         DECIMAL(10,2) DEFAULT 0,
   kd01         DECIMAL(10,0) DEFAULT 0,
   kd02         DECIMAL(10,0) DEFAULT 0,
   kd03         DECIMAL(10,0) DEFAULT 0,
   kd04         DECIMAL(10,0) DEFAULT 0,
   kd05         DECIMAL(10,0) DEFAULT 0,
   kd06         DECIMAL(10,0) DEFAULT 0,
   kd07         DECIMAL(10,0) DEFAULT 0,
   kd08         DECIMAL(10,0) DEFAULT 0,
   kd09         DECIMAL(10,0) DEFAULT 0,
   kd10         DECIMAL(10,0) DEFAULT 0,
   kd11         DECIMAL(10,0) DEFAULT 0,
   kd12         DECIMAL(10,0) DEFAULT 0,
   kd13         DECIMAL(10,0) DEFAULT 0,
   pox          DECIMAL(1,0) DEFAULT 0,
   pozn         VARCHAR(80),
   str2         TEXT,
   datum        DATE
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdevidencny'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


//zober data z kun
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdevidencny$kli_uzid ".
" SELECT oc,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"'','','','','','','','','','','','','',".
"dan,dar,'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"dav,'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"2,'','','0000-00-00'".
" FROM F$kli_vxcf"."_mzdkun".
" WHERE F$kli_vxcf"."_mzdkun.oc >= 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober data z sum
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdevidencny$kli_uzid ".
" SELECT oc,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"'','','','','','','','','','','','','',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"zzam_sp,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"2,'','','0000-00-00'".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE oc >= 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//zober data z vy
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdevidencny$kli_uzid ".
" SELECT oc,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"'','','','','','','','','','','','','',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"kc,0,0,0,0,0,0,0,0,0,0,0,0,".
"(TO_DAYS(dk)-TO_DAYS(dp)+1),0,0,0,0,0,0,0,0,0,0,0,0,".
"2,'','','0000-00-00'".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE oc >= 0 AND ( dm = 801 OR dm = 802 )".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


if( $alchem == 1 )
{
//zober data z vy
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdevidencny$kli_uzid ".
" SELECT oc,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"'','','','','','','','','','','','','',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,kc,0,0,0,0,0,0,0,0,0,0,0,".
"0,(TO_DAYS(dk)-TO_DAYS(dp)+1),0,0,0,0,0,0,0,0,0,0,0,".
"2,'','','0000-00-00'".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE oc >= 0 AND dm = 513 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

//exit;

//sumar za oc
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdevidencny$kli_uzid ".
" SELECT oc,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"'','','','','','','','','','','','','',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"SUM(vz01),0,0,0,0,0,0,0,0,0,0,0,0,".
"SUM(vv01),SUM(vv02),0,0,0,0,0,0,0,0,0,0,0,".
"SUM(kd01),SUM(kd02),0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','0000-00-00'".
" FROM F$kli_vxcf"."_mzdevidencny$kli_uzid".
" WHERE pox = 2 GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$uprtxt = "DELETE FROM F$kli_vxcf"."_mzdevidencny$kli_uzid WHERE pox != 1 "; 
$upravene = mysql_query("$uprtxt");


$uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny$kli_uzid,F$kli_vxcf"."_mzdkun ".
" SET dp01=dan, dk01=dav, dp02=dar ".
" WHERE F$kli_vxcf"."_mzdevidencny$kli_uzid.oc=F$kli_vxcf"."_mzdkun.oc "; 
$upravene = mysql_query("$uprtxt"); 

$dat0101=$kli_vrok."-01-01";
$dat3112=$kli_vrok."-12-31";

$uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny$kli_uzid SET dp01='$dat0101' WHERE dp01 < '$dat0101' "; 
$upravene = mysql_query("$uprtxt"); 
$uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny$kli_uzid SET dk01='$dat3112' WHERE dp01 < '$dat0101' OR dk01 = '0000-00-00' "; 
$upravene = mysql_query("$uprtxt");

//narodeny po 31.12.1984
$uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny$kli_uzid SET kd03=1 WHERE dp02 > '1984-12-31' "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny$kli_uzid SET vv02=0, kd02=0 WHERE kd03 = 1 "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny$kli_uzid SET vv01=vv01+vv02, kd01=kd01+kd02 WHERE oc >= 0 "; 
$upravene = mysql_query("$uprtxt"); 


//vytlac 

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdevidencny$kli_uzid ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdevidencny$kli_uzid.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdevidencny$kli_uzid.oc > 0 AND pox = 1 ORDER BY pox,prie,meno";

//echo $sqltt;
//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//exit;

$zostatokeur=0;
$zostatok=0;
$new=0;
$strana=0;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);


$dp_sk=SkDatum($riadok->dp);
$dk_sk=SkDatum($riadok->dk);
if( $dp_sk == '00.00.0000' ) $dp_sk="";
if( $dk_sk == '00.00.0000' ) $dk_sk="";

//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$pdf->SetFont('arial','',10);
if ( $copern == 10 )  { $pdf->Cell(90,6,"Zoznam evidenèných listov $kli_vrok","LTB",0,"L"); }
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',10);


$pdf->Cell(80,4,"Zamestnanec","1",0,"L");$pdf->Cell(30,4,"rod.èíslo","1",0,"L");$pdf->Cell(50,4,"Obdobie dôchod.poistenia","1",0,"L");
$pdf->Cell(40,4,"VZ","1",0,"R");$pdf->Cell(30,4,"VZ poèas vyl.dôb","1",0,"R");
$pdf->Cell(30,4,"Kal.dni vyl.dôb","1",0,"R");$pdf->Cell(0,4," ","1",1,"R");


$new=0;
     }
//koniec hlavicky j=0



if( $riadok->pox == 1 )
{

$pdf->SetFont('arial','',10);

$dp01=SkDatum($riadok->dp01);
if( $dp01 == "00.00.0000" ) $dp01="";
$dk01=SkDatum($riadok->dk01);
if( $dk01 == "00.00.0000" ) $dk01="";

$dar=SkDatum($riadok->dp02);

$pole = explode(".", $dp01);
$dnip=$pole[0];
$mesp=$pole[1];
$pole = explode(".", $dk01);
$dnik=$pole[0];
$mesk=$pole[1];

$pdf->Cell(80,4,"$riadok->oc $riadok->prie $riadok->meno","B",0,"L");
$pdf->Cell(30,4,"$riadok->rdc $riadok->rdk","B",0,"L");
$pdf->Cell(50,4,"$dnip . $mesp - $dnik . $mesk ","B",0,"L");
$pdf->Cell(40,4,"$riadok->vz01","B",0,"R");$pdf->Cell(30,4,"$riadok->vv01","B",0,"R");
$pdf->Cell(30,4,"$riadok->kd01","B",0,"R");$pdf->Cell(0,4," ","B",1,"R");


}



}
$i = $i + 1;
$j = $j + 1;
if( $j > 36 ) $j=0;

  }
//koniec while

$pdf->Output("../tmp/mzdtlac.$kli_uzid.pdf");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdevidencny'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/mzdtlac.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
     }
//koniec copern=10

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
