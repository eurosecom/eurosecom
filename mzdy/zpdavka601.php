<HTML>
<?php

do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$cislo_oc = $_REQUEST['cislo_oc'];
$h_kzmen = $_REQUEST['h_kzmen'];
$h_pzmen = $_REQUEST['h_pzmen'];
$h_dzmen = $_REQUEST['h_dzmen'];
$h_kdrh = $_REQUEST['h_kdrh'];
$h_dvypl = $_REQUEST['h_dvypl'];

$h_al = 1*$_REQUEST['h_al'];

$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if(!isset($fort)) $fort = 1;

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$mzdkun="mzdkun";
if( $_SESSION['newzam'] == 1 ) { $mzdkun="mzdkunnewzam"; }
//echo $_SESSION['newzam'];

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$h_dzmensql = SqlDatum($h_dzmen);
$h_dzmen = SkDatum($h_dzmensql);

//echo $h_dzmen;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));


?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Komunik·cia so ZP d·vka 601</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

function urob601(zdrv)
                {
var h_kzmen = document.forms.forms1.h_kzmen.value;
var h_pzmen = document.forms.forms1.h_pzmen.value;
var h_dzmen = document.forms.forms1.h_dzmen.value;
var h_kdrh = document.forms.forms1.h_kdrh.value;
var h_dvypl = document.forms.forms1.h_dvypl.value;
  var h_al = 0;
  if( document.forms.forms1.h_al.checked ) h_al=1;

window.open('zpdavka601.php?h_al=' + h_al + '&h_dvypl=' + h_dvypl + '&h_kzmen=' + h_kzmen + '&h_pzmen=' + h_pzmen + '&h_dzmen=' + h_dzmen + '&h_kdrh=' + h_kdrh + '&c_zdrv=' + zdrv + '&copern=30&drupoh=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>',
 '_blank' ,'<?php echo $tlcuwin; ?>' );
                }

function pdf601(zdrv)
                {
var h_dvypl = document.forms.forms1.h_dvypl.value;
var h_kzmen = document.forms.forms1.h_kzmen.value;
var h_pzmen = document.forms.forms1.h_pzmen.value;
var h_dzmen = document.forms.forms1.h_dzmen.value;
var h_kdrh = document.forms.forms1.h_kdrh.value;

window.open('zpdavka601.php?h_dvypl=' + h_dvypl + '&h_kzmen=' + h_kzmen + '&h_pzmen=' + h_pzmen + '&h_dzmen=' + h_dzmen + '&h_kdrh=' + h_kdrh + '&c_zdrv=' + zdrv +  '&copern=40&drupoh=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>',
 '_blank' ,'<?php echo $tlcuwin; ?>' );
                }


function nastav()
                {

<?php if( $copern == 1 ) { ?>

document.forms.forms1.h_dzmen.value='<?php echo $dnes; ?>';

<?php                    } ?>
                }
    
</script>
</HEAD>
<BODY class="white" id="white" onload="nastav();" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Komunik·cia so ZP d·vka 601

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//zakladna ponuka
if( $copern == 1 )
{
?>

<?php
$podmoc="oc = $cislo_oc ";
$sqltt = "SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE $podmoc ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);


  if (@$zaznam=mysql_data_seek($sql,0))
{
$polozka=mysql_fetch_object($sql);
?>

<table class="vstup" width="100%" >
<FORM name="forms1" class="obyc" method="post" action="#" >
<tr><td class="bmenu" width="30%">ZP:<td class="bmenu" width="50%"><?php echo $polozka->zdrv; ?></td>
<td class="bmenu" width="20%">ALL<input type="checkbox" name="h_al" value="1" /></td>
</tr>
<tr><td class="bmenu" width="30%">Firma:<td class="bmenu" width="50%"><?php echo $fir_fnaz.", ".$fir_fuli." ".$fir_fcdm.", ".$fir_fmes; ?></td></tr>
<tr><td class="bmenu" width="30%">Zamestnanec:<td class="bmenu" width="50%">
<img src='../obr/uprav.png' width=15 height=15 border=0 title="⁄prava ˙dajov o zamestnancovi" onClick="window.open('zamestnanci.php?sys=MZD&copern=8&page=1&cislo_oc=<?php echo $cislo_oc;?>&h_oc=<?php echo $cislo_oc;?>','_self','<?php echo $tlcuwin; ?>')" >

<?php echo $polozka->titl." ".$polozka->meno." ".$polozka->prie; ?></td></tr>

<tr>
<td class="bmenu" width="30%">Druh:
<td class="bmenu" width="50%">
<select size="1" name="h_kdrh" id="h_kdrh" >
<option value="N" >N = novÈ</option>
<option value="O" >O = opravnÈ</option>
</select>
</tr>
<tr>
<td class="bmenu" width="30%">KÛd zmeny:
<td class="bmenu" width="50%">
<select size="1" name="h_kzmen" id="h_kzmen" >
<option value="1" >1 = öt·t</option>
<option value="2" >2 = zamestnanec</option>
<option value="10" >10 = nemoc</option>
</select>
</tr>

<tr>
<td class="bmenu" width="30%">Platnosù zmeny:
<td class="bmenu" width="50%">
<select size="1" name="h_pzmen" id="h_pzmen" >
<option value="Z" >Z = zaËiatok</option>
<option value="K" >K = koniec</option>
</select>
</tr>


<tr>
<td class="bmenu" width="30%">D·tum zmeny:
<td class="bmenu" width="50%">
<input type="text" name="h_dzmen" id="h_dzmen" size="10" /> v tvare napr. 04.08.2009
</tr>
<tr>
<td class="bmenu" width="30%">D·tum vyplnenia formul·ra:
<td class="bmenu" width="50%">
<input type="text" name="h_dvypl" id="h_dvypl" size="10" /> v tvare napr. 04.08.2009
</tr>

<tr>
<td class="bmenu" width="30%">
<button class="hvstup" height=10 onclick="urob601(<?php echo $polozka->zdrv; ?>);">
Vytvoriù d·vku 601 elektronicky</button>
</tr>

<?php $ajpapier=0; ?>
<?php if( $ajpapier == 1 ) { ?>
<tr>
<td class="bmenu" width="30%">
<button class="hvstup" height=10 onclick="pdf601(<?php echo $polozka->zdrv; ?>);">
Vytvoriù d·vku 601 na papieri</button>
</tr>
<?php                      } ?>

</FORM>

</table>


<br /><br /><br /><br />

<table class="vstup" width="100%" >

<tr>
<td class="bmenu" width="30%">
<button class="hvstup" height=10 
 onclick="window.open('sp_rlfo.php?sys=<?php echo $sys; ?>&copern=1&cislo_oc=<?php echo $cislo_oc;?>','_self','<?php echo $tlcuwin; ?>');">
Prepn˙ù do Soci·lnej Poisùovne</button>

</tr>

</table>


<?php
}


?>





<?php
}
//koniec zakladnej ponuky
?>

<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU PRE ELEKTRONIKU
if( $copern == 30 )
{

$lenjeden = 1*$_REQUEST['lenjeden'];
if( $lenjeden == 1 )
{
$strana = 1*$_REQUEST['page'];
$pocetstran = 1*$_REQUEST['pocetpage'];
}

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="N601";


if (File_Exists ("../tmp/$nazsub.001")) { $soubor = unlink("../tmp/$nazsub.001"); }

$soubor = fopen("../tmp/$nazsub.001", "a+");

$c_zdrv = 1*$_REQUEST['c_zdrv'];

//hlavicka
if( $lenjeden == 0 )
{
$podmoc="oc = $cislo_oc ";
$h_dzmensql=SqlDatum($h_dzmen);
if( $h_al == 1 ) { $podmoc=" dan = '$h_dzmensql' AND zdrv = $c_zdrv "; }
$sqltt = "SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE $podmoc ";
}
if( $lenjeden == 1 )
{
$cislo_zdrv = 1*$_REQUEST['cislo_zdrv'];

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0 AND xzdrv = $cislo_zdrv ";
}

//echo $sqltt;

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


/////////////NACITANIE CISLA PLATITELA,NAZVU Z CISELNIKA ZP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv=$hlavicka->zdrv ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $platitel=$riaddok->vsy;
  $nazzdrv=$riaddok->nzdr;
  }

$pocetvietteladavky=1;
if( $lenjeden == 1 ) { $pocetvietteladavky=$pol; }
if( $h_al == 1 ) { $pocetvietteladavky=$pol; }

$obdobie=$kli_vmes;
$pole = explode(".", $h_dzmen);
$d_dzmen=$pole[2].$pole[1].$pole[0];

$dat_dat = Date ("Ymd", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$zp_fico="35937874";
if( $hlavicka->zdrv >= 2400 AND $hlavicka->zdrv <= 2499 ) { $zp_fico="35942436"; }
if( $hlavicka->zdrv >= 2700 AND $hlavicka->zdrv <= 2799 ) { $zp_fico="36284831"; }
if( $hlavicka->zdrv >= 2100 AND $hlavicka->zdrv <= 2199 ) { $zp_fico="35936835"; }
if( $hlavicka->zdrv >= 2300 AND $hlavicka->zdrv <= 2399 ) { $zp_fico="31699626"; }

$cislozp=substr($hlavicka->zdrv,0,2);
$pobocka=substr($hlavicka->zdrv,2,2);
$kli_vrok2=$kli_vrok-2000;
if( $kli_vrok2 < 10 ) $kli_vrok2="0".$kli_vrok2;

$kli_uzprix = StrTr($kli_uzprie, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

if( $i == 0 )
     {

  $text = "".$h_kdrh."|601|".$fir_fico."|".$zp_fico."|".$hlavicka->zdrv."|".$dat_dat."|1|".$pocetvietteladavky."";
  $text = $text."|1|1"."\r\n";
  fwrite($soubor, $text);

  $text = $platitel."|".$cislozp."|".$pobocka."|".$kli_vmes."|".$kli_vrok2."|".$fir_fnaz."|".$fir_fico."|||";
  $text = $text.$fir_fdic."|PO|".$fir_fmes."||".$fir_fuli."|".$fir_fpsc."||".$fir_ftel."|".$fir_ffax."|".$fir_fem1."|".$fir_fnb1."||".$fir_fuc1."|".$fir_fnm1."|";
  $text = $text.$kli_uzprix."|"."\r\n";
  fwrite($soubor, $text);

     }

}
$i = $i + 1;
$j = $j + 1;
  }

//polozky
if( $lenjeden == 0 )
{
$podmoc="oc = $cislo_oc ";
$h_dzmensql=SqlDatum($h_dzmen);
if( $h_al == 1 ) { $podmoc=" dan = '$h_dzmensql' AND zdrv = $c_zdrv "; }
$sqltt = "SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE $podmoc ";
//echo $sqltt;
}
if( $lenjeden == 1 )
{
$cislo_zdrv = 1*$_REQUEST['cislo_zdrv'];

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0 AND xzdrv = $cislo_zdrv ";
}


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);
$cislo=$i+1;

