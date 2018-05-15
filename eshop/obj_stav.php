<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {

$zmtz=1*$_REQUEST['zmtz'];

if( $zmtz == 1 )
  {
$sys = 'SKL';
$urov = 2000;
$clsm = 960;
$uziv = include("../uziv.php");
if( !$uziv ) exit;
  }
if( $zmtz == 0 )
  {
exit;
  }

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

//zisti ci som v prirucnom sklade
$somvprirskl=0;
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ezak WHERE cuid = $kli_uzid AND cskf = $kli_vxcf ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$cskp = 1*$fir_riadok->cskp; $cskf = 1*$fir_riadok->cskf; $xxid = 1*$fir_riadok->ez_id;

if( $cskp > 0 AND $cskf > 0 )
  {
$somvprirskl=1;
  }

//koniec zisti ci som v prirucnom sklade

$citwebs = include("../funkcie/citaj_webs.php");
$kli_vxcf=$webs_fir;
if( $kli_vxcf == 0 ) exit;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$autoreg=0;
if (File_Exists ('../eshop/autoregistracia.ano') ) { $autoreg=1; }
$autoregsubor="../dokumenty/FIR".$kli_vxcf."/autoregistracia.ano";
if (File_Exists ($autoregsubor) ) { $autoreg=1; }

if( $copern == 1 )
{
$sql = "SELECT * FROM F$kli_vxcf"."_sklzaspriemer";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
//echo "idem";
$priemer = include("../sklad/skl_rekonstrukcia.php");
     }
}

if( $zmtz == 1 )
  {
$cit_fir = include("../cis/citaj_fir.php");
  }

//zmena cisla objednavky
if( $copern == 44401 )
{
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$h_ncsl = 1*$_REQUEST['h_ncsl'];
?>
<script type="text/javascript">
if( !confirm ("Chcete zmeniù ËÌslo objedn·vky <?php echo $cislo_dok; ?> na ËÌslo <?php echo $h_ncsl; ?> ?") )
         {  }
else
  var okno = window.open("obj_stav.php?copern=44402&drupoh=1&page=1&cislo_dok=<?php echo $cislo_dok; ?>&zmtz=<?php echo $zmtz; ?>&h_ncsl=<?php echo $h_ncsl; ?>","_self");
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
if( $copern == 44402 )
{
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$h_ncsl = 1*$_REQUEST['h_ncsl'];

$uzje=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_kosikobj WHERE xdok = $h_ncsl ORDER BY xdok DESC LIMIT 1"; 
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $uzje=1;
 }

if( $uzje == 1 ) { echo "POZOR !!! Objedn·vka ËÌslo ".$h_ncsl." uû v systÈme existuje !!!"; exit; }

if( $uzje == 0 )
  {

$dsqlt = "UPDATE F$kli_vxcf"."_kosikobj SET xdok='$h_ncsl' WHERE xdok = $cislo_dok ";
$dsql = mysql_query("$dsqlt"); 

$cislo_dok=$h_ncsl;

?>
<script type="text/javascript">
  var okno = window.open("obj_stav.php?copern=1&drupoh=1&page=1&cislo_dok=<?php echo $cislo_dok; ?>&zmtz=<?php echo $zmtz; ?>","_self");
</script>
<?php
  }
exit;
}
//koniec zmena cisla objednavky


//oznac vybavena
if( $copern == 8801 )
{
$cislo_dok=1*$_REQUEST['cislo_dok'];
$h_fak=1*$_REQUEST['h_fak'];

$dsqlt = "UPDATE F$kli_vxcf"."_kosikobj SET xfak='$h_fak' WHERE xdok = $cislo_dok ";
$dsql = mysql_query("$dsqlt"); 
//echo $dsqlt;

?>
<script type="text/javascript">
  var okno = window.open("../eshop/obj_tlac.php?copern=1&drupoh=1&page=1&zmtz=1&html=1","_self");
</script>
<?php
}
//koniec oznac vybavena

//nova polozka
if( $copern == 7701 )
{
$cislo_dok=1*$_REQUEST['cislo_dok'];

$fir_ficox=$fir_fico;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_kosikobj WHERE xdok = $cislo_dok ORDER BY xdok DESC LIMIT 1"; 
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $fir_ficox=1*$riaddok->xice;
 }

$csl=1*$_REQUEST['csl'];
$popisplu=$_REQUEST['h_nat'];
$cisplu=1*$_REQUEST['h_cis'];
$mnoplu=1*$_REQUEST['h_mno'];
$cepplu=1*$_REQUEST['h_cep'];
$dphplu=1*$_REQUEST['h_dph'];
$cedplu=$cepplu*(100+$dphplu)/100;
$hdb=$cepplu*$mnoplu;
$hdd=$cedplu*$mnoplu;

$kli_uzidxx=$kli_uzid;
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ezak WHERE cuid = $kli_uzid ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $xeid = 1*$fir_riadok->ez_id; }
if( $xeid > 0 ) { $kli_uzidxx=$xeid; }

//xdok  xfak  xsx1  xsx2  xsx3  xdx1  xdx2  xdx3  xice  xodbm  xcpo  xcpl  xcis  xnat  xdph  xcep  xced  xmno  xhdb  xhdd  xid  xdatm  
$xsx3=0;
if( $cisplu == 0 ) { $xsx3=1; }
if( $csl == 1 ) { $xsx3=1; }

$dsqlt = "INSERT INTO F$kli_vxcf"."_kosikobj ( xdok, xfak, xice, xodbm, xsx3, xcis, xnat, xid, xdatm, xmno, xdph, xcep, xced, xhdb, xhdd ) ".
" VALUES ( $cislo_dok, 0, '$fir_ficox', 0, '$xsx3', '$cisplu', '$popisplu', $kli_uzidxx, now(), '$mnoplu', '$dphplu', '$cepplu', '$cedplu', '$hdb', '$hdd'  ) ";
$dsql = mysql_query("$dsqlt"); 
//echo $dsqlt;

