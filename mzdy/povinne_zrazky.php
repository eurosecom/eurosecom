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

if( $drupoh >= 1 )
{
$uctsys="mzdpovinnezrz";
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
   dmn         DECIMAL(3,0) DEFAULT 0,
   iban        VARCHAR(40) NOT NULL,
   celk        DECIMAL(10,2) DEFAULT 0,

   druh        DECIMAL(2,0) DEFAULT 0,
   cstm        DECIMAL(10,2) DEFAULT 0,
   zivm        DECIMAL(10,2) DEFAULT 0,
   napov       DECIMAL(10,2) DEFAULT 0,
   pocvz       DECIMAL(2,0) DEFAULT 0,
   navyz       DECIMAL(10,2) DEFAULT 0,
   poodp       DECIMAL(10,2) DEFAULT 0,
   smnad       DECIMAL(10,2) DEFAULT 0,
   zvscs       DECIMAL(10,2) DEFAULT 0,
   treti       DECIMAL(10,2) DEFAULT 0,
   pctre       DECIMAL(2,0) DEFAULT 0,
   zrazk       DECIMAL(10,2) DEFAULT 0,

   des6        DECIMAL(13,6) DEFAULT 0,
   des2        DECIMAL(10,2) DEFAULT 0,
   PRIMARY KEY(cpl)
);
uctmzd;


$sql = "CREATE TABLE F".$kli_vxcf."_".$uctsys.$sqlt;
$ulozene = mysql_query("$sql");

$sql = "SELECT zosr FROM F".$kli_vxcf."_".$uctsys;
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sqlfir = "ALTER TABLE F".$kli_vxcf."_".$uctsys." ADD npcr DECIMAL(10,2) DEFAULT 0 AFTER des2 ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F".$kli_vxcf."_".$uctsys." ADD splr DECIMAL(10,2) DEFAULT 0 AFTER des2 ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F".$kli_vxcf."_".$uctsys." ADD mmes DECIMAL(10,2) DEFAULT 0 AFTER des2 ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F".$kli_vxcf."_".$uctsys." ADD zosr DECIMAL(10,2) DEFAULT 0 AFTER des2 ";
$sqldok = mysql_query("$sqlfir");
}

//zober cistu mzdu 
if ( $copern == 9001 )
    {
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);

$cstmx=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcsum$kli_uzid WHERE oc = $cislo_oc AND ume = $kli_vume ";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $cstmx=1*$riadok->cista_mzda;

  }

$sqltt = "UPDATE F$kli_vxcf"."_$uctsys SET cstm = $cstmx WHERE cpl = $cislo_cpl  ";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 


$copern=308;

     }
//koniec zober cistu mzdu

//nastav do trv 
if ( $copern == 8001 )
    {
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);

$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl = $cislo_cpl  ";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $hlvnx=1*$riadok->hlvn;
  $dmnx=1*$riadok->dmn;
  $ibanx=$riadok->iban;
  $zrazkx=$riadok->zrazk;

  }

$sqltt = "UPDATE F$kli_vxcf"."_mzdtrn SET kc=$zrazkx WHERE oc = $hlvnx AND dm = $dmnx AND trx4 = '$ibanx'  ";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 


$copern=308;

     }
//koniec nastav do trv



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
  $dmn = $_REQUEST['dmn'];
  $iban = $_REQUEST['iban'];

  $druh = $_REQUEST['druh'];
  $cstm = $_REQUEST['cstm'];
  $zivm = $_REQUEST['zivm'];
  $napov = $_REQUEST['napov'];
  $pocvz = $_REQUEST['pocvz'];
  $navyz = $_REQUEST['navyz'];
  $poodp = $_REQUEST['poodp'];
  $smnad = $_REQUEST['smnad'];
  $zvscs = $_REQUEST['zvscs'];
  $treti = $_REQUEST['treti'];
  $pctre = $_REQUEST['pctre'];
  $zrazk = $_REQUEST['zrazk'];

  $mmes = $_REQUEST['mmes'];
  $celk = $_REQUEST['celk'];
  $npcr = $_REQUEST['npcr'];
  $splr = $_REQUEST['splr'];
  $zosr = $_REQUEST['zosr'];



