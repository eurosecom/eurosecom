<HTML>
<?php
//XML pre FOB 2016
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
alert ("Da�ov� priznanie XML bude pripraven� v priebehu janu�ra 2017. Aktu�lne info n�jdete na vstupnej str�nke v bode Novinky, tipy, triky.");
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

$nazsub="PRIZNANIEFOB_".$kli_vrok."_".$idx.".xml";

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
<title>EuroSecom - FOB xml export</title>
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
   <td class="header">Da� z pr�jmov FOB / Export XML - <span class="subheader"><?php echo "$dmeno $dprie";?></span></td>
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
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob ";

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

  $text = "  <typDP>"."\r\n"; fwrite($soubor, $text);
$rdp="1"; $odp="0"; $ddp="0";
if ( $hlavicka->druh == 2 ) { $rdp="0"; $odp="1"; $ddp="0"; }
if ( $hlavicka->druh == 3 ) { $rdp="0"; $odp="0"; $ddp="1"; }
  $text = "   <rdp><![CDATA[".$rdp."]]></rdp>"."\r\n"; fwrite($soubor, $text);
  $text = "   <odp><![CDATA[".$odp."]]></odp>"."\r\n"; fwrite($soubor, $text);
  $text = "   <ddp><![CDATA[".$ddp."]]></ddp>"."\r\n"; fwrite($soubor, $text);
  $text = "  </typDP>"."\r\n"; fwrite($soubor, $text);

  $text = "  <zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);
$rok=$kli_vrok;
  $text = "   <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);
$datumDDP=SkDatum($hlavicka->ddp);
if ( $datumDDP == '00.00.0000' ) $datumDDP="";
  $text = "   <datumDDP><![CDATA[".$datumDDP."]]></datumDDP>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);

  $text = "  <skNace>"."\r\n"; fwrite($soubor, $text);
$fir_sknace=trim($fir_sknace);
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sknaceb=$pole[1];
$sknacec=$pole[2];
  $k1=$sknacea;
  $text = "   <k1><![CDATA[".$k1."]]></k1>"."\r\n"; fwrite($soubor, $text);
  $k2=$sknaceb;
  $text = "   <k2><![CDATA[".$k2."]]></k2>"."\r\n"; fwrite($soubor, $text);
  $k3=$sknacec;
  $text = "   <k3><![CDATA[".$k3."]]></k3>"."\r\n"; fwrite($soubor, $text);
$cinnost=iconv("CP1250", "UTF-8", $hlavicka->cinnost);
  $text = "   <cinnost><![CDATA[".$cinnost."]]></cinnost>"."\r\n"; fwrite($soubor, $text);
  $text = "  </skNace>"."\r\n"; fwrite($soubor, $text);

$priezvisko=iconv("CP1250", "UTF-8", $dprie);
  $text = "  <priezvisko><![CDATA[".$priezvisko."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
$meno=iconv("CP1250", "UTF-8", $dmeno);
  $text = "  <meno><![CDATA[".$meno."]]></meno>"."\r\n"; fwrite($soubor, $text);
$titul=iconv("CP1250", "UTF-8", $dtitl);
  $text = "  <titul><![CDATA[".$titul."]]></titul>"."\r\n"; fwrite($soubor, $text);
$titulza=iconv("CP1250", "UTF-8", $dtitz);
  $text = "  <titulZa><![CDATA[".$titulza."]]></titulZa>"."\r\n"; fwrite($soubor, $text);

  $text = "  <adresaTrvPobytu>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $duli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$dcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$dpsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $dmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$stat=iconv("CP1250", "UTF-8", $dstat);
  $text = "   <stat><![CDATA[".$stat."]]></stat>"."\r\n"; fwrite($soubor, $text);
  $text = "  </adresaTrvPobytu>"."\r\n"; fwrite($soubor, $text);

$nerezident=$hlavicka->nrz;
  $text = "  <nerezident><![CDATA[".$nerezident."]]></nerezident>"."\r\n"; fwrite($soubor, $text);
$nerezident=$hlavicka->prp;
  $text = "  <prepojeniePar2><![CDATA[".$nerezident."]]></prepojeniePar2>"."\r\n"; fwrite($soubor, $text);

  $text = "  <adresaObvPobytu>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->d2uli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->d2cdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->d2psc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->d2mes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
  $text = "  </adresaObvPobytu>"."\r\n"; fwrite($soubor, $text);

  $text = "  <zastupca>"."\r\n"; fwrite($soubor, $text);
$priezvisko=iconv("CP1250", "UTF-8", $hlavicka->zprie);
  $text = "   <priezvisko><![CDATA[".$priezvisko."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
$meno=iconv("CP1250", "UTF-8", $hlavicka->zmeno);
  $text = "   <meno><![CDATA[".$meno."]]></meno>"."\r\n"; fwrite($soubor, $text);
$titul=iconv("CP1250", "UTF-8", $hlavicka->ztitl);
  $text = "   <titul><![CDATA[".$titul."]]></titul>"."\r\n"; fwrite($soubor, $text);
