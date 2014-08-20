<HTML>
<?php

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

$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];

$chyby = 1*$_REQUEST['chyby'];

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

//druh priznania 1=mesacne,2=stvrtrocne,4=rocne
$fir_uctx01 = $_REQUEST['fir_uctx01'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


//koniec nastav tlac z archivu

$nazsub="VYKAZ_PRIVYD_".$kli_vrok."_".$kli_uzid.".xml";

$copern=10;
$zarchivu=1;
$elsubor=2;


?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>XML</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
td.hvstup_bred { background-color:#ff6c6c; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    
</script>
</HEAD>
<BODY class="white" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Výkaz o príjmoch a výdavkoch v.13 rok <?php echo $kli_vrok; ?> - export do XML

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>

<?php
///////////////////////////////////////////////////TLAC a VYTVORENIE XML SUBORU PRE ELEKTRONIKU elsubor=1,2
if ( $copern == 10 AND $elsubor == 2  )
    {

//prva strana


if (File_Exists ("../tmp/$nazsub")) { $soubor = unlink("../tmp/$nazsub"); }

$soubor = fopen("../tmp/$nazsub", "a+");


$sqlt = <<<mzdprc
(
<?xml version="1.0" encoding="UTF-8"?>

-<dokument>


-<hlavicka>


-<datumK>

<den>31</den>

<mesiac>12</mesiac>

<rok>2013</rok>

</datumK>

<dic/>

<ico/>


-<skNace>

<k1/>

<k2/>

<k3/>

</skNace>


-<uctovnaZavierka>

<riadna>1</riadna>

<mimoriadna>0</mimoriadna>

<priebezna>0</priebezna>

</uctovnaZavierka>


-<zaObdobie>


-<od>

<mesiac/>

<rok/>

</od>


-<do>

<mesiac/>

<rok/>

</do>

</zaObdobie>


-<nazovUJ>

<riadok/>

<riadok/>

</nazovUJ>


-<bydlisko>

<ulica/>

<cislo/>

<psc/>

<obec/>

<tel/>

<fax/>

<email/>

</bydlisko>


-<miestoPodnikania>

<ulica/>

<cislo/>

<psc/>

<obec/>

<tel/>

<fax/>

</miestoPodnikania>

<zostaveneDna>31.12.2013</zostaveneDna>

</hlavicka>


-<telo>

<r01 ukazovatel="681"/>

<r02 ukazovatel="682"/>

<r03 ukazovatel="683"/>

<r04 ukazovatel="684"/>

<r05 ukazovatel="685"/>

<r06 ukazovatel="686"/>

<r07 ukazovatel="687"/>

<r08 ukazovatel="688"/>

<r09 ukazovatel="689"/>

<r10 ukazovatel="690"/>

<r11 ukazovatel="691"/>

<r12 ukazovatel="692"/>

</telo>

</dokument>
);
mzdprc;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvprivyds".$kli_uzid." WHERE prx = 1 "."";

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

if( $j == 0 )
          {
  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n";
  fwrite($soubor, $text);
  $text = "<dokument xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"universal.xsd\">"."\r\n"; fwrite($soubor, $text);		
   	
  $text = "  <hlavicka>	"."\r\n"; fwrite($soubor, $text);

  $text = "  <datumK>"."\r\n";   fwrite($soubor, $text);

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   datp          DATE,
   datk          DATE,
   fic          INT
);
prcdatum;

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $kli_vume);
$kli_mdph=$pole[0];
$kli_rdph=$pole[1];
if( $kli_mdph < 10 ) $kli_mdph='0'.$kli_mdph;

$pole = explode(".", $kli_vume);
$mesp_dph=$pole[0];
$mesk_dph=$pole[0];
$rokp_dph=$pole[1];

$datp_dph=$rokp_dph.'-'.$mesp_dph.'-01';
$datk_dph=$rokp_dph.'-'.$mesk_dph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datp_dph', 0 )";
$ttqq = mysql_query("$ttvv");


$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$datp_dph',  datk=LAST_DAY('$datk_dph')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sqlkk = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sqlkk,0))
  {
  $riadok=mysql_fetch_object($sqlkk);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$datp_sk=SkDatum($datp_dph);
$datk_sk=SkDatum($datk_dph);


//uzavierka k z ufirdalsie
if( $kli_vrok >= 2013 )
          {

$sqldtu = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sqldtu,0))
  {
  $riadokdtu=mysql_fetch_object($sqldtu);
  if( $riadokdtu->datk != '0000-00-00' )
    {
  $datk_sk=SkDatum($riadokdtu->datk);
    }
  }
          }

$pole = explode(".", $datk_sk);
$denk_sk=$pole[0];
$mesk_sk=$pole[1];
$rokk_sk=$pole[2];
if( $rokk_sk < 10 ) $rokk_sk='0'.$rokk_sk;

  $den=$denk_sk;
  $text = "    <den><![CDATA[".$den."]]></den>	"."\r\n";
  fwrite($soubor, $text);

  $mesiac=$mesk_sk;
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>	"."\r\n";
  fwrite($soubor, $text);

  $rok=$rokk_sk;
  $text = "    <rok><![CDATA[".$rok."]]></rok>	"."\r\n";
  fwrite($soubor, $text); 

  $text = "  </datumK>"."\r\n";   fwrite($soubor, $text);

  $dic=$fir_fdic;
  $text = "    <dic><![CDATA[".$dic."]]></dic>	"."\r\n"; fwrite($soubor, $text);

  $ico=$fir_fico;
  $text = "    <ico><![CDATA[".$ico."]]></ico>	"."\r\n"; fwrite($soubor, $text);


$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sknaceb=$pole[1];
$sknacec=$pole[2];
  $text = "   <skNace>"."\r\n";   fwrite($soubor, $text);
  $k1=$sknacea;
  $text = "    <k1><![CDATA[".$k1."]]></k1>	"."\r\n";   fwrite($soubor, $text);
  $k2=$sknaceb;
  $text = "    <k2><![CDATA[".$k2."]]></k2>	"."\r\n";   fwrite($soubor, $text);
  $k3=$sknacec;
  $text = "    <k3><![CDATA[".$k3."]]></k3>	"."\r\n";   fwrite($soubor, $text);
  $text = "   </skNace>"."\r\n";   fwrite($soubor, $text);


  $text = "  <uctovnaZavierka>"."\r\n";   fwrite($soubor, $text);

  $riadna=1;
  $text = "    <riadna><![CDATA[".$riadna."]]></riadna>	"."\r\n"; fwrite($soubor, $text);

  $mimoriadna=0;
  $text = "    <mimoriadna><![CDATA[".$mimoriadna."]]></mimoriadna>	"."\r\n"; fwrite($soubor, $text);

  $zostavena=0;
  $text = "    <priebezna><![CDATA[".$zostavena."]]></priebezna>	"."\r\n"; fwrite($soubor, $text);

  $text = "  </uctovnaZavierka>"."\r\n";   fwrite($soubor, $text);


  $text = "  <zaObdobie>"."\r\n";   fwrite($soubor, $text); 

if( $kli_vrok >= 2013 )
{

//nacitaj obdobia z ufirdalsie
$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];
if ( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
$kli_mrokx=$kli_vrokx-1;

$datbodsk="01.01.".$kli_vrokx; $datbdosk="31.".$kli_vmesx.".".$kli_vrokx; $datmodsk="01.01.".$kli_mrokx; $datmdosk="31.12.".$kli_mrokx;
$sqldtu = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sqldtu,0))
  {
  $riadokdtu=mysql_fetch_object($sqldtu);

if ( $riadokdtu->datbod != '0000-00-00' )
     {
  $datbodsk=SkDatum($riadokdtu->datbod);
  $datbdosk=SkDatum($riadokdtu->datbdo);
  $datmodsk=SkDatum($riadokdtu->datmod);
  $datmdosk=SkDatum($riadokdtu->datmdo);
     }
  }
