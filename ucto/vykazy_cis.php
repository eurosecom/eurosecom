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

//echo $h_obdp;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

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
if(!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if(!isset($sysx)) $sysx = 'INE';
if( $sysx == 'UCT' ) $rozuct="ANO";

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$gener=1;
$minul=0;
if( $drupoh == 91 )
{
$uctsys="crs_muj2014";
$gener=1;
$minul=0;
}
if( $drupoh == 93 )
{
$uctsys="pos_muj2014";
$gener=0;
$minul=1;
}
if( $drupoh == 95 )
{
$uctsys="uctsyngensuv_muj2014";
$gener=1;
$minul=0;
}
if( $drupoh == 92 )
{
$uctsys="crv_muj2014";
$gener=1;
$minul=0;
}
if( $drupoh == 94 )
{
$uctsys="pov_muj2014";
$gener=0;
$minul=1;
}
if( $drupoh == 96 )
{
$uctsys="uctparzaok_muj2014";
$gener=1;
$minul=0;
}
if( $drupoh == 191 )
{
$uctsys="crs_pod2014";
$gener=1;
$minul=0;
}
if( $drupoh == 193 )
{
$uctsys="pos_pod2014";
$gener=0;
$minul=1;
}
if( $drupoh == 195 )
{
$uctsys="uctsyngensuv_pod2014";
$gener=1;
$minul=0;
}
if( $drupoh == 192 )
{
$uctsys="crv_pod2014";
$gener=1;
$minul=0;
}
if( $drupoh == 194 )
{
$uctsys="pov_pod2014";
$gener=0;
$minul=1;
}
if( $drupoh == 196 )
{
$uctsys="uctparzaok_pod2014";
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

if( $drupoh == 95 OR $drupoh == 195 )
     {
$sqlt = <<<uctmzd
(
   cpl         int not null auto_increment,
   dok         VARCHAR(10),
   ucm         DECIMAL(10,0),
   ucd         DECIMAL(10,0),
   PRIMARY KEY(cpl)
);
uctmzd;
     }


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
if ( !confirm ("Chcete na��ta� generovanie z minul�ho roka ?") ) //dopyt, �o je to za hl�ku?
         { window.close()  }
else
         { location.href='vykazy_cis.php?copern=4056&page=1&drupoh=<?php echo $drupoh; ?>' }
</script>
<?php
    }

    if ( $copern == 4056 )
    {

$h_ycf=0;
if ( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
$dtbzx = include("../cis/oddel_dtbz1.php");


$dsqlt = "TRUNCATE F$kli_vxcf"."_".$uctsys." ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_".$uctsys." SELECT * FROM ".$databaza."F$h_ycf"."_".$uctsys." ";
$dsql = mysql_query("$dsqlt");


$copern=308;
    }
//koniec nacitanie generovania z minuleho roka


//nacitanie standartneho generovania
    if ( $copern == 155 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete na��ta� �tandartn� ��seln�k generovania ?") )
         { window.close()  }
else
         { location.href='vykazy_cis.php?copern=156&page=1&drupoh=<?php echo $drupoh; ?>'  }
</script>
<?php
    }

    if ( $copern == 156 )
    {

if ( $drupoh == 96 ) {
$sql = "DELETE FROM F$kli_vxcf"."_uctparzaok_muj2014 ";
$vysledok = mysql_query("$sql");

$sql = "INSERT INTO F".$kli_vxcf."_uctparzaok_muj2014 (uce, crs) VALUE ('15', '17') ";
$ulozene = mysql_query("$sql");

$uprav=1;
                     }

if ( $drupoh == 91 ) {

$sql = "DELETE FROM F$kli_vxcf"."_crs_muj2014 ";
$vysledok = mysql_query("$sql");

$subor = fopen("../import/crs_muj$kli_vrok.csv", "r");
while (! feof($subor))
     {
  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_uce = $pole[0];
  $x_crs = $pole[1];
  $x_kon = $pole[2];
 
$c_uce=1*$x_uce;

if( $c_uce > 0 )
{
$sqult = "INSERT INTO F$kli_vxcf"."_crs_muj2014 ( uce,crs )".
" VALUES ( '$x_uce', '$x_crs' ); "; 

$ulozene = mysql_query("$sqult"); 
}
     }
                     }

if ( $drupoh == 92 ) {

$sql = "DELETE FROM F$kli_vxcf"."_crv_muj2014 ";
$vysledok = mysql_query("$sql");

$subor = fopen("../import/crv_muj$kli_vrok.csv", "r");
while (! feof($subor))
     {
  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_uce = $pole[0];
  $x_crs = $pole[1];
  $x_kon = $pole[2];
 
$c_uce=1*$x_uce;

if( $c_uce > 0 )
{
$sqult = "INSERT INTO F$kli_vxcf"."_crv_muj2014 ( uce,crs )".
" VALUES ( '$x_uce', '$x_crs' ); "; 

$ulozene = mysql_query("$sqult"); 
}
     }
                     }

if ( $drupoh == 95 ) {

$sql = "DELETE FROM F$kli_vxcf"."_uctsyngensuv_muj2014 ";
$vysledok = mysql_query("$sql");

$subor = fopen("../import/uctsyngensuv_muj$kli_vrok.csv", "r");
while (! feof($subor))
     {
  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_dok = $pole[0];
  $x_ucm = $pole[1];
  $x_ucd = $pole[2];
  $x_kon = $pole[3];
 
$c_dok=1*$x_dok;

if( $c_dok > 0 )
{
$sqult = "INSERT INTO F$kli_vxcf"."_uctsyngensuv_muj2014 ( dok,ucm,ucd )".
" VALUES ( '$x_dok', '$x_ucm', '$x_ucd' ); "; 

$ulozene = mysql_query("$sqult"); 
}
     }
                     }

if ( $drupoh == 196 ) {
$sql = "DELETE FROM F$kli_vxcf"."_uctparzaok_pod2014 ";
$vysledok = mysql_query("$sql");

$sql = "INSERT INTO F".$kli_vxcf."_uctparzaok_pod2014 (uce, crs) VALUE ('35', '26') ";
$ulozene = mysql_query("$sql");

$uprav=1;
                     }

if ( $drupoh == 191 ) {

$sql = "DELETE FROM F$kli_vxcf"."_crs_pod2014 ";
$vysledok = mysql_query("$sql");

$subor = fopen("../import/crs_pod$kli_vrok.csv", "r");
while (! feof($subor))
     {
  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_uce = $pole[0];
  $x_crs = $pole[1];
  $x_kon = $pole[2];

$c_uce=1*$x_uce;

if( $c_uce > 0 )
{
$sqult = "INSERT INTO F$kli_vxcf"."_crs_pod2014 ( uce,crs )".
" VALUES ( '$x_uce', '$x_crs' ); ";

$ulozene = mysql_query("$sqult");
}
     }
                     }

if ( $drupoh == 192 ) {

$sql = "DELETE FROM F$kli_vxcf"."_crv_pod2014 ";
$vysledok = mysql_query("$sql");

$subor = fopen("../import/crv_pod$kli_vrok.csv", "r");
while (! feof($subor))
     {
  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_uce = $pole[0];
  $x_crs = $pole[1];
  $x_kon = $pole[2];

$c_uce=1*$x_uce;

if( $c_uce > 0 )
{
$sqult = "INSERT INTO F$kli_vxcf"."_crv_pod2014 ( uce,crs )".
" VALUES ( '$x_uce', '$x_crs' ); ";

$ulozene = mysql_query("$sqult");
}
     }
                     }

if ( $drupoh == 195 ) {

$sql = "DELETE FROM F$kli_vxcf"."_uctsyngensuv_pod2014 ";
$vysledok = mysql_query("$sql");

$subor = fopen("../import/uctsyngensuv_pod$kli_vrok.csv", "r");
while (! feof($subor))
     {
  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_dok = $pole[0];
  $x_ucm = $pole[1];
  $x_ucd = $pole[2];
  $x_kon = $pole[3];

$c_dok=1*$x_dok;

if( $c_dok > 0 )
{
$sqult = "INSERT INTO F$kli_vxcf"."_uctsyngensuv_pod2014 ( dok,ucm,ucd )".
" VALUES ( '$x_dok', '$x_ucm', '$x_ucd' ); ";

$ulozene = mysql_query("$sqult");
}
     }
                     }

$copern=308;
    }
//koniec nacitania standartneho generovania


//vymazanie 
if ( $copern == 316 )
    {
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$uctsys WHERE cpl='$cislo_cpl' "); 

$copern=308;
if (!$zmazane):
?>
<script type="text/javascript"> alert( "POLO�KA NEBOLA VYMAZAN�" ) </script>
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
$h_uce = strip_tags($_REQUEST['h_uce']);
$h_crs = strip_tags($_REQUEST['h_crs']);
$h_ucd = strip_tags($_REQUEST['h_ucd']);

if( $gener == 1 ) {
if( $drupoh == 96 OR $drupoh == 196 )
     {
$ulozttx = "DELETE FROM F$kli_vxcf"."_$uctsys ";
$ulozenx = mysql_query("$ulozttx");
     } 
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( uce, crs ) VALUES ( '$h_uce', '$h_crs'  ); ";
if( $drupoh == 95 OR $drupoh == 195 )
     {
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( dok, ucm, ucd ) VALUES ( '$h_uce', '$h_crs', '$h_ucd'  ); ";
     } 
                  }
if( $minul == 1 ) {
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( dok, hod ) VALUES ( '$h_uce', '$h_crs'  ); "; 
                  }
//echo $ulozttt;

$ulozene = mysql_query("$ulozttt"); 
$copern=308;
$uprav=0;

if (!$ulozene):
?>
<script type="text/javascript"> alert( "POLO�KA NEBOLA SPR�VNE ULO�EN�" ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec ulozenia 

//uprava polozky
if ( $copern == 315 AND $uprav == 1 AND $drupoh >= 81  )
    {
$cislo_cpl = 1*strip_tags($_REQUEST['cislo_cpl']);
$uprav_cpl = 1*strip_tags($_REQUEST['uprav_cpl']);

$h_uce = strip_tags($_REQUEST['h_uce']);
$h_crs = strip_tags($_REQUEST['h_crs']);
$h_ucd = strip_tags($_REQUEST['h_ucd']);

if( $gener == 1 ) {
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( uce, crs ) VALUES ( '$h_uce', '$h_crs'  ); ";
if( $drupoh == 95 OR $drupoh == 195 )
     {
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( dok, ucm, ucd ) VALUES ( '$h_uce', '$h_crs', '$h_ucd'  ); ";
     }  
                  }
if( $minul == 1 ) {
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( dok, hod ) VALUES ( '$h_uce', '$h_crs'  ); "; 
                  }

//echo $ulozttt;
$ulozene = mysql_query("$ulozttt"); 
$copern=308;
$uprav=0;
if (!$ulozene):
?>
<script type="text/javascript"> alert( "POLO�KA NEBOLA SPR�VNE ULO�EN�" ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec uprava 

//308=uprava ak uz existuje
if ( $copern == 308 AND $uprav == 1 AND $drupoh >= 91  )
      {
$cislo_cpl = 1*strip_tags($_REQUEST['cislo_cpl']);
$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl = $cislo_cpl  ";
if( $drupoh == 96 OR $drupoh == 196 )
    {
$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl >= 0 ";
    }
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

if( $gener == 1 ) {
$h_uce = $riadok->uce;
$h_crs = $riadok->crs;
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( uce, crs ) VALUES ( '$h_uce', '$h_crs'  ); ";
if( $drupoh == 95 OR $drupoh == 195 )
     {
$h_uce = $riadok->dok;
$h_crs = $riadok->ucm;
$h_ucd = $riadok->ucd;
     }
                  }
if( $minul == 1 ) {
$h_uce = $riadok->dok;
$h_crs = $riadok->hod;
                  }
  }
       }
//koniec uprava nacitanie

if( $drupoh != 96 AND $drupoh != 196 AND $uprav == 1)
    {
$sqltx = "DELETE FROM F$kli_vxcf"."_$uctsys WHERE cpl = $cislo_cpl ";
//echo $sqltx;
$sqlx = mysql_query("$sqltx"); 
    }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css" type="text/css">
 <link rel="stylesheet" href="../css/tlaciva.css" type="text/css">
<title>EuroSecom -
<?php
if ( $drupoh >= 91 AND $drupoh <= 96 ) echo "M�J";
if ( $drupoh >= 191 AND $drupoh <= 196 ) echo "P�";
?>
&nbsp;z�vierka nastavenie</title>
<style type="text/css">
ul.legend-vykazy { /* legenda v zahlavi */
  position: relative;
  top: 7px;
  line-height: 20px;
  font-size: 12px;
}
ul.legend-vykazy span {
  padding: 0px 3px;
}
.darkgreen {
  background-color: #1ccba8;
  color: #0c5445;
}
.purple {
  background-color: #a39dcd;
  color: #433b74;
}
.darkgray {
  background-color: #b1bdbd;
  color: #4a5758;
}
div.wrap-content { /* centrovanie tela strany */
  position: relative;
  width: 950px;
  margin: 15px auto;
}
div.content-navbar > a { /* prepinanie vykazov */
  display: block;
  float: left;
  height: 12px;
  font-size: 12px;
  padding: 6px 10px 4px 10px;
}
div.content-navbar > a:hover, a.active, div.content {
  background-color: #fff;
}
div.content { /* telo strany */
  overflow: auto;
  width: 92%;
  padding: 20px 3% 20px 5%;
}
div.content-heading { /* zahlavie tela */
  height: 30px;
}
div.content-heading > h2 {
  height: 16px;
  font-size: 16px;
  font-weight: bold;

}

a.btn-down-x26:hover {
  opacity: 1; /* dopyt, prefixy */
}
a.btn-down-x26 {
  line-height: 26px;
  padding: 0 9px 0 7px;
  font-size: 11px; /* dopyt, sk�si� shortland */
  color: #fff;
  background-color: #39f;
  border-radius: 2px; /* dopyt, prefixy */
  font-weight: bold;
  display: block;
  margin-left: 10px;
  opacity: 0.8; /* dopyt, prefixy */
}
a.btn-down-x26:before {
  display: inline-block; /* dopyt, zos�ladi� s ostatn�mi :before, :after */
  background-image: url(../obr/ikony/download6_white_x16.png);
  background-repeat: no-repeat; /* dopyt, zos�ladi� s ostatn�mi :before, :after */
  content: ''; /* dopyt, zos�ladi� s ostatn�mi :before, :after */
  width: 16px;
  height: 16px;
  vertical-align: -4px;
  margin-right: 3px;
}

table.content-body {
  overflow: auto;
  width: 360px;
  background-color: red;
}
table.content-body tr {
  background-color: #eee;
}
table.content-body tr:hover {
  background-color: #fff;

}
table.content-body thead th {
  background-color: #fff;
  font-size: 11px;
  height: 13px;
  border-bottom: 1px solid #eee;

}
table.content-body tbody td {
  line-height: 20px;
  border-bottom: 1px solid #fff;
  border-right: 1px solid #fff;
  font-size: 12px;
  
}
table.content-body tfoot th {
  height: 26px;
  line-height: 26px;
/*   padding-top: 4px;
  padding-bottom: 6px; */
  background-color: #ddd;
}
table.content-body tfoot td {
  height: 26px;
  line-height: 26px;
  background-color: #fff;

}


input[type=text].field {
  display: block;
  width: 50px;
  height: 13px !important;
  line-height: 13px;
/*   border: 2px solid #82c5df; */
  padding: 3px 0 3px 3px !important;
  font-size: 13px;
  border: 1px solid #c2c2c2;
  margin-top: 3px;
}

table.content-body-fixed {
  overflow: auto;
  width: 200px;
  margin-top: 15px;
}
table.content-body-fixed th {
  background-color: #fff;
  font-size: 11px;
  height: 14px;
  text-align: left;

}
table.content-body-fixed td {
  height: 12px;
  padding: 7px 0 6px 0;
  border-bottom: 1px solid #fff;
  border-right: 1px solid #fff;
  font-size: 12px;
  background-color: #eee;
}

a.btn-edit, a.btn-cancel {
  display: inline-block;
  width: 16px;
  height: 16px;
  vertical-align: -4px;
  opacity: 0.8; /* dopyt, prefixy */
  display: ;
}
a.btn-edit {
  background-image: url(../obr/ikony/pencil3_blue_x16.png);
  background-repeat: no-repeat;

}
a.btn-cancel {
  background-image: url(../obr/ikony/xmark_red_x16.png);
  background-repeat: no-repeat;

}

a.btn-edit:hover, a.btn-cancel:hover {
  opacity: 1; /* dopyt, prefixy */
}

span.alert-error {
  font-weight:bold;
  background-color: ;
  font-size: 13px;
  vertical-align: middle;
  color: red;
}




</style>

<script type="text/javascript">
//sirka a vyska okna
var vyskawin = screen.height-175; //dopyt, chcem da� pre�

  function VyberVstup()
  {
  }

  function ObnovUI()
  {
<?php if ( $copern == 308 AND $uprav >= 0 AND $drupoh >= 91 ) { ?>
   document.formv1.h_uce.value = '<?php echo "$h_uce";?>';
   document.formv1.h_crs.value = '<?php echo "$h_crs";?>';
<?php if ( $drupoh == 95 OR $drupoh == 195 ) { ?>
   document.formv1.h_ucd.value = '<?php echo "$h_ucd";?>';
<?php                      } ?>
   document.formv1.uloz.disabled = true;
   document.forms.formv1.h_uce.focus();
   document.forms.formv1.h_uce.select();
<?php                                                         } ?>
  }

//Kontrola cisla
  function KontrolaCisla(Vstup, Oznam)
  {
   if ( Vstup.value.search(/[^0-9]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
   if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; }
   else { Oznam.style.display="none"; }
  }
//Kontrola cisla desatinneho
  function KontrolaDcisla(Vstup, Oznam)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
   else { Oznam.style.display="none"; }
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
   window.open('../ucto/vykazy_cis.php?copern=316&page=1&sysx=UCT&cislo_cpl=' + cislo_cpl + '&drupoh=<?php echo $drupoh; ?>&uprav=0', '_self');
  }
  function UpravPolozku(cpl)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/vykazy_cis.php?copern=308&page=1&sysx=UCT&uprav_cpl=' + cislo_cpl + '&cislo_cpl=' + cislo_cpl + '&drupoh=<?php echo $drupoh; ?>&uprav=1', '_self');
  }

  function UceEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // k�d stla�enej kl�vesy

  if(k == 13 ){
        document.forms.formv1.h_crs.focus();
        document.forms.formv1.h_crs.select();
              }

                }

 function Crs96Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // k�d stla�enej kl�vesy

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
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // k�d stla�enej kl�vesy

  if(k == 13 ){
    var okvstup=1;

    if ( document.formv1.h_crs.value == '' ) okvstup=0;
    if ( document.formv1.h_uce.value == '' ) okvstup=0;

    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }
              }
                }

  function Crs95Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // k�d stla�enej kl�vesy

  if(k == 13 ){
        document.forms.formv1.h_ucd.focus();
        document.forms.formv1.h_ucd.select();
              }

                }

  function UcdEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // k�d stla�enej kl�vesy

  if(k == 13 ){
    var okvstup=1;

    if ( document.formv1.h_crs.value == '' ) okvstup=0;
    if ( document.formv1.h_uce.value == '' ) okvstup=0;

    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }
              }
                }
 
