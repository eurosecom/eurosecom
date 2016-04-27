<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {

$zmtz=1;

$sys = 'SKL';
$urov = 2000;
$clsm = 960;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

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
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Dod·vateæsk· objedn·vka</title>
<style type="text/css">
img { border:none; }
h3 {
  margin: 0;
  padding: 4px 10px;
  background-color: lightblue;
  width: 230px;
  letter-spacing: 1px;
  float: left;
  font-size:16px;
}
a.btn-prepni {
  font-size:14px;
  text-decoration:none;
  color:white;
  padding:3px 15px;  
  background-color: #ABD159;  
  border:1px solid #86A83D;
  font-family:Helvetica, Geneva, Verdana, sans-serif;
  position:relative;
}
a.btn-prephead {
  text-decoration:none;
  font-size:13px;  
  font-family: Arial;
  border: 2px solid #3389a6;
  background-color: #86c5da;
  width: 80px;
  padding: 5px 2px 5px 2px;
  display:block;
  color: #3389a6;
  border-radius: 6px;
}
input.fill { padding-left: 1px; }
div.nofill {
  background-color: white;
  font-weight: normal;
  padding: 1px 0 1px 2px;
}
input.fillrg {
  width:90%;
  text-align:right;
  padding-right:2px;           
}


.headpol {
  border-bottom:2px solid #FFFF90;
  padding-bottom: 2px;
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

<?php if( $zmazalsom == 1 ){ ?>

    document.formv1.xcis.value = '<?php echo "$xcisz";?>';
    document.formv1.xnat.value = '<?php echo "$xnatz";?>';
    document.formv1.xced.value = '<?php echo "$xcedz";?>';
    document.formv1.xmno.value = '<?php echo "$xmnoz";?>';

<?php                        } ?>

<?php if( $opakujinput == 0 ){ ?>

    document.formv1.uloz.disabled = true;
    document.formv1.xnat.focus();
    document.formv1.xnat.select();

<?php                        } ?>
    
    }
<?php
//koniec uprava
  }
?>
</script>

</HEAD>

<BODY class="white" onload="ObnovUI();" >
<span style="position:absolute; top:130px; left:52%; z-index:3000;"> 
<span id="myIcoElement"></span>
</span>
<span style="position:absolute; top: 185; left:50%; z-index:3000;"> 
<div id="myOdbmElement"></div>
</span> <!-- upraviù -->
<div id="robotmenu" style="display: none; position:absolute; z-index:1; top:100px; right:15%;">zobrazene menu</div>

<table class="h2" width="100%">
<tr>
<td align="left">EuroSecom - Dod·vateæsk· objedn·vka</td>
<td align="right">
<a href="#" onclick="SpatZoznam();" class="btn-prepni" >
<img src="../obr/back_white.png" alt="Sp‰ù na zoznam objedn·vok" title="Sp‰ù na zoznam objedn·vok" height="16" width="16" style="vertical-align:middle;">
Zoznam</a>
</td>
</tr>
</table>

<?php

if( $docasnemazanie == 0 ) 
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

<div style="width:100%; margin-top:5px; ">
<h3>Objedn·vka Ë. <span style="background-color:#FFFF90; padding:0 7px;"><?php echo $cislo_dok; ?></span></h3>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php if ( $vseobj == 0 ) { ?>
<a href="#" onclick="TlacOBJ(<?php echo $cislo_dok; ?>);"><img src='../obr/tlac.png' width=20 height=15 title='Zobraziù objedn·vku v PDF'></a> <!-- dopyt, musÌ tu byù <a>? -->
<?php                     } ?>
&nbsp;
<a href="#" onclick="TlacOBJnoprice(<?php echo $cislo_dok; ?>);;"><img src='../obr/tlac.png' width=20 height=15 title='Zobraziù objedn·vku bez n·kupn˝ch cien v PDF'></a>
&nbsp;
<a href="#" onclick=";"><img src="../obr/vlozit.png" width=20 height=15 title='NaËÌtaù poloûky zo zostavy o vyhodnotenÌ minim·lnych z·sob za <?php echo $nai; ?> '></a> <!-- dopyt, dorobiù premenn˙ pre iËo a n·zov -->
</div>

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

