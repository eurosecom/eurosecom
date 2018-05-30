<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$copern = 1*$_REQUEST['copern'];
$sys = 'MZD';

$uziv = include("../uziv.php");
if( !$uziv ) exit;
if(!isset($kli_vxcf)) $kli_vxcf = 1;


  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$sql = "SELECT * FROM F$kli_vxcf"."_vtvmzd";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvmzd = include("../mzdy/vtvmzd.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

// cislo operacie
$cislo_dm = strip_tags($_REQUEST['cislo_dm']);
$h_dm = strip_tags($_REQUEST['h_dm']);
$h_nzdm = strip_tags($_REQUEST['h_nzdm']);
$h_dndm = strip_tags($_REQUEST['h_dndm']);
$h_napzp = strip_tags($_REQUEST['h_napzp']);
$h_napnp = strip_tags($_REQUEST['h_napnp']);
$h_napsp = strip_tags($_REQUEST['h_napsp']);
$h_napip = strip_tags($_REQUEST['h_napip']);
$h_nappn = strip_tags($_REQUEST['h_nappn']);
$h_napup = strip_tags($_REQUEST['h_napup']);
$h_napgf = strip_tags($_REQUEST['h_napgf']);
$h_naprf = strip_tags($_REQUEST['h_naprf']);

$h_td = strip_tags($_REQUEST['h_td']);
$h_br = strip_tags($_REQUEST['h_br']);
$h_rh = strip_tags($_REQUEST['h_rh']);
$h_do = strip_tags($_REQUEST['h_do']);
$h_ne = strip_tags($_REQUEST['h_ne']);
$h_ho = strip_tags($_REQUEST['h_ho']);
$h_np = strip_tags($_REQUEST['h_np']);
$h_prn = strip_tags($_REQUEST['h_prn']);
$h_prm = strip_tags($_REQUEST['h_prm']);
$h_prv = strip_tags($_REQUEST['h_prv']);
$h_prs = strip_tags($_REQUEST['h_prs']);
$h_sa = strip_tags($_REQUEST['h_sa']);
$h_ko = strip_tags($_REQUEST['h_ko']);
$h_sax = strip_tags($_REQUEST['h_sax']);
$h_su = strip_tags($_REQUEST['h_su']);
$h_au = strip_tags($_REQUEST['h_au']);
$h_suc = strip_tags($_REQUEST['h_suc']);
$h_auc = strip_tags($_REQUEST['h_auc']);


//nacitanie standartnej 
    if ( $copern == 155 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù ötandartnÈ druhy miezd ?") )
         { window.close()  }
else
         { location.href='drmiezd.php?copern=156&page=1'  }
</script>
<?php
    }

    if ( $copern == 156 )
    {
$copern=1;

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzddmn SELECT * FROM mzddmn";
$dsql = mysql_query("$dsqlt");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012011dmpm ";
$vysledek = mysql_query("$sql");

if( $kli_vrok == 2012 )
{
//echo "idem";
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012012";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012012a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012012b";
$vysledek = mysql_query("$sql");

}

//koniec nacitania standartnej
    }


//uprava 
if ( $copern == 8 )
    {
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzddmn WHERE dm = $cislo_dm ".
"";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_dm = $riadok->dm;
$h_nzdm = $riadok->nzdm;
$h_dndm = $riadok->dndm;
$h_napzp = $riadok->nap_zp;
$h_napnp = $riadok->nap_np;
$h_napsp = $riadok->nap_sp;
$h_napip = $riadok->nap_ip;
$h_nappn = $riadok->nap_pn;
$h_napup = $riadok->nap_up;
$h_napgf = $riadok->nap_gf;
$h_naprf = $riadok->nap_rf;
$h_td = $riadok->td;
$h_br = $riadok->br;
$h_rh = $riadok->rh;
$h_do = $riadok->do;
$h_ne = $riadok->ne;
$h_ho = $riadok->ho;
$h_np = $riadok->np;
$h_prn = $riadok->prn;
$h_prm = $riadok->prm;
$h_prv = $riadok->prv;
$h_prs = $riadok->prs;
$h_sa = $riadok->sa;
$h_ko = $riadok->ko;
$h_sax = $riadok->sax;
$h_su = $riadok->su;
$h_au = $riadok->au;
$h_suc = $riadok->suc;
$h_auc = $riadok->auc;
  }
    }
//koniec copern=8 nacitanie

