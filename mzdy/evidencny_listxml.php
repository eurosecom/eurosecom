<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];

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

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$cislo_oc = 1*$_REQUEST['cislo_oc'];

$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$idx=$kli_uzid.$hhmm;

$nazsub="EVIDENCNY_LIST_OSC_".$cislo_oc."_".$idx.".xml";

$copern=10;
$elsubor=2;
?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>DMV XML</title>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
</script>
</HEAD>
<BODY class="white">
<table class="h2" width="100%" >
 <tr>
  <td>EuroSecom - Evidenèný list osè <?php echo $cislo_oc; ?> export do XML</td>
  <td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
 </tr>
</table>

<?php
///////////////////////////////////////////////////TLAC a VYTVORENIE XML SUBORU PRE ELEKTRONIKU elsubor=1,2
if ( $copern == 10 AND $elsubor == 2 )
    {
//prva strana
if (File_Exists ("../tmp/$nazsub")) { $soubor = unlink("../tmp/$nazsub"); }
$soubor = fopen("../tmp/$nazsub", "a+");

$sqlt = <<<mzdprc
(

//NOVA SCHEMA od 1.1.2016
<?xml version="1.0" encoding="UTF-8"?>
<spELDPZec xmlns="http://socpoist.sk/xsd/eldpzec" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://socpoist.sk/xsd/eldpzec ELDP-v2015_1.3.xsd ">
  <zamestnavatel>
    <identifikacia>
      <icz>1122334455</icz>
      <identifikator>
        <ico>11223344</ico>
      </identifikator>
      <nazov>SPtest s.r.o</nazov>
    </identifikacia>
    <korAdresa>
      <ulica>Kvetinková</ulica>
      <oCislo>17</oCislo>
      <obec>Prešov</obec>
      <psc>08001</psc>
    </korAdresa>
  </zamestnavatel>
  <zoznamELDPZec>
    <eldpZec opravny="1">
      <poistenec>
        <rc>531015123</rc>
        <priezvisko>Osobitý</priezvisko>
        <meno>František</meno>
        <rodPriezvisko>Osobitý</rodPriezvisko>
        <miestoNarodenia>Brezno</miestoNarodenia>
        <datNarodenia>15.10.1953</datNarodenia>
        <adresa>
        	<ulica>Vesmírna</ulica>
        	<oCislo>308</oCislo>
        	<obec>Martin</obec>
        	<psc>03601</psc>
			<stat>SK</stat>
        </adresa>
      </poistenec>
      <poistVztah>
        <datVzniku>01.05.2008</datVzniku>
        <datZaniku>30.09.2013</datZaniku>
      </poistVztah>
      <obdobiaPoist datDovrseniaDV="15.10.2012">
        <vzZaObdobiePoist rok="2008" znakPoist="A" datOd="01.05.2008" datDo="31.12.2008" vzDP="123250" />
        <vzZaObdobiePoist rok="2009" znakPoist="A" datOd="01.01.2009" datDo="31.12.2009" vzDP="7458.30" />
        <vzZaObdobiePoist rok="2010" znakPoist="A" datOd="01.01.2010" datDo="31.12.2010" vzDP="10500.00" vzVyluc="1200.00" dniVyluc="20"/>
        <vzZaObdobiePoist rok="2011" znakPoist="A" datOd="01.01.2011" datDo="31.12.2011" vzDP="8421.36" />
        <vzZaObdobiePoist rok="2012" znakPoist="A" datOd="01.01.2012" datDo="14.10.2012" vzDP="12480.20"/>
        <vzZaObdobiePoist rok="2012" znakPoist="A" datOd="15.10.2012" datDo="31.12.2012" vzDP="4258.35" dniVyluc="7"/>
        <vzZaObdobiePoist rok="2013" znakPoist="A" datOd="01.01.2013" datDo="30.09.2013" vzDP="7525.48" />
      </obdobiaPoist>
    </eldpZec>
    <eldpZec opravny="0">
      <poistenec>
        <rc>5511118899</rc>
        <priezvisko>Osoba</priezvisko>
        <meno>¼ubomír</meno>
        <rodPriezvisko>Osoba</rodPriezvisko>
        <miestoNarodenia>Prešov</miestoNarodenia>
        <datNarodenia>11.11.1955</datNarodenia>
        <adresa>
        	<ulica>Dlhá</ulica>
        	<oCislo>54</oCislo>
        	<obec>Obec</obec>
        	<psc>01122</psc>
			<stat>SK</stat>
        </adresa>
      </poistenec>
      <poistVztah>
        <datVzniku>15.04.2014</datVzniku>
        <trva>1</trva>
      </poistVztah>
      <obdobiaPoist>
        <vzZaObdobiePoist rok="2014" znakPoist="A" datOd="15.04.2014" datDo="31.12.2014" vzDP="4826.20"/>
        <vzZaObdobiePoist rok="2015" znakPoist="A" datOd="01.01.2015" datDo="27.10.2015" vzDP="6045.25"/>
      </obdobiaPoist>
    </eldpZec>
  </zoznamELDPZec>
  <datOdoslania>04.11.2015</datOdoslania>
  <kontakt>
  	<priezvisko>Test</priezvisko>
  	<meno>Juraj</meno>
  	<email>j.test@mailova.sk</email>
  	<telCislo>+421911223344</telCislo>
  </kontakt>
</spELDPZec>



);
mzdprc;

//hlavicka

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdevidencny".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdevidencny.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdevidencny.oc = $cislo_oc AND konx = 1 ORDER BY konx,prie,meno";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);
$obdobie=$kli_vmes;
$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $j == 0 )
{
  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n";
  fwrite($soubor, $text);

$text = "<spELDPZec xmlns=\"http://socpoist.sk/xsd/eldpzec\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" ".
        " xsi:schemaLocation=\"http://socpoist.sk/xsd/eldpzec ELDP-v2015_1.3.xsd \">";
  fwrite($soubor, $text);



  $text = " <zamestnavatel> "."\r\n";
  fwrite($soubor, $text);

  $text = " <identifikacia> "."\r\n";
  fwrite($soubor, $text);

  $text = "  <icz><![CDATA[".$cicz."]]></icz> "."\r\n"; fwrite($soubor, $text);

  $text = " <identifikator> "."\r\n";
  fwrite($soubor, $text);

  $text = "  <ico><![CDATA[".$fir_fico."]]></ico> "."\r\n"; fwrite($soubor, $text);

  $text = " </identifikator> "."\r\n";
  fwrite($soubor, $text);

  $hodnota=iconv("CP1250", "UTF-8", $fir_fnaz);
  $text = "   <nazov><![CDATA[".$hodnota."]]></nazov> "."\r\n"; fwrite($soubor, $text);

  $text = " </identifikacia> "."\r\n";
  fwrite($soubor, $text);

$duli = $fir_fuli;
$dcdm = $fir_fcdm;
$dmes = $fir_fmes;
$dpsc = str_replace(" ","",$fir_fpsc);

  $text = "  <korAdresa>"."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $duli);
  $text = "   <ulica><![CDATA[".$hodnota."]]></ulica> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$dcdm;
  $text = "   <oCislo><![CDATA[".$hodnota."]]></oCislo> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $dmes);
  $text = "   <obec><![CDATA[".$hodnota."]]></obec> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$dpsc;
  $text = "   <psc><![CDATA[".$hodnota."]]></psc> "."\r\n"; fwrite($soubor, $text);
  $text = "  </korAdresa>"."\r\n"; fwrite($soubor, $text);

  $text = " </zamestnavatel> "."\r\n";
  fwrite($soubor, $text);

  $text = " <zoznamELDPZec> "."\r\n";
  fwrite($soubor, $text);

$opravx="0";
if( $hlavicka->oprav == 1 ) { $opravx="1"; }

  $text = " <eldpZec opravny=\"".$opravx."\"> "."\r\n";
  fwrite($soubor, $text);

  $text = " <poistenec> "."\r\n";
  fwrite($soubor, $text);

  $rodne = $hlavicka->rdc."".$hlavicka->rdk;
  $text = "   <rc><![CDATA[".$rodne."]]></rc> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->prie);
  $text = "   <priezvisko><![CDATA[".$hodnota."]]></priezvisko> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->meno);
  $text = "   <meno><![CDATA[".$hodnota."]]></meno> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->rodn);
  $text = "   <rodPriezvisko><![CDATA[".$hodnota."]]></rodPriezvisko> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->mnr);
  $text = "   <miestoNarodenia><![CDATA[".$hodnota."]]></miestoNarodenia> "."\r\n"; fwrite($soubor, $text);
  $dar=SkDatum($hlavicka->dar);
  $text = "   <datNarodenia><![CDATA[".$dar."]]></datNarodenia> "."\r\n"; fwrite($soubor, $text);



  $text = " <adresa> "."\r\n";
  fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->zuli);
  $text = "   <ulica><![CDATA[".$hodnota."]]></ulica> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->zcdm);
  $text = "   <oCislo><![CDATA[".$hodnota."]]></oCislo> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->zmes);
  $text = "   <obec><![CDATA[".$hodnota."]]></obec> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->zpsc);
  $text = "   <psc><![CDATA[".$hodnota."]]></psc> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", "SK");
  $text = "   <stat><![CDATA[".$hodnota."]]></stat> "."\r\n"; fwrite($soubor, $text);
  $text = " </adresa> "."\r\n";
  fwrite($soubor, $text);

  $text = " </poistenec> "."\r\n";
  fwrite($soubor, $text);

  $text = " <poistVztah> "."\r\n";
  fwrite($soubor, $text);
  $dan=SkDatum($hlavicka->dan);
  $text = "   <datVzniku><![CDATA[".$dan."]]></datVzniku> "."\r\n"; fwrite($soubor, $text);
  $dav=SkDatum($hlavicka->dav);
  $text = "   <datZaniku><![CDATA[".$dav."]]></datZaniku> "."\r\n"; fwrite($soubor, $text);
  $text = " </poistVztah> "."\r\n";
  fwrite($soubor, $text);

