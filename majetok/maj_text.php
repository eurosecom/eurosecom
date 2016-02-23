<HTML>
<?php

// celkovy zaciatok dokkurztu
       do
       {
$sys = 'HIM';
$urov = 1000;
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

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$citfir = include("../cis/citaj_nas.php");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$drupoh = 1*strip_tags($_REQUEST['drupoh']);
$h_inv = 1*$_REQUEST['h_inv'];
$uloz="NO";
$zmaz="NO";
$uprav="NO";
//$poliklinikase=1;


//vymazanie vsetko
if ( $copern == 66 )
    {



    }
//koniec vymazania vsetko


$sql = "SELECT * FROM F".$kli_vxcf."_majtextmaj";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sqlt = <<<paskovacka
(
   invt        int not null,
   itxt        TEXT not null
);
paskovacka;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_majtextmaj'.$sqlt;
$vysledok = mysql_query($sql);
              }

$sql = "SELECT zdro FROM F".$kli_vxcf."_majtextmaj ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD nas1 DECIMAL(4,0) DEFAULT 0 AFTER itxt";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD zdro DECIMAL(1,0) DEFAULT 0 AFTER nas1";
$vysledek = mysql_query("$sql");
               }

$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj MODIFY invt int PRIMARY KEY not null ";
$vysledek = mysql_query("$sql");

$sql = "SELECT zake FROM F".$kli_vxcf."_majtextmaj ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD cene DECIMAL(10,2) DEFAULT 0 AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD peru DECIMAL(10,2) DEFAULT 0 AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD pere DECIMAL(10,2) DEFAULT 0 AFTER zdro";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD odmu VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD odme VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD odpu VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD odpe VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD suv1 VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD suv2 VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD zrmu VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD zrme VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD zrpu VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD zrpe VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD stre VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD zake VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");

               }

$sql = "SELECT kcpa FROM F".$kli_vxcf."_majtextmaj ";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD suv3 VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD suv4 VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD stru VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD zaku VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD kcpa VARCHAR(15) not null AFTER zdro";
$vysledek = mysql_query("$sql");
               }

$sql = "SELECT cens FROM F".$kli_vxcf."_majtextmaj ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD cens DECIMAL(10,2) DEFAULT 0 AFTER zdro";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_majtextmaj,F$kli_vxcf"."_majmaj SET cens=cen*peru/100 WHERE F$kli_vxcf"."_majtextmaj.invt=F$kli_vxcf"."_majmaj.inv ";
$vysledek = mysql_query("$sql");
               }

$sql = "SELECT celu FROM F".$kli_vxcf."_majtextmaj ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD neud DECIMAL(10,2) DEFAULT 0 AFTER cene";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD neuu DECIMAL(10,2) DEFAULT 0 AFTER cene";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD celd DECIMAL(10,2) DEFAULT 0 AFTER cene";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD celu DECIMAL(10,2) DEFAULT 0 AFTER cene";
$vysledek = mysql_query("$sql");
               }

$sql = "SELECT ospo FROM F".$kli_vxcf."_majtextmaj ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD ospo DECIMAL(10,2) DEFAULT 0 AFTER zdro";
$vysledek = mysql_query("$sql");
               }

$ulozenx="";

