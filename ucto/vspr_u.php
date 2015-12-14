<HTML>
<?php
$sys = 'UCT';
if( $_SERVER['SERVER_NAME'] == "www.stavoimpexsro.sk" ) { $sys = 'MZD'; }
$urov = 2000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {
//5=novy doklad zadavanie udajov po vyplneni ide na 68 ulozi a vrati sa do vstpru.php ako copern=1
//6=vymazanie faktury  po odsuhlaseni sa vrati sa do vstpru.php ako copern na 16
//8=uprava dokladu po vyplneni ide na 78 ulozi a vrati sa do vstpru.php ako copern na 1
//7=z novej 5 alebo upravy 8 po odpaleni sluzby ulozi 68 alebo 78 hlavicku a ide na vstup sluzieb
//77=ulozenie polozky sluzby do uctpok a naspat do copern na 7
//36=vymazanie polozky sluzby a naspat do copern na 7
//87=vybral som polozku sluzieb na upravu a 88 update upravenej a naspat do copern na 7
//97=vybral som textovu polozku sluzieb na upravu a 98 update upravenej textovej a naspat do copern na 7

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$citfir = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;


if( $kli_vxcf == 109 AND $_SERVER['SERVER_NAME'] == "www.europkse.sk" )
    {

?>
<script type="text/javascript">
alert ("PrÌkazy na ˙hradu do banky \r musÌte spracov·vaù vo firme roku 2011 !");
window.close();
</script>
<?php
exit;
    }


$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvfak";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvskl = include("../faktury/vtvfak.php");
endif;

$sql = "ALTER TABLE F$kli_vxcf"."_uctprikp ADD pbic VARCHAR(10) NOT NULL AFTER iban ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdtrn MODIFY trx3 VARCHAR(10) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzaltrn MODIFY trx3 VARCHAR(10) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctprikp MODIFY pbic VARCHAR(15) NOT NULL ";
$vysledek = mysql_query("$sql");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$drupoh = strip_tags($_REQUEST['drupoh']);
$hladaj_uce = $_REQUEST['hladaj_uce'];

$rozuct = $_REQUEST['rozuct'];
if(!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if(!isset($sysx)) $sysx = 'INE';

$ucto_sys=$_SESSION['ucto_sys'];
//echo $ucto_sys;
if( $ucto_sys == 1 )
{
$rozuct='ANO';
$sysx='UCT';
}

$page = strip_tags($_REQUEST['page']);
$cislo_dok = strip_tags($_REQUEST['cislo_dok']);
$h_uce = strip_tags($_REQUEST['h_uce']);
if(!isset($hladaj_uce)) $hladaj_uce = $h_uce;
$h_dok = strip_tags($_REQUEST['h_dok']);
$h_dat = strip_tags($_REQUEST['h_dat']);
$h_ico = strip_tags($_REQUEST['h_ico']);
$h_nai = strip_tags($_REQUEST['h_nai']);
$h_poz = strip_tags($_REQUEST['h_poz']);
$h_kto = strip_tags($_REQUEST['h_kto']);
$h_txp = strip_tags($_REQUEST['h_txp']);
$h_txz = strip_tags($_REQUEST['h_txz']);
$h_unk = strip_tags($_REQUEST['h_unk']);

$newdok = strip_tags($_REQUEST['newdok']);

$hlat = strip_tags($_REQUEST['hlat']);
$vybr = strip_tags($_REQUEST['vybr']);
$hlat_ico = strip_tags($_REQUEST['h_ico']);
$hlat_nai = strip_tags($_REQUEST['h_nai']);
$rozb1 = strip_tags($_REQUEST['rozb1']);
$rozb2 = strip_tags($_REQUEST['rozb2']);
$h_tlsl = strip_tags($_REQUEST['h_tlsl']);
$sluz1 = 'MALE';
if( $h_tlsl == 1 AND $rozb2 == 'NOT' ) $sluz1 = 'VELKE';
$h_tltv = strip_tags($_REQUEST['h_tltv']);
$tov1 = 'MALE';
if( $h_tltv == 1 AND $rozb2 == 'NOT'  ) $tov1 = 'VELKE';
$hlas = strip_tags($_REQUEST['hlas']);

$h_cpl = strip_tags($_REQUEST['h_cpl']);
$h_uceb = strip_tags($_REQUEST['h_uceb']);
$h_numb = strip_tags($_REQUEST['h_numb']);
$h_hodp = strip_tags($_REQUEST['h_hodp']);
$h_hodm = strip_tags($_REQUEST['h_hodm']);
$h_vsy = strip_tags($_REQUEST['h_vsy']);
$h_ksy = strip_tags($_REQUEST['h_ksy']);
$h_ssy = strip_tags($_REQUEST['h_ssy']);
$h_iban = strip_tags($_REQUEST['h_iban']);
$h_pbic = strip_tags($_REQUEST['h_pbic']);
$h_twib = strip_tags($_REQUEST['h_twib']);
$h_zmen = strip_tags($_REQUEST['h_zmen']);
$h_kurz = strip_tags($_REQUEST['h_kurz']);
$h_pomr = strip_tags($_REQUEST['h_pomr']);
$h_mena = strip_tags($_REQUEST['h_mena']);
$h_iban = strip_tags($_REQUEST['h_iban']);
$h_pbic = strip_tags($_REQUEST['h_pbic']);

if ( $rozb2 == 'VELKE' AND $copern == 68) $copern=15;
if ( $rozb2 == 'VELKE' AND $copern == 78) $copern=18;
if ( $rozb2 == 'MALE' AND $copern == 68) $copern=15;
if ( $rozb2 == 'MALE' AND $copern == 78) $copern=18;

if( $drupoh == 1 )
{
$tabl = "uctpriku";
$adrdok = "pokprijem";
$uctpol = "uctprikp";
$uctpoh = "uctprikp";
if( $copern == 5 )
    {
$odber=1;
$dodav=1;
$saldo_subor = include("saldo_subor.php"); 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldo'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofak'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldo'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
    }
}

$mazanie=0;


//ulozenie  polozky sluzby 7777777777777777
if ( $copern == 77 )
    {

if( $h_ksy == 0 ) $h_ksy="";
if( $h_ssy == 0 ) $h_ssy="";
$h_hodm=$h_hodp;
if( $h_zmen == 1 AND $kli_vrok < 2009 ) $h_hodp=$h_kurz*$h_hodm/$h_pomr;
if( $h_zmen == 1 AND $kli_vrok > 2008 ) $h_hodp=($h_hodm/$h_kurz)*$h_pomr;

$sqty = "INSERT INTO F$kli_vxcf"."_$uctpol ( dok,uceb,numb,hodp,hodm,vsy,ksy,ssy,id,uce,ico,iban,pbic,twib )".
" VALUES ('$cislo_dok', '$h_uceb', '$h_numb', '$h_hodp', '$h_hodm', '$h_vsy', '$h_ksy', '$h_ssy',".
" '$kli_uzid', '$h_uce', '$h_ico', '$h_iban', '$h_pbic', '$h_twib' );"; 
$ulozene = mysql_query("$sqty"); 

$uprt = "UPDATE F$kli_vxcf"."_$tabl SET hodp=hodp+'$h_hodp', hodm=hodm+'$h_hodm'  WHERE dok='$cislo_dok'";
//echo $uprt;
$upravene = mysql_query("$uprt");

$copern=7;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec ulozenia polozky sluzby

//vymazanie polozky sluzby 3636363636363636363
if ( $copern == 316 )
    {
$mazanie=1;
$z_hodp = strip_tags($_REQUEST['z_hodp']);
$z_hodm = strip_tags($_REQUEST['z_hodm']);
$z_uceb = strip_tags($_REQUEST['z_uceb']);
$z_numb = strip_tags($_REQUEST['z_numb']);
$z_iban = strip_tags($_REQUEST['z_iban']);
$z_pbic = strip_tags($_REQUEST['z_pbic']);
$z_vsy = strip_tags($_REQUEST['z_vsy']);
$z_ksy = strip_tags($_REQUEST['z_ksy']);
$z_ssy = strip_tags($_REQUEST['z_ssy']);
$z_twib = strip_tags($_REQUEST['z_twib']);

$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$cislo_dok = strip_tags($_REQUEST['cislo_dok']);

$uprt = "UPDATE F$kli_vxcf"."_$tabl SET hodp=hodp-'$z_hodp', hodm=hodm-'$z_hodm' WHERE dok='$cislo_dok'";
//echo $uprt;
$upravene = mysql_query("$uprt");

$zmazttt = "DELETE FROM F$kli_vxcf"."_$uctpol WHERE cpl='$cislo_cpl' "; 
//echo $zmazttt;
$zmazane = mysql_query("$zmazttt"); 

$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
$copern=7;
endif;
    }
//koniec vymazania polozky sluzby

//nova faktura hlavicka
if ( $copern == 5 OR $copern == 55 )
    {
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$tabl WHERE ( isnull(dok) )"); 

$maxdok=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctpriku WHERE dok > 0 ORDER BY dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $maxdok=$riaddok->dok;
  }

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dban WHERE dban = $hladaj_uce ORDER BY dban DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $riadkto=$riaddok->nban." ".$riaddok->uceb." / ".$riaddok->numb;
  }

$h_doknew=$maxdok+1;

$newdok=$h_doknew;
$h_fak = $newdok;

$dat_dat = Date ("Y-m-d", MkTime (0,0,0,date("m"),date("d"),date("Y")));
$txpxx="";
if( $alchem == 1 ) { $txpxx="20"; }

$sqlhh = "INSERT INTO F$kli_vxcf"."_$tabl ( uce,dok,dat,ico,id,txp,txz,kto,unk,poz,mena,kurz ) VALUES ".
" ( '$hladaj_uce', $newdok, '$dat_dat', '$fir_fico', $kli_uzid, '$txpxx', '', '$riadkto', '', '', '$mena1', '1' )";
//echo $sqlhh;
$ulozene = mysql_query("$sqlhh"); 
if (!$ulozene):
?>
<script type="text/javascript"> alert( " NIE JE SPOJENIE S DATAB¡ZOU ,  ukonËite program a spustite ho znovu " ) </script>
<?php
exit;
endif;
if ($ulozene):
//$uloz="OK";
endif;
$copern=7;
$cislo_dok=$newdok;
    }
//if ( $copern == 15 ) $copern=5;
//if ( $copern == 5 AND $sluz1 == "VELKE" ) $copern=7;
//koniec nova faktura hlavicka


//uprava dokladu hlavicka
if ( $copern == 8 )
    {
$sqltt = "SELECT * FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_$tabl.dok = $cislo_dok ".
"";
$sql = mysql_query("$sqltt"); 
$nieje=0;
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$nieje=1;
$cislo_uce = $riadok->uce;
$cislo_dok = $riadok->dok;
$newdok = $riadok->dok;
$cislo_dat = $riadok->dat;
$cislo_ico = $riadok->ico;
$cislo_unk = $riadok->unk;
$cislo_kto = $riadok->kto;
$cislo_txp = $riadok->txp;
$cislo_txz = $riadok->txz;
$cislo_poz = $riadok->poz;
$vybr_ico = $riadok->ico;
$cislo_datsk = SkDatum($riadok->dat);
$vybr = 'ANO';
  }

if( $nieje == 0 )
{
?>
<script type="text/javascript">
 location.href='vstpru.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=1&drupoh=<?php echo $drupoh; ?>&page=<?php echo $page; ?>'  
</script>
<?php
}
    }

