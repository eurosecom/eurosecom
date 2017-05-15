<!doctype html>
<html>
<?php
$sys = 'ALL';
$urov = 50000;
$uziv = include("uziv.php");
if( !$uziv ) exit;

  require_once("pswd/password.php");

$newdelenie=0;
if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) { $newdelenie=1; }
if ( $newdelenie == 1 )
          {
$dtb2 = include("oddel_dtb3new.php");
          }

  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$strana = 1*$_REQUEST['strana'];
if( $strana == 0 ) { $strana = 1; }
$min_uzall=50000;
if( $kli_uzall >= 100000 ) { $min_uzall=999999;}

$uprav = 1*$_REQUEST['uprav'];
$cislo_id = 1*$_REQUEST['cislo_id'];

//echo $copern;

//uprava
if ( $copern == 8 )
  {
$h_id = $_REQUEST['h_id'];
$h_uzm = $_REQUEST['h_uzm'];
$h_uzh = $_REQUEST['h_uzh'];
$h_prie = $_REQUEST['h_prie'];
$h_meno = $_REQUEST['h_meno'];
$h_all = $_REQUEST['h_all'];
$h_uct = $_REQUEST['h_uct'];
$h_mzd = $_REQUEST['h_mzd'];
$h_skl = $_REQUEST['h_skl'];
$h_him = $_REQUEST['h_him'];
$h_dop = $_REQUEST['h_dop'];
$h_ana = $_REQUEST['h_ana'];
$h_vyr = $_REQUEST['h_vyr'];
$h_fak = $_REQUEST['h_fak'];
$h_txt1 = $_REQUEST['h_txt1'];
$cis1 = $_REQUEST['cis1'];
$cislo_id = $_REQUEST['cislo_id'];

if( $h_all > 10000 AND $kli_uzall < 100000 ) { $h_all=10000; }

$upravttt = "UPDATE klienti SET uziv_meno='$h_uzm', uziv_heslo='$h_uzh', priezvisko='$h_prie', meno='$h_meno',
 all_prav='$h_all', uct_prav='$h_uct', mzd_prav='$h_mzd', skl_prav='$h_skl', him_prav='$h_him', dop_prav='$h_dop',
 vyr_prav='$h_vyr', fak_prav='$h_fak', ana_prav='$h_ana', txt1='$h_txt1', cis1='$cis1' WHERE id_klienta=$cislo_id";

$upravene = mysql_query("$upravttt");
//echo $upravttt;

$copern=1;
$uprav=0;
     }
//koniec uprava

//nacitaj udaje
if ( $copern >= 1 )
     {
$sqlttt = "SELECT * FROM klienti WHERE id_klienta = $cislo_id ";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $h_uzm=$riaddok->uziv_meno;
 $h_uzh=$riaddok->uziv_heslo;
 $h_prie=$riaddok->priezvisko;
 $h_meno=$riaddok->meno;
 $h_all=$riaddok->all_prav;
 $h_uct=$riaddok->uct_prav;
 $h_mzd=$riaddok->mzd_prav;
 $h_skl=$riaddok->skl_prav;
 $h_fak=$riaddok->fak_prav;
 $h_him=$riaddok->him_prav;
 $h_dop=$riaddok->dop_prav;
 $h_vyr=$riaddok->vyr_prav;
 $h_ana=$riaddok->ana_prav;
 $h_txt1=$riaddok->txt1;
 }

     }
//koniec nacitaj udaje


