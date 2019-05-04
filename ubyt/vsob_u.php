<HTML>
<?php
$sys = 'VYR';
$urov = 2000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {
//5=novy doklad zadavanie udajov po vyplneni ide na 68 ulozi a vrati sa do vstobj.php ako copern=1
//6=vymazanie faktury  po odsuhlaseni sa vrati sa do vstobj.php ako copern na 16
//8=uprava dokladu po vyplneni ide na 78 ulozi a vrati sa do vstobj.php ako copern na 1
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


$citfir = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$citkuch = include("citaj_ubyt.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//pristup podla prihlasenia
if( $fir_xrs01 == 1 )
     {
//echo "idem";

$nemapristup=0;
if( $rest_xediobj != 1 AND $copern != 1 AND $copern != 9 AND $drupoh == 1 ) { $nemapristup=1; }
if( $rest_xpozobj != 1 AND ( $copern == 1 OR $copern = 9 ) AND $drupoh == 1 ) { $nemapristup=1; }
if( $rest_xedipre != 1 AND $copern != 1 AND $copern != 9 AND $drupoh == 2 ) { $nemapristup=1; }
if( $rest_xpozpre != 1 AND ( $copern == 1 OR $copern = 9 ) AND $drupoh == 2 ) { $nemapristup=1; }
if( $rest_xedipre != 1 AND $copern != 1 AND $copern != 9 AND $drupoh == 3 ) { $nemapristup=1; }
if( $rest_xpozpre != 1 AND ( $copern == 1 OR $copern = 9 ) AND $drupoh == 3 ) { $nemapristup=1; }
if( $rest_xedipre != 1 AND $copern != 1 AND $copern != 9 AND $drupoh == 4 ) { $nemapristup=1; }
if( $rest_xpozpre != 1 AND ( $copern == 1 OR $copern = 9 ) AND $drupoh == 4 ) { $nemapristup=1; }

//takto zakazem pristup
if( $nemapristup == 1 )
{
$zakazrest=1;
$citkuch = include("../ubyt/citaj_ubyt.php");
exit;
}

     }
//koniec pristup podla prihlasenia


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


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
$h_udr = strip_tags($_REQUEST['h_udr']);
$h_dok = strip_tags($_REQUEST['h_dok']);
$h_dat = strip_tags($_REQUEST['h_dat']);
$h_dap = strip_tags($_REQUEST['h_dap']);
$h_dak = strip_tags($_REQUEST['h_dak']);
$h_ico = strip_tags($_REQUEST['h_ico']);
$h_nai = strip_tags($_REQUEST['h_nai']);
$h_poz = strip_tags($_REQUEST['h_poz']);
$h_kto = strip_tags($_REQUEST['h_kto']);
$h_txp = strip_tags($_REQUEST['h_txp']);
$h_txz = strip_tags($_REQUEST['h_txz']);
$h_unk = strip_tags($_REQUEST['h_unk']);

$h_cizb = strip_tags($_REQUEST['h_cizb']);

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
$h_rnaz = strip_tags($_REQUEST['h_rnaz']);
$h_druhp = 1*$_REQUEST['h_druhp'];
if( $h_druhp == 0 ) $h_druhp=1;
$h_hodp = strip_tags($_REQUEST['h_hodp']);
$h_rcep = strip_tags($_REQUEST['h_rcep']);
$h_jmno = strip_tags($_REQUEST['h_jmno']);
$h_ksy = strip_tags($_REQUEST['h_ksy']);
$h_rcis = strip_tags($_REQUEST['h_rcis']);
$h_iban = strip_tags($_REQUEST['h_iban']);
$h_twib = strip_tags($_REQUEST['h_twib']);
$h_zmen = strip_tags($_REQUEST['h_zmen']);
$h_kurz = strip_tags($_REQUEST['h_kurz']);
$h_pomr = strip_tags($_REQUEST['h_pomr']);
$h_mena = strip_tags($_REQUEST['h_mena']);

if ( $rozb2 == 'VELKE' AND $copern == 68) $copern=15;
if ( $rozb2 == 'VELKE' AND $copern == 78) $copern=18;
if ( $rozb2 == 'MALE' AND $copern == 68) $copern=15;
if ( $rozb2 == 'MALE' AND $copern == 78) $copern=18;

if( $drupoh == 1 )
{
$tablh = "ubytobjh";
$adrdok = " ";
$uctpol = "ubytobjp";
$uctpoh = "ubytobjp";
$hladaj_uce=1;
}
if( $drupoh == 2 )
{
$tablh = "ubytpredh";
$adrdok = " ";
$uctpol = "ubytpredp";
$uctpoh = "ubytpredp";
$hladaj_uce=2;
}
if( $drupoh == 3 )
{
$tablh = "ubytdodh";
$adrdok = " ";
$uctpol = "ubytdodp";
$uctpoh = "ubytdodp";
$hladaj_uce=3;
}
if( $drupoh == 4 )
{
$tablh = "restdodh";
$adrdok = " ";
$uctpol = "restdodp";
$uctpoh = "restdodp";
$hladaj_uce=4;
}

$mazanie=0;


//uloz vymaz oc dalsi host
if( $copern == 1055 OR $copern == 1058 )
{

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];

if( $copern == 1055 )
{
$ulozho=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_ubythostia WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ulozho=1;
  }

$sqty = "INSERT INTO F$kli_vxcf"."_ubytdalsihostia ( dok,dhst ) VALUES ( '$cislo_dok', '$cislo_oc' );"; 
//echo $sqty;
if( $ulozho == 1 ) { $ulozene = mysql_query("$sqty"); }
}

if( $copern == 1058 )
{

$sqty = "DELETE FROM F$kli_vxcf"."_ubytdalsihostia WHERE dok = $cislo_dok AND dhst = $cislo_oc "; 
//echo $sqty;
$ulozene = mysql_query("$sqty");
}

$copern=7;
}
//koniec uloz vymaz oc dalsi host


//zapis mnozstva jedla
if( $copern == 3618 )
{

$n_cpl = 1*$_REQUEST['n_cpl'];
$n_mnozs = 1*$_REQUEST['n_mnozs'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];

$dsqlt = "UPDATE F$kli_vxcf"."_$uctpol ".
" SET jmno=$n_mnozs ".
" WHERE cpl = $n_cpl";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$copern=8;
}
//koniec zapis mnozstva jedla

//ulozenie  polozky sluzby 7777777777777777
if ( $copern == 77 )
    {

if( $h_ksy == 0 ) $h_ksy="";
if( $h_rcis == 0 ) $h_rcis="";
$h_rced=$h_hodp;
if( $h_zmen == 1 AND $kli_vrok < 2009 ) $h_hodp=$h_kurz*$h_rced/$h_pomr;
if( $h_zmen == 1 AND $kli_vrok > 2008 ) $h_hodp=($h_rced/$h_kurz)*$h_pomr;

$sadzbadph=$fir_dph2;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_ubytcis WHERE cis = $h_rcis  ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sadzbadph=$riaddok->dph;
  }


