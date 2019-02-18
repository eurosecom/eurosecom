<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 2000;
$clsm = 900;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$kanc = 1*$_REQUEST['kanc'];
$kontrola = 1*$_REQUEST['kontrola'];
$cislo_kanc = 1*$_REQUEST['cislo_kanc'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];
$ostre = 1*$_REQUEST['ostre'];
if( $copern == 501 ) { $vyb_osc = 1*$_REQUEST['vyb_osc']; }


if( $kli_vrok < 2010 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vyplat_paska2009.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&ostre=<?php echo $ostre; ?>
&cislo_oc=<?php echo $cislo_oc; ?>&cislo_kanc=<?php echo $cislo_kanc; ?>&kanc=<?php echo $kanc; ?>&kontrola=<?php echo $kontrola; ?>
&vyb_osc=<?php echo $vyb_osc; ?>","_self");
</script>
<?php
exit;
}


if( $kli_vrok < 2011 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vyplat_paska2010.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&ostre=<?php echo $ostre; ?>
&cislo_oc=<?php echo $cislo_oc; ?>&cislo_kanc=<?php echo $cislo_kanc; ?>&kanc=<?php echo $kanc; ?>&kontrola=<?php echo $kontrola; ?>
&vyb_osc=<?php echo $vyb_osc; ?>","_self");
</script>
<?php
exit;
}


if( $kli_vrok < 2012 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vyplat_paska2011.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&ostre=<?php echo $ostre; ?>
&cislo_oc=<?php echo $cislo_oc; ?>&cislo_kanc=<?php echo $cislo_kanc; ?>&kanc=<?php echo $kanc; ?>&kontrola=<?php echo $kontrola; ?>
&vyb_osc=<?php echo $vyb_osc; ?>","_self");
</script>
<?php
exit;
}

if( $kli_vrok < 2013 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vyplat_paska2012.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&ostre=<?php echo $ostre; ?>
&cislo_oc=<?php echo $cislo_oc; ?>&cislo_kanc=<?php echo $cislo_kanc; ?>&kanc=<?php echo $kanc; ?>&kontrola=<?php echo $kontrola; ?>
&vyb_osc=<?php echo $vyb_osc; ?>","_self");
</script>
<?php
exit;
}

if( $kli_vrok < 2014 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vyplat_paska2013.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&ostre=<?php echo $ostre; ?>
&cislo_oc=<?php echo $cislo_oc; ?>&cislo_kanc=<?php echo $cislo_kanc; ?>&kanc=<?php echo $kanc; ?>&kontrola=<?php echo $kontrola; ?>
&vyb_osc=<?php echo $vyb_osc; ?>","_self");
</script>
<?php
exit;
}

if( $kli_vrok < 2015 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vyplat_paska2014.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&ostre=<?php echo $ostre; ?>
&cislo_oc=<?php echo $cislo_oc; ?>&cislo_kanc=<?php echo $cislo_kanc; ?>&kanc=<?php echo $kanc; ?>&kontrola=<?php echo $kontrola; ?>
&vyb_osc=<?php echo $vyb_osc; ?>","_self");
</script>
<?php
exit;
}

if( $kli_vrok < 2016 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vyplat_paska2015.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&ostre=<?php echo $ostre; ?>
&cislo_oc=<?php echo $cislo_oc; ?>&cislo_kanc=<?php echo $cislo_kanc; ?>&kanc=<?php echo $kanc; ?>&kontrola=<?php echo $kontrola; ?>
&vyb_osc=<?php echo $vyb_osc; ?>","_self");
</script>
<?php
exit;
}

if( $kli_vrok < 2017 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vyplat_paska2016.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&ostre=<?php echo $ostre; ?>
&cislo_oc=<?php echo $cislo_oc; ?>&cislo_kanc=<?php echo $cislo_kanc; ?>&kanc=<?php echo $kanc; ?>&kontrola=<?php echo $kontrola; ?>
&vyb_osc=<?php echo $vyb_osc; ?>","_self");
</script>
<?php
exit;
}

if( $kli_vrok < 2018 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vyplat_paska2017.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&ostre=<?php echo $ostre; ?>
&cislo_oc=<?php echo $cislo_oc; ?>&cislo_kanc=<?php echo $cislo_kanc; ?>&kanc=<?php echo $kanc; ?>&kontrola=<?php echo $kontrola; ?>
&vyb_osc=<?php echo $vyb_osc; ?>","_self");
</script>
<?php
exit;
}

if( $kli_vrok < 2019 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vyplat_paska2018.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&ostre=<?php echo $ostre; ?>
&cislo_oc=<?php echo $cislo_oc; ?>&cislo_kanc=<?php echo $cislo_kanc; ?>&kanc=<?php echo $kanc; ?>&kontrola=<?php echo $kontrola; ?>
&vyb_osc=<?php echo $vyb_osc; ?>","_self");
</script>
<?php
exit;
}

//vyplatne pasky z menu po ostrom
if( $copern == 11 )
    {
$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume ORDER BY ume";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp == 0 )
{
?>
<script type="text/javascript">
alert ("Mzdy za obdobie <?php echo $kli_vume; ?> neboli spracovanÈ naostro , \r urobte najprv ostrÈ spracovanie !");
window.close();
</script>
<?php
exit;
}
    }

//neostre spracovanie
if( $copern == 1 AND $ostre == 0 )
    {
$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume ORDER BY ume";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp > 0 )
{
?>
<script type="text/javascript">
alert ("POZOR !  Mzdy za obdobie <?php echo $kli_vume; ?> \r boli uû spracovanÈ naostro ");
window.close();
</script>
<?php
exit;
}
    }


//test ostreho ci chcem a ci uz nahodou nebolo
if( $copern == 1 AND $ostre == 1 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete naostro spracovaù mzdy za obdobie <?php echo $kli_vume; ?> ?") )
         { window.close();  }
else
  var okno = window.open("../mzdy/vyplat_paska.php?&copern=2&page=1&ostre=1","_self");
</script>

<?php
exit;
}


if( $copern == 2 )
    {
$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume ORDER BY ume";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp > 0 )
{
?>
<script type="text/javascript">
alert ("Mzdy za obdobie <?php echo $kli_vume; ?> uû boli spracovanÈ , \r mÙûete zruöiù spracovanie !");
window.close();
</script>
<?php
exit;
}
    }

if( $copern == 2 ) $copern=1;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

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

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$vyb_osc=0;
$all_oc=1;
$data_zal=1;
$zmzdoveho=0;
if( $copern == 101 ) { $vyb_osc = 1*$_SESSION['vyb_osc']; $all_oc=0; $copern=1; $data_zal=0; }

if( $copern == 501 ) { $vyb_osc = 1*$_REQUEST['vyb_osc']; $all_oc=0; $copern=1; $data_zal=0; }

if( $copern == 511 ) { $vyb_osc = 1*$_REQUEST['cislo_oc']; $all_oc=0; $data_zal=1; $zmzdoveho=1;}

$podm_oc="oc > 0";
$mzdmes="mzdzalmesx".$kli_uzid;
$mzdtrn="mzdzaltrnx".$kli_uzid;
$mzdddp="mzdzalddpx".$kli_uzid;
$mzdkun="mzdzalkunx".$kli_uzid;
$mzdprm="mzdzalprmx".$kli_uzid;
if( $all_oc == 0 )
{
$podm_oc="oc = ".$vyb_osc;
}

if( $copern == 1 ) { $data_zal=0; }

if( $data_zal == 0 )
{
$mzdmes="mzdmes";
$mzdtrn="mzdtrn";
$mzdddp="mzdddp";
$mzdkun="mzdkun";
$mzdprm="mzdprm";
}

if( $data_zal != 0 )
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalmesx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzaltrnx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalkunx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalmesx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalmes WHERE ume = $kli_vume";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzaltrnx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzaltrn WHERE ume = $kli_vume";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalddpx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalddp WHERE ume = $kli_vume";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalkunx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalkun WHERE ume = $kli_vume";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalprmx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalprm WHERE ume = $kli_vume";
$vysledek = mysql_query("$sql");
}

if( $copern == 511 )
{
$sql = "DELETE FROM F".$kli_vxcf."_mzdzalmesx$kli_uzid WHERE oc != $vyb_osc ";
$vysledek = mysql_query("$sql");
$sql = "DELETE FROM F".$kli_vxcf."_mzdzaltrnx$kli_uzid WHERE oc != $vyb_osc ";
$vysledek = mysql_query("$sql");
$sql = "DELETE FROM F".$kli_vxcf."_mzdzalddpx$kli_uzid WHERE oc != $vyb_osc ";
$vysledek = mysql_query("$sql");
$sql = "DELETE FROM F".$kli_vxcf."_mzdzalkunx$kli_uzid WHERE oc != $vyb_osc ";
$vysledek = mysql_query("$sql");
$sql = "DELETE FROM F".$kli_vxcf."_mzdzalprmx$kli_uzid WHERE oc != $vyb_osc ";
$vysledek = mysql_query("$sql");

$data_zal=0;
$copern=1;
}
//exit;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//prac.subor
//POZOR ! Ak by sa menila definicia vy alebo sum je to aj v importe vy a sum v trexima.php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcsum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcneod'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcneodx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcneody'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   cel_dni      DECIMAL(10,2) DEFAULT 0,
   cel_hod      DECIMAL(10,2) DEFAULT 0,
   cel_hru      DECIMAL(10,2) DEFAULT 0,
   cel_nem      DECIMAL(10,2) DEFAULT 0,
   cel_zrz      DECIMAL(10,2) DEFAULT 0,
   cel_hot      DECIMAL(10,2) DEFAULT 0,
   cel_ban      DECIMAL(10,2) DEFAULT 0,
   czz_zzp      DECIMAL(10,2) DEFAULT 0,
   czz_znp      DECIMAL(10,2) DEFAULT 0,
   czz_zsp      DECIMAL(10,2) DEFAULT 0,
   czz_zip      DECIMAL(10,2) DEFAULT 0,
   czz_zpn      DECIMAL(10,2) DEFAULT 0,
   czz_zup      DECIMAL(10,2) DEFAULT 0,
   czz_zgf      DECIMAL(10,2) DEFAULT 0,
   czz_zrf      DECIMAL(10,2) DEFAULT 0,
   dok          INT(8) DEFAULT 0,
   dat          DATE not null,
   ume          DECIMAL(7,4),
   oc           INT(7) DEFAULT 0,
   dm           INT(4) DEFAULT 0,
   dp           DATE not null,
   dk           DATE not null,
   dni          DECIMAL(10,2) DEFAULT 0,
   hod          DECIMAL(10,2) DEFAULT 0,
   mnz          DECIMAL(10,4) DEFAULT 0,
   saz          DECIMAL(10,4) DEFAULT 0,
   kc           DECIMAL(10,2) DEFAULT 0,
   kcsk         DECIMAL(10,2) DEFAULT 0,
   str          INT(7) DEFAULT 0,
   zak          INT(7) DEFAULT 0,
   stj          INT(7) DEFAULT 0,
   trncpl       INT,
   czd_dnp      DECIMAL(10,2) DEFAULT 0,
   id           INT,
   odkial       INT,
   trx1         INT,
   dne          DECIMAL(10,2) DEFAULT 0,
   hne          DECIMAL(10,2) DEFAULT 0,
   prd          DECIMAL(10,2) DEFAULT 0,
   prh          DECIMAL(10,2) DEFAULT 0,
   ds6          DECIMAL(13,6) DEFAULT 0,
   ds2          DECIMAL(10,2) DEFAULT 0,
   neod_dni     DECIMAL(10,2) DEFAULT 0,
   neod_hod     DECIMAL(10,2) DEFAULT 0,
   cddp         INT,
   ddp_perz     DECIMAL(10,2) DEFAULT 0,
   ddp_fixz     DECIMAL(10,2) DEFAULT 0,
   ddp_perp     DECIMAL(10,2) DEFAULT 0,
   ddp_fixp     DECIMAL(10,2) DEFAULT 0,
   ddp_zam      DECIMAL(10,2) DEFAULT 0,
   ddp_fir      DECIMAL(10,2) DEFAULT 0,
   vdoch        int,
   vdocv        int,
   vspnie       int,
   vzpnie       int,
   vpom         int,
   konx         INT,
   nesp_dni     DECIMAL(10,2) DEFAULT 0,
   nesp_hod     DECIMAL(10,2) DEFAULT 0,
   nezp_dni     DECIMAL(10,2) DEFAULT 0,
   nezp_hod     DECIMAL(10,2) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$sqlt = <<<mzdprc
