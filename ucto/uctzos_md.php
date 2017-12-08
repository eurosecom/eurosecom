<!doctype html>
<html>
<?php
$sys = 'UCT';
$urov = 1000;
$cslm=100020;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;
if(!isset($kli_vduj)) $kli_vduj = 1;

       do
       {

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

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

if( $fir_uctx01 != 2 ) $fir_uctx01=1;

$rozuct = $_REQUEST['rozuct'];
if(!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if(!isset($sysx)) $sysx = 'INE';
if( $sysx == 'UCT' ) $rozuct="ANO";

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$rokdph=$kli_vrok;
if( $kli_vrok <  2012 ) { $rokdph=""; }
if( $kli_vrok == 2013 ) { $rokdph="2013"; }
if( $kli_vrok >  2013 ) { $rokdph="2014"; }

//if( $_SERVER['SERVER_NAME'] == "localhost" ) { $kli_vduj=9; }

if (File_Exists ("../tmp/potvrddph$kli_vmes.$kli_vrok.$kli_uzid.pdf")) { $soubor = unlink("../tmp/potvrddph$kli_vmes.$kli_vrok.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/prizdph$kli_vmes.$kli_vrok.$kli_uzid.pdf")) { $soubor = unlink("../tmp/prizdph$kli_vmes.$kli_vrok.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/penden.$kli_uzid.pdf")) { $soubor = unlink("../tmp/penden.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/poklkni.$kli_uzid.pdf")) { $soubor = unlink("../tmp/poklkni.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/suvaha.$kli_uzid.pdf")) { $soubor = unlink("../tmp/suvaha.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/vykzis.$kli_uzid.pdf")) { $soubor = unlink("../tmp/vykzis.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/uobrat.$kli_uzid.pdf")) { $soubor = unlink("../tmp/uobrat.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/udennik.$kli_uzid.pdf")) { $soubor = unlink("../tmp/udennik.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/hlkniha.$kli_uzid.pdf")) { $soubor = unlink("../tmp/hlkniha.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/zoznam$kli_uzid.pdf")) { $soubor = unlink("../tmp/zoznam$kli_uzid.pdf"); }
if (File_Exists ("../tmp/saldo.$kli_uzid.pdf")) { $soubor = unlink("../tmp/saldo.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/inventura.$kli_uzid.pdf")) { $soubor = unlink("../tmp/inventura.$kli_uzid.pdf"); }

?>
<head>
<meta charset="cp1250">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="../css/material.min.css">
<link rel="stylesheet" href="../css/material_edit.css">
<title>⁄ËtovnÈ zostavy | EuroSecom</title>
<style>
/* layout */
.ui-container {
  max-width: 1160px; /*max-width: 1440px;*/
}
.inline-card {


  /*margin: 10px 0;*/
  /*min-height: 48px;*/
}
.inline-card > .divider-horizontal {
  background-color: rgba(0,0,0,.1);
  height: 1px;
}
.inline-card-content {
  height: 52px;
  padding: 10px 12px;
  overflow: auto;
  background-color: #fff;
  border-radius: 2px;
}
.inline-card-content > :first-child {
  min-width: 72px;
}
.inline-card-content > div:not(.toright) {
  float: left;
}
.card-title {
  padding: 0px 8px;
  font-size: 16px;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  align-items: center;
  height: 32px;
}
.card-title > strong {
  font-weight: 500;
}
.card-title > .select-bg {
  background-color: rgba(0,0,0,.04);
  border-radius: 2px;
  color: rgba(0,0,0,.54);
  margin: 0 4px;
  height: 32px;
  padding: 0 2px 0 4px;
  border: 0;
  font-size: 14px;
}
.card-actions > .mdl-button--icon {
  float: left;
  margin: 0 2px;
}

</style>
</head>
<body onload="VyberVstup();">
<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendens'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendensx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendensy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcudenniks'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcudenniksx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcudenniksy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihas'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihasx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihasy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
?>

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
<header class="mdl-layout__header mdl-layout__header--waterfall ui-header">
  <div class="mdl-layout__header-row ui-header-title-row">
    <ol class="mdl-layout-title ui-header-breadcrumb" style="">
    <li class="breadcrumb-item">
      <a href="#" onclick="Ucto();">⁄ËtovnÌctvo</a>
    </li>
    <li class="breadcrumb-item active">
      <a href="#" id="header_dropdown_menu" class="dropdown">⁄ËtovnÈ zostavy</a>
    </li>
<!-- header dropdown nav menu -->
    <li class="wrap-dropdown-menu">
      <ul for="header_dropdown_menu" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
        <li onclick="UctZostavy();" class="mdl-menu__item active">⁄ËtovnÈ zostavy</li>
        <li onclick="StatVykazy();" class="mdl-menu__item">ätatistickÈ v˝kazy</li>
        <li onclick="DanForms();" class="mdl-menu__item">DaÚovÈ formul·re</li>
      </ul>
    </li>
    </ol><!-- .ui-header-breadcrumb -->
    <div class="mdl-layout-spacer"></div>

<!-- period nav -->
    <div class="clearfix" style="margin-top: 16px;">
      <button type="button" id="month_prev" onclick="navMonth(1);" class="mdl-button mdl-js-button mdl-button--icon toleft">
        <i class="material-icons">navigate_before</i>
      </button>
        <span data-mdl-for="month_prev" class="mdl-tooltip">Prejsù na <?php echo $kli_pume; ?></span>
      <button type="button" id="month_next" onclick="navMonth(2);" class="mdl-button mdl-js-button mdl-button--icon toleft">
        <i class="material-icons">navigate_next</i>
      </button>
        <span data-mdl-for="month_next" class="mdl-tooltip">Prejsù na <?php echo $kli_dume; ?></span>
      <div class="toleft" style="font-size: 16px; line-height: 32px; margin-left: 4px;"><?php echo $kli_vume; ?></div>
    </div>
<!-- login firm + user -->
    <ul class="small-list-absolute" style="top: 0; right: 8px;">
      <li class="mdl-color-text--white"><?php echo "<strong>$kli_vxcf</strong>&nbsp;&nbsp;$kli_nxcf"; ?></li>
      <li title="<?php echo "$kli_uzmeno $kli_uzprie"; ?>"><?php echo $kli_uzid; ?></li>
    </ul>
  </div><!-- .ui-header-title-row -->
</header>
<main class="mdl-layout__content ui-content sticky-footer">
<div class="mdl-grid ui-container">

<!-- legend -->
<div class="mdl-cell mdl-cell--10-col mdl-cell--1-offset-desktop inline-card">
  <ul class="mdl-list toright legend-inline-card-area" style="padding: 0;">
    <li class="mdl-list__item" style="font-size: 11px; min-height: auto; padding: 0;">
      <span class="mdl-list__item-primary-content">
        <i class="material-icons mdl-list__item-icon md-dark md-inactive md-18" style="margin: 0 2px 0 16px; height: 18px;">print</i>Zobraziù v PDF
      </span>
      <span class="mdl-list__item-primary-content">
        <i class="material-icons mdl-list__item-icon md-dark md-inactive md-18" style="margin: 0 2px 0 16px; height: 18px;">arrow_forward</i>Vst˙più
      </span>
    </li>
  </ul>
</div>

<?php
if ( $kli_vduj != 9 )
     {
?>
<!-- obratovka -->
<div class="mdl-cell mdl-cell--10-col mdl-cell--1-offset-desktop">
  <div class="mdl-shadow--2dp inline-card">
    <div class="inline-card-content">
      <div class="card-actions">
        <button type="button" id="obratovka_pdf" onclick="ObratovkaPDF();" class="mdl-button mdl-js-button mdl-button--icon">
          <i class="material-icons md-dark">print</i>
        </button>
          <span data-mdl-for="obratovka_pdf" class="mdl-tooltip">Zobraziù v PDF</span>
      </div>
      <div class="card-title">Obratov· predvaha</div>
      <div class="card-actions toright">
        <button type="button" id="obratovka" onclick="Obratovka();" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
          <i class="material-icons">arrow_forward</i>
        </button>
          <span data-mdl-for="obratovka" class="mdl-tooltip">Vst˙più, n·hæad</span>
      </div>
    </div><!-- .inline-card-content -->
  </div><!-- .inline-card -->
</div><!-- .mdl-cell -->

<!-- hlavna kniha -->
<div class="mdl-cell mdl-cell--10-col mdl-cell--1-offset-desktop">
  <div class="mdl-shadow--2dp inline-card">
    <form name="formhkp1" method="post" action="#" class="inline-card-content">
      <div class="card-actions">
        <button type="button" id="hk_detail_pdf" onclick="HlavnaKnihaPolozkovitaPDF();" class="mdl-button mdl-js-button mdl-button--icon">
          <i class="material-icons md-dark">print</i>
        </button>
          <span data-mdl-for="hk_detail_pdf" class="mdl-tooltip">Zobraziù v PDF</span>
      </div>
      <div class="card-title">
        Hlavn· kniha&nbsp;<strong>poloûkovit·</strong>
<?php if ( $fir_big == 1 ) { ?>
        <select name="h_s200" id="h_s200" size="1" class="select-bg">
          <option value="1">strany 1-150</option>
          <option value="2">strany 150-300</option>
          <option value="3">strany 300-450</option>
          <option value="4">strany 450-600</option>
        </select>
<?php                     } ?>
      </div>
      <div class="card-actions toright">
<?php if ( $fir_big == 0 ) { ?>
        <button type="button" id="hk_detail" onclick="HlavnaKnihaPolozkovita();" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
          <i class="material-icons">arrow_forward</i>
        </button>
          <span data-mdl-for="hk_detail" class="mdl-tooltip">Vst˙più, n·hæad</span>
         <!-- dopyt, spraviù disable pri veæk˝ch a napÌsaù, vzhæadom na veækosù d·t, nie je moûnÈ vst˙più -->
<?php                     } ?>
      </div> <!-- dopyt, daù disable pri veæk˝ch firm·ch a preËo je disable -->

    </form><!-- .inline-card-content -->
    <div class="divider-horizontal">&nbsp;</div>
    <form name="formhk1" method="post" action="#" class="inline-card-content">
      <div class="card-actions">
        <button type="button" id="hk_all_ana_pdf" onclick="HlavnaKnihaSumarnaPDF();" class="mdl-button mdl-js-button mdl-button--icon">
          <i class="material-icons md-dark">print</i>
        </button>
          <span data-mdl-for="hk_all_ana_pdf" class="mdl-tooltip">Za analytickÈ ˙Ëty zobraziù v PDF</span>
        <button type="button" id="hk_all_more" class="mdl-button mdl-js-button mdl-button--icon">
          <i class="material-icons md-dark md-inactive">more_vert</i>
        </button>
          <span data-mdl-for="hk_all_more" class="mdl-tooltip">œalöie moûnosti</span>
      </div>
      <div class="card-title">
        Hlavn· kniha&nbsp;<strong>sum·rna</strong>
        <select name="h_obdp" id="h_obdp" size="1" class="select-bg">
          <option value="1">01.<?php echo $kli_vrok; ?></option>
          <option value="2">02.<?php echo $kli_vrok; ?></option>
          <option value="3">03.<?php echo $kli_vrok; ?></option>
          <option value="4">04.<?php echo $kli_vrok; ?></option>
          <option value="5">05.<?php echo $kli_vrok; ?></option>
          <option value="6">06.<?php echo $kli_vrok; ?></option>
          <option value="7">07.<?php echo $kli_vrok; ?></option>
          <option value="8">08.<?php echo $kli_vrok; ?></option>
          <option value="9">09.<?php echo $kli_vrok; ?></option>
          <option value="10">10.<?php echo $kli_vrok; ?></option>
          <option value="11">11.<?php echo $kli_vrok; ?></option>
          <option value="12">12.<?php echo $kli_vrok; ?></option>
        </select>
        <i class="material-icons md-dark md-inactive">trending_flat</i>
        <select name="h_obdk" id="h_obdk" size="1" class="select-bg">
          <option value="1">01.<?php echo $kli_vrok; ?></option>
          <option value="2">02.<?php echo $kli_vrok; ?></option>
          <option value="3">03.<?php echo $kli_vrok; ?></option>
          <option value="4">04.<?php echo $kli_vrok; ?></option>
          <option value="5">05.<?php echo $kli_vrok; ?></option>
          <option value="6">06.<?php echo $kli_vrok; ?></option>
          <option value="7">07.<?php echo $kli_vrok; ?></option>
          <option value="8">08.<?php echo $kli_vrok; ?></option>
          <option value="9">09.<?php echo $kli_vrok; ?></option>
          <option value="10">10.<?php echo $kli_vrok; ?></option>
          <option value="11">11.<?php echo $kli_vrok; ?></option>
          <option value="12">12.<?php echo $kli_vrok; ?></option>
        </select>
      </div>
      <div class="card-actions toright">
        <button type="button" id="hk_all_ana" onclick="HlavnaKnihaSumarna();" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
          <i class="material-icons">arrow_forward</i>
        </button>
          <span data-mdl-for="hk_all_ana" class="mdl-tooltip">Vst˙più, n·hæad</span>
      </div>

  <ul for="hk_all_more" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
    <li onclick="HlavnaKnihaSumarnaSUPDF();" class="mdl-menu__item"><i class="material-icons">print</i>Za syntetickÈ ˙Ëty zobraziù v PDF</li>
    <li onclick="HlavnaKnihaSumarnaSUAUPDF();" class="mdl-menu__item"><i class="material-icons">print</i>Za syntetickÈ + analytickÈ ˙Ëty zobraziù v PDF</li>
    <li onclick="HlavnaKnihaSumarnaSUAUnazovPDF();" class="mdl-menu__item"><i class="material-icons">print</i>Za syntetickÈ + analytickÈ ˙Ëty s n·zvom ˙Ëtu zobraziù v PDF</li>
  </ul>
    </form><!-- .inline-card-content -->
  </div><!-- .inline-card -->
</div><!-- .mdl-cell -->

<!-- uctovny dennik -->
<div class="mdl-cell mdl-cell--10-col mdl-cell--1-offset-desktop">
  <div class="mdl-shadow--2dp inline-card">
    <div class="inline-card-content">
      <div class="card-actions">
        <button type="button" id="dennik_pdf" onclick="DennikPDF();" class="mdl-button mdl-js-button mdl-button--icon">
          <i class="material-icons md-dark">print</i>
        </button>
          <span data-mdl-for="dennik_pdf" class="mdl-tooltip">Zobraziù v PDF</span>
      </div>
      <div class="card-title">⁄Ëtovn˝ dennÌk</div>
<!-- <?php if( $fir_fico == 36084344 OR $_SERVER['SERVER_NAME'] == "localhost" ) { ?>
<a href="#" onClick="window.open('../ucto/udennik36084344.php?copern=10&drupoh=1&page=1&typ=PDF', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/pdf.png' width=20 height=15 border=0 title='⁄Ëtovn˝ dennÌk STR 5 PRO REGION n. o. DSS Svetluöka' ></a>
<?php                     } ?> dopyt, zruöÌm, uû nepotrebuj˙ -->
      <div class="card-actions toright">
<?php if ( $fir_big == 0 ) { ?>
        <button type="button" id="dennik" onclick="Dennik();" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
          <i class="material-icons">arrow_forward</i>
        </button>
          <span data-mdl-for="dennik" class="mdl-tooltip">Vst˙più, n·hæad</span>
<?php                     } ?>
      </div> <!-- dopyt, daù disable pri veæk˝ch firm·ch a preËo je disable -->
    </div><!-- .inline-card-content -->
  </div><!-- .inline-card -->
</div><!-- .mdl-cell -->

<!-- kniha faktur -->
<div class="mdl-cell mdl-cell--10-col mdl-cell--1-offset-desktop">
  <div class="mdl-shadow--2dp inline-card">
    <form name="formkf1" method="post" action="#" class="inline-card-content">
      <div class="card-actions">
        <button type="button" id="kniha_fak_pdf" onclick="KnihaFakturPDF();" class="mdl-button mdl-js-button mdl-button--icon">
          <i class="material-icons md-dark">print</i>
        </button>
          <span data-mdl-for="kniha_fak_pdf" class="mdl-tooltip">Zobraziù v PDF</span>
      </div>
      <div class="card-title">
        Kniha
        <select name="h_drp" id="h_drp" size="1" style="font-size: inherit; font-weight: 500; border:0; font-family: 'Roboto', 'Arial'; color: inherit; height: 32px; padding-bottom: 1px;">
          <option value="1">odberateæsk˝ch</option>
          <option value="2">dod·vateæsk˝ch</option>
        </select>
        fakt˙r
        <select name="h_obdp" id="h_obdp" size="1" class="select-bg">
          <option value="1">01.<?php echo $kli_vrok; ?></option>
          <option value="2">02.<?php echo $kli_vrok; ?></option>
          <option value="3">03.<?php echo $kli_vrok; ?></option>
          <option value="4">04.<?php echo $kli_vrok; ?></option>
          <option value="5">05.<?php echo $kli_vrok; ?></option>
          <option value="6">06.<?php echo $kli_vrok; ?></option>
          <option value="7">07.<?php echo $kli_vrok; ?></option>
          <option value="8">08.<?php echo $kli_vrok; ?></option>
          <option value="9">09.<?php echo $kli_vrok; ?></option>
          <option value="10">10.<?php echo $kli_vrok; ?></option>
          <option value="11">11.<?php echo $kli_vrok; ?></option>
          <option value="12">12.<?php echo $kli_vrok; ?></option>
        </select>
        <i class="material-icons md-dark md-inactive">trending_flat</i>
        <select name="h_obdk" id="h_obdk" size="1" class="select-bg">
          <option value="1">01.<?php echo $kli_vrok; ?></option>
          <option value="2">02.<?php echo $kli_vrok; ?></option>
          <option value="3">03.<?php echo $kli_vrok; ?></option>
          <option value="4">04.<?php echo $kli_vrok; ?></option>
          <option value="5">05.<?php echo $kli_vrok; ?></option>
          <option value="6">06.<?php echo $kli_vrok; ?></option>
          <option value="7">07.<?php echo $kli_vrok; ?></option>
          <option value="8">08.<?php echo $kli_vrok; ?></option>
          <option value="9">09.<?php echo $kli_vrok; ?></option>
          <option value="10">10.<?php echo $kli_vrok; ?></option>
          <option value="11">11.<?php echo $kli_vrok; ?></option>
          <option value="12">12.<?php echo $kli_vrok; ?></option>
        </select>
      </div>
    </form><!-- .inline-card-content -->
  </div><!-- .inline-card -->
</div><!-- .mdl-cell -->

<!-- suvaha a vysledovka -->
<div class="mdl-cell mdl-cell--10-col mdl-cell--1-offset-desktop">
  <div class="mdl-shadow--2dp inline-card">
    <div class="inline-card-content">
      <div class="card-actions">
        <button type="button" id="suvaha_pdf" onclick="SuvahaPDF();" class="mdl-button mdl-js-button mdl-button--icon">
          <i class="material-icons md-dark">print</i>
        </button>
          <span data-mdl-for="suvaha_pdf" class="mdl-tooltip">Zobraziù v PDF</span>
        <button type="button" id="suvaha_more" class="mdl-button mdl-js-button mdl-button--icon">
          <i class="material-icons md-dark md-inactive">more_vert</i>
        </button>
          <span data-mdl-for="suvaha_more" class="mdl-tooltip">œalöie moûnosti zobrazenia</span>
      </div>
      <div class="card-title">S˙vaha jednoduch·</div>
<ul for="suvaha_more" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
  <li onclick="SuvahaSUPDF();" class="mdl-menu__item"><i class="material-icons">print</i>Za syntetickÈ ˙Ëty zobraziù v PDF</li>
  <li onclick="SuvahaMesPDF();" class="mdl-menu__item"><i class="material-icons">print</i>MesaËn˝ prehæad s˙vahov˝ch ˙Ëtov beûnÈho roka zobraziù v pdf</li>
  <li onclick="SuvahaMesTextPDF();" class="mdl-menu__item"><i class="material-icons">print</i>MesaËn˝ prehæad s˙vahov˝ch ˙Ëtov beûnÈho roka aj s n·zvom ˙Ëtu zobraziù v PDF</li>
  <li onclick="SuvahaRokPDF();" class="mdl-menu__item"><i class="material-icons">print</i>MedziroËn˝ prehæad s˙vahov˝ch ˙Ëtov zobraziù v PDF</li>
  <li onclick="SuvahaRokTextPDF();" class="mdl-menu__item"><i class="material-icons">print</i>MedziroËn˝ prehæad s˙vahov˝ch ˙Ëtov aj s n·zvom ˙Ëtu zobraziù v PDF</li>
</ul>
    </div><!-- .inline-card-content -->
    <div class="divider-horizontal">&nbsp;</div>
    <form name="formvm1" method="post" action="#" class="inline-card-content">
      <div class="card-actions">
        <button type="button" id="vysledovka_pdf" onclick="VysledovkaPDF();" class="mdl-button mdl-js-button mdl-button--icon">
          <i class="material-icons md-dark">print</i>
        </button>
          <span data-mdl-for="vysledovka_pdf" class="mdl-tooltip">Zobraziù v PDF</span>
        <button type="button" id="vysledovka_more" class="mdl-button mdl-js-button mdl-button--icon">
          <i class="material-icons md-dark md-inactive">more_vert</i>
        </button>
          <span data-mdl-for="vysledovka_more" class="mdl-tooltip">œalöie moûnosti zobrazenia</span>
      </div>
      <div class="card-title">
        V˝sledovka jednoduch·
        <select name="h_obdp" id="h_obdp" size="1" class="select-bg">
<?php if ( $kli_vmes >= 1 ) { echo "<option value='1'>01.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes >= 2 ) { echo "<option value='2'>02.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes >= 3 ) { echo "<option value='3'>03.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes >= 4 ) { echo "<option value='4'>04.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes >= 5 ) { echo "<option value='5'>05.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes >= 6 ) { echo "<option value='6'>06.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes >= 7 ) { echo "<option value='7'>07.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes >= 8 ) { echo "<option value='8'>08.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes >= 9 ) { echo "<option value='9'>09.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes >= 10 ) { echo "<option value='10'>od 10.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes >= 11 ) { echo "<option value='11'>od 11.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes >= 12 ) { echo "<option value='12'>od 12.$kli_vrok</option>"; } ?>
        </select>
        <i class="material-icons md-dark md-inactive">trending_flat</i>
        <select name="h_obdk" id="h_obdk" size="1" class="select-bg">
<?php if ( $kli_vmes == 1 ) { echo "<option value='1'>01.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes == 2 ) { echo "<option value='2'>02.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes == 3 ) { echo "<option value='3'>03.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes == 4 ) { echo "<option value='4'>04.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes == 5 ) { echo "<option value='5'>05.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes == 6 ) { echo "<option value='6'>06.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes == 7 ) { echo "<option value='7'>07.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes == 8 ) { echo "<option value='8'>08.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes == 9 ) { echo "<option value='9'>09.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes == 10 ) { echo "<option value='10'>do 10.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes == 11 ) { echo "<option value='11'>do 11.$kli_vrok</option>"; } ?>
<?php if ( $kli_vmes == 12 ) { echo "<option value='12'>do 12.$kli_vrok</option>"; } ?>
        </select>
      </div>
    </form><!-- .inline-card-content -->
  </div><!-- .inline-card -->
</div><!-- .mdl-cell -->

<ul for="vysledovka_more" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
  <li onclick="VysledovkaSUPDF();" class="mdl-menu__item"><i class="material-icons">print</i>Za syntetickÈ ˙Ëty zobraziù v PDF</li>
  <li onclick="VysledovkaStrPDF();" class="mdl-menu__item"><i class="material-icons">print</i>Za stredisk· zobraziù v pdf</li>
  <li onclick="VysledovkaZakPDF();" class="mdl-menu__item"><i class="material-icons">print</i>Za z·kazky zobraziù v pdf</li>
  <li onclick="VysledovkaStrZakPDF();" class="mdl-menu__item"><i class="material-icons">print</i>Za stredisk· a z·kazky zobraziù v pdf</li>
  <li onclick="VysledovkaSkuPDF();" class="mdl-menu__item"><i class="material-icons">print</i>Za skupiny zobraziù v pdf</li>
  <li onclick="VysledovkaSkuPDF();" class="mdl-menu__item"><i class="material-icons">print</i>Za stavby zobraziù v pdf</li>
<?php if ( $stavoimpex == 1 OR $_SERVER['SERVER_NAME'] == "localhost" ) { ?>
  <li onclick="window.open('../ucto/vys_stvimpx.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>', '_blank', blank_param);" class="mdl-menu__item"><i class="material-icons">print</i>Za bytovÈ domy zobraziù v pdf</li>
<?php                        } ?> <!-- dopyt, podæa mÚa nevyuûÌvaj˙, ide slepÈ Ërevo -->

  <li onclick="VysledovkaMesPDF();" class="mdl-menu__item"><i class="material-icons">print</i>MesaËn˝ prehæad n·kladov a v˝nosov beûnÈho roka zobraziù v pdf</li>
  <li onclick="VysledovkaMesTextPDF();" class="mdl-menu__item"><i class="material-icons">print</i>MesaËn˝ prehæad n·kladov a v˝nosov beûnÈho roka aj s n·zvom ˙Ëtu zobraziù v PDF</li>
  <li onclick="VysledovkaRokPDF();" class="mdl-menu__item"><i class="material-icons">print</i>MedziroËn˝ prehæad n·kladov a v˝nosov zobraziù v PDF</li>
  <li onclick="VysledovkaRokTextPDF();" class="mdl-menu__item"><i class="material-icons">print</i>MedziroËn˝ prehæad n·kladov a v˝nosov aj s n·zvom ˙Ëtu zobraziù v PDF</li>
</ul>


<?php
if ( $kli_vrok < 2009 )
{
?>
<!-- dopyt, niË som nerobil, ale budem musieù, lebo je neËitateænÈ -->
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/suvaha2008.php?copern=10&drupoh=1&page=1&tis=0&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/suvaha2008.php?copern=10&drupoh=1&page=1&tis=1&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V tisÌcoch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/suvaha2008.php?copern=10&drupoh=1&page=1&tis=1&fort=0&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V tisÌcoch <?php echo $mena1; ?> bez formul·ra - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="90%">S˙vaha ⁄Ë POD 1-01 verzia UVPOD1v07_1</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=22&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vykzis2008.php?copern=10&drupoh=1&page=1&tis=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vykzis2008.php?copern=10&drupoh=1&page=1&tis=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V tisÌcoch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vykzis2008.php?copern=10&drupoh=1&page=1&tis=1&fort=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V tisÌcoch <?php echo $mena1; ?> bez formul·ra - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="90%">V˝kaz ziskov a str·t ⁄Ë POD 2-01 verzia UVPOD2v07_2</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=21&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</table>
<?php
}
//$kli_vrok < 2009
?>

<?php
if ( $kli_vrok >= 2009 AND $kli_vrok <= 2013 )
{
?>
<!-- dopyt, niË som nerobil, ale budem musieù, lebo je neËitateænÈ -->

<?php
//$povelak=""; tymto by urobil zostavu vzor 2008
$povelak="__x";
?>
<script type="text/javascript">

function SUvAHA()
                {
var h_zos = document.forms.formsv1.h_zos.value;
var h_sch = document.forms.formsv1.h_sch.value;

window.open('../ucto/suvaha<?php echo $povelak; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&tis=0&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function SUvAHAEUR()
                {
var h_zos = document.forms.formsv1.h_zos.value;
var h_sch = document.forms.formsv1.h_sch.value;

window.open('../ucto/suvaha<?php echo $povelak; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&tis=1&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }
</script>

<table class="vstup" width="100%" >
<form name="formsv1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="SUvAHA();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="SUvAHAEUR();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<?php $versuv="UVPOD1v09_1"; if( $kli_vrok > 2010 ) $versuv="UVPOD1v11 "; ?>

<td class="bmenu" width="55%">S˙vaha ⁄Ë POD 1-01 ( platn· do 30.12.2014 )

<a href="#" onClick="SynGenSuv();">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title='SyntetickÈ generovanie riadkov s˙vahy' ></a>
</td>
<td class="bmenu" width="35%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?>
 Zostaven·: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Schv·len·: <input type="text" name="h_sch" id="h_sch" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=22&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</form>
</table>

<?php
$povelak="__x";
?>

<script type="text/javascript">

function VYKZIS()
                {
var h_zos = document.forms.formvz1.h_zos.value;
var h_sch = document.forms.formvz1.h_sch.value;

window.open('../ucto/vykzis<?php echo $povelak; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&tis=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function VYKZISEUR()
                {
var h_zos = document.forms.formvz1.h_zos.value;
var h_sch = document.forms.formvz1.h_sch.value;

window.open('../ucto/vykzis<?php echo $povelak; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&tis=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }
</script>

<table class="vstup" width="100%" >
<form name="formvz1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="VYKZIS();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="VYKZISEUR();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="55%">V˝kaz ziskov a str·t ⁄Ë POD 2-01 ( platn˝ do 30.12.2014 )

</td>
<td class="bmenu" width="35%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?>
 Zostaven˝: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Schv·len˝: <input type="text" name="h_sch" id="h_sch" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=21&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</form>
</table>
<?php
}
//$kli_vrok >= 2009 AND $kli_vrok <= 2013
?>


<?php
if ( $kli_nezis == 1 )
     {
?>
<?php
if ( $kli_vrok < 2012 )
{
?>
<!-- dopyt, niË som nerobil, ale budem musieù, lebo je neËitateænÈ -->
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/suvaha_no2011.php?copern=10&drupoh=1&page=1&tis=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/suvaha_no2011.php?copern=10&drupoh=1&page=1&tis=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="92%">S˙vaha ⁄Ë NUJ 1-01 prÌloha Ë.1 k opatreniu Ë. MF/25682/2007-74</td>
<td class="bmenu" width="2%">
<a href="#" onClick="GenSuvNo();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Generovanie riadkov s˙vahy NO' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=32&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vykzis_no2011.php?copern=10&drupoh=1&page=1&tis=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vykzis_no2011.php?copern=10&drupoh=1&page=1&tis=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="94%">V˝sledovka ⁄Ë NUJ 2-01 prÌloha Ë.2 k opatreniu Ë. MF/25682/2007-74</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=31&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</table>
<?php
}
//$kli_vrok < 2012
?>
<?php if ( $kli_vrok >= 2012 AND $kli_vrok < 2015 )
{
?>
<!-- dopyt, niË som nerobil, ale budem musieù, lebo je neËitateænÈ -->
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/suvaha_no.php?copern=10&drupoh=1&page=1&tis=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/suvaha_no.php?copern=10&drupoh=1&page=1&tis=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="92%">S˙vaha ⁄Ë NUJ 1-01 prÌloha Ë.1 k opatreniu Ë. MF/22603/2012-74</td>
<td class="bmenu" width="2%">
<a href="#" onClick="GenSuvNo();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Generovanie riadkov s˙vahy NO' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=32&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vykzis_no.php?copern=10&drupoh=1&page=1&tis=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vykzis_no.php?copern=10&drupoh=1&page=1&tis=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="94%">V˝sledovka ⁄Ë NUJ 2-01 prÌloha Ë.2 k opatreniu Ë. MF/22603/2012-74</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=31&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</table>
<?php
}
//$kli_vrok >= 2012 AND $kli_vrok < 2015
?>
<?php
     }
//$kli_nezis == 1
?>

<?php if ( $kli_vduj != 9 ) { ?>
<!-- <a href="#" onClick="window.open('../analyzy/danovy_csv.php?copern=1&drupoh=1&page=1', '_self' )">
  <img src='../obr/export.png' width=20 height=15 border=0 title='Prejsù do exportu pre D⁄ do CSV' ></a>
<a href="#" onClick="window.open('../analyzy/export_csv.php?copern=1&drupoh=1&page=1', '_self' )">
  <img src='../obr/export.png' width=20 height=15 border=0 title='Prejsù do exportu do CSV' ></a> -->
<?php                     } ?>
<!-- dopyt, ikony urobiù priamo v zostav·ch a buÔ v hlavnom menu, ale lepöie vo vst˙più -->



<!-- dopyt, pÙjde do inej card, tu bude len odkaz, takûe nerobiù niË -->
<table class="vstup" width="100%" style="display: none;">
<form name="formp1" class="obyc" method="post" action="#" >
<tr>
<?php if( $kli_vrok >= 2009 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="PriznanieDPH();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF" ></a>
</td>
<?php if( $kli_vrok <  2011 ) { ?>
<td class="bmenu" width="90%">DaÚovÈ priznanie DaÚ z pridanej hodnoty verzia DPHv10
<?php                        } ?>
<?php if( $kli_vrok == 2011 ) { ?>
<td class="bmenu" width="90%">DaÚovÈ priznanie DaÚ z pridanej hodnoty verzia DPHv11
<?php                        } ?>
<?php if( $kli_vrok >  2011 ) { ?>
<td class="bmenu" width="90%">DaÚovÈ priznanie DaÚ z pridanej hodnoty verzia DPHv12
<?php                        } ?>
<select size="1" name="h_drp" id="h_drp" >
<option value="1" >Riadne</option>
<option value="2" >OpravnÈ</option>
<option value="3" >DodatoËnÈ</option>
</select>
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?>
 D·tum: <input type="text" name="h_dap" id="h_dap" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
<select size="1" name="fir_uctx01" id="fir_uctx01" >
<option value="1" >MesaËnÈ</option>
<option value="2" >ätvrùroËnÈ</option>
<option value="4" >RoËnÈ</option>
</select>
<a href="#" onClick="TlacPotvrdDPH();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù potvrdenie o podanÌ daÚovÈho priznania DPH vo form·te PDF" ></a>
</td>
<td class="bmenu" width="10%">
<select size="1" name="h_arch" id="h_arch" >
<option value="0" >Nearchivovaù</option>
<option value="1" >Archivovaù</option>
</select>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/archivdph<?php echo $rokdph; ?>.php?copern=80&drupoh=1&page=1', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='ArchÌv DaÚov˝ch priznanÌ DPH rok <?php echo $kli_vrok; ?>' ></a>
</td>
<?php                        } ?>

<?php if( $kli_vrok < 2009 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/prizdph_2008.php?copern=10&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="90%">DaÚovÈ priznanie DaÚ z pridanej hodnoty verzia DPHv07_1</td>
<?php                        } ?>
</tr>
</form>
</table>

<table class="vstup" width="100%" style="display: none;">
<form name="formg1" class="obyc" method="post" action="#" >
<tr>
<?php if( $kli_vrok >= 2009 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="TZoznamDPH();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam dokladov po riadkoch DPH vo form·te PDF" ></a>
<td class="bmenu" width="2%">
<a href="#" onClick="ZoznamDPH();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam dokladov po riadkoch DPH vo form·te HTML' ></a>
</td>
</td>
<td class="bmenu" width="54%">DaÚ z pridanej hodnoty - Zoznamy dokladov a chybovÈ hl·senia v.<?php echo $kli_vrok; ?>
<select size="1" name="fir_uctx01" id="fir_uctx01" >
<option value="1" >MesaËn˝</option>
<option value="2" >ätvrùroËn˝</option>
<option value="4" >RoËnÈ</option>
</select>
</td>

<td class="bmenu" align="right" width="8%">
<?php if( $fir_xvr05 != 2 AND $kli_vrok >= 2016 ) { ?>
PRP
<a href="#" onClick="TZoznamDPHPRP();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam prijat˝ch platieb pre uplatnenie DPH vo form·te PDF" ></a>
<?php                                             } ?>
</td>

<td class="bmenu" align="right" width="8%">FKT
<a href="#" onClick="TZoznamDPHFAK();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam dokladov po fakt˙rach vo form·te PDF" ></a>
<a href="#" onClick="ZoznamDPHFAK();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam dokladov po fakt˙rach vo form·te HTML' ></a>
</td>

<td class="bmenu" align="right" width="8%">DOK
<a href="#" onClick="TZoznamDPHDOK();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam dokladov po dokladoch vo form·te PDF" ></a>
<a href="#" onClick="ZoznamDPHDOK();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam dokladov po dokladoch vo form·te HTML' ></a>
</td>

<td class="bmenu" align="right" width="8%">DRD
<a href="#" onClick="TZoznamDPHDRD();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam dokladov po druhoch DPH vo form·te PDF" ></a>
<a href="#" onClick="ZoznamDPHDRD();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam dokladov po druhoch DPH vo form·te HTML' ></a>
</td>

<td class="bmenu" align="right" width="8%">CHB
<a href="#" onClick="TZoznamDPHCHB();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam chybov˝ch hl·senÌ DPH vo form·te PDF" ></a>
<a href="#" onClick="ZoznamDPHCHB();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam chybov˝ch hl·senÌ DPH vo form·te HTML' ></a>
</td>

<?php                        } ?>
<?php if( $kli_vrok < 2009 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/prizdph_2008.php?copern=20&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF" ></a>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/prizdph_2008.php?copern=30&drupoh=1&page=1&typ=HTML', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobrazenie a ˙prava DPH' ></a>
</td>
</td>
<td class="bmenu" width="90%">DaÚ z pridanej hodnoty - Zoznam dokladov a chybovÈ hl·senia v.2008</td>
<?php                        } ?>

</tr>
</form>
</table>



<script type="text/javascript">
//obratova predvaha
  function ObratovkaPDF()
  {
    window.open('../ucto/uobrat.php?copern=10&drupoh=1&page=1&typ=PDF', '_blank', blank_param);
  }
  function Obratovka()
  {
    window.open('../ucto/uobrat.php?copern=10&drupoh=1&page=1&typ=HTML', '_self');
  }
//hlavna kniha polozkovita
  function HlavnaKnihaPolozkovitaPDF()
  {
<?php if ( $fir_big == 1 ) { echo "var h_s200 = document.forms.formhkp1.h_s200.value;"; } ?>
<?php if ( $fir_big == 0 ) { echo "var h_s200=1;"; } ?>
    window.open('../ucto/hlkniha_polpdf.php?h_s200=' + h_s200 + '&copern=10&drupoh=1&page=1&typ=PDF', '_blank', blank_param);
  }
  function HlavnaKnihaPolozkovita()
  {
    window.open('../ucto/hlkniha_pdf.php?copern=10&drupoh=1&page=1&typ=HTML', '_self');
  }
//hlavna kniha sumarna
  function HlavnaKnihaSumarnaPDF()
  {
    var h_obdp = document.forms.formhk1.h_obdp.value;
    var h_obdk = document.forms.formhk1.h_obdk.value;
    window.open('../ucto/hlkniha.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&copern=11&drupoh=2&page=1&typ=PDF', '_blank', blank_param);
  }
  function HlavnaKnihaSumarnaSUPDF()
  {
    var h_obdp = document.forms.formhk1.h_obdp.value;
    var h_obdk = document.forms.formhk1.h_obdk.value;
    window.open('../ucto/hlkniha_su.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&copern=11&drupoh=2&page=1&typ=PDF&su=1', '_blank', blank_param);
  }
  function HlavnaKnihaSumarnaSUAUPDF()
  {
    var h_obdp = document.forms.formhk1.h_obdp.value;
    var h_obdk = document.forms.formhk1.h_obdk.value;
    window.open('../ucto/hlkniha_suau.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&copern=11&drupoh=2&page=1&typ=PDF&su=1', '_blank', blank_param);
  }
  function HlavnaKnihaSumarnaSUAUnazovPDF()
  {
    var h_obdp = document.forms.formhk1.h_obdp.value;
    var h_obdk = document.forms.formhk1.h_obdk.value;
    window.open('../ucto/hlkniha_suau.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&copern=11&drupoh=2&page=1&typ=PDF&su=1&nazvy=1', '_blank', blank_param);
  }
  function HlavnaKnihaSumarna()
  {
    var h_obdp = document.forms.formhk1.h_obdp.value;
    var h_obdk = document.forms.formhk1.h_obdk.value;
    window.open('../ucto/hlkniha.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&copern=11&drupoh=2&page=1&typ=HTML', '_self');
  }
//uctovny dennik
  function DennikPDF()
  {
    window.open('../ucto/udennik.php?copern=10&drupoh=1&page=1&typ=PDF', '_blank', blank_param);
  }
  function Dennik()
  {
    window.open('../ucto/udennik.php?copern=10&drupoh=1&page=1&typ=HTML', '_self');
  }
//suvaha jednoducha
  function SuvahaPDF()
  {
    window.open('../ucto/suv_mala.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>', '_blank', blank_param);
  }
  function SuvahaSUPDF()
  {
    window.open('../ucto/suv_mala.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&synt=1', '_blank', blank_param);
  }
  function SuvahaMesPDF()
  {
    window.open('../ucto/messuv.php?copern=10&drupoh=1&h_obdp=1&h_obdk=<?php echo $kli_vmes; ?>&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1', '_blank', blank_param);
  }
  function SuvahaMesTextPDF()
  {
    window.open('../ucto/messuv.php?copern=10&drupoh=1&h_obdp=1&h_obdk=<?php echo $kli_vmes; ?>&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1&ajtext=1', '_blank', blank_param);
  }
  function SuvahaRokPDF()
  {
    window.open('../ucto/roksuv.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1', '_blank',blank_param);
  }
  function SuvahaRokTextPDF()
  {
    window.open('../ucto/roksuv.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1&ajtext=1', '_blank', blank_param);
  }
//vysledovka jednoducha
  function VysledovkaPDF()
  {
    var h_obdp = document.forms.formvm1.h_obdp.value;
    var h_obdk = document.forms.formvm1.h_obdk.value;
    window.open('../ucto/vys_mala.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1', '_blank', blank_param);
  }
  function VysledovkaSUPDF()
  {
    var h_obdp = document.forms.formvm1.h_obdp.value;
    var h_obdk = document.forms.formvm1.h_obdk.value;
    window.open('../ucto/vys_mala.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&synt=1&obdx=1', '_blank', blank_param);
  }
  function VysledovkaStrPDF()
  {
    window.open('../ucto/vys_str.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>', '_blank', blank_param);
  }
  function VysledovkaZakPDF()
  {
    window.open('../ucto/vys_zak.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>', '_blank', blank_param);
  }
  function VysledovkaStrZakPDF()
  {
    window.open('../ucto/vys_strzak.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>', '_blank', blank_param);
  }
  function VysledovkaSkuPDF()
  {
    window.open('../ucto/vys_sku.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>', '_blank', blank_param) ;
  }
  function VysledovkaStaPDF()
  {
    window.open('../ucto/vys_stv.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>', '_blank', blank_param);
  }
  function VysledovkaMesPDF()
  {
    var h_obdp = document.forms.formvm1.h_obdp.value;
    var h_obdk = document.forms.formvm1.h_obdk.value;
    window.open('../ucto/mesnakvyn.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1', '_blank',blank_param);
  }
  function VysledovkaMesTextPDF()
  {
    var h_obdp = document.forms.formvm1.h_obdp.value;
    var h_obdk = document.forms.formvm1.h_obdk.value;
    window.open('../ucto/mesnakvyn.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1&ajtext=1', '_blank',blank_param);
  }
  function VysledovkaRokPDF()
  {
    var h_obdp = document.forms.formvm1.h_obdp.value;
    var h_obdk = document.forms.formvm1.h_obdk.value;
    window.open('../ucto/roknakvyn.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1', '_blank', blank_param);
  }
  function VysledovkaRokTextPDF()
  {
    var h_obdp = document.forms.formvm1.h_obdp.value;
    var h_obdk = document.forms.formvm1.h_obdk.value;
    window.open('../ucto/roknakvyn.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1&ajtext=1', '_blank', blank_param);
  }
</script>
<?php
     }
//$kli_vduj != 9
?>


<?php
if ( $kli_vduj == 9 )
     {
?>
<!-- <a href="#" onClick="window.open('../analyzy/danovy_csv.php?copern=1&drupoh=1&page=1', '_self' )">
<img src='../obr/export.png' width=20 height=15 border=0 title='Prejsù do exportu pre D⁄ do CSV' ></a> -->

<!-- penazny dennik1 -->
<div class="mdl-cell mdl-cell--10-col mdl-cell--1-offset-desktop">
  <div class="mdl-shadow--2dp inline-card">
    <div class="inline-card-content">
      <div class="card-actions">
        <button type="button" id="pen_dennik1_pdf" onclick="PenaznyDennik1PDF();" class="mdl-button mdl-js-button mdl-button--icon">
          <i class="material-icons md-dark">print</i>
        </button>
          <span data-mdl-for="pen_dennik1_pdf" class="mdl-tooltip">Zobraziù v PDF</span>
      </div>
      <div class="card-title">PeÚaûn˝ dennÌk&nbsp;<i title="druh 1" class="material-icons md-dark md-inactive">looks_one</i></div>
      <div class="card-actions toright">
        <button type="button" id="pen_dennik1" onclick="PenaznyDennik1();" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
          <i class="material-icons">arrow_forward</i>
        </button>
          <span data-mdl-for="pen_dennik1" class="mdl-tooltip">Vst˙più, n·hæad</span>
      </div>
    </div><!-- .inline-card-content -->
  </div><!-- .inline-card -->
</div><!-- .mdl-cell -->

<!-- penazny dennik2 -->
<div class="mdl-cell mdl-cell--10-col mdl-cell--1-offset-desktop">
  <div class="mdl-shadow--2dp inline-card">
    <form name="formd2" method="post" action="#" class="inline-card-content">
      <div class="card-actions">
        <button type="button" id="pen_dennik22012" onclick="PenaznyDennik22012PDF();" class="mdl-button mdl-js-button mdl-button--icon">
          <i class="material-icons md-dark">print</i>
        </button>
          <span data-mdl-for="pen_dennik22012" class="mdl-tooltip">Zobraziù v PDF</span>
      </div>
      <div class="card-title">
        PeÚaûn˝ dennÌk&nbsp;<i title="druh 2" class="material-icons md-dark md-inactive">looks_two</i>
        <select name="h_aky" id="h_aky" size="1" style="font-size: inherit; font-weight: 500; border:0; font-family: 'Roboto', 'Arial'; color: inherit; height: 32px; padding-bottom: 1px;">
          <option value="1">poloûkovit˝</option>
          <option value="2">suma za doklady</option>
        </select>
        verzia pre rok 2012
<?php
$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$prvy = "01.01.".$kli_vrok;
?>
 D·tum: <input type="text" name="h_dap" id="h_dap" maxlenght="10" value="<?php echo $prvy; ?>" style="width: 70px;"/>
 <input type="text" name="h_dak" id="h_dak" maxlenght="10" value="<?php echo $dnes; ?>" style="width: 70px;"/>
 Strany: <input type="text" name="h_stp" id="h_stp" maxlenght="10" value="1" style="width: 20px;"/>
 <input type="text" name="h_stk" id="h_stk" maxlenght="10" value="999" style="width: 30px;"/>
      </div>
      <div class="card-actions toright">
        <button type="button" id="pen_dennik22012_druh" onclick="PenaznyDennik22012Druh();" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
          <i class="material-icons">settings</i>
        </button>
          <span data-mdl-for="pen_dennik22012_druh" class="mdl-tooltip">Nastavenie druh pohybu -> stÂpec peÚaûnÈho dennÌka pre rok 2012</span>
      </div>
    </form><!-- .inline-card-content -->
    <div class="divider-horizontal">&nbsp;</div>
    <form name="formd2013" method="post" action="#" class="inline-card-content">
      <div class="card-actions">
        <button type="button" id="pen_dennik22013" onclick="PenaznyDennik22013PDF();" class="mdl-button mdl-js-button mdl-button--icon">
          <i class="material-icons md-dark">print</i>
        </button>
          <span data-mdl-for="pen_dennik22013" class="mdl-tooltip">Zobraziù v PDF</span>
      </div>
      <div class="card-title">
        PeÚaûn˝ dennÌk&nbsp;<i title="druh 2" class="material-icons md-dark md-inactive">looks_two</i>
        <select name="h_aky" id="h_aky" size="1" style="font-size: inherit; font-weight: 500; border:0; font-family: 'Roboto', 'Arial'; color: inherit; height: 32px; padding-bottom: 1px;">
          <option value="1">poloûkovit˝</option>
          <option value="2">suma za doklady</option>
        </select>
        &nbsp;verzia pre rok 2013
<?php
$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$prvy = "01.01.".$kli_vrok;
?>
 D·tum: <input type="text" name="h_dap" id="h_dap" maxlenght="10" value="<?php echo $prvy; ?>" style="width: 70px;"/>
 <input type="text" name="h_dak" id="h_dak" maxlenght="10" value="<?php echo $dnes; ?>" style="width: 70px;"/>
 Strany: <input type="text" name="h_stp" id="h_stp" maxlenght="10" value="1" style="width: 20px;"/>
 <input type="text" name="h_stk" id="h_stk" maxlenght="10" value="999" style="width: 30px;"/>
      </div>
      <div class="card-actions toright">
        <button type="button" id="pen_dennik22013_druh" onclick="PenaznyDennik22013Druh();" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
          <i class="material-icons">settings</i>
        </button>
          <span data-mdl-for="pen_dennik22013_druh" class="mdl-tooltip">Nastavenie druh pohybu -> stÂpec peÚaûnÈho dennÌka pre rok 2013</span>
      </div>
    </form><!-- .inline-card-content -->
  </div><!-- .inline-card -->
</div><!-- .mdl-cell -->

<!-- kniha pohladavok/zavazkov -->
<div class="mdl-cell mdl-cell--10-col mdl-cell--1-offset-desktop">
  <div class="mdl-shadow--2dp inline-card">
    <form name="formkf1" method="post" action="#" class="inline-card-content">
      <div class="card-actions">
        <button type="button" id="kniha_pohzav_pdf" onclick="KnihaFakturPDF();" class="mdl-button mdl-js-button mdl-button--icon">
          <i class="material-icons md-dark">print</i>
        </button>
          <span data-mdl-for="kniha_pohzav_pdf" class="mdl-tooltip">Zobraziù v PDF</span>
      </div>
      <div class="card-title">
        Kniha
        <select name="h_drp" id="h_drp" size="1" style="font-size: inherit; font-weight: 500; border:0; font-family: 'Roboto', 'Arial'; color: inherit; height: 32px; padding-bottom: 1px;">
          <option value="3">pohæad·vok</option>
          <option value="4">z·v‰zkov</option>
        </select>
        <select name="h_obdp" id="h_obdp" size="1" class="select-bg">
          <option value="1">01.<?php echo $kli_vrok; ?></option>
          <option value="2">02.<?php echo $kli_vrok; ?></option>
          <option value="3">03.<?php echo $kli_vrok; ?></option>
          <option value="4">04.<?php echo $kli_vrok; ?></option>
          <option value="5">05.<?php echo $kli_vrok; ?></option>
          <option value="6">06.<?php echo $kli_vrok; ?></option>
          <option value="7">07.<?php echo $kli_vrok; ?></option>
          <option value="8">08.<?php echo $kli_vrok; ?></option>
          <option value="9">09.<?php echo $kli_vrok; ?></option>
          <option value="10">10.<?php echo $kli_vrok; ?></option>
          <option value="11">11.<?php echo $kli_vrok; ?></option>
          <option value="12">12.<?php echo $kli_vrok; ?></option>
        </select>
        <i class="material-icons md-dark md-inactive">trending_flat</i>
        <select name="h_obdk" id="h_obdk" size="1" class="select-bg">
          <option value="1">01.<?php echo $kli_vrok; ?></option>
          <option value="2">02.<?php echo $kli_vrok; ?></option>
          <option value="3">03.<?php echo $kli_vrok; ?></option>
          <option value="4">04.<?php echo $kli_vrok; ?></option>
          <option value="5">05.<?php echo $kli_vrok; ?></option>
          <option value="6">06.<?php echo $kli_vrok; ?></option>
          <option value="7">07.<?php echo $kli_vrok; ?></option>
          <option value="8">08.<?php echo $kli_vrok; ?></option>
          <option value="9">09.<?php echo $kli_vrok; ?></option>
          <option value="10">10.<?php echo $kli_vrok; ?></option>
          <option value="11">11.<?php echo $kli_vrok; ?></option>
          <option value="12">12.<?php echo $kli_vrok; ?></option>
        </select>
      </div>
    </form><!-- .inline-card-content -->
  </div><!-- .inline-card -->
</div><!-- .mdl-cell -->

<!-- prehlad pohybov -->
<div class="mdl-cell mdl-cell--10-col mdl-cell--1-offset-desktop">
  <div class="mdl-shadow--2dp inline-card">
    <form name="formhk1" method="post" action="#" class="inline-card-content">
      <div class="card-actions">
        <button type="button" id="ju_pohyby_pdf" onclick="PohybyUctyPDF();" class="mdl-button mdl-js-button mdl-button--icon">
          <i class="material-icons md-dark">print</i>
        </button>
          <span data-mdl-for="ju_pohyby_pdf" class="mdl-tooltip">Zobraziù v PDF</span>
      </div>
      <div class="card-title">
        Prehæad ˙Ëtovn˝ch pohybov
        <select name="h_obdp" id="h_obdp" size="1" class="select-bg">
          <option value="1">01.<?php echo $kli_vrok; ?></option>
          <option value="2">02.<?php echo $kli_vrok; ?></option>
          <option value="3">03.<?php echo $kli_vrok; ?></option>
          <option value="4">04.<?php echo $kli_vrok; ?></option>
          <option value="5">05.<?php echo $kli_vrok; ?></option>
          <option value="6">06.<?php echo $kli_vrok; ?></option>
          <option value="7">07.<?php echo $kli_vrok; ?></option>
          <option value="8">08.<?php echo $kli_vrok; ?></option>
          <option value="9">09.<?php echo $kli_vrok; ?></option>
          <option value="10">10.<?php echo $kli_vrok; ?></option>
          <option value="11">11.<?php echo $kli_vrok; ?></option>
          <option value="12">12.<?php echo $kli_vrok; ?></option>
        </select>
        <i class="material-icons md-dark md-inactive">trending_flat</i>
        <select name="h_obdk" id="h_obdk" size="1" class="select-bg">
          <option value="1">01.<?php echo $kli_vrok; ?></option>
          <option value="2">02.<?php echo $kli_vrok; ?></option>
          <option value="3">03.<?php echo $kli_vrok; ?></option>
          <option value="4">04.<?php echo $kli_vrok; ?></option>
          <option value="5">05.<?php echo $kli_vrok; ?></option>
          <option value="6">06.<?php echo $kli_vrok; ?></option>
          <option value="7">07.<?php echo $kli_vrok; ?></option>
          <option value="8">08.<?php echo $kli_vrok; ?></option>
          <option value="9">09.<?php echo $kli_vrok; ?></option>
          <option value="10">10.<?php echo $kli_vrok; ?></option>
          <option value="11">11.<?php echo $kli_vrok; ?></option>
          <option value="12">12.<?php echo $kli_vrok; ?></option>
        </select>
      </div>
      <div class="card-actions toright">
        <button type="button" id="ju_pohyby" onclick="PohybyUcty();" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
          <i class="material-icons">arrow_forward</i>
        </button>
          <span data-mdl-for="ju_pohyby" class="mdl-tooltip">Vst˙più, n·hæad</span>
      </div>
    </form><!-- .inline-card-content -->
  </div><!-- .inline-card -->
</div><!-- .mdl-cell -->












<table class="vstup" width="100%" style="display: none;"> <!-- dopyt, pÙjde do zvl·öù card -->
<form name="formvm1ju" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="MesNakVynJu();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='MesaËn˝ prehæad prÌjmov a v˝davkov zapoËÌtateæn˝ch do daÚovÈho z·kladu VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="72%">MesaËn˝ prehæad prÌjmov a v˝davkov zapoËÌtateæn˝ch do daÚovÈho z·kladu
<a href="#" onClick="MesNakVynTextJu();">
MESTx<img src='../obr/tlac.png' width=20 height=15 border=0 title='MesaËn˝ prehæad prÌjmov a v˝davkov aj s n·zvom pohybu VytlaËiù vo form·te PDF' ></a>
</td>
<?php
//echo $kli_vmes;
?>

<td class="bmenu" width="20%" >
<select size="1" name="h_obdp" id="h_obdp" >
<?php if( $kli_vmes >= 1 ) { echo "<option value='1' >od 01.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 2 ) { echo "<option value='2' >od 02.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 3 ) { echo "<option value='3' >od 03.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 4 ) { echo "<option value='4' >od 04.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 5 ) { echo "<option value='5' >od 05.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 6 ) { echo "<option value='6' >od 06.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 7 ) { echo "<option value='7' >od 07.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 8 ) { echo "<option value='8' >od 08.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 9 ) { echo "<option value='9' >od 09.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 10 ) { echo "<option value='10' >od 10.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 11 ) { echo "<option value='11' >od 11.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 12 ) { echo "<option value='12' >od 12.$kli_vrok</option>";  } ?>
</select>

<select size="1" name="h_obdk" id="h_obdk" >
<?php if( $kli_vmes == 1 ) { echo "<option value='1' >do 01.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 2 ) { echo "<option value='2' >do 02.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 3 ) { echo "<option value='3' >do 03.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 4 ) { echo "<option value='4' >do 04.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 5 ) { echo "<option value='5' >do 05.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 6 ) { echo "<option value='6' >do 06.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 7 ) { echo "<option value='7' >do 07.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 8 ) { echo "<option value='8' >do 08.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 9 ) { echo "<option value='9' >do 09.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 10 ) { echo "<option value='10' >do 10.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 11 ) { echo "<option value='11' >do 11.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 12 ) { echo "<option value='12' >do 12.$kli_vrok</option>";  } ?>
</select>
</tr>
</form>
</table>

<?php
$jedrok=2013;
if( $kli_vrok < 2013 ) { $jedrok=""; }
$zobraz="";
if( $kli_vrok > 2015 ) { $zobraz="style=\"display:none;\""; }

?>

<table class="vstup" width="100%" <?php echo $zobraz; ?> >
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vprivyd<?php echo $jedrok; ?>.php?copern=10&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF v eurocentoch" ></a>
</td>
<td class="bmenu" width="88%">V˝kaz o prÌjmoch a v˝davkoch ⁄Ë. FO 1-01</td>
<td class="bmenu" width="2%" >
<a href="#" onClick="JUvykpvpohHTML()">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='V˝kaz o prÌjmoch a v˝davkoch podæa ˙Ëtovn˝ch pohybov' ></a>

</tr>
</table>

<table class="vstup" width="100%" <?php echo $zobraz; ?> >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vmajzav<?php echo $jedrok; ?>.php?copern=10&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF v eurocentoch" ></a>
</td>
<td class="bmenu" width="90%">V˝kaz o majetku a z·v‰zkoch ⁄Ë. FO 2-01 </td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=42&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
<tr>
</table>

<table class="vstup" width="100%" style="display: none;"> <!-- dopyt, pÙjde do zvl·öù card dph -->
<form name="formrd2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacRD();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Zoznam fakt˙r" ></a>
</td>
<td class="bmenu" width="38%">DPH za˙Ëtovan· a zaplaten· na fakt˙rach
 <select size="1" name="h_aky" id="h_aky" >
<option value="1" >dod·vateæsk˝ch</option>
<option value="2" >odberateæsk˝ch</option>
</select>
</td>
<td class="bmenu" width="60%"></td>
</tr>
<tr>
</form>
</table>

<table class="vstup" width="100%" style="display: none;">
<form name="formp1" class="obyc" method="post" action="#" >
<tr>
<?php if( $kli_vrok >= 2009 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="PriznanieDPH();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF" ></a>
</td>

<?php if( $kli_vrok <  2011 ) { ?>
<td class="bmenu" width="90%">DaÚovÈ priznanie DaÚ z pridanej hodnoty verzia DPHv10
<?php                        } ?>
<?php if( $kli_vrok == 2011 ) { ?>
<td class="bmenu" width="90%">DaÚovÈ priznanie DaÚ z pridanej hodnoty verzia DPHv11
<?php                        } ?>
<?php if( $kli_vrok >  2011 ) { ?>
<td class="bmenu" width="90%">DaÚovÈ priznanie DaÚ z pridanej hodnoty verzia DPHv12
<?php                        } ?>

<select size="1" name="h_drp" id="h_drp" >
<option value="1" >Riadne</option>
<option value="2" >OpravnÈ</option>
<option value="3" >DodatoËnÈ</option>
</select>
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?>
 D·tum: <input type="text" name="h_dap" id="h_dap" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
<select size="1" name="fir_uctx01" id="fir_uctx01" >
<option value="1" >MesaËnÈ</option>
<option value="2" >ätvrùroËnÈ</option>
<option value="4" >RoËnÈ</option>
</select>
<a href="#" onClick="TlacPotvrdDPH();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù potvrdenie o podanÌ daÚovÈho priznania DPH vo form·te PDF" ></a>
</td>
<td class="bmenu" width="10%">
<select size="1" name="h_arch" id="h_arch" >
<option value="0" >Nearchivovaù</option>
<option value="1" >Archivovaù</option>
</select>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/archivdph<?php echo $rokdph; ?>.php?copern=80&drupoh=1&page=1', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='ArchÌv DaÚov˝ch priznanÌ DPH rok <?php echo $kli_vrok; ?>' ></a>
</td>
<?php                        } ?>

<?php if( $kli_vrok < 2009 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/prizdph_2008.php?copern=10&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam dokladov po riadkoch DPH vo form·te PDF" ></a>
</td>
<td class="bmenu" width="90%">DaÚovÈ priznanie DaÚ z pridanej hodnoty verzia DPHv07_1</td>
<?php                        } ?>
</tr>
</form>
</table>

<table class="vstup" width="100%" style="display: none;">
<form name="formg1" class="obyc" method="post" action="#" >
<tr>
<?php if( $kli_vrok >= 2009 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="TZoznamDPH();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam dokladov po riadkoch DPH vo form·te PDF" ></a>
<td class="bmenu" width="2%">
<a href="#" onClick="ZoznamDPH();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam dokladov po riadkoch DPH vo form·te HTML' ></a>
</td>
</td>
<td class="bmenu" width="70%">DaÚ z pridanej hodnoty - Zoznamy dokladov a chybovÈ hl·senia v.<?php echo $kli_vrok; ?>
<select size="1" name="fir_uctx01" id="fir_uctx01" >
<option value="1" >MesaËn˝</option>
<option value="2" >ätvrùroËn˝</option>
</select>
</td>

<td class="bmenu" align="right" width="8%">DOK
<a href="#" onClick="TZoznamDPHDOK();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam dokladov po dokladoch DPH vo form·te PDF" ></a>
<a href="#" onClick="ZoznamDPHDOK();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam dokladov po dokladoch DPH vo form·te HTML' ></a>
</td>

<td class="bmenu" align="right" width="8%">DRD
<a href="#" onClick="TZoznamDPHDRD();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam dokladov po druhoch DPH vo form·te PDF" ></a>
<a href="#" onClick="ZoznamDPHDRD();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam dokladov po druhoch DPH vo form·te HTML' ></a>
</td>

<td class="bmenu" align="right" width="8%">CHB
<a href="#" onClick="TZoznamDPHCHB();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam chybov˝ch hl·senÌ DPH vo form·te PDF" ></a>
<a href="#" onClick="ZoznamDPHCHB();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam chybov˝ch hl·senÌ DPH vo form·te HTML' ></a>
</td>
<?php                        } ?>
<?php if( $kli_vrok < 2009 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/prizdph_2008.php?copern=20&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF" ></a>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/prizdph_2008.php?copern=30&drupoh=1&page=1&typ=HTML', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobrazenie a ˙prava DPH' ></a>
</td>
</td>
<td class="bmenu" width="90%">DaÚ z pridanej hodnoty - Zoznam dokladov a chybovÈ hl·senia v.2008</td>
<?php                        } ?>

</tr>
</form>
</table>


<script>
//penazny dennik1
  function PenaznyDennik1PDF()
  {
    window.open('../ucto/penden.php?copern=10&drupoh=1&page=1&typ=PDF', '_blank', blank_param);
  }
  function PenaznyDennik1()
  {
    window.open('../ucto/penden.php?copern=10&drupoh=1&page=1&typ=HTML', '_self');
  }
//penazny dennik2 2012
  function PenaznyDennik22012PDF()
  {
    var h_dap = document.forms.formd2.h_dap.value;
    var h_dak = document.forms.formd2.h_dak.value;
    var h_stp = document.forms.formd2.h_stp.value;
    var h_stk = document.forms.formd2.h_stk.value;
    var h_aky = document.forms.formd2.h_aky.value;
    window.open('../ucto/penden2.php?h_dap=' + h_dap + '&h_dak=' + h_dak + '&h_stp=' + h_stp + '&h_stk=' + h_stk + '&h_aky=' + h_aky + '&copern=10&drupoh=1&page=1&typ=PDF', '_blank', blank_param)
  }
  function PenaznyDennik22012Druh()
  {
    window.open('../ucto/oprsys.php?copern=308&drupoh=29&page=1&sysx=UCT', '_blank', blank_param);
  }
//penazny dennik2 2013
  function PenaznyDennik22013PDF()
  {
    var h_dap = document.forms.formd2013.h_dap.value;
    var h_dak = document.forms.formd2013.h_dak.value;
    var h_stp = document.forms.formd2013.h_stp.value;
    var h_stk = document.forms.formd2013.h_stk.value;
    var h_aky = document.forms.formd2013.h_aky.value;
    window.open('../ucto/penden2013.php?h_dap=' + h_dap + '&h_dak=' + h_dak + '&h_stp=' + h_stp + '&h_stk=' + h_stk + '&h_aky=' + h_aky + '&copern=10&drupoh=1&page=1&typ=PDF', '_blank', blank_param);
  }
  function PenaznyDennik22013Druh()
  {
    window.open('../ucto/oprsys.php?copern=308&drupoh=28&page=1&sysx=UCT', '_blank', blank_param);
  }
//prehlad pohybov
  function PohybyUctyPDF()
  {
    var h_obdp = document.forms.formhk1.h_obdp.value;
    var h_obdk = document.forms.formhk1.h_obdk.value;
    window.open('../ucto/juknihapoh.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&copern=11&drupoh=2&page=1&typ=PDF', '_blank', blank_param);
  }
  function PohybyUcty()
  {
    var h_obdp = document.forms.formhk1.h_obdp.value;
    var h_obdk = document.forms.formhk1.h_obdk.value;
    window.open('../ucto/juknihapoh.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&copern=11&drupoh=2&page=1&typ=HTML', '_blank', blank_param);
  }

</script>
<?php
     }
//$kli_vduj == 9
?>
</div><!-- .mdl-grid -->


<div class="mdl-layout-spacer"></div>
<footer class="mdl-mini-footer ui-container">
  <div class="mdl-mini-footer__left-section">
    <div class="mdl-logo mdl-color-text--grey-500">© 2018 EuroSecom</div>
  </div>
</footer>
</main>


<div class="mdl-layout__drawer">
  <span class="mdl-layout-title">Title</span>
  <nav class="mdl-navigation">
    <a class="mdl-navigation__link" href="">Link</a>
    <a class="mdl-navigation__link" href="">Link</a>
    <a class="mdl-navigation__link" href="">Link</a>
    <a class="mdl-navigation__link" href="">Link</a>
  </nav>
</div>




</div><!-- .mdl-layout -->


<?php
// celkovy koniec dokumentu

//$zmenume=1; $odkaz="../ucto/meszos.php?copern=1&drupoh=1&page=1&sysx=UCT";
//$cislista = include("uct_lista.php");

       } while (false);
?>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script type="text/javascript">
//dimensions blank window
var blank_param = 'scrollbars=yes, resizable=yes, top=0, left=0, width=1080, height=900';
//dopyt, zakomponovaù aj "_blank"

//kniha faktur
  function KnihaFakturPDF()
  {
    var h_obdp = document.forms.formkf1.h_obdp.value;
    var h_obdk = document.forms.formkf1.h_obdk.value;
    var h_drp = document.forms.formkf1.h_drp.value;
    window.open('../ucto/kniha_faktur.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&h_drp=' + h_drp +  '&copern=1&drupoh=1&page=1&typ=PDF', '_blank', blank_param);
  }




//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;




function PriznanieDPH()
                {
var h_drp = document.forms.formp1.h_drp.value;
var h_dap = document.forms.formp1.h_dap.value;
var h_arch = document.forms.formp1.h_arch.value;
var fir_uctx01 = document.forms.formp1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&h_drp=' + h_drp + '&h_dap=' + h_dap + '&h_arch=' + h_arch + '&copern=10&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function ZoznamDPH()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=30&drupoh=1&page=1&typ=HTML', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function TZoznamDPH()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=20&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }


function VyberVstup()
                {
<?php if( $kli_vduj != 9 ) { echo "document.forms.formhk1.h_obdp.value=$kli_vmes; "; } ?>
<?php if( $kli_vduj != 9 ) { echo "document.forms.formhk1.h_obdk.value=$kli_vmes; "; } ?>
<?php if( $kli_vduj != 99 ) { echo "document.forms.formkf1.h_obdp.value=$kli_vmes; "; } ?>
<?php if( $kli_vduj != 99 ) { echo "document.forms.formkf1.h_obdk.value=$kli_vmes; "; } ?>
<?php echo "document.forms.formp1.fir_uctx01.value=$fir_uctx01; ";  ?>
<?php echo "document.forms.formg1.fir_uctx01.value=$fir_uctx01; ";  ?>
                }




function JUvykpvpohHTML()
                {
var h_obdp = document.forms.formhk1.h_obdp.value;
var h_obdk = document.forms.formhk1.h_obdk.value;

window.open('../ucto/vykpvpoh.php?h_obdp=1&h_obdk=<?php echo $kli_vmes; ?>&copern=11&drupoh=2&page=1&typ=HTML', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }


function TlacPotvrdDPH()
                {
  var okno = window.open("../tmp/potvrddph<?php echo $kli_vume; ?>.<?php echo $kli_uzid; ?>.pdf", '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }





function ZoznamDPHDOK()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=1&page=1&typ=HTML', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function TZoznamDPHDOK()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=2&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function ZoznamDPHFAK()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=1&page=1&typ=HTML&zfak=10', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function TZoznamDPHFAK()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=2&page=1&typ=PDF&zfak=11', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function ZoznamDPHDRD()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=1&page=1&typ=HTML&zdrd=10', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function TZoznamDPHDRD()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=2&page=1&typ=PDF&zdrd=11', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function ZoznamDPHCHB()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=1&page=1&typ=HTML&chyby=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function TZoznamDPHCHB()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=2&page=1&typ=PDF&chyby=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }


function TZoznamDPHPRP()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prijplat_dph.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=2&page=1&typ=PDF&zdrd=11', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

  function SynGenSuv()
  {

window.open('../ucto/oprsys.php?copern=308&drupoh=44&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

  }


function TlacRD()
                {

var h_aky = document.forms.formrd2.h_aky.value;

window.open('../ucto/fakt_dph.php?h_aky=' + h_aky + '&copern=40&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }







function MesNakVynJu()
                {
var h_obdp = document.forms.formvm1ju.h_obdp.value;
var h_obdk = document.forms.formvm1ju.h_obdk.value;

window.open('../ucto/mesnakvynju.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }



function MesNakVynTextJu()
                {
var h_obdp = document.forms.formvm1ju.h_obdp.value;
var h_obdk = document.forms.formvm1ju.h_obdk.value;

window.open('../ucto/mesnakvynju.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1&ajtext=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }



  function GenSuvNo()
  {

window.open('../ucto/oprcis.php?copern=308&drupoh=96&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

  }











</script>
</body>
</html>