$titulza=iconv("CP1250", "UTF-8", $hlavicka->ztitz);
  $text = "   <titulZa><![CDATA[".$titulza."]]></titulZa>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->zrdc.$hlavicka->zrdk;
  $text = "   <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->zuli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->zcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->zpsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->zmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$stat=iconv("CP1250", "UTF-8", $hlavicka->zstat);
  $text = "   <stat><![CDATA[".$stat."]]></stat>"."\r\n"; fwrite($soubor, $text);
$telefon=$hlavicka->dtel;
  $text = "   <tel><![CDATA[".$telefon."]]></tel>"."\r\n"; fwrite($soubor, $text);
$mail=iconv("CP1250", "UTF-8", $hlavicka->dmailfax);
  $text = "   <email><![CDATA[".$mail."]]></email>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zastupca>"."\r\n"; fwrite($soubor, $text);

  $text = " </hlavicka>"."\r\n"; fwrite($soubor, $text);

//telo
  $text = " <telo>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r29;
  $text = "  <r29><![CDATA[".$riadok."]]></r29>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r30;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r30><![CDATA[".$riadok."]]></r30>"."\r\n"; fwrite($soubor, $text);
 
  $text = "  <r31>"."\r\n"; fwrite($soubor, $text);
$priezvisko=iconv("CP1250", "UTF-8", $hlavicka->mprie);
  $text = "   <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->mrod;
  $text = "   <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$vlastnePrijmy=$hlavicka->mpri;
if ( $hlavicka->mpri == 0 ) $vlastnePrijmy="";
  $text = "   <vlastnePrijmy><![CDATA[".$vlastnePrijmy."]]></vlastnePrijmy>"."\r\n"; fwrite($soubor, $text);
$pocetMesiacov=$hlavicka->mpom;
if ( $hlavicka->mpom == 0 ) $pocetMesiacov="";
  $text = "   <pocetMesiacov><![CDATA[".$pocetMesiacov."]]></pocetMesiacov>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r31>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r32>"."\r\n"; fwrite($soubor, $text);
  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d1prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d1rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00=$hlavicka->d1pomc;
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=$hlavicka->d1pom1;
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=$hlavicka->d1pom2;
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=$hlavicka->d1pom3;
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=$hlavicka->d1pom4;
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=$hlavicka->d1pom5;
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=$hlavicka->d1pom6;
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=$hlavicka->d1pom7;
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=$hlavicka->d1pom8;
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=$hlavicka->d1pom9;
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=$hlavicka->d1pom10;
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=$hlavicka->d1pom11;
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=$hlavicka->d1pom12;
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);

  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d2prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d2rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00=$hlavicka->d2pomc;
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=$hlavicka->d2pom1;
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=$hlavicka->d2pom2;
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=$hlavicka->d2pom3;
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=$hlavicka->d2pom4;
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=$hlavicka->d2pom5;
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=$hlavicka->d2pom6;
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=$hlavicka->d2pom7;
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=$hlavicka->d2pom8;
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=$hlavicka->d2pom9;
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=$hlavicka->d2pom10;
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=$hlavicka->d2pom11;
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=$hlavicka->d2pom12;
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);

  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d3prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d3rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00=1*$hlavicka->d3pomc;
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=1*$hlavicka->d3pom1;
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=1*$hlavicka->d3pom2;
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=1*$hlavicka->d3pom3;
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=1*$hlavicka->d3pom4;
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=1*$hlavicka->d3pom5;
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=1*$hlavicka->d3pom6;
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=1*$hlavicka->d3pom7;
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=1*$hlavicka->d3pom8;
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=1*$hlavicka->d3pom9;
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=1*$hlavicka->d3pom10;
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=1*$hlavicka->d3pom11;
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=1*$hlavicka->d3pom12;
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);

  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d4prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d4rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00=1*$hlavicka->d4pomc;
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=1*$hlavicka->d4pom1;
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=1*$hlavicka->d4pom2;
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=1*$hlavicka->d4pom3;
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=1*$hlavicka->d4pom4;
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=1*$hlavicka->d4pom5;
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=1*$hlavicka->d4pom6;
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=1*$hlavicka->d4pom7;
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=1*$hlavicka->d4pom8;
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=1*$hlavicka->d4pom9;
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=1*$hlavicka->d4pom10;
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=1*$hlavicka->d4pom11;
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=1*$hlavicka->d4pom12;
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r32>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r33;
  $text = "  <r33viacAko4><![CDATA[".$riadok."]]></r33viacAko4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r34;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r34><![CDATA[".$riadok."]]></r34>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r34a;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r34a><![CDATA[".$riadok."]]></r34a>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r35;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r35><![CDATA[".$riadok."]]></r35>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r36;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r36><![CDATA[".$riadok."]]></r36>"."\r\n"; fwrite($soubor, $text);
  
  $text = "  <tabulka1>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t1r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r1>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r2>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r3>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r4>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r5>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r6>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r6>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r7>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r7>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r8>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r8>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r9>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r9>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r10>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r11>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r12>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r13>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p13;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v13;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r13>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabulka1>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->uppr1;
  $text = "  <vydavkyPar6ods11_ods1a2><![CDATA[".$riadok."]]></vydavkyPar6ods11_ods1a2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->uppr3;
  $text = "  <vydavkyPar6ods11_ods3><![CDATA[".$riadok."]]></vydavkyPar6ods11_ods3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->uppr4;
  $text = "  <vydavkyPar6ods11_ods4><![CDATA[".$riadok."]]></vydavkyPar6ods11_ods4>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->uvp61;
  $text = "  <vydavkyPar6ods10_ods1a2><![CDATA[".$riadok."]]></vydavkyPar6ods10_ods1a2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->uvp61m;