(
   sum_dni      DECIMAL(10,2) DEFAULT 0,
   sum_hod      DECIMAL(10,2) DEFAULT 0,
   sum_hru      DECIMAL(10,2) DEFAULT 0,
   sum_nem      DECIMAL(10,2) DEFAULT 0,
   sum_zrz      DECIMAL(10,2) DEFAULT 0,
   sum_hot      DECIMAL(10,2) DEFAULT 0,
   sum_ban      DECIMAL(10,2) DEFAULT 0,
   zzam_zp      DECIMAL(10,2) DEFAULT 0,
   zzam_np      DECIMAL(10,2) DEFAULT 0,
   zzam_sp      DECIMAL(10,2) DEFAULT 0,
   zzam_ip      DECIMAL(10,2) DEFAULT 0,
   zzam_pn      DECIMAL(10,2) DEFAULT 0,
   zzam_up      DECIMAL(10,2) DEFAULT 0,
   zzam_gf      DECIMAL(10,2) DEFAULT 0,
   zzam_rf      DECIMAL(10,2) DEFAULT 0,
   zfir_zp      DECIMAL(10,2) DEFAULT 0,
   zfir_np      DECIMAL(10,2) DEFAULT 0,
   zfir_sp      DECIMAL(10,2) DEFAULT 0,
   zfir_ip      DECIMAL(10,2) DEFAULT 0,
   zfir_pn      DECIMAL(10,2) DEFAULT 0,
   zfir_up      DECIMAL(10,2) DEFAULT 0,
   zfir_gf      DECIMAL(10,2) DEFAULT 0,
   zfir_rf      DECIMAL(10,2) DEFAULT 0,
   ozam_zp      DECIMAL(10,2) DEFAULT 0,
   ozam_np      DECIMAL(10,2) DEFAULT 0,
   ozam_sp      DECIMAL(10,2) DEFAULT 0,
   ozam_ip      DECIMAL(10,2) DEFAULT 0,
   ozam_pn      DECIMAL(10,2) DEFAULT 0,
   ozam_up      DECIMAL(10,2) DEFAULT 0,
   ozam_gf      DECIMAL(10,2) DEFAULT 0,
   ozam_rf      DECIMAL(10,2) DEFAULT 0,
   ofir_zp      DECIMAL(10,2) DEFAULT 0,
   ofir_np      DECIMAL(10,2) DEFAULT 0,
   ofir_sp      DECIMAL(10,2) DEFAULT 0,
   ofir_ip      DECIMAL(10,2) DEFAULT 0,
   ofir_pn      DECIMAL(10,2) DEFAULT 0,
   ofir_up      DECIMAL(10,2) DEFAULT 0,
   ofir_gf      DECIMAL(10,2) DEFAULT 0,
   ofir_rf      DECIMAL(10,2) DEFAULT 0,
   ozam_spolu   DECIMAL(10,2) DEFAULT 0,
   ofir_spolu   DECIMAL(10,2) DEFAULT 0,
   des1         DECIMAL(10,1) DEFAULT 0,
   des2         DECIMAL(10,2) DEFAULT 0,
   des3         DECIMAL(10,3) DEFAULT 0,
   des6         DECIMAL(13,6) DEFAULT 0,
   ume          DECIMAL(7,4),
   oc           INT(7) DEFAULT 0,
   zdan_dnp     DECIMAL(10,2) DEFAULT 0,
   odan_dnp     DECIMAL(10,2) DEFAULT 0,
   pdan_dnv     DECIMAL(10,2) DEFAULT 0,
   pdan_fnd     DECIMAL(10,2) DEFAULT 0,
   pdan_zn1     DECIMAL(10,2) DEFAULT 0,
   pdan_zn2     DECIMAL(10,2) DEFAULT 0,
   odan_zrz     DECIMAL(10,2) DEFAULT 0,
   zakl_dan     DECIMAL(10,2) DEFAULT 0,
   bonus_dan    DECIMAL(10,2) DEFAULT 0,
   id           INT,
   hot_eur      DECIMAL(10,2) DEFAULT 0,
   ban_eur      DECIMAL(10,2) DEFAULT 0,
   ddp_zam      DECIMAL(10,2) DEFAULT 0,
   ddp_fir      DECIMAL(10,2) DEFAULT 0,
   sum_cccp     DECIMAL(10,2) DEFAULT 0,
   sum_cccpsk   DECIMAL(10,2) DEFAULT 0,
   cista_mzda   DECIMAL(10,2) DEFAULT 0,
   cista_mzdask DECIMAL(10,2) DEFAULT 0,
   sdoch        int,
   sdocv        int,
   sspnie       int,
   szpnie       int,
   spom         int,
   svban        int,
   snumb        VARCHAR(4),
   scdss        int,
   ozam_dss     DECIMAL(10,2) DEFAULT 0,
   suva         DECIMAL(10,2) DEFAULT 0,
   ksum1        INT,
   zmax_zp      DECIMAL(10,2) DEFAULT 0,
   zmax_np      DECIMAL(10,2) DEFAULT 0,
   zmax_sp      DECIMAL(10,2) DEFAULT 0,
   zmax_ip      DECIMAL(10,2) DEFAULT 0,
   zmax_pn      DECIMAL(10,2) DEFAULT 0,
   zmax_up      DECIMAL(10,2) DEFAULT 0,
   zmax_gf      DECIMAL(10,2) DEFAULT 0,
   zmax_rf      DECIMAL(10,2) DEFAULT 0,
   zmin_zp      DECIMAL(10,2) DEFAULT 0,
   zmin_np      DECIMAL(10,2) DEFAULT 0,
   zmin_sp      DECIMAL(10,2) DEFAULT 0,
   zmin_ip      DECIMAL(10,2) DEFAULT 0,
   zmin_pn      DECIMAL(10,2) DEFAULT 0,
   zmin_up      DECIMAL(10,2) DEFAULT 0,
   zmin_gf      DECIMAL(10,2) DEFAULT 0,
   zmin_rf      DECIMAL(10,2) DEFAULT 0,
   ksum2        INT
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcsum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   neod_dni     DECIMAL(10,2) DEFAULT 0,
   neod_hod     DECIMAL(10,2) DEFAULT 0,
   den_prvy     DATE,
   den_posl     DATE,
   nesp_dni     DECIMAL(10,2) DEFAULT 0,
   nesp_hod     DECIMAL(10,2) DEFAULT 0,
   nezp_dni     DECIMAL(10,2) DEFAULT 0,
   nezp_hod     DECIMAL(10,2) DEFAULT 0,
   prac_dni     DECIMAL(10,2) DEFAULT 0,
   prac_hod     DECIMAL(10,2) DEFAULT 0,
   svia_dni     DECIMAL(10,2) DEFAULT 0,
   svia_hod     DECIMAL(10,2) DEFAULT 0,
   celk_dni     DECIMAL(10,2) DEFAULT 0,
   celk_hod     DECIMAL(10,2) DEFAULT 0,
   konnex       DECIMAL(10,2) DEFAULT 0,
   neoxx        INT 
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcneod'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcneodx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcneody'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

//oprava kalendar
//$uprt = "UPDATE kalendar SET svt=0 WHERE dat = '2016-05-25' ";
//$upravene = mysql_query("$uprt");


//VYPOCET LEN KED NEOSTRE ALEBO OSTRE
if( $copern != 11 )
         {


//rusim dopocitanie hodnoty pre polozky s kc=0 v mesacnej
//zober polozky z mesacnej davky - este doriesit take bez hodnoty dovolenka,nemocenska...

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" SELECT 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,". //zaklady fondov;
" dok,dat,ume,oc,dm,dp,dk,dni,hod,mnz,saz,kc,0,str,zak,stj,0,0,id,".
" 0,0,0,0,0,0,0,0,".
" 0,0,". //neodpracovane;
" 0,0,0,0,0,0,0,". //DDP;
" 0,0,0,0,0,". //z kmenovych;
" 0,".
" 0,0,0,0". //nesp,nezp;
" FROM F$kli_vxcf"."_$mzdmes".
" WHERE ume = $kli_vume AND ".$podm_oc.
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


/////////////NACITANIE UDAJOV Z PARAMETROV
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_$mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uva_hod=$riaddok->uva_hod;
  $dan_danov=$riaddok->dan_danov;
  $dan_bonus=$riaddok->dan_bonus;
  $dan_perc=$riaddok->dan_perc;
  $zam_zp=$riaddok->zam_zp;
  $zam_zpn=$riaddok->zam_zpn;
  $zam_np=$riaddok->zam_np;
  $zam_sp=$riaddok->zam_sp;
  $zam_ip=$riaddok->zam_ip;
  $zam_pn=$riaddok->zam_pn;
  $zam_up=$riaddok->zam_up;
  $zam_gf=$riaddok->zam_gf;
  $zam_rf=$riaddok->zam_rf;
  $fir_zp=$riaddok->fir_zp;
  $fir_zpn=$riaddok->fir_zpn;
  $fir_np=$riaddok->fir_np;
  $fir_sp=$riaddok->fir_sp;
  $fir_ip=$riaddok->fir_ip;
  $fir_pn=$riaddok->fir_pn;
  $fir_up=$riaddok->fir_up;
  $fir_gf=$riaddok->fir_gf;
  $fir_rf=$riaddok->fir_rf;
  $min_mzda=$riaddok->min_mzda;
  $min_mzd2=$riaddok->min_mzda/2;
  $max_zp=$riaddok->max_zp;
  $max_np=$riaddok->max_np;
  $max_sp=$riaddok->max_sp;
  $max_ip=$riaddok->max_ip;
  $max_pn=$riaddok->max_pn;
  $max_up=$riaddok->max_up;
  $max_gf=$riaddok->max_gf;
  $max_rf=$riaddok->max_rf;
  }


//danovy bonus sa bude asi menit od 1.7.2019 rovnaky cely rok
if( $kli_vume <= 12.2019 AND $kli_vrok == 2019 )
          {
$dan_bonus=22.17;
          }

//koniec nacitania parametrov

/////////////POLOZKY Z TRVALYCH
//neodpracovane hod a dni z nahrad
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET neod_dni=dni, neod_hod=hod".
" WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = F$kli_vxcf"."_mzddmn.dm AND ne = 1 AND F$kli_vxcf"."_mzdprcvy$kli_uzid.dm < 800 ".
" AND F$kli_vxcf"."_mzdprcvy$kli_uzid.dm != 502 AND F$kli_vxcf"."_mzdprcvy$kli_uzid.dm != 503 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");


//ak ma vystup alebo nastup v mesiaci 
$prvyden=$kli_vrok."-".$kli_vmes."-01";

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   datp          DATE,
   datk          DATE,
   fic          INT
);
prcdatum;

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$prvyden', '$prvyden', 0 )";
$ttqq = mysql_query("$ttvv");

$dsqlt = "UPDATE prcdatum".$kli_uzid." SET datp='$prvyden',  datk=LAST_DAY('$prvyden') WHERE fic >= 0 ";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $prvyden=$riadok->datp;
  $poslden=$riadok->datk;
  }
//vypocitaj datum konca mesiaca

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" SELECT 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,". //zaklady fondov;
" 0,'$prvyden',$kli_vume,oc,9504,dav,LAST_DAY('$prvyden'),0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,0,". //neodpracovane;
" 0,0,0,0,0,0,0,". //DDP;
" 0,0,0,0,0,". //z kmenovych;
" 0,".
" 0,0,0,0". //nesp,nezp;
" FROM F$kli_vxcf"."_$mzdkun".
" WHERE dav <= '$poslden' AND dav >= '$prvyden' AND ".$podm_oc.
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" SELECT 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,". //zaklady fondov;
" 0,'$prvyden',$kli_vume,oc,9505,'$prvyden',dan,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,0,". //neodpracovane;
" 0,0,0,0,0,0,0,". //DDP;
" 0,0,0,0,0,". //z kmenovych;
" 0,".
" 0,0,0,0". //nesp,nezp;
" FROM F$kli_vxcf"."_$mzdkun".
" WHERE dan <= '$poslden' AND dan >= '$prvyden' AND ".$podm_oc.
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" SET ".
" dni=TO_DAYS(dk)-TO_DAYS(dp), hod=dni*$uva_hod".
" WHERE oc >= 0 AND ( dm = 9504 OR dm = 9505 )";
$oznac = mysql_query("$sqtoz");

//uprav neodprcovane dni,hod u 800/899,502,503,9504 podla dp,dk nie dni,hod

  //czz_zrf=9999 pre polozky znizujuce dni poistenia
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid SET czz_zzp=DAYOFWEEK(dp), czz_zrf=9999 ".
" WHERE dm = 9505 OR dm = 9504 OR dm = 502 OR dm = 503 OR ( dm >= 800 AND dm <= 899 )";
$oznac = mysql_query("$sqtoz");

  //soboty czz_zsp
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,kalendar SET czz_zsp=sodo WHERE dp=kalendar.dat AND czz_zrf = 9999";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,kalendar SET czz_zsp=czz_zsp-sood WHERE dk=kalendar.dat AND czz_zrf = 9999";
$oznac = mysql_query("$sqtoz");

  //nedele czz_zip
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,kalendar SET czz_zip=nedo WHERE dp=kalendar.dat AND czz_zrf = 9999";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,kalendar SET czz_zip=czz_zip-neod WHERE dk=kalendar.dat AND czz_zrf = 9999";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid".
" SET ds2=czz_zsp+czz_zip, neod_dni=dni-ds2, neod_hod=neod_dni*$uva_hod, ".
" ds2=0, czz_zzp=0, czz_znp=0, czz_zsp=0, czz_zip=0, czz_zgf=0, czz_zrf=0 ".
" WHERE dm = 9505 OR dm = 9504 OR dm = 502 OR dm = 503 OR ( dm >= 800 AND dm <= 899 )";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET neod_hod=neod_dni*uva ".
" WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.oc=F$kli_vxcf"."_$mzdkun.oc AND ".
" ( dm = 9505 OR dm = 9504 OR dm = 502 OR dm = 503 OR ( dm >= 800 AND dm <= 899 ) ) AND uva != $uva_hod";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
//exit;

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid".
" SET neod_dni=0, neod_hod=0 ".
" WHERE ( dm = 9505 OR dm = 9504 ) AND neod_dni < 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//neodpracovane hod a dni z nemocenskej , neplateneho volna a absencie, odhlasenia zo ZP
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid".
" SET nesp_dni=dni, nesp_hod=hod, nezp_dni=dni, nezp_hod=hod ".
" WHERE dm = 9505 OR dm = 9504 OR dm = 502 OR ( dm >= 800 AND dm <= 899 )";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid".
" SET nesp_dni=dni, nesp_hod=hod ".
" WHERE dm = 503";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid".
" SET nezp_dni=dni, nezp_hod=hod ".
" WHERE dm = 592";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//pocet pracovnych a sviatkovych pondelok-piatok dni a hodin
$sql = mysql_query("SELECT * FROM kalendar WHERE ume = $kli_vume AND ( ( akyden >= 1 AND akyden <= 5 ) AND (  svt = 0 ) )");
$prc = mysql_num_rows($sql);
$sql = mysql_query("SELECT * FROM kalendar WHERE ume = $kli_vume AND ( ( akyden >= 1 AND akyden <= 5 ) AND (  svt = 1 ) )");
$svt = mysql_num_rows($sql);

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcneodx$kli_uzid "." SELECT".
" oc,0,0,".
" '','',0,0,0,0,0,0,0,0,0,0,".
"0,0".
" FROM F$kli_vxcf"."_$mzdkun".
" WHERE oc >= 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcneodx$kli_uzid "." SELECT".
" oc,sum(neod_dni),sum(neod_hod),".
" '','',sum(nesp_dni),sum(nesp_hod),sum(nezp_dni),sum(nezp_hod),0,0,0,0,0,0,".
"0,0".
" FROM F$kli_vxcf"."_mzdprcvy$kli_uzid".
" WHERE id >= 0".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$prvyden=$kli_vrok."-".$kli_vmes."-01";

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcneody'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcneod$kli_uzid "." SELECT".
" oc,sum(neod_dni),sum(neod_hod),".
" '','',sum(nesp_dni),sum(nesp_hod),sum(nezp_dni),sum(nezp_hod),0,0,0,0,0,0,".
"0,9".
" FROM F$kli_vxcf"."_mzdprcneodx$kli_uzid".
" WHERE oc >= 0 AND ".$podm_oc.
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcneodx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET prac_dni=$prc, prac_hod=$prc*$uva_hod, svia_dni=$svt, svia_hod=$svt*$uva_hod,".
" den_prvy='$prvyden', den_posl=LAST_DAY('$prvyden'),".
" celk_dni=1+TO_DAYS(den_posl)-TO_DAYS(den_prvy), celk_hod=celk_dni*$uva_hod".
" WHERE oc >= 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//poistka proti minusovym neodpracovanym dnom
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid SET neod_dni=0, neod_hod=0 WHERE neod_dni < 0 OR neod_hod < 0";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid SET neod_dni=0, neod_hod=0 WHERE neod_dni < 0 OR neod_hod < 0";
$oznac = mysql_query("$sqtoz");
//exit;

//zober polozky z trvalych este dories prepocet dm 101,118 ak je prescas a dopln str,zak z kun
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" SELECT 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,'0000-00-00',$kli_vume,oc,dm,'0000-00-00','0000-00-00',0,0,mn,0,kc,0,0,0,0,cpl,0,0,".
" 1,trx1,0,0,0,0,0,0,".
" 0,0,".
" 0,0,0,0,0,0,0,". //DDP;
" 0,0,0,0,0,". //z kmenovych;
" 0,".
" 0,0,0,0". //nesp,nezp;
" FROM F$kli_vxcf"."_$mzdtrn".
" WHERE ".$podm_oc.
"";
$dsql = mysql_query("$dsqlt");

//vypocitaj odkial=1 trvale trx1=1 prepocitat na hodiny
//pocet pracovnych a sviatkovych pondelok-piatok dni a hodin
$sql = mysql_query("SELECT * FROM kalendar WHERE ume = $kli_vume AND ( ( akyden >= 1 AND akyden <= 5 ) OR ( akyden >= 1 AND akyden <= 5 AND svt = 1 ) )");
$prs = mysql_num_rows($sql);

//POZOR AK UVAZOK JE SKRATENY

//nastav prd a prh do poloziek z trvalych
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid SET prd=$prs, prh=$prs*$uva_hod ".
" WHERE odkial = 1 AND trx1 = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET prh=$prs*uva".
" WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND odkial = 1 AND trx1 = 1 AND uva != $uva_hod ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid ".
" SET dne=F$kli_vxcf"."_mzdprcneod$kli_uzid.neod_dni, hne=F$kli_vxcf"."_mzdprcneod$kli_uzid.neod_hod ".
" WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND odkial = 1 AND trx1 = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");


if( $fir_mzdx01 != 1 )
{
//pripocitaj hodiny nadcas 201 pre vpp
$vppsro=0;
if( $_SERVER['SERVER_NAME'] == "www.vppsro.sk" ) { $vppsro=1; }
if( $vppsro == 1 )
   {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_$mzdmes ".
" SET hne=hne-F$kli_vxcf"."_$mzdmes.hod ".
" WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.oc = F$kli_vxcf"."_$mzdmes.oc ".
" AND F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = 101 AND F$kli_vxcf"."_$mzdmes.ume = $kli_vume ".
" AND F$kli_vxcf"."_$mzdmes.dm = 201 AND odkial = 1 AND trx1 = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_$mzdmes ".
" SET hne=hne-F$kli_vxcf"."_$mzdmes.hod ".
" WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.oc = F$kli_vxcf"."_$mzdmes.oc ".
" AND F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = 118 AND F$kli_vxcf"."_$mzdmes.ume = $kli_vume ".
" AND F$kli_vxcf"."_$mzdmes.dm = 201 AND odkial = 1 AND trx1 = 1 ";
//echo $sqtoz;
//exit;
$oznac = mysql_query("$sqtoz");

   }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid SET dni=prd-dne, hod=prh-hne, ".
" ds6=(kc/prh)*hod, ds2=ds6, kc=ds2, ds6=0, ds2=0 ".
" WHERE odkial = 1 AND trx1 = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

}

if( $fir_mzdx01 == 1 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET dni=prd-dne, ddp_perz=uva".
" WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND odkial = 1 AND trx1 = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid".
" SET hod=ddp_perz*dni, ds6=(kc/prd)*dni, ds2=ds6, kc=ds2, ds6=0, ds2=0, ddp_perz=0 ".
" WHERE odkial = 1 AND trx1 = 1 ";
$oznac = mysql_query("$sqtoz");

}

