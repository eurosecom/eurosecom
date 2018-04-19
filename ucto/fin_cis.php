<!doctype html>
<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
$uziv = include("../uziv.php");
if ( !$uziv ) exit;
if (!isset($kli_vxcf)) $kli_vxcf = 1;
       do
       {
//cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$uprav = 1*$_REQUEST['uprav'];
$h_obdp = 1*$_REQUEST['h_obdp'];
$h_obdk = 1*$_REQUEST['h_obdk'];

$xtrd = 1*$_REQUEST['xtrd'];
$xtrd1 = 1*$_REQUEST['xtrd1'];
$xtrd2 = 1*$_REQUEST['xtrd2'];
$xtrd3 = 1*$_REQUEST['xtrd3'];
//echo $h_obdp;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_minrok=$kli_vrok-1;

if ( $h_obdp == 0 ) $h_obdp=$kli_vmes;
if ( $h_obdk == 0 ) $h_obdk=$kli_vmes;

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

$rozuct = $_REQUEST['rozuct'];
if (!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if (!isset($sysx)) $sysx = 'INE';
if ( $sysx == 'UCT' ) $rozuct="ANO";

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$gener=1;
$minul=0;
if( $drupoh == 91 )
{
$uctsys="genfin204pod";
$gener=1;
$minul=0;
}

if( $drupoh == 92 )
{
$uctsys="genfin204no";
$gener=1;
$minul=0;
}

if( $drupoh == 93 )
{
$uctsys="genfin304";
$gener=1;
$minul=0;
}

if( $drupoh == 94 )
{
$uctsys="genfin404";
$gener=1;
$minul=0;
}

if( $drupoh == 96 )
{
$uctsys="genfin604";
$gener=1;
$minul=0;
}

if( $drupoh == 97 )
{
$uctsys="genfin704";
$gener=1;
$minul=0;
}

if( $drupoh == 98 )
{
$uctsys="crf104nuj_no";
$gener=1;
$minul=0;
}

if( $gener == 1 )
{

$sqlt = <<<uctmzd
(
   cpl         int not null auto_increment,
   uce         VARCHAR(10),
   crs         DECIMAL(10,0),
   PRIMARY KEY(cpl)
);
uctmzd;


$sql = 'CREATE TABLE F'.$kli_vxcf.'_'.$uctsys.$sqlt;
$ulozene = mysql_query("$sql");

}
if( $minul == 1 )
{

$sqlt = <<<uctmzd
(
   cpl         int not null auto_increment,
   dok         VARCHAR(10),
   hod         DECIMAL(10,2),
   PRIMARY KEY(cpl)
);
uctmzd;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_'.$uctsys.$sqlt;
$ulozene = mysql_query("$sql");

}

//nacitanie generovania z minuleho roka 
    if ( $copern == 4055 )
    {
?>
<script type="text/javascript">
if ( !confirm ("Chcete naËÌtaù ËÌselnÌk z minulÈho roka ?") )
         { window.close()  }
else
         { location.href='fin_cis.php?copern=4056&page=1&drupoh=<?php echo $drupoh; ?>' }
</script>
<?php
    }

    if ( $copern == 4056 )
    {

$h_ycf=0;
if ( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
$dtbzx = include("../cis/oddel_dtbz1.php");

if( $drupoh == 98 )
  {
$dsqlt = "TRUNCATE F$kli_vxcf"."_crf104nuj_no ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_crf104nuj_no SELECT * FROM ".$databaza."F$h_ycf"."_crf104nuj_no ";
$dsql = mysql_query("$dsqlt");
  }

if( $drupoh == 91 )
  {
$dsqlt = "TRUNCATE F$kli_vxcf"."_genfin204pod ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_genfin204pod SELECT * FROM ".$databaza."F$h_ycf"."_genfin204pod ";
$dsql = mysql_query("$dsqlt");
  }

if( $drupoh == 92 )
  {
$dsqlt = "TRUNCATE F$kli_vxcf"."_genfin204no ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_genfin204no SELECT * FROM ".$databaza."F$h_ycf"."_genfin204no ";
$dsql = mysql_query("$dsqlt");
  }

if( $drupoh == 93 )
  {
$dsqlt = "TRUNCATE F$kli_vxcf"."_genfin304 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_genfin304 SELECT * FROM ".$databaza."F$h_ycf"."_genfin304 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
  }

if( $drupoh == 94 )
  {
$dsqlt = "TRUNCATE F$kli_vxcf"."_genfin404 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_genfin404 SELECT * FROM ".$databaza."F$h_ycf"."_genfin404 ";
$dsql = mysql_query("$dsqlt");
  }

if( $drupoh == 96 )
  {
$dsqlt = "TRUNCATE F$kli_vxcf"."_genfin604 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_genfin604 SELECT * FROM ".$databaza."F$h_ycf"."_genfin604 ";
$dsql = mysql_query("$dsqlt");
  }

if( $drupoh == 97 )
  {
$dsqlt = "TRUNCATE F$kli_vxcf"."_genfin704 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_genfin704 SELECT * FROM ".$databaza."F$h_ycf"."_genfin704 ";
$dsql = mysql_query("$dsqlt");
  }


$copern=308;
    }
//koniec nacitanie generovania z minuleho roka


//nacitanie standartneho generovania
    if ( $copern == 155 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù ötandardn˝ ËÌselnÌk generovania ?") )
         { window.close()  }
else
         { location.href='fin_cis.php?copern=156&page=1&drupoh=<?php echo $drupoh; ?>'  }
</script>
<?php
    }

    if ( $copern == 156 )
    {

if( $drupoh == 91 )
      {
?>
<script type="text/javascript">
window.open('vykaz_fin204pod_2016.php?cislo_oc=1&copern=1001&drupoh=1&fmzdy=&page=1&subor=0&strana=1&nacitajgen=1', '_self' ); 
</script>
<?php
      }

if( $drupoh == 92 )
      {
?>
<script type="text/javascript">
window.open('vykaz_fin204no_2016.php?cislo_oc=1&copern=1001&drupoh=1&fmzdy=&page=1&subor=0&strana=1&nacitajgen=1', '_self' ); 
</script>
<?php
      }

if( $drupoh == 93 )
      {
?>
<script type="text/javascript">
window.open('vykaz_fin304_2016.php?cislo_oc=1&copern=1001&drupoh=1&fmzdy=&page=1&subor=0&strana=1&nacitajgen=1', '_self' ); 
</script>
<?php
      }

if( $drupoh == 94 )
      {
?>
<script type="text/javascript">
window.open('vykaz_fin404_2016.php?cislo_oc=1&copern=1001&drupoh=1&fmzdy=&page=1&subor=0&strana=1&nacitajgen=1', '_self' ); 
</script>
<?php
      }

if( $drupoh == 96 )
      {
?>
<script type="text/javascript">
window.open('vykaz_fin604_2016.php?cislo_oc=1&copern=1001&drupoh=1&fmzdy=&page=1&subor=0&strana=1&nacitajgen=1', '_self' ); 
</script>
<?php
      }

if( $drupoh == 97 )
      {
?>
<script type="text/javascript">
window.open('vykaz_fin704_2016.php?cislo_oc=1&copern=1001&drupoh=1&fmzdy=&page=1&subor=0&strana=1&nacitajgen=1', '_self' ); 
</script>
<?php
      }

exit;
$copern=308;
    }
//koniec nacitania standartneho generovania

//zmazat generovanie
    if ( $copern == 1316 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete zmazaù vöetky poloûky generovania ?") )
         { window.close()  }
else
         { location.href='fin_cis.php?copern=1416&page=1&drupoh=<?php echo $drupoh; ?>'  }
</script>
<?php
    }

    if ( $copern == 1416 )
    {


if( $drupoh == 91 )
      {
$sql = "DELETE FROM F$kli_vxcf"."_genfin204pod ";
$vysledok = mysql_query("$sql");
      }
if( $drupoh == 92 )
      {
$sql = "DELETE FROM F$kli_vxcf"."_genfin204no ";
$vysledok = mysql_query("$sql");
      }
if( $drupoh == 93 )
      {
$sql = "DELETE FROM F$kli_vxcf"."_genfin304 ";
$vysledok = mysql_query("$sql");
      }
if( $drupoh == 94 )
      {
$sql = "DELETE FROM F$kli_vxcf"."_genfin404 ";
$vysledok = mysql_query("$sql");
      }

if( $drupoh == 96 )
      {
$sql = "DELETE FROM F$kli_vxcf"."_genfin604 ";
$vysledok = mysql_query("$sql");
      }

if( $drupoh == 97 )
      {
$sql = "DELETE FROM F$kli_vxcf"."_genfin704 ";
$vysledok = mysql_query("$sql");
      }

if( $drupoh == 98 )
      {
$sql = "DELETE FROM F$kli_vxcf"."_crf104nuj_no ";
$vysledok = mysql_query("$sql");
      }

$copern=308;
    }
//koniec vymaz vsetky

//vymazanie 
if ( $copern == 316 )
    {
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);

$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl = $cislo_cpl  ";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $h_uce=$riadok->uce;
  $h_crs=$riadok->crs;
  }


$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$uctsys WHERE cpl='$cislo_cpl' "); 

$copern=308;
if (!$zmazane):
?>
<script type="text/javascript"> alert( "POLOéKA NEBOLA VYMAZAN¡" ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;
     }
//koniec vymazania
 

//ulozenie noveho 
if ( $copern == 315 AND $uprav != 1 AND $drupoh >= 91  )
    {
$h_uce = $_REQUEST['h_uce'];
$c_uce = 1*$_REQUEST['h_uce'];
$h_crs = 1*$_REQUEST['h_crs'];
$h_ucd = 1*$_REQUEST['h_ucd'];

if( $gener == 1 ) {
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( uce, crs ) VALUES ( '$h_uce', '$h_crs'  ); ";
                  }
if( $minul == 1 ) {
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( dok, hod ) VALUES ( '$h_uce', '$h_crs'  ); "; 
                  }
//echo $ulozttt;

if( $h_uce > 0 ) { $ulozene = mysql_query("$ulozttt"); } 
$copern=308;
$uprav=0;
$xtrd=0;
    }
//koniec ulozenia 

//uprava polozky
if ( $copern == 315 AND $uprav == 1 AND $drupoh >= 81  )
    {
$cislo_cpl = 1*strip_tags($_REQUEST['cislo_cpl']);
$uprav_cpl = 1*strip_tags($_REQUEST['uprav_cpl']);

$h_uce = $_REQUEST['h_uce'];
$c_uce = 1*$_REQUEST['h_uce'];
$h_crs = 1*$_REQUEST['h_crs'];
$h_ucd = 1*$_REQUEST['h_ucd'];

if( $gener == 1 ) {
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( uce, crs ) VALUES ( '$h_uce', '$h_crs'  ); "; 
                  }
if( $minul == 1 ) {
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( dok, hod ) VALUES ( '$h_uce', '$h_crs'  ); "; 
                  }

//echo $ulozttt;
if( $c_uce > 0 ) { $ulozene = mysql_query("$ulozttt"); }
$copern=308;
$uprav=0;
$xtrd=0;
    }
//koniec uprava 

//308=uprava ak uz existuje
if ( $copern == 308 AND $uprav == 1 AND $drupoh >= 91  )
      {
$cislo_cpl = 1*strip_tags($_REQUEST['cislo_cpl']);
$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl = $cislo_cpl  ";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

if( $gener == 1 ) {
$h_uce = $riadok->uce;
$h_crs = $riadok->crs;
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( uce, crs ) VALUES ( '$h_uce', '$h_crs'  ); ";
                  }
if( $minul == 1 ) {
$h_uce = $riadok->dok;
$h_crs = $riadok->hod;
                  }
  }
       }
//koniec uprava nacitanie
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
<link rel="stylesheet" href="../css/reset.css" type="text/css">
<title>EuroSecom - Fin.v˝kazy</title>
<style type="text/css">
body {
  min-width: 900px;
  font-family: Arial, sans-serif;
  background-color: #add8e6;
}
a {
  text-decoration: none;
}
strong {
  font-weight: bold;
}
div.wrap-heading {
  overflow: auto;
  width: 98%;
  padding: 0 1%;
  background-color: #ffff90;
  -webkit-box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
  -moz-box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
  box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
}
div.ilogin {
  font-size: 11px;
  background-color:;
  height: 11px;
  padding-top: 4px;
}
div.ilogin strong {
  margin-left: 6px;
  margin-right: 3px;
}
div.heading {
  height: 36px;
  overflow: hidden;
}
div.heading > h1 {
  line-height: 36px;
  font-size: 20px;
  font-weight: bold;
  font-family: Times, 'Times New Roman', Georgia, serif;
}
div.bar-btn-form-tool {
  position: absolute;
  top: 23px;
  right: 1%;
}
img.btn-form-tool {
  float: right;
  width: 20px;
  height: 20px;
  margin-left: 10px;
  cursor: pointer;
}

div.wrap-content { /* okolie tela */
  position: relative;
  width: 950px;
  margin: 15px auto;
}
div.content-navbar > a { /* zalozky v tele */
  float: left;
  height: 12px;
  font-size: 12px;
  padding: 6px 12px 5px 12px;
  color: #000;
}
div.content-navbar > a:hover, a.active, div.content {
  background-color: #fff;
}
div.content { /* telo strany */
  overflow: auto;
  width: 92%;
  padding: 20px 3% 20px 5%;
}
div.content-heading > h2 { /* nadpis v tele */
  height: 16px;
  font-size: 16px;
  font-weight: bold;
}

/* TABLES */
table.vertical, table.flat {
  width: 360px;
}
table.vertical tbody tr {
  background-color: #eee;
}
table.vertical tbody tr:hover {
  background-color: #fff;
}
table.vertical thead td, table.vertical tbody td {
  border-right: 1px solid #fff;
  border-bottom: 1px solid #fff;
}
table.vertical thead td, table.flat tbody td, table.flat tfoot td {
  position: relative;
  top: 0;
  left: 0;
}
table.vertical thead td, table.flat tbody td {
  height: 30px;
  background-color: #ddd;
}
table.vertical tbody td {
  line-height: 20px;
  font-size: 12px;
}
table.flat thead th {
  height: 14px;
  font-size: 11px;
  color: #777;
}
table.flat tbody td {
  border-bottom: 2px solid #fff;
}
table.flat tbody th {
  line-height: 30px;
  text-align: left;
  font-size: 11px;
  color: #777;
}
table.vertical tfoot td, table.flat tfoot td {
  height: 30px;
}
input[type=text].field {
  display: block;
  width: 50px;
  height: 13px;
  line-height: 13px;
  padding: 3px 0 3px 3px;
  font-size: 12px;
  border: 1px solid #c2c2c2;
  position: absolute;
  top: 5px;
  left: 17px;
}
input[type=text].field:focus {
  -webkit-box-shadow: none;
  -moz-box-shadow: none;
  box-shadow: none;
  border: 1px solid #888;
}

/* BUTTONS */
span:after, a:before, a:after {
  display: inline-block;
  content: '';
  background-repeat: no-repeat;
}
span.legend-criadok:after {
  width: 11px;
  height: 11px;
  background-image: url(../obr/info.png);
  vertical-align: -1px;
  margin-left: 4px;
}
a.sort-field {
  height: 14px;
  font-size: 11px;
  color: #777;
  display: block;
}
a.sort-field:after {
  width: 12px;
  height: 12px;
  background-image: url(../obr/ikony/arrowdown37_gray_x12.png);
  vertical-align: -2px;
  margin-left: 2px;
}
a.btn-down-x26 {
  display: block;
  line-height: 26px;
  padding: 0 9px 0 7px;
  font-size: 11px;
  font-weight: bold;
  color: #fff;
  background-color: #39f;
  -moz-border-radius: 2px;
  -webkit-border-radius: 2px;
  border-radius: 2px;
  margin-left: 10px;
}
a.btn-down-x26:before {
  background-image: url(../obr/ikony/download6_white_x16.png);
  width: 16px;
  height: 16px;
  vertical-align: -4px;
  margin-right: 3px;
}
a.btn-edit, a.btn-cancel {
  display: inline-block;
  width: 16px;
  height: 16px;
  vertical-align: -2px;
}
a.btn-edit {
  background-image: url(../obr/ikony/pencil3_blue_x16.png);
}
a.btn-cancel {
  background-image: url(../obr/ikony/xmark_red_x16.png);
}
a.btn-edit, a.btn-cancel, a.btn-down-x26 {
  -moz-opacity: 0.7;
  -khtml-opacity: 0.7;
  opacity: 0.7;
}
a.btn-edit:hover, a.btn-cancel:hover, a.btn-down-x26:hover {
  -moz-opacity: 1;
  -khtml-opacity: 1;
  opacity: 1;
}
div.wrap-area-uloz {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
div.area-uloz {
  position: absolute;
  top: 2px;
  left: 15px;
  width: 60px;
  height: 26px;
}
input[type=submit] {
  display: block;
  width: 56px;
  height: 22px;
  margin: 2px auto;
  font-size:13px;
}

/* ALERTS */
div.alert-warning {
  font-weight:bold;
  background-color: ;
  font-size: 12px;
  color: #FF0000;
  line-height: 24px;
  padding-left: 5px;
}
.toleft {
  float: left;
}
.toright {
  float: right;
}
</style>

<script type="text/javascript">
  function VyberVstup()
  {
  }

  function ObnovUI()
  {
<?php if ( $copern == 308 AND $uprav >= 0 AND $drupoh >= 91 ) { ?>
   document.formv1.h_uce.value = '<?php echo "$h_uce";?>';
   document.formv1.h_crs.value = '<?php echo "$h_crs";?>';
   document.formv1.uloz.disabled = true;
   document.forms.formv1.h_uce.focus();
   document.forms.formv1.h_uce.select();
<?php                                                         } ?>
  }

//Kontrola cisla
  function KontrolaCisla(Vstup, Oznam)
  {
   if ( Vstup.value.search(/[^0-9]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
   if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; Vstup.style.borderColor = "red"; }
   else { Oznam.style.display="none"; Vstup.style.borderColor = ""; }
  }
//Kontrola cisla desatinneho
  function KontrolaDcisla(Vstup, Oznam)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; Vstup.style.borderColor = "red"; }
   else { Oznam.style.display="none"; Vstup.style.borderColor = ""; }
  }


  function Povol_uloz()
  {
    var okvstup=1;

    if ( document.formv1.h_crs.value == '' ) okvstup=0;
    if ( document.formv1.h_uce.value == '' ) okvstup=0;

    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }
  }
  function ZmazPolozku(cpl)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/fin_cis.php?copern=316&page=1&sysx=UCT&cislo_cpl=' + cislo_cpl + '&drupoh=<?php echo $drupoh; ?>&uprav=0', '_self');
  }
  function UpravPolozku(cpl)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/fin_cis.php?copern=308&page=1&sysx=UCT&uprav_cpl=' + cislo_cpl + '&cislo_cpl=' + cislo_cpl + '&drupoh=<?php echo $drupoh; ?>&uprav=1', '_self');
  }
  function ZmazVsetky()
  {
   window.open('../ucto/fin_cis.php?copern=1316&page=1&sysx=UCT&drupoh=<?php echo $drupoh; ?>&uprav=0', '_self');
  }

  function UceEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; //kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_crs.focus();
        document.forms.formv1.h_crs.select();
              }

                }

 function Crs96Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;

    if ( document.formv1.h_crs.value == '' ) okvstup=0;
    if ( document.formv1.h_uce.value == '' ) okvstup=0;

    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; document.forms.formv1.submit(); return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }
              }

                }

 function CrsEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;

    if ( document.formv1.h_crs.value == '' ) okvstup=0;
    if ( document.formv1.h_uce.value == '' ) okvstup=0;
    if ( document.formv1.h_uce.value == '0' ) okvstup=0;

    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }
              }
                }

  function Crs95Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_ucd.focus();
        document.forms.formv1.h_ucd.select();
              }

                }

  function UcdEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;

    if ( document.formv1.h_crs.value == '' ) okvstup=0;
    if ( document.formv1.h_uce.value == '' ) okvstup=0;
    if ( document.formv1.h_crs.value == '0' ) okvstup=0;
    if ( document.formv1.h_uce.value == '0' ) okvstup=0;

    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }
              }
                }