$ulozttt = "DELETE FROM F$kli_vxcf"."_$uctsys WHERE hlvn = $h_hlvn ";
$ulozene = mysql_query("$ulozttt");

$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( hlvn, dmn, iban, druh, cstm, zivm, napov, pocvz, navyz, poodp, ".
" smnad, zvscs, treti, pctre, zrazk, mmes, celk, npcr, splr, zosr ) ".
" VALUES ( '$h_hlvn', '$dmn', '$iban', '$druh', '$cstm', '$zivm', '$napov', '$pocvz', '$navyz', '$poodp', '$smnad', ".
" '$zvscs', '$treti', '$pctre', '$zrazk', '$mmes', '$celk', '$npcr', '$splr', '$zosr' ); ";
$ulozene = mysql_query("$ulozttt"); 
//echo $ulozttt;
$copern=308;
$uprav=0;
$xtrd=0;
    }
//koniec ulozenia 


//vypocty
$ziv_min=199.48;
$ziv_min25=49.87;
$ziv_min50=99.74;
$ziv_min150=299.22;
$ziv_min70z60=83.78;
$ziv_min70z25=34.90;

$ulozttt = "UPDATE F$kli_vxcf"."_$uctsys SET druh=1 WHERE druh = 0 ";
$ulozene = mysql_query("$ulozttt");

$ulozttt = "UPDATE F$kli_vxcf"."_$uctsys SET zivm='$ziv_min', smnad='$ziv_min150' ";
$ulozene = mysql_query("$ulozttt"); 

$ulozttt = "UPDATE F$kli_vxcf"."_$uctsys SET napov='$ziv_min', navyz=pocvz*'$ziv_min25' WHERE druh = 1 ";
$ulozene = mysql_query("$ulozttt");

$ulozttt = "UPDATE F$kli_vxcf"."_$uctsys SET napov='$ziv_min70z60', navyz=pocvz*'$ziv_min70z25' WHERE druh = 2 ";
$ulozene = mysql_query("$ulozttt");

$ulozttt = "UPDATE F$kli_vxcf"."_$uctsys SET napov='$ziv_min', navyz=pocvz*'$ziv_min50' WHERE druh = 3 ";
$ulozene = mysql_query("$ulozttt");

$ulozttt = "UPDATE F$kli_vxcf"."_$uctsys SET poodp=cstm-napov-navyz ";
$ulozene = mysql_query("$ulozttt");

$ulozttt = "UPDATE F$kli_vxcf"."_$uctsys SET poodp=0 WHERE poodp < 0 ";
$ulozene = mysql_query("$ulozttt");

$ulozttt = "UPDATE F$kli_vxcf"."_$uctsys SET des6=poodp/3, des6=des6-0.0049 WHERE poodp < $ziv_min150 ";
$ulozene = mysql_query("$ulozttt");

$ulozttt = "UPDATE F$kli_vxcf"."_$uctsys SET des6='$ziv_min150'/3, des6=des6-0.0049 WHERE poodp >= $ziv_min150 ";
$ulozene = mysql_query("$ulozttt");

$ulozttt = "UPDATE F$kli_vxcf"."_$uctsys SET treti=des6 ";
$ulozene = mysql_query("$ulozttt");

$ulozttt = "UPDATE F$kli_vxcf"."_$uctsys SET zvscs=poodp-smnad ";
$ulozene = mysql_query("$ulozttt"); 

$ulozttt = "UPDATE F$kli_vxcf"."_$uctsys SET zvscs=0 WHERE zvscs < 0 ";
$ulozene = mysql_query("$ulozttt");

$ulozttt = "UPDATE F$kli_vxcf"."_$uctsys SET pctre=1 WHERE pctre = 0 ";
$ulozene = mysql_query("$ulozttt");

$ulozttt = "UPDATE F$kli_vxcf"."_$uctsys SET pctre=2 WHERE druh = 2 ";
$ulozene = mysql_query("$ulozttt");

$ulozttt = "UPDATE F$kli_vxcf"."_$uctsys SET zrazk=(pctre*treti)+zvscs ";
$ulozene = mysql_query("$ulozttt");

