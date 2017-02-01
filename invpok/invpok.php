<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$zmtz=1*$_REQUEST['zmtz'];


$sys = 'SKL';
$urov = 2000;
$clsm = 960;
$uziv = include("../uziv.php");
if( !$uziv ) exit;


// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$html = 1*$_REQUEST['html'];
$xyid = 1*$_REQUEST['xyid'];
$xyico = 1*$_REQUEST['xyico'];

$hladaj_uce = 1*strip_tags($_REQUEST['hladaj_uce']);
if( $hladaj_uce == 0 ) $hladaj_uce=31100;


  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


if( $zmtz == 1 )
  {
$cit_fir = include("../cis/citaj_fir.php");


$sql = "SELECT invrozdiel FROM F$kli_vxcf"."_invpok";
$vysledok = mysql_query("$sql");
if (!$vysledok)
 {

$vsql = 'DROP TABLE F'.$kli_vxcf.'_invpok';
$vytvor = mysql_query("$vsql");


$sqlt = <<<statistika_p1304
(
   xdok         INT default 0,
   invdat       DATE not null,
   invucet      VARCHAR(6) not null,
   invmulz      VARCHAR(50) not null,
   invdatzac    DATE not null,
   invdatskc    DATE not null,
   invohz       VARCHAR(50) not null,
   invozv       VARCHAR(50) not null,
   invstav      DECIMAL(10,2) default 0,
   ks500e       DECIMAL(10,0) default 0,
   suma500e     DECIMAL(10,0) default 0,
   ks200e       DECIMAL(10,0) default 0,
   suma200e     DECIMAL(10,0) default 0,
   ks100e       DECIMAL(10,0) default 0,
   suma100e     DECIMAL(10,0) default 0,
   ks50e        DECIMAL(10,0) default 0,
   suma50e      DECIMAL(10,0) default 0,
   ks20e        DECIMAL(10,0) default 0,
   suma20e      DECIMAL(10,0) default 0,
   ks10e        DECIMAL(10,0) default 0,
   suma10e      DECIMAL(10,0) default 0,
   ks5e         DECIMAL(10,0) default 0,
   suma5e       DECIMAL(10,0) default 0,
   ks2e         DECIMAL(10,0) default 0,
   suma2e       DECIMAL(10,0) default 0,
   ks1e         DECIMAL(10,0) default 0,
   suma1e       DECIMAL(10,0) default 0,
   ks50ec       DECIMAL(10,0) default 0,
   suma50ec     DECIMAL(10,2) default 0,
   ks20ec       DECIMAL(10,0) default 0,
   suma20ec     DECIMAL(10,2) default 0,
   ks10ec       DECIMAL(10,0) default 0,
   suma10ec     DECIMAL(10,2) default 0,
   ks5ec        DECIMAL(10,0) default 0,
   suma5ec      DECIMAL(10,2) default 0,
   ks2ec        DECIMAL(10,0) default 0,
   suma2ec      DECIMAL(10,2) default 0,
   ks1ec        DECIMAL(10,0) default 0,
   suma1ec      DECIMAL(10,2) default 0,
   sumaspolu    DECIMAL(10,2) default 0,
   invrozdiel   DECIMAL(10,2) default 0,
   invpozn      TEXT not null,
   xid          INT default 0,
   xdatm        TIMESTAMP(14)
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_invpok'.$sqlt;
$vytvor = mysql_query("$vsql");
 }

  }
//koniec ak zmtz=1


//zisti ci som v prirucnom sklade
$somvprirskl=0;


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

if( $copern == 7702 )
{

$novaobj=1;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_invpok WHERE xdok > 0 ORDER BY xdok DESC LIMIT 1"; 
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $novaobj=$riaddok->xdok+1;
 }

$kli_uzidxx=$kli_uzid;

//xdok  xfak  xsx1  xsx2  xsx3  xdx1  xdx2  xdx3  xice  xodbm  xcpo  xcpl  xcis  xnat  xdph  xcep  xced  xmno  xhdb  xhdd  xid  xdatm  

$dsqlt = "INSERT INTO F$kli_vxcf"."_invpok ( xdok, invdat, xid, xdatm ) ".
" VALUES ( $novaobj, now(),  $kli_uzidxx, now() ) ";
if( $novaobj > 0 ) { $dsql = mysql_query("$dsqlt"); }
//echo $dsqlt;

?>
<script type="text/javascript">
  var okno = window.open("invpok_u.php?copern=1&drupoh=1&page=1&cislo_dok=<?php echo $novaobj; ?>&ffd=0&tlacobj=1&zmtz=1","_self");
</script>
<?php
exit;
}
//koniec nova obj

