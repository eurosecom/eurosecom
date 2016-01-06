<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;
if(!isset($kli_vduj)) $kli_vduj = 1;

       do
       {

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$drupoh = 1*strip_tags($_REQUEST['drupoh']);
$uce = 1*strip_tags($_REQUEST['uce']);
$h_uce=$uce;
$h_poh = 1*strip_tags($_REQUEST['h_poh']);
$ico = 1*strip_tags($_REQUEST['ico']);
$fak = 1*strip_tags($_REQUEST['fak']);
$Z0 = 1*strip_tags($_REQUEST['Z0']);
$Z1 = 1*strip_tags($_REQUEST['Z1']);
$Z2 = 1*strip_tags($_REQUEST['Z2']);
$D1 = 1*strip_tags($_REQUEST['D1']);
$D2 = 1*strip_tags($_REQUEST['D2']);
$HU = 1*strip_tags($_REQUEST['HU']);
$ZOST = 1*strip_tags($_REQUEST['ZOST']);

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

$kontrolastrzak=0;
if( $poliklinikase == 1 ) $kontrolastrzak=1;
if( $kontrolstrzak == 1 ) $kontrolastrzak=1;

$rozuct = $_REQUEST['rozuct'];
if(!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if(!isset($sysx)) $sysx = 'INE';
if( $sysx == 'UCT' ) $rozuct="ANO";
$cislo_dok =  strip_tags($_REQUEST['cislo_dok']);
$next_dok = 1*$cislo_dok +1;
$prev_dok = 1*$cislo_dok -1;
$hladaj_uce = strip_tags($_REQUEST['hladaj_uce']);

$tlacitkoenter=0;
//if( $_SESSION['nieie'] == 1 AND $_SESSION['chrome'] == 0 AND $_SESSION['safari'] == 0 ) { $tlacitkoenter=1; }
if( $copern != 1 ) { $tlacitkoenter=0; }

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

if( $drupoh == 1 )
{
$tabl = "fakodb";
$uctfak = "uctodb";
}
if( $drupoh == 2 )
{
$tabl = "fakdod";
$uctfak = "uctdod";
}

$nastavene_uce=1*$_SESSION['nastavene_uce'];
if( $nastavene_uce > 0 ) $hladaj_uce=$nastavene_uce;

?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Roz˙Ëtovanie dokladu <?php echo $cislo_dok;?></title>
  <style type="text/css">

  </style>
<script type="text/javascript" src="spr_zlh_ins.js"></script>

<script type="text/javascript" src="spr_ucm_xml.js"></script>
<script type="text/javascript" src="spr_ucd_xml.js"></script>
<script type="text/javascript" src="spr_icp_xml.js"></script>
<script type="text/javascript" src="spr_str_xml.js"></script>
<script type="text/javascript" src="spr_zak_xml.js"></script>
<script type="text/javascript" src="spr_rdp_xml.js"></script>
<script type="text/javascript" src="spr_ucf_vyp.js"></script>
<script type="text/javascript" src="spr_ucf_ins.js"></script>
<?php if( $kli_nemazat != 1 ) { ?> <script type="text/javascript" src="spr_ucf_del.js"></script> <?php } ?> 

<?php if( $kli_nemazat == 1 ) { ?> 
<script type="text/javascript">
function ZmazRozuct(drupoh,ako,doklad,cpl,ucm,ucd,rdp,hop,ico,fak,str,zak)
{

}
</script>
<?php                         } ?> 

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

<?php if( $_SESSION['nieie'] == 0 ) { ?>

function KopyDok()
                {
        window.close();
        return !window.open('../faktury/vstf_u.php?copern=5&kopydok=1&drupoh=<?php echo $drupoh;?>&page=1sysx=UCT&rozuct=ANO&hladaj_uce=<?php echo $hladaj_uce;?>&cislo_dok=<?php echo $cislo_dok;?>','zoznam'); 
                }

function GoToZoznam()
                {
<?php $godrup = $drupoh + 1000; ?>
        window.close();
        return !window.open('../faktury/vstfak.php?sysx=UCT&rozuct=ANO&copern=1&drupoh=<?php echo $godrup; ?>&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>','zoznam'); 

                }

function NovyDoklad()
                {
<?php $godrup = $drupoh; ?>
        window.close();
        return !window.open('../faktury/vstf_u.php?sysx=UCT&rozuct=ANO&copern=5&drupoh=<?php echo $godrup; ?>&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>','zoznam'); 

                }

function Ulozit()
                {
    var okvstup=1;
    if ( document.forms1.err_ucm.value == '1' ) okvstup=0;

    if ( document.forms1.h_ucm.value == '' ) okvstup=0;
    if ( document.forms1.h_ucd.value == '' ) okvstup=0;
    if ( document.forms1.h_rdp.value == '' ) okvstup=0;
    if ( document.forms1.h_hop.value == '' ) okvstup=0;
    if ( document.forms1.h_hop.value == '0' ) okvstup=0;

<?php if( $kontrolastrzak == 1 ) { ?>

    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_zak.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_zak.value == '' ) okvstup=2;

    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_zak.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_zak.value == '' ) okvstup=2;

<?php                           } ?>

    if ( okvstup == 1 )
    { 
    UlozRozuct(<?php echo $drupoh; ?>,0,<?php echo $cislo_dok; ?>);
    ZhasniPopis();

    }
    if ( okvstup == 0 && document.forms1.h_ucm.value == '' ) { document.forms1.h_ucm.focus(); }
    if ( okvstup == 0 && document.forms1.h_ucd.value == '' ) { document.forms1.h_ucd.focus(); }
    if ( okvstup == 0 && document.forms1.h_rdp.value == '' ) { document.forms1.h_rdp.focus(); }
    if ( okvstup == 0 && document.forms1.h_hop.value == '' ) { document.forms1.h_hop.focus(); }
    if ( okvstup == 0 && document.forms1.h_hop.value == '0' ) { document.forms1.h_hop.focus(); }
    if ( okvstup == 2 ) { document.forms1.h_str.focus(); document.forms1.h_str.select(); Str.style.display=""; }
                }

function TlacRozuct()
                {
        return !window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=NIE&copern=20&drupoh=<?php echo $drupoh;?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&page=1&cislo_dok=<?php echo $cislo_dok;?>&tlacitR=1','_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes'); 
                }

function Dalsi()
                {
        window.close();
        return !window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=<?php echo $drupoh;?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&page=1&cislo_dok=<?php echo $next_dok;?>','zoznam'); 
                }

function Minul()
                {
        window.close();
        return !window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=<?php echo $drupoh;?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&page=1&cislo_dok=<?php echo $prev_dok;?>','zoznam'); 
                }

    function ZmazUcto()
    {
<?php if( $kli_nemazat != 1 ) { ?> 

<?php $godrup = $drupoh + 1000; ?>
        window.close();
        return !window.open('../faktury/vstfak.php?sysx=UCT&rozuct=ANO&copern=416&drupoh=<?php echo $godrup; ?>&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&cislo_dok=<?php echo $cislo_dok; ?>','zoznam'); 

<?php                         } ?> 
    }


function TlacRozuctPDF()
                {
        return !window.open('../faktury/vstf_pdf.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=<?php echo $drupoh;?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&page=1&cislo_dok=<?php echo $cislo_dok;?>&tlacitR=1&fff=1&mini=1','_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes'); 
                }

<?php                                } ?>

