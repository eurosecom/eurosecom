<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 2000;
$clsm = 901;
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

$podmume="ume = ".$kli_vume;

if( $copern == 2 )
{
$h_obdp = 1*$_REQUEST['h_obdp'];
$h_obdk = 1*$_REQUEST['h_obdk'];

$ume_obdp = $h_obdp.".".$kli_vrok;
$ume_obdk = $h_obdk.".".$kli_vrok;
$podmume="ume >= $ume_obdp AND ume <= $ume_obdk";
}


$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalmesx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalmes WHERE $podmume";
//$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzaltrnx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzaltrn WHERE $podmume";
//$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalddpx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalddp WHERE $podmume";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalkunx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalkun WHERE $podmume";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalprmx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalprm WHERE $podmume";
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
   vpom         INT(7) DEFAULT 0,
   dm           INT(7) DEFAULT 0,
   str          INT(7) DEFAULT 0,
   zak          INT(7) DEFAULT 0,
   dni          DECIMAL(10,2) DEFAULT 0,
   hod          DECIMAL(10,2) DEFAULT 0,
   kc           DECIMAL(10,2) DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0,
   cel_hru      DECIMAL(10,2) DEFAULT 0,
   cel_nem      DECIMAL(10,2) DEFAULT 0,
   cel_zrz      DECIMAL(10,2) DEFAULT 0,
   cel_zsp      DECIMAL(10,2) DEFAULT 0,
   cel_fsp      DECIMAL(10,2) DEFAULT 0,
   cel_zzp      DECIMAL(10,2) DEFAULT 0,
   cel_fzp      DECIMAL(10,2) DEFAULT 0,
   cel_scf      DECIMAL(10,2) DEFAULT 0,
   konx1        DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid.$sqlt;
//$vytvor = mysql_query("$vsql");

//zober data z vy 
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,vpom,dm,str,zak,".
"dni,hod,kc,".
"0,".
"cel_hru,cel_nem,cel_zrz,".
"0,0,0,0,0,".
"0".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE $podmume AND dm != 0 AND dm != 9504 AND dm != 9505 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober data zo sum 
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,9001,0,0,".
"sum_hot,sum_ban,0,".
"0,".
"0,0,0,".
"(ozam_np+ozam_sp+ozam_ip+ozam_pn),(ofir_np+ofir_sp+ofir_ip+ofir_pn+ofir_up+ofir_gf+ofir_rf),ozam_zp,ofir_zp,0,".
"0".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE $podmume ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


////socialny fond

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   dru         INT,
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT,
   dmn         INT,
   br          INT,
   pom         INT,
   kon         INT,
   oc          INT,
   ico         INT,
   fak         INT,
   pds         INT,
   pms         INT,
   str         INT,
   zak         INT,
   hod         DECIMAL(10,2),
   ucm         INT(10),
   ucd         INT(10)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprc'.$sqlt;
$vytvor = mysql_query("$vsql");


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc".
" SELECT 1,ume,'0000-00-00','0000-00-00',dm,0,0,0,oc,0,0,0,0,str,zak,kc,0,0 FROM F$kli_vxcf"."_mzdzalvy WHERE dm != 904 AND kc != 0 AND $podmume ".
" ORDER BY oc".
"";
$dsql = mysql_query("$dsqlt");

$mzdkun="mzdzalkunx".$kli_uzid;

//dopln pom z mzdkun
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc,F$kli_vxcf"."_$mzdkun".
" SET F$kli_vxcf"."_mzdprc.pom = F$kli_vxcf"."_$mzdkun.pom ".
" WHERE F$kli_vxcf"."_mzdprc.oc = F$kli_vxcf"."_$mzdkun.oc".
"";
$dsql = mysql_query("$dsqlt");

//dopln kon = konatel  z mzdpomer
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc,F$kli_vxcf"."_mzdpomer".
" SET kon=pm_maj, pms=np_soc ".
" WHERE F$kli_vxcf"."_mzdprc.pom = F$kli_vxcf"."_mzdpomer.pm".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln br,prs pre dm z ciselnika dmn
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc,F$kli_vxcf"."_mzddmn".
" SET pds = prs ".
" WHERE F$kli_vxcf"."_mzdprc.dmn = F$kli_vxcf"."_mzddmn.dm".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $soc_perc=$riaddok->soc_perc;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc".
" SET hod=$soc_perc*hod*pds*pms/100 ".
" WHERE oc > 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,9004,0,0,".
"0,0,0,".
"0,".
"0,0,0,".
"0,0,0,0,hod,".
"0".
" FROM F$kli_vxcf"."_mzdprc".
" WHERE $podmume ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx';
$vysledok = mysql_query("$sqlt");

//koniec soc.fond


