<?PHP
session_start();
$_SESSION['ucto_sys'] = 1;
$_SESSION['pocstav'] = 0; /*dopyt, nebude treba v bud˙cnosti, nebudem rozliöovaù*/
?>
<!doctype html>
<html>
<?php

// cislo operacie
$copern = 1*$_REQUEST['copern'];
//$newmenu = 1*$_REQUEST['newmenu'];
//if( $_SESSION['chrome'] == 0 ) { $newmenu = 0; }
//if( $_SESSION['nieie'] == 1 ) { $newmenu = 1; }
//$copern = 1*$_REQUEST['copern'];
$parwin="width=' + sirkawin + ', height=' + vyskawin + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes"; //dopyt, pÙjde preË
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes"; //dopyt, pÙjde preË
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes"; //dopyt, pÙjde preË

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

$query="START TRANSACTION;";
$trans = mysql_query($query);

$zmazane = mysql_query("DELETE FROM $mysqldbfir.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldbfir.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");

if ( $ulozene )
{
$query="COMMIT;";
$trans = mysql_query($query);
}
if ( !$ulozene )
{
$query="ROLLBACK;";
$trans = mysql_query($query);
}

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



</style>
</head>
<body> <!-- dopyt, rieöiù cez .js -->
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--no-drawer-button">
<header class="mdl-layout__header mdl-layout__header--waterfall">
  <div class="mdl-layout__header-row mdl-color--light-blue-600 ">
    <span class="mdl-layout-title mdl-color-text--yellow-A100">EuroSecom</span>&nbsp;
<?php
//first login new user
if ( $vyb_xcf == '' ) { $copern=22; } //dopyt, preveriù
?>

<?php
//change firm
//$btn_action="noactive";
//if ( $copern == 22 ) $btn_action="active";
?>
    <button type="button" id="show-dialog" onclick="window.open('ucto_md.php?copern=22', '_self');" class="mdl-button mdl-js-button mdl-color--light-blue-700" style="font-family: unset; color: rgba(255,255,255,.7); letter-spacing: 0.02em;">
      <strong class="mdl-color-text--white"><?php echo $vyb_xcf; ?></strong>&nbsp;
      <span class="mdl-color-text--white" style="text-transform: none; font-weight: 400;"><?php echo $vyb_naz; ?></span>
      <i class="material-icons vacenter">arrow_drop_down</i>
    </button>
 <a href="ucto_md.php?copern=24" title="Vybraù ˙ËtovnÈ obdobie" class="dropdown-toggle <?php echo $active; ?>">&nbsp;<?php echo $vyb_ume; ?><i class="material-icons md-18 toright">arrow_drop_down</i></a>

    <div class="mdl-layout-spacer"></div>
    <button type="button" id="ilogin_user" class="mdl-button mdl-js-button mdl-button--icon mdl-color--indigo-400 mdl-color-text--blue-grey-50 avatar"><?php echo $kli_uzid; ?></button>&nbsp;&nbsp;
    <span class="mdl-color-text--blue-grey-50"><?php echo "$kli_uzmeno $kli_uzprie"; ?></span>
  </div>
<!-- Tabs -->
  <div class="mdl-layout__tab-bar" style="">
    <a href="#" onclick="Ucto();" class="mdl-layout__tab is-active">⁄ËtovnÌctvo
