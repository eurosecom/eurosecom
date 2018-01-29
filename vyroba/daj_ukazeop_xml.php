<?php
$sys = 'VYR';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

//vsetky ekonomicke operacie do tabulky
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


$h_ico = $_GET['prm1'];
$h_nai = $_GET['prm2'];
$h_uce = $_GET['prm3'];
$prm4 = $_GET['prm4'];
$ch_ico = 1*$h_ico;
$ch_uce = 1*$h_uce;
$h_naiBD = StrTr($h_nai, "����������������������������ͼ�����������ݎ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

$_SESSION['vyb_zak'] = $h_ico;

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$citvyr = include("../vyroba/citaj_vyr.php");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//DOPLNUJUCE UDAJE
$txp01 = $retezec = iconv("CP1250", "UTF-8", "Dopl�uj�ce �daje o z�kazke"); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", "-");
$txp08 = $retezec = iconv("CP1250", "UTF-8", "2");
$txp09 = $retezec = iconv("CP1250", "UTF-8", "0");

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

$vety->appendChild($veta);

$txp01 = $retezec = iconv("CP1250", "UTF-8", "Z�kazka"); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", "Objedn�vka"); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", "Odberate�"); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", "Objednan�"); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", "D�tum ukon�enia"); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", "Dohodnut� cena"); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", "-");
$txp08 = $retezec = iconv("CP1250", "UTF-8", "1");
$txp09 = $retezec = iconv("CP1250", "UTF-8", "0");

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

$vety->appendChild($veta);

$sqltt = "SELECT * FROM F$kli_vxcf"."_vyrzakdopln".
" LEFT JOIN F$kli_vxcf"."_zak".
" ON F$kli_vxcf"."_vyrzakdopln.zak=F$kli_vxcf"."_zak.zak".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_vyrzakdopln.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_vyrzakdopln.zak = $h_ico ORDER BY F$kli_vxcf"."_vyrzakdopln.zak";
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$iconai=$riadok->ico." ".$riadok->nai;
if( strlen($riadok->nai) < 2 ) $iconai='';
$dao_sk=SkDatum($riadok->dao);
$dau_sk=SkDatum($riadok->dau);
$dhcsk = $riadok->dhc." ".$mena1;

$txp01 = $retezec = iconv("CP1250", "UTF-8", $riadok->zak); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $riadok->obj); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $iconai); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $dao_sk); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", $dau_sk); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $dhcsk); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", $cpol);
$txp08 = $retezec = iconv("CP1250", "UTF-8", "0");
$txp09 = $retezec = iconv("CP1250", "UTF-8", $riadok->pozn);

if( $txp01 == '' ) $txp01='-';
if( $txp02 == '' ) $txp02='-';
if( $txp03 == '' ) $txp03='-';
if( $txp04 == '' ) $txp04='-';
if( $txp05 == '' ) $txp05='0';
if( $txp06 == '' ) $txp06='0';
if( $txp07 == '' ) $txp07='0';
if( $txp08 == '' ) $txp08='0';
if( $txp09 == '' ) $txp09='-';

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

$vety->appendChild($veta);

//datumy
$datum1=SkDatum($riadok->da1);
if( $riadok->da1 == "0000-00-00" ) $datum1="-";
$txp01 = $retezec = iconv("CP1250", "UTF-8", "$pop_datum1 :"); $txp02 = $retezec = iconv("CP1250", "UTF-8", $datum1); 
$txp03='-'; $txp04='-'; $txp05='-'; $txp06='-'; $txp06='-'; $txp08='11';
$pol01 = $dom->createElement('pol01'); $pol01Text = $dom->createTextNode($txp01); $pol01->appendChild($pol01Text);
$pol02 = $dom->createElement('pol02'); $pol02Text = $dom->createTextNode($txp02); $pol02->appendChild($pol02Text);
$pol03 = $dom->createElement('pol03'); $pol03Text = $dom->createTextNode($txp03); $pol03->appendChild($pol03Text);
$pol04 = $dom->createElement('pol04'); $pol04Text = $dom->createTextNode($txp04); $pol04->appendChild($pol04Text);
$pol05 = $dom->createElement('pol05'); $pol05Text = $dom->createTextNode($txp05); $pol05->appendChild($pol05Text);
$pol06 = $dom->createElement('pol06'); $pol06Text = $dom->createTextNode($txp06); $pol06->appendChild($pol06Text);
$pol07 = $dom->createElement('pol07'); $pol07Text = $dom->createTextNode($txp07); $pol07->appendChild($pol07Text);
$pol08 = $dom->createElement('pol08'); $pol08Text = $dom->createTextNode($txp08); $pol08->appendChild($pol08Text);
$pol09 = $dom->createElement('pol09'); $pol09Text = $dom->createTextNode($txp09); $pol09->appendChild($pol09Text);
$veta = $dom->createElement('veta');
$veta->appendChild($pol01); $veta->appendChild($pol02); $veta->appendChild($pol03); $veta->appendChild($pol04); $veta->appendChild($pol05);
$veta->appendChild($pol06); $veta->appendChild($pol07); $veta->appendChild($pol08); $veta->appendChild($pol09); $vety->appendChild($veta);

