<!doctype html>
<HTML>
<?php
//RZ 2016
do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if (!isset($tis)) $tis = 0;

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

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

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");

$cislo_oc = $_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) { $strana = 1; }

$vsetkyprepocty=0;

//.jpg podklad
$jpg_cesta="../dokumenty/dan_z_prijmov2016/dan_zo_zavislej2016/rz/rzfo_v16";
$jpg_popis="tlaËivo RoËnÈ z˙Ëtovanie preddavkov na daÚ z prÌjmov FO zo z·vislej Ëinnosti pre rok ".$kli_vrok;

$sqtoz = "DELETE FROM F513_mzdrocnedane WHERE r00 > 99999999.98 ";
//$oznac = mysql_query("$sqtoz");

//kontrola ci nie je dva krat ak ano znovu napocitaj
$zupravy=0;
$tvpol=0;
if ( $copern == 10 OR $copern == 20 )
     {
$tovtt = "SELECT * FROM F$kli_vxcf"."_mzdrocnedane WHERE oc = $cislo_oc";
$tov = mysql_query("$tovtt");
if ( $tov ) { $tvpol = mysql_num_rows($tov); }

if ( $tvpol > 1 AND $copern == 20 ) { $copern=26; $zupravy=1; }
if ( $tvpol > 1 AND $copern == 10 ) { $copern=26; }
     }
//koniec kontroly

//$zablokovane=1;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("Potvrdenie bude pripravenÈ v priebehu janu·ra 2017. Aktu·lne info n·jdete na vstupnej str·nke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

//znovu nacitaj
if ( $copern == 26 )
     {
//echo "citam";
$nasielvyplnene=0;

$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdrocnedane WHERE oc = $cislo_oc AND ( r00z2 != 0 OR r00a2 != 0 OR r04a2 != 0 OR r04b != 0 ".
" OR r00b2 != 0 OR r00c2 != 0 OR r11b != 0 OR r14b != 0  ) ORDER BY r00z1 ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $nasielvyplnene=1;

  $riaddok=mysql_fetch_object($sqldok);
  $xr00z2=1*$riaddok->r00z2;
  $xr00a2=1*$riaddok->r00a2;
  $xr00b2=1*$riaddok->r00b2;
  $xr00c2=1*$riaddok->r00c2;
  $xr02=1*$riaddok->r02;
  $xr04a2=1*$riaddok->r04a2;
  $xr04b=1*$riaddok->r04b;
  $xr11b=1*$riaddok->r11b;
  $xr14b=1*$riaddok->r14b;
  $xvyk=1*$riaddok->vyk;
  }
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdrocnedane WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");
$copern=10;
if ( $zupravy == 1 ) $copern=20;
$subor=1;
$vsetkyprepocty=1;
     }
//koniec znovu nacitaj

//zapis do mzdy
if ( $copern == 27 )
     {
$dmx = 1*$_REQUEST['dmx'];
$umx = $_REQUEST['umx'];
$fix = 1*$_REQUEST['fix'];

if ( $umx == '1.2011' ) { $umx = "1.2017"; }
if ( $umx == '1.2012' ) { $umx = "1.2017"; }
if ( $umx == '1.2013' ) { $umx = "1.2017"; }
if ( $umx == '1.2014' ) { $umx = "1.2017"; }
if ( $umx == '2.2011' ) { $umx = "2.2017"; }
if ( $umx == '2.2012' ) { $umx = "2.2017"; }
if ( $umx == '2.2013' ) { $umx = "2.2017"; }
if ( $umx == '2.2014' ) { $umx = "2.2017"; }
if ( $umx == '3.2011' ) { $umx = "3.2017"; }
if ( $umx == '3.2012' ) { $umx = "3.2017"; }
if ( $umx == '3.2013' ) { $umx = "3.2017"; }
if ( $umx == '3.2014' ) { $umx = "3.2017"; }
if ( $umx == '1.2015' ) { $umx = "1.2017"; }
if ( $umx == '2.2015' ) { $umx = "2.2017"; }
if ( $umx == '3.2015' ) { $umx = "3.2017"; }
if ( $umx == '1.2016' ) { $umx = "1.2017"; }
if ( $umx == '2.2016' ) { $umx = "2.2017"; }
if ( $umx == '3.2016' ) { $umx = "3.2017"; }

$ned = 1*$_REQUEST['ned'];
$pre = 1*$_REQUEST['pre'];
$nedbon = 1*$_REQUEST['nedbon'];
$prebon = 1*$_REQUEST['prebon'];
$zampre = 1*$_REQUEST['zampre'];
$zamprex = 1*$_REQUEST['zamprex'];

//$h_kc=$ned-$pre-($nedbon-$prebon)+$zampre;
$h_kc=$ned-$pre;
$h_kcbon=$nedbon-$prebon;
$h_kczam=-1*($zampre-$zamprex);

if ( $dmx == 903 AND $umx > 0 AND $fix > 0 )
     {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdrocnedaneprenos SET dmx='$dmx', umx='$umx', fix='$fix' ";
$upravene = mysql_query("$uprtxt"); 
$databaza="";

$dtb2 = include("../cis/oddel_dtbz3.php");

$jetamostre=0;
$sqlfir = "SELECT * FROM ".$databaza."F$fix"."_mzdzalkun WHERE ume = '$umx' ";
$sql = mysql_query("$sqlfir");
$pol = 1*mysql_num_rows($sql);
if( $pol > 0 ) { $jetamostre=1; }

if ( $jetamostre == 1 )
     {
?>
<script type="text/javascript">
alert ("NemÙûete pren·öaù do <?php echo $umx; ?>. Uû bolo ostrÈ spracovanie za mesiac <?php echo $umx; ?>.");
window.close();
</script>
<?php
exit;
     }

$uprtxt = "DELETE FROM ".$databaza."F$fix"."_mzdmes WHERE oc = $cislo_oc AND dm = $dmx ";
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
$uprtxt = "DELETE FROM ".$databaza."F$fix"."_mzdmes WHERE oc = $cislo_oc AND dm = 952 ";
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
$uprtxt = "DELETE FROM ".$databaza."F$fix"."_mzdmes WHERE oc = $cislo_oc AND dm = 953 ";
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

$dat_sk="01.".$umx."";
$dat_sql=SqlDatum($dat_sk);

$sqty = "INSERT INTO ".$databaza."F$fix"."_mzdmes ( dok,oc,dat,ume,str,dm,dp,dk,dni,stj,zak,hod,mnz,saz,kc,id )".
" VALUES (1, '$cislo_oc', '$dat_sql', '$umx', '0', '$dmx', '0000-00-00', '0000-00-00', '0', '0', '0',".
" '0', '0', '0', '$h_kc', '$kli_uzid' );"; 
//echo $sqty;
if ( $h_kc != 0 ) { $ulozene = mysql_query("$sqty");  }

$sqty = "INSERT INTO ".$databaza."F$fix"."_mzdmes ( dok,oc,dat,ume,str,dm,dp,dk,dni,stj,zak,hod,mnz,saz,kc,id )".
" VALUES (1, '$cislo_oc', '$dat_sql', '$umx', '0', '952', '0000-00-00', '0000-00-00', '0', '0', '0',".
" '0', '0', '0', '$h_kcbon', '$kli_uzid' );"; 
//echo $sqty;
if ( $h_kcbon != 0 ) { $ulozene = mysql_query("$sqty");  }

$sqty = "INSERT INTO ".$databaza."F$fix"."_mzdmes ( dok,oc,dat,ume,str,dm,dp,dk,dni,stj,zak,hod,mnz,saz,kc,id )".
" VALUES (1, '$cislo_oc', '$dat_sql', '$umx', '0', '953', '0000-00-00', '0000-00-00', '0', '0', '0',".
" '0', '0', '0', '$h_kczam', '$kli_uzid' );"; 
//echo $sqty;
if ( $zampre > 0 ) { $ulozene = mysql_query("$sqty"); }
     }
$copern=20;
     }
//koniec zapis do mzdy