//pridaj premie vypocitane k polozke z trvalych
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" SELECT 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,'0000-00-00',$kli_vume,oc,(dm+200),'0000-00-00','0000-00-00',dni,hod,mnz,0,(mnz*kc/100),0,0,0,0,trncpl,0,0,".
" odkial,trx1,0,0,0,0,0,0,".
" 0,0,".
" 0,0,0,0,0,0,0,". //DDP;
" 0,0,0,0,0,". //z kmenovych;
" 0,".
" 0,0,0,0". //nesp,nezp;
" FROM F$kli_vxcf"."_mzdprcvy$kli_uzid".
" WHERE odkial = 1 AND trx1 = 1 AND mnz > 0 AND kc > 0 ".
"";

$dsql = mysql_query("$dsqlt");

//pridaj datumy dm 809,811,812 materska a rocicovska k polozke z trvalych
//pocet dni v mesiaci
$pocetdnix=31;
$sqltt = "SELECT * FROM kalendar WHERE ume = $kli_vume ";
$sql = mysql_query("$sqltt");
$pocetdnix = mysql_num_rows($sql);

$denprvyx=$kli_vrok."-".$kli_vmes."-01";
$denposlednyx=$kli_vrok."-".$kli_vmes."-".$pocetdnix;

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET dp='".$denprvyx."', dk='".$denposlednyx."', dni=".$pocetdnix.", hod=".$pocetdnix."*uva ".
" WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND odkial = 1 AND trx1 = 0 AND ( dm = 809 OR dm = 811 OR dm = 812 )";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz;
//exit;

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvy$kli_uzid WHERE odkial = 1 AND trx1 = 1 AND kc < 0 ";
$oznac = mysql_query("$sqtoz");

//daj stz a zkz z kmenovych do trvalych
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET str=stz, zak=zkz ".
" WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND odkial = 1 AND trx1 = 1 AND str = 0 AND zak = 0 ";
$oznac = mysql_query("$sqtoz");

//exit;

////////////KONIEC POLOZKY Z TRVALYCH

///////////////////////////////////////////////DDP dorobit ak zadane percentom z zzam_sp

//zober polozky z DDP
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" SELECT 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,'0000-00-00',$kli_vume,oc,965,'0000-00-00','0000-00-00',0,0,0,0,fixz_dd,0,0,0,0,cpl,0,0,".
" 2,0,0,0,0,0,0,0,".
" 0,0,".
" cddp,0,fixz_dd,0,fixp_dd,fixz_dd,fixp_dd,". //DDP;
" 0,0,0,0,0,". //z kmenovych;
" 0,".
" 0,0,0,0". //nesp,nezp;
" FROM F$kli_vxcf"."_$mzdddp".
" WHERE ( fixz_dd > 0 OR fixp_dd > 0 ) AND ".$podm_oc.
"";
//echo $dsqlt;

$dsql = mysql_query("$dsqlt");

//zober polozky z DDP
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" SELECT 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,'0000-00-00',$kli_vume,oc,965,'0000-00-00','0000-00-00',0,0,0,0,0,0,0,0,0,cpl,0,0,".
" 2,9,0,0,0,0,0,0,".
" 0,0,".
" cddp,perz_dd,0,perp_dd,0,0,0,". //DDP;
" 0,0,0,0,0,". //z kmenovych;
" 0,".
" 0,0,0,0". //nesp,nezp;
" FROM F$kli_vxcf"."_$mzdddp".
" WHERE ( perz_dd > 0 OR perp_dd > 0 ) AND ".$podm_oc.
"";
//echo $dsqlt;

$dsql = mysql_query("$dsqlt");

//exit;
//////////////////////////////////////////////KONIEC DDP

//dopln udaje kun do vy
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET vdoch=doch, vdocv=docv, vspnie=spnie, vzpnie=zpnie, vpom=pom".
" WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//prepocet na sk
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid SET kcsk=kc*$kurz12 WHERE kc != 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//hruba mzda br=1
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET cel_hru=kc".
" WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = F$kli_vxcf"."_mzddmn.dm AND ( br = 1 OR br = 0 )";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid".
" SET cel_hru=0".
" WHERE dm = 997 OR dm = 998 OR dm = 999";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//vyplaty nemoc br=2
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET cel_nem=kc".
" WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = F$kli_vxcf"."_mzddmn.dm AND br = 2 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//zrazky br=3
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET cel_zrz=kc".
" WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = F$kli_vxcf"."_mzddmn.dm AND br = 3 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//zrazky br > 3
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET cel_nem=kc".
" WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = F$kli_vxcf"."_mzddmn.dm AND br > 3 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//odpracovane dni,hodiny na paske ho=1,2 a br=1,2    dorob prescas 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET cel_dni=dni, cel_hod=hod".
" WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = F$kli_vxcf"."_mzddmn.dm AND ( ho=1 OR ho=2 ) AND ( br=1 OR br=2 )";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//zaklad zamestnanec zp,np.....rf 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET czz_zzp=kc WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = F$kli_vxcf"."_mzddmn.dm AND nap_zp = 1 AND F$kli_vxcf"."_mzdprcvy$kli_uzid.dm != 955 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET czz_zzp=-kc WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = F$kli_vxcf"."_mzddmn.dm AND nap_zp = 1 AND F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = 955 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET czz_znp=kc WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = F$kli_vxcf"."_mzddmn.dm AND nap_np = 1";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET czz_zsp=kc WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = F$kli_vxcf"."_mzddmn.dm AND nap_sp = 1";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET czz_zip=kc WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = F$kli_vxcf"."_mzddmn.dm AND nap_ip = 1";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET czz_zpn=kc WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = F$kli_vxcf"."_mzddmn.dm AND nap_pn = 1";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET czz_zup=kc WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = F$kli_vxcf"."_mzddmn.dm AND nap_up = 1";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET czz_zgf=kc WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = F$kli_vxcf"."_mzddmn.dm AND nap_gf = 1";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET czz_zrf=kc WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = F$kli_vxcf"."_mzddmn.dm AND nap_rf = 1";
$oznac = mysql_query("$sqtoz");

//zaklad zamestnanec dan z prijmu 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET czd_dnp=kc WHERE F$kli_vxcf"."_mzdprcvy$kli_uzid.dm = F$kli_vxcf"."_mzddmn.dm AND td = 0 ".
" AND F$kli_vxcf"."_mzdprcvy$kli_uzid.dm != 954 AND F$kli_vxcf"."_mzdprcvy$kli_uzid.dm != 955 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid ".
" SET ds2=kc WHERE  dm = 954 OR dm = 955 ";
$oznac = mysql_query("$sqtoz");

//uprava dni,hod miezd 801/899,502,503 a dp- '' dk- '' zniz polozky dni o soboty,nedele a prepocitaj hod polozku
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid".
" SET cel_dni=neod_dni, cel_hod=neod_hod".
" WHERE dp > '0000-00-00' AND dk > '0000-00-00' AND ( dm = 9505 OR dm = 9504 OR dm = 502 OR dm = 503 OR ( dm >= 800 AND dm <= 899) )";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid ".
" SET cel_dni=0, cel_hod=0".
" WHERE dm = 9505 OR dm = 9504";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");


//sumarizuj za oc napocty sumu percenta ddp da do hot_eur
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcsum".$kli_uzid." ".
" SELECT sum(cel_dni),sum(cel_hod),sum(cel_hru),sum(cel_nem),sum(cel_zrz),sum(cel_hot),sum(cel_ban),".
" sum(czz_zzp),sum(czz_znp),sum(czz_zsp),sum(czz_zip),sum(czz_zpn),sum(czz_zup),sum(czz_zgf),sum(czz_zrf),".
" 0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,ume,oc,".
" sum(czd_dnp),0,0,0,0,SUM(ds2),0,0,0,".
"id,sum(ddp_perp),0,sum(ddp_zam),sum(ddp_fir),0,0,0,0, ".
"0,0,0,0,0,0,0,0,0,0,". //z kun
"0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0".
" FROM F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" WHERE oc > 0 ".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

//dopln udaje kun do sum
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET sdoch=doch, sdocv=docv, sspnie=spnie, szpnie=zpnie, spom=pom, svban=vban, snumb=numb, scdss=cdss, suva=uva".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//vypocet DDP za zamestnanca zadane percentom
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvy$kli_uzid,F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET kc=(zzam_sp*ddp_perz)/100, kcsk=30.126*(zzam_sp*ddp_perz)/100  ".
" WHERE dm=965 AND trx1 = 9 AND F$kli_vxcf"."_mzdprcvy$kli_uzid.oc = F$kli_vxcf"."_mzdprcsum$kli_uzid.oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//sumarizuj ddp za zamestnanca percentom ak je viac zmluv
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyd'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyds'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_mzdprcvyd$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdprcvy$kli_uzid WHERE trx1 = 9 AND dm=965 AND ddp_perz > 0 ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdprcvyds$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdprcvy$kli_uzid WHERE trx1 = 20 ";
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyds".$kli_uzid.
" SELECT 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,'0000-00-00',0,oc,965,'0000-00-00','0000-00-00',0,0,0,0,SUM(kc),0,0,0,0,0,0,0,".
" 2,9,0,0,0,0,0,0,".
" 0,0,".
" 0,0,0,0,0,0,0,". //DDP;
" 0,0,0,0,0,". //z kmenovych;
" 0,".
" 0,0,0,0". //nesp,nezp;
" FROM F$kli_vxcf"."_mzdprcvyd$kli_uzid ".
" WHERE oc > 0 GROUP BY oc".
"";
//echo $dsqlt;
$vysledek = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcvyds$kli_uzid".
" SET sum_zrz=sum_zrz+kc ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcvyds$kli_uzid.oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
//exit;

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyd'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyds'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvy$kli_uzid WHERE dm = 965 AND kc = 0 ";
$oznac = mysql_query("$sqtoz");

//vypocet DDP za firmu ak je zadane percento sucet percent je v hot_eur
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET des6=(sum_hru*hot_eur)/100, ddp_fir=des6, des2=0, des6=0, hot_eur=0 ".
" WHERE hot_eur > 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");


//DDP za firmu pripocitaj do zakladu zzam_zp 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET zzam_zp=zzam_zp+ddp_fir WHERE szpnie = 0";
$oznac = mysql_query("$sqtoz");


//uprav maximalny a minimalny zaklad ZP,NP,SP...,RF nesp_dni,hod a nezp_dni,hod v tabulke neod su dni , za ktore nie je poisteny SP a ZP
  //nastav max a min z parametrov
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_$mzdprm".
" SET ".
" zmax_zp=$max_zp, zmin_zp=min_zp, ".
" zmax_np=$max_np, zmin_np=min_np, ".
" zmax_sp=$max_sp, zmin_sp=min_sp, ".
" zmax_ip=$max_ip, zmin_ip=min_ip, ".
" zmax_pn=$max_pn, zmin_pn=min_pn, ".
" zmax_up=$max_up, zmin_up=min_up, ".
" zmax_gf=$max_gf, zmin_gf=min_gf, ".
" zmax_rf=$max_rf, zmin_rf=min_rf ".
" WHERE oc > 0 ";
$oznac = mysql_query("$sqtoz");


  //ak je v mesacnej davke 508-prep dovolenka alebo 130=odstupne zober zaklad aky napocital neupravuj ani max ani min
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyx".$kli_uzid.
" SELECT 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,'0000-00-00',$kli_vume,oc,508,'0000-00-00','0000-00-00',dni,hod,0,0,kc,0,0,0,0,0,0,0,".
" 9,0,0,0,0,0,0,0,".
" 0,0,".
" 0,0,0,0,0,0,0,". //DDP;
" 0,0,0,0,0,". //z kmenovych;
" 0,".
" 0,0,0,0". //nesp,nezp;
" FROM F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" WHERE dm = 508 OR dm = 130 ".
"";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid,F$kli_vxcf"."_mzdprcvyx$kli_uzid ".
" SET konnex=508 ".
" WHERE F$kli_vxcf"."_mzdprcneod$kli_uzid.oc = F$kli_vxcf"."_mzdprcvyx$kli_uzid.oc AND kc > 0  ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvyx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


//uprav maximalny a minimalny podla nepoistenych dni, zpmax neupravuj ak celkovedni = nepoistenedni pravdepodobne je to prijem rocny...
//od 11.2014 neznizujem maximalny zaklad do ZP podla poctu poistenych dni, vzdy je maxZP

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET zmin_zp=zmin_zp*(celk_dni-nezp_dni)/celk_dni ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND konnex != 508 ";
$oznac = mysql_query("$sqtoz");

$podmkonnex="konnex != 989";

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET zmax_np=zmax_np*(celk_dni-nesp_dni)/celk_dni, zmin_np=zmin_np*(celk_dni-nesp_dni)/celk_dni ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND $podmkonnex ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET zmax_sp=zmax_sp*(celk_dni-nesp_dni)/celk_dni, zmin_sp=zmin_sp*(celk_dni-nesp_dni)/celk_dni ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND $podmkonnex ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET zmax_ip=zmax_ip*(celk_dni-nesp_dni)/celk_dni, zmin_ip=zmin_ip*(celk_dni-nesp_dni)/celk_dni ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND $podmkonnex ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET zmax_pn=zmax_pn*(celk_dni-nesp_dni)/celk_dni, zmin_pn=zmin_pn*(celk_dni-nesp_dni)/celk_dni ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND $podmkonnex ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET ".
" zmin_up=zmin_up*(celk_dni-nesp_dni)/celk_dni ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND $podmkonnex ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET zmax_rf=zmax_rf*(celk_dni-nesp_dni)/celk_dni, zmin_rf=zmin_rf*(celk_dni-nesp_dni)/celk_dni ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND $podmkonnex ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET zmax_gf=zmax_gf*(celk_dni-nesp_dni)/celk_dni, zmin_gf=zmin_gf*(celk_dni-nesp_dni)/celk_dni ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND $podmkonnex ";
$oznac = mysql_query("$sqtoz");

//prechod na denny vymariavaci zaklad SP
if( $kli_vrok > 2011 ) {

$pocetdni=30;
$sqltt = "SELECT * FROM kalendar WHERE ume = $kli_vume ";
$sql = mysql_query("$sqltt");
$pocetdni = mysql_num_rows($sql);

//echo $pocetdni;
//exit;

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzddennyzaklad'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   zkl_vys6     DECIMAL(10,6) DEFAULT 0,
   zkl_niz6     DECIMAL(10,6) DEFAULT 0,
   zkl_vysm     DECIMAL(10,6) DEFAULT 0,
   zkl_nizm     DECIMAL(10,6) DEFAULT 0,
   zkl_vys      DECIMAL(10,2) DEFAULT 0,
   zkl_niz      DECIMAL(10,2) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzddennyzaklad'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$sqtoz = "INSERT INTO F$kli_vxcf"."_mzddennyzaklad$kli_uzid (zkl_vys) VALUES ( 0 ) ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzddennyzaklad$kli_uzid SET zkl_vys6=$max_sp/$pocetdni, zkl_niz6=$max_np/$pocetdni ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzddennyzaklad$kli_uzid SET zkl_vysm=zkl_vys6-0.005, zkl_nizm=zkl_niz6-0.005 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzddennyzaklad$kli_uzid SET zkl_vys=zkl_vysm, zkl_niz=zkl_nizm ";
$oznac = mysql_query("$sqtoz");

$denVzNp=36.02; $denVzGf=36.02; $denVzSp=96.06; $denVzIp=96.06; $denVzPn=96.06; $denVzRf=96.06;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddennyzaklad$kli_uzid ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $denVzNp=$riaddok->zkl_niz;
  $denVzGf=$riaddok->zkl_niz;
  $denVzSp=$riaddok->zkl_vys;
  $denVzIp=$riaddok->zkl_vys;
  $denVzPn=$riaddok->zkl_vys;
  $denVzRf=$riaddok->zkl_vys;
  }

//echo   $denVzNp." ".$denVzGf." ".$denVzSp." ".$denVzIp." ".$denVzPn." ".$denVzRf;
//exit;
//exit;

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET zmax_np=$denVzNp*(celk_dni-nesp_dni)  ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND $podmkonnex AND nesp_dni > 0 ";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz;
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET zmax_sp=$denVzSp*(celk_dni-nesp_dni)  ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND $podmkonnex AND nesp_dni > 0 ";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz;
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET zmax_ip=$denVzIp*(celk_dni-nesp_dni)  ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND $podmkonnex AND nesp_dni > 0 ";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz;
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET zmax_pn=$denVzPn*(celk_dni-nesp_dni)  ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND $podmkonnex AND nesp_dni > 0 ";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz;
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET zmax_rf=$denVzRf*(celk_dni-nesp_dni)  ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND $podmkonnex AND nesp_dni > 0 ";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz;
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET zmax_gf=$denVzGf*(celk_dni-nesp_dni)  ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND $podmkonnex AND nesp_dni > 0 ";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz;
//exit;

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzddennyzaklad'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
                         }
