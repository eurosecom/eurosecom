<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'VYR';
$urov = 2000;
$clsm = 930;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];
//echo $cislo_oc;
//exit;

$ubytovani = 1*$_REQUEST['ubytovani'];


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

    if ( $copern == 1 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete odpÌsaù predaj zo skladu ?") )
         { window.close()  }
else
         { location.href='odpissklad.php?copern=2&drupoh=1&page=1&spo=0&pds=0'  }
</script>
<?php
exit;
//ukonci
    }

    if ( $copern == 2 )
    {
    //pokracuj
    $copern=1;
    }

//pocet dni v mesiaci
$pocetdni=31;
$sqltt = "SELECT * FROM kalendar WHERE ume = $kli_vume ";
$sql = mysql_query("$sqltt");
$pocetdni = mysql_num_rows($sql);

$h_datpsql=$kli_vrok."-".$kli_vmes."-01";
$h_datksql=$kli_vrok."-".$kli_vmes."-".$pocetdni;

$h_datp=SkDatum($h_datpsql);
$h_datk=SkDatum($h_datksql);

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dnes_sk=SkDatum($dnes);

$citfir = include("../doprava/citaj_reg.php");
$citrest = include("../restauracia/citaj_rest.php"); 

//vymaz z vydajok minuly prenos
$h_doknew1="9".$kli_vxcf."0001"; 
$h_doknew2="9".$kli_vxcf."9999"; 
$h_doknew3="8".$kli_vxcf."0001"; 
$h_doknew4="8".$kli_vxcf."9999"; 
//ak prekroci 9999
$kli_vxcf2=$kli_vxcf+1;
$h_doknew5="9".$kli_vxcf2."0000"; 
$h_doknew6="9".$kli_vxcf2."9999"; 
$h_doknew7="8".$kli_vxcf2."0000"; 
$h_doknew8="8".$kli_vxcf2."9999";
//ak prekroci 9999
$kli_vxcf3=$kli_vxcf+2;
$h_doknew11="9".$kli_vxcf3."0000"; 
$h_doknew12="9".$kli_vxcf3."9999"; 
$h_doknew13="8".$kli_vxcf3."0000"; 
$h_doknew14="8".$kli_vxcf3."9999";
//ak prekroci 9999
$kli_vxcf4=$kli_vxcf+3;
$h_doknew15="9".$kli_vxcf4."0000"; 
$h_doknew16="9".$kli_vxcf4."9999"; 
$h_doknew17="8".$kli_vxcf4."0000"; 
$h_doknew18="8".$kli_vxcf4."9999";
//v roku 2016,2017 cislujeme od 1 v penzionskalica.sk
$h_doknew21="1"; 
$h_doknew22="500000"; 
//od 11.2018 cislujeme od 7800001 v penzionskalica.sk
$h_doknew31="7800001"; 
$h_doknew32="7899999";

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklvyd WHERE dat >= '$h_datpsql' AND dat <= '$h_datksql' AND dok >= $h_doknew1 AND dok <= $h_doknew2 AND poh = 12 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklvyd WHERE dok >= $h_doknew3 AND dok <= $h_doknew4 AND poh = 12 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklvyd WHERE dat >= '$h_datpsql' AND dat <= '$h_datksql' AND dok >= $h_doknew5 AND dok <= $h_doknew6 AND poh = 12 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklvyd WHERE dok >= $h_doknew7 AND dok <= $h_doknew8 AND poh = 12 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklvyd WHERE dat >= '$h_datpsql' AND dat <= '$h_datksql' AND dok >= $h_doknew11 AND dok <= $h_doknew12 AND poh = 12 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklvyd WHERE dok >= $h_doknew13 AND dok <= $h_doknew14 AND poh = 12 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklvyd WHERE dat >= '$h_datpsql' AND dat <= '$h_datksql' AND dok >= $h_doknew15 AND dok <= $h_doknew16 AND poh = 12 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklvyd WHERE dok >= $h_doknew17 AND dok <= $h_doknew18 AND poh = 12 ";
$dsql = mysql_query("$dsqlt");

if( $kli_vrok >= 2016 AND $_SERVER['SERVER_NAME'] == "www.penzionskalica.sk" )
  {

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklvyd WHERE dat >= '$h_datpsql' AND dat <= '$h_datksql' AND dok >= $h_doknew21 AND dok <= $h_doknew22 AND poh = 12 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklvyd WHERE dat >= '$h_datpsql' AND dat <= '$h_datksql' AND dok >= $h_doknew31 AND dok <= $h_doknew32 AND poh = 12 ";
$dsql = mysql_query("$dsqlt");

  } 

