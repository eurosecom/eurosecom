<!doctype html>
<HTML>
<?php
do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;

$uziv = include("../uziv.php");
if( !$uziv ) exit;

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
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=1;


$prepoc = 1*$_REQUEST['prepoc'];
$vsetkyprepocty=0;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//priezvisko,meno,titul FO
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";

$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
if ( $fir_uctt03 == 999 )
{
$fnazov = $fir_riadok->dmeno." ".$fir_riadok->dprie." ".$fir_riadok->dtitl;
$dadresa = $fir_riadok->duli." "." ".$fir_riadok->dcdm." ".$fir_riadok->dmes;
}
if( $fir_uctt03 != 999 )
{
$fadresa = $fir_fuli." ".$fir_fcdm." ".$fir_fmes;
$fnazov = $fir_fnaz;
}



// zapis upravene udaje
if ( $copern == 23 )
    {


$da1 = strip_tags($_REQUEST['da1']);
$da1sql=SqlDatum($da1);

$da2 = strip_tags($_REQUEST['da2']);
$da2sql=SqlDatum($da2);




$uprtxt = "UPDATE F$kli_vxcf"."_mzdoznam_student SET ".
" da1='$da1sql', da2='$da2sql' ".
" WHERE oc = $cislo_oc"; 


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

//prac.subor a subor vytvorenych 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sql = "SELECT oc FROM F".$kli_vxcf."_mzdoznam_student";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdoznam_student';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   druh         DECIMAL(10,0) DEFAULT 0,
   da1          DATE,
   da2          DATE,
   konx1        DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdoznam_student'.$sqlt;
$vytvor = mysql_query("$vsql");

}
//koniec vytvorenie oznamenie


$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzdoznam_student";
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzdoznam_student";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");




$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_mzdoznam_student WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $jepotvrd=1;
  }
if( $jepotvrd == 0 ) $subor=1;

//pre rocne vytvor pracovny subor
if( $subor == 1 )
{

$ttvv = "INSERT INTO F$kli_vxcf"."_mzdprcvypl$kli_uzid ( druh,oc ) VALUES  ( 1, '$cislo_oc' )";
$ttqq = mysql_query("$ttvv");

//uloz do priznania
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdoznam_student WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdoznam_student".
" SELECT * FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid." WHERE oc = $cislo_oc ".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$prepoc=1;
}
//koniec pracovneho suboru 


//nacitaj udaje pre upravu
if ( $copern == 20 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdoznam_student".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdoznam_student.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdoznam_student.oc = $cislo_oc AND konx1 = 0 ORDER BY F$kli_vxcf"."_mzdoznam_student.oc";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$oc = $fir_riadok->oc;
$meno = $fir_riadok->meno;
$prie = $fir_riadok->prie;
$titl = $fir_riadok->titl;
$rodne = $fir_riadok->rdc."/".$fir_riadok->rdk;
$h_rdc = $fir_riadok->rdc;
$h_rdk = $fir_riadok->rdk;
$zuli = $fir_riadok->zuli." ".$fir_riadok->zcdm." ".$fir_riadok->zmes;

//echo "meno".$meno;

$da1 = $fir_riadok->da1;
$da1sk=SkDatum($da1);
$da2 = $fir_riadok->da2;
$da2sk=SkDatum($da2);
    }
//koniec nacitania
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css" type="text/css">
 <link rel="stylesheet" href="../css/tlaciva.css" type="text/css">
<title>EuroSecom - Oznámenie študenta</title>
<style>
form input[type=text] {
  height: 16px;
  line-height: 16px;
  font-size: 14px;
}
</style>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height-20;
var sirkawic = screen.width-10;

<?php
//uprava
  if ( $copern == 20 )
  { 
?>
  function ObnovUI()
  {


   document.formv1.da1.value = '<?php echo "$da1sk";?>';
   document.formv1.da2.value = '<?php echo "$da2sk";?>';

  }
<?php
//koniec uprava
  }
?>

<?php
  if ( $copern != 20 )
  { 
?>
  function ObnovUI()
  {
  }
<?php
  }