$datum2=SkDatum($riadok->da2);
if( $riadok->da2 == "0000-00-00" ) $datum2="-";
$txp01 = $retezec = iconv("CP1250", "UTF-8", "$pop_datum2 :"); $txp02 = $retezec = iconv("CP1250", "UTF-8", $datum2); 
$txp03='-'; $txp04='-'; $txp05='-'; $txp06='-'; $txp06='-'; $txp08='11';
$pol01 = $dom->createElement('pol01'); $pol01Text = $dom->createTextNode($txp01); $pol01->appendChild($pol01Text);
$pol02 = $dom->createElement('pol02'); $pol02Text = $dom->createTextNode($txp02); $pol02->appendChild($pol02Text);
$pol03 = $dom->createElement('pol03'); $pol03Text = $dom->createTextNode($txp03); $pol03->appendChild($pol03Text);
$pol04 = $dom->createElement('pol04'); $pol04Text = $dom->createTextNode($txp04); $pol04->appendChild($pol04Text);
$pol05 = $dom->createElement('pol05'); $pol05Text = $dom->createTextNode($txp05); $pol05->appendChild($pol05Text);
$pol06 = $dom->createElement('pol06'); $pol06Text = $dom->createTextNode($txp06); $pol06->appendChild($pol06Text);
$pol07 = $dom->createElement('pol07'); $pol07Text = $dom->createTextNode($txp07); $pol07->appendChild($pol07Text);
$pol08 = $dom->createElement('pol08'); $pol08Text = $dom->createTextNode($txp08); $pol08->appendChild($pol08Text);
$pol09 = $dom->createElement('pol09'); $pol09Text = $dom->createTextNode($txp09); $pol09->appendChild($pol09Text);
$veta = $dom->createElement('veta');
$veta->appendChild($pol01); $veta->appendChild($pol02); $veta->appendChild($pol03); $veta->appendChild($pol04); $veta->appendChild($pol05);
$veta->appendChild($pol06); $veta->appendChild($pol07); $veta->appendChild($pol08); $veta->appendChild($pol09); $vety->appendChild($veta);

