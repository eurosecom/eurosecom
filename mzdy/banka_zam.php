<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 2000;
$clsm = 900;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$kanc = 1*$_REQUEST['kanc'];
$cislo_kanc = 1*$_REQUEST['cislo_kanc'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];
$ostre = 1*$_REQUEST['ostre'];

$zastr = 1*$_REQUEST['zastr'];

if(!isset($kli_vxcf)) $kli_vxcf = 1;

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

//prac.subor
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   sum_ban      DECIMAL(10,2) DEFAULT 0,
   oc           INT(7) DEFAULT 0,
   dok          INT(7) DEFAULT 0,
   ucep         VARCHAR(35) NOT NULL,
   nump         VARCHAR(10) NOT NULL,
   vsyp         DECIMAL(10,0) DEFAULT 0,
   ksyp         VARCHAR(4) NOT NULL,
   ssyp         VARCHAR(30) NOT NULL,
   dm           INT(7) DEFAULT 0,
   trncpl       INT(7) DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0,
   konx2        DECIMAL(10,0) DEFAULT 0,
   strx         DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid.$sqlt;
//$vytvor = mysql_query("$vsql");

//zober data zo sum vyplaty do banky
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT sum_ban,oc,0,".
" '','',0,'','',".
" 935,0,0,0,0".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE ume = $kli_vume AND sum_ban > 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln udaje kun do vy
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdkun".
" SET ucep=uceb, nump=numb, vsyp=vsy, ksyp=ksy, ssyp=ssy".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc = F$kli_vxcf"."_mzdkun.oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

if( $kli_vrok > 2015 )
  {

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdtextmzd".
" SET ucep=ziban, nump=zswft ".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc = F$kli_vxcf"."_mzdtextmzd.invt AND F$kli_vxcf"."_mzdtextmzd.ziban != '' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

  }

//zober data z trvalych

if( $kli_vrok <= 2015 )
  {
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT kc,oc,0,".
" uceb,numb,vsy,ksy,ssy,".
" dm,0,0,0,0".
" FROM F$kli_vxcf"."_mzdzaltrn".
" WHERE ume = $kli_vume AND uceb != '' AND numb != '0000' AND kc > 0 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
  }
if( $kli_vrok >  2015 )
  {
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT kc,oc,0,".
" trx4,trx3,vsy,ksy,ssy,".
" dm,0,0,0,0".
" FROM F$kli_vxcf"."_mzdzaltrn".
" WHERE ume = $kli_vume AND uceb != '' AND numb != '0000' AND kc > 0 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
  }