$poleb = explode(".", $datbodsk);
$obdd1=$poleb[0];
$obdm1=$poleb[1];
$obdr1=$poleb[2];
$poleb = explode(".", $datbdosk);
$obdd2=$poleb[0];
$obdm2=$poleb[1];
$obdr2=$poleb[2];
$poleb = explode(".", $datmodsk);
$obmd1=$poleb[0];
$obmm1=$poleb[1];
$obmr1=$poleb[2];
$poleb = explode(".", $datmdosk);
$obmd2=$poleb[0];
$obmm2=$poleb[1];
$obmr2=$poleb[2];
$cobdd1=1*$obdd1;
$cobdm1=1*$obdm1;
$cobdr1=1*$obdr1;

$obdr1=substr($obdr1,2,2);
$obdr2=substr($obdr2,2,2);
$obmr1=substr($obmr1,2,2);
$obmr2=substr($obmr2,2,2);
}
//koniec rok 2013
 
$rokp_sk="20".$obdr1;
$mesp_sk=$obdm1;
$rokk_sk="20".$obdr2;
$mesk_sk=$obdm2;

  $text = "  <od>"."\r\n";   fwrite($soubor, $text); 

  $mesiac=$mesp_sk;
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>	"."\r\n"; fwrite($soubor, $text);

  $rok=$rokp_sk;
  $text = "    <rok><![CDATA[".$rok."]]></rok>	"."\r\n"; fwrite($soubor, $text);


  $text = "  </od>"."\r\n";   fwrite($soubor, $text);

  $text = "  <do>"."\r\n";   fwrite($soubor, $text); 


  $mesiac=$mesk_sk;
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>	"."\r\n"; fwrite($soubor, $text);

  $rok=$rokk_sk;
  $text = "    <rok><![CDATA[".$rok."]]></rok>	"."\r\n"; fwrite($soubor, $text); 

  $text = "  </do>"."\r\n";   fwrite($soubor, $text); 


  $text = "  </zaObdobie>"."\r\n";   fwrite($soubor, $text);


  $text = "  <nazovUJ>"."\r\n";   fwrite($soubor, $text); 

  $riadok=iconv("CP1250", "UTF-8", $fir_fnaz);
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>	"."\r\n"; fwrite($soubor, $text);

  $riadok="";
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>	"."\r\n"; fwrite($soubor, $text);

  $text = "  </nazovUJ>"."\r\n";   fwrite($soubor, $text);

 
  $text = "  <bydlisko>"."\r\n";   fwrite($soubor, $text); 

  $ulica=iconv("CP1250", "UTF-8", $fir_fuli);
  $text = "    <ulica><![CDATA[".$ulica."]]></ulica>	"."\r\n"; fwrite($soubor, $text);

  $cislo=$fir_fcdm;
  $text = "    <cislo><![CDATA[".$cislo."]]></cislo>	"."\r\n"; fwrite($soubor, $text);

  $psc=$fir_fpsc;
  $text = "    <psc><![CDATA[".$psc."]]></psc>	"."\r\n"; fwrite($soubor, $text);

  $obec=iconv("CP1250", "UTF-8", $fir_fmes);
  $text = "    <obec><![CDATA[".$obec."]]></obec>	"."\r\n"; fwrite($soubor, $text);

  $telefon=$fir_ftel;
  $text = "    <tel><![CDATA[".$telefon."]]></tel>	"."\r\n"; fwrite($soubor, $text);

  $fax=$fir_ffax;
  $text = "    <fax><![CDATA[".$fax."]]></fax>	"."\r\n"; fwrite($soubor, $text);

  $email=$fir_fem1;
  $text = "    <email><![CDATA[".$email."]]></email>	"."\r\n"; fwrite($soubor, $text);

  $text = "  </bydlisko>"."\r\n";   fwrite($soubor, $text);

