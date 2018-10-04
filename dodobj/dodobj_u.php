<!doctype html>
<HTML>
<?php

//celkovy zaciatok dokumentu
       do
       {
$zmtz=1;

$sys = 'SKL';
$urov = 2000;
$clsm = 960;
$uziv = include("../uziv.php");
if ( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$html = 1*$_REQUEST['html'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$vseobj = 1*$_REQUEST['vseobj'];
$vsezaico = 1*$_REQUEST['vsezaico'];
$icox = 1*$_REQUEST['icox'];

$hladaj_uce = 1*strip_tags($_REQUEST['hladaj_uce']);
if( $hladaj_uce == 0 ) $hladaj_uce=31100;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$somvprirskl=0;

$citfir = include("../cis/citaj_fir.php");
$opakujinput=1;
if( $fir_fico == 46614478 ) { $opakujinput=0; }

if( $fir_fico == '46614478' )
  {
$sqlttt = "ALTER TABLE F".$kli_vxcf."_dodavobj MODIFY xcep decimal(10,4) DEFAULT 0 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "ALTER TABLE F".$kli_vxcf."_dodavobj MODIFY xced decimal(10,4) DEFAULT 0 ";
$sqldok = mysql_query("$sqlttt");
  }

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//nacitaj min zasoby
if( $copern == 191918 )
{
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$akeico = 1*$_REQUEST['akeico'];
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù zo zostavy minim·lnych z·sob do objedn·vky Ë.<?php echo $cislo_dok; ?> ?") )
         {  }
else
  var okno = window.open("dodobj_u.php?copern=191919&drupoh=1&page=1&cislo_dok=<?php echo $cislo_dok; ?>&zmtz=<?php echo $zmtz; ?>&akeico=<?php echo $akeico; ?>","_self");
</script>
<?php
//echo "rus";
$copern=1;
$page=1;
$zmtz=1;
$tlacobj=1;
$drupoh=1;
//exit;
}
if( $copern == 191919 )
{

$cislo_dok = 1*$_REQUEST['cislo_dok'];
$akeico = 1*$_REQUEST['akeico'];

$sqltt2 = "SELECT * FROM F$kli_vxcf"."_dodavobj WHERE xdok = $cislo_dok AND xsx2 = 9 ";
$sqldo2 = mysql_query("$sqltt2");
 if (@$zaznam=mysql_data_seek($sqldo2,0))
 {
 $riaddo2=mysql_fetch_object($sqldo2);
 $xdatd=$riaddo2->xdatd;
 $xdatv=$riaddo2->xdatv;
 $xstav=$riaddo2->xstav;

 }


$sqlttt = "SELECT * FROM F$kli_vxcf"."_sklprcdminzas$kli_uzid  WHERE ddv = $akeico AND pox = 0 ORDER BY cis ";

//echo $sqlttt."<br />";
//exit;

$sql = mysql_query("$sqlttt");
$cpol = mysql_num_rows($sql);
$i=0;


while ($i <= $cpol )
{
  if (@$zaznam=mysql_data_seek($sql,$i))
    {
  $riadok=mysql_fetch_object($sql);


//`f93_sklprcdminzas38`
//druh	pox1	pox	ume	dat	skl	cis	ddv	mno	cen	zas	hod	vdj	prj	pcs

//dodavobj
//xdok	xdatd	xdatv	xfak	xsx1	xsx2	xsx3	xdx1	xdx2	xdx3	xice	xodbm	xcpo	xcpl
//xcis	xnat	xdph	xcep	xced	xmno	xhdb	xhdd	xid	xdatm	xplat	xfir	xodm	xdop	xstav

$cisnaz="";
$sqltt2 = "SELECT * FROM F$kli_vxcf"."_sklcis WHERE cis = $riadok->cis ";
$sqldo2 = mysql_query("$sqltt2");
 if (@$zaznam=mysql_data_seek($sqldo2,0))
 {
 $riaddo2=mysql_fetch_object($sqldo2);
 $cisnaz=$riaddo2->nat;

 }

$ciscen=0; $prodnum="";
$sqltt2 = "SELECT * FROM F$kli_vxcf"."_sklcisudaje WHERE xcis = $riadok->cis ";
$sqldo2 = mysql_query("$sqltt2");
 if (@$zaznam=mysql_data_seek($sqldo2,0))
 {
 $riaddo2=mysql_fetch_object($sqldo2);
 $ciscen=$riaddo2->pdod;
 $prodnum=trim($riaddo2->xnat4);

 }

$cenax=$riadok->cen;
if( $fir_fico == 46614478 )
{
$cenax=$ciscen;
if( $prodnum != "" AND $prodnum != 0 ) { $cisnaz="ProdNm ".$prodnum." ".$cisnaz; }
}

$dsqlt = "INSERT INTO F$kli_vxcf"."_dodavobj ( xdatd, xdatv, xstav, xdok, xfak, xice, xodbm, xsx3, xcis, xnat, xid, xdatm, xmno, xdph, xcep, xced, xhdb, xhdd ) ".
" VALUES ( '$xdatd', '$xdatv', '$xstav', '$cislo_dok', '0', '$akeico', '0', '0', '$riadok->cis', '$cisnaz', '$kli_uzid', now(), '$riadok->vdj', '20', '$cenax', '0', '0', '0'  ) ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt."<br />";

    }
$i=$i+1;
}


$dsqlt = "UPDATE F$kli_vxcf"."_dodavobj SET xced=xcep, xhdb=xmno*xcep, xhdd=xmno*xced WHERE xdok = $cislo_dok ";
$dsql = mysql_query("$dsqlt");

$html=1;
$copern=2;
$tlacobj=1;
$zmtz=1;
}
//koniec nacitaj min zasoby

//oznac vybavena
if( $copern == 8801 )
{
$cislo_dok=1*$_REQUEST['cislo_dok'];
$h_fak=1*$_REQUEST['h_fak'];

$dsqlt = "UPDATE F$kli_vxcf"."_dodavobj SET xfak='$h_fak' WHERE xdok = $cislo_dok ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;

?>
<script type="text/javascript">
  var okno = window.open("../dodobj/dodobj.php?copern=1&drupoh=1&page=1&zmtz=1&html=1","_self");
</script>
<?php
}
//koniec oznac vybavena

//nova polozka
if( $copern == 7701 )
{
$cislo_dok=1*$_REQUEST['cislo_dok'];

$fir_ficox=$fir_fico;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_dodavobj WHERE xdok = $cislo_dok ORDER BY xdok DESC LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $fir_ficox=1*$riaddok->xice;
 }

$popisplu=$_REQUEST['h_nat'];
$cisplu=1*$_REQUEST['h_cis'];
$mnoplu=1*$_REQUEST['h_mno'];
$cepplu=1*$_REQUEST['h_cep'];
$dphplu=1*$_REQUEST['h_dph'];
$cedplu=$cepplu*(100+$dphplu)/100;
$hdb=$cepplu*$mnoplu;
$hdd=$cedplu*$mnoplu;

$kli_uzidxx=$kli_uzid;
$sqlfir = "SELECT * FROM ezak WHERE cuid = $kli_uzid ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $xeid = 1*$fir_riadok->ez_id; }
if( $xeid > 0 ) { $kli_uzidxx=$xeid; }

//xdok  xfak  xsx1  xsx2  xsx3  xdx1  xdx2  xdx3  xice  xodbm  xcpo  xcpl  xcis  xnat  xdph  xcep  xced  xmno  xhdb  xhdd  xid  xdatm
$xsx3=0;
if( $cisplu == 0 ) { $xsx3=1; }

$dsqlt = "INSERT INTO F$kli_vxcf"."_dodavobj ( xdok, xfak, xice, xodbm, xsx3, xcis, xnat, xid, xdatm, xmno, xdph, xcep, xced, xhdb, xhdd ) ".
" VALUES ( $cislo_dok, 0, '$fir_ficox', 0, '$xsx3', '$cisplu', '$popisplu', $kli_uzidxx, now(), '$mnoplu', '$dphplu', '$cepplu', '$cedplu', '$hdb', '$hdd'  ) ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;

$html=1;
$copern=2;
$zmtz=1;
}
//koniec nova polozka


//zmena ico,odbm
if( $copern == 181818 )
{
$setico=1*$_REQUEST['h_icoset'];
$setobdm=1*$_REQUEST['h_odbmset'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
?>
<script type="text/javascript">
if( !confirm ("Chcete zmeniù I»O a odbernÈ miesto na objedn·vke Ë.<?php echo $cislo_dok; ?> ?") )
         {  }
else
  var okno = window.open("dodobj_u.php?copern=181819&drupoh=1&page=1&h_icoset=<?php echo $setico; ?>&h_odbmset=<?php echo $setobdm; ?>&cislo_dok=<?php echo $cislo_dok; ?>&zmtz=<?php echo $zmtz; ?>","_self");
</script>
<?php
//echo "rus";
$copern=1;
$page=1;
$zmtz=1;
$tlacobj=1;
$drupoh=1;
//exit;
}
if( $copern == 181819 )
{
$setico=1*$_REQUEST['h_icoset'];
$setobdm=1*$_REQUEST['h_odbmset'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];

$sqlttt = "UPDATE F$kli_vxcf"."_dodavobj SET xice=$setico, xodbm=$setobdm WHERE xdok = $cislo_dok ";
$sqldok = mysql_query("$sqlttt");

//echo $sqlttt;

$html=1;
$copern=1;
$zmtz=1;
}
//koniec zmena ico,odbm

$zmazalsom=0;
//zmazat polozku z obj uplne
if( $copern == 6001 )
{
$plux = 1*$_REQUEST['plux'];
?>
<script type="text/javascript">
if( !confirm ("Chcete zmazaù poloûku Ë.<?php echo $plux; ?> z objedn·vky Ë.<?php echo $cislo_dok; ?> ?") )
         {   }
else
  var okno = window.open("dodobj_u.php?copern=6002&drupoh=1&page=1&plux=<?php echo $plux; ?>&cislo_dok=<?php echo $cislo_dok; ?>&zmtz=<?php echo $zmtz; ?>","_self");
</script>
<?php
$copern=1;
$html=1;
}
if( $copern == 6002 )
{
$plux = 1*$_REQUEST['plux'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];

$xcisz=0; $xnatz=""; $xcedz=0; $xmnoz=0;
$sqlfir = "SELECT * FROM F$kli_vxcf"."_dodavobj  WHERE xcpo = $plux ";
$sqldok = mysql_query("$sqlfir");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $xcisz=1*$riaddok->xcis;
  $xnatz=$riaddok->xnat;
  $xcedz=1*$riaddok->xced;
  $xmnoz=1*$riaddok->xmno;
  }

$zmazalsom=1;

$dsqlt = "DELETE FROM F$kli_vxcf"."_dodavobj  WHERE xcpo = $plux ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;

$html=1;
$copern=2;
}
//koniezmazat polozku z obj uplne

$docasnemazanie=0;



//zapis upravenu hlavicku
if ( $copern == 11 )
    {
$xdatv = strip_tags($_REQUEST['xdatv']);
$xdatvsql = SqlDatum($xdatv);
$xdatd = strip_tags($_REQUEST['xdatd']);
$xdatdsql = SqlDatum($xdatd);
$xplat = strip_tags($_REQUEST['xplat']);
$xice = strip_tags($_REQUEST['xice']);
$xfir = strip_tags($_REQUEST['xfir']);
$xdop = strip_tags($_REQUEST['xdop']);
$xstav = strip_tags($_REQUEST['xstav']);

$uprav="NO";
$uprtxt = "UPDATE F$kli_vxcf"."_dodavobj SET ".
" xdatv='$xdatvsql', xdatd='$xdatdsql', xplat='$xplat', xice='$xice', xfir='$xfir', xodm='$xodm', xdop='$xdop', xstav='$xstav' ".
" WHERE xdok = $cislo_dok ";
$upravene = mysql_query("$uprtxt");
//echo $uprtxt;
$copern=2;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenu hlavicku


//zapis upravenu polozku
if ( $copern == 22 )
    {

$xcis = strip_tags($_REQUEST['xcis']);
$xnat = strip_tags($_REQUEST['xnat']);
$xced = strip_tags($_REQUEST['xced']);
$xmno = strip_tags($_REQUEST['xmno']);
$xhdd = strip_tags($_REQUEST['xhdd']);

$sqlttt = "SELECT * FROM F$kli_vxcf"."_dodavobj WHERE xdok = $cislo_dok ORDER BY xdok DESC LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $xdatd=$riaddok->xdatd;
 $xdatv=$riaddok->xdatv;
 $xice=$riaddok->xice;
 $xdop=$riaddok->xdop;
 $xstav=$riaddok->xstav;
 $xplat=$riaddok->xplat;
 }

$kli_uzidxx=$kli_uzid;

$dsqlt = "INSERT INTO F$kli_vxcf"."_dodavobj ( xdok, xdatv, xdatd, xice,  xsx2, xsx3, xcis, xnat, xced, xmno, xdop, xstav, xplat, xid, xdatm, xhdd ) ".
" VALUES ( $cislo_dok, '$xdatv', '$xdatd', '$xice', 0, 0, '$xcis', '$xnat', '$xced', '$xmno', '$xdop', '$xstav', '$xplat', $kli_uzidxx, now(), ($xmno*$xced) ) ";
$dsql = mysql_query("$dsqlt");

//echo $dsqlt;
$copern=2;
if (!$dsql):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenu polozku

//nacitaj udaje
if ( $copern == 1 OR $copern == 2 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_dodavobj WHERE xdok = $cislo_dok ORDER BY xcpo DESC";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

//echo $sqlfir;

$xdatv = $fir_riadok->xdatv;
$xdatvsk = SkDatum($xdatv);
$xdatd = $fir_riadok->xdatd;
$xdatdsk = SkDatum($xdatd);
$xplat = $fir_riadok->xplat;
$xice = $fir_riadok->xice;
$xfir = $fir_riadok->xfir;
$xdop = $fir_riadok->xdop;
$xstav = $fir_riadok->xstav;
$xcis = $fir_riadok->xcis;
$xnat = $fir_riadok->xnat;
$xced = $fir_riadok->xced;
$xmno = $fir_riadok->xmno;
$xhdd = $fir_riadok->xhdd;

//echo $xdatvsk;

mysql_free_result($fir_vysledok);

$sqlfir = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $xice ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok);

$ico = $fir_riadok->ico; $dic = $fir_riadok->dic; $icd = $fir_riadok->icd;
$nai = $fir_riadok->nai; $na2 = $fir_riadok->na2; $uli = $fir_riadok->uli;
$psc = $fir_riadok->psc; $mes = $fir_riadok->mes; $tel = $fir_riadok->tel; $fax = $fir_riadok->fax; $em1 = $fir_riadok->em1;
}

$sqlfir = "SELECT * FROM F$kli_vxcf"."_icoodbm WHERE ico = $xice AND odbm = $xodbm ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok);

$onai = $fir_riadok->onai; $ona2 = $fir_riadok->ona2; $ouli = $fir_riadok->ouli;
$opsc = $fir_riadok->opsc; $omes = $fir_riadok->omes;
}
    }