if ( $copern == 18 ) { $copern=8; }
if ( $copern == 8 AND $sluz1 == "VELKE" ) { $copern=7; }
//koniec uprava faktury hlavicka

//nova hlavicka ulozenie 68
if ( $copern == 68 )
  {

$h_dat = SqlDatum($h_dat);

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dban WHERE dban = $h_uce ORDER BY dban DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_kto=$riaddok->nban." ".$riaddok->uceb." / ".$riaddok->numb;
  }

$pole = explode("-", $h_dat);
$h_ume = $pole[1].".".$pole[0];

$uprt = "UPDATE F$kli_vxcf"."_$tabl SET uce='$h_uce', dok='$h_dok', dat='$h_dat',".
" ico='$h_ico', unk='$h_unk',".
" poz='$h_poz', txp='$h_txp', txz='$h_txz',".
" hodp='$h_hodp', kto='$h_kto'".
" WHERE id='$kli_uzid' AND dok='$h_dok'";
//echo $uprt;
$upravene = mysql_query("$uprt");  
$cislo_dok = $h_dok;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA ULOéEN¡ " ) </script>
<?php
exit;
endif;
if ($upravene):
$uprav="OK";
if ( $sluz1 != 'VELKE' )
{
?>
<script type="text/javascript">
 location.href='vstpru.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=1&drupoh=<?php echo $drupoh; ?>&page=1'  
</script>
<?php
}
$copern=7;
endif;
  }
//koniec nova hlavicka ulozenie

//uprava hlavicka ulozenie 78
if ( $copern == 78 )
  {
 
$h_dat = SqlDatum($h_dat);
$h_daz = SqlDatum($h_daz);
$h_das = SqlDatum($h_das);

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dban WHERE dban = $h_uce ORDER BY dban DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_kto=$riaddok->nban." ".$riaddok->uceb." / ".$riaddok->numb;
  }

$pole = explode("-", $h_dat);
$h_ume = $pole[1].".".$pole[0];

$uprt = "UPDATE F$kli_vxcf"."_$tabl SET uce='$h_uce', dok='$h_dok', dat='$h_dat',".
" ico='$h_ico', unk='$h_unk',".
" poz='$h_poz', txp='$h_txp', txz='$h_txz',".
" hodp='$h_hodp', kto='$h_kto'".
" WHERE dok='$h_dok'";
//echo $uprt;
$upravene = mysql_query("$uprt");  

$cislo_dok = $h_dok;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA ULOéEN¡ " ) </script>
<?php
exit;
endif;
if ($upravene):
$uprav="OK";
$sluz1='VELKE';
if ( $sluz1 != 'VELKE' )
{
?>
<script type="text/javascript">
 location.href='vstpru.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=1&drupoh=<?php echo $drupoh; ?>&page=1'  
</script>
<?php
}
$copern=7;
endif;
  }
//koniec uprava hlavicka ulozenie
//echo 'sluz'.$sluz1;
//echo 'rozb1'.$rozb1;
//echo 'rozb2'.$rozb2;
//echo 'copern'.$copern;


if ( $sluz1 == "VELKE" ) { $rozb1="NOT"; $rozb2="NOT"; }

//echo 'rozb1'.$rozb1;
//echo 'rozb2'.$rozb2;
//echo 'copern'.$copern;
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<?php if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 ) echo "<title>PrÌkaz na ˙hradu</title>"; ?>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0; z-index: 300;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js"></SCRIPT>

<?php
if ( $copern == 5 OR $copern == 8 )
{
?>
<script type="text/javascript" src="../ajax/spr_ico_xml.js"></script>
<?php
}
?>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;

function Len1ICO()
                    {
document.forms.fhlv1.h_kto.focus();
                    }

function HlvOnClick()
                    {
 Fxh.style.display='none';
 document.fhlv1.uloh.disabled = true; 
                    }


//posuny Enter[[[[[[[[[[[


function UceEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_dat.focus();
              }
                }


function OnfocusDat()
                {
        if( document.forms.fhlv1.h_dat.value == "" ) { document.forms.fhlv1.h_dat.value = '<?php echo date("d.m.Y"); ?>'; }
        document.forms.fhlv1.h_dat.select();
                }

function DatEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_unk.focus();
        document.forms.fhlv1.h_unk.select();
              }
                }


function UnkEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        if( document.fhlv1.h_ico.value == "" ) { document.fhlv1.h_ico.value = '<?php echo $fir_fico; ?>'; }
        document.forms.fhlv1.h_ico.focus();
        document.forms.fhlv1.h_ico.select();
              }
                }


function IcoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhlv1.h_ico.value != '')
        {
        myIcoElement.style.display='';
        nulujIco();
        volajIco();
        }      
        if( document.fhlv1.h_ico.value == "" ) { document.fhlv1.h_nai.disabled = false; document.fhlv1.h_nai.focus(); document.forms.fhlv1.h_nai.select(); }
        if( document.fhlv1.h_ico.value == 0 ) { document.fhlv1.h_nai.disabled = false; document.fhlv1.h_nai.focus(); document.forms.fhlv1.h_nai.select(); }
              }
                }



function NaiEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhlv1.h_nai.value != '' )
        {
        myIcoElement.style.display='';
        nulujIco();
        volajIco();
        }   
        if( document.fhlv1.h_nai.value != "" && document.fhlv1.h_ico.value > 0 )
            { document.fhlv1.h_ico.focus(); document.forms.fhlv1.h_ico.select(); }

        if( document.fhlv1.h_nai.value == "" ) { document.fhlv1.h_ico.focus(); document.forms.fhlv1.h_ico.select();}
              }
                }


//co urobi po potvrdeni ok z tabulky ico
function vykonajIco(ico,nazov,mesto,ucb,num,tel)
                {
        document.forms.fhlv1.h_ico.value = ico;
        document.forms.fhlv1.h_nai.value = nazov;
        myIcoElement.style.display='none';
        document.forms.fhlv1.h_kto.focus();
        document.forms.fhlv1.h_kto.select();
                }

function nulujIco()
                {

                }



function KtoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_txp.focus();
              }
                }


function TxpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_poz.focus();
        document.forms.fhlv1.h_poz.select();
              }
                }


function TxzEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_poz.focus();
              }
                }


function PozEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;
    if ( document.fhlv1.err_dat.value == '1' ) okvstup=0;
    if ( document.fhlv1.h_dat.value == '' ) okvstup=0;

    if ( okvstup == 0 && document.fhlv1.h_dat.value == '' ) { document.fhlv1.h_dat.focus(); return (false); }
    if ( okvstup == 0 && document.fhlv1.err_dat.value == '1' ) { document.fhlv1.h_dat.focus(); return (false); }
    if ( okvstup == 1 ) { document.forms.fhlv1.submit(); return (true); }
              }
                }


//script pre copern vymazanie 6 666666666666666 
<?php
if ( $copern == 6 ) 
{?>
    function ObnovUI()
    {

    }
    function VyberVstup()
    {

    }

<?php
//koniec skriptu 6 666666666
}?>


