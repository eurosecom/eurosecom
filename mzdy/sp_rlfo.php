<HTML>
<?php

do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$cislo_oc = $_REQUEST['cislo_oc'];
$h_kzmen = $_REQUEST['h_kzmen'];
$h_pzmen = $_REQUEST['h_pzmen'];
$h_dzmen = $_REQUEST['h_dzmen'];
$h_dvypl = $_REQUEST['h_dvypl'];

$h_al = 1*$_REQUEST['h_al'];

$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if(!isset($fort)) $fort = 1;

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$mzdkun="mzdkun";
if( $_SESSION['newzam'] == 1 ) { $mzdkun="mzdkunnewzam"; }
//echo $_SESSION['newzam'];

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$h_dzmensql = SqlDatum($h_dzmen);
$h_dzmen = SkDatum($h_dzmensql);
$h_dvyplsql = SqlDatum($h_dvypl);
$h_dvypl = SkDatum($h_dvyplsql);

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


$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));


?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>SP registraËn˝ list FO</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

function urobRLFO()
                {
var h_kzmen = document.forms.forms1.h_kzmen.value;
var h_pzmen = 0;
var h_dzmen = document.forms.forms1.h_dzmen.value;
var h_dvypl = document.forms.forms1.h_dvypl.value;
  var h_al = 0;
  if( document.forms.forms1.h_al.checked ) h_al=1;

window.open('sp_rlfo.php?h_al=' + h_al + '&h_kzmen=' + h_kzmen + '&h_pzmen=' + h_pzmen + '&h_dzmen=' + h_dzmen + '&h_dvypl=' + h_dvypl + '&copern=30&drupoh=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>',
 '_blank' ,'<?php echo $tlcuwin; ?>' );
                }

function pdfRLFO()
                {
var h_kzmen = document.forms.forms1.h_kzmen.value;
var h_pzmen = 0;
var h_dzmen = document.forms.forms1.h_dzmen.value;
var h_dvypl = document.forms.forms1.h_dvypl.value;

window.open('sp_rlfo.php?h_kzmen=' + h_kzmen + '&h_pzmen=' + h_pzmen + '&h_dzmen=' + h_dzmen + '&h_dvypl=' + h_dvypl + '&copern=40&drupoh=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>',
 '_blank' ,'<?php echo $tlcuwin; ?>' );
                }

function nastav()
                {

<?php if( $copern == 1 ) { ?>

document.forms.forms1.h_dzmen.value='<?php echo $dnes; ?>';
document.forms.forms1.h_dvypl.value='<?php echo $dnes; ?>';

<?php                    } ?>
                }
    
</script>
</HEAD>
<BODY class="white" id="white" onload="nastav();" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Komunik·cia so SP RLFO

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

<?php
$sqltt = "SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE oc = $cislo_oc";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);


  if (@$zaznam=mysql_data_seek($sql,0))
{
$polozka=mysql_fetch_object($sql);
?>

<table class="vstup" width="100%" >
<FORM name="forms1" class="obyc" method="post" action="#" >
<tr><td class="bmenu" width="30%">Firma:<td class="bmenu" width="50%"><?php echo $fir_fnaz.", ".$fir_fuli." ".$fir_fcdm.", ".$fir_fmes; ?></td>
<td class="bmenu" width="20%">ALL<input type="checkbox" name="h_al" value="1" /></td>
</tr>
<tr><td class="bmenu" width="30%">Zamestnanec:<td class="bmenu" width="50%">
<img src='../obr/uprav.png' width=15 height=15 border=0 title="⁄prava ˙dajov o zamestnancovi" onClick="window.open('zamestnanci.php?sys=MZD&copern=8&page=1&cislo_oc=<?php echo $cislo_oc;?>&h_oc=<?php echo $cislo_oc;?>','_self','<?php echo $tlcuwin; ?>')" >

<?php echo $polozka->titl." ".$polozka->meno." ".$polozka->prie; ?></td></tr>

<tr>
<td class="bmenu" width="30%">Druh RLFO:
<td class="bmenu" width="50%">
<select size="1" name="h_kzmen" id="h_kzmen" >
<option value="1" >Prihl·öka - pravideln˝ prÌjem</option>
<option value="2" >Odhl·öka</option>
<option value="10" >InÈ - len na papieri</option>
</select>
</tr>

<?php //este Prerusenie,Zmena,Zrusenie prihlasenia,MD,RD... ?>

<tr>
<td class="bmenu" width="30%">D·tum vzniku zmeny:
<td class="bmenu" width="50%">
<input type="text" name="h_dzmen" id="h_dzmen" size="10" /> v tvare napr. 04.08.2009
</tr>
<tr>
<td class="bmenu" width="30%">D·tum vyplnenia formul·ra:
<td class="bmenu" width="50%">
<input type="text" name="h_dvypl" id="h_dvypl" size="10" /> v tvare napr. 04.08.2009
</tr>

<tr>
<td class="bmenu" width="30%">
<button class="hvstup" height=10 onclick="urobRLFO();">
Vytvoriù RLFO elektronicky</button>
</tr>

<?php $ajpapier=0; ?>
<?php if( $ajpapier == 1 ) { ?>
<tr>
<td class="bmenu" width="30%">
<button class="hvstup" height=10 onclick="pdfRLFO();">
Vytvoriù RLFO na papieri</button>
</tr>
<?php                      } ?>

</FORM>

</table>



<br /><br /><br /><br />

<table class="vstup" width="100%" >

<tr>
<td class="bmenu" width="30%">
<button class="hvstup" height=10 
 onclick="window.open('zpdavka601.php?sys=<?php echo $sys; ?>&copern=1&cislo_oc=<?php echo $cislo_oc;?>','_self','<?php echo $tlcuwin; ?>');">
Prepn˙ù do Zdravotnej Poisùovne</button>

</tr>

</table>


<?php
}


