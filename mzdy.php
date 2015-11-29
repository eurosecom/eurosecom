<?PHP
session_start();
$_SESSION['ucto_sys'] = 0;
$_SESSION['pocstav'] = 0;

?>
<HTML>
<?php

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$newmenu = 1*$_REQUEST['newmenu'];
if( $_SESSION['chrome'] == 0 ) { $newmenu = 0; }
if( $_SESSION['nieie'] == 1 ) { $newmenu = 1; }

$parwin="width=' + sirkawin + ', height=' + vyskawin + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes";
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

       do
       {
if ( $copern !== 99 )
{
$sys = 'MZD';
$urov = 4000;
$cslm = 1;

if( $_SESSION['kli_vxcf'] == 9999 ) 
{ echo "Vypnite všetky okná v prehliadaèi IE a prihláste sa znovu prosím do IS, ak ste pouívali Cestovné príkazy"; exit; }

$uziv = include("uziv.php");
if( !$uziv ) exit;

  require_once("pswd/password.php");

$mysqldbfir=$mysqldb;
$mysqldbdata=$mysqldb;
$dtb2 = include("oddel_dtb1.php");

  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

}

$firs = 1*$_REQUEST['firs'];
$umes = 1*$_REQUEST['umes'];

// zmena firmy
if ( $copern == 25 OR $copern == 23 )
     {

//ak zmena firmy nastav umes podla kli_vrok vo firme
if ( $copern == 23 )
     {
$sqlmax = mysql_query("SELECT * FROM $mysqldbfir.fir WHERE xcf=$firs");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $umes="1.".$riadmax->rok;
  }
     }

$query="START TRANSACTION;"; 
$trans = mysql_query($query);

$zmazane = mysql_query("DELETE FROM $mysqldbfir.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldbfir.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); "); 
if ( $ulozene )
{
$query="COMMIT;";
$trans = mysql_query($query);
}
if ( !$ulozene )
{
$query="ROLLBACK;";
$trans = mysql_query($query);
}
     }

$cit_nas = include("cis/citaj_nas.php");

$cook=0;
if( $cook == 1 )
    {
setcookie("kli_vxcf", $vyb_xcf, time() + (7 * 24 * 60 * 60));
setcookie("kli_nxcf", $vyb_naz, time() + (7 * 24 * 60 * 60));
setcookie("kli_vume", $vyb_ume, time() + (7 * 24 * 60 * 60));
setcookie("kli_vrok", $vyb_rok, time() + (7 * 24 * 60 * 60));
    }
session_start();    
$_SESSION['kli_vxcf'] = $vyb_xcf;
$_SESSION['kli_nxcf'] = $vyb_naz;
$_SESSION['kli_vume'] = $vyb_ume;
$_SESSION['kli_vrok'] = $vyb_rok;
$_SESSION['kli_vduj'] = $vyb_duj;

  $kli_vduj=$_SESSION['kli_vduj'];

$dtb2 = include("oddel_dtb2.php");

  mysql_select_db($mysqldbdata);
$vrz = include("verzia.php");



//oprava parametrov 01.2010
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012010a";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "DROP TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012010";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012010dm952";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012010dm953";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012010zp_d1";
$vysledek = mysql_query("$sql");

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012010a".$sqlt;
$vysledek = mysql_query("$sql");
}

//uprava parametrov miezd na aktualny stav od 1.1.2010 a zaroven zmena od 1.7.2010 maxSP 
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012010";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

if( $vyb_rok == 2010 )
     {

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm2009 SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm SET ".
" zam_zp=4,    fir_zp=10, max_zp=2169.09, min_zp=307.70, zam_zpn=2, fir_zpn=5, ".
" zam_np=1.4,  fir_np=1.4,  max_np=1116.75, min_np=0, ".
" zam_sp=4,    fir_sp=14,   max_sp=2978.00, min_sp=0, ".
" zam_ip=3,    fir_ip=3,    max_ip=2978.00, min_ip=0, ".
" zam_pn=1,    fir_pn=1,    max_pn=2978.00, min_pn=0, ".
" zam_gf=0,    fir_gf=0.25, max_gf=1116.75, min_gf=0, ".
" zam_up=0,    fir_up=0.8,  max_up=9999999, min_up=0, ".
" zam_rf=0,    fir_rf=4.75, max_rf=2978.00, min_rf=0, ".
" min_mzda=307.70, dan_bonus=20.02, dan_danov=335.47 ";
$vysledek = mysql_query("$sql");

     }

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012010".$sqlt;
$vysledek = mysql_query("$sql");
}
//uprava parametrov miezd od 1.1.2010

//oprava cisla uctu Dovera ZP 01.2010
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012010dovera3";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
if( $vyb_rok == 2010 )
     {
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_zdravpois SET uceb='7000747747', numb='8180' WHERE zdrv >= 2400 AND zdrv <=2499 ";
$vysledek = mysql_query("$sql");
     }

if( $vyb_rok == 2010 AND $_SERVER['SERVER_NAME'] == "www.ekorobot.sk" )
     {
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_zdravpois SET zdrv=2400 WHERE zdrv = 2408 ";
$vysledek = mysql_query("$sql");
     }
$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012010dovera3".$sqlt;
$vysledek = mysql_query("$sql");
}

//dm952 doplatok dan.bonus z RZ 01.2010,2011
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012011dm952";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
if( $vyb_rok >= 2010 AND $vyb_rok < 2013 )
     {
$sql = "DELETE FROM ".$mysqldbdata.".F$vyb_xcf"."_mzddmn WHERE dm = 952 ";
$vysledek = mysql_query("$sql");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzddmn ( dm,nzdm,dndm,td,nap_zp,nap_np,nap_sp,nap_ip,nap_pn,nap_up,nap_gf,nap_rf,".
" br,rh,do,ne,ho,np,prn,prm,prv,prs,sa,ko,sax,su,au,suc,auc )".
" VALUES ( '952', 'Dan.bonus z RZ', 'Dan.bonus z RZ', '1', '$x_napzp', '$x_napnp', '$x_napsp', '$x_napip', '$x_nappn', '$x_napup', '$x_napgf', '$x_naprf',".
" '3', '$x_rh', '$x_do', '$x_ne', '$x_ho', '$x_np', '$x_prn', '$x_prm', '$x_prv', '$x_prs',".
" '$c_sa', '$x_ko', '$x_sax', '342', '10',".
" '342', '10' ); "; 

$ulozene = mysql_query("$sqult");

     }


$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012011dm952".$sqlt;
$vysledek = mysql_query("$sql");
}

//dm953 zam.premia z RZ 01.2010,2011
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012011dm953";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
if( $vyb_rok >= 2010 AND $vyb_rok < 2013 )
     {
$sql = "DELETE FROM ".$mysqldbdata.".F$vyb_xcf"."_mzddmn WHERE dm = 953 ";
$vysledek = mysql_query("$sql");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzddmn ( dm,nzdm,dndm,td,nap_zp,nap_np,nap_sp,nap_ip,nap_pn,nap_up,nap_gf,nap_rf,".
" br,rh,do,ne,ho,np,prn,prm,prv,prs,sa,ko,sax,su,au,suc,auc )".
" VALUES ( '953', 'Zam.premia', 'Zam.premia', '1', '$x_napzp', '$x_napnp', '$x_napsp', '$x_napip', '$x_nappn', '$x_napup', '$x_napgf', '$x_naprf',".
" '3', '$x_rh', '$x_do', '$x_ne', '$x_ho', '$x_np', '$x_prn', '$x_prm', '$x_prv', '$x_prs',".
" '$c_sa', '$x_ko', '$x_sax', '342', '10',".
" '342', '10' ); "; 

$ulozene = mysql_query("$sqult");

     }


$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012011dm953".$sqlt;
$vysledek = mysql_query("$sql");
}

//oprava v ciselniku ZP pz1,pz2 nenulove
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012010zp_d1";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{


$sql = "ALTER TABLE ".$mysqldbdata.".F$vyb_xcf"."_zdravpois MODIFY pz1 DECIMAL(4,0) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ".$mysqldbdata.".F$vyb_xcf"."_zdravpois MODIFY pz2 DECIMAL(4,0) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ".$mysqldbdata.".F$vyb_xcf"."_zdravpois MODIFY pz1 DECIMAL(4,0) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ".$mysqldbdata.".F$vyb_xcf"."_zdravpois MODIFY pz2 DECIMAL(4,0) DEFAULT 0";
$vysledek = mysql_query("$sql");


$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012010zp_d1".$sqlt;
$vysledek = mysql_query("$sql");
}

