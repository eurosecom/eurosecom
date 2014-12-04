<HTML>
<?php

// celkovy zaciatok dokkurztu
       do
       {
$sys = 'UCT';
$urov = 2000;
$clsm = 960;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

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

$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011texty MODIFY ozntxt VARCHAR(10) PRIMARY KEY not null ";
$vysledek = mysql_query("$sql");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$drupoh = 1*strip_tags($_REQUEST['drupoh']);
$h_ozntxt = $_REQUEST['h_ozntxt'];
$uloz="NO";
$zmaz="NO";
$uprav="NO";


$ulozenx="";

$bralsomjedentext=0;
//zober jeden text z inej firmy len z novej a nahradi existujuci text
if ( $copern == 4055 )
     {
$bralsomjedentext=1;
$h_ozntxt = strip_tags($_REQUEST['h_ozntxt']);
$firmax = strip_tags($_REQUEST['firmax']);
$oznacx = strip_tags($_REQUEST['oznacx']);

$kli_vrokxy=$kli_vrok;
$firmaneex=1;
$sqlfir = "SELECT * FROM fir WHERE xcf = $firmax ";
$fir_vysledok = mysql_query($sqlfir);
$kolkofir = 1*mysql_num_rows($fir_vysledok);
if( $kolkofir == 1 ) { $firmaneex=0; }
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $kli_vrokxy = 1*$fir_riadok->rok;  }

if( $firmaneex == 1 ) { echo "Zadana firma cislo ".$firmax." neexistuje v ciselniku firiem."; exit; }

$databaza="";
$kli_vrokx=$kli_vrok;
$kli_vrok=$kli_vrokxy;
$dtb2 = include("../cis/oddel_dtbz2.php");
$kli_vrok=$kli_vrokx;

$ulozttt = "INSERT INTO F$kli_vxcf"."_poznamky_po2011texty ( ozntxt, hdntxt ) VALUES ('$h_ozntxt', '' ) "; 
$ulozene = mysql_query("$ulozttt"); 

$nerob=1;

if( $nerob == 0 )
  {
$sqlfir = "SELECT * FROM ".$databaza."F$firmax"."_poznamky_po2011texty WHERE ozntxt='$oznacx' ";
//echo $sqlfir; 
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); 
$h_hdntxtplus = str_replace("\r\n","###rn###",$fir_riadok->hdntxt); $h_hdntxtplusx=str_replace("\r","###r###",$h_hdntxtplus); }

$ulozttt = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET hdntxt='".$h_hdntxtplusx."' WHERE ozntxt='$h_ozntxt' "; 
$ulozene = mysql_query("$ulozttt"); 

echo $ulozttt;

$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET hdntxt=REPLACE(hdntxt,'###rn###','\r\n') WHERE ozntxt='$h_ozntxt' ";
$ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET hdntxt=REPLACE(hdntxt,'###r###','\r') WHERE ozntxt='$h_ozntxt' ";
$ulozene = mysql_query("$sqult"); 
  }

$ulozttt = "DROP TABLE F$kli_vxcf"."_poznamky_po2011textyxxx "; 
$ulozene = mysql_query("$ulozttt"); 
$ulozttt = "CREATE TABLE F$kli_vxcf"."_poznamky_po2011textyxxx SELECT * FROM ".$databaza."F$firmax"."_poznamky_po2011texty WHERE  ozntxt='$oznacx' "; 
$ulozene = mysql_query("$ulozttt"); 


$ulozttt = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamky_po2011textyxxx SET ".
" F$kli_vxcf"."_poznamky_po2011texty.hdntxt=F$kli_vxcf"."_poznamky_po2011textyxxx.hdntxt ".
" WHERE F$kli_vxcf"."_poznamky_po2011texty.ozntxt='$h_ozntxt' "; 
$ulozene = mysql_query("$ulozttt"); 

$ulozttt = "DROP TABLE F$kli_vxcf"."_poznamky_po2011textyxxx "; 
$ulozene = mysql_query("$ulozttt"); 

$copern=1;
$ulozenx="Text uloûen˝";
    }
//koniec zober jeden text z inej firmy

