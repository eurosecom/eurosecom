<!doctype html>
<HTML>
<?php
do
{
$sys = 'UCT';
$urov = 2000;
$copern = $_REQUEST['copern'];

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$citfir = include("../cis/citaj_fir.php");

$xume = 1*$_REQUEST['xume'];
$xstv = 1*$_REQUEST['xstv'];
$xpov = 1*$_REQUEST['xpov'];
$xdod = 1*$_REQUEST['xdod'];
//$ddosql = SqlDatum($_REQUEST['xddo']);

$sqlt = "CREATE TABLE F".$kli_vxcf."_archivdphkvdphmanual SELECT * FROM F".$kli_vxcf."_archivdphkvdph WHERE cpl < 0 ";
$vysledok = mysql_query("$sqlt");

$sql = "ALTER TABLE F".$kli_vxcf."_archivdphkvdphmanual MODIFY cpl int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sqltt = "SELECT * FROM F$kli_vxcf"."_archivdphkvdphmanual WHERE kvodd = 'XXX' ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
if ( $pol == 0 )
     {
$sqty = "DELETE FROM F$kli_vxcf"."_archivdphkvdphmanual WHERE kvodd = 'XXX' ";
$ulozene = mysql_query("$sqty");
$sqty = "INSERT INTO F$kli_vxcf"."_archivdphkvdphmanual ( kvodd,ume,er2,er3,er4 ) VALUES ( 'XXX', '$xume', '$xstv', '0', '$xdod' ) ";
$ulozene = mysql_query("$sqty");
     }

$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$kvodd = strip_tags($_REQUEST['kvodd']);
$kvicd = strip_tags($_REQUEST['kvicd']);
$kvfak = strip_tags($_REQUEST['kvfak']);
$kvpvf = strip_tags($_REQUEST['kvpvf']);
$dazsql = SqlDatum($_REQUEST['kvdaz']);
$kvzdn = 1*$_REQUEST['kvzdn'];
$kvsdn = 1*$_REQUEST['kvsdn'];
$kvszd = 1*$_REQUEST['kvszd'];
if ( $kvszd == 0 ) { $kvszd=$fir_dph2;  }
$kver1 = 1*$_REQUEST['kver1'];
if ( $kver1 == 0 ) { $kver1=2;  }


$kvzkl = 1*$_REQUEST['kvzkl'];
$kvkodt = strip_tags($_REQUEST['kvkodt']);
$kvdtov = strip_tags($_REQUEST['kvdtov']);
$kvmnot = strip_tags($_REQUEST['kvmnot']);
$kvmerj = strip_tags($_REQUEST['kvmerj']);

$kvodn = 1*$_REQUEST['kvodn'];

$kvzcobr = 1*$_REQUEST['kvcobr'];
$kvzdn20 = 1*$_REQUEST['kvzdn20'];
$kvsdn20 = 1*$_REQUEST['kvsdn20'];
$kvzdn10 = 1*$_REQUEST['kvzdn10'];
$kvsdn10 = 1*$_REQUEST['kvsdn10'];

//uloz ako pridavok
if ( $copern == 28001 )
{
$xxpov = 1*$_REQUEST['xxpov'];
?>
<script type="text/javascript">
if( !confirm ("Chcete uloûiù tieto riadky KVDPH ako prÌdavok ku KVDPH s ID ËÌslom <?php echo $xxpov; ?> ?") )
         { var okno = window.close();  }
else
  var okno = window.open("kontrolnydph2014_manual.php?copern=28002&xxpov=<?php echo $xxpov; ?>","_self");
</script>
<?php
$copern=1;
exit;
}
if ( $copern == 28002 )
{
$xxpov = 1*$_REQUEST['xxpov'];
$sqty = "DROP TABLE F$kli_vxcf"."_archivdphkvdphmanualplus".$xxpov." ";
$ulozene = mysql_query("$sqty");
$sqlt = "CREATE TABLE F".$kli_vxcf."_archivdphkvdphmanualplus$xxpov SELECT * FROM F".$kli_vxcf."_archivdphkvdphmanual WHERE er1 = 2 ";
$vysledok = mysql_query("$sqlt");

?>
<script type="text/javascript">
alert ("Riadky tohoto manu·lneho KVDPH boli uloûenÈ \r ako prÌdavok ku KVDPH s ID ËÌslom <?php echo $xxpov; ?>. \r Zmazaù alebo zmeniù prÌdavok mÙûete opakovan˝m \r uloûenÌm pr·zdneho alebo zmenenÈho manu·lneho KVDPH \r do KVDPH s ID ËÌslom <?php echo $xxpov; ?> !");
</script>
<?php
$copern=1;

}
//koniec uloz ako pridavok

//nova polozka
if ( $copern >= 15000 AND $copern <= 15999 )
{
if ( $copern == 15000 )
     {
$sqty = "DELETE FROM F$kli_vxcf"."_archivdphkvdphmanual WHERE kvodd = 'XXX' ";
$ulozene = mysql_query("$sqty");

$sqty = "UPDATE F$kli_vxcf"."_archivdph SET cpop='$xpov' WHERE cpid = $xdod ";
$ulozene = mysql_query("$sqty");
//echo $sqty;

$sqty = "INSERT INTO F$kli_vxcf"."_archivdphkvdphmanual ( kvodd,ume,er2,er3,er4,dat ) VALUES ( 'XXX', '$xume', '$xstv', '$xpov', '$xdod', '$ddosql' ) ";
   }
if ( $copern == 15001 )
   {
$sqty = "INSERT INTO F$kli_vxcf"."_archivdphkvdphmanual ( kvodd,kvicd,kvfak,daz,kvzdn,kvsdn,kvszd,er1 )".
" VALUES ('A1', '$kvicd', '$kvfak', '$dazsql', '$kvzdn', '$kvsdn', '$kvszd', '$kver1' ) ";
   }
if ( $copern == 15002 )
   {
$sqty = "INSERT INTO F$kli_vxcf"."_archivdphkvdphmanual ( kvodd,kvicd,kvfak,daz,kvzkl,kvkodt,kvdtov,kvmnot,kvmerj,er1 )".
" VALUES ('A2', '$kvicd', '$kvfak', '$dazsql', '$kvzkl', '$kvkodt', '$kvdtov', '$kvmnot', '$kvmerj', '$kver1' ) ";
  }
if( $copern == 15003 )
  {
$sqty = "INSERT INTO F$kli_vxcf"."_archivdphkvdphmanual ( kvodd,kvicd,kvfak,daz,kvzdn,kvsdn,kvszd,kvodn,er1 )".
" VALUES ('B1', '$kvicd', '$kvfak', '$dazsql', '$kvzdn', '$kvsdn', '$kvszd', '$kvodn', '$kver1' ) ";
  }
if( $copern == 15004 )
  {
$sqty = "INSERT INTO F$kli_vxcf"."_archivdphkvdphmanual ( kvodd,kvicd,kvfak,daz,kvzdn,kvsdn,kvszd,kvodn,er1 )".
" VALUES ('B2', '$kvicd', '$kvfak', '$dazsql', '$kvzdn', '$kvsdn', '$kvszd', '$kvodn', '$kver1' ) ";
  }
if( $copern == 15005 )
  {
$sqty = "INSERT INTO F$kli_vxcf"."_archivdphkvdphmanual ( kvodd,kvzdn,kvsdn,kvszd,kvodn,er1 )".
" VALUES ('B3', '$kvzdn', '$kvsdn', '$kvszd', '$kvodn', '$kver1' ) ";
  }
if( $copern == 15006 )
  {
$sqty = "INSERT INTO F$kli_vxcf"."_archivdphkvdphmanual ( kvodd,kvicd,kvfak,kvpvf,kvzkl,kvsdn,kvszd,kvkodt,kvdtov,kvmnot,kvmerj,er1 )".
" VALUES ('C1', '$kvicd', '$kvfak', '$kvpvf', '$kvzkl', '$kvsdn', '$kvszd','$kvkodt', '$kvdtov', '$kvmnot', '$kvmerj', '$kver1' ) ";
  }
if( $copern == 15007 )
  {
$sqty = "INSERT INTO F$kli_vxcf"."_archivdphkvdphmanual ( kvodd,kvicd,kvfak,kvpvf,kvzdn,kvsdn,kvszd,kvodn,er1 )".
" VALUES ('C2', '$kvicd', '$kvfak', '$kvpvf', '$kvzdn', '$kvsdn', '$kvszd', '$kvodn', '$kver1' ) ";
  }
if( $copern == 15008 )
  {
$sqty = "INSERT INTO F$kli_vxcf"."_archivdphkvdphmanual ( kvodd,kvcobr,kvzdn20,kvsdn20,kvzdn10,kvsdn10,er1 )".
" VALUES ('D1', '$kvcobr', '$kvzdn20', '$kvsdn20', '$kvzdn10', '$kvsdn10','$kver1' ) ";
  }
if( $copern == 15009 )
  {
$sqty = "INSERT INTO F$kli_vxcf"."_archivdphkvdphmanual ( kvodd,kvcobr,kvzdn20,kvsdn20,kvzdn10,kvsdn10,er1 )".
" VALUES ('D2', '$kvcobr', '$kvzdn20', '$kvsdn20', '$kvzdn10', '$kvsdn10','$kver1' ) ";
  }
$ulozene = mysql_query("$sqty");
//echo $sqty;

$copern=1;
}
//koniec nova polozka

//zmaz polozku
if( $copern == 16001 )
{

$sqty = "DELETE FROM F$kli_vxcf"."_archivdphkvdphmanual WHERE cpl = $cislo_cpl "; 
$ulozene = mysql_query("$sqty");
//echo $sqty;

$copern=1;
}
//koniec zmaz polozku

//zmaz polozku
if ( $copern == 16099 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete zmazaù vöetky poloûky z manu·lneho dodatoËnÈho KV DPH ?") )
         { var okno = window.close();  }
else
  var okno = window.open("kontrolnydph2014_manual.php?copern=16089","_self");
</script>
<?php
$copern=1;
exit;
}
if ( $copern == 16089 )
{
$sqty = "DELETE FROM F$kli_vxcf"."_archivdphkvdphmanual ";
$ulozene = mysql_query("$sqty");
?>
<script type="text/javascript">
var okno = window.close();  
</script>
<?php
$copern=1;
exit;
}
//koniec zmaz polozky vsetky


//nacitaj roziely
if ( $copern == 18099 )
{
$cislo_cpop=1*$_REQUEST['cislo_cpop'];
$cislo_cpid=1*$_REQUEST['cislo_cpid'];
$cislo_ume=1*$_REQUEST['cislo_ume'];
$cislo_stvrt=1*$_REQUEST['cislo_stvrt'];
$cislo_druh=3;
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù rozdiely oproti pÙvodnÈmu KV DPH Ë. <?php echo $cislo_cpop; ?> ?") )
         { var okno = window.close();  }
else
  var okno = window.open("kontrolnydph2014_manual.php?copern=18089&cislo_cpop=<?php echo $cislo_cpop; ?>&cislo_cpid=<?php echo $cislo_cpid; ?>&cislo_ume=<?php echo $cislo_ume; ?>&cislo_druh=3&cislo_stvrt=<?php echo $cislo_stvrt; ?>","_self");
</script>
<?php
$copern=1;
exit;
}
if ( $copern == 18089 )
{
$cislo_cpop=1*$_REQUEST['cislo_cpop'];
$cislo_cpid=1*$_REQUEST['cislo_cpid'];
$cislo_ume=1*$_REQUEST['cislo_ume'];
$cislo_stvrt=1*$_REQUEST['cislo_stvrt'];
$cislo_druh=3;

?>
<script type="text/javascript">
function KvXml()
                {

window.open('../ucto/kontrolnydph2014.php?copern=7020&drupoh=1&page=1&typ=PDF&xmlko=1&cislo_cpop=<?php echo $cislo_cpop; ?>&cislo_cpid=<?php echo $cislo_cpid; ?>&cislo_ume=<?php echo $cislo_ume; ?>&cislo_druh=3&cislo_stvrt=<?php echo $cislo_stvrt; ?>&rozdiel=0&poslidomanual=1',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

KvXml();  
</script>
<?php
$copern=1;
exit;
}
//koniec zmaz polozky vsetky


$sqlfir = "SELECT * FROM F$kli_vxcf"."_archivdphkvdphmanual WHERE kvodd = 'XXX' ";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$xume = $fir_riadok->ume;
$xstv = $fir_riadok->er2;
$xpov = $fir_riadok->er3;
$xdod = $fir_riadok->er4;
$ddosk = SkDatum($fir_riadok->dat);
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - DodatoËn˝ KVDPH</title>
<style type="text/css">
#content {
  position: relative;
  width: 98%;
  margin: 10px 1% 0 1%;
  padding-bottom: 20px;
}
table.oddiel {
  width: 100%;
  min-width: 1000px;
  margin-top: 10px;
}
table.uvod {
  float: right;
  width: 400px;
  margin-bottom: 5px;
}
table.uvod td {
  height: 20px;
  line-height: 20px;
  font-size: 11px;
  font-weight: bold;
}
input.obdobie {
  width:60px;
  border: 1px solid #abadb3 !important;
  background-color: #ebebe4;
  color: #755454;
  cursor: not-allowed;
}
table.oddiel caption {
  height: 20px;
  line-height: 20px;
  font-size: 12px;
  text-align: left;
  background-color: #88c3ff;
}
table.oddiel caption > strong {
  font-size: 14px;
  padding:0 5px;
}
table.oddiel td, table.oddiel th {
  background-color: #fff;
  border: 1px solid lightblue;
}
table.oddiel td {
  font-size: 13px;
  height: 18px;
  line-height: 18px;
  text-align: center;
}
table.oddiel th {
  height: 14px;
  line-height: 14px;
  color: #999;
  font-size: 11px;
}
table.oddiel input[type=text], table.uvod input[type=text] {
  height: 16px;
  line-height: 16px;
  padding-left: 2px;
  border: 1px solid #39f;
  font-size: 13px;
}
table.oddiel select {
  border: 1px solid #39f;
  font-size: 12px;
}
table.oddiel img {
  position: relative;
  top: 2px;
  width: 16px;
  height: 16px;
  cursor: pointer;
}
div.ponuka-box {
  z-index: 10;
  position: fixed;
  top: 0;
  left: 0;
  height: 400px;
  overflow: auto;
}
table.ponuka {
  width: 700px;
  background-color: #ffff90;
}
table.ponuka caption {
  font-weight: bold;
  font-size: 15px;
  text-align: left;
  height: 24px;
  line-height: 24px;
  background-color: #ffff90;
  text-indent: 5px;
  border-bottom: none;
}
img.skry {
  position: relative;
  top: 3px;
  left: 585px;
  width: 18px;
  height: 18px;
  cursor: pointer;
}
input.ok-btn {
  position: relative;
  top: 2px;
}
table.ponuka td {
  height: 20px;
  line-height: 20px;
  font-size: 13px;
  text-align: center;
  background-color: white;
  border: 2px solid #ffff90;
}
table.ponuka th {
  font-size: 11px;
  font-weight: bold;
  height: 16px;
  line-height: 16px;
}
</style>

<script type="text/javascript">
    function Povol_uloz0()
    {
    var okvstup=1;

    if ( okvstup == 1 ) { document.fhlv0.uloz0.disabled = false; return (true); }
       else { document.fhlv0.uloz0.disabled = true;  return (false) ; }

    }

    function Povol_uloz1()
    {
    var okvstup=1;

    if ( okvstup == 1 ) { document.fhlv1.uloz1.disabled = false; return (true); }
       else { document.fhlv1.uloz1.disabled = true;  return (false) ; }

    }

    function Povol_uloz2()
    {
    var okvstup=1;

    if ( okvstup == 1 ) { document.fhlv2.uloz2.disabled = false; return (true); }
       else { document.fhlv2.uloz2.disabled = true;  return (false) ; }

    }


    function Povol_uloz3()
    {
    var okvstup=1;

    if ( okvstup == 1 ) { document.fhlv3.uloz3.disabled = false; return (true); }
       else { document.fhlv3.uloz3.disabled = true;  return (false) ; }

    }

    function Povol_uloz4()
    {
    var okvstup=1;

    if ( okvstup == 1 ) { document.fhlv4.uloz4.disabled = false; return (true); }
       else { document.fhlv4.uloz4.disabled = true;  return (false) ; }

    }

    function Povol_uloz5()
    {
    var okvstup=1;

    if ( okvstup == 1 ) { document.fhlv5.uloz5.disabled = false; return (true); }
       else { document.fhlv5.uloz5.disabled = true;  return (false) ; }

    }

    function Povol_uloz6()
    {
    var okvstup=1;

    if ( okvstup == 1 ) { document.fhlv6.uloz6.disabled = false; return (true); }
       else { document.fhlv6.uloz6.disabled = true;  return (false) ; }

    }

    function Povol_uloz7()
    {
    var okvstup=1;

    if ( okvstup == 1 ) { document.fhlv7.uloz7.disabled = false; return (true); }
       else { document.fhlv7.uloz7.disabled = true;  return (false) ; }

    }

    function Povol_uloz8()
    {
    var okvstup=1;

    if ( okvstup == 1 ) { document.fhlv8.uloz8.disabled = false; return (true); }
       else { document.fhlv8.uloz8.disabled = true;  return (false) ; }

    }

    function Povol_uloz9()
    {
    var okvstup=1;

    if ( okvstup == 1 ) { document.fhlv9.uloz9.disabled = false; return (true); }
       else { document.fhlv9.uloz9.disabled = true;  return (false) ; }

    }

  function VyberVstup()
  {
   document.fhlv0.xume.value = '<?php echo "$xume";?>';
    document.fhlv0.xstv.value = '<?php echo "$xstv";?>';
    document.fhlv0.xpov.value = '<?php echo "$xpov";?>';
    document.fhlv0.xdod.value = '<?php echo "$xdod";?>';


    document.forms.fhlv1.kvicd.focus();
    document.fhlv0.uloz0.disabled = true;
    document.fhlv1.uloz1.disabled = true;
    document.fhlv2.uloz2.disabled = true;
    document.fhlv3.uloz3.disabled = true;
    document.fhlv4.uloz4.disabled = true;
    document.fhlv5.uloz5.disabled = true;
    document.fhlv6.uloz6.disabled = true;
    document.fhlv7.uloz7.disabled = true;
    document.fhlv8.uloz8.disabled = true;
    document.fhlv9.uloz9.disabled = true;
    document.fh1v1.kvicd.focus();
    document.fh1v1.kvicd.select();
  }

//preskakovanie ENTER-om
//oddiel A1
  function kvicda1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv1.kvfak.focus();
        document.forms.fhlv1.kvfak.select();
                 }
  }
  function kvfaka1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv1.kvdaz.focus();
        document.forms.fhlv1.kvdaz.select();
                 }
  }
  function kvdaza1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv1.kvzdn.focus();
        document.forms.fhlv1.kvzdn.select();
                 }
  }
  function kvzdna1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv1.kvsdn.focus();
        document.forms.fhlv1.kvsdn.select();
                 }
  }
  function kvsdna1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv1.kvszd.focus();
        document.forms.fhlv1.kvszd.select();
                 }
  }
  function kvszda1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv1.kver1.focus();
        document.forms.fhlv1.kver1.select();
                 }
  }
  function kver1a1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv1.submit(); return (true);
                 }
  }