//koniec nacitania
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css" type="text/css">
<title>Dod·vateæsk· objedn·vka | EuroSecom</title>
<style type="text/css">
body {
  min-width: 980px;
  font-family: Arial, sans-serif;
  background-color: #fff;
}
strong {
  font-weight: bold;
}
.toleft {
  float: left;
}
.toright {
  float: right;
}
.center {
  text-align: center;
}
.left {
  text-align: left;
}
.right {
  text-align: right;
}
div.wrap-heading {
  overflow: auto;
  width: 98%;
  padding: 0 1%;
  background-color: #ffff90;
  -webkit-box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
  -moz-box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
  box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
}
div.ilogin {
  font-size: 11px;
  background-color:;
  height: 11px;
  padding-top: 4px;
}
div.ilogin strong {
  margin-left: 6px;
  margin-right: 3px;
}
div.heading {
  height: 36px;
  overflow: hidden;
}
div.heading > h1 {
  line-height: 36px;
  font-size: 20px;
  font-weight: bold;
  font-family: Times, 'Times New Roman', Georgia, serif;
}
div.content {
  margin: 14px 2%;
  width: 96%;
  padding-bottom: 40px;
  position: relative;
}
tr.zero-line > td { /* urcenie sirky stlpcov */
  height: 0 !important;
}
table.form-head thead td, table.form-head thead th {
  background-color: #add8e6;
}
table.form-head thead th {
  height: 17px;
}
table.form-head tbody td, table.form-head tbody th {
  background-color: #add8e6;
  font-size: 11px;
  height: 17px;
}
table.form-head tbody th, table.form-head thead th {
  text-align: right;
}

