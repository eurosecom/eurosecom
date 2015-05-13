<?php
$sys = 'SKL';
$urov = 1;
$uziv = include("../uziv.php");
if( !$uziv ) exit;


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
$podmzasoba="";
if( $fir_xsk02 == 1 ) $podmzasoba="AND zas != 0 ";
$sklzasoby="sklzas";
if( $fir_xsk04 == 1 ) $sklzasoby="sklzaspriemer";
//$sklzasoby="sklzas";

$prm1 = $_GET['prm1'];
$prm2 = $_GET['prm2'];
$prm3 = $_GET['prm3'];
$prm4 = $_GET['prm4'];
$cprm1 = 1*$prm1;
$prm2BD = StrTr($prm2, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

if( $prm1 == "" AND $prm2 == "" AND $prm4 == 1 )
{ 
$sqltt = "SELECT skl, F$kli_vxcf"."_$sklzasoby.cis, nat, natBD, F$kli_vxcf"."_$sklzasoby.cen,".
" mer, zas, xmerx, xmer2, xmerk".
" FROM F$kli_vxcf"."_$sklzasoby".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_$sklzasoby.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_sklcisudaje".
" ON F$kli_vxcf"."_$sklzasoby.cis=F$kli_vxcf"."_sklcisudaje.xcis".
" WHERE F$kli_vxcf"."_$sklzasoby.cis > 0 AND skl > 0 ORDER BY skl,natBD";

$sql = mysql_query("$sqltt");
}


if( $prm1 == "" AND $prm2 == "" AND $prm4 == 0 )
{ 
$sqltt = "SELECT skl, F$kli_vxcf"."_$sklzasoby.cis, nat, natBD, F$kli_vxcf"."_$sklzasoby.cen,".
" mer, zas, xmerx, xmer2, xmerk, dph".
" FROM F$kli_vxcf"."_$sklzasoby".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_$sklzasoby.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_sklcisudaje".
" ON F$kli_vxcf"."_$sklzasoby.cis=F$kli_vxcf"."_sklcisudaje.xcis".
" WHERE F$kli_vxcf"."_$sklzasoby.cis > 0 AND skl = $prm3 $podmzasoba ORDER BY skl,natBD";

$sql = mysql_query("$sqltt");
}

if( $prm1 == "" AND $prm2 != "" AND $prm4 == 1  )
{ 
$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_sklcis".
" LEFT JOIN F$kli_vxcf"."_sklcisudaje".
" ON F$kli_vxcf"."_sklcis.cis=F$kli_vxcf"."_sklcisudaje.xcis".
" WHERE natBD LIKE '%$prm2BD%'  ORDER BY natBD";
$sql = mysql_query("$sqltt");
}


if( $prm1 == "" AND $prm2 != "" AND $prm4 == 0 )
{ 
$sqltt = "SELECT skl, F$kli_vxcf"."_$sklzasoby.cis, nat, natBD, F$kli_vxcf"."_$sklzasoby.cen,".
" mer, zas, xmerx, xmer2, xmerk, dph".
" FROM F$kli_vxcf"."_$sklzasoby".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_$sklzasoby.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_sklcisudaje".
" ON F$kli_vxcf"."_$sklzasoby.cis=F$kli_vxcf"."_sklcisudaje.xcis".
" WHERE natBD LIKE '%$prm2BD%' AND skl = $prm3 $podmzasoba ORDER BY skl,natBD";
$sql = mysql_query("$sqltt");
}


if( $prm1 != "" AND $prm4 == 1 ) 
{ 
$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_sklcis".
" LEFT JOIN F$kli_vxcf"."_sklcisudaje".
" ON F$kli_vxcf"."_sklcis.cis=F$kli_vxcf"."_sklcisudaje.xcis".
" WHERE F$kli_vxcf"."_sklcis.cis = $cprm1 ORDER BY cis";
$sql = mysql_query("$sqltt");
}

if( $prm1 != "" AND $prm4 == 0 ) 
{ 
$sqltt = "SELECT skl, F$kli_vxcf"."_$sklzasoby.cis, nat, natBD, F$kli_vxcf"."_$sklzasoby.cen,".
" mer, zas, xmerx, xmer2, xmerk, dph ".
" FROM F$kli_vxcf"."_$sklzasoby".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_$sklzasoby.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_sklcisudaje".
" ON F$kli_vxcf"."_$sklzasoby.cis=F$kli_vxcf"."_sklcisudaje.xcis".
" WHERE F$kli_vxcf"."_$sklzasoby.cis = $cprm1 AND skl = $prm3 $podmzasoba ORDER BY skl,cis";
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
$xmerx=1*$riadok->xmerx;
$xmerk=1*$riadok->xmerk;

$txp01 = $retezec = iconv("CP1250", "UTF-8", $riadok->cis); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $riadok->nat); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $riadok->dph); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $riadok->mer); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", $riadok->cen); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $riadok->zas); 
$txp08 = $retezec = iconv("CP1250", "UTF-8", $riadok->skl);

$txp09 = $retezec = iconv("CP1250", "UTF-8", $xmerx); 
$txp10 = $retezec = iconv("CP1250", "UTF-8", $riadok->xmer2); 
$txp11 = $retezec = iconv("CP1250", "UTF-8", $xmerk); 
}

if( $txp01 == '' ) $txp01='--';
if( $txp02 == '' ) $txp02='--';
$txp02 = AddSlashes($txp02);
if( $txp03 == '' ) $txp03='20';
if( $txp04 == '' ) $txp04='-';
$txp04 = AddSlashes($txp04);
if( $txp05 == '' ) $txp05='0';
if( $txp06 == '' ) $txp06='0';
if( $txp08 == '' ) $txp08='0';
if( $txp09 == '' ) $txp09='0';
if( $txp10 == '' ) $txp10='-';
if( $txp11 == '' ) $txp11='0';

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
//$dom->save('../tmp/sklvyd.xml');
?>