$datum3=SkDatum($riadok->da3);
if( $riadok->da3 == "0000-00-00" ) $datum3="-";
$txp01 = $retezec = iconv("CP1250", "UTF-8", "$pop_datum3 :"); $txp02 = $retezec = iconv("CP1250", "UTF-8", $datum3); 
$txp03='-'; $txp04='-'; $txp05='-'; $txp06='-'; $txp06='-'; $txp08='11';
$pol01 = $dom->createElement('pol01'); $pol01Text = $dom->createTextNode($txp01); $pol01->appendChild($pol01Text);
$pol02 = $dom->createElement('pol02'); $pol02Text = $dom->createTextNode($txp02); $pol02->appendChild($pol02Text);
$pol03 = $dom->createElement('pol03'); $pol03Text = $dom->createTextNode($txp03); $pol03->appendChild($pol03Text);
$pol04 = $dom->createElement('pol04'); $pol04Text = $dom->createTextNode($txp04); $pol04->appendChild($pol04Text);
$pol05 = $dom->createElement('pol05'); $pol05Text = $dom->createTextNode($txp05); $pol05->appendChild($pol05Text);
$pol06 = $dom->createElement('pol06'); $pol06Text = $dom->createTextNode($txp06); $pol06->appendChild($pol06Text);
$pol07 = $dom->createElement('pol07'); $pol07Text = $dom->createTextNode($txp07); $pol07->appendChild($pol07Text);
$pol08 = $dom->createElement('pol08'); $pol08Text = $dom->createTextNode($txp08); $pol08->appendChild($pol08Text);
$pol09 = $dom->createElement('pol09'); $pol09Text = $dom->createTextNode($txp09); $pol09->appendChild($pol09Text);
$veta = $dom->createElement('veta');
$veta->appendChild($pol01); $veta->appendChild($pol02); $veta->appendChild($pol03); $veta->appendChild($pol04); $veta->appendChild($pol05);
$veta->appendChild($pol06); $veta->appendChild($pol07); $veta->appendChild($pol08); $veta->appendChild($pol09); $vety->appendChild($veta);

$datum4=SkDatum($riadok->da4);
if( $riadok->da4 == "0000-00-00" ) $datum4="-";
$txp01 = $retezec = iconv("CP1250", "UTF-8", "$pop_datum4 :"); $txp02 = $retezec = iconv("CP1250", "UTF-8", $datum4); 
$txp03='-'; $txp04='-'; $txp05='-'; $txp06='-'; $txp06='-'; $txp08='11';
$pol01 = $dom->createElement('pol01'); $pol01Text = $dom->createTextNode($txp01); $pol01->appendChild($pol01Text);
$pol02 = $dom->createElement('pol02'); $pol02Text = $dom->createTextNode($txp02); $pol02->appendChild($pol02Text);
$pol03 = $dom->createElement('pol03'); $pol03Text = $dom->createTextNode($txp03); $pol03->appendChild($pol03Text);
$pol04 = $dom->createElement('pol04'); $pol04Text = $dom->createTextNode($txp04); $pol04->appendChild($pol04Text);
$pol05 = $dom->createElement('pol05'); $pol05Text = $dom->createTextNode($txp05); $pol05->appendChild($pol05Text);
$pol06 = $dom->createElement('pol06'); $pol06Text = $dom->createTextNode($txp06); $pol06->appendChild($pol06Text);
$pol07 = $dom->createElement('pol07'); $pol07Text = $dom->createTextNode($txp07); $pol07->appendChild($pol07Text);
$pol08 = $dom->createElement('pol08'); $pol08Text = $dom->createTextNode($txp08); $pol08->appendChild($pol08Text);
$pol09 = $dom->createElement('pol09'); $pol09Text = $dom->createTextNode($txp09); $pol09->appendChild($pol09Text);
$veta = $dom->createElement('veta');
$veta->appendChild($pol01); $veta->appendChild($pol02); $veta->appendChild($pol03); $veta->appendChild($pol04); $veta->appendChild($pol05);
$veta->appendChild($pol06); $veta->appendChild($pol07); $veta->appendChild($pol08); $veta->appendChild($pol09); $vety->appendChild($veta);

  }
$i = $i + 1;
   }