//zapis upravene udaje
if ( $copern == 23 )
     {
$vyk = 1*$_REQUEST['vyk'];
//$r00 = 1*$_REQUEST['r00'];
$r00z1 = 1*$_REQUEST['r00z1'];
$r00z2 = 1*$_REQUEST['r00z2'];
//$r00d = 1*$_REQUEST['r00d'];
$r00d1 = 1*$_REQUEST['r00d1'];
$r00d2 = 1*$_REQUEST['r00d2'];
//$r00a = 1*$_REQUEST['r00a'];
$r00a1 = 1*$_REQUEST['r00a1'];
$r00a2 = 1*$_REQUEST['r00a2'];
//$r00b = 1*$_REQUEST['r00b'];
$r00b1 = 1*$_REQUEST['r00b1'];
$r00b2 = 1*$_REQUEST['r00b2'];
//$r00c = 1*$_REQUEST['r00c'];
$r00c1 = 1*$_REQUEST['r00c1'];
$r00c2 = 1*$_REQUEST['r00c2'];
//$r01 = 1*$_REQUEST['r01'];
$r02 = 1*$_REQUEST['r02'];
//$r03 = 1*$_REQUEST['r03'];
$r04 = 1*$_REQUEST['r04'];
//$r04a = 1*$_REQUEST['r04a'];
$r04a1 = 1*$_REQUEST['r04a1'];
$r04a2 = 1*$_REQUEST['r04a2'];
$r04b = 1*$_REQUEST['r04b'];
$r04c = 1*$_REQUEST['r04c'];
//$r04c1 = strip_tags($_REQUEST['r04c1']);
//$r04c2 = strip_tags($_REQUEST['r04c2']);
$r04d = strip_tags($_REQUEST['r04d']);
//$r04e = strip_tags($_REQUEST['r04e']);
//$r04f = strip_tags($_REQUEST['r04f']);
//$r04x = 1*$_REQUEST['r04x'];
//$r05 = 1*$_REQUEST['r05'];
$r06 = 1*$_REQUEST['r06'];
$r07 = 1*$_REQUEST['r07'];
$r08 = 1*$_REQUEST['r08'];
if ( $r08 > 12 ) { $r08 = 12; }
$r09 = 1*$_REQUEST['r09'];
$r09a = 1*$_REQUEST['r09a'];
$r10 = 1*$_REQUEST['r10'];
//$r11 = 1*$_REQUEST['r11'];
$r11a = 1*$_REQUEST['r11a'];
$r11b = 1*$_REQUEST['r11b'];
$r12 = 1*$_REQUEST['r12'];
$r12a = 1*$_REQUEST['r12a'];
$r13 = 1*$_REQUEST['r13'];
//$r14 = 1*$_REQUEST['r14'];
$r14a = 1*$_REQUEST['r14a'];
$r14b = 1*$_REQUEST['r14b'];
$r15 = 1*$_REQUEST['r15'];
//$r15a = strip_tags($_REQUEST['r15a']);
//$r15b = strip_tags($_REQUEST['r15b']);
$r16 = 1*$_REQUEST['r16'];
$r17n = 1*$_REQUEST['r17n'];
$r17p = 1*$_REQUEST['r17p'];
$r18n = 1*$_REQUEST['r18n'];
$r18p = 1*$_REQUEST['r18p'];
$da21 = strip_tags($_REQUEST['da21']);
$da21sql=SqlDatum($da21);
$pozn = trim(strip_tags($_REQUEST['pozn']));
//$da2 = strip_tags($_REQUEST['da2']);
//$da2sql=SqlDatum($da2);

if ( $strana == 1 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdrocnedane SET ".
" vyk='$vyk', r00z1='$r00z1', r00z2='$r00z2', r00d1='$r00d1', r00d2='$r00d2', r00a1='$r00a1', r00a2='$r00a2', ".
" r00b1='$r00b1', r00b2='$r00b2', r00c1='$r00c1', r00c2='$r00c2', r02='$r02', ".
" r04='$r04', r04a1='$r04a1', r04a2='$r04a2', r04b='$r04b', r04c='$r04c', r04d='$r04d', r06='$r06', r07='$r07', r08='$r08', ".
" r09='$r09', r09a='$r09a', r10='$r10', r11a='$r11a', r11b='$r11b', r12='$r12', r12a='$r12a', r13='$r13', r14a='$r14a', r14b='$r14b', ".
" r15='$r15', r16='$r16', r17n='$r17n', r17p='$r17p', r18n='$r18n', r18p='$r18p', da21='$da21sql', pozn='$pozn' ".
" WHERE oc = $cislo_oc"; 
                    }

if ( $strana == 2 ) {
$sql = "ALTER TABLE F".$kli_vxcf."_mzdrocnedane2strana MODIFY oc int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
$vsql = "INSERT INTO F".$kli_vxcf."_mzdrocnedane2strana ( oc ) VALUES ( '$cislo_oc' )";
$vytvor = mysql_query("$vsql");

$da2str = strip_tags($_REQUEST['da2str']);
$da2strsql=SqlDatum($da2str);
$suma1 = 1*$_REQUEST['suma1'];
$zost1 = 1*$_REQUEST['zost1'];
$datm2 = strip_tags($_REQUEST['datm2']);
$datm2sql=SqlDatum($datm2);
$suma2 = 1*$_REQUEST['suma2'];
$zost2 = 1*$_REQUEST['zost2'];
$datm3 = strip_tags($_REQUEST['datm3']);
$datm3sql=SqlDatum($datm3);
$suma3 = 1*$_REQUEST['suma3'];
$zost3 = 1*$_REQUEST['zost3'];
$suma4 = 1*$_REQUEST['suma4'];
$zost4 = 1*$_REQUEST['zost4'];
$datm5 = strip_tags($_REQUEST['datm5']);
$datm5sql=SqlDatum($datm5);
$suma5 = 1*$_REQUEST['suma5'];
$zost5 = 1*$_REQUEST['zost5'];
$datm6 = strip_tags($_REQUEST['datm6']);
$datm6sql=SqlDatum($datm6);
$suma6 = 1*$_REQUEST['suma6'];
$zost6 = 1*$_REQUEST['zost6'];
$datm7 = strip_tags($_REQUEST['datm7']);
$datm7sql=SqlDatum($datm7);
$suma7 = 1*$_REQUEST['suma7'];
$zost7 = 1*$_REQUEST['zost7'];
$da2ked = strip_tags($_REQUEST['da2ked']);
$da2kedsql=SqlDatum($da2ked);

$uprtxt = "UPDATE F$kli_vxcf"."_mzdrocnedane2strana SET ".
" da2str='$da2strsql', suma1='$suma1', zost1='$zost1', datm2='$datm2sql', suma2='$suma2', zost2='$zost2', datm3='$datm3sql', suma3='$suma3', zost3='$zost3',".
" suma4='$suma4', zost4='$zost4', datm5='$datm5sql', suma5='$suma5', zost5='$zost5', datm6='$datm6sql', suma6='$suma6', zost6='$zost6',".
" datm7='$datm7sql', suma7='$suma7', zost7='$zost7', da2ked='$da2kedsql' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 3 ) {
$sql = "ALTER TABLE F".$kli_vxcf."_mzdrocnedane2strana MODIFY oc int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
$vsql = "INSERT INTO F".$kli_vxcf."_mzdrocnedane2strana ( oc ) VALUES ( '$cislo_oc' )";
$vytvor = mysql_query("$vsql");

$zp2hod = 1*$_REQUEST['zp2hod'];
$zp2dat = strip_tags($_REQUEST['zp2dat']);
$zp2datsql=SqlDatum($zp2dat);
$zp2dak = strip_tags($_REQUEST['zp2dak']);
$zp2daksql=SqlDatum($zp2dak);

$uprtxt = "UPDATE F$kli_vxcf"."_mzdrocnedane2strana SET ".
" zp2dat='$zp2datsql', zp2dak='$zp2daksql', zp2hod='$zp2hod' ".
" WHERE oc = $cislo_oc"; 
                    }
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");  

$nepoc = 1*$_REQUEST['nepoc'];
$vsetkyprepocty=1;
if ( $nepoc == 1 ) $vsetkyprepocty=0;

$copern=20;
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

//prac.subor a subor vytvorenych rocnych
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sql = "SELECT px4 FROM F".$kli_vxcf."_mzdrocnedane2strana";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdrocnedane2strana';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   da2str       DATE not null,
   suma1        DECIMAL(10,2) DEFAULT 0,
   zost1        DECIMAL(10,2) DEFAULT 0,
   datm2        DATE not null,
   suma2        DECIMAL(10,2) DEFAULT 0,
   zost2        DECIMAL(10,2) DEFAULT 0,
   datm3        DATE not null,
   suma3        DECIMAL(10,2) DEFAULT 0,
   zost3        DECIMAL(10,2) DEFAULT 0,
   suma4        DECIMAL(10,2) DEFAULT 0,
   zost4        DECIMAL(10,2) DEFAULT 0,
   datm5        DATE not null,
   suma5        DECIMAL(10,2) DEFAULT 0,
   zost5        DECIMAL(10,2) DEFAULT 0,
   datm6        DATE not null,
   suma6        DECIMAL(10,2) DEFAULT 0,
   zost6        DECIMAL(10,2) DEFAULT 0,
   datm7        DATE not null,
   suma7        DECIMAL(10,2) DEFAULT 0,
   zost7        DECIMAL(10,2) DEFAULT 0,
   da2ked       DATE not null,
   px4          DECIMAL(10,2) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdrocnedane2strana'.$sqlt;
$vytvor = mysql_query("$vsql");
}
$sql = "SELECT zp2hod FROM F$kli_vxcf"."_mzdrocnedane2strana ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnedane2strana ADD zp2hod DECIMAL(10,2) DEFAULT 0 AFTER da2ked";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnedane2strana ADD zp2dak DATE NOT NULL AFTER da2ked";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnedane2strana ADD zp2dat DATE NOT NULL AFTER da2ked";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT px4 FROM F".$kli_vxcf."_mzdrocnedane";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdrocnedane';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   vyk          DECIMAL(10,0) DEFAULT 0,
   r00          DECIMAL(10,2) DEFAULT 0,
   r00z1        DECIMAL(10,2) DEFAULT 0,
   r00z2        DECIMAL(10,2) DEFAULT 0,
   r00a         DECIMAL(10,2) DEFAULT 0,
   r00a1        DECIMAL(10,2) DEFAULT 0,
   r00a2        DECIMAL(10,2) DEFAULT 0,
   r00b         DECIMAL(10,2) DEFAULT 0,
   r00b1        DECIMAL(10,2) DEFAULT 0,
   r00b2        DECIMAL(10,2) DEFAULT 0,
   r00c         DECIMAL(10,2) DEFAULT 0,
   r00c1        DECIMAL(10,2) DEFAULT 0,
   r00c2        DECIMAL(10,2) DEFAULT 0,
   r01          DECIMAL(10,2) DEFAULT 0,
   r02          DECIMAL(10,2) DEFAULT 0,
   r03          DECIMAL(10,2) DEFAULT 0,
   konx1        DECIMAL(10,0) DEFAULT 0,
   r04          DECIMAL(10,2) DEFAULT 0,
   r04a         DECIMAL(10,2) DEFAULT 0,
   r04a1        DECIMAL(10,2) DEFAULT 0,
   r04a2        DECIMAL(10,2) DEFAULT 0,
   r04b         DECIMAL(10,2) DEFAULT 0,
   r04c         DECIMAL(10,2) DEFAULT 0,
   r04c1        DECIMAL(10,2) DEFAULT 0,
   r04c2        DECIMAL(10,2) DEFAULT 0,
   r04d         DECIMAL(10,2) DEFAULT 0,
   r04e         DECIMAL(10,2) DEFAULT 0,
   r04f         DECIMAL(10,2) DEFAULT 0,
   r04x         DECIMAL(10,2) DEFAULT 0,
   konx2        DECIMAL(10,0) DEFAULT 0,
   r05          DECIMAL(10,2) DEFAULT 0,
   r06          DECIMAL(10,2) DEFAULT 0,
   r07          DECIMAL(10,2) DEFAULT 0,
   r08          DECIMAL(10,0) DEFAULT 0,
   r09          DECIMAL(10,2) DEFAULT 0,
   r09a         DECIMAL(10,2) DEFAULT 0,
   r10          DECIMAL(10,2) DEFAULT 0,
   konx3        DECIMAL(10,0) DEFAULT 0,
   r11          DECIMAL(10,2) DEFAULT 0,
   r11a         DECIMAL(10,2) DEFAULT 0,
   r11b         DECIMAL(10,2) DEFAULT 0,
   r12          DECIMAL(10,2) DEFAULT 0,
   r12a         DECIMAL(10,2) DEFAULT 0,
   r13          DECIMAL(10,2) DEFAULT 0,
   r14          DECIMAL(10,2) DEFAULT 0,
   r14a         DECIMAL(10,2) DEFAULT 0,
   r14b         DECIMAL(10,2) DEFAULT 0,
   r15          DECIMAL(10,2) DEFAULT 0,
   r15a         DECIMAL(10,2) DEFAULT 0,
   r15b         DECIMAL(10,2) DEFAULT 0,
   r16          DECIMAL(10,2) DEFAULT 0,
   r17n         DECIMAL(10,2) DEFAULT 0,
   r17p         DECIMAL(10,2) DEFAULT 0,
   r18n         DECIMAL(10,2) DEFAULT 0,
   r18p         DECIMAL(10,2) DEFAULT 0,
   konx4        DECIMAL(10,0) DEFAULT 0,
   pozn         VARCHAR(80) NOT NULL,
   da2          DATE,
   da21         DATE,
   da22         DATE,
   da23         DATE,
   da24         DATE,
   da25         DATE,
   d11          DECIMAL(10,2) DEFAULT 0,
   d12          DECIMAL(10,2) DEFAULT 0,
   d13          DECIMAL(10,2) DEFAULT 0,
   d14          DECIMAL(10,2) DEFAULT 0,
   d15          DECIMAL(10,2) DEFAULT 0,
   d16          DECIMAL(10,2) DEFAULT 0,
   d17          DECIMAL(10,2) DEFAULT 0,
   z11          DECIMAL(10,2) DEFAULT 0,
   z12          DECIMAL(10,2) DEFAULT 0,
   z13          DECIMAL(10,2) DEFAULT 0,
   z14          DECIMAL(10,2) DEFAULT 0,
   z15          DECIMAL(10,2) DEFAULT 0,
   z16          DECIMAL(10,2) DEFAULT 0,
   z17          DECIMAL(10,2) DEFAULT 0,
   po6          DECIMAL(14,6) DEFAULT 0,
   px4          DECIMAL(10,2) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdrocnedane'.$sqlt;
$vytvor = mysql_query("$vsql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnedane ADD pozn VARCHAR(80) NOT NULL AFTER konx4";
//$vysledek = mysql_query("$sql");
}
$sql = "SELECT r00d FROM F$kli_vxcf"."_mzdrocnedane ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnedane ADD r00d2 DECIMAL(10,2) DEFAULT 0 AFTER r00c2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnedane ADD r00d1 DECIMAL(10,2) DEFAULT 0 AFTER r00c2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnedane ADD r00d DECIMAL(10,2) DEFAULT 0 AFTER r00c2";
$vysledek = mysql_query("$sql");
}
//koniec vytvorenie rocnedane

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzdrocnedane";
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzdrocnedane";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
//exit;

//vytvorenie uloz prenos 903
$sql = "SELECT px5 FROM F".$kli_vxcf."_mzdrocnedaneprenos";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdrocnedaneprenos';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   dmx          INT(7) DEFAULT 0,
   umx          DECIMAL(10,4) DEFAULT 0,
   fix          DECIMAL(10,0) DEFAULT 0,
   px5          DECIMAL(10,2) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdrocnedaneprenos'.$sqlt;
$vytvor = mysql_query("$vsql");

$vsql = "INSERT INTO F".$kli_vxcf."_mzdrocnedaneprenos ( dmx,umx,fix) VALUES ( '903','1.2017',0 )";
$vytvor = mysql_query("$vsql");

}
//koniec vytvorenie uloz prenos 903

$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_mzdrocnedane WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $jepotvrd=1;
  }
if ( $jepotvrd == 0 ) $subor=1;