</script>
</HEAD>
<BODY id="white" onload="ObnovUI(); VyberVstup();">
<!-- zahlavie -->
<div class="wrap-heading">
 <div class="ilogin">
  <h6 class="toleft">EuroSecom</h6>
  <h6 class="toright">
   <strong>UME</strong><?php echo $kli_vume; ?>
   <strong>FIR</strong><?php echo "$kli_vxcf:$kli_nxcf"; ?>
   <strong>login</strong><?php echo "$kli_uzmeno $kli_uzprie / $kli_uzid"; ?>
  </h6>
 </div>
 <div class="heading">
  <h1 class="toleft">FinanËnÈ v˝kazy -
   <span style="color:#39f;">nastavenie generovania
   </span>
  </h1>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/trash_blue_icon.png" onclick="ZmazVsetky();" title="Vymazaù vöetky poloûky z generovania"
     class="btn-form-tool" style="margin:0;">
   </div>
 </div>
</div> <!-- .wrap-heading -->

<div class="wrap-content">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive";
$clas4="noactive"; $clas5="noactive"; $clas6="noactive";
if ( $drupoh == 91 OR $drupoh == 191 ) $clas1="active";
if ( $drupoh == 92 OR $drupoh == 192 ) $clas2="active";
if ( $drupoh == 93 OR $drupoh == 193 ) $clas3="active";
if ( $drupoh == 94 OR $drupoh == 194 ) $clas4="active";
if ( $drupoh == 96 OR $drupoh == 196 ) $clas5="active";
if ( $drupoh == 97 OR $drupoh == 197 ) $clas6="active";
if ( $drupoh == 98 OR $drupoh == 198 ) $clas7="active";
$source="../ucto/fin_cis.php?copern=308";
?>

