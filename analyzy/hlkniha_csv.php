<HTML>
<?php

do
{
$sys = 'ANA';
$urov = 2900;
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$vsetko = 1*$_REQUEST['vsetko'];
$podlastr = 1*$_REQUEST['podlastr'];

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

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;
$strana=1;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";



$sql = "DROP TABLE F".$kli_vxcf."_prctopman".$kli_uzid;
$vysledok = mysql_query($sql);
$sql = "DROP TABLE F".$kli_vxcf."_prctopmany".$kli_uzid;
$vysledok = mysql_query($sql);

$sqlt = <<<uctcrv
(
   cpl           int not null auto_increment,
   prx           DECIMAL(10,0) DEFAULT 0,
   ume           DECIMAL(7,4) DEFAULT 0,
   dat           DATE NOT NULL,
   dok           DECIMAL(10,0) DEFAULT 0,
   uce           VARCHAR(11) NOT NULL,
   ucm           VARCHAR(11) NOT NULL,
   ucd           VARCHAR(11) NOT NULL,
   hod           DECIMAL(10,2) DEFAULT 0,
   popis         VARCHAR(60) NOT NULL,
   konx4         DECIMAL(10,0) DEFAULT 0,
   str           DECIMAL(10,0) DEFAULT 0,
   zak           DECIMAL(10,0) DEFAULT 0,
   PRIMARY KEY(cpl)
);
uctcrv;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prctopman'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prctopmany'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");



//len ak subor
if ( $copern == 10 )
    {

$psys=1;
 while ($psys <= 9 ) 
 {
//zober prijmove pokl
if( $psys == 1 ) { $uctovanie="uctpokuct"; $doklad="pokpri"; }
//zober vydavkove pokl
if( $psys == 2 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psys == 3 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psys == 4 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }
//zober odberatelske
if( $psys == 5 ) { $uctovanie="uctodb"; $doklad="fakodb"; }
//zober dodavatelske
if( $psys == 6 ) { $uctovanie="uctdod"; $doklad="fakdod"; }
//zober majetok
if( $psys == 7 ) { $uctovanie="uctmaj"; }
//zober majetok
if( $psys == 8 ) { $uctovanie="uctskl"; }
//zober mzdy
if( $psys == 9 ) { $uctovanie="uctmzd"; }

if( $psys <= 6 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prctopmany$kli_uzid"." SELECT".
" 0,$psys,ume,F$kli_vxcf"."_$doklad.dat,F$kli_vxcf"."_$doklad.dok,0,ucm,ucd,F$kli_vxcf"."_$uctovanie.hod,".
" CONCAT(txp, ' ', pop),0,F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak ".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ume >= 0 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_prctopmany$kli_uzid"." SELECT".
" 0,$psys,ume,dat,dok,0,ucm,ucd,hod,pop,0,str,zak ".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE ume >= 0 ";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }

//poc.stav
$umepoc="1.".$kli_vrok;
$datpoc=$kli_vrok."-01-01";

$sqtoz = "UPDATE F$kli_vxcf"."_prctopmany$kli_uzid SET REPLACE(pop, '\r', ' '); WHERE prx >= 0";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prctopmany$kli_uzid SET REPLACE(pop, '\n', ' '); WHERE prx >= 0";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prctopmany$kli_uzid SET REPLACE(pop, '\rn', ' '); WHERE prx >= 0";
$oznac = mysql_query("$sqtoz");

//vypocitaj ume z dat
$sqtoz = "UPDATE F$kli_vxcf"."_prctopmany$kli_uzid SET ume=MONTH(dat)+(YEAR(dat)/10000) WHERE prx >= 0";
$oznac = mysql_query("$sqtoz");


//koniec len ak subor
    }

?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Export Hlavná kniha</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;



    
</script>
</HEAD>
<BODY class="white" id="white" onload="ObnovUI();" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Export Hlavná kniha do CSV

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU 
if( $copern == 10 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="hlavnakniha";

if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");



$sqltt = "SELECT * FROM F$kli_vxcf"."_prctopmany$kli_uzid".
" WHERE hod != 0 ORDER BY ume,dat ";
//echo $sqltt;

if( $podlastr == 1 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_prctopmany$kli_uzid".
" WHERE hod != 0 ORDER BY str,ume,dat ";
}

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0;
$crrd=3;
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


if( $i == 0 )
{

  $text = "uc.mesiac;datum;c.dokladu;ucm;ucd;str;zak;hodnota;popis"."\r\n";
  fwrite($soubor, $text);
}


$hodnota=$hlavicka->hod;
$hodnotaex=str_replace(".",",",$hodnota);

$popis=$hlavicka->popis;
$popis=str_replace("\n","",$popis);
$popis=str_replace("\r","",$popis);

  $text = $hlavicka->ume.";".$hlavicka->dat.";".$hlavicka->dok.";";

  $text = $text.$hlavicka->ucm.";".$hlavicka->ucd.";".$hlavicka->str.";".$hlavicka->zak.";".$hodnotaex.";".$popis."\r\n";
  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);

?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>

<br />
<br />


<?php



}
///////////////////////////////////////////////////KONIEC SUBORU
?>




<?php
// celkovy koniec dokumentu

       } while (false);
?>
</BODY>
</HTML>
