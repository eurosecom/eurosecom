<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 2000;
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

$citfir = include("../cis/citaj_fir.php");
//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$drupoh = 1*strip_tags($_REQUEST['drupoh']);
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$cislo_cpld = 1*$_REQUEST['cislo_cpld'];


$faktury="fakdod";
if( $drupoh == 1 ) { $faktury="fakodb"; }

//echo $copern;
//echo $cislo_cpld;

$h_dok = strip_tags($_REQUEST['h_dok']);
$h_dou = strip_tags($_REQUEST['h_dou']);
$h_dau = strip_tags($_REQUEST['h_dau']);
$h_dpp = strip_tags($_REQUEST['h_dpp']);
$h_hou = strip_tags($_REQUEST['h_hou']);
$h_hz2 = strip_tags($_REQUEST['h_hz2']);
$h_hd2 = strip_tags($_REQUEST['h_hd2']);
$h_hz1 = strip_tags($_REQUEST['h_hz1']);
$h_hd1 = strip_tags($_REQUEST['h_hd1']);
$h_dausql=SqlDatum($h_dau); 
$h_dppsql=SqlDatum($h_dpp); 

//datova tabulka
$sql = "SELECT druh FROM F$kli_vxcf"."_uctfakuhrdph ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{

$sql = "DROP TABLE F".$kli_vxcf."_uctfakuhrdph ";
$vysledek = mysql_query("$sql");

$sqlt = <<<banvyp
(
   cpld        int not null auto_increment,
   dok         DECIMAL(10,0) DEFAULT 0,
   druh        DECIMAL(10,0) DEFAULT 0,
   dppx        DECIMAL(2,0) DEFAULT 0,
   prx7        DECIMAL(4,0) DEFAULT 0,
   PRIMARY KEY(cpld)
);
banvyp;

$sql = "CREATE TABLE F".$kli_vxcf."_uctfakuhrdph ".$sqlt;
$vysledek = mysql_query("$sql");

}
$sql = "SELECT dou FROM F$kli_vxcf"."_uctfakuhrdph ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctfakuhrdph ADD hou DECIMAL(10,2) DEFAULT 0 AFTER prx7 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctfakuhrdph ADD hz1 DECIMAL(10,2) DEFAULT 0 AFTER prx7 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctfakuhrdph ADD hd1 DECIMAL(10,2) DEFAULT 0 AFTER prx7 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctfakuhrdph ADD hz2 DECIMAL(10,2) DEFAULT 0 AFTER prx7 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctfakuhrdph ADD hd2 DECIMAL(10,2) DEFAULT 0 AFTER prx7 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctfakuhrdph ADD dau DATE NOT NULL AFTER prx7 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctfakuhrdph ADD dpp DATE NOT NULL AFTER prx7 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctfakuhrdph ADD dou DECIMAL(10,0) DEFAULT 0 AFTER prx7 ";
$vysledek = mysql_query("$sql");

}

//nacitaj uhrady
if ( $copern == 1001 OR $copern == 1002 )
    {


    }
//koniec nacitaj uhrady

$cplda=0;
$prepocty=0;

//ulozenie novej
if ( $copern == 15 )
    {

$ulozttt = " INSERT INTO F$kli_vxcf"."_uctfakuhrdph ( dok,druh,dppx,dou,dau,dpp,hou,hz1,hd1,hz2,hd2 ) ".
" VALUES ( '$cislo_dok', '$drupoh', '$h_dppx', '$h_dou', '$h_dausql', '$h_dppsql', '$h_hou', '$h_hz1', '$h_hd1', '$h_hz2', '$h_hd2' ) "; 
$ulozene = mysql_query("$ulozttt"); 
//echo $ulozttt;

$cplda=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctfakuhrdph WHERE cpld > 0 ORDER BY cpld DESC ";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $cplda=1*$riadok->cpld;

  }

$prepocty=1;

$copern=1;

    }
//koniec ulozenia


