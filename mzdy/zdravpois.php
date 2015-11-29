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

$sql = "ALTER TABLE F$kli_vxcf"."_zdravpois MODIFY iban VARCHAR(50) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_zdravpois MODIFY pt3 VARCHAR(35) NOT NULL ";
$vysledek = mysql_query("$sql");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

// cislo operacie
$cislo_zdrv = strip_tags($_REQUEST['cislo_zdrv']);
$h_zdrv = strip_tags($_REQUEST['h_zdrv']);
$h_nzdr = strip_tags($_REQUEST['h_nzdr']);
$h_uceb = strip_tags($_REQUEST['h_uceb']);
$h_numb = strip_tags($_REQUEST['h_numb']);
$h_vsy = strip_tags($_REQUEST['h_vsy']);
$h_ksy = strip_tags($_REQUEST['h_ksy']);
$h_ssy = strip_tags($_REQUEST['h_ssy']);
$h_iban = strip_tags($_REQUEST['h_iban']);
$h_pbic = strip_tags($_REQUEST['h_pbic']);
$h_pz1 = strip_tags($_REQUEST['h_pz1']);
$h_pz2 = strip_tags($_REQUEST['h_pz2']);

//standartny ciselnik ZP
    if ( $copern == 155 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù ötandartn˝ ËÌselnÌk ZP ?") )
         { window.close()  }
else
         { location.href='zdravpois.php?sys=<?php echo $sys; ?>&copern=156&page=1'  }
</script>
<?php
    }
    if ( $copern == 156 )
    {
$copern=1;

$ttvv = "INSERT INTO F$kli_vxcf"."_zdravpois ( zdrv,nzdr ) VALUES ( '2108', 'SpoloËn· zdravotn· poisùovÚa' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_zdravpois ( zdrv,nzdr ) VALUES ( '2700', 'UNION' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_zdravpois ( zdrv,nzdr ) VALUES ( '2300', 'DÙvera rok 2009' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_zdravpois ( zdrv,nzdr ) VALUES ( '2400', 'DÙvera ZP' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_zdravpois ( zdrv,nzdr ) VALUES ( '2408', 'Apollo' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_zdravpois ( zdrv,nzdr ) VALUES ( '2508', 'Vöeobecn· zdravotn· poisùovÚa' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_zdravpois ( zdrv,nzdr ) VALUES ( '0', 'éiadna Zdravotn· PoisùovÚa' )";
$ttqq = mysql_query("$ttvv");

    }
//koniec nacitat standartny ZP