if( $lenjeden == 0 )
{
  $text = $cislo."|".$hlavicka->rdc.$hlavicka->rdk."|";

  $text = $text.$hlavicka->titl."|".$hlavicka->meno."|".$hlavicka->prie."|";
  $text = $text.$h_kzmen."|".$h_pzmen."|".$d_dzmen."|\r\n";

  fwrite($soubor, $text);
}

if( $lenjeden == 1 )
{
$datumsk=SkDatum($hlavicka->datum);
$pole = explode(".", $datumsk );
$d_dzmen=$pole[2].$pole[1].$pole[0];

  $text = $cislo."|".$hlavicka->rdc.$hlavicka->rdk."|";

  $text = $text.$hlavicka->titl."|".$hlavicka->meno."|".$hlavicka->prie."|";
  $text = $text.$hlavicka->kod."|".$hlavicka->platnost."|".$d_dzmen."|\r\n";

  fwrite($soubor, $text);
}

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.001">../tmp/<?php echo $nazsub; ?>.001</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalmesx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzaltrnx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalkunx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

}
///////////////////////////////////////////////////KONIEC SUBORU PRE ELEKTRONIKU copern=30

?>

<?php
///////////////////////////////////////////////////VYTVORENIE PDF 601
if( $copern == 40 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


if (File_Exists ("../tmp/d601s.$kli_uzid.pdf")) { $soubor = unlink("../tmp/d601s.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$sirka_vyska="320,230";
$c_zdrv = 1*$_REQUEST['c_zdrv'];
$cislo_zdrv = 1*$_REQUEST['cislo_zdrv'];
if( $c_zdrv >= 2700 AND $c_zdrv <= 2799 ) { $sirka_vyska="320,232"; }
if( $cislo_zdrv >= 2700 AND $cislo_zdrv <= 2799 ) { $sirka_vyska="320,232"; }
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE oc = $cislo_oc";
//echo $sqltt;

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

///////////////////////////////////////////ZP 2508
if( $hlavicka->zdrv >= 2500 AND $hlavicka->zdrv <= 2599 )
          {

if( $j == 0 )
     {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/zdravpoist/zp2508/davka601s.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/zdravpoist/zp2508/davka601s.jpg',5,5,310,200); 
}

//strana ËÌslo/celkov˝ poËet str·n
$pdf->Cell(190,23,"                          ","0",1,"L");

$strana=1;
$pocetstran=1;
$lenjeden = 1*$_REQUEST['lenjeden'];
if( $lenjeden == 1 )
{
$strana = 1*$_REQUEST['page'];
$pocetstran = 1*$_REQUEST['pocetpage'];
}

$pdf->Cell(14,6," ","0",0,"R");$pdf->Cell(20,6,"$strana","0",0,"C");$pdf->Cell(1,6," ","0",0,"R");$pdf->Cell(20,6,"$pocetstran","0",0,"C");

//za kalend·rny mesiac
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$kli_vmes;

$pdf->Cell(26,6," ","0",0,"R");$pdf->Cell(21,6,"$text","0",0,"C");

//rok
$pdf->Cell(2,6,"                          ","0",0,"L");

$text="$kli_vrok";

$pdf->Cell(33,6," ","0",0,"R");$pdf->Cell(21,6,"$text","0",0,"C");

//kÛd poisùovne
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=substr($hlavicka->zdrv,2,2);

$A=substr($text,0,1);
$B=substr($text,1,1);

$pdf->Cell(38,6," ","0",0,"R");$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(4,6,"$B","0",0,"C");

//ËÌslo platiteæa
$pdf->Cell(2,6,"                          ","0",0,"L");


/////////////NACITANIE CISLA PLATITELA,NAZVU Z CISELNIKA ZP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv=$hlavicka->zdrv ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $platitel=$riaddok->vsy;
  $nazzdrv=$riaddok->nzdr;
  }

$text=$platitel;

$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);

$pdf->Cell(32,6," ","0",0,"R");$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(3,6,"$B","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");
$pdf->Cell(4,6,"$D","0",0,"C");$pdf->Cell(4,6,"$E","0",0,"C");$pdf->Cell(4,6,"$F","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");
$pdf->Cell(3,6,"$H","0",0,"C");$pdf->Cell(5,6,"$I","0",0,"C");$pdf->Cell(4,6,"$J","0",1,"C");


//novÈ
$pdf->Cell(190,11,"                          ","0",1,"L");

$nove="x"; $opravne="";
if( $h_kdrh == 'O' ) { $nove=""; $opravne="x"; }

$text=$nove;

$pdf->Cell(40,6," ","0",0,"R");$pdf->Cell(5,6,"$text","0",0,"C");$pdf->Cell(1,6," ","0",0,"R");

//opravnÈ
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$opravne;

$pdf->Cell(15,6," ","0",0,"R");$pdf->Cell(6,6,"$text","0",0,"C");$pdf->Cell(1,6," ","0",1,"R");


//obchodnÈ meno - 1.riadok
$pdf->Cell(190,6,"                          ","0",1,"L");

$text=$fir_fnaz;

$pdf->Cell(38,5," ","0",0,"R");$pdf->Cell(143,5,"$text","0",0,"L");$pdf->Cell(1,5," ","0",1,"R");

//2.riadok
$pdf->Cell(-1,5,"                          ","0",0,"L");

$text=" ";

$pdf->Cell(39,5," ","0",0,"R");$pdf->Cell(143,5,"$text","0",0,"L");

//pr·vna forma
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$fir_uctt02;

$pdf->Cell(1,6," ","0",0,"R");$pdf->Cell(33,5,"$text","0",0,"L");$pdf->Cell(1,6," ","0",1,"R");


//rodnÈ ËÌslo
$pdf->Cell(190,3,"                          ","0",1,"L");

$text=$fordc;

$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);

$pdf->Cell(14,6," ","0",0,"R");$pdf->Cell(4,6,"$A","0",0,"C");$pdf->Cell(4,6,"$B","0",0,"C");$pdf->Cell(4,6,"$C","0",0,"C");
$pdf->Cell(4,6,"$D","0",0,"C");$pdf->Cell(4,6,"$E","0",0,"C");$pdf->Cell(5,6,"$F","0",0,"C");$pdf->Cell(4,6,"$G","0",0,"C");
$pdf->Cell(4,6,"$H","0",0,"C");$pdf->Cell(4,6,"$I","0",0,"C");$pdf->Cell(4,6,"$J","0",0,"C");

//ËÌslo povolenia k pobytu
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=" ";

$pdf->Cell(19,6," ","0",0,"R");$pdf->Cell(55,6,"$text","0",0,"L");

//DI»
$pdf->Cell(2,6,"                          ","0",0,"L");

$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);

$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(4,6,"$B","0",0,"C");$pdf->Cell(4,6,"$C","0",0,"C");
$pdf->Cell(4,6,"$D","0",0,"C");$pdf->Cell(4,6,"$E","0",0,"C");$pdf->Cell(4,6,"$F","0",0,"L");$pdf->Cell(5,6,"$G","0",0,"C");
$pdf->Cell(3,6,"$H","0",0,"C");$pdf->Cell(5,6,"$I","0",0,"C");$pdf->Cell(4,6,"$J","0",0,"C");

//I»O
$pdf->Cell(2,6,"                          ","0",0,"L");

$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);

$pdf->Cell(43,6," ","0",0,"R");$pdf->Cell(4,6,"$A","0",0,"C");$pdf->Cell(4,6,"$B","0",0,"C");$pdf->Cell(4,6,"$C","0",0,"C");
$pdf->Cell(4,6,"$D","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");$pdf->Cell(4,6,"$F","0",0,"C");$pdf->Cell(4,6,"$G","0",0,"C");
$pdf->Cell(4,6,"$H","0",1,"C");


//obec
$pdf->Cell(190,0,"                          ","0",1,"L");

$text=$fir_fmes;

$pdf->Cell(39,5," ","0",0,"R");$pdf->Cell(92,6,"$text","0",0,"L");$pdf->Cell(1,5," ","0",0,"R");

//ulica
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$fir_fuli;

$pdf->Cell(5,5," ","0",0,"R");$pdf->Cell(150,6,"$text","0",0,"L");$pdf->Cell(1,5," ","0",1,"R");


//s˙pis ËÌslo
$pdf->Cell(190,5,"                          ","0",1,"L");

$text=$fir_fcdm;

$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(43,6,"$text","0",0,"L");

//ËÌslo
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=" ";

$pdf->Cell(55,6,"$text","0",0,"L");

//PS»
$pdf->Cell(2,6,"                          ","0",0,"L");

$A=substr($fir_fpsc,0,1);
$B=substr($fir_fpsc,1,1);
$C=substr($fir_fpsc,2,1);
$D=substr($fir_fpsc,3,1);
$E=substr($fir_fpsc,4,1);

$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(5,5,"$C","0",0,"C");
$pdf->Cell(3,5,"$D","0",0,"C");$pdf->Cell(5,5,"$E","0",0,"C");

//öt·t
$pdf->Cell(2,6,"                          ","0",0,"L");

$text="SR";

$pdf->Cell(62,5," ","0",0,"R");$pdf->Cell(36,6,"$text","0",1,"L");


//telefÛn
$pdf->Cell(190,0,"                          ","0",1,"L");

$text=$fir_ftel;

$pdf->Cell(23,5," ","0",0,"R");$pdf->Cell(51,5,"$text","0",0,"L");

//fax
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$fir_ffax;

$pdf->Cell(4,5," ","0",0,"R");$pdf->Cell(51,5,"$text","0",0,"L");

//email
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$fir_fem1;

$pdf->Cell(8,5," ","0",0,"R");$pdf->Cell(59,5,"$text","0",1,"L");


//n·zov banky
$pdf->Cell(190,5,"                          ","0",1,"L");

$text=$fir_fnb1;

$pdf->Cell(13,5," ","0",0,"R");$pdf->Cell(70,5,"$text","0",0,"L");

//predËÌslie
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=" ";

$pdf->Cell(1,5," ","0",0,"R");$pdf->Cell(45,5,"$text","0",0,"L");

//ËÌslo ˙Ëtu
$pdf->Cell(2,6,"                          ","0",0,"L");

$A=substr($fir_fuc1,0,1);
$B=substr($fir_fuc1,1,1);
$C=substr($fir_fuc1,2,1);
$D=substr($fir_fuc1,3,1);
$E=substr($fir_fuc1,4,1);
$F=substr($fir_fuc1,5,1);
$G=substr($fir_fuc1,6,1);
$H=substr($fir_fuc1,7,1);
$I=substr($fir_fuc1,8,1);
$J=substr($fir_fuc1,9,1);

$pdf->Cell(4,4,"$A","0",0,"C");$pdf->Cell(5,4,"$B","0",0,"C");$pdf->Cell(3,4,"$C","0",0,"C");$pdf->Cell(5,4,"$D","0",0,"C");
$pdf->Cell(4,4,"$E","0",0,"C");$pdf->Cell(4,4,"$F","0",0,"C");$pdf->Cell(4,4,"$G","0",0,"C");$pdf->Cell(5,4,"$H","0",0,"C");
$pdf->Cell(3,4,"$I","0",0,"C");$pdf->Cell(5,4,"$J","0",0,"C");