?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="css/material.css">
<link rel="stylesheet" href="css/material_edit.css">
<title>UûÌvatelia | EuroSecom</title>
<script type="text/javascript">

  function ObnovUI()
  {
   document.forma3.selectpage.value = '<?php echo "$strana"; ?>';


<?php if( $uprav == 1 ) { ?>

   document.formv.h_id.value = '<?php echo "$cislo_id"; ?>';
   document.formv.h_uzm.value = '<?php echo "$h_uzm"; ?>';
   document.formv.h_uzh.value = '<?php echo "$h_uzh"; ?>';
   document.formv.h_prie.value = '<?php echo "$h_prie"; ?>';
   document.formv.h_meno.value = '<?php echo "$h_meno"; ?>';
   document.formv.h_txt1.value = '<?php echo "$h_txt1"; ?>';
   document.formv.h_all.value = '<?php echo "$h_all"; ?>';
   document.formv.h_uct.value = '<?php echo "$h_uct"; ?>';
   document.formv.h_mzd.value = '<?php echo "$h_mzd"; ?>';
   document.formv.h_skl.value = '<?php echo "$h_skl"; ?>';
   document.formv.h_fak.value = '<?php echo "$h_fak"; ?>';
   document.formv.h_him.value = '<?php echo "$h_him"; ?>';
   document.formv.h_dop.value = '<?php echo "$h_dop"; ?>';
   document.formv.h_vyr.value = '<?php echo "$h_vyr"; ?>';
   document.formv.h_ana.value = '<?php echo "$h_ana"; ?>';


<?php                   } ?>

  }

  function Uzivatelia()
  {
  window.open('users_md.php?copern=1&strana=1&xxx=1', '_self');
  }

  function NastavFirmu( id, page )
  {
  window.open('users_md.php?cislo_id=' + id + '&copern=1001&strana=' + page + '&xxx=1', '_self' );
  }

  function ZoznamFir(uzivatel)
  {
  window.open('../cis/setuzfir.php?copern=1&uzid=' + uzivatel + '&tt=1','_blank','width=980, height=800, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }

  function ChodNaStranu()
  {
   var chodna = document.forma3.selectpage.value;
   window.open('users_md.php?copern=1&strana=' + chodna + '', '_self');
  }

  function NaStr(chodna)
  {
   window.open('users_md.php?copern=1&strana=' + chodna + '', '_self');
  }

  function upravId(uzivatel)
  {
  window.open('users_md.php?copern=<?php echo $copern;?>&strana=<?php echo $strana;?>&cislo_id=' + uzivatel + '&uprav=1','_self');
  }

  function zmazId(uzivatel)
  {
  window.open('users_md.php?copern=6&strana=<?php echo $strana;?>&cislo_id=' + uzivatel + '&tt=1','_self');
  }

</script>
</head>
<body onload="ObnovUI();" >
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--no-desktop-drawer-button">
<header class="mdl-layout__header mdl-color--light-blue-700 mdl-layout__header--waterfall ui-header">
<div class="mdl-layout__header-row ui-app-row">
  <div class="mdl-grid mdl-grid--no-spacing">
  <div class="mdl-cell mdl-cell--4-col mdl-cell--3-col-phone mdl-cell--middle">
    <div class="mdl-layout-title">
      <a href="http://www.edcom.sk/web/eurosecom.html" target="_blank" class="mdl-color-text--yellow-A100">EuroSecom</a>
      <a href="admin_md.php" class="mdl-color-text--white mdl-layout--large-screen-only">euroalchem.sk</a>
    </div>
  </div>
  <div class="mdl-cell mdl-cell--4-col mdl-cell--hide-tablet mdl-cell--hide-phone">
    <nav class="mdl-navigation mdl-layout--large-screen-only header-nav">
      <a href="admin_md.php" class="mdl-navigation__link header-nav-link">Prehæad</a> <!-- <i class="material-icons">home</i> -->
      <a href="users_md.php?copern=1&strana=1&xxx=1" onclick="Uzivatelia();" class="mdl-navigation__link header-nav-link active">UûÌvatelia</a> <!-- <i class="material-icons">people</i> -->
      <a href="firms_md.php" class="mdl-navigation__link header-nav-link">Firmy</a> <!-- <i class="material-icons">business</i> -->
    </nav>
  </div>
  <div class="mdl-cell mdl-cell--4-col mdl-cell--1-col-phone mdl-cell--middle">
  <div class="toright">
    <div class="mdl-list header-list">
    <div class="mdl-list__item mdl-color-text--blue-grey-100">
      <i class="material-icons mdl-list__item-avatar mdl-color--blue-A100 mdl-color-text--blue-A700 item-avatar-md">person</i>
      <span>UûÌvateæ sk˙öobn˝</span>
    </div>
    </div>
<form action="#" class="ukaz hidden" style="display: inline;">
    <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable" style="">
      <label class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--light-blue-500" for="listfield" style=""><i class="material-icons ">search</i></label>
      <div class="mdl-textfield__expandable-holder" style="">
        <input class="mdl-textfield__input" type="text" id="listfield" pattern="-?[0-9]*(\.[0-9]+)?">
        <label class="mdl-textfield__label" for="listfield">Hæadan˝ v˝raz</label>
        <span class="mdl-textfield__error">Nevyhæad·vajte text!</span>
      </div>
    </div>
</form>
  </div> <!-- .toright -->
  </div> <!-- .mdl-cell -->
  </div> <!-- .mdl-grid -->
</div> <!-- .ui-app-row -->
</header>

<main class="mdl-layout__content mdl-color--blue-grey-50">

<!-- floating action button -->
<aside class="floating-toolbar" style="top:50px; ">
  <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored mdl-color--green-500"><i class="material-icons">add</i></button>
  <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab"><i class="material-icons">print</i></button>
</aside>

<article class="" style="max-width: 1290px; margin: auto; padding-bottom: 20px;">





  <div class="" style="height: 56px; ">
    <span class="mdl-color-text--grey-600" style="font-size: 14px; font-family: Roboto; font-weight: 400; text-transform: uppercase; text-indent: 16px;">»ÌselnÌk uûÌvateæov</span>
    <i class="material-icons">arrow_drop_down</i>


  </div>


<?php if( $copern == 1 ) {

$sql = mysql_query("SELECT * FROM klienti WHERE all_prav < $min_uzall ORDER BY id_klienta ");
//$sql = mysql_query("SELECT * FROM klienti WHERE all_prav < 1 ORDER BY id_klienta ");//prazdny zoznam
// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;

// pocet poloziek na stranu
$pols = 15;
// pocet stran
$xstr =ceil($cpol / $pols);
$npage =  $strana + 1;
// predchadzajuca strana
$ppage =  $strana - 1;
if( $ppage == 0 ) { $ppage=1; }
if( $npage >  $xstr ) { $npage=$xstr; }
// zaciatok cyklu
$i = ( $strana - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($strana-1))+($pols-1);


?>

  <div class="mdl-card mdl-shadow--2dp card-data-table" style=" ">
  <table class="mdl-data-table data-table full-width" style="">
  <colgroup>
    <col style="width:18%;">
    <col style="width:14%;">
    <col class="" style="width:15%;">
    <col style="width:8%;">
    <col style="width:8%;">
    <col style="width:8%;">
    <col style="width:8%;">
    <col style="width:8%;">
    <col style="width:13%;">
  </colgroup>
  <thead>
   <tr>
    <th class="mdl-data-table__cell--non-numeric">UûÌvateæ</th>
    <th class="mdl-data-table__cell--non-numeric" style="">Prihlasovacie<br>meno - heslo</th>
    <th class=" ">Firmy</th>
    <th class=" ">PrÌstup</th>
    <th class="">⁄Ëto<br>Majetok</th>
    <th class="">Mzdy<br>Doprava</th>
    <th class="">Odbyt<br>V˝roba</th>
    <th class="">Sklad<br>Anal˝zy</th>
    <th>&nbsp;</th>
   </tr>
  </thead>
  <tbody>
<?php if ( $cpol == 0 ) { ?>
    <tr class="mdl-color--blue-grey-100">
      <td colspan="9" class="mdl-data-table__cell--non-numeric">
        <i class="material-icons toleft mdl-color-text--blue-grey-400">info</i>
        <span class="row-alert toleft">V tabuæke nie s˙ poloûky</span>
      </td>
    </tr>
<?php } ?>

<?php
   while ($i <= $konc )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
    <tr>
      <td class="mdl-data-table__cell--non-numeric">
<div class="mdl-list__item">
    <span class="mdl-list__item-primary-content">
      <span class="mdl-list__item-avatar"><?php echo $riadok->id_klienta; ?></span>
      <span><?php echo "$riadok->meno $riadok->priezvisko"; ?></span>
    </span>
  </div>
      </td>
<?php
//uzivatel s gridkartou
$jegrid=0;
$sqlpoktt = "SELECT * FROM krtgrd WHERE id = $riadok->id_klienta ";
$sqlpok = mysql_query("$sqlpoktt");
  if (@$zaznam=mysql_data_seek($sqlpok,0))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
  $jegrid=1;
  }

//uzivatel s obmedzenim skriptov
$jemenp=0;
$sqlpoktt = "SELECT * FROM menp WHERE prav = $riadok->id_klienta ";
$sqlpok = mysql_query("$sqlpoktt");
  if (@$zaznam=mysql_data_seek($sqlpok,0))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
  $jemenp=1;
  }
?>
      <td class="mdl-data-table__cell--non-numeric"><?php echo "$riadok->uziv_meno - $riadok->uziv_heslo"; ?><br>
<?php if ( $jegrid == 1 ) { ?>
        <span class="text-chip">Grid</span>
<?php                     } ?>
<?php if ( $jemenp == 1 ) { ?>
        <span class="text-chip">Menp</span>
<?php                     } ?>
      </td>
      <td class="" style="">
      <?php if ( $riadok->txt1 == "0-0" ) { ?>
<img src='../obr/zoznam.png' width=15 height=12 border=1 onClick='ZoznamFir(<?php echo $riadok->id_klienta; ?>);' title='Zoznam firiem pre uûÌvateæa <?php echo $riadok->id_klienta; ?>' >
<?php                              } ?>
        <div class="wide-text"><?php echo $riadok->txt1;?></div>
      </td>
      <td>
      <img src='../obr/naradie.png' onClick="NastavFirmu(<?php echo $riadok->id_klienta;?>, <?php echo $strana;?>);" style="width: 16px; height: 16px; display: ;" title='Nastaviù predvolen˙ FIRmu a UME podæa mÙjho konta' >
<?php echo $riadok->all_prav; ?>
</td>
      <td><?php echo $riadok->uct_prav;?><br><?php echo $riadok->him_prav;?></td>
      <td><?php echo $riadok->mzd_prav;?><br><?php echo $riadok->dop_prav;?></td>
      <td><?php echo $riadok->fak_prav;?><br><?php echo $riadok->vyr_prav;?></td>
      <td><?php echo $riadok->skl_prav;?><br><?php echo $riadok->ana_prav;?></td>
      <td class="">
      <div style="">
          <button type="button" id="itemedit" onClick="upravId(<?php echo $riadok->id_klienta;?>);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons">edit</i></button><div class="mdl-tooltip" data-mdl-for="itemedit">Upraviù</div>
          <button type="button" id="itemcopy" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons">content_copy</i></button><div class="mdl-tooltip" data-mdl-for="itemcopy">KopÌrovaù</div>
          <button type="button" id="itemdelete" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons">remove</i></button><div class="mdl-tooltip" data-mdl-for="itemdelete">Vymazaù</div>
  </div>
      </td>
    </tr>

<?php
  }
