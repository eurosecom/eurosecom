<HTML>
<?php
//XML pre v176 2016
do
{
$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];
$zdrd = $_REQUEST['zdrd'];
$h_drp = $_REQUEST['h_drp'];
$h_dap = $_REQUEST['h_dap'];
$h_arch = $_REQUEST['h_arch'];

$chyby = 1*$_REQUEST['chyby'];

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$zablokovane=0;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("Daòové priznanie XML bude pripravené v priebehu januára 2017. Aktuálne info nájdete na vstupnej stránke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");


//druh priznania 1=mesacne,2=stvrtrocne,4=rocne
$fir_uctx01 = $_REQUEST['fir_uctx01'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$idx=$kli_uzid.$hhmm;

$nazsub="OZNAMENIEv176_".$kli_vrok."_".$idx.".xml";

$copern=10;
$zarchivu=1;
$elsubor=2;

//FO - priezvisko,meno,tituly a trvaly pobyt z ufirdalsie
$sql = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$vysledok = mysql_query($sql);
if ( $vysledok )
     {
$riadok=mysql_fetch_object($vysledok);
$dprie = $riadok->dprie;
$dmeno = $riadok->dmeno;
$dtitl = $riadok->dtitl;
$dtitz = $riadok->dtitz;
$duli = $riadok->duli;
$dcdm = $riadok->dcdm;
$dpsc = $riadok->dpsc;
$dmes = $riadok->dmes;
$dstat = $riadok->dstat;
//$dtel = $riadok->dtel;
     }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
<link rel="stylesheet" href="../css/reset.css">
<link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Oznv176 xml export</title>
<style>
#content {
  box-sizing: border-box;
  background-color: white;
  padding: 30px 25px;
   -webkit-box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
  -moz-box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
  box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
}
#content > p {
  line-height: 22px;
  font-size: 14px;
}
#content > p > a {
  color: #00e;
}
#content > p > a:hover {
  text-decoration: underline;
}
#upozornenie > h2 {
  line-height: 20px;
  margin-top: 25px;
  margin-bottom: 10px;
  overflow: auto;
}
#upozornenie > h2 > strong {
  font-size: 16px;
  font-weight: bold;
}
#upozornenie > ul > li {
  line-height: 18px;
  margin: 10px 0;
  font-size: 13px;
}
.red {
  border-left: 4px solid #f22613;
  text-indent: 8px;
}
.orange {
  border-left: 4px solid #f89406;
  text-indent: 8px;
}
dl.legend-area {
  height: 14px;
  line-height: 14px;
  font-size: 11px;
  position: relative;
  top: 5px;
}
dl.legend-area > dt {
  width:10px;
  height:10px;
  margin: 2px 5px 0 12px;
}
.box-red {
  background-color: #f22613;
}
.box-orange {
  background-color: #f89406;
}
.header-section {
  padding-top: 5px;
}
</style>
</HEAD>
<BODY>
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">Oznámenie v176 / Export XML - <span class="subheader"><?php echo "$dmeno $dprie";?></span></td>
   <td></td>
  </tr>
 </table>
</div>
<?php
//XML SUBOR elsubor=2
if ( $copern == 10 AND $elsubor == 2  )
     {
//prva strana
if ( File_Exists("../tmp/$nazsub") ) { $soubor = unlink("../tmp/$nazsub"); }
     $soubor = fopen("../tmp/$nazsub", "a+");
?>

<?php
//rok2016
$sqlt = <<<mzdprc
(

);
mzdprc;


//hlavicka
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctoznamenie_uprzd WHERE oc = 1 AND cpl = $cislo_cpl ORDER BY zodic ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ( $i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$obdobie=$kli_vmes;
$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dat_datsql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $j == 0 )
     {
  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n"; fwrite($soubor, $text);
  $text = "<dokument>"."\r\n"; fwrite($soubor, $text);		
  $text = " <hlavicka>"."\r\n"; fwrite($soubor, $text);

$dic=$fir_fdic;
  $text = "  <dic><![CDATA[".$dic."]]></dic>"."\r\n"; fwrite($soubor, $text);
$datumNarodenia=SkDatum($hlavicka->dar);
if ( $datumNarodenia == '00.00.0000' ) $datumNarodenia="";
  $text = "  <datumNarodenia><![CDATA[".$datumNarodenia."]]></datumNarodenia>"."\r\n"; fwrite($soubor, $text);

  $text = " </hlavicka>"."\r\n"; fwrite($soubor, $text);

//telo
  $text = " <telo>"."\r\n"; fwrite($soubor, $text);

  $text = " </telo>"."\r\n"; fwrite($soubor, $text);
  $text = "</dokument>"."\r\n"; fwrite($soubor, $text);
     }
//koniec ak j=0
}
$i = $i + 1;
$j = $j + 1;
  }
