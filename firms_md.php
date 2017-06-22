<!doctype html>
<html>
<?php
$sys = 'ALL';
$urov = 15000;
$uziv = include("uziv.php");
if( !$uziv ) exit;

  require_once("pswd/password.php");

$newdelenie=0;
if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) { $newdelenie=1; }
if ( $newdelenie == 1 )
          {
$dtb2 = include("../oddel_dtb3new.php");
          }

  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//cislo operacie
$copern = 1*$_REQUEST['copern'];
if( $copern == 0 ) { $copern = 1; }
$strana = 1*$_REQUEST['strana'];
if( $strana == 0 ) { $strana = 1; }

$server_name = $_SERVER['SERVER_NAME'];

$uprav = 1*$_REQUEST['uprav'];
$cislo_xcf = 1*$_REQUEST['cislo_xcf'];
$hladanie = 1*$_REQUEST['hladanie'];
$cohladat = trim($_REQUEST['cohladat']);
if( $cohladat == '' ){ $hladanie=0; }
//echo $cohladat."<br />";

$kopkli=0;
$zmazane=0;

//nacitaj udaje
if ( $copern >= 1 )
     {
$sqlttt = "SELECT * FROM fir WHERE xcf = $cislo_xcf ";
$sqldok = mysql_query("$sqlttt");
//echo $sqlttt;
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $h_xcf=$riaddok->xcf;
 $h_naz=$riaddok->naz;
 $h_rok=$riaddok->rok;
 $h_duj=$riaddok->duj;
 }

     }
//koniec nacitaj udaje

if( $newdelenie == 1 AND $kopkli == 1 )
          {

if( $mysqldb2016 != $mysqldb2017 AND $mysqldb2017 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2017."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2017."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2017.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2017.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2018 AND $mysqldb2018 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2018."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2018."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2018.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2018.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2019 AND $mysqldb2019 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2019."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2019."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2019.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2019.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2015 AND $mysqldb2015 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2015."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2015."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2015.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2015.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2014 AND $mysqldb2014 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2014."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2014."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2014.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2014.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2013 AND $mysqldb2013 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2013."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2013."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2013.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2013.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2012 AND $mysqldb2012 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2012."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2012."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2012.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2012.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2011 AND $mysqldb2011 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2011."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2011."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2011.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2011.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2010 AND $mysqldb2010 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2010."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2010."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2010.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2010.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }


          }
//if( $newdelenie == 1 )

?>
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
<body onload="ObnovUI();" >
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
<header class="mdl-layout__header mdl-layout__header--waterfall ui-header ui-header-three-row">
<div class="mdl-layout__header-row mdl-color--light-blue-700 ui-header-app-row">
  <a href="http://www.edcom.sk/web/eurosecom.html" target="_blank" class="mdl-layout-title mdl-color-text--yellow-A100">EuroSecom</a>&nbsp;
  <a href="admin_md.php" class="mdl-layout-title mdl-color-text--white">localhost</a>
  <div class="mdl-layout-spacer"></div>
  <div class="mdl-list header-list" style="  ">
    <div class="mdl-list__item mdl-color-text--blue-grey-100 " style="min-height: 40px; padding: 0; float: right;">
      <i class="material-icons mdl-list__item-avatar mdl-color--blue-A100 mdl-color-text--blue-A700 item-avatar-md" style="font-size: 24px; height: 24px; line-height: 24px; width: 24px; margin-right: 6px;">person</i>
      <span class="" style="font-size: 12px; letter-spacing: 0.02em;">UûÌvateæ sk˙öobn˝</span>
    </div>
  </div>
</div> <!-- .ui-header-app-row -->
<div class="mdl-layout__header-row mdl-color--light-blue-600 ui-header-page-row" style=" ">
  <span class="mdl-layout-title">»ÌselnÌk firiem</span>
</div> <!-- .ui-header-page-row -->
<div class="mdl-layout__header-row mdl-color--light-blue-600">
  <div class="tocenter" style="max-width: 1080px; left:-28px; position: relative; width: 100%;">


<?php
$sqltt = "SELECT * FROM fir WHERE xcf >= 0 ORDER BY xcf ";
if( $hladanie == 1 )
{ 
$sqltt = "SELECT * FROM klienti WHERE  xcf >= 0  AND ( naz LIKE '%$cohladat%' OR rok LIKE '%$cohladat%' ) ORDER BY xcf ";
}
$sql = mysql_query("$sqltt");
//$sql = mysql_query("SELECT * FROM fir WHERE xcf < 0 ORDER BY xcf ");//prazdny zoznam
// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;

// pocet poloziek na stranu
$pols = 10;
if( $hladanie == 1 ){ $pols = 900; }
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

  <table class="ui-table-layout">
  <thead>
   <tr>
    <th style="width: 8%;">»Ìslo</th>
    <th style="width: 52%;">N·zov</th>
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

<?php
   while ($i <= $konc )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>

<?php  if ( $riadok->xcf != $cislo_xcf ) { ?>

  <tr style="background-color: ;">
    <td class=""><?php echo $riadok->xcf; ?></td>
    <td ><?php echo $riadok->naz; ?></td>
    <td><?php echo $riadok->rok; ?></td>
    <td class=""><?php echo $riadok->duj; ?></td>
    <td class="">
      <button type="button" id="itemedit" onclick="upravXcf(<?php echo $riadok->xcf; ?>,1);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <button type="button" id="usercopy" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
      <button type="button" id="userremove" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
    </td>
  </tr>

<?php                                    } ?>

