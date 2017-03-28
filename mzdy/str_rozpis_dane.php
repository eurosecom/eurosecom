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
   str          INT(7) DEFAULT 0,
   oc           INT(7) DEFAULT 0,
   xdrv         INT(7) DEFAULT 0,
   znizp        INT(1) DEFAULT 0,
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

//zober data zo sum 
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT 0,oc,0,0,".
"zdan_dnp,pdan_fnd,pdan_dnv,pdan_zn1,zakl_dan,odan_dnp,0,0,".
"odan_zrz,0,zfir_sp,zfir_ip,zfir_pn,zfir_up,zfir_gf,zfir_rf,".
"ozam_zp,ozam_np,ozam_sp,ozam_ip,ozam_pn,ozam_up,ozam_gf,ozam_rf,".
"ofir_zp,ofir_np,ofir_sp,ofir_ip,ofir_pn,ofir_up,ofir_gf,ofir_rf,".
"ozam_spolu,ofir_spolu,0,".
"1".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE ume = $kli_vume".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober rocne zuctovanie zo zalvy 
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT 0,oc,0,0,".
"0,0,0,0,0,0,0,0,".
"0,-(kc),0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
"0,0,0,".
"1".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume = $kli_vume AND ( dm = 903 OR dm = 953 )".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober bonus zo zalvy 
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT 0,oc,0,0,".
"0,0,0,0,0,0,-kc,0,".
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
"0,0,0,".
"1".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume = $kli_vume AND ( dm = 902 OR dm = 952 )".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln str,zak z mzdkun ak str=0 
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.",F$kli_vxcf"."_mzdkun".
" SET str=stz ".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc = F$kli_vxcf"."_mzdkun.oc AND str = 0 ".
"";
$dsql = mysql_query("$dsqlt");

//vypocitaj sucty
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET zzam_rf=zzam_up-zzam_gf-zfir_np".
" WHERE oc > 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//sumar za oc
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT str,oc,xdrv,0,".
"sum(zzam_zp),sum(zzam_np),sum(zzam_sp),sum(zzam_ip),sum(zzam_pn),sum(zzam_up),sum(zzam_gf),sum(zzam_rf),".
"sum(zfir_zp),sum(zfir_np),sum(zfir_sp),sum(zfir_ip),sum(zfir_pn),sum(zfir_up),sum(zfir_gf),sum(zfir_rf),".
"sum(ozam_zp),sum(ozam_np),sum(ozam_sp),sum(ozam_ip),sum(ozam_pn),sum(ozam_up),sum(ozam_gf),sum(ozam_rf),".
"sum(ofir_zp),sum(ofir_np),sum(ofir_sp),sum(ofir_ip),sum(ofir_pn),sum(ofir_up),sum(ofir_gf),sum(ofir_rf),".
"sum(ozam_spolu),sum(ofir_spolu),sum(celk_spolu),".
"0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY str,oc";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid." WHERE konx = 1 ";
$dsql = mysql_query("$dsqlt");

//sumar za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" SELECT str,oc,xdrv,0,".
"sum(zzam_zp),sum(zzam_np),sum(zzam_sp),sum(zzam_ip),sum(zzam_pn),sum(zzam_up),sum(zzam_gf),sum(zzam_rf),".
"sum(zfir_zp),sum(zfir_np),sum(zfir_sp),sum(zfir_ip),sum(zfir_pn),sum(zfir_up),sum(zfir_gf),sum(zfir_rf),".
"sum(ozam_zp),sum(ozam_np),sum(ozam_sp),sum(ozam_ip),sum(ozam_pn),sum(ozam_up),sum(ozam_gf),sum(ozam_rf),".
"sum(ofir_zp),sum(ofir_np),sum(ofir_sp),sum(ofir_ip),sum(ofir_pn),sum(ofir_up),sum(ofir_gf),sum(ofir_rf),".
"sum(ozam_spolu),sum(ofir_spolu),sum(celk_spolu),".
"9".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY str,konx";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT str,oc,xdrv,0,".
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
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>STR - Rozpis Dane z príjmu</title>
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
<td>EuroSecom  -  Rozpis Dane z príjmu 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/mzdzos$kli_uzid.pdf")) { $soubor = unlink("../tmp/mzdzos$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$neparne=1;

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_str".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".str=F$kli_vxcf"."_str.str".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc >= 0 ORDER BY F$kli_vxcf"."_mzdprcvypl$kli_uzid".".str,konx,prie,meno";

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