?>





<?php
}
//koniec zakladnej ponuky
?>

<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU PRE ELEKTRONIKU PRIHLASKA
if( $copern == 30 AND $h_kzmen == 1 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;

$sqlt = <<<mzdprc
(
 
);
mzdprc;


$nazsub="rlfo_prihlasenie";


if (File_Exists ("../tmp/$nazsub.xml")) { $soubor = unlink("../tmp/$nazsub.xml"); }

$soubor = fopen("../tmp/$nazsub.xml", "a+");


//hlavicka
$podmoc="oc = $cislo_oc ";
$h_dzmensql=SqlDatum($h_dzmen);
if( $h_al == 1 ) { $podmoc=" dan = '$h_dzmensql' "; }
$sqltt = "SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE $podmoc ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if( $i == 0 ) {

  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n";
  fwrite($soubor, $text);


  $text = "<spRegListZec xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://socpoist.sk/xsd/rlzec2014 RLZEC-v2014.xsd\" xmlns=\"http://socpoist.sk/xsd/rlzec2014\">";
  fwrite($soubor, $text);
  $text = "<typDoc>RLZEC0001</typDoc>"."\r\n";
  fwrite($soubor, $text);


  $text = "      <zamestnavatel>"."\r\n";
  fwrite($soubor, $text);
  $text = "       <identifikacia>"."\r\n";
  fwrite($soubor, $text);

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  }

$nazov = iconv("CP1250", "UTF-8", $fir_fnaz);

  $text = "         <variabilnySymbol>".$cicz."</variabilnySymbol>	"."\r\n";
  fwrite($soubor, $text);

  $text = "         <identifikator>"."\r\n";
  fwrite($soubor, $text);

  $text = "         <dic>".$fir_fdic."</dic>	"."\r\n";
  fwrite($soubor, $text);

  $text = "         </identifikator>"."\r\n";
  fwrite($soubor, $text);

  $text = "         <nazov>".$nazov."</nazov>	"."\r\n";
  fwrite($soubor, $text);
  $text = "       </identifikacia>"."\r\n";
  fwrite($soubor, $text);
  $text = "       </zamestnavatel>"."\r\n";
  fwrite($soubor, $text);


  $text = "<zoznamRLZec>"."\r\n";
  fwrite($soubor, $text);

  $text = " <regListyZec>"."\r\n";
  fwrite($soubor, $text);
    

// koniec if i == 0
              }

//jeden list

  $text = "  <regListZec typRL=\"PA\">"."\r\n";
  fwrite($soubor, $text);

  $text = "  <identFO>"."\r\n";
  fwrite($soubor, $text);
  $text = "      <rc>".$hlavicka->rdc.$hlavicka->rdk."</rc>	"."\r\n";
  fwrite($soubor, $text);

$prie = iconv("CP1250", "UTF-8", $hlavicka->prie);
$meno = iconv("CP1250", "UTF-8", $hlavicka->meno);
$titl = iconv("CP1250", "UTF-8", $hlavicka->titl);
$rodn = iconv("CP1250", "UTF-8", $hlavicka->rodn);

  $text = "      <priezvisko>".$prie."</priezvisko>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      <meno>".$meno."</meno>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      <titulPred>".$titl."</titulPred>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      <titulZa>".$titlza."</titulZa>	"."\r\n";
  fwrite($soubor, $text);
  $text = "  </identFO>"."\r\n";
  fwrite($soubor, $text);


  $text = "  <typRegListuFO>"."\r\n";
  fwrite($soubor, $text);

  $text = "  <prihlaska>"."\r\n";
  fwrite($soubor, $text);



  $text = "  <identFODopl>"."\r\n";
  fwrite($soubor, $text);

$rodn = iconv("CP1250", "UTF-8", $hlavicka->rodn);
$mnar = iconv("CP1250", "UTF-8", $hlavicka->mnr);
$statp = "SK";


$dar=SkDatum($hlavicka->dar);

  $text = "      <rodPriezvisko>".$rodn."</rodPriezvisko>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      <datNarodenia>".$dar."</datNarodenia>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      <miestoNarodenia>".$mnar."</miestoNarodenia>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      <statP>".$statp."</statP>	"."\r\n";
  fwrite($soubor, $text);

