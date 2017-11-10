<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu PRACA 204 rok 2017
do
{
$sys = 'MZD';
$urov = 2000;
$uziv = include("../uziv.php");
if ( !$uziv ) exit;
if (!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 AND $copern == 11 ) $strana=9999;
if ( $strana == 0 ) $strana=1;

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$stvrtrok=1;
$vyb_ump="1.".$kli_vrok;
$vyb_ums="2.".$kli_vrok;
$vyb_umk="3.".$kli_vrok;
$mesiac="03";
if ( $kli_vmes > 3 ) { $stvrtrok=2; $vyb_ump="4.".$kli_vrok; $vyb_ums="5.".$kli_vrok; $vyb_umk="6.".$kli_vrok; $mesiac="06"; }
if ( $kli_vmes > 6 ) { $stvrtrok=3; $vyb_ump="7.".$kli_vrok; $vyb_ums="8.".$kli_vrok; $vyb_umk="9.".$kli_vrok; $mesiac="09"; }
if ( $kli_vmes > 9 ) { $stvrtrok=4; $vyb_ump="10.".$kli_vrok; $vyb_ums="11.".$kli_vrok; $vyb_umk="12.".$kli_vrok; $mesiac="12"; }
$kli_vrokx = substr($kli_vrok,2,2);

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$modul = 1*$_REQUEST['modul'];

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//.jpg podklad
$jpg_cesta="../dokumenty/statistika2017/praca204/praca204_v17";
$jpg_popis="tlaËivo ätvrùroËn˝ v˝kaz o pr·ci Pr·ca 2-04 ".$kli_vrok;

if ( $copern == 101 ) { $copern=102; }

//pracovny subor statistika_p1304
$sql = "SELECT * FROM F$kli_vxcf"."_statistika_praca204 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_statistika_praca204';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   psys         INT,
   cinnost      VARCHAR(80),
   ico          DECIMAL(8,0)
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statistika_praca204'.$sqlt;
$vytvor = mysql_query("$vsql");

$ttvv = "INSERT INTO F$kli_vxcf"."_statistika_praca204 ( ico ) VALUES ( '0' )";
$ttqq = mysql_query("$ttvv");

}
$sql = "SELECT mod5r01 FROM F$kli_vxcf"."_statistika_praca204 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r99 DECIMAL(10,1) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r25 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r24 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r23 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r22 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r21 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r20 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r19 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r18 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r17 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r16 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r15 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r14 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r13 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r12 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r11 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r10 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r09 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r08 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r07 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r06 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r05 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r04 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r03 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r02 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod5r01 DECIMAL(10,1) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT mod2r01 FROM F$kli_vxcf"."_statistika_praca204 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod2r02 DECIMAL(10,0) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD mod2r01 DECIMAL(10,0) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT odoslane FROM F$kli_vxcf"."_statistika_praca204 ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_praca204 ADD odoslane DATE NOT NULL AFTER ico";
$vysledek = mysql_query("$sql");
}
//koniec pracovny subor


//zapis do statistickej TABLE a prepni do stat zostavy
if( $copern == 200 )
{
$h_mfir = 1*strip_tags($_REQUEST['h_mfir']);
$vyb_ume = strip_tags($_REQUEST['vyb_ume']);
//echo $h_mfir;
//echo $vyb_ume;

$vsql = 'DROP TABLE F'.$kli_vxcf.'_statprac';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statprac
(
   drh          DECIMAL(3,0) DEFAULT 0,
   oc           INT(5),
   ume          DECIMAL(7,4) DEFAULT 0,
   rodc         VARCHAR(6),
   zena         INT(1),
   pom          DECIMAL(3,0) DEFAULT 0,
   dhpom        DECIMAL(3,0) DEFAULT 0,
   pocet        DECIMAL(10,0) DEFAULT 0,
   dm           INT(5),
   dni          DECIMAL(10,2) DEFAULT 0,
   hod          DECIMAL(10,2) DEFAULT 0,
   kc           DECIMAL(10,2) DEFAULT 0,
   uvax         DECIMAL(10,2) DEFAULT 0,
   uvap         DECIMAL(10,2) DEFAULT 0,
   skrat        DECIMAL(3,0) DEFAULT 0,
   ico          DECIMAL(8,0)
);
statprac;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statprac'.$sqlt;
$vytvor = mysql_query("$vsql");

//pocet zamestnancov

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 0,oc,ume,rdc,0,pom,0,1, ".
"0,0,0,0,uva,0,0,$fir_fico".
" FROM F$kli_vxcf"."_mzdzalkun".
" WHERE pom != 9 AND ume >= $vyb_ump AND ume <= $vyb_umk".
"";
$dsql = mysql_query("$dsqlt");

$uprtxt = "UPDATE F$kli_vxcf"."_statprac,F$kli_vxcf"."_mzdpomer SET ".
" dhpom=pm_doh, zena=SUBSTRING(rodc,3,2) ".
" WHERE F$kli_vxcf"."_statprac.pom = F$kli_vxcf"."_mzdpomer.pm";
$upravene = mysql_query("$uprtxt");

/////////////NACITANIE prac.uvazku standartneho
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uva_hod=$riaddok->uva_hod;
  }