//pre rocne vytvor pracovny subor
if ( $subor == 1 )
{
//zober z kun ak niesu data
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,".
"'','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00', ".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".
" FROM F$kli_vxcf"."_mzdkun".
" WHERE F$kli_vxcf"."_mzdkun.oc = $cislo_oc ".
"";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober data zo sum zaklady,odvody spocitane novy eurosecom
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,".
"0,(zdan_dnp+pdan_zn1),0,0,pdan_fnd,0,(ozam_np+ozam_sp+ozam_ip+ozam_pn),(ozam_np+ozam_sp+ozam_ip+ozam_pn),0,".
"(pdan_fnd-ozam_np-ozam_sp-ozam_ip-ozam_pn),(pdan_fnd-ozam_np-ozam_sp-ozam_ip-ozam_pn),0,0,0,0,0,0,0,".
"0,".
"0,0,pdan_dnv,0,0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,".
"'','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00', ".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,ume,0 ".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE F$kli_vxcf"."_mzdzalsum.oc = $cislo_oc ".
"";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober bonus mesacny z vy
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,-(kc),".
"0,".
"-(kc),-(kc),0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,".
"'','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00', ".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE F$kli_vxcf"."_mzdzalvy.oc = $cislo_oc AND dm = 902".
"";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober dan z prijmu 901 z vy
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,0,kc,0,0,0,0,0,0,0,0,0,".
"0,".
"'','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00', ".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE F$kli_vxcf"."_mzdzalvy.oc = $cislo_oc AND dm = 901".
"";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober dan zrazkova 951 z vy od 1.1.2011 uz nie je pre istotu ju pripocitam k 901ke
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,0,kc,0,0,0,0,0,0,0,0,0,".
"0,".
"'','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00', ".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE F$kli_vxcf"."_mzdzalvy.oc = $cislo_oc AND dm = 951".
"";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober doplatok ZP 954 z vy a pripocitaj k odvodom a poist.ZP
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,".
"0,0,0,0,kc,0,0,0,0,kc,kc,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,".
"'','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00', ".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE F$kli_vxcf"."_mzdzalvy.oc = $cislo_oc AND dm = 954 AND kc > 0".
"";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober preplatok ZP 954 z vy a pripocitaj k prijmu
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,".
"0,-(kc),0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,".
"'','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00', ".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE F$kli_vxcf"."_mzdzalvy.oc = $cislo_oc AND dm = 954 AND kc < 0 ".
"";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//sumarizuj za oc,ume
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,".
"sum(r00),sum(r00z1),sum(r00z2),sum(r00a),sum(r00a1),sum(r00a2),sum(r00b),sum(r00b1),sum(r00b2),sum(r00c),sum(r00c1),sum(r00c2),sum(r00d),sum(r00d1),sum(r00d2),".
"sum(r01),sum(r02),sum(r03),9,".
"sum(r04),sum(r04a),sum(r04a1),sum(r04a2),sum(r04b),sum(r04c),sum(r04c1),sum(r04c2),sum(r04d),sum(r04e),sum(r04f),sum(r04x),0,".
"sum(r05),sum(r06),sum(r07),sum(r08),sum(r09),sum(r09a),sum(r10),0,".
"sum(r11),sum(r11a),sum(r11b),".
"sum(r12),sum(r12a),sum(r13),sum(r14),sum(r14a),sum(r14b),sum(r15),sum(r15a),sum(r15b),sum(r16),sum(r17n),sum(r17p),sum(r18n),sum(r18p),0,'',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00', ".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" GROUP BY oc,po6".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl".$kli_uzid." SET r08=1  WHERE oc = $cislo_oc AND r00z1 > 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$dat_spr = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$dat_sprsql=SqlDatum($dat_spr);

//sumarizuj za oc
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,".
"sum(r00),sum(r00z1),sum(r00z2),sum(r00a),sum(r00a1),sum(r00a2),sum(r00b),sum(r00b1),sum(r00b2),sum(r00c),sum(r00c1),sum(r00c2),sum(r00d),sum(r00d1),sum(r00d2),".
"sum(r01),sum(r02),sum(r03),4,".
"sum(r04),sum(r04a),sum(r04a1),sum(r04a2),sum(r04b),sum(r04c),sum(r04c1),sum(r04c2),sum(r04d),sum(r04e),sum(r04f),sum(r04x),0,".
"sum(r05),sum(r06),sum(r07),sum(r08),sum(r09),sum(r09a),sum(r10),0,".
"sum(r11),sum(r11a),sum(r11b),".
"sum(r12),sum(r12a),sum(r13),sum(r14),sum(r14a),sum(r14b),sum(r15),sum(r15a),sum(r15b),sum(r16),sum(r17n),sum(r17p),sum(r18n),sum(r18p),0,'',".
"'0000-00-00','$dat_sprsql','0000-00-00','0000-00-00','0000-00-00','0000-00-00', ".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid." WHERE konx1 = 9 ".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx1 != 4";
$oznac = mysql_query("$sqtoz");

//ak dohoda r00d1=r00z1, r00d=r00
$akypom=1;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $cislo_oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $akypom=$riaddok->pom;
    }

$jedohoda=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpomer WHERE pm = $akypom AND pm_doh = 1 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $jedohoda=1;
    }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET r00d1=r00z1, r00d=r00 WHERE oc = $cislo_oc";
if( $jedohoda == 1 ) { $oznac = mysql_query("$sqtoz"); }



//uloz do rocnych
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdrocnedane WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdrocnedane".
" SELECT oc,0,".
"sum(r00),sum(r00z1),sum(r00z2),sum(r00a),sum(r00a1),sum(r00a2),sum(r00b),sum(r00b1),sum(r00b2),sum(r00c),sum(r00c1),sum(r00c2),sum(r00d),sum(r00d1),sum(r00d2),".
"sum(r01),sum(r02),sum(r03),2,".
"sum(r04),sum(r04a),sum(r04a1),sum(r04a2),sum(r04b),sum(r04c),sum(r04c1),sum(r04c2),sum(r04d),sum(r04e),sum(r04f),sum(r04x),0,".
"sum(r05),sum(r06),sum(r07),sum(r08),sum(r09),sum(r09a),sum(r10),0,".
"sum(r11),sum(r11a),sum(r11b),".
"sum(r12),sum(r12a),sum(r13),sum(r14),sum(r14a),sum(r14b),sum(r15),sum(r15a),sum(r15b),sum(r16),sum(r17n),sum(r17p),sum(r18n),sum(r18p),0,'',".
"'0000-00-00','$dat_sprsql','0000-00-00','0000-00-00','0000-00-00','0000-00-00', ".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid." WHERE oc = $cislo_oc ".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

  if ( $nasielvyplnene == 1 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET r00z2='$xr00z2', r00a2='$xr00a2', r00b2='$xr00b2', r00c2='$xr00c2', r04a2='$xr04a2', r04b='$xr04b', ".
" r02='$xr02', r11b='$xr11b', r14b='$xr14b', vyk='$xvyk'  WHERE oc = $cislo_oc ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
  }
}
//koniec pracovneho suboru pre rocne 

//vypocty
//vsetky vypocty su aktualizovane na rok 2015
$nepocitaj=0;
if ( ( $copern == 10 OR $copern == 20 ) AND $nepocitaj == 0 )
{
//vypocitaj 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET r00=r00z1+r00z2, r00a=r00a1+r00a2, r00b=r00b1+r00b2, r00c=r00c1+r00c2, r00d=r00d1+r00d2, r01=r00-r00a, r03=r01+r02, r04a=r04a1+r04a2  ".
"  WHERE oc = $cislo_oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//len vynulujem nepouzivane 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET r04c1=0, r04c2=0, r04e=0, r04f=0 WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");

//nezdanitelna cast na danovnika za 2015 rovnako ako v 2014
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET r04a1=3803.33, r04a2=0   WHERE oc = $cislo_oc AND r04a1 != 0 AND r04a2 >= 0 AND r01 <= 19809.00 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET r04a=r04a1+r04a2  WHERE oc = $cislo_oc ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");


//milionarska dan za 2015 rovnako ako v 2014
if ( $vsetkyprepocty == 1 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET po6=8755.578-(r01/4) WHERE oc = $cislo_oc AND r01 > 19809.00 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET po6=0, px4=0 WHERE oc = $cislo_oc AND po6 < 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET px4=po6*100, px4=ceil(px4), r04a1=px4/100, r04a=r04a1+r04a2 WHERE oc = $cislo_oc AND r01 > 19809.00 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET r04a=0, r04a1=0, r04a2=0 WHERE oc = $cislo_oc AND r01 >= 35022.32 ";
$oznac = mysql_query("$sqtoz");
     }
//koniec milionarska dan za 2015

//rok 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET po6=0, px4=0, r04x=r04a+r04b+r04c+r04d, r05=r03-r04x  WHERE oc = $cislo_oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET r05=0  WHERE oc = $cislo_oc AND r05 < 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//dan z prijmu 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET po6=0, px4=0, r06=0 WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET po6=r05*19/100 WHERE oc = $cislo_oc AND r05 <= 35022.31 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET px4=po6*100, r06=floor(px4), r06=r06/100 WHERE oc = $cislo_oc AND r05 <= 35022.31 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET po6=(35022.31*19/100)+((r05-35022.31)*25/100) WHERE oc = $cislo_oc AND r05 > 35022.31 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET px4=po6*100, r06=floor(px4), r06=r06/100 WHERE oc = $cislo_oc AND r05 > 35022.31 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET r06=0 WHERE oc = $cislo_oc AND r06 < 0 ";
$oznac = mysql_query("$sqtoz");


//zam.premia 2015
//2013	2026.20		2014	2112.00 6nasobok min.mzdy
//2013	4052.40		2014	4224.00 12nasobok min.mzdy
//2013	3509.76		2014	3658.08 zaklad dane zo sumy 12nasobku min.mzdy

//2014	2112.00		2015	2280.00
//2014	4224.00		2015	4560.00
//2014	3658.08
if ( $vsetkyprepocty == 1 AND $kli_vrok >= 2015 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET r07=r01, px4=0, po6=0 WHERE oc = $cislo_oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET r07=r01 WHERE oc = $cislo_oc AND r00 >= 4560.00 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET r07=0, r08=0 WHERE oc = $cislo_oc AND r00 < 4560.00 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET r07=0, r09=0 WHERE oc = $cislo_oc AND r08 = 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET r08=12 WHERE oc = $cislo_oc AND r08 > 12 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET po6=((r04a-r07)*0.19)*r08/12 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET px4=po6*100, r09=ceil(px4), r09=r09/100 WHERE oc = $cislo_oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET r09=0  WHERE oc = $cislo_oc AND r09 < 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//max zam.premia na rok 2015 nie je stanovena lebo vraj vsetci musia mat nulu a tak dam to co bolo 2014
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane SET r09=27.60  WHERE oc = $cislo_oc AND r09 > 27.60";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

     }
//koniec zam.premia 2015


//dan.bonus 2015 max. 256.92 na rok na 1 dieta
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET r12=0, r13=0, r11=r11a+r11b, r12=r10-r11 WHERE oc = $cislo_oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET r13=-r12, r12=0 WHERE oc = $cislo_oc AND r12 < 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET r12a=r12-r06 WHERE oc = $cislo_oc AND r12 > 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET r12a=0 WHERE oc = $cislo_oc AND r12a < 0";
$oznac = mysql_query("$sqtoz");

//uhrn preddavkov
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET r14=r14a+r14b WHERE oc = $cislo_oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//preplatok,nedoplatok neupraveny
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET r16=0, r15=r06-r14 WHERE oc = $cislo_oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET r16=-r15, r15=0 WHERE oc = $cislo_oc AND r15 < 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//preplatok,nedoplatok upraveny
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET r17p=0, r17n=r06-r10+r11+r12a-r14+r09a WHERE oc = $cislo_oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET r17p=-r17n, r17n=0 WHERE oc = $cislo_oc AND r17n < 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