//oddiel A2
  function kvicda2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv2.kvfak.focus();
        document.forms.fhlv2.kvfak.select();
                 }
  }
  function kvfaka2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv2.kvdaz.focus();
        document.forms.fhlv2.kvdaz.select();
                 }
  }
  function kvdaza2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv2.kvzkl.focus();
        document.forms.fhlv2.kvzkl.select();
                 }
  }
  function kvzkla2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv2.kvkodt.focus();
        document.forms.fhlv2.kvkodt.select();
                 }
  }
  function kvkodta2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv2.kvdtov.focus();
        document.forms.fhlv2.kvdtov.select();
                 }
  }
  function kvdtova2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv2.kvmnot.focus();
        document.forms.fhlv2.kvmnot.select();
                 }
  }
  function kvmnota2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv2.kvmerj.focus();
        document.forms.fhlv2.kvmerj.select();
                 }
  }
  function kvmerja2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv2.kver1.focus();
        document.forms.fhlv2.kver1.select();
                 }
  }
  function kver1a2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv2.submit(); return (true);
                 }
  }
//oddiel B1
  function kvicdb1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv3.kvfak.focus();
        document.forms.fhlv3.kvfak.select();
                 }
  }
  function kvfakb1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv3.kvdaz.focus();
        document.forms.fhlv3.kvdaz.select();
                 }
  }
  function kvdazb1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv3.kvzdn.focus();
        document.forms.fhlv3.kvzdn.select();
                 }
  }
  function kvzdnb1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv3.kvsdn.focus();
        document.forms.fhlv3.kvsdn.select();
                 }
  }
  function kvsdnb1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv3.kvszd.focus();
        document.forms.fhlv3.kvszd.select();
                 }
  }
  function kvszdb1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv3.kvodn.focus();
        document.forms.fhlv3.kvodn.select();
                 }
  }
  function kvodnb1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv3.kver1.focus();
        document.forms.fhlv3.kver1.select();
                 }
  }
  function kver1b1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv3.submit(); return (true);
                 }
  }