//ulozenie
if ( $copern == 116 )
     {

$itxt = strip_tags($_REQUEST['itxt']);
$zdro = 1*strip_tags($_REQUEST['zdro']);
$kcpa = strip_tags($_REQUEST['kcpa']);
$ospo = strip_tags($_REQUEST['ospo']);
$cene = 1*strip_tags($_REQUEST['cene']);
$cens = 1*strip_tags($_REQUEST['cens']);
$peru = 1*strip_tags($_REQUEST['peru']);
$pere = 1*strip_tags($_REQUEST['pere']);
$odmu = strip_tags($_REQUEST['odmu']);
$odme = strip_tags($_REQUEST['odme']);
$odpu = strip_tags($_REQUEST['odpu']);
$odpe = strip_tags($_REQUEST['odpe']);
$suv1 = strip_tags($_REQUEST['suv1']);
$suv2 = strip_tags($_REQUEST['suv2']);
$suv3 = strip_tags($_REQUEST['suv3']);
$suv4 = strip_tags($_REQUEST['suv4']);
$zrmu = strip_tags($_REQUEST['zrmu']);
$zrme = strip_tags($_REQUEST['zrme']);
$zrpu = strip_tags($_REQUEST['zrpu']);
$zrpe = strip_tags($_REQUEST['zrpe']);
$stre = strip_tags($_REQUEST['stre']);
$zake = strip_tags($_REQUEST['zake']);
$stru = strip_tags($_REQUEST['stru']);
$zaku = strip_tags($_REQUEST['zaku']);

$neuu = strip_tags($_REQUEST['neuu']);
$neud = strip_tags($_REQUEST['neud']);
$celu = strip_tags($_REQUEST['celu']);
$celd = strip_tags($_REQUEST['celd']);

$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_majtextmaj ( invt, itxt, zdro ) VALUES ('$h_inv', '$itxt', '$zdro' ); "); 

$ulozttt = "UPDATE F$kli_vxcf"."_majtextmaj SET itxt='$itxt', zdro='$zdro', kcpa='$kcpa', ospo='$ospo', ".
" cene='$cene', cens='$cens', peru='$peru', pere='$pere', odmu='$odmu', odme='$odme', odpu='$odpu', odpe='$odpe', suv1='$suv1', suv2='$suv2', ". 
" suv3='$suv3', suv4='$suv4', stru='$stru', zaku='$zaku', neuu='$neuu', neud='$neud', celu='$celu', celd='$celd', ".
" zrmu='$zrmu', zrme='$zrme', zrpu='$zrpu', zrpe='$zrpe', stre='$stre', zake='$zake' WHERE invt=$h_inv "; 
$ulozene = mysql_query("$ulozttt"); 
//echo $ulozttt;
$copern=1;
$ulozenx="Text uloenı";
    }
//koniec ulozenia


//ak je zdroj > 0 aspon u jednej polozky nastav poliklinikase=1 aby ponukal uctovanie pri zdrojoch financovania eu...
$sql = "SELECT * FROM F$kli_vxcf"."_majtextmaj WHERE zdro > 0 ";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $poliklinikase=1;
  }


$sqlfir = "SELECT * FROM F$kli_vxcf"."_majtextmaj ".
" LEFT JOIN F$kli_vxcf"."_majmaj".
" ON F$kli_vxcf"."_majtextmaj.invt=F$kli_vxcf"."_majmaj.inv ".
" WHERE invt = $h_inv ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$itxt = $fir_riadok->itxt;
$naz = $fir_riadok->naz;
$zdro = 1*$fir_riadok->zdro;
$kcpa = $fir_riadok->kcpa;
$ospo = $fir_riadok->ospo;

$cene = $fir_riadok->cene;
$cens = $fir_riadok->cens;
$peru = $fir_riadok->peru;
$pere = $fir_riadok->pere;
$odmu = $fir_riadok->odmu;
$odme = $fir_riadok->odme;
$odpu = $fir_riadok->odpu;
$odpe = $fir_riadok->odpe;
$suv1 = $fir_riadok->suv1;
$suv2 = $fir_riadok->suv2;
$suv3 = $fir_riadok->suv3;
$suv4 = $fir_riadok->suv4;
$zrmu = $fir_riadok->zrmu;
$zrme = $fir_riadok->zrme;
$zrpu = $fir_riadok->zrpu;
$zrpe = $fir_riadok->zrpe;
$stre = $fir_riadok->stre;
$zake = $fir_riadok->zake;
$stru = $fir_riadok->stru;
$zaku = $fir_riadok->zaku;