//urob prepocty
if( $prepocty == 1 ) 
{

$zk2a=0; $dn2a=0; $zk1a=0; $dn1a=0; $hoda=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctfakuhrdph WHERE dok = $cislo_dok AND cpld = $cplda ";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $zk2a=1*$riadok->hz2;
  $dn2a=1*$riadok->hd2;
  $zk1a=1*$riadok->hz1;
  $dn1a=1*$riadok->hd1;
  $hoda=1*$riadok->hou;
  }

$zk2s=0; $dn2s=0; $zk1s=0; $dn1s=0; $hods=0;
$sqltt = "SELECT SUM(hz2) AS hz2s, SUM(hd2) AS hd2s, SUM(hz1) AS hz1s, SUM(hd1) AS hd1s, SUM(hou) AS hous FROM F$kli_vxcf"."_uctfakuhrdph WHERE dok = $cislo_dok ";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $zk2s=1*$riadok->hz2s;
  $dn2s=1*$riadok->hd2s;
  $zk1s=1*$riadok->hz1s;
  $dn1s=1*$riadok->hd1s;
  $hods=1*$riadok->hous;
  }


$zk2f=0; $dn2f=0; $zk1f=0; $dn1f=0; $hodf=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_$faktury WHERE dok = $cislo_dok ";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $zk2f=1*$riadok->zk2u;
  $dn2f=1*$riadok->dn2u;
  $zk1f=1*$riadok->zk1u;
  $dn1f=1*$riadok->dn1u;
  $hodf=1*$riadok->hodu;
  }

$koef=$hoda/$hodf;
if( $koef > 1 ) { $koef=1; }
$zk2set=$zk2f*$koef;
$dn2set=$dn2f*$koef;
$zk1set=$zk1f*$koef;
$dn1set=$dn1f*$koef;


if( $koef <  1 ) {
$sqltt = "UPDATE F$kli_vxcf"."_uctfakuhrdph SET hz2=$zk2set WHERE dok = $cislo_dok AND cpld = $cplda AND hz2 = 0 ";
$sql = mysql_query("$sqltt"); 

$sqltt = "UPDATE F$kli_vxcf"."_uctfakuhrdph SET hd2=$dn2set WHERE dok = $cislo_dok AND cpld = $cplda AND hd2 = 0 ";
$sql = mysql_query("$sqltt");

$sqltt = "UPDATE F$kli_vxcf"."_uctfakuhrdph SET hz1=$zk1set WHERE dok = $cislo_dok AND cpld = $cplda AND hz1 = 0 ";
$sql = mysql_query("$sqltt"); 

$sqltt = "UPDATE F$kli_vxcf"."_uctfakuhrdph SET hd1=$dn1set WHERE dok = $cislo_dok AND cpld = $cplda AND hd1 = 0 ";
$sql = mysql_query("$sqltt");
                 }

if( $koef == 1 ) {
$sqltt = "UPDATE F$kli_vxcf"."_uctfakuhrdph SET hz2=$zk2f WHERE dok = $cislo_dok AND cpld = $cplda AND hz2 = 0 ";
$sql = mysql_query("$sqltt"); 

$sqltt = "UPDATE F$kli_vxcf"."_uctfakuhrdph SET hd2=$dn2f WHERE dok = $cislo_dok AND cpld = $cplda AND hd2 = 0 ";
$sql = mysql_query("$sqltt");

$sqltt = "UPDATE F$kli_vxcf"."_uctfakuhrdph SET hz1=$zk1f WHERE dok = $cislo_dok AND cpld = $cplda AND hz1 = 0 ";
$sql = mysql_query("$sqltt"); 

$sqltt = "UPDATE F$kli_vxcf"."_uctfakuhrdph SET hd1=$dn1f WHERE dok = $cislo_dok AND cpld = $cplda AND hd1 = 0 ";
$sql = mysql_query("$sqltt");
                 }

