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

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

if( $kli_vrok < 2010 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vykaz_ZP2009.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&cislo_zdrv=<?php echo $cislo_zdrv; ?>
&tis=<?php echo $tis; ?>&fort=<?php echo $fort; ?>","_self");
</script>
<?php
exit;
}
if( $kli_vrok < 2013 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vykaz_ZP2012.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&cislo_zdrv=<?php echo $cislo_zdrv; ?>
&tis=<?php echo $tis; ?>&fort=<?php echo $fort; ?>","_self");
</script>
<?php
exit;
}
if( $kli_vrok < 2014 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/vykaz_ZP2013.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&cislo_zdrv=<?php echo $cislo_zdrv; ?>
&tis=<?php echo $tis; ?>&fort=<?php echo $fort; ?>&h_oprav=<?php echo $h_oprav; ?>","_self");
</script>
<?php
exit;
}

if( $copern == 1 )
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
if (File_Exists ("../tmp/mzdpasky$kli_uzid.pdf")) { $soubor = unlink("../tmp/mzdpasky$kli_uzid.pdf"); }
if (File_Exists ("../tmp/mzdzos.$kli_uzid.pdf")) { $soubor = unlink("../tmp/mzdzos.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/mzdvyp.$kli_uzid.pdf")) { $soubor = unlink("../tmp/mzdvyp.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/priemery.$kli_uzid.pdf")) { $soubor = unlink("../tmp/priemery.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/prilohaSP.$kli_uzid.pdf")) { $soubor = unlink("../tmp/prilohaSP.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/vykazSP.$kli_uzid.pdf")) { $soubor = unlink("../tmp/vykazSP.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/vykazZP.$kli_uzid.pdf")) { $soubor = unlink("../tmp/vykazZP.$kli_uzid.pdf"); }

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
if( $copern == 10 OR $copern == 20 OR $copern == 30 )
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
   konx2        DECIMAL(10,0) DEFAULT 0
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
"0".
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
"0".
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
"888".
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
"0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0 AND xdrv > 0 ".
" GROUP BY rodne";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

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
"999".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY oc";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid." WHERE konx2 != 999 ";
$dsql = mysql_query("$dsqlt");

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

$sqlttx = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET zcel_zp=0 WHERE zzam_zp = 0 AND ozam_zp = 0 AND ofir_zp = 0 AND oc = $hlavicka->oc AND konx2 = 999 ";
$sqlx = mysql_query("$sqlttx");
//echo $sqlttx;
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
"0".
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
"0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY xdrv";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

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
"0 ".
" FROM F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" WHERE oc >= 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


}
//koniec pracovneho suboru 

/////////////NACITANIE UDAJOV Z PARAMETROV
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
if( $copern == 10 )
{

if (File_Exists ("../tmp/vykazZP.$kli_uzid.pdf")) { $soubor = unlink("../tmp/vykazZP.$kli_uzid.pdf"); }

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

/////////////NACITANIE CISLA PLATITELA,NAZVU Z CISELNIKA ZP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv=$cislo_zdrv ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $platitel=$riaddok->vsy;
  $nazzdrv=$riaddok->nzdr;
  }

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(20);

