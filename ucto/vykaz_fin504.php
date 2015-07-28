<HTML>
<?php

do
{
$sys = 'UCT';
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

//ramcek fpdf
$rmc=0;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$stvrtrok = 1*$_REQUEST['cislo_oc'];
$subor = 1*$_REQUEST['subor'];
$strana = 1*$_REQUEST['strana'];
if( $strana == 0 ) $strana=9999;
$strana=2;

if( $cislo_oc == 0 ) $cislo_oc=1;
if( $cislo_oc == 1 ) { $datum="31.03.".$kli_vrok; $mesiac="03"; $kli_vume="3.".$kli_vrok; }
if( $cislo_oc == 2 ) { $datum="30.06.".$kli_vrok; $mesiac="06"; $kli_vume="6.".$kli_vrok; }
if( $cislo_oc == 3 ) { $datum="30.09.".$kli_vrok; $mesiac="09"; $kli_vume="9.".$kli_vrok; }
if( $cislo_oc == 4 ) { $datum="31.12.".$kli_vrok; $mesiac="12"; $kli_vume="12.".$kli_vrok; }


$vsetkyprepocty=0;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


// vymaz polozku
if ( $copern == 316 )
    {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];

$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin504 WHERE cpl = $cislo_cpl";
$oznac = mysql_query("$sqtoz");
$copern=20;

    }
//koniec vymaz polozku