$h_rcep=($h_rced/(1+$sadzbadph/100));
$h_xdph=$sadzbadph;

$sqty = "INSERT INTO F$kli_vxcf"."_$uctpol ( dok,rnaz,druhp,hodp,rcep,rced,jmno,ksy,rcis,id,uce,ico,iban,twib,xdph )".
" VALUES ('$cislo_dok', '$h_rnaz', '$h_druhp', '$h_hodp', '$h_rcep', '$h_rced', '$h_jmno', '$h_ksy', '$h_rcis',".
" '$kli_uzid', '$h_uce', '$h_ico', '$h_iban', '$h_twib', '$h_xdph' );"; 
//echo $sqty;
$ulozene = mysql_query("$sqty"); 

$uprt = "UPDATE F$kli_vxcf"."_$tablh SET  hodd=hodd+('$h_rced'*'$h_jmno') WHERE dok='$cislo_dok'";
$upravene = mysql_query("$uprt");

//ak drupoh=2 a je recept zapis do kuchzakp
//kuchzakp dok  xcpl  cpl  stol  rxcf  rid  datr  druhp  rcis  jmno  ico  kxcf  kid  datk  datp  oxcf  oid  dato  id  datm 
if( $drupoh == 2 )
   {
$niercp=1;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_ubytcisudaje WHERE xcis = $h_rcis AND xrcx = 1 AND xrcp > 0 ";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $niercp=0;
  $xrcp=$riaddok->xrcp;
  $xkuch=1*$riaddok->xdr3;
  if( $xkuch == 0 ) { $xkuch=$kli_vxcf; }
  }
  if ( $niercp == 0 )
  {
$sqlttt = "SELECT * FROM F$kli_vxcf"."_$uctpol WHERE dok = $cislo_dok ORDER BY cpl DESC ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
  $riaddok=mysql_fetch_object($sqldok);
  $xcpl=$riaddok->cpl;
    }

$sqty = "INSERT INTO F$xkuch"."_kuchzakp ( dok,xcpl,stol,rxcf,rid,druhp,rcis,jmno,kxcf ) ".
" VALUES ('$cislo_dok', '$xcpl', 1, '$kli_vxcf', '$kli_uzid', '11', '$xrcp', '$h_jmno', '$xkuch' );"; 
//echo $sqty;
$ulozzak = mysql_query("$sqty"); 
  }

   }
//koniec ak drupoh=2 a je recept zapis do kuchzakp

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
$z_rcep = strip_tags($_REQUEST['z_rcep']);
$z_rced = strip_tags($_REQUEST['z_rced']);
$z_rnaz = strip_tags($_REQUEST['z_rnaz']);
$z_druhp = strip_tags($_REQUEST['z_druhp']);
$z_jmno = strip_tags($_REQUEST['z_jmno']);
$z_ksy = strip_tags($_REQUEST['z_ksy']);
$z_rcis = strip_tags($_REQUEST['z_rcis']);

$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$cislo_dok = strip_tags($_REQUEST['cislo_dok']);

$sadzbadph=$fir_dph2;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_ubytcis WHERE cis = $z_rcis  ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sadzbadph=$riaddok->dph;
  }

$z_rcep=($z_rced/(1+$sadzbadph/100));

$uprt = "UPDATE F$kli_vxcf"."_$tablh SET  hodd=hodd-('$z_rced'*'$z_jmno') WHERE dok='$cislo_dok'";
$upravene = mysql_query("$uprt");



if( $drupoh == 1 ) { $zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_kuchvydajky WHERE dok='$cislo_dok' AND druhp = 40 AND zskcis = $z_rcis "); }

$zmazttt = "DELETE FROM F$kli_vxcf"."_$uctpol WHERE cpl='$cislo_cpl' "; 
//echo $zmazttt;
$zmazane = mysql_query("$zmazttt"); 

//ak drupoh=2 a je recept zmaz z kuchzakp
//kuchzakp dok  xcpl  cpl  stol  rxcf  rid  datr  druhp  rcis  jmno  ico  kxcf  kid  datk  datp  oxcf  oid  dato  id  datm 
if( $drupoh == 2 )
   {
$niercp=1;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_ubytcisudaje WHERE xcis = $z_rcis AND xrcx = 1 AND xrcp > 0 ";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $niercp=0;
  $xrcp=$riaddok->xrcp;
  $xkuch=1*$riaddok->xdr3;
  if( $xkuch == 0 ) { $xkuch=$kli_vxcf; }
  }
  if ( $niercp == 0 )
  {
$sqty = "DELETE FROM F$xkuch"."_kuchzakp WHERE dok = $cislo_dok AND xcpl = $cislo_cpl "; 
//echo $sqty;
$zmazzak = mysql_query("$sqty"); 
  }

   }
//koniec ak drupoh=2 a je recept zmaz z kuchzakp

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
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$tablh WHERE ( isnull(dok) )"); 

$maxdok=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_$tablh WHERE dok > 0 ORDER BY dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $maxdok=$riaddok->dok;
  }

$riadkto="";


$h_doknew=$maxdok+1;
if( $drupoh == 2 AND $h_doknew == 1 ) 
{ 
$h_doknew="7".$kli_vxcf."0001"; 
}
if( $drupoh == 3 AND $h_doknew == 1 ) 
{ 
$h_doknew="6".$kli_vxcf."0001"; 
}
if( $drupoh == 4 AND $h_doknew == 1 ) 
{ 
$h_doknew="8".$kli_vxcf."0001"; 
}

$newdok=$h_doknew;
$h_fak = $newdok;

$dat_dat = Date ("Y-m-d", MkTime (0,0,0,date("m"),date("d"),date("Y")));

$sqlhh = "INSERT INTO F$kli_vxcf"."_$tablh ( uce,dok,dat,dap,dak,ico,id,txp,txz,kto,unk,poz,mena,kurz ) VALUES ".
" ( '$hladaj_uce', $newdok, '$dat_dat', '$dat_dat', '$dat_dat', '$fir_fico', $kli_uzid, '', '', '$riadkto', '', '', '$mena1', '1' )";
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

if( $drupoh == 2 ) 
{ 
$citreg = include("../doprava/citaj_reg.php");
$newfak = $reg_cbl;
$upravcbl = mysql_query("UPDATE F$kli_vxcf"."_dopdkp SET cbl='$newfak'+1"); 
$upravcbl = mysql_query("UPDATE F$kli_vxcf"."_$tablh SET dencis='$newfak' WHERE dok= $newdok ");
}

$copern=8;
$cislo_dok=$newdok;
    }