//VYROBKY
$txp01 = $retezec = iconv("CP1250", "UTF-8", "V�robky pre z�kazku"); $txp02 = $retezec = iconv("CP1250", "UTF-8", '-'); 
$txp03=$h_ico; $txp04='-'; $txp05='-'; $txp06='-'; $txp06='-'; $txp08='502';
$pol01 = $dom->createElement('pol01'); $pol01Text = $dom->createTextNode($txp01); $pol01->appendChild($pol01Text);
$pol02 = $dom->createElement('pol02'); $pol02Text = $dom->createTextNode($txp02); $pol02->appendChild($pol02Text);
$pol03 = $dom->createElement('pol03'); $pol03Text = $dom->createTextNode($txp03); $pol03->appendChild($pol03Text);
$pol04 = $dom->createElement('pol04'); $pol04Text = $dom->createTextNode($txp04); $pol04->appendChild($pol04Text);
$pol05 = $dom->createElement('pol05'); $pol05Text = $dom->createTextNode($txp05); $pol05->appendChild($pol05Text);
$pol06 = $dom->createElement('pol06'); $pol06Text = $dom->createTextNode($txp06); $pol06->appendChild($pol06Text);
$pol07 = $dom->createElement('pol07'); $pol07Text = $dom->createTextNode($txp07); $pol07->appendChild($pol07Text);
$pol08 = $dom->createElement('pol08'); $pol08Text = $dom->createTextNode($txp08); $pol08->appendChild($pol08Text);
$pol09 = $dom->createElement('pol09'); $pol09Text = $dom->createTextNode($txp09); $pol09->appendChild($pol09Text);
$veta = $dom->createElement('veta');
$veta->appendChild($pol01); $veta->appendChild($pol02); $veta->appendChild($pol03); $veta->appendChild($pol04); $veta->appendChild($pol05);
$veta->appendChild($pol06); $veta->appendChild($pol07); $veta->appendChild($pol08); $veta->appendChild($pol09); $vety->appendChild($veta);

$txp01 = iconv("CP1250", "UTF-8", "-"); $txp02 = iconv("CP1250", "UTF-8", '��slo'); 
$txp03 = iconv("CP1250", "UTF-8", "N�zov"); $txp04 = iconv("CP1250", "UTF-8", 'CenaBdph/Sdph');
$txp05 = iconv("CP1250", "UTF-8", "Mno�stvo"); $txp06 = iconv("CP1250", "UTF-8", 'HodnotaBdph/Sdph');
$txp08='501';
$pol01 = $dom->createElement('pol01'); $pol01Text = $dom->createTextNode($txp01); $pol01->appendChild($pol01Text);
$pol02 = $dom->createElement('pol02'); $pol02Text = $dom->createTextNode($txp02); $pol02->appendChild($pol02Text);
$pol03 = $dom->createElement('pol03'); $pol03Text = $dom->createTextNode($txp03); $pol03->appendChild($pol03Text);
$pol04 = $dom->createElement('pol04'); $pol04Text = $dom->createTextNode($txp04); $pol04->appendChild($pol04Text);
$pol05 = $dom->createElement('pol05'); $pol05Text = $dom->createTextNode($txp05); $pol05->appendChild($pol05Text);
$pol06 = $dom->createElement('pol06'); $pol06Text = $dom->createTextNode($txp06); $pol06->appendChild($pol06Text);
$pol07 = $dom->createElement('pol07'); $pol07Text = $dom->createTextNode($txp07); $pol07->appendChild($pol07Text);
$pol08 = $dom->createElement('pol08'); $pol08Text = $dom->createTextNode($txp08); $pol08->appendChild($pol08Text);
$pol09 = $dom->createElement('pol09'); $pol09Text = $dom->createTextNode($txp09); $pol09->appendChild($pol09Text);
$veta = $dom->createElement('veta');
$veta->appendChild($pol01); $veta->appendChild($pol02); $veta->appendChild($pol03); $veta->appendChild($pol04); $veta->appendChild($pol05);
$veta->appendChild($pol06); $veta->appendChild($pol07); $veta->appendChild($pol08); $veta->appendChild($pol09); $vety->appendChild($veta);

$sqltt = "SELECT * FROM F$kli_vxcf"."_vyrzakpol".
" LEFT JOIN F$kli_vxcf"."_dopsluzby".
" ON F$kli_vxcf"."_vyrzakpol.slu=F$kli_vxcf"."_dopsluzby.slu".
" LEFT JOIN F$kli_vxcf"."_vyrrcph".
" ON F$kli_vxcf"."_vyrzakpol.slu=F$kli_vxcf"."_vyrrcph.crcp".
" WHERE zak = $h_ico ORDER BY F$kli_vxcf"."_vyrzakpol.slu";
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;
$hodbezcelkom=0;
$sHodbezcelkom=0;
$hodsdpcelkom=0;
$sHodsdpcelkom=0;
$celkomvyr=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$hodbez=$riadok->mnov*$riadok->cepv;
$Cislo=$hodbez+"";
$sHodbez=sprintf("%0.2f", $Cislo);
$hodbezcelkom=$hodbezcelkom+$hodbez;
$Cislo=$hodbezcelkom+"";
$sHodbezcelkom=sprintf("%0.2f", $Cislo);