//vypocitaj priemerne ceny
$sqlpr = 'DROP TABLE F'.$kli_vxcf.'_sklzaspriemer';
$vyslpr = mysql_query("$sqlpr"); 

$sqlt = <<<sklzas
(
   prx         INT,
   skl         INT,
   cis         DECIMAL(15,0),
   cen         DECIMAL(10,4),
   zas         DECIMAL(10,3),
   hop         DECIMAL(10,2)
);
sklzas;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_sklzaspriemer'.$sqlt;
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklzaspriemer ".
" SELECT 0,skl,cis,cen,zas,(cen*zas) ".
" FROM F$kli_vxcf"."_sklzas ".
" WHERE cis >= 0 ORDER BY skl,cis,cen DESC";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklzaspriemer ".
" SELECT 1,skl,cis,MAX(cen),SUM(zas),SUM(hop) ".
" FROM F$kli_vxcf"."_sklzaspriemer ".
" WHERE cis >= 0 GROUP by skl,cis";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklzaspriemer WHERE prx = 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklzaspriemer SET cen=hop/zas WHERE zas > 0 AND hop > 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_sklzaspriemer SET cen=hop/zas WHERE zas < 0 AND hop < 0";
$dsql = mysql_query("$dsqlt");



//co ak je zas > 0 a hop < 0 elebo opacne ??????
//najlepsie keby som vedel zobrat poslednu nakupnu cenu
$dsqlt = "UPDATE F$kli_vxcf"."_sklzaspriemer,F$kli_vxcf"."_sklpri SET ".
" F$kli_vxcf"."_sklzaspriemer.cen=F$kli_vxcf"."_sklpri.cen ".
" WHERE F$kli_vxcf"."_sklzaspriemer.cis=F$kli_vxcf"."_sklpri.cis AND zas > 0 AND hop < 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklzaspriemer,F$kli_vxcf"."_sklpri SET ".
" F$kli_vxcf"."_sklzaspriemer.cen=F$kli_vxcf"."_sklpri.cen ".
" WHERE F$kli_vxcf"."_sklzaspriemer.cis=F$kli_vxcf"."_sklpri.cis AND zas < 0 AND hop > 0 ";
$dsql = mysql_query("$dsqlt");

//koniec vypocitaj priemerne ceny


if( $_SERVER['SERVER_NAME'] == "www.penzionskalica.sk" AND $kli_vrok > 2012 AND $kli_uzid == 17171717 ) 
{
//cocacola cis44 nak0.4821
$dsqlt = "UPDATE F$kli_vxcf"."_sklzaspriemer SET cen=0.4821 WHERE cis = 44 AND cen < 0 ";
$dsql = mysql_query("$dsqlt");

//zmrzlina cis1611 cen2.0454
$dsqlt = "UPDATE F$kli_vxcf"."_sklzaspriemer SET cen=2.0454 WHERE cis = 1611 ";
$dsql = mysql_query("$dsqlt");

//vino sudove cis128 cen 0.1610
$dsqlt = "UPDATE F$kli_vxcf"."_sklzaspriemer SET cen=0.1610 WHERE cis = 128 ";
$dsql = mysql_query("$dsqlt");

//pomarance cis1631 cen0.7875
$dsqlt = "UPDATE F$kli_vxcf"."_sklzaspriemer SET cen=0.7875 WHERE cis = 1631 ";
$dsql = mysql_query("$dsqlt");

//mlieko cis1630 cen0.5417
$dsqlt = "UPDATE F$kli_vxcf"."_sklzaspriemer SET cen=0.5417 WHERE cis = 1630 ";
$dsql = mysql_query("$dsqlt");
}

if( $kli_uzid > 0 )
 {

$sqlttx = "SELECT * FROM F$kli_vxcf"."_sklcis WHERE tl3 = 1  ";
$tovx = mysql_query("$sqlttx");
$tvpolx = mysql_num_rows($tovx);
          
$ix=0;

  while ($ix <= $tvpolx )
  {

  if (@$zaznam=mysql_data_seek($tovx,$ix))
{
$riadokx=mysql_fetch_object($tovx);

$cenazprijmu=0;
$poslhh = "SELECT * FROM F$kli_vxcf"."_sklpri WHERE cis = $riadokx->cis ORDER BY dat DESC ";
$posl = mysql_query("$poslhh"); 
  if (@$zaznam=mysql_data_seek($posl,0))
  {
  $posled=mysql_fetch_object($posl);
  $cenazprijmu = 1*$posled->cen;
  $cis = $posled->cis;
  }

$cenahranica1=0.4*$cenazprijmu; $cenahranica2=1.5*$cenazprijmu;

if( $cenazprijmu > 0 )
  {

$dsqlt = "UPDATE F$kli_vxcf"."_sklzaspriemer SET cen=$cenazprijmu WHERE cis = $riadokx->cis AND ( cen < $cenahranica1 OR cen > $cenahranica2 ) ";
$dsql = mysql_query("$dsqlt");
  }

}
$ix=$ix+1;
  }

 }