$i = $i + 1;
   }
?>

<?php
      } //copern=1
?>

<?php if( $uprav == 1 ) {

?>

    <tr style="">
      <td colspan="9" style="">
<form method="post" action="users_md.php?copern=8&strana=<?php echo $strana;?>&cislo_id=<?php echo $cislo_id;?>" id="formv" name="formv" class="">
<div class="mdl-card mdl-shadow--4dp mdl-color--blue-grey-100">

  <INPUT type="submit" id="uloz" name="uloz" value="Uloz">

  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="h_id" name="h_id" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="h_id" style="">Id</label>
  </div>

  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="h_meno" name="h_meno" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="h_meno" style="">Meno uûÌvateæa</label>
  </div>
  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="h_prie" name="h_prie" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="h_prie" style="">Priezvisko uûÌvateæa</label>
  </div>

  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="h_uzm" name="h_uzm" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="h_uzm" style="">Prihlasovacie meno</label>
  </div>
  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="h_uzh" name="h_uzh" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="h_uzh" style="">Prihlasovacie heslo</label>
  </div>


  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="h_txt1" name="h_txt1" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="h_txt1" style="">Firmy</label>
  </div>



  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="h_all" name="h_all" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="h_all" style="">CelkovÈ pr·va</label>
  </div>
  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="h_uct" name="h_uct" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="h_uct" style="">⁄ËtovnÌctvo</label>
  </div>
  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="h_mzd" name="h_mzd" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="h_mzd" style="">Mzdy</label>
  </div>








</div>
</form>
      </td>
    </tr>

<?php
      } //uprav=1
