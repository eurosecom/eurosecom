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
<title>Odberate�sk� objedn�vky | EuroSecom</title>
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
      <li class="toleft" style="font-size: 70%;">PLOTY SKALA 2018 > Odbyt</li>
      <li class="toright" style="font-size: 70%;">&nbsp;&nbsp;&nbsp;User</li>
    </ul>
    <ul class="ui-header-title" style="line-height: 48px; background-color: ;">
      <li class="toleft" style="font-size: 24px; font-weight: 500; letter-spacing: .02em;">Odberate�sk� objedn�vky&nbsp;<strong style="color: #39f;">nevybaven�</strong><!-- dopyt, bude preklik na ne/vybaven� --></li>
      <li class="toright clearfix" style="background-color: ; ">
        <button type="button" title="Vytvori� nov� objedn�vku" class="toleft" style="cursor: pointer; margin-top: 12px; display: block; background-color: transparent; border: 0; color: #39f; height: 24px;"><i class="material-icons">add</i><span style="font-size: 18px; position: relative; top: -5px; padding: 0 8px 0 4px;">Objedn�vka</span></button>
        <button type="button" title="Zobrazi� zoznam v pdf" class="toleft" style="cursor: pointer; margin-top: 12px; display: block; background-color: transparent; border: 0; color: #39f; height: 24px;"><i class="material-icons" >print</i></button>
      </li>
    </ul><!-- .ui-header-title -->
  </div><!-- .ui-header-row -->
</header>
<main class="ui-content">
  <div class="ui-container" style="margin: 10px auto; max-width: 1366px;">
    <ul class="ui-list ui-list-header clearfix" style="width: 100%; font-size: 13px; height: 40px;">
      <li class="toleft" style="width: 10%;">��slo / druh <br>eshop objedn�vka</li>
      <li class="toleft" style="width: 7%;">D�tum</li>
      <li class="toleft" style="width: 40%;">Objednal / Adresa dodania<br>Pozn�mka</li>
      <li class="toleft" style="width: 10%;">Platba<br>Stav</li>
      <li class="toleft" style="width: 10%;">Doprava<br>Pl�novan� rozvoz</li>
      <li class="toleft" style="width: 10%;">Hodnota -/+ dph</li>
      <li class="toleft" style="width: 13%;"></li>
    </ul>
    <ul class="ui-list-content clearfix" style="background-color: white; padding:8px 4px; font-size: 14px; border-radius: 1px;">
      <li class="toleft" style="width: 10%;">1005 / 1 <br>4015</li>
      <li class="toleft" style="width: 7%;">12.08.2018</li>
      <li class="toleft" style="width: 40%;">Firma ABC a.s.<br>Preveri�, �i u� neuhradil. Informova� de� dopredu</li>
      <li class="toleft" style="width: 10%;">Platba pri dovoze<br>�ak�me na �hradu</li>
      <li class="toleft" style="width: 10%;">vlastn�<br>�tvrtok</li>
      <li class="toleft" style="width: 10%;">100/120 dph</li>
      <li class="toleft" style="width: 13%;">
        <button type="button">Upravi�</button>
        <button type="button">Spracova�</button>
        <button type="button">Zobrazi�</button>
        <button type="button">Vymaza�</button>
      </li>
    </ul>






  </div><!-- .ui-container -->
</main>










</body>
<?php
//celkovy koniec dokumentu
       } while (false);
?>
</html>