//oddiel B.2
  function kvicdb2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv4.kvfak.focus();
        document.forms.fhlv4.kvfak.select();
                 }
  }
  function kvfakb2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv4.kvdaz.focus();
        document.forms.fhlv4.kvdaz.select();
                 }
  }
  function kvdazb2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv4.kvzdn.focus();
        document.forms.fhlv4.kvzdn.select();
                 }
  }
  function kvzdnb2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv4.kvsdn.focus();
        document.forms.fhlv4.kvsdn.select();
                 }
  }
  function kvsdnb2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv4.kvszd.focus();
        document.forms.fhlv4.kvszd.select();
                 }
  }
  function kvszdb2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv4.kvodn.focus();
        document.forms.fhlv4.kvodn.select();
                 }
  }
  function kvodnb2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv4.kver1.focus();
        document.forms.fhlv4.kver1.select();
                 }
  }
  function kver1b2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv4.submit(); return (true);
                 }
  }
//oddiel B.3
  function kvzdnb3Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv5.kvsdn.focus();
        document.forms.fhlv5.kvsdn.select();
                 }
  }
  function kvsdnb3Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv5.kvodn.focus();
        document.forms.fhlv5.kvodn.select();
                 }
  }
  function kvodnb3Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv5.kver1.focus();
        document.forms.fhlv5.kver1.select();
                 }
  }
  function kver1b3Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv5.submit(); return (true);
                 }
  }
//oddiel C.1
  function kvicdc1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv6.kvfak.focus();
        document.forms.fhlv6.kvfak.select();
                 }
  }
  function kvfakc1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv6.kvpvf.focus();
        document.forms.fhlv6.kvpvf.select();
                 }
  }
  function kvpvfc1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv6.kvzkl.focus();
        document.forms.fhlv6.kvzkl.select();
                 }
  }
  function kvzklc1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv6.kvzdn.focus();
        document.forms.fhlv6.kvzdn.select();
                 }
  }
  function kvzdnc1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv6.kvszd.focus();
        document.forms.fhlv6.kvszd.select();
                 }
  }
  function kvszdc1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv6.kvkodt.focus();
        document.forms.fhlv6.kvkodt.select();
                 }
  }
  function kvkodtc1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv6.kvdtov.focus();
        document.forms.fhlv6.kvdtov.select();
                 }
  }
  function kvdtovc1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv6.kvmnot.focus();
        document.forms.fhlv6.kvmnot.select();
                 }
  }
  function kvmnotc1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv6.kvmerj.focus();
        document.forms.fhlv6.kvmerj.select();
                 }
  }
  function kvmerjc1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv6.kver1.focus();
        document.forms.fhlv6.kver1.select();
                 }
  }
  function kver1c1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv6.submit(); return (true);
                 }
  }
//oddiel C.2
  function kvicdc2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv7.kvfak.focus();
        document.forms.fhlv7.kvfak.select();
                 }
  }
  function kvfakc2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv7.kvpvf.focus();
        document.forms.fhlv7.kvpvf.select();
                 }
  }
  function kvpvfc2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv7.kvzdn.focus();
        document.forms.fhlv7.kvzdn.select();
                 }
  }
  function kvzdnc2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv7.kvsdn.focus();
        document.forms.fhlv7.kvsdn.select();
                 }
  }
  function kvsdnc2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv7.kvszd.focus();
        document.forms.fhlv7.kvszd.select();
                 }
  }
  function kvszdc2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv7.kvodn.focus();
        document.forms.fhlv7.kvodn.select();
                 }
  }
  function kvodnc2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv7.kver1.focus();
        document.forms.fhlv7.kver1.select();
                 }
  }
  function kver1c2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv7.submit(); return (true);
                 }
  }
//oddiel D.1
  function kvcobrd1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv8.kvzdn20.focus();
        document.forms.fhlv8.kvzdn20.select();
                 }
  }
  function kvzdn20d1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv8.kvsdn20.focus();
        document.forms.fhlv8.kvsdn20.select();
                 }
  }
  function kvsdn20d1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv8.kvzdn10.focus();
        document.forms.fhlv8.kvzdn10.select();
                 }
  }
  function kvzdn10d1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv8.kvsdn10.focus();
        document.forms.fhlv8.kvsdn10.select();
                 }
  }
  function kvsdn10d1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv8.kver1.focus();
        document.forms.fhlv8.kver1.select();
                 }
  }
  function kver1d1Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv8.submit(); return (true);
                 }
  }