?>
  </tbody>
  </table>
<div style="background-color: #F5F5F5;">

    <div style="font-size: 12px; color:rgba(0, 0, 0, 0.54); font-family: Roboto; font-weight: 600;">= <?php echo $cpol;?></div> <!-- dopyt, tento ˙daj mi niË nehovorÌ -->

    <form  name="forma3" id="forma3" action="#" class="" style="display: flex; align-items: center;">

      <div class="mdl-layout-spacer"></div>
      <div class=" pagination " style="padding: 0;">
        <label for="">&nbsp;Strana<select name="selectpage" id="selectpage" onchange="ChodNaStranu();">
<?php
$is = 1;
while ( $is <= $xstr )
{
?>
<option value="<?php echo $is; ?>"><?php echo $is; ?></option>
<?php
$is = $is + 1;
}
?>
            </select>&nbsp;/ <?php echo $xstr;?></label>

        <span class="">
            <button id="pageprev" type="button" onclick="NaStr(<?php echo $ppage;?>);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons">keyboard_arrow_left</i></button><div class="mdl-tooltip" data-mdl-for="pageprev" >Prejsù na stranu <?php echo $ppage;?></div>
            <button id="pagenext" type="button" onclick="NaStr(<?php echo $npage;?>);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons">keyboard_arrow_right</i></button><div class="mdl-tooltip" data-mdl-for="pagenext">Prejsù na stranu <?php echo $npage;?></div>
          </span>
      </div>





    </form>
  </div>