//kÛd banky
$pdf->Cell(2,6,"                          ","0",0,"L");

$A=substr($fir_fnm1,0,1);
$B=substr($fir_fnm1,1,1);
$C=substr($fir_fnm1,2,1);
$D=substr($fir_fnm1,3,1);

$pdf->Cell(43,5," ","0",0,"R");$pdf->Cell(4,4,"$A","0",0,"C");$pdf->Cell(4,4,"$B","0",0,"C");$pdf->Cell(5,4,"$C","0",0,"C");
$pdf->Cell(3,4,"$D","0",1,"C");


//POISTENEC 1
  $prie1=$hlavicka->prie;
  $meno1=$hlavicka->meno;
  $rdc1=$hlavicka->rdc;
  $rdk1=$hlavicka->rdk;
  $h_kzmen1=$h_kzmen;
  $h_pzmen1=$h_pzmen;
  $h_dzmen1=$h_dzmen;
  $titl1=trim($hlavicka->titl);
  if( $titl1 != '' ) $titl1=", ".$titl1;

$lenjeden = 1*$_REQUEST['lenjeden'];

if( $lenjeden == 1 )
{
$cislo_zdrv = 1*$_REQUEST['cislo_zdrv'];
$sqldoktt = "SELECT datum FROM F$kli_vxcf"."_mzdzpprerusenie "." WHERE ume = $kli_vume AND cpl >= 0 AND xzdrv = $cislo_zdrv ORDER BY datum DESC LIMIT 1";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_dzmen=SkDatum($riaddok->datum);
  $h_dvypl=SkDatum($riaddok->datum);
  }


$cpl=1;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*6);

$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0 AND xzdrv = $cislo_zdrv ORDER BY cpl";

//echo $sqldoktt;
//exit;

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie1=$riaddok->prie;
  $meno1=$riaddok->meno;
  $rdc1=$riaddok->rdc;
  $rdk1=$riaddok->rdk;
  $h_kzmen1=$riaddok->kod;
  $h_pzmen1=$riaddok->platnost;
  $h_dzmen1=SkDatum($riaddok->datum);
  $titl1=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl1 != '' ) $titl1=", ".$titl1;
}
$priemenotitl=$prie1.",".$meno1.$titl1;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,14,"                          ","0",1,"L");
$text=$rdc1.$rdk1;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(20,5," ","0",0,"R");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(5,5,"$C","0",0,"C");
$pdf->Cell(3,5,"$D","0",0,"C");$pdf->Cell(5,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");$pdf->Cell(4,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",0,"C");$pdf->Cell(5,5,"$I","0",0,"C");$pdf->Cell(3,5,"$J","0",0,"C");


$pdf->Cell(1,6,"                          ","0",0,"L");

$pdf->Cell(156,5,"$priemenotitl","0",0,"L");$pdf->Cell(19,5,"$h_kzmen1","0",0,"C");$pdf->Cell(20,5,"$h_pzmen1","0",0,"C");

$pdf->Cell(1,6,"                          ","0",0,"L");
$text=$h_dzmen1;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(5,5,"$C","0",0,"C");
$pdf->Cell(3,5,"$D","0",0,"C");$pdf->Cell(5,5,"$E","0",0,"C");$pdf->Cell(3,5,"$F","0",0,"C");$pdf->Cell(5,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",1,"C");



if( $lenjeden == 1 )
{
//POISTENEC 2
$cpl=2;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*6);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie2=""; $meno2=""; $titl2=""; $h_kzmen2=""; $h_pzmen2="";  $h_dzmen2=""; $rdc2=""; $rdk2="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie2=$riaddok->prie;
  $meno2=$riaddok->meno;
  $rdc2=$riaddok->rdc;
  $rdk2=$riaddok->rdk;
  $h_kzmen2=$riaddok->kod;
  $h_pzmen2=$riaddok->platnost;
  $h_dzmen2=SkDatum($riaddok->datum);
  $titl2=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl2 != '' ) $titl2=", ".$titl2;

$priemenotitl=$prie2.",".$meno2.$titl2;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";


$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc2.$rdk2;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(20,5," ","0",0,"R");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(5,5,"$C","0",0,"C");
$pdf->Cell(3,5,"$D","0",0,"C");$pdf->Cell(5,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");$pdf->Cell(4,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",0,"C");$pdf->Cell(5,5,"$I","0",0,"C");$pdf->Cell(3,5,"$J","0",0,"C");

$pdf->Cell(1,6,"                          ","0",0,"L");

$pdf->Cell(156,5,"$priemenotitl","0",0,"L");$pdf->Cell(19,5,"$h_kzmen2","0",0,"C");$pdf->Cell(20,5,"$h_pzmen2","0",0,"C");

$pdf->Cell(1,6,"                          ","0",0,"L");
$text=$h_dzmen2;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(5,5,"$C","0",0,"C");
$pdf->Cell(3,5,"$D","0",0,"C");$pdf->Cell(5,5,"$E","0",0,"C");$pdf->Cell(3,5,"$F","0",0,"C");$pdf->Cell(5,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",1,"C");

//POISTENEC 3
$cpl=3;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*6);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie3=""; $meno3=""; $titl3=""; $h_kzmen3=""; $h_pzmen3="";  $h_dzmen3=""; $rdc3=""; $rdk3="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie3=$riaddok->prie;
  $meno3=$riaddok->meno;
  $rdc3=$riaddok->rdc;
  $rdk3=$riaddok->rdk;
  $h_kzmen3=$riaddok->kod;
  $h_pzmen3=$riaddok->platnost;
  $h_dzmen3=SkDatum($riaddok->datum);
  $titl3=trim($riaddok->titl);;
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl3 != '' ) $titl3=", ".$titl3;

$priemenotitl=$prie3.",".$meno3.$titl3;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc3.$rdk3;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(20,5," ","0",0,"R");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(5,5,"$C","0",0,"C");
$pdf->Cell(3,5,"$D","0",0,"C");$pdf->Cell(5,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");$pdf->Cell(4,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",0,"C");$pdf->Cell(5,5,"$I","0",0,"C");$pdf->Cell(3,5,"$J","0",0,"C");

$pdf->Cell(1,6,"                          ","0",0,"L");

$pdf->Cell(156,5,"$priemenotitl","0",0,"L");$pdf->Cell(19,5,"$h_kzmen3","0",0,"C");$pdf->Cell(20,5,"$h_pzmen3","0",0,"C");

$pdf->Cell(1,6,"                          ","0",0,"L");
$text=$h_dzmen3;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(5,5,"$C","0",0,"C");
$pdf->Cell(3,5,"$D","0",0,"C");$pdf->Cell(5,5,"$E","0",0,"C");$pdf->Cell(3,5,"$F","0",0,"C");$pdf->Cell(5,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",1,"C");

//POISTENEC 4
$cpl=4;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*6);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie4=""; $meno4=""; $titl4=""; $h_kzmen4=""; $h_pzmen4="";  $h_dzmen4=""; $rdc4=""; $rdk4="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie4=$riaddok->prie;
  $meno4=$riaddok->meno;
  $rdc4=$riaddok->rdc;
  $rdk4=$riaddok->rdk;
  $h_kzmen4=$riaddok->kod;
  $h_pzmen4=$riaddok->platnost;
  $h_dzmen4=SkDatum($riaddok->datum);
  $titl4=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl4 != '' ) $titl4=", ".$titl4;

$priemenotitl=$prie4.",".$meno4.$titl4;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc4.$rdk4;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(20,5," ","0",0,"R");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(5,5,"$C","0",0,"C");
$pdf->Cell(3,5,"$D","0",0,"C");$pdf->Cell(5,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");$pdf->Cell(4,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",0,"C");$pdf->Cell(5,5,"$I","0",0,"C");$pdf->Cell(3,5,"$J","0",0,"C");

$pdf->Cell(1,6,"                          ","0",0,"L");
$pdf->Cell(156,5,"$priemenotitl","0",0,"L");$pdf->Cell(19,5,"$h_kzmen4","0",0,"C");$pdf->Cell(20,5,"$h_pzmen4","0",0,"C");

$pdf->Cell(1,6,"                          ","0",0,"L");
$text=$h_dzmen4;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(5,5,"$C","0",0,"C");
$pdf->Cell(3,5,"$D","0",0,"C");$pdf->Cell(5,5,"$E","0",0,"C");$pdf->Cell(3,5,"$F","0",0,"C");$pdf->Cell(5,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",1,"C");

//POISTENEC 5
$cpl=5;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*6);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie5=""; $meno5=""; $titl5=""; $h_kzmen5=""; $h_pzmen5="";  $h_dzmen5=""; $rdc5=""; $rdk5="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie5=$riaddok->prie;
  $meno5=$riaddok->meno;
  $rdc5=$riaddok->rdc;
  $rdk5=$riaddok->rdk;
  $h_kzmen5=$riaddok->kod;
  $h_pzmen5=$riaddok->platnost;
  $h_dzmen5=SkDatum($riaddok->datum);
  $titl5=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl5 != '' ) $titl5=", ".$titl5; 

$priemenotitl=$prie5.",".$meno5.$titl5;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,1,"                          ","0",1,"L");
$text=$rdc5.$rdk5;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(20,5," ","0",0,"R");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(5,5,"$C","0",0,"C");
$pdf->Cell(3,5,"$D","0",0,"C");$pdf->Cell(5,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");$pdf->Cell(4,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",0,"C");$pdf->Cell(5,5,"$I","0",0,"C");$pdf->Cell(3,5,"$J","0",0,"C");

$pdf->Cell(1,6,"                          ","0",0,"L");
$pdf->Cell(156,5,"$priemenotitl","0",0,"L");$pdf->Cell(19,5,"$h_kzmen5","0",0,"C");$pdf->Cell(20,5,"$h_pzmen5","0",0,"C");

$pdf->Cell(1,6,"                          ","0",0,"L");
$text=$h_dzmen5;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(5,5,"$C","0",0,"C");
$pdf->Cell(3,5,"$D","0",0,"C");$pdf->Cell(5,5,"$E","0",0,"C");$pdf->Cell(3,5,"$F","0",0,"C");$pdf->Cell(5,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",1,"C");

//POISTENEC 6
$cpl=6;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*6);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie6=""; $meno6=""; $titl6=""; $h_kzmen6=""; $h_pzmen6="";  $h_dzmen6=""; $rdc6=""; $rdk6="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie6=$riaddok->prie;
  $meno6=$riaddok->meno;
  $rdc6=$riaddok->rdc;
  $rdk6=$riaddok->rdk;
  $h_kzmen6=$riaddok->kod;
  $h_pzmen6=$riaddok->platnost;
  $h_dzmen6=SkDatum($riaddok->datum);
  $titl6=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl6 != '' ) $titl6=", ".$titl6;