if ( $vsetkyprepocty == 1 )
     {
//vybrat od zamestnanca alebo vyplatit
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET r18p=0, r18n=r15+r13-r16-r09-r12+r09a WHERE oc = $cislo_oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnedane".
" SET r18p=-r18n, r18n=0 WHERE oc = $cislo_oc AND r18n < 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz"); 
     }
}
//koniec vypocty 2015


//nacitaj udaje pre upravu
if ( $copern == 20 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdrocnedane".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdrocnedane.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdrocnedane.oc = $cislo_oc AND konx1 = 2 ORDER BY konx1,prie,meno";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$oc = $fir_riadok->oc;
$vyk = $fir_riadok->vyk;
$zamestnanec = $fir_riadok->meno." ".$fir_riadok->prie;
$meno = $fir_riadok->meno;
$prie = $fir_riadok->prie;
$rodne = $fir_riadok->rdc."/".$fir_riadok->rdk;
$dar=SkDatum($fir_riadok->dar);
if ( $rodne == "0/" ) { $rodne="$dar"; }
$ptitl = $fir_riadok->titl;
$adresa = $fir_riadok->zuli." ".$fir_riadok->zcdm.", ".$fir_riadok->zmes;
$zuli = $fir_riadok->zuli;
$zcdm = $fir_riadok->zcdm;
$zpsc = $fir_riadok->zpsc;
$zmes = $fir_riadok->zmes;
$r00 = $fir_riadok->r00;
$r00z1 = $fir_riadok->r00z1;
$r00z2 = $fir_riadok->r00z2;
$r00d = $fir_riadok->r00d;
$r00d1 = $fir_riadok->r00d1;
$r00d2 = $fir_riadok->r00d2;
$r00a = $fir_riadok->r00a;
$r00a1 = $fir_riadok->r00a1;
$r00a2 = $fir_riadok->r00a2;
$r00b = $fir_riadok->r00b;
$r00b1 = $fir_riadok->r00b1;
$r00b2 = $fir_riadok->r00b2;
$r00c = $fir_riadok->r00c;
$r00c1 = $fir_riadok->r00c1;
$r00c2 = $fir_riadok->r00c2;
$r01 = $fir_riadok->r01;
$r02 = $fir_riadok->r02;
$r03 = $fir_riadok->r03;
$r04 = $fir_riadok->r04;
$r04a = $fir_riadok->r04a;
$r04a1 = $fir_riadok->r04a1;
$r04a2 = $fir_riadok->r04a2;
$r04b = $fir_riadok->r04b;
$r04c = $fir_riadok->r04c;
$r04d = $fir_riadok->r04d;
$r04x = $fir_riadok->r04x;
$r05 = $fir_riadok->r05;
$r06 = $fir_riadok->r06;
$r07 = $fir_riadok->r07;
$r07 = $fir_riadok->r07;
$r08 = $fir_riadok->r08;
$r09 = $fir_riadok->r09;
$r09a = $fir_riadok->r09a;
$r10 = $fir_riadok->r10;
$r11 = $fir_riadok->r11;
$r11a = $fir_riadok->r11a;
$r11b = $fir_riadok->r11b;
$r12 = $fir_riadok->r12;
$r12a = $fir_riadok->r12a;
$r13 = $fir_riadok->r13;
$r14 = $fir_riadok->r14;
$r14a = $fir_riadok->r14a;
$r14b = $fir_riadok->r14b;
$r15 = $fir_riadok->r15;
$r16 = $fir_riadok->r16;
$r17n = $fir_riadok->r17n;
$r17p = $fir_riadok->r17p;
$r18n = $fir_riadok->r18n;
$r18p = $fir_riadok->r18p;
$da21 = $fir_riadok->da21;
$da21=SkDatum($da21);
$pozn = $fir_riadok->pozn;

mysql_free_result($fir_vysledok);

$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdrocnedaneprenos";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$dmx = $fir_riadok->dmx;
$umx = $fir_riadok->umx;
$fix = $fir_riadok->fix;

if ( $umx == '1.2011' ) { $umx = "1.2017"; }
if ( $umx == '1.2012' ) { $umx = "1.2017"; }
if ( $umx == '1.2013' ) { $umx = "1.2017"; }
if ( $umx == '1.2014' ) { $umx = "1.2017"; }
if ( $umx == '1.2015' ) { $umx = "1.2017"; }
if ( $umx == '1.2016' ) { $umx = "1.2017"; }

mysql_free_result($fir_vysledok);

if ( $strana == 2 ) {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdrocnedane2strana WHERE oc = $cislo_oc ";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$da2str = $fir_riadok->da2str;
$da2strsk =SkDatum($da2str);
$suma1 = $fir_riadok->suma1;
$zost1 = $fir_riadok->zost1;
$datm2 = $fir_riadok->datm2;
$datm2sk=SkDatum($datm2);
$suma2 = $fir_riadok->suma2;
$zost2 = $fir_riadok->zost2;
$datm3 = $fir_riadok->datm3;
$datm3sk=SkDatum($datm3);
$suma3 = $fir_riadok->suma3;
$zost3 = $fir_riadok->zost3;
$suma4 = $fir_riadok->suma4;
$zost4 = $fir_riadok->zost4;
$datm5 = $fir_riadok->datm5;
$datm5sk=SkDatum($datm5);
$suma5 = $fir_riadok->suma5;
$zost5 = $fir_riadok->zost5;
$datm6 = $fir_riadok->datm6;
$datm6sk=SkDatum($datm6);
$suma6 = $fir_riadok->suma6;
$zost6 = $fir_riadok->zost6;
$datm7 = $fir_riadok->datm7;
$datm7sk=SkDatum($datm7);
$suma7 = $fir_riadok->suma7;
$zost7 = $fir_riadok->zost7;
$da2ked = $fir_riadok->da2ked;
$da2kedsk =SkDatum($da2ked);
mysql_free_result($fir_vysledok);
                    }

if ( $strana == 3 ) {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdrocnedane2strana WHERE oc = $cislo_oc ";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$zp2dat = $fir_riadok->zp2dat;
$zp2datsk =SkDatum($zp2dat);
$zp2dak = $fir_riadok->zp2dak;
$zp2daksk =SkDatum($zp2dak);
$zp2hod = $fir_riadok->zp2hod;
$zpzrobil = $kli_uzprie." ".$kli_uzmeno;

mysql_free_result($fir_vysledok);
                    }
     }
//koniec nacitania


/////////////NACITANIE UDAJOV Z PARAMETROV
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  }
?>

<?php
$novy=0;
if ( $novy == 0 )
{
$prev_oc=$cislo_oc-1;
$next_oc=$cislo_oc+1;
if ( $prev_oc == 0 ) $prev_oc=1;
if ( $next_oc > 9999 ) $next_oc=9999;

$nasieloc=0;
$i=0;
while ($i <= 9999 AND $nasieloc == 0 )
{
$sqlico = mysql_query("SELECT oc FROM F$kli_vxcf"."_mzdkun WHERE oc=$prev_oc ");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if ( $nasieloc == 0 ) $prev_oc=$prev_oc-1;
if ( $prev_oc <= 1 ) $nasieloc=1;
}
$i=$i+1;

$maxoc=9999;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdkun ORDER BY oc DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $maxoc=1*$riaddok->oc;
  }
if ( $next_oc > $maxoc ) $next_oc=$maxoc;

$nasieloc=0;
$i=0;
while ($i <= 9999 AND $nasieloc == 0 AND $next_oc <= $maxoc )
{
$sqlico = mysql_query("SELECT oc FROM F$kli_vxcf"."_mzdkun WHERE oc=$next_oc ");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if ( $nasieloc == 0 ) $next_oc=$next_oc+1;
if ( $next_oc >= 9999 ) $nasieloc=1;
}
$i=$i+1;

if ( $prev_oc == 0 ) $prev_oc=1;
if ( $next_oc > 9999 ) $next_oc=9999;
}
//koniec novy=0

//statna prislusnost z statistiky treximaoc
$statznec="SK";
$sqlttt = "SELECT * FROM F$kli_vxcf"."_treximaoc WHERE idec = $cislo_oc LIMIT 1 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $statznec=trim($riaddok->stprisl);
  }
if ( $statznec == '' ) { $statznec="SK"; }

//titul za zo ziadosti o rz
$titulza="";
$sqlttt = "SELECT * FROM F$kli_vxcf"."_rocneziadost WHERE oc = $cislo_oc LIMIT 1 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $titulza=trim($riaddok->ztitl);
  }

//FO-Priezvisko,Meno,Titul a trvaly pobyt z ufirdalsie
if ( $fir_uctt03 == 999 )
{
$sqlc = "SELECT * FROM F$kli_vxcf"."_ufirdalsie WHERE icox = 0";
$vysledokc = mysql_query($sqlc);
if ( $vysledokc )
     {
$riadokc=mysql_fetch_object($vysledokc);
$dprie = $riadokc->dprie;
$dmeno = $riadokc->dmeno;
$dtitl = $riadokc->dtitl;
$dtitz = $riadokc->dtitz;
$duli = $riadokc->duli;
$dcdm = $riadokc->dcdm;
$dpsc = $riadokc->dpsc;
$dmes = $riadokc->dmes;
$dstat = $riadokc->dstat;
$dtel = $riadokc->dtel;
//$dfax = $riadokc->dfax;
     }
}
if ( $fir_uctt03 != 999 )
{
$dmeno=""; $dprie=""; $dtitl=""; $dtitz="";
$duli=$fir_fuli; $dcdm=$fir_fcdm; $dmes=$fir_fmes; $dpsc=$fir_fpsc;
$dtel=$fir_ftel; $dfax=$fir_ffax; $dstat="Slovensko";
}
$fir_uctt03tlac=$fir_uctt03;
if ( $fir_uctt03 == 999 )
{
$fir_fnaz=""; $fir_uctt03tlac="";
}
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - RZ dane z prÌjmu</title>
<style type="text/css">
form.prenos-bar {
  display: block;
  position: absolute;
  top: 19px;
  right: 102px;
  background-color: #add8e6;
  font-size: 12px;
}
form.prenos-bar a {
  float: left;
  height: 24px;
  line-height: 24px;
  width: 70px;
  margin: 2px;
  background-color: #39f;
  text-align: center;
  color: #fff;
  font-weight: bold;
}
table.prenos-box {
  float: left;
  width: 250px;
  margin: 0 3px 0 10px;
}
table.prenos-box td {
  width: 60px;
  height: 28px;
  line-height: 28px;
}
table.prenos-box input {
  width: 50px;
  height: 18px;
  line-height: 18px;
  margin: 3px 0 0 3px;
  font-size: 13px;
}
select.btn-zrobrz {
  top: 52px;
  left: 130px;
  height: 28px;
  padding-left: 5px;
  background-color: #39f;
  color: #fff;
  font-size: 14px;
  border-radius: 2px;
}
div.leg-pozn {
  position: absolute;
  top: 1286px;
  left: 610px;
  font: bold 12px Times new Roman;
}
div.input-echo {
  position: absolute;
  font-size: 16px;
  background-color: #fff;
  text-align: right;
  font-weight: bold;
}
</style>
<script type="text/javascript">
//parameter okna
var param = 'scrollbars=yes,resizable=yes,top=0,left=0,width=1080,height=900';

