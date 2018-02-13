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

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$drupoh = 1*strip_tags($_REQUEST['drupoh']);
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$cislo_cpld = 1*$_REQUEST['cislo_cpld'];

//echo $copern;
//echo $cislo_cpld;

$h_dok = strip_tags($_REQUEST['h_dok']);
$h_kodt = strip_tags($_REQUEST['h_kodt']);
$h_dtov = strip_tags($_REQUEST['h_dtov']);
$h_mnot = strip_tags($_REQUEST['h_mnot']);
$h_merj = strip_tags($_REQUEST['h_merj']);
$h_zkld = strip_tags($_REQUEST['h_zkld']);
$h_sumd = strip_tags($_REQUEST['h_sumd']);
$h_prx1 = strip_tags($_REQUEST['h_prx1']);
$cislo_cpld = strip_tags($_REQUEST['cislo_cpld']);


//nacitaj tovar
if ( $copern == 1001 OR $copern == 1002 )
    {

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   datp          DATE,
   datk          DATE,
   fic          INT
);
prcdatum;

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $kli_vume);
$kli_mdph=$pole[0];
$kli_rdph=$pole[1];
if( $kli_mdph < 10 ) $kli_mdph="0".$kli_mdph;

$pole = explode(".", $kli_vume);
$mesp_dph=$pole[0];
$mesk_dph=$pole[0];
$rokp_dph=$pole[1];


$datp_dph=$rokp_dph.'-'.$mesp_dph.'-01';
$datk_dph=$rokp_dph.'-'.$mesk_dph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datp_dph', 0 )";
$ttqq = mysql_query("$ttvv");


$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$datp_dph',  datk=LAST_DAY('$datk_dph')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$zmazttt = "DROP TABLE F$kli_vxcf"."_uctvykdpha2prac$kli_uzid "; 
$zmazane = mysql_query("$zmazttt");

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$zmazttt = "CREATE TABLE F$kli_vxcf"."_uctvykdpha2prac$kli_uzid SELECT * FROM F$kli_vxcf"."_uctvykdpha2 WHERE dok < 0 "; 
$zmazane = mysql_query("$zmazttt");

$sql = "ALTER TABLE F$kli_vxcf"."_uctvykdpha2prac$kli_uzid ADD cis DECIMAL(15,0) DEFAULT 0 AFTER prx2 ";
$vysledek = mysql_query("$sql");

//_uctvykdpha2prac38
//cpld	dok	kodt	dtov	mnot	merj	zkld	sumd	prx1	prx2	cis	prx3	prx6


$podmfak="dok = ".$cislo_dok;
if( $copern == 1002 ) { $podmfak="dat >= '".$datp_dph."' AND dat <= '".$datk_dph."' "; }
//echo $podmfak;

$sqltt = "SELECT * FROM F$kli_vxcf"."_fakodb WHERE $podmfak ";
//echo $sqltt."<br />";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
$strana=1;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$jetam361=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctodb WHERE dok = $hlavicka->dok AND rdp = 361 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $jetam361=1;
  }

$ulozttt = " INSERT INTO F$kli_vxcf"."_uctvykdpha2prac$kli_uzid SELECT 0,dok,'','',mno,mer,(cep*mno),0,0,0,cis,0,0  ".
" FROM F$kli_vxcf"."_sklfak WHERE dok = $hlavicka->dok AND cis > 0 "; 
if( $jetam361 == 1 ) { $ulozene = mysql_query("$ulozttt"); }
//echo $ulozttt."<br />";

$zmazttt = "DELETE FROM F$kli_vxcf"."_uctvykdpha2 WHERE dok = $hlavicka->dok "; 
$zmazane = mysql_query("$zmazttt");

}
$i = $i + 1;

   }



$ulozttt = "UPDATE F$kli_vxcf"."_uctvykdpha2prac$kli_uzid,F$kli_vxcf"."_sklcisudaje SET kodt=TRIM(xtxt5) ".
" WHERE F$kli_vxcf"."_uctvykdpha2prac$kli_uzid.cis=F$kli_vxcf"."_sklcisudaje.xcis "; 
$ulozene = mysql_query("$ulozttt");

$ulozttt = " INSERT INTO F$kli_vxcf"."_uctvykdpha2prac$kli_uzid SELECT 0,dok,kodt,'',SUM(mnot),merj,SUM(zkld),0,0,9,cis,0,0  ".
" FROM F$kli_vxcf"."_uctvykdpha2prac$kli_uzid WHERE dok > 0 GROUP BY dok,kodt,dtov "; 
$ulozene = mysql_query("$ulozttt");

$zmazttt = "DELETE FROM F$kli_vxcf"."_uctvykdpha2prac$kli_uzid WHERE prx2 != 9 "; 
$zmazane = mysql_query("$zmazttt");

$zmazttt = "DELETE FROM F$kli_vxcf"."_uctvykdpha2prac$kli_uzid WHERE kodt = '' "; 
$zmazane = mysql_query("$zmazttt");