$pohlavie = 1;
$mesrc=1*substr($hlavicka->rdc,2,2);
if( $mesrc > 12 ) { $pohlavie=2; }

  $text = "      <pohlavie>".$pohlavie."</pohlavie>	"."\r\n";
  fwrite($soubor, $text);

$stav="1";
//Rodinn˝ stav: 1 - slobodn˝(·), 2 - ûenat˝, vydat·, 3 - rozveden˝(·), 4 - vdova, vdovec, 5 - druh, druûka
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_vyhlaseniedane WHERE oc = $cislo_oc");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $stav=$riaddok->rdstav+1;
  if( $riaddok->rdstav == 2 ) $stav=4;
  if( $riaddok->rdstav == 3 ) $stav=3;
  }
if( $stav == 0 ) $stav=1;
  $text = "      <stav>".$stav."</stav>	"."\r\n";
  fwrite($soubor, $text);

  $text = "      <zamSUcastou>0</zamSUcastou>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      <par7ods2>0</par7ods2>	"."\r\n";
  fwrite($soubor, $text);

  $text = "  </identFODopl>"."\r\n";
  fwrite($soubor, $text);


  $text = "  <adresa>"."\r\n";
  fwrite($soubor, $text);

$ztel = iconv("CP1250", "UTF-8", $hlavicka->ztel);
$zuli = iconv("CP1250", "UTF-8", $hlavicka->zuli);
$zpsc = iconv("CP1250", "UTF-8", $hlavicka->zpsc);
$zmes = iconv("CP1250", "UTF-8", $hlavicka->zmes);
$zcdm = $hlavicka->zcdm;
$zstat = "SK";
$zema = iconv("CP1250", "UTF-8", $hlavicka->zema);

$pole = explode("/", $zcdm);
$zcdmx=1*$pole[0];
$zcdox=1*$pole[1];


  $text = "      <ulica>".$zuli."</ulica>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      <supCislo>".$zcdmx."</supCislo>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      <oCislo>".$zcdox."</oCislo>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      <obec>".$zmes."</obec>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      <psc>".$zpsc."</psc>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      <stat>".$zstat."</stat>	"."\r\n";
  fwrite($soubor, $text);

  $text = "  </adresa>"."\r\n";
  fwrite($soubor, $text);


  $text = "      <typPoistPrihl>	"."\r\n";
  fwrite($soubor, $text);

$typzec="ZEC";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpomer WHERE pm = $hlavicka->pom ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $typzec=$riaddok->pm3;
  }

  $text = "      <zecPrihl typZec=\"$typzec\">	"."\r\n";
  fwrite($soubor, $text);

$h_dzmensk=$h_dzmen;
$stat_prace="SK";

  $text = "      <ucet>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      <nazovSidloBanky>Banka</nazovSidloBanky>	"."\r\n";
  fwrite($soubor, $text);

$iban="";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $hlavicka->oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $iban=$riaddok->ziban;
  }

  $text = "      <iban>".$iban."</iban>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      </ucet>	"."\r\n";
  fwrite($soubor, $text);

  $text = "        <datVznikPoist>".$h_dzmensk."</datVznikPoist>	"."\r\n";
  fwrite($soubor, $text);
  $text = "        <statVykPrace>".$stat_prace."</statVykPrace>	"."\r\n";
  fwrite($soubor, $text);
  $text = "        <zecPomer>1</zecPomer>	"."\r\n";
  fwrite($soubor, $text);

  $text = "      </zecPrihl>	"."\r\n";
  fwrite($soubor, $text);

  $text = "      </typPoistPrihl>	"."\r\n";
  fwrite($soubor, $text);

  $text = "  </prihlaska>"."\r\n";
  fwrite($soubor, $text);

  $text = "  </typRegListuFO>"."\r\n";
  fwrite($soubor, $text);

  $text = "  </regListZec>"."\r\n";
  fwrite($soubor, $text);

//koniec jeden list

}
$i = $i + 1;
$j = $j + 1;
  }


  $text = " </regListyZec>"."\r\n";
  fwrite($soubor, $text);

  $text = "</zoznamRLZec>"."\r\n";
  fwrite($soubor, $text);

  $text = "  <vystavenie>"."\r\n";
  fwrite($soubor, $text);

$h_dvyplsk=$h_dvypl;

$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$priefosoba = trim($fir_riadok->fospprie);
$menofosoba = trim($fir_riadok->fospmeno);
$telfosoba = trim($fir_riadok->fosptel);
$mailfosoba = trim($fir_riadok->fospmail);
if ( $priefosoba == '' ) { $priefosoba="mzdov·"; }
if ( $menofosoba == '' ) { $menofosoba="˙Ët·reÚ"; }
if ( $telfosoba == '' ) { $telfosoba=$fir_ftel; }
if ( $mailfosoba == '' ) { $mailfosoba=$fir_fem1; }


