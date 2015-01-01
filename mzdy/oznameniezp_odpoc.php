<!doctype html>
<HTML>
<?php
do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if (!isset($tis)) $tis = 0;
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) { $strana=1; }

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");

$cislo_oc = $_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//priezvisko,meno,titul FO
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";

$fir_vysledok = mysql_query($sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
if ( $fir_uctt03 == 999 )
{
$fnazov = $fir_riadok->dmeno." ".$fir_riadok->dprie." ".$fir_riadok->dtitl." ".$fir_riadok->dtitz;
$dadresa = $fir_riadok->duli." "." ".$fir_riadok->dcdm." ".$fir_riadok->dmes;
}
if ( $fir_uctt03 != 999 )
{
$fadresa = $fir_fnaz." ".$fir_fuli." ".$fir_fcdm." ".$fir_fmes;
$fnazov = $fir_fnaz;
}

//znovu nacitaj
if ( $copern == 26 )
     {
$sqtoz = "DELETE FROM F$kli_vxcf"."_oznamzpodpoc WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");
$copern=20;
$subor=1;
     }
//koniec znovu nacitaj

//zapis upravene udaje
if ( $copern == 23 )
     {
$datum = strip_tags($_REQUEST['datum']);
$datum_sql=SqlDatum($datum);
$datpre = strip_tags($_REQUEST['datpre']);
$datpre_sql=SqlDatum($datpre);

$zmtx1 = strip_tags($_REQUEST['zmtx1']);
$zmdz1_sql=SqlDatum($_REQUEST['zmdz1']);
$zmdo1_sql=SqlDatum($_REQUEST['zmdo1']);
$zmtx2 = strip_tags($_REQUEST['zmtx2']);
$zmdz2_sql=SqlDatum($_REQUEST['zmdz2']);
$zmdo2_sql=SqlDatum($_REQUEST['zmdo2']);
$zmtx3 = strip_tags($_REQUEST['zmtx3']);
$zmdz3_sql=SqlDatum($_REQUEST['zmdz3']);
$zmdo3_sql=SqlDatum($_REQUEST['zmdo3']);
$zmtx4 = strip_tags($_REQUEST['zmtx4']);
$zmdz4_sql=SqlDatum($_REQUEST['zmdz4']);
$zmdo4_sql=SqlDatum($_REQUEST['zmdo4']);
$zmtx5 = strip_tags($_REQUEST['zmtx5']);
$zmdz5_sql=SqlDatum($_REQUEST['zmdz5']);
$zmdo5_sql=SqlDatum($_REQUEST['zmdo5']);
$zmtx6 = strip_tags($_REQUEST['zmtx6']);
$zmdz6_sql=SqlDatum($_REQUEST['zmdz6']);
$zmdo6_sql=SqlDatum($_REQUEST['zmdo6']);

$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_oznamzpodpoc SET ".
" zmtx1='$zmtx1', zmdz1='$zmdz1_sql', zmdo1='$zmdo1_sql', ".
" zmtx2='$zmtx2', zmdz2='$zmdz2_sql', zmdo2='$zmdo2_sql', ".
" zmtx3='$zmtx3', zmdz3='$zmdz3_sql', zmdo3='$zmdo3_sql', ".
" zmtx4='$zmtx4', zmdz4='$zmdz4_sql', zmdo4='$zmdo4_sql', ".
" zmtx5='$zmtx5', zmdz5='$zmdz5_sql', zmdo5='$zmdo5_sql', ".
" zmtx6='$zmtx6', zmdz6='$zmdz6_sql', zmdo6='$zmdo6_sql', ".
" datum='$datum_sql', datpre='$datpre_sql' ".
" WHERE oc = $cislo_oc";
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");  

$copern=20;
if (!$upravene):
?>
 <script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ" ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }
//koniec zapisu upravenych udajov


//prac.subor a subor vytvorenych potvrdeni
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   datum        DATE,
   pozn         VARCHAR(80),
   str2         TEXT,
   konx         INT(4) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_oznamzpodpoc'.$sqlt;
$vytvor = mysql_query("$vsql");


//zmeny pre rok 2015
$sql = "SELECT zmdo6 FROM F".$kli_vxcf."_oznamzpodpoc";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD new2015 DECIMAL(2,0) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD datpre DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmtx1 VARCHAR(80) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmdz1 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmdo1 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmtx2 VARCHAR(80) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmdz2 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmdo2 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmtx3 VARCHAR(80) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmdz3 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmdo3 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmtx4 VARCHAR(80) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmdz4 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmdo4 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmtx5 VARCHAR(80) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmdz5 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmdo5 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmtx6 VARCHAR(80) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmdz6 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_oznamzpodpoc ADD zmdo6 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");

}
$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvypl$kli_uzid SELECT * FROM F".$kli_vxcf."_oznamzpodpoc WHERE oc < 0 ";
$vytvor = mysql_query("$vsql");
$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvyplx$kli_uzid SELECT * FROM F".$kli_vxcf."_oznamzpodpoc WHERE oc < 0 ";
$vytvor = mysql_query("$vsql");