$neuu = $fir_riadok->neuu;
$neud = $fir_riadok->neud;
$celu = $fir_riadok->celu;
$celd = $fir_riadok->celd;

//echo $zake;

mysql_free_result($fir_vysledok);

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Doplòujúci text o majetku</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">





<?php
//nova
  if ( $copern == 1 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.zdro.value = '<?php echo "$zdro";?>';
    document.formv1.kcpa.value = '<?php echo "$kcpa";?>';
    document.formv1.ospo.value = '<?php echo "$ospo";?>';

    document.formv1.neuu.value = '<?php echo "$neuu";?>';
    document.formv1.neud.value = '<?php echo "$neud";?>';
    document.formv1.celu.value = '<?php echo "$celu";?>';
    document.formv1.celd.value = '<?php echo "$celd";?>';

<?php if ( $poliklinikase == 1 ) { ?>

    document.formv1.cene.value = '<?php echo "$cene";?>';
    document.formv1.cens.value = '<?php echo "$cens";?>';
    document.formv1.peru.value = '<?php echo "$peru";?>';
    document.formv1.pere.value = '<?php echo "$pere";?>';
    document.formv1.odmu.value = '<?php echo "$odmu";?>';
    document.formv1.odme.value = '<?php echo "$odme";?>';
    document.formv1.odpu.value = '<?php echo "$odpu";?>';
    document.formv1.odpe.value = '<?php echo "$odpe";?>';
    document.formv1.suv1.value = '<?php echo "$suv1";?>';
    document.formv1.suv2.value = '<?php echo "$suv2";?>';
    document.formv1.suv3.value = '<?php echo "$suv3";?>';
    document.formv1.suv4.value = '<?php echo "$suv4";?>';
    document.formv1.zrmu.value = '<?php echo "$zrmu";?>';
    document.formv1.zrme.value = '<?php echo "$zrme";?>';
    document.formv1.zrpu.value = '<?php echo "$zrpu";?>';
    document.formv1.zrpe.value = '<?php echo "$zrpe";?>';
    document.formv1.stre.value = '<?php echo "$stre";?>';
    document.formv1.zake.value = '<?php echo "$zake";?>';
    document.formv1.stru.value = '<?php echo "$stru";?>';
    document.formv1.zaku.value = '<?php echo "$zaku";?>';




<?php                          } ?>

    }

<?php
//koniec nova
  }
?>

  </script>
</HEAD>
<BODY class="white" onload="ObnovUI();" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Doplòujúci text o majetku inv.èíslo <?php echo $h_inv." - ".$naz;?>
</td>
</tr>
</table>
<br />