//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$pdf->SetFont('arial','',10);
$pdf->Cell(115,6,"Rozpis Dane z príjmov za STREDISKÁ obdobie $kli_vume","LTB",0,"L");
$pdf->Cell(135,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(115,6,"STREDISKO $rtov->str $rtov->nst","0",1,"L");

$pdf->SetFont('arial','',6);
$pdf->Cell(50,5," ","1",0,"L");$pdf->Cell(20,5," ","1",0,"R");$pdf->Cell(40,5,"Nezdanite¾né èasti","1",0,"C");
$pdf->Cell(20,5,"Pripoè.položka","1",0,"R");$pdf->Cell(20,5," ","1",0,"R");$pdf->Cell(20,5," ","1",0,"R");$pdf->Cell(20,5," ","1",0,"R");
$pdf->Cell(20,5," ","1",0,"R");$pdf->Cell(20,5," ","1",0,"R");
$pdf->Cell(20,5," ","1",1,"R");
$pdf->Cell(50,5,"Priezvisko,meno","1",0,"L");$pdf->Cell(20,5,"Úhrn zd.príj.","1",0,"R");$pdf->Cell(20,5,"-Poistné","1",0,"R");
$pdf->Cell(20,5,"-Na daòovníka","1",0,"R");$pdf->Cell(20,5,"+Zaplatené DDP","1",0,"R");$pdf->Cell(20,5,"Zdanite¾ná mzda","1",0,"R");
$pdf->Cell(20,5,"Daò","1",0,"R");$pdf->Cell(20,5,"Daòový bonus","1",0,"R");$pdf->Cell(20,5,"Roè.zúèt.","1",0,"R");$pdf->Cell(20,5,"Spolu","1",0,"R");
$pdf->Cell(20,5,"Zrážková daò","1",1,"R");

     }
//koniec hlavicky j=0


if( $rtov->konx == 0 )
{


$pdf->SetFont('arial','',8);

$pdf->Cell(50,5,"$rtov->prie $rtov->meno $rtov->titl","0",0,"L");$pdf->Cell(20,5,"$rtov->zzam_zp","0",0,"R");$pdf->Cell(20,5,"$rtov->zzam_np","0",0,"R");
$pdf->Cell(20,5,"$rtov->zzam_sp","0",0,"R");$pdf->Cell(20,5,"$rtov->zzam_ip","0",0,"R");$pdf->Cell(20,5,"$rtov->zzam_pn","0",0,"R");
$pdf->Cell(20,5,"$rtov->zzam_up","0",0,"R");$pdf->Cell(20,5,"$rtov->zzam_gf","0",0,"R");
$pdf->Cell(20,5,"$rtov->zfir_np","0",0,"R");$pdf->Cell(20,5,"$rtov->zzam_rf","0",0,"R");
$pdf->Cell(20,5,"$rtov->zfir_zp","0",1,"R");

}

if( $rtov->konx == 9 )
{
$pdf->Cell(250,3," ","B",1,"R");

$pdf->Cell(50,5,"CELKOM SPOLU","B",0,"L");$pdf->Cell(20,5,"$rtov->zzam_zp","B",0,"R");$pdf->Cell(20,5,"$rtov->zzam_np","B",0,"R");
$pdf->Cell(20,5,"$rtov->zzam_sp","B",0,"R");$pdf->Cell(20,5,"$rtov->zzam_ip","B",0,"R");$pdf->Cell(20,5,"$rtov->zzam_pn","B",0,"R");
$pdf->Cell(20,5,"$rtov->zzam_up","B",0,"R");$pdf->Cell(20,5,"$rtov->zzam_gf","B",0,"R");$pdf->Cell(20,5,"$rtov->zfir_np","B",0,"R");
$pdf->Cell(20,5,"$rtov->zzam_rf","B",0,"R");
$pdf->Cell(20,5,"$rtov->zfir_zp","B",1,"R");


}


}
$i = $i + 1;
$j = $j + 1;

if( $rtov->konx == 9 ) $j=0; //nova strana;
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
