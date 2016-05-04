<?php

$sys = 'UCT';
$urov = 3000;
$copern = $_REQUEST['copern'];

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

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


$hhmmss = Date ("dmY_Hi", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$adresar="../dokumenty/FIR".$kli_vxcf."/euler/";

$nazzip="saldo_".$hhmmss.".zip";

$zip = new ZipArchive();
$filename = "./$nazzip";

if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
}


$sqltt5 = "SELECT * FROM F$kli_vxcf"."_ucthlasenie_euler WHERE dsuma > 0 AND nahl = 1 ORDER BY ico ";
$sql5 = mysql_query("$sqltt5");                                                   
$pol5 = mysql_num_rows($sql5);

$i5=0;
  while ($i5 <= $pol5 )
  {
  if (@$zaznam=mysql_data_seek($sql5,$i5))
{
$hlavicka5=mysql_fetch_object($sql5);

$sqlfir = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $hlavicka5->ico ";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$ico_nai = trim($fir_riadok->nai);
$ico_mes = trim($fir_riadok->mes);
$ico_uli = trim($fir_riadok->uli);
$ico_psc = $fir_riadok->psc;
$ico_konemail = $fir_riadok->em1;
$ico_kontel = $fir_riadok->tel;
$ico_konfax = $fir_riadok->fax;
$ico_stat="SR";

$ico_naib = StrTr($ico_nai, "áäèïéìëí¾òôóöàøšúùüýžÁÄÈÏÉÌËÍ¼ÒÓÖÔØÀŠÚÙÜÝŽ","aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

$odkial=$adresar."saldo_DUKOM, s.r.o..csv";
$nazov="saldo_DUKOM, s.r.o..csv";

$odkial=$adresar."saldo_".$ico_naib.".csv";
$nazov="saldo_".$ico_naib.".csv";

$zip->addFile("$odkial", "$nazov");

}
$i5 = $i5 + 1;
  }


echo "numfiles: " . $zip->numFiles . "\n";
echo "status:" . $zip->status . "\n";
$zip->close();


// Stream the file to the client 
header("Content-Type: application/zip"); 
header("Content-Length: " . filesize($filename)); 
header("Content-Disposition: attachment; filename=\"$nazzip\""); 
readfile($filename); 

unlink($filename);
?> 