//koniec ak kliuzid > 0

if( $kli_uzid == 171717 )
 {

$poslhhh = "SELECT * FROM F$kli_vxcf"."_sklzaspriemer WHERE cis = 1611 ";
$poslh = mysql_query("$poslhhh"); 
  if (@$zaznam=mysql_data_seek($poslh,0))
  {
  $posledh=mysql_fetch_object($poslh);
  $cena = $posledh->cen;
  $cis = $posledh->cis;
  }

echo "cis ".$cis." cena ".$cena;

exit;
 }

                                             
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>
<?php if( $copern == 1 ) { echo "Zostava PDF"; } ?>
</title>
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
<td>EuroSecom  -  Odpis zo skladu <?php echo $kli_vume; ?> 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/mzdtlac$kli_uzid.pdf")) { $soubor = unlink("../tmp/mzdtlac$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

if ( $copern == 1 )
    {

$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$sqlt = <<<mzdprc
(
   pox          int,
   cpl          int,
   dok          DECIMAL(10,0) DEFAULT 0,
   dax          DATE not null,
   icx          DECIMAL(10,0) DEFAULT 0,
   cix          VARCHAR(15) not null,
   cis          VARCHAR(15) not null,
   ckm          VARCHAR(15) not null,
   mnx          DECIMAL(10,3) DEFAULT 0,
   mno          DECIMAL(10,3) DEFAULT 0,
   cen          DECIMAL(10,4) DEFAULT 0,
   cep          DECIMAL(10,2) DEFAULT 0,
   ced          DECIMAL(10,2) DEFAULT 0,
   hos          DECIMAL(10,2) DEFAULT 0,
   hop          DECIMAL(10,2) DEFAULT 0,
   hdp          DECIMAL(10,2) DEFAULT 0,
   hod          DECIMAL(10,2) DEFAULT 0,
   rcp          DECIMAL(10,0) DEFAULT 0,
   kon          INT(7) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

//restpredp dok  cpl  rnaz  druhp  iban  twib  jmno  ksy  rcis  xdph  hodp  rcep  rced  uce  ico  id  datm  dfak  cfak  

//zober zo restpredp
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcu".$kli_uzid.
" SELECT 1,cpl,dok,'0000-00-00',0,rcis,rcis,0,jmno,jmno,0,rcep,rced,0,0,0,0,'',0 FROM F$kli_vxcf"."_restpredp".
" WHERE jmno != 0 ".
"";
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcu".$kli_uzid.",F$kli_vxcf"."_restpredh ".
" SET dax=dat, icx=ico ".
" WHERE F$kli_vxcf"."_mzdprcu".$kli_uzid.".dok=F$kli_vxcf"."_restpredh.dok ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcu".$kli_uzid." WHERE dax < '$h_datpsql' OR dax > '$h_datksql' ";
$dsql = mysql_query("$dsqlt");

//zober zo restpredp
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcu".$kli_uzid.
" SELECT 1,cpl,dok,'0000-00-00',0,rcis,rcis,0,jmno,jmno,0,rcep,rced,0,0,0,0,'',0 FROM F$kli_vxcf"."_restdodp".
" WHERE jmno != 0 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcu".$kli_uzid.",F$kli_vxcf"."_restdodh ".
" SET dax=dat, icx=ico ".
" WHERE F$kli_vxcf"."_mzdprcu".$kli_uzid.".dok=F$kli_vxcf"."_restdodh.dok ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcu".$kli_uzid." WHERE cis = $reg_vklad ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcu".$kli_uzid." WHERE cis = $reg_vyber ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcu".$kli_uzid." WHERE cis = $reg_uhrfa ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcu".$kli_uzid." WHERE cis = $reg_plkar ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcu".$kli_uzid." WHERE cis >= 500 AND cis <= 550 ";
$dsql = mysql_query("$dsqlt");

//tu zober recepty a prirad do cis a mno podla receptu
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcu".$kli_uzid.",F$kli_vxcf"."_sklcisudaje ".
" SET F$kli_vxcf"."_mzdprcu".$kli_uzid.".rcp=F$kli_vxcf"."_sklcisudaje.xrcp ".
" WHERE F$kli_vxcf"."_mzdprcu".$kli_uzid.".cis=F$kli_vxcf"."_sklcisudaje.xcis AND F$kli_vxcf"."_sklcisudaje.xrcx = 1 ".
"";
$dsql = mysql_query("$dsqlt");

//polozky s receptom
$norma2=1;
if( $norma2 == 1 ) {
//normovanie

$sqlttx = "SELECT * FROM F$kli_vxcf"."_mzdprcu$kli_uzid ".
" LEFT JOIN F$kli_vxcf"."_kuchrecepth".
" ON F$kli_vxcf"."_mzdprcu$kli_uzid.rcp=F$kli_vxcf"."_kuchrecepth.crcp".
" WHERE F$kli_vxcf"."_mzdprcu$kli_uzid.rcp > 0 ".
" ORDER BY F$kli_vxcf"."_mzdprcu$kli_uzid.cpl ";
//echo $sqlttx;
//exit;
$tovx = mysql_query("$sqlttx");
$tvpolx = mysql_num_rows($tovx);
          
$ix=0;

  while ($ix <= $tvpolx )
  {

  if (@$zaznam=mysql_data_seek($tovx,$ix))
{
$riadokx=mysql_fetch_object($tovx);


//pox  cpl  dok  dax  icx  cix  cis ckm mnx  mno  cen  cep  ced  hop  hdp  hod  rcp  kon 

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx$kli_uzid "." SELECT".
" 2,0,'$riadokx->dok','$riadokx->dax','$riadokx->icx','$riadokx->cix',0,ckmp,'$riadokx->mnx',(mkmp*$riadokx->mnx),0,'0','0',".
" 0,0,0,0,'$riadokx->rcp',0 ".
" FROM F$kli_vxcfrcp"."_kuchreceptp ".
" WHERE F$kli_vxcfrcp"."_kuchreceptp.crcp = $riadokx->rcp ".
"";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;
}

$ix=$ix+1;
   }

               } 
//koniec polozky s receptom

//prirad surovine skladovu polozku
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid.",F$kli_vxcf"."_kuchsuroviny ".
" SET F$kli_vxcf"."_mzdprcx".$kli_uzid.".cis=F$kli_vxcf"."_kuchsuroviny.cisk ".
" WHERE F$kli_vxcf"."_mzdprcx".$kli_uzid.".ckm=F$kli_vxcf"."_kuchsuroviny.ckmp ".
"";
$dsql = mysql_query("$dsqlt");

//exit;

//polozky bez receptu
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 2,cpl,dok,dax,icx,cix,cis,ckm,mnx,mno,cen,0,0,0,0,0,0,0,kon  FROM F$kli_vxcf"."_mzdprcu".$kli_uzid." ".
" WHERE pox = 1 AND rcp = 0  GROUP BY cpl".
"";
$dsql = mysql_query("$dsqlt");


//prirad cen z sklzaspriemer podla cis
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid.",F$kli_vxcf"."_sklzaspriemer ".
" SET F$kli_vxcf"."_mzdprcx".$kli_uzid.".cen=F$kli_vxcf"."_sklzaspriemer.cen ".
" WHERE F$kli_vxcf"."_mzdprcx".$kli_uzid.".cis=F$kli_vxcf"."_sklzaspriemer.cis ".
"";
$dsql = mysql_query("$dsqlt");

//trzby za doklad
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 4,cpl,dok,dax,icx,cix,cis,ckm,mnx,0,0,cep,ced,0,0,0,0,0,kon  FROM F$kli_vxcf"."_mzdprcu".$kli_uzid." ".
" WHERE pox = 1 GROUP BY cpl".
"";
$dsql = mysql_query("$dsqlt");

//polozky bez ceny
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcv".$kli_uzid.
" SELECT * FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE pox = 2 AND cen = 0  GROUP BY cis".
"";
$dsql = mysql_query("$dsqlt");

//uloz do vydajok
//sklvyd    cpl  ume  dat  dok  doq  skl  poh  ico  fak  unk  poz  str  zak  cis  mno  cen  id  sk2  datm  me2  mn2 


$dsqlt = "INSERT INTO F$kli_vxcf"."_sklvyd ".
" SELECT 0,$kli_vume,dax,dok,dok,'$fir_xrsskv',12,icx,0,'','','$fir_xrsstr','$fir_xrszak',".
" 0,0,0,$kli_uzid,0,now(),0,0   FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE pox = 2 GROUP BY dok".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklvyd ".
" SELECT 0,$kli_vume,dax,dok,dok,'$fir_xrsskv',12,icx,0,'','','$fir_xrsstr','$fir_xrszak',".
" cis,SUM(mno),cen,$kli_uzid,0,now(),0,0   FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE pox = 2 AND cis > 0 GROUP BY dok,cis,cen ".
"";
$dsql = mysql_query("$dsqlt");

//exit;
  }

if ( $drupoh == 1 )
    {
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET hos=cen*mno, hop=cep*mnx, hod=ced*mnx, hdp=hod-hop ";
$dsql = mysql_query("$dsqlt");

//group doklad
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,cpl,dok,dax,icx,cix,cis,ckm,mnx,mno,cen,cep,ced,SUM(hos),SUM(hop),SUM(hdp),SUM(hod),rcp,kon  FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE pox < 5 GROUP BY dok".
"";
$dsql = mysql_query("$dsqlt");

//group vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 10,cpl,dok,dax,icx,cix,cis,ckm,mnx,mno,cen,cep,ced,SUM(hos),SUM(hop),SUM(hdp),SUM(hod),rcp,kon   FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE pox = 1 GROUP BY pox".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." WHERE pox != 1 AND pox != 10 ";
$dsql = mysql_query("$dsqlt");
    }



if ( $drupoh == 1 )
  {
$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE ( pox = 1 OR pox = 10 ) ORDER BY pox,dok ";
  }




//echo $sqltt;
//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//exit;

$zostatokeur=0;
$zostatok=0;
$new=0;
$strana=0;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);