//koniec prechod na denny vymariavaci zaklad SP

//uprav maximalny a minimalny ak je znizeny uvazok v kun uvazn=1
//od 5.2011 neznizuj maximalny zaklad ZP,SP podla znizeneho uvazku, od 1.2011 uz minimalny nie je

//ak ma poisteny len jeden den napr. 1.2.2009 je nedela a maroduje od 2.2.2009 do 28.2.2009 vynuluj zaklad odvodov
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET des6=celk_dni-nesp_dni".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND nesp_dni > 0";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET zmin_zp=0, zmin_np=0, zmin_sp=0, zmin_ip=0, zmin_pn=0, zmin_up=0, zmin_gf=0, zmin_rf=0 ".
" WHERE zzam_zp = 0 AND zzam_np = 0 AND zzam_sp = 0 AND zzam_ip = 0 AND zzam_pn = 0 AND des6 = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET des6=0 ";
$oznac = mysql_query("$sqtoz");

//ak je 508 nechaj zaklad ZP neupravuj na min ani max
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET zmax_zp=zzam_zp, zmin_zp=zzam_zp ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND konnex = 508 ";
$oznac = mysql_query("$sqtoz");

//ak je 508 nechaj zaklad neupravuj na min ani max len do 2.2011

//vyhodnotenie dm=513 nahrada 60% neupravuj minimalny do SP
if( $alchem == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyx".$kli_uzid.
" SELECT 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,'0000-00-00',$kli_vume,oc,dm,'0000-00-00','0000-00-00',dni,hod,0,0,kc,0,0,0,0,0,0,0,".
" 9,0,0,0,0,0,0,0,".
" 0,0,".
" 0,0,0,0,0,0,0,". //DDP;
" 0,0,0,0,0,". //z kmenovych;
" 0,".
" 0,0,0,0". //nesp,nezp;
" FROM F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" WHERE dm = 513 ".
"";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid,F$kli_vxcf"."_mzdprcvyx$kli_uzid ".
" SET konnex=513 ".
" WHERE F$kli_vxcf"."_mzdprcneod$kli_uzid.oc = F$kli_vxcf"."_mzdprcvyx$kli_uzid.oc AND kc > 0  ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET ".
" zmin_np=zzam_np, ".
" zmin_sp=zzam_sp, ".
" zmin_ip=zzam_ip, ".
" zmin_pn=zzam_pn, ".
" zmin_up=zzam_up, ".
" zmin_gf=zzam_gf, ".
" zmin_rf=zzam_rf ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneod$kli_uzid.oc AND konnex = 513 ";
$oznac = mysql_query("$sqtoz");

}
//koniec vyhodnotenie 513

//ak je pomer na dohodu nechaj zaklad gf,up neupravuj min len max, od 1.1.2013 podla BA-26366/2013 z 7.2.2013

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zmax_gf=$max_gf, zmin_gf=zzam_gf ".
" WHERE spom = 41 AND zzam_gf <= 200 AND zzam_gf < $max_gf ";
$oznac = mysql_query("$sqtoz"); 

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdpomer SET zmax_up=$max_up, zmin_up=zzam_up ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.spom = F$kli_vxcf"."_mzdpomer.pm AND pm_doh = 1 AND zzam_up < $max_up";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdpomer SET zmax_up=$max_up, zmin_up=$max_up ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.spom = F$kli_vxcf"."_mzdpomer.pm AND pm_doh = 1 AND zzam_up >= $max_up";
$oznac = mysql_query("$sqtoz");
//exit;

//uprava zakladov SP,IP,RF pre pomer=41 podla veku od 1.1.2015 18rokov(vratane v mesiaci ma 18nast)-200Eur,26rokov(v celom roku)-200Eur 
//rovnako plati aj od 1.1.2019

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET des1=YEAR(dar), des2=MONTH(dar) ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND spom = 41 ";
$oznac = mysql_query("$sqtoz");

$kedyma26=$kli_vrok-26;

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET des2=12 WHERE spom = 41 AND des1 = $kedyma26  ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid ".
" SET des3=(($kli_vrok-des1)*12)+($kli_vmes-des2)  WHERE spom = 41 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid ".
" SET des6=des3/12  WHERE spom = 41 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid ".
" SET des6=30  WHERE spom = 41 AND des6 < 0 ";
$oznac = mysql_query("$sqtoz");

//exit;
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid ".
" SET zzam_sp=0, zzam_ip=0, zzam_rf=0, zfir_sp=0, zfir_ip=0, zfir_rf=0 WHERE spom = 41 AND zzam_sp <= 200 AND des6 <= 18 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid ".
" SET zzam_sp=zzam_sp-200, zzam_ip=zzam_ip-200, zzam_rf=zzam_rf-200, zfir_sp=zfir_sp-200, zfir_ip=zfir_ip-200, zfir_rf=zfir_rf-200  WHERE spom = 41 AND zzam_sp > 200 AND des6 <= 18 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid ".
" SET zzam_sp=0, zzam_ip=0, zzam_rf=0, zfir_sp=0, zfir_ip=0, zfir_rf=0 WHERE spom = 41 AND zzam_sp <= 200 AND des6 <= 26 AND des6 > 18 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid ".
" SET zzam_sp=zzam_sp-200, zzam_ip=zzam_ip-200, zzam_rf=zzam_rf-200, zfir_sp=zfir_sp-200, zfir_ip=zfir_ip-200, zfir_rf=zfir_rf-200 WHERE spom = 41 AND zzam_sp > 200 AND des6 <= 26 AND des6 > 18 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid ".
" SET des6=0, des3=0, des6=2, des1=0 ";
$oznac = mysql_query("$sqtoz");
//koniec uprava zakladov SP,IP,RF pre pomer=41  


//uprava zakladu zp pre zrz_dn=1 dochodca odvodova ulava DP od 1.7.2018
if( $kli_vrok >= 2018 )
  {

$sqltt = "SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE zrz_dn = 1 AND pom != 1 ";
$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
//echo $sqltt.$tvpol."<br />";
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);

//echo $rtov->oc." ".$tvpol."<br />";


$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid ".
" SET zzam_sp=0, zzam_ip=0, zzam_rf=0, zfir_sp=0, zfir_ip=0, zfir_rf=0 WHERE oc = $rtov->oc AND zzam_sp <= 200 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid ".
" SET zzam_sp=zzam_sp-200, zzam_ip=zzam_ip-200, zzam_rf=zzam_rf-200, zfir_sp=zfir_sp-200, zfir_ip=zfir_ip-200, zfir_rf=zfir_rf-200 ".
" WHERE oc = $rtov->oc AND zzam_sp > 200 ";
$oznac = mysql_query("$sqtoz");

 }

$i=$i+1;
   }

//exit;
   

  }
//koniec uprava zakladu zp pre zrz_dn=1 dochodca odvodova ulava DP od 1.7.2018

//uprav zaklad podla max a min od 1.2012 do zmin_up ulozim neupraveny zzam_zp
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zmin_up=zzam_zp WHERE oc > 0 ";
$oznac = mysql_query("$sqtoz");

//tuto vypocitam odvodovu ulavu zp
// ak od 380 do 570 do zmin_pn upraveny zaklad zp a do zmin_ip je odpocitatelna polozka
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zmin_ip=0, zmin_pn=0, des6=0, des2=0 WHERE oc > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET zmin_ip=zzam_zp ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND deti_sp = 1 AND zzam_zp < 380 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET zmin_ip=380-(2*(zzam_zp-380)) ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND deti_sp = 1 AND zzam_zp >= 380 AND zzam_zp < 570 ";
$oznac = mysql_query("$sqtoz");

//alikvotne znizenie o 502,503 a ak nemal zmluvu cely mesiac
$prvydena=$kli_vrok."-".$kli_vmes."-01";
$pocetdnia=31;
$sqltt = "SELECT * FROM kalendar WHERE ume = $kli_vume ";
$sql = mysql_query("$sqltt");
$pocetdnia = mysql_num_rows($sql);
$posldena=$kli_vrok."-".$kli_vmes."-".$pocetdni;

$dsqlt = "DROP TABLE F$kli_vxcf"."_mzdprcneoda$kli_uzid  "; $dsql = mysql_query("$dsqlt");
$dsqlt = "CREATE TABLE F$kli_vxcf"."_mzdprcneoda$kli_uzid  SELECT * FROM F$kli_vxcf"."_mzdprcneod$kli_uzid WHERE oc < 0 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcneoda$kli_uzid "." SELECT".
" oc,0,0,".
" dan,dav,0,0,0,0,0,0,0,0,0,0,".
"0,0".
" FROM F$kli_vxcf"."_$mzdkun".
" WHERE oc >= 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET celk_dni=1+TO_DAYS(den_posl)-TO_DAYS(den_prvy) ".
" WHERE oc >= 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcneoda$kli_uzid".
" SET nezp_dni=TO_DAYS(den_prvy)-TO_DAYS('$prvydena') ".
" WHERE oc >= 0 AND den_prvy > '$prvydena' AND den_prvy <= '$posldena' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcneoda$kli_uzid".
" SET nesp_dni=TO_DAYS('$posldena')-TO_DAYS(den_posl) ".
" WHERE oc >= 0 AND den_posl < '$posldena' AND den_posl > '$prvydena' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcneoda$kli_uzid "." SELECT".
" oc,0,0,".
" dp,dk,0,0,sum(dni),0,0,0,0,0,0,0,".
"0,0".
" FROM F$kli_vxcf"."_mzdprcvy$kli_uzid".
" WHERE id >= 0 AND ( dm = 502 OR dm = 503 ) ".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcneoda$kli_uzid "." SELECT".
" oc,sum(neod_dni),sum(neod_hod),".
" '','',sum(nesp_dni),sum(nesp_hod),sum(nezp_dni+nesp_dni),sum(nezp_hod),0,0,0,0,'$pocetdnia',0,".
"0,9".
" FROM F$kli_vxcf"."_mzdprcneoda$kli_uzid".
" WHERE oc >= 0 AND ".$podm_oc.
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcneoda$kli_uzid WHERE neoxx != 9 "; $dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcneoda$kli_uzid".
" SET des6=zmin_ip*(celk_dni-nezp_dni)/celk_dni ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_mzdprcneoda$kli_uzid.oc AND zmin_ip > 0 ";
$oznac = mysql_query("$sqtoz");


if( $kli_uzid > 0 )
{


$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcneoda$kli_uzid ".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcneoda$kli_uzid.oc=F$kli_vxcf"."_$mzdkun.oc ".
" WHERE deti_sp = 1 AND nezp_dni >= 0 ";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
//echo $sqltt.$tvpol."<br />";
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);


$skutzaklad=0;
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdprcsum$kli_uzid WHERE oc = $rtov->oc ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) 
{ 
$fir_riadok=mysql_fetch_object($fir_vysledok); 
$skutzaklad=$fir_riadok->zmin_up;
}


$prepzaklad=570*($rtov->celk_dni-$rtov->nezp_dni)/$rtov->celk_dni;
$rozd=$skutzaklad-$prepzaklad;


if( $skutzaklad > $prepzaklad AND $rozd > 0.05 ) 
{  
echo "Zamestnanec osË. $rtov->oc s prÌjmom ".$skutzaklad." asi nem· n·rok na odpoËet ZP !!!!! <br />"; 

echo "celkom dni v mesiaci ".$rtov->celk_dni." nepoistenÈ dni v mesiaci ".$rtov->nezp_dni."<br />";
echo "skutoËn˝ z·klad ZP ".$skutzaklad."<br />";
echo "prepoËÌtan˝ z·klad ZP ".$prepzaklad."<br />";

exit; 

}

 }

$i=$i+1;
   }

}
//koniec vyhodnod vysku prijmu pre odpocet ZP


if( $kli_uzid == 171717171717171 )
{


$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcneoda$kli_uzid  WHERE oc > 0 ";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
echo $sqltt.$tvpol."<br />";
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);


echo $rtov->oc.";".$rtov->celk_dni.";".$rtov->nezp_dni."<br />";

 }

$i=$i+1;
   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcsum$kli_uzid  WHERE oc > 0 ";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
echo $sqltt.$tvpol."<br />";
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);


echo $rtov->oc.";".$rtov->zzam_zp.";".$rtov->des6."<br />";

 }

$i=$i+1;
   }

exit;
}

 

$dsqlt = "DROP TABLE F$kli_vxcf"."_mzdprcneoda$kli_uzid  "; $dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET des6=des6+0.0049 ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND deti_sp = 1 AND zmin_ip > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET des2=des6  ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND deti_sp = 1 AND zmin_ip > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET zmin_ip=des2 ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND deti_sp = 1 AND zmin_ip > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid ".
" SET des6=0, des3=0, des6=2, des1=0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET zmin_pn=zzam_zp-zmin_ip  ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND deti_sp = 1";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET zzam_zp=zmin_pn ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND deti_sp = 1";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//exit;
//v zmin_pn znizeny, v zmin_ip je znizenie zakladu, v zmin_up je povodny
//koniec tuto vypocitam odvodovu ulavu zp

//exit;

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_zp=zmax_zp WHERE zzam_zp > zmax_zp ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_zp=zmin_zp WHERE zzam_zp < zmin_zp ";
//$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_np=zmax_np WHERE zzam_np > zmax_np ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_np=zmin_np WHERE zzam_np < zmin_np ";
//$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_sp=zmax_sp WHERE zzam_sp > zmax_sp ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_sp=zmin_sp WHERE zzam_sp < zmin_sp ";
//$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_ip=zmax_ip WHERE zzam_ip > zmax_ip ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_ip=zmin_ip WHERE zzam_ip < zmin_ip ";
//$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_pn=zmax_pn WHERE zzam_pn > zmax_pn ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_pn=zmin_pn WHERE zzam_pn < zmin_pn ";
//$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_up=zmax_up WHERE zzam_up > zmax_up ";
//$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_up=zmin_up WHERE zzam_up < zmin_up ";
//$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_gf=zmax_gf WHERE zzam_gf > zmax_gf ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_gf=zmin_gf WHERE zzam_gf < zmin_gf ";
//$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_rf=zmax_rf WHERE zzam_rf > zmax_rf ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_rf=zmin_rf WHERE zzam_rf < zmin_rf ";
//$oznac = mysql_query("$sqtoz");

//exit;

//uprava zakladov ak dochodca starobny sdoch  a vysluhovy sdocv
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET zzam_ip=0, zzam_pn=0 ".
" WHERE sdoch = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET zzam_ip=0, zzam_pn=0 ".
" WHERE sdocv = 1 ";
$oznac = mysql_query("$sqtoz");

//uprav zaklady podla zpnie,spnie
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET zzam_zp=0 WHERE szpnie = 1";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET zzam_np=0, zzam_sp=0, zzam_ip=0, zzam_pn=0, zzam_up=0, zzam_gf=0, zzam_rf=0 ".
" WHERE sspnie = 1";
$oznac = mysql_query("$sqtoz");

//uprav max zaklady ak nahodou > ako maximalne tak daj maximalny
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_zp=$max_zp WHERE zzam_zp > $max_zp "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_np=$max_np WHERE zzam_np > $max_np "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_sp=$max_sp WHERE zzam_sp > $max_sp "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_ip=$max_ip WHERE zzam_ip > $max_ip "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_pn=$max_pn WHERE zzam_pn > $max_pn "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_up=$max_up WHERE zzam_up > $max_up "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_gf=$max_gf WHERE zzam_gf > $max_gf "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET zzam_rf=$max_rf WHERE zzam_rf > $max_rf "; $oznac = mysql_query("$sqtoz");


//zaklad firma zp,np,.....,gf,rf 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET zfir_zp=zzam_zp, zfir_np=zzam_np, zfir_sp=zzam_sp, zfir_ip=zzam_ip, zfir_pn=zzam_pn, zfir_up=zzam_up, zfir_gf=zzam_gf, zfir_rf=zzam_rf ".
" WHERE oc > 0 ";
$oznac = mysql_query("$sqtoz");

//ak ma odpocitatelnu ZP od 1.1.2018 za zamestnavatela neuplatnuje
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET zfir_zp=zmin_up ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND deti_sp = 1";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//exit;