//andrej

  $dad=SkDatum($hlavicka->dar);
  if( $dad != '00.00.0000' ) {
  $text = "   <obdobiaPoist datDovrseniaDV=\"".$dad."\">"."\r\n"; fwrite($soubor, $text);
                             }
  if( $dad == '00.00.0000' ) {
  $text = "   <obdobiaPoist>"."\r\n"; fwrite($soubor, $text);
                             }
  
$riadok=1;
$dajriadok=0;
while( $riadok <= 13 )
          {                           

if( $hlavicka->kr01 > 0 AND $riadok == 1 )
{
$rok=$hlavicka->kr01;
$znak=$hlavicka->zp01;
$daod=SkDatum($hlavicka->dp01);
$dado=SkDatum($hlavicka->dk01);
$vzdp=$hlavicka->vz01;
$vv=$hlavicka->vv01;
$kd=$hlavicka->kd01;
$dajriadok=1;
}
if( $hlavicka->kr02 > 0 AND $riadok == 2 )
{
$rok=$hlavicka->kr02;
$znak=$hlavicka->zp02;
$daod=SkDatum($hlavicka->dp02);
$dado=SkDatum($hlavicka->dk02);
$vzdp=$hlavicka->vz02;
$vv=$hlavicka->vv02;
$kd=$hlavicka->kd02;
$dajriadok=1;
}
if( $hlavicka->kr03 > 0 AND $riadok == 3 )
{
$rok=$hlavicka->kr03;
$znak=$hlavicka->zp03;
$daod=SkDatum($hlavicka->dp03);
$dado=SkDatum($hlavicka->dk03);
$vzdp=$hlavicka->vz03;
$vv=$hlavicka->vv03;
$kd=$hlavicka->kd03;
$dajriadok=1;
}
if( $hlavicka->kr04 > 0 AND $riadok == 4 )
{
$rok=$hlavicka->kr04;
$znak=$hlavicka->zp04;
$daod=SkDatum($hlavicka->dp04);
$dado=SkDatum($hlavicka->dk04);
$vzdp=$hlavicka->vz04;
$vv=$hlavicka->vv04;
$kd=$hlavicka->kd04;
$dajriadok=1;
}
if( $hlavicka->kr05 > 0 AND $riadok == 5 )
{
$rok=$hlavicka->kr05;
$znak=$hlavicka->zp05;
$daod=SkDatum($hlavicka->dp05);
$dado=SkDatum($hlavicka->dk05);
$vzdp=$hlavicka->vz05;
$vv=$hlavicka->vv05;
$kd=$hlavicka->kd05;
$dajriadok=1;
}
if( $hlavicka->kr06 > 0 AND $riadok == 6 )
{
$rok=$hlavicka->kr06;
$znak=$hlavicka->zp06;
$daod=SkDatum($hlavicka->dp06);
$dado=SkDatum($hlavicka->dk06);
$vzdp=$hlavicka->vz06;
$vv=$hlavicka->vv06;
$kd=$hlavicka->kd06;
$dajriadok=1;
}
if( $hlavicka->kr07 > 0 AND $riadok == 7 )
{
$rok=$hlavicka->kr07;
$znak=$hlavicka->zp07;
$daod=SkDatum($hlavicka->dp07);
$dado=SkDatum($hlavicka->dk07);
$vzdp=$hlavicka->vz07;
$vv=$hlavicka->vv07;
$kd=$hlavicka->kd07;
$dajriadok=1;
}
if( $hlavicka->kr08 > 0 AND $riadok == 8 )
{
$rok=$hlavicka->kr08;
$znak=$hlavicka->zp08;
$daod=SkDatum($hlavicka->dp08);
$dado=SkDatum($hlavicka->dk08);
$vzdp=$hlavicka->vz08;
$vv=$hlavicka->vv08;
$kd=$hlavicka->kd08;
$dajriadok=1;
}
if( $hlavicka->kr09 > 0 AND $riadok == 9 )
{
$rok=$hlavicka->kr09;
$znak=$hlavicka->zp09;
$daod=SkDatum($hlavicka->dp09);
$dado=SkDatum($hlavicka->dk09);
$vzdp=$hlavicka->vz09;
$vv=$hlavicka->vv09;
$kd=$hlavicka->kd09;
$dajriadok=1;
}
if( $hlavicka->kr10 > 0 AND $riadok == 10 )
{
$rok=$hlavicka->kr10;
$znak=$hlavicka->zp10;
$daod=SkDatum($hlavicka->dp10);
$dado=SkDatum($hlavicka->dk10);
$vzdp=$hlavicka->vz10;
$vv=$hlavicka->vv10;
$kd=$hlavicka->kd10;
$dajriadok=1;
}
if( $hlavicka->kr11 > 0 AND $riadok == 11 )
{
$rok=$hlavicka->kr11;
$znak=$hlavicka->zp11;
$daod=SkDatum($hlavicka->dp11);
$dado=SkDatum($hlavicka->dk11);
$vzdp=$hlavicka->vz11;
$vv=$hlavicka->vv11;
$kd=$hlavicka->kd11;
$dajriadok=1;
}
if( $hlavicka->kr12 > 0 AND $riadok == 12 )
{
$rok=$hlavicka->kr12;
$znak=$hlavicka->zp12;
$daod=SkDatum($hlavicka->dp12);
$dado=SkDatum($hlavicka->dk12);
$vzdp=$hlavicka->vz12;
$vv=$hlavicka->vv12;
$kd=$hlavicka->kd12;
$dajriadok=1;
}
if( $hlavicka->kr13 > 0 AND $riadok == 13 )
{
$rok=$hlavicka->kr13;
$znak=$hlavicka->zp13;
$daod=SkDatum($hlavicka->dp13);
$dado=SkDatum($hlavicka->dk13);
$vzdp=$hlavicka->vz13;
$vv=$hlavicka->vv13;
$kd=$hlavicka->kd13;
$dajriadok=1;
}

if( $dajriadok == 1 ) 
     {

  $text = "<vzZaObdobiePoist rok=\"".$rok."\" znakPoist=\"".$znak."\" ";
  $text = $text."datOd=\"".$daod."\" datDo=\"".$dado."\" vzDP=\"".$vzdp."\" ";

if( $vv > 0 ) {   $text = $text."vzVyluc=\"".$vv."\" "; }
if( $kd > 0 ) {   $text = $text."dniVyluc=\"".$kd."\" "; }

  $text = $text."/>"."\r\n";
echo $text; 
  fwrite($soubor, $text);
     }

$dajriadok=0;
$riadok=$riadok+1;
          }


  $text = "   </obdobiaPoist>"."\r\n"; fwrite($soubor, $text);

  $text = " </eldpZec> "."\r\n";
  fwrite($soubor, $text);

  $text = " </zoznamELDPZec> "."\r\n";
  fwrite($soubor, $text);

  $datum=SkDatum($hlavicka->datum);
  if ( $datum == '00.00.0000' ) { $datum=Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); }
  $text = "   <datOdoslania><![CDATA[".$datum."]]></datOdoslania> "."\r\n"; fwrite($soubor, $text);