</div> <!-- .mdl-card -->
</article>








</main>





<div class="mdl-layout__drawer">
  <span class="mdl-layout-title">EuroSecom</span>
  <nav class="mdl-navigation">
    <a href="admin_md.php" class="mdl-navigation__link" >Prehæad</a>
    <a class="mdl-navigation__link" href="admin_md.php">DomÈna</a>
    <a href="users_md.php" class="mdl-navigation__link mdl-navigation__link--current">UûÌvatelia</a>
    <a class="mdl-navigation__link" href="">⁄Ët. jednotky</a>
  </nav>
</div>




















<!--     <div class="" style=" overflow: auto; height: 48px; line-height: 48px; display: none;">
    <h5 class="toleft" style="margin:0;">»ÌselnÌk uûÌvateæov</h5>

    <div class="mdl-navigation toright" >
      <a href="#" class="mdl-navigation__link">HistÛria</a>
      <a href="#" class="mdl-navigation__link">PrÌstupy</a>
    </div>
    </div> -->

<footer class="mdl-mini-footer mdl-color--white hidden">
  <div class="mdl-mini-footer__left-section">
    <ul class="mdl-mini-footer__link-list">
      <li><a href="#">EuroSecom</a></li>
    </ul>
  </div>
  <div class="mdl-mini-footer__right-section">
    <ul class="mdl-mini-footer__link-list">
      <li><a href="#">EDcom</a></li>
    </ul>
  </div>
</footer>
</div> <!-- .mdl-layout -->

<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>