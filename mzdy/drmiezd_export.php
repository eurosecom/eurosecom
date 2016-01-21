<HTML>
<?php
$sys = 'ALL';
$urov = 25000;
$dopln = 1*$_REQUEST['dopln'];
if( $dopln == 1 ) { $urov = 3000; }
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

// cislo operacie
$copern = 1*$_REQUEST['copern'];

$dopln = 1*$_REQUEST['dopln'];
//1519 nacitat drmiezd
if( $copern == 1519 )
{
$textx="Naèíta štandartnı";
$subx="";
if( $dopln == 1 ) { $textx="Doplni"; $subx="dopln"; }
?>
<script type="text/javascript">
if( !confirm ("Chcete <?php echo $textx; ?> èíselník mzdovıch zloiek z ../import/dmn<?php echo $kli_vrok; ?><?php echo $subx; ?>.csv ?") )
         {   }
else
  var okno = window.open("drmiezd_export.php?copern=151999&page=1&dopln=<?php echo $dopln; ?>","_self");
</script>
<?php
$copern=1;
}
if( $copern == 151999 )
{
$nazov="../import/dmn".$kli_vrok.".csv";
if( $dopln == 1 ) 
{ 
$nazov="../import/dmn".$kli_vrok."dopln.csv"; 

$sqult = "DELETE FROM F$kli_vxcf"."_mzddmn WHERE dm = 592 ";
$uloz = mysql_query("$sqult");
$sqult = "DELETE FROM F$kli_vxcf"."_mzddmn WHERE dm = 952 ";
$uloz = mysql_query("$sqult");
$sqult = "DELETE FROM F$kli_vxcf"."_mzddmn WHERE dm = 953 ";
$uloz = mysql_query("$sqult");
$sqult = "DELETE FROM F$kli_vxcf"."_mzddmn WHERE dm = 954 ";
$uloz = mysql_query("$sqult");
$sqult = "DELETE FROM F$kli_vxcf"."_mzddmn WHERE dm = 955 ";
$uloz = mysql_query("$sqult");
$sqult = "DELETE FROM F$kli_vxcf"."_mzddmn WHERE dm = 968 ";
$uloz = mysql_query("$sqult");
}

if( $kli_vrok == 2014 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014c";
$vysledek = mysql_query("$sql");
}
if( $kli_vrok == 2015 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015c";
$vysledek = mysql_query("$sql");
}
if( $kli_vrok == 2016 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016c";
$vysledek = mysql_query("$sql");
}
$subor = fopen("$nazov", "r");
while (! feof($subor))
{

  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_data = $pole[0];

  if( $x_data == 314 ) { $akysubor=314; }

  //echo $akysubor;

//subor 314
if( $akysubor == 314 AND $x_data == 1 )
  {
  $x_dm = $pole[1];
  $x_nzdm = $pole[2];
  $x_ndndm = $pole[3];
  $x_td = $pole[4];
  $x_nap_zp = $pole[5];
  $x_nap_np = $pole[6];
  $x_nap_sp = $pole[7];
  $x_nap_ip = $pole[8];
  $x_nap_pn = $pole[9];
  $x_nap_up = $pole[10];
  $x_nap_gf = $pole[11];

  $x_nap_rf = $pole[12];
  $x_br = $pole[13];
  $x_rh = $pole[14];
  $x_do = $pole[15];
  $x_ne = $pole[16];
  $x_ho = $pole[17];
  $x_np = $pole[18];
  $x_prn = $pole[19];
  $x_prm = $pole[20];
  $x_prv = $pole[21];
  $x_prs = $pole[22];
  $x_sa = $pole[23];
  $x_ko = $pole[24];
  $x_sax = $pole[25];
  $x_su = $pole[26];
  $x_au = $pole[27];
  $x_suc = $pole[28];
  $x_auc = $pole[29];
  $x_dm1 = $pole[30];
  $x_dm2 = $pole[31];
  $x_dm3 = $pole[32];
  $x_dm4 = $pole[33];

$cdm=1*$x_dm;

//0;dm;nzdm;dndm;td;nap_zp;nap_np;nap_sp;nap_ip;nap_pn;nap_up;nap_gf;nap_rf;br;rh;do;ne;ho;np;prn;prm;prv;prs;sa;ko;sax;su;au;suc;auc;dm1;dm2;dm3;dm4;datm
 
$sqult = "INSERT INTO F$kli_vxcf"."_mzddmn ( dm, nzdm, dndm, td, nap_zp, nap_np, nap_sp, nap_ip, nap_pn, nap_up, nap_gf, ".
" nap_rf, br, rh, do, ne, ho, np, prn, prm, prv, prs, sa, ko, sax, su, au, suc, auc, dm1, dm2, dm3, dm4, datm ) ".
" VALUES ( '$x_dm','$x_nzdm', '$x_dndm', '$x_td', '$x_nap_zp', '$x_nap_np', '$x_nap_sp', '$x_nap_ip', '$x_nap_pn', '$x_nap_up', '$x_nap_gf', ".
" '$x_nap_rf', '$x_br', '$x_rh', '$x_do', '$x_ne', '$x_ho', '$x_np', '$x_prn', '$x_prm', '$x_prv', '$x_prs', '$x_sa', '$x_ko', '$x_sax', '$x_su', '$x_au', '$x_suc', ".
" '$x_auc', '$x_dm1', '$x_dm2', '$x_dm3', '$x_dm4', now() ) ";

if( $cdm > 0 ) { $uloz = mysql_query("$sqult"); }
//echo $sqult;
  }
//koniec subor 314


//koniec while
}
fclose ($subor);

//exit;

?>
<script type="text/javascript">
window.open('../mzdy/drmiezd.php?copern=1&drupoh=1&page=1', '_self' );
</script>
<?php
exit;
}
//koniec 1519 nacitat drmiezd