//kontrola max. zaklad a dph
$zk2s=0; $dn2s=0; $zk1s=0; $dn1s=0; $hods=0;
$sqltt = "SELECT SUM(hz2) AS hz2s, SUM(hd2) AS hd2s, SUM(hz1) AS hz1s, SUM(hd1) AS hd1s, SUM(hou) AS hous FROM F$kli_vxcf"."_uctfakuhrdph WHERE dok = $cislo_dok ";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $zk2s=1*$riadok->hz2s;
  $dn2s=1*$riadok->hd2s;
  $zk1s=1*$riadok->hz1s;
  $dn1s=1*$riadok->hd1s;
  $hods=1*$riadok->hous;
  }

if( $zk2s > $zk2f )
 {
$sqltt = "UPDATE F$kli_vxcf"."_uctfakuhrdph SET hz2=hz2-($zk2s-$zk2f) WHERE dok = $cislo_dok AND cpld = $cplda AND hz2 != 0 ";
$sql = mysql_query("$sqltt"); 
 }
if( $dn2s > $dn2f )
 {
$sqltt = "UPDATE F$kli_vxcf"."_uctfakuhrdph SET hd2=hd2-($dn2s-$dn2f) WHERE dok = $cislo_dok AND cpld = $cplda AND hd2 != 0 ";
$sql = mysql_query("$sqltt"); 
 }
if( $zk1s > $zk1f )
 {
$sqltt = "UPDATE F$kli_vxcf"."_uctfakuhrdph SET hz1=hz1-($zk1s-$zk1f) WHERE dok = $cislo_dok AND cpld = $cplda AND hz1 != 0 ";
$sql = mysql_query("$sqltt"); 
 }
if( $dn1s > $dn1f )
 {
$sqltt = "UPDATE F$kli_vxcf"."_uctfakuhrdph SET hd1=hd1-($dn1s-$dn1f) WHERE dok = $cislo_dok AND cpld = $cplda AND hd1 != 0 ";
$sql = mysql_query("$sqltt"); 
 }


}
//koniec urob prepocty





//vymazanie a uprava
if ( $copern == 16 )
    {


$sqltt = "SELECT * FROM F$kli_vxcf"."_uctfakuhrdph WHERE cpld = $cislo_cpld ";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_dok = $riadok->dok;
$h_dou = $riadok->dou;
$h_dppx = $riadok->dppx;
$h_dau = $riadok->dau;
$h_dpp = $riadok->dpp;
$h_hou = $riadok->hou;
$h_hz2 = $riadok->hz2;
$h_hd2 = $riadok->hd2;
$h_hz1 = $riadok->hz1;
$h_hd1 = $riadok->hd1;



$h_dausk=SkDatum($h_dau); 
$h_dppsk=SkDatum($h_dpp); 
  }

$zmazttt = "DELETE FROM F$kli_vxcf"."_uctfakuhrdph WHERE cpld='$cislo_cpld' "; 
$zmazane = mysql_query("$zmazttt");
//echo $zmazttt;
$copern=1;

    }
