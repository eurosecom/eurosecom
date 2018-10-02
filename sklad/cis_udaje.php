<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 2000;
$cslm=404200;
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

$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvskl";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvskl = include("../sklad/vtvskl.php");
endif;

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$uloz="NO";
$zmaz="NO";
$uprav="NO";

$cislo_cis = 1*$_REQUEST['cislo_cis'];
$prepocitajceny = 1*$_REQUEST['prepocitajceny'];

//prepocitaj dalsie ceny
if( $prepocitajceny == 1 )
  {
$prepoc = include("prepoc_ceny.php");
  }
//koniec prepocitaj dalsie ceny

//Tabulka restktgtov
$sql = "SELECT * FROM F$kli_vxcf"."_restktgtov";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "Vytvorit tabulku F$kli_vxcf"."_restktgtov!"."<br />";

$sqlt = <<<restktgtov
(
   cktg         int PRIMARY KEY not null auto_increment,
   nktg         VARCHAR(35) NOT NULL,
   pktg         INT DEFAULT 0,
   oktg         INT DEFAULT 0,
   pr1g         INT DEFAULT 0,
   pr2g         INT DEFAULT 0,
   pr3g         INT DEFAULT 0,
   datm         TIMESTAMP(14)

);
restktgtov;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_restktgtov'.$sqlt;
//echo 'CREATE TABLE F'.$kli_vxcf.'_restktgtov'.$sqlt;

$vysledek = mysql_query("$sql");
if ($vysledek)
      echo "Tabulka F$kli_vxcf"."_restktgtov!"."vytvoren· <br />";

$ttvv = "INSERT INTO F$kli_vxcf"."_restktgtov ( nktg ) VALUES ( 'KategÛria 1'  )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_restktgtov ( nktg ) VALUES ( 'KategÛria 2'  )";
$ttqq = mysql_query("$ttvv");
}

//koniec tabulky restktgtov

//uprava sklcisudaje
$sql = "SELECT cep01 FROM F$kli_vxcf"."_sklcisudaje ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD ced05 DECIMAL(12,4) DEFAULT 0 AFTER xrcx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD cep05 DECIMAL(12,4) DEFAULT 0 AFTER xrcx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD ced04 DECIMAL(12,4) DEFAULT 0 AFTER xrcx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD cep04 DECIMAL(12,4) DEFAULT 0 AFTER xrcx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD ced03 DECIMAL(12,4) DEFAULT 0 AFTER xrcx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD cep03 DECIMAL(12,4) DEFAULT 0 AFTER xrcx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD ced02 DECIMAL(12,4) DEFAULT 0 AFTER xrcx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD cep02 DECIMAL(12,4) DEFAULT 0 AFTER xrcx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD ced01 DECIMAL(12,4) DEFAULT 0 AFTER xrcx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD cep01 DECIMAL(12,4) DEFAULT 0 AFTER xrcx";
$vysledek = mysql_query("$sql");

}
$sql = "SELECT cxc01 FROM F$kli_vxcf"."_sklcisudaje ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD cxc05 DECIMAL(12,4) DEFAULT 0 AFTER xrcx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD cxc04 DECIMAL(12,4) DEFAULT 0 AFTER xrcx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD cxc03 DECIMAL(12,4) DEFAULT 0 AFTER xrcx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD cxc02 DECIMAL(12,4) DEFAULT 0 AFTER xrcx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD cxc01 DECIMAL(12,4) DEFAULT 0 AFTER xrcx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT idod FROM F$kli_vxcf"."_sklcisudaje ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje MODIFY xdr2 DECIMAL(6,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD pdod DECIMAL(12,4) DEFAULT 0 AFTER ced05";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD idod DECIMAL(10,0) DEFAULT 0 AFTER ced05";
$vysledek = mysql_query("$sql");
}

//koniec uprava tabulka sklcisudaje

