<HTML>
<?php
$sys = 'MZD';
$urov = 2000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$uprav = 1*$_REQUEST['uprav'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];

//echo $h_obdp;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];


require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;


//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");



//ulozenie noveho 
if ( $copern == 315 )
    {

$h_dat = $_REQUEST['h_dat'];
$h_odch = 1*$_REQUEST['h_odch'];
$h_pri = 1*$_REQUEST['h_pri'];


$dlzka=strlen($h_dat);
if( $dlzka < 3 AND $dlzka >= 1 ) { $h_dat=1*$h_dat; $h_dat=$h_dat.".".$kli_vmes.".".$kli_vrok; }

$datumsql=SqlDatum($h_dat);

$ipadx=$_SERVER["REMOTE_ADDR"];

$polep = explode(".", $h_pri);
$hodp=1*$polep[0];
$minp=1*$polep[1];
$prichod=$hodp.":".$minp.":00";

$poleo = explode(".", $h_odch);
$hodo=1*$poleo[0];
$mino=1*$poleo[1];
$odchod=$hodo.".".$mino.":00";

$sqlfir = "SELECT * FROM kalendar WHERE dat = '$datumsql' ";
$tovk = mysql_query("$sqlfir");
$okdatum = 1*mysql_num_rows($tovk);

if( $h_pri > 0 AND $okdatum == 1 ) { 

$datnsql=$datumsql." ".$prichod;

$sqty = "INSERT INTO F$kli_vxcf"."_mzddochadzka ( ume,oc,dmxa,dmxb,daod,dado,dnixa,dnixb,hodxa,hodxb,xtxt,datn )".
" VALUES ( '$kli_vume', '$cislo_oc', '1', '0', '$datumsql', '$datumsql', '0', '0', '0', '', '$ipadx', '$datnsql' );"; 
$ulozene = mysql_query("$sqty");

                 }

if( $h_odch > 0 AND $okdatum == 1 ) { 

$datnsql=$datumsql." ".$odchod;

$sqty = "INSERT INTO F$kli_vxcf"."_mzddochadzka ( ume,oc,dmxa,dmxb,daod,dado,dnixa,dnixb,hodxa,hodxb,xtxt,datn )".
" VALUES ( '$kli_vume', '$cislo_oc', '2', '0', '$datumsql', '$datumsql', '0', '0', '0', '', '$ipadx', '$datnsql' );"; 
$ulozene = mysql_query("$sqty");

                 }


$copern=1;
$uprav=0;

    }
//koniec ulozenia 



//nacitanie
if ( $copern >= 1  )
      {
$cislo_cpl = 1*strip_tags($_REQUEST['cislo_cpl']);
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzddochadzka WHERE cplxb = $cislo_cpl  ".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_datn = $riadok->datn;

$pole = explode(" ", $h_datn);

$datum=SkDatum($pole[0]);

$polet = explode(":", $pole[1]);
$hod=$polet[0];
$min=$polet[1];

$prichod=$hod.".".$min;
$odchod=$hod.".".$min;
if( $riadok->dmxa == 1 ) { $odchod=""; }
if( $riadok->dmxa == 2 ) { $prichod=""; }


$h_pri = $prichod;
$h_odch = $odchod;
$h_dat = $datum;


  } 

if( $copern == 316 ) { $sqltt = "DELETE FROM F$kli_vxcf"."_mzddochadzka WHERE cplxb = $cislo_cpl  "; $sql = mysql_query("$sqltt"); }

$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $cislo_oc ORDER BY oc LIMIT 1";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $meno=$riaddok->meno;
 $prie=$riaddok->prie;
 }

       }

//koniec uprava nacitanie

if( $copern == 316 ) { $copern=1; }

?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Dochádzka</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;

