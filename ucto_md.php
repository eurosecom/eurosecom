<?php
session_start();
$_SESSION['ucto_sys'] = 1;
$_SESSION['pocstav'] = 0; /*dopyt, nebude treba v bud˙cnosti, nebudem rozliöovaù*/
?>
<!doctype html>
<html>
<?php
//cislo operacie
$copern = 1*$_REQUEST['copern'];

       do
       {
if ( $copern !== 99 )
{
$sys = 'UCT';
$urov = 2000;
$cslm = 1;
if( $_SESSION['kli_vxcf'] == 9999 )
{ echo "Vypnite vöetky okn· v prehliadaËi IE a prihl·ste sa znovu prosÌm do IS, ak ste pouûÌvali CestovnÈ prÌkazy"; exit; } //dopyt, nie je mi jasnÈ
$uziv = include("uziv.php");
if( !$uziv ) exit;

  require_once("pswd/password.php");

$mysqldbfir=$mysqldb;
$mysqldbdata=$mysqldb;
$oddelnew=0;
if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano"))
          {
$dtb2 = include("oddel_dtb1new.php");
$oddelnew=1;
          }
else
          {
$dtb2 = include("oddel_dtb1.php");
          }

  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

}

$firs = 1*$_REQUEST['firs'];
$umes = 1*$_REQUEST['umes'];

//echo "copern ".$copern." firs ".$firs;

// zmena firmy
if ( $copern == 25 OR $copern == 23 )
     {

//ak zmena firmy nastav umes podla kli_vrok vo firme
if ( $copern == 23 )
     {
$sqlmax = mysql_query("SELECT * FROM $mysqldbfir.fir WHERE xcf=$firs");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $umes="1.".$riadmax->rok;
  }
     }


$zmazane = mysql_query("DELETE FROM $mysqldbfir.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldbfir.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");

if( $oddelnew == 1 )
  {
$zmazane = mysql_query("DELETE FROM $mysqldb2010.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2010.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2011.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2011.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2012.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2012.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2013.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2013.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2014.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2014.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2015.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2015.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2016.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2016.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2017.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2017.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2018.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2018.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2019.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2019.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
  }
     }

$cit_nas = include("cis/citaj_nas.php");

$cook=0;
if( $cook == 1 )
    {
setcookie("kli_vxcf", $vyb_xcf, time() + (7 * 24 * 60 * 60));
setcookie("kli_nxcf", $vyb_naz, time() + (7 * 24 * 60 * 60));
setcookie("kli_vume", $vyb_ume, time() + (7 * 24 * 60 * 60));
setcookie("kli_vrok", $vyb_rok, time() + (7 * 24 * 60 * 60));
    }
session_start();
$_SESSION['kli_vxcf'] = $vyb_xcf;
$_SESSION['kli_nxcf'] = $vyb_naz;
$_SESSION['kli_vume'] = $vyb_ume;
$_SESSION['kli_vrok'] = $vyb_rok;
$_SESSION['kli_vduj'] = $vyb_duj;

  $kli_vduj=$_SESSION['kli_vduj'];

if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano"))
          {
$dtb2 = include("oddel_dtb2new.php");
          }
else
          {
$dtb2 = include("oddel_dtb2.php");
          }


//echo " rok ".$vyb_rok;
//echo " dbdata ".$mysqldbdata."<br />";
//exit;

  mysql_select_db($mysqldbdata);
$vrz = include("verzia.php");

$cvybxcf=1*$vyb_xcf;
if( $cvybxcf > 0 )
          {
//len ak je vybrana firma
//echo "<br /><br /><br /><br /><br />idem";

$sql = "SELECT zmen FROM ".$mysqldbdata.".F$vyb_xcf"."_uctvsdh";
if( $copern == 1 OR $copern == 25 )
{
//echo $sql;
$vysledok = mysql_query($sql);
if (!$vysledok):
$kli_vxcf=$vyb_xcf;
  mysql_select_db($mysqldbdata);
$kalend = include("ucto/vtvuct.php");
endif;
}


          }
//len ak je vybrana firma

//cleaning
$datdnessql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$jeclean=0;
$poslhh = "SELECT * FROM ".$mysqldbdata.".cleaningtmp WHERE dat='$datdnessql' ";
$posl = mysql_query("$poslhh");
if( $posl ) { $jeclean = 1*mysql_num_rows($posl); }
if( $jeclean == 0 )
{
$copernx="alibaba40";
//echo "idem";
$clean = include("funkcie/subory.php");
}

//month navigation
$zmenume=1*$zmenume;
$pole = explode(".", $vyb_ume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_pmes=$kli_vmes-1;
if ( $kli_pmes < 1 ) $kli_pmes=1;
$kli_dmes=$kli_vmes+1;
if ( $kli_dmes > 12 ) $kli_dmes=12;
$kli_pume=$kli_pmes.".".$kli_vrok;
$kli_dume=$kli_dmes.".".$kli_vrok;
$odkaz="../ucto_md.php?copern=1";
$odkaz64=urlencode($odkaz);

//ufir data
$jemenpid=0;
$sqlpoktt = "SELECT * FROM F$kli_vxcf"."_ufir ";
$sqlpok = mysql_query("$sqlpoktt");
if (@$zaznam=mysql_data_seek($sqlpok,0))
{
$riadokpok=mysql_fetch_object($sqlpok);
$fir_fnaz=$riadokpok->fnaz;
}

//first login new user
if ( $vyb_xcf == '' ) { $copern=22; } //dopyt, preveriù



?>
<head>
<meta charset="cp1250">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="css/material.min.css">
<link rel="stylesheet" href="css/material_edit.css">
<title>⁄ËtovnÌctvo | EuroSecom</title>
<style>
/* layout */
.ui-container {
  max-width: 1440px;
}

.ui-header-app-row .mdl-button.dropdown {
  text-transform: none;
  font-weight: 400;
  letter-spacing: 0.02em;
  color: #fff;
}
.ui-header-app-row .mdl-button.dropdown:hover {
  background-color: #039BE5;
}
.ui-header-app-row .mdl-button.dropdown:after {
  vertical-align: middle;
  color: rgba(255,255,255,.7);
}


/* CHANGE DEFAULT */
.mdl-layout__tab-bar-container {
  border-bottom: 1px solid #CFD8DC;
}
.mdl-layout__tab-bar-container, .mdl-layout__tab-bar-button, .mdl-layout__tab-bar {
  background-color: #ECEFF1;
}
.mdl-layout.is-upgraded .mdl-layout__tab.is-active {
  color: #039BE5;
}
.mdl-layout__tab {
  color: rgba(0,0,0,0.4);
  height: 64px;
  line-height: 64px;
}
.mdl-layout.is-upgraded .mdl-layout__tab.is-active:after {
  height: 3px;
  background-color: #039BE5;
}
.mdl-layout__tab-bar-button, .mdl-layout__tab-bar, .mdl-layout__tab-bar-container {
  height: 64px;
}
.mdl-layout__tab-bar-button .material-icons {
  line-height: 64px;
}


.ui-header-toolbar .mdl-button--icon {
  height: 40px;
  width: 40px;
  min-width: 40px;
}









.card-module {
  margin: 16px 0;
  min-height: 56px;
  padding: 10px 0;
  background-color: #fff;
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
}
.card-module-header {
  height: 36px;
  padding: 6px 0 6px 16px;
  position: relative;
  overflow: hidden;
}
.card-module-header .material-icons {
  color: rgba(0,0,0,.54);
  float: left;
}
.card-module-title {
  font-size: 19px;
  float: left;
  height: 24px;
  padding-top: 3px;
  padding-left: 14px;
  width: calc(100% - 48px);
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
.card-module-content {
  position: relative;
}
.card-module-content .card-item {
  font-size: 13px;
  height: 36px;
  padding: 12px 28px 12px 56px;
  letter-spacing: 0.02em;
  position: relative;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;

}
.card-module [onclick]:hover {
  /*background-color: #eee;*/
  /*background-color: #E3F2FD;*/
  background-color: rgba(3,155,229,0.2);
  /*background-color: #E1F5FE;*/
}




.card-module [onclick]:hover:after {
  display: inline-block;
  font-family: 'Material Icons';
  content: '\e89e';
  font-size: 18px;
  position: absolute;
  right: 9px;
  top: 9px;
  color: rgba(0,0,0,.54);
}


.card-module strong {
  font-weight: 500;
}






.card-module[disabled], .card-module-header[disabled], .card-item[disabled], .card-module .mdl-menu__item[disabled] {
  color: rgba(0,0,0,.54);
  background-color: transparent;
  box-shadow: none;
  pointer-events: none;
}










.modal-cover {
  z-index: 100;
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgb(33,33,33); /* Fallback color */
  background-color: rgba(33,33,33,0.45);
}
.modal {
  /*width: 56%;*/
  /*max-width: 768px;*/
width: 720px;
  background-color: #fff;
  overflow: auto;
  /*max-width: 768px;*/

  /*height: 480px;*/
  /*padding: 24px;*/
  /*left: 50%;*/
  /*margin-left: -28%;*/
  /*position: absolute;*/
  /*top: 50%;*/
  /*margin-top: -260px;*/

}
.modal-header {
  /*height: 40px;*/
}
.modal-title {
  font-size: 20px;
  letter-spacing: 0.02em;
}


</style>
</head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--no-drawer-button">
<header class="mdl-layout__header mdl-layout__header--waterfall ui-header">
  <div class="mdl-layout__header-row ui-header-title-row" style="">
    <ol class="mdl-layout-title ui-header-breadcrumb">
    <li onclick="AppPage();" class="mdl-color-text--yellow-A100">EuroSecom</li>
    <li class="breadcrumb-item active">
      <a href="#" id="header_dropdown_menu" class="dropdown">⁄ËtovnÌctvo
<?php
if ( $vyb_duj == 0 ) { echo "podvojnÈ"; }
if ( $vyb_duj == 9 ) { echo "jednoduchÈ"; }
?>
      </a>
    </li>
<!-- header dropdown nav menu -->
    <li class="wrap-dropdown-menu">
      <ul for="header_dropdown_menu" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
        <li onclick="Ucto();" class="mdl-menu__item active">⁄ËtovnÌctvo
<?php
if ( $vyb_duj == 0 ) { echo "podvojnÈ"; }
if ( $vyb_duj == 9 ) { echo "jednoduchÈ"; }
?>
        </li>
        <li onclick="Mzdy();" class="mdl-menu__item">Mzdy</li>
        <li onclick="Odbyt();" class="mdl-menu__item">Odbyt</li>
        <li onclick="Sklad();" class="mdl-menu__item">Sklad</li>
        <li onclick="Majetok();" class="mdl-menu__item">Majetok</li>
        <li onclick="Doprava();" class="mdl-menu__item">Doprava</li>
        <li onclick="Vyroba();" class="mdl-menu__item">V˝roba</li>
        <li onclick="Analyzy();" class="mdl-menu__item">Anal˝zy</li>
      </ul>
    </li>
    </ol><!-- .ui-header-breadcrumb -->

    <button type="button" id="select_firm" onclick="selectFirm();" class="mdl-button mdl-js-button dropdown " style="background-color: white; height: 40px; line-height: 40px; font-weight: 400;">
      <strong><?php echo $vyb_xcf; ?></strong>&nbsp;
      <span><?php echo $vyb_naz; ?></span>
    </button>
    <div class="mdl-layout-spacer"></div>

<!-- tools -->
    <div class="ui-header-toolbar flexbox" style="padding: 12px 0; ">
      <button id="searching" onclick="Searching();" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" title="Prehæad·vanie">
        <i class="material-icons">search</i>
      </button>
      <button id="transfer" onclick="Transfer();" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" title="Prenosy">
        <i class="material-icons">hourglass_empty</i>
      </button>
      <button id="more_tools" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" title="Viac n·strojov">
        <i class="material-icons">more_vert</i>
      </button>
    </div> <!-- .ui-header-toolbar -->

<!-- period nav -->
    <div class="clearfix " style=" margin-right: 16px;">
      <button type="button" id="month_prev" onclick="navMonth(1);" class="mdl-button mdl-js-button mdl-button--icon toleft">
        <i class="material-icons">navigate_before</i>
      </button>
        <span class="mdl-tooltip" data-mdl-for="month_prev">Prejsù na <?php echo $kli_pume; ?></span>
      <button type="button" id="month_next" onclick="navMonth(2);" class="mdl-button mdl-js-button mdl-button--icon toleft">
        <i class="material-icons">navigate_next</i>
      </button>
        <span class="mdl-tooltip" data-mdl-for="month_next">Prejsù na <?php echo $kli_dume; ?></span>
      <button type="button" id="select_month" onclick="selectPeriod();" class="mdl-button mdl-js-button dropdown">
        <span><?php echo $vyb_ume; ?></span>
      </button>
    </div>



<!-- login user -->
    <ul class="ilogin-inline-list">
      <li class="mdl-color--indigo-400 ilogin-list-item item-avatar"><?php echo $kli_uzid; ?></li>
      <li class="ilogin-list-item" style="margin-left: 0;"><?php echo "$kli_uzmeno&nbsp;$kli_uzprie"; ?></li>
    </ul>
  </div><!-- .ui-header-title-row -->
</header>

<!-- more subs nav menu -->
<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="more_subs">
  <li onclick="Doprava();" class="mdl-menu__item">Doprava</li>
  <li onclick="Vyroba();" class="mdl-menu__item">V˝roba</li>
  <li onclick="Analyzy();" class="mdl-menu__item">Anal˝zy</li>
</ul>

<!-- more header tools -->
<div style="position:fixed; right: 32px; top: 56px; z-index: 10;">
  <ul for="more_tools" class="mdl-menu mdl-menu--bottom-right mdl-js-menu">
    <li id="account_checks" class="mdl-menu__item" onclick="AccountChecks();">Kontrola ˙Ëtovania</li>
    <li id="backup" class="mdl-menu__item" onclick="Backup();">Z·lohovanie d·t</li>
    <li id="calculator" class="mdl-menu__item" onclick="Calculator();">KalkulaËka</li>
  </ul>
</div>
















<main class="mdl-layout__content ui-content sticky-footer">
<div class="ui-container">
<div class="mdl-grid">
<!-- 1.column -->
  <div class="mdl-cell mdl-cell--4-col">
<!-- vstup dat -->
    <div id="vstup_data" class="card-module">
      <div class="card-module-header">
        <i class="material-icons">add_to_photos</i>
        <span class="card-module-title">Vstup d·t</span>
      </div>
      <ul class="card-module-content">
        <li id="odber_faktury" onclick="OdberFa();" class="card-item">OdberateæskÈ fakt˙ry</li>
        <li id="dodav_faktury" onclick="DodavFa();" class="card-item">Dod·vateæskÈ fakt˙ry</li>
        <li id="prijem_pokladna" onclick="PokladnicaPrijem();" class="card-item">PrÌjmovÈ pokladniËnÈ doklady</li>
        <li id="vydaj_pokladna" onclick="PokladnicaVydaj();" class="card-item">V˝davkovÈ pokladniËnÈ doklady</li>
        <li id="bank_vypisy" onclick="BankaVypisy();" class="card-item">BankovÈ v˝pisy</li>
        <li id="vseobec_doklady" onclick="VseoDoklady();" class="card-item">VöeobecnÈ ˙ËtovnÈ doklady</li>
      </ul>
    </div>
<!-- ekorobot -->
    <div id="ekorobot" class="card-module" style="background-color: transparent; box-shadow: none; padding-left: 56px;">
      <div class="card-module-content">
        <img src="obr/robot/robot3.jpg" onclick="showRobotMenu();" title="Ak m·te ûelanie, kliknite na mÚa" class="">
      </div>
    </div>
<!-- data podsystemy -->
    <div id="podsystem_data" class="card-module">
      <div onclick="PodsystemData();" class="card-module-header">
        <i class="material-icons">storage</i>
        <span class="card-module-title">D·ta z podsystÈmov</span>
      </div>
      <ul class="card-module-content">
        <li id="mzdy_data" onclick="MzdyData();" class="card-item">Mzdy a personalistika</li>
        <li id="sklad_data" onclick="SkladData();" class="card-item">Sklad</li>
        <li id="majetok_data" onclick="MajetokData();" class="card-item">Majetok</li>
      </ul>
    </div>
  </div> <!-- .mdl-cell -->

<!-- 2.column -->
  <div class="mdl-cell mdl-cell--4-col">
<!-- saldokonto -->
    <div id="saldo" class="card-module">
      <div onclick="Saldo();" class="card-module-header">
        <i class="material-icons">thumbs_up_down</i>
        <span class="card-module-title">Saldokonto</span>
      </div>
      <ul class="card-module-content">
        <li id="upomienky" onclick="Upomienky();" class="card-item">Upomienky</li>
        <li id="zapocty" onclick="Zapocty();" class="card-item">Vz·jomnÈ z·poËty</li>
        <li id="faktoring" onclick="Faktoring();" class="card-item">Faktoring</li>
        <li id="prikazy" onclick="Prikazy();" class="card-item">PrÌkazy na ˙hradu</li>
      </ul>
    </div>
<!-- vystupy -->
    <div id="vystupy" class="card-module">
      <div class="card-module-header">
        <i class="material-icons">call_made</i>
        <span class="card-module-title">V˝stupy</span>
      </div>
      <ul class="card-module-content">
        <li id="uct_zostavy" onclick="UctZostavy();" class="card-item">⁄ËtovnÈ zostavy
          <button id="account_report" class="mdl-button mdl-js-button mdl-button--icon" style="position: absolute; top: 2px; right: 24px;">
            <i class="material-icons md-dark">more_vert</i>
          </button>
        </li>
        <li>
          <ul for="account_report" class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
             style="" >
            <li id="obratovka" onclick="Obratovka();" class="mdl-menu__item">Obratov· predvaha</li>
            <li id="vysledovka" onclick="Vysledovka();" class="mdl-menu__item">V˝sledovka jednoduch·</li>
          </ul>
        </li>
        <li id="stat_vykazy" onclick="StatVykazy();" class="card-item">ätatistickÈ v˝kazy</li>
        <li id="dan_form" onclick="DanForms();" class="card-item">DaÚovÈ formul·re</li>
      </ul>
    </div>
<!-- dph -->
    <div id="dph" class="card-module">
      <div onclick="Dph();" class="card-module-header">
        <i class="material-icons">playlist_add</i>
        <span class="card-module-title">DaÚ z pridanej hodnoty</span>
      </div>
    </div>
<!-- cudzia mena -->
    <div id="mena" class="card-module">
      <div onclick="Mena();" class="card-module-header">
        <i class="material-icons">playlist_add</i>
        <span class="card-module-title">Cudzia mena</span>
      </div>
    </div>
  </div> <!-- mdl-cell -->

<!-- 3.column -->
  <div class="mdl-cell mdl-cell--4-col">
<!-- nastavenia -->
    <div id="nastavenia" class="card-module">
      <div class="card-module-header">
        <i class="material-icons">settings</i>
        <span class="card-module-title">Nastavenia</span>
      </div>
      <ul class="card-module-content">
        <li id="parametre" onclick="PrmUcto();" class="card-item">Parametre ˙ËtovnÌctva</li>
        <li id="osnova" onclick="UctOsn();" class="card-item">⁄Ëtov· osnova</li>
        <li id="dph_kody" onclick="DphKody();" class="card-item">KÛdy DPH</li>
        <li class="card-item">AnalytickÈ ˙Ëty
          <button id="account_analytical" class="mdl-button mdl-js-button mdl-button--icon" style="position: absolute; top: 2px; right: 24px; ">
            <i class="material-icons md-dark">more_vert</i>
          </button>
        </li>
        <li>
          <ul for="account_analytical" class="mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect">
            <li id="odber_ucty" onclick="OdberUcty();" class="mdl-menu__item">OdberateæskÈ ˙Ëty</li>
            <li id="dodav_ucty" onclick="DodavUcty();" class="mdl-menu__item">Dod·vateæskÈ ˙Ëty</li>
            <li id="pokladna_ucty" onclick="PokladnicaUcty();" class="mdl-menu__item">Pokladnice</li>
            <li id="banka_ucty" onclick="BankaUcty();" class="mdl-menu__item">BankovÈ ˙Ëty</li>
          </ul>
        </li>
      </ul>
    </div>
<!-- ciselniky -->
    <div id="firma_udaje" class="card-module">
      <div onclick="FirmaUdaje();" class="card-module-header">
        <i class="material-icons">home</i>
        <span class="card-module-title"><?php echo $fir_fnaz; ?></span>
      </div>
      <ul class="card-module-content">
        <li class="card-item clearfix" style="height: 48px; line-height: 1.4; padding-top: 8px;">
          <div class="toleft" style="min-width: 88px;">Firma ID<br><strong><?php echo $kli_vxcf; ?></strong></div>
          <div>Firma obdobie<br><strong><?php echo $kli_vrok; ?></strong></div>
        </li>
        <li id="cico" onclick="CisIco();" class="card-item">»ÌselnÌk I»O</li>
        <li onclick="" class="card-item">»ÌselnÌky
          <button id="codelist" class="mdl-button mdl-js-button mdl-button--icon" style="position: absolute; top: 2px; right: 24px;">
            <i class="material-icons md-dark">more_vert</i>
          </button>
        </li>
        <li>
          <ul for="codelist" class="mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect">
            <li id="strediska" onclick="Strediska();" class="mdl-menu__item">Stredisk·</li>
            <li id="zakazky" onclick="Zakazky();" class="mdl-menu__item">Z·kazky</li>
            <li id="skupiny" onclick="Skupiny();" class="mdl-menu__item">Skupiny</li>
            <li id="stavby" onclick="Stavby();" class="mdl-menu__item">Stavby</li>
          </ul>
        </li>
      </ul>
    </div>
  </div> <!-- .mdl-cell -->
</div> <!-- .mdl-grid -->
</div> <!-- .container -->

<div class="mdl-layout-spacer"></div>
<footer class="mdl-mini-footer ui-container">
  <div class="mdl-mini-footer__left-section">
    <div class="mdl-logo mdl-color-text--grey-500">© 2017 EuroSecom</div>
    <ul class="mdl-mini-footer__link-list">
      <li><a href="#" onclick="News();" title="Novinky v EuroSecom" class="mdl-color-text--light-blue-500">Novinky</a></li>
    </ul>
  </div>
  <div class="mdl-mini-footer__right-section">
    <ul class="mdl-mini-footer__link-list">
      <li><a href="#" onclick="Edcom();" title="EuroSecom powered by EDcom" class="mdl-color-text--light-blue-500">EDcom</a></li>
    </ul>
  </div>
</footer>
</main>












<!--   <div class="tiles-col-content">
   <img src="obr/robot/<?php echo $robot3; ?>.jpg" onclick="UkazLista(ekorobot);" title="Ak m·te ûelanie, kliknite na mÚa" class="ekorobot-xl">
  </div> -->


<?php
// zmena ume
if ( $copern == 23 OR $copern == 24 )
     {
?>
<div style="position:absolute; top:48px; left:10px; z-index: 100; background-color: lightgrey; padding: 16px;">

<FORM name="fir1" method="post" action="ucto_md.php?copern=25">
<select size="12" name="umes" id="umes" >
<option value="01.<?php echo $vyb_rok;?>" selected='selected'
 >01.<?php echo $vyb_rok;?></option>
<option value="02.<?php echo $vyb_rok;?>"
 >02.<?php echo $vyb_rok;?></option>
<option value="03.<?php echo $vyb_rok;?>"
 >03.<?php echo $vyb_rok;?></option>
<option value="04.<?php echo $vyb_rok;?>"
 >04.<?php echo $vyb_rok;?></option>
<option value="05.<?php echo $vyb_rok;?>"
 >05.<?php echo $vyb_rok;?></option>
<option value="06.<?php echo $vyb_rok;?>"
 >06.<?php echo $vyb_rok;?></option>
<option value="07.<?php echo $vyb_rok;?>"
 >07.<?php echo $vyb_rok;?></option>
<option value="08.<?php echo $vyb_rok;?>"
 >08.<?php echo $vyb_rok;?></option>
<option value="09.<?php echo $vyb_rok;?>"
 >09.<?php echo $vyb_rok;?></option>
<option value="10.<?php echo $vyb_rok;?>"
 >10.<?php echo $vyb_rok;?></option>
<option value="11.<?php echo $vyb_rok;?>"
 >11.<?php echo $vyb_rok;?></option>
<option value="12.<?php echo $vyb_rok;?>"
 >12.<?php echo $vyb_rok;?></option>
<INPUT type="hidden" id="firs" name="firs" value="<?php echo $vyb_xcf;?>" ><br>
<INPUT type="submit" id="umev" name="umev" value="Vybraù ˙ËtovnÈ obdobie" >
</FORM>
</div>
<?php
     }
//toto je koniec zmeny ume
?>

<?php
//select period
if ( $copern == 22 )
     {
$pole = explode(",", $kli_txt1);

$pole0 = explode("-", $pole[0]);
$kli_fmin0=$pole0[0];
$kli_fmax0=$pole0[1];
$akefirmy = "( xcf >= $kli_fmin0 AND xcf <= $kli_fmax0 )";

$pole1 = explode("-", $pole[1]);
$kli_fmin1=$pole1[0];
$kli_fmax1=$pole1[1];
$cislo=1*$kli_fmin1;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin1 AND xcf <= $kli_fmax1 )";

$pole2 = explode("-", $pole[2]);
$kli_fmin2=$pole2[0];
$kli_fmax2=$pole2[1];
$cislo=1*$kli_fmin2;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin2 AND xcf <= $kli_fmax2 )";

$pole3 = explode("-", $pole[3]);
$kli_fmin3=$pole3[0];
$kli_fmax3=$pole3[1];
$cislo=1*$kli_fmin3;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin3 AND xcf <= $kli_fmax3 )";

$pole4 = explode("-", $pole[4]);
$kli_fmin4=$pole4[0];
$kli_fmax4=$pole4[1];
$cislo=1*$kli_fmin4;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin4 AND xcf <= $kli_fmax4 )";

