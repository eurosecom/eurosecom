<HTML>
<?php
do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$cislo_zdrv = $_REQUEST['cislo_zdrv'];
$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if(!isset($fort)) $fort = 1;
$h_oprav = 1*$_REQUEST['h_oprav'];
$max2 = 1*$_REQUEST['max2'];

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

if ( $kli_vrok < 2010 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vykaz_ZP2009.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&cislo_zdrv=<?php echo $cislo_zdrv; ?>
&tis=<?php echo $tis; ?>&fort=<?php echo $fort; ?>","_self");
</script>
<?php
exit;
}
if ( $kli_vrok < 2013 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vykaz_ZP2012.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&cislo_zdrv=<?php echo $cislo_zdrv; ?>
&tis=<?php echo $tis; ?>&fort=<?php echo $fort; ?>","_self");
</script>
<?php
exit;
}
if ( $kli_vrok < 2014 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vykaz_ZP2013.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&cislo_zdrv=<?php echo $cislo_zdrv; ?>
&tis=<?php echo $tis; ?>&fort=<?php echo $fort; ?>&h_oprav=<?php echo $h_oprav; ?>","_self");
</script>
<?php
exit;
}
if ( $kli_vrok < 2015 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vykaz_ZP2014.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&cislo_zdrv=<?php echo $cislo_zdrv; ?>
&tis=<?php echo $tis; ?>&fort=<?php echo $fort; ?>&h_oprav=<?php echo $h_oprav; ?>","_self");
</script>
<?php
exit;
}

if ( $copern == 1 )
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

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$ajmeno = 1*$_REQUEST['ajmeno'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//bezpecne zmaz
if ( File_Exists("../tmp/mzdpasky$kli_uzid.pdf") ) { $soubor = unlink("../tmp/mzdpasky$kli_uzid.pdf"); }
if ( File_Exists("../tmp/mzdzos.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/mzdzos.$kli_uzid.pdf"); }
if ( File_Exists("../tmp/mzdvyp.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/mzdvyp.$kli_uzid.pdf"); }
if ( File_Exists("../tmp/priemery.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/priemery.$kli_uzid.pdf"); }
if ( File_Exists("../tmp/prilohaSP.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/prilohaSP.$kli_uzid.pdf"); }
if ( File_Exists("../tmp/vykazSP.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/vykazSP.$kli_uzid.pdf"); }
if ( File_Exists("../tmp/vykazZP.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/vykazZP.$kli_uzid.pdf"); }

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

$mzdmes="mzdzalmesx".$kli_uzid;
$mzdtrn="mzdzaltrnx".$kli_uzid;
$mzdddp="mzdzalddpx".$kli_uzid;
$mzdkun="mzdzalkunx".$kli_uzid;
$mzdprm="mzdzalprmx".$kli_uzid;

$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalmesx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalmes WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzaltrnx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzaltrn WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalddpx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalddp WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalkunx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalkun WHERE ume = $kli_vume";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalprmx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalprm WHERE ume = $kli_vume";
$vysledek = mysql_query("$sql");

$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_mzdzalprmx$kli_uzid WHERE ume = $kli_vume ");
$cpoldok = mysql_num_rows($sqldok);
if( $cpoldok < 1 )
{
//echo "nie je mzdzal za ".$kli_vume;
$mzdprm="mzdprm";
}

//pre mesacny vykaz vytvor pracovny subor
if ( $copern == 10 OR $copern == 20 OR $copern == 30 )
{

//prac.subor
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   rodne        DECIMAL(10,0) DEFAULT 0,
   xdrv         INT(7) DEFAULT 0,
   znizp        INT(1) DEFAULT 0,
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
   celk_spolu   DECIMAL(10,2) DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0,
   pzam_celk    DECIMAL(10,0) DEFAULT 0,
   pzam_zp      DECIMAL(10,0) DEFAULT 0,
   pzam_zpn     DECIMAL(10,0) DEFAULT 0,
   zcel_zp      DECIMAL(10,2) DEFAULT 0,
   zcel_zpn     DECIMAL(10,2) DEFAULT 0,
   pdni_zp      DECIMAL(10,0) DEFAULT 0,
   pdni_zpn     DECIMAL(10,0) DEFAULT 0,
   vcelk_dni    DECIMAL(10,0) DEFAULT 0,
   vnesp_dni    DECIMAL(10,0) DEFAULT 0,
   vden_prvy    DATE,
   vden_posl    DATE,
   konx2        DECIMAL(10,0) DEFAULT 0,
   zcel_odp     DECIMAL(10,2) DEFAULT 0,
   zcel_inp     DECIMAL(10,2) DEFAULT 0,
   zodp_zp      DECIMAL(10,2) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid.$sqlt;
//$vytvor = mysql_query("$vsql");

//zober data zo sum 
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,".
"zzam_zp,zzam_np,zzam_sp,zzam_ip,zzam_pn,zzam_up,zzam_gf,zzam_rf,".
"zfir_zp,zfir_np,zfir_sp,zfir_ip,zfir_pn,zfir_up,zfir_gf,zfir_rf,".
"ozam_zp,ozam_np,ozam_sp,ozam_ip,ozam_pn,ozam_up,ozam_gf,ozam_rf,".
"ofir_zp,ofir_np,ofir_sp,ofir_ip,ofir_pn,ofir_up,ofir_gf,ofir_rf,".
"ozam_spolu,ofir_spolu,0,".
"0,".
"1,1,0,(zdan_dnp+pdan_zn1),0,".
"0,0,0,0,'','',".
"0,".
"zmin_up,0,zmin_ip ".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE ume = $kli_vume AND szpnie = 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober data z vy nezp_dni
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,".
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
"0,0,0,".
"0,".
"0,0,0,0,0,".
"0,0,0,nezp_dni,'','',".
"0,".
"0,0,0 ".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume = $kli_vume AND vzpnie = 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,rodne,xdrv,znizp,".
"sum(zzam_zp),sum(zzam_np),sum(zzam_sp),sum(zzam_ip),sum(zzam_pn),sum(zzam_up),sum(zzam_gf),sum(zzam_rf),".
"sum(zfir_zp),sum(zfir_np),sum(zfir_sp),sum(zfir_ip),sum(zfir_pn),sum(zfir_up),sum(zfir_gf),sum(zfir_rf),".
"sum(ozam_zp),sum(ozam_np),sum(ozam_sp),sum(ozam_ip),sum(ozam_pn),sum(ozam_up),sum(ozam_gf),sum(ozam_rf),".
"sum(ofir_zp),sum(ofir_np),sum(ofir_sp),sum(ofir_ip),sum(ofir_pn),sum(ofir_up),sum(ofir_gf),sum(ofir_rf),".
"sum(ozam_spolu),sum(ofir_spolu),sum(celk_spolu),".
"0,".
"sum(pzam_celk),sum(pzam_zp),sum(pzam_zpn),sum(zcel_zp),sum(zcel_zpn),".
"sum(pdni_zp),sum(pdni_zpn),sum(vcelk_dni),sum(vnesp_dni),vden_prvy,vden_posl,".
"888,".
"sum(zcel_odp),sum(zcel_inp),sum(zodp_zp) ".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY oc";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid." WHERE konx2 != 888 ";
$dsql = mysql_query("$dsqlt");
//exit;

//spocitat riadky za zdrv a rodne cislo teda zobrat oc najmensie a dat ho podla rodneho cisla na vsetky
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdkun".
" SET rodne=1*CONCAT(rdc, rdk ), xdrv=zdrv ".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc = F$kli_vxcf"."_mzdkun.oc";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdtextmzd".
" SET rodne=1*cszp ".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc = F$kli_vxcf"."_mzdtextmzd.invt AND cszp > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET zzam_rf=1 ";
$oznac = mysql_query("$sqtoz");

//presunul som to sem aby vyriesil ak pomer 1 jedno osobne a dohoda druhe osobne
//ak je ZP DOVERA a DOHODAR presun CELK.PRIJEM PRE ODP. do CELK.INY PRIJ. od 1.7.2015 zacali kontrolovat
$sqltt = "SELECT * FROM F$kli_vxcf"."_$mzdkun ".
"LEFT JOIN F$kli_vxcf"."_mzdpomer ON F$kli_vxcf"."_$mzdkun.pom=F$kli_vxcf"."_mzdpomer.pm ".
" WHERE ume = $kli_vume AND pm_doh = 1 ORDER BY oc ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$sqlttx = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET zcel_inp=zcel_odp WHERE oc = $hlavicka->oc AND konx2 = 888 AND zcel_odp != 0 AND xdrv >= 2300 AND xdrv <= 2499 ";
$sqlx = mysql_query("$sqlttx");

//echo $sqlttx."<br />";

$sqlttx = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET zcel_odp=0 WHERE oc = $hlavicka->oc AND konx2 = 888 AND zcel_odp != 0 AND xdrv >= 2300 AND xdrv <= 2499 ";
$sqlx = mysql_query("$sqlttx");

}
$i=$i+1;
  }

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" SELECT MIN(oc),rodne,xdrv,znizp,".
"sum(zzam_zp),sum(zzam_np),sum(zzam_sp),sum(zzam_ip),sum(zzam_pn),sum(zzam_up),sum(zzam_gf),sum(zzam_rf),".
"sum(zfir_zp),sum(zfir_np),sum(zfir_sp),sum(zfir_ip),sum(zfir_pn),sum(zfir_up),sum(zfir_gf),sum(zfir_rf),".
"sum(ozam_zp),sum(ozam_np),sum(ozam_sp),sum(ozam_ip),sum(ozam_pn),sum(ozam_up),sum(ozam_gf),sum(ozam_rf),".
"sum(ofir_zp),sum(ofir_np),sum(ofir_sp),sum(ofir_ip),sum(ofir_pn),sum(ofir_up),sum(ofir_gf),sum(ofir_rf),".
"sum(ozam_spolu),sum(ofir_spolu),sum(celk_spolu),".
"9,".
"sum(pzam_celk),sum(pzam_zp),sum(pzam_zpn),sum(zcel_zp),sum(zcel_zpn),".
"sum(pdni_zp),sum(pdni_zpn),0,0,vden_prvy,vden_posl,".
"0,".
"sum(zcel_odp),sum(zcel_inp),sum(zodp_zp) ".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0 AND xdrv > 0 ".
" GROUP BY rodne";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdprcvyplx$kli_uzid".
" SET F$kli_vxcf"."_mzdprcvypl$kli_uzid.vnesp_dni = 0 ".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.rodne = F$kli_vxcf"."_mzdprcvyplx$kli_uzid.rodne AND ".
" F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc != F$kli_vxcf"."_mzdprcvyplx$kli_uzid.oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdprcvyplx$kli_uzid".
" SET F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc = F$kli_vxcf"."_mzdprcvyplx$kli_uzid.oc ".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.rodne = F$kli_vxcf"."_mzdprcvyplx$kli_uzid.rodne ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvyplx$kli_uzid ";
$oznac = mysql_query("$sqtoz");

//exit;
//koniec spocitat riadky za zdrv a rodne cislo



$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,rodne,xdrv,znizp,".
"sum(zzam_zp),sum(zzam_np),sum(zzam_sp),sum(zzam_ip),sum(zzam_pn),sum(zzam_up),sum(zzam_gf),sum(zzam_rf),".
"sum(zfir_zp),sum(zfir_np),sum(zfir_sp),sum(zfir_ip),sum(zfir_pn),sum(zfir_up),sum(zfir_gf),sum(zfir_rf),".
"sum(ozam_zp),sum(ozam_np),sum(ozam_sp),sum(ozam_ip),sum(ozam_pn),sum(ozam_up),sum(ozam_gf),sum(ozam_rf),".
"sum(ofir_zp),sum(ofir_np),sum(ofir_sp),sum(ofir_ip),sum(ofir_pn),sum(ofir_up),sum(ofir_gf),sum(ofir_rf),".
"sum(ozam_spolu),sum(ofir_spolu),sum(celk_spolu),".
"0,".
"sum(pzam_celk),sum(pzam_zp),sum(pzam_zpn),sum(zcel_zp),sum(zcel_zpn),".
"sum(pdni_zp),sum(pdni_zpn),sum(vcelk_dni),sum(vnesp_dni),vden_prvy,vden_posl,".
"999,".
"sum(zcel_odp),sum(zcel_inp),sum(zodp_zp) ".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY oc";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid." WHERE konx2 != 999 ";
$dsql = mysql_query("$dsqlt");