$hodsdp=$riadok->mnov*$riadok->cedv;
$Cislo=$hodsdp+"";
$sHodsdp=sprintf("%0.2f", $Cislo);
$hodsdpcelkom=$hodsdpcelkom+$hodsdp;
$Cislo=$hodsdpcelkom+"";
$sHodsdpcelkom=sprintf("%0.2f", $Cislo);

$cena=$riadok->cepv." / ".$riadok->cedv;
$hodnota=$sHodbez." / ".$sHodsdp;
$celkomvyr=$sHodbezcelkom."/ ".$sHodsdpcelkom;

$txp01 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $riadok->slu); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $riadok->nsl); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $cena); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", $riadok->mnov); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $hodnota); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", $cpol);
$txp08 = $retezec = iconv("CP1250", "UTF-8", "500");
$txp09 = $retezec = iconv("CP1250", "UTF-8", "$riadok->nslp");
$colsadz=trim($riadok->prcp);
$colsadzc=1*$colsadz;
if( $colsadzc > 1 )
{
$txp09 = $retezec = iconv("CP1250", "UTF-8", "$riadok->nslp colny sadzobnik $riadok->prcp - prenos DP");
}
$txp09=trim($txp09);

if( $txp01 == '' ) $txp01='-';
if( $txp02 == '' ) $txp02='-';
if( $txp03 == '' ) $txp03='-';
if( $txp04 == '' ) $txp04='-';
if( $txp05 == '' ) $txp05='0';
if( $txp06 == '' ) $txp06='0';
if( $txp07 == '' ) $txp06='0';
if( $txp08 == '' ) $txp08='0';
if( $txp09 == '' ) $txp09='-';

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

$vety->appendChild($veta);

  }
$i = $i + 1;
   }

$txp01 = $retezec = iconv("CP1250", "UTF-8", "Celkom v�robky Eur:"); $txp02 = $retezec = iconv("CP1250", "UTF-8", $celkomvyr); 
$txp03='-'; $txp04='-'; $txp05='-'; $txp06='-'; $txp06='-'; $txp08='503';
$pol01 = $dom->createElement('pol01'); $pol01Text = $dom->createTextNode($txp01); $pol01->appendChild($pol01Text);
$pol02 = $dom->createElement('pol02'); $pol02Text = $dom->createTextNode($txp02); $pol02->appendChild($pol02Text);
$pol03 = $dom->createElement('pol03'); $pol03Text = $dom->createTextNode($txp03); $pol03->appendChild($pol03Text);
$pol04 = $dom->createElement('pol04'); $pol04Text = $dom->createTextNode($txp04); $pol04->appendChild($pol04Text);
$pol05 = $dom->createElement('pol05'); $pol05Text = $dom->createTextNode($txp05); $pol05->appendChild($pol05Text);
$pol06 = $dom->createElement('pol06'); $pol06Text = $dom->createTextNode($txp06); $pol06->appendChild($pol06Text);
$pol07 = $dom->createElement('pol07'); $pol07Text = $dom->createTextNode($txp07); $pol07->appendChild($pol07Text);
$pol08 = $dom->createElement('pol08'); $pol08Text = $dom->createTextNode($txp08); $pol08->appendChild($pol08Text);
$pol09 = $dom->createElement('pol09'); $pol09Text = $dom->createTextNode($txp09); $pol09->appendChild($pol09Text);
$veta = $dom->createElement('veta');
$veta->appendChild($pol01); $veta->appendChild($pol02); $veta->appendChild($pol03); $veta->appendChild($pol04); $veta->appendChild($pol05);
$veta->appendChild($pol06); $veta->appendChild($pol07); $veta->appendChild($pol08); $veta->appendChild($pol09); $vety->appendChild($veta);

//PREDFAKTURY
$hodcelkom=0;

