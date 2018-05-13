<!doctype html>
<HTML>
<?php
$sys = 'MZD';
$urov = 1000;
$uziv = include("../uziv.php");
if ( !$uziv ) exit;
if (!isset($kli_vxcf)) $kli_vxcf = 1;
       do
       {
//cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];
$uprav = 1*$_REQUEST['uprav'];


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


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

if( $drupoh == 1 )
{
$uctsys="mzdsubeznepp";
}


$sqlt = <<<uctmzd
(
   cpl         int not null auto_increment,
   hlvn        DECIMAL(10,0) DEFAULT 0,
   sub1        DECIMAL(10,0) DEFAULT 0,
   sub2        DECIMAL(10,0) DEFAULT 0,
   sub3        DECIMAL(10,0) DEFAULT 0,
   sub4        DECIMAL(10,0) DEFAULT 0,
   sub5        DECIMAL(10,0) DEFAULT 0,
   PRIMARY KEY(cpl)
);
uctmzd;


$sql = "CREATE TABLE F".$kli_vxcf."_".$uctsys.$sqlt;
$ulozene = mysql_query("$sql");



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
  $h_hlvn=1*$riadok->hlvn;
  $h_sub1=1*$riadok->sub1;
  $h_sub2=1*$riadok->sub2;
  $h_sub3=1*$riadok->sub3;
  $h_sub4=1*$riadok->sub4;
  $h_sub5=1*$riadok->sub5;
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
if ( $copern == 315 AND $uprav != 1 AND $drupoh == 1  )
    {
$h_hlvn = $_REQUEST['h_hlvn'];
$h_sub1 = 1*$_REQUEST['h_sub1'];
$h_sub2 = 1*$_REQUEST['h_sub2'];
$h_sub3 = 1*$_REQUEST['h_sub3'];
$h_sub4 = 1*$_REQUEST['h_sub4'];
$h_sub5 = 1*$_REQUEST['h_sub5'];

$ulozttt = "DELETE FROM F$kli_vxcf"."_$uctsys WHERE hlvn = $h_hlvn ";
$ulozene = mysql_query("$ulozttt");

$ulozttt = "DELETE FROM F$kli_vxcf"."_$uctsys WHERE sub1 = $h_hlvn ";
$ulozene = mysql_query("$ulozttt");

$ulozttt = "DELETE FROM F$kli_vxcf"."_$uctsys WHERE sub2 = $h_hlvn ";
$ulozene = mysql_query("$ulozttt");

$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( hlvn, sub1, sub2, sub3, sub4, sub5 ) VALUES ".
"( '$h_hlvn', '$h_sub1', '$h_sub2', '$h_sub3', '$h_sub4', '$h_sub5'  ); ";
if( $h_hlvn != $h_sub1 AND $h_hlvn != $h_sub2 AND $h_sub1 != $h_sub2 )$ulozene = mysql_query("$ulozttt"); 
$copern=308;
$uprav=0;
$xtrd=0;
    }
//koniec ulozenia 


//nacitanie
$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE hlvn = $cislo_oc OR sub1 = $cislo_oc OR sub2 = $cislo_oc ";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $h_hlvn=1*$riadok->hlvn;
  $h_sub1=1*$riadok->sub1;
  $h_sub2=1*$riadok->sub2;
  $h_sub3=1*$riadok->sub3;
  $h_sub4=1*$riadok->sub4;
  $h_sub5=1*$riadok->sub5;
  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $h_hlvn  ";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $prie=$riadok->prie;
  $meno=$riadok->meno;
  $rdc=$riadok->rdc;
  $rdk=$riadok->rdk;
  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $h_sub1  ";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $prie1=$riadok->prie;
  $meno1=$riadok->meno;
  $rdc1=$riadok->rdc;
  $rdk1=$riadok->rdk;
  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $h_sub2  ";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $prie2=$riadok->prie;
  $meno2=$riadok->meno;
  $rdc2=$riadok->rdc;
  $rdk2=$riadok->rdk;
  }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