//vypocet odvody
//od 1.1.2011 zaokruhlenie odvodov SP na eurocenty dole
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET ".
" des6=($zam_zp*zzam_zp)/100, des6=des6-0.005, des2=des6, ozam_zp=des2, ".
" des6=($fir_zp*zfir_zp)/100, des6=des6-0.005, des2=des6, ofir_zp=des2, ".
" des6=($zam_np*zzam_np)/100, des6=des6-0.005, des2=des6, ozam_np=des2, ".
" des6=($fir_np*zfir_np)/100, des6=des6-0.005, des2=des6, ofir_np=des2, ".
" des6=($zam_sp*zzam_sp)/100, des6=des6-0.005, des2=des6, ozam_sp=des2, ".
" des6=($fir_sp*zfir_sp)/100, des6=des6-0.005, des2=des6, ofir_sp=des2, ".
" des6=($zam_ip*zzam_ip)/100, des6=des6-0.005, des2=des6, ozam_ip=des2, ".
" des6=($fir_ip*zfir_ip)/100, des6=des6-0.005, des2=des6, ofir_ip=des2, ".
" des6=($zam_pn*zzam_pn)/100, des6=des6-0.005, des2=des6, ozam_pn=des2, ".
" des6=($fir_pn*zfir_pn)/100, des6=des6-0.005, des2=des6, ofir_pn=des2, ".
" des6=($zam_up*zzam_up)/100, des6=des6-0.005, des2=des6, ozam_up=des2, ".
" des6=($fir_up*zfir_up)/100, des6=des6-0.005, des2=des6, ofir_up=des2, ".
" des6=($zam_gf*zzam_gf)/100, des6=des6-0.005, des2=des6, ozam_gf=des2, ".
" des6=($fir_gf*zfir_gf)/100, des6=des6-0.005, des2=des6, ofir_gf=des2, ".
" des6=($zam_rf*zzam_rf)/100, des6=des6-0.005, des2=des6, ozam_rf=des2, ".
" des6=($fir_rf*zfir_rf)/100, des6=des6-0.005, des2=des6, ofir_rf=des2, ".
" zzam_up=0, zzam_gf=0, zzam_rf=0, des1=0, des2=0, des3=0, des6=0 ".
" WHERE oc > 0 ";
$oznac = mysql_query("$sqtoz");

//znizene odvody do ZP polozka v kun zpno=1 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET des6=($zam_zpn*zzam_zp)/100, des2=999 ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND zpno = 1";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//exit;

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid ".
" SET des6=des6-0.005, des2=des6, ozam_zp=des2 ".
" WHERE des2 = 999";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET des6=($fir_zpn*zfir_zp)/100, des2=999 ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND zpno = 1";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid ".
" SET des6=des6-0.005, des2=des6, ofir_zp=des2 ".
" WHERE des2 = 999";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET des6=0, des2=0, des1=0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//ak viac pracovn˝ch pomerov odvod do DOVERA je odvod zo suctu zakladov 
$prepsub=0;
$podm_hlvn="hlvn > 0";
if( $all_oc == 0 )
{
$podm_hlvn="hlvn = ".$vyb_osc;
}
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdsubeznepp WHERE $podm_hlvn ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $hlvn=1*$riaddok->hlvn;
  $sub1=1*$riaddok->sub1;
  $sub2=1*$riaddok->sub2;
  if( $hlvn > 0 ) { $prepsub=1; }
  }
//if( $_SERVER['SERVER_NAME'] == "www.eurorekoplast.sk" ) { $prepsub=1; }
if( $all_oc == 0 ) { $prepsub=0; }
if( $prepsub == 1 )
   {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ozam_zp=1.69 WHERE ozam_zp = 1.68 AND oc = 916 AND ume = 3.2018 "; 
//$oznac = mysql_query("$sqtoz");

$sql = "DROP TABLE F".$kli_vxcf."_mzdsubodv".$kli_uzid;
$ulozene = mysql_query("$sql");

$sqlt = <<<uctmzd
(
   hlvn        DECIMAL(10,0) DEFAULT 0,
   zzam        DECIMAL(10,2) DEFAULT 0,
   zfir        DECIMAL(10,2) DEFAULT 0,
   ozam        DECIMAL(10,2) DEFAULT 0,
   ofir        DECIMAL(10,2) DEFAULT 0,
   ozan        DECIMAL(10,2) DEFAULT 0,
   ofin        DECIMAL(10,2) DEFAULT 0,
   ozax        DECIMAL(10,2) DEFAULT 0,
   ofix        DECIMAL(10,2) DEFAULT 0,
   des2        DECIMAL(10,2) DEFAULT 0,
   des6        DECIMAL(13,6) DEFAULT 0
);
uctmzd;


$sql = "CREATE TABLE F".$kli_vxcf."_mzdsubodv".$kli_uzid.$sqlt;
$ulozene = mysql_query("$sql");

$tovttt = "SELECT * FROM F$kli_vxcf"."_mzdsubeznepp WHERE $podm_hlvn ";
$tov = mysql_query("$tovttt");
$tvpol = mysql_num_rows($tov);
$i=0;
  while ($i < $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

$zdrv=0; $zpno=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE oc = $rtov->hlvn ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zdrv=$riaddok->zdrv;
  $zpno=1*$riaddok->zpno;
  }

if( $zdrv >= 2400 AND $zdrv <= 2499 )
    {

$sql = "TRUNCATE F".$kli_vxcf."_mzdsubodv".$kli_uzid;
$ulozene = mysql_query("$sql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdsubodv".$kli_uzid." ".
" SELECT $rtov->hlvn,sum(zzam_zp),sum(zfir_zp),sum(ozam_zp),sum(ofir_zp),0,0,0,0,0,0 ".
" FROM F$kli_vxcf"."_mzdprcsum".$kli_uzid.
" WHERE ( oc = $rtov->hlvn OR oc = $rtov->sub1 OR oc = $rtov->sub2 ) AND oc > 0 GROUP BY ksum2 ";
//echo $dsqlt."<br />";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdsubodv$kli_uzid".
" SET ".
" des6=($zam_zp*zzam)/100, des6=des6-0.005, des2=des6, ozan=des2, ".
" des6=($fir_zp*zfir)/100, des6=des6-0.005, des2=des6, ofin=des2  ".
" WHERE hlvn > 0 ";
$oznac = mysql_query("$sqtoz");

if( $zpno == 1 )
    {

$sqtoz = "UPDATE F$kli_vxcf"."_mzdsubodv$kli_uzid".
" SET ".
" des6=($zam_zpn*zzam)/100, des6=des6-0.005, des2=des6, ozan=des2, ".
" des6=($fir_zpn*zfir)/100, des6=des6-0.005, des2=des6, ofin=des2  ".
" WHERE hlvn > 0 ";
$oznac = mysql_query("$sqtoz");

    }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdsubodv$kli_uzid SET ozax=ozan-ozam, ofix=ofin-ofir WHERE hlvn > 0 ";
$oznac = mysql_query("$sqtoz");


//echo $rtov->hlvn.";".$rtov->sub1.";".$rtov->sub2."<br />";

$ozax=0; $ofix=0;
$sqldo2 = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdsubodv$kli_uzid ");
  if (@$zaznam=mysql_data_seek($sqldo2,0))
  {
  $riaddo2=mysql_fetch_object($sqldo2);
  $ozax=1*$riaddo2->ozax;
  $ofix=1*$riaddo2->ofix;
  if( $ozax > 0.03 OR $ozax < -0.03 ) { $ozax=0; }
  if( $ofix > 0.03 OR $ofix < -0.03 ) { $ofix=0; }
  }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ozam_zp=ozam_zp+$ozax WHERE oc = $rtov->hlvn ";
//echo $sqtoz."<br />";
if( $ozax != 0 ) { $oznac = mysql_query("$sqtoz"); }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ofir_zp=ofir_zp+$ofix WHERE oc = $rtov->hlvn ";
if( $ofix != 0 ) { $oznac = mysql_query("$sqtoz"); }

    }

 }

$i=$i+1;
   }

//exit;
$sql = "DROP TABLE F".$kli_vxcf."_mzdsubodv".$kli_uzid;
$ulozene = mysql_query("$sql");

   }
//koniec ak viac pracovn˝ch pomerov odvod do DOVERA je odvod zo suctu zakladov 

//poistka ak odvod < 0 potom odvod=0
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ozam_zp=0 WHERE ozam_zp < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ofir_zp=0 WHERE ofir_zp < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ozam_np=0 WHERE ozam_np < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ofir_np=0 WHERE ofir_np < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ozam_sp=0 WHERE ozam_sp < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ofir_sp=0 WHERE ofir_sp < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ozam_ip=0 WHERE ozam_ip < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ofir_ip=0 WHERE ofir_ip < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ozam_pn=0 WHERE ozam_pn < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ofir_pn=0 WHERE ofir_pn < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ozam_up=0 WHERE ozam_up < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ofir_up=0 WHERE ofir_up < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ozam_gf=0 WHERE ozam_gf < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ofir_gf=0 WHERE ofir_gf < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ozam_rf=0 WHERE ozam_rf < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ofir_rf=0 WHERE ofir_rf < 0 "; $oznac = mysql_query("$sqtoz");

//uprava zakladov podla pomeru 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdpomer".
" SET zzam_zp=zam_zp*zzam_zp, zfir_zp=fir_zp*zfir_zp, ozam_zp=zam_zp*ozam_zp, ofir_zp=fir_zp*ofir_zp, ".
" zzam_np=zam_np*zzam_np, zfir_np=fir_np*zfir_np, ozam_np=zam_np*ozam_np, ofir_np=fir_np*ofir_np, ".
" zzam_sp=zam_sp*zzam_sp, zfir_sp=fir_sp*zfir_sp, ozam_sp=zam_sp*ozam_sp, ofir_sp=fir_sp*ofir_sp, ".
" zzam_ip=zam_ip*zzam_ip, zfir_ip=fir_ip*zfir_ip, ozam_ip=zam_ip*ozam_ip, ofir_ip=fir_ip*ofir_ip, ".
" zzam_pn=zam_pn*zzam_pn, zfir_pn=fir_pn*zfir_pn, ozam_pn=zam_pn*ozam_pn, ofir_pn=fir_pn*ofir_pn, ".
" zzam_up=zam_up*zzam_up, zfir_up=fir_up*zfir_up, ozam_up=zam_up*ozam_up, ofir_up=fir_up*ofir_up, ".
" zzam_gf=zam_gf*zzam_gf, zfir_gf=fir_gf*zfir_gf, ozam_gf=zam_gf*ozam_gf, ofir_gf=fir_gf*ofir_gf, ".
" zzam_rf=zam_rf*zzam_rf, zfir_rf=fir_rf*zfir_rf, ozam_rf=zam_rf*ozam_rf, ofir_rf=fir_rf*ofir_rf ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.spom = F$kli_vxcf"."_mzdpomer.pm";
$oznac = mysql_query("$sqtoz");


//dan z prijmu odpocitatelna polozka na danovnika=0 ak doch=0 a docv=0 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET pdan_dnv=$dan_danov WHERE sdoch = 0 AND sdocv = 0";
$oznac = mysql_query("$sqtoz");

//zrus odpocitatelnu na danovnika ak v kmenovych ziv_dn=1
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET pdan_dnv=0 WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND ziv_dn = 1";
$oznac = mysql_query("$sqtoz");

//uprava odpocitatelnej polozky podla pomeru 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdpomer".
" SET pdan_dnv=pdan_dnv*zam_zm ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.spom = F$kli_vxcf"."_mzdpomer.pm";
$oznac = mysql_query("$sqtoz");

//danovy bonus 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET bonus_dan=deti_dn*$dan_bonus WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc AND deti_dn > 0 AND zdan_dnp >= $min_mzd2 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//odvody nepravidelny prijem
if( $fir_mzdx03 == 1 )
     {
$neprprijem = include("neprav_prijem.php");

     }
//koniec odvody nepravidelny prijem

//dan z prijmu vypocet od 1.1.2019 zmena oproti 2018 do 3021.36 Eur zaklad 19% a 25% z rozdielu nad 3021.36 Eur 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET pdan_fnd=ozam_zp+ozam_np+ozam_sp+ozam_ip+ozam_pn+ozam_up+ozam_gf+ozam_rf, pdan_zn1=ddp_fir,".
" zakl_dan=zdan_dnp-pdan_dnv-pdan_fnd+pdan_zn1-pdan_zn2, des6=($dan_perc*zakl_dan)/100, des6=des6-0.005, des2=des6, odan_dnp=des2, ".
" des1=0, des2=0, des3=0, des6=0  ".
" WHERE oc > 0 AND zakl_dan <= 3021.36  ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET pdan_fnd=ozam_zp+ozam_np+ozam_sp+ozam_ip+ozam_pn+ozam_up+ozam_gf+ozam_rf, pdan_zn1=ddp_fir,".
" zakl_dan=zdan_dnp-pdan_dnv-pdan_fnd+pdan_zn1-pdan_zn2-3021.36, des6=(25*zakl_dan)/100, des6=des6+574.0584, des6=des6-0.005, des2=des6, odan_dnp=des2, ".
" des1=0, des2=0, des3=0, des6=0  ".
" WHERE oc > 0 AND zakl_dan > 3021.36 ";
$oznac = mysql_query("$sqtoz");

//poistka ak dan < 0 potom dan=0
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET odan_dnp=0, zakl_dan=0 WHERE odan_dnp < 0 "; $oznac = mysql_query("$sqtoz");

//zrazkova dan od 1.1.2011 zrusena

//odvody spolu a zvys zrazky o dan a odvody a bonus
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ozam_spolu=ozam_zp+ozam_np+ozam_sp+ozam_ip+ozam_pn+ozam_up+ozam_gf+ozam_rf,".
"ofir_spolu=ofir_zp+ofir_np+ofir_sp+ofir_ip+ofir_pn+ofir_up+ofir_gf+ofir_rf, ".
"sum_zrz=sum_zrz+ozam_spolu+odan_dnp+odan_zrz-bonus_dan WHERE oc > 0 ";
$oznac = mysql_query("$sqtoz");

//odbory pocitaj
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcodb'.$kli_uzid.'';
$vytvor = mysql_query("$vsql");

