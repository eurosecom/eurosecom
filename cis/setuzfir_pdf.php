<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
$urov = 10000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

$fod = 1*$_REQUEST['fod'];
$fdo = 1*$_REQUEST['fdo'];

//echo $cislo_dok;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);



//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$sqltt = "DROP TABLE klientixxx ";
$tov = mysql_query("$sqltt");

$sqltt = "CREATE TABLE klientixxx SELECT * FROM klienti WHERE id_klienta < 0 ";
$tov = mysql_query("$sqltt");

$sqltt = "ALTER TABLE klientixxx MODIFY txt2 VARCHAR(300) ";
$tov = mysql_query("$sqltt");

$sqltt = "DROP TABLE firxxx ";
$tov = mysql_query("$sqltt");

$sqltt = "CREATE TABLE firxxx SELeCT * FROM fir WHERE xcf < 0 ";
$tov = mysql_query("$sqltt");

$ifx=$fod;
  while ( $ifx <= $fdo )
  {

$sqltt = "INSERT INTO firxxx ( xcf ) VALUES ( '$ifx' ) ";
$tov = mysql_query("$sqltt");

$ifx=$ifx+1;
  }



$sqltt = "SELECT * FROM klienti WHERE id_klienta >= 0 ORDER BY id_klienta ";
$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
          
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);

$kli_txt1=$riadok->txt1;

$pole = explode(",", $kli_txt1);

$pole0 = explode("-", $pole[0]);
$kli_fmin0=$pole0[0];
$kli_fmax0=$pole0[1];
$akefirmy = "( xcf >= $kli_fmin0 AND xcf <= $kli_fmax0 )";

$pole1 = explode("-", $pole[1]);
$kli_fmin1=$pole1[0];
$kli_fmax1=$pole1[1];
$cislo=1*$kli_fmin1;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin1 AND xcf <= $kli_fmax1 )";

$pole2 = explode("-", $pole[2]);
$kli_fmin2=$pole2[0];
$kli_fmax2=$pole2[1];
$cislo=1*$kli_fmin2;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin2 AND xcf <= $kli_fmax2 )";

$pole3 = explode("-", $pole[3]);
$kli_fmin3=$pole3[0];
$kli_fmax3=$pole3[1];
$cislo=1*$kli_fmin3;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin3 AND xcf <= $kli_fmax3 )";

$pole4 = explode("-", $pole[4]);
$kli_fmin4=$pole4[0];
$kli_fmax4=$pole4[1];
$cislo=1*$kli_fmin4;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin4 AND xcf <= $kli_fmax4 )";

$pole5 = explode("-", $pole[5]);
$kli_fmin5=$pole5[0];
$kli_fmax5=$pole5[1];
$cislo=1*$kli_fmin5;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin5 AND xcf <= $kli_fmax5 )";

$pole6 = explode("-", $pole[6]);
$kli_fmin6=$pole6[0];
$kli_fmax6=$pole6[1];
$cislo=1*$kli_fmin6;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin6 AND xcf <= $kli_fmax6 )";

$pole7 = explode("-", $pole[7]);
$kli_fmin7=$pole7[0];
$kli_fmax7=$pole7[1];
$cislo=1*$kli_fmin7;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin7 AND xcf <= $kli_fmax7 )";

$pole8 = explode("-", $pole[8]);
$kli_fmin8=$pole8[0];
$kli_fmax8=$pole8[1];
$cislo=1*$kli_fmin8;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin8 AND xcf <= $kli_fmax8 )";

$pole9 = explode("-", $pole[9]);
$kli_fmin9=$pole9[0];
$kli_fmax9=$pole9[1];
$cislo=1*$kli_fmin9;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin9 AND xcf <= $kli_fmax9 )";


if( $akefirmy == "( xcf >= 0 AND xcf <= 0 )" ) 
    { 
  $sqlfiruzttx = "SELECT * FROM firuz ";
  $sqlfiruzx = mysql_query("$sqlfiruzttx");
  if($sqlfiruzx)
      {

  $sqlfiruzttt = "SELECT * FROM $mysqldbfir.firuz WHERE uzid = $riadok->id_klienta ORDER BY fiod, fido";
  $sqlfiruz = mysql_query("$sqlfiruzttt");
  while ($riadokf = mysql_fetch_object($sqlfiruz))
  {

  $akefirmy = $akefirmy." OR ( xcf >= $riadokf->fiod AND xcf <= $riadokf->fido )";

  }

      }
    }

//echo $riadok->id_klienta." ".$akefirmy."<br />";

$sqldttt = "SELECT * FROM firxxx WHERE $akefirmy ";
$sqldt = mysql_query("$sqldttt");
$poldt = mysql_num_rows($sqldt);

if( $poldt > 0 ) 
  {

$sqlttp = "INSERT INTO klientixxx ( id_klienta, txt1, priezvisko, meno, txt2 ) VALUES ( '$riadok->id_klienta', '$riadok->txt1', '$riadok->priezvisko', '$riadok->meno', '$akefirmy' ) ";
$tovp = mysql_query("$sqlttp");

  }


}
$i=$i+1;
  }

//exit;


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Èíselník uzid</title>
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
<td>EuroSecom  -  Užívatelia, ktorý majú prístup do firiem od do 

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




$sqltt = "SELECT * FROM klientixxx WHERE id_klienta >= 0 ORDER BY id_klienta ";

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

$pdf->SetFont('arial','',10);
$pdf->Cell(90,6,"Užívatelia, ktorý majú prístup do firiem od $fod do $fdo","LTB",0,"L"); 
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',8);


$pdf->Cell(20,6,"èíslo","1",0,"R");$pdf->Cell(80,6,"Priezvisko Meno","1",0,"L");
$pdf->Cell(0,6,"firx","1",1,"L");

     }
//koniec hlavicky j=0





$pdf->SetFont('arial','',8);

$pdf->Cell(20,6,"$riadok->id_klienta","0",0,"R");
$pdf->Cell(80,6,"$riadok->priezvisko $riadok->meno","0",0,"L");
$pdf->Cell(0,6,"$riadok->txt1","0",1,"L");
$pdf->SetFont('arial','',5);


  $sqlfiruzttt = "SELECT * FROM firuz WHERE uzid = $riadok->id_klienta ORDER BY fiod, fido";
  $sqlfiruz = mysql_query("$sqlfiruzttt");
  while ($riadokf = mysql_fetch_object($sqlfiruz))
  {


$pdf->Cell(105,6," ","0",0,"R");$pdf->Cell(0,6,"$riadokf->fiod - $riadokf->fido","0",1,"L");

  }

$pdf->SetFont('arial','',8);
$pdf->Cell(0,1," ","B",1,"L");

}
$i = $i + 1;
$j = $j + 1;
if( $j > 40 ) $j=0;

  }




$pdf->Output("../tmp/podklad.$kli_uzid.pdf");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

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