if ( $riadok == 0 ) $riadok="";
  $text = "  <vydavkyPar6ods10_ods1a2pocMes><![CDATA[".$riadok."]]></vydavkyPar6ods10_ods1a2pocMes>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->uvp64;
  $text = "  <vydavkyPar6ods10_ods4><![CDATA[".$riadok."]]></vydavkyPar6ods10_ods4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->uvp64m;
if ( $riadok == 0 ) $riadok="";
  $text = "  <vydavkyPar6ods10_ods4pocMes><![CDATA[".$riadok."]]></vydavkyPar6ods10_ods4pocMes>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->psp6;
if ( $riadok == 0 ) $riadok="";
  $text = "  <vydavkyPoistPar6ods11_ods1a2><![CDATA[".$riadok."]]></vydavkyPoistPar6ods11_ods1a2>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->uos61;
  $text = "  <uplatnujemPar17ods17_ods1a2><![CDATA[".$riadok."]]></uplatnujemPar17ods17_ods1a2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->uos64;
  $text = "  <uplatnujemPar17ods17_ods3a4><![CDATA[".$riadok."]]></uplatnujemPar17ods17_ods3a4>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->kos61;
  $text = "  <ukoncujemUplatnovaniePar17ods17_ods1a2><![CDATA[".$riadok."]]></ukoncujemUplatnovaniePar17ods17_ods1a2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->kos64;
  $text = "  <ukoncujemUplatnovaniePar17ods17_ods3a4><![CDATA[".$riadok."]]></ukoncujemUplatnovaniePar17ods17_ods3a4>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabulka1a>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t1r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1az1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1ak1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r1>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1az2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1ak2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r2>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1az3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1ak3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r3>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1az4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1ak4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r4>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1az5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1ak5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r5>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabulka1a>"."\r\n"; fwrite($soubor, $text);

$text = "  <tabulka1b>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t1r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1bz1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1bk1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r1>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1bz2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1bk2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r2>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabulka1b>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r37;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r37><![CDATA[".$riadok."]]></r37>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r38;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r38><![CDATA[".$riadok."]]></r38>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r39;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r39><![CDATA[".$riadok."]]></r39>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r40;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r40><![CDATA[".$riadok."]]></r40>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r41;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r41><![CDATA[".$riadok."]]></r41>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r42;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r42><![CDATA[".$riadok."]]></r42>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r43;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r43><![CDATA[".$riadok."]]></r43>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r44;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r44><![CDATA[".$riadok."]]></r44>"."\r\n"; fwrite($soubor, $text);

//zmena 2015
$riadok=$hlavicka->r45;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r45>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "    <rok>2010</rok>"."\r\n"; fwrite($soubor, $text);
  $text = "    <strata><![CDATA[".$riadok."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r45>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r46;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r46>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "    <rok>2011</rok>"."\r\n"; fwrite($soubor, $text);
  $text = "    <strata><![CDATA[".$riadok."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r46>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r47;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r47>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "    <rok>2012</rok>"."\r\n"; fwrite($soubor, $text);
  $text = "    <strata><![CDATA[".$riadok."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r47>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r48;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r48>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "    <rok>2013</rok>"."\r\n"; fwrite($soubor, $text);
  $text = "    <strata><![CDATA[".$riadok."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r48>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r49;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r49>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "    <rok>2014</rok>"."\r\n"; fwrite($soubor, $text);
  $text = "    <strata><![CDATA[".$riadok."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r49>"."\r\n"; fwrite($soubor, $text);
//koniec zmena 2015

//rok2016
$riadok=$hlavicka->r50;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r50>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "    <rok>2015</rok>"."\r\n"; fwrite($soubor, $text);
  $text = "    <strata><![CDATA[".$riadok."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r50>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r51;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r51><![CDATA[".$riadok."]]></r51>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r52;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r52><![CDATA[".$riadok."]]></r52>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r53;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r53><![CDATA[".$riadok."]]></r53>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r54;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r54><![CDATA[".$riadok."]]></r54>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r55;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r55><![CDATA[".$riadok."]]></r55>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r56;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r56><![CDATA[".$riadok."]]></r56>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r57;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r57><![CDATA[".$riadok."]]></r57>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r58;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r58><![CDATA[".$riadok."]]></r58>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r59;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r59><![CDATA[".$riadok."]]></r59>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r60;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r60><![CDATA[".$riadok."]]></r60>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r61;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r61><![CDATA[".$riadok."]]></r61>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r62;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r62><![CDATA[".$riadok."]]></r62>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r63;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r63><![CDATA[".$riadok."]]></r63>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r64;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r64><![CDATA[".$riadok."]]></r64>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r65;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r65><![CDATA[".$riadok."]]></r65>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabulka2>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t2r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p1;
if( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r1>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r2>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r3>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r4>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r5>"."\r\n"; fwrite($soubor, $text);

  $text = "  <t2r6>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r6>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r7>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r7>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r8>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r8>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r9>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r9>"."\r\n"; fwrite($soubor, $text);
 
  $text = "   <t2r10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r10>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r11>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r12>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabulka2>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r66;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r66><![CDATA[".$riadok."]]></r66>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r67;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r67><![CDATA[".$riadok."]]></r67>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r68;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r68><![CDATA[".$riadok."]]></r68>"."\r\n"; fwrite($soubor, $text);


  $text = "  <tabulka3>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t3r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r1>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r2>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r3>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);;
  $text = "   </t3r4>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r5>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r6>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r6>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r7>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r7>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r8>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r8>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r9>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r9>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r10>"."\r\n";   fwrite($soubor, $text);
  
  $text = "   <t3r11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r11>"."\r\n"; fwrite($soubor, $text);
 
  $text = "   <t3r12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);;
$riadok=$hlavicka->t3v12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);;
  $text = "   </t3r12>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r13>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p13;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v13;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r13>"."\r\n"; fwrite($soubor, $text);

//zmena 2015
  $text = "   <t3r14>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p14;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v14;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r14>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r15>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p15;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v15;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r15>"."\r\n"; fwrite($soubor, $text);
//koniec zmena 2015

  $text = "   <t3r16>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p16;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r16>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t3r17>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p17;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v17;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r17>"."\r\n"; fwrite($soubor, $text);

  $text = "  </tabulka3>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r69;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r69><![CDATA[".$riadok."]]></r69>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r70;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r70><![CDATA[".$riadok."]]></r70>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r71;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r71><![CDATA[".$riadok."]]></r71>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r72;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r72><![CDATA[".$riadok."]]></r72>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r73;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r73><![CDATA[".$riadok."]]></r73>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r74;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r74><![CDATA[".$riadok."]]></r74>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r75;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r75><![CDATA[".$riadok."]]></r75>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r76;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r76><![CDATA[".$riadok."]]></r76>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r77;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r77><![CDATA[".$riadok."]]></r77>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r78;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r78><![CDATA[".$riadok."]]></r78>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r79;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r79><![CDATA[".$riadok."]]></r79>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r80;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r80><![CDATA[".$riadok."]]></r80>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r81;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r81><![CDATA[".$riadok."]]></r81>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r82;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r82><![CDATA[".$riadok."]]></r82>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r83;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r83><![CDATA[".$riadok."]]></r83>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r84;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r84><![CDATA[".$riadok."]]></r84>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r85;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r85><![CDATA[".$riadok."]]></r85>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r86;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r86><![CDATA[".$riadok."]]></r86>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r87;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r87><![CDATA[".$riadok."]]></r87>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r88;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r88><![CDATA[".$riadok."]]></r88>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r89;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r89><![CDATA[".$riadok."]]></r89>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r90;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r90><![CDATA[".$riadok."]]></r90>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r91;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r91><![CDATA[".$riadok."]]></r91>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r92;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r92><![CDATA[".$riadok."]]></r92>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r93;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r93><![CDATA[".$riadok."]]></r93>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r94;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r94><![CDATA[".$riadok."]]></r94>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r95;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r95><![CDATA[".$riadok."]]></r95>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r96;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r96><![CDATA[".$riadok."]]></r96>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r97;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r97><![CDATA[".$riadok."]]></r97>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r98;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r98><![CDATA[".$riadok."]]></r98>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r99;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r99><![CDATA[".$riadok."]]></r99>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r100;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r100><![CDATA[".$riadok."]]></r100>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r101;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r101><![CDATA[".$riadok."]]></r101>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r102;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r102><![CDATA[".$riadok."]]></r102>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r103;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r103><![CDATA[".$riadok."]]></r103>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r104;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r104><![CDATA[".$riadok."]]></r104>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r105;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r105><![CDATA[".$riadok."]]></r105>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r106;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r106><![CDATA[".$riadok."]]></r106>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r107;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r107><![CDATA[".$riadok."]]></r107>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r108;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r108><![CDATA[".$riadok."]]></r108>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r109;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r109><![CDATA[".$riadok."]]></r109>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r110;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r110><![CDATA[".$riadok."]]></r110>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r111;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r111><![CDATA[".$riadok."]]></r111>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r112;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r112><![CDATA[".$riadok."]]></r112>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r113;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r113><![CDATA[".$riadok."]]></r113>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r114;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r114><![CDATA[".$riadok."]]></r114>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r115;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r115><![CDATA[".$riadok."]]></r115>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r116;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r116><![CDATA[".$riadok."]]></r116>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r117;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r117><![CDATA[".$riadok."]]></r117>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r118;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r118><![CDATA[".$riadok."]]></r118>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r119;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r119><![CDATA[".$riadok."]]></r119>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r120;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r120><![CDATA[".$riadok."]]></r120>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r121;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r121><![CDATA[".$riadok."]]></r121>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r122;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r122><![CDATA[".$riadok."]]></r122>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r123;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r123><![CDATA[".$riadok."]]></r123>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r124;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r124><![CDATA[".$riadok."]]></r124>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r125;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r125><![CDATA[".$riadok."]]></r125>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r126;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r126><![CDATA[".$riadok."]]></r126>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r127;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r127><![CDATA[".$riadok."]]></r127>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r128;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r128><![CDATA[".$riadok."]]></r128>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r129;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r129><![CDATA[".$riadok."]]></r129>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r130;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r130><![CDATA[".$riadok."]]></r130>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r131;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r131><![CDATA[".$riadok."]]></r131>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r132;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r132><![CDATA[".$riadok."]]></r132>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r133;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r133><![CDATA[".$riadok."]]></r133>"."\r\n"; fwrite($soubor, $text);