$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_oznamzpodpoc WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $jepotvrd=1;
  }
if ( $jepotvrd == 0 ) $subor=1;

//pre potvrdenie vytvor pracovny subor
if ( $subor == 1 )
{
$pracovx=$fir_fnaz." ".$fir_fuli." ".$fir_fcdm.", ".$fir_fmes.", ".$fir_fpsc;

//uloz do vyhlasenia
$sqtoz = "DELETE FROM F$kli_vxcf"."_oznamzpodpoc WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_oznamzpodpoc ( oc ) VALUES ( '$cislo_oc' ) ";
$dsql = mysql_query("$dsqlt");
}
//koniec pracovneho suboru pre potvrdenie 

/////////////NACITANIE UDAJOV Z PARAMETROV
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  }

//nacitaj udaje pre upravu
if ( $copern == 20 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_oznamzpodpoc".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_oznamzpodpoc.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_oznamzpodpoc.oc = $cislo_oc ORDER BY konx,prie,meno";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
//$zamestnanec = $fir_riadok->oc." ".$fir_riadok->titl." ".$fir_riadok->meno." ".$fir_riadok->prie;
$prie = $fir_riadok->prie;
$meno = $fir_riadok->meno;
$rodne = $fir_riadok->rdc."/".$fir_riadok->rdk;
$dar=SkDatum($fir_riadok->dar);
if ( $rodne == "0/" ) { $rodne="$dar"; }
$ptitl = $fir_riadok->titl;
$rdstav = $fir_riadok->rdstav;
$uli = $fir_riadok->zuli;
$cdm = $fir_riadok->zcdm;
$psc = $fir_riadok->zpsc;
$mes = $fir_riadok->zmes;
$zamestnavatel = $fir_fnaz.", ".$fir_fuli." ".$fir_fcdm.", ".$fir_fmes;
$datum_sk = SkDatum($fir_riadok->datum);
$datpre_sk = SkDatum($fir_riadok->datpre);
$zmtx1 = $fir_riadok->zmtx1;
$zmdz1_sk = SkDatum($fir_riadok->zmdz1);
$zmdo1_sk = SkDatum($fir_riadok->zmdo1);
$zmtx2 = $fir_riadok->zmtx2;
$zmdz2_sk = SkDatum($fir_riadok->zmdz2);
$zmdo2_sk = SkDatum($fir_riadok->zmdo2);
$zmtx3 = $fir_riadok->zmtx3;
$zmdz3_sk = SkDatum($fir_riadok->zmdz3);
$zmdo3_sk = SkDatum($fir_riadok->zmdo3);
$zmtx4 = $fir_riadok->zmtx4;
$zmdz4_sk = SkDatum($fir_riadok->zmdz4);
$zmdo4_sk = SkDatum($fir_riadok->zmdo4);
$zmtx5 = $fir_riadok->zmtx5;
$zmdz5_sk = SkDatum($fir_riadok->zmdz5);
$zmdo5_sk = SkDatum($fir_riadok->zmdo5);
$zmtx6 = $fir_riadok->zmtx6;
$zmdz6_sk = SkDatum($fir_riadok->zmdz6);
$zmdo6_sk = SkDatum($fir_riadok->zmdo6);


mysql_free_result($fir_vysledok);

//stat z udajov o zamestn.
$zstat="Slovensko"; $zstak="703";
$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_mzdtextmzd WHERE invt = $cislo_oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zstat=$riaddok->zstat;
  }
