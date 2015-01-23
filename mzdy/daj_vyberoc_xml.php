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

$citfir = include("../cis/citaj_fir.php");

$h_ico = 1*$_GET['h_ico'];
$h_nai = $_GET['h_nai'];
$h_uce = $_GET['h_uce'];
$prm4 = $_GET['prm4'];
$ch_ico = 1*$h_ico;
$ch_uce = 1*$h_uce;
$h_naiBD = StrTr($h_nai, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

$podmuce = "uce > 0";

$trd="prie";
if( $medo == 1 ) { $trd="oc"; }

if( $h_ico > 0 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdkun".
" WHERE oc = $h_ico ORDER BY oc";
$sql = mysql_query("$sqltt");
}
if( $h_ico == 0 AND $h_nai == '' )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdkun".
" WHERE oc > 0 ORDER BY $trd";
$sql = mysql_query("$sqltt");
}
if( $h_ico == 0 AND $h_nai != '' )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdkun".
" WHERE prbd LIKE '%$h_naiBD%' ORDER BY $trd";
$sql = mysql_query("$sqltt");
}

$cpol = mysql_num_rows($sql);
$i=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

//odstrani diakritiku
$diak=1;
if( $diak == 0 ) 
{ 
$txp01 = StrTr($riadok->ico, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$txp02 = StrTr($riadok->nai, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ"); 
$txp03 = StrTr($riadok->mes, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ"); 
$txp04 = StrTr($riadok->uc1, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ"); 
$txp05 = StrTr($riadok->nm1, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ"); 
$txp06 = StrTr($riadok->dns, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ"); 
}


//s diakritikou prevod do utf-8
if( $diak == 1 ) 
{
$znemx=$riadok->znem;
 
$txp01 = $retezec = iconv("CP1250", "UTF-8", $riadok->oc); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $riadok->prie); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $riadok->meno); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $h_ico); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", $h_nai); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $h_uce); 
$txp08 = $retezec = iconv("CP1250", "UTF-8", $prm4);
$txp09 = $retezec = iconv("CP1250", "UTF-8", $riadok->uva); 
$txp10 = $retezec = iconv("CP1250", "UTF-8", $riadok->titl); 
$txp11 = $retezec = iconv("CP1250", "UTF-8", $riadok->stz); 
$txp12 = $retezec = iconv("CP1250", "UTF-8", $riadok->zkz);
$txp13 = $retezec = iconv("CP1250", "UTF-8", $riadok->znah); 
$txp14 = $retezec = iconv("CP1250", "UTF-8", $znemx);
$txp15 = $retezec = iconv("CP1250", "UTF-8", $riadok->sz0); 
$txp16 = $retezec = iconv("CP1250", "UTF-8", $riadok->sz1);
$txp17 = $retezec = iconv("CP1250", "UTF-8", $riadok->sz2);
$txp18 = $retezec = iconv("CP1250", "UTF-8", $riadok->sz3);
$txp19 = $retezec = iconv("CP1250", "UTF-8", $riadok->sz4);
$txp20 = $retezec = iconv("CP1250", "UTF-8", $riadok->pom);
}

if( $txp01 == '' ) $txp01='0';
if( $txp02 == '' ) $txp02='--';
if( $txp03 == '' ) $txp03='--';
if( $txp04 == '' ) $txp04='-';
if( $txp05 == '' ) $txp05='--';
if( $txp06 == '' ) $txp06='0';
if( $txp08 == '' ) $txp08='0';
if( $txp09 == '' ) $txp09='0';
if( $txp10 == '' ) $txp10='--';
if( $txp11 == '' ) $txp11='0';
if( $txp12 == '' ) $txp12='0';
if( $txp13 == '' ) $txp13='0';
if( $txp14 == '' ) $txp14='0';
if( $txp15 == '' ) $txp15='0';
if( $txp16 == '' ) $txp16='0';
if( $txp17 == '' ) $txp17='0';
if( $txp18 == '' ) $txp18='0';
if( $txp19 == '' ) $txp19='0';
if( $txp20 == '' ) $txp20='1';

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

// create the pol19 element for the veta
$pol19 = $dom->createElement('pol19');
$pol19Text = $dom->createTextNode($txp19);
$pol19->appendChild($pol19Text);

// create the pol20 element for the veta
$pol20 = $dom->createElement('pol20');
$pol20Text = $dom->createTextNode($txp20);
$pol20->appendChild($pol20Text);

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
$veta->appendChild($pol19);
$veta->appendChild($pol20);

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
//$dom->save('../tmp/salico.xml');
?>