//1819 vymazat drmiezd
if( $copern == 1819 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete Vymaza èíselník mzdovıch zloiek ?") )
         {   }
else
  var okno = window.open("drmiezd_export.php?copern=181999&page=1","_self");
</script>
<?php
$copern=1;
}
if( $copern == 181999 )
{

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzddmn WHERE dm >= 0 ";
$dsql = mysql_query("$dsqlt");

?>
<script type="text/javascript">
window.open('../mzdy/drmiezd.php?copern=1&drupoh=1&page=1', '_self' );
</script>
<?php
exit;
}
//koniec 1819 vymazat drmiezd

//1816 vymazat drdph
if( $copern == 1816 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete Vymaza èíselník druhov DPH ?") )
         {   }
else
  var okno = window.open("../mzdy/drmiezd_export.php?copern=181699&page=1","_self");
</script>
<?php
$copern=1;
}
if( $copern == 181699 )
{

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctdrdp WHERE rdp >= 0 ";
$dsql = mysql_query("$dsqlt");

?>
<script type="text/javascript">
window.open('../ucto/drudan.php?copern=1&drupoh=1&page=1', '_self' );
</script>
<?php
exit;
}
//koniec 1816 vymazat drdph

//1815 vymazat uct pohyby asistenta
if( $copern == 1815 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete Vymaza èíselník automatickıch úètovnıch pohybov ?") )
         {   }
else
  var okno = window.open("../mzdy/drmiezd_export.php?copern=181599&page=1","_self");
</script>
<?php
$copern=1;
}
if( $copern == 181599 )
{

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctpohyby WHERE cpoh >= 0 ";
$dsql = mysql_query("$dsqlt");

?>
<script type="text/javascript">
window.open('../ucto/uctpoh.php?copern=1&drupoh=1&page=1', '_self' );
</script>
<?php
exit;
}
//koniec 1815 vymazat uct pohyby asistenta

//1818 vymazat pomer
if( $copern == 1818 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete Vymaza èíselník pomerov ?") )
         {   }
else
  var okno = window.open("drmiezd_export.php?copern=181899&page=1","_self");
</script>
<?php
$copern=1;
}
if( $copern == 181899 )
{

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdpomer WHERE pm >= 0 ";
$dsql = mysql_query("$dsqlt");

?>
<script type="text/javascript">
window.open('../mzdy/pomery.php?copern=1&drupoh=1&page=1', '_self' );
</script>
<?php
exit;
}
//koniec 1818 vymazat pomery