//oddiel D.2
  function kvzdn20d2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv9.kvsdn20.focus();
        document.forms.fhlv9.kvsdn20.select();
                 }
  }
  function kvsdn20d2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv9.kvzdn10.focus();
        document.forms.fhlv9.kvzdn10.select();
                 }
  }
  function kvzdn10d2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv9.kvsdn10.focus();
        document.forms.fhlv9.kvsdn10.select();
                 }
  }
  function kvsdn10d2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv9.kver1.focus();
        document.forms.fhlv9.kver1.select();
                 }
  }
  function kver1d2Enter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode;
   if ( k == 13 ){
        document.forms.fhlv9.submit(); return (true);
                 }
  }

  function New()
  {
   window.open('kontrolnydph2014_manual.php?copern=16099', '_self', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function vytvorXML()
  {
   window.open('../ucto/kontrolnydph2014.php?copern=7020&drupoh=1&page=1&typ=PDF&xmlko=1&dodatmanualxml=1&rozdiel=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function volajKvdph(oddiel)
  {
  //document.fhlv1.kvicd.value = "1122";
  volajKV(oddiel, <?php echo $xdod; ?>);
  }

//1-odd;icd;daz;fak;5-zdn;sdn;odn;szd;zkl;10-kodt;dtov;mnot;merj;cobr;15-cobr;zdn20;sdn20;zdn10;sdn10;20-pvf

  function vykonajKVDPH(oddiel,icd,datum,fak,zkl,suma,odn,szd,zkl2,kodt,dtov,mnot,merj,cobr,zdn20,sdn20,zdn10,sdn10,pvf)
  {

   if ( oddiel == "A1" )
      {
   document.forms.fhlv1.kvodd.value = oddiel;
   document.forms.fhlv1.kvicd.value = icd;
   document.forms.fhlv1.kvdaz.value = datum;
   document.forms.fhlv1.kvfak.value = fak;
   document.forms.fhlv1.kvzdn.value = zkl;
   document.forms.fhlv1.kvsdn.value = suma;
   document.forms.fhlv1.kvszd.value = szd;

      }
   if( oddiel == "A2" )
     {
   document.forms.fhlv2.kvodd.value = oddiel;
   document.forms.fhlv2.kvicd.value = icd;
   document.forms.fhlv2.kvdaz.value = datum;
   document.forms.fhlv2.kvfak.value = fak;
   document.forms.fhlv2.kvzkl.value = zkl2;
   document.forms.fhlv2.kvkodt.value = kodt;
   document.forms.fhlv2.kvdtov.value = dtov;
   document.forms.fhlv2.kvmnot.value = mnot;
   document.forms.fhlv2.kvmerj.value = merj;
     }
   if( oddiel == "B1" )
     {
   document.forms.fhlv3.kvodd.value = oddiel;
   document.forms.fhlv3.kvicd.value = icd;
   document.forms.fhlv3.kvdaz.value = datum;
   document.forms.fhlv3.kvfak.value = fak;
   document.forms.fhlv3.kvzdn.value = zkl;
   document.forms.fhlv3.kvsdn.value = suma;
   document.forms.fhlv3.kvszd.value = szd;
   document.forms.fhlv3.kvodn.value = odn;
     }
   if( oddiel == "B2" )
     {
   document.forms.fhlv4.kvodd.value = oddiel;
   document.forms.fhlv4.kvicd.value = icd;
   document.forms.fhlv4.kvdaz.value = datum;
   document.forms.fhlv4.kvfak.value = fak;
   document.forms.fhlv4.kvzdn.value = zkl;
   document.forms.fhlv4.kvsdn.value = suma;
   document.forms.fhlv4.kvszd.value = szd;
   document.forms.fhlv4.kvodn.value = odn;
     }
   if( oddiel == "B3" )
     {
   document.forms.fhlv5.kvodd.value = oddiel;
   document.forms.fhlv5.kvzdn.value = zkl;
   document.forms.fhlv5.kvsdn.value = suma;
   document.forms.fhlv5.kvodn.value = odn;
     }
   if( oddiel == "C1" )
     {
   document.forms.fhlv6.kvodd.value = oddiel;
   document.forms.fhlv6.kvicd.value = icd;
   document.forms.fhlv6.kvpvf.value = pvf;
   document.forms.fhlv6.kvfak.value = fak;
   document.forms.fhlv6.kvzdn.value = zkl;
   document.forms.fhlv6.kvsdn.value = suma;
   document.forms.fhlv6.kvkodt.value = kodt;
   document.forms.fhlv6.kvdtov.value = dtov;
   document.forms.fhlv6.kvmnot.value = mnot;
   document.forms.fhlv6.kvmerj.value = merj;
     }
   if( oddiel == "C2" )
     {
   document.forms.fhlv7.kvodd.value = oddiel;
   document.forms.fhlv7.kvicd.value = icd;
   document.forms.fhlv7.kvfak.value = fak;
   document.forms.fhlv7.kvpvf.value = pvf;
   document.forms.fhlv7.kvzdn.value = zkl;
   document.forms.fhlv7.kvsdn.value = suma;
   document.forms.fhlv7.kvszd.value = szd;
   document.forms.fhlv7.kvodn.value = odn;
     }
   if( oddiel == "D1" )
     {
   document.forms.fhlv8.kvodd.value = oddiel;
   document.forms.fhlv8.kvcobr.value = cobr;
   document.forms.fhlv8.kvzdn20.value = zdn20;
   document.forms.fhlv8.kvsdn20.value = sdn20;
   document.forms.fhlv8.kvzdn10.value = zdn10;
   document.forms.fhlv8.kvsdn10.value = sdn10;
     }
   if( oddiel == "D2" )
     {
   document.forms.fhlv9.kvodd.value = oddiel;
   document.forms.fhlv9.kvzdn20.value = zdn20;
   document.forms.fhlv9.kvsdn20.value = sdn20;
   document.forms.fhlv9.kvzdn10.value = zdn10;
   document.forms.fhlv9.kvsdn10.value = sdn10;
     }

   myKVDPH.style.display='none';
  }

  function vymazatCpl(cpl)
  {
   var cislo_cpl=cpl;
   window.open('kontrolnydph2014_manual.php?copern=16001&cislo_cpl='+ cislo_cpl + '&xx=1', '_self');
  }

  function SavePridavok(cpl)
  {
   var xxpov = document.fhlv0.xpov.value;
   if( xxpov > 0 ) {
   window.open('kontrolnydph2014_manual.php?copern=28001&xxpov=' + xxpov + '&xx=1', '_self');
                   }
  }

function RozdielyKvXml(cpid,ume,druh,stvrtrok,dap,cpop)
                {
var cislo_cpid = cpid;
var cislo_ume = ume;
var cislo_druh = druh;
var stvrtrok = stvrtrok;
var cislo_cpop = cpop;

window.open('../ucto/kontrolnydph2014_manual.php?copern=18099&drupoh=1&page=1&typ=PDF&xmlko=1&cislo_cpop=' + cislo_cpop + '&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok + '&rozdiel=0&poslidomanual=1',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


</script>
<script type="text/javascript" src="spr_kvdph_xml.js"></script>
</HEAD>
<BODY onload="VyberVstup();">

<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">DodatoËn˝ KV DPH - <span class="subheader">id <?php echo $xdod;?></span></td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/floppy_blue_icon.png" onclick="SavePridavok();" title="Uloûiù tieto riadky KVDPH ako prÌdavok ku KVDPH s ID ËÌslom zadan˝m v inpute ID pÙvodnÈho KVDPH:" class="btn-form-tool">

     <img src="../obr/ikony/download_blue_icon.png" onclick="RozdielyKvXml(17,'5.2014',3,0,'',16);" title="NaËÌtaù rozdielovÈ riadky oproti pÙvodnÈmu KVDPH" class="btn-form-tool">
     <img src="../obr/ikony/upbox_blue_icon.png" onclick="vytvorXML();" title="Export do XML" class="btn-form-tool">
     <img src="../obr/ikony/trash_blue_icon.png" onclick="New();" title="Vymazaù vöetky poloûky" class="btn-form-tool">
     <!-- dopyt, dorobiù pouËenie len k dodatoËnÈmu -->
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="myKVDPH" class="ponuka-box" style=" "></div> <!-- dopyt, vyskakovacia ponuka -->


<div id="content">

<table class="uvod">
<FORM name="fhlv0" method="post" action="kontrolnydph2014_manual.php?copern=15000&page=1">
<tr>
 <td width="40%">
<?php
$xobd=$xume;
if ( $xstv == 1 ) { $xobd="I.ötvrùrok"; }
if ( $xstv == 2 ) { $xobd="II.ötvrùrok"; }
if ( $xstv == 3 ) { $xobd="III.ötvrùrok"; }
if ( $xstv == 4 ) { $xobd="IV.ötvrùrok"; }
?>
  Obdobie: <input type="text" name="xobd" id="xobd" value="<?php echo $xobd;?>" disabled="disabled" class="obdobie"/>
 </td>
 <td width="45%">
  ID pÙvodnÈho KVDPH: <input type="text" name="xpov" id="xpov" maxlength="10" style="width:40px;"/>
 </td>
 <td width="15%">
  <input type="submit" id="uloz0" name="uloz0" value="Uloûiù" onmouseover="return Povol_uloz0();"><SPAN id="uvolni0" onmouseover="return Povol_uloz0();">&nbsp;</SPAN>

 </td>
</tr>
</table>
  <input type="hidden" name="xume" id="xume" value="<?php echo $cislo_ume; ?>"/>
  <input type="hidden" name="xstv" id="xstv" value="<?php echo $cislo_stvrt; ?>"/>
  <input type="hidden" name="xdod" id="xdod" value="<?php echo $xdod;?>"/><input type="hidden" name="xddo" id="xddo"/>
</FORM> <!-- dopyt, robÌ problÈmy v ie10 -->


<?php
//////ODDIEL A1
$sqltt = "SELECT * FROM F$kli_vxcf"."_archivdphkvdphmanual WHERE kvodd = 'A1' ORDER BY kvodd ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$strana=1;
$i=0;
  while ($i <= $pol )
  {
if ( $i == 0 )
     {
?>
<table class="oddiel">
<caption>
 <strong>A.1.</strong>⁄daje z vyhotovenej fa., kt. platiteæ dane vyhotovil podæa ß 71 aû 75 z·k., pri kt. je osobou povinnou platiù daÚ (okrem zjednoduöenej fa. a fa. o dodanÌ plnenÌ oslobod. od dane)
</caption>
<FORM name="fhlv1" method="post" action="kontrolnydph2014_manual.php?copern=15001&page=1">
<tr>
 <th width="5%">Oddiel</th>
 <th width="15%">I»DPH odberateæa</th>
 <th width="15%">»Ìslo fakt˙ry</th>
 <th width="10%">D·t. dodania</th>
 <th width="15%">Z·klad dane</th>
 <th width="15%">Suma dane</th>
 <th width="10%">Sadzba dane</th>
 <th width="10%">KÛd opravy</th>
 <th width="5%"></th>
</tr>
<?php
     }
//koniec i=0
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);
?>
<tr>
 <td><?php echo $polozka->kvodd;?></td>
 <td><?php echo $polozka->kvicd;?></td>
 <td><?php echo $polozka->kvfak;?></td>
 <td><?php echo SkDatum($polozka->daz);?></td>
 <td style="text-align:right;"><?php echo $polozka->kvzdn;?>&nbsp;</td>
 <td style="text-align:right;"><?php echo $polozka->kvsdn;?>&nbsp;</td>
 <td><?php echo $polozka->kvszd;?></td>
 <td><?php echo $polozka->er1;?></td>
 <td>
  <img src="../obr/ikony/xmark_lred_icon.png" onclick="vymazatCpl(<?php echo $polozka->cpl;?>);" title="Vymazaù riadok">
 </td>
</tr>
<?php
}
$i = $i + 1;
  }
?>
<tr>
 <td>
  <input type="hidden" name="kvodd" id="kvodd" value="A1"/>
  <img src='../obr/hladaj.png' onclick="myKVDPH.style.display=''; volajKvdph('A1');" title="Hæadaù v KVDPH">
 </td>
 <td><input type="text" name="kvicd" id="kvicd" onkeydown="kvicda1Enter(event.which);" maxlength="20" style="width:100px;"/></td>
 <td><input type="text" name="kvfak" id="kvfak" onkeydown="kvfaka1Enter(event.which);" maxlength="35" style="width:120px;"/></td> <!-- dopyt, preveriù öÌrku inputu -->
 <td><input type="text" name="kvdaz" id="kvdaz" onkeydown="kvdaza1Enter(event.which);" maxlength="12" style="width:80px;"/></td>
 <td><input type="text" name="kvzdn" id="kvzdn" onkeydown="kvzdna1Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td><input type="text" name="kvsdn" id="kvsdn" onkeydown="kvsdna1Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td><input type="text" name="kvszd" id="kvszd" onkeydown="kvszda1Enter(event.which);" maxlength="2" style="width:80px;"/></td>
 <td>
  <select size="1" name="kver1" id="kver1" onkeydown="kver1a1Enter(event.which);">
   <option value="1">1=zmazan· poloûka</option>
   <option value="2">2=nov· poloûka</option>
  </select>
 </td>
 <td></td>
</tr>
</table>
 <input type="submit" id="uloz1" name="uloz1" value="Uloûiù" onmouseover="return Povol_uloz1();">
 <SPAN id="uvolni1" onmouseover="return Povol_uloz1();">&nbsp;</SPAN>
</FORM>


<?php
//////ODDIEL A2
$sqltt = "SELECT * FROM F$kli_vxcf"."_archivdphkvdphmanual WHERE kvodd = 'A2' ORDER BY kvodd ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$strana=1;
$i=0;
  while ($i <= $pol )
  {
if ( $i == 0 )
     {
?>
<table class="oddiel">
<caption>
 <strong>A.2.</strong>⁄daje z vyhotovenej fa., kt. platiteæ dane vyhotovil podæa ß 71 aû 75 z·kona, pri ktor˝ch je osobou povinnou platiù daÚ prÌjemca plnenia podæa ß 69 ods. 12 pÌsm. f) aû i) z·kona
</caption>
<tr>
<FORM name="fhlv2" method="post" action="kontrolnydph2014_manual.php?copern=15002&page=1">
 <th width="5%">Oddiel</th>
 <th width="10%">I»DPH odberateæa</th>
 <th width="14%">»Ìslo fakt˙ry</th>
 <th width="10%">D·t. dodania</th>
 <th width="12%">Z·klad dane</th>
 <th width="8%">KÛd tovaru</th> <!-- dopyt, daù obr·zok s info, Ëo to je -->
 <th width="8%">Druh tovaru</th> <!-- dopyt, daù obr·zok s info, Ëo to je -->
 <th width="13%">Mnoûstvo tovaru</th> <!-- dopyt, daù obr·zok s info, Ëo to je -->
 <th width="5%">MJ</th>
 <th width="10%">KÛd opravy</th>
 <th width="5%"></th>
</tr>
<?php
     }
//koniec i=0
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);
?>
<tr>
 <td><?php echo $polozka->kvodd;?></td>
 <td><?php echo $polozka->kvicd;?></td>
 <td><?php echo $polozka->kvfak;?></td>
 <td><?php echo SkDatum($polozka->daz);?></td>
 <td style="text-align:right;"><?php echo $polozka->kvzkl;?>&nbsp;</td>
 <td><?php echo $polozka->kvkodt;?></td>
 <td><?php echo $polozka->kvdtov;?></td>
 <td style="text-align:right;"><?php echo $polozka->kvmnot;?>&nbsp;</td>
 <td><?php echo $polozka->merj;?></td>
 <td><?php echo $polozka->er1;?></td>
 <td>
  <img src="../obr/ikony/xmark_lred_icon.png" onclick="vymazatCpl(<?php echo $polozka->cpl;?>);" title="Vymazaù riadok">
 </td>
</tr>
<?php
}
$i = $i + 1;
  }