$priemenotitl=$prie6.",".$meno6.$titl6;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc6.$rdk6;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(20,5," ","0",0,"R");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(5,5,"$C","0",0,"C");
$pdf->Cell(3,5,"$D","0",0,"C");$pdf->Cell(5,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");$pdf->Cell(4,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",0,"C");$pdf->Cell(5,5,"$I","0",0,"C");$pdf->Cell(3,5,"$J","0",0,"C");

$pdf->Cell(1,6,"                          ","0",0,"L");
$pdf->Cell(156,5,"$priemenotitl","0",0,"L");$pdf->Cell(19,5,"$h_kzmen6","0",0,"C");$pdf->Cell(20,5,"$h_pzmen6","0",0,"C");

$pdf->Cell(1,6,"                          ","0",0,"L");
$text=$h_dzmen6;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(5,5,"$C","0",0,"C");
$pdf->Cell(3,5,"$D","0",0,"C");$pdf->Cell(5,5,"$E","0",0,"C");$pdf->Cell(3,5,"$F","0",0,"C");$pdf->Cell(5,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",1,"C");
}
//koniec lenjeden != 1

$pdf->SetY(157);
//vyplnil
$pdf->Cell(190,2,"                          ","0",1,"L");

$text=$fir_mzdt05;

$pdf->Cell(23,5," ","0",0,"R");$pdf->Cell(88,6,"$text","0",0,"L");$pdf->Cell(13,5," ","0",1,"R");

//vyplnil 2
$pdf->Cell(190,0,"                          ","0",1,"L");

$text=" ";

$pdf->Cell(23,5," ","0",0,"R");$pdf->Cell(88,6,"$text","0",0,"L");$pdf->Cell(13,5," ","0",1,"R");


//kontakt 1
$pdf->Cell(190,1,"                          ","0",1,"L");

$text=$fir_mzdt04;

$pdf->Cell(23,5," ","0",0,"R");$pdf->Cell(88,5,"$text","0",0,"L");$pdf->Cell(13,5," ","0",1,"R");

//kontakt 2
$pdf->Cell(190,-1,"                          ","0",1,"L");

$text=" ";

$pdf->Cell(23,5," ","0",0,"R");$pdf->Cell(88,5,"$text","0",0,"L");$pdf->Cell(13,5," ","0",1,"R");

//kontakt 3
$pdf->Cell(190,-1,"                          ","0",1,"L");

$text=" ";

$pdf->Cell(23,5," ","0",0,"R");$pdf->Cell(88,5,"$text","0",0,"L");$pdf->Cell(13,5," ","0",1,"R");


//d·tum 1
$pdf->Cell(190,0,"                          ","0",1,"L");

$text=$h_dvypl;

$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);

$pdf->Cell(24,5," ","0",0,"R");$pdf->Cell(4,6,"$A","0",0,"C");$pdf->Cell(5,6,"$B","0",0,"C");$pdf->Cell(3,6,"$C","0",0,"C");
$pdf->Cell(5,6,"$D","0",0,"C");$pdf->Cell(4,6,"$E","0",0,"L");$pdf->Cell(4,6,"$F","0",0,"L");$pdf->Cell(4,6,"$G","0",0,"L");
$pdf->Cell(4,6,"$H","0",0,"L");

//d·tum 2
$pdf->Cell(1,6,"                          ","0",0,"L");

$text=$h_dvypl;

$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);

$pdf->Cell(64,5," ","0",0,"R");$pdf->Cell(4,6,"$A","0",0,"C");$pdf->Cell(5,6,"$B","0",0,"C");$pdf->Cell(4,6,"$C","0",0,"C");
$pdf->Cell(4,6,"$D","0",0,"C");$pdf->Cell(4,6,"$E","0",0,"C");$pdf->Cell(4,6,"$F","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");
$pdf->Cell(3,6,"$H","0",0,"C");

//d·tum 3
$pdf->Cell(1,6,"                          ","0",0,"L");

$text=" ";

$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);

$pdf->Cell(62,5," ","0",0,"R");$pdf->Cell(4,6,"$A","0",0,"C");$pdf->Cell(4,6,"$B","0",0,"C");$pdf->Cell(4,6,"$C","0",0,"C");
$pdf->Cell(4,6,"$D","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");$pdf->Cell(3,6,"$F","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");
$pdf->Cell(4,6,"$H","0",0,"C");


     }

          }
///////////////////////////////////////////koniec 2508

///////////////////////////////////////////ZP 2408
if( $hlavicka->zdrv >= 2400 AND $hlavicka->zdrv <= 2499 )
          {

if( $j == 0 )
     {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/zdravpoist/dovera2010/davka601s.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/zdravpoist/dovera2010/davka601s.jpg',23,2,280,200); 

}

/////////////NACITANIE CISLA PLATITELA,NAZVU Z CISELNIKA ZP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv=$hlavicka->zdrv ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $platitel=$riaddok->vsy;
  $nazzdrv=$riaddok->nzdr;
  }

//ËÌslo platiteæa poistnÈho
$pdf->Cell(190,1,"                          ","0",1,"L");

$text=$platitel."     ";

$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);

$pdf->Cell(168,6," ","0",0,"R");$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(7,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");
$pdf->Cell(8,5,"$D","0",0,"C");$pdf->Cell(7,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(7,5,"$G","0",0,"C");
$pdf->Cell(8,5,"$H","0",0,"C");$pdf->Cell(8,5,"$I","0",0,"C");$pdf->Cell(8,5,"$J","0",0,"C");$pdf->Cell(7,5,"$K","0",0,"C");
$pdf->Cell(8,5,"$L","0",0,"C");$pdf->Cell(7,5,"$M","0",0,"C");$pdf->Cell(8,5,"$N","0",0,"C");$pdf->Cell(8,5,"$O","0",1,"C");


//za kalend·rny mesiac
$pdf->Cell(190,7,"                          ","0",1,"L");

$text=$kli_vmes;

$pdf->Cell(115,5," ","0",0,"R");$pdf->Cell(22,8,"$text","0",0,"C");

//rok
$pdf->Cell(2,6,"                          ","0",0,"L");

$text="$kli_vrok";

$pdf->Cell(22,5," ","0",0,"R");$pdf->Cell(22,8,"$text","0",0,"C");


//kÛd poisùovne
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$hlavicka->zdrv;

$A=substr($text,2,1);
$B=substr($text,3,1);

$pdf->Cell(44,5," ","0",0,"R");$pdf->Cell(8,4,"$A","0",0,"C");$pdf->Cell(7,4,"$B","0",1,"C");


//strana ËÌslo / celkov˝ poËet str·n
$pdf->Cell(190,0,"                          ","0",1,"L");

$strana=1;
$pocetstran=1;
$lenjeden = 1*$_REQUEST['lenjeden'];
if( $lenjeden == 1 )
{
$strana = 1*$_REQUEST['page'];
$pocetstran = 1*$_REQUEST['pocetpage'];
}

$A=substr($text,0,1);
$B=substr($text,1,1);

$pdf->Cell(16,5," ","0",0,"R");$pdf->Cell(30,4,"$strana","0",0,"C");$pdf->Cell(30,4,"$pocetstran","0",0,"C");

//ËÌslo platiteæa
$pdf->Cell(2,6,"                          ","0",0,"L");


$text=$platitel;

$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);

$pdf->Cell(136,6," ","0",0,"R");$pdf->Cell(8,4,"$A","0",0,"C");$pdf->Cell(7,4,"$B","0",0,"C");$pdf->Cell(8,4,"$C","0",0,"C");
$pdf->Cell(8,4,"$D","0",0,"C");$pdf->Cell(7,4,"$E","0",0,"C");$pdf->Cell(8,4,"$F","0",0,"C");$pdf->Cell(7,4,"$G","0",0,"C");
$pdf->Cell(8,4,"$H","0",0,"C");$pdf->Cell(8,4,"$I","0",0,"C");$pdf->Cell(7,4,"$J","0",1,"C");


//druh ozn·menia novÈ
$pdf->Cell(190,6,"                          ","0",1,"L");

$nove="x"; $opravne="";
if( $h_kdrh == 'O' ) { $nove=""; $opravne="x"; }

$text=$nove;

$pdf->Cell(145,5," ","0",0,"R");$pdf->Cell(8,5,"$text","0",0,"C");

//opravnÈ
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$opravne;

$pdf->Cell(20,5," ","0",0,"R");$pdf->Cell(9,5,"$text","0",1,"C");


//obchodnÈ meno alebo meno a prezvisko
$pdf->Cell(190,3,"                          ","0",1,"L");

$text=$fir_fnaz;

$pdf->Cell(54,5," ","0",0,"R");$pdf->Cell(152,8,"$text","0",0,"L");

//pr·vna forma
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$fir_uctt02;

$pdf->Cell(21,5," ","0",0,"R");$pdf->Cell(61,8,"$text","0",1,"L");


//rodnÈ ËÌslo
$pdf->Cell(190,4,"                          ","0",1,"L");

$text=$fordc;

$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);