<?php if( $_SESSION['nieie'] == 1 ) { ?>

function KopyDok()
                {
        return !window.open('../faktury/vstf_u.php?copern=5&kopydok=1&drupoh=<?php echo $drupoh;?>&page=1sysx=UCT&rozuct=ANO&hladaj_uce=<?php echo $hladaj_uce;?>&cislo_dok=<?php echo $cislo_dok;?>','_self'); 
                }

function GoToZoznam()
                {
<?php $godrup = $drupoh + 1000; ?>
        return !window.open('../faktury/vstfak.php?sysx=UCT&rozuct=ANO&copern=1&drupoh=<?php echo $godrup; ?>&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>','_self'); 

                }

function NovyDoklad()
                {
<?php $godrup = $drupoh; ?>
        return !window.open('../faktury/vstf_u.php?sysx=UCT&rozuct=ANO&copern=5&drupoh=<?php echo $godrup; ?>&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>','_self'); 

                }

function Ulozit()
                {
    var okvstup=1;
    if ( document.forms1.err_ucm.value == '1' ) okvstup=0;

    if ( document.forms1.h_ucm.value == '' ) okvstup=0;
    if ( document.forms1.h_ucd.value == '' ) okvstup=0;
    if ( document.forms1.h_rdp.value == '' ) okvstup=0;
    if ( document.forms1.h_hop.value == '' ) okvstup=0;
    if ( document.forms1.h_hop.value == '0' ) okvstup=0;

<?php if( $kontrolastrzak == 1 ) { ?>

    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_zak.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_zak.value == '' ) okvstup=2;

    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_zak.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_zak.value == '' ) okvstup=2;

<?php                           } ?>

    if ( okvstup == 1 )
    { 
    UlozRozuct(<?php echo $drupoh; ?>,0,<?php echo $cislo_dok; ?>);
    ZhasniPopis();

    }
    if ( okvstup == 0 && document.forms1.h_ucm.value == '' ) { document.forms1.h_ucm.focus(); }
    if ( okvstup == 0 && document.forms1.h_ucd.value == '' ) { document.forms1.h_ucd.focus(); }
    if ( okvstup == 0 && document.forms1.h_rdp.value == '' ) { document.forms1.h_rdp.focus(); }
    if ( okvstup == 0 && document.forms1.h_hop.value == '' ) { document.forms1.h_hop.focus(); }
    if ( okvstup == 0 && document.forms1.h_hop.value == '0' ) { document.forms1.h_hop.focus(); }
    if ( okvstup == 2 ) { document.forms1.h_str.focus(); document.forms1.h_str.select(); Str.style.display=""; }
                }

function TlacRozuct()
                {
        return !window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=NIE&copern=20&drupoh=<?php echo $drupoh;?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&page=1&cislo_dok=<?php echo $cislo_dok;?>&tlacitR=1','_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes'); 
                }

function Dalsi()
                {
        return !window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=<?php echo $drupoh;?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&page=1&cislo_dok=<?php echo $next_dok;?>','_self'); 
                }

function Minul()
                {
        return !window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=<?php echo $drupoh;?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&page=1&cislo_dok=<?php echo $prev_dok;?>','_self'); 
                }


    function ZmazUcto()
    {
<?php if( $kli_nemazat != 1 ) { ?> 

<?php $godrup = $drupoh + 1000; ?>
        return !window.open('../faktury/vstfak.php?sysx=UCT&rozuct=ANO&copern=416&drupoh=<?php echo $godrup; ?>&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&cislo_dok=<?php echo $cislo_dok; ?>','_self'); 

<?php                         } ?> 
    }


function TlacRozuctPDF()
                {

window.open('../faktury/vstf_pdf.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=<?php echo $drupoh;?>&hladaj_uce=<?php echo $hladaj_uce; ?>&page=1&cislo_dok=<?php echo $cislo_dok;?>&tlacitR=1&fff=1&mini=1','_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');

                }


<?php                                } ?>


function UcmOnfocus(e)
                {

        <?php echo "document.forms1.h_ico.value = '".$ico."';"; ?>
        <?php echo "document.forms1.h_fak.value = '".$fak."';"; ?>
        <?php if( $drupoh == 11 ) echo "document.forms1.h_ucm.value = '".$uce."';"; ?>
        <?php if( $drupoh == 12 ) echo "document.forms1.h_ucd.value = '".$uce."';"; ?>

        if ( document.forms1.h_ucm.value == '' ) document.forms1.h_ucm.value = '0';
        document.forms.forms1.h_ucm.focus();
        document.forms.forms1.h_ucm.select();

                }

function UcmEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        var slpol = document.forms1.slpol.value;
        if ( document.forms1.h_ucm.value != '' && document.forms1.h_ucm.value != '0' ) 
<?php
if ( $sysx == 'UCT' ) 
{
?>
        { myUcmelement.style.display=''; volajUcm(slpol,10); }
<?php
}
?>
<?php
if ( $sysx != 'UCT' ) 
{
?>
        { if ( document.forms1.h_ucd.value == '' ) document.forms1.h_ucd.value = '0'; document.forms.forms1.h_ucd.focus(); document.forms.forms1.h_ucd.select(); }
<?php
}
?>
        if ( document.forms1.h_ucm.value == '0' )
        {         
        if ( document.forms1.h_ucd.value == '' ) document.forms1.h_ucd.value = '0';
        document.forms.forms1.h_ucd.focus();
        document.forms.forms1.h_ucd.select();
        }
              }

                }