$priefosoba=iconv("CP1250", "UTF-8", $priefosoba);
$menofosoba=iconv("CP1250", "UTF-8", $menofosoba);
$mailfosoba=iconv("CP1250", "UTF-8", $mailfosoba);

  $text = "   <zostavil>".$menofosoba." ".$priefosoba."</zostavil>	"."\r\n";
  fwrite($soubor, $text);
  $text = "   <tel>".$telfosoba."</tel>	"."\r\n";
  fwrite($soubor, $text);
  $text = "   <mail>".$mailfosoba."</mail>	"."\r\n";
  fwrite($soubor, $text);
  $text = "   <datumVyst>".$h_dvyplsk."</datumVyst>	"."\r\n";
  fwrite($soubor, $text);

  $text = "  </vystavenie>"."\r\n";
  fwrite($soubor, $text);

  $text = "</spRegListZec>"."\r\n";
  fwrite($soubor, $text);

}
//koniec $copern == 30 AND $h_kzmen == 1 PRIHLASKA
?>

<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU PRE ELEKTRONIKU ODHLASKA
if( $copern == 30 AND $h_kzmen == 2 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;

$sqlt = <<<mzdprc
(

);
mzdprc;


$nazsub="rlfo_odhlasenie";


if (File_Exists ("../tmp/$nazsub.xml")) { $soubor = unlink("../tmp/$nazsub.xml"); }

$soubor = fopen("../tmp/$nazsub.xml", "a+");


//hlavicka
$podmoc="oc = $cislo_oc ";
$h_dzmensql=SqlDatum($h_dzmen);
if( $h_al == 1 ) { $podmoc=" dav = '$h_dzmensql' "; }
$sqltt = "SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE $podmoc ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if( $i == 0 ) {

  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n";
  fwrite($soubor, $text);


  $text = "<spRegListZec xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://socpoist.sk/xsd/rlzec2014 RLZEC-v2014.xsd\" xmlns=\"http://socpoist.sk/xsd/rlzec2014\">";
  fwrite($soubor, $text);
  $text = "<typDoc>RLZEC0001</typDoc>"."\r\n";
  fwrite($soubor, $text);


  $text = "      <zamestnavatel>"."\r\n";
  fwrite($soubor, $text);
  $text = "       <identifikacia>"."\r\n";
  fwrite($soubor, $text);

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  }

$nazov = iconv("CP1250", "UTF-8", $fir_fnaz);

  $text = "         <variabilnySymbol>".$cicz."</variabilnySymbol>	"."\r\n";
  fwrite($soubor, $text);

  $text = "         <identifikator>"."\r\n";
  fwrite($soubor, $text);

  $text = "         <dic>".$fir_fdic."</dic>	"."\r\n";
  fwrite($soubor, $text);

  $text = "         </identifikator>"."\r\n";
  fwrite($soubor, $text);

  $text = "         <nazov>".$nazov."</nazov>	"."\r\n";
  fwrite($soubor, $text);
  $text = "       </identifikacia>"."\r\n";
  fwrite($soubor, $text);
  $text = "       </zamestnavatel>"."\r\n";
  fwrite($soubor, $text);

  $text = "<zoznamRLZec>"."\r\n";
  fwrite($soubor, $text);

  $text = " <regListyZec>"."\r\n";
  fwrite($soubor, $text);
    

// koniec if i == 0
              }

//jeden list

  $text = "  <regListZec typRL=\"OD\">"."\r\n";
  fwrite($soubor, $text);

  $text = "  <identFO>"."\r\n";
  fwrite($soubor, $text);
  $text = "      <rc>".$hlavicka->rdc.$hlavicka->rdk."</rc>	"."\r\n";
  fwrite($soubor, $text);

$prie = iconv("CP1250", "UTF-8", $hlavicka->prie);
$meno = iconv("CP1250", "UTF-8", $hlavicka->meno);
$titl = iconv("CP1250", "UTF-8", $hlavicka->titl);


  $text = "      <priezvisko>".$prie."</priezvisko>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      <meno>".$meno."</meno>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      <titulPred>".$titl."</titulPred>	"."\r\n";
  fwrite($soubor, $text);
  $text = "      <titulZa>".$titlza."</titulZa>	"."\r\n";
  fwrite($soubor, $text);
  $text = "  </identFO>"."\r\n";
  fwrite($soubor, $text);


  $text = "  <typRegListuFO>"."\r\n";
  fwrite($soubor, $text);

  $text = "  <odhlaska>"."\r\n";
  fwrite($soubor, $text);


  $text = "      <typPoistOdhl>	"."\r\n";
  fwrite($soubor, $text);

$typzec="ZEC";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpomer WHERE pm = $hlavicka->pom ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $typzec=$riaddok->pm3;
  }

  $text = "      <zecPPOdhl pracPomer=\"1\" typZec=\"$typzec\">	"."\r\n";
  fwrite($soubor, $text);

