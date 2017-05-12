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
if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) 
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


?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="css/material.css">
<link rel="stylesheet" href="css/material_edit.css">
<title>Uívatelia | EuroSecom</title>
<script type="text/javascript">

  function ObnovUI()
  {
   document.forma3.selectpage.value = '<?php echo "$strana"; ?>';
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
      <a href="admin_md.php" class="mdl-navigation__link header-nav-link">Preh¾ad</a> <!-- <i class="material-icons">home</i> -->
      <a href="users_md.php?copern=1&strana=1&xxx=1" onclick="Uzivatelia();" class="mdl-navigation__link header-nav-link active">Uívatelia</a> <!-- <i class="material-icons">people</i> -->
      <a href="firms_md.php" class="mdl-navigation__link header-nav-link">Firmy</a> <!-- <i class="material-icons">business</i> -->
    </nav>
  </div>
  <div class="mdl-cell mdl-cell--4-col mdl-cell--1-col-phone mdl-cell--middle">
  <div class="toright">
    <div class="mdl-list header-list">
    <div class="mdl-list__item mdl-color-text--blue-grey-100">
      <i class="material-icons mdl-list__item-avatar mdl-color--blue-A100 mdl-color-text--blue-A700 item-avatar-md">person</i>
      <span>Uívate¾ skúšobnı</span>
    </div>
    </div>
<form action="#" class="ukaz hidden" style="display: inline;">
    <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable" style="">
      <label class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--light-blue-500" for="listfield" style=""><i class="material-icons ">search</i></label>
      <div class="mdl-textfield__expandable-holder" style="">
        <input class="mdl-textfield__input" type="text" id="listfield" pattern="-?[0-9]*(\.[0-9]+)?">
        <label class="mdl-textfield__label" for="listfield">H¾adanı vıraz</label>
        <span class="mdl-textfield__error">Nevyh¾adávajte text!</span>
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
<aside class="floating-toolbar" style="top:50px;">
  <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored mdl-color--green-500"><i class="material-icons">add</i></button>
  <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab"><i class="material-icons">print</i></button>
</aside>




<article class="ui-page center" style="min-width: 720px; max-width: 1290px; overflow: auto; margin: auto; ">







    <div class="left " style="height: 56px; ">
    <span class="mdl-color-text--grey-600" style="font-size: 14px; font-family: Roboto; font-weight: 400; text-transform: uppercase; text-indent: 16px;">Èíselník uívate¾ov</span>
    <i class="material-icons">arrow_drop_down</i>


  </div>


<?php if( $copern == 1 ) { 

$sql = mysql_query("SELECT * FROM klienti WHERE all_prav < $min_uzall ORDER BY id_klienta ");
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

  <div class="mdl-card mdl-color--blue-grey-50 card-data-table  " style="overflow: auto; padding: 0 10px 10px 10px; display: inline-block; margin: 0 auto; text-align: center;">

  <table class="mdl-data-table data-table mdl-shadow--2dp" style=""> <!-- width: 100%; -->
<!--   <colgroup>
    <col style="width:5%;">
    <col style="width:15%;">
    <col style="width:10%;">
    <col style="width:20%;">
    <col style="width:10%;">
    <col style="width:10%;">
    <col style="width:10%;">
    <col style="width:10%;">
    <col style="width:10%;">
  </colgroup> -->
  <thead class="" style="">
   <tr>
    <th class="mdl-data-table__cell--non-numeric " style="vertical-align: middle;">ID</th>
    <th class="mdl-data-table__cell--non-numeric " style="vertical-align: middle;">Uívate¾</th>
    <th class="mdl-data-table__cell--non-numeric " style="vertical-align: middle;">Login<br>meno - heslo</th>
    <th class=" " style="vertical-align: middle;">Firmy</th>
    <th class=" " style="vertical-align: middle;">Prístup</th>
    <th class="">Úèto<br>Majetok</th>
    <th class="">Mzdy<br>Doprava</th>
    <th class="">Odbyt<br>Vıroba</th>
    <th class="">Sklad<br>Analızy</th>
    <th>&nbsp;</th>
   </tr>
  </thead>
  <tbody>


<?php
   while ($i <= $konc )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>


    <tr class="two-line">
      <td class="mdl-data-table__cell--non-numeric"><?php echo $riadok->id_klienta;?></td>
      <td class="mdl-data-table__cell--non-numeric"><span style="font-size: 14px; font-weight: 500;"><?php echo $riadok->meno;?> <?php echo $riadok->priezvisko;?></span><br><span style="font-size: 12px; color: rgba(0,0,0,.54);"> </span></td>
      <td class="mdl-data-table__cell--non-numeric"><?php echo $riadok->uziv_meno;?> - <?php echo $riadok->uziv_heslo;?></td>
      <td><?php if( $riadok->txt1 == "0-0" ) { ?>
<img src='../obr/zoznam.png' width=15 height=12 border=1 onClick='ZoznamFir(<?php echo $riadok->id_klienta; ?>);' title='Zoznam firiem pre uívate¾a <?php echo $riadok->id_klienta; ?>' >
<?php                              } ?>
<?php echo $riadok->txt1;?>
</td>
      <td><img src='../obr/naradie.png' onClick="NastavFirmu(<?php echo $riadok->id_klienta;?>, <?php echo $strana;?>);" width=15 height=15 border=0 title='Nastavi predvolenú FIRmu a UME pod¾a môjho konta' >
<?php echo $riadok->all_prav;?>
</td>
      <td><?php echo $riadok->uct_prav;?><br><?php echo $riadok->him_prav;?></td>
      <td><?php echo $riadok->mzd_prav;?><br><?php echo $riadok->dop_prav;?></td>
      <td><?php echo $riadok->fak_prav;?><br><?php echo $riadok->vyr_prav;?></td>
      <td><?php echo $riadok->skl_prav;?><br><?php echo $riadok->ana_prav;?></td>
      <td>
        <i class="material-icons mdl-color-text--light-blue-600">edit</i>
        <i class="material-icons mdl-color-text--grey-500">content_copy</i>
        <i class="material-icons mdl-color-text--red-500">clear</i>
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

    <tr style="display: none;">
      <td colspan="10" style="display: none;">
<form action="#" class="hidden">
<div class="mdl-card mdl-shadow--4dp mdl-color--blue-grey-100">
  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="cislo" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="cislo" style="">Meno uívate¾a</label>
  </div>
  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="cislo" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="cislo" style="">Priezvisko uívate¾a</label>
  </div>
  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="cislo" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="cislo" style="">Prihlasovacie meno</label>
  </div>
  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="cislo" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="cislo" style="">Prihlasovacie heslo</label>
  </div>
  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="cislo" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="cislo" style="">Prístupné firmy</label>
  </div>
  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="cislo" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="cislo" style="">Celkové práva</label>
  </div>
  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="cislo" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="cislo" style="">Úètovníctvo</label>
  </div>
  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="cislo" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="cislo" style="">Mzdy</label>
  </div>
  <div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="cislo" style="font-size: 14px;">
    <label class="mdl-textfield__label" for="cislo" style="">Prihlasovacie meno</label>
  </div>




<div class="mdl-textfield mdl-js-textfield " style="">
    <input class="mdl-textfield__input" type="text" id="nazov" style="">
    <label class="mdl-textfield__label" for="nazov">Názov firmy</label>
 </div>


<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: inherit;">
    <input class="mdl-textfield__input" type="text" id="obdobie" style="">
    <label class="mdl-textfield__label" for="obdobie">Obdobie</label>
 </div>


<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: inherit;">
    <input class="mdl-textfield__input" type="text" id="druh" style="">
    <label class="mdl-textfield__label" for="druh">Druh firmy</label>
 </div>




</div>
</form>
      </td>
    </tr>
  </tbody>
  <tfoot class="" style="background-color: #F5F5F5;">
  <tr>
    <td colspan="2" class="mdl-data-table__cell--non-numeric">
      <div style="font-size: 12px; color:rgba(0, 0, 0, 0.54); font-family: Roboto; font-weight: 600;">= <?php echo $cpol;?></div> <!-- dopyt, tento údaj mi niè nehovorí -->
    </td>
    <td colspan="8">
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
            <button id="pageprev" onclick="NaStr(<?php echo $ppage;?>);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons">keyboard_arrow_left</i></button><div class="mdl-tooltip" data-mdl-for="pageprev" >Prejs na stranu <?php echo $ppage;?></div>
            <button id="pagenext" onclick="NaStr(<?php echo $npage;?>);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons">keyboard_arrow_right</i></button><div class="mdl-tooltip" data-mdl-for="pagenext">Prejs na stranu <?php echo $npage;?></div>
          </span>
      </div>





    </form>
    </td>
  </tr>
  </tfoot>
  </table>


</div> <!-- .mdl-card -->
</article>






<div class="mdl-grid     " style=""> <!-- mdl-grid--no-spacing mdl-color--white mdl-color--blue-grey-50 -->
<div class="mdl-cell mdl-cell--12-col " style="">
</div>
</div> <!-- .mdl-grid -->

</main>





<div class="mdl-layout__drawer">
  <span class="mdl-layout-title">EuroSecom</span>
  <nav class="mdl-navigation">
    <a href="admin_md.php" class="mdl-navigation__link" >Preh¾ad</a>
    <a class="mdl-navigation__link" href="admin_md.php">Doména</a>
    <a href="users_md.php" class="mdl-navigation__link mdl-navigation__link--current">Uívatelia</a>
    <a class="mdl-navigation__link" href="">Úèt. jednotky</a>
  </nav>
</div>




















<!--     <div class="" style=" overflow: auto; height: 48px; line-height: 48px; display: none;">
    <h5 class="toleft" style="margin:0;">Èíselník uívate¾ov</h5>

    <div class="mdl-navigation toright" >
      <a href="#" class="mdl-navigation__link">História</a>
      <a href="#" class="mdl-navigation__link">Prístupy</a>
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