table.form-head tbody input[type=text] {
  font-size: 12px;
  height: 12px;
  padding: 3px 0 2px 3px;
  margin-left: 6px;
}
table.form-head tfoot td {
  background-color: #add8e6;
}

table.form-polozky thead th {
  border-bottom: 2px solid #ffff90;
  padding-bottom: 3px;
  font-size: 11px;
  height: 12px;
  padding-top: 8px;
}
table.form-polozky tbody th {
  padding-top: 4px;

}
table.form-polozky tbody td {
  font-size: 12px;
  background-color: #fff;
  border-left: 2px solid lightblue;
  border-bottom: 2px solid lightblue;
  height: 12px;
  padding-bottom: 3px;
}
table.form-polozky tfoot th {
  height: 12px;
  font-size: 12px;
  padding: 8px 0 7px 0;
}
table.form-polozky tfoot td {
  font-size: 14px;
  font-weight: bold;
}

table.form-polozky tbody input[type=text] {
  font-size: 12px;
  height: 12px;
  padding: 3px 0 2px 3px;
}

a.form-head-tool {
  display: block;
  width: 24px;
  height: 24px;
  cursor: pointer;
  margin-left: 10px;
}
a.form-head-tool > img {
  width: 18px;
  height: 18px;
  margin: 1px 0 0 3px;
  display: inline-block;
  cursor: pointer;
}