$nebolaziadna=1;
//vseobecna zdravotna mesacny max2=0
if ( $cislo_zdrv >= 2500 AND $cislo_zdrv <= 2599 AND $max2 == 0 )
          {
$nebolaziadna=0;

if (File_Exists ('../dokumenty/zdravpoist/zp2508/mesacny_vykaz.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/zdravpoist/zp2508/mesacny_vykaz.jpg',0,0,210,094); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',12);
$obdobie=$kli_vume*10000;
if( $obdobie < 102009 ) $obdobie= "0".$obdobie;

$zdrv22=substr($cislo_zdrv,2,2);

$pdf->Cell(190,7,"                          ","0",1,"L");
$A=substr($zdrv22,0,1);
$B=substr($zdrv22,1,1);
$pdf->Cell(171,5," ","0",0,"C");$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(3,6,"$B","0",1,"R");
$pdf->Cell(190,11,"                          ","0",1,"L");
//typ v˝kazu (N,O,A)
$pdf->Cell(142,4," ","0",0,"L");$pdf->Cell(6,5," ","0",1,"L");
$pdf->Cell(190,4,"                          ","0",1,"L");
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
$pdf->Cell(142,6," ","0",0,"L");$pdf->Cell(4,6,"$A","0",0,"L");$pdf->Cell(4,6,"$B","0",0,"L");$pdf->Cell(3,6,"$C","0",0,"C");
$pdf->Cell(4,6,"$D","0",0,"L");$pdf->Cell(4,6,"$E","0",0,"C");$pdf->Cell(3,6,"$F","0",0,"C");$pdf->Cell(4,6,"$G","0",0,"L");
$pdf->Cell(4,6,"$H","0",0,"C");$pdf->Cell(3,6,"$I","0",0,"C");$pdf->Cell(4,6,"$J","0",1,"L");
$pdf->Cell(190,2,"                          ","0",1,"L");
$pdf->Cell(30,6," ","0",0,"L");$pdf->Cell(60,6,"$obdobie","0",0,"L");$pdf->Cell(58,6," ","0",0,"L");$pdf->Cell(31,6," ","0",1,"L");
$pdf->Cell(190,8,"                          ","0",1,"L");
$pdf->Cell(36,6," ","0",0,"L");$pdf->Cell(90,6,"$fir_fnaz","0",0,"L");$pdf->Cell(19,6," ","0",0,"L");$pdf->Cell(34,6," ","0",1,"L");

$pdf->Cell(190,8,"                          ","0",1,"L");
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
$pdf->Cell(15,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(3,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");
$pdf->Cell(4,5,"$D","0",0,"C");$pdf->Cell(3,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"L");$pdf->Cell(4,5,"$G","0",0,"C");
$pdf->Cell(3,5,"$H","0",0,"C");$pdf->Cell(4,5,"$I","0",0,"C");$pdf->Cell(3,5,"$J","0",0,"C");$pdf->Cell(49,5," ","0",0,"L");
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
$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(3,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");$pdf->Cell(4,5,"$D","0",0,"C");
$pdf->Cell(3,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"L");$pdf->Cell(4,5,"$G","0",0,"C");$pdf->Cell(3,5,"$H","0",0,"C");
$pdf->Cell(4,5,"$I","0",0,"C");$pdf->Cell(4,5,"$J","0",0,"C");$pdf->Cell(9,5," ","0",0,"L");
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);
$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(3,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");$pdf->Cell(3,5,"$D","0",0,"C");
$pdf->Cell(4,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");$pdf->Cell(3,5,"$G","0",0,"C");$pdf->Cell(4,5,"$H","0",1,"C");
$pdf->SetFont('arial','',9);

$pdf->Cell(34,6," ","0",0,"L");$pdf->Cell(42,6,"$fir_fmes","0",0,"L");
$pdf->Cell(6,6," ","0",0,"L");$pdf->Cell(97,6,"$fir_fuli","0",1,"L");
$pdf->Cell(40,5," ","0",0,"L");$pdf->Cell(36,5,"$fir_fcdm","0",0,"L");$pdf->Cell(6,5," ","0",0,"L");$pdf->Cell(22,5," ","0",0,"L");
$A=substr($fir_fpsc,0,1);
$B=substr($fir_fpsc,1,1);
$C=substr($fir_fpsc,2,1);
$D=substr($fir_fpsc,3,1);
$E=substr($fir_fpsc,4,1);
$pdf->Cell(7,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"L");$pdf->Cell(4,5,"$B","0",0,"L");$pdf->Cell(3,5,"$C","0",0,"C");
$pdf->Cell(4,5,"$D","0",0,"C");$pdf->Cell(3,5,"$E","0",0,"C");$pdf->Cell(12,5," ","0",0,"R");$pdf->Cell(38,5,"$stat","0",1,"L");
$pdf->Cell(190,0,"                          ","0",1,"L");
$pdf->Cell(23,5," ","0",0,"L");$pdf->Cell(53,5,"$fir_ftel","0",0,"L");$pdf->Cell(5,5," ","0",0,"L");$pdf->Cell(52,5,"$fir_ffax","0",0,"L");
$pdf->Cell(8,5," ","0",0,"L");$pdf->Cell(38,4,"$fir_fem1","0",1,"L");
$pdf->Cell(190,0,"                          ","0",1,"L");
$pdf->Cell(67,5,"","0",0,"L");$pdf->Cell(112,6,"$fir_fnb1","0",1,"L");
//predËÌslie ˙Ëtu
$pdf->Cell(190,4,"                          ","0",1,"L");
$text=" ";
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$pdf->Cell(15,4," ","0",0,"L");$pdf->Cell(4,4,"$A","0",0,"L");$pdf->Cell(3,4,"$B","0",0,"C");$pdf->Cell(4,4,"$C","0",0,"R");
$pdf->Cell(4,4,"$D","0",0,"C");$pdf->Cell(3,4,"$E","0",0,"C");$pdf->Cell(4,4,"$F","0",0,"R");$pdf->Cell(4,4,"$G","0",0,"C");
$pdf->Cell(3,4,"$H","0",0,"C");$pdf->Cell(34,4," ","0",0,"L");
$A=substr($fir_fuc1,0,1);
$B=substr($fir_fuc1,1,1);
$C=substr($fir_fuc1,2,1);
$D=substr($fir_fuc1,3,1);
$E=substr($fir_fuc1,4,1);
$F=substr($fir_fuc1,5,1);
$G=substr($fir_fuc1,6,1);
$H=substr($fir_fuc1,7,1);
$I=substr($fir_fuc1,8,1);
$J=substr($fir_fuc1,9,1);
$pdf->Cell(4,4,"$A","0",0,"L");$pdf->Cell(3,4,"$B","0",0,"C");$pdf->Cell(4,4,"$C","0",0,"R");$pdf->Cell(4,4,"$D","0",0,"C");
$pdf->Cell(3,4,"$E","0",0,"C");$pdf->Cell(4,4,"$F","0",0,"R");$pdf->Cell(4,4,"$G","0",0,"L");$pdf->Cell(3,4,"$H","0",0,"C");
$pdf->Cell(4,4,"$I","0",0,"C");$pdf->Cell(4,4,"$J","0",0,"L");$pdf->Cell(27,4," ","0",0,"L");
$A=substr($fir_fnm1,0,1);
$B=substr($fir_fnm1,1,1);
$C=substr($fir_fnm1,2,1);
$D=substr($fir_fnm1,3,1);
$pdf->Cell(4,4,"$A","0",0,"L");$pdf->Cell(3,4,"$B","0",0,"C");$pdf->Cell(4,4,"$C","0",0,"R");$pdf->Cell(3,4,"$D","0",1,"L");
$pdf->Cell(190,10,"                          ","0",1,"L");




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


$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(23,5," ","0",0,"R");$pdf->Cell(49,5,"$poistenychvzp","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5," ","0",0,"L");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$platia","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->pdni_zp","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->zcel_zp","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->zzam_zp","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(23,5,"$fir_zp","0",0,"L");$pdf->Cell(49,5,"$hlavicka->ofir_zp","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(23,5,"$zam_zp","0",0,"L");$pdf->Cell(49,5,"$hlavicka->ozam_zp","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->ofir_gf","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5," ","0",0,"L");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$platiazpn","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->pdni_zpn","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->zcel_zpn","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->zzam_np","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(23,5,"$fir_zpn","0",0,"L");$pdf->Cell(49,5,"$hlavicka->ofir_np","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(23,5,"$zam_zpn","0",0,"L");$pdf->Cell(49,5,"$hlavicka->ozam_np","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->ofir_rf","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(190,6,"                          ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->celk_spolu","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");


$pdf->Cell(190,10,"                          ","0",1,"L");
$pdf->Cell(45,5,"  ","0",0,"L");$pdf->Cell(53,5,"  ","0",0,"L");$pdf->Cell(45,5,"  ","0",0,"L");$pdf->Cell(47,5,"  ","0",1,"L");

$pdf->Cell(190,7,"                          ","0",1,"L");
$pdf->Cell(98,5,"  ","0",0,"L");$pdf->Cell(92,5,"  ","0",1,"L");

$pdf->Cell(190,13,"                          ","0",1,"L");
$pdf->Cell(98,5,"  ","0",0,"L");$pdf->Cell(92,5,"  ","0",1,"L");

$pdf->SetY(231);
$pdf->SetFont('arial','',8);
$pdf->Cell(14,4," ","0",0,"L");$pdf->Cell(50,4,"$fir_mzdt05","0",0,"L");$pdf->Cell(60,4,"$fir_mzdt04","0",1,"L");

$pdf->SetY(34);
$akyvyk="N";
if( $h_oprav == 1 ) $akyvyk="O";
$pdf->Cell(143,5," ","0",0,"L");$pdf->Cell(4,5,"$akyvyk","0",1,"L");


          }
//koniec vseobecna zdravotna max2=0


//vseobecna zdravotna mesacny max2=1
if ( $cislo_zdrv >= 2500 AND $cislo_zdrv <= 2599 AND $max2 == 1 )
          {
$nebolaziadna=0;
$rmc=0;

if (File_Exists ('../dokumenty/zdravpoist/zp2508/mesacny_vykaz_max2.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/zdravpoist/zp2508/mesacny_vykaz_max2.jpg',0,0,206,094); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',12);
$obdobie=$kli_vume*10000;
if( $obdobie < 102009 ) $obdobie= "0".$obdobie;

$zdrv22=substr($cislo_zdrv,2,2);

$pdf->Cell(190,13,"                          ","$rmc",1,"L");
$A=substr($zdrv22,0,1);
$B=substr($zdrv22,1,1);
$pdf->Cell(174,5," ","$rmc",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",1,"R");

//platitel
$pdf->Cell(190,1,"                          ","$rmc",1,"L");
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

$pdf->Cell(143,6," ","$rmc",0,"L");$pdf->Cell(4,6,"$A","$rmc",0,"L");$pdf->Cell(4,6,"$B","$rmc",0,"L");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"L");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"L");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"L");


$pdf->Cell(190,15,"                          ","$rmc",1,"L");
$pdf->Cell(30,6," ","$rmc",0,"L");$pdf->Cell(60,6,"$obdobie","$rmc",0,"L");


//den vyplaty
$fir_mzdx06=1*$fir_mzdx06;
if( $fir_mzdx06 == 0 ) $fir_mzdx06="";

$A=substr($fir_mzdx06,0,1);
$B=substr($fir_mzdx06,1,1);


$pdf->Cell(74,5," ","$rmc",0,"L");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",1,"C");

//nazov
$pdf->Cell(190,12,"                          ","$rmc",1,"L");
$pdf->Cell(36,6," ","$rmc",0,"L");$pdf->Cell(90,6,"$fir_fnaz","$rmc",0,"L");$pdf->Cell(19,6," ","$rmc",0,"L");$pdf->Cell(34,6,"$fir_uctt02","$rmc",1,"L");

$pdf->Cell(190,7,"                          ","$rmc",1,"L");
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
$pdf->Cell(6,5," ","$rmc",0,"L");$pdf->Cell(3,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"L");$pdf->Cell(4,5,"$G","$rmc",0,"C");
$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(4,5,"$J","$rmc",0,"C");$pdf->Cell(54,5," ","$rmc",0,"L");
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
$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(3,5,"$F","$rmc",0,"L");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");
$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(4,5,"$J","$rmc",0,"C");$pdf->Cell(10,5," ","$rmc",0,"L");
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);
$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",1,"C");
$pdf->SetFont('arial','',9);

$pdf->Cell(34,6," ","$rmc",0,"L");$pdf->Cell(42,6,"$fir_fmes","$rmc",0,"L");
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(97,6,"$fir_fuli","$rmc",1,"L");
$pdf->Cell(40,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$fir_fcdm","$rmc",0,"L");$pdf->Cell(6,5," ","$rmc",0,"L");$pdf->Cell(22,5," ","$rmc",0,"L");
$A=substr($fir_fpsc,0,1);
$B=substr($fir_fpsc,1,1);
$C=substr($fir_fpsc,2,1);
$D=substr($fir_fpsc,3,1);
$E=substr($fir_fpsc,4,1);
$pdf->Cell(14,5," ","$rmc",0,"L");$pdf->Cell(4,5,"$A","$rmc",0,"L");$pdf->Cell(4,5,"$B","$rmc",0,"L");$pdf->Cell(4,5,"$C","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(12,5," ","$rmc",0,"R");$pdf->Cell(38,5,"$stat","$rmc",1,"L");
$pdf->Cell(190,0,"                          ","$rmc",1,"L");

//celkovy pocet poistenych vo vsetkych ZP
$pocetpoistenychcelkom=0;
$sqldokx = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume AND zdrv > 0 AND zpnie = 0 ";
$sqlx = mysql_query("$sqldokx");
$pocetpoistenychcelkom=1*mysql_num_rows($sqlx);
if( $pocetpoistenychcelkom == 0 ) { $pocetpoistenychcelkom=$hlavicka->pzam_celk; }


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


$pdf->Cell(190,10,"                          ","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(23,5," ","$rmc",0,"R");$pdf->Cell(49,5,"$poistenychvzp","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(23,5," ","$rmc",0,"R");$pdf->Cell(49,5,"$pocetpoistenychcelkom","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");

$pdf->Cell(190,6,"                          ","$rmc",1,"L");

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(72,5,"$platia","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(72,5,"$hlavicka->pdni_zp","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(72,5,"$hlavicka->zcel_zp","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");
$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->zzam_zp","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(17,7," ","$rmc",0,"L");$pdf->Cell(81,7,"","$rmc",0,"L");$pdf->Cell(23,7,"$fir_zp","$rmc",0,"R");$pdf->Cell(49,7,"$hlavicka->ofir_zp","$rmc",0,"R");$pdf->Cell(20,7," ","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(23,5,"$zam_zp","$rmc",0,"R");$pdf->Cell(49,5,"$hlavicka->ozam_zp","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(72,5,"$hlavicka->ofir_gf","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(72,5," ","$rmc",0,"L");$pdf->Cell(20,5," ","$rmc",1,"L");

$pdf->Cell(190,1,"                          ","$rmc",1,"L");

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(72,5,"$platiazpn","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(72,5,"$hlavicka->pdni_zpn","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");
$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->zcel_zpn","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(72,5,"$hlavicka->zzam_np","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");
$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(23,6,"$fir_zpn","$rmc",0,"R");$pdf->Cell(49,6,"$hlavicka->ofir_np","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(23,5,"$zam_zpn","$rmc",0,"R");$pdf->Cell(49,5,"$hlavicka->ozam_np","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");
$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->ofir_rf","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(190,3,"                          ","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(72,5,"$hlavicka->celk_spolu","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");


//vyplnil
$pdf->SetY(219);
$pdf->SetFont('arial','',8);
$pdf->Cell(14,4," ","$rmc",0,"L");$pdf->Cell(45,4,"$fir_mzdt05","$rmc",0,"L");$pdf->Cell(41,4,"$fir_mzdt04","$rmc",0,"L");
$pdf->Cell(35,4,"$fir_ffax","$rmc",0,"L");$pdf->Cell(0,4,"$fir_fem1","$rmc",1,"L");

//typ vykazu
$pdf->SetY(39);
$akyvyk="N";
if( $h_oprav == 1 ) $akyvyk="O";
$pdf->Cell(178,5," ","$rmc",0,"L");$pdf->Cell(4,5,"$akyvyk","$rmc",1,"L");


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


$porcislo=1;
$pdf->SetFont('arial','',9);

if( $ip == 0 ) $pdf->SetY(243);
if( $ip == 1 ) $pdf->SetY(248);

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


$pdf->Cell(12,5," ","$rmc",0,"R");
$pdf->Cell(28,5,"$cislopoistenca","$rmc",0,"L");

if( $hlavicka->znizp == 0 )
{
$pdf->Cell(13,5,"$hlavicka->pdni_zp","$rmc",0,"R");
$pdf->Cell(18,5,"$hlavicka->zcel_zp","$rmc",0,"R");$pdf->Cell(19,5,"$hlavicka->zzam_zp","$rmc",0,"R");
$pdf->Cell(19,5,"$fir_zp","$rmc",0,"R");$pdf->Cell(18,5,"$zam_zp","$rmc",0,"R");
$pdf->Cell(18,5,"$hlavicka->ofir_zp","$rmc",0,"R");$pdf->Cell(20,5,"$hlavicka->ozam_zp","$rmc",0,"R");
$pdf->Cell(17,5,"$hlavicka->ofir_gf","$rmc",1,"R");
}

if( $hlavicka->znizp != 0 )
{
$pdf->Cell(13,5,"$hlavicka->pdni_zpn","$rmc",0,"R");
$pdf->Cell(18,5,"$hlavicka->zcel_zpn","$rmc",0,"R");$pdf->Cell(19,5,"$hlavicka->zzam_np","$rmc",0,"R");
$pdf->Cell(19,5,"$fir_zpn","$rmc",0,"R");$pdf->Cell(18,5,"$zam_zpn","$rmc",0,"R");
$pdf->Cell(18,5,"$hlavicka->ofir_np","$rmc",0,"R");$pdf->Cell(20,5,"$hlavicka->ozam_np","$rmc",0,"R");
$pdf->Cell(17,5,"$hlavicka->ofir_rf","$rmc",1,"R");
}

  }
$ip = $ip + 1;
    }
//koniec prilohy 


          }
//koniec vseobecna zdravotna max=1

//union mesacny max2=0
if ( $cislo_zdrv >= 2700 AND $cislo_zdrv <= 2799 AND $max2 == 0 )
          {
$nebolaziadna=0;

if (File_Exists ('../dokumenty/zdravpoist/zp2708/mesacny_vykaz.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/zdravpoist/zp2708/mesacny_vykaz.jpg',5,0,200,094); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',12);

$pdf->Cell(190,21,"                          ","0",1,"L");

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

$pdf->SetFont('arial','',9);
$pdf->Cell(27,6," ","0",0,"L");$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(5,6,"$B","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");
$pdf->Cell(6,6,"$D","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");$pdf->Cell(5,6,"$F","0",0,"C");
$pdf->Cell(5,6,"$G","0",0,"C");$pdf->Cell(5,6,"$H","0",0,"C");$pdf->Cell(5,6,"$I","0",0,"C");$pdf->Cell(5,6,"$J","0",0,"C");

$pdf->Cell(89,6,"                          ","0",0,"L");

$A=substr($cislo_zdrv,0,1);
$B=substr($cislo_zdrv,1,1);
$C=substr($cislo_zdrv,2,1);
$D=substr($cislo_zdrv,3,1);

$pdf->Cell(5,6,"$A","0",0,"C");$pdf->Cell(5,6,"$B","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");$pdf->Cell(6,6,"$D","0",1,"C");

$pdf->Cell(190,25,"                          ","0",1,"L");

$obdobie=$kli_vmes;
if( $obdobie < 10 ) $obdobie= "0".$obdobie;
$A=substr($obdobie,0,1);
$B=substr($obdobie,1,1);

$pdf->Cell(16,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"L");$pdf->Cell(4,5,"$B","0",0,"L");

$robdobie=$kli_vrok;
$A=substr($robdobie,0,1);
$B=substr($robdobie,1,1);
$C=substr($robdobie,2,1);
$D=substr($robdobie,3,1);

$pdf->Cell(4,5,"$A","0",0,"L");$pdf->Cell(4,5,"$B","0",0,"L");$pdf->Cell(4,5,"$C","0",0,"L");$pdf->Cell(4,5,"$D","0",1,"L");

$pdf->Cell(190,9,"                          ","0",1,"L");

$pdf->Cell(25,5," ","0",0,"L");$pdf->Cell(50,5,"$fir_fnaz","0",0,"L");$pdf->Cell(0,5," ","0",1,"L");

$pdf->Cell(190,10,"                          ","0",1,"L");

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

$pdf->Cell(99,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");
$pdf->Cell(4,5,"$D","0",0,"C");$pdf->Cell(4,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");
$pdf->Cell(4,5,"$G","0",0,"C");$pdf->Cell(4,5,"$H","0",0,"C");$pdf->Cell(4,5,"$I","0",0,"C");$pdf->Cell(4,5,"$J","0",0,"C");

$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);


$pdf->Cell(9,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");
$pdf->Cell(4,5,"$D","0",0,"C");$pdf->Cell(4,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");
$pdf->Cell(4,5,"$G","0",0,"C");$pdf->Cell(4,5,"$H","0",1,"C");

$pdf->Cell(190,2,"                          ","0",1,"L");

$pdf->Cell(25,5," ","0",0,"L");$pdf->Cell(90,5,"$fir_fmes","0",0,"L");$pdf->Cell(30,5,"$fir_fcdm","0",0,"L");$pdf->Cell(0,5," ","0",1,"L");

$pdf->Cell(190,1,"                          ","0",1,"L");

$pdf->Cell(25,5," ","0",0,"L");$pdf->Cell(90,5,"$fir_fuli","0",0,"L");

$fir_fpscx=str_replace(" ","",$fir_fpsc);

$A=substr($fir_fpscx,0,1);
$B=substr($fir_fpscx,1,1);
$C=substr($fir_fpscx,2,1);
$D=substr($fir_fpscx,3,1);
$E=substr($fir_fpscx,4,1);
$F=substr($fir_fpscx,5,1);


$pdf->Cell(53,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");
$pdf->Cell(4,5,"$D","0",0,"C");$pdf->Cell(4,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",1,"C");

$pdf->Cell(190,3,"                          ","0",1,"L");

$pdf->Cell(25,5," ","0",0,"L");$pdf->Cell(70,5,"$fir_fem1","0",0,"L");$pdf->Cell(50,5,"$fir_ftel","0",0,"L");$pdf->Cell(0,5,"$fir_ffax","0",1,"L");

$pdf->Cell(190,2,"                          ","0",1,"L");

$pdf->Cell(34,5," ","0",0,"L");$pdf->Cell(80,5,"$fir_fnb1","0",0,"L");$pdf->Cell(39,5,"$fir_fuc1","0",0,"L");

$A=substr($fir_fnm1,0,1);
$B=substr($fir_fnm1,1,1);
$C=substr($fir_fnm1,2,1);
$D=substr($fir_fnm1,3,1);


$pdf->Cell(19,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");
$pdf->Cell(4,5,"$D","0",1,"C");



$pdf->Cell(190,10,"                          ","0",1,"L");



$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(23,6," ","0",0,"R");$pdf->Cell(49,6,"$hlavicka->pzam_celk","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->pzam_zp","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->pdni_zp","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->zcel_zp","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->zzam_zp","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(33,6,"$fir_zp","0",0,"R");$pdf->Cell(39,6,"$hlavicka->ofir_zp","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(33,6,"$zam_zp","0",0,"R");$pdf->Cell(39,6,"$hlavicka->ozam_zp","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->ofir_gf","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->pzam_zpn","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->pdni_zpn","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->zcel_zpn","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->zzam_np","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(33,6,"$fir_zpn","0",0,"R");$pdf->Cell(39,6,"$hlavicka->ofir_np","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(33,6,"$zam_zpn","0",0,"R");$pdf->Cell(39,6,"$hlavicka->ozam_np","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->ofir_rf","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");

$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->celk_spolu","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");


$pdf->Cell(190,10,"                          ","0",1,"L");
$pdf->Cell(45,5,"  ","0",0,"L");$pdf->Cell(53,5,"  ","0",0,"L");$pdf->Cell(45,5,"  ","0",0,"L");$pdf->Cell(47,5,"  ","0",1,"L");

//vyplnil a telefon
if( $fir_mzdt05 == '' ) $fir_mzdt05=$kli_uzmeno." ".$kli_uzprie;

$pdf->SetY(249);
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(40,6,"$fir_mzdt05","$rmc",0,"L");

$fir_mzdt04x=str_replace("/","",$fir_mzdt04);
$fir_mzdt04x=str_replace(" ","",$fir_mzdt04x);

$A=substr($fir_mzdt04x,0,1);
$B=substr($fir_mzdt04x,1,1);
$C=substr($fir_mzdt04x,2,1);
$D=substr($fir_mzdt04x,3,1);
$E=substr($fir_mzdt04x,4,1);
$F=substr($fir_mzdt04x,5,1);
$G=substr($fir_mzdt04x,6,1);
$H=substr($fir_mzdt04x,7,1);
$I=substr($fir_mzdt04x,8,1);
$J=substr($fir_mzdt04x,9,1);

$pdf->Cell(34,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");
$pdf->Cell(4,5,"$D","0",0,"C");$pdf->Cell(4,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");
$pdf->Cell(4,5,"$G","0",0,"C");$pdf->Cell(4,5,"$H","0",0,"C");$pdf->Cell(4,5,"$I","0",0,"C");$pdf->Cell(4,5,"$J","0",0,"C");

$pdf->SetY(42);
$akyvyk="N";
if( $h_oprav == 1 ) $akyvyk="O";
$pdf->Cell(181,5," ","0",0,"L");$pdf->Cell(4,5,"$akyvyk","0",1,"L");

          }
//koniec union mesacny max2=0


//union mesacny max2=1
if ( $cislo_zdrv >= 2700 AND $cislo_zdrv <= 2799 AND $max2 == 1 )
          {
$nebolaziadna=0;

if (File_Exists ('../dokumenty/zdravpoist/zp2708/mesacny_vykaz_max2.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/zdravpoist/zp2708/mesacny_vykaz_max2.jpg',5,4,199,095); }
}

$rmc=0;

$pdf->SetY(10);
$pdf->SetFont('arial','',9);

$pdf->Cell(190,15,"                          ","$rmc",1,"L");


$A=substr($cislo_zdrv,0,1);
$B=substr($cislo_zdrv,1,1);
$C=substr($cislo_zdrv,2,1);
$D=substr($cislo_zdrv,3,1);

$pdf->Cell(171,6,"  ","$rmc",0,"L");
$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(6,6,"$C","$rmc",0,"C");$pdf->Cell(6,6,"$D","$rmc",1,"C");


$pdf->Cell(190,2,"                          ","$rmc",1,"L");

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

$pdf->Cell(138,6," ","$rmc",0,"L");$pdf->Cell(6,6,"$A","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");
$pdf->Cell(6,6,"$D","$rmc",0,"C");$pdf->Cell(6,6,"$E","$rmc",0,"C");$pdf->Cell(5,6,"$F","$rmc",0,"C");
$pdf->Cell(6,6,"$G","$rmc",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");$pdf->Cell(5,6,"$J","$rmc",1,"C");

$pdf->Cell(190,17,"                          ","$rmc",1,"L");

$kli_mesiac=$kli_vmes;
if( $kli_vmes < 10 ) $kli_mesiac="0".$kli_vmes;
$sqlttp = "SELECT * FROM kalendar WHERE ume = $kli_vume ";
$sqlp = mysql_query("$sqlttp");
$pocetdni = mysql_num_rows($sqlp);

$robdobie=$kli_mesiac.$kli_vrok;


$A=substr($robdobie,0,1);
$B=substr($robdobie,1,1);
$C=substr($robdobie,2,1);
$D=substr($robdobie,3,1);
$E=substr($robdobie,4,1);
$F=substr($robdobie,5,1);


$pdf->Cell(64,5," ","$rmc",0,"L");
$pdf->Cell(4,5,"$A","$rmc",0,"L");$pdf->Cell(4,5,"$B","$rmc",0,"L");$pdf->Cell(5,5,"$C","$rmc",0,"L");$pdf->Cell(4,5,"$D","$rmc",0,"L");
$pdf->Cell(4,5,"$E","$rmc",0,"L");$pdf->Cell(4,5,"$F","$rmc",0,"L");


//den vyplaty
$fir_mzdx06=1*$fir_mzdx06;
$fir_mzdx06x=$fir_mzdx06.$kli_mesiac.$kli_vrok;
if( $fir_mzdx06 == 0 ) $fir_mzdx06x="";

$A=substr($fir_mzdx06x,0,1);
$B=substr($fir_mzdx06x,1,1);
$C=substr($fir_mzdx06x,2,1);
$D=substr($fir_mzdx06x,3,1);
$E=substr($fir_mzdx06x,4,1);
$F=substr($fir_mzdx06x,5,1);
$G=substr($fir_mzdx06x,6,1);
$H=substr($fir_mzdx06x,7,1);

$pdf->Cell(70,5," ","$rmc",0,"L");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");
$pdf->Cell(5,5,"$D","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",1,"C");


$pdf->Cell(190,9,"                          ","$rmc",1,"L");
$pdf->Cell(190,4,"                          ","$rmc",1,"L");
$pdf->Cell(25,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$fir_fnaz","$rmc",0,"L");
$pdf->Cell(90,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$fir_uctt02","$rmc",1,"L");

$pdf->Cell(190,8,"                          ","$rmc",1,"L");

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

$pdf->Cell(100,5," ","$rmc",0,"L");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(4,5,"$J","$rmc",0,"C");

$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);


$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",1,"C");

$pdf->Cell(190,2,"                          ","$rmc",1,"L");

$pdf->Cell(25,5," ","$rmc",0,"L");$pdf->Cell(90,5,"$fir_fmes","$rmc",0,"L");$pdf->Cell(30,5,"$fir_fuli","$rmc",0,"L");$pdf->Cell(0,5," ","$rmc",1,"L");

$pdf->Cell(190,3,"                          ","$rmc",1,"L");

$pdf->Cell(32,5," ","$rmc",0,"L");$pdf->Cell(23,5,"$fir_fcdm","$rmc",0,"L");

$fir_fpscx=str_replace(" ","",$fir_fpsc);

$A=substr($fir_fpscx,0,1);
$B=substr($fir_fpscx,1,1);
$C=substr($fir_fpscx,2,1);
$D=substr($fir_fpscx,3,1);
$E=substr($fir_fpscx,4,1);
$F=substr($fir_fpscx,5,1);


$pdf->Cell(53,5," ","$rmc",0,"L");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",1,"C");

$pdf->Cell(190,3,"                          ","$rmc",1,"L");




$pdf->Cell(190,5,"                          ","$rmc",1,"L");

//celkovy pocet poistenych vo vsetkych ZP
$pocetpoistenychcelkom=0;
$sqldokx = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume AND zdrv > 0 AND zpnie = 0 ";
$sqlx = mysql_query("$sqldokx");
$pocetpoistenychcelkom=1*mysql_num_rows($sqlx);
if( $pocetpoistenychcelkom == 0 ) { $pocetpoistenychcelkom=$hlavicka->pzam_celk; }

$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(23,6," ","$rmc",0,"R");$pdf->Cell(49,6,"$hlavicka->pzam_celk","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(23,6," ","$rmc",0,"R");$pdf->Cell(49,6,"$pocetpoistenychcelkom","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(17,6," ","$rmc",1,"L");
$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->pzam_zp","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(72,5,"$hlavicka->pdni_zp","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");
$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->zcel_zp","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->zzam_zp","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(33,6,"$fir_zp","$rmc",0,"R");$pdf->Cell(39,6,"$hlavicka->ofir_zp","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(33,5,"$zam_zp","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->ozam_zp","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");
$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->ofir_gf","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(20,5," ","$rmc",1,"L");
$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->pzam_zpn","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->pdni_zpn","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(72,5,"$hlavicka->zcel_zpn","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");
$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->zzam_np","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(33,5,"$fir_zpn","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->ofir_np","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");
$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(33,6,"$zam_zpn","$rmc",0,"R");$pdf->Cell(39,6,"$hlavicka->ozam_np","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->ofir_rf","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");

$pdf->Cell(17,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->celk_spolu","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");


$pdf->Cell(190,10,"                          ","$rmc",1,"L");
$pdf->Cell(45,5,"  ","$rmc",0,"L");$pdf->Cell(53,5,"  ","$rmc",0,"L");$pdf->Cell(45,5,"  ","$rmc",0,"L");$pdf->Cell(47,5,"  ","$rmc",1,"L");

//vyplnil a telefon a email
if( $fir_mzdt05 == '' ) $fir_mzdt05=$kli_uzmeno." ".$kli_uzprie;

$pdf->SetY(228);
$pdf->Cell(9,6," ","$rmc",0,"L");$pdf->Cell(40,6,"$fir_mzdt05","$rmc",0,"L");

$fir_mzdt04x=str_replace("/","",$fir_mzdt04);
$fir_mzdt04x=str_replace(" ","",$fir_mzdt04x);

$A=substr($fir_mzdt04x,0,1);
$B=substr($fir_mzdt04x,1,1);
$C=substr($fir_mzdt04x,2,1);
$D=substr($fir_mzdt04x,3,1);
$E=substr($fir_mzdt04x,4,1);
$F=substr($fir_mzdt04x,5,1);
$G=substr($fir_mzdt04x,6,1);
$H=substr($fir_mzdt04x,7,1);
$I=substr($fir_mzdt04x,8,1);
$J=substr($fir_mzdt04x,9,1);

$pdf->Cell(1,5," ","$rmc",0,"L");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");
$pdf->Cell(5,5,"$D","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(4,5,"$J","$rmc",0,"C");

$pdf->Cell(60,6," ","$rmc",0,"L");$pdf->Cell(40,6,"$fir_fem1","$rmc",0,"L");

//aky vykaz
$pdf->SetY(45);
$akyvyk="N";
if( $h_oprav == 1 ) $akyvyk="O";
$pdf->Cell(185,5," ","0",0,"L");$pdf->Cell(4,5,"$akyvyk","0",1,"L");


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


$porcislo=1;
$pdf->SetFont('arial','',9);

if( $ip == 0 ) $pdf->SetY(254);
if( $ip == 1 ) $pdf->SetY(261);

$pdf->Cell(5,6," ","$rmc",0,"R");
$pdf->Cell(20,6,"$hlavicka->rdc $hlavicka->rdk","$rmc",0,"L");

if( $hlavicka->znizp == 0 )
{
$pdf->Cell(9,6,"$hlavicka->pdni_zp","$rmc",0,"R");
$pdf->Cell(20,6,"$hlavicka->zcel_zp","$rmc",0,"R");$pdf->Cell(25,6,"$hlavicka->zzam_zp","$rmc",0,"R");
$pdf->Cell(25,6,"$fir_zp","$rmc",0,"R");$pdf->Cell(23,6,"$zam_zp","$rmc",0,"R");
$pdf->Cell(25,6,"$hlavicka->ofir_zp","$rmc",0,"R");$pdf->Cell(23,6,"$hlavicka->ozam_zp","$rmc",0,"R");
$pdf->Cell(17,6,"$hlavicka->ofir_gf","$rmc",0,"R");
$pdf->Cell(5,6,"                          ","$rmc",1,"L");
}

if( $hlavicka->znizp != 0 )
{
$pdf->Cell(9,6,"$hlavicka->pdni_zpn","$rmc",0,"R");
$pdf->Cell(20,6,"$hlavicka->zcel_zpn","$rmc",0,"R");$pdf->Cell(25,6,"$hlavicka->zzam_np","$rmc",0,"R");
$pdf->Cell(25,6,"$fir_zpn","$rmc",0,"R");$pdf->Cell(23,6,"$zam_zpn","$rmc",0,"R");
$pdf->Cell(25,6,"$hlavicka->ofir_np","$rmc",0,"R");$pdf->Cell(23,6,"$hlavicka->ozam_np","$rmc",0,"R");
$pdf->Cell(17,6,"$hlavicka->ofir_rf","$rmc",0,"R");
$pdf->Cell(5,6,"                          ","$rmc",1,"L");
}

  }
$ip = $ip + 1;
    }
//koniec prilohy 


          }
//koniec union mesacny max2=1


//szp mesacny
if ( $cislo_zdrv >= 2100 AND $cislo_zdrv <= 2199 )
          {
$nebolaziadna=0;


if (File_Exists ('../dokumenty/zdravpoist/zp2108/mesacny_vykaz.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/zdravpoist/zp2108/mesacny_vykaz.jpg',5,0,200,094); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',12);

$pdf->Cell(190,17,"                          ","0",1,"L");


$A=substr($cislo_zdrv,0,1);
$B=substr($cislo_zdrv,1,1);
$C=substr($cislo_zdrv,2,1);
$D=substr($cislo_zdrv,3,1);

$pdf->Cell(141,5," ","0",0,"L");$pdf->Cell(4,5,"$C","0",0,"L");$pdf->Cell(4,5,"$D","0",1,"L");

$pdf->Cell(190,1,"                          ","0",1,"L");

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

$pdf->SetFont('arial','',9);
$pdf->Cell(140,6," ","0",0,"L");$pdf->Cell(4,6,"$A","0",0,"C");$pdf->Cell(4,6,"$B","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");
$pdf->Cell(4,6,"$D","0",0,"C");$pdf->Cell(4,6,"$E","0",0,"C");$pdf->Cell(4,6,"$F","0",0,"C");
$pdf->Cell(4,6,"$G","0",0,"C");$pdf->Cell(4,6,"$H","0",0,"C");$pdf->Cell(4,6,"$I","0",0,"C");$pdf->Cell(4,6,"$J","0",1,"C");

$pdf->Cell(190,17,"                          ","0",1,"L");

$obdobie=$kli_vmes;
if( $obdobie < 10 ) $obdobie= "0".$obdobie;
$A=substr($obdobie,0,1);
$B=substr($obdobie,1,1);

$pdf->Cell(26,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"L");$pdf->Cell(4,5,"$B","0",0,"L");

$robdobie=$kli_vrok;
$A=substr($robdobie,0,1);
$B=substr($robdobie,1,1);
$C=substr($robdobie,2,1);
$D=substr($robdobie,3,1);

$pdf->Cell(1,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"L");$pdf->Cell(4,5,"$B","0",0,"L");$pdf->Cell(4,5,"$C","0",0,"L");$pdf->Cell(4,5,"$D","0",1,"L");

$pdf->Cell(190,10,"                          ","0",1,"L");

$pdf->Cell(65,5," ","0",0,"L");$pdf->Cell(60,5,"$fir_fnaz","0",0,"L");$pdf->Cell(0,5," ","0",1,"L");


$pdf->Cell(190,6,"                          ","0",1,"L");

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

$pdf->Cell(15,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");
$pdf->Cell(5,5,"$D","0",0,"C");$pdf->Cell(4,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");
$pdf->Cell(4,5,"$G","0",0,"C");$pdf->Cell(4,5,"$H","0",0,"C");$pdf->Cell(4,5,"$I","0",0,"C");$pdf->Cell(4,5,"$J","0",0,"C");

$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);


$pdf->Cell(8,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");
$pdf->Cell(5,5,"$D","0",0,"C");$pdf->Cell(4,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");
$pdf->Cell(4,5,"$G","0",0,"C");$pdf->Cell(4,5,"$H","0",1,"C");

$pdf->Cell(190,1,"                          ","0",1,"L");

$pdf->Cell(28,5," ","0",0,"L");$pdf->Cell(87,5,"$fir_fmes","0",0,"L");$pdf->Cell(30,5,"$fir_fuli","0",0,"L");$pdf->Cell(0,5," ","0",1,"L");

$pdf->Cell(190,1,"                          ","0",1,"L");

$pdf->Cell(25,5," ","0",0,"L");$pdf->Cell(40,5,"$fir_fcdm","0",0,"L");

$A=substr($fir_fpsc,0,1);
$B=substr($fir_fpsc,1,1);
$C=substr($fir_fpsc,2,1);
$D=substr($fir_fpsc,3,1);
$E=substr($fir_fpsc,4,1);
$F=substr($fir_fpsc,5,1);


$pdf->Cell(13,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");
$pdf->Cell(4,5,"$D","0",0,"C");$pdf->Cell(4,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",1,"C");

$pdf->Cell(190,1,"                          ","0",1,"L");

$pdf->Cell(25,5," ","0",0,"L");$pdf->Cell(50,5,"$fir_ftel","0",0,"L");$pdf->Cell(55,5,"$fir_ffax","0",0,"L");$pdf->Cell(0,5,"$fir_fem1","0",1,"L");


$pdf->Cell(75,5," ","0",0,"L");$pdf->Cell(80,5,"$fir_fnb1","0",0,"L");$pdf->Cell(39,5," ","0",1,"L");

$pdf->Cell(190,2,"                          ","0",1,"L");

$A=substr($fir_fuc1,0,1);
$B=substr($fir_fuc1,1,1);
$C=substr($fir_fuc1,2,1);
$D=substr($fir_fuc1,3,1);
$E=substr($fir_fuc1,4,1);
$F=substr($fir_fuc1,5,1);
$G=substr($fir_fuc1,6,1);
$H=substr($fir_fuc1,7,1);
$I=substr($fir_fuc1,8,1);
$J=substr($fir_fuc1,9,1);

$pdf->Cell(72,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");
$pdf->Cell(5,5,"$D","0",0,"C");$pdf->Cell(4,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");
$pdf->Cell(4,5,"$G","0",0,"C");$pdf->Cell(4,5,"$H","0",0,"C");$pdf->Cell(4,5,"$I","0",0,"C");$pdf->Cell(4,5,"$J","0",0,"C");



$A=substr($fir_fnm1,0,1);
$B=substr($fir_fnm1,1,1);
$C=substr($fir_fnm1,2,1);
$D=substr($fir_fnm1,3,1);


$pdf->Cell(18,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");
$pdf->Cell(4,5,"$D","0",1,"C");



$pdf->Cell(190,8,"                          ","0",1,"L");



$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(23,5," ","0",0,"R");$pdf->Cell(49,5,"$hlavicka->pzam_celk","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->pzam_zp","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,4," ","0",0,"L");$pdf->Cell(81,4,"","0",0,"L");$pdf->Cell(72,4,"$hlavicka->pdni_zp","0",0,"R");$pdf->Cell(20,4," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->zcel_zp","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->zzam_zp","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(33,5," ","0",0,"R");$pdf->Cell(39,5,"$hlavicka->ofir_zp","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(33,5," ","0",0,"R");$pdf->Cell(39,5,"$hlavicka->ozam_zp","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->ofir_gf","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(20,7," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->pzam_zpn","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,4," ","0",0,"L");$pdf->Cell(81,4,"","0",0,"L");$pdf->Cell(72,4,"$hlavicka->pdni_zpn","0",0,"R");$pdf->Cell(20,4," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->zcel_zpn","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->zzam_np","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(33,5," ","0",0,"R");$pdf->Cell(39,5,"$hlavicka->ofir_np","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(33,5," ","0",0,"R");$pdf->Cell(39,5,"$hlavicka->ozam_np","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->ofir_rf","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(20,1," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->celk_spolu","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");


$pdf->Cell(190,10,"                          ","0",1,"L");
$pdf->Cell(45,5,"  ","0",0,"L");$pdf->Cell(53,5,"  ","0",0,"L");$pdf->Cell(45,5,"  ","0",0,"L");$pdf->Cell(47,5,"  ","0",1,"L");

          }
//koniec szp mesacny


//dovera a apolo spojene mesacny max2=0
if ( $cislo_zdrv >= 2300 AND $cislo_zdrv <= 2499 AND $max2 == 0  )
          {
$nebolaziadna=0;


if (File_Exists ('../dokumenty/zdravpoist/dovera2010/mesacny_vykaz.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/zdravpoist/dovera2010/mesacny_vykaz.jpg',20,12,170,270); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',9);

$pdf->Cell(190,16,"                          ","0",1,"L");


$A=substr($cislo_zdrv,0,1);
$B=substr($cislo_zdrv,1,1);
$C=substr($cislo_zdrv,2,1);
$D=substr($cislo_zdrv,3,1);

$pdf->Cell(138,5," ","0",0,"L");$pdf->Cell(20,5,"$cislo_zdrv","0",0,"L");$pdf->Cell(4,5," ","0",1,"L");

$pdf->Cell(190,2,"                          ","0",1,"L");

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

$pdf->SetFont('arial','',9);
$pdf->Cell(129,6," ","0",0,"L");$pdf->Cell(4,6,"$A","0",0,"C");$pdf->Cell(4,6,"$B","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");
$pdf->Cell(4,6,"$D","0",0,"C");$pdf->Cell(4,6,"$E","0",0,"C");$pdf->Cell(4,6,"$F","0",0,"C");
$pdf->Cell(4,6,"$G","0",0,"C");$pdf->Cell(4,6,"$H","0",0,"C");$pdf->Cell(4,6,"$I","0",0,"C");$pdf->Cell(4,6,"$J","0",1,"C");

$pdf->Cell(190,15,"                          ","0",1,"L");

$obdobie=$kli_vmes;
if( $obdobie < 10 ) $obdobie= '0'.$obdobie;
$A=substr($obdobie,0,1);
$B=substr($obdobie,1,1);

$pdf->Cell(47,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"L");$pdf->Cell(4,5,"$B","0",0,"L");

$robdobie=$kli_vrok;
$A=substr($robdobie,0,1);
$B=substr($robdobie,1,1);
$C=substr($robdobie,2,1);
$D=substr($robdobie,3,1);

$pdf->Cell(1,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"L");$pdf->Cell(4,5,"$B","0",0,"L");$pdf->Cell(4,5,"$C","0",0,"L");$pdf->Cell(4,5,"$D","0",0,"L");
$pdf->Cell(90,5,"","0",0,"L");$pdf->Cell(0,5,"$fir_mzdx06.","0",1,"L");



$pdf->Cell(190,10,"                          ","0",1,"L");

$pdf->Cell(50,5," ","0",0,"L");$pdf->Cell(80,5,"$fir_fnaz","0",0,"L");
$pdf->Cell(20,5,"","0",0,"L");$pdf->Cell(0,5,"$fir_uctt02","0",1,"L");


$pdf->Cell(190,7,"                          ","0",1,"L");


$pdf->Cell(98,5," ","0",0,"L");$pdf->Cell(37,5,"$fir_fdic","0",0,"L");$pdf->Cell(40,5,"$fir_fico","0",1,"L");


$pdf->Cell(190,1,"                          ","0",1,"L");

$pdf->Cell(43,5," ","0",0,"L");$pdf->Cell(85,5,"$fir_fmes","0",0,"L");$pdf->Cell(30,5,"$fir_fuli","0",0,"L");$pdf->Cell(0,5," ","0",1,"L");



$pdf->Cell(43,5," ","0",0,"L");$pdf->Cell(85,5,"$fir_fcdm","0",0,"L");$pdf->Cell(40,5,"$fir_fpsc","0",1,"L");

$pdf->Cell(190,1,"                          ","0",1,"L");

$pdf->Cell(43,5," ","0",0,"L");$pdf->Cell(45,5,"$fir_ftel","0",0,"L");$pdf->Cell(48,5,"$fir_ffax","0",0,"L");$pdf->Cell(0,5,"$fir_fem1","0",1,"L");

$pdf->Cell(190,5,"                          ","0",1,"L");

$pdf->Cell(43,5," ","0",0,"L");$pdf->Cell(65,5,"$fir_fnb1","0",0,"L");$pdf->Cell(52,5,"$fir_fuc1","0",0,"L");$pdf->Cell(48,5,"$fir_fnm1","0",1,"L");


$pdf->Cell(190,8,"                          ","0",1,"L");


$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(23,5," ","0",0,"R");$pdf->Cell(49,5,"$hlavicka->pzam_celk","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(81,5,"","0",0,"L");$pdf->Cell(72,5,"$hlavicka->pzam_zp","0",0,"R");$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->pdni_zp","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->zcel_zp","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->zzam_zp","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,7," ","0",0,"L");$pdf->Cell(81,7,"","0",0,"L");$pdf->Cell(33,7," ","0",0,"R");$pdf->Cell(39,7,"$hlavicka->ofir_zp","0",0,"R");$pdf->Cell(20,7," ","0",1,"L");
$pdf->Cell(17,7," ","0",0,"L");$pdf->Cell(81,7,"","0",0,"L");$pdf->Cell(33,7," ","0",0,"R");$pdf->Cell(39,7,"$hlavicka->ozam_zp","0",0,"R");$pdf->Cell(20,7," ","0",1,"L");
$pdf->Cell(17,7," ","0",0,"L");$pdf->Cell(81,7,"","0",0,"L");$pdf->Cell(72,7,"$hlavicka->ofir_gf","0",0,"R");$pdf->Cell(20,7," ","0",1,"L");
$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->pzam_zpn","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->pdni_zpn","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->zcel_zpn","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->zzam_np","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");
$pdf->Cell(17,8," ","0",0,"L");$pdf->Cell(81,8,"","0",0,"L");$pdf->Cell(33,8," ","0",0,"R");$pdf->Cell(39,8,"$hlavicka->ofir_np","0",0,"R");$pdf->Cell(20,8," ","0",1,"L");
$pdf->Cell(17,8," ","0",0,"L");$pdf->Cell(81,8,"","0",0,"L");$pdf->Cell(33,8," ","0",0,"R");$pdf->Cell(39,8,"$hlavicka->ozam_np","0",0,"R");$pdf->Cell(20,8," ","0",1,"L");
$pdf->Cell(17,8," ","0",0,"L");$pdf->Cell(81,8,"","0",0,"L");$pdf->Cell(72,8,"$hlavicka->ofir_rf","0",0,"R");$pdf->Cell(20,8," ","0",1,"L");
$pdf->Cell(20,3," ","0",1,"L");
$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(81,6,"","0",0,"L");$pdf->Cell(72,6,"$hlavicka->celk_spolu","0",0,"R");$pdf->Cell(20,6," ","0",1,"L");


$pdf->Cell(190,10,"                          ","0",1,"L");
$pdf->Cell(45,6,"  ","0",0,"L");$pdf->Cell(53,6,"  ","0",0,"L");$pdf->Cell(45,6,"  ","0",0,"L");$pdf->Cell(47,6,"  ","0",1,"L");


$pdf->SetY(245);
$pdf->SetFont('arial','',8);
$pdf->Cell(31,4," ","0",0,"L");$pdf->Cell(38,4,"$fir_mzdt05","0",0,"L");$pdf->Cell(60,4,"$fir_mzdt04","0",1,"L");

$pdf->SetY(44);
$akyvyk="N";
if( $h_oprav == 1 ) $akyvyk="O";
$pdf->Cell(171,5," ","0",0,"L");$pdf->Cell(4,5,"$akyvyk","0",1,"L");

          }
//koniec doveramesacny max2=0



//dovera a apolo spojene mesacny max2=1
if ( $cislo_zdrv >= 2300 AND $cislo_zdrv <= 2499 AND $max2 == 1  )
          {
$nebolaziadna=0;
$rmc=0;

if (File_Exists ('../dokumenty/zdravpoist/dovera2010/mesacny_vykaz_max2.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/zdravpoist/dovera2010/mesacny_vykaz_max2.jpg',20,12,170,275); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',9);

$pdf->Cell(193,13,"                          ","$rmc",1,"L");


$A=substr($cislo_zdrv,0,1);
$B=substr($cislo_zdrv,1,1);
$C=substr($cislo_zdrv,2,1);
$D=substr($cislo_zdrv,3,1);

$pdf->Cell(154,4," ","$rmc",0,"L");$pdf->Cell(20,5,"$C$D","$rmc",0,"L");$pdf->Cell(4,5," ","$rmc",1,"L");

$pdf->Cell(195,1,"                          ","$rmc",1,"L");

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

$pdf->SetFont('arial','',9);
$pdf->Cell(148,6," ","$rmc",0,"L");$pdf->Cell(3,6,"$A","$rmc",0,"C");$pdf->Cell(3,6,"$B","$rmc",0,"C");$pdf->Cell(3,6,"$C","$rmc",0,"C");
$pdf->Cell(3,6,"$D","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(3,6,"$F","$rmc",0,"C");
$pdf->Cell(3,6,"$G","$rmc",0,"C");$pdf->Cell(3,6,"$H","$rmc",0,"C");$pdf->Cell(3,6,"$I","$rmc",0,"C");$pdf->Cell(3,6,"$J","$rmc",1,"C");

$pdf->Cell(190,13,"                          ","$rmc",1,"L");

$obdobie=$kli_vmes;
if( $obdobie < 10 ) $obdobie= '0'.$obdobie;
$A=substr($obdobie,0,1);
$B=substr($obdobie,1,1);

$pdf->Cell(47,5," ","$rmc",0,"L");$pdf->Cell(4,5,"$A","$rmc",0,"L");$pdf->Cell(4,5,"$B","$rmc",0,"L");

$robdobie=$kli_vrok;
$A=substr($robdobie,0,1);
$B=substr($robdobie,1,1);
$C=substr($robdobie,2,1);
$D=substr($robdobie,3,1);

$pdf->Cell(1,5," ","$rmc",0,"L");$pdf->Cell(4,5,"$A","$rmc",0,"L");$pdf->Cell(4,5,"$B","$rmc",0,"L");$pdf->Cell(4,5,"$C","$rmc",0,"L");$pdf->Cell(4,5,"$D","$rmc",0,"L");
$pdf->Cell(90,5,"","$rmc",0,"L");$pdf->Cell(0,5,"$fir_mzdx06.","$rmc",1,"L");



$pdf->Cell(190,10,"                          ","$rmc",1,"L");

$pdf->Cell(50,5," ","$rmc",0,"L");$pdf->Cell(80,5,"$fir_fnaz","$rmc",0,"L");
$pdf->Cell(20,5,"","$rmc",0,"L");$pdf->Cell(0,5,"$fir_uctt02","$rmc",1,"L");


$pdf->Cell(190,7,"                          ","$rmc",1,"L");


$pdf->Cell(98,5," ","$rmc",0,"L");$pdf->Cell(37,5,"$fir_fdic","$rmc",0,"L");$pdf->Cell(40,5,"$fir_fico","$rmc",1,"L");


$pdf->Cell(190,2,"                          ","$rmc",1,"L");

$pdf->Cell(43,5," ","$rmc",0,"L");$pdf->Cell(85,5,"$fir_fmes","$rmc",0,"L");$pdf->Cell(30,5,"$fir_fuli","$rmc",0,"L");$pdf->Cell(0,5," ","$rmc",1,"L");



$pdf->Cell(43,5," ","$rmc",0,"L");$pdf->Cell(85,5,"$fir_fcdm","$rmc",0,"L");$pdf->Cell(13,5,"$fir_fpsc","$rmc",0,"L");

$stat="SR";
//ak FO
if( $fir_uctt03 == 999 ) 
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";
 
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
 
$stat = $fir_riadok->xstat;
}
//ak PO
if( $fir_uctt03 != 999 ) 
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_po ";
 
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
 
$stat = $fir_riadok->xstat;
}

$pdf->Cell(9,5," ","$rmc",0,"L");$pdf->Cell(29,5,"$stat","$rmc",1,"L");


$pdf->Cell(190,7,"                          ","$rmc",1,"L");


//celkovy pocet poistenych vo vsetkych ZP
$pocetpoistenychcelkom=0;
$sqldokx = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume AND zdrv > 0 AND zpnie = 0 ";
$sqlx = mysql_query("$sqldokx");
$pocetpoistenychcelkom=1*mysql_num_rows($sqlx);
if( $pocetpoistenychcelkom == 0 ) { $pocetpoistenychcelkom=$hlavicka->pzam_celk; }

$pdf->Cell(23,5," ","$rmc",0,"L");$pdf->Cell(81,5,"","$rmc",0,"L");$pdf->Cell(23,5," ","$rmc",0,"R");$pdf->Cell(49,5,"$hlavicka->pzam_celk","$rmc",0,"R");$pdf->Cell(20,5," ","$rmc",1,"L");
$pdf->Cell(23,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(23,6," ","$rmc",0,"R");$pdf->Cell(49,6,"$pocetpoistenychcelkom","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");

$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(23,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->pzam_zp","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(23,7," ","$rmc",0,"L");$pdf->Cell(81,7,"","$rmc",0,"L");$pdf->Cell(72,7,"$hlavicka->pdni_zp","$rmc",0,"R");$pdf->Cell(20,7," ","$rmc",1,"L");
$pdf->Cell(23,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->zcel_zp","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(23,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->zzam_zp","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(23,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(33,6," ","$rmc",0,"R");$pdf->Cell(39,6,"$hlavicka->ofir_zp","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(23,7," ","$rmc",0,"L");$pdf->Cell(81,7,"","$rmc",0,"L");$pdf->Cell(33,7," ","$rmc",0,"R");$pdf->Cell(39,7,"$hlavicka->ozam_zp","$rmc",0,"R");$pdf->Cell(20,7," ","$rmc",1,"L");
$pdf->Cell(23,7," ","$rmc",0,"L");$pdf->Cell(81,7,"","$rmc",0,"L");$pdf->Cell(72,7,"$hlavicka->ofir_gf","$rmc",0,"R");$pdf->Cell(20,7," ","$rmc",1,"L");
$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(23,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->pzam_zpn","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(23,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->pdni_zpn","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(23,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->zcel_zpn","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(23,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->zzam_np","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(23,7," ","$rmc",0,"L");$pdf->Cell(81,7,"","$rmc",0,"L");$pdf->Cell(33,7," ","$rmc",0,"R");$pdf->Cell(39,7,"$hlavicka->ofir_np","$rmc",0,"R");$pdf->Cell(20,7," ","$rmc",1,"L");
$pdf->Cell(23,8," ","$rmc",0,"L");$pdf->Cell(81,8,"","$rmc",0,"L");$pdf->Cell(33,8," ","$rmc",0,"R");$pdf->Cell(39,8,"$hlavicka->ozam_np","$rmc",0,"R");$pdf->Cell(20,8," ","$rmc",1,"L");
$pdf->Cell(23,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->ofir_rf","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");
$pdf->Cell(20,1," ","$rmc",1,"L");
$pdf->Cell(23,6," ","$rmc",0,"L");$pdf->Cell(81,6,"","$rmc",0,"L");$pdf->Cell(72,6,"$hlavicka->celk_spolu","$rmc",0,"R");$pdf->Cell(20,6," ","$rmc",1,"L");


$pdf->Cell(190,10,"                          ","$rmc",1,"L");
$pdf->Cell(45,6,"  ","$rmc",0,"L");$pdf->Cell(53,6,"  ","$rmc",0,"L");$pdf->Cell(45,6,"  ","$rmc",0,"L");$pdf->Cell(47,6,"  ","$rmc",1,"L");

//vyplnil
$pdf->SetY(223);
$pdf->SetFont('arial','',8);
$pdf->Cell(31,4," ","$rmc",0,"L");$pdf->Cell(38,4,"$fir_mzdt05","$rmc",0,"L");$pdf->Cell(80,4,"$fir_mzdt04","$rmc",0,"L");$pdf->Cell(60,4,"$fir_fem1","$rmc",1,"L");

//druh vykazu
$pdf->SetY(37);
$akyvyk="N";
if( $h_oprav == 1 ) $akyvyk="O";
$pdf->Cell(171,5," ","$rmc",0,"L");$pdf->Cell(4,5,"$akyvyk","$rmc",1,"L");


//vytlac prilohu 2 zamestnancov
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


$porcislo=1;
$pdf->SetFont('arial','',9);

$cislopoistenca=$hlavicka->rdc." ".$hlavicka->rdk;

//ak zahranicny v dovere daj cislo do doplnujucich udajov
$cislozp=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $hlavicka->oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislozp=1*$riaddok->cszp;
  }
if( $cislozp > 0 ) { $cislopoistenca=$cislozp; }


if( $ip == 0 ) $pdf->SetY(255);
if( $ip == 1 ) $pdf->SetY(261);

$pdf->Cell(19,5," ","$rmc",0,"R");
$pdf->Cell(33,5,"$cislopoistenca","$rmc",0,"L");

if( $hlavicka->znizp == 0 )
{
$pdf->Cell(1,5,"$hlavicka->pdni_zp","$rmc",0,"R");
$pdf->Cell(20,5,"$hlavicka->zcel_zp","$rmc",0,"R");$pdf->Cell(20,5,"$hlavicka->zzam_zp","$rmc",0,"R");
$pdf->Cell(15,5,"$fir_zp","$rmc",0,"R");$pdf->Cell(10,5,"$zam_zp","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->ofir_zp","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->ozam_zp","$rmc",0,"R");
$pdf->Cell(17,5,"$hlavicka->ofir_gf","$rmc",0,"R");
$pdf->Cell(5,5,"                          ","$rmc",1,"L");
}

if( $hlavicka->znizp != 0 )
{
$pdf->Cell(1,5,"$hlavicka->pdni_zpn","$rmc",0,"R");
$pdf->Cell(20,5,"$hlavicka->zcel_zpn","$rmc",0,"R");$pdf->Cell(20,5,"$hlavicka->zzam_np","$rmc",0,"R");
$pdf->Cell(15,5,"$fir_zpn","$rmc",0,"R");$pdf->Cell(10,5,"$zam_zpn","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->ofir_np","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->ozam_np","$rmc",0,"R");
$pdf->Cell(17,5,"$hlavicka->ofir_rf","$rmc",0,"R");
$pdf->Cell(5,5,"                          ","$rmc",1,"L");
}

  }
$ip = $ip + 1;
    }
//koniec prilohy 



          }
//koniec doveramesacny max2=1

//ina ako vseobecna zdravotna,apollo,union,szp,dovera
if ( $nebolaziadna == 1 )
          {

$pdf->SetY(10);
$pdf->SetFont('arial','',12);
$obdobie=$kli_vume*10000;
if( $obdobie < 102009 ) $obdobie= "0".$obdobie;

$pdf->Cell(190,7,"                          ","1",1,"L");
$pdf->Cell(127,5,"$nazzdrv","1",0,"C");
$pdf->SetFont('arial','',8);
$pdf->Cell(30,5,"kÛd poisùovne","1",0,"R");
$pdf->SetFont('arial','',12);
$pdf->Cell(15,5,"$cislo_zdrv","1",0,"L");$pdf->Cell(18,5,"","1",1,"L");

$pdf->Cell(190,12,"                          ","LR",1,"L");
$pdf->Cell(142,5,"V˝kaz preddavkov na poistnÈ na verejnÈ zdravotnÈ poistenie","L",0,"L");$pdf->Cell(48,5," ","R",1,"R");
$pdf->SetFont('arial','',8);
$pdf->Cell(75,5,"PRV¡ »ASç","L",0,"L");$pdf->Cell(50,5," ","0",0,"L");$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(48,5,"ËÌslo platiteæa","1",1,"L");
$pdf->SetFont('arial','',12);
$pdf->Cell(75,6," ","L",0,"L");$pdf->Cell(50,6," ","0",0,"L");$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(48,6,"$platitel","1",1,"L");
$pdf->Cell(190,2,"                          ","LR",1,"L");

$pdf->SetFont('arial','',8);
$pdf->Cell(30,6,"za obdobie","1",0,"L");
$pdf->SetFont('arial','',12);
$pdf->Cell(60,6,"$obdobie","1",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(60,6,"deÚ urËen˝ na v˝platu prÌjmov","1",0,"L");$pdf->Cell(40,6," ","1",1,"L");

$pdf->Cell(190,8,"˙daje o platiteæovi","1",1,"L");
$pdf->Cell(40,6,"obchodnÈ meno","L",0,"L");
$pdf->SetFont('arial','',12);
$pdf->Cell(90,6,"$fir_fnaz","R",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(20,6,"pr·vna forma","L",0,"L");$pdf->Cell(40,6," ","R",1,"L");
$pdf->Cell(40,6," ","L",0,"L");
$pdf->SetFont('arial','',12);
$pdf->Cell(90,6," ","R",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(20,6," ","L",0,"L");$pdf->Cell(40,6," ","R",1,"L");

$pdf->Cell(15,4," ","LT",0,"L");$pdf->Cell(40,4,"rodnÈ ËÌslo","T",0,"L");$pdf->Cell(45,4,"ËÌslo povolenia k pobytu","T",0,"L");
$pdf->Cell(45,4,"DI»","T",0,"L");$pdf->Cell(45,4,"I»O","TR",1,"L");
$pdf->SetFont('arial','',12);
$pdf->Cell(15,5," ","L",0,"L");$pdf->Cell(40,5," ","1",0,"L");$pdf->Cell(45,5," ","0",0,"L");
$pdf->Cell(45,5,"$fir_fdic","1",0,"L");$pdf->Cell(45,5,"$fir_fico","1",1,"L");

$pdf->SetFont('arial','',8);
$pdf->Cell(35,6,"SÌdlo obec","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(35,6,"$fir_fmes","1",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(20,6,"ulica","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(65,6,"$fir_fuli","1",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(35,6," ","R",1,"L");

$pdf->Cell(35,5,"s˙pisnÈ ËÌslo","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(35,5,"$fir_fcdm","1",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(20,5,"ËÌslo","1",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(21,5,"psË","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(20,5,"$fir_fpsc","1",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(11,5,"öt·t","1",0,"L");$pdf->Cell(48,5," ","1",1,"L");

$pdf->Cell(35,5,"telefÛn","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(35,5,"$fir_ftel","1",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(20,5,"fax","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(41,5,"$fir_ffax","1",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(11,5,"e-mail","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(48,5,"$fir_fem1","1",1,"L");

$pdf->SetFont('arial','',8);
$pdf->Cell(78,5,"n·zov banky alebo poboËky zahr.banky","L",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(64,5,"$fir_fnb1","0",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(48,5," ","R",1,"L");

$pdf->Cell(35,4,"","LT",0,"L");
$pdf->Cell(43,4,"predËÌslie ˙Ëtu","T",0,"L");
$pdf->Cell(64,4,"ËÌslo ˙Ëtu","T",0,"L");
$pdf->Cell(48,4,"kÛd banky","RT",1,"L");

$pdf->SetFont('arial','',9);
$pdf->Cell(35,5,"","1",0,"L");$pdf->Cell(43,5,"","1",0,"L");$pdf->Cell(64,5,"$fir_fuc1","1",0,"L");$pdf->Cell(48,5,"$fir_fnm1","1",1,"L");

$pdf->Cell(190,5,"                          ","0",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(190,4,"˙daje o preddavkoch","1",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5,"1","1",0,"R");$pdf->Cell(81,5,"poËet prihl·sen˝ch zamestnancov","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(23,5," ","1",0,"R");$pdf->Cell(49,5,"$hlavicka->pzam_celk","LTB",0,"R");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5," ","1",0,"R");$pdf->Cell(81,5,"poistenci bez zdravotnÈho postihnutia","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(72,5," ","LTB",0,"L");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5,"2","1",0,"R");$pdf->Cell(81,5,"poËet zamestnancov, za ktor˝ch sa platÌ preddavok","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(72,5,"$hlavicka->pzam_zp","LTB",0,"R");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5,"3","1",0,"R");$pdf->Cell(81,5,"poËet kalend·rnych dnÌ, za ktorÈ sa platÌ preddavok","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(72,5,"$hlavicka->pdni_zp","LTB",0,"R");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5,"4","1",0,"R");$pdf->Cell(81,5,"celkov˝ prÌjem, ktor˝ je predmetom v˝poËtu VZ v Ä","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(72,5,"$hlavicka->zcel_zp","LTB",0,"R");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5,"5","1",0,"R");$pdf->Cell(81,5,"vymeriavacÌ z·klad podæa ß 13 v Ä","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(72,5,"$hlavicka->zzam_zp","LTB",0,"R");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5,"6","1",0,"R");$pdf->Cell(81,5,"sadzba v % / preddavok v Ä za zamestn·vateæa podæa 2.Ëasti v˝kazu","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(23,5,"$fir_zp %","1",0,"L");$pdf->Cell(49,5,"$hlavicka->ofir_zp","LTB",0,"R");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5,"7","1",0,"R");$pdf->Cell(81,5,"sadzba v % / preddavok v Ä za zamestnancov podæa 2.Ëasti v˝kazu","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(23,5,"$zam_zp %","1",0,"L");$pdf->Cell(49,5,"$hlavicka->ozam_zp","LTB",0,"R");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5,"8","1",0,"R");$pdf->Cell(81,5,"celkov· suma preddavku (r.6 a r.7)","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(72,5,"$hlavicka->ofir_gf","LTB",0,"R");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5," ","1",0,"R");$pdf->Cell(81,5,"poistenci so zdravotn˝m postihnutÌm","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(72,5," ","LTB",0,"L");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5,"9","1",0,"R");$pdf->Cell(81,5,"poËet zamestnancov, za ktor˝ch sa platÌ preddavok","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(72,5,"$hlavicka->pzam_zpn","LTB",0,"R");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5,"10","1",0,"R");$pdf->Cell(81,5,"poËet kalend·rnych dnÌ, za ktorÈ sa platÌ preddavok","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(72,5,"$hlavicka->pdni_zpn","LTB",0,"R");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5,"11","1",0,"R");$pdf->Cell(81,5,"celkov˝ prÌjem, ktor˝ je predmetom v˝poËtu VZ v Ä","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(72,5,"$hlavicka->zcel_zpn","LTB",0,"R");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5,"12","1",0,"R");$pdf->Cell(81,5,"vymeriavacÌ z·klad podæa ß 13 v Ä","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(72,5,"$hlavicka->zzam_np","LTB",0,"R");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5,"13","1",0,"R");$pdf->Cell(81,5,"sadzba v % / preddavok v Ä za zamestn·vateæa podæa 2.Ëasti v˝kazu","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(23,5,"$fir_zpn %","1",0,"L");$pdf->Cell(49,5,"$hlavicka->ofir_np","LTB",0,"R");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5,"14","1",0,"R");$pdf->Cell(81,5,"sadzba v % / preddavok v Ä za zamestnancov podæa 2.Ëasti v˝kazu","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(23,5,"$zam_zpn %","1",0,"L");$pdf->Cell(49,5,"$hlavicka->ozam_np","LTB",0,"R");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(17,5,"15","1",0,"R");$pdf->Cell(81,5,"celkov· suma preddavku (r.13 a r.14)","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(72,5,"$hlavicka->ofir_rf","LTB",0,"R");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',7);
$pdf->Cell(190,6,"                          ","1",1,"L");
$pdf->Cell(17,5,"16","1",0,"R");$pdf->Cell(81,5,"Preddavok spolu v Ä (r.8 a r.15)","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(72,5,"$hlavicka->celk_spolu","LTB",0,"R");$pdf->Cell(20,5," ","RTB",1,"L");

$pdf->SetFont('arial','',8);
$pdf->Cell(190,10,"                          ","0",1,"L");
$pdf->Cell(45,5,"vyplnil","LT",0,"L");$pdf->Cell(53,5,"telefÛn","T",0,"L");$pdf->Cell(45,5,"dÚa","T",0,"L");$pdf->Cell(47,5,"poËet str·n prÌlohy","RT",1,"L");
$pdf->Cell(190,7,"                          ","LRB",1,"L");

$pdf->Cell(190,13,"                          ","0",1,"L");

$pdf->Cell(98,13,"","LT",0,"L");$pdf->Cell(92,13,"","LRT",1,"L");
$pdf->Cell(98,5,"d·tum","LB",0,"L");$pdf->Cell(92,5,"d·tum evidencie","LRB",1,"L");

          }
//koniec ina ako vseobecna zdravotna, apollo,union,szp,dovera



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
if( $copern == 20 )
{

if (File_Exists ("../tmp/prilohaSP.$kli_uzid.pdf")) { $soubor = unlink("../tmp/prilohaSP.$kli_uzid.pdf"); }

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

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE konx = 0 AND xdrv = $cislo_zdrv ORDER BY konx,rdc";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$nebolaziadna=1;

//vseobecna zdravotna
if ( $cislo_zdrv >= 2500 AND $cislo_zdrv <= 2599 )
          {
$nebolaziadna=0;


$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(20);

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
if( $i != 0 )
                 {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(20);
                 }

if (File_Exists ('../dokumenty/zdravpoist/zp2508/priloha_mesacny_vykaz.jpg') AND $j == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/zdravpoist/zp2508/priloha_mesacny_vykaz.jpg',0,0,210,094); }
}

$pdf->SetY(28);
$pdf->SetFont('arial','',12);

//typ prÌlohy (N,O,A)
$pdf->Cell(190,6,"                          ","0",1,"L");
$pdf->Cell(140,6," ","0",0,"R");$pdf->Cell(5,7," ","0",0,"L");

$obdobie=$kli_vume*10000;
if( $obdobie < 102009 ) $obdobie= "0".$obdobie;
$pdf->Cell(190,12,"                          ","0",1,"L");
$pdf->Cell(27,5," ","0",0,"L");$pdf->Cell(62,6,"$obdobie","0",0,"L");$pdf->Cell(60,5," ","0",1,"L");
$pdf->Cell(190,10,"                          ","0",1,"L");
$pdf->Cell(25,5," ","0",0,"L");$pdf->Cell(111,7,"$fir_fnaz","0",1,"L");
$pdf->Cell(190,-3,"                          ","0",1,"L");
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);
$pdf->Cell(144,6," ","0",0,"R");$pdf->Cell(4,6,"$A","0",0,"C");$pdf->Cell(4,6,"$B","0",0,"C");$pdf->Cell(3,6,"$C","0",0,"C");
$pdf->Cell(4,6,"$D","0",0,"C");$pdf->Cell(4,6,"$E","0",0,"R");$pdf->Cell(3,6,"$F","0",0,"C");$pdf->Cell(4,6,"$G","0",0,"C");
$pdf->Cell(3,6,"$H","0",1,"C");

$pdf->Cell(190,25,"                          ","0",1,"L");
             }
//koniec hlavicky

//telo polozky
$porcislo=$i+1;
$pdf->SetFont('arial','',9);

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


if( $hlavicka->znizp == 0 )
{
if( $ajmeno == 0 )
  {
$pdf->Cell(17,5," ","0",0,"R");$pdf->Cell(32,5,"$cislopoistenca","0",0,"L");
  }
if( $ajmeno == 1 )
  {
$pdf->SetFont('arial','',7);
$pdf->Cell(49,5,"$cislopoistenca $hlavicka->prie $hlavicka->meno osË$hlavicka->oc","0",0,"L");
$pdf->SetFont('arial','',9);
  }

$fir_zptlac=$fir_zp;
$zam_zptlac=$zam_zp;
if( $hlavicka->pom == 14 ) { $fir_zptlac=0; $zam_zptlac=0; }

$pdf->Cell(8,5,"$hlavicka->pdni_zp","0",0,"R");
$pdf->Cell(24,5,"$hlavicka->zcel_zp","0",0,"R");$pdf->Cell(20,5,"$hlavicka->zzam_zp","0",0,"R");
$pdf->Cell(10,5,"$fir_zptlac","0",0,"R");$pdf->Cell(10,5,"$zam_zptlac","0",0,"R");
$pdf->Cell(19,5,"$hlavicka->ofir_zp","0",0,"R");$pdf->Cell(19,5,"$hlavicka->ozam_zp","0",0,"R");
$pdf->Cell(20,5,"$hlavicka->ofir_gf","0",0,"R");
$pdf->Cell(11,5,"                          ","0",1,"L");
}

if( $hlavicka->znizp != 0 )
{
if( $ajmeno == 0 )
  {
$pdf->Cell(17,5," ","0",0,"R");$pdf->Cell(32,5,"$cislopoistenca","0",0,"L");
  }
if( $ajmeno == 1 )
  {
$pdf->SetFont('arial','',7);
$pdf->Cell(49,5,"$cislopoistenca $hlavicka->prie $hlavicka->meno osË$hlavicka->oc","0",0,"L");
$pdf->SetFont('arial','',9);
  }
$pdf->Cell(8,5,"$hlavicka->pdni_zpn","0",0,"R");
$pdf->Cell(24,5,"$hlavicka->zcel_zpn","0",0,"R");$pdf->Cell(20,5,"$hlavicka->zzam_np","0",0,"R");
$pdf->Cell(10,5,"$fir_zpn","0",0,"R");$pdf->Cell(10,5,"$zam_zpn","0",0,"R");
$pdf->Cell(19,5,"$hlavicka->ofir_np","0",0,"R");$pdf->Cell(19,5,"$hlavicka->ozam_np","0",0,"R");
$pdf->Cell(20,5,"$hlavicka->ofir_rf","0",0,"R");
$pdf->Cell(11,5,"                          ","0",1,"L");
}

if( $j == 4 OR $j == 8 OR $j == 12 OR $j == 16 ) $pdf->Cell(190,1,"                          ","0",1,"L");

//koniec tela polozky

}
$i = $i + 1;
$j = $j + 1;

if( $j == 20 )
{

$j=0;
$pdf->SetY(201);
$pdf->Cell(190,10,"                          ","0",1,"L");
$pdf->Cell(45,5,"  ","0",0,"L");$pdf->Cell(53,5,"  ","0",0,"L");$pdf->Cell(45,5,"  ","0",0,"L");$pdf->Cell(47,5,"  ","0",1,"L");

$pdf->Cell(190,17,"                          ","0",1,"L");
$pdf->Cell(98,5,"  ","0",0,"L");$pdf->Cell(92,5,"  ","0",1,"L");

$pdf->Cell(190,2,"                          ","0",1,"L");


$pdf->Cell(45,5,"  ","0",0,"L");$pdf->Cell(53,5,"  ","0",0,"L");$pdf->Cell(45,5,"  ","0",0,"L");$pdf->Cell(47,5,"  ","0",1,"L");

$pdf->Cell(190,17,"                          ","0",1,"L");
$pdf->Cell(98,5,"  ","0",0,"L");$pdf->Cell(92,5,"  ","0",1,"L");

$pdf->SetY(221);
$pdf->SetFont('arial','',8);
$pdf->Cell(14,4," ","0",0,"L");$pdf->Cell(50,4,"$fir_mzdt05","0",1,"L");

$pdf->SetY(34);
$akyvyk="N";
if( $h_oprav == 1 ) $akyvyk="O";
$pdf->Cell(141,5," ","0",0,"L");$pdf->Cell(4,5,"$akyvyk","0",1,"L");

}

  }

$pdf->SetY(201);
$pdf->Cell(190,10,"                          ","0",1,"L");
$pdf->Cell(45,5,"  ","0",0,"L");$pdf->Cell(53,5,"  ","0",0,"L");$pdf->Cell(45,5,"  ","0",0,"L");$pdf->Cell(47,5,"  ","0",1,"L");

$pdf->Cell(190,17,"                          ","0",1,"L");
$pdf->Cell(98,5,"  ","0",0,"L");$pdf->Cell(92,5,"  ","0",1,"L");

$pdf->Cell(190,2,"                          ","0",1,"L");


$pdf->Cell(45,5,"  ","0",0,"L");$pdf->Cell(53,5,"  ","0",0,"L");$pdf->Cell(45,5,"  ","0",0,"L");$pdf->Cell(47,5,"  ","0",1,"L");

$pdf->Cell(190,17,"                          ","0",1,"L");
$pdf->Cell(98,5,"  ","0",0,"L");$pdf->Cell(92,5,"  ","0",1,"L");

$pdf->SetY(221);
$pdf->SetFont('arial','',8);
$pdf->Cell(14,4," ","0",0,"L");$pdf->Cell(50,4,"$fir_mzdt05","0",1,"L");

$pdf->SetY(34);
$akyvyk="N";
if( $h_oprav == 1 ) $akyvyk="O";
$pdf->Cell(141,5," ","0",0,"L");$pdf->Cell(4,5,"$akyvyk","0",1,"L");

//koniec vseobecna zdravotna
          }





//spolocna ZP priloha
if ( $cislo_zdrv >= 2100 AND $cislo_zdrv <= 2199 )
          {
$nebolaziadna=0;


/////////////NACITANIE CISLA PLATITELA,NAZVU Z CISELNIKA ZP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv=$cislo_zdrv ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $platitel=$riaddok->vsy;
  $nazzdrv=$riaddok->nzdr;
  }

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(20);

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
if( $i != 0 )
                 {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(20);
                 }

if (File_Exists ('../dokumenty/zdravpoist/zp2108/priloha_mesacny_vykaz.jpg') AND $j == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/zdravpoist/zp2108/priloha_mesacny_vykaz.jpg',0,0,210,094); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',12);


$pdf->Cell(190,28,"                          ","0",1,"L");

$A=substr($cislo_zdrv,0,1);
$B=substr($cislo_zdrv,1,1);
$C=substr($cislo_zdrv,2,1);
$D=substr($cislo_zdrv,3,1);

$pdf->Cell(143,5," ","0",0,"L");$pdf->Cell(4,5,"$C","0",0,"L");$pdf->Cell(4,5,"$D","0",1,"L");
$pdf->Cell(190,1,"                          ","0",1,"L");
$pdf->Cell(143,5," ","0",0,"L");

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

$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");
$pdf->Cell(4,5,"$D","0",0,"C");$pdf->Cell(1,5," ","0",0,"C");
$pdf->Cell(4,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");$pdf->Cell(4,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",0,"C");$pdf->Cell(1,5," ","0",0,"C");
$pdf->Cell(4,5,"$I","0",0,"C");$pdf->Cell(4,5,"$J","0",0,"C");$pdf->Cell(1,5," ","0",1,"C");

$obdobie=$kli_vmes;
if( $obdobie < 10 ) $obdobie= "0".$obdobie;
$A=substr($obdobie,0,1);
$B=substr($obdobie,1,1);

$pdf->Cell(190,20,"                          ","0",1,"L");
$pdf->Cell(27,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"L");$pdf->Cell(4,5,"$B","0",0,"L");
$pdf->Cell(2,5," ","0",0,"L");

$robdobie=$kli_vrok;
$A=substr($robdobie,0,1);
$B=substr($robdobie,1,1);
$C=substr($robdobie,2,1);
$D=substr($robdobie,3,1);

$pdf->Cell(4,5,"$A","0",0,"L");$pdf->Cell(4,5,"$B","0",0,"L");$pdf->Cell(4,5,"$C","0",0,"L");$pdf->Cell(4,5,"$D","0",1,"L");

$pdf->Cell(190,9,"                          ","0",1,"L");
$pdf->Cell(20,5," ","0",0,"L");$pdf->Cell(131,5,"$fir_fnaz","0",0,"L");

$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);
$I=substr($fir_fico,8,1);
$J=substr($fir_fico,9,1);

$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(1,5," ","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");
$pdf->Cell(4,5,"$D","0",0,"C");$pdf->Cell(1,5," ","0",0,"C");
$pdf->Cell(4,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");$pdf->Cell(4,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",0,"C");$pdf->Cell(1,5," ","0",1,"C");

$pdf->Cell(190,19,"                          ","0",1,"L");
             }
//koniec hlavicky

//telo polozky
$porcislo=$i+1;
$pdf->SetFont('arial','',9);


$A=substr($hlavicka->rdc,0,1);
$B=substr($hlavicka->rdc,1,1);
$C=substr($hlavicka->rdc,2,1);
$D=substr($hlavicka->rdc,3,1);
$E=substr($hlavicka->rdc,4,1);
$F=substr($hlavicka->rdc,5,1);
$G=substr($hlavicka->rdk,0,1);
$H=substr($hlavicka->rdk,1,1);
$I=substr($hlavicka->rdk,2,1);
$J=substr($hlavicka->rdk,3,1);

$pdf->Cell(10,5," ","0",0,"R");
$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(1,5," ","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");
$pdf->Cell(4,5,"$D","0",0,"C");$pdf->Cell(1,5," ","0",0,"C");
$pdf->Cell(4,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");$pdf->Cell(4,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",0,"C");$pdf->Cell(1,5," ","0",0,"C");$pdf->Cell(4,5,"$I","0",0,"C");$pdf->Cell(4,5,"$J","0",0,"C");


if( $hlavicka->znizp == 0 )
{
$pdf->Cell(12,5,"$hlavicka->pdni_zp","0",0,"R");
$pdf->Cell(23,5,"$hlavicka->zcel_zp","0",0,"R");$pdf->Cell(20,5,"$hlavicka->zzam_zp","0",0,"R");
$pdf->Cell(14,5,"$fir_zp","0",0,"R");$pdf->Cell(14,5,"$zam_zp","0",0,"R");
$pdf->Cell(15,5,"$hlavicka->ofir_zp","0",0,"R");$pdf->Cell(14,5,"$hlavicka->ozam_zp","0",0,"R");
$pdf->Cell(20,5,"$hlavicka->ofir_gf","0",0,"R");
$pdf->Cell(5,5,"                          ","0",1,"L");

}

if( $hlavicka->znizp != 0 )
{
$pdf->Cell(12,5,"$hlavicka->pdni_zpn","0",0,"R");
$pdf->Cell(23,5,"$hlavicka->zcel_zpn","0",0,"R");$pdf->Cell(20,5,"$hlavicka->zzam_np","0",0,"R");
$pdf->Cell(14,5,"$fir_zpn","0",0,"R");$pdf->Cell(14,5,"$zam_zpn","0",0,"R");
$pdf->Cell(15,5,"$hlavicka->ofir_np","0",0,"R");$pdf->Cell(14,5,"$hlavicka->ozam_np","0",0,"R");
$pdf->Cell(20,5,"$hlavicka->ofir_rf","0",0,"R");
$pdf->Cell(5,5,"                          ","0",1,"L");

}

if( $j != 5 AND $j != 10 AND $j != 15 ) $pdf->Cell(190,1,"                          ","0",1,"L");

//koniec tela polozky

}
$i = $i + 1;
$j = $j + 1;

if( $j == 20 )
{

$j=0;
$pdf->SetY(201);
//koniec dokumentu

}

  }

$pdf->SetY(201);
//koniec dokumentu

//koniec spolocna priloha
          }

//UNION ZP priloha
if ( $cislo_zdrv >= 2700 AND $cislo_zdrv <= 2799 )
          {
$nebolaziadna=0;


/////////////NACITANIE CISLA PLATITELA,NAZVU Z CISELNIKA ZP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv=$cislo_zdrv ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $platitel=$riaddok->vsy;
  $nazzdrv=$riaddok->nzdr;
  }

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(20);

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
if( $i != 0 )
                 {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(20);
                 }

if (File_Exists ('../dokumenty/zdravpoist/zp2708/priloha_mesacny_vykaz.jpg') AND $j == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/zdravpoist/zp2708/priloha_mesacny_vykaz.jpg',0,0,210,094); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',12);


$pdf->Cell(190,42,"                          ","0",1,"L");

$obdobie=$kli_vmes;
if( $obdobie < 10 ) $obdobie= "0".$obdobie;
$A=substr($obdobie,0,1);
$B=substr($obdobie,1,1);

$pdf->Cell(12,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"L");$pdf->Cell(4,5,"$B","0",0,"L");

$robdobie=$kli_vrok;
$A=substr($robdobie,0,1);
$B=substr($robdobie,1,1);
$C=substr($robdobie,2,1);
$D=substr($robdobie,3,1);

$pdf->Cell(5,5,"$A","0",0,"L");$pdf->Cell(4,5,"$B","0",0,"L");$pdf->Cell(4,5,"$C","0",0,"L");$pdf->Cell(4,5,"$D","0",1,"L");

$pdf->Cell(190,13,"                          ","0",1,"L");
$pdf->Cell(20,5," ","0",0,"L");$pdf->Cell(131,5,"$fir_fnaz","0",1,"L");

$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);
$I=substr($fir_fico,8,1);
$J=substr($fir_fico,9,1);

$pdf->Cell(190,3," ","0",1,"L");
$pdf->Cell(151,5," ","0",0,"L");
$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");
$pdf->Cell(4,5,"$D","0",0,"C");
$pdf->Cell(5,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");$pdf->Cell(4,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",0,"C");$pdf->Cell(1,5," ","0",1,"C");

$pdf->Cell(190,22,"                          ","0",1,"L");
             }
//koniec hlavicky

//telo polozky
$porcislo=$i+1;
$pdf->SetFont('arial','',9);


if( $ajmeno == 0 )
  {
$pdf->Cell(5,6," ","0",0,"R");
$pdf->Cell(20,6,"$hlavicka->rdc $hlavicka->rdk","0",0,"C");
  }
if( $ajmeno == 1 )
  {
$pdf->SetFont('arial','',7);
$pdf->Cell(25,6,"$hlavicka->rdc $hlavicka->prie $hlavicka->meno","0",0,"C");
$pdf->SetFont('arial','',9);
  }




if( $hlavicka->znizp == 0 )
{
$pdf->Cell(9,6,"$hlavicka->pdni_zp","0",0,"R");
$pdf->Cell(23,6,"$hlavicka->zcel_zp","0",0,"R");$pdf->Cell(23,6,"$hlavicka->zzam_zp","0",0,"R");
$pdf->Cell(20,6,"$fir_zp","0",0,"R");$pdf->Cell(20,6,"$zam_zp","0",0,"R");
$pdf->Cell(25,6,"$hlavicka->ofir_zp","0",0,"R");$pdf->Cell(25,6,"$hlavicka->ozam_zp","0",0,"R");
$pdf->Cell(20,6,"$hlavicka->ofir_gf","0",0,"R");
$pdf->Cell(5,6,"                          ","0",1,"L");

}

if( $hlavicka->znizp != 0 )
{
$pdf->Cell(9,6,"$hlavicka->pdni_zpn","0",0,"R");
$pdf->Cell(23,6,"$hlavicka->zcel_zpn","0",0,"R");$pdf->Cell(23,6,"$hlavicka->zzam_np","0",0,"R");
$pdf->Cell(20,6,"$fir_zpn","0",0,"R");$pdf->Cell(20,6,"$zam_zpn","0",0,"R");
$pdf->Cell(25,6,"$hlavicka->ofir_np","0",0,"R");$pdf->Cell(25,6,"$hlavicka->ozam_np","0",0,"R");
$pdf->Cell(20,6,"$hlavicka->ofir_rf","0",0,"R");
$pdf->Cell(5,6,"                          ","0",1,"L");

}

if( $j != 5 AND $j != 10 AND $j != 15 ) $pdf->Cell(190,1,"                          ","0",1,"L");

//koniec tela polozky

}
$i = $i + 1;
$j = $j + 1;

if( $j == 20 )
{

$j=0;
$pdf->SetY(201);
//koniec dokumentu

//vyplnil a telefon
if( $fir_mzdt05 == '' ) $fir_mzdt05=$kli_uzmeno." ".$kli_uzprie;

$pdf->SetY(251);
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(40,6,"$fir_mzdt05 $fir_mzdt04","$rmc",1,"L");

$pdf->SetY(28);
$akyvyk="N";
if( $h_oprav == 1 ) $akyvyk="O";
$pdf->Cell(186,5," ","0",0,"L");$pdf->Cell(4,5,"$akyvyk","0",1,"L");

}

  }

$pdf->SetY(201);
//koniec dokumentu

//vyplnil a telefon
if( $fir_mzdt05 == '' ) $fir_mzdt05=$kli_uzmeno." ".$kli_uzprie;

$pdf->SetY(251);
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(40,6,"$fir_mzdt05 $fir_mzdt04","$rmc",1,"L");

$pdf->SetY(28);
$akyvyk="N";
if( $h_oprav == 1 ) $akyvyk="O";
$pdf->Cell(186,5," ","0",0,"L");$pdf->Cell(4,5,"$akyvyk","0",1,"L");

//koniec UNION priloha
          }


//dovera a apolo spojene ZP priloha
if ( $cislo_zdrv >= 2300 AND $cislo_zdrv <= 2499 )
          {
$nebolaziadna=0;


/////////////NACITANIE CISLA PLATITELA,NAZVU Z CISELNIKA ZP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv=$cislo_zdrv ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $platitel=$riaddok->vsy;
  $nazzdrv=$riaddok->nzdr;
  }

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(20);

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
if( $i != 0 )
                 {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(20);
                 }

if (File_Exists ('../dokumenty/zdravpoist/dovera2010/priloha_mesacny_vykaz.jpg') AND $j == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/zdravpoist/dovera2010/priloha_mesacny_vykaz.jpg',20,12,170,270); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',12);


$pdf->Cell(190,28,"                          ","0",1,"L");



$obdobie=$kli_vmes;
if( $obdobie < 10 ) $obdobie= '0'.$obdobie;
$A=substr($obdobie,0,1);
$B=substr($obdobie,1,1);

$pdf->Cell(190,4,"                          ","0",1,"L");
$pdf->Cell(45,5," ","0",0,"L");$pdf->Cell(4,5,"$A","0",0,"L");$pdf->Cell(4,5,"$B","0",0,"L");
$pdf->Cell(2,5," ","0",0,"L");

$robdobie=$kli_vrok;
$A=substr($robdobie,0,1);
$B=substr($robdobie,1,1);
$C=substr($robdobie,2,1);
$D=substr($robdobie,3,1);

$pdf->Cell(4,5,"$A","0",0,"L");$pdf->Cell(4,5,"$B","0",0,"L");$pdf->Cell(4,5,"$C","0",0,"L");$pdf->Cell(4,5,"$D","0",1,"L");

$pdf->Cell(190,11,"                          ","0",1,"L");
$pdf->Cell(20,5," ","0",0,"L");$pdf->Cell(115,5,"$fir_fnaz","0",0,"L");

$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);
$I=substr($fir_fico,8,1);
$J=substr($fir_fico,9,1);

$pdf->Cell(4,5,"$A","0",0,"C");$pdf->Cell(1,5," ","0",0,"C");$pdf->Cell(4,5,"$B","0",0,"C");$pdf->Cell(4,5,"$C","0",0,"C");
$pdf->Cell(4,5,"$D","0",0,"C");$pdf->Cell(1,5," ","0",0,"C");
$pdf->Cell(4,5,"$E","0",0,"C");$pdf->Cell(4,5,"$F","0",0,"C");$pdf->Cell(4,5,"$G","0",0,"C");
$pdf->Cell(4,5,"$H","0",0,"C");$pdf->Cell(1,5," ","0",1,"C");

$pdf->Cell(190,32,"                          ","0",1,"L");
             }
//koniec hlavicky

//telo polozky
$porcislo=$i+1;
$pdf->SetFont('arial','',9);


$cislopoistenca=$hlavicka->rdc." ".$hlavicka->rdk;

//ak zahranicny v dovera daj cislo do doplnujucich udajov
$cislozp=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $hlavicka->oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislozp=1*$riaddok->cszp;
  }
if( $cislozp > 0 ) { $cislopoistenca=$cislozp; }

if( $ajmeno == 0 )
  {
$pdf->Cell(20,5," ","0",0,"R");
$pdf->Cell(22,5,"$cislopoistenca","0",0,"L");
  }
if( $ajmeno == 1 )
  {
$pdf->SetFont('arial','',7);
$pdf->Cell(42,6,"$cislopoistenca $hlavicka->prie $hlavicka->meno","0",0,"C");
$pdf->SetFont('arial','',9);
  }




if( $hlavicka->znizp == 0 )
{
$pdf->Cell(14,5,"$hlavicka->pdni_zp","0",0,"R");
$pdf->Cell(18,5,"$hlavicka->zcel_zp","0",0,"R");$pdf->Cell(22,5,"$hlavicka->zzam_zp","0",0,"R");
$pdf->Cell(12,5,"$fir_zp","0",0,"R");$pdf->Cell(12,5,"$zam_zp","0",0,"R");
$pdf->Cell(23,5,"$hlavicka->ofir_zp","0",0,"R");$pdf->Cell(17,5,"$hlavicka->ozam_zp","0",0,"R");
$pdf->Cell(17,5,"$hlavicka->ofir_gf","0",0,"R");
$pdf->Cell(5,5,"                          ","0",1,"L");

}

if( $hlavicka->znizp != 0 )
{
$pdf->Cell(14,5,"$hlavicka->pdni_zpn","0",0,"R");
$pdf->Cell(18,5,"$hlavicka->zcel_zpn","0",0,"R");$pdf->Cell(22,5,"$hlavicka->zzam_np","0",0,"R");
$pdf->Cell(12,5,"$fir_zpn","0",0,"R");$pdf->Cell(12,5,"$zam_zpn","0",0,"R");
$pdf->Cell(23,5,"$hlavicka->ofir_np","0",0,"R");$pdf->Cell(17,5,"$hlavicka->ozam_np","0",0,"R");
$pdf->Cell(17,5,"$hlavicka->ofir_rf","0",0,"R");
$pdf->Cell(5,5,"                          ","0",1,"L");

}

if( $j != 88 ) $pdf->Cell(190,1,"                          ","0",1,"L");

//koniec tela polozky

}
$i = $i + 1;
$j = $j + 1;


if( $j == 20 )
{

$j=0;
$pdf->SetY(225);
$pdf->SetFont('arial','',9);
$pdf->Cell(15,4," ","0",0,"L");$pdf->Cell(38,4,"$fir_mzdt05 ","0",1,"L");

$pdf->SetY(31);
$akyvyk="N";
if( $h_oprav == 1 ) $akyvyk="O";
$pdf->Cell(170,5," ","0",0,"L");$pdf->Cell(4,5,"$akyvyk","0",1,"L");

}

  }

$pdf->SetY(225);
$pdf->SetFont('arial','',9);
$pdf->Cell(15,4," ","0",0,"L");$pdf->Cell(38,4,"$fir_mzdt05 ","0",1,"L");

$pdf->SetY(31);
$akyvyk="N";
if( $h_oprav == 1 ) $akyvyk="O";
$pdf->Cell(170,5," ","0",0,"L");$pdf->Cell(4,5,"$akyvyk","0",1,"L");


//koniec dovera priloha
          }


//nie vseobecna zdravotna, nie apollo , nie spolocna, nie dovera
if ( $nebolaziadna == 1 )
          {

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(20);

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
if( $i != 0 )
                 {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(20);
                 }
$pdf->SetY(10);
$pdf->SetFont('arial','',12);
$obdobie=$kli_vume*10000;
if( $obdobie < 102009 ) $obdobie= "0".$obdobie;


$pdf->Cell(190,7,"                          ","1",1,"L");
$pdf->Cell(127,5,"$nazzdrv","1",0,"C");
$pdf->SetFont('arial','',8);
$pdf->Cell(30,5," ","TB",0,"R");
$pdf->SetFont('arial','',12);
$pdf->Cell(15,5," ","TB",0,"L");$pdf->Cell(18,5,"","RTB",1,"L");

$pdf->Cell(190,12,"                          ","LR",1,"L");
$pdf->Cell(142,4,"PrÌloha k v˝kazu preddavkov na verejnÈ zdravotnÈ poistenie","L",0,"L");$pdf->Cell(48,4," ","R",1,"R");
$pdf->SetFont('arial','',8);
$pdf->Cell(75,5,"DRUH¡ »ASç","L",0,"L");$pdf->Cell(50,5," ","0",0,"L");$pdf->Cell(17,5," ","0",0,"L");$pdf->Cell(48,5," ","R",1,"L");
$pdf->SetFont('arial','',12);
$pdf->Cell(75,6," ","L",0,"L");$pdf->Cell(50,6," ","0",0,"L");$pdf->Cell(17,6," ","0",0,"L");$pdf->Cell(48,6," ","R",1,"L");
$pdf->Cell(190,2,"                          ","LR",1,"L");

$pdf->SetFont('arial','',8);
$pdf->Cell(30,6,"za obdobie","1",0,"L");
$pdf->SetFont('arial','',12);
$pdf->Cell(60,6,"$obdobie","LTB",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(60,6," ","TB",0,"L");$pdf->Cell(40,6," ","RTB",1,"L");

$pdf->Cell(190,8,"identifik·cia zamestn·vateæa","1",1,"L");


$pdf->Cell(17,5,"1.","LTR",0,"L");$pdf->Cell(17,5,"n·zov","T",0,"L");
$pdf->SetFont('arial','',12);
$pdf->Cell(90,5,"$fir_fnaz","TR",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(17,5,"2.","T",0,"L");$pdf->Cell(17,5,"I»O","T",0,"L");$pdf->Cell(32,5," ","TR",1,"L");

$pdf->Cell(17,5," ","LBR",0,"L");$pdf->Cell(17,5," ","B",0,"L");$pdf->Cell(90,5," ","B",0,"L");
$pdf->Cell(17,5," ","LB",0,"L");$pdf->Cell(3,5," ","B",0,"L");
$pdf->SetFont('arial','',12);
$pdf->Cell(46,5,"$fir_fico","1",1,"L");
$pdf->SetFont('arial','',8);

$pdf->Cell(190,10,"                          ","0",1,"L");
$pdf->Cell(190,4,"zoznam zamestnancov,vymeriavacie z·klady a preddavky","1",1,"L");

$pdf->Cell(17,5,"Por.","LRT",0,"C");$pdf->Cell(32,5," ","LRT",0,"C");$pdf->Cell(8,5,"PoË.","LRT",0,"C");
$pdf->Cell(24,5,"celkov˝","LRT",0,"C");$pdf->Cell(20,5,"vymeriavacÌ","LRT",0,"C");
$pdf->Cell(20,5,"sadzba %","LRTB",0,"C");$pdf->Cell(38,5,"suma preddavku v Ä","LRTB",0,"C");
$pdf->Cell(20,5,"preddavok","LRT",0,"C");
$pdf->Cell(11,5,"                          ","LRT",1,"C");
$pdf->Cell(17,5,"ËÌs.","LRB",0,"C");$pdf->Cell(32,5,"rodnÈ ËÌslo poistenca","LRB",0,"C");$pdf->Cell(8,5,"dnÌ","LRB",0,"C");
$pdf->Cell(24,5,"prÌjem","LRB",0,"C");$pdf->Cell(20,5,"z·klad","LRB",0,"C");
$pdf->Cell(10,5,"Ztel","LRB",0,"C");$pdf->Cell(10,5,"Znec","LRB",0,"C");$pdf->Cell(19,5,"Zamtel","LRB",0,"C");$pdf->Cell(19,5,"Zamnec","LRB",0,"C");
$pdf->Cell(20,5,"spolu","LRB",0,"C");
$pdf->Cell(11,5,"                          ","LRB",1,"C");
$pdf->Cell(190,1,"                          ","1",1,"C");
             }
//koniec hlavicky

//telo polozky
$porcislo=$i+1;
$pdf->SetFont('arial','',9);

if( $hlavicka->znizp == 0 )
{
$pdf->Cell(17,5,"$porcislo","1",0,"R");$pdf->Cell(32,5,"$hlavicka->rdc $hlavicka->rdk","1",0,"L");$pdf->Cell(8,5,"$hlavicka->pdni_zp","1",0,"R");
$pdf->Cell(24,5,"$hlavicka->zcel_zp","1",0,"R");$pdf->Cell(20,5,"$hlavicka->zzam_zp","1",0,"R");
$pdf->Cell(10,5,"$fir_zp","1",0,"R");$pdf->Cell(10,5,"$zam_zp","1",0,"R");
$pdf->Cell(19,5,"$hlavicka->ofir_zp","1",0,"R");$pdf->Cell(19,5,"$hlavicka->ozam_zp","1",0,"R");
$pdf->Cell(20,5,"$hlavicka->ofir_gf","1",0,"R");
$pdf->Cell(11,5,"                          ","1",1,"L");
}

if( $hlavicka->znizp != 0 )
{
$pdf->Cell(17,5,"$porcislo","1",0,"R");$pdf->Cell(32,5,"$hlavicka->rdc $hlavicka->rdk","1",0,"L");$pdf->Cell(8,5,"$hlavicka->pdni_zpn","1",0,"R");
$pdf->Cell(24,5,"$hlavicka->zcel_zpn","1",0,"R");$pdf->Cell(20,5,"$hlavicka->zzam_np","1",0,"R");
$pdf->Cell(10,5,"$fir_zpn","1",0,"R");$pdf->Cell(10,5,"$zam_zpn","1",0,"R");
$pdf->Cell(19,5,"$hlavicka->ofir_np","1",0,"R");$pdf->Cell(19,5,"$hlavicka->ozam_np","1",0,"R");
$pdf->Cell(20,5,"$hlavicka->ofir_rf","1",0,"R");
$pdf->Cell(11,5,"                          ","1",1,"L");
}

if( $j == 4 OR $j == 8 OR $j == 12 OR $j == 16 ) $pdf->Cell(190,1,"                          ","1",1,"L");

//koniec tela polozky

}
$i = $i + 1;
$j = $j + 1;

if( $j == 20 )
{

$j=0;
$pdf->SetY(201);
$pdf->Cell(190,10,"                          ","0",1,"L");
$pdf->Cell(45,5,"vyplnil","LT",0,"L");$pdf->Cell(53,5,"  ","T",0,"L");$pdf->Cell(45,5,"strana ËÌslo/celkov˝ poËet str·n","LT",0,"L");$pdf->Cell(47,5,"  ","RT",1,"L");

$pdf->Cell(98,17,"  ","L",0,"L");$pdf->Cell(92,17,"  ","LR",1,"L");
$pdf->Cell(98,5,"dÚa","LB",0,"L");$pdf->Cell(92,5,"  ","LRB",1,"L");

$pdf->Cell(190,2,"                          ","0",1,"L");


$pdf->Cell(98,5,"podpis a odtlaËok peËiatky platiteæa poistnÈho","LT",0,"L");$pdf->Cell(45,5,"v˝kaz evidoval","LT",0,"L");$pdf->Cell(47,5,"  ","RT",1,"L");

$pdf->Cell(98,17,"  ","L",0,"L");$pdf->Cell(92,17,"  ","LR",1,"L");
$pdf->Cell(98,5,"d·tum","LB",0,"L");$pdf->Cell(92,5,"d·tum evidencie","LRB",1,"L");

}

  }

$pdf->SetY(201);
$pdf->Cell(190,10,"                          ","0",1,"L");
$pdf->Cell(45,5,"vyplnil","LT",0,"L");$pdf->Cell(53,5,"  ","T",0,"L");$pdf->Cell(45,5,"strana ËÌslo/celkov˝ poËet str·n","LT",0,"L");$pdf->Cell(47,5,"  ","RT",1,"L");

$pdf->Cell(98,17,"  ","L",0,"L");$pdf->Cell(92,17,"  ","LR",1,"L");
$pdf->Cell(98,5,"dÚa","LB",0,"L");$pdf->Cell(92,5,"  ","LRB",1,"L");

$pdf->Cell(190,2,"                          ","0",1,"L");


$pdf->Cell(98,5,"podpis a odtlaËok peËiatky platiteæa poistnÈho","LT",0,"L");$pdf->Cell(45,5,"v˝kaz evidoval","LT",0,"L");$pdf->Cell(47,5,"  ","RT",1,"L");

$pdf->Cell(98,17,"  ","L",0,"L");$pdf->Cell(92,17,"  ","LR",1,"L");
$pdf->Cell(98,5,"d·tum","LB",0,"L");$pdf->Cell(92,5,"d·tum evidencie","LRB",1,"L");

//koniec nie vseobecna zdravotna , nie apollo , nie spolocna, nie dovera
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
<a href="#" onClick="MesacnyVykaz(<?php echo $polozka->zdrv; ?>);">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
MesaËn˝ v˝kaz

<?php if( $polozka->zdrv >= 2300 AND $polozka->zdrv <= 2499 )  { ?>
<a href="#" onClick="MesacnyVykaz2(<?php echo $polozka->zdrv; ?>);">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù DÙVERA mesaËn˝ v˝kaz vo form·te PDF max. 2 zamestnanci' ></a>
<?php                                                    } ?>

<?php if( $polozka->zdrv >= 2700 AND $polozka->zdrv <= 2799 )  { ?>
<a href="#" onClick="MesacnyVykaz2(<?php echo $polozka->zdrv; ?>);">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù UNION mesaËn˝ v˝kaz vo form·te PDF max. 2 zamestnanci' ></a>
<?php                                                    } ?>

<?php if( $polozka->zdrv >= 2500 AND $polozka->zdrv <= 2599 )  { ?>
<a href="#" onClick="MesacnyVykaz2(<?php echo $polozka->zdrv; ?>);">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù VäZP mesaËn˝ v˝kaz vo form·te PDF max. 2 zamestnanci' ></a>
<?php                                                    } ?>

</td>

<td class="bmenu" width="20%">
<a href="#" onClick="Priloha(<?php echo $polozka->zdrv; ?>);">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
PrÌloha
<a href="#" onClick="PrilohaMena(<?php echo $polozka->zdrv; ?>);">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù aj s menom a priezviskom vo form·te PDF' ></a>
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


  $text = "".$akyvyk."|514|".$fir_fico."|".$platitel."|".$cislo_zdrv."|".$dat_dat."|1|".$poistenychvzp;
  $text = $text."|1|1".$konznak."\r\n";
  fwrite($soubor, $text);

//den na vyplatu
if( $fir_mzdx06 == 0 ) { $fir_mzdx06=15; }
if( $fir_mzdx06 > 31 ) { $fir_mzdx06=15; }
$denvyplaty=$fir_mzdx06;


if( $denvyplaty == '29' AND $obdobie == 01 ) { $denvyplaty="28"; }
if( $denvyplaty == '30' AND $obdobie == 01 ) { $denvyplaty="28"; }
if( $denvyplaty == '31' AND $obdobie == 01 ) { $denvyplaty="28"; }
if( $denvyplaty == '31' AND $obdobie == 03 ) { $denvyplaty="30"; }
if( $denvyplaty == '31' AND $obdobie == 05 ) { $denvyplaty="30"; }
if( $denvyplaty == '31' AND $obdobie == 08 ) { $denvyplaty="30"; }
if( $denvyplaty == '31' AND $obdobie == 10 ) { $denvyplaty="30"; }

  $text = $kli_vrok.$obdobie."|$denvyplaty|".$fir_fnaz."|".$fir_fico."|".$platitel."|".$fir_fdic."|".$fir_ftel."|".$fir_ffax."|".$fir_fem1."|".$fir_fnm1."||".$fir_fuc1;
  

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

$cislopoistenca=$hlavicka->rdc.$hlavicka->rdk;

//ak zahranicny vo vszp,dovera daj cislo do doplnujucich udajov
if( $cislo_zdrv >= 2400 AND $cislo_zdrv <= 2599 ) 
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

if( $hlavicka->znizp == 0 )
{

$fir_zptlac=$fir_zp;
$zam_zptlac=$zam_zp;
if( $hlavicka->pom == 14 ) { $fir_zptlac=0; $zam_zptlac=0; }

  $text = $text.$hlavicka->pdni_zp."|".$fir_zptlac."|".$zam_zptlac."|".$hlavicka->zcel_zp."|".$hlavicka->zzam_zp."|";
  $text = $text.$hlavicka->ofir_zp."|".$hlavicka->ozam_zp."|".$hlavicka->celk_spolu.$konznak."\r\n";

  fwrite($soubor, $text);
}


if( $hlavicka->znizp != 0 )
{
  $text = $text.$hlavicka->pdni_zpn."|".$fir_zpn."|".$zam_zpn."|".$hlavicka->zcel_zpn."|".$hlavicka->zzam_np."|";
  $text = $text.$hlavicka->ofir_np."|".$hlavicka->ozam_np."|".$hlavicka->celk_spolu.$konznak."\r\n";

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