if ( $zstat == '' ) { $zstat="Slovensko"; }
     }
//koniec nacitania

//titulza z udajov o zamestn.
$ztitz=" ";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $cislo_oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ztitz=$riaddok->ztitz;
  }

//osobne cislo prepinanie
$prepoc=1;
$novy=0;
if ( $novy == 0 )
{
$prev_oc=$cislo_oc-1;
$next_oc=$cislo_oc+1;
if ( $prev_oc == 0 ) $prev_oc=1;
if ( $next_oc > 9999 ) $next_oc=9999;

$nasieloc=0;
$i=0;
while ($i <= 9999 AND $nasieloc == 0 )
{
$sqlico = mysql_query("SELECT oc FROM F$kli_vxcf"."_mzdkun WHERE oc=$prev_oc ");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if ( $nasieloc == 0 ) $prev_oc=$prev_oc-1;
if ( $prev_oc <= 1 ) $nasieloc=1;
}
$i=$i+1;

$maxoc=9999;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdkun ORDER BY oc DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $maxoc=1*$riaddok->oc;
  }
if ( $next_oc > $maxoc ) $next_oc=$maxoc;

$nasieloc=0;
$i=0;
while ($i <= 9999 AND $nasieloc == 0 AND $next_oc <= $maxoc )
{
$sqlico = mysql_query("SELECT oc FROM F$kli_vxcf"."_mzdkun WHERE oc=$next_oc ");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if ( $nasieloc == 0 ) $next_oc=$next_oc+1;
if ( $next_oc >= 9999 ) $nasieloc=1;
}
$i=$i+1;
if ( $prev_oc == 0 ) $prev_oc=1;
if ( $next_oc > 9999 ) $next_oc=9999;
}
//koniec novy=0
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Odpoèítate¾ná položka ZP</title>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height-20;
var sirkawic = screen.width-10;

<?php
//uprava sadzby
  if ( $copern == 20 )
  { 
?>
  function ObnovUI()
  {
   document.formv1.datum.value = '<?php echo "$datum_sk";?>';
   document.formv1.datpre.value = '<?php echo "$datpre_sk";?>';
   document.formv1.zmtx1.value = '<?php echo "$zmtx1";?>';
   document.formv1.zmdz1.value = '<?php echo "$zmdz1_sk";?>';
   document.formv1.zmdo1.value = '<?php echo "$zmdo1_sk";?>';
   document.formv1.zmtx2.value = '<?php echo "$zmtx2";?>';
   document.formv1.zmdz2.value = '<?php echo "$zmdz2_sk";?>';
   document.formv1.zmdo2.value = '<?php echo "$zmdo2_sk";?>';
   document.formv1.zmtx3.value = '<?php echo "$zmtx3";?>';
   document.formv1.zmdz3.value = '<?php echo "$zmdz3_sk";?>';
   document.formv1.zmdo3.value = '<?php echo "$zmdo3_sk";?>';
   document.formv1.zmtx4.value = '<?php echo "$zmtx4";?>';
   document.formv1.zmdz4.value = '<?php echo "$zmdz4_sk";?>';
   document.formv1.zmdo4.value = '<?php echo "$zmdo4_sk";?>';
   document.formv1.zmtx5.value = '<?php echo "$zmtx5";?>';
   document.formv1.zmdz5.value = '<?php echo "$zmdz5_sk";?>';
   document.formv1.zmdo5.value = '<?php echo "$zmdo5_sk";?>';
   document.formv1.zmtx6.value = '<?php echo "$zmtx6";?>';
   document.formv1.zmdz6.value = '<?php echo "$zmdz6_sk";?>';
   document.formv1.zmdo6.value = '<?php echo "$zmdo6_sk";?>';
  }
<?php
//koniec uprava
  }