<table class="fmenu" width="100%" style="border:none; border-collapse:collapse;">
<tr>
<td width="12%"></td><td width="30%"></td><td width="13%"></td><td width="15%"></td><td width="30%"></td>
</tr>
<?php
//hlavicka vyplnatelna
if ( $copern == 1 )
     {
?>

<FORM name="formv1" method="post" action="dodobj_u.php?copern=11&cislo_dok=<?php echo $cislo_dok; ?>" >
<tr>
<td class="bmenu" align="right">D·tum vystavenia</td>
<td class="bmenu"><input type="text" name="xdatv" id="xdatv" class="fill" size="10" maxlength="10" onKeyDown="return xDatvEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" /></td>
<td rowspan="5">&nbsp;</td>
<td class="bmenu" align="right">
<img src='../obr/ziarovka.png' onclick="newIco();" width="12" height="12" title="Vloûiù novÈ I»O do datab·zy" >
Dod·vateæ - <span style="font-weight:normal;">I»O</span></td>
<td class="bmenu">
<input type="text" name="xice" id="xice" class="fill" size="10" maxlength="8" onKeyDown="return xIceEnter(event.which)" />
<img src='../obr/hladaj.png' onclick="volajIco();" title="Hæadaù I»O alebo n·zov firmy" > 
</td>
</tr>
<tr>
<td class="bmenu" align="right">D·tum dodania</td>
<td class="bmenu"><input type="text" name="xdatd" id="xdatd" class="fill" size="10" maxlength="10" onKeyDown="return xDatdEnter(event.which);" onkeyup="CiarkaNaBodku(this);" /></td>
<td class="bmenu" align="right"><span style="font-weight:normal;" >Firma</span></td>
<td class="bmenu"><input type="text" name="xfir" id="xfir" class="fill" size="30" onKeyDown="return xFirEnter(event.which)" /></td>
</tr>
<tr>
<td class="bmenu" align="right">SpÙsob platby</td>
<td class="bmenu"><input type="text" name="xplat" id="xplat" class="fill" size="20" onKeyDown="return xPlatEnter(event.which)" /></td>
<td class="bmenu" align="right">Doprava</td>
<td class="bmenu"><input type="text" name="xdop" id="xdop" class="fill" size="10" onKeyDown="return xDopEnter(event.which)" /></td>
</tr>
<tr>
<td class="bmenu" align="right" >
<img src='../obr/orig.png' width=20 height=15 onclick="textObj('<?php echo $cislo_dok;?>')" title="Pozn·mka k objedn·vke" >&nbsp;Pozn·mka</td>
<td class="fmenu" rowspan="2" style="position:relative; left:4px; ">
<?php
//poznamka
$poznx="";
$sqlfir = "SELECT * FROM F$kli_vxcf"."_dodavobjtext WHERE invt = $cislo_dok ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $poznx = $fir_riadok->itxt; }
$poznx=substr($poznx,0,80);
echo $poznx." ...";
?>
</td>
<td class="bmenu" colspan="2"></td>
</tr>
<tr>
<td class="bmenu"></td>
<td class="bmenu" align="right">Stav&nbsp;</td>
<td class="bmenu"><input type="text" name="xstav" id="xstav" class="fill" size="10" onKeyDown="return xStavEnter(event.which)" /></td>
</tr>
<tr>
<td colspan="5" style="height:3px; background-color:lightblue;"></td>
</tr>
<tr>
<td class="fmenu" colspan="5" align="right">
<SPAN id="uvolni" onmouseover="document.formv1.uloz.disabled = false;">&nbsp;</SPAN>
<INPUT type="submit" id="uloz" name="uloz" value="Uloûiù hlaviËku"></td>
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
<tr><td colspan="5" style="height:2px; background-color:lightblue;"></td></tr>
<tr>
<td class="bmenu" align="right">D·tum vystavenia&nbsp;</td>
<td><div class="nofill" style="width:100px;" ><?php echo $xdatvsk; ?></div></td>
<td rowspan="5" align="center">
<a href="dodobj_u.php?copern=1&drupoh=1&page=1&cislo_dok=<?php echo $cislo_dok; ?>&ffd=0&tlacobj=1&zmtz=1" class="btn-prephead" ><span style="font-weight:normal;">upraviù</span> hlaviËku</a>
</td>
<td class="bmenu" align="right">Dod·vateæ - <span style="font-weight:normal;">I»O</span>&nbsp;</td>
<td class="bmenu" rowspan="2"><div class="nofill" style="width:250px; height:32px;"><?php echo $ico; ?><br><?php echo $nai; ?> <?php echo $na2; ?></div></td>
</tr>
<tr>
<td class="bmenu" align="right">D·tum dodania&nbsp;</td>
<td class="bmenu"><div class="nofill" style="width:100px;" ><?php echo $xdatdsk; ?></div></td>
<td class="bmenu" align="right"><span style="font-weight:normal;">Firma</span>&nbsp;</td>
</tr>
<tr>
<td class="bmenu" align="right">SpÙsob platby&nbsp;</td>
<td class="bmenu"><div class="nofill" style="width:200px;"><?php echo $xplat; ?>&nbsp;</div></td>
<td class="bmenu" align="right">Doprava&nbsp;</td>
<td class="bmenu"><div class="nofill" style="width:200px;"><?php echo $xdop; ?>&nbsp;</div></td>
</tr>
<tr>
<td class="bmenu" align="right">Pozn·mka&nbsp;</td>
<td class="bmenu" rowspan="2"><div class="nofill" style="width:250px; height:32px;" >
<?php
//poznamka
$poznx="";
$sqlfir = "SELECT * FROM F$kli_vxcf"."_dodavobjtext WHERE invt = $cislo_dok ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $poznx = $fir_riadok->itxt; }
$poznx=substr($poznx,0,80);
echo $poznx." ...";
?>
</div></td>
<td class="bmenu" colspan="2"></td>
</tr>
<tr>
<td class="bmenu"></td>
<td class="bmenu" align="right">Stav&nbsp;</td>
<td class="bmenu"><div class="nofill" style="width:100px;" ><?php echo $xstav; ?>&nbsp;</div></td>
</tr>
<tr><td colspan="5" style="height:2px;" ></td></tr>
<tr>
<td class="fmenu" colspan="5" align="right"></td>
</tr>
<?php
//koniec hlavicka vypis copern=2   
     }
