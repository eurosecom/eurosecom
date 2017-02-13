<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$celeeura = 1*$_REQUEST['celeeura'];
$h_zos = $_REQUEST['h_zos'];
$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];
$h_drp = 1*$_REQUEST['h_drp'];
$suborxml = 1*$_REQUEST['suborxml'];

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//ramcek fpdf
$rmc=0;

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;


if (File_Exists ("../tmp/vmajzav$kli_vume.$kli_uzid.pdf")) { $soubor = unlink("../tmp/vmajzav$kli_vume.$kli_uzid.pdf"); }

$kompletka = 1*$_REQUEST['kompletka'];
if( $kompletka == 0 )
  {
   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

//350=sirka obdlznika 0 znamena do konca , 15=vyska obdlznika , $riadok-text , "0"=border ano 0 nie
//parameter druhy zlava 1=kurzor prejde na zaciatok riadku,0 kurzor pokracuje na riadku,2 kurzor ide nad riadok
//L=zarovnanie left alebo C=center R=right
//$pdf->Cell(350,15,"$riadok","$rmc",1,"L");
//$rest = substr("abcdef", 0, 4); // vrátí "abcd"

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
  }

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvmajzavs'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$sqlt = <<<prcvmajzavs
(
   prx          INT,
   uce          VARCHAR(10),
   ucm          VARCHAR(10),
   ucd          VARCHAR(10),
   rdk          INT,
   prv          INT,
   hod          DECIMAL(10,2),
   pri          DECIMAL(10,2),
   vyd          DECIMAL(10,2),
   r01          DECIMAL(10,2),
   r02          DECIMAL(10,2),
   r03          DECIMAL(10,2),
   r04          DECIMAL(10,2),
   r05          DECIMAL(10,2),
   r06          DECIMAL(10,2),
   r07          DECIMAL(10,2),
   r08          DECIMAL(10,2),
   r09          DECIMAL(10,2),
   r10          DECIMAL(10,2),
   r11          DECIMAL(10,2),
   r12          DECIMAL(10,2),
   r13          DECIMAL(10,2),
   r14          DECIMAL(10,2),
   r15          DECIMAL(10,2),
   r98          DECIMAL(10,2),
   r16          DECIMAL(10,2),
   r17          DECIMAL(10,2),
   r18          DECIMAL(10,2),
   r19          DECIMAL(10,2),
   r20          DECIMAL(10,2),
   r21          DECIMAL(10,2),
   r99          DECIMAL(10,2),
   ico          INT
);
prcvmajzavs;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcvmajzavs'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


//zober stav pokladnice,banka,priebezne z posledne vytvoreneho pendennika druh1
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvmajzavs$kli_uzid"." SELECT".
" 0,pokc,'','',0,0,0,(hotp-hotv),0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,$fir_fico".
" FROM F".$kli_vxcf."_prcpendens".$kli_uzid." ".
" WHERE uro = 1 AND LEFT(pokc,3) = 211 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvmajzavs$kli_uzid"." SELECT".
" 0,ucbc,'','',0,0,0,(ucbp-ucbv),0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,$fir_fico".
" FROM F".$kli_vxcf."_prcpendens".$kli_uzid." ".
" WHERE uro = 1 AND LEFT(ucbc,3) = 221 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvmajzavs$kli_uzid"." SELECT".
" 0,'26100','','',0,0,0,(prbp-prbv),0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,$fir_fico".
" FROM F".$kli_vxcf."_prcpendens".$kli_uzid." ".
" WHERE uro = 1 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//saldo odber a dodav z posledne vytvorenej zostavy salda

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvmajzavs$kli_uzid"." SELECT".
" 0,'31100','','',0,0,0,(zos),0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,$fir_fico".
" FROM F".$kli_vxcf."_prsaldoicofak".$kli_uzid." ".
" WHERE F".$kli_vxcf."_prsaldoicofak".$kli_uzid.".uce = 31100 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvmajzavs$kli_uzid"." SELECT".
" 0,'32100','','',0,0,0,(zos),0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,$fir_fico".
" FROM F".$kli_vxcf."_prsaldoicofak".$kli_uzid." ".
" WHERE F".$kli_vxcf."_prsaldoicofak".$kli_uzid.".uce = 32100 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//tu vezmi zasoby  ak je nahrate v uctskl  na uctoch 11200,13200,12300 a ma nastavene 
//cislo crs v uctosnova

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvmajzavs$kli_uzid"." SELECT".
" 0,ucm,'','',0,0,0,(hod),0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,$fir_fico".
" FROM F".$kli_vxcf."_uctskl ".
" WHERE F".$kli_vxcf."_uctskl.hod != 0 AND ume = $kli_vume ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//tu vezmi zasoby  ak vediete podsystem a spracujete mesacny stav zasob polozkovite ucty 11200,13200,12300 podla skladov a ma nastavene 
//cislo crs v uctosnova

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvmajzavs$kli_uzid"." SELECT".
" 0,0,skl,'999112',0,0,0,(hod),0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,$fir_fico".
" FROM F".$kli_vxcf."_sklprcd$kli_uzid ".
" WHERE F".$kli_vxcf."_sklprcd$kli_uzid.hod != 0 AND pox = 9 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid,F$kli_vxcf"."_skl".
" SET uce=F$kli_vxcf"."_skl.ucs".
" WHERE F$kli_vxcf"."_prcvmajzavs$kli_uzid.ucm = F$kli_vxcf"."_skl.skl AND ucd = 999112 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");