$pole5 = explode("-", $pole[5]);
$kli_fmin5=$pole5[0];
$kli_fmax5=$pole5[1];
$cislo=1*$kli_fmin5;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin5 AND xcf <= $kli_fmax5 )";

$pole6 = explode("-", $pole[6]);
$kli_fmin6=$pole6[0];
$kli_fmax6=$pole6[1];
$cislo=1*$kli_fmin6;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin6 AND xcf <= $kli_fmax6 )";

$pole7 = explode("-", $pole[7]);
$kli_fmin7=$pole7[0];
$kli_fmax7=$pole7[1];
$cislo=1*$kli_fmin7;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin7 AND xcf <= $kli_fmax7 )";

$pole8 = explode("-", $pole[8]);
$kli_fmin8=$pole8[0];
$kli_fmax8=$pole8[1];
$cislo=1*$kli_fmin8;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin8 AND xcf <= $kli_fmax8 )";

$pole9 = explode("-", $pole[9]);
$kli_fmin9=$pole9[0];
$kli_fmax9=$pole9[1];
$cislo=1*$kli_fmin9;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin9 AND xcf <= $kli_fmax9 )";

if( $akefirmy == "( xcf >= 0 AND xcf <= 0 )" ) { $setuzfir = include("cis/vybuzfir.php"); }