//koniec vymazanie a uprava


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>PrijatÈ platby na fakt˙re</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

  function douEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        document.forms.formv1.h_dau.focus();
	document.forms.formv1.h_dau.select();
              }

                }

  function dauEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        document.forms.formv1.h_dpp.focus();
	document.forms.formv1.h_dpp.select();
              }

                }

  function dppEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        document.forms.formv1.h_hou.focus();
	document.forms.formv1.h_hou.select();
              }

                }

  function houEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        if ( document.formv1.h_hz2.value == '' ) { document.forms.formv1.h_hz2.value="0"; };
        document.forms.formv1.h_hz2.focus();
	document.forms.formv1.h_hz2.select();
              }

                }

  function hz2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){


        if ( document.formv1.h_hd2.value == '' ) { document.forms.formv1.h_hd2.value="0"; };
        document.forms.formv1.h_hd2.focus();
	document.forms.formv1.h_hd2.select();
              }

                }

  function hd2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){


        if ( document.formv1.h_hz1.value == '' ) { document.forms.formv1.h_hz1.value="0"; };
        document.forms.formv1.h_hz1.focus();
	document.forms.formv1.h_hz1.select();
              }

                }

  function hz1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){


        if ( document.formv1.h_hd1.value == '' ) { document.forms.formv1.h_hd1.value="0"; };
        document.forms.formv1.h_hd1.focus();
	document.forms.formv1.h_hd1.select();
              }

                }

  function hd1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        Povol_uloz();
              }

                }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_hou.value == '' ) okvstup=0;
    if ( document.formv1.h_hou.value == '0' ) okvstup=0;
    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; return (true); }
       else { document.formv1.uloz.disabled = true; return (false) ; }

    }

    function ObnovUI()
    {
    //document.formv1.h_cpld.value = '<?php echo "$h_cpld";?>';
    document.formv1.h_dok.value = '<?php echo "$cislo_dok";?>';
    document.formv1.h_dou.value = '<?php echo "$h_dou";?>';
    //document.formv1.h_dppx.value = '<?php echo "$h_dppx";?>';
    document.formv1.h_dau.value = '<?php echo "$h_dausk";?>';
    document.formv1.h_dpp.value = '<?php echo "$h_dppsk";?>';
    document.formv1.h_hou.value = '<?php echo "$h_hou";?>';
    document.formv1.h_hz2.value = '<?php echo "$h_hz2";?>';
    document.formv1.h_hd2.value = '<?php echo "$h_hd2";?>';
    document.formv1.h_hz1.value = '<?php echo "$h_hz1";?>';
    document.formv1.h_hd1.value = '<?php echo "$h_hd1";?>';

    document.formv1.h_dou.focus();
    document.formv1.h_dou.select();
    document.formv1.h_dok.disabled = true
    document.formv1.h_cpld.disabled = true;
    document.formv1.uloz.disabled = true;

    }

function zmazat(cpl)
                {

var n_cpl = cpl;
window.open('fakuhrdph.php?copern=16&cislo_cpld=' + n_cpl + '&cislo_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>', '_self' );
                }

function TovarFak()
                {
        window.open('fakuhrdph.php?copern=1001&cislo_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>', '_self'); 
                }
function TovarFakAll()
                {
        window.open('fakuhrdph.php?copern=1002&cislo_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>', '_self'); 
                }

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  </script>
</HEAD>
<BODY class="white" onload="ObnovUI();" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  ⁄hrady dokladu ËÌslo <?php echo $cislo_dok; ?> pre OdpoËet a uplatnenie DPH aû po prijatÌ platby</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
//nastavenie datumu do kvdph
if ( $copern >= 1 )
     {
$textdpp=0;
$sql = mysql_query("SELECT * FROM F".$kli_vxcf."_uctfakuhrdph WHERE dok = $cislo_dok AND prx7 = 1 ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $textdpp=$riadok->dppx;
  }
?>
<div id="nastavdppx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 200px; left: 10px; width:600px; height:100px;">
<table  class='ponuka' width='100%'>
<tr><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td></tr>

<tr><td colspan='3'>Nastavenie OdpoËtu a uplatnenia DPH aû po prijatÌ platby</td>
<td colspan='2' align='right'><img border=0 src='../obr/zmazuplne.png' style="width:10; height:10;" onClick="nastavdppx.style.display='none';" title='Zhasni' ></td></tr>  
                    
<tr><FORM name='enastdpp' method='post' action='#' >
<td class='ponuka' colspan='5'> 
 OdpoËet a uplatnenie DPH aû po prijatÌ platby <input type="checkbox" name="dppx" value="1" />
 <img border=0 src='../obr/ok.png' style="width:10; height:10;" onClick="NacitajDpp();" title='Uloû nastavenie OdpoËtu a uplatnenia DPH aû po prijatÌ platby' > 
<?php if ( $textdpp == 1 )       { ?>
 <script type="text/javascript">document.enastdpp.dppx.checked = "checked";</script>
<?php                            } ?>
</td></tr> 
</FORM></table>
</div>
<script type="text/javascript">

//zapis nastavenie
function NacitajDpp()
                {
var dppx = 0;
if( document.enastdpp.dppx.checked ) dppx=1;

window.open('../faktury/fak_setulozdpp.php?cislo_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>&dppx=' + dppx + '&copern=901', '_self' );
                }

</script>
<?php
     }
?>