</script>
</HEAD>
<BODY id="white" onload="ObnovUI(); VyberVstup();">
<div id="wrap-heading">
 <table id="heading">
 <tr>
  <td class="ilogin">EuroSecom</td>
  <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
 </tr>
 <tr>
  <td class="header">��tovn� z�vierka
   <span class="subheader">
<?php
if ( $drupoh >= 91 AND $drupoh <= 96 ) echo "mikro ��tovnej jednotky";
if ( $drupoh >= 191 AND $drupoh <= 196 ) echo "podnikate�ov";
?>
   </span> - nastavenie
  </td>
  <td>
   <ul class="toright legend-vykazy">
    <li class="toleft">
     <span class="darkgreen">&nbsp;</span>&nbsp;&nbsp;S�vaha
    </li>
    <li class="toleft" style="margin-left:20px;">
     <span class="purple">&nbsp;</span>&nbsp;&nbsp;V�kaz ziskov a str�t
    </li>
    <li class="toleft" style="margin-left:20px;">
     <span class="darkgray">&nbsp;</span>&nbsp;&nbsp;S�vaha + V�kaz ziskov a str�t
    </li>
   </ul>
  </td>
 </tr>
 </table>
</div>

<div class="wrap-content">
<?php
$clas1="darkgreen"; $clas2="darkgreen"; $clas3="purple"; $clas4="purple"; $clas5="darkgreen"; $clas6="darkgray";
if ( $drupoh == 91 OR $drupoh == 191 ) $clas1="active";
if ( $drupoh == 93 OR $drupoh == 193 ) $clas2="active";
if ( $drupoh == 92 OR $drupoh == 192 ) $clas3="active";
if ( $drupoh == 94 OR $drupoh == 194 ) $clas4="active";
if ( $drupoh == 95 OR $drupoh == 195 ) $clas5="active";
if ( $drupoh == 96 OR $drupoh == 196 ) $clas6="active";
$source="../ucto/vykazy_cis.php?copern=308";
?>