//1818 vymazat zp
if( $copern == 1817 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete Vymaza èíselník ZP ?") )
         {   }
else
  var okno = window.open("drmiezd_export.php?copern=181799&page=1","_self");
</script>
<?php
$copern=1;
}
if( $copern == 181799 )
{

$dsqlt = "DELETE FROM F$kli_vxcf"."_zdravpois WHERE zdrv >= 0 ";
$dsql = mysql_query("$dsqlt");

?>
<script type="text/javascript">
window.open('../mzdy/zdravpois.php?copern=1&drupoh=1&page=1', '_self' );
</script>
<?php
exit;
}
//koniec 1818 vymazat zp


//1814 vymazat cash
if( $copern == 1814 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete Vymaza èíselník generovania CASHFLOW ?") )
         {   }
else
  var okno = window.open("drmiezd_export.php?copern=181499&page=1","_self");
</script>
<?php
$copern=1;
}
if( $copern == 181499 )
{

$dsqlt = "DELETE FROM F$kli_vxcf"."_crcash_flow2011 ";
$dsql = mysql_query("$dsqlt");

?>
<script type="text/javascript">
window.open('../ucto/oprcis.php?copern=308&drupoh=95&page=1&sysx=UCT', '_self' );
</script>
<?php
exit;
}
//koniec 1814 vymazat cash

$dopln = 1*$_REQUEST['dopln'];
//1518 nacitat pomerov
if( $copern == 1518 )
{
$textx="Naèíta štandartnı";
$subx="";
if( $dopln == 1 ) { $textx="Doplni"; $subx="dopln"; }
?>
<script type="text/javascript">
if( !confirm ("Chcete <?php echo $textx; ?> èíselník pomerov z ../import/pomer<?php echo $kli_vrok; ?><?php echo $subx; ?>.csv ?") )
         {   }
else
  var okno = window.open("drmiezd_export.php?copern=151899&page=1&dopln=<?php echo $dopln; ?>","_self");
</script>
<?php
$copern=1;
}
if( $copern == 151899 )
{
$nazov="../import/pomer".$kli_vrok.".csv";
if( $dopln == 1 ) 
{ 
$nazov="../import/pomer".$kli_vrok."dopln.csv"; 

if( $kli_vrok == 2013 )
  {
$sqult = "DELETE FROM F$kli_vxcf"."_mzdpomer WHERE pm = 14 ";
$uloz = mysql_query("$sqult");
$sqult = "DELETE FROM F$kli_vxcf"."_mzdpomer WHERE pm = 61 ";
$uloz = mysql_query("$sqult");
$sqult = "DELETE FROM F$kli_vxcf"."_mzdpomer WHERE pm = 55 ";
$uloz = mysql_query("$sqult");
$sqult = "DELETE FROM F$kli_vxcf"."_mzdpomer WHERE pm = 56 ";
$uloz = mysql_query("$sqult");
  }
if( $kli_vrok == 2014 )
  {
$sqult = "DELETE FROM F$kli_vxcf"."_mzdpomer WHERE pm = 3 ";
$uloz = mysql_query("$sqult");
  }
if( $kli_vrok == 2015 )
  {
$sqult = "DELETE FROM F$kli_vxcf"."_mzdpomer WHERE pm = 3 ";
$uloz = mysql_query("$sqult");
  }
if( $kli_vrok == 2016 )
  {
$sqult = "DELETE FROM F$kli_vxcf"."_mzdpomer WHERE pm = 3 ";
$uloz = mysql_query("$sqult");
  }
}

if( $kli_vrok == 2014 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014c";
$vysledek = mysql_query("$sql");
}
if( $kli_vrok == 2015 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015c";
$vysledek = mysql_query("$sql");
}
if( $kli_vrok == 2016 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016c";
$vysledek = mysql_query("$sql");
}

$subor = fopen("$nazov", "r");
while (! feof($subor))
{

  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_data = $pole[0];

  if( $x_data == 315 ) { $akysubor=315; }

  //echo $akysubor;

//subor 315
if( $akysubor == 315 AND $x_data == 1 )
  {
  $x_pm = $pole[1];
  $x_nzpm = $pole[2];
  $x_prpm = $pole[3];
  $x_zam_zp = $pole[4];
  $x_zam_np = $pole[5];
  $x_zam_sp = $pole[6];
  $x_zam_ip = $pole[7];
  $x_zam_pn = $pole[8];
  $x_zam_up = $pole[9];
  $x_zam_gf = $pole[10];
  $x_zam_rf = $pole[11];

  $x_fir_zp = $pole[12];
  $x_fir_np = $pole[13];
  $x_fir_sp = $pole[14];
  $x_fir_ip = $pole[15];
  $x_fir_pn = $pole[16];
  $x_fir_up = $pole[17];
  $x_fir_gf = $pole[18];
  $x_fir_rf = $pole[19];

  $x_zam_zm = $pole[20];
  $x_pm_doh = $pole[21];
  $x_pm_maj = $pole[22];
  $x_np_soc = $pole[23];
  $x_pm1 = $pole[24];
  $x_pm2 = $pole[25];
  $x_pm3 = $pole[26];
  $x_pm4 = $pole[27];

$cpm=1*$x_pm;

//0;pm;nzpm;prpm;zam_zp;zam_np;zam_sp;zam_ip;zam_pn;zam_up;zam_gf;zam_rf;
//fir_zp;fir_np;fir_sp;fir_ip;fir_pn;fir_up;fir_gf;fir_rf;
//zam_zm;pm_doh;pm_maj;np_soc;pm1;pm2;pm3;pm4;datm

$sqult = "INSERT INTO F$kli_vxcf"."_mzdpomer ( pm, nzpm, prpm, zam_zp, zam_np, zam_sp, zam_ip, zam_pn, zam_up, zam_gf, zam_rf, ".
" fir_zp, fir_np, fir_sp, fir_ip, fir_pn, fir_up, fir_gf, fir_rf, ".
" zam_zm, pm_doh, pm_maj, np_soc, pm1, pm2, pm3, pm4, datm ) ".
" VALUES ( '$x_pm', '$x_nzpm', '$x_prpm', '$x_zam_zp', '$x_zam_np', '$x_zam_sp', '$x_zam_ip', '$x_zam_pn', '$x_zam_up', '$x_zam_gf', '$x_zam_rf', ".
" '$x_fir_zp', '$x_fir_np', '$x_fir_sp', '$x_fir_ip', '$x_fir_pn', '$x_fir_up', '$x_fir_gf', '$x_fir_rf',  ".
" '$x_zam_zm', '$x_pm_doh', '$x_pm_maj', '$x_np_soc', '$x_pm1', '$x_pm2', '$x_pm3', '$x_pm4', now() ) ";

if( $cpm >= 0 ) { $uloz = mysql_query("$sqult"); }
//echo $sqult;
  }
//koniec subor 315


//koniec while
}
fclose ($subor);

//exit;

?>
<script type="text/javascript">
window.open('../mzdy/pomery.php?copern=1&drupoh=1&page=1', '_self' );
</script>
<?php
exit;
}
//koniec 1518 nacitat pomerov