//ak zzam_zp > zcel_zp zcel_zp=zzam_zp
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET  zcel_zp=zzam_zp".
" WHERE zzam_zp > zcel_zp ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
//exit;

//ak zzam_zp=0 potom vynuluj pzam_zp
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET ".
" pzam_zp=0".
" WHERE zzam_zp=0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");


$prvyden=$kli_vrok."-".$kli_vmes."-01";

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET ".
" vden_prvy='$prvyden', vden_posl=LAST_DAY('$prvyden')".
" WHERE oc >= 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET ".
" vcelk_dni=TO_DAYS(vden_posl)-TO_DAYS(vden_prvy)+1, pdni_zp=vcelk_dni-vnesp_dni".
" WHERE oc >= 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//vypocitaj sucty
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET ozam_spolu=ozam_zp,".
"ofir_spolu=ofir_zp, celk_spolu=ozam_spolu+ofir_spolu,".
"zzam_np=0, ozam_np=0, ofir_np=0, ofir_gf=0, ofir_rf=0".
" WHERE oc > 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//dopln zdrv z kun do vy
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET xdrv=zdrv, znizp=zpno, ofir_gf=ozam_zp+ofir_zp".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//ak je odvodova ulava vynuluj dni, prijem, percenta a zaklad od 1.5.2014 zacali kontrolovat
$sqltt = "SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE ume = $kli_vume AND pom = 14 ORDER BY oc";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$sqlttx = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET pdni_zp=0, zcel_zp=0, vcelk_dni=0 WHERE oc = $hlavicka->oc AND konx2 = 999 ";
$sqlx = mysql_query("$sqlttx");

}
$i=$i+1;
  }
//exit;


//ak je DOHODAR co neodvadza do ZP a VZaklad=0 aj odvody=0 vynuluj aj UhrnPrijmu, od 1.5.2014 zacali kontrolovat
$sqltt = "SELECT * FROM F$kli_vxcf"."_$mzdkun ".
"LEFT JOIN F$kli_vxcf"."_mzdpomer ON F$kli_vxcf"."_$mzdkun.pom=F$kli_vxcf"."_mzdpomer.pm ".
" WHERE ume = $kli_vume AND pm_doh = 1 AND zam_zp = 0 AND fir_zp = 0 ORDER BY oc ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$sqlttx = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET zcel_zp=0, zcel_odp=0, zcel_inp=0 WHERE zzam_zp = 0 AND ozam_zp = 0 AND ofir_zp = 0 AND oc = $hlavicka->oc AND konx2 = 999 ";
$sqlx = mysql_query("$sqlttx");
//echo $sqlttx;
}
$i=$i+1;
  }

//od tadeto som to presunul hore
//ak je ZP DOVERA a DOHODAR presun CELK.PRIJEM PRE ODP. do CELK.INY PRIJ. od 1.7.2015 zacali kontrolovat
$sqltt = "SELECT * FROM F$kli_vxcf"."_$mzdkun ".
"LEFT JOIN F$kli_vxcf"."_mzdpomer ON F$kli_vxcf"."_$mzdkun.pom=F$kli_vxcf"."_mzdpomer.pm ".
" WHERE ume = $kli_vume AND pm_doh = 1111 ORDER BY oc ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$sqlttx = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET zcel_inp=zcel_odp WHERE oc = $hlavicka->oc AND konx2 = 999 AND zcel_odp != 0 AND xdrv >= 2300 AND xdrv <= 2499 ";
$sqlx = mysql_query("$sqlttx");

//echo $sqlttx."<br />";

$sqlttx = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET zcel_odp=0 WHERE oc = $hlavicka->oc AND konx2 = 999 AND zcel_odp != 0 AND xdrv >= 2300 AND xdrv <= 2499 ";
$sqlx = mysql_query("$sqlttx");

}
$i=$i+1;
  }

//exit;

//ak zdravotne postihnutie znizp presun do .._np
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET zzam_np=zzam_zp, ozam_np=ozam_zp, ofir_np=ofir_zp, ofir_rf=ofir_gf, pzam_zpn=pzam_zp, pdni_zpn=pdni_zp, zcel_zpn=zcel_zp, ".
" zzam_zp=0, ozam_zp=0, ofir_zp=0, ofir_gf=0, pzam_zp=0, pdni_zp=0, zcel_zp=0 ".
" WHERE znizp=1";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" SELECT oc,rodne,xdrv,znizp,".
"sum(zzam_zp),sum(zzam_np),sum(zzam_sp),sum(zzam_ip),sum(zzam_pn),sum(zzam_up),sum(zzam_gf),sum(zzam_rf),".
"sum(zfir_zp),sum(zfir_np),sum(zfir_sp),sum(zfir_ip),sum(zfir_pn),sum(zfir_up),sum(zfir_gf),sum(zfir_rf),".
"sum(ozam_zp),sum(ozam_np),sum(ozam_sp),sum(ozam_ip),sum(ozam_pn),sum(ozam_up),sum(ozam_gf),sum(ozam_rf),".
"sum(ofir_zp),sum(ofir_np),sum(ofir_sp),sum(ofir_ip),sum(ofir_pn),sum(ofir_up),sum(ofir_gf),sum(ofir_rf),".
"sum(ozam_spolu),sum(ofir_spolu),sum(celk_spolu),".
"9,".
"sum(pzam_celk),sum(pzam_zp),sum(pzam_zpn),sum(zcel_zp),sum(zcel_zpn),".
"sum(pdni_zp),sum(pdni_zpn),0,0,vden_prvy,vden_posl,".
"0,".
"sum(zcel_odp),sum(zcel_inp),sum(zodp_zp) ".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY konx";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" SELECT oc,rodne,xdrv,znizp,".
"sum(zzam_zp),sum(zzam_np),sum(zzam_sp),sum(zzam_ip),sum(zzam_pn),sum(zzam_up),sum(zzam_gf),sum(zzam_rf),".
"sum(zfir_zp),sum(zfir_np),sum(zfir_sp),sum(zfir_ip),sum(zfir_pn),sum(zfir_up),sum(zfir_gf),sum(zfir_rf),".
"sum(ozam_zp),sum(ozam_np),sum(ozam_sp),sum(ozam_ip),sum(ozam_pn),sum(ozam_up),sum(ozam_gf),sum(ozam_rf),".
"sum(ofir_zp),sum(ofir_np),sum(ofir_sp),sum(ofir_ip),sum(ofir_pn),sum(ofir_up),sum(ofir_gf),sum(ofir_rf),".
"sum(ozam_spolu),sum(ofir_spolu),sum(celk_spolu),".
"8,".
"sum(pzam_celk),sum(pzam_zp),sum(pzam_zpn),sum(zcel_zp),sum(zcel_zpn),".
"sum(pdni_zp),sum(pdni_zpn),0,0,vden_prvy,vden_posl,".
"0,".
"sum(zcel_odp),sum(zcel_inp),sum(zodp_zp) ".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY xdrv";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,rodne,xdrv,znizp,".
"zzam_zp,zzam_np,zzam_sp,zzam_ip,zzam_pn,zzam_up,zzam_gf,zzam_rf,".
"zfir_zp,zfir_np,zfir_sp,zfir_ip,zfir_pn,zfir_up,zfir_gf,zfir_rf,".
"ozam_zp,ozam_np,ozam_sp,ozam_ip,ozam_pn,ozam_up,ozam_gf,ozam_rf,".
"ofir_zp,ofir_np,ofir_sp,ofir_ip,ofir_pn,ofir_up,ofir_gf,ofir_rf,".
"ozam_spolu,ofir_spolu,celk_spolu,".
"konx,".
"pzam_celk,pzam_zp,pzam_zpn,zcel_zp,zcel_zpn,".
"pdni_zp,pdni_zpn,0,0,'','',".
"0,".
"zcel_odp,zcel_inp,zodp_zp ".
" FROM F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" WHERE oc >= 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;
}
//koniec pracovneho suboru 

//NACITANIE UDAJOV Z PARAMETROV
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_$mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  $zam_zp=$riaddok->zam_zp;
  $fir_zp=$riaddok->fir_zp;
  $zam_zpn=$riaddok->zam_zpn;
  $fir_zpn=$riaddok->fir_zpn;
  }