$pdf->Cell(15,5," ","0",0,"R");$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(7,5,"$C","0",0,"C");
$pdf->Cell(8,5,"$D","0",0,"C");$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(7,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");
$pdf->Cell(8,5,"$H","0",0,"C");$pdf->Cell(7,5,"$I","0",0,"C");$pdf->Cell(7,5,"$J","0",0,"C");

//»Ìslo povolenia k pobytu
$pdf->Cell(1,5,"                          ","0",0,"L");

$text=" ";

$pdf->Cell(45,5,"$text","0",0,"L");

//DI»/I» DPH
$pdf->Cell(1,5,"                          ","0",0,"L");

$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$K=substr($fir_fdic,10,1);
$L=substr($fir_fdic,11,1);

$pdf->Cell(7,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(7,5,"$C","0",0,"C");$pdf->Cell(8,5,"$D","0",0,"C");
$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(7,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");$pdf->Cell(8,5,"$H","0",0,"C");
$pdf->Cell(7,5,"$I","0",0,"C");$pdf->Cell(8,5,"$J","0",0,"C");$pdf->Cell(7,5,"$K","0",0,"C");$pdf->Cell(7,5,"$L","0",0,"C");

//I»O
$pdf->Cell(1,5,"                          ","0",0,"L");

$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);

$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(7,5,"$C","0",0,"C");$pdf->Cell(8,5,"$D","0",0,"C");
$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(7,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");$pdf->Cell(7,5,"$H","0",1,"C");


//obec
$pdf->Cell(190,0,"                          ","0",1,"L");

$text=$fir_fmes;

$pdf->Cell(54,5," ","0",0,"R");$pdf->Cell(91,5,"$text","0",0,"L");

//ulica
$pdf->Cell(1,5,"                          ","0",0,"L");

$text=$fir_fuli;

$pdf->Cell(15,5," ","0",0,"R");$pdf->Cell(129,5,"$text","0",1,"L");

//s˙pis ËÌslo
$pdf->Cell(190,0,"                          ","0",1,"L");

$text=$fir_fcdm;

$pdf->Cell(54,5," ","0",0,"R");$pdf->Cell(38,5,"$text","0",0,"L");

//ËÌslo
$pdf->Cell(1,5,"                          ","0",0,"L");

$text=" ";

$pdf->Cell(14,5," ","0",0,"R");$pdf->Cell(38,5,"$text","1",0,"L");

//PS»
$pdf->Cell(1,5,"                          ","0",0,"L");

$A=substr($fir_fpsc,0,1);
$B=substr($fir_fpsc,1,1);
$C=substr($fir_fpsc,2,1);
$D=substr($fir_fpsc,3,1);
$E=substr($fir_fpsc,4,1);

$pdf->Cell(14,6," ","0",0,"R");$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(8,6," ","0",0,"R");
$pdf->Cell(7,5,"$C","0",0,"C");$pdf->Cell(8,5,"$D","0",0,"C");$pdf->Cell(7,5,"$E","0",0,"C");

//öt·t
$pdf->Cell(1,5,"                          ","0",0,"L");

$text="SR";

$pdf->Cell(22,5," ","0",0,"R");$pdf->Cell(61,5,"$text","0",1,"L");


//telefÛn
$pdf->Cell(190,0,"                          ","0",1,"L");

$text=$fir_ftel;

$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(61,5,"$text","0",0,"L");

//fax
$pdf->Cell(1,5,"                          ","0",0,"L");

$text=$fir_ffax;

$pdf->Cell(14,5," ","0",0,"R");$pdf->Cell(38,5,"$text","0",0,"L");

//email
$pdf->Cell(1,5,"                          ","0",0,"L");

$text=$fir_fem1;

$pdf->Cell(15,5," ","0",0,"R");$pdf->Cell(129,5,"$text","0",1,"L");


//banka
$pdf->Cell(190,2,"                          ","0",1,"L");

$pdf->Cell(15,5," ","0",0,"R");$pdf->Cell(92,8,"$fir_fnb1","0",0,"L");$pdf->Cell(38,8," ","0",0,"C");$pdf->Cell(84,8,"$fir_fuc1","0",0,"L");
$pdf->Cell(61,8,"$fir_fnm1","0",1,"C");


//POISTENEC 1
  $prie1=$hlavicka->prie;
  $meno1=$hlavicka->meno;
  $rdc1=$hlavicka->rdc;
  $rdk1=$hlavicka->rdk;
  $h_kzmen1=$h_kzmen;
  $h_pzmen1=$h_pzmen;
  $h_dzmen1=$h_dzmen;
  $titl1=trim($hlavicka->titl);
  if( $titl1 != '' ) $titl1=", ".$titl1;

$lenjeden = 1*$_REQUEST['lenjeden'];

if( $lenjeden == 1 )
{
$cislo_zdrv = 1*$_REQUEST['cislo_zdrv'];
$sqldoktt = "SELECT datum FROM F$kli_vxcf"."_mzdzpprerusenie "." WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY datum DESC LIMIT 1";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_dzmen=SkDatum($riaddok->datum);
  $h_dvypl=SkDatum($riaddok->datum);
  }


$cpl=1;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*15);

$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

//echo $sqldoktt;
//exit;

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie1=$riaddok->prie;
  $meno1=$riaddok->meno;
  $rdc1=$riaddok->rdc;
  $rdk1=$riaddok->rdk;
  $h_kzmen1=$riaddok->kod;
  $h_pzmen1=$riaddok->platnost;
  $h_dzmen1=SkDatum($riaddok->datum);
  $titl1=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl1 != '' ) $titl1=", ".$titl1;
}
$priemenotitl=$prie1.",".$meno1.$titl1;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,8,"                          ","0",1,"L");
$text=$rdc1.$rdk1;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(7,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");
$pdf->Cell(7,5,"$D","0",0,"C");$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(7,5,"$G","0",0,"C");
$pdf->Cell(8,5,"$H","0",0,"C");$pdf->Cell(7,5,"$I","0",0,"C");$pdf->Cell(8,5,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(15,5,"$h_kzmen1","0",0,"C");$pdf->Cell(22,5,"$h_pzmen1","0",0,"C");


$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen1;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(7,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");$pdf->Cell(8,5,"$D","0",0,"C");
$pdf->Cell(7,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");$pdf->Cell(7,5,"$H","0",1,"C");


if( $lenjeden == 1 )
{
$cpl=2;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*15);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie2=""; $meno2=""; $titl2=""; $h_kzmen2=""; $h_pzmen2="";  $h_dzmen2=""; $rdc2=""; $rdk2="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie2=$riaddok->prie;
  $meno2=$riaddok->meno;
  $rdc2=$riaddok->rdc;
  $rdk2=$riaddok->rdk;
  $h_kzmen2=$riaddok->kod;
  $h_pzmen2=$riaddok->platnost;
  $h_dzmen2=SkDatum($riaddok->datum);
  $titl2=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl2 != '' ) $titl2=", ".$titl2;

$priemenotitl=$prie2.",".$meno2.$titl2;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

//POISTENEC 2
$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc2.$rdk2;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(7,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");
$pdf->Cell(7,5,"$D","0",0,"C");$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(7,5,"$G","0",0,"C");
$pdf->Cell(8,5,"$H","0",0,"C");$pdf->Cell(7,5,"$I","0",0,"C");$pdf->Cell(8,5,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(15,5,"$h_kzmen2","0",0,"C");$pdf->Cell(22,5,"$h_pzmen2","0",0,"C");


$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen2;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(7,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");$pdf->Cell(8,5,"$D","0",0,"C");
$pdf->Cell(7,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");$pdf->Cell(7,5,"$H","0",1,"C");


//POISTENEC 3
$cpl=3;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*15);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie3=""; $meno3=""; $titl3=""; $h_kzmen3=""; $h_pzmen3="";  $h_dzmen3=""; $rdc3=""; $rdk3="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie3=$riaddok->prie;
  $meno3=$riaddok->meno;
  $rdc3=$riaddok->rdc;
  $rdk3=$riaddok->rdk;
  $h_kzmen3=$riaddok->kod;
  $h_pzmen3=$riaddok->platnost;
  $h_dzmen3=SkDatum($riaddok->datum);
  $titl3=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl3 != '' ) $titl3=", ".$titl3;

$priemenotitl=$prie3.",".$meno3.$titl3;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";


$pdf->Cell(190,1,"                          ","0",1,"L");
$text=$rdc3.$rdk3;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(7,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");
$pdf->Cell(7,5,"$D","0",0,"C");$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(7,5,"$G","0",0,"C");
$pdf->Cell(8,5,"$H","0",0,"C");$pdf->Cell(7,5,"$I","0",0,"C");$pdf->Cell(8,5,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(15,5,"$h_kzmen3","0",0,"C");$pdf->Cell(22,5,"$h_pzmen3","0",0,"C");


$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen3;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(7,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");$pdf->Cell(8,5,"$D","0",0,"C");
$pdf->Cell(7,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");$pdf->Cell(7,5,"$H","0",1,"C");


//POISTENEC 4
$cpl=4;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*15);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie4=""; $meno4=""; $titl4=""; $h_kzmen4=""; $h_pzmen4="";  $h_dzmen4=""; $rdc4=""; $rdk4="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie4=$riaddok->prie;
  $meno4=$riaddok->meno;
  $rdc4=$riaddok->rdc;
  $rdk4=$riaddok->rdk;
  $h_kzmen4=$riaddok->kod;
  $h_pzmen4=$riaddok->platnost;
  $h_dzmen4=SkDatum($riaddok->datum);
  $titl4=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl4 != '' ) $titl4=", ".$titl4;

$priemenotitl=$prie4.",".$meno4.$titl4;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc4.$rdk4;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(7,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");
$pdf->Cell(7,5,"$D","0",0,"C");$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(7,5,"$G","0",0,"C");
$pdf->Cell(8,5,"$H","0",0,"C");$pdf->Cell(7,5,"$I","0",0,"C");$pdf->Cell(8,5,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(15,5,"$h_kzmen4","0",0,"C");$pdf->Cell(22,5,"$h_pzmen4","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen4;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(7,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");$pdf->Cell(8,5,"$D","0",0,"C");
$pdf->Cell(7,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");$pdf->Cell(7,5,"$H","0",1,"C");


//POISTENEC 5
$cpl=5;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*15);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie5=""; $meno5=""; $titl5=""; $h_kzmen5=""; $h_pzmen5="";  $h_dzmen5=""; $rdc5=""; $rdk5="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie5=$riaddok->prie;
  $meno5=$riaddok->meno;
  $rdc5=$riaddok->rdc;
  $rdk5=$riaddok->rdk;
  $h_kzmen5=$riaddok->kod;
  $h_pzmen5=$riaddok->platnost;
  $h_dzmen5=SkDatum($riaddok->datum);
  $titl5=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl5 != '' ) $titl5=", ".$titl5;

$priemenotitl=$prie5.",".$meno5.$titl5;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,1,"                          ","0",1,"L");
$text=$rdc5.$rdk5;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(7,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");
$pdf->Cell(7,5,"$D","0",0,"C");$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(7,5,"$G","0",0,"C");
$pdf->Cell(8,5,"$H","0",0,"C");$pdf->Cell(7,5,"$I","0",0,"C");$pdf->Cell(8,5,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(15,5,"$h_kzmen5","0",0,"C");$pdf->Cell(22,5,"$h_pzmen5","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen5;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(7,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");$pdf->Cell(8,5,"$D","0",0,"C");
$pdf->Cell(7,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");$pdf->Cell(7,5,"$H","0",1,"C");


//POISTENEC 6
$cpl=6;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*15);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie6=""; $meno6=""; $titl6=""; $h_kzmen6=""; $h_pzmen6="";  $h_dzmen6=""; $rdc6=""; $rdk6="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie6=$riaddok->prie;
  $meno6=$riaddok->meno;
  $rdc6=$riaddok->rdc;
  $rdk6=$riaddok->rdk;
  $h_kzmen6=$riaddok->kod;
  $h_pzmen6=$riaddok->platnost;
  $h_dzmen6=SkDatum($riaddok->datum);
  $titl6=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl6 != '' ) $titl6=", ".$titl6;

$priemenotitl=$prie6.",".$meno6.$titl6;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc6.$rdk6;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(31,6," ","0",0,"R");$pdf->Cell(7,6,"$A","0",0,"C");$pdf->Cell(8,6,"$B","0",0,"C");$pdf->Cell(8,6,"$C","0",0,"C");
$pdf->Cell(7,6,"$D","0",0,"C");$pdf->Cell(8,6,"$E","0",0,"C");$pdf->Cell(8,6,"$F","0",0,"C");$pdf->Cell(7,6,"$G","0",0,"C");
$pdf->Cell(8,6,"$H","0",0,"C");$pdf->Cell(7,6,"$I","0",0,"C");$pdf->Cell(8,6,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(15,5,"$h_kzmen6","0",0,"C");$pdf->Cell(22,5,"$h_pzmen6","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen6;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(8,6,"$A","0",0,"C");$pdf->Cell(7,6,"$B","0",0,"C");$pdf->Cell(8,6,"$C","0",0,"C");$pdf->Cell(8,6,"$D","0",0,"C");
$pdf->Cell(7,6,"$E","0",0,"C");$pdf->Cell(8,6,"$F","0",0,"C");$pdf->Cell(8,6,"$G","0",0,"C");$pdf->Cell(7,6,"$H","0",1,"C");


//POISTENEC 7
$cpl=7;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*15);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie7=""; $meno7=""; $titl7=""; $h_kzmen7=""; $h_pzmen7="";  $h_dzmen7=""; $rdc7=""; $rdk7="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie7=$riaddok->prie;
  $meno7=$riaddok->meno;
  $rdc7=$riaddok->rdc;
  $rdk7=$riaddok->rdk;
  $h_kzmen7=$riaddok->kod;
  $h_pzmen7=$riaddok->platnost;
  $h_dzmen7=SkDatum($riaddok->datum);
  $titl7=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl7 != '' ) $titl7=", ".$titl7;

$priemenotitl=$prie7.",".$meno7.$titl7;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc7.$rdk7;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(7,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");
$pdf->Cell(7,5,"$D","0",0,"C");$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(7,5,"$G","0",0,"C");
$pdf->Cell(8,5,"$H","0",0,"C");$pdf->Cell(7,5,"$I","0",0,"C");$pdf->Cell(8,5,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(15,5,"$h_kzmen7","0",0,"C");$pdf->Cell(22,5,"$h_pzmen7","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen7;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(7,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");$pdf->Cell(8,5,"$D","0",0,"C");
$pdf->Cell(7,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");$pdf->Cell(7,5,"$H","0",1,"C");


//POISTENEC 8
$cpl=8;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*15);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie8=""; $meno8=""; $titl8=""; $h_kzmen8=""; $h_pzmen8="";  $h_dzmen8=""; $rdc8=""; $rdk8="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie8=$riaddok->prie;
  $meno8=$riaddok->meno;
  $rdc8=$riaddok->rdc;
  $rdk8=$riaddok->rdk;
  $h_kzmen8=$riaddok->kod;
  $h_pzmen8=$riaddok->platnost;
  $h_dzmen8=SkDatum($riaddok->datum);
  $titl8=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl8 != '' ) $titl8=", ".$titl8;

$priemenotitl=$prie8.",".$meno8.$titl8;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,1,"                          ","0",1,"L");
$text=$rdc8.$rdk8;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(7,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");
$pdf->Cell(7,5,"$D","0",0,"C");$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(7,5,"$G","0",0,"C");
$pdf->Cell(8,5,"$H","0",0,"C");$pdf->Cell(7,5,"$I","0",0,"C");$pdf->Cell(8,5,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(15,5,"$h_kzmen8","0",0,"C");$pdf->Cell(22,5,"$h_pzmen8","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen8;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(7,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");$pdf->Cell(8,5,"$D","0",0,"C");
$pdf->Cell(7,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");$pdf->Cell(7,5,"$H","0",1,"C");


//POISTENEC 9
$cpl=9;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*15);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie9=""; $meno9=""; $titl9=""; $h_kzmen9=""; $h_pzmen9="";  $h_dzmen9=""; $rdc9=""; $rdk9="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie9=$riaddok->prie;
  $meno9=$riaddok->meno;
  $rdc9=$riaddok->rdc;
  $rdk9=$riaddok->rdk;
  $h_kzmen9=$riaddok->kod;
  $h_pzmen9=$riaddok->platnost;
  $h_dzmen9=SkDatum($riaddok->datum);
  $titl9=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl9 != '' ) $titl9=", ".$titl9;

$priemenotitl=$prie9.",".$meno9.$titl9;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc9.$rdk9;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(7,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");
$pdf->Cell(7,5,"$D","0",0,"C");$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(7,5,"$G","0",0,"C");
$pdf->Cell(8,5,"$H","0",0,"C");$pdf->Cell(7,5,"$I","0",0,"C");$pdf->Cell(8,5,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(15,5,"$h_kzmen9","0",0,"C");$pdf->Cell(22,5,"$h_pzmen9","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen9;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(7,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");$pdf->Cell(8,5,"$D","0",0,"C");
$pdf->Cell(7,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");$pdf->Cell(7,5,"$H","0",1,"C");


//POISTENEC 10
$cpl=10;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*15);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie10=""; $meno10=""; $titl10=""; $h_kzmen10=""; $h_pzmen10="";  $h_dzmen10=""; $rdc10=""; $rdk10="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie10=$riaddok->prie;
  $meno10=$riaddok->meno;
  $rdc10=$riaddok->rdc;
  $rdk10=$riaddok->rdk;
  $h_kzmen10=$riaddok->kod;
  $h_pzmen10=$riaddok->platnost;
  $h_dzmen10=SkDatum($riaddok->datum);
  $titl10=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl10 != '' ) $titl10=", ".$titl10;

$priemenotitl=$prie10.",".$meno10.$titl10;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,1,"                          ","0",1,"L");
$text=$rdc10.$rdk10;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(7,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");
$pdf->Cell(7,5,"$D","0",0,"C");$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(7,5,"$G","0",0,"C");
$pdf->Cell(8,5,"$H","0",0,"C");$pdf->Cell(7,5,"$I","0",0,"C");$pdf->Cell(8,5,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(15,5,"$h_kzmen10","0",0,"C");$pdf->Cell(22,5,"$h_pzmen10","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen10;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(7,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");$pdf->Cell(8,5,"$D","0",0,"C");
$pdf->Cell(7,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");$pdf->Cell(7,5,"$H","0",1,"C");


//POISTENEC 11
$cpl=11;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*15);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie11=""; $meno11=""; $titl11=""; $h_kzmen11=""; $h_pzmen11="";  $h_dzmen11=""; $rdc11=""; $rdk11="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie11=$riaddok->prie;
  $meno11=$riaddok->meno;
  $rdc11=$riaddok->rdc;
  $rdk11=$riaddok->rdk;
  $h_kzmen11=$riaddok->kod;
  $h_pzmen11=$riaddok->platnost;
  $h_dzmen11=SkDatum($riaddok->datum);
  $titl11=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl11 != '' ) $titl11=", ".$titl11;

$priemenotitl=$prie11.",".$meno11.$titl11;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc11.$rdk11;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(7,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");
$pdf->Cell(7,5,"$D","0",0,"C");$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(7,5,"$G","0",0,"C");
$pdf->Cell(8,5,"$H","0",0,"C");$pdf->Cell(7,5,"$I","0",0,"C");$pdf->Cell(8,5,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(15,5,"$h_kzmen11","0",0,"C");$pdf->Cell(22,5,"$h_pzmen11","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen11;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(7,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");$pdf->Cell(8,5,"$D","0",0,"C");
$pdf->Cell(7,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");$pdf->Cell(7,5,"$H","0",1,"C");


//POISTENEC 12
$cpl=12;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*15);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie12=""; $meno12=""; $titl12=""; $h_kzmen12=""; $h_pzmen12="";  $h_dzmen12=""; $rdc12=""; $rdk12="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie12=$riaddok->prie;
  $meno12=$riaddok->meno;
  $rdc12=$riaddok->rdc;
  $rdk12=$riaddok->rdk;
  $h_kzmen12=$riaddok->kod;
  $h_pzmen12=$riaddok->platnost;
  $h_dzmen12=SkDatum($riaddok->datum);
  $titl12=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl12 != '' ) $titl12=", ".$titl12;

$priemenotitl=$prie12.",".$meno12.$titl12;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,1,"                          ","0",1,"L");
$text=$rdc12.$rdk12;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(7,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");
$pdf->Cell(7,5,"$D","0",0,"C");$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(7,5,"$G","0",0,"C");
$pdf->Cell(8,5,"$H","0",0,"C");$pdf->Cell(7,5,"$I","0",0,"C");$pdf->Cell(8,5,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(15,5,"$h_kzmen12","0",0,"C");$pdf->Cell(22,5,"$h_pzmen12","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen12;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(7,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");$pdf->Cell(8,5,"$D","0",0,"C");
$pdf->Cell(7,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");$pdf->Cell(7,5,"$H","0",1,"C");


//POISTENEC 13
$cpl=13;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*15);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie13=""; $meno13=""; $titl13=""; $h_kzmen13=""; $h_pzmen13="";  $h_dzmen13=""; $rdc13=""; $rdk13="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie13=$riaddok->prie;
  $meno13=$riaddok->meno;
  $rdc13=$riaddok->rdc;
  $rdk13=$riaddok->rdk;
  $h_kzmen13=$riaddok->kod;
  $h_pzmen13=$riaddok->platnost;
  $h_dzmen13=SkDatum($riaddok->datum);
  $titl13=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl13 != '' ) $titl13=", ".$titl13;

$priemenotitl=$prie13.",".$meno13.$titl13;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc13.$rdk13;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(7,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");
$pdf->Cell(7,5,"$D","0",0,"C");$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(7,5,"$G","0",0,"C");
$pdf->Cell(8,5,"$H","0",0,"C");$pdf->Cell(7,5,"$I","0",0,"C");$pdf->Cell(8,5,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(15,5,"$h_kzmen13","0",0,"C");$pdf->Cell(22,5,"$h_pzmen13","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen13;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(7,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");$pdf->Cell(8,5,"$D","0",0,"C");
$pdf->Cell(7,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");$pdf->Cell(7,5,"$H","0",1,"C");


//POISTENEC 14
$cpl=14;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*15);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie14=""; $meno14=""; $titl14=""; $h_kzmen14=""; $h_pzmen14="";  $h_dzmen14=""; $rdc14=""; $rdk14="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie14=$riaddok->prie;
  $meno14=$riaddok->meno;
  $rdc14=$riaddok->rdc;
  $rdk14=$riaddok->rdk;
  $h_kzmen14=$riaddok->kod;
  $h_pzmen14=$riaddok->platnost;
  $h_dzmen14=SkDatum($riaddok->datum);
  $titl14=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl14 != '' ) $titl14=", ".$titl14;

$priemenotitl=$prie14.",".$meno14.$titl14;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,1,"                          ","0",1,"L");
$text=$rdc14.$rdk14;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(7,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");
$pdf->Cell(7,5,"$D","0",0,"C");$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(7,5,"$G","0",0,"C");
$pdf->Cell(8,5,"$H","0",0,"C");$pdf->Cell(7,5,"$I","0",0,"C");$pdf->Cell(8,5,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(15,5,"$h_kzmen14","0",0,"C");$pdf->Cell(22,5,"$h_pzmen14","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen14;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(7,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");$pdf->Cell(8,5,"$D","0",0,"C");
$pdf->Cell(7,5,"$E","0",0,"C");$pdf->Cell(8,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");$pdf->Cell(7,5,"$H","0",1,"C");


//POISTENEC 15
$cpl=15;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*15);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie15=""; $meno15=""; $titl15=""; $h_kzmen15=""; $h_pzmen15="";  $h_dzmen15=""; $rdc15=""; $rdk15="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie15=$riaddok->prie;
  $meno15=$riaddok->meno;
  $rdc15=$riaddok->rdc;
  $rdk15=$riaddok->rdk;
  $h_kzmen15=$riaddok->kod;
  $h_pzmen15=$riaddok->platnost;
  $h_dzmen15=SkDatum($riaddok->datum);
  $titl15=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl15 != '' ) $titl15=", ".$titl15;

$priemenotitl=$prie15.",".$meno15.$titl15;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc15.$rdk15;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(31,6," ","0",0,"R");$pdf->Cell(7,6,"$A","0",0,"C");$pdf->Cell(8,6,"$B","0",0,"C");$pdf->Cell(8,6,"$C","0",0,"C");
$pdf->Cell(7,6,"$D","0",0,"C");$pdf->Cell(8,6,"$E","0",0,"C");$pdf->Cell(8,6,"$F","0",0,"C");$pdf->Cell(7,6,"$G","0",0,"C");
$pdf->Cell(8,6,"$H","0",0,"C");$pdf->Cell(7,6,"$I","0",0,"C");$pdf->Cell(8,6,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(15,5,"$h_kzmen15","0",0,"C");$pdf->Cell(22,5,"$h_pzmen15","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen15;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(8,6,"$A","0",0,"C");$pdf->Cell(7,6,"$B","0",0,"C");$pdf->Cell(8,6,"$C","0",0,"C");$pdf->Cell(8,6,"$D","0",0,"C");
$pdf->Cell(7,6,"$E","0",0,"C");$pdf->Cell(8,6,"$F","0",0,"C");$pdf->Cell(8,6,"$G","0",0,"C");$pdf->Cell(7,6,"$H","0",1,"C");
}
//koniec lenjeden == 1


$pdf->SetY(178);
//Vyplnil
$pdf->Cell(190,1,"                          ","0",1,"L");

$text=$fir_mzdt05;

$pdf->Cell(31,6," ","0",0,"R");$pdf->Cell(68,9,"$text","0",1,"L");


//Kontakt
$pdf->Cell(190,-1,"                          ","0",1,"L");

$text=$fir_mzdt04;

$pdf->Cell(31,6," ","0",0,"R");$pdf->Cell(68,8,"$text","0",1,"L");


//D·tum1
$pdf->Cell(190,-2,"                          ","0",1,"L");

$text=$h_dvypl;

$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);

$pdf->Cell(38,6," ","0",0,"R");$pdf->Cell(8,5,"$A","0",0,"C");$pdf->Cell(7,5,"$B","0",0,"C");$pdf->Cell(9,5,"$C","0",0,"C");
$pdf->Cell(7,5,"$D","0",0,"C");$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(7,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");
$pdf->Cell(7,5,"$H","0",0,"C");

//D·tum2
$pdf->Cell(1,5,"                          ","0",0,"L");

$text=$h_dvypl;

$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);

$pdf->Cell(23,6," ","0",0,"R");$pdf->Cell(7,5,"$A","0",0,"C");$pdf->Cell(8,5,"$B","0",0,"C");$pdf->Cell(8,5,"$C","0",0,"C");
$pdf->Cell(7,5,"$D","0",0,"C");$pdf->Cell(8,5,"$E","0",0,"C");$pdf->Cell(7,5,"$F","0",0,"C");$pdf->Cell(8,5,"$G","0",0,"C");
$pdf->Cell(7,5,"$H","0",1,"C");


     }

          }
///////////////////////////////////////////koniec 2408

///////////////////////////////////////////ZP 2700
if( $hlavicka->zdrv >= 2700 AND $hlavicka->zdrv <= 2799 )
          {

if( $j == 0 )
     {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/zdravpoist/zp2708/davka601s.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/zdravpoist/zp2708/davka601s.jpg',3,-1,314,230); 
}

//Strana ËÌslo/celkov˝ poËet str·n
$pdf->Cell(190,38,"                          ","0",1,"L");

$strana=1;
$pocetstran=1;
$lenjeden = 1*$_REQUEST['lenjeden'];
if( $lenjeden == 1 )
{
$strana = 1*$_REQUEST['page'];
$pocetstran = 1*$_REQUEST['pocetpage'];
}

$pdf->Cell(10,6," ","0",0,"R");$pdf->Cell(25,6,"$strana","0",0,"C");$pdf->Cell(1,6," ","0",0,"R");$pdf->Cell(24,6,"$pocetstran","0",0,"C");

//Za kalend·rny mesiac
$pdf->Cell(1,5,"                          ","0",0,"L");

$text=$kli_vmes;

$pdf->Cell(33,6,"$text","0",0,"C");$pdf->Cell(33,6," ","0",0,"R");

//Rok
$pdf->Cell(1,5,"                          ","0",0,"L");

$text="$kli_vrok";

$pdf->Cell(32,6,"$text","0",1,"C");

//»Ìslo platiteæa
$pdf->Cell(190,-7,"                          ","0",1,"L");

/////////////NACITANIE CISLA PLATITELA,NAZVU Z CISELNIKA ZP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv=$hlavicka->zdrv ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $platitel=$riaddok->vsy;
  $nazzdrv=$riaddok->nzdr;
  }

$text=$platitel;

$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);

$pdf->Cell(237,6," ","0",0,"R");$pdf->Cell(4,8,"$A","0",0,"C");$pdf->Cell(4,8,"$B","0",0,"C");$pdf->Cell(5,8,"$C","0",0,"C");
$pdf->Cell(3,8,"$D","0",0,"C");$pdf->Cell(5,8,"$E","0",0,"C");$pdf->Cell(4,8,"$F","0",0,"C");$pdf->Cell(4,8,"$G","0",0,"C");
$pdf->Cell(4,8,"$H","0",0,"C");$pdf->Cell(4,8,"$I","0",0,"C");$pdf->Cell(4,8,"$J","0",1,"C");


//Druh ozn·menia - novÈ - opravnÈ
$pdf->Cell(190,5,"                          ","0",1,"L");

$nove="x"; $opravne="";
if( $h_kdrh == 'O' ) { $nove=""; $opravne="x"; }


$pdf->Cell(161,6," ","0",0,"R");$pdf->Cell(5,6,"$nove","0",0,"C");$pdf->Cell(14,6," ","0",0,"R");$pdf->Cell(4,6,"$opravne","0",1,"R");


//ObchodnÈ meno
$pdf->Cell(190,8,"                          ","0",1,"L");

$text=$fir_fnaz;

$pdf->Cell(55,6," ","0",0,"R");$pdf->Cell(170,6,"$text","0",0,"L");

//Pr·vna forma
$pdf->Cell(1,5,"                          ","0",0,"L");

$text=$fir_uctt02;

$pdf->Cell(16,6," ","0",0,"R");$pdf->Cell(48,6,"$text","0",1,"L");


//RodnÈ ËÌslo
$pdf->SetFont('arial','',12);
$pdf->Cell(190,10,"                          ","0",1,"L");

$text=$fordc;

$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);

$pdf->Cell(11,6," ","0",0,"R");$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");
$pdf->Cell(6,6,"$B","0",0,"C");$pdf->Cell(6,6,"$C","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");
$pdf->Cell(5,6,"$D","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$E","0",0,"C");
$pdf->Cell(6,6,"$F","0",0,"C");$pdf->Cell(5,6," ","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");
$pdf->Cell(6,6,"$H","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$I","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");
$pdf->Cell(5,6,"$J","0",0,"C");


//»Ìslo povolenia k pobytu
$pdf->Cell(1,5,"                          ","0",0,"L");

$text=" ";

$pdf->Cell(71,6,"$text","0",0,"L");

//DI» / I» DPH
$pdf->Cell(1,5,"                          ","0",0,"L");

$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$K=substr($fir_fdic,10,1);
$L=substr($fir_fdic,11,1);


$pdf->Cell(6,6,"$A","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");
$pdf->Cell(5,6,"$B","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");
$pdf->Cell(6,6,"$D","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");
$pdf->Cell(5,6,"$F","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");
$pdf->Cell(6,6,"$H","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$I","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");
$pdf->Cell(5,6,"$J","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$K","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");
$pdf->Cell(5,6,"$L","0",0,"C");$pdf->Cell(7,6," ","0",0,"C");


//I»O
$pdf->Cell(1,5,"                          ","0",0,"L");

$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);
$I=substr($fir_fico,8,1);

$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");
$pdf->Cell(6,6,"$B","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");
$pdf->Cell(5,6,"$D","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");
$pdf->Cell(6,6,"$F","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");
$pdf->Cell(5,6,"$H","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$I","0",1,"C");

$pdf->SetFont('arial','',10);


//Obec
$pdf->Cell(190,2,"                          ","0",1,"L");

$text=$fir_fmes;

$pdf->Cell(68,6," ","0",0,"C");$pdf->Cell(107,6,"$text","0",0,"L");

//Ulica
$pdf->Cell(1,5,"                          ","0",0,"L");

$text=$fir_fuli;

$pdf->Cell(6,6," ","0",0,"C");$pdf->Cell(108,6,"$text","0",1,"L");

//S˙pis. ËÌslo
$pdf->Cell(190,2,"                          ","0",1,"L");

$text=$fir_fcdm;

$pdf->Cell(75,6," ","0",0,"C");$pdf->Cell(54,6,"$text","0",0,"L");

//»Ìslo
$pdf->Cell(1,5,"                          ","0",0,"L");

$text=" ";

$pdf->Cell(6,6," ","0",0,"C");$pdf->Cell(39,6,"$text","0",0,"L");

//PS»
$pdf->Cell(1,5,"                          ","0",0,"L");

$A=substr($fir_fpsc,0,1);
$B=substr($fir_fpsc,1,1);
$C=substr($fir_fpsc,2,1);
$D=substr($fir_fpsc,3,1);
$E=substr($fir_fpsc,4,1);

$pdf->Cell(12,6," ","0",0,"C");$pdf->Cell(6,6,"$A","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");
$pdf->Cell(5,6,"$B","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");$pdf->Cell(8,6," ","0",0,"C");
$pdf->Cell(5,6,"$D","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");

//ät·t
$pdf->Cell(1,5,"                          ","0",0,"L");

$text="SR";

$pdf->Cell(4,6," ","0",0,"C");$pdf->Cell(59,6,"$text","0",1,"L");

//TelefÛn
$pdf->Cell(190,2,"                          ","0",1,"L");

$text=$fir_ftel;

$pdf->Cell(21,6," ","0",0,"C");$pdf->Cell(71,6,"$text","0",0,"L");

//Fax
$pdf->Cell(1,5,"                          ","0",0,"L");

$text=$fir_ffax;

$pdf->Cell(5,6," ","0",0,"C");$pdf->Cell(77,6,"$text","0",0,"L");

//E-mail
$pdf->Cell(1,5,"                          ","0",0,"L");

$text=$fir_fem1;

$pdf->Cell(8,6," ","0",0,"C");$pdf->Cell(106,6,"$text","0",1,"L");


//banka
$pdf->Cell(190,1,"                          ","0",1,"L");

$pdf->Cell(43,6," ","0",0,"C");$pdf->Cell(86,7,"$fir_fnb1","0",0,"L");$pdf->Cell(13,6," ","0",0,"C");$pdf->Cell(28,7," ","0",0,"L");
$pdf->Cell(13,6," ","0",0,"C");$pdf->Cell(68,7,"$fir_fuc1","0",0,"L");$pdf->Cell(14,6," ","0",0,"C");$pdf->Cell(25,7,"$fir_fnm1","0",1,"L");


//POISTENEC 1
  $prie1=$hlavicka->prie;
  $meno1=$hlavicka->meno;
  $rdc1=$hlavicka->rdc;
  $rdk1=$hlavicka->rdk;
  $h_kzmen1=$h_kzmen;
  $h_pzmen1=$h_pzmen;
  $h_dzmen1=$h_dzmen;
  $titl1=trim($hlavicka->titl);
  if( $titl1 != '' ) $titl1=", ".$titl1;

$lenjeden = 1*$_REQUEST['lenjeden'];

if( $lenjeden == 1 )
{
$cislo_zdrv = 1*$_REQUEST['cislo_zdrv'];
$sqldoktt = "SELECT datum FROM F$kli_vxcf"."_mzdzpprerusenie "." WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY datum DESC LIMIT 1";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_dzmen=SkDatum($riaddok->datum);
  $h_dvypl=SkDatum($riaddok->datum);
  }


$cpl=1;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*6);

$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

//echo $sqldoktt;
//exit;

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie1=$riaddok->prie;
  $meno1=$riaddok->meno;
  $rdc1=$riaddok->rdc;
  $rdk1=$riaddok->rdk;
  $h_kzmen1=$riaddok->kod;
  $h_pzmen1=$riaddok->platnost;
  $h_dzmen1=SkDatum($riaddok->datum);
  $titl1=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl1 != '' ) $titl1=", ".$titl1;
}
$priemenotitl=$prie1.",".$meno1.$titl1;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";


$pdf->Cell(190,16,"                          ","0",1,"L");
$text=$rdc1.$rdk1;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(21,6," ","0",0,"C");$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$B","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$C","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$D","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$F","0",0,"C");
$pdf->Cell(5,6," ","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$H","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$I","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$J","0",0,"C");

$titl="";
if( $hlavicka->titl != '' ) $titl=", ".$hlavicka->titl;
$pdf->Cell(1,6," ","0",0,"C");
$pdf->Cell(83,5,"$hlavicka->prie, $hlavicka->meno$titl","0",0,"L");$pdf->Cell(16,5,"$h_kzmen","0",0,"C");$pdf->Cell(52,5,"$h_pzmen","0",0,"C");

//$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(40,5,"$hlavicka->prie","0",0,"L");$pdf->Cell(1,5,",","0",0,"R");$pdf->Cell(27,5,"$hlavicka->meno","0",0,"L");
//$pdf->Cell(1,5,",","0",0,"R");$pdf->Cell(14,5,"$hlavicka->titl","0",0,"L");$pdf->Cell(16,5,"kÛd","0",0,"C");$pdf->Cell(52,5,"zmena","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen1;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$B","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$D","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$E","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$F","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$H","0",1,"C");


if( $lenjeden == 1 )
{
//POISTENEC 2
$cpl=2;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*6);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie2=""; $meno2=""; $titl2=""; $h_kzmen2=""; $h_pzmen2="";  $h_dzmen2=""; $rdc2=""; $rdk2="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie2=$riaddok->prie;
  $meno2=$riaddok->meno;
  $rdc2=$riaddok->rdc;
  $rdk2=$riaddok->rdk;
  $h_kzmen2=$riaddok->kod;
  $h_pzmen2=$riaddok->platnost;
  $h_dzmen2=SkDatum($riaddok->datum);
  $titl2=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl2 != '' ) $titl2=", ".$titl2;

$priemenotitl=$prie2.",".$meno2.$titl2;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc2.$rdk2;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(21,6," ","0",0,"C");$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$B","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$C","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$D","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$F","0",0,"C");
$pdf->Cell(5,6," ","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$H","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$I","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(16,5,"$h_kzmen2","0",0,"C");$pdf->Cell(52,5,"$h_pzmen2","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen2;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$B","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$D","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$E","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$F","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$H","0",1,"C");

//POISTENEC 3
$cpl=3;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*6);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie3=""; $meno3=""; $titl3=""; $h_kzmen3=""; $h_pzmen3="";  $h_dzmen3=""; $rdc3=""; $rdk3="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie3=$riaddok->prie;
  $meno3=$riaddok->meno;
  $rdc3=$riaddok->rdc;
  $rdk3=$riaddok->rdk;
  $h_kzmen3=$riaddok->kod;
  $h_pzmen3=$riaddok->platnost;
  $h_dzmen3=SkDatum($riaddok->datum);
  $titl3=trim($riaddok->titl);;
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl3 != '' ) $titl3=", ".$titl3;

$priemenotitl=$prie3.",".$meno3.$titl3;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc3.$rdk3;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(21,6," ","0",0,"C");$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$B","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$C","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$D","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$F","0",0,"C");
$pdf->Cell(5,6," ","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$H","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$I","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(16,5,"$h_kzmen3","0",0,"C");$pdf->Cell(52,5,"$h_pzmen3","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen3;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$B","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$D","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$E","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$F","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$H","0",1,"C");

//POISTENEC 4
$cpl=4;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*6);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie4=""; $meno4=""; $titl4=""; $h_kzmen4=""; $h_pzmen4="";  $h_dzmen4=""; $rdc4=""; $rdk4="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie4=$riaddok->prie;
  $meno4=$riaddok->meno;
  $rdc4=$riaddok->rdc;
  $rdk4=$riaddok->rdk;
  $h_kzmen4=$riaddok->kod;
  $h_pzmen4=$riaddok->platnost;
  $h_dzmen4=SkDatum($riaddok->datum);
  $titl4=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl4 != '' ) $titl4=", ".$titl4;

$priemenotitl=$prie4.",".$meno4.$titl4;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc4.$rdk4;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(21,6," ","0",0,"C");$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$B","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$C","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$D","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$F","0",0,"C");
$pdf->Cell(5,6," ","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$H","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$I","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(16,5,"$h_kzmen4","0",0,"C");$pdf->Cell(52,5,"$h_pzmen4","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen4;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$B","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$D","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$E","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$F","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$H","0",1,"C");

//POISTENEC 5
$cpl=5;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*6);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie5=""; $meno5=""; $titl5=""; $h_kzmen5=""; $h_pzmen5="";  $h_dzmen5=""; $rdc5=""; $rdk5="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie5=$riaddok->prie;
  $meno5=$riaddok->meno;
  $rdc5=$riaddok->rdc;
  $rdk5=$riaddok->rdk;
  $h_kzmen5=$riaddok->kod;
  $h_pzmen5=$riaddok->platnost;
  $h_dzmen5=SkDatum($riaddok->datum);
  $titl5=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl5 != '' ) $titl5=", ".$titl5; 