//tu vezmi  majetok ak je nahraty v  uctmaj na uctoch 01900,02200... a ma nastavene 
//cislo crs v uctosnova

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvmajzavs$kli_uzid"." SELECT".
" 0,ucm,'','',0,0,0,(hod),0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,$fir_fico".
" FROM F".$kli_vxcf."_uctmaj ".
" WHERE F".$kli_vxcf."_uctmaj.hod != 0 AND ume = $kli_vume ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//tu vezmi majetok  ak vediete podsystem a spracujete mesacne odpisy  ucty 022,11900 podla druhu a ma nastavene 
//cislo crs v uctosnova

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvmajzavs$kli_uzid"." SELECT".
" 0,0,drm,'999022',0,0,0,(zos),0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,$fir_fico".
" FROM F".$kli_vxcf."_majmaj ".
" WHERE F".$kli_vxcf."_majmaj.zos != 0 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid,F$kli_vxcf"."_majdrm".
" SET uce=F$kli_vxcf"."_majdrm.ucmzar".
" WHERE F$kli_vxcf"."_prcvmajzavs$kli_uzid.ucm = F$kli_vxcf"."_majdrm.cdrm AND ucd = 999022 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");


//nastav crs podla uce
$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid,F$kli_vxcf"."_uctgenmajzavnoju".
" SET rdk=F$kli_vxcf"."_uctgenmajzavnoju.crs".
" WHERE F$kli_vxcf"."_prcvmajzavs$kli_uzid.uce = F$kli_vxcf"."_uctgenmajzavnoju.uce ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//rozdel do riadkov
$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r01=pri-vyd WHERE rdk = 1 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r02=pri-vyd WHERE rdk = 2 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r03=pri-vyd WHERE rdk = 3 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r04=pri-vyd WHERE rdk = 4 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r05=pri-vyd WHERE rdk = 5 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r06=pri-vyd WHERE rdk = 6 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r07=pri-vyd WHERE rdk = 7 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r08=pri-vyd WHERE rdk = 8 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r09=pri-vyd WHERE rdk = 9 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r10=pri-vyd WHERE rdk = 10 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r11=r01+r02+r03+r04+r05+r06+r07+r08+r09+r10 WHERE rdk > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r12=pri-vyd WHERE rdk = 12 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r13=pri-vyd WHERE rdk = 13 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r14=pri-vyd WHERE rdk = 14 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r15=pri-vyd WHERE rdk = 15 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r16=pri-vyd WHERE rdk = 16 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r16=r12+r13+r14+r15 WHERE rdk > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvmajzavs$kli_uzid SET r17=r11-r16 WHERE rdk > 0 ";
$oznac = mysql_query("$sqtoz");


//sumar za riadky
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvmajzavs$kli_uzid "." SELECT".
" 1,uce,ucm,ucd,rdk,prv,hod,pri,vyd,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),".
"SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),SUM(r11),SUM(r12),SUM(r13),SUM(r14),".
"SUM(r15),SUM(r98),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),SUM(r21),".
"SUM(r99),$fir_fico".
" FROM F$kli_vxcf"."_prcvmajzavs$kli_uzid".
" WHERE rdk > 0".
" GROUP BY prx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

//poc.stav
$sqltpoc = <<<prcpred
(
   dok          INT,
   hod          DECIMAL(10,2),
   rm01         DECIMAL(10,2),
   fic          INT
);
prcpred;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctpocmajzavnoju_stl'.$sqltpoc;
$ulozene = mysql_query("$sql");



//obdobie vypocitaj
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
if( $kli_mdph < 10 ) $kli_mdph='0'.$kli_mdph;

$pole = explode(".", $kli_vume);
$mesp_dph=$pole[0];
$mesk_dph=$pole[0];
$rokp_dph=$pole[1];

$datp_dph=$rokp_dph.'-'.$mesp_dph.'-01';
$datk_dph=$rokp_dph.'-'.$mesk_dph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datp_dph', 0 )";
$ttqq = mysql_query("$ttvv");


$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$datp_dph',  datk=LAST_DAY('$datk_dph')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sqlkk = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sqlkk,0))
  {
  $riadok=mysql_fetch_object($sqlkk);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//echo $datk_sk;
//exit;

$datp_sk=SkDatum($datp_dph);
$datk_sk=SkDatum($datk_dph);

$pole = explode(".", $datk_sk);
$denk_sk=$pole[0];
$mesk_sk=$pole[1];
$rokk_sk=$pole[2]-2000;
if( $rokk_sk < 10 ) $rokk_sk='0'.$rokk_sk;


//uzavierka NO 2013
$kompletka = 1*$_REQUEST['kompletka'];
if( $kompletka == 1 )
  {
$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];
$h_drp = $_REQUEST['h_drp'];
?>
<script type="text/javascript">

window.open('../ucto/uzavierka_no2013.php?copern=10&drupoh=1&tis=0&h_zos=<?php echo $h_zos; ?>&h_sch=<?php echo $h_sch; ?>&h_drp=<?php echo $h_drp; ?>&page=1&kompletka=1', '_self' )


</script>
<?php
exit;
  }


//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvmajzavs".$kli_uzid." WHERE prx = 1 ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

if( $pol == 0 )
  {
$sqltt = "INSERT INTO F$kli_vxcf"."_prcvmajzavs".$kli_uzid." ( prx ) VALUES ( 1 ) ";
$sql = mysql_query("$sqltt");
  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvmajzavs".$kli_uzid." ".
" LEFT JOIN F$kli_vxcf"."_uctpocmajzavnoju_stl".
" ON F$kli_vxcf"."_prcvmajzavs$kli_uzid.prx=F$kli_vxcf"."_uctpocmajzavnoju_stl.fic".
" WHERE prx = 1 "."";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);


$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i < $pol )
  {


//strana1
$pdf->AddPage();
$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy_ju2013/majzavjuno_str1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_ju2013/majzavjuno_str1.jpg',1,14,210,297);
}