//uprava 8 a 18
if ( $copern == 18 )
  {
$h_dph = strip_tags($_REQUEST['h_dph']);
$h_cis = strip_tags($_REQUEST['h_cis']);
$h_nat = strip_tags($_REQUEST['h_nat']);
$h_cep = strip_tags($_REQUEST['h_cep']);
$h_ced = strip_tags($_REQUEST['h_ced']);
$h_mer = strip_tags($_REQUEST['h_mer']);
$h_tl1 = strip_tags($_REQUEST['h_tl1']);
$h_tl2 = strip_tags($_REQUEST['h_tl2']);
$h_tl3 = strip_tags($_REQUEST['h_tl3']);


$cxc01 = strip_tags($_REQUEST['cxc01']);
$cxc02 = strip_tags($_REQUEST['cxc02']);

$cep01 = strip_tags($_REQUEST['cep01']);
$ced01 = strip_tags($_REQUEST['ced01']);
$cep02 = strip_tags($_REQUEST['cep02']);
$ced02 = strip_tags($_REQUEST['ced02']);
$cep03 = strip_tags($_REQUEST['cep03']);
$ced03 = strip_tags($_REQUEST['ced03']);
$cep04 = strip_tags($_REQUEST['cep04']);
$ced04 = strip_tags($_REQUEST['ced04']);

$xmerx = strip_tags($_REQUEST['xmerx']);
$xmer2 = strip_tags($_REQUEST['xmer2']);
$xmerk = 1*$_REQUEST['xmerk'];

$xrcp = strip_tags($_REQUEST['xrcp']);
$xrcx = 1*$_REQUEST['xrcx'];

$xzvr = 1*$_REQUEST['xzvr'];
$xkrd = 1*$_REQUEST['xkrd'];
$xzkz = 1*$_REQUEST['xzkz'];
$xstz = 1*$_REQUEST['xstz'];
$xdr1 = 1*$_REQUEST['xdr1'];
$xdr2 = 1*$_REQUEST['xdr2'];
$xdr3 = 1*$_REQUEST['xdr3'];
$xdr4 = 1*$_REQUEST['xdr4'];
$xnat = strip_tags($_REQUEST['xnat']);
$xnat5 = strip_tags($_REQUEST['xnat5']);
$xnat4 = strip_tags($_REQUEST['xnat4']);
$xnat3 = 1*$_REQUEST['xnat3'];
$xtxt5 = $_REQUEST['xtxt5'];
$idod = $_REQUEST['idod'];
$pdod = $_REQUEST['pdod'];

$h_natBD = StrTr($h_nat, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$upravene = mysql_query("UPDATE F$kli_vxcf"."_sklcis SET dph='$h_dph', cis='$h_cis', nat='$h_nat', natBD='$h_natBD',
 cep='$h_cep', ced='$h_ced', mer='$h_mer', tl1='$h_tl1', tl2='$h_tl2', tl3='$h_tl3' WHERE cis='$h_cis'");  

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_sklcisudaje WHERE xcis='$h_cis'"); 
$vlozene = mysql_query("INSERT INTO F$kli_vxcf"."_sklcisudaje (xcis) VALUES ( '$h_cis' )"); 
$upravene = mysql_query("UPDATE F$kli_vxcf"."_sklcisudaje SET xmerx='$xmerx', xmer2='$xmer2', xmerk='$xmerk', xrcx='$xrcx', xrcp='$xrcp' 
, cxc01='$cxc01', cxc02='$cxc02', idod='$idod', pdod='$pdod' 
, cep01='$cep01', ced01='$ced01', cep02='$cep02', ced02='$ced02', cep03='$cep03', ced03='$ced03', cep04='$cep04', ced04='$ced04', xnat3='$xnat3', xtxt5='$xtxt5'
, xzvr='$xzvr', xkrd='$xkrd', xzkz='$xzkz', xstz='$xstz', xdr3='$xdr3', xdr4='$xdr4', xdr2='$xdr2', xdr1='$xdr1', xnat='$xnat', xnat5='$xnat5', xnat4='$xnat4'
 WHERE xcis='$h_cis'"); 

$copern=20;
$cislo_cis=$h_cis;
  }



//nacitaj udaje 
if ( $copern == 20  )
    {


$sqlfir = "SELECT * FROM F$kli_vxcf"."_sklcis WHERE cis = $cislo_cis ";
//echo $sqlfir;

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);


$h_dph = $fir_riadok->dph;
$h_cis = $fir_riadok->cis;
$h_nat = $fir_riadok->nat;
$h_cep = $fir_riadok->cep;
$h_ced = $fir_riadok->ced;
$h_mer = $fir_riadok->mer;
$h_tl1 = $fir_riadok->tl1;
$h_tl2 = $fir_riadok->tl2;
$h_tl3 = $fir_riadok->tl3;

mysql_free_result($fir_vysledok);

$sqlfir = "SELECT * FROM F$kli_vxcf"."_sklcisudaje WHERE xcis = $cislo_cis ";
//echo $sqlfir;

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$xmerx = $fir_riadok->xmerx;
$xmer2 = $fir_riadok->xmer2;
$xmerk = 1*$fir_riadok->xmerk;
$xrcp = $fir_riadok->xrcp;
$xrcx = 1*$fir_riadok->xrcx;

$cxc01 = $fir_riadok->cxc01;
$cxc02 = $fir_riadok->cxc02;

$cep01 = $fir_riadok->cep01;
$ced01 = $fir_riadok->ced01;
$cep02 = $fir_riadok->cep02;
$ced02 = $fir_riadok->ced02;
$cep03 = $fir_riadok->cep03;
$ced03 = $fir_riadok->ced03;
$cep04 = $fir_riadok->cep04;
$ced04 = $fir_riadok->ced04;

$xzvr = 1*$fir_riadok->xzvr;
$xkrd = 1*$fir_riadok->xkrd;
$xzkz = 1*$fir_riadok->xzkz;
$xstz = 1*$fir_riadok->xstz;
$xdr1 = 1*$fir_riadok->xdr1;
$xdr2 = 1*$fir_riadok->xdr2;
$xdr3 = 1*$fir_riadok->xdr3;
$xdr4 = 1*$fir_riadok->xdr4;
$xnat = $fir_riadok->xnat;
$xnat5 = $fir_riadok->xnat5;
$xnat4 = $fir_riadok->xnat4;
$xnat3 = 1*$fir_riadok->xnat3;
$xtxt5 = $fir_riadok->xtxt5;

$idod = $fir_riadok->idod;
$pdod = $fir_riadok->pdod;

mysql_free_result($fir_vysledok);


    }
//koniec nacitania udajov


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Sklad-»ÌselnÌk materi·lu-DoplÚuj˙ce ˙daje</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;

var vyskawic = screen.height;
var sirkawic = screen.width-10;

//posuny Enter[[[[[[[[[[[

function CepEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {

        if( document.forms.formv1.h_dph.value == <?php echo $fir_dph2; ?> ) { dann = 0.<?php echo $fir_dph2; ?>*document.forms.formv1.h_cep.value; }
        if( document.forms.formv1.h_dph.value == <?php echo $fir_dph1; ?> ) { dann = 0.<?php echo $fir_dph1; ?>*document.forms.formv1.h_cep.value; }
        if( document.forms.formv1.h_dph.value == 0 ) { dann = 0; }

        <?php if( $vyb_rok < 2009 ) { echo "danz = dann.toFixed(1);"; } ?>
        <?php if( $vyb_rok > 2008 ) { echo "danz = dann.toFixed(2);"; } ?>

        document.forms.formv1.h_ced.value = (1*danz) + (1*document.forms.formv1.h_cep.value);
        sdphpred =  document.forms.formv1.h_ced.value;
        document.forms.formv1.h_ced.focus();
        document.forms.formv1.h_ced.select();
               }

                }

function CedEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        sdphpo =  document.forms.formv1.h_ced.value;
        sdphrz =  sdphpred - sdphpo;

    if( sdphrz <= 0.03 && sdphrz >= -0.03  )
        {
        if( document.forms.formv1.h_mer.value == "" ) document.forms.formv1.h_mer.value = 'ks';
        document.forms.formv1.h_mer.focus();
        document.forms.formv1.h_mer.select();
        }
    if( sdphrz > 0.03 || sdphrz < -0.03 )
        {
        if( document.forms.formv1.h_dph.value == <?php echo $fir_dph2; ?> ) { bezd = document.forms.formv1.h_ced.value / 1.<?php echo $fir_dph2; ?>; }
        if( document.forms.formv1.h_dph.value == <?php echo $fir_dph1; ?> ) { bezd = document.forms.formv1.h_ced.value / 1.<?php echo $fir_dph1; ?>; }
        if( document.forms.formv1.h_dph.value == 0 ) { bezd = document.forms.formv1.h_ced.value / 1; }

        bezd = bezd.toFixed(2);
        document.forms.formv1.h_cep.value = bezd;
        document.forms.formv1.h_cep.focus();
        document.forms.formv1.h_cep.select();
        }
               }
                 }