?>
<tr>
 <td>
  <input type="hidden" name="kvodd" id="kvodd" value="A2"/>
  <img src='../obr/hladaj.png' onclick="myKVDPH.style.display=''; volajKvdph('A2');" title="Hæadaù v KVDPH">
 </td>
 <td><input type="text" name="kvicd" id="kvicd" onkeydown="kvicda2Enter(event.which);" maxlength="20" style="width:100px;"/></td>
 <td><input type="text" name="kvfak" id="kvfak" onkeydown="kvfaka2Enter(event.which);" maxlength="35" style="width:120px;"/></td> <!-- dopyt, preveriù öÌrku inputu -->
 <td><input type="text" name="kvdaz" id="kvdaz" onkeydown="kvdaza2Enter(event.which);" maxlength="12" style="width:80px;"/></td>
 <td><input type="text" name="kvzkl" id="kvzkl" onkeydown="kvzkla2Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td><input type="text" name="kvkodt" id="kvkodt" onkeydown="kvkodta2Enter(event.which);" maxlength="12" style="width:60px;"/></td> <!-- dopyt, moûno select -->
 <td><input type="text" name="kvdtov" id="kvdtov" onkeydown="kvdtova2Enter(event.which);" maxlength="12" style="width:60px;"/></td> <!-- dopyt, moûno select -->
 <td><input type="text" name="kvmnot" id="kvmnot" onkeydown="kvmnota2Enter(event.which);" maxlength="12" style="width:60px;"/></td>
 <td><input type="text" name="kvmerj" id="kvmerj" onkeydown="kvmerja2Enter(event.which);" maxlength="2" style="width:40px;"/></td> <!-- dopyt, moûno select -->
 <td>
  <select size="1" name="kver1" id="kver1" onkeydown="kver1a2Enter(event.which);">
   <option value="1">1=zmazan· poloûka</option>
   <option value="2">2=nov· poloûka</option>
  </select>
 </td>
 <td></td>
</tr>
</table>
 <input type="submit" id="uloz2" name="uloz2" value="Uloûiù" onmouseover="return Povol_uloz2();">
 <SPAN id="uvolni2" onmouseover="return Povol_uloz2();">&nbsp;</SPAN>
</FORM>

