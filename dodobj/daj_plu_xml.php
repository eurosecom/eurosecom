<?php
$sys = 'FAK';
$urov = 1;
$uziv = include("../uziv.php");
if( !$uziv ) exit;


// set the output content type as xml
header('Content-Type: text/xml; Accept-Charset: utf-8; ');
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
$sklzasoby="sklzas";
if( $fir_xsk04 == 1 ) { $sklzasoby="sklzaspriemer"; }
$kli_vxcfskl=$kli_vxcf;
if( $fir_xfa06 >  0 ) { $kli_vxcfskl=$fir_xfa06; }

$prm1 = $_GET['prm1'];
$prm2 = $_GET['prm2'];
$cprm1 = 1*$prm1;
if( $cprm1 == 0 ) { $prm1=""; }

$cennik=1*$_GET['cennik'];;

if( $prm1 == "" AND $prm2 == "" )
{ 
$sqltt = "SELECT skl, F$kli_vxcfskl"."_$sklzasoby.cis, F$kli_vxcfskl"."_sklcis.nat, F$kli_vxcfskl"."_sklcis.mer,".
" F$kli_vxcfskl"."_sklcis.dph, cen, zas, cep, ced".
" FROM F$kli_vxcfskl"."_$sklzasoby".
" LEFT JOIN F$kli_vxcfskl"."_sklcis".
" ON F$kli_vxcfskl"."_$sklzasoby.cis=F$kli_vxcfskl"."_sklcis.cis".
" WHERE ( F$kli_vxcfskl"."_$sklzasoby.cis > 0 )".
" ORDER BY nat";

//echo $sqltt;
$sql = mysql_query("$sqltt");
}


if( $prm1 == "" AND $prm2 != "" )
{ 
$sqltt = "SELECT skl, F$kli_vxcfskl"."_$sklzasoby.cis, F$kli_vxcfskl"."_sklcis.nat, F$kli_vxcfskl"."_sklcis.mer,".
" F$kli_vxcfskl"."_sklcis.dph, cen, zas, cep, ced".
" FROM F$kli_vxcfskl"."_$sklzasoby".
" LEFT JOIN F$kli_vxcfskl"."_sklcis".
" ON F$kli_vxcfskl"."_$sklzasoby.cis=F$kli_vxcfskl"."_sklcis.cis".
" WHERE ( F$kli_vxcfskl"."_sklcis.nat LIKE '%$prm2%' )".
" ORDER BY nat";

$sql = mysql_query("$sqltt");
}

if( $prm1 != "" ) 
{ 
$sqltt = "SELECT skl, F$kli_vxcfskl"."_$sklzasoby.cis, F$kli_vxcfskl"."_sklcis.nat, F$kli_vxcfskl"."_sklcis.mer,".
" F$kli_vxcfskl"."_sklcis.dph, cen, zas, cep, ced".
" FROM F$kli_vxcfskl"."_$sklzasoby".
" LEFT JOIN F$kli_vxcfskl"."_sklcis".
" ON F$kli_vxcfskl"."_$sklzasoby.cis=F$kli_vxcfskl"."_sklcis.cis".
" WHERE ( F$kli_vxcfskl"."_$sklzasoby.cis = $cprm1 )".
" ORDER BY nat";

$sql = mysql_query("$sqltt");
}

//echo $sqltt;

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
$txp01 = StrTr($riadok->slu, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$txp02 = StrTr($riadok->nsl, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ"); 
$txp03 = StrTr($riadok->dph, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ"); 
$txp04 = StrTr($riadok->cep, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ"); 
$txp05 = StrTr($riadok->ced, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ"); 
$txp06 = StrTr($riadok->mer, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ"); 
}

//s diakritikou prevod do utf-8
if( $diak == 1 ) 
{ 
$cenap=$riadok->cep;
$cenad=$riadok->ced;
$cislotov=1*$riadok->cis;
$zasoba=$riadok->zas;

  $ajeshop=0;
  if (File_Exists ("../eshop/index.php")) { $ajeshop=1; }
  if( $ajeshop == 1 )       
  {
$sumaobj=0;
$sqlfir = "SELECT SUM(xmno) AS xmnos FROM F$kli_vxcfskl"."_kosikobj WHERE xfak = 0 AND xcis = $cislotov ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$sumaobj = 1*$fir_riadok->xmnos; 
$zasoba=$riadok->zas-$sumaobj;
  } 

if( $cennik > 0 ) 
    {

$sqlttts = "SELECT * FROM F$kli_vxcfskl"."_sklcisudaje WHERE xcis = $cislotov ";
//echo $sqlttts;
$sqldoks = mysql_query("$sqlttts");
  if (@$zaznam=mysql_data_seek($sqldoks,0))
  {
  $riaddoks=mysql_fetch_object($sqldoks);
  if( $cennik == 1 ) { $cenap=$riaddoks->cep01; $cenad=$riaddoks->ced01; }
  if( $cennik == 2 ) { $cenap=$riaddoks->cep02; $cenad=$riaddoks->ced02; }
  if( $cennik == 3 ) { $cenap=$riaddoks->cep03; $cenad=$riaddoks->ced03; }
  if( $cennik == 4 ) { $cenap=$riaddoks->cep04; $cenad=$riaddoks->ced04; }
  }
    }

$txp01 = $retezec = iconv("CP1250", "UTF-8", $riadok->cis); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $riadok->nat); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $riadok->dph); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $cenap); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", $cenad); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $riadok->mer); 

$txp08 = $retezec = iconv("CP1250", "UTF-8", $riadok->skl); 
$txp09 = $retezec = iconv("CP1250", "UTF-8", $riadok->cen); 
$txp10 = $retezec = iconv("CP1250", "UTF-8", $zasoba); 

}

if( $txp01 == '' ) $txp01='--';
if( $txp02 == '' ) $txp02='--';
$txp02 = AddSlashes($txp02);
//$txp02 = URLEncode($txp02);
if( $txp03 == '' ) $txp03='--';
if( $txp04 == '' ) $txp04='0.00';
if( $txp05 == '' ) $txp05='0.00';
if( $txp06 == '' ) $txp06='-';
//$txp06 = AddSlashes($txp06);
$txp06 = AddSlashes($txp06);

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

// append <veta> as a child of <vety>
$vety->appendChild($veta);

  }
$i = $i + 1;
   }



//uloz xml strukturu
// build the XML structure in a string variable
//$dom->formatOutput = TRUE;
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
//$dom->save('../tmp/sluzby.xml');
?>