<?php
if ( $vyb_duj == 0 ) { echo "podvojnÈ"; }
if ( $vyb_duj == 9 ) { echo "jednoduchÈ"; }
?>
    </a>
    <a href="#" onclick="Mzdy();" class="mdl-layout__tab">Mzdy</a>
    <a href="#" onclick="Odbyt();" class="mdl-layout__tab">Odbyt</a>
    <a href="#" onclick="Sklad();" class="mdl-layout__tab">Sklad</a>
    <a href="#" onclick="Majetok();" class="mdl-layout__tab">Majetok</a>
    <a href="#" onclick="Doprava();" class="mdl-layout__tab">Doprava</a>
    <a href="#" onclick="Vyroba();" class="mdl-layout__tab">Vyroba</a>
    <a href="#" onclick="Analyzy();" class="mdl-layout__tab">Anal˝zy</a>
    <div class="mdl-layout-spacer"></div>
    <a href="#" id="settings" class="mdl-layout__tab" style="text-transform: none; padding: 0 8px;">Nastavenia<i class="material-icons vacenter">arrow_drop_down</i></a>
    <a href="#" id="codelist" class="mdl-layout__tab" style="text-transform: none; padding: 0 8px;">»ÌselnÌky<i class="material-icons vacenter">arrow_drop_down</i></a>
    <a href="#" id="tools" class="mdl-layout__tab" style="text-transform: none; padding: 0 8px;">N·stroje<i class="material-icons vacenter">arrow_drop_down</i></a>
  </div> <!-- tabs -->
</header>

<!-- select firm and period -->
<?php
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
if ( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin1 AND xcf <= $kli_fmax1 )";

$pole2 = explode("-", $pole[2]);
$kli_fmin2=$pole2[0];
$kli_fmax2=$pole2[1];
$cislo=1*$kli_fmin2;
if ( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin2 AND xcf <= $kli_fmax2 )";

$pole3 = explode("-", $pole[3]);
$kli_fmin3=$pole3[0];
$kli_fmax3=$pole3[1];
$cislo=1*$kli_fmin3;
if ( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin3 AND xcf <= $kli_fmax3 )";

$pole4 = explode("-", $pole[4]);
$kli_fmin4=$pole4[0];
$kli_fmax4=$pole4[1];
$cislo=1*$kli_fmin4;
if ( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin4 AND xcf <= $kli_fmax4 )";

$pole5 = explode("-", $pole[5]);
$kli_fmin5=$pole5[0];
$kli_fmax5=$pole5[1];
$cislo=1*$kli_fmin5;
if ( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin5 AND xcf <= $kli_fmax5 )";

$pole6 = explode("-", $pole[6]);
$kli_fmin6=$pole6[0];
$kli_fmax6=$pole6[1];
$cislo=1*$kli_fmin6;
if ( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin6 AND xcf <= $kli_fmax6 )";

$pole7 = explode("-", $pole[7]);
$kli_fmin7=$pole7[0];
$kli_fmax7=$pole7[1];
$cislo=1*$kli_fmin7;
if ( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin7 AND xcf <= $kli_fmax7 )";

$pole8 = explode("-", $pole[8]);
$kli_fmin8=$pole8[0];
$kli_fmax8=$pole8[1];
$cislo=1*$kli_fmin8;
if ( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin8 AND xcf <= $kli_fmax8 )";

$pole9 = explode("-", $pole[9]);
$kli_fmin9=$pole9[0];
$kli_fmax9=$pole9[1];
$cislo=1*$kli_fmin9;
if ( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin9 AND xcf <= $kli_fmax9 )";

if ( $akefirmy == "( xcf >= 0 AND xcf <= 0 )" ) { $setuzfir = include("cis/vybuzfir.php"); }

$sql = mysql_query("SELECT xcf,naz FROM $mysqldbfir.fir WHERE ( $akefirmy ) AND SUBSTRING(prav,$kli_uzid,1) != 'n' ORDER BY xcf");
//celkom poloziek
//$cpol = mysql_num_rows($sql);
?>
<FORM name="fir1" method="post" action="ucto_md.php?copern=23">
<div class="mdl-color--grey-50" style="box-shadow: 0 7px 8px -4px rgba(0,0,0,0.2), 0 13px 19px 2px rgba(0,0,0,0.14), 0 5px 24px 4px rgba(0,0,0,0.12); color: rgba(0,0,0,0.87); font-size: 13px; max-width: 768px; min-width: 512px; opacity: 1; position: relative; overflow: auto;  ">
  <div class="modal-title " style="font-size: 20px; letter-spacing: 0.02em; height: 24px; margin: 12px 24px 12px 24px;">V˝ber firmy</div>
  <div class="modal-content" style="padding: 0 24px 24px 24px;">
    <div>
      <table style="width: 100%; " style="overflow: auto;">
        <tr style="height: 24px;">
          <th class="right" style="width: 10%;">»Ìslo</th>
          <th style="width: 90%;">N·zov</th>
        </tr>