<?php
//////ODDIEL B1
$sqltt = "SELECT * FROM F$kli_vxcf"."_archivdphkvdphmanual WHERE kvodd = 'B1' ORDER BY kvodd ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$strana=1;
$i=0;
  while ($i <= $pol )
  {
if ( $i == 0 )
     {
?>
<table class="oddiel">
<caption>
 <strong>B.1.</strong>⁄daje z prijatej fakt˙ry, pri kt. je platiteæom dane prÌjemca plnenia podæa ß 69 ods. 2, 3, 6, 7 a 9 aû 12 z·kona (okrem fakt˙ry o dodanÌ plnenÌ osloboden˝ch od dane)
</caption>
<tr>
<FORM name="fhlv3" method="post" action="kontrolnydph2014_manual.php?copern=15003&page=1">
 <th width="5%">Oddiel</th>
 <th width="12%">I»DPH dod·vateæa</th>
 <th width="13%">»Ìslo fakt˙ry</th>
 <th width="10%">D·t. dodania</th>
 <th width="10%">Z·klad dane</th>
 <th width="10%">Suma dane</th>
 <th width="10%">Sadzba dane</th>
 <th width="10%">OdpoËÌtan· daÚ</th>
 <th width="10%">KÛd opravy</th>
 <th width="5%"></th>
</tr>
<?php
     }
//koniec i=0
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);
?>
<tr>
 <td><?php echo $polozka->kvodd;?></td>
 <td><?php echo $polozka->kvicd;?></td>
 <td><?php echo $polozka->kvfak;?></td>
 <td><?php echo SkDatum($polozka->daz);?></td>
 <td style="text-align:right;"><?php echo $polozka->kvzdn;?>&nbsp;</td>
 <td style="text-align:right;"><?php echo $polozka->kvsdn;?>&nbsp;</td>
 <td><?php echo $polozka->kvszd;?></td>
 <td style="text-align:right;"><?php echo $polozka->kvodn;?>&nbsp;</td>
 <td><?php echo $polozka->er1;?></td>
 <td>
  <img src="../obr/ikony/xmark_lred_icon.png" onclick="vymazatCpl(<?php echo $polozka->cpl;?>);" title="Vymazaù riadok">
 </td>
</tr>
<?php
}
$i = $i + 1;
  }
?>
<tr>
 <td>
  <input type="hidden" name="kvodd" id="kvodd" value="B1"/>
  <img src='../obr/hladaj.png' onclick="myKVDPH.style.display=''; volajKvdph('B1');" title="Hæadaù v KVDPH">
 </td>
 <td><input type="text" name="kvicd" id="kvicd" onkeydown="kvicdb1Enter(event.which);" maxlength="20" style="width:100px;"/></td>
 <td><input type="text" name="kvfak" id="kvfak" onkeydown="kvfakb1Enter(event.which);" maxlength="35" style="width:120px;"/></td> <!-- dopyt, preveriù öÌrku inputu -->
 <td><input type="text" name="kvdaz" id="kvdaz" onkeydown="kvdazb1Enter(event.which);" maxlength="12" style="width:80px;"/></td>
 <td><input type="text" name="kvzdn" id="kvzdn" onkeydown="kvzdnb1Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td><input type="text" name="kvsdn" id="kvsdn" onkeydown="kvsdnb1Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td><input type="text" name="kvszd" id="kvszd" onkeydown="kvszdb1Enter(event.which);" maxlength="2" style="width:80px;"/></td>
 <td><input type="text" name="kvodn" id="kvodn" onkeydown="kvodnb1Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td>
  <select size="1" name="kver1" id="kver1" onkeydown="kver1b1Enter(event.which);">
   <option value="1">1=zmazan· poloûka</option>
   <option value="2">2=nov· poloûka</option>
  </select>
 </td>
 <td></td>
</tr>
</table>
 <input type="submit" id="uloz3" name="uloz3" value="Uloûiù" onmouseover="return Povol_uloz3();">
 <SPAN id="uvolni3" onmouseover="return Povol_uloz3();">&nbsp;</SPAN>
</FORM>


<?php
//////ODDIEL B2
$sqltt = "SELECT * FROM F$kli_vxcf"."_archivdphkvdphmanual WHERE kvodd = 'B2' ORDER BY kvodd ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$strana=1;
$i=0;
  while ($i <= $pol )
  {
if ( $i == 0 )
     {
?>
<table class="oddiel">
<caption>
 <strong>B.2.</strong>⁄daje z prijatej fakt˙ry, z ktorej prÌjemca plnenia uplatÚuje odpoËÌtanie dane a ktor˙ vyhotovil platiteæ dane, ktor˝ je osobou povinnou platiù daÚ podæa ß 69 ods. 1 z·kona
</caption>
<tr>
<FORM name="fhlv4" method="post" action="kontrolnydph2014_manual.php?copern=15004&page=1">
 <th width="5%">Oddiel</th>
 <th width="12%">I»DPH dod·vateæa</th>
 <th width="13%">»Ìslo fakt˙ry</th>
 <th width="10%">D·t. dodania</th>
 <th width="12%">Z·klad dane</th>
 <th width="12%">Suma dane</th>
 <th width="10%">Sadzba dane</th>
 <th width="10%">OdpoËÌtan· daÚ</th>
 <th width="11%">KÛd opravy</th>
 <th width="5%"></th>
</tr>
<?php
     }
//koniec i=0
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);
?>
<tr>
 <td><?php echo $polozka->kvodd;?></td>
 <td><?php echo $polozka->kvicd;?></td>
 <td><?php echo $polozka->kvfak;?></td>
 <td><?php echo SkDatum($polozka->daz);?></td>
 <td style="text-align:right;"><?php echo $polozka->kvzdn;?>&nbsp;</td>
 <td style="text-align:right;"><?php echo $polozka->kvsdn;?>&nbsp;</td>
 <td><?php echo $polozka->kvszd;?></td>
 <td style="text-align:right;"><?php echo $polozka->kvodn;?>&nbsp;</td>
 <td><?php echo $polozka->er1;?></td>
 <td>
  <img src="../obr/ikony/xmark_lred_icon.png" onclick="vymazatCpl(<?php echo $polozka->cpl;?>);" title="Vymazaù riadok">
 </td>
</tr>
<?php
}
$i = $i + 1;
  }
?>
<tr>
 <td>
 <input type="hidden" name="kvodd" id="kvodd" value="B2"/>
 <img src='../obr/hladaj.png' onclick="myKVDPH.style.display=''; volajKvdph('B2');" title="Hæadaù v KVDPH">
 </td>
 <td><input type="text" name="kvicd" id="kvicd" onkeydown="kvicdb2Enter(event.which);" maxlength="20" style="width:100px;"/></td>
 <td><input type="text" name="kvfak" id="kvfak" onkeydown="kvfakb2Enter(event.which);" maxlength="35" style="width:120px;"/></td> <!-- dopyt, preveriù öÌrku inputu -->
 <td><input type="text" name="kvdaz" id="kvdaz" onkeydown="kvdazb2Enter(event.which);" maxlength="12" style="width:80px;"/></td>
 <td><input type="text" name="kvzdn" id="kvzdn" onkeydown="kvzdnb2Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td><input type="text" name="kvsdn" id="kvsdn" onkeydown="kvsdnb2Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td><input type="text" name="kvszd" id="kvszd" onkeydown="kvszdb2Enter(event.which);" maxlength="2" style="width:80px;"/></td>
 <td><input type="text" name="kvodn" id="kvodn" onkeydown="kvodnb2Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td>
  <select size="1" name="kver1" id="kver1" onkeydown="kver1b2Enter(event.which);">
   <option value="1">1=zmazan· poloûka</option>
   <option value="2">2=nov· poloûka</option>
  </select>
 </td>
 <td></td>
</tr>
</table>
 <input type="submit" id="uloz4" name="uloz4" value="Uloûiù" onmouseover="return Povol_uloz4();">
 <SPAN id="uvolni4" onmouseover="return Povol_uloz4();">&nbsp;</SPAN>
</FORM>


<?php
//////ODDIEL B3
$sqltt = "SELECT * FROM F$kli_vxcf"."_archivdphkvdphmanual WHERE kvodd = 'B3' ORDER BY kvodd ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$strana=1;
$i=0;
  while ($i <= $pol )
  {
if ( $i == 0 )
     {
?>
<table class="oddiel">
<caption>
 <strong>B.3.</strong>⁄daje zo vöetk˝ch prijat˝ch zjednoduöen˝ch fakt˙r podæa ß 74 ods. 3 pÌsm. a) aû c) z·kona, z ktor˝ch prÌjemca plnenia uplatÚuje odpoËÌtanie dane
</caption>
<tr>
<FORM name="fhlv5" method="post" action="kontrolnydph2014_manual.php?copern=15005&page=1">
 <th width="15%">Oddiel</th>
 <th width="20%">Z·klad dane (ZD)</th>
 <th width="20%">Suma dane (SD)</th>
 <th width="20%">OdpoËÌtan· daÚ</th>
 <th width="20%">KÛd opravy</th>
 <th width="5%"></th>