$neuplatnujem=$hlavicka->upl50;
  $text = "  <neuplatnujem><![CDATA[".$neuplatnujem."]]></neuplatnujem>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->spl3d;
  $text = "  <splnam3per><![CDATA[".$riadok."]]></splnam3per>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r123;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r123><![CDATA[".$riadok."]]></r123>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r124>"."\r\n"; fwrite($soubor, $text);
$pico=$hlavicka->pico;
if ( $hlavicka->pico < 1000000 AND $hlavicka->pico > 1 ) { $pico="00".$hlavicka->pico; }
//$ico=$hlavicka->pico."/".$hlavicka->psid;
//if ( $hlavicka->psid == '' ) { $ico=$hlavicka->pico; }
  $text = "   <ico><![CDATA[".$pico."]]></ico>"."\r\n"; fwrite($soubor, $text);
$sid=$hlavicka->psid;
  $text = "   <sid><![CDATA[".$sid."]]></sid>"."\r\n"; fwrite($soubor, $text);

$pravnaForma=iconv("CP1250", "UTF-8", $hlavicka->pfor);
  $text = "   <pravnaForma><![CDATA[".$pravnaForma."]]></pravnaForma>"."\r\n"; fwrite($soubor, $text);
  $text = "   <obchMeno>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pmen);
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
$riadok="";
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "   </obchMeno>"."\r\n";   fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->puli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->pcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->ppsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->pmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
//new2015
$riadok=$hlavicka->zslu;
  $text = "    <suhlasZaslUdaje><![CDATA[".$riadok."]]></suhlasZaslUdaje>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r124>"."\r\n"; fwrite($soubor, $text);


  $text = "  <osobitneZaznamy>"."\r\n"; fwrite($soubor, $text);
$uvadza=$hlavicka->uoso;
  $text = "   <uvadza><![CDATA[".$uvadza."]]></uvadza>"."\r\n"; fwrite($soubor, $text);
  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks1);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp1);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro1);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks2);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp2);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro2);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks3);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp3);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro3);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks4);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp4);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro4);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks5);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp5);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro5);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks6);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp6);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro6);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

$zaznamy=iconv("CP1250", "UTF-8", $hlavicka->osob);
  $text = "   <zaznamy><![CDATA[".$zaznamy."]]></zaznamy>"."\r\n"; fwrite($soubor, $text);
  $text = "  </osobitneZaznamy>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->pril;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r125><![CDATA[".$riadok."]]></r125>"."\r\n"; fwrite($soubor, $text);

$datum=SKDatum($hlavicka->dat);
if ( $datum =='00.00.0000' ) $datum="";
  $text = "  <datumVyhlasenia><![CDATA[".$datum."]]></datumVyhlasenia>"."\r\n"; fwrite($soubor, $text);

  $text = "  <danovyPreplatokBonus>"."\r\n"; fwrite($soubor, $text);
$vyplatbonus=$hlavicka->zdbo;
  $text = "   <vyplatitDanovyBonus><![CDATA[".$vyplatbonus."]]></vyplatitDanovyBonus>"."\r\n"; fwrite($soubor, $text);
$vratpreplatok=$hlavicka->zpre;
  $text = "   <vratitDanPreplatok><![CDATA[".$vratpreplatok."]]></vratitDanPreplatok>"."\r\n"; fwrite($soubor, $text);
  $text = "   <sposobPlatby>"."\r\n";   fwrite($soubor, $text);
$poukazka=$hlavicka->post;
  $text = "    <poukazka><![CDATA[".$poukazka."]]></poukazka>"."\r\n"; fwrite($soubor, $text);
