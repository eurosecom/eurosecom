<!doctype html>
<HTML>
<?php
//HLASENIE 2018
do
{
$sys = 'MZD';
$urov = 2000;
$uziv = include("../uziv.php");
if ( !$uziv ) exit;

if (!isset($kli_vxcf)) $kli_vxcf = 1;

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
alert ("Hl·senie bude pripravenÈ v priebehu janu·ra 2019. Aktu·lne info n·jdete na vstupnej str·nke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_oc = $_REQUEST['cislo_oc'];
$mes1=1;
$mes2=2;
$mes3=3;
if ( $cislo_oc == 2 ) { $mes1=4; $mes2=5; $mes3=6; }
if ( $cislo_oc == 3 ) { $mes1=7; $mes2=8; $mes3=9; }
if ( $cislo_oc == 4 ) { $mes1=10; $mes2=11; $mes3=12; }

//cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);

//new zamestnanec
if ( $copern == 2500 )
     {
$cislo_ocn = 1*$_REQUEST['cislo_ocn'];

$ockunje="0";
$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_mzdkun WHERE oc = $cislo_ocn ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ockunje=1;
  }

$ochlaje="0";
$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_mzdrocnehlaseniedaneoc WHERE oc = $cislo_ocn ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ochlaje=1;
  }

$ulozocn=0;
if ( $cislo_ocn > 0 AND $cislo_ocn < 9999 AND $ockunje == 1 AND $ochlaje == 0 ) { $ulozocn=1; }

$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdrocnehlaseniedaneoc ( oc, tz1 ) VALUES ( '$cislo_ocn', 0 ) ";
if ( $ulozocn == 1 ) { $upravene = mysql_query("$uprtxt"); }
//echo $cislo_ocn;
$copern=101;
     }
//koniec new

//zmazat zamestnanca
if ( $copern == 502 )
     {
$cislo_oc = strip_tags($_REQUEST['cislo_oc']);
$uprtxt = "DELETE FROM F$kli_vxcf"."_mzdrocnehlaseniedaneoc WHERE oc = $cislo_oc ";
$upravene = mysql_query("$uprtxt");  
$copern=101;
     }
//koniec zmazat zamestnanca

//sumarizuj podla rc
if ( $copern == 4402 )
     {
$cislo_oc = strip_tags($_REQUEST['cislo_oc']);

$akerodc=""; $akerodk="";
$sqlttt = "SELECT * FROM F".$kli_vxcf."_mzdkun WHERE oc = $cislo_oc ";
//echo $sqlttt."<br />";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akerodc=$riaddok->rdc;
  $akerodk=$riaddok->rdk;
  }

//echo "idem".$akerodc." ".$akerodk."<br />";


$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE rdc = '$akerodc' AND rdk = '$akerodk' AND oc != $cislo_oc ORDER BY oc ";
$sql = mysql_query("$sqltt");
//echo $sqltt."<br />";