$dax_sk=SkDatum($riadok->dax);


//hlavicka strany
if ( $j == 0 )
     {


$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$pdf->SetFont('arial','',10);
if ( $copern == 1 AND $drupoh == 1 )  { $pdf->Cell(90,6,"Odpis zo skladu $h_datp / $h_datk ","LTB",0,"L"); }

$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',10);

if ( $copern == 1 AND $drupoh == 1 )  {
$pdf->Cell(110,5,"Doklad","1",0,"L");$pdf->Cell(40,5,"Predan˝ tovar","1",0,"R");$pdf->Cell(40,5,"Trûba bez DPH","1",0,"R");
$pdf->Cell(40,5,"DPH","1",0,"R");$pdf->Cell(40,5,"Trûba s DPH","1",1,"R");
                                      }
     }
//koniec hlavicky j=0



if( $riadok->pox == 1 AND $drupoh == 1 )
{

$pdf->SetFont('arial','',10);

$pdf->Cell(110,4,"$riadok->dok","0",0,"L");$pdf->Cell(40,4,"$riadok->hos","0",0,"R");$pdf->Cell(40,4,"$riadok->hop","0",0,"R");
$pdf->Cell(40,4,"$riadok->hdp","0",0,"R");$pdf->Cell(40,4,"$riadok->hod","0",1,"R");

}


