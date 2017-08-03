<HTML>
<?php

do
{
$sys = 'ANA';
$urov = 2900;
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$vsetko = 1*$_REQUEST['vsetko'];

$uziv = include("../uziv.php");
if( !$uziv ) exit;

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

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";



?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Export do CSV</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    
</script>
</HEAD>
<BODY class="white" id="white" onload="" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Export do CSV

<a href="#" onClick="window.open('../ucto/meszos.php?copern=1&drupoh=1&page=1&sysx=UCT', '_self' )">
<img src='../obr/export.png' width=20 height=15 border=0 title='Prejs do mesaèných úètovných zostáv' ></a>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//zakladna ponuka
if( $copern == 1 )
{
?>



<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('export_csv.php?copern=10&drupoh=1&page=1&vsetko=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export celého saldokonta do CSV súboru
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('export_csv.php?copern=10&drupoh=1&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export nespárovaného saldokonta aktuálny stav do CSV súboru
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('export_csv.php?copern=10&drupoh=1&page=1&vsetko=2', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export celého saldokonta za posledne vybrané IÈO v saldokonte z analýz do CSV súboru
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('export_csv.php?copern=10&drupoh=1&page=1&vsetko=3', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export nespárovaného saldokonta posledne vytvorenú zostavu v saldokonte z analýz do CSV súboru

<td class="bmenu" width="2%">
<?php 
//$alchem=1; 
if( $alchem == 1 ) 
{ ?>
<a href="#" onClick="window.open('export_csv.php?copern=10&drupoh=1&page=1&vsetko=5', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/export.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV pre banku' ></a>
<?php
} ?>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('export_csv.php?copern=10&drupoh=1&page=1&vsetko=4', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export nespárovaného saldokonta sumy za IÈO rozdeleného pod¾a splatnosti posledne vytvorenú zostavu v saldokonte z analýz do CSV súboru
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" title="Dolehotné" onClick="window.open('saldo_csv.php?copern=10&drupoh=1&page=1&pol=0', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 ></a>
<td class="bmenu" width="2%">
<a href="#" title="Polehotné" onClick="window.open('saldo_csv.php?copern=10&drupoh=1&page=1&pol=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 ></a>
<td class="bmenu" width="96%">
Export dolehotného a polehotného saldokonta, posledne vytvorenú zostavu v saldokonte do CSV súboru
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('export_csv.php?copern=20&drupoh=1&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export Výkaz ziskov a strát Úè POD 2-01 do CSV súboru
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('export_csv.php?copern=30&drupoh=1&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export Súvaha Úè POD 1-01 do CSV súboru
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('export_csv.php?copern=120&drupoh=1&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export Výsledovka Úè NUJ 2-01 príloha è.2 k opatreniu è. MF/25682/2007-74 do CSV súboru
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('export_csv.php?copern=130&drupoh=1&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export Súvaha Úè NUJ 1-01 príloha è.1 k opatreniu è. MF/25682/2007-74 do CSV súboru
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('export_csv.php?copern=40&drupoh=1&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export Výsledovka jednoduchá do CSV súboru
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('export_csv.php?copern=50&drupoh=1&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export Súvaha jednoduchá do CSV súboru
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('hlkniha_csv.php?copern=10&drupoh=1&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export Hlavnej knihy položkovej do CSV súboru

<a href="#" onClick="window.open('hlkniha_csv.php?copern=10&drupoh=1&page=1&podlastr=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV triedené pod¾a STR' ></a>

</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('knihafaktur_csv.php?copern=10&drupoh=1&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export Knihy faktúr do CSV súboru
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('export_topman.php?copern=10&drupoh=1&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export pre TOPMAN do CSV súboru

<a href="#" onClick="window.open('export_topman.php?copern=20&drupoh=1&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/naradie.png' width=15 height=15 border=1 title='Nastavenie exportu pre TOPMAN do formátu CSV' ></a>

</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('export_csv.php?copern=310&drupoh=1&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export Nedok

</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('danovy_csv.php?copern=1&drupoh=1&page=1', '_self', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export súborov CSV pre Ïanový úrad pri kontrole
</table>

<?php
}
//koniec zakladnej ponuky
?>

<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU SALDOKONTA
if( $copern == 10 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="saldokonto";
if( $vsetko == 4 ) { $nazsub="rsaldokonto"; }

if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");


$sqltt = "SELECT * FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prsaldoicofak".$kli_uzid.".ico=F$kli_vxcf"."_ico.ico".
" WHERE zos != 0 ORDER BY uce,nai,fak,dok";
if( $vsetko == 1 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prsaldoicofak".$kli_uzid.".ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_prsaldoicofak$kli_uzid.ico != 0 ORDER BY uce,nai,fak,dok";
}
if( $vsetko == 2 )
{
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_anauceico$kli_uzid");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_uce=$riaddok->uce;
  $h_ico=$riaddok->ico;
  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prsaldoicofak".$kli_uzid.".ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_prsaldoicofak$kli_uzid.ico = $h_ico AND uce = $h_uce ORDER BY uce,nai,fak,dok";
//echo $sqltt;
}
if( $vsetko == 3 )
{
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_anauceico$kli_uzid");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_uce=$riaddok->uce;
  $h_ico=$riaddok->ico;
  }

$h_uce3=substr($h_uce,0,3);

$sqltt = "SELECT * FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prsaldoicofaknesp".$kli_uzid.".ico=F$kli_vxcf"."_ico.ico".
" WHERE LEFT(uce,3) = $h_uce3 AND pox = 1 ORDER BY uce,nai,fak,dok";
//echo $sqltt;

//SELECT * FROM F43_prsaldoicofaknesp38 LEFT JOIN F43_ico ON F43_prsaldoicofaknesp38.ico=F43_ico.ico 
//WHERE uce = 31100 ORDER BY uce,pox1,nai,F43_prsaldoicofaknesp38.ico,pox,dat,dok,fak

}
if( $vsetko == 4 )
{
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_anauceico$kli_uzid");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_uce=$riaddok->uce;
  $h_ico=$riaddok->ico;
  }

$h_uce3=substr($h_uce,0,3);

$sqlttx = "UPDATE F$kli_vxcf"."_prsaldoicofaknesproz$kli_uzid SET pox2=pox ";
$sqlx = mysql_query("$sqlttx");
$sqlttx = "UPDATE F$kli_vxcf"."_prsaldoicofaknesproz$kli_uzid SET pox2=991 WHERE pox = 993 ";
$sqlx = mysql_query("$sqlttx");

$sqltt = "SELECT * FROM F$kli_vxcf"."_prsaldoicofaknesproz$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prsaldoicofaknesproz$kli_uzid.ico=F$kli_vxcf"."_ico.ico".
" WHERE ( pox = 991 OR pox = 993 OR pox = 997 OR pox = 999 )  ".
" ORDER BY pox2,uce,pox,nai ";
//echo $sqltt;

//SELECT * FROM F43_prsaldoicofaknesproz38 LEFT JOIN F43_ico ON F43_prsaldoicofaknesproz38.ico=F43_ico.ico 
//WHERE uce = 31100 ORDER BY pox2,nai,F43_prsaldoicofaknesproz38.ico,pox

}

if( $vsetko == 5 )
{

$sqlttx = "DROP TABLE F$kli_vxcf"."_prsaldoicofakcsv$kli_uzid ";
$sqlx = mysql_query("$sqlttx");

$sqlttx = "CREATE TABLE F$kli_vxcf"."_prsaldoicofakcsv$kli_uzid SELECT * FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE LEFT(uce,3) = 311 AND pox = 1 ";
$sqlx = mysql_query("$sqlttx");

//pox1  pox2  pox  drupoh  uce  puc  ume  dat  das  daz  dok  ico  fak  poz  ksy  ssy  hdp  hdu  hod  uhr  zos  dau  

$sqlttx = "DELETE FROM F$kli_vxcf"."_prsaldoicofakcsv$kli_uzid WHERE zos <= 0 ";
$sqlx = mysql_query("$sqlttx");

$dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$sqlttx = "UPDATE F$kli_vxcf"."_prsaldoicofakcsv$kli_uzid SET pox1=TO_DAYS(das)-TO_DAYS(dat) WHERE pox = 1 ";
$sqlx = mysql_query("$sqlttx");

if( $kli_vrok < 2014 )
  {
$sqlttx = "DELETE FROM F$kli_vxcf"."_prsaldoicofakcsv$kli_uzid WHERE pox1 > 180 ";
$sqlx = mysql_query("$sqlttx");

$sqlttx = "UPDATE F$kli_vxcf"."_prsaldoicofakcsv$kli_uzid SET pox1=TO_DAYS('$dnes')-TO_DAYS(das) WHERE pox = 1 ";
$sqlx = mysql_query("$sqlttx");

$sqlttx = "DELETE FROM F$kli_vxcf"."_prsaldoicofakcsv$kli_uzid WHERE pox1 > 30 ";
$sqlx = mysql_query("$sqlttx");
  }
if( $kli_vrok >= 2014 )
  {
$sqlttx = "DELETE FROM F$kli_vxcf"."_prsaldoicofakcsv$kli_uzid WHERE pox1 > 270 ";
$sqlx = mysql_query("$sqlttx");

$sqlttx = "UPDATE F$kli_vxcf"."_prsaldoicofakcsv$kli_uzid SET pox1=TO_DAYS('$dnes')-TO_DAYS(das) WHERE pox = 1 ";
$sqlx = mysql_query("$sqlttx");

$sqlttx = "DELETE FROM F$kli_vxcf"."_prsaldoicofakcsv$kli_uzid WHERE pox1 > 30 ";
$sqlx = mysql_query("$sqlttx");

if( $fir_fico == 31424317 )
        {
$sqlttx = "DELETE FROM F$kli_vxcf"."_prsaldoicofakcsv$kli_uzid WHERE ico = 36671291 ";
$sqlx = mysql_query("$sqlttx");
        }

  }

$sqlttx = "INSERT INTO F$kli_vxcf"."_prsaldoicofakcsv$kli_uzid SELECT ".
" pox1,pox2,999,drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,poz,ksy,ssy,hdp,hdu,SUM(hod),SUM(uhr),SUM(zos),dau ".
" FROM F$kli_vxcf"."_prsaldoicofakcsv$kli_uzid WHERE LEFT(uce,3) = 311 GROUP BY pox ";
$sqlx = mysql_query("$sqlttx");

$sqltt = "SELECT * FROM F$kli_vxcf"."_prsaldoicofakcsv$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prsaldoicofakcsv$kli_uzid.ico=F$kli_vxcf"."_ico.ico".
" WHERE pox > 0  ".
" ORDER BY pox,uce,nai ";
//echo $sqltt;



}

$sql = mysql_query("$sqltt");
$pocet = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ( $i <= $pocet )
  {

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$das_sk=SkDatum($hlavicka->das);
$dat_sk=SkDatum($hlavicka->dat);
$dau_sk=SkDatum($hlavicka->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk=$dau_sk;

if( $vsetko != 4 AND $vsetko != 5 )
     {
$hod=$hlavicka->hod;
$ehod=str_replace(".",",",$hod);
$uhr=$hlavicka->uhr;
$euhr=str_replace(".",",",$uhr);
$zos=$hlavicka->zos;
$ezos=str_replace(".",",",$zos);

if( $i == 0 )
{
  $text = "ucet;ico;nazov;mesto;doklad;vystavena;splatna;faktura;hodnota;uhradene;zostatok;popis"."\r\n";
  fwrite($soubor, $text);
}

  $text = $hlavicka->uce.";".$hlavicka->ico.";".$hlavicka->nai.";".$hlavicka->mes.";";
  $text = $text.$hlavicka->dok.";".$dat_sk.";".$das_sk.";".$hlavicka->fak.";";
  $text = $text.$ehod.";".$euhr.";".$ezos.";";
  $text = $text.";$hlavicka->pop"."\r\n";
  fwrite($soubor, $text);

     }


if( $vsetko == 4 )
     {
$dol=$hlavicka->dol;
$edol=str_replace(".",",",$dol);
$pol=$hlavicka->pol;
$epol=str_replace(".",",",$pol);
$zos=$hlavicka->zos;
$ezos=str_replace(".",",",$zos);

$po1=$hlavicka->po1;
$epo1=str_replace(".",",",$po1);
$po2=$hlavicka->po2;
$epo2=str_replace(".",",",$po2);
$po3=$hlavicka->po3;
$epo3=str_replace(".",",",$po3);
$po4=$hlavicka->po4;
$epo4=str_replace(".",",",$po4);
$po5=$hlavicka->po5;
$epo5=str_replace(".",",",$po5);
$po6=$hlavicka->po6;
$epo6=str_replace(".",",",$po6);
$po7=$hlavicka->po7;
$epo7=str_replace(".",",",$po7);

if( $i == 0 ) {

  $text = "ucet;ico;nazov;nezaplatene;dolehoty;polehote;do30dni;do60dni;do90dni;do180dni;do270dni;do365dni;nad365dni"."\r\n";
  fwrite($soubor, $text);

              }
if( $hlavicka->pox == 991 ) {

  $text = $hlavicka->uce.";".$hlavicka->ico.";".$hlavicka->nai." ".$hlavicka->mes.";";   fwrite($soubor, $text);
                            }

if( $hlavicka->pox == 993 ) {

  $text = "Spolu $hlavicka->uce;;;";   fwrite($soubor, $text);
                            }

if( $hlavicka->pox == 997 ) {

$uce3=substr($hlavicka->uce,0,3);

  $text = "Spolu $uce3;;;";   fwrite($soubor, $text);
                            }

if( $hlavicka->pox == 999 ) {

  $text = "Všetky úèty spolu;;;";   fwrite($soubor, $text);
                            }



  $text = $ezos.";".$edol.";".$epol.";";
  $text = $text.$epo1.";".$epo2.";".$epo3.";";
  $text = $text.$epo4.";".$epo5.";".$epo6.";";

  $text = $text.$epo7."\r\n";
  fwrite($soubor, $text);

//echo "riadok ".$i."<br />";

     }
//koniec vsetko=4

if( $vsetko == 5 )
     {
$hod=$hlavicka->hod;
$ehod=str_replace(".",",",$hod);
$uhr=$hlavicka->uhr;
$euhr=str_replace(".",",",$uhr);
$zos=$hlavicka->zos;
$ezos=str_replace(".",",",$zos);

if( $i == 0 )
{
  $text = "ucet;ico;nazov;mesto;doklad;vystavena;splatna;faktura;hodnota;uhradene;zostatok"."\r\n";
  fwrite($soubor, $text);
}

if( $hlavicka->pox != 999 )
{
  $text = $hlavicka->uce.";".$hlavicka->ico.";".$hlavicka->nai.";".$hlavicka->mes.";";
  $text = $text.$hlavicka->dok.";".$dat_sk.";".$das_sk.";".$hlavicka->fak.";";
  $text = $text.$ehod.";".$euhr.";".$ezos.";";
  $text = $text."\r\n";
  fwrite($soubor, $text);
}

if( $hlavicka->pox == 999 )
{
  $text = "spolu;;;;;;;;".$ehod.";".$euhr.";".$ezos."\r\n";
  fwrite($soubor, $text);
}


     }
//koniec vsetko=5

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


}
///////////////////////////////////////////////////KONIEC SUBORU PRE SALDO
?>

<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU VYKAZZISKOV
if( $copern == 20 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="vykaz_ziskov";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvykziss".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpocvziskov_stl".
" ON F$kli_vxcf"."_prcvykziss$kli_uzid.prx=F$kli_vxcf"."_uctpocvziskov_stl.fic".
" WHERE prx = 1 "."";


$sql = mysql_query("$sqltt");
if($sql)                                                      {
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$das_sk=SkDatum($hlavicka->das);
$dat_sk=SkDatum($hlavicka->dat);
$dau_sk=SkDatum($hlavicka->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk=$dau_sk;

$r01=$hlavicka->r01; $er01=str_replace(".",",",$r01); $rm01=$hlavicka->rm01; $erm01=str_replace(".",",",$rm01);
$r02=$hlavicka->r02; $er02=str_replace(".",",",$r02); $rm02=$hlavicka->rm02; $erm02=str_replace(".",",",$rm02);
$r03=$hlavicka->r03; $er03=str_replace(".",",",$r03); $rm03=$hlavicka->rm03; $erm03=str_replace(".",",",$rm03);
$r04=$hlavicka->r04; $er04=str_replace(".",",",$r04); $rm04=$hlavicka->rm04; $erm04=str_replace(".",",",$rm04);
$r05=$hlavicka->r05; $er05=str_replace(".",",",$r05); $rm05=$hlavicka->rm05; $erm05=str_replace(".",",",$rm05);
$r06=$hlavicka->r06; $er06=str_replace(".",",",$r06); $rm06=$hlavicka->rm06; $erm06=str_replace(".",",",$rm06);
$r07=$hlavicka->r07; $er07=str_replace(".",",",$r07); $rm07=$hlavicka->rm07; $erm07=str_replace(".",",",$rm07);
$r08=$hlavicka->r08; $er08=str_replace(".",",",$r08); $rm08=$hlavicka->rm08; $erm08=str_replace(".",",",$rm08);
$r09=$hlavicka->r09; $er09=str_replace(".",",",$r09); $rm09=$hlavicka->rm09; $erm09=str_replace(".",",",$rm09);

$r10=$hlavicka->r10; $er10=str_replace(".",",",$r10); $rm10=$hlavicka->rm10; $erm10=str_replace(".",",",$rm10);
$r11=$hlavicka->r11; $er11=str_replace(".",",",$r11); $rm11=$hlavicka->rm11; $erm11=str_replace(".",",",$rm11);
$r12=$hlavicka->r12; $er12=str_replace(".",",",$r12); $rm12=$hlavicka->rm12; $erm12=str_replace(".",",",$rm12);
$r13=$hlavicka->r13; $er13=str_replace(".",",",$r13); $rm13=$hlavicka->rm13; $erm13=str_replace(".",",",$rm13);
$r14=$hlavicka->r14; $er14=str_replace(".",",",$r14); $rm14=$hlavicka->rm14; $erm14=str_replace(".",",",$rm14);
$r15=$hlavicka->r15; $er15=str_replace(".",",",$r15); $rm15=$hlavicka->rm15; $erm15=str_replace(".",",",$rm15);
$r16=$hlavicka->r16; $er16=str_replace(".",",",$r16); $rm16=$hlavicka->rm16; $erm16=str_replace(".",",",$rm16);
$r17=$hlavicka->r17; $er17=str_replace(".",",",$r17); $rm17=$hlavicka->rm17; $erm17=str_replace(".",",",$rm17);
$r18=$hlavicka->r18; $er18=str_replace(".",",",$r18); $rm18=$hlavicka->rm18; $erm18=str_replace(".",",",$rm18);
$r19=$hlavicka->r19; $er19=str_replace(".",",",$r19); $rm19=$hlavicka->rm19; $erm19=str_replace(".",",",$rm19);

$r20=$hlavicka->r20; $er20=str_replace(".",",",$r20); $rm20=$hlavicka->rm20; $erm20=str_replace(".",",",$rm20);
$r21=$hlavicka->r21; $er21=str_replace(".",",",$r21); $rm21=$hlavicka->rm21; $erm21=str_replace(".",",",$rm21);
$r22=$hlavicka->r22; $er22=str_replace(".",",",$r22); $rm22=$hlavicka->rm22; $erm22=str_replace(".",",",$rm22);
$r23=$hlavicka->r23; $er23=str_replace(".",",",$r23); $rm23=$hlavicka->rm23; $erm23=str_replace(".",",",$rm23);
$r24=$hlavicka->r24; $er24=str_replace(".",",",$r24); $rm24=$hlavicka->rm24; $erm24=str_replace(".",",",$rm24);
$r25=$hlavicka->r25; $er25=str_replace(".",",",$r25); $rm25=$hlavicka->rm25; $erm25=str_replace(".",",",$rm25);
$r26=$hlavicka->r26; $er26=str_replace(".",",",$r26); $rm26=$hlavicka->rm26; $erm26=str_replace(".",",",$rm26);
$r27=$hlavicka->r27; $er27=str_replace(".",",",$r27); $rm27=$hlavicka->rm27; $erm27=str_replace(".",",",$rm27);
$r28=$hlavicka->r28; $er28=str_replace(".",",",$r28); $rm28=$hlavicka->rm28; $erm28=str_replace(".",",",$rm28);
$r29=$hlavicka->r29; $er29=str_replace(".",",",$r29); $rm29=$hlavicka->rm29; $erm29=str_replace(".",",",$rm29);

$r30=$hlavicka->r30; $er30=str_replace(".",",",$r30); $rm30=$hlavicka->rm30; $erm30=str_replace(".",",",$rm30);
$r31=$hlavicka->r31; $er31=str_replace(".",",",$r31); $rm31=$hlavicka->rm31; $erm31=str_replace(".",",",$rm31);
$r32=$hlavicka->r32; $er32=str_replace(".",",",$r32); $rm32=$hlavicka->rm32; $erm32=str_replace(".",",",$rm32);
$r33=$hlavicka->r33; $er33=str_replace(".",",",$r33); $rm33=$hlavicka->rm33; $erm33=str_replace(".",",",$rm33);
$r34=$hlavicka->r34; $er34=str_replace(".",",",$r34); $rm34=$hlavicka->rm34; $erm34=str_replace(".",",",$rm34);
$r35=$hlavicka->r35; $er35=str_replace(".",",",$r35); $rm35=$hlavicka->rm35; $erm35=str_replace(".",",",$rm35);
$r36=$hlavicka->r36; $er36=str_replace(".",",",$r36); $rm36=$hlavicka->rm36; $erm36=str_replace(".",",",$rm36);
$r37=$hlavicka->r37; $er37=str_replace(".",",",$r37); $rm37=$hlavicka->rm37; $erm37=str_replace(".",",",$rm37);
$r38=$hlavicka->r38; $er38=str_replace(".",",",$r38); $rm38=$hlavicka->rm38; $erm38=str_replace(".",",",$rm38);
$r39=$hlavicka->r39; $er39=str_replace(".",",",$r39); $rm39=$hlavicka->rm39; $erm39=str_replace(".",",",$rm39);

$r40=$hlavicka->r40; $er40=str_replace(".",",",$r40); $rm40=$hlavicka->rm40; $erm40=str_replace(".",",",$rm40);
$r41=$hlavicka->r41; $er41=str_replace(".",",",$r41); $rm41=$hlavicka->rm41; $erm41=str_replace(".",",",$rm41);
$r42=$hlavicka->r42; $er42=str_replace(".",",",$r42); $rm42=$hlavicka->rm42; $erm42=str_replace(".",",",$rm42);
$r43=$hlavicka->r43; $er43=str_replace(".",",",$r43); $rm43=$hlavicka->rm43; $erm43=str_replace(".",",",$rm43);
$r44=$hlavicka->r44; $er44=str_replace(".",",",$r44); $rm44=$hlavicka->rm44; $erm44=str_replace(".",",",$rm44);
$r45=$hlavicka->r45; $er45=str_replace(".",",",$r45); $rm45=$hlavicka->rm45; $erm45=str_replace(".",",",$rm45);
$r46=$hlavicka->r46; $er46=str_replace(".",",",$r46); $rm46=$hlavicka->rm46; $erm46=str_replace(".",",",$rm46);
$r47=$hlavicka->r47; $er47=str_replace(".",",",$r47); $rm47=$hlavicka->rm47; $erm47=str_replace(".",",",$rm47);
$r48=$hlavicka->r48; $er48=str_replace(".",",",$r48); $rm48=$hlavicka->rm48; $erm48=str_replace(".",",",$rm48);
$r49=$hlavicka->r49; $er49=str_replace(".",",",$r49); $rm49=$hlavicka->rm49; $erm49=str_replace(".",",",$rm49);

$r50=$hlavicka->r50; $er50=str_replace(".",",",$r50); $rm50=$hlavicka->rm50; $erm50=str_replace(".",",",$rm50);
$r51=$hlavicka->r51; $er51=str_replace(".",",",$r51); $rm51=$hlavicka->rm51; $erm51=str_replace(".",",",$rm51);
$r52=$hlavicka->r52; $er52=str_replace(".",",",$r52); $rm52=$hlavicka->rm52; $erm52=str_replace(".",",",$rm52);
$r53=$hlavicka->r53; $er53=str_replace(".",",",$r53); $rm53=$hlavicka->rm53; $erm53=str_replace(".",",",$rm53);
$r54=$hlavicka->r54; $er54=str_replace(".",",",$r54); $rm54=$hlavicka->rm54; $erm54=str_replace(".",",",$rm54);
$r55=$hlavicka->r55; $er55=str_replace(".",",",$r55); $rm55=$hlavicka->rm55; $erm55=str_replace(".",",",$rm55);
$r56=$hlavicka->r56; $er56=str_replace(".",",",$r56); $rm56=$hlavicka->rm56; $erm56=str_replace(".",",",$rm56);
$r57=$hlavicka->r57; $er57=str_replace(".",",",$r57); $rm57=$hlavicka->rm57; $erm57=str_replace(".",",",$rm57);
$r58=$hlavicka->r58; $er58=str_replace(".",",",$r58); $rm58=$hlavicka->rm58; $erm58=str_replace(".",",",$rm58);
$r59=$hlavicka->r59; $er59=str_replace(".",",",$r59); $rm59=$hlavicka->rm59; $erm59=str_replace(".",",",$rm59);

$r60=$hlavicka->r60; $er60=str_replace(".",",",$r60); $rm60=$hlavicka->rm60; $erm60=str_replace(".",",",$rm60);
$r61=$hlavicka->r61; $er61=str_replace(".",",",$r61); $rm61=$hlavicka->rm61; $erm61=str_replace(".",",",$rm61);
$r62=$hlavicka->r62; $er62=str_replace(".",",",$r62); $rm62=$hlavicka->rm62; $erm62=str_replace(".",",",$rm62);
$r63=$hlavicka->r63; $er63=str_replace(".",",",$r63); $rm63=$hlavicka->rm63; $erm63=str_replace(".",",",$rm63);
$r64=$hlavicka->r64; $er64=str_replace(".",",",$r64); $rm64=$hlavicka->rm64; $erm64=str_replace(".",",",$rm64);
$r65=$hlavicka->r65; $er65=str_replace(".",",",$r65); $rm65=$hlavicka->rm65; $erm65=str_replace(".",",",$rm65);
$r66=$hlavicka->r66; $er66=str_replace(".",",",$r66); $rm66=$hlavicka->rm66; $erm66=str_replace(".",",",$rm66);
$r67=$hlavicka->r67; $er67=str_replace(".",",",$r67); $rm67=$hlavicka->rm67; $erm67=str_replace(".",",",$rm67);
$r68=$hlavicka->r68; $er68=str_replace(".",",",$r68); $rm68=$hlavicka->rm68; $erm68=str_replace(".",",",$rm68);
$r69=$hlavicka->r69; $er69=str_replace(".",",",$r69); $rm69=$hlavicka->rm69; $erm69=str_replace(".",",",$rm69);

if( $i == 0 )
     {
  $text = "riadok".";"."bezne obdobie".";"."predch.obdobie"."\r\n"; 

  fwrite($soubor, $text);

     }

  $text = "01;".$er01.";".$erm01."\r\n"; $text = $text."02;".$er02.";".$erm02."\r\n"; $text = $text."03;".$er03.";".$erm03."\r\n";
  $text = $text."04;".$er04.";".$erm04."\r\n"; $text = $text."05;".$er05.";".$erm05."\r\n"; $text = $text."06;".$er06.";".$erm06."\r\n";
  $text = $text."07;".$er07.";".$erm07."\r\n"; $text = $text."08;".$er08.";".$erm08."\r\n"; $text = $text."09;".$er09.";".$erm09."\r\n";

  $text = $text."10;".$er10.";".$erm10."\r\n";  
  $text = $text."11;".$er11.";".$erm11."\r\n"; $text = $text."12;".$er12.";".$erm12."\r\n"; $text = $text."13;".$er13.";".$erm13."\r\n";
  $text = $text."14;".$er14.";".$erm14."\r\n"; $text = $text."15;".$er15.";".$erm15."\r\n"; $text = $text."16;".$er16.";".$erm16."\r\n";
  $text = $text."17;".$er17.";".$erm17."\r\n"; $text = $text."18;".$er18.";".$erm18."\r\n"; $text = $text."19;".$er19.";".$erm19."\r\n";

  $text = $text."20;".$er20.";".$erm20."\r\n"; 
  $text = $text."21;".$er21.";".$erm21."\r\n"; $text = $text."22;".$er22.";".$erm22."\r\n"; $text = $text."23;".$er23.";".$erm23."\r\n";
  $text = $text."24;".$er24.";".$erm24."\r\n"; $text = $text."25;".$er25.";".$erm25."\r\n"; $text = $text."26;".$er26.";".$erm26."\r\n";
  $text = $text."27;".$er27.";".$erm27."\r\n"; $text = $text."28;".$er28.";".$erm28."\r\n"; $text = $text."29;".$er29.";".$erm29."\r\n";

  $text = $text."30;".$er30.";".$erm30."\r\n";  
  $text = $text."31;".$er31.";".$erm31."\r\n"; $text = $text."32;".$er32.";".$erm32."\r\n"; $text = $text."33;".$er33.";".$erm33."\r\n";
  $text = $text."34;".$er34.";".$erm34."\r\n"; $text = $text."35;".$er35.";".$erm35."\r\n"; $text = $text."36;".$er36.";".$erm36."\r\n";
  $text = $text."37;".$er37.";".$erm37."\r\n"; $text = $text."38;".$er38.";".$erm38."\r\n"; $text = $text."39;".$er39.";".$erm39."\r\n";

  $text = $text."40;".$er40.";".$erm40."\r\n"; 
  $text = $text."41;".$er41.";".$erm41."\r\n"; $text = $text."42;".$er42.";".$erm42."\r\n"; $text = $text."43;".$er43.";".$erm43."\r\n";
  $text = $text."44;".$er44.";".$erm44."\r\n"; $text = $text."45;".$er45.";".$erm45."\r\n"; $text = $text."46;".$er46.";".$erm46."\r\n";
  $text = $text."47;".$er47.";".$erm47."\r\n"; $text = $text."48;".$er48.";".$erm48."\r\n"; $text = $text."49;".$er49.";".$erm49."\r\n";

  $text = $text."50;".$er50.";".$erm50."\r\n";  
  $text = $text."51;".$er51.";".$erm51."\r\n"; $text = $text."52;".$er52.";".$erm52."\r\n"; $text = $text."53;".$er53.";".$erm53."\r\n";
  $text = $text."54;".$er54.";".$erm54."\r\n"; $text = $text."55;".$er55.";".$erm55."\r\n"; $text = $text."56;".$er56.";".$erm56."\r\n";
  $text = $text."57;".$er57.";".$erm57."\r\n"; $text = $text."58;".$er58.";".$erm58."\r\n"; $text = $text."59;".$er59.";".$erm59."\r\n";
  $text = $text."60;".$er60.";".$erm60."\r\n";
  $text = $text."61;".$er61.";".$erm61."\r\n";
  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//koniec ak existuje suvor
                                                              }
}
///////////////////////////////////////////////////KONIEC SUBORU VYKAZZISKOV



///////////////////////////////////////////////////VYTVORENIE SUBORU SUVAHA
if( $copern == 30 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="suvaha";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuvahas".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpocsuvaha_stl".
" ON F$kli_vxcf"."_prcsuvahas$kli_uzid.prx=F$kli_vxcf"."_uctpocsuvaha_stl.fic".
" WHERE prx = 1 ".""; 


$sql = mysql_query("$sqltt");
if($sql)                                                      {
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$das_sk=SkDatum($hlavicka->das);
$dat_sk=SkDatum($hlavicka->dat);
$dau_sk=SkDatum($hlavicka->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk=$dau_sk;

$r01=$hlavicka->r01; $er01=str_replace(".",",",$r01); $rm01=$hlavicka->rm01; $erm01=str_replace(".",",",$rm01);
$r02=$hlavicka->r02; $er02=str_replace(".",",",$r02); $rm02=$hlavicka->rm02; $erm02=str_replace(".",",",$rm02);
$r03=$hlavicka->r03; $er03=str_replace(".",",",$r03); $rm03=$hlavicka->rm03; $erm03=str_replace(".",",",$rm03);
$r04=$hlavicka->r04; $er04=str_replace(".",",",$r04); $rm04=$hlavicka->rm04; $erm04=str_replace(".",",",$rm04);
$r05=$hlavicka->r05; $er05=str_replace(".",",",$r05); $rm05=$hlavicka->rm05; $erm05=str_replace(".",",",$rm05);
$r06=$hlavicka->r06; $er06=str_replace(".",",",$r06); $rm06=$hlavicka->rm06; $erm06=str_replace(".",",",$rm06);
$r07=$hlavicka->r07; $er07=str_replace(".",",",$r07); $rm07=$hlavicka->rm07; $erm07=str_replace(".",",",$rm07);
$r08=$hlavicka->r08; $er08=str_replace(".",",",$r08); $rm08=$hlavicka->rm08; $erm08=str_replace(".",",",$rm08);
$r09=$hlavicka->r09; $er09=str_replace(".",",",$r09); $rm09=$hlavicka->rm09; $erm09=str_replace(".",",",$rm09);

$r10=$hlavicka->r10; $er10=str_replace(".",",",$r10); $rm10=$hlavicka->rm10; $erm10=str_replace(".",",",$rm10);
$r11=$hlavicka->r11; $er11=str_replace(".",",",$r11); $rm11=$hlavicka->rm11; $erm11=str_replace(".",",",$rm11);
$r12=$hlavicka->r12; $er12=str_replace(".",",",$r12); $rm12=$hlavicka->rm12; $erm12=str_replace(".",",",$rm12);
$r13=$hlavicka->r13; $er13=str_replace(".",",",$r13); $rm13=$hlavicka->rm13; $erm13=str_replace(".",",",$rm13);
$r14=$hlavicka->r14; $er14=str_replace(".",",",$r14); $rm14=$hlavicka->rm14; $erm14=str_replace(".",",",$rm14);
$r15=$hlavicka->r15; $er15=str_replace(".",",",$r15); $rm15=$hlavicka->rm15; $erm15=str_replace(".",",",$rm15);
$r16=$hlavicka->r16; $er16=str_replace(".",",",$r16); $rm16=$hlavicka->rm16; $erm16=str_replace(".",",",$rm16);
$r17=$hlavicka->r17; $er17=str_replace(".",",",$r17); $rm17=$hlavicka->rm17; $erm17=str_replace(".",",",$rm17);
$r18=$hlavicka->r18; $er18=str_replace(".",",",$r18); $rm18=$hlavicka->rm18; $erm18=str_replace(".",",",$rm18);
$r19=$hlavicka->r19; $er19=str_replace(".",",",$r19); $rm19=$hlavicka->rm19; $erm19=str_replace(".",",",$rm19);

$r20=$hlavicka->r20; $er20=str_replace(".",",",$r20); $rm20=$hlavicka->rm20; $erm20=str_replace(".",",",$rm20);
$r21=$hlavicka->r21; $er21=str_replace(".",",",$r21); $rm21=$hlavicka->rm21; $erm21=str_replace(".",",",$rm21);
$r22=$hlavicka->r22; $er22=str_replace(".",",",$r22); $rm22=$hlavicka->rm22; $erm22=str_replace(".",",",$rm22);
$r23=$hlavicka->r23; $er23=str_replace(".",",",$r23); $rm23=$hlavicka->rm23; $erm23=str_replace(".",",",$rm23);
$r24=$hlavicka->r24; $er24=str_replace(".",",",$r24); $rm24=$hlavicka->rm24; $erm24=str_replace(".",",",$rm24);
$r25=$hlavicka->r25; $er25=str_replace(".",",",$r25); $rm25=$hlavicka->rm25; $erm25=str_replace(".",",",$rm25);
$r26=$hlavicka->r26; $er26=str_replace(".",",",$r26); $rm26=$hlavicka->rm26; $erm26=str_replace(".",",",$rm26);
$r27=$hlavicka->r27; $er27=str_replace(".",",",$r27); $rm27=$hlavicka->rm27; $erm27=str_replace(".",",",$rm27);
$r28=$hlavicka->r28; $er28=str_replace(".",",",$r28); $rm28=$hlavicka->rm28; $erm28=str_replace(".",",",$rm28);
$r29=$hlavicka->r29; $er29=str_replace(".",",",$r29); $rm29=$hlavicka->rm29; $erm29=str_replace(".",",",$rm29);

$r30=$hlavicka->r30; $er30=str_replace(".",",",$r30); $rm30=$hlavicka->rm30; $erm30=str_replace(".",",",$rm30);
$r31=$hlavicka->r31; $er31=str_replace(".",",",$r31); $rm31=$hlavicka->rm31; $erm31=str_replace(".",",",$rm31);
$r32=$hlavicka->r32; $er32=str_replace(".",",",$r32); $rm32=$hlavicka->rm32; $erm32=str_replace(".",",",$rm32);
$r33=$hlavicka->r33; $er33=str_replace(".",",",$r33); $rm33=$hlavicka->rm33; $erm33=str_replace(".",",",$rm33);
$r34=$hlavicka->r34; $er34=str_replace(".",",",$r34); $rm34=$hlavicka->rm34; $erm34=str_replace(".",",",$rm34);
$r35=$hlavicka->r35; $er35=str_replace(".",",",$r35); $rm35=$hlavicka->rm35; $erm35=str_replace(".",",",$rm35);
$r36=$hlavicka->r36; $er36=str_replace(".",",",$r36); $rm36=$hlavicka->rm36; $erm36=str_replace(".",",",$rm36);
$r37=$hlavicka->r37; $er37=str_replace(".",",",$r37); $rm37=$hlavicka->rm37; $erm37=str_replace(".",",",$rm37);
$r38=$hlavicka->r38; $er38=str_replace(".",",",$r38); $rm38=$hlavicka->rm38; $erm38=str_replace(".",",",$rm38);
$r39=$hlavicka->r39; $er39=str_replace(".",",",$r39); $rm39=$hlavicka->rm39; $erm39=str_replace(".",",",$rm39);

$r40=$hlavicka->r40; $er40=str_replace(".",",",$r40); $rm40=$hlavicka->rm40; $erm40=str_replace(".",",",$rm40);
$r41=$hlavicka->r41; $er41=str_replace(".",",",$r41); $rm41=$hlavicka->rm41; $erm41=str_replace(".",",",$rm41);
$r42=$hlavicka->r42; $er42=str_replace(".",",",$r42); $rm42=$hlavicka->rm42; $erm42=str_replace(".",",",$rm42);
$r43=$hlavicka->r43; $er43=str_replace(".",",",$r43); $rm43=$hlavicka->rm43; $erm43=str_replace(".",",",$rm43);
$r44=$hlavicka->r44; $er44=str_replace(".",",",$r44); $rm44=$hlavicka->rm44; $erm44=str_replace(".",",",$rm44);
$r45=$hlavicka->r45; $er45=str_replace(".",",",$r45); $rm45=$hlavicka->rm45; $erm45=str_replace(".",",",$rm45);
$r46=$hlavicka->r46; $er46=str_replace(".",",",$r46); $rm46=$hlavicka->rm46; $erm46=str_replace(".",",",$rm46);
$r47=$hlavicka->r47; $er47=str_replace(".",",",$r47); $rm47=$hlavicka->rm47; $erm47=str_replace(".",",",$rm47);
$r48=$hlavicka->r48; $er48=str_replace(".",",",$r48); $rm48=$hlavicka->rm48; $erm48=str_replace(".",",",$rm48);
$r49=$hlavicka->r49; $er49=str_replace(".",",",$r49); $rm49=$hlavicka->rm49; $erm49=str_replace(".",",",$rm49);

$r50=$hlavicka->r50; $er50=str_replace(".",",",$r50); $rm50=$hlavicka->rm50; $erm50=str_replace(".",",",$rm50);
$r51=$hlavicka->r51; $er51=str_replace(".",",",$r51); $rm51=$hlavicka->rm51; $erm51=str_replace(".",",",$rm51);
$r52=$hlavicka->r52; $er52=str_replace(".",",",$r52); $rm52=$hlavicka->rm52; $erm52=str_replace(".",",",$rm52);
$r53=$hlavicka->r53; $er53=str_replace(".",",",$r53); $rm53=$hlavicka->rm53; $erm53=str_replace(".",",",$rm53);
$r54=$hlavicka->r54; $er54=str_replace(".",",",$r54); $rm54=$hlavicka->rm54; $erm54=str_replace(".",",",$rm54);
$r55=$hlavicka->r55; $er55=str_replace(".",",",$r55); $rm55=$hlavicka->rm55; $erm55=str_replace(".",",",$rm55);
$r56=$hlavicka->r56; $er56=str_replace(".",",",$r56); $rm56=$hlavicka->rm56; $erm56=str_replace(".",",",$rm56);
$r57=$hlavicka->r57; $er57=str_replace(".",",",$r57); $rm57=$hlavicka->rm57; $erm57=str_replace(".",",",$rm57);
$r58=$hlavicka->r58; $er58=str_replace(".",",",$r58); $rm58=$hlavicka->rm58; $erm58=str_replace(".",",",$rm58);
$r59=$hlavicka->r59; $er59=str_replace(".",",",$r59); $rm59=$hlavicka->rm59; $erm59=str_replace(".",",",$rm59);

$r60=$hlavicka->r60; $er60=str_replace(".",",",$r60); $rm60=$hlavicka->rm60; $erm60=str_replace(".",",",$rm60);
$r61=$hlavicka->r61; $er61=str_replace(".",",",$r61); $rm61=$hlavicka->rm61; $erm61=str_replace(".",",",$rm61);
$r62=$hlavicka->r62; $er62=str_replace(".",",",$r62); $rm62=$hlavicka->rm62; $erm62=str_replace(".",",",$rm62);
$r63=$hlavicka->r63; $er63=str_replace(".",",",$r63); $rm63=$hlavicka->rm63; $erm63=str_replace(".",",",$rm63);
$r64=$hlavicka->r64; $er64=str_replace(".",",",$r64); $rm64=$hlavicka->rm64; $erm64=str_replace(".",",",$rm64);
$r65=$hlavicka->r65; $er65=str_replace(".",",",$r65); $rm65=$hlavicka->rm65; $erm65=str_replace(".",",",$rm65);
$r66=$hlavicka->r66; $er66=str_replace(".",",",$r66); $rm66=$hlavicka->rm66; $erm66=str_replace(".",",",$rm66);
$r67=$hlavicka->r67; $er67=str_replace(".",",",$r67); $rm67=$hlavicka->rm67; $erm67=str_replace(".",",",$rm67);
$r68=$hlavicka->r68; $er68=str_replace(".",",",$r68); $rm68=$hlavicka->rm68; $erm68=str_replace(".",",",$rm68);
$r69=$hlavicka->r69; $er69=str_replace(".",",",$r69); $rm69=$hlavicka->rm69; $erm69=str_replace(".",",",$rm69);

$r70=$hlavicka->r70; $er70=str_replace(".",",",$r70); $rm70=$hlavicka->rm70; $erm70=str_replace(".",",",$rm70);
$r71=$hlavicka->r71; $er71=str_replace(".",",",$r71); $rm71=$hlavicka->rm71; $erm71=str_replace(".",",",$rm71);
$r72=$hlavicka->r72; $er72=str_replace(".",",",$r72); $rm72=$hlavicka->rm72; $erm72=str_replace(".",",",$rm72);
$r73=$hlavicka->r73; $er73=str_replace(".",",",$r73); $rm73=$hlavicka->rm73; $erm73=str_replace(".",",",$rm73);
$r74=$hlavicka->r74; $er74=str_replace(".",",",$r74); $rm74=$hlavicka->rm74; $erm74=str_replace(".",",",$rm74);
$r75=$hlavicka->r75; $er75=str_replace(".",",",$r75); $rm75=$hlavicka->rm75; $erm75=str_replace(".",",",$rm75);
$r76=$hlavicka->r76; $er76=str_replace(".",",",$r76); $rm76=$hlavicka->rm76; $erm76=str_replace(".",",",$rm76);
$r77=$hlavicka->r77; $er77=str_replace(".",",",$r77); $rm77=$hlavicka->rm77; $erm77=str_replace(".",",",$rm77);
$r78=$hlavicka->r78; $er78=str_replace(".",",",$r78); $rm78=$hlavicka->rm78; $erm78=str_replace(".",",",$rm78);
$r79=$hlavicka->r79; $er79=str_replace(".",",",$r79); $rm79=$hlavicka->rm79; $erm79=str_replace(".",",",$rm79);

$r80=$hlavicka->r80; $er80=str_replace(".",",",$r80); $rm80=$hlavicka->rm80; $erm80=str_replace(".",",",$rm80);
$r81=$hlavicka->r81; $er81=str_replace(".",",",$r81); $rm81=$hlavicka->rm81; $erm81=str_replace(".",",",$rm81);
$r82=$hlavicka->r82; $er82=str_replace(".",",",$r82); $rm82=$hlavicka->rm82; $erm82=str_replace(".",",",$rm82);
$r83=$hlavicka->r83; $er83=str_replace(".",",",$r83); $rm83=$hlavicka->rm83; $erm83=str_replace(".",",",$rm83);
$r84=$hlavicka->r84; $er84=str_replace(".",",",$r84); $rm84=$hlavicka->rm84; $erm84=str_replace(".",",",$rm84);
$r85=$hlavicka->r85; $er85=str_replace(".",",",$r85); $rm85=$hlavicka->rm85; $erm85=str_replace(".",",",$rm85);
$r86=$hlavicka->r86; $er86=str_replace(".",",",$r86); $rm86=$hlavicka->rm86; $erm86=str_replace(".",",",$rm86);
$r87=$hlavicka->r87; $er87=str_replace(".",",",$r87); $rm87=$hlavicka->rm87; $erm87=str_replace(".",",",$rm87);
$r88=$hlavicka->r88; $er88=str_replace(".",",",$r88); $rm88=$hlavicka->rm88; $erm88=str_replace(".",",",$rm88);
$r89=$hlavicka->r89; $er89=str_replace(".",",",$r89); $rm89=$hlavicka->rm89; $erm89=str_replace(".",",",$rm89);

$r90=$hlavicka->r90; $er90=str_replace(".",",",$r90); $rm90=$hlavicka->rm90; $erm90=str_replace(".",",",$rm90);
$r91=$hlavicka->r91; $er91=str_replace(".",",",$r91); $rm91=$hlavicka->rm91; $erm91=str_replace(".",",",$rm91);
$r92=$hlavicka->r92; $er92=str_replace(".",",",$r92); $rm92=$hlavicka->rm92; $erm92=str_replace(".",",",$rm92);
$r93=$hlavicka->r93; $er93=str_replace(".",",",$r93); $rm93=$hlavicka->rm93; $erm93=str_replace(".",",",$rm93);
$r94=$hlavicka->r94; $er94=str_replace(".",",",$r94); $rm94=$hlavicka->rm94; $erm94=str_replace(".",",",$rm94);
$r95=$hlavicka->r95; $er95=str_replace(".",",",$r95); $rm95=$hlavicka->rm95; $erm95=str_replace(".",",",$rm95);
$r96=$hlavicka->r96; $er96=str_replace(".",",",$r96); $rm96=$hlavicka->rm96; $erm96=str_replace(".",",",$rm96);
$r97=$hlavicka->r97; $er97=str_replace(".",",",$r97); $rm97=$hlavicka->rm97; $erm97=str_replace(".",",",$rm97);
$r98=$hlavicka->r98; $er98=str_replace(".",",",$r98); $rm98=$hlavicka->rm98; $erm98=str_replace(".",",",$rm98);
$r99=$hlavicka->r99; $er99=str_replace(".",",",$r99); $rm99=$hlavicka->rm99; $erm99=str_replace(".",",",$rm99);

$r100=$hlavicka->r100; $er100=str_replace(".",",",$r100); $rm100=$hlavicka->rm100; $erm100=str_replace(".",",",$rm100);
$r101=$hlavicka->r101; $er101=str_replace(".",",",$r101); $rm101=$hlavicka->rm101; $erm101=str_replace(".",",",$rm101);
$r102=$hlavicka->r102; $er102=str_replace(".",",",$r102); $rm102=$hlavicka->rm102; $erm102=str_replace(".",",",$rm102);
$r103=$hlavicka->r103; $er103=str_replace(".",",",$r103); $rm103=$hlavicka->rm103; $erm103=str_replace(".",",",$rm103);
$r104=$hlavicka->r104; $er104=str_replace(".",",",$r104); $rm104=$hlavicka->rm104; $erm104=str_replace(".",",",$rm104);
$r105=$hlavicka->r105; $er105=str_replace(".",",",$r105); $rm105=$hlavicka->rm105; $erm105=str_replace(".",",",$rm105);
$r106=$hlavicka->r106; $er106=str_replace(".",",",$r106); $rm106=$hlavicka->rm106; $erm106=str_replace(".",",",$rm106);
$r107=$hlavicka->r107; $er107=str_replace(".",",",$r107); $rm107=$hlavicka->rm107; $erm107=str_replace(".",",",$rm107);
$r108=$hlavicka->r108; $er108=str_replace(".",",",$r108); $rm108=$hlavicka->rm108; $erm108=str_replace(".",",",$rm108);
$r109=$hlavicka->r109; $er109=str_replace(".",",",$r109); $rm109=$hlavicka->rm109; $erm109=str_replace(".",",",$rm109);

$r110=$hlavicka->r110; $er110=str_replace(".",",",$r110); $rm110=$hlavicka->rm110; $erm110=str_replace(".",",",$rm110);
$r111=$hlavicka->r111; $er111=str_replace(".",",",$r111); $rm111=$hlavicka->rm111; $erm111=str_replace(".",",",$rm111);
$r112=$hlavicka->r112; $er112=str_replace(".",",",$r112); $rm112=$hlavicka->rm112; $erm112=str_replace(".",",",$rm112);
$r113=$hlavicka->r113; $er113=str_replace(".",",",$r113); $rm113=$hlavicka->rm113; $erm113=str_replace(".",",",$rm113);
$r114=$hlavicka->r114; $er114=str_replace(".",",",$r114); $rm114=$hlavicka->rm114; $erm114=str_replace(".",",",$rm114);
$r115=$hlavicka->r115; $er115=str_replace(".",",",$r115); $rm115=$hlavicka->rm115; $erm115=str_replace(".",",",$rm115);
$r116=$hlavicka->r116; $er116=str_replace(".",",",$r116); $rm116=$hlavicka->rm116; $erm116=str_replace(".",",",$rm116);
$r117=$hlavicka->r117; $er117=str_replace(".",",",$r117); $rm117=$hlavicka->rm117; $erm117=str_replace(".",",",$rm117);
$r118=$hlavicka->r118; $er118=str_replace(".",",",$r118); $rm118=$hlavicka->rm118; $erm118=str_replace(".",",",$rm118);
$r119=$hlavicka->r119; $er119=str_replace(".",",",$r119); $rm119=$hlavicka->rm119; $erm119=str_replace(".",",",$rm119);

$r120=$hlavicka->r120; $er120=str_replace(".",",",$r120); $rm120=$hlavicka->rm120; $erm120=str_replace(".",",",$rm120);
$r121=$hlavicka->r121; $er121=str_replace(".",",",$r121); $rm121=$hlavicka->rm121; $erm121=str_replace(".",",",$rm121);
$r122=$hlavicka->r122; $er122=str_replace(".",",",$r122); $rm122=$hlavicka->rm122; $erm122=str_replace(".",",",$rm122);
$r123=$hlavicka->r123; $er123=str_replace(".",",",$r123); $rm123=$hlavicka->rm123; $erm123=str_replace(".",",",$rm123);
$r124=$hlavicka->r124; $er124=str_replace(".",",",$r124); $rm124=$hlavicka->rm124; $erm124=str_replace(".",",",$rm124);
$r125=$hlavicka->r125; $er125=str_replace(".",",",$r125); $rm125=$hlavicka->rm125; $erm125=str_replace(".",",",$rm125);
$r126=$hlavicka->r126; $er126=str_replace(".",",",$r126); $rm126=$hlavicka->rm126; $erm126=str_replace(".",",",$rm126);
$r127=$hlavicka->r127; $er127=str_replace(".",",",$r127); $rm127=$hlavicka->rm127; $erm127=str_replace(".",",",$rm127);
$r128=$hlavicka->r128; $er128=str_replace(".",",",$r128); $rm128=$hlavicka->rm128; $erm128=str_replace(".",",",$rm128);
$r129=$hlavicka->r129; $er129=str_replace(".",",",$r129); $rm129=$hlavicka->rm129; $erm129=str_replace(".",",",$rm129);

//rk a rn

$rk01=$hlavicka->rk01; $erk01=str_replace(".",",",$rk01); $rn01=$hlavicka->rn01; $ern01=str_replace(".",",",$rn01);
$rk02=$hlavicka->rk02; $erk02=str_replace(".",",",$rk02); $rn02=$hlavicka->rn02; $ern02=str_replace(".",",",$rn02);
$rk03=$hlavicka->rk03; $erk03=str_replace(".",",",$rk03); $rn03=$hlavicka->rn03; $ern03=str_replace(".",",",$rn03);
$rk04=$hlavicka->rk04; $erk04=str_replace(".",",",$rk04); $rn04=$hlavicka->rn04; $ern04=str_replace(".",",",$rn04);
$rk05=$hlavicka->rk05; $erk05=str_replace(".",",",$rk05); $rn05=$hlavicka->rn05; $ern05=str_replace(".",",",$rn05);
$rk06=$hlavicka->rk06; $erk06=str_replace(".",",",$rk06); $rn06=$hlavicka->rn06; $ern06=str_replace(".",",",$rn06);
$rk07=$hlavicka->rk07; $erk07=str_replace(".",",",$rk07); $rn07=$hlavicka->rn07; $ern07=str_replace(".",",",$rn07);
$rk08=$hlavicka->rk08; $erk08=str_replace(".",",",$rk08); $rn08=$hlavicka->rn08; $ern08=str_replace(".",",",$rn08);
$rk09=$hlavicka->rk09; $erk09=str_replace(".",",",$rk09); $rn09=$hlavicka->rn09; $ern09=str_replace(".",",",$rn09);

$rk10=$hlavicka->rk10; $erk10=str_replace(".",",",$rk10); $rn10=$hlavicka->rn10; $ern10=str_replace(".",",",$rn10);
$rk11=$hlavicka->rk11; $erk11=str_replace(".",",",$rk11); $rn11=$hlavicka->rn11; $ern11=str_replace(".",",",$rn11);
$rk12=$hlavicka->rk12; $erk12=str_replace(".",",",$rk12); $rn12=$hlavicka->rn12; $ern12=str_replace(".",",",$rn12);
$rk13=$hlavicka->rk13; $erk13=str_replace(".",",",$rk13); $rn13=$hlavicka->rn13; $ern13=str_replace(".",",",$rn13);
$rk14=$hlavicka->rk14; $erk14=str_replace(".",",",$rk14); $rn14=$hlavicka->rn14; $ern14=str_replace(".",",",$rn14);
$rk15=$hlavicka->rk15; $erk15=str_replace(".",",",$rk15); $rn15=$hlavicka->rn15; $ern15=str_replace(".",",",$rn15);
$rk16=$hlavicka->rk16; $erk16=str_replace(".",",",$rk16); $rn16=$hlavicka->rn16; $ern16=str_replace(".",",",$rn16);
$rk17=$hlavicka->rk17; $erk17=str_replace(".",",",$rk17); $rn17=$hlavicka->rn17; $ern17=str_replace(".",",",$rn17);
$rk18=$hlavicka->rk18; $erk18=str_replace(".",",",$rk18); $rn18=$hlavicka->rn18; $ern18=str_replace(".",",",$rn18);
$rk19=$hlavicka->rk19; $erk19=str_replace(".",",",$rk19); $rn19=$hlavicka->rn19; $ern19=str_replace(".",",",$rn19);

$rk20=$hlavicka->rk20; $erk20=str_replace(".",",",$rk20); $rn20=$hlavicka->rn20; $ern20=str_replace(".",",",$rn20);
$rk21=$hlavicka->rk21; $erk21=str_replace(".",",",$rk21); $rn21=$hlavicka->rn21; $ern21=str_replace(".",",",$rn21);
$rk22=$hlavicka->rk22; $erk22=str_replace(".",",",$rk22); $rn22=$hlavicka->rn22; $ern22=str_replace(".",",",$rn22);
$rk23=$hlavicka->rk23; $erk23=str_replace(".",",",$rk23); $rn23=$hlavicka->rn23; $ern23=str_replace(".",",",$rn23);
$rk24=$hlavicka->rk24; $erk24=str_replace(".",",",$rk24); $rn24=$hlavicka->rn24; $ern24=str_replace(".",",",$rn24);
$rk25=$hlavicka->rk25; $erk25=str_replace(".",",",$rk25); $rn25=$hlavicka->rn25; $ern25=str_replace(".",",",$rn25);
$rk26=$hlavicka->rk26; $erk26=str_replace(".",",",$rk26); $rn26=$hlavicka->rn26; $ern26=str_replace(".",",",$rn26);
$rk27=$hlavicka->rk27; $erk27=str_replace(".",",",$rk27); $rn27=$hlavicka->rn27; $ern27=str_replace(".",",",$rn27);
$rk28=$hlavicka->rk28; $erk28=str_replace(".",",",$rk28); $rn28=$hlavicka->rn28; $ern28=str_replace(".",",",$rn28);
$rk29=$hlavicka->rk29; $erk29=str_replace(".",",",$rk29); $rn29=$hlavicka->rn29; $ern29=str_replace(".",",",$rn29);

$rk30=$hlavicka->rk30; $erk30=str_replace(".",",",$rk30); $rn30=$hlavicka->rn30; $ern30=str_replace(".",",",$rn30);
$rk31=$hlavicka->rk31; $erk31=str_replace(".",",",$rk31); $rn31=$hlavicka->rn31; $ern31=str_replace(".",",",$rn31);
$rk32=$hlavicka->rk32; $erk32=str_replace(".",",",$rk32); $rn32=$hlavicka->rn32; $ern32=str_replace(".",",",$rn32);
$rk33=$hlavicka->rk33; $erk33=str_replace(".",",",$rk33); $rn33=$hlavicka->rn33; $ern33=str_replace(".",",",$rn33);
$rk34=$hlavicka->rk34; $erk34=str_replace(".",",",$rk34); $rn34=$hlavicka->rn34; $ern34=str_replace(".",",",$rn34);
$rk35=$hlavicka->rk35; $erk35=str_replace(".",",",$rk35); $rn35=$hlavicka->rn35; $ern35=str_replace(".",",",$rn35);
$rk36=$hlavicka->rk36; $erk36=str_replace(".",",",$rk36); $rn36=$hlavicka->rn36; $ern36=str_replace(".",",",$rn36);
$rk37=$hlavicka->rk37; $erk37=str_replace(".",",",$rk37); $rn37=$hlavicka->rn37; $ern37=str_replace(".",",",$rn37);
$rk38=$hlavicka->rk38; $erk38=str_replace(".",",",$rk38); $rn38=$hlavicka->rn38; $ern38=str_replace(".",",",$rn38);
$rk39=$hlavicka->rk39; $erk39=str_replace(".",",",$rk39); $rn39=$hlavicka->rn39; $ern39=str_replace(".",",",$rn39);

$rk40=$hlavicka->rk40; $erk40=str_replace(".",",",$rk40); $rn40=$hlavicka->rn40; $ern40=str_replace(".",",",$rn40);
$rk41=$hlavicka->rk41; $erk41=str_replace(".",",",$rk41); $rn41=$hlavicka->rn41; $ern41=str_replace(".",",",$rn41);
$rk42=$hlavicka->rk42; $erk42=str_replace(".",",",$rk42); $rn42=$hlavicka->rn42; $ern42=str_replace(".",",",$rn42);
$rk43=$hlavicka->rk43; $erk43=str_replace(".",",",$rk43); $rn43=$hlavicka->rn43; $ern43=str_replace(".",",",$rn43);
$rk44=$hlavicka->rk44; $erk44=str_replace(".",",",$rk44); $rn44=$hlavicka->rn44; $ern44=str_replace(".",",",$rn44);
$rk45=$hlavicka->rk45; $erk45=str_replace(".",",",$rk45); $rn45=$hlavicka->rn45; $ern45=str_replace(".",",",$rn45);
$rk46=$hlavicka->rk46; $erk46=str_replace(".",",",$rk46); $rn46=$hlavicka->rn46; $ern46=str_replace(".",",",$rn46);
$rk47=$hlavicka->rk47; $erk47=str_replace(".",",",$rk47); $rn47=$hlavicka->rn47; $ern47=str_replace(".",",",$rn47);
$rk48=$hlavicka->rk48; $erk48=str_replace(".",",",$rk48); $rn48=$hlavicka->rn48; $ern48=str_replace(".",",",$rn48);
$rk49=$hlavicka->rk49; $erk49=str_replace(".",",",$rk49); $rn49=$hlavicka->rn49; $ern49=str_replace(".",",",$rn49);

$rk50=$hlavicka->rk50; $erk50=str_replace(".",",",$rk50); $rn50=$hlavicka->rn50; $ern50=str_replace(".",",",$rn50);
$rk51=$hlavicka->rk51; $erk51=str_replace(".",",",$rk51); $rn51=$hlavicka->rn51; $ern51=str_replace(".",",",$rn51);
$rk52=$hlavicka->rk52; $erk52=str_replace(".",",",$rk52); $rn52=$hlavicka->rn52; $ern52=str_replace(".",",",$rn52);
$rk53=$hlavicka->rk53; $erk53=str_replace(".",",",$rk53); $rn53=$hlavicka->rn53; $ern53=str_replace(".",",",$rn53);
$rk54=$hlavicka->rk54; $erk54=str_replace(".",",",$rk54); $rn54=$hlavicka->rn54; $ern54=str_replace(".",",",$rn54);
$rk55=$hlavicka->rk55; $erk55=str_replace(".",",",$rk55); $rn55=$hlavicka->rn55; $ern55=str_replace(".",",",$rn55);
$rk56=$hlavicka->rk56; $erk56=str_replace(".",",",$rk56); $rn56=$hlavicka->rn56; $ern56=str_replace(".",",",$rn56);
$rk57=$hlavicka->rk57; $erk57=str_replace(".",",",$rk57); $rn57=$hlavicka->rn57; $ern57=str_replace(".",",",$rn57);
$rk58=$hlavicka->rk58; $erk58=str_replace(".",",",$rk58); $rn58=$hlavicka->rn58; $ern58=str_replace(".",",",$rn58);
$rk59=$hlavicka->rk59; $erk59=str_replace(".",",",$rk59); $rn59=$hlavicka->rn59; $ern59=str_replace(".",",",$rn59);

$rk60=$hlavicka->rk60; $erk60=str_replace(".",",",$rk60); $rn60=$hlavicka->rn60; $ern60=str_replace(".",",",$rn60);
$rk61=$hlavicka->rk61; $erk61=str_replace(".",",",$rk61); $rn61=$hlavicka->rn61; $ern61=str_replace(".",",",$rn61);
$rk62=$hlavicka->rk62; $erk62=str_replace(".",",",$rk62); $rn62=$hlavicka->rn62; $ern62=str_replace(".",",",$rn62);
$rk63=$hlavicka->rk63; $erk63=str_replace(".",",",$rk63); $rn63=$hlavicka->rn63; $ern63=str_replace(".",",",$rn63);
$rk64=$hlavicka->rk64; $erk64=str_replace(".",",",$rk64); $rn64=$hlavicka->rn64; $ern64=str_replace(".",",",$rn64);
$rk65=$hlavicka->rk65; $erk65=str_replace(".",",",$rk65); $rn65=$hlavicka->rn65; $ern65=str_replace(".",",",$rn65);
$rk66=$hlavicka->rk66; $erk66=str_replace(".",",",$rk66); $rn66=$hlavicka->rn66; $ern66=str_replace(".",",",$rn66);
$rk67=$hlavicka->rk67; $erk67=str_replace(".",",",$rk67); $rn67=$hlavicka->rn67; $ern67=str_replace(".",",",$rn67);
$rk68=$hlavicka->rk68; $erk68=str_replace(".",",",$rk68); $rn68=$hlavicka->rn68; $ern68=str_replace(".",",",$rn68);
$rk69=$hlavicka->rk69; $erk69=str_replace(".",",",$rk69); $rn69=$hlavicka->rn69; $ern69=str_replace(".",",",$rn69);

$rk70=$hlavicka->rk70; $erk70=str_replace(".",",",$rk70); $rn70=$hlavicka->rn70; $ern70=str_replace(".",",",$rn70);
$rk71=$hlavicka->rk71; $erk71=str_replace(".",",",$rk71); $rn71=$hlavicka->rn71; $ern71=str_replace(".",",",$rn71);
$rk72=$hlavicka->rk72; $erk72=str_replace(".",",",$rk72); $rn72=$hlavicka->rn72; $ern72=str_replace(".",",",$rn72);
$rk73=$hlavicka->rk73; $erk73=str_replace(".",",",$rk73); $rn73=$hlavicka->rn73; $ern73=str_replace(".",",",$rn73);
$rk74=$hlavicka->rk74; $erk74=str_replace(".",",",$rk74); $rn74=$hlavicka->rn74; $ern74=str_replace(".",",",$rn74);
$rk75=$hlavicka->rk75; $erk75=str_replace(".",",",$rk75); $rn75=$hlavicka->rn75; $ern75=str_replace(".",",",$rn75);
$rk76=$hlavicka->rk76; $erk76=str_replace(".",",",$rk76); $rn76=$hlavicka->rn76; $ern76=str_replace(".",",",$rn76);
$rk77=$hlavicka->rk77; $erk77=str_replace(".",",",$rk77); $rn77=$hlavicka->rn77; $ern77=str_replace(".",",",$rn77);
$rk78=$hlavicka->rk78; $erk78=str_replace(".",",",$rk78); $rn78=$hlavicka->rn78; $ern78=str_replace(".",",",$rn78);
$rk79=$hlavicka->rk79; $erk79=str_replace(".",",",$rk79); $rn79=$hlavicka->rn79; $ern79=str_replace(".",",",$rn79);

$rk80=$hlavicka->rk80; $erk80=str_replace(".",",",$rk80); $rn80=$hlavicka->rn80; $ern80=str_replace(".",",",$rn80);
$rk81=$hlavicka->rk81; $erk81=str_replace(".",",",$rk81); $rn81=$hlavicka->rn81; $ern81=str_replace(".",",",$rn81);
$rk82=$hlavicka->rk82; $erk82=str_replace(".",",",$rk82); $rn82=$hlavicka->rn82; $ern82=str_replace(".",",",$rn82);
$rk83=$hlavicka->rk83; $erk83=str_replace(".",",",$rk83); $rn83=$hlavicka->rn83; $ern83=str_replace(".",",",$rn83);
$rk84=$hlavicka->rk84; $erk84=str_replace(".",",",$rk84); $rn84=$hlavicka->rn84; $ern84=str_replace(".",",",$rn84);
$rk85=$hlavicka->rk85; $erk85=str_replace(".",",",$rk85); $rn85=$hlavicka->rn85; $ern85=str_replace(".",",",$rn85);
$rk86=$hlavicka->rk86; $erk86=str_replace(".",",",$rk86); $rn86=$hlavicka->rn86; $ern86=str_replace(".",",",$rn86);
$rk87=$hlavicka->rk87; $erk87=str_replace(".",",",$rk87); $rn87=$hlavicka->rn87; $ern87=str_replace(".",",",$rn87);
$rk88=$hlavicka->rk88; $erk88=str_replace(".",",",$rk88); $rn88=$hlavicka->rn88; $ern88=str_replace(".",",",$rn88);
$rk89=$hlavicka->rk89; $erk89=str_replace(".",",",$rk89); $rn89=$hlavicka->rn89; $ern89=str_replace(".",",",$rn89);

$rk90=$hlavicka->rk90; $erk90=str_replace(".",",",$rk90); $rn90=$hlavicka->rn90; $ern90=str_replace(".",",",$rn90);
$rk91=$hlavicka->rk91; $erk91=str_replace(".",",",$rk91); $rn91=$hlavicka->rn91; $ern91=str_replace(".",",",$rn91);
$rk92=$hlavicka->rk92; $erk92=str_replace(".",",",$rk92); $rn92=$hlavicka->rn92; $ern92=str_replace(".",",",$rn92);
$rk93=$hlavicka->rk93; $erk93=str_replace(".",",",$rk93); $rn93=$hlavicka->rn93; $ern93=str_replace(".",",",$rn93);
$rk94=$hlavicka->rk94; $erk94=str_replace(".",",",$rk94); $rn94=$hlavicka->rn94; $ern94=str_replace(".",",",$rn94);
$rk95=$hlavicka->rk95; $erk95=str_replace(".",",",$rk95); $rn95=$hlavicka->rn95; $ern95=str_replace(".",",",$rn95);
$rk96=$hlavicka->rk96; $erk96=str_replace(".",",",$rk96); $rn96=$hlavicka->rn96; $ern96=str_replace(".",",",$rn96);
$rk97=$hlavicka->rk97; $erk97=str_replace(".",",",$rk97); $rn97=$hlavicka->rn97; $ern97=str_replace(".",",",$rn97);
$rk98=$hlavicka->rk98; $erk98=str_replace(".",",",$rk98); $rn98=$hlavicka->rn98; $ern98=str_replace(".",",",$rn98);
$rk99=$hlavicka->rk99; $erk99=str_replace(".",",",$rk99); $rn99=$hlavicka->rn99; $ern99=str_replace(".",",",$rn99);

$rk100=$hlavicka->rk100; $erk100=str_replace(".",",",$rk100); $rn100=$hlavicka->rn100; $ern100=str_replace(".",",",$rn100);
$rk101=$hlavicka->rk101; $erk101=str_replace(".",",",$rk101); $rn101=$hlavicka->rn101; $ern101=str_replace(".",",",$rn101);
$rk102=$hlavicka->rk102; $erk102=str_replace(".",",",$rk102); $rn102=$hlavicka->rn102; $ern102=str_replace(".",",",$rn102);
$rk103=$hlavicka->rk103; $erk103=str_replace(".",",",$rk103); $rn103=$hlavicka->rn103; $ern103=str_replace(".",",",$rn103);
$rk104=$hlavicka->rk104; $erk104=str_replace(".",",",$rk104); $rn104=$hlavicka->rn104; $ern104=str_replace(".",",",$rn104);
$rk105=$hlavicka->rk105; $erk105=str_replace(".",",",$rk105); $rn105=$hlavicka->rn105; $ern105=str_replace(".",",",$rn105);
$rk106=$hlavicka->rk106; $erk106=str_replace(".",",",$rk106); $rn106=$hlavicka->rn106; $ern106=str_replace(".",",",$rn106);
$rk107=$hlavicka->rk107; $erk107=str_replace(".",",",$rk107); $rn107=$hlavicka->rn107; $ern107=str_replace(".",",",$rn107);
$rk108=$hlavicka->rk108; $erk108=str_replace(".",",",$rk108); $rn108=$hlavicka->rn108; $ern108=str_replace(".",",",$rn108);
$rk109=$hlavicka->rk109; $erk109=str_replace(".",",",$rk109); $rn109=$hlavicka->rn109; $ern109=str_replace(".",",",$rn109);

$rk110=$hlavicka->rk110; $erk110=str_replace(".",",",$rk110); $rn110=$hlavicka->rn110; $ern110=str_replace(".",",",$rn110);
$rk111=$hlavicka->rk111; $erk111=str_replace(".",",",$rk111); $rn111=$hlavicka->rn111; $ern111=str_replace(".",",",$rn111);
$rk112=$hlavicka->rk112; $erk112=str_replace(".",",",$rk112); $rn112=$hlavicka->rn112; $ern112=str_replace(".",",",$rn112);
$rk113=$hlavicka->rk113; $erk113=str_replace(".",",",$rk113); $rn113=$hlavicka->rn113; $ern113=str_replace(".",",",$rn113);
$rk114=$hlavicka->rk114; $erk114=str_replace(".",",",$rk114); $rn114=$hlavicka->rn114; $ern114=str_replace(".",",",$rn114);
$rk115=$hlavicka->rk115; $erk115=str_replace(".",",",$rk115); $rn115=$hlavicka->rn115; $ern115=str_replace(".",",",$rn115);
$rk116=$hlavicka->rk116; $erk116=str_replace(".",",",$rk116); $rn116=$hlavicka->rn116; $ern116=str_replace(".",",",$rn116);
$rk117=$hlavicka->rk117; $erk117=str_replace(".",",",$rk117); $rn117=$hlavicka->rn117; $ern117=str_replace(".",",",$rn117);
$rk118=$hlavicka->rk118; $erk118=str_replace(".",",",$rk118); $rn118=$hlavicka->rn118; $ern118=str_replace(".",",",$rn118);
$rk119=$hlavicka->rk119; $erk119=str_replace(".",",",$rk119); $rn119=$hlavicka->rn119; $ern119=str_replace(".",",",$rn119);

$rk120=$hlavicka->rk120; $erk120=str_replace(".",",",$rk120); $rn120=$hlavicka->rn120; $ern120=str_replace(".",",",$rn120);
$rk121=$hlavicka->rk121; $erk121=str_replace(".",",",$rk121); $rn121=$hlavicka->rn121; $ern121=str_replace(".",",",$rn121);
$rk122=$hlavicka->rk122; $erk122=str_replace(".",",",$rk122); $rn122=$hlavicka->rn122; $ern122=str_replace(".",",",$rn122);
$rk123=$hlavicka->rk123; $erk123=str_replace(".",",",$rk123); $rn123=$hlavicka->rn123; $ern123=str_replace(".",",",$rn123);
$rk124=$hlavicka->rk124; $erk124=str_replace(".",",",$rk124); $rn124=$hlavicka->rn124; $ern124=str_replace(".",",",$rn124);
$rk125=$hlavicka->rk125; $erk125=str_replace(".",",",$rk125); $rn125=$hlavicka->rn125; $ern125=str_replace(".",",",$rn125);
$rk126=$hlavicka->rk126; $erk126=str_replace(".",",",$rk126); $rn126=$hlavicka->rn126; $ern126=str_replace(".",",",$rn126);
$rk127=$hlavicka->rk127; $erk127=str_replace(".",",",$rk127); $rn127=$hlavicka->rn127; $ern127=str_replace(".",",",$rn127);
$rk128=$hlavicka->rk128; $erk128=str_replace(".",",",$rk128); $rn128=$hlavicka->rn128; $ern128=str_replace(".",",",$rn128);
$rk129=$hlavicka->rk129; $erk129=str_replace(".",",",$rk129); $rn129=$hlavicka->rn129; $ern129=str_replace(".",",",$rn129);

if( $i == 0 )
     {
  $text = "riadok".";"."brutto".";"."korekcia".";"."netto".";"."predch.obdobie"."\r\n"; 

  fwrite($soubor, $text);

     }

  $text = "01;".$er01.";".$erk01.";".$ern01.";".$erm01."\r\n"; 
  $text = $text."02;".$er02.";".$erk02.";".$ern02.";".$erm02."\r\n"; 
  $text = $text."03;".$er03.";".$erk03.";".$ern03.";".$erm03."\r\n"; 
  $text = $text."04;".$er04.";".$erk04.";".$ern04.";".$erm04."\r\n"; 
  $text = $text."05;".$er05.";".$erk05.";".$ern05.";".$erm05."\r\n"; 
  $text = $text."06;".$er06.";".$erk06.";".$ern06.";".$erm06."\r\n"; 
  $text = $text."07;".$er07.";".$erk07.";".$ern07.";".$erm07."\r\n"; 
  $text = $text."08;".$er08.";".$erk08.";".$ern08.";".$erm08."\r\n"; 
  $text = $text."09;".$er09.";".$erk09.";".$ern09.";".$erm09."\r\n"; 

  $text = $text."10;".$er10.";".$erk10.";".$ern10.";".$erm10."\r\n"; 
  $text = $text."11;".$er11.";".$erk11.";".$ern11.";".$erm11."\r\n"; 
  $text = $text."12;".$er12.";".$erk12.";".$ern12.";".$erm12."\r\n"; 
  $text = $text."13;".$er13.";".$erk13.";".$ern13.";".$erm13."\r\n"; 
  $text = $text."14;".$er14.";".$erk14.";".$ern14.";".$erm14."\r\n"; 
  $text = $text."15;".$er15.";".$erk15.";".$ern15.";".$erm15."\r\n"; 
  $text = $text."16;".$er16.";".$erk16.";".$ern16.";".$erm16."\r\n"; 
  $text = $text."17;".$er17.";".$erk17.";".$ern17.";".$erm17."\r\n"; 
  $text = $text."18;".$er18.";".$erk18.";".$ern18.";".$erm18."\r\n"; 
  $text = $text."19;".$er19.";".$erk19.";".$ern19.";".$erm19."\r\n"; 

  $text = $text."20;".$er20.";".$erk20.";".$ern20.";".$erm20."\r\n"; 
  $text = $text."21;".$er21.";".$erk21.";".$ern21.";".$erm21."\r\n"; 
  $text = $text."22;".$er22.";".$erk22.";".$ern22.";".$erm22."\r\n"; 
  $text = $text."23;".$er23.";".$erk23.";".$ern23.";".$erm23."\r\n"; 
  $text = $text."24;".$er24.";".$erk24.";".$ern24.";".$erm24."\r\n"; 
  $text = $text."25;".$er25.";".$erk25.";".$ern25.";".$erm25."\r\n"; 
  $text = $text."26;".$er26.";".$erk26.";".$ern26.";".$erm26."\r\n"; 
  $text = $text."27;".$er27.";".$erk27.";".$ern27.";".$erm27."\r\n"; 
  $text = $text."28;".$er28.";".$erk28.";".$ern28.";".$erm28."\r\n"; 
  $text = $text."29;".$er29.";".$erk29.";".$ern29.";".$erm29."\r\n"; 

  $text = $text."30;".$er30.";".$erk30.";".$ern30.";".$erm30."\r\n"; 
  $text = $text."31;".$er31.";".$erk31.";".$ern31.";".$erm31."\r\n"; 
  $text = $text."32;".$er32.";".$erk32.";".$ern32.";".$erm32."\r\n"; 
  $text = $text."33;".$er33.";".$erk33.";".$ern33.";".$erm33."\r\n"; 
  $text = $text."34;".$er34.";".$erk34.";".$ern34.";".$erm34."\r\n"; 
  $text = $text."35;".$er35.";".$erk35.";".$ern35.";".$erm35."\r\n"; 
  $text = $text."36;".$er36.";".$erk36.";".$ern36.";".$erm36."\r\n"; 
  $text = $text."37;".$er37.";".$erk37.";".$ern37.";".$erm37."\r\n"; 
  $text = $text."38;".$er38.";".$erk38.";".$ern38.";".$erm38."\r\n"; 
  $text = $text."39;".$er39.";".$erk39.";".$ern39.";".$erm39."\r\n"; 

  $text = $text."40;".$er40.";".$erk40.";".$ern40.";".$erm40."\r\n"; 
  $text = $text."41;".$er41.";".$erk41.";".$ern41.";".$erm41."\r\n"; 
  $text = $text."42;".$er42.";".$erk42.";".$ern42.";".$erm42."\r\n"; 
  $text = $text."43;".$er43.";".$erk43.";".$ern43.";".$erm43."\r\n"; 
  $text = $text."44;".$er44.";".$erk44.";".$ern44.";".$erm44."\r\n"; 
  $text = $text."45;".$er45.";".$erk45.";".$ern45.";".$erm45."\r\n"; 
  $text = $text."46;".$er46.";".$erk46.";".$ern46.";".$erm46."\r\n"; 
  $text = $text."47;".$er47.";".$erk47.";".$ern47.";".$erm47."\r\n"; 
  $text = $text."48;".$er48.";".$erk48.";".$ern48.";".$erm48."\r\n"; 
  $text = $text."49;".$er49.";".$erk49.";".$ern49.";".$erm49."\r\n"; 

  $text = $text."50;".$er50.";".$erk50.";".$ern50.";".$erm50."\r\n"; 
  $text = $text."51;".$er51.";".$erk51.";".$ern51.";".$erm51."\r\n"; 
  $text = $text."52;".$er52.";".$erk52.";".$ern52.";".$erm52."\r\n"; 
  $text = $text."53;".$er53.";".$erk53.";".$ern53.";".$erm53."\r\n"; 
  $text = $text."54;".$er54.";".$erk54.";".$ern54.";".$erm54."\r\n"; 
  $text = $text."55;".$er55.";".$erk55.";".$ern55.";".$erm55."\r\n"; 
  $text = $text."56;".$er56.";".$erk56.";".$ern56.";".$erm56."\r\n"; 
  $text = $text."57;".$er57.";".$erk57.";".$ern57.";".$erm57."\r\n"; 
  $text = $text."58;".$er58.";".$erk58.";".$ern58.";".$erm58."\r\n"; 
  $text = $text."59;".$er59.";".$erk59.";".$ern59.";".$erm59."\r\n"; 

  $text = $text."60;".$er60.";".$erk60.";".$ern60.";".$erm60."\r\n"; 
  $text = $text."61;".$er61.";".$erk61.";".$ern61.";".$erm61."\r\n"; 
  $text = $text."62;".$er62.";".$erk62.";".$ern62.";".$erm62."\r\n"; 
  $text = $text."63;".$er63.";".$erk63.";".$ern63.";".$erm63."\r\n"; 
  $text = $text."64;".$er64.";".$erk64.";".$ern64.";".$erm64."\r\n"; 
  $text = $text."65;".$er65.";".$erk65.";".$ern65.";".$erm65."\r\n"; 
  $text = $text."66;".$er66.";".$erk66.";".$ern66.";".$erm66."\r\n"; 
  $text = $text."67;".$er67.";".$erk67.";".$ern67.";".$erm67."\r\n"; 
  $text = $text."68;".$er68.";".$erk68.";".$ern68.";".$erm68."\r\n"; 
  $text = $text."69;".$er69.";".$erk69.";".$ern69.";".$erm69."\r\n"; 

  $text = $text."70;".$er70.";".$erk70.";".$ern70.";".$erm70."\r\n"; 
  $text = $text."71;".$er71.";".$erk71.";".$ern71.";".$erm71."\r\n"; 
  $text = $text."72;".$er72.";".$erk72.";".$ern72.";".$erm72."\r\n"; 
  $text = $text."73;".$er73.";".$erk73.";".$ern73.";".$erm73."\r\n"; 
  $text = $text."74;".$er74.";".$erk74.";".$ern74.";".$erm74."\r\n"; 
  $text = $text."75;".$er75.";".$erk75.";".$ern75.";".$erm75."\r\n"; 
  $text = $text."76;".$er76.";".$erk76.";".$ern76.";".$erm76."\r\n"; 
  $text = $text."77;".$er77.";".$erk77.";".$ern77.";".$erm77."\r\n"; 
  $text = $text."78;".$er78.";".$erk78.";".$ern78.";".$erm78."\r\n"; 
  $text = $text."79;".$er79.";".$erk79.";".$ern79.";".$erm79."\r\n"; 

  $text = $text."80;".$er80.";".$erk80.";".$ern80.";".$erm80."\r\n"; 
  $text = $text."81;".$er81.";".$erk81.";".$ern81.";".$erm81."\r\n"; 
  $text = $text."82;".$er82.";".$erk82.";".$ern82.";".$erm82."\r\n"; 
  $text = $text."83;".$er83.";".$erk83.";".$ern83.";".$erm83."\r\n"; 
  $text = $text."84;".$er84.";".$erk84.";".$ern84.";".$erm84."\r\n"; 
  $text = $text."85;".$er85.";".$erk85.";".$ern85.";".$erm85."\r\n"; 
  $text = $text."86;".$er86.";".$erk86.";".$ern86.";".$erm86."\r\n"; 
  $text = $text."87;".$er87.";".$erk87.";".$ern87.";".$erm87."\r\n"; 
  $text = $text."88;".$er88.";".$erk88.";".$ern88.";".$erm88."\r\n"; 
  $text = $text."89;".$er89.";".$erk89.";".$ern89.";".$erm89."\r\n"; 

  $text = $text."90;".$er90.";".$erk90.";".$ern90.";".$erm90."\r\n"; 
  $text = $text."91;".$er91.";".$erk91.";".$ern91.";".$erm91."\r\n"; 
  $text = $text."92;".$er92.";".$erk92.";".$ern92.";".$erm92."\r\n"; 
  $text = $text."93;".$er93.";".$erk93.";".$ern93.";".$erm93."\r\n"; 
  $text = $text."94;".$er94.";".$erk94.";".$ern94.";".$erm94."\r\n"; 
  $text = $text."95;".$er95.";".$erk95.";".$ern95.";".$erm95."\r\n"; 
  $text = $text."96;".$er96.";".$erk96.";".$ern96.";".$erm96."\r\n"; 
  $text = $text."97;".$er97.";".$erk97.";".$ern97.";".$erm97."\r\n"; 
  $text = $text."98;".$er98.";".$erk98.";".$ern98.";".$erm98."\r\n"; 
  $text = $text."99;".$er99.";".$erk99.";".$ern99.";".$erm99."\r\n"; 

  $text = $text."100;".$er100.";".$erk100.";".$ern100.";".$erm100."\r\n"; 
  $text = $text."101;".$er101.";".$erk101.";".$ern101.";".$erm101."\r\n"; 
  $text = $text."102;".$er102.";".$erk102.";".$ern102.";".$erm102."\r\n"; 
  $text = $text."103;".$er103.";".$erk103.";".$ern103.";".$erm103."\r\n"; 
  $text = $text."104;".$er104.";".$erk104.";".$ern104.";".$erm104."\r\n"; 
  $text = $text."105;".$er105.";".$erk105.";".$ern105.";".$erm105."\r\n"; 
  $text = $text."106;".$er106.";".$erk106.";".$ern106.";".$erm106."\r\n"; 
  $text = $text."107;".$er107.";".$erk107.";".$ern107.";".$erm107."\r\n"; 
  $text = $text."108;".$er108.";".$erk108.";".$ern108.";".$erm108."\r\n"; 
  $text = $text."109;".$er109.";".$erk109.";".$ern109.";".$erm109."\r\n"; 

  $text = $text."110;".$er110.";".$erk110.";".$ern110.";".$erm110."\r\n"; 
  $text = $text."111;".$er111.";".$erk111.";".$ern111.";".$erm111."\r\n"; 
  $text = $text."112;".$er112.";".$erk112.";".$ern112.";".$erm112."\r\n"; 
  $text = $text."113;".$er113.";".$erk113.";".$ern113.";".$erm113."\r\n"; 
  $text = $text."114;".$er114.";".$erk114.";".$ern114.";".$erm114."\r\n"; 
  $text = $text."115;".$er115.";".$erk115.";".$ern115.";".$erm115."\r\n"; 
  $text = $text."116;".$er116.";".$erk116.";".$ern116.";".$erm116."\r\n"; 
  $text = $text."117;".$er117.";".$erk117.";".$ern117.";".$erm117."\r\n"; 
  $text = $text."118;".$er118.";".$erk118.";".$ern118.";".$erm118."\r\n"; 
  $text = $text."119;".$er119.";".$erk119.";".$ern119.";".$erm119."\r\n"; 

  $text = $text."120;".$er120.";".$erk120.";".$ern120.";".$erm120."\r\n"; 
  $text = $text."121;".$er121.";".$erk121.";".$ern121.";".$erm121."\r\n"; 
  $text = $text."122;".$er122.";".$erk122.";".$ern122.";".$erm122."\r\n"; 
  $text = $text."123;".$er123.";".$erk123.";".$ern123.";".$erm123."\r\n"; 
  $text = $text."124;".$er124.";".$erk124.";".$ern124.";".$erm124."\r\n"; 
  $text = $text."125;".$er125.";".$erk125.";".$ern125.";".$erm125."\r\n"; 

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//koniec ak existuje suvor
                                                              }
}
///////////////////////////////////////////////////KONIEC SUBORU SUVAHA
?>



<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU VYKAZZISKOV NO
if( $copern == 120 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="vykaz_ziskov_no";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvykziss".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpocvziskovno_stl".
" ON F$kli_vxcf"."_prcvykziss$kli_uzid.prx=F$kli_vxcf"."_uctpocvziskovno_stl.fic".
" WHERE prx = 1 "."";

$sql = mysql_query("$sqltt");
if($sql)                                                      {
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$das_sk=SkDatum($hlavicka->das);
$dat_sk=SkDatum($hlavicka->dat);
$dau_sk=SkDatum($hlavicka->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk=$dau_sk;

$r01=$hlavicka->r01; $er01=str_replace(".",",",$r01); $rm01=$hlavicka->rm01; $erm01=str_replace(".",",",$rm01);
$r02=$hlavicka->r02; $er02=str_replace(".",",",$r02); $rm02=$hlavicka->rm02; $erm02=str_replace(".",",",$rm02);
$r03=$hlavicka->r03; $er03=str_replace(".",",",$r03); $rm03=$hlavicka->rm03; $erm03=str_replace(".",",",$rm03);
$r04=$hlavicka->r04; $er04=str_replace(".",",",$r04); $rm04=$hlavicka->rm04; $erm04=str_replace(".",",",$rm04);
$r05=$hlavicka->r05; $er05=str_replace(".",",",$r05); $rm05=$hlavicka->rm05; $erm05=str_replace(".",",",$rm05);
$r06=$hlavicka->r06; $er06=str_replace(".",",",$r06); $rm06=$hlavicka->rm06; $erm06=str_replace(".",",",$rm06);
$r07=$hlavicka->r07; $er07=str_replace(".",",",$r07); $rm07=$hlavicka->rm07; $erm07=str_replace(".",",",$rm07);
$r08=$hlavicka->r08; $er08=str_replace(".",",",$r08); $rm08=$hlavicka->rm08; $erm08=str_replace(".",",",$rm08);
$r09=$hlavicka->r09; $er09=str_replace(".",",",$r09); $rm09=$hlavicka->rm09; $erm09=str_replace(".",",",$rm09);

$r10=$hlavicka->r10; $er10=str_replace(".",",",$r10); $rm10=$hlavicka->rm10; $erm10=str_replace(".",",",$rm10);
$r11=$hlavicka->r11; $er11=str_replace(".",",",$r11); $rm11=$hlavicka->rm11; $erm11=str_replace(".",",",$rm11);
$r12=$hlavicka->r12; $er12=str_replace(".",",",$r12); $rm12=$hlavicka->rm12; $erm12=str_replace(".",",",$rm12);
$r13=$hlavicka->r13; $er13=str_replace(".",",",$r13); $rm13=$hlavicka->rm13; $erm13=str_replace(".",",",$rm13);
$r14=$hlavicka->r14; $er14=str_replace(".",",",$r14); $rm14=$hlavicka->rm14; $erm14=str_replace(".",",",$rm14);
$r15=$hlavicka->r15; $er15=str_replace(".",",",$r15); $rm15=$hlavicka->rm15; $erm15=str_replace(".",",",$rm15);
$r16=$hlavicka->r16; $er16=str_replace(".",",",$r16); $rm16=$hlavicka->rm16; $erm16=str_replace(".",",",$rm16);
$r17=$hlavicka->r17; $er17=str_replace(".",",",$r17); $rm17=$hlavicka->rm17; $erm17=str_replace(".",",",$rm17);
$r18=$hlavicka->r18; $er18=str_replace(".",",",$r18); $rm18=$hlavicka->rm18; $erm18=str_replace(".",",",$rm18);
$r19=$hlavicka->r19; $er19=str_replace(".",",",$r19); $rm19=$hlavicka->rm19; $erm19=str_replace(".",",",$rm19);

$r20=$hlavicka->r20; $er20=str_replace(".",",",$r20); $rm20=$hlavicka->rm20; $erm20=str_replace(".",",",$rm20);
$r21=$hlavicka->r21; $er21=str_replace(".",",",$r21); $rm21=$hlavicka->rm21; $erm21=str_replace(".",",",$rm21);
$r22=$hlavicka->r22; $er22=str_replace(".",",",$r22); $rm22=$hlavicka->rm22; $erm22=str_replace(".",",",$rm22);
$r23=$hlavicka->r23; $er23=str_replace(".",",",$r23); $rm23=$hlavicka->rm23; $erm23=str_replace(".",",",$rm23);
$r24=$hlavicka->r24; $er24=str_replace(".",",",$r24); $rm24=$hlavicka->rm24; $erm24=str_replace(".",",",$rm24);
$r25=$hlavicka->r25; $er25=str_replace(".",",",$r25); $rm25=$hlavicka->rm25; $erm25=str_replace(".",",",$rm25);
$r26=$hlavicka->r26; $er26=str_replace(".",",",$r26); $rm26=$hlavicka->rm26; $erm26=str_replace(".",",",$rm26);
$r27=$hlavicka->r27; $er27=str_replace(".",",",$r27); $rm27=$hlavicka->rm27; $erm27=str_replace(".",",",$rm27);
$r28=$hlavicka->r28; $er28=str_replace(".",",",$r28); $rm28=$hlavicka->rm28; $erm28=str_replace(".",",",$rm28);
$r29=$hlavicka->r29; $er29=str_replace(".",",",$r29); $rm29=$hlavicka->rm29; $erm29=str_replace(".",",",$rm29);

$r30=$hlavicka->r30; $er30=str_replace(".",",",$r30); $rm30=$hlavicka->rm30; $erm30=str_replace(".",",",$rm30);
$r31=$hlavicka->r31; $er31=str_replace(".",",",$r31); $rm31=$hlavicka->rm31; $erm31=str_replace(".",",",$rm31);
$r32=$hlavicka->r32; $er32=str_replace(".",",",$r32); $rm32=$hlavicka->rm32; $erm32=str_replace(".",",",$rm32);
$r33=$hlavicka->r33; $er33=str_replace(".",",",$r33); $rm33=$hlavicka->rm33; $erm33=str_replace(".",",",$rm33);
$r34=$hlavicka->r34; $er34=str_replace(".",",",$r34); $rm34=$hlavicka->rm34; $erm34=str_replace(".",",",$rm34);
$r35=$hlavicka->r35; $er35=str_replace(".",",",$r35); $rm35=$hlavicka->rm35; $erm35=str_replace(".",",",$rm35);
$r36=$hlavicka->r36; $er36=str_replace(".",",",$r36); $rm36=$hlavicka->rm36; $erm36=str_replace(".",",",$rm36);
$r37=$hlavicka->r37; $er37=str_replace(".",",",$r37); $rm37=$hlavicka->rm37; $erm37=str_replace(".",",",$rm37);
$r38=$hlavicka->r38; $er38=str_replace(".",",",$r38); $rm38=$hlavicka->rm38; $erm38=str_replace(".",",",$rm38);
$r39=$hlavicka->r39; $er39=str_replace(".",",",$r39); $rm39=$hlavicka->rm39; $erm39=str_replace(".",",",$rm39);

$r40=$hlavicka->r40; $er40=str_replace(".",",",$r40); $rm40=$hlavicka->rm40; $erm40=str_replace(".",",",$rm40);
$r41=$hlavicka->r41; $er41=str_replace(".",",",$r41); $rm41=$hlavicka->rm41; $erm41=str_replace(".",",",$rm41);
$r42=$hlavicka->r42; $er42=str_replace(".",",",$r42); $rm42=$hlavicka->rm42; $erm42=str_replace(".",",",$rm42);
$r43=$hlavicka->r43; $er43=str_replace(".",",",$r43); $rm43=$hlavicka->rm43; $erm43=str_replace(".",",",$rm43);
$r44=$hlavicka->r44; $er44=str_replace(".",",",$r44); $rm44=$hlavicka->rm44; $erm44=str_replace(".",",",$rm44);
$r45=$hlavicka->r45; $er45=str_replace(".",",",$r45); $rm45=$hlavicka->rm45; $erm45=str_replace(".",",",$rm45);
$r46=$hlavicka->r46; $er46=str_replace(".",",",$r46); $rm46=$hlavicka->rm46; $erm46=str_replace(".",",",$rm46);
$r47=$hlavicka->r47; $er47=str_replace(".",",",$r47); $rm47=$hlavicka->rm47; $erm47=str_replace(".",",",$rm47);
$r48=$hlavicka->r48; $er48=str_replace(".",",",$r48); $rm48=$hlavicka->rm48; $erm48=str_replace(".",",",$rm48);
$r49=$hlavicka->r49; $er49=str_replace(".",",",$r49); $rm49=$hlavicka->rm49; $erm49=str_replace(".",",",$rm49);

$r50=$hlavicka->r50; $er50=str_replace(".",",",$r50); $rm50=$hlavicka->rm50; $erm50=str_replace(".",",",$rm50);
$r51=$hlavicka->r51; $er51=str_replace(".",",",$r51); $rm51=$hlavicka->rm51; $erm51=str_replace(".",",",$rm51);
$r52=$hlavicka->r52; $er52=str_replace(".",",",$r52); $rm52=$hlavicka->rm52; $erm52=str_replace(".",",",$rm52);
$r53=$hlavicka->r53; $er53=str_replace(".",",",$r53); $rm53=$hlavicka->rm53; $erm53=str_replace(".",",",$rm53);
$r54=$hlavicka->r54; $er54=str_replace(".",",",$r54); $rm54=$hlavicka->rm54; $erm54=str_replace(".",",",$rm54);
$r55=$hlavicka->r55; $er55=str_replace(".",",",$r55); $rm55=$hlavicka->rm55; $erm55=str_replace(".",",",$rm55);
$r56=$hlavicka->r56; $er56=str_replace(".",",",$r56); $rm56=$hlavicka->rm56; $erm56=str_replace(".",",",$rm56);
$r57=$hlavicka->r57; $er57=str_replace(".",",",$r57); $rm57=$hlavicka->rm57; $erm57=str_replace(".",",",$rm57);
$r58=$hlavicka->r58; $er58=str_replace(".",",",$r58); $rm58=$hlavicka->rm58; $erm58=str_replace(".",",",$rm58);
$r59=$hlavicka->r59; $er59=str_replace(".",",",$r59); $rm59=$hlavicka->rm59; $erm59=str_replace(".",",",$rm59);

$r60=$hlavicka->r60; $er60=str_replace(".",",",$r60); $rm60=$hlavicka->rm60; $erm60=str_replace(".",",",$rm60);
$r61=$hlavicka->r61; $er61=str_replace(".",",",$r61); $rm61=$hlavicka->rm61; $erm61=str_replace(".",",",$rm61);
$r62=$hlavicka->r62; $er62=str_replace(".",",",$r62); $rm62=$hlavicka->rm62; $erm62=str_replace(".",",",$rm62);
$r63=$hlavicka->r63; $er63=str_replace(".",",",$r63); $rm63=$hlavicka->rm63; $erm63=str_replace(".",",",$rm63);
$r64=$hlavicka->r64; $er64=str_replace(".",",",$r64); $rm64=$hlavicka->rm64; $erm64=str_replace(".",",",$rm64);
$r65=$hlavicka->r65; $er65=str_replace(".",",",$r65); $rm65=$hlavicka->rm65; $erm65=str_replace(".",",",$rm65);
$r66=$hlavicka->r66; $er66=str_replace(".",",",$r66); $rm66=$hlavicka->rm66; $erm66=str_replace(".",",",$rm66);
$r67=$hlavicka->r67; $er67=str_replace(".",",",$r67); $rm67=$hlavicka->rm67; $erm67=str_replace(".",",",$rm67);
$r68=$hlavicka->r68; $er68=str_replace(".",",",$r68); $rm68=$hlavicka->rm68; $erm68=str_replace(".",",",$rm68);
$r69=$hlavicka->r69; $er69=str_replace(".",",",$r69); $rm69=$hlavicka->rm69; $erm69=str_replace(".",",",$rm69);

$r70=$hlavicka->r70; $er70=str_replace(".",",",$r70); $rm70=$hlavicka->rm70; $erm70=str_replace(".",",",$rm70);
$r71=$hlavicka->r71; $er71=str_replace(".",",",$r71); $rm71=$hlavicka->rm71; $erm71=str_replace(".",",",$rm71);
$r72=$hlavicka->r72; $er72=str_replace(".",",",$r72); $rm72=$hlavicka->rm72; $erm72=str_replace(".",",",$rm72);
$r73=$hlavicka->r73; $er73=str_replace(".",",",$r73); $rm73=$hlavicka->rm73; $erm73=str_replace(".",",",$rm73);
$r74=$hlavicka->r74; $er74=str_replace(".",",",$r74); $rm74=$hlavicka->rm74; $erm74=str_replace(".",",",$rm74);
$r75=$hlavicka->r75; $er75=str_replace(".",",",$r75); $rm75=$hlavicka->rm75; $erm75=str_replace(".",",",$rm75);
$r76=$hlavicka->r76; $er76=str_replace(".",",",$r76); $rm76=$hlavicka->rm76; $erm76=str_replace(".",",",$rm76);
$r77=$hlavicka->r77; $er77=str_replace(".",",",$r77); $rm77=$hlavicka->rm77; $erm77=str_replace(".",",",$rm77);
$r78=$hlavicka->r78; $er78=str_replace(".",",",$r78); $rm78=$hlavicka->rm78; $erm78=str_replace(".",",",$rm78);
$r79=$hlavicka->r79; $er79=str_replace(".",",",$r79); $rm79=$hlavicka->rm79; $erm79=str_replace(".",",",$rm79);


$rpc01=$hlavicka->rpc01; $erpc01=str_replace(".",",",$rpc01); $rsp01=$hlavicka->rsp01; $ersp01=str_replace(".",",",$rsp01);
$rpc02=$hlavicka->rpc02; $erpc02=str_replace(".",",",$rpc02); $rsp02=$hlavicka->rsp02; $ersp02=str_replace(".",",",$rsp02);
$rpc03=$hlavicka->rpc03; $erpc03=str_replace(".",",",$rpc03); $rsp03=$hlavicka->rsp03; $ersp03=str_replace(".",",",$rsp03);
$rpc04=$hlavicka->rpc04; $erpc04=str_replace(".",",",$rpc04); $rsp04=$hlavicka->rsp04; $ersp04=str_replace(".",",",$rsp04);
$rpc05=$hlavicka->rpc05; $erpc05=str_replace(".",",",$rpc05); $rsp05=$hlavicka->rsp05; $ersp05=str_replace(".",",",$rsp05);
$rpc06=$hlavicka->rpc06; $erpc06=str_replace(".",",",$rpc06); $rsp06=$hlavicka->rsp06; $ersp06=str_replace(".",",",$rsp06);
$rpc07=$hlavicka->rpc07; $erpc07=str_replace(".",",",$rpc07); $rsp07=$hlavicka->rsp07; $ersp07=str_replace(".",",",$rsp07);
$rpc08=$hlavicka->rpc08; $erpc08=str_replace(".",",",$rpc08); $rsp08=$hlavicka->rsp08; $ersp08=str_replace(".",",",$rsp08);
$rpc09=$hlavicka->rpc09; $erpc09=str_replace(".",",",$rpc09); $rsp09=$hlavicka->rsp09; $ersp09=str_replace(".",",",$rsp09);

$rpc10=$hlavicka->rpc10; $erpc10=str_replace(".",",",$rpc10); $rsp10=$hlavicka->rsp10; $ersp10=str_replace(".",",",$rsp10);
$rpc11=$hlavicka->rpc11; $erpc11=str_replace(".",",",$rpc11); $rsp11=$hlavicka->rsp11; $ersp11=str_replace(".",",",$rsp11);
$rpc12=$hlavicka->rpc12; $erpc12=str_replace(".",",",$rpc12); $rsp12=$hlavicka->rsp12; $ersp12=str_replace(".",",",$rsp12);
$rpc13=$hlavicka->rpc13; $erpc13=str_replace(".",",",$rpc13); $rsp13=$hlavicka->rsp13; $ersp13=str_replace(".",",",$rsp13);
$rpc14=$hlavicka->rpc14; $erpc14=str_replace(".",",",$rpc14); $rsp14=$hlavicka->rsp14; $ersp14=str_replace(".",",",$rsp14);
$rpc15=$hlavicka->rpc15; $erpc15=str_replace(".",",",$rpc15); $rsp15=$hlavicka->rsp15; $ersp15=str_replace(".",",",$rsp15);
$rpc16=$hlavicka->rpc16; $erpc16=str_replace(".",",",$rpc16); $rsp16=$hlavicka->rsp16; $ersp16=str_replace(".",",",$rsp16);
$rpc17=$hlavicka->rpc17; $erpc17=str_replace(".",",",$rpc17); $rsp17=$hlavicka->rsp17; $ersp17=str_replace(".",",",$rsp17);
$rpc18=$hlavicka->rpc18; $erpc18=str_replace(".",",",$rpc18); $rsp18=$hlavicka->rsp18; $ersp18=str_replace(".",",",$rsp18);
$rpc19=$hlavicka->rpc19; $erpc19=str_replace(".",",",$rpc19); $rsp19=$hlavicka->rsp19; $ersp19=str_replace(".",",",$rsp19);

$rpc20=$hlavicka->rpc20; $erpc20=str_replace(".",",",$rpc20); $rsp20=$hlavicka->rsp20; $ersp20=str_replace(".",",",$rsp20);
$rpc21=$hlavicka->rpc21; $erpc21=str_replace(".",",",$rpc21); $rsp21=$hlavicka->rsp21; $ersp21=str_replace(".",",",$rsp21);
$rpc22=$hlavicka->rpc22; $erpc22=str_replace(".",",",$rpc22); $rsp22=$hlavicka->rsp22; $ersp22=str_replace(".",",",$rsp22);
$rpc23=$hlavicka->rpc23; $erpc23=str_replace(".",",",$rpc23); $rsp23=$hlavicka->rsp23; $ersp23=str_replace(".",",",$rsp23);
$rpc24=$hlavicka->rpc24; $erpc24=str_replace(".",",",$rpc24); $rsp24=$hlavicka->rsp24; $ersp24=str_replace(".",",",$rsp24);
$rpc25=$hlavicka->rpc25; $erpc25=str_replace(".",",",$rpc25); $rsp25=$hlavicka->rsp25; $ersp25=str_replace(".",",",$rsp25);
$rpc26=$hlavicka->rpc26; $erpc26=str_replace(".",",",$rpc26); $rsp26=$hlavicka->rsp26; $ersp26=str_replace(".",",",$rsp26);
$rpc27=$hlavicka->rpc27; $erpc27=str_replace(".",",",$rpc27); $rsp27=$hlavicka->rsp27; $ersp27=str_replace(".",",",$rsp27);
$rpc28=$hlavicka->rpc28; $erpc28=str_replace(".",",",$rpc28); $rsp28=$hlavicka->rsp28; $ersp28=str_replace(".",",",$rsp28);
$rpc29=$hlavicka->rpc29; $erpc29=str_replace(".",",",$rpc29); $rsp29=$hlavicka->rsp29; $ersp29=str_replace(".",",",$rsp29);

$rpc30=$hlavicka->rpc30; $erpc30=str_replace(".",",",$rpc30); $rsp30=$hlavicka->rsp30; $ersp30=str_replace(".",",",$rsp30);
$rpc31=$hlavicka->rpc31; $erpc31=str_replace(".",",",$rpc31); $rsp31=$hlavicka->rsp31; $ersp31=str_replace(".",",",$rsp31);
$rpc32=$hlavicka->rpc32; $erpc32=str_replace(".",",",$rpc32); $rsp32=$hlavicka->rsp32; $ersp32=str_replace(".",",",$rsp32);
$rpc33=$hlavicka->rpc33; $erpc33=str_replace(".",",",$rpc33); $rsp33=$hlavicka->rsp33; $ersp33=str_replace(".",",",$rsp33);
$rpc34=$hlavicka->rpc34; $erpc34=str_replace(".",",",$rpc34); $rsp34=$hlavicka->rsp34; $ersp34=str_replace(".",",",$rsp34);
$rpc35=$hlavicka->rpc35; $erpc35=str_replace(".",",",$rpc35); $rsp35=$hlavicka->rsp35; $ersp35=str_replace(".",",",$rsp35);
$rpc36=$hlavicka->rpc36; $erpc36=str_replace(".",",",$rpc36); $rsp36=$hlavicka->rsp36; $ersp36=str_replace(".",",",$rsp36);
$rpc37=$hlavicka->rpc37; $erpc37=str_replace(".",",",$rpc37); $rsp37=$hlavicka->rsp37; $ersp37=str_replace(".",",",$rsp37);
$rpc38=$hlavicka->rpc38; $erpc38=str_replace(".",",",$rpc38); $rsp38=$hlavicka->rsp38; $ersp38=str_replace(".",",",$rsp38);
$rpc39=$hlavicka->rpc39; $erpc39=str_replace(".",",",$rpc39); $rsp39=$hlavicka->rsp39; $ersp39=str_replace(".",",",$rsp39);

$rpc40=$hlavicka->rpc40; $erpc40=str_replace(".",",",$rpc40); $rsp40=$hlavicka->rsp40; $ersp40=str_replace(".",",",$rsp40);
$rpc41=$hlavicka->rpc41; $erpc41=str_replace(".",",",$rpc41); $rsp41=$hlavicka->rsp41; $ersp41=str_replace(".",",",$rsp41);
$rpc42=$hlavicka->rpc42; $erpc42=str_replace(".",",",$rpc42); $rsp42=$hlavicka->rsp42; $ersp42=str_replace(".",",",$rsp42);
$rpc43=$hlavicka->rpc43; $erpc43=str_replace(".",",",$rpc43); $rsp43=$hlavicka->rsp43; $ersp43=str_replace(".",",",$rsp43);
$rpc44=$hlavicka->rpc44; $erpc44=str_replace(".",",",$rpc44); $rsp44=$hlavicka->rsp44; $ersp44=str_replace(".",",",$rsp44);
$rpc45=$hlavicka->rpc45; $erpc45=str_replace(".",",",$rpc45); $rsp45=$hlavicka->rsp45; $ersp45=str_replace(".",",",$rsp45);
$rpc46=$hlavicka->rpc46; $erpc46=str_replace(".",",",$rpc46); $rsp46=$hlavicka->rsp46; $ersp46=str_replace(".",",",$rsp46);
$rpc47=$hlavicka->rpc47; $erpc47=str_replace(".",",",$rpc47); $rsp47=$hlavicka->rsp47; $ersp47=str_replace(".",",",$rsp47);
$rpc48=$hlavicka->rpc48; $erpc48=str_replace(".",",",$rpc48); $rsp48=$hlavicka->rsp48; $ersp48=str_replace(".",",",$rsp48);
$rpc49=$hlavicka->rpc49; $erpc49=str_replace(".",",",$rpc49); $rsp49=$hlavicka->rsp49; $ersp49=str_replace(".",",",$rsp49);

$rpc50=$hlavicka->rpc50; $erpc50=str_replace(".",",",$rpc50); $rsp50=$hlavicka->rsp50; $ersp50=str_replace(".",",",$rsp50);
$rpc51=$hlavicka->rpc51; $erpc51=str_replace(".",",",$rpc51); $rsp51=$hlavicka->rsp51; $ersp51=str_replace(".",",",$rsp51);
$rpc52=$hlavicka->rpc52; $erpc52=str_replace(".",",",$rpc52); $rsp52=$hlavicka->rsp52; $ersp52=str_replace(".",",",$rsp52);
$rpc53=$hlavicka->rpc53; $erpc53=str_replace(".",",",$rpc53); $rsp53=$hlavicka->rsp53; $ersp53=str_replace(".",",",$rsp53);
$rpc54=$hlavicka->rpc54; $erpc54=str_replace(".",",",$rpc54); $rsp54=$hlavicka->rsp54; $ersp54=str_replace(".",",",$rsp54);
$rpc55=$hlavicka->rpc55; $erpc55=str_replace(".",",",$rpc55); $rsp55=$hlavicka->rsp55; $ersp55=str_replace(".",",",$rsp55);
$rpc56=$hlavicka->rpc56; $erpc56=str_replace(".",",",$rpc56); $rsp56=$hlavicka->rsp56; $ersp56=str_replace(".",",",$rsp56);
$rpc57=$hlavicka->rpc57; $erpc57=str_replace(".",",",$rpc57); $rsp57=$hlavicka->rsp57; $ersp57=str_replace(".",",",$rsp57);
$rpc58=$hlavicka->rpc58; $erpc58=str_replace(".",",",$rpc58); $rsp58=$hlavicka->rsp58; $ersp58=str_replace(".",",",$rsp58);
$rpc59=$hlavicka->rpc59; $erpc59=str_replace(".",",",$rpc59); $rsp59=$hlavicka->rsp59; $ersp59=str_replace(".",",",$rsp59);

$rpc60=$hlavicka->rpc60; $erpc60=str_replace(".",",",$rpc60); $rsp60=$hlavicka->rsp60; $ersp60=str_replace(".",",",$rsp60);
$rpc61=$hlavicka->rpc61; $erpc61=str_replace(".",",",$rpc61); $rsp61=$hlavicka->rsp61; $ersp61=str_replace(".",",",$rsp61);
$rpc62=$hlavicka->rpc62; $erpc62=str_replace(".",",",$rpc62); $rsp62=$hlavicka->rsp62; $ersp62=str_replace(".",",",$rsp62);
$rpc63=$hlavicka->rpc63; $erpc63=str_replace(".",",",$rpc63); $rsp63=$hlavicka->rsp63; $ersp63=str_replace(".",",",$rsp63);
$rpc64=$hlavicka->rpc64; $erpc64=str_replace(".",",",$rpc64); $rsp64=$hlavicka->rsp64; $ersp64=str_replace(".",",",$rsp64);
$rpc65=$hlavicka->rpc65; $erpc65=str_replace(".",",",$rpc65); $rsp65=$hlavicka->rsp65; $ersp65=str_replace(".",",",$rsp65);
$rpc66=$hlavicka->rpc66; $erpc66=str_replace(".",",",$rpc66); $rsp66=$hlavicka->rsp66; $ersp66=str_replace(".",",",$rsp66);
$rpc67=$hlavicka->rpc67; $erpc67=str_replace(".",",",$rpc67); $rsp67=$hlavicka->rsp67; $ersp67=str_replace(".",",",$rsp67);
$rpc68=$hlavicka->rpc68; $erpc68=str_replace(".",",",$rpc68); $rsp68=$hlavicka->rsp68; $ersp68=str_replace(".",",",$rsp68);
$rpc69=$hlavicka->rpc69; $erpc69=str_replace(".",",",$rpc69); $rsp69=$hlavicka->rsp69; $ersp69=str_replace(".",",",$rsp69);

$rpc70=$hlavicka->rpc70; $erpc70=str_replace(".",",",$rpc70); $rsp70=$hlavicka->rsp70; $ersp70=str_replace(".",",",$rsp70);
$rpc71=$hlavicka->rpc71; $erpc71=str_replace(".",",",$rpc71); $rsp71=$hlavicka->rsp71; $ersp71=str_replace(".",",",$rsp71);
$rpc72=$hlavicka->rpc72; $erpc72=str_replace(".",",",$rpc72); $rsp72=$hlavicka->rsp72; $ersp72=str_replace(".",",",$rsp72);
$rpc73=$hlavicka->rpc73; $erpc73=str_replace(".",",",$rpc73); $rsp73=$hlavicka->rsp73; $ersp73=str_replace(".",",",$rsp73);
$rpc74=$hlavicka->rpc74; $erpc74=str_replace(".",",",$rpc74); $rsp74=$hlavicka->rsp74; $ersp74=str_replace(".",",",$rsp74);
$rpc75=$hlavicka->rpc75; $erpc75=str_replace(".",",",$rpc75); $rsp75=$hlavicka->rsp75; $ersp75=str_replace(".",",",$rsp75);
$rpc76=$hlavicka->rpc76; $erpc76=str_replace(".",",",$rpc76); $rsp76=$hlavicka->rsp76; $ersp76=str_replace(".",",",$rsp76);
$rpc77=$hlavicka->rpc77; $erpc77=str_replace(".",",",$rpc77); $rsp77=$hlavicka->rsp77; $ersp77=str_replace(".",",",$rsp77);
$rpc78=$hlavicka->rpc78; $erpc78=str_replace(".",",",$rpc78); $rsp78=$hlavicka->rsp78; $ersp78=str_replace(".",",",$rsp78);
$rpc79=$hlavicka->rpc79; $erpc79=str_replace(".",",",$rpc79); $rsp79=$hlavicka->rsp79; $ersp79=str_replace(".",",",$rsp79);


if( $i == 0 )
     {
  $text = "riadok".";"."hlav.cin.".";"."podn.cin.".";"."spolu".";"."predch.obdobie"."\r\n"; 

  fwrite($soubor, $text);

     }

  $text =       "01;".$er01.";".$erpc01.";".$ersp01.";".$erm01."\r\n"; 
  $text = $text."02;".$er02.";".$erpc02.";".$ersp02.";".$erm02."\r\n"; 
  $text = $text."03;".$er03.";".$erpc03.";".$ersp03.";".$erm03."\r\n"; 
  $text = $text."04;".$er04.";".$erpc04.";".$ersp04.";".$erm04."\r\n"; 
  $text = $text."05;".$er05.";".$erpc05.";".$ersp05.";".$erm05."\r\n"; 
  $text = $text."06;".$er06.";".$erpc06.";".$ersp06.";".$erm06."\r\n"; 
  $text = $text."07;".$er07.";".$erpc07.";".$ersp07.";".$erm07."\r\n"; 
  $text = $text."08;".$er08.";".$erpc08.";".$ersp08.";".$erm08."\r\n"; 
  $text = $text."09;".$er09.";".$erpc09.";".$ersp09.";".$erm09."\r\n"; 
  $text = $text."10;".$er10.";".$erpc10.";".$ersp10.";".$erm10."\r\n"; 
  $text = $text."11;".$er11.";".$erpc11.";".$ersp11.";".$erm11."\r\n"; 
  $text = $text."12;".$er12.";".$erpc12.";".$ersp12.";".$erm12."\r\n"; 
  $text = $text."13;".$er13.";".$erpc13.";".$ersp13.";".$erm13."\r\n"; 
  $text = $text."14;".$er14.";".$erpc14.";".$ersp14.";".$erm14."\r\n"; 
  $text = $text."15;".$er15.";".$erpc15.";".$ersp15.";".$erm15."\r\n"; 
  $text = $text."16;".$er16.";".$erpc16.";".$ersp16.";".$erm16."\r\n"; 
  $text = $text."17;".$er17.";".$erpc17.";".$ersp17.";".$erm17."\r\n"; 
  $text = $text."18;".$er18.";".$erpc18.";".$ersp18.";".$erm18."\r\n"; 
  $text = $text."19;".$er19.";".$erpc19.";".$ersp19.";".$erm19."\r\n";   

  $text = $text."20;".$er20.";".$erpc20.";".$ersp20.";".$erm20."\r\n"; 
  $text = $text."21;".$er21.";".$erpc21.";".$ersp21.";".$erm21."\r\n"; 
  $text = $text."22;".$er22.";".$erpc22.";".$ersp22.";".$erm22."\r\n"; 
  $text = $text."23;".$er23.";".$erpc23.";".$ersp23.";".$erm23."\r\n"; 
  $text = $text."24;".$er24.";".$erpc24.";".$ersp24.";".$erm24."\r\n"; 
  $text = $text."25;".$er25.";".$erpc25.";".$ersp25.";".$erm25."\r\n"; 
  $text = $text."26;".$er26.";".$erpc26.";".$ersp26.";".$erm26."\r\n"; 
  $text = $text."27;".$er27.";".$erpc27.";".$ersp27.";".$erm27."\r\n"; 
  $text = $text."28;".$er28.";".$erpc28.";".$ersp28.";".$erm28."\r\n"; 
  $text = $text."29;".$er29.";".$erpc29.";".$ersp29.";".$erm29."\r\n";  
  $text = $text."30;".$er30.";".$erpc30.";".$ersp30.";".$erm30."\r\n"; 
  $text = $text."31;".$er31.";".$erpc31.";".$ersp31.";".$erm31."\r\n"; 
  $text = $text."32;".$er32.";".$erpc32.";".$ersp32.";".$erm32."\r\n"; 
  $text = $text."33;".$er33.";".$erpc33.";".$ersp33.";".$erm33."\r\n"; 
  $text = $text."34;".$er34.";".$erpc34.";".$ersp34.";".$erm34."\r\n"; 
  $text = $text."35;".$er35.";".$erpc35.";".$ersp35.";".$erm35."\r\n"; 
  $text = $text."36;".$er36.";".$erpc36.";".$ersp36.";".$erm36."\r\n"; 
  $text = $text."37;".$er37.";".$erpc37.";".$ersp37.";".$erm37."\r\n"; 
  $text = $text."38;".$er38.";".$erpc38.";".$ersp38.";".$erm38."\r\n"; 
  $text = $text."39;".$er39.";".$erpc39.";".$ersp39.";".$erm39."\r\n";  
  $text = $text."40;".$er40.";".$erpc40.";".$ersp40.";".$erm40."\r\n"; 
  $text = $text."41;".$er41.";".$erpc41.";".$ersp41.";".$erm41."\r\n"; 
  $text = $text."42;".$er42.";".$erpc42.";".$ersp42.";".$erm42."\r\n"; 
  $text = $text."43;".$er43.";".$erpc43.";".$ersp43.";".$erm43."\r\n"; 
  $text = $text."44;".$er44.";".$erpc44.";".$ersp44.";".$erm44."\r\n"; 
  $text = $text."45;".$er45.";".$erpc45.";".$ersp45.";".$erm45."\r\n"; 
  $text = $text."46;".$er46.";".$erpc46.";".$ersp46.";".$erm46."\r\n"; 
  $text = $text."47;".$er47.";".$erpc47.";".$ersp47.";".$erm47."\r\n"; 
  $text = $text."48;".$er48.";".$erpc48.";".$ersp48.";".$erm48."\r\n"; 
  $text = $text."49;".$er49.";".$erpc49.";".$ersp49.";".$erm49."\r\n";  
  $text = $text."50;".$er50.";".$erpc50.";".$ersp50.";".$erm50."\r\n"; 
  $text = $text."51;".$er51.";".$erpc51.";".$ersp51.";".$erm51."\r\n"; 
  $text = $text."52;".$er52.";".$erpc52.";".$ersp52.";".$erm52."\r\n"; 
  $text = $text."53;".$er53.";".$erpc53.";".$ersp53.";".$erm53."\r\n"; 
  $text = $text."54;".$er54.";".$erpc54.";".$ersp54.";".$erm54."\r\n"; 
  $text = $text."55;".$er55.";".$erpc55.";".$ersp55.";".$erm55."\r\n"; 
  $text = $text."56;".$er56.";".$erpc56.";".$ersp56.";".$erm56."\r\n"; 
  $text = $text."57;".$er57.";".$erpc57.";".$ersp57.";".$erm57."\r\n"; 
  $text = $text."58;".$er58.";".$erpc58.";".$ersp58.";".$erm58."\r\n"; 
  $text = $text."59;".$er59.";".$erpc59.";".$ersp59.";".$erm59."\r\n";  
  $text = $text."60;".$er60.";".$erpc60.";".$ersp60.";".$erm60."\r\n"; 
  $text = $text."61;".$er61.";".$erpc61.";".$ersp61.";".$erm61."\r\n"; 
  $text = $text."62;".$er62.";".$erpc62.";".$ersp62.";".$erm62."\r\n"; 
  $text = $text."63;".$er63.";".$erpc63.";".$ersp63.";".$erm63."\r\n"; 
  $text = $text."64;".$er64.";".$erpc64.";".$ersp64.";".$erm64."\r\n"; 
  $text = $text."65;".$er65.";".$erpc65.";".$ersp65.";".$erm65."\r\n"; 
  $text = $text."66;".$er66.";".$erpc66.";".$ersp66.";".$erm66."\r\n"; 
  $text = $text."67;".$er67.";".$erpc67.";".$ersp67.";".$erm67."\r\n"; 
  $text = $text."68;".$er68.";".$erpc68.";".$ersp68.";".$erm68."\r\n"; 
  $text = $text."69;".$er69.";".$erpc69.";".$ersp69.";".$erm69."\r\n";  
  $text = $text."70;".$er70.";".$erpc70.";".$ersp70.";".$erm70."\r\n"; 
  $text = $text."71;".$er71.";".$erpc71.";".$ersp71.";".$erm71."\r\n"; 
  $text = $text."72;".$er72.";".$erpc72.";".$ersp72.";".$erm72."\r\n"; 
  $text = $text."73;".$er73.";".$erpc73.";".$ersp73.";".$erm73."\r\n"; 
  $text = $text."74;".$er74.";".$erpc74.";".$ersp74.";".$erm74."\r\n"; 
  $text = $text."75;".$er75.";".$erpc75.";".$ersp75.";".$erm75."\r\n"; 
  $text = $text."76;".$er76.";".$erpc76.";".$ersp76.";".$erm76."\r\n"; 
  $text = $text."77;".$er77.";".$erpc77.";".$ersp77.";".$erm77."\r\n"; 
  $text = $text."78;".$er78.";".$erpc78.";".$ersp78.";".$erm78."\r\n"; 
  $text = $text."79;".$er79.";".$erpc79.";".$ersp79.";".$erm79."\r\n";  



  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//koniec ak existuje suvor
                                                              }
}
///////////////////////////////////////////////////KONIEC SUBORU VYKAZZISKOV NO



///////////////////////////////////////////////////VYTVORENIE SUBORU SUVAHA NO
if( $copern == 130 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="suvaha_no";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuvahas".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpocsuvahano_stl".
" ON F$kli_vxcf"."_prcsuvahas$kli_uzid.prx=F$kli_vxcf"."_uctpocsuvahano_stl.fic".
" WHERE prx = 1 "."";


$sql = mysql_query("$sqltt");
if($sql)                                                      {
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$das_sk=SkDatum($hlavicka->das);
$dat_sk=SkDatum($hlavicka->dat);
$dau_sk=SkDatum($hlavicka->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk=$dau_sk;

$r01=$hlavicka->r01; $er01=str_replace(".",",",$r01); $rm01=$hlavicka->rm01; $erm01=str_replace(".",",",$rm01);
$r02=$hlavicka->r02; $er02=str_replace(".",",",$r02); $rm02=$hlavicka->rm02; $erm02=str_replace(".",",",$rm02);
$r03=$hlavicka->r03; $er03=str_replace(".",",",$r03); $rm03=$hlavicka->rm03; $erm03=str_replace(".",",",$rm03);
$r04=$hlavicka->r04; $er04=str_replace(".",",",$r04); $rm04=$hlavicka->rm04; $erm04=str_replace(".",",",$rm04);
$r05=$hlavicka->r05; $er05=str_replace(".",",",$r05); $rm05=$hlavicka->rm05; $erm05=str_replace(".",",",$rm05);
$r06=$hlavicka->r06; $er06=str_replace(".",",",$r06); $rm06=$hlavicka->rm06; $erm06=str_replace(".",",",$rm06);
$r07=$hlavicka->r07; $er07=str_replace(".",",",$r07); $rm07=$hlavicka->rm07; $erm07=str_replace(".",",",$rm07);
$r08=$hlavicka->r08; $er08=str_replace(".",",",$r08); $rm08=$hlavicka->rm08; $erm08=str_replace(".",",",$rm08);
$r09=$hlavicka->r09; $er09=str_replace(".",",",$r09); $rm09=$hlavicka->rm09; $erm09=str_replace(".",",",$rm09);

$r10=$hlavicka->r10; $er10=str_replace(".",",",$r10); $rm10=$hlavicka->rm10; $erm10=str_replace(".",",",$rm10);
$r11=$hlavicka->r11; $er11=str_replace(".",",",$r11); $rm11=$hlavicka->rm11; $erm11=str_replace(".",",",$rm11);
$r12=$hlavicka->r12; $er12=str_replace(".",",",$r12); $rm12=$hlavicka->rm12; $erm12=str_replace(".",",",$rm12);
$r13=$hlavicka->r13; $er13=str_replace(".",",",$r13); $rm13=$hlavicka->rm13; $erm13=str_replace(".",",",$rm13);
$r14=$hlavicka->r14; $er14=str_replace(".",",",$r14); $rm14=$hlavicka->rm14; $erm14=str_replace(".",",",$rm14);
$r15=$hlavicka->r15; $er15=str_replace(".",",",$r15); $rm15=$hlavicka->rm15; $erm15=str_replace(".",",",$rm15);
$r16=$hlavicka->r16; $er16=str_replace(".",",",$r16); $rm16=$hlavicka->rm16; $erm16=str_replace(".",",",$rm16);
$r17=$hlavicka->r17; $er17=str_replace(".",",",$r17); $rm17=$hlavicka->rm17; $erm17=str_replace(".",",",$rm17);
$r18=$hlavicka->r18; $er18=str_replace(".",",",$r18); $rm18=$hlavicka->rm18; $erm18=str_replace(".",",",$rm18);
$r19=$hlavicka->r19; $er19=str_replace(".",",",$r19); $rm19=$hlavicka->rm19; $erm19=str_replace(".",",",$rm19);

$r20=$hlavicka->r20; $er20=str_replace(".",",",$r20); $rm20=$hlavicka->rm20; $erm20=str_replace(".",",",$rm20);
$r21=$hlavicka->r21; $er21=str_replace(".",",",$r21); $rm21=$hlavicka->rm21; $erm21=str_replace(".",",",$rm21);
$r22=$hlavicka->r22; $er22=str_replace(".",",",$r22); $rm22=$hlavicka->rm22; $erm22=str_replace(".",",",$rm22);
$r23=$hlavicka->r23; $er23=str_replace(".",",",$r23); $rm23=$hlavicka->rm23; $erm23=str_replace(".",",",$rm23);
$r24=$hlavicka->r24; $er24=str_replace(".",",",$r24); $rm24=$hlavicka->rm24; $erm24=str_replace(".",",",$rm24);
$r25=$hlavicka->r25; $er25=str_replace(".",",",$r25); $rm25=$hlavicka->rm25; $erm25=str_replace(".",",",$rm25);
$r26=$hlavicka->r26; $er26=str_replace(".",",",$r26); $rm26=$hlavicka->rm26; $erm26=str_replace(".",",",$rm26);
$r27=$hlavicka->r27; $er27=str_replace(".",",",$r27); $rm27=$hlavicka->rm27; $erm27=str_replace(".",",",$rm27);
$r28=$hlavicka->r28; $er28=str_replace(".",",",$r28); $rm28=$hlavicka->rm28; $erm28=str_replace(".",",",$rm28);
$r29=$hlavicka->r29; $er29=str_replace(".",",",$r29); $rm29=$hlavicka->rm29; $erm29=str_replace(".",",",$rm29);

$r30=$hlavicka->r30; $er30=str_replace(".",",",$r30); $rm30=$hlavicka->rm30; $erm30=str_replace(".",",",$rm30);
$r31=$hlavicka->r31; $er31=str_replace(".",",",$r31); $rm31=$hlavicka->rm31; $erm31=str_replace(".",",",$rm31);
$r32=$hlavicka->r32; $er32=str_replace(".",",",$r32); $rm32=$hlavicka->rm32; $erm32=str_replace(".",",",$rm32);
$r33=$hlavicka->r33; $er33=str_replace(".",",",$r33); $rm33=$hlavicka->rm33; $erm33=str_replace(".",",",$rm33);
$r34=$hlavicka->r34; $er34=str_replace(".",",",$r34); $rm34=$hlavicka->rm34; $erm34=str_replace(".",",",$rm34);
$r35=$hlavicka->r35; $er35=str_replace(".",",",$r35); $rm35=$hlavicka->rm35; $erm35=str_replace(".",",",$rm35);
$r36=$hlavicka->r36; $er36=str_replace(".",",",$r36); $rm36=$hlavicka->rm36; $erm36=str_replace(".",",",$rm36);
$r37=$hlavicka->r37; $er37=str_replace(".",",",$r37); $rm37=$hlavicka->rm37; $erm37=str_replace(".",",",$rm37);
$r38=$hlavicka->r38; $er38=str_replace(".",",",$r38); $rm38=$hlavicka->rm38; $erm38=str_replace(".",",",$rm38);
$r39=$hlavicka->r39; $er39=str_replace(".",",",$r39); $rm39=$hlavicka->rm39; $erm39=str_replace(".",",",$rm39);

$r40=$hlavicka->r40; $er40=str_replace(".",",",$r40); $rm40=$hlavicka->rm40; $erm40=str_replace(".",",",$rm40);
$r41=$hlavicka->r41; $er41=str_replace(".",",",$r41); $rm41=$hlavicka->rm41; $erm41=str_replace(".",",",$rm41);
$r42=$hlavicka->r42; $er42=str_replace(".",",",$r42); $rm42=$hlavicka->rm42; $erm42=str_replace(".",",",$rm42);
$r43=$hlavicka->r43; $er43=str_replace(".",",",$r43); $rm43=$hlavicka->rm43; $erm43=str_replace(".",",",$rm43);
$r44=$hlavicka->r44; $er44=str_replace(".",",",$r44); $rm44=$hlavicka->rm44; $erm44=str_replace(".",",",$rm44);
$r45=$hlavicka->r45; $er45=str_replace(".",",",$r45); $rm45=$hlavicka->rm45; $erm45=str_replace(".",",",$rm45);
$r46=$hlavicka->r46; $er46=str_replace(".",",",$r46); $rm46=$hlavicka->rm46; $erm46=str_replace(".",",",$rm46);
$r47=$hlavicka->r47; $er47=str_replace(".",",",$r47); $rm47=$hlavicka->rm47; $erm47=str_replace(".",",",$rm47);
$r48=$hlavicka->r48; $er48=str_replace(".",",",$r48); $rm48=$hlavicka->rm48; $erm48=str_replace(".",",",$rm48);
$r49=$hlavicka->r49; $er49=str_replace(".",",",$r49); $rm49=$hlavicka->rm49; $erm49=str_replace(".",",",$rm49);

$r50=$hlavicka->r50; $er50=str_replace(".",",",$r50); $rm50=$hlavicka->rm50; $erm50=str_replace(".",",",$rm50);
$r51=$hlavicka->r51; $er51=str_replace(".",",",$r51); $rm51=$hlavicka->rm51; $erm51=str_replace(".",",",$rm51);
$r52=$hlavicka->r52; $er52=str_replace(".",",",$r52); $rm52=$hlavicka->rm52; $erm52=str_replace(".",",",$rm52);
$r53=$hlavicka->r53; $er53=str_replace(".",",",$r53); $rm53=$hlavicka->rm53; $erm53=str_replace(".",",",$rm53);
$r54=$hlavicka->r54; $er54=str_replace(".",",",$r54); $rm54=$hlavicka->rm54; $erm54=str_replace(".",",",$rm54);
$r55=$hlavicka->r55; $er55=str_replace(".",",",$r55); $rm55=$hlavicka->rm55; $erm55=str_replace(".",",",$rm55);
$r56=$hlavicka->r56; $er56=str_replace(".",",",$r56); $rm56=$hlavicka->rm56; $erm56=str_replace(".",",",$rm56);
$r57=$hlavicka->r57; $er57=str_replace(".",",",$r57); $rm57=$hlavicka->rm57; $erm57=str_replace(".",",",$rm57);
$r58=$hlavicka->r58; $er58=str_replace(".",",",$r58); $rm58=$hlavicka->rm58; $erm58=str_replace(".",",",$rm58);
$r59=$hlavicka->r59; $er59=str_replace(".",",",$r59); $rm59=$hlavicka->rm59; $erm59=str_replace(".",",",$rm59);

$r60=$hlavicka->r60; $er60=str_replace(".",",",$r60); $rm60=$hlavicka->rm60; $erm60=str_replace(".",",",$rm60);
$r61=$hlavicka->r61; $er61=str_replace(".",",",$r61); $rm61=$hlavicka->rm61; $erm61=str_replace(".",",",$rm61);
$r62=$hlavicka->r62; $er62=str_replace(".",",",$r62); $rm62=$hlavicka->rm62; $erm62=str_replace(".",",",$rm62);
$r63=$hlavicka->r63; $er63=str_replace(".",",",$r63); $rm63=$hlavicka->rm63; $erm63=str_replace(".",",",$rm63);
$r64=$hlavicka->r64; $er64=str_replace(".",",",$r64); $rm64=$hlavicka->rm64; $erm64=str_replace(".",",",$rm64);
$r65=$hlavicka->r65; $er65=str_replace(".",",",$r65); $rm65=$hlavicka->rm65; $erm65=str_replace(".",",",$rm65);
$r66=$hlavicka->r66; $er66=str_replace(".",",",$r66); $rm66=$hlavicka->rm66; $erm66=str_replace(".",",",$rm66);
$r67=$hlavicka->r67; $er67=str_replace(".",",",$r67); $rm67=$hlavicka->rm67; $erm67=str_replace(".",",",$rm67);
$r68=$hlavicka->r68; $er68=str_replace(".",",",$r68); $rm68=$hlavicka->rm68; $erm68=str_replace(".",",",$rm68);
$r69=$hlavicka->r69; $er69=str_replace(".",",",$r69); $rm69=$hlavicka->rm69; $erm69=str_replace(".",",",$rm69);

$r70=$hlavicka->r70; $er70=str_replace(".",",",$r70); $rm70=$hlavicka->rm70; $erm70=str_replace(".",",",$rm70);
$r71=$hlavicka->r71; $er71=str_replace(".",",",$r71); $rm71=$hlavicka->rm71; $erm71=str_replace(".",",",$rm71);
$r72=$hlavicka->r72; $er72=str_replace(".",",",$r72); $rm72=$hlavicka->rm72; $erm72=str_replace(".",",",$rm72);
$r73=$hlavicka->r73; $er73=str_replace(".",",",$r73); $rm73=$hlavicka->rm73; $erm73=str_replace(".",",",$rm73);
$r74=$hlavicka->r74; $er74=str_replace(".",",",$r74); $rm74=$hlavicka->rm74; $erm74=str_replace(".",",",$rm74);
$r75=$hlavicka->r75; $er75=str_replace(".",",",$r75); $rm75=$hlavicka->rm75; $erm75=str_replace(".",",",$rm75);
$r76=$hlavicka->r76; $er76=str_replace(".",",",$r76); $rm76=$hlavicka->rm76; $erm76=str_replace(".",",",$rm76);
$r77=$hlavicka->r77; $er77=str_replace(".",",",$r77); $rm77=$hlavicka->rm77; $erm77=str_replace(".",",",$rm77);
$r78=$hlavicka->r78; $er78=str_replace(".",",",$r78); $rm78=$hlavicka->rm78; $erm78=str_replace(".",",",$rm78);
$r79=$hlavicka->r79; $er79=str_replace(".",",",$r79); $rm79=$hlavicka->rm79; $erm79=str_replace(".",",",$rm79);

$r80=$hlavicka->r80; $er80=str_replace(".",",",$r80); $rm80=$hlavicka->rm80; $erm80=str_replace(".",",",$rm80);
$r81=$hlavicka->r81; $er81=str_replace(".",",",$r81); $rm81=$hlavicka->rm81; $erm81=str_replace(".",",",$rm81);
$r82=$hlavicka->r82; $er82=str_replace(".",",",$r82); $rm82=$hlavicka->rm82; $erm82=str_replace(".",",",$rm82);
$r83=$hlavicka->r83; $er83=str_replace(".",",",$r83); $rm83=$hlavicka->rm83; $erm83=str_replace(".",",",$rm83);
$r84=$hlavicka->r84; $er84=str_replace(".",",",$r84); $rm84=$hlavicka->rm84; $erm84=str_replace(".",",",$rm84);
$r85=$hlavicka->r85; $er85=str_replace(".",",",$r85); $rm85=$hlavicka->rm85; $erm85=str_replace(".",",",$rm85);
$r86=$hlavicka->r86; $er86=str_replace(".",",",$r86); $rm86=$hlavicka->rm86; $erm86=str_replace(".",",",$rm86);
$r87=$hlavicka->r87; $er87=str_replace(".",",",$r87); $rm87=$hlavicka->rm87; $erm87=str_replace(".",",",$rm87);
$r88=$hlavicka->r88; $er88=str_replace(".",",",$r88); $rm88=$hlavicka->rm88; $erm88=str_replace(".",",",$rm88);
$r89=$hlavicka->r89; $er89=str_replace(".",",",$r89); $rm89=$hlavicka->rm89; $erm89=str_replace(".",",",$rm89);

$r90=$hlavicka->r90; $er90=str_replace(".",",",$r90); $rm90=$hlavicka->rm90; $erm90=str_replace(".",",",$rm90);
$r91=$hlavicka->r91; $er91=str_replace(".",",",$r91); $rm91=$hlavicka->rm91; $erm91=str_replace(".",",",$rm91);
$r92=$hlavicka->r92; $er92=str_replace(".",",",$r92); $rm92=$hlavicka->rm92; $erm92=str_replace(".",",",$rm92);
$r93=$hlavicka->r93; $er93=str_replace(".",",",$r93); $rm93=$hlavicka->rm93; $erm93=str_replace(".",",",$rm93);
$r94=$hlavicka->r94; $er94=str_replace(".",",",$r94); $rm94=$hlavicka->rm94; $erm94=str_replace(".",",",$rm94);
$r95=$hlavicka->r95; $er95=str_replace(".",",",$r95); $rm95=$hlavicka->rm95; $erm95=str_replace(".",",",$rm95);
$r96=$hlavicka->r96; $er96=str_replace(".",",",$r96); $rm96=$hlavicka->rm96; $erm96=str_replace(".",",",$rm96);
$r97=$hlavicka->r97; $er97=str_replace(".",",",$r97); $rm97=$hlavicka->rm97; $erm97=str_replace(".",",",$rm97);
$r98=$hlavicka->r98; $er98=str_replace(".",",",$r98); $rm98=$hlavicka->rm98; $erm98=str_replace(".",",",$rm98);
$r99=$hlavicka->r99; $er99=str_replace(".",",",$r99); $rm99=$hlavicka->rm99; $erm99=str_replace(".",",",$rm99);

$r100=$hlavicka->r100; $er100=str_replace(".",",",$r100); $rm100=$hlavicka->rm100; $erm100=str_replace(".",",",$rm100);
$r101=$hlavicka->r101; $er101=str_replace(".",",",$r101); $rm101=$hlavicka->rm101; $erm101=str_replace(".",",",$rm101);
$r102=$hlavicka->r102; $er102=str_replace(".",",",$r102); $rm102=$hlavicka->rm102; $erm102=str_replace(".",",",$rm102);
$r103=$hlavicka->r103; $er103=str_replace(".",",",$r103); $rm103=$hlavicka->rm103; $erm103=str_replace(".",",",$rm103);
$r104=$hlavicka->r104; $er104=str_replace(".",",",$r104); $rm104=$hlavicka->rm104; $erm104=str_replace(".",",",$rm104);
$r105=$hlavicka->r105; $er105=str_replace(".",",",$r105); $rm105=$hlavicka->rm105; $erm105=str_replace(".",",",$rm105);
$r106=$hlavicka->r106; $er106=str_replace(".",",",$r106); $rm106=$hlavicka->rm106; $erm106=str_replace(".",",",$rm106);
$r107=$hlavicka->r107; $er107=str_replace(".",",",$r107); $rm107=$hlavicka->rm107; $erm107=str_replace(".",",",$rm107);
$r108=$hlavicka->r108; $er108=str_replace(".",",",$r108); $rm108=$hlavicka->rm108; $erm108=str_replace(".",",",$rm108);
$r109=$hlavicka->r109; $er109=str_replace(".",",",$r109); $rm109=$hlavicka->rm109; $erm109=str_replace(".",",",$rm109);

$r110=$hlavicka->r110; $er110=str_replace(".",",",$r110); $rm110=$hlavicka->rm110; $erm110=str_replace(".",",",$rm110);
$r111=$hlavicka->r111; $er111=str_replace(".",",",$r111); $rm111=$hlavicka->rm111; $erm111=str_replace(".",",",$rm111);
$r112=$hlavicka->r112; $er112=str_replace(".",",",$r112); $rm112=$hlavicka->rm112; $erm112=str_replace(".",",",$rm112);
$r113=$hlavicka->r113; $er113=str_replace(".",",",$r113); $rm113=$hlavicka->rm113; $erm113=str_replace(".",",",$rm113);
$r114=$hlavicka->r114; $er114=str_replace(".",",",$r114); $rm114=$hlavicka->rm114; $erm114=str_replace(".",",",$rm114);
$r115=$hlavicka->r115; $er115=str_replace(".",",",$r115); $rm115=$hlavicka->rm115; $erm115=str_replace(".",",",$rm115);
$r116=$hlavicka->r116; $er116=str_replace(".",",",$r116); $rm116=$hlavicka->rm116; $erm116=str_replace(".",",",$rm116);
$r117=$hlavicka->r117; $er117=str_replace(".",",",$r117); $rm117=$hlavicka->rm117; $erm117=str_replace(".",",",$rm117);
$r118=$hlavicka->r118; $er118=str_replace(".",",",$r118); $rm118=$hlavicka->rm118; $erm118=str_replace(".",",",$rm118);
$r119=$hlavicka->r119; $er119=str_replace(".",",",$r119); $rm119=$hlavicka->rm119; $erm119=str_replace(".",",",$rm119);

$r120=$hlavicka->r120; $er120=str_replace(".",",",$r120); $rm120=$hlavicka->rm120; $erm120=str_replace(".",",",$rm120);
$r121=$hlavicka->r121; $er121=str_replace(".",",",$r121); $rm121=$hlavicka->rm121; $erm121=str_replace(".",",",$rm121);
$r122=$hlavicka->r122; $er122=str_replace(".",",",$r122); $rm122=$hlavicka->rm122; $erm122=str_replace(".",",",$rm122);
$r123=$hlavicka->r123; $er123=str_replace(".",",",$r123); $rm123=$hlavicka->rm123; $erm123=str_replace(".",",",$rm123);
$r124=$hlavicka->r124; $er124=str_replace(".",",",$r124); $rm124=$hlavicka->rm124; $erm124=str_replace(".",",",$rm124);
$r125=$hlavicka->r125; $er125=str_replace(".",",",$r125); $rm125=$hlavicka->rm125; $erm125=str_replace(".",",",$rm125);
$r126=$hlavicka->r126; $er126=str_replace(".",",",$r126); $rm126=$hlavicka->rm126; $erm126=str_replace(".",",",$rm126);
$r127=$hlavicka->r127; $er127=str_replace(".",",",$r127); $rm127=$hlavicka->rm127; $erm127=str_replace(".",",",$rm127);
$r128=$hlavicka->r128; $er128=str_replace(".",",",$r128); $rm128=$hlavicka->rm128; $erm128=str_replace(".",",",$rm128);
$r129=$hlavicka->r129; $er129=str_replace(".",",",$r129); $rm129=$hlavicka->rm129; $erm129=str_replace(".",",",$rm129);

//rk a rn

$rk01=$hlavicka->rk01; $erk01=str_replace(".",",",$rk01); $rn01=$hlavicka->rn01; $ern01=str_replace(".",",",$rn01);
$rk02=$hlavicka->rk02; $erk02=str_replace(".",",",$rk02); $rn02=$hlavicka->rn02; $ern02=str_replace(".",",",$rn02);
$rk03=$hlavicka->rk03; $erk03=str_replace(".",",",$rk03); $rn03=$hlavicka->rn03; $ern03=str_replace(".",",",$rn03);
$rk04=$hlavicka->rk04; $erk04=str_replace(".",",",$rk04); $rn04=$hlavicka->rn04; $ern04=str_replace(".",",",$rn04);
$rk05=$hlavicka->rk05; $erk05=str_replace(".",",",$rk05); $rn05=$hlavicka->rn05; $ern05=str_replace(".",",",$rn05);
$rk06=$hlavicka->rk06; $erk06=str_replace(".",",",$rk06); $rn06=$hlavicka->rn06; $ern06=str_replace(".",",",$rn06);
$rk07=$hlavicka->rk07; $erk07=str_replace(".",",",$rk07); $rn07=$hlavicka->rn07; $ern07=str_replace(".",",",$rn07);
$rk08=$hlavicka->rk08; $erk08=str_replace(".",",",$rk08); $rn08=$hlavicka->rn08; $ern08=str_replace(".",",",$rn08);
$rk09=$hlavicka->rk09; $erk09=str_replace(".",",",$rk09); $rn09=$hlavicka->rn09; $ern09=str_replace(".",",",$rn09);

$rk10=$hlavicka->rk10; $erk10=str_replace(".",",",$rk10); $rn10=$hlavicka->rn10; $ern10=str_replace(".",",",$rn10);
$rk11=$hlavicka->rk11; $erk11=str_replace(".",",",$rk11); $rn11=$hlavicka->rn11; $ern11=str_replace(".",",",$rn11);
$rk12=$hlavicka->rk12; $erk12=str_replace(".",",",$rk12); $rn12=$hlavicka->rn12; $ern12=str_replace(".",",",$rn12);
$rk13=$hlavicka->rk13; $erk13=str_replace(".",",",$rk13); $rn13=$hlavicka->rn13; $ern13=str_replace(".",",",$rn13);
$rk14=$hlavicka->rk14; $erk14=str_replace(".",",",$rk14); $rn14=$hlavicka->rn14; $ern14=str_replace(".",",",$rn14);
$rk15=$hlavicka->rk15; $erk15=str_replace(".",",",$rk15); $rn15=$hlavicka->rn15; $ern15=str_replace(".",",",$rn15);
$rk16=$hlavicka->rk16; $erk16=str_replace(".",",",$rk16); $rn16=$hlavicka->rn16; $ern16=str_replace(".",",",$rn16);
$rk17=$hlavicka->rk17; $erk17=str_replace(".",",",$rk17); $rn17=$hlavicka->rn17; $ern17=str_replace(".",",",$rn17);
$rk18=$hlavicka->rk18; $erk18=str_replace(".",",",$rk18); $rn18=$hlavicka->rn18; $ern18=str_replace(".",",",$rn18);
$rk19=$hlavicka->rk19; $erk19=str_replace(".",",",$rk19); $rn19=$hlavicka->rn19; $ern19=str_replace(".",",",$rn19);

$rk20=$hlavicka->rk20; $erk20=str_replace(".",",",$rk20); $rn20=$hlavicka->rn20; $ern20=str_replace(".",",",$rn20);
$rk21=$hlavicka->rk21; $erk21=str_replace(".",",",$rk21); $rn21=$hlavicka->rn21; $ern21=str_replace(".",",",$rn21);
$rk22=$hlavicka->rk22; $erk22=str_replace(".",",",$rk22); $rn22=$hlavicka->rn22; $ern22=str_replace(".",",",$rn22);
$rk23=$hlavicka->rk23; $erk23=str_replace(".",",",$rk23); $rn23=$hlavicka->rn23; $ern23=str_replace(".",",",$rn23);
$rk24=$hlavicka->rk24; $erk24=str_replace(".",",",$rk24); $rn24=$hlavicka->rn24; $ern24=str_replace(".",",",$rn24);
$rk25=$hlavicka->rk25; $erk25=str_replace(".",",",$rk25); $rn25=$hlavicka->rn25; $ern25=str_replace(".",",",$rn25);
$rk26=$hlavicka->rk26; $erk26=str_replace(".",",",$rk26); $rn26=$hlavicka->rn26; $ern26=str_replace(".",",",$rn26);
$rk27=$hlavicka->rk27; $erk27=str_replace(".",",",$rk27); $rn27=$hlavicka->rn27; $ern27=str_replace(".",",",$rn27);
$rk28=$hlavicka->rk28; $erk28=str_replace(".",",",$rk28); $rn28=$hlavicka->rn28; $ern28=str_replace(".",",",$rn28);
$rk29=$hlavicka->rk29; $erk29=str_replace(".",",",$rk29); $rn29=$hlavicka->rn29; $ern29=str_replace(".",",",$rn29);

$rk30=$hlavicka->rk30; $erk30=str_replace(".",",",$rk30); $rn30=$hlavicka->rn30; $ern30=str_replace(".",",",$rn30);
$rk31=$hlavicka->rk31; $erk31=str_replace(".",",",$rk31); $rn31=$hlavicka->rn31; $ern31=str_replace(".",",",$rn31);
$rk32=$hlavicka->rk32; $erk32=str_replace(".",",",$rk32); $rn32=$hlavicka->rn32; $ern32=str_replace(".",",",$rn32);
$rk33=$hlavicka->rk33; $erk33=str_replace(".",",",$rk33); $rn33=$hlavicka->rn33; $ern33=str_replace(".",",",$rn33);
$rk34=$hlavicka->rk34; $erk34=str_replace(".",",",$rk34); $rn34=$hlavicka->rn34; $ern34=str_replace(".",",",$rn34);
$rk35=$hlavicka->rk35; $erk35=str_replace(".",",",$rk35); $rn35=$hlavicka->rn35; $ern35=str_replace(".",",",$rn35);
$rk36=$hlavicka->rk36; $erk36=str_replace(".",",",$rk36); $rn36=$hlavicka->rn36; $ern36=str_replace(".",",",$rn36);
$rk37=$hlavicka->rk37; $erk37=str_replace(".",",",$rk37); $rn37=$hlavicka->rn37; $ern37=str_replace(".",",",$rn37);
$rk38=$hlavicka->rk38; $erk38=str_replace(".",",",$rk38); $rn38=$hlavicka->rn38; $ern38=str_replace(".",",",$rn38);
$rk39=$hlavicka->rk39; $erk39=str_replace(".",",",$rk39); $rn39=$hlavicka->rn39; $ern39=str_replace(".",",",$rn39);

$rk40=$hlavicka->rk40; $erk40=str_replace(".",",",$rk40); $rn40=$hlavicka->rn40; $ern40=str_replace(".",",",$rn40);
$rk41=$hlavicka->rk41; $erk41=str_replace(".",",",$rk41); $rn41=$hlavicka->rn41; $ern41=str_replace(".",",",$rn41);
$rk42=$hlavicka->rk42; $erk42=str_replace(".",",",$rk42); $rn42=$hlavicka->rn42; $ern42=str_replace(".",",",$rn42);
$rk43=$hlavicka->rk43; $erk43=str_replace(".",",",$rk43); $rn43=$hlavicka->rn43; $ern43=str_replace(".",",",$rn43);
$rk44=$hlavicka->rk44; $erk44=str_replace(".",",",$rk44); $rn44=$hlavicka->rn44; $ern44=str_replace(".",",",$rn44);
$rk45=$hlavicka->rk45; $erk45=str_replace(".",",",$rk45); $rn45=$hlavicka->rn45; $ern45=str_replace(".",",",$rn45);
$rk46=$hlavicka->rk46; $erk46=str_replace(".",",",$rk46); $rn46=$hlavicka->rn46; $ern46=str_replace(".",",",$rn46);
$rk47=$hlavicka->rk47; $erk47=str_replace(".",",",$rk47); $rn47=$hlavicka->rn47; $ern47=str_replace(".",",",$rn47);
$rk48=$hlavicka->rk48; $erk48=str_replace(".",",",$rk48); $rn48=$hlavicka->rn48; $ern48=str_replace(".",",",$rn48);
$rk49=$hlavicka->rk49; $erk49=str_replace(".",",",$rk49); $rn49=$hlavicka->rn49; $ern49=str_replace(".",",",$rn49);

$rk50=$hlavicka->rk50; $erk50=str_replace(".",",",$rk50); $rn50=$hlavicka->rn50; $ern50=str_replace(".",",",$rn50);
$rk51=$hlavicka->rk51; $erk51=str_replace(".",",",$rk51); $rn51=$hlavicka->rn51; $ern51=str_replace(".",",",$rn51);
$rk52=$hlavicka->rk52; $erk52=str_replace(".",",",$rk52); $rn52=$hlavicka->rn52; $ern52=str_replace(".",",",$rn52);
$rk53=$hlavicka->rk53; $erk53=str_replace(".",",",$rk53); $rn53=$hlavicka->rn53; $ern53=str_replace(".",",",$rn53);
$rk54=$hlavicka->rk54; $erk54=str_replace(".",",",$rk54); $rn54=$hlavicka->rn54; $ern54=str_replace(".",",",$rn54);
$rk55=$hlavicka->rk55; $erk55=str_replace(".",",",$rk55); $rn55=$hlavicka->rn55; $ern55=str_replace(".",",",$rn55);
$rk56=$hlavicka->rk56; $erk56=str_replace(".",",",$rk56); $rn56=$hlavicka->rn56; $ern56=str_replace(".",",",$rn56);
$rk57=$hlavicka->rk57; $erk57=str_replace(".",",",$rk57); $rn57=$hlavicka->rn57; $ern57=str_replace(".",",",$rn57);
$rk58=$hlavicka->rk58; $erk58=str_replace(".",",",$rk58); $rn58=$hlavicka->rn58; $ern58=str_replace(".",",",$rn58);
$rk59=$hlavicka->rk59; $erk59=str_replace(".",",",$rk59); $rn59=$hlavicka->rn59; $ern59=str_replace(".",",",$rn59);

$rk60=$hlavicka->rk60; $erk60=str_replace(".",",",$rk60); $rn60=$hlavicka->rn60; $ern60=str_replace(".",",",$rn60);
$rk61=$hlavicka->rk61; $erk61=str_replace(".",",",$rk61); $rn61=$hlavicka->rn61; $ern61=str_replace(".",",",$rn61);
$rk62=$hlavicka->rk62; $erk62=str_replace(".",",",$rk62); $rn62=$hlavicka->rn62; $ern62=str_replace(".",",",$rn62);
$rk63=$hlavicka->rk63; $erk63=str_replace(".",",",$rk63); $rn63=$hlavicka->rn63; $ern63=str_replace(".",",",$rn63);
$rk64=$hlavicka->rk64; $erk64=str_replace(".",",",$rk64); $rn64=$hlavicka->rn64; $ern64=str_replace(".",",",$rn64);
$rk65=$hlavicka->rk65; $erk65=str_replace(".",",",$rk65); $rn65=$hlavicka->rn65; $ern65=str_replace(".",",",$rn65);
$rk66=$hlavicka->rk66; $erk66=str_replace(".",",",$rk66); $rn66=$hlavicka->rn66; $ern66=str_replace(".",",",$rn66);
$rk67=$hlavicka->rk67; $erk67=str_replace(".",",",$rk67); $rn67=$hlavicka->rn67; $ern67=str_replace(".",",",$rn67);
$rk68=$hlavicka->rk68; $erk68=str_replace(".",",",$rk68); $rn68=$hlavicka->rn68; $ern68=str_replace(".",",",$rn68);
$rk69=$hlavicka->rk69; $erk69=str_replace(".",",",$rk69); $rn69=$hlavicka->rn69; $ern69=str_replace(".",",",$rn69);

$rk70=$hlavicka->rk70; $erk70=str_replace(".",",",$rk70); $rn70=$hlavicka->rn70; $ern70=str_replace(".",",",$rn70);
$rk71=$hlavicka->rk71; $erk71=str_replace(".",",",$rk71); $rn71=$hlavicka->rn71; $ern71=str_replace(".",",",$rn71);
$rk72=$hlavicka->rk72; $erk72=str_replace(".",",",$rk72); $rn72=$hlavicka->rn72; $ern72=str_replace(".",",",$rn72);
$rk73=$hlavicka->rk73; $erk73=str_replace(".",",",$rk73); $rn73=$hlavicka->rn73; $ern73=str_replace(".",",",$rn73);
$rk74=$hlavicka->rk74; $erk74=str_replace(".",",",$rk74); $rn74=$hlavicka->rn74; $ern74=str_replace(".",",",$rn74);
$rk75=$hlavicka->rk75; $erk75=str_replace(".",",",$rk75); $rn75=$hlavicka->rn75; $ern75=str_replace(".",",",$rn75);
$rk76=$hlavicka->rk76; $erk76=str_replace(".",",",$rk76); $rn76=$hlavicka->rn76; $ern76=str_replace(".",",",$rn76);
$rk77=$hlavicka->rk77; $erk77=str_replace(".",",",$rk77); $rn77=$hlavicka->rn77; $ern77=str_replace(".",",",$rn77);
$rk78=$hlavicka->rk78; $erk78=str_replace(".",",",$rk78); $rn78=$hlavicka->rn78; $ern78=str_replace(".",",",$rn78);
$rk79=$hlavicka->rk79; $erk79=str_replace(".",",",$rk79); $rn79=$hlavicka->rn79; $ern79=str_replace(".",",",$rn79);

$rk80=$hlavicka->rk80; $erk80=str_replace(".",",",$rk80); $rn80=$hlavicka->rn80; $ern80=str_replace(".",",",$rn80);
$rk81=$hlavicka->rk81; $erk81=str_replace(".",",",$rk81); $rn81=$hlavicka->rn81; $ern81=str_replace(".",",",$rn81);
$rk82=$hlavicka->rk82; $erk82=str_replace(".",",",$rk82); $rn82=$hlavicka->rn82; $ern82=str_replace(".",",",$rn82);
$rk83=$hlavicka->rk83; $erk83=str_replace(".",",",$rk83); $rn83=$hlavicka->rn83; $ern83=str_replace(".",",",$rn83);
$rk84=$hlavicka->rk84; $erk84=str_replace(".",",",$rk84); $rn84=$hlavicka->rn84; $ern84=str_replace(".",",",$rn84);
$rk85=$hlavicka->rk85; $erk85=str_replace(".",",",$rk85); $rn85=$hlavicka->rn85; $ern85=str_replace(".",",",$rn85);
$rk86=$hlavicka->rk86; $erk86=str_replace(".",",",$rk86); $rn86=$hlavicka->rn86; $ern86=str_replace(".",",",$rn86);
$rk87=$hlavicka->rk87; $erk87=str_replace(".",",",$rk87); $rn87=$hlavicka->rn87; $ern87=str_replace(".",",",$rn87);
$rk88=$hlavicka->rk88; $erk88=str_replace(".",",",$rk88); $rn88=$hlavicka->rn88; $ern88=str_replace(".",",",$rn88);
$rk89=$hlavicka->rk89; $erk89=str_replace(".",",",$rk89); $rn89=$hlavicka->rn89; $ern89=str_replace(".",",",$rn89);

$rk90=$hlavicka->rk90; $erk90=str_replace(".",",",$rk90); $rn90=$hlavicka->rn90; $ern90=str_replace(".",",",$rn90);
$rk91=$hlavicka->rk91; $erk91=str_replace(".",",",$rk91); $rn91=$hlavicka->rn91; $ern91=str_replace(".",",",$rn91);
$rk92=$hlavicka->rk92; $erk92=str_replace(".",",",$rk92); $rn92=$hlavicka->rn92; $ern92=str_replace(".",",",$rn92);
$rk93=$hlavicka->rk93; $erk93=str_replace(".",",",$rk93); $rn93=$hlavicka->rn93; $ern93=str_replace(".",",",$rn93);
$rk94=$hlavicka->rk94; $erk94=str_replace(".",",",$rk94); $rn94=$hlavicka->rn94; $ern94=str_replace(".",",",$rn94);
$rk95=$hlavicka->rk95; $erk95=str_replace(".",",",$rk95); $rn95=$hlavicka->rn95; $ern95=str_replace(".",",",$rn95);
$rk96=$hlavicka->rk96; $erk96=str_replace(".",",",$rk96); $rn96=$hlavicka->rn96; $ern96=str_replace(".",",",$rn96);
$rk97=$hlavicka->rk97; $erk97=str_replace(".",",",$rk97); $rn97=$hlavicka->rn97; $ern97=str_replace(".",",",$rn97);
$rk98=$hlavicka->rk98; $erk98=str_replace(".",",",$rk98); $rn98=$hlavicka->rn98; $ern98=str_replace(".",",",$rn98);
$rk99=$hlavicka->rk99; $erk99=str_replace(".",",",$rk99); $rn99=$hlavicka->rn99; $ern99=str_replace(".",",",$rn99);

$rk100=$hlavicka->rk100; $erk100=str_replace(".",",",$rk100); $rn100=$hlavicka->rn100; $ern100=str_replace(".",",",$rn100);
$rk101=$hlavicka->rk101; $erk101=str_replace(".",",",$rk101); $rn101=$hlavicka->rn101; $ern101=str_replace(".",",",$rn101);
$rk102=$hlavicka->rk102; $erk102=str_replace(".",",",$rk102); $rn102=$hlavicka->rn102; $ern102=str_replace(".",",",$rn102);
$rk103=$hlavicka->rk103; $erk103=str_replace(".",",",$rk103); $rn103=$hlavicka->rn103; $ern103=str_replace(".",",",$rn103);
$rk104=$hlavicka->rk104; $erk104=str_replace(".",",",$rk104); $rn104=$hlavicka->rn104; $ern104=str_replace(".",",",$rn104);
$rk105=$hlavicka->rk105; $erk105=str_replace(".",",",$rk105); $rn105=$hlavicka->rn105; $ern105=str_replace(".",",",$rn105);
$rk106=$hlavicka->rk106; $erk106=str_replace(".",",",$rk106); $rn106=$hlavicka->rn106; $ern106=str_replace(".",",",$rn106);
$rk107=$hlavicka->rk107; $erk107=str_replace(".",",",$rk107); $rn107=$hlavicka->rn107; $ern107=str_replace(".",",",$rn107);
$rk108=$hlavicka->rk108; $erk108=str_replace(".",",",$rk108); $rn108=$hlavicka->rn108; $ern108=str_replace(".",",",$rn108);
$rk109=$hlavicka->rk109; $erk109=str_replace(".",",",$rk109); $rn109=$hlavicka->rn109; $ern109=str_replace(".",",",$rn109);

$rk110=$hlavicka->rk110; $erk110=str_replace(".",",",$rk110); $rn110=$hlavicka->rn110; $ern110=str_replace(".",",",$rn110);
$rk111=$hlavicka->rk111; $erk111=str_replace(".",",",$rk111); $rn111=$hlavicka->rn111; $ern111=str_replace(".",",",$rn111);
$rk112=$hlavicka->rk112; $erk112=str_replace(".",",",$rk112); $rn112=$hlavicka->rn112; $ern112=str_replace(".",",",$rn112);
$rk113=$hlavicka->rk113; $erk113=str_replace(".",",",$rk113); $rn113=$hlavicka->rn113; $ern113=str_replace(".",",",$rn113);
$rk114=$hlavicka->rk114; $erk114=str_replace(".",",",$rk114); $rn114=$hlavicka->rn114; $ern114=str_replace(".",",",$rn114);
$rk115=$hlavicka->rk115; $erk115=str_replace(".",",",$rk115); $rn115=$hlavicka->rn115; $ern115=str_replace(".",",",$rn115);
$rk116=$hlavicka->rk116; $erk116=str_replace(".",",",$rk116); $rn116=$hlavicka->rn116; $ern116=str_replace(".",",",$rn116);
$rk117=$hlavicka->rk117; $erk117=str_replace(".",",",$rk117); $rn117=$hlavicka->rn117; $ern117=str_replace(".",",",$rn117);
$rk118=$hlavicka->rk118; $erk118=str_replace(".",",",$rk118); $rn118=$hlavicka->rn118; $ern118=str_replace(".",",",$rn118);
$rk119=$hlavicka->rk119; $erk119=str_replace(".",",",$rk119); $rn119=$hlavicka->rn119; $ern119=str_replace(".",",",$rn119);

$rk120=$hlavicka->rk120; $erk120=str_replace(".",",",$rk120); $rn120=$hlavicka->rn120; $ern120=str_replace(".",",",$rn120);
$rk121=$hlavicka->rk121; $erk121=str_replace(".",",",$rk121); $rn121=$hlavicka->rn121; $ern121=str_replace(".",",",$rn121);
$rk122=$hlavicka->rk122; $erk122=str_replace(".",",",$rk122); $rn122=$hlavicka->rn122; $ern122=str_replace(".",",",$rn122);
$rk123=$hlavicka->rk123; $erk123=str_replace(".",",",$rk123); $rn123=$hlavicka->rn123; $ern123=str_replace(".",",",$rn123);
$rk124=$hlavicka->rk124; $erk124=str_replace(".",",",$rk124); $rn124=$hlavicka->rn124; $ern124=str_replace(".",",",$rn124);
$rk125=$hlavicka->rk125; $erk125=str_replace(".",",",$rk125); $rn125=$hlavicka->rn125; $ern125=str_replace(".",",",$rn125);
$rk126=$hlavicka->rk126; $erk126=str_replace(".",",",$rk126); $rn126=$hlavicka->rn126; $ern126=str_replace(".",",",$rn126);
$rk127=$hlavicka->rk127; $erk127=str_replace(".",",",$rk127); $rn127=$hlavicka->rn127; $ern127=str_replace(".",",",$rn127);
$rk128=$hlavicka->rk128; $erk128=str_replace(".",",",$rk128); $rn128=$hlavicka->rn128; $ern128=str_replace(".",",",$rn128);
$rk129=$hlavicka->rk129; $erk129=str_replace(".",",",$rk129); $rn129=$hlavicka->rn129; $ern129=str_replace(".",",",$rn129);

if( $i == 0 )
     {
  $text = "riadok".";"."brutto".";"."korekcia".";"."netto".";"."predch.obdobie"."\r\n"; 

  fwrite($soubor, $text);

     }

  $text = "01;".$er01.";".$erk01.";".$ern01.";".$erm01."\r\n"; 
  $text = $text."02;".$er02.";".$erk02.";".$ern02.";".$erm02."\r\n"; 
  $text = $text."03;".$er03.";".$erk03.";".$ern03.";".$erm03."\r\n"; 
  $text = $text."04;".$er04.";".$erk04.";".$ern04.";".$erm04."\r\n"; 
  $text = $text."05;".$er05.";".$erk05.";".$ern05.";".$erm05."\r\n"; 
  $text = $text."06;".$er06.";".$erk06.";".$ern06.";".$erm06."\r\n"; 
  $text = $text."07;".$er07.";".$erk07.";".$ern07.";".$erm07."\r\n"; 
  $text = $text."08;".$er08.";".$erk08.";".$ern08.";".$erm08."\r\n"; 
  $text = $text."09;".$er09.";".$erk09.";".$ern09.";".$erm09."\r\n"; 

  $text = $text."10;".$er10.";".$erk10.";".$ern10.";".$erm10."\r\n"; 
  $text = $text."11;".$er11.";".$erk11.";".$ern11.";".$erm11."\r\n"; 
  $text = $text."12;".$er12.";".$erk12.";".$ern12.";".$erm12."\r\n"; 
  $text = $text."13;".$er13.";".$erk13.";".$ern13.";".$erm13."\r\n"; 
  $text = $text."14;".$er14.";".$erk14.";".$ern14.";".$erm14."\r\n"; 
  $text = $text."15;".$er15.";".$erk15.";".$ern15.";".$erm15."\r\n"; 
  $text = $text."16;".$er16.";".$erk16.";".$ern16.";".$erm16."\r\n"; 
  $text = $text."17;".$er17.";".$erk17.";".$ern17.";".$erm17."\r\n"; 
  $text = $text."18;".$er18.";".$erk18.";".$ern18.";".$erm18."\r\n"; 
  $text = $text."19;".$er19.";".$erk19.";".$ern19.";".$erm19."\r\n"; 

  $text = $text."20;".$er20.";".$erk20.";".$ern20.";".$erm20."\r\n"; 
  $text = $text."21;".$er21.";".$erk21.";".$ern21.";".$erm21."\r\n"; 
  $text = $text."22;".$er22.";".$erk22.";".$ern22.";".$erm22."\r\n"; 
  $text = $text."23;".$er23.";".$erk23.";".$ern23.";".$erm23."\r\n"; 
  $text = $text."24;".$er24.";".$erk24.";".$ern24.";".$erm24."\r\n"; 
  $text = $text."25;".$er25.";".$erk25.";".$ern25.";".$erm25."\r\n"; 
  $text = $text."26;".$er26.";".$erk26.";".$ern26.";".$erm26."\r\n"; 
  $text = $text."27;".$er27.";".$erk27.";".$ern27.";".$erm27."\r\n"; 
  $text = $text."28;".$er28.";".$erk28.";".$ern28.";".$erm28."\r\n"; 
  $text = $text."29;".$er29.";".$erk29.";".$ern29.";".$erm29."\r\n"; 

  $text = $text."30;".$er30.";".$erk30.";".$ern30.";".$erm30."\r\n"; 
  $text = $text."31;".$er31.";".$erk31.";".$ern31.";".$erm31."\r\n"; 
  $text = $text."32;".$er32.";".$erk32.";".$ern32.";".$erm32."\r\n"; 
  $text = $text."33;".$er33.";".$erk33.";".$ern33.";".$erm33."\r\n"; 
  $text = $text."34;".$er34.";".$erk34.";".$ern34.";".$erm34."\r\n"; 
  $text = $text."35;".$er35.";".$erk35.";".$ern35.";".$erm35."\r\n"; 
  $text = $text."36;".$er36.";".$erk36.";".$ern36.";".$erm36."\r\n"; 
  $text = $text."37;".$er37.";".$erk37.";".$ern37.";".$erm37."\r\n"; 
  $text = $text."38;".$er38.";".$erk38.";".$ern38.";".$erm38."\r\n"; 
  $text = $text."39;".$er39.";".$erk39.";".$ern39.";".$erm39."\r\n"; 

  $text = $text."40;".$er40.";".$erk40.";".$ern40.";".$erm40."\r\n"; 
  $text = $text."41;".$er41.";".$erk41.";".$ern41.";".$erm41."\r\n"; 
  $text = $text."42;".$er42.";".$erk42.";".$ern42.";".$erm42."\r\n"; 
  $text = $text."43;".$er43.";".$erk43.";".$ern43.";".$erm43."\r\n"; 
  $text = $text."44;".$er44.";".$erk44.";".$ern44.";".$erm44."\r\n"; 
  $text = $text."45;".$er45.";".$erk45.";".$ern45.";".$erm45."\r\n"; 
  $text = $text."46;".$er46.";".$erk46.";".$ern46.";".$erm46."\r\n"; 
  $text = $text."47;".$er47.";".$erk47.";".$ern47.";".$erm47."\r\n"; 
  $text = $text."48;".$er48.";".$erk48.";".$ern48.";".$erm48."\r\n"; 
  $text = $text."49;".$er49.";".$erk49.";".$ern49.";".$erm49."\r\n"; 

  $text = $text."50;".$er50.";".$erk50.";".$ern50.";".$erm50."\r\n"; 
  $text = $text."51;".$er51.";".$erk51.";".$ern51.";".$erm51."\r\n"; 
  $text = $text."52;".$er52.";".$erk52.";".$ern52.";".$erm52."\r\n"; 
  $text = $text."53;".$er53.";".$erk53.";".$ern53.";".$erm53."\r\n"; 
  $text = $text."54;".$er54.";".$erk54.";".$ern54.";".$erm54."\r\n"; 
  $text = $text."55;".$er55.";".$erk55.";".$ern55.";".$erm55."\r\n"; 
  $text = $text."56;".$er56.";".$erk56.";".$ern56.";".$erm56."\r\n"; 
  $text = $text."57;".$er57.";".$erk57.";".$ern57.";".$erm57."\r\n"; 
  $text = $text."58;".$er58.";".$erk58.";".$ern58.";".$erm58."\r\n"; 
  $text = $text."59;".$er59.";".$erk59.";".$ern59.";".$erm59."\r\n"; 

  $text = $text."60;".$er60.";".$erk60.";".$ern60.";".$erm60."\r\n"; 
  $text = $text."61;".$er61.";".$erk61.";".$ern61.";".$erm61."\r\n"; 
  $text = $text."62;".$er62.";".$erk62.";".$ern62.";".$erm62."\r\n"; 
  $text = $text."63;".$er63.";".$erk63.";".$ern63.";".$erm63."\r\n"; 
  $text = $text."64;".$er64.";".$erk64.";".$ern64.";".$erm64."\r\n"; 
  $text = $text."65;".$er65.";".$erk65.";".$ern65.";".$erm65."\r\n"; 
  $text = $text."66;".$er66.";".$erk66.";".$ern66.";".$erm66."\r\n"; 
  $text = $text."67;".$er67.";".$erk67.";".$ern67.";".$erm67."\r\n"; 
  $text = $text."68;".$er68.";".$erk68.";".$ern68.";".$erm68."\r\n"; 
  $text = $text."69;".$er69.";".$erk69.";".$ern69.";".$erm69."\r\n"; 

  $text = $text."70;".$er70.";".$erk70.";".$ern70.";".$erm70."\r\n"; 
  $text = $text."71;".$er71.";".$erk71.";".$ern71.";".$erm71."\r\n"; 
  $text = $text."72;".$er72.";".$erk72.";".$ern72.";".$erm72."\r\n"; 
  $text = $text."73;".$er73.";".$erk73.";".$ern73.";".$erm73."\r\n"; 
  $text = $text."74;".$er74.";".$erk74.";".$ern74.";".$erm74."\r\n"; 
  $text = $text."75;".$er75.";".$erk75.";".$ern75.";".$erm75."\r\n"; 
  $text = $text."76;".$er76.";".$erk76.";".$ern76.";".$erm76."\r\n"; 
  $text = $text."77;".$er77.";".$erk77.";".$ern77.";".$erm77."\r\n"; 
  $text = $text."78;".$er78.";".$erk78.";".$ern78.";".$erm78."\r\n"; 
  $text = $text."79;".$er79.";".$erk79.";".$ern79.";".$erm79."\r\n"; 

  $text = $text."80;".$er80.";".$erk80.";".$ern80.";".$erm80."\r\n"; 
  $text = $text."81;".$er81.";".$erk81.";".$ern81.";".$erm81."\r\n"; 
  $text = $text."82;".$er82.";".$erk82.";".$ern82.";".$erm82."\r\n"; 
  $text = $text."83;".$er83.";".$erk83.";".$ern83.";".$erm83."\r\n"; 
  $text = $text."84;".$er84.";".$erk84.";".$ern84.";".$erm84."\r\n"; 
  $text = $text."85;".$er85.";".$erk85.";".$ern85.";".$erm85."\r\n"; 
  $text = $text."86;".$er86.";".$erk86.";".$ern86.";".$erm86."\r\n"; 
  $text = $text."87;".$er87.";".$erk87.";".$ern87.";".$erm87."\r\n"; 
  $text = $text."88;".$er88.";".$erk88.";".$ern88.";".$erm88."\r\n"; 
  $text = $text."89;".$er89.";".$erk89.";".$ern89.";".$erm89."\r\n"; 

  $text = $text."90;".$er90.";".$erk90.";".$ern90.";".$erm90."\r\n"; 
  $text = $text."91;".$er91.";".$erk91.";".$ern91.";".$erm91."\r\n"; 
  $text = $text."92;".$er92.";".$erk92.";".$ern92.";".$erm92."\r\n"; 
  $text = $text."93;".$er93.";".$erk93.";".$ern93.";".$erm93."\r\n"; 
  $text = $text."94;".$er94.";".$erk94.";".$ern94.";".$erm94."\r\n"; 
  $text = $text."95;".$er95.";".$erk95.";".$ern95.";".$erm95."\r\n"; 
  $text = $text."96;".$er96.";".$erk96.";".$ern96.";".$erm96."\r\n"; 
  $text = $text."97;".$er97.";".$erk97.";".$ern97.";".$erm97."\r\n"; 
  $text = $text."98;".$er98.";".$erk98.";".$ern98.";".$erm98."\r\n"; 
  $text = $text."99;".$er99.";".$erk99.";".$ern99.";".$erm99."\r\n"; 

  $text = $text."100;".$er100.";".$erk100.";".$ern100.";".$erm100."\r\n"; 
  $text = $text."101;".$er101.";".$erk101.";".$ern101.";".$erm101."\r\n"; 
  $text = $text."102;".$er102.";".$erk102.";".$ern102.";".$erm102."\r\n"; 
  $text = $text."103;".$er103.";".$erk103.";".$ern103.";".$erm103."\r\n"; 
  $text = $text."104;".$er104.";".$erk104.";".$ern104.";".$erm104."\r\n"; 


  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//koniec ak existuje suvor
                                                              }
}
///////////////////////////////////////////////////KONIEC SUBORU SUVAHA NO



///////////////////////////////////////////////////VYTVORENIE SUBORU SUVAHA mala
if( $copern == 50 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="suv";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");


$sqltt = "SELECT ".
" F$kli_vxcf"."_prcuobratsx$kli_uzid.uce, F$kli_vxcf"."_uctosnova.nuc, F$kli_vxcf"."_prcuobratsx$kli_uzid.pmd, pdl,".
" bmd,bdl,omd,odl,zmd,zdl,ur1,uro,ico,fak ".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".uce=F$kli_vxcf"."_uctosnova.uce".
" WHERE ur1 = 999  ";
" ORDER BY cpl";
//echo $sqltt;


$sql = mysql_query("$sqltt");
if($sql)                                                      {
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$das_sk=SkDatum($hlavicka->das);
$dat_sk=SkDatum($hlavicka->dat);
$dau_sk=SkDatum($hlavicka->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk=$dau_sk;

if( $i == 0 )
     {
  $text = "ucet".";"."zostatok madat".";"."zostatok dal"."\r\n"; 

  fwrite($soubor, $text);

     }

$zmd=$hlavicka->zmd; $ezmd=str_replace(".",",",$zmd); 
$zdl=$hlavicka->zdl; $ezdl=str_replace(".",",",$zdl);
$zos=$hlavicka->zos; $ezos=str_replace(".",",",$zos);

  $text = $hlavicka->uce.";".$ezmd.";".$ezdl."\r\n"; 

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//koniec ak existuje subor
                                                              }
}
///////////////////////////////////////////////////KONIEC SUBORU SUVAHA mala


///////////////////////////////////////////////////VYTVORENIE SUBORU NEDOK
if( $copern == 310 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;

//echo "idem";
$nazsub="nedok";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");

$sqltt = "DELETE FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 != 999  ";
$sql = mysql_query("$sqltt");

$sqltt = "DELETE FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE str != 100  ";
$sql = mysql_query("$sqltt");

$sqltt = "DELETE FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE zak < 400 OR zak > 592  ";
$sql = mysql_query("$sqltt");


$sqltt = "UPDATE F$kli_vxcf"."_prcuobratsx$kli_uzid SET zak=zak-300 ";
$sql = mysql_query("$sqltt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" WHERE ( ur1 = 999 AND zmd != 0 ) ".
" ORDER BY str,zak,uce ";
//echo $sqltt;


$sql = mysql_query("$sqltt");
if($sql)                                                      {
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$das_sk=SkDatum($hlavicka->das);
$dat_sk=SkDatum($hlavicka->dat);
$dau_sk=SkDatum($hlavicka->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk=$dau_sk;

if( $i == 0 )
     {
  $text = "str".";"."zak".";"."ucm".";"."ucd".";"."hodnota".";"."\r\n"; 

  fwrite($soubor, $text);

     }

$zmd=$hlavicka->zmd; $ezmd=str_replace(".",",",$zmd); 
$zdl=$hlavicka->zdl; $ezdl=str_replace(".",",",$zdl);
$zos=$hlavicka->zos; $ezos=str_replace(".",",",$zos);

  $text = $hlavicka->str.";".$hlavicka->zak.";".$hlavicka->uce.";"."121100".";".$ezmd.";"."\r\n"; 

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" WHERE ( ur1 = 999 AND zdl != 0 ) ".
" ORDER BY str,zak,uce ";
//echo $sqltt;


$sql = mysql_query("$sqltt");                                                 
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$das_sk=SkDatum($hlavicka->das);
$dat_sk=SkDatum($hlavicka->dat);
$dau_sk=SkDatum($hlavicka->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk=$dau_sk;


$zmd=$hlavicka->zmd; $ezmd=str_replace(".",",",$zmd); 
$zdl=$hlavicka->zdl; $ezdl=str_replace(".",",",$zdl);
$zos=$hlavicka->zos; $ezos=str_replace(".",",",$zos);

  $text = $hlavicka->str.";".$hlavicka->zak.";"."121100".";".$hlavicka->uce.";".$ezdl.";"."\r\n"; 

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//koniec ak existuje subor
                                                              }
}
///////////////////////////////////////////////////KONIEC SUBORU NEDOK

///////////////////////////////////////////////////VYTVORENIE SUBORU VYSL mala
if( $copern == 40 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="vys";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");


$sqltt = "SELECT ".
" F$kli_vxcf"."_prcuobratsx$kli_uzid.uce, F$kli_vxcf"."_uctosnova.nuc, F$kli_vxcf"."_prcuobratsx$kli_uzid.pmd, pdl,".
" bmd,bdl,omd,odl,zmd,zdl,ur1,uro,ico,fak ".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".uce=F$kli_vxcf"."_uctosnova.uce".
" WHERE ur1 = 999  ";
" ORDER BY cpl";
//echo $sqltt;


$sql = mysql_query("$sqltt");
if($sql)                                                      {
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$das_sk=SkDatum($hlavicka->das);
$dat_sk=SkDatum($hlavicka->dat);
$dau_sk=SkDatum($hlavicka->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk=$dau_sk;

if( $i == 0 )
     {
  $text = "ucet".";"."zostatok madat".";"."zostatok dal"."\r\n"; 

  fwrite($soubor, $text);

     }

$zmd=$hlavicka->zmd; $ezmd=str_replace(".",",",$zmd); 
$zdl=$hlavicka->zdl; $ezdl=str_replace(".",",",$zdl);
$zos=$hlavicka->zos; $ezos=str_replace(".",",",$zos);

  $text = $hlavicka->uce.";".$ezmd.";".$ezdl."\r\n"; 

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//koniec ak existuje subor
                                                              }
}
///////////////////////////////////////////////////KONIEC SUBORU VYSL mala

//suvmala
if( $synt == 0 )
{
$sqltt = "SELECT ".
" F$kli_vxcf"."_prcuobratsx$kli_uzid.uce, F$kli_vxcf"."_uctosnova.nuc, F$kli_vxcf"."_prcuobratsx$kli_uzid.pmd, pdl,".
" bmd,bdl,omd,odl,zmd,zdl,ur1,uro,ico,fak ".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".uce=F$kli_vxcf"."_uctosnova.uce".
" WHERE ( ur1 = 999 OR ur1 = 998 OR uro = 998 OR uro = 997 OR uro = 1999 OR uro = 1888 ) ";
" ORDER BY cpl";
//echo $sqltt;
}
if( $synt == 1 )
{

$sqltt = "SELECT ".
" F$kli_vxcf"."_prcuobratsx$kli_uzid.uce, F$kli_vxcf"."_uctosnova.nuc, F$kli_vxcf"."_prcuobratsx$kli_uzid.pmd, pdl,".
" bmd,bdl,omd,odl,zmd,zdl,ur1,uro,ico,fak ".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".fak=F$kli_vxcf"."_uctosnova.uce".
" WHERE ( ur1 = 999 OR ur1 = 998 OR uro = 998 OR uro = 997 OR uro = 1999 OR uro = 1888 ) ";
" ORDER BY cpl";
//echo $sqltt;
}

//vysmala
if( $synt == 0 )
{
$sqltt = "SELECT ".
" F$kli_vxcf"."_prcuobratsx$kli_uzid.uce, F$kli_vxcf"."_uctosnova.nuc, F$kli_vxcf"."_prcuobratsx$kli_uzid.pmd, pdl,".
" bmd,bdl,omd,odl,zmd,zdl,ur1,uro,ico,fak ".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".uce=F$kli_vxcf"."_uctosnova.uce".
" WHERE ( ur1 = 999 OR ur1 = 998 OR uro = 998 OR uro = 997 OR uro = 1999 OR uro = 1888 ) ";
" ORDER BY cpl";
//echo $sqltt;
}
if( $synt == 1 )
{
$sqltt = "SELECT ".
" F$kli_vxcf"."_prcuobratsx$kli_uzid.uce, F$kli_vxcf"."_uctosnova.nuc, F$kli_vxcf"."_prcuobratsx$kli_uzid.pmd, pdl,".
" bmd,bdl,omd,odl,zmd,zdl,ur1,uro,ico,fak ".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".fak=F$kli_vxcf"."_uctosnova.uce".
" WHERE ( ur1 = 999 OR ur1 = 998 OR uro = 998 OR uro = 997 OR uro = 1999 OR uro = 1888 ) ";
" ORDER BY cpl";
//echo $sqltt;
}

?>
<?php
// celkovy koniec dokumentu

       } while (false);
?>
</BODY>
</HTML>