$priemenotitl=$prie5.",".$meno5.$titl5;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc5.$rdk5;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(21,6," ","0",0,"C");$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$B","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$C","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$D","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$F","0",0,"C");
$pdf->Cell(5,6," ","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$H","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$I","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(16,5,"$h_kzmen5","0",0,"C");$pdf->Cell(52,5,"$h_pzmen5","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen5;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$B","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$D","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$E","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$F","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$H","0",1,"C");

//POISTENEC 6
$cpl=6;
$cstr=$strana-1;
$icr=$cpl-1+($cstr*6);
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdzpprerusenie ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdzpprerusenie.oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE ume = $kli_vume AND cpl >= 0  AND xzdrv = $cislo_zdrv ORDER BY cpl";

$prie6=""; $meno6=""; $titl6=""; $h_kzmen6=""; $h_pzmen6="";  $h_dzmen6=""; $rdc6=""; $rdk6="";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,$icr))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie6=$riaddok->prie;
  $meno6=$riaddok->meno;
  $rdc6=$riaddok->rdc;
  $rdk6=$riaddok->rdk;
  $h_kzmen6=$riaddok->kod;
  $h_pzmen6=$riaddok->platnost;
  $h_dzmen6=SkDatum($riaddok->datum);
  $titl6=trim($riaddok->titl);
  //$h_dzmen=SkDatum($riaddok->datum);
  }
  if( $titl6 != '' ) $titl6=", ".$titl6;

