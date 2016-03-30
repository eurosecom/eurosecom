<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'VYR';
$urov = 2000;
$clsm = 920;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$exportean = 1*$_REQUEST['exportean'];


  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//urob pracovnu 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<uctprc
(
   pox         INT(3),
   cix         DECIMAL(15,0),
   nat         VARCHAR(40),
   mer         VARCHAR(3),
   dph         INT(2),
   cep         DECIMAL(10,2),
   ced         DECIMAL(10,2),
   ktg         DECIMAL(10,0)
);
uctprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprc'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");




?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>»ÌselnÌk materi·lu a tovaru</title>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
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
<td>EuroSecom  -  KatalÛg tovaru XML  

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//subor XML
if( $copern == 10 AND $exportean == 1 )
          {


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcean'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$vsql = "CREATE TABLE F".$kli_vxcf."_uctprcean".$kli_uzid." SELECT * FROM F".$kli_vxcf."_sklcis WHERE cis < 15000 ";
$vytvor = mysql_query("$vsql");

$sqltt = "SELECT * FROM F".$kli_vxcf."_uctprcean".$kli_uzid." ".
" LEFT JOIN F".$kli_vxcf."_sklcisudaje".
" ON F".$kli_vxcf."_uctprcean".$kli_uzid.".cis=F".$kli_vxcf."_sklcisudaje.xcis".
" WHERE tl1 = 1 AND xdr2 > 0 ORDER BY xnat "; 
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql); 
$polm1=$pol-1;

$subx=1;
$je81=0; $je82=0; $je83=0; $je84=0; $je85=0; $je86=0; $je87=0; $je88=0; $je89=0; 
$eank81=0; $eank82=0; $eank83=0; $eank84=0; $eank85=0; $eank86=0; $eank87=0; $eank88=0; $eank89=0; 


       while ( $subx <= 9 )
       {

$eank=0;

if( $subx == 1 ) { $nazsub81="productsean1"; $i=0; }
if( $subx == 2 ) { $nazsub82="productsean2"; $i=1000; }
if( $subx == 3 ) { $nazsub83="productsean3"; $i=2000; }
if( $subx == 4 ) { $nazsub84="productsean4"; $i=3000; }
if( $subx == 5 ) { $nazsub85="productsean5"; $i=4000; }
if( $subx == 6 ) { $nazsub86="productsean6"; $i=5000; }
if( $subx == 7 ) { $nazsub87="productsean7"; $i=6000; }
if( $subx == 8 ) { $nazsub88="productsean8"; $i=7000; }
if( $subx == 9 ) { $nazsub89="productsean9"; $i=8000; }

$suborxxx="productsean".$subx;

if (File_Exists ("../tmp/$suborxxx.xml")) { $soubor = unlink("../tmp/$suborxxx.xml"); }
$soubor = fopen("../tmp/$suborxxx.xml", "a+");

$j=1;
$polj=1000;


  $text = "<?xml version = \"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>"."\r\n";
  fwrite($soubor, $text);

  $text = "<products>"."\r\n";
  fwrite($soubor, $text);


  while ( $j <= $polj )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if( $subx == 1 ) { $je81=1; }
if( $subx == 2 ) { $je82=1; }
if( $subx == 3 ) { $je83=1; }
if( $subx == 4 ) { $je84=1; }
if( $subx == 5 ) { $je85=1; }
if( $subx == 6 ) { $je86=1; }
if( $subx == 7 ) { $je87=1; }
if( $subx == 8 ) { $je88=1; }
if( $subx == 9 ) { $je89=1; }

  $text = "<product>"."\r\n";
  fwrite($soubor, $text);

  $text = "<pid>".$hlavicka->cis."</pid>"."\r\n";
  fwrite($soubor, $text);

$nat = iconv("CP1250", "UTF-8", $hlavicka->nat);

  $text = "<name>".trim($nat)."</name>"."\r\n";
  fwrite($soubor, $text);

$mer = iconv("CP1250", "UTF-8", $hlavicka->mer);

  $text = "<mer>".$mer."</mer>"."\r\n";
  fwrite($soubor, $text);


$ced=sprintf("%0.2f", $hlavicka->ced);

  $text = "<price>".$ced."</price>"."\r\n";
  fwrite($soubor, $text);

$zasoba=0;
$sqlzas = mysql_query("SELECT cis,zas FROM F".$kli_vxcf."_sklzaspriemer WHERE cis = $hlavicka->cis ");
  if (@$zaznam=mysql_data_seek($sqlzas,0))
  {
  $riadok=mysql_fetch_object($sqlzas);
  $zasoba=1*$riadok->zas;
  }

  $text = "<zasoba>".$zasoba."</zasoba>"."\r\n";
  fwrite($soubor, $text);

  $text = "<ean>".trim($hlavicka->xnat)."</ean>"."\r\n";
  fwrite($soubor, $text);

$eank=trim($hlavicka->xnat);

  $text = "</product>"."\r\n";
  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
   }