//uprava parametrov miezd na aktualny stav od 1.7.2010 zmena max.vym.zakladov do SP a zmena danoveho bonusu
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new072010a";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

if( $vyb_rok == 2010 )
     {
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm SET dan_bonus=20.02, max_np=1116.75, max_gf=1116.75, max_sp=2978.00, max_ip=2978.00, max_pn=2978.00, max_rf=2978.00 ";
$vysledek = mysql_query("$sql");
     }

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new072010a".$sqlt;
$vysledek = mysql_query("$sql");

}
//uprava parametrov miezd



//uprava parametrov miezd na aktualny stav od 1.1.2011
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012011";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

if( $vyb_rok == 2011 )
     {

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm2010 SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm SET ".
" zam_zp=4,    fir_zp=10,   max_zp=2233.50, min_zp=0, zam_zpn=2, fir_zpn=5, ".
" zam_np=1.4,  fir_np=1.4,  max_np=1116.75, min_np=0, ".
" zam_sp=4,    fir_sp=14,   max_sp=2978.00, min_sp=0, ".
" zam_ip=3,    fir_ip=3,    max_ip=2978.00, min_ip=0, ".
" zam_pn=1,    fir_pn=1,    max_pn=2978.00, min_pn=0, ".
" zam_gf=0,    fir_gf=0.25, max_gf=1116.75, min_gf=0, ".
" zam_up=0,    fir_up=0.8,  max_up=9999999, min_up=0, ".
" zam_rf=0,    fir_rf=4.75, max_rf=2978.00, min_rf=0, ".
" min_mzda=317.00, dan_bonus=20.51, dan_danov=296.60  ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzddmn SET ".
" nap_zp=1, nap_np=1, nap_sp=1, nap_ip=1, nap_pn=1, nap_up=1, nap_gf=1, nap_rf=1 WHERE td = 0  ";
$vysledek = mysql_query("$sql");


     }

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012011".$sqlt;
$vysledek = mysql_query("$sql");
}
//uprava parametrov miezd od 1.1.2011

//uprava parametrov miezd od 1.7.2011 zmena danoveho bonusu
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new072011a";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

if( $vyb_rok == 2010 )
     {
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm SET dan_bonus=20.51 ";
$vysledek = mysql_query("$sql");
     }

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new072011a".$sqlt;
$vysledek = mysql_query("$sql");

}
//uprava parametrov miezd od 1.7.2011

// pm  nzpm  prpm  zam_zp  zam_np  zam_sp  zam_ip  zam_pn  zam_up  zam_gf  zam_rf  fir_zp  fir_np  fir_sp  fir_ip  fir_pn  fir_up  fir_gf  fir_rf  
// zam_zm  pm_doh  pm_maj  np_soc  pm1  pm2  pm3  pm4  datm  

//nove pomery a zlozky miezd pre statutarne organy s pravidelnym a nepravidelnym prijmom
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012011dmpm";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
if( $vyb_rok == 2011 )
     {
$sql = "DELETE FROM ".$mysqldbdata.".F$vyb_xcf"."_mzddmn WHERE dm = 150 OR dm = 151 ";
$vysledek = mysql_query("$sql");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzddmn ( dm,nzdm,dndm,td,nap_zp,nap_np,nap_sp,nap_ip,nap_pn,nap_up,nap_gf,nap_rf,".
" br,rh,do,ne,ho,np,prn,prm,prv,prs,sa,ko,sax,su,au,suc,auc )".
" VALUES ( '150', 'Kon.Spol.Štat.PP', 'Kon.Spol.Štat.PravidelnıPríjem', '0', '1', '1', '1', '1', '1', '0', '0', '1',".
" '1', '0', '0', '0', '0', '0', '0', '0', '0', '0',".
" '0', '0', '0', '522', '0',".
" '522', '0' ); "; 
$ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzddmn ( dm,nzdm,dndm,td,nap_zp,nap_np,nap_sp,nap_ip,nap_pn,nap_up,nap_gf,nap_rf,".
" br,rh,do,ne,ho,np,prn,prm,prv,prs,sa,ko,sax,su,au,suc,auc )".
" VALUES ( '151', 'Kon.Spol.Štat.NP', 'Kon.Spol.Štat.NepravidelnıPríjem', '0', '1', '0', '1', '1', '0', '0', '0', '1',".
" '1', '0', '0', '0', '0', '0', '0', '0', '0', '0',".
" '0', '0', '0', '522', '0',".
" '522', '0' ); "; 
$ulozene = mysql_query("$sqult");

$sql = "DELETE FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer WHERE pm = 50 OR pm = 51 OR pm = 31 ";
$vysledek = mysql_query("$sql");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer ( pm,nzpm,prpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf, ".
" zam_zm,pm_doh,pm_maj,np_soc,pm1,pm2,pm3,pm4,datm ) ".
" VALUES ( 50, 'Kon.Spol.Štat.PravidelnıPríjem', '', '1', '1', '1', '1', '1', '0', '0', '0', ".
" '1', '1', '1', '1', '1', '0', '0', '1', ".
" 0, 1, 1, 0, 0, 0, 0, 0, now()  ); "; 
$ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer ( pm,nzpm,prpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf, ".
" zam_zm,pm_doh,pm_maj,np_soc,pm1,pm2,pm3,pm4,datm ) ".
" VALUES ( 51, 'Kon.Spol.Štat.NepravidelnıPríjem', '', '1', '0', '1', '1', '0', '0', '0', '0', ".
" '1', '0', '1', '1', '0', '0', '0', '1', ".
" 0, 1, 1, 0, 0, 0, 0, 0, now()  ); "; 
$ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer ( pm,nzpm,prpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf, ".
" zam_zm,pm_doh,pm_maj,np_soc,pm1,pm2,pm3,pm4,datm ) ".
" VALUES ( 31, 'Zamestnanec InvDôchodok', '', '1', '1', '1', '0', '1', '0', '0', '0', ".
" '1', '1', '1', '0', '1', '1', '1', '1', ".
" 1, 0, 0, 1, 0, 0, 0, 0, now()  ); "; 
$ulozene = mysql_query("$sqult");

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012011dmpm".$sqlt;
$vysledek = mysql_query("$sql");

     }

}

//uprava dm150,151 br=1
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012011dmpm_a";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
if( $vyb_rok == 2011 )
     {
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzddmn SET br=1 WHERE dm=150 OR dm=151 ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012011dmpm_a".$sqlt;
$vysledek = mysql_query("$sql");

     }

}

//uprava pm=31 Zamestnanec InvDôchodok ZPSdo70
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012011dmpm_b";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
if( $vyb_rok == 2011 )
     {
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer SET nzpm='Zamestnanec InvDôchodok ZPSdo70', zam_ip=1, fir_ip=1, zam_pn=1, fir_pn=1 WHERE pm=31 ";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer WHERE pm = 32 ";
$vysledek = mysql_query("$sql");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer ( pm,nzpm,prpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf, ".
" zam_zm,pm_doh,pm_maj,np_soc,pm1,pm2,pm3,pm4,datm ) ".
" VALUES ( 32, 'Zamestnanec InvDôchodok ZPSnad70', '', '1', '1', '1', '0', '1', '0', '0', '0', ".
" '1', '1', '1', '0', '1', '1', '1', '1', ".
" 1, 0, 0, 1, 0, 0, 0, 0, now()  ); "; 
$ulozene = mysql_query("$sqult");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer SET nzpm='Zamestnanec InvDôchodok ZPSnad70', zam_ip=1, fir_ip=1, zam_pn=0, fir_pn=0 WHERE pm=32 ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012011dmpm_b".$sqlt;
$vysledek = mysql_query("$sql");

     }

}


//uprava parametrov miezd na aktualny stav od 1.1.2012
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012012";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

if( $vyb_rok == 2012 )
     {

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm2011 SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm SET ".
" zam_zp=4,    fir_zp=10,   max_zp=2307.00, min_zp=0, zam_zpn=2, fir_zpn=5, ".
" zam_np=1.4,  fir_np=1.4,  max_np=1153.50, min_np=0, ".
" zam_sp=4,    fir_sp=14,   max_sp=3076.00, min_sp=0, ".
" zam_ip=3,    fir_ip=3,    max_ip=3076.00, min_ip=0, ".
" zam_pn=1,    fir_pn=1,    max_pn=3076.00, min_pn=0, ".
" zam_gf=0,    fir_gf=0.25, max_gf=1153.50, min_gf=0, ".
" zam_up=0,    fir_up=0.8,  max_up=9999999, min_up=0, ".
" zam_rf=0,    fir_rf=4.75, max_rf=3076.00, min_rf=0, ".
" min_mzda=327.20, dan_bonus=21.03, dan_danov=303.72  ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzddmn SET ".
" nap_zp=1, nap_np=1, nap_sp=1, nap_ip=1, nap_pn=1, nap_up=1, nap_gf=1, nap_rf=1 WHERE td = 0  ";
$vysledek = mysql_query("$sql");


     }

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012012".$sqlt;
$vysledek = mysql_query("$sql");
}

$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012012a";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

if( $vyb_rok == 2012 )
     {

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzddmn SET ".
" nap_zp=1, nap_np=1, nap_sp=1, nap_ip=1, nap_pn=1, nap_up=1, nap_gf=1, nap_rf=1 WHERE td = 0  ";
$vysledek = mysql_query("$sql");


     }

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012012a".$sqlt;
$vysledek = mysql_query("$sql");
}
//uprava parametrov miezd od 1.1.2012

//uprava parametrov miezd od 1.7.2012 zmena danoveho bonusu
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new072012a";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

if( $vyb_rok == 2012 )
     {

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm SET dan_bonus=21.03 ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new072012a".$sqlt;
$vysledek = mysql_query("$sql");

     }

}
//uprava parametrov miezd od 1.7.2012