//1517 nacitat zp
if( $copern == 1517 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete Naèíta štandartnı èíselník ZP z ../import/zp<?php echo $kli_vrok; ?>.csv ?") )
         {   }
else
  var okno = window.open("drmiezd_export.php?copern=151799&page=1","_self");
</script>
<?php
$copern=1;
}
if( $copern == 151799 )
{
$nazov="../import/zp".$kli_vrok.".csv";

$subor = fopen("$nazov", "r");
while (! feof($subor))
{

  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_data = $pole[0];

  if( $x_data == 318 ) { $akysubor=318; }

  //echo $akysubor;

//subor 318
if( $akysubor == 318 AND $x_data == 1 )
  {
  $x_zdrv = $pole[1];
  $x_nzdr = $pole[2];
  $x_uceb = $pole[3];
  $x_numb = $pole[4];
  $x_iban = $pole[5];
  $x_vsy = $pole[6];
  $x_ksy = $pole[7];
  $x_ssy = $pole[8];
  $x_anl = $pole[9];

  $x_pz1 = $pole[10];
  $x_pz2 = $pole[11];
  $x_pz3 = $pole[12];
  $x_pz4 = $pole[13];
  $x_pz5 = $pole[14];
  $x_pt1 = $pole[15];
  $x_pt2 = $pole[16];
  $x_pt3 = $pole[17];


$czdrv=1*$x_zdrv;

//0;zdrv;nzdr;uceb;numb;iban;vsy;ksy;ssy;anl;
//pz1;pz2;pz3;pz4;pz5;pt1;pt2;pt3;

$sqult = "INSERT INTO F$kli_vxcf"."_zdravpois ( zdrv, nzdr, uceb, numb, iban, vsy, ksy, ssy, anl,  ".
" pz1, pz2, pz3, pz4, pz5, pt1, pt2, pt3, datm ) ".
" VALUES ( '$x_zdrv', '$x_nzdr', '$x_uceb', '$x_numb', '$x_iban', '$x_vsy', '$x_ksy', '$x_ssy', '$x_anl', ".
" '$x_pz1', '$x_pz2', '$x_pz3', '$x_pz4', '$x_pz5', '$x_pt1', '$x_pt2', '$x_pt3', now() ) ";

if( $czdrv >= 0 ) { $uloz = mysql_query("$sqult"); }
//echo $sqult;
  }
//koniec subor 318


//koniec while
}
fclose ($subor);

//exit;

?>
<script type="text/javascript">
window.open('../mzdy/zdravpois.php?copern=1&drupoh=1&page=1', '_self' );
</script>
<?php
exit;
}
//koniec 1517 nacitat zp