// zapis polozku
if ( $copern == 23 )
    {


if ( $strana == 2 )    {

$okres = strip_tags($_REQUEST['okres']);
$obec = strip_tags($_REQUEST['obec']);
$daz = $_REQUEST['daz'];
$daz_sql = SqlDatum($daz);
$stlpa = strip_tags($_REQUEST['stlpa']);
$stlpb = strip_tags($_REQUEST['stlpb']);
$stlp1 = strip_tags($_REQUEST['stlp1']);
$stlp2 = strip_tags($_REQUEST['stlp2']);
$stlp3 = strip_tags($_REQUEST['stlp3']);
$stlp4 = strip_tags($_REQUEST['stlp4']);
$stlp5 = strip_tags($_REQUEST['stlp5']);
$stlp1 = str_replace(".","",$stlp1);
$stlp2 = str_replace(".","",$stlp2);

$rs00003 = 1*strip_tags($_REQUEST['rs00003']);
$rs00004 = 1*strip_tags($_REQUEST['rs00004']);

$uprtxt = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin504 (oc,druh,stlpa,stlpb,stlp1,stlp2,stlp3,stlp4,stlp5,stlp6,rs00003,rs00004) VALUES ".
" (  '$stvrtrok', 1, '$stlpa', '$stlpb', '$stlp1', '$stlp2', '$stlp3', '$stlp4', '$stlp5', '$stlp6', '$rs00003', '$rs00004' ) ";
if( $stlp5 >= 0 OR $stlp6 >= 0 ) { $upravene = mysql_query("$uprtxt"); }

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin504 SET okres='$okres', obec='$obec', daz='$daz_sql'  ";
$upravene = mysql_query("$uprtxt");
//echo $uprtxt;
                       }



$copern=20;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu polozky

//prac.subor a subor 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sql = "SELECT px01 FROM F".$kli_vxcf."_uctvykaz_fin504";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin504';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin504d2';
$vysledok = mysql_query("$sqlt");

$desat=0;
  while ($desat < 1 )
  {
$pocdes="10,0";
if( $desat == 1 ) $pocdes="10,2";

$sqlt = <<<mzdprc
(
   cpl         int not null auto_increment,
   px01         DECIMAL($pocdes) DEFAULT 0,
   oc           INT(7) DEFAULT 0,
   druh         DECIMAL(10,0) DEFAULT 0,
   okres        VARCHAR(11) NOT NULL,
   obec         VARCHAR(11) NOT NULL,
   daz          DATE NOT NULL,
   stlpa        VARCHAR(11) NOT NULL,
   stlpb        VARCHAR(11) NOT NULL,
   stlp1        DECIMAL(4,0) DEFAULT 0,
   stlp2        DECIMAL(4,0) DEFAULT 0,
   stlp3        DECIMAL(10,0) DEFAULT 0,
   stlp4        DATE NOT NULL,
   stlp5        DECIMAL(10,0) DEFAULT 0,
   stlp6        DECIMAL(10,0) DEFAULT 0,
   PRIMARY KEY(cpl)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctvykaz_fin504'.$sqlt;
if( $desat == 1 ) $vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctvykaz_fin504d2'.$sqlt;
$vytvor = mysql_query("$vsql");

$desat=$desat+1;
  }
//koniec while


}
//koniec vytvorenie 

$sql = "SELECT xxb FROM F".$kli_vxcf."_uctvykaz_fin504";
$vysledok = mysql_query($sql);
if (!$vysledok)
{

$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin504 MODIFY stlp1 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin504 MODIFY stlp2 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin504 MODIFY stlp3 VARCHAR(11) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin504 MODIFY stlp4 DECIMAL(10,2) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin504 MODIFY stlp5 DECIMAL(10,2) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin504 ADD xxb DECIMAL(10,0) DEFAULT 0 AFTER stlp6";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT rs00004 FROM F".$kli_vxcf."_uctvykaz_fin504";
$vysledok = mysql_query($sql);
if (!$vysledok)
{

$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin504 ADD rs00003 DECIMAL(10,2) DEFAULT 0 AFTER xxb ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin504 ADD rs00004 DECIMAL(10,2) DEFAULT 0 AFTER xxb ";
$vysledek = mysql_query("$sql");

}

//vypocty
if( $copern == 10 OR $copern == 20 )
{



}
//koniec vypocty


/////////////////////////////////////////////////VYTLAC ROCNE
if( $copern == 10 )
{

if (File_Exists ("../tmp/vykazfin.$kli_uzid.pdf")) { $soubor = unlink("../tmp/vykazfin.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


//vytlac

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_fin504";
$vytvor = mysql_query("$vsql");


//sumare
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." "." SELECT".
" 0,1,oc,druh,okres,obec,daz,".
" '','',stlp1,stlp2,stlp3,SUM(stlp4),SUM(stlp5),SUM(stlp6),0,rs00003,rs00004 ".
" FROM F$kli_vxcf"."_uctvykaz_fin504".
" WHERE druh = 1 ".
" GROUP BY druh ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");



$sqltt = "SELECT * FROM F$kli_vxcf"."_uctprcvykazx".$kli_uzid." ".
" WHERE F$kli_vxcf"."_uctprcvykazx$kli_uzid.oc >= 0  ORDER BY px01,cpl ";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0;
$hlavickavydavky=0;
$hlavickaprijmy=0;

  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i) )
{
$hlavicka=mysql_fetch_object($sql);


$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$dat_dat = SkDatum($hlavicka->da21 );
if( $dat_dat == '0000-00-00' ) $dat_dat="";

//prva strana j=0
if ( $j == 0 )    {

$pdf->AddPage();
$pdf->SetLeftMargin(8); 
$pdf->SetTopMargin(10);

//od tehoto velkost strany a presne

if (File_Exists ('../dokumenty/vykazy_nujfin2013/fin504/fin504_str1.jpg') )
{
$pdf->Image('../dokumenty/vykazy_nujfin2013/fin504/fin504_str1.jpg',0,1,210,296); 
}

$pdf->SetY(10);
$pdf->SetFont('arial','',10);

//obdobie k
$pdf->Cell(195,54,"                          ","$rmc",1,"L");
$text=$datum;
$textx="14.01.2010";
$t01=substr($text,0,1);

$pdf->Cell(78,6," ","$rmc",0,"R");$pdf->Cell(42,6,"$text","$rmc",1,"C");


//iËo
$pdf->Cell(195,38,"                          ","$rmc",1,"L");
$text=$fir_fico;
$textx="12345678";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);

$pdf->Cell(1,5," ","$rmc",0,"R");
$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5," ","$rmc",0,"C");


//mesiac
$text=$mesiac;
$textx="12345678";
$t01=substr($text,0,1);
$t02=substr($text,1,1);

$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5," ","$rmc",0,"C");


//rok
$text=$kli_vrok;
$textx="1234";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);

$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5," ","$rmc",0,"C");


//kod okresu
$text=$hlavicka->okres;
$textx="123";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);

$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(24,5," ","$rmc",0,"C");


//kod obce
$text=$hlavicka->obec;
$textx="123456";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);

$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",1,"C");


//nazov subj. VS
$pdf->Cell(195,14,"                          ","$rmc",1,"L");
$text=$fir_fnaz;
$textx="0123456789abcdefghijklmnoprstuv";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);