<style>
.selected {
  font-weight: 500;
}
</style>
<?php
while($zaznam=mysql_fetch_array($sql)):
if ( $zaznam["xcf"] == $vyb_xcf ) { $class = 'selected'; }
?>
        <tr class="<?php echo $class; ?>" style="font-size: 13px; height: 32px; padding: 3px 0; border-top: 1px solid lightgrey; border-bottom: 1px solid lightgrey;">
          <td class="right"><?php echo $zaznam["xcf"]; ?></td>
          <td>&nbsp;<?php echo $zaznam["naz"]; ?></td>
        </tr>
<?php endwhile; ?>
      </table>
    </div>
  </div>
  <div class="modal-action" style="height: 48px;">
    <INPUT type="hidden" id="umes" name="umes" value="<?php echo $umes1; ?>">
    <button id="firv" name="firv" class="mdl-button">Vybraù</button>
  </div>
</div>
</FORM>



<FORM name="fir1" method="post" action="ucto_md.php?copern=23">
<select name="firs" id="firs" size="10"> <!-- dopyt, nahradiù size -->
<?php while($zaznam=mysql_fetch_array($sql)): ?>
 <option value="<?php echo $zaznam["xcf"]; ?>"
<?php
if ( $zaznam["xcf"] == $vyb_xcf ) echo " selected='selected'";
$umes1="1.".$zaznam["rok"] //dopyt, neviem kde zaradiù
?>><?php echo $zaznam["xcf"].$zaznam["naz"]; ?>
 </option>
<?php endwhile; ?>
</select>
<INPUT type="hidden" id="umes" name="umes" value="<?php echo $umes1; ?>">
<button id="firv" name="firv" >Vybraù</button>

</FORM>



<?php
mysql_close();
mysql_free_result($sql);
//koniec zmena firmy
     }

?>





<?php
//zmena obdobia
if ( $copern == 23 OR $copern == 24 )
     {
?>
<FORM name="fir1" method="post" action="ucto_md.php?copern=25">
<select size="12" name="umes" id="umes">
 <option value="01.<?php echo $vyb_rok; ?>" selected="selected">01.<?php echo $vyb_rok; ?></option>
 <option value="02.<?php echo $vyb_rok; ?>">02.<?php echo $vyb_rok; ?></option>
 <option value="03.<?php echo $vyb_rok; ?>">03.<?php echo $vyb_rok; ?></option>
 <option value="04.<?php echo $vyb_rok; ?>">04.<?php echo $vyb_rok; ?></option>
 <option value="05.<?php echo $vyb_rok; ?>">05.<?php echo $vyb_rok; ?></option>
 <option value="06.<?php echo $vyb_rok; ?>">06.<?php echo $vyb_rok; ?></option>
 <option value="07.<?php echo $vyb_rok; ?>">07.<?php echo $vyb_rok; ?></option>
 <option value="08.<?php echo $vyb_rok; ?>">08.<?php echo $vyb_rok; ?></option>
 <option value="09.<?php echo $vyb_rok; ?>">09.<?php echo $vyb_rok; ?></option>
 <option value="10.<?php echo $vyb_rok; ?>">10.<?php echo $vyb_rok; ?></option>
 <option value="11.<?php echo $vyb_rok; ?>">11.<?php echo $vyb_rok; ?></option>
 <option value="12.<?php echo $vyb_rok; ?>">12.<?php echo $vyb_rok; ?></option>
</select>
<INPUT type="hidden" id="firs" name="firs" value="<?php echo $vyb_xcf; ?>">
<button type="submit" id="umev" name="umev">Vybraù</button>
</FORM>
<?php
    }