//koniec vypocty


//nacitanie
$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE hlvn = $cislo_oc ";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $cislo_cpl=1*$riadok->cpl;
  $h_hlvn=1*$riadok->hlvn;
  $dmn=1*$riadok->dmn;
  $iban=$riadok->iban;

  $druh=1*$riadok->druh;
  $cstm=1*$riadok->cstm;
  $zivm=1*$riadok->zivm;
  $napov=1*$riadok->napov;
  $pocvz=1*$riadok->pocvz;
  $navyz=1*$riadok->navyz;
  $poodp=1*$riadok->poodp;
  $smnad=1*$riadok->smnad;
  $zvscs=1*$riadok->zvscs;
  $treti=1*$riadok->treti;
  $pctre=1*$riadok->pctre;
  $zrazk=1*$riadok->zrazk;

  $mmes=1*$riadok->mmes;
  $celk=1*$riadok->celk;
  $npcr=1*$riadok->npcr;
  $splr=1*$riadok->splr;
  $zosr=1*$riadok->zosr;

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


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
<link rel="stylesheet" href="../css/reset.css" type="text/css">
<title>EuroSecom - PovinnÈ zr·ûky</title>
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
  width: 860px;
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
   document.formv1.dmn.value = '<?php echo "$dmn";?>';
   document.formv1.iban.value = '<?php echo "$iban";?>';

   document.formv1.druh.value = '<?php echo "$druh";?>';
   document.formv1.cstm.value = '<?php echo "$cstm";?>';
   document.formv1.zivm.value = '<?php echo "$zivm";?>';
   document.formv1.napov.value = '<?php echo "$napov";?>';
   document.formv1.pocvz.value = '<?php echo "$pocvz";?>';
   document.formv1.navyz.value = '<?php echo "$navyz";?>';
   document.formv1.poodp.value = '<?php echo "$poodp";?>';
   document.formv1.smnad.value = '<?php echo "$smnad";?>';
   document.formv1.zvscs.value = '<?php echo "$zvscs";?>';
   document.formv1.treti.value = '<?php echo "$treti";?>';
   document.formv1.pctre.value = '<?php echo "$pctre";?>';
   document.formv1.zrazk.value = '<?php echo "$zrazk";?>';

   document.formv1.mmes.value = '<?php echo "$mmes";?>';
   document.formv1.celk.value = '<?php echo "$celk";?>';
   document.formv1.npcr.value = '<?php echo "$npcr";?>';
   document.formv1.splr.value = '<?php echo "$splr";?>';
   document.formv1.zosr.value = '<?php echo "$zosr";?>';

   document.formv1.uloz.disabled = true;
   document.forms.formv1.dmn.focus();
   document.forms.formv1.dmn.select();
<?php                      } ?>
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
    if ( document.formv1.dmn.value == '' ) okvstup=0;

    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }
  }
  function ZmazPolozku(cpl)
  {
   var cislo_cpl = cpl;
   window.open('../mzdy/povinne_zrazky.php?copern=316&cislo_oc=<?php echo $cislo_oc;?>&page=1&sysx=UCT&cislo_cpl=' + cislo_cpl + '&drupoh=<?php echo $drupoh; ?>&uprav=0', '_self');
  }

  function UpravPolozku(cpl, oc)
  {
   var cislo_cpl = cpl;
   window.open('../mzdy/povinne_zrazky.php?copern=308&cislo_oc=' + oc + '&page=1&sysx=UCT&uprav_cpl=' + cislo_cpl + '&cislo_cpl=' + cislo_cpl + '&drupoh=1&uprav=1', '_self');
  }

  function doTrv()
  {
   window.open('../mzdy/trvale.php?copern=1&drupoh=1&zkun=1&cislo_oc=<?php echo $cislo_oc;?>&page=1'
, '_blank',  'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function nastavTrv()
  {
   window.open('../mzdy/povinne_zrazky.php?copern=8001&cislo_oc=<?php echo $cislo_oc;?>&page=1&sysx=UCT&cislo_cpl=<?php echo $cislo_cpl;?>&drupoh=1&uprav=0', '_self');
  }

  function nastavCstm()
  {
   window.open('../mzdy/povinne_zrazky.php?copern=9001&cislo_oc=<?php echo $cislo_oc;?>&page=1&sysx=UCT&cislo_cpl=<?php echo $cislo_cpl;?>&drupoh=1&uprav=0', '_self');
  }

  function HlvnEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; //kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.dmn.focus();
        document.forms.formv1.dmn.select();
              }

                }

  function DmnEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; //kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.iban.focus();
        document.forms.formv1.iban.select();
              }

                }


 function ZrazkEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;

    if ( document.formv1.h_hlvn.value == '' ) okvstup=0;
    if ( document.formv1.dmn.value == '' ) okvstup=0;
    if ( document.formv1.iban.value == '' ) okvstup=0;

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
  <h1 class="toleft">Zr·ûky zo mzdy pri v˝kone rozhodnutia 
