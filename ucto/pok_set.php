<?php
$sys = 'UCT';
$urov = 10;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

//ponuka stredisk
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

$sql = "SELECT zmd FROM F$kli_vxcf"."_pokladnicaset";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = 'DROP TABLE F'.$kli_vxcf.'_pokladnicaset'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_pokladnicaset';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   polozka      VARCHAR(10) not null,
   ucm1         VARCHAR(10) not null,
   ucm2         VARCHAR(10) not null,
   ucm3         VARCHAR(10) not null,
   ucm4         VARCHAR(10) not null,
   ucm5         VARCHAR(10) not null,
   ico1         DECIMAL(8,0) DEFAULT 0,
   ico2         DECIMAL(8,0) DEFAULT 0,
   ico3         DECIMAL(8,0) DEFAULT 0,
   ico4         DECIMAL(8,0) DEFAULT 0,
   ico5         DECIMAL(8,0) DEFAULT 0,
   zmd          DECIMAL(1,0) DEFAULT 0,
   zdl          DECIMAL(1,0) DEFAULT 0,
   omd          DECIMAL(1,0) DEFAULT 0,
   odl          DECIMAL(1,0) DEFAULT 0,
   pmd          DECIMAL(1,0) DEFAULT 0,
   pdl          DECIMAL(1,0) DEFAULT 0
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_pokladnicaset'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$vsql = "CREATE TABLE F".$kli_vxcf."_pokladnicaset SELECT * FROM F".$kli_vxcf."_pokladnicaset".$kli_uzid." ";
$vytvor = mysql_query("$vsql");
}

$vsql = "CREATE TABLE F".$kli_vxcf."_pokladnicaset".$kli_uzid." SELECT * FROM F".$kli_vxcf."_pokladnicaset ";
$vytvor = mysql_query("$vsql");

//h_str
$prm1 = $_GET['prm1'];
$prm2 = $_GET['prm2'];
//ako prm3
$prm3 = $_GET['prm3'];
//polozka prm4
$prm4 = $_GET['prm4'];


$sqltt = "SELECT * FROM F$kli_vxcf"."_pokladnicaset$kli_uzid ";
$sql = mysql_query("$sqltt");

$ucm1=0; $ucm2=0; $ucm3=0; $ucm4=0; $ucm5=0; $ico1=0; $ico2=0; $ico3=0; $ico4=0; $ico5=0; $zmd=0; $zdl=0; $omd=0; $odl=0; $pmd=0; $pdl=0;

$cpol = 1;
$i=0;
   while ( $i < $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

//echo "idem";

$ucm1=$riadok->ucm1;
$ucm2=$riadok->ucm2;
$ucm3=$riadok->ucm3;
$ucm4=$riadok->ucm4;
$ucm5=$riadok->ucm5;

$cucm1=1*$riadok->ucm1;
$cucm2=1*$riadok->ucm2;
$cucm3=1*$riadok->ucm3;
$cucm4=1*$riadok->ucm4;
$cucm5=1*$riadok->ucm5;
if( $cucm1 == 0 ) $ucm1=0;
if( $cucm2 == 0 ) $ucm2=0;
if( $cucm3 == 0 ) $ucm3=0;
if( $cucm4 == 0 ) $ucm4=0;
if( $cucm5 == 0 ) $ucm5=0;

$ico1=1*$riadok->ico1;
$ico2=1*$riadok->ico2;
$ico3=1*$riadok->ico3;
$ico4=1*$riadok->ico4;
$ico5=1*$riadok->ico5;

$zmd=1*$riadok->zmd;
$zdl=1*$riadok->zdl;
$omd=1*$riadok->omd;
$odl=1*$riadok->odl;
$pmd=1*$riadok->pmd;
$pdl=1*$riadok->pdl;

  }
$i = $i + 1;
   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_pokladnicaset ";
$sql = mysql_query("$sqltt");

$ucm1x=0; $ucm2x=0; $ucm3x=0; $ucm4x=0; $ucm5x=0; $ico1x=0; $ico2x=0; $ico3x=0; $ico4x=0; $ico5x=0; $zmdx=0; $zdlx=0; $omdx=0; $odlx=0; $pmdx=0; $pdlx=0;