//ulozenie
if ( $copern == 116 )
     {

$h_hdntxt = strip_tags($_REQUEST['h_hdntxt']);

$ulozttt = "INSERT INTO F$kli_vxcf"."_poznamky_po2011texty ( ozntxt, hdntxt ) VALUES ('$h_ozntxt', '$h_hdntxt' ) "; 
//echo $ulozttt;
$ulozene = mysql_query("$ulozttt"); 

$ulozttt = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET hdntxt='$h_hdntxt' WHERE ozntxt='$h_ozntxt' "; 
$ulozene = mysql_query("$ulozttt"); 
//echo $ulozttt;
$copern=1;
$ulozenx="Text uloûen˝";
    }
//koniec ulozenia


//import z ../import/FIR$kli_vxcf/POZNAMKYPO2012.CSV
    if ( $copern == 55 )
    {
$odkial="../import/FIR".$kli_vxcf."/POZNAMKYPO".$kli_vrok.".CSV";
$firxyz = 1*strip_tags($_REQUEST['firx']);
if( $firxyz == 9999 ) { $odkial="../import/POZNAMKYPO".$kli_vrok.".CSV"; }

?>
<script type="text/javascript">
if( !confirm ("Chcete importovaù poloûky \r zo s˙boru <?php echo $odkial; ?> ? \r POZOR!!! Pred importom bud˙ terajöie pozn·mky v tejto firme vymazanÈ .") )
         { window.close()  }
else
         { location.href='poznamky_potexty.php?copern=56&page=1&firx=<?php echo $firxyz; ?>'  }
</script>
<?php
    }
    if ( $copern == 56 )
    {
$copern=20;

$odkial="../import/FIR".$kli_vxcf."/POZNAMKYPO".$kli_vrok.".CSV";
$firxyz = 1*strip_tags($_REQUEST['firx']);
if( $firxyz == 9999 ) { $odkial="../import/POZNAMKYPO".$kli_vrok.".CSV"; }

if( file_exists("$odkial")) 
{
echo "S˙bor $odkial existuje<br />";
$sqult = "TRUNCATE TABLE F$kli_vxcf"."_poznamky_po2011texty ";
$ulozene = mysql_query("$sqult"); 
}

$subor = fopen("$odkial", "r");
while (! feof($subor))
  {
  $riadok = fgets($subor, 1120);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);


  $h_ozntxt = $pole[0];
  $h_hdntxt = $pole[1];


$sqult = "INSERT INTO F$kli_vxcf"."_poznamky_po2011texty ( ozntxt, hdntxt ) VALUES ('$h_ozntxt', '$h_hdntxt' ) ";
//echo $sqult;

$ulozene = mysql_query("$sqult"); 


  }

echo "Tabulka F$kli_vxcf"."_poznamky_po2011texty!"." naimportovan· <br />";
echo "Zatvorte toto okno aj okno ˙prav Pozn·mok k ˙Ëtovnej z·vierke. Po op‰tovnom otvorenÌ ˙prav Pozn·mok k ˙Ëtovnej z·vierke bud˙ texty naËÌtanÈ. <br />";

fclose ($subor);

$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET hdntxt=REPLACE(hdntxt,'###rn###','\r\n') ";
$ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET hdntxt=REPLACE(hdntxt,'###r###','\r') ";
$ulozene = mysql_query("$sqult"); 

exit;
    }
//koniec nacitania poznamok


//exportuj poznamky
if ( $copern == 655 )
    {
$nazsub="POZNAMKYPO".$kli_vrok;


if (File_Exists ("../tmp/$nazsub.CSV")) { $soubor = unlink("../tmp/$nazsub.CSV"); }

$soubor = fopen("../tmp/$nazsub.CSV", "a+");

//polozky
$sqltt = "SELECT * FROM F$kli_vxcf"."_poznamky_po2011texty ORDER BY ozntxt";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$poznbr=str_replace("\r\n","###rn###",$hlavicka->hdntxt);
$poznbr=str_replace("\r","###r###",$poznbr);

  $text = $hlavicka->ozntxt.";".$poznbr.";koniec";
  $text = $text."\r\n";


  fwrite($soubor, $text);


}
$i = $i + 1;
$j = $j + 1;
  }

$copern=1;
fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.CSV">../tmp/<?php echo $nazsub; ?>.CSV</a>


<?php
exit;
    }
//koniec exportuj poznamky



