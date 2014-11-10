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

// cislo operacie
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

if( $drupoh == 95 )
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
if ( !confirm ("Chcete naËÌtaù generovanie z minulÈho roka ?") ) //dopyt, Ëo je to za hl·öku?
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
if ( $kli_vrok > 2010 )
{
if ( File_Exists("../pswd/oddelena2010db2011.php") ) { $databaza=$mysqldb2010."."; }
}
if ( $kli_vrok > 2011 )
{
if ( File_Exists("../pswd/oddelena2011db2012.php") ) { $databaza=$mysqldb2011."."; }
}
if ( $kli_vrok > 2012 )
{
if ( File_Exists("../pswd/oddelena2012db2013.php") ) { $databaza=$mysqldb2012."."; }
}
if ( $kli_vrok > 2013 )
{
if ( File_Exists("../pswd/oddelena2013db2014.php") ) { $databaza=$mysqldb2013."."; }
}
if ( $kli_vrok > 2014 )
{
if ( File_Exists("../pswd/oddelena2014db2015.php") ) { $databaza=$mysqldb2014."."; }
}


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
if( !confirm ("Chcete naËÌtaù ötandartn˝ ËÌselnÌk generovania ?") )
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
$h_uce = strip_tags($_REQUEST['h_uce']);
$h_crs = strip_tags($_REQUEST['h_crs']);
$h_ucd = strip_tags($_REQUEST['h_ucd']);