$priemenotitl=$prie6.",".$meno6.$titl6;
if( strlen($priemenotitl) < 4 ) $priemenotitl="";

$pdf->Cell(190,0,"                          ","0",1,"L");
$text=$rdc6.$rdk6;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(21,6," ","0",0,"C");$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$B","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$C","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$D","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$F","0",0,"C");
$pdf->Cell(5,6," ","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$H","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$I","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$J","0",0,"C");

$pdf->Cell(84,5,"$priemenotitl","0",0,"L");$pdf->Cell(16,5,"$h_kzmen6","0",0,"C");$pdf->Cell(52,5,"$h_pzmen6","0",0,"C");

$pdf->Cell(1,5,"                          ","0",0,"L");
$text=$h_dzmen6;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,3,1);
$D=substr($text,4,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$B","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$D","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(6,6,"$E","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$F","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$H","0",1,"C");
}
//koniec lenjeden != 1

$pdf->SetY(179);
//Vyplnil
$pdf->Cell(190,5,"                          ","0",1,"L");

$text=$fir_mzdt05;

$pdf->Cell(21,5," ","0",0,"R");$pdf->Cell(80,8,"$text","0",0,"L");$pdf->Cell(1,5," ","0",1,"R");

//Kontakt
$pdf->Cell(190,4,"                          ","0",1,"L");

$text=$fir_mzdt04;

$pdf->Cell(21,5," ","0",0,"R");$pdf->Cell(80,8,"$text","0",0,"L");$pdf->Cell(1,5," ","0",1,"R");


//D·tum1
$pdf->Cell(190,7,"                          ","0",1,"L");

$text=$h_dvypl;



$pdf->Cell(19,6," ","0",0,"C");$pdf->Cell(30,6,"$text","0",0,"L");$pdf->Cell(1,6," ","0",0,"C");


//D·tum2
$pdf->Cell(1,5,"                          ","0",0,"L");

$text=$h_dvypl;

$pdf->Cell(60,6," ","0",0,"C");$pdf->Cell(30,6,"$text","0",0,"L");$pdf->Cell(1,6," ","0",0,"C");

     }

          }
///////////////////////////////////////////koniec 2700

}
$i = $i + 1;
$j = $j + 1;
  }

$pdf->Output("../tmp/d601s.$kli_uzid.pdf");

?>

<script type="text/javascript">
  var okno = window.open("../tmp/d601s.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalmesx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzaltrnx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalkunx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

}
///////////////////////////////////////////////////KONIEC PDF 601 copern=40
?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