<link rel="stylesheet" href="../css/reset.css" type="text/css">
<title>EuroSecom - S˙beûnÈ PP</title>
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
<?php if ( $drupoh == 1 ) { ?>
   document.formv1.h_hlvn.value = '<?php echo "$cislo_oc";?>';
   document.formv1.h_sub1.value = '<?php echo "$h_sub1";?>';
   document.formv1.h_sub2.value = '<?php echo "$h_sub2";?>';
   document.formv1.uloz.disabled = true;
   document.forms.formv1.h_sub1.focus();
   document.forms.formv1.h_sub1.select();
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

    if ( document.formv1.h_hlvn.value == '' ) okvstup=0;
    if ( document.formv1.h_sub1.value == '' ) okvstup=0;

    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }
  }
  function ZmazPolozku(cpl)
  {
   var cislo_cpl = cpl;
   window.open('../mzdy/subeznepp.php?copern=316&cislo_oc=<?php echo $cislo_oc;?>&page=1&sysx=UCT&cislo_cpl=' + cislo_cpl + '&drupoh=<?php echo $drupoh; ?>&uprav=0', '_self');
  }
  function UpravPolozku(cpl)
  {
   var cislo_cpl = cpl;
   window.open('../mzdy/subeznepp.php?copern=308&cislo_oc=<?php echo $cislo_oc;?>&page=1&sysx=UCT&uprav_cpl=' + cislo_cpl + '&cislo_cpl=' + cislo_cpl + '&drupoh=<?php echo $drupoh; ?>&uprav=1', '_self');
  }

  function HlvnEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; //kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_sub1.focus();
        document.forms.formv1.h_sub1.select();
              }

                }

  function Sub1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; //kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_sub2.focus();
        document.forms.formv1.h_sub2.select();
              }

                }


 function Sub2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;

    if ( document.formv1.h_hlvn.value == '' ) okvstup=0;
    if ( document.formv1.h_sub1.value == '' ) okvstup=0;
    if ( document.formv1.h_sub1.value == '0' ) okvstup=0;

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
  <h1 class="toleft">S˙beûnÈ PP  -
   <span style="color:#39f;">osobnÈ ËÌslo <?php echo "$cislo_oc"; ?> <?php echo $prie." ".$meno." rË. ".$rdc." ".$rdk; ?>
   </span>
  </h1>
   <div class="bar-btn-form-tool">
   </div>
 </div>
</div> <!-- .wrap-heading -->

<div class="wrap-content">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive";
$clas4="noactive"; $clas5="noactive"; $clas6="noactive";
if ( $drupoh == 1 OR $drupoh == 191 ) $clas1="active";
if ( $drupoh == 2 OR $drupoh == 192 ) $clas2="active";

$source="../mzdy/subeznepp.php?copern=308&cislo_oc=$cislo_oc";
?>

<div class="content-navbar toright">
<?php if ( $drupoh == 1 ) { ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=1', '_self');" title="S˙beûnÈ PP" class="<?php echo $clas1; ?>">S˙beûnÈ PP</a>
<?php                                        } ?>
</div>

<div class="content">
 <div class="content-heading" style="height:30px;">
  <h2>
<?php
if ( $drupoh == 1 OR $drupoh == 191 ) { echo "S˙beûnÈ PP"; }
if ( $drupoh == 2 OR $drupoh == 192 ) { echo "Fin 2-04 NO - Generovanie"; }
?>
   <img src='../obr/info.png' title="EnterNext = kl·vesou ENTER prejdete na Ôalöiu poloûku">
  </h2>
 </div>
<?php
$triedenie="BY cpl DESC ";
if( $xtrd1 == 1 ) { $triedenie="BY osc "; }