//nacitanie nacitania poznamok z firmy
    if ( $copern == 355 )
    {

$firxyz = 1*strip_tags($_REQUEST['firx']);
$fix=0;
if( $fir_allx11 > 0 ) $fix=1*$fir_allx11;
if( $firxyz > 0 ) { $fix=1*$firxyz; }

if( $fix == 0 AND $firxyz == 0 ) { echo "V ˙dajoch o firme musÌte zadaù ËÌslo firmy minulÈho roka."; exit; }

?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù pozn·mky z firmy Ë. <?php echo $fix;?> ? \r POZOR !!! CelÈ pozn·mky bud˙ najprv vymazanÈ .") )
         { window.close()  }
else
         { location.href='poznamky_potexty.php?&copern=356&drupoh=1&page=1&h_ozntxt=<?php echo $h_ozntxt; ?>&firx=<?php echo $firxyz; ?>'  }
</script>
<?php
    }

    if ( $copern == 356 )
    {
$copern=1;
$firxyz = 1*strip_tags($_REQUEST['firx']);
$fix=0;
if( $fir_allx11 > 0 ) { $fix=1*$fir_allx11; }
if( $firxyz > 0 ) { $fix=1*$firxyz; }

if( $fix == 0 AND $firxyz == 0 ) { echo "V ˙dajoch o firme musÌte zadaù ËÌslo firmy minulÈho roka."; exit; }

$kli_vrokxy=$kli_vrok;
$firmaneex=1;
$sqlfir = "SELECT * FROM fir WHERE xcf = $fix ";
$fir_vysledok = mysql_query($sqlfir);
$kolkofir = 1*mysql_num_rows($fir_vysledok);
if( $kolkofir == 1 ) { $firmaneex=0; }
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $kli_vrokxy = 1*$fir_riadok->rok;  }

if( $firmaneex == 1 ) { echo "Zadan· firma ËÌslo ".$fix." neexistuje v ËÌselnÌku firiem."; exit; }
//echo $kli_vrokxy;

$databaza="";
$kli_vrokx=$kli_vrok;
$kli_vrok=$kli_vrokxy;
$dtb2 = include("../cis/oddel_dtbz2.php");
$kli_vrok=$kli_vrokx;

//_poznamky_po2011texty   psys  ozntxt  hdntxt  prmx1  prmx2  prmx3  prmx4  oldp  oldc1  oldc2  konx  konx8  ico 

//z akych poznamok ideme
$idemezostarych=1;
$poslhh = "SELECT * FROM F$kli_vxcf"."_poznamky_po2011texty WHERE ico >= 0 ";
$posl = mysql_query("$poslhh"); 
$kolkordk = 1*mysql_num_rows($posl);
if( $kolkordk > 5 ) { $idemezostarych=0; }


//len ked prenos zo starych
if( $idemezostarych == 1 )
     {
//echo "ideme zo starych";

$sqult = "DROP TABLE F$kli_vxcf"."_poznamkypoprc ";
$ulozene = mysql_query("$sqult");
$sqult = "CREATE TABLE F$kli_vxcf"."_poznamkypoprc SELECT * FROM ".$databaza."F$fix"."_uctpoznamkypo ";
$ulozene = mysql_query("$sqult"); 
$ulozttt = "UPDATE F$kli_vxcf"."_poznamkypoprc SET pozn='' WHERE isnull(pozn) "; 
$ulozene = mysql_query("$ulozttt");


//zosuladenie oznacenia
$poslhh = "SELECT * FROM F$kli_vxcf"."_poznamkypoprc WHERE LEFT(r00,1) = 'D' ";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp > 0 )
  {
//echo "Zos˙ladenie oznaËenia 2010/2011";
$sqult = "UPDATE F$kli_vxcf"."_poznamkypoprc SET z17=r00 ";
$ulozene = mysql_query("$sqult"); 

$sqult = "UPDATE F$kli_vxcf"."_poznamkypoprc SET z17=REPLACE(r00,'D','E') WHERE LEFT(r00,1) = 'D' ";
$ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE F$kli_vxcf"."_poznamkypoprc SET z17=REPLACE(r00,'E','F') WHERE LEFT(r00,1) = 'E' ";
$ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE F$kli_vxcf"."_poznamkypoprc SET z17=REPLACE(r00,'F','G') WHERE LEFT(r00,1) = 'F' ";
$ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE F$kli_vxcf"."_poznamkypoprc SET z17=REPLACE(r00,'G','H') WHERE LEFT(r00,1) = 'G' ";
$ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE F$kli_vxcf"."_poznamkypoprc SET z17=REPLACE(r00,'H','I') WHERE LEFT(r00,1) = 'H' ";
$ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE F$kli_vxcf"."_poznamkypoprc SET z17=REPLACE(r00,'I','J') WHERE LEFT(r00,1) = 'I' ";
$ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE F$kli_vxcf"."_poznamkypoprc SET z17=REPLACE(r00,'J','K') WHERE LEFT(r00,1) = 'J' ";
$ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE F$kli_vxcf"."_poznamkypoprc SET z17=REPLACE(r00,'K','L') WHERE LEFT(r00,1) = 'K' ";
$ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE F$kli_vxcf"."_poznamkypoprc SET z17=REPLACE(r00,'L','M') WHERE LEFT(r00,1) = 'L' ";
$ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE F$kli_vxcf"."_poznamkypoprc SET z17=REPLACE(r00,'M','N') WHERE LEFT(r00,1) = 'M' ";
$ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE F$kli_vxcf"."_poznamkypoprc SET z17=REPLACE(r00,'N','O') WHERE LEFT(r00,1) = 'N' ";
$ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE F$kli_vxcf"."_poznamkypoprc SET z17=REPLACE(r00,'O','P') WHERE LEFT(r00,1) = 'O' ";
$ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE F$kli_vxcf"."_poznamkypoprc SET r00=z17 ";
$ulozene = mysql_query("$sqult");
  }