//if ( $copern == 15 ) $copern=5;
//if ( $copern == 5 AND $sluz1 == "VELKE" ) $copern=7;
//koniec nova faktura hlavicka


//uprava dokladu hlavicka
if ( $copern == 8 )
    {
$sqltt = "SELECT * FROM F$kli_vxcf"."_$tablh".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tablh.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_$tablh.dok = $cislo_dok ".
"";
$sql = mysql_query("$sqltt"); 
$nieje=0;
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$nieje=1;
$cislo_uce = $riadok->uce;
$cislo_udr = $riadok->udr;
$cislo_dok = $riadok->dok;
$newdok = $riadok->dok;
$cislo_dat = $riadok->dat;
$cislo_dap = $riadok->dap;
$cislo_dak = $riadok->dak;
$cislo_ico = $riadok->ico;
$cislo_unk = $riadok->unk;
$cislo_kto = $riadok->kto;
$cislo_txp = $riadok->txp;
$cislo_txz = $riadok->txz;
$cislo_poz = $riadok->poz;
$cislo_chst = $riadok->chst;
$cislo_cizb = $riadok->cizb;
$vybr_ico = $riadok->ico;
$cislo_datsk = SkDatum($riadok->dat);
$cislo_dapsk = SkDatum($riadok->dap);
$cislo_daksk = SkDatum($riadok->dak);
$vybr = 'ANO';
  }

if( $nieje == 0 )
{
?>
<script type="text/javascript">
 location.href='vstobj.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=1&drupoh=<?php echo $drupoh; ?>&page=<?php echo $page; ?>'  
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
$h_dap = SqlDatum($h_dap);
$h_dak = SqlDatum($h_dak);

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dban WHERE dban = $h_uce ORDER BY dban DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_kto=$riaddok->nban." ".$riaddok->rnaz." / ".$riaddok->druhp;
  }

$pole = explode("-", $h_dat);
$h_ume = $pole[1].".".$pole[0];

$uprt = "UPDATE F$kli_vxcf"."_$tablh SET uce='$h_uce', udr='$h_udr', dok='$h_dok', dat='$h_dat', dap='$h_dap', dak='$h_dak',".
" ico='$h_ico', unk='$h_unk',".
" poz='$h_poz', txp='$h_txp', txz='$h_txz',".
" hodp='$h_hodp', kto='$h_kto', chst='$h_kto', cizb='$h_cizb' ".
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
if ( $sluz1 != 'VELKE' )
{
?>
<script type="text/javascript">
 location.href='vstobj.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=1&drupoh=<?php echo $drupoh; ?>&page=1'  
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
$h_dap = SqlDatum($h_dap);
$h_dak = SqlDatum($h_dak);

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dban WHERE dban = $h_uce ORDER BY dban DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_kto=$riaddok->nban." ".$riaddok->rnaz." / ".$riaddok->druhp;
  }

if( $drupoh == 4 AND $h_kto == 0 )
{
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_ubytdodh WHERE dap <= '$h_dat' AND dak >= '$h_dat' AND cizb = $h_cizb ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_kto=1*$riaddok->chst;
  }

}

$pole = explode("-", $h_dat);
$h_ume = $pole[1].".".$pole[0];

$uprt = "UPDATE F$kli_vxcf"."_$tablh SET uce='$h_uce', udr='$h_udr',dok='$h_dok', dat='$h_dat', dap='$h_dap', dak='$h_dak',".
" ico='$h_ico', unk='$h_unk',".
" poz='$h_poz', txp='$h_txp', txz='$h_txz',".
" hodp='$h_hodp', kto='$h_kto', chst='$h_kto', cizb='$h_cizb' ".
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
 location.href='vstobj.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=1&drupoh=<?php echo $drupoh; ?>&page=1'  
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
<?php if( $drupoh == 1 ) echo "<title>Objedn·vky v ubytovanÌ</title>"; ?>
<?php if( $drupoh == 2 ) echo "<title>PredajnÈ doklady v ubytovanÌ</title>"; ?>
<?php if( $drupoh == 3 ) { echo "<title>DodanÈ sluûby a tovar v ubytovanÌ</title>"; } ?>
<?php if( $drupoh == 4 ) { echo "<title>Doklady na hotelov˝ ˙Ëet</title>"; } ?>
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
<script type="text/javascript" src="daj_cizb.js"></script>
<script type="text/javascript" src="daj_hosta.js"></script>
<?php
}
?>
<?php
if ( $copern == 7 )
{
?>
<script type="text/javascript" src="daj_hosta.js"></script>
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
        if( document.forms.fhlv1.h_dap.value == "" ) { document.forms.fhlv1.h_dap.value = '<?php echo date("d.m.Y"); ?>'; }
        if( document.forms.fhlv1.h_dak.value == "" ) { document.forms.fhlv1.h_dak.value = '<?php echo date("d.m.Y"); ?>'; }
        document.forms.fhlv1.h_dat.select();
                }

function OnfocusDap()
                {

        document.forms.fhlv1.h_dap.value=document.forms.fhlv1.h_dat.value;
        document.forms.fhlv1.h_dap.select();
                }

function OnfocusDak()
                {

        if( document.forms.fhlv1.h_dak.value == "" ) { document.forms.fhlv1.h_dak.value=document.forms.fhlv1.h_dat.value; }
        document.forms.fhlv1.h_dak.select();
                }


function DatEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        document.forms.fhlv1.h_dap.focus();
        document.forms.fhlv1.h_dap.select();
              }
                }

function DapEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_dak.focus();
        document.forms.fhlv1.h_dak.select();
              }
                }

function DakEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_cizb.focus();
        document.forms.fhlv1.h_cizb.select();
              }
                }

function CizbEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhlv1.h_cizb.value != '')
        {
        myCizbElement.style.display='';
        volajCizb(1);
        }      
        if( document.fhlv1.h_cizb.value == "" ) { document.fhlv1.h_ico.focus(); document.forms.fhlv1.h_ico.select(); }
        if( document.fhlv1.h_cizb.value == 0 ) { document.fhlv1.h_ico.focus(); document.forms.fhlv1.h_ico.select(); }
              }
                }

//co urobi po potvrdeni ok z tabulky cizb
function vykonajCizb(cizb,nizb)
                {
        document.forms.fhlv1.h_cizb.value = cizb;
        myCizbElement.style.display='none';
        document.forms.fhlv1.h_ico.focus();
        document.forms.fhlv1.h_ico.select();
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

function XNhstEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fvypis.h_ktox.value != '')
        {
        myHostElement.style.display='';
        volajHost(13);
        }      

              }
                }

function XChstEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fvypis.h_kto.value != '')
        {
        myHostElement.style.display='';
        volajHost(11);
        }      
              }
                }


function NhstEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhlv1.h_ktox.value != '')
        {
        myHostElement.style.display='';
        volajHost(3);
        }      

              }
                }

function ChstEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhlv1.h_kto.value != '')
        {
        myHostElement.style.display='';
        volajHost(1);
        }      
        if( document.fhlv1.h_kto.value == "" ) { document.fhlv1.h_udr.focus(); }
        if( document.fhlv1.h_kto.value == 0 ) { document.fhlv1.h_udr.focus();  }
              }
                }

//co urobi po potvrdeni ok z tabulky hostia
function vykonajHost(chst,nhst)
                {
        document.forms.fhlv1.h_kto.value = chst;
        document.forms.fhlv1.h_ktox.value = nhst;
        myHostElement.style.display='none';
        document.forms.fhlv1.h_udr.focus();
                }

//co urobi po potvrdeni ok z tabulky hostia
function vykonajHost3(chst,nhst)
                {
        document.forms.fvypis.h_kto.value = chst;
        document.forms.fvypis.h_ktox.value = nhst;
        myHostElement.style.display='none';
        document.forms.fvypis.h_kto.focus();
                }

function UdrEnter(e)
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
function vykonajPriku(naz,cis,druh,ake,ced)
                {

        document.forms.forms1.h_rnaz.value = naz;
        document.forms.forms1.h_rcis.value = cis;
        document.forms.forms1.h_hodp.value = ced;
        myPrikuelement.style.display='none';
        document.forms.forms1.h_jmno.value = 0;
        document.forms.forms1.h_jmno.focus();
        document.forms.forms1.h_jmno.select();
        if( ake == 1 ) { volajPriku(2); }

                }



function volatPriku1()
                    {
                    volajPriku(1);
                    }



function Len1Priku(ake)
                    {
        myPrikuelement.style.display='none';
        document.forms.forms1.h_jmno.focus();
        document.forms.forms1.h_jmno.select();
                    }

function Len0Priku()
                    {
        myPrikuelement.style.display='none';
        document.forms.forms1.h_rnaz.focus();
        document.forms.forms1.h_rnaz.select();
                    }

//posuny Enter[[[[[[[[[[[

function druhpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.forms1.h_rnaz.focus();
        document.forms.forms1.h_rnaz.select();
              }
                }

function rnazEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if( document.forms.forms1.h_rnaz.value != '' ) { volajPriku(1); }
        if( document.forms.forms1.h_rnaz.value == '' ) 
                               {
        document.forms.forms1.h_rcis.focus();
        document.forms.forms1.h_rcis.select();
                               }
              }
                }

function rcisEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.forms1.h_jmno.focus();
        document.forms.forms1.h_jmno.select();
              }
                }


function HodpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.forms1.h_jmno.focus();
        document.forms.forms1.h_jmno.select();
              }
                }



function jmnoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;
    if ( document.forms1.h_rnaz.value == '' ) okvstup=0;
    if ( document.forms1.h_jmno.value == '' ) okvstup=0;

    if ( okvstup == 0 && document.forms1.h_rnaz.value == '' ) { document.forms1.h_rnaz.focus(); return (false); }
    if ( okvstup == 0 && document.forms1.h_rcis.value == '' ) { document.forms1.h_rcis.focus(); return (false); }

    if ( okvstup == 1 ) { document.forms.forms1.submit(); return (true); }
              }
                }