/////////////////////////////////////////////////VYTLAC MESACNY VYKAZ
if ( $copern == 10 )
{
if ( File_Exists("../tmp/vykazZP.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/vykazZP.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE konx = 8 AND xdrv = $cislo_zdrv ORDER BY konx";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

  $ozam_np = $hlavicka->ozam_np;
  $pole = explode(".", $ozam_np);
  $Cozam_np = $pole[0];
  $Dozam_np = substr($pole[1],0,1);

//NACITANIE CISLA PLATITELA,NAZVU Z CISELNIKA ZP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv=$cislo_zdrv ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $platitel=$riaddok->vsy;
  $nazzdrv=$riaddok->nzdr;
  }

//pocitane dni
$prvydena=$kli_vrok."-".$kli_vmes."-01";
$pocetdnia=31;
$sqlttd = "SELECT * FROM kalendar WHERE ume = $kli_vume ";
$sqld = mysql_query("$sqlttd");
$pocetdnia = mysql_num_rows($sqld);
$posldena=$kli_vrok."-".$kli_vmes."-".$pocetdnia;

$sqltd = "DROP TABLE F".$kli_vxcf."_mzdprcneod".$kli_uzid;
$vysledokd = mysql_query("$sqltd");
$sqltdd = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   den_prvy     DATE,
   den_posl     DATE,
   celk_dni     DECIMAL(10,2) DEFAULT 0,
   konnex       DECIMAL(10,2) DEFAULT 0
);
mzdprc;

$vsqld = "CREATE TABLE F".$kli_vxcf."_mzdprcneod".$kli_uzid.$sqltdd;
$vytvord = mysql_query("$vsqld");

//strana
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(20);

$nebolaziadna=1;

//vszp mesacny max2=1
if ( $cislo_zdrv >= 2500 AND $cislo_zdrv <= 2599 AND $max2 == 1 )
     {
$nebolaziadna=0;

if ( File_Exists('../dokumenty/zdravpoist/vszp2015/mesacny_vykaz_vszp2015.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/zdravpoist/vszp2015/mesacny_vykaz_vszp2015.jpg',0,0,210,297);
}
$pdf->SetY(10);

//kod poistovne
$pdf->Cell(190,11," ","$rmc1",1,"L");
$zdrv22=substr($cislo_zdrv,2,2);
$A=substr($zdrv22,0,1);
$B=substr($zdrv22,1,1);
$pdf->Cell(171,5," ","$rmc1",0,"C");
$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(3,5,"$B","$rmc",1,"C");

//cislo platitela
$pdf->Cell(190,12," ","$rmc1",1,"L");
$A=substr($platitel,0,1);
$B=substr($platitel,1,1);
$C=substr($platitel,2,1);
$D=substr($platitel,3,1);
$E=substr($platitel,4,1);
$F=substr($platitel,5,1);
$G=substr($platitel,6,1);
$H=substr($platitel,7,1);
$I=substr($platitel,8,1);
$J=substr($platitel,9,1);
$pdf->Cell(141,6," ","$rmc1",0,"L");
$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(3,5,"$B","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");
$pdf->Cell(3,5,"$D","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(3,5,"$F","$rmc",0,"C");
$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");
$pdf->Cell(3,5,"$J","$rmc",1,"C");

//druh vykazu
$pdf->Cell(190,5," ","$rmc1",1,"L");
$akyvyk="N";
if ( $h_oprav == 1 ) $akyvyk="O";
$pdf->Cell(174,5," ","$rmc1",0,"L");$pdf->Cell(4,6,"$akyvyk","$rmc",1,"C");

//za obdobie
$pdf->Cell(190,1," ","$rmc1",1,"L");
$obdobiem=$kli_vmes;
if ( $obdobiem < 10 ) $obdobiem= "0".$obdobiem;
$obdobie=$kli_vrok.$obdobiem;
$pdf->Cell(28,6," ","$rmc1",0,"L");$pdf->Cell(60,7,"$obdobie","$rmc",0,"L");

//den vyplaty
$fir_mzdx06=1*$fir_mzdx06;
if ( $fir_mzdx06 == 0 ) $fir_mzdx06="";
$A=substr($fir_mzdx06,0,1);
$B=substr($fir_mzdx06,1,1);
$pdf->Cell(79,5," ","$rmc1",0,"L");$pdf->Cell(3,7,"$A","$rmc",0,"C");$pdf->Cell(4,7,"$B","$rmc",1,"C");

//PLATITEL
//nazov a forma
$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->Cell(35,6," ","$rmc1",0,"L");$pdf->Cell(90,5,"$fir_fnaz","$rmc",0,"L");
$pravnaforma="PO";
if ( $fir_uctt03 == 999 ) { $pravnaforma="FO"; }
$pdf->Cell(11,6," ","$rmc1",0,"L");$pdf->Cell(43,5,"$pravnaforma","$rmc",1,"L");
//rodne
$pdf->Cell(190,4," ","$rmc1",1,"L");
$A=substr($fordc,0,1);
$B=substr($fordc,1,1);
$C=substr($fordc,2,1);
$D=substr($fordc,3,1);
$E=substr($fordc,4,1);
$F=substr($fordc,5,1);
$G=substr($fordc,6,1);
$H=substr($fordc,7,1);
$I=substr($fordc,8,1);
$J=substr($fordc,9,1);
$pdf->Cell(29,5," ","$rmc1",0,"L");
$pdf->Cell(3,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");
$pdf->Cell(3,5,"$D","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(3,5,"$G","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");
$pdf->Cell(3,5,"$J","$rmc",1,"C");
//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(29,5," ","$rmc1",0,"L");
$pdf->Cell(3,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");
$pdf->Cell(3,5,"$D","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(3,5,"$G","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");
$pdf->Cell(3,5,"$J","$rmc",0,"C");
//ico
$text=$fir_fico;
if ( $fir_fico < 1000000 ) { $text="00".$fir_fico; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$pdf->Cell(45,5," ","$rmc1",0,"L");
$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(3,5,"$C","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(3,5,"$F","$rmc",0,"C");
$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(3,5,"$H","$rmc",1,"C");

$pdf->SetFont('arial','',9);
//obec
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(38,6," ","$rmc1",0,"L");$pdf->Cell(62,6,"$fir_fmes","$rmc",0,"L");
$pdf->Cell(9,6," ","$rmc1",0,"L");$pdf->Cell(70,6,"$fir_fuli","$rmc",1,"L");
//cislo
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(45,5," ","$rmc1",0,"L");$pdf->Cell(19,5,"$fir_fcdm","$rmc",0,"L");
$pdf->Cell(20,5," ","$rmc1",0,"L");$pdf->Cell(16,5," ","$rmc",0,"L");
//psc
$A=substr($fir_fpsc,0,1);
$B=substr($fir_fpsc,1,1);
$C=substr($fir_fpsc,2,1);
$D=substr($fir_fpsc,3,1);
$E=substr($fir_fpsc,4,1);
$pdf->Cell(10,5," ","$rmc1",0,"L");
$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(3,5,"$C","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(3,5,"$E","$rmc",0,"C");
//stat
$stat="";
$pdf->Cell(17,5," ","$rmc1",0,"R");$pdf->Cell(34,5,"$stat","$rmc",1,"L");

//celkovy pocet poistenych vo vsetkych ZP
$pocetpoistenychcelkom=0;
$sqldokx = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume AND zdrv > 0 AND zpnie = 0 ";
$sqlx = mysql_query("$sqldokx");
$pocetpoistenychcelkom=1*mysql_num_rows($sqlx);
if ( $pocetpoistenychcelkom == 0 ) { $pocetpoistenychcelkom=$hlavicka->pzam_celk; }

$poistenychvzp=$hlavicka->pzam_celk;
$platia=$hlavicka->pzam_zp;
$platiazpn=$hlavicka->pzam_zpn;
if ( $agrostav >= 0 )
{ 
$sqlttxx = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 0 AND xdrv = $cislo_zdrv ORDER BY konx ";
$sqlxx = mysql_query("$sqlttxx");
$polxx = mysql_num_rows($sqlxx);

$poistenychvzp=$polxx;

$sqlttxx = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 0 AND xdrv = $cislo_zdrv AND znizp = 0 AND ( ozam_zp > 0 OR ofir_zp > 0 ) ORDER BY konx ";
$sqlxx = mysql_query("$sqlttxx");
$polxx = mysql_num_rows($sqlxx);

$platia=$polxx;

$sqlttxx = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 0 AND xdrv = $cislo_zdrv AND znizp > 0 AND ( ozam_np > 0 OR ofir_np > 0 ) ORDER BY konx ";
$sqlxx = mysql_query("$sqlttxx");
$polxx = mysql_num_rows($sqlxx);

$platiazpn=$polxx;
}

//PREDDAVKY
//riadky 1 a 1a
$pdf->Cell(190,7," ","$rmc1",1,"L");
$pdf->Cell(140,5," ","$rmc1",0,"L");$pdf->Cell(11,5," ","$rmc",0,"R");$pdf->Cell(24,5,"$poistenychvzp","$rmc",1,"R");
$pdf->Cell(140,5," ","$rmc1",0,"L");$pdf->Cell(11,5," ","$rmc",0,"L");$pdf->Cell(24,4,"$pocetpoistenychcelkom","$rmc",1,"R");
//riadky 2 az 8
$pdf->Cell(190,5," ","$rmc1",1,"L");
$pdf->Cell(140,5," ","$rmc1",0,"L");$pdf->Cell(11,5,"","$rmc",0,"L");$pdf->Cell(24,5,"$platia","$rmc",1,"R");
$pdf->Cell(140,5," ","$rmc1",0,"L");$pdf->Cell(11,5,"","$rmc",0,"L");$pdf->Cell(24,4,"$hlavicka->pdni_zp","$rmc",1,"R");
$pdf->Cell(140,5," ","$rmc1",0,"L");$pdf->Cell(11,5,"","$rmc",0,"L");$pdf->Cell(24,5,"$hlavicka->zcel_zp","$rmc",1,"R");
$pdf->Cell(140,6," ","$rmc1",0,"L");$pdf->Cell(11,6,"","$rmc",0,"L");$pdf->Cell(24,5,"$hlavicka->zzam_zp","$rmc",1,"R");
$pdf->Cell(139,7," ","$rmc1",0,"L");$pdf->Cell(12,4,"$fir_zp","$rmc",0,"L");$pdf->Cell(24,4,"$hlavicka->ofir_zp","$rmc",1,"R");
$pdf->Cell(140,5," ","$rmc1",0,"L");$pdf->Cell(11,5,"$zam_zp","$rmc",0,"L");$pdf->Cell(24,5,"$hlavicka->ozam_zp","$rmc",1,"R");
$pdf->Cell(140,5," ","$rmc1",0,"L");$pdf->Cell(11,5,"","$rmc",0,"L");$pdf->Cell(24,5,"$hlavicka->ofir_gf","$rmc",1,"R");
//riadky 9 az 16
$pdf->Cell(190,4," ","$rmc1",1,"L");
$pdf->Cell(140,5," ","$rmc1",0,"L");$pdf->Cell(11,5,"","$rmc",0,"L");$pdf->Cell(24,5,"$platiazpn","$rmc",1,"R");
$pdf->Cell(140,5," ","$rmc1",0,"L");$pdf->Cell(11,5,"","$rmc",0,"L");$pdf->Cell(24,4,"$hlavicka->pdni_zpn","$rmc",1,"R");
$pdf->Cell(140,6," ","$rmc1",0,"L");$pdf->Cell(11,6,"","$rmc",0,"L");$pdf->Cell(24,5,"$hlavicka->zcel_zpn","$rmc",1,"R");
$pdf->Cell(140,5," ","$rmc1",0,"L");$pdf->Cell(11,5,"","$rmc",0,"L");$pdf->Cell(24,4,"$hlavicka->zzam_np","$rmc",1,"R");
$pdf->Cell(140,6," ","$rmc1",0,"L");$pdf->Cell(11,5,"$fir_zpn","$rmc",0,"L");$pdf->Cell(24,5,"$hlavicka->ofir_np","$rmc",1,"R");
$pdf->Cell(140,5," ","$rmc1",0,"L");$pdf->Cell(11,5,"$zam_zpn","$rmc",0,"L");$pdf->Cell(24,5,"$hlavicka->ozam_np","$rmc",1,"R");
$pdf->Cell(140,6," ","$rmc1",0,"L");$pdf->Cell(11,6,"","$rmc",0,"L");$pdf->Cell(24,4,"$hlavicka->ofir_rf","$rmc",1,"R");
$pdf->Cell(140,5," ","$rmc1",0,"L");$pdf->Cell(11,5,"","$rmc",0,"L");$pdf->Cell(24,5,"$hlavicka->celk_spolu","$rmc",1,"R");
$pdf->SetFont('arial','',8);

//VYPLNIL
$pdf->Cell(190,5," ","$rmc1",1,"L");
$pdf->Cell(22,4," ","$rmc1",0,"L");$pdf->Cell(40,4,"$fir_mzdt05","$rmc",0,"L");
$pdf->Cell(10,4," ","$rmc1",0,"L");$pdf->Cell(25,4,"$fir_mzdt04","$rmc",0,"L");
$pdf->Cell(7,4," ","$rmc1",0,"L");$pdf->Cell(26,4,"$fir_ffax","$rmc",0,"L");
$pdf->Cell(9,4," ","$rmc1",0,"L");$pdf->Cell(40,4,"$fir_fem1","$rmc",1,"L");

//ZAMESTNANCI
//vytlac prilohu
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE konx = 0 AND xdrv = $cislo_zdrv ORDER BY konx,rdc";

$ip=0;
while ($ip <= 1 )
    {
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,$ip))
  {
  $hlavicka=mysql_fetch_object($sqldok);

//pocitane dni
$dsqltd = "TRUNCATE TABLE F$kli_vxcf"."_mzdprcneod$kli_uzid ";
$dsqld = mysql_query("$dsqltd");

$dsqltd = "INSERT INTO F$kli_vxcf"."_mzdprcneod$kli_uzid "." SELECT oc,dan,dav,'$pocetdnia',0 FROM F$kli_vxcf"."_$mzdkun WHERE oc = $hlavicka->oc ";
$dsqld = mysql_query("$dsqltd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET celk_dni=TO_DAYS('$posldena')-TO_DAYS(den_prvy)+1 ".
" WHERE oc >= 0 AND den_prvy >= '$prvydena' AND den_prvy <= '$posldena' AND ( den_posl = '0000-00-00' OR den_posl > '$posldena' )";
$oznacd = mysql_query("$sqtozd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET celk_dni=TO_DAYS(den_posl)-TO_DAYS('$prvydena')+1 ".
" WHERE oc >= 0 AND den_prvy < '$prvydena' AND den_posl < '$posldena' AND den_posl >= '$prvydena' ";
$oznacd = mysql_query("$sqtozd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET celk_dni=TO_DAYS(den_posl)-TO_DAYS(den_prvy)+1 ".
" WHERE oc >= 0 AND den_prvy >= '$prvydena' AND den_posl <= '$posldena' AND den_posl >= '$prvydena' ";
$oznacd = mysql_query("$sqtozd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid SET celk_dni='$pocetdnia' WHERE celk_dni > '$pocetdnia' OR celk_dni < 0 ";
$oznacd = mysql_query("$sqtozd");

$dnipocitane=$pocetdnia;
$sqldokd = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprcneod$kli_uzid WHERE oc = $hlavicka->oc ");
  if (@$zaznam=mysql_data_seek($sqldokd,0))
  {
  $riaddokd=mysql_fetch_object($sqldokd);
  $dnipocitane=1*$riaddokd->celk_dni;
  }


$porcislo=1;
if ( $ip == 0 ) $pdf->SetY(226);
if ( $ip == 1 ) $pdf->SetY(232);

$cislopoistenca=$hlavicka->rdc." ".$hlavicka->rdk;

//ak zahranicny vo vszp daj cislo do doplnujucich udajov
$cislozp=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $hlavicka->oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislozp=1*$riaddok->cszp;
  }
if ( $cislozp > 0 ) { $cislopoistenca=$cislozp; }
$pdf->Cell(21,5," ","$rmc1",0,"R");$pdf->Cell(20,5,"$cislopoistenca","$rmc",0,"C");

if ( $hlavicka->znizp == 0 )
{
$pdf->Cell(8,5,"$dnipocitane","$rmc",0,"C");
$pdf->Cell(13,5,"$hlavicka->zcel_zp","$rmc",0,"R");
$pdf->Cell(12,5,"$hlavicka->zcel_odp","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->zcel_inp","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->zodp_zp","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->zzam_zp","$rmc",0,"R");
$pdf->Cell(12,5,"$fir_zp","$rmc",0,"C");$pdf->Cell(13,5,"$zam_zp","$rmc",0,"C");
$pdf->Cell(13,5,"$hlavicka->ofir_zp","$rmc",0,"R");$pdf->Cell(12,5,"$hlavicka->ozam_zp","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->ofir_gf","$rmc",1,"R");
}
if ( $hlavicka->znizp != 0 )
{
$pdf->Cell(8,5,"$dnipocitane","$rmc",0,"C");
$pdf->Cell(13,5,"$hlavicka->zcel_zpn","$rmc",0,"R");
$pdf->Cell(12,5,"$hlavicka->zcel_odp","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->zcel_inp","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->zodp_zp","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->zzam_np","$rmc",0,"R");
$pdf->Cell(12,5,"$fir_zpn","$rmc",0,"C");$pdf->Cell(13,5,"$zam_zpn","$rmc",0,"C");
$pdf->Cell(13,5,"$hlavicka->ofir_np","$rmc",0,"C");$pdf->Cell(12,5,"$hlavicka->ozam_np","$rmc",0,"C");
$pdf->Cell(13,5,"$hlavicka->ofir_rf","$rmc",1,"R");
}
  }
$ip = $ip + 1;
    }
//koniec prilohy 
     }
//koniec vszp max=1


//union mesacny max2=1
if ( $cislo_zdrv >= 2700 AND $cislo_zdrv <= 2799 AND $max2 == 1 )
     {
$nebolaziadna=0;

if ( File_Exists('../dokumenty/zdravpoist/union2015/mesacny_vykaz_union2015.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/zdravpoist/union2015/mesacny_vykaz_union2015.jpg',0,0,210,297);
}
$pdf->SetY(10);

//kod poistovne
$pdf->Cell(190,18," ","$rmc1",1,"L");
$pdf->Cell(181,5," ","$rmc1",0,"C");$pdf->Cell(10,5,"$cislo_zdrv","$rmc",1,"L");

//cislo platitela
$pdf->Cell(190,3," ","$rmc1",1,"L");
$pdf->Cell(169,5," ","$rmc1",0,"C");$pdf->Cell(22,5,"$platitel","$rmc",1,"R");

//druh vykazu
$pdf->Cell(190,6," ","$rmc1",1,"L");
$akyvyk="N";
if ( $h_oprav == 1 ) $akyvyk="O";
$pdf->Cell(187,5," ","$rmc1",0,"L");$pdf->Cell(4,5,"$akyvyk","$rmc",1,"C");

//za obdobie
$pdf->Cell(190,6," ","$rmc1",1,"L");
$obdobiem=$kli_vmes;
if ( $obdobiem < 10 ) $obdobiem= "0".$obdobiem;
$obdobie=$kli_vrok.$obdobiem;
$pdf->Cell(19,6," ","$rmc1",0,"L");$pdf->Cell(80,6,"$obdobie","$rmc",0,"L");

//den vyplaty
$fir_mzdx06=1*$fir_mzdx06;
if ( $fir_mzdx06 == 0 ) $fir_mzdx06="";
$pdf->Cell(82,5," ","$rmc1",0,"L");$pdf->Cell(10,6,"$fir_mzdx06","$rmc",1,"R");

//PLATITEL
//nazov
$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->Cell(20,6," ","$rmc1",0,"L");$pdf->Cell(131,10,"$fir_fnaz","$rmc",0,"L");
//pravna forma
$pravnaforma="PO";
if ( $fir_uctt03 == 999 ) { $pravnaforma="FO"; }
$pdf->Cell(10,6," ","$rmc1",0,"L");$pdf->Cell(30,10,"$pravnaforma","$rmc",1,"R");

//rodne
$pdf->Cell(190,4," ","$rmc1",1,"L");
$A=substr($fordc,0,1);
$B=substr($fordc,1,1);
$C=substr($fordc,2,1);
$D=substr($fordc,3,1);
$E=substr($fordc,4,1);
$F=substr($fordc,5,1);
$G=substr($fordc,6,1);
$H=substr($fordc,7,1);
$I=substr($fordc,8,1);
$J=substr($fordc,9,1);
$pdf->Cell(47,5,"$fordc","$rmc",0,"C");$pdf->Cell(53,5," ","$rmc1",0,"C");

//dic
$pdf->Cell(51,5,"$fir_fdic","$rmc",0,"C");
//ico
$text=$fir_fico;
if ( $fir_fico < 1000000 ) { $text="00".$fir_fico; }
$pdf->Cell(42,5,"$fir_fico","$rmc",1,"C");

//obec
$pdf->Cell(190,4," ","$rmc1",1,"L");
$pdf->Cell(22,6," ","$rmc1",0,"L");$pdf->Cell(77,7,"$fir_fmes","$rmc",0,"L");
$pdf->Cell(8,6," ","$rmc1",0,"L");$pdf->Cell(86,7,"$fir_fuli","$rmc",1,"L");
//cislo
$pdf->Cell(190,0," ","$rmc1",1,"L");
$pdf->Cell(31,5," ","$rmc1",0,"L");$pdf->Cell(25,8,"$fir_fcdm","$rmc",0,"L");
$pdf->Cell(21,5," ","$rmc1",0,"L");$pdf->Cell(22,8," ","$rmc",0,"L");
//psc
$pdf->Cell(7,5," ","$rmc1",0,"L");$pdf->Cell(24,8,"$fir_fpsc","$rmc",0,"L");
//stat
$stat="";
$pdf->Cell(6,5," ","$rmc1",0,"R");$pdf->Cell(58,8,"$stat","$rmc",1,"L");

//celkovy pocet poistenych vo vsetkych ZP
$pocetpoistenychcelkom=0;
$sqldokx = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume AND zdrv > 0 AND zpnie = 0 ";
$sqlx = mysql_query("$sqldokx");
$pocetpoistenychcelkom=1*mysql_num_rows($sqlx);
if ( $pocetpoistenychcelkom == 0 ) { $pocetpoistenychcelkom=$hlavicka->pzam_celk; }

$poistenychvzp=$hlavicka->pzam_celk;
$platia=$hlavicka->pzam_zp;
$platiazpn=$hlavicka->pzam_zpn;
if ( $agrostav >= 0 )
{ 
$sqlttxx = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 0 AND xdrv = $cislo_zdrv ORDER BY konx ";
$sqlxx = mysql_query("$sqlttxx");
$polxx = mysql_num_rows($sqlxx);

$poistenychvzp=$polxx;

$sqlttxx = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 0 AND xdrv = $cislo_zdrv AND znizp = 0 AND ( ozam_zp > 0 OR ofir_zp > 0 ) ORDER BY konx ";
$sqlxx = mysql_query("$sqlttxx");
$polxx = mysql_num_rows($sqlxx);

$platia=$polxx;

$sqlttxx = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 0 AND xdrv = $cislo_zdrv AND znizp > 0 AND ( ozam_np > 0 OR ofir_np > 0 ) ORDER BY konx ";
$sqlxx = mysql_query("$sqlttxx");
$polxx = mysql_num_rows($sqlxx);

$platiazpn=$polxx;
}

//PREDDAVKY
//riadky 1 a 1a
$pdf->Cell(190,7," ","$rmc1",1,"L");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,6,"$poistenychvzp","$rmc",1,"R");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,6,"$pocetpoistenychcelkom","$rmc",1,"R");
//riadky 2 az 8
$pdf->Cell(190,5," ","$rmc1",1,"L");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,6,"$platia","$rmc",1,"R");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,6,"$hlavicka->pdni_zp","$rmc",1,"R");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,6,"$hlavicka->zcel_zp","$rmc",1,"R");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,6,"$hlavicka->zzam_zp","$rmc",1,"R");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,5,"$hlavicka->ofir_zp","$rmc",1,"R");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,5,"$hlavicka->ozam_zp","$rmc",1,"R");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,6,"$hlavicka->ofir_gf","$rmc",1,"R");
//riadky 9 az 16
$pdf->Cell(190,5," ","$rmc1",1,"L");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,6,"$platiazpn","$rmc",1,"R");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,6,"$hlavicka->pdni_zpn","$rmc",1,"R");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,5,"$hlavicka->zcel_zpn","$rmc",1,"R");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,6,"$hlavicka->zzam_np","$rmc",1,"R");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,5,"$hlavicka->ofir_np","$rmc",1,"R");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,6,"$hlavicka->ozam_np","$rmc",1,"R");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,6,"$hlavicka->ofir_rf","$rmc",1,"R");
$pdf->Cell(99,5," ","$rmc1",0,"L");$pdf->Cell(90,6,"$hlavicka->celk_spolu","$rmc",1,"R");