function Cep01Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {

        if( document.forms.formv1.h_dph.value == <?php echo $fir_dph2; ?> ) { dann = 0.<?php echo $fir_dph2; ?>*document.forms.formv1.cep01.value; }
        if( document.forms.formv1.h_dph.value == <?php echo $fir_dph1; ?> ) { dann = 0.<?php echo $fir_dph1; ?>*document.forms.formv1.cep01.value; }
        if( document.forms.formv1.h_dph.value == 0 ) { dann = 0; }

        <?php if( $vyb_rok < 2009 ) { echo "danz = dann.toFixed(1);"; } ?>
        <?php if( $vyb_rok > 2008 ) { echo "danz = dann.toFixed(2);"; } ?>

        document.forms.formv1.ced01.value = (1*danz) + (1*document.forms.formv1.cep01.value);
        sdphpred =  document.forms.formv1.ced01.value;
        document.forms.formv1.ced01.focus();
        document.forms.formv1.ced01.select();
               }

                }

function Ced01Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {



        if( document.forms.formv1.h_dph.value == <?php echo $fir_dph2; ?> ) { bezd = document.forms.formv1.ced01.value / 1.<?php echo $fir_dph2; ?>; }
        if( document.forms.formv1.h_dph.value == <?php echo $fir_dph1; ?> ) { bezd = document.forms.formv1.ced01.value / 1.<?php echo $fir_dph1; ?>; }
        if( document.forms.formv1.h_dph.value == 0 ) { bezd = document.forms.formv1.ced01.value / 1; }

        bezd = bezd.toFixed(2);
        document.forms.formv1.cep01.value = bezd;
        document.forms.formv1.cep01.focus();
        document.forms.formv1.cep01.select();

               }
                 }

