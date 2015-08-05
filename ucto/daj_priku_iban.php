<?php
$sys = 'UCT';
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

$h_ico = $_GET['ico'];
$h_vsy = $_GET['vsy'];
$h_uceb = $_GET['uceb'];
$prm4 = $_GET['prm4'];
$ucm = 1*$_GET['ucm'];
$ucd = 1*$_GET['ucd'];
$uce = 1*$_GET['uce'];

$ch_ico = 1*$h_ico;
$ch_vsy = 1*$h_vsy;
$h_ucebBD = StrTr($h_uceb, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$h_vsyBD = StrTr($h_vsy, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

$tried="nai";
if( $slovakiaplay == 1 ) $tried="F$kli_vxcf"."_prsaldoicofak$kli_uzid.ico";


if( $prm4 == 1 ) 
     {
if( $h_uceb == '' AND $ch_vsy > 0 ) 
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prsaldoicofak$kli_uzid.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_prsaldoicofak$kli_uzid.ico > 0 AND fak = $ch_vsy ORDER BY nai,fak";
$sql = mysql_query("$sqltt");
}
if( $h_uceb != '' ) 
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prsaldoicofak$kli_uzid.ico=F$kli_vxcf"."_ico.ico".
" WHERE nai LIKE '%$h_ucebBD%' ORDER BY nai,fak";
$sql = mysql_query("$sqltt");
}
     }

if( $prm4 == 2 ) 
     {
if( $h_uceb == '' ) 
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_ico".
" WHERE ico > 0 ORDER BY nai";
$sql = mysql_query("$sqltt");
}
if( $h_uceb != '' ) 
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_ico".
" WHERE nai LIKE '%$h_ucebBD%' OR uc1 LIKE '%$h_ucebBD%' OR uc2 LIKE '%$h_ucebBD%' OR uc3 LIKE '%$h_ucebBD%' ORDER BY nai";
$sql = mysql_query("$sqltt");
}
     }

if( $prm4 == 3 ) 
     {
if( $h_uceb == '' ) 
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctprikp".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_uctprikp.ico=F$kli_vxcf"."_ico.ico".
" WHERE cpl > 0 AND dok = 1 ORDER BY uceb";
$sql = mysql_query("$sqltt");
}
if( $h_uceb != '' ) 
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctprikp".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_uctprikp.ico=F$kli_vxcf"."_ico.ico".
" WHERE nai LIKE '%$h_ucebBD%' OR uceb LIKE '%$h_ucebBD%' ORDER BY uceb";
$sql = mysql_query("$sqltt");
}
     }


//bankove
if( $prm4 == 4 ) 
     {

$podmuce="uce > 0";
if( $ucm == $uce AND $ucd > 0 ) { $drt="odber"; $podmuce="uce = ".$ucd; }
if( $ucm > 0 AND $ucd == $uce ) { $drt="dodav"; $podmuce="uce = ".$ucm; }


if( $h_vsy != '' ) 
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prsaldoicofak$kli_uzid.ico=F$kli_vxcf"."_ico.ico".
" WHERE nai LIKE '%$h_vsyBD%' OR ( fak = $ch_vsy AND $podmuce ) ORDER BY $tried,fak";
}
if( $h_vsy == '0' ) 
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prsaldoicofak$kli_uzid.ico=F$kli_vxcf"."_ico.ico".
" WHERE ( fak > 0 AND $podmuce AND zos != 0 ) ORDER BY $tried,fak";
}
$sql = mysql_query("$sqltt");
     }
//koniec bankove

$cpol = mysql_num_rows($sql);
$i=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

//odstrani diakritiku
$diak=1;

if( $prm4 == 1 OR $prm4 == 2 OR $prm4 == 3 OR $prm4 == 4 ) 
          { 

//s diakritikou prevod do utf-8
if( $diak == 1 AND ( $prm4 == 1 OR $prm4 == 2 OR $prm4 == 4 ) ) 
{ 
$h_hdx=1*($riadok->hdp-$riadok->hdu);
$txp01 = $retezec = iconv("CP1250", "UTF-8", $riadok->ico); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $riadok->nai); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $riadok->mes); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $h_vsy); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", $h_uceb); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $riadok->uce); 
$txp08 = $retezec = iconv("CP1250", "UTF-8", $riadok->uc1);
$txp09 = $retezec = iconv("CP1250", "UTF-8", $riadok->hod);
$txp10 = $retezec = iconv("CP1250", "UTF-8", $riadok->uhr);
$txp11 = $retezec = iconv("CP1250", "UTF-8", $riadok->zos);
$txp12 = $retezec = iconv("CP1250", "UTF-8", $riadok->nm1);
$txp13 = $retezec = iconv("CP1250", "UTF-8", $riadok->fak);
$txp14 = $retezec = iconv("CP1250", "UTF-8", $riadok->ksy);
$txp15 = $retezec = iconv("CP1250", "UTF-8", $riadok->ssy);
$txp16 = $retezec = iconv("CP1250", "UTF-8", $prm4);
$txp17 = $retezec = iconv("CP1250", "UTF-8", $h_hdx);

