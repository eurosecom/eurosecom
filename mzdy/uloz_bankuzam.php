<?php
$sys = 'MZD';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

//ponuka ico pre saldokonto
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

$h_oc = $_GET['h_oc'];
$uceb = strip_tags($_GET['uceb']);
$numb = strip_tags($_GET['numb']);
$vsy = strip_tags($_GET['vsy']);
$ksy = strip_tags($_GET['ksy']);
$ssy = strip_tags($_GET['ssy']);
$prm4 = $_GET['prm4'];
$iban = strip_tags($_GET['iban']);
$swft = strip_tags($_GET['swft']);

if( $prm4 == 1 ) 
{
if( trim($uceb) == '' AND trim($iban) != '' ) {  $uceb = 1*substr($iban,14,10); }   
if( trim($numb) == '' AND trim($iban) != '' ) {  $numb = substr($iban,4,4); }

$sqltt = "UPDATE F$kli_vxcf"."_mzdkun".
" SET vban=1, uceb='$uceb', numb='$numb', vsy='$vsy', ksy='$ksy', ssy='$ssy'".
" WHERE oc = $h_oc";
$sql = mysql_query("$sqltt");

$sqltt = "INSERT INTO F$kli_vxcf"."_mzdtextmzd ( invt ) VALUES ( '$h_oc' ) ";
$sql = mysql_query("$sqltt");

$sqltt = "UPDATE F$kli_vxcf"."_mzdtextmzd".
" SET ziban='$iban', zswft='$swft' ".
" WHERE invt = $h_oc";
$sql = mysql_query("$sqltt");
}

if( $prm4 == 2 ) 
{
$sqltt = "UPDATE F$kli_vxcf"."_mzdprm".
" SET uced='$uceb', numd='$numb', vsyd='$vsy', ksyd='$ksy', ssyd='$ssy'";
$sql = mysql_query("$sqltt");
}

if( $prm4 == 3 ) 
{
$sqltt = "UPDATE F$kli_vxcf"."_mzdprm".
" SET uces='$uceb', nums='$numb', vsys='$vsy', ksys='$ksy', ssys='$ssy'";
$sql = mysql_query("$sqltt");
}

if( $prm4 == 4 ) 
{
$sqltt = "UPDATE F$kli_vxcf"."_mzdprm".
" SET ucedz='$uceb', numdz='$numb', vsydz='$vsy', ksydz='$ksy', ssydz='$ssy'";
$sql = mysql_query("$sqltt");
}

if( $prm4 == 5 ) 
{
$sqltt = "UPDATE F$kli_vxcf"."_mzdprm".
" SET uceo='$uceb', numo='$numb', vsyo='$vsy', ksyo='$ksy', ssyo='$ssy'";
$sql = mysql_query("$sqltt");
}

//odstrani diakritiku
$diak=1;

//s diakritikou prevod do utf-8
if( $diak == 1 ) 
{ 
$txp01 = $retezec = iconv("CP1250", "UTF-8", $h_oc); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $uceb); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $numb); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $vsy); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", $ksy); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $ssy); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", $prm4);
$txp08 = $retezec = iconv("CP1250", "UTF-8", $swft);
$txp09 = $retezec = iconv("CP1250", "UTF-8", $iban); 

}

if( $txp01 == '' ) $txp01='0';
if( $txp02 == '' ) $txp02='0';
if( $txp03 == '' ) $txp03='0';
if( $txp04 == '' ) $txp04='0';
if( $txp05 == '' ) $txp05='0';
if( $txp06 == '' ) $txp06='0';
if( $txp07 == '' ) $txp07='0';
if( $txp08 == '' ) $txp08='0';
if( $txp09 == '' ) $txp08='0';

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
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

// create the pol08 element for the veta
$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

// create the pol09 element for the veta
$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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
$veta->appendChild($pol09);

// append <veta> as a child of <vety>
$vety->appendChild($veta);



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
//$dom->save('../tmp/ulmena.xml');
?>