$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(6,5,"$t10","$rmc",0,"C");$pdf->Cell(6,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(6,5,"$t13","$rmc",0,"C");$pdf->Cell(6,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(6,5,"$t16","$rmc",0,"C");
$pdf->Cell(6,5,"$t17","$rmc",0,"C");$pdf->Cell(6,5,"$t18","$rmc",0,"C");$pdf->Cell(6,5,"$t19","$rmc",0,"C");$pdf->Cell(6,5,"$t20","$rmc",0,"C");
$pdf->Cell(6,5,"$t21","$rmc",0,"C");$pdf->Cell(6,5,"$t22","$rmc",0,"C");$pdf->Cell(6,5,"$t23","$rmc",0,"C");$pdf->Cell(6,5,"$t24","$rmc",0,"C");
$pdf->Cell(6,5,"$t25","$rmc",0,"C");$pdf->Cell(6,5,"$t26","$rmc",0,"C");$pdf->Cell(6,5,"$t27","$rmc",0,"C");$pdf->Cell(6,5,"$t28","$rmc",0,"C");
$pdf->Cell(6,5,"$t29","$rmc",0,"C");$pdf->Cell(6,5,"$t30","$rmc",0,"C");$pdf->Cell(6,5,"$t31","$rmc",1,"C");

//nazov subj. VS 2
$pdf->Cell(195,1,"                          ","$rmc",1,"L");
$text=substr($fir_fnaz,31,30);;
$textx="0123456789abcdefghijklmnoprstuv";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);

$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(6,5,"$t10","$rmc",0,"C");$pdf->Cell(6,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(6,5,"$t13","$rmc",0,"C");$pdf->Cell(6,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(6,5,"$t16","$rmc",0,"C");
$pdf->Cell(6,5,"$t17","$rmc",0,"C");$pdf->Cell(6,5,"$t18","$rmc",0,"C");$pdf->Cell(6,5,"$t19","$rmc",0,"C");$pdf->Cell(6,5,"$t20","$rmc",0,"C");
$pdf->Cell(6,5,"$t21","$rmc",0,"C");$pdf->Cell(6,5,"$t22","$rmc",0,"C");$pdf->Cell(6,5,"$t23","$rmc",0,"C");$pdf->Cell(6,5,"$t24","$rmc",0,"C");
$pdf->Cell(6,5,"$t25","$rmc",0,"C");$pdf->Cell(6,5,"$t26","$rmc",0,"C");$pdf->Cell(6,5,"$t27","$rmc",0,"C");$pdf->Cell(6,5,"$t28","$rmc",0,"C");
$pdf->Cell(6,5,"$t29","$rmc",0,"C");$pdf->Cell(6,5,"$t30","$rmc",0,"C");$pdf->Cell(6,5,"$t31","$rmc",1,"C");


//pravna forma subj. VS
$pdf->Cell(195,15,"                          ","$rmc",1,"L");
$text=$fir_uctt02;
$textx="0123456789abcdefghijklmnoprstuv";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);

$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(6,5,"$t10","$rmc",0,"C");$pdf->Cell(6,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(6,5,"$t13","$rmc",0,"C");$pdf->Cell(6,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(6,5,"$t16","$rmc",0,"C");
$pdf->Cell(6,5,"$t17","$rmc",0,"C");$pdf->Cell(6,5,"$t18","$rmc",0,"C");$pdf->Cell(6,5,"$t19","$rmc",0,"C");$pdf->Cell(6,5,"$t20","$rmc",0,"C");
$pdf->Cell(6,5,"$t21","$rmc",0,"C");$pdf->Cell(6,5,"$t22","$rmc",0,"C");$pdf->Cell(6,5,"$t23","$rmc",0,"C");$pdf->Cell(6,5,"$t24","$rmc",0,"C");
$pdf->Cell(6,5,"$t25","$rmc",0,"C");$pdf->Cell(6,5,"$t26","$rmc",0,"C");$pdf->Cell(6,5,"$t27","$rmc",0,"C");$pdf->Cell(6,5,"$t28","$rmc",0,"C");
$pdf->Cell(6,5,"$t29","$rmc",0,"C");$pdf->Cell(6,5,"$t30","$rmc",0,"C");$pdf->Cell(6,5,"$t31","$rmc",1,"C");


//ulica a cislo
$pdf->Cell(195,20,"                          ","$rmc",1,"L");
$text=$fir_fuli." ".$fir_fcdm;
$textx="0123456789abcdefghijklmnoprstuv";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);

$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(6,5,"$t10","$rmc",0,"C");$pdf->Cell(6,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(6,5,"$t13","$rmc",0,"C");$pdf->Cell(6,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(6,5,"$t16","$rmc",0,"C");
$pdf->Cell(6,5,"$t17","$rmc",0,"C");$pdf->Cell(6,5,"$t18","$rmc",0,"C");$pdf->Cell(6,5,"$t19","$rmc",0,"C");$pdf->Cell(6,5,"$t20","$rmc",0,"C");
$pdf->Cell(6,5,"$t21","$rmc",0,"C");$pdf->Cell(6,5,"$t22","$rmc",0,"C");$pdf->Cell(6,5,"$t23","$rmc",0,"C");$pdf->Cell(6,5,"$t24","$rmc",0,"C");
$pdf->Cell(6,5,"$t25","$rmc",0,"C");$pdf->Cell(6,5,"$t26","$rmc",0,"C");$pdf->Cell(6,5,"$t27","$rmc",0,"C");$pdf->Cell(6,5,"$t28","$rmc",0,"C");
$pdf->Cell(6,5,"$t29","$rmc",0,"C");$pdf->Cell(6,5,"$t30","$rmc",0,"C");$pdf->Cell(6,5,"$t31","$rmc",1,"C");


//psc
$pdf->Cell(195,14,"                          ","$rmc",1,"L");
$fir_fpsc=str_replace(" ","",$fir_fpsc);
$text=$fir_fpsc;
$textx="123456";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);

$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5," ","$rmc",0,"C");


//obec
$text=$fir_fmes;
$textx="123456789abcdefghijklmnov";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);

$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(6,5,"$t10","$rmc",0,"C");$pdf->Cell(6,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(6,5,"$t13","$rmc",0,"C");$pdf->Cell(6,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(6,5,"$t16","$rmc",0,"C");
$pdf->Cell(6,5,"$t17","$rmc",0,"C");$pdf->Cell(6,5,"$t18","$rmc",0,"C");$pdf->Cell(6,5,"$t19","$rmc",0,"C");$pdf->Cell(6,5,"$t20","$rmc",0,"C");
$pdf->Cell(6,5,"$t21","$rmc",0,"C");$pdf->Cell(6,5,"$t22","$rmc",0,"C");$pdf->Cell(6,5,"$t23","$rmc",0,"C");$pdf->Cell(6,5,"$t24","$rmc",0,"C");
$pdf->Cell(6,5,"$t25","$rmc",1,"C");


//smerove cislo telefonu
$pdf->Cell(195,14,"                          ","$rmc",1,"L");
$pole = explode("/", $fir_ftel);
$tel_pred=$pole[0];
$tel_za=$pole[1];
$text=$tel_pred;
$textx="01234567";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);

$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5," ","$rmc",0,"C");

//cislo telefonu
$text=$tel_za;
$textx="0123456789";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);

$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(6,5,"$t10","$rmc",0,"C");
$pdf->Cell(6,5," ","$rmc",0,"C");

//cislo faxu
$pole = explode("/", $fir_ffax);
$tel_pred=$pole[0];
$tel_za=$pole[1];
$text=$tel_za;
$textx="01234567";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);