<div class="content-navbar toright">
<?php if ( $drupoh >= 91 AND $drupoh <= 96 ) { ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=91', '_self');"
  title="S�vaha - generovanie" class="<?php echo $clas1; ?> darkgreen">Generovanie</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=93', '_self');"
  title="S�vaha - predch�dzaj�ce ��tovn� obdobie" class="<?php echo $clas2; ?> darkgreen">Predch�dz. obdobie</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=92', '_self');"
  title="VZaS - generovanie" class="<?php echo $clas3; ?> purple">Generovanie</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=94', '_self');"
  title="VZaS - predch�dzaj�ce ��tovn� obdobie" class="<?php echo $clas4; ?> purple">Predch�dz. obdobie</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=95', '_self');"
  title="S�vaha - syntetick� generovanie Akt�v a Pas�v" class="<?php echo $clas5; ?> darkgreen">Generovanie A / P</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=96&uprav=1', '_self');"
  title="S�vaha a VZaS - zaokr�hlenie" class="<?php echo $clas6; ?> darkgray">Zaokr�hlenie</a>
<?php                                        } ?>
<?php if ( $drupoh >= 191 AND $drupoh <= 196 ) { ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=191', '_self');"
  title="S�vaha - generovanie" class="<?php echo $clas1; ?> darkgreen" >Generovanie</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=193', '_self');"
  title="S�vaha - predch�dzaj�ce ��tovn� obdobie" class="<?php echo $clas2; ?> darkgreen">Predch�dz. obdobie</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=192', '_self');"
  title="VZaS - generovanie" class="<?php echo $clas3; ?> purple">Generovanie</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=194', '_self');"
  title="VZaS - predch�dzaj�ce ��tovn� obdobie" class="<?php echo $clas4; ?> purple">Predch�dz. obdobie</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=195', '_self');"
  title="S�vaha - syntetick� generovanie Akt�v a Pas�v" class="<?php echo $clas5; ?> darkgreen">Generovanie A / P</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&drupoh=196&uprav=1', '_self');"
  title="S�vaha a VZaS - zaokr�hlenie" class="<?php echo $clas6; ?> darkgray">Zaokr�hlenie</a>
<?php                                          } ?>
</div>