if( $riadok->pox == 10 AND $drupoh == 1 )
{

$pdf->SetFont('arial','',10);

$pdf->Cell(110,4,"Celkom","1",0,"L");$pdf->Cell(40,4,"$riadok->hos","1",0,"R");$pdf->Cell(40,4,"$riadok->hop","1",0,"R");
$pdf->Cell(40,4,"$riadok->hdp","1",0,"R");$pdf->Cell(40,4,"$riadok->hod","1",1,"R");

}


}
$i = $i + 1;
$j = $j + 1;
if( $j > 38 ) $j=0;

  }


//polozky bez ceny
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcv".$kli_uzid." ".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_mzdprcv$kli_uzid.cis=F$kli_vxcf"."_sklcis.cis".
" WHERE F$kli_vxcf"."_mzdprcv$kli_uzid.cis > 0 ORDER BY F$kli_vxcf"."_mzdprcv$kli_uzid.cis ";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
          
$i=0;
  while ($i <= $tvpol AND $tvpol > 0 )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);



//hlavicka strany
if ( $i == 0 )
     {


$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$pdf->SetFont('arial','',10);
$pdf->Cell(90,6,"Poloûky bez priradenej ceny ","LTB",0,"L"); 

$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(0,4,"PLU","1",1,"L");

     }
//koniec hlavicky j=0


$pdf->SetFont('arial','',10);

$pdf->Cell(20,4,"$riadok->cis","0",0,"R");$pdf->Cell(0,4,"$riadok->nat","0",1,"L");


}
$i = $i + 1;

  }


$pdf->Output("../tmp/mzdtlac.$kli_uzid.pdf");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/mzdtlac.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