$ucet=$hlavicka->ucet;
  $text = "    <ucet><![CDATA[".$ucet."]]></ucet>"."\r\n"; fwrite($soubor, $text);
  $text = "   </sposobPlatby>"."\r\n"; fwrite($soubor, $text);
  $text = "   <bankovyUcet>"."\r\n"; fwrite($soubor, $text);
$iban=$hlavicka->diban;
  $text = "    <IBAN><![CDATA[".$iban."]]></IBAN>"."\r\n"; fwrite($soubor, $text);

$pole = explode("-", $hlavicka->uceb);
$predcislieUctu=$pole[0];
$cisloUctu=$pole[1];
if ( $pole[1] == '' ) { $cisloUctu=$pole[0]; $predcislieUctu=""; }
if ( $ucet == 0 ) $predcislieUctu="";
  //$text = "    <predcislieUctu><![CDATA[".$predcislieUctu."]]></predcislieUctu>"."\r\n"; fwrite($soubor, $text);
if ( $ucet == 0 ) $cisloUctu="";
  //$text = "    <cisloUctu><![CDATA[".$cisloUctu."]]></cisloUctu>"."\r\n"; fwrite($soubor, $text);
$kodBanky=$hlavicka->numb;
if ( $ucet == 0 ) $kodBanky="";
  //$text = "    <kodBanky><![CDATA[".$kodBanky."]]></kodBanky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </bankovyUcet>"."\r\n"; fwrite($soubor, $text);

$datum=SKDatum($hlavicka->da2);
if ( $datum =='00.00.0000' ) $datum="";
  $text = "   <datum><![CDATA[".$datum."]]></datum>"."\r\n"; fwrite($soubor, $text);
  $text = "  </danovyPreplatokBonus>"."\r\n"; fwrite($soubor, $text);

//pridana priloha proj 2015
  $text = "  <prilPar30cOdpocetVydavkov>"."\r\n"; fwrite($soubor, $text);

$riadok=1;
if ( $hlavicka->prpods == 0 ) $riadok="0";
  $text = "    <projektCislo><![CDATA[".$riadok."]]></projektCislo>"."\r\n"; fwrite($soubor, $text);
$riadok=1;
if ( $hlavicka->prpods == 0 ) $riadok="0";
  $text = "    <pocetProjektov><![CDATA[".$riadok."]]></pocetProjektov>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpdzc);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumRealizacie><![CDATA[".$riadok."]]></datumRealizacie>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r01>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzo1);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieOd><![CDATA[".$riadok."]]></zdanObdobieOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzd1);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieDo><![CDATA[".$riadok."]]></zdanObdobieDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpvz1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <narok><![CDATA[".$riadok."]]></narok>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpod1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <odpocitanaCast><![CDATA[".$riadok."]]></odpocitanaCast>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r01>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r02>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzo2);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieOd><![CDATA[".$riadok."]]></zdanObdobieOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzd2);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieDo><![CDATA[".$riadok."]]></zdanObdobieDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpvz2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <narok><![CDATA[".$riadok."]]></narok>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpod2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <odpocitanaCast><![CDATA[".$riadok."]]></odpocitanaCast>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r02>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r03>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzo3);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieOd><![CDATA[".$riadok."]]></zdanObdobieOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzd3);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieDo><![CDATA[".$riadok."]]></zdanObdobieDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpvz3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <narok><![CDATA[".$riadok."]]></narok>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpod3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <odpocitanaCast><![CDATA[".$riadok."]]></odpocitanaCast>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r03>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r04>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzo4);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieOd><![CDATA[".$riadok."]]></zdanObdobieOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzd4);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieDo><![CDATA[".$riadok."]]></zdanObdobieDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpvz4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <narok><![CDATA[".$riadok."]]></narok>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpod4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <odpocitanaCast><![CDATA[".$riadok."]]></odpocitanaCast>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r04>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r05>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzo5);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieOd><![CDATA[".$riadok."]]></zdanObdobieOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzd5);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieDo><![CDATA[".$riadok."]]></zdanObdobieDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpvz5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <narok><![CDATA[".$riadok."]]></narok>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpod5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <odpocitanaCast><![CDATA[".$riadok."]]></odpocitanaCast>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r05>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->prpods;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->prptxt);
  $text = "    <ciele><![CDATA[".$riadok."]]></ciele>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpodv;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);

  $text = "  </prilPar30cOdpocetVydavkov>"."\r\n"; fwrite($soubor, $text);
