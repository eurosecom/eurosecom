<!doctype html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/material.css">
  <!-- <link rel="stylesheet" href="css/material_edit.css"> -->
  <title>Firmy | EuroSecom</title>
<style>
body {
  font-family: 'Roboto', 'Helvetica', 'Arial', sans-serif;
  line-height: 1;
}
a {
  text-decoration: none;
  display: inline-block;
}
table {
  border-collapse: collapse;
  width: 100%;
  /*background-color: red;*/
}
.right {
  text-align: right;
}
.tocenter {
  margin: auto;
}
.ui-header .mdl-layout__drawer-button {
  margin: 0 8px;
  width: 40px;
  height: 40px;
  line-height: 1;
  background-color: transparent;
  min-height: 40px;
  max-height: 40px;
  padding-top: 8px;
}
.ui-header-three-row.is-compact {
  max-height: 136px;
}
.ui-header-three-row .mdl-layout__header-row:not(.ui-header-page-row) {
  height: 40px;
}

.ui-header-app-row {
  padding: 0 20px 0 56px;

}
.ui-header-app-row .mdl-layout-title {
  font-size: 12px;
  font-weight: 400;
}
.ui-header-page-row {
  height: 56px;
  padding: 0 20px 0 56px;
}
.ui-header-page-row .mdl-layout-title {
  font-size: 18px;
}

.material-icons.md-18 { font-size: 18px; }





.ukaz {
  outline: 1px solid red;
  border: 1px solid red;
}


.ui-table-layout thead th {
  font-size: 11px;
  font-weight: 500;
  text-align: left;
  line-height: 1.2;
  box-sizing: border-box;
  /*vertical-align: -4px;*/
  text-overflow: ellipsis;
  position: relative;
  height: 40px;
  letter-spacing: 0.04em;
  /*color: rgba(0, 0, 0, 0.54);*/
  text-transform: uppercase;
  padding: 0 0 0 0;
}
.ui-table-layout tbody tr:hover {
  background-color: #eeeeee;
}
.ui-table-layout tbody tr:last-of-type td {
  border: 0;

}

.ui-table-layout th:first-of-type {
  padding-left: 24px;
}
.ui-table-layout th:last-of-type {
  padding-right: 24px;

}


.ui-table-layout tbody td {
  /*height: 42px;*/
  height: 40px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.12);
  border-top: 1px solid rgba(0, 0, 0, 0.12);
  font-size: 13px;
  color: rgba(0,0,0, 0.87);
  box-sizing: border-box;
  line-height: 1.2;
  vertical-align: middle;
  position: relative;
  padding: 0;
}
.ui-table-layout tbody td:first-of-type {
  padding-left: 24px;
}
.ui-table-layout tbody td:last-of-type {
  padding-right: 24px;

}
.ui-table-layout thead th > .material-icons {
  position: absolute;
}

</style>
</head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
<header class="mdl-layout__header mdl-layout__header--waterfall ui-header ui-header-three-row">
<div class="mdl-layout__header-row mdl-color--light-blue-700 ui-header-app-row">
  <a href="http://www.edcom.sk/web/eurosecom.html" target="_blank" class="mdl-layout-title mdl-color-text--yellow-A100">EuroSecom</a>&nbsp;
  <a href="admin_md.php" class="mdl-layout-title mdl-color-text--white">localhost</a>
  <div class="mdl-layout-spacer"></div>
  <div class="mdl-list header-list" style="  ">
    <div class="mdl-list__item mdl-color-text--blue-grey-100 " style="min-height: 40px; padding: 0; float: right;">
      <i class="material-icons mdl-list__item-avatar mdl-color--blue-A100 mdl-color-text--blue-A700 item-avatar-md" style="font-size: 24px; height: 24px; line-height: 24px; width: 24px; margin-right: 6px;">person</i>
      <span class="" style="font-size: 12px; letter-spacing: 0.02em;">Užívate¾ skúšobný</span>
    </div>
  </div>
</div> <!-- .ui-header-app-row -->
<div class="mdl-layout__header-row mdl-color--light-blue-600 ui-header-page-row" style=" ">
  <span class="mdl-layout-title">Èíselník firiem</span>
</div> <!-- .ui-header-page-row -->
<div class="mdl-layout__header-row mdl-color--light-blue-600">
  <div class="tocenter" style="max-width: 1080px; left:-28px; position: relative; width: 100%;">
  <table class="ui-table-layout">
  <thead>
   <tr>
    <th style="width: 8%;">Èíslo</th>
    <th style="width: 52%;">Názov</th>
    <th style="width: 10%;">Obdobie</th>
    <th style="width: 10%;">Druh<i class="material-icons md-18" style="top:10px; left:35px;">info_outline</i></th>
    <th style="width: 20%;">&nbsp;</th>
  </tr>
  </thead>
  </table>
  </div>
</div>
</header>

<button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored mdl-color--green-500" style="position: absolute; top: 110px; right: 50px;"><i class="material-icons">add</i></button>

<main class="mdl-layout__content mdl-color--blue-grey-50" style="padding: 0 0 50px 0; ">
<div class="mdl-color--white">
  <div class="tocenter" style="max-width: 1080px;">
  <table class="ui-table-layout">
  <colgroup>
    <col style="width:8%;">
    <col style="width:52%;">
    <col style="width:10%;">
    <col style="width:10%;">
    <col style="width:20%;">
  </colgroup>
  <tbody>
  <tr style="background-color: ;">
    <td class="">1</td>
    <td >Firma ABC</td>
    <td>2017</td>
    <td class="">5</td>
    <td class="">
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>2</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>3</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>
  <tr>
    <td>1</td>
    <td>Firma ABC</td>
    <td>2017</td>
    <td>5</td>
    <td>
      <button type="button" id="itemedit" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>








  </tbody>
  </table>
  </div> <!-- .tocenter -->
</div>
</main>

<nav class="mdl-navigation mdl-layout--large-screen-only header-nav " style="width: 300px; display: none;">
    <a href="admin_md.php" class="mdl-navigation__link header-nav-link">Preh¾ad</a> <!-- dopyt, cez onclick -->
    <a href="#" onclick="Uzivatelia();" class="mdl-navigation__link header-nav-link active">Užívatelia</a>
    <a href="firms_md.php" class="mdl-navigation__link header-nav-link">Firmy</a> <!-- dopyt, cez onclick -->
  </nav>

<div class="mdl-layout__drawer">
  <span class="mdl-layout-title">EuroSecom</span>
  <nav class="mdl-navigation">
    <a href="admin_md.php" class="mdl-navigation__link">Preh¾ad</a>
    <a href="users_md.php" class="mdl-navigation__link mdl-navigation__link--current">Užívatelia</a>
    <a href="firms_md.php" class="mdl-navigation__link">Firmy</a>
    <a href="" class="mdl-navigation__link">Úètovníctvo</a>
    <a href="" class="mdl-navigation__link">Mzdy</a>
    <a href="" class="mdl-navigation__link">Odbyt</a>
    <a href="" class="mdl-navigation__link">Sklad</a>
    <a href="" class="mdl-navigation__link">Majetok</a>
    <a href="" class="mdl-navigation__link">Analýzy</a>
  </nav>
</div>

</div> <!-- .mdl-layout -->

<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>