$h_dzmensk=$h_dzmen;
$h_dvznik=SkDatum($hlavicka->dan);

  $text = "        <zanik datVzniku=\"".$h_dvznik."\" datZaniku=\"".$h_dzmensk."\"></zanik>	"."\r\n"; 
  fwrite($soubor, $text);

  $text = "      </zecPPOdhl>	"."\r\n";
  fwrite($soubor, $text);

  $text = "      </typPoistOdhl>	"."\r\n";
  fwrite($soubor, $text);

  $text = "  </odhlaska>"."\r\n";
  fwrite($soubor, $text);

  $text = "  </typRegListuFO>"."\r\n";
  fwrite($soubor, $text);

  $text = "  </regListZec>"."\r\n";
  fwrite($soubor, $text);

//koniec jeden list

}
$i = $i + 1;
$j = $j + 1;
  }


  $text = " </regListyZec>"."\r\n";
  fwrite($soubor, $text);

  $text = "</zoznamRLZec>"."\r\n";
  fwrite($soubor, $text);

  $text = "  <vystavenie>"."\r\n";
  fwrite($soubor, $text);

$h_dvyplsk=$h_dvypl;

$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$priefosoba = trim($fir_riadok->fospprie);
$menofosoba = trim($fir_riadok->fospmeno);
$telfosoba = trim($fir_riadok->fosptel);
$mailfosoba = trim($fir_riadok->fospmail);
if ( $priefosoba == '' ) { $priefosoba="mzdov·"; }
if ( $menofosoba == '' ) { $menofosoba="˙Ët·reÚ"; }
if ( $telfosoba == '' ) { $telfosoba=$fir_ftel; }
if ( $mailfosoba == '' ) { $mailfosoba=$fir_fem1; }


$priefosoba=iconv("CP1250", "UTF-8", $priefosoba);
$menofosoba=iconv("CP1250", "UTF-8", $menofosoba);
$mailfosoba=iconv("CP1250", "UTF-8", $mailfosoba);

  $text = "   <zostavil>".$menofosoba." ".$priefosoba."</zostavil>	"."\r\n";
  fwrite($soubor, $text);
  $text = "   <tel>".$telfosoba."</tel>	"."\r\n";
  fwrite($soubor, $text);
  $text = "   <mail>".$mailfosoba."</mail>	"."\r\n";
  fwrite($soubor, $text);
  $text = "   <datumVyst>".$h_dvyplsk."</datumVyst>	"."\r\n";
  fwrite($soubor, $text);


  $text = "  </vystavenie>"."\r\n";
  fwrite($soubor, $text);

  $text = "</spRegListZec>"."\r\n";
  fwrite($soubor, $text);



}
//koniec $copern == 30 AND $h_kzmen == 2 ODHLASKA
?>

<?php
if( $copern == 30 AND ( $h_kzmen == 1 OR $h_kzmen == 2 ) )
{

fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.xml"><?php echo $nazsub; ?>.xml</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalmesx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzaltrnx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalkunx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

}
///////////////////////////////////////////////////KONIEC SUBORU PRE ELEKTRONIKU copern=30
?>