//koniec zmena obdobia
?>





<!-- nastavenia nav menu -->
<ul for="settings" class="mdl-menu mdl-menu--bottom-left mdl-js-menu" style="">
  <li class="mdl-menu__item" onclick="PrmUcto();">Parametre ˙ËtovnÌctva</li>
  <li class="mdl-menu__item" onclick="UctOsn();">⁄Ëtov· osnova</li>
  <li class="mdl-menu__item" onclick="DphDruh();">KÛdy DPH</li>
  <li class="mdl-menu__item" onclick="PoklDruh();">Pokladnice</li>
  <li class="mdl-menu__item" onclick="OdberDruh();">OdberateæskÈ ˙Ëty</li>
  <li class="mdl-menu__item" onclick="DodavDruh();">Dod·vateæskÈ ˙Ëty</li>
  <li class="mdl-menu__item" onclick="BanDruh();">BankovÈ ˙Ëty</li>
  <li class="mdl-menu__item" onclick="Ufir();">⁄daje o firme</li>
  <li class="mdl-menu__item" onclick="NastavAutouct();">Ekorobot nastavenie</li>
  <li class="mdl-menu__item" onclick="PredvolText();">PredvolenÈ texty</li>
</ul>

<!-- ciselniky nav menu -->
<ul for="codelist" class="mdl-menu mdl-menu--bottom-left mdl-js-menu" style="">
  <li class="mdl-menu__item" onclick="CisIco();">»ÌselnÌk I»O</li>
  <li class="mdl-menu__item" onclick="Strediska();">»ÌselnÌk stredÌsk</li>
  <li class="mdl-menu__item" onclick="Zakazky();">»ÌselnÌk z·kaziek</li>
  <li class="mdl-menu__item" onclick="Skupiny();">»ÌselnÌk skupÌn</li>
  <li class="mdl-menu__item" onclick="Stavby();">»ÌselnÌk stavieb</li>
  <li class="mdl-menu__item" onclick="Ezakaznik();">E-z·kaznÌci</li>
</ul>

<!-- nastroje nav menu -->
<ul for="tools" class="mdl-menu mdl-menu--bottom-right mdl-js-menu" style="">
  <li class="mdl-menu__item" onclick="PrenosPoc();">Prenos poËiatkov</li>
  <li class="mdl-menu__item" onclick="ZalDat();">Z·lohovanie d·t</li>
  <li class="mdl-menu__item" onclick="Users();">Kontrola ˙Ëtovania</li>
  <li class="mdl-menu__item" onclick="Kalkulacka();">KalkulaËka</li>
</ul>