$sqlt = <<<mzdprc
(
   rohx         DECIMAL(3,0) DEFAULT 0,
   oc           INT(7) DEFAULT 0,
   dm           INT(7) DEFAULT 0,
   kc           DECIMAL(10,2) DEFAULT 0,
   zakl_odb     DECIMAL(10,2) DEFAULT 0,
   odvod_fnd    DECIMAL(10,2) DEFAULT 0,
   dan_prj      DECIMAL(10,2) DEFAULT 0,
   zaku_odb     DECIMAL(10,2) DEFAULT 0,
   odvod_odb    DECIMAL(10,2) DEFAULT 0,
   konnex       DECIMAL(10,2) DEFAULT 0,
   neoxx        INT 
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcodb'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

//zober kun do odborov
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcodb".$kli_uzid." SELECT roh,oc,0,0,0,0,0,0,0,0,0  FROM F$kli_vxcf"."_$mzdkun WHERE roh = 1 AND ".$podm_oc."";
$dsql = mysql_query("$dsqlt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcodb".$kli_uzid."";
$sql = mysql_query("$sqltt");
$hlvpol = mysql_num_rows($sql);
$hlvpol=1*$hlvpol;
if( $hlvpol > 0 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcodb".$kli_uzid." SELECT 0,oc,0,0,0,ozam_spolu,(odan_dnp+odan_zrz),0,0,0,0 FROM F$kli_vxcf"."_mzdprcsum$kli_uzid ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcodb".$kli_uzid." SELECT 0,oc,dm,kc,0,0,0,0,0,0,0 FROM F$kli_vxcf"."_mzdprcvy$kli_uzid WHERE dm > 100 AND dm < 800 ";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcodb$kli_uzid,F$kli_vxcf"."_mzddmn ".
" SET zakl_odb=kc WHERE F$kli_vxcf"."_mzdprcodb$kli_uzid.dm=F$kli_vxcf"."_mzddmn.dm AND rh = 1 ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcodb".$kli_uzid." SELECT SUM(rohx),oc,0,0,SUM(zakl_odb),SUM(odvod_fnd),SUM(dan_prj),0,0,0,9 ".
" FROM F$kli_vxcf"."_mzdprcodb$kli_uzid GROUP BY oc";
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcodb$kli_uzid WHERE neoxx != 9 OR rohx != 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcodb$kli_uzid SET zaku_odb=zakl_odb-odvod_fnd-dan_prj, odvod_odb=zaku_odb*0.01 WHERE oc > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcodb$kli_uzid WHERE odvod_odb < 0 ";
$oznac = mysql_query("$sqtoz");

//zober odvod odbory do pohybov
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" SELECT 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,'0000-00-00',$kli_vume,oc,920,'0000-00-00','0000-00-00',0,0,0,0,odvod_odb,(odvod_odb*$kurz12),0,0,0,0,0,0,".
" 9,0,0,0,0,0,0,0,".
" 0,0,".
" 0,0,0,0,0,0,0,". //DDP;
" 0,0,0,0,0,". //z kmenovych;
" 0,".
" 0,0,0,0". //nesp,nezp;
" FROM F$kli_vxcf"."_mzdprcodb".$kli_uzid.
" WHERE odvod_odb > 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdprcodb$kli_uzid ".
" SET sum_zrz=sum_zrz+odvod_odb WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc=F$kli_vxcf"."_mzdprcodb$kli_uzid.oc ";
$oznac = mysql_query("$sqtoz");
}
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcodb'.$kli_uzid.'';
$vytvor = mysql_query("$vsql");
//koniec odbory

//zober odvod ZP,SP do pohybov
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" SELECT 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,'0000-00-00',$kli_vume,oc,904,'0000-00-00','0000-00-00',0,0,0,0,ozam_spolu,(ozam_spolu*$kurz12),0,0,0,0,0,0,".
" 9,0,0,0,0,0,0,0,".
" 0,0,".
" 0,0,0,0,0,0,0,". //DDP;
" 0,0,0,0,0,". //z kmenovych;
" 0,".
" 0,0,0,0". //nesp,nezp;
" FROM F$kli_vxcf"."_mzdprcsum".$kli_uzid.
" WHERE ozam_spolu != 0 ".
"";
$dsql = mysql_query("$dsqlt");

//zober dan z prijmov do pohybov
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" SELECT 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,'0000-00-00',$kli_vume,oc,901,'0000-00-00','0000-00-00',0,0,0,0,odan_dnp,(odan_dnp*$kurz12),0,0,0,0,0,0,".
" 9,0,0,0,0,0,0,0,".
" 0,0,".
" 0,0,0,0,0,0,0,". //DDP;
" 0,0,0,0,0,". //z kmenovych;
" 0,".
" 0,0,0,0". //nesp,nezp;
" FROM F$kli_vxcf"."_mzdprcsum".$kli_uzid.
" WHERE odan_dnp != 0 ".
"";
$dsql = mysql_query("$dsqlt");

//zober zrazkovu dan do pohybov
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" SELECT 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,'0000-00-00',$kli_vume,oc,951,'0000-00-00','0000-00-00',0,0,0,0,odan_zrz,(odan_zrz*$kurz12),0,0,0,0,0,0,".
" 9,0,0,0,0,0,0,0,".
" 0,0,".
" 0,0,0,0,0,0,0,". //DDP;
" 0,0,0,0,0,". //z kmenovych;
" 0,".
" 0,0,0,0". //nesp,nezp;
" FROM F$kli_vxcf"."_mzdprcsum".$kli_uzid.
" WHERE odan_zrz != 0 ".
"";
$dsql = mysql_query("$dsqlt");

//zober dan.bonus do pohybov
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" SELECT 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,'0000-00-00',$kli_vume,oc,902,'0000-00-00','0000-00-00',0,0,0,0,-(bonus_dan),-(bonus_dan*$kurz12),0,0,0,0,0,0,".
" 9,0,0,0,0,0,0,0,".
" 0,0,".
" 0,0,0,0,0,0,0,". //DDP;
" 0,0,0,0,0,". //z kmenovych;
" 0,".
" 0,0,0,0". //nesp,nezp;
" FROM F$kli_vxcf"."_mzdprcsum".$kli_uzid.
" WHERE bonus_dan != 0 ".
"";
$dsql = mysql_query("$dsqlt");

//vypocitaj k vyplate v hotovosti
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET sum_hot=sum_hru+sum_nem-sum_zrz,".
" hot_eur=sum_hot*$kurz12 ".
" WHERE oc > 0 ";
$oznac = mysql_query("$sqtoz");

//vypocitaj k vyplate cez banku
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET sum_ban=sum_hot,".
" sum_hot=0 ".
" WHERE oc > 0 AND svban = 1 AND snumb >= 0000 ";
$oznac = mysql_query("$sqtoz");


//vypocitaj celkovu cenu prace eur aj sk
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET sum_cccp=sum_hru+ofir_spolu, sum_cccpsk=sum_cccp*$kurz12 ".
" WHERE oc > 0 ";
$oznac = mysql_query("$sqtoz");

//vypocitaj cistu mzdu eur aj sk
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid".
" SET cista_mzda=sum_hru-odan_dnp-ozam_spolu-odan_zrz, cista_mzdask=cista_mzda*$kurz12 ".
" WHERE oc > 0 ";
$oznac = mysql_query("$sqtoz");

//vypocitaj odvod na DSS od 1.1.2019 4.75% z 18tich
if( $kli_vrok >= 2019 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid SET ozam_dss= 4.75 * ( ozam_sp+ofir_sp ) / 18  WHERE oc > 0 AND scdss > 0 ";
$oznac = mysql_query("$sqtoz");
  }

//daj do vy jeden riadok za oc zo sum na odstrankovanie konx=9999
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvy".$kli_uzid.
" SELECT 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,'0000-00-00',$kli_vume,oc,0,'0000-00-00','0000-00-00',0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,".
" 0,0,".
" 0,0,0,0,0,0,0,". //DDP;
" 0,0,0,0,0,". //z kmenovych;
" 9999,".
" 0,0,0,0". //nesp,nezp;
" FROM F$kli_vxcf"."_mzdprcsum".$kli_uzid.
" WHERE oc >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

//KONIEC VYPOCET LEN KED NEOSTRE ALEBO OSTRE
         }

//KED PASKY Z MENU LEN ZOBER vy a sum zo ZAL
if( $copern == 11 )
         {
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvy".$kli_uzid." SELECT ".
"cel_dni,cel_hod,cel_hru,cel_nem,cel_zrz,cel_hot,cel_ban,czz_zzp,czz_znp,czz_zsp,czz_zip,czz_zpn,czz_zup,czz_zgf,czz_zrf,".
"dok,dat,ume,oc,dm,dp,dk,dni,hod,mnz,saz,kc,kcsk,str,zak,stj,trncpl,czd_dnp,id,odkial,trx1,dne,hne,prd,prh,ds6,ds2,neod_dni,neod_hod,".
"cddp,ddp_perz,ddp_fixz,ddp_perp,ddp_fixp,ddp_zam,ddp_fir,vdoch,vdocv,vspnie,vzpnie,vpom,konx,nesp_dni,nesp_hod,nezp_dni,nezp_hod".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume = $kli_vume";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcsum".$kli_uzid." SELECT ".
"sum_dni,sum_hod,sum_hru,sum_nem,sum_zrz,sum_hot,sum_ban,zzam_zp,zzam_np,zzam_sp,zzam_ip,zzam_pn,zzam_up,zzam_gf,zzam_rf,".
"zfir_zp,zfir_np,zfir_sp,zfir_ip,zfir_pn,zfir_up,zfir_gf,zfir_rf,ozam_zp,ozam_np,ozam_sp,ozam_ip,ozam_pn,ozam_up,ozam_gf,ozam_rf,".
"ofir_zp,ofir_np,ofir_sp,ofir_ip,ofir_pn,ofir_up,ofir_gf,ofir_rf,ozam_spolu,ofir_spolu,des1,des2,des3,des6,ume,oc,".
"zdan_dnp,odan_dnp,pdan_dnv,pdan_fnd,pdan_zn1,pdan_zn2,odan_zrz,zakl_dan,bonus_dan,id,hot_eur,ban_eur,ddp_zam,ddp_fir,sum_cccp,sum_cccpsk,".
"cista_mzda,cista_mzdask,sdoch,sdocv,sspnie,szpnie,spom,svban,snumb,scdss,ozam_dss,suva,ksum1,zmax_zp,zmax_np,zmax_sp,zmax_ip,zmax_pn,".
"zmax_up,zmax_gf,zmax_rf,zmin_zp,zmin_np,zmin_sp,zmin_ip,zmin_pn,zmin_up,zmin_gf,zmin_rf,ksum2".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE ume = $kli_vume";
$dsql = mysql_query("$dsqlt");

         }
//koniec ak pasky z menu zober sum a vy zo zal

//cerpanie dovolenky z vy

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdcerp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   dmx          INT, 
   umxq         DECIMAL(10,4) DEFAULT 0,
   cerp_dni     DECIMAL(10,2) DEFAULT 0,
   dovx         INT, 
   dovy         INT 
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdcerp'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdcerp".$kli_uzid.
" SELECT oc,dm,ume,dni,0,0 FROM F$kli_vxcf"."_mzdprcvy".$kli_uzid." WHERE ( dm >= 500 AND dm < 600 ) AND ume = $kli_vume";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdcerp".$kli_uzid.
" SELECT oc,dm,ume,dni,0,0 FROM F$kli_vxcf"."_mzdzalvy WHERE ( dm >= 500 AND dm < 600 ) AND ume < $kli_vume";
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdcerp".$kli_uzid.
" SELECT oc,506,0,0,0,0 FROM F$kli_vxcf"."_$mzdkun WHERE oc > 0 ";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdcerp$kli_uzid,F$kli_vxcf"."_mzddmn".
" SET dovx=do ".
" WHERE F$kli_vxcf"."_mzdcerp$kli_uzid.dmx = F$kli_vxcf"."_mzddmn.dm";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdcerp".$kli_uzid.
" SELECT oc,dmx,0,".
"sum(cerp_dni),dovx,1".
" FROM F$kli_vxcf"."_mzdcerp".$kli_uzid.
" WHERE oc >= 0 AND dovx = 1".
" GROUP BY oc";
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdcerp$kli_uzid WHERE dovy = 0";
$oznac = mysql_query("$sqtoz");

//cepanie dovolenky z vy koniec

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>V˝platn· p·ska</title>
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
    



</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  V˝platn· p·ska <?php echo $vyb_osc; ?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if ( $kontrola == 1 )
{
?>
<script type="text/javascript">
window.open('../mzdy/kontrola.php?copern=1&drupoh=1', '_self' );
</script>
<?php
exit;
}
?>

<?php
//subor so zakladmi z trvalych
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprczaklady'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   och           INT(7) DEFAULT 0,
   dmh           INT(7) DEFAULT 0,
   kch           DECIMAL(10,2) DEFAULT 0,
   konh2         DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprczaklady'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

//echo "ostre".$ostre." "."data_zal".$data_zal." "."ostre".$ostre." ";

if( $ostre == 0 OR $data_zal == 0 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprczaklady".$kli_uzid." SELECT oc,dm,kc,0 FROM F$kli_vxcf"."_mzdtrn".
" WHERE trx1 = 1 AND ".$podm_oc." ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}
if( $ostre == 1 AND $data_zal == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprczaklady".$kli_uzid." SELECT oc,dm,kc,0 FROM F$kli_vxcf"."_mzdzaltrn".
" WHERE trx1 = 1 AND ume = $kli_vume AND ".$podm_oc." ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}
?>


<?php
//tlac pasky

$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/mzdpasky_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/mzdpasky_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$sql = "DROP TABLE F".$kli_vxcf."_mzdprcvypp".$kli_uzid." ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_mzdprcvypp".$kli_uzid." ".
"SELECT * FROM F".$kli_vxcf."_mzdprcvy".$kli_uzid." WHERE oc=0";
$vysledek = mysql_query("$sql");

$podmeso="";
if( $esoplast == 1 ) { $podmeso=" AND dm != 105 "; }
if( $polno == 1 ) { $podmeso=" AND dm != 107 AND dm != 302 AND dm != 104 AND dm != 108 "; }
if( $fir_mzdx02 == 1 ) { $esoplast=0; $polno=0; $podmeso=" AND dm != 104 AND dm != 105 AND dm != 106 AND dm != 107 AND dm != 108 AND dm != 302 "; }

$dsqlt = "INSERT INTO F".$kli_vxcf."_mzdprcvypp".$kli_uzid."  SELECT ".
"cel_dni,cel_hod,cel_hru,cel_nem,cel_zrz,cel_hot,cel_ban,czz_zzp,czz_znp,czz_zsp,czz_zip,czz_zpn,czz_zup,czz_zgf,czz_zrf,".
"dok,dat,ume,oc,dm,dp,dk,dni,hod,mnz,saz,kc,kcsk,str,zak,stj,trncpl,czd_dnp,id,odkial,trx1,dne,hne,prd,prh,ds6,ds2,neod_dni,neod_hod,".
"cddp,ddp_perz,ddp_fixz,ddp_perp,ddp_fixp,ddp_zam,ddp_fir,vdoch,vdocv,vspnie,vzpnie,vpom,konx,nesp_dni,nesp_hod,nezp_dni,nezp_hod".
" FROM F$kli_vxcf"."_mzdprcvy".$kli_uzid." ".
" WHERE oc >= 0 $podmeso ";
$dsql = mysql_query("$dsqlt");

if( $esoplast == 1 ) {
$dsqlt = "INSERT INTO F".$kli_vxcf."_mzdprcvypp".$kli_uzid."  SELECT ".
"cel_dni,cel_hod,cel_hru,cel_nem,cel_zrz,cel_hot,cel_ban,czz_zzp,czz_znp,czz_zsp,czz_zip,czz_zpn,czz_zup,czz_zgf,czz_zrf,".
"dok,dat,ume,oc,dm,dp,dk,sum(dni),sum(hod),sum(mnz),saz,sum(kc),sum(kcsk),str,zak,stj,trncpl,czd_dnp,id,odkial,trx1,dne,hne,prd,prh,ds6,ds2,neod_dni,neod_hod,".
"cddp,ddp_perz,ddp_fixz,ddp_perp,ddp_fixp,ddp_zam,ddp_fir,vdoch,vdocv,vspnie,vzpnie,vpom,konx,nesp_dni,nesp_hod,nezp_dni,nezp_hod".
" FROM F$kli_vxcf"."_mzdprcvy".$kli_uzid." ".
" WHERE oc >= 0 AND dm = 105 GROUP BY oc";
$dsql = mysql_query("$dsqlt");
                     }
if( $polno == 1 ) {
$dsqlt = "INSERT INTO F".$kli_vxcf."_mzdprcvypp".$kli_uzid."  SELECT ".
"cel_dni,cel_hod,cel_hru,cel_nem,cel_zrz,cel_hot,cel_ban,czz_zzp,czz_znp,czz_zsp,czz_zip,czz_zpn,czz_zup,czz_zgf,czz_zrf,".
"dok,dat,ume,oc,dm,dp,dk,sum(dni),sum(hod),sum(mnz),saz,sum(kc),sum(kcsk),str,zak,stj,trncpl,czd_dnp,id,odkial,trx1,dne,hne,prd,prh,ds6,ds2,neod_dni,neod_hod,".
"cddp,ddp_perz,ddp_fixz,ddp_perp,ddp_fixp,ddp_zam,ddp_fir,vdoch,vdocv,vspnie,vzpnie,vpom,konx,nesp_dni,nesp_hod,nezp_dni,nezp_hod".
" FROM F$kli_vxcf"."_mzdprcvy".$kli_uzid." ".
" WHERE oc >= 0 AND ( dm = 107 OR dm = 302 OR dm = 104 OR dm = 108 ) GROUP BY oc,dm";
$dsql = mysql_query("$dsqlt");
                     }

if( $fir_mzdx02 == 1 ) {
$dsqlt = "INSERT INTO F".$kli_vxcf."_mzdprcvypp".$kli_uzid."  SELECT ".
"cel_dni,cel_hod,cel_hru,cel_nem,cel_zrz,cel_hot,cel_ban,czz_zzp,czz_znp,czz_zsp,czz_zip,czz_zpn,czz_zup,czz_zgf,czz_zrf,".
"dok,dat,ume,oc,dm,dp,dk,sum(dni),sum(hod),sum(mnz),saz,sum(kc),sum(kcsk),str,zak,stj,trncpl,czd_dnp,id,odkial,trx1,dne,hne,prd,prh,ds6,ds2,neod_dni,neod_hod,".
"cddp,ddp_perz,ddp_fixz,ddp_perp,ddp_fixp,ddp_zam,ddp_fir,vdoch,vdocv,vspnie,vzpnie,vpom,konx,nesp_dni,nesp_hod,nezp_dni,nezp_hod".
" FROM F$kli_vxcf"."_mzdprcvy".$kli_uzid." ".
" WHERE oc >= 0 AND ( dm = 104 OR dm = 105 OR dm = 106 OR dm = 107 OR dm = 108 OR dm = 302 ) GROUP BY oc,dm";
$dsql = mysql_query("$dsqlt");
                     }

$trdvm="";
if( $merkfood == 1 OR $emotrans == 1 OR $medo == 1 ) $trdvm="F$kli_vxcf"."_".$mzdkun.".wms,";
if( $fir_mzdx07 == 1 ) { $trdvm="F$kli_vxcf"."_".$mzdkun.".wms,"; }


$neparne=1;
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcsum".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcsum".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcerp".$kli_uzid." ".
" ON F$kli_vxcf"."_mzdprcsum".$kli_uzid.".oc=F$kli_vxcf"."_mzdcerp".$kli_uzid.".oc".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc > 0 ORDER BY $trdvm"."F$kli_vxcf"."_mzdprcsum$kli_uzid.oc".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$hlvpol = mysql_num_rows($sql);
$hlvdo = 1*$hlvpol-1;

//exit;

$hlv=0;

//zaciatok hlavicky
     while ($hlv <= $hlvdo )
     {
       if (@$zaznam=mysql_data_seek($sql,$hlv))
       {
       $hlavicka=mysql_fetch_object($sql);

$dat_sk=SkDatum($hlavicka->dat);

$zostdov=1*$hlavicka->nrk+$hlavicka->nev-$hlavicka->cerp_dni;
$Cislo=$zostdov+"";
$sZostdov=sprintf("%0.2f", $Cislo);

$pdf->SetFont('arial','',10);
$pdf->Cell(80,6,"$kli_vume $fir_fnaz","T",0,"L");
$pdf->Cell(100,5,"OS»: $hlavicka->oc $hlavicka->titl $hlavicka->meno $hlavicka->prie STR: $hlavicka->stz Z¡K: $hlavicka->zkz VM: $hlavicka->wms","T",1,"R");

//$pdf->Cell(20,3,"","0",1,"L");
$pdf->SetFont('arial','',7);

//precitaj cerpane lekar
$lek_cerp=0; $lek_nrk=7;
$sqldok = mysql_query("SELECT SUM(dni) AS cerlek, dm, oc, ume FROM F$kli_vxcf"."_mzdzalvy WHERE dm = 518 AND oc = $hlavicka->oc AND ume <= $kli_vume GROUP BY oc,dm ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $lek_cerp=$lek_cerp+$riaddok->cerlek;
  }
$sqldok = mysql_query("SELECT SUM(dni) AS cerlek, dm, oc, ume FROM F$kli_vxcf"."_mzdprcvy$kli_uzid WHERE dm = 518 AND oc = $hlavicka->oc AND ume <= $kli_vume GROUP BY oc,dm ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  if( $copern != 11 AND $zmzdoveho == 0 ) { $lek_cerp=$lek_cerp+$riaddok->cerlek; }
  }
//precitaj cerpane doprovod
$dop_cerp=0; $dop_nrk=7;
$sqldok = mysql_query("SELECT SUM(dni) AS cerdop, dm, oc, ume FROM F$kli_vxcf"."_mzdzalvy WHERE dm = 519 AND oc = $hlavicka->oc AND ume <= $kli_vume GROUP BY oc,dm ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dop_cerp=$dop_cerp+$riaddok->cerdop;
  }
$sqldok = mysql_query("SELECT SUM(dni) AS cerdop, dm, oc, ume FROM F$kli_vxcf"."_mzdprcvy$kli_uzid WHERE dm = 519 AND oc = $hlavicka->oc AND ume <= $kli_vume GROUP BY oc,dm ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  if( $copern != 11 AND $zmzdoveho == 0 ) { $dop_cerp=$dop_cerp+$riaddok->cerdop; }
  }

$textlekdop="Lek·r dni - n·rok $lek_nrk ËerpanÈ $lek_cerp, Doprovod dni - n·rok $dop_nrk ËerpanÈ $dop_cerp";

$pdf->Cell(80,3," ","0",0,"L");
$pdf->Cell(100,3,"$textlekdop","0",1,"R");

$texthl2x="Prac.pomer: $hlavicka->pom ⁄v‰zok: $hlavicka->suva hod/deÚ PrNah: $hlavicka->znah";
if( $fir_fico == 37986830 ) { $texthl2x="Prac.pomer: $hlavicka->pom ⁄v‰zok: $hlavicka->suva hod/deÚ PrNah: $hlavicka->znah FP: $hlavicka->sz4"; }
if( $kli_nezis != 0 ) { $texthl2x="Prac.pomer: $hlavicka->pom ⁄v‰zok: $hlavicka->suva hod/deÚ PrNah: $hlavicka->znah FP: $hlavicka->sz4"; }

$pdf->SetFont('arial','',8);
$pdf->Cell(80,4,"$texthl2x","0",0,"L");
$pdf->Cell(100,4,"Dovolenka dni - n·rok $hlavicka->nrk prenesenÈ $hlavicka->nev ËerpanÈ $hlavicka->cerp_dni = zostatok $sZostdov","0",1,"R");

$pdf->SetFont('arial','',8);
$pdf->Cell(40,4,"Druh mzdy","BT",0,"L");$pdf->Cell(20,4,"Dni","BT",0,"R");$pdf->Cell(20,4,"Hodiny","BT",0,"R");
$textsk="($mena2)";
if( $fir_mzdx04 == 1 ) { $textsk="";  }
$pdf->Cell(20,4,"$textsk","BT",0,"L");$pdf->Cell(20,4,"$mena1","BT",0,"R");
$textsk="Konverzn˝ kurz ".$kurz12." Sk/Ä";
if( $fir_mzdx04 == 1 ) { $textsk="";  }
$pdf->Cell(60,4,"$textsk","BT",1,"R");

//zaciatok hlavicky


//zaciatok vypisu poloziek

$tovtt = "SELECT kcsk,dni,hod,F$kli_vxcf"."_mzdprcvypp$kli_uzid.oc,F$kli_vxcf"."_mzdprcvypp$kli_uzid.dm,F$kli_vxcf"."_mzdprcvypp$kli_uzid.kc,".
" F$kli_vxcf"."_mzddmn.nzdm,F$kli_vxcf"."_mzdtrn.uceb,F$kli_vxcf"."_mzdtrn.numb,F$kli_vxcf"."_mzdtrn.trx4, ".
" nddp,F$kli_vxcf"."_mzdprcvypp$kli_uzid.cddp,dp,dk,konx,saz,dmh,och,kch,str,zak ". 
" FROM F$kli_vxcf"."_mzdprcvypp".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_mzddmn".
" ON F$kli_vxcf"."_mzdprcvypp".$kli_uzid.".dm=F$kli_vxcf"."_mzddmn.dm".
" LEFT JOIN F$kli_vxcf"."_mzdtrn".
" ON F$kli_vxcf"."_mzdprcvypp".$kli_uzid.".trncpl=F$kli_vxcf"."_mzdtrn.cpl".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcvypp".$kli_uzid.".cddp=F$kli_vxcf"."_mzdcisddp.cddp".
" LEFT JOIN F$kli_vxcf"."_mzdprczaklady".$kli_uzid." ".
" ON F$kli_vxcf"."_mzdprcvypp".$kli_uzid.".oc=F$kli_vxcf"."_mzdprczaklady".$kli_uzid.".och ".
" AND F$kli_vxcf"."_mzdprcvypp".$kli_uzid.".dm=F$kli_vxcf"."_mzdprczaklady".$kli_uzid.".dmh ".
" WHERE F$kli_vxcf"."_mzdprcvypp$kli_uzid.oc = $hlavicka->oc ORDER BY F$kli_vxcf"."_mzdprcvypp$kli_uzid.oc,konx,F$kli_vxcf"."_mzdprcvypp$kli_uzid.dm".
" ";
//echo $tovtt;

$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
if( $tvpol > 0 ) $jetovar=1;

//exit;

//Ak su polozky
if( $jetovar == 1 )
           {
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

//precitaj nazov dss
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddss WHERE cdss=$hlavicka->scdss");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $nzdss=$riaddok->ndss;
  }

//precitaj iban
$ibanoc="";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt=$hlavicka->oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ibanoc=$riaddok->ziban;
  }
$ibanoc=str_replace(" ","",$ibanoc);


$h_hod=$rtov->hod;
if( $rtov->hod == 0 ) $h_hod="";
$h_dni=$rtov->dni;
if( $rtov->dni == 0 ) $h_dni="";
$h_kcsk=$rtov->kcsk;
if( $rtov->kcsk == 0 ) $h_kcsk="";
$h_kc=$rtov->kc;
if( $rtov->kc == 0 ) $h_kc="";

$dp_sk=SkDatum($rtov->dp);
$dk_sk=SkDatum($rtov->dk);

if( $rtov->konx != 9999 AND ( $rtov->dm != 9504 AND $rtov->dm != 9505 ) ) 
     {
$pdf->SetFont('arial','',9);
$pdf->Cell(40,4,"$rtov->dm $rtov->nzdm","0",0,"L");$pdf->Cell(20,4,"$h_dni","0",0,"R");$pdf->Cell(20,4,"$h_hod","0",0,"R");
$pdf->SetFont('arial','',7);

$textsk="$h_kcsk";
if( $fir_mzdx04 == 1 ) { $textsk="";  }

$ajstrzak=0;
$strzak=$rtov->zak;
if( $rtov->str == 0 AND $rtov->zak == 0 ) { $strzak=""; }
if( $ajstrzak == 0 ) { $strzak=""; }

$pdf->Cell(20,4,"$textsk","0",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(20,4,"$h_kc","0",0,"R");
if( $ajstrzak == 1 AND $rtov->dmh > 1 AND $rtov->dmh < 599 ) { $pdf->SetFont('arial','',7); $pdf->Cell(15,4,"zk$strzak","0",0,"L"); $pdf->SetFont('arial','',9); }
if( $rtov->dmh > 0 ) { $pdf->SetFont('arial','',7); $pdf->Cell(10,4,"(Z·klad $rtov->kch)","0",0,"L"); $pdf->SetFont('arial','',9); }
if( $rtov->saz > 0 ) { $pdf->SetFont('arial','',7); $pdf->Cell(10,4,"($rtov->saz)","0",0,"L"); $pdf->SetFont('arial','',9); }
if( $rtov->dp != '0000-00-00' AND $rtov->dk != '0000-00-00' ) $pdf->Cell(60,4,"$dp_sk - $dk_sk","0",0,"L");
if( trim($rtov->trx4) != '' AND trim($rtov->trx4) != '0' AND $rtov->dm != 965 ) { $pdf->SetFont('arial','',6); $pdf->Cell(60,4,"banka $rtov->trx4","0",0,"L"); $pdf->SetFont('arial','',9); }
if( $rtov->cddp > 0 ) $pdf->Cell(60,4,"DDP $rtov->cddp $rtov->nddp ","0",0,"L");
$pdf->Cell(0,4," ","0",1,"L");
     }

if( $rtov->konx != 9999 AND $rtov->dm == 9504 ) 
     {
$dpsk=SkDatum($rtov->dp);
$pdf->SetFont('arial','',9);
$pdf->Cell(40,4,"D·tum v˝stupu $dpsk","0",1,"L");
     }

if( $rtov->konx != 9999 AND $rtov->dm == 9505 ) 
     {
$dksk=SkDatum($rtov->dk);
$pdf->SetFont('arial','',9);
$pdf->Cell(40,4,"D·tum n·stupu $dksk","0",1,"L");
     }

}
$i = $i + 1;
  }

           }
//koniec poloziek mzdy

//ak je dlhsia paska ako 18poloziek
$dlhapaska=0;
if( $neparne > 0 AND $i > 18 ) { $neparne=-1; $dlhapaska=1; }
if( $neparne < 0 AND $i > 18 AND $dlhapaska == 0 ) 
{ 
$neparne=1; $dlhapaska=1; 


$pdf->SetFont('arial','',8);
$pdf->Cell(0,6,"PokraËovanie v˝platnej p·sky na 2.strane ","0",1,"C");

//odstrankuj
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$pdf->SetFont('arial','',8);
$pdf->Cell(0,6,"PokraËovanie v˝platnej p·sky z 1.strany","0",1,"C");
$pdf->SetFont('arial','',10);
$pdf->Cell(80,6,"$kli_vume $fir_fnaz","T",0,"L");
$pdf->Cell(100,6,"OS»: $hlavicka->oc $hlavicka->titl $hlavicka->meno $hlavicka->prie STR: $hlavicka->stz Z¡K: $hlavicka->zkz VM: $hlavicka->wms","T",1,"R");

}

//koniec hlavicky
if( $neparne > 0 ) $patka=105;
if( $neparne < 0 ) $patka=240;
$pdf->SetY($patka);
//$pdf->Line(15, $patka, 195, $patka); 
//$pdf->SetY($patka+1);

$pdf->SetFont('arial','',10);
$pdf->Cell(40,6,"CELKOM","BT",0,"L");$pdf->Cell(20,6,"$hlavicka->sum_dni","BT",0,"R");$pdf->Cell(20,6,"$hlavicka->sum_hod","BT",0,"R");
$pdf->SetFont('arial','',7);

$textsk="($hlavicka->hot_eur)Sk";
if( $fir_mzdx04 == 1 ) { $textsk="";  }
$pdf->Cell(20,6,"$textsk","BT",0,"L");
$pdf->SetFont('arial','',12);
if( $hlavicka->sum_ban == 0 )
{
$pdf->Cell(30,6,"$hlavicka->sum_hot","LBT",0,"R");
$pdf->Cell(60,6,"Ä k v˝plate v hotovosti","BT",1,"L");
}
if( $hlavicka->sum_ban != 0 )
{
$pdf->Cell(50,6,"$hlavicka->sum_ban Ä banka","LBT",0,"R");
$pdf->SetFont('arial','',6);
if( $ibanoc == '' ) { $pdf->Cell(30,6,"$hlavicka->uceb / $hlavicka->numb","BT",1,"L"); }
if( $ibanoc != '' ) { $pdf->Cell(30,6,"$ibanoc","BT",1,"L"); }
}

$pdf->Cell(20,2,"","0",1,"L");

$pdf->SetFont('arial','',8);
if( $wedgb == 1 ) { $pdf->SetFont('arial','B',9); }
$pdf->Cell(55,4,"Hrub· mzda $hlavicka->sum_hru Ä","0",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(55,4,"InÈ.d·vky $hlavicka->sum_nem Ä","0",0,"L");
$pdf->Cell(30,4,"Zr·ûky $hlavicka->sum_zrz Ä","0",0,"L");
if( $hlavicka->scdss != 0 ) { $pdf->SetFont('arial','',6); $pdf->Cell(30,4,"DSS $nzdss $hlavicka->ozam_dss Ä","0",0,"L"); $pdf->SetFont('arial','',8); }
$pdf->Cell(10,4,"","0",1,"L");

$textsk="/$hlavicka->cista_mzdask Sk";
if( $fir_mzdx04 == 1 ) { $textsk="";  }

$pdf->Cell(55,4,"»ist· mzda $hlavicka->cista_mzda Ä$textsk","0",0,"L");
$pdf->Cell(55,4,"OdvodyZamtel $hlavicka->ofir_spolu Ä","0",0,"L");

$textsk="/$hlavicka->sum_cccpsk Sk";
if( $fir_mzdx04 == 1 ) { $textsk="";  }

$pdf->Cell(55,4,"Celkova cena pr·ce $hlavicka->sum_cccp Ä$textsk","0",0,"L");
$pdf->Cell(10,4,"","0",1,"L");

$pdf->Cell(60,1,"","0",1,"R");
$pdf->SetFont('arial','',7);
$pdf->Cell(20,3,"Z·klad odvodov","0",0,"L");
$pdf->Cell(20,3,"ZP $hlavicka->zfir_zp","0",0,"L");
$pdf->Cell(20,3,"NP $hlavicka->zfir_np","0",0,"L");
$pdf->Cell(20,3,"SP $hlavicka->zfir_sp","0",0,"L");
$pdf->Cell(20,3,"IP $hlavicka->zfir_ip","0",0,"L");
$pdf->Cell(20,3,"PvN $hlavicka->zfir_pn","0",0,"L");
$pdf->Cell(20,3,"UP $hlavicka->zfir_up","0",0,"L");
$pdf->Cell(20,3,"GF $hlavicka->zfir_gf","0",0,"L");
$pdf->Cell(20,3,"RF $hlavicka->zfir_rf","0",1,"L");
$pdf->Cell(20,3,"Odvod Znec/Ztel","0",0,"L");
$pdf->Cell(20,3,"$hlavicka->ozam_zp/$hlavicka->ofir_zp","0",0,"L");
$pdf->Cell(20,3,"$hlavicka->ozam_np/$hlavicka->ofir_np","0",0,"L");
$pdf->Cell(20,3,"$hlavicka->ozam_sp/$hlavicka->ofir_sp","0",0,"L");
$pdf->Cell(20,3,"$hlavicka->ozam_ip/$hlavicka->ofir_ip","0",0,"L");
$pdf->Cell(20,3,"$hlavicka->ozam_pn/$hlavicka->ofir_pn","0",0,"L");
$pdf->Cell(20,3,"$hlavicka->ozam_up/$hlavicka->ofir_up","0",0,"L");
$pdf->Cell(20,3,"$hlavicka->ozam_gf/$hlavicka->ofir_gf","0",0,"L");
$pdf->Cell(20,3,"$hlavicka->ozam_rf/$hlavicka->ofir_rf","0",1,"L");

$pdf->Cell(20,2,"","0",1,"L");

$pdf->Cell(20,3,"DaÚ z prÌjmu","0",0,"L");
$pdf->Cell(20,3,"⁄h.prÌj $hlavicka->zdan_dnp","0",0,"L");
$pdf->Cell(20,3,"PoistnÈ $hlavicka->pdan_fnd","0",0,"L");
$pdf->Cell(20,3,"Nzd.dÚv $hlavicka->pdan_dnv","0",0,"L");
$pdf->Cell(20,3,"Zpl.DDP $hlavicka->pdan_zn1","0",0,"L");

$pdf->Cell(22,3,"Zd.mzda $hlavicka->zakl_dan","0",0,"L");
$pdf->Cell(20,3,"DaÚ $hlavicka->odan_dnp","0",0,"L");
$pdf->Cell(20,3,"Zr.daÚ $hlavicka->odan_zrz","0",1,"L");

//konto prac.casu
$kprc=0; $kprh=0; $kpre=0;
$sqldokkp = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt=$hlavicka->oc ");
  if (@$zaznam=mysql_data_seek($sqldokkp,0))
  {
  $riaddokkp=mysql_fetch_object($sqldokkp);
  $kprc=1*$riaddokkp->kprc;
  $kprh=1*$riaddokkp->kprh;
  $kpre=1*$riaddokkp->kpre;
  $dmp=1*$riaddokkp->dmp;
  $dmm=1*$riaddokkp->dmm;
  $pcen=1*$riaddokkp->pcen;
  }
if( $kprc == 1 ) { 



$preh=0; $pree=0; $kc=0; $hod=0;
$sqldoktt = "SELECT SUM(kc) AS kc, SUM(hod) AS hod FROM F$kli_vxcf"."_mzdzalvy WHERE ( dm = $dmp OR dm = $dmm ) AND oc=$hlavicka->oc AND ume < $kli_vume GROUP BY oc";
$sqldokkp = mysql_query("$sqldoktt ");
  if (@$zaznam=mysql_data_seek($sqldokkp,0))
  {
  $riaddokkp=mysql_fetch_object($sqldokkp);
  $kc=1*$riaddokkp->kc;
  $hod=1*$riaddokkp->hod; 
  }

$preh=$hod+$kprh;
$pree=$kc+$kpre;

$tabulkavy="_mzdzalvy";
if( $ostre == 1 ) { $tabulkavy="_mzdprcvy".$kli_uzid; }
if( $copern == 1 ) { $tabulkavy="_mzdprcvy".$kli_uzid; }

$pluh=0; $plue=0; $kc=0; $hod=0;
$sqldoktt = "SELECT SUM(kc) AS kc, SUM(hod) AS hod FROM F$kli_vxcf"."$tabulkavy WHERE dm = $dmp AND oc=$hlavicka->oc AND ume = $kli_vume GROUP BY oc";
$sqldokkp = mysql_query("$sqldoktt ");
  if (@$zaznam=mysql_data_seek($sqldokkp,0))
  {
  //echo $sqldoktt;
  //exit;
  $riaddokkp=mysql_fetch_object($sqldokkp);
  $kc=1*$riaddokkp->kc;
  $hod=1*$riaddokkp->hod;
$pluh=$hod;
$plue=$kc; 
  }

$minh=0; $mine=0; $kc=0; $hod=0;
$sqldoktt = "SELECT SUM(kc) AS kc, SUM(hod) AS hod FROM F$kli_vxcf"."$tabulkavy WHERE dm = $dmm AND oc=$hlavicka->oc AND ume = $kli_vume GROUP BY oc";
$sqldokkp = mysql_query("$sqldoktt ");
  if (@$zaznam=mysql_data_seek($sqldokkp,0))
  {
  $riaddokkp=mysql_fetch_object($sqldokkp);
  $kc=-1*$riaddokkp->kc;
  $hod=-1*$riaddokkp->hod;
$minh=$hod;
$mine=$kc; 
  }

$zosh=$preh+$pluh-$minh;  
if( $zosh != 0 AND $zose == 0 ) { $zose=$zosh*$pcen; } 
if( $pluh != 0 AND $plue == 0 ) { $plue=$pluh*$pcen; }  
if( $minh != 0 AND $mine == 0 ) { $mine=$minh*$pcen; }  
if( $preh != 0 AND $pree == 0 ) { $pree=$preh*$pcen; }
$zose=$pree+$plue-$mine;

$pdf->SetFont('arial','',5); 
$pdf->Cell(25,1," ","0",1,"L");
$pdf->Cell(70,3,"Konto pracovnÈho Ëasu ß87a Z·k.311/2001 a nasl. Z.z. - Z·konnÌk pr·ce ","0",0,"L"); 
$pdf->Cell(29,3,"Prenos: $preh h/$pree e ","0",0,"L"); 
$pdf->Cell(29,3,"$kli_vume(+): $pluh h/$plue e ","0",0,"L");
$pdf->Cell(29,3,"$kli_vume(-): $minh h/$mine e ","0",0,"L");
$pdf->Cell(29,3,"Zostatok: $zosh h/$zose e ","0",1,"L");
                 }


       }
//koniec paty

if( $rtov->konx == 9999 AND $all_oc == 1 ) 
     {

if( $neparne < 0 AND $hlv < $hlvdo ) 
   {
//odstrankuj
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 
   }

if( $neparne > 0 ) 
   {
//posun
$stred=145;
$pdf->SetY($stred);
$pdf->Cell(10,1,"----------------","0",0,"L");$pdf->Cell(10,1,"   ","0",0,"L");$pdf->Cell(10,1,"----------------","0",0,"L");$pdf->Cell(10,1,"   ","0",0,"L");
$pdf->Cell(10,1,"----------------","0",0,"L");$pdf->Cell(10,1,"   ","0",0,"L");$pdf->Cell(10,1,"----------------","0",0,"L");$pdf->Cell(10,1,"   ","0",0,"L");
$pdf->Cell(10,1,"----------------","0",0,"L");$pdf->Cell(10,1,"   ","0",0,"L");$pdf->Cell(10,1,"----------------","0",0,"L");$pdf->Cell(10,1,"   ","0",0,"L");
$pdf->Cell(10,1,"----------------","0",0,"L");$pdf->Cell(10,1,"   ","0",0,"L");$pdf->Cell(10,1,"----------------","0",0,"L");$pdf->Cell(10,1,"   ","0",0,"L");
$pdf->Cell(10,1,"----------------","0",0,"L");$pdf->Cell(10,1," ","0",1,"L");
$pdf->Cell(180,10," ","0",1,"L");
   }
$neparne=-1*$neparne;
     }

$hlv=$hlv+1;
     }
//koniec hlavicky


$sql = "DROP TABLE F".$kli_vxcf."_mzdprcvypp".$kli_uzid." ";
$vysledek = mysql_query("$sql");

//zalohovanie databaz pri ostrom
if( $ostre == 1 )
     {
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdzalkun"." SELECT ".
"'$kli_vume',".
"oc,meno,prie,rodn,prbd,titl,akt,rdc,rdk,dar,mnr,cop,zmes,zpsc,zcdm,zuli,zema,ztel,pom,kat,wms,stz,zkz,uva,uvazn,dan,dav,".
"nev,nrk,crp,znah,znem,doch,docv,dad,dvy,cdss,roh,spno,dsp,spnie,deti_sp,zrz_dn,ziv_dn,deti_dn,zpno,zpnie,dvp,zdrv,trd,sz0,sz1,sz2,sz3,sz4,sz5,".
"vban,uceb,numb,vsy,ksy,ssy,datm".
" FROM F$kli_vxcf"."_mzdkun".
" WHERE oc >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdzaltrn"." SELECT ".
"'$kli_vume',".
"0,oc,dm,kc,mn,trx1,trx2,trx3,trx4,uceb,numb,vsy,ksy,ssy,datm".
" FROM F$kli_vxcf"."_mzdtrn".
" WHERE oc >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdzalmes"." SELECT ".
"0,dok,dat,ume,oc,dm,dp,dk,dni,hod,mnz,saz,kc,str,zak,stj,msx1,msx2,msx3,msx4,pop,id,datm".
" FROM F$kli_vxcf"."_mzdmes".
" WHERE oc >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdzalddp"." SELECT ".
"'$kli_vume',".
"0,oc,perz_dd,fixz_dd,perp_dd,fixp_dd,cddp,czm,dtd,pd1,pd2,pd3,pd4,datm".
" FROM F$kli_vxcf"."_mzdddp".
" WHERE oc >= 0";
$dsql = mysql_query("$dsqlt");


$sql = "SELECT zuco FROM F$kli_vxcf"."_mzdprm";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD ssyo VARCHAR(10) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD ksyo VARCHAR(4) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD vsyo DECIMAL(10,0) DEFAULT 0 AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD numo VARCHAR(4) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD uceo VARCHAR(30) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD zuco INT(2) DEFAULT 0 AFTER dan_perc";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT zuco FROM F$kli_vxcf"."_mzdzalprm";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalprm ADD ssyo VARCHAR(10) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalprm ADD ksyo VARCHAR(4) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalprm ADD vsyo DECIMAL(10,0) DEFAULT 0 AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalprm ADD numo VARCHAR(4) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalprm ADD uceo VARCHAR(30) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalprm ADD zuco INT(2) DEFAULT 0 AFTER dan_perc";
$vysledek = mysql_query("$sql");
}

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdzalprm"." SELECT ".
"'$kli_vume',".
"datum,max_zp,max_np,max_sp,max_ip,max_pn,max_up,max_gf,max_rf,min_zp,min_np,min_sp,min_ip,min_pn,min_up,min_gf,min_rf,".
"zam_zp,zam_zpn,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,fir_zp,fir_zpn,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf,".
"dan_bonus,dan_danov,soc_perc,uva_hod,min_mzda,dan_perc,zuco,uceo,numo,vsyo,ksyo,ssyo,".
"ucedz,numdz,vsydz,ksydz,ssydz,zucdz,cicz,zucd,zucs,zucz,uced,numd,vsyd,ksyd,ssyd,".
"uces,nums,vsys,ksys,ssys".
" FROM F$kli_vxcf"."_mzdprm";
$dsql = mysql_query("$dsqlt");

$sql = "SELECT umx FROM F$kli_vxcf"."_mzdzalvy ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalvy ".
"SELECT * FROM F".$kli_vxcf."_mzdprcvy".$kli_uzid." WHERE oc=0";
$vysledek = mysql_query("$sql");
}
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdzalvy"." SELECT ".
"cel_dni,cel_hod,cel_hru,cel_nem,cel_zrz,cel_hot,cel_ban,czz_zzp,czz_znp,czz_zsp,czz_zip,czz_zpn,czz_zup,czz_zgf,czz_zrf,".
"dok,dat,ume,oc,dm,dp,dk,dni,hod,mnz,saz,kc,kcsk,str,zak,stj,trncpl,czd_dnp,id,odkial,trx1,dne,hne,prd,prh,ds6,ds2,neod_dni,neod_hod,".
"cddp,ddp_perz,ddp_fixz,ddp_perp,ddp_fixp,ddp_zam,ddp_fir,vdoch,vdocv,vspnie,vzpnie,vpom,konx,nesp_dni,nesp_hod,nezp_dni,nezp_hod".
" FROM F$kli_vxcf"."_mzdprcvy".$kli_uzid." ".
" WHERE oc >= 0";
$dsql = mysql_query("$dsqlt");