<?php if ( $copern != 20 ) { ?>
  function ObnovUI()
  {
  }
<?php                      } ?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1 ) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function prevOC()
  {
   window.open('rocne_dane2016.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $prev_oc;?>', '_self');
  }
  function nextOC()
  {
   window.open('rocne_dane2016.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $next_oc;?>', '_self');
  }
  function TlacRZ()
  {
   window.open('../mzdy/rocne_dane2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999', '_blank', param);
  }
  function reNacitajMzdy()
  {
   window.open('../mzdy/rocne_dane2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=0', '_self');
  }
  function UpravZamestnanca()
  {
   window.open('zamestnanci.php?sys=<?php echo $sys; ?>&copern=8&page=1&cislo_oc=<?php echo $cislo_oc;?>&h_oc=<?php echo $cislo_oc;?>', '_blank', param);
  }
  function TlacMzdovyList()
  {
   window.open('../mzdy/mzdevid.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1', '_blank', param);
  }

  function NacitajMzdy()
  {
   var fix = document.forms.emzdy.fix.value;
   var umx = document.forms.emzdy.umx.value;
   var dmx = document.forms.emzdy.dmx.value;
   var pre = 1*document.forms.formv1.r16.value;
   var ned = 1*document.forms.formv1.r15.value;
   var prebon = 1*document.forms.formv1.r12.value;
   var nedbon = 1*document.forms.formv1.r13.value;
   var zampre = 1*document.forms.formv1.r09.value;
   var zamprex = 1*document.forms.formv1.r09a.value;
   window.open('../mzdy/rocne_dane2016.php?fix=' + fix + '&zamprex=' + zamprex + '&zampre=' + zampre + '&prebon=' + prebon +  '&nedbon=' + nedbon + '&pre=' + pre + '&ned=' + ned + '&umx=' + umx + '&dmx=' + dmx + '&cislo_oc=<?php echo $cislo_oc;?>&copern=27&drupoh=1&page=1&subor=0', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function ZoznamRocnezucto()
  {
   window.open('../mzdy/rocne_danezoznam2013.php?copern=1&drupoh=1&page=1&subor=0', '_self');
  }

<?php
//uprava sadzby
  if ( $copern == 20 )
  { 
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
   document.formv1.vyk.value = '<?php echo "$vyk";?>';
   document.formv1.r00z1.value = '<?php echo "$r00z1";?>';
   document.formv1.r00z2.value = '<?php echo "$r00z2";?>';
   document.formv1.r00d1.value = '<?php echo "$r00d1";?>';
   document.formv1.r00d2.value = '<?php echo "$r00d2";?>';
   document.formv1.r00a1.value = '<?php echo "$r00a1";?>';
   document.formv1.r00a2.value = '<?php echo "$r00a2";?>';
   document.formv1.r00b1.value = '<?php echo "$r00b1";?>';
   document.formv1.r00b2.value = '<?php echo "$r00b2";?>';
   document.formv1.r00c1.value = '<?php echo "$r00c1";?>';
   document.formv1.r00c2.value = '<?php echo "$r00c2";?>';
   document.formv1.r02.value = '<?php echo "$r02";?>';
   document.formv1.r04a1.value = '<?php echo "$r04a1";?>';
   document.formv1.r04a2.value = '<?php echo "$r04a2";?>';
   document.formv1.r04b.value = '<?php echo "$r04b";?>';
   document.formv1.r04c.value = '<?php echo "$r04c";?>';
   document.formv1.r04d.value = '<?php echo "$r04d";?>';
   document.formv1.r06.value = '<?php echo "$r06";?>';
   document.formv1.r07.value = '<?php echo "$r07";?>';
   document.formv1.r08.value = '<?php echo "$r08";?>';
   document.formv1.r09.value = '<?php echo "$r09";?>';
   document.formv1.r09a.value = '<?php echo "$r09a";?>';
   document.formv1.r10.value = '<?php echo "$r10";?>';
   document.formv1.r11a.value = '<?php echo "$r11a";?>';
   document.formv1.r11b.value = '<?php echo "$r11b";?>';
   document.formv1.r12.value = '<?php echo "$r12";?>';
   document.formv1.r12a.value = '<?php echo "$r12a";?>';
   document.formv1.r13.value = '<?php echo "$r13";?>';
   document.formv1.r14a.value = '<?php echo "$r14a";?>';
   document.formv1.r14b.value = '<?php echo "$r14b";?>';
   document.formv1.r15.value = '<?php echo "$r15";?>';
   document.formv1.r16.value = '<?php echo "$r16";?>';
   document.formv1.r17n.value = '<?php echo "$r17n";?>';
   document.formv1.r17p.value = '<?php echo "$r17p";?>';
   document.formv1.r18n.value = '<?php echo "$r18n";?>';
   document.formv1.r18p.value = '<?php echo "$r18p";?>';
   document.formv1.da21.value = '<?php echo "$da21";?>';
   document.formv1.pozn.value = '<?php echo "$pozn";?>';
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
   document.formv1.da2str.value = '<?php echo "$da2strsk";?>';
   document.formv1.suma1.value = '<?php echo "$suma1";?>';
   document.formv1.zost1.value = '<?php echo "$zost1";?>';
   document.formv1.datm2.value = '<?php echo "$datm2sk";?>';
   document.formv1.suma2.value = '<?php echo "$suma2";?>';
   document.formv1.zost2.value = '<?php echo "$zost2";?>';
   document.formv1.datm3.value = '<?php echo "$datm3sk";?>';
   document.formv1.suma3.value = '<?php echo "$suma3";?>';
   document.formv1.zost3.value = '<?php echo "$zost3";?>';
   document.formv1.suma4.value = '<?php echo "$suma4";?>';
   document.formv1.zost4.value = '<?php echo "$zost4";?>';
   document.formv1.datm5.value = '<?php echo "$datm5sk";?>';
   document.formv1.suma5.value = '<?php echo "$suma5";?>';
   document.formv1.zost5.value = '<?php echo "$zost5";?>';
   document.formv1.datm6.value = '<?php echo "$datm6sk";?>';
   document.formv1.suma6.value = '<?php echo "$suma6";?>';
   document.formv1.zost6.value = '<?php echo "$zost6";?>';
   document.formv1.datm7.value = '<?php echo "$datm7sk";?>';
   document.formv1.suma7.value = '<?php echo "$suma7";?>';
   document.formv1.zost7.value = '<?php echo "$zost7";?>';
   document.formv1.da2ked.value = '<?php echo "$da2kedsk";?>';
<?php                     } ?>

<?php if ( $strana == 3 ) { ?>
   document.formv1.zp2dat.value = '<?php echo "$zp2datsk";?>';
   document.formv1.zp2dak.value = '<?php echo "$zp2daksk";?>';
   document.formv1.zp2hod.value = '<?php echo "$zp2hod";?>';
<?php                     } ?>

<?php  if ( $copern == 299 ) { ?>
<?php                        } ?>
  }
<?php
//koniec uprav
  }
?>
</script>
</HEAD>
<BODY id="white" onload="ObnovUI();">
<?php
//uprav udaje
if ( $copern == 20 )
{
?>
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
  </tr>
  <tr>
   <td class="header">RoËnÈ z˙Ëtovanie dane z prÌjmov - <span class="subheader"><?php echo "$oc $zamestnanec";?></span>
<?php if ( $novy == 0 ) { ?>
    <img src='../obr/prev.png' onclick="prevOC();" title="Os.Ë. <?php echo $prev_oc; ?>" class="navoc-icon">
    <img src='../obr/next.png' onclick="nextOC();" title="Os.Ë. <?php echo $next_oc; ?>" class="navoc-icon">
<?php                   } ?>
   </td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/reload_blue_icon.png" onclick="reNacitajMzdy();" title="Znovu naËÌtaù hodnoty z miezd" class="btn-form-tool">
     <img src="../obr/ikony/list_blue_icon.png" onclick="TlacMzdovyList();" title="Zobraziù mzdov˝ list v PDF" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacRZ();" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>

 <FORM name="emzdy" method="post" action="#" class="prenos-bar">
<?php if ( $strana == 1 ) { ?>
  <a href="#" onclick="NacitajMzdy();" title="Preniesù preplatok alebo nedoplatok do mesaËnej mzdovej d·vky vpravo nastavenej firmy,
   mzdovej zloûky a ˙ËtovnÈho mesiaca. RZ = dm903, daÚ.bonus = dm952 a zam.prÈmia = dm953.">Preniesù</a>
  <table class="prenos-box">
  <tr>
   <td><strong>FIR</strong><input type="text" name="fix" id="fix" maxlength="4" value="<?php echo $fix; ?>"></td>
   <td><strong>DM</strong><input type="text" name="dmx" id="dmx" maxlength="4" value="<?php echo $dmx; ?>"></td>
   <td><strong>UME</strong><input type="text" name="umx" id="umx" maxlength="8" value="<?php echo $umx; ?>"></td>
  </tr>
  </table>

<?php                     } ?>
 </FORM>
</div>

<div id="content">
<FORM name="formv1" method="post" action="rocne_dane2016.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana;?>">
<?php
$clas1="noactive"; $clas2="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active"; if ( $strana == 3 ) $clas3="active";
$source="../mzdy/rocne_dane2016.php?cislo_oc=".$cislo_oc."&drupoh=1&page=1&subor=0";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">Potvrdenie 2%</a>
 <a href="#" onclick="ZoznamRocnezucto();" class="toleft">Zamestnanci</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=90&strana=1', '_blank');" class="<?php echo $clas3; ?> toright">Potvrdenie 2%</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str1_form.jpg" alt="<?php echo $jpg_popis; ?> 1.strana 247kB" class="form-background">
<?php $nepoc=0; ?>
 <input type="checkbox" name="nepoc" value="1" class="btn-prepocet"/>
<?php if ( $nepoc == 1 ) { ?> <script type="text/javascript">document.formv1.nepoc.checked = "checked";</script> <?php } ?>
 <h5 class="btn-prepocet-title"><strong>NeprepoËÌtaù</strong> zam.prÈmiu, "milion·rsku daÚ" a r.18</h5>

 <select size="1" name="vyk" id="vyk" class="btn-zrobrz">
  <option value="0">Nevykonaù</option>
  <option value="1">Vykonaù</option>
 </select>
<span class="text-echo" style="top:83px; left:573px; font-size:18px;"><?php echo $kli_vrok; ?></span>

<!-- zamestnanec -->
<span class="text-echo" style="top:114px; left:302px; "><?php echo "$ptitl $zamestnanec"; ?></span>
<span class="text-echo" style="top:114px; left:670px; "><?php echo $rodne; ?></span>
 <img src="../obr/ikony/pencil_blue_icon.png" onclick="UpravZamestnanca();"
  title="Upraviù ˙daje o zamestnancovi" class="btn-row-tool" style="top:112px; left:780px; width:20px; height:20px;">
<span class="text-echo" style="top:135px; left:247px; "><?php echo $adresa; ?></span>
<span class="text-echo" style="top:135px; left:672px; "><?php echo $zpsc; ?></span>

<!-- I.CAST -->
<div class="input-echo" style="width:80px; top:228px; left:661px;"><?php echo $r00; ?></div>
<input type="text" name="r00z1" id="r00z1" onkeyup="CiarkaNaBodku(this);" style="width:75px; top:227px; left:754px;"/>
<input type="text" name="r00z2" id="r00z2" onkeyup="CiarkaNaBodku(this);" style="width:75px; top:227px; left:841px;"/>
<div class="input-echo" style="width:80px; top:263px; left:661px;"><?php echo $r00d; ?></div>
<input type="text" name="r00d1" id="r00d1" onkeyup="CiarkaNaBodku(this);" style="width:75px; top:260px; left:754px;"/>
<input type="text" name="r00d2" id="r00d2" onkeyup="CiarkaNaBodku(this);" style="width:75px; top:260px; left:841px;"/>
<!-- r00b -->
<div class="input-echo" style="width:80px; top:296px; left:661px;"><?php echo $r00a; ?></div>
<input type="text" name="r00a1" id="r00a1" onkeyup="CiarkaNaBodku(this);" style="width:75px; top:293px; left:754px;"/>
<input type="text" name="r00a2" id="r00a2" onkeyup="CiarkaNaBodku(this);" style="width:75px; top:293px; left:841px;"/>
<div class="input-echo" style="width:80px; top:328px; left:661px;"><?php echo $r00b; ?></div>
<input type="text" name="r00b1" id="r00b1" onkeyup="CiarkaNaBodku(this);" style="width:75px; top:325px; left:754px;"/>
<input type="text" name="r00b2" id="r00b2" onkeyup="CiarkaNaBodku(this);" style="width:75px; top:325px; left:841px;"/>
<div class="input-echo" style="width:80px; top:360px; left:661px;"><?php echo $r00c; ?></div>
<input type="text" name="r00c1" id="r00c1" onkeyup="CiarkaNaBodku(this);" style="width:75px; top:358px; left:754px;"/>
<input type="text" name="r00c2" id="r00c2" onkeyup="CiarkaNaBodku(this);" style="width:75px; top:358px; left:841px;"/>
<!-- r01 -->
<div class="input-echo" style="width:80px; top:393px; left:661px;"><?php echo $r01; ?></div>
<input type="text" name="r02" id="r02" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:423px; left:661px;"/>
<div class="input-echo" style="width:80px; top:457px; left:661px;"><?php echo $r03; ?></div>
<!-- r04 -->
<div class="input-echo" style="width:80px; top:490px; left:661px;"><?php echo $r04a; ?></div>
<input type="text" name="r04a1" id="r04a1" onkeyup="CiarkaNaBodku(this);" style="width:75px; top:488px; left:754px;"/>
<input type="text" name="r04a2" id="r04a2" onkeyup="CiarkaNaBodku(this);" style="width:75px; top:488px; left:841px;"/>
<input type="text" name="r04b" id="r04b" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:520px; left:661px;"/>
<input type="text" name="r04c" id="r04c" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:553px; left:661px;"/>
<input type="text" name="r04d" id="r04d" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:585px; left:661px;"/>
<div class="input-echo" style="width:80px; top:620px; left:661px;"><?php echo $r04x; ?></div>
<div class="input-echo" style="width:80px; top:653px; left:661px;"><?php echo $r05; ?></div>
<input type="text" name="r06" id="r06" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:683px; left:661px;"/>
<input type="text" name="r07" id="r07" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:715px; left:661px;"/>
<input type="text" name="r08" id="r08" onkeyup="CiarkaNaBodku(this);" maxlength="2" style="width:80px; top:747px; left:661px;"/>
<input type="text" name="r09" id="r09" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:780px; left:661px;"/>
<input type="text" name="r09a" id="r09a" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:812px; left:661px;"/>
<input type="text" name="r10" id="r10" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:845px; left:661px;"/>
<!-- r11 -->
<div class="input-echo" style="width:80px; top:882px; left:661px;"><?php echo $r11; ?></div>
<input type="text" name="r11a" id="r11a" onkeyup="CiarkaNaBodku(this);" style="width:75px; top:880px; left:754px;"/>
<input type="text" name="r11b" id="r11b" onkeyup="CiarkaNaBodku(this);" style="width:75px; top:880px; left:841px;"/>
<input type="text" name="r12" id="r12" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:915px; left:661px;"/>
<input type="text" name="r12a" id="r12a" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:948px; left:661px;"/>
<input type="text" name="r13" id="r13" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:981px; left:661px;"/>
<!-- r14 -->
<div class="input-echo" style="width:80px; top:1018px; left:661px;"><?php echo $r14; ?></div>
<input type="text" name="r14a" id="r14a" onkeyup="CiarkaNaBodku(this);" style="width:75px; top:1016px; left:754px;"/>
<input type="text" name="r14b" id="r14b" onkeyup="CiarkaNaBodku(this);" style="width:75px; top:1016px; left:841px;"/>
<input type="text" name="r15" id="r15" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:1052px; left:661px;"/>
<input type="text" name="r16" id="r16" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:1084px; left:661px;"/>
<!-- r17 -->
<input type="text" name="r17n" id="r17n" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1117px; left:670px;"/>
<input type="text" name="r17p" id="r17p" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1149px; left:670px;"/>
<!-- r18 -->
<input type="text" name="r18n" id="r18n" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:1181px; left:661px;"/>
<input type="text" name="r18p" id="r18p" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:1214px; left:661px;"/>
<!-- Vykonal a pozn -->
<span class="text-echo" style="top:1265px; left:77px;"><?php echo $kli_uzprie; ?></span>
<input type="text" name="da21" id="da21" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:117px; top:1255px; left:383px;"/>
<input type="text" name="pozn" id="pozn" style="width:300px; top:1255px; left:610px;"/>
<div class="leg-pozn">Pozn·mka</div>
<?php                     } ?>