<main class="mdl-layout__content mdl-color--blue-grey-50">
  <div class="mdl-grid" style="">
    <div class="mdl-cell mdl-cell--3-col clearfix" style="padding: 0 0;">
      <div class="" style="font-size: 12px;">Vstup d·t</div>
      <div class="mdl-shadow--2dp mdl-color--white " style=" padding: 4px 4px 4px 4px; width: 46%; margin: 8px 2%; float: left;">
        <div class="material-icons md-18 right full-width" style="">open_in_new</div>
        <div class="material-icons md-40 mdl-color-text--blue-500 center full-width" style="padding: 8px 0 24px 0; ">account_balance</div>
        <div class="center " style="font-size: 12px; letter-spacing: 0.02em; line-height: 1.2; ">OdberateæskÈ fakt˙ry</div>
      </div>
      <div class="mdl-shadow--2dp mdl-color--white " style=" padding: 4px 4px 4px 4px; width: 46%; margin: 8px 2%; float: left;">
        <div class="material-icons md-18 right full-width" style="">open_in_new</div>
        <div class="material-icons md-40 mdl-color-text--blue-500 center full-width" style="padding: 8px 0 24px 0; ">account_balance</div>
        <div class="center " style="font-size: 12px; letter-spacing: 0.02em; line-height: 1.2; ">Dod·vateæskÈ fakt˙ry</div>
      </div>
      <div class="mdl-shadow--2dp mdl-color--white " style=" padding: 4px 4px 4px 4px; width: 46%; margin: 8px 2%; float: left;">
        <div class="material-icons md-18 right full-width" style="">open_in_new</div>
        <div class="material-icons md-40 mdl-color-text--blue-500 center full-width" style="padding: 8px 0 24px 0; ">account_balance</div>
        <div class="center " style="font-size: 12px; letter-spacing: 0.02em; line-height: 1.2; ">PrÌjmovÈ pokladniËnÈ doklady</div>
      </div>
      <div class="mdl-shadow--2dp mdl-color--white " style=" padding: 4px 4px 4px 4px; width: 46%; margin: 8px 2%; float: left;">
        <div class="material-icons md-18 right full-width" style="">open_in_new</div>
        <div class="material-icons md-40 mdl-color-text--blue-500 center full-width" style="padding: 8px 0 24px 0; ">account_balance</div>
        <div class="center " style="font-size: 12px; letter-spacing: 0.02em; line-height: 1.2; ">V˝davkovÈ pokladniËnÈ doklady</div>
      </div>
      <div class="mdl-shadow--2dp mdl-color--white " style=" padding: 4px 4px 4px 4px; width: 46%; margin: 8px 2%; clear: both;">
        <div class="material-icons md-18 right full-width" style="">open_in_new</div>
        <div class="material-icons md-40 mdl-color-text--blue-500 center full-width" style="padding: 8px 0 24px 0; ">account_balance</div>
        <div class="center " style="font-size: 12px; letter-spacing: 0.02em; line-height: 1.2; ">BankovÈ doklady</div>
      </div>
      <div class="mdl-shadow--2dp mdl-color--white" style=" padding: 4px 4px 4px 4px; width: 46%; margin: 8px 2%; ">
        <div class="material-icons md-18 right full-width" style="">open_in_new</div>
        <div class="material-icons md-40 mdl-color-text--blue-500 center full-width" style="padding: 8px 0 24px 0; ">account_balance</div>
        <div class="center " style="font-size: 12px; letter-spacing: 0.02em; line-height: 1.2; ">VöeobecnÈ doklady</div>
      </div>



    </div> <!-- .mdl-cell -->

    <div class="mdl-cell mdl-cell--3-col" style="padding: 0 32px;">
      <div style="font-size: 12px;">MesaËnÈ spracovanie</div>
    </div>

    <div class="mdl-cell mdl-cell--3-col" style="padding: 0 16px;">
      <div style="font-size: 12px;">Inform·cie</div>
    </div>

    <div class="mdl-cell mdl-cell--3-col" style="padding: 0 16px;">
      <div style="font-size: 12px;">EkoRobot</div>
    </div>
<?php $akyrobot = include("akyrobot.php"); //dopyt, prerobiù, css sprite
 ?>


    <div class="mdl-cell mdl-cell--2-col ">



    </div>



<!--   <div class="tiles-col-content">
   <img src="obr/robot/<?php echo $robot3; ?>.jpg" onclick="UkazLista(ekorobot);" title="Ak m·te ûelanie, kliknite na mÚa" class="ekorobot-xl">
  </div> -->




  </div> <!-- .mdl-grid -->
</main>




















<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 200; top: 200; left: 40; width:60; height:100;">
<img border=0 src='../obr/robot/<?php echo $robot3;?>.jpg' style='' onClick="zobraz_robotmenu();"
 alt='Dobr˝ deÚ , ja som V·ö EkoRobot , ak m·te ot·zku alebo nejakÈ ûelanie kliknite na mÚa prosÌm 1x myöou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 alt='Zhasni EkoRobota' >