$uloz="NO";
$zmaz="NO";
$uprav="NO";
// 5=ulozenie polozky do databazy nahratej v drmiezd.php
// 6=vymazanie polozky potvrdene v drmiezd.php
if ( $copern == 15 || $copern == 16 )
     {
$cislo_dm = strip_tags($_REQUEST['cislo_dm']);
//ulozenie novej
if ( $copern == 15 )
    {

$h_dar = SqlDatum($h_dar);
$h_dsk = SqlDatum($h_dsk);
$uloztt = "INSERT INTO F$kli_vxcf"."_mzddmn".
" ( dm,nzdm,dndm,nap_zp,nap_np,nap_sp,nap_ip,nap_pn,nap_up,nap_gf,nap_rf,td,br,rh,do,ne,ho,np,prn,prm,prv,prs,sa,ko,sax,su,au,suc,auc )".
" VALUES ($h_dm, '$h_nzdm', '$h_dndm', '$h_napzp', '$h_napnp', '$h_napsp', '$h_napip', '$h_nappn', '$h_napup', '$h_napgf', '$h_naprf',".
" '$h_td', '$h_br', '$h_rh', '$h_do', '$h_ne', '$h_ho', '$h_np', '$h_prn',".
" '$h_prm', '$h_prv', '$h_prs', '$h_sa', '$h_ko', '$h_sax', '$h_su', '$h_au', '$h_suc', '$h_auc' ) "; 
//echo $uloztt;
$ulozene = mysql_query("$uloztt"); 

$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA dm:$h_dm SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_mzddmn WHERE dm='$cislo_dm'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA dm:$cislo_dm BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {

$cislo_dm = strip_tags($_REQUEST['cislo_dm']);
$h_dar = SqlDatum($h_dar);
$h_dsk = SqlDatum($h_dsk);

$upravene = mysql_query("UPDATE F$kli_vxcf"."_mzddmn SET nzdm='$h_nzdm', dndm='$h_dndm', ".
" nap_zp='$h_napzp', nap_np='$h_napnp', nap_sp='$h_napsp', nap_ip='$h_napip', nap_pn='$h_nappn', nap_up='$h_napup', nap_gf='$h_napgf', nap_rf='$h_naprf', ".
" td='$h_td', br='$h_br', rh='$h_rh', do='$h_do', ne='$h_ne', ho='$h_ho', np='$h_np', prn='$h_prn', ".
" prm='$h_prm', prv='$h_prv', prs='$h_prs', sa='$h_sa', ko='$h_ko', sax='$h_sax', su='$h_su', au='$h_au', suc='$h_suc', auc='$h_auc' WHERE dm='$cislo_dm'");  
$copern=1;
$cislo_dm = $h_dm;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA dm:$cislo_dm UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
  {
$cislo_dm = strip_tags($_REQUEST['h_dm']);
  }
//6=uprava
if ( $copern == 6 )
  {
$cislo_dm = strip_tags($_REQUEST['cislo_dm']);
  }


//echo $h_dar;
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Druhy mzdov˝ch zloûiek</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">

function UrobOnClick()
                {
      Fx.style.display='none';
                }

// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (Math.floor(b)==b && b>=x && b<=y) return true; 
         else {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         return false;
              } 
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
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }



<?php
//hladanie
  if ( $copern == 7 )
  {
?>
    function VyberVstup()
    {
    document.formhl1.hladaj_dndm.focus();
    }

<?php
  }
//koniec hladania
?>
<?php
//vymazanie
  if ( $copern == 6 OR $copern == 9 OR $copern == 16 )
  {
?>
    function VyberVstup()
    {

    }

    function ObnovUI()
    {

    }

<?php
  }
//koniec vymazania
?>

<?php
//zobrazenie
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 OR $copern == 4 )
  {
?>
//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; document.forma3.sstrana.disabled = true; }
     else { Oznam.style.display="none"; document.forma3.sstrana.disabled = false; }
    }

    function VyberVstup()
    {
    document.forma3.page.focus();
    document.forma3.page.select();
    }

    function ObnovUI()
    {

    var ii=1*<?php echo strip_tags($_REQUEST['page']);?>;
    if ( ii == 1 ) document.forma2.pstrana.disabled = true;
    <?php if( $zmaz == 'OK' ) echo "Zm.style.display='';";?>
    <?php if( $uprav == 'OK' ) echo "Up.style.display='';";?>
    }

<?php
  }
