<HTML>
<?php

do
{
$sys = 'MZD';
$zana = 1*$_REQUEST['zana'];
if( $zana == 1 ) $sys="ANA";

$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if(!isset($fort)) $fort = 1;

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_oc = $_REQUEST['cislo_oc'];
$cislo_obdobie = 1*$_REQUEST['cislo_obdobie'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$podmoc=" = ".$cislo_oc;
if( $cislo_oc == 999999 ) $podmoc=" >= 0 ";

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
   r01          DECIMAL(10,2) DEFAULT 0,
   r02          DECIMAL(10,2) DEFAULT 0,
   r03          DECIMAL(10,2) DEFAULT 0,
   r04          DECIMAL(10,2) DEFAULT 0,
   r05          DECIMAL(10,2) DEFAULT 0,
   r06          DECIMAL(10,2) DEFAULT 0,
   r07          DECIMAL(10,2) DEFAULT 0,
   r08          DECIMAL(10,2) DEFAULT 0,
   r09          DECIMAL(10,2) DEFAULT 0,
   r10          DECIMAL(10,2) DEFAULT 0,
   r11          DECIMAL(10,2) DEFAULT 0,
   r12          DECIMAL(10,2) DEFAULT 0,
   rspolu       DECIMAL(10,2) DEFAULT 0,
   r4d01          DECIMAL(10,4) DEFAULT 0,
   r4d02          DECIMAL(10,4) DEFAULT 0,
   r4d03          DECIMAL(10,4) DEFAULT 0,
   r4d04          DECIMAL(10,4) DEFAULT 0,
   r4d05          DECIMAL(10,4) DEFAULT 0,
   r4d06          DECIMAL(10,4) DEFAULT 0,
   r4d07          DECIMAL(10,4) DEFAULT 0,
   r4d08          DECIMAL(10,4) DEFAULT 0,
   r4d09          DECIMAL(10,4) DEFAULT 0,
   r4d10          DECIMAL(10,4) DEFAULT 0,
   r4d11          DECIMAL(10,4) DEFAULT 0,
   r4d12          DECIMAL(10,4) DEFAULT 0,
   r4dspolu       DECIMAL(10,4) DEFAULT 0,
   r0d01          DECIMAL(10,0) DEFAULT 0,
   r0d02          DECIMAL(10,0) DEFAULT 0,
   r0d03          DECIMAL(10,0) DEFAULT 0,
   r0d04          DECIMAL(10,0) DEFAULT 0,
   r0d05          DECIMAL(10,0) DEFAULT 0,
   r0d06          DECIMAL(10,0) DEFAULT 0,
   r0d07          DECIMAL(10,0) DEFAULT 0,
   r0d08          DECIMAL(10,0) DEFAULT 0,
   r0d09          DECIMAL(10,0) DEFAULT 0,
   r0d10          DECIMAL(10,0) DEFAULT 0,
   r0d11          DECIMAL(10,0) DEFAULT 0,
   r0d12          DECIMAL(10,0) DEFAULT 0,
   r0dspolu       DECIMAL(10,0) DEFAULT 0,
   konxx        DECIMAL(10,0) DEFAULT 0,
   dm           INT(7) DEFAULT 0,
   dmx          INT(7) DEFAULT 0,
   kc           DECIMAL(10,4) DEFAULT 0,
   ume          DECIMAL(7,4) DEFAULT 0,
   konx1        DECIMAL(10,0) DEFAULT 0,
   konx2        DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid.$sqlt;
//$vytvor = mysql_query("$vsql");


//zober kc zloziek mzdy z mzdzalvy
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,".
"2,dm,dm,kc,ume,".
"30,0".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE F$kli_vxcf"."_mzdzalvy.oc $podmoc  AND konx != 9999".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober dni zloziek mzdy z mzdzalvy
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,".
"2,dm,dm,dni,ume,".
"10,0".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE F$kli_vxcf"."_mzdzalvy.oc $podmoc  AND konx != 9999 AND dni != 0 AND F$kli_vxcf"."_mzdzalvy.dm < 899".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober hod zloziek mzdy z mzdzalvy
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,".
"2,dm,dm,hod,ume,".
"20,0".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE F$kli_vxcf"."_mzdzalvy.oc $podmoc  AND konx != 9999 AND hod != 0 AND F$kli_vxcf"."_mzdzalvy.dm < 599".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober dni celkom z mzdzalsum
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,".
"2,10001,10001,sum_dni,ume,".
"10,0".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober hod celkom z mzdzalsum
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,".
"2,10101,10101,sum_hod,ume,".
"20,0".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE dm = 9504 OR dm = 9505";
$oznac = mysql_query("$sqtoz");

//ak prenesene zo stareho vypocitaj v hotovosti
$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdzalsum WHERE ksum2 = 9";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp > 0 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,11120,11120,sum_hru,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND sum_hru != 0 AND ksum2 = 9 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,11120,11120,-kc,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalvy WHERE F$kli_vxcf"."_mzdzalvy.oc $podmoc  AND odkial = 0 AND kcsk = 0 AND F$kli_vxcf"."_mzdzalvy.dm > 900 AND F$kli_vxcf"."_mzdzalvy.dm < 990 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,11120,11120,kc,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalvy WHERE F$kli_vxcf"."_mzdzalvy.oc $podmoc  AND odkial = 0 AND kcsk = 0 AND F$kli_vxcf"."_mzdzalvy.dm = 529 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,11120,11120,kc,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalvy WHERE F$kli_vxcf"."_mzdzalvy.oc $podmoc  AND odkial = 0 AND kcsk = 0 AND F$kli_vxcf"."_mzdzalvy.dm = 803 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,11120,11120,kc,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalvy WHERE F$kli_vxcf"."_mzdzalvy.oc $podmoc  AND odkial = 0 AND kcsk = 0 AND F$kli_vxcf"."_mzdzalvy.dm = 804 ";
$dsql = mysql_query("$dsqlt");
}
//koniec ak prenesene zo stareho vypocitaj v hotovosti

//zober hru,hot,ban..
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,11110,11110,sum_hru,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND sum_hru != 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,11120,11120,sum_hot,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND sum_hot != 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,11130,11130,sum_ban,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND sum_ban != 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,11140,11140,(zdan_dnp+pdan_zn1-ozam_spolu),ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND zdan_dnp != 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,11141,11141,pdan_dnv,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND pdan_dnv > 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,11150,11150,cista_mzda,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND cista_mzda != 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,11160,11160,sum_cccp,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND sum_cccp != 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,11170,11170,ddp_fir,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND ddp_fir > 0";
$dsql = mysql_query("$dsqlt");

//zober zaklady do zp,sp
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,20101,20101,zzam_zp,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND zzam_zp > 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,20102,20102,ozam_zp,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND ozam_zp > 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,20201,20201,zzam_np,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND zzam_np > 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,20202,20202,ozam_np,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND ozam_np > 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,20301,20301,zzam_sp,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND zzam_sp > 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,20302,20302,ozam_sp,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND ozam_sp > 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,20401,20401,zzam_ip,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND zzam_ip > 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,20402,20402,ozam_ip,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND ozam_ip > 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,20501,20501,zzam_pn,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND zzam_pn > 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,20502,20502,ozam_pn,ume,120,0".
" FROM F$kli_vxcf"."_mzdzalsum WHERE F$kli_vxcf"."_mzdzalsum.oc $podmoc  AND ozam_pn > 0";
$dsql = mysql_query("$dsqlt");


//zober znah,znem..
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,30110,30110,znah,ume,220,0".
" FROM F$kli_vxcf"."_mzdzalkun WHERE F$kli_vxcf"."_mzdzalkun.oc $podmoc  AND znah != 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,30120,30120,znem,ume,220,0".
" FROM F$kli_vxcf"."_mzdzalkun WHERE F$kli_vxcf"."_mzdzalkun.oc $podmoc  AND znem != 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,40110,40110,pom,ume,220,0".
" FROM F$kli_vxcf"."_mzdzalkun WHERE F$kli_vxcf"."_mzdzalkun.oc $podmoc  AND pom != 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SELECT oc,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,40120,40120,zdrv,ume,220,0".
" FROM F$kli_vxcf"."_mzdzalkun WHERE F$kli_vxcf"."_mzdzalkun.oc $podmoc  AND zdrv != 0";
$dsql = mysql_query("$dsqlt");


//rozdel do januar az december 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r01=kc, r4d01=kc, r0d01=kc WHERE ume = 1.$kli_vrok";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r02=kc, r4d02=kc, r0d02=kc WHERE ume = 2.$kli_vrok";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r03=kc, r4d03=kc, r0d03=kc WHERE ume = 3.$kli_vrok";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r04=kc, r4d04=kc, r0d04=kc WHERE ume = 4.$kli_vrok";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r05=kc, r4d05=kc, r0d05=kc WHERE ume = 5.$kli_vrok";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r06=kc, r4d06=kc, r0d06=kc WHERE ume = 6.$kli_vrok";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r07=kc, r4d07=kc, r0d07=kc WHERE ume = 7.$kli_vrok";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r08=kc, r4d08=kc, r0d08=kc WHERE ume = 8.$kli_vrok";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r09=kc, r4d09=kc, r0d09=kc WHERE ume = 9.$kli_vrok";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r10=kc, r4d10=kc, r0d10=kc WHERE ume = 10.$kli_vrok";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r11=kc, r4d11=kc, r0d11=kc WHERE ume = 11.$kli_vrok";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r12=kc, r4d12=kc, r0d12=kc WHERE ume = 12.$kli_vrok";
$oznac = mysql_query("$sqtoz");


//sumarizuj za oc
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
"sum(r01),sum(r02),sum(r03),sum(r04),sum(r05),sum(r06),sum(r07),sum(r08),sum(r09),sum(r10),sum(r11),sum(r12),sum(rspolu),".
"sum(r4d01),sum(r4d02),sum(r4d03),sum(r4d04),sum(r4d05),sum(r4d06),sum(r4d07),sum(r4d08),sum(r4d09),sum(r4d10),sum(r4d11),sum(r4d12),sum(r4dspolu),".
"sum(r0d01),sum(r0d02),sum(r0d03),sum(r0d04),sum(r0d05),sum(r0d06),sum(r0d07),sum(r0d08),sum(r0d09),sum(r0d10),sum(r0d11),sum(r0d12),sum(r0dspolu),".
"3,dm,dmx,0,0,".
"konx1,2".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" GROUP BY oc,dm,konx1".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konxx = 2";
$oznac = mysql_query("$sqtoz");

//ochrana ak vyplata v hotovosti < 0 vymaz
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r01 = 0 WHERE dmx = 11120 AND r01 < 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r02 = 0 WHERE dmx = 11120 AND r02 < 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r03 = 0 WHERE dmx = 11120 AND r03 < 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r04 = 0 WHERE dmx = 11120 AND r04 < 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r05 = 0 WHERE dmx = 11120 AND r05 < 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r06 = 0 WHERE dmx = 11120 AND r06 < 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r07 = 0 WHERE dmx = 11120 AND r07 < 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r08 = 0 WHERE dmx = 11120 AND r08 < 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r09 = 0 WHERE dmx = 11120 AND r09 < 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r10 = 0 WHERE dmx = 11120 AND r10 < 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r11 = 0 WHERE dmx = 11120 AND r11 < 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r12 = 0 WHERE dmx = 11120 AND r12 < 0"; $oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE dmx = 11120 AND r01 = 0 AND r02 = 0 AND r03 = 0 AND r04 = 0 AND r05 = 0 AND r06 = 0 ".
" AND r07 = 0 AND r08 = 0 AND r09 = 0 AND r10 = 0 AND r11 = 0 AND r12 = 0 ";
$oznac = mysql_query("$sqtoz");

//vypocitaj spolu
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET r4dspolu=r4d01+r4d02+r4d03+r4d04+r4d05+r4d06+r4d07+r4d08+r4d09+r4d10+r4d11+r4d12,".
" r0dspolu=r0d01+r0d02+r0d03+r0d04+r0d05+r0d06+r0d07+r0d08+r0d09+r0d10+r0d11+r0d12,".
" rspolu=r01+r02+r03+r04+r05+r06+r07+r08+r09+r10+r11+r12 ";

$oznac = mysql_query("$sqtoz");

//oznac na 4desatinne
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET konx2=4".
" WHERE dmx = 30110 OR dmx = 30120 ";
$oznac = mysql_query("$sqtoz");

//oznac na 0desatinne
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET konx2=0".
" WHERE dmx = 40110 OR dmx = 40120 ";
$oznac = mysql_query("$sqtoz");

//exit;

}
//koniec pracovneho suboru 