$html=1;
$copern=1;
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
  var okno = window.open("obj_stav.php?copern=181819&drupoh=1&page=1&h_icoset=<?php echo $setico; ?>&h_odbmset=<?php echo $setobdm; ?>&cislo_dok=<?php echo $cislo_dok; ?>&zmtz=<?php echo $zmtz; ?>","_self");
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

$sqlttt = "UPDATE F$kli_vxcf"."_kosikobj SET xice=$setico, xodbm=$setobdm WHERE xdok = $cislo_dok "; 
$sqldok = mysql_query("$sqlttt");

//echo $sqlttt;

$html=1;
$copern=1;
$zmtz=1;
}
//koniec zmena ico,odbm

$uplnezmazane=0;
//zmazat polozku z obj uplne
if( $copern == 6001 )
{
$plux = 1*$_REQUEST['plux'];
?>
<script type="text/javascript">
if( !confirm ("Chcete zmazaù poloûku Ë.<?php echo $plux; ?> z objedn·vky Ë.<?php echo $cislo_dok; ?> ?") )
         {   }
else
  var okno = window.open("obj_stav.php?copern=6002&drupoh=1&page=1&plux=<?php echo $plux; ?>&cislo_dok=<?php echo $cislo_dok; ?>&zmtz=<?php echo $zmtz; ?>&rozniplu=1","_self");
</script>
<?php
$copern=1;
$html=1;
}
if( $copern == 6002 )
{
$plux = 1*$_REQUEST['plux'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$uplnezmazane=1;

$cisz=0; $natz=""; $cepz=0; $dphz=20; $mnoz=0;
$sqlfir = "SELECT * FROM F$kli_vxcf"."_kosikobj WHERE xcpo = $plux ";
$sqldok = mysql_query("$sqlfir");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cisz=1*$riaddok->xcis;
  $natz=$riaddok->xnat;
  $cepz=1*$riaddok->xcep;
  $dphz=1*$riaddok->xdph;
  $mnoz=1*$riaddok->xmno;
  }


$dsqlt = "DELETE FROM F$kli_vxcf"."_kosikobj  WHERE xcpo = $plux ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;

$html=1;
$copern=1;
}
//koniezmazat polozku z obj uplne