//zmazat inv
if( $copern == 6001 )
{
$plux = 1*$_REQUEST['plux'];
?>
<script type="text/javascript">
if( !confirm ("Chcete zmazaù invent˙ru Ë.<?php echo $plux; ?> ?") )
         {   }
else
  var okno = window.open("invpok.php?copern=6002&drupoh=1&page=1&plux=<?php echo $plux; ?>&ffd=0&zmtz=<?php echo $zmtz; ?>","_self");
</script>
<?php
$copern=1;
$html=1;
}
if( $copern == 6002 )
{
$plux = 1*$_REQUEST['plux'];

$dsqlt = "DELETE FROM F$kli_vxcf"."_invpok  WHERE xdok = $plux ";
$dsql = mysql_query("$dsqlt");

$html=1;
$copern=1;
}
//koniec zmazat obj

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>PokladniËnÈ invent˙ry</title>
<style type="text/css">
img { border: none; }
a.btn-prepni {
  font-size:14px;
  text-decoration:none;
  color:white;
  padding:3px 15px;  
  background-color: #ABD159;  
  border:1px solid #86A83D;
  font-family:Helvetica, Geneva, Verdana, sans-serif;
  position:relative;
  font-weight:bold;
}  
</style>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;


function NovaINV()
                {
window.open('invpok.php?copern=7702&drupoh=1&page=1&plux=0&ffd=0&zmtz=<?php echo $zmtz; ?>', '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }
    
function ZmazINV(plu)
                {
var plux = plu;
window.open('invpok.php?copern=6001&drupoh=1&page=1&plux='+ plux + '&ffd=0&zmtz=<?php echo $zmtz; ?>', '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacINV(plu)
                {
var plux = plu;
window.open('invpok_t.php?copern=1&drupoh=1&page=1&cislo_dok=' + plux + '&ffd=0&tlacobj=1&zmtz=<?php echo $zmtz; ?>', '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravINV(plu)
                {
var plux = plu;
window.open('invpok_u.php?copern=1&drupoh=1&page=1&cislo_dok=' + plux + '&ffd=0&tlacobj=1&zmtz=<?php echo $zmtz; ?>', '_self', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function SpatZoznam()
                {
window.open('../dodobj/invpok_t.php?copern=1&drupoh=1&page=1&zmtz=1&html=1', '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function textINV( objx )
    {
var h_obj = objx;
window.open('../invpok/invpok_pozn.php?h_obj=' + h_obj + '&copern=1&drupoh=1&page=1&zmtz=1', '_blank',  'width=900, height=800, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

    }
</script>
</HEAD>
<BODY class="white">
<table class="h2" width="100%" >
<tr>
<td align="left">EuroSecom - PokladniËnÈ invent˙ry</td>
<td align="right"><span class="login"><?php echo "$kli_vxcf-$kli_nxcf | $kli_uzmeno $kli_uzprie/$kli_uzid ";?></span></td>
</tr>
</table>

<?php
if ( $html == 1 )  
{
?>
<table width="100%" style="margin:5px 0;" >
<tr>
<td width="20%" ><a href="#" onclick="NovaINV();" class="btn-prepni" ><strong style="font-size:16px;" >+</strong> invent˙ra</a></td>
<td width="50%"></td>
<td width="30%"></td> <!-- cez ikony -->
</tr>
</table>
<?php
}

if ( $drupoh == 1 )
  {
$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_invpok".
" WHERE ( xdok > 0 ) ORDER BY xdok DESC";
  }


//echo $sqltt;
//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);


$strana=0;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i) OR $i == 0 )
{
$riadok=mysql_fetch_object($tov);



//hlavicka strany
if ( $j == 0 )
     {
$strana=$strana+1;

if ( $copern == 1 AND $drupoh == 1 AND $html == 1 )  {
?>
<table class="fmenu" width="100%">
<tr>
<th width="10%" class="bmenu">PokladÚa</th>
<th width="10%" class="bmenu">»Ìslo</th>
<th width="30%" class="bmenu">D·tum</th>
<th width="30%" class="bmenu">Stav</th>
<th width="20%" class="bmenu"></th>
</tr>
<?php
                                                     }
     }
//koniec hlavicky j=0


if( $drupoh == 1 )
{
$skinvdat=SkDatum($riadok->invdat);


if( $html == 1 AND $riadok->xdok > 0 )
 {
?>
<tr>
<td class="hvstup" align="center"><?php echo $riadok->invucet; ?></td>
<td class="hvstup" align="right"><?php echo $riadok->xdok; ?>&nbsp;</td>
<td class="hvstup" align="center"><?php echo $skinvdat; ?></td>
<td class="hvstup" align="center" ><?php echo $riadok->invstav; ?> - <?php echo $riadok->sumaspolu; ?></td>
<td class="hvstup" align="center">
<a href="#" onclick="UpravINV(<?php echo $riadok->xdok; ?>);">
<img src='../obr/uprav.png' width=20 height=20 border=0 title='⁄prava objedn·vky' ></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#" onclick="TlacINV(<?php echo $riadok->xdok; ?>);"><img src='../obr/tlac.png' width=20 height=15 title='TlaËiù objedn·vku' ></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#" onclick="ZmazINV(<?php echo $riadok->xdok; ?>);"><img src='../obr/zmaz.png' width=20 height=15 title='Zmazaù objedn·vku' ></a>
</td>
</tr>
<?php
 }

}


}
$i = $i + 1;
$j = $j + 1;

  }

?>
</table>
<?php 

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