$txp01 = $retezec = iconv("CP1250", "UTF-8", "Predfakt�ry vyhotoven� na z�kazku"); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", "-");
$txp08 = $retezec = iconv("CP1250", "UTF-8", "1102");
$txp09 = $retezec = iconv("CP1250", "UTF-8", "0");

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

$vety->appendChild($veta);

$txp01 = $retezec = iconv("CP1250", "UTF-8", "Doklad"); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", "��sloPredfakt�ry"); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", "Odberate�"); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", "Vyhotoven�"); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", "Splatn�"); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", "Hodnota"); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", "-");
$txp08 = $retezec = iconv("CP1250", "UTF-8", "1101");
$txp09 = $retezec = iconv("CP1250", "UTF-8", "0");

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

$vety->appendChild($veta);

$sqltt = "SELECT * FROM F$kli_vxcf"."_dopprf".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_dopprf.ico=F$kli_vxcf"."_ico.ico".
" WHERE zak = $h_ico ORDER BY dok";
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;
$hodmatcelkom=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$hodprf=$riadok->hod;
$Cislo=$hodprf+"";
$sHodprf=sprintf("%0.2f", $Cislo);
$dat_sk=SkDatum($riadok->dat);
$das_sk=SkDatum($riadok->das);
$iconai=$riadok->ico." ".$riadok->nai;
if( strlen($riadok->nai) < 2 ) $iconai='';

$txp01 = $retezec = iconv("CP1250", "UTF-8", $riadok->dok); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $riadok->prf); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $iconai); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $dat_sk); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", $das_sk); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $sHodprf); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", $cpol);
$txp08 = $retezec = iconv("CP1250", "UTF-8", "1100");
$txp09 = $retezec = iconv("CP1250", "UTF-8", "0");

if( $txp01 == '' ) $txp01='-';
if( $txp02 == '' ) $txp02='-';
if( $txp03 == '' ) $txp03='-';
if( $txp04 == '' ) $txp04='-';
if( $txp05 == '' ) $txp05='0';
if( $txp06 == '' ) $txp06='0';
if( $txp07 == '' ) $txp06='0';
if( $txp08 == '' ) $txp08='0';

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

$vety->appendChild($veta);

  }
$i = $i + 1;
   }

//DODAKY
$hodcelkom=0;

$txp01 = $retezec = iconv("CP1250", "UTF-8", "Dodacie listy vyhotoven� na z�kazku"); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", "-");
$txp08 = $retezec = iconv("CP1250", "UTF-8", "1202");
$txp09 = $retezec = iconv("CP1250", "UTF-8", "0");

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

$vety->appendChild($veta);

$txp01 = $retezec = iconv("CP1250", "UTF-8", "Doklad"); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", "��sloDodListu"); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", "Odberate�"); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", "Dodan�"); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", "Splatn�"); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", "Hodnota"); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", "-");
$txp08 = $retezec = iconv("CP1250", "UTF-8", "1201");
$txp09 = $retezec = iconv("CP1250", "UTF-8", "0");

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

$vety->appendChild($veta);

$sqltt = "SELECT * FROM F$kli_vxcf"."_dopdol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_dopdol.ico=F$kli_vxcf"."_ico.ico".
" WHERE zak = $h_ico ORDER BY dok";
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;
$hodmatcelkom=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$hoddol=$riadok->hod;
$Cislo=$hoddol+"";
$sHoddol=sprintf("%0.2f", $Cislo);
$dat_sk=SkDatum($riadok->dat);
$das_sk=SkDatum($riadok->das);
$iconai=$riadok->ico." ".$riadok->nai;
if( strlen($riadok->nai) < 2 ) $iconai='';

$txp01 = $retezec = iconv("CP1250", "UTF-8", $riadok->dok); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $riadok->dol); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $iconai); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $dat_sk); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", $das_sk); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $sHoddol); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", $cpol);
$txp08 = $retezec = iconv("CP1250", "UTF-8", "1200");
$txp09 = $retezec = iconv("CP1250", "UTF-8", "0");

if( $txp01 == '' ) $txp01='-';
if( $txp02 == '' ) $txp02='-';
if( $txp03 == '' ) $txp03='-';
if( $txp04 == '' ) $txp04='-';
if( $txp05 == '' ) $txp05='0';
if( $txp06 == '' ) $txp06='0';
if( $txp07 == '' ) $txp06='0';
if( $txp08 == '' ) $txp08='0';

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