<?php
if ( $copern == 1  )
     {
?>

<table class="fmenu" width="260px" >

<tr>
<td class="cmenu" width="10%"></td><td class="cmenu" width="10%"></td><td class="cmenu" width="10%"></td><td class="cmenu" width="10%"></td>
<td class="cmenu" width="10%"></td><td class="cmenu" width="10%"></td><td class="cmenu" width="10%"></td><td class="cmenu" width="10%"></td>
<td class="cmenu" width="10%">

Odpisovı plán - daòovı <img src='../obr/zoznam.png' width=20 height=20 border=0 title="Odpisovı plán" 
 onclick="window.open('../majetok/mesodp.php?copern=4&drupoh=4&page=1&cislo_inv=<?php echo $h_inv;?>&druh_pln=1', '_blank',
 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')" >
</td>
<td class="cmenu" width="10%">

Odpisovı plán - úètovnı <img src='../obr/zoznam.png' width=20 height=20 border=0 title="Odpisovı plán" 
 onclick="window.open('../majetok/mesodp.php?copern=4&drupoh=4&page=1&cislo_inv=<?php echo $h_inv;?>', '_blank',
 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')" >
</td>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="maj_text.php?page=<?php echo $page;?>&copern=116&h_inv=<?php echo $h_inv;?>">

<td class="bmenu" colspan="10">
<INPUT type="submit" id="uloz" name="uloz" value="Uloi">
<?php echo $ulozenx; ?>
</tr>

<tr>
<td class="cmenu" colspan="10">
Kód CPA:
<input class="hvstup" type="text" name="kcpa" id="kcpa" size="10" maxlength="15" value="" />

<img src='../obr/info.png' width=15 height=15 border=0 title="Èíselník kódov CPA" onclick="window.open('../majetok/ciselnik_kodov_CPA.pdf', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')" >

 Zdroj obstarania:
<select class="hvstup" size="1" name="zdro" id="zdro" >
<option value="0" >majetok obstaranı z vlastnıch prostriedkov</option>
<option value="2" >majetok obstaranı z prostriedkov EU,SR</option>
<option value="3" >darovanı a bezplatne nadobudnutı majetok</option>
</select>

 % Osobnej spotreby

<img src='../obr/info.png' width=15 height=15 border=0 title="Ko¾ko percent z nákladov ( daòovıch odpisov ) spotrebujete pre osobnú spotrebu ( pripoèítate¾ná poloka v DP ), ak pripoèítate minimálne 20% paušál netreba preukazova v 2015 - POZRI zostavu Daòové odpisy pre osobnú spotrebu v Inventúrnych a evidenènıch zostavách majetku" >

<input class="hvstup" type="text" name="ospo" id="ospo" size="10" maxlength="10" value="" />
</td>

</tr>


<?php if ( $poliklinikase == 1 ) { ?>


<tr><td class="cmenu" colspan="4">Hodnota obstaraná z prostriedkov SR:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="cens" id="cens" size="10" maxlength="10" value="" />Eur</td>
<td class="cmenu" colspan="4">Hodnota obstaraná z prostriedkov EU/bezplatne:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="cene" id="cene" size="10" maxlength="10" value="" />Eur</td>
</tr>

<tr><td class="cmenu" colspan="4">% obstarané z prostriedkov SR:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="peru" id="peru" size="10" maxlength="10" value="" />%</td>
<td class="cmenu" colspan="4">% obstarané z prostriedkov EU/bezplatne:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="pere" id="pere" size="10" maxlength="10" value="" />%</td></tr>

<tr><td class="cmenu" colspan="4"> ZARADENIE

<tr><td class="cmenu" colspan="4">UCM zaradenie èas obstaraná z prostriedkov SR:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="zrmu" id="zrmu" size="10" maxlength="10" value="" />(022)</td>
<td class="cmenu" colspan="4">UCD zaradenie èas obstaraná z prostriedkov SR:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="zrpu" id="zrpu" size="10" maxlength="10" value="" />(042)</td></tr>

<tr><td class="cmenu" colspan="4">UCM zaradenie èas obstaraná z prostriedkov EU:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="zrme" id="zrme" size="10" maxlength="10" value="" />(022)</td>
<td class="cmenu" colspan="4">UCD zaradenie èas obstaraná z prostriedkov EU:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="zrpe" id="zrpe" size="10" maxlength="10" value="" />(042)</td></tr>

<tr><td class="cmenu" colspan="4">UCM zaradenie z prostriedkov EU,SR - súvzanı zápis:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="suv3" id="suv3" size="10" maxlength="10" value="" />(346)</td>
<td class="cmenu" colspan="4">UCD zaradenie èas z prostriedkov EU,SR - súvzanı zápis:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="suv4" id="suv4" size="10" maxlength="10" value="" />(691)</td></tr>


<tr><td class="cmenu" colspan="4"> ODPISY

<tr><td class="cmenu" colspan="4">UCM odpisy èas obstaraná z prostriedkov SR:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="odmu" id="odmu" size="10" maxlength="10" value="" />(551)</td>
<td class="cmenu" colspan="4">UCD odpisy èas obstaraná z prostriedkov SR:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="odpu" id="odpu" size="10" maxlength="10" value="" />(082)</td></tr>

<tr><td class="cmenu" colspan="4">UCM odpisy èas obstaraná z prostriedkov EU:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="odme" id="odme" size="10" maxlength="10" value="" />(551)</td>
<td class="cmenu" colspan="4">UCD odpisy èas obstaraná z prostriedkov EU:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="odpe" id="odpe" size="10" maxlength="10" value="" />(082)</td></tr>

<tr><td class="cmenu" colspan="4">UCM odpisy z prostriedkov EU,SR - súvzanı zápis:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="suv1" id="suv1" size="10" maxlength="10" value="" />(384)</td>
<td class="cmenu" colspan="4">UCD odpisy z prostriedkov EU,SR - súvzanı zápis:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="suv2" id="suv2" size="10" maxlength="10" value="" />(649)</td></tr>

<tr><td class="cmenu" colspan="4">STR odpisy èas obstaraná z prostriedkov SR:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="stru" id="stru" size="10" maxlength="10" value="<?php echo $stru;?>" />(09)</td>
<td class="cmenu" colspan="4">ZAK odpisy èas obstaraná z prostriedkov SR:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="zaku" id="zaku" size="10" maxlength="10" value="<?php echo $zaku;?>" />(099901)</td></tr>

<tr><td class="cmenu" colspan="4">STR odpisy èas obstaraná z prostriedkov EU:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="stre" id="stre" size="10" maxlength="10" value="<?php echo $stre;?>" />(09)</td>
<td class="cmenu" colspan="4">ZAK odpisy èas obstaraná z prostriedkov EU:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="zake" id="zake" size="10" maxlength="10" value="<?php echo $zake;?>" />(099901)</td></tr>


<?php                             } ?>

<tr><td class="bmenu" colspan="10">
<textarea name="itxt" id="itxt" rows="15" cols="120" >
<?php echo $itxt; ?>
</textarea>
</td></tr>

<tr><td class="bmenu" colspan="10"></td></tr>

<tr><td class="cmenu" colspan="10">Stav odpisov v roku zaradenia v zmysle Zákona o dani z príjmov 595/2003 Z. z. §26 a 28</td></tr>
<tr><td class="cmenu" colspan="6">Celé Úètovné odpisy v roku zaradenia vypoèítané v zmysle §27 ods.1 alebo pod¾a §28 ods.1:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="neuu" id="neuu" size="10" maxlength="10"  /></td></tr>
<tr><td class="cmenu" colspan="6">Úètovné odpisy uplatnené v roku zaradenia zníené v zmysle §27 ods.2 písm.a) alebo pod¾a §28 ods.2 písm.a):
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="celu" id="celu" size="10" maxlength="10"  /></td>
<td class="cmenu" colspan="3">pomerná èas z roèného odpisu pod¾a poètu mesiacov od zaradenia</td>
</tr>
<tr><td class="cmenu" colspan="6">Celé Daòové odpisy v roku zaradenia vypoèítané v zmysle §27 ods.1 alebo pod¾a §28 ods.1:
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="neud" id="neud" size="10" maxlength="10"  /></td></tr>
<tr><td class="cmenu" colspan="6">Daòové odpisy uplatnené v roku zaradenia zníené v zmysle §27 ods.2 písm.a) alebo pod¾a §28 ods.2 písm.a):
<td class="cmenu" colspan="1"><input class="hvstup" type="text" name="celd" id="celd" size="10" maxlength="10"  /></td>
<td class="cmenu" colspan="3">pomerná èas z roèného odpisu pod¾a poètu mesiacov od zaradenia</td>
</tr>

</FORM>




<?php
// toto je koniec casti na zobrazenie tabulky a prechody medzi stranami 
     }

// celkovy koniec dokkurztu

       } while (false);
?>
</BODY>
</HTML>
