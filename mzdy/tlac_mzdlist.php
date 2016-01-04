<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 2000;
$clsm = 820;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$cislo_dok = 1*strip_tags($_REQUEST['cislo_dok']);
$kopia_dok = 1*strip_tags($_REQUEST['kopia_dok']);



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

if( $copern == 10 )
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdkunvyber'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzddmnvyber'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzddatavyber'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   meno         VARCHAR(40) NOT NULL,
   prie         VARCHAR(40) NOT NULL,
   pom          DECIMAL(10,0) DEFAULT 0,
   hx3          DECIMAL(1,0) DEFAULT 0,
   konx         INT DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdkunvyber'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$sql = "INSERT INTO F".$kli_vxcf."_mzdkunvyber".$kli_uzid." SELECT oc,meno,prie,pom,0,0 FROM F".$kli_vxcf."_mzdkun WHERE oc >= 0";
$vysledek = mysql_query("$sql");

$sqlt = <<<mzdprc
(
   dm           INT(7) DEFAULT 0,
   nzdm         VARCHAR(40) NOT NULL,
   br           DECIMAL(10,0) DEFAULT 0,
   hx4          DECIMAL(1,0) DEFAULT 0,
   konx         INT DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzddmnvyber'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$sql = "INSERT INTO F".$kli_vxcf."_mzddmnvyber".$kli_uzid." SELECT dm,nzdm,br,0,0 FROM F".$kli_vxcf."_mzddmn WHERE dm >= 0";
$vysledek = mysql_query("$sql");

$sqlt = <<<mzdprc
(
   ocx          INT(7) DEFAULT 0,
   ume          DECIMAL(7,4) DEFAULT 0,
   dmx          INT(7) DEFAULT 0,
   hodx         DECIMAL(10,2) DEFAULT 0,
   dnix         DECIMAL(10,2) DEFAULT 0,
   eurx         DECIMAL(10,2) DEFAULT 0,
   prho         DECIMAL(10,4) DEFAULT 0,
   prdn         DECIMAL(10,4) DEFAULT 0,
   konx         INT DEFAULT 0,
   konx1        INT DEFAULT 0,
   konx2        INT DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzddatavyber'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


}
//koniec prac.subor

//oznacenie polozky dm 100/199
    if ( $copern == 6001 )
    {
$h_oc = 1*$_REQUEST['h_oc'];
$h_hx4 = 1*$_REQUEST['h_hx4'];
$h_dmn = 1*$_REQUEST['h_dmn'];

$podmdm=" dm > 100 AND dm <= 199 ";
$dm=$h_dmn;
if( $dm >= 200 AND $dm <= 299 ) $podmdm=" dm > 200 AND dm <= 299 ";
if( $dm >= 300 AND $dm <= 399 ) $podmdm=" dm > 300 AND dm <= 399 ";
if( $dm >= 400 AND $dm <= 499 ) $podmdm=" dm > 400 AND dm <= 499 ";
if( $dm >= 500 AND $dm <= 599 ) $podmdm=" dm > 500 AND dm <= 599 ";
if( $dm >= 800 AND $dm <= 899 ) $podmdm=" dm > 800 AND dm <= 899 ";
if( $dm >= 900 AND $dm <= 999 ) $podmdm=" dm > 900 AND dm <= 999 ";


$upravttt = "UPDATE F$kli_vxcf"."_mzddmnvyber".$kli_uzid." SET hx4=1 WHERE $podmdm ";
$upravene = mysql_query("$upravttt");

$copern=10;
    }
//koniec oznacenie polozky pom

//oznacenie polozky pom
    if ( $copern == 5001 )
    {
$h_oc = 1*$_REQUEST['h_oc'];
$h_hx3 = 1*$_REQUEST['h_hx3'];
$h_pom = 1*$_REQUEST['h_pom'];


$upravttt = "UPDATE F$kli_vxcf"."_mzdkunvyber".$kli_uzid." SET hx3=1 WHERE pom='$h_pom' ";
$upravene = mysql_query("$upravttt");

$copern=10;
    }
//koniec oznacenie polozky pom

//oznacenie polozky kun
    if ( $copern == 3001 )
    {
$h_oc = 1*$_REQUEST['h_oc'];
$h_hx3 = 1*$_REQUEST['h_hx3'];

$hx3=1;
if( $h_hx3 == 1 ) { $hx3=0; }

$upravttt = "UPDATE F$kli_vxcf"."_mzdkunvyber".$kli_uzid." SET hx3=$hx3 WHERE oc='$h_oc' ";

if( $h_oc == 0 ) { $upravttt = "UPDATE F$kli_vxcf"."_mzdkunvyber".$kli_uzid." SET hx3=0 WHERE oc >= 0 "; }
if( $h_oc == 10000 ) { $upravttt = "UPDATE F$kli_vxcf"."_mzdkunvyber".$kli_uzid." SET hx3=1 WHERE oc >= 0 "; }
$upravene = mysql_query("$upravttt");

$copern=10;
    }
//koniec oznacenie polozky kun

//oznacenie polozky dmn
    if ( $copern == 4001 )
    {
$h_dm = 1*$_REQUEST['h_dm'];
$h_hx4 = 1*$_REQUEST['h_hx4'];

$hx4=1;
if( $h_hx4 == 1 ) { $hx4=0; }

$upravttt = "UPDATE F$kli_vxcf"."_mzddmnvyber".$kli_uzid." SET hx4=$hx4 WHERE dm='$h_dm' ";

if( $h_dm == 0 ) { $upravttt = "UPDATE F$kli_vxcf"."_mzddmnvyber".$kli_uzid." SET hx4=0 WHERE dm >= 0 "; }
if( $h_dm == 10000 ) { $upravttt = "UPDATE F$kli_vxcf"."_mzddmnvyber".$kli_uzid." SET hx4=1 WHERE dm >= 0 "; }
$upravene = mysql_query("$upravttt");

$copern=10;
    }
//koniec oznacenie polozky dmn


//tlac
    if ( $copern == 20 )
    {
$h_obdp = 1*$_REQUEST['h_obdp'];
$h_obdk = 1*$_REQUEST['h_obdk'];
$pole = explode(".", $kli_vume);
$mesiac=$pole[0];
$rok=$pole[1];
$h_umep=$h_obdp.".".$rok;
$h_umek=$h_obdk.".".$rok;

$sumall = 1*$_REQUEST['sumall'];
$sumoc = 1*$_REQUEST['sumoc'];
$sumdm = 1*$_REQUEST['sumdm'];
$sumume = 0;
$prhod = 1*$_REQUEST['prhod'];
$prden = 1*$_REQUEST['prden'];
$lensum = 1*$_REQUEST['lensum'];

if (File_Exists ("../tmp/tlacmzl$kli_uzid.pdf") ) { $soubor = unlink("../tmp/tlacmzl$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$sirka_vyska="210,200";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//echo "priprava ok";
//exit;
    }
//koniec tlac

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>TlaË z MzdovÈho listu</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }

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
    
    function VyberDmn( dmx, pagex, hx4x )
    {

var h_dm = dmx;
var h_page = pagex;
var h_hx4 = hx4x;

window.open('../mzdy/tlac_mzdlist.php?h_dm=' + h_dm + '&copern=4001&drupoh=<?php echo $drupoh;?>&page=1&h_hx4=' + h_hx4 + '&xxx=1', '_self' );


    }

    function VyberKun( ocx, pagex, hx3x )
    {

var h_oc = ocx;
var h_page = pagex;
var h_hx3 = hx3x;

window.open('../mzdy/tlac_mzdlist.php?h_oc=' + h_oc + '&copern=3001&drupoh=<?php echo $drupoh;?>&page=1&h_hx3=' + h_hx3 + '&xxx=1', '_self' );


    }

    function VyberPom( ocx, pomx, hx3x )
    {

var h_oc = ocx;
var h_pom = pomx;
var h_hx3 = hx3x;

window.open('../mzdy/tlac_mzdlist.php?h_oc=' + h_oc + '&copern=5001&drupoh=<?php echo $drupoh;?>&h_pom=' + h_pom + '&h_hx3=' + h_hx3 + '&xxx=1', '_self' );


    }

    function VyberDmn1( fffx, dmnx, hx4x )
    {

var h_dmn = dmnx;
var h_hx4 = hx4x;

window.open('../mzdy/tlac_mzdlist.php?h_dmn=' + h_dmn + '&copern=6001&drupoh=<?php echo $drupoh;?>&h_hx4=' + h_hx4 + '&xxx=1', '_self' );


    }

function TlacPdf()
                {
var h_obdp = document.forms.formp2.h_obdp.value;
var h_obdk = document.forms.formp2.h_obdk.value;
  var sumall = 0;
  if( document.formp2.sumall.checked ) sumall=1;
  var sumoc = 0;
  if( document.formp2.sumoc.checked ) sumoc=1;
  var sumdm = 0;
  if( document.formp2.sumdm.checked ) sumdm=1;
  var sumume = 0;
  var prhod = 0;
  if( document.formp2.prhod.checked ) prhod=1;
  var prden = 0;
  if( document.formp2.prden.checked ) prden=1;
  var lensum = 0;
  if( document.formp2.prhod.checked ) lensum=1;

window.open('../mzdy/tlac_mzdlist.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&sumall=' + sumall + '&sumoc=' + sumoc + '&sumdm=' + sumdm +  '&sumume=' + sumume +  '&prhod=' + prhod +  '&prden=' + prden +  '&lensum=' + lensum + '&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  TlaË z MzdovÈho listu

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//vyberova podmienka
    if ( $copern == 10 )
    {
?>

<table class="fmenu" width="100%" >
<FORM name="formp2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" colspan="2" >
TLA»Iç <img src='../obr/tlac.png'  width=15 height=15 border=0 title='VytlaËiù zostavu' onclick='TlacPdf();' >

<td class="bmenu" colspan="4" >

Obdobie

<select size="1" name="h_obdp" id="h_obdp" >
<option value="1" >od 01.<?php echo $kli_vrok;?></option>
<option value="2" >od 02.<?php echo $kli_vrok;?></option>
<option value="3" >od 03.<?php echo $kli_vrok;?></option>
<option value="4" >od 04.<?php echo $kli_vrok;?></option>
<option value="5" >od 05.<?php echo $kli_vrok;?></option>
<option value="6" >od 06.<?php echo $kli_vrok;?></option>
<option value="7" >od 07.<?php echo $kli_vrok;?></option>
<option value="8" >od 08.<?php echo $kli_vrok;?></option>
<option value="9" >od 09.<?php echo $kli_vrok;?></option>
<option value="10" >od 10.<?php echo $kli_vrok;?></option>
<option value="11" >od 11.<?php echo $kli_vrok;?></option>
<option value="12" >od 12.<?php echo $kli_vrok;?></option>
</select>

<select size="1" name="h_obdk" id="h_obdk" >
<option value="1" >do 01.<?php echo $kli_vrok;?></option>
<option value="2" >do 02.<?php echo $kli_vrok;?></option>
<option value="3" >do 03.<?php echo $kli_vrok;?></option>
<option value="4" >do 04.<?php echo $kli_vrok;?></option>
<option value="5" >do 05.<?php echo $kli_vrok;?></option>
<option value="6" >do 06.<?php echo $kli_vrok;?></option>
<option value="7" >do 07.<?php echo $kli_vrok;?></option>
<option value="8" >do 08.<?php echo $kli_vrok;?></option>
<option value="9" >do 09.<?php echo $kli_vrok;?></option>
<option value="10" >do 10.<?php echo $kli_vrok;?></option>
<option value="11" >do 11.<?php echo $kli_vrok;?></option>
<option value="12" >do 12.<?php echo $kli_vrok;?></option>
</select>

<td class="bmenu" colspan="9" >

 SumaAll<input type="checkbox" name="sumall" value="1" />

 SumaOc<input type="checkbox" name="sumoc" value="1" />

 SumaDm<input type="checkbox" name="sumdm" value="1" />

 PriemerHod<input type="checkbox" name="prhod" value="1" />

 PriemerDen<input type="checkbox" name="prden" value="1" />

 LenSumy<input type="checkbox" name="lensum" value="1" />

<tr>
<td class="bmenu" width="5%" >
 <img src='../obr/zmazuplne.png'  width=12 height=12 border=0 title='Zruöiù oznaËenie vöetk˝ch poloûiek OS»' onclick='VyberKun(0, 1, 0);' >

 <img src='../obr/ok.png'  width=12 height=12 border=0 title='OznaËenie vöetk˝ch poloûiek OS»' onclick='VyberKun(10000, 1, 0);' >

<td class="bmenu" width="5%" > <td class="bmenu" width="5%" > <td class="bmenu" width="5%" >  
<td class="bmenu" width="5%" ><td class="bmenu" width="5%" > <td class="bmenu" width="5%" > 
<td class="bmenu" width="5%" >  

 <img src='../obr/zmazuplne.png'  width=12 height=12 border=0 title='Zruöiù oznaËenie vöetk˝ch poloûiek DM' onclick='VyberDmn(0, 1, 0);' >

 <img src='../obr/ok.png'  width=12 height=12 border=0 title='OznaËenie vöetk˝ch poloûiek DM' onclick='VyberDmn(10000, 1, 0);' >

<td class="bmenu" width="5%" ><td class="bmenu" width="5%" >  
<td class="bmenu" width="5%" ><td class="bmenu" width="5%" > <td class="bmenu" width="5%" > <td class="bmenu" width="5%" >  
<td class="bmenu" width="5%" ><td class="bmenu" width="5%" > <td class="bmenu" width="5%" > <td class="bmenu" width="5%" >  
<td class="bmenu" width="5%" ><td class="bmenu" width="5%" > 
</tr>

<tr>
<td class="bmenu" colspan="1" align="right">osË
<td class="bmenu" colspan="4" align="left">priezvisko menu
<td class="bmenu" colspan="1" align="right">pr.pomer
<td class="bmenu" colspan="1" > 
<td class="bmenu" colspan="1" align="right">dm 
<td class="bmenu" colspan="4" >n·zov dm
<td class="bmenu" colspan="1" >br
<td class="bmenu" colspan="1" > 
<td class="bmenu" colspan="6" > 
</tr>


<?php
if ( $copern == 10 )
  {
$sqlkunttt = "SELECT *  FROM F$kli_vxcf"."_mzdkunvyber".$kli_uzid." ORDER BY oc ";
//echo $sqlkunttt;

$sqlkun = mysql_query("$sqlkunttt");

$sqldmnttt = "SELECT *  FROM F$kli_vxcf"."_mzddmnvyber".$kli_uzid." ORDER BY dm ";
//echo $sqldmnttt;

$sqldmn = mysql_query("$sqldmnttt");

  }
  

// celkom poloziek
$pockun = mysql_num_rows($sqlkun);
$pocdmn = mysql_num_rows($sqldmn);


$pocriadkov=$pockun;
if( $pocdmn > $pockun ) { $pocriadkov=$pocdmn; }

$iriadok=0;
$page=1;

   while ($iriadok < $pocriadkov )
   {

$oc="";
$meno="";
$prie="";
$pom="";
$hx3="";

$dm="";
$nzdm="";
$br="";

  if (@$zaznam=mysql_data_seek($sqlkun,$iriadok))
  {
$riadokkun=mysql_fetch_object($sqlkun);
$oc=$riadokkun->oc;
$meno=$riadokkun->meno;
$prie=$riadokkun->prie;
$pom=$riadokkun->pom;
$hx3=$riadokkun->hx3;

  }

  if (@$zaznam=mysql_data_seek($sqldmn,$iriadok))
  {
$riadokdmn=mysql_fetch_object($sqldmn);
$dm=$riadokdmn->dm;
$nzdm=$riadokdmn->nzdm;
$br=$riadokdmn->br;
$hx4=$riadokdmn->hx4;

  }

?>


<tr>
<td class="fmenu" colspan="1" align="right"><?php echo $oc;?>
<td class="fmenu" colspan="4" align="left">

<?php
if( $oc != "" )
        {
?>  

 <input type="checkbox" name="vyberKun<?php echo $oc;?>" value="1" onclick="VyberKun(<?php echo $oc;?>, <?php echo $page;?>, <?php echo $hx3;?>);"/>
<?php
if ( $hx3 == 1 )
   {
?>
<script type="text/javascript">
document.formp2.vyberKun<?php echo $oc;?>.checked = "checked";
</script>
<?php
   }

        }
?>

<?php echo $prie;?> <?php echo $meno;?>
<td class="fmenu" colspan="1" align="right">

<?php
if( $pom != "" )
        {
?>  

 <img src='../obr/ok.png'  width=12 height=12 border=0 title='OznaËenie vöetk˝ch poloûiek OS» s pomerom=<?php echo $pom;?>' onclick='VyberPom(10000, <?php echo $pom;?>, 0);' >
<?php

        }
?>

<?php echo $pom;?>
<td class="bmenu" colspan="1" > 
<td class="fmenu" colspan="1" >

<?php
if( $dm != "" )
        {
$dmn1="1";
if( $dm >= 200 AND $dm <= 299 ) $dmn1="2";
if( $dm >= 300 AND $dm <= 399 ) $dmn1="3";
if( $dm >= 400 AND $dm <= 499 ) $dmn1="4";
if( $dm >= 500 AND $dm <= 599 ) $dmn1="5";
if( $dm >= 800 AND $dm <= 899 ) $dmn1="8";
if( $dm >= 900 AND $dm <= 999 ) $dmn1="9";
?>  
 <img src='../obr/ok.png'  width=12 height=12 border=0 title='OznaËenie vöetk˝ch poloûiek DMN, ktorÈ zaËÌnaj˙ na <?php echo $dmn1;?>' onclick='VyberDmn1(10000, <?php echo $dm;?>, 0);' >
<?php

        }
?>

<?php echo $dm;?> 
<td class="fmenu" colspan="4" >

<?php
if( $dm != "" )
        {
?>  

 <input type="checkbox" name="vyberDmn<?php echo $dm;?>" value="1" onclick="VyberDmn(<?php echo $dm;?>, <?php echo $page;?>, <?php echo $hx4;?>);"/>
<?php
if ( $hx4 == 1 )
   {
?>
<script type="text/javascript">
document.formp2.vyberDmn<?php echo $dm;?>.checked = "checked";
</script>
<?php
   }

        }
?>

<?php echo $nzdm;?>
<td class="fmenu" colspan="1" ><?php echo $br;?> 

<td class="bmenu" colspan="1" > 
<td class="bmenu" colspan="6" > 
</tr>

<?php

$iriadok = $iriadok + 1;
   }

?>

</FORM>
</table>
<br clear=left>

<?php
//koniec vyberova podmienka
//  if ( $copern == 10 )
    }
?>


<?php
//tlac
    if ( $copern == 20 )
    {
?>

<?php


$vsql = 'TRUNCATE F'.$kli_vxcf.'_mzddatavyber'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzddatavyber".$kli_uzid.
" SELECT oc,ume,dm,hod,dni,kc,0,0,0,0,0 FROM F$kli_vxcf"."_mzdzalvy ".
" WHERE ume >= $h_umep AND ume <= $h_umek AND dm > 0 AND dm < 9000 ".
"";
$dsql = mysql_query("$dsqlt");

//nechaj len vybrane oc
$dsqlt = "UPDATE F$kli_vxcf"."_mzddatavyber".$kli_uzid.",F$kli_vxcf"."_mzdkunvyber".$kli_uzid." ".
" SET F$kli_vxcf"."_mzddatavyber".$kli_uzid.".konx=999 ".
" WHERE F$kli_vxcf"."_mzddatavyber".$kli_uzid.".ocx=F$kli_vxcf"."_mzdkunvyber".$kli_uzid.".oc AND F$kli_vxcf"."_mzdkunvyber".$kli_uzid.".hx3 = 1 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzddatavyber".$kli_uzid." ".
" WHERE konx=0 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzddatavyber".$kli_uzid." SET konx=0 ";
$dsql = mysql_query("$dsqlt");

//nechaj len vybrane dm
$dsqlt = "UPDATE F$kli_vxcf"."_mzddatavyber".$kli_uzid.",F$kli_vxcf"."_mzddmnvyber".$kli_uzid." ".
" SET F$kli_vxcf"."_mzddatavyber".$kli_uzid.".konx=999 ".
" WHERE F$kli_vxcf"."_mzddatavyber".$kli_uzid.".dmx=F$kli_vxcf"."_mzddmnvyber".$kli_uzid.".dm AND F$kli_vxcf"."_mzddmnvyber".$kli_uzid.".hx4 = 1 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzddatavyber".$kli_uzid." ".
" WHERE konx=0 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzddatavyber".$kli_uzid." SET konx=0 ";
$dsql = mysql_query("$dsqlt");

if( $sumoc == 1 )
{
$sqltxx = <<<mzdprc
(
   ocx          INT(7) DEFAULT 0,
   ume          DECIMAL(7,4) DEFAULT 0,
   dmx          INT(7) DEFAULT 0,
   hodx         DECIMAL(10,2) DEFAULT 0,
   dnix         DECIMAL(10,2) DEFAULT 0,
   eurx         DECIMAL(10,2) DEFAULT 0,
   prho         DECIMAL(10,4) DEFAULT 0,
   prdn         DECIMAL(10,4) DEFAULT 0,
   konx         INT DEFAULT 0,
   konx1        INT DEFAULT 0,
   konx2        INT DEFAULT 0
);
mzdprc;

//echo "idem";
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzddatavyber".$kli_uzid.
" SELECT ocx,0,0,SUM(hodx),SUM(dnix),SUM(eurx),0,0,10,0,0 FROM F$kli_vxcf"."_mzddatavyber".$kli_uzid." ".
" WHERE ocx >= 0 GROUP BY ocx ".
"";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
//exit;
}

if( $sumall == 1 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzddatavyber".$kli_uzid.
" SELECT 0,0,0,SUM(hodx),SUM(dnix),SUM(eurx),0,0,20,20,0 FROM F$kli_vxcf"."_mzddatavyber".$kli_uzid." ".
" WHERE konx = 0 GROUP BY konx2 ".
"";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
//exit;
}

if( $sumdm == 1 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzddatavyber".$kli_uzid.
" SELECT 99999,0,dmx,SUM(hodx),SUM(dnix),SUM(eurx),0,0,30,0,0 FROM F$kli_vxcf"."_mzddatavyber".$kli_uzid." ".
" WHERE konx = 0 GROUP BY dmx ".
"";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
//exit;
}

if( $prhod == 1 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_mzddatavyber".$kli_uzid." SET prho=eurx/hodx WHERE hodx != 0";
$dsql = mysql_query("$dsqlt");
}
if( $prden == 1 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_mzddatavyber".$kli_uzid." SET prdn=eurx/dnix WHERE dnix != 0";
$dsql = mysql_query("$dsqlt");
}

if( $lensum == 1 )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzddatavyber".$kli_uzid." ".
" WHERE konx=0 AND konx1 = 0".
"";
$dsql = mysql_query("$dsqlt");
}

$trd="konx1,ocx,ume,dmx";
if( $sumoc == 1 ) $trd="konx1,ocx,konx,ume,dmx";

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzddatavyber$kli_uzid ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzddatavyber".$kli_uzid.".ocx=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzddmn".
" ON F$kli_vxcf"."_mzddatavyber".$kli_uzid.".dmx=F$kli_vxcf"."_mzddmn.dm".
" ORDER BY $trd ";
//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//echo $sqltt;
//exit;

$strana=0;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);
 

//hlavicka strany
if ( $j == 0 )
     {
$strana=$strana+1;

$pdf->AddPage();
$pdf->SetFont('arial','',8);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

$pdf->Cell(90,4,"Zostava $h_umep / $h_umek ","0",0,"L");$pdf->Cell(0,4,"strana $strana","0",1,"R");

$pdf->Cell(11,4,"Ume","1",0,"R");$pdf->Cell(40,4,"Priezvisko Meno, OsË","1",0,"L");
$pdf->Cell(10,4,"DM","1",0,"R");$pdf->Cell(30,4,"N·zov ","1",0,"L");

$pdf->Cell(15,4,"Dni","1",0,"R");$pdf->Cell(15,4,"Hodiny","1",0,"R");$pdf->Cell(20,4,"EUR","1",0,"R");

if( $prden == 1 )
{
$pdf->Cell(15,4,"Eur/deÚ","1",0,"R");
}

if( $prhod == 1 )
{
$pdf->Cell(15,4,"Eur/hod","1",0,"R");
}


$pdf->Cell(0,4," ","1",1,"L");

//echo "hlavicka ok";

     }
//koniec hlavicky j=0

$dnix=$riadok->dnix;
if( $dnix == 0 ) $dnix="";
$hodx=$riadok->hodx;
if( $hodx == 0 ) $hodx="";

if ( $riadok->konx == 0 )
     {

$pdf->Cell(11,4,"$riadok->ume","0",0,"R");$pdf->Cell(40,4,"$riadok->prie $riadok->meno, $riadok->ocx","0",0,"L");
$pdf->Cell(10,4,"$riadok->dmx","0",0,"R");$pdf->Cell(30,4,"$riadok->nzdm","0",0,"L");

$pdf->Cell(15,4,"$dnix","0",0,"R");$pdf->Cell(15,4,"$hodx","0",0,"R");$pdf->Cell(20,4,"$riadok->eurx","0",0,"R");

if( $prden == 1 )
{
$pdf->Cell(15,4,"$riadok->prdn","0",0,"R");
}

if( $prhod == 1 )
{
$pdf->Cell(15,4,"$riadok->prho","0",0,"R");
}

$pdf->Cell(0,4," ","0",1,"L");

     }

if ( $riadok->konx == 10 )
     {

$pdf->Cell(11,4,"SPOLU","T",0,"R");$pdf->Cell(40,4,"$riadok->prie $riadok->meno, $riadok->ocx","T",0,"L");
$pdf->Cell(10,4," ","T",0,"R");$pdf->Cell(30,4," ","T",0,"L");

$pdf->Cell(15,4,"$dnix","T",0,"R");$pdf->Cell(15,4,"$hodx","T",0,"R");$pdf->Cell(20,4,"$riadok->eurx","T",0,"R");

if( $prden == 1 )
{
$pdf->Cell(15,4,"$riadok->prdn","T",0,"R");
}

if( $prhod == 1 )
{
$pdf->Cell(15,4,"$riadok->prho","T",0,"R");
}

$pdf->Cell(0,4," ","T",1,"L");

     }

if ( $riadok->konx == 20 )
     {

$pdf->Cell(91,4,"SPOLU Celkom","1",0,"R");

$pdf->Cell(15,4,"$dnix","1",0,"R");$pdf->Cell(15,4,"$hodx","1",0,"R");$pdf->Cell(20,4,"$riadok->eurx","1",0,"R");

if( $prden == 1 )
{
$pdf->Cell(15,4,"$riadok->prdn","1",0,"R");
}

if( $prhod == 1 )
{
$pdf->Cell(15,4,"$riadok->prho","1",0,"R");
}

$pdf->Cell(0,4," ","1",1,"L");

     }

if ( $riadok->konx == 30 )
     {

$pdf->Cell(11,4,"SPOLU","T",0,"R");$pdf->Cell(40,4," ","T",0,"L");
$pdf->Cell(10,4,"$riadok->dmx","T",0,"R");$pdf->Cell(30,4,"$riadok->nzdm","T",0,"L");

$pdf->Cell(15,4,"$dnix","T",0,"R");$pdf->Cell(15,4,"$hodx","T",0,"R");$pdf->Cell(20,4,"$riadok->eurx","T",0,"R");

if( $prden == 1 )
{
$pdf->Cell(15,4,"$riadok->prdn","T",0,"R");
}

if( $prhod == 1 )
{
$pdf->Cell(15,4,"$riadok->prho","T",0,"R");
}

$pdf->Cell(0,4," ","T",1,"L");

     }

//echo "telo ok";

}
$i = $i + 1;
$j = $j + 1;
if( $j > 39 ) $j=0;

  }

$pdf->Output("../tmp/tlacmzl.$kli_uzid.pdf"); 
//exit;
?> 


<script type="text/javascript">
  var okno = window.open("../tmp/tlacmzl.<?php echo $kli_uzid; ?>.pdf","_self");
</script>



<?php
//koniec tlac
//  if ( $copern == 20 )
    }
?>

<br /><br />
<?php
// celkovy koniec dokumentu

$cislista = include("mzd_lista.php");

       } while (false);
?>
</BODY>
</HTML>