$vety->appendChild($veta);

  }
$i = $i + 1;
   }

//FAKTURY
$hodcelkom=0;

$txp01 = $retezec = iconv("CP1250", "UTF-8", "Fakt�ry vyhotoven� na z�kazku"); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", "-");
$txp08 = $retezec = iconv("CP1250", "UTF-8", "1302");
$txp09 = $retezec = iconv("CP1250", "UTF-8", "0");

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

$vety->appendChild($veta);

$txp01 = $retezec = iconv("CP1250", "UTF-8", "Doklad"); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", "��sloFakt�ry"); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", "Odberate�"); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", "Vyhotoven�"); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", "Splatn�"); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", "Hodnota"); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", "-");
$txp08 = $retezec = iconv("CP1250", "UTF-8", "1301");
$txp09 = $retezec = iconv("CP1250", "UTF-8", "0");

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

$vety->appendChild($veta);

$sqltt = "SELECT * FROM F$kli_vxcf"."_dopfak".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_dopfak.ico=F$kli_vxcf"."_ico.ico".
" WHERE zak = $h_ico ORDER BY dok";
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;
$hodmatcelkom=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$hodfak=$riadok->hod;
$Cislo=$hodfak+"";
$sHodfak=sprintf("%0.2f", $Cislo);
$dat_sk=SkDatum($riadok->dat);
$das_sk=SkDatum($riadok->das);
$iconai=$riadok->ico." ".$riadok->nai;
if( strlen($riadok->nai) < 2 ) $iconai='';

$txp01 = $retezec = iconv("CP1250", "UTF-8", $riadok->dok); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $riadok->fak); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $iconai); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $dat_sk); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", $das_sk); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $sHodfak); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", $cpol);
$txp08 = $retezec = iconv("CP1250", "UTF-8", "1300");
$txp09 = $retezec = iconv("CP1250", "UTF-8", "0");

if( $txp01 == '' ) $txp01='-';
if( $txp02 == '' ) $txp02='-';
if( $txp03 == '' ) $txp03='-';
if( $txp04 == '' ) $txp04='-';
if( $txp05 == '' ) $txp05='0';
if( $txp06 == '' ) $txp06='0';
if( $txp07 == '' ) $txp06='0';
if( $txp08 == '' ) $txp08='0';

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

$vety->appendChild($veta);

  }
$i = $i + 1;
   }

//UHRADY
$hodcelkom=0;

$txp01 = $retezec = iconv("CP1250", "UTF-8", "�hrady na z�kazku"); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", "-");
$txp08 = $retezec = iconv("CP1250", "UTF-8", "1402");
$txp09 = $retezec = iconv("CP1250", "UTF-8", "0");

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

$vety->appendChild($veta);

$txp01 = $retezec = iconv("CP1250", "UTF-8", "Doklad"); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", "Variabiln� symbol"); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", "Odberate�"); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", "Uhraden�"); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", "Hodnota"); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", "-");
$txp08 = $retezec = iconv("CP1250", "UTF-8", "1401");
$txp09 = $retezec = iconv("CP1250", "UTF-8", "0");

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

$vety->appendChild($veta);

//uhrady v hotovosti
$sqltt = "SELECT F$kli_vxcf"."_uctpok.dok, fak, F$kli_vxcf"."_uctpok.hod,".
" F$kli_vxcf"."_doppokpri.dat, F$kli_vxcf"."_uctpok.ico, F$kli_vxcf"."_ico.nai,".
" F$kli_vxcf"."_uctpok.zak ".
" FROM F$kli_vxcf"."_uctpok".
" LEFT JOIN F$kli_vxcf"."_doppokpri".
" ON F$kli_vxcf"."_uctpok.dok=F$kli_vxcf"."_doppokpri.dok".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_uctpok.ico=F$kli_vxcf"."_ico.ico".
" WHERE zak = $h_ico ORDER BY F$kli_vxcf"."_uctpok.dok";