$sql = "SELECT umx FROM F$kli_vxcf"."_mzdzalsum ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalsum ".
"SELECT * FROM F".$kli_vxcf."_mzdprcsum".$kli_uzid." WHERE oc=0";
$vysledek = mysql_query("$sql");
}
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdzalsum"." SELECT ".
"sum_dni,sum_hod,sum_hru,sum_nem,sum_zrz,sum_hot,sum_ban,zzam_zp,zzam_np,zzam_sp,zzam_ip,zzam_pn,zzam_up,zzam_gf,zzam_rf,".
"zfir_zp,zfir_np,zfir_sp,zfir_ip,zfir_pn,zfir_up,zfir_gf,zfir_rf,ozam_zp,ozam_np,ozam_sp,ozam_ip,ozam_pn,ozam_up,ozam_gf,ozam_rf,".
"ofir_zp,ofir_np,ofir_sp,ofir_ip,ofir_pn,ofir_up,ofir_gf,ofir_rf,ozam_spolu,ofir_spolu,des1,des2,des3,des6,ume,oc,".
"zdan_dnp,odan_dnp,pdan_dnv,pdan_fnd,pdan_zn1,pdan_zn2,odan_zrz,zakl_dan,bonus_dan,id,hot_eur,ban_eur,ddp_zam,ddp_fir,sum_cccp,sum_cccpsk,".
"cista_mzda,cista_mzdask,sdoch,sdocv,sspnie,szpnie,spom,svban,snumb,scdss,ozam_dss,suva,ksum1,zmax_zp,zmax_np,zmax_sp,zmax_ip,zmax_pn,".
"zmax_up,zmax_gf,zmax_rf,zmin_zp,zmin_np,zmin_sp,zmin_ip,zmin_pn,zmin_up,zmin_gf,zmin_rf,ksum2".
" FROM F$kli_vxcf"."_mzdprcsum".$kli_uzid." ".
" WHERE oc >= 0";
$dsql = mysql_query("$dsqlt");