if( $subx == 1 ) { $eank81=$eank; }
if( $subx == 2 ) { $eank82=$eank; }
if( $subx == 3 ) { $eank83=$eank; }
if( $subx == 4 ) { $eank84=$eank; }
if( $subx == 5 ) { $eank85=$eank; }
if( $subx == 6 ) { $eank86=$eank; }
if( $subx == 7 ) { $eank87=$eank; }
if( $subx == 8 ) { $eank88=$eank; }
if( $subx == 9 ) { $eank89=$eank; }

  $text = "</products>"."\r\n";
  fwrite($soubor, $text);


fclose($soubor);


$subx = $subx + 1;
       }

$textcsv=$eank81.";".$eank82.";".$eank83.";".$eank84.";".$eank85.";".$eank86.";".$eank87.";".$eank88.";".$eank89;


$nazsubcsv="eanindex";
if (File_Exists ("../tmp/$nazsubcsv.csv")) { $soubor = unlink("../tmp/$nazsubcsv.csv"); }
$soubor = fopen("../tmp/$nazsubcsv.csv", "a+");
  $text = $textcsv."\r\n";
  fwrite($soubor, $text);
fclose($soubor);

?>
<br />
<br />
<a href="../tmp/<?php echo $nazsubcsv; ?>.csv">../tmp/<?php echo $nazsubcsv; ?>.csv</a>
<?php if( $je81 == 1 ) { ?>
<br />
<br />
<a href="../tmp/<?php echo $nazsub81; ?>.xml">../tmp/<?php echo $nazsub81; ?>.xml</a>
<?php                  } ?>
<?php if( $je82 == 1 ) { ?>
<br />
<br />
<a href="../tmp/<?php echo $nazsub82; ?>.xml">../tmp/<?php echo $nazsub82; ?>.xml</a>
<?php                  } ?>
<?php if( $je83 == 1 ) { ?>
<br />
<br />
<a href="../tmp/<?php echo $nazsub83; ?>.xml">../tmp/<?php echo $nazsub83; ?>.xml</a>
<?php                  } ?>
<?php if( $je84 == 1 ) { ?>
<br />
<br />
<a href="../tmp/<?php echo $nazsub84; ?>.xml">../tmp/<?php echo $nazsub84; ?>.xml</a>
<?php                  } ?>
<?php if( $je85 == 1 ) { ?>
<br />
<br />
<a href="../tmp/<?php echo $nazsub85; ?>.xml">../tmp/<?php echo $nazsub85; ?>.xml</a>
<?php                  } ?>
<?php if( $je86 == 1 ) { ?>
<br />
<br />
<a href="../tmp/<?php echo $nazsub86; ?>.xml">../tmp/<?php echo $nazsub86; ?>.xml</a>
<?php                  } ?>
<?php if( $je87 == 1 ) { ?>
<br />
<br />
<a href="../tmp/<?php echo $nazsub87; ?>.xml">../tmp/<?php echo $nazsub87; ?>.xml</a>
<?php                  } ?>
<?php if( $je88 == 1 ) { ?>
<br />
<br />
<a href="../tmp/<?php echo $nazsub88; ?>.xml">../tmp/<?php echo $nazsub88; ?>.xml</a>
<?php                  } ?>
<?php if( $je89 == 1 ) { ?>
<br />
<br />
<a href="../tmp/<?php echo $nazsub89; ?>.xml">../tmp/<?php echo $nazsub89; ?>.xml</a>
<?php                  } ?>
<?php

          }