$setuzrok = include("cis/citajrok.php");

$sql = mysql_query("SELECT xcf,naz,rok FROM $mysqldbfir.fir WHERE ( $akefirmy ) AND SUBSTRING(prav,$kli_uzid,1) != 'n' AND rok > $citajrok ORDER BY xcf");
// celkom poloziek
// $cpol = mysql_num_rows($sql);
?>
<div style="position:absolute; top:48px; left:10px; z-index: 100; background-color: lightgrey; padding: 16px;">
<FORM name="fir1" method="post" action="ucto_md.php?copern=23" >
<select size="10" name="firs" id="firs" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["xcf"];?>"
<?php
if ( $zaznam["xcf"] == $vyb_xcf ) echo " selected='selected'";
$umes1="1.".$zaznam["rok"]
?>
 ><?php echo $zaznam["xcf"];?> - <?php echo $zaznam["naz"];?></option>
<?php endwhile;?>
</select>
<INPUT type="hidden" id="umes" name="umes" value="<?php echo $umes1;?>" ><br>
<INPUT type="submit" id="firv" name="firv" value="Vybraù ˙Ëtovn˙ jednotku" >
</FORM>
</div>
<?php
mysql_close();
mysql_free_result($sql);
// toto je koniec zmeny firmy
     }

$akyrobot = include("akyrobot.php");
?>