$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(6,5,"$t10","$rmc",0,"C");$pdf->Cell(6,5,"$t11","$rmc",1,"C");


//email
$pdf->Cell(195,14,"                          ","$rmc",1,"L");
$text=$fir_fem1;
$textx="0123456789abcdefghijklmnoprstuv";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);

$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(6,5,"$t10","$rmc",0,"C");$pdf->Cell(6,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(6,5,"$t13","$rmc",0,"C");$pdf->Cell(6,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(6,5,"$t16","$rmc",0,"C");
$pdf->Cell(6,5,"$t17","$rmc",0,"C");$pdf->Cell(6,5,"$t18","$rmc",0,"C");$pdf->Cell(6,5,"$t19","$rmc",0,"C");$pdf->Cell(6,5,"$t20","$rmc",0,"C");
$pdf->Cell(6,5,"$t21","$rmc",0,"C");$pdf->Cell(6,5,"$t22","$rmc",0,"C");$pdf->Cell(6,5,"$t23","$rmc",0,"C");$pdf->Cell(6,5,"$t24","$rmc",0,"C");
$pdf->Cell(6,5,"$t25","$rmc",0,"C");$pdf->Cell(6,5,"$t26","$rmc",0,"C");$pdf->Cell(6,5,"$t27","$rmc",0,"C");$pdf->Cell(6,5,"$t28","$rmc",0,"C");
$pdf->Cell(6,5,"$t29","$rmc",0,"C");$pdf->Cell(6,5,"$t30","$rmc",0,"C");$pdf->Cell(6,5,"$t31","$rmc",1,"C");


//datum zostavenia
$pdf->Cell(195,21,"                          ","$rmc",1,"L");
$daz= SkDatum($hlavicka->daz);
if( $daz == '00.00.0000' ) $daz="";

$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(48,6,"$daz","$rmc",1,"C");



//strana 2
$pdf->AddPage();
$pdf->SetLeftMargin(8); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy_nujfin2013/fin504/fin504_str2.jpg') )
{
$pdf->Image('../dokumenty/vykazy_nujfin2013/fin504/fin504_str2.jpg',15,20,180,65); 
}

if (File_Exists ('../dokumenty/vykazy_nujfin2013/fin504/fin504_str2b.jpg') )
{
$pdf->Image('../dokumenty/vykazy_nujfin2013/fin504/fin504_str2b.jpg',15,270,180,20); 
}

$pdf->SetFont('arial','',6);
$text=$datum;
$textx="14.01.2010";
$t01=substr($text,0,1);
$pdf->SetY(26);

$pdf->Cell(148,3," ","$rmc",0,"R");$pdf->Cell(13,3,"$text","$rmc",1,"C");

$pdf->SetY(37);
                                          }
//koniec j=0

$pdf->SetFont('arial','',9);

$stlpa=$hlavicka->stlpa;
$stlpb=$hlavicka->stlpb;
$stlp1=$hlavicka->stlp1;
$stlp2=$hlavicka->stlp2;
$stlp3=$hlavicka->stlp3;
$stlp4=$hlavicka->stlp4;
if( $hlavicka->stlp4 == 0 ) $stlp4="";
$stlp5=$hlavicka->stlp5;
if( $hlavicka->stlp5 == 0 ) $stlp5="";
$stlp6=$hlavicka->stlp6;
if( $hlavicka->stlp6 == 0 ) $stlp6="";

if( $hlavicka->px01 == 0 AND $i <= 7 )
  {
$pdf->Cell(9,6," ","$rmc",0,"C");
$pdf->Cell(25,6,"$stlpa","$rmc",0,"L");$pdf->Cell(25,6,"$stlpb","$rmc",0,"C");$pdf->Cell(26,6,"$stlp1","$rmc",0,"C");$pdf->Cell(25,6,"$stlp2","$rmc",0,"C");
$pdf->Cell(25,6,"$stlp3","$rmc",0,"C");$pdf->Cell(26,6,"$stlp4 ","$rmc",0,"R");$pdf->Cell(25,6,"$stlp5 ","$rmc",1,"R");
  }

if( $hlavicka->px01 == 0 AND $i > 7 )
  {
$pdf->Cell(9,6," ","$rmc",0,"C");
$pdf->Cell(25,6,"$stlpa","1",0,"L");$pdf->Cell(25,6,"$stlpb","1",0,"C");$pdf->Cell(26,6,"$stlp1","1",0,"C");$pdf->Cell(25,6,"$stlp2","1",0,"C");
$pdf->Cell(25,6,"$stlp3","1",0,"C");$pdf->Cell(26,6,"$stlp4 ","1",0,"R");$pdf->Cell(25,6,"$stlp5 ","1",1,"R");
  }

if( $hlavicka->px01 == 1 )
  {
if( $pol <= 8 ) { $pdf->SetY(85); }
$pdf->Cell(195,1,"                          ","$rmc",1,"L");
$pdf->Cell(9,6," ","$rmc",0,"C");
$pdf->SetFont('arial','B',10);
$pdf->Cell(126,6,"⁄hrn","$rmc",0,"L");$pdf->Cell(26,6,"$stlp4","$rmc",0,"R");$pdf->Cell(25,6,"$stlp5","$rmc",1,"R");
  }


}
$i = $i + 1;
$j = $j + 1;

  }