?>
<?php
//uprava
  if ( $copern == 8 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.h_dm.value = '<?php echo "$h_dm";?>';
    document.formv1.h_nzdm.value = '<?php echo "$h_nzdm";?>';
    document.formv1.h_dndm.value = '<?php echo "$h_dndm";?>';

    document.formv1.h_br.value = '<?php echo "$h_br";?>';
    document.formv1.h_rh.value = '<?php echo "$h_rh";?>';
    document.formv1.h_ne.value = '<?php echo "$h_ne";?>';
    document.formv1.h_ho.value = '<?php echo "$h_ho";?>';
    document.formv1.h_sa.value = '<?php echo "$h_sa";?>';
    document.formv1.h_ko.value = '<?php echo "$h_ko";?>';
    document.formv1.h_sax.value = '<?php echo "$h_sax";?>';
    document.formv1.h_su.value = '<?php echo "$h_su";?>';
    document.formv1.h_au.value = '<?php echo "$h_au";?>';
    document.formv1.h_suc.value = '<?php echo "$h_suc";?>';
    document.formv1.h_auc.value = '<?php echo "$h_auc";?>';

    }

<?php
//koniec uprava
  }
//uprava,nova
  if ( $copern == 5 OR $copern == 8 OR $copern == 15 OR $copern == 8 )
  {
?>

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
//   Vstup.value = Vstup.value.replace ( ',','.' );
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

    function Zapis_COOK()
    {

    return (true);
    }

    function Obnov_vstup()
    {

    return (true);
    }

//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; document.formv1.uloz.disabled = true; }
     else { Oznam.style.display="none"; }
    }

    function VyberVstup()
    {
    <?php if( $copern == 5 ) echo "document.formv1.h_dm.focus();"; ?>
    <?php if( $copern == 5 ) echo "document.formv1.h_dm.select();"; ?>
    <?php if( $copern == 8 ) echo "document.formv1.h_nzdm.focus();"; ?>
    <?php if( $copern == 8 ) echo "document.formv1.h_nzdm.select();"; ?>
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_dm.value == '' ) okvstup=0;
    if ( document.formv1.h_nzdm.value == '' ) okvstup=0;

    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }

    }

<?php
//koniec nova,uprava
  }
?>

<?php
//nova
  if ( $copern == 5 )
  { 
?>
    function ObnovUI()
    {
<?php if( $uloz == 'OK' ) echo "Ul.style.display='';";?>
    }

<?php
//koniec nova
  }
?>


    function TlacDmn()
    {

window.open('dmn_pdf.php?copern=20&drupoh=1&page=1', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
    }



  </script>
</HEAD>

<BODY class="white" onload="ObnovUI(); VyberVstup();" >



<?php 
// aktualna strana
$page = strip_tags($_REQUEST['page']);
//nasledujuca strana
$npage =  $page + 1;
// predchadzajuca strana
$ppage =  $page - 1;
// pocet poloziek na stranu
$pols = 10;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);
?>


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Druhy mzdov˝ch zloûiek
<?php
  if ( $copern == 5 ) echo "- nov· poloûka";
  if ( $copern == 8 ) echo "- ˙prava poloûky";
  if ( $copern == 6 ) echo "- vymazanie poloûky";