$uprtxt = "UPDATE F$kli_vxcf"."_statprac SET uvap=uvax/$uva_hod ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_statprac SET skrat=1 WHERE uvap < 0.8 ";
$upravene = mysql_query("$uprtxt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 999,oc,ume,rodc,zena,pom,dhpom,SUM(pocet), ".
"dm,dni,hod,kc,0,0,0,$fir_fico".
" FROM F$kli_vxcf"."_statprac".
" WHERE dhpom >= 0".
" GROUP BY ume,dhpom";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 998,oc,ume,rodc,zena,pom,dhpom,SUM(pocet), ".
"dm,dni,hod,kc,0,0,0,$fir_fico".
" FROM F$kli_vxcf"."_statprac".
" WHERE dhpom = 1".
" GROUP BY oc";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 993,oc,ume,rodc,zena,pom,dhpom,SUM(pocet), ".
"dm,dni,hod,kc,0,0,skrat,$fir_fico".
" FROM F$kli_vxcf"."_statprac".
" WHERE skrat = 1".
" GROUP BY oc";
$dsql = mysql_query("$dsqlt");
//exit;

$r01=0; $r01p=0; $r01s=0; $r01k=0; $r03=0; $r08=0; $skrat=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 993 AND skrat = 1";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $skrat=$skrat+1; }
$i=$i+1;                  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_ump AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01p=$r01p+$polozka->pocet; }
$i=$i+1;                  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_ums AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01s=$r01s+$polozka->pocet; }
$i=$i+1;                  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_umk AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01k=$r01k+$polozka->pocet; }
$i=$i+1;                  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 0 AND ume = $vyb_umk AND zena > 12 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r03=$r03+1; }
$i=$i+1;                  }

$r01=($r01p+$r01s+$r01k)/3;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 998";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r08=$r08+1; }
$i=$i+1;                  }

//odpracovane hodiny a eur a odvody
$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 0,oc,ume,'',0,vpom,0,1, ".
"dm,dni,hod,kc,0,0,0,$fir_fico".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume >= $vyb_ump AND ume <= $vyb_umk".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 0,oc,ume,'',0,spom,0,1, ".
"9999,0,0,(ofir_zp+ofir_np+ofir_sp+ofir_ip+ofir_pn+ofir_up+ofir_gf+ofir_rf),0,0,0,$fir_fico".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE ume >= $vyb_ump AND ume <= $vyb_umk".
"";
$dsql = mysql_query("$dsqlt");

$uprtxt = "UPDATE F$kli_vxcf"."_statprac,F$kli_vxcf"."_mzdpomer SET ".
" dhpom=pm_doh ".
" WHERE F$kli_vxcf"."_statprac.pom = F$kli_vxcf"."_mzdpomer.pm";
$upravene = mysql_query("$uprtxt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 555,oc,ume,rodc,zena,pom,dhpom,pocet, ".
"dm,SUM(dni),SUM(hod),SUM(kc),0,0,0,$fir_fico".
" FROM F$kli_vxcf"."_statprac".
" WHERE dhpom >= 0".
" GROUP BY ume,dhpom,dm";
$dsql = mysql_query("$dsqlt");

$r07=0; $r09=0; $r10=0; $r11=0; $r12=0; $r13=0; $r14=0; $r15=0; $r16=0; $r17=0; $r18=0; $r19=0; $r20=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( ( dm > 100 AND dm < 111 ) OR dm = 132 OR dm = 209 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r07=$r07+$polozka->hod; }
$i=$i+1;                  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 1 AND ( ( dm > 100 AND dm < 111 ) OR dm = 132 OR dm = 209 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r09=$r09+$polozka->hod; }
$i=$i+1;                  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( dm > 100 AND dm < 600 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r10=$r10+$polozka->kc; }
$i=$i+1;                  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( dm > 500 AND dm < 600 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r11=$r11+$polozka->kc; }
$i=$i+1;                  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 1 AND ( dm > 100 AND dm < 600 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r17=$r17+$polozka->kc; }
$i=$i+1;                  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND ( dm = 803 OR dm = 804 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r18=$r18+$polozka->kc; }
$i=$i+1;                  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dm = 130 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r19=$r19+$polozka->kc; }
$i=$i+1;                  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND dm = 9999";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r20=$r20+$polozka->kc; }
$i=$i+1;                  }