//koniec pridana priloha proj 2015

  $text = "  <socZdravPoistenie>"."\r\n"; fwrite($soubor, $text);
  $text = "   <pr1>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->sz1p1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz1v1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </pr1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz2;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr2><![CDATA[".$riadok."]]></pr2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz3;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr3><![CDATA[".$riadok."]]></pr3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz4;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr4><![CDATA[".$riadok."]]></pr4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz5;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr5><![CDATA[".$riadok."]]></pr5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz6;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr6><![CDATA[".$riadok."]]></pr6>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz7;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr7><![CDATA[".$riadok."]]></pr7>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz8;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr8><![CDATA[".$riadok."]]></pr8>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz9;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr9><![CDATA[".$riadok."]]></pr9>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz10;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr10><![CDATA[".$riadok."]]></pr10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz11;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr11><![CDATA[".$riadok."]]></pr11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz12;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr12><![CDATA[".$riadok."]]></pr12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz13;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr13><![CDATA[".$riadok."]]></pr13>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz14;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr14><![CDATA[".$riadok."]]></pr14>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz15;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr15><![CDATA[".$riadok."]]></pr15>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz16;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr16><![CDATA[".$riadok."]]></pr16>"."\r\n"; fwrite($soubor, $text);

$vediempu=$hlavicka->vpdu;
  $text = "   <priPrimoch6ods1a2VediemPU><![CDATA[".$vediempu."]]></priPrimoch6ods1a2VediemPU>"."\r\n"; fwrite($soubor, $text);
$datum=SKDatum($hlavicka->szdat);
if ( $datum =='00.00.0000' ) $datum="";
  $text = "   <datum><![CDATA[".$datum."]]></datum>"."\r\n"; fwrite($soubor, $text);
  $text = "  </socZdravPoistenie>"."\r\n";   fwrite($soubor, $text);

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
<p>Stiahnite si ni��ie uveden� s�bor <strong>.xml</strong> do V�ho po��ta�a a na��tajte ho na
<a href="https://www.financnasprava.sk/sk/titulna-stranka" target="_blank" title="Str�nka Finan�nej spr�vy">www.financnasprava.sk</a> alebo do aplik�cie eDane:
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
 <dt class="toleft box-red"></dt><dd class="toleft">kritick�</dd>
 <dt class="toleft box-orange"></dt><dd class="toleft">logick�</dd>