//zaverecny riadok za oc
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,".
"sum(r01),sum(r02),sum(r03),sum(r04),sum(r05),sum(r06),sum(r07),sum(r08),sum(r09),sum(r10),sum(r11),sum(r12),sum(rspolu),".
"sum(r4d01),sum(r4d02),sum(r4d03),sum(r4d04),sum(r4d05),sum(r4d06),sum(r4d07),sum(r4d08),sum(r4d09),sum(r4d10),sum(r4d11),sum(r4d12),sum(r4dspolu),".
"sum(r0d01),sum(r0d02),sum(r0d03),sum(r0d04),sum(r0d05),sum(r0d06),sum(r0d07),sum(r0d08),sum(r0d09),sum(r0d10),sum(r0d11),sum(r0d12),sum(r0dspolu),".
"3,dm,dmx,0,0,".
"900,2".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


/////////////NACITANIE UDAJOV Z PARAMETROV
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  }

/////////////////////////////////////////////////VYTLAC MZDOVY LIST
if( $copern == 10 )
{

if (File_Exists ("../tmp/mzdovyLIST.$kli_uzid.pdf")) { $soubor = unlink("../tmp/mzdovyLIST.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzddmn".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".dm=F$kli_vxcf"."_mzddmn.dm".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc $podmoc  ".
" ORDER BY F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc,konx1,F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".dm";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$druhastrana=0;

  while ($i < $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

  $ozam_np = $hlavicka->ozam_np;
  $pole = explode(".", $ozam_np);
  $Cozam_np = $pole[0];
  $Dozam_np = substr($pole[1],0,1);

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 


//hlavicka
if( $j == 0 )
{

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(20);

$pdf->SetY(10);
$pdf->SetFont('arial','',10);
$obdobie=$kli_vrok;


$pdf->Cell(10,4,"1.strana","0",0,"L");$pdf->Cell(0,4,"MZDOVÝ LIST","0",1,"C");
$pdf->Cell(25,4,"$obdobie","1",0,"L");
$pdf->Cell(0,4,"Zamestnávate¾: $fir_fnaz, $fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc, IÈO: $fir_fico, tel: $fir_ftel","1",1,"L");
$pdf->Cell(25,4,"Zamestnanec:","L",0,"L");
$pdf->Cell(0,4,"$hlavicka->titl $hlavicka->meno $hlavicka->prie rodné èíslo: $hlavicka->rdc $hlavicka->rdk osè: $hlavicka->oc rodné priezvisko: $hlavicka->rodn","R",1,"L");
$pdf->Cell(25,4,"Adresa:","L",0,"L");
$pdf->Cell(0,4,"$hlavicka->zuli $hlavicka->zcdm, $hlavicka->zmes, $hlavicka->zpsc","R",1,"L");

$dan_sk=SkDatum($hlavicka->dan);
$dav_sk=SkDatum($hlavicka->dav);
if( $dav_sk == '00.00.0000' ) $dav_sk="";
$dvp_sk=SkDatum($hlavicka->dvp);
if( $dvp_sk == '00.00.0000' ) $dvp_sk="";
$dsp_sk=SkDatum($hlavicka->dsp);
if( $dsp_sk == '00.00.0000' ) $dsp_sk="";

$pdf->Cell(30,4,"Dátum nástupu:","L",0,"L");$pdf->Cell(50,4,"$dan_sk","0",0,"L");
$pdf->Cell(40,4,"Poistený v ZP $hlavicka->zdrv od:","0",0,"L");$pdf->Cell(20,4,"$dvp_sk","0",0,"L");
$pdf->Cell(0,4," ","R",1,"L");

$pdf->Cell(30,4,"Úväzok hod/deò:","L",0,"L");$pdf->Cell(50,4,"$hlavicka->uva","0",0,"L");
$pdf->Cell(40,4,"Poistený v SP od:","0",0,"L");$pdf->Cell(20,4,"$dsp_sk","0",0,"L");
$pdf->Cell(0,4," ","R",1,"L");

$pdf->Cell(30,4,"Dátum výstupu:","L",0,"L");$pdf->Cell(50,4,"$dav_sk","0",0,"L");
$pdf->Cell(40,4,"Pracovný pomer:","0",0,"L");$pdf->Cell(20,4,"$hlavicka->pom","0",0,"L");
$pdf->Cell(0,4," ","R",1,"L");

$pdf->Cell(277,1,"","LRB",1,"L");

$pdf->SetFont('arial','',7);

$pdf->Cell(43,4," ","1",0,"R");
$pdf->Cell(18,4,"január","1",0,"R");$pdf->Cell(18,4,"február","1",0,"R");$pdf->Cell(18,4,"marec","1",0,"R");$pdf->Cell(18,4,"apríl","1",0,"R");
$pdf->Cell(18,4,"máj","1",0,"R");$pdf->Cell(18,4,"jún","1",0,"R");$pdf->Cell(18,4,"júl","1",0,"R");$pdf->Cell(18,4,"august","1",0,"R");
$pdf->Cell(18,4,"september","1",0,"R");$pdf->Cell(18,4,"október","1",0,"R");$pdf->Cell(18,4,"november","1",0,"R");$pdf->Cell(18,4,"december","1",0,"R");
$pdf->Cell(18,4,"spolu","1",1,"R");

$druhastrana=0;
}
//koniec hlavicky


//polozky
$r01=$hlavicka->r01;
if( $hlavicka->r01 == 0 ) $r01="";
$r02=$hlavicka->r02;
if( $hlavicka->r02 == 0 ) $r02="";
$r03=$hlavicka->r03;
if( $hlavicka->r03 == 0 ) $r03="";
$r04=$hlavicka->r04;
if( $hlavicka->r04 == 0 ) $r04="";
$r05=$hlavicka->r05;
if( $hlavicka->r05 == 0 ) $r05="";
$r06=$hlavicka->r06;
if( $hlavicka->r06 == 0 ) $r06="";
$r07=$hlavicka->r07;
if( $hlavicka->r07 == 0 ) $r07="";
$r08=$hlavicka->r08;
if( $hlavicka->r08 == 0 ) $r08="";
$r09=$hlavicka->r09;
if( $hlavicka->r09 == 0 ) $r09="";
$r10=$hlavicka->r10;
if( $hlavicka->r10 == 0 ) $r10="";
$r11=$hlavicka->r11;
if( $hlavicka->r11 == 0 ) $r11="";
$r12=$hlavicka->r12;
if( $hlavicka->r12 == 0 ) $r12="";

$r13=$hlavicka->r13;
if( $hlavicka->r13 == 0 ) $r13="";

//polozky 4desatinne
$r4d01=$hlavicka->r4d01;
if( $hlavicka->r4d01 == 0 ) $r4d01="";
$r4d02=$hlavicka->r4d02;
if( $hlavicka->r4d02 == 0 ) $r4d02="";
$r4d03=$hlavicka->r4d03;
if( $hlavicka->r4d03 == 0 ) $r4d03="";
$r4d04=$hlavicka->r4d04;
if( $hlavicka->r4d04 == 0 ) $r4d04="";
$r4d05=$hlavicka->r4d05;
if( $hlavicka->r4d05 == 0 ) $r4d05="";
$r4d06=$hlavicka->r4d06;
if( $hlavicka->r4d06 == 0 ) $r4d06="";
$r4d07=$hlavicka->r4d07;
if( $hlavicka->r4d07 == 0 ) $r4d07="";
$r4d08=$hlavicka->r4d08;
if( $hlavicka->r4d08 == 0 ) $r4d08="";
$r4d09=$hlavicka->r4d09;
if( $hlavicka->r4d09 == 0 ) $r4d09="";
$r4d10=$hlavicka->r4d10;
if( $hlavicka->r4d10 == 0 ) $r4d10="";
$r4d11=$hlavicka->r4d11;
if( $hlavicka->r4d11 == 0 ) $r4d11="";
$r4d12=$hlavicka->r4d12;
if( $hlavicka->r4d12 == 0 ) $r4d12="";


//polozky 0desatinne
$r0d01=$hlavicka->r0d01;
if( $hlavicka->r0d01 == 0 ) $r0d01="";
$r0d02=$hlavicka->r0d02;
if( $hlavicka->r0d02 == 0 ) $r0d02="";
$r0d03=$hlavicka->r0d03;
if( $hlavicka->r0d03 == 0 ) $r0d03="";
$r0d04=$hlavicka->r0d04;
if( $hlavicka->r0d04 == 0 ) $r0d04="";
$r0d05=$hlavicka->r0d05;
if( $hlavicka->r0d05 == 0 ) $r0d05="";
$r0d06=$hlavicka->r0d06;
if( $hlavicka->r0d06 == 0 ) $r0d06="";
$r0d07=$hlavicka->r0d07;
if( $hlavicka->r0d07 == 0 ) $r0d07="";
$r0d08=$hlavicka->r0d08;
if( $hlavicka->r0d08 == 0 ) $r0d08="";
$r0d09=$hlavicka->r0d09;
if( $hlavicka->r0d09 == 0 ) $r0d09="";
$r0d10=$hlavicka->r0d10;
if( $hlavicka->r0d10 == 0 ) $r0d10="";
$r0d11=$hlavicka->r0d11;
if( $hlavicka->r0d11 == 0 ) $r0d11="";
$r0d12=$hlavicka->r0d12;
if( $hlavicka->r0d12 == 0 ) $r0d12="";

$nazovdm=$hlavicka->dm." ".$hlavicka->nzdm;
$nazovdms = substr($nazovdm,0,43);

//polozky zamestnanca
if( $hlavicka->konx1 != 900 )
     {

if( $hlavicka->dmx == 10001 ) { $pdf->Cell(43,4,"Celkom dni","0",0,"L"); }
if( $hlavicka->dmx == 10101 ) { $pdf->Cell(43,4,"Celkom hodiny","0",0,"L"); }

if( $hlavicka->dmx >= 100 AND $hlavicka->dmx < 10000 ) { $pdf->Cell(43,4,"$nazovdms","0",0,"L"); }

if( $hlavicka->dmx == 11110 ) { $pdf->Cell(0,1," ","T",1,"L"); }

if( $hlavicka->dmx == 11110 ) { $pdf->Cell(43,4,"Hrubá mzda","0",0,"L"); }
if( $hlavicka->dmx == 11120 ) { $pdf->Cell(43,4,"Výplata v hotovosti","0",0,"L"); }
if( $hlavicka->dmx == 11130 ) { $pdf->Cell(43,4,"Výplata cez banku","0",0,"L"); }
if( $hlavicka->dmx == 11140 ) { $pdf->Cell(43,4,"Èiastkový zákl.dane","0",0,"L"); }
if( $hlavicka->dmx == 11141 ) { $pdf->Cell(43,4,"Odpoèet na daòovníka","0",0,"L"); }
if( $hlavicka->dmx == 11150 ) { $pdf->Cell(43,4,"Èistá mzda","0",0,"L"); }
if( $hlavicka->dmx == 11160 ) { $pdf->Cell(43,4,"Celková cena práce","0",0,"L"); }
if( $hlavicka->dmx == 11170 ) { $pdf->Cell(43,4,"Odvod DDP zamtel","0",0,"L"); }

if( $hlavicka->dmx == 20101 ) { $pdf->Cell(0,1," ","T",1,"L"); }

if( $hlavicka->dmx == 20101 ) { $pdf->Cell(43,4,"Základ ZP","0",0,"L"); }
if( $hlavicka->dmx == 20102 ) { $pdf->Cell(43,4,"Odvod ZP zamnec","0",0,"L"); }
if( $hlavicka->dmx == 20201 ) { $pdf->Cell(43,4,"Základ NP","0",0,"L"); }
if( $hlavicka->dmx == 20202 ) { $pdf->Cell(43,4,"Odvod NP zamnec","0",0,"L"); }
if( $hlavicka->dmx == 20301 ) { $pdf->Cell(43,4,"Základ SP","0",0,"L"); }
if( $hlavicka->dmx == 20302 ) { $pdf->Cell(43,4,"Odvod SP zamnec","0",0,"L"); }
if( $hlavicka->dmx == 20401 ) { $pdf->Cell(43,4,"Základ IP","0",0,"L"); }
if( $hlavicka->dmx == 20402 ) { $pdf->Cell(43,4,"Odvod IP zamnec","0",0,"L"); }
if( $hlavicka->dmx == 20501 ) { $pdf->Cell(43,4,"Základ PvN","0",0,"L"); }
if( $hlavicka->dmx == 20502 ) { $pdf->Cell(43,4,"Odvod PvN zamnec","0",0,"L"); }

if( $hlavicka->dmx == 30110 ) { $pdf->Cell(43,4,"Priemer na náhrady €/hodinu","0",0,"L"); }
if( $hlavicka->dmx == 30120 ) { $pdf->Cell(43,4,"Priemer na výplatu nemoc.náhrad €/deò","0",0,"L"); }

if( $hlavicka->dmx == 40110 ) { $pdf->Cell(43,4,"Pracovný pomer","0",0,"L"); }
if( $hlavicka->dmx == 40120 ) { $pdf->Cell(43,4,"Zdravotná poisovòa","0",0,"L"); }

if( $hlavicka->konx2 == 2 ) { 
$pdf->Cell(18,4,"$r01","0",0,"R");$pdf->Cell(18,4,"$r02","0",0,"R");$pdf->Cell(18,4,"$r03","0",0,"R");$pdf->Cell(18,4,"$r04","0",0,"R");
$pdf->Cell(18,4,"$r05","0",0,"R");$pdf->Cell(18,4,"$r06","0",0,"R");$pdf->Cell(18,4,"$r07","0",0,"R");$pdf->Cell(18,4,"$r08","0",0,"R");
$pdf->Cell(18,4,"$r09","0",0,"R");$pdf->Cell(18,4,"$r10","0",0,"R");$pdf->Cell(18,4,"$r11","0",0,"R");$pdf->Cell(18,4,"$r12","0",0,"R");
$pdf->Cell(18,4,"$hlavicka->rspolu","0",1,"R");
if( $hlavicka->dmx == 20502 AND $kli_vrok == 2012 AND $hlavicka->oc == 213 AND $alchem == 1  ) 
{ $pdf->Cell(0,4,"sumu 1220,11 Eur zaplatené v hotovosti Soc.poist./IP,PvN/ za 12/2009 - 10/2012","0",1,"L"); }

                           }

if( $hlavicka->konx2 == 4 ) { 
$pdf->Cell(18,4,"$r4d01","0",0,"R");$pdf->Cell(18,4,"$r4d02","0",0,"R");$pdf->Cell(18,4,"$r4d03","0",0,"R");$pdf->Cell(18,4,"$r4d04","0",0,"R");
$pdf->Cell(18,4,"$r4d05","0",0,"R");$pdf->Cell(18,4,"$r4d06","0",0,"R");$pdf->Cell(18,4,"$r4d07","0",0,"R");$pdf->Cell(18,4,"$r4d08","0",0,"R");
$pdf->Cell(18,4,"$r4d09","0",0,"R");$pdf->Cell(18,4,"$r4d10","0",0,"R");$pdf->Cell(18,4,"$r4d11","0",0,"R");$pdf->Cell(18,4,"$r4d12","0",0,"R");
$pdf->Cell(18,4,"","0",1,"R");
                           }

if( $hlavicka->konx2 == 0 ) { 
$pdf->Cell(18,4,"$r0d01","0",0,"R");$pdf->Cell(18,4,"$r0d02","0",0,"R");$pdf->Cell(18,4,"$r0d03","0",0,"R");$pdf->Cell(18,4,"$r0d04","0",0,"R");
$pdf->Cell(18,4,"$r0d05","0",0,"R");$pdf->Cell(18,4,"$r0d06","0",0,"R");$pdf->Cell(18,4,"$r0d07","0",0,"R");$pdf->Cell(18,4,"$r0d08","0",0,"R");
$pdf->Cell(18,4,"$r0d09","0",0,"R");$pdf->Cell(18,4,"$r0d10","0",0,"R");$pdf->Cell(18,4,"$r0d11","0",0,"R");$pdf->Cell(18,4,"$r0d12","0",0,"R");
$pdf->Cell(18,4,"","0",1,"R");
                           }


if( $hlavicka->dmx == 10101 ) { $pdf->Cell(0,1," ","T",1,"L"); }
if( $hlavicka->dmx == 10001 ) { $pdf->Cell(0,1," ","T",1,"L"); }


//polozky zamestnanca
//if( $hlavicka->konx1 != 900 )
     }

}
$i = $i + 1;
$j = $j + 1;

if( $j >= 35 AND $druhastrana == 0 )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(20);

$pdf->SetY(10);
$pdf->SetFont('arial','',10);

$pdf->Cell(10,4,"2.strana","0",0,"L");$pdf->Cell(0,4,"MZDOVÝ LIST","0",1,"C");
$pdf->Cell(25,4,"$obdobie","1",0,"L");
$pdf->Cell(0,4,"Zamestnávate¾: $fir_fnaz, $fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc, IÈO: $fir_fico, tel: $fir_ftel","1",1,"L");
$pdf->Cell(25,4,"Zamestnanec:","LB",0,"L");
$pdf->Cell(0,4,"$hlavicka->titl $hlavicka->meno $hlavicka->prie rodné èíslo: $hlavicka->rdc $hlavicka->rdk osè: $hlavicka->oc","RB",1,"L");

$pdf->SetFont('arial','',7);

$pdf->Cell(43,4," ","1",0,"R");
$pdf->Cell(18,4,"január","1",0,"R");$pdf->Cell(18,4,"február","1",0,"R");$pdf->Cell(18,4,"marec","1",0,"R");$pdf->Cell(18,4,"apríl","1",0,"R");
$pdf->Cell(18,4,"máj","1",0,"R");$pdf->Cell(18,4,"jún","1",0,"R");$pdf->Cell(18,4,"júl","1",0,"R");$pdf->Cell(18,4,"august","1",0,"R");
$pdf->Cell(18,4,"september","1",0,"R");$pdf->Cell(18,4,"október","1",0,"R");$pdf->Cell(18,4,"november","1",0,"R");$pdf->Cell(18,4,"december","1",0,"R");
$pdf->Cell(18,4,"spolu","1",1,"R");

$druhastrana=1;

}


//za kazdim zamestnancom daj deti a prerusenia
if( $hlavicka->konx1 == 900 )
     {

//zisti deti
$sqldttt = "SELECT * FROM F$kli_vxcf"."_mzddeti WHERE oc = $hlavicka->oc ORDER BY dr";

$sqldt = mysql_query("$sqldttt");
$poldt = mysql_num_rows($sqldt);

//zisti prerusenia
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   dok          INT(8) DEFAULT 0,
   dat          DATE not null,
   ume          DECIMAL(7,4),
   dm           INT(4) DEFAULT 0,
   dp           DATE not null,
   dk           DATE not null,
   dni          DECIMAL(10,2) DEFAULT 0,
   hod          DECIMAL(10,2) DEFAULT 0,
   mnz          DECIMAL(10,4) DEFAULT 0,
   saz          DECIMAL(10,4) DEFAULT 0,
   kc           DECIMAL(10,2) DEFAULT 0,
   konx1        DECIMAL(10,0) DEFAULT 0,
   konx2        DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplp'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


//zober zlozky mzdy z mzdzalvy
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplp".$kli_uzid.
" SELECT oc,".
" dok,dat,ume,dm,dp,dk,dni,hod,mnz,saz,kc,0,0".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE F$kli_vxcf"."_mzdzalvy.oc = $hlavicka->oc AND F$kli_vxcf"."_mzdzalvy.dp != '0000-00-00' ".
" AND F$kli_vxcf"."_mzdzalvy.dm < 900 AND F$kli_vxcf"."_mzdzalvy.dm > 499 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcvyplp".$kli_uzid." WHERE dm < 799 AND dm != 502 AND dm != 503 ";
$dsql = mysql_query("$dsqlt");

$sqldttn = "SELECT * FROM F$kli_vxcf"."_mzdprcvyplp$kli_uzid ".
" LEFT JOIN F$kli_vxcf"."_mzddmn".
" ON F$kli_vxcf"."_mzdprcvyplp".$kli_uzid.".dm=F$kli_vxcf"."_mzddmn.dm".
" WHERE oc = $hlavicka->oc ORDER BY oc,dp";

$sqldn = mysql_query("$sqldttn");
$poldn = mysql_num_rows($sqldn);


$poznamkytext="";
$sqltttd = "SELECT * FROM F$kli_vxcf"."_mzdtextmzdlist WHERE invt = $hlavicka->oc ";
$sqldokd = mysql_query("$sqltttd");
  if (@$zaznam=mysql_data_seek($sqldokd,0))
  {
  $riaddokd=mysql_fetch_object($sqldokd);
  $poznamkytext=$riaddokd->itxt;
  }

$kprc=0; 
$sqldokkp = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt=$hlavicka->oc ");
  if (@$zaznam=mysql_data_seek($sqldokkp,0))
  {
  $riaddokkp=mysql_fetch_object($sqldokkp);
  $kprc=1*$riaddokkp->kprc;
  }

//druha strana
if( $druhastrana >= 0 AND ( $poldn > 0 OR $poldt > 0 OR $poznamkytext != '' OR $kprc == 1 ))
{
//echo "idem";
//exit;

if( $druhastrana == 0 )
     {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(20);

$pdf->SetY(10);
$pdf->SetFont('arial','',10);

$pdf->Cell(10,4,"2.strana","0",0,"L");$pdf->Cell(0,4,"MZDOVÝ LIST","0",1,"C");
$pdf->Cell(25,4,"$obdobie","1",0,"L");
$pdf->Cell(0,4,"Zamestnávate¾: $fir_fnaz, $fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc, IÈO: $fir_fico, tel: $fir_ftel","1",1,"L");
$pdf->Cell(25,4,"Zamestnanec:","LB",0,"L");
$pdf->Cell(0,4,"$hlavicka->titl $hlavicka->meno $hlavicka->prie rodné èíslo: $hlavicka->rdc $hlavicka->rdk osè: $hlavicka->oc","RB",1,"L");
     }

//poznamky na mzdovom liste

if( $poznamkytext != '' )
  {
$pdf->Cell(0,1,"","B",1,"L");

$pole = explode("\r\n", $poznamkytext);

$ipole=1;
foreach( $pole as $hodnota ) {
 $pdf->Cell(0,5,"$hodnota","0",1,"L"); 
$ipole=$ipole+1;
}

  }

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

$preh=$kprh;
$pree=$kpre;

$tabulkavy="_mzdzalvy";

$pluh=0; $plue=0;
$sqldoktt = "SELECT SUM(kc) AS kc, SUM(hod) AS hod FROM F$kli_vxcf"."$tabulkavy WHERE dm = $dmp AND oc=$hlavicka->oc  GROUP BY oc";
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

$minh=0; $mine=0;
$sqldoktt = "SELECT SUM(kc) AS kc, SUM(hod) AS hod FROM F$kli_vxcf"."$tabulkavy WHERE dm = $dmm AND oc=$hlavicka->oc GROUP BY oc";
$sqldokkp = mysql_query("$sqldoktt ");
  if (@$zaznam=mysql_data_seek($sqldokkp,0))
  {
  $riaddokkp=mysql_fetch_object($sqldokkp);
  $kc=-1*$riaddokkp->kc;
  $hod=-1*$riaddokkp->hod;
$minh=$hod;
$mine=$kc; 
  }

$zosh=$preh+$pluh-$minh; $zose=$pree+$plue-$mine;
if( $zosh != 0 AND $zose == 0 ) { $zose=$zosh*$pcen; }

$pdf->Cell(25,3," ","0",1,"L");
$pdf->SetFont('arial','',7);
$pdf->Cell(90,3,"Konto pracovného èasu §87a Zák.311/2001 a nasl. Z.z. - Zákonník práce ","0",0,"L"); 
$pdf->SetFont('arial','',10);
$pdf->Cell(35,3,"Prenos: $preh h/$pree e ","0",0,"L"); 
$pdf->Cell(35,3,"$kli_vrok(+): $pluh h/$plue e ","0",0,"L");
$pdf->Cell(35,3,"$kli_vrok(-): $minh h/$mine e ","0",0,"L");
$pdf->Cell(35,3,"Zostatok: $zosh h/$zose e ","0",1,"L");
                 }

//deti
$mdt1=""; $rcdt1=''; $msdt1="";
$mdt2=""; $rcdt2=''; $msdt2="";
$mdt3=""; $rcdt3=''; $msdt3="";
$mdt4=""; $rcdt4=''; $msdt4="";
$mdt5=""; $rcdt5=''; $msdt5="";
$mdt6=""; $rcdt6=''; $msdt6="";


$idt=0;
  while ($idt <= $poldt )
  {
  if (@$zaznam=mysql_data_seek($sqldt,$idt))
{
$deti=mysql_fetch_object($sqldt);

$dr_sk=SkDatum($deti->dr);

if( $idt == 0 ) { $mdt1=$deti->md; $rcdt1=$dr_sk; $msdt1="1-12"; }
if( $idt == 1 ) { $mdt2=$deti->md; $rcdt2=$dr_sk; $msdt2="1-12"; }
if( $idt == 2 ) { $mdt3=$deti->md; $rcdt3=$dr_sk; $msdt3="1-12"; }
if( $idt == 3 ) { $mdt4=$deti->md; $rcdt4=$dr_sk; $msdt4="1-12"; }
if( $idt == 4 ) { $mdt5=$deti->md; $rcdt5=$dr_sk; $msdt5="1-12"; }
if( $idt == 5 ) { $mdt6=$deti->md; $rcdt6=$dr_sk; $msdt6="1-12"; }

if( $idt == 0 )
  {
$pdf->SetFont('arial','',10);
$pdf->Cell(145,4," ","0",1,"L");
$pdf->Cell(160,4,"Deti , na ktoré bol uplatnený daòový bonus","1",1,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(50,4,"meno ","0",0,"L");$pdf->Cell(30,4,"dát.narodenia ","0",0,"L");$pdf->Cell(20,4,"rodné èíslo ","0",1,"L");
  }
$pdf->Cell(50,4,"$deti->md","0",0,"L");$pdf->Cell(30,4,"$dr_sk","0",0,"L");$pdf->Cell(20,4,"$deti->rcd","0",1,"L");
}
$idt = $idt + 1;

  }


//koniec deti

//nem.davky,nepl.volno,absencia

$idn=0;
  while ($idn <= $poldn )
  {
  if (@$zaznam=mysql_data_seek($sqldn,$idn))
{
$polon=mysql_fetch_object($sqldn);

$dp_sk=SkDatum($polon->dp);
$dk_sk=SkDatum($polon->dk);

if( $polon->dm > 0 )
     {
if( $idn == 0 )
{
$pdf->SetFont('arial','',10);
$pdf->Cell(145,4," ","0",1,"L");
$pdf->Cell(160,4,"Dni prerušenia platenia do SP a ZP","1",1,"L");
$pdf->Cell(40,4,"Druh mzdy","0",0,"L");$pdf->Cell(20,4,"Dni","0",0,"R");$pdf->Cell(20,4,"Hodiny","0",0,"R");
$pdf->Cell(20,4,"Eur","0",0,"R");
$pdf->Cell(60,4,"Dátum od - do","0",1,"L");
}


$pdf->SetFont('arial','',9);
$pdf->Cell(40,4,"$polon->dm $polon->nzdm","0",0,"L");$pdf->Cell(20,4,"$polon->dni","0",0,"R");$pdf->Cell(20,4,"$polon->hod","0",0,"R");
$pdf->Cell(20,4,"$polon->kc","0",0,"R");
$pdf->Cell(60,4,"$dp_sk - $dk_sk","0",1,"L");
     }

}
$idn = $idn + 1;

  }

//nem.davky,nepl.volno,absencia

$druhastrana=1;

}
//koniec druhej strany

//koniec za kazdim zamestnancom daj deti a prerusenia
//if( $hlavicka->konx1 == 900 )
$j=0;
     }

  }
//koniec tlac mzd.list



$pdf->Output("../tmp/mzdovyLIST.$kli_uzid.pdf");


?>
<?php

$oprava = 1*$_REQUEST['oprava'];
if( $oprava == 1 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/mzdlist_oprava.php?copern=101&drupoh=1&cislo_oc=<?php echo $cislo_oc; ?>&cislo_obdobie=<?php echo $cislo_obdobie; ?>","_self");
</script>
<?php
exit;
}
?>

<script type="text/javascript">
  var okno = window.open("../tmp/mzdovyLIST.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA MZDOVEHO LISTU



?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Mzdove a Evidencne listy</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

//mzdovy list

function TlacMzdovyListALL()
                {
var h_oc = 999999;

window.open('../mzdy/mzdevid.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacMzdovyList()
                {
var h_oc = document.forms.formp1.h_oc.value;

window.open('../mzdy/mzdevid.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravMzdovyList()
                {
var h_oc = document.forms.formp1.h_oc.value;

window.open('../mzdy/mzdevid.php?cislo_oc=' + h_oc + '&cislo_obdobie=<?php echo $cislo_obdobie; ?>&copern=10&drupoh=1&page=1&oprava=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//koniec mzdovy list


function TlacPrehlad()
                {
var h_oc = document.forms.formp2.h_oc.value;

window.open('../mzdy/prehlad_dane.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPrehlad()
                {
var h_oc = document.forms.formp2.h_oc.value;

window.open('../mzdy/prehlad_dane.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuPrehlad()
                {
var h_oc = document.forms.formp2.h_oc.value;

window.open('../mzdy/prehlad_dane.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function TlacPotvrdNem()
                {
var h_oc = document.forms.formp4.h_oc.value;

window.open('../mzdy/potvrd_nemd.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPotvrdNem()
                {
var h_oc = document.forms.formp4.h_oc.value;

window.open('../mzdy/potvrd_nemd.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuPotvrdNem()
                {
var h_oc = document.forms.formp4.h_oc.value;

window.open('../mzdy/potvrd_nemd.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function TlacEvidencny()
                {
var h_oc = document.forms.formp2.h_oc.value;

window.open('../mzdy/evidencny_list.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravEvidencny()
                {
var h_oc = document.forms.formp2.h_oc.value;

window.open('../mzdy/evidencny_list.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuEvidencny()
                {
var h_oc = document.forms.formp2.h_oc.value;

window.open('../mzdy/evidencny_list.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZoznamEvidencny()
                {
var h_oc = document.forms.formp2.h_oc.value;

window.open('../mzdy/evidencny_listzoznam.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//zpoctovy list
<?php
$rokzapoct="2014";
if( $kli_vrok < 2014 ) { $rokzapoct=""; }
?>

function TlacZapoctovy()
                {
var h_oc = document.forms.formp3.h_oc.value;

window.open('../mzdy/zapoctovy_list<?php echo $rokzapoct; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacZapoctovyJed()
                {
var h_oc = document.forms.formp3.h_oc.value;

window.open('../mzdy/zapoctovy_list<?php echo $rokzapoct; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>&jedn=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravZapoctovy()
                {
var h_oc = document.forms.formp3.h_oc.value;

window.open('../mzdy/zapoctovy_list<?php echo $rokzapoct; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuZapoctovy()
                {
var h_oc = document.forms.formp3.h_oc.value;

window.open('../mzdy/zapoctovy_list<?php echo $rokzapoct; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php
$roknezd="";
if( $kli_vrok >= 2013 ) { $roknezd="2013"; }
if( $kli_vrok >= 2014 ) { $roknezd="2014"; }
?>

function TlacPotvrdNezam()
                {
var h_oc = document.forms.formp6.h_oc.value;

window.open('../mzdy/potvrd_nezd<?php echo $roknezd; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPotvrdNezam()
                {
var h_oc = document.forms.formp6.h_oc.value;

window.open('../mzdy/potvrd_nezd<?php echo $roknezd; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuPotvrdNezam()
                {
var h_oc = document.forms.formp6.h_oc.value;

window.open('../mzdy/potvrd_nezd<?php echo $roknezd; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UdajeML()
                {
var h_oc = 0;

window.open('../mzdy/tlac_mzdlist.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TriedenieOsc()
                {

window.open('../mzdy/mzdevid.php?&copern=1&drupoh=1&page=1&subor=0&podlaosc=1',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacPaskaOsc()
                {
var h_oc = document.forms.formp1.h_oc.value;

window.open('../mzdy/vyplat_paska.php?&copern=511&page=1&cislo_oc=' + h_oc + '&ostre=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function MailPaskaOscXX()
                {
var h_oc = document.forms.formp1.h_oc.value;

window.open('../mzdy/mail_paska.php?&copern=1&page=1&cislo_oc=' + h_oc + '&posem=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function MailPaskaOsc()
                {
var h_oc = document.forms.formp1.h_oc.value;

window.open('../mzdy/vyplat_paska.php?&copern=511&page=1&cislo_oc=' + h_oc + '&ostre=0&odmailuj=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

    function textMzdlist()
    {

var h_osc = document.forms.formp1.h_oc.value;

window.open('../mzdy/mzdlist_text.php?h_cvz=' + h_osc + '&copern=1&drupoh=<?php echo $drupoh;?>&page=1', '_blank',  'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );


    }


//oznamenie a cestne vyhlasenie
function TlacOznamenia()
                {
var h_oc = document.forms.formsoc2.h_oc.value;

window.open('../mzdy/oznamenie_student.php?cislo_oc=' + h_oc + '&strana=9999&copern=10&drupoh=1&subor=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravaOznamenia()
                {
var h_oc = document.forms.formsoc2.h_oc.value;

window.open('../mzdy/oznamenie_student.php?cislo_oc=' + h_oc + '&strana=1&copern=20&drupoh=1&subor=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


  
</script>
</HEAD>
<BODY class="white" id="white" onload="" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Mzdové, evidenèné listy, mzdové potvrdenia zamestnancov

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//zakladna ponuka
if( $copern == 1 )
{

$podlaosc = 1*$_REQUEST['podlaosc'];
$triedenie="prie,meno";
if( $podlaosc == 1 ) { $triedenie="oc"; }
?>

<table class="vstup" width="100%" >
<FORM name="formp1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacMzdovyList();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi mzdový list vo formáte PDF' ></a>
</td>

<td class="bmenu" width="58%">
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY $triedenie ");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osè <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>
<a href="#" onClick="TlacMzdovyList();">Mzdový list zamestnanca</a>
</td>

<td class="bmenu" width="20%">
<img src='../obr/orig.png' onClick="textMzdlist();" width=20 height=15 border=0 title='Poznámky na mzdový list' >

<td class="bmenu" width="20%">
<img src='../obr/ok.png' onClick="TriedenieOsc();" width=20 height=15 border=0 title='Triedenie výberu zamestnancov pod¾a osè' >

<img src='../obr/banky/euro.jpg' onClick="TlacPaskaOsc();" width=20 height=15 border=0 title='Vytlaèi výplatnú pásku pre vybrané osè a <?php echo $kli_vume;?> vo formáte PDF' >

<img src='../obr/obalka.jpg' onClick="MailPaskaOsc();" width=20 height=15 border=0 title='Odmailova výplatnú pásku pre vybrané osè a <?php echo $kli_vume;?>' >

</td>

<td class="bmenu" width="2%">
<a href="#" onClick="TlacMzdovyListALL();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi všetky mzdové listy vo formáte PDF' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="UpravMzdovyList();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upravi hodnoty v mzdovom liste' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formp4" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPotvrdNem();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi vo formáte PDF' ></a>
</td>

<td class="bmenu" width="98%">
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osè <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>
<a href="#" onClick="TlacPotvrdNem();">Potvrdenie zamestnávate¾a o zamestnancovi na úèely uplatnenia nároku na nemocenskú dávku</a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravPotvrdNem();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upravi hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuPotvrdNem();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='Naèíta hodnoty - môžete opakova viackrát' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formp2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacEvidencny();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi vo formáte PDF' ></a>
</td>

<td class="bmenu" width="98%">
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osè <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>
<a href="#" onClick="TlacEvidencny();">Evidenèný list zamestnanca</a>

<a href="#" onClick="ZoznamEvidencny();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi zoznam všetkých evidenèných listov vo formáte PDF' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravEvidencny();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upravi hodnoty v evidenènom liste' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuEvidencny();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='Naèíta hodnoty do evidenèného listu - môžete opakova viackrát' ></a>
</td>
</tr>
</FORM>
</table>





<table class="vstup" width="100%" >
<FORM name="formp3" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacZapoctovyJed();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi vo formáte PDF tvar 2012' ></a>
</td>

<td class="bmenu" width="98%">
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osè <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>
<a href="#" onClick="TlacZapoctovyJed();">Zápoèet odpracovaných rokov zamestnanca</a>

<?php if( $kli_vrok < 2012 ) { ?>
<a href="#" onClick="TlacZapoctovy();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi vo formáte PDF tvar 2011' ></a>
<?php                        } ?>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravZapoctovy();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upravi hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuZapoctovy();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='Naèíta hodnoty - môžete opakova viackrát' ></a>
</td>
</tr>
</FORM>
</table>


                         


<table class="vstup" width="100%" >
<FORM name="formp6" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPotvrdNezam();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi vo formáte PDF' ></a>
</td>

<td class="bmenu" width="98%">
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osè <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>
<a href="#" onClick="TlacPotvrdNezam();">Potvrdenie zamestnávate¾a na úèely nároku na dávku v nezamestnanosti</a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravPotvrdNezam();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upravi hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuPotvrdNezam();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='Naèíta hodnoty - môžete opakova viackrát' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formsoc2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacOznamenia();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi vo formáte PDF' ></a>
</td>

<td class="bmenu" width="96%">
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osè <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>
<a href="#" onClick="TlacOznamenia();">Oznámenie a èestné vyhlásenie k dohode o brigádnickej práci študentov </a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravaOznamenia();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upravi hodnoty ' ></a>
</td>

</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formmz6" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="UdajeML();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori výberovú podmienku a tlaè zostavy z mzdového listu' ></a>
</td>

<td class="bmenu" width="98%">
<a href="#" onClick="UdajeML();">Tlaè výberových údajov z mzdového listu</a>
</td>
<td class="bmenu" width="2%"></td>

<td class="bmenu" width="2%"></td>
</tr>
</FORM>
</table>

<?php
}
//koniec zakladnej ponuky
?>



<?php
// celkovy koniec dokumentu
$cislista = include("mzd_lista.php");
       } while (false);
?>
</BODY>
</HTML>