//1516 nacitat druh dph
$dopln = 1*$_REQUEST['dopln'];
if( $copern == 1516 )
{
$textx="Naèíta štandartnı";
$subx="";
if( $dopln ==  1 ) { $textx="Doplni"; $subx="dopln"; }
if( $dopln == 27 ) { $textx="Doplni"; $subx="dopln27"; }
?>
<script type="text/javascript">
if( !confirm ("Chcete <?php echo $textx; ?> štandartnı èíselník druhov DPH z ../import/druhdph<?php echo $kli_vrok; ?><?php echo $subx; ?>.csv ?") )
         {   }
else
  var okno = window.open("../mzdy/drmiezd_export.php?copern=151699&page=1&dopln=<?php echo $dopln; ?>","_self");
</script>
<?php
$copern=1;
}
if( $copern == 151699 )
{
$nazov="../import/druhdph".$kli_vrok.".csv";
if( $dopln == 1 ) 
{ 
$nazov="../import/druhdph".$kli_vrok."dopln.csv"; 

$sqult = "DELETE FROM F$kli_vxcf"."_uctdrdp WHERE rdp > 100 OR rdp = 27 OR rdp = 32 OR rdp = 82 ";
$uloz = mysql_query("$sqult");

}
if( $dopln == 27 ) 
{ 
$nazov="../import/druhdph".$kli_vrok."dopln27.csv"; 

$sqult = "DELETE FROM F$kli_vxcf"."_uctdrdp WHERE rdp = 27 OR rdp = 32 OR rdp = 82 ";
$uloz = mysql_query("$sqult");

}
if( $kli_vrok >= 2014 )
  {
$sql = "ALTER TABLE F$kli_vxcf"."_uctdrdp MODIFY crd3 VARCHAR(10) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctdrdp MODIFY nrd VARCHAR(70) NOT NULL ";
$vysledek = mysql_query("$sql");
  }

$subor = fopen("$nazov", "r");
while (! feof($subor))
{

  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_data = $pole[0];

  if( $x_data == 215 ) { $akysubor=215; }

  //echo $akysubor;

//subor 215
if( $akysubor == 215 AND $x_data == 1 )
  {
  $x_rdp = $pole[1];
  $x_nrd = $pole[2];
  $x_szd = $pole[3];
  $x_crz = $pole[4];
  $x_crd = $pole[5];
  $x_crz1 = $pole[6];
  $x_crd1 = $pole[7];
  $x_crz2 = $pole[8];
  $x_crd2 = $pole[9];
  $x_crz3 = $pole[10];
  $x_crd3 = $pole[11];
  $x_crd3=substr($x_crd3,0,2);


$crdp=1*$x_rdp;

//0;rdp;nrd;szd;crz;crd;crz1;crd1;crz2;crd2;crz3;crd3

$sqult = "INSERT INTO F$kli_vxcf"."_uctdrdp ( rdp, nrd, szd, crz, crd, crz1, crd1, crz2, crd2, crz3, crd3 ) ".
" VALUES ( '$x_rdp',  '$x_nrd',  '$x_szd',  '$x_crz',  '$x_crd',  '$x_crz1',  '$x_crd1',  '$x_crz2',  '$x_crd2',  '$x_crz3',  '$x_crd3' ) ";

if( $crdp > 0 ) { $uloz = mysql_query("$sqult"); }
//echo $sqult;
  }
//koniec subor 215


//koniec while
}
fclose ($subor);

//exit;

?>
<script type="text/javascript">
window.open('../ucto/drudan.php?copern=1&drupoh=1&page=1', '_self' );
</script>
<?php
exit;
}
//koniec 1516 nacitat druh dph

