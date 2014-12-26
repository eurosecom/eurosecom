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
$fort = $_REQUEST['fort'];
if (!isset($fort)) $fort = 1;
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) { $strana=9999; }

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
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

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



// znovu nacitaj
if ( $copern == 26 )
     {
$sqtoz = "DELETE FROM F$kli_vxcf"."_oznamzpodpoc WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");
$copern=20;
$subor=1;
     }
//koniec znovu nacitaj

// zapis upravene udaje
if ( $copern == 23 )
     {
$datum = strip_tags($_REQUEST['datum']);
$datum_sql=SqlDatum($datum);
$datpre = strip_tags($_REQUEST['datpre']);
$datpre_sql=SqlDatum($datpre);

$zmtx1 = strip_tags($_REQUEST['zmtx1']);
$zmdz1_sql=SqlDatum($_REQUEST['zmdz1']);
$zmdo1_sql=SqlDatum($_REQUEST['zmdo1']);


$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_oznamzpodpoc SET ".
" zmtx1='$zmtx1', zmdz1='$zmdz1_sql', zmdo1='$zmdo1_sql', ".
" datum='$datum_sql', datpre='$datpre_sql' ".
" WHERE oc = $cislo_oc";
echo $uprtxt;
$upravene = mysql_query("$uprtxt");  

$copern=20;
if (!$upravene):
?>
 <script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN…" ) </script>
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
<title>EuroSecom - Ozn·menie zamestnanca na uplatnenie n·roku na odpoËÌtateæn˙ poloûku ZP</title>

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
  function ZnovuPotvrdenie()
  {
   window.open('../mzdy/oznameniezp_odpoc.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=1', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function TlacVyhlNCZD()
  {
   window.open('../mzdy/oznameniezp_odpoc.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=1', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMinRok()
  {
   window.open('../mzdy/oznameniezp_odpoc.php?cislo_oc=<?php echo $cislo_oc;?>&copern=1055&drupoh=1&page=1&subor=1', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
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
   <td class="header">Ozn·menie n·roku na odpoËÌtateæn˙ poloûku ZP - <span class="subheader"><?php echo "$cislo_oc $meno $prie ";?></span>
<?php if ( $novy == 0 ) { ?>
    <img src="../obr/prev.png" onclick="prevOC();" title="Os.Ë. <?php echo $prev_oc; ?>" class="navoc-icon">
    <img src="../obr/next.png" onclick="nextOC();" title="Os.Ë. <?php echo $next_oc; ?>" class="navoc-icon">
<?php                   } ?>
   </td>
   <td>
    <div class="bar-btn-form-tool">
<!-- dopyt, spraviù pouËenie, zatiaæ nem·m podklad -->
     <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajMinRok();" title="NaËÌtaù ˙daje z minulÈho roka" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVyhlNCZD();" title="Zobraziù v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="oznameniezp_odpoc.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>">
<div class="navbar">
<?php
$clas1="active";
$source="../mzdy/oznameniezp_odpoc.php?cislo_oc=".$cislo_oc."&drupoh=1&page=1&subor=0";
?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>

<img src="../dokumenty/zdravpoist/oznamzp_odpoc.jpg" alt="../dokumenty/zdravpoist/oznamzp_odpoc.jpg"" class="form-background">

<!-- ZAMESTNANEC -->
 <img src="../obr/ikony/pencil_blue_icon.png" onclick="UpravZamestnanca();" title="Upraviù ˙daje o zamestnancovi" class="btn-row-tool" style="top:247px; left:330px; width:18px; height:18px;">
<input type="text" name="prie" id="prie" value="<?php echo $prie; ?>" disabled="disabled" class="nofill" style="width:277px; top:304px; left:116px;"/>
<input type="text" name="meno" id="meno" value="<?php echo $meno; ?>" disabled="disabled" class="nofill" style="width:166px; top:304px; left:405px;"/>
<input type="text" name="rodne" id="rodne" value="<?php echo $rodne; ?>" disabled="disabled" class="nofill" style="width:110px; top:304px; left:590px;"/>
<input type="text" name="ptitl" id="ptitl" value="<?php echo $ptitl; ?>" disabled="disabled" class="nofill" style="width:96px; top:339px; left:230px;"/>
<input type="text" name="ztitz" id="ztitz" value="<?php echo $ztitz; ?>" disabled="disabled" class="nofill" style="width:106px; top:339px; left:465px;"/>

<input type="text" name="uli" id="uli" value="<?php echo $uli; ?>" disabled="disabled" class="nofill" style="width:200px; top:392px; left:158px;"/>
<input type="text" name="cdm" id="cdm" value="<?php echo $cdm; ?>" disabled="disabled" class="nofill" style="width:112px; top:392px; left:536px;"/>
<input type="text" name="psc" id="psc" value="<?php echo $psc; ?>" disabled="disabled" class="nofill" style="width:60px; top:392px; left:700px;"/>
<input type="text" name="mes" id="mes" value="<?php echo $mes; ?>" disabled="disabled" class="nofill" style="width:323px; top:428px; left:158px;"/>
<input type="text" name="zstat" id="zstat" value="<?php echo $zstat; ?>" disabled="disabled" class="nofill" style="width:200px; top:428px; left:530px;"/>
<input type="text" name="zamestnavatel" id="zamestnavatel" value="<?php echo $zamestnavatel; ?>" disabled="disabled" class="nofill" style="width:724px; top:482px; left:116px;"/>

<!-- DATUMY -->
<input type="text" name="datum" id="datum" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:800px; left:140px;"/>
<input type="text" name="datpre" id="datpre" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:900px; left:150px;"/>

<!-- ZMENY -->
<input type="text" name="zmtx1" id="zmtx1" style="width:300px; top:1000px; left:120px;"/>
<input type="text" name="zmdz1" id="zmdz1" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1000px; left:480px;"/>
<input type="text" name="zmdo1" id="zmdo1" style="width:100px; top:1000px; left:620px;"/>

 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">

</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
     }
//koniec uprav
?>

<?php
/////////////////////////////////////////////////VYTLAC VYHLASENIE
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

if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(15);
if ( File_Exists('../dokumenty/zdravpoist/oznamzp_odpoc.jpg') AND $i == 0 )
{
if ( $fort == 1 ) { $pdf->Image('../dokumenty/zdravpoist/oznamzp_odpoc.jpg',0,0,210,297); }
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
$pdf->Cell(190,59,"                          ","$rmc1",1,"L");
$pdf->Cell(18,4," ","$rmc1",0,"L");$pdf->Cell(63,6,"$hlavicka->prie","$rmc",0,"L");
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(38,6,"$hlavicka->meno","$rmc",0,"L");
$dar=SkDatum($hlavicka->dar);
$tlacrd="$hlavicka->rdc / $hlavicka->rdk";
if ( $tlacrd == "0 / " ) { $tlacrd="$dar"; }
$pdf->Cell(24,4," ","$rmc1",0,"L");$pdf->Cell(34,6,"$tlacrd","$rmc",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(190,1,"                          ","$rmc1",1,"L");
$pdf->Cell(42,4," ","$rmc1",0,"L");$pdf->Cell(25,5,"$hlavicka->titl","$rmc",0,"L");$pdf->Cell(27,4," ","$rmc1",0,"L");$pdf->Cell(27,5,"$ztitz","$rmc",0,"L");
$pdf->Cell(20,4," ","$rmc1",0,"L");
if ( $hlavicka->rdstav == 0 ) { $pdf->Cell(38,5,"slobodn˝/slobodn·","$rmc",1,"L"); }
if ( $hlavicka->rdstav == 1 ) { $pdf->Cell(38,5,"ûenat˝/vydat·","$rmc",1,"L"); }
if ( $hlavicka->rdstav == 2 ) { $pdf->Cell(38,5,"vdovec/vdova","$rmc",1,"L"); }
if ( $hlavicka->rdstav == 3 ) { $pdf->Cell(38,5,"rozveden˝/rozveden·","$rmc",1,"L"); }
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$pdf->Cell(26,5," ","$rmc1",0,"L");$pdf->Cell(75,4,"$hlavicka->zuli","$rmc",0,"L");$pdf->Cell(9,5," ","$rmc1",0,"L");$pdf->Cell(29,4,"$hlavicka->zcdm","$rmc",0,"L");
$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(32,4,"$hlavicka->zpsc","$rmc",1,"L");
$pdf->Cell(27,5," ","$rmc1",0,"L");$pdf->Cell(74,4,"$hlavicka->zmes","$rmc",0,"L");$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(70,4,"$zstat","$rmc",1,"L");
$pdf->SetFont('arial','',10);

//zamestnavatel
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$pdf->Cell(18,5," ","$rmc1",0,"L");$pdf->Cell(161,6,"$fir_fnaz, $fir_fuli $fir_fcdm $fir_fmes","$rmc",1,"L");

//udaje NCZD
$pdf->Cell(190,17,"                          ","$rmc1",1,"L");
$nezdx=" ";
if ( $hlavicka->nezd == 1 ) { $nezdx="x"; }
$doch=" ";
if ( $hlavicka->docx == 1 ) { $doch="x"; }
$pdf->Cell(170,5," ","$rmc1",0,"L");$pdf->Cell(4,3,"$nezdx","$rmc",1,"L");
$pdf->Cell(190,9,"                          ","$rmc1",1,"L");
$pdf->Cell(170,5," ","$rmc1",0,"L");$pdf->Cell(4,4,"$doch","$rmc",1,"L");

//udaje BONUS
$pdf->Cell(190,19,"                          ","$rmc1",1,"L");
$bonusx=" ";
if ( $hlavicka->bonus == 1 ) { $bonusx="x"; }
$pdf->Cell(170,5," ","$rmc1",0,"L");$pdf->Cell(4,5,"$bonusx","$rmc",1,"L");
$pdf->SetFont('arial','',8);

$pdf->Cell(190,17,"                          ","$rmc1",1,"L");
$nar01=SkDatum($hlavicka->nar01);
if ( $nar01 == '00.00.0000' ) $nar01="";
$nar02=SkDatum($hlavicka->nar02);
if ( $nar02 == '00.00.0000' ) $nar02="";
$nar03=SkDatum($hlavicka->nar03);
if ( $nar03 == '00.00.0000' ) $nar03="";
$nar04=SkDatum($hlavicka->nar04);
if ( $nar04 == '00.00.0000' ) $nar04="";
$nar05=SkDatum($hlavicka->nar05);
if ( $nar05 == '00.00.0000' ) $nar05="";
$nar06=SkDatum($hlavicka->nar06);
if ( $nar06 == '00.00.0000' ) $nar06="";
$nar07=SkDatum($hlavicka->nar07);
if ( $nar07 == '00.00.0000' ) $nar07="";
$nar08=SkDatum($hlavicka->nar08);
if ( $nar08 == '00.00.0000' ) $nar08="";
$nar09=SkDatum($hlavicka->nar09);
if ( $nar09 == '00.00.0000' ) $nar09="";
$nar10=SkDatum($hlavicka->nar10);
if ( $nar10 == '00.00.0000' ) $nar10="";

if ( $hlavicka->bonus == 0 ) 
{ 
$hlavicka->det01=""; $nar01=""; $hlavicka->det02=""; $nar02=""; $hlavicka->det03=""; $nar03="";
$hlavicka->det04=""; $nar04=""; $hlavicka->det05=""; $nar05=""; $hlavicka->det06=""; $nar06="";
$hlavicka->det07=""; $nar07=""; $hlavicka->det08=""; $nar08=""; $hlavicka->det09=""; $nar09=""; $hlavicka->det10=""; $nar10="";
}
$pdf->Cell(17,4," ","$rmc1",0,"L");$pdf->Cell(58,4,"$hlavicka->det01","$rmc",0,"L");$pdf->Cell(24,4,"$nar01","$rmc",0,"C");
$pdf->Cell(58,4,"$hlavicka->det06","$rmc",0,"L");$pdf->Cell(23,4,"$nar06","$rmc",1,"C");
$pdf->Cell(17,4," ","$rmc1",0,"L");$pdf->Cell(58,5,"$hlavicka->det02","$rmc",0,"L");$pdf->Cell(24,5,"$nar02","$rmc",0,"C");
$pdf->Cell(58,5,"$hlavicka->det07","$rmc",0,"L");$pdf->Cell(23,5,"$nar07","$rmc",1,"C");
$pdf->Cell(17,4," ","$rmc1",0,"L");$pdf->Cell(58,4,"$hlavicka->det03","$rmc",0,"L");$pdf->Cell(24,4,"$nar03","$rmc",0,"C");
$pdf->Cell(58,4,"$hlavicka->det08","$rmc",0,"L");$pdf->Cell(23,4,"$nar08","$rmc",1,"C");
$pdf->Cell(17,4," ","$rmc1",0,"L");$pdf->Cell(58,4,"$hlavicka->det04","$rmc",0,"L");$pdf->Cell(24,4,"$nar04","$rmc",0,"C");
$pdf->Cell(58,4,"$hlavicka->det09","$rmc",0,"L");$pdf->Cell(23,4,"$nar09","$rmc",1,"C");
$pdf->Cell(17,4," ","$rmc1",0,"L");$pdf->Cell(58,4,"$hlavicka->det05","$rmc",0,"L");$pdf->Cell(24,4,"$nar05","$rmc",0,"C");
$pdf->Cell(58,4,"$hlavicka->det10","$rmc",0,"L");$pdf->Cell(23,4,"$nar10","$rmc",1,"C");
$pdf->SetFont('arial','',10);

//Dna
$pdf->Cell(190,56,"                          ","$rmc1",1,"L");
$datum=SkDatum($hlavicka->datum);
if ( $datum == '00.00.0000' ) $datum="";
$pdf->Cell(23,3," ","$rmc1",0,"L");$pdf->Cell(55,6,"$datum","$rmc",1,"C");
                                       } //koniec 1.strany


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
/////////////////////////////////////////KONIEC VYTLACENIA VZHLASENIA
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