$pdf->SetY(10);
$pdf->SetFont('arial','',10);

//obdobie k
$pdf->Cell(195,43,"     ","$rmc",1,"L");
$Adenk=substr($denk_sk,0,1);
$Bdenk=substr($denk_sk,1,1);
$Amesk=substr($mesk_sk,0,1);
$Bmesk=substr($mesk_sk,1,1);
$Arokk=substr($rokk_sk,0,1);
$Brokk=substr($rokk_sk,1,1);

$pdf->Cell(75,6," ","$rmc",0,"C");$pdf->Cell(15,6,"$Adenk$Bdenk. $Amesk$Bmesk.","$rmc",0,"C");$pdf->Cell(12,6," ","$rmc",0,"C");
$pdf->Cell(8,6,"$Arokk$Brokk","$rmc",1,"L");


//uctovne obdobie od do
$pdf->Cell(195,12,"     ","$rmc",1,"L"); 
$rokp_sk=$rokk_sk;
$mesp_sk="01";
$rokp08_sk=$rokk_sk-1;
if( $rokp08_sk < 10 ) $rokp08_sk="0".$rokp08_sk;
$mesp08_sk="01";
$rokk08_sk=$rokk_sk-1;
if( $rokk08_sk < 10 ) $rokk08_sk="0".$rokk08_sk;
$mesk08_sk="12";

$Amesp=substr($mesp_sk,0,1);
$Bmesp=substr($mesp_sk,1,1);
$Arokp=substr($rokp_sk,0,1);
$Brokp=substr($rokp_sk,1,1);
$Amesk08=substr($mesk08_sk,0,1);
$Bmesk08=substr($mesk08_sk,1,1);
$Arokk08=substr($rokk08_sk,0,1);
$Brokk08=substr($rokk08_sk,1,1);
$Amesp08=substr($mesp08_sk,0,1);
$Bmesp08=substr($mesp08_sk,1,1);
$Arokp08=substr($rokp08_sk,0,1);
$Brokp08=substr($rokp08_sk,1,1);

$pdf->Cell(50,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$Amesp","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$Bmesp","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"2","$rmc",0,"C");$pdf->Cell(6,6,"0","$rmc",0,"C");$pdf->Cell(6,6,"$Arokp","$rmc",0,"C");$pdf->Cell(6,6,"$Brokp","$rmc",0,"C");
$pdf->Cell(20,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$Amesk","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$Bmesk","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"2","$rmc",0,"C");$pdf->Cell(6,6,"0","$rmc",0,"C");$pdf->Cell(6,6,"$Arokk","$rmc",0,"C");$pdf->Cell(6,6,"$Brokk","$rmc",1,"C");


//krizik riadna,mimoriadna,priebezna
$pdf->Cell(195,12,"     ","$rmc",1,"L");
$riadna="x"; $mimoriadna=" "; $priebezna=" ";
if( $h_drp == 2 ) { $riadna=" "; $mimoriadna="x"; $priebezna=" "; }
if( $h_drp == 3 ) { $riadna=" "; $mimoriadna=" "; $priebezna="x"; }

$pdf->Cell(97,5," ","$rmc",0,"R");$pdf->Cell(6,6,"$riadna","$rmc",1,"C");
$pdf->Cell(195,2,"     ","$rmc",1,"L");
$pdf->Cell(97,5," ","$rmc",0,"R");$pdf->Cell(6,6,"$mimoriadna","$rmc",1,"C");
$pdf->Cell(195,2,"     ","$rmc",1,"L");
$pdf->Cell(97,5," ","$rmc",0,"R");$pdf->Cell(6,6,"$priebezna","$rmc",1,"C");


//dic
$pdf->Cell(195,-3,"     ","$rmc",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);

$pdf->Cell(4,6," ","$rmc",0,"R");
$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(6,6,"$D","$rmc",0,"C");
$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(5,6,"$F","$rmc",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(6,6,"$I","$rmc",0,"C");$pdf->Cell(5,6,"$J","$rmc",1,"C");


//ico
$pdf->Cell(195,7,"     ","$rmc",1,"L");
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);

$pdf->Cell(4,6," ","$rmc",0,"R");
$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(6,6,"$B","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(6,6,"$E","$rmc",0,"C");$pdf->Cell(5,6,"$F","$rmc",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");$pdf->Cell(6,6,"$H","$rmc",0,"C");
$pdf->Cell(37,5," ","$rmc",0,"C");


//sknace
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sn1a=substr($sknacea,0,1);
$sn2a=substr($sknacea,1,1);

$sknaceb=$pole[1];
$sn1b=substr($sknaceb,0,1);
$sn2b=substr($sknaceb,1,1);
$sknacec=$pole[2];
$sn1c=substr($sknacec,0,1);
$sn2c=substr($sknacec,1,1);