//1515 nacitat autopohyby
if( $copern == 1515 )
{
$jejednoduche="";
if( $kli_vduj == 9 ) { $jejednoduche="ju"; }
?>
<script type="text/javascript">
if( !confirm ("Chcete Naèíta štandartnı èíselník automatickıch úètovnıch pohybov z ../import/uctautpoh<?php echo $kli_vrok; ?><?php echo $jejednoduche; ?>.csv ?") )
         {   }
else
  var okno = window.open("../mzdy/drmiezd_export.php?copern=151599&page=1","_self");
</script>
<?php
$copern=1;
}
if( $copern == 151599 )
{
$jejednoduche="";
if( $kli_vduj == 9 ) { $jejednoduche="ju"; }
$nazov="../import/uctautpoh".$kli_vrok.$jejednoduche.".csv";

$subor = fopen("$nazov", "r");
while (! feof($subor))
{

  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_data = $pole[0];

  if( $x_data == 216 ) { $akysubor=216; }

  //echo $akysubor;

//subor 216
if( $akysubor == 216 AND $x_data == 1 )
  {
  $x_cpoh = $pole[1];
  $x_pohp = $pole[2];
  $x_ucto = $pole[3];
  $x_druh = $pole[4];
  $x_uzk0 = $pole[5];
  $x_dzk0 = $pole[6];
  $x_uzk1 = $pole[7];
  $x_dzk1 = $pole[8];
  $x_uzk2 = $pole[9];
  $x_dzk2 = $pole[10];
  $x_udn1 = $pole[11];

  $x_ddn1 = $pole[12];
  $x_udn2 = $pole[13];
  $x_ddn2 = $pole[14];
  $x_hfak = $pole[15];
  $x_hico = $pole[16];
  $x_hstr = $pole[17];
  $x_hzak = $pole[18];
  $x_id = $pole[19];

$ccpoh=1*$x_cpoh;

//0;cpoh;pohp;ucto;druh;uzk0;dzk0;uzk1;dzk1;uzk2;dzk2;udn1;ddn1;udn2;ddn2;hfak;hico;hstr;hzak;id;datm

$sqult = "INSERT INTO F$kli_vxcf"."_uctpohyby ( cpoh, pohp, ucto, druh, uzk0, dzk0, uzk1, dzk1, uzk2, dzk2, udn1, ".
" ddn1, udn2, ddn2, hfak, hico, hstr, hzak, id, datm ) ".
" VALUES ( '$x_cpoh',  '$x_pohp',  '$x_ucto',  '$x_druh',  '$x_uzk0',  '$x_dzk0',  '$x_uzk1',  '$x_dzk1',  '$x_uzk2',  '$x_dzk2',  '$x_udn1', ".
" '$x_ddn1',  '$x_udn2',  '$x_ddn2',  '$x_hfak',  '$x_hico',  '$x_hstr',  '$x_hzak',  '$x_id', now() ) ";

if( $ccpoh > 0 ) { $uloz = mysql_query("$sqult"); }
//echo $sqult;
  }
//koniec subor 216


//koniec while
}
fclose ($subor);

//exit;

?>
<script type="text/javascript">
window.open('../ucto/uctpoh.php?copern=1&drupoh=1&page=1', '_self' );
</script>
<?php
exit;
}
//koniec 1515 nacitat autopohyby