//zapis do statistiky
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_praca204 SET ".
" mod5r01='$r01', mod5r02='$r01', mod5r06='$r01k', mod5r07='$r03', mod5r13=mod5r06, mod5r10='$r07', mod5r11='$r08', mod5r12='$r09',".
" mod5r15='$r10', mod5r16='$r11', mod5r17='$r12', mod5r18='$r13', mod5r19='$r14', mod5r20='$r15', mod5r08='$skrat',".
" mod5r21='$r16', mod5r22='$r17', mod5r23='$r19', mod5r24='$r18', mod5r25='$r20',".
" mod5r99=mod5r01+mod5r02+mod5r06+mod5r07+mod5r08+mod5r10,".
" mod5r99=mod5r99+mod5r11+mod5r12+mod5r13+mod5r14+mod5r15+mod5r16+mod5r17+mod5r18+mod5r19+mod5r20+mod5r22+mod5r23+mod5r24+mod5r25".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");
//echo $uprtxt;
//exit;

$vsql = 'DROP TABLE F'.$kli_vxcf.'_statprac';
//$vytvor = mysql_query("$vsql");
?>

<script type="text/javascript">
 window.open('../mzdy/stat_praca204.php?copern=101&drupoh=1&page=1&strana=2', '_self')
</script>
<?php
}
//koniec copern=200 nacitaj statistiku z miezd