$ulozttt = " INSERT INTO F$kli_vxcf"."_uctvykdpha2 SELECT 0,dok,kodt,'',mnot,merj,zkld,0,0,0,0,0  ".
" FROM F$kli_vxcf"."_uctvykdpha2prac$kli_uzid WHERE dok > 0 "; 
$ulozene = mysql_query("$ulozttt");

//exit;


    }
//koniec nacitaj tovar


//ulozenie novej
if ( $copern == 15 )
    {

$ulozttt = " INSERT INTO F$kli_vxcf"."_uctvykdpha2 ( dok,kodt,dtov,mnot,merj,prx1,zkld,sumd ) ".
" VALUES ( '$cislo_dok', '$h_kodt', '$h_dtov', '$h_mnot', '$h_merj', '$h_prx1', '$h_zkld', '$h_sumd') "; 
$ulozene = mysql_query("$ulozttt"); 
//echo $ulozttt;

$copern=1;

    }
//koniec ulozenia

//vymazanie a uprava
if ( $copern == 16 )
    {


$sqltt = "SELECT * FROM F$kli_vxcf"."_uctvykdpha2 WHERE cpld = $cislo_cpld ";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_dok = $riadok->dok;
$h_kodt = $riadok->kodt;
$h_dtov = $riadok->dtov;
$h_mnot = $riadok->mnot;
$h_merj = $riadok->merj;
$h_prx1 = $riadok->prx1;
$h_zkld = $riadok->zkld;
$h_sumd = $riadok->sumd;

  }

$zmazttt = "DELETE FROM F$kli_vxcf"."_uctvykdpha2 WHERE cpld='$cislo_cpld' "; 
$zmazane = mysql_query("$zmazttt");
//echo $zmazttt;
$copern=1;

    }
//koniec vymazanie a uprava

//prepocet nerozuctovaneho
$zk0=0; $esterozuctuj=0; $rozuctovane=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_fakodb WHERE dok = $cislo_dok ";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
$zk0 = 1*$riadok->zk0;
  }
$sqltt = "SELECT SUM(zkld) AS sumz FROM F$kli_vxcf"."_uctvykdpha2 WHERE dok = $cislo_dok ";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
$rozuctovane = 1*$riadok->sumz;
  }
$esterozuctuj=$zk0-$rozuctovane;

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Tovar na fakt˙re</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

  function kodtEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        document.forms.formv1.h_dtov.focus();
	document.forms.formv1.h_dtov.select();
              }

                }

  function dtovEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        document.forms.formv1.h_zkld.focus();
	document.forms.formv1.h_zkld.select();
              }

                }

  function zkldEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        document.forms.formv1.h_sumd.focus();
	document.forms.formv1.h_sumd.select();
              }

                }

  function sumdEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        if ( document.formv1.h_mnot.value == '' ) { document.forms.formv1.h_mnot.value=1; };
        document.forms.formv1.h_mnot.focus();
	document.forms.formv1.h_mnot.select();
              }

                }

  function mnotEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){


        if ( document.formv1.h_merj.value == '' ) { document.forms.formv1.h_merj.value="ks"; };
        document.forms.formv1.h_merj.focus();
	document.forms.formv1.h_merj.select();
              }

                }

  function merjEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        Povol_uloz();
              }

                }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_mnot.value == '' ) okvstup=0;
    if ( document.formv1.h_merj.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; return (true); }
       else { document.formv1.uloz.disabled = true; return (false) ; }

    }


    function ObnovUI()
    {
    document.formv1.h_cpld.value = '<?php echo "$h_cpld";?>';
    document.formv1.h_dok.value = '<?php echo "$cislo_dok";?>';
    document.formv1.h_kodt.value = '<?php echo "$h_kodt";?>';
    document.formv1.h_dtov.value = '<?php echo "$h_dtov";?>';
    document.formv1.h_mnot.value = '<?php echo "$h_mnot";?>';
    document.formv1.h_merj.value = '<?php echo "$h_merj";?>';
    document.formv1.h_prx1.value = '<?php echo "$h_prx1";?>';
    document.formv1.h_zkld.value = '<?php echo "$esterozuctuj";?>';
    document.formv1.h_sumd.value = '<?php echo "$h_sumd";?>';

    document.formv1.h_kodt.focus();
    document.formv1.h_kodt.select();
    document.formv1.h_dok.disabled = true
    document.formv1.h_cpld.disabled = true;
    document.formv1.h_prx1.disabled = true;
    document.formv1.h_ne1.disabled = true;
    document.formv1.uloz.disabled = true;
    }

function zmazat(cpl)
                {

var n_cpl = cpl;
window.open('faktovdph.php?copern=16&cislo_cpld=' + n_cpl + '&cislo_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>', '_self' );
                }

function TovarFak()
                {
        window.open('faktovdph.php?copern=1001&cislo_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>', '_self'); 
                }