<?php

// toto je cast na zobrazenie tabulky
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctfakuhrdph WHERE dok = $cislo_dok AND prx7 = 0 ORDER BY cpld";
$sql = mysql_query("$sqltt");
$cpol = mysql_num_rows($sql);
$i=0;
?>

<table class="fmenu" width="100%" >

<?php

$zk2f=0; $dn2f=0; $zk1f=0; $dn1f=0; $hodf=0;
$sqlttd = "SELECT * FROM F$kli_vxcf"."_$faktury WHERE dok = $cislo_dok ";
$sqld = mysql_query("$sqlttd"); 
  if (@$zaznamd=mysql_data_seek($sqld,0))
  {
  $riadokd=mysql_fetch_object($sqld);
  $zk2f=1*$riadokd->zk2u;
  $dn2f=1*$riadokd->dn2u;
  $zk1f=1*$riadokd->zk1u;
  $dn1f=1*$riadokd->dn1u;
  $hodf=1*$riadokd->hodu;

  }

?>

<tr>
<td class="hmenu" > </td>
<td class="hmenu" >Fakt˙ra</td>
<td class="hmenu" > </td>
<td class="hmenu" > </td>
<td class="hmenu" > </td>
<td class="hmenu" ><?php echo $hodf;?></td>
<td class="hmenu" ><?php echo $zk2f;?></td>
<td class="hmenu" ><?php echo $dn2f;?></td>
<td class="hmenu" ><?php echo $zk1f;?></td>
<td class="hmenu" ><?php echo $dn1f;?></td>
<td class="hmenu" ></td>

</tr>


<tr>
<td class="hmenu" width="8%" >Ë.p.

<?php
//echo $copern;
if ( $kli_vrok >= 2016 )
     {
$textdpp=0;
$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_uctfakuhrdph WHERE dok = $cislo_dok AND prx7 = 1 ");
  if (@$zaznamdok=mysql_data_seek($sqldok,0))
  {
  $riadokdok=mysql_fetch_object($sqldok);
  $textdpp=$riadokdok->dppx;
  }
?>
<img src='../obr/icon_calendar.png' onClick="nastavdppx.style.display=''; volajDppset(<?php echo $kli_uzid;?>);" width=12 height=12 border=0 title="OdpoËet a uplatnenie DPH aû po prijatÌ platby 0=nie, 1=·no" ></a>
<?php echo $textdpp; ?>
</td>
<?php
     }
?>

<td class="hmenu" width="8%" >Doklad

<td class="hmenu" width="10%" >⁄hr.dok.
<td class="hmenu" width="8%" >Dat.˙hr.
<td class="hmenu" width="8%" >Dat.DPH
<td class="hmenu" width="8%" >UhradenÈ
<td class="hmenu" width="8%" >ZK2
<td class="hmenu" width="8%" >DN2
<td class="hmenu" width="8%" >ZK1
<td class="hmenu" width="8%" >DN1
<td class="hmenu" width="5%" >Zmaû/Uprav
</tr>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);


$h_dauskx=SkDatum($riadok->dau); 
$h_dppskx=SkDatum($riadok->dpp);

?>
<tr>
<td class="fmenu" ><?php echo $riadok->cpld;?></td>
<td class="fmenu" ><?php echo $riadok->dok;?></td>
<td class="fmenu" ><?php echo $riadok->dou;?></td>
<td class="fmenu" ><?php echo $h_dauskx;?></td>
<td class="fmenu" ><?php echo $h_dppskx;?></td>
<td class="fmenu" ><?php echo $riadok->hou;?></td>
<td class="fmenu" ><?php echo $riadok->hz2;?></td>
<td class="fmenu" ><?php echo $riadok->hd2;?></td>
<td class="fmenu" ><?php echo $riadok->hz1;?></td>
<td class="fmenu" ><?php echo $riadok->hd1;?></td>
<td class="fmenu" >
<img border=1 src="../obr/zmaz.png" style="width:15; height:15;" onclick="zmazat(<?php echo $riadok->cpld;?>);" title="Zmazaù" >
</td>