if( $drupoh == 2 )
{
//suma dm
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT sum(sum_ban),0,0,".
" '','',0,'','',".
" dm,0,998,0,0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY dm";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

if( $drupoh == 3 )
{
//suma banka
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT sum(sum_ban),0,0,".
" '',nump,0,'','',".
" 0,0,997,0,0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY nump";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

if( $zastr == 1 )
{
//suma str

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdkun".
" SET strx=stz ".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc = F$kli_vxcf"."_mzdkun.oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT sum(sum_ban),0,0,".
" '',nump,0,'','',".
" 0,0,996,0,strx".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY strx";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

//suma vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT sum(sum_ban),0,0,".
" '','',0,'','',".
" 0,0,999,999,999999999".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE konx=0".
" GROUP BY konx";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>BANKA Zamestnanci</title>
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
<td>EuroSecom  -  Výplatná listina 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/mzdzos$kli_uzid.pdf")) { $soubor = unlink("../tmp/mzdzos$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$neparne=1;

if( $drupoh == 1 ) {
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc >= 0 ORDER BY konx,ucep,sum_ban";
}

if( $zastr == 1 ) {
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc >= 0 ORDER BY strx,konx,prie,dm,sum_ban";

//echo $sqltt;
//exit;

}

if( $drupoh == 2 ) {
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc >= 0 ORDER BY konx2,dm,konx,prie,meno";
}

if( $drupoh == 3 ) {
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc >= 0 ORDER BY konx2,nump,konx,prie,meno";
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
$rtov=mysql_fetch_object($tov);

$h_dao = SkDatum($rtov->dao);
$h_e1000=$rtov->e1000;


//hlavicka strany
if ( $j == 0 )
     {
$strana=$strana+1;

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$pdf->SetFont('arial','',10);
$pdf->Cell(90,6,"Platby cez BANKU - Zamestnanci $kli_vume","LTB",0,"L");
$pdf->Cell(90,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',9);

$pdf->Cell(15,6,"DM","1",0,"L");
if( $kli_vrok <= 2015 )
  {
$pdf->Cell(45,6,"Úèet","1",0,"R");
  }
if( $kli_vrok >  2015 )
  {
$pdf->Cell(45,6,"IBAN","1",0,"R");
  }
$pdf->Cell(40,6,"Priezvisko,Meno,titul","LTB",0,"L");$pdf->Cell(10,6,"osè","RTB",0,"R");
$pdf->Cell(30,6,"Vyplatené v €","1",0,"R");

if( $kli_vrok <= 2015 )
  {
$pdf->Cell(40,6,"Poznámka ","1",1,"L");
  }
if( $kli_vrok >  2015 )
  {
$pdf->Cell(40,6,"SWIFT","1",1,"R");
  }

if( $zastr == 1 AND $rtov->konx != 999 ) { $pdf->Cell(40,6,"Stredisko: $rtov->strx ","0",1,"L"); $j=$j+1; }

     }
//koniec hlavicky j=0


if( $rtov->konx == 0 )
{
if( $kli_vrok <= 2015 )
  {
$pdf->SetFont('arial','',9);
$pdf->Cell(15,7,"$rtov->dm","0",0,"R");$pdf->Cell(45,7,"$rtov->ucep / $rtov->nump","0",0,"R");
  }
if( $kli_vrok >  2015 )
  {
$pdf->SetFont('arial','',9);
$pdf->Cell(15,7,"$rtov->dm","0",0,"L");
$pdf->SetFont('arial','',7);

$ibanoc=$rtov->ucep;
$ibanoc=str_replace(" ","",$ibanoc);
$ibanoc1 = substr($ibanoc,0,4);
$ibanoc2 = substr($ibanoc,4,4);
$ibanoc3 = substr($ibanoc,8,4);
$ibanoc4 = substr($ibanoc,12,4);
$ibanoc5 = substr($ibanoc,16,4);
$ibanoc6 = trim(substr($ibanoc,20,20));

$ibanoc=$ibanoc1." ".$ibanoc2." ".$ibanoc3." ".$ibanoc4." ".$ibanoc5." ".$ibanoc6;

$pdf->Cell(45,7,"$ibanoc","0",0,"R");
  }

$pdf->SetFont('arial','',8);
$pdf->Cell(40,7,"$rtov->prie $rtov->meno $rtov->titl","0",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(10,7,"$rtov->oc","0",0,"R");

$pdf->Cell(30,7,"$rtov->sum_ban","0",0,"R");
if( $kli_vrok <= 2015 )
  {
$pdf->Cell(40,7,"","0",1,"R");
  }
if( $kli_vrok >  2015 )
  {
$pdf->Cell(40,7,"$rtov->nump","0",1,"R");
  }
}

if( $rtov->konx == 999 )
{
$pdf->Cell(60,2,"","0",1,"L");

$pdf->Cell(15,7,"","BT",0,"R");$pdf->Cell(45,7," ","BT",0,"R");
$pdf->Cell(50,7,"SPOLU všetko","BT",0,"L");
$pdf->Cell(30,7,"$rtov->sum_ban","BT",0,"R");
$pdf->Cell(40,7,"","BT",1,"R");
}

if( $rtov->konx == 998 )
{
$pdf->Cell(60,2,"","0",1,"L");

$pdf->Cell(15,7,"","BT",0,"R");$pdf->Cell(45,7," ","BT",0,"R");
$pdf->Cell(50,7,"SPOLU mzdová zložka","BT",0,"L");
$pdf->Cell(30,7,"$rtov->sum_ban","BT",0,"R");
$pdf->Cell(40,7,"","BT",1,"R");
}

if( $rtov->konx == 997 )
{
$pdf->Cell(60,2,"","0",1,"L");

$pdf->Cell(15,7,"","BT",0,"R");$pdf->Cell(45,7," ","BT",0,"R");
$pdf->Cell(50,7,"SPOLU banka","BT",0,"L");
$pdf->Cell(30,7,"$rtov->sum_ban","BT",0,"R");
$pdf->Cell(40,7,"","BT",1,"R");
}

if( $rtov->konx == 996 )
{
$pdf->Cell(60,2,"","0",1,"L");

$pdf->Cell(15,7,"","BT",0,"R");$pdf->Cell(45,7," ","BT",0,"R");
$pdf->Cell(50,7,"SPOLU Stredisko","BT",0,"L");
$pdf->Cell(30,7,"$rtov->sum_ban","BT",0,"R");
$pdf->Cell(40,7,"","BT",1,"R");

$j=-1;
}

}
$i = $i + 1;
$j = $j + 1;
  }


$pdf->Output("../tmp/mzdzos.$kli_uzid.pdf");



$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/mzdzos.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