<div class="content">
 <div class="content-heading">
  <h2>
<?php
if ( $drupoh == 91 OR $drupoh == 191 ) { echo "S�vaha - generovanie"; }
if ( $drupoh == 93 OR $drupoh == 193 ) { echo "S�vaha - predch�dzaj�ce ��tovn� obdobie"; }
if ( $drupoh == 92 OR $drupoh == 192 ) { echo "V�kaz ziskov a str�t - generovanie"; }
if ( $drupoh == 94 OR $drupoh == 194 ) { echo "V�kaz ziskov a str�t - predch�dzaj�ce ��tovn� obdobie"; }
if ( $drupoh == 95 OR $drupoh == 195 ) { echo "S�vaha - syntetick� generovanie Akt�v a Pas�v"; }
if ( $drupoh == 96 OR $drupoh == 196 ) { echo "S�vaha a V�kaz ziskov a str�t - zaokr�hlenie"; }
?>
  </h2>
 </div>
<?php
//uprava vykazu
if ( $drupoh >= 91 AND $drupoh != 96 AND $drupoh != 196 )
{

if ( $gener == 1 ) {
$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER BY cpl";
                   }
if ( $minul == 1 ) {
$sqltt = "SELECT cpl, dok AS uce, hod AS crs FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER BY cpl";
                   }
if ( $drupoh == 95 OR $drupoh == 195 ) {
$sqltt = "SELECT cpl, dok AS uce, ucm AS crs, ucd FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER BY cpl";
                                       }
$sql = mysql_query("$sqltt");
//echo $sqltt;

//celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

$varcolspan = 2; if ( $drupoh == 95 OR $drupoh == 195 ) $varcolspan = 1;
?>
<FORM name="formv1" method="post" action="vykazy_cis.php?copern=315&uprav=<?php echo $uprav;?>&drupoh=<?php echo $drupoh;?>">
 <table class="content-body toleft" style="">
 <thead>
 <tr>
  <th style="width:25%; border:0; height:1px;"></th>
  <th style="width:25%; border:0; height:1px;"></th>
  <th style="width:25%; border:0; height:1px;"></th>
  <th style="width:25%; border:0; height:1px;"></th>
 </tr>
 <tr>
<?php
if ( $gener == 1 )
{
?>
<?php if ( $drupoh != 95 AND $drupoh != 96 AND $drupoh != 195 AND $drupoh != 196 ) { ?>
  <th>��et</th><th colspan="2">��slo riadku</th>
<?php                                                                              } ?>
<?php if ( $drupoh == 95 OR $drupoh == 195 ) { ?>
  <th>��et</th><th>Akt�va</th><th>Pas�va</th>
<?php                                        } ?>
<?php
}
?>
<?php if ( $minul == 1 ) { ?>
  <th>Riadok</th><th colspan="2">Hodnota</th>
<?php                    } ?>
  <th>&nbsp;</th>
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
<?php                      } ?>

 <td style="text-align:center;">
  <a href="#" onclick="UpravPolozku(<?php echo $riadok->cpl;?>);" title="Upravi�" class="btn-edit"></a>
  <a href="#" onclick="ZmazPolozku(<?php echo $riadok->cpl;?>);" title="Vymaza�" class="btn-cancel"></a>
 </td>