//VYPLNIL
$pdf->Cell(190,4," ","$rmc1",1,"L");
$pdf->Cell(7,4," ","$rmc1",0,"L");$pdf->Cell(33,5,"$fir_mzdt05","$rmc",0,"L");
$pdf->Cell(11,4," ","$rmc1",0,"L");$pdf->Cell(41,5,"$fir_mzdt04","$rmc",0,"L");
$pdf->Cell(7,4," ","$rmc1",0,"L");$pdf->Cell(41,5,"$fir_ffax","$rmc",0,"L");
$pdf->Cell(9,4," ","$rmc1",0,"L");$pdf->Cell(44,5,"$fir_fem1","$rmc",1,"L");

//ZAMESTNANCI
//vytlac prilohu 
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE konx = 0 AND xdrv = $cislo_zdrv ORDER BY konx,rdc";

$ip=0;
while ($ip <= 1 )
    {
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,$ip))
  {
  $hlavicka=mysql_fetch_object($sqldok);

//pocitane dni
$dsqltd = "TRUNCATE TABLE F$kli_vxcf"."_mzdprcneod$kli_uzid ";
$dsqld = mysql_query("$dsqltd");

$dsqltd = "INSERT INTO F$kli_vxcf"."_mzdprcneod$kli_uzid "." SELECT oc,dan,dav,'$pocetdnia',0 FROM F$kli_vxcf"."_$mzdkun WHERE oc = $hlavicka->oc ";
$dsqld = mysql_query("$dsqltd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET celk_dni=TO_DAYS('$posldena')-TO_DAYS(den_prvy)+1 ".
" WHERE oc >= 0 AND den_prvy >= '$prvydena' AND den_prvy <= '$posldena' AND ( den_posl = '0000-00-00' OR den_posl > '$posldena' )";
$oznacd = mysql_query("$sqtozd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET celk_dni=TO_DAYS(den_posl)-TO_DAYS('$prvydena')+1 ".
" WHERE oc >= 0 AND den_prvy < '$prvydena' AND den_posl < '$posldena' AND den_posl >= '$prvydena' ";
$oznacd = mysql_query("$sqtozd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET celk_dni=TO_DAYS(den_posl)-TO_DAYS(den_prvy)+1 ".
" WHERE oc >= 0 AND den_prvy >= '$prvydena' AND den_posl <= '$posldena' AND den_posl >= '$prvydena' ";
$oznacd = mysql_query("$sqtozd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid SET celk_dni='$pocetdnia' WHERE celk_dni > '$pocetdnia' OR celk_dni < 0 ";
$oznacd = mysql_query("$sqtozd");

$dnipocitane=$pocetdnia;
$sqldokd = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprcneod$kli_uzid WHERE oc = $hlavicka->oc ");
  if (@$zaznam=mysql_data_seek($sqldokd,0))
  {
  $riaddokd=mysql_fetch_object($sqldokd);
  $dnipocitane=1*$riaddokd->celk_dni;
  }

$porcislo=1;
if ( $ip == 0 ) $pdf->SetY(256);
if ( $ip == 1 ) $pdf->SetY(263);

$cislopoistenca=$hlavicka->rdc." ".$hlavicka->rdk;

//ak zahranicny v dovere daj cislo do doplnujucich udajov
$cislozp=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $hlavicka->oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislozp=1*$riaddok->cszp;
  }
if ( $cislozp > 0 ) { $cislopoistenca=$cislozp; }

$pdf->SetFont('arial','',8);
$pdf->Cell(4,5," ","$rmc1",0,"R");
$pdf->Cell(19,6,"$cislopoistenca","$rmc",0,"L");

if ( $hlavicka->znizp == 0 )
{
$pdf->Cell(8,6,"$dnipocitane","$rmc",0,"C");
$pdf->Cell(17,6,"$hlavicka->zcel_zp","$rmc",0,"R");
$pdf->Cell(18,6,"$hlavicka->zcel_odp","$rmc",0,"R");
$pdf->Cell(18,6,"$hlavicka->zcel_inp","$rmc",0,"R");
$pdf->Cell(11,6,"$hlavicka->zodp_zp","$rmc",0,"R");
$pdf->Cell(16,6,"$hlavicka->zzam_zp","$rmc",0,"R");
$pdf->Cell(16,6,"$fir_zp","$rmc",0,"C");$pdf->Cell(16,6,"$zam_zp","$rmc",0,"C");
$pdf->Cell(17,6,"$hlavicka->ofir_zp","$rmc",0,"R");$pdf->Cell(17,6,"$hlavicka->ozam_zp","$rmc",0,"R");
$pdf->Cell(17,6,"$hlavicka->ofir_gf","$rmc",1,"R");
}

if ( $hlavicka->znizp != 0 )
{
$pdf->Cell(8,6,"$dnipocitane","$rmc",0,"C");
$pdf->Cell(17,6,"$hlavicka->zcel_zpn","$rmc",0,"R");
$pdf->Cell(18,6,"$hlavicka->zcel_odp","$rmc",0,"R");
$pdf->Cell(18,6,"$hlavicka->zcel_inp","$rmc",0,"R");
$pdf->Cell(11,6,"$hlavicka->zodp_zp","$rmc",0,"R");
$pdf->Cell(16,6,"$hlavicka->zzam_np","$rmc",0,"R");
$pdf->Cell(16,6,"$fir_zpn","$rmc",0,"C");$pdf->Cell(16,6,"$zam_zpn","$rmc",0,"C");
$pdf->Cell(17,6,"$hlavicka->ofir_np","$rmc",0,"R");$pdf->Cell(17,6,"$hlavicka->ozam_np","$rmc",0,"R");
$pdf->Cell(17,6,"$hlavicka->ofir_rf","$rmc",1,"R");
}
  }
$ip = $ip + 1;
    }
//koniec prilohy 
     }
//koniec union mesacny max2=1


//dovera mesacny max2=1
if ( $cislo_zdrv >= 2300 AND $cislo_zdrv <= 2499 AND $max2 == 1  )
     {
$nebolaziadna=0;

if ( File_Exists('../dokumenty/zdravpoist/dovera2015/mesacny_vykaz_dovera2015.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/zdravpoist/dovera2015/mesacny_vykaz_dovera2015.jpg',0,0,210,297);
}
$pdf->SetY(10);

//kod poistovne
$pdf->Cell(190,6," ","$rmc1",1,"L");
$zdrv22=substr($cislo_zdrv,2,2);
$A=substr($zdrv22,0,1);
$B=substr($zdrv22,1,1);
$pdf->Cell(181,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(5,5,"$B","$rmc",1,"C");

//cislo platitela
$pdf->Cell(190,2," ","$rmc1",1,"L");
$A=substr($platitel,0,1);
$B=substr($platitel,1,1);
$C=substr($platitel,2,1);
$D=substr($platitel,3,1);
$E=substr($platitel,4,1);
$F=substr($platitel,5,1);
$G=substr($platitel,6,1);
$H=substr($platitel,7,1);
$I=substr($platitel,8,1);
$J=substr($platitel,9,1);
$pdf->Cell(141,6," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$A","$rmc",0,"C");$pdf->Cell(5,4,"$B","$rmc",0,"C");$pdf->Cell(5,4,"$C","$rmc",0,"C");
$pdf->Cell(5,4,"$D","$rmc",0,"C");$pdf->Cell(5,4,"$E","$rmc",0,"C");$pdf->Cell(5,4,"$F","$rmc",0,"C");
$pdf->Cell(5,4,"$G","$rmc",0,"C");$pdf->Cell(5,4,"$H","$rmc",0,"C");$pdf->Cell(5,4,"$I","$rmc",0,"C");
$pdf->Cell(5,4,"$J","$rmc",1,"C");

//druh vykazu
$pdf->Cell(190,21," ","$rmc1",1,"L");
$akyvyk="N";
if ( $h_oprav == 1 ) $akyvyk="O";
$pdf->Cell(186,5," ","$rmc1",0,"L");$pdf->Cell(5,5,"$akyvyk","$rmc",1,"C");

//za obdobie
$pdf->Cell(190,1," ","$rmc1",1,"L");
$obdobiem=$kli_vmes;
if ( $obdobiem < 10 ) $obdobiem= "0".$obdobiem;
$obdobie=$kli_vrok.$obdobiem;
$pdf->Cell(16,6," ","$rmc1",0,"L");$pdf->Cell(70,6,"$obdobie","$rmc",0,"L");

//den vyplaty
$fir_mzdx06=1*$fir_mzdx06;
if ( $fir_mzdx06 == 0 ) $fir_mzdx06="";
$A=substr($fir_mzdx06,0,1);
$B=substr($fir_mzdx06,1,1);
$pdf->Cell(42,5," ","$rmc1",0,"L");$pdf->Cell(10,6,"$fir_mzdx06","$rmc",1,"L");

//PLATITEL
//nazov a forma
$pdf->Cell(190,15," ","$rmc1",1,"L");
$pdf->Cell(25,6," ","$rmc1",0,"L");$pdf->Cell(117,5,"$fir_fnaz","$rmc",0,"L");
$pravnaforma="PO";
if( $fir_uctt03 == 999 ) { $pravnaforma="FO"; }
$pdf->Cell(15,6," ","$rmc1",0,"L");$pdf->Cell(34,5,"$pravnaforma","$rmc",1,"L");
//rodne
$pdf->Cell(190,11," ","$rmc1",1,"L");
$A=substr($fordc,0,1);
$B=substr($fordc,1,1);
$C=substr($fordc,2,1);
$D=substr($fordc,3,1);
$E=substr($fordc,4,1);
$F=substr($fordc,5,1);
$G=substr($fordc,6,1);
$H=substr($fordc,7,1);
$I=substr($fordc,8,1);
$J=substr($fordc,9,1);
$pdf->Cell(4,5,"$A","$rmc",0,"L");$pdf->Cell(5,5,"$B","$rmc",0,"C");$pdf->Cell(5,5,"$C","$rmc",0,"C");
$pdf->Cell(5,5,"$D","$rmc",0,"C");$pdf->Cell(5,5,"$E","$rmc",0,"C");$pdf->Cell(5,5,"$F","$rmc",0,"C");
$pdf->Cell(5,5,"$G","$rmc",0,"C");$pdf->Cell(5,5,"$H","$rmc",0,"C");$pdf->Cell(5,5,"$I","$rmc",0,"C");
$pdf->Cell(5,5,"$J","$rmc",0,"C");
//dic
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(39,5," ","$rmc1",0,"L");
$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(6,5,"$C","$rmc",0,"C");
$pdf->Cell(5,5,"$D","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(5,5,"$F","$rmc",0,"C");
$pdf->Cell(6,5,"$G","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(5,5,"$I","$rmc",0,"C");
$pdf->Cell(6,5,"$J","$rmc",0,"C");$pdf->Cell(5,5," ","$rmc",0,"C");$pdf->Cell(5,5," ","$rmc",0,"C");
//ico
$text=$fir_fico;
if ( $fir_fico < 1000000 ) { $text="00".$fir_fico; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$pdf->Cell(3,5," ","$rmc1",0,"L");
$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(5,5,"$B","$rmc",0,"C");$pdf->Cell(5,5,"$C","$rmc",0,"C");
$pdf->Cell(5,5,"$D","$rmc",0,"C");$pdf->Cell(5,5,"$E","$rmc",0,"C");$pdf->Cell(5,5,"$F","$rmc",0,"C");
$pdf->Cell(5,5,"$G","$rmc",0,"C");$pdf->Cell(5,5,"$H","$rmc",1,"C");

//obec
$pdf->Cell(190,7," ","$rmc1",1,"L");
$pdf->Cell(8,6," ","$rmc1",0,"L");$pdf->Cell(85,6,"$fir_fmes","$rmc",0,"L");
$pdf->Cell(12,6," ","$rmc1",0,"L");$pdf->Cell(86,7,"$fir_fuli","$rmc",1,"L");
//cislo
$pdf->Cell(190,0," ","$rmc1",1,"L");
$pdf->Cell(17,5," ","$rmc1",0,"L");$pdf->Cell(30,5,"$fir_fcdm","$rmc",0,"L");
$pdf->Cell(25,5," ","$rmc1",0,"L");$pdf->Cell(30,6," ","$rmc",0,"L");
//psc
$A=substr($fir_fpsc,0,1);
$B=substr($fir_fpsc,1,1);
$C=substr($fir_fpsc,2,1);
$D=substr($fir_fpsc,3,1);
$E=substr($fir_fpsc,4,1);
$pdf->Cell(9,5," ","$rmc1",0,"L");
$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");
$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");

//stat
$stat="";
$pdf->Cell(9,5," ","$rmc1",0,"R");$pdf->Cell(46,6,"$stat","$rmc",1,"L");

//celkovy pocet poistenych vo vsetkych ZP
$pocetpoistenychcelkom=0;
$sqldokx = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume AND zdrv > 0 AND zpnie = 0 ";
$sqlx = mysql_query("$sqldokx");
$pocetpoistenychcelkom=1*mysql_num_rows($sqlx);
if ( $pocetpoistenychcelkom == 0 ) { $pocetpoistenychcelkom=$hlavicka->pzam_celk; }

$poistenychvzp=$hlavicka->pzam_celk;
$platia=$hlavicka->pzam_zp;
$platiazpn=$hlavicka->pzam_zpn;
if ( $agrostav >= 0 )
{ 
$sqlttxx = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 0 AND xdrv = $cislo_zdrv ORDER BY konx ";
$sqlxx = mysql_query("$sqlttxx");
$polxx = mysql_num_rows($sqlxx);

$poistenychvzp=$polxx;

$sqlttxx = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 0 AND xdrv = $cislo_zdrv AND znizp = 0 AND ( ozam_zp > 0 OR ofir_zp > 0 ) ORDER BY konx ";
$sqlxx = mysql_query("$sqlttxx");
$polxx = mysql_num_rows($sqlxx);

$platia=$polxx;

$sqlttxx = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 0 AND xdrv = $cislo_zdrv AND znizp > 0 AND ( ozam_np > 0 OR ofir_np > 0 ) ORDER BY konx ";
$sqlxx = mysql_query("$sqlttxx");
$polxx = mysql_num_rows($sqlxx);

$platiazpn=$polxx;
}

//PREDDAVKY
//riadky 1 a 1a
$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->Cell(141,5," ","$rmc1",0,"L");$pdf->Cell(47,5,"$poistenychvzp","$rmc",1,"R");
$pdf->Cell(141,5," ","$rmc1",0,"L");$pdf->Cell(47,5,"$pocetpoistenychcelkom","$rmc",1,"R");
//riadky 2 az 8
$pdf->Cell(190,5," ","$rmc1",1,"L");
$pdf->Cell(141,5," ","$rmc1",0,"L");$pdf->Cell(47,5,"$platia","$rmc",1,"R");
$pdf->Cell(141,5," ","$rmc1",0,"L");$pdf->Cell(47,5,"$hlavicka->pdni_zp","$rmc",1,"R");
$pdf->Cell(141,5," ","$rmc1",0,"L");$pdf->Cell(47,5,"$hlavicka->zcel_zp","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,5,"$hlavicka->zzam_zp","$rmc",1,"R");
$pdf->Cell(141,7," ","$rmc1",0,"L");$pdf->Cell(47,5,"$hlavicka->ofir_zp","$rmc",1,"R");
$pdf->Cell(141,5," ","$rmc1",0,"L");$pdf->Cell(47,5,"$hlavicka->ozam_zp","$rmc",1,"R");
$pdf->Cell(141,5," ","$rmc1",0,"L");$pdf->Cell(47,5,"$hlavicka->ofir_gf","$rmc",1,"R");
//riadky 9 az 16
$pdf->Cell(190,5," ","$rmc1",1,"L");
$pdf->Cell(141,5," ","$rmc1",0,"L");$pdf->Cell(47,5,"$platiazpn","$rmc",1,"R");
$pdf->Cell(141,5," ","$rmc1",0,"L");$pdf->Cell(47,5,"$hlavicka->pdni_zpn","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,5,"$hlavicka->zcel_zpn","$rmc",1,"R");
$pdf->Cell(141,5," ","$rmc1",0,"L");$pdf->Cell(47,5,"$hlavicka->zzam_np","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,5,"$hlavicka->ofir_np","$rmc",1,"R");
$pdf->Cell(141,5," ","$rmc1",0,"L");$pdf->Cell(47,5,"$hlavicka->ozam_np","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,5,"$hlavicka->ofir_rf","$rmc",1,"R");
$pdf->Cell(141,5," ","$rmc1",0,"L");$pdf->Cell(47,5,"$hlavicka->celk_spolu","$rmc",1,"R");
$pdf->SetFont('arial','',8);

//VYPLNIL
$pdf->Cell(190,3," ","$rmc1",1,"L");
$pdf->Cell(9,4," ","$rmc1",0,"L");$pdf->Cell(45,4,"$fir_mzdt05","$rmc",0,"L");
$pdf->Cell(13,4," ","$rmc1",0,"L");$pdf->Cell(30,4,"$fir_mzdt04","$rmc",0,"L");
$pdf->Cell(8,4," ","$rmc1",0,"L");$pdf->Cell(30,4,"$fir_ffax","$rmc",0,"L");
$pdf->Cell(11,4," ","$rmc1",0,"L");$pdf->Cell(45,4,"$fir_fem1","$rmc",1,"L");
$pdf->SetFont('arial','',9);

//ZAMESTNANCI
//vytlac prilohu
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE konx = 0 AND xdrv = $cislo_zdrv ORDER BY konx,rdc";

$ip=0;
while ($ip <= 1 )
    {
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,$ip))
  {
  $hlavicka=mysql_fetch_object($sqldok);

//pocitane dni
$dsqltd = "TRUNCATE TABLE F$kli_vxcf"."_mzdprcneod$kli_uzid ";
$dsqld = mysql_query("$dsqltd");

$dsqltd = "INSERT INTO F$kli_vxcf"."_mzdprcneod$kli_uzid "." SELECT oc,dan,dav,'$pocetdnia',0 FROM F$kli_vxcf"."_$mzdkun WHERE oc = $hlavicka->oc ";
$dsqld = mysql_query("$dsqltd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET celk_dni=TO_DAYS('$posldena')-TO_DAYS(den_prvy)+1 ".
" WHERE oc >= 0 AND den_prvy >= '$prvydena' AND den_prvy <= '$posldena' AND ( den_posl = '0000-00-00' OR den_posl > '$posldena' )";
$oznacd = mysql_query("$sqtozd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET celk_dni=TO_DAYS(den_posl)-TO_DAYS('$prvydena')+1 ".
" WHERE oc >= 0 AND den_prvy < '$prvydena' AND den_posl < '$posldena' AND den_posl >= '$prvydena' ";
$oznacd = mysql_query("$sqtozd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET celk_dni=TO_DAYS(den_posl)-TO_DAYS(den_prvy)+1 ".
" WHERE oc >= 0 AND den_prvy >= '$prvydena' AND den_posl <= '$posldena' AND den_posl >= '$prvydena' ";
$oznacd = mysql_query("$sqtozd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid SET celk_dni='$pocetdnia' WHERE celk_dni > '$pocetdnia' OR celk_dni < 0 ";
$oznacd = mysql_query("$sqtozd");

$dnipocitane=$pocetdnia;
$sqldokd = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprcneod$kli_uzid WHERE oc = $hlavicka->oc ");
  if (@$zaznam=mysql_data_seek($sqldokd,0))
  {
  $riaddokd=mysql_fetch_object($sqldokd);
  $dnipocitane=1*$riaddokd->celk_dni;
  }

$porcislo=1;
if ( $ip == 0 ) $pdf->SetY(249);
if ( $ip == 1 ) $pdf->SetY(254);

$cislopoistenca=$hlavicka->rdc." ".$hlavicka->rdk;

//ak zahranicny v dovere daj cislo do doplnujucich udajov
$cislozp=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $hlavicka->oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislozp=1*$riaddok->cszp;
  }
if ( $cislozp > 0 ) { $cislopoistenca=$cislozp; }
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(25,5,"$cislopoistenca","$rmc",0,"L");

if ( $hlavicka->znizp == 0 )
{
$pdf->Cell(10,5,"$dnipocitane","$rmc",0,"C");
$pdf->Cell(15,5,"$hlavicka->zcel_zp","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->zcel_odp","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->zcel_inp","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->zodp_zp","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->zzam_zp","$rmc",0,"R");
$pdf->Cell(15,5,"$fir_zp","$rmc",0,"C");$pdf->Cell(15,5,"$zam_zp","$rmc",0,"C");
$pdf->Cell(15,5,"$hlavicka->ofir_zp","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->ozam_zp","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->ofir_gf","$rmc",1,"R");
}
if ( $hlavicka->znizp != 0 )
{
$pdf->Cell(10,5,"$dnipocitane","$rmc",0,"C");
$pdf->Cell(15,5,"$hlavicka->zcel_zpn","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->zcel_odp","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->zcel_inp","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->zodp_zp","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->zzam_np","$rmc",0,"R");
$pdf->Cell(15,5,"$fir_zpn","$rmc",0,"C");$pdf->Cell(15,5,"$zam_zpn","$rmc",0,"C");
$pdf->Cell(15,5,"$hlavicka->ofir_np","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->ozam_np","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->ofir_rf","$rmc",1,"R");
}
  }
$ip = $ip + 1;
    }
//koniec prilohy 
     }
//koniec dovera max2=1
}
$i = $i + 1;
  }
$pdf->Output("../tmp/vykazZP.$kli_uzid.pdf");
?>

<script type="text/javascript">
 var okno = window.open("../tmp/vykazZP.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA MESACNEHO VYKAZU


/////////////////////////////////////////VYTLAC PRILOHU MESACNEHO VYKAZU 
if ( $copern == 20 )
{
if ( File_Exists("../tmp/prilohaSP.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/prilohaSP.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

/////////////NACITANIE CISLA PLATITELA,NAZVU Z CISELNIKA ZP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv=$cislo_zdrv ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $platitel=$riaddok->vsy;
  $nazzdrv=$riaddok->nzdr;
  }

$prvydena=$kli_vrok."-".$kli_vmes."-01";
$pocetdnia=31;
$sqlttd = "SELECT * FROM kalendar WHERE ume = $kli_vume ";
$sqld = mysql_query("$sqlttd");
$pocetdnia = mysql_num_rows($sqld);
$posldena=$kli_vrok."-".$kli_vmes."-".$pocetdnia;

$sqltd = "DROP TABLE F".$kli_vxcf."_mzdprcneod".$kli_uzid;
$vysledokd = mysql_query("$sqltd");
$sqltdd = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   den_prvy     DATE,
   den_posl     DATE,
   celk_dni     DECIMAL(10,2) DEFAULT 0,
   konnex       DECIMAL(10,2) DEFAULT 0
);
mzdprc;

$vsqld = "CREATE TABLE F".$kli_vxcf."_mzdprcneod".$kli_uzid.$sqltdd;
$vytvord = mysql_query("$vsqld");

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE konx = 0 AND xdrv = $cislo_zdrv ORDER BY konx,rdc";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$nebolaziadna=1;

//vsetky rovnaka priloha
if ( $cislo_zdrv >= 1 AND $cislo_zdrv <= 9999 )
          {
$nebolaziadna=0;


$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(20);
$strana=0;

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


//zaciatok hlavicky
if( $j == 0 )
            {
$strana=$strana+1;

//typ prÌlohy (N,O,A)
$akyvyk="N";
if( $h_oprav == 1 ) $akyvyk="O";
$obdobie=$kli_vume*10000;
if( $obdobie < 102009 ) $obdobie= "0".$obdobie;

$pdf->SetFont('arial','',9);
$pdf->Cell(40,5,"ZP $cislo_zdrv ","0",0,"L");$pdf->Cell(40,5,"Typ v˝kazu $akyvyk","0",0,"L");
$pdf->Cell(40,5,"Obdobie $obdobie","0",0,"L");
$pdf->Cell(0,5,"PrÌloha k mesaËnÈmu v˝kazu preddavkov strana $strana","0",1,"R");

$pdf->Cell(40,5,"Zamestn·vateæ: $fir_fnaz","0",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(8,5,"Ë.","1",0,"R");$pdf->Cell(50,5,"rË, priezvisko meno, osË","1",0,"L");
$pdf->Cell(8,5,"dni","1",0,"R");
$pdf->Cell(15,5,"PrÌjem","1",0,"R");$pdf->Cell(15,5,"Vym.z·klad","1",0,"R");
$pdf->Cell(10,5,"%Ztel","1",0,"R");$pdf->Cell(10,5,"%Znec","1",0,"R");
$pdf->Cell(12,5,"Pr. Ztel","1",0,"R");$pdf->Cell(12,5,"Pr. Znec","1",0,"R");
$pdf->Cell(12,5,"Pr. Spolu","1",0,"R");
$pdf->Cell(12,5,"PrÌj.OP","1",0,"R");$pdf->Cell(12,5,"PrÌj.in˝","1",0,"R");$pdf->Cell(12,5,"OP","1",1,"R");


             }
//koniec hlavicky

//telo polozky

$dsqltd = "TRUNCATE TABLE F$kli_vxcf"."_mzdprcneod$kli_uzid ";
$dsqld = mysql_query("$dsqltd");

$dsqltd = "INSERT INTO F$kli_vxcf"."_mzdprcneod$kli_uzid "." SELECT oc,dan,dav,'$pocetdnia',0 FROM F$kli_vxcf"."_$mzdkun WHERE oc = $hlavicka->oc ";
$dsqld = mysql_query("$dsqltd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET celk_dni=TO_DAYS('$posldena')-TO_DAYS(den_prvy)+1 ".
" WHERE oc >= 0 AND den_prvy >= '$prvydena' AND den_prvy <= '$posldena' AND ( den_posl = '0000-00-00' OR den_posl > '$posldena' )";
$oznacd = mysql_query("$sqtozd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET celk_dni=TO_DAYS(den_posl)-TO_DAYS('$prvydena')+1 ".
" WHERE oc >= 0 AND den_prvy < '$prvydena' AND den_posl < '$posldena' AND den_posl >= '$prvydena' ";
$oznacd = mysql_query("$sqtozd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET celk_dni=TO_DAYS(den_posl)-TO_DAYS(den_prvy)+1 ".
" WHERE oc >= 0 AND den_prvy >= '$prvydena' AND den_posl <= '$posldena' AND den_posl >= '$prvydena' ";
$oznacd = mysql_query("$sqtozd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid SET celk_dni='$pocetdnia' WHERE celk_dni > '$pocetdnia' OR celk_dni < 0 ";
$oznacd = mysql_query("$sqtozd");

$dnipocitane=$pocetdnia;
$sqldokd = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprcneod$kli_uzid WHERE oc = $hlavicka->oc ");
  if (@$zaznam=mysql_data_seek($sqldokd,0))
  {
  $riaddokd=mysql_fetch_object($sqldokd);
  $dnipocitane=1*$riaddokd->celk_dni;
  }


$porcislo=$i+1;
$pdf->SetFont('arial','',8);

$cislopoistenca=$hlavicka->rdc." ".$hlavicka->rdk;

//ak zahranicny vo vszp daj cislo do doplnujucich udajov
$cislozp=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $hlavicka->oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislozp=1*$riaddok->cszp;
  }
if( $cislozp > 0 ) { $cislopoistenca=$cislozp; }

$pdf->Cell(8,5,"$porcislo","0",0,"R");
$pdf->SetFont('arial','',7);
$pdf->Cell(50,5,"$cislopoistenca $hlavicka->prie $hlavicka->meno, $hlavicka->oc","0",0,"L");
$pdf->SetFont('arial','',8);

if( $hlavicka->znizp == 0 )
{

$fir_zptlac=$fir_zp;
$zam_zptlac=$zam_zp;
if( $hlavicka->pom == 14 AND ( $cislo_zdrv < 2400 OR $cislo_zdrv > 2499 ) ) { $fir_zptlac=0; $zam_zptlac=0; }

$pdf->Cell(8,5,"$dnipocitane","0",0,"R");
$pdf->Cell(15,5,"$hlavicka->zcel_zp","0",0,"R");$pdf->Cell(15,5,"$hlavicka->zzam_zp","0",0,"R");
$pdf->Cell(10,5,"$fir_zptlac","0",0,"R");$pdf->Cell(10,5,"$zam_zptlac","0",0,"R");
$pdf->Cell(12,5,"$hlavicka->ofir_zp","0",0,"R");$pdf->Cell(12,5,"$hlavicka->ozam_zp","0",0,"R");
$pdf->Cell(12,5,"$hlavicka->ofir_gf","0",0,"R");
$pdf->Cell(12,5,"$hlavicka->zcel_odp","0",0,"R");$pdf->Cell(12,5,"$hlavicka->zcel_inp","0",0,"R");$pdf->Cell(12,5,"$hlavicka->zodp_zp","0",1,"R");
}

if( $hlavicka->znizp != 0 )
{

$pdf->Cell(8,5,"$dnipocitane","0",0,"R");
$pdf->Cell(15,5,"$hlavicka->zcel_zpn","0",0,"R");$pdf->Cell(15,5,"$hlavicka->zzam_np","0",0,"R");
$pdf->Cell(10,5,"$fir_zpn","0",0,"R");$pdf->Cell(10,5,"$zam_zpn","0",0,"R");
$pdf->Cell(12,5,"$hlavicka->ofir_np","0",0,"R");$pdf->Cell(12,5,"$hlavicka->ozam_np","0",0,"R");
$pdf->Cell(12,5,"$hlavicka->ofir_rf","0",0,"R");
$pdf->Cell(12,5,"$hlavicka->zcel_odp","0",0,"R");$pdf->Cell(12,5,"$hlavicka->zcel_inp","0",0,"R");$pdf->Cell(12,5,"$hlavicka->zodp_zp","0",1,"R");
}


//koniec tela polozky

}
$i = $i + 1;
$j = $j + 1;
if( $j >= 30 ) { $j=0; }


  }


//koniec vsetky rovnaka priloha
          }



$pdf->Output("../tmp/prilohaSP.$kli_uzid.pdf");

?>

<script type="text/javascript">
  var okno = window.open("../tmp/prilohaSP.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php
}
////////////////////////////////////////////////////KONIEC VYTLACENIA PRILOHY MESACNEHO VYKAZU


?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Mesacne vykazy ZP v PDF</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;


function MesacnyVykaz(h_zdrv)
                {
var h_oprav = document.forms.formp1.h_oprav.value;

window.open('../mzdy/vykaz_ZP.php?h_oprav=' + h_oprav + '&copern=10&drupoh=1&page=1&cislo_zdrv=' + h_zdrv + '&tt=1', '_blank', '<?php echo $tlcswin; ?>' )

                }

function MesacnyVykaz2(h_zdrv)
                {
var h_oprav = document.forms.formp1.h_oprav.value;

window.open('../mzdy/vykaz_ZP.php?h_oprav=' + h_oprav + '&copern=10&drupoh=1&page=1&cislo_zdrv=' + h_zdrv + '&tt=1&max2=1', '_blank', '<?php echo $tlcswin; ?>' )

                }


function Priloha(h_zdrv)
                {
var h_oprav = document.forms.formp1.h_oprav.value;

window.open('../mzdy/vykaz_ZP.php?h_oprav=' + h_oprav + '&copern=20&drupoh=1&page=1&cislo_zdrv=' + h_zdrv + '&tt=1', '_blank', '<?php echo $tlcswin; ?>' )

                }

function PrilohaMena(h_zdrv)
                {
var h_oprav = document.forms.formp1.h_oprav.value;

window.open('../mzdy/vykaz_ZP.php?h_oprav=' + h_oprav + '&copern=20&drupoh=1&page=1&cislo_zdrv=' + h_zdrv + '&tt=1&ajmeno=1', '_blank', '<?php echo $tlcswin; ?>' )

                }


function ElektronikaVykaz(h_zdrv)
                {
var h_oprav = document.forms.formp1.h_oprav.value;

window.open('../mzdy/vykaz_ZP.php?h_oprav=' + h_oprav + '&copern=30&drupoh=1&page=1&cislo_zdrv=' + h_zdrv + '&tt=1', '_blank', '<?php echo $tlcswin; ?>' )

                }

    
</script>
</HEAD>
<BODY class="white" id="white" onload="" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  V˝kazy pre ZdravotnÈ poisùovne

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//zakladna ponuka
if( $copern == 1 )
{
?>

<table class="vstup" width="100%" >
<FORM name="formp1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="100%"> 
Druh v˝kazu : 
 <select size="1" name="h_oprav" id="h_oprav" >
<option value="0" >N - Riadny</option>
<option value="1" >O - Opravn˝</option>
</select>
 - v˝ber platÌ pre mesaËn˝ v˝kaz, prÌlohu aj s˙bor pre el.podateæÚu vo vöetk˝ch ZP</td>
</tr>
</FORM>
</table>


<?php
$sqltt = "SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv > 0 ORDER BY zdrv";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

if( $pol > 0 )
         {
$i=0;
  while ( $i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);
?>

<table class="vstup" width="100%" >
<tr>

<td class="bmenu" width="30%">ZP<?php echo $polozka->zdrv; ?> <?php echo $polozka->nzdr; ?></td>
<td class="bmenu" width="20%">
<a href="#" onClick="MesacnyVykaz2(<?php echo $polozka->zdrv; ?>);">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù mesaËn˝ v˝kaz vo form·te PDF' ></a>
MesaËn˝ v˝kaz

</td>

<td class="bmenu" width="20%">
<a href="#" onClick="Priloha(<?php echo $polozka->zdrv; ?>);">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù aj s menom a priezviskom vo form·te PDF' ></a>
PrÌloha
</td>

<td class="bmenu" width="28%">
<a href="#" onClick="ElektronikaVykaz(<?php echo $polozka->zdrv; ?>);">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvoriù vo form·te TXT' ></a>
S˙bor pre elektronick˙ podateæÚu</td>

<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../mzdy/vykaz_zpprerus.php?cislo_oc=9999&copern=101&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0&cislo_zdrv=<?php echo $polozka->zdrv; ?>', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/import.png' width=20 height=15 border=0 title='Vytvorenie el.s˙boru, ˙prava a tlaË PreruöenÌ platenia ZP ( nemoc...)' ></a>
</td>

</tr>
</table>

<?php
}
$i = $i + 1;
$j = $j + 1;
  }

         }
?>



<?php
}
//koniec zakladnej ponuky
?>

<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU PRE ELEKTRONIKU
if( $copern == 30 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="N514".$kli_vxr.$kli_vmes;


if (File_Exists ("../tmp/$nazsub.001")) { $soubor = unlink("../tmp/$nazsub.001"); }

$soubor = fopen("../tmp/$nazsub.001", "a+");

/////////////NACITANIE CISLA PLATITELA,NAZVU Z CISELNIKA ZP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv=$cislo_zdrv ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $platitel=$riaddok->vsy;
  $nazzdrv=$riaddok->nzdr;
  }


//celkovy pocet poistenych vo vsetkych ZP
$pocetpoistenychcelkom=0;
$sqldokx = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume AND zdrv > 0 AND zpnie = 0 ";
$sqlx = mysql_query("$sqldokx");
$pocetpoistenychcelkom=1*mysql_num_rows($sqlx);



//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE konx = 8 AND xdrv = $cislo_zdrv ORDER BY konx";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$konznak="";
$zapnikonznak=1;
if( $zapnikonznak == 1 ) { $konznak="|"; }

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$obdobie=$kli_vmes;

$dat_dat = Date ("Ymd", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 

$akyvyk="N";
if( $h_oprav == 1 ) $akyvyk="O";


$poistenychvzp=$hlavicka->pzam_celk;
$platia=$hlavicka->pzam_zp;
$platiazpn=$hlavicka->pzam_zpn;
if( $agrostav >= 0 ) 
{ 
$sqlttxx = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 0 AND xdrv = $cislo_zdrv ORDER BY konx ";
$sqlxx = mysql_query("$sqlttxx");
$polxx = mysql_num_rows($sqlxx);

$poistenychvzp=$polxx;

$sqlttxx = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 0 AND xdrv = $cislo_zdrv AND znizp = 0 AND ( ozam_zp > 0 OR ofir_zp > 0 ) ORDER BY konx ";
$sqlxx = mysql_query("$sqlttxx");
$polxx = mysql_num_rows($sqlxx);

$platia=$polxx;

$sqlttxx = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 0 AND xdrv = $cislo_zdrv AND znizp > 0 AND ( ozam_np > 0 OR ofir_np > 0 ) ORDER BY konx ";
$sqlxx = mysql_query("$sqlttxx");
$polxx = mysql_num_rows($sqlxx);

$platiazpn=$polxx;
}

$fir_ficox=$fir_fico;
if( $fir_fico < 999999 ) { $fir_ficox="00".$fir_fico; }


  $text = "".$akyvyk."|514|".$fir_ficox."|".$platitel."|".$cislo_zdrv."|".$dat_dat."|1|".$poistenychvzp;
  $text = $text."|1|1".$konznak."\r\n";
  fwrite($soubor, $text);

//den na vyplatu
if( $fir_mzdx06 == 0 ) { $fir_mzdx06=31; }
if( $fir_mzdx06 > 31 ) { $fir_mzdx06=31; }
$denvyplaty=$fir_mzdx06;


if( $denvyplaty == 29 AND $obdobie == 1 ) { $denvyplaty="28"; }
if( $denvyplaty == 30 AND $obdobie == 1 ) { $denvyplaty="28"; }
if( $denvyplaty == 31 AND $obdobie == 1 ) { $denvyplaty="28"; }
if( $denvyplaty == 31 AND $obdobie == 3 ) { $denvyplaty="30"; }
if( $denvyplaty == 31 AND $obdobie == 5 ) { $denvyplaty="30"; }
if( $denvyplaty == 31 AND $obdobie == 8 ) { $denvyplaty="30"; }
if( $denvyplaty == 31 AND $obdobie == 10 ) { $denvyplaty="30"; }
//echo $obdobie;
  $text = $kli_vrok.$obdobie."|$denvyplaty|".$fir_fnaz."|".$fir_ficox."|".$platitel."|".$fir_fdic."|".$fir_ftel."|".$fir_ffax."|".$fir_fem1."|".$fir_fnm1."||".$fir_fuc1;
  

  $text = $text.$konznak."\r\n";
  fwrite($soubor, $text);


  $text = $poistenychvzp."|".$fir_zp."|".$zam_zp."|".$fir_zpn."|".$zam_zpn."|".$platia."|".$platiazpn."|";
  $text = $text.$hlavicka->pdni_zp."|".$hlavicka->pdni_zpn."|".$hlavicka->zcel_zp."|".$hlavicka->zcel_zpn."|";
  $text = $text.$hlavicka->zzam_zp."|".$hlavicka->zzam_np."|".$hlavicka->ofir_zp."|".$hlavicka->ozam_zp."|";
  $text = $text.$hlavicka->ofir_np."|".$hlavicka->ozam_np."|".$hlavicka->celk_spolu;

if( $kli_vrok < 2011 )
   {
  $textkon = "|Poznamka";
   }
if( $kli_vrok == 2011 AND $kli_vmes < 7 )
   {
  $textkon = "|Poznamka";
   }
if( $kli_vrok > 2011 OR ( $kli_vrok == 2011 AND $kli_vmes >= 7 ) )
   {
$pravnaforma="PO";
if( $fir_uctt03 == 999 ) { $pravnaforma="FO"; }
if( $pocetpoistenychcelkom == 0 ) { $pocetpoistenychcelkom=$hlavicka->pzam_celk; }

  $textkon = "|".$pravnaforma."|".$pocetpoistenychcelkom;
   }
if( $kli_vrok > 2007 )
   {
$pravnaforma="PO";
if( $fir_uctt03 == 999 ) { $pravnaforma="FO"; }
if( $pocetpoistenychcelkom == 0 ) { $pocetpoistenychcelkom=$hlavicka->pzam_celk; }

  $textkon = "|".$pravnaforma."|".$pocetpoistenychcelkom;
   }
  $text = $text.$textkon.$konznak."\r\n";
  fwrite($soubor, $text);


}
$i = $i + 1;
$j = $j + 1;
  }

//polozky
$prvydena=$kli_vrok."-".$kli_vmes."-01";
$pocetdnia=31;
$sqlttd = "SELECT * FROM kalendar WHERE ume = $kli_vume ";
$sqld = mysql_query("$sqlttd");
$pocetdnia = mysql_num_rows($sqld);
$posldena=$kli_vrok."-".$kli_vmes."-".$pocetdnia;

$sqltd = "DROP TABLE F".$kli_vxcf."_mzdprcneod".$kli_uzid;
$vysledokd = mysql_query("$sqltd");
$sqltdd = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   den_prvy     DATE,
   den_posl     DATE,
   celk_dni     DECIMAL(10,2) DEFAULT 0,
   konnex       DECIMAL(10,2) DEFAULT 0
);
mzdprc;

$vsqld = "CREATE TABLE F".$kli_vxcf."_mzdprcneod".$kli_uzid.$sqltdd;
$vytvord = mysql_query("$vsqld");


$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE konx = 0 AND xdrv = $cislo_zdrv ORDER BY konx,rdc";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);
$cislo=$i+1;

$dsqltd = "TRUNCATE TABLE F$kli_vxcf"."_mzdprcneod$kli_uzid ";
$dsqld = mysql_query("$dsqltd");

$dsqltd = "INSERT INTO F$kli_vxcf"."_mzdprcneod$kli_uzid "." SELECT oc,dan,dav,'$pocetdnia',0 FROM F$kli_vxcf"."_$mzdkun WHERE oc = $hlavicka->oc ";
$dsqld = mysql_query("$dsqltd");

//$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid SET den_prvy='2015-01-02', den_posl='2015-01-20' ";
//echo $sqtozd;
//$oznacd = mysql_query("$sqtozd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET celk_dni=TO_DAYS('$posldena')-TO_DAYS(den_prvy)+1 ".
" WHERE oc >= 0 AND den_prvy >= '$prvydena' AND den_prvy <= '$posldena' AND ( den_posl = '0000-00-00' OR den_posl > '$posldena' )";
$oznacd = mysql_query("$sqtozd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET celk_dni=TO_DAYS(den_posl)-TO_DAYS('$prvydena')+1 ".
" WHERE oc >= 0 AND den_prvy < '$prvydena' AND den_posl < '$posldena' AND den_posl >= '$prvydena' ";
$oznacd = mysql_query("$sqtozd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid".
" SET celk_dni=TO_DAYS(den_posl)-TO_DAYS(den_prvy)+1 ".
" WHERE oc >= 0 AND den_prvy >= '$prvydena' AND den_posl <= '$posldena' AND den_posl >= '$prvydena' ";
$oznacd = mysql_query("$sqtozd");

$sqtozd = "UPDATE F$kli_vxcf"."_mzdprcneod$kli_uzid SET celk_dni='$pocetdnia' WHERE celk_dni > '$pocetdnia' OR celk_dni < 0 ";
$oznacd = mysql_query("$sqtozd");

$dnipocitane=$pocetdnia;
$sqldokd = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprcneod$kli_uzid WHERE oc = $hlavicka->oc ");
  if (@$zaznam=mysql_data_seek($sqldokd,0))
  {
  $riaddokd=mysql_fetch_object($sqldokd);
  $dnipocitane=1*$riaddokd->celk_dni;
  }

//od dni pocitanych odrataj 502ku
$dni502=0;
if( $cislo_zdrv >= 2400 AND $cislo_zdrv <= 2499 ) 
      {
$sqldokd = mysql_query("SELECT SUM(TO_DAYS(dk)-TO_DAYS(dp)+1) AS dni502 FROM F$kli_vxcf"."_mzdzalmes WHERE dm = 502 AND oc = $hlavicka->oc AND ume = $kli_vume ");
  if (@$zaznam=mysql_data_seek($sqldokd,0))
  {
  $riaddokd=mysql_fetch_object($sqldokd);
  $dni502=1*$riaddokd->dni502;
  }
      }

//ak ma 3 osc pripocitaj dni z druheho osc
$dni2osc=0;
if( $cislo_zdrv >= 2400 AND $cislo_zdrv <= 2499 AND $dnipocitane < $pocetdnia ) 
      {
$sqldokd = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 0 AND oc = $hlavicka->oc AND zzam_rf > 1 ");
    if (@$zaznam=mysql_data_seek($sqldokd,0))
    {
    $riaddokd=mysql_fetch_object($sqldokd);

$sqltto2 = "SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE oc != $riaddokd->oc AND pom != 9 ";
$sqlo2 = mysql_query("$sqltto2");
$polo2 = mysql_num_rows($sqlo2);

$io2=0;
  while ($io2 <= $polo2 )
  {
  if(@$zaznam=mysql_data_seek($sqlo2,$io2))
{
    $riaddokdo2=mysql_fetch_object($sqlo2);

       if( $hlavicka->rdc.$hlavicka->rdk == $riaddokdo2->rdc.$riaddokdo2->rdk )
       {
       //echo "idem ".$riaddokdo2->oc."<br />";

$sqldokd = mysql_query("SELECT SUM(TO_DAYS('$posldena')-TO_DAYS(dan)+1) AS dni2osc FROM F$kli_vxcf"."_$mzdkun WHERE oc = $riaddokdo2->oc AND dan >= '$prvydena' ");
  if (@$zaznam=mysql_data_seek($sqldokd,0))
  {
  $riaddokd=mysql_fetch_object($sqldokd);
  $dni2osc=1*$riaddokd->dni2osc;
  //echo "dni2osc ".$dni2osc."<br />";
  }


       }

}
$io2=$io2+1;
  }


    }
      }
//koniec ak ma 3 osc pripocitaj dni z druheho osc
//exit;

$dnipocitane=$dnipocitane-$dni502+$dni2osc;
if( $dnipocitane > $pocetdnia ) { $dnipocitane=$pocetdnia; }

$cislopoistenca=$hlavicka->rdc.$hlavicka->rdk;

//ak zahranicny vo vszp,dovera,union daj cislo do doplnujucich udajov
if( $cislo_zdrv >= 2400 AND $cislo_zdrv <= 2799 ) 
      {
$cislozp=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $hlavicka->oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislozp=1*$riaddok->cszp;
  }
if( $cislozp > 0 ) { $cislopoistenca=$cislozp; }
      }

  $text = $cislo."|".$cislopoistenca."|";

//struktura vety od 1.2.2015
//1.	PoradovÈ ËÌslo	P	INT	6
//2.	RodnÈ ËÌslo zamestnanca	P	INT	10
//3.	PoËet dnÌ	P	INT	2
//4.	Sadzba preddavkov ñ zamestn·vateæ	P	DEC	4, 2
//5.	Sadzba preddavkov ñ zamestnanec	P	DEC	4, 2
//6.	Celkov· v˝öka prÌjmu zamestnanca	P	DEC	12, 2
//7.	VymeriavacÌ z·klad zamestnanca	P	DEC	12, 2
//8.	Preddavok zamestn·vateæ 	P	DEC 	12,2
//9.	Preddavok zamestnanec	P	DEC	12, 2
//10.	Preddavok spolu	P	DEC	12, 2
//11.	Celkov· v˝öka prÌjmu zamestnanca pre uplatnenie odpoËÌtateænej poloûky 	P	DEC	12, 2
//12. 	Celkov· v˝öka ÔalöÌch prÌjmov zamestnanca	P	DEC	12, 2
//13.	OdpoËÌtateæn· poloûka	P	DEC	12, 2



if( $hlavicka->znizp == 0 )
{

$fir_zptlac=$fir_zp;
$zam_zptlac=$zam_zp;
if( $hlavicka->pom == 14 AND ( $cislo_zdrv < 2400 OR $cislo_zdrv > 2499 ) ) { $fir_zptlac=0; $zam_zptlac=0; }

  $text = $text.$dnipocitane."|".$fir_zptlac."|".$zam_zptlac."|".$hlavicka->zcel_zp."|".$hlavicka->zzam_zp."|";
  $text = $text.$hlavicka->ofir_zp."|".$hlavicka->ozam_zp."|".$hlavicka->celk_spolu;
  $text = $text."|".$hlavicka->zcel_odp."|".$hlavicka->zcel_inp."|".$hlavicka->zodp_zp.$konznak."\r\n";

  fwrite($soubor, $text);
}


if( $hlavicka->znizp != 0 )
{
  $text = $text.$dnipocitane."|".$fir_zpn."|".$zam_zpn."|".$hlavicka->zcel_zpn."|".$hlavicka->zzam_np."|";
  $text = $text.$hlavicka->ofir_np."|".$hlavicka->ozam_np."|".$hlavicka->celk_spolu;
  $text = $text."|".$hlavicka->zcel_odp."|".$hlavicka->zcel_inp."|".$hlavicka->zodp_zp.$konznak."\r\n";

  fwrite($soubor, $text);
}




}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.001">../tmp/<?php echo $nazsub; ?>.001</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalmesx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzaltrnx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalkunx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

}
///////////////////////////////////////////////////KONIEC SUBORU PRE ELEKTRONIKU

?>
<?php
// celkovy koniec dokumentu
$zmenume=1; $odkaz="../mzdy/vykaz_ZP.php?&copern=1&page=1&ostre=0";
$cislista = include("mzd_lista.php");

       } while (false);
?>
</BODY>
</HTML>