function TovarFakAll()
                {
        window.open('faktovdph.php?copern=1002&cislo_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>', '_self'); 
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
<?php if( $drupoh == 1 ) { ?>
<td>EuroSecom  -  ⁄daje z vyhotovenej fakt˙ry ËÌslo <?php echo $cislo_dok; ?> o dodanÌ tovarov, 
ktor˙ bol platiteæ dane povinn˝ vyhotoviù podæa ß 71 aû 75 z·kona, pri ktor˝ch je osobou povinnou platiù 
daÚ prÌjemca plnenia podæa ß 69 ods. 12 pÌsm. f) aû i) z·kona
</td>
<?php                    } ?>
<?php if( $drupoh == 2 ) { ?>
<td>EuroSecom  -  ⁄daje z prijatej fakt˙ry ËÌslo <?php echo $cislo_dok; ?> , pri ktorej je osobou povinnou platiù daÚ prÌjemca plnenia podæa 
ß 69 ods. 2, 3, 6, 7 a 9 aû 12 z·kona (okrem fakt˙ry o dodanÌ plnenÌ osloboden˝ch od dane)
</td>
<?php                    } ?>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
// toto je cast na zobrazenie tabulky
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctvykdpha2 WHERE dok = $cislo_dok ORDER BY cpld";
$sql = mysql_query("$sqltt");
$cpol = mysql_num_rows($sql);
$i=0;
?>

<table class="fmenu" width="100%" >

<tr>
<td class="hmenu" width="10%" >Ë.p.
<td class="hmenu" width="10%" >Doklad
<td class="hmenu" width="10%" >KÛd
 <img border=1 src="../obr/info.png" style="width:15; height:15;" title="»Ìseln˝ kÛd tovaru podæa SpoloËnÈho colnÈho sadzobnÌka [len tovar podæa ß 69 ods. 12 pÌsm. f) a g) z·kona]" >
<td class="hmenu" width="10%" >Druh
 <img border=1 src="../obr/info.png" style="width:15; height:15;" title="Druh tovaru [len tovar podæa ß 69 ods. 12 pÌsm. h) a i) z·kona]" >
<td class="hmenu" width="10%" >Z·kladDPH
<td class="hmenu" width="10%" >SumaDPH
<td class="hmenu" width="10%" >Mnoûstvo
 <img border=1 src="../obr/info.png" style="width:15; height:15;" title="DesatinnÈ ËÌslo na 2 desatinnÈ miesta" >
<td class="hmenu" width="10%" >MJ
 <img border=1 src="../obr/info.png" style="width:15; height:15;" title="Zadajte t, m, kg alebo ks" >
<td class="hmenu" width="10%" >Parameter
<th class="hmenu" width="5%" >Zmaû/Uprav
<th class="hmenu" width="25%" >
</tr>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="fmenu" ><?php echo $riadok->cpld;?></td>
<td class="fmenu" ><?php echo $riadok->dok;?></td>
<td class="fmenu" ><?php echo $riadok->kodt;?></td>
<td class="fmenu" ><?php echo $riadok->dtov;?></td>
<td class="fmenu" ><?php echo $riadok->zkld;?></td>
<td class="fmenu" ><?php echo $riadok->sumd;?></td>
<td class="fmenu" ><?php echo $riadok->mnot;?></td>
<td class="fmenu" ><?php echo $riadok->merj;?></td>
<td class="fmenu" ><?php echo $riadok->prx1;?></td>
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
<FORM name="formv1" class="obyc" method="post" action="faktovdph.php?cislo_dok=<?php echo $cislo_dok; ?>&page=<?php echo $page;?>&copern=15&drupoh=<?php echo $drupoh; ?>" >

<td class="fmenu"><input type="text" name="h_cpld" id="h_cpld" size="10" /></td>

<td class="fmenu"><input type="text" name="h_dok" id="h_dok" size="10"  /></td>

<td class="fmenu"><input type="text" name="h_kodt" id="h_kodt" size="10" onKeyDown="return kodtEnter(event.which)" /></td>

<td class="fmenu"><input type="text" name="h_dtov" id="h_dtov" size="10" onKeyDown="return dtovEnter(event.which)"/></td>

<td class="fmenu"><input type="text" name="h_zkld" id="h_zkld" size="10" onKeyDown="return zkldEnter(event.which)" onkeyup="CiarkaNaBodku(this);"/></td>
<td class="fmenu"><input type="text" name="h_sumd" id="h_sumd" size="10" onKeyDown="return sumdEnter(event.which)" onkeyup="CiarkaNaBodku(this);"/></td>

<td class="fmenu"><input type="text" name="h_mnot" id="h_mnot" size="10" onKeyDown="return mnotEnter(event.which)" onkeyup="CiarkaNaBodku(this);"/></td>

<td class="fmenu"><input type="text" name="h_merj" id="h_merj" size="10" onKeyDown="return merjEnter(event.which)"/></td>

<td class="fmenu"><input type="text" name="h_prx1" id="h_prx1" size="10" onKeyDown="return prx1Enter(event.which)"/></td>

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" /></td>

</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>
</FORM>
</table>

<br />
<a href="#" title="xxx" onclick="TovarFak();" >NaËÌtaù tovar do fakt˙ry Ë.<?php echo $cislo_dok; ?></a>
<br />
<br />
<a href="#" title="xxx" onclick="TovarFakAll();" >NaËÌtaù tovar do vöetk˝ch fakt˙r z obdobia <?php echo $kli_vume; ?></a>
<br />

<?php


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
