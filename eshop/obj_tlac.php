<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$zmtz=1*$_REQUEST['zmtz'];

if( $zmtz == 1 )
  {
$sys = 'SKL';
$urov = 2000;
$clsm = 960;
$uziv = include("../uziv.php");
if( !$uziv ) exit;
  }
if( $zmtz == 0 )
  {
session_start(); 
$h5rtgh5 = include("../odpad2010/h5rtgh5.php");
//$kli_vxcf=53;
$kli_uzid=1*$_SESSION['ez_id'];
if( $kli_uzid == 0 ) exit;
  }

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$html = 1*$_REQUEST['html'];
$xyid = 1*$_REQUEST['xyid'];
$xyico = 1*$_REQUEST['xyico'];
$vybavene = 1*$_REQUEST['vybavene'];
$mont = 1*$_REQUEST['mont'];

$hladaj_uce = 1*strip_tags($_REQUEST['hladaj_uce']);
if( $hladaj_uce == 0 ) $hladaj_uce=31100;


  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

if( $zmtz == 0 )
  {
$citwebs = include("../funkcie/citaj_webs.php");
$kli_vxcf=$webs_fir;
if( $kli_vxcf == 0 ) exit;
  }

if( $zmtz == 1 )
  {
$citwebs = include("../funkcie/citaj_webs.php");
$cit_fir = include("../cis/citaj_fir.php");


$sql = "SELECT xhdd FROM F$kli_vxcf"."_kosik";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = 'DROP TABLE F'.$kli_vxcf.'_kosik'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_kosik';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   xdok         int DEFAULT 0,
   xice         decimal(10,0) DEFAULT 0,
   xcpl         int PRIMARY KEY not null auto_increment,
   xcis         varchar(15) NOT NULL,
   xnat         VARCHAR(50) NOT NULL,
   xdph         DECIMAL(2,0) DEFAULT 20,
   xcep         decimal(10,4) DEFAULT 0,
   xced         decimal(10,2) DEFAULT 0,
   xmno         decimal(10,3) DEFAULT 0,
   xhdb         decimal(10,2) DEFAULT 0,
   xhdd         decimal(10,2) DEFAULT 0,
   xid          INT DEFAULT 0,
   xdatm        TIMESTAMP(14)
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_kosik'.$sqlt;
$vytvor = mysql_query("$vsql");
}

$sql = "SELECT xcpo FROM F$kli_vxcf"."_kosikobj";
$vysledok = mysql_query("$sql");
if (!$vysledok)
 {

$vsql = 'DROP TABLE F'.$kli_vxcf.'_kosikobj';
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

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_kosikobj'.$sqlt;
$vytvor = mysql_query("$vsql");

 }

$sql = "SELECT xodbm FROM F$kli_vxcf"."_kosikobj";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_kosik ADD xodbm decimal(10,0) DEFAULT 0 AFTER xice";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_kosikobj ADD xodbm decimal(10,0) DEFAULT 0 AFTER xice";
$vysledek = mysql_query("$sql");
}

$sqlttt = "ALTER TABLE F".$kli_vxcf."_kosikobj MODIFY xdx3 VARCHAR(80) NOT NULL "; 
$sqldok = mysql_query("$sqlttt");

  }
//koniec ak zmtz=1


if( $fir_fico == '46614478' )
  {
$sqlttt = "ALTER TABLE F".$kli_vxcf."_kosikobj MODIFY xcep decimal(10,4) DEFAULT 0 "; 
$sqldok = mysql_query("$sqlttt");
$sqlttt = "ALTER TABLE F".$kli_vxcf."_kosikobj MODIFY xced decimal(10,4) DEFAULT 0 "; 
$sqldok = mysql_query("$sqlttt");
  }


$autoreg=0;
if (File_Exists ('../eshop/autoregistracia.ano') ) { $autoreg=1; }
$autoregsubor="../dokumenty/FIR$kli_vxcf/"."autoregistracia.ano";
if (File_Exists ($autoregsubor) ) { $autoreg=1; }

//vymaz vcerajsuie z kosika
if( $autoreg == 1 AND $copern == 1 )
{
$dnessql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$sqlfir = "DELETE FROM F$kli_vxcf"."_kosik WHERE xid > 999990000 AND xdatm < '$dnessql' ";
$fir_vysledok = mysql_query($sqlfir);


}
//koniec vymaz vcerajsuie z kosika