$cpol = 1;
$i=0;
   while ( $i < $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

//echo "idem";

$ucm1x=$riadok->ucm1;
$ucm2x=$riadok->ucm2;
$ucm3x=$riadok->ucm3;
$ucm4x=$riadok->ucm4;
$ucm5x=$riadok->ucm5;

$cucm1=1*$riadok->ucm1;
$cucm2=1*$riadok->ucm2;
$cucm3=1*$riadok->ucm3;
$cucm4=1*$riadok->ucm4;
$cucm5=1*$riadok->ucm5;
if( $cucm1 == 0 ) $ucm1x=0;
if( $cucm2 == 0 ) $ucm2x=0;
if( $cucm3 == 0 ) $ucm3x=0;
if( $cucm4 == 0 ) $ucm4x=0;
if( $cucm5 == 0 ) $ucm5x=0;

$ico1x=1*$riadok->ico1;
$ico2x=1*$riadok->ico2;
$ico3x=1*$riadok->ico3;
$ico4x=1*$riadok->ico4;
$ico5x=1*$riadok->ico5;

$zmdx=1*$riadok->zmd;
$zdlx=1*$riadok->zdl;
$omdx=1*$riadok->omd;
$odlx=1*$riadok->odl;
$pmdx=1*$riadok->pmd;
$pdlx=1*$riadok->pdl;

  }
$i = $i + 1;
   }

$txp01 = $retezec = iconv("CP1250", "UTF-8", $ucm1); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $ucm2); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $ucm3); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $ucm4); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", $prm1); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $ucm5x); 
$txp08 = $retezec = iconv("CP1250", "UTF-8", $ico1x); 
$txp09 = $retezec = iconv("CP1250", "UTF-8", $ico2x); 
$txp10 = $retezec = iconv("CP1250", "UTF-8", $ico3x); 
$txp11 = $retezec = iconv("CP1250", "UTF-8", $ico4x); 
$txp12 = $retezec = iconv("CP1250", "UTF-8", $ico5); 
$txp13 = $retezec = iconv("CP1250", "UTF-8", $zmd); 
$txp14 = $retezec = iconv("CP1250", "UTF-8", $zdlx);
$txp15 = $retezec = iconv("CP1250", "UTF-8", $omdx); 
$txp16 = $retezec = iconv("CP1250", "UTF-8", $odlx);
$txp17 = $retezec = iconv("CP1250", "UTF-8", $pmd); 
$txp18 = $retezec = iconv("CP1250", "UTF-8", $pdl);


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

// create the pol09 element for the veta
$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

// create the pol10 element for the veta
$pol10 = $dom->createElement('pol10');
$pol10Text = $dom->createTextNode($txp10);
$pol10->appendChild($pol10Text);

// create the pol11 element for the veta
$pol11 = $dom->createElement('pol11');
$pol11Text = $dom->createTextNode($txp11);
$pol11->appendChild($pol11Text);

// create the pol12 element for the veta
$pol12 = $dom->createElement('pol12');
$pol12Text = $dom->createTextNode($txp12);
$pol12->appendChild($pol12Text);

// create the pol13 element for the veta
$pol13 = $dom->createElement('pol13');
$pol13Text = $dom->createTextNode($txp13);
$pol13->appendChild($pol13Text);

// create the pol14 element for the veta
$pol14 = $dom->createElement('pol14');
$pol14Text = $dom->createTextNode($txp14);
$pol14->appendChild($pol14Text);

// create the pol15 element for the veta
$pol15 = $dom->createElement('pol15');
$pol15Text = $dom->createTextNode($txp15);
$pol15->appendChild($pol15Text);

// create the pol16 element for the veta
$pol16 = $dom->createElement('pol16');
$pol16Text = $dom->createTextNode($txp16);
$pol16->appendChild($pol16Text);

// create the pol17 element for the veta
$pol17 = $dom->createElement('pol17');
$pol17Text = $dom->createTextNode($txp17);
$pol17->appendChild($pol17Text);

// create the pol18 element for the veta
$pol18 = $dom->createElement('pol18');
$pol18Text = $dom->createTextNode($txp18);
$pol18->appendChild($pol18Text);



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
$veta->appendChild($pol10);
$veta->appendChild($pol11);
$veta->appendChild($pol12);
$veta->appendChild($pol13);
$veta->appendChild($pol14);
$veta->appendChild($pol15);
$veta->appendChild($pol16);
$veta->appendChild($pol17);
$veta->appendChild($pol18);


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
//$dom->save('../tmp/strediska.xml');
?>