//script pre copern  7 77777777777777777 vstup sluzby
<?php
if ( $copern == 7 OR $copern == 87 ) 
{?>


//co urobi po potvrdeni ok z tabulky Priku
function vykonajPriku(ico,nai,mes,vsy,uceb,uce,uc1,zos,nm1,fak,ksy,ssy,xiban,xbic)
                {
        document.forms.forms1.h_ico.value = ico;
        document.forms.forms1.h_uceb.value = uc1;
        document.forms.forms1.h_numb.value = nm1;
        document.forms.forms1.h_vsy.value = fak;
        document.forms.forms1.h_hodp.value = zos;
        document.forms.forms1.h_ksy.value = ksy;
        document.forms.forms1.h_ssy.value = ssy;
        document.forms.forms1.h_uce.value = uce;
        document.forms.forms1.h_iban.value = xiban;
        document.forms.forms1.h_pbic.value = xbic;
        myPrikuelement.style.display='none';
        document.forms.forms1.h_hodp.focus();
        document.forms.forms1.h_hodp.select();
                }

function vykonajPriku2(ico,nai,mes,vsy,uceb,uce,uc1,zos,nm1,fak,ksy,ssy,xiban,xbic)
                {
        document.forms.forms1.h_uceb.value = uc1;
        document.forms.forms1.h_numb.value = nm1;
        document.forms.forms1.h_iban.value = xiban;
        document.forms.forms1.h_pbic.value = xbic;
        myPrikuelement.style.display='none';
        document.forms.forms1.h_hodp.focus();
        document.forms.forms1.h_hodp.select();
                }

function volatPriku1()
                    {
    if ( document.forms1.h_vsy.value != '' || document.forms1.h_uceb.value != '' ) { volajPriku(1); }
                    }

function volatPriku2()
                    {
             volajPriku(2);
                    }

function volatPriku3()
                    {
             volajPriku(3); 
                    }

function Len1Priku()
                    {
        myPrikuelement.style.display='none';
        document.forms.forms1.h_hodp.focus();
        document.forms.forms1.h_hodp.select();
                    }

function Len0Priku()
                    {
        myPrikuelement.style.display='none';
        document.forms.forms1.h_uceb.focus();
        document.forms.forms1.h_uceb.select();
                    }

//posuny Enter[[[[[[[[[[[

function IbanEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.forms1.h_pbic.focus();
              }
                }

function PbicEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.forms1.h_uceb.focus();
              }
                }

function UcebEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.forms1.h_numb.focus();
              }
                }

function NumbEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.forms1.h_hodp.focus();
              }
                }

function HodpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.forms1.h_vsy.focus();
              }
                }

function VsyEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.forms1.h_ksy.focus();
              }
                }

function KsyEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.forms1.h_ssy.focus();
              }
                }

function SsyEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.forms1.h_twib.focus();
              }
                }

function TwibEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;
    if ( document.forms1.err_numb.value == '1' ) okvstup=0;
    if ( document.forms1.h_hodp.value == '' ) okvstup=0;

    if ( okvstup == 0 && document.forms1.err_numb.value == '1' ) { document.forms1.h_numb.focus(); return (false); }
    if ( okvstup == 0 && document.forms1.h_hodp.value == '' ) { document.forms1.h_hodp.focus(); return (false); }

    if ( okvstup == 1 ) { document.forms.forms1.submit(); return (true); }
              }
                }


function nulujPol()
                {

                }


    function ObnovUI()
    {

    }

    function VyberVstup()
    {
    <?php if( $mazanie == 1 ) { 
    echo "document.forms1.h_uceb.value = '$z_uceb';\r";
    echo "document.forms1.h_numb.value = '$z_numb';\r";
    echo "document.forms1.h_hodp.value = '$z_hodp';\r";
    echo "document.forms1.h_vsy.value = '$z_vsy';\r";
    echo "document.forms1.h_ksy.value = '$z_ksy';\r";
    echo "document.forms1.h_ssy.value = '$z_ssy';\r";
    echo "document.forms1.h_twib.value = '$z_twib';\r";
    echo "document.forms1.h_iban.value = '$z_iban';\r";
    echo "document.forms1.h_pbic.value = '$z_pbic';\r";
                              } ?>
    document.forms.forms1.h_uceb.focus();
    document.forms1.uloz.disabled = true;
    }


    function Zapis_COOK()
    {

    return (true);
    }

    function Povol_uloz()
    {
    var okvstup=1;

    if ( document.forms1.err_hodp.value == '1' ) okvstup=0;

    if ( document.forms1.h_uceb.value == '' ) okvstup=0;
    if ( document.forms1.h_numb.value == '' ) okvstup=0;
    if ( document.forms1.h_iban.value != '' ) okvstup=1;
    if ( document.forms1.h_hodp.value == '' ) okvstup=0;

    if ( okvstup == 1 ) { document.forms1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.forms1.uloz.disabled = true; Fx.style.display=""; return (false) ; }

    }

    function ZhasniSP()
    {
    Fx.style.display="none";
    Ul.style.display="none";
    Zm.style.display="none";
    NiejeUce.style.display="none";
    NiejeIcp.style.display="none";
    NiejeStr.style.display="none";
    NiejeZak.style.display="none";
    NiejeRdp.style.display="none";
    Uce.style.display="none";
    Fak.style.display="none";
    Ico.style.display="none";
    Str.style.display="none";
    Zak.style.display="none";
    Des.style.display="none";
    Rdp.style.display="none";
    }


<?php
//koniec skriptu 7 77777777
}?>


//script pre copern 5555555555555[[[[[[[[[[88888888888888888
<?php
if ( $copern == 5 OR $copern == 8 ) 
{?>
    function ObnovUI()
    {
<?php if( $vybr == 'ANO' )
{
  if( $cislo_uce != '' ) { echo "document.fhlv1.h_uce.value = '$cislo_uce';"; }
 echo "document.fhlv1.h_dok.value = '$cislo_dok';";
 echo "document.fhlv1.h_dat.value = '$cislo_datsk';";
 echo "document.fhlv1.h_unk.value = '$cislo_unk';";
 echo "document.fhlv1.h_kto.value = '$cislo_kto';";
 echo "document.fhlv1.h_poz.value = '$cislo_poz';";
 echo "document.fhlv1.h_txp.value = '$cislo_txp';";
 echo "document.fhlv1.h_ico.value = '$cislo_ico';";
 echo "document.fhlv1.h_nai.value = '$vybr_nai';";
}
?>
    }

    function Hlat()
    {
    document.fhlv1.hlat.value = 'ANO';
    }

    function NeHlat()
    {
    document.fhlv1.hlat.value = 'NIE';
    }


    function Rozb1()
    {
    document.fhlv1.rozb1.value = 'VELKE';
    }

    function NeRozb1()
    {
    document.fhlv1.rozb1.value = 'MALE';
    }

    function Rozb2()
    {
    document.fhlv1.rozb2.value = 'VELKE';
    }

    function NeRozb2()
    {
    document.fhlv1.rozb2.value = 'MALE';
    }

    function Sluz1()
    {
    document.fhlv1.sluz1.value = 'VELKE';
    }

    function NeSluz1()
    {
    document.fhlv1.sluz1.value = 'MALE';
    }


    function Povol_uloz()
    {
    var okvstup=1;

    //if ( document.fhlv1.h_dat.value == '' ) okvstup=0;
    if ( document.fhlv1.h_ico.value == '' ) okvstup=0;
    if ( document.fhlv1.err_dat.value == '1' ) okvstup=0;
    if ( document.fhlv1.err_ico.value == '1' ) okvstup=0;

    if ( okvstup == 1 )
       { 
         document.fhlv1.uloh.disabled = false;
         Fxh.style.display="none"; return (true);
       }
       else { 
            document.fhlv1.uloh.disabled = true;
            Fxh.style.display="";
            if ( okvstup == 0 && document.fhlv1.h_kto.value == '' ){ document.fhlv1.h_kto.focus();}
            return (false) ;
            }

    }

    function VyberVstup()
    {

<?php if( $hlat != 'ANO' AND $vybr != 'ANO' AND $rozb1 != 'VELKE' AND $rozb2 != 'VELKE' AND $rozb1 != 'MALE' AND $rozb2 != 'MALE' )
{
 echo "document.forms.fhlv1.h_uce.focus();";
}
?>

<?php if( $vybr == 'ANO' )
{
?>
  document.fhlv1.h_uce.focus();
<?php
}
?>

<?php if( $rozb1 == 'VELKE' )
{
?>
  document.fhlv1.h_txp.focus();
<?php
}
?>

<?php if( $rozb2 == 'VELKE' )
{
?>
  document.fhlv1.h_txz.focus();
<?php
}
?>

<?php if( $rozb1 == 'MALE' )
{
?>
  document.fhlv1.h_zk1.focus();
<?php
}
?>

<?php if( $rozb2 == 'MALE' )
{
?>
  document.fhlv1.h_poz.focus();
<?php
}
?>

    document.fhlv1.uloh.disabled = true;
    <?php  if( $hladaj_uce != '' ) { ?> document.fhlv1.h_uce.value='<?php echo $hladaj_uce;?>'; <?php } ?>
    document.fhlv1.nwwdok.disabled = true;
   }


    function Zapis_COOK()
    {

    return (true);
    }

    function Obnov_vstup()
    {

    return (true);
    }


<?php
}?>
//koniec scriptu copern 5,8

