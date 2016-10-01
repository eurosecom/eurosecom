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

$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/uct".$kli_vrokx."".$kli_vmes."_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/uct".$kli_vrokx."".$kli_vmes."_".$kli_uzid."_".$hhmmss.".csv";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

$nazovsuboru=$outfilex;
$soubor = fopen("$nazovsuboru", "a+");


  $text = "101;##########Tabulka F$kli_vxcf"."_ico"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ico;dic;icd;nai;na2;uli;psc;mes;tel;fax;em1;em2;em3;www;uc1;nm1;ib1;uc2;nm2;ib2;uc3;nm3;ib3;dns;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_ico ORDER BY ico");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";
  
  $text = $text.";".$riadok->ico.";".$riadok->dic.";".$riadok->icd.";".$riadok->nai.";".$riadok->na2.";".$riadok->uli.";".$riadok->psc;
  $text = $text.";".$riadok->mes.";".$riadok->tel.";".$riadok->fax.";".$riadok->em1.";".$riadok->em2.";".$riadok->em3.";".$riadok->www;
  $text = $text.";".$riadok->uc1.";".$riadok->nm1.";".$riadok->ib1.";".$riadok->uc2.";".$riadok->nm2.";".$riadok->ib2.";".$riadok->uc3;
  $text = $text.";".$riadok->nm3.";".$riadok->ib3.";".$riadok->dns.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

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