//uprava vykazu 1
if ( $drupoh == 1 )
{

$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 AND ( hlvn = $cislo_oc OR sub1 = $cislo_oc OR sub2 = $cislo_oc ) ORDER $triedenie";
$sql = mysql_query("$sqltt");
//echo $sqltt;

//celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

?>
<FORM name="formv1" method="post" action="subeznepp.php?copern=315&cislo_oc=<?php echo $cislo_oc;?>&uprav=<?php echo $uprav;?>&drupoh=<?php echo $drupoh;?>&xtrd=0">
 <table class="vertical toleft">
 <thead>
 <tr>
  <th style="width:25%;"></th><th style="width:25%;"></td>
  <th style="width:25%;"></th><th style="width:25%;"></td>
 </tr>
 <tr>
<?php
if ( $drupoh == 2 OR $drupoh == 192 ) { $stlpec1="⁄Ëet"; $stlpec2="Riadok"; }
if ( $drupoh == 1 OR $drupoh == 191 ) { $stlpec1="HlavnÈ osË"; $stlpec2="S˙beûnÈ osË 1"; $stlpec3="S˙beûnÈ osË 2"; }
?>
  <th>
   <a href="#" title="Zoradiù" class="sort-field" onclick="window.open('subeznepp.php?copern=308&cislo_oc=<?php echo $cislo_oc;?>&uprav=<?php echo $uprav;?>&drupoh=<?php echo $drupoh;?>&xtrd1=<?php echo $xtrd1;?>&xtrd2=0&xtrd3=0', '_self');"><?php echo $stlpec1; ?></a>
  </th>
  <th colspan="1">
   <a href="#" title="Zoradiù" class="sort-field" onclick="window.open('subeznepp.php?copern=308&cislo_oc=<?php echo $cislo_oc;?>&uprav=<?php echo $uprav;?>&drupoh=<?php echo $drupoh;?>&xtrd2=<?php echo $xtrd2;?>&xtrd1=0&xtrd3=0', '_self');"><?php echo $stlpec2; ?></a>
  </th>
  <th colspan="1">
   <a href="#" title="Zoradiù" class="sort-field" onclick="window.open('subeznepp.php?copern=308&cislo_oc=<?php echo $cislo_oc;?>&uprav=<?php echo $uprav;?>&drupoh=<?php echo $drupoh;?>&xtrd2=<?php echo $xtrd2;?>&xtrd1=0&xtrd3=0', '_self');"><?php echo $stlpec3; ?></a>
  </th>
  <th>&nbsp;</th>
 </tr>
 <tr style="">
  <td style="">
   <input type="text" name="h_hlvn" id="h_hlvn" onkeyup="KontrolaCisla(this, Cele)"
    onKeyDown="return HlvnEnter(event.which)" class="field" readonly="readonly"/>
  </td>
  <td colspan="1" >
   <input type="text" name="h_sub1" id="h_sub1" class="field" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return Sub1Enter(event.which)" />
  </td>
  <td colspan="1" >
   <input type="text" name="h_sub2" id="h_sub2" class="field" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return Sub2Enter(event.which)" />
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
  <td style="text-align:center;"><?php echo $riadok->hlvn; ?></td>
  <td colspan="1" style="text-align:center;">
  <?php echo $riadok->sub1; ?>&nbsp;&nbsp;</td>
  <td colspan="1" style="text-align:center;">
  <?php echo $riadok->sub2; ?>&nbsp;&nbsp;</td>
  <td style="text-align:center;">
   <a href="#" onclick="ZmazPolozku(<?php echo $riadok->cpl;?>);" title="Vymazaù" class="btn-cancel"></a>
  </td>
 </tr>
<?php if ( $riadok->hlvn > 0 ) { ?>
 <tr>
  <td style="text-align:center;" colspan="4">
  <span style="color:#39f;">AktÌvne prepojenie</span>
  </td>
 </tr>
<?php                    } ?>
<?php if ( $riadok->hlvn > 0 ) { ?>
 <tr>
  <td style="text-align:left;" colspan="4">
  <span style="color:#39f;">HlavnÈ osobnÈ ËÌslo <?php echo "$h_hlvn"; ?> - <?php echo $prie." ".$meno." rË. ".$rdc." ".$rdk; ?></span>
  </td>
 </tr>
<?php                    } ?>
<?php if ( $riadok->sub1 > 0 ) { ?>
 <tr>
  <td style="text-align:left;" colspan="4">
  <span style="color:#39f;">1. S˙beûnÈ osobnÈ ËÌslo <?php echo "$h_sub1"; ?> - <?php echo $prie1." ".$meno1." rË. ".$rdc1." ".$rdk1; ?></span>
  </td>
 </tr>
<?php                    } ?>
<?php if ( $riadok->sub2 > 0 ) { ?>
 <tr>
  <td style="text-align:left;" colspan="4">
  <span style="color:#39f;">2. S˙beûnÈ osobnÈ ËÌslo <?php echo "$h_sub2"; ?> - <?php echo $prie2." ".$meno2." rË. ".$rdc2." ".$rdk2; ?></span>
  </td>
 </tr>
<?php                    } ?>
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
//koniec uprava vykazu 1
?>





</div> <!-- .content -->
</div> <!-- .wrap-content -->
<?php
//celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>