//[[[[[[[[[[[[
//Kontrola datumu Sk
function kontrola_datum(vstup, Oznam, x1, errflag)
		{
if( document.fhlv1.h_dat.value != '' )    {
		var text
		var index
		var tecka
		var den
		var mesic
		var rok
		var ch
                var err

		text=""
                err=0 
		
		den=""
		mesic=""
		rok=""
		tecka=0
		
		for (index = 0; index < vstup.value.length; index++) 
			{
      ch = vstup.value.charAt(index);
			if (ch != "0" && ch != "1" && ch != "2" && ch != "3" && ch != "4" && ch != "5" && ch != "6" && ch != "7" && ch != "8" && ch != "9" && ch != ".") 
				{text="Pole Datum zadavajte vo formate DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok).\r"; err=3 }
			if ((ch == "0" || ch == "1" || ch == "2" || ch == "3" || ch == "4" || ch == "5" || ch == "6" || ch == "7" || ch == "8" || ch == "9") && (text ==""))
				{
				if (tecka == 0)
					{den=den + ch}
				if (tecka == 1)
					{mesic=mesic + ch}
				if (tecka == 2)
					{rok=rok + ch}
				}
			if (ch == "." && text == "")
				{
				if (tecka == 1)
					{tecka=2}
				if (tecka == 0)
					{tecka=1}
				
				}	
			}
			
		if (tecka == 2 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>}
		if (tecka == 1 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>; err= 0}
		if (tecka == 1 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; err= 0}
		if (tecka == 0 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; rok=<?php echo $kli_vrok; ?>; err= 0}
		if ((den<1 || den >31) && (text == ""))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 31.\r"; err=1 }
		if ((mesic<1 || mesic>12) && (text == ""))
			{text=text + "Pocet mesiacov nemoze byt mensi ako 1 a vacsi ako 12.\r"; err=2 }
		if (rok<1965 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt mensi ako 1965.\r"; err=3 }
		if (rok>2029 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt v‰ËöÌ ako 2029.\r"; err=3 }
		if (tecka > 2)
			{text=text+ "Datum zadavajte vo formatu DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok)\r"; err=3 }

		if (mesic == 2)
			{
			if (rok != "")
				{
				if (rok % 4 == 0)
					{
					if (den>29)
						{text=text + "Vo februari roku " + rok + " je maximalne 29 dni.\r"; err=1 }
					}
				else
					{
					if (den>28)
						{text=text + "Vo februari roku " + rok + " je maximalne 28 dni.\r"; err=1 }
					}
				}
			else
				{
				if (den>29)
					{text=text + "Vo februari roku je maximalne 29 dni.\r"}
				}
			}

		if ((mesic == 4 || mesic == 6 || mesic == 9 || mesic == 11) && (den>30))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 30.\r"}
		



		if (text!="" && err == 1)
			{
                        Oznam.style.display="";
                        x1.value = den + "??"  + "." + mesic+ "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 2)
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic + "??" + "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 3)
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic +  "." + rok + "??";
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (err == 0)
			{
                        Oznam.style.display="none";
                        x1.value = den + "." + mesic +  "." + rok ;
                        errflag.value = "0";
			return true;
			}
                                            }
		}
//koniec kontrola datumu

// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam,errflag) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;

         if (b == "") { err=0 }
         if (Math.floor(b)==b && b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9]/g) != -1) { err=1 }
         if (Math.floor(b)!=b && b != "") { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         <?php
         if ( $copern == 5 OR $copern == 8 ) 
         {?>
         errflag.value = "0";
         <?php
         }?>
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         <?php
         if ( $copern == 88 ) 
         {?>
         document.formv1.uloz.disabled = true;
         errflag.value = "1";
         <?php
         }?>
         <?php
         if ( $copern == 5 OR $copern == 8 ) 
         {?>
         document.fhlv1.uloh.disabled = true;
         errflag.value = "1";
         <?php
         }?>
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


// Kontrola des.cisla celeho v rozsahu x az y  
      function cele(x1,x,y,Oznam,des,errflag) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;
       var c;
       var d;
       var cele;
       var pocdes;
       cele=0;
       pocdes=0;
       c=b.toString();
       d=c.split('.');
       if ( isNaN(d[1]) ) { cele=1; }
       if ( cele == 0 ) { pocdes=d[1].length; }

         if (b == "") { err=0 }
         if (b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9.-]/g) != -1) { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }
         if (cele == 0 && pocdes > des ) { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         <?php
         if ( $copern == 5 OR $copern == 8 ) 
         {?>
         errflag.value = "0";
         <?php
         }?>
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         <?php
         if ( $copern == 88 ) 
         {?>
         document.formv1.uloz.disabled = true;
         errflag.value = "1";
         <?php
         }?>
         <?php
         if ( $copern == 5 OR $copern == 8 ) 
         {?>
         document.fhlv1.uloh.disabled = true;
         errflag.value = "1";
         <?php
         }?>
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola datumu
    function KontrolaDatum(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }


//funkcia na zobrazenie popisu 
    function UkazSkryj (text)
    {
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;

    }

  function ukazrobot()
  { 
  myRobot = document.getElementById("robotokno");
  myRobotmenu = document.getElementById("robotmenu");
  myRobothlas = document.getElementById("robothlas");
  myRobot.style.top = toprobot;
  myRobot.style.left = leftrobot;
  myRobotmenu.style.top = toprobotmenu;
  myRobotmenu.style.left = leftrobotmenu;
  myRobothlas.style.top = toprobothlas;
  myRobothlas.style.left = leftrobothlas;
  <?php if( $kli_vduj == 9 AND $vyb_robot == 1 ) { echo "robotokno.style.display=''; robotmenu.style.display='none';"; } ?>
  }

  function zhasnirobot()
  { 
  robotokno.style.display='none';
  robotmenu.style.display='none';
  robothlas.style.display='none';
  }

  function zobraz_robotmenu()
  { 
  myRobotmenu.style.width = widthrobotmenu;
  myRobotmenu.innerHTML = htmlmenu;
  robotmenu.style.display='';
  }

  function zhasni_menurobot()
  { 
  robotmenu.style.display='none';
  robotmenu.style.display='none';
  robothlas.style.display='none';
  }

    var toprobot = 280;
    var leftrobot = 40;
    var toprobotmenu = 260;
    var leftrobotmenu = 70;
    var widthrobotmenu = 400;
    var toprobothlas = 300;
    var leftrobothlas = 60;

    var htmlmenu = "<table  class='ponuka' width='100%'><tr><td width='90%'>Menu EkoRobot</td>";
    htmlmenu += "<td width='10%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;'";
    htmlmenu += "onClick='zhasni_menurobot();' title='Zhasni menu' ></td></tr>";  

<?php if( $drupoh == 1 AND $copern == 5 ) { ?>

    var toprobotmenu = 127;

<?php                    } ?>

    htmlmenu += "</table>";  
    
</script>

<?php if( $kli_vduj == 9 AND $vyb_robot == 1 ) 
{ echo "<script type='text/javascript' src='robot_ju.js'></script>"; } ?>

<?php if( $drupoh == 1 ) 
{ echo "<script type='text/javascript' src='daj_priku_iban.js'></script>"; } ?>

<?php if( $drupoh == 1 AND $copern == 7 ) 
{ echo "<script type='text/javascript' src='uloz_mena.js'></script>"; } ?>

<script type='text/javascript'>
//cudzia mena


    function nastavKURZ()
    {
       var b;
       b=document.fmena1.h_menax.value;
       var c;
       var d;
       var mena;
       var pomr;
       var kurz;
       c=b.toString();
       d=c.split(',');
       mena=d[0];
       pomr=d[1];
       kurz=d[2];

    document.fmena1.h_mena.value = mena;
    document.fmena1.h_pomr.value = pomr;
    document.fmena1.h_kurz.value = kurz;
    }

    function vyberMENU()
    { 
    myMENA = document.getElementById("myMENAelement");

    var htmlmena = "<table  class='ponuka' width='100%'><tr><FORM name='fmena1' class='obyc' method='post' action='#' >";

    htmlmena += "<td width='15%'>Cudzia mena:";
<?php

$sql = mysql_query("SELECT dat FROM F$kli_vxcf"."_uctpriku WHERE dok = $cislo_dok");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datum=$riadok->dat;
  }

//echo $datum;

$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_uctkurzy WHERE datk = '$datum' ORDER BY mena");
$i=0;
?>
    htmlmena += "<select class='hvstup' size='1' name='h_menax' id='h_menax' onchange=\"nastavKURZ();\" > ";
<?php while($zaznam=mysql_fetch_array($sqls)):?>
    htmlmena += "<option value=\"<?php echo $zaznam['mena'];?>,<?php echo $zaznam['pomr'];?>,<?php echo $zaznam['kurz'];?>\" >";
    htmlmena += "<?php echo $zaznam['mena'];?> <?php echo $zaznam['kurz'];?></option>";
<?php if( $i == 0 ) { $mena=$zaznam['mena']; $pomr=$zaznam['pomr']; $kurz=$zaznam['kurz']; } $i=$i+1; endwhile;?>
    htmlmena += "</select>";
    htmlmena += "<INPUT type='hidden' name='h_mena' value=\"<?php echo $mena;?>\">";
    htmlmena += "</td>";

    htmlmena += "<td width='12%'>Pomer:";
    htmlmena += "<input type='text' name='h_pomr' id='h_pomr' size='5' value=\"<?php echo $pomr;?>\" ";
    htmlmena += "onchange='return intg(this,1,1000,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='12%'>Kurz:";
    htmlmena += "<input type='text' name='h_kurz' id='h_kurz' size='5' onchange='return cele(this,0,99999999,Desc,4,document.formv1.err_kurz)' ";
    htmlmena += "onkeyup=\"KontrolaDcisla(this, Desc)\" value=\"<?php echo $kurz;?>\" /> ";
    htmlmena += "<INPUT type='hidden' name='err_kurz' value='0'>";
    htmlmena += "</td>";

    htmlmena += "<td width='12%'>";
    htmlmena += "<img src='../obr/ok.png' border='1' onclick='ulozMENU(1);'  title='Uloûiù' >";
    htmlmena += "</td>";


    htmlmena += "<td width='60%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;'";
    htmlmena += "onClick='zhasniMENU();' title='Zhasni v˝ber meny' ></td></FORM></tr>"; 
    htmlmena += "</table>";
    myMENA.innerHTML = htmlmena;
    myMENAelement.style.display='';
    }

    function zhasniMENU()
    { 
    myMENAelement.style.display='none';
    }

    function uhradMzdy(skupina)
    { 
    var vypl=skupina;
    window.open('../mzdy/priku.php?copern=1&drupoh=1&page=1&wyplmiesto='+ vypl + '&cislo_dok=<?php echo $cislo_dok;?>&hladaj_uce=<?php echo $hladaj_uce;?>', '_self' );
    }