?>
</table>

<h4 style="margin:-20px 0 0 1%; width:99%; padding:10px 0 3px 0; font-size:18px;" >Objedn·vame si u V·s:</h4>

<table class="fmenu" width="100%" style="border:none;" >
<tr>
<td width="8%"></td><td width="51%"></td><td width="15%"></td><td width="10%"></td><td width="12%"></td><td width="4%"></td>
</tr>
<tr>
<th class="bmenu headpol">ËÌslo poloûky</th>
<td class="bmenu headpol">&nbsp;Poloûka</td>
<th class="bmenu headpol">Jednotkov· cena</th>
<th class="bmenu headpol">Mnoûstvo</th>
<th class="bmenu headpol" colspan="2">Hodnota</th>
</tr>
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
<FORM name="formv1" method="post" action="dodobj_u.php?copern=22&cislo_dok=<?php echo $cislo_dok; ?>" >
<tr>
<td align="center"><input type="text" name="xcis" id="xcis" style="width:60%; text-align:center;" onKeyDown="return xCisEnter(event.which)" /></td>
<td>
 <img src='../obr/hladaj.png' width='14' height='14' onclick="hladPLU();" title='Hladaù poloûku' > 
 <input type="text" name="xnat" id="xnat" style="width:90%; padding-left:1px;" onKeyDown="return xNatEnter(event.which)" /></td>
<td align="center" class="bmenu"><input type="text" name="xced" id="xced" class="fillrg" onKeyDown="return xCedEnter(event.which)" /></td>
<td align="center" class="bmenu"><input type="text" name="xmno" id="xmno" class="fillrg" onKeyDown="return xMnoEnter(event.which)" /></td>
<td align="center" class="bmenu" colspan="2"><input type="text" name="xhdd" id="xhdd" class="fillrg" style="width:90%;" onKeyDown="return xHddEnter(event.which)"/></td>
</tr>
<tr>
<td class="bmenu" colspan="2">
<INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku">
<SPAN id="uvolni" onmouseover="document.formv1.uloz.disabled = false;">&nbsp;</SPAN>
</td>
<tr>
</FORM>
<div id='myDivElement' style="display: none;" >
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
if( $riadok->pox == 1 AND $riadok->xsx2 == 0 )
{
?>
<tr>
<td class="hvstup" align="center"><?php echo $riadok->xcis; ?></td>
<td class="hvstup" >&nbsp;<?php echo $riadok->xnat; ?></td>
<td class="hvstup" align="right"><?php echo $riadok->xced; ?>&nbsp;</td>
<td class="hvstup" align="right"><?php echo $riadok->xmno; ?>&nbsp;</td>
<td class="hvstup" align="right"><?php echo $riadok->xhdd; ?>&nbsp;</td>
<td class="hvstup" align="center">
<?php if( $vseobj == 0 AND $somvprirskl == 0 ) { ?>
<a href="#" onclick="ZmazPolozkuUplne(<?php echo $riadok->xcpl; ?>,<?php echo $riadok->xdok; ?>);">
<img src='../obr/zmazuplne.png' width=20 height=15 title='Zmazaù poloûku z objedn·vky' ></a>
<?php                                          } ?>
</td>
</tr>
<?php
}

//koniec polozky vypis    
     }
?>
<?php

if( $riadok->pox == 10 )
{
?>
<tr>
<?php if( $vseobj == 0 ) { ?><td class="bmenu" colspan="2">Sum·r objedn·vky Ë. <?php echo $riadok->xdok; ?></td><?php } ?>
<?php if( $vseobj == 1 ) { ?><td class="bmenu" colspan="2">Celkom vöetky objedn·vky</td><?php } ?> <!-- toto je Ëo -->
<td class="bmenu"></td>
<td class="bmenu" align="right"><?php echo $riadok->xmno; ?></td>
<td class="pvstuz" align="right" style="font-size:16px;" ><?php echo $riadok->xhdd; ?>&nbsp;</td>
</tr>
<?php

}


}
$i = $i + 1;
$j = $j + 1;
if( $j > 30 AND $html == 0 ) $j=0;

  }


?>
</table>
<div style="width:100%; margin-top:10px; " ><a href="#" onclick="NovaOBJ();" class="btn-prepni" >&nbsp;&nbsp;<strong>Nov·</strong>&nbsp;objedn·vka&nbsp;&nbsp;</a></div>

<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