<!-- <div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 200; top: 200; left: 40; width:60; height:100;">
<img border=0 src='../obr/robot/<?php echo $robot3;?>.jpg' style='' onClick="zobraz_robotmenu();"
 alt='Dobr˝ deÚ , ja som V·ö EkoRobot , ak m·te ot·zku alebo nejakÈ ûelanie kliknite na mÚa prosÌm 1x myöou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 alt='Zhasni EkoRobota' >
</div>
<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 150; left: 90; width:200; height:100;">
zobrazene menu
</div> -->




</div> <!-- .mdl-layout -->


<?php
//$robot=1;
//celkovy koniec dokumentu
       } while (false);
?>





<script type="text/javascript">
//blank window
var param = 'scrollbars=yes,resizable=yes,top=0,left=0,width=1080,height=900'; //dopyt, premenn˙ do eng a neskÙr pouûiù

//month nav
  function navMonth(kam)
  {
    window.open('../cis/zmenume.php?odkaz=<?php echo $odkaz64; ?>&copern=' + kam + '', '_self');
  }
<?php if ( $kli_vmes == 1 ) { ?> document.getElementById('month_prev').disabled = true; <?php } ?>
<?php if ( $kli_vmes == 12 ) { ?> document.getElementById('month_next').disabled = true; <?php } ?>