//uprava parametrov miezd na aktualny stav od 1.1.2013
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012013";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

if( $vyb_rok == 2013 )
     {

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm2012 SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm SET ".
" zam_zp=4,    fir_zp=10,   max_zp=3930.00, min_zp=0, zam_zpn=2, fir_zpn=5, ".
" zam_np=1.4,  fir_np=1.4,  max_np=3930.00, min_np=0, ".
" zam_sp=4,    fir_sp=14,   max_sp=3930.00, min_sp=0, ".
" zam_ip=3,    fir_ip=3,    max_ip=3930.00, min_ip=0, ".
" zam_pn=1,    fir_pn=1,    max_pn=3930.00, min_pn=0, ".
" zam_gf=0,    fir_gf=0.25, max_gf=3930.00, min_gf=0, ".
" zam_up=0,    fir_up=0.8,  max_up=9999999, min_up=0, ".
" zam_rf=0,    fir_rf=4.75, max_rf=3930.00, min_rf=0, ".
" min_mzda=337.70, dan_bonus=21.41, dan_danov=311.32  ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzddmn SET ".
" nap_zp=1, nap_np=1, nap_sp=1, nap_ip=1, nap_pn=1, nap_up=1, nap_gf=1, nap_rf=1 WHERE td = 0  ";
$vysledek = mysql_query("$sql");


     }

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012013".$sqlt;
$vysledek = mysql_query("$sql");
}

//uprava parametrov miezd na aktualny stav od 1.1.2013

//uprava parametrov miezd od 1.7.2013 zmena danoveho bonusu
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new072013a";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

if( $vyb_rok == 2013 )
     {

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm SET dan_bonus=21.41 ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new072013a".$sqlt;
$vysledek = mysql_query("$sql");

     }

}
//uprava parametrov miezd od 1.7.2013



$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012013a";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

if( $vyb_rok == 2013 )
     {

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzddmn SET ".
" nap_zp=1, nap_np=1, nap_sp=1, nap_ip=1, nap_pn=1, nap_up=1, nap_gf=1, nap_rf=1 WHERE td = 0  ";
$vysledek = mysql_query("$sql");


     }

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012013a".$sqlt;
$vysledek = mysql_query("$sql");
}
//uprava parametrov miezd od 1.1.2013


//uprava nove pomery od 1.1.2013 
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012013pomer_c";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "DROP TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012013pomer_a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012013pomer_b";
$vysledek = mysql_query("$sql");