//strana 3
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(8); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy_nujfin2013/fin504/fin504_str3.jpg') )
{
$pdf->Image('../dokumenty/vykazy_nujfin2013/fin504/fin504_str3.jpg',8,5,195,305); 
}

$pdf->Output("../tmp/vykazfin.$kli_uzid.pdf");




?>

<script type="text/javascript">
  var okno = window.open("../tmp/vykazfin.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA 

if( $strana == 9999 ) $strana=2;

//nacitaj udaje pre upravu
if ( $copern == 20 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin504 WHERE oc >= 0 ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

if( $strana == 1 OR $strana == 9999 )
{

$okres = 1*$fir_riadok->okres;
$obec = 1*$fir_riadok->obec;
$daz = $fir_riadok->daz;
$daz_sk=SkDatum($daz);



}

if( $strana == 2 )
{

$okres = 1*$fir_riadok->okres;
$obec = 1*$fir_riadok->obec;
$daz = $fir_riadok->daz;
$daz_sk=SkDatum($daz);



}



mysql_free_result($fir_vysledok);



    }
//koniec nacitania

$pol=0;
if( $okres == 0 OR $obec == 0 )
{
$sqlokr = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE okres > 0 AND obec > 0 ";
$okr_vysledok = mysql_query($sqlokr);
if( $okr_vysledok ) { $pol = 1*mysql_num_rows($okr_vysledok); }
if( $pol > 0) { $okr_riadok=mysql_fetch_object($okr_vysledok); $okres=1*$okr_riadok->okres; $obec=1*$okr_riadok->obec; }
}
$pol=0;
if( $okres == 0 OR $obec == 0 )
{
$sqlokr = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin204nuj WHERE okres > 0 AND obec > 0 ";
$okr_vysledok = mysql_query($sqlokr);
if( $okr_vysledok ) { $pol = 1*mysql_num_rows($okr_vysledok); }
if( $pol > 0) { $okr_riadok=mysql_fetch_object($okr_vysledok); $okres=1*$okr_riadok->okres; $obec=1*$okr_riadok->obec; }
}
$pol=0;
if( $okres == 0 OR $obec == 0 )
{
$sqlokr = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin504 WHERE okres > 0 AND obec > 0 ";
$okr_vysledok = mysql_query($sqlokr);
if( $okr_vysledok ) { $pol = 1*mysql_num_rows($okr_vysledok); }
if( $pol > 0) { $okr_riadok=mysql_fetch_object($okr_vysledok); $okres=1*$okr_riadok->okres; $obec=1*$okr_riadok->obec; }
}
$pol=0;
if( $okres == 0 OR $obec == 0 )
{
$sqlokr = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin604 WHERE okres > 0 AND obec > 0 ";
$okr_vysledok = mysql_query($sqlokr);
if( $okr_vysledok ) { $pol = 1*mysql_num_rows($okr_vysledok); }
if( $pol > 0) { $okr_riadok=mysql_fetch_object($okr_vysledok); $okres=1*$okr_riadok->okres; $obec=1*$okr_riadok->obec; }
}


$dness = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
if( $daz_sk == '00.00.0000' ) { $daz_sk=$dness; }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>V˝kaz FIN 5-04</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height-20;
var sirkawic = screen.width-10;

<?php
//uprava 
  if ( $copern == 20 )
  { 
?>



    function ObnovUI()
    {

<?php if ( $strana == 2  )                           { ?>


document.formv1.okres.value = '<?php echo $okres;?>';
document.formv1.obec.value = '<?php echo $obec;?>';
document.formv1.daz.value = '<?php echo $daz_sk;?>';

document.formv1.stlpa.value = '<?php echo $stlpa;?>';
document.formv1.stlpb.value = '<?php echo $stlpb;?>';
document.formv1.stlp1.value = '<?php echo $stlp1;?>';
document.formv1.stlp2.value = '<?php echo $stlp2;?>';
document.formv1.stlp3.value = '<?php echo $stlp3;?>';
document.formv1.stlp4.value = '<?php echo $stlp4;?>';
document.formv1.stlp5.value = '<?php echo $stlp5;?>';

document.formv1.rs00003.value = '<?php echo $rs00003;?>';
document.formv1.rs00004.value = '<?php echo $rs00004;?>';

        document.forms.formv1.stlpa.focus();
        document.forms.formv1.stlpa.select();

<?php                                                 } ?>



    }

<?php
//koniec uprava
  }
?>

<?php
  if ( $copern != 20 )
  { 
?>
    function ObnovUI()
    {

    }
<?php
  }
?>

//Kontrola datumu Sk
function kontrola_datum(vstup, Oznam, x1, errflag)
		{
		var text
		var index
		var tecka
		var den
		var mesic
		var rok
		var ch
                var err

		text=""
                err=0 
		
		den=""
		mesic=""
		rok=""
		tecka=0
		
		for (index = 0; index < vstup.value.length; index++) 
			{
      ch = vstup.value.charAt(index);
			if (ch != "0" && ch != "1" && ch != "2" && ch != "3" && ch != "4" && ch != "5" && ch != "6" && ch != "7" && ch != "8" && ch != "9" && ch != ".") 
				{text="Pole Datum zadavajte vo formate DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok).\r"; err=3 }
			if ((ch == "0" || ch == "1" || ch == "2" || ch == "3" || ch == "4" || ch == "5" || ch == "6" || ch == "7" || ch == "8" || ch == "9") && (text ==""))
				{
				if (tecka == 0)
					{den=den + ch}
				if (tecka == 1)
					{mesic=mesic + ch}
				if (tecka == 2)
					{rok=rok + ch}
				}
			if (ch == "." && text == "")
				{
				if (tecka == 1)
					{tecka=2}
				if (tecka == 0)
					{tecka=1}
				
				}	
			}
			
		if (tecka == 2 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>}
		if (tecka == 1 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>; err= 0}
		if (tecka == 1 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; err= 0}
		if (tecka == 0 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; rok=<?php echo $kli_vrok; ?>; err= 0}
		if ((den<1 || den >31) && (text == ""))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 31.\r"; err=1 }
		if ((mesic<1 || mesic>12) && (text == ""))
			{text=text + "Pocet mesiacov nemoze byt mensi ako 1 a vacsi ako 12.\r"; err=2 }
		if (rok<1930 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt mensi ako 1930.\r"; err=3 }
		if (rok>2029 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt v‰ËöÌ ako 2029.\r"; err=3 }
		if (tecka > 2)
			{text=text+ "Datum zadavajte vo formatu DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok)\r"; err=3 }

		if (mesic == 2)
			{
			if (rok != "")
				{
				if (rok % 4 == 0)
					{
					if (den>29)
						{text=text + "Vo februari roku " + rok + " je maximalne 29 dni.\r"; err=1 }
					}
				else
					{
					if (den>28)
						{text=text + "Vo februari roku " + rok + " je maximalne 28 dni.\r"; err=1 }
					}
				}
			else
				{
				if (den>29)
					{text=text + "Vo februari roku je maximalne 29 dni.\r"}
				}
			}

		if ((mesic == 4 || mesic == 6 || mesic == 9 || mesic == 11) && (den>30))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 30.\r"}
		



		if (text!="" && err == 1 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "??"  + "." + mesic+ "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 2 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic + "??" + "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 3 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic +  "." + rok + "??";
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (err == 0)
			{
                        Oznam.style.display="none";
                        x1.value = den + "." + mesic +  "." + rok ;
                        errflag.value = "0";
			return true;
			}

		}
//koniec kontrola datumu

// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (Math.floor(b)==b && b>=x && b<=y) return true; 
         else {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         return false;
              } 
             }
      }


// Kontrola des.cisla celeho v rozsahu x az y  
      function cele(x1,x,y,Oznam,des) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;
       var c;
       var d;
       var cele;
       var pocdes;
       cele=0;
       pocdes=0;
       c=b.toString();
       d=c.split('.');
       if ( isNaN(d[1]) ) { cele=1; }
       if ( cele == 0 ) { pocdes=d[1].length; }

         if (b == "") { err=0 }
         if (b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9.-]/g) != -1) { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }
         if (cele == 0 && pocdes > des ) { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola datumu
    function KontrolaDatum(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

   
</script>
</HEAD>
<BODY class="white" id="white" onload="ObnovUI();" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  V˝kaz FIN 5-04

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>


<?php if( $copern == 20 ) { ?>

<table class="h2" width="100%" >
<tr>
<td align="left">

<?php
if( $strana < 1 OR $strana > 2 ) $strana=2;
?>

<a href="#" onClick="window.open('vykaz_fin504.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999',
 '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='TlaË do PDF' ></a>
</td>

<td colspan="2">
</tr>
</table>


<?php                     } ?>


<?php
//upravy  udaje strana
if ( $copern == 20 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 2 desatinnÈ miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 4 desatinnÈ miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 1 desatinnÈ miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_oc;?> spr·vne uloûen·</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="../ucto/vykaz_fin504.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana;?>" >
<tr>
<td class="bmenu" width="10%"> Strana <?php echo $strana;?>
<td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
</tr>



<?php if ( $strana == 2  )                           { ?>


<?php

$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin504  ".
" WHERE oc >= 0 AND druh = 1 ORDER BY cpl ";


//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

//zaciatok vypisu
$i=0;
$j=0;
  while ($i <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$i) OR $j == 0 )
{
$rsluz=mysql_fetch_object($sluz);

if( $j == 0 )
     {
$fmenu="fmenu";
$pvstup="pvstup";
$da4_sk = SkDatum($rsluz->stlp4);

?>

<tr><td class="pvstuz" colspan="12">⁄daje o firme </td></tr>
<tr>
<td class="bmenu" colspan="10">KÛd okresu:
<input type="text" name="okres" id="okres" size="10" />
 KÛd obce:
<input type="text" name="obec" id="obec" size="10" />
 V˝kaz zostaven˝ dÚa:
<input type="text" name="daz" id="daz" size="10" />
</td>
</tr>


<tr><td class="pvstuz" colspan="12">FinanËn˝ v˝kaz o ˙veroch, dlhopisoch, zmenk·ch a finanËnom pren·jme subjektu verejnej</td></tr>

<tr>
<td class="bmenu" colspan="1">Symbol dlh.n·stroja BU..</td>
<td class="bmenu" colspan="1">KÛd meny EUR..</td>
<td class="bmenu" colspan="1">D·tum prijatia DDMMRRRR</td>
<td class="bmenu" colspan="1">D·tum splatnosti DDMMRRRR</td>
<td class="bmenu" colspan="1">Druh ˙roku F, V</td>
<td class="bmenu" colspan="1" align="right">NesplatenÈ celkom</td>
<td class="bmenu" colspan="1" align="right">NesplatenÈ zahr.veritelia</td>
<td class="bmenu" colspan="1" align="right">⁄roky celkom</td>
<td class="bmenu" colspan="1" align="right">⁄roky zahr.veritelia</td>
</tr>

<tr>
<td class="bmenu" colspan="1">a</td>
<td class="bmenu" colspan="1">b</td>
<td class="bmenu" colspan="1">1</td>
<td class="bmenu" colspan="1">2</td>
<td class="bmenu" colspan="1">3</td>
<td class="bmenu" colspan="1" align="right">4</td>
<td class="bmenu" colspan="1" align="right">5</td>
<td class="bmenu" colspan="1" align="right">6</td>
<td class="bmenu" colspan="1" align="right">7</td>
</tr>

<?php
     }
//koniec j=0



?>

<tr>
<td class="hvstup" colspan="1"><?php echo $rsluz->stlpa;?></td>
<td class="hvstup" colspan="1"><?php echo $rsluz->stlpb;?></td>
<td class="hvstup" colspan="1"><?php echo $rsluz->stlp1;?></td>
<td class="hvstup" colspan="1"><?php echo $rsluz->stlp2;?></td>

<td class="hvstup" colspan="1"><?php echo $rsluz->stlp3;?></td>
<td class="hvstup" colspan="1" align="right"><?php echo $rsluz->stlp4;?></td>
<td class="hvstup" colspan="1" align="right"><?php echo $rsluz->stlp5;?></td>

<td class="hvstup" colspan="1" align="right"><?php echo $rsluz->rs00003;?></td>
<td class="hvstup" colspan="1" align="right"><?php echo $rsluz->rs00004;?>
<a href='vykaz_fin504.php?copern=316&cislo_cpl=<?php echo $rsluz->cpl;?>&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana;?>'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazaù riadok" ></a>

</td>
</tr>

<?php
}

$i = $i + 1;
$j = $j + 1;
  }
              
?>


<tr>
<td class="bmenu" colspan="1"><input type="text" name="stlpa" id="stlpa" size="10" /></td>
<td class="bmenu" colspan="1"><input type="text" name="stlpb" id="stlpb" size="10" /></td>
<td class="bmenu" colspan="1"><input type="text" name="stlp1" id="stlp1" size="10" /></td>

<td class="bmenu" colspan="1"><input type="text" name="stlp2" id="stlp2" size="10" /></td>

<td class="bmenu" colspan="1" align="right"><input type="text" name="stlp3" id="stlp3" size="10" /></td>
<td class="bmenu" colspan="1" align="right"><input type="text" name="stlp4" id="stlp4" size="10" /></td>
<td class="bmenu" colspan="1" align="right"><input type="text" name="stlp5" id="stlp5" size="10" /></td>
<td class="bmenu" colspan="1" align="right"><input type="text" name="rs00003" id="rs00003" size="10" /></td>
<td class="bmenu" colspan="1" align="right"><input type="text" name="rs00004" id="rs00004" size="10" /></td>
</tr>



<?php                                                                  } //koniec 2.strana ?>


<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù"></td>
</tr>



</FORM>

</table>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>


<script type="text/javascript">

</script>

<?php
//mysql_free_result($vysledok);
    }
//koniec uprav  udaje 
?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
$cislista = include("uct_lista.php");
       } while (false);
?>
</BODY>
</HTML>