fclose($soubor);
?>
<div id="content">
<?php if ( $elsubor == 2 ) { ?>
<p>Stiahnite si nišie uvedenı súbor <strong>.xml</strong> do Vášho poèítaèa a naèítajte ho na
<a href="https://www.financnasprava.sk/sk/titulna-stranka" target="_blank" title="Stránka Finanènej správy">www.financnasprava.sk</a> alebo do aplikácie eDane:
</p>
<p>
<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>
</p>
<?php                      } ?>

<?php
/////////////////////////////////////////////////////////////////////UPOZORNENIE
$upozorni1=0; $upozorni2=0; $upozorni10=0; $upozorni11=0; $upozorni12=0;
?>
<div id="upozornenie" style="display:none;">
<h2>
<strong class="toleft">Upozornenie</strong>
<dl class="toright legend-area">
 <dt class="toleft box-red"></dt><dd class="toleft">kritické</dd>
 <dt class="toleft box-orange"></dt><dd class="toleft">logické</dd>
</dl>
</h2>
<ul id="alertpage1" style="display:none;">
<li class="header-section">STRANA 1</li>
<li class="red">
<?php if ( $hlavicka->fdic == "0" AND $hlavicka->dar == '0000-00-00' )
{
$upozorni1=1;
echo "Nie je vyplnené <strong>DIÈ</strong> daòovníka.";
}
?>
</li>
<li class="red">
<?php if ( $hlavicka->dar != '0000-00-00' AND $hlavicka->fdic != "0" )
{
$upozorni1=1;
echo "Súèasne vyplnené <strong>diè</strong> aj <strong>dátum narodenia</strong> daòovníka.";
}
?>
</li>
<li class="red">
<?php if ( $hlavicka->nrz == 1 AND $hlavicka->dar == '0000-00-00' )
{
$upozorni1=1;
echo "Pri <strong>nerezidentovi</strong> (bod 12) nie je vyplnenı jeho <strong>dátum narodenia</strong> v bode 2.";
}
?>
</li>
<li class="red">
<?php if ( $hlavicka->druh == 3 AND $hlavicka->ddp == '0000-00-00' )
{
$upozorni1=1;
echo "Pri <strong>dodatoènom</strong> daòovom priznaní <strong> nie je vyplnenı dátum</strong> zistenia skutoènosti na podanie dodatoèného priznania.";
}
?>
</li>
<li class="red">
<?php if ( ( $hlavicka->druh == 1 OR $hlavicka->druh == 2 ) AND $hlavicka->ddp != '0000-00-00' )
{
$upozorni1=1;
echo "Vyplnenı <strong>dátum</strong> zistenia skutoènosti na podanie dodatoèného priznania, ale <strong>nie je</strong> vybraté dodatoèné daòové priznanie.";
}
?>
</li>
<li class="red">
<?php if ( $dprie == "" OR $dmeno == "" )
{
$upozorni1=1;
echo "Nie je vyplnené <strong>priezvisko alebo meno</strong> daòovníka.";
}
?>
</li>
<li class="orange">
<?php if ( $dcdm == "" OR $dpsc == "" OR $dmes == "" OR $dstat == "" ) {
$upozorni1=1;
echo "Nie je vyplnená celá <strong>adresa trvalého pobytu</strong> daòovníka.";
} ?>
</li>
</ul>
<ul id="alertpage2" style="display:none;">
<li class="header-section">STRANA 2</li>
<li class="orange">
<?php if ( $hlavicka->r29 == 0 AND $hlavicka->r30 != 0 )
{
$upozorni2=1;
echo "Vyplnená <strong>úhrnná suma dôchodku</strong> v bode 30, avšak nie je zaškrtnuté <strong>poberanie dôchodku</strong> v bode 29.";
}
?>
</li>
</ul>
<ul id="alertpage10" style="display:none;">
<li class="header-section">STRANA 10</li>
<li class="orange">
<?php if ( $hlavicka->druh != 3 AND ( $hlavicka->r122 != 0 OR $hlavicka->r123 != 0 OR $hlavicka->r124 != 0 OR $hlavicka->r125 != 0 OR $hlavicka->r126 != 0 OR $hlavicka->r127 != 0 ) )
{
$upozorni10=1;
echo "Vyplnené riadky <strong>X.oddielu</strong>, ale <strong>nie je</strong> vybraté dodatoèné daòové priznanie na 1.strane.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->nrz == 0 AND ( $hlavicka->sdnr != "" OR $hlavicka->r129 != 0 OR $hlavicka->r130 != 0 ) )
{
$upozorni10=1;
echo "V <strong>XI.oddiele</strong> vyplnené <strong>údaje nerezidenta</strong>, ale nie je vybratı nerezident <strong>v bode 12 na 1.strane</strong>.";
}
?>
</li>
</ul>
<ul id="alertpage11" style="display:none;">
<li class="header-section">STRANA 11</li>
<li class="orange">
<?php if ( $hlavicka->nrz == 0 AND ( $hlavicka->r131 != 0 OR $hlavicka->ldnr != 0 OR $hlavicka->nrzsprev != 0 ) )
{
$upozorni11=1;
echo "V <strong>XI.oddiele</strong> vyplnené <strong>údaje nerezidenta</strong>, ale nie je vybratı nerezident <strong>v bode 12 na 1.strane</strong>.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->upl50 == 1 AND $hlavicka->r134 != 0 )
{
$upozorni11=1;
echo "<strong>Neuplatòujem postup</strong> pod¾a § 50 zákona a zároveò poukazujem sumu v <strong>bode 134</strong>.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->upl50 == 1 AND ( $hlavicka->pico != 0 OR $hlavicka->psid != 0 OR $hlavicka->pfor != "" OR $hlavicka->pmen != "" OR $hlavicka->puli != "" OR $hlavicka->pcdm != "" OR $hlavicka->ppsc != "" OR $hlavicka->pmes != "" ) )
{
$upozorni11=1;
echo "<strong>Neuplatòujem postup</strong> pod¾a § 50 zákona a zároveò sú vyplnené <strong>údaje o prijímate¾ovi</strong> v bode 134.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->r134 != 0 AND $hlavicka->upl50 == 0 AND ( $hlavicka->pico == 0 OR $hlavicka->psid == 0 OR $hlavicka->pfor == "" OR $hlavicka->pmen == "" ) )
{
$upozorni11=1;
echo "Nie sú vyplnené <strong>údaje o príjimate¾ovi</strong> v bode 135.";
}
?>
</li>
</ul>
<ul id="alertpage12" style="display:none;">
<li class="header-section">STRANA 12</li>
<li class="orange">
<?php if ( $hlavicka->uoso == 0 AND $hlavicka->osob != "" )
{
$upozorni12=1;
echo "Vyplnené <strong>osobitné záznamy</strong>, ale <strong>nie je vybraté uvádzam</strong> osobitné záznamy na strane 11.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->dat == '0000-00-00' )
{
$upozorni12=1;
echo "Nie je vyplnenı <strong>dátum vyhlásenia</strong> daòového priznania.";
}
?>
</li>
<li class="orange">
<?php
$wrongdat=1;
$sqlico = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob WHERE dat <= '$dat_datsql' ");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $ibanx=$riadico->ibanx;
  $wrongdat=0;
  }
if ( $wrongdat == 1 )
{
$upozorni12=1;
echo "<strong>Dátum vyhlásenia</strong> nemôe by vyšší ako aktuálny dátum.";
}
?>
</li>
<li class="orange">
<?php if ( ( $hlavicka->zdbo == 0 AND $hlavicka->zpre == 0 ) AND ( $hlavicka->post == 1 OR $hlavicka->ucet == 1 OR $hlavicka->diban != "" OR $hlavicka->da2 != '0000-00-00' ) )
{
$upozorni12=1;
echo "V <strong>XIV.oddiele neiadam</strong> o vyplatenie / vrátenie, ale sú vyplnené hodnoty súvisiace s vyplatením / vrátením(napr. spôsob, iban alebo dátum).";
}
?>
</li>
<li class="orange">
<?php if ( ( $hlavicka->zdbo == 1 OR $hlavicka->zpre == 1 ) AND $hlavicka->da2 == '0000-00-00' )
{
$upozorni12=1;
echo "V <strong>XIV.oddiele iadam</strong> o vyplatenie / vrátenie, ale nie je vyplnenı <strong>dátum</strong> vyplatenia / vrátenia.";
}
?>
</li>
<li class="orange">
<?php
$wrongdat=1;
$sqlico = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob WHERE da2 <= '$dat_datsql' ");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $ibanx=$riadico->ibanx;
  $wrongdat=0;
  }
if ( $wrongdat == 1 )
{
$upozorni12=1;
echo "<strong>Dátum iadosti o vrátenie</strong> nemôe by vyšší ako aktuálny dátum.";
}
?>
</li>
<li class="orange">
<?php
$wrongdat=1;
$sqlico = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob WHERE dat <= '$dat_datsql' ");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $ibanx=$riadico->ibanx;
  $wrongdat=0;
  }
if ( $wrongdat == 1 )
{
$upozorni12=1;
echo "<strong>Dátum iadosti o vrátenie</strong> nemôe by vyšší ako aktuálny dátum.";
}
?>
</li>
<li class="orange">
<?php if ( ( $hlavicka->zdbo == 1 OR $hlavicka->zpre == 1 ) AND $hlavicka->ucet == 1 AND $hlavicka->diban == "" ) {
$upozorni6=1;
echo "V <strong>XIV.oddiele iadam</strong> o vyplatenie / vrátenie na úèet, ale nie je vyplnenı <strong>IBAN</strong> úètu na vyplatenie / vrátenie.";
} ?>
</li>
</ul>

<ul id="alertpage14" style="display:none;">
<li class="header-section">STRANA 14 - PRÍLOHA 2</li>
<li class="orange">
<?php
$wrongdat=1;
$sqlico = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob WHERE szdat <= '$dat_datsql' ");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $ibanx=$riadico->ibanx;
  $wrongdat=0;
  }
if ( $wrongdat == 1 )
{
$upozorni14=1;
echo "<strong>Dátum v prílohe 2</strong> nemôe by vyšší ako aktuálny dátum.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->sz9 != 0 AND $hlavicka->szdat == '0000-00-00' )
{
$upozorni14=1;
echo "Je vyplnenı riadok 9, ale chıba vyplnenı <strong>dátum</strong>.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->r35 != $hlavicka->sz9 )
{
$upozorni14=1;
echo "Riadok 35 zo strany 2 sa musí rovna <strong>riadku 9</strong> v Prílohe 2 priznania.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->psp6 != ( $hlavicka->sz12 + $hlavicka->sz14 ) )
{
$upozorni14=1;
echo "Hodnota v riadku \"preukázate¾né zaplatené poistné\" na strane 3 sa musí rovna <strong>riadok 12 + 14</strong> v Prílohe 2 priznania.";
}
?>
</li>
</ul>
</div> <!-- #upozornenie -->

<script type="text/javascript">
<?php
if ( $upozorni1 == 1 OR $upozorni2 == 1 OR $upozorni10 == 1 OR $upozorni11 == 1 OR $upozorni12 == 1 OR $upozorni14 == 1 )
     { echo "upozornenie.style.display='block';"; }
if ( $upozorni1 == 1 ) { echo "alertpage1.style.display='block';"; } 
if ( $upozorni2 == 1 ) { echo "alertpage2.style.display='block';"; } 
if ( $upozorni10 == 1 ) { echo "alertpage10.style.display='block';"; }
if ( $upozorni11 == 1 ) { echo "alertpage11.style.display='block';"; }
if ( $upozorni12 == 1 ) { echo "alertpage12.style.display='block';"; }
if ( $upozorni14 == 1 ) { echo "alertpage14.style.display='block';"; }
?>
</script>

</div> <!-- #content -->
<?php
//mysql_free_result($vysledok);
     }
//koniec XML SUBOR
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>