// 1514 nacitat cash
if( $copern == 1514 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete Naèíta štandartnı èíselník generovania CASH FLOW z ../import/cashgen<?php echo $kli_vrok; ?>.csv ?") )
         {   }
else
  var okno = window.open("../mzdy/drmiezd_export.php?copern=151499&page=1","_self");
</script>
<?php
$copern=1;
}
if( $copern == 151499 )
{
$nazov="../import/cashgen".$kli_vrok.".csv";

$subor = fopen("$nazov", "r");
while (! feof($subor))
{

  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_data = $pole[0];

  if( $x_data == 214 ) { $akysubor=214; }

  //echo $akysubor;

//subor 214
if( $akysubor == 214 AND $x_data == 1 )
  {
  $x_uce = $pole[1];
  $x_crs = 1*$pole[2];

$sqult = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) ".
" VALUES ( '$x_uce', '$x_crs' ) ";

$uloz = mysql_query("$sqult");
//echo $sqult;
  }
//koniec subor 214


//koniec while
}
fclose ($subor);

//exit;

?>
<script type="text/javascript">
window.open('../ucto/oprcis.php?copern=308&drupoh=95&page=1&sysx=UCT', '_self' );
</script>
<?php
exit;
}
//koniec 1514 cash


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Export</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

    
</script>
</HEAD>
<BODY class="white" >

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Export / Import štandartnıch èíselníkov</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<?php


if ( $copern == 19 ) { 


$nazovsuboru="../tmp/dmn".$kli_vrok.".csv"; 

if (File_Exists ("$nazovsuboru")) { $soubor = unlink("$nazovsuboru"); }

$soubor = fopen("$nazovsuboru", "a+");



  $text = "314;##########Tabulka F$kli_vxcf"."_mzddmn"."\r\n";
  fwrite($soubor, $text);
  $text = "0;dm;nzdm;dndm;td;nap_zp;nap_np;nap_sp;nap_ip;nap_pn;nap_up;nap_gf;nap_rf;br;rh;do;ne;ho;np;prn;prm;prv;prs;sa;ko;sax;su;au;suc;auc;dm1;dm2;dm3;dm4;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddmn ORDER BY dm");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->dm.";".$riadok->nzdm.";".$riadok->dndm.";".$riadok->td.";".$riadok->nap_zp.";".$riadok->nap_np.";".$riadok->nap_sp.";".$riadok->nap_ip.";".$riadok->nap_pn.";".$riadok->nap_up.";".$riadok->nap_gf.";".$riadok->nap_rf.";".$riadok->br.";".$riadok->rh.";".$riadok->do.";".$riadok->ne.";".$riadok->ho.";".$riadok->np.";".$riadok->prn.";".$riadok->prm.";".$riadok->prv.";".$riadok->prs.";".$riadok->sa.";".$riadok->ko.";".$riadok->sax.";".$riadok->su.";".$riadok->au.";".$riadok->suc.";".$riadok->auc.";".$riadok->dm1.";".$riadok->dm2.";".$riadok->dm3.";".$riadok->dm4.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

                     }
if ( $copern == 18 ) { 

$nazovsuboru="../tmp/pomer".$kli_vrok.".csv"; 

if (File_Exists ("$nazovsuboru")) { $soubor = unlink("$nazovsuboru"); }

$soubor = fopen("$nazovsuboru", "a+");

  $text = "315;##########Tabulka F$kli_vxcf"."_mzdpomer"."\r\n";
  fwrite($soubor, $text);
  $text = "0;pm;nzpm;prpm;zam_zp;zam_np;zam_sp;zam_ip;zam_pn;zam_up;zam_gf;zam_rf;fir_zp;fir_np;fir_sp;fir_ip;fir_pn;fir_up;fir_gf;fir_rf;zam_zm;pm_doh;pm_maj;np_soc;pm1;pm2;pm3;pm4;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpomer ORDER BY pm");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->pm.";".$riadok->nzpm.";".$riadok->prpm.";".$riadok->zam_zp.";".$riadok->zam_np.";".$riadok->zam_sp.";".$riadok->zam_ip.";".$riadok->zam_pn.";".$riadok->zam_up.";".$riadok->zam_gf.";".$riadok->zam_rf.";".$riadok->fir_zp.";".$riadok->fir_np.";".$riadok->fir_sp.";".$riadok->fir_ip.";".$riadok->fir_pn.";".$riadok->fir_up.";".$riadok->fir_gf.";".$riadok->fir_rf.";".$riadok->zam_zm.";".$riadok->pm_doh.";".$riadok->pm_maj.";".$riadok->np_soc.";".$riadok->pm1.";".$riadok->pm2.";".$riadok->pm3.";".$riadok->pm4.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


                     }
