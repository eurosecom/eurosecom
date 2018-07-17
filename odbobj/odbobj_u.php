<!doctype html>
<html>
<?php
//celkovy zaciatok dokumentu
       do
       {
?>
<head>
<meta charset="cp1250">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="../css/reset.css">
<title>Odberateľská objednávka | EuroSecom</title>
<style>
html {
  -webkit-box-sizing: border-box;
          box-sizing: border-box; /* width + padding + border */
}
*, *:after, *:before {
  -webkit-box-sizing: inherit;
          box-sizing: inherit;
}
body {
  min-width: 900px;
  background-color: #add8e6;
  font-family: Arial, sans-serif;
}
.clearfix:before,
.clearfix:after {
  content: " ";
  display: table;
}
.clearfix:after {
  clear: both;
}
.toleft {
  float: left;
}
.toright {
  float: right;
}

</style>
</head>
<body>
<header class="ui-header">
  <div class="ui-header-row clearfix" style="background-color: #ffff90; height: 64px; box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298); padding: 4px 16px;">
    <ul class="ui-header-ilogin clearfix">
      <li class="toleft" style="font-size: 70%;">PLOTY SKALA 2018 > Odbyt > Odberateľské objednávky</li>
      <li class="toright" style="font-size: 70%;">&nbsp;&nbsp;&nbsp;User</li>
    </ul>
    <ul class="ui-header-title" style="line-height: 48px; background-color: ;">
      <li class="toleft" style="font-size: 24px; font-weight: 500; letter-spacing: .02em;">Odberateľská objednávka&nbsp;<strong style="color: #39f;">nová / úprava</strong>
      </li>
      <li class="toright clearfix" style="background-color: ; ">
        <button type="button" title="Vytvoriť novú objednávku" class="toleft" style="cursor: pointer; margin-top: 12px; display: block; background-color: transparent; border: 0; color: #39f; height: 24px;"><i class="material-icons">add</i><span style="font-size: 18px; position: relative; top: -5px; padding: 0 8px 0 4px;">Objednávka</span></button>
        <button type="button" title="Zobraziť zoznam v pdf" class="toleft" style="cursor: pointer; margin-top: 12px; display: block; background-color: transparent; border: 0; color: #39f; height: 24px;"><i class="material-icons" >print</i></button>
      </li>
    </ul><!-- .ui-header-title -->
  </div><!-- .ui-header-row -->
</header>
<main class="ui-content">
  <div class="ui-container" style="margin: 16px auto; max-width: 1366px;">
    <form action="#" class="clearfix" style="background-color: white; font-size: 14px; display: block; padding: 16px 16px;">
    <fieldset class="toleft" style="width: 50%;">
      <label for="obj_cis">Číslo</label>
      <input type="text" name="obj_cis" disabled="disabled" style="width: 50px;"><!-- dopyt, automaticky generovať -->
      <label for="obj_druh">Druh</label>
      <select name="obj_druh" id="obj_druh">
        <option value="1">tovar</option>
        <option value="2">montáž</option>
      </select>
      <label for="esobj_cis">Číslo eshop obj.</label>
      <input type="number" name="esobj_cis" style="width: 100px;"><br><br>
      <label for="obj_datum">Dátum</label>
      <input type="date" name="obj_datum">
    </fieldset>



    <fieldset class="toleft" style="width: 50%;">
      <legend>Objednal</legend>
      <label for="obj_ico">IČO</label>
      <input type="number" name="obj_ico" disabled style="width: 100px;">
      <button type="button" title="Vybrať ičo" class="" style="cursor: pointer; background-color: transparent; border: 0; color: #39f; height: 24px;"><i class="material-icons" >edit</i></button>
      <label for="obj_icdph">IČDPH</label>
      <input type="text" name="obj_icdph" disabled style="width: 100px;"><br>
      <label for="obj_nazov">Názov</label>
      <input type="text" name="obj_nazov" disabled style="width: 300px;"><br><!-- dopyt, výpis názov iča -->
      <label for="obj_adresa">Adresa</label>
      <input type="text" name="obj_adresa" disabled style="width: 300px;"><br><!-- dopyt, výpis mesto psč ulica číslo z číselníka ičo -->
      <label for="obj_kontakt">Kontakt</label>
      <input type="text" name="obj_kontakt" disabled style="width: 200px;"><br><br><!-- dopyt, výpis tel a email z číselníka ičo -->
      <legend>Iná adresa dodania</legend>
      <label for="obj_dodnazov">Firma</label>
      <input type="obj_dodnazov" style="width: 300px;"><br>
      <label for="obj_dodulica">Ulica</label>
      <input type="obj_dodulica" style="width: 300px;"><br>
      <label for="obj_dodmesto">Mesto</label>
      <input type="obj_dodmesto" style="width: 300px;">
      <label for="obj_dodpsc">PSČ</label>
      <input type="obj_dodpsc" style="width: 50px;"><br>
      <label for="obj_dodosoba">Kontaktná osoba</label>
      <input type="obj_dodosoba" style="width: 300px;"><br>
    </fieldset>

    <fieldset>
      <legend>Spôsob platby</legend>
      <label for="platba_ucet">Bankový prevod</label>
      <input type="radio" name="obj_platba" id="platba_ucet" value="ucet"><br>
      <label for="platba_cash">Hotovosť / dobierka</label>
      <input type="radio" name="obj_platba" id="platba_cash" value="cash"><br>
      <label for="platba_card">Platba kartou</label>
      <input type="radio" name="obj_platba" id="platba_card" value="card"><br>
      <label for="platba_card">Dodací list</label>
      <input type="radio" name="obj_platba" id="platba_dodak" value="dodak">
      <label for="platba_dodak_suma">Suma na DL</label>
      <input type="text" id="platba_dodak_suma" style="width: 100px;">
      <br>
      <legend>Stav platby</legend><!-- dopyt, pôjde do poznámky -->
      <label for="platba_done">Zaplatené</label>
      <input type="radio" name="obj_platba_stav" id="platba_done" value="done"><br>
      <label for="platba_wait">Čakáme na úhradu</label>
      <input type="radio" name="obj_platba_stav" id="platba_wait" value="card"><br>
      <label for="platba_delivery">Pri dovoze</label>
      <input type="radio" name="obj_platba_stav" id="platba_delivery" value="delivery"><br>
    </fieldset><br>
    <fieldset>
      <legend>Doprava</legend>
      <label for="doprava_vlastna">Vlastná</label>
      <input type="radio" name="obj_doprava" id="doprava_vlastna" value="vlastna">
      <label for="doprava_vlastna_datum">Plánovaný rozvoz</label>
      <select name="doprava_vlastna_datum" id="">
        <option value="1">Pondelok</option>
        <option value="2">Utorok</option>
        <option value="3">Streda</option>
        <option value="4">Štvrtok</option>
        <option value="5">Piatok</option>
      </select><br>
      <label for="doprava_gls">Kuriér GLS</label>
      <input type="radio" name="obj_doprava" id="doprava_gls" value="gls"><br>
      <label for="doprava_toptrans">Kuriér Toptrans</label>
      <input type="radio" name="obj_doprava" id="doprava_toptrans" value="toptrans"><br>
      <label for="doprava_osobne">Osobný odber</label>
      <input type="radio" name="obj_doprava" id="doprava_osobne" value="osobne"><br>

    </fieldset>





    </form>
  </div><!-- .ui-container -->
</main>











</body>
<?php
//celkovy koniec dokumentu
       } while (false);
?>
</html>