//zapis upravene udaje
if ( $copern == 103 )
     {
//$cinnost = strip_tags($_REQUEST['cinnost']);
$mod5r01 = strip_tags($_REQUEST['mod5r01']);
$mod5r02 = strip_tags($_REQUEST['mod5r02']);
$mod5r03 = strip_tags($_REQUEST['mod5r03']);
$mod5r04 = strip_tags($_REQUEST['mod5r04']);
$mod5r05 = strip_tags($_REQUEST['mod5r05']);
$mod5r06 = strip_tags($_REQUEST['mod5r06']);
$mod5r07 = strip_tags($_REQUEST['mod5r07']);
$mod5r08 = strip_tags($_REQUEST['mod5r08']);
$mod5r09 = strip_tags($_REQUEST['mod5r09']);
$mod5r10 = strip_tags($_REQUEST['mod5r10']);
$mod5r11 = strip_tags($_REQUEST['mod5r11']);
$mod5r12 = strip_tags($_REQUEST['mod5r12']);
$mod5r13 = strip_tags($_REQUEST['mod5r13']);
$mod5r14 = strip_tags($_REQUEST['mod5r14']);
$mod5r15 = strip_tags($_REQUEST['mod5r15']);
$mod5r16 = strip_tags($_REQUEST['mod5r16']);
$mod5r17 = strip_tags($_REQUEST['mod5r17']);
$mod5r18 = strip_tags($_REQUEST['mod5r18']);
$mod5r19 = strip_tags($_REQUEST['mod5r19']);
$mod5r20 = strip_tags($_REQUEST['mod5r20']);
$mod5r21 = strip_tags($_REQUEST['mod5r21']);
$mod5r22 = strip_tags($_REQUEST['mod5r22']);
$mod5r23 = strip_tags($_REQUEST['mod5r23']);
$mod5r24 = strip_tags($_REQUEST['mod5r24']);
$mod5r25 = strip_tags($_REQUEST['mod5r25']);
$mod5r99 = strip_tags($_REQUEST['mod5r99']);
$mod2r01 = strip_tags($_REQUEST['mod2r01']);
$mod2r02 = strip_tags($_REQUEST['mod2r02']);
$odoslane = strip_tags($_REQUEST['odoslane']);
$odoslane_sql=SqlDatum($odoslane);

$uprav="NO";

if ( $strana == 1 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_praca204 SET ".
" odoslane='$odoslane_sql' ".
" WHERE ico >= 0";
                    }
if ( $strana == 2 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_praca204 SET ".
" mod2r01='$mod2r01', mod2r02='$mod2r02', ".
" mod5r01='$mod5r01',mod5r02='$mod5r02',mod5r03='$mod5r03',mod5r04='$mod5r04',mod5r05='$mod5r05',  ".
" mod5r06='$mod5r06',mod5r07='$mod5r07',mod5r08='$mod5r08',mod5r09='$mod5r09',mod5r10='$mod5r10', mod5r25='$mod5r25',  ".
" mod5r11='$mod5r11',mod5r12='$mod5r12',mod5r13='$mod5r13',mod5r14='$mod5r14',mod5r15='$mod5r15', mod5r23='$mod5r23', mod5r24='$mod5r24',  ".
" mod5r16='$mod5r16',mod5r17='$mod5r17',mod5r18='$mod5r18',mod5r19='$mod5r19',mod5r20='$mod5r20', mod5r21='$mod5r21', mod5r22='$mod5r22',  ".
" mod5r99=mod5r01+mod5r02+mod5r06+mod5r07+mod5r08+mod5r10,".
" mod5r99=mod5r99+mod5r11+mod5r12+mod5r13+mod5r14+mod5r15+mod5r16+mod5r17+mod5r18+mod5r19+mod5r20+mod5r22+mod5r23+mod5r24+mod5r25".
" WHERE ico >= 0";
                   }

//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
$copern=102;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN…" ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }
//koniec zapisu upravenych udajov

//nacitaj udaje
if ( $copern >= 1 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_statistika_praca204 WHERE ico >= 0";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
$mod5r01 = $fir_riadok->mod5r01;
$mod5r02 = $fir_riadok->mod5r02;
$mod5r03 = $fir_riadok->mod5r03;
$mod5r04 = $fir_riadok->mod5r04;
$mod5r05 = $fir_riadok->mod5r05;
$mod5r06 = $fir_riadok->mod5r06;
$mod5r07 = $fir_riadok->mod5r07;
$mod5r08 = $fir_riadok->mod5r08;
$mod5r09 = $fir_riadok->mod5r09;
$mod5r10 = $fir_riadok->mod5r10;
$mod5r11 = $fir_riadok->mod5r11;
$mod5r12 = $fir_riadok->mod5r12;
$mod5r13 = $fir_riadok->mod5r13;
$mod5r14 = $fir_riadok->mod5r14;
$mod5r15 = $fir_riadok->mod5r15;
$mod5r16 = $fir_riadok->mod5r16;
$mod5r17 = $fir_riadok->mod5r17;
$mod5r18 = $fir_riadok->mod5r18;
$mod5r19 = $fir_riadok->mod5r19;
$mod5r20 = $fir_riadok->mod5r20;
$mod5r99 = $fir_riadok->mod5r99;
$mod5r21 = $fir_riadok->mod5r21;
$mod5r22 = $fir_riadok->mod5r22;
$mod5r23 = $fir_riadok->mod5r23;
$mod5r24 = $fir_riadok->mod5r24;
$mod5r25 = $fir_riadok->mod5r25;
$odoslane_sk = SkDatum($fir_riadok->odoslane);
$mod2r01 = $fir_riadok->mod2r01;
$mod2r02 = $fir_riadok->mod2r02;
mysql_free_result($fir_vysledok);
     }
//koniec nacitania
?>

<?php
//kod okresu z treximy
$okres="";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_treximafir ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $okres=$riaddok->uzemie;
  }

//6-miestne ico
$fir_ficox=$fir_fico; if ( $fir_ficox < 999999 ) { $fir_ficox="00".$fir_ficox; }


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - v˝kaz Pr·ca 2-04</title>
<style type="text/css">
img.btn-row-tool {
  width: 18px;
  height: 18px;
}
form input[type=text] {
  position: absolute;
  height: 18px;
  line-height: 18px;
  padding-left: 4px;
  border: 1px solid #39f;
  font-size: 14px;
}
</style>

