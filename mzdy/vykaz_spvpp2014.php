<HTML>
<?php
do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if (!isset($tis)) $tis = 0;
$meno = 1*$_REQUEST['meno'];

$h_oprav = 1*$_REQUEST['h_oprav'];

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

if ( $copern == 1 )
     {
$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume ORDER BY ume";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if ( $umesp == 0 )
{
?>
<script type="text/javascript">
alert ("Mzdy za obdobie <?php echo $kli_vume; ?> neboli spracovan� naostro , \r urobte najprv ostr� spracovanie !");
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

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

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

//pre mesacny vykaz vytvor pracovny subor
if ( $copern == 10 OR $copern == 20 OR $copern == 30 OR $copern == 155 OR $copern == 156 )
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
   umeo         DECIMAL(7,4) DEFAULT 0,
   zdrv         INT(7) DEFAULT 0,
   znizp        INT(1) DEFAULT 0,
   pocdni       decimal(10,0) DEFAULT 0,
   strajk       decimal(10,0) DEFAULT 0,
   skonci       decimal(10,0) DEFAULT 0,
   neplat       decimal(10,0) DEFAULT 0,
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
   pzam_zp      DECIMAL(10,0) DEFAULT 0,
   pzam_np      DECIMAL(10,0) DEFAULT 0,
   pzam_sp      DECIMAL(10,0) DEFAULT 0,
   pzam_ip      DECIMAL(10,0) DEFAULT 0,
   pzam_pn      DECIMAL(10,0) DEFAULT 0,
   pzam_up      DECIMAL(10,0) DEFAULT 0,
   pzam_gf      DECIMAL(10,0) DEFAULT 0,
   pzam_rf      DECIMAL(10,0) DEFAULT 0,
   ozam_spolu   DECIMAL(10,2) DEFAULT 0,
   ofir_spolu   DECIMAL(10,2) DEFAULT 0,
   celk_spolu   DECIMAL(10,2) DEFAULT 0,
   vcelk_dni    DECIMAL(10,0) DEFAULT 0,
   vnesp_dni    DECIMAL(10,0) DEFAULT 0,
   vpois_dni    DECIMAL(10,0) DEFAULT 0,
   vden_prvy    DATE,
   vden_posl    DATE,
   konx         DECIMAL(10,0) DEFAULT 0,
   vrdk         VARCHAR(4) NOT NULL,
   vrdc         VARCHAR(6) NOT NULL,
   porc         int not null,
   vdni         int not null,
   konx1        DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid.$sqlt;
//$vytvor = mysql_query("$vsql");

//datumy pociatok a koniec mesiaca
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

$pole = explode(".", $kli_vume);
$kli_mdph=$pole[0];
$kli_rdph=$pole[1];

$datp_dph=$kli_rdph.'-'.$kli_mdph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datp_dph', 0 )";
$ttqq = mysql_query("$ttvv");

$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$datp_dph',  datk=LAST_DAY('$datp_dph')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//echo $datp_dph."  ".$datk_dph;

//exit;
//koniec datumy pociatok a koniec mesiaca


//zober data z mzdneprav 
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT ocx,umeo,0,0,pocdni,strajk,skonci,neplat,".
"0,zzam_np,zzam_sp,zzam_ip,zzam_pn,zzam_up,zzam_gf,zzam_rf,".
"0,zfir_np,zfir_sp,zfir_ip,zfir_pn,zfir_up,zfir_gf,zfir_rf,".
"0,ozam_np,ozam_sp,ozam_ip,ozam_pn,ozam_up,ozam_gf,ozam_rf,".
"0,ofir_np,ofir_sp,ofir_ip,ofir_pn,ofir_up,ofir_gf,ofir_rf,".
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,'','',".
"1,".
"'','',0,0,".
"0".
" FROM F$kli_vxcf"."_mzdneprav ".
" WHERE umex = $kli_vume ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,umeo,0,0,pocdni,strajk,skonci,neplat,".
"sum(zzam_zp),sum(zzam_np),sum(zzam_sp),sum(zzam_ip),sum(zzam_pn),sum(zzam_up),sum(zzam_gf),sum(zzam_rf),".
"sum(zfir_zp),sum(zfir_np),sum(zfir_sp),sum(zfir_ip),sum(zfir_pn),sum(zfir_up),sum(zfir_gf),sum(zfir_rf),".
"sum(ozam_zp),sum(ozam_np),sum(ozam_sp),sum(ozam_ip),sum(ozam_pn),sum(ozam_up),sum(ozam_gf),sum(ozam_rf),".
"sum(ofir_zp),sum(ofir_np),sum(ofir_sp),sum(ofir_ip),sum(ofir_pn),sum(ofir_up),sum(ofir_gf),sum(ofir_rf),".
"sum(pzam_zp),sum(pzam_np),sum(pzam_sp),sum(pzam_ip),sum(pzam_pn),sum(pzam_up),sum(pzam_gf),sum(pzam_rf),".
"sum(ozam_spolu),sum(ofir_spolu),sum(celk_spolu),0,sum(vnesp_dni),0,'','',".
"0,".
"'','',0,0,".
"0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY oc,umeo";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 1";
$oznac = mysql_query("$sqtoz");

//dopln udaje kun do vypl, do znizp daj spnie a potom ak = 1 vymaz
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET vrdc=rdc, vrdk=rdk, porc=pom, znizp=spnie".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE znizp = 1";
$oznac = mysql_query("$sqtoz");

//daj prec pravidelny prijem ak je v ciselniku pomerov pm4=1
if ( $fir_mzdx03 == 1 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdpomer".
" SET znizp=pm4 ".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.porc = F$kli_vxcf"."_mzdpomer.pm";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE znizp = 0 ";
$oznac = mysql_query("$sqtoz");
     }

//dopln udaje pomer do vypl
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdpomer".
" SET konx1=pm_doh".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.porc = F$kli_vxcf"."_mzdpomer.pm";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//vypocitaj pocet zamestnancov pre jednotlive fondy
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET pzam_np=1 WHERE oc > 0 AND ( zzam_np > 0 OR zfir_np > 0 )"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET pzam_sp=1 WHERE oc > 0 AND ( zzam_sp > 0 OR zfir_sp > 0 )"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET pzam_ip=1 WHERE oc > 0 AND ( zzam_ip > 0 OR zfir_ip > 0 )"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET pzam_pn=1 WHERE oc > 0 AND ( zzam_pn > 0 OR zfir_pn > 0 )"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET pzam_up=1 WHERE oc > 0 AND ( zzam_up > 0 OR zfir_up > 0 )"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET pzam_gf=1 WHERE oc > 0 AND ( zzam_gf > 0 OR zfir_gf > 0 )"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET pzam_rf=1 WHERE oc > 0 AND ( zzam_rf > 0 OR zfir_rf > 0 )"; $oznac = mysql_query("$sqtoz");

//vypocitaj sucty
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET ozam_spolu=ozam_np+ozam_sp+ozam_ip+ozam_pn+ozam_up+ozam_gf+ozam_rf,".
"ofir_spolu=ofir_np+ofir_sp+ofir_ip+ofir_pn+ofir_up+ofir_gf+ofir_rf, celk_spolu=ozam_spolu+ofir_spolu".
" WHERE oc > 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" SELECT oc,0,0,0,0,0,0,0,".
"sum(zzam_zp),sum(zzam_np),sum(zzam_sp),sum(zzam_ip),sum(zzam_pn),sum(zzam_up),sum(zzam_gf),sum(zzam_rf),".
"sum(zfir_zp),sum(zfir_np),sum(zfir_sp),sum(zfir_ip),sum(zfir_pn),sum(zfir_up),sum(zfir_gf),sum(zfir_rf),".
"sum(ozam_zp),sum(ozam_np),sum(ozam_sp),sum(ozam_ip),sum(ozam_pn),sum(ozam_up),sum(ozam_gf),sum(ozam_rf),".
"sum(ofir_zp),sum(ofir_np),sum(ofir_sp),sum(ofir_ip),sum(ofir_pn),sum(ofir_up),sum(ofir_gf),sum(ofir_rf),".
"sum(pzam_zp),sum(pzam_np),sum(pzam_sp),sum(pzam_ip),sum(pzam_pn),sum(pzam_up),sum(pzam_gf),sum(pzam_rf),".
"sum(ozam_spolu),sum(ofir_spolu),sum(celk_spolu),0,0,0,'','',".
"9,".
"'','',0,0,".
"0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY konx";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,0,0,0,0,".
"zzam_zp,zzam_np,zzam_sp,zzam_ip,zzam_pn,zzam_up,zzam_gf,zzam_rf,".
"zfir_zp,zfir_np,zfir_sp,zfir_ip,zfir_pn,zfir_up,zfir_gf,zfir_rf,".
"ozam_zp,ozam_np,ozam_sp,ozam_ip,ozam_pn,ozam_up,ozam_gf,ozam_rf,".
"ofir_zp,ofir_np,ofir_sp,ofir_ip,ofir_pn,ofir_up,ofir_gf,ofir_rf,".
"pzam_zp,pzam_np,pzam_sp,pzam_ip,pzam_pn,pzam_up,pzam_gf,pzam_rf,".
"ozam_spolu,ofir_spolu,celk_spolu,0,0,0,'','',".
"9,".
"'','',0,0,".
"0".
" FROM F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" WHERE oc >= 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$prvyden=$kli_vrok."-".$kli_vmes."-01";

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET ".
" vden_prvy='$prvyden', vden_posl=LAST_DAY('$prvyden')".
" WHERE oc >= 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET ".
" vcelk_dni=TO_DAYS(vden_posl)-TO_DAYS(vden_prvy)+1, vpois_dni=vcelk_dni-vnesp_dni".
" WHERE oc >= 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

}
//koniec pracovneho suboru 

//exit;

/////////////NACITANIE UDAJOV Z PARAMETROV
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=1*$riaddok->cicz;
  }