<div class="content-navbar toright">
<?php if ( $drupoh >= 91 AND $drupoh <= 98 ) { ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=98', '_self');"
    title="Fin 1-12 - generovanie" class="<?php echo $clas7; ?>">Fin 1-12</a>
<?php if ( $kli_vrok <= 2017 ) { ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=92', '_self');"
    title="Fin 2-04 NO generovanie" class="<?php echo $clas2; ?>">Fin 2-04 NO</a>
<?php    } ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=91', '_self');"
    title="Fin 2-04 POD generovanie" class="<?php echo $clas1; ?>">Fin 2-04 POD</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=93', '_self');"
    title="Fin 3-04 - generovanie" class="<?php echo $clas3; ?>">Fin 3-04</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=94', '_self');"
    title="Fin 4-04 - generovanie" class="<?php echo $clas4; ?>">Fin 4-04</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=96', '_self');"
    title="Fin 6-04 - generovanie" class="<?php echo $clas5; ?>">Fin 6-04</a>
<?php if ( $kli_vrok <= 2017 ) { ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=97', '_self');"
    title="Fin 7-04 - generovanie" class="<?php echo $clas6; ?>">Fin 7-04</a>
<?php    } ?>
<?php                                        } ?>
</div>

<div class="content">
 <div class="content-heading" style="height:30px;">
  <h2>