//koniec posunov Enter

// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (Math.floor(b)==b && b>=x && b<=y) return true; 
         else {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         return false;
              } 
             }
      }

// Kontrola ces.cisla v rozsahu x az y  
      function cele(x1,x,y,Oznam) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (b>=x && b<=y) return true; 
         else {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         return false;
              } 
             }
      }

    function KontrolaDcisla(Vstup, Oznam)
    {
    Vstup.value = Vstup.value.replace ( ',','.' );
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }


<?php
//uprava 
  if ( $copern == 20 )
  { 
?>
    function ObnovUI()
    {


    document.formv1.h_dph.value = '<?php echo "$h_dph";?>';
    document.formv1.h_nat.value = '<?php echo "$h_nat";?>';
    document.formv1.h_cep.value = '<?php echo "$h_cep";?>';
    document.formv1.h_ced.value = '<?php echo "$h_ced";?>';
    document.formv1.h_mer.value = '<?php echo "$h_mer";?>';

    document.formv1.xmer2.value = '<?php echo "$xmer2";?>';
    document.formv1.xmerk.value = '<?php echo "$xmerk";?>';

    document.formv1.xrcp.value = '<?php echo "$xrcp";?>';

    document.formv1.xkrd.value = '<?php echo "$xkrd";?>';
    document.formv1.xzkz.value = '<?php echo "$xzkz";?>';
    document.formv1.xstz.value = '<?php echo "$xstz";?>';
    document.formv1.xdr2.value = '<?php echo "$xdr2";?>';
    document.formv1.xdr3.value = '<?php echo "$xdr3";?>';
    document.formv1.xdr4.value = '<?php echo "$xdr4";?>';

    document.formv1.cxc01.value = '<?php echo "$cxc01";?>';
    document.formv1.cxc02.value = '<?php echo "$cxc02";?>';

    document.formv1.cep01.value = '<?php echo "$cep01";?>';
    document.formv1.ced01.value = '<?php echo "$ced01";?>';
    document.formv1.cep02.value = '<?php echo "$cep02";?>';
    document.formv1.ced02.value = '<?php echo "$ced02";?>';
    document.formv1.cep03.value = '<?php echo "$cep03";?>';
    document.formv1.ced03.value = '<?php echo "$ced03";?>';
    document.formv1.cep04.value = '<?php echo "$cep04";?>';
    document.formv1.ced04.value = '<?php echo "$ced04";?>';

    document.formv1.xnat.value = '<?php echo "$xnat";?>';
    document.formv1.xnat5.value = '<?php echo "$xnat5";?>';
    document.formv1.xnat4.value = '<?php echo "$xnat4";?>';
    document.formv1.xtxt5.value = '<?php echo "$xtxt5";?>';

    document.formv1.idod.value = '<?php echo "$idod";?>';
    document.formv1.pdod.value = '<?php echo "$pdod";?>';

    document.formv1.h_cisx.disabled = true;
    document.formv1.uloz.disabled = true;
    }
<?php
//koniec uprava
  }