<?php if ( $drupoh == 1 ) { ?>
   <span style="color:#39f;"> - osobnÈ ËÌslo <?php echo "$cislo_oc"; ?> <?php echo $prie." ".$meno." rË. ".$rdc." ".$rdk; ?>
   </span>
<?php                     } ?>
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
if ( $drupoh == 2 OR $drupoh == 192 ) $clas1="active";

$source="../mzdy/povinne_zrazky.php?copern=308&cislo_oc=$cislo_oc";
?>

<div class="content-navbar toright">
<?php if ( $drupoh >= 1 ) { ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=2', '_self');" title="Zr·ûky zo mzdy" class="<?php echo $clas1; ?>">Zr·ûky zo mzdy</a>
<?php                                        } ?>
</div>

<div class="content">
 <div class="content-heading" style="height:30px;">
  <h2>
<?php
if ( $drupoh == 1 OR $drupoh == 191 ) { echo "Zr·ûky zo mzdy"; }
if ( $drupoh == 2 OR $drupoh == 192 ) { echo "Zoznam zr·ûkok zo mzdy"; }
?>
   <img src='../obr/info.png' title="EnterNext = kl·vesou ENTER prejdete na Ôalöiu poloûku">
  </h2>
 </div>
<?php

//uprava zrazky 
if ( $drupoh == 1 )
{

$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 AND hlvn = $cislo_oc ORDER BY cpl ";
$sql = mysql_query("$sqltt");
//echo $sqltt;

//celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

?>
<FORM name="formv1" method="post" action="povinne_zrazky.php?copern=315&cislo_oc=<?php echo $cislo_oc;?>&uprav=<?php echo $uprav;?>&drupoh=<?php echo $drupoh;?>&xtrd=0">
 <table class="vertical toleft">
 <thead>
 <tr>
  <th style="width:20%;"></th>
  <th style="width:20%;"></th>
  <th style="width:45%;"></th>
  <th ></td>
 </tr>
 <tr style="">
  <td style="">
   osË <input type="text" name="h_hlvn" id="h_hlvn" onkeyup="KontrolaCisla(this, Cele)"
    onKeyDown="return HlvnEnter(event.which)" style="width: 80px;" readonly="readonly"/>
  </td>
  <td colspan="1" >
   <img src='../obr/info.png' title="Druh mzdy v trval˝ch poloûk·ch, na ktor˝ ide zr·ûka zo mzdy">
   dmn <input type="text" name="dmn" id="dmn" style="width: 80px;" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return DmnEnter(event.which)" />
  </td>
  <td colspan="1" >
   <input type="text" name="iban" id="iban" style="width: 290px;" onKeyDown="return IbanEnter(event.which)" />
    iban 
   <img src='../obr/info.png' title="IBAN z Druhu mzdy v trval˝ch poloûk·ch, na ktor˝ ide zr·ûka zo mzdy">
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

 <tr style="">
  <td colspan="2"> Maxim·lna mesaËn· zr·ûka:</td>
  <td colspan="1" >
   <input type="text" name="mmes" id="mmes" style="width: 70px;" onkeyup="KontrolaDcisla(this, Cele)"  />
 </td>
 </tr>

 <tr style="">
  <td style="" colspan="2"> Druh zr·ûky:</td>
  <td colspan="1" >

<select class="hvstup" size="1" name="druh" id="druh" onKeyDown="return DruhEnter(event.which)" >
<option value="1" >peÚaûnÈ plnenie</option>
<option value="2" >v˝ûivnÈ na maloletÈ dieùa</option>
<option value="3" >peÚaûnÈ plnenie, poberateæ dÙchodku</option>
</select>

  </td>
 </tr>

 <tr style="">
  <td style="" colspan="2"> »ist· mzda povinnÈho »MP:</td>
  <td colspan="1" >
   <input type="text" name="cstm" id="cstm" style="width: 80px;" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return CstmEnter(event.which)" />
&nbsp&nbsp&nbsp&nbsp&nbsp
   <img src='../obr/vlozit.png' onclick="nastavCstm();" width=15 height=15 border=0 title="Nastaviù »ist˙ mzdu povinnÈho z neostrÈho spracovania" >
  </td>
 </tr>

 <tr style="">
  <td style="" colspan="2"> èivotnÈ minimum:</td>
  <td colspan="1" >
   <input type="text" name="zivm" id="zivm" style="width: 80px;" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return ZivmEnter(event.which)" />
  </td>
 </tr>

 <tr style="">
  <td style="" colspan="2"> Sumy, ktorÈ sa nesm˙ zraziù:</td>
  <td colspan="1" >
  </td>
 </tr>

 <tr style="">
<?php //$druh=2; ?>
<?php if( $druh <= 1 ) { ?>
  <td style="" colspan="2"> a) na povinnÈho ( 100% éM ):</td>
<?php                  } ?>
<?php if( $druh == 2 ) { ?>
  <td style="" colspan="2"> a) na povinnÈho ( 70% zo 60% éM ):</td>
