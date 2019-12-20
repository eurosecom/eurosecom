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
$nepravidelny = 1*$_REQUEST['nepravidelny'];


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


$statsum = 1*$_REQUEST['statsum'];
$h_obdp = 1*$_REQUEST['h_obdp'];
$h_obdk = 1*$_REQUEST['h_obdk'];
if( $h_obdp == 0 ) $h_obdp=1;
if( $h_obdk == 0 ) $h_obdk=12;
$vyb_ume=$h_obdk.".".$kli_vrok;
$vyb_umep=$h_obdp.".".$kli_vrok;
$vyb_umek=$h_obdk.".".$kli_vrok;


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
   zdrv         INT(7) DEFAULT 0,
   znizp        INT(1) DEFAULT 0,
   pomer        DECIMAL(10,0) DEFAULT 0,
   neprav       DECIMAL(10,0) DEFAULT 0,
   zzam_zp      DECIMAL(10,2) DEFAULT 0,
   zzam_np      DECIMAL(10,2) DEFAULT 0,
   zzam_sp      DECIMAL(10,2) DEFAULT 0,
   zzam_ip      DECIMAL(10,2) DEFAULT 0,
   zzam_pn      DECIMAL(10,2) DEFAULT 0,
   zzam_up      DECIMAL(10,2) DEFAULT 0,
   zzam_gf      DECIMAL(10,2) DEFAULT 0,
   zzam_rf      DECIMAL(10,2) DEFAULT 0,
   zfir_zp      DECIMAL(10,2) DEFAULT 0,
   zfir_np      DECIMAL(10,2) DEFAULT 0,
   zfir_sp      DECIMAL(10,2) DEFAULT 0,
   zfir_ip      DECIMAL(10,2) DEFAULT 0,
   zfir_pn      DECIMAL(10,2) DEFAULT 0,
   zfir_up      DECIMAL(10,2) DEFAULT 0,
   zfir_gf      DECIMAL(10,2) DEFAULT 0,
   zfir_rf      DECIMAL(10,2) DEFAULT 0,
   ozam_zp      DECIMAL(10,2) DEFAULT 0,
   ozam_np      DECIMAL(10,2) DEFAULT 0,
   ozam_sp      DECIMAL(10,2) DEFAULT 0,
   ozam_ip      DECIMAL(10,2) DEFAULT 0,
   ozam_pn      DECIMAL(10,2) DEFAULT 0,
   ozam_up      DECIMAL(10,2) DEFAULT 0,
   ozam_gf      DECIMAL(10,2) DEFAULT 0,
   ozam_rf      DECIMAL(10,2) DEFAULT 0,
   ofir_zp      DECIMAL(10,2) DEFAULT 0,
   ofir_np      DECIMAL(10,2) DEFAULT 0,
   ofir_sp      DECIMAL(10,2) DEFAULT 0,
   ofir_ip      DECIMAL(10,2) DEFAULT 0,
   ofir_pn      DECIMAL(10,2) DEFAULT 0,
   ofir_up      DECIMAL(10,2) DEFAULT 0,
   ofir_gf      DECIMAL(10,2) DEFAULT 0,
   ofir_rf      DECIMAL(10,2) DEFAULT 0,
   ozam_spolu   DECIMAL(10,2) DEFAULT 0,
   ofir_spolu   DECIMAL(10,2) DEFAULT 0,
   celk_spolu   DECIMAL(10,2) DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid.$sqlt;
//$vytvor = mysql_query("$vsql");

//datumy pociatok a koniec mesiaca

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   datp          DATE,
   datk          DATE,
   fic          INT
);
prcdatum;

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $kli_vume);
$kli_mdph=$pole[0];
$kli_rdph=$pole[1];

$datp_dph=$kli_rdph.'-'.$kli_mdph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datp_dph', 0 )";
$ttqq = mysql_query("$ttvv");

$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$datp_dph',  datk=LAST_DAY('$datp_dph')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//echo $datp_dph."  ".$datk_dph;

//exit;

//koniec datumy pociatok a koniec mesiaca