<?php if ( $strana == 2 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str2_form.jpg" alt="<?php echo $jpg_popis; ?> 2.strana 352kB" class="form-background">

<!-- II. CAST -->
<input type="text" name="da2str" id="da2str" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:90px; top:162px; left:440px;"/>
<span class="text-echo" style="top:200px; left:465px; "><?php echo $kli_vrok; ?></span>

<!-- tabulka -->
<span class="text-echo" style="top:268px; left:88px;"><?php echo $zamestnanec; ?></span>
<!-- zrazene -->
<input type="text" name="suma1" id="suma1" onkeyup="CiarkaNaBodku(this);" style="width:120px; top:295px; left:606px;"/>
<input type="text" name="zost1" id="zost1" onkeyup="CiarkaNaBodku(this);" style="width:120px; top:295px; left:741px;"/>
<input type="text" name="datm2" id="datm2" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:98px; top:331px; left:494px;"/>
<input type="text" name="suma2" id="suma2" onkeyup="CiarkaNaBodku(this);" style="width:120px; top:331px; left:606px;"/>
<input type="text" name="zost2" id="zost2" onkeyup="CiarkaNaBodku(this);" style="width:120px; top:331px; left:741px;"/>
<input type="text" name="datm3" id="datm3" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:98px; top:366px; left:494px;"/>
<input type="text" name="suma3" id="suma3" onkeyup="CiarkaNaBodku(this);" style="width:120px; top:366px; left:606px;"/>
<input type="text" name="zost3" id="zost3" onkeyup="CiarkaNaBodku(this);" style="width:120px; top:366px; left:741px;"/>
<!-- vratene -->
<input type="text" name="suma4" id="suma4" onkeyup="CiarkaNaBodku(this);" style="width:120px; top:401px; left:606px;"/>
<input type="text" name="zost4" id="zost4" onkeyup="CiarkaNaBodku(this);" style="width:120px; top:401px; left:741px;"/>
<input type="text" name="datm5" id="datm5" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:98px; top:436px; left:494px;"/>
<input type="text" name="suma5" id="suma5" onkeyup="CiarkaNaBodku(this);" style="width:120px; top:436px; left:606px;"/>
<input type="text" name="zost5" id="zost5" onkeyup="CiarkaNaBodku(this);" style="width:120px; top:436px; left:741px;"/>
<input type="text" name="datm6" id="datm6" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:98px; top:471px; left:494px;"/>
<input type="text" name="suma6" id="suma6" onkeyup="CiarkaNaBodku(this);" style="width:120px; top:471px; left:606px;"/>
<input type="text" name="zost6" id="zost6" onkeyup="CiarkaNaBodku(this);" style="width:120px; top:471px; left:741px;"/>
<input type="text" name="datm7" id="datm7" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:98px; top:506px; left:494px;"/>
<input type="text" name="suma7" id="suma7" onkeyup="CiarkaNaBodku(this);" style="width:120px; top:506px; left:606px;"/>
<input type="text" name="zost7" id="zost7" onkeyup="CiarkaNaBodku(this);" style="width:120px; top:506px; left:741px;"/>
<!-- Dna -->
<input type="text" name="da2ked" id="da2ked" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:117px; top:639px; left:352px;"/>
<span class="text-echo" style="top:646px; left:75px;"><?php echo $fir_fmes; ?></span>
<?php                     } ?>


<?php if ( $strana == 3 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dan_zo_zavislej2013/rz/rz_potvrdenie_dane_v13_form.jpg"
     alt="tlaËivo Potvrdenie o zaplatenÌ dane z prÌjmov zo z·vislej Ëinnosti 305kB" class="form-background">
<span class="text-echo" style="top:111px; left:742px; font-size:18px;"><?php echo $kli_vrok; ?></span>

<!-- POTVRDENIE ZAPLATENIE DANE -->
<!-- I.Zamestnanec -->
<div class="input-echo" style="top:216px; left:119px;"><?php echo $prie; ?></div>
<div class="input-echo" style="top:216px; left:409px;"><?php echo $meno; ?></div>
<div class="input-echo" style="top:216px; left:590px;"><?php echo $rodne; ?></div>
<div class="input-echo" style="top:252px; left:220px;"><?php echo $ptitl; ?></div>
<div class="input-echo" style="top:252px; left:610px;"><?php echo $titulza; ?></div>
<div class="input-echo" style="top:309px; left:155px;"><?php echo $zuli; ?></div>
<div class="input-echo" style="top:309px; left:535px;"><?php echo $zcdm; ?></div>
<div class="input-echo" style="top:309px; left:700px;"><?php echo $zpsc; ?></div>
<div class="input-echo" style="top:344px; left:155px;"><?php echo $zmes; ?></div>
<div class="input-echo" style="top:344px; left:530px;"><?php echo $statznec; ?></div>
<!-- II.Zamestnavatel -->
<div class="input-echo" style="top:484px; left:120px;"><?php echo $dprie; ?></div>
<div class="input-echo" style="top:484px; left:408px;"><?php echo $dmeno; ?></div>
<div class="input-echo" style="top:484px; left:587px;"><?php echo $dtitl; ?></div>
<div class="input-echo" style="top:542px; left:164px;"><?php echo $fir_fnaz; ?></div>
<!-- Adresa -->
<div class="input-echo" style="top:599px; left:154px;"><?php echo $duli; ?></div>
<div class="input-echo" style="top:599px; left:533px;"><?php echo $dcdm; ?></div>
<div class="input-echo" style="top:599px; left:700px;"><?php echo $dpsc; ?></div>
<div class="input-echo" style="top:634px; left:158px;"><?php echo $dmes; ?></div>
<div class="input-echo" style="top:634px; left:530px;"><?php echo $dstat; ?></div>
<div class="input-echo" style="top:669px; left:153px;"><?php echo $fir_fdic; ?></div>
<div class="input-echo" style="top:669px; left:570px;"><?php echo $fir_uctt01; ?></div>
<!-- III.Zaplatenie -->
<div class="input-echo" style="width:117px; top:775px; left:717px; text-align:right;"><?php echo $r06; ?></div>
<div class="input-echo" style="width:117px; top:817px; left:717px; text-align:right;"><?php echo $r10; ?></div>
<?php
$zpr03=$r06-$r10; 
if ( $zpr03 <= 0 ) { $zpr03=""; }
?>
<div class="input-echo" style="width:117px; top:863px; left:717px;"><?php echo $zpr03; ?>0</div>
<div class="input-echo" style="width:117px; top:902px; left:717px;"><?php echo $r17n; ?></div>
<!-- riadok 05 -->
<input type="text" name="zp2dak" id="zp2dak" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:84px; top:934px; left:750px;"/>
<input type="text" name="zp2hod" id="zp2hod" onkeyup="CiarkaNaBodku(this);" style="width:117px; top:969px; left:717px;"/>
<!-- Povrdenie -->
<div class="input-echo" style="width:203px; top:1110px; left:269px; background-color:white; text-align:left;"><?php echo $zpzrobil; ?></div>
<input type="text" name="zp2dat" id="zp2dat" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:183px; top:1107px; left:512px;"/>
<?php                     } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">Potvrdenie 2%</a>
 <a href="#" onclick="ZoznamRocnezucto();" class="toleft">Zamestnanci</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>

</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
}
//koniec uprav udaje
?>


<?php
/////////////////////////////////////////////////VYTLAC ROCNE
if ( $copern == 10 )
{
$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/rzdane_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/rzdane_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany);
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

if ( $strana == 1 OR $strana == 9999 ) {
//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdrocnedane".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdrocnedane.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdrocnedane.oc = $cislo_oc AND konx1 = 2 ORDER BY konx1,prie,meno";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);
$titl=$hlavicka->titl;
$meno=$hlavicka->meno;
$prie=$hlavicka->prie;
$adresa=$hlavicka->zuli." ".$hlavicka->zcdm.",".$hlavicka->zmes;

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dat_dat = SkDatum($hlavicka->da21);
if ( $dat_dat == '0000-00-00' ) $dat_dat="";

$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str1.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str1.jpg',0,0,210,297);
}

//za zdanovacie obdobie
$pdf->SetFont('arial','',12);
$pdf->Cell(190,12," ","$rmc1",1,"L");
$obdobie=$kli_vrok;
$pdf->Cell(115,4," ","$rmc1",0,"L");$pdf->Cell(22,6,"$kli_vrok","$rmc",1,"C");
$pdf->SetFont('arial','',10);