<?php
if ( $drupoh == 98 OR $drupoh == 198 ) { echo "Fin 1-12 - Generovanie"; }
if ( $drupoh == 92 OR $drupoh == 192 ) { echo "Fin 2-04 NO - Generovanie"; }
if ( $drupoh == 91 OR $drupoh == 191 ) { echo "Fin 2-04 POD - Generovanie"; }
if ( $drupoh == 93 OR $drupoh == 193 ) { echo "Fin 3-04 - Generovanie"; }
if ( $drupoh == 94 OR $drupoh == 194 ) { echo "Fin 4-04 - Generovanie"; }
if ( $drupoh == 96 OR $drupoh == 196 ) { echo "Fin 6-04 - Generovanie"; }
if ( $drupoh == 97 OR $drupoh == 197 ) { echo "Fin 7-04 - Generovanie"; }
?>
   <img src='../obr/info.png' title="EnterNext = kl·vesou ENTER prejdete na Ôalöiu poloûku">
  </h2>
 </div>
<?php
$triedenie="BY cpl DESC ";
if( $xtrd1 == 0 ) { $xtrd1x=1; }
if( $xtrd2 == 0 ) { $xtrd2x=3; }
if( $xtrd3 == 0 ) { $xtrd3x=5; }
if( $xtrd1 == 1 ) { $triedenie="BY uce "; $xtrd1x=2;}
if( $xtrd1 == 2 ) { $triedenie="BY uce DESC "; $xtrd1x=1;}
if( $xtrd2 == 3 ) { $triedenie="BY crs "; $xtrd2x=4;}
if( $xtrd2 == 4 ) { $triedenie="BY crs DESC "; $xtrd2x=3;}
if( $xtrd3 == 5 ) { $triedenie="BY ucd "; $xtrd3x=6;}
if( $xtrd3 == 6 ) { $triedenie="BY ucd DESC "; $xtrd3x=5;}
$xtrd1=$xtrd1x; $xtrd2=$xtrd2x; $xtrd3=$xtrd3x;
//uprava vykazu 91-95,191-195
if ( $drupoh >= 91 )
{
if ( $gener == 1 ) {
$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER $triedenie";
                   }
if ( $minul == 1 ) {
$sqltt = "SELECT cpl, dok AS uce, hod AS crs FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER $triedenie";
                   }
$sql = mysql_query("$sqltt");
//echo $sqltt;

//celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

$varcolspan = 2; 
?>
<FORM name="formv1" method="post" action="fin_cis.php?copern=315&uprav=<?php echo $uprav;?>&drupoh=<?php echo $drupoh;?>&xtrd=0">
 <table class="vertical toleft">
 <thead>
 <tr>
  <th style="width:25%;"></th><th style="width:25%;"></td>
  <th style="width:25%;"></th><th style="width:25%;"></td>
 </tr>
 <tr>
<?php
if ( $gener == 1 )
{
if ( $drupoh == 98 OR $drupoh == 198 ) { $stlpec1="⁄Ëet"; $stlpec2="RozpoËtov· poloûka"; }
if ( $drupoh == 92 OR $drupoh == 192 ) { $stlpec1="⁄Ëet"; $stlpec2="Riadok"; }
if ( $drupoh == 91 OR $drupoh == 191 ) { $stlpec1="⁄Ëet"; $stlpec2="Riadok"; }
if ( $drupoh == 93 OR $drupoh == 193 ) { $stlpec1="⁄Ëet"; $stlpec2="StÂpec"; }
if ( $drupoh == 94 OR $drupoh == 194 ) { $stlpec1="⁄Ëet"; $stlpec2="StÂpec"; }
if ( $drupoh == 96 OR $drupoh == 196 ) { $stlpec1="⁄Ëet"; $stlpec2="Riadok"; }
if ( $drupoh == 97 OR $drupoh == 197 ) { $stlpec1="⁄Ëet"; $stlpec2="Riadok"; }
?>
  <th>
   <a href="#" title="Zoradiù" class="sort-field" onclick="window.open('fin_cis.php?copern=308&uprav=<?php echo $uprav;?>&drupoh=<?php echo $drupoh;?>&xtrd1=<?php echo $xtrd1;?>&xtrd2=0&xtrd3=0', '_self');"><?php echo $stlpec1; ?></a>
  </th>
  <th colspan="2">
   <a href="#" title="Zoradiù" class="sort-field" onclick="window.open('fin_cis.php?copern=308&uprav=<?php echo $uprav;?>&drupoh=<?php echo $drupoh;?>&xtrd2=<?php echo $xtrd2;?>&xtrd1=0&xtrd3=0', '_self');"><?php echo $stlpec2; ?></a>
  </th>
<?php
}
?>
<?php if ( $minul == 1 ) { ?>
  <th><a href="#" title="Zoradiù" class="sort-field" onclick="window.open('fin_cis.php?copern=308&uprav=<?php echo $uprav;?>&drupoh=<?php echo $drupoh;?>&xtrd1=<?php echo $xtrd1;?>&xtrd2=0&xtrd3=0', '_self');">Riadok</a></th>
  <th colspan="2"><a href="#" title="sort-field" class="sort-field" onclick="window.open('fin_cis.php?copern=308&uprav=<?php echo $uprav;?>&drupoh=<?php echo $drupoh;?>&xtrd2=<?php echo $xtrd2;?>&xtrd1=0&xtrd3=0', '_self');">Hodnota</a></th>
<?php                    } ?>
  <th>&nbsp;</th>
 </tr>
 <tr style="">
  <td style="">
   <input type="text" name="h_uce" id="h_uce" onkeyup="KontrolaCisla(this, Cele)"
    onKeyDown="return UceEnter(event.which)" class="field"/>
  </td>
  <td colspan="<?php echo $varcolspan ?>" >
   <input type="text" name="h_crs" id="h_crs" class="field" 
<?php if ( $drupoh != 93 AND $drupoh != 94 AND $drupoh != 193 AND $drupoh != 194 ) { ?> onkeyup="KontrolaCisla(this, Cele)" <?php } ?>
<?php if ( $drupoh == 93 OR  $drupoh == 94 OR  $drupoh == 193 OR  $drupoh == 194 ) { ?> onkeyup="KontrolaDcisla(this, Desc)" <?php } ?>
   />
  </td>
  <td>
   <div onmouseover="Fx.style.display='none';" class="wrap-area-uloz">&nbsp;</div>
   <div onmouseover="return Povol_uloz();" class="area-uloz">
    <input type="submit" id="uloz" name="uloz" value="Uloûiù" style="">
   </div>
  </td>
 </tr>
 <tr>
  <th colspan="4" style="text-align:left;">
   <div id="Cele" class="alert-warning" style="display:none;">MusÌ byù celÈ ËÌslo</div>
   <div id="Desc" class="alert-warning" style="display:none;">MusÌ byù desatinnÈ ËÌslo</div>
   <div id="Fx" class="alert-warning" style="display:none;">VyplÚte vöetky poloûky</div>
  </th>
 </tr>
 </thead>
<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
 <tbody>
 <tr>
  <td style="text-align:center;"><?php echo $riadok->uce; ?></td>
  <td colspan="<?php echo $varcolspan; ?>" style="text-align:right;">
  <?php echo $riadok->crs; ?>&nbsp;&nbsp;</td>

<?php if ( $drupoh == 95 OR $drupoh == 195 ) { ?>
  <td style="text-align:right;"><?php echo $riadok->ucd;?>&nbsp;&nbsp;</td>
<?php                                        } ?>
  <td style="text-align:center;">

   <a href="#" onclick="ZmazPolozku(<?php echo $riadok->cpl;?>);" title="Vymazaù" class="btn-cancel"></a>
  </td>
 </tr>
 </tbody>
<?php
  }
$i = $i + 1;
   }
?>
 <tfoot>
  <tr><td colspan="4">&nbsp;</td></tr>
 </tfoot>
 </table>
</FORM>
<?php
}
//koniec uprava vykazu 91-95,191-195
?>



<?php
$vartitle = "ËÌselnÌk";
?>
<?php if ( ( $drupoh >= 91 AND $kli_vrok > 2016 ) OR $drupoh == 98 ) { ?>
 <a href='fin_cis.php?drupoh=<?php echo $drupoh; ?>&copern=4055&page=1'
  title="NaËÌtaù <?php echo $vartitle; ?> generovania z firmy predch·dzaj˙ceho ˙ËtovnÈho obdobia"
  class="btn-down-x26 toright">Generovanie <?php echo $kli_minrok; ?></a>
<?php                         } ?>

<?php if ( $drupoh >= 91 AND $drupoh != 98 ) { ?>
 <a href='fin_cis.php?drupoh=<?php echo $drupoh; ?>&copern=155&page=1'
  title="NaËÌtaù ötandardn˝ ËÌselnÌk" class="btn-down-x26 toright">ätandardn˝</a>
<?php                                                                              } ?>

</div> <!-- .content -->
</div> <!-- .wrap-content -->
<?php
//celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>