//zober data zo sum vyplaty do banky
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,0,".
"sum_hru,zzam_np,zzam_sp,zzam_ip,zzam_pn,zzam_up,zzam_gf,zzam_rf,".
"zfir_zp,zfir_np,zfir_sp,zfir_ip,zfir_pn,zfir_up,zfir_gf,zfir_rf,".
"ozam_zp,ozam_np,ozam_sp,ozam_ip,ozam_pn,ozam_up,ozam_gf,ozam_rf,".
"ofir_zp,ofir_np,ofir_sp,ofir_ip,ofir_pn,ofir_up,ofir_gf,ofir_rf,".
"ozam_spolu,ofir_spolu,0,".
"9".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE ume = $kli_vume AND sspnie = 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober zamestnancov z kun ak by nemali nic v sumzal
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
"0,0,0,".
"9".
" FROM F$kli_vxcf"."_mzdzalkun".
" WHERE ume = $kli_vume AND spnie = 0 AND pom != 9 AND dan <= '$datk_dph' AND ( dav = '0000-00-00' OR dav > '$datk_dph' )".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,0,".
"sum(zzam_zp),sum(zzam_np),sum(zzam_sp),sum(zzam_ip),sum(zzam_pn),sum(zzam_up),sum(zzam_gf),sum(zzam_rf),".
"sum(zfir_zp),sum(zfir_np),sum(zfir_sp),sum(zfir_ip),sum(zfir_pn),sum(zfir_up),sum(zfir_gf),sum(zfir_rf),".
"sum(ozam_zp),sum(ozam_np),sum(ozam_sp),sum(ozam_ip),sum(ozam_pn),sum(ozam_up),sum(ozam_gf),sum(ozam_rf),".
"sum(ofir_zp),sum(ofir_np),sum(ofir_sp),sum(ofir_ip),sum(ofir_pn),sum(ofir_up),sum(ofir_gf),sum(ofir_rf),".
"sum(ozam_spolu),sum(ofir_spolu),sum(celk_spolu),".
"0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY oc";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 9";
$oznac = mysql_query("$sqtoz");

//vypocitaj sucty
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET ozam_spolu=ozam_np+ozam_sp+ozam_ip+ozam_pn+ozam_up+ozam_gf+ozam_rf,".
"ofir_spolu=ofir_np+ofir_sp+ofir_ip+ofir_pn+ofir_up+ofir_gf+ofir_rf, celk_spolu=ozam_spolu+ofir_spolu".
" WHERE oc > 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$nepravidelny=1;
if( $nepravidelny == 1 )
  {
if( $fir_mzdx03 == 1 )
     {

$mzdkun="mzdzalkunx".$kli_uzid;

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET F$kli_vxcf"."_mzdprcvypl$kli_uzid.pomer=pom ".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdpomer ".
" SET F$kli_vxcf"."_mzdprcvypl$kli_uzid.neprav=pm4 ".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.pomer = F$kli_vxcf"."_mzdpomer.pm ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

     }

  }