//subsystems
  function Ucto()
  {
    window.open('ucto_md.php?copern=1', '_self');
  }
  function Mzdy()
  {
    window.open('mzdy_md.php?copern=1', '_self');
  }
  function Odbyt()
  {
    window.open('faktury_md.php?copern=1', '_self');
  }
  function Sklad()
  {
    window.open('sklad_md.php?copern=1', '_self');
  }
  function Majetok()
  {
    window.open('majetok_md.php?copern=1', '_self');
  }
  function Doprava()
  {
    window.open('doprava_md.php?copern=1', '_self');
  }
  function Vyroba()
  {
    window.open('vyroba_md.php?copern=1', '_self');
  }
  function Analyzy()
  {
    window.open('analyzy_md.php?copern=1', '_self');
  }

//tools
  function Searching()
  {
    window.open('../ucto/uctohladaj_md.php?copern=1&sysx=UCT', '_blank');
  }
  function Transfer()
  {
    window.open('../cis/prenos_md.php?copern=10&upozorni2011=1&upozorni2012=1&upozorni2013=1', '_blank');
  }
  function AccountChecks()
  {
    window.open('../ucto/ucto_kontrol_md.php?copern=40&drupoh=1&page=1', '_blank'); //page=1 nebude treba, otestovaù bez drupoh
  }
  function Backup()
  {
    window.open('../cis/zaldat_ucto_md.php?copern=101', '_blank');
  }
  function Calculator()
  {
    window.open('../ucto/calculator_md.php?copern=5', '_blank');
  }