</tr>
<?php
  }
$i = $i + 1;
   }
?>
<tr>
<FORM name="formv1" class="obyc" method="post" action="fakuhrdph.php?cislo_dok=<?php echo $cislo_dok; ?>&page=<?php echo $page;?>&copern=15&drupoh=<?php echo $drupoh; ?>" >

<td class="fmenu"><input type="text" name="h_cpld" id="h_cpld" size="6" /></td>
<td class="fmenu"><input type="text" name="h_dok" id="h_dok" size="8"  /></td>

<td class="fmenu"><input type="text" name="h_dou" id="h_dou" size="10" onKeyDown="return douEnter(event.which)" onkeyup="CiarkaNaBodku(this);" /></td>
<td class="fmenu"><input type="text" name="h_dau" id="h_dau" size="10" onKeyDown="return dauEnter(event.which)" onkeyup="CiarkaNaBodku(this);" /></td>
<td class="fmenu"><input type="text" name="h_dpp" id="h_dpp" size="10" onKeyDown="return dppEnter(event.which)" onkeyup="CiarkaNaBodku(this);" /></td>
<td class="fmenu"><input type="text" name="h_hou" id="h_hou" size="10" onKeyDown="return houEnter(event.which)" onkeyup="CiarkaNaBodku(this);" /></td>

<td class="fmenu"><input type="text" name="h_hz2" id="h_hz2" size="10" onKeyDown="return hz2Enter(event.which)" onkeyup="CiarkaNaBodku(this);" /></td>
<td class="fmenu"><input type="text" name="h_hd2" id="h_hd2" size="10" onKeyDown="return hd2Enter(event.which)" onkeyup="CiarkaNaBodku(this);" /></td>
<td class="fmenu"><input type="text" name="h_hz1" id="h_hz1" size="10" onKeyDown="return hz1Enter(event.which)" onkeyup="CiarkaNaBodku(this);" /></td>
<td class="fmenu"><input type="text" name="h_hd1" id="h_hd1" size="10" onKeyDown="return hd1Enter(event.which)" onkeyup="CiarkaNaBodku(this);" /></td>

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" /></td>

</tr>

<?php

$zk2s=0; $dn2s=0; $zk1s=0; $dn1s=0; $hods=0;
$sqlttd = "SELECT SUM(hz2) AS hz2s, SUM(hd2) AS hd2s, SUM(hz1) AS hz1s, SUM(hd1) AS hd1s, SUM(hou) AS hous FROM F$kli_vxcf"."_uctfakuhrdph WHERE dok = $cislo_dok ";
$sqld = mysql_query("$sqlttd"); 
  if (@$zaznamd=mysql_data_seek($sqld,0))
  {
  $riadokd=mysql_fetch_object($sqld);
  $zk2s=1*$riadokd->hz2s;
  $dn2s=1*$riadokd->hd2s;
  $zk1s=1*$riadokd->hz1s;
  $dn1s=1*$riadokd->hd1s;
  $hous=1*$riadokd->hous;

  }

?>

<tr>
<td class="hmenu" > </td>
<td class="hmenu" colspan="2" >Spolu platby</td>
<td class="hmenu" > </td>
<td class="hmenu" > </td>
<td class="hmenu" ><?php echo $hous;?></td>
<td class="hmenu" ><?php echo $zk2s;?></td>
<td class="hmenu" ><?php echo $dn2s;?></td>
<td class="hmenu" ><?php echo $zk1s;?></td>
<td class="hmenu" ><?php echo $dn1s;?></td>
<td class="hmenu" ></td>

</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>
</FORM>
</table>

<br />
<a href="#" title="xxx" onclick="TovarFak();" >NaËÌtaù ˙hrady do fakt˙ry Ë.<?php echo $cislo_dok; ?> z obdobia <?php echo $kli_vume; ?></a>
<br />
<br />
<a href="#" title="xxx" onclick="TovarFakAll();" >NaËÌtaù ˙hrady do vöetk˝ch fakt˙r z obdobia <?php echo $kli_vume; ?></a>
<br />

<?php


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
