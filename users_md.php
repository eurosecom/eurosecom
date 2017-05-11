<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="css/material.css">
<link rel="stylesheet" href="css/material_edit.css">
<title>Uívatelia | EuroSecom</title>
</head>
<body>
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
      <a href="users_md.php" class="mdl-navigation__link header-nav-link active">Uívatelia</a> <!-- <i class="material-icons">people</i> -->
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
    <tr class="two-line">
      <td class="mdl-data-table__cell--non-numeric">21</td>
      <td class="mdl-data-table__cell--non-numeric"><span style="font-size: 14px; font-weight: 500;">ÈUívate¾ skúšobnı</span><br><span style="font-size: 12px; color: rgba(0,0,0,.54);">Èuzivatel@domena.sk</span></td>
      <td class="mdl-data-table__cell--non-numeric">Èlogin1 - password1</td>
      <td>200-230,701-805</td>
      <td>10000</td>
      <td>3000<br>3000</td>
      <td>3000<br>3000</td>
      <td>3000<br>3000</td>
      <td>3000<br>3000</td>
      <td>
        <i class="material-icons mdl-color-text--light-blue-600">edit</i>
        <i class="material-icons mdl-color-text--grey-500">content_copy</i>
        <i class="material-icons mdl-color-text--red-500">clear</i>
      </td>
    </tr>
    <tr class="two-line">
      <td class="mdl-data-table__cell--non-numeric">22</td>
      <td class="mdl-data-table__cell--non-numeric">Uívate¾ skúšobnı<br>uzivatel@domena.sk</td>
      <td class="mdl-data-table__cell--non-numeric">login1 - password1</td>
      <td>200-230,701-805</td>
      <td>10000</td>
      <td>3000<br>3000</td>
      <td>3000<br>3000</td>
      <td>3000<br>3000</td>
      <td>3000<br>3000</td>
      <td>
        <i class="material-icons mdl-color-text--light-blue-600">edit</i>
        <i class="material-icons mdl-color-text--grey-500">content_copy</i>
        <i class="material-icons mdl-color-text--red-500">clear</i>
      </td>
    </tr>
    <tr class="one-line slim-row">
      <td class="mdl-data-table__cell--non-numeric">23</td>
      <td class="mdl-data-table__cell--non-numeric">Uívate¾ skúšobnı</td>
      <td class="mdl-data-table__cell--non-numeric">login1 - password1</td>
      <td>200-230,701-805</td>
      <td>10000</td>
      <td>3000</td>
      <td>3000</td>
      <td>3000</td>
      <td>3000</td>
      <td class="cell-button">
        <i class="material-icons mdl-color-text--light-blue-600">edit</i>
        <i class="material-icons mdl-color-text--grey-500">content_copy</i>
        <i class="material-icons mdl-color-text--red-500">clear</i>
      </td>
    </tr>
    <tr>
      <td class="mdl-data-table__cell--non-numeric">25</td>
      <td class="mdl-data-table__cell--non-numeric">Uívate¾ skúšobnı<br>uzivatel@domena.sk</td>
      <td class="mdl-data-table__cell--non-numeric">login1 - password1</td>
      <td>200-230,701-805</td>
      <td>10000</td>
      <td>3000<br>3000</td>
      <td>3000<br>3000</td>
      <td>3000<br>3000</td>
      <td>3000<br>3000</td>
      <td>
        <i class="material-icons mdl-color-text--light-blue-600">edit</i>
        <i class="material-icons mdl-color-text--grey-500">content_copy</i>
        <i class="material-icons mdl-color-text--red-500">clear</i>
      </td>
    </tr>
    <tr>
      <td class="mdl-data-table__cell--non-numeric">25</td>
      <td class="mdl-data-table__cell--non-numeric">Uívate¾ skúšobnı<br>uzivatel@domena.sk</td>
      <td class="mdl-data-table__cell--non-numeric">login1 - password1</td>
      <td>200-230,701-805</td>
      <td>10000</td>
      <td>3000<br>3000</td>
      <td>3000<br>3000</td>
      <td>3000<br>3000</td>
      <td>3000<br>3000</td>
      <td>
        <i class="material-icons mdl-color-text--light-blue-600">edit</i>
        <i class="material-icons mdl-color-text--grey-500">content_copy</i>
        <i class="material-icons mdl-color-text--red-500">clear</i>
      </td>
    </tr>
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
      <div style="font-size: 12px; color:rgba(0, 0, 0, 0.54); font-family: Roboto; font-weight: 600;">= 120</div> <!-- dopyt, tento údaj mi niè nehovorí -->
    </td>
    <td colspan="8">
    <form action="#" class="" style="display: flex; align-items: center;">

      <div class="mdl-layout-spacer"></div>
      <div class=" pagination " style="padding: 0;">
        <label for="">&nbsp;Strana<select name="" id="">
              <option value="">1</option>
              <option value="">2</option>
              <option value="">3</option>
              <option value="">4</option>
              <option value="">5</option>
            </select>&nbsp;/ 40</label>

        <span class="">
            <button id="pageprev" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons">keyboard_arrow_left</i></button><div class="mdl-tooltip" data-mdl-for="pageprev" >Prejs na stranu 1</div>
            <button id="pagenext" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons">keyboard_arrow_right</i></button><div class="mdl-tooltip" data-mdl-for="pagenext">Prejs na stranu 2</div>
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