//vstup dat
  function OdberFa()
  {
    window.open('../faktury/vstfak_md.php?copern=1&drupoh=1001&page=1&pocstav=0', '_blank');
  }
  function DodavFa()
  {
    window.open('../faktury/vstfak_md.php?copern=1&drupoh=1002&page=1&pocstav=0', '_blank');
  }
  function PokladnicaPrijem()
  {
    window.open('../ucto/vstpok_md.php?copern=1&drupoh=1&page=1&sysx=UCT', '_blank');
  }
  function PokladnicaVydaj()
  {
    window.open('../ucto/vstpok_md.php?copern=1&drupoh=2&page=1&sysx=UCT', '_blank');
  }
  function BankaVypisy()
  {
    window.open('../ucto/vstban_md.php?copern=1&page=1', '_blank');
  }
  function VseoDoklady()
  {
    window.open('../ucto/vstvse_md.php?copern=1&page=1', '_blank');
  }
//data podsystemy
  function PodsystemData()
  {
    window.open('../ucto/podsys_md.php?copern=1&sysx=UCT', '_blank');
  }
  function MzdyData()
  {
    window.open('../ucto/podsys_md.php?copern=308&drupoh=1&page=1', '_blank'); /*dopyt, page=1 nebude maù v˝znam, pretoûe tam nie je str·nkovanie*/
  }
  function MajetokData()
  {
    window.open('../ucto/podsys_md.php?copern=308&drupoh=2&page=1', '_blank'); /*dopyt, page=1 nebude maù v˝znam, pretoûe tam nie je str·nkovanie*/
  }
  function SkladData()
  {
    window.open('../ucto/podsys_md.php?copern=308&drupoh=3&page=1', '_blank'); /*dopyt, page=1 nebude maù v˝znam, pretoûe tam nie je str·nkovanie*/
  }