//nastav sklzas na tl1=1 a cep,ced
$dsqlt = "UPDATE F21_sklcis SET tl1=1, cep=1, ced=1.2 WHERE cis > 1 ";
$dsqlt = "UPDATE F21_sklcis SET tl1=0, cep=0, ced=0 WHERE cis > 1 ";
//echo $dsqlt;
//$dsql = mysql_query("$dsqlt");

//zisti ci som v prirucnom sklade
$somvprirskl=0;
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ezak WHERE cuid = $kli_uzid AND cskf = $kli_vxcf ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$cskp = 1*$fir_riadok->cskp; $cskf = 1*$fir_riadok->cskf; $xxid = 1*$fir_riadok->ez_id;

if( $cskp > 0 AND $cskf > 0 )
  {
$somvprirskl=1;
  }

//koniec zisti ci som v prirucnom sklade

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
  var okno = window.open("obj_tlac.php?copern=7702&drupoh=1&page=1&plux=0&ffd=0&zmtz=<?php echo $zmtz; ?>","_self");
</script>
<?php
$copern=1;
$html=1;
}
if( $copern == 7702 )
{

$novaobj=1;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_kosikobj WHERE xdok > 0 ORDER BY xdok DESC LIMIT 1"; 
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $novaobj=$riaddok->xdok+1;
 }

$kli_uzidxx=$kli_uzid;
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ezak WHERE cuid = $kli_uzid ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $xeid = 1*$fir_riadok->ez_id; }
if( $xeid > 0 ) { $kli_uzidxx=$xeid; }

//xdok  xfak  xsx1  xsx2  xsx3  xdx1  xdx2  xdx3  xice  xodbm  xcpo  xcpl  xcis  xnat  xdph  xcep  xced  xmno  xhdb  xhdd  xid  xdatm  

$dsqlt = "INSERT INTO F$kli_vxcf"."_kosikobj ( xdok, xfak, xice, xodbm, xsx3, xcis, xnat, xid, xdatm ) ".
" VALUES ( $novaobj, 0, '$fir_fico', 0, 0, 0, 'Objedn·vame si u V·s', $kli_uzidxx, now() ) ";
if( $novaobj > 0 ) { $dsql = mysql_query("$dsqlt"); }
//echo $dsqlt;

$html=1;
$copern=1;
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
  var okno = window.open("obj_tlac.php?copern=6002&drupoh=1&page=1&plux=<?php echo $plux; ?>&ffd=0&zmtz=<?php echo $zmtz; ?>","_self");
</script>
<?php
$copern=1;
$html=1;
}
if( $copern == 6002 )
{
$plux = 1*$_REQUEST['plux'];

$dsqlt = "DELETE FROM F$kli_vxcf"."_kosikobj  WHERE xdok = $plux ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_kosiktext  WHERE invt = $plux ";
$dsql = mysql_query("$dsqlt");

$html=1;
$copern=1;
}
//koniec zmazat obj

//spracovat obj
if( $copern == 8001 )
{
$plux = 1*$_REQUEST['plux'];
?>
<script type="text/javascript">
if( !confirm ("Chcete spracovaù objedn·vku Ë.<?php echo $plux; ?> ?") )
         {   }
else
  var okno = window.open("../faktury/vstf_u.php?copern=5&shopdok=1&drupoh=1&page=1sysx=UCT&rozuct=ANO&hladaj_uce=<?php echo $hladaj_uce;?>&cislo_dok=<?php echo $plux; ?>&ttx=1","_self");
</script>
<?php
$html=1;
$copern=1;
}
//koniec spracovat obj

$zinejfir=0;
if( $fir_xfa06 > 0 ) { $zinejfir=1; }

