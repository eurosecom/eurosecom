<HTML>
<?php

do
{
$sys = 'FAK';
$urov = 2000;
$drupoh = $_REQUEST['drupoh'];

$uziv = include("../uziv.php");
if( !$uziv ) exit;

$copern = $_REQUEST['copern'];
$citfir = include("../cis/citaj_fir.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vrokx=$kli_vrok-2000;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/uct".$kli_vrokx."".$kli_vmes."_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/uct".$kli_vrokx."".$kli_vmes."_".$kli_uzid."_".$hhmmss.".csv";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

//pocet dni v mesiaci
$pocetdni=31;
$sqltt = "SELECT * FROM kalendar WHERE ume = $kli_vume ";
$sql = mysql_query("$sqltt");
$pocetdni = mysql_num_rows($sql);


$denprvy=$kli_vrok."-".$kli_vmes."-01";
$denposledny=$kli_vrok."-".$kli_vmes."-".$pocetdni;


$nazovsuboru=$outfilex;
$soubor = fopen("$nazovsuboru", "a+");

  $vysledtt = "SELECT * FROM F$kli_vxcf"."_fakodb WHERE dat >= '$denprvy' AND dat <= '$denposledny' ORDER BY dok ";
  $vysledok = mysql_query("$vysledtt");
  while ($riadok = mysql_fetch_object($vysledok))
  {

$riadok->sys=55;

$datsk=SkDatum($riadok->dat);
$dazsk=SkDatum($riadok->daz);
$dassk=SkDatum($riadok->das);

  
  $text = $riadok->uce.";".$riadok->dok.";".$dazsk.";".$riadok->fak;
  $text = $text.";".$riadok->ico.";".$riadok->ksy.";".$riadok->ssy.";".$dassk;
  $text = $text.";".$riadok->hod.";".$riadok->pop.";".$riadok->pom.";".$datsk;
  $text = $text.";".$riadok->ume.";".$riadok->dpr.";".$riadok->hou.";".$riadok->kod;
  $text = $text.";".$riadok->uhr.";".$riadok->duh.";".$riadok->sys.";".$riadok->zk0;
  $text = $text.";".$riadok->zk1.";".$riadok->dn1.";".$riadok->zk2.";".$riadok->dn2;
  $text = $text.";".$riadok->mena.";".$riadok->hodm.";".$riadok->kurz.";".$riadok->sz3;
  $text = $text.";".$riadok->dav.";".$riadok->kon;

  $text = $text."\r\n";
  fwrite($soubor, $text);

  }


$text = "endodber"."\r\n";
fwrite($soubor, $text);

$text = "endpohuc"."\r\n";
fwrite($soubor, $text);


$vysledttf = "SELECT * FROM F$kli_vxcf"."_fakodb WHERE dat >= '$denprvy' AND dat <= '$denposledny' ORDER BY dok ";
$vysledokf = mysql_query("$vysledttf");
while ($riadokf = mysql_fetch_object($vysledokf))
{

  $vysledtt = "SELECT * FROM F$kli_vxcf"."_uctodb".$kli_uzid." WHERE dok = $riadokf->dok ORDER BY ico";
  $vysledok = mysql_query("$vysledtt");
  while ($riadok = mysql_fetch_object($vysledok))
  {

$riadok->sys=55;
  
  $text = $riadok->dok.";".$riadok->ico.";".$riadok->cpr.";".$riadok->fak;
  $text = $text.";".$riadok->ucm.";".$riadok->ucd.";".$riadok->hod.";".$riadok->suh;
  $text = $text.";".$riadok->pop.";".$riadok->str.";".$riadok->zak.";".$riadok->ume;
  $text = $text.";".$riadok->dat.";".$riadok->rdp.";".$riadok->upl.";".$riadok->zme;
  $text = $text.";".$riadok->kod.";".$riadok->sys.";".$riadok->kon;

  $text = $text."\r\n";
  fwrite($soubor, $text);

  }

}


$text = "enducfak"."\r\n";
fwrite($soubor, $text);

$vysledttf = "SELECT * FROM F$kli_vxcf"."_fakodb WHERE dat >= '$denprvy' AND dat <= '$denposledny' ORDER BY dok ";
$vysledokf = mysql_query("$vysledttf");
while ($riadokf = mysql_fetch_object($vysledokf))
{

  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $riadokf->ico ORDER BY ico");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  
  $text = $riadok->ico.";".$riadok->icd.";".$riadok->nai.";".$riadok->uli.";;";
  $text = $text.";".$riadok->psc.";".$riadok->mes.";".$riadok->tel.";".$riadok->fax.";".$riadok->kon;
  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

}

$text = "endico"."\r\n";
fwrite($soubor, $text);

$text = "endsklfak"."\r\n";
fwrite($soubor, $text);

fclose($soubor);

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Export faktúry</title>

</HEAD>
<BODY class="white" >

<table class="h2" width="100%" >
<tr>
<td>EuroSecom 
<?php
  if ( $copern == 1 ) echo "- Export faktúr do súboru CSV";

?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php

?>
<br />
<br />
Stiahnite si nižšie uvedený súbor CSV na Váš lokálny disk:
<br />
<br />
<a href="<?php echo $outfilex; ?>"><?php echo $outfilex; ?></a>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />


<?php
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>