//saldokonto
  function Saldo()
  {
    window.open('../ucto/saldo_md.php?copern=1&sysx=UCT&typhtml=0', '_blank');
  }
  function Upomienky()
  {
    window.open('../ucto/saldo_md.php?copern=1&sysx=UCT&typhtml=1&cinnost=1', '_blank');
  }
  function Zapocty()
  {
    window.open('../ucto/saldo_md.php?copern=1&sysx=UCT&typhtml=1&cinnost=8', '_blank');
  }
  function Faktoring()
  {
    window.open('../ucto/saldo_md.php?copern=1&sysx=UCT&typhtml=1&cinnost=6', '_blank');
  }
  function Prikazy()
  {
    window.open('../ucto/prikazy_md.php?copern=1&page=1&sysx=UCT', '_blank');
  }
//vystupy
  function UctZostavy()
  {
    window.open('../ucto/uctzos_md.php?copern=1&sysx=UCT', '_blank');
  }
  function Obratovka()
  {
    window.open('../ucto/uobrat_md.php?copern=10&drupoh=1&page=1&typ=HTML', '_blank'); /*dopyt, page=1 zbytoËnÈ, buÔ copern alebo typ pouûiù a drupoh preveriù*/
  }
  function Vysledovka()
  {
    window.open('../ucto/vys_mala_md.php?copern=10&h_obdp=1&h_obdk=1&drupoh=1&page=1&typ=PDF&vyb_ume=1.2016&obdx=1', '_blank');
  }
  function StatVykazy()
  {
    window.open('../ucto/statzos_md.php?copern=1&sysx=UCT', '_blank');
  }
  function DanForms()
  {
    window.open('../ucto/danzos_md.php?copern=1&sysx=UCT', '_blank');
  }