//celkom poloziek
$cpol = mysql_num_rows($sql);
$i=0;
   while ($i <= $cpol )
   {
if (@$zaznam=mysql_data_seek($sql,$i))
{
$riadok=mysql_fetch_object($sql);

$sqlttt = "SELECT * FROM F".$kli_vxcf."_mzdrocnehlaseniedaneoc WHERE oc = $riadok->oc ";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ocx=$riaddok->oc;
  //echo "pripocitavam a mazem osc ".$ocx."<br />";

  $r01a=1*$riaddok->r01a;
  $r01b=1*$riaddok->r01b;
  $doho=1*$riaddok->doho;
  $dnbh=1*$riaddok->dnbh;
  $socp=1*$riaddok->socp;
  $zdrp=1*$riaddok->zdrp;
  $ddssum=1*$riaddok->ddssum;

  $mz01=1*$riaddok->mz01;
  $mz02=1*$riaddok->mz02;
  $mz03=1*$riaddok->mz03;
  $mz04=1*$riaddok->mz04;
  $mz05=1*$riaddok->mz05;
  $mz06=1*$riaddok->mz06;
  $mz07=1*$riaddok->mz07;
  $mz08=1*$riaddok->mz08;
  $mz09=1*$riaddok->mz09;
  $mz10=1*$riaddok->mz10;
  $mz11=1*$riaddok->mz11;
  $mz12=1*$riaddok->mz12;


$sqltt2 = "DELETE FROM F".$kli_vxcf."_mzdrocnehlaseniedaneoc WHERE oc = $riadok->oc ";
$sqldo2 = mysql_query("$sqltt2");

$sqltt2 = "UPDATE F".$kli_vxcf."_mzdrocnehlaseniedaneoc SET mz01=1 WHERE mzc = 0 AND oc = $cislo_oc ";
if( $mz01 == 1 ) { $sqldo2 = mysql_query("$sqltt2"); }
$sqltt2 = "UPDATE F".$kli_vxcf."_mzdrocnehlaseniedaneoc SET mz02=1 WHERE mzc = 0 AND oc = $cislo_oc ";
if( $mz02 == 1 ) { $sqldo2 = mysql_query("$sqltt2"); }
$sqltt2 = "UPDATE F".$kli_vxcf."_mzdrocnehlaseniedaneoc SET mz03=1 WHERE mzc = 0 AND oc = $cislo_oc ";
if( $mz03 == 1 ) { $sqldo2 = mysql_query("$sqltt2"); }
$sqltt2 = "UPDATE F".$kli_vxcf."_mzdrocnehlaseniedaneoc SET mz04=1 WHERE mzc = 0 AND oc = $cislo_oc ";
if( $mz04 == 1 ) { $sqldo2 = mysql_query("$sqltt2"); }
$sqltt2 = "UPDATE F".$kli_vxcf."_mzdrocnehlaseniedaneoc SET mz05=1 WHERE mzc = 0 AND oc = $cislo_oc ";
if( $mz05 == 1 ) { $sqldo2 = mysql_query("$sqltt2"); }
$sqltt2 = "UPDATE F".$kli_vxcf."_mzdrocnehlaseniedaneoc SET mz06=1 WHERE mzc = 0 AND oc = $cislo_oc ";
if( $mz06 == 1 ) { $sqldo2 = mysql_query("$sqltt2"); }
$sqltt2 = "UPDATE F".$kli_vxcf."_mzdrocnehlaseniedaneoc SET mz07=1 WHERE mzc = 0 AND oc = $cislo_oc ";
if( $mz07 == 1 ) { $sqldo2 = mysql_query("$sqltt2"); }
$sqltt2 = "UPDATE F".$kli_vxcf."_mzdrocnehlaseniedaneoc SET mz08=1 WHERE mzc = 0 AND oc = $cislo_oc ";
if( $mz08 == 1 ) { $sqldo2 = mysql_query("$sqltt2"); }
$sqltt2 = "UPDATE F".$kli_vxcf."_mzdrocnehlaseniedaneoc SET mz09=1 WHERE mzc = 0 AND oc = $cislo_oc ";
if( $mz09 == 1 ) { $sqldo2 = mysql_query("$sqltt2"); }
$sqltt2 = "UPDATE F".$kli_vxcf."_mzdrocnehlaseniedaneoc SET mz10=1 WHERE mzc = 0 AND oc = $cislo_oc ";
if( $mz10 == 1 ) { $sqldo2 = mysql_query("$sqltt2"); }
$sqltt2 = "UPDATE F".$kli_vxcf."_mzdrocnehlaseniedaneoc SET mz11=1 WHERE mzc = 0 AND oc = $cislo_oc ";
if( $mz11 == 1 ) { $sqldo2 = mysql_query("$sqltt2"); }
$sqltt2 = "UPDATE F".$kli_vxcf."_mzdrocnehlaseniedaneoc SET mz12=1 WHERE mzc = 0 AND oc = $cislo_oc ";
if( $mz12 == 1 ) { $sqldo2 = mysql_query("$sqltt2"); }

$sqltt2 = "UPDATE F".$kli_vxcf."_mzdrocnehlaseniedaneoc SET ".
" mzc=1, mz01=0, mz02=0, mz03=0, mz04=0, mz05=0, mz06=0, mz07=0, mz08=0, mz09=0, mz10=0, mz11=0, mz12=0 ".
" WHERE mzc = 0 AND  mz01 = 1 AND mz02 = 1 AND mz03 = 1 AND mz04 = 1 AND mz05 = 1 AND mz06 = 1 AND mz07 = 1 AND mz08 = 1 AND mz09 = 1 AND mz10 = 1 AND mz11 = 1 AND mz12 = 1 AND oc = $cislo_oc ";
$sqldo2 = mysql_query("$sqltt2");

$sqltt2 = "UPDATE F".$kli_vxcf."_mzdrocnehlaseniedaneoc SET ".
" r01a=r01a+'$r01a', r01b=r01b+'$r01b', doho=doho+'$doho', dnbh=dnbh+'$dnbh', socp=socp+'$socp', zdrp=zdrp+'$zdrp', ddssum=ddssum+'$ddssum' WHERE oc = $cislo_oc ";
$sqldo2 = mysql_query("$sqltt2");
//echo $sqltt2."<br />";

  }

}
$i=$i+1;
   }



$copern=101;
     }
//koniec sumarizuj podla rc

//nacitaj z rz
if ( $copern == 1102 )
     {
$cislo_oc = strip_tags($_REQUEST['cislo_oc']);

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdrocnedane SET ".
" tz1=1, rocz=r15-r16,  ".

" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.dnbh=F$kli_vxcf"."_mzdrocnedane.r10, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.zmpm=F$kli_vxcf"."_mzdrocnedane.r08, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.ra1b=F$kli_vxcf"."_mzdrocnedane.r09, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.nzmh=F$kli_vxcf"."_mzdrocnedane.r04b, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.r01b=F$kli_vxcf"."_mzdrocnedane.r14, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.nzdh=F$kli_vxcf"."_mzdrocnedane.r04a, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.zdrp=F$kli_vxcf"."_mzdrocnedane.r00c, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.socp=F$kli_vxcf"."_mzdrocnedane.r00b, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.doho=F$kli_vxcf"."_mzdrocnedane.r00d, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.r01a=F$kli_vxcf"."_mzdrocnedane.r00, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.prvypj=F$kli_vxcf"."_mzdrocnedane.r00z1 ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdrocnedane.oc AND vyk = 1 AND F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc = $cislo_oc ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$copern=102;
     }
//koniec nacitaj z rz