function nulujPol()
                {

                }


    function ObnovUI()
    {

document.forms1.h_druhp.value = "40";
    }

    function VyberVstup()
    {
    <?php if( $mazanie == 1 ) { 
    echo "document.forms1.h_rnaz.value = '$z_rnaz';\r";
    echo "document.forms1.h_druhp.value = '40';\r";
    echo "document.forms1.h_hodp.value = '$z_hodp';\r";
    echo "document.forms1.h_jmno.value = '$z_jmno';\r";
    echo "document.forms1.h_rcis.value = '$z_rcis';\r";
                              } ?>
    document.forms.forms1.h_rnaz.focus();
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

    if ( document.forms1.h_rnaz.value == '' ) okvstup=0;
    if ( document.forms1.h_rcis.value == '' ) okvstup=0;

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
 echo "document.fhlv1.h_udr.value = '$cislo_udr';";
 echo "document.fhlv1.h_dok.value = '$cislo_dok';";
 echo "document.fhlv1.h_dat.value = '$cislo_datsk';";
 echo "document.fhlv1.h_dap.value = '$cislo_dapsk';";
 echo "document.fhlv1.h_dak.value = '$cislo_daksk';";
 echo "document.fhlv1.h_cizb.value = '$cislo_cizb';";
 echo "document.fhlv1.h_kto.value = '$cislo_kto';";
 echo "document.fhlv1.h_unk.value = '$cislo_unk';";
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

//Kontrola datumu Sk dak
function kontrola_datumDAK(vstup, Oznam, x1, errflag)
		{
if( document.fhlv1.h_dak.value != '' )    {
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
//koniec kontrola datumu dak

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

<?php if( $copern == 5 ) { ?>

    var toprobotmenu = 127;

<?php                    } ?>

    htmlmenu += "</table>";  
    
</script>


<?php if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 ) 
{ echo "<script type='text/javascript' src='daj_tovar.js'></script>"; } ?>
<?php if( $drupoh == 4 ) 
{ echo "<script type='text/javascript' src='../restauracia/daj_tovar.js'></script>"; } ?>

<script type='text/javascript'>

    function nastavDruh()
    { 
    document.forms1.xdruh.value=0;
    if( document.forms1.h_vdruh.checked ) { document.forms1.xdruh.value=1; }
    }


function UlozSTZ(cpl,mno)
                {

var n_cpl = document.forms.fhosnew.h_cpl.value;
var n_mnozs = document.forms.fhosnew.n_mnozs.value;

if( n_cpl > 0 ) {
window.open('vsob_u.php?copern=3618&n_mnozs=' + n_mnozs + '&n_cpl=' + n_cpl + '&drupoh=<?php echo $drupoh; ?>&cislo_dok=<?php echo $cislo_dok; ?>&sysx=INE&rozuct=NIE&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_self' );
                 }

                }

    function CiarkaNaBodku(Vstup)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
    }

function VlozSTZ(cpl,mno)
                {
var uhr_mcpl = cpl;
var uhr_mmno = mno;

var dajism = "SM" + uhr_mcpl; 

  myUhrasm = document.getElementById( dajism );

  htmluhs  = " <table width='100%' ><tr><FORM name='fhosnew' class='obyc' method='post' action='#' >";

  htmluhs += " <td class='hvstup_zlte' width='100%' align='right'>";

  htmluhs += " <img border=1 src='../obr/zmazuplne.png' style='width:15; height:15;' title='Zhasn˙ù okno' ";
  htmluhs += " onClick=\"ZhasniSTZ('" + uhr_mcpl + "','" + uhr_mmno + "');\">";

  htmluhs += " <input class='hvstup' type='text' name='n_mnozs' id='n_mnozs' size='8' onkeyup='CiarkaNaBodku(this)' value='"  + uhr_mmno +  "' />";

  htmluhs += " <img border=1 src='../obr/ok.png' style='width:15; height:15;' title='Uloûiù mnoûstvo' ";
  htmluhs += " onClick=\"UlozSTZ('" + uhr_mcpl + "','" + uhr_mmno + "');\">";

  htmluhs += " <INPUT type='hidden' name='h_cpl' value='" + uhr_mcpl + "' >";
  htmluhs += " </td>";

  htmluhs += " </tr></table>";



  myUhrasm.innerHTML = htmluhs;


  document.forms.fhosnew.n_mnozs.focus();
  document.forms.fhosnew.n_mnozs.select();
                }

function ZhasniSTZ(cpl,mno )
                {

var uhr_mcpl = cpl;
var uhr_mmno = mno;

var dajism = "SM" + uhr_mcpl; 

  myUhrasm = document.getElementById( dajism );
  var htmluhs = uhr_mmno + " ";
  htmluhs += " <img border=1 src='../obr/uprav.png' style='width:15; height:15;' title='Uloûiù poloûku a zapÌsaù do receptu vzùah Skladov· poloûka -> Surovina' ";
  htmluhs += " onClick=\"VlozSTZ('" + uhr_mcpl + "','" + uhr_mmno + "');\">";

  myUhrasm.innerHTML = htmluhs;
                }

<?php if( $copern == 7 ) { ?>

    function PolozkyIzby( izba )
    {

    window.open('pridaj_polozky.php?copern=100&drupoh=<?php echo $drupoh; ?>&cislo_uce=<?php echo $hladaj_uce; ?>&cislo_dok=<?php echo $cislo_dok; ?>&izba=' + izba + '&page=1', '_self' )

    }

    function PolozkyPred1( izba )
    {

    window.open('pridaj_polozky.php?copern=1&drupoh=<?php echo $drupoh; ?>&cislo_uce=<?php echo $hladaj_uce; ?>&cislo_dok=<?php echo $cislo_dok; ?>&izba=' + izba + '&page=1', '_self' )

    }

    function PolozkyPred2( izba )
    {

    window.open('pridaj_polozky.php?copern=2&drupoh=<?php echo $drupoh; ?>&cislo_uce=<?php echo $hladaj_uce; ?>&cislo_dok=<?php echo $cislo_dok; ?>&izba=' + izba + '&page=1', '_self' )

    }



  function zobraz_dalsihostia()
  { 


  myvyp = document.getElementById("divNahrate");
    var htmlvyp = "<table  class='ponuka' width='100%'><tr><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td>" +
    "<td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td></tr>"; 
    htmlvyp += "<tr><FORM name='fvypis' method='post' action='#' ><td  colspan='5'>";
    htmlvyp += " V˝pis ÔalöÌch hostÌ na izbe </td>";

    htmlvyp += "<td align='right' colspan='5'><img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;'";
    htmlvyp += "onClick='zhasni_dalsihostia();' title='Zhasni v˝pis' ></td></tr>"; 


<?php
$sqltt = "SELECT * FROM F$kli_vxcf"."_ubytdalsihostia ".
" LEFT JOIN F$kli_vxcf"."_ubythostia".
" ON F$kli_vxcf"."_ubytdalsihostia.dhst=F$kli_vxcf"."_ubythostia.oc".
" WHERE dok = $cislo_dok ORDER BY dhst";
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>


    htmlvyp += "<tr><td class='ponuka' colspan='10'>"; 
    htmlvyp += " <img border=1 src='../obr/zmaz.png' style='width:15; height:15;'";
    htmlvyp += "onClick='ZmazOc(<?php echo $riadok->dhst; ?>);' title='Zmazaù UbytovanÈho z izby' >"; 
    htmlvyp += " <?php echo $riadok->dhst; ?> <?php echo $riadok->prie; ?> <?php echo $riadok->meno; ?></td></tr>";

<?php
  }
$i=$i+1;
   }
?>

    htmlvyp += "<tr><td colspan='10'>";
    htmlvyp += " OsË <img src='../obr/hladaj.png' width=12 height=12 border=0 onclick='volajHost(12);' ";
    htmlvyp += " title='Zadajte osobnÈ ËÌslo alebo vyberte z ponuky'> ";

    htmlvyp += "<input type='text' name='h_kto' id='h_kto' size='4' maxlenght='4' >"; 
    htmlvyp += " <input type='text' name='h_ktox' id='h_ktox' size='15' onKeyDown='return XNhstEnter(event.which)' >"; 
    htmlvyp += " <img border=0 src='../obr/ok.png' style='width:15; height:15;'";
    htmlvyp += "onClick='UlozOc();' title='Uloûiù ubytovanÈho do izby' >"; 

    htmlvyp += "</td></tr>";


    htmlvyp += "<tr><td></td></FORM></tr></table>"; 

  myvyp.innerHTML = htmlvyp;

  divNahrate.style.display='';

  }

  function zhasni_dalsihostia()
  { 
  divNahrate.style.display='none';
  }

  function ZmazOc( ocx )
  { 
  var h_xyoc = ocx;

  window.open('vsob_u.php?cislo_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>&cislo_oc=' + h_xyoc + '&copern=1058&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function UlozOc()
  { 

  var h_xyoc = document.forms.fvypis.h_kto.value;

  window.open('vsob_u.php?cislo_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>&cislo_oc=' + h_xyoc + '&copern=1055&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }


//koniec   function zobraz_dalsihostia()





<?php                    } ?>

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

<div id="divNahrate" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 150; left: 850; width:350; height:200;">
zobrazeny vysledok
</div>

<div id="divdalsihostia" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 150; left: 850; width:350; height:200;">
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
<?php if( $drupoh == 1 ) echo "<td>EuroSecom  -  Objedn·vky v ubytovanÌ"; ?>
<?php if( $drupoh == 2 ) echo "<td>EuroSecom  -  PredajnÈ doklady v ubytovanÌ"; ?>
<?php if( $drupoh == 3 ) echo "<td>EuroSecom  -  DodanÈ sluûby a tovar v ubytovanÌ"; ?>
<?php if( $drupoh == 4 ) echo "<td>EuroSecom  -  Doklady na hotelov˝ ˙Ëet v reötaur·cii"; ?>
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
if ( $copern == 7 )
     {
?>

<div id="myHostElement" style="position: absolute; top: 350; left: 0; z-index: 900; "></div>

<?php
     }    

if ( $copern == 5 OR $copern == 8 )
     {
?>

<div id="myCizbElement" style="position: absolute; top: 350; left: 0; z-index: 900; "></div>

<div id="myHostElement" style="position: absolute; top: 350; left: 0; z-index: 900; "></div>

<span style="position: absolute; top: 150; left: 50%;"> 
<div id="myIcoElement"></div>
</span>
<table class="vstup" width="50%" height="130px" align="left">
<tr></tr><tr></tr>
<FORM name="fhlv1" class="obyc" method="post" action="vsob_u.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>
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
 <?php if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 OR $drupoh == 4 ) echo "Druh:"; ?>
</td>

<?php
if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 OR $drupoh == 4 )
{
?>
<td class="fmenu">
<select class="hvstup" size="1" name="h_uce" id="h_uce" onmouseover="HlvOnClick();" 
 onKeyDown="return UceEnter(event.which)" >
<option value="<?php echo $hladaj_uce;?>" >
<?php echo $hladaj_uce;?></option>
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
<td class="bmenu" width="10%" ></td>
</tr>
<tr><td class="pvstup" >&nbsp;D·tum:</td>
<td class="hvstup">
<input class="hvstup" type="text" name="h_dat" id="h_dat" size="10" maxlength="10" value="<?php echo $h_dat;?>"
 onclick="HlvOnClick()" onkeyup="KontrolaDatum(this, Kx)"  onfocus="OnfocusDat()"
 onChange="return kontrola_datum(this, Kx, this, document.fhlv1.err_dat)" onKeyDown="return DatEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dat" value="0">
<input class="hvstup" type="hidden" name="h_dns" id="h_dns" value="" size="2" maxlength="3">

Od <input class="hvstup" type="text" name="h_dap" id="h_dap" size="10" maxlength="10" value="<?php echo $h_dap;?>"
 onclick="HlvOnClick()" onkeyup="KontrolaDatum(this, Kx)"  onfocus="OnfocusDap()"  
 onChange="return kontrola_datum(this, Kx, this, document.fhlv1.err_dat)" onKeyDown="return DapEnter(event.which)" />
 Do <input class="hvstup" type="text" name="h_dak" id="h_dak" size="10" maxlength="10" value="<?php echo $h_dak;?>"
 onclick="HlvOnClick()" onkeyup="KontrolaDatum(this, Kx)"  onfocus="OnfocusDak()"   
 onChange="return kontrola_datumDAK(this, Kx, this, document.fhlv1.err_dat)" onKeyDown="return DakEnter(event.which)" />

</td>
</tr>

<input class="hvstup" type="hidden" name="h_daz" id="h_daz" />
<input class="hvstup" type="hidden" name="h_das" id="h_das" />
<input class="hvstup" type="hidden" name="h_obj" id="h_obj" />

<tr><td class="pvstup" >&nbsp;»Ìslo IZBY:</td>
<td class="hvstup" >

<input class="hvstup" type="text" name="h_cizb" id="h_cizb" size="8" maxlength="8" value="<?php echo $h_cizb;?>" onclick="HlvOnClick()"
 onKeyDown="return CizbEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_cizb" value="0">

<img src='../obr/hladaj.png' border="1" onclick="myCizbElement.style.display=''; volajCizb(2);" title="Hæadaj ËÌslo izby" >

</td>
</tr>

<tr></tr><tr></tr>
</table>
<table class="vstup" width="50%" height="130px" align="left">
<tr></tr><tr></tr>
<tr><td class="pvstup" width="15%" >&nbsp;<?php echo $Odberatel; ?> I»O:
<a href='../cis/cico.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=5&page=1' target="_blank" ><img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Vloûiù novÈ I»O do datab·zy" ></a>
</td>
<td class="hvstup" width="25%" >
<?php if( $drupoh == 4 ) { $h_ico=$fir_fico; } ?>
<?php if( $drupoh == 5 ) { $h_ico=$fir_fico; } ?>
<input class="hvstup" type="text" name="h_ico" id="h_ico" size="12" maxlength="8" value="<?php echo $h_ico;?>"
 onclick="Fxh.style.display='none'; document.fhlv1.h_nai.disabled = false; myIcoElement.style.display='none'; nulujIco();"
 onchange="return intg(this,1,99999999,Ix,document.fhlv1.err_ico)" onkeyup="KontrolaCisla(this, Ix)" 
 onKeyDown="return IcoEnter(event.which)" />

<img src='../obr/hladaj.png' border="1" onclick="myIcoElement.style.display=''; volajIco();" title="Hæadaj zadanÈ I»O alebo n·zov firmy" >

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
<td class="pvstup" >&nbsp;»Ìslo UbytovanÈho:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_kto" id="h_kto" size="8" maxlength="8" value="<?php echo $h_chst;?>" onclick="HlvOnClick()"
 onKeyDown="return ChstEnter(event.which)" />

<img src='../obr/hladaj.png' border="1" onclick="myHostElement.style.display=''; volajHost(2);" title="Hæadaj ubytovanÈho" >

<input class="hvstup" type="text" name="h_ktox" id="h_ktox" size="25"  onKeyDown="return NhstEnter(event.which)" />

</td>
</tr>

<tr>
<td class="pvstup" >&nbsp;SpÙsob ˙hrady:</td>
<td class="hvstup" >
<select class="hvstup" size="1" name="h_udr" id="h_udr" onmouseover="HlvOnClick();" 
 onKeyDown="return UdrEnter(event.which)" >
<option value="0" >0=BEZ ⁄HRADY</option>
</select>

<input class="hvstup" type="text" name="h_unk" id="h_unk" size="8" maxlength="8" value="<?php echo $h_unk;?>"  />

</td>
</tr>

<tr></tr>
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
<td class="pvstup"  width="10%" >&nbsp;Pozn·mka:</td>
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
<FORM name="formh4" class="obyc" method="post" action="vstobj.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
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
$sqltt = "SELECT * FROM F$kli_vxcf"."_$tablh".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tablh.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_ubythostia".
" ON F$kli_vxcf"."_$tablh.chst=F$kli_vxcf"."_ubythostia.oc".
" LEFT JOIN F$kli_vxcf"."_ubytizby".
" ON F$kli_vxcf"."_$tablh.cizb=F$kli_vxcf"."_ubytizby.cizb".
" WHERE F$kli_vxcf"."_$tablh.dok = $cislo_dok ".
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
$dap_sk=SkDatum($riadok->dap);
$dak_sk=SkDatum($riadok->dak);
$celsuma=$riadok->rced;
$celsump=$riadok->hodp;
?>

<tr>
<td class="pvstup">&nbsp;
<?php if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 OR $drupoh == 4 ) echo "Druh:"; ?></td>
<td class="fmenu"><?php echo $riadok->uce; ?></td>
<td class="bmenu" width="10%" >
<?php if( $drupoh == 1 ) { ?>
<a href="#" onClick="window.open('objednavka_pdf.php?copern=20&drupoh=<?php echo $drupoh;?>
&cislo_dok=<?php echo $riadok->dok;?>', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/pdf.png' width=20 height=12 border=0 title="VytlaËiù Objedn·vku" ></a>
<?php                    } ?>
<?php if( $drupoh == 2 ) { ?>
<a href="#" onClick="window.open('predaj_pdf.php?copern=20&drupoh=<?php echo $drupoh;?>
&cislo_dok=<?php echo $riadok->dok;?>', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/pdf.png' width=20 height=12 border=0 title="VytlaËiù Doklad" ></a>
<?php                    } ?>
<?php if( $drupoh == 3 ) { ?>
<a href="#" onClick="window.open('dodaci_pdf.php?copern=20&drupoh=<?php echo $drupoh;?>
&cislo_dok=<?php echo $riadok->dok;?>', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/pdf.png' width=20 height=12 border=0 title="VytlaËiù DodacÌ list" ></a>
<?php                    } ?>
<?php if( $drupoh == 4 ) { ?>
<a href="#" onClick="window.open('../ubyt/predaj_pdf.php?copern=20&drupoh=<?php echo $drupoh;?>
&cislo_dok=<?php echo $riadok->dok;?>&akakasa=1', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/pdf.png' width=20 height=12 border=0 title="VytlaËiù Doklad" ></a>
<?php                    } ?>
</td>
</tr>
<tr>
<td class="pvstup" width="15%" >&nbsp;»Ìslo dokladu:
</td>
<td class="hvstup" width="25%" ><?php echo $riadok->dok; ?></td>
<td class="bmenu">

</td>
</tr>
<tr>
<td class="pvstup" >&nbsp;D·tum:</td>
<td class="hvstup"><?php echo $dat_sk; ?> Od <?php echo $dap_sk; ?> Do <?php echo $dak_sk; ?></td>
<td class="bmenu">

</td>
</tr>
<tr>
<td class="pvstup" >&nbsp;»Ìslo Izby:</td>
<td class="hvstup"><?php echo $riadok->cizb; ?> - <?php echo $riadok->nizb; ?>


</td>
<?php
if( $copern == 7 OR $copern == 17 )
{
?>
<td>
<a href='vsob_u.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
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
<td class="bmenu" width="10%" ></td>
</tr>
<tr>
<td class="pvstup" width="15%" >&nbsp;<?php echo $Odberatel; ?> N·zov:</td>
<td class="hvstup" width="25%" ><?php echo $riadok->nai; ?></td>
<td class="bmenu" width="10%" >

</td>
</tr>
<td class="pvstup" > 
&nbsp;»Ìslo UbytovanÈho:</td>
<td class="hvstup"><?php echo $riadok->chst; ?> <?php echo $riadok->prie; ?> <?php echo $riadok->meno; ?></td>
<td class="bmenu" width="10%" >


<img src='../obr/klienti.png' width=15 height=15 border=0 onClick="zobraz_dalsihostia();" title="œalöÌ hostia na izbe" >



</td>
</tr>

<tr>
<td class="pvstup" >&nbsp;SpÙsob ˙hrady:</td>
<td class="pvstup" >
<?php
$dudr="";
if( $riadok->udr == 0 ) $dudr="BEZ ⁄HRADY";
if( $riadok->udr == 1 ) $dudr="ZAPLATEN… V HOTOVOSTI";
if( $riadok->udr == 2 ) $dudr="PLATBA KARTOU";
if( $riadok->udr == 8 ) $dudr="DODAN…";
if( $riadok->udr == 9 ) $dudr="FAKT⁄ROVAN…";


?>
<?php echo $riadok->udr; ?> <?php echo $dudr; ?>  <?php echo $riadok->unk; ?></td>
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
<td class="pvstup" width="15%" >Pozn·mka:</td>
<td class="hvstup" width="75%" ><?php echo $vypis_txp; ?></td>

<td class="pvstup" align="right" width="10%" >
<?php
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 OR $drupoh == 4 )
  {
?>
<a href="#" onClick="">
<img src='../obr/export.jpg' width=15 height=15 border=0 title="Export ˙dajov" ></a>


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
  while ($i <= $slpol OR $i == 0 )
  {


if( $i == 0 )
{
?>
<table class="<?php echo $fmenu; ?>" width="100%" >

<tr>
<td class="<?php echo $pvstup ?>" width="10%">Poloûka
<td class="<?php echo $pvstup ?>" width="7%">Druh
<td class="<?php echo $pvstup ?>" width="28%">Tovar n·zov

<?php
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 )
  {
?>
<a href="#" onClick="PolozkyIzby(<?php echo $riadok->cizb; ?>)">
Izba<img src='../obr/ziarovka.png' width=15 height=15 border=0 title="Poloûky vybranej Izby" ></a>

<a href="#" onClick="PolozkyPred1(<?php echo $riadok->cizb; ?>)">
P1<img src='../obr/ziarovka.png' width=15 height=15 border=0 title="Poloûky preddefinovanÈ Ë.1 - na izbe Ë.99990001" ></a>

<a href="#" onClick="PolozkyPred2(<?php echo $riadok->cizb; ?>)">
P2<img src='../obr/ziarovka.png' width=15 height=15 border=0 title="Poloûky preddefinovanÈ Ë.2 - na izbe Ë.99990002" ></a>

<?php
  }
?>

<td class="<?php echo $pvstup ?>" width="8%">Tovar ËÌslo
<td class="<?php echo $pvstup ?>" width="3%" align="right" >%DPH
<td class="<?php echo $pvstup ?>" width="8%" align="right" >Pred.CenasDPH
<td class="<?php echo $pvstup ?>" width="9%" align="right" >Mnoûstvo
<td class="<?php echo $pvstup ?>" width="7%">Zmaû
</tr>

<?php
}
//koniec i=0


  if (@$zaznam=mysql_data_seek($sluz,$i))
{
$rsluz=mysql_fetch_object($sluz);
$jmno=$rsluz->jmno;
if( $jmno == 0 ) $jmno="";
$rced=$rsluz->rced;
if( $rced == 0 ) $rced="";
?>

<tr>
<td class="fmenu" ><?php echo $rsluz->cpl;?></td>
<td class="fmenu" align="left" >
<?php if( $rsluz->druhp == 1 )  { echo "POLIEVKA 1"; } ?>
<?php if( $rsluz->druhp == 2 )  { echo "POLIEVKA 2"; } ?>
<?php if( $rsluz->druhp == 3 )  { echo "POLIEVKA 3"; } ?>
<?php if( $rsluz->druhp == 11 )  { echo "HL.JEDLO 1"; } ?>
<?php if( $rsluz->druhp == 12 )  { echo "HL.JEDLO 2"; } ?>
<?php if( $rsluz->druhp == 13 )  { echo "HL.JEDLO 3"; } ?>
<?php if( $rsluz->druhp == 14 )  { echo "HL.JEDLO 4"; } ?>
<?php if( $rsluz->druhp == 15 )  { echo "HL.JEDLO 5"; } ?>
<?php if( $rsluz->druhp == 16 )  { echo "HL.JEDLO 6"; } ?>
<?php if( $rsluz->druhp == 17 )  { echo "HL.JEDLO 7"; } ?>

<?php if( $rsluz->druhp == 21 )  { echo "DOPLNOK 1"; } ?>
<?php if( $rsluz->druhp == 22 )  { echo "DOPLNOK 2"; } ?>
<?php if( $rsluz->druhp == 23 )  { echo "DOPLNOK 3"; } ?>
<?php if( $rsluz->druhp == 40 )  { echo "TOVAR"; } ?>
</td>
<td class="fmenu" align="left" ><?php echo $rsluz->rnaz;?></td>
<td class="fmenu" align="left" ><?php echo $rsluz->rcis;?></td>
<td class="fmenu" align="right" ><?php echo $rsluz->xdph;?></td>
<td class="fmenu" align="right" ><?php echo $rced;?></td>
<td class="fmenu" align="right" >
<div id='SM<?php echo $rsluz->cpl; ?>' >
<?php echo $jmno;?>
</div>
</td>

<td class="fmenu" width="5%" >
<a href='vsob_u.php?copern=316&drupoh=<?php echo $drupoh;?>&z_rcep=<?php echo $rsluz->rcep;?>&z_rced=<?php echo $rsluz->rced;?>
&z_rnaz=<?php echo $rsluz->rnaz;?>&z_druhp=<?php echo $rsluz->druhp;?>&z_jmno=<?php echo $rsluz->jmno;?>
&z_ksy=<?php echo $rsluz->ksy;?>&z_rcis=<?php echo $rsluz->rcis;?>
&cislo_cpl=<?php echo $rsluz->cpl;?>&cislo_dok=<?php echo $rsluz->dok;?>&z_hodp=<?php echo $rsluz->hodp;?>&uprav=0'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazaù riadok" ></a>
<?php 
$cfak=$rsluz->cfak;
if( $cfak == 0 ) $cfak="";
if( $cfak != "" ) { echo "d".$cfak; }
?>
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
<?php
if ( $copern == 7 )
     {
?>
<FORM name="forms1" class="obyc" method="post" action="vsob_u.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>
&copern=77&cislo_dok=<?php echo $cislo_dok;?>" >
<?php
     }
?>
<tr>

<td class="hmenu"><input type="text" name="h_cpl" id="h_cpl" size="5"  disabled="disabled" /></td>

<td class="hmenu">
 <select size="1" name="h_druhp" id="h_druhp" >

<option value="40" >TOVAR</option>
</select>

<td class="hmenu">
<input type="text" name="h_rnaz" id="h_rnaz" size="50"  onKeyDown="return rnazEnter(event.which)" 
 onclick="myPrikuelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" /> 

<img src='../obr/hladaj.png' border="1" onclick="myPrikuelement.style.display=''; volatPriku1();" title="Hæadaj v tovarov˝ch poloûk·ch" >

<td class="hmenu" align="left"><input type="text" name="h_rcis" id="h_rcis" size="10"
 onclick="myPrikuelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return rcisEnter(event.which)" 
 onchange="return intg(this,0,9999999999,Cele,document.forms1.err_rcis)" 
 onkeyup="KontrolaCisla(this, Cele)"/>
<INPUT type="hidden" name="err_rcis" value="0"> 

<td class="hmenu" align="right" colspan="2" ><input type="text" name="h_hodp" id="h_hodp" size="8" 
 onclick="myPrikuelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return HodpEnter(event.which)"
 onchange="return cele(this,0.01,99999999,Desc,2,document.forms1.err_hodp)" 
 onkeyup="KontrolaDcisla(this, Desc)"  />
<INPUT type="hidden" name="err_hodp" value="0"></td>

<td class="hmenu" align="right"><input type="text" name="h_jmno" id="h_jmno" size="10"
 onclick="myPrikuelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return jmnoEnter(event.which)" 
 onchange="return intg(this,0,9999999999,Cele,document.forms1.err_jmno)" 
 onkeyup="KontrolaCisla(this, Cele)"/>
<INPUT type="hidden" name="err_jmno" value="0"> 



<td class="hmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" disabled="disabled" /></td>

<input class="hvstup" type="hidden" name="hladaj_uce" id="hladaj_uce" value="<?php echo $hladaj_uce;?>" />
<input class="hvstup" type="hidden" name="h_dok" id="h_dok" value="<?php echo $cislo_dok;?>" />
<input class="hvstup" type="hidden" name="h_uce" id="h_uce" value="0" />

<input class="hvstup" type="hidden" name="h_zmen" id="h_zmen" value="<?php echo $riadok->zmen;?>" />
<input class="hvstup" type="hidden" name="h_mena" id="h_mena" value="<?php echo $riadok->mena;?>" />
<input class="hvstup" type="hidden" name="h_pomr" id="h_pomr" value="1" />
<input class="hvstup" type="hidden" name="h_kurz" id="h_kurz" value="<?php echo $riadok->kurz;?>" />
<input class="hvstup" type="hidden" name="xdruh" id="xdruh" />

<input class="hvstup" type="hidden" name="h_ico" id="h_ico" />

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù" onclick="Zapis_COOK();" 
 onmouseover="UkazSkryj('Uloûiù poloûku do dokladu')" onmouseout="Okno.style.display='none';" >
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</FORM>

<td class="<?php echo $pvstup;?>" ></td>
<FORM name="formh4" method="post" action="vstobj.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=1" >
<td class="<?php echo $pvstup;?>" >
<INPUT type="submit" id="stornou" name="stornou" value="Zoznam" align="right"
 onmouseover="UkazSkryj('N·vrat do zoznamu dokladov')" onmouseout="Okno.style.display='none';">
</td>

</FORM>

<td class="<?php echo $pvstup;?>" ></td>
<FORM name="forma4" method="post" action="vsob_u.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
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
<FORM name="formv2" class="obyc" method="post" action="vstobj.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=16&
cislo_dok=<?php echo $riadok->dok;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="Vymazaù" 
 onmouseover="UkazSkryj('Vymazaù vybran˝ doklad')" onmouseout="Okno.style.display='none';" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="vstobj.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
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

<div id="myPrikuelement"></div>

<?php
// toto je koniec vymazanie faktury copern=6 a sluzby copern=7 
     }

$robot=1;
if( $drupoh != 4 ){ $cislista = include("ubyt_lista.php"); }
if( $drupoh == 4 ){ $cislista = include("../restauracia/rest_lista.php"); }
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