</div>
<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 150; left: 90; width:200; height:100;">
zobrazene menu
</div>




</div> <!-- .mdl-layout -->

<?php
$robot=1;
$zmenume=1; $odkaz="../podvojneu.php?copern=1&newmenu=$newmenu";



//celkovy koniec dokumentu
       } while (false);
?>



<script type="text/javascript">
//dimensions blank window
var param = 'scrollbars=yes,resizable=yes,top=0,left=0,width=1080,height=900'; //dopyt, premenn˙ do eng a neskÙr pouûiù

//preklikavanie mesiacov
<?php
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
?>
  function ZmenMesiac(kam)
  {
   window.open('../cis/zmenume.php?odkaz=<?php echo $odkaz64; ?>&copern=' + kam + '', '_self');
  }

//vstup dat
  function OdberFa()
  {
   window.open('../faktury/vstfak_new.php?copern=1&drupoh=1001&page=1&pocstav=0', '_blank');
  }
  function DodavFa()
  {
   window.open('../faktury/vstfak_new.php?copern=1&drupoh=1002&page=1&pocstav=0', '_blank');
  }
  function PrijPokl()
  {
   window.open('../ucto/vstpok_new.php?copern=1&drupoh=1&page=1&sysx=UCT', '_blank');
  }
  function VydavPokl()
  {
   window.open('../ucto/vstpok_new.php?copern=1&drupoh=2&page=1&sysx=UCT', '_blank');
  }
  function BankVyp()
  {
   window.open('../ucto/vstban_new.php?copern=1&drupoh=4&page=1&sysx=UCT', '_blank');
  }
  function VseoDokl()
  {
   window.open('../ucto/vstvse_new.php?copern=1&drupoh=5&page=1&sysx=UCT', '_blank');
  }
//mesacne
  function UctZos()
  {
   window.open('../ucto/meszos_new.php?copern=1&sysx=UCT', '_blank');
  }
  function StatVyk()
  {
   window.open('../ucto/statzos_new.php?copern=1&sysx=UCT', '_blank');
  }
  function UprPodsys()
  {
   window.open('../ucto/oprsys_new.php?copern=1&sysx=UCT', '_blank');
  }
  function DanZos()
  {
   window.open('../ucto/danprij_new.php?copern=1&sysx=UCT', '_blank');
  }
  function DphZos()
  {
//   var okno =;
// dopyt, dorobiù
  }
//informacie
  function UctPohyby()
  {
   window.open('../ucto/uctpohyby_new.php?copern=1&sysx=UCT', '_blank');
  }
  function HladajDokl()
  {
   window.open('../ucto/hladaj_dok_new.php?copern=1&sysx=UCT', '_blank');
  }
  function Saldo()
  {
   window.open('../ucto/saldo_new.php?copern=1&sysx=UCT&typhtml=0', '_blank');
  }
  function RucneSpar()
  {
   window.open('../ucto/saldo_new.php?copern=1&sysx=UCT&typhtml=1&cinnost=9', '_blank');
  }
  function VzajZap()
  {
   window.open('../ucto/saldo_new.php?copern=1&sysx=UCT&typhtml=1&cinnost=8', '_blank');
  }
  function PrikUhr()
  {
   window.open('../ucto/vstpru_new.php?copern=1&page=1&sysx=UCT', '_blank');
  }
  function Faktoring()
  {
   window.open('../ucto/saldo_new.php?copern=1&sysx=UCT&typhtml=1&cinnost=6', '_blank');
  }
  function Upomienka()
  {
   window.open('../ucto/saldo_new.php?copern=1&sysx=UCT&typhtml=1&cinnost=1', '_blank');
  }
  function Cudzie()
  {
   window.open('../ucto/cudzie_new.php?copern=1&drupoh=1&sysx=UCT', '_blank');
  }
  function KurzListok() //dopyt, moûno zruöÌm
  {
   window.open('../ucto/kurzy.php?copern=1&page=1', '_blank');
  }
  function ZozDokl()
  {
   window.open('../ucto/prhdok.php?copern=1&sysx=UCT', '_blank');
  }
