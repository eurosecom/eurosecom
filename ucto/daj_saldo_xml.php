<?php
$sys = 'UCT';
$urov = 1;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

//vytvorenie saldokonta
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

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$h_al = 1*$_GET['h_al'];
$h_ico = $_GET['prm1'];
$h_nai = $_GET['prm2'];
$h_uce = $_GET['prm3'];
$prm4 = $_GET['prm4'];
$h_obd = $_GET['obd'];
$ch_ico = 1*$h_ico;
$ch_uce = 1*$h_uce;
$h_naiBD = StrTr($h_nai, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

$podmuce = "uce = $h_uce";
if( $h_al == 1 ) $podmuce = "uce > 0";

if( $h_ico != '' AND $h_obd == 0 )
{
$sqltt = "SELECT *".
" FROM F$kli_vxcf"."_prsaldo".$kli_uzid.
" WHERE $podmuce AND ico = $h_ico ORDER BY uce,ico,fak,dat,drupoh";
//echo $sqltt;
$sql = mysql_query("$sqltt");
}

if( $h_ico != '' AND $h_obd == 100 )
{
$sqltt = "SELECT *".
" FROM F$kli_vxcf"."_prsaldo".$kli_uzid.
" WHERE $podmuce AND ico = $h_ico AND ( drupoh = 7 OR drupoh = 8 ) ORDER BY uce,ico,fak,dat,drupoh";
//echo $sqltt;
$sql = mysql_query("$sqltt");
}

if( $h_ico != '' AND $h_obd >= 1 ANd $h_obd <= 12 )
{
$akeobd=$h_obd.".".$kli_vrok;
$sqltt = "SELECT *".
" FROM F$kli_vxcf"."_prsaldo".$kli_uzid.
" WHERE $podmuce AND ico = $h_ico AND ( drupoh = 7 OR drupoh = 8 OR ume <= $akeobd ) ORDER BY uce,ico,fak,dat,drupoh";
//echo $sqltt;
$sql = mysql_query("$sqltt");
}

$zostatok=0;

$cpol = mysql_num_rows($sql);
$i=0;
   while ($i <= $cpol AND $i < 100 )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

//odstrani diakritiku
$diak=1;


$dat_sk=SkDatum($riadok->dat);
$das_sk=SkDatum($riadok->das);
if( $das_sk == '00.00.0000' ) { $das_sk="-"; }
if( $dat_sk == '00.00.0000' ) { $dat_sk=SkDatum($riadok->dau); }



//s diakritikou prevod do utf-8
if( $diak == 1 ) 
{ 
$txp01 = $retezec = iconv("CP1250", "UTF-8", $riadok->uce); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $riadok->ume); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $dat_sk); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $das_sk); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", $riadok->ico); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $riadok->fak); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", $riadok->dok);
$txp08 = $retezec = iconv("CP1250", "UTF-8", $riadok->poz);
$txp09 = $retezec = iconv("CP1250", "UTF-8", $riadok->hod);
$txp10 = $retezec = iconv("CP1250", "UTF-8", $riadok->drupoh);
$txp11 = $retezec = iconv("CP1250", "UTF-8", $riadok->uhr);
$txp12 = $retezec = iconv("CP1250", "UTF-8", $riadok->zos);
}
if( $riadok->drupoh == 11 )
    {
$mno=0; $hod=0;
$sqlttt = "SELECT uce, dok FROM F$kli_vxcf"."_pokpri WHERE dok = $riadok->dok ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $txp01 = $retezec = iconv("CP1250", "UTF-8", $riaddok->uce);
  }
    }
if( $riadok->drupoh == 12 )
    {
$mno=0; $hod=0;
$sqlttt = "SELECT uce, dok FROM F$kli_vxcf"."_pokvyd WHERE dok = $riadok->dok ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $txp01 = $retezec = iconv("CP1250", "UTF-8", $riaddok->uce);
  }
    }
if( $riadok->drupoh == 1313 )
    {
$mno=0; $hod=0;
$sqlttt = "SELECT uce, dok FROM F$kli_vxcf"."_banvyp WHERE dok = $riadok->dok ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $txp01 = $retezec = iconv("CP1250", "UTF-8", $riaddok->uce);
  }
    }

$zostatok=$zostatok+$riadok->zas;

if( $txp01 == '' ) $txp01='0';
if( $txp02 == '' ) $txp02='0';
if( $txp03 == '' ) $txp03='0';
if( $txp04 == '' ) $txp04='0';
if( $txp05 == '' ) $txp05='0';
if( $txp05 == '' ) $txp05='0';
if( $txp06 == '' ) $txp06='0';
if( $txp07 == '' ) $txp07='0';
$txp08=trim($txp08);
if( $txp08 == '' ) $txp08='--';
if( $txp08 == ' ' ) $txp08='--';
$txp08 = AddSlashes($txp08);
$txp08 = strip_tags($txp08);
//$txp08 = urlencode($txp08);
//$txp08 = urldecode($txp08);
$txp08 = StrTr($txp08, "\r"," ");
$txp08 = StrTr($txp08, "\n"," ");
if( $txp09 == '' ) $txp09='0';
if( $txp10 == '' ) $txp10='0';
if( $txp11 == '' ) $txp11='0';
if( $txp12 == '' ) $txp12='0';

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
//$dom->save('../tmp/saldo.xml');
?>