<script language="JavaScript" src="../js/cookies.js"></script>
<script type="text/javascript">
<?php
//uprava
  if ( $copern == 102 )
  {
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
   document.formv1.odoslane.value = '<?php echo "$odoslane_sk";?>';
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
   document.formv1.mod5r01.value = '<?php echo "$mod5r01";?>';
   document.formv1.mod5r02.value = '<?php echo "$mod5r02";?>';
   document.formv1.mod5r06.value = '<?php echo "$mod5r06";?>';
   document.formv1.mod5r07.value = '<?php echo "$mod5r07";?>';
   document.formv1.mod5r08.value = '<?php echo "$mod5r08";?>';
   document.formv1.mod5r10.value = '<?php echo "$mod5r10";?>';
   document.formv1.mod5r11.value = '<?php echo "$mod5r11";?>';
   document.formv1.mod5r12.value = '<?php echo "$mod5r12";?>';
   document.formv1.mod5r13.value = '<?php echo "$mod5r13";?>';
   document.formv1.mod5r14.value = '<?php echo "$mod5r14";?>';
   document.formv1.mod5r15.value = '<?php echo "$mod5r15";?>';
   document.formv1.mod5r16.value = '<?php echo "$mod5r16";?>';
   document.formv1.mod5r17.value = '<?php echo "$mod5r17";?>';
   document.formv1.mod5r18.value = '<?php echo "$mod5r18";?>';
   document.formv1.mod5r19.value = '<?php echo "$mod5r19";?>';
   document.formv1.mod5r20.value = '<?php echo "$mod5r20";?>';
   document.formv1.mod5r22.value = '<?php echo "$mod5r22";?>';
   document.formv1.mod5r23.value = '<?php echo "$mod5r23";?>';
   document.formv1.mod5r24.value = '<?php echo "$mod5r24";?>';
   document.formv1.mod5r25.value = '<?php echo "$mod5r25";?>';
   document.formv1.mod5r99.value = '<?php echo "$mod5r99";?>';
   document.formv1.mod2r01.value = '<?php echo "$mod2r01";?>';
   document.formv1.mod2r02.value = '<?php echo "$mod2r02";?>';
<?php                     } ?>
  }
<?php
//koniec uprava
  }
?>