//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola datumu
    function KontrolaDatum(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Ciarka na bodku
    function CiarkaNaBodku(Vstup)
    {
    Vstup.value=Vstup.value.replace(",",".");
    }


    function VyberVstup()
    {
    document.formv1.h_dat.select();
    document.formv1.h_dat.focus();
    document.formv1.uloz.disabled = true;
    }

    function ObnovUI()
    {

    document.formv1.h_dat.value = '<?php echo "$h_dat";?>';
    document.formv1.h_pri.value = '<?php echo "$h_pri";?>';
    document.formv1.h_odch.value = '<?php echo "$h_odch";?>';
 
    }

    function Povol_uloz()
    {
    var okvstup=1;

    if ( document.formv1.h_pri.value == '' && document.formv1.h_odch.value == '' ) okvstup=0;

    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; return (true); }
    if ( okvstup == 0 ) { document.formv1.uloz.disabled = true; return (false) ; }

    }

function ZmazPolozku(cpl)
                {
var cislo_cpl = cpl;

window.open('dochadzka_edi.php?copern=316&page=1&cislo_cpl=' + cislo_cpl + '&drupoh=<?php echo $drupoh; ?>&cislo_oc=<?php echo $cislo_oc;?>&uprav=0',
 '_self' );
                }

function DatEnter(e)
                {

  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy

  if(k == 13 ){

    document.formv1.h_pri.select();
    document.formv1.h_pri.focus();
              }
                }

function PriEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy

  if(k == 13 ){

    document.formv1.h_odch.select();
    document.formv1.h_odch.focus();
              }
                }

function OdchEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy

  if(k == 13 ){

    var okvstup=1;
    if ( document.formv1.h_pri.value == '' && document.formv1.h_odch.value == '' ) { okvstup=0; }

    if ( okvstup == 1 ) { document.forms.formv1.submit(); return (true); }
              }
                }
  
</script>
</HEAD>
<BODY class="white" id="white" onload="ObnovUI(); VyberVstup();" >



<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Dochádzka <?php echo $kli_vume; ?> - <?php echo $prie; ?> <?php echo $meno; ?></td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />




<?php
////////////////////////////////////////////////////////////////uprava 
if( $copern == 1 )           
{

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzddochadzka WHERE cplxb > 0 AND dmxa <= 2 AND dmxa >= 1 AND ume = $kli_vume ORDER BY daod,dmxa,cplxb";
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

?>
<table class="vstup" width="100%" >
<tr>
<td class="hmenu" width="10%" >Dátum
<td class="hmenu" width="10%" align="right" >Príchod
<td class="hmenu" width="10%" align="right" >Odchod
<th class="hmenu" width="5%" >Edi/Del
<td class="hmenu" width="65%" align="right" > 
</tr>
<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$pole = explode(" ", $riadok->datn);

$datum=SkDatum($pole[0]);

$polet = explode(":", $pole[1]);
$hod=$polet[0];
$min=$polet[1];

$prichod=$hod.".".$min;
$odchod=$hod.".".$min;
if( $riadok->dmxa == 1 ) { $odchod=""; }
if( $riadok->dmxa == 2 ) { $prichod=""; }
?>
<tr>

<td class="fmenu" ><?php echo $datum;?></td>
<td class="fmenu" align="right" ><?php echo $prichod;?></td>
<td class="fmenu" align="right" ><?php echo $odchod;?></td>
<td class="fmenu" width="5%" >

<a href="#" onClick="ZmazPolozku(<?php echo $riadok->cplxb;?>);">
<img src='../obr/zmaz.png' width=15 height=10 border=0 alt='Vymaza/Upravi riadok' ></a>

</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formv1" class="obyc" method="post" action="dochadzka_edi.php?copern=315&drupoh=<?php echo $drupoh;?>&cislo_oc=<?php echo $cislo_oc;?>" >
<tr>

<td class="hmenu"><input type="text" name="h_dat" id="h_dat" size="7" onKeyDown="return DatEnter(event.which)" onkeyup="KontrolaCisla(this);"/>

<td class="hmenu"><input type="text" name="h_pri" id="h_pri" size="7"onKeyDown="return PriEnter(event.which)" onkeyup="KontrolaCisla(this);"/>

<td class="hmenu"><input type="text" name="h_odch" id="h_odch" size="7" onKeyDown="return OdchEnter(event.which)" onkeyup="KontrolaCisla(this);"/>

</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloži" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>
</FORM>
</table>

<?php
}
////////////////////////////////////////////////////////////////koniec uprava 
?>

<?php
// celkovy koniec dokumentu

       } while (false);
?>
</BODY>
</HTML>