<?php                  } ?>
<?php if( $druh == 3 ) { ?>
  <td style="" colspan="2"> a) na povinnÈho ( 100% éM ):</td>
<?php                  } ?>
  <td colspan="1" >
   <input type="text" name="napov" id="napov" style="width: 80px;" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return NapovEnter(event.which)" />
  </td>
 </tr>

 <tr style="">
<?php if( $druh <= 1 ) { ?>
  <td style="" colspan="2"> b) na vyûivovan˙ osobu ( 25% zo éM ):</td>
<?php                  } ?>
<?php if( $druh == 2 ) { ?>
  <td style="" colspan="2"> a) na vyûivovan˙ osobu ( 70% z 25% éM ):</td>
<?php                  } ?>
<?php if( $druh == 3 ) { ?>
  <td style="" colspan="2"> b) na vyûivovan˙ osobu ( 50% zo éM ):</td>
<?php                  } ?>
  <td colspan="1" >
   <input type="text" name="navyz" id="navyz" style="width: 80px;" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return NavyzEnter(event.which)" />
  </td>
 </tr>

 <tr style="">
  <td style="" colspan="2"> PoËet vyûivovan˝ch osÙb:</td>
  <td colspan="1" >
   <input type="text" name="pocvz" id="pocvz" style="width: 80px;" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return PocvzEnter(event.which)" />
  </td>
 </tr>

 <tr style="">
  <td style="" colspan="2"> Po odpoËÌtanÌ:</td>
  <td colspan="1" >
   <input type="text" name="poodp" id="poodp" style="width: 80px;" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return PoodpEnter(event.which)" />
  </td>
 </tr>

 <tr style="">
  <td style="" colspan="2"> Suma, nad ktor˙ sa zvyöok »MP zrazÌ bez obmedzenia (150 % zo éM)</td>
  <td colspan="1" >
   <input type="text" name="smnad" id="smnad" style="width: 80px;" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return SmnadEnter(event.which)" />
  </td>
 </tr>

 <tr style="">
  <td style="" colspan="2"> Zvyöok »MP, ktor· sa zrazÌ bez obmedzenia:</td>
  <td colspan="1" >
   <input type="text" name="zvscs" id="zvscs" style="width: 80px;" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return ZvscsEnter(event.which)" />
  </td>
 </tr>

 <tr style="">
  <td style="" colspan="2"> 1/3 na zr·ûku</td>
  <td colspan="1" >
   <input type="text" name="treti" id="treti" style="width: 80px;" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return TretiEnter(event.which)" />
  </td>
 </tr>

 <tr style="">
  <td style="" colspan="2"> PoËet tretÌn na zrazenie:</td>
  <td colspan="1" >
   <input type="text" name="pctre" id="pctre" style="width: 80px;" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return PctreEnter(event.which)" />
  </td>
 </tr>

 <tr style="">
  <td style="" colspan="2"> Celkov· zr·ûka zo mzdy:</td>
  <td colspan="1" >
   <input type="text" name="zrazk" id="zrazk" style="width: 80px;" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return ZrazkEnter(event.which)" />