a.btn-prepni {
  font-size: 14px;
  text-decoration: none;
  color: white;
  padding: 4px 15px;
  background-color: #ABD159;
  border: 1px solid #86A83D;
}
a.btn-prephead {
  text-decoration: none;
  font-size: 13px;
  display: block;
  border: 2px solid #3389a6;
  border-radius: 6px;
  background-color: #86c5da;
  width: 80px;
  line-height: 16px;
  padding: 4px 2px 3px 2px;
  color: #3389a6;
  text-align: center;
  margin: 0 auto;
  position: relative;
  top: 30px;
}

div.nofill {
  background-color: #fff;
  padding: 3px 0 2px 4px;
  margin-left: 6px;
  font-size: 12px;
}
table.ponuka {
  width: 100%;
  font-size: 12px;
  font-weight: bold;
  background-color: #ffff90;
}
table.ponuka td {
  height: 16px;
  padding-top: 1px;
  padding-bottom: 1px;
  border: 2px solid #ffff90;
  background-color:
}
table.ponuka tr {
  background-color: #fff;
}
table.ponuka tr:hover {
  background-color: #eee;
}

table.ponuka td > input[type=image] {
  display: inline-block;
  width: 16px;
  height: 16px;
  position: relative;
  top: 3px;
  margin-right: 5px;
  margin-left: 5px;
}

div.alert-red {
  width: 350px;
  line-height: 26px;
  background-color:red;
  font-weight:bold;
  font-size: 14px;
  text-indent: 10px;
  border-radius: 3px;
  z-index: 10;
}
div.alert-ponuka {
  z-index: 10;
  position: absolute;
}


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

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }


<?php  if( $zmtz == 1 ) { ?>


function ZmazPolozku(plu, dok)
                {

var plux = plu;
var dokx = dok;

window.open('dodobj_u.php?copern=6101&drupoh=1&page=1&plux='+ plux + '&cislo_dok='+ dokx + '&zmtz=<?php echo $zmtz; ?>', '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZmazPolozkuUplne(plu, dok)
                {

var plux = plu;
var dokx = dok;

window.open('dodobj_u.php?copern=6002&drupoh=1&page=1&plux='+ plux + '&cislo_dok='+ dokx + '&zmtz=<?php echo $zmtz; ?>', '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function SpatZoznam()
                {

window.open('../dodobj/dodobj.php?copern=1&drupoh=1&page=1&zmtz=1&html=1', '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }



function Export1OBJ(dok)
                {

var dokx = dok;

window.open('obj_export.php?copern=1&drupoh=1&cislo_dok='+ dokx + '&ffd=0',
 '_blank', 'width=1080, height=900, top=0, left=40, status=yes, resizable=yes, scrollbars=yes' );
                 }

function Export2OBJ(dok)
                {

var dokx = dok;

window.open('obj_export.php?copern=1&drupoh=1&cislo_dok='+ dokx + '&ffd=1',
 '_blank', 'width=1080, height=900, top=0, left=40, status=yes, resizable=yes, scrollbars=yes' );
                 }

<?php                    } ?>



    function textObj( objx )
    {

var h_obj = objx;

window.open('../dodobj/dodobj_pozn.php?h_obj=' + h_obj + '&copern=1&drupoh=1&page=1&zmtz=1', '_blank',  'width=900, height=800, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

    }

function TlacOBJ(plu)
                {
var plux = plu;

window.open('dodobj_t.php?copern=1&drupoh=1&page=1&cislo_dok=' + plux + '&ffd=0&tlacobj=1&zmtz=<?php echo $zmtz; ?>', '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacOBJnoprice(plu)
                {
var plux = plu;

window.open('dodobj_t.php?copern=1&drupoh=1&page=1&cislo_dok=' + plux + '&ffd=0&tlacobj=1&zmtz=<?php echo $zmtz; ?>&noprice=1', '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function NovaOBJ()
                {
window.open('dodobj.php?copern=7701&drupoh=1&page=1&plux=0&ffd=0&zmtz=<?php echo $zmtz; ?>', '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function newIco()
                {
window.open('../cis/cico.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=5&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function xDatvEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.xdatd.focus();
        document.forms.formv1.xdatd.select();
              }
                }

function xDatdEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.xice.focus();
        document.forms.formv1.xice.select();
              }
                }

function xIceEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.xfir.focus();
        document.forms.formv1.xfir.select();
              }
                }

function xFirEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.xplat.focus();
        document.forms.formv1.xplat.select();
              }
                }

function xPlatEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.xdop.focus();
        document.forms.formv1.xdop.select();
              }
                }

function xDopEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.xstav.focus();
        document.forms.formv1.xstav.select();
              }
                }

function xStavEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
              document.forms.formv1.submit(); return (true);
              }
                }

function xCisEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.xnat.focus();
        document.forms.formv1.xnat.select();
              }
                }

function xNatEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.xced.focus();
        document.forms.formv1.xced.select();
              }
                }

function xCedEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.xmno.focus();
        document.forms.formv1.xmno.select();
              }
                }

function xMnoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        hodnota = document.forms.formv1.xced.value*document.forms.formv1.xmno.value;
        document.forms.formv1.xhdd.value = hodnota.toFixed(2);
        document.forms.formv1.xhdd.focus();
        document.forms.formv1.xhdd.select();
              }
                }

function xHddEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
              document.forms.formv1.submit(); return (true);
              }
                }

function CiarkaNaBodku(Vstup, e)
    {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k != 13 ){
Vstup.value=Vstup.value.replace(",",".");
              }
    }

</script>

<script type="text/javascript" src="spr_ico_xml.js"></script>
<script type="text/javascript" src="spr_plu_xml.js"></script>


<script type="text/javascript">
<?php
//uprava hlavicka
  if ( $copern == 1 )
  {
?>
    function ObnovUI()
    {
    document.formv1.xdatv.value = '<?php echo "$xdatvsk";?>';
    document.formv1.xdatd.value = '<?php echo "$xdatdsk";?>';
    document.formv1.xplat.value = '<?php echo "$xplat";?>';
    document.formv1.xice.value = '<?php echo "$xice";?>';
    document.formv1.xfir.value = '<?php echo "$nai";?>';
    document.formv1.xdop.value = '<?php echo "$xdop";?>';
    document.formv1.xstav.value = '<?php echo "$xstav";?>';
    document.formv1.uloz.disabled = true;
    document.formv1.xdatv.focus();
    document.formv1.xdatv.select();

    }
<?php
//koniec uprava
  }
?>

<?php
//uprava polozky
  if ( $copern == 2 )
  {
?>
    function ObnovUI()
    {

<?php if( $opakujinput == 1 ){ ?>

    document.formv1.xcis.value = '<?php echo "$xcis";?>';
    document.formv1.xnat.value = '<?php echo "$xnat";?>';
    document.formv1.xced.value = '<?php echo "$xced";?>';
    document.formv1.xmno.value = '<?php echo "$xmno";?>';
    document.formv1.xhdd.value = '<?php echo "$xhdd";?>';
    document.formv1.uloz.disabled = true;
    document.formv1.xnat.focus();
    document.formv1.xnat.select();
<?php                        } ?>

<?php if ( $zmazalsom == 1 ) { ?>

    document.formv1.xcis.value = '<?php echo "$xcisz";?>';
    document.formv1.xnat.value = '<?php echo "$xnatz";?>';
    document.formv1.xced.value = '<?php echo "$xcedz";?>';
    document.formv1.xmno.value = '<?php echo "$xmnoz";?>';

<?php                        } ?>

<?php if ( $opakujinput == 0 ) { ?>
    document.formv1.uloz.disabled = true;
    document.formv1.xnat.focus();
    document.formv1.xnat.select();
<?php                          } ?>

    }

<?php
//koniec uprava
  }
?>

function NacitajMin(dok, ico)
                {

var dokx = dok;
var akeicox = ico;

window.open('dodobj_u.php?copern=191918&drupoh=1&page=1&cislo_dok='+ dokx + '&akeico='+ akeicox + '&zmtz=<?php echo $zmtz; ?>', '_self' );
                }
</script>
</HEAD>

<BODY onload="ObnovUI();">
<!-- zahlavie -->
<div class="wrap-heading">
 <div class="ilogin">
  <h6 class="toleft">EuroSecom</h6>
  <h6 class="toright">
   <strong>UME</strong><?php echo $kli_vume; ?>
   <strong>FIR</strong><?php echo "$kli_vxcf:$kli_nxcf"; ?>
   <strong>login</strong><?php echo "$kli_uzmeno $kli_uzprie / $kli_uzid"; ?>
  </h6>
 </div>
 <div class="heading">
  <h1 class="toleft">Dod·vateæsk· objedn·vka</h1>
  <a href="#" onclick="SpatZoznam();" class="toright btn-prepni" style="position:relative; top:6px;">
   <img src="../obr/back_white.png" title="Sp‰ù na zoznam objedn·vok"
        style="width:16px; height:16px; vertical-align:middle;">&nbsp;Zoznam</a>
 </div>
</div>