if( $vyb_rok == 2013 )
     {

$sql = "ALTER TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer MODIFY pm3 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer SET pm3='ZEC' ";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer WHERE ( pm >= 41 AND pm <= 49 ) OR pm = 12 OR pm = 17 OR pm = 3 ";
$vysledek = mysql_query("$sql");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer ( pm,nzpm,prpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf, ".
" zam_zm,pm_doh,pm_maj,np_soc,pm1,pm2,pm3,pm4,datm ) ".
" VALUES ( 41, 'Dohoda o brigádnickej práci študentov I.dohoda ', '', '0', '0', '1', '1', '0', '0', '0', '0', ".
" '0', '0', '1', '1', '0', '1', '1', '1', ".
" 1, 1, 0, 0, 0, 0, 'ZECD3', 0, now()  ); "; 
$ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer ( pm,nzpm,prpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf, ".
" zam_zm,pm_doh,pm_maj,np_soc,pm1,pm2,pm3,pm4,datm ) ".
" VALUES ( 42, 'Dohoda o brigádnickej práci študentov II.dohoda ', '', '0', '0', '1', '1', '0', '0', '0', '0', ".
" '0', '0', '1', '1', '0', '1', '1', '1', ".
" 1, 1, 0, 0, 0, 0, 'ZECD3', 0, now()  ); "; 
$ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer ( pm,nzpm,prpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf, ".
" zam_zm,pm_doh,pm_maj,np_soc,pm1,pm2,pm3,pm4,datm ) ".
" VALUES ( 43, 'Dohoda o vykonaní práce Starobnı dôchodca ', '', '0', '0', '1', '0', '0', '0', '0', '0', ".
" '0', '0', '1', '0', '0', '1', '1', '1', ".
" 0, 1, 0, 0, 0, 0, 'ZECD1', 0, now()  ); "; 
$ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer ( pm,nzpm,prpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf, ".
" zam_zm,pm_doh,pm_maj,np_soc,pm1,pm2,pm3,pm4,datm ) ".
" VALUES ( 44, 'Dohoda o pracovnej èinnosti Starobnı dôchodca ', '', '0', '0', '1', '0', '0', '0', '0', '0', ".
" '0', '0', '1', '0', '0', '1', '1', '1', ".
" 0, 1, 0, 0, 0, 0, 'ZECD2', 0, now()  ); "; 
$ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer ( pm,nzpm,prpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf, ".
" zam_zm,pm_doh,pm_maj,np_soc,pm1,pm2,pm3,pm4,datm ) ".
" VALUES ( 45, 'Dohoda o vykonaní práce Inval.dôchodca ZPSdo70', '', '0', '0', '1', '1', '1', '0', '0', '0', ".
" '0', '0', '1', '1', '1', '1', '1', '1', ".
" 0, 1, 0, 0, 0, 0, 'ZECD1', 0, now()  ); "; 
$ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer ( pm,nzpm,prpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf, ".
" zam_zm,pm_doh,pm_maj,np_soc,pm1,pm2,pm3,pm4,datm ) ".
" VALUES ( 46, 'Dohoda o pracovnej èinnosti Inval.dôchodca ZPSdo70', '', '0', '0', '1', '1', '1', '0', '0', '0', ".
" '0', '0', '1', '1', '0', '1', '1', '1', ".
" 0, 1, 0, 0, 0, 0, 'ZECD2', 0, now()  ); "; 
$ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer ( pm,nzpm,prpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf, ".
" zam_zm,pm_doh,pm_maj,np_soc,pm1,pm2,pm3,pm4,datm ) ".
" VALUES ( 47, 'Dohoda o vykonaní práce Inval.dôchodca ZPnad70', '', '0', '0', '1', '1', '0', '0', '0', '0', ".
" '0', '0', '1', '1', '0', '1', '1', '1', ".
" 0, 1, 0, 0, 0, 0, 'ZECD1', 0, now()  ); "; 
$ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer ( pm,nzpm,prpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf, ".
" zam_zm,pm_doh,pm_maj,np_soc,pm1,pm2,pm3,pm4,datm ) ".
" VALUES ( 48, 'Dohoda o pracovnej èinnosti Inval.dôchodca ZPSnad70', '', '0', '0', '1', '1', '0', '0', '0', '0', ".
" '0', '0', '1', '1', '0', '1', '1', '1', ".
" 0, 1, 0, 0, 0, 0, 'ZECD2', 0, now()  ); "; 
$ulozene = mysql_query("$sqult");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer SET nzpm='Zamestnanec InvDôchodok ZPSdo70 ', ".
" zam_zp=1, zam_np=1, zam_sp=1, zam_ip=1,zam_pn=1, zam_up=0, zam_gf=0, zam_rf=0, fir_zp=1, fir_np=1, fir_sp=1, fir_ip=1, fir_np=1, fir_pn=1, fir_up=1, fir_gf=1, fir_rf=1 ".
" WHERE pm=31 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer SET nzpm='Zamestnanec InvDôchodok ZPSnad70 ', ".
" zam_zp=1, zam_np=1, zam_sp=1, zam_ip=1, zam_np=1, zam_pn=1, zam_up=0, zam_gf=0, zam_rf=0, fir_zp=1, fir_np=1, fir_sp=1, fir_ip=1, fir_np=1, fir_pn=1, fir_up=1, fir_gf=1, fir_rf=1 ".
" WHERE pm=32 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer SET ".
" zam_zp=1, zam_np=1, zam_sp=1, zam_ip=1, zam_pn=1, zam_up=0, zam_gf=0, zam_rf=0, fir_zp=1, fir_np=1, fir_sp=1, fir_ip=1, fir_pn=1, fir_up=1, fir_gf=1, fir_rf=1 ".
" WHERE pm=2 OR pm=7 OR pm=8 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer SET nzpm='Dohoda o vykonaní práce - Pravidelnı príjem', pm3='ZECD1' WHERE pm = 2 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer SET nzpm='Dohoda o pracovnej èinnosti - Pravidelnı príjem', pm3='ZECD2' WHERE pm = 7 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer SET nzpm='Dohoda o pracovnej èinnosti - Pravidelnı príjem', pm3='ZECD2' WHERE pm = 8 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer SET nzpm='Zamestnanec bez NÈZD na daòovníka' WHERE pm = 21 ";
$vysledek = mysql_query("$sql");


$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer ( pm,nzpm,prpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf, ".
" zam_zm,pm_doh,pm_maj,np_soc,pm1,pm2,pm3,pm4,datm ) ".
" VALUES ( 12, 'Dohoda o vykonaní práce - NEPravidelnı príjem', '', '1', '0', '1', '1', '0', '0', '0', '0', ".
" '1', '0', '1', '1', '0', '1', '1', '1', ".
" 0, 1, 1, 0, 0, 0, 'ZECD1N', 0, now()  ); "; 
$ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer ( pm,nzpm,prpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf, ".
" zam_zm,pm_doh,pm_maj,np_soc,pm1,pm2,pm3,pm4,datm ) ".
" VALUES ( 17, 'Dohoda o pracovnej èinnosti - NEPravidelnı príjem', '', '1', '0', '1', '1', '0', '0', '0', '0', ".
" '1', '0', '1', '1', '0', '1', '1', '1', ".
" 0, 1, 1, 0, 0, 0, 'ZECD2N', 0, now()  ); "; 
$ulozene = mysql_query("$sqult");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer SET pm4=0 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer SET pm4=1 WHERE pm=12 OR pm=17 OR pm=51 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer SET pm3='ZECN' WHERE pm=51 ";
$vysledek = mysql_query("$sql");

//dobrovolny prispevok do II.piliera
$sql = "DELETE FROM ".$mysqldbdata.".F$vyb_xcf"."_mzddmn WHERE dm = 968 ";
$vysledek = mysql_query("$sql");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzddmn ( dm,nzdm,dndm,td,nap_zp,nap_np,nap_sp,nap_ip,nap_pn,nap_up,nap_gf,nap_rf,".
" br,rh,do,ne,ho,np,prn,prm,prv,prs,sa,ko,sax,su,au,suc,auc )".
" VALUES ( '968', 'DD.poist. II.P', 'Dobrovo¾né dôch.poistenie II.pilier', '1', '0', '0', '0', '0', '0', '0', '0', '0',".
" '3', '0', '0', '0', '0', '0', '0', '0', '0', '0',".
" '0', '0', '0', '366', '0',".
" '366', '0' ); "; 
$ulozene = mysql_query("$sqult");


$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012013pomer_c".$sqlt;
$vysledek = mysql_query("$sql");

     }
}
//koniec uprava nove pomery od 1.1.2013 

//uprava2 nove pomery od 1.1.2013 
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012013pomer_d";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

if( $vyb_rok == 2013 )
     {

$sql = "DELETE FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer WHERE pm = 61 ";
$vysledek = mysql_query("$sql");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer ( pm,nzpm,prpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf, ".
" zam_zm,pm_doh,pm_maj,np_soc,pm1,pm2,pm3,pm4,datm ) ".
" VALUES ( 61, 'Zamestnanec - po skonèení PP ', '', '1', '1', '1', '1', '1', '0', '0', '0', ".
" '1', '1', '1', '1', '1', '1', '1', '1', ".
" 0, 0, 0, 0, 0, 0, 'ZEC', 1, now()  ); "; 
$ulozene = mysql_query("$sqult");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer SET zam_pn=0, fir_pn=0 WHERE pm=45 OR pm=46 ";
$vysledek = mysql_query("$sql");

     }


$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012013pomer_d".$sqlt;
$vysledek = mysql_query("$sql");


}
//koniec uprava2 nove pomery od 1.1.2013 

//uprava3 nove pomery od 1.1.2013 
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012013pomer_e";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

if( $vyb_rok == 2013 )
     {


$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer SET zam_pn=0, fir_pn=0 WHERE pm=32 ";
$vysledek = mysql_query("$sql");

     }


$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012013pomer_e".$sqlt;
$vysledek = mysql_query("$sql");


}
//koniec uprava3 nove pomery od 1.1.2013 

//uprava parametrov miezd na aktualny stav od 1.1.2014
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012014";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vyb_roks=$vyb_rok;
$mysqldbdatas=$mysqldbdata;
$vyb_xcfs=$vyb_xcf;
$setprm = include("mzdy/set2014parametre.php");
}
//uprava parametrov miezd na aktualny stav od 1.1.2014

//uprava nove pomery od 1.1.2014 
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012014pomer_b";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sql = "ALTER TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer MODIFY pm3 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");

if( $vyb_rok == 2014 )
     {

$sql = "DELETE FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer WHERE pm = 3 ";
$vysledek = mysql_query("$sql");

$sqult = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_mzdpomer ( pm,nzpm,prpm,zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
" fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf, ".
" zam_zm,pm_doh,pm_maj,np_soc,pm1,pm2,pm3,pm4,datm ) ".
" VALUES ( 3, 'Zamestnanec a konate¾, štatutár min.50% podiel', '', '1', '1', '1', '1', '1', '0', '0', '0', ".
" '1', '1', '1', '1', '1', '1', '0', '1', ".
" 1, 0, 1, 1, 0, 0, 'ZEC', 0, now()  ); "; 
$ulozene = mysql_query("$sqult");


     }


$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012014pomer_b".$sqlt;
$vysledek = mysql_query("$sql");


}
//koniec uprava nove pomery od 1.1.2014 

//uprava sepa od 1.1.2014
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_sepa012014a";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vyb_roks=$vyb_rok;
$mysqldbdatas=$mysqldbdata;
$vyb_xcfs=$vyb_xcf;
$setprm = include("mzdy/sepa2014.php");
}
//uprava sepa od 1.1.2014

//echo $vyb_rok;

//uprava parametrov miezd na aktualny stav od 1.1.2015
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012015";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vyb_roks=$vyb_rok;
$mysqldbdatas=$mysqldbdata;
$vyb_xcfs=$vyb_xcf;
$setprm = include("mzdy/set2015parametre.php");
}
//uprava parametrov miezd na aktualny stav od 1.1.2015

//uprava sepa od 1.1.2015
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_sepa012015a";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vyb_roks=$vyb_rok;
$mysqldbdatas=$mysqldbdata;
$vyb_xcfs=$vyb_xcf;
$setprm = include("mzdy/sepa2015.php");
}
//uprava sepa od 1.1.2015

//uprava parametrov miezd na aktualny stav od 1.1.2016
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_new012016";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vyb_roks=$vyb_rok;
$mysqldbdatas=$mysqldbdata;
$vyb_xcfs=$vyb_xcf;
$setprm = include("mzdy/set2016parametre.php");
}
//uprava parametrov miezd na aktualny stav od 1.1.2016

//uprava sepa od 1.1.2016
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_mzdprm_sepa012016a";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vyb_roks=$vyb_rok;
$mysqldbdatas=$mysqldbdata;
$vyb_xcfs=$vyb_xcf;
$setprm = include("mzdy/sepa2016.php");
}
//uprava sepa od 1.1.2016

//cleaning
$datdnessql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$jeclean=0;
$poslhh = "SELECT * FROM ".$mysqldbdata.".cleaningtmp WHERE dat='$datdnessql' ";
$posl = mysql_query("$poslhh"); 
if( $posl ) { $jeclean = 1*mysql_num_rows($posl); }
if( $jeclean == 0 )
{
$copernx="alibaba40";
//echo "idem";
$clean = include("funkcie/subory.php");
}

if (File_Exists ("tmp/mzdList.$kli_uzid.pdf")) { $soubor = unlink("tmp/mzdList.$kli_uzid.pdf"); }
if (File_Exists ("tmp/mzdpasky$kli_uzid.pdf")) { $soubor = unlink("tmp/mzdpasky$kli_uzid.pdf"); }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="css/styl.css">
<title>Mzdy Hl.menu</title>
<style type="text/css">

a:link, a:visited {text-decoration: none; color: black;}
a:hover {text-decoration: underline; background-color: #ffff90; }

<?php if( $newmenu == 0 ) { ?>
  @import url(css/skryvanemenu.css);
<?php                     } ?>
</style>
<?php if( $newmenu == 0 ) { ?>
<script type="text/javascript" src="js/cskryvanemenu.js" > </script>
<?php                     } ?>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-90;

<?php if( $newmenu == 0 ) { ?>

  // PRVE MENU
  var M1 = new CSkryvaneMenu("M1", 350);
  M1.NovaPolozka
  ( "Nahrávanie mesaènej mzdy",
    "OtvorMesdav()",
    "Nahrávanie mesaènıch zloiek mzdy , úprava trvalıch mzdovıch zloiek, úprava údajov o zamestnancoch"
  );
  M1.NovaPolozka
  ( "Údaje o zamestnancoch",
    "OtvorKun()",
    "Vytvorenie nového zamestnanca, kmeòové a personálne údaje, údaje o bankovıch úètoch, doplnkovom poistení "
  );
  M1.NovaPolozka
  ( "Trvalé mzdové poloky",
    "OtvorTrn()",
    "Nastavenie fixnej mesaènej mzdy , trvalıch zráok a vıplat , pravidelne mesaène opakovanıch "
  );
  M1.NovaPolozka
  ( "Doplnkové dôchodkové sporenie ",
    "OtvorDDP()",
    "Nastavenie odvodov do doplnkového sporenia ( poistenia ) "
  );
  M1.classMenu = "menu2";
  M1.classPolozka = "polozka2";
  M1.classApolozka = "Apolozka2";
  //M1.x=100;// M1.y=100;

  // DRUHE MENU
  var M2 = new CSkryvaneMenu("M2", 350);
  M2.NovaPolozka
  ( "Spracovanie nahratıch miezd - OSTRÉ",
    "Messprac()",
    "Ostré spracovanie nahratıch mzdovıch zloiek s archiváciou mesaènıch dát"
  );
  M2.NovaPolozka
  ( "Spracovanie nahratıch miezd - NEOSTRÉ",
    "Mnesprac()",
    "Neostré spracovanie nahratıch mzdovıch zloiek , môete ho opakova viac krát"
  );
  M2.NovaPolozka
  ( "Vıplatné pásky",
    "Pasky()",
    "Vytvorenie vıplatnıch pások...."
  );
  M2.NovaPolozka
  ( "Vıplatná listina a mincovka - DOBIERKA",
    "Vypli()",
    "Vytvorenie vıplatnej listiny a mincovky pre dobierky...."
  );
  M2.NovaPolozka
  ( "Príkazy na úhradu miezd a odvodov",
    "Priku()",
    "Vytvorenie príkazov na úhradu miezd a odvodov...."
  );
  M2.NovaPolozka
  ( "Vıkazy pre Sociálnu poisovòu",
    "Socpoist()",
    "Vytvorenie Vıkazov pre Sociálnu poisovòu...."
  );
  M2.NovaPolozka
  ( "Vıkazy pre Zdravotné poisovne",
    "Zdravpoist()",
    "Vytvorenie Vıkazov pre Zdravotné poisovne...."
  );
  M2.NovaPolozka
  ( "Mesaèné mzdové zostavy",
    "Meszost()",
    "Vytvorenie mzdovıch zostáv pre vybranı úètovnı mesiac...."
  );
  M2.NovaPolozka
  ( "Zrušenie ostrého spracovania miezd",
    "Zrusmes()",
    "Zrušenie ostrého spracovania miezd za nastavenı úètovnı mesiac..."
  );
  M2.NovaPolozka
  ( "Prevod do úètovníctva",
    "PreUct()",
    "Prevod do úètovníctva"
  );
  M2.classMenu = "menu2";
  M2.classPolozka = "polozka2";
  M2.classApolozka = "Apolozka2";

  // TRETIE MENU
  var M3 = new CSkryvaneMenu("M3", 370);
  M3.NovaPolozka
  ( "Mzdové, evidenèné listy, potvrdenia",
    "MzdEvid()",
    "Tlaè mzdového listu, evidenèného listu, potvrdení pre úèely vyplácania dávok, zápoèet rokov zamestnancov..."
  );
  M3.NovaPolozka
  ( "Priemery na náhrady a nemocenské ",
    "Priemery()",
    "Vıpoèet priemerov na náhrady a vıplaty nemocenského poistenia..."
  );
  M3.NovaPolozka
  ( "Daò z príjmov FO - potvrdenia,RZ,daò.priznanie ",
    "RZ_dane()",
    "Vıpoèet a tlaè vyhlásenia k dani, potvrdení, roèného zúètovania a daòovıch priznaní pre FO..."
  );
  M3.NovaPolozka
  ( "Zdravotné poistenie - potvrdenia, iadosti, RZ",
    "Roczdr()",
    "Vıpoèet a tlaè potvrdení a roèného zúètovania ZP..."
  );
  M3.NovaPolozka
  ( "Štatistika a vıkazníctvo",
    "sttzos()",
    "Vytvorenie súborov pre TREXIMU a štatistickıch vıkazov...."
  );
  M3.NovaPolozka
  ( "Tlaè z údajov o zamestnancoch ",
    "tlaczam()",
    "Vytvorenie a vytlaèenie vıberovıch zostáv z údajov o zamestnancoch...."
  );
  M3.NovaPolozka
  ( "Personálne zmluvy a dohody so zamestnancami ",
    "personal()",
    "Vytvorenie a vytlaèenie zmlúv a dohôd so zamestnancami...."
  );
  M3.classMenu = "menu2";
  M3.classPolozka = "polozka2";
  M3.classApolozka = "Apolozka2";

  // STVRTE MENU
  var M4 = new CSkryvaneMenu("M4", 280);
  M4.NovaPolozka
  ( "Parametre programu Mzdy",
    "OtvorUfir191()",
    "Parametre programu Mzdy"
  );
  M4.NovaPolozka
  ( "Druhy mzdovıch zloiek",
    "Drm()",
    "Druhy mzdovıch zloiek"
  );
  M4.NovaPolozka
  ( "Druhy pracovnıch pomerov",
    "Pomery()",
    "Druhy pracovnıch pomerov"
  );

  M4.NovaPolozka
  ( "Zdravotné poisovne",
    "ZdrvPois()",
    "Èíselník zdravotnıch poisovní"
  );
  M4.NovaPolozka
  ( "Zoznam DSS",
    "Dss()",
    "Èíselník DSS"
  );
  M4.NovaPolozka
  ( "Zoznam DDP",
    "Ddp()",
    "Èíselník DDP"
  );
  M4.NovaPolozka
  ( "Sadzby ZP, SP, Daò z príjmov",
    "Parametre()",
    "Sadzby odvodov do ZP, SP max,min základy , percentá odvodov a dane z príjmov, odpoèítate¾né poloky"
  );
  M4.NovaPolozka
  ( "Úètovanie miezd",
    "Uctovanie()",
    "Nastavenie úètovania odvodov do fondu , soc.fondu..."
  );
  M4.NovaPolozka
  ( "Druhy bankovıch úètov",
    "OtvorDban()",
    "Druhy bankovıch úètov"
  );
  M4.classMenu = "menu2";
  M4.classPolozka = "polozka2";
  M4.classApolozka = "Apolozka2";
//  M4.x=605;// M1.y=100;

  // PIATE MENU
  var M5 = new CSkryvaneMenu("M5", 150);
  M5.NovaPolozka
  ( "Údaje o firme",
    "OtvorUfir1()",
    "Údaje o firme"
  );
  M5.NovaPolozka
  ( "Èíselník IÈO",
    "OtvorCico()",
    "Èíselník"
  );
  M5.NovaPolozka
  ( "Èíselník stredísk",
    "OtvorCstr()",
    "Èíselník"
  );
  M5.NovaPolozka
  ( "Èíselník zákaziek",
    "OtvorCzak()",
    "Èíselník"
  );
  M5.NovaPolozka
  ( "Èíselník skupín",
    "OtvorCsku()",
    "Èíselník skupn"
  );
  M5.NovaPolozka
  ( "Èíselník stavieb",
    "OtvorCsta()",
    "Èíselník stavieb"
  );
  M5.NovaPolozka
  ( "E-zákazníci",
    "Ezakaznik()",
    "Registrácia e-zákazníkov"
  );
  M5.NovaPolozka
  ( "Zálohovanie dát",
    "ZalDat()",
    "Zálohovanie dát na médium "
  );
  M5.NovaPolozka
  ( "Prenos poè.stavu",
    "PrenosPoc()",
    "Prenos poèiatoèného stavu majetku "
  );
  M5.classMenu = "menu2";
  M5.classPolozka = "polozka2";
  M5.classApolozka = "Apolozka2";
//  M5.x=800;// M1.y=100;

<?php                     } ?>

   // Priklad funkce volane z menu
  function Funkciazmenu()
  {
    alert ("Hlási sa sluba z menu");
  }


  function OtvorCstr()
  { 
  var okno = window.open("../cis/cstr.php?copern=1&page=1","_blank");
  }


  function OtvorCsku()
  { 
  var okno = window.open("../cis/csku.php?copern=1&page=1","_blank");
  }


  function OtvorCsta()
  { 
  var okno = window.open("../cis/csta.php?copern=1&page=1","_blank");
  }

  function OtvorCzak()
  { 
  var okno = window.open("../cis/czak.php?copern=1&page=1","_blank");
  }

  function OtvorUfir1()
  { 
  var okno = window.open("../cis/ufir.php?copern=1","_blank");
  }

  function OtvorUfir191()
  { 
  var okno = window.open("../cis/ufir.php?copern=191","_blank");
  }

  function OtvorCico()
  { 
  var okno = window.open("../cis/cico.php?copern=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function ZmnPrih()
  { 
  var okno = window.open("../cis/zmnprih.php?copern=1&page=1","_blank");
  }

  function ZalDat()
  { 
  var okno = window.open("../cis/zaldat_mzdy.php?copern=101&page=1","_blank");
  }

  function ObnDat()
  { 
  var okno = window.open("../cis/obndat.php?copern=1&page=1","_blank");
  }

  function Ezakaznik()
  { 
  var okno = window.open("../cis/ezak.php?copern=1&page=1","_blank");
  }

//[[[[[[[ body mzdy

  function Vzor()
  { 
  var okno = window.open('../mzdy/vstzam.php?copern=1&drupoh=1&page=1','_blank','<?php echo $parwin; ?>');
  }

  function OtvorDban()
  { 
  var okno = window.open("../ucto/dban.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }  

  function ZdrvPois()
  { 
  var okno = window.open('../mzdy/zdravpois.php?copern=1&drupoh=1&page=1','_blank','<?php echo $parwin; ?>');
  }

  function Dss()
  { 
  var okno = window.open('../mzdy/cisdss.php?copern=1&drupoh=1&page=1','_blank','<?php echo $parwin; ?>');
  }

  function Ddp()
  { 
  var okno = window.open('../mzdy/cisddp.php?copern=1&drupoh=1&page=1','_blank','<?php echo $parwin; ?>');
  }

  function Pomery()
  { 
  var okno = window.open('../mzdy/pomery.php?copern=1&drupoh=1&page=1','_blank','<?php echo $parwin; ?>');
  }

  function Drm()
  { 
  var okno = window.open('../mzdy/drmiezd.php?copern=1&drupoh=1&page=1','_blank','<?php echo $parwin; ?>');
  }

  function OtvorMesdav() {
  var okno = window.open('../mzdy/mes_mzdy.php?copern=1&drupoh=1&page=1','_blank','<?php echo $parwin; ?>');
                         }

  function OtvorKun() {
  var okno = window.open('../mzdy/zamestnanci.php?copern=1&drupoh=1&page=1','_blank','<?php echo $parwin; ?>');
                      }

  function OtvorTrn() {
  var okno = window.open('../mzdy/trvale.php?copern=1&drupoh=1&page=1&zkun=0','_blank','<?php echo $parwin; ?>');
                      }

  function OtvorDDP() {
  var okno = window.open('../mzdy/ddp.php?copern=1&drupoh=1&page=1&zkun=0','_blank','<?php echo $parwin; ?>');
                      }

  function Parametre() {
  var okno = window.open('../mzdy/parametre.php?copern=1&drupoh=1&page=1','_blank','<?php echo $parwin; ?>');
                      }

  function Uctovanie() {
  var okno = window.open('../mzdy/uctovanie.php?copern=1&drupoh=1&page=1','_blank','<?php echo $parwin; ?>');
                      }

  function Messprac() {
  var okno = window.open('../mzdy/vyplat_paska.php?&copern=1&page=1&ostre=1','_blank','<?php echo $parwin; ?>');
                      }

  function Mnesprac() {
  var okno = window.open('../mzdy/vyplat_paska.php?&copern=1&page=1&ostre=0','_blank','<?php echo $parwin; ?>');
                      }

  function Meszost() {
  var okno = window.open("../mzdy/meszos.php?copern=1&drupoh=1&page=1&sysx=MZD","_blank",'<?php echo $parwin; ?>');
                      }

  function Pasky() {
  var okno = window.open('../mzdy/vyplat_paska.php?&copern=11&page=1&ostre=0','_blank','<?php echo $parwin; ?>');
                   }

  function Vypli() {
  var okno = window.open('../mzdy/vyplat_listina.php?&copern=2&page=1&ostre=0&zaloha=0','_blank','<?php echo $parwin; ?>');
                   }

  function Priku() {
  var okno = window.open("../ucto/vstpru.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
                   }

  function Socpoist() {
  var okno = window.open('../mzdy/vykaz_SP.php?&copern=1&page=1&ostre=0','_blank','<?php echo $parwin; ?>');
  }

  function Zdravpoist() {
  var okno = window.open('../mzdy/vykaz_ZP.php?&copern=1&page=1&ostre=0','_blank','<?php echo $parwin; ?>');
  }

  function Zrusmes() {
  var okno = window.open('../mzdy/zrus_ostre.php?&copern=1&page=1&ostre=0','_blank','<?php echo $parwin; ?>');
                   }
  function PreUct()
  { 
  var okno = window.open("../mzdy/mzdyuct.php?copern=10&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function MzdEvid()
  { 
  var okno = window.open("../mzdy/mzdevid.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Priemery() 
  {
  var okno = window.open("../mzdy/priemery.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function sttzos()
  { 
  var okno = window.open("../mzdy/statzos.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function RZ_dane()
  { 
  var okno = window.open("../mzdy/RZ_dane.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function personal()
  { 
  var okno = window.open("../mzdy/personal.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Roczdr()  { 
  var okno = window.open("../mzdy/rz_zdravotne.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function tlaczam()
  { 
  var okno = window.open("../mzdy/tlac_zam.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function ukazrobot()
  { 
  <?php if( $kli_vduj >= 0 AND $vyb_robot == 1 ) { echo "robotokno.style.display=''; robotmenu.style.display='none';"; } ?>
  myRobot = document.getElementById("robotokno");
  myRobotmenu = document.getElementById("robotmenu");
  myRobot.style.top = toprobot;
  myRobot.style.left = leftrobot;
  myRobotmenu.style.top = toprobotmenu;
  myRobotmenu.style.left = leftrobotmenu;
  }

  function zhasnirobot()
  { 
  robotokno.style.display='none';
  robotmenu.style.display='none';
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
  }

    var toprobot = 200;
    var leftrobot = 40;
    var toprobotmenu = 112;
    var leftrobotmenu = 100;
    var widthrobotmenu = 400;

    var htmlmenu = "<table  class='ponuka' width='100%'><tr><td width='90%'>Menu EkoRobot</td>" +
    "<td width='10%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick='zhasni_menurobot();' alt='Zhasni menu' ></td></tr>";  

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"OtvorKun();\">" +
"Chcete upravova zoznam zamestnancov ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"OtvorMesdav();\">" +
"Chcete nahráva mesaèné mzdy zamestnancov ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../mzdy/vyplat_paska.php?&copern=11&page=1&ostre=0', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytlaèi Vıplatné pásky ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../mzdy/vyplat_listina.php?&copern=2&page=1&ostre=0&zaloha=0', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytlaèi Vıplatnú listinu a mincovku ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/vstpru.php?copern=1&drupoh=1&page=1&sysx=UCT', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytvori príkazy na úhradu miezd a odvodov ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../mzdy/vykaz_SP.php?&copern=1&page=1&ostre=0', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytlaèi Vıkazy pre Sociálnu poisovòu ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../mzdy/vykaz_ZP.php?&copern=1&page=1&ostre=0', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytlaèi Vıkazy pre Zdravotné poisovne ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../mzdy/vyplat_paska.php?&copern=1&page=1&ostre=0&kontrola=1', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete kontrolova nahraté údaje v období <?php echo $vyb_ume; ?> ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "</table>";  

  function PrenosPoc()
  { 
  var okno = window.open("../cis/prenos_poc.php?copern=9&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

</script>
</HEAD>
<BODY class="white" <?php if( $copern != 22 AND $copern != 23 AND $copern != 24 ) { echo "onload='ukazrobot();'"; } ?> >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  MZDY a Personalistika
</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid  ";?></span></td>
</tr>
</table>

<table class="pmenu" width="100%" style="border:none">
<tr>
<td width="60%" >
<a href='mzdy.php?copern=22&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width=15 height=10 border=0 alt="Zmena úètovnej jednotky"> Firma</a>
<?php echo "$vyb_xcf";?> <?php echo "$vyb_naz";?>
</td>
<td width="40%" >
<a href='mzdy.php?copern=24&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width=15 height=10 border=0 alt="Zmena úètovného obdobia"> Úètovné obdobie:</a>
<?php echo "$vyb_ume";?>
</td>
</tr>
</table>

<?php 
$klepnutie=".Klepnuti";
if( $newmenu == 1 ) 
{ 
?>
<script type="text/javascript">

  function MZvyrazni(Obj)
                {

  Obj.className = "pmenuz";

                }

  function MNeZvyrazni(Obj)
                {

  Obj.className = "pmenu";

                }

  function M1KlikNaMenu()  {   progmenu1.style.display='';  }
  function M1ZhasniMenu()  {   progmenu1.style.display='none';  }
  function M2KlikNaMenu()  {   progmenu2.style.display='';  }
  function M2ZhasniMenu()  {   progmenu2.style.display='none';  }
  function M3KlikNaMenu()  {   progmenu3.style.display='';  }
  function M3ZhasniMenu()  {   progmenu3.style.display='none';  }
  function M4KlikNaMenu()  {   progmenu4.style.display='';  }
  function M4ZhasniMenu()  {   progmenu4.style.display='none';  }
  function M5KlikNaMenu()  {   progmenu5.style.display='';  }
  function M5ZhasniMenu()  {   progmenu5.style.display='none';  }
</script>

<?php //OBRAZKOVE MENU ?>

<table class="pmenu" width="100%" style="position:relative; top:3px; border:none; background-color:white;" >
<tr>
<td width='20%' onClick="M1KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/vstupdat.jpg' style='width:98%; height:20;' alt='Vstup dát' ></a></center>
</td>
<td width='20%' onClick="M2KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/mesacnespracovanie.jpg' style='width:98%; height:20;' alt='Mesaèné spracovanie' ></a></center>
</td>
<td width='20%' onClick="M3KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/informacieavystupy.jpg' style='width:98%; height:20;' alt='Informácie a vıstupy' ></a></center>
</td>
<td width='20%' onClick="M4KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/nastaveniaasluzby.jpg' style='width:98%; height:20;' alt='Nastavenia a sluby' ></a></center>
</td>
<td width='20%' onClick="M5KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/ciselnikyaudrzba.jpg' style='width:98%; height:20;' alt='Èíselníky a údrba' ></a></center>
</td>
</tr>
</table>

<div id="progmenu1" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 20; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M1ZhasniMenu();'>Menu Vstup dát</td>
<td width='10%' align='right' onClick='M1ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M1ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorMesdav();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s1-r1.jpg' style='width:98%; height:20;' alt='Nahrávanie mesaènej mzdy' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorKun();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s1-r2.jpg' style='width:98%; height:20;' alt='Údaje o zamestnancoch' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorTrn();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s1-r3.jpg' style='width:98%; height:20;' alt='Trvalé mzdové poloky' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDDP();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s1-r4.jpg' style='width:98%; height:20;' alt='Doplnkové dôchodkové poistenie' ></a></center></td></tr>


</FORM>
</table>
</div>

<div id="progmenu2" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 300; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M2ZhasniMenu();'>Menu Mesaèné spracovanie</td>
<td width='10%' align='right' onClick='M2ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M2ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="Messprac();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s2-r1.jpg' style='width:98%; height:20;' alt='Spracovanie nahratıch miezd - OSTRÉ' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Mnesprac();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s2-r2.jpg' style='width:98%; height:20;' alt='Spracovanie nahratıch miezd - NEOSTRÉ' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Pasky();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s2-r3.jpg' style='width:98%; height:20;' alt='Vıplatné pásky' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Vypli();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s2-r4.jpg' style='width:98%; height:20;' alt='Vıplatná listina a mincovka - DOBIERKA' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Priku();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s2-r5.jpg' style='width:98%; height:20;' alt='Príkazy na úhradu miezd a odvodov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Socpoist();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s2-r6.jpg' style='width:98%; height:20;' alt='Vıkazy pre Sociálnu poisovòu' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Zdravpoist();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s2-r7.jpg' style='width:98%; height:20;' alt='Vıkazy pre Zdravotné poisovne' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Meszost();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s2-r8.jpg' style='width:98%; height:20;' alt='Mesaèné mzdové zostavy' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Zrusmes();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s2-r9.jpg' style='width:98%; height:20;' alt='Zrušenie ostrého spracovania miezd' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="PreUct();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s2-r10.jpg' style='width:98%; height:20;' alt='Prevod do úètovníctva' ></a></center></td></tr>



</FORM>
</table>
</div>


<div id="progmenu3" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 470; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M3ZhasniMenu();'>Menu Informácie a vıstupy</td>
<td width='10%' align='right' onClick='M3ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M3ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="MzdEvid();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s3-r1.jpg' style='width:98%; height:20;' alt='Mzdové, evidenèné listy, potvrdenia' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Priemery();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s3-r2.jpg' style='width:98%; height:20;' alt='Priemery na náhrady a nemocenské' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="RZ_dane();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s3-r3.jpg' style='width:98%; height:20;' alt='Daò z príjmov FO - potvrdenia,RZ,daò.priznanie' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Roczdr();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s3-r4.jpg' style='width:98%; height:20;' alt='Zdravotné poistenie - potvrdenia, iadosti, RZ' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="sttzos();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s3-r5.jpg' style='width:98%; height:20;' alt='Štatistika a vıkazníctvo' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="tlaczam();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s3-r6.jpg' style='width:98%; height:20;' alt='Tlaè z údajov o zamestnancoch' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="personal();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s3-r7.jpg' style='width:98%; height:20;' alt='Personálne zmluvy a dohody so zamestnancami' ></a></center></td></tr>


</FORM>
</table>
</div>

<div id="progmenu4" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 740; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M4ZhasniMenu();'>Menu Nastavenia a sluby</td>
<td width='10%' align='right' onClick='M4ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M4ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir191();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s4-r1.jpg' style='width:98%; height:20;' alt='Parametre programu Mzdy' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Drm();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s4-r2.jpg' style='width:98%; height:20;' alt='Druhy mzdovıch zloiek' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Pomery();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s4-r3.jpg' style='width:98%; height:20;' alt='Druhy pracovnıch pomerov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="ZdrvPois();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s4-r4.jpg' style='width:98%; height:20;' alt='Zdravotné poisovne' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Dss();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s4-r5.jpg' style='width:98%; height:20;' alt='Zoznam DSS' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Ddp();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s4-r6.jpg' style='width:98%; height:20;' alt='Zoznam DDP' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Parametre();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s4-r7.jpg' style='width:98%; height:20;' alt='Sadzby ZP, SP, Daò z príjmov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Uctovanie();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s4-r8.jpg' style='width:98%; height:20;' alt='Úètovanie miezd' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDban();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s4-r9.jpg' style='width:98%; height:20;' alt='Druhy bankovıch úètov' ></a></center></td></tr>

</FORM>
</table>
</div>

<div id="progmenu5" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 900; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M5ZhasniMenu();'>Menu Èíselníky a údrba</td>
<td width='10%' align='right' onClick='M5ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M5ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir1();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s5-r1.jpg' style='width:98%; height:20;' alt='Údaje o firme' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCico();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s5-r2.jpg' style='width:98%; height:20;' alt='Èíselník IÈO' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCstr();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s5-r3.jpg' style='width:98%; height:20;' alt='Èíselník stredísk' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCzak();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s5-r4.jpg' style='width:98%; height:20;' alt='Èíselník zákaziek' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsku();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s5-r5.jpg' style='width:98%; height:20;' alt='Èíselník skupín' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsta();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s5-r6.jpg' style='width:98%; height:20;' alt='Èíselník stavieb' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="Ezakaznik();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s5-r7.jpg' style='width:98%; height:20;' alt='E-zákazníci' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="ZalDat();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r9.jpg' style='width:98%; height:20;' alt='Zálohovanie dát' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="PrenosPoc();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/mzdy/s5-r8.jpg' style='width:98%; height:20;' alt='Prenos poè.stavu' ></a></center></td></tr>


</FORM>
</table>
</div>

<?php
} 
?>


<?php
if( $newmenu == 0 ) 
{ 
?>
<span style="position:absolute; top:70; ">
<table class="pmenu" width="100%" border=1 >
<tr>
<span onclick="M1.Klepnuti(); return false; ">
<td width="20%" ><center>Vstup dát</center></td>
</span>

<span  onclick="M2.Klepnuti(); return false;  ">
<td width="20%" ><center>Mesaèné spracovanie</center></td>
</span>

<span  onclick="M3.Klepnuti(); return false;  ">
<td width="20%" ><center>Informácie a vıstupy</center></td>
</span>

<span  onclick="M4.Klepnuti(); return false; ">
<td width="20%" ><center>Nastavenia a sluby</center></td>
</span>

<span  onclick="M5.Klepnuti(); return false; ">
<td width="20%" ><center>Èíselníky a údrba</center></td>
</span>
</tr>
</table>
</span>
<?php
} 
?>

<br />
<br />
<br />
<br />
<br />
<br />
<br />


<?php 
// zmena ume
if ( $copern == 23 OR $copern == 24 )
     {
?>
<span style="position:absolute; top:70; left:10; ">
<table class="fmenu" width="30%" >
<FORM name="fir1" class="obyc" method="post" action="mzdy.php?copern=25&newmenu=<?php echo "$newmenu";?>" >
<tr>
<td class="obyc">
<select size="12" name="umes" id="umes" >

<option value="01.<?php echo $vyb_rok;?>" selected='selected'
 >01.<?php echo $vyb_rok;?></option>
<option value="02.<?php echo $vyb_rok;?>"
 >02.<?php echo $vyb_rok;?></option>
<option value="03.<?php echo $vyb_rok;?>"
 >03.<?php echo $vyb_rok;?></option>
<option value="04.<?php echo $vyb_rok;?>"
 >04.<?php echo $vyb_rok;?></option>
<option value="05.<?php echo $vyb_rok;?>"
 >05.<?php echo $vyb_rok;?></option>
<option value="06.<?php echo $vyb_rok;?>"
 >06.<?php echo $vyb_rok;?></option>
<option value="07.<?php echo $vyb_rok;?>"
 >07.<?php echo $vyb_rok;?></option>
<option value="08.<?php echo $vyb_rok;?>"
 >08.<?php echo $vyb_rok;?></option>
<option value="09.<?php echo $vyb_rok;?>"
 >09.<?php echo $vyb_rok;?></option>
<option value="10.<?php echo $vyb_rok;?>"
 >10.<?php echo $vyb_rok;?></option>
<option value="11.<?php echo $vyb_rok;?>"
 >11.<?php echo $vyb_rok;?></option>
<option value="12.<?php echo $vyb_rok;?>"
 >12.<?php echo $vyb_rok;?></option>

</td>
</tr>
<tr>
<INPUT type="hidden" id="firs" name="firs" value="<?php echo $vyb_xcf;?>" >
<td class="obyc"><INPUT type="submit" id="umev" name="umev" value="Vybra úètovné obdobie" ></td>
</tr>
</FORM>
</table>
</span>
<?php
     }
//toto je koniec zmeny ume


if ( $copern == 22 )
     {
$pole = explode(",", $kli_txt1);

$pole0 = explode("-", $pole[0]);
$kli_fmin0=$pole0[0];
$kli_fmax0=$pole0[1];
$akefirmy = "( xcf >= $kli_fmin0 AND xcf <= $kli_fmax0 )";

$pole1 = explode("-", $pole[1]);
$kli_fmin1=$pole1[0];
$kli_fmax1=$pole1[1];
$cislo=1*$kli_fmin1;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin1 AND xcf <= $kli_fmax1 )";

$pole2 = explode("-", $pole[2]);
$kli_fmin2=$pole2[0];
$kli_fmax2=$pole2[1];
$cislo=1*$kli_fmin2;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin2 AND xcf <= $kli_fmax2 )";

$pole3 = explode("-", $pole[3]);
$kli_fmin3=$pole3[0];
$kli_fmax3=$pole3[1];
$cislo=1*$kli_fmin3;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin3 AND xcf <= $kli_fmax3 )";

$pole4 = explode("-", $pole[4]);
$kli_fmin4=$pole4[0];
$kli_fmax4=$pole4[1];
$cislo=1*$kli_fmin4;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin4 AND xcf <= $kli_fmax4 )";

$pole5 = explode("-", $pole[5]);
$kli_fmin5=$pole5[0];
$kli_fmax5=$pole5[1];
$cislo=1*$kli_fmin5;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin5 AND xcf <= $kli_fmax5 )";

$pole6 = explode("-", $pole[6]);
$kli_fmin6=$pole6[0];
$kli_fmax6=$pole6[1];
$cislo=1*$kli_fmin6;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin6 AND xcf <= $kli_fmax6 )";

$pole7 = explode("-", $pole[7]);
$kli_fmin7=$pole7[0];
$kli_fmax7=$pole7[1];
$cislo=1*$kli_fmin7;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin7 AND xcf <= $kli_fmax7 )";

$pole8 = explode("-", $pole[8]);
$kli_fmin8=$pole8[0];
$kli_fmax8=$pole8[1];
$cislo=1*$kli_fmin8;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin8 AND xcf <= $kli_fmax8 )";

$pole9 = explode("-", $pole[9]);
$kli_fmin9=$pole9[0];
$kli_fmax9=$pole9[1];
$cislo=1*$kli_fmin9;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin9 AND xcf <= $kli_fmax9 )";

if( $akefirmy == "( xcf >= 0 AND xcf <= 0 )" ) { $setuzfir = include("cis/vybuzfir.php"); }

$sql = mysql_query("SELECT xcf,naz FROM $mysqldbfir.fir WHERE ( $akefirmy ) AND SUBSTRING(prav,$kli_uzid,1) != 'n' ORDER BY xcf");
// celkom poloziek
// $cpol = mysql_num_rows($sql);
?>

<span style="position:absolute; top:70; left:10; ">
<table class="fmenu" width="30%" >
<FORM name="fir1" class="obyc" method="post" action="mzdy.php?copern=23&newmenu=<?php echo "$newmenu";?>" >
<tr>
<td class="obyc">
<select size="10" name="firs" id="firs" >
<?php while($zaznam=mysql_fetch_array($sql)):?>

<option value="<?php echo $zaznam["xcf"];?>"
<?php

if ( $zaznam["xcf"] == $vyb_xcf ) echo " selected='selected'";

?>
 ><?php echo $zaznam["xcf"];?> - <?php echo $zaznam["naz"];?></option>

<?php endwhile;?>
</td>
</tr>
<tr>
<INPUT type="hidden" id="umes" name="umes" value="<?php echo $vyb_ume;?>" >
<td class="obyc"><INPUT type="submit" id="firv" name="firv" value="Vybra úètovnú jednotku" ></td>
</tr>
</FORM>
</table>
</span>

<?php
mysql_close();
mysql_free_result($sql);

// toto je koniec zmeny firmy 
     }

$akyrobot = include("akyrobot.php");
?>

<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 200; top: 200; left: 40; width:60; height:100;">
<img border=0 src='../obr/robot/<?php echo $robot3;?>.jpg' style='' onClick="zobraz_robotmenu();"
 alt='Dobrı deò , ja som Váš EkoRobot , ak máte otázku alebo nejaké elanie kliknite na mòa prosím 1x myšou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 alt='Zhasni EkoRobota' >
</div>
<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 150; left: 90; width:200; height:100;">
zobrazene menu
</div>
<?php

$robot=1;
$absolut=1;
$zmenume=1; $odkaz="../mzdy.php?copern=1&newmenu=$newmenu";
$cislista = include("mzdy/mzd_lista.php");


// celkovy koniec dokumentu
       } while (false);
?>

</BODY>
</HTML>