//ZAMESTNANEC
$pdf->Cell(190,6," ","$rmc1",1,"L");
$dar=SkDatum($hlavicka->dar);
$tlacrd="$hlavicka->rdc / $hlavicka->rdk";
if ( $tlacrd == "0 / " ) { $tlacrd="$dar"; }
$pdf->Cell(60,6," ","$rmc1",0,"L");$pdf->Cell(56,5,"$hlavicka->titl $meno $prie","$rmc",0,"L");$pdf->Cell(23,4," ","$rmc1",0,"L");
$pdf->Cell(42,5,"$tlacrd","$rmc",1,"L");
$pdf->Cell(47,7," ","$rmc1",0,"L");$pdf->Cell(78,6,"$adresa","$rmc",0,"L");$pdf->Cell(15,7," ","$rmc1",0,"L");$pdf->Cell(20,6,"$hlavicka->zpsc","$rmc",1,"L");

//I. CAST
$r00 = $hlavicka->r00; if ( $hlavicka->r00 == 0 ) $r00="";
$r00d = $hlavicka->r00d; if ( $hlavicka->r00d == 0 ) $r00d="";
$r00a = $hlavicka->r00a; if ( $hlavicka->r00a == 0 ) $r00a="";
$r00b = $hlavicka->r00b; if ( $hlavicka->r00b == 0 ) $r00b="";
$r00c = $hlavicka->r00c; if ( $hlavicka->r00c == 0 ) $r00c="";
$r01 = $hlavicka->r01; if ( $hlavicka->r01 == 0 ) $r01="";
$r02 = $hlavicka->r02; if ( $hlavicka->r02 == 0 ) $r02="";
$r03 = $hlavicka->r03; if ( $hlavicka->r03 == 0 ) $r03="";
$r04a = $hlavicka->r04a; if ( $hlavicka->r04a == 0 ) $r04a="";
$r04b = $hlavicka->r04b; if ( $hlavicka->r04b == 0 ) $r04b="";
$r04c = $hlavicka->r04c; if ( $hlavicka->r04c == 0 ) $r04c="";
$r04d = $hlavicka->r04d; if ( $hlavicka->r04d == 0 ) $r04d="";
$r04x = $hlavicka->r04x; if ( $hlavicka->r04x == 0 ) $r04x="";
$r05 = $hlavicka->r05; if ( $hlavicka->r05 == 0 ) $r05="";
$r06 = $hlavicka->r06; if ( $hlavicka->r06 == 0 ) $r06="0";
$r07 = $hlavicka->r07; if ( $hlavicka->r07 == 0 ) $r07="";
$r08 = $hlavicka->r08; if ( $hlavicka->r08 == 0 ) $r08="";
$r09 = $hlavicka->r09; if ( $hlavicka->r09 == 0 ) $r09="";
$r09a = $hlavicka->r09a; if ( $hlavicka->r09a == 0 ) $r09a="";
$r10 = $hlavicka->r10; if ( $hlavicka->r10 == 0 ) $r10="";
$r11 = $hlavicka->r11; if ( $hlavicka->r11 == 0 ) $r11="";
$r12 = $hlavicka->r12; if ( $hlavicka->r12 == 0 ) $r12="";
$r12a = $hlavicka->r12a; if ( $hlavicka->r12a == 0 ) $r12a="";
$r13 = $hlavicka->r13; if ( $hlavicka->r13 == 0 ) $r13="";
$r14 = $hlavicka->r14; if ( $hlavicka->r14 == 0 ) $r14="";
$r15 = $hlavicka->r15; if ( $hlavicka->r15 == 0 ) $r15="";
$r16 = $hlavicka->r16; if ( $hlavicka->r16 == 0 ) $r16="";
$r17n = $hlavicka->r17n; if ( $hlavicka->r17n == 0 ) $r17n="";
$r17p = $hlavicka->r17p; if ( $hlavicka->r17p == 0 ) $r17p="";
$r18n = $hlavicka->r18n; if ( $hlavicka->r18n == 0 ) $r18n="";
$r18p = $hlavicka->r18p; if ( $hlavicka->r18p == 0 ) $r18p="";
$pdf->Cell(190,6," ","$rmc1",1,"L");
$pdf->Cell(161,22," ","$rmc1",0,"L");$pdf->Cell(25,22,"$r00","$rmc",1,"R");
$pdf->Cell(161,5," ","$rmc1",0,"L");$pdf->Cell(25,5,"$r00d","$rmc",1,"R");
$pdf->Cell(161,6," ","$rmc1",0,"L");$pdf->Cell(25,6,"$r00a","$rmc",1,"R");
$pdf->Cell(161,5," ","$rmc1",0,"L");$pdf->Cell(25,5,"$r00b","$rmc",1,"R");
$pdf->Cell(161,5," ","$rmc1",0,"L");$pdf->Cell(25,6,"$r00c","$rmc",1,"R");
$pdf->Cell(161,6," ","$rmc1",0,"L");$pdf->Cell(25,5,"$r01","$rmc",1,"R");
$pdf->Cell(161,8," ","$rmc1",0,"L");$pdf->Cell(25,7,"$r02","$rmc",1,"R");
$pdf->Cell(161,9," ","$rmc1",0,"L");$pdf->Cell(25,5,"$r03","$rmc",1,"R");

if ( $r09 > 0 ) { $r04a="";  $r04b=""; $r04c=""; $r04d=""; $r04x=""; }
$pdf->Cell(161,6," ","$rmc1",0,"L");$pdf->Cell(25,6,"$r04a","$rmc",1,"R");
$pdf->Cell(161,6," ","$rmc1",0,"L");$pdf->Cell(25,6,"$r04b","$rmc",1,"R");
$pdf->Cell(161,6," ","$rmc1",0,"L");$pdf->Cell(25,6,"$r04c","$rmc",1,"R");
$pdf->Cell(161,6," ","$rmc1",0,"L");$pdf->Cell(25,7,"$r04d","$rmc",1,"R");
$pdf->Cell(161,6," ","$rmc1",0,"L");$pdf->Cell(25,6,"$r04x","$rmc",1,"R");
$pdf->Cell(161,6," ","$rmc1",0,"L");$pdf->Cell(25,6,"$r05","$rmc",1,"R");
$pdf->Cell(161,7," ","$rmc1",0,"L");$pdf->Cell(25,6,"$r06","$rmc",1,"R");

$pdf->Cell(161,7," ","$rmc1",0,"L");$pdf->Cell(25,5,"$r07","$rmc",1,"R");
$pdf->Cell(161,6," ","$rmc1",0,"L");$pdf->Cell(25,6,"$r08","$rmc",1,"R");
$pdf->Cell(161,6," ","$rmc1",0,"L");$pdf->Cell(25,6,"$r09","$rmc",1,"R");
$pdf->Cell(161,6," ","$rmc1",0,"L");$pdf->Cell(25,6,"$r09a","$rmc",1,"R");

$pdf->Cell(161,6," ","$rmc1",0,"L");$pdf->Cell(25,6,"$r10","$rmc",1,"R");
$pdf->Cell(161,9," ","$rmc1",0,"L");$pdf->Cell(25,8,"$r11","$rmc",1,"R");
$pdf->Cell(161,8," ","$rmc1",0,"L");$pdf->Cell(25,5,"$r12","$rmc",1,"R");
$pdf->Cell(161,4," ","$rmc1",0,"L");$pdf->Cell(25,5,"$r12a","$rmc",1,"R");
$pdf->Cell(161,7," ","$rmc1",0,"L");$pdf->Cell(25,6,"$r13","$rmc",1,"R");

$pdf->Cell(161,9," ","$rmc1",0,"L");$pdf->Cell(25,8,"$r14","$rmc",1,"R");
$pdf->Cell(161,6," ","$rmc1",0,"L");$pdf->Cell(25,6.5,"$r15","$rmc",1,"R");
$pdf->Cell(161,7," ","$rmc1",0,"L");$pdf->Cell(25,5,"$r16","$rmc",1,"R");
$pdf->Cell(161,5," ","$rmc1",0,"L");$pdf->Cell(25,5,"$r17n","$rmc",1,"R");
$pdf->Cell(161,7," ","$rmc1",0,"L");$pdf->Cell(25,5,"$r17p","$rmc",1,"R");
$pdf->Cell(161,5," ","$rmc1",0,"L");$pdf->Cell(25,4,"$r18n","$rmc",1,"R");
$pdf->Cell(161,5," ","$rmc1",0,"L");$pdf->Cell(25,5.5,"$r18p","$rmc",1,"R");

//ZAMESTNAVATEL
$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->Cell(19,5," ","$rmc1",0,"L");$pdf->Cell(35,5,"$fir_fdic","$rmc",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(64,5," ","$rmc1",0,"L");$pdf->Cell(80,5,"$fir_fnaz, $fir_fuli $fir_fcdm, $fir_fmes","$rmc",1,"L");
$pdf->SetFont('arial','',10);

//Vypracoval
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(11,7," ","$rmc1",0,"L");$pdf->Cell(42,4,"$kli_uzprie","$rmc",0,"L");$pdf->Cell(2,5," ","$rmc1",0,"L");
if ( $dat_dat == '00.00.0000' ) $dat_dat="";
$pdf->Cell(20,4,"$dat_dat","$rmc",0,"L");$pdf->Cell(4,5," ","$rmc1",0,"L");$pdf->Cell(60,4,"$fir_ftel","$rmc",1,"L");

//Poznamka
$pdf->Cell(190,22," ","$rmc1",1,"L");
$pozn=$hlavicka->pozn;
$pdf->Cell(11,5," ","$rmc1",0,"L");$pdf->Cell(160,5,"$pozn","$rmc",1,"L");
}
$i = $i + 1;
  }
                                       } //koniec 1.strany