//presun fakturu do objednavok
if( $copern == 8011 )
{
$kli_vxcfskl=$kli_vxcf;
if( $fir_xfa06 > 0 ) { $kli_vxcfskl=$fir_xfa06; }


//kosikobj xdok  xfak  xsx1  xsx2  xsx3  xdx1  xdx2  xdx3  xice  xcpo  xcpl  xcis  xnat  xdph  xcep  xced  xmno  xhdb  xhdd  xid  xdatm  
//   7 720012 0 0 0 0000-00-00 0000-00-00 0000-00-00 31414699 3 51 2   20 1.0000 1.20 3.000 3.00 3.60 1001 2012-04-30 23:17:00 
//sklfak cpl  ume  dat  dok  doq  skl  poh  ico  fak  unk  dol  prf  poz  str  zak  cis  nat  dph  mer  pop  mno  cen  cep  ced  id  sk2  datm  me2  mn2  
//      1 4.2012 2012-04-22 720010 NULL 1 51 31414699 720010 NULL 0 0 NULL 0 0 12 PepsiCola 0.3l 20 ks   50.000 0.9000 1.0000 1.2000 38 NULL 2012-04-22 16:59:45 0 0.000 

$cislo_dok = 1*$_REQUEST['cislo_dok'];

$ico=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_fakodb WHERE dok = $cislo_dok ORDER BY dok LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $ico=1*$riaddok->ico;
 $odbm=1*$riaddok->odbm;
 $uce=1*$riaddok->uce;
 }

$id=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_ezak WHERE ez_ico = $ico ORDER BY ez_id LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $id=1*$riaddok->ez_id;
 }
if( $id == 0 ) { $id=1*$kli_uzid; }

//andrejko cislo kosikobj+10000
$novaobj=1;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_kosikobj WHERE xdok > 0 ORDER BY xdok DESC LIMIT 1"; 
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $novaobj=$riaddok->xdok+1;
 }
if( $novaobj < 100000 ) { $novaobj=$novaobj+100000; }

$dsqlt = "INSERT INTO F$kli_vxcfskl"."_kosikobj ".
" SELECT $novaobj,0,0,0,0,'','','','$ico','$odbm',0,cpl,cis,nat,dph,cep,ced,mno,(cep*mno),(ced*mno),'$id',now() FROM F$kli_vxcfskl"."_sklfak WHERE dok = $cislo_dok ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcfskl"."_kosikobj ".
" SELECT $novaobj,0,0,0,1,'','','','$ico','$odbm',0,cpl,slu,nsl,dph,cep,ced,mno,(cep*mno),(ced*mno),'$id',now() FROM F$kli_vxcf"."_fakslu WHERE dok = $cislo_dok ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcfskl"."_sklfak WHERE dok = $cislo_dok ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_fakslu WHERE dok = $cislo_dok ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_fakodb WHERE dok = $cislo_dok ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_uctodb WHERE dok = $cislo_dok ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_dodb SET cfak=$cislo_dok WHERE dodb = $uce AND cfak > $cislo_dok";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_ufir SET fakodb=$cislo_dok WHERE fakodb > $cislo_dok";
$dsql = mysql_query("$dsqlt");

$copern=1;
$drupoh=1;
$html=1;
if( $fir_xfa06 > 0 ) { $zinejfir=1; }
}
//koniec presun fakturu do objednavok

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>
Objedn·vky
</title>
  <style type="text/css">
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

function TlacFakturu(dok)
                {              

window.open('../faktury/vstf_pdf.php?sysx=INE&rozuct=NIE&copern=20&drupoh=1&page=1&cislo_dok=' + dok + '&hladaj_dok=' + dok + '&xcv=1', '_blank'
, 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );

                }