if( $gener == 1 ) {
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( uce, crs ) VALUES ( '$h_uce', '$h_crs'  ); ";
if( $drupoh == 95 )
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
<script type="text/javascript"> alert( "POLOéKA NEBOLA SPR¡VNE ULOéEN¡" ) </script>
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
if( $drupoh == 95 )
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
<script type="text/javascript"> alert( "POLOéKA NEBOLA SPR¡VNE ULOéEN¡" ) </script>
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
$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl = $cislo_cpl  ".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

if( $gener == 1 ) {
$h_uce = $riadok->uce;
$h_crs = $riadok->crs;
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( uce, crs ) VALUES ( '$h_uce', '$h_crs'  ); ";
if( $drupoh == 95 )
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
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$uctsys WHERE cpl='$cislo_cpl' "); 
       }
//koniec uprava nacitanie
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css" type="text/css">
 <link rel="stylesheet" href="../css/tlaciva.css" type="text/css">
<title>EuroSecom - M⁄J z·vierka nastavenie</title>
<style type="text/css">
table.content-body {
  width: 500px;
  margin-left: 80px;
/* background-color:#ececec; */
}
table.content-body thead th {
  font-size: 11px;
  text-align: left;
  height: 14px;
}
table.content-body tbody td {
  background-color: #ececec;
  line-height: 18px;
  border-bottom: 2px solid #fff;
  border-right: 2px solid #fff;
  font-size: 12px;
  
}
table.content-body tfoot td {
  height: 20px;

}

a.btn-edit, a.btn-cancel {
  display: inline-block;
  width: 16px;
  height: 16px;
  vertical-align: -4px;
  opacity: 0.7;
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
  opacity: 1;
}

</style>

<script type="text/javascript">
//sirka a vyska okna
var vyskawin = screen.height-175;

  function VyberVstup()
  {
  }

  function ObnovUI()
  {
<?php if ( $copern == 308 AND $uprav >= 0 AND $drupoh >= 91 ) { ?>
   document.formv1.h_uce.value = '<?php echo "$h_uce";?>';
   document.formv1.h_crs.value = '<?php echo "$h_crs";?>';
<?php if ( $drupoh == 95 ) { ?>
   document.formv1.h_ucd.value = '<?php echo "$h_ucd";?>';
<?php                      } ?>
<?php                                                         } ?>
  }

  function Povol_uloz()
  {
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
   <td class="header">⁄Ëtovn· z·vierka <span class="subheader">mikro ˙Ëtovnej jednotky</span> - nastavenie</td>
   <td></td>
  </tr>
 </table>
</div>

<div id="content" >




<?php
$clas1="noactive"; $clas2="noactive"; if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active"; if ( $strana == 3 ) $clas3="active";

?>
<div class="wrap-content-navbar" style="float:right; width:100%; background-color:lightblue; line-height:20px;">
 <h2 class="" style="font-family:arial; font-size:14px; float:left; font-weight: bold; ">
<?php
if ( $drupoh == 91 ) { echo "S˙vaha - Generovanie"; }
if ( $drupoh == 93 ) { echo "S˙vaha - Predch·dzaj˙ce ˙ËtovnÈ obdobie"; }
if ( $drupoh == 92 ) { echo "VZaS - Generovanie"; }
if ( $drupoh == 94 ) { echo "VZaS - Predch·dzaj˙ce ˙ËtovnÈ obdobie"; }
if ( $drupoh == 95 ) { echo "S˙vaha - generovanie v˝kazu AktÌva / PasÌva"; }
if ( $drupoh == 96 ) { echo "S˙vaha a VZaS - Nastavenie zaokr˙hlenia"; }
?>
 </h2>




</div>


<div class="" style="background-color:white;">













<?php
////////////////////////////////////////////////////////////////uprava vykazu
if ( $drupoh >= 91 )
{

if ( $gener == 1 ) {
$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER BY cpl";
                   }
if ( $minul == 1 ) {
$sqltt = "SELECT cpl, dok AS uce, hod AS crs FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER BY cpl";
                   }
if ( $drupoh == 95 ) {
$sqltt = "SELECT cpl, dok AS uce, ucm AS crs, ucd FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER BY cpl";
                     }
$sql = mysql_query("$sqltt");
//echo $sqltt;

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
?>
<table class="content-body" style="">
<FORM name="formv1" method="post" action="vykazy_cis.php?copern=315&uprav=<?php echo $uprav;?>&drupoh=<?php echo $drupoh;?>">

<thead>
<tr>
 <th style="width:25%;"></th>
 <th style="width:25%;"></th>
 <th style="width:25%;"></th>
 <th style="width:25%;"></th>
</tr>
<tr>
<?php
if ( $gener == 1 )
{
?>
<?php if ( $drupoh != 95 AND $drupoh != 96 ) { ?>
 <th>⁄Ëet</th>
 <th colspan="2">Riadok</th>
<?php                                        } ?>
<?php if ( $drupoh == 95 ) { ?>
 <th>⁄Ëet</th>
 <th>AktÌva</th>
 <th>PasÌva</th>
<?php                      } ?>

<?php if ( $drupoh == 96 ) { ?>
 <th>
 ËrSUV <img src='../obr/info.png' width=12 height=12 border=0 title="»Ìslo riadku aktÌv v S˙vahe kam m· program z˙Ëtovaù rozdiel HV po zaokr˙hlenÌ S˙vahy, napr. Ë. 15">
 </th> <!-- dopyt, spoloËn˝ obr·zok -->
 <th>
ËrVZS <img src='../obr/info.png' width=12 height=12 border=0 title="»Ìslo n·kladovÈho riadku vo V˝kaze ziskov kam m· program z˙Ëtovaù rozdiel HV po zaokr˙hlenÌ S˙vahy a VZaS, napr. Ë. 17">
</th>

<?php                     } ?>
<?php
}
?>

<?php if ( $minul == 1 ) { ?>
 <th>Riadok</th>
 <th colspan="2">Hodnota</th>
<?php                    } ?>
 <th>
  <a href='vykazy_cis.php?drupoh=<?php echo $drupoh; ?>&copern=4055&page=1' style="display:none;"> <!-- dopyt, doprava na liötu spraviù tlaËidlo "naËÌtaù" -->
   <img src='../obr/import.png' width=20 height=15 border=0 title="NaËÌtaj z minulÈho roka">
  </a>
  <a href='vykazy_cis.php?drupoh=<?php echo $drupoh; ?>&copern=155&page=1' style="display:none;">
   <img src='../obr/orig.png' width=20 height=15 border=0 title="Nastav ötandartn˝ ËÌselnÌk">
  </a>
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
 <td><?php echo $riadok->uce;?></td>
 <td style="text-align:right;"><?php echo $riadok->crs;?></td>

<?php if ( $drupoh == 95 ) { ?>
 <td style="text-align:right;"><?php echo $riadok->ucd;?></td>
<?php                      } ?>

 <td style="text-align:center;">
  <a href="#" onclick="UpravPolozku(<?php echo $riadok->cpl;?>);" title="Upraviù" class="btn-edit"></a>
  <a href="#" onclick="ZmazPolozku(<?php echo $riadok->cpl;?>);" title="Vymazaù" class="btn-cancel" ></a>
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
 <td>
  <input type="text" name="h_uce" id="h_uce" size="7" onclick=" " onKeyDown=" "  onkeyup=" " />
 </td>
 <td>
  <input type="text" name="h_crs" id="h_crs" size="7" onclick=" " onKeyDown=" "  onkeyup=" "/>
 </td>
<?php if ( $drupoh == 95 ) { ?>
 <td>
  <input type="text" name="h_ucd" id="h_ucd" size="7" onclick=" " onKeyDown=" "  onkeyup=" "/>
 </td>
<?php                      } ?>
</tr>



<tr>
 <td></td>
 <td colspan="3" style="">
  <input type="submit" id="uloz" name="uloz" value="Uloûiù" >
 </td>
</tr>
</tfoot>
</table>

<!-- dopyt, sem pÙjde drupoh 96 -->


</FORM>

<?php
}
////////////////////////////////////////////////////////////////koniec uprava vykazu
?>

 </div> <!-- koniec .content-body -->


</div> <!-- koniec  #content -->


<?php
//celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