</script>
<script type='text/javascript'>

function newIco()
                {

window.open('../cis/cico.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=5&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

</script>
</HEAD>

<BODY class="white" id="white" 
onload="ObnovUI(); VyberVstup(); <?php if( $copern == 555 ) { echo " ukazrobot(); "; } ?>" >

<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 400; top: 150; left: 90; width:200; height:100;">
zobrazene menu
</div>

<div id="robothlas" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 150; left: 90; width:200; height:100;">
zobrazeny vysledok
</div>

<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 200; left: 40; ">
<img border=0 src='../obr/robot/robot3.jpg' style='width:40; height:80;' onClick="zobraz_robotmenu();"
 title='Dobr˝ deÚ , ja som V·ö EkoRobot , ak m·te ot·zku alebo nejakÈ ûelanie kliknite na mÚa prosÌm 1x myöou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 title='Zhasni EkoRobota' >
</div>

<table class="h2" width="100%" >
<tr>
<?php if( $drupoh == 1 ) echo "<td>EuroSecom  -  PrÌkaz na ˙hradu"; ?>
 <img src='../obr/info.png' width=12 height=12 border=0 title="EnterNext = v tomto formul·ry po zadanÌ hodnoty poloûky a stlaËenÌ Enter program prejde na vstup Ôalöej poloûky">
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<div id="myUcmelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myUcdelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myFakelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myIcpelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myStrelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myZakelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myRdpelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>

<?php 
//hlavicka nova
//[[[[[[[5555555555[[[[[[[[[888888888888
if ( $copern == 5 OR $copern == 8 )
     {
?>
<span style="position: absolute; top: 150; left: 50%;"> 
<div id="myIcoElement"></div>
</span>
<table class="vstup" width="50%" height="130px" align="left">
<tr></tr><tr></tr>
<FORM name="fhlv1" class="obyc" method="post" action="vspr_u.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>
&drupoh=<?php echo $drupoh;?>&page=1
&cislo_dok=<?php echo $newdok;?>&hladaj_uce=<?php echo $hladaj_uce; ?>
<?php
if ( $copern == 5 )
     {
?>
&copern=68" >
<?php
     }
?>
<?php
if ( $copern == 8 )
     {
?>
&copern=78" >
<?php
     }
?>
<tr>
<td class="pvstup">&nbsp;
 <?php if( $drupoh == 1 ) echo "⁄Ëet:"; ?>
</td>

<?php
if( $drupoh == 1 )
{
$sqls = mysql_query("SELECT dban,nban,uceb FROM F$kli_vxcf"."_dban WHERE ( dban > 0 ) ORDER BY dban");
?>
<td class="fmenu">
<select class="hvstup" size="1" name="h_uce" id="h_uce" onmouseover="HlvOnClick();" 
 onKeyDown="return UceEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["dban"];?>" >
<?php 
$polmen = $zaznam["nban"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dban"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
<input class="hvstup" type="hidden" name="hladaj_uce" id="hladaj_uce" value="<?php echo $hladaj_uce;?>" />
</td>
<?php
}
?>
</tr>

<tr>
<td class="pvstup" width="15%" >&nbsp;»Ìslo dokladu:
</td>
<td class="hvstup" width="25%" >
<input class="hvstup" type="text" name="nwwdok" id="nwwdok" size="10" value="<?php echo $newdok;?>" onclick="HlvOnClick()" />
<input class="hvstup" type="hidden" name="newdok" id="newdok" value="<?php echo $newdok;?>" />
<input class="hvstup" type="hidden" name="h_dok" id="h_dok" value="<?php echo $newdok;?>" />
</td>
<td class="bmenu" width="10%" >
<?php
if ( $copern == 8 )
     {
?>
<a href="#" onClick="window.open('vspr_pdf.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_dok=<?php echo $riadok->dok;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=12 border=0 title="VytlaËiù doklad" >TlaËiù</a>

<a href="#" onClick="window.open('vspr_pdf.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_dok=<?php echo $riadok->dok;?>&ajtext=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=12 border=0 title="VytlaËiù doklad" ></a>

<?php
     }
?>
</td>
</tr>
<tr><td class="pvstup" >&nbsp;D·tum:</td>
<td class="hvstup">
<input class="hvstup" type="text" name="h_dat" id="h_dat" size="10" maxlength="10" value="<?php echo $h_dat;?>"
 onclick="HlvOnClick()" onkeyup="KontrolaDatum(this, Kx)"  onfocus="OnfocusDat()"
 onChange="return kontrola_datum(this, Kx, this, document.fhlv1.err_dat)" onKeyDown="return DatEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dat" value="0">
<input class="hvstup" type="hidden" name="h_dns" id="h_dns" value="" size="2" maxlength="3">
</td>
</tr>

<input class="hvstup" type="hidden" name="h_daz" id="h_daz" />
<input class="hvstup" type="hidden" name="h_das" id="h_das" />
<input class="hvstup" type="hidden" name="h_obj" id="h_obj" />

<tr><td class="pvstup" >&nbsp;UNIkÛd:</td>
<td class="hvstup" >

<input class="hvstup" type="text" name="h_unk" id="h_unk" size="20" maxlength="20" value="<?php echo $h_unk;?>" onclick="HlvOnClick()"
 onKeyDown="return UnkEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_unk" value="0">
</td>
</tr>

<tr></tr><tr></tr>
</table>
<table class="vstup" width="50%" height="130px" align="left">
<tr></tr><tr></tr>
<tr><td class="pvstup" width="15%" >&nbsp;<?php echo $Odberatel; ?> I»O:
<img src='../obr/ziarovka.png' border="1" onclick="newIco();" width="12" hight="12" title="Vloûiù novÈ I»O do datab·zy" >
</td>
<td class="hvstup" width="25%" >
<?php if( $drupoh == 4 ) { $h_ico=$fir_fico; } ?>
<?php if( $drupoh == 5 ) { $h_ico=$fir_fico; } ?>
<input class="hvstup" type="text" name="h_ico" id="h_ico" size="12" maxlength="8" value="<?php echo $h_ico;?>"
 onclick="Fxh.style.display='none'; document.fhlv1.h_nai.disabled = false; myIcoElement.style.display='none'; nulujIco();"
 onchange="return intg(this,1,99999999,Ix,document.fhlv1.err_ico)" onkeyup="KontrolaCisla(this, Ix)" 
 onKeyDown="return IcoEnter(event.which)" />

<img src='../obr/hladaj.png' border="1" onclick="myIcoElement.style.display=''; volajIco();" width="12" hight="12" title="Hæadaj zadanÈ I»O alebo n·zov firmy" >

<input class="hvstup" type="hidden" name="err_ico" value="0">

</td>
<td class="pvstup" width="10%" ></td>
</tr>
<tr><td class="pvstup" >&nbsp;<?php echo $Odberatel; ?> N·zov:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_nai" id="h_nai" size="30" value="<?php echo $h_nai;?>"
 onKeyDown="return NaiEnter(event.which)" 
 onclick="Fxh.style.display='none'; myIcoElement.style.display='none'; nulujIco();"/>
</td>
</tr>

<tr>
<td class="pvstup" >&nbsp;
<?php
if( $drupoh == 1 ) { echo "B⁄:"; }
?>
</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_kto" id="h_kto" size="45" maxlength="40" value="<?php echo $h_kto;?>" onclick="HlvOnClick()"
 onKeyDown="return KtoEnter(event.which)" />
</td>
</tr>

<tr></tr><tr></tr>
</table>

<br clear=left>
<tr>
<span id="Fxh" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte spr·vne vyplniù vöetky poloûky vstupu</span>
<span id="Ix" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 I»O dod·vateæa musÌ byù celÈ ËÌslo v rozsahu 1 aû 9999999999</span>
<span id="Jx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo dokladu musÌ byù celÈ ËÌslo v rozsahu 1 aû 9999999999</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo musÌ byù desatinnÈ ËÌslo na dve desatinnÈ miesta</span>
<span id="Kx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Uph" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Z·hlavie DOK=<?php echo $cislo_dok;?> upravenÈ</span>
<div id="Okno"></div>
</tr>

<table class="vstup" width="100%">
<tr>
<td class="pvstup"  width="10%" >&nbsp;⁄Ëel:</td>
<td class="hvstup"  width="55%" >
<input class="hvstup" type="text" name="h_txp" id="h_txp" size="80" onclick="HlvOnClick()"
 onKeyDown="return TxpEnter(event.which)"
<td class="pvstup" width="35%" >&nbsp;</td>
</tr>
</table>


<table class="vstup" width="100%">
<tr>
<td class="pvstup" width="15%" >&nbsp;Pozn·mka:</td>
<td class="hvstup" width="55%" >
<input class="hvstup" type="text" name="h_poz" id="h_poz" size="80" maxlength="80" value="<?php echo $h_poz;?>" onclick="HlvOnClick()"
 onKeyDown="return PozEnter(event.which)" /></td>
<td class="pvstup" width="25%" >&nbsp;(Nebude vytlaËen· na doklade)</td><td class="pvstup" >&nbsp;</td>
</tr>
<tr>
<td>
<input type="submit" id="uloh" name="uloh" value="Uloûiù"  
 onmouseover="UkazSkryj('Uloûiù ˙pravy z·hlavia dokladu, n·vrat do zoznamu poloûiek'); return Povol_uloz();"
 onmouseout="Okno.style.display='none';" onclick="Zapis_COOK();">
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
</td>
</FORM>
<FORM name="formh4" class="obyc" method="post" action="vstpru.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=1" >
<td class="obyc" ><INPUT type="submit" id="stornou" name="stornou" value="Zoznam" align="right"
 onmouseover="UkazSkryj('Neuloûiù ˙pravy z·hlavia dokladu , n·vrat do zoznamu dokladov')" onmouseout="Okno.style.display='none';"></td>
</FORM>
</table>

<?php
// toto je koniec hlavicka nova a uprava copern=5,8
     }
?>

<?php 
//hlavicka vymazanie a vstup poloziek
//[[[[[[[666666666666 777777777777
if ( $copern == 6 OR $copern == 7  )
     {
$sqltt = "SELECT * FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_$tabl.dok = $cislo_dok ".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$j = 0;
?>
<table class="vstup" width="50%" height="120px" align="left">
<tr></tr><tr></tr>
<?php
   while ($j <= 0 )
   {
  if (@$zaznam=mysql_data_seek($sql,$j))
  {
$riadok=mysql_fetch_object($sql);
$dat_sk=SkDatum($riadok->dat);
$celsuma=$riadok->hodm;
$celsump=$riadok->hodp;
?>

<tr>
<td class="pvstup">&nbsp;
<?php if( $drupoh == 1 ) echo "⁄Ëet:"; ?></td>
<td class="fmenu"><?php echo $riadok->uce; ?> - MENA <?php echo $riadok->mena; ?></td>
<td class="bmenu" width="10%" ><a href="#" onClick="vyberMENU();">
<img src='../obr/banky/dollar2.jpg' width=20 height=12 border=0 title='Vybraù menu' >Mena</a></td>
</tr>
<tr>
<td class="pvstup" width="15%" >&nbsp;»Ìslo dokladu:
</td>
<td class="hvstup" width="25%" ><?php echo $riadok->dok; ?></td>
<td class="bmenu">
<?php
if ( $copern != 6 AND $copern != 87 )
     {
?>
<a href="#" onClick="window.open('vspr_pdf.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_dok=<?php echo $riadok->dok;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=12 border=0 title="VytlaËiù doklad" >TlaËiù</a>

<a href="#" onClick="window.open('vspr_pdf.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_dok=<?php echo $riadok->dok;?>&ajtext=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=12 border=0 title="VytlaËiù doklad aj s doplÚuj˙cim textom" ></a>
<?php
     }
?>
</td>
</tr>
<tr>
<td class="pvstup" >&nbsp;D·tum:</td>
<td class="hvstup"><?php echo $dat_sk; ?></td>
<td class="bmenu">
<?php
if ( $copern != 6 AND $copern != 87 )
     {
?>
<a href="#" onClick="window.open('vspriban_pdf.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_dok=<?php echo $riadok->dok;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=12 border=0 title="VytlaËiù doklad s IBAN" >TlaËiù IBAN</a>

<?php
     }
?>
</td>
</tr>
<tr>
<td class="pvstup" >&nbsp;UNIkÛd:</td>
<td class="hvstup"><?php echo $riadok->unk; ?></td>
<?php
if( $copern == 7 OR $copern == 17 )
{
?>
<td>
<a href='vspr_u.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&copern=8&drupoh=<?php echo $drupoh;?>&cislo_dok=<?php echo $riadok->dok;?>'>
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="⁄prava z·hlavia dokladu" >Z·hlavie</a>
</td>
<?php
}
?>
</tr>
<tr></tr><tr></tr>
</table>

<table class="vstup" width="50%" height="120px" align="left">
<tr></tr><tr></tr>

<tr>
<td class="pvstup">&nbsp;<?php echo $Odberatel; ?> I»O:</td>
<td class="fmenu"><?php echo $riadok->ico; ?></td>
<td class="bmenu" width="10%" >
<?php
if ( $copern == 7 AND $agrostav != 1 )
     {
$wyplmiesto=1*$riadok->unk;
?>
<a href="#" onClick="uhradMzdy(<?php echo $wyplmiesto;?>);">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title="Uhradiù mzdy" ></a>
<a href="#" onClick="window.open('../mzdy/priku.php?copern=2&drupoh=1&page=1&cislo_dok=<?php echo $riadok->dok;?>&hladaj_uce=<?php echo $riadok->uce;?>', '_self' )">
<img src='../obr/orig.png' width=15 height=15 border=0 title="Uhradiù odvody do fondov a daÚ z prÌjmu" ></a>
<a href="#" onClick="window.open('../mzdy/priku.php?copern=3&drupoh=1&page=1&cislo_dok=<?php echo $riadok->dok;?>&hladaj_uce=<?php echo $riadok->uce;?>', '_self' )">
<img src='../obr/ziarovka.png' width=15 height=15 border=0 title="Uhradiù DDP" ></a>
<a href="#" onClick="window.open('../mzdy/priku.php?copern=4&drupoh=1&page=1&cislo_dok=<?php echo $riadok->dok;?>&hladaj_uce=<?php echo $riadok->uce;?>', '_self' )">
<img src='../obr/import.png' width=15 height=15 border=0 title="Uhradiù Odbory" ></a>
<?php if( $wedgb == 1 ) { ?>
<a href="#" onClick="window.open('../mzdy/priku.php?copern=5&drupoh=1&page=1&cislo_dok=<?php echo $riadok->dok;?>&hladaj_uce=<?php echo $riadok->uce;?>', '_self' )">
<img src='../obr/export.png' width=15 height=15 border=0 title="Uhradiù Exek˙cie" ></a>
<?php                   } ?>
<?php
     }
?>
<?php
if ( $copern == 7 AND $agrostav == 1 )
     {
?>
<a href="#" onClick="window.open('../mzdy/priku.php?copern=1&drupoh=1&page=1&cislo_dok=<?php echo $riadok->dok;?>&hladaj_uce=<?php echo $riadok->uce;?>', '_self' )">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title="Uhradiù mzdy VUB 0200" ></a>
<a href="#" onClick="window.open('../mzdy/priku.php?copern=1&drupoh=2&page=1&cislo_dok=<?php echo $riadok->dok;?>&hladaj_uce=<?php echo $riadok->uce;?>', '_self' )">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title="Uhradiù mzdy SLSP 0900" ></a>
<a href="#" onClick="window.open('../mzdy/priku.php?copern=2&drupoh=1&page=1&cislo_dok=<?php echo $riadok->dok;?>&hladaj_uce=<?php echo $riadok->uce;?>', '_self' )">
<img src='../obr/orig.png' width=15 height=15 border=0 title="Uhradiù odvody do fondov a daÚ z prÌjmu" ></a>
<a href="#" onClick="window.open('../mzdy/priku.php?copern=3&drupoh=1&page=1&cislo_dok=<?php echo $riadok->dok;?>&hladaj_uce=<?php echo $riadok->uce;?>', '_self' )">
<img src='../obr/ziarovka.png' width=15 height=15 border=0 title="Uhradiù DDP" ></a>
<?php
     }
?>
</td>
</tr>
<tr>
<td class="pvstup" width="15%" >&nbsp;<?php echo $Odberatel; ?> N·zov:</td>
<td class="hvstup" width="25%" ><?php echo $riadok->nai; ?></td>
<td class="bmenu" width="10%" >
<?php
if ( $copern == 7 AND $merkfood == 1 )
     {
?>
<a href="#" onClick="uhradMzdy(1);">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title="Uhradiù mzdy SKUPINA 1" ></a>
<a href="#" onClick="uhradMzdy(2);">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title="Uhradiù mzdy SKUPINA 2" ></a>
<a href="#" onClick="uhradMzdy(3);">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title="Uhradiù mzdy SKUPINA 3" ></a>
<?php
     }
?>
</td>
</tr>
<td class="pvstup" >&nbsp;&nbsp;B⁄:</td>
<td class="hvstup"><?php echo $riadok->kto; ?></td>
<td class="bmenu" width="10%" >
<?php
if ( $copern == 7 )
     {
?>
<a href="#" onClick="window.open('../ucto/saldo.php?copern=1&drupoh=1&page=1&sysx=UCT&typhtml=1&cinnost=7&uhrvseob=<?php echo $riadok->dok;?>', '_self' )">
<img src='../obr/vlozit.png' width=15 height=15 border=0 title="Vybraù zo saldokonta" ></a>
<?php
     }
?>
</td>
</tr>
<tr>
<td class="pvstup" >&nbsp;&nbsp;IBAN / BIC(swift):</td>
<?php
$sqlfir = "SELECT * FROM F$kli_vxcf"."_dban WHERE dban = $riadok->uce ";
$fir_vysledok = mysql_query($sqlfir);
if( $fir_vysledok ) 
{
$fir_riadok=mysql_fetch_object($fir_vysledok);

$priban = $fir_riadok->iban;
$prbic = $fir_riadok->twib;
}
?>
<td class="hvstup"><?php echo $priban; ?> / <?php echo $prbic; ?></td>
</tr>

<tr></tr>
</table>
<br clear=left>
<tr>
<div id="Okno"></div>
<div id="myMENAelement"></div>
</tr>

<?php
if( $riadok->zmen == 1 )
    {
//cudzia mena
?>
<table  class='ponuka' width='100%'>
<tr>
<td width="15%" >Cudzia mena: <?php echo $riadok->mena; ?></td>
<td width="12%" >Pomer: 1</td>
<td width="12%" >Kurz: <?php echo $riadok->kurz; ?></td>
<td width="72%" > </td>
</tr>
</table>
<?php
    }
?>

<table class="vstup" width="100%">
<tr>
<?php
$vypis_txp = ereg_replace("\n", "<br>", trim($riadok->txp));
$vypis_txp = ereg_replace(" ", "&nbsp;", trim($vypis_txp));
?>
<td class="pvstup" width="15%" >
<?php
if ( $drupoh == 1 )
  {
?>
<a href="#" onClick="window.open('vspr_exportxml.php?copern=1&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>
&h_uce=<?php echo $riadok->uce;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/export.png' width=15 height=15 border=0 title="Export nov˝ XML form·t pre vöetky banky od 1.2.2016 " ></a>

<?php
  }
?>

 ⁄Ëel:</td>
<td class="hvstup" width="75%" ><?php echo $vypis_txp; ?></td>

<td class="pvstup" align="right" width="10%" >
<?php
if ( $drupoh == 1 )
  {
?>
<a href="#" onClick="window.open('vspr_export.php?copern=1&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>
&h_uce=<?php echo $riadok->uce;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/banky/tatrabanka.jpg' width=15 height=15 border=0 title="Export ˙dajov do TATRABANKY Gemini" ></a>

<a href="#" onClick="window.open('vspr_export.php?copern=2&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>
&h_uce=<?php echo $riadok->uce;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/banky/vub.jpg' width=15 height=15 border=1 title="Export ˙dajov do VUB KPC" ></a>

<a href="#" onClick="window.open('vspr_export.php?copern=3&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>
&h_uce=<?php echo $riadok->uce;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/banky/vub.jpg' width=15 height=15 border=1 title="Export ˙dajov do VUB CDF" ></a>

<a href="#" onClick="window.open('vspr_export.php?copern=6&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>
&h_uce=<?php echo $riadok->uce;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/banky/slsp.jpg' width=15 height=15 border=1 title="Export ˙dajov do SLSP HBform·t" ></a>

<a href="#" onClick="window.open('vspr_export.php?copern=5&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>
&h_uce=<?php echo $riadok->uce;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/banky/dexia.jpg' width=15 height=15 border=1 title="Export ˙dajov do DEXIA ABO" ></a>

<a href="#" onClick="window.open('vspr_export.php?copern=7&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>
&h_uce=<?php echo $riadok->uce;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/banky/tatrabanka.jpg' width=15 height=15 border=0 title="Export ˙dajov do TATRABANKY CSV" ></a>
<?php
  }
?>
</td>
</tr>
</table>
<tr>
<span id="Uce" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo ˙Ëtu musÌ byù celÈ kladnÈ ËÌslo v rozsahu 0 aû 9999999</span>
<span id="Des" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù desatinnÈ ËÌslo v rozsahu 0.01 aû 99999999 max. 2 desatinnÈ miesta</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù desatinnÈ ËÌslo v rozsahu 0.01 aû 99999999 max. 2 desatinnÈ miesta</span>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ ËÌslo </span>
<span id="Fak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo fakt˙ry musÌ byù celÈ ËÌslo v rozsahu 1 aû 9999999999</span>
<span id="Ico" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 I»O musÌ byù celÈ ËÌslo v rozsahu 1 aû 9999999999</span>
<span id="Str" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo strediska musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99999</span>
<span id="Zak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo z·kazky musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99999999</span>
<span id="Rdp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Druh DPH musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte spr·vne vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka spr·vne uloûen·</span>
<span id="Zm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka CPL=<?php echo $h_cpl;?>  zmazan·</span>
<span id="Nen" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:lime; color:black;">
 Nenaöiel som v ËÌselnÌku , pre voæn˝ vstup zadajte UCM=0</span>
<span id="NiejeUce" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som ˙Ëet v ËÌselnÌku </span>
<span id="NiejeIcp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som I»O v ËÌselnÌku </span>
<span id="NiejeStr" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som stredisko v ËÌselnÌku </span>
<span id="NiejeZak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som z·kazku v ËÌselnÌku </span>
<span id="NiejeRdp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som druh v ËÌselnÌku </span>

</tr>
<div id="myDivElement"></div>
<?php
//VYPIS ROZUCTOVANIA A POLOZIEK DOKLADU 
if ( $copern == 6 OR $copern == 7 OR $copern == 17 )
                {

$fmenu="fmenu";
$pvstup="pvstup";
$hvstup="hvstup";
$cotoje="Poloûky dokladu";
$seldph="%DPH";
$UCM="UCM";
$UCD="UCD";
if ( $rozuct == 'ANO' )
{
$fmenu="fmenz";
$pvstup="pvstuz";
$hvstup="hvstuz";
$cotoje="Roz˙Ëtovanie dokladu";
$seldph="DRD";
$UCM="M·Daù";
$UCD="Dal";
}
?>
<table class="<?php echo $fmenu; ?>" width="100%" >
<tr>
<td class="<?php echo $pvstup ?>" width="4%">Poloûka
<td class="<?php echo $pvstup ?>" width="19%">IBAN prÌjemcu
<td class="<?php echo $pvstup ?>" width="5%">BIC prÌjemcu
<td class="<?php echo $pvstup ?>" width="19%">⁄Ëet prÌjemcu
<td class="<?php echo $pvstup ?>" width="6%" align="right" >NumKÛd
<td class="<?php echo $pvstup ?>" width="7%" align="right" >Suma
<td class="<?php echo $pvstup ?>" width="9%" align="right" >Variabiln˝
<td class="<?php echo $pvstup ?>" width="5%" align="right" >Konötantn˝
<td class="<?php echo $pvstup ?>" width="7%" align="right" >äpecifick˝

<td class="<?php echo $pvstup ?>" width="14%">DoplÚuj˙ci text

<td class="<?php echo $pvstup ?>" width="5%">Zmaû
</tr>

<?php
//VYPIS POLOZIEK DOKLADU ALEBO ROZUCTOVANIE

$sluztt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" WHERE F$kli_vxcf"."_$uctpol.dok = $cislo_dok ".
" ORDER BY cpl";

//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);
?>

<?php
//zaciatok vypisu
$i=0;
  while ($i <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$i))
{
$rsluz=mysql_fetch_object($sluz);

?>


<tr>
<td class="fmenu" ><?php echo $rsluz->cpl;?></td>
<td class="fmenu" align="left" ><?php echo $rsluz->iban;?></td>
<td class="fmenu" align="left" ><?php echo $rsluz->pbic;?></td>
<td class="fmenu" align="right" ><?php echo $rsluz->uceb;?></td>
<td class="fmenu" align="right" ><?php echo $rsluz->numb;?></td>
<td class="fmenu" align="right" ><?php echo $rsluz->hodm;?></td>
<td class="fmenu" align="right" ><?php echo $rsluz->vsy;?></td>
<td class="fmenu" align="right" ><?php echo $rsluz->ksy;?></td>
<td class="fmenu" align="right" ><?php echo $rsluz->ssy;?></td>
<td class="fmenu" ><?php echo $rsluz->twib;?></td>
<td class="fmenu" width="5%" >
<a href='vspr_u.php?copern=316&drupoh=<?php echo $drupoh;?>&z_hodm=<?php echo $rsluz->hodm;?>
&z_uceb=<?php echo $rsluz->uceb;?>&z_numb=<?php echo $rsluz->numb;?>&z_vsy=<?php echo $rsluz->vsy;?>
&z_ksy=<?php echo $rsluz->ksy;?>&z_ssy=<?php echo $rsluz->ssy;?>&z_twib=<?php echo $rsluz->twib;?>&z_pbic=<?php echo $rsluz->pbic;?>
&cislo_cpl=<?php echo $rsluz->cpl;?>&cislo_dok=<?php echo $rsluz->dok;?>&z_hodp=<?php echo $rsluz->hodp;?>&z_iban=<?php echo $rsluz->iban;?>&uprav=0'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazaù riadok" ></a>
</td>
</tr>

<?php
}

$i = $i + 1;
  }

                }
// KONIEC VYPISU POLOZIEK DOKLADU ALEBO ROZUCTOVANIE pre copern 6,7 6666666666666666  777777777777777
?>


<?php
// vstup poloziek sluzby 777777777777777
if ( $copern == 7 )
     {
?>
<tr>
<FORM name="forms1" class="obyc" method="post" action="vspr_u.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>
&copern=77&cislo_dok=<?php echo $cislo_dok;?>" >

<td class="hmenu"><input type="text" name="h_cpl" id="h_cpl" size="5"  disabled="disabled" /></td>

<td class="hmenu">
<input type="text" name="h_iban" id="h_iban" size="33"  onKeyDown="return IbanEnter(event.which)" 
 onclick="myPrikuelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" />

<td class="hmenu">
<input type="text" name="h_pbic" id="h_pbic" size="8"  onKeyDown="return PbicEnter(event.which)" 
 onclick="myPrikuelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" />  

<td class="hmenu">
<img src='../obr/hladaj.png' border="1" onclick="myPrikuelement.style.display=''; volatPriku1();" width="12" hight="12" title="Hæadaj v dod·vateæsk˝ch fakt˙rach" >

<input type="text" name="h_uceb" id="h_uceb" size="22"  onKeyDown="return UcebEnter(event.which)" 
 onclick="myPrikuelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" /> 

<img src='../obr/hladaj.png' border="1" onclick="myPrikuelement.style.display=''; volatPriku2();" width="12" hight="12" title="Hæadaj v ËÌselnÌku I»O" >

<img src='../obr/hladaj.png' border="1" onclick="myPrikuelement.style.display=''; volatPriku3();" width="12" hight="12" title="Hæadaj v predvolen˝ch prÌkazoch" >

<td class="hmenu" align="right" ><input type="text" name="h_numb" id="h_numb" size="5"
 onclick="myPrikuelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return NumbEnter(event.which)" 
 onchange="return intg(this,0,9999,Cele,document.forms1.err_numb)" 
 onkeyup="KontrolaCisla(this, Cele)"/>
<INPUT type="hidden" name="err_numb" value="0"> 

<td class="hmenu" align="right" ><input type="text" name="h_hodp" id="h_hodp" size="8" 
 onclick="myPrikuelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return HodpEnter(event.which)"
 onchange="return cele(this,0.01,99999999,Desc,2,document.forms1.err_hodp)" 
 onkeyup="KontrolaDcisla(this, Desc)"  />
<INPUT type="hidden" name="err_hodp" value="0"></td>

<td class="hmenu" align="right" ><input type="text" name="h_vsy" id="h_vsy" size="10"
 onclick="myPrikuelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return VsyEnter(event.which)" 
 onchange="return intg(this,0,9999999999,Cele,document.forms1.err_vsy)" 
 onkeyup="KontrolaCisla(this, Cele)"/>
<INPUT type="hidden" name="err_vsy" value="0"> 

<td class="hmenu" align="right" ><input type="text" name="h_ksy" id="h_ksy" size="4"
 onclick="myPrikuelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return KsyEnter(event.which)" 
 onchange="return intg(this,0,9999,Cele,document.forms1.err_ksy)" 
 onkeyup="KontrolaCisla(this, Cele)"/>
<INPUT type="hidden" name="err_ksy" value="0"> 

<td class="hmenu" align="right" ><input type="text" name="h_ssy" id="h_ssy" size="10"
 onclick="myPrikuelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return SsyEnter(event.which)" 
 onchange="return intg(this,0,9999999999,Cele,document.forms1.err_ssy)" 
 onkeyup="KontrolaCisla(this, Cele)"/>
<INPUT type="hidden" name="err_ssy" value="0"> 

<td class="hmenu"><input type="text" name="h_twib" id="h_twib" size="15" onKeyDown="return TwibEnter(event.which)"  /></td>


<td class="hmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" disabled="disabled" /></td>

<input class="hvstup" type="hidden" name="hladaj_uce" id="hladaj_uce" value="<?php echo $hladaj_uce;?>" />
<input class="hvstup" type="hidden" name="h_dok" id="h_dok" value="<?php echo $cislo_dok;?>" />
<input class="hvstup" type="hidden" name="h_uce" id="h_uce" value="0" />

<input class="hvstup" type="hidden" name="h_zmen" id="h_zmen" value="<?php echo $riadok->zmen;?>" />
<input class="hvstup" type="hidden" name="h_mena" id="h_mena" value="<?php echo $riadok->mena;?>" />
<input class="hvstup" type="hidden" name="h_pomr" id="h_pomr" value="1" />
<input class="hvstup" type="hidden" name="h_kurz" id="h_kurz" value="<?php echo $riadok->kurz;?>" />


<input class="hvstup" type="hidden" name="h_ico" id="h_ico" />

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù" onclick="Zapis_COOK();" 
 onmouseover="UkazSkryj('Uloûiù poloûku do dokladu')" onmouseout="Okno.style.display='none';" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</FORM>

<td class="<?php echo $pvstup;?>" ></td>
<FORM name="formh4" method="post" action="vstpru.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=1" >
<td class="<?php echo $pvstup;?>" >
<INPUT type="submit" id="stornou" name="stornou" value="Zoznam" align="right"
 onmouseover="UkazSkryj('N·vrat do zoznamu dokladov')" onmouseout="Okno.style.display='none';">
</td>

</FORM>

<td class="<?php echo $pvstup;?>" ></td>
<FORM name="forma4" method="post" action="vspr_u.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=5&drupoh=<?php echo $drupoh;?>&page=1" >
<td class="<?php echo $pvstup;?>" >
<INPUT type="submit" name="npol" id="npol" value="Doklad"
 onmouseover="UkazSkryj('Vytvoriù nov˝ doklad')" onmouseout="Okno.style.display='none';" >
</td>

</FORM>
</tr>

<?php
     }
//koniec vstupu poloziek sluzby 77777777777777777777
?>


<?php
// ZOBRAZ SUMARE PRE ROZUCTOVANIE
if ( $rozuct == 'ANO' )
     {

//pre banku
if ( $drupoh == 1 )
          {

?>
<tr></tr><tr></tr>
<tr>
<td class="hmenu" align="right" >&nbsp;</td>
<td class="hmenu" align="right" >&nbsp;</td>
<td class="hmenu" align="right" >&nbsp;</td>
<td class="hmenu" align="right" >&nbsp;</td>
<td class="hmenu" align="right" >&nbsp;</td>
<td class="hmenu" align="right" >&nbsp;</td>
<td class="hmenu" align="right" >Celkom suma:</td>
<td class="hmenu" align="right" ><?php echo $celsuma;?> <?php echo $riadok->mena;?></td>
</tr>
<?php
if( $riadok->zmen == 1 )
    {
//cudzia mena
?>
<tr>
<td class="hmenu" align="right" >&nbsp;</td>
<td class="hmenu" align="right" >&nbsp;</td>
<td class="hmenu" align="right" >&nbsp;</td>
<td class="hmenu" align="right" >&nbsp;</td>
<td class="hmenu" align="right" >&nbsp;</td>
<td class="hmenu" align="right" >&nbsp;</td>
<td class="hmenu" align="right" >Celkom suma:</td>
<td class="hmenu" align="right" ><?php echo $celsump;?> <?php echo $mena1;?></td>
</tr>
<?php
    }
?>

<tr></tr><tr></tr>

<?php
//koniec pre banku
          }
?>

</table>
<?php
// KONIEC ZOBRAZ SUMARE PRE ROZUCTOVANIE
     }
?>

<div id="myPrikuelement"></div>

<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:lime; color:black;">
 Nepozn·m poloûku CIS v ûiadnom sklade v celom ËÌselnÌku materi·lu , hæadajte podæa n·zvu</span>

<div id="jeUcm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeUcd" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeRdp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeIcp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeStr" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeZak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>


<table class="vstup" width="100%">
<tr>
<td class="pvstup" width="15%" >&nbsp;Pozn·mka:</td>
<td class="hvstup" width="55%" ><?php echo $riadok->poz; ?></td>
<td class="pvstup" width="25%" >&nbsp;(Nebude vytlaËen· na doklade)</td><td class="pvstup" width="5%" >&nbsp;</td>
</tr>
</table>

<?php 
//[[[[[[[[[[[[66666666666666666vymazanie
if ( $copern == 6 )
     {
?>
<table class="vstup" width="100%">
<FORM name="formv2" class="obyc" method="post" action="vstpru.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=16&
cislo_dok=<?php echo $riadok->dok;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="Vymazaù" 
 onmouseover="UkazSkryj('Vymazaù vybran˝ doklad')" onmouseout="Okno.style.display='none';" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="vstpru.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornom" name="stornom" value="Storno" 
 onmouseover="UkazSkryj('Nevymazaù vybran˝ doklad , n·vrat do zoznamu dokladov')" onmouseout="Okno.style.display='none';" ></td>
</tr>
</FORM>
</table>
<?php 
     }
?>

<?php
  }
$j = $j + 1;
   }
?>

<?php
// toto je koniec vymazanie faktury copern=6 a sluzby copern=7 
     }

$robot=1;
$cislista = include("uct_lista.php");
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