//echo $sqltt;
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;
$hodmatcelkom=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$hodfak=$riadok->hod;
$Cislo=$hodfak+"";
$sHodfak=sprintf("%0.2f", $Cislo);
$dat_sk=SkDatum($riadok->dat);
$das_sk=SkDatum($riadok->das);
$iconai=$riadok->ico." ".$riadok->nai;
if( strlen($riadok->nai) < 2 ) $iconai='';

$txp01 = $retezec = iconv("CP1250", "UTF-8", $riadok->dok); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $riadok->fak); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $iconai); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $dat_sk); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $sHodfak); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", $cpol);
$txp08 = $retezec = iconv("CP1250", "UTF-8", "1400");
$txp09 = $retezec = iconv("CP1250", "UTF-8", "0");

if( $txp01 == '' ) $txp01='-';
if( $txp02 == '' ) $txp02='-';
if( $txp03 == '' ) $txp03='-';
if( $txp04 == '' ) $txp04='-';
if( $txp05 == '' ) $txp05='0';
if( $txp06 == '' ) $txp06='0';
if( $txp07 == '' ) $txp06='0';
if( $txp08 == '' ) $txp08='0';

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

$vety->appendChild($veta);

  }
$i = $i + 1;
   }

//uhrady cez banku
$sqltt = "SELECT F$kli_vxcf"."_uctban.dok, fak, F$kli_vxcf"."_uctban.hod,".
" F$kli_vxcf"."_banvyp.dat, F$kli_vxcf"."_uctban.ico, F$kli_vxcf"."_ico.nai,".
" F$kli_vxcf"."_uctban.zak ".
" FROM F$kli_vxcf"."_uctban".
" LEFT JOIN F$kli_vxcf"."_banvyp".
" ON F$kli_vxcf"."_uctban.dok=F$kli_vxcf"."_banvyp.dok".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_uctban.ico=F$kli_vxcf"."_ico.ico".
" WHERE zak = $h_ico ORDER BY F$kli_vxcf"."_uctban.dok";

//echo $sqltt;
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;
$hodmatcelkom=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$hodfak=$riadok->hod;
$Cislo=$hodfak+"";
$sHodfak=sprintf("%0.2f", $Cislo);
$dat_sk=SkDatum($riadok->dat);
$das_sk=SkDatum($riadok->das);
$iconai=$riadok->ico." ".$riadok->nai;
if( strlen($riadok->nai) < 2 ) $iconai='';

$txp01 = $retezec = iconv("CP1250", "UTF-8", $riadok->dok); 
$txp02 = $retezec = iconv("CP1250", "UTF-8", $riadok->fak); 
$txp03 = $retezec = iconv("CP1250", "UTF-8", $iconai); 
$txp04 = $retezec = iconv("CP1250", "UTF-8", $dat_sk); 
$txp05 = $retezec = iconv("CP1250", "UTF-8", "-"); 
$txp06 = $retezec = iconv("CP1250", "UTF-8", $sHodfak); 
$txp07 = $retezec = iconv("CP1250", "UTF-8", $cpol);
$txp08 = $retezec = iconv("CP1250", "UTF-8", "1450");
$txp09 = $retezec = iconv("CP1250", "UTF-8", "0");

if( $txp01 == '' ) $txp01='-';
if( $txp02 == '' ) $txp02='-';
if( $txp03 == '' ) $txp03='-';
if( $txp04 == '' ) $txp04='-';
if( $txp05 == '' ) $txp05='0';
if( $txp06 == '' ) $txp06='0';
if( $txp07 == '' ) $txp06='0';
if( $txp08 == '' ) $txp08='0';

$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

$pol07 = $dom->createElement('pol07');
$pol07Text = $dom->createTextNode($txp07);
$pol07->appendChild($pol07Text);

$pol08 = $dom->createElement('pol08');
$pol08Text = $dom->createTextNode($txp08);
$pol08->appendChild($pol08Text);

$pol09 = $dom->createElement('pol09');
$pol09Text = $dom->createTextNode($txp09);
$pol09->appendChild($pol09Text);

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

// konfigurace pro ulo�en�
//$dom->formatOutput = TRUE;
//$dom->encoding = 'utf-8';
//$dom->save('../tmp/ekooper.xml');
?>