//vypocitaj zrazky
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET cel_zrz=kc".
" WHERE dm >= 900 AND dm <= 990";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" SELECT oc,vpom,dm,str,zak,".
"SUM(dni),SUM(hod),SUM(kc),".
"0,".
"SUM(cel_hru),SUM(cel_nem),SUM(cel_zrz),".
"0,0,0,0,0,".
"0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE dm > 0".
" GROUP BY dm";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//vypocitaj zrazky
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET dni=0, hod=0 ".
" WHERE dm != 9001";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" SELECT oc,vpom,dm,str,zak,".
"SUM(dni),SUM(hod),SUM(kc),".
"9,".
"SUM(cel_hru),SUM(cel_nem),SUM(cel_zrz),".
"SUM(cel_zsp),SUM(cel_fsp),SUM(cel_zzp),SUM(cel_fzp),SUM(cel_scf),".
"0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE dm > 0".
" GROUP BY konx";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvyplx$kli_uzid WHERE dm >= 9000 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Prehlad Brutto</title>
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
<?php if ( $copern == 1 OR $copern == 2 ) { echo "<td>EuroSecom  -  Preh¾ad Brutto "; } ?>
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
////////////////////////////////////MESACNA ZOSTAVA
if ( $copern == 1 OR $copern == 2 )
          {

$hhmmss = Date ("His", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$outfilexdel="../tmp/mzdzos_".$kli_uzid."_*.*";
foreach (glob("$outfilexdel") as $filename) { unlink($filename); }
$outfilex="../tmp/mzdzos_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$neparne=1;

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvyplx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzddmn".
" ON F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.".dm=F$kli_vxcf"."_mzddmn.dm".
" WHERE oc >= 0 ORDER BY konx,F$kli_vxcf"."_mzdprcvyplx$kli_uzid".".dm";

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

$zzam_ddp=$rtov->zzam_ddp;
if( $rtov->zzam_ddp == 0 ) $zzam_ddp="";
$ozam_ddp=$rtov->ozam_ddp;
if( $rtov->ozam_ddp == 0 ) $ozam_ddp="";
$ofir_ddp=$rtov->ofir_ddp;
if( $rtov->ofir_ddp == 0 ) $ofir_ddp="";

//hlavicka strany
if ( $j == 0 AND $rtov->konx == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$pdf->SetFont('arial','',10);
if ( $copern == 1 ) { $pdf->Cell(115,6,"Preh¾ad brutto miezd za $kli_vume","LTB",0,"L"); }
if ( $copern == 2 ) { $pdf->Cell(115,6,"Preh¾ad brutto miezd za $ume_obdp / $ume_obdk","LTB",0,"L"); }
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',8);


$pdf->Cell(50,5,"DM ","1",0,"L");$pdf->Cell(20,5,"Dni","1",0,"R");$pdf->Cell(20,5,"Hodiny","1",0,"R");$pdf->Cell(25,5,"Hodnota v €","1",0,"R");
$pdf->Cell(0,5,"Úètovanie Zamestnanec/Spoloèník,konate¾","1",1,"L");
     }
//koniec hlavicky j=0


if( $rtov->konx == 0 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(50,5,"$rtov->dm $rtov->nzdm","0",0,"L");
$pdf->Cell(20,5,"$rtov->dni","0",0,"R");$pdf->Cell(20,5,"$rtov->hod","0",0,"R");$pdf->Cell(25,5,"$rtov->kc","0",0,"R");
$pdf->Cell(0,5,"$rtov->su $rtov->au / $rtov->suc $rtov->auc","0",1,"L");

}

if( $rtov->konx == 9 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(0,5,"","T",1,"L");

$pdf->Cell(45,5,"Celkom výplata v hotovosti","0",0,"L");$pdf->Cell(25,5,"$rtov->dni","0",1,"R");
$pdf->Cell(45,5,"Celkom výplata cez banku dm935","0",0,"L");$pdf->Cell(25,5,"$rtov->hod","0",1,"R");
$pdf->Cell(25,5," ","0",1,"R");

$pdf->Cell(45,5,"Celkom hrubá mzda","0",0,"L");$pdf->Cell(25,5,"$rtov->cel_hru","0",1,"R");
$pdf->Cell(45,5,"Celkom výplaty nemoc. a iné","0",0,"L");$pdf->Cell(25,5,"$rtov->cel_nem","0",1,"R");
$pdf->Cell(45,5,"Celkom zrážky","0",0,"L");$pdf->Cell(25,5,"$rtov->cel_zrz","0",1,"R");
$pdf->Cell(25,5," ","0",1,"R");
$pdf->Cell(45,5,"Celkom odvod SP zamestnanec","0",0,"L");$pdf->Cell(25,5,"$rtov->cel_zsp","0",1,"R");
$pdf->Cell(45,5,"Celkom odvod SP zamestnávate¾","0",0,"L");$pdf->Cell(25,5,"$rtov->cel_fsp","0",1,"R");
$pdf->Cell(45,5,"Celkom odvod ZP zamestnanec","0",0,"L");$pdf->Cell(25,5,"$rtov->cel_zzp","0",1,"R");
$pdf->Cell(45,5,"Celkom odvod ZP zamestnávate¾","0",0,"L");$pdf->Cell(25,5,"$rtov->cel_fzp","0",1,"R");
$pdf->Cell(45,5,"Celkom tvorba sociálny fond","0",0,"L");$pdf->Cell(25,5,"$rtov->cel_scf","0",1,"R");
}

}
$i = $i + 1;
$j = $j + 1;

if( $rtov->konx == 9 ) $j=0; //nova strana;
  }

$pdf->Output("$outfilex");


?> 

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>

?>

<?php

          }
////////////////////////////////////KONIEC MESACNA ZOSTAVA
?>




<?php
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

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