if ( $strana == 2 OR $strana == 9999 ) {
$sqltt2 = "SELECT * FROM F$kli_vxcf"."_mzdrocnedane2strana WHERE oc = $cislo_oc ";
$sql2 = mysql_query("$sqltt2");
$pol2 = mysql_num_rows($sql2);

$i2=0;
  while ($i2 <= $pol2 )
  {
  if (@$zaznam2=mysql_data_seek($sql2,$i2))
{
$hlavicka2=mysql_fetch_object($sql2);
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str2.jpg') AND $i2 == 0 )
{
$pdf->Image($jpg_cesta.'_str2.jpg',0,0,210,297);
}

//II. CAST
$pdf->Cell(190,28," ","$rmc1",1,"L");
$da2str = $hlavicka2->da2str;
$da2strsk=SkDatum($da2str);
if ( $hlavicka2->da2str == '0000-00-00' ) $da2strsk="";
$pdf->Cell(93,5," ","$rmc1",0,"L");$pdf->Cell(24,4,"$da2strsk","$rmc",1,"C");
$pdf->Cell(106,4," ","$rmc1",0,"L");$pdf->Cell(20,5,"$kli_vrok","$rmc",1,"C");

//Zamestnanec
$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $cislo_oc ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie=$riaddok->prie;
  $meno=$riaddok->meno;
  $titl=$riaddok->titl;
  }
$pdf->Cell(190,9," ","$rmc1",1,"L");
$pdf->Cell(10,6," ","$rmc1",0,"L");$pdf->Cell(80,5,"$titl $meno $prie","$rmc",0,"L");$pdf->Cell(23,4," ","$rmc1",0,"L");

$pdf->Cell(190,6," ","$rmc1",1,"L");
$suma1 = $hlavicka2->suma1;
$suma2 = $hlavicka2->suma2;
$suma3 = $hlavicka2->suma3;
$suma4 = $hlavicka2->suma4;
$suma5 = $hlavicka2->suma5;
$suma6 = $hlavicka2->suma6;
$suma7 = $hlavicka2->suma7;
if ( $hlavicka2->suma1 == 0 ) $suma1="";
if ( $hlavicka2->suma2 == 0 ) $suma2="";
if ( $hlavicka2->suma3 == 0 ) $suma3="";
if ( $hlavicka2->suma4 == 0 ) $suma4="";
if ( $hlavicka2->suma5 == 0 ) $suma5="";
if ( $hlavicka2->suma6 == 0 ) $suma6="";
if ( $hlavicka2->suma7 == 0 ) $suma7="";
$zost1 = $hlavicka2->zost1;
$zost2 = $hlavicka2->zost2;
$zost3 = $hlavicka2->zost3;
$zost4 = $hlavicka2->zost4;
$zost5 = $hlavicka2->zost5;
$zost6 = $hlavicka2->zost6;
$zost7 = $hlavicka2->zost7;
if ( $hlavicka2->zost1 == 0 ) $zost1="";
if ( $hlavicka2->zost2 == 0 ) $zost2="";
if ( $hlavicka2->zost3 == 0 ) $zost3="";
if ( $hlavicka2->zost4 == 0 ) $zost4="";
if ( $hlavicka2->zost5 == 0 ) $zost5="";
if ( $hlavicka2->zost6 == 0 ) $zost6="";
if ( $hlavicka2->zost7 == 0 ) $zost7="";
$datm2 = $hlavicka2->datm2;
$datm2sk=SkDatum($datm2);
if ( $hlavicka2->datm2 == '0000-00-00' ) $datm2sk="";
$datm3 = $hlavicka2->datm3;
$datm3sk=SkDatum($datm3);
if ( $hlavicka2->datm3 == '0000-00-00' ) $datm3sk="";
$datm5 = $hlavicka2->datm5;
$datm5sk=SkDatum($datm5);
if ( $hlavicka2->datm5 == '0000-00-00' ) $datm5sk="";
$datm6 = $hlavicka2->datm6;
$datm6sk=SkDatum($datm6);
if ( $hlavicka2->datm6 == '0000-00-00' ) $datm6sk="";
$datm7 = $hlavicka2->datm7;
$datm7sk=SkDatum($datm7);
if ( $hlavicka2->datm7 == '0000-00-00' ) $datm7sk="";

$pdf->Cell(101,5," ","$rmc1",0,"L");$pdf->Cell(22,5," ","$rmc1",0,"R");$pdf->Cell(32,6,"$suma1","$rmc",0,"R");$pdf->Cell(28,6,"$zost1","$rmc",1,"R");
$pdf->Cell(101,5," ","$rmc1",0,"L");$pdf->Cell(22,6,"$datm2sk","$rmc",0,"C");$pdf->Cell(32,6,"$suma2","$rmc",0,"R");$pdf->Cell(28,6,"$zost2","$rmc",1,"R");
$pdf->Cell(101,5," ","$rmc1",0,"L");$pdf->Cell(22,7,"$datm3sk","$rmc",0,"C");$pdf->Cell(32,7,"$suma3","$rmc",0,"R");$pdf->Cell(28,7,"$zost3","$rmc",1,"R");
$pdf->Cell(101,5," ","$rmc1",0,"L");$pdf->Cell(22,5," ","$rmc1",0,"R");$pdf->Cell(32,6,"$suma4","$rmc",0,"R");$pdf->Cell(28,6,"$zost4","$rmc",1,"R");
$pdf->Cell(101,5," ","$rmc1",0,"L");$pdf->Cell(22,6,"$datm5sk","$rmc",0,"C");$pdf->Cell(32,6,"$suma5","$rmc",0,"R");$pdf->Cell(28,6,"$zost5","$rmc",1,"R");
$pdf->Cell(101,5," ","$rmc1",0,"L");$pdf->Cell(22,6,"$datm6sk","$rmc",0,"C");$pdf->Cell(32,6,"$suma6","$rmc",0,"R");$pdf->Cell(28,6,"$zost6","$rmc",1,"R");
$pdf->Cell(101,5," ","$rmc1",0,"L");$pdf->Cell(22,7,"$datm7sk","$rmc",0,"C");$pdf->Cell(32,7,"$suma7","$rmc",0,"R");$pdf->Cell(28,7,"$zost7","$rmc",1,"R");

//Vystavene
$pdf->Cell(190,18," ","$rmc1",1,"L");
$da2ked = $hlavicka2->da2ked;
$da2kedsk =SkDatum($da2ked);
if ( $hlavicka2->da2ked == '0000-00-00' ) $da2kedsk="";
$pdf->Cell(15,5," ","$rmc1",0,"L");$pdf->Cell(48,6,"$fir_fmes","$rmc",0,"L");
$pdf->Cell(10,5," ","$rmc1",0,"R");$pdf->Cell(27,6,"$da2kedsk","$rmc",1,"C");
}
$i2 = $i2 + 1;
  }
                                       } //koniec 2.strany

$pdf->Output("$outfilex");
?>

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>

<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA ROCNEHO
?>

<?php
/////////////////////////////////////////////////VYTLAC Potvrdenie o zaplatenÌ dane z prÌjmov zo z·vislej Ëinnosti
if ( $copern == 90 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdrocnedane2strana WHERE oc = $cislo_oc ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$zp2dat = $fir_riadok->zp2dat;
$zp2datsk =SkDatum($zp2dat);
$zp2dak = $fir_riadok->zp2dak;
$zp2daksk =SkDatum($zp2dak);
$zp2hod = $fir_riadok->zp2hod;
if ( $fir_riadok->zp2hod == 0 ) $zp2hod="";
if ( $fir_riadok->zp2dat == '0000-00-00' ) $zp2datsk="";
if ( $fir_riadok->zp2dak == '0000-00-00' ) $zp2daksk="";
mysql_free_result($fir_vysledok);

$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/potvrdzapldan_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/potvrdzapldan_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany);
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


//statna prislusnost z statistiky treximaoc
$statznec="SK";
$sqlttt = "SELECT * FROM F$kli_vxcf"."_treximaoc WHERE idec = $cislo_oc LIMIT 1 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $statznec=trim($riaddok->stprisl);
  }
if ( $statznec == '' ) { $statznec="SK"; }

//titul za zo ziadosti o rz
$titulza="";
$sqlttt = "SELECT * FROM F$kli_vxcf"."_rocneziadost WHERE oc = $cislo_oc LIMIT 1 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $titulza=trim($riaddok->ztitl);
  }

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdrocnedane".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdrocnedane.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdrocnedane.oc = $cislo_oc AND konx1 = 2 ORDER BY konx1,prie,meno";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ( $i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

  $ozam_np = $hlavicka->ozam_np;
  $pole = explode(".", $ozam_np);
  $Cozam_np = $pole[0];
  $Dozam_np = substr($pole[1],0,1);

$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);

if ( File_Exists('../dokumenty/dan_z_prijmov2013/dan_zo_zavislej2013/rz/rz_potvrdenie_dane_v13.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dan_zo_zavislej2013/rz/rz_potvrdenie_dane_v13.jpg',0,0,210,297);
}

//za rok
$pdf->Cell(190,24," ","$rmc1",1,"L");
$pdf->Cell(155,4," ","$rmc1",0,"L");$pdf->Cell(35,4,"$kli_vrok","$rmc",0,"L");

//I. ZAMESTNANEC
$pdf->Cell(190,25," ","$rmc1",1,"L");
$pdf->Cell(18,4," ","$rmc1",0,"L");$pdf->Cell(63,6,"$hlavicka->prie","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(35,6,"$hlavicka->meno","$rmc",0,"L");
$dar=SkDatum($hlavicka->dar);
$tlacrd="$hlavicka->rdc / $hlavicka->rdk";
if ( $tlacrd == "0 / " ) { $tlacrd="$dar"; }
$pdf->Cell(24,4," ","$rmc1",0,"L");$pdf->Cell(34,6,"$tlacrd","$rmc",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(190,1,"                          ","$rmc1",1,"L");
$pdf->Cell(42,4," ","$rmc1",0,"L");$pdf->Cell(25,4,"$hlavicka->titl","$rmc",0,"L");$pdf->Cell(63,4," ","$rmc1",0,"L");$pdf->Cell(27,4,"$titulza","$rmc",1,"L");
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$pdf->Cell(26,5," ","$rmc1",0,"L");$pdf->Cell(75,5,"$hlavicka->zuli","$rmc",0,"L");$pdf->Cell(9,5," ","$rmc1",0,"L");$pdf->Cell(28,5,"$hlavicka->zcdm","$rmc",0,"L");
$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(32,5,"$hlavicka->zpsc","$rmc",1,"L");
$pdf->Cell(27,5," ","$rmc1",0,"L");$pdf->Cell(74,4,"$hlavicka->zmes","$rmc",0,"L");$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(70,4,"$statznec","$rmc",1,"L");
$pdf->SetFont('arial','',10);

//II. ZAMESTNAVATEL
//FO
$pdf->Cell(190,19,"                          ","$rmc1",1,"L");
$pdf->Cell(18,4," ","$rmc1",0,"L");$pdf->Cell(63,7,"$dprie","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(35,7,"$dmeno","$rmc",0,"L");
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(50,7,"$dtitl $dtitz","$rmc",1,"L");
//PO
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$pdf->Cell(28,4," ","$rmc1",0,"L");$pdf->Cell(150,7,"$fir_fnaz","$rmc",1,"L");
//adresa
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$pdf->Cell(26,5," ","$rmc1",0,"L");$pdf->Cell(75,6,"$duli","$rmc",0,"L");$pdf->Cell(9,5," ","$rmc1",0,"L");$pdf->Cell(28,6,"$dcdm","$rmc",0,"L");
$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(32,6,"$dpsc","$rmc",1,"L");
$pdf->Cell(27,5," ","$rmc1",0,"L");$pdf->Cell(74,4,"$dmes","$rmc",0,"L");$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(69,4,"$dstat","$rmc",1,"L");
//danove
$pdf->Cell(26,5," ","$rmc1",0,"L");$pdf->Cell(46,7,"$fir_fdic","$rmc",0,"L");$pdf->Cell(45,5," ","$rmc1",0,"L");$pdf->Cell(61,7,"DaÚov˝ ˙rad $fir_uctt01","$rmc",1,"L");

//UDAJE
$pdf->Cell(190,10,"                          ","$rmc1",1,"L");
$r06=$hlavicka->r06;
$Cislo=$r06+"";
$r06=sprintf("%0.2f", $Cislo);
if ( $r06 == 0.00 ) $r06="";
$r10=$hlavicka->r10;
$Cislo=$r10+"";
$r10=sprintf("%0.2f", $Cislo);
if ( $hlavicka->r10 == 0.00 ) $r10="";
$roz=$hlavicka->r06-$hlavicka->r10;
if ( $roz < 0 ) $roz=0;
$Cislo=$roz+"";
$roz=sprintf("%0.2f", $Cislo);
if ( $roz == 0.00 ) $roz="";
$r17n=$hlavicka->r17n;
$Cislo=$r17n+"";
$r17n=sprintf("%0.2f", $Cislo);
if ( $hlavicka->r17n == 0.00 ) $r17n="";
$pdf->Cell(150,11," ","$rmc1",0,"L");$pdf->Cell(28,10,"$r06","$rmc",1,"R");
$pdf->Cell(150,10," ","$rmc1",0,"L");$pdf->Cell(28,11,"$r10","$rmc",1,"R");
$pdf->Cell(150,10," ","$rmc1",0,"L");$pdf->Cell(28,10,"$roz","$rmc",1,"R");
$pdf->Cell(150,6," ","$rmc1",0,"L");$pdf->Cell(28,7,"$r17n","$rmc",1,"R");
$pdf->Cell(158,7," ","$rmc1",0,"L");$pdf->Cell(20,6,"$zp2daksk","$rmc",1,"R");
$pdf->Cell(150,6," ","$rmc1",0,"L");$pdf->Cell(28,8,"$zp2hod","$rmc",1,"R");

//Vypracoval
$pdf->Cell(190,19,"                          ","$rmc1",1,"L");
$pdf->Cell(50,5," ","$rmc1",0,"L");$pdf->Cell(47,5,"$kli_uzprie $kli_uzmeno","$rmc",0,"L");$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(42,5,"$zp2datsk","$rmc",1,"C");
}
$i = $i + 1;
  }
$pdf->Output("$outfilex");
?>

<script type="text/javascript">
 var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>

<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA Potvrdenie o zaplatenÌ dane z prÌjmov zo z·vislej Ëinnosti
?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
$cislista = include("mzd_lista_norm.php");
} while (false);
?>
</BODY>
</HTML>