</tr>
</tbody>
<?php
  }
$i = $i + 1;
   }
?>
<tfoot>
<tr>
 <th>
  <input type="text" name="h_uce" id="h_uce" class="field" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return UceEnter(event.which)"/>
 </th>

 <th colspan="<?php echo $varcolspan ?>">
  <input type="text" name="h_crs" id="h_crs" class="field" onkeyup="KontrolaCisla(this, Cele)" 
<?php if ( $drupoh != 95 AND $drupoh != 195 ) { ?>
onKeyDown="return CrsEnter(event.which)"/> 
<?php                      } ?>
<?php if ( $drupoh == 95 OR $drupoh == 195 ) { ?>
onKeyDown="return Crs95Enter(event.which)"/> 
<?php                      } ?>
 </th>


<?php if ( $drupoh == 95 OR $drupoh == 195 ) { ?>
 <th >
  <input type="text" name="h_ucd" id="h_ucd" class="field" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return UcdEnter(event.which)"/>
 </th>
<?php                      } ?>
 <th>

 </th>
</tr>



 <tr style="background-color: ;">
  <td colspan="3" style="">
   <span id="Cele" class="alert-error" style="display:none; ">Hodnota mus� by� cel� ��slo</span>
   <span id="Fx" class="alert-error" style="display:none; ">Mus�te vyplni� v�etky polo�ky vstupu</span>
  </td>
  <td colspan="1" style=" text-align:right;" onmouseover="return Povol_uloz();" >
   <input type="submit" id="uloz" name="uloz" value="Ulo�i�" onmouseover="return Povol_uloz();">
  </td>
 </tr>
 </tfoot>
 </table>
