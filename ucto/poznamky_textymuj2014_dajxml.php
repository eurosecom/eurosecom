<?php
$sys = 'UCT';
$urov = 10;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

//ponuka zakaziek
// set the output content type as xml
header('Content-Type: text/xml; Accept-Charset: utf-8; ');
//header('Content-Type: text/xml ');
// create the new XML document
$dom = new DOMDocument();

// create the root <response> element
$response = $dom->createElement('response');
$dom->appendChild($response);

// create the <vety> element and append it as a child of <response>
$vety = $dom->createElement('vety');
$response->appendChild($vety);


require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//h_zak,h_str
$prm1 = $_GET['prm1'];
$prm2 = $_GET['prm2'];
//ako prm3
$cfirmy = 1*$_GET['prm3'];
//polozka prm4
$prm4 = $_GET['prm4'];


$kli_vrokxy=$kli_vrok;
$firmaneex=1;
$sqlfir = "SELECT * FROM fir WHERE xcf = $cfirmy ";
$fir_vysledok = mysql_query($sqlfir);
$kolkofir = 1*mysql_num_rows($fir_vysledok);
if( $kolkofir == 1 ) { $firmaneex=0; }
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $kli_vrokxy = 1*$fir_riadok->rok;  }

if( $firmaneex == 1 ) { echo "Zadana firma cislo ".$cfirmy." neexistuje v ciselniku firiem."; exit; }

$databaza="";
$kli_vrokx=$kli_vrok;
$kli_vrok=$kli_vrokxy;
$dtb2 = include("../cis/oddel_dtbz2.php");
$kli_vrok=$kli_vrokx;


//z akych poznamok ideme umoznuje len z novych
$idemezostarych=0;


if( $idemezostarych == 0 )
  {
$sqltt = "SELECT * FROM ".$databaza."F$cfirmy"."_poznamky_muj2014texty WHERE psys >= 0 ORDER BY ozntxt";
$sql = mysql_query("$sqltt");
  }



$cpol = mysql_num_rows($sql);
$i=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i) OR $i == 0 )
  {
$riadok=mysql_fetch_object($sql);

//odstrani diakritiku
$diak=1;

//s diakritikou prevod do utf-8
if( $diak == 1 ) 
{ 
$txp01 = $retezec = iconv("CP1250", "UTF-8", $riadok->ozntxt); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $riadok->hdntxt); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $cfirmy); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $idemezostarych); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", $prm1); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $prm4); 
$txp08 = $retezec = iconv("CP1250", "UTF-8", 0);
}


if( $txp01 == '' ) $txp01='--';
if( $txp02 == '' ) $txp02='--';
$txp02 = AddSlashes($txp02);
if( $txp03 == '' ) $txp03='0';
if( $txp04 == '' ) $txp04='-';
if( $txp05 == '' ) $txp05='0';
if( $txp06 == '' ) $txp06='0';
if( $txp08 == '' ) $txp08='0';

// create the title element for the veta
$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

// create the pol02 element for the veta
$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

// create the pol03 element for the veta
$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

// create the pol04 element for the veta
$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);
 
// create the pol05 element for the veta
$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

// create the pol06 element for the veta
$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

// create the pol07 element for the veta
$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($cpol);
$pol07->appendChild($pol07Text);

// create the pol08 element for the veta
$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

// create the <veta> element 
$veta = $dom->createElement('veta');
$veta->appendChild($pol01);
$veta->appendChild($pol02);
$veta->appendChild($pol03);
$veta->appendChild($pol04);
$veta->appendChild($pol05);
$veta->appendChild($pol06);
$veta->appendChild($pol07);
$veta->appendChild($pol08);

// append <veta> as a child of <vety>
$vety->appendChild($veta);

  }
$i = $i + 1;
   }


//uloz xml strukturu
// build the XML structure in a string variable
$dom->encoding = 'utf-8';
$xmlString = $dom->saveXML();
// output the XML string
echo $xmlString;

// vystup textoveho retazca
//echo $xmlString;
//print $xmlString;

// konfigurace pro uložení
//$dom->formatOutput = TRUE;
//$dom->encoding = 'utf-8';
//$dom->save('../tmp/zakazky.xml');
?>