<?php
///////////////////////////////////////////////////VYTVORENIE PDF RLFO
if( $copern == 40 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


if (File_Exists ("../tmp/rlfo.$kli_uzid.pdf")) { $soubor = unlink("../tmp/rlfo.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$rmc=0;

//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE oc = $cislo_oc";
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

if( $j == 0 )
     {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(6); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/socpoist2011/rlfo.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/socpoist2011/rlfo.jpg',6,0,204,297); 
}

//vyplnenÈ pÌsacÌm strojom
$pdf->Cell(190,5,"                          ","$rmc",1,"L");

$text="x";


if( $h_kzmen == 1 ) $pr="x";
if( $h_kzmen == 2 ) $od="x";

//$pr="x"; $ps="x"; $zm="x"; $od="x"; $zp="x"; 

//prihl·öka
$pdf->Cell(4,6,"                          ","$rmc",0,"L");
$text=$pr;

$pdf->Cell(5,6," ","$rmc",0,"R");$pdf->Cell(3,5,"$text","$rmc",0,"L");

//preruöenie
$pdf->Cell(2,6,"                          ","$rmc",0,"L");
$text=$ps;

$pdf->Cell(10,6," ","$rmc",0,"R");$pdf->Cell(3,5,"$text","$rmc",0,"C");

//zmena
$pdf->Cell(2,6,"                          ","$rmc",0,"L");
$text=$zm;

$pdf->Cell(10,6," ","$rmc",0,"R");$pdf->Cell(3,5,"$text","$rmc",0,"C");

//odhl·öka
$pdf->Cell(2,6,"                          ","$rmc",0,"L");
$text=$od;

$pdf->Cell(9,6," ","$rmc",0,"R");$pdf->Cell(3,5,"$text","$rmc",0,"L");

//zruöenie prihl·senia
$pdf->Cell(2,6,"                          ","$rmc",0,"L");
$text=$zp;

$pdf->Cell(10,6," ","$rmc",0,"R");$pdf->Cell(3,5,"$text","$rmc",0,"L");

//zamestnanec prac. pomer
$pom=$hlavicka->pom;
$pp="x";
$doh=0;
$ppomer=1;

$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpomer WHERE pm = $pom ";

$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { 
$fir_riadok=mysql_fetch_object($fir_vysledok); 
$doh = $fir_riadok->pm_doh;
}


if( $doh == 1 ) {$pp=""; $dh="x"; $ppomer=""; }

//$pp="x"; 
//$np="x"; 
//$dh="x"; 

$pdf->Cell(2,6,"                          ","$rmc",0,"L");
$text=$pp;

$pdf->Cell(44,6," ","$rmc",0,"R");$pdf->Cell(2,5,"$text","$rmc",0,"L");

//zamestnanec dohoda
$pdf->Cell(6,6,"                          ","$rmc",0,"L");
$text=$dh;

$pdf->Cell(3,6," ","$rmc",0,"R");$pdf->Cell(3,5,"$text","$rmc",0,"L");

//SZ»O
$pdf->Cell(2,6,"                          ","$rmc",0,"L");
$text=" ";

$pdf->Cell(7,6," ","$rmc",0,"R");$pdf->Cell(3,5,"$text","$rmc",0,"C");

//DPO
$pdf->Cell(2,6,"                          ","$rmc",0,"L");
$text=" ";

$pdf->Cell(6,6," ","$rmc",0,"R");$pdf->Cell(3,5,"$text","$rmc",0,"L");

//FO, za kt. platÌ öt·t
$pdf->Cell(2,6,"                          ","$rmc",0,"L");
$text=" ";

$pdf->Cell(7,6," ","$rmc",0,"R");$pdf->Cell(3,5,"$text","$rmc",0,"L");

//typ
$pdf->Cell(2,6,"                          ","$rmc",0,"L");
$text=" ";

$pdf->Cell(21,6," ","$rmc",0,"R");$pdf->Cell(6,5,"$text","$rmc",1,"L");


//identifikaËnÈ ËÌslo icz
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  }

$pdf->Cell(190,8,"                          ","$rmc",1,"L");

$text=$cicz;

$pdf->Cell(159,6," ","$rmc",0,"R");$pdf->Cell(37,6,"$text","$rmc",1,"C");


//II. Identifik·cia FO
//Priezvisko
$pdf->Cell(190,15,"                          ","$rmc",1,"L");

$text=$hlavicka->prie;

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(75,6,"$text","$rmc",0,"L");

//Meno
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$hlavicka->meno;

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(42,6,"$text","$rmc",0,"L");

//Titul
$pdf->Cell(2,6,"                          ","$rmc",0,"L");

$text=$hlavicka->titl;

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(23,6,"$text","$rmc",0,"L");

//Pohlavie
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$pohlavie = 1;
$mesrc=1*substr($hlavicka->rdc,2,2);
if( $mesrc > 12 ) $pohlavie=2;

$text=$pohlavie;

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(7,6,"$text","$rmc",0,"C");

//R»
$pdf->Cell(2,6,"                          ","$rmc",0,"L");

$text=$hlavicka->rdc.$hlavicka->rdk;

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(37,6,"$text","$rmc",1,"C");


//III. Adresa a dopl. identifik. ˙daje FO
//Ulica
$pdf->Cell(190,7,"                          ","$rmc",1,"L");

$text=$hlavicka->zuli;

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(97,6,"$text","$rmc",0,"L");

//»Ìslo s˙pisnÈ
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$hlavicka->zcdm;

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(22,6,"$text","$rmc",0,"C");

//D·tum narodenia
$pdf->Cell(2,6,"                          ","$rmc",0,"L");

$text=SkDatum($hlavicka->dar);

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(29,6,"$text","$rmc",0,"C");

//ät·tna prÌsluönosù
$pdf->Cell(2,6,"                          ","$rmc",0,"L");

$text="SK";

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(37,6,"$text","$rmc",1,"C");

//Obec
$pdf->Cell(190,2,"                          ","$rmc",1,"L");

$text=$hlavicka->zmes;

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(97,6,"$text","$rmc",0,"L");

//PS»
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$hlavicka->zpsc;

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(22,6,"$text","$rmc",0,"C");

//Stav
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$stav=1;
$stav="1";
//Rodinn˝ stav: 1 - slobodn˝(·), 2 - ûenat˝, vydat·, 3 - rozveden˝(·), 4 - vdova, vdovec, 5 - druh, druûka
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_vyhlaseniedane WHERE oc = $cislo_oc");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $stav=$riaddok->rdstav+1;
  if( $riaddok->rdstav == 2 ) $stav=4;
  if( $riaddok->rdstav == 3 ) $stav=3;
  }
if( $stav == 0 ) $stav=1;

$text=$stav;

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(7,6,"$text","$rmc",0,"C");

//RodnÈ priezvisko
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$hlavicka->rodn;

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(61,6,"$text","$rmc",1,"L");

//ät·t
$pdf->Cell(190,2,"                          ","$rmc",1,"L");

$text="SK";

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(69,6,"$text","$rmc",0,"L");

//D·tum - poistnÈ na IP neplatÌ
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$hlavicka->datn;

$pdf->Cell(3,6," ","$rmc",0,"R");$pdf->Cell(48,6,"$text","$rmc",0,"L");

//DÙchodok
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$hlavicka->doch;
if( $text == 0 ) $text="";

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(7,6,"$text","$rmc",0,"L");

//Miesto narodenia
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$hlavicka->mnr;

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(61,6,"$text","$rmc",1,"L");


//IV. DoplÚuj˙ce ˙daje iba pre SZ»O
$pdf->Cell(0,6," ","$rmc",1,"L");

//KÛd Ëinnosti
$pdf->Cell(97,6,"                          ","$rmc",0,"L");

$text=" ";

$pdf->Cell(4,6," ","$rmc",0,"R");$pdf->Cell(7,6,"$text","$rmc",0,"L");



//I»O
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$fir_fico;

$pdf->Cell(10,6," ","$rmc",0,"R");$pdf->Cell(37,6,"$text","$rmc",0,"L");


//DIC
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$fir_fdic;

$pdf->Cell(6,6," ","$rmc",0,"R");$pdf->Cell(37,6,"$text","$rmc",1,"L");


//V. KoreöpondenËn· adresa FO
//Ulica
$pdf->Cell(190,7,"                          ","$rmc",1,"L");

$text=" ";

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(97,6,"$text","$rmc",0,"L");

//ËÌslo s˙pisnÈ
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=" ";

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(22,6,"$text","$rmc",0,"C");

//TelefÛn
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=" ";

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(71,6,"$text","$rmc",1,"L");

//Obec
$pdf->Cell(190,2,"                          ","$rmc",1,"L");

$text=" ";

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(97,6,"$text","$rmc",0,"L");

//PS»
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=" ";

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(22,6,"$text","$rmc",0,"C");

//Fax
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=" ";

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(71,6,"$text","$rmc",1,"L");

//ät·t
$pdf->Cell(190,3,"                          ","$rmc",1,"L");

$text=" ";

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(121,6,"$text","$rmc",0,"L");

//E-mail
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=" ";

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(71,6,"$text","$rmc",1,"L");


//VI. BankovÈ spojenie FO
//N·zov banky
$pdf->Cell(190,7,"                          ","$rmc",1,"L");

$text=" ";

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(121,6,"$text","$rmc",0,"L");

//»Ìslo ˙Ëtu
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$hlavicka->uceb." ".$hlavicka->numb;

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(71,6,"$text","$rmc",1,"L");


//VII. Z·kladn· identifik·cia zamestn·vateæa
//N·zov zamestn·vateæa
$pdf->Cell(190,7,"                          ","$rmc",1,"L");

$text=$fir_fnaz;

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(155,6,"$text","$rmc",0,"L");

//I»Z
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$cicz;

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(37,6,"$text","$rmc",1,"C");


//pokraË. n·zvu zamestn·vateæa
$pdf->Cell(190,2,"                          ","$rmc",1,"L");

$text=" ";

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(121,6,"$text","$rmc",0,"L");

//I»O
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text="x";

$pdf->Cell(12,6," ","$rmc",0,"R");$pdf->Cell(2,6,"$text","$rmc",0,"C");

//DI»
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text="";

$pdf->Cell(11,6," ","$rmc",0,"R");$pdf->Cell(2,6,"$text","$rmc",0,"C");

//I»O/DI»
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$fir_fico;

$pdf->Cell(6,6," ","$rmc",0,"R");$pdf->Cell(37,6,"$text","$rmc",1,"C");


//VIII. DoplÚuj˙ce identifikaËnÈ ˙daje zamestn·vateæa FO

$fomeno = "";
$foprie = "";
$fotitl = "";
$fordc = "";

if( $fir_uctt03 == 999 ) 
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";

$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fomeno = $fir_riadok->dmeno;
$foprie = $fir_riadok->dprie;
$fotitl = $fir_riadok->dtitl;
$fordc = $fir_riadok->rdc.$fir_riadok->rdk;

}