<?php  if ( $uprav != 0 AND $riadok->xcf == $cislo_xcf ) { ?>
<form method="post" action="firms_md.php?copern=8&strana=<?php echo $strana; ?>&cislo_xcf=<?php echo $cislo_xcf; ?>&uprav=<?php echo $uprav; ?>&hladanie=<?php echo $hladanie; ?>&cohladat=<?php echo $cohladat; ?>" id="formv" name="formv">

  <tr style="background-color: ;">
    <td class=""><?php echo $riadok->xcf; ?></td>
    <td ><input type="text" id="h_naz" name="h_naz" ></td>
    <td><input type="text" id="h_rok" name="h_rok" ></td>
    <td class=""><input type="text" id="h_duj" name="h_duj" ></td>
  </tr>

</form>
<?php                                                    } ?>

<?php
  }
$i = $i + 1;
   }
?>






  </tbody>

  <tfoot class="mdl-color--grey-100">
    <tr>
      <td colspan="2" class="mdl-data-table__cell--non-numeric">= <?php echo $cpol; ?></td>
      <td colspan="6">
<form name="forma3" id="forma3" action="#" class="table-pagination " style="">
      <label for="selectpage" class="" style="vertical-align: middle; ">Strana&nbsp;&nbsp;&nbsp;<select name="selectpage" id="selectpage" onchange="ChodNaStranu();" style="font-size: 12px; border: 0; color: rgba(0,0,0, 0.87); border-bottom: 1px solid rgba(0,0,0,0.12); background-color: transparent; min-width: 32px; padding-bottom: 2px; padding-top: 4px;">
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
      </select>&nbsp;&nbsp;/&nbsp;&nbsp;<?php echo $xstr; ?></label>
      </td>
      <td>
      <button id="btnpageprev" type="button" onclick="NaStr(<?php echo $ppage; ?>);" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">navigate_before</i></button><div class="mdl-tooltip" data-mdl-for="btnpageprev" >Prejsù na stranu <?php echo $ppage; ?></div>
      <button id="btnpagenext" type="button" onclick="NaStr(<?php echo $npage; ?>);" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">navigate_next</i></button><div class="mdl-tooltip" data-mdl-for="btnpagenext">Prejsù na stranu <?php echo $npage; ?></div>
      </td>
</form>
    </tr>
  </tfoot>

  </table>
  </div> <!-- .tocenter -->
</div>
</main>

<nav class="mdl-navigation mdl-layout--large-screen-only header-nav " style="width: 300px; display: none;">
    <a href="admin_md.php" class="mdl-navigation__link header-nav-link">Prehæad</a> <!-- dopyt, cez onclick -->
    <a href="#" onclick="Uzivatelia();" class="mdl-navigation__link header-nav-link active">UûÌvatelia</a>
    <a href="firms_md.php" class="mdl-navigation__link header-nav-link">Firmy</a> <!-- dopyt, cez onclick -->
  </nav>

<div class="mdl-layout__drawer">
  <span class="mdl-layout-title">EuroSecom</span>
  <nav class="mdl-navigation">
    <a href="admin_md.php" class="mdl-navigation__link">Prehæad</a>
    <a href="users_md.php" class="mdl-navigation__link mdl-navigation__link--current">UûÌvatelia</a>
    <a href="firms_md.php" class="mdl-navigation__link">Firmy</a>
    <a href="" class="mdl-navigation__link">⁄ËtovnÌctvo</a>
    <a href="" class="mdl-navigation__link">Mzdy</a>
    <a href="" class="mdl-navigation__link">Odbyt</a>
    <a href="" class="mdl-navigation__link">Sklad</a>
    <a href="" class="mdl-navigation__link">Majetok</a>
    <a href="" class="mdl-navigation__link">Anal˝zy</a>
  </nav>
</div>

</div> <!-- .mdl-layout -->

<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

<script type="text/javascript">

  function ObnovUI()
  {

   document.forma3.selectpage.value = '<?php echo $strana; ?>';

//start end pagination
<?php if ( $strana == 1 ) { ?>
   document.getElementById('btnpageprev').disabled = true;
<?php } ?>
<?php if ( $strana == $xstr ) { ?>
   document.getElementById('btnpagenext').disabled = true;
<?php } ?>

<?php if ( $uprav == 1 ) { ?>

   document.formv.h_naz.value = '<?php echo "$h_naz"; ?>';
   document.formv.h_rok.value = '<?php echo "$h_rok"; ?>';
   document.formv.h_duj.value = '<?php echo "$h_duj"; ?>';

<?php                   } ?>

  }


  function upravXcf(xcf,uprav)
  {
    window.open('firms_md.php?copern=<?php echo $copern; ?>&strana=<?php echo $strana; ?>&cislo_xcf=' + xcf + '&uprav=' + uprav + '&hladanie=<?php echo $hladanie; ?>&cohladat=<?php echo $cohladat; ?>', '_self');

  }

  function ChodNaStranu()
  {
   var chodna = document.forma3.selectpage.value;
   window.open('firms_md.php?copern=1&strana=' + chodna + '', '_self');
  }

  function NaStr(chodna)
  {
   window.open('firms_md.php?copern=1&strana=' + chodna + '', '_self');
  }


</script>

</body>
</html>