//suma za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" SELECT oc,0,0,0,9999,".
"sum(zzam_zp),sum(zzam_np),sum(zzam_sp),sum(zzam_ip),sum(zzam_pn),sum(zzam_up),sum(zzam_gf),sum(zzam_rf),".
"sum(zfir_zp),sum(zfir_np),sum(zfir_sp),sum(zfir_ip),sum(zfir_pn),sum(zfir_up),sum(zfir_gf),sum(zfir_rf),".
"sum(ozam_zp),sum(ozam_np),sum(ozam_sp),sum(ozam_ip),sum(ozam_pn),sum(ozam_up),sum(ozam_gf),sum(ozam_rf),".
"sum(ofir_zp),sum(ofir_np),sum(ofir_sp),sum(ofir_ip),sum(ofir_pn),sum(ofir_up),sum(ofir_gf),sum(ofir_rf),".
"sum(ozam_spolu),sum(ofir_spolu),sum(celk_spolu),".
"99".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY konx ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//suma za prav/neprav
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" SELECT oc,0,0,0,neprav,".
"sum(zzam_zp),sum(zzam_np),sum(zzam_sp),sum(zzam_ip),sum(zzam_pn),sum(zzam_up),sum(zzam_gf),sum(zzam_rf),".
"sum(zfir_zp),sum(zfir_np),sum(zfir_sp),sum(zfir_ip),sum(zfir_pn),sum(zfir_up),sum(zfir_gf),sum(zfir_rf),".
"sum(ozam_zp),sum(ozam_np),sum(ozam_sp),sum(ozam_ip),sum(ozam_pn),sum(ozam_up),sum(ozam_gf),sum(ozam_rf),".
"sum(ofir_zp),sum(ofir_np),sum(ofir_sp),sum(ofir_ip),sum(ofir_pn),sum(ofir_up),sum(ofir_gf),sum(ofir_rf),".
"sum(ozam_spolu),sum(ofir_spolu),sum(celk_spolu),".
"9".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY neprav";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,neprav,".
"zzam_zp,zzam_np,zzam_sp,zzam_ip,zzam_pn,zzam_up,zzam_gf,zzam_rf,".
"zfir_zp,zfir_np,zfir_sp,zfir_ip,zfir_pn,zfir_up,zfir_gf,zfir_rf,".
"ozam_zp,ozam_np,ozam_sp,ozam_ip,ozam_pn,ozam_up,ozam_gf,ozam_rf,".
"ofir_zp,ofir_np,ofir_sp,ofir_ip,ofir_pn,ofir_up,ofir_gf,ofir_rf,".
"ozam_spolu,ofir_spolu,celk_spolu,".
"konx".
" FROM F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" WHERE oc >= 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Rozpis odvodov SP</title>
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
<td>EuroSecom  -  Rozpis odvodov SP 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
$hhmmss = Date ("His", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$outfilexdel="../tmp/rozpis_".$kli_uzid."_*.*";
foreach (glob("$outfilexdel") as $filename) { unlink($filename); }
$outfilex="../tmp/rozpis_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$neparne=1;

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc >= 0 ORDER BY neprav,konx,prie,meno";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//exit;

$strana=1;
$j=0;           
$i=0;
$pcislo=1;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);