//co urobi po potvrdeni ok z tabulky ucm
function vykonajUcm(ucm,ucmtext)
                {
         ukazUcm.innerHTML = "UCM: " + ucmtext;
         ukazUcm.style.display='';
         document.forms.forms1.h_ucm.value = ucm;
         myUcmelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_ucd.value == '' ) document.forms1.h_ucd.value = '0';
         document.forms1.h_ucd.focus();
         document.forms1.h_ucd.select();
                }


function Len1Ucm(ucm)
              {
         document.forms.forms1.h_ucm.value = ucm;
         myUcmelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_ucd.value == '' ) document.forms1.h_ucd.value = '0';
         document.forms1.h_ucd.focus();
         document.forms1.h_ucd.select();
              }

function Len0Ucm()
                    {
         document.forms1.h_ucm.focus();
         document.forms1.h_ucm.select();
                    }



function UcdEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        var slpol = document.forms1.slpol.value;
        if ( document.forms1.h_ucd.value != '' && document.forms1.h_ucd.value != '0' )
<?php
if ( $sysx == 'UCT' ) 
{
?>
        { myUcdelement.style.display=''; volajUcd(slpol,10); }
<?php
}
?>
<?php
if ( $sysx != 'UCT' ) 
{
?>
        { if ( document.forms1.h_rdp.value == '' ) document.forms1.h_rdp.value = '0'; document.forms.forms1.h_rdp.focus(); }
<?php
}
?>

        if ( document.forms1.h_ucd.value == '0' )
        {         
        if ( document.forms1.h_rdp.value == '' ) document.forms1.h_rdp.value = '1';
        document.forms.forms1.h_rdp.focus();
         <?php if( $rozuct == 'ANO' ) echo "document.forms1.h_rdp.select();"; ?>
        }
              }

                }


//co urobi po potvrdeni ok z tabulky ucd
function vykonajUcd(ucd,ucdtext)
                {
         ukazUcd.innerHTML = "UCD: " + ucdtext;
         ukazUcd.style.display='';
         document.forms.forms1.h_ucd.value = ucd;
         myUcdelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_rdp.value == '' ) document.forms1.h_rdp.value = '1';
         document.forms1.h_rdp.focus();
         <?php if( $rozuct == 'ANO' ) echo "document.forms1.h_rdp.select();"; ?>
                }


function Len1Ucd(ucd)
              {
         document.forms.forms1.h_ucd.value = ucd;
         myUcdelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_rdp.value == '' ) document.forms1.h_rdp.value = '1';
         document.forms1.h_rdp.focus();
         <?php if( $rozuct == 'ANO' ) echo "document.forms1.h_rdp.select();"; ?>
              }

function Len0Ucd()
                    {
         document.forms1.h_ucd.focus();
         document.forms1.h_ucd.select();
                    }



<?php
if ( $rozuct != 'ANO' ) 
{
?>
function RdpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        if ( document.forms1.h_fak.value == '' ) document.forms1.h_fak.value = '0';
        document.forms.forms1.h_fak.focus();
        document.forms.forms1.h_fak.select();
              }

                }
<?php
}
?>


<?php
if ( $rozuct == 'ANO' ) 
{
?>function RdpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        var slpol = document.forms1.slpol.value;
        if ( document.forms1.h_rdp.value != '' ) 

        { myRdpelement.style.display=''; volajRdp(slpol,10); }

               }

                }


//co urobi po potvrdeni ok z tabulky rdp
function vykonajRdp(rdp,rdptext)
                {
         ukazRdp.innerHTML = "Druh DPH: " + rdptext;
         ukazRdp.style.display='';
         document.forms.forms1.h_rdp.value = rdp;
         myRdpelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_fak.value == '' ) document.forms1.h_fak.value = '0';
         document.forms1.h_fak.focus();
         document.forms1.h_fak.select();
                }


function Len1Rdp(rdp)
              {
         document.forms.forms1.h_rdp.value = rdp;
         myRdpelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_fak.value == '' ) document.forms1.h_fak.value = '0';
         document.forms1.h_fak.focus();
         document.forms1.h_fak.select();
              }

function Len0Rdp()
                    {
         document.forms1.h_rdp.focus();
         document.forms1.h_rdp.select();
                    }

<?php
}
?>

function FakEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {

        if ( document.forms1.h_ico.value == '' ) document.forms1.h_ico.value = '<?php echo $h_ico; ?>';
        if ( document.forms1.h_ico.value == '0' ) document.forms1.h_ico.value = '<?php echo $h_ico; ?>';
        document.forms.forms1.h_ico.focus();
        document.forms.forms1.h_ico.select();
              }

                }

function IcpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        var slpol = document.forms1.slpol.value;
        if ( document.forms1.h_ico.value != '' && document.forms1.h_ico.value != '0' ) 
<?php
if ( $sysx == 'UCT' ) 
{
?>
        { myIcpelement.style.display=''; volajIcp(slpol,10); }
<?php
}
?>
<?php
if ( $sysx != 'UCT' ) 
{
?>
        { if ( document.forms1.h_str.value == '' ) document.forms1.h_str.value = '0'; document.forms.forms1.h_str.focus(); document.forms.forms1.h_str.select(); }
<?php
}
?>
        if ( document.forms1.h_ico.value == '0' )
        {         
        if ( document.forms1.h_str.value == '' ) document.forms1.h_str.value = '0';
        document.forms.forms1.h_str.focus();
        document.forms.forms1.h_str.select();
        }
              }

                }


//co urobi po potvrdeni ok z tabulky ico
function vykonajIcp(ico,icptext)
                {
         ukazIcp.innerHTML = "I»O: " + icptext;
         ukazIcp.style.display='';
         document.forms.forms1.h_ico.value = ico;
         myIcpelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_str.value == '' ) document.forms1.h_str.value = '0';
         document.forms1.h_str.focus();
         document.forms1.h_str.select();
                }


function Len1Icp(ico)
              {
         document.forms.forms1.h_ico.value = ico;
         myIcpelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_str.value == '' ) document.forms1.h_str.value = '0';
         document.forms1.h_str.focus();
         document.forms1.h_str.select();
              }