//koniec subor XML
?>

<?php
//subor XML
if( $copern == 10 AND $exportean == 0 )
          {

$nazsub1="categories";


if (File_Exists ("../tmp/$nazsub1.xml")) { $soubor = unlink("../tmp/$nazsub1.xml"); }

$soubor = fopen("../tmp/$nazsub1.xml", "a+");


$sqltt = "SELECT * FROM F$kli_vxcf"."_restktgtov WHERE cktg > 0 ORDER BY cktg "; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$polm1=$pol-1;

$i=0;

  while ( $i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if( $i == 0 ) {

  $text = "<?xml version = \"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>"."\r\n";
  fwrite($soubor, $text);

  $text = "<categories>"."\r\n";
  fwrite($soubor, $text);

              }

  $text = "<category>"."\r\n";
  fwrite($soubor, $text);

  $text = "<ckat>".$hlavicka->cktg."</ckat>"."\r\n";
  fwrite($soubor, $text);

//$nktg = iconv("CP1250", "UTF-8", $hlavicka->nktg);
$nktg = StrTr($hlavicka->nktg, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é","aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

  $text = "<nkat>".$nktg."</nkat>"."\r\n";
  fwrite($soubor, $text);
  $text = "<pkat>".$hlavicka->pktg."</pkat>"."\r\n";
  fwrite($soubor, $text);

  $text = "</category>"."\r\n";
  fwrite($soubor, $text);

if( $i == $polm1 ) {


  $text = "</categories>"."\r\n";
  fwrite($soubor, $text);

                   }

}
$i = $i + 1;
   }

fclose($soubor);
?>

<?php
$nazsub2="products";


if (File_Exists ("../tmp/$nazsub2.xml")) { $soubor = unlink("../tmp/$nazsub2.xml"); }

$soubor = fopen("../tmp/$nazsub2.xml", "a+");


$sqltt = "SELECT * FROM F".$kli_vxcf."_sklcis ".
" LEFT JOIN F".$kli_vxcf."_sklcisudaje".
" ON F".$kli_vxcf."_sklcis.cis=F".$kli_vxcf."_sklcisudaje.xcis".
" WHERE tl1 = 1 AND xdr2 > 0 AND cis < 1300 ORDER BY cis "; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$polm1=$pol-1;

$i=0;

  while ( $i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


if( $i == 0 ) {

  $text = "<?xml version = \"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>"."\r\n";
  fwrite($soubor, $text);

  $text = "<products>"."\r\n";
  fwrite($soubor, $text);

              }

  $text = "<product>"."\r\n";
  fwrite($soubor, $text);

  $text = "<ckat>".$hlavicka->xdr2."</ckat>"."\r\n";
  fwrite($soubor, $text);

  $text = "<pid>".$hlavicka->cis."</pid>"."\r\n";
  fwrite($soubor, $text);

$nat = StrTr($hlavicka->nat, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é","aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
//$nat = iconv("CP1250", "UTF-8", $hlavicka->nat);

  $text = "<name>".trim($nat)."</name>"."\r\n";
  fwrite($soubor, $text);

$mer = iconv("CP1250", "UTF-8", $hlavicka->mer);

  $text = "<mer>".$mer."</mer>"."\r\n";
  fwrite($soubor, $text);

  $text = "<dph>".$hlavicka->dph."</dph>"."\r\n";
  fwrite($soubor, $text);

$cep=sprintf("%0.2f", $hlavicka->cep);

  $text = "<cep>".$cep."</cep>"."\r\n";
  fwrite($soubor, $text);

$ced=sprintf("%0.2f", $hlavicka->ced);

  $text = "<price>".$ced."</price>"."\r\n";
  fwrite($soubor, $text);

  $text = "<ean>".trim($hlavicka->xnat)."</ean>"."\r\n";
  fwrite($soubor, $text);

$ix=0;
$pidp=$hlavicka->cis;
$pidn=$hlavicka->cis;
$pidm=$hlavicka->cis;

$zbyt=0;
if( $zbyt == 0 ) 
          {

$sqlttx = "SELECT * FROM F".$kli_vxcf."_sklcis ".
" LEFT JOIN F".$kli_vxcf."_sklcisudaje".
" ON F".$kli_vxcf."_sklcis.cis=F".$kli_vxcf."_sklcisudaje.xcis".
" WHERE tl1 = 1 AND xdr2 = $hlavicka->xdr2 ORDER BY cis "; 
$sqldok = mysql_query("$sqlttx");
$polx = mysql_num_rows($sqldok);
  while ( $ix <= $polx )
  {
  if (@$zaznam=mysql_data_seek($sqldok,$ix))
{
$hlavickax=mysql_fetch_object($sqldok);

if( $hlavickax->cis == $hlavicka->cis ) { $ixcis=$ix; }

}
$ix = $ix + 1;
   }

$ix=0;
$ixp=$ixcis-1;
$ixn=$ixcis+1;
if( $ixp < 0 ) { $ixp=$polx-1; }
if( $ixn >= $polx ) { $ixn=0; }
  while ( $ix <= $polx )
  {
  if (@$zaznam=mysql_data_seek($sqldok,$ix))
{
$hlavickax=mysql_fetch_object($sqldok);

if( $ix == 0 ) { $pidm=$hlavickax->cis; }
if( $ix == $ixp ) { $pidp=$hlavickax->cis; }
if( $ix == $ixn ) { $pidn=$hlavickax->cis; }

}
$ix = $ix + 1;
   }

//if( $zbyt == 0 ) 
          }

  $text = "<pidm>".$pidm."</pidm>"."\r\n";
  fwrite($soubor, $text);

  $text = "<pidp>".$pidp."</pidp>"."\r\n";
  fwrite($soubor, $text);

  $text = "<pidn>".$pidn."</pidn>"."\r\n";
  fwrite($soubor, $text);


$desc = iconv("CP1250", "UTF-8", $hlavicka->webtx1);

  $text = "<desc>".$desc."</desc>"."\r\n";
  fwrite($soubor, $text);

  $text = "</product>"."\r\n";
  fwrite($soubor, $text);

if( $i == $polm1 ) {


  $text = "</products>"."\r\n";
  fwrite($soubor, $text);

                   }



}
$i = $i + 1;
   }

fclose($soubor);
?>

<?php
$nazsub2a="products_name";


if (File_Exists ("../tmp/$nazsub2a.xml")) { $soubor = unlink("../tmp/$nazsub2a.xml"); }

$soubor = fopen("../tmp/$nazsub2a.xml", "a+");


$sqltt = "SELECT * FROM F".$kli_vxcf."_sklcis ".
" LEFT JOIN F".$kli_vxcf."_sklcisudaje".
" ON F".$kli_vxcf."_sklcis.cis=F".$kli_vxcf."_sklcisudaje.xcis".
" WHERE tl1 = 1 AND xdr2 > 0 AND cis < 1300 ORDER BY nat "; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$polm1=$pol-1;

$i=0;

  while ( $i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


if( $i == 0 ) {

  $text = "<?xml version = \"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>"."\r\n";
  fwrite($soubor, $text);

  $text = "<products>"."\r\n";
  fwrite($soubor, $text);

              }

  $text = "<product>"."\r\n";
  fwrite($soubor, $text);

  $text = "<ckat>".$hlavicka->xdr2."</ckat>"."\r\n";
  fwrite($soubor, $text);

  $text = "<pid>".$hlavicka->cis."</pid>"."\r\n";
  fwrite($soubor, $text);

$nat = StrTr($hlavicka->nat, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é","aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
//$nat = iconv("CP1250", "UTF-8", $hlavicka->nat);

  $text = "<name>".trim($nat)."</name>"."\r\n";
  fwrite($soubor, $text);

$mer = iconv("CP1250", "UTF-8", $hlavicka->mer);

  $text = "<mer>".$mer."</mer>"."\r\n";
  fwrite($soubor, $text);

  $text = "<dph>".$hlavicka->dph."</dph>"."\r\n";
  fwrite($soubor, $text);

$cep=sprintf("%0.2f", $hlavicka->cep);

  $text = "<cep>".$cep."</cep>"."\r\n";
  fwrite($soubor, $text);

$ced=sprintf("%0.2f", $hlavicka->ced);

  $text = "<price>".$ced."</price>"."\r\n";
  fwrite($soubor, $text);

  $text = "<ean>".trim($hlavicka->xnat)."</ean>"."\r\n";
  fwrite($soubor, $text);

$ix=0;
$pidp=$hlavicka->cis;
$pidn=$hlavicka->cis;
$pidm=$hlavicka->cis;

$zbyt=0;
if( $zbyt == 0 ) 
          {

$sqlttx = "SELECT * FROM F".$kli_vxcf."_sklcis ".
" LEFT JOIN F".$kli_vxcf."_sklcisudaje".
" ON F".$kli_vxcf."_sklcis.cis=F".$kli_vxcf."_sklcisudaje.xcis".
" WHERE tl1 = 1 AND xdr2 = $hlavicka->xdr2 ORDER BY cis "; 
$sqldok = mysql_query("$sqlttx");
$polx = mysql_num_rows($sqldok);
  while ( $ix <= $polx )
  {
  if (@$zaznam=mysql_data_seek($sqldok,$ix))
{
$hlavickax=mysql_fetch_object($sqldok);

if( $hlavickax->cis == $hlavicka->cis ) { $ixcis=$ix; }

}
$ix = $ix + 1;
   }

$ix=0;
$ixp=$ixcis-1;
$ixn=$ixcis+1;
if( $ixp < 0 ) { $ixp=$polx-1; }
if( $ixn >= $polx ) { $ixn=0; }
  while ( $ix <= $polx )
  {
  if (@$zaznam=mysql_data_seek($sqldok,$ix))
{
$hlavickax=mysql_fetch_object($sqldok);

if( $ix == 0 ) { $pidm=$hlavickax->cis; }
if( $ix == $ixp ) { $pidp=$hlavickax->cis; }
if( $ix == $ixn ) { $pidn=$hlavickax->cis; }

}
$ix = $ix + 1;
   }

//if( $zbyt == 0 ) 
          }

  $text = "<pidm>".$pidm."</pidm>"."\r\n";
  fwrite($soubor, $text);

  $text = "<pidp>".$pidp."</pidp>"."\r\n";
  fwrite($soubor, $text);

  $text = "<pidn>".$pidn."</pidn>"."\r\n";
  fwrite($soubor, $text);


$desc = iconv("CP1250", "UTF-8", $hlavicka->webtx1);

  $text = "<desc>".$desc."</desc>"."\r\n";
  fwrite($soubor, $text);

  $text = "</product>"."\r\n";
  fwrite($soubor, $text);

if( $i == $polm1 ) {


  $text = "</products>"."\r\n";
  fwrite($soubor, $text);

                   }



}
$i = $i + 1;
   }

fclose($soubor);
?>

<?php
$nazsub3="banks";


if (File_Exists ("../tmp/$nazsub3.xml")) { $soubor = unlink("../tmp/$nazsub3.xml"); }

$soubor = fopen("../tmp/$nazsub3.xml", "a+");


$sqltt = "SELECT * FROM F$kli_vxcf"."_reststoly WHERE cstl > 0 ORDER BY cstl "; 

$sql = mysql_query("$sqltt");
if( $sql )
     {
$pol = mysql_num_rows($sql);
$polm1=$pol-1;

$i=0;

  while ( $i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if( $i == 0 ) {

  $text = "<?xml version = \"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>"."\r\n";
  fwrite($soubor, $text);

  $text = "<banks>"."\r\n";
  fwrite($soubor, $text);

              }

  $text = "<bank>"."\r\n";
  fwrite($soubor, $text);

  $text = "<cstl>".$hlavicka->cstl."</cstl>"."\r\n";
  fwrite($soubor, $text);

$nstl = StrTr($hlavicka->nstl, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é","aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
//$nstl = iconv("CP1250", "UTF-8", $hlavicka->nstl);

  $text = "<nstl>".$nstl."</nstl>"."\r\n";
  fwrite($soubor, $text);
  $text = "<psch>".$hlavicka->psch."</psch>"."\r\n";
  fwrite($soubor, $text);

  $text = "</bank>"."\r\n";
  fwrite($soubor, $text);

if( $i == $polm1 ) {


  $text = "</banks>"."\r\n";
  fwrite($soubor, $text);

                   }

}
$i = $i + 1;
   }

fclose($soubor);

     }
?>


<?php
$nazsub4="ico";


if (File_Exists ("../tmp/$nazsub4.xml")) { $soubor = unlink("../tmp/$nazsub4.xml"); }

$soubor = fopen("../tmp/$nazsub4.xml", "a+");


$sqltt = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico > 0 ORDER BY ico "; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$polm1=$pol-1;

$i=0;

  while ( $i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if( $i == 0 ) {

  $text = "<?xml version = \"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>"."\r\n";
  fwrite($soubor, $text);

  $text = "<customers>"."\r\n";
  fwrite($soubor, $text);

              }

  $text = "<customer>"."\r\n";
  fwrite($soubor, $text);

  $text = "<ico>".$hlavicka->ico."</ico>"."\r\n";
  fwrite($soubor, $text);

  $dic = iconv("CP1250", "UTF-8", $hlavicka->dic);
  $text = "<dic>".$dic."</dic>"."\r\n";
  fwrite($soubor, $text);

  $icd = iconv("CP1250", "UTF-8", $hlavicka->icd);
  $text = "<icd>".$icd."</icd>"."\r\n";
  fwrite($soubor, $text);

  $nai = iconv("CP1250", "UTF-8", $hlavicka->nai);
  $nai=str_replace("&","a",$nai);
  $text = "<nai>".$nai."</nai>"."\r\n";
  fwrite($soubor, $text);

  $uli = iconv("CP1250", "UTF-8", $hlavicka->uli);
  $text = "<uli><![CDATA[".$uli."]]></uli>"."\r\n";
  fwrite($soubor, $text);

  $psc = iconv("CP1250", "UTF-8", $hlavicka->psc);
  $psc=str_replace(" ","",$psc);
  $psc=str_replace("&","a",$psc);
  $text = "<psc>".$psc."</psc>"."\r\n";
  fwrite($soubor, $text);

  $mes = iconv("CP1250", "UTF-8", $hlavicka->mes);
  $text = "<mes>".$mes."</mes>"."\r\n";
  fwrite($soubor, $text);

  $tel = iconv("CP1250", "UTF-8", $hlavicka->tel);
  $text = "<tel>".$tel."</tel>"."\r\n";
  fwrite($soubor, $text);

  $fax = iconv("CP1250", "UTF-8", $hlavicka->fax);
  $text = "<fax>".$fax."</fax>"."\r\n";
  fwrite($soubor, $text);

  $em1 = iconv("CP1250", "UTF-8", $hlavicka->em1);
  $text = "<em1>".$em1."</em1>"."\r\n";
  fwrite($soubor, $text);

  $em2 = iconv("CP1250", "UTF-8", $hlavicka->em2);
  $text = "<em2>".$em2."</em2>"."\r\n";
  fwrite($soubor, $text);

  $em3 = iconv("CP1250", "UTF-8", $hlavicka->em3);
  $text = "<em3>".$em3."</em3>"."\r\n";
  fwrite($soubor, $text);

  $www = iconv("CP1250", "UTF-8", $hlavicka->www);
  $text = "<www>".$www."</www>"."\r\n";
  fwrite($soubor, $text);

  $uc1 = iconv("CP1250", "UTF-8", $hlavicka->uc1);
  $text = "<uc1>".$uc1."</uc1>"."\r\n";
  fwrite($soubor, $text);

  $nm1 = iconv("CP1250", "UTF-8", $hlavicka->nm1);
  $text = "<nm1>".$nm1."</nm1>"."\r\n";
  fwrite($soubor, $text);

  $ib1 = iconv("CP1250", "UTF-8", $hlavicka->ib1);
  $text = "<ib1>".$ib1."</ib1>"."\r\n";
  fwrite($soubor, $text);

  $dns = iconv("CP1250", "UTF-8", $hlavicka->dns);
  $text = "<dns>".$dns."</dns>"."\r\n";
  fwrite($soubor, $text);

  $text = "</customer>"."\r\n";
  fwrite($soubor, $text);

if( $i == $polm1 ) {


  $text = "</customers>"."\r\n";
  fwrite($soubor, $text);

                   }

}
$i = $i + 1;
   }