</tr>
<?php
     }
//koniec i=0
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);
?>
<tr>
 <td><?php echo $polozka->kvodd;?></td>
 <td style="text-align:right;"><?php echo $polozka->kvzdn;?>&nbsp;</td>
 <td style="text-align:right;"><?php echo $polozka->kvsdn;?>&nbsp;</td>
 <td style="text-align:right;"><?php echo $polozka->kvodn;?>&nbsp;</td>
 <td><?php echo $polozka->er1;?></td>
 <td>
  <img src="../obr/ikony/xmark_lred_icon.png" onclick="vymazatCpl(<?php echo $polozka->cpl;?>);" title="Vymazaù riadok">
 </td>
</tr>
<?php
}
$i = $i + 1;
  }
?>
<tr>
 <td>
  <input type="hidden" name="kvodd" id="kvodd" value="B3"/>
  <img src='../obr/hladaj.png' onclick="myKVDPH.style.display=''; volajKvdph('B3');" title="Hæadaù v KVDPH">
 </td>
 <td><input type="text" name="kvzdn" id="kvzdn" onkeydown="kvzdnb3Enter(event.which);" maxlength="12" style="width:80px;"/></td>
 <td><input type="text" name="kvsdn" id="kvsdn" onkeydown="kvsdnb3Enter(event.which);" maxlength="12" style="width:80px;"/></td>
 <td><input type="text" name="kvodn" id="kvodn" onkeydown="kvodnb3Enter(event.which);" maxlength="12" style="width:80px;"/></td>
 <td>
  <select class="hmenu" size="1" name="kver1" id="kver1" onkeydown="kver1b3Enter(event.which);">
   <option value="1">1=zmazan· poloûka</option>
   <option value="2">2=nov· poloûka</option>
  </select>
 </td>
 <td></td>
</tr>
</table>
 <input type="submit" id="uloz5" name="uloz5" value="Uloûiù" onmouseover="return Povol_uloz5();" >
 <SPAN id="uvolni5" onmouseover="return Povol_uloz5();">&nbsp;</SPAN>
</FORM>


<?php
//////ODDIEL C1
$sqltt = "SELECT * FROM F$kli_vxcf"."_archivdphkvdphmanual WHERE kvodd = 'C1' ORDER BY kvodd ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$strana=1;
$i=0;
  while ($i <= $pol )
  {
if ( $i == 0 )
      {
?>
<table class="oddiel">
<caption>
 <strong>C.1.</strong>⁄daje z vyhotovenej opravnej fakt˙ry (podæa ß 71 ods. 2 z·kona, ktor· menÌ pÙvodn˙ fakt˙ru - Ôalej len "opravn· fakt˙ra")
</caption>
<tr>
<FORM name="fhlv6" method="post" action="kontrolnydph2014_manual.php?copern=15006&page=1">
 <th width="5%">Oddiel</th>
 <th width="10%">I»DPH odberat.</th>
 <th width="10%">»Ìslo oprav.fa.</th>
 <th width="10%">»Ìslo pÙvod.fa.</th>
 <th width="10%">Rozdiel ZD</th>
 <th width="10%">Rozdiel SD</th>
 <th width="5%">Sadz.dane</th>
 <th width="5%">KÛd T</th>
 <th width="5%">Druh T</th>
 <th width="10%">Rozd. mnoû.T</th>
 <th width="5%">MJ</th>
 <th width="10%">KÛd opravy</th>
 <th width="5%"></th>
</tr>
<?php
      }
//koniec i=0
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);
?>
<tr>
 <td><?php echo $polozka->kvodd;?></td>
 <td><?php echo $polozka->kvicd;?></td>
 <td><?php echo $polozka->kvfak;?></td>
 <td><?php echo $polozka->kvpvf;?></td>
 <td style="text-align:right;"><?php echo $polozka->kvzkl;?>&nbsp;</td>
 <td style="text-align:right;"><?php echo $polozka->kvsdn;?>&nbsp;</td>
 <td><?php echo $polozka->kvszd;?></td>
 <td><?php echo $polozka->kvkodt;?></td>
 <td><?php echo $polozka->kvdtov;?></td>
 <td style="text-align:right;"><?php echo $polozka->kvmnot;?>&nbsp;</td>
 <td><?php echo $polozka->merj;?></td>
 <td><?php echo $polozka->er1;?></td>
 <td>
  <img src="../obr/ikony/xmark_lred_icon.png" onclick="vymazatCpl(<?php echo $polozka->cpl;?>);" title="Vymazaù riadok">
 </td>
</tr>
<?php
}
$i = $i + 1;
  }
?>
<tr>
 <td>
  <input type="hidden" name="kvodd" id="kvodd" value="C1"/>
  <img src='../obr/hladaj.png' onclick="myKVDPH.style.display=''; volajKvdph('C1');" title="Hæadaù v KVDPH">
 </td>
 <td><input type="text" name="kvicd" id="kvicd" onkeydown="kvicdc1Enter(event.which);" maxlength="20" style="width:90px;"/></td>
 <td><input type="text" name="kvfak" id="kvfak" onkeydown="kvfakc1Enter(event.which);" maxlength="35" style="width:110px;"/></td> <!-- dopyt, preveriù öÌrku inputu -->
 <td><input type="text" name="kvpvf" id="kvpvf" onkeydown="kvpvfc1Enter(event.which);" maxlength="35" style="width:110px;"/></td>
 <td><input type="text" name="kvzkl" id="kvzkl" onkeydown="kvzklc1Enter(event.which);" maxlength="12" style="width:80px;"/></td>
 <td><input type="text" name="kvzdn" id="kvzdn" onkeydown="kvzdnc1Enter(event.which);" maxlength="12" style="width:80px;"/></td>
 <td><input type="text" name="kvszd" id="kvszd" onkeydown="kvszdc1Enter(event.which);" maxlength="12" style="width:40px;"/></td>
 <td><input type="text" name="kvkodt" id="kvkodt" onkeydown="kvkodtc1Enter(event.which);" maxlength="12" style="width:40px;"/></td>
 <td><input type="text" name="kvdtov" id="kvdtov" onkeydown="kvdtovc1Enter(event.which);" maxlength="12" style="width:40px;"/></td>
 <td><input type="text" name="kvmnot" id="kvmnot" onkeydown="kvmnotc1Enter(event.which);" maxlength="12" style="width:70px;"/></td>
 <td><input type="text" name="kvmerj" id="kvmerj" onkeydown="kvmerjc1Enter(event.which);" maxlength="2" style="width:30px;"/></td>
 <td>
  <select size="1" name="kver1" id="kver1" onkeydown="kver1c1Enter(event.which);">
   <option value="1">1=zmazan· poloûka</option>
   <option value="2">2=nov· poloûka</option>
  </select>
 </td>
 <td></td>
</tr>
</table>
 <input type="submit" id="uloz6" name="uloz6" value="Uloûiù" onmouseover="return Povol_uloz6();">
 <SPAN id="uvolni6" onmouseover="return Povol_uloz6();">&nbsp;</SPAN>
</FORM>


<?php
//////ODDIEL C2
$sqltt = "SELECT * FROM F$kli_vxcf"."_archivdphkvdphmanual WHERE kvodd = 'C2' ORDER BY kvodd ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$strana=1;
$i=0;
  while ($i <= $pol )
  {
if ( $i == 0 )
     {
?>
<table class="oddiel">
<caption>
 <strong>C.2.</strong>⁄daje z prijatej opravnej fakt˙ry
</caption>
<tr>
<FORM name="fhlv7" method="post" action="kontrolnydph2014_manual.php?copern=15007&page=1">
 <th width="5%">Oddiel</th>
 <th width="12%">I»DPH dod·vateæa</th>
 <th width="13%">»Ìslo opravnej fa.</th>
 <th width="13%">»Ìslo pÙvodnej fa.</th>
 <th width="11%">Rozdiel ZD</th>
 <th width="10%">Rozdiel SD</th>
 <th width="8%">Sadzba dane</th>
 <th width="13%">Rozdiel odpoË.dane</th>
 <th width="10%">KÛd opravy</th>
 <th width="5%"></th>
</tr>
<?php
     }
//koniec i=0
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);
?>
<tr>
 <td><?php echo $polozka->kvodd;?></td>
 <td><?php echo $polozka->kvicd;?></td>
 <td><?php echo $polozka->kvfak;?></td>
 <td><?php echo $polozka->kvpvf;?></td>
 <td style="text-align:right;"><?php echo $polozka->kvzdn;?>&nbsp;</td>
 <td style="text-align:right;"><?php echo $polozka->kvsdn;?>&nbsp;</td>
 <td><?php echo $polozka->kvszd;?></td>
 <td style="text-align:right;"><?php echo $polozka->kvodn;?>&nbsp;</td>
 <td><?php echo $polozka->er1;?></td>
 <td>
  <img src="../obr/ikony/xmark_lred_icon.png" onclick="vymazatCpl(<?php echo $polozka->cpl;?>);" title="Vymazaù riadok">
 </td>