$pdf->Cell(5,6,"$sn1a","$rmc",0,"C");$pdf->Cell(6,6,"$sn2a","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(6,6,"$sn1b","$rmc",0,"C");$pdf->Cell(5,6,"$sn2b","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$sn1c","$rmc",1,"C");


//nazov uj r1
$pdf->Cell(195,13,"     ","$rmc",1,"L");
$A=substr($fir_fnaz,0,1);$B=substr($fir_fnaz,1,1);$C=substr($fir_fnaz,2,1);$D=substr($fir_fnaz,3,1);$E=substr($fir_fnaz,4,1);
$F=substr($fir_fnaz,5,1);$G=substr($fir_fnaz,6,1);$H=substr($fir_fnaz,7,1);$I=substr($fir_fnaz,8,1);$J=substr($fir_fnaz,9,1);
$K=substr($fir_fnaz,10,1);$L=substr($fir_fnaz,11,1);$M=substr($fir_fnaz,12,1);$N=substr($fir_fnaz,13,1);$O=substr($fir_fnaz,14,1);
$P=substr($fir_fnaz,15,1);$R=substr($fir_fnaz,16,1);$S=substr($fir_fnaz,17,1);$T=substr($fir_fnaz,18,1);$U=substr($fir_fnaz,19,1);
$V=substr($fir_fnaz,20,1);$W=substr($fir_fnaz,21,1);$X=substr($fir_fnaz,22,1);$Y=substr($fir_fnaz,23,1);$Z=substr($fir_fnaz,24,1);
$A1=substr($fir_fnaz,25,1);$B1=substr($fir_fnaz,26,1);$C1=substr($fir_fnaz,27,1);$D1=substr($fir_fnaz,28,1);$E1=substr($fir_fnaz,29,1);
$F1=substr($fir_fnaz,30,1);$G1=substr($fir_fnaz,31,1);

$pdf->Cell(4,6," ","$rmc",0,"R");
$pdf->Cell(6,6,"$A","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(6,6,"$C","$rmc",0,"C");$pdf->Cell(6,6,"$D","$rmc",0,"C");
$pdf->Cell(6,6,"$E","$rmc",0,"C");$pdf->Cell(6,6,"$F","$rmc",0,"C");$pdf->Cell(6,6,"$G","$rmc",0,"C");$pdf->Cell(6,6,"$H","$rmc",0,"C");
$pdf->Cell(6,6,"$I","$rmc",0,"C");$pdf->Cell(6,6,"$J","$rmc",0,"C");$pdf->Cell(6,6,"$K","$rmc",0,"C");$pdf->Cell(6,6,"$L","$rmc",0,"C");
$pdf->Cell(6,6,"$M","$rmc",0,"C");$pdf->Cell(5,6,"$N","$rmc",0,"C");$pdf->Cell(6,6,"$O","$rmc",0,"C");$pdf->Cell(6,6,"$P","$rmc",0,"C");
$pdf->Cell(6,6,"$R","$rmc",0,"C");$pdf->Cell(6,6,"$S","$rmc",0,"C");$pdf->Cell(6,6,"$T","$rmc",0,"C");$pdf->Cell(6,6,"$U","$rmc",0,"C");
$pdf->Cell(6,6,"$V","$rmc",0,"C");$pdf->Cell(6,6,"$W","$rmc",0,"C");$pdf->Cell(5,6,"$X","$rmc",0,"C");$pdf->Cell(6,6,"$Y","$rmc",0,"C");
$pdf->Cell(6,6,"$Z","$rmc",0,"C");$pdf->Cell(6,6,"$A1","$rmc",0,"C");$pdf->Cell(6,6,"$B1","$rmc",0,"C");$pdf->Cell(6,6,"$C1","$rmc",0,"C");
$pdf->Cell(6,6,"$D1","$rmc",0,"C");$pdf->Cell(6,6,"$E1","$rmc",0,"C");$pdf->Cell(6,6,"$F1","$rmc",0,"C");$pdf->Cell(5,6,"$G1","$rmc",1,"C");


//nazov r2
$pdf->Cell(195,1,"     ","$rmc",1,"L");
$fir_fnazr2=substr($fir_fnaz,30,30);
$A=substr($fir_fnazr2,0,1);$B=substr($fir_fnazr2,1,1);$C=substr($fir_fnazr2,2,1);$D=substr($fir_fnazr2,3,1);$E=substr($fir_fnazr2,4,1);
$F=substr($fir_fnazr2,5,1);$G=substr($fir_fnazr2,6,1);$H=substr($fir_fnazr2,7,1);$I=substr($fir_fnazr2,8,1);$J=substr($fir_fnazr2,9,1);
$K=substr($fir_fnazr2,10,1);$L=substr($fir_fnazr2,11,1);$M=substr($fir_fnazr2,12,1);$N=substr($fir_fnazr2,13,1);$O=substr($fir_fnazr2,14,1);
$P=substr($fir_fnazr2,15,1);$R=substr($fir_fnazr2,16,1);$S=substr($fir_fnazr2,17,1);$T=substr($fir_fnazr2,18,1);$U=substr($fir_fnazr2,19,1);
$V=substr($fir_fnazr2,20,1);$W=substr($fir_fnazr2,21,1);$X=substr($fir_fnazr2,22,1);$Y=substr($fir_fnazr2,23,1);$Z=substr($fir_fnazr2,24,1);
$A1=substr($fir_fnazr2,25,1);$B1=substr($fir_fnazr2,26,1);$C1=substr($fir_fnazr2,27,1);$D1=substr($fir_fnazr2,28,1);$E1=substr($fir_fnazr2,29,1);
$F1=substr($fir_fnazr2,30,1);$G1=substr($fir_fnazr2,31,1);

$pdf->Cell(4,6," ","$rmc",0,"R");
$pdf->Cell(6,6,"$A","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(6,6,"$C","$rmc",0,"C");$pdf->Cell(6,6,"$D","$rmc",0,"C");
$pdf->Cell(6,6,"$E","$rmc",0,"C");$pdf->Cell(6,6,"$F","$rmc",0,"C");$pdf->Cell(6,6,"$G","$rmc",0,"C");$pdf->Cell(6,6,"$H","$rmc",0,"C");
$pdf->Cell(6,6,"$I","$rmc",0,"C");$pdf->Cell(6,6,"$J","$rmc",0,"C");$pdf->Cell(6,6,"$K","$rmc",0,"C");$pdf->Cell(6,6,"$L","$rmc",0,"C");
$pdf->Cell(6,6,"$M","$rmc",0,"C");$pdf->Cell(5,6,"$N","$rmc",0,"C");$pdf->Cell(6,6,"$O","$rmc",0,"C");$pdf->Cell(6,6,"$P","$rmc",0,"C");
$pdf->Cell(6,6,"$R","$rmc",0,"C");$pdf->Cell(6,6,"$S","$rmc",0,"C");$pdf->Cell(6,6,"$T","$rmc",0,"C");$pdf->Cell(6,6,"$U","$rmc",0,"C");
$pdf->Cell(6,6,"$V","$rmc",0,"C");$pdf->Cell(6,6,"$W","$rmc",0,"C");$pdf->Cell(5,6,"$X","$rmc",0,"C");$pdf->Cell(6,6,"$Y","$rmc",0,"C");
$pdf->Cell(6,6,"$Z","$rmc",0,"C");$pdf->Cell(6,6,"$A1","$rmc",0,"C");$pdf->Cell(6,6,"$B1","$rmc",0,"C");$pdf->Cell(6,6,"$C1","$rmc",0,"C");
$pdf->Cell(6,6,"$D1","$rmc",0,"C");$pdf->Cell(6,6,"$E1","$rmc",0,"C");$pdf->Cell(6,6,"$F1","$rmc",0,"C");$pdf->Cell(5,6,"$G1","$rmc",1,"C");


//ulica a cislo
$pdf->Cell(195,14,"     ","$rmc",1,"L");
$fir_fulicis=$fir_fuli." ".$fir_fcdm;

$A=substr($fir_fulicis,0,1);$B=substr($fir_fulicis,1,1);$C=substr($fir_fulicis,2,1);$D=substr($fir_fulicis,3,1);$E=substr($fir_fulicis,4,1);
$F=substr($fir_fulicis,5,1);$G=substr($fir_fulicis,6,1);$H=substr($fir_fulicis,7,1);$I=substr($fir_fulicis,8,1);$J=substr($fir_fulicis,9,1);
$K=substr($fir_fulicis,10,1);$L=substr($fir_fulicis,11,1);$M=substr($fir_fulicis,12,1);$N=substr($fir_fulicis,13,1);$O=substr($fir_fulicis,14,1);
$P=substr($fir_fulicis,15,1);$R=substr($fir_fulicis,16,1);$S=substr($fir_fulicis,17,1);$T=substr($fir_fulicis,18,1);$U=substr($fir_fulicis,19,1);
$V=substr($fir_fulicis,20,1);$W=substr($fir_fulicis,21,1);$X=substr($fir_fulicis,22,1);$Y=substr($fir_fulicis,23,1);$Z=substr($fir_fulicis,24,1);
$A1=substr($fir_fulicis,25,1);$B1=substr($fir_fulicis,26,1);$C1=substr($fir_fulicis,27,1);$D1=substr($fir_fulicis,28,1);$E1=substr($fir_fulicis,29,1);

$pdf->Cell(4,6," ","$rmc",0,"R");
$pdf->Cell(6,6,"$A","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(6,6,"$C","$rmc",0,"C");$pdf->Cell(6,6,"$D","$rmc",0,"C");
$pdf->Cell(6,6,"$E","$rmc",0,"C");$pdf->Cell(6,6,"$F","$rmc",0,"C");$pdf->Cell(6,6,"$G","$rmc",0,"C");$pdf->Cell(6,6,"$H","$rmc",0,"C");
$pdf->Cell(6,6,"$I","$rmc",0,"C");$pdf->Cell(6,6,"$J","$rmc",0,"C");$pdf->Cell(6,6,"$K","$rmc",0,"C");$pdf->Cell(6,6,"$L","$rmc",0,"C");
$pdf->Cell(6,6,"$M","$rmc",0,"C");$pdf->Cell(5,6,"$N","$rmc",0,"C");$pdf->Cell(6,6,"$O","$rmc",0,"C");$pdf->Cell(6,6,"$P","$rmc",0,"C");
$pdf->Cell(6,6,"$R","$rmc",0,"C");$pdf->Cell(6,6,"$S","$rmc",0,"C");$pdf->Cell(6,6,"$T","$rmc",0,"C");$pdf->Cell(6,6,"$U","$rmc",0,"C");
$pdf->Cell(6,6,"$V","$rmc",0,"C");$pdf->Cell(6,6,"$W","$rmc",0,"C");$pdf->Cell(5,6,"$X","$rmc",0,"C");$pdf->Cell(6,6,"$Y","$rmc",0,"C");
$pdf->Cell(6,6,"$Z","$rmc",0,"C");$pdf->Cell(6,6,"$A1","$rmc",0,"C");$pdf->Cell(6,6,"$B1","$rmc",0,"C");$pdf->Cell(6,6,"$C1","$rmc",0,"C");
$pdf->Cell(6,6,"$D1","$rmc",0,"C");$pdf->Cell(6,6,"$E1","$rmc",0,"C");$pdf->Cell(6,6,"$F1","$rmc",0,"C");$pdf->Cell(5,6,"$G1","$rmc",1,"C");



//psc
$pdf->Cell(195,16,"     ","$rmc",1,"L");
$A=substr($fir_fpsc,0,1);
$B=substr($fir_fpsc,1,1);
$C=substr($fir_fpsc,2,1);
$D=substr($fir_fpsc,3,1);
$E=substr($fir_fpsc,4,1);

$pdf->Cell(4,5," ","$rmc",0,"R");$pdf->Cell(6,6,"$A","$rmc",0,"C");$pdf->Cell(6,6,"$B","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");
$pdf->Cell(6,6,"$D","$rmc",0,"C");$pdf->Cell(6,6,"$E","$rmc",0,"C");


//obec
$A=substr($fir_fmes,0,1); $B=substr($fir_fmes,1,1); $C=substr($fir_fmes,2,1); $D=substr($fir_fmes,3,1); $E=substr($fir_fmes,4,1);
$F=substr($fir_fmes,5,1); $G=substr($fir_fmes,6,1); $H=substr($fir_fmes,7,1); $I=substr($fir_fmes,8,1); $J=substr($fir_fmes,9,1); 
$K=substr($fir_fmes,10,1); $L=substr($fir_fmes,11,1); $M=substr($fir_fmes,12,1); $N=substr($fir_fmes,13,1); $O=substr($fir_fmes,14,1);
$P=substr($fir_fmes,15,1); $R=substr($fir_fmes,16,1); $S=substr($fir_fmes,17,1); $T=substr($fir_fmes,18,1); $U=substr($fir_fmes,19,1);
$V=substr($fir_fmes,20,1); $W=substr($fir_fmes,21,1); $X=substr($fir_fmes,22,1); $Y=substr($fir_fmes,23,1); $Z=substr($fir_fmes,24,1);
$A1=substr($fir_fmes,25,1);

$pdf->Cell(6,5," ","$rmc",0,"R");
$pdf->Cell(6,6,"$A","$rmc",0,"C");$pdf->Cell(6,6,"$B","$rmc",0,"C");$pdf->Cell(6,6,"$C","$rmc",0,"C");$pdf->Cell(6,6,"$D","$rmc",0,"C");
$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(6,6,"$F","$rmc",0,"C");$pdf->Cell(6,6,"$G","$rmc",0,"C");$pdf->Cell(6,6,"$H","$rmc",0,"C");
$pdf->Cell(6,6,"$I","$rmc",0,"C");$pdf->Cell(6,6,"$J","$rmc",0,"C");$pdf->Cell(6,6,"$K","$rmc",0,"C");$pdf->Cell(6,6,"$L","$rmc",0,"C");
$pdf->Cell(6,6,"$M","$rmc",0,"C");$pdf->Cell(6,6,"$N","$rmc",0,"C");$pdf->Cell(6,6,"$O","$rmc",0,"C");$pdf->Cell(6,6,"$P","$rmc",0,"C");
$pdf->Cell(5,6,"$R","$rmc",0,"C");$pdf->Cell(6,6,"$S","$rmc",0,"C");$pdf->Cell(6,6,"$T","$rmc",0,"C");$pdf->Cell(6,6,"$U","$rmc",0,"C");
$pdf->Cell(6,6,"$V","$rmc",0,"C");$pdf->Cell(6,6,"$W","$rmc",0,"C");$pdf->Cell(6,6,"$X","$rmc",0,"C");$pdf->Cell(6,6,"$Y","$rmc",0,"C");
$pdf->Cell(6,6,"$Z","$rmc",0,"C");$pdf->Cell(6,6,"$A1","$rmc",1,"C");


//telefon
$pdf->Cell(195,7,"     ","$rmc",1,"L");
$pdf->SetFont('arial','',10);
$pole = explode("/", $fir_ftel);
$tel_pred=1*$pole[0];
if( $tel_pred == 0 ) { $tel_pred=""; }
$tel_za=$pole[1];

$A1=substr($tel_pred,0,1);$B1=substr($tel_pred,1,1);$C1=substr($tel_pred,2,1);
$A=substr($tel_za,0,1);$B=substr($tel_za,1,1);$C=substr($tel_za,2,1);$D=substr($tel_za,3,1);$E=substr($tel_za,4,1);$F=substr($tel_za,5,1);
$G=substr($tel_za,6,1);$H=substr($tel_za,7,1);$I=substr($tel_za,8,1);$J=substr($tel_za,9,1);$K=substr($tel_za,10,1);$L=substr($tel_za,11,1);

$pdf->Cell(9,6," ","$rmc",0,"C");
$pdf->Cell(6,6,"$A1","$rmc",0,"C");$pdf->Cell(5,6,"$B1","$rmc",0,"C");$pdf->Cell(5,6,"$C1","$rmc",0,"C");$pdf->Cell(18,6," ","$rmc",0,"C");

$pdf->Cell(6,6,"$A","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(6,6,"$C","$rmc",0,"C");$pdf->Cell(6,6,"$D","$rmc",0,"C");
$pdf->Cell(6,6,"$E","$rmc",0,"C");$pdf->Cell(6,6,"$F","$rmc",0,"C");$pdf->Cell(6,6,"$G","$rmc",0,"C");$pdf->Cell(6,6,"$H","$rmc",0,"C");
$pdf->Cell(6,6,"$I","$rmc",0,"C");$pdf->Cell(5,6,"$J","$rmc",0,"C");$pdf->Cell(6,6,"$K","$rmc",0,"C");$pdf->Cell(6,6,"$L","$rmc",0,"C");

//fax
$pdf->SetFont('arial','',10);
$pole = explode("/", $fir_ffax);
$fax_pred=$pole[0];
$fax_za=$pole[1];

$A=substr($fax_pred,0,1);$B=substr($fax_pred,1,1);$C=substr($fax_pred,2,1);$D=substr($fax_pred,3,1);

$E=substr($fax_za,0,1);$F=substr($fax_za,1,1);$G=substr($fax_za,2,1);$H=substr($fax_za,3,1);$I=substr($fax_za,4,1);$J=substr($fax_za,5,1);
$K=substr($fax_za,6,1);$L=substr($fax_za,7,1);

$pdf->Cell(9,6," ","$rmc",0,"C");
$pdf->Cell(6,6,"$A","$rmc",0,"C");$pdf->Cell(6,6,"$B","$rmc",0,"C");$pdf->Cell(6,6,"$C","$rmc",0,"C");$pdf->Cell(6,6,"$D","$rmc",0,"C");
$pdf->Cell(6,6,"/","$rmc",0,"C");$pdf->Cell(6,6,"$E","$rmc",0,"C");  $pdf->Cell(6,6,"$F","$rmc",0,"C");
$pdf->Cell(5,6,"$G","$rmc",0,"C");$pdf->Cell(6,6,"$H","$rmc",0,"C");$pdf->Cell(6,6,"$I","$rmc",0,"C");
$pdf->Cell(6,6,"$J","$rmc",0,"C");$pdf->Cell(6,6,"$K","$rmc",1,"C");


//email
$pdf->SetFont('arial','',9);
$pdf->Cell(195,8,"     ","0",1,"L");
$fir_fulicis=$fir_fem1;

$A=substr($fir_fem1,0,1);$B=substr($fir_fem1,1,1);$C=substr($fir_fem1,2,1);$D=substr($fir_fem1,3,1);$E=substr($fir_fem1,4,1);
$F=substr($fir_fem1,5,1);$G=substr($fir_fem1,6,1);$H=substr($fir_fem1,7,1);$I=substr($fir_fem1,8,1);$J=substr($fir_fem1,9,1);
$K=substr($fir_fem1,10,1);$L=substr($fir_fem1,11,1);$M=substr($fir_fem1,12,1);$N=substr($fir_fem1,13,1);$O=substr($fir_fem1,14,1);
$P=substr($fir_fem1,15,1);$R=substr($fir_fem1,16,1);$S=substr($fir_fem1,17,1);$T=substr($fir_fem1,18,1);$U=substr($fir_fem1,19,1);
$V=substr($fir_fem1,20,1);$W=substr($fir_fem1,21,1);$X=substr($fir_fem1,22,1);$Y=substr($fir_fem1,23,1);$Z=substr($fir_fem1,24,1);
$A1=substr($fir_fem1,25,1);$B1=substr($fir_fem1,26,1);$C1=substr($fir_fem1,27,1);$D1=substr($fir_fem1,28,1);$E1=substr($fir_fem1,29,1);
$F1=substr($fir_fem1,30,1);$G1=substr($fir_fem1,31,1);

$pdf->Cell(4,6," ","$rmc",0,"R");
$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(6,6,"$B","$rmc",0,"C");$pdf->Cell(6,6,"$C","$rmc",0,"C");$pdf->Cell(6,6,"$D","$rmc",0,"C");
$pdf->Cell(6,6,"$E","$rmc",0,"C");$pdf->Cell(6,6,"$F","$rmc",0,"C");$pdf->Cell(6,6,"$G","$rmc",0,"C");$pdf->Cell(6,6,"$H","$rmc",0,"C");
$pdf->Cell(5,6,"$I","$rmc",0,"C");$pdf->Cell(6,6,"$J","$rmc",0,"C");$pdf->Cell(6,6,"$K","$rmc",0,"C");$pdf->Cell(6,6,"$L","$rmc",0,"C");
$pdf->Cell(6,6,"$M","$rmc",0,"C");$pdf->Cell(5,6,"$N","$rmc",0,"C");$pdf->Cell(6,6,"$O","$rmc",0,"C");$pdf->Cell(6,6,"$P","$rmc",0,"C");
$pdf->Cell(6,6,"$R","$rmc",0,"C");$pdf->Cell(6,6,"$S","$rmc",0,"C");$pdf->Cell(6,6,"$T","$rmc",0,"C");$pdf->Cell(6,6,"$U","$rmc",0,"C");
$pdf->Cell(6,6,"$V","$rmc",0,"C");$pdf->Cell(6,6,"$W","$rmc",0,"C");$pdf->Cell(6,6,"$X","$rmc",0,"C");$pdf->Cell(6,6,"$Y","$rmc",0,"C");
$pdf->Cell(6,6,"$Z","$rmc",0,"C");$pdf->Cell(6,6,"$A1","$rmc",0,"C");$pdf->Cell(5,6,"$B1","$rmc",0,"C");$pdf->Cell(6,6,"$C1","$rmc",0,"C");
$pdf->Cell(6,6,"$D1","$rmc",0,"C");$pdf->Cell(6,6,"$E1","$rmc",0,"C");$pdf->Cell(6,6,"$F1","$rmc",0,"C");$pdf->Cell(6,6,"$G1","$rmc",1,"C");


//datum zostavenia
$pdf->SetFont('arial','',10);
$h_zos = $_REQUEST['h_zos'];
$pdf->SetY(245);
$pdf->SetX(25);
$pdf->Cell(37,6,"$h_zos","$rmc",1,"C");


//strana2
if ( $j == 0 )
{
$pdf->AddPage();
$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy_ju2013/majzavjuno_str2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_ju2013/majzavjuno_str2.jpg',0,0,210,298);
}
$pdf->SetFont('arial','',10);

//ico
$pdf->Cell(195,9,"     ","$rmc",1,"L");
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);

$pdf->Cell(98,6," ","$rmc",0,"R");
$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(6,6,"$C","$rmc",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(5,6,"$F","$rmc",0,"C");$pdf->Cell(6,6,"$G","$rmc",0,"C");$pdf->Cell(5,6,"$H","$rmc",1,"C");

}
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$r01=$hlavicka->r01;
if( $hlavicka->r01 == 0 ) $r01="";
$r02=$hlavicka->r02;
if( $hlavicka->r02 == 0 ) $r02="";
$r03=$hlavicka->r03;
if( $hlavicka->r03 == 0 ) $r03="";
$r04=$hlavicka->r04;
if( $hlavicka->r04 == 0 ) $r04="";
$r05=$hlavicka->r05;
if( $hlavicka->r05 == 0 ) $r05="";
$r06=$hlavicka->r06;
if( $hlavicka->r06 == 0 ) $r06="";
$r07=$hlavicka->r07;
if( $hlavicka->r07 == 0 ) $r07="";
$r08=$hlavicka->r08;
if( $hlavicka->r08 == 0 ) $r08="";
$r09=$hlavicka->r09;
if( $hlavicka->r09 == 0 ) $r09="";
$r10=$hlavicka->r10;
if( $hlavicka->r10 == 0 ) $r10="";
$r11=$hlavicka->r11;
if( $hlavicka->r11 == 0 ) $r11="";
$r12=$hlavicka->r12;
if( $hlavicka->r12 == 0 ) $r12="";
$r13=$hlavicka->r13;
if( $hlavicka->r13 == 0 ) $r13="";
$r14=$hlavicka->r14;
if( $hlavicka->r14 == 0 ) $r14="";
$r15=$hlavicka->r15;
if( $hlavicka->r15 == 0 ) $r15="";
$r16=$hlavicka->r16;
if( $hlavicka->r16 == 0 ) $r16="";
$r17=$hlavicka->r17;
if( $hlavicka->r17 == 0 ) $r17="";

$rm01=$hlavicka->rm01;
if( $hlavicka->rm01 == 0 ) $rm01="";
$rm02=$hlavicka->rm02;
if( $hlavicka->rm02 == 0 ) $rm02="";
$rm03=$hlavicka->rm03;
if( $hlavicka->rm03 == 0 ) $rm03="";
$rm04=$hlavicka->rm04;
if( $hlavicka->rm04 == 0 ) $rm04="";
$rm05=$hlavicka->rm05;
if( $hlavicka->rm05 == 0 ) $rm05="";
$rm06=$hlavicka->rm06;
if( $hlavicka->rm06 == 0 ) $rm06="";
$rm07=$hlavicka->rm07;
if( $hlavicka->rm07 == 0 ) $rm07="";
$rm08=$hlavicka->rm08;
if( $hlavicka->rm08 == 0 ) $rm08="";
$rm09=$hlavicka->rm09;
if( $hlavicka->rm09 == 0 ) $rm09="";
$rm10=$hlavicka->rm10;
if( $hlavicka->rm10 == 0 ) $rm10="";
$rm11=$hlavicka->rm11;
if( $hlavicka->rm11 == 0 ) $rm11="";
$rm12=$hlavicka->rm12;
if( $hlavicka->rm12 == 0 ) $rm12="";
$rm13=$hlavicka->rm13;
if( $hlavicka->rm13 == 0 ) $rm13="";
$rm14=$hlavicka->rm14;
if( $hlavicka->rm14 == 0 ) $rm14="";
$rm15=$hlavicka->rm15;
if( $hlavicka->rm15 == 0 ) $rm15="";
$rm16=$hlavicka->rm16;
if( $hlavicka->rm16 == 0 ) $rm16="";
$rm17=$hlavicka->rm17;
if( $hlavicka->rm17 == 0 ) $rm17="";


//MAJETOK
$pdf->Cell(100,33,"     ","$rmc",1,"L");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,6,"$r01","$rmc",0,"R");$pdf->Cell(32,6,"$rm01","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,10,"$r02","$rmc",0,"R");$pdf->Cell(32,10,"$rm02","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,9,"$r03","$rmc",0,"R");$pdf->Cell(32,9,"$rm03","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,8,"$r04","$rmc",0,"R");$pdf->Cell(32,8,"$rm04","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,9,"$r05","$rmc",0,"R");$pdf->Cell(32,9,"$rm05","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,9,"$r06","$rmc",0,"R");$pdf->Cell(32,9,"$rm06","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,9,"$r07","$rmc",0,"R");$pdf->Cell(32,9,"$rm07","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,9,"$r08","$rmc",0,"R");$pdf->Cell(32,9,"$rm08","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,9,"$r09","$rmc",0,"R");$pdf->Cell(32,9,"$rm09","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,9,"$r10","$rmc",0,"R");$pdf->Cell(32,9,"$rm10","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,7,"$r11","$rmc",0,"R");$pdf->Cell(32,7,"$rm11","$rmc",1,"R");


//ZAVAZKY
$pdf->Cell(100,44,"     ","$rmc",1,"L");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,6,"$r12","$rmc",0,"R");$pdf->Cell(32,6,"$rm12","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,10,"$r13","$rmc",0,"R");$pdf->Cell(32,10,"$rm13","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,8,"$r14","$rmc",0,"R");$pdf->Cell(32,8,"$rm14","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,9,"$r15","$rmc",0,"R");$pdf->Cell(32,9,"$rm15","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,9,"$r16","$rmc",0,"R");$pdf->Cell(32,9,"$rm16","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc",0,"C");$pdf->Cell(33,9,"$r17","$rmc",0,"R");$pdf->Cell(32,9,"$rm17","$rmc",1,"R");


}
$i = $i + 1;
$j = $j + 1;

if( $j == 35 ) $j=0;

  }
//koniec hlavicky

$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];
$suborxml = 1*$_REQUEST['suborxml'];
if( $suborxml == 1 )                     { ?>
<script type="text/javascript">
window.open('../ucto/vmajzav_xml.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1&h_zos=<?php echo $h_zos; ?>&h_sch=<?php echo $h_sch; ?>', '_self' );
</script>
<?php 
exit;
                                         } 

$pdf->Output("../tmp/vmajzav$kli_vume.$kli_uzid.pdf");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvmajzavs'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvmajzavs1000x'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/vmajzav<?php echo $kli_vume; ?>.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Vykaz o majetku a zavazkoch NO JU PDF</title>
</HEAD>
<BODY class="white" >

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
