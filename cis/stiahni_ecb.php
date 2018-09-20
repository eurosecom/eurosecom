<?php

// celkovy zaciatok dokumentu
//php_flag allow_url_fopen on 
//php_flag allow_url_include off
//do souboru .htaccess
//cURL


$sys = 'ALL';
$urov = 2000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;


// cislo operacie
$copern = 1*$_REQUEST['copern'];
$dni90 = 1*$_REQUEST['dni90'];

    if ( $copern == 1010 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù kurzov˝ lÌstok ECB ?") )
         { window.close();  }
else
         { location.href='stiahni_ecb.php?copern=1020&dni90=<?php echo $dni90; ?>'  }
</script>
<?php
exit;
    }

    if ( $copern == 1020 )
    {


  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


$citfir = include("../cis/citaj_fir.php");

$nazovsuboru="../tmp/pracak".$kli_uzid.".xml"; 

if (File_Exists ("$nazovsuboru")) { $soubor = unlink("$nazovsuboru"); }

$souborz = fopen("$nazovsuboru", "a+");

if( $dni90 == 0 )
                {

$practxt="../tmp/prac".$kli_uzid.".txt";
if (File_Exists ("$practxt")) { $soubor = unlink("$practxt"); }

$ch = curl_init ("https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
$fp = fopen ("$practxt", "w");

curl_setopt ($ch, CURLOPT_FILE, $fp);
curl_setopt ($ch, CURLOPT_HEADER, 0);

curl_exec ($ch);
curl_close ($ch);
fclose ($fp);
//exit;

$subor = @fopen("$practxt", "r");
if (!$subor) { $subor = @fopen("$practxt", "r"); }
    if (!$subor)
    {
        echo "Nenaöiel som denn˝ kurzov˝ lÌstok ! "; exit; 
    }
    else
    {

$nemenxml=1;
while (! feof($subor) AND $nemenxml = 0 )
{
  $riadok = fgets($subor, 500);

  $riadok=str_replace("<Cube time","<datum>\r\n<time den",$riadok);
  $riadok=str_replace("<Cube currency","<kurz kurz",$riadok);
  $riadok=str_replace("gesmes:Envelope","listok",$riadok);


  $riadok=str_replace("<Cube>
","",$riadok);
  $riadok=str_replace("</Cube>
","",$riadok);

$riadok=trim($riadok);

$r6=substr($riadok,0,6);
if( $r6 == '<datum' ) { $riadok=$riadok."</time>"; }
if( $r6 == '</list' ) { $riadok="</datum>\r\n".$riadok; }

  $text = $riadok."\r\n";
  fwrite($souborz, $text);
	

}

while (! feof($subor) AND $nemenxml = 1 )
{

  $riadokx = fgets($subor, 5000);


  $riadokx=str_replace("<Cube time=","\r\n<Cube time=",$riadokx);
  $riadokx=str_replace("<Cube currency=","\r\n<Cube currency=",$riadokx);

  $text = $riadokx;
  fwrite($souborz, $text);	

}

fclose($souborz);
     }
                }
//koniec jeden den

if( $dni90 == 1 )
                {
$practxt="../tmp/prac".$kli_uzid.".txt";
if (File_Exists ("$practxt")) { $soubor = unlink("$practxt"); }

$ch = curl_init ("https://www.ecb.europa.eu/stats/eurofxref/eurofxref-hist-90d.xml");
$fp = fopen ("$practxt", "w");

curl_setopt ($ch, CURLOPT_FILE, $fp);
curl_setopt ($ch, CURLOPT_HEADER, 0);

curl_exec ($ch);
curl_close ($ch);
fclose ($fp);
//exit;

$subor = @fopen("$practxt", "r");
if (!$subor) { $subor = @fopen("$practxt", "r"); }
    if (!$subor)
    {
        echo "Nenaöiel som 90 dÚov˝ kurzov˝ lÌstok ! "; exit; 
    }
    else
    {

while (! feof($subor))
{
  $riadokx = fgets($subor, 5000);


  $riadokx=str_replace("<Cube time=","\r\n<Cube time=",$riadokx);
  $riadokx=str_replace("<Cube currency=","\r\n<Cube currency=",$riadokx);

  $text = $riadokx;
  fwrite($souborz, $text);


	

}


fclose($souborz);
    }
                }
//koniec 90dni

//urob z pracak38 kurzy38

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctkurzxy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_uctkurzxy$kli_uzid SELECT * FROM F".$kli_vxcf."_uctkurzy WHERE kurz < 0 ";
$vysledek = mysql_query("$sql");

$nazov="../tmp/pracak".$kli_uzid.".xml"; 

$subor = fopen("$nazov", "r");
while (! feof($subor))
{

$zapis=0;

  $riadok = fgets($subor, 500);
  $pole = explode("<Cube ", $riadok);

  $x_x0 = $pole[0];
  $x_x1 = $pole[1];

//echo $x_x1."<br />";


$xx4=substr($x_x1,0,4);
$xx8=substr($x_x1,0,8);

if( $xx4 == "time" )
{
  $timex = explode("time=", $x_x1);
  $x_datk = substr($timex[1],1,10);
}

if( $xx8 == "currency" )
{
  $menax = explode("currency=", $x_x1);
  $x_mena = substr($menax[1],1,3);

  $ratex = explode("rate=", $x_x1);
  $x_kurz = 1*substr($ratex[1],1,10);
  $zapis=1;
}

//echo $x_x1." time ".$x_datk." mena ".$x_mena." kurz ".$x_kurz."<br />";


$sqult = "INSERT INTO F$kli_vxcf"."_uctkurzxy$kli_uzid ( mena,datk,pomr,kurz,prk1,prk2,datm ) ".
" VALUES ( '$x_mena', '$x_datk', '1', '$x_kurz', '1', '0', now() ) ";

if( $zapis == 1 ) 
{ 
$uloz = mysql_query("$sqult"); 
//echo $sqult."<br />"; 
} 


//koniec while
}
fclose ($subor);

$sql = "UPDATE F$kli_vxcf"."_uctkurzxy$kli_uzid,F$kli_vxcf"."_uctmeny ".
" SET F$kli_vxcf"."_uctkurzxy$kli_uzid.prk1=0 ".
" WHERE F$kli_vxcf"."_uctkurzxy$kli_uzid.mena=F$kli_vxcf"."_uctmeny.mena ";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM F$kli_vxcf"."_uctkurzxy$kli_uzid WHERE prk1 = 1 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_uctkurzxy$kli_uzid,F$kli_vxcf"."_uctkurzy ".
" SET F$kli_vxcf"."_uctkurzxy$kli_uzid.pomr=F$kli_vxcf"."_uctkurzy.pomr ".
" WHERE F$kli_vxcf"."_uctkurzxy$kli_uzid.mena=F$kli_vxcf"."_uctkurzy.mena ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_uctkurzxy$kli_uzid,F$kli_vxcf"."_uctkurzy ".
" SET F$kli_vxcf"."_uctkurzxy$kli_uzid.prk2=1 ".
" WHERE F$kli_vxcf"."_uctkurzxy$kli_uzid.mena=F$kli_vxcf"."_uctkurzy.mena AND F$kli_vxcf"."_uctkurzxy$kli_uzid.datk=F$kli_vxcf"."_uctkurzy.datk ";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM F$kli_vxcf"."_uctkurzxy$kli_uzid WHERE prk2 = 1 ";
$vysledek = mysql_query("$sql");

$sql = "INSERT INTO F$kli_vxcf"."_uctkurzy SELECT * FROM F$kli_vxcf"."_uctkurzxy$kli_uzid WHERE prk1 = 0 AND prk2 = 0 ";
$vysledek = mysql_query("$sql");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctkurzxy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//koniec urob z pracak38 kurzy38

echo "Kurzov˝ lÌstok ECB naËÌtan˝ . Zatvorte okno .";

?>
<script type="text/javascript">

window.open('../ucto/kurzy.php?copern=1&drupoh=1&page=1', '_self' )

</script>
<?php


          }
//koniec copern1020
?>