<?php if ( $copern != 2 AND $copern != 102 ) { ?>
  function ObnovUI()
  {
  }
<?php                                        } ?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function MetodVypln()
  {
   window.open('<?php echo $jpg_cesta; ?>_metodika.pdf',
'_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
  function TlacVykaz()
  {
   window.open('../mzdy/stat_praca204.php?copern=11&drupoh=1&page=1&typ=PDF&strana=9999',
'_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes');
  }
  function UdajeFirma()
  {
   window.open('../mzdy/trexima.php?cislo_oc=1&copern=1&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0',
'_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMzdy()
  {
   window.open('../mzdy/stat_praca204.php?copern=200&drupoh=1&page=1&typ=PDF&cstat=1304&vyb_ume=<?php echo $vyb_umk; ?>&strana=<?php echo $strana; ?>', '_self');
  }
</script>
</HEAD>
<BODY onload="ObnovUI();">
<?php
//uprav udaje
if ( $copern == 102 )
     {
?>
<div id="wrap-heading">
 <table id="heading">
 <tr>
  <td class="ilogin">EuroSecom</td>
  <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
 </tr>
 <tr>
  <td class="header">ätvrùroËn˝ v˝kaz o pr·ci</td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();" title="MetodickÈ vysvetlivky k obsahu v˝kazu" class="btn-form-tool">
    <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajMzdy();" title="NaËÌtaù ˙daje z miezd" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="stat_praca204.php?copern=103&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
$source="stat_praca204.php?cislo_oc=".$cislo_oc."";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>


<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str1.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 1.strana 240kB">
<span class="text-echo" style="top:225px; left:480px; font-size:24px; letter-spacing:0.02em;"><?php echo $kli_vrok; ?></span>
<span class="text-echo" style="top:348px; left:247px; font-size:18px; letter-spacing:36px;"><?php echo $kli_vrokx; ?></span>
<span class="text-echo" style="top:348px; left:338px; font-size:18px; letter-spacing:34px;"><?php echo $mesiac; ?></span>
<span class="text-echo" style="top:348px; left:429px; font-size:18px; letter-spacing:37px;"><?php echo $fir_ficox; ?></span>
<!-- ORGANIZACIA -->
<span class="text-echo" style="top:1061px; left:55px; line-height: 20px;"><?php echo "$fir_fnaz<br>$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc"; ?></span>
<span class="text-echo" style="top:1070px; left:806px;"><?php echo $okres; ?></span>
<img src="../obr/ikony/pencil_blue_icon.png" onclick="StatUdajeFirma();" title="Nastaviù kÛd okresu" class="btn-row-tool" style="top:1068px; left:839px;">
<!-- Vyplnil -->
<span class="text-echo" style="top:1138px; left:55px;"><?php echo $fir_mzdt05; ?></span>
<span class="text-echo" style="width:499px; top:1156px; left:390px;"><?php echo $fir_mzdt04; ?></span>
<span class="text-echo" style="width:499px; top:1202px; left:55px;"><?php echo $fir_fem1; ?></span>
<input type="text" name="odoslane" id="odoslane" onkeyup="CiarkaNaBodku(this);" style="width:90px; top:1198px; left:390px;"/>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str2.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 2.strana 216kB">

<!-- modul 100164 -->
<?php $fir_sknacex=str_replace(".","",$fir_sknace); ?>
<span class="text-echo" style="top:199px; left:770px;"><?php echo $fir_sknacex; ?></span>
<span class="text-echo" style="top:226px; left:778px;"><?php echo $okres; ?></span>
 <img src="../obr/ikony/pencil_blue_icon.png" onclick="UdajeFirma();" title="Nastaviù kÛd okresu" class="btn-row-tool" style="top:223px; left:810px;">

<!-- modul 2 -->
<input type="text" name="mod2r01" id="mod2r01" style="width:100px; top:400px; left:740px;"/>
<input type="text" name="mod2r02" id="mod2r02" style="width:100px; top:436px; left:740px;"/>

<!-- modul 5 -->
<input type="text" name="mod5r01" id="mod5r01" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:639px; left:680px;"/>
<input type="text" name="mod5r02" id="mod5r02" style="width:100px; top:665px; left:680px;"/>
<input type="text" name="mod5r06" id="mod5r06" style="width:100px; top:696px; left:680px;"/>
<input type="text" name="mod5r07" id="mod5r07" style="width:100px; top:728px; left:680px;"/>
<input type="text" name="mod5r08" id="mod5r08" style="width:100px; top:759px; left:680px;"/>
<input type="text" name="mod5r10" id="mod5r10" style="width:100px; top:790px; left:680px;"/>
<input type="text" name="mod5r11" id="mod5r11" style="width:100px; top:822px; left:680px;"/>
<input type="text" name="mod5r12" id="mod5r12" style="width:100px; top:858px; left:680px;"/>
<input type="text" name="mod5r13" id="mod5r13" style="width:100px; top:889px; left:680px;"/>
<input type="text" name="mod5r14" id="mod5r14" style="width:100px; top:915px; left:680px;"/>
<input type="text" name="mod5r15" id="mod5r15" style="width:100px; top:941px; left:680px;"/>
<input type="text" name="mod5r16" id="mod5r16" style="width:100px; top:967px; left:680px;"/>
<input type="text" name="mod5r17" id="mod5r17" style="width:100px; top:993px; left:680px;"/>
<input type="text" name="mod5r18" id="mod5r18" style="width:100px; top:1019px; left:680px;"/>
<input type="text" name="mod5r19" id="mod5r19" style="width:100px; top:1045px; left:680px;"/>
<input type="text" name="mod5r20" id="mod5r20" style="width:100px; top:1076px; left:680px;"/>
<input type="text" name="mod5r22" id="mod5r22" style="width:100px; top:1112px; left:680px;"/>
<input type="text" name="mod5r23" id="mod5r23" style="width:100px; top:1143px; left:680px;"/>
<input type="text" name="mod5r24" id="mod5r24" style="width:100px; top:1170px; left:680px;"/>
<input type="text" name="mod5r25" id="mod5r25" style="width:100px; top:1201px; left:680px;"/>
<input type="text" name="mod5r99" id="mod5r99" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1232px; left:680px;"/>
<?php                                        } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>

</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
     }
//koniec uprav
?>


<?php
/////////////////////////////////////////////////VYTLAC VYKAZ
if ( $copern == 11 )
{
if ( File_Exists("../tmp/statistika.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/statistika.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "UPDATE F$kli_vxcf"."_statistika_praca204 SET psys=$stvrtrok ";
$sql = mysql_query("$sqltt");
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_praca204 WHERE ico >= 0 "."";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str1.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);
//za rok
$pdf->SetFont('arial','',16);
$pdf->Cell(190,35," ","$rmc1",1,"L");
$pdf->Cell(95,6," ","$rmc1",0,"L");$pdf->Cell(16,8,"$kli_vrok","$rmc",1,"C");
$pdf->SetFont('arial','',12);

//rok
$A=substr($kli_vrokx,0,1);
$B=substr($kli_vrokx,1,1);
$pdf->Cell(190,19," ","$rmc1",1,"L");
$pdf->Cell(41,6," ","$rmc1",0,"L");$pdf->Cell(10,8,"$A","$rmc",0,"C");$pdf->Cell(10,8,"$B","$rmc",0,"C");
//mesiac
$A=substr($mesiac,0,1);
$B=substr($mesiac,1,1);
$pdf->Cell(10,8,"$A","$rmc",0,"C");$pdf->Cell(10,8,"$B","$rmc",0,"C");
//ico
$fir_ficx=$fir_fico;
$cfico=1*$fir_fico;
if ( $cfico < 999999 ) $fir_ficx="00".$fir_fico;
$A=substr($fir_ficx,0,1);
$B=substr($fir_ficx,1,1);
$C=substr($fir_ficx,2,1);
$D=substr($fir_ficx,3,1);
$E=substr($fir_ficx,4,1);
$F=substr($fir_ficx,5,1);
$G=substr($fir_ficx,6,1);
$H=substr($fir_ficx,7,1);
$pdf->Cell(10,8,"$A","$rmc",0,"C");$pdf->Cell(10,8,"$B","$rmc",0,"C");
$pdf->Cell(11,8,"$C","$rmc",0,"C");$pdf->Cell(10,8,"$D","$rmc",0,"C");
$pdf->Cell(10,8,"$E","$rmc",0,"C");$pdf->Cell(11,8,"$F","$rmc",0,"C");
$pdf->Cell(10,8,"$G","$rmc",0,"C");$pdf->Cell(10,8,"$H","$rmc",1,"C");

//ORGANIZACIA
$pdf->Cell(190,157," ","$rmc1",1,"L");
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(153,4,"$fir_fnaz","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(34,4,"$okres","$rmc",1,"C");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(153,6,"$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc","$rmc",1,"L");

//VYPLNIL
$pdf->Cell(195,7," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(70,5,"$fir_mzdt05","$rmc",0,"L");
$pdf->Cell(4,5," ","$rmc1",0,"L");$pdf->Cell(43,13,"$fir_mzdt04","$rmc",1,"L");
$pdf->Cell(195,1," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(72,6,"$fir_fem1","$rmc",0,"L");
//odoslane
$pdf->Cell(2,5," ","$rmc1",0,"L");$pdf->Cell(43,6,"$odoslane_sk","$rmc",1,"L");
                                       }

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str2.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

$mod2r01=$hlavicka->mod2r01;
if ( $mod2r01 == 0 ) $mod2r01="";
$mod2r02=$hlavicka->mod2r02;
if ( $mod2r02 == 0 ) $mod2r02="";

$mod5r01=$hlavicka->mod5r01;
if ( $hlavicka->mod5r01 == 0 ) $mod5r01="";
$mod5r02=$hlavicka->mod5r02;
if ( $hlavicka->mod5r02 == 0 ) $mod5r02="";
$mod5r03=$hlavicka->mod5r03;
if ( $hlavicka->mod5r03 == 0 ) $mod5r03="";
$mod5r04=$hlavicka->mod5r04;
if ( $hlavicka->mod5r04 == 0 ) $mod5r04="";
$mod5r05=$hlavicka->mod5r05;
if ( $hlavicka->mod5r05 == 0 ) $mod5r05="";
$mod5r06=$hlavicka->mod5r06;
if ( $hlavicka->mod5r06 == 0 ) $mod5r06="";
$mod5r07=$hlavicka->mod5r07;
if ( $hlavicka->mod5r07 == 0 ) $mod5r07="";
$mod5r08=$hlavicka->mod5r08;
if ( $hlavicka->mod5r08 == 0 ) $mod5r08="";
$mod5r10=$hlavicka->mod5r10;
if ( $hlavicka->mod5r10 == 0 ) $mod5r10="";
$mod5r11=$hlavicka->mod5r11;
if ( $hlavicka->mod5r11 == 0 ) $mod5r11="";
$mod5r12=$hlavicka->mod5r12;
if ( $hlavicka->mod5r12 == 0 ) $mod5r12="";
$mod5r13=$hlavicka->mod5r13;
if ( $hlavicka->mod5r13 == 0 ) $mod5r13="";
$mod5r14=$hlavicka->mod5r14;
if ( $hlavicka->mod5r14 == 0 ) $mod5r14="";
$mod5r15=$hlavicka->mod5r15;
if ( $hlavicka->mod5r15 == 0 ) $mod5r15="";
$mod5r16=$hlavicka->mod5r16;
if ( $hlavicka->mod5r16 == 0 ) $mod5r16="";
$mod5r17=$hlavicka->mod5r17;
if ( $hlavicka->mod5r17 == 0 ) $mod5r17="";
$mod5r18=$hlavicka->mod5r18;
if ( $hlavicka->mod5r18 == 0 ) $mod5r18="";
$mod5r19=$hlavicka->mod5r19;
if ( $hlavicka->mod5r19 == 0 ) $mod5r19="";
$mod5r20=$hlavicka->mod5r20;
if ( $hlavicka->mod5r20 == 0 ) $mod5r20="";
$mod5r22=$hlavicka->mod5r22;
if ( $hlavicka->mod5r22 == 0 ) $mod5r22="";
$mod5r23=$hlavicka->mod5r23;
if ( $hlavicka->mod5r23 == 0 ) $mod5r23="";
$mod5r24=$hlavicka->mod5r24;
if ( $hlavicka->mod5r24 == 0 ) $mod5r24="";
$mod5r25=$hlavicka->mod5r25;
if ( $hlavicka->mod5r25 == 0 ) $mod5r25="";
$mod5r99=$hlavicka->mod5r99;
if ( $hlavicka->mod5r99 == 0 ) $mod5r99="";

//modul 100164
$pdf->Cell(195,29," ","$rmc1",1,"L");
$sknace= str_replace(".", "", $fir_sknace);
$pdf->Cell(139,5," ","$rmc1",0,"C");$pdf->Cell(50,6,"$sknace","$rmc",1,"C");
$pdf->Cell(139,5," ","$rmc1",0,"C");$pdf->Cell(50,6,"$okres","$rmc",1,"C");

//modul 2
$pdf->Cell(195,34," ","$rmc1",1,"L");
$pdf->Cell(139,5," ","$rmc1",0,"C");$pdf->Cell(50,8,"$mod2r01","$rmc",1,"C");
$pdf->Cell(139,5," ","$rmc1",0,"C");$pdf->Cell(50,9,"$mod2r02","$rmc",1,"C");

//modul 5
$pdf->Cell(190,38," ","$rmc1",1,"L");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,6,"$mod5r01","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,6,"$mod5r02","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,8,"$mod5r06","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,7,"$mod5r07","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,8,"$mod5r08","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,6,"$mod5r10","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,8,"$mod5r11","$rmc",1,"R");
$pdf->Cell(130,8," ","$rmc1",0,"L");$pdf->Cell(44,8,"$mod5r12","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,7,"$mod5r13","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,6,"$mod5r14","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,6,"$mod5r15","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,6,"$mod5r16","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,6,"$mod5r17","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,5,"$mod5r18","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,6,"$mod5r19","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,8,"$mod5r20","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,9,"$mod5r22","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,6,"$mod5r23","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,6,"$mod5r24","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,8,"$mod5r25","$rmc",1,"R");
$pdf->Cell(130,6," ","$rmc1",0,"L");$pdf->Cell(44,6,"$mod5r99","$rmc",1,"R");
                                       }
}
$i = $i + 1;
  }
$pdf->Output("../tmp/statistika.$kli_uzid.pdf");

//archiv vykazu
$sql = "SELECT psys FROM F$kli_vxcf"."_statistika_praca204arch ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_praca204arch SELECT * FROM F".$kli_vxcf."_statistika_praca204 WHERE psys=$stvrtrok";
$vysledek = mysql_query("$sql");
}
$sql = "DELETE FROM F".$kli_vxcf."_statistika_praca204arch WHERE psys=$stvrtrok";
$vysledek = mysql_query("$sql");
$sql = "INSERT INTO F".$kli_vxcf."_statistika_praca204arch SELECT * FROM F".$kli_vxcf."_statistika_praca204 WHERE psys=$stvrtrok";
$vysledek = mysql_query("$sql");
?>
<script type="text/javascript">
 var okno = window.open("../tmp/statistika.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php
}
//koniec vytlac

$cislista = include("mzd_lista_norm.php");
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>