fclose($soubor);
?>

<?php
$nazsub5="odbm";


if (File_Exists ("../tmp/$nazsub5.xml")) { $soubor = unlink("../tmp/$nazsub5.xml"); }

$soubor = fopen("../tmp/$nazsub5.xml", "a+");


$sqltt = "SELECT * FROM F$kli_vxcf"."_icoodbm WHERE ico > 0 ORDER BY ico "; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$polm1=$pol-1;

$i=0;

  while ( $i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if( $i == 0 ) {

  $text = "<?xml version = \"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>"."\r\n";
  fwrite($soubor, $text);

  $text = "<odbms>"."\r\n";
  fwrite($soubor, $text);

              }


  $text = "<odbmx>"."\r\n";
  fwrite($soubor, $text);

  $text = "<ico>".$hlavicka->ico."</ico>"."\r\n";
  fwrite($soubor, $text);

  $text = "<odbm>".$hlavicka->odbm."</odbm>"."\r\n";
  fwrite($soubor, $text);

  $onai = iconv("CP1250", "UTF-8", $hlavicka->onai);
  $text = "<onai>".$onai."</onai>"."\r\n";
  fwrite($soubor, $text);

  $ouli = iconv("CP1250", "UTF-8", $hlavicka->ouli);
  $text = "<ouli>".$ouli."</ouli>"."\r\n";
  fwrite($soubor, $text);

  $opsc = iconv("CP1250", "UTF-8", $hlavicka->opsc);
  $opsc=str_replace(" ","",$opsc);
  $text = "<opsc>".$opsc."</opsc>"."\r\n";
  fwrite($soubor, $text);

  $omes = iconv("CP1250", "UTF-8", $hlavicka->omes);
  $text = "<omes>".$omes."</omes>"."\r\n";
  fwrite($soubor, $text);

  $text = "</odbmx>"."\r\n";
  fwrite($soubor, $text);

if( $i == $polm1 ) {


  $text = "</odbms>"."\r\n";
  fwrite($soubor, $text);

                   }

}
$i = $i + 1;
   }