//nastavenia
  function PrmUcto()
  {
   window.open('../cis/ufir_new.php?copern=91', '_blank');
  }
  function UctOsn()
  {
   window.open('../ucto/uctosn_new.php?copern=1&page=1', '_blank');
  }
  function DphDruh()
  {
   window.open('../ucto/drudan_new.php?copern=1&page=1', '_blank');
  }
  function OdberDruh()
  {
   window.open('../faktury/dodb_new.php?copern=1&page=1', '_blank');
  }
  function DodavDruh()
  {
   window.open('../faktury/ddod_new.php?copern=1&page=1', '_blank');
  }
  function PoklDruh()
  {
   window.open('../ucto/dpok_new.php?copern=1&page=1', '_blank');
  }
  function BanDruh()
  {
   window.open('../ucto/dban_new.php?copern=1&page=1', '_blank');
  }
  function OdberPoc()
  {
   window.open('../faktury/vstfak_new.php?copern=1&drupoh=1001&page=1&pocstav=1', '_blank');
  }
  function DodavPoc()
  {
   window.open('../faktury/vstfak_new.php?copern=1&drupoh=1002&page=1&pocstav=1', '_blank');
  }
  function UhradyPoc()
  {
   window.open('../ucto/oprsys_new.php?copern=308&drupoh=8', '_blank');
  }
  function PredvolText()
  {
   window.open('../faktury/ftexty_new.php?copern=105', '_blank');
  }
  function NastavAutouct()
  {
   window.open('../ucto/uctpoh_new.php?copern=1&page=1', '_blank');
  }
//ciselniky
  function Ufir()
  {
   var okno = window.open('../cis/ufir_new.php?copern=1', '_blank');
  }
  function CisIco()
  {
   window.open('../cis/cico_new.php?copern=1&page=1', '_blank');
  }
  function Strediska()
  {
   window.open('../cis/cstr.php?copern=1&page=1', '_blank');
  }
  function Skupiny()
  {
   window.open('../cis/csku.php?copern=1&page=1', '_blank');
  }
  function Stavby()
  {
   window.open('../cis/csta.php?copern=1&page=1', '_blank');
  }
  function Zakazky()
  {
   window.open('../cis/czak.php?copern=1&page=1', '_blank');
  }
  function ZalDat()
  {
   window.open('../cis/zaldat_ucto_new.php?copern=101', '_blank');
  }
  function Ezakaznik()
  {
   window.open('../cis/ezak.php?copern=1&page=1', '_blank');
  }
  function PrenosPoc()
  {
   window.open('../cis/prenos_poc_new.php?copern=10&upozorni2011=1&upozorni2012=1&upozorni2013=1', '_blank');
  }




//ekorobot
  function NacitajKurzDnes()
  {
   window.open('../cis/stiahni_ecb.php?copern=1010', '_blank');
  }
  function NacitajKurz90()
  {
   window.open('../cis/stiahni_ecb.php?copern=1010&dni90=1', '_blank');
  }
  function KontrolaUct() //dopyt, bude presunute vyssie
  {
   window.open('../ucto/ucto_kontrol_new.php?copern=40&drupoh=1&page=1', '_blank'); //page=1 nebude treba, otestovaù bez drupoh
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



//podsystemy
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
   window.open('odbyt_md.php?copern=1', '_self');
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


  function Kalkulacka()
  {
   window.open('../ucto/paskovacka.php?copern=5', '_blank');
  }


















</script>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>