//import z ../import/ZDRAVPOIS.CSV
    if ( $copern == 55 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete importovaù poloûky \r zo s˙boru ../import/FIR<?php echo $kli_vxcf; ?>/ZDRVPOIS.CSV , MZDDMN.CSV, MZDPOMER.CSV ?") )
         { window.close()  }
else
         { location.href='zdravpois.php?sys=<?php echo $sys; ?>&copern=56&page=1'  }
</script>
<?php
    }
    if ( $copern == 56 )
    {
$copern=1;

if( file_exists("../import/FIR$kli_vxcf/ZDRVPOIS.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/ZDRVPOIS.CSV existuje<br />";

$subor = fopen("../import/FIR$kli_vxcf/ZDRVPOIS.CSV", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_zdrv = $pole[0];
  $x_nzdr = $pole[1];
  $x_uceb = $pole[2];
  $x_numb = $pole[3];
  $x_vsy = $pole[4];
  $x_ksy = $pole[5];
  $x_ssy = $pole[6];
  $x_kon = $pole[7];
 
$sqult = "INSERT INTO F$kli_vxcf"."_zdravpois ( zdrv,nzdr,uceb,numb,vsy,ksy,ssy )".
" VALUES ( '$x_zdrv', '$x_nzdr', '$x_uceb', '$x_numb', '$x_vsy', '$x_ksy', '$x_ssy' ); "; 

$squpd = "UPDATE F$kli_vxcf"."_mzdprm SET uced='$x_uceb', numd='$x_numb', vsyd='$x_vsy', ksyd='$x_ksy', ssyd='$x_ssy' "; 
$squps = "UPDATE F$kli_vxcf"."_mzdprm SET uces='$x_uceb', nums='$x_numb', vsys='$x_vsy', ksys='$x_ksy', ssys='$x_ssy' "; 

//echo $sqult;

$c_zdrv=1*$x_zdrv;
if( $c_zdrv > 0 AND $c_zdrv != 6666 AND $c_zdrv != 8881 ) { $ulozene = mysql_query("$sqult"); }
if( $c_zdrv > 0 AND $c_zdrv == 6666 ) { $ulozene = mysql_query("$squpd"); }
if( $c_zdrv > 0 AND $c_zdrv == 8881 ) { $ulozene = mysql_query("$squps"); }

}

echo "Tabulka F$kli_vxcf"."_zdravpois!"." naimportovan· <br />";

fclose ($subor);

if( file_exists("../import/FIR$kli_vxcf/MZDDMN.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/MZDDMN.CSV existuje<br />";

$subor = fopen("../import/FIR$kli_vxcf/MZDDMN.CSV", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_dm = $pole[0];
  $x_na = $pole[1];
  $x_td = $pole[2];
  $x_napzp = $pole[3];
  $x_napnp = $pole[4];
  $x_napsp = $pole[5];
  $x_napip = $pole[6];
  $x_nappn = $pole[7];
  $x_napup = $pole[8];
  $x_napgf = $pole[9];
  $x_naprf = $pole[10];

  $x_br = $pole[11];
  $x_rh = $pole[12];
  $x_do = $pole[13];
  $x_ne = $pole[14];
  $x_ho = $pole[15];
  $x_np = $pole[16];
  $x_prn = $pole[17];
  $x_prm = $pole[18];
  $x_prv = $pole[19];
  $x_prs = $pole[20];
  $x_sa = $pole[21];
  $x_ko = $pole[22];
  $x_sax = $pole[23];
  $x_su = $pole[24];
  $x_au = $pole[25];
  $x_suc = $pole[26];
  $x_auc = $pole[27];

  $x_kon = $pole[28];

$c_sa=100*$x_sa;

$c_td=1*$x_td;
if( $c_td > 1 ) $x_td=1; 
$c_br=1*$x_br;
if( $c_br > 3 ) $x_br=1;

$sqult = "INSERT INTO F$kli_vxcf"."_mzddmn ( dm,nzdm,dndm,td,nap_zp,nap_np,nap_sp,nap_ip,nap_pn,nap_up,nap_gf,nap_rf,".
" br,rh,do,ne,ho,np,prn,prm,prv,prs,sa,ko,sax,su,au,suc,auc )".
" VALUES ( '$x_dm', '$x_na', '$x_na', '$x_td', '$x_napzp', '$x_napnp', '$x_napsp', '$x_napip', '$x_nappn', '$x_napup', '$x_napgf', '$x_naprf',".
" '$x_br', '$x_rh', '$x_do', '$x_ne', '$x_ho', '$x_np', '$x_prn', '$x_prm', '$x_prv', '$x_prs',".
" '$c_sa', '$x_ko', '$x_sax', '$x_su', '$x_au',".
" '$x_suc', '$x_auc' ); "; 

//echo $sqult;

$c_dm=1*$x_dm;

if( $c_dm > 0 ) { $ulozene = mysql_query("$sqult"); }

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012011dmpm ";
$vysledek = mysql_query("$sql");

}

echo "Tabulka F$kli_vxcf"."_mzddmn!"." naimportovan· <br />";

fclose ($subor);

//osetrenie ak br > 3 alebo br=0 br=1
$sqult = "UPDATE F$kli_vxcf"."_mzddmn br=1 WHERE br = 0 OR br > 3 "; 
$ulozene = mysql_query("$sqult"); 


if( file_exists("../import/FIR$kli_vxcf/MZDPOMER.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/MZDPOMER.CSV existuje<br />";

$subor = fopen("../import/FIR$kli_vxcf/MZDPOMER.CSV", "r");
while (! feof($subor))
{

  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_pm = $pole[0];
  $x_nzpm = $pole[1];
  $x_zamzp = $pole[2];
  $x_zamnp = $pole[3];
  $x_zamsp = $pole[4];
  $x_zamip = $pole[5];
  $x_zampn = $pole[6];
  $x_zamup = $pole[7];
  $x_zamgf = $pole[8];
  $x_zamrf = $pole[9];
  $x_firzp = $pole[10];
  $x_firnp = $pole[11];
  $x_firsp = $pole[12];
  $x_firip = $pole[13];
  $x_firpn = $pole[14];
  $x_firup = $pole[15];
  $x_firgf = $pole[16];
  $x_firrf = $pole[17];

  $x_zamzm = $pole[18];
  $x_pmdoh = $pole[19];
  $x_pmmaj = $pole[20];
  $x_npsoc = $pole[21];

  $x_kon = $pole[22];


$sqult = "INSERT INTO F$kli_vxcf"."_mzdpomer ( pm,nzpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf,".
" zam_zm,pm_doh,pm_maj,np_soc )".
" VALUES ( '$x_pm', '$x_nzpm', '$x_zamzp', '$x_zamnp', '$x_zamsp', '$x_zamip', '$x_zampn', '$x_zamup', '$x_zamgf', '$x_zamrf',".
" '$x_firzp', '$x_firnp', '$x_firsp', '$x_firip', '$x_firpn', '$x_firup', '$x_firgf', '$x_firrf',".
" '$x_zamzm', '$x_pmdoh', '$x_pmmaj', '$x_npsoc' ); "; 

//echo $sqult;

$c_pm=1*$x_pm;
if( $x_pm != '' ) { $ulozene = mysql_query("$sqult"); }


}

echo "Tabulka F$kli_vxcf"."_mzdpomer!"." naimportovan· <br />";

fclose ($subor);

    }

//vymazanie vsetkych poloziek
    if ( $copern == 67 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky poloûky \r zoznamu zdravotn˝ch poisùovnÌ , druhov miezd a druhov pomerov ?") )
         { window.close()  }
else
         { location.href='zdravpois.php?sys=<?php echo $sys; ?>&copern=167&page=1'  }
</script>
<?php
    }
    if ( $copern == 167 )
    {
$copern=1;
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_zdravpois';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_zdravpois!"." vynulovan· <br />";

$sqlt = 'TRUNCATE F'.$kli_vxcf.'_mzddmn';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_mzddmn!"." vynulovan· <br />";

$sqlt = 'TRUNCATE F'.$kli_vxcf.'_mzdpomer';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_mzdpomer!"." vynulovan· <br />";
    }


//uprava 
if ( $copern == 8 )
    {
$sqltt = "SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv = $cislo_zdrv ".
"";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_zdrv = $riadok->zdrv;
$h_nzdr = $riadok->nzdr;
$h_uceb = $riadok->uceb;
$h_numb = $riadok->numb;
$h_vsy = $riadok->vsy;
$h_ksy = $riadok->ksy;
$h_ssy = $riadok->ssy;
$h_iban = $riadok->iban;
$h_pbic = $riadok->pt3;
$h_pz1 = $riadok->pz1;
$h_pz2 = $riadok->pz2;
  }
    }
//koniec copern=8 nacitanie

$uloz="NO";
$zmaz="NO";
$uprav="NO";
// 5=ulozenie polozky do databazy nahratej v zdravpois.php
// 6=vymazanie polozky potvrdene v zdravpois.php
if ( $copern == 15 || $copern == 16 )
     {
$cislo_zdrv = strip_tags($_REQUEST['cislo_zdrv']);
//ulozenie novej
if ( $copern == 15 )
    {

$h_zdrv = AddSlashes($h_zdrv);
$h_nzdr = AddSlashes($h_nzdr);
$h_uceb = AddSlashes($h_uceb);
$h_numb = AddSlashes($h_numb);
$h_vsy = AddSlashes($h_vsy);
$h_ksy = AddSlashes($h_ksy);
$h_ssy = AddSlashes($h_ssy);
$h_pz1 = 1*$h_pz1;
$h_pz2 = 1*$h_pz2;

$h_dar = SqlDatum($h_dar);
$h_dsk = SqlDatum($h_dsk);
$uloztt = "INSERT INTO F$kli_vxcf"."_zdravpois".
" ( zdrv,nzdr,uceb,numb,vsy,ksy,ssy,iban,pz1,pz2,pt3 )".
" VALUES ($h_zdrv, '$h_nzdr', '$h_uceb', '$h_numb', '$h_vsy', '$h_ksy', '$h_ssy', '$h_iban', '$h_pz1', '$h_pz2', '$h_pbic' ) "; 
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
//echo "POLOéKA zdrv:$h_zdrv SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_zdravpois WHERE zdrv='$cislo_zdrv'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA zdrv:$cislo_zdrv BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {

$h_zdrv = AddSlashes($h_zdrv);
$h_nzdr = AddSlashes($h_nzdr);
$h_uceb = AddSlashes($h_uceb);
$h_numb = AddSlashes($h_numb);
$h_vsy = AddSlashes($h_vsy);
$h_ksy = AddSlashes($h_ksy);
$h_ssy = AddSlashes($h_ssy);
$h_iban = AddSlashes($h_iban);
$h_pbic = AddSlashes($h_pbic);
$h_pz1 = 1*$h_pz1;
$h_pz2 = 1*$h_pz2;

$cislo_zdrv = strip_tags($_REQUEST['cislo_zdrv']);
$h_dar = SqlDatum($h_dar);
$h_dsk = SqlDatum($h_dsk);

$upravene = mysql_query("UPDATE F$kli_vxcf"."_zdravpois SET zdrv='$h_zdrv', nzdr='$h_nzdr', numb='$h_numb',
 uceb='$h_uceb', vsy='$h_vsy', ksy='$h_ksy', ssy='$h_ssy', iban='$h_iban', pz1='$h_pz1', pz2='$h_pz2', pt3='$h_pbic' WHERE zdrv='$cislo_zdrv'");  
$copern=1;
$cislo_zdrv = $h_zdrv;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA zdrv:$cislo_zdrv UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
  {
$cislo_zdrv = strip_tags($_REQUEST['h_zdrv']);
  }
//6=uprava
if ( $copern == 6 )
  {
$cislo_zdrv = strip_tags($_REQUEST['cislo_zdrv']);
  }


//echo $h_dar;
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>ZdravotnÈ poisùovne</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">


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

<?php
//hladanie
  if ( $copern == 7 )
  {
?>
    function VyberVstup()
    {
    document.formhl1.hladaj_uceb.focus();
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
    document.formv1.h_zdrv.value = '<?php echo "$h_zdrv";?>';
    document.formv1.h_nzdr.value = '<?php echo "$h_nzdr";?>';
    document.formv1.h_uceb.value = '<?php echo "$h_uceb";?>';
    document.formv1.h_numb.value = '<?php echo "$h_numb";?>';
    document.formv1.h_vsy.value = '<?php echo "$h_vsy";?>';
    document.formv1.h_ksy.value = '<?php echo "$h_ksy";?>';
    document.formv1.h_ssy.value = '<?php echo "$h_ssy";?>';
    document.formv1.h_iban.value = '<?php echo "$h_iban";?>';
    document.formv1.h_pbic.value = '<?php echo "$h_pbic";?>';
    document.formv1.h_pz1.value = '<?php echo "$h_pz1";?>';
    document.formv1.h_pz2.value = '<?php echo "$h_pz2";?>';
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
    <?php if( $copern == 5 ) echo "document.formv1.h_zdrv.focus();"; ?>
    <?php if( $copern == 5 ) echo "document.formv1.h_zdrv.select();"; ?>
    <?php if( $copern == 8 ) echo "document.formv1.h_nzdr.focus();"; ?>
    <?php if( $copern == 8 ) echo "document.formv1.h_nzdr.select();"; ?>
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_zdrv.value == '' ) okvstup=0;
    if ( document.formv1.h_nzdr.value == '' ) okvstup=0;

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
<td>EuroSecom  -  ZdravotnÈ poisùovne
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
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois ORDER BY zdrv");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_uceb = strip_tags($_REQUEST['hladaj_uceb']);
$hladaj_nzdr = strip_tags($_REQUEST['hladaj_nzdr']);
$hladaj_vsy = strip_tags($_REQUEST['hladaj_vsy']);
$hladaj_zdrv = strip_tags($_REQUEST['hladaj_zdrv']);

if ( $hladaj_vsy != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE ( tel LIKE '%$hladaj_vsy%' ) ORDER BY zdrv");
if ( $hladaj_nzdr != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE ( nzdr LIKE '%$hladaj_nzdr%' ) ORDER BY zdrv");
if ( $hladaj_uceb != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE ( uceb LIKE '%$hladaj_uceb%' ) ORDER BY zdrv");
if ( $hladaj_zdrv != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE ( zdrv = '$hladaj_zdrv' ) ORDER BY zdrv");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv > 0 ORDER BY zdrv");

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
<FORM name="formhl1" class="hmenu" method="post" action="zdravpois.php?sys=<?php echo $sys; ?>&page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
<td class="hmenu" ></td>
<td class="hmenu" colspan="2" >
<?php
if ( $kli_uzall > 25000 )
  {
?>
<td class="hmenu" colspan="2">
<img src='../obr/orig.png' onclick="window.open('drmiezd_export.php?sys=<?php echo $sys; ?>&copern=1517&page=1', '_self');" 
width=20 height=15 border=0 title="NaËÌtaù ötandartn˝ ËÌselnÌk ZP z ../import/zp<?php echo $kli_vrok; ?>.csv" >
 - 
<img src='../obr/export.png' onclick="window.open('drmiezd_export.php?sys=<?php echo $sys; ?>&copern=17&page=1', '_self');" 
width=20 height=15 border=0 title="Exportovaù ËÌselnÌk ZP do s˙boru CSV" >
 - 
<img src='../obr/kos.png' onclick="window.open('drmiezd_export.php?sys=<?php echo $sys; ?>&copern=1817&page=1', '_self');" 
width=20 height=15 border=0 title="Vymazaù ËÌselnÌk ZP" >
<?php
  }
?>
</td>

</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_zdrv" id="hladaj_zdrv" size="11" value="<?php echo $hladaj_zdrv;?>" />
<td class="hmenu"><input type="text" name="hladaj_nzdr" id="hladaj_nzdr" size="20" value="<?php echo $hladaj_nzdr;?>" /> 

<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="zdravpois.php?sys=<?php echo $sys; ?>&page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<td class="hmenu" width="10%" >ËÌslo</td>
<td class="hmenu" width="30%" >n·zov</td>
<td class="hmenu" width="25%" >bankov˝ ˙Ëet</td>
<td class="hmenu" width="25%" >symboly platby</td>
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
<td class="fmenu" ><?php echo $riadok->zdrv;?></td>
<td class="fmenu" ><?php echo $riadok->nzdr;?></td>
<td class="fmenu" ><?php echo $riadok->iban;?> /  <?php echo $riadok->uceb;?> /  <?php echo $riadok->numb;?></td>
<td class="fmenu" ><?php echo $riadok->vsy;?> / <?php echo $riadok->ksy;?> / <?php echo $riadok->ssy;?></td>
<td class="fmenu" width="5%" ><a href='zdravpois.php?sys=<?php echo $sys; ?>&copern=8&page=<?php echo $page;?>&cislo_zdrv=<?php echo $riadok->zdrv;?>&h_zdrv=<?php echo $riadok->zdrv;?>'>
 <img src='../obr/uprav.png' width=20 height=20 border=0 title="⁄prava ˙dajov"></a></td>
<td class="fmenu" width="5%" ><a href='zdravpois.php?sys=<?php echo $sys; ?>&copern=6&page=<?php echo $page;?>&cislo_zdrv=<?php echo $riadok->zdrv;?>'>Zmaû</a></td>
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
$cislo_zdrv = strip_tags($_REQUEST['cislo_zdrv']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv='$cislo_zdrv'";
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
<td class="fmenu" width="10%" ><?php echo $zaznam["zdrv"];?></td>
<td class="fmenu" width="30%" ><?php echo $zaznam["nzdr"];?></td>
<td class="fmenu" width="25%" ><?php echo $zaznam["uceb"];?> / <?php echo $zaznam["numb"];?></td>
<td class="fmenu" width="25%" ><?php echo $zaznam["vsy"];?> <?php echo $zaznam["ksy"];?>, <?php echo $zaznam["ssy"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="zdravpois.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=16>&cislo_zdrv=<?php echo $cislo_zdrv;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="zdravpois.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=1" >
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
<span id="Bx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_zdrv;?> spr·vne uloûen·</span>
</tr>
<tr>
</table>

<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="zdravpois.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_zdrv=$cislo_zdrv"; } ?>
" >

<tr></tr><tr></tr><tr></tr>
<tr>
<td class="hmenu" width="10%">»Ìslo:</td>
<td class="fmenu" width="15%">
<?php
if ( $copern == 5 )
     {
?>
<input type="text" name="h_zdrv" id="h_zdrv" 
onchange="return intg(this,0,9999,Bx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Bx)" />*</td>
<?php
     }
?>
<?php
if ( $copern == 8 )
     {
echo "   ".$h_zdrv;
?>
<input type="hidden" name="h_zdrv" id="h_zdrv" /></td>
<?php
     }
?>
<td class="hmenu" width="10%">n·zov:</td>
<td class="fmenu" colspan="3">
<input type="text" name="h_nzdr" id="h_nzdr" size="50" onclick="Fx.style.display='none';" />*</td>
</tr>
<tr></tr>
<tr>
<td class="hmenu" colspan="4">Bankov˝ ˙Ëet na ˙hradu poistnÈho:</td>
</tr>
<td class="hmenu" width="10%">ËÌslo ˙Ëtu:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_uceb" id="h_uceb" onclick="Fx.style.display='none';" /></td>
<td class="hmenu" width="10%">num.kÛd:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_numb" id="h_numb" onclick="Fx.style.display='none';" /></td>
<td class="hmenu" width="10%">IBAN:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_iban" id="h_iban" size="37" onclick="Fx.style.display='none';" /></td>
<td class="hmenu" width="10%">BIC(swift):</td>
<td class="fmenu" width="15%">
<input type="text" name="h_pbic" id="h_pbic" size="12" onclick="Fx.style.display='none';" /></td>
</tr>
<tr></tr>
<tr>
<td class="hmenu" colspan="4">Symboly platby:</td>
</tr>
<tr>
<td class="hmenu" >Variabiln˝=ËÌslo platiteæa:</td>
<td class="fmenu" >
<input type="text" name="h_vsy" id="h_vsy" /></td>
<td class="hmenu" >Konötantn˝:</td>
<td class="fmenu" >
<input type="text" name="h_ksy" id="h_ksy" /></td>
<td class="hmenu" width="10%">äpecifick˝:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_ssy" id="h_ssy" /></td>
</tr>

<tr><td class="hmenu" colspan="4">   </td></tr>
<tr>
<td class="hmenu" colspan="4">AnalytickÈ ˙Ëtovanie odvodov ZP ( program pripoËÌta analytiku k ˙Ëtu v nastavenÌ ˙Ëtovania miezd ):</td>
</tr>
<tr>
<td class="hmenu" >524analytika:</td>
<td class="fmenu" >
<input type="text" name="h_pz1" id="h_pz1" /></td>
<td class="hmenu" >336analytika:</td>
<td class="fmenu" >
<input type="text" name="h_pz2" id="h_pz2" /></td>
</tr>


<tr></tr>
<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td class="obyc"></td><td class="obyc"></td><td class="obyc"></td><td class="obyc"></td><td class="obyc"></td><td class="obyc"></td>
<td class="obyc" align="right"></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="zdravpois.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornou" name="stornou" value="Koniec vstupu" ></td>
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
 Poloûka OS»=<?php echo $cislo_zdrv;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $cislo_zdrv;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="zdravpois.php?sys=<?php echo $sys; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_zdrv=$hladaj_zdrv&hladaj_uceb=$hladaj_uceb&hladaj_nzdr=$hladaj_nzdr&hladaj_vsy=$hladaj_vsy";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="zdravpois.php?sys=<?php echo $sys; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_zdrv=$hladaj_zdrv&hladaj_uceb=$hladaj_uceb&hladaj_nzdr=$hladaj_nzdr&hladaj_vsy=$hladaj_vsy";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="zdravpois.php?sys=<?php echo $sys; ?>&copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="zdravpois.php?sys=<?php echo $sys; ?>&copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
<INPUT type="submit" id="npol" value="Vloûiù nov˙ poloûku" >
</FORM>
</td>
<td>
<FORM name="forma6" class="obyc" method="post" target="_blank" action="cvod_t.php
<?php
if ( $copern != 9 )
{
echo "?copern=10";
}
if ( $copern == 9 )
{
echo "?copern=11&hladaj_uceb=$hladaj_uceb&hladaj_zdrv=$hladaj_zdrv";
}
?>
" >
<INPUT type="submit" id="tlac" value="TlaËiù" >
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