if ( $copern == 17 ) { 


$nazovsuboru="../tmp/zp".$kli_vrok.".csv"; 

if (File_Exists ("$nazovsuboru")) { $soubor = unlink("$nazovsuboru"); }

$soubor = fopen("$nazovsuboru", "a+");

  $text = "318;##########Tabulka F$kli_vxcf"."_zdravpois"."\r\n";
  fwrite($soubor, $text);
  $text = "0;zdrv;nzdr;uceb;numb;iban;vsy;ksy;ssy;anl;pz1;pz2;pz3;pz4;pz5;pt1;pt2;pt3;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois ORDER BY zdrv");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->zdrv.";".$riadok->nzdr.";".$riadok->uceb.";".$riadok->numb.";".$riadok->iban.";".$riadok->vsy.";".$riadok->ksy.";".$riadok->ssy.";".$riadok->anl.";".$riadok->pz1.";".$riadok->pz2.";".$riadok->pz3.";".$riadok->pz4.";".$riadok->pz5.";".$riadok->pt1.";".$riadok->pt2.";".$riadok->pt3.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


                     }

if ( $copern == 16 ) { 

$nazovsuboru="../tmp/druhdph".$kli_vrok.".csv"; 

if (File_Exists ("$nazovsuboru")) { $soubor = unlink("$nazovsuboru"); }

$soubor = fopen("$nazovsuboru", "a+");

 $text = "215;##########Tabulka F$kli_vxcf"."_uctdrdp"."\r\n";
  fwrite($soubor, $text);
  $text = "0;rdp;nrd;szd;crz;crd;crz1;crd1;crz2;crd2;crz3;crd3;rxx"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctdrdp ORDER BY rdp");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->rdp.";".$riadok->nrd.";".$riadok->szd.";".$riadok->crz.";".$riadok->crd.";".$riadok->crz1.";".$riadok->crd1.";".$riadok->crz2.";".$riadok->crd2.";".$riadok->crz3.";".$riadok->crd3.";";

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

                     }

if ( $copern == 15 ) { 

$nazovsuboru="../tmp/uctautpoh".$kli_vrok.".csv"; 

if (File_Exists ("$nazovsuboru")) { $soubor = unlink("$nazovsuboru"); }

$soubor = fopen("$nazovsuboru", "a+");

 $text = "216;##########Tabulka F$kli_vxcf"."_uctpohyby"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpoh;pohp;ucto;druh;uzk0;dzk0;uzk1;dzk1;uzk2;dzk2;udn1;ddn1;udn2;ddn2;hfak;hico;hstr;hzak;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctpohyby ORDER BY cpoh");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpoh.";".$riadok->pohp.";".$riadok->ucto.";".$riadok->druh.";".$riadok->uzk0.";".$riadok->dzk0.";".$riadok->uzk1.";".$riadok->dzk1.";".$riadok->uzk2.";".$riadok->dzk2.";".$riadok->udn1.";".$riadok->ddn1.";".$riadok->udn2.";".$riadok->ddn2.";".$riadok->hfak.";".$riadok->hico.";".$riadok->hstr.";".$riadok->hzak.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

                     }

if ( $copern == 14 ) { 

$nazovsuboru="../tmp/cashgen".$kli_vrok.".csv"; 

if (File_Exists ("$nazovsuboru")) { $soubor = unlink("$nazovsuboru"); }

$soubor = fopen("$nazovsuboru", "a+");

 $text = "214;##########Tabulka F$kli_vxcf"."_crcash_flow2011"."\r\n";
  fwrite($soubor, $text);
  $text = "0;uce;crs"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_crcash_flow2011 ORDER BY uce");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->uce.";".$riadok->crs;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

                     }


if ( $copern == 14 OR $copern == 15 OR $copern == 16 OR $copern == 17 OR $copern == 18 OR $copern == 19 ) { 

fclose($soubor);

?>

<a href="<?php echo $nazovsuboru; ?>"><?php echo $nazovsuboru; ?></a>


<?php

                                                           }

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