//miesto podnikania berie z ufirdalsie Miesto podnikania 
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";

$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$mpulica = $fir_riadok->pruli;
$mpcislo = $fir_riadok->prcdm;
$mppsc = $fir_riadok->prpsc;
$mpobec = $fir_riadok->prmes;
$mptel = $fir_riadok->prtel;
$mpfax = $fir_riadok->prfax;
  
$ulica = iconv("CP1250", "UTF-8", $mpulica);
$cislo=$mpcislo;
$psc=$mppsc;
$obec = iconv("CP1250", "UTF-8", $mpobec);
$telefon=$mptel;
$fax=$mpfax;

  $text = "  <miestoPodnikania>"."\r\n";   fwrite($soubor, $text);

  $text = "    <ulica><![CDATA[".$ulica."]]></ulica>	"."\r\n"; fwrite($soubor, $text);

  $text = "    <cislo><![CDATA[".$cislo."]]></cislo>	"."\r\n"; fwrite($soubor, $text);

  $text = "    <psc><![CDATA[".$psc."]]></psc>	"."\r\n"; fwrite($soubor, $text);

  $text = "    <obec><![CDATA[".$obec."]]></obec>	"."\r\n"; fwrite($soubor, $text);

  $text = "    <tel><![CDATA[".$telefon."]]></tel>	"."\r\n"; fwrite($soubor, $text);

  $text = "    <fax><![CDATA[".$fax."]]></fax>	"."\r\n"; fwrite($soubor, $text);

  $text = "  </miestoPodnikania>"."\r\n";   fwrite($soubor, $text);


  $datZostavenia=$h_zos;
  $text = "    <zostaveneDna><![CDATA[".$datZostavenia."]]></zostaveneDna>	"."\r\n"; fwrite($soubor, $text);


  $text = "  </hlavicka>"."\r\n";   fwrite($soubor, $text);
 

  $text = "  <telo>"."\r\n";   fwrite($soubor, $text);

  $riadok=$hlavicka->r01;
  if( $riadok == 0 ) $riadok="";
  $text = "    <r01 ukazovatel=\"681\"><![CDATA[".$riadok."]]></r01>"."\r\n";   fwrite($soubor, $text);

  $riadok=$hlavicka->r02;
  if( $riadok == 0 ) $riadok="";
  $text = "    <r02 ukazovatel=\"682\"><![CDATA[".$riadok."]]></r02>"."\r\n";   fwrite($soubor, $text);

  $riadok=$hlavicka->r03;
  if( $riadok == 0 ) $riadok="";
  $text = "    <r03 ukazovatel=\"683\"><![CDATA[".$riadok."]]></r03>"."\r\n";   fwrite($soubor, $text);

  $riadok=$hlavicka->r04;
  if( $riadok == 0 ) $riadok="";
  $text = "    <r04 ukazovatel=\"684\"><![CDATA[".$riadok."]]></r04>"."\r\n";   fwrite($soubor, $text);

  $riadok=$hlavicka->r05;
  if( $riadok == 0 ) $riadok="";
  $text = "    <r05 ukazovatel=\"685\"><![CDATA[".$riadok."]]></r05>"."\r\n";   fwrite($soubor, $text);

  $riadok=$hlavicka->r06;
  if( $riadok == 0 ) $riadok="";
  $text = "    <r06 ukazovatel=\"686\"><![CDATA[".$riadok."]]></r06>"."\r\n";   fwrite($soubor, $text);

  $riadok=$hlavicka->r07;
  if( $riadok == 0 ) $riadok="";
  $text = "    <r07 ukazovatel=\"687\"><![CDATA[".$riadok."]]></r07>"."\r\n";   fwrite($soubor, $text);

  $riadok=$hlavicka->r08;
  if( $riadok == 0 ) $riadok="";
  $text = "    <r08 ukazovatel=\"688\"><![CDATA[".$riadok."]]></r08>"."\r\n";   fwrite($soubor, $text);

  $riadok=$hlavicka->r09;
  if( $riadok == 0 ) $riadok="";
  $text = "    <r09 ukazovatel=\"689\"><![CDATA[".$riadok."]]></r09>"."\r\n";   fwrite($soubor, $text);

  $riadok=$hlavicka->r10;
  if( $riadok == 0 ) $riadok="";
  $text = "    <r10 ukazovatel=\"690\"><![CDATA[".$riadok."]]></r10>"."\r\n";   fwrite($soubor, $text);

  $riadok=$hlavicka->r11;
  if( $riadok == 0 ) $riadok="";
  $text = "    <r11 ukazovatel=\"691\"><![CDATA[".$riadok."]]></r11>"."\r\n";   fwrite($soubor, $text);

  $riadok=$hlavicka->r12;
  if( $riadok == 0 ) $riadok="";
  $text = "    <r12 ukazovatel=\"692\"><![CDATA[".$riadok."]]></r12>"."\r\n";   fwrite($soubor, $text);

  $text = "  </telo>"."\r\n";   fwrite($soubor, $text);    

  $text = "  </dokument>"."\r\n";   fwrite($soubor, $text);  


          }
//koniec ak j=0



}
$i = $i + 1;
$j = $j + 1;
  }



fclose($soubor);
?>



<?php
if( $elsubor == 2 )
{
?>
<br />
<br />
Stiahnite si nižšie uvedený súbor XML na Váš lokálny disk a naèítajte na www.drsr.sk alebo do aplikácie eDane :
<br />
<br />
<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>
<br />
<br />


<?php
}
?>

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