$ibn1=""; $bic1="";

if( $prm4 == 1 OR $prm4 == 2 ) 
          { 

  $pole1 = explode("-", $riadok->ib1);
  $h_ib1 = $pole1[0];
  $h_st1 = $pole1[1];

$ibn1=trim($h_ib1);
if( $ibn1 == '' ) $ibn1="0000";
$bic1=trim($h_st1);
if( $bic1 == '' ) $bic1="0";

          }

$txp18 = $retezec = iconv("CP1250", "UTF-8", $ibn1);
$txp19 = $retezec = iconv("CP1250", "UTF-8", $bic1);
}
if( $diak == 1 AND ( $prm4 == 3 ) ) 
{ 
$h_hdx=1*($riadok->hdp-$riadok->hdu);
$txp01 = $retezec = iconv("CP1250", "UTF-8", $riadok->ico); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $riadok->nai); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $riadok->mes); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $h_vsy); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", $h_uceb); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $riadok->uce); 
$txp08 = $retezec = iconv("CP1250", "UTF-8", $riadok->uceb);
$txp09 = $retezec = iconv("CP1250", "UTF-8", $riadok->hodp);
$txp10 = $retezec = iconv("CP1250", "UTF-8", $riadok->uhr);
$txp11 = $retezec = iconv("CP1250", "UTF-8", $riadok->hodp);
$txp12 = $retezec = iconv("CP1250", "UTF-8", $riadok->numb);
$txp13 = $retezec = iconv("CP1250", "UTF-8", $riadok->vsy);
$txp14 = $retezec = iconv("CP1250", "UTF-8", $riadok->ksy);
$txp15 = $retezec = iconv("CP1250", "UTF-8", $riadok->ssy);
$txp16 = $retezec = iconv("CP1250", "UTF-8", $prm4);
$txp17 = $retezec = iconv("CP1250", "UTF-8", $h_hdx);
$txp18 = $retezec = iconv("CP1250", "UTF-8", $riadok->iban);
$txp19 = $retezec = iconv("CP1250", "UTF-8", $riadok->pbic);
}


if( $txp01 == '' ) $txp01='--';
if( $txp02 == '' ) $txp02='--';
$txp02 = AddSlashes($txp02);
if( $txp03 == '' ) $txp03='--';
$txp03 = AddSlashes($txp03);
if( $txp04 == '' ) $txp04='-';
if( $txp05 == '' ) $txp05='0';
if( $txp06 == '' ) $txp06='0';
if( $txp08 == '' ) $txp08='0';
if( $txp09 == '' ) $txp09='0';
if( $txp10 == '' ) $txp10='0';
if( $txp11 == '' ) $txp11='0';
if( $txp12 == '' ) $txp12='0';
if( $txp13 == '' ) $txp13='0';
if( $txp14 == '' ) $txp14='0';
if( $txp15 == '' ) $txp15='0';
if( $txp16 == '' ) $txp16='0';
if( $txp17 == '' ) $txp17='0';
if( $txp18 == '' ) $txp18='0000';
if( $txp19 == '' ) $txp19='0';

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

// append <veta> as a child of <vety>
$vety->appendChild($veta);

          }
//koniec prm4=1,2


if( $prm4 == 2 AND $riadok->uc2 != '' ) 
          { 

$cpol=$cpol+1;

//s diakritikou prevod do utf-8
if( $diak == 1 ) 
{ 
$txp01 = $retezec = iconv("CP1250", "UTF-8", $riadok->ico); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $riadok->nai); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $riadok->mes); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $h_vsy); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", $h_uceb); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $riadok->uce); 
$txp08 = $retezec = iconv("CP1250", "UTF-8", $riadok->uc2);
$txp09 = $retezec = iconv("CP1250", "UTF-8", $riadok->hod);
$txp10 = $retezec = iconv("CP1250", "UTF-8", $riadok->uhr);
$txp11 = $retezec = iconv("CP1250", "UTF-8", $riadok->zos);
$txp12 = $retezec = iconv("CP1250", "UTF-8", $riadok->nm2);
$txp13 = $retezec = iconv("CP1250", "UTF-8", $riadok->fak);
$txp14 = $retezec = iconv("CP1250", "UTF-8", $riadok->ksy);
$txp15 = $retezec = iconv("CP1250", "UTF-8", $riadok->ssy);
$txp16 = $retezec = iconv("CP1250", "UTF-8", $prm4);