?>
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<?php
// toto je cast na zobrazenie tabulky a prechody medzi stranami
// 1=volanie z menu.php
// 2=dalsia strana
// 3=predosla strana
// 4=prejst na stranu
// 5=nova polozka
// 6=mazanie
// 7=hladanie
// 8=uprava
// 9=hladanie
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5|| $copern == 6 || $copern == 7 || $copern == 8 || $copern == 9 )
     {

if ( $copern != 1 && $copern != 2 && $copern != 3 && $copern != 4 && $copern != 5 && $copern != 6 && $copern != 7 && $copern != 8 && $copern != 9 ) break;

    do
    {
// zobraz vsetko co je v tabulke
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5 || $copern == 6 || $copern == 8 || $copern == 7 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddmn ORDER BY dm");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_dndm = strip_tags($_REQUEST['hladaj_dndm']);
$hladaj_nzdm = strip_tags($_REQUEST['hladaj_nzdm']);
$hladaj_dm = strip_tags($_REQUEST['hladaj_dm']);

if ( $hladaj_nzdm != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddmn WHERE ( nzdm LIKE '%$hladaj_nzdm%' ) ORDER BY dm");
if ( $hladaj_dndm != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddmn WHERE ( dndm LIKE '%$hladaj_dndm%' ) ORDER BY dm");
if ( $hladaj_dm != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddmn WHERE ( dm = '$hladaj_dm' ) ORDER BY dm");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddmn WHERE dm >= 0 ORDER BY dm");

  }

// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;
// pocet stran
$xstr =1*(ceil($cpol / $pols));
if ( $xstr == 0 ) $xstr=1;
?>

<table class="fmenu" width="100%" >

<?php
//nezobraz hladanie pre novu,upravu a mazanie
if ( $copern != 5 AND $copern != 6 AND $copern != 8 )
     {
?>
<tr>
<FORM name="formhl1" class="hmenu" method="post" action="drmiezd.php?sys=<?php echo $sys; ?>&page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
<td class="hmenu" >

<img src='../obr/tlac.png' onClick='TlacDmn();' width=20 height=12 border=0 title="TlaË ËÌselnÌka mzdov˝ch zloûiek" >
</td>
<td class="hmenu" ></td>
<td class="hmenu" >
<?php
if ( $kli_vrok > 2017 )
  {
?>
<img src='../obr/zoznam.png' onclick="window.open('drmiezd_export.php?sys=<?php echo $sys; ?>&copern=1519&page=1&dopln=2', '_self');" 
width=20 height=15 border=0 title="Doplniù ËÌselnÌk mzdov˝ch zloûiek z ../import/pomer<?php echo $kli_vrok; ?>doplnpripl.csv o prÌplatky 201, 202, 203, 204, 223 a 13.plat" >
PrÌplatky a 13.plat 2018
<?php
  }
?>
</td>
<td class="hmenu" colspan="2">
<?php
if ( $kli_uzall > 25000 )
  {
?>
<img src='../obr/orig.png' onclick="window.open('drmiezd_export.php?sys=<?php echo $sys; ?>&copern=1519&page=1', '_self');" 
width=20 height=15 border=0 title="NaËÌtaù ötandartn˝ ËÌselnÌk mzdov˝ch zloûiek z ../import/dmn<?php echo $kli_vrok; ?>.csv" >
 - 
<img src='../obr/export.png' onclick="window.open('drmiezd_export.php?sys=<?php echo $sys; ?>&copern=19&page=1', '_self');" 
width=20 height=15 border=0 title="Exportovaù ËÌselnÌk mzdov˝ch zloûiek do s˙boru CSV" >
 - 
<img src='../obr/kos.png' onclick="window.open('drmiezd_export.php?sys=<?php echo $sys; ?>&copern=1819&page=1', '_self');" 
width=20 height=15 border=0 title="Vymazaù ËÌselnÌk mzdov˝ch zloûiek" >
 - 
<?php
  }
?>
<img src='../obr/zoznam.png' onclick="window.open('drmiezd_export.php?sys=<?php echo $sys; ?>&copern=1519&page=1&dopln=1', '_self');" 
width=20 height=15 border=0 title="Doplniù ËÌselnÌk mzdov˝ch zloûiek z ../import/dmn<?php echo $kli_vrok; ?>dopln.csv" >
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_dm" id="hladaj_dm" size="11" value="<?php echo $hladaj_dm;?>" />
<td class="hmenu"><input type="text" name="hladaj_nzdm" id="hladaj_nzdm" size="20" value="<?php echo $hladaj_nzdm;?>" /> 

<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="drmiezd.php?sys=<?php echo $sys; ?>&page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<td class="hmenu" width="10%" >ËÌslo</td>
<td class="hmenu" width="25%" >n·zov</td>
<td class="hmenu" width="20%" >dlh˝ n·zov</td>
<td class="hmenu" width="35%" >Do z·kladov pre fondy</td>
<td class="hmenu" width="5%" >Uprav</td>
<td class="hmenu" width="5%" >Zmaû</td>

<?php
   while ($i <= $konc )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="fmenu" ><?php echo $riadok->dm;?></td>
<td class="fmenu" ><?php echo $riadok->nzdm;?></td>
<td class="fmenu" ><?php echo $riadok->dndm;?></td>
<td class="fmenu" >
N·poËet ZP<?php echo $riadok->nap_zp;?>,NP<?php echo $riadok->nap_np;?>,SP<?php echo $riadok->nap_sp;?>,
IP<?php echo $riadok->nap_ip;?>,PN<?php echo $riadok->nap_pn;?>,UP<?php echo $riadok->nap_up;?>,
GF<?php echo $riadok->nap_gf;?>,RF<?php echo $riadok->nap_rf;?>
</td>
<td class="fmenu" width="5%" ><a href='drmiezd.php?sys=<?php echo $sys; ?>&copern=8&page=<?php echo $page;?>&cislo_dm=<?php echo $riadok->dm;?>&h_dm=<?php echo $riadok->dm;?>'>
 <img src='../obr/uprav.png' width=20 height=20 border=0 title="⁄prava ˙dajov"></a></td>
<td class="fmenu" width="5%" ><a href='drmiezd.php?sys=<?php echo $sys; ?>&copern=6&page=<?php echo $page;?>&cislo_dm=<?php echo $riadok->dm;?>'>Zmaû</a></td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>
</table>
<table class="fmenu" width="100%" >
<tr><td><?php echo "Strana:$page  Celkom poloûiek/str·n v celej tabulke:$cpol/$xstr ";?></td></tr>
</table>
<?php
//mysql_close();
mysql_free_result($sql);
    } while (false);
//koniec 1,2,3,4,5,6,7,8,9
?>

<?php
// 6=vymazanie polozky
if ( $copern == 6 )
  {
$cislo_dm = strip_tags($_REQUEST['cislo_dm']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_mzddmn WHERE dm='$cislo_dm'";
$sql = mysql_query("$sqlp");
?>
<table class="fmenu" width="100%" >
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<td class="fmenu"  width="10%" ><?php echo $zaznam["dm"];?></td>
<td class="fmenu"  width="25%" ><?php echo $zaznam["nzdm"];?></td>
<td class="fmenu"  width="20%" ><?php echo $zaznam["dndm"];?></td>
<td class="fmenu"  width="35%" > </td>
<td class="fmenu"  width="5%" ></td>
<td class="fmenu"  width="5%" ></td>
</tr>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="drmiezd.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=16>&cislo_dm=<?php echo $cislo_dm;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="drmiezd.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornom" name="stornom" value="Storno nevymazaù" ></td>
</tr>
</FORM>
</table>

<?php
//mysql_close();
mysql_free_result($sql);
  }
//koniec pre vymazanie
?>

<?php
//zobraz pre novu polozku
if ( $copern == 5 OR $copern == 8 )
     {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Bx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 DM musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka dm=<?php echo $h_dm;?> spr·vne uloûen·</span>
<span id="Des4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù desatinnÈ ËÌslo v rozsahu 0.0001 aû 99999999 max. 4 desatinnÈ miesta</span>
</tr>
<tr>

<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="drmiezd.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_dm=$cislo_dm"; } ?>
" >

<tr></tr><tr></tr><tr></tr>
<tr>
<td class="hmenu" width="5%"></td><td class="hmenu" width="5%"></td><td class="hmenu" width="5%"></td><td class="hmenu" width="5%"></td>
<td class="hmenu" width="5%"></td><td class="hmenu" width="5%"></td><td class="hmenu" width="5%"></td><td class="hmenu" width="5%"></td>
<td class="hmenu" width="5%"></td><td class="hmenu" width="5%"></td><td class="hmenu" width="5%"></td><td class="hmenu" width="5%"></td>
<td class="hmenu" width="5%"></td><td class="hmenu" width="5%"></td><td class="hmenu" width="5%"></td><td class="hmenu" width="5%"></td>
</tr>
<tr>
<td class="hmenu" colspan="1">»Ìslo:</td>
<td class="fmenu" colspan="1">
<?php
if ( $copern == 5 )
     {
?>
<input type="text" name="h_dm" id="h_dm" size="4"
onchange="return intg(this,1,9999,Bx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Bx)" />*</td>
<?php
     }
?>
<?php
if ( $copern == 8 )
     {
echo " ".$h_dm;
?>
<input type="hidden" name="h_dm" id="h_dm" /></td>
<?php
     }
?>
<td class="hmenu" colspan="2">N·zov:</td>
<td class="fmenu" colspan="7">
<input type="text" name="h_nzdm" id="h_nzdm" size="60" onclick="Fx.style.display='none';" />*</td>
</tr>
<tr></tr>
<tr>
<td class="hmenu" colspan="2"></td>
<td class="hmenu" colspan="2">⁄pln˝ n·zov:
 <img src='../obr/info.png' width=12 height=12 border=0 title="⁄pln˝ n·zov mzdovej poloûky">
</td>
<td class="fmenu" colspan="7">
<input type="text" name="h_dndm" id="h_dndm" size="60" onclick="Fx.style.display='none';" /></td>
</tr>
<tr></tr>
<tr>
<td class="hmenu" colspan="2">N·poËet do z·kladov fondov
 <img src='../obr/info.png' width=12 height=12 border=0 title="Zaökrtnut· poloûka znamen· , ûe t·to mzdov· zloûka sa napoËÌta do z·kladu prÌsluönÈho fondu">
</td>
<td class="hmenu" colspan="1">ZP
 <input type="checkbox" name="h_napzp" value="1"  /><?php if ( $h_napzp == 1 ) { ?>
<script type="text/javascript">
document.formv1.h_napzp.checked = "checked";
</script> <?php                                                                } ?>
<td class="hmenu" colspan="1">NP
 <input type="checkbox" name="h_napnp" value="1"  /><?php if ( $h_napnp == 1 ) { ?>
<script type="text/javascript">
document.formv1.h_napnp.checked = "checked";
</script> <?php                                                                } ?>
</td>
<td class="hmenu" colspan="1">SP
 <input type="checkbox" name="h_napsp" value="1"  /><?php if ( $h_napsp == 1 ) { ?>
<script type="text/javascript">
document.formv1.h_napsp.checked = "checked";
</script> <?php                                                                } ?>
</td>
<td class="hmenu" colspan="1">IP
 <input type="checkbox" name="h_napip" value="1"  /><?php if ( $h_napip == 1 ) { ?>
<script type="text/javascript">
document.formv1.h_napip.checked = "checked";
</script> <?php                                                                } ?>
</td>
<td class="hmenu" colspan="1">PvN
 <input type="checkbox" name="h_nappn" value="1"  /><?php if ( $h_nappn == 1 ) { ?>
<script type="text/javascript">
document.formv1.h_nappn.checked = "checked";
</script> <?php                                                                } ?>
</td>
<td class="hmenu" colspan="1">UP
 <input type="checkbox" name="h_napup" value="1"  /><?php if ( $h_napup == 1 ) { ?>
<script type="text/javascript">
document.formv1.h_napup.checked = "checked";
</script> <?php                                                                } ?>
</td>
<td class="hmenu" colspan="1">GF
 <input type="checkbox" name="h_napgf" value="1"  /><?php if ( $h_napgf == 1 ) { ?>
<script type="text/javascript">
document.formv1.h_napgf.checked = "checked";
</script> <?php                                                                } ?>
</td>
<td class="hmenu" colspan="1">RF
 <input type="checkbox" name="h_naprf" value="1"  /><?php if ( $h_naprf == 1 ) { ?>
<script type="text/javascript">
document.formv1.h_naprf.checked = "checked";
</script> <?php                                                                } ?>
</td>
</tr>
<tr></tr>



<tr>
<td class="hmenu" colspan="3"></td>
</tr>
<tr></tr>

<tr>
<td class="hmenu" colspan="3">TD NezdaÚovaù
 <img src='../obr/info.png' width=12 height=12 border=0 title="Zaökrtnut· poloûka znamen· , ûe mzdov· zloûka nie je zdaÚovan· a nenapoËÌta sa do z·kladu dane z prÌjmu">
 <input type="checkbox" name="h_td" value="1"  /><?php if ( $h_td == 1 ) { ?>
<script type="text/javascript">
document.formv1.h_td.checked = "checked";
</script> <?php                                                                } ?>
</td>

<td class="hmenu" colspan="3">BR Druh zloûky
 <img src='../obr/info.png' width=12 height=12 border=0 title="1=z·klad alebo n·hrady, 2=nemocenkÈ v˝platy, 3=zr·ûky, 4=cestovnÈ">
<input class="fmenu" type="text" name="h_br" id="h_br" size="2" maxlength="1" 
 onclick="UrobOnClick()"
 onchange="return intg(this,1,6,Cele,document.formv1.err_br)" onkeyup="KontrolaCisla(this, Cele)"  />
</td>

<td class="hmenu" colspan="3">RH Odbory
 <img src='../obr/info.png' width=12 height=12 border=0 title="N·poËet zloûky do z·kladu odborov 0-nie, 1-·no">
<input class="fmenu" type="text" name="h_rh" id="h_rh" size="2" maxlength="1" 
 onclick="UrobOnClick()"
 onchange="return intg(this,0,2,Cele,document.formv1.err_rh)" onkeyup="KontrolaCisla(this, Cele)"  />
</td>

<td class="hmenu" colspan="3">DO Dovolenka
 <img src='../obr/info.png' width=12 height=12 border=0 title="Zaökrtnut· poloûka znamen· , ûe dni mzdovej zloûky sa napoËÌtaj˙ do Ëerpanej dovolenky">
 <input type="checkbox" name="h_do" value="1"  /><?php if ( $h_do == 1 ) { ?>
<script type="text/javascript">
document.formv1.h_do.checked = "checked";
</script> <?php                                                                } ?>
</td>

<td class="hmenu" colspan="3">NE NeodpracovanÈ
 <img src='../obr/info.png' width=12 height=12 border=0 title="Neodpracovan˝ Ëas (zniûuje hodiny z·kladnÈho platu) 0-nie, 1-·no, 2-zvyöuje hodiny">
<input class="fmenu" type="text" name="h_ne" id="h_ne" size="2" maxlength="1" 
 onclick="UrobOnClick()"
 onchange="return intg(this,0,2,Cele,document.formv1.err_ne)" onkeyup="KontrolaCisla(this, Cele)"  />
</td>
</tr>
<tr></tr>

<tr>
<td class="hmenu" colspan="3">HO Hodiny
 <img src='../obr/info.png' width=12 height=12 border=0 title="NapoËÌtaù hodiny do odpracovan˝ch 0-nie, 1-odpracovanÈ, 2-n·hrady alebo nemoc">
<input class="fmenu" type="text" name="h_ho" id="h_ho" size="2" maxlength="1" 
 onclick="UrobOnClick()"
 onchange="return intg(this,1,2,Cele,document.formv1.err_ho)" onkeyup="KontrolaCisla(this, Cele)"  />
</td>

<td class="hmenu" colspan="3">NP Dni
 <img src='../obr/info.png' width=12 height=12 border=0 title="Zaökrtnut· poloûka znamen· , ûe dni mzdovej zloûky sa napoËÌtaj˙ do odpracovan˝ch dnÌ">
 <input type="checkbox" name="h_np" value="1"  /><?php if ( $h_np == 1 ) { ?>
<script type="text/javascript">
document.formv1.h_np.checked = "checked";
</script> <?php                                                                } ?>
</td>

<td class="hmenu" colspan="3">PRN priemer n·hrad
 <img src='../obr/info.png' width=12 height=12 border=0 title="Zaökrtnut· poloûka znamen· , ûe mzdov· zloûka sa napoËÌta do v˝poËtu priemerov na n·hrady">
 <input type="checkbox" name="h_prn" value="1"  /><?php if ( $h_prn == 1 ) { ?>
<script type="text/javascript">
document.formv1.h_prn.checked = "checked";
</script> <?php                                                                } ?>
</td>

<td class="hmenu" colspan="3">PRM priemer nemoc
 <img src='../obr/info.png' width=12 height=12 border=0 title="Zaökrtnut· poloûka znamen· , ûe mzdov· zloûka sa napoËÌta do v˝poËtu priemerov na nemoc">
 <input type="checkbox" name="h_prm" value="1"  /><?php if ( $h_prm == 1 ) { ?>
<script type="text/javascript">
document.formv1.h_prm.checked = "checked";
</script> <?php                                                                } ?>
</td>

<td class="hmenu" colspan="3">PRS soc.fond
 <img src='../obr/info.png' width=12 height=12 border=0 title="Zaökrtnut· poloûka znamen· , ûe mzdov· zloûka sa napoËÌta do z·kladu pre v˝poËet soci·lneho fondu">
 <input type="checkbox" name="h_prs" value="1"  /><?php if ( $h_prs == 1 ) { ?>
<script type="text/javascript">
document.formv1.h_prs.checked = "checked";
</script> <?php                                                                } ?>
</td>

</tr>
<tr></tr>

<tr>
<td class="hmenu" colspan="3">SA Sadzba Ä
 <img src='../obr/info.png' width=12 height=12 border=0 title="Sadzba v Ä na hodinu pre KO=40
Koæko % z priemeru na n·hrady z kmeÚov˝ch ˙dajov pre KO=20
Koæko % zo sadzby z kmeÚov˝ch ˙dajov pre KO=30
">
<input type="text" name="h_sa" id="h_sa" size="8" 
 onclick="UrobOnClick();"
 onchange="return cele(this,0,99999999,Des4,4,document.formv1.err_sa)" 
 onkeyup="KontrolaDcisla(this, Des4)"  />
<INPUT type="hidden" name="err_sa" >

</td>
</td>
<td class="hmenu" colspan="3">KO Koeficient
 <img src='../obr/info.png' width=12 height=12 border=0 
title="     KO = 20 sadzba=priemer na n·hrady z kmeÚov˝ch ˙dajov
     KO = 30 sadzba=sadzba z kmeÚov˝ch ˙dajov
     KO = 40 sadzba=hodnota v sadzbe z ËÌselnÌka miezd
     KO = 50 sadzba=sadzba a mnoûstvo z tabuæky mzdov˝ch sadzieb
     KO = 60 sadzba=priemer na nemoc. z kmeÚov˝ch ˙dajov">
<input class="fmenu" type="text" name="h_ko" id="h_ko" size="3" maxlength="3" 
 onclick="UrobOnClick();"
 onchange="return intg(this,0,100,Cele,document.formv1.err_ko)" onkeyup="KontrolaCisla(this, Cele)"
  />
<INPUT type="hidden" name="err_ko" >
</td>
<td class="hmenu" colspan="3">SAX »Ìslo sadzby
 <img src='../obr/info.png' width=12 height=12 border=0 
title="»Ìslo sadzby z kmeÚov˝ch ˙dajov ak KO=30/39">
<input class="fmenu" type="text" name="h_sax" id="h_sax" size="3" maxlength="1" 
 onclick="UrobOnClick()"
 onchange="return intg(this,0,5,Cele,document.formv1.err_sax)" onkeyup="KontrolaCisla(this, Cele)"  />
<INPUT type="hidden" name="err_sax" >
</td>

</tr>
<tr></tr>

<tr>

<td class="hmenu" colspan="2">SU
 <img src='../obr/info.png' width=12 height=12 border=0 title="Syntetick˝ ˙Ëet">
<input class="fmenu" type="text" name="h_su" id="h_su" size="3" maxlength="3" 
 onclick="UrobOnClick()"
 onchange="return intg(this,0,999,Cele,document.formv1.err_br)" onkeyup="KontrolaCisla(this, Cele)"  />
</td>

<td class="hmenu" colspan="2">AU
 <img src='../obr/info.png' width=12 height=12 border=0 title="Analytick˝ ˙Ëet">
<input class="fmenu" type="text" name="h_au" id="h_au" size="3" maxlength="3" 
 onclick="UrobOnClick()"
 onchange="return intg(this,0,999,Cele,document.formv1.err_br)" onkeyup="KontrolaCisla(this, Cele)"  />
</td>

<td class="hmenu" colspan="2">SUC
 <img src='../obr/info.png' width=12 height=12 border=0 title="Syntetick˝ ˙Ëet - majiteæ,konateæ">
<input class="fmenu" type="text" name="h_suc" id="h_suc" size="3" maxlength="3" 
 onclick="UrobOnClick()"
 onchange="return intg(this,0,999,Cele,document.formv1.err_br)" onkeyup="KontrolaCisla(this, Cele)"  />
</td>

<td class="hmenu" colspan="2">AUC
 <img src='../obr/info.png' width=12 height=12 border=0 title="Analytick˝ ˙Ëet - majiteæ,konateæ">
<input class="fmenu" type="text" name="h_auc" id="h_auc" size="3" maxlength="3" 
 onclick="UrobOnClick()"
 onchange="return intg(this,0,999,Cele,document.formv1.err_br)" onkeyup="KontrolaCisla(this, Cele)"  />
</td>

</tr>
<tr></tr>

<tr></tr>
<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td class="obyc"></td><td class="obyc"></td><td class="obyc"></td><td class="obyc"></td><td class="obyc"></td><td class="obyc"></td>
<td class="obyc" align="right"></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="drmiezd.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornou" name="stornou" value="Sp‰ù-Zoznam" ></td>
</tr>
</FORM>
</table>
<?php
     }
//koniec zobrazenia pre novu polozku
//nezobraz pre novu,upravu a mazanie
if ( $copern != 5 AND $copern != 6 AND $copern != 8 )
     {
?>
<tr>
<span id="Ax" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Zadajte ËÌslo strany - ˙daj musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Zm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $cislo_dm;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $cislo_dm;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="drmiezd.php?sys=<?php echo $sys; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_dm=$hladaj_dm&hladaj_dndm=$hladaj_dndm&hladaj_nzdm=$hladaj_nzdm&hladaj_zamnp=$hladaj_zamnp";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="drmiezd.php?sys=<?php echo $sys; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_dm=$hladaj_dm&hladaj_dndm=$hladaj_dndm&hladaj_nzdm=$hladaj_nzdm&hladaj_zamnp=$hladaj_zamnp";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="drmiezd.php?sys=<?php echo $sys; ?>&copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="drmiezd.php?sys=<?php echo $sys; ?>&copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
<INPUT type="submit" id="npol" value="Vloûiù nov˙ poloûku" >
</FORM>
</td>
</tr>
</table>

<?php
     }
//koniec nezobraz pre novu,upravu a mazanie
?>


<?php
// toto je koniec casti na zobrazenie tabulky a prechody medzi stranami 
     }

// celkovy koniec dokumentu


$cislista = include("../mzdy/mzd_lista.php");

       } while (false);
?>
</BODY>
</HTML>