</tr>
<?php
}
$i = $i + 1;
  }
?>
<tr>
 <td>
  <input type="hidden" name="kvodd" id="kvodd" value="C2"/>
  <img src='../obr/hladaj.png' onclick="myKVDPH.style.display=''; volajKvdph('C2');" title="Hæadaù v KVDPH">
 </td>
 <td><input type="text" name="kvicd" id="kvicd" onkeydown="kvicdc2Enter(event.which);" maxlength="20" style="width:90px;"/></td>
 <td><input type="text" name="kvfak" id="kvfak" onkeydown="kvfakc2Enter(event.which);" maxlength="35" style="width:120px;"/></td> <!-- dopyt, preveriù öÌrku inputu -->
 <td><input type="text" name="kvpvf" id="kvpvf" onkeydown="kvpvfc2Enter(event.which);" maxlength="35" style="width:120px;"/></td>
 <td><input type="text" name="kvzdn" id="kvzdn" onkeydown="kvzdnc2Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td><input type="text" name="kvsdn" id="kvsdn" onkeydown="kvsdnc2Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td><input type="text" name="kvszd" id="kvszd" onkeydown="kvszdc2Enter(event.which);" maxlength="2" style="width:50px;"/></td>
 <td><input type="text" name="kvodn" id="kvodn" onkeydown="kvodnc2Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td>
  <select size="1" name="kver1" id="kver1" onkeydown="kver1c2Enter(event.which);">
   <option value="1">1=zmazan· poloûka</option>
   <option value="2">2=nov· poloûka</option>
  </select>
 </td>
 <td></td>
</tr>
</table>
 <input type="submit" id="uloz7" name="uloz7" value="Uloûiù" onmouseover="return Povol_uloz7();">
 <SPAN id="uvolni7" onmouseover="return Povol_uloz7();">&nbsp;</SPAN>
</FORM>


<?php
//////ODDIEL D1
$sqltt = "SELECT * FROM F$kli_vxcf"."_archivdphkvdphmanual WHERE kvodd = 'D1' ORDER BY kvodd ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$strana=1;
$i=0;
  while ($i <= $pol )
  {
if ( $i == 0 )
     {
?>
<table class="oddiel">
<caption>
 <strong>D.1.</strong>⁄daje o dodanÌ tovarov a sluûieb in˝ch ako uveden˝ch v Ëasti A., z kt. je platiteæ dane povinn˝ platÌ daÚ - ⁄daje o obratoch evidovan˝ch vöetk˝mi ERP
</caption>
<tr>
<FORM name="fhlv8" method="post" action="kontrolnydph2014_manual.php?copern=15008&page=1">
 <th width="5%">Oddiel</th>
 <th width="15%">Celkov· suma obratov</th>
 <th width="15%">Celkov· suma ZD 20% DPH</th>
 <th width="15%">Celkov· SD 20% DPH</th>
 <th width="15%">Celkov· suma ZD 10% DPH</th>
 <th width="15%">Celkov· SD 10% DPH</th>
 <th width="15%">KÛd opravy</th>
 <th width="5%"></th>
</tr>
<?php
     }
//koniec i=0
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);
?>
<tr>
 <td><?php echo $polozka->kvodd;?></td>
 <td style="text-align:right;"><?php echo $polozka->kvcobr;?>&nbsp;</td>
 <td style="text-align:right;"><?php echo $polozka->kvzdn20;?>&nbsp;</td>
 <td style="text-align:right;"><?php echo $polozka->kvsdn20;?>&nbsp;</td>
 <td style="text-align:right;"><?php echo $polozka->kvzdn10;?>&nbsp;</td>
 <td style="text-align:right;"><?php echo $polozka->kvsdn10;?>&nbsp;</td>
 <td><?php echo $polozka->er1;?></td>
 <td>
  <img src="../obr/ikony/xmark_lred_icon.png" onclick="vymazatCpl(<?php echo $polozka->cpl;?>);" title="Vymazaù riadok">
 </td>
</tr>
<?php
}
$i = $i + 1;
  }
?>
<tr>
 <td>
  <input type="hidden" name="kvodd" id="kvodd" value="D1"/>
  <img src='../obr/hladaj.png' onclick="myKVDPH.style.display=''; volajKvdph('D1');" title="Hæadaù v KVDPH">
 </td>
 <td><input type="text" name="kvcobr" id="kvcobr" onkeydown="kvcobrd1Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td><input type="text" name="kvzdn20" id="kvzdn20" onkeydown="kvzdn20d1Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td><input type="text" name="kvsdn20" id="kvsdn20" onkeydown="kvsdn20d1Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td><input type="text" name="kvzdn10" id="kvzdn10" onkeydown="kvzdn10d1Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td><input type="text" name="kvsdn10" id="kvsdn10" onkeydown="kvsdn10d1Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td>
  <select size="1" name="kver1" id="kver1" onkeydown="kver1d1Enter(event.which);">
   <option value="1">1=zmazan· poloûka</option>
   <option value="2">2=nov· poloûka</option>
  </select>
 </td>
 <td></td>
</tr>
</table>
 <input type="submit" id="uloz8" name="uloz8" value="Uloûiù" onmouseover="return Povol_uloz8();">
 <SPAN id="uvolni8" onmouseover="return Povol_uloz8();">&nbsp;</SPAN>
</FORM>


<?php
//////ODDIEL D2
$sqltt = "SELECT * FROM F$kli_vxcf"."_archivdphkvdphmanual WHERE kvodd = 'D2' ORDER BY kvodd ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$strana=1;
$i=0;
  while ($i <= $pol )
  {
if ( $i == 0 )
      {
?>
<table class="oddiel">
<caption>
 <strong>D.2.</strong>⁄daje o dodanÌ tovarov a sluûieb in˝ch ako uveden˝ch v Ëasti A., ktorÈ sa neeviduj˙ ERP
</caption>
<tr>
<FORM name="fhlv9" method="post" action="kontrolnydph2014_manual.php?copern=15009&page=1">
 <th width="10%">Oddiel</th>
 <th width="16%">Celkov˝ suma ZD 20% DPH</th>
 <th width="16%">Celkov˝ SD 20% DPH</th>
 <th width="16%">Celkov˝ suma ZD 10% DPH</th>
 <th width="16%">Celkov˝ SD 10% DPH</th>
 <th width="16%">KÛd opravy</th>
 <th width="10%"></th>
</tr>
<?php
      }
//koniec i=0
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);
?>
<tr>
 <td><?php echo $polozka->kvodd;?></td>
 <td style="text-align:right;"><?php echo $polozka->kvzdn20;?>&nbsp;</td>
 <td style="text-align:right;"><?php echo $polozka->kvsdn20;?>&nbsp;</td>
 <td style="text-align:right;"><?php echo $polozka->kvzdn10;?>&nbsp;</td>
 <td style="text-align:right;"><?php echo $polozka->kvsdn10;?>&nbsp;</td>
 <td><?php echo $polozka->er1;?></td>
 <td>
  <img src="../obr/ikony/xmark_lred_icon.png" onclick="vymazatCpl(<?php echo $polozka->cpl;?>);" title="Vymazaù riadok">
 </td>
</tr>
<?php
}
$i = $i + 1;
  }
?>
<tr>
 <td>
  <input type="hidden" name="kvodd" id="kvodd" value="D2"/>
  <img src='../obr/hladaj.png' onclick="myKVDPH.style.display=''; volajKvdph('D2');" title="Hæadaù v KVDPH">
  <input type="hidden" name="kvcobr" id="kvcobr"/>
 </td>
 <td><input type="text" name="kvzdn20" id="kvzdn20" onkeydown="kvzdn20d2Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td><input type="text" name="kvsdn20" id="kvsdn20" onkeydown="kvsdn20d2Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td><input type="text" name="kvzdn10" id="kvzdn10" onkeydown="kvzdn10d2Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td><input type="text" name="kvsdn10" id="kvsdn10" onkeydown="kvsdn10d2Enter(event.which);" maxlength="12" style="width:90px;"/></td>
 <td>
  <select size="1" name="kver1" id="kver1" onkeydown="kver1d2Enter(event.which);">
   <option value="1">1=zmazan· poloûka</option>
   <option value="2">2=nov· poloûka</option>
  </select>
 </td>
 <td></td>
</tr>
</table>
 <input type="submit" id="uloz9" name="uloz9" value="Uloûiù" onmouseover="return Povol_uloz9();">
 <SPAN id="uvolni9" onmouseover="return Povol_uloz9();">&nbsp;</SPAN>
</FORM>
</div>

<?php
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>