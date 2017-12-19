<HTML>
<?php

// celkovy zaciatok dokumentu TREXIMA v.2018
       do
       {
$sys = 'MZD';
$urov = 2000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

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
$citnas = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_oc = $_REQUEST['cislo_oc'];
$mes1=1;
$mes2=2;
$mes3=3;
if( $cislo_oc == 2 ) { $mes1=4; $mes2=5; $mes3=6; }
if( $cislo_oc == 3 ) { $mes1=7; $mes2=8; $mes3=9; }
if( $cislo_oc == 4 ) { $mes1=10; $mes2=11; $mes3=12; }


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$stvrtrok=1;
$vyb_ump="1.".$kli_vrok;
$vyb_ums="2.".$kli_vrok;
$vyb_umk="3.".$kli_vrok;
$mesiac="03";
if( $cislo_oc == 2 ) { $stvrtrok=2; $vyb_ump="1.".$kli_vrok; $vyb_ums="5.".$kli_vrok; $vyb_umk="6.".$kli_vrok; $mesiac="06"; }
if( $cislo_oc == 3 ) { $stvrtrok=3; $vyb_ump="1.".$kli_vrok; $vyb_ums="8.".$kli_vrok; $vyb_umk="9.".$kli_vrok; $mesiac="09"; }
if( $cislo_oc == 4 ) { $stvrtrok=4; $vyb_ump="1.".$kli_vrok; $vyb_ums="11.".$kli_vrok; $vyb_umk="12.".$kli_vrok; $mesiac="12"; }


// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);



//vymazanie vsetkych poloziek
    if ( $copern == 67 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky poloûky \r zoznamu zamestnancov a pohybov pre TREXIMU ?") )
         { window.close()  }
else
         { location.href='trexima2018.php?sys=<?php echo $sys; ?>&copern=167&page=1'  }
</script>
<?php
    }
    if ( $copern == 167 )
    {
$copern=101;
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_mzdkun';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_mzdkun!"." vynulovan· <br />";

$sqlt = 'TRUNCATE F'.$kli_vxcf.'_mzdzalkun';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_mzdzalkun!"." vynulovan· <br />";

$sqlt = 'TRUNCATE F'.$kli_vxcf.'_mzdzalvy';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_mzdzalvy!"." vynulovan· <br />";


$sqlt = 'TRUNCATE F'.$kli_vxcf.'_mzdzalsum';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_mzdzalsum!"." vynulovan· <br />";
    }


//vymazanie vsetkych poloziek
    if ( $copern == 6667 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky poloûky \r pohybov pre TREXIMU ?") )
         { window.close()  }
else
         { location.href='trexima2018.php?sys=<?php echo $sys; ?>&copern=11167&page=1'  }
</script>
<?php
    }
    if ( $copern == 11167 )
    {
$copern=101;
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_treximafir';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_treximafir!"." vynulovan· <br />";

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_treximaoc';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_treximaoc!"." vynulovan· <br />";


    }


//pracovny subor treximafir
$sql = "SELECT * FROM F$kli_vxcf"."_treximafir WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = 'DROP TABLE F'.$kli_vxcf.'_treximafir';
$vytvor = mysql_query("$vsql");

$sqlt = <<<trexima
(
   psys             INT,
   uzemie           VARCHAR(10),
   p_forma          VARCHAR(10),
   vlastnic         VARCHAR(10),
   odvetvie         VARCHAR(10),
   odb_zvaz         VARCHAR(10),
   kol_zml          VARCHAR(10),
   poc_pracz        DECIMAL(10,2) DEFAULT 0,
   poc_praczp       DECIMAL(10,2) DEFAULT 0,
   poc_pracp        DECIMAL(10,2) DEFAULT 0,
   trh_vyr          VARCHAR(10),
   ico              DECIMAL(8,0)
);  
trexima;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_treximafir'.$sqlt;
$vytvor = mysql_query("$vsql");

$sql = "ALTER TABLE F$kli_vxcf"."_treximafir ADD stvrtrok DECIMAL(2,0) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_treximafir ( ico,stvrtrok ) VALUES ( '0',1 )";
$ttqq = mysql_query("$ttvv");
}

//pracovny subor treximaoc
$sql = "SELECT * FROM F$kli_vxcf"."_treximaoc WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = 'DROP TABLE F'.$kli_vxcf.'_treximaoc';
$vytvor = mysql_query("$vsql");

$sqlt = <<<trexima
(
   psys             INT,
   idec             INT(5),
   zamest           VARCHAR(10),
   vzdelanie        VARCHAR(2),
   tartrieda        VARCHAR(2),
   typzmluvy        VARCHAR(10),
   zakon            VARCHAR(2),
   stprisl          VARCHAR(5),
   ico              DECIMAL(8,0)
);  
trexima;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_treximaoc'.$sqlt;
$vytvor = mysql_query("$vsql");

$sql = "ALTER TABLE F$kli_vxcf"."_treximaoc ADD stvrtrok DECIMAL(2,0) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_treximaoc ADD bydlisko VARCHAR(10) AFTER typzmluvy";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_treximaoc ADD pracovisko VARCHAR(10) AFTER typzmluvy";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_treximaoc ADD miesto VARCHAR(2) AFTER stprisl";
$vysledek = mysql_query("$sql");

}

//koniec pracovny subor

$sql = "SELECT skisco08 FROM F$kli_vxcf"."_treximaoc WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_treximaoc ADD odborvzdelania VARCHAR(25) NOT NULL AFTER stvrtrok";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_treximaoc ADD postihnutie VARCHAR(2) NOT NULL AFTER stvrtrok";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_treximaoc ADD pracpozicia VARCHAR(40) NOT NULL AFTER stvrtrok";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_treximaoc ADD skisco08 VARCHAR(10) NOT NULL AFTER stvrtrok";
$vysledek = mysql_query("$sql");
}

//zaktualizuj podla mzdkun
$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc > 0";
$posl = mysql_query("$poslhh"); 
$pocetoc = mysql_num_rows($posl);
if( $pocetoc > 0 )
{

$sqlt = "DROP TABLE F".$kli_vxcf."_treximaocprenos";
$vysledok = mysql_query("$sqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_treximaocpovodne";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_treximaocpovodne SELECT * FROM F".$kli_vxcf."_treximaoc WHERE idec >= 0";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaocpovodne SET psys=9 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaocpovodne,F$kli_vxcf"."_mzdkun SET ".
" F$kli_vxcf"."_treximaocpovodne.psys=0 WHERE F$kli_vxcf"."_treximaocpovodne.idec = F$kli_vxcf"."_mzdkun.oc ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "DELETE FROM F$kli_vxcf"."_treximaocpovodne WHERE psys = 9";
$dsql = mysql_query("$dsqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_treximaocprenos SELECT * FROM F".$kli_vxcf."_treximaoc WHERE idec = 0";
$vysledek = mysql_query("$sql");

$sql = "INSERT INTO F".$kli_vxcf."_treximaocprenos SELECT 0,oc,'','','','','','','','','',0,0,'','','','' FROM F".$kli_vxcf."_mzdkun WHERE oc >= 0";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaocprenos,F$kli_vxcf"."_treximaoc SET ".
" F$kli_vxcf"."_treximaocprenos.psys=9 WHERE F$kli_vxcf"."_treximaocprenos.idec = F$kli_vxcf"."_treximaoc.idec ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "DELETE FROM F$kli_vxcf"."_treximaoc WHERE idec >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_treximaoc SELECT ".
"*  FROM F$kli_vxcf"."_treximaocprenos WHERE psys != 9";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_treximaoc SELECT ".
"*  FROM F$kli_vxcf"."_treximaocpovodne ".
" WHERE psys != 9";
$dsql = mysql_query("$dsqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_treximaocprenos";
$vysledok = mysql_query("$sqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_treximaocpovodne";
$vysledok = mysql_query("$sqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaoc SET psys=0";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaoc SET stprisl='SK' WHERE stprisl='' ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaoc SET vzdelanie='F' WHERE vzdelanie='' ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaoc SET vzdelanie='F' WHERE vzdelanie='' ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaoc SET typzmluvy='1' WHERE typzmluvy='' ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaoc SET tartrieda='99' WHERE tartrieda='' ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaoc SET zakon='1' WHERE zakon='' ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaoc SET miesto='4' WHERE miesto='' ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaoc SET pracovisko='205' WHERE pracovisko='' ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaoc SET bydlisko='205' WHERE bydlisko='' ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaoc SET postihnutie='3' WHERE postihnutie='' ";
$oznac = mysql_query("$sqtoz");

//zamest pre agrostav
if ( $fir_fico == 31419623 )
    {
$sqtoz = "UPDATE F$kli_vxcf"."_treximaoc SET zamest='712909' WHERE idec >= 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaoc SET zamest='311214' WHERE idec > 0 AND idec < 999 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaoc SET zamest='123101' WHERE idec = 5 OR idec = 161 OR idec = 162 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaoc SET zamest='214209' WHERE idec = 57 OR idec = 83 OR idec = 96".
" OR idec = 97 OR idec = 194 OR idec = 206 OR idec = 214 OR idec = 3582 ";
$oznac = mysql_query("$sqtoz");
    }
}
//koniec zaktualizuj podla kun


// zapis upravene udaje strana 1
if ( $copern == 3 )
    {
$uzemie = strip_tags($_REQUEST['uzemie']);
$p_forma = strip_tags($_REQUEST['p_forma']);
$vlastnic = strip_tags($_REQUEST['vlastnic']);
$odvetvie = strip_tags($_REQUEST['odvetvie']);
$odb_zvaz = strip_tags($_REQUEST['odb_zvaz']);
$kol_zml = strip_tags($_REQUEST['kol_zml']);
$poc_pracz = strip_tags($_REQUEST['poc_pracz']);
$poc_praczp = strip_tags($_REQUEST['poc_praczp']);
$poc_pracp = strip_tags($_REQUEST['poc_pracp']);
$trh_vyr = strip_tags($_REQUEST['trh_vyr']);



$uprav="NO";


$uprtxt = "UPDATE F$kli_vxcf"."_treximafir SET ".
" uzemie='$uzemie',p_forma='$p_forma',vlastnic='$vlastnic',odvetvie='$odvetvie',odb_zvaz='$odb_zvaz',kol_zml='$kol_zml',  ".
" poc_pracz='$poc_pracz',poc_praczp='$poc_praczp',poc_pracp='$poc_pracp',trh_vyr='$trh_vyr' ".
" WHERE ico = 0"; 

//echo $uprtxt;

$upravene = mysql_query("$uprtxt");  
$copern=1;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenych udajov strana 1


// zapis upravene udaje strana 2
if ( $copern == 103 )
    {

$idec = strip_tags($_REQUEST['idec']);
$zamest = strip_tags($_REQUEST['zamest']);
$vzdelanie = strip_tags($_REQUEST['vzdelanie']);
$tartrieda = strip_tags($_REQUEST['tartrieda']);
$typzmluvy = strip_tags($_REQUEST['typzmluvy']);
$zakon = strip_tags($_REQUEST['zakon']);
$stprisl = strip_tags($_REQUEST['stprisl']);
$pracovisko = strip_tags($_REQUEST['pracovisko']);
$bydlisko = strip_tags($_REQUEST['bydlisko']);
$miesto = strip_tags($_REQUEST['miesto']);
$skisco08 = strip_tags($_REQUEST['skisco08']);
$pracpozicia = strip_tags($_REQUEST['pracpozicia']);
$postihnutie = strip_tags($_REQUEST['postihnutie']);
$odborvzdelania = strip_tags($_REQUEST['odborvzdelania']);

$uprav="NO";


$uprtxt = "UPDATE F$kli_vxcf"."_treximaoc SET ".
" zamest='$zamest', vzdelanie='$vzdelanie', tartrieda='$tartrieda', typzmluvy='$typzmluvy', zakon='$zakon',  ".
" skisco08='$skisco08', pracpozicia='$pracpozicia', postihnutie='$postihnutie', odborvzdelania='$odborvzdelania', ".
" stprisl='$stprisl', pracovisko='$pracovisko', bydlisko='$bydlisko', miesto='$miesto'  ".
" WHERE idec = $idec"; 

//echo $uprtxt;

$upravene = mysql_query("$uprtxt");  
$copern=101;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenych udajov strana 2

//nacitaj udaje firmy
if ( $copern >= 1 )
    {

$sqlfir = "SELECT * FROM F$kli_vxcf"."_treximafir WHERE ico = 0";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);


$uzemie = $fir_riadok->uzemie;
$p_forma = $fir_riadok->p_forma;
$vlastnic = $fir_riadok->vlastnic;
$odvetvie = $fir_riadok->odvetvie;
$odb_zvaz = $fir_riadok->odb_zvaz;
$kol_zml = $fir_riadok->kol_zml;
$poc_pracz = $fir_riadok->poc_pracz;
$poc_praczp = $fir_riadok->poc_praczp;
$poc_pracp = $fir_riadok->poc_pracp;
$trh_vyr = $fir_riadok->trh_vyr;


mysql_free_result($fir_vysledok);

    }
//koniec nacitania firmy


//nacitaj udaje zamestnanca
if ( $copern > 100 )
    {

$idec = 1*strip_tags($_REQUEST['idec']);


$sqlfir = "SELECT * FROM F$kli_vxcf"."_treximaoc ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_treximaoc.idec=F$kli_vxcf"."_mzdkun.oc".
" WHERE idec = $idec ORDER BY idec";

//echo $sqlfir;

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);


$zamest = $fir_riadok->zamest;
$vzdelanie = $fir_riadok->vzdelanie;
$tartrieda = $fir_riadok->tartrieda;
$typzmluvy = $fir_riadok->typzmluvy;
$zakon = $fir_riadok->zakon;
$stprisl = $fir_riadok->stprisl;
$prie = $fir_riadok->prie;
$meno = $fir_riadok->meno;
$pracovisko = $fir_riadok->pracovisko;
$bydlisko = $fir_riadok->bydlisko;
$miesto = $fir_riadok->miesto;
$skisco08 = $fir_riadok->skisco08;
$pracpozicia = $fir_riadok->pracpozicia;
$postihnutie = $fir_riadok->postihnutie;
$odborvzdelania = $fir_riadok->odborvzdelania;

mysql_free_result($fir_vysledok);

    }
//koniec nacitania zamestnanca


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>TREXIMA</title>
  <style type="text/css">

  </style>
</SCRIPT>
<script type="text/javascript">


<?php
//uprava sadzby strana 1
  if ( $copern == 2 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.uzemie.value = '<?php echo "$uzemie";?>';

    document.formv1.p_forma.value = '<?php echo "$p_forma";?>';
    document.formv1.vlastnic.value = '<?php echo "$vlastnic";?>';
    document.formv1.odvetvie.value = '<?php echo "$odvetvie";?>';
    document.formv1.odb_zvaz.value = '<?php echo "$odb_zvaz";?>';
    document.formv1.kol_zml.value = '<?php echo "$kol_zml";?>';
    document.formv1.poc_pracz.value = '<?php echo "$poc_pracz";?>';
    document.formv1.poc_praczp.value = '<?php echo "$poc_praczp";?>';
    document.formv1.poc_pracp.value = '<?php echo "$poc_pracp";?>';
    document.formv1.trh_vyr.value = '<?php echo "$trh_vyr";?>';


    }
<?php
//koniec uprava
  }
?>

<?php
//uprava sadzby strana 2
  if ( $copern == 102 )
  { 
?>
    function ObnovUI()
    {

    document.formv1.zamest.value = '<?php echo "$zamest";?>';
    document.formv1.vzdelanie.value = '<?php echo "$vzdelanie";?>';
    document.formv1.tartrieda.value = '<?php echo "$tartrieda";?>';
    document.formv1.typzmluvy.value = '<?php echo "$typzmluvy";?>';
    document.formv1.zakon.value = '<?php echo "$zakon";?>';
    document.formv1.stprisl.value = '<?php echo "$stprisl";?>';
    document.formv1.pracovisko.value = '<?php echo "$pracovisko";?>';
    document.formv1.bydlisko.value = '<?php echo "$bydlisko";?>';
    document.formv1.miesto.value = '<?php echo "$miesto";?>';
    document.formv1.skisco08.value = '<?php echo "$skisco08";?>';
    document.formv1.pracpozicia.value = '<?php echo "$pracpozicia";?>';
    document.formv1.postihnutie.value = '<?php echo "$postihnutie";?>';
    document.formv1.odborvzdelania.value = '<?php echo "$odborvzdelania";?>';

        document.forms.formv1.zamest.focus();
        document.forms.formv1.zamest.select();
    }
<?php
//koniec uprava
  }
?>

<?php
//nie uprava
  if ( $copern != 2 AND $copern != 102 )
  { 
?>
    function ObnovUI()
    {

    }
<?php
//koniec uprava
  }
?>



</script>



</HEAD>
<BODY class="white" onload="ObnovUI();" >

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  
<?php
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 OR $copern == 11 OR $copern == 12 OR $copern == 13 ) 
{ echo "V˝kaz o cene pr·ce ISCP 1-04 / V˝kaz PLATY 1-02";
}
?>
<?php
  if ( $copern == 101 OR $copern == 102 OR $copern == 103 ) { echo "ätvrùroËn˝ v˝kaz o cene pr·ce ISCP 1-04";
}
?>
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//zobraz nastavene udaje strana 1
if ( $copern == 1 OR $copern == 3 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 2 desatinnÈ miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 4 desatinnÈ miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 1 desatinnÈ miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_oc;?> spr·vne uloûen·</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="trexima2018.php?copern=2" >
<tr>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
</tr>

<tr><td class="bmenu" colspan="5">DoplÚuj˙ce udaje o firme</td>
<td class="bmenu" colspan="3"> </td>
<td class="obyc" colspan="2" align="right"><INPUT type="submit" id="uloz" name="uloz" value="Upraviù ˙daje"></td>
</tr>

<tr><td class="bmenu" colspan="5">⁄zemie (kÛd okresu)</td>
<td class="fmenu" colspan="3" align="left"><?php echo "$uzemie";?></td></tr>

<tr><td class="bmenu" colspan="5">Pr·vna forma</td>
<td class="fmenu" colspan="3" align="left"><?php echo "$p_forma";?></td></tr>

<tr><td class="bmenu" colspan="5">VlastnÌctvo (kÛd DRVLST)</td>
<td class="fmenu" colspan="3" align="left"><?php echo "$vlastnic";?></td></tr>

<tr><td class="bmenu" colspan="5">Odvetvie</td>
<td class="fmenu" colspan="3" align="left"><?php echo "$odvetvie";?></td></tr>

<tr><td class="bmenu" colspan="5">Odborov˝ zv‰z</td>
<td class="fmenu" colspan="3" align="left"><?php echo "$odb_zvaz";?></td></tr>

<tr><td class="bmenu" colspan="5">KolektÌvna zmluva</td>
<td class="fmenu" colspan="3" align="left"><?php echo "$kol_zml";?></td></tr>

<tr><td class="bmenu" colspan="5">Priemern˝ evidenËn˝ poËet zamestnancov z·vodu spravodajskej jednotky</td>
<td class="fmenu" colspan="3" align="left"><?php echo "$poc_pracz";?></td></tr>

<tr><td class="bmenu" colspan="5">Priemern˝ evidenËn˝ poËet zamestnancov spravodajskej jednotky prepoËÌtan˝</td>
<td class="fmenu" colspan="3" align="left"><?php echo "$poc_praczp";?></td></tr>

<tr><td class="bmenu" colspan="5">Priemern˝ evidenËn˝ poËet zamestnancov organiz·cie, ku ktorej spr.jednotka patrÌ</td>
<td class="fmenu" colspan="3" align="left"><?php echo "$poc_pracp";?></td></tr>

<tr><td class="bmenu" colspan="5">Odbytov˝ trh v˝robkov</td>
<td class="fmenu" colspan="3" align="left"><?php echo "$trh_vyr";?></td></tr>

</FORM>

</table>
<?php
    }
//koniec zobrazenia udajov strana 1
?>

<?php
//zobraz nastavene udaje strana 2
if ( $copern == 101 OR $copern == 103 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 2 desatinnÈ miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 4 desatinnÈ miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 1 desatinnÈ miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_oc;?> spr·vne uloûen·</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="trexima2018.php?copern=102" >
<tr>
<td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td>
<td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td>
<td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td>
<td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td>
<td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td>
<td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td>
</tr>

<tr><td class="bmenu" colspan="5">DoplÚuj˙ce udaje o zamestnancoch</td>
<td class="bmenu" colspan="3"> 
<?php
$umesp=0;
$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ( oc > 0 AND akt != 9 ) ORDER BY ume";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if ( $umesp == 0 )
  {
?>
<td class="hmenu" ><a href='trexima2018.php?sys=<?php echo $sys; ?>&copern=67&page=1'>
<img src='../obr/kos.png' width=20 height=15 border=0 title="Vymazanie vöetk˝ch poloûiek"></a>
<a href='trexima2018.php?sys=<?php echo $sys; ?>&copern=55&page=1'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Import ˙dajov"></a>
<?php
  }
?>
</td>
</tr>

<?php

$sqltt = "SELECT * FROM F$kli_vxcf"."_treximaoc ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_treximaoc.idec=F$kli_vxcf"."_mzdkun.oc".
" WHERE idec >= 0 ORDER BY idec";
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
?>

<tr>
<td class="hmenu" colspan="3" >Zamestnanec - ËÌslo,priezvisko,meno</td>
<td class="hmenu" colspan="1" >KÛd Ëinnosti
  <a href="#" onClick="window.open('../dokumenty/trexima/kzam.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >KÛd SKISCO
  <a href="#" onClick="window.open('../dokumenty/trexima/skisco.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Prac.pozÌcia
<img src='../obr/help.png' width=12 height=12 border=0 title='Intern˝ n·zov prac.pozÌcie vo Vaöej firme max.30 znakov' ></a>
</td>
<td class="hmenu" colspan="1" >Postihnutie
  <a href="#" onClick="window.open('../dokumenty/trexima/postihnutie.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Vzdelanie
  <a href="#" onClick="window.open('../dokumenty/trexima/vzdelanie.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Odbor vzdelania
  <a href="#" onClick="window.open('../dokumenty/trexima/odborvzdelania.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Tarifn· TR</td>
<td class="hmenu" colspan="1" >Typ zmluvy
  <a href="#" onClick="window.open('../dokumenty/trexima/prac_zml.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Pracovisko
  <a href="#" onClick="window.open('../dokumenty/trexima/uzemie.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Bydlisko
  <a href="#" onClick="window.open('../dokumenty/trexima/uzemie.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Odmena podæa z·kona
  <a href="#" onClick="window.open('../dokumenty/trexima/zakon.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >ät·tna prÌsl.
  <a href="#" onClick="window.open('../dokumenty/trexima/st_prisl.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Prac.miesto
  <a href="#" onClick="window.open('../dokumenty/trexima/prac_miesto.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Editovaù</td>
</tr>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="fmenu" colspan="3" ><?php echo $riadok->idec;?> <?php echo $riadok->prie;?>, <?php echo $riadok->meno;?>, <?php echo $riadok->titl;?> PP<?php echo $riadok->pom;?></td>
<td class="fmenu" ><?php echo $riadok->zamest;?></td>
<td class="fmenu" ><?php echo $riadok->skisco08;?></td>
<td class="fmenu" ><?php echo $riadok->pracpozicia;?></td>
<td class="fmenu" ><?php echo $riadok->postihnutie;?></td>
<td class="fmenu" ><?php echo $riadok->vzdelanie;?></td>
<td class="fmenu" ><?php echo $riadok->odborvzdelania;?></td>
<td class="fmenu" ><?php echo $riadok->tartrieda;?></td>
<td class="fmenu" ><?php echo $riadok->typzmluvy;?></td>
<td class="fmenu" ><?php echo $riadok->pracovisko;?></td>
<td class="fmenu" ><?php echo $riadok->bydlisko;?></td>
<td class="fmenu" ><?php echo $riadok->zakon;?></td>
<td class="fmenu" ><?php echo $riadok->stprisl;?></td>
<td class="fmenu" ><?php echo $riadok->miesto;?></td>

<td class="fmenu" >
<a href='trexima2018.php?copern=102&idec=<?php echo $riadok->idec;?>&drupoh=<?php echo $drupoh;?>&uprav=1'>
<img src='../obr/uprav.png' width=15 height=10 border=0 title="Upraviù riadok" ></a>
</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

</FORM>

</table>
<?php
    }
//koniec zobrazenia udajov strana 2
?>

<?php
//upravy  udaje strana 1
if ( $copern == 2 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 2 desatinnÈ miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 4 desatinnÈ miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 1 desatinnÈ miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_oc;?> spr·vne uloûen·</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="trexima2018.php?copern=3" >
<tr>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%">
<td class="hmenu" >
<a href='trexima2018.php?sys=<?php echo $sys; ?>&copern=6667&page=1'>
<img src='../obr/kos.png' width=20 height=15 border=0 title="Vymazanie vöetk˝ch poloûiek ötatistick˝ch ˙dajov o zamestnancoch"></a>
</td>
</tr>


<tr><td class="bmenu" colspan="5">DoplÚuj˙ce udaje o firme</td>
<td class="bmenu" colspan="5"> </td>
</tr>

<tr><td class="bmenu" colspan="5">⁄zemie (kÛd okresu)</td>
<td class="fmenu" colspan="3" align="left"><input type="text" name="uzemie" id="uzemie" size="10"/>
  <a href="#" onClick="window.open('../dokumenty/trexima/uzemie.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td></tr>

<tr><td class="bmenu" colspan="5">Pr·vna forma</td>
<td class="fmenu" colspan="3" align="left"><input type="text" name="p_forma" id="p_forma" size="10"/>
  <a href="#" onClick="window.open('../dokumenty/trexima/p_forma.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td></tr>

<tr><td class="bmenu" colspan="5">VlastnÌctvo (kÛd DRVLST)</td>
<td class="fmenu" colspan="3" align="left"><input type="text" name="vlastnic" id="vlastnic" size="10"/>
  <a href="#" onClick="window.open('../dokumenty/trexima/vlastnictvo.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td></tr>

<tr><td class="bmenu" colspan="5">Odvetvie</td>
<td class="fmenu" colspan="3" align="left"><input type="text" name="odvetvie" id="odvetvie" size="10"/>
  <a href="#" onClick="window.open('../dokumenty/trexima/odvetvie.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td></tr>

<tr><td class="bmenu" colspan="5">Odborov˝ zv‰z</td>
<td class="fmenu" colspan="3" align="left"><input type="text" name="odb_zvaz" id="odb_zvaz" size="10"/>
  <a href="#" onClick="window.open('../dokumenty/trexima/odb_zvaz.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td></tr>

<tr><td class="bmenu" colspan="5">KolektÌvna zmluva</td>
<td class="fmenu" colspan="3" align="left"><input type="text" name="kol_zml" id="kol_zml" size="10"/>
  <a href="#" onClick="window.open('../dokumenty/trexima/kol_zml.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td></tr>

<tr><td class="bmenu" colspan="5">Priemern˝ evidenËn˝ poËet zamestnancov z·vodu spravodajskej jednotky</td>
<td class="fmenu" colspan="3" align="left"><input type="text" name="poc_pracz" id="poc_pracz" size="10"/></td></tr>

<tr><td class="bmenu" colspan="5">Priemern˝ evidenËn˝ poËet zamestnancov spravodajskej jednotky prepoËÌtan˝</td>
<td class="fmenu" colspan="3" align="left"><input type="text" name="poc_praczp" id="poc_praczp" size="10"/></td></tr>

<tr><td class="bmenu" colspan="5">Priemern˝ evidenËn˝ poËet zamestnancov organiz·cie, ku ktorej spr.jednotka patrÌ</td>
<td class="fmenu" colspan="3" align="left"><input type="text" name="poc_pracp" id="poc_pracp" size="10"/></td></tr>

<tr><td class="bmenu" colspan="5">Odbytov˝ trh v˝robkov</td>
<td class="fmenu" colspan="3" align="left"><input type="text" name="trh_vyr" id="trh_vyr" size="10"/>
  <a href="#" onClick="window.open('../dokumenty/trexima/trh_vyr.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td></tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù ˙pravy"></td>
</tr>
</FORM>

<FORM name="formv2" class="obyc" method="post" action="trexima2018.php?copern=1" >
<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Koniec neuloûiù"></td>
</tr>
</FORM>

</table>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>


<script type="text/javascript">

</script>

<?php
//mysql_free_result($vysledok);
    }
//koniec uprav  udaje strana 1
?>


<?php
//upravy  udaje strana 2
if ( $copern == 102 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 2 desatinnÈ miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 4 desatinnÈ miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 1 desatinnÈ miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_oc;?> spr·vne uloûen·</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="trexima2018.php?copern=103" >
<tr>
<td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td>
<td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td>
<td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td>
<td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td>
<td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td>
<td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td><td class="bmenu" width="6%"></td>
</tr>

<tr><td class="bmenu" colspan="5">DoplÚuj˙ce udaje o zamestnancoch</td>
<td class="bmenu" colspan="3"> </td>
</tr>

<?php

$sqltt = "SELECT * FROM F$kli_vxcf"."_treximaoc ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_treximaoc.idec=F$kli_vxcf"."_mzdkun.oc".
" WHERE idec >= 0 ORDER BY idec";
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
?>

<tr>
<td class="hmenu" colspan="3" >Zamestnanec - ËÌslo,priezvisko,meno</td>
<td class="hmenu" colspan="1" >KÛd Ëinnosti
  <a href="#" onClick="window.open('../dokumenty/trexima/kzam.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >KÛd SKISCO
  <a href="#" onClick="window.open('../dokumenty/trexima/skisco.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Prac.pozÌcia
<img src='../obr/help.png' width=12 height=12 border=0 title='Intern˝ n·zov prac.pozÌcie vo Vaöej firme max.30 znakov' ></a>
</td>
<td class="hmenu" colspan="1" >Postihnutie
  <a href="#" onClick="window.open('../dokumenty/trexima/postihnutie.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Vzdelanie
  <a href="#" onClick="window.open('../dokumenty/trexima/vzdelanie.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Odbor vzdelania
  <a href="#" onClick="window.open('../dokumenty/trexima/odborvzdelania.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Tarifn· TR</td>
<td class="hmenu" colspan="1" >Typ zmluvy
  <a href="#" onClick="window.open('../dokumenty/trexima/prac_zml.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Pracovisko
  <a href="#" onClick="window.open('../dokumenty/trexima/uzemie.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Bydlisko
  <a href="#" onClick="window.open('../dokumenty/trexima/uzemie.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Odmena podæa z·kona
  <a href="#" onClick="window.open('../dokumenty/trexima/zakon.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >ät·tna prÌsl.
  <a href="#" onClick="window.open('../dokumenty/trexima/st_prisl.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Prac.miesto
  <a href="#" onClick="window.open('../dokumenty/trexima/prac_miesto.htm', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/help.png' width=12 height=12 border=0 title='Zobraziù ËÌselnÌk' ></a>
</td>
<td class="hmenu" colspan="1" >Editovaù</td>
</tr>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="fmenu" colspan="3" ><?php echo $riadok->idec;?> <?php echo $riadok->prie;?>, <?php echo $riadok->meno;?>, <?php echo $riadok->titl;?></td>
<td class="fmenu" ><?php echo $riadok->zamest;?></td>
<td class="fmenu" ><?php echo $riadok->skisco08;?></td>
<td class="fmenu" ><?php echo $riadok->pracpozicia;?></td>
<td class="fmenu" ><?php echo $riadok->postihnutie;?></td>
<td class="fmenu" ><?php echo $riadok->vzdelanie;?></td>
<td class="fmenu" ><?php echo $riadok->odborvzdelania;?></td>
<td class="fmenu" ><?php echo $riadok->tartrieda;?></td>
<td class="fmenu" ><?php echo $riadok->typzmluvy;?></td>
<td class="fmenu" ><?php echo $riadok->pracovisko;?></td>
<td class="fmenu" ><?php echo $riadok->bydlisko;?></td>
<td class="fmenu" ><?php echo $riadok->zakon;?></td>
<td class="fmenu" ><?php echo $riadok->stprisl;?></td>
<td class="fmenu" ><?php echo $riadok->miesto;?></td>

<td class="fmenu" ></td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<tr>
<td class="bmenu" colspan="10" align="left">Editovaù zamestnanca</td>
</tr>

<tr>
<td class="fmenu" colspan="3" align="left"><?php echo $idec;?> <?php echo $prie;?>, <?php echo $meno;?></td>
<td class="fmenu" colspan="1" align="left"><input type="text" name="zamest" id="zamest" size="8"/></td>
<td class="fmenu" colspan="1" align="left"><input type="text" name="skisco08" id="skisco08" size="7"/></td>
<td class="fmenu" colspan="1" align="left"><input type="text" name="pracpozicia" id="pracpozicia" size="30"/></td>
<td class="fmenu" colspan="1" align="left"><input type="text" name="postihnutie" id="postihnutie" size="2"/></td>
<td class="fmenu" colspan="1" align="left"><input type="text" name="vzdelanie" id="vzdelanie" size="8"/></td>
<td class="fmenu" colspan="1" align="left"><input type="text" name="odborvzdelania" id="odborvzdelania" size="8"/></td>
<td class="fmenu" colspan="1" align="left"><input type="text" name="tartrieda" id="tartrieda" size="8"/></td>
<td class="fmenu" colspan="1" align="left"><input type="text" name="typzmluvy" id="typzmluvy" size="8"/></td>
<td class="fmenu" colspan="1" align="left"><input type="text" name="pracovisko" id="pracovisko" size="8"/></td>
<td class="fmenu" colspan="1" align="left"><input type="text" name="bydlisko" id="bydlisko" size="8"/></td>
<td class="fmenu" colspan="1" align="left"><input type="text" name="zakon" id="zakon" size="8"/></td>
<td class="fmenu" colspan="1" align="left"><input type="text" name="stprisl" id="stprisl" size="8"/></td>
<td class="fmenu" colspan="1" align="left"><input type="text" name="miesto" id="miesto" size="8"/></td>
<td class="fmenu" colspan="1" align="left"> </td>
<input class="hvstup" type="hidden" name="idec" id="idec" value="<?php echo $idec;?>" />
</tr>



<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù ˙pravy"></td>
</tr>
</FORM>

<FORM name="formv2" class="obyc" method="post" action="trexima2018.php?copern=101" >
<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Koniec neuloûiù"></td>
</tr>
</FORM>

</table>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>


<script type="text/javascript">

</script>

<?php
//mysql_free_result($vysledok);
    }
//koniec uprav  udaje strana 2
?>



<?php
//zostava PDF a odoslanie
if( $copern == 11 OR $copern == 12 OR $copern == 13 )
          {
if (File_Exists ("../tmp/statistika.$kli_uzid.pdf")) { $soubor = unlink("../tmp/statistika.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$pdf=new FPDF("L","mm", "A4" );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//pracovny subor
$vsql = 'DROP TABLE F'.$kli_vxcf.'_treximaprac';
$vytvor = mysql_query("$vsql");

$sqlt = <<<trexima
(
   prx              INT,
   idec             INT(5),
   dm               VARCHAR(10),
   hod              DECIMAL(10,2) DEFAULT 0,
   kc               DECIMAL(10,2) DEFAULT 0,
   ume              DECIMAL(7,4) DEFAULT 0,
   konz1            INT,
   vek              DECIMAL(4,0),
   pohlavie         DECIMAL(4,0) DEFAULT 1,
   dobzam           VARCHAR(2),
   pracuv           VARCHAR(2),
   percento         DECIMAL(10,2) DEFAULT 0,
   tyzdfond         DECIMAL(10,2) DEFAULT 0,
   konx1            INT,
   odpracd          DECIMAL(10,2) DEFAULT 0,
   nadcas           DECIMAL(10,2) DEFAULT 0,
   dovolenka        DECIMAL(10,2) DEFAULT 0,
   pn               DECIMAL(10,2) DEFAULT 0,
   pvn              DECIMAL(10,2) DEFAULT 0,
   pv               DECIMAL(10,2) DEFAULT 0,
   konx2            INT,
   cenaprace        DECIMAL(10,2) DEFAULT 0,
   zucmzda          DECIMAL(10,2) DEFAULT 0,
   zakmzda          DECIMAL(10,2) DEFAULT 0,
   priplad          DECIMAL(10,2) DEFAULT 0,
   premodm          DECIMAL(10,2) DEFAULT 0,
   mzdapoh          DECIMAL(10,2) DEFAULT 0,
   nahrady          DECIMAL(10,2) DEFAULT 0,
   ostatne          DECIMAL(10,2) DEFAULT 0,
   konx3            INT,
   mzdanadcas       DECIMAL(10,2) DEFAULT 0,
   sporenie         DECIMAL(10,2) DEFAULT 0,
   nahzapoh         DECIMAL(10,2) DEFAULT 0,
   nahpn            DECIMAL(10,2) DEFAULT 0,
   plnzisk          DECIMAL(10,2) DEFAULT 0,
   cistmzda         DECIMAL(10,2) DEFAULT 0,
   priemzda         DECIMAL(10,4) DEFAULT 0,
   konx4            INT,
   bolk01           DECIMAL(10,0) DEFAULT 0,
   bolk02           DECIMAL(10,0) DEFAULT 0,
   bolk03           DECIMAL(10,0) DEFAULT 0,
   icox             DECIMAL(8,0),
   zucmzdao         DECIMAL(10,2) DEFAULT 0,
   mzdnadcaso       DECIMAL(10,2) DEFAULT 0,
   mzdzvyho         DECIMAL(10,2) DEFAULT 0,
   psn              DECIMAL(10,2) DEFAULT 0,
   plathodo         DECIMAL(10,2) DEFAULT 0,
   osn              DECIMAL(10,2) DEFAULT 0,
   nadcashodo       DECIMAL(10,2) DEFAULT 0
);  
trexima;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_treximaprac'.$sqlt;
$vytvor = mysql_query("$vsql");


$dsqlt = "INSERT INTO F$kli_vxcf"."_treximaprac SELECT".
" 1,oc,dm,hod,kc,ume,".
"0,".//konz1;
"'','','','',0,0,".
"0,".//konx1;
"0,0,0,0,0,0,".
"0,".//konx2;
"0,0,0,0,0,0,0,0,".
"0,".//konx3;
"0,0,0,0,0,0,0,".
"0,0,0,0,".//konx4;
"0,".
"0,0,0,0,0,0,0 ".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume >= $vyb_ump AND ume <= $vyb_umk ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//daj prec dohody a vystupeny minuly rok
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdzalkun ".
" SET icox=pom WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdzalkun.oc AND F$kli_vxcf"."_treximaprac.ume=F$kli_vxcf"."_mzdzalkun.ume ";
$oznac = mysql_query("$sqtoz");

$dat11=$kli_vrok."-01-01";

//daj prec dohody a vystupeny minuly rok
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdzalkun ".
" SET icox=99 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdzalkun.oc AND F$kli_vxcf"."_treximaprac.ume=F$kli_vxcf"."_mzdzalkun.ume ".
" AND pom=9 AND dav < '$dat11' AND dav > '0000-00-00' ";
$oznac = mysql_query("$sqtoz");

//exit;

$sqtoz = "DELETE FROM F$kli_vxcf"."_treximaprac WHERE icox >= 50 OR icox = 2 OR icox = 6 OR icox = 8 "; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET icox=0 "; 
$oznac = mysql_query("$sqtoz");

//hodiny
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET odpracd=hod WHERE ( dm > 100 AND dm < 110 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET nadcas=hod WHERE ( dm = 201 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET dovolenka=hod WHERE ( dm = 506 OR dm = 507 OR dm = 508 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET pn=hod WHERE ( dm = 801 OR dm = 803 OR dm = 804 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET pvn=hod WHERE ( dm = 506 OR dm = 507 OR dm = 508 OR dm = 510 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET pv=hod WHERE ( dm = 502 )"; 
$oznac = mysql_query("$sqtoz");

//mzda
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET zucmzda=kc WHERE ( dm > 100 AND dm < 599 AND dm != 130 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET zakmzda=kc WHERE ( dm > 100 AND dm < 200 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET priplad=kc WHERE ( dm > 200 AND dm < 300 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET premodm=kc WHERE ( dm > 300 AND dm < 500 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET nahrady=kc WHERE ( dm > 500 AND dm < 599 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET mzdanadcas=kc WHERE ( dm = 201 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET nahpn=kc WHERE ( dm = 803 OR dm = 804 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET cistmzda=kc WHERE ( dm > 100 AND dm < 599 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET cistmzda=-kc WHERE ( dm = 904 OR dm = 901 OR dm = 902 OR dm = 903 )"; 
$oznac = mysql_query("$sqtoz");

//oktober
//zucmzdao         DECIMAL(10,2) DEFAULT 0,
//mzdnadcaso       DECIMAL(10,2) DEFAULT 0,
//mzdzvyho         DECIMAL(10,2) DEFAULT 0,
//psn              DECIMAL(10,2) DEFAULT 0,
//plathodo         DECIMAL(10,2) DEFAULT 0,
//osn              DECIMAL(10,2) DEFAULT 0,
//nadcashodo       DECIMAL(10,2) DEFAULT 0

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET zucmzdao=kc WHERE ( dm > 100 AND dm < 599 AND dm != 130 ) AND ume = 10.$kli_vrok "; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET mzdanadcaso=kc WHERE ( dm = 201 ) AND ume = 10.$kli_vrok "; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET mzdzvyhoo=kc WHERE ( dm = 202 OR dm = 204 OR dm = 223 OR ) AND ume = 10.$kli_vrok "; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET psn=kc WHERE ( dm = 202 ) AND ume = 10.$kli_vrok "; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET plathodo=hod WHERE ( ( dm > 100 AND dm < 109 ) OR ( dm > 504 AND dm < 520 ) ) AND ume = 10.$kli_vrok "; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET osn=hod WHERE ( dm = 202 ) AND ume = 10.$kli_vrok "; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET nadcashodo=hod WHERE ( dm = 201 ) AND ume = 10.$kli_vrok "; 
$oznac = mysql_query("$sqtoz");

//konx1  odpracd,nadcas,dovolenka,pn,pvn,pv  
//konx2  cenaprace,zucmzda,zakmzda,priplad,premodm,mzdapoh,nahrady,ostatne  
//konx3  mzdanadcas,sporenie,nahzapoh,nahpn,plnzisk,cistmzda,priemzda 

$dsqlt = "INSERT INTO F$kli_vxcf"."_treximaprac SELECT".
" 2,idec,0,0,0,ume,".
"0,".//konz1;
"'','','','',0,0,".
"0,".//konx1;
"SUM(odpracd),SUM(nadcas),SUM(dovolenka),SUM(pn),SUM(pvn),SUM(pv),".
"0,".//konx2;
"SUM(cenaprace),SUM(zucmzda),SUM(zakmzda),SUM(priplad),SUM(premodm),SUM(mzdapoh),SUM(nahrady),SUM(ostatne),".
"0,".//konx3;
"SUM(mzdanadcas),SUM(sporenie),SUM(nahzapoh),SUM(nahpn),SUM(plnzisk),SUM(cistmzda),SUM(priemzda),".
"0,0,0,0,".//konx4;
"0,".
"SUM(zucmzdao),SUM(mzdnadcaso),SUM(mzdzvyho),SUM(psn),SUM(plathodo),SUM(osn),SUM(nadcashodo) ".
" FROM F$kli_vxcf"."_treximaprac".
" WHERE idec >= 0 ".
" GROUP BY idec".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_treximaprac WHERE prx = 1"; 
$oznac = mysql_query("$sqtoz");

//vek
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET vek=$kli_vrok-1900-LEFT(rdc,2) WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc"; 
$oznac = mysql_query("$sqtoz");

//pohlavie
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET pohlavie=1 "; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET pohlavie=2 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND SUBSTRING(rdc,3,1) > 4"; 
$oznac = mysql_query("$sqtoz");

//percento uvazku
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uva_hod=$riaddok->uva_hod;
  }
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET percento=100 "; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET percento=100*(uva/$uva_hod) WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc "; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET percento=100 WHERE percento > 100 "; 
$oznac = mysql_query("$sqtoz");

//pracuv
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac SET pracuv=1 "; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET pracuv=2 WHERE percento < 95"; 
$oznac = mysql_query("$sqtoz");

//tyzdfond
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET tyzdfond=5*uva WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc "; 
$oznac = mysql_query("$sqtoz");

//priemzda
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET priemzda=znah WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc "; 
$oznac = mysql_query("$sqtoz");

//vyrad dohody pom=2
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk01=99 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND pom = 2 "; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "DELETE FROM F$kli_vxcf"."_treximaprac WHERE bolk01 = 99"; 
$oznac = mysql_query("$sqtoz");

//prepocitany zamestnanci poc_pracz,poc_pracp
if( $cislo_oc == 1 ) {
$dtm=$kli_vrok."-02-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk01=1 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dan < '$dtm' "; 
$oznac = mysql_query("$sqtoz");
$dtm=$kli_vrok."-03-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk02=1 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dan < '$dtm' "; 
$oznac = mysql_query("$sqtoz");
$dtm=$kli_vrok."-04-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk03=1 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dan < '$dtm' "; 
$oznac = mysql_query("$sqtoz");
                     }
if( $cislo_oc == 2 ) {
$dtm=$kli_vrok."-05-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk01=1 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dan < '$dtm' "; 
$oznac = mysql_query("$sqtoz");
$dtm=$kli_vrok."-06-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk02=1 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dan < '$dtm' "; 
$oznac = mysql_query("$sqtoz");
$dtm=$kli_vrok."-07-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk03=1 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dan < '$dtm' "; 
$oznac = mysql_query("$sqtoz");
                     }
if( $cislo_oc == 3 ) {
$dtm=$kli_vrok."-08-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk01=1 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dan < '$dtm' "; 
$oznac = mysql_query("$sqtoz");
$dtm=$kli_vrok."-09-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk02=1 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dan < '$dtm' "; 
$oznac = mysql_query("$sqtoz");
$dtm=$kli_vrok."-10-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk03=1 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dan < '$dtm' "; 
$oznac = mysql_query("$sqtoz");
                     }
$kli_drok=$kli_vrok+1;
if( $cislo_oc == 4 ) {
$dtm=$kli_vrok."-11-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk01=1 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dan < '$dtm' "; 
$oznac = mysql_query("$sqtoz");
$dtm=$kli_vrok."-12-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk02=1 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dan < '$dtm' "; 
$oznac = mysql_query("$sqtoz");
$dtm=$kli_drok."-01-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk03=1 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dan < '$dtm' "; 
$oznac = mysql_query("$sqtoz");
                     }




if( $cislo_oc == 1 ) {
$dtm=$kli_vrok."-02-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk01=0 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dav < '$dtm' AND dav != '0000-00-00' "; 
$oznac = mysql_query("$sqtoz");
$dtm=$kli_vrok."-03-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk02=0 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dav < '$dtm' AND dav != '0000-00-00' "; 
$oznac = mysql_query("$sqtoz");
$dtm=$kli_vrok."-04-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk03=0 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dav < '$dtm' AND dav != '0000-00-00' "; 
$oznac = mysql_query("$sqtoz");
                     }
if( $cislo_oc == 2 ) {
$dtm=$kli_vrok."-05-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk01=0 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dav < '$dtm' AND dav != '0000-00-00' "; 
$oznac = mysql_query("$sqtoz");
$dtm=$kli_vrok."-06-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk02=0 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dav < '$dtm' AND dav != '0000-00-00' "; 
$oznac = mysql_query("$sqtoz");
$dtm=$kli_vrok."-07-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk03=0 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dav < '$dtm' AND dav != '0000-00-00' "; 
$oznac = mysql_query("$sqtoz");
                     }
if( $cislo_oc == 3 ) {
$dtm=$kli_vrok."-08-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk01=0 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dav < '$dtm' AND dav != '0000-00-00' "; 
$oznac = mysql_query("$sqtoz");
$dtm=$kli_vrok."-09-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk02=0 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dav < '$dtm' AND dav != '0000-00-00' "; 
$oznac = mysql_query("$sqtoz");
$dtm=$kli_vrok."-10-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk03=0 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dav < '$dtm' AND dav != '0000-00-00' "; 
$oznac = mysql_query("$sqtoz");
                     }
if( $cislo_oc == 4 ) {
$dtm=$kli_vrok."-11-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk01=0 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dav < '$dtm' AND dav != '0000-00-00' "; 
$oznac = mysql_query("$sqtoz");
$dtm=$kli_vrok."-12-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk02=0 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dav < '$dtm' AND dav != '0000-00-00' "; 
$oznac = mysql_query("$sqtoz");
$dtm=$kli_drok."-01-01";
$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk03=0 WHERE F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_mzdkun.oc AND dav < '$dtm' AND dav != '0000-00-00' "; 
$oznac = mysql_query("$sqtoz");
                     }

$sqtoz = "UPDATE F$kli_vxcf"."_treximaprac,F$kli_vxcf"."_mzdkun SET bolk01=bolk01+bolk02+bolk03 "; 
$oznac = mysql_query("$sqtoz");

$sqltt = "SELECT * FROM F$kli_vxcf"."_treximaprac WHERE prx = 2 ".""; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$pocetzam=0;
$i=0;
  while ($i <= $pol )
  {

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$pocetzam=$pocetzam+$hlavicka->bolk01;

}
$i = $i + 1;
$j = $j + 1;
  }


$poc_pracz=$pocetzam/3;
$poc_pracp=$pocetzam/3;
$poc_praczp=$pocetzam/3;

//exit;

$Cislo=$poc_pracz+"";
$Spoc_praczv=sprintf("%0.0f", $Cislo);
$Cislo=$poc_pracp+"";
$Spoc_pracpv=sprintf("%0.0f", $Cislo);
$Cislo=$poc_praczp+"";
$Spoc_praczpv=sprintf("%0.0f", $Cislo);

//koniec vypocet poctu zamestnancov

//exit;

          }
//koniec pracovny subor copern=11,12




//subor XML
if( $copern == 12 )
          {

$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$idx=$kli_uzid.$hhmm;
$nazsub="TREXIMA_".$stvrtrok."_".$idx;


if (File_Exists ("../tmp/$nazsub.xml")) { $soubor = unlink("../tmp/$nazsub.xml"); }

$soubor = fopen("../tmp/$nazsub.xml", "a+");


//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_treximafir WHERE ico = 0 ".""; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


  $text = "<?xml version = \"1.0\" encoding=\"utf-8\" ?>"."\r\n";
  fwrite($soubor, $text);

  $text = "<iscp xsi:schemaLocation=\"http://www.trexima.sk/xsd/iscp/1 http://www.trexima.sk/xsd/iscp/1/iscp.xsd\" xmlns=\"http://www.trexima.sk/xsd/iscp/1\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">"."\r\n";
  fwrite($soubor, $text);

  $text = "<subor>"."\r\n";
  fwrite($soubor, $text);
  $text = "<zistovanie>ISCP (MPSVR SR) 1-04</zistovanie>"."\r\n"; 
  fwrite($soubor, $text);
  $text = "<obdobie_od>1".$kli_vrok."</obdobie_od>"."\r\n"; 
  fwrite($soubor, $text);
  $text = "<obdobie_do>".$mes3.$kli_vrok."</obdobie_do>"."\r\n"; 
  fwrite($soubor, $text);
  $text = "<sw_firma>Coex s.r.o.</sw_firma>"."\r\n"; 
  fwrite($soubor, $text);
  $text = "<program>EuroSecom ochranna znamka</program>"."\r\n"; 
  fwrite($soubor, $text);
  $text = "<verzia>2018_01</verzia>"."\r\n"; 
  fwrite($soubor, $text);
  $text = "</subor>"."\r\n";
  fwrite($soubor, $text);

  $text = "<respondent>"."\r\n";
  fwrite($soubor, $text);
  $text = "<ico>".$fir_fico."</ico>"."\r\n";
  fwrite($soubor, $text);

$fir_fnaz = iconv("CP1250", "UTF-8", $fir_fnaz);

  $text = "<nazov>".$fir_fnaz."</nazov>"."\r\n";
  fwrite($soubor, $text);

$fir_fuli = iconv("CP1250", "UTF-8", $fir_fuli);

  $text = "<ul_cis>".$fir_fuli." ".$fir_fcdm."</ul_cis>"."\r\n";
  fwrite($soubor, $text);

$fir_fmes = iconv("CP1250", "UTF-8", $fir_fmes);

  $text = "<obec>".$fir_fmes."</obec>"."\r\n";
  fwrite($soubor, $text);

$fir_fpsc=str_replace(" ","",$fir_fpsc);

  $text = "<psc>".$fir_fpsc."</psc>"."\r\n";
  fwrite($soubor, $text);
  $text = "<uzemie>".$hlavicka->uzemie."</uzemie>"."\r\n";
  fwrite($soubor, $text);
  $text = "<p_forma>".$hlavicka->p_forma."</p_forma>"."\r\n";
  fwrite($soubor, $text);
  $text = "<vlastnic>".$hlavicka->vlastnic."</vlastnic>"."\r\n";
  fwrite($soubor, $text);
  $text = "<odvetvie>".$hlavicka->odvetvie."</odvetvie>"."\r\n";
  fwrite($soubor, $text);
  $text = "<odb_zvaz>".$hlavicka->odb_zvaz."</odb_zvaz>"."\r\n";
  fwrite($soubor, $text);
  $text = "<kol_zml>".$hlavicka->kol_zml."</kol_zml>"."\r\n";
  fwrite($soubor, $text);

$poc_praczz=$hlavicka->poc_pracz;
$Cislo=$poc_praczz+"";
$Spoc_praczz=sprintf("%0.0f", $Cislo);

$poc_praczpz=$hlavicka->poc_praczp;
$Cislo=$poc_praczpz+"";
$Spoc_praczpz=sprintf("%0.0f", $Cislo);

$poc_pracpz=$hlavicka->poc_pracp;
$Cislo=$poc_pracpz+"";
$Spoc_pracpz=sprintf("%0.0f", $Cislo);


  $text = "<poc_pracz>".$Spoc_praczz."</poc_pracz>"."\r\n";
  if( $hlavicka->poc_pracz == 0 ) { $text = "<poc_pracz>".$Spoc_praczv."</poc_pracz>"."\r\n"; }
  fwrite($soubor, $text);

  $text = "<poc_praczp>".$Spoc_praczpz."</poc_praczp>"."\r\n";
  if( $hlavicka->poc_praczp == 0 ) { $text = "<poc_praczp>".$Spoc_praczpv."</poc_praczp>"."\r\n"; }
  fwrite($soubor, $text);

  $text = "<poc_pracp>".$Spoc_pracpz."</poc_pracp>"."\r\n";
  if( $hlavicka->poc_pracp == 0 ) { $text = "<poc_pracp>".$Spoc_pracpv."</poc_pracp>"."\r\n"; }
  fwrite($soubor, $text);

  $text = "<trh_vyr>".$hlavicka->trh_vyr."</trh_vyr>"."\r\n";
  fwrite($soubor, $text);


  $text = "</respondent>"."\r\n";
  fwrite($soubor, $text);

  $text = "<zamestnanci>"."\r\n";
  fwrite($soubor, $text);


}
$i = $i + 1;
$j = $j + 1;
  }
//koniec hlavicky

//zamestnanci

$sqltt = "SELECT * FROM F$kli_vxcf"."_treximaprac ".
" LEFT JOIN F$kli_vxcf"."_treximaoc".
" ON F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_treximaoc.idec".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_treximaoc.idec=F$kli_vxcf"."_mzdkun.oc".

" WHERE F$kli_vxcf"."_treximaprac.prx = 2 ORDER BY F$kli_vxcf"."_treximaprac.idec ".""; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

  $text = "<zamestnanec>"."\r\n";
  fwrite($soubor, $text);

$nastup=SkDatum($hlavicka->dan);
$vystup=SkDatum($hlavicka->dav);
if( $vystup == '00.00.0000' ) $vystup="";
$pole = explode(".", $nastup);
$roknastupu=$pole[2];
$dobzam=$kli_vrok-$roknastupu;
if( $dobzam < 0 ) $dobzam=1;
$postihnutie=1*$hlavicka->postihnutie;
if( $postihnutie == 0 ) { $postihnutie=3; }
$pracpozicia = iconv("CP1250", "UTF-8", $hlavicka->pracpozicia);

  $text = "<idec>".$hlavicka->idec."</idec>"."\r\n";  fwrite($soubor, $text); 
  $text = "<vek>".$hlavicka->vek."</vek>"."\r\n";  fwrite($soubor, $text);
//od 1.1.2018 zrusene
//$text = "<zamest>".$hlavicka->zamest."</zamest>"."\r\n";  fwrite($soubor, $text); 
  $text = "<skisco08>".$hlavicka->skisco08."</skisco08>"."\r\n";  fwrite($soubor, $text); 
  $text = "<pracpozicia>".$pracpozicia."</pracpozicia>"."\r\n";  fwrite($soubor, $text); 
  $text = "<postihnutie>".$postihnutie."</postihnutie>"."\r\n";  fwrite($soubor, $text); 
  $text = "<pohlavie>".$hlavicka->pohlavie."</pohlavie>"."\r\n";  fwrite($soubor, $text); 
  $text = "<vzdelanie>".$hlavicka->vzdelanie."</vzdelanie>"."\r\n";  fwrite($soubor, $text); 
  $text = "<odborvzdelania>".$hlavicka->odborvzdelania."</odborvzdelania>"."\r\n";  fwrite($soubor, $text); 
  $text = "<tartrieda>".$hlavicka->tartrieda."</tartrieda>"."\r\n";  fwrite($soubor, $text); 
  //vyradeny $text = "<dobzam>".$dobzam."</dobzam>"."\r\n";  fwrite($soubor, $text); 
  $text = "<pracuv>".$hlavicka->pracuv."</pracuv>"."\r\n";  fwrite($soubor, $text); 
  $text = "<percento>".$hlavicka->percento."</percento>"."\r\n";  fwrite($soubor, $text); 
  $text = "<typzmluvy>".$hlavicka->typzmluvy."</typzmluvy>"."\r\n";  fwrite($soubor, $text); 
  $text = "<tyzdfond>".$hlavicka->tyzdfond."</tyzdfond>"."\r\n";  fwrite($soubor, $text); 
  $text = "<odpracd>".$hlavicka->odpracd."</odpracd>"."\r\n";  fwrite($soubor, $text); 
  $text = "<nadcas>".$hlavicka->nadcas."</nadcas>"."\r\n";  fwrite($soubor, $text); 
  $text = "<dovolenka>".$hlavicka->dovolenka."</dovolenka>"."\r\n";  fwrite($soubor, $text); 
  $text = "<pn>".$hlavicka->pn."</pn>"."\r\n";  fwrite($soubor, $text); 
  $text = "<pvn>".$hlavicka->pvn."</pvn>"."\r\n";  fwrite($soubor, $text); 
  $text = "<pv>".$hlavicka->pv."</pv>"."\r\n";  fwrite($soubor, $text);

//nova polozka od 1.1.2018
  $text = "<cenaprace>".$hlavicka->cenaprace."</cenaprace>"."\r\n";  fwrite($soubor, $text);
 
  $text = "<zucmzda>".$hlavicka->zucmzda."</zucmzda>"."\r\n";  fwrite($soubor, $text); 
  $text = "<zakmzda>".$hlavicka->zakmzda."</zakmzda>"."\r\n";  fwrite($soubor, $text); 
  $text = "<priplad>".$hlavicka->priplad."</priplad>"."\r\n";  fwrite($soubor, $text); 
  $text = "<premodm>".$hlavicka->premodm."</premodm>"."\r\n";  fwrite($soubor, $text); 
  $text = "<mzdapoh>".$hlavicka->mzdapoh."</mzdapoh>"."\r\n";  fwrite($soubor, $text); 
  $text = "<nahrady>".$hlavicka->nahrady."</nahrady>"."\r\n";  fwrite($soubor, $text); 
  $text = "<ostatne>".$hlavicka->ostatne."</ostatne>"."\r\n";  fwrite($soubor, $text); 
  $text = "<mzdanadcas>".$hlavicka->mzdanadcas."</mzdanadcas>"."\r\n";  fwrite($soubor, $text); 
  $text = "<sporenie>".$hlavicka->sporenie."</sporenie>"."\r\n";  fwrite($soubor, $text); 
  $text = "<nahzapoh>".$hlavicka->nahzapoh."</nahzapoh>"."\r\n";  fwrite($soubor, $text); 
  $text = "<nahpn>".$hlavicka->nahpn."</nahpn>"."\r\n";  fwrite($soubor, $text); 
  $text = "<plnzisk>".$hlavicka->plnzisk."</plnzisk>"."\r\n";  fwrite($soubor, $text); 
  $text = "<cistmzda>".$hlavicka->cistmzda."</cistmzda>"."\r\n";  fwrite($soubor, $text); 
  $text = "<priemzda>".$hlavicka->priemzda."</priemzda>"."\r\n";  fwrite($soubor, $text); 
  $text = "<pracovisko>".$hlavicka->pracovisko."</pracovisko>"."\r\n";  fwrite($soubor, $text); 
  $text = "<bydlisko>".$hlavicka->bydlisko."</bydlisko>"."\r\n";  fwrite($soubor, $text); 
  $text = "<zakon>".$hlavicka->zakon."</zakon>"."\r\n";  fwrite($soubor, $text); 
  $text = "<stprisl>".$hlavicka->stprisl."</stprisl>"."\r\n";  fwrite($soubor, $text); 
  $text = "<miesto>".$hlavicka->miesto."</miesto>"."\r\n";  fwrite($soubor, $text); 

  $text = "<nastup>".$nastup."</nastup>"."\r\n";  fwrite($soubor, $text); 
  $text = "<vystup>".$vystup."</vystup>"."\r\n";  fwrite($soubor, $text); 

  $text = "<oktober>"."\r\n";
  fwrite($soubor, $text);
  $text = "<zucmzdao>".$hlavicka->zucmzdao."</zucmzdao>"."\r\n"; 
  fwrite($soubor, $text);
  $text = "<mzdnadcaso>".$hlavicka->mzdnadcaso."</mzdnadcaso>"."\r\n"; 
  fwrite($soubor, $text);
  $text = "<mzdzvyho>".$hlavicka->mzdzvyho."</mzdzvyho>"."\r\n"; 
  fwrite($soubor, $text);
  $text = "<psn>".$hlavicka->psn."</psn>"."\r\n"; 
  fwrite($soubor, $text);
  $text = "<plathodo>".$hlavicka->plathodo."</plathodo>"."\r\n"; 
  fwrite($soubor, $text);
  $text = "<osn>".$hlavicka->osn."</osn>"."\r\n"; 
  fwrite($soubor, $text);
  $text = "<nadcashodo>".$hlavicka->nadcashodo."</nadcashodo>"."\r\n"; 
  fwrite($soubor, $text);
  $text = "</oktober>"."\r\n";
  fwrite($soubor, $text);
  $text = "</zamestnanec>"."\r\n";
  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }

  $text = "</zamestnanci>"."\r\n";
  fwrite($soubor, $text);

//koniec zamestnanci


//uplny koniec vykazu

  $text = "</iscp>"."\r\n";
  fwrite($soubor, $text);


fclose($soubor);
?>


<a href="../tmp/<?php echo $nazsub; ?>.xml">../tmp/<?php echo $nazsub; ?>.xml</a>


<?php

          }
//koniec subor XML
?>

<?php
//subor PDF
if( $copern == 13 )
          {



//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_treximafir WHERE ico = 0 ".""; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


if (File_Exists ("../tmp/podklad$kli_uzid.pdf")) { $soubor = unlink("../tmp/podklad$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$dsqlt = "DELETE FROM F$kli_vxcf"."_treximaprac WHERE prx = 2 AND pracuv != 1 ";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_treximaprac SELECT".
" 3,9999,0,0,0,ume,".
"0,".//konz1;
"'','','','',0,0,".
"0,".//konx1;
"SUM(odpracd),SUM(nadcas),SUM(dovolenka),SUM(pn),SUM(pvn),SUM(pv),".
"0,".//konx2;
"SUM(zucmzda),SUM(zakmzda),SUM(priplad),SUM(premodm),SUM(mzdapoh),SUM(nahrady),SUM(ostatne),".
"0,".//konx3;
"SUM(mzdanadcas),SUM(sporenie),SUM(nahzapoh),SUM(nahpn),SUM(plnzisk),SUM(cistmzda),SUM(priemzda),".
"0,0,0,0,".//konx4;
"0,".
"SUM(zucmzdao),SUM(mzdnadcaso),SUM(mzdzvyho),SUM(psn),SUM(plathodo),SUM(osn),SUM(nadcashodo) ".
" FROM F$kli_vxcf"."_treximaprac".
" WHERE prx = 2 ".
" GROUP BY prx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

}
$i = $i + 1;
$j = $j + 1;
  }
//koniec hlavicky

//zamestnanci

$sqltt = "SELECT * FROM F$kli_vxcf"."_treximaprac ".
" LEFT JOIN F$kli_vxcf"."_treximaoc".
" ON F$kli_vxcf"."_treximaprac.idec=F$kli_vxcf"."_treximaoc.idec".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_treximaoc.idec=F$kli_vxcf"."_mzdkun.oc".

" WHERE ( F$kli_vxcf"."_treximaprac.prx = 2 OR F$kli_vxcf"."_treximaprac.prx = 3 )  ORDER BY F$kli_vxcf"."_treximaprac.idec ".""; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; 
$strana=0;
$poczam=0;
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$pdf->SetFont('arial','',10);
$pdf->Cell(90,6,"TREXIMA 1.$kli_vrok - $mes3.$kli_vrok","LTB",0,"L"); 
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);


$pdf->Cell(10,6,"IDEC","LRB",0,"R");$pdf->Cell(10,6,"Uvazok","LRB",0,"R");$pdf->Cell(15,6,"Odpr.hod","LRB",0,"R");

$pdf->Cell(15,6,"Zkl.mzdy","LRB",0,"R");
$pdf->Cell(15,6,"Nadcas.mzdy","LRB",0,"R");
$pdf->Cell(15,6,"Premie","LRB",0,"R");
$pdf->Cell(15,6,"Priplatky","LRB",0,"R");
$pdf->Cell(15,6,"Nahrady","LRB",0,"R");
$pdf->Cell(15,6,"Sporenie","LRB",0,"R");
$pdf->Cell(15,6,"Pohotovost","LRB",0,"R");
$pdf->Cell(15,6,"Zo zisku","LRB",0,"R");


$pdf->Cell(0,6," ","1",1,"R");

     }
//koniec hlavicky j=0




$nastup=SkDatum($hlavicka->dan);
$vystup=SkDatum($hlavicka->dav);
if( $vystup == '00.00.0000' ) $vystup="";
$pole = explode(".", $nastup);
$roknastupu=$pole[2];
$dobzam=$kli_vrok-$roknastupu;
if( $dobzam < 0 ) $dobzam=1;

if ( $hlavicka->prx == 2 )
     {
$poczam=$poczam+1;

$pdf->Cell(10,4,"$hlavicka->idec","0",0,"R");
     }
if ( $hlavicka->prx == 3 )
     {
$pdf->Cell(10,4,"SPOLU","T",0,"R");
     }

$sqlt = <<<mzdprc
(
  $text = "<odpracd>".$hlavicka->odpracd."</odpracd>"."\r\n";  fwrite($soubor, $text); 
  $text = "<nadcas>".$hlavicka->nadcas."</nadcas>"."\r\n";  fwrite($soubor, $text); 
  $text = "<dovolenka>".$hlavicka->dovolenka."</dovolenka>"."\r\n";  fwrite($soubor, $text); 
  $text = "<pn>".$hlavicka->pn."</pn>"."\r\n";  fwrite($soubor, $text); 
  $text = "<pvn>".$hlavicka->pvn."</pvn>"."\r\n";  fwrite($soubor, $text); 
  $text = "<pv>".$hlavicka->pv."</pv>"."\r\n";  fwrite($soubor, $text); 
  $text = "<zucmzda>".$hlavicka->zucmzda."</zucmzda>"."\r\n";  fwrite($soubor, $text); 
  $text = "<zakmzda>".$hlavicka->zakmzda."</zakmzda>"."\r\n";  fwrite($soubor, $text); 
  $text = "<priplad>".$hlavicka->priplad."</priplad>"."\r\n";  fwrite($soubor, $text); 
  $text = "<premodm>".$hlavicka->premodm."</premodm>"."\r\n";  fwrite($soubor, $text); 
  $text = "<mzdapoh>".$hlavicka->mzdapoh."</mzdapoh>"."\r\n";  fwrite($soubor, $text); 
  $text = "<nahrady>".$hlavicka->nahrady."</nahrady>"."\r\n";  fwrite($soubor, $text); 
  $text = "<ostatne>".$hlavicka->ostatne."</ostatne>"."\r\n";  fwrite($soubor, $text); 
  $text = "<mzdanadcas>".$hlavicka->mzdanadcas."</mzdanadcas>"."\r\n";  fwrite($soubor, $text); 
  $text = "<sporenie>".$hlavicka->sporenie."</sporenie>"."\r\n";  fwrite($soubor, $text); 
  $text = "<nahzapoh>".$hlavicka->nahzapoh."</nahzapoh>"."\r\n";  fwrite($soubor, $text); 
  $text = "<nahpn>".$hlavicka->nahpn."</nahpn>"."\r\n";  fwrite($soubor, $text); 
  $text = "<plnzisk>".$hlavicka->plnzisk."</plnzisk>"."\r\n";  fwrite($soubor, $text); 
  $text = "<cistmzda>".$hlavicka->cistmzda."</cistmzda>"."\r\n";  fwrite($soubor, $text); 
);
mzdprc;

$pdf->Cell(10,4,"$hlavicka->pracuv","0",0,"R");
$pdf->Cell(15,4,"$hlavicka->odpracd","0",0,"R");
$pdf->Cell(15,4,"$hlavicka->zakmzda","0",0,"R");
$pdf->Cell(15,4,"$hlavicka->nadcas","0",0,"R");
$pdf->Cell(15,4,"$hlavicka->premodm","0",0,"R");
$pdf->Cell(15,4,"$hlavicka->priplad","0",0,"R");
$pdf->Cell(15,4,"$hlavicka->nahrady","0",0,"R");
$pdf->Cell(15,4,"$hlavicka->sporenie","0",0,"R");
$pdf->Cell(15,4,"$hlavicka->nahzapoh","0",0,"R");
$pdf->Cell(15,4,"$hlavicka->plnzisk","0",0,"R");


$pdf->Cell(0,4," ","0",1,"R");

}
$i = $i + 1;
$j = $j + 1;
  }


$pdf->Cell(0,4," ","0",1,"L");
$pdf->Cell(0,4,"PoËet zamestnancov = $poczam ","0",1,"L");


$sqlttt = "SELECT SUM(ofir_zp) AS sumzp FROM F$kli_vxcf"."_mzdzalsum WHERE ume > 0 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sumzp=$riaddok->sumzp;
  }

$pdf->Cell(0,4," ","0",1,"L");
$pdf->Cell(0,4,"Suma odvodov ZP = $sumzp ","0",1,"L");

$sqlttt = "SELECT SUM(ofir_np) AS sumnp FROM F$kli_vxcf"."_mzdzalsum WHERE ume > 0 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sumnp=$riaddok->sumnp;
  }

$pdf->Cell(0,4," ","0",1,"L");
$pdf->Cell(0,4,"Suma odvodov NP = $sumnp ","0",1,"L");

$sqlttt = "SELECT SUM(ofir_sp) AS sumsp FROM F$kli_vxcf"."_mzdzalsum WHERE ume > 0 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sumsp=$riaddok->sumsp;
  }

$pdf->Cell(0,4," ","0",1,"L");
$pdf->Cell(0,4,"Suma odvodov SP = $sumsp ","0",1,"L");


$sqlttt = "SELECT SUM(ofir_ip) AS sumip FROM F$kli_vxcf"."_mzdzalsum WHERE ume > 0 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sumip=$riaddok->sumip;
  }

$pdf->Cell(0,4," ","0",1,"L");
$pdf->Cell(0,4,"Suma odvodov IP = $sumip ","0",1,"L");


$sqlttt = "SELECT SUM(ofir_pn) AS sumpn FROM F$kli_vxcf"."_mzdzalsum WHERE ume > 0 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sumpn=$riaddok->sumpn;
  }

$pdf->Cell(0,4," ","0",1,"L");
$pdf->Cell(0,4,"Suma odvodov PvN = $sumpn ","0",1,"L");

$sqlttt = "SELECT SUM(ofir_up) AS sumup FROM F$kli_vxcf"."_mzdzalsum WHERE ume > 0 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sumup=$riaddok->sumup;
  }

$pdf->Cell(0,4," ","0",1,"L");
$pdf->Cell(0,4,"Suma odvodov UP = $sumup ","0",1,"L");

$sqlttt = "SELECT SUM(ofir_rf) AS sumrf FROM F$kli_vxcf"."_mzdzalsum WHERE ume > 0 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sumrf=$riaddok->sumrf;
  }

$pdf->Cell(0,4," ","0",1,"L");
$pdf->Cell(0,4,"Suma odvodov RF = $sumrf ","0",1,"L");

$sqlttt = "SELECT SUM(ofir_gf) AS sumgf FROM F$kli_vxcf"."_mzdzalsum WHERE ume > 0 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sumgf=$riaddok->sumgf;
  }

$pdf->Cell(0,4," ","0",1,"L");
$pdf->Cell(0,4,"Suma odvodov GF = $sumgf ","0",1,"L");


$sqlttt = "SELECT SUM(ofir_zp+ofir_np+ofir_sp+ofir_ip+ofir_pn+ofir_up+ofir_rf+ofir_gf) AS sumall FROM F$kli_vxcf"."_mzdzalsum WHERE ume > 0 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sumall=$riaddok->sumall;
  }

$pdf->Cell(0,4," ","0",1,"L");
$pdf->Cell(0,4,"Suma odvodov celkom SP + ZP = $sumall ","0",1,"L");


$pdf->Output("../tmp/podklad.$kli_uzid.pdf");

?>


<script type="text/javascript">
  var okno = window.open("../tmp/podklad.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php

          }
//koniec subor PDF
?>


<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 200; top: 200; left: 40; width:60; height:100;">
<img border=0 src='../obr/robot/robot3.jpg' style='' onClick="zobraz_robotmenu();"
 title='Dobr˝ deÚ , ja som V·ö EkoRobot , ak m·te ot·zku alebo nejakÈ ûelanie kliknite na mÚa prosÌm 1x myöou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 title='Zhasni EkoRobota' >
</div>
<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 160; left: 90; width:200; height:100;">
zobrazene menu
</div>

<?php
$vsql = 'DROP TABLE F'.$kli_vxcf.'_treximaprac';
$vytvor = mysql_query("$vsql");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
