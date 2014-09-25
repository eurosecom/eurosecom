<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 100;
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

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];


$cit_nas = include("../cis/citaj_nas.php");

$zmenu = 1*$_REQUEST['zmenu'];
if( $zmenu == 1 )
{
session_start();    
$_SESSION['kli_vxcf'] = $vyb_xcf;
$_SESSION['kli_nxcf'] = $vyb_naz;
$_SESSION['kli_vume'] = $vyb_ume;
$_SESSION['kli_vrok'] = $vyb_rok;
$_SESSION['kli_vduj'] = $vyb_duj;

$kli_vduj=$vyb_duj;
$kli_vxcf=$vyb_xcf;
$kli_nxcf=$vyb_naz;
$kli_vume=$vyb_ume;
$kli_vrok=$vyb_rok;
}

$sqlfir = "SELECT * FROM klienti WHERE id_klienta = $kli_uzid ";
//echo $sqlfir;
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $cislo_oc = 1*$fir_riadok->cis1; }

$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $cislo_oc ";
//echo $sqlfir;
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $priemeno = $fir_riadok->prie." ".$fir_riadok->meno; }

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));  
$dnessql=SqlDatum($dnes);

$bolprichod=0;
$bolodchod=0;

//prichod,odchod
if( $copern == 1051 OR $copern == 1052 )
{

$ipadx=$_SERVER["REMOTE_ADDR"];

$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));  
$dnessql=SqlDatum($dnes);

$pole = explode(".", $dnes);
$kli_vmes=$pole[1];
$kli_vrok=$pole[2];
$kli_vume=$kli_vmes.".".$kli_vrok;

$dnestim = Date ("d.m.Y H:i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if( $copern == 1051 ) { $h_dmxa=1; $bolprichod=1; $prichodch="PrÌchod osË.".$cislo_oc." ".$dnestim; }
if( $copern == 1052 ) { $h_dmxa=2; $bolodchod=1; $prichodch="Odchod osË.".$cislo_oc." ".$dnestim; }

$sqty = "INSERT INTO F$kli_vxcf"."_mzddochadzka ( ume,oc,dmxa,dmxb,daod,dado,dnixa,dnixb,hodxa,hodxb,xtxt,datn )".
" VALUES ( '$kli_vume', '$cislo_oc', '$h_dmxa', '0', '$dnessql', '$dnessql', '0', '0', '0', '$h_hdo', '$ipadx', now() );"; 

//echo $sqty;
$ulozene = mysql_query("$sqty");

$copern=20;
}
//koniec prichod,odchod

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Doch·dzka Mini</title>
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
    
  function Prichod(h_oc)
  { 

  window.open('../mzdy/dochadzkamini.php?cislo_oc=<?php echo $cislo_oc; ?>&copern=1051&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function Odchod(h_oc)
  { 

  window.open('../mzdy/dochadzkamini.php?cislo_oc=<?php echo $cislo_oc; ?>&copern=1052&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }


</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom - Dochadzkov˝ systÈm - <?php echo $priemeno; ?></td>
<td align="right"></td>
</tr>
</table>
<br />


<br /><br />

<table class=user border=0 width="500" >
<tr class=user>

<td width="25%">
<center>
<a href="#" onClick="Prichod(<?php echo $cislo_oc; ?>);"><img border=2 src='../obr/import.png' 
style="width:50; height:50;" title="OznaËiù prÌchod" > </a>
<a href="#" onClick="Prichod(<?php echo $cislo_oc; ?>);"><font size="1"><br />PrÌchod</font></a></center>


<td width="25%">
<center>
<a href="#" onClick="Odchod(<?php echo $cislo_oc; ?>);"><img border=2 src='../obr/export.png' 
style="width:50; height:50;" title="OznaËiù odchod" > </a>
<a href="#" onClick="Odchod(<?php echo $cislo_oc; ?>);"><font size="1"><br />Odchod</font></a></center>


<td width="25%">
<center>
<a href="#" onClick="window.open('../mzdy/dochadzka.php?copern=1&drupoh=1&page=1&subor=0&zmenu=1&niemini=1','_self' )"><img border=2 src='../obr/hodiny.jpg' 
style="width:50; height:50;" title="OznaËiù neprÌtomnosù" > </a>
<a href="#" onClick="window.open('../mzdy/dochadzka.php?copern=1&drupoh=1&page=1&subor=0&zmenu=1&niemini=1','_self' )"><font size="1"><br />NeprÌtomnosù</font></a></center>


<td width="25%">
<center>
<a href="#" onClick="window.open('../hses.php','_self' )"><img border=2 src='../obr/zmaz.png' 
style="width:50; height:50;" title="Odhl·siù sa z Doch·dzkovÈho systÈmu" > </a>
<a href="#" onClick="window.open('../hses.php','_self' )"><font size="1"><br />Odhl·siù</font></a></center>

</tr>
</table>

<br /><br />

<?php

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzddochadzka WHERE oc = $cislo_oc AND daod = '$dnessql' AND dmxa <= 2 ORDER BY cplxb DESC ";
//echo $sqltt;
//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);

$skdatum=SkDatum($riadok->daod);
$prichod=$riadok->datn;
$odchod=$riadok->datn;
if( $riadok->dmxa == 1 ) { $odchod=""; }
if( $riadok->dmxa == 2 ) { $prichod=""; }

if( $i == 0 )
  {
?>

<table>
<tr>
<td class="bmenu" align="left" width="20%" >D·tum</td>
<td class="bmenu" align="right" width="20%" >PrÌchod</td>
<td class="bmenu" align="right" width="20%" >Odchod</td>
</tr>

<?php
  }
?>

<tr>
<td class="hvstup"><?php echo $skdatum; ?></td>
<td class="hvstup" align="right"><?php echo $prichod; ?></td>
<td class="hvstup" align="right"><?php echo $odchod; ?></td>
</tr>

<?php
}
$i = $i + 1;

  }
?>
</table>


<?php


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