&nbsp&nbsp&nbsp&nbsp&nbsp
   <img src='../obr/import.png' onclick="nastavTrv();" width=15 height=15 border=0 title="Nastaviù celkov˙ zr·ûku do trval˝ch mzdov˝ch poloûiek" >
&nbsp&nbsp&nbsp&nbsp&nbsp
   <img src='../obr/zoznam.png' onclick="doTrv();" width=15 height=15 border=0 title="TrvalÈ mzdovÈ poloûky zamestnanca osË <?php echo $hlvn; ?>" >
  </td>
 </tr>

 <tr style="">
  <td colspan="4">
 </td>
 </tr>

 <tr style="">
  <td colspan="4"> 
  Celkom pohæad·vka: <input type="text" name="celk" id="celk" style="width: 70px;" onkeyup="KontrolaDcisla(this, Cele)"  />
  Stav k 1.1.: <input type="text" name="npcr" id="npcr" style="width: 70px;" onkeyup="KontrolaDcisla(this, Cele)"  />
  SplatenÈ v roku: <input type="text" name="splr" id="splr" style="width: 70px;" onkeyup="KontrolaDcisla(this, Cele)"  />
  Nesplaten˝ zostatok: <input type="text" name="zosr" id="zosr" style="width: 70px;" onkeyup="KontrolaDcisla(this, Cele)"  />
 </td>
 </tr>

 </thead>

 <tfoot>
  <tr><td colspan="4">&nbsp;</td></tr>
 </tfoot>
 </table>
</FORM>
<?php
}
//koniec uprava zrazky
?>

<?php
//zoznam zrazok
if ( $drupoh == 2 )
{

$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_$uctsys.hlvn=F$kli_vxcf"."_mzdkun.oc".
" WHERE cpl > 0 ORDER BY hlvn ";
$sql = mysql_query("$sqltt");
//echo $sqltt;

//celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
?>

<FORM name="formv1" method="post" action="#" >
 <table class="vertical toleft">
 <thead>
 <tr>
  <th style="width:20%;">osË priezvisko</th>
  <th style="width:20%;">dmn</th>
  <th style="width:45%;">iban</th>
  <th ></td>
 </tr>

<?php
   while ($i <= $cpol )
   {

  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
 <tbody>
 <tr>
  <td style="text-align:center;"><?php echo $riadok->hlvn; ?> <?php echo $riadok->prie; ?></td>
  <td colspan="1" style="text-align:center;">
  <?php echo $riadok->dmn; ?>&nbsp;&nbsp;</td>
  <td colspan="1" style="text-align:center;">
  <?php echo $riadok->iban; ?>&nbsp;&nbsp;</td>
  <td style="text-align:center;">
   <a href="#" onclick="ZmazPolozku(<?php echo $riadok->cpl;?>);" title="Vymazaù nastavenie povinnej zr·ûky" class="btn-cancel"></a>
   &nbsp&nbsp&nbsp
   <a href="#" onclick="UpravPolozku(<?php echo $riadok->cpl;?>, <?php echo $riadok->hlvn;?>);" title="Upraviù nastavenie povinnej zr·ûky" class="btn-edit"></a>
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
//koniec zoznam zrazok
?>



</div> <!-- .content -->
</div> <!-- .wrap-content -->
<?php
//celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>