/////////////NACITANIE poctu stran
if ( $copern != 1 )
{
$pocetstran=1;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc >= 0 AND konx = 0 ORDER BY konx,vrdc";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
$polk = mysql_num_rows($sqldok);
$ik=0;
$jk=1;

  while ($ik <= $polk )
  {
  if (@$zaznam=mysql_data_seek($sqldok,$ik))
{
$hlavickadok=mysql_fetch_object($sqldok);
$ocdok=1*$hlavickadok->oc;

if ( $jk == 6 AND $ocdok > 0 ) {  $pocetstran=$pocetstran+1; $jk=0; }

}
$ik = $ik + 1;
  }
}
/////////////NACITANIE poctu stran


/////////////////////////////////////////////////VYTLAC VYKAZ
if ( $copern == 10 OR $copern == 155 )
{
//$zablokovane=1;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("PDF v�kaz bude pripraven� v priebehu febru�ra 2014. Aktu�lne info n�jdete na vstupnej str�nke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

if ( File_Exists("../tmp/vykazSP.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/vykazSP.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
//$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

if ( $copern == 155 )
{
//volaj precitanie xml a zapis do mzdprcvypl s konx=9
$citajXML = include("citajxmlpril.php");
}

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc >= 0 AND konx = 9 ORDER BY konx,prie,meno";

//exit;

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
  $D2ozam_np = substr($pole[1],1,1);

  $ozam_sp = $hlavicka->ozam_sp;
  $pole = explode(".", $ozam_sp);
  $Cozam_sp = $pole[0];
  $Dozam_sp = substr($pole[1],0,1);
  $D2ozam_sp = substr($pole[1],1,1);

  $ozam_ip = $hlavicka->ozam_ip;
  $pole = explode(".", $ozam_ip);
  $Cozam_ip = $pole[0];
  $Dozam_ip = substr($pole[1],0,1);
  $D2ozam_ip = substr($pole[1],1,1);

  $ozam_pn = $hlavicka->ozam_pn;
  $pole = explode(".", $ozam_pn);
  $Cozam_pn = $pole[0];
  $Dozam_pn = substr($pole[1],0,1);
  $D2ozam_pn = substr($pole[1],1,1);

  $ozam_up = $hlavicka->ozam_up;
  $pole = explode(".", $ozam_up);
  $Cozam_up = $pole[0];
  $Dozam_up = substr($pole[1],0,1);
  $D2ozam_up = substr($pole[1],1,1);

  $ozam_gf = $hlavicka->ozam_gf;
  $pole = explode(".", $ozam_gf);
  $Cozam_gf = $pole[0];
  $Dozam_gf = substr($pole[1],0,1);
  $D2ozam_gf = substr($pole[1],1,1);

  $ozam_rf = $hlavicka->ozam_rf;
  $pole = explode(".", $ozam_rf);
  $Cozam_rf = $pole[0];
  $Dozam_rf = substr($pole[1],0,1);
  $D2ozam_rf = substr($pole[1],1,1);

  $ofir_np = $hlavicka->ofir_np;
  $pole = explode(".", $ofir_np);
  $Cofir_np = $pole[0];
  $Dofir_np = substr($pole[1],0,1);
  $D2ofir_np = substr($pole[1],1,1);

  $ofir_sp = $hlavicka->ofir_sp;
  $pole = explode(".", $ofir_sp);
  $Cofir_sp = $pole[0];
  $Dofir_sp = substr($pole[1],0,1);
  $D2ofir_sp = substr($pole[1],1,1);

  $ofir_ip = $hlavicka->ofir_ip;
  $pole = explode(".", $ofir_ip);
  $Cofir_ip = $pole[0];
  $Dofir_ip = substr($pole[1],0,1);
  $D2ofir_ip = substr($pole[1],1,1);

  $ofir_pn = $hlavicka->ofir_pn;
  $pole = explode(".", $ofir_pn);
  $Cofir_pn = $pole[0];
  $Dofir_pn = substr($pole[1],0,1);
  $D2ofir_pn = substr($pole[1],1,1);

  $ofir_up = $hlavicka->ofir_up;
  $pole = explode(".", $ofir_up);
  $Cofir_up = $pole[0];
  $Dofir_up = substr($pole[1],0,1);
  $D2ofir_up = substr($pole[1],1,1);

  $ofir_gf = $hlavicka->ofir_gf;
  $pole = explode(".", $ofir_gf);
  $Cofir_gf = $pole[0];
  $Dofir_gf = substr($pole[1],0,1);
  $D2ofir_gf = substr($pole[1],1,1);

  $ofir_rf = $hlavicka->ofir_rf;
  $pole = explode(".", $ofir_rf);
  $Cofir_rf = $pole[0];
  $Dofir_rf = substr($pole[1],0,1);
  $D2ofir_rf = substr($pole[1],1,1);

  $celk_spolu = $hlavicka->celk_spolu;
  $pole = explode(".", $celk_spolu);
  $Ccelk_spolu = $pole[0];
  $Dcelk_spolu = substr($pole[1],0,1);
  $D2celk_spolu = substr($pole[1],1,1);

$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(5);
$pdf->SetTopMargin(20);
if ( File_Exists('../dokumenty/socpoist2014/vykaz.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/socpoist2014/vykaz.jpg',0,0,210,298);
}

//icz
$pdf->Cell(195,8,"     ","$rmc1",1,"L");
$pdf->Cell(2,5," ","$rmc1",0,"L");$pdf->Cell(37,5,"$cicz","$rmc",0,"C");

//cislo vykazu v tvare MM99YYYY
$obdobie=$kli_vume*10000;
if ( $obdobie < 102009 ) $obdobie= "0".$obdobie;
if ( $import == 1 ) $obdobie=$obdobix;
$cislo1=$kli_vmes;
if ( $cislo1 < 10 ) $cislo1= "0".$kli_vmes;
$cislo2=$kli_vrok;
$A=substr($cislo1,0,1);
$B=substr($cislo1,1,1);
$C=substr($cislo2,0,1);
$D=substr($cislo2,1,1);
$E=substr($cislo2,2,1);
$F=substr($cislo2,3,1);
$pdf->Cell(19,5," ","$rmc1",0,"L");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(11,6," ","$rmc1",0,"L");
$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(5,6,"$F","$rmc",0,"C");

//zuctovane v mesiaci
$pdf->Cell(2,6," ","$rmc1",0,"L");$pdf->Cell(41,6,"$obdobie","$rmc",0,"C");

//typ vykazu
$riadne="x";
$opravne="x";
if ( $h_oprav == 0 ) { $opravne="";  }
if ( $h_oprav == 1 ) { $riadne="";  }
$pdf->Cell(31,4,"   ","$rmc1",0,"C");$pdf->Cell(4,4,"$riadne","$rmc",0,"C");$pdf->Cell(11,4," ","$rmc1",0,"C");$pdf->Cell(3,4,"$opravne","$rmc",1,"C");

//ZAMESTNAVATEL
$pdf->Cell(198,12,"     ","$rmc1",1,"L");
$pdf->Cell(3,6," ","$rmc1",0,"L");$pdf->Cell(114,7,"$fir_fnaz","$rmc",0,"L");$pdf->Cell(12,2," ","$rmc1",0,"L");$pdf->Cell(4,6,"x","$rmc",0,"C");
$pdf->Cell(27,6," ","$rmc1",0,"L");$pdf->Cell(37,6,"$fir_fico","$rmc",1,"C");
$pdf->Cell(198,4,"     ","$rmc1",1,"L");
$pdf->Cell(3,6," ","$rmc1",0,"L");$pdf->Cell(194,6," ","$rmc",1,"L");
$pdf->Cell(198,4," ","$rmc1",1,"L");
$pdf->Cell(3,6," ","$rmc1",0,"L");$pdf->Cell(71,6,"$fir_ftel","$rmc",0,"L");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(71,6,"$fir_fem1","$rmc",1,"L");
$pdf->SetFont('arial','',12);
$pdf->Cell(195,12,"     ","$rmc1",1,"L");
$pdf->Cell(3,5," ","$rmc1",0,"L");$pdf->Cell(71,6,"$fir_fib1","$rmc",1,"L");

//3. suhrn poistneho a prispevkov
$pdf->Cell(198,12,"     ","$rmc1",1,"L");
$pdf->Cell(94,6," ","$rmc1",0,"L");$pdf->Cell(31,6,"$Cozam_np","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"L");$pdf->Cell(4,6,"$Dozam_np","$rmc",0,"L");
$pdf->Cell(4,6,"$D2ozam_np","$rmc",0,"L");$pdf->Cell(13,6,"","$rmc1",0,"L");
$pdf->Cell(30,6,"$Cofir_np","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(7,6,"$Dofir_np $D2ofir_np","$rmc",1,"C");

$pdf->Cell(198,2,"     ","$rmc1",1,"L");
$pdf->Cell(94,6," ","$rmc1",0,"L");$pdf->Cell(31,6,"$Cozam_sp","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"L");$pdf->Cell(4,6,"$Dozam_sp","$rmc",0,"L");
$pdf->Cell(4,6,"$D2ozam_sp","$rmc",0,"L");$pdf->Cell(13,6,"","$rmc1",0,"L");
$pdf->Cell(30,6,"$Cofir_sp","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(7,6,"$Dofir_sp $D2ofir_sp","$rmc",1,"C");

$pdf->Cell(198,3,"     ","$rmc1",1,"L");
$pdf->Cell(94,6," ","$rmc1",0,"L");$pdf->Cell(31,6,"$Cozam_ip","$rmc",0,"R");$pdf->Cell(1,6,"","$rmc1",0,"L");$pdf->Cell(4,6,"$Dozam_ip","$rmc",0,"L");
$pdf->Cell(4,6,"$D2ozam_ip","$rmc",0,"L");$pdf->Cell(13,6,"","$rmc1",0,"L");
$pdf->Cell(30,6,"$Cofir_ip","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(7,6,"$Dofir_ip $D2ofir_ip","$rmc",1,"C");

$pdf->Cell(198,2,"     ","$rmc1",1,"L");
$pdf->Cell(94,6," ","$rmc1",0,"L");$pdf->Cell(31,6,"$Cozam_pn","$rmc",0,"R");$pdf->Cell(1,6,"","$rmc1",0,"L");$pdf->Cell(4,6,"$Dozam_pn","$rmc",0,"L");
$pdf->Cell(4,6,"$D2ozam_pn","$rmc",0,"L");$pdf->Cell(13,6,"","$rmc1",0,"L");
$pdf->Cell(30,6,"$Cofir_pn","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc",0,"L");$pdf->Cell(7,6,"$Dofir_pn $D2ofir_pn","$rmc",1,"C");

$pdf->Cell(198,3,"     ","$rmc1",1,"L");
$pdf->Cell(147,6," ","$rmc1",0,"L");$pdf->Cell(30,6,"$Cofir_up","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(7,6,"$Dofir_up $D2ofir_up","$rmc",1,"C");

$pdf->Cell(198,2,"     ","$rmc1",1,"L");
$pdf->Cell(147,6," ","$rmc1",0,"L");$pdf->Cell(30,6,"$Cofir_gf","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(7,6,"$Dofir_gf $D2ofir_gf","$rmc",1,"C");

$pdf->Cell(198,2,"     ","$rmc1",1,"L");
$pdf->Cell(147,6," ","$rmc1",0,"L");$pdf->Cell(30,6,"$Cofir_rf","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(7,6,"$Dofir_rf $D2ofir_rf","$rmc",1,"C");

$pdf->Cell(198,7,"     ","$rmc1",1,"L");
$pdf->Cell(147,6," ","$rmc1",0,"L");$pdf->Cell(30,6,"$Ccelk_spolu","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(7,6,"$Dcelk_spolu $D2celk_spolu","$rmc",1,"C");

//4. FO povinna voci SP
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$priefosoba = trim($fir_riadok->fospprie);
$menofosoba = trim($fir_riadok->fospmeno);
$telfosoba = trim($fir_riadok->fosptel);
$mailfosoba = trim($fir_riadok->fospmail);
if ( $priefosoba == '' ) { $priefosoba="mzdov�"; }
if ( $menofosoba == '' ) { $menofosoba="��t�re�"; }
if ( $telfosoba == '' ) { $telfosoba=$fir_ftel; }
if ( $mailfosoba == '' ) { $mailfosoba=$fir_fem1; }
$pdf->Cell(190,16,"     ","$rmc1",1,"L");
$pdf->Cell(3,5," ","$rmc1",0,"L");$pdf->Cell(64,7,"$menofosoba","$rmc",0,"L");$pdf->Cell(2,5," ","$rmc1",0,"L");$pdf->Cell(78,7,"$priefosoba","$rmc",1,"L");
$pdf->Cell(190,3,"     ","$rmc1",1,"L");
$pdf->Cell(3,5," ","$rmc1",0,"L");$pdf->Cell(71,7,"$telfosoba","$rmc",0,"L");$pdf->Cell(3,5," ","$rmc1",0,"L");$pdf->Cell(71,6,"$mailfosoba","$rmc",1,"L");

//5. vyplnil
$pdf->SetFont('arial','',10);
$pdf->Cell(190,14,"     ","$rmc1",1,"L");
if ( $fir_mzdt05 == '' ) $fir_mzdt05=$kli_uzmeno." ".$kli_uzprie;
$pdf->Cell(3,6," ","$rmc1",0,"L");$pdf->Cell(58,6,"$fir_mzdt05","$rmc",1,"L");
$pdf->SetFont('arial','',12);

//pocet stran prilohy a datum vyplnenia
$datumvypln = $_REQUEST['davyp'];
$pdf->Cell(190,3,"     ","$rmc1",1,"L");
$pdf->Cell(11,6," ","$rmc1",0,"L");$pdf->Cell(15,6,"$pocetstran","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"L");$pdf->Cell(31,6,"$datumvypln","$rmc",1,"C");
}
$i = $i + 1;
  }

$pdf->Output("../tmp/vykazSP.$kli_uzid.pdf");

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
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/vykazSP.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA VYKAZU


/////////////////////////////////////////VYTLAC PRILOHU VYKAZU 
if ( $copern == 20 OR $copern == 156 )
{
//$zablokovane=1;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("PDF v�kaz bude pripraven� v priebehu febru�ra 2014. Aktu�lne info n�jdete na vstupnej str�nke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

if ( File_Exists("../tmp/prilohaSP.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/prilohaSP.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
//$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

if ( $copern == 156 )
{
//volaj precitanie xml a zapis do mzdprcvypl s konx=0
$citajXML = include("citajxmlpril.php");
}

//vytlac

$sqltt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE ".
" zfir_np = 0 AND zfir_sp = 0 AND  zfir_ip = 0 AND  zfir_pn = 0 AND  zfir_up = 0 AND  zfir_gf = 0 AND  zfir_rf = 0 ";
$sql = mysql_query("$sqltt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc >= 0 AND konx = 0 ORDER BY konx,vrdc,umeo";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$strana=0;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);
//odvody
  $ozam_np = $hlavicka->ozam_np;
  $pole = explode(".", $ozam_np);
  $Cozam_np = $pole[0];
  $Dozam_np = substr($pole[1],0,1);
  $D2ozam_np = substr($pole[1],1,1);

  $ozam_sp = $hlavicka->ozam_sp;
  $pole = explode(".", $ozam_sp);
  $Cozam_sp = $pole[0];
  $Dozam_sp = substr($pole[1],0,1);
  $D2ozam_sp = substr($pole[1],1,1);

  $ozam_ip = $hlavicka->ozam_ip;
  $pole = explode(".", $ozam_ip);
  $Cozam_ip = $pole[0];
  $Dozam_ip = substr($pole[1],0,1);
  $D2ozam_ip = substr($pole[1],1,1);

  $ozam_pn = $hlavicka->ozam_pn;
  $pole = explode(".", $ozam_pn);
  $Cozam_pn = $pole[0];
  $Dozam_pn = substr($pole[1],0,1);
  $D2ozam_pn = substr($pole[1],1,1);

  $ozam_up = $hlavicka->ozam_up;
  $pole = explode(".", $ozam_up);
  $Cozam_up = $pole[0];
  $Dozam_up = substr($pole[1],0,1);
  $D2ozam_up = substr($pole[1],1,1);

  $ozam_gf = $hlavicka->ozam_gf;
  $pole = explode(".", $ozam_gf);
  $Cozam_gf = $pole[0];
  $Dozam_gf = substr($pole[1],0,1);
  $D2ozam_gf = substr($pole[1],1,1);

  $ozam_rf = $hlavicka->ozam_rf;
  $pole = explode(".", $ozam_rf);
  $Cozam_rf = $pole[0];
  $Dozam_rf = substr($pole[1],0,1);
  $D2ozam_rf = substr($pole[1],1,1);

  $ofir_np = $hlavicka->ofir_np;
  $pole = explode(".", $ofir_np);
  $Cofir_np = $pole[0];
  $Dofir_np = substr($pole[1],0,1);
  $D2ofir_np = substr($pole[1],1,1);

  $ofir_sp = $hlavicka->ofir_sp;
  $pole = explode(".", $ofir_sp);
  $Cofir_sp = $pole[0];
  $Dofir_sp = substr($pole[1],0,1);
  $D2ofir_sp = substr($pole[1],1,1);

  $ofir_ip = $hlavicka->ofir_ip;
  $pole = explode(".", $ofir_ip);
  $Cofir_ip = $pole[0];
  $Dofir_ip = substr($pole[1],0,1);
  $D2ofir_ip = substr($pole[1],1,1);

  $ofir_pn = $hlavicka->ofir_pn;
  $pole = explode(".", $ofir_pn);
  $Cofir_pn = $pole[0];
  $Dofir_pn = substr($pole[1],0,1);
  $D2ofir_pn = substr($pole[1],1,1);

  $ofir_up = $hlavicka->ofir_up;
  $pole = explode(".", $ofir_up);
  $Cofir_up = $pole[0];
  $Dofir_up = substr($pole[1],0,1);
  $D2ofir_up = substr($pole[1],1,1);

  $ofir_gf = $hlavicka->ofir_gf;
  $pole = explode(".", $ofir_gf);
  $Cofir_gf = $pole[0];
  $Dofir_gf = substr($pole[1],0,1);
  $D2ofir_gf = substr($pole[1],1,1);

  $ofir_rf = $hlavicka->ofir_rf;
  $pole = explode(".", $ofir_rf);
  $Cofir_rf = $pole[0];
  $Dofir_rf = substr($pole[1],0,1);
  $D2ofir_rf = substr($pole[1],1,1);

  $celk_spolu = $hlavicka->celk_spolu;
  $pole = explode(".", $celk_spolu);
  $Ccelk_spolu = $pole[0];
  $Dcelk_spolu = substr($pole[1],0,1);
  $D2celk_spolu = substr($pole[1],1,1);

//zaklady
  $zzam_np = $hlavicka->zzam_np;
  $pole = explode(".", $zzam_np);
  $Czzam_np = $pole[0];
  $D1zzam_np = substr($pole[1],0,1);
  $D2zzam_np = substr($pole[1],1,1);

  $zzam_sp = $hlavicka->zzam_sp;
  $pole = explode(".", $zzam_sp);
  $Czzam_sp = $pole[0];
  $D1zzam_sp = substr($pole[1],0,1);
  $D2zzam_sp = substr($pole[1],1,1);

  $zzam_ip = $hlavicka->zzam_ip;
  $pole = explode(".", $zzam_ip);
  $Czzam_ip = $pole[0];
  $D1zzam_ip = substr($pole[1],0,1);
  $D2zzam_ip = substr($pole[1],1,1);

  $zzam_pn = $hlavicka->zzam_pn;
  $pole = explode(".", $zzam_pn);
  $Czzam_pn = $pole[0];
  $D1zzam_pn = substr($pole[1],0,1);
  $D2zzam_pn = substr($pole[1],1,1);

  $zzam_up = $hlavicka->zzam_up;
  $pole = explode(".", $zzam_up);
  $Czzam_up = $pole[0];
  $D1zzam_up = substr($pole[1],0,1);
  $D2zzam_up = substr($pole[1],1,1);

  $zzam_gf = $hlavicka->zzam_gf;
  $pole = explode(".", $zzam_gf);
  $Czzam_gf = $pole[0];
  $D1zzam_gf = substr($pole[1],0,1);
  $D2zzam_gf = substr($pole[1],1,1);

  $zzam_rf = $hlavicka->zzam_rf;
  $pole = explode(".", $zzam_rf);
  $Czzam_rf = $pole[0];
  $D1zzam_rf = substr($pole[1],0,1);
  $D2zzam_rf = substr($pole[1],1,1);

  $zfir_np = $hlavicka->zfir_np;
  $pole = explode(".", $zfir_np);
  $Czfir_np = $pole[0];
  $D1zfir_np = substr($pole[1],0,1);
  $D2zfir_np = substr($pole[1],1,1);

  $zfir_sp = $hlavicka->zfir_sp;
  $pole = explode(".", $zfir_sp);
  $Czfir_sp = $pole[0];
  $D1zfir_sp = substr($pole[1],0,1);
  $D2zfir_sp = substr($pole[1],1,1);

  $zfir_ip = $hlavicka->zfir_ip;
  $pole = explode(".", $zfir_ip);
  $Czfir_ip = $pole[0];
  $D1zfir_ip = substr($pole[1],0,1);
  $D2zfir_ip = substr($pole[1],1,1);

  $zfir_pn = $hlavicka->zfir_pn;
  $pole = explode(".", $zfir_pn);
  $Czfir_pn = $pole[0];
  $D1zfir_pn = substr($pole[1],0,1);
  $D2zfir_pn = substr($pole[1],1,1);

  $zfir_up = $hlavicka->zfir_up;
  $pole = explode(".", $zfir_up);
  $Czfir_up = $pole[0];
  $D1zfir_up = substr($pole[1],0,1);
  $D2zfir_up = substr($pole[1],1,1);

  $zfir_gf = $hlavicka->zfir_gf;
  $pole = explode(".", $zfir_gf);
  $Czfir_gf = $pole[0];
  $D1zfir_gf = substr($pole[1],0,1);
  $D2zfir_gf = substr($pole[1],1,1);

  $zfir_rf = $hlavicka->zfir_rf;
  $pole = explode(".", $zfir_rf);
  $Czfir_rf = $pole[0];
  $D1zfir_rf = substr($pole[1],0,1);
  $D2zfir_rf = substr($pole[1],1,1);

//zaciatok hlavicky
if ( $j == 0 )
     {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(5);
$pdf->SetTopMargin(20);
if ( File_Exists('../dokumenty/socpoist2014/vykaz_priloha.jpg') AND $j == 0 )
{
$pdf->Image('../dokumenty/socpoist2014/vykaz_priloha.jpg',0,0,210,298);
}
$pdf->SetY(10);

//zuctovane v mesiaci
$obdobie=$kli_vume*10000;
if ( $obdobie < 102009 ) $obdobie= "0".$obdobie;
$pdf->Cell(198,4,"                          ","$rmc1",1,"L");
$pdf->Cell(80,6," ","$rmc1",0,"L");$pdf->Cell(41,6,"$obdobie","$rmc",1,"C");

//typ priznania
$pdf->Cell(195,-3,"                          ","$rmc1",1,"L");
$riadne="x";
$opravne="x";
if ( $h_oprav == 0 ) { $opravne=""; }
if ( $h_oprav == 1 ) { $riadne=""; }
$pdf->Cell(172,4," ","$rmc1",0,"C");$pdf->Cell(4,5,"$riadne","$rmc",0,"C");$pdf->Cell(11,4," ","$rmc1",0,"C");$pdf->Cell(4,5,"$opravne","$rmc",1,"C");

//1. ZAMESTNAVATEL
$pdf->Cell(198,13,"     ","$rmc1",1,"L");
$pdf->Cell(4,6," ","$rmc1",0,"L");$pdf->Cell(38,6,"$cicz","$rmc",0,"C");
$icokrizik="x";
$pdf->Cell(86,6," ","$rmc1",0,"L");$pdf->Cell(4,5,"$icokrizik","$rmc",0,"C");$pdf->Cell(26,6," ","$rmc1",0,"L");$pdf->Cell(37,6,"$fir_fico","$rmc",1,"C");
$pdf->Cell(198,13,"                          ","$rmc1",1,"L");

$strana=$strana+1;
     }
//koniec hlavicky

//2. ZAMESTNANCI
$porcislo=$i+1;
$pdf->SetFont('arial','',10);
$pdf->Cell(3,6," ","$rmc1",0,"L");$pdf->Cell(12,7,"$porcislo","$rmc",0,"L");

$obdobiepr=$hlavicka->umeo*10000;
if ( $obdobie < 99999 ) { $obdobiepr="0".$obdobiepr; }

$pocdni=1*$hlavicka->pocdni;
if ( $pocdni == 0 )
     {
$sqldok = mysql_query("SELECT * FROM kalendar WHERE ume = $hlavicka->umeo");
$pocdni = 1*mysql_num_rows($sqldok);
     }

$strajk=$hlavicka->strajk;
if ( $strajk == 0 ) { $strajk=""; }
$pdf->Cell(5,6," ","$rmc1",0,"L");$pdf->Cell(26,7,"$obdobiepr","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");$pdf->Cell(35,7,"$hlavicka->vrdc $hlavicka->vrdk","$rmc",0,"L");
$pdf->Cell(10,6,"","$rmc1",0,"L");$pdf->Cell(8,7,"$pocdni","$rmc",0,"C");$pdf->Cell(14,6," ","$rmc1",0,"L");$pdf->Cell(7,7,"$strajk","$rmc",0,"C");
$pdf->Cell(28,6," ","$rmc1",0,"L");
//dopyt, vyzer� na nov� input
$pdf->Cell(8,7,"","$rmc",0,"C");

$typZec="ZEC";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpomer WHERE pm=$hlavicka->pom ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $typZec=trim($riaddok->pm3);
  }
if ( $typZec == "" ) { $typZec="ZEC"; }

//ak dohoda o brig.praci studenta a presiahne hranize pre platenie DOCH.POISTENIA prepis ZECD3 na ZECD3V a daj vynimka=1 takto mi to bralo socpoist.sk 30.1.2013
//v reakciach poslednych SP napr. z 8.2.2013 sa uvadza aj riesenie ZECD4 bez poistenia a ak vyssi prijem nez hranica tak ZECD3
if( $typZec == "ZECD3" AND $hlavicka->zzam_sp > 0 ) { $typZec="ZECD3V"; }

$pdf->SetFont('arial','',5);
$pdf->Cell(25,6," ","$rmc1",0,"L");$pdf->Cell(8,7,"$typZec","$rmc",1,"C");
$pdf->SetFont('arial','',9);

$pdf->Cell(198,8,"                          ","$rmc1",1,"L");
$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(15,6,"$Czfir_np","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(4,6,"$D1zfir_np","$rmc",0,"C");$pdf->Cell(3,6,"$D2zfir_np","$rmc",0,"C");
$pdf->Cell(4,6,"","$rmc1",0,"L");
$pdf->Cell(15,6,"$Czfir_sp","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(4,6,"$D1zfir_sp","$rmc",0,"C");$pdf->Cell(3,6,"$D2zfir_sp","$rmc",0,"C");
$pdf->Cell(3,6,"","$rmc1",0,"L");
$pdf->Cell(16,6,"$Czfir_ip","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(3,6,"$D1zfir_ip","$rmc",0,"C");$pdf->Cell(4,6,"$D2zfir_ip","$rmc",0,"C");
$pdf->Cell(3,6,"","$rmc1",0,"L");
$pdf->Cell(16,6,"$Czfir_pn","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(4,6,"$D1zfir_pn","$rmc",0,"C");$pdf->Cell(3,6,"$D2zfir_pn","$rmc",0,"C");
$pdf->Cell(3,6,"","$rmc1",0,"L");
$pdf->Cell(16,6,"$Czfir_up","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(4,6,"$D1zfir_up","$rmc",0,"C");$pdf->Cell(3,6,"$D2zfir_up","$rmc",0,"C");
$pdf->Cell(3,6,"","$rmc1",0,"L");
$pdf->Cell(16,6,"$Czfir_gf","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(3,6,"$D1zfir_gf","$rmc",0,"C");$pdf->Cell(4,6,"$D2zfir_gf","$rmc",0,"C");
$pdf->Cell(3,6,"","$rmc1",0,"L");
$pdf->Cell(16,6,"$Czfir_rf","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(3,6,"$D1zfir_rf","$rmc",0,"C");$pdf->Cell(4,6,"$D2zfir_rf","$rmc",1,"C");

$pdf->Cell(198,7,"                          ","$rmc1",1,"L");
$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(15,6,"$Czzam_np","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(4,6,"$D1zzam_np","$rmc",0,"C");$pdf->Cell(3,6,"$D2zzam_np","$rmc",0,"C");
$pdf->Cell(4,6,"","$rmc1",0,"L");
$pdf->Cell(16,6,"$Czzam_sp","$rmc",0,"R");$pdf->Cell(1,6,"","$rmc1",0,"L");$pdf->Cell(4,6,"$D1zzam_sp","$rmc",0,"C");$pdf->Cell(3,6,"$D2zzam_sp","$rmc",0,"C");
$pdf->Cell(3,6,"","$rmc1",0,"L");
$pdf->Cell(16,6,"$Czzam_ip","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(3,6,"$D1zzam_ip","$rmc",0,"C");$pdf->Cell(4,6,"$D2zzam_ip","$rmc",0,"C");
$pdf->Cell(3,6,"","$rmc1",0,"L");
$pdf->Cell(16,6,"$Czzam_pn","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(4,6,"$D1zzam_pn","$rmc",0,"C");$pdf->Cell(3,6,"$D2zzam_pn","$rmc",0,"C");

$menoprie=$hlavicka->prie." ".$hlavicka->meno;
if ( $meno == 0 ) $menoprie="";
$pdf->Cell(4,6,"","$rmc1",0,"L");$pdf->Cell(80,6,"$menoprie","$rmc",1,"L");

$pdf->Cell(198,4,"                          ","$rmc1",1,"L");
$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(15,6,"$Cofir_np","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(4,6,"$Dofir_np","$rmc",0,"C");$pdf->Cell(3,6,"$D2ofir_np","$rmc",0,"C");
$pdf->Cell(4,6,"","$rmc1",0,"L");
$pdf->Cell(15,6,"$Cofir_sp","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(4,6,"$Dofir_sp","$rmc",0,"C");$pdf->Cell(3,6,"$D2ofir_sp","$rmc",0,"C");
$pdf->Cell(3,6,"","$rmc1",0,"L");
$pdf->Cell(16,6,"$Cofir_ip","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(3,6,"$Dofir_ip","$rmc",0,"C");$pdf->Cell(4,6,"$D2ofir_ip","$rmc",0,"C");
$pdf->Cell(3,6,"","$rmc1",0,"L");
$pdf->Cell(16,6,"$Cofir_pn","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(4,6,"$Dofir_pn","$rmc",0,"C");$pdf->Cell(3,6,"$D2ofir_pn","$rmc",0,"C");
$pdf->Cell(3,6,"","$rmc1",0,"L");
$pdf->Cell(16,6,"$Cofir_up","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(4,6,"$Dofir_up","$rmc",0,"C");$pdf->Cell(3,6,"$D2ofir_up","$rmc",0,"C");
$pdf->Cell(3,6,"","$rmc1",0,"L");
$pdf->Cell(16,6,"$Cofir_gf","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(3,6,"$Dofir_gf","$rmc",0,"C");$pdf->Cell(4,6,"$D2ofir_gf","$rmc",0,"C");
$pdf->Cell(3,6,"","$rmc1",0,"L");
$pdf->Cell(16,6,"$Cofir_rf","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(3,6,"$Dofir_rf","$rmc",0,"C");$pdf->Cell(4,6,"$D2ofir_rf","$rmc",1,"C");

$pdf->Cell(198,4,"                          ","$rmc1",1,"L");
$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(15,6,"$Cozam_np","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(4,6,"$Dozam_np","$rmc",0,"C");$pdf->Cell(3,6,"$D2ozam_np","$rmc",0,"C");
$pdf->Cell(4,6,"","$rmc1",0,"L");
$pdf->Cell(15,6,"$Cozam_sp","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(4,6,"$Dozam_sp","$rmc",0,"C");$pdf->Cell(3,6,"$D2ozam_sp","$rmc",0,"C");
$pdf->Cell(3,6,"","$rmc1",0,"L");
$pdf->Cell(16,6,"$Cozam_ip","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(3,6,"$Dozam_ip","$rmc",0,"C");$pdf->Cell(4,6,"$D2ozam_ip","$rmc",0,"C");
$pdf->Cell(3,6,"","$rmc1",0,"L");
$pdf->Cell(16,6,"$Cozam_pn","$rmc",0,"R");$pdf->Cell(2,6,"","$rmc",0,"L");$pdf->Cell(4,6,"$Dozam_pn","$rmc",0,"C");$pdf->Cell(3,6,"$D2ozam_pn","$rmc",0,"C");
$skonci=$hlavicka->skonci;
if ( $skonci != 1 ) { $skonci=""; }
if ( $skonci == 1 ) { $skonci="x"; }
$neplat=$hlavicka->neplat;
if ( $neplat != 1 ) { $neplat=""; }
if ( $neplat == 1 ) { $neplat="x"; }
$pdf->Cell(28,6," ","$rmc1",0,"L");$pdf->Cell(4,9,"$skonci","$rmc",0,"C");$pdf->Cell(19,6," ","$rmc1",0,"L");$pdf->Cell(4,9,"$neplat","$rmc",1,"C");
$pdf->Cell(195,1,"                          ","$rmc1",1,"L");

//kal.dni vylucenych dob z doplnujucich o zamestnancovi
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $hlavicka->oc ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$spvod = trim($fir_riadok->spvod);
$spvdo = trim($fir_riadok->spvdo);
$spvtr = trim($fir_riadok->spvtr);
$spvtrx="";
if ( $spvtr == 'TRUE' ) { $spvtrx="x"; }
$pdf->Cell(114,6," ","$rmc1",0,"R");$pdf->Cell(31,7,"$spvod","$rmc",0,"C");$pdf->Cell(2,6,"","$rmc1",0,"L");$pdf->Cell(31,7,"$spvdo","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"R");$pdf->Cell(4,5,"$spvtrx","$rmc",1,"C");
$pdf->Cell(195,2,"                          ","$rmc1",1,"L");

if ( $j == 0 ) { $pdf->Cell(195,4,"                          ","$rmc1",1,"L"); }
if ( $j == 1 ) { $pdf->Cell(195,5,"                          ","$rmc1",1,"L"); }
if ( $j == 2 ) { $pdf->Cell(195,5,"                          ","$rmc1",1,"L"); }

//koniec tela polozky
}
$i = $i + 1;
$j = $j + 1;

if ( $j == 3 )
{
//3. vyplnil
$pdf->SetFont('arial','',10);
$pdf->SetY(269);
if ( $fir_mzdt05 == '' ) $fir_mzdt05=$kli_uzmeno." ".$kli_uzprie;
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(58,7,"$fir_mzdt05","$rmc",1,"L");

//pocet stran prilohy a datum vyplnenia
$pdf->SetY(284);
$datumvypln = $_REQUEST['davyp'];
$pdf->Cell(11,6," ","$rmc1",0,"L");$pdf->Cell(16,6,"$strana","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"L");$pdf->Cell(31,6,"$datumvypln","$rmc",1,"C");

$j=0;
}
  }

if ( $j > 0 )
{
//3. vyplnil
$pdf->SetFont('arial','',10);
$pdf->SetY(269);
if ( $fir_mzdt05 == '' ) $fir_mzdt05=$kli_uzmeno." ".$kli_uzprie;
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(58,7,"$fir_mzdt05","$rmc",1,"L");

//pocet stran prilohy a datum vyplnenia
$pdf->SetY(284);
$datumvypln = $_REQUEST['davyp'];
$pdf->Cell(11,6," ","$rmc1",0,"L");$pdf->Cell(16,6,"$strana","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"L");$pdf->Cell(31,6,"$datumvypln","$rmc",1,"C");

$j=0;
}

$pdf->Output("../tmp/prilohaSP.$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/prilohaSP.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

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
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
}
////////////////////////////////////////////////////KONIEC VYTLACENIA PRILOHY VYKAZU
?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Mesa�n� v�kazy pre SP 2014</title>
  <style type="text/css">
h3 {
  padding:0;
  margin:10px 0;
  font-size:14px;
  font-family:Tahoma;
  color:#6cb9d2;   
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
<BODY class="white" id="white" onload="" >

<table class="h2" width="100%" >
<tr>
<td>EuroSecom - V�kazy pre Soci�lnu pois�ov�u 2014</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>

<h3>&nbsp;V�kaz poistn�ho a pr�spevkov</h3>

<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU PRE ELEKTRONIKU
if ( $copern == 30 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if ( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;

$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$idx=$kli_uzid.$hhmm;
$nazsub="prilVP".$kli_vmes."_id".$idx;

//$nazsub="pril".$kli_vmes;


if ( File_Exists("../tmp/$nazsub.xml") ) { $soubor = unlink("../tmp/$nazsub.xml"); }
     $soubor = fopen("../tmp/$nazsub.xml", "a+");

/////////////NACITANIE CISLA PLATITELA,NAZVU Z CISELNIKA ZP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv=$cislo_zdrv ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $platitel=$riaddok->vsy;
  $nazzdrv=$riaddok->nzdr;
  }

//XML verzia 2014
$sqlt = <<<mzdprc
(
<?xml version="1.0" encoding="UTF-8"?>
<vpp xmlns="http://socpoist.sk/xsd/vpp2014" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://socpoist.sk/xsd/vpp2014 VPP-v2014.xsd">
	<typDoc>VPP00001</typDoc>
	<cisloVykazu>01992014</cisloVykazu>
	<obdobieVyplPrijmov>012014</obdobieVyplPrijmov>
	<typVykazu>R</typVykazu>
	<zamestnavatel>
		<identifikacia>
			<variabilnySymbol>1234567890</variabilnySymbol>
			<identifikator>
				<dic>12345678</dic>
			</identifikator>
			<nazov>Firma, s.r.o.</nazov>
		</identifikacia>
		<ucet>
			<nazovSidloBanky>Banka</nazovSidloBanky>
			<iban>SK00001234567890</iban>
		</ucet>
	</zamestnavatel>
	<poistne>
		<np>
			<npZamtel>21.00</npZamtel>
			<npZamnec>21.00</npZamnec>
		</np>
		<sp>
			<spZamtel>210.00</spZamtel>
			<spZamnec>60.00</spZamnec>
		</sp>
		<ip>
			<ipZamtel>45.00</ipZamtel>
			<ipZamnec>45.00</ipZamnec>
		</ip>
		<pvn>
			<pvnZamtel>15.00</pvnZamtel>
			<pvnZamnec>15.00</pvnZamnec>
		</pvn>
		<up>
			<upZamtel>12.00</upZamtel>
		</up>
		<gp>
			<gpZamtel>3.75</gpZamtel>
		</gp>
		<rfs>
			<rfsZamtel>71.25</rfsZamtel>
		</rfs>
		<spoluPoistne>519.00</spoluPoistne>
	</poistne>
	<fOsoba>
		<priezvisko>Priezvisko</priezvisko>
		<meno>Meno</meno>
		<tel>1234567890</tel>
		<mail>mail@mail.mail</mail>
	</fOsoba>
	<vystavenie>
		<zostavil>Zostavil</zostavil>
		<datum>13.01.2014</datum>
	</vystavenie>
	<priloha>
		<poistneZamestnancov>
		<!-- Zamestnanec - pravidelny prijem. -->
			<poistneZamestnanca pc="1" obdobie="122013" rc="1234567890" pocDni="31" typZec="ZEC" vynimkaVZ="0" rozsahSP="1111111" vzNp="300.00" vzSp="300.00" vzIp="300.00" vzPvn="300.00" vzUp="300.00" vzGp="300.00" vzRfs="300.00" vzZecNp="300.00" vzZecSp="300.00" vzZecIp="300.00" vzZecPvn="300.00" npZamtel="4.20" npZamnec="4.20" spZamtel="42.00" spZamnec="12.00" ipZamtel="9.00" ipZamnec="9.00" pvnZamtel="3.00" pvnZamnec="3.00" upZamtel="2.40" gpZamtel="0.75" rfsZamtel="14.25" poSkonceni="1"/>
		<!-- Zamestnanec - pravidelny prijem. Sucet pocDniStrajku a pocDni nesmie byt vyssi ako je pocet dni v kal. mesiaci.-->
			<poistneZamestnanca pc="2" obdobie="112013" rc="1134567890" pocDni="29" typZec="ZEC" vynimkaVZ="0" rozsahSP="1111111" vzNp="300.00" vzSp="300.00" vzIp="300.00" vzPvn="300.00" vzUp="300.00" vzGp="300.00" vzRfs="300.00" vzZecNp="300.00" vzZecSp="300.00" vzZecIp="300.00" vzZecPvn="300.00" npZamtel="4.20" npZamnec="4.20" spZamtel="42.00" spZamnec="12.00" ipZamtel="9.00" ipZamnec="9.00" pvnZamtel="3.00" pvnZamnec="3.00" upZamtel="2.40" gpZamtel="0.75" rfsZamtel="14.25" poSkonceni="1" pocDniStrajku="1"/>
		<!-- Zamestnanec - pravidelny prijem s uvedenim vylucDobyObdobieOd. -->
			<poistneZamestnanca pc="3" obdobie="112013" rc="1233567890" pocDni="30" typZec="ZEC" vynimkaVZ="0" rozsahSP="1111111" vzNp="300.00" vzSp="300.00" vzIp="300.00" vzPvn="300.00" vzUp="300.00" vzGp="300.00" vzRfs="300.00" vzZecNp="300.00" vzZecSp="300.00" vzZecIp="300.00" vzZecPvn="300.00" npZamtel="4.20" npZamnec="4.20" spZamtel="42.00" spZamnec="12.00" ipZamtel="9.00" ipZamnec="9.00" pvnZamtel="3.00" pvnZamnec="3.00" upZamtel="2.40" gpZamtel="0.75" rfsZamtel="14.25" poSkonceni="1" vylucDobyObdobieOd="30.01.2014"/>
		<!-- Zamestnanec - pravidelny prijem s uvedenim vylucDobyObdobieDo. -->
			<poistneZamestnanca pc="4" obdobie="122013" rc="1234456789" pocDni="31" typZec="ZEC" vynimkaVZ="0" rozsahSP="1111111" vzNp="300.00" vzSp="300.00" vzIp="300.00" vzPvn="300.00" vzUp="300.00" vzGp="300.00" vzRfs="300.00" vzZecNp="300.00" vzZecSp="300.00" vzZecIp="300.00" vzZecPvn="300.00" npZamtel="4.20" npZamnec="4.20" spZamtel="42.00" spZamnec="12.00" ipZamtel="9.00" ipZamnec="9.00" pvnZamtel="3.00" pvnZamnec="3.00" upZamtel="2.40" gpZamtel="0.75" rfsZamtel="14.25" poSkonceni="1" vylucDobyObdobieDo="10.01.2014"/>
		<!-- Zamestnanec - pravidelny prijem s uvedenim vylucDobyTrva. Je mozne pouzit boolean hodnoty true alebo false, tak aj ciselne zastupenie 1 alebo 0. -->
			<poistneZamestnanca pc="5" obdobie="112013" rc="1234557890" pocDni="30" typZec="ZEC" vynimkaVZ="0" rozsahSP="1111111" vzNp="300.00" vzSp="300.00" vzIp="300.00" vzPvn="300.00" vzUp="300.00" vzGp="300.00" vzRfs="300.00" vzZecNp="300.00" vzZecSp="300.00" vzZecIp="300.00" vzZecPvn="300.00" npZamtel="4.20" npZamnec="4.20" spZamtel="42.00" spZamnec="12.00" ipZamtel="9.00" ipZamnec="9.00" pvnZamtel="3.00" pvnZamnec="3.00" upZamtel="2.40" gpZamtel="0.75" rfsZamtel="14.25" poSkonceni="1" vylucDobyTrva="true"/>
		</poistneZamestnancov>
	</priloha>

</vpp>
);
mzdprc;

$sqltt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE ".
" zfir_np = 0 AND zfir_sp = 0 AND  zfir_ip = 0 AND  zfir_pn = 0 AND  zfir_up = 0 AND  zfir_gf = 0 AND  zfir_rf = 0 AND pocdni = 0 ";
$sql = mysql_query("$sqltt");

//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE konx = 9 ORDER BY konx";

$nulapoloziek=0;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
if( $pol == 0 ) $nulapoloziek=1;

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i) OR $nulapoloziek == 1 )
{
$hlavicka=mysql_fetch_object($sql);

$obdobie=$kli_vmes;
$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>"."\r\n";
  fwrite($soubor, $text);

  $text = "<vpp xmlns=\"http://socpoist.sk/xsd/vpp2014\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\""."\r\n";
  fwrite($soubor, $text);
  $text = "xsi:schemaLocation=\"http://socpoist.sk/xsd/vpp2014 VPP-v2014.xsd\" >"."\r\n";
  fwrite($soubor, $text);

  $text = "<typDoc>VPP00001</typDoc>"."\r\n";
  fwrite($soubor, $text);

  $text = "<cisloVykazu>".$kli_vmes."99".$kli_vrok."</cisloVykazu>"."\r\n";
  fwrite($soubor, $text);

  $text = "<obdobieVyplPrijmov>".$kli_vmes.$kli_vrok."</obdobieVyplPrijmov>"."\r\n";
  fwrite($soubor, $text);
  if( $h_oprav == 0 ) { $text = "<typVykazu>R</typVykazu>"."\r\n"; }
  if( $h_oprav == 1 ) { $text = "<typVykazu>O</typVykazu>"."\r\n"; }
  fwrite($soubor, $text);


  $text = "<zamestnavatel>"."\r\n";
  fwrite($soubor, $text);

  $text = "<identifikacia>"."\r\n";
  fwrite($soubor, $text);
  $text = "<variabilnySymbol>$cicz</variabilnySymbol>"."\r\n";
  fwrite($soubor, $text);
  $text = "<identifikator>"."\r\n";
  fwrite($soubor, $text);
  $text = "<dic>$fir_fdic</dic>"."\r\n";
  fwrite($soubor, $text);
  $text = "</identifikator>"."\r\n";
  fwrite($soubor, $text);
$fir_fnaz = $retezec = iconv("CP1250", "UTF-8", $fir_fnaz);
$fir_fnaz = str_replace("&","a",$fir_fnaz);
  $text = "<nazov>$fir_fnaz</nazov>"."\r\n";
  fwrite($soubor, $text);

  $text = "<tel>$fir_ftel</tel>"."\r\n";
  fwrite($soubor, $text);
  $text = "<mail>$fir_fem1</mail>"."\r\n";
  fwrite($soubor, $text);

  $text = "</identifikacia>"."\r\n";
  fwrite($soubor, $text);


  $text = "<ucet>"."\r\n";
  fwrite($soubor, $text);
$fir_fnb1 = $retezec = iconv("CP1250", "UTF-8", $fir_fnb1);
$fir_fsb1 = $retezec = iconv("CP1250", "UTF-8", $fir_fsb1);
$fir_fib1 = str_replace(" ","",$fir_fib1);
  $text = "<nazovSidloBanky>$fir_fnb1 $fir_fsb1</nazovSidloBanky>"."\r\n";
  fwrite($soubor, $text);
  $text = "<iban>$fir_fib1</iban>"."\r\n";
  fwrite($soubor, $text);
  $text = "</ucet>"."\r\n";
  fwrite($soubor, $text);
  $text = "</zamestnavatel>"."\r\n";
  fwrite($soubor, $text);

$Cislo=$hlavicka->ofir_np+"";
$ofir_np=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ofir_sp+"";
$ofir_sp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ofir_ip+"";
$ofir_ip=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ofir_pn+"";
$ofir_pn=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ofir_up+"";
$ofir_up=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ofir_gf+"";
$ofir_gf=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ofir_rf+"";
$ofir_rf=sprintf("%0.2f", $Cislo);

$Cislo=$hlavicka->ozam_np+"";
$ozam_np=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_sp+"";
$ozam_sp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_ip+"";
$ozam_ip=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_pn+"";
$ozam_pn=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_up+"";
$ozam_up=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_gf+"";
$ozam_gf=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_rf+"";
$ozam_rf=sprintf("%0.2f", $Cislo);

$Cislo=$hlavicka->celk_spolu+"";
$celk_spolu=sprintf("%0.2f", $Cislo);

$pzam_np=$hlavicka->pzam_np;
if( $pzam_np == "" ) $pzam_np=0;
$pzam_sp=$hlavicka->pzam_sp;
if( $pzam_sp == "" ) $pzam_sp=0;
$pzam_ip=$hlavicka->pzam_ip;
if( $pzam_ip == "" ) $pzam_ip=0;
$pzam_pn=$hlavicka->pzam_pn;
if( $pzam_pn == "" ) $pzam_pn=0;
$pzam_up=$hlavicka->pzam_up;
if( $pzam_up == "" ) $pzam_up=0;
$pzam_gf=$hlavicka->pzam_gf;
if( $pzam_gf == "" ) $pzam_gf=0;
$pzam_rf=$hlavicka->pzam_rf;
if( $pzam_rf == "" ) $pzam_rf=0;

  $text = "<poistne>"."\r\n";  fwrite($soubor, $text);
  $text = "<np>"."\r\n";  fwrite($soubor, $text);
  $text = "<npZamtel>$ofir_np</npZamtel>"."\r\n";  fwrite($soubor, $text);
  $text = "<npZamnec>$ozam_np</npZamnec>"."\r\n";  fwrite($soubor, $text);
  $text = "</np>"."\r\n";  fwrite($soubor, $text);

  $text = "<sp>"."\r\n";  fwrite($soubor, $text);
  $text = "<spZamtel>$ofir_sp</spZamtel>"."\r\n";  fwrite($soubor, $text);
  $text = "<spZamnec>$ozam_sp</spZamnec>"."\r\n";  fwrite($soubor, $text);
  $text = "</sp>"."\r\n";  fwrite($soubor, $text);

  $text = "<ip>"."\r\n";  fwrite($soubor, $text);
  $text = "<ipZamtel>$ofir_ip</ipZamtel>"."\r\n";  fwrite($soubor, $text);
  $text = "<ipZamnec>$ozam_ip</ipZamnec>"."\r\n";  fwrite($soubor, $text);
  $text = "</ip>"."\r\n";  fwrite($soubor, $text);

  $text = "<pvn>"."\r\n";  fwrite($soubor, $text);
  $text = "<pvnZamtel>$ofir_pn</pvnZamtel>"."\r\n";  fwrite($soubor, $text);
  $text = "<pvnZamnec>$ozam_pn</pvnZamnec>"."\r\n";  fwrite($soubor, $text);
  $text = "</pvn>"."\r\n";  fwrite($soubor, $text);

  $text = "<up>"."\r\n";  fwrite($soubor, $text);
  $text = "<upZamtel>$ofir_up</upZamtel>"."\r\n";  fwrite($soubor, $text);
  $text = "<upZamnec>0.00</upZamnec>"."\r\n";  fwrite($soubor, $text);
  $text = "</up>"."\r\n";  fwrite($soubor, $text);

  $text = "<gp>"."\r\n";  fwrite($soubor, $text);
  $text = "<gpZamtel>$ofir_gf</gpZamtel>"."\r\n";  fwrite($soubor, $text);
  $text = "<gpZamnec>0.00</gpZamnec>"."\r\n";  fwrite($soubor, $text);
  $text = "</gp>"."\r\n";  fwrite($soubor, $text);

  $text = "<rfs>"."\r\n";  fwrite($soubor, $text);
  $text = "<rfsZamtel>$ofir_rf</rfsZamtel>"."\r\n";  fwrite($soubor, $text);
  $text = "<rfsZamnec>0.00</rfsZamnec>"."\r\n";  fwrite($soubor, $text);
  $text = "</rfs>"."\r\n";  fwrite($soubor, $text);

  $text = "<spoluPoistne>$celk_spolu</spoluPoistne>"."\r\n";  fwrite($soubor, $text);
  $text = "</poistne>"."\r\n";  fwrite($soubor, $text);

//fOsoba sp z dalsich udajov 
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";

$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$priefosoba = trim($fir_riadok->fospprie);
$menofosoba = trim($fir_riadok->fospmeno);
$telfosoba = trim($fir_riadok->fosptel);
$mailfosoba = trim($fir_riadok->fospmail);

if( $priefosoba == '' ) { $priefosoba="mzdov�"; }
if( $menofosoba == '' ) { $menofosoba="��t�re�"; }
if( $telfosoba == '' ) { $telfosoba=$fir_ftel; }
if( $mailfosoba == '' ) { $mailfosoba=$fir_fem1; }

$priefosoba = $retezec = iconv("CP1250", "UTF-8", $priefosoba);
$menofosoba = $retezec = iconv("CP1250", "UTF-8", $menofosoba);
$telfosoba = $retezec = iconv("CP1250", "UTF-8", $telfosoba);
$mailfosoba = $retezec = iconv("CP1250", "UTF-8", $mailfosoba);

  $text = "<fOsoba>"."\r\n";  fwrite($soubor, $text);
  $text = "<priezvisko>$priefosoba</priezvisko>"."\r\n";  fwrite($soubor, $text);
  $text = "<meno>$menofosoba</meno>"."\r\n";  fwrite($soubor, $text);
  $text = "<tel>$telfosoba</tel>"."\r\n";  fwrite($soubor, $text);
  $text = "<mail>$mailfosoba</mail>"."\r\n";  fwrite($soubor, $text);
  $text = "</fOsoba>"."\r\n";  fwrite($soubor, $text);

  $text = "<vystavenie>"."\r\n";
  fwrite($soubor, $text);
if( $fir_mzdt05 == '' ) $fir_mzdt05=$kli_uzmeno." ".$kli_uzprie;
$fir_mzdt05 = $retezec = iconv("CP1250", "UTF-8", $fir_mzdt05);
  $text = "<zostavil>$fir_mzdt05</zostavil>"."\r\n";
  fwrite($soubor, $text);

$datumvypln = $_REQUEST['davyp'];
if( $datumvypln == '' ) { $datumvypln=$dat_dat; }

  $text = "<datum>$datumvypln</datum>"."\r\n";
  fwrite($soubor, $text);
  $text = "</vystavenie>"."\r\n";
  fwrite($soubor, $text);

  $text = "<priloha>"."\r\n";
  fwrite($soubor, $text);
  $text = "<poistneZamestnancov>"."\r\n";
  fwrite($soubor, $text);



}
$i = $i + 1;
$j = $j + 1;
  }

//polozky

//dopln udaje kun do vypl
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET zpnie=0, zpnie=uvazn".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE konx = 0 ORDER BY konx,rdc,umeo";


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

$Cislo=$hlavicka->ofir_np+"";
$ofir_np=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ofir_sp+"";
$ofir_sp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ofir_ip+"";
$ofir_ip=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ofir_pn+"";
$ofir_pn=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ofir_up+"";
$ofir_up=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ofir_gf+"";
$ofir_gf=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ofir_rf+"";
$ofir_rf=sprintf("%0.2f", $Cislo);

$Cislo=$hlavicka->ozam_np+"";
$ozam_np=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_sp+"";
$ozam_sp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_ip+"";
$ozam_ip=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_pn+"";
$ozam_pn=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_up+"";
$ozam_up=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_gf+"";
$ozam_gf=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_rf+"";
$ozam_rf=sprintf("%0.2f", $Cislo);

$vynimkaVZ="0";
$typZec="ZEC";
//od 1.1.2013 nove typy zec budem brat z ciselnika pomerov
//if( $hlavicka->konx1 == 1 AND $hlavicka->pom != 50 AND $hlavicka->pom != 51 ) $typZec="D";

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpomer WHERE pm=$hlavicka->pom ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $typZec=trim($riaddok->pm3);
  }
if( $typZec == "" ) { $typZec="ZEC"; }

//ak dohoda o brig.praci studenta a presiahne hranize pre platenie DOCH.POISTENIA prepis ZECD3 na ZECD3V a daj vynimka=1 takto mi to bralo socpoist.sk 30.1.2013
if( $typZec == "ZECD3" AND $hlavicka->zzam_sp > 0 ) { $typZec="ZECD3V"; $vynimkaVZ="1"; }


$sqlttxx = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET pocdni=0 WHERE ".
" zfir_np = 0 AND zfir_sp = 0 AND  zfir_ip = 0 AND  zfir_pn = 0 AND  zfir_up = 0 AND  zfir_gf = 0 AND  zfir_rf = 0 ";
$sqlxx = mysql_query("$sqlttxx");

$niezaklad=0;
if( $hlavicka->zfir_np == 0 AND $hlavicka->zfir_sp == 0 AND $hlavicka->zfir_ip == 0 AND $hlavicka->zfir_pn == 0 AND $hlavicka->zfir_up == 0 AND $hlavicka->zfir_gf == 0 AND $hlavicka->zfir_rf == 0 ) { $niezaklad=1; }

$pocdni=1*$hlavicka->pocdni;
if( $pocdni == 0 )
  {
$sqldok = mysql_query("SELECT * FROM kalendar WHERE ume = $hlavicka->umeo ");
$pocdni = 1*mysql_num_rows($sqldok);
  }

if( $niezaklad == 1 )
  {
$pocdni=0;
  }

$strajk=$hlavicka->strajk;
if( $strajk == 0 ) { $strajk="0"; }
$skonci=$hlavicka->skonci;
if( $skonci != 1 ) { $skonci="0"; }
if( $skonci == 1 ) { $skonci="1"; }
if( $hlavicka->pom == 61 ) { $skonci="1"; }
$neplat=$hlavicka->neplat;
if( $neplat != 1 ) { $neplat="0"; }
if( $neplat == 1 ) { $neplat="1"; }

//od 1.1.2013 vynimkaVZ len 0 a 1=ak viac dohod a prekroci maxVZ zamestnavatel plati vsetko zamestnanec len z rozdielu

$rozsahSPnp="1";
if( $hlavicka->zzam_np == 0 ) $rozsahSPnp="0";
$rozsahSPsp="1";
if( $hlavicka->zzam_sp == 0 ) $rozsahSPsp="0";
$rozsahSPip="1";
if( $hlavicka->zzam_ip == 0 ) $rozsahSPip="0";
$rozsahSPpn="1";
if( $hlavicka->zzam_pn == 0 ) $rozsahSPpn="0";
$rozsahSPup="1";
if( $hlavicka->zfir_up == 0 ) $rozsahSPup="0";
$rozsahSPgf="1";
if( $hlavicka->zfir_gf == 0 ) $rozsahSPgf="0";
$rozsahSPrf="1";
if( $hlavicka->zfir_rf == 0 ) $rozsahSPrf="0";

$rozsahSP=$rozsahSPnp.$rozsahSPsp.$rozsahSPip.$rozsahSPpn.$rozsahSPup.$rozsahSPgf.$rozsahSPrf;
$rodnecislo=$hlavicka->rdc.$hlavicka->rdk;
//$rodnecislo=6505146681;

$obdobie=$hlavicka->obdobie;
$obdobie=$hlavicka->umeo*10000;
if( $obdobie < 99999 ) { $obdobie="0".$obdobie; }


  $text = "<poistneZamestnanca pc=\"$cislo\" obdobie=\"$obdobie\" rc=\"$rodnecislo\" pocDni=\"$pocdni\" typZec=\"$typZec\""."\r\n";
  fwrite($soubor, $text);
  $text = "vynimkaVZ=\"$vynimkaVZ\" rozsahSP=\"$rozsahSP\" vzNp=\"$hlavicka->zfir_np\" vzSp=\"$hlavicka->zfir_sp\" vzIp=\"$hlavicka->zfir_ip\""."\r\n";
  fwrite($soubor, $text);
  $text = "vzPvn=\"$hlavicka->zfir_pn\" vzUp=\"$hlavicka->zfir_up\" vzGp=\"$hlavicka->zfir_gf\" vzRfs=\"$hlavicka->zfir_rf\" "."\r\n";
  fwrite($soubor, $text);

  $text = "vzZecNp=\"$hlavicka->zzam_np\" vzZecSp=\"$hlavicka->zzam_sp\" vzZecIp=\"$hlavicka->zzam_ip\""."\r\n";
  fwrite($soubor, $text);
  $text = "vzZecPvn=\"$hlavicka->zzam_pn\" "."\r\n";
  fwrite($soubor, $text);

  $text = "npZamtel=\"$ofir_np\" npZamnec=\"$ozam_np\" spZamtel=\"$ofir_sp\" spZamnec=\"$ozam_sp\" ipZamtel=\"$ofir_ip\" ipZamnec=\"$ozam_ip\""."\r\n";
  fwrite($soubor, $text);
  $text = "pvnZamtel=\"$ofir_pn\" pvnZamnec=\"$ozam_pn\" upZamtel=\"$ofir_up\" gpZamtel=\"$ofir_gf\" rfsZamtel=\"$ofir_rf\""."\r\n";
  fwrite($soubor, $text);

//kal.dni vylucenych dob z doplnujucich o zamestnancovi 
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $hlavicka->oc ";

$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$spvod = trim($fir_riadok->spvod);
$spvdo = trim($fir_riadok->spvdo);
$spvtr = trim($fir_riadok->spvtr);

if( $spvod != '' ) {   $text = "vylucDobyObdobieOd=\"$spvod\" "."\r\n"; fwrite($soubor, $text); }
if( $spvdo != '' ) {   $text = "vylucDobyObdobieDo=\"$spvdo\" "."\r\n"; fwrite($soubor, $text); }
if( $spvdo != '' ) {   $text = "vylucDobyTrva=\"$spvtr\" "."\r\n"; fwrite($soubor, $text); }

  $text = " poSkonceni=\"$skonci\" pocDniStrajku=\"$strajk\" />"."\r\n";
  fwrite($soubor, $text);




}
$i = $i + 1;
$j = $j + 1;
  }

  $text = "</poistneZamestnancov>"."\r\n";
  fwrite($soubor, $text);
  $text = "</priloha>"."\r\n";
  fwrite($soubor, $text);
  $text = "</vpp>"."\r\n";
  fwrite($soubor, $text);

fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.xml">../tmp/<?php echo $nazsub; ?>.xml</a>
<br />
<br />
<br />
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
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

}
///////////////////////////////////////////////////KONIEC SUBORU PRE ELEKTRONIKU

?>


<?php
// celkovy koniec dokumentu
$zmenume=1; $odkaz="../mzdy/vykaz_SP.php?&copern=1&page=1&ostre=0";
$cislista = include("mzd_lista.php");

       } while (false);
?>
</BODY>
</HTML>