//Priezvisko (poslednÈ)
$pdf->Cell(190,7,"                          ","$rmc",1,"L");

$text=$foprie;

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(84,6,"$text","$rmc",0,"L");

//Meno
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$fomeno;

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(43,6,"$text","$rmc",0,"L");

//Titul
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$fotitl;

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(22,6,"$text","$rmc",0,"L");

//R»
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$fordc;

$pdf->Cell(6,6," ","$rmc",0,"R");$pdf->Cell(34,6,"$text","$rmc",1,"C");


//IX. Adresa zamestn·vateæa
//Ulica
$pdf->Cell(190,7,"                          ","$rmc",1,"L");

$text=$fir_fuli;

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(97,6,"$text","$rmc",0,"L");

//ËÌslo s˙pisnÈ
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$fir_fcdm;

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(22,6,"$text","$rmc",0,"C");

//TelefÛn
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$fir_ftel;

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(71,6,"$text","$rmc",1,"L");

//Obec
$pdf->Cell(190,2,"                          ","$rmc",1,"L");

$text=$fir_fmes;

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(97,6,"$text","$rmc",0,"L");

//PS»
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$fir_fpsc;

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(22,6,"$text","$rmc",0,"C");

//Fax
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$fir_ffax;

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(71,6,"$text","$rmc",1,"L");