$ulozenezmeny=0;
//zapis upravene udaje strana 2
if ( $copern == 103 )
     {
$oc = strip_tags($_REQUEST['oc']);
$r01a = strip_tags($_REQUEST['r01a']);
$r01c = strip_tags($_REQUEST['r01c']);
$doho = strip_tags($_REQUEST['doho']);
$r01b = strip_tags($_REQUEST['r01b']);
$tz1 = strip_tags($_REQUEST['tz1']);
$tz3 = strip_tags($_REQUEST['tz3']);
$dnbh = strip_tags($_REQUEST['dnbh']);
$ra1b = strip_tags($_REQUEST['ra1b']);
$mzc = strip_tags($_REQUEST['mzc']);
$mz01 = strip_tags($_REQUEST['mz01']);
$mz02 = strip_tags($_REQUEST['mz02']);
$mz03 = strip_tags($_REQUEST['mz03']);
$mz04 = strip_tags($_REQUEST['mz04']);
$mz05 = strip_tags($_REQUEST['mz05']);
$mz06 = strip_tags($_REQUEST['mz06']);
$mz07 = strip_tags($_REQUEST['mz07']);
$mz08 = strip_tags($_REQUEST['mz08']);
$mz09 = strip_tags($_REQUEST['mz09']);
$mz10 = strip_tags($_REQUEST['mz10']);
$mz11 = strip_tags($_REQUEST['mz11']);
$mz12 = strip_tags($_REQUEST['mz12']);
$pred = strip_tags($_REQUEST['pred']);
$pdan = strip_tags($_REQUEST['pdan']);
$socp = strip_tags($_REQUEST['socp']);
$zdrp = strip_tags($_REQUEST['zdrp']);
$dnbm = strip_tags($_REQUEST['dnbm']);
$nzdh = strip_tags($_REQUEST['nzdh']);
$nzmh = strip_tags($_REQUEST['nzmh']);
$zmpm = strip_tags($_REQUEST['zmpm']);
$rocz = strip_tags($_REQUEST['rocz']);
$ddssum = strip_tags($_REQUEST['ddssum']);
$ddsnzc = strip_tags($_REQUEST['ddsnzc']);

$prvypj = strip_tags($_REQUEST['prvypj']);
$dds2nc = strip_tags($_REQUEST['dds2nc']);
$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc SET ".
" ddssum='$ddssum', ddsnzc='$ddsnzc', dds2nc='$dds2nc', prvypj='$prvypj',".
" mzc='$mzc', mz01='$mz01', mz02='$mz02', mz03='$mz03', mz04='$mz04', mz05='$mz05', ".
" mz06='$mz06', mz07='$mz07', mz08='$mz08', mz09='$mz09', mz10='$mz10', mz11='$mz11', mz12='$mz12', ".
" r01a='$r01a', r01b='$r01b', r01c='$r01c', dnbh='$dnbh', ra1b='$ra1b', tz1='$tz1', tz3='$tz3', ".
" doho='$doho', pred='$pred', pdan='$pdan', socp='$socp', zdrp='$zdrp', dnbm='$dnbm', nzdh='$nzdh', nzmh='$nzmh', zmpm='$zmpm', rocz='$rocz'  ".
" WHERE oc = $oc"; 
//echo $uprtxt;

$upravene = mysql_query("$uprtxt");  
$copern=102;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN…" ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
$ulozenezmeny=1;
endif;
     }
//koniec zapisu upravenych udajov strana 2


//nacitaj udaje zamestnanca
if ( $copern > 100 )
     {
$oc = 1*strip_tags($_REQUEST['oc']);

$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdrocnehlaseniedaneoc ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc = $oc ORDER BY F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc";
//echo $sqlfir;

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
$rodnec = $fir_riadok->rdc;
$rodnek = $fir_riadok->rdk;
$narodeny = SkDatum($fir_riadok->dar);
$prie = $fir_riadok->prie;
$meno = $fir_riadok->meno;
$uli = $fir_riadok->zuli;
$cdm = $fir_riadok->zcdm;
$psc = $fir_riadok->zpsc;
$mes = $fir_riadok->zmes;
$r01a = $fir_riadok->r01a;
$r01c = $fir_riadok->r01c;
$doho = $fir_riadok->doho;
$r01b = $fir_riadok->r01b;
$dnbh = $fir_riadok->dnbh;
$ra1b = $fir_riadok->ra1b;
$tz1 = $fir_riadok->tz1;
$tz3 = $fir_riadok->tz3;
$mzc = strip_tags($fir_riadok->mzc);
$mz01 = strip_tags($fir_riadok->mz01);
$mz02 = strip_tags($fir_riadok->mz02);
$mz03 = strip_tags($fir_riadok->mz03);
$mz04 = strip_tags($fir_riadok->mz04);
$mz05 = strip_tags($fir_riadok->mz05);
$mz06 = strip_tags($fir_riadok->mz06);
$mz07 = strip_tags($fir_riadok->mz07);
$mz08 = strip_tags($fir_riadok->mz08);
$mz09 = strip_tags($fir_riadok->mz09);
$mz10 = strip_tags($fir_riadok->mz10);
$mz11 = strip_tags($fir_riadok->mz11);
$mz12 = strip_tags($fir_riadok->mz12);
$pred = strip_tags($fir_riadok->pred);
$pdan = 1*strip_tags($fir_riadok->pdan);
$socp = strip_tags($fir_riadok->socp);
$zdrp = strip_tags($fir_riadok->zdrp);
$dnbm = strip_tags($fir_riadok->dnbm);
$nzdh = strip_tags($fir_riadok->nzdh);
$nzmh = strip_tags($fir_riadok->nzmh);
$zmpm = strip_tags($fir_riadok->zmpm);
$rocz = strip_tags($fir_riadok->rocz);
$ddssum = strip_tags($fir_riadok->ddssum);
$ddsnzc = strip_tags($fir_riadok->ddsnzc);

$prvypj = strip_tags($fir_riadok->prvypj);
$dds2nc = strip_tags($fir_riadok->dds2nc);
mysql_free_result($fir_vysledok);

//Slovak a cudzinec
$zstat="Slovensko"; $zstak="703";
$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_mzdtextmzd WHERE invt = $oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zstat=$riaddok->zstat;
  $zstak=$riaddok->zstak;
  }
if ( $zstat == '' ) { $zstat="Slovensko"; }
if ( $zstak == 0 ) { $zstak="703"; }
//if ( $zstak != 703 ) { $rodnec=""; $rodnek=""; }
if ( $zstak == 703 ) { $narodeny=""; }
     }
