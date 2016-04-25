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
$citwebs = include("../funkcie/citaj_webs.php");
$cit_fir = include("../cis/citaj_fir.php");


$sql = "SELECT xcpo FROM F$kli_vxcf"."_dodavobj";
$vysledok = mysql_query("$sql");
if (!$vysledok)
 {

$vsql = 'DROP TABLE F'.$kli_vxcf.'_dodavobj';
$vytvor = mysql_query("$vsql");


$sqlt = <<<statistika_p1304
(
   xdok         int DEFAULT 0,
   xfak         decimal(10,0) DEFAULT 0,
   xsx1         decimal(10,0) DEFAULT 0,
   xsx2         decimal(10,0) DEFAULT 0,
   xsx3         decimal(10,0) DEFAULT 0,
   xdx1         DATE not null,
   xdx2         DATE not null,
   xdx3         DATE not null,
   xice         decimal(10,0) DEFAULT 0,
   xcpo         int PRIMARY KEY not null auto_increment,
   xcpl         decimal(10,0) DEFAULT 0,
   xcis         varchar(15) NOT NULL,
   xnat         VARCHAR(50) NOT NULL,
   xdph         DECIMAL(2,0) DEFAULT 20,
   xcep         decimal(10,2) DEFAULT 0,
   xced         decimal(10,2) DEFAULT 0,
   xmno         decimal(10,3) DEFAULT 0,
   xhdb         decimal(10,2) DEFAULT 0,
   xhdd         decimal(10,2) DEFAULT 0,
   xid          INT DEFAULT 0,
   xdatm        TIMESTAMP(14)
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_dodavobj'.$sqlt;
$vytvor = mysql_query("$vsql");

 }

$sql = "SELECT xodbm FROM F$kli_vxcf"."_dodavobj";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_dodavobj ADD xodbm decimal(10,0) DEFAULT 0 AFTER xice";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT xstav FROM F$vyb_xcf"."_dodavobj";
$vysledok = mysql_query("$sql");
if (!$vysledok)
   {
$sql = "ALTER TABLE F$kli_vxcf"."_dodavobj ADD xdatv DATE NOT NULL AFTER xdok";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dodavobj ADD xdatd DATE NOT NULL AFTER xdok";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dodavobj ADD xplat VARCHAR(60) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dodavobj ADD xfir VARCHAR(60) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dodavobj ADD xodm VARCHAR(60) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dodavobj ADD xdop VARCHAR(60) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dodavobj ADD xstav VARCHAR(60) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dodavobj MODIFY xnat VARCHAR(100) NOT NULL";
$vysledek = mysql_query("$sql");
   }

  }
//koniec ak zmtz=1


//zisti ci som v prirucnom sklade
$somvprirskl=0;


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//nova obj
if( $copern == 7701 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete vytvoriù nov˙ objedn·vku ?") )
         {   }
else
  var okno = window.open("dodobj.php?copern=7702&drupoh=1&page=1&plux=0&ffd=0&zmtz=<?php echo $zmtz; ?>","_self");
</script>
<?php
$copern=1;
$html=1;
}
if( $copern == 7702 )
{

$novaobj=1;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_dodavobj WHERE xdok > 0 ORDER BY xdok DESC LIMIT 1"; 
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $novaobj=$riaddok->xdok+1;
 }

$kli_uzidxx=$kli_uzid;

//xdok  xfak  xsx1  xsx2  xsx3  xdx1  xdx2  xdx3  xice  xodbm  xcpo  xcpl  xcis  xnat  xdph  xcep  xced  xmno  xhdb  xhdd  xid  xdatm  

$dsqlt = "INSERT INTO F$kli_vxcf"."_dodavobj ( xdok, xdatv, xfak, xice, xodbm, xsx2, xsx3, xcis, xnat, xid, xdatm ) ".
" VALUES ( $novaobj, now(), 0, '$fir_fico', 0, 9, 0, 0, 'hlavicka', $kli_uzidxx, now() ) ";
if( $novaobj > 0 ) { $dsql = mysql_query("$dsqlt"); }
//echo $dsqlt;

?>
<script type="text/javascript">
  var okno = window.open("dodobj_u.php?copern=1&drupoh=1&page=1&cislo_dok=<?php echo $novaobj; ?>&ffd=0&tlacobj=1&zmtz=1","_self");