$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$priefosoba = trim($fir_riadok->fospprie);
$menofosoba = trim($fir_riadok->fospmeno);
$telfosoba = trim($fir_riadok->fosptel);
$mailfosoba = trim($fir_riadok->fospmail);
if ( $priefosoba == '' ) { $priefosoba="mzdová"; }
if ( $menofosoba == '' ) { $menofosoba="úètáreò"; }
if ( $telfosoba == '' ) { $telfosoba=$fir_ftel; }
if ( $mailfosoba == '' ) { $mailfosoba=$fir_fem1; }

  $text = " <kontakt> "."\r\n";
  fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $priefosoba);
  $text = "   <priezvisko><![CDATA[".$hodnota."]]></priezvisko> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $menofosoba);
  $text = "   <meno><![CDATA[".$hodnota."]]></meno> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $mailfosoba);
  $text = "   <email><![CDATA[".$hodnota."]]></email> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $telfosoba);
  $text = "   <telCislo><![CDATA[".$hodnota."]]></telCislo> "."\r\n"; fwrite($soubor, $text);
  $text = " </kontakt> "."\r\n";
  fwrite($soubor, $text);

}
//koniec ak j=0

}
$i = $i + 1;
$j = $j + 1;
  }


  $text = "</spELDPZec> "."\r\n";
  fwrite($soubor, $text);

fclose($soubor);
?>



<?php if ( $elsubor == 2 ) { ?>

<br />
<br />
Stiahnite si nižšie uvedený súbor XML na Váš lokálny disk a naèítajte na www.drsr.sk alebo do aplikácie eDane :
<br />
<br />
<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>
<br />
<br />

<?php                      } ?>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>


<?php
//mysql_free_result($vysledok);
    }
/////////////////////////////////////////////////////koniec TLAC a VYTVORENIE XML SUBORU PRE ELEKTRONIKU


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