//vynuluj mesacnu davku pri ostrom
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_mzdmes';
$vysledok = mysql_query("$sqlt");

//odvody ddp
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcddp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//zmaz nemoc.zaklady bezny rok pri ostrom
$sqlt = "DROP TABLE F".$kli_vxcf."_mzdnemzakb ";
$vysledok = mysql_query("$sqlt");

//zmaz mesacny prehlad pri ostrom
$sqlt = 'DELETE FROM F'.$kli_vxcf.'_mzdmesacnyprehladdane WHERE umex = '.$kli_vume.' ';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DELETE FROM F'.$kli_vxcf.'_mzdmesacnyprehladdaneoc WHERE umex = '.$kli_vume.' ';
$vysledok = mysql_query("$sqlt");
//echo $sqlt; 
//exit;

//uloz log ostre spracovanie
$sql = "SELECT osneos FROM F".$kli_vxcf."_mzdsprclog ";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sql = "DROP TABLE F".$kli_vxcf."_mzdsprclog ";
$vysledok = mysql_query($sql);

$sqlt = <<<uctcrv
(
   kliuzid          DECIMAL(10,0) DEFAULT 0,
   ume              DECIMAL(7,4) DEFAULT 0,
   osneos           DECIMAL(10,0) DEFAULT 0,
   datm             TIMESTAMP(14)
);
uctcrv;

$vsql = "CREATE TABLE F".$kli_vxcf."_mzdsprclog ".$sqlt;
$vytvor = mysql_query("$vsql");
}
$vsql = "INSERT INTO F".$kli_vxcf."_mzdsprclog ( kliuzid, ume, osneos ) VALUES ( '$kli_uzid', '$kli_vume', '1' )";
$vytvor = mysql_query("$vsql");


     }
//koniec zalohovania databaz pri ostrom


$pdf->Output("$outfilex");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcsum'.$kli_uzid;
if( $ostre == 1 ){ $vysledok = mysql_query("$sqlt"); }
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcneod'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcneodx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcneody'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdcerp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

if( $data_zal != 0 )
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalmesx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzaltrnx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalkunx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
}

$odmailuj = 1*$_REQUEST['odmailuj'];
if( $odmailuj == 1 )
                {
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/mail_paska.php?&copern=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>&posem=1&outfilex=<?php echo $outfilex; ?>","_self");
</script>
<?php
                }

?> 

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