</script>
<?php
exit;
}
//koniec nova obj

//zmazat obj
if( $copern == 6001 )
{
$plux = 1*$_REQUEST['plux'];
?>
<script type="text/javascript">
if( !confirm ("Chcete zmazaù objedn·vku Ë.<?php echo $plux; ?> ?") )
         {   }
else
  var okno = window.open("dodobj.php?copern=6002&drupoh=1&page=1&plux=<?php echo $plux; ?>&ffd=0&zmtz=<?php echo $zmtz; ?>","_self");
</script>
<?php
$copern=1;
$html=1;
}
if( $copern == 6002 )
{
$plux = 1*$_REQUEST['plux'];

$dsqlt = "DELETE FROM F$kli_vxcf"."_dodavobj  WHERE xdok = $plux ";
$dsql = mysql_query("$dsqlt");

$html=1;
$copern=1;
}
//koniec zmazat obj


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Dod·vateæskÈ objedn·vky</title>
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
  
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
  </style>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

<?php  if( $zmtz == 1 ) { ?>

function NovaOBJ()
                {

window.open('dodobj.php?copern=7701&drupoh=1&page=1&plux=0&ffd=0&zmtz=<?php echo $zmtz; ?>', '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }
    
function ZmazOBJ(plu)
                {

var plux = plu;

window.open('dodobj.php?copern=6001&drupoh=1&page=1&plux='+ plux + '&ffd=0&zmtz=<?php echo $zmtz; ?>', '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }



<?php                    } ?>


function TlacOBJ(plu)
                {
var plux = plu;

window.open('dodobj_t.php?copern=1&drupoh=1&page=1&cislo_dok=' + plux + '&ffd=0&tlacobj=1&zmtz=<?php echo $zmtz; ?>', '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function StavOBJ(plu)
                {
var plux = plu;

window.open('dodobj_u.php?copern=2&drupoh=1&page=1&cislo_dok=' + plux + '&ffd=0&tlacobj=1&zmtz=<?php echo $zmtz; ?>', '_self', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function StavOBJALL(plu, ico)
                {
var plux = plu;
var icox = ico;

window.open('dodobj_u.php?copern=1&drupoh=1&page=1&cislo_dok=' + plux + '&icox=' + icox + '&ffd=0&tlacobj=1&zmtz=<?php echo $zmtz; ?>&vseobj=1', '_self', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function StavOBJico(plu, ico)
                {
var plux = plu;
var icox = ico;

window.open('dodobj_u.php?copern=1&drupoh=1&page=1&cislo_dok=' + plux + '&icox=' + icox + '&ffd=0&tlacobj=1&zmtz=<?php echo $zmtz; ?>&vseobj=1&vsezaico=1', '_self', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function nakupnykosik()
    {
 
window.open('kosik_tlac.php?copern=1&drupoh=1&page=1&html=1', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
   
    }


function MojeFaktury(icox)
                {
var h_ico = icox;

window.open('../ucto/saldo_pdf.php?h_uce=31100&h_nai=&h_ico=' + h_ico + '&h_obd=0&copern=10&drupoh=1&page=1&h_su=0&h_al=1&analyzy=0&zkosika=1', '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function AllObjID(xid)
                {
var xyid = xid;

window.open('../dodobj/dodobj_t.php?copern=1&drupoh=1&xyid=' + xyid + '&page=1&zmtz=1&html=1', '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function AllObjICO(xico)
                {
var xyico = xico;

window.open('../dodobj/dodobj_t.php?copern=1&drupoh=1&xyico=' + xyico + '&page=1&zmtz=1&html=1', '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function SpatZoznam()
                {

window.open('../dodobj/dodobj_t.php?copern=1&drupoh=1&page=1&zmtz=1&html=1', '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

    function textObj( objx )
    {

var h_obj = objx;

window.open('../dodobj/dodobj_pozn.php?h_obj=' + h_obj + '&copern=1&drupoh=1&page=1&zmtz=1', '_blank',  'width=900, height=800, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

    }
</script>
</HEAD>
<BODY class="white">
<table class="h2" width="100%" >
<tr>
<td align="left">EuroSecom - Dod·vateæskÈ objedn·vky</td>
<td align="right"><span class="login"><?php echo "$kli_vxcf-$kli_nxcf | $kli_uzmeno $kli_uzprie/$kli_uzid ";?></span></td>
</tr>
</table>

<?php

$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$sqlt = <<<mzdprc
(
   pox          decimal(10,0) DEFAULT 0,
   xdok         decimal(10,0) DEFAULT 0,
   xfak         decimal(10,0) DEFAULT 0,
   xdatd         DATE not null,
   xdatv         DATE not null,
   xsx1         decimal(10,0) DEFAULT 0,
   xsx2         decimal(10,0) DEFAULT 0,
   xsx3         decimal(10,0) DEFAULT 0,
   xice         decimal(10,0) DEFAULT 0,
   xcpo         int PRIMARY KEY not null auto_increment,
   xcpl         decimal(10,0) DEFAULT 0,
   xcis         varchar(15) NOT NULL,
   xnat         VARCHAR(50) NOT NULL,
   xdph         DECIMAL(2,0) DEFAULT 20,
   xcep         decimal(10,4) DEFAULT 0,
   xced         decimal(10,2) DEFAULT 0,
   xmno         decimal(10,3) DEFAULT 0,
   xhdb         decimal(10,2) DEFAULT 0,
   xhdd         decimal(10,2) DEFAULT 0,
   xid          INT DEFAULT 0,
   xdatm        TIMESTAMP(14),
   xstav        VARCHAR(60) NOT NULL
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


//zober objednavky vsetky
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 0,xdok,xfak,xdatd,xdatv,0,xsx2,xsx3,xice,0,xcpl,xcis,xnat,xdph,xcep,xced,xmno,xhdb,xhdd,xid,xdatm,xstav FROM F$kli_vxcf"."_dodavobj WHERE xdok > 0 ";
$dsql = mysql_query("$dsqlt");


//group doklad
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,xdok,xfak,xdatd,xdatv,xsx1,xsx2,xsx3,xice,0,xcpl,xcis,xnat,xdph,xcep,xced,SUM(xmno),SUM(xhdb),SUM(xhdd),xid,xdatm,xstav  FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE xdok > 0 GROUP BY xdok".
"";
$dsql = mysql_query("$dsqlt");

//group vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 10,999999999,xfak,xdatd,xdatv,xsx1,xsx2,xsx3,xice,0,xcpl,xcis,xnat,xdph,xcep,xced,SUM(xmno),SUM(xhdb),SUM(xhdd),xid,xdatm,xstav  FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE pox = 1 GROUP BY pox".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." WHERE pox = 0 ";
$dsql = mysql_query("$dsqlt");


if ( $html == 1 )  
{
?>
<table width="100%" style="margin:5px 0;" >
<tr>
<td width="20%" ><a href="#" onclick="NovaOBJ();" class="btn-prepni" ><strong style="font-size:16px;" >+</strong> objedn·vka</a></td>
<td width="50%" align="right"><span style="display:none;">Zobraziù: vöetky</span></td>
<td align="right" width="30%" style="font-size:14px;" >
<img onclick="window.open('../dodobj/zozobj.php?copern=1&drupoh=1','_blank')" src='../obr/tlac.png' width=20 height=15 title='TlaËiù objedn·vky' >

</td>
</tr>
</table>
<?php
}

if ( $drupoh == 1 )
  {
$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_mzdprcx".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_mzdprcx".$kli_uzid.".xcis=F$kli_vxcf"."_sklcis.cis".
" WHERE xdok > 0 ORDER BY xdok ";
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

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);



//hlavicka strany
if ( $j == 0 )
     {


$strana=$strana+1;

if ( $copern == 1 AND $drupoh == 1 AND $html == 1 )  {
?>
<table class="fmenu" width="100%" >
<tr>
<th width="7%" class="bmenu">»Ìslo</th>
<th width="40%" align="left" class="bmenu">Dod·vateæ</th>
<th width="16%" class="bmenu" >D. vystavenia - dodania</th>
<th width="10%" class="bmenu">Stav</th>
<th width="10%" class="bmenu">Suma</th>
<th width="17%" class="bmenu"></th>
</tr>
<?php
                                                     }

     }
//koniec hlavicky j=0


if( $riadok->pox == 1 AND $drupoh == 1 )
{
$skdatv=SkDatum($riadok->xdatv);
$skdatd=SkDatum($riadok->xdatd);

if( $html == 1 )
 {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $riadok->xice ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$ico = $fir_riadok->ico; $dic = $fir_riadok->dic; $icd = $fir_riadok->icd;
$nai = $fir_riadok->nai; $na2 = $fir_riadok->na2; $uli = $fir_riadok->uli;
$psc = $fir_riadok->psc; $mes = $fir_riadok->mes; $tel = $fir_riadok->tel; $fax = $fir_riadok->fax; $em1 = $fir_riadok->em1;
$xstav = $fir_riadok->xstav; 

$icox=1*$ico;
?>
<tr>
<td class="hvstup">&nbsp;&nbsp;<?php echo $riadok->xdok; ?></td>
<td class="hvstup" align="left">
&nbsp;<?php echo $ico; ?>&nbsp; - <?php echo $nai; ?> <?php echo $na2; ?>
<span style="display:none;">
<a href="#" onclick="AllObjID(<?php echo $riadok->xid; ?>);" title='Vöetky objedn·vky objedn·vateæa' ><?php echo $ekto; ?></a>
<?php if(( $zmtz == 1 AND $zinejfir == 0 ) OR ( $somvprirskl == 1 )) { ?>
<a href="#" onclick="StavOBJico(0, <?php echo $icox; ?>);"><img src='../obr/naradie.png' width=15 height=12 title='Stav objedn·vok za firmu' ></a>
<?php                                     } ?>
<a href="#" onclick="AllObjICO(<?php echo $icox; ?>);" title='Vöetky objedn·vky za firmu'><?php echo $nai; ?> <?php echo $na2; ?></a>
</span>
<img src='../obr/orig.png' width=20 height=15 onclick="textObj('<?php echo $riadok->xdok;?>')" title="Pozn·mka k objedn·vke" >
</td>
<td class="hvstup" align="center"><?php echo $skdatv; ?> - <?php echo $skdatd; ?></td>
<td class="hvstup" align="center" ><?php echo $riadok->xstav; ?></td>
<td class="hvstup" align="right" ><?php echo $riadok->xhdd; ?>&nbsp;</td>
<td class="hvstup" align="center"> 
<?php
$cislodod=1*$riadok->xsx1;
if( $cislodod > 0 ) { echo "Dod.list".$cislodod; }
?>
<?php if(( $zmtz == 1 AND $zinejfir == 0 ) OR ( $somvprirskl == 1 )) { ?>
<a href="#" onclick="StavOBJ(<?php echo $riadok->xdok; ?>);">
<img src='../obr/uprav.png' width=20 height=20 border=0 title='⁄prava objedn·vky' ></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php                                     } ?>
<?php 
$cislofak=1*$riadok->xfak;
if( $cislofak > 0 )
  {
echo " F".$cislofak;
  }
?>

<?php
//poznamka
//$poznx="";
//$sqlfir = "SELECT * FROM F$kli_vxcf"."_dodavobjtext WHERE invt = $riadok->xdok ";
//$fir_vysledok = mysql_query($sqlfir);
//if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $poznx = $fir_riadok->itxt; }
//echo $poznx;
?>
<a href="#" onclick="TlacOBJ(<?php echo $riadok->xdok; ?>);"><img src='../obr/tlac.png' width=20 height=15 title='TlaËiù objedn·vku' ></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php if( $zmtz == 1 AND $zinejfir == 0 AND $somvprirskl == 0 ) { ?>
<a href="#" onClick="ZmazOBJ(<?php echo $riadok->xdok; ?>);"><img src='../obr/zmaz.png' width=20 height=15 title='Zmazaù objedn·vku' ></a>
<?php                                                           } ?>
</td>
</tr>
<?php
 }

}

if( $riadok->pox == 10 AND $drupoh == 1 )
{


if( $html == 1 )
 {
?>
<tr>
<td colspan="4">&nbsp;Celkom</td>
<td align="right"><?php echo $riadok->xhdd; ?></td>
</tr>
<tr>
</table>
<?php
 }

}





}
$i = $i + 1;
$j = $j + 1;

  }



$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