$dsqlt = "TRUNCATE TABLE F$kli_vxcf"."_poznamky_po2011texty ";
$dsql = mysql_query("$dsqlt");

//_poznamky_po2011texty  psys  ozntxt  hdntxt  prmx1  prmx2  prmx3  prmx4  oldp  oldc1  oldc2 konx  konx8  ico  


//_poznamkypoprc      oc  vyk  r00  r00z1  r00z2  r00a  r00a1  r00a2  r00b  r01  r02  r03  konx1  r04  r04a  r04a1  r04a2  r04b  
//r04c  r04c1  r04c2  r04d  r04e  r04f  r04x  konx2  r05  r06  r07  r08  r09  r10  konx3  r11  r11a  r11b  r12  r13  r14  r14a  r14b  
//r15  r15a  r15b  r16  r17  r18  r18n  r18p  konx4  pozn  da2  da21  da22  da23  da24  da25  d11  d12  d13  d14  d15  d16  d17  z11  
//z12  z13  z14  z15  z16  z17  po6  px8  
//text je v pozn oznacenie v pismenio r00 a cislo r01 a r02 musim urobyt prevodnu tabulku 

$sql = "ALTER TABLE F$kli_vxcf"."_poznamkypoprc MODIFY r01 VARCHAR(10) ";
$vysledek = mysql_query("$sql");
$ulozttt = "UPDATE F$kli_vxcf"."_poznamkypoprc SET r00='' WHERE isnull(r00) "; 
$ulozene = mysql_query("$ulozttt");
$ulozttt = "UPDATE F$kli_vxcf"."_poznamkypoprc SET r01='' WHERE isnull(r01) "; 
$ulozene = mysql_query("$ulozttt");
$ulozttt = "UPDATE F$kli_vxcf"."_poznamkypoprc SET r02='' WHERE isnull(r02) "; 
$ulozene = mysql_query("$ulozttt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_poznamky_po2011texty".
" SELECT 0,CONCAT(r00, r01, r02, oc),pozn,0,0,0,0,r00,r01,r02,0,0,0 ".
" FROM F$kli_vxcf"."_poznamkypoprc WHERE r00 = 'A' OR r00 = 'B' OR r00 = 'C' OR r00 = 'D' OR r00 = 'E' OR r00 = 'F' OR r00 = 'G' OR r00 = 'H' OR r00 = 'I'  ".
" OR r00 = 'J' OR r00 = 'K' OR r00 = 'L' OR r00 = 'M' OR r00 = 'N' OR r00 = 'O' OR r00 = 'P' OR r00 = 'R' OR r00 = 'S' OR r00 = 'T' ";

$dsql = mysql_query("$dsqlt");

$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=99 ";
$ulozene = mysql_query("$sqult");

//Acka
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='A_text1' WHERE oldp = 'A' AND oldc1 = 0 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='A_text1' AND r00 = 'A' AND r01 = '1' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='A_text1' AND r00 = 'A' AND r01 = '3' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='A_text1' AND r00 = 'A' AND r01 = '4' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='A_text1' AND r00 = 'A' AND r01 = '5' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='A_text2' WHERE oldp = 'A' AND oldc1 = 2 ";
$ulozene = mysql_query("$sqult");

//Bcka
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='B_text1' WHERE oldp = 'B' AND oldc1 = 1 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='B_text1' AND r00 = 'B' AND r01 = '2' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='B_text1' AND r00 = 'B' AND r01 = '3' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='B_text2' WHERE oldp = 'B' AND oldc1 = 4 ";
$ulozene = mysql_query("$sqult");

//Ccka
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='C_text1' WHERE oldp = 'C' AND oldc1 = 0 ";
$ulozene = mysql_query("$sqult");

//Ecka
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='E_text1' WHERE oldp = 'E' AND oldc1 = 1 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='E_text2' WHERE oldp = 'E' AND oldc1 = 2 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='E_text2' AND r00 = 'E' AND r01 = '3' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='E_text2' AND r00 = 'E' AND r01 = '4' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='E_text2' AND r00 = 'E' AND r01 = '5' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='E_text2' AND r00 = 'E' AND r01 = '6' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='E_text3' WHERE oldp = 'E' AND oldc1 = 7 ";
$ulozene = mysql_query("$sqult");

//Fka
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='F_text1' WHERE oldp = 'F' AND oldc1 = 0 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='F_text1' AND r00 = 'F' AND r01 = '18' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='F_text2' WHERE oldp = 'F' AND oldc1 = 1 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='F_text5' WHERE oldp = 'F' AND oldc1 = 2 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='F_text8' WHERE oldp = 'F' AND oldc1 = 3 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='F_text7' WHERE oldp = 'F' AND oldc1 = 4 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='F_text7' AND r00 = 'F' AND r01 = '15' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='F_text7' AND r00 = 'F' AND r01 = '16' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='F_text9' WHERE oldp = 'F' AND oldc1 = 5 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='F_text9' AND r00 = 'F' AND r01 = '6' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='F_text14' WHERE oldp = 'F' AND oldc1 = 7 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='F_text17' WHERE oldp = 'F' AND oldc1 = 9 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='F_text21' WHERE oldp = 'F' AND oldc1 = 10 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='F_text25' WHERE oldp = 'F' AND oldc1 = 12 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='F_text30' WHERE oldp = 'F' AND oldc1 = 13 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='F_text3' WHERE oldp = 'F' AND oldc1 = 14 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='F_text31' WHERE oldp = 'F' AND oldc1 = 19 ";
$ulozene = mysql_query("$sqult");

//Gcka
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='G_text8' WHERE oldp = 'F' AND oldc1 = 11 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='G_text1' WHERE oldp = 'G' AND oldc1 = 0 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='G_text4' WHERE oldp = 'G' AND oldc1 = 2 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='G_text7' WHERE oldp = 'G' AND oldc1 = 3 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='G_text8' AND r00 = 'G' AND r01 = '4' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='G_text9' WHERE oldp = 'G' AND oldc1 = 5 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='G_text10' WHERE oldp = 'G' AND oldc1 = 6 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='G_text11' WHERE oldp = 'G' AND oldc1 = 7 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='G_text14' WHERE oldp = 'G' AND oldc1 = 8 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='G_text18' WHERE oldp = 'G' AND oldc1 = 10 ";
$ulozene = mysql_query("$sqult");

//Hcka
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='H_text1' WHERE oldp = 'H' AND oldc1 = 0 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='H_text1' AND r00 = 'H' AND r01 = '1' ";
$ulozene = mysql_query("$sqult");

//Icka
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='I_text1' WHERE oldp = 'I' AND oldc1 = 0 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='I_text1' AND r00 = 'I' AND r01 = '1' ";
$ulozene = mysql_query("$sqult");

//Jcka
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='J_text1' WHERE oldp = 'J' AND oldc1 = 0 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='J_text1' AND r00 = 'J' AND r01 = '1' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='J_text1' AND r00 = 'J' AND r01 = '2' ";
$ulozene = mysql_query("$sqult");

//Kcka
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='K_text1' WHERE oldp = 'K' AND oldc1 = 0 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='K_text1' AND r00 = 'K' AND r01 = '1' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='K_text1' AND r00 = 'K' AND r01 = '2' ";
$ulozene = mysql_query("$sqult");

//Lcka
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='L_text1' WHERE oldp = 'L' AND oldc1 = 0 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='L_text1' AND r00 = 'L' AND r01 = '1' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='L_text1' AND r00 = 'L' AND r01 = '2' ";
$ulozene = mysql_query("$sqult");

//Mcka
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='M_text1' WHERE oldp = 'M' AND oldc1 = 0 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='M_text1' AND r00 = 'M' AND r01 = '1' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='M_text1' AND r00 = 'M' AND r01 = '2' ";
$ulozene = mysql_query("$sqult");

//Ncka
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='N_text1' WHERE oldp = 'N' AND oldc1 = 0 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='N_text1' AND r00 = 'N' AND r01 = '1' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='N_text1' AND r00 = 'N' AND r01 = '2' ";
$ulozene = mysql_query("$sqult");

//Ocka
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='O_text1' WHERE oldp = 'O' AND oldc1 = 0 ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='O_text1' AND r00 = 'O' AND r01 = '1' ";
$ulozene = mysql_query("$sqult");
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty,F$kli_vxcf"."_poznamkypoprc ".
" SET psys=0, hdntxt=CONCAT('\r', hdntxt, pozn )  WHERE ozntxt='O_text1' AND r00 = 'O' AND r01 = '2' ";
$ulozene = mysql_query("$sqult");

//Pcko
$sqult = "UPDATE F$kli_vxcf"."_poznamky_po2011texty SET psys=0, ozntxt='P_text1' WHERE oldp = 'G' AND oldc1 = 1 ";
$ulozene = mysql_query("$sqult");

$sqult = "DELETE FROM F$kli_vxcf"."_poznamky_po2011texty WHERE psys = 99 ";
$ulozene = mysql_query("$sqult");

$sqult = "DROP TABLE F$kli_vxcf"."_poznamkypoprc ";
$ulozene = mysql_query("$sqult");

//koniec len ked prenos zo starych
     }