$ibn2=""; $bic2="";

if( $prm4 == 2 ) 
          { 

  $pole2 = explode("-", $riadok->ib2);
  $h_ib2 = $pole2[0];
  $h_st2 = $pole2[1];

$ibn2=trim($h_ib2);
if( $ibn2 == '' ) $ibn2="0000";
$bic2=trim($h_st2);
if( $bic2 == '' ) $bic2="0";

          }

$txp18 = $retezec = iconv("CP1250", "UTF-8", $ibn2);
$txp19 = $retezec = iconv("CP1250", "UTF-8", $bic2);
}

if( $txp01 == '' ) $txp01='--';
if( $txp02 == '' ) $txp02='--';
$txp02 = AddSlashes($txp02);
if( $txp03 == '' ) $txp03='--';
$txp03 = AddSlashes($txp03);
if( $txp04 == '' ) $txp04='-';
if( $txp05 == '' ) $txp05='0';
if( $txp06 == '' ) $txp06='0';
if( $txp08 == '' ) $txp08='0';
if( $txp09 == '' ) $txp09='0';
if( $txp10 == '' ) $txp10='0';
if( $txp11 == '' ) $txp11='0';
if( $txp12 == '' ) $txp12='0';
if( $txp13 == '' ) $txp13='0';
if( $txp14 == '' ) $txp14='0';
if( $txp15 == '' ) $txp15='0';
if( $txp16 == '' ) $txp16='0';
$txp17='0';
if( $txp18 == '' ) $txp18='0000';
if( $txp19 == '' ) $txp19='0';

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

// append <veta> as a child of <vety>
$vety->appendChild($veta);

          }
//koniec prm4=2 a uc2

if( $prm4 == 2 AND $riadok->uc3 != '' ) 
          { 

$cpol=$cpol+1;

//s diakritikou prevod do utf-8
if( $diak == 1 ) 
{ 
$txp01 = $retezec = iconv("CP1250", "UTF-8", $riadok->ico); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $riadok->nai); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $riadok->mes); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $h_vsy); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", $h_uceb); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $riadok->uce); 
$txp08 = $retezec = iconv("CP1250", "UTF-8", $riadok->uc3);
$txp09 = $retezec = iconv("CP1250", "UTF-8", $riadok->hod);
$txp10 = $retezec = iconv("CP1250", "UTF-8", $riadok->uhr);
$txp11 = $retezec = iconv("CP1250", "UTF-8", $riadok->zos);
$txp12 = $retezec = iconv("CP1250", "UTF-8", $riadok->nm3);
$txp13 = $retezec = iconv("CP1250", "UTF-8", $riadok->fak);
$txp14 = $retezec = iconv("CP1250", "UTF-8", $riadok->ksy);
$txp15 = $retezec = iconv("CP1250", "UTF-8", $riadok->ssy);
$txp16 = $retezec = iconv("CP1250", "UTF-8", $prm4);

$ibn3=""; $bic3="";

if( $prm4 == 2 ) 
          { 

  $pole3 = explode("-", $riadok->ib3);
  $h_ib3 = $pole3[0];
  $h_st3 = $pole3[1];

$ibn3=trim($h_ib3);
if( $ibn3 == '' ) $ibn3="0000";
$bic3=trim($h_st3);
if( $bic3 == '' ) $bic3="0";

          }

$txp18 = $retezec = iconv("CP1250", "UTF-8", $ibn3);
$txp19 = $retezec = iconv("CP1250", "UTF-8", $bic3);
}

if( $txp01 == '' ) $txp01='--';
if( $txp02 == '' ) $txp02='--';
$txp02 = AddSlashes($txp02);
if( $txp03 == '' ) $txp03='--';
$txp03 = AddSlashes($txp03);
if( $txp04 == '' ) $txp04='-';
if( $txp05 == '' ) $txp05='0';
if( $txp06 == '' ) $txp06='0';
if( $txp08 == '' ) $txp08='0';
if( $txp09 == '' ) $txp09='0';
if( $txp10 == '' ) $txp10='0';
if( $txp11 == '' ) $txp11='0';
if( $txp12 == '' ) $txp12='0';
if( $txp13 == '' ) $txp13='0';
if( $txp14 == '' ) $txp14='0';
if( $txp15 == '' ) $txp15='0';
if( $txp16 == '' ) $txp16='0';
$txp17='0';
if( $txp18 == '' ) $txp18='0000';
if( $txp19 == '' ) $txp19='0';

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

// append <veta> as a child of <vety>
$vety->appendChild($veta);

          }
//koniec prm4=2 a uc3

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