<div class="content">
<div id="myIcoElement" class="alert-ponuka" style="top:78px; left:65%;"></div> <!-- ponuka ico -->
<?php
if ( $docasnemazanie == 0 )
     {
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$sqlt = <<<mzdprc
(
   pox          decimal(10,0) DEFAULT 0,
   xdok         int DEFAULT 0,
   xice         decimal(10,0) DEFAULT 0,
   xodbm        decimal(10,0) DEFAULT 0,
   xsx2         decimal(10,0) DEFAULT 0,
   xsx3         decimal(10,0) DEFAULT 0,
   xcpl         int(10) DEFAULT 0,
   xcis         varchar(15) NOT NULL,
   xnat         VARCHAR(50) NOT NULL,
   xdph         DECIMAL(2,0) DEFAULT 20,
   xcep         decimal(10,4) DEFAULT 0,
   xced         decimal(10,2) DEFAULT 0,
   xmno         decimal(10,3) DEFAULT 0,
   xhdb         decimal(10,2) DEFAULT 0,
   xhdd         decimal(10,2) DEFAULT 0,
   xid          INT DEFAULT 0,
   xdatm        TIMESTAMP(14),
   xskm         decimal(10,3) DEFAULT 0,
   xobm         decimal(10,3) DEFAULT 0,
   xrzd         decimal(10,3) DEFAULT 0,
   xpsk         decimal(10,3) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

if( $fir_fico == '46614478' )
  {
$sqlttt = "ALTER TABLE F".$kli_vxcf."_mzdprcx$kli_uzid MODIFY xced decimal(10,4) DEFAULT 0 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "ALTER TABLE F".$kli_vxcf."_mzdprcu$kli_uzid MODIFY xced decimal(10,4) DEFAULT 0 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "ALTER TABLE F".$kli_vxcf."_mzdprcx$kli_uzid MODIFY xced decimal(10,4) DEFAULT 0 ";
$sqldok = mysql_query("$sqlttt");
  }

$tlacobj = 1*$_REQUEST['tlacobj'];


//zober z objednavok
$podmdok=" xdok = ".$cislo_dok." ";
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,xdok,xice,xodbm,xsx2,xsx3,xcpo,xcis,xnat,xdph,xcep,xced,xmno,xhdb,xhdd,xid,xdatm,0,0,0,0 FROM F$kli_vxcf"."_dodavobj ".
" WHERE $podmdok AND xfak = 0 ".
"";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
//exit;
     }

//group vsetko
$podmgrp=" xdok";
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 10,xdok,xice,0,xsx2,0,xcpl,xcis,xnat,xdph,xcep,xced,SUM(xmno),SUM(xhdb),SUM(xhdd),xid,xdatm,SUM(xskm),SUM(xobm),SUM(xrzd),SUM(xpsk)  FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE xdok > 0 GROUP BY $podmgrp".
"";
$dsql = mysql_query("$dsqlt");
?>

<!-- zahlavie objednavky -->
<table class="form-head" style="width:100%;">
<thead>
<tr class="zero-line">
 <td width="12%"></td><td width="23%"></td><td width="30%"></td>
 <td width="12%"></td><td width="23%"></td>
</tr>
<tr>
 <th style="font-size:14px;"><span style="position:relative; top:6px;">Objedn·vka Ë.</span></th>
 <td style="font-size:14px;">
   <div style="width:20px; text-align:center; background-color:#ffff90; padding:3px 0 2px 0; margin-left:6px; position:relative; top:7px;"><?php echo $cislo_dok; ?></div>
 </td>
 <td colspan="3" style="background-color:#fff;">&nbsp;
<?php if ( $vseobj == 0 ) { ?>
  <a href="#" onclick="TlacOBJ(<?php echo $cislo_dok; ?>);" class="toleft form-head-tool"><img src='../obr/tlac.png' title='Zobraziù objedn·vku v PDF'>
  </a> <!-- dopyt, musÌ tu byù <a>? -->
<?php                     } ?>
  <a href="#" onclick="TlacOBJnoprice(<?php echo $cislo_dok; ?>);" class="toleft form-head-tool"><img src='../obr/tlac.png' title='Zobraziù objedn·vku bez n·kupn˝ch cien v PDF'></a>
  <a href="#" onclick="NacitajMin(<?php echo $cislo_dok; ?>, <?php echo $ico; ?>);" class="toleft form-head-tool"><img src="../obr/vlozit.png" title='NaËÌtaù poloûky zo zostavy o vyhodnotenÌ minim·lnych z·sob za <?php echo $nai; ?>'></a>
 </td>
</tr>
</thead>
<tbody>
<tr>
 <td colspan="5" style="height:4px;"></td>
</tr>
<?php
$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_mzdprcx".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_mzdprcx".$kli_uzid.".xcis=F$kli_vxcf"."_sklcis.cis".
" WHERE ( xdok > 0 ) ORDER BY pox,xcpl ";

//echo $sqltt;
//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

$strana=0;
$j=0;
$i=0;
  while ($i <= $tvpol )
  {
  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);

$skdatum=SkDatum($riadok->xdatm);

//prva polozka
if ( $j == 0 )
        {
?>

<?php
//hlavicka vyplnatelna
if ( $copern == 1 )
     {
?>
<FORM name="formv1" method="post" action="dodobj_u.php?copern=11&cislo_dok=<?php echo $cislo_dok; ?>">
<tr>
 <th>D·tum vystavenia</th>
 <td>
  <input type="text" name="xdatv" id="xdatv" maxlength="10" onKeyDown="return xDatvEnter(event.which);"
         onkeyup="CiarkaNaBodku(this, event.which);" style="width:80px;"/>
 </td>
 <td rowspan="3">&nbsp;</td>
 <th>
  <img src='../obr/ziarovka.png' onclick="newIco();" title="Vloûiù novÈ I»O do datab·zy"
       style="width:15px; height:15px; cursor:pointer;">
Dod·vateæ - <span style="font-weight:normal;">I»O</span>
 </th>
 <td>
  <input type="text" name="xice" id="xice" maxlength="8" onKeyDown="return xIceEnter(event.which)"
         style="width:70px;"/>&nbsp;
  <img src='../obr/hladaj.png' onclick="volajIco();" title="Hæadaù I»O alebo n·zov firmy" style="width:16px; height:16px; cursor:pointer;">
 </td>
</tr>
<tr>
 <th>D·tum dodania</th>
 <td>
  <input type="text" name="xdatd" id="xdatd" maxlength="10" onKeyDown="return xDatdEnter(event.which);"
         onkeyup="CiarkaNaBodku(this);" style="width:80px;"/>
 </td>
 <th><span style="font-weight:normal;">Firma</span></th>
 <td>
  <input type="text" name="xfir" id="xfir" onKeyDown="return xFirEnter(event.which)"
         style="width:160px;"/>
 </td>
</tr>
<tr>
 <th>SpÙsob platby</th>
 <td>
  <input type="text" name="xplat" id="xplat" onKeyDown="return xPlatEnter(event.which)"
         style="width:160px;"/>
 </td>
 <th>Doprava</th>
 <td>
  <input type="text" name="xdop" id="xdop" onKeyDown="return xDopEnter(event.which)"
         style="width:160px;"/>
 </td>
</tr>
<tr>
 <th rowspan="2">
  <img src='../obr/orig.png' onclick="textObj('<?php echo $cislo_dok;?>')"
       title="Pozn·mka k objedn·vke" style="width:20px; height:15px; cursor:pointer;">&nbsp;Pozn·mka
 </th>
 <td rowspan="2">
<span style="margin-left:7px; background-color:#fff; font-size:12px; padding:2px;">
<?php
//poznamka
$poznx="";
$sqlfir = "SELECT * FROM F$kli_vxcf"."_dodavobjtext WHERE invt = $cislo_dok ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $poznx = $fir_riadok->itxt; }
$poznx=substr($poznx,0,80);
echo $poznx." ...";
?>
</span>
 </td>
 <td rowspan="2">
  <div id="uvolni" onmouseover="document.formv1.uloz.disabled = false;"
       style="width:120px; line-height:27px; position:relative; top:22px; text-align:center; margin:0 auto;">
<INPUT type="submit" id="uloz" name="uloz" value="Uloûiù hlaviËku" style="cursor:pointer; padding:2px 5px;">
</div>
 </td>
 <td colspan="2">&nbsp;</td>
</tr>
<tr>
 <th>Stav</th>
 <td>
  <input type="text" name="xstav" id="xstav" onKeyDown="return xStavEnter(event.which)"
         style="width:160px;"/>
 </td>
</tr>
</FORM>
<?php
//koniec hlavicka vyplnatelna copern=1
     }
?>

<?php
//hlavicka vypis
if ( $copern == 2 )
     {
?>
<tr>
 <th>D·tum vystavenia</th>
 <td>
  <div class="nofill" style="width:100px;"><?php echo $xdatvsk; ?></div>
 </td>
 <td rowspan="5">
  <a href="dodobj_u.php?copern=1&drupoh=1&page=1&cislo_dok=<?php echo $cislo_dok; ?>&ffd=0&tlacobj=1&zmtz=1" class="btn-prephead">Upraviù hlaviËku</a>
 </td>
 <th>Dod·vateæ</th>
 <td class="bmenu" rowspan="2">
  <div class="nofill" style="width:250px; line-height:15px;"><?php echo $ico; ?><br><?php echo $nai; ?> <?php echo $na2; ?></div>
 </td>
</tr>
<tr>
 <th>D·tum dodania</th>
 <td>
  <div class="nofill" style="width:100px;" ><?php echo $xdatdsk; ?></div>
 </td>
 <th></th>
</tr>
<tr>
 <th>SpÙsob platby</th>
 <td>
  <div class="nofill" style="width:200px;"><?php echo $xplat; ?>&nbsp;</div>
 </td>
 <th>Doprava</th>
 <td>
  <div class="nofill" style="width:200px;"><?php echo $xdop; ?>&nbsp;</div>
 </td>
</tr>
<tr>
 <th>Pozn·mka</th>
 <td rowspan="2">
<div class="nofill" style="width:250px; height:32px;">
<?php
//poznamka
$poznx="";
$sqlfir = "SELECT * FROM F$kli_vxcf"."_dodavobjtext WHERE invt = $cislo_dok ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $poznx = $fir_riadok->itxt; }
$poznx=substr($poznx,0,80);
echo $poznx." ...";
?>
</div>
 </td>
 <td colspan="2"></td>
</tr>
<tr>
 <td class="bmenu"></td>
 <th>Stav</th>
 <td>
  <div class="nofill" style="width:100px;" ><?php echo $xstav; ?>&nbsp;</div>
 </td>
</tr>
<tr>
 <td colspan="5" style="height:2px;" ></td>
</tr>
<?php
//koniec hlavicka vypis copern=2
     }
?>
</tbody>
<tfoot>
<tr>
 <td colspan="5" style="height:4px;"></td>
</tr>
</tfoot>
</table>

<div class="form-content" style="margin-top:8px; position:relative;">
<div id='myDivElement' class="alert-ponuka" style="width:100%; top:80px;"></div> <!-- ponuka poloziek -->
 <h3 style="height:25px; font-size:18px;">&nbsp;Objedn·vame si u V·s:</h3>
<!-- polozky objednavky -->
<table class="form-polozky" style="width:100%; background-color:lightblue;">
<thead>
<tr class="zero-line">
 <td width="8%"></td><td width="40%"></td><td width="8%"></td><td width="12%"></td>
 <td width="10%"></td><td width="7%"></td><td width="10%"></td><td width="5%"></td>
</tr>
<tr>
 <th>»Ìslo</th>
 <th class="left">N·zov</th>
 <th>DPH</th>
 <th>Jednotkov· Cena</th>
 <th>Mnoûstvo</th>
 <th>M.j.</th>
 <th>Hodnota</th>
 <th></th>
</tr>
</thead>
<tbody>
<script type="text/javascript">
  function hladPLU()
  {
	 myDivElement.style.display='';
	 volajSlu();
  }
  function vykonajPlu(slu,nazov,dph,cenap,cenad,cenan,zas,mer)
  {
   document.forms.formv1.xcis.value = slu;
   document.forms.formv1.xnat.value = nazov;
   document.forms.formv1.xced.value = cenan;
   document.forms.formv1.xmno.value = zas;

   myDivElement.style.display='none';
   document.forms.formv1.xced.focus();
   document.forms.formv1.xced.select();
  }
</script>
<?php
if ( $copern == 2 )
     {
?>
<FORM name="formv1" method="post" action="dodobj_u.php?copern=22&cislo_dok=<?php echo $cislo_dok; ?>">
<tr>
 <th>
  <input type="text" name="xcis" id="xcis" onKeyDown="return xCisEnter(event.which)" style="width:40px;"/>
 </th>
 <th class="left">
  <img src='../obr/hladaj.png' onclick="hladPLU();" title='Hladaù poloûku' style="width:15px; height:15px; cursor:pointer;">
  <input type="text" name="xnat" id="xnat" onKeyDown="return xNatEnter(event.which)" style="width:90%;"/>
 </th>
 <th></th>
 <th class="center">
  <input type="text" name="xced" id="xced" onkeyup="CiarkaNaBodku(this);" onKeyDown="return xCedEnter(event.which)" style="width:70px;"/>
 </th>
 <th class="center">
  <input type="text" name="xmno" id="xmno" onkeyup="CiarkaNaBodku(this);" onKeyDown="return xMnoEnter(event.which)" style="width:60px;"/>
 </th>
 <th></th>
 <th class="center">
  <input type="text" name="xhdd" id="xhdd" style="width:70px;" onkeyup="CiarkaNaBodku(this);" onKeyDown="return xHddEnter(event.which)"/>
 </th>
 <th></th>
</tr>
<tr>
 <th colspan="8" style="padding-bottom:4px;">
<div id="uvolni" onmouseover="document.formv1.uloz.disabled = false;" style="width:90px; line-height:28px; text-align:center;">
<INPUT type="submit" id="uloz" name="uloz" value="Uloûiù">
</div>
 </th>
</tr>
</FORM>
<?php
     }
//koniec copern=2
?>
<?php
        }
//koniec hlavicky j=0
?>


<?php
//polozky vypis
if ( $copern == 1 OR $copern == 2 )
     {
?>
<?php
if ( $riadok->pox == 1 AND $riadok->xsx2 == 0 )
{
?>
<tr>
 <td class="center"><?php echo $riadok->xcis; ?></td>
 <td>&nbsp;&nbsp;<?php echo $riadok->xnat; ?></td>
 <td class="center"><?php echo $riadok->xdph; ?></td>
 <td class="right"><?php echo $riadok->xced; ?>&nbsp;</td>
 <td class="right"><?php echo $riadok->xmno; ?>&nbsp;</td>
 <td class="center"><?php echo $riadok->mer; ?></td>
 <td class="right"><?php echo $riadok->xhdd; ?>&nbsp;</td>
 <td class="center" style="background-color:lightblue; border:none;">
<?php if ( $vseobj == 0 AND $somvprirskl == 0 ) { ?>
  <a href="#" onclick="ZmazPolozkuUplne(<?php echo $riadok->xcpl; ?>,<?php echo $riadok->xdok; ?>);">
   <img src='../obr/zmazuplne.png' width=20 height=15 title='Zmazaù poloûku z objedn·vky' >
  </a>
<?php                                           } ?>
 </td>
</tr>
<?php
}
//koniec polozky vypis
     }
?>
</tbody>
<?php
if ( $riadok->pox == 10 ) {
?>
<tfoot>
<tr>
<?php if ( $vseobj == 0 ) { ?>
<?php if ( $fir_fico == '36268399' ) { ?>
<th colspan="3" class="left">&nbsp;&nbsp;Sum·r objedn·vky Ë. <?php echo $riadok->xdok; ?>&nbsp;s dph</th>
<?php                                } ?>
<?php if ( $fir_fico != '36268399' ) { ?>
<th colspan="3" class="left">&nbsp;&nbsp;Sum·r objedn·vky Ë. <?php echo $riadok->xdok; ?></th>
<?php                                } ?>


<?php } ?>
 <td></td>
 <td class="right"><?php echo $riadok->xmno; ?></td>
 <td></td>
 <td class="right" style="background-color:#FFFF90; border-bottom:2px solid lightblue; border-left:2px solid lightblue;"><?php echo $riadok->xhdd; ?>&nbsp;</td>
 <td></td>
</tr>
<tr>
 <td colspan="8" style="height:4px;"></td>
</tr>
</tfoot>
<?php
                          }
}
$i = $i + 1;
$j = $j + 1;
if ( $j > 30 AND $html == 0 ) $j=0;
  }
?>

</table>
</div>  <!-- .form-content -->

<a href="#" onclick="NovaOBJ();" class="btn-prepni" style="float:right; position:relative; top:5px;"><strong>Nov·</strong>&nbsp;objedn·vka</a>
</div> <!-- .content -->

<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