//hlavicka strany
if ( $j == 0 )
     {

$pdf->SetFont('arial','',10);
if( $statsum == 0 ) {
$pdf->Cell(135,6,"Rozpis odvodov do Sociálnej Poisovne za $kli_vume","LTB",0,"L");
}
if( $statsum == 1 ) {
$pdf->Cell(135,6,"Rozpis odvodov do Sociálnej Poisovne za $vyb_umep až $vyb_umek","LTB",0,"L");
}
$pdf->Cell(133,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',8);

$pdf->Cell(40,5,"Hr.mzda / Pomer","1",0,"R");$pdf->Cell(15,5,"Znec","1",0,"L");
$pdf->Cell(28,5,"NP","1",0,"C");$pdf->Cell(28,5,"SP","1",0,"C");$pdf->Cell(28,5,"IP","1",0,"C");
$pdf->Cell(28,5,"PvN","1",0,"C");$pdf->Cell(28,5,"UP","1",0,"C");$pdf->Cell(28,5,"GP","1",0,"C");$pdf->Cell(28,5,"RFS","1",0,"C");
$pdf->Cell(17,5,"Spolu","1",1,"C");

$pdf->Cell(40,5,"Priezvisko,meno","1",0,"L");$pdf->Cell(15,5,"Ztel","1",0,"L");
$pdf->Cell(14,5,"Zakl","1",0,"C");$pdf->Cell(14,5,"Odvod","1",0,"C");
$pdf->Cell(14,5,"Zakl","1",0,"C");$pdf->Cell(14,5,"Odvod","1",0,"C");
$pdf->Cell(14,5,"Zakl","1",0,"C");$pdf->Cell(14,5,"Odvod","1",0,"C");
$pdf->Cell(14,5,"Zakl","1",0,"C");$pdf->Cell(14,5,"Odvod","1",0,"C");
$pdf->Cell(14,5,"Zakl","1",0,"C");$pdf->Cell(14,5,"Odvod","1",0,"C");
$pdf->Cell(14,5,"Zakl","1",0,"C");$pdf->Cell(14,5,"Odvod","1",0,"C");
$pdf->Cell(14,5,"Zakl","1",0,"C");$pdf->Cell(14,5,"Odvod","1",0,"C");
$pdf->Cell(17,5,"Spolu","1",1,"C");

     }
//koniec hlavicky j=0


if( $rtov->konx == 0 )
{

$pdf->SetFont('arial','',7);

$pdf->Cell(40,5,"$rtov->zzam_zp / $rtov->pom","0",0,"R");$pdf->Cell(15,5,"Znec","0",0,"L");
$pdf->Cell(14,5,"$rtov->zzam_np","0",0,"R");$pdf->Cell(14,5,"$rtov->ozam_np","0",0,"R");
$pdf->Cell(14,5,"$rtov->zzam_sp","0",0,"R");$pdf->Cell(14,5,"$rtov->ozam_sp","0",0,"R");
$pdf->Cell(14,5,"$rtov->zzam_ip","0",0,"R");$pdf->Cell(14,5,"$rtov->ozam_ip","0",0,"R");
$pdf->Cell(14,5,"$rtov->zzam_pn","0",0,"R");$pdf->Cell(14,5,"$rtov->ozam_pn","0",0,"R");
$pdf->Cell(14,5,"","0",0,"R");$pdf->Cell(14,5,"","0",0,"R");
$pdf->Cell(14,5,"","0",0,"R");$pdf->Cell(14,5,"","0",0,"R");
$pdf->Cell(14,5,"","0",0,"R");$pdf->Cell(14,5,"","0",0,"R");
$pdf->Cell(17,5,"$rtov->ozam_spolu","0",1,"R");


$pdf->Cell(40,5,"$pcislo. $rtov->prie $rtov->meno $rtov->titl","B",0,"L");$pdf->Cell(15,5,"Ztel","B",0,"L");
$pdf->Cell(14,5,"$rtov->zfir_np","B",0,"R");$pdf->Cell(14,5,"$rtov->ofir_np","B",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_sp","0",0,"R");$pdf->Cell(14,5,"$rtov->ofir_sp","0",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_ip","0",0,"R");$pdf->Cell(14,5,"$rtov->ofir_ip","0",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_pn","0",0,"R");$pdf->Cell(14,5,"$rtov->ofir_pn","0",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_up","0",0,"R");$pdf->Cell(14,5,"$rtov->ofir_up","0",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_gf","0",0,"R");$pdf->Cell(14,5,"$rtov->ofir_gf","0",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_rf","0",0,"R");$pdf->Cell(14,5,"$rtov->ofir_rf","0",0,"R");
$pdf->Cell(17,5,"$rtov->ofir_spolu","0",1,"R");

}

if( $rtov->konx == 9 )
{
$pdf->Cell(268,5," ","B",1,"R");

$pdf->Cell(40,5,"$rtov->zzam_zp","0",0,"R");$pdf->Cell(15,5,"Znec","0",0,"L");
$pdf->Cell(14,5,"$rtov->zzam_np","0",0,"R");$pdf->Cell(14,5,"$rtov->ozam_np","0",0,"R");
$pdf->Cell(14,5,"$rtov->zzam_sp","0",0,"R");$pdf->Cell(14,5,"$rtov->ozam_sp","0",0,"R");
$pdf->Cell(14,5,"$rtov->zzam_ip","0",0,"R");$pdf->Cell(14,5,"$rtov->ozam_ip","0",0,"R");
$pdf->Cell(14,5,"$rtov->zzam_pn","0",0,"R");$pdf->Cell(14,5,"$rtov->ozam_pn","0",0,"R");
$pdf->Cell(14,5,"","0",0,"R");$pdf->Cell(14,5,"","0",0,"R");
$pdf->Cell(14,5,"","0",0,"R");$pdf->Cell(14,5,"","0",0,"R");
$pdf->Cell(14,5,"","0",0,"R");$pdf->Cell(14,5,"","0",0,"R");
$pdf->Cell(17,5,"$rtov->ozam_spolu","0",1,"R");


if( $rtov->neprav == 0 ) { $pdf->Cell(40,5,"SPOLU Pravidelný príjem","B",0,"L");$pdf->Cell(15,5,"Ztel","B",0,"L"); }
if( $rtov->neprav == 1 ) { $pdf->Cell(40,5,"SPOLU NEPravidelný príjem","B",0,"L");$pdf->Cell(15,5,"Ztel","B",0,"L"); }
$pdf->Cell(14,5,"$rtov->zfir_np","B",0,"R");$pdf->Cell(14,5,"$rtov->ofir_np","B",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_sp","B",0,"R");$pdf->Cell(14,5,"$rtov->ofir_sp","B",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_ip","B",0,"R");$pdf->Cell(14,5,"$rtov->ofir_ip","B",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_pn","B",0,"R");$pdf->Cell(14,5,"$rtov->ofir_pn","B",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_up","B",0,"R");$pdf->Cell(14,5,"$rtov->ofir_up","B",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_gf","B",0,"R");$pdf->Cell(14,5,"$rtov->ofir_gf","B",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_rf","B",0,"R");$pdf->Cell(14,5,"$rtov->ofir_rf","B",0,"R");
$pdf->Cell(17,5,"$rtov->ofir_spolu","B",1,"R");
$pdf->Cell(80,5,"SPOLU všetky odvody Zamnec + Zamtel: $rtov->celk_spolu €","1",1,"L");
$pdf->Cell(17,10," ","0",1,"R");$j=$j+2;
}

if( $rtov->konx == 99 )
{
$pdf->Cell(268,5," ","B",1,"R");

$pdf->Cell(40,5,"$rtov->zzam_zp","0",0,"R");$pdf->Cell(15,5,"Znec","0",0,"L");
$pdf->Cell(14,5,"$rtov->zzam_np","0",0,"R");$pdf->Cell(14,5,"$rtov->ozam_np","0",0,"R");
$pdf->Cell(14,5,"$rtov->zzam_sp","0",0,"R");$pdf->Cell(14,5,"$rtov->ozam_sp","0",0,"R");
$pdf->Cell(14,5,"$rtov->zzam_ip","0",0,"R");$pdf->Cell(14,5,"$rtov->ozam_ip","0",0,"R");
$pdf->Cell(14,5,"$rtov->zzam_pn","0",0,"R");$pdf->Cell(14,5,"$rtov->ozam_pn","0",0,"R");
$pdf->Cell(14,5,"","0",0,"R");$pdf->Cell(14,5,"","0",0,"R");
$pdf->Cell(14,5,"","0",0,"R");$pdf->Cell(14,5,"","0",0,"R");
$pdf->Cell(14,5,"","0",0,"R");$pdf->Cell(14,5,"","0",0,"R");
$pdf->Cell(17,5,"$rtov->ozam_spolu","0",1,"R");


$pdf->Cell(40,5,"SPOLU PRAV + NEPRAV","B",0,"L");$pdf->Cell(15,5,"Ztel","B",0,"L");
$pdf->Cell(14,5,"$rtov->zfir_np","B",0,"R");$pdf->Cell(14,5,"$rtov->ofir_np","B",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_sp","B",0,"R");$pdf->Cell(14,5,"$rtov->ofir_sp","B",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_ip","B",0,"R");$pdf->Cell(14,5,"$rtov->ofir_ip","B",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_pn","B",0,"R");$pdf->Cell(14,5,"$rtov->ofir_pn","B",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_up","B",0,"R");$pdf->Cell(14,5,"$rtov->ofir_up","B",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_gf","B",0,"R");$pdf->Cell(14,5,"$rtov->ofir_gf","B",0,"R");
$pdf->Cell(14,5,"$rtov->zfir_rf","B",0,"R");$pdf->Cell(14,5,"$rtov->ofir_rf","B",0,"R");
$pdf->Cell(17,5,"$rtov->ofir_spolu","B",1,"R");
$pdf->Cell(80,5,"SPOLU všetky odvody Zamnec + Zamtel: $rtov->celk_spolu €","1",1,"L");
}


}
$i = $i + 1;
$j = $j + 1;
$pcislo=$pcislo+1;
  }


$pdf->Output("$outfilex");



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
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