$docasnemazanie=0;
//zmazat polozku z obj docasne
if( $copern == 6101 )
{
$plux = 1*$_REQUEST['plux'];
?>
<script type="text/javascript">
if( !confirm ("Chcete doËasne zmazaù poloûku Ë.<?php echo $plux; ?> z objedn·vky Ë.<?php echo $cislo_dok; ?> ?") )
         {   }
else
  var okno = window.open("obj_stav.php?copern=6102&drupoh=1&page=1&plux=<?php echo $plux; ?>&cislo_dok=<?php echo $cislo_dok; ?>&zmtz=<?php echo $zmtz; ?>","_self");
</script>
<?php
$copern=1;
$html=1;
exit;
}
if( $copern == 6102 )
{
$plux = 1*$_REQUEST['plux'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcx$kli_uzid  WHERE xcpl = $plux AND pox = 1";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;

$docasnemazanie=1;
$html=1;
$copern=1;
}
//koniezmazat polozku z obj docasne

//spracovat obj do fakt
if( $copern == 8001 )
{
$plux = 1*$_REQUEST['plux'];
$textspr=" do fakt˙ry ";
?>
<script type="text/javascript">
if( !confirm ("Chcete spracovaù objedn·vku Ë.<?php echo $plux; ?> <?php echo $textspr; ?> ?") )
         {   }
else
  var okno = window.open("../faktury/vstf_u.php?copern=5&shopdok=1&drupoh=1&page=1sysx=UCT&rozuct=ANO&hladaj_uce=<?php echo $hladaj_uce;?>&cislo_dok=<?php echo $plux; ?>&ttx=1&zprac=1","_self");
</script>
<?php
$cislo_dok=$plux;
$docasnemazanie=1;
$html=1;
$copern=1;
}
//koniec spracovat obj do fakt

//spracovat obj do dod
if( $copern == 9001 )
{
$plux = 1*$_REQUEST['plux'];
$dodod = 1*$_REQUEST['dodod'];
$textspr=" do dodacieho listu "; 
?>
<script type="text/javascript">
if( !confirm ("Chcete spracovaù objedn·vku Ë.<?php echo $plux; ?> <?php echo $textspr; ?> ?") )
         {   }
else
  var okno = window.open("../eshop/spracuj_objdod.php?copern=2&hladaj_uce=88801&drupoh=11&cislo_dok=<?php echo $plux; ?>&dodaneobj=<?php echo $dodaneobj; ?>&lensklad=<?php echo $lensklad; ?>&zprac=<?php echo $zprac; ?>","_self");
</script>
<?php
$cislo_dok=$plux;
$docasnemazanie=1;
$html=1;
$copern=1;
}
//koniec spracovat obj do dod

//spracovat obj len na sklade
if( $copern == 8901 )
{
$plux = 1*$_REQUEST['plux'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
?>
<script type="text/javascript">
if( !confirm ("Chcete spracovaù poloûky na sklade z objedn·vky Ë.<?php echo $plux; ?> ?") )
         {   }
else
  var okno = window.open("../faktury/vstf_u.php?copern=5&shopdok=1&drupoh=1&page=1sysx=UCT&rozuct=ANO&hladaj_uce=<?php echo $hladaj_uce;?>&cislo_dok=<?php echo $plux; ?>&ttx=1&lensklad=1&zprac=1","_self");
</script>
<?php
$docasnemazanie=1;
$html=1;
$copern=1;
}
//koniecspracovat obj len na sklade

//spracovat obj pre ico
if( $copern == 88801 )
{
$plux = 1*$_REQUEST['plux'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$xico99=$plux-999000000000;
$dodaneobj = 1*$_REQUEST['dodaneobj'];
$akepolozky="";
if( $dodaneobj == 1 ) { $akepolozky=" dodanÈ"; }
?>
<script type="text/javascript">
if( !confirm ("Chcete spracovaù<?php echo $akepolozky; ?> poloûky pre iËo <?php echo $xico99; ?> ?") )
         {  }
else
  var okno = window.open("../faktury/vstf_u.php?copern=5&shopdok=1&drupoh=1&page=1sysx=UCT&rozuct=ANO&hladaj_uce=<?php echo $hladaj_uce;?>&cislo_dok=<?php echo $plux; ?>&ttx=1&lensklad=1&zprac=1&dodaneobj=<?php echo $dodaneobj; ?>","_self");
</script>
<?php
$docasnemazanie=0;
$html=1;
$copern=1;
$vsezaico=1;
$vseobj=1;
$icox=$xico99;
}
//koniecspracovat obj pre ico

//platba ?
$sqlfir = "SELECT * FROM F$kli_vxcf"."_kosiktext WHERE invt = $cislo_dok ";
$platba=1;
$sqldok = mysql_query("$sqlfir");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $platba=1*$riaddok->nas1;
  } 
if( $platba == 0 ) { $platba=1; }
//koniec platba

if( $_SESSION['ie10'] == 1 ) { header('X-UA-Compatible: IE=8'); }


$rozniplu = 1*$_REQUEST['rozniplu'];
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">

<title>
OBJ
</title>
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
    
<?php  if( $zmtz == 1 ) { ?>

function importPLU(dok)
                {

var dokx = dok;

window.open('nacitajobjcsv.php?copern=10&drupoh=1&page=1&cislo_dok='+ dokx + '&zmtz=1', '_self' );
                }   

function ZmazPolozku(plu, dok)
                {

var plux = plu;
var dokx = dok;

window.open('obj_stav.php?copern=6101&drupoh=1&page=1&plux='+ plux + '&cislo_dok='+ dokx + '&zmtz=<?php echo $zmtz; ?>',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZmazPolozkuUplne(plu, dok)
                {

var plux = plu;
var dokx = dok;

window.open('obj_stav.php?copern=6001&drupoh=1&page=1&plux='+ plux + '&cislo_dok='+ dokx + '&zmtz=<?php echo $zmtz; ?>&rozniplu=1',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function SpatZoznam()
                {

window.open('../eshop/obj_tlac.php?copern=1&drupoh=1&page=1&zmtz=1&html=1',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function SpracujOBJ(plu)
                {
var plux = plu;

window.open('obj_stav.php?copern=8001&drupoh=1&page=1&plux='+ plux + '&ffd=0&zmtz=1',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );

                }

function SpracujOBJdod(plu)
                {
var plux = plu;

window.open('obj_stav.php?copern=9001&drupoh=1&page=1&plux='+ plux + '&ffd=0&zmtz=1&dodod=1',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );

                }


function SpracujOBJnasklade(plu)
                {
var plux = plu;

window.open('obj_stav.php?copern=8901&drupoh=1&page=1&plux='+ plux + '&ffd=0&zmtz=1&cislo_dok=<?php echo $cislo_dok; ?>',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );

                }

function SpracujOBJnaprskladexxx(plu)
                {
var plux = plu;

window.open('obj_stav.php?copern=88801&drupoh=1&page=1&plux='+ plux + '&ffd=0&zmtz=1&cislo_dok=<?php echo $cislo_dok; ?>',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );

                }

function SpracujOBJnaprsklade(plu)
                {


                }

function SpracujOBJico(plu)
                {
var plux = plu;

window.open('obj_stav.php?copern=88801&drupoh=1&page=1&plux='+ plux + '&ffd=0&zmtz=1&cislo_dok=<?php echo $cislo_dok; ?>',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );

                }

function SpracujOBJicododane(plu)
                {
var plux = plu;

window.open('obj_stav.php?copern=88801&drupoh=1&page=1&plux='+ plux + '&ffd=0&zmtz=1&cislo_dok=<?php echo $cislo_dok; ?>&dodaneobj=1',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );

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

function ExportEAN(dok)
                {

var dokx = dok;

window.open('obj_exportean.php?copern=1&drupoh=1&cislo_dok='+ dokx + '&ffd=2',
 '_blank', 'width=1080, height=900, top=0, left=40, status=yes, resizable=yes, scrollbars=yes' );
                 }

function Export1OBJtxt(dok)
                {

var dokx = dok;

window.open('obj_exporttxt.php?copern=1&drupoh=1&cislo_dok='+ dokx + '&ffd=0',
 '_blank', 'width=1080, height=900, top=0, left=40, status=yes, resizable=yes, scrollbars=yes' );
                 }

<?php                    } ?>



    function textObj( objx )
    {

var h_obj = objx;

window.open('../eshop/obj_text.php?h_obj=' + h_obj + '&copern=1&drupoh=1&page=1&zmtz=1', '_blank',  'width=900, height=800, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );


    }

function DodaciOBJ(plu)
                {
var plux = plu;
 
window.open('dodaci_tlac.php?copern=1&drupoh=1&page=1&cislo_dok=' + plux + '&ffd=0&tlacobj=1&zmtz=1',
 '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacOBJ(plu)
                {
var plux = plu;

window.open('kosik_tlac.php?copern=1&drupoh=1&page=1&cislo_dok=' + plux + '&ffd=0&tlacobj=1&zmtz=<?php echo $zmtz; ?>',
 '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function onloadFunkcia()
                {

<?php if( $uplnezmazane == 1 ) {  ?>

	document.forms.eplu.h_cis.value = "<?php echo $cisz; ?>";
	document.forms.eplu.h_nat.value = "<?php echo $natz; ?>";
	document.forms.eplu.h_dph.value = "<?php echo $dphz; ?>";
	document.forms.eplu.h_cep.value = "<?php echo $cepz; ?>";
	document.forms.eplu.h_mno.value = "<?php echo $mnoz; ?>";

<?php                          }  ?>

<?php if( $rozniplu == 1 ) { echo "rozniPLU();"; } ?>


                }

</script>
<script type="text/javascript" src="nastavfak.js"></script>
<script type="text/javascript" src="spr_ico_xml.js"></script>
<script type="text/javascript" src="spr_plu_xml.js"></script>
<script type="text/javascript" src="spr_odbm_xml.js"></script>
</HEAD>
<BODY class="white" onload="onloadFunkcia();">

<span style="position: absolute; top: 185; left: 50%;  z-index: 3000;"> 
<div id="myIcoElement"></div>
</span>
<span style="position: absolute; top: 185; left: 50%;  z-index: 3000;"> 
<div id="myOdbmElement"></div>
</span> <!-- upraviù -->
<div id="robotmenu" style="display: none; position:absolute; z-index:1; top:100px; right:15%;">
zobrazene menu
</div>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Objedn·vky 

</td>
</tr>
</table>
<br />


<?php
if ( $copern == 1)
     {
?>
<div id="nastavfakx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 200; left: 200; width:600; height:100;">
<table  class='bmenu' >

<tr><td width='28%'></td><td width='52%'></td><td width='20%'></td></tr>

<tr height='25'><td colspan='2' class='bmenu' >V˝ber odberateæa</td>
<td colspan='1' align='right' class='bmenu' ><a href="#" onClick="nastavfakx.style.display='none';" title='Zruöiù registr·ciu' class='regcancel'>Zavrieù
<img src='../obr/zmazuplne.png' style='width:15; height:15; position:relative; top:3px; margin-left:4px;'></a></td></tr>
                    
<tr><FORM name='enasti' method='post' action='#'></tr>

<tr><td colspan='1' align='right' class='pvstuz' >I»O&nbsp;</td> 
<td colspan='2' class='pvstuz' >
<input type='text' name='h_ico' id='h_ico' style='width:100' maxlenght='10' value="" class='povi'>
<img src='../obr/eshop/find_icon.png' width='14' height='14' onclick='volajIcox();' title='Hæadaj I»O' class='odbfind'>
</td></tr>

<tr><td colspan='1' align='right' class='pvstuz' >OdbernÈ miesto&nbsp;</td> 
<td colspan='1' class='pvstuz' ><input type='text' name='h_odbm' id='h_odbm' style='width:150' maxlenght='50' value="" class='norm'>
<img src='../obr/eshop/find_icon.png' width='14' height='14' onclick='volajODBMx();' title='Hæadaj ODBM' class='odbfind'></td>
<td rowspan='2' valign='top' colspan='1' align='right' class='pvstuz' >
<a href="#" onClick="ZapisIco(<?php echo $cislo_dok; ?>);" class='regbut'>Nastaviù<img src='../obr/ok.png' style='width:15; height:15; position:relative; top:3px; margin-left:4px;'></a>
</td></tr>
    
<tr style='height:20px'><td colspan='1' class='pvstuz' ></td><td valign='top' colspan='1' class='pvstuz' ></td></tr>

</FORM></table>
</div>
<script type="text/javascript">

function NastavIco( doklad, icox, odbmx )
                {
  nastavfakx.style.display='';
  document.forms.enasti.h_ico.value=icox;
  document.forms.enasti.h_odbm.value=odbmx;
                }

  function ZapisIco( premx )
                {

  var ico = document.forms.enasti.h_ico.value;
  var odbm = document.forms.enasti.h_odbm.value;

  var doklad = premx;

  window.open('obj_stav.php?copern=181818&h_icoset=' + ico + '&h_odbmset=' + odbm + '&cislo_dok=' + doklad + '&page=1&zmtz=1', '_self' );

                }

  function zhasni_menurobot()
  {                 
  robotmenu.style.display='none';
  myIcoElement.style.display='none';
  myOdbmElement.style.display='none';
  } 

  function volajIcox()
  {                 
  if( document.forms.enasti.h_ico.value != '' ) { volajIco(); }
  }

  function volajODBMx()
  {                 
  if( document.forms.enasti.h_ico.value > 0 ) { volajODBM(); }
  }

</script>
<?php
     }
?>


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


$tlacobj = 1*$_REQUEST['tlacobj'];


//zober z objednavok
$podmdok=" xdok = ".$cislo_dok." ";
if( $vseobj == 1 ) { $podmdok=" xdok > 0 "; }
$icoxvse=$icox;
if( $vseobj == 1 AND $vsezaico == 1 ) { $podmdok=" xdok > 0 "; }
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,xdok,xice,xodbm,xsx3,xcpo,xcis,xnat,xdph,xcep,xced,xmno,xhdb,xhdd,xid,xdatm,0,0,0,0 FROM F$kli_vxcf"."_kosikobj ".
" WHERE $podmdok AND xfak = 0 ".
"";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
//exit;

     }

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcx$kli_uzid  WHERE pox != 1";
$dsql = mysql_query("$dsqlt");

if( $vseobj == 1 ) {

if( $vseobj == 1 AND $vsezaico == 1 ) {

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid  SET xobm=xmno WHERE xice != $icox ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid  SET xmno=0 WHERE xice != $icox ";
$dsql = mysql_query("$dsqlt");
                                      }

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 2,xdok,xice,0,0,xcpl,xcis,xnat,xdph,xcep,xced,SUM(xmno),SUM(xhdb),SUM(xhdd),xid,xdatm,0,SUM(xobm),0,0  FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE xdok > 0 GROUP BY xcis".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcx$kli_uzid  WHERE pox != 2";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET pox=1 ";
$dsql = mysql_query("$dsqlt");
                   }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid,F$kli_vxcf"."_sklzaspriemer SET xskm=zas ".
" WHERE F$kli_vxcf"."_mzdprcx$kli_uzid.xcis=F$kli_vxcf"."_sklzaspriemer.cis AND xsx3 = 0";
$dsql = mysql_query("$dsqlt");

//group mnozstvo na ost.objednavkach
if( $vseobj == 0 ) { 
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcu".$kli_uzid.
" SELECT 1,xdok,xice,0,xsx3,xcpl,xcis,xnat,xdph,xcep,xced,SUM(xmno),xhdb,xhdd,xid,xdatm,0,0,0,0 FROM F$kli_vxcf"."_kosikobj ".
" WHERE xdok != $cislo_dok AND xfak = 0 AND xsx3 = 0 GROUP BY xcis ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid,F$kli_vxcf"."_mzdprcu$kli_uzid SET F$kli_vxcf"."_mzdprcx$kli_uzid.xobm=F$kli_vxcf"."_mzdprcu$kli_uzid.xmno ".
" WHERE F$kli_vxcf"."_mzdprcx$kli_uzid.xcis=F$kli_vxcf"."_mzdprcu$kli_uzid.xcis ";
$dsql = mysql_query("$dsqlt");
                   }
//koniec group mnozstvo na ost.objednavkach

//mnozstvo na prirucnom sklade
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ezak WHERE cuid = $kli_uzid AND cskp != 0 AND cskf != 0 ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$cskp = 1*$fir_riadok->cskp; $cskf = 1*$fir_riadok->cskf;

if( $cskp > 0 AND $cskf > 0 )
  {
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid,F$cskf"."_sklzaspriemer SET xpsk=zas ".
" WHERE F$kli_vxcf"."_mzdprcx$kli_uzid.xcis=F$cskf"."_sklzaspriemer.cis AND xsx3 = 0";
$dsql = mysql_query("$dsqlt");
  }
//koniec mnozstvo na prirucnom sklade

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET xrzd=xskm+xpsk-xmno-xobm ".
" WHERE xsx3 = 0 ";
$dsql = mysql_query("$dsqlt");

//group vsetko
$podmgrp=" xdok";
if( $vseobj == 1 ) { $podmgrp="pox"; }
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 10,xdok,xice,0,0,xcpl,xcis,xnat,xdph,xcep,xced,SUM(xmno),SUM(xhdb),SUM(xhdd),xid,xdatm,SUM(xskm),SUM(xobm),SUM(xrzd),SUM(xpsk)  FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE xdok > 0 GROUP BY $podmgrp".
"";
$dsql = mysql_query("$dsqlt");

if( $vseobj == 1 AND $vsezaico == 1 ) {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $icox ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$naixx = $fir_riadok->nai; $na2xx = $fir_riadok->na2; $ulixx = $fir_riadok->uli;
$pscxx = $fir_riadok->psc; $mesxx = $fir_riadok->mes; $telxx = $fir_riadok->tel; $faxxx = $fir_riadok->fax; $em1xx = $fir_riadok->em1;
                                      }
?>
<table class="h2" width="100%" >
<tr>
<?php if( $vseobj == 0 ) { ?><td class="bmenu" colspan="4">Stav objedn·vky Ë.<?php echo $cislo_dok; ?>

<img src='../obr/uprav.png' onclick="myCslElement.style.display='';" width=20 height=15 border=0 title='Zmeniù ËÌslo objedn·vky' >

<a href="#" onClick="TlacOBJ(<?php echo $cislo_dok; ?>);">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='TlaËiù potvrdenie objedn·vky' ></a>

<div id='myCslElement' style="display: none; width:300px;" >
<table class='fmenu' width='100%' ><tr><FORM name='ecsl' method='post' action='#'>
<td class='hmenu' width='90%' >
 zmeniù ËÌslo <?php echo $cislo_dok; ?> na <input type='text' name='h_ncsl' id='h_ncsl' size='8' >
 <img src='../obr/ok.png' width='14' height='14' onclick='ulozNewc(<?php echo $cislo_dok; ?>);' title='Uloûiù novÈ ËÌslo' >
</td>
<td class='hmenu' width='10%' >
 <img src='../obr/zmaz.png' width='14' height='14' onclick="myCslElement.style.display='none';" title='Zhasn˙ù' >
</td>
</FORM></tr></table>
</div>
<script type="text/javascript">

function ulozNewc( doklad )
                {
var h_ncsl = document.forms.ecsl.h_ncsl.value;


window.open('obj_stav.php?copern=44401&h_ncsl=' + h_ncsl + '&cislo_dok=' + doklad + '&zmtz=1&drupoh=1&page=1', '_self'  );
                }

</script>

</td><?php } ?>
<?php if( $vseobj == 1 AND $vsezaico == 0 ) { ?><td class="bmenu" colspan="4">Stav vöetk˝ch objedn·vok</td><?php } ?>
<?php if( $vseobj == 1 AND $vsezaico == 1 ) { ?><td class="bmenu" colspan="4">Stav vöetk˝ch objedn·vok pre odberateæa iËo <?php echo $icox; ?> <?php echo $naixx." ".$mesxx; ?></td><?php } ?>

<td class="bmenu" colspan="4" align="right">
<a href="#" onClick="SpatZoznam();">
NevybavenÈ OBJ<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Nasp‰ù do zoznamu objedn·vok' ></a>

</tr>
<?php

if ( $drupoh == 1 )
  {
$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_mzdprcx".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_mzdprcx".$kli_uzid.".xcis=F$kli_vxcf"."_sklcis.cis".
" WHERE ( xdok > 0 ) ORDER BY pox,xcpl ";

//echo $sqltt;
  }



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

if( $i == 0 )
  {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $riadok->xice ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$ico = $fir_riadok->ico; $dic = $fir_riadok->dic; $icd = $fir_riadok->icd;
$nai = $fir_riadok->nai; $na2 = $fir_riadok->na2; $uli = $fir_riadok->uli;
$psc = $fir_riadok->psc; $mes = $fir_riadok->mes; $tel = $fir_riadok->tel; $fax = $fir_riadok->fax; $em1 = $fir_riadok->em1;

$icox=1*$ico;

$sqlfir = "SELECT * FROM F$kli_vxcf"."_ezak WHERE ez_id = $riadok->xid ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$ekto = $fir_riadok->ez_kto; $etel = $fir_riadok->ez_tel; $email = $fir_riadok->ez_ema; $odbx = 1*$fir_riadok->cxx1; $icoezak = 1*$fir_riadok->ez_ico;

if( $riadok->xid < 900 AND trim($ekto) == '' )
  {
$sqlfir = "SELECT * FROM klienti WHERE id_klienta = $riadok->xid ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$ekto = $fir_riadok->meno." ".$fir_riadok->priezvisko; $etel = ""; $email = ""; $odbx = 0; $icoezak = 0;

  }


if( $icoezak == 99999999 ) { $odbx=1*$riadok->xodbm; }

$sqlfir = "SELECT * FROM F$kli_vxcf"."_webslu ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) 
{ 
$fir_riadok=mysql_fetch_object($fir_vysledok); 
$platba01 = $fir_riadok->kat04h01;
$platba02 = $fir_riadok->kat04h02;
$platba03 = $fir_riadok->kat04h03;
$platba04 = $fir_riadok->kat04h04;
$platba05 = $fir_riadok->kat04h05;
$platba06 = $fir_riadok->kat04h06;
$platba07 = $fir_riadok->kat04h07;
$platba08 = $fir_riadok->kat04h08;
$platba09 = $fir_riadok->kat04h09;
$platba10 = $fir_riadok->kat04h10;

$platbap = $fir_riadok->kat04p;
} 

  }

//hlavicka strany
if ( $j == 0 )
     {
?>
<?php if( $vseobj == 0 ) { ?>
<tr>
<td class="hvstup" colspan="8">Objednal: <?php echo $ekto; ?>, Tel: <?php echo $etel; ?>, Email: <?php echo $email; ?></td>
</tr>
<tr>
<tr>
<td class="hvstup" colspan="8">D·tum: <?php echo $skdatum; ?></td>
</tr>
<tr>
<td class="hvstup" colspan="8">Firma: <?php echo $nai; ?> <?php echo $na2; ?>, <?php echo $uli; ?>, <?php echo $mes; ?>, <?php echo $psc; ?></td>
</tr>

<?php if( $odbx > 0 ) { 

$sqlfir = "SELECT * FROM F$kli_vxcf"."_icoodbm WHERE ico = $icox AND odbm = $odbx ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$onai = $fir_riadok->onai; $ona2 = $fir_riadok->ona2; $ouli = $fir_riadok->ouli;
$opsc = $fir_riadok->opsc; $omes = $fir_riadok->omes; 

?>
<tr>
<td class="hvstup" colspan="8">OdbernÈ miesto: <?php echo $onai; ?> <?php echo $ona2; ?>, <?php echo $ouli; ?>, <?php echo $omes; ?>, <?php echo $opsc; ?></td>
</tr>
<?php                 } ?>

<tr>
<td class="hvstup" colspan="8">Tel: <?php echo $tel; ?>, Fax: <?php echo $fax; ?>, Email: <?php echo $em1; ?> </td>
</tr>
<tr>
<tr>
<td class="hvstup" colspan="4">

<?php if( $vseobj == 0 AND $somvprirskl == 0 AND $zmtz == 1 ) { ?>

<?php $ico=1*$ico; $odbx=1*$odbx; ?>

<img src='../obr/uprav.png' onClick="NastavIco( <?php echo $cislo_dok; ?>, <?php echo $ico; ?>, <?php echo $odbx; ?>)" width=15 height=15 border=1 title='Upraviù firmu' >
<?php                  } ?>

I»O: <?php echo $ico; ?>, DI»: <?php echo $dic; ?>, I»DPH: <?php echo $icd; ?></td>

<td class="hvstup" colspan="2" align="right" >
<?php if( $vseobj == 0 AND $somvprirskl == 0 AND $zmtz == 1 ) { ?>
<img src='../obr/naradie.png' onClick="NastavFak( <?php echo $cislo_dok; ?>)" width=15 height=15 border=1 title='OznaËiù objedn·vku ako vybaven˙' >

<?php                  } ?>
</td>

<td class="hvstup" colspan="2" align="right" >

<div id='myFakElement' ></div>
</td>

</tr>

<?php if ( $autoreg == 1 )  {

if( $platba == 1 ) { $platbax=$platba01; }
if( $platba == 2 ) { $platbax=$platba02; }
if( $platba == 3 ) { $platbax=$platba03; }
if( $platba == 4 ) { $platbax=$platba04; }
if( $platba == 5 ) { $platbax=$platba05; }
if( $platba == 6 ) { $platbax=$platba06; }
if( $platba == 7 ) { $platbax=$platba07; }
if( $platba == 8 ) { $platbax=$platba08; }
if( $platba == 9 ) { $platbax=$platba09; }
if( $platba == 10 ) { $platbax=$platba10; }
?>
<tr>
<td class="hvstup" colspan="8"><?php echo $platbap; ?>: <?php echo $platbax; ?> </td>
</tr>
<?php
                            }
?>


<tr>
<td class="hvstup" colspan="8">
Pozn·mka <img src='../obr/orig.png' width=20 height=15 border=1 onclick="textObj('<?php echo $cislo_dok;?>')" title="Pozn·mka k objedn·vke" >

<?php
//poznamka
$poznx="";
$sqlfir = "SELECT * FROM F$kli_vxcf"."_kosiktext WHERE invt = $cislo_dok ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $poznx = $fir_riadok->itxt; }
echo $poznx;
?>

<?php                    } ?>
<tr>
<td class="bmenu" align="left" width="30%" >
<?php if( $vseobj == 0 AND $somvprirskl == 0 AND $zmtz == 1 ) { ?>
<a href="#" onClick="importPLU( <?php echo $cislo_dok; ?> )">
<img src='../obr/import.png' width=15 height=15 border=1 title='NaËÌtaù poloûky z CSV s˙boru' ></a>
<?php                                                         } ?>

Poloûka

<?php if( $vseobj == 0 AND $somvprirskl == 0 AND $zmtz == 1 ) { ?>
<a href="#" onClick="rozniPLU();">
<img src='../obr/vlozit.png' width=15 height=15 border=1 title='Nov· poloûka ' ></a>
<?php                                                         } ?>
</td>
<td class="bmenu" align="right" width="10%" >Mnoûstvo</td>
<td class="bmenu" align="right" width="10%" >Na hl. sklade</td>
<td class="bmenu" align="right" width="10%" >Na pr. sklade</td>
<td class="bmenu" align="right" width="10%" >œalöie objedn·vky</td>
<td class="bmenu" align="right" width="10%" >Zostatok</td>
<td class="bmenu" align="right" width="10%" >Cena bez/s DPH</td>
<td class="bmenu" align="right" width="10%" >Hodnota bez/s DPH</td>
</tr>
<tr>
<td class="bmenu" colspan="8" >
<div id='myPluElement' style="display: none;" >
<table class='fmenu' width='100%' ><tr><FORM name='eplu' method='post' action='#'>
<td class='hmenu' width='90%' >
 <input type="checkbox" name="csl" value="1" title="ËÌselnÌk tovaru / sluûieb(zaökrtnutÈ)">
 <img src='../obr/hladaj.png' width='14' height='14' onclick="hladPLU();" title='Hladaù poloûku' > 
 cis<input type='text' name='h_cis' id='h_cis' maxlenght='10' size='5' value='0' onKeyDown="return CisEnter(event.which)">
 n·zov<input type='text' name='h_nat' id='h_nat' size='35' onKeyDown="return NatEnter(event.which)" >
 sadzba dph<input type='text' name='h_dph' id='h_dph' size='5' value='20' >
 cena bez dph<input type='text' name='h_cep' id='h_cep' size='5' onKeyDown="return CepEnter(event.which)" >
 mnoûstvo<input type='text' name='h_mno' id='h_mno' size='5' onKeyDown="return MnoEnter(event.which)" >
 <img src='../obr/ok.png' width='14' height='14' onclick='NovaPLU(<?php echo $cislo_dok; ?>);' title='Uloûiù poloûku' >
</td>
<td class='hmenu' width='10%' >
 <img src='../obr/zmaz.png' width='14' height='14' onclick="myPluElement.style.display='none'; myDivElement.style.display='none';" title='Zhasn˙ù ponuku' >
</td>
</FORM></tr></table>
</div>
<div id="myDivElement" style="display: none;" ></div>
</td>
</tr>
<script type="text/javascript">

function rozniPLU()
                {
	myPluElement.style.display='';
        document.forms.eplu.h_cis.focus();
        document.forms.eplu.h_cis.select();
                }

function hladPLU()
                {
	myDivElement.style.display=''; 
	volajSlu();

                }

function NovaPLU( doklad )
                {
var h_cis = document.forms.eplu.h_cis.value;
var h_nat = document.forms.eplu.h_nat.value;
var h_dph = document.forms.eplu.h_dph.value;
var h_cep = document.forms.eplu.h_cep.value;
var h_mno = document.forms.eplu.h_mno.value;
var csl   = 0;
if( document.forms.eplu.csl.checked ) csl=1;


window.open('obj_stav.php?copern=7701&csl=' + csl + '&h_cis=' + h_cis + '&h_nat=' + h_nat + '&h_mno=' + h_mno + '&h_dph=' + h_dph + '&h_cep=' + h_cep + '&cislo_dok=' + doklad + '&zmtz=1&drupoh=1&page=1&rozniplu=1', '_self'  );
                }

function vykonajPlu(slu,nazov,dph,cenap,cenad,cenan,zas,mer)
                {
        document.forms.eplu.h_cis.value = slu;
        document.forms.eplu.h_nat.value = nazov;
        document.forms.eplu.h_dph.value = dph;
        document.forms.eplu.h_cep.value = cenap;
        document.forms.eplu.h_mno.value = zas;

        myDivElement.style.display='none';
        document.forms.eplu.h_cep.focus();
        document.forms.eplu.h_cep.select();
                }

function CisEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 && document.forms.eplu.h_cis.value != "0" && document.forms.eplu.h_cis.value != "" ){
	myDivElement.style.display=''; 
	volajSlu();
              }
  if(k == 13 && document.forms.eplu.h_cis.value == "0" ){
        document.forms.eplu.h_nat.focus();
        document.forms.eplu.h_nat.select();
              }

                }

function NatEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 && document.forms.eplu.h_nat.value != "" ){
	myDivElement.style.display=''; 
	volajSlu();
              }
                }

function MnoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13){
	NovaPLU(<?php echo $cislo_dok; ?>);
             }
                }

function CepEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13){
        document.forms.eplu.h_mno.focus();
        document.forms.eplu.h_mno.select();
             }
                }

</script>
<?php
//andrejko tuto robi
     }
//koniec hlavicky j=0



if( $riadok->pox == 1 AND $drupoh == 1 )
{

$xcis=1*$riadok->xcis;
$nat=$riadok->nat;

if( $xcis == 0 AND $riadok->xsx3 == 0 ) { $nat=$riadok->xnat; $xcis=0; }

if( $riadok->xsx3 == 1 )
  {
$sqlttt = "SELECT * FROM F$kli_vxcf"."_sluzby WHERE slu = $xcis ORDER BY slu LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $natx=$riaddok->nsl;
 $xcisx=$riaddok->slu;
 }
$nat=$natx;
$xcis=$xcisx;

if( $xcis == 0 ) { $nat=$riadok->xnat; $xcis=0; }
  }


?>
<tr>
<td class="hvstup">
<?php if( $vseobj == 0 AND $somvprirskl == 0 ) { ?>
<a href="#" onClick="ZmazPolozku(<?php echo $riadok->xcpl; ?>,<?php echo $riadok->xdok; ?>);">
<img src='../obr/zmaz.png' width=20 height=15 border=0 title='Zmazaù poloûku doËasne' ></a>
<?php                    } ?>
<?php echo $xcis; ?> <?php echo $nat; ?></td>
<td class="hvstup" align="right"><?php echo $riadok->xmno; ?></td>
<td class="hvstup" align="right"><?php echo $riadok->xskm; ?></td>
<td class="hvstup" align="right"><?php echo $riadok->xpsk; ?></td>
<td class="hvstup" align="right"><?php echo $riadok->xobm; ?></td>
<td class="hvstup" align="right"><?php echo $riadok->xrzd; ?></td>
<td class="hvstup" align="right"><?php echo $riadok->xcep; ?> / <?php echo $riadok->xced; ?></td>
<td class="hvstup" align="right"><?php echo $riadok->xhdb; ?> / <?php echo $riadok->xhdd; ?>
<?php if( $vseobj == 0 AND $somvprirskl == 0 ) { ?>
<a href="#" onClick="ZmazPolozkuUplne(<?php echo $riadok->xcpl; ?>,<?php echo $riadok->xdok; ?>);">
<img src='../obr/zmazuplne.png' width=20 height=15 border=0 title='Zmazaù poloûku ˙plne z objedn·vky' ></a>
<?php                    } ?>
</td>
</tr>
<?php
}


if( $riadok->pox == 10 AND $drupoh == 1 )
{
?>
<tr>
<?php if( $vseobj == 0 ) { ?><td class="bmenu">Celkom objedn·vka Ë.<?php echo $riadok->xdok; ?></td><?php } ?>
<?php if( $vseobj == 1 ) { ?><td class="bmenu">Celkom vöetky objedn·vky</td><?php } ?>
<td class="bmenu" align="right"><?php echo $riadok->xmno; ?></td>
<td class="bmenu" align="right"> </td>
<td class="bmenu" align="right"> </td>
<td class="bmenu" align="right"> </td>
<td class="bmenu" align="right"> </td>
<td class="bmenu" align="right"> </td>
<td class="bmenu" align="right"><?php echo $riadok->xhdb; ?> / <?php echo $riadok->xhdd; ?></td>
</tr>
<?php

}





}
$i = $i + 1;
$j = $j + 1;
if( $j > 30 AND $html == 0 ) $j=0;

  }


?>
<tr>
<td class="bmenu"> 
<?php if( $vseobj == 0 AND $somvprirskl == 0 ) { ?>
<a href="#" onClick="SpracujOBJ(<?php echo $riadok->xdok; ?>);">
all <img src='../obr/ok.png' width=20 height=20 border=0 title='Spracovaù cel˙ objedn·vku Ë.<?php echo $riadok->xdok; ?> do Fakt˙ry' ></a>
<?php                    } ?>


<?php if( $vseobj == 0 AND $somvprirskl == 0 AND $fir_fico == 46614478 ) { ?>
&nbsp&nbsp&nbsp&nbsp&nbsp<a href="#" onClick="SpracujOBJdod(<?php echo $riadok->xdok; ?>);">
ddl <img src='../obr/prev.png' width=20 height=20 border=0 title='Spracovaù cel˙ objedn·vku Ë.<?php echo $riadok->xdok; ?> do Dodacieho listu' ></a>
<?php                    } ?>

<?php if( $vseobj == 1 AND $vsezaico == 1 ) { ?>
<?php $xico99=999000000000+$icoxvse; ?>
<a href="#" onClick="SpracujOBJico(<?php echo $xico99; ?>);">
all<img src='../obr/ok.png' width=20 height=20 border=0 title='Spracovaù vöetky objedn·vky pre iËo <?php echo $icoxvse; ?>' ></a>
<?php                    } ?>
</td>
<td class="bmenu"> 
<?php if( $vseobj == 1 AND $vsezaico == 1 ) { ?>
<?php $xico99=999000000000+$icoxvse; ?>
<a href="#" onClick="SpracujOBJicododane(<?php echo $xico99; ?>);">
dodanÈ<img src='../obr/ok.png' width=20 height=20 border=0 title='Spracovaù dodanÈ objedn·vky pre iËo <?php echo $icoxvse; ?>' ></a>
<?php                    } ?>
<?php if( $vseobj == 0 AND $somvprirskl == 0 ) { ?>
<a href="#" onClick="DodaciOBJ(<?php echo $riadok->xdok; ?>);">
Dod.list<img src='../obr/pdf.png' width=20 height=20 border=0 title='DodacÌ list na cel˙ objedn·vku Ë.<?php echo $riadok->xdok; ?>' ></a>
<?php                    } ?>
<td class="bmenu"> 
<td class="bmenu">
<?php if( $vseobj == 0 AND $somvprirskl == 1 ) { ?>
<a href="#" onClick="SpracujOBJnaprsklade(<?php echo $riadok->xdok; ?>);">
pr.skl<img src='../obr/ok.png' width=20 height=20 border=0 title='Spracovaù poloûky na prÌruËnom sklade z objedn·vky Ë.<?php echo $riadok->xdok; ?>' ></a>
<?php                    } ?> 
<td class="bmenu"> 
<td class="bmenu"> 
<?php if( $vseobj == 0 AND $somvprirskl == 0 ) { ?>
<a href="#" onClick="SpracujOBJnasklade(<?php echo $riadok->xdok; ?>);">
skl<img src='../obr/ok.png' width=20 height=20 border=0 title='Spracovaù poloûky na sklade z objedn·vky Ë.<?php echo $riadok->xdok; ?>' ></a>
<?php                    } ?>
</td>
<td class="bmenu"> 
<?php
$cislo_dox=$riadok->xdok;
if( $vseobj == 1 ) { $cislo_dox=0; }
?>
All<a href="#" onClick="Export1OBJ(<?php echo $cislo_dox; ?>);">
<img src='../obr/export.png' width=20 height=20 border=0 title='Exportovaù cel˙ objedn·vku Ë.<?php echo $cislo_dox; ?> do CSV' ></a>
<br />
NoSkl<a href="#" onClick="Export2OBJ(<?php echo $cislo_dox; ?>);">
<img src='../obr/export.png' width=20 height=20 border=0 title='Exportovaù poloûky, ktorÈ nie s˙ na sklade z objedn·vky Ë.<?php echo $cislo_dox; ?> do CSV' ></a>
<br />
EAN<a href="#" onClick="ExportEAN(<?php echo $cislo_dox; ?>);">
<img src='../obr/export.png' width=20 height=20 border=0 title='Exportovaù cel˙ objedn·vku Ë.<?php echo $cislo_dox; ?> aj s EAN do CSV' ></a>

</td>
<td class="bmenu"> 
<?php
$cislo_dox=$riadok->xdok;
if( $vseobj == 1 ) { $cislo_dox=0; }
?>
All<a href="#" onClick="Export1OBJtxt(<?php echo $cislo_dox; ?>);">
<img src='../obr/zoznam.png' width=20 height=20 border=0 title='Exportovaù cel˙ objedn·vku Ë.<?php echo $cislo_dox; ?> do TXT' ></a>
</td>

</tr>
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