//ät·t
$pdf->Cell(190,3,"                          ","$rmc",1,"L");

$text="SK";

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(121,6,"$text","$rmc",0,"L");

//E-mail
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$fir_fem1;

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(71,6,"$text","$rmc",1,"L");


//X. Obdobie poistenia
//D·tum vzniku poistenia
$pdf->Cell(190,7,"                          ","$rmc",1,"L");

if( $h_kzmen == 1 ) $datvp=$h_dzmen;
$text=$datvp;

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",0,"L");

//D·tum zruöenia prihl·senia
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$datzp;

$pdf->Cell(3,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",0,"L");

//D·tum vzniku preruöenia
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$datvpr;

$pdf->Cell(4,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",0,"L");

//DÙvod preruöenia
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$dp;

$pdf->Cell(4,6," ","$rmc",0,"R");$pdf->Cell(6,6,"$text","$rmc",0,"L");

//D·tum z·niku preruöenia
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$datzpr;

$pdf->Cell(4,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",0,"L");

//D·tum z·niku poistenia
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

if( $h_kzmen == 2 ) $datzp=$h_dzmen;
$text=$datzp;

$pdf->Cell(3,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",0,"L");

//Pracovn˝ pomer
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$pom=$ppomer;

$pdf->Cell(4,6," ","$rmc",0,"R");$pdf->Cell(5,6,"$pom","$rmc",1,"L");

//D·tum narodenia dieùaùa
$pdf->Cell(190,2,"                          ","$rmc",1,"L");

$text=$datnd;

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",0,"L");

//D·tum zaËiatku MD
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$datzm;

$pdf->Cell(3,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",0,"L");

//D·tum skonËenia MD
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$datsm;

$pdf->Cell(4,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",0,"L");

//D·tum zaËiatku RD
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$datzd;

$pdf->Cell(4,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",0,"L");

//D·tum skonËenia RD
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=$datsd;

$pdf->Cell(4,6," ","$rmc",0,"R");$pdf->Cell(31,6,"$text","$rmc",0,"L");

//V˝kon pr·ce v öt·te
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text="SK";

$pdf->Cell(5,6," ","$rmc",0,"R");$pdf->Cell(13,6,"$text","$rmc",1,"L");


//XI. Obdobie a vymeriavacÌ z·klad DPO
//D·tum vzniku NP
$pdf->Cell(190,9,"                          ","$rmc",1,"L");

$text=" ";

$pdf->Cell(26,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",0,"C");

//VymeriavacÌ z·klad NP
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=" ";

$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);

$pdf->Cell(24,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$A","$rmc",0,"R");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(2,6,"$B","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(2,6,"$C","$rmc",0,"C");

//D·tum z·niku NP
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=" ";

$pdf->Cell(22,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",1,"C");

//D·tum vzniku DP
$pdf->Cell(190,3,"                          ","$rmc",1,"L");

$text=" ";

$pdf->Cell(26,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",0,"C");

//VymeriavacÌ z·klad DP a RFS
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=" ";

$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);

$pdf->Cell(24,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$A","$rmc",0,"R");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(2,6,"$B","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(2,6,"$C","$rmc",0,"C");

//D·tum z·niku DP
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=" ";

$pdf->Cell(22,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",1,"C");

//D·tum vzniku PvN
$pdf->Cell(190,2,"                          ","$rmc",1,"L");

$text=" ";

$pdf->Cell(26,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",0,"C");

//VymeriavacÌ z·klad PvN
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=" ";

$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);

$pdf->Cell(24,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$A","$rmc",0,"R");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(2,6,"$B","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(2,6,"$C","$rmc",0,"C");

//D·tum z·niku PvN
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=" ";

$pdf->Cell(22,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",1,"C");


//XII. Podpisy a odtlaËky peËiatok
//D·tum vzniku zmeny
$pdf->Cell(190,10,"                          ","$rmc",1,"L");

$text=$h_dzmen;

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",0,"L");

//D·tum vyplnenia formul·ra
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$h_dvyplsk=$h_dvypl;
$zostavil=$kli_uzprie;

$text=$h_dvyplsk;

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(31,6,"$text","$rmc",0,"L");

//D·tum prijatia formul·ra
$pdf->Cell(1,6,"                          ","$rmc",0,"L");

$text=" ";

$pdf->Cell(83,6," ","$rmc",0,"R");$pdf->Cell(30,6,"$text","$rmc",1,"L");

//Formul·r vyplnil
$pdf->Cell(190,3,"                          ","$rmc",1,"L");

$text=$zostavil;

$pdf->Cell(10,6," ","$rmc",0,"R");$pdf->Cell(56,6,"$text","$rmc",0,"L");



     }
//koniec j=0

}
$i = $i + 1;
$j = $j + 1;
  }

$pdf->Output("../tmp/rlfo.$kli_uzid.pdf");

?>

<script type="text/javascript">
  var okno = window.open("../tmp/rlfo.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalmesx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzaltrnx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalkunx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

}
///////////////////////////////////////////////////KONIEC PDF RLFO copern=40


?>
<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