//len ked ideme z novych
if( $idemezostarych == 0 )
     {
//echo "ideme z novych";

$sqult = "TRUNCATE TABLE F$kli_vxcf"."_poznamky_po2011texty ";
$ulozene = mysql_query("$sqult");

$dsqlt = "INSERT INTO F$kli_vxcf"."_poznamky_po2011texty SELECT * FROM ".$databaza."F$fix"."_poznamky_po2011texty WHERE ico >= 0 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;

//koniec len ked ideme z novych
     }

$copern=1;
    }
//koniec nacitania poznamok z firmy


$sqlfir = "SELECT * FROM F$kli_vxcf"."_poznamky_po2011texty ".
" WHERE ozntxt = '$h_ozntxt' ";
//echo $sqlfir;

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$h_hdntxt = $fir_riadok->hdntxt;


mysql_free_result($fir_vysledok);



?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link rel="stylesheet" href="../css/styl_poznamky_po2011.css" type="text/css">
  <style type="text/css">
table.pnseda { border: outset 2pt ; background-color:gray;
              background:gray; top:10px; 
              font-family:bold; font-size:10pt; font-weight:bold; } 
td.pnseda  { background-color:white; color:black; font-weight:bold;
            height:12px; font-size:12px; } 

  </style>
<title>EuroSecom - ⁄ËtovnÈ pozn·mky - doplÚuj˙ci text</title>
 <SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">

    function ImportPoz()
    {
var firma = 1*document.forms.formpren.xfir.value;


window.open('poznamky_potexty.php?&copern=55&page=1&firx=' + firma + '&h_ozntxt=<?php echo $h_ozntxt; ?>',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
    }

    function nacitajMin()
    {
window.open('poznamky_potexty.php?copern=355&drupoh=1&page=1&h_ozntxt=<?php echo $h_ozntxt; ?>',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
    }

    function nacitajFir()
    {
var firma = 1*document.forms.formpren.xfir.value;

if( firma > 0 && firma != <?php echo $kli_vxcf; ?> )
       {
window.open('poznamky_potexty.php?copern=355&drupoh=1&page=1&firx='+ firma + '&h_ozntxt=<?php echo $h_ozntxt; ?>',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
       }
    }

    function nacitajFirJeden()
    {
myZakelement.style.display='';
volajZak(0,1);

    }

    function vykonajTextJeden(oznacenie,firma,starytyp)
    {

var oznacx= oznacenie;
var firmax= firma;
var strtpx= starytyp;

myZakelement.style.display='none';
window.open('poznamky_potexty.php?copern=4055&drupoh=1&page=1&firmax='+ firmax + '&oznacx='+ oznacx + '&h_ozntxt=<?php echo $h_ozntxt; ?>',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
    }

<?php
//nova
  if ( $copern == 1 AND $bralsomjedentext == 0 )
  { 
?>
    function ObnovUI()
    {


    }

<?php
//koniec nova
  }
?>
<?php
//nova
  if ( $copern == 1 AND $bralsomjedentext == 1 )
  { 
?>
    function ObnovUI()
    {
    document.forms.formpren.xfir.value = <?php echo $firmax; ?>

    }

<?php
//koniec nova
  }
?>

  </script> 
<script type="text/javascript" src="poznamky_texty_xml.js"></script>
</HEAD>
<BODY onload="ObnovUI();" style="overflow:auto;"  >


<div id="myZakelement" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 200; left: 40; ">texty</div>

<table class="nadpis" width="100%" style="margin-bottom:20px;" >
 <tr>
  <td width="40%" class="h2" >DoplÚuj˙ci text k <?php echo $h_ozntxt;?></td>
<FORM name="formpren" method="post" action="#">
  <td width="60%" align="right" style="font-size:14px;" >
  <a href="#" onClick="nacitajMin();" title='NaËÌtaù vöetky texty pozn·mok z minulÈho roka'>Minul˝ rok
  <img src='../obr/zoznam.png' width=20 height=15 border=0 ></a>
  &nbsp;|&nbsp;
  <a href="#" onClick="nacitajFir();" title='NaËÌtaù vöetky texty pozn·mok z firmy ËÌslo' >Firma
  <img src='../obr/zoznam.png' width=20 height=15 border=0 ></a>
  &nbsp;|&nbsp;
  <span style="font-weight:normal" >ËÌslo</span><INPUT type="text" name="xfir" id="xfir" size="5">
  &nbsp;|&nbsp;
  <a href="#" onClick="nacitajFirJeden();" title='NaËÌtaù jeden text pozn·mok z firmy ËÌslo' >1x
  <img src='../obr/naradie.png' width=20 height=15 border=0 ></a>

<?php if ( $kli_uzall > 90000 ) { ?>
  &nbsp;&nbsp;&nbsp;|&nbsp;
<a href='poznamky_potexty.php?&copern=655&page=1'>
<img src='../obr/export.png' width=20 height=15 border=0 title="Exportuj pozn·mky do CSV"></a>
<?php                           } ?>
<?php if ( $kli_uzall > 90000 ) { ?>
  &nbsp;|&nbsp;
<a href='#' onclick='ImportPoz();'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Importuj pozn·mky z CSV"></a>
<?php                           } ?>
  &nbsp;|&nbsp;
<a href='poznamky_potexty.php?&copern=55&page=1&firx=9999' >
<img src='../obr/orig.png' width=20 height=15 border=0 title="Importuj ötandartnÈ pozn·mky"></a>
  </td>
</FORM>
 </tr>
</table>


<?php
if ( $copern == 1  )
     {
?>
<FORM name="formv1" method="post" action="poznamky_potexty.php?page=1&copern=116&h_ozntxt=<?php echo $h_ozntxt;?>">
<table style="" width="900px" align="center" >
<thead style="" >
 <tr>
  <td width="15%" ></td>
  <td width="50%" ><span id="infosave" name="infosave" style="letter-spacing:1px; background-color:lightblue; padding:2px 10px; font-weight:bold;"><?php echo $ulozenx; ?></span></td>
  <td width="20%" align="right" ><INPUT style="height:26px; width:80px;" type="submit" id="uloz" name="uloz" value="Uloûiù"></td>
  <td width="15%" ></td>
 </tr>
</thead>
<tbody>
 <tr>
  <td valign="bottom" ><img src="../obr/left_quote.png" style="" title="bottom quote" height="50" width="62"></td>
  <td colspan="2" align="center" ><div>
  <textarea style="margin:5px 0; overflow:auto; border:4px solid lightblue;" onClick="infosave.style.display='none';" name="h_hdntxt" id="h_hdntxt" rows="34" cols="90" style=""><?php echo $h_hdntxt; ?></textarea>
  </div>
  </td>
  <td valign="top" >&nbsp;<img src="../obr/right_quote.png" style="" title="top quote" height="50" width="62"></td>
 </tr>
</tbody>
</table>
</FORM>

<?php
// toto je koniec casti na zobrazenie tabulky a prechody medzi stranami 
     }

// celkovy koniec dokkurztu

       } while (false);
?>
</BODY>
</HTML>