?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function prevOC(prevoc)
  {
   window.open('oznamenie_student.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=' + prevoc + '', '_self');
  }
  function nextOC(nextoc)
  {
   window.open('oznamenie_student.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=' + nextoc + '', '_self');
  }
  function UpravZamestnanca()
  {
   window.open('zamestnanci.php?sys=<?php echo $sys; ?>&copern=8&page=1&cislo_oc=<?php echo $cislo_oc;?>&h_oc=<?php echo $cislo_oc;?>', '_blank','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes');
  }
  function Poucenie()
  {
   window.open('../dokumenty/mzdy_potvrdenia/oznamenie_studenta_v14/oznamenie_studenta_v14_poucenie.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function tlacpdf(oc)
  {
   window.open('../mzdy/oznamenie_student.php?cislo_oc=' + oc + '&copern=10&drupoh=1&page=1&subor=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
</script>

<?php
//osobne cislo prepinanie
$novy=0;
if ( $novy == 0 )
{
$prev_oc=$cislo_oc-1;
$next_oc=$cislo_oc+1;
if ( $prev_oc == 0 ) $prev_oc=1;
if ( $next_oc > 9999 ) $next_oc=9999;
$nasieloc=0;
$i=0;
while ( $i <= 9999 AND $nasieloc == 0 )
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
?>
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
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
  </tr>
  <tr>
   <td class="header">Oznámenie a èestné vyhlásenie študenta - <span class="subheader"><?php echo "$oc $meno $prie"; ?></span>
<?php if ( $novy == 0 ) { ?>
    <img src='../obr/prev.png' onclick="prevOC(<?php echo $prev_oc; ?>);" title="Os.è. <?php echo $prev_oc; ?>" class="navoc-icon">
    <img src='../obr/next.png' onclick="nextOC(<?php echo $next_oc; ?>);" title="Os.è. <?php echo $next_oc; ?>" class="navoc-icon">
<?php                   } ?>
   </td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/info_blue_icon.png" onclick="Poucenie();" title="Pouèenie na vyplnenie" class="btn-form-tool">
     <img src="../obr/ikony/user_blue_icon.png" onclick="UpravZamestnanca();" title="Upravi údaje o zamestnancovi" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="tlacpdf(<?php echo $cislo_oc; ?>);" title="Zobrazi v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="oznamenie_student.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana;?>">
 <INPUT type="submit" id="uloz" name="uloz" value="Uloži zmeny" class="btn-top-formsave" style="top:4px;">
<img src="../dokumenty/mzdy_potvrdenia/oznamenie_studenta_v14/oznamenie_studenta_v14.jpg"
 alt="tlaèivo Oznámenie a èestné vyhlásenie k dohode o brigádnickej práci študentov 175kB" class="form-background">

<!-- zamestnanec -->
<span class="text-echo" style="top:296px; left:195px;"><?php echo $prie; ?></span>
<span class="text-echo" style="top:296px; left:559px;"><?php echo $meno; ?></span>
<span class="text-echo" style="top:296px; left:776px;"><?php echo $titl; ?></span>
<span class="text-echo" style="top:323px; left:206px;"><?php echo $rodne; ?></span>
<span class="text-echo" style="top:349px; left:290px;"><?php echo $zuli; ?></span>

<!-- zamestnavatel -->
<span class="text-echo" style="top:430px; left:290px;"><?php echo $fnazov; ?></span>
<span class="text-echo" style="top:450px; left:290px;"><?php echo $dadresa; ?></span>
<span class="text-echo" style="top:480px; left:290px;"><?php echo $fadresa; ?></span>

<!-- oznamujem -->
<input type="text" name="da2" id="da2" onkeyup="CiarkaNaBodku(this);"
 style="top:540px; left:160px; width:90px;"/>

<!-- dna -->
<input type="text" name="da1" id="da1" onkeyup="CiarkaNaBodku(this);"
 style="top:840px; left:160px; width:90px;"/>

</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav
?>

<?php
/////////////////////////////////////////////////VYTLAC OZNAMENIE
if ( $copern == 10 )
{

if ( File_Exists("../tmp/oznamenie.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/oznamenie.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdoznam_student".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdoznam_student.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdoznam_student.oc = $cislo_oc AND konx1 = 0 ORDER BY F$kli_vxcf"."_mzdoznam_student.oc";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$pdf->Addpage();
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);

if ( File_Exists('../dokumenty/mzdy_potvrdenia/oznamenie_studenta_v14/oznamenie_studenta_v14.jpg') )
{
$pdf->Image('../dokumenty/mzdy_potvrdenia/oznamenie_studenta_v14/oznamenie_studenta_v14.jpg',0,0,210,297);
}
$pdf->SetY(10);
$pdf->SetFont('arial','',10);

//zamestnanec
$pdf->Cell(190,57," ","$rmc1",1,"L");
$pdf->Cell(34,6," ","$rmc1",0,"R");$pdf->Cell(71,5,"$hlavicka->prie","$rmc",0,"L");
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(40,5,"$hlavicka->meno","$rmc",0,"L");
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(28,5,"$hlavicka->titl","$rmc",1,"L");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(37,6," ","$rmc1",0,"R");$pdf->Cell(25,5,"$hlavicka->rdc / $hlavicka->rdk","$rmc",1,"L");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(55,6," ","$rmc1",0,"R");$pdf->Cell(135,5,"$hlavicka->zuli $hlavicka->zcdm ","$rmc",1,"L");

//zamestnavatel
$pdf->Cell(190,13," ","$rmc1",1,"L");
$fnazov = $fir_fnaz;
if ( $fir_uctt03 == 999 ) $fnazov = $fir_riadok->dmeno." ".$fir_riadok->dprie." ".$fir_riadok->dtitl;
$pdf->Cell(29,6," ","$rmc1",0,"R");$pdf->Cell(161,5,"$fnazov","$rmc",1,"L");
$pdf->Cell(190,1," ","$rmc1",1,"L");
if ( $fir_uctt03 != 999 ) $dadresa = " ";
$pdf->Cell(112,6," ","$rmc1",0,"R");$pdf->Cell(78,5,"$dadresa","$rmc",1,"L");
$pdf->Cell(190,1," ","$rmc1",1,"L");
if ( $fir_uctt03 == 999 ) $fadresa = " ";
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(87,6,"$fadresa","$rmc",1,"L");

//uzatvoril dna
$pdf->Cell(190,9," ","$rmc1",1,"L");
$text=SKDatum($hlavicka->da2);
if ( $text =='00.00.0000' ) $text="";
$pdf->Cell(25,6," ","$rmc1",0,"R");$pdf->Cell(33,5,"$text","$rmc",1,"C");

//dna
$pdf->Cell(190,67," ","$rmc1",1,"L");
$text=SKDatum($hlavicka->da1);
if ( $text =='00.00.0000' ) $text="";
$pdf->Cell(26,6," ","$rmc1",0,"R");$pdf->Cell(28,7,"$text","$rmc",1,"C");

}
$i = $i + 1;
  }
$pdf->Output("../tmp/oznamenie.$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/oznamenie.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA ROCNEHO
?>







<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
$cislista = include("mzd_lista_norm.php");
} while (false);
?>
</BODY>
</HTML>