<?php  if( $zmtz == 1 ) { ?>

function NovaOBJ()
                {

window.open('obj_tlac.php?copern=7701&drupoh=1&page=1&plux=0&ffd=0&zmtz=<?php echo $zmtz; ?>',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }
    
function ZmazOBJ(plu)
                {

var plux = plu;

window.open('obj_tlac.php?copern=6001&drupoh=1&page=1&plux='+ plux + '&ffd=0&zmtz=<?php echo $zmtz; ?>',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }



function SpracujOBJ(plu)
                {
var plux = plu;

window.open('obj_tlac.php?copern=8001&drupoh=1&page=1&plux='+ plux + '&ffd=0&zmtz=<?php echo $zmtz; ?>',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );

                }

<?php                    } ?>


function TlacOBJ(plu)
                {
var plux = plu;

window.open('kosik_tlac.php?copern=1&drupoh=1&page=1&cislo_dok=' + plux + '&ffd=0&tlacobj=1&zmtz=<?php echo $zmtz; ?>',
 '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function StavOBJ(plu, ico)
                {
var plux = plu;
var icox = ico;

window.open('obj_stav.php?copern=1&drupoh=1&page=1&cislo_dok=' + plux + '&icox=' + icox + '&ffd=0&tlacobj=1&zmtz=<?php echo $zmtz; ?>',
 '_self', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function StavOBJALL(plu, ico)
                {
var plux = plu;
var icox = ico;

window.open('obj_stav.php?copern=1&drupoh=1&page=1&cislo_dok=' + plux + '&icox=' + icox + '&ffd=0&tlacobj=1&zmtz=<?php echo $zmtz; ?>&vseobj=1',
 '_self', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function StavOBJico(plu, ico)
                {
var plux = plu;
var icox = ico;

window.open('obj_stav.php?copern=1&drupoh=1&page=1&cislo_dok=' + plux + '&icox=' + icox + '&ffd=0&tlacobj=1&zmtz=<?php echo $zmtz; ?>&vseobj=1&vsezaico=1',
 '_self', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function nakupnykosik()
    {
 
window.open('kosik_tlac.php?copern=1&drupoh=1&page=1&html=1',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
   
    }


function MojeFaktury(icox)
                {
var h_ico = icox;

window.open('../ucto/saldo_pdf.php?h_uce=31100&h_nai=&h_ico=' + h_ico + '&h_obd=0&copern=10&drupoh=1&page=1&h_su=0&h_al=1&analyzy=0&zkosika=1',
 '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function AllObjID(xid)
                {
var xyid = xid;

window.open('../eshop/obj_tlac.php?copern=1&drupoh=1&xyid=' + xyid + '&page=1&zmtz=1&html=1',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function AllObjICO(xico)
                {
var xyico = xico;

window.open('../eshop/obj_tlac.php?copern=1&drupoh=1&xyico=' + xyico + '&page=1&zmtz=1&html=1',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function MontZoznam()
                {

window.open('../eshop/obj_tlac.php?copern=1&drupoh=1&page=1&zmtz=1&html=1&mont=1',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function SpatZoznam()
                {

window.open('../eshop/obj_tlac.php?copern=1&drupoh=1&page=1&zmtz=1&html=1',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function VybavZoznam()
                {

window.open('../eshop/obj_tlac.php?copern=1&drupoh=1&page=1&zmtz=1&html=1&vybavene=1',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

    function textObj( objx )
    {

var h_obj = objx;

window.open('../eshop/obj_text.php?h_obj=' + h_obj + '&copern=1&drupoh=1&page=1&zmtz=1', '_blank',  'width=900, height=800, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );


    }

function hladajMat()
                {


window.open('../sklad/cisobj.php?copern=1&page=1', '_blank', 'width=950, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );


                }

</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<?php
$tnadpis=" - nevybavenÈ";
if( $xyid  > 0 )  { $tnadpis=" "; }
if( $xyico > 0 )  { $tnadpis=" - vöetky pre i»O ".$xyico; }
if( $vybavene == 1 )  { $tnadpis=" - vybavenÈ "; }
if( $mont == 1 )  { $tnadpis=" - nevybavenÈ Mont·ûe"; }
?>
<td>EuroSecom  -  Objedn·vky <?php echo $tnadpis; ?> 



</td>
</tr>
</table>
<br />

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
   xsx1         decimal(10,0) DEFAULT 0,
   xsx2         decimal(10,0) DEFAULT 0,
   xsx3         decimal(10,0) DEFAULT 0,
   xdx1         DATE not null,
   xdx2         DATE not null,
   xdx3         DATE not null,
   xice         decimal(10,0) DEFAULT 0,
   xodbm        decimal(10,0) DEFAULT 0,
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
   xdatm        TIMESTAMP(14)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

if( $zmtz == 0 ) {
//zober objednavky aky za jedneho
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 0,xdok,xfak,0,0,xsx3,'','','',xice,xodbm,0,xcpl,xcis,xnat,xdph,xcep,xced,xmno,xhdb,xhdd,xid,xdatm FROM F$kli_vxcf"."_kosikobj WHERE xid = $kli_uzid ";
$dsql = mysql_query("$dsqlt");
                 }

$podmfak="xfak = 0 ";
if( $xyid  > 0 )  { $podmfak="xfak >= 0 "; }
if( $xyico > 0 )  { $podmfak="xfak >= 0 "; }
if( $vybavene == 1 )  { $podmfak="xfak > 0 "; }


if( $zmtz == 1 ) {
//zober objednavky vsetky
$kli_vxcfxxx=$kli_vxcf;
if( $fir_xfa06 > 0 ) { $kli_vxcfxxx=$fir_xfa06; }
//and
if( $somvprirskl == 1 ) { $kli_vxcfxxx=$webs_fir; }
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 0,xdok,xfak,xsx1,0,xsx3,'','','',xice,xodbm,0,xcpl,xcis,xnat,xdph,xcep,xced,xmno,xhdb,xhdd,xid,xdatm FROM F$kli_vxcfxxx"."_kosikobj WHERE xid >= 0 AND $podmfak ";
$dsql = mysql_query("$dsqlt");

if( $zinejfir == 1 ) {
$dsqlt = "DELETE FROM F$kli_vxcfskl"."_mzdprcx$kli_uzid. WHERE xid != $kli_uzid ";
$dsql = mysql_query("$dsqlt");
                     }
                 }

if( $somvprirskl == 1 ) {

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcx$kli_uzid  WHERE xid != $xxid AND xid != $kli_uzid ";
$dsql = mysql_query("$dsqlt");

                        }

//ak pre ico a id vymaz ostatne
if( $xyid > 0 )  {

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcx$kli_uzid  WHERE xid != $xyid ";
$dsql = mysql_query("$dsqlt");
$zinejfir=1;
                 }
if( $xyico > 0 ) {

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcx$kli_uzid  WHERE xice != $xyico ";
$dsql = mysql_query("$dsqlt");
$zinejfir=1; 
                 }



//group doklad
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,xdok,xfak,xsx1,0,0,'','','',xice,xodbm,0,xcpl,xcis,xnat,xdph,xcep,xced,SUM(xmno),SUM(xhdb),SUM(xhdd),xid,xdatm  FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE xdok > 0 GROUP BY xdok".
"";
$dsql = mysql_query("$dsqlt");

//group vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 10,999999999,0,0,0,0,'','','',xice,0,0,xcpl,xcis,xnat,xdph,xcep,xced,SUM(xmno),SUM(xhdb),SUM(xhdd),xid,xdatm  FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE pox = 1 AND $podmfak GROUP BY pox".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." WHERE pox = 0 ";
$dsql = mysql_query("$dsqlt");


if ( $html == 1 )  
{
?>
<table class="h2" width="100%" >
<tr>
<td class="bmenu" colspan="1">Objedn·vky

<?php if( $zmtz == 1 AND $zinejfir == 0 AND $somvprirskl == 0 ) { ?>
<a href="#" onClick="NovaOBJ();">
<img src='../obr/vlozit.png' width=15 height=15 border=1 title='Nov· objedn·vka ' ></a>
<?php                                     } ?>
</td>

<td class="bmenu" colspan="1" align="right">
<a href="#" onClick="VybavZoznam();">
VybavenÈ OBJ<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobraziù vybavenÈ objedn·vky' ></a>
</td>

<td class="bmenu" colspan="3" align="right">
<a href="#" onClick="MontZoznam();">
Mont·ûe<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobraziù nevybavenÈ mont·ûe' ></a>
<a href="#" onClick="SpatZoznam();">
NevybavenÈ OBJ<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobraziù nevybavenÈ objedn·vky' ></a>
</tr>
<?php
}

if ( $drupoh == 1 )
  {

//montaze
if( $mont == 1 )
  {
$sqlttx = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid.",F$kli_vxcf"."_kosiktext SET xsx2=1 ".
" WHERE F$kli_vxcf"."_mzdprcx".$kli_uzid.".xdok=F$kli_vxcf"."_kosiktext.invt AND F$kli_vxcf"."_kosiktext.nas1 = 1 ";
$tovx = mysql_query("$sqlttx");

$podmfak="xfak = 0 AND xsx2 = 1 "; 
  }

$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_mzdprcx".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_mzdprcx".$kli_uzid.".xcis=F$kli_vxcf"."_sklcis.cis".
" WHERE xdok > 0 AND $podmfak ORDER BY xdok ";
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
<tr>
<td class="bmenu" align="right" width="10%" >»Ìslo obj.</td>
<td class="bmenu" align="left" width="60%" >Z·kaznÌk
<img src='../obr/zoznam.png' onclick="window.open('../cis/cico.php?copern=1&page=1', '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' )" width=20 height=20 border=0 title='»ÌselnÌk I»O' >

&nbsp&nbsp&nbsp
<input type='image' src='../obr/kosik.gif' width=20 height=20 border=0 title='Vybran˝ materi·l na nevybaven˝ch objedn·vkach z e-shopu'
 onclick="hladajMat();" >

</td>
<td class="bmenu" align="left" width="10%" >Stav obj.
<?php if( $zmtz == 1 AND $zinejfir == 0 AND $somvprirskl == 0 AND $vybavene == 0 ) { ?>
<a href="#" onClick="StavOBJALL(0, 0);">
<img src='../obr/naradie.png' width=20 height=20 border=0 title='Stav vöetk˝ch objedn·vok' ></a>
<?php                                     } ?>
</td>
<td class="bmenu" align="right" width="10%" >PoËet poloûiek</td>
<td class="bmenu" align="right" width="10%" >Hodnota bez/s DPH</td>
</tr>
<?php
                                      }



     }
//koniec hlavicky j=0



if( $riadok->pox == 1 AND $drupoh == 1 )
{
$skdatum=SkDatum($riadok->xdatm);

if( $html == 1 )
 {



$sqlfir = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $riadok->xice ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$ico = $fir_riadok->ico; $dic = $fir_riadok->dic; $icd = $fir_riadok->icd;
$nai = $fir_riadok->nai; $na2 = $fir_riadok->na2; $uli = $fir_riadok->uli;
$psc = $fir_riadok->psc; $mes = $fir_riadok->mes; $tel = $fir_riadok->tel; $fax = $fir_riadok->fax; $em1 = $fir_riadok->em1;

$icox=1*$ico;

$sqlfir = "SELECT * FROM F$kli_vxcf"."_ezak WHERE ez_id = $riadok->xid ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$ekto = $fir_riadok->ez_kto; $etel = $fir_riadok->ez_tel; $email = $fir_riadok->ez_ema; $odbx = 1*$fir_riadok->cxx1; $icoezak = 1*$fir_riadok->ez_ico;


if( $riadok->xid < 900 AND trim($ekto) == '' )
  {
$sqlfir = "SELECT * FROM klienti WHERE id_klienta = $riadok->xid ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$ekto = $fir_riadok->meno." ".$fir_riadok->priezvisko; $etel = ""; $email = ""; $odbx = 0; $icoezak = 0;

  }

if( $icoezak == 99999999 ) { $odbx=1*$riadok->xodbm; }

?>
<tr>
<td class="hvstup" align="right">
<?php echo $riadok->xdok; ?>

<?php if( $zmtz == 1 AND $zinejfir == 0 AND $somvprirskl == 0 AND $vybavene == 0 ) { ?>
<a href="#" onClick="SpracujOBJ(<?php echo $riadok->xdok; ?>);">
<img src='../obr/ok.png' width=20 height=20 border=0 title='Spracovaù cel˙ objedn·vku Ë.<?php echo $riadok->xdok; ?> do Fakt˙ry' ></a>
<?php                                     } ?>
</td>
<td class="hvstup" align="left">
<a href="#" onClick="TlacOBJ(<?php echo $riadok->xdok; ?>);">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='TlaËiù potvrdenie objedn·vky' ></a>
D·tum: <?php echo $skdatum; ?>
 Objednal: 
<a href="#" onClick="AllObjID(<?php echo $riadok->xid; ?>);" title='Vöetky objedn·vky objedn·vateæa' >
<?php echo $ekto; ?>
</a>
, Tel: <?php echo $etel; ?>, Email: <?php echo $email; ?>
 Firma: 
<?php if(( $zmtz == 1 AND $zinejfir == 0 ) OR ( $somvprirskl == 1 )) { ?>
<a href="#" onClick="StavOBJico(0, <?php echo $icox; ?>);">
<img src='../obr/naradie.png' width=15 height=12 border=0 title='Stav objedn·vok za firmu' ></a>
<?php                                     } ?>

<a href="#" onClick="AllObjICO(<?php echo $icox; ?>);" title='Vöetky objedn·vky za firmu'>
<?php echo $nai; ?> <?php echo $na2; ?>
</a>
, <?php echo $uli; ?>, <?php echo $mes; ?>, <?php echo $psc; ?>
<?php if( $odbx > 0 ) { 

$sqlfir = "SELECT * FROM F$kli_vxcf"."_icoodbm WHERE ico = $icox AND odbm = $odbx ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$onai = $fir_riadok->onai; $ona2 = $fir_riadok->ona2; $ouli = $fir_riadok->ouli;
$opsc = $fir_riadok->opsc; $omes = $fir_riadok->omes; 

?>
 OdbernÈ miesto: <?php echo $onai; ?> <?php echo $ona2; ?>, <?php echo $ouli; ?>, <?php echo $omes; ?>, <?php echo $opsc; ?>
<?php                 } ?>

Pozn·mka <img src='../obr/orig.png' width=20 height=15 border=1 onclick="textObj('<?php echo $riadok->xdok;?>')" title="Pozn·mka k objedn·vke" >

<?php
//poznamka
$poznx="";
$sqlfir = "SELECT * FROM F$kli_vxcf"."_kosiktext WHERE invt = $riadok->xdok ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { 
$fir_riadok=mysql_fetch_object($fir_vysledok); 
$poznx = $fir_riadok->itxt; 
$eobj = 1*$fir_riadok->eobj;
$akod = 1*$fir_riadok->akod;
$datd_sk = SkDatum($fir_riadok->datd);

if( $eobj > 0 ) { $poznx=$poznx." eshopOBJ: ".$eobj; }
if( $datd_sk != "00.00.0000" ) { $poznx=$poznx." dodaù: ".$datd_sk; }
}
echo $poznx;
?>

</td>
<td class="hvstup" align="right"> 
<?php
$cislodod=1*$riadok->xsx1;
if( $cislodod > 0 ) { echo "Dod.list".$cislodod; }
?>
<?php if(( $zmtz == 1 AND $zinejfir == 0 AND $vybavene == 0 ) OR ( $somvprirskl == 1 AND $vybavene == 0 )) { ?>
<a href="#" onClick="StavOBJ(<?php echo $riadok->xdok; ?>, <?php echo $icox; ?>);">
<img src='../obr/naradie.png' width=20 height=20 border=0 title='Stav objedn·vky' ></a>
<?php                                     } ?>
<?php 
$cislofak=1*$riadok->xfak;
if( $cislofak > 0 )
  {
echo " F".$cislofak;
  }
?>
<?php if( $vybavene == 1 ) { ?>
<a href="#" onClick="TlacFakturu(<?php echo $riadok->xfak; ?>);">
<img src='../obr/pdf.png' width=20 height=20 border=0 title='Zobraziù PDF fakt˙ru <?php echo $riadok->xfak; ?> ' ></a>
<?php                                     } ?>
</td>
<td class="hvstup" align="right"><?php echo $riadok->xmno; ?></td>
<td class="hvstup" align="right">
<?php echo $riadok->xhdb; ?> / <?php echo $riadok->xhdd; ?>

<?php if( $zmtz == 1 AND $zinejfir == 0 AND $somvprirskl == 0 AND $vybavene == 0 ) { ?>
<a href="#" onClick="ZmazOBJ(<?php echo $riadok->xdok; ?>);">
<img src='../obr/zmaz.png' width=20 height=15 border=0 title='Zmazaù objedn·vku' ></a>
<?php                                     } ?>
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
<td class="bmenu" colspan="3" >Celkom bez/s DPH</td>
<td class="bmenu" align="right"><?php echo $riadok->xmno; ?></td>
<td class="bmenu" align="right"><?php echo $riadok->xhdb; ?> / <?php echo $riadok->xhdd; ?></td>
</tr>
<tr>
<?php
 }

}





}
$i = $i + 1;
$j = $j + 1;

  }

if( $html == 1 )
 {
?>
<tr>
<td class="bmenu" colspan="4" > </td>
<td class="bmenu" align="right"> 
<?php if( $zmtz == 0 ) { ?>
<a href="#" onClick="MojKosik();">
<img src='../obr/kosik.gif' onclick="nakupnykosik();" width=25 height=17 border=1 title="N·kupn˝ koöÌk" >
</a>

<a href="#" onClick="MojeFaktury(<?php echo $ico; ?>);">
<img src='../obr/zoznam.png' width=20 height=20 border=0 title='Zoznam mojÌch neuhraden˝ch fakt˙r' ></a>
<?php                  } ?>
</td>
</tr>

<?php
 }



$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