</FORM>






<?php
}
//koniec uprava vykazu
?>


<?php
//uprava vykazu drupoh 96,196
if ( $drupoh == 96 OR $drupoh == 196 )
{
?>
<FORM name="formv1" method="post" action="vykazy_cis.php?copern=315&uprav=0&drupoh=<?php echo $drupoh;?>">
<table class="content-body-fixed toleft" style="">
<thead>
<tr>
 <th style="width:65%;"></th>
 <th style="width:35%;">��slo riadku</th>
</tr>
<tr>
 <th>

 </th> <!-- dopyt, spolo�n� obr�zok -->
 <th>

</th>

 <th>
  <a href='vykazy_cis.php?drupoh=<?php echo $drupoh; ?>&copern=4055&page=1' style="display:none;"> <!-- dopyt, m� tu zmysel? -->
   <img src='../obr/import.png' width=20 height=15 border=0 title="Na��taj z minul�ho roka">
  </a>
  <a href='vykazy_cis.php?drupoh=<?php echo $drupoh; ?>&copern=155&page=1' style="display:none;">
   <img src='../obr/orig.png' width=20 height=15 border=0 title="Nastav �tandartn� ��seln�k">
  </a>
 </th>
</tr>
</thead>

<tbody style="">
<tr>
 <td> </td> 
 <td style="text-align:right;"> </td>


</tr>
</tbody>

<tbody>
<tr>
<?php
if ( $drupoh == 96 )
{
?>
 <th>S�vaha <img src='../obr/info.png' width=12 height=12 border=0 title="��slo riadku akt�v v S�vahe kam m� program z��tova� rozdiel HV po zaokr�hlen� S�vahy, napr. �. 15">
<?php
}
?>
<?php
if ( $drupoh == 196 )
{
?>
 <th>S�vaha <img src='../obr/info.png' width=12 height=12 border=0 title="��slo riadku akt�v v S�vahe kam m� program z��tova� rozdiel HV po zaokr�hlen� S�vahy, napr. �. 35"> <!-- dopyt, pozor in� ��slo riadku v title img -->
<?php
}
?>
 </th>
 <td>
  <input type="text" name="h_uce" id="h_uce" class="field" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return UceEnter(event.which)"/>
 </td>
</tr>
<tr>
<?php
if ( $drupoh == 96 )
{
?>
 <th>V�kaz ziskov a str�t
<img src='../obr/info.png' width=12 height=12 border=0 title="��slo n�kladov�ho riadku vo V�kaze ziskov kam m� program z��tova� rozdiel HV po zaokr�hlen� S�vahy a VZaS, napr. �. 17">
<?php
}
?>
<?php
if ( $drupoh == 196 )
{
?>
 <th>V�kaz ziskov a str�t
<img src='../obr/info.png' width=12 height=12 border=0 title="��slo n�kladov�ho riadku vo V�kaze ziskov kam m� program z��tova� rozdiel HV po zaokr�hlen� S�vahy a VZaS, napr. �. 26">
<?php
}
?>
</th>
 <td>
  <input type="text" name="h_crs" id="h_crs" class="field" onkeyup="KontrolaCisla(this, Cele)" onKeyDown="return Crs96Enter(event.which)"/>
 </td>
</tr>
</tbody>
<tfoot>

<tr>
 <td></td>
 <td style="height:12px; padding:4px 0;" onmouseover="return Povol_uloz();" >
  <input type="submit" id="uloz" name="uloz" value="Ulo�i�" >
 </td>
 </tr>
 </tfoot>
 </table>


</FORM>

<span id="Cele" style="display:none; width:100%; font-weight:bold; background-color:red; color:black;">
 Hodnota mus� by� cel� ��slo</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus� by� desatinn� ��slo</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Mus�te vyplni� v�etky polo�ky vstupu</span>

<?php
}
//koniec uprava vykazu drupoh 96,196
?>




<?php
$vartitle = "��seln�k";
if ( $drupoh == 93 OR $drupoh == 193 OR $drupoh == 94 OR $drupoh == 194 ) $vartitle = "hodnoty";
?>
<?php if ( $drupoh != 93 AND $drupoh != 193 AND $drupoh != 94 AND $drupoh != 194 ) { ?> <!-- dopyt, o�etri�, aby neukazoval v roku 2013 a star�ie -->
 <a href='vykazy_cis.php?drupoh=<?php echo $drupoh; ?>&copern=155&page=1'
  title="Na��ta� �tandardn� ��seln�k" class="btn-down-x26 toright">�tandardn�</a> <!-- dopyt, preveri�, �i nie�o rob� -->
<?php                                                                              } ?>
 <a href='vykazy_cis.php?drupoh=<?php echo $drupoh; ?>&copern=4055&page=1'
  title="Na��ta� <?php echo $vartitle; ?> z predch�dzaj�ceho ��tovn�ho obdobia"
  class="btn-down-x26 toright">Predch. obdobie</a>




</div> <!-- koniec .content -->


</div> <!-- koniec .wrap-content -->


<?php
//celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