function Len0Icp()
                    {
         document.forms1.h_rdp.focus();
         document.forms1.h_rdp.select();
                    }


function StrEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        var slpol = document.forms1.slpol.value;
        if ( document.forms1.h_str.value != '' && document.forms1.h_str.value != '0' ) 
<?php
if ( $sysx == 'UCT' ) 
{
?>
        { myStrelement.style.display=''; volajStr(slpol,10); }
<?php
}
?>
<?php
if ( $sysx != 'UCT' ) 
{
?>
        { if ( document.forms1.h_zak.value == '' ) document.forms1.h_zak.value = '0'; document.forms.forms1.h_zak.focus(); document.forms.forms1.h_zak.select(); }
<?php
}
?>
        if ( document.forms1.h_str.value == '0' )
        {         
        if ( document.forms1.h_zak.value == '' ) document.forms1.h_zak.value = '0';
        document.forms.forms1.h_zak.focus();
        document.forms.forms1.h_zak.select();
        }
              }

                }


//co urobi po potvrdeni ok z tabulky str
function vykonajStr(str,strtext)
                {
         ukazStr.innerHTML = "Stredisko: " + strtext;
         ukazStr.style.display='';
         document.forms.forms1.h_str.value = str;
         myStrelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_zak.value == '' ) document.forms1.h_zak.value = '0';
         document.forms1.h_zak.focus();
         document.forms1.h_zak.select();
                }


function Len1Str(str)
              {
         document.forms.forms1.h_str.value = str;
         myStrelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_zak.value == '' ) document.forms1.h_zak.value = '0';
         document.forms1.h_zak.focus();
         document.forms1.h_zak.select();
              }

function Len0Str()
                    {
         document.forms1.h_str.focus();
         document.forms1.h_str.select();
                    }


function ZakEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        var slpol = document.forms1.slpol.value;
        if ( document.forms1.h_zak.value != '' && document.forms1.h_zak.value != '0' ) 
<?php
if ( $sysx == 'UCT' ) 
{
?>
        { myZakelement.style.display=''; volajZak(slpol,10); }
<?php
}
?>
<?php
if ( $sysx != 'UCT' ) 
{
?>
        { if ( document.forms1.h_hop.value == '' ) document.forms1.h_hop.value = '0'; document.forms.forms1.h_hop.focus(); document.forms.forms1.h_hop.select(); }
<?php
}
?>
        if ( document.forms1.h_zak.value == '0' )
        {         
        if ( document.forms1.h_hop.value == '' ) document.forms1.h_hop.value = '0';
        document.forms.forms1.h_hop.focus();
        document.forms.forms1.h_hop.select();
        }
              }

                }


//co urobi po potvrdeni ok z tabulky zak
function vykonajZak(str,zak,zaktext)
                {
         ukazZak.innerHTML = "Z·kazka: " + zaktext;
         ukazZak.style.display='';
         document.forms.forms1.h_zak.value = zak;
         document.forms.forms1.h_str.value = str;
         myZakelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_hop.value == '' ) document.forms1.h_hop.value = '0';
         document.forms1.h_hop.focus();
         document.forms1.h_hop.select();
                }


function Len1Zak(str,zak)
              {
         document.forms.forms1.h_zak.value = zak;
         document.forms.forms1.h_str.value = str;
         myZakelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_hop.value == '' ) document.forms1.h_hop.value = '0';
         document.forms1.h_hop.focus();
         document.forms1.h_hop.select();
              }

function Len0Zak()
                    {
         document.forms1.h_zak.focus();
         document.forms1.h_zak.select();
                    }


function HopEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

              Ulozit();

              }
                }


    function ZhasniSP()
    {
    Fx.style.display="none";
    Ul.style.display="none";
    Zm.style.display="none";
    NiejeUce.style.display="none";
    NiejeIcp.style.display="none";
    NiejeStr.style.display="none";
    NiejeZak.style.display="none";
    NiejeRdp.style.display="none";
    Uce.style.display="none";
    Fak.style.display="none";
    Ico.style.display="none";
    Str.style.display="none";
    Zak.style.display="none";
    Des.style.display="none";
    Rdp.style.display="none";
    }

    function ZhasniPopis()
    {
    jeUcm.style.display="none";
    jeUcd.style.display="none";
    jeIcp.style.display="none";
    jeStr.style.display="none";
    jeZak.style.display="none";
    jeRdp.style.display="none";
    }

//[[[[[[[[[[[[


// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam,errflag) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;

         if (b == "") { err=0 }
         if (Math.floor(b)==b && b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9]/g) != -1) { err=1 }
         if (Math.floor(b)!=b && b != "") { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         <?php
         if ( $copern == 5 OR $copern == 8 ) 
         {?>
         errflag.value = "0";
         <?php
         }?>
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
//         document.forms1.uloz.disabled = true;
         errflag.value = "1";
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


// Kontrola des.cisla celeho v rozsahu x az y  
      function cele(x1,x,y,Oznam,des,errflag) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;
       var c;
       var d;
       var cele;
       var pocdes;
       cele=0;
       pocdes=0;
       c=b.toString();
       d=c.split('.');
       if ( isNaN(d[1]) ) { cele=1; }
       if ( cele == 0 ) { pocdes=d[1].length; }

         if (b == "") { err=0 }
         if (b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9.-]/g) != -1) { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }
         if (cele == 0 && pocdes > des ) { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         <?php
         if ( $copern == 5 OR $copern == 8 ) 
         {?>
         errflag.value = "0";
         <?php
         }?>
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
//         document.forms1.uloz.disabled = true;
         errflag.value = "1";
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
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


    function OnloadCelkom()
    {
    <?php if( $drupoh == 1 ) echo "document.forms1.h_ucm.value = '".$uce."';"; ?>
    <?php if( $drupoh == 2 ) echo "document.forms1.h_ucd.value = '".$uce."';"; ?>
    var zost = <?php echo $ZOST; ?>;
    var zost2 = zost.toFixed(2);
    document.forms.forms1.h_hop.value = zost2;
    }

<?php if( $tlacitkoenter == 1 ) {  ?>

    function ukaztlacitkoEnter()
    { 
    tlacitkoEnter.style.display='';
    }

    function zhasni_Enter()
    { 
    tlacitkoEnter.style.display='none';
    }

    function tlacitko_Enter()
    { 

    <?php if( $copern == 1 ) {  ?>
    document.forms.forms1.klikenter.value=1;
    if( document.forms.forms1.kdefoc.value == 'ucm' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; UcmEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'ucd' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; UcdEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'rdp' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; RdpEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'fak' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; FakEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'ico' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; IcpEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'str' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; StrEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'zak' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; ZakEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'hop' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; HopEnter(13); }
    <?php                    }  ?>
    }


<?php                           }  ?> 

    <?php if( $copern == 1 ) {  ?>
    function onUcm()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'ucm';"; } ?>  }
    function onUcd()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'ucd';"; } ?>  }
    function onRdp()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'rdp';"; } ?>  }
    function onFak()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'fak';"; } ?>  }
    function onIcp()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'ico';"; } ?>  }
    function onStr()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'str';"; } ?>  }
    function onZak()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'zak';"; } ?>  }
    function onHop()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'hop';"; } ?>  }
    function onPop()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'pop';"; } ?>  }
    <?php                    }  ?>


function TovarDok()
                {
        window.open('faktovdph.php?copern=1&cislo_dok=<?php echo $cislo_dok;?>&drupoh=<?php echo $drupoh;?>', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes'); 
                }

function OverIcdph()
                {
        window.open('http://ec.europa.eu/taxation_customs/vies/', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes'); 
                }

  function roznizalohu()
  { 
  zalohadiv.style.display='';
  myZaloha = document.getElementById("zalohadiv");
        document.forms.zaloha.h_dkz.focus();
        document.forms.zaloha.h_dkz.select();
  }

  function zhasnizalohu()
  { 
  zalohadiv.style.display='none';
  }

  function ulozzalohux()
  {
  var dkz = document.forms.zaloha.h_dkz.value;
  var ucz = document.forms.zaloha.h_ucz.value;
  var clz = document.forms.zaloha.h_clz.value;
  var dpz = document.forms.zaloha.h_dpz.value;
 
  UlozZalohu(<?php echo $drupoh; ?>,1,<?php echo $cislo_dok; ?>,dkz,ucz,clz,dpz);
  }

  function najdizalohux()
  {
  var dkz = document.forms.zaloha.h_dkz.value;
  var ucz = document.forms.zaloha.h_ucz.value;
  var clz = document.forms.zaloha.h_clz.value;
  var dpz = document.forms.zaloha.h_dpz.value;
 
  UlozZalohu(<?php echo $drupoh; ?>,2,<?php echo $cislo_dok; ?>,dkz,ucz,clz,dpz);
  }

  function UhradyDok()
                {
        window.open('fakuhrdph.php?copern=1&cislo_dok=<?php echo $cislo_dok;?>&drupoh=<?php echo $drupoh;?>', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes'); 
                }

</script>
</HEAD>
<BODY class="white" id="white" onload="VypisRozuct(<?php echo $drupoh; ?>,0,<?php echo $cislo_dok; ?>); OnloadCelkom();
<?php if( $tlacitkoenter == 1 ) { echo " ukaztlacitkoEnter(); "; } ?>
">

<?php if( $tlacitkoenter == 1 ) {  ?>

<div id="tlacitkoEnter" style="cursor: hand; display: none; position: absolute; z-index: 400; top: 10; left: 730; width:80; height:25;">
<img border=0 src='../obr/tlacitka/enter.jpg' style='width:50; height:20;' onClick="tlacitko_Enter();"
 title='tlaËÌtko Enter' >
<img border=+ src='../obr/zmazuplne.png' style='width:15; height:15;' onClick="zhasni_Enter();"
 title='zhasn˙ù Enter' >
</div>

<?php                           }  ?>

<?php
//VYPIS POLOZIEK  ROZUCTOVANIA

if( $rozuct == 'ANO' )
{

//ak neexistuje uctosnova2 tak ju vytvor
$sql = "SELECT * FROM F$kli_vxcf"."_uctosnova2";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = <<<uctosnova2
(
   uce2        INT(10),
   nuc2        VARCHAR(40)
);
uctosnova2;
$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctosnova2'.$sqlt;
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctosnova2 ".
"SELECT uce,nuc ".
"FROM F$kli_vxcf"."_uctosnova WHERE ( uce > 0 ) ".
"ORDER BY ucc".
"";
$dsql = mysql_query("$dsqlt");
}

$sluztt = "SELECT * FROM F$kli_vxcf"."_$uctfak".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctfak.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_str".
" ON F$kli_vxcf"."_$uctfak.str=F$kli_vxcf"."_str.str".
" LEFT JOIN F$kli_vxcf"."_zak".
" ON F$kli_vxcf"."_$uctfak.zak=F$kli_vxcf"."_zak.zak".
" LEFT JOIN F$kli_vxcf"."_uctdrdp".
" ON F$kli_vxcf"."_$uctfak.rdp=F$kli_vxcf"."_uctdrdp.rdp".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_$uctfak.ucm=F$kli_vxcf"."_uctosnova.uce".
" LEFT JOIN F$kli_vxcf"."_uctosnova2".
" ON F$kli_vxcf"."_$uctfak.ucd=F$kli_vxcf"."_uctosnova2.uce2".
" WHERE F$kli_vxcf"."_$uctfak.dok = $cislo_dok ".
" ORDER BY cpl";
}

//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);
?>

<?php
$fmenu="fmenz";
$pvstup="pvstuz";
$hvstup="hvstuz";
$cotoje="Roz˙Ëtovanie dokladu";
$seldph="DRD";
$UCM="M·Daù";
$UCD="Dal";
if( $kli_vduj == 9 )
  {
$UCM="ODB";
$UCD="POH";
if( $drupoh == 2 ) { $UCM="POH"; $UCD="DOD"; }
  }
?>

<div id="myUcmelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myUcdelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myFakelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myIcpelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myStrelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myZakelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myRdpelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>

<span id="Uce" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo ˙Ëtu musÌ byù celÈ kladnÈ ËÌslo v rozsahu 0 aû 9999999</span>
<span id="Des" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù desatinnÈ ËÌslo v rozsahu 0.01 aû 99999999 max. 2 desatinnÈ miesta</span>
<span id="Fak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo fakt˙ry musÌ byù celÈ ËÌslo v rozsahu 1 aû 9999999999</span>
<span id="Ico" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 I»O musÌ byù celÈ ËÌslo v rozsahu 1 aû 9999999999</span>
<span id="Str" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo strediska musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99999</span>
<span id="Zak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo z·kazky musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99999999</span>
<span id="Rdp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Druh DPH musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte spr·vne vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka spr·vne uloûen·</span>
<span id="Zm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka CPL=<?php echo $h_cpl;?>  zmazan·</span>
<span id="Nen" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:lime; color:black;">
 Nenaöiel som v ËÌselnÌku , pre voæn˝ vstup zadajte UCM=0</span>
<span id="NiejeUce" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som ˙Ëet v ËÌselnÌku </span>
<span id="NiejeIcp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som I»O v ËÌselnÌku </span>
<span id="NiejeStr" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som stredisko v ËÌselnÌku </span>
<span id="NiejeZak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som z·kazku v ËÌselnÌku </span>
<span id="NiejeRdp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som druh v ËÌselnÌku </span>

<div id="myDivElement"></div>

<table class="<?php echo $fmenu; ?>" width="100%" >
<tr>
<td class="<?php echo $pvstup ?>" colspan="5">

<?php
$sqldokttt = "SELECT * FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE dok = $cislo_dok ";

$sqldok = mysql_query("$sqldokttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $icox=$riaddok->ico;
  $naix=$riaddok->nai;
  $mesx=$riaddok->mes;
  $fakx=$riaddok->fak;
  $houx=$riaddok->hod;
  $icd=$riaddok->icd;
  }
?>
Doklad Ë.<?php echo $cislo_dok ?>, I»O <?php echo $icox ?> <?php echo $naix ?>, <?php echo $mesx ?>, Fakt˙ra <?php echo $fakx ?>, Hodnota=<?php echo $houx ?>
</td>
<td class="<?php echo $pvstup ?>" colspan="3">
Skontrolujte si spr·vne nahratÈ I» DPH = <?php echo $icd ?> <a href="#" onclick="OverIcdph();" >Overovanie I» DPH</a>
</td>
<td class="<?php echo $pvstup ?>" colspan="2">

</td>
</tr>
<tr>
<td class="<?php echo $pvstup ?>" width="7%">Por.ËÌslo
<td class="<?php echo $pvstup ?>" width="11%"><?php echo $UCM; ?>
<td class="<?php echo $pvstup ?>" width="11%"><?php echo $UCD; ?><td class="<?php echo $pvstup ?>" width="11%"><?php echo $seldph; ?>
<td class="<?php echo $pvstup ?>" width="11%" align="right">FAK<td class="<?php echo $pvstup ?>" width="11%" align="right">I»O
<td class="<?php echo $pvstup ?>" width="11%" align="right">STR
<td class="<?php echo $pvstup ?>" width="11%" align="right">Z¡K<td class="<?php echo $pvstup ?>" width="11%" align="right">Hodnota
<td class="<?php echo $pvstup ?>" width="5%">Zmaû
</tr>
</table>
<div id="divNahrate"></div>
<div id="divIns"></div>
<div id="divDel"></div>
<table class="<?php echo $fmenu; ?>" width="100%" >
<tr>
<FORM name="forms1" class="obyc" method="post" action="#" >
<td class="fmenu"  width="7%">
<input type="text" name="h_cpl" id="h_cpl" size="5" />
</td>

<td class="fmenu" width="11%">
<a href="#" onClick="myUcmelement.style.display=''; volajUcm(<?php echo $slpol;?>,11);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 title="Hæadaù ˙Ëet" ></a>
<input type="text" name="h_ucm" id="h_ucm" size="7" 
 onfocus="return UcmOnfocus(event.which); onUcm();"
 onchange="return intg(this,0,999999,Uce,document.forms1.err_ucm)"
 onclick="ZhasniSP(); "
 onkeyup="KontrolaCisla(this, Uce)" onKeyDown="return UcmEnter(event.which)"/>
<INPUT type="hidden" name="err_ucm" value="0"></td>

<td class="fmenu" width="11%">
<a href="#" onClick="myUcdelement.style.display=''; volajUcd(<?php echo $slpol;?>,11);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 title="Hæadaù ˙Ëet" ></a>
<input type="text" name="h_ucd" id="h_ucd" size="7" 
 onchange="return intg(this,0,999999,Uce,document.forms1.err_ucd)"
 onclick="ZhasniSP(); " onfocus="onUcd();"
 onkeyup="KontrolaCisla(this, Uce)" onKeyDown="return UcdEnter(event.which)"/>
<INPUT type="hidden" name="err_ucm" value="0"></td>

<td class="fmenu" width="11%">
<a href="#" onClick="myRdpelement.style.display=''; volajRdp(<?php echo $slpol;?>,11);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 title="Hæadaù druh dokladu" ></a>
<input type="text" name="h_rdp" id="h_rdp" size="3" 
 onclick="ZhasniSP();" onfocus="onRdp();"
 onKeyDown="return RdpEnter(event.which)"/>
</td>

<td class="fmenu" align="right" width="11%">
<input type="text" name="h_fak" id="h_fak" size="10" 
 onclick="ZhasniSP();" onfocus="onFak();"
 onchange="return intg(this,0,9999999999,Fak,document.forms1.err_fak)"
 onkeyup="KontrolaCisla(this, Fak)" onKeyDown="return FakEnter(event.which)"/>
<INPUT type="hidden" name="err_fak" value="0"></td>

<td class="fmenu" align="right" width="11%">
<a href="#" onClick="myIcpelement.style.display=''; volajIcp(<?php echo $slpol;?>,11);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 title="Hæadaù I»O" ></a>
<input type="text" name="h_ico" id="h_ico" size="7" 
 onclick="ZhasniSP();" onfocus="onIcp();"
 onKeyDown="return IcpEnter(event.which)"/>
</td>

<td class="fmenu" align="right" width="11%">
<a href="#" onClick="myStrelement.style.display=''; volajStr(<?php echo $slpol;?>,11);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 title="Hæadaù stredisko" ></a>
<input type="text" name="h_str" id="h_str" size="7" 
 onclick="ZhasniSP();" onfocus="onStr();"
 onchange="return intg(this,0,9999,Str,document.forms1.err_str)"
 onkeyup="KontrolaCisla(this, Str)" onKeyDown="return StrEnter(event.which)"/>
<INPUT type="hidden" name="err_str" value="0"></td>

<td class="fmenu" align="right" width="11%">
<a href="#" onClick="myZakelement.style.display=''; volajZak(<?php echo $slpol;?>,11);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 title="Hæadaù z·kazku" ></a>
<input type="text" name="h_zak" id="h_zak" size="7" 
 onclick="ZhasniSP();" onfocus="onZak();"
 onchange="return intg(this,0,9999999,Zak,document.forms1.err_zak)"
 onkeyup="KontrolaCisla(this, Zak)" onKeyDown="return ZakEnter(event.which)"/>
<INPUT type="hidden" name="err_zak" value="0"></td>

<td class="fmenu" align="right" width="11%"><input type="text" name="h_hop" id="h_hop" size="10" 
 onclick="ZhasniSP();" onfocus="onHop();"
 onchange="return cele(this,-99999999,99999999,Des,2,document.forms1.err_hop)" 
 onkeyup="KontrolaDcisla(this, Des)" onKeyDown="return HopEnter(event.which)" />
<INPUT type="hidden" name="err_hop" >


<td class="fmenu" width="5%"><input type="text" name="h_ne1" id="h_ne1" size="3" /></td>
<input type="hidden" name="h_dok" id="h_dok" value="<?php echo $cislo_dok;?>" />
<input type="hidden" name="h_uce" id="h_uce" value="<?php echo $h_uce;?>" />
<input type="hidden" name="h_unk" id="h_unk" value="<?php echo $h_unk;?>" />
<input type="hidden" name="h_poh" id="h_poh" value="<?php echo $h_poh;?>" />
<input type="hidden" name="slpol" id="slpol" value="<?php echo $slpol;?>" />

<input class="hvstup" type="hidden" name="kdefoc" id="kdefoc" value="ucm" />
<input class="hvstup" type="hidden" name="klikenter" id="klikenter" value="0" />

</tr>
</table>
<div id="jeUcm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeUcd" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeRdp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeIcp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeStr" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeZak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>



    <table class="vstup" width="100%">
     <tr> 

<?php if( $_SESSION['nieie'] == 0 )  { ?>

       <td width="10%" align="left">
<button id="uloz" onclick="Ulozit(); ">Uloûiù</button>
       </td>
       <td width="10%" align="left">
<button id="minul" onclick="return Minul();"><img src='../obr/prev.png' border="0" width="15" height="15" title="Roz˙Ëtovaù doklad <?php echo $prev_dok;?>" ></button>
<button id="dalsi" onclick="return Dalsi();"><img src='../obr/next.png' border="0" width="15" height="15" title="Roz˙Ëtovaù doklad <?php echo $next_dok;?>" ></button>
       </td>
       <td width="10%" align="left">
<button id="zozfak" onclick="return NovyDoklad();"><img src='../obr/vlozit.png' border="0" title="Nov˝ doklad" ></button>
       </td>
       <td width="10%" align="left">
<button id="zozfak" onclick="return GoToZoznam();"><img src='../obr/zoznam.png' border="0" title="Nasp‰ù do zoznamu fakt˙r" ></button>
       </td>
       <td width="10%" align="left">
<?php if( $kli_vrok <  2014 )  { ?>
<button id="zozfak" onclick="return TlacRozuct();"><img src='../obr/tlac.png' border="0" title="TlaË roz˙Ëtovania" ></button>
<?php                          } ?>
<?php if( $kli_vrok >= 2014 )  { ?>
<button id="zozfak" onclick="return TlacRozuctPDF();"><img src='../obr/tlac.png' border="0" title="TlaË roz˙Ëtovania" ></button>
<?php                          } ?>
<button id="zozfak" onclick="return TlacRozuctPDF();"><img src='../obr/pdf.png' border="0" title="TlaË roz˙Ëtovania PDF" ></button>
       </td>
       <td width="10%" align="left">
<button id="zozfak4" onclick="return ZmazUcto();"><img src='../obr/kos.png' border="0" title="Vymazaù celÈ roz˙Ëtovanie dokladu <?php echo $cislo_dok;?>" ></button>
       </td>
       <td width="10%" align="left">
<button id="zozfak5" onclick="return KopyDok();"><img src='../obr/orig.png' border="0" title="KÛpia dokladu <?php echo $cislo_dok;?>" ></button>
       </td>
       <td width="10%" align="left">
<img src='../obr/export.png' border="1" onclick="TovarDok();" width="15" height="15" title="⁄daje o tovare na doklade <?php echo $cislo_dok;?>" >
&nbsp;&nbsp;&nbsp;
<img src='../obr/import.png' border="1" onclick="roznizalohu();" width="15" height="15" title="Od˙Ëtovanie z·lohy" >
<?php if( $fir_xvr05 == 1 ) { ?>
&nbsp;&nbsp;&nbsp;
<img src='../obr/vlozit.png' border="1" onclick="UhradyDok();" width="15" height="15" title="⁄hrady pre odpoËet a odvod DPH z fakt˙r" >
<?php                      } ?>
       </td>
<?php                                 } ?>
<?php if( $_SESSION['nieie'] == 1 )  { ?>

       <td width="10%" align="left">
<img src='../obr/tlacitka/ulozit.jpg' style='width:65; height:22;' border="1" onclick="Ulozit();"  title="Uloûiù" >
       </td>
       <td width="10%" align="left">
<img src='../obr/prev.png' border="1" onclick="Minul();" width="15" height="15" title="Roz˙Ëtovaù doklad <?php echo $prev_dok;?>" >
<img src='../obr/next.png' border="1" onclick="Dalsi();" width="15" height="15" title="Roz˙Ëtovaù doklad <?php echo $next_dok;?>" >
       </td>
       <td width="10%" align="left">
<img src='../obr/vlozit.png' border="1" onclick="NovyDoklad();" width="15" height="15" title="Nov˝ doklad" >
       </td>
       <td width="10%" align="left">
<img src='../obr/zoznam.png' border="1" onclick="GoToZoznam();" width="15" height="15" title="Nasp‰ù do zoznamu fakt˙r" >
       </td>
       <td width="10%" align="left">
<img src='../obr/pdf.png' border="1" onclick="TlacRozuctPDF();" width="15" height="15" title="TlaË roz˙Ëtovania PDF" >
       </td>
       <td width="10%" align="left">
<img src='../obr/kos.png' border="1" onclick="ZmazUcto();" width="15" height="15" title="Vymazaù celÈ roz˙Ëtovanie dokladu <?php echo $cislo_dok;?>" >
       </td>
       <td width="10%" align="left">
<img src='../obr/orig.png' border="1" onclick="KopyDok();" width="15" height="15" title="KÛpia dokladu <?php echo $cislo_dok;?>" >
       </td>
       <td width="10%" align="left">
<img src='../obr/export.png' border="1" onclick="TovarDok();" width="15" height="15" title="⁄daje o dodanom tovare na doklade <?php echo $cislo_dok;?>" >
&nbsp;&nbsp;&nbsp;
<img src='../obr/import.png' border="1" onclick="roznizalohu();" width="15" height="15" title="Od˙Ëtovanie z·lohy" >
<?php if( $fir_xvr05 == 1 ) { ?>
&nbsp;&nbsp;&nbsp;
<img src='../obr/vlozit.png' border="1" onclick="UhradyDok();" width="15" height="15" title="⁄hrady pre odpoËet a odvod DPH z fakt˙r" >
<?php                      } ?>
       </td>
<?php                                 } ?>

       <td width="40%" align="right">
<div id="celkom" >
</div>

       </td>
</FORM>
      </tr> 
    </table>

<?php
$sql = "SELECT prx6 FROM F$kli_vxcf"."_uctzlhodu$kli_uzid ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{


$sqlt = <<<banvyp
(
   dkz         DECIMAL(10,0) DEFAULT 0,
   ucz1        VARCHAR(20) NOT NULL DEFAULT 32400,
   ucz2        VARCHAR(20) NOT NULL DEFAULT 31400,
   clz         DECIMAL(10,2) DEFAULT 0,
   dpz         DECIMAL(10,2) DEFAULT 0,
   prx6        DECIMAL(4,0) DEFAULT 0
);
banvyp;


$sql = "CREATE TABLE F".$kli_vxcf."_uctzlhodu".$kli_uzid." ".$sqlt;
$vysledek = mysql_query("$sql");

$sql = "INSERT INTO F".$kli_vxcf."_uctzlhodu".$kli_uzid." (dkz) VALUES ( 0 ) ";
$vysledek = mysql_query("$sql");
}

$dkz=0; $ucz=""; $clz=0; $dpz=0;
$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_uctzlhodu$kli_uzid ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $dkz=$riaddok->dkz;
    $ucz=$riaddok->ucz1;
    if( $drupoh == 2 ) { $ucz=$riaddok->ucz2; }
    $clz=1*$riaddok->clz;
    $dpz=1*$riaddok->dpz;
    }

?>


<div id="zalohadiv" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 350; left: 460; width:380; height:100;">

<table  class='ponuka' width='100%'>
<tr>
<td width='80%'>Od˙Ëtovanie z·lohy</td>
<td width='20%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick='zhasnizalohu();' title='Zhasni okno' ></td>
</tr> 

<tr><td>           </td></tr>

<tr><FORM name="zaloha" method='post' action='#' ><td width='100%' class='ponuka' colspan='1'>
<a href="#" title="KliknutÌm n·jdete z·lohov˝ doklad a naËÌtate v˝öku z·lohy a DPH na z·lohe" onClick="najdizalohux(<?php echo $drupoh; ?>,2,<?php echo $cislo_dok; ?>);">
»Ìslo dokladu z·lohovÈho</a>
</td> 
<td class='ponuka' colspan='1'><input type='text' name='h_dkz' id='h_dkz' size='30' maxlenght='30' onkeydown="return DkzEnter(event.which)" onkeyup="CiarkaNaBodku(this);" value='<?php echo $dkz; ?>' > 
</td></tr>

<tr><td class='ponuka' colspan='1'>⁄Ëet z·lohy 31400, 32400...</td> 
<td class='ponuka' colspan='1'><input type='text' name='h_ucz' id='h_ucz' size='30' maxlenght='30' onkeydown="return UczEnter(event.which)" onkeyup="CiarkaNaBodku(this);" value='<?php echo $ucz; ?>' > 
</td></tr>

<tr><td class='ponuka' colspan='1'>Celkov· hodnota z·lohy</td> 
<td class='ponuka' colspan='1'><input type='text' name='h_clz' id='h_clz' size='30' maxlenght='30' onkeydown="return ClzEnter(event.which)" onkeyup="CiarkaNaBodku(this);" value='<?php echo $clz; ?>' > 
</td></tr>


<tr><td class='ponuka' colspan='1'>Hodnota DPH na z·lohe</td>
<td class='ponuka' colspan='1'>
<input type='text' name='h_dpz' id='h_dpz' size='30' maxlenght='30' onkeydown="return DpzEnter(event.which)" onkeyup="CiarkaNaBodku(this);" value='<?php echo $dpz; ?>' > 
</td></tr>

<tr><td>           </td></tr>

<tr>
<td width='100%' class='ponuka' colspan='2'>
<a href="#" title="KliknutÌm od˙Ëtujete z·lohu" onClick="ulozzalohux(<?php echo $drupoh; ?>,1,<?php echo $cislo_dok; ?>);">
Od˙Ëtovaù z·lohu z dokladu Ë.<?php echo $cislo_dok; ?></a>
</td>
</FORM>
</tr>

</table> 
</div> 
<script type="text/javascript">
//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

function DkzEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.zaloha.h_ucz.focus();
        document.forms.zaloha.h_ucz.select();
              }
                }

function UczEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.zaloha.h_clz.focus();
        document.forms.zaloha.h_clz.select();
              }
                }

function ClzEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.zaloha.h_dpz.focus();
        document.forms.zaloha.h_dpz.select();
              }
                }

function DpzEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.zaloha.h_dkz.focus();
        document.forms.zaloha.h_dkz.select();
              }
                }


</script>
<?php
// celkovy koniec dokumentu
$cislista = include("../ucto/uct_lista.php");

?>
<br />
<span id="overicdph" style="display:blok; width:100%; align:center; font-family:bold; font-weight:bold; background-color:white; color:black;">Skontrolujte si spr·vne nahratÈ I» DPH = <?php echo $icd ?></span> &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" title="Pre spr·vne vytvorenie KontrolnÈho v˝kazu DPH je dÙleûitÈ aby ste mali v ËÌselnÌku I»O spr·vne I» DPH !!!" onclick="OverIcdph();" >Overovanie I» DPH</a>
<br />
<br />
<?php

       } while (false);
?>
</BODY>
</HTML>