//koniec nacitania zamestnanca
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - PrÌloha k Hl·seniu dane</title>
<style type="text/css">
div.wrap-zoznam {
  overflow: auto;
  width: 100%;
  background-color: #fff;
}
span.puntik {
  padding: 0 5px;
  background-color: #93ccde;
}
table.zoznam {
  width: 936px;
  margin: 5px auto;
  font-size: 13px;
}
table.zoznam thead th {
  height: 16px;
  line-height: 16px;
  font-size: 11px;
  background-color: ;
  vertical-align:middle;
  color: #999;
}
table.zoznam tr.stripe-dark {
  background-color: #e1f1f6;
}
table.zoznam tbody td {
  height: 24px;
  line-height: 24px;
  border-top: 2px solid #fff;
  text-align: right;
}
table.zoznam tbody td.rzclassano {
  background-color: #93ccde;
  font-weight: bold;
}
table.zoznam tbody img {
  position: relative;
  top: 3px;
  width: 16px;
  height: 16px;
  cursor: pointer;
}
table.zoznam tbody a { color: #000; }
table.zoznam tbody a:hover { color: #39f; }
table.zoznam tfoot td {
  height: 18px;
  line-height: 18px;
  border-top: 2px solid #add8e6;
  font-size: 11px;
  font-weight: bold;
  text-align: right;
  color: #999;
}
select.btn-rzstav {
  height: 28px;
  border: 2px solid #39f;
  font-weight: bold;
  color: #39f;
  font-size: 13px;
  cursor: pointer;
}
div.leg-osc {
  position: absolute;
  left: 0;
  width: 50px;
  height: 28px;
  line-height: 28px;
  background-color: #add8e6;
  text-indent: 3px;
  letter-spacing: 1px;
  color: #39f;
  font-size: 15px;
  font-weight: bold;
}
a.btn-rzuprav {
  position: absolute;
  height: 24px;
  line-height: 24px;
  width: 100px;
  border: 2px solid #39f;
  background-color: #fff;
  text-align: center;
  color: #39f;
  font-weight: bold;
  font-size: 13px;
}
div.addzam-bar {
  position: absolute;
  top: 19px;
  right: 73px;
  width: 207px;
  height: 28px;
  line-height: 30px;
  background-color: #add8e6;
  font-size: 12px;
}
div.addzam-bar input {
  width: 40px;
  height: 18px;
  line-height: 18px;
  margin: 3px 0 0 3px;
  font-size: 13px;
}

div.addzam-bar a {
  float: right;
  width: 40px;
  height: 22px;
  line-height: 24px;
  margin: 3px 3px 3px 0;
  text-align: center;
  color: #fff;
  font-weight: bold;
  font-size: 11px;
}
a.addzam-btn {
  position: absolute;
  top: 21px;
  right: 74px;
  height: 23px;
  line-height: 23px;
  width: 80px;
  background-color: #39f;
  color: #fff;
  font-size: 12px;
  font-weight: bold;
  text-align: center;
}
span.text-echo {
  font-size: 18px;
  letter-spacing: 13px;
}
div.input-echo {
  position: absolute;
  font-size: 18px;
  background-color: #fff;
}
</style>
<script language="JavaScript" src="../js/cookies.js"></script>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

<?php
//uprava sadzby
if ( $copern == 102 )
{
?>
  function ObnovUI()
  {
   document.formv1.r01a.value = '<?php echo "$r01a";?>';
   document.formv1.doho.value = '<?php echo "$doho";?>';
<?php if ( $mzc == 1 ) { ?> document.formv1.mzc.checked = "checked"; <?php } ?>
<?php if ( $mz01 == 1 ) { ?> document.formv1.mz01.checked = "checked"; <?php } ?>
<?php if ( $mz02 == 1 ) { ?> document.formv1.mz02.checked = "checked"; <?php } ?>
<?php if ( $mz03 == 1 ) { ?> document.formv1.mz03.checked = "checked"; <?php } ?>
<?php if ( $mz04 == 1 ) { ?> document.formv1.mz04.checked = "checked"; <?php } ?>
<?php if ( $mz05 == 1 ) { ?> document.formv1.mz05.checked = "checked"; <?php } ?>
<?php if ( $mz06 == 1 ) { ?> document.formv1.mz06.checked = "checked"; <?php } ?>
<?php if ( $mz07 == 1 ) { ?> document.formv1.mz07.checked = "checked"; <?php } ?>
<?php if ( $mz08 == 1 ) { ?> document.formv1.mz08.checked = "checked"; <?php } ?>
<?php if ( $mz09 == 1 ) { ?> document.formv1.mz09.checked = "checked"; <?php } ?>
<?php if ( $mz10 == 1 ) { ?> document.formv1.mz10.checked = "checked"; <?php } ?>
<?php if ( $mz11 == 1 ) { ?> document.formv1.mz11.checked = "checked"; <?php } ?>
<?php if ( $mz12 == 1 ) { ?> document.formv1.mz12.checked = "checked"; <?php } ?>
   document.formv1.r01b.value = '<?php echo "$r01b";?>';
   document.formv1.tz1.value = '<?php echo "$tz1";?>';
   document.formv1.dnbh.value = '<?php echo "$dnbh";?>';
   document.formv1.tz3.value = '<?php echo "$tz3";?>';
<?php if ( $pred == 1 ) { ?> document.formv1.pred.checked = "checked"; <?php } ?>
   document.formv1.pdan.value = '<?php echo "$pdan";?>';
   document.formv1.ra1b.value = '<?php echo "$ra1b";?>';
   document.formv1.socp.value = '<?php echo "$socp";?>';
   document.formv1.zdrp.value = '<?php echo "$zdrp";?>';
   document.formv1.dnbm.value = '<?php echo "$dnbm";?>';
   document.formv1.nzdh.value = '<?php echo "$nzdh";?>';
   document.formv1.nzmh.value = '<?php echo "$nzmh";?>';
   document.formv1.zmpm.value = '<?php echo "$zmpm";?>';
   document.formv1.rocz.value = '<?php echo "$rocz";?>';
   document.formv1.ddssum.value = '<?php echo "$ddssum";?>';
   document.formv1.ddsnzc.value = '<?php echo "$ddsnzc";?>';

   document.formv1.prvypj.value = '<?php echo "$prvypj";?>';
   document.formv1.dds2nc.value = '<?php echo "$dds2nc";?>';

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
//koniec nie uprava
}
?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
<?php if ( $ulozenezmeny ==  1 ) { ?>
   alertdiv.style.display='none';
<?php                            } ?>
   if ( Vstup.value.search(/[^0-9.-]/g) != -1 ) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function PoucVyplnenie()
  {
   window.open('../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/hlasenie_dane/hlasenie_v14_poucenie.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function upravRZ()
  {
   window.open('../mzdy/rocne_dane2018.php?cislo_oc=<?php echo $oc; ?>&copern=20&drupoh=1&page=1&subor=0', '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes');
  }
  function nacitajRZ()
  {
   window.open('../mzdy/hlasenie_daneoc2018.php?cislo_oc=<?php echo $oc; ?>&copern=1102&oc=<?php echo $oc; ?>&uprav=1', '_self', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes');
  }
  function sumarRC(oc)
  {
   window.open('../mzdy/hlasenie_daneoc2018.php?cislo_oc='+ oc + '&copern=4402&oc='+ oc + '&uprav=1', '_self', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes');
  }
<?php $dnessk = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?>
  function TlacRocHlasenie2014priloha()
  {
   window.open('../mzdy/hlasenie_dane2014.php?h_drp=1&h_dap=<?php echo $dnessk; ?>&copern=10&drupoh=2&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function UpravZamestnanca()
  {
   window.open('zamestnanci.php?sys=MZD&copern=8&page=1&cislo_oc=<?php echo $oc;?>&h_oc=<?php echo $oc;?>', '_blank','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes');
  }
  function upravOC(oc)
  {
   window.open('hlasenie_daneoc2018.php?copern=102&oc='+ oc + '&drupoh=<?php echo $drupoh;?>&uprav=1', '_self');
  }
  function zmazOC(oc)
  {
   window.open('hlasenie_daneoc2018.php?copern=502&cislo_oc='+ oc + '&drupoh=<?php echo $drupoh;?>&uprav=1', '_self');
  }
//new zamestnanec
  function rozninewoc()
  { 
   newocdiv.style.display='';
   myNewoc = document.getElementById("newocdiv");
  }
  function zhasninewoc()
  { 
   newocdiv.style.display='none';
  }
  function uloznewoc()
  {
   var ocn = document.forms.newoc.h_ocn.value;
   window.open('hlasenie_daneoc2018.php?copern=2500&cislo_ocn='+ ocn + '&drupoh=<?php echo $drupoh;?>&uprav=1', '_self');
  }
</script>
</HEAD>
<BODY onload="ObnovUI();">

<div id="wrap-heading">
 <table id="heading">
 <tr>
  <td class="ilogin">EuroSecom</td>
  <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
 </tr>
 <tr>
  <td class="header">Hl·senie o vy˙ËtovanÌ dane - PrÌloha</td>
  <td>
   <a href="#" onclick="rozninewoc();" title="Pridaù zamestnanca do prÌlohy" class="addzam-btn">Pridaù os.Ë.</a>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="PoucVyplnenie();" title="PouËenie na vyplnenie" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacRocHlasenie2014priloha();" title="Zobraziù IV. a V.Ëasù Hl·senia v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>

<FORM name="newoc" method="post" action="#">
 <div id="newocdiv" class="addzam-bar" style="display:none;">&nbsp;&nbsp;Pridaù os.Ë.
  <input type="text" name="h_ocn" id="h_ocn" maxlength="4">
  <a href="#" onclick="zhasninewoc();" style="background-color:#F94748;">NIE</a>
  <a href="#" onclick="uloznewoc();" title="Pridaù zamestnanca do prÌlohy" style="background-color:#39f;">¡NO</a>
 </div>
</FORM>

<div id="content">
<div class="navbar">
<?php
$clas3="active";
$source="../mzdy/hlasenie_dane2014.php?drupoh=1&page=1&subor=0";
?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('../mzdy/hlasenie_daneoc2018.php?cislo_oc=9999&copern=101&drupoh=1&fmzdy=63&page=1&subor=0', '_self');" class="<?php echo $clas3; ?> toleft">prÌloha</a>
 <a href="#" onclick="window.open('../mzdy/hlasenie_dane2014.php?h_drp=&h_dap=&copern=10&drupoh=2&page=1&subor=0', '_blank');" class="<?php echo $clas3; ?> toright">prÌloha</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
</div>


<?php
//zoznam zamestnancov
if ( $copern == 101 OR $copern == 103 )
     {
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdrocnehlaseniedaneoc ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc >= 0 ORDER BY F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc";

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdrocnehlaseniedaneoc ".
" WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc >= 0 ORDER BY F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc";
$sql = mysql_query("$sqltt");

//celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
$r01asum=0; $dohosum=0; $r01bsum=0; $dnbhsum=0;
?>
<div class="wrap-zoznam">

<FORM name="formv1" method="post" action="hlasenie_daneoc2018.php?copern=102">
 <table class="zoznam">
 <thead>
 <tr>
  <th style="width:276px;">Zamestnanec<br>Os.Ë.<span style="font-weight:normal;">&nbsp;Priezvisko Meno / pomer</span></th>
  <th style="width:200px;">⁄hrn<br>prÌjmov / <span style="font-weight:normal;">z dohÙd</span></th>
  <th style="width:130px;">Preddavky</th>
  <th style="width:130px;">DaÚov˝<br>bonus</th>
  <th style="width:130px;">Zamestnan.<br>prÈmia</th>
  <th style="width:70px;">
   <span class="puntik">&nbsp;</span>&nbsp;&nbsp;<span style="color:#000;">¡NO RZ</span>
  </th>
 </tr>

<?php
   while ($i <= $cpol )
   {
if (@$zaznam=mysql_data_seek($sql,$i))
{
$riadok=mysql_fetch_object($sql);
$stripe="stripe-dark";
if ( $par == 1 ) { $stripe="stripe-light"; }

$r01asum=$r01asum+$riadok->r01a;
$dohosum=$dohosum+$riadok->doho;
$r01bsum=$r01bsum+$riadok->r01b;
$dnbhsum=$dnbhsum+$riadok->dnbh;
$ra1bsum=$ra1bsum+$riadok->ra1b;

$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $riadok->oc ";
$fir_vysledok = mysql_query($sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok);
$prie=$fir_riadok->prie; $meno=$fir_riadok->meno; $titl=$fir_riadok->titl; $pom=$fir_riadok->pom; $rodne=$fir_riadok->rdc." ".$fir_riadok->rdk;}

$rzclass="rzclass";
if ( $riadok->tz1 == 1 ) { $rzclass="rzclassano"; }
?>
 <tbody>
 <tr class="<?php echo $stripe; ?>">
  <td class="<?php echo $rzclass; ?>" style="text-align:left;">
   <a href="#" onclick="upravOC(<?php echo $riadok->oc;?>)" title="Upraviù prÌlohu">&nbsp;<strong><?php echo $riadok->oc;?></strong>
   <?php echo "$prie $meno / $pom"; ?>&nbsp;<img src="../obr/ikony/pencil_blue_icon.png"></a>
  </td>
  <td class="<?php echo $rzclass; ?>"><?php echo $riadok->r01a;?> / <span style="font-size:11px;"><?php echo $riadok->doho;?></span>&nbsp;

<img src="../obr/ikony/calculator_blue_icon.png" onclick="sumarRC(<?php echo $riadok->oc;?>);" title="NaËÌtaù a vymazaù vöetky ostatnÈ prÌlohy s rodn˝m ËÌslom <?php echo $rodne;?>">

</td>
  <td class="<?php echo $rzclass; ?>"><?php echo $riadok->r01b;?>&nbsp;</td>
  <td class="<?php echo $rzclass; ?>"><?php echo $riadok->dnbh;?>&nbsp;</td>
  <td class="<?php echo $rzclass; ?>"><?php echo $riadok->ra1b;?>&nbsp;</td>
  <td style="text-align:center;">
<?php if( $riadok->r01a == 0 ) { ?>
<img src="../obr/ikony/xmark_lred_icon.png" onclick="zmazOC(<?php echo $riadok->oc;?>)" title="Vymazaù riadok">
<?php                          } ?>
</td>
 </tr>
 </tbody>
<?php
}
$i = $i + 1;
if ( $par == 0 ) { $par=1; }
else { $par=0; }
   }
?>
 <tfoot>
 <tr>
  <td style="text-align:left;">&nbsp;SPOLU</td>
  <td><?php echo" $r01asum / $dohosum";?> &nbsp;</td>
  <td><?php echo $r01bsum;?>&nbsp;</td>
  <td><?php echo $dnbhsum;?>&nbsp;</td>
  <td><?php echo $ra1bsum;?>&nbsp;</td>
  <td></td>
 </tr>
 </tfoot>
 </table>
</FORM>
</div>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('../mzdy/hlasenie_daneoc2018.php?cislo_oc=9999&copern=101&drupoh=1&fmzdy=63&page=1&subor=0', '_self');" class="<?php echo $clas3; ?> toleft">prÌloha</a>
</div>
<?php
     }
//koniec zoznam
?>


<?php
//uprav prilohu
if ( $copern == 102 )
     {
?>
<FORM name="formv1" method="post" action="hlasenie_daneoc2018.php?copern=103">
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
<?php
$alertuloz="!!! Zmeny boli uloûenÈ !!!";
$akedisplay="none";
if ( $ulozenezmeny == 1 ) { $akedisplay="display"; }
?>
 <div id="alertdiv" class="alert-pocitam" style="display:<?php echo $akedisplay; ?>;"><?php echo "$alertuloz";?></div>

<?php
//cast IV. nevykonal RZ
if ( $tz1 != 1 ) {
?>
<img src="../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/hlasenie_dane/hlasenie_v14_str3.jpg"
     alt="III.Ëasù Hl·senia o vy˙ËtovanÌ dane pre rok 2014, 230kB" class="form-background">
<span class="text-echo" style="top:75px; left:457px;"><?php echo $fir_fdic; ?></span>
<select size="1" name="tz1" id="tz1" class="btn-rzstav" style="top:142px; left:557px;">
 <option value="0">&nbsp;Nevykonal&nbsp;&nbsp;</option>
 <option value="1">&nbsp;Vykonal</option>
</select>
<div class="leg-osc" style="top:174px;" title="OsobnÈ ËÌslo"><?php echo $oc; ?></div>

<!-- riadok 1 -->
<div class="input-echo" style="width:128px; top:183px; left:196px;"><?php echo $rodnec; ?></div>
<div class="input-echo" style="width:81px; top:183px; left:358px;"><?php echo $rodnek; ?></div>
<div class="input-echo" style="width:197px; top:222px; left:196px;"><?php echo $narodeny; ?></div>
<a href="#" onclick="upravRZ();" title="Upraviù roËnÈ z˙Ëtovanie zamestnanca"
   class="btn-rzuprav" style="top:221px; left:433px;">Upraviù RZ</a>
<!-- riadok 2 -->
<img src="../obr/ikony/pencil_blue_icon.png" onclick="UpravZamestnanca();"
     title="Upraviù ˙daje o zamestnancovi" class="btn-row-tool" style="top:261px; left:150px;">
<div class="input-echo" style="width:336px; top:260px; left:196px;"><?php echo $prie; ?></div>
<div class="input-echo" style="width:336px; top:300px; left:196px;"><?php echo $meno; ?></div>
<div class="input-echo" style="width:336px; top:339px; left:196px;"><?php echo $uli; ?></div>
<div class="input-echo" style="width:174px; top:378px; left:196px;"><?php echo $cdm; ?></div>
<div class="input-echo" style="width:105px; top:378px; left:426px;"><?php echo $psc; ?></div>
<div class="input-echo" style="width:336px; top:416px; left:196px;"><?php echo $mes; ?></div>
<div class="input-echo" style="width:243px; top:455px; left:196px;"><?php echo $zstat; ?></div>
<div class="input-echo" style="width:60px; top:455px; left:471px;"><?php echo $zstak; ?></div>
<!-- riadok 3 -->
<input type="text" name="r01a" id="r01a" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:493px; left:195px;"/>
<input type="text" name="doho" id="doho" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:531px; left:195px;"/>
<!-- riadok 4 -->
<input type="checkbox" name="mzc" value="1" style="top:582px; left:202px;"/>
<input type="checkbox" name="mz01" value="1" style="top:582px; left:238px;"/>
<input type="checkbox" name="mz02" value="1" style="top:582px; left:263px;"/>
<input type="checkbox" name="mz03" value="1" style="top:582px; left:289px;"/>
<input type="checkbox" name="mz04" value="1" style="top:582px; left:314px;"/>
<input type="checkbox" name="mz05" value="1" style="top:582px; left:339px;"/>
<input type="checkbox" name="mz06" value="1" style="top:582px; left:364px;"/>
<input type="checkbox" name="mz07" value="1" style="top:582px; left:390px;"/>
<input type="checkbox" name="mz08" value="1" style="top:582px; left:415px;"/>
<input type="checkbox" name="mz09" value="1" style="top:582px; left:440px;"/>
<input type="checkbox" name="mz10" value="1" style="top:582px; left:466px;"/>
<input type="checkbox" name="mz11" value="1" style="top:582px; left:492px;"/>
<input type="checkbox" name="mz12" value="1" style="top:582px; left:517px;"/>
<!-- riadok 5 -->
<input type="text" name="socp" id="socp" onkeyup="CiarkaNaBodku(this);" style="width:162px; top:610px; left:195px;"/>
<input type="text" name="zdrp" id="zdrp" onkeyup="CiarkaNaBodku(this);" style="width:162px; top:610px; left:374px;"/>
<!-- riadok 6 -->
<input type="text" name="r01b" id="r01b" onkeyup="CiarkaNaBodku(this);" style="width:221px; top:649px; left:195px;"/>
<!-- riadok 7 -->
<input type="text" name="dnbh" id="dnbh" onkeyup="CiarkaNaBodku(this);" style="width:174px; top:688px; left:195px;"/>
<input type="text" name="tz3" id="tz3" style="width:36px; top:688px; left:489px;"/>
<!-- riadok 8 -->
<input type="checkbox" name="pred" value="1" style="top:731px; left:277px;"/>
<input type="text" name="pdan" id="pdan" style="width:36px; top:727px; left:489px;"/>
<!-- riadok 9 -->
<input type="text" name="ddssum" id="ddssum" onkeyup="CiarkaNaBodku(this);" style="width:174px; top:769px; left:195px;"/>

<!-- inputy nepouzite v IV.casti = musia byt hidden -->
<input type="hidden" name="oc" id="oc" value="<?php echo $oc;?>"/>
<input type="hidden" name="nzdh" id="nzdh" value="<?php echo $nzdh;?>"/>
<input type="hidden" name="nzmh" id="nzmh" value="<?php echo $nzmh;?>"/>
<input type="hidden" name="ddsnzc" id="ddsnzc" value="<?php echo $ddsnzc;?>"/>
<input type="hidden" name="ra1b" id="ra1b" value="<?php echo $ra1b;?>"/>
<input type="hidden" name="zmpm" id="zmpm" value="<?php echo $zmpm;?>"/>
<input type="hidden" name="dnbm" id="dnbm" value="<?php echo $dnbm;?>"/>
<input type="hidden" name="rocz" id="rocz" value="<?php echo $rocz;?>"/>

<input type="hidden" name="prvypj" id="prvypj" value="<?php echo $prvypj;?>"/>
<input type="hidden" name="dds2nc" id="dds2nc" value="<?php echo $dds2nc;?>"/>
<?php            } ?>


<?php
//cast V. vykonal RZ
if ( $tz1 == 1 ) {
?>
<img src="../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/hlasenie_dane/hlasenie_v14_str4.jpg"
     alt="IV.Ëasù Hl·senia o vy˙ËtovanÌ dane pre rok 2014, 230kB" class="form-background">
<span class="text-echo" style="top:75px; left:457px;"><?php echo $fir_fdic; ?></span>
<select size="1" name="tz1" id="tz1" class="btn-rzstav" style="top:126px; left:683px;">
 <option value="0">&nbsp;Nevykonal&nbsp;&nbsp;</option>
 <option value="1">&nbsp;Vykonal</option>
</select>
<div class="leg-osc" style="top:159px;" title="OsobnÈ ËÌslo"><?php echo $oc; ?></div>
<a href="#" onclick="upravRZ();" title="Upraviù roËnÈ z˙Ëtovanie zamestnanca"
   class="btn-rzuprav" style="top:205px; left:433px;">Upraviù RZ</a>

<!-- riadok 1 -->
<div class="input-echo" style="width:128px; top:167px; left:196px;"><?php echo $rodnec; ?></div>
<div class="input-echo" style="width:81px; top:167px; left:358px;"><?php echo $rodnek; ?></div>
<div class="input-echo" style="width:197px; top:206px; left:196px;"><?php echo $narodeny; ?></div>
<!-- riadok 2 -->
<img src="../obr/ikony/pencil_blue_icon.png" onclick="UpravZamestnanca();"
     title="Upraviù ˙daje o zamestnancovi" class="btn-row-tool" style="top:246px; left:150px;">
<div class="input-echo" style="width:336px; top:245px; left:196px;"><?php echo $prie; ?></div>
<div class="input-echo" style="width:336px; top:284px; left:196px;"><?php echo $meno; ?></div>
<div class="input-echo" style="width:336px; top:323px; left:196px;"><?php echo $uli; ?></div>
<div class="input-echo" style="width:174px; top:362px; left:196px;"><?php echo $cdm; ?></div>
<div class="input-echo" style="width:105px; top:362px; left:426px;"><?php echo $psc; ?></div>
<div class="input-echo" style="width:336px; top:401px; left:196px;"><?php echo $mes; ?></div>
<div class="input-echo" style="width:243px; top:440px; left:196px;"><?php echo $zstat; ?></div>
<div class="input-echo" style="width:60px; top:440px; left:471px;"><?php echo $zstak; ?></div>
<!-- riadok 3 -->
<input type="text" name="r01a" id="r01a" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:477px; left:196px;"/>
<input type="text" name="doho" id="doho" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:515px; left:196px;"/>
<input type="text" name="prvypj" id="dprvypj" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:557px; left:196px;"/>
<!-- riadok 4 -->
<input type="text" name="socp" id="socp" onkeyup="CiarkaNaBodku(this);" style="width:162px; top:599px; left:196px;"/>
<input type="text" name="zdrp" id="zdrp" onkeyup="CiarkaNaBodku(this);" style="width:162px; top:599px; left:374px;"/>
<!-- riadok 5 -->
<input type="text" name="nzdh" id="nzdh" onkeyup="CiarkaNaBodku(this);" style="width:150px; top:639px; left:219px;"/>
<img src='../obr/ikony/download_blue_icon.png' onclick="nacitajRZ();"
     title="NaËÌtaù ˙daje z roËnÈho z˙Ëtovania" class="btn-row-tool" style="top:640px; left:385px;">
<!-- riadok 6 -->
<input type="text" name="r01b" id="r01b" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:677px; left:196px;"/>
<!-- riadok 7 -->
<input type="text" name="nzmh" id="nzmh" onkeyup="CiarkaNaBodku(this);" style="width:150px; top:717px; left:219px;"/>
<input type="text" name="tz3" id="tz3" style="width:36px; top:717px; left:500px;"/>
<!-- riadok 8 -->
<input type="text" name="ddsnzc" id="ddsnzc" onkeyup="CiarkaNaBodku(this);" style="width:150px; top:760px; left:219px;"/>
<!-- riadok 9 -->
<input type="text" name="dds2nc" id="dds2nc" onkeyup="CiarkaNaBodku(this);" style="width:127px; top:806px; left:242px;"/>
<!-- riadok 10 -->
<input type="text" name="ra1b" id="ra1b" onkeyup="CiarkaNaBodku(this);" style="width:127px; top:844px; left:242px;"/>
<input type="text" name="zmpm" id="zmpm" style="width:36px; top:844px; left:500px;"/>
<!-- riadok 11 -->
<input type="text" name="dnbh" id="dnbh" onkeyup="CiarkaNaBodku(this);" style="width:150px; top:883px; left:219px;"/>
<input type="text" name="dnbm" id="dnbm" style="width:58px; top:883px; left:478px;"/>
<!-- riadok 12 -->
<input type="text" name="rocz" id="rocz" onkeyup="CiarkaNaBodku(this);" style="width:266px; top:927px; left:196px;"/>

<!-- inputy nepouzite v V.casti = musia byt hidden -->
<input type="hidden" name="oc" id="oc" value="<?php echo $oc;?>"/>
<input type="hidden" name="mzc" value="<?php echo $mzc; ?>"/>
<input type="hidden" name="mz01" value="<?php echo $mz01; ?>"/>
<input type="hidden" name="mz02" value="<?php echo $mz02; ?>"/>
<input type="hidden" name="mz03" value="<?php echo $mz03; ?>"/>
<input type="hidden" name="mz04" value="<?php echo $mz04; ?>"/>
<input type="hidden" name="mz05" value="<?php echo $mz05; ?>"/>
<input type="hidden" name="mz06" value="<?php echo $mz06; ?>"/>
<input type="hidden" name="mz07" value="<?php echo $mz07; ?>"/>
<input type="hidden" name="mz08" value="<?php echo $mz08; ?>"/>
<input type="hidden" name="mz09" value="<?php echo $mz09; ?>"/>
<input type="hidden" name="mz10" value="<?php echo $mz10; ?>"/>
<input type="hidden" name="mz11" value="<?php echo $mz11; ?>"/>
<input type="hidden" name="mz12" value="<?php echo $mz12; ?>"/>
<input type="hidden" name="pred" value="<?php echo $pred; ?>"/>
<input type="hidden" name="pdan" id="pdan" value="<?php echo $pdan; ?>"/>
<input type="hidden" name="ddssum" id="ddssum" value="<?php echo $ddssum; ?>"/>
<?php            } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('../mzdy/hlasenie_daneoc2018.php?cislo_oc=9999&copern=101&drupoh=1&fmzdy=63&page=1&subor=0', '_self');" class="<?php echo $clas3; ?> toleft">prÌloha</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>

</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
     }
//koniec uprav prilohu
?>

<?php
$vsql = 'DROP TABLE F'.$kli_vxcf.'_treximaprac';
$vytvor = mysql_query("$vsql");
} while (false);
?>

</BODY>
</HTML>