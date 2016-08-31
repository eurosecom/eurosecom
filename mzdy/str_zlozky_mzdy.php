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

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalmesx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzaltrnx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalkunx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$mzdmes="mzdzalmesx".$kli_uzid;
$mzdtrn="mzdzaltrnx".$kli_uzid;
$mzdddp="mzdzalddpx".$kli_uzid;
$mzdkun="mzdzalkunx".$kli_uzid;
$mzdprm="mzdzalprmx".$kli_uzid;

$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalmesx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalmes WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzaltrnx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzaltrn WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalddpx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalddp WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalkunx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalkun WHERE ume = $kli_vume";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalprmx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalprm WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");

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
   dok          INT(8) DEFAULT 0,
   dat          DATE not null,
   ume          DECIMAL(7,4),
   dm           INT(4) DEFAULT 0,
   dp           DATE not null,
   dk           DATE not null,
   dni          DECIMAL(10,2) DEFAULT 0,
   hod          DECIMAL(10,2) DEFAULT 0,
   mnz          DECIMAL(10,4) DEFAULT 0,
   saz          DECIMAL(10,4) DEFAULT 0,
   kc           DECIMAL(10,2) DEFAULT 0,
   kcsk         DECIMAL(10,2) DEFAULT 0,
   str          INT(7) DEFAULT 0,
   zak          INT(7) DEFAULT 0,
   stj          INT(7) DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


//zober data z vy
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,dok,dat,ume,dm,dp,dk,dni,hod,mnz,saz,kc,0,str,zak,stj,0".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume = $kli_vume AND dm <= 999 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln str,zak z mzdkun ak str=0 
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.",F$kli_vxcf"."_mzdkun".
" SET str=stz ".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc = F$kli_vxcf"."_mzdkun.oc AND str = 0 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,dok,dat,ume,dm,dp,dk,SUM(dni),SUM(hod),mnz,saz,SUM(kc),0,str,zak,stj,9".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY str,dm";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>STR - Mzdové zložky</title>
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
<td>EuroSecom  -  Mzdové zložky 

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

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzddmn".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".dm=F$kli_vxcf"."_mzddmn.dm".
" LEFT JOIN F$kli_vxcf"."_str".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".str=F$kli_vxcf"."_str.str".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc >= 0 AND F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".dm > 0".
" ORDER BY F$kli_vxcf"."_mzdprcvypl$kli_uzid".".str,F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".dm,konx,prie,meno";

//echo $sqltt;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//exit;

$strana=1;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

$h_dao = SkDatum($rtov->dao);
$h_dni=$rtov->dni;
if( $rtov_dni == '0' ) { $h_dni=""; }
$h_hod=$rtov->hod;
if( $rtov_hod == '0' ) { $h_hod=""; }
$h_kc=$rtov->kc;
if( $rtov_kc == '0' ) { $h_kc=""; }

//hlavicka strany
if ( $j == 0 )
     {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$pdf->SetFont('arial','',10);
$pdf->Cell(90,6,"Mzdové zložky za STREDISKÁ obdobie $kli_vume","LTB",0,"L");
$pdf->Cell(90,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(115,6,"STREDISKO $rtov->str $rtov->nst","0",1,"L");

$pdf->SetFont('arial','',9);
$pdf->Cell(15,6,"DM","1",0,"R");$pdf->Cell(40,6,"Meno","1",0,"R");
$pdf->Cell(20,6,"Dni","1",0,"R");$pdf->Cell(20,6,"Hodiny","1",0,"R");$pdf->Cell(25,6,"Suma","1",1,"R");

$pdf->Cell(15,6,"$rtov->dm","0",0,"R");$pdf->Cell(0,6,"$rtov->nzdm Úètovanie: Zamestnanec $rtov->su/$rtov->au Spoloèník,konate¾ $rtov->suc/$rtov->auc","0",1,"L");


     }
//koniec hlavicky j=0


if( $rtov->konx == 0 )
{
$pdf->SetFont('arial','',9);

$pdf->Cell(15,6,"$rtov->dm","0",0,"R");$pdf->Cell(40,6,"$rtov->oc $rtov->prie $rtov->meno $rtov->titl","0",0,"L");
$pdf->Cell(20,6,"$h_dni","0",0,"R");$pdf->Cell(20,6,"$h_hod","0",0,"R");$pdf->Cell(25,6,"$rtov->kc","0",1,"R");

}



if( $rtov->konx != 0 )
{

$pdf->Cell(15,6,"$rtov->dm","T",0,"R");$pdf->Cell(40,6,"SPOLU","T",0,"R");
$pdf->Cell(20,6,"$rtov->dni","T",0,"R");$pdf->Cell(20,6,"$rtov->hod","T",0,"R");$pdf->Cell(25,6,"$rtov->kc","T",1,"R");

$pdf->Cell(60,4,"","0",1,"L");
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

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalmesx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzaltrnx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalkunx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
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