</dl>
</h2>
<ul id="alertpage1" style="display:none;">
<li class="header-section">STRANA 1</li>
<li class="red">
<?php if ( $hlavicka->fdic == "0" AND $hlavicka->dar == '0000-00-00' )
{
$upozorni1=1;
echo "Nie je vyplnen� <strong>DI�</strong> da�ovn�ka.";
}
?>
</li>
<li class="red">
<?php if ( $hlavicka->dar != '0000-00-00' AND $hlavicka->fdic != "0" )
{
$upozorni1=1;
echo "S��asne vyplnen� <strong>di�</strong> aj <strong>d�tum narodenia</strong> da�ovn�ka.";
}
?>
</li>
<li class="red">
<?php if ( $hlavicka->nrz == 1 AND $hlavicka->dar == '0000-00-00' )
{
$upozorni1=1;
echo "Pri <strong>nerezidentovi</strong> (bod 12) nie je vyplnen� jeho <strong>d�tum narodenia</strong> v bode 2.";
}
?>
</li>
<li class="red">
<?php if ( $hlavicka->druh == 3 AND $hlavicka->ddp == '0000-00-00' )
{
$upozorni1=1;
echo "Pri <strong>dodato�nom</strong> da�ovom priznan� <strong> nie je vyplnen� d�tum</strong> zistenia skuto�nosti na podanie dodato�n�ho priznania.";
}
?>
</li>
<li class="red">
<?php if ( ( $hlavicka->druh == 1 OR $hlavicka->druh == 2 ) AND $hlavicka->ddp != '0000-00-00' )
{
$upozorni1=1;
echo "Vyplnen� <strong>d�tum</strong> zistenia skuto�nosti na podanie dodato�n�ho priznania, ale <strong>nie je</strong> vybrat� dodato�n� da�ov� priznanie.";
}
?>
</li>
<li class="red">
<?php if ( $dprie == "" OR $dmeno == "" )
{
$upozorni1=1;
echo "Nie je vyplnen� <strong>priezvisko alebo meno</strong> da�ovn�ka.";
}
?>
</li>
<li class="orange">
<?php if ( $dcdm == "" OR $dpsc == "" OR $dmes == "" OR $dstat == "" ) {
$upozorni1=1;
echo "Nie je vyplnen� cel� <strong>adresa trval�ho pobytu</strong> da�ovn�ka.";
} ?>
</li>
</ul>
<ul id="alertpage2" style="display:none;">
<li class="header-section">STRANA 2</li>
<li class="orange">
<?php if ( $hlavicka->r29 == 0 AND $hlavicka->r30 != 0 )
{
$upozorni2=1;
echo "Vyplnen� <strong>�hrnn� suma d�chodku</strong> v bode 30, av�ak nie je za�krtnut� <strong>poberanie d�chodku</strong> v bode 29.";
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
echo "Vyplnen� riadky <strong>X.oddielu</strong>, ale <strong>nie je</strong> vybrat� dodato�n� da�ov� priznanie na 1.strane.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->nrz == 0 AND ( $hlavicka->sdnr != "" OR $hlavicka->r129 != 0 OR $hlavicka->r130 != 0 ) )
{
$upozorni10=1;
echo "V <strong>XI.oddiele</strong> vyplnen� <strong>�daje nerezidenta</strong>, ale nie je vybrat� nerezident <strong>v bode 12 na 1.strane</strong>.";
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
echo "V <strong>XI.oddiele</strong> vyplnen� <strong>�daje nerezidenta</strong>, ale nie je vybrat� nerezident <strong>v bode 12 na 1.strane</strong>.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->upl50 == 1 AND $hlavicka->r134 != 0 )
{
$upozorni11=1;
echo "<strong>Neuplat�ujem postup</strong> pod�a � 50 z�kona a z�rove� poukazujem sumu v <strong>bode 134</strong>.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->upl50 == 1 AND ( $hlavicka->pico != 0 OR $hlavicka->psid != 0 OR $hlavicka->pfor != "" OR $hlavicka->pmen != "" OR $hlavicka->puli != "" OR $hlavicka->pcdm != "" OR $hlavicka->ppsc != "" OR $hlavicka->pmes != "" ) )
{
$upozorni11=1;
echo "<strong>Neuplat�ujem postup</strong> pod�a � 50 z�kona a z�rove� s� vyplnen� <strong>�daje o prij�mate�ovi</strong> v bode 134.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->r134 != 0 AND $hlavicka->upl50 == 0 AND ( $hlavicka->pico == 0 OR $hlavicka->psid == 0 OR $hlavicka->pfor == "" OR $hlavicka->pmen == "" ) )
{
$upozorni11=1;
echo "Nie s� vyplnen� <strong>�daje o pr�jimate�ovi</strong> v bode 135.";
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
echo "Vyplnen� <strong>osobitn� z�znamy</strong>, ale <strong>nie je vybrat� uv�dzam</strong> osobitn� z�znamy na strane 11.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->dat == '0000-00-00' )
{
$upozorni12=1;
echo "Nie je vyplnen� <strong>d�tum vyhl�senia</strong> da�ov�ho priznania.";
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
echo "<strong>D�tum vyhl�senia</strong> nem��e by� vy��� ako aktu�lny d�tum.";
}
?>
</li>
<li class="orange">
<?php if ( ( $hlavicka->zdbo == 0 AND $hlavicka->zpre == 0 ) AND ( $hlavicka->post == 1 OR $hlavicka->ucet == 1 OR $hlavicka->diban != "" OR $hlavicka->da2 != '0000-00-00' ) )
{
$upozorni12=1;
echo "V <strong>XIV.oddiele ne�iadam</strong> o vyplatenie / vr�tenie, ale s� vyplnen� hodnoty s�visiace s vyplaten�m / vr�ten�m(napr. sp�sob, iban alebo d�tum).";
}
?>
</li>
<li class="orange">
<?php if ( ( $hlavicka->zdbo == 1 OR $hlavicka->zpre == 1 ) AND $hlavicka->da2 == '0000-00-00' )
{
$upozorni12=1;
echo "V <strong>XIV.oddiele �iadam</strong> o vyplatenie / vr�tenie, ale nie je vyplnen� <strong>d�tum</strong> vyplatenia / vr�tenia.";
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
echo "<strong>D�tum �iadosti o vr�tenie</strong> nem��e by� vy��� ako aktu�lny d�tum.";
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
echo "<strong>D�tum �iadosti o vr�tenie</strong> nem��e by� vy��� ako aktu�lny d�tum.";
}
?>
</li>
<li class="orange">
<?php if ( ( $hlavicka->zdbo == 1 OR $hlavicka->zpre == 1 ) AND $hlavicka->ucet == 1 AND $hlavicka->diban == "" ) {
$upozorni6=1;
echo "V <strong>XIV.oddiele �iadam</strong> o vyplatenie / vr�tenie na ��et, ale nie je vyplnen� <strong>IBAN</strong> ��tu na vyplatenie / vr�tenie.";
} ?>
</li>
</ul>

<ul id="alertpage14" style="display:none;">
<li class="header-section">STRANA 14 - PR�LOHA 2</li>
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
echo "<strong>D�tum v pr�lohe 2</strong> nem��e by� vy��� ako aktu�lny d�tum.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->sz9 != 0 AND $hlavicka->szdat == '0000-00-00' )
{
$upozorni14=1;
echo "Je vyplnen� riadok 9, ale ch�ba vyplnen� <strong>d�tum</strong>.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->r35 != $hlavicka->sz9 )
{
$upozorni14=1;
echo "Riadok 35 zo strany 2 sa mus� rovna� <strong>riadku 9</strong> v Pr�lohe 2 priznania.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->psp6 != ( $hlavicka->sz12 + $hlavicka->sz14 ) )
{
$upozorni14=1;
echo "Hodnota v riadku \"preuk�zate�n� zaplaten� poistn�\" na strane 3 sa mus� rovna� <strong>riadok 12 + 14</strong> v Pr�lohe 2 priznania.";
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