//dph
  function Dph()
  {
    window.open('../ucto/dph_md.php?copern=1', '_blank');
  }
//mena
  function Mena()
  {
    window.open('../ucto/mena_md.php?copern=1&drupoh=1&sysx=UCT', '_blank');
  }
//nastavenia
  function PrmUcto()
  {
    window.open('../cis/prmpodsys_md.php?copern=91', '_blank');
  }
  function UctOsn()
  {
    window.open('../ucto/uctosn_md.php?copern=1&page=1', '_blank');
  }
  function DphKody()
  {
    window.open('../ucto/drudan_md.php?copern=1&page=1', '_blank');
  }
  function OdberUcty()
  {
    window.open('../faktury/dodb_md.php?copern=1&page=1', '_blank');
  }
  function DodavUcty()
  {
    window.open('../faktury/ddod_md.php?copern=1&page=1', '_blank');
  }
  function PokladnicaUcty()
  {
    window.open('../ucto/dpok_md.php?copern=1&page=1', '_blank');
  }
  function BankaUcty()
  {
    window.open('../ucto/dban_md.php?copern=1&page=1', '_blank');
  }
//ciselniky
  function FirmaUdaje()
  {
    window.open('../cis/ufir_md.php?copern=1', '_blank');
  }
  function CisIco()
  {
    window.open('../cis/cico_md.php?copern=1&page=1', '_blank');
  }
  function Strediska()
  {
    window.open('../cis/cstr_md.php?copern=1&page=1', '_blank');
  }
  function Zakazky()
  {
    window.open('../cis/czak_md.php?copern=1&page=1', '_blank');
  }
  function Skupiny()
  {
    window.open('../cis/csku_md.php?copern=1&page=1', '_blank');
  }
  function Stavby()
  {
    window.open('../cis/csta_md.php?copern=1&page=1', '_blank');
  }



























//ekorobot
  function showRobotMenu()
  {
    robotmenu.style.display='block';
  }
  function hideRobotMenu()
  {
    robotmenu.style.display='none';
  }





  function NacitajKurzDnes()
  {
   window.open('../cis/stiahni_ecb.php?copern=1010', '_blank');
  }
  function NacitajKurz90()
  {
   window.open('../cis/stiahni_ecb.php?copern=1010&dni90=1', '_blank');
  }

<?php
$rokdph=2014;
if ( $vyb_rok <= 2013 ) { $rokdph=2013; }
if ( $vyb_rok <= 2012 ) { $rokdph=2012; }
?>
  function KontrolaDph() //dopyt, bude presunute vyssie
  {
   window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?copern=40&drupoh=1&page=1&chyby=1', '_blank'); //page=1 nebude treba, otestovaù bez drupoh
  }
  function TlacDph()
  {
   window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?copern=10&drupoh=1&page=1fir_uctx01=0&h_drp=1&h_dap=&h_arch=0', '_blank'); //page=1 nebude treba, otestovaù bez drupoh
  }

  function KurzListok() //dopyt, moûno zruöÌm
  {
   window.open('../ucto/kurzy.php?copern=1&page=1', '_blank');
  }


//select firm/month
  function selectFirm()
  {
    window.open('ucto_md.php?copern=22', '_self');
  }
  function selectPeriod()
  {
    window.open('ucto_md.php?copern=24', '_self');
  }












</script>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>