fclose($soubor);
?>

<?php
$nazsub6="services";


if (File_Exists ("../tmp/$nazsub6.xml")) { $soubor = unlink("../tmp/$nazsub6.xml"); }

$soubor = fopen("../tmp/$nazsub6.xml", "a+");


$sqltt = "SELECT * FROM F".$kli_vxcf."_sluzby ".
" WHERE tl1 = 1 ORDER BY slu "; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$polm1=$pol-1;

$i=0;

  while ( $i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if( $i == 0 ) {

  $text = "<?xml version = \"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>"."\r\n";
  fwrite($soubor, $text);

  $text = "<products>"."\r\n";
  fwrite($soubor, $text);

              }

  $text = "<product>"."\r\n";
  fwrite($soubor, $text);

  $text = "<ckat>9999</ckat>"."\r\n";
  fwrite($soubor, $text);

  $text = "<pid>".$hlavicka->slu."</pid>"."\r\n";
  fwrite($soubor, $text);

$nat = iconv("CP1250", "UTF-8", $hlavicka->nsl);

  $text = "<name>".$nat."</name>"."\r\n";
  fwrite($soubor, $text);

$mer = iconv("CP1250", "UTF-8", $hlavicka->mer);

  $text = "<mer>".$mer."</mer>"."\r\n";
  fwrite($soubor, $text);

  $text = "<dph>".$hlavicka->dph."</dph>"."\r\n";
  fwrite($soubor, $text);

$cep=sprintf("%0.2f", $hlavicka->cep);

  $text = "<cep>".$cep."</cep>"."\r\n";
  fwrite($soubor, $text);

$ced=sprintf("%0.2f", $hlavicka->ced);

  $text = "<price>".$ced."</price>"."\r\n";
  fwrite($soubor, $text);

$ix=0;
$pidp=$hlavicka->slu;
$pidn=$hlavicka->slu;
$pidm=$hlavicka->slu;
$sqlttx = "SELECT * FROM F".$kli_vxcf."_sluzby ".
" WHERE tl1 = 1 ORDER BY slu "; 
$sqldok = mysql_query("$sqlttx");
$polx = mysql_num_rows($sqldok);
  while ( $ix <= $polx )
  {
  if (@$zaznam=mysql_data_seek($sqldok,$ix))
{
$hlavickax=mysql_fetch_object($sqldok);

if( $hlavickax->slu == $hlavicka->slu ) { $ixcis=$ix; }

}
$ix = $ix + 1;
   }

$ix=0;
$ixp=$ixcis-1;
$ixn=$ixcis+1;
if( $ixp < 0 ) { $ixp=$polx-1; }
if( $ixn >= $polx ) { $ixn=0; }
  while ( $ix <= $polx )
  {
  if (@$zaznam=mysql_data_seek($sqldok,$ix))
{
$hlavickax=mysql_fetch_object($sqldok);

if( $ix == 0 ) { $pidm=$hlavickax->slu; }
if( $ix == $ixp ) { $pidp=$hlavickax->slu; }
if( $ix == $ixn ) { $pidn=$hlavickax->slu; }

}
$ix = $ix + 1;
   }

  $text = "<pidm>".$pidm."</pidm>"."\r\n";
  fwrite($soubor, $text);

  $text = "<pidp>".$pidp."</pidp>"."\r\n";
  fwrite($soubor, $text);

  $text = "<pidn>".$pidn."</pidn>"."\r\n";
  fwrite($soubor, $text);


$desc = iconv("CP1250", "UTF-8", $hlavicka->webtx1);

  $text = "<desc>".$desc."</desc>"."\r\n";
  fwrite($soubor, $text);

  $text = "</product>"."\r\n";
  fwrite($soubor, $text);

if( $i == $polm1 ) {


  $text = "</products>"."\r\n";
  fwrite($soubor, $text);

                   }

}
$i = $i + 1;
   }

fclose($soubor);
?>

<br />
<a href="../tmp/<?php echo $nazsub1; ?>.xml">../tmp/<?php echo $nazsub1; ?>.xml</a>
<br />
<br />
<a href="../tmp/<?php echo $nazsub2; ?>.xml">../tmp/<?php echo $nazsub2; ?>.xml</a>
<br />
<br />
<a href="../tmp/<?php echo $nazsub2a; ?>.xml">../tmp/<?php echo $nazsub2a; ?>.xml</a>
<br />
<br />
<a href="../tmp/<?php echo $nazsub3; ?>.xml">../tmp/<?php echo $nazsub3; ?>.xml</a>
<br />
<br />
<a href="../tmp/<?php echo $nazsub4; ?>.xml">../tmp/<?php echo $nazsub4; ?>.xml</a>
<br />
<br />
<a href="../tmp/<?php echo $nazsub5; ?>.xml">../tmp/<?php echo $nazsub5; ?>.xml</a>
<br />
<br />
<a href="../tmp/<?php echo $nazsub6; ?>.xml">../tmp/<?php echo $nazsub6; ?>.xml</a>
<?php

          }
//koniec subor XML
?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