?>

    function Povol_uloz()
    {
    var okvstup=1;
    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
 
    }

function ColnySadzobnik()
                {
        window.open('https://intrastat.financnasprava.sk/index.php?page=cs', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes'); 
                }

  </script>
</HEAD>
<BODY class="white" onload="ObnovUI(); " >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Materi·lovÈ a tovarovÈ poloûky - DoplÚuj˙ce ˙daje


</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
// zobrazenie tabulky 
if ( $copern == 20  )
     {
?>

<table class="fmenu" width="100%" >


<tr>
<FORM name="formv1" class="obyc" method="post" action="cis_udaje.php?page=<?php echo $page;?>&copern=18&cislo_cis=$cislo_cis" >
<td class="hmenu" >
<INPUT type="submit" id="uloz" name="uloz" value="Uloûiù ˙pravy" onclick=" " ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" >
<a href='../faktury/cslu_web.php?copern=1&page=1' target="_self">
<img src='../obr/ziarovka.png' width=20 height=15 border=0 title="Vzhæad webstr·nky tovaru"></a>
</td>
</tr>

<tr>
<th class="hmenu">».materi·lu<th class="hmenu">N·zov materi·lu
<th class="hmenu">Sadzba DPH<th class="hmenu">PCena bez DPH<th class="hmenu">PCena s DPH<th class="hmenu">MJ
<th class="hmenu"><img src='../obr/info.png' width=12 height=12 border=0 title="T1 => zaökrtnutÈ bud˙ vo WEB ponuke">
 - T2 - T3
</tr>


<tr>
<span id="Bx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Sadzba DPH musÌ byù celÈ kladnÈ ËÌslo v rozsahu 0 aû 4</span>
<span id="Cx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo materi·lu musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999999999999</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Predajn· cena materi·lu musÌ byù desatinnÈ ËÌslo v rozsahu 0 aû 99999999</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Predajn· cena materi·lu musÌ byù desatinnÈ ËÌslo v rozsahu 0 aû 99999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka CIS=<?php echo $h_cis;?> spr·vne uloûen·</span>
</tr>

<tr>
<td class="fmenu"><input type="text" name="h_cisx" id="h_cisx" size="15" value="<?php echo $cislo_cis;?>" 
onchange="return intg(this,1,9999999999999,Cx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Cx)" />
<input type="hidden" name="h_cis" id="h_cis" value="<?php echo $cislo_cis;?>" />

<td class="fmenu"><input type="text" name="h_nat" id="h_nat" size="40" maxlength="40" onKeyDown=" "
onclick="Fx.style.display='none';" /></td>

<td class="fmenu">
<select size="1" name="h_dph" id="h_dph" onmouseover="Fx.style.display='none';" onKeyDown=" " >
<option value="<?php echo $fir_dph2;?>" >DPH Ë.2=<?php echo $fir_dph2;?>%</option>
<option value="<?php echo $fir_dph1;?>" >DPH Ë.1=<?php echo $fir_dph1;?>%</option>
<option value="00" >DPH     00%</option>
<option value="<?php echo $fir_dph3;?>" >DPH Ë.3=<?php echo $fir_dph3;?>%</option>
<option value="<?php echo $fir_dph4;?>" >DPH Ë.4=<?php echo $fir_dph4;?>%</option>
</td>

<td class="fmenu"><input type="text" name="h_cep" id="h_cep" size="12" onKeyDown="return CepEnter(event.which)"
onchange="return cele(this,0,99999999,Dx)" onclick="Fx.style.display='none';" onkeyup="KontrolaDcisla(this, Dx)" />

<td class="fmenu"><input type="text" name="h_ced" id="h_ced" size="12" onKeyDown="return CedEnter(event.which)"
onchange="return cele(this,0,99999999,Ex)" onclick="Fx.style.display='none';" onkeyup="KontrolaDcisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_mer" id="h_mer" size="3" onClick=" " onKeyDown=" " />

<td class="fmenu"><input type="checkbox" name="h_tl1" value="1"/> 
 <input type="checkbox" name="h_tl2" value="1"/> 
 <input type="checkbox" name="h_tl3" value="1"/></td>

<?php
if ( $h_tl1 == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_tl1.checked = "checked";
</script>
<?php
   }
?>
<?php
if ( $h_tl2 == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_tl2.checked = "checked";
</script>
<?php
   }
?>
<?php
if ( $h_tl3 == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_tl3.checked = "checked";
</script>
<?php
   }
?>



</tr>

<tr><td class="hmenu" colspan="7"> </td></tr>
<tr>
<td class="hmenu" colspan="2"> 
Obr·zky 
<a href='../faktury/vstf_s.php?copern=131&drupoh=1&page=1&cislo_dok=<?php echo $cislo_cis;?>' target="_blank"><img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie obr·zku A do datab·zy" ></a>
<a href='../faktury/vstf_s.php?copern=132&drupoh=1&page=1&cislo_dok=<?php echo $cislo_cis;?>' target="_blank"><img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie obr·zku B do datab·zy" ></a>
<a href='../faktury/vstf_s.php?copern=133&drupoh=1&page=1&cislo_dok=<?php echo $cislo_cis;?>' target="_blank"><img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie obr·zku C do datab·zy" ></a>
<a href='../faktury/vstf_s.php?copern=134&drupoh=1&page=1&cislo_dok=<?php echo $cislo_cis;?>' target="_blank"><img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie obr·zku D do datab·zy" ></a>

</td>

<td class="hmenu" colspan="2"> 
WEB  
<a href='../faktury/cslu_web.php?copern=11&page=<?php echo $page;?>&cislo_slu=<?php echo $cislo_cis;?>&ponuka=3' target="_self">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="DoplÚuj˙ce inform·cie na WEB str·nku"></a>

</tr>



<tr>
<td class="hmenu" colspan="6" >2.mern· jednotka <input type="checkbox" name="xmerx" value="1"/>
<?php
if ( $xmerx == 1 )
   {
?>
<script type="text/javascript">
document.formv1.xmerx.checked = "checked";
</script>
<?php
   }
?>

 2.MJ popis <input type="text" name="xmer2" id="xmer2" size="3" maxlength="3" onKeyDown=" "
onclick="Fx.style.display='none';" />

 1.MJ/2.MJ <input type="text" name="xmerk" id="xmerk" size="12" 
onchange="return cele(this,0,99999999,Dx)" onclick="Fx.style.display='none';" onkeyup="KontrolaDcisla(this, Dx)" />
 ak nie je prepoËÌtacÌ vzùah ( napr. kusy a kilogramy ) zadajte nulu

</tr>

<tr>
<td class="hmenu" colspan="6" >Poloûka s receptom <input type="checkbox" name="xrcx" value="1"/>
<?php
if ( $xrcx == 1 )
   {
?>
<script type="text/javascript">
document.formv1.xrcx.checked = "checked";
</script>
<?php
   }
?>

 ».kuchyne <input type="text" name="xdr3" id="xdr3" size="5" 
onchange="return cele(this,0,99999,Dx)" onclick="Fx.style.display='none';" onkeyup="KontrolaDcisla(this, Dx)" />

 ».receptu <input type="text" name="xrcp" id="xrcp" size="12" onclick="Fx.style.display='none';" />

<a href='../vyroba/recepty.php?copern=1&drupoh=1&page=1' target="_self">
VYR <img src='../obr/zoznam.png' width=20 height=15 border=0 title="»ÌselnÌk receptov V˝roby"></a>

<a href='../kuchyna/cisreceptov.php?copern=1&drupoh=1&page=1' target="_self">
KUCH <img src='../obr/zoznam.png' width=20 height=15 border=0 title="»ÌselnÌk receptov Kuchyne"></a>
</tr>


<tr>
<td class="hmenu" colspan="6" >ZVR <input type="checkbox" name="xzvr" value="1"/>
<?php
if ( $xzvr == 1 )
   {
?>
<script type="text/javascript">
document.formv1.xzvr.checked = "checked";
</script>
<?php
   }
?>

 STZ <input type="text" name="xstz" id="xstz" size="8" maxlength="8" onKeyDown=" "
onclick="Fx.style.display='none';" />

 ZKZ <input type="text" name="xzkz" id="xzkz" size="8" maxlength="8" onKeyDown=" "
onclick="Fx.style.display='none';" />

 Eur/krmd <input type="text" name="xkrd" id="xkrd" size="12" 
onchange="return cele(this,0,99999999,Dx)" onclick="Fx.style.display='none';" onkeyup="KontrolaDcisla(this, Dx)" />
 
 DRZ <input type="text" name="xdr4" id="xdr4" size="12" 
onchange="return cele(this,0,99999999,Dx)" onclick="Fx.style.display='none';" onkeyup="KontrolaDcisla(this, Dx)" />

</tr>

<tr>
<td class="hmenu" colspan="2" >KategÛria z·sob 

<a href='../restauracia/ktgtov.php?copern=1&drupoh=1&page=1&spo=0&pds=0&prvespustenie=1' target="_self">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="»ÌselnÌk kategÛriÌ"></a>

<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_restktgtov WHERE cktg >= 0 ORDER BY cktg");
?>
<select class="hvstup" size="1" name="xdr2" id="xdr2" >
<option value="0" >0 - nezaradenÈ</option>
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["cktg"];?>" >
<?php echo $zaznam["cktg"];?> - <?php echo $zaznam["nktg"];?></option>
<?php endwhile;?>
</select>

<td class="hmenu" colspan="4" >
Minim·lny stav z·sob <input type="text" name="cxc01" id="cxc01" size="13" maxlength="13" onKeyDown=" "
onclick="Fx.style.display='none';" />

</tr>

<tr>
<td class="hmenu" colspan="6" >Alkohol <input type="checkbox" name="xdr1" value="1"/>
<?php
if ( $xdr1 == 1 )
   {
?>
<script type="text/javascript">
document.formv1.xdr1.checked = "checked";
</script>
<?php
   }
?>

 EAN kÛd <input type="text" name="xnat" id="xnat" size="13" maxlength="13" onKeyDown=" "
onclick="Fx.style.display='none';" />

 kÛd CPA <input type="text" name="xnat5" id="xnat5" size="13" maxlength="13" onKeyDown=" "
onclick="Fx.style.display='none';" />
<img src='../obr/info.png' width=15 height=15 border=0 title="»ÌselnÌk kÛdov CPA" onclick="window.open('../majetok/ciselnik_kodov_CPA.pdf', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')" >

 Prod.Num <input type="text" name="xnat4" id="xnat4" size="20" maxlength="20" onKeyDown=" "
onclick="Fx.style.display='none';" />
<img src='../obr/info.png' width=15 height=15 border=0 title="ProduktovÈ ËÌslo dod·vateæa" onclick="" >

 Dod.iËo <input type="text" name="idod" id="idod" size="10" maxlength="10" onKeyDown=" "
onclick="Fx.style.display='none';" />
<?php
$sqldo2 = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $idod ";
$sqldok = mysql_query("$sqldo2");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ico=$riaddok->ico;
  $nai=$riaddok->nai;
  $mes=$riaddok->mes;
  }
?>
<img src='../obr/info.png' width=15 height=15 border=0 title="I»O dod·vateæa <?php echo $ico.' '.$nai.' '.$mes; ?>" onclick="" >

 Dod.cena <input type="text" name="pdod" id="pdod" size="12" maxlength="10" onKeyDown=" "
onclick="Fx.style.display='none';" />
<img src='../obr/info.png' width=15 height=15 border=0 title="Cena bez DPH od dod·vateæa" onclick="" >

Komisia <input type="checkbox" name="xnat3" value="1"/>
<?php
if ( $xnat3 == 1 )
   {
?>
<script type="text/javascript">
document.formv1.xnat3.checked = "checked";
</script>
<?php
   }
?>
</tr>
<tr>
<td class="hmenu" colspan="6" >
Spol.col.sadzobnÌk <input type="text" name="xtxt5" id="xtxt5" size="20" maxlength="20" onKeyDown=" "
onclick="Fx.style.display='none';" />
<img src='../obr/info.png' width=15 height=15 border=0 title="SpoloËn˝ coln˝ sadzobnÌk" onclick="ColnySadzobnik();" >
&nbsp&nbsp V·ha MJ(kg) <input type="text" name="cxc02" id="cxc02" size="13" maxlength="13" onKeyDown=" "
onclick="Fx.style.display='none';" />
</tr>


<tr>
<td class="hmenu" colspan="6" > 
<tr>
<td class="hmenu" colspan="6" >œalöie cennÌky pre tovarov˙ poloûku
<a href='cis_udaje.php?copern=20&cislo_cis=<?php echo $cislo_cis;?>&prepocitajceny=1' target="_self">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="PrepoËÌtaù Ôalöie ceny podæa nastavenÈho vzorca"></a>
<tr>
<td class="hmenu" colspan="2" >
CenaBdph 01 <input type="text" name="cep01" id="cep01" size="13" maxlength="13" onKeyDown="return Cep01Enter(event.which)"
onclick="Fx.style.display='none';" />
CenaSdph 01 <input type="text" name="ced01" id="ced01" size="13" maxlength="13" onKeyDown="return Ced01Enter(event.which)"
onclick="Fx.style.display='none';" />

<td class="hmenu" colspan="3" >
CenaBdph 02 <input type="text" name="cep02" id="cep02" size="13" maxlength="13" onKeyDown=" "
onclick="Fx.style.display='none';" />
CenaSdph 02 <input type="text" name="ced02" id="ced02" size="13" maxlength="13" onKeyDown=" "
onclick="Fx.style.display='none';" />
</tr>

<tr>
<td class="hmenu" colspan="2" >
CenaBdph 03 <input type="text" name="cep03" id="cep03" size="13" maxlength="13" onKeyDown=" "
onclick="Fx.style.display='none';" />
CenaSdph 03 <input type="text" name="ced03" id="ced03" size="13" maxlength="13" onKeyDown=" "
onclick="Fx.style.display='none';" />

<td class="hmenu" colspan="3" >
CenaBdph 04 <input type="text" name="cep04" id="cep04" size="13" maxlength="13" onKeyDown=" "
onclick="Fx.style.display='none';" />
CenaSdph 04 <input type="text" name="ced04" id="ced04" size="13" maxlength="13" onKeyDown=" "
onclick="Fx.style.display='none';" />
</tr>

</FORM>

</table>



<?php
// toto je koniec casti na zobrazenie tabulky a prechody medzi stranami 
     }

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