?>

<?php if ( $copern != 20 ) { ?>
  function ObnovUI()
  {
  }
<?php                      } ?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function prevOC()
  {
   window.open('oznameniezp_odpoc.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $prev_oc;?>', '_self');
  }
  function nextOC()
  {
   window.open('oznameniezp_odpoc.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $next_oc;?>', '_self');
  }
  function TlacVyhlNCZD()
  {
   window.open('../mzdy/oznameniezp_odpoc.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=1', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMinRok() //dopyt, asi nemá zmysel ale narok bude
  {

  }
  function UpravZamestnanca()
  {
   window.open('zamestnanci.php?sys=<?php echo $sys; ?>&copern=8&page=1&cislo_oc=<?php echo $cislo_oc;?>&h_oc=<?php echo $cislo_oc;?>', '_blank','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes');
  }
</script>
</HEAD>
<BODY id="white" onload="ObnovUI();">
<?php
//uprav udaje
if ( $copern == 20 )
     {
?>
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">Oznámenie nároku na odpoèítate¾nú položku ZP - <span class="subheader"><?php echo "$cislo_oc $meno $prie ";?></span>
<?php if ( $novy == 0 ) { ?>
    <img src="../obr/prev.png" onclick="prevOC();" title="Os.è. <?php echo $prev_oc; ?>" class="navoc-icon">
    <img src="../obr/next.png" onclick="nextOC();" title="Os.è. <?php echo $next_oc; ?>" class="navoc-icon">
<?php                   } ?>
   </td>
   <td>
    <div class="bar-btn-form-tool">
<!-- dopyt, spravi pouèenie, naèítanie asi nemá zmysel -->
     <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajMinRok();" title="Naèíta údaje z minulého roka" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVyhlNCZD();" title="Zobrazi v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="oznameniezp_odpoc.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>">
<div class="navbar">
 <INPUT type="submit" id="uloz" name="uloz" value="Uloži zmeny" class="btn-top-formsave" style="top:4px;">
</div>
<img src="../dokumenty/zdravpoist/oznamzp_odpoc_form.jpg"
     alt="tlaèivo Oznámenie nároku na odpoèítate¾nú položku ZP 348kB"
     class="form-background">

<!-- ZAMESTNANEC -->
<img src="../obr/ikony/pencil_blue_icon.png" onclick="UpravZamestnanca();"
     title="Upravi údaje o zamestnancovi" class="btn-row-tool"
     style="top:145px; left:570px; width:16px; height:16px;">
<span class="text-echo" style="top:202px; left:67px;"><?php echo $prie; ?></span>
<span class="text-echo" style="top:202px; left:360px;"><?php echo $meno; ?></span>
<span class="text-echo" style="top:202px; left:555px;"><?php echo $rodne; ?></span>
<span class="text-echo" style="top:233px; left:175px;"><?php echo $ptitl; ?></span>
<span class="text-echo" style="top:233px; left:455px;"><?php echo $ztitz; ?></span>
<span class="text-echo" style="top:285px; left:104px;"><?php echo $uli; ?></span>
<span class="text-echo" style="top:285px; left:587px;"><?php echo $cdm; ?></span>
<span class="text-echo" style="top:285px; left:755px;"><?php echo $psc; ?></span>
<span class="text-echo" style="top:319px; left:104px;"><?php echo $mes; ?></span>
<span class="text-echo" style="top:319px; left:584px;"><?php echo $zstat; ?></span>
<span class="text-echo" style="top:370px; left:67px;"><?php echo $zamestnavatel; ?></span>

<!-- DATUMY -->
<input type="text" name="datum" id="datum" onkeyup="CiarkaNaBodku(this);" style="width:90px; top:698px; left:95px;"/>
<input type="text" name="datpre" id="datpre" onkeyup="CiarkaNaBodku(this);" style="width:90px; top:768px; left:145px;"/>

<!-- ZMENY -->
<input type="text" name="zmtx1" id="zmtx1" style="width:317px; top:878px; left:60px;"/>
<input type="text" name="zmdz1" id="zmdz1" onkeyup="CiarkaNaBodku(this);" style="width:135px; top:878px; left:389px;"/>
<input type="text" name="zmdo1" id="zmdo1" onkeyup="CiarkaNaBodku(this);" style="width:135px; top:878px; left:536px;"/>
<input type="text" name="zmtx2" id="zmtx2" style="width:317px; top:912px; left:60px;"/>
<input type="text" name="zmdz2" id="zmdz2" onkeyup="CiarkaNaBodku(this);" style="width:135px; top:912px; left:389px;"/>
<input type="text" name="zmdo2" id="zmdo2" onkeyup="CiarkaNaBodku(this);" style="width:135px; top:912px; left:536px;"/>
<input type="text" name="zmtx3" id="zmtx3" style="width:317px; top:946px; left:60px;"/>
<input type="text" name="zmdz3" id="zmdz3" onkeyup="CiarkaNaBodku(this);" style="width:135px; top:946px; left:389px;"/>
<input type="text" name="zmdo3" id="zmdo3" onkeyup="CiarkaNaBodku(this);" style="width:135px; top:946px; left:536px;"/>
<input type="text" name="zmtx4" id="zmtx4" style="width:317px; top:979px; left:60px;"/>
<input type="text" name="zmdz4" id="zmdz4" onkeyup="CiarkaNaBodku(this);" style="width:135px; top:979px; left:389px;"/>
<input type="text" name="zmdo4" id="zmdo4" onkeyup="CiarkaNaBodku(this);" style="width:135px; top:979px; left:536px;"/>
<input type="text" name="zmtx5" id="zmtx5" style="width:317px; top:1013px; left:60px;"/>
<input type="text" name="zmdz5" id="zmdz5" onkeyup="CiarkaNaBodku(this);" style="width:135px; top:1013px; left:389px;"/>
<input type="text" name="zmdo5" id="zmdo5" onkeyup="CiarkaNaBodku(this);" style="width:135px; top:1013px; left:536px;"/>
<input type="text" name="zmtx6" id="zmtx6" style="width:317px; top:1046px; left:60px;"/>
<input type="text" name="zmdz6" id="zmdz6" onkeyup="CiarkaNaBodku(this);" style="width:135px; top:1046px; left:389px;"/>
<input type="text" name="zmdo6" id="zmdo6" onkeyup="CiarkaNaBodku(this);" style="width:135px; top:1046px; left:536px;"/>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloži zmeny" class="btn-bottom-formsave">
</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
     }
//koniec uprav
?>


<?php
//pdf
if ( $copern == 10 )
{
//urob sucet
$sqtoz = "UPDATE F$kli_vxcf"."_oznamzpodpoc".
" SET ".
" vyldni1=TO_DAYS(vyldo1)-TO_DAYS(vylod1)+1, vyldni2=TO_DAYS(vyldo2)-TO_DAYS(vylod2)+1, vyldni3=TO_DAYS(vyldo3)-TO_DAYS(vylod3)+1, ".
" vyldni4=TO_DAYS(vyldo4)-TO_DAYS(vylod4)+1, vyldni5=TO_DAYS(vyldo5)-TO_DAYS(vylod5)+1, ".
" vyl2dni1=TO_DAYS(vyl2do1)-TO_DAYS(vyl2od1)+1, vyl2dni2=TO_DAYS(vyl2do2)-TO_DAYS(vyl2od2)+1, vyl2dni3=TO_DAYS(vyl2do3)-TO_DAYS(vyl2od3)+1, ".
" vyl2dni4=TO_DAYS(vyl2do4)-TO_DAYS(vyl2od4)+1, vyl2dni5=TO_DAYS(vyl2do5)-TO_DAYS(vyl2od5)+1, ".
" vyl3dni1=TO_DAYS(vyl3do1)-TO_DAYS(vyl3od1)+1, vyl3dni2=TO_DAYS(vyl3do2)-TO_DAYS(vyl3od2)+1, vyl3dni3=TO_DAYS(vyl3do3)-TO_DAYS(vyl3od3)+1, ".
" vyl3dni4=TO_DAYS(vyl3do4)-TO_DAYS(vyl3od4)+1, vyl3dni5=TO_DAYS(vyl3do5)-TO_DAYS(vyl3od5)+1 ".
" WHERE oc >= 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

if ( File_Exists("../tmp/vyhlasenie.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/vyhlasenie.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_oznamzpodpoc".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_oznamzpodpoc.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_oznamzpodpoc.oc = $cislo_oc ORDER BY konx,prie,meno";
//echo $sqltt;
//exit;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$hlavicka=mysql_fetch_object($sql);

  $ozam_np = $hlavicka->ozam_np;
  $pole = explode(".", $ozam_np);
  $Cozam_np = $pole[0];
  $Dozam_np = substr($pole[1],0,1);

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $strana == 1 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(15);
if ( File_Exists('../dokumenty/zdravpoist/oznamzp_odpoc.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/zdravpoist/oznamzp_odpoc.jpg',0,0,210,297);
}

$zstat="Slovensko"; $zstak="703";
$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_mzdtextmzd WHERE invt = $cislo_oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zstat=$riaddok->zstat;
  $zstak=$riaddok->zstak;
  }
if ( $zstat == '' ) { $zstat="Slovensko"; }

//zamestnanec
$pdf->Cell(190,52," ","$rmc1",1,"L");
$pdf->Cell(6,4," ","$rmc1",0,"L");$pdf->Cell(63,6,"$hlavicka->prie","$rmc",0,"L");
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(41,6,"$hlavicka->meno","$rmc",0,"L");
$dar=SkDatum($hlavicka->dar);
$tlacrd="$hlavicka->rdc / $hlavicka->rdk";
if ( $tlacrd == "0 / " ) { $tlacrd="$dar"; }
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(60,6,"$tlacrd","$rmc",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(190,0," ","$rmc1",1,"L");
$pdf->Cell(31,4," ","$rmc1",0,"L");$pdf->Cell(38,4,"$hlavicka->titl","$rmc",0,"L");
$pdf->Cell(24,4," ","$rmc1",0,"L");$pdf->Cell(19,4,"$ztitz","$rmc",1,"L");
$pdf->Cell(190,4," ","$rmc1",1,"L");
$pdf->Cell(14,5," ","$rmc1",0,"L");$pdf->Cell(98,5,"$hlavicka->zuli","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"L");$pdf->Cell(29,5,"$hlavicka->zcdm","$rmc",0,"L");
$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(32,5,"$hlavicka->zpsc","$rmc",1,"L");
$pdf->Cell(14,5," ","$rmc1",0,"L");$pdf->Cell(98,3,"$hlavicka->zmes","$rmc",0,"L");
$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(70,3,"$zstat","$rmc",1,"L");
$pdf->SetFont('arial','',9);

//zamestnavatel
$pdf->Cell(190,4," ","$rmc1",1,"L");
$pdf->Cell(6,5," ","$rmc1",0,"L");$pdf->Cell(184,6,"$fir_fnaz, $fir_fuli $fir_fcdm $fir_fmes","$rmc",1,"L");

//uplatnujem - datumy
$pdf->Cell(190,69," ","$rmc1",1,"L");
$datum=SkDatum($hlavicka->datum);
if ( $datum == '00.00.0000' ) $datum="";
$pdf->Cell(11,3," ","$rmc1",0,"L");$pdf->Cell(54,6,"$datum","$rmc",1,"C");
$pdf->Cell(190,10," ","$rmc1",1,"L");
$datpre=SkDatum($hlavicka->datpre);
if ( $datpre == '00.00.0000' ) $datpre="";
$pdf->Cell(23,3," ","$rmc1",0,"L");$pdf->Cell(43,6,"$datpre","$rmc",1,"C");

//zmeny
$pdf->Cell(190,20," ","$rmc1",1,"L");
$zmdz1=SkDatum($hlavicka->zmdz1); if ( $zmdz1 == '00.00.0000' ) $zmdz1="";
$zmdo1=SkDatum($hlavicka->zmdo1); if ( $zmdo1 == '00.00.0000' ) $zmdo1="";
$pdf->Cell(5,5," ","$rmc1",0,"L");$pdf->Cell(72,5,"$hlavicka->zmtx1","$rmc",0,"L");
$pdf->Cell(33,5,"$zmdz1","$rmc",0,"C");$pdf->Cell(32,5,"$zmdo1","$rmc",1,"C");
$pdf->Cell(190,0," ","$rmc1",1,"L");
$zmdz2=SkDatum($hlavicka->zmdz2); if ( $zmdz2 == '00.00.0000' ) $zmdz2="";
$zmdo2=SkDatum($hlavicka->zmdo2); if ( $zmdo2 == '00.00.0000' ) $zmdo2="";
$pdf->Cell(5,5," ","$rmc1",0,"L");$pdf->Cell(72,5,"$hlavicka->zmtx2","$rmc",0,"L");
$pdf->Cell(33,5,"$zmdz2","$rmc",0,"C");$pdf->Cell(32,5,"$zmdo2","$rmc",1,"C");
$pdf->Cell(190,0," ","$rmc1",1,"L");
$zmdz3=SkDatum($hlavicka->zmdz3); if ( $zmdz3 == '00.00.0000' ) $zmdz3="";
$zmdo3=SkDatum($hlavicka->zmdo3); if ( $zmdo3 == '00.00.0000' ) $zmdo3="";
$pdf->Cell(5,5," ","$rmc1",0,"L");$pdf->Cell(72,5,"$hlavicka->zmtx3","$rmc",0,"L");
$pdf->Cell(33,5,"$zmdz3","$rmc",0,"C");$pdf->Cell(32,5,"$zmdo3","$rmc",1,"C");
$pdf->Cell(190,0," ","$rmc1",1,"L");
$zmdz4=SkDatum($hlavicka->zmdz4); if ( $zmdz4 == '00.00.0000' ) $zmdz4="";
$zmdo4=SkDatum($hlavicka->zmdo4); if ( $zmdo4 == '00.00.0000' ) $zmdo4="";
$pdf->Cell(5,5," ","$rmc1",0,"L");$pdf->Cell(72,4,"$hlavicka->zmtx4","$rmc",0,"L");
$pdf->Cell(33,4,"$zmdz4","$rmc",0,"C");$pdf->Cell(32,4,"$zmdo4","$rmc",1,"C");
$pdf->Cell(190,0," ","$rmc1",1,"L");
$zmdz5=SkDatum($hlavicka->zmdz5); if ( $zmdz5 == '00.00.0000' ) $zmdz5="";
$zmdo5=SkDatum($hlavicka->zmdo5); if ( $zmdo5 == '00.00.0000' ) $zmdo5="";
$pdf->Cell(5,5," ","$rmc1",0,"L");$pdf->Cell(72,6,"$hlavicka->zmtx5","$rmc",0,"L");
$pdf->Cell(33,6,"$zmdz5","$rmc",0,"C");$pdf->Cell(32,6,"$zmdo5","$rmc",1,"C");
$pdf->Cell(190,0," ","$rmc1",1,"L");
$zmdz6=SkDatum($hlavicka->zmdz6); if ( $zmdz6 == '00.00.0000' ) $zmdz6="";
$zmdo6=SkDatum($hlavicka->zmdo6); if ( $zmdo6 == '00.00.0000' ) $zmdo6="";
$pdf->Cell(5,5," ","$rmc1",0,"L");$pdf->Cell(72,5,"$hlavicka->zmtx6","$rmc",0,"L");
$pdf->Cell(33,5,"$zmdz6","$rmc",0,"C");$pdf->Cell(32,5,"$zmdo6","$rmc",1,"C");
                    } //koniec strany
  }
$i = $i + 1;
  }
$pdf->Output("../tmp/vyhlasenie.$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/vyhlasenie.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
}
//koniec pdf
?>

<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
$cislista = include("mzd_lista_norm.php");
} while (false);
?>
</BODY>
</HTML>