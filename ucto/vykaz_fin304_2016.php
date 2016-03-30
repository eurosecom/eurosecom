<!doctype html>
<HTML>
<?php
//celkovy zaciatok
do
{
$sys = 'UCT';
$urov = 3000;
$copern = $_REQUEST['copern'];

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//ramcek fpdf 1=zap,0=vyp
$rmc=1;
$rmc1=0;

//.jpg podklad
$jpg_cesta="../dokumenty/statistika2016/fin304/fin3-04_v16";
$jpg_popis="Finanèný výkaz o finanèných aktívach pod¾a sektorov subjektu verejnej správy FIN 3-04 za rok ".$kli_vrok;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=9999;

if ( $cislo_oc == 0 ) $cislo_oc=1;
if ( $cislo_oc == 1 ) { $datum="31.03.".$kli_vrok; $mesiac="03"; $kli_vume="3.".$kli_vrok; }
if ( $cislo_oc == 2 ) { $datum="30.06.".$kli_vrok; $mesiac="06"; $kli_vume="6.".$kli_vrok; }
if ( $cislo_oc == 3 ) { $datum="30.09.".$kli_vrok; $mesiac="09"; $kli_vume="9.".$kli_vrok; }
if ( $cislo_oc == 4 ) { $datum="31.12.".$kli_vrok; $mesiac="12"; $kli_vume="12.".$kli_vrok; }


$vsetkyprepocty=0;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//ak nie je generovanie daj standardne
$niejegen=0;
$sql = "SELECT * FROM F".$kli_vxcf."_genfin304 ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$copern=1001;
$niejegen=1;
}
//koniec ak nie je generovanie daj standardne


//Tabulka generovania
if ( $copern == 1001 )
{

$sql = "DROP TABLE F$kli_vxcf"."_genfin304";
$vysledok = mysql_query("$sql");

$sqlt = <<<crf204nuj_no
(
   cpl         int not null auto_increment,
   uce         VARCHAR(10),
   crs         INT,
   cpl01       INT,
   PRIMARY KEY(cpl)
);
crf204nuj_no;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_genfin304'.$sqlt;
$vysledek = mysql_query("$sql");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin304 ( uce,crs ) VALUES ( '012', '2' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin304 ( uce,crs ) VALUES ( '014', '2' ); "; $ulozene = mysql_query("$sqult");


$nacitajgen = 1*$_REQUEST['nacitajgen'];
if ( $nacitajgen == 1 ) {
?>
<script type="text/javascript">
 window.open('../ucto/fin_cis.php?copern=308&drupoh=93&page=1&sysx=UCT', '_self');
</script>
<?php
exit;
                      }
$copern=20;
}
//koniec Tabulka generovania


//znovu nacitaj
if ( $copern == 26 )
    {
//echo "citam";
$nasielvyplnene=0;

$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin304 WHERE oc = $cislo_oc ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $nasielvyplnene=1;

  $riaddok=mysql_fetch_object($sqldok);
  $xokres=1*$riaddok->okres;
  $xobec=1*$riaddok->obec;
  }

$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin304 WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");
$copern=20;
if( $zupravy == 1 ) $copern=20;
$subor=1;
$vsetkyprepocty=1;
    }
//koniec znovu nacitaj


//zapis upravene udaje
if ( $copern == 23 )
     {
if ( $strana == 1 ) {
//$okres = strip_tags($_REQUEST['okres']);
//$obec = strip_tags($_REQUEST['obec']);
$daz = $_REQUEST['daz'];
$daz_sql = SqlDatum($daz);

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin304 SET ".
" daz='$daz_sql' ".
" WHERE oc = $cislo_oc"; 
                    }

if ( $strana == 2 ) {
$pocs01 = 1*$_REQUEST['pocs01'];
$pocs02 = 1*$_REQUEST['pocs02'];
$pocs03 = 1*$_REQUEST['pocs03'];
$pocs04 = 1*$_REQUEST['pocs04'];
$pocs05 = 1*$_REQUEST['pocs05'];
$pocs06 = 1*$_REQUEST['pocs06'];
$pocs07 = 1*$_REQUEST['pocs07'];
$pocs08 = 1*$_REQUEST['pocs08'];
$pocs09 = 1*$_REQUEST['pocs09'];
$pocs10 = 1*$_REQUEST['pocs10'];
$zvys01 = 1*$_REQUEST['zvys01'];
$zvys02 = 1*$_REQUEST['zvys02'];
$zvys03 = 1*$_REQUEST['zvys03'];
$zvys04 = 1*$_REQUEST['zvys04'];
$zvys05 = 1*$_REQUEST['zvys05'];
$zvys06 = 1*$_REQUEST['zvys06'];
$zvys07 = 1*$_REQUEST['zvys07'];
$zvys08 = 1*$_REQUEST['zvys08'];
$zvys09 = 1*$_REQUEST['zvys09'];
$zvys10 = 1*$_REQUEST['zvys10'];
$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin304 SET ".
" pocs01='$pocs01', pocs02='$pocs02', pocs03='$pocs03', pocs04='$pocs04', pocs05='$pocs05',
  pocs06='$pocs06', pocs07='$pocs07', pocs08='$pocs08', pocs09='$pocs09', pocs10='$pocs10',
  zvys01='$zvys01', zvys02='$zvys02', zvys03='$zvys03', zvys04='$zvys04', zvys05='$zvys05',
  zvys06='$zvys06', zvys07='$zvys07', zvys08='$zvys08', zvys09='$zvys09', zvys10='$zvys10' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 3 ) {
$znis01 = 1*$_REQUEST['znis01'];
$znis02 = 1*$_REQUEST['znis02'];
$znis03 = 1*$_REQUEST['znis03'];
$znis04 = 1*$_REQUEST['znis04'];
$znis05 = 1*$_REQUEST['znis05'];
$znis06 = 1*$_REQUEST['znis06'];
$znis07 = 1*$_REQUEST['znis07'];
$znis08 = 1*$_REQUEST['znis08'];
$znis09 = 1*$_REQUEST['znis09'];
$znis10 = 1*$_REQUEST['znis10'];
$oces01 = 1*$_REQUEST['oces01'];
$oces02 = 1*$_REQUEST['oces02'];
$oces03 = 1*$_REQUEST['oces03'];
$oces04 = 1*$_REQUEST['oces04'];
$oces05 = 1*$_REQUEST['oces05'];
$oces06 = 1*$_REQUEST['oces06'];
$oces07 = 1*$_REQUEST['oces07'];
$oces08 = 1*$_REQUEST['oces08'];
$oces09 = 1*$_REQUEST['oces09'];
$oces10 = 1*$_REQUEST['oces10'];
$osts01 = 1*$_REQUEST['osts01'];
$osts02 = 1*$_REQUEST['osts02'];
$osts03 = 1*$_REQUEST['osts03'];
$osts04 = 1*$_REQUEST['osts04'];
$osts05 = 1*$_REQUEST['osts05'];
$osts06 = 1*$_REQUEST['osts06'];
$osts07 = 1*$_REQUEST['osts07'];
$osts08 = 1*$_REQUEST['osts08'];
$osts09 = 1*$_REQUEST['osts09'];
$osts10 = 1*$_REQUEST['osts10'];
$zoss01 = 1*$_REQUEST['zoss01'];
$zoss02 = 1*$_REQUEST['zoss02'];
$zoss03 = 1*$_REQUEST['zoss03'];
$zoss04 = 1*$_REQUEST['zoss04'];
$zoss05 = 1*$_REQUEST['zoss05'];
$zoss06 = 1*$_REQUEST['zoss06'];
$zoss07 = 1*$_REQUEST['zoss07'];
$zoss08 = 1*$_REQUEST['zoss08'];
$zoss09 = 1*$_REQUEST['zoss09'];
$zoss10 = 1*$_REQUEST['zoss10'];
$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin304 SET ".
" znis01='$znis01', znis02='$znis02', znis03='$znis03', znis04='$znis04', znis05='$znis05',
  znis06='$znis06', znis07='$znis07', znis08='$znis08', znis09='$znis09', znis10='$znis10',
  oces01='$oces01', oces02='$oces02', oces03='$oces03', oces04='$oces04', oces05='$oces05',
  oces06='$oces06', oces07='$oces07', oces08='$oces08', oces09='$oces09', oces10='$oces10',
  osts01='$osts01', osts02='$osts02', osts03='$osts03', osts04='$osts04', osts05='$osts05',
  osts06='$osts06', osts07='$osts07', osts08='$osts08', osts09='$osts09', osts10='$osts10',
  zoss01='$zoss01', zoss02='$zoss02', zoss03='$zoss03', zoss04='$zoss04', zoss05='$zoss05',
  zoss06='$zoss06', zoss07='$zoss07', zoss08='$zoss08', zoss09='$zoss09', zoss10='$zoss10' ".
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
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ" ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }
//koniec zapisu upravenych udajov

//prac.subor a subor 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$sql = "SELECT pocs01 FROM F".$kli_vxcf."_uctvykaz_fin304";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin304';
$vysledok = mysql_query("$sqlt");

$pocdes="10,2";
$sqlt = <<<mzdprc
(
   px08         DECIMAL($pocdes) DEFAULT 0,
   oc           INT(7) DEFAULT 0,
   druh         DECIMAL(10,0) DEFAULT 0,
   okres        VARCHAR(11),
   obec         VARCHAR(11),
   daz          DATE,
   kor          INT,
   prx          INT,
   uce          VARCHAR(11),
   ucm          VARCHAR(11),
   ucd          VARCHAR(11),
   rdk          INT,
   prv          INT,
   hod          DECIMAL($pocdes),
   mdt          DECIMAL($pocdes),
   dal          DECIMAL($pocdes),
   pocs01       DECIMAL($pocdes),
   pocs02       DECIMAL($pocdes),
   pocs03       DECIMAL($pocdes),
   pocs04       DECIMAL($pocdes),
   pocs05       DECIMAL($pocdes),
   pocs06       DECIMAL($pocdes),
   pocs07       DECIMAL($pocdes),
   pocs08       DECIMAL($pocdes),
   pocs09       DECIMAL($pocdes),
   pocs10       DECIMAL($pocdes),

   zvys01       DECIMAL($pocdes),
   zvys02       DECIMAL($pocdes),
   zvys03       DECIMAL($pocdes),
   zvys04       DECIMAL($pocdes),
   zvys05       DECIMAL($pocdes),
   zvys06       DECIMAL($pocdes),
   zvys07       DECIMAL($pocdes),
   zvys08       DECIMAL($pocdes),
   zvys09       DECIMAL($pocdes),
   zvys10       DECIMAL($pocdes),

   znis01       DECIMAL($pocdes),
   znis02       DECIMAL($pocdes),
   znis03       DECIMAL($pocdes),
   znis04       DECIMAL($pocdes),
   znis05       DECIMAL($pocdes),
   znis06       DECIMAL($pocdes),
   znis07       DECIMAL($pocdes),
   znis08       DECIMAL($pocdes),
   znis09       DECIMAL($pocdes),
   znis10       DECIMAL($pocdes),

   oces01       DECIMAL($pocdes),
   oces02       DECIMAL($pocdes),
   oces03       DECIMAL($pocdes),
   oces04       DECIMAL($pocdes),
   oces05       DECIMAL($pocdes),
   oces06       DECIMAL($pocdes),
   oces07       DECIMAL($pocdes),
   oces08       DECIMAL($pocdes),
   oces09       DECIMAL($pocdes),
   oces10       DECIMAL($pocdes),

   osts01       DECIMAL($pocdes),
   osts02       DECIMAL($pocdes),
   osts03       DECIMAL($pocdes),
   osts04       DECIMAL($pocdes),
   osts05       DECIMAL($pocdes),
   osts06       DECIMAL($pocdes),
   osts07       DECIMAL($pocdes),
   osts08       DECIMAL($pocdes),
   osts09       DECIMAL($pocdes),
   osts10       DECIMAL($pocdes),

   zoss01       DECIMAL($pocdes),
   zoss02       DECIMAL($pocdes),
   zoss03       DECIMAL($pocdes),
   zoss04       DECIMAL($pocdes),
   zoss05       DECIMAL($pocdes),
   zoss06       DECIMAL($pocdes),
   zoss07       DECIMAL($pocdes),
   zoss08       DECIMAL($pocdes),
   zoss09       DECIMAL($pocdes),
   zoss10       DECIMAL($pocdes),

   ico           INT
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctvykaz_fin304'.$sqlt;
$vytvor = mysql_query("$vsql");
}
//koniec vytvorenie 


$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_fin304";
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_fin304";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
//exit;


$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin304 WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $jepotvrd=1;
  }
if ( $jepotvrd == 0 ) $subor=1;

//vytvor pracovny subor
if ( $subor == 1 )
{

//zober data z kun
$sql = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $meno=$riaddok->meno;
  }

$ttvv = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid ".
" ( oc   ) VALUES ".
" ( '$cislo_oc' )";
//$ttqq = mysql_query("$ttvv");

/////////////////////////////////nacitaj hodnoty z ucta do suboru
echo "Naèítavam hodnoty";

//zober pociatocny stav uctov
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" pmd,$cislo_oc,0,'','','0000-00-00',".
" 0,0,uce,uce,0,0,0,0,pmd,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"$fir_fico FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pmd != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" -pda,$cislo_oc,0,'','','0000-00-00',".
" 0,0,uce,uce,0,0,0,0,0,pda,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"$fir_fico FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pda != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//exit;

$psys=1;
while ($psys <= 9 ) 
  {
//zober prijmove pokl
if( $psys == 1 ) { $uctovanie="uctpokuct"; $doklad="pokpri"; }
//zober vydavkove pokl
if( $psys == 2 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psys == 3 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psys == 4 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }
//zober odberatelske
if( $psys == 5 ) { $uctovanie="uctodb"; $doklad="fakodb"; }
//zober dodavatelske
if( $psys == 6 ) { $uctovanie="uctdod"; $doklad="fakdod"; }
//zober majetok
if( $psys == 7 ) { $uctovanie="uctmaj"; }
//zober majetok
if( $psys == 8 ) { $uctovanie="uctskl"; }
//zober mzdy
if( $psys == 9 ) { $uctovanie="uctmzd"; }

if( $psys <= 6 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
"0,0,ucm,ucm,0,0,0,0,F$kli_vxcf"."_$uctovanie.hod,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucm > 0 AND ume <= $kli_vume";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
" 0,0,ucd,0,ucd,0,0,0,0,F$kli_vxcf"."_$uctovanie.hod,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucd > 0 AND ume <= $kli_vume";
$dsql = mysql_query("$dsqlt");

}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
" 0,0,ucm,ucm,0,0,0,0,SUM(hod),0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie".
" WHERE ( ucm > 0 AND ume <= $kli_vume ) GROUP BY F$kli_vxcf"."_$uctovanie.ucm";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
" 0,0,ucd,0,ucd,0,0,0,0,SUM(hod),".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie".
" WHERE ( ucd > 0 AND ume <= $kli_vume ) GROUP BY F$kli_vxcf"."_$uctovanie.ucd";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid,F$kli_vxcf"."_genfin304".
" SET rdk=F$kli_vxcf"."_genfin304.crs".
" WHERE LEFT(F$kli_vxcf"."_uctprcvykaz$kli_uzid.uce,3) = LEFT(F$kli_vxcf"."_genfin304.uce,3) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid,F$kli_vxcf"."_genfin304".
" SET rdk=F$kli_vxcf"."_genfin304.crs".
" WHERE F$kli_vxcf"."_uctprcvykaz$kli_uzid.uce = F$kli_vxcf"."_genfin304.uce ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
//exit;

//rozdel do riadkov , vypocitaj netto

$rdk=1;
while ($rdk <= 74 ) 
  {
$crdk=$rdk;
if( $rdk < 10 ) $crdk="0".$rdk;

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET r$crdk=mdt-dal WHERE rdk = $rdk AND kor = 0 ";
if( $rdk > 43 ) { $sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET r$crdk=dal-mdt WHERE rdk = $rdk "; }
$oznac = mysql_query("$sqtoz");

if( $rdk < 44 ) { 
$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET rk$crdk=dal-mdt WHERE rdk = $rdk AND kor = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET rn$crdk=r$crdk-rk$crdk WHERE rdk > 0 ";
$oznac = mysql_query("$sqtoz");

                }

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET rm$crdk=px08 WHERE rdk = $rdk ";
if( $rdk > 43 ) { $sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET rm$crdk=-px08 WHERE rdk = $rdk "; }
$oznac = mysql_query("$sqtoz");

$rdk=$rdk+1;
  }



//sumar za riadky
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid "." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
" 0,1,uce,ucm,ucd,rdk,prv,hod,mdt,dal,".
"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),".
"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),".
"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10),".
"SUM(oces01),SUM(oces02),SUM(oces03),SUM(oces04),SUM(oces05),SUM(oces06),SUM(oces07),SUM(oces08),SUM(oces09),SUM(oces10),".
"SUM(osts01),SUM(osts02),SUM(osts03),SUM(osts04),SUM(osts05),SUM(osts06),SUM(osts07),SUM(osts08),SUM(osts09),SUM(osts10),".
"SUM(zoss01),SUM(zoss02),SUM(zoss03),SUM(zoss04),SUM(zoss05),SUM(zoss06),SUM(zoss07),SUM(zoss08),SUM(zoss09),SUM(zoss10),".
"$fir_fico".
" FROM F$kli_vxcf"."_uctprcvykaz$kli_uzid".
" WHERE rdk > 0".
" GROUP BY prx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");



$dsqlt = "UPDATE F$kli_vxcf"."_uctprcvykaz".$kli_uzid." ".
" SET r11=r11+r12, rk11=rk11+rk12, rn11=rn11+rn12  WHERE oc = $cislo_oc ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." ".
" SELECT * FROM F$kli_vxcf"."_uctprcvykaz".$kli_uzid." WHERE oc = $cislo_oc ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


/////////////////////////////////koniec naCITAJ HODNOTY

//uloz 
$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin304 WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");


$dsqlt = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin304".
" SELECT * FROM F$kli_vxcf"."_uctprcvykazx".$kli_uzid." WHERE oc = $cislo_oc AND prx = 1 ".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

  if ( $nasielvyplnene == 1 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin304 SET okres='$xokres',  obec='$xobec'  WHERE oc = $cislo_oc ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

  }


}
//koniec pracovneho suboru pre rocne 

//vypocty
if ( $copern == 10 OR $copern == 20 )
{



}
//koniec vypocty


//nacitaj udaje pre upravu
if ( $copern == 20 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin304 WHERE oc = $cislo_oc ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

if ( $strana == 1 OR $strana == 9999 )
{
$daz = $fir_riadok->daz;
$daz_sk=SkDatum($daz);
}

if ( $strana == 2 )
{
$pocs01 = $fir_riadok->pocs01;
$pocs02 = $fir_riadok->pocs02;
$pocs03 = $fir_riadok->pocs03;
$pocs04 = $fir_riadok->pocs04;
$pocs05 = $fir_riadok->pocs05;
$pocs06 = $fir_riadok->pocs06;
$pocs07 = $fir_riadok->pocs07;
$pocs08 = $fir_riadok->pocs08;
$pocs09 = $fir_riadok->pocs09;
$pocs10 = $fir_riadok->pocs10;
$zvys01 = $fir_riadok->zvys01;
$zvys02 = $fir_riadok->zvys02;
$zvys03 = $fir_riadok->zvys03;
$zvys04 = $fir_riadok->zvys04;
$zvys05 = $fir_riadok->zvys05;
$zvys06 = $fir_riadok->zvys06;
$zvys07 = $fir_riadok->zvys07;
$zvys08 = $fir_riadok->zvys08;
$zvys09 = $fir_riadok->zvys09;
$zvys10 = $fir_riadok->zvys10;

$r01s01 = $fir_riadok->pocs01;
$r01s02 = $fir_riadok->pocs02;
$r01s03 = $fir_riadok->pocs03;
$r01s04 = $fir_riadok->pocs04;
$r01s05 = $fir_riadok->pocs05;
$r01s06 = $fir_riadok->pocs06;
$r01s07 = $fir_riadok->pocs07;
$r01s08 = $fir_riadok->pocs08;
$r01s09 = $fir_riadok->pocs09;
$r01s10 = $fir_riadok->pocs10;


$r06s01 = $fir_riadok->pocs01;
$r06s02 = $fir_riadok->pocs02;
$r06s03 = $fir_riadok->pocs03;
$r06s04 = $fir_riadok->pocs04;
$r06s05 = $fir_riadok->pocs05;
$r06s06 = $fir_riadok->pocs06;
$r06s07 = $fir_riadok->pocs07;
$r06s08 = $fir_riadok->pocs08;
$r06s09 = $fir_riadok->pocs09;
$r06s10 = $fir_riadok->pocs10;


$r13s01 = $fir_riadok->zvys01;
$r13s02 = $fir_riadok->zvys02;
$r13s03 = $fir_riadok->zvys03;
$r13s04 = $fir_riadok->zvys04;
$r13s05 = $fir_riadok->zvys05;
$r13s06 = $fir_riadok->zvys06;
$r13s07 = $fir_riadok->zvys07;
$r13s08 = $fir_riadok->zvys08;
$r13s09 = $fir_riadok->zvys09;
$r13s10 = $fir_riadok->zvys10;

$r18s01 = $fir_riadok->zvys01;
$r18s02 = $fir_riadok->zvys02;
$r18s03 = $fir_riadok->zvys03;
$r18s04 = $fir_riadok->zvys04;
$r18s05 = $fir_riadok->zvys05;
$r18s06 = $fir_riadok->zvys06;
$r18s07 = $fir_riadok->zvys07;
$r18s08 = $fir_riadok->zvys08;
$r18s09 = $fir_riadok->zvys09;
$r18s10 = $fir_riadok->zvys10;

$r25s01 = $fir_riadok->znis01;
$r25s02 = $fir_riadok->znis02;
$r25s03 = $fir_riadok->znis03;
$r25s04 = $fir_riadok->znis04;
$r25s05 = $fir_riadok->znis05;
$r25s06 = $fir_riadok->znis06;
$r25s07 = $fir_riadok->znis07;
$r25s08 = $fir_riadok->znis08;
$r25s09 = $fir_riadok->znis09;
$r25s10 = $fir_riadok->znis10;


}

if ( $strana == 3 )
{
$znis01 = $fir_riadok->znis01;
$znis02 = $fir_riadok->znis02;
$znis03 = $fir_riadok->znis03;
$znis04 = $fir_riadok->znis04;
$znis05 = $fir_riadok->znis05;
$znis06 = $fir_riadok->znis06;
$znis07 = $fir_riadok->znis07;
$znis08 = $fir_riadok->znis08;
$znis09 = $fir_riadok->znis09;
$znis10 = $fir_riadok->znis10;
$oces01 = $fir_riadok->oces01;
$oces02 = $fir_riadok->oces02;
$oces03 = $fir_riadok->oces03;
$oces04 = $fir_riadok->oces04;
$oces05 = $fir_riadok->oces05;
$oces06 = $fir_riadok->oces06;
$oces07 = $fir_riadok->oces07;
$oces08 = $fir_riadok->oces08;
$oces09 = $fir_riadok->oces09;
$oces10 = $fir_riadok->oces10;
$osts01 = $fir_riadok->osts01;
$osts02 = $fir_riadok->osts02;
$osts03 = $fir_riadok->osts03;
$osts04 = $fir_riadok->osts04;
$osts05 = $fir_riadok->osts05;
$osts06 = $fir_riadok->osts06;
$osts07 = $fir_riadok->osts07;
$osts08 = $fir_riadok->osts08;
$osts09 = $fir_riadok->osts09;
$osts10 = $fir_riadok->osts10;
$zoss01 = $fir_riadok->zoss01;
$zoss02 = $fir_riadok->zoss02;
$zoss03 = $fir_riadok->zoss03;
$zoss04 = $fir_riadok->zoss04;
$zoss05 = $fir_riadok->zoss05;
$zoss06 = $fir_riadok->zoss06;
$zoss07 = $fir_riadok->zoss07;
$zoss08 = $fir_riadok->zoss08;
$zoss09 = $fir_riadok->zoss09;
$zoss10 = $fir_riadok->zoss10;

$r30s01 = $fir_riadok->znis01;
$r30s02 = $fir_riadok->znis02;
$r30s03 = $fir_riadok->znis03;
$r30s04 = $fir_riadok->znis04;
$r30s05 = $fir_riadok->znis05;
$r30s06 = $fir_riadok->znis06;
$r30s07 = $fir_riadok->znis07;
$r30s08 = $fir_riadok->znis08;
$r30s09 = $fir_riadok->znis09;
$r30s10 = $fir_riadok->znis10;

$r39s01 = $fir_riadok->zoss01;
$r39s02 = $fir_riadok->zoss02;
$r39s03 = $fir_riadok->zoss03;
$r39s04 = $fir_riadok->zoss04;
$r39s05 = $fir_riadok->zoss05;
$r39s06 = $fir_riadok->zoss06;
$r39s07 = $fir_riadok->zoss07;
$r39s08 = $fir_riadok->zoss08;
$r39s09 = $fir_riadok->zoss09;
$r39s10 = $fir_riadok->zoss10;

$r44s01 = $fir_riadok->zoss01;
$r44s02 = $fir_riadok->zoss02;
$r44s03 = $fir_riadok->zoss03;
$r44s04 = $fir_riadok->zoss04;
$r44s05 = $fir_riadok->zoss05;
$r44s06 = $fir_riadok->zoss06;
$r44s07 = $fir_riadok->zoss07;
$r44s08 = $fir_riadok->zoss08;
$r44s09 = $fir_riadok->zoss09;
$r44s10 = $fir_riadok->zoss10;
}
mysql_free_result($fir_vysledok);
    }
//koniec nacitania

//6-miestne ico
$fir_ficox=$fir_fico; if ( $fir_ficox < 999999 ) { $fir_ficox="00".$fir_ficox; }

//skrateny datum k
//$skutku=substr($datum,0,6);
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>Výkaz FIN 3-04</title>
<style type="text/css">
img.btn-row-tool {
  width: 20px;
  height: 20px;
}
form input[type=text] {
  height: 16px;
  line-height: 16px;
  padding-left: 2px;
  border: 1px solid #39f;
  font-size: 12px;
}
div.input-echo {
  position: absolute;
  font-size: 16px;
  background-color: #fff;
  font-weight: bold;
}
</style>
<script type="text/javascript">
<?php
//uprava sadzby
  if ( $copern == 20 )
  { 
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
   document.formv1.daz.value = '<?php echo $daz_sk;?>';
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
   document.formv1.pocs01.value = '<?php echo $pocs01; ?>';
   document.formv1.pocs02.value = '<?php echo $pocs02; ?>';
   document.formv1.pocs03.value = '<?php echo $pocs03; ?>';
   document.formv1.pocs04.value = '<?php echo $pocs04; ?>';
   document.formv1.pocs05.value = '<?php echo $pocs05; ?>';
   document.formv1.pocs06.value = '<?php echo $pocs06; ?>';
   document.formv1.pocs07.value = '<?php echo $pocs07; ?>';
   document.formv1.pocs08.value = '<?php echo $pocs08; ?>';
   document.formv1.pocs09.value = '<?php echo $pocs09; ?>';
   document.formv1.pocs10.value = '<?php echo $pocs10; ?>';
   document.formv1.zvys01.value = '<?php echo $zvys01; ?>';
   document.formv1.zvys02.value = '<?php echo $zvys02; ?>';
   document.formv1.zvys03.value = '<?php echo $zvys03; ?>';
   document.formv1.zvys04.value = '<?php echo $zvys04; ?>';
   document.formv1.zvys05.value = '<?php echo $zvys05; ?>';
   document.formv1.zvys06.value = '<?php echo $zvys06; ?>';
   document.formv1.zvys07.value = '<?php echo $zvys07; ?>';
   document.formv1.zvys08.value = '<?php echo $zvys08; ?>';
   document.formv1.zvys09.value = '<?php echo $zvys09; ?>';
   document.formv1.zvys10.value = '<?php echo $zvys10; ?>';
<?php                     } ?>

<?php if ( $strana == 3 ) { ?>
   document.formv1.znis01.value = '<?php echo $znis01; ?>';
   document.formv1.znis02.value = '<?php echo $znis02; ?>';
   document.formv1.znis03.value = '<?php echo $znis03; ?>';
   document.formv1.znis04.value = '<?php echo $znis04; ?>';
   document.formv1.znis05.value = '<?php echo $znis05; ?>';
   document.formv1.znis06.value = '<?php echo $znis06; ?>';
   document.formv1.znis07.value = '<?php echo $znis07; ?>';
   document.formv1.znis08.value = '<?php echo $znis08; ?>';
   document.formv1.znis09.value = '<?php echo $znis09; ?>';
   document.formv1.znis10.value = '<?php echo $znis10; ?>';
   document.formv1.oces01.value = '<?php echo $oces01; ?>';
   document.formv1.oces02.value = '<?php echo $oces02; ?>';
   document.formv1.oces03.value = '<?php echo $oces03; ?>';
   document.formv1.oces04.value = '<?php echo $oces04; ?>';
   document.formv1.oces05.value = '<?php echo $oces05; ?>';
   document.formv1.oces06.value = '<?php echo $oces06; ?>';
   document.formv1.oces07.value = '<?php echo $oces07; ?>';
   document.formv1.oces08.value = '<?php echo $oces08; ?>';
   document.formv1.oces09.value = '<?php echo $oces09; ?>';
   document.formv1.oces10.value = '<?php echo $oces10; ?>';
   document.formv1.osts01.value = '<?php echo $osts01; ?>';
   document.formv1.osts02.value = '<?php echo $osts02; ?>';
   document.formv1.osts03.value = '<?php echo $osts03; ?>';
   document.formv1.osts04.value = '<?php echo $osts04; ?>';
   document.formv1.osts05.value = '<?php echo $osts05; ?>';
   document.formv1.osts06.value = '<?php echo $osts06; ?>';
   document.formv1.osts07.value = '<?php echo $osts07; ?>';
   document.formv1.osts08.value = '<?php echo $osts08; ?>';
   document.formv1.osts09.value = '<?php echo $osts09; ?>';
   document.formv1.osts10.value = '<?php echo $osts10; ?>';
   document.formv1.zoss01.value = '<?php echo $zoss01; ?>';
   document.formv1.zoss02.value = '<?php echo $zoss02; ?>';
   document.formv1.zoss03.value = '<?php echo $zoss03; ?>';
   document.formv1.zoss04.value = '<?php echo $zoss04; ?>';
   document.formv1.zoss05.value = '<?php echo $zoss05; ?>';
   document.formv1.zoss06.value = '<?php echo $zoss06; ?>';
   document.formv1.zoss07.value = '<?php echo $zoss07; ?>';
   document.formv1.zoss08.value = '<?php echo $zoss08; ?>';
   document.formv1.zoss09.value = '<?php echo $zoss09; ?>';
   document.formv1.zoss10.value = '<?php echo $zoss10; ?>';
<?php                     } ?>
    }
<?php
//koniec uprava
  }
?>
<?php
  if ( $copern != 20 )
  { 
?>
  function ObnovUI()
  {
  }
<?php
  }
?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function MetodVypln()
  {
   window.open('<?php echo $jpg_cesta; ?>_vysvetlivky.pdf',
'_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
  function TlacVykaz()
  {
   window.open('vykaz_fin304_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999',
'_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function Nacitaj()
  {
   window.open('vykaz_fin304_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=0',
'_self', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
</script>
</HEAD>
<BODY onload="ObnovUI();">
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
  <td class="header">FIN 3-04 Finanèné aktíva pod¾a sektorov za
   <span style="color:#39f;"><?php echo "$cislo_oc. štvrrok";?></span>
  </td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();" title="Vysvetlivky na vyplnenie výkazu" class="btn-form-tool">
    <img src="../obr/ikony/download_blue_icon.png" onclick="Nacitaj();" title="Naèíta údaje" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();" title="Zobrazi všetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>


<?php
$sirka=950;
$vyska=1300;
if ( $strana == 2 OR $strana == 3 )
{
$sirka=1250; $vyska=920;
}
?>
<div id="content" style="width:<?php echo $sirka; ?>px; height:<?php echo $vyska; ?>px;">
<FORM name="formv1" method="post" action="../ucto/vykaz_fin304_2016.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
if ( $strana == 3 ) $clas3="active";
$source="vykaz_fin304_2016.php";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloži zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str1.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 1.strana 265kB">

<span class="text-echo" style="top:153px; left:403px;"><?php echo $datum; ?></span>
<span class="text-echo" style="top:301px; left:141px;">x</span>
<span class="text-echo" style="top:516px; left:141px; letter-spacing:13.5px;"><?php echo $fir_ficox; ?></span>
<span class="text-echo" style="top:516px; left:342px; letter-spacing:14px;"><?php echo $mesiac; ?></span>
<span class="text-echo" style="top:516px; left:409px; letter-spacing:13.5px;"><?php echo $kli_vrok; ?></span>
<div class="input-echo" style="width:687px; top:574px; left:135px; height:40px; line-height:40px;"><?php echo $fir_fnaz; ?></div>
<div class="input-echo" style="width:687px; top:655px; left:135px; height:19px; line-height:19px; font-size:15px;"><?php echo $fir_uctt02; ?></div>
<div class="input-echo" style="width:687px; top:735.5px; left:135px; height:39.5px; line-height:39.5px;"><?php echo $fir_fuli; ?></div>
<div class="input-echo" style="width:105px; top:816.5px; left:135px; height:19px; line-height:19px;"><?php echo $fir_fpsc; ?></div>
<div class="input-echo" style="width:553px; top:816.5px; left:269px; height:39.5px; line-height:39.5px;"><?php echo $fir_fmes; ?></div>
<div class="input-echo" style="width:687px; top:898px; left:135px; height:19px; line-height:19px; font-size:15px;"><?php echo $fir_fem1; ?></div>
<input type="text" name="daz" id="daz" onkeyup="CiarkaNaBodku(this);"
       style="width:80px; top:966px; left:236px; height:22px; line-height:22px; font-size:14px; padding-left:4px;"/>
<?php                     } ?>


<?php if ( $strana == 2 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str2.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 2.strana 265kB" style="width:1250px; height:1000px;">

<!-- 1.STAV k 1.1. -->
<span class="text-echo" style="top:232px; right:868px;"><?php echo $r01s01; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:232px; right:784px;"><?php echo $r01s02; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:232px; right:700px;"><?php echo $r01s03; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:232px; right:616px;"><?php echo $r01s04; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:232px; right:532px;"><?php echo $r01s05; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:232px; right:439px;"><?php echo $r01s06; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:232px; right:355px;"><?php echo $r01s07; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:232px; right:246px;"><?php echo $r01s08; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:232px; right:162px;"><?php echo $r01s09; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:232px; right:70px;"><?php echo $r01s10; ?></span> <!-- dopyt, rozbeha -->
<!-- 8.uzemna samosprava -->
<?php $top=413; ?>
<input type="text" name="pocs01" id="pocs01" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:295px;"/>
<input type="text" name="pocs02" id="pocs02" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:388px;"/>
<input type="text" name="pocs03" id="pocs03" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:472px;"/>
<input type="text" name="pocs04" id="pocs04" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:556px;"/>
<input type="text" name="pocs05" id="pocs05" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:640px;"/>
<input type="text" name="pocs06" id="pocs06" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:725px;"/>
<input type="text" name="pocs07" id="pocs07" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:817px;"/>
<input type="text" name="pocs08" id="pocs08" onkeyup="CiarkaNaBodku(this);" style="width:98px; top:<?php echo $top; ?>px; left:902px;"/>
<input type="text" name="pocs09" id="pocs09" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:1011px;"/>
<input type="text" name="pocs10" id="pocs10" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:1095px;"/>

<!-- 13.ZVYSENIE -->
<span class="text-echo" style="top:592px; right:868px;"><?php echo $r13s01; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:592px; right:784px;"><?php echo $r13s02; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:592px; right:700px;"><?php echo $r13s03; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:592px; right:616px;"><?php echo $r13s04; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:592px; right:532px;"><?php echo $r13s05; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:592px; right:439px;"><?php echo $r13s06; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:592px; right:355px;"><?php echo $r13s07; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:592px; right:246px;"><?php echo $r13s08; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:592px; right:162px;"><?php echo $r13s09; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:592px; right:70px;"><?php echo $r13s10; ?></span> <!-- dopyt, rozbeha -->
<!-- 20.uzemna samosprava -->
<?php $top=772; ?>
<input type="text" name="zvys01" id="zvys01" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:295px;"/>
<input type="text" name="zvys02" id="zvys02" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:388px;"/>
<input type="text" name="zvys03" id="zvys03" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:472px;"/>
<input type="text" name="zvys04" id="zvys04" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:556px;"/>
<input type="text" name="zvys05" id="zvys05" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:640px;"/>
<input type="text" name="zvys06" id="zvys06" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:725px;"/>
<input type="text" name="zvys07" id="zvys07" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:817px;"/>
<input type="text" name="zvys08" id="zvys08" onkeyup="CiarkaNaBodku(this);" style="width:98px; top:<?php echo $top; ?>px; left:902px;"/>
<input type="text" name="zvys09" id="zvys09" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:1011px;"/>
<input type="text" name="zvys10" id="zvys10" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:1095px;"/>

<!-- 25.ZNIZENIE -->
<span class="text-echo" style="top:916px; right:868px;"><?php echo $r25s01; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:916px; right:784px;"><?php echo $r25s02; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:916px; right:700px;"><?php echo $r25s03; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:916px; right:616px;"><?php echo $r25s04; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:916px; right:532px;"><?php echo $r25s05; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:916px; right:439px;"><?php echo $r25s06; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:916px; right:355px;"><?php echo $r25s07; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:916px; right:246px;"><?php echo $r25s08; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:916px; right:162px;"><?php echo $r25s09; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:916px; right:70px;"><?php echo $r25s10; ?></span> <!-- dopyt, rozbeha -->
<?php                     } ?>


<?php if ( $strana == 3 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str3.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 3.strana 265kB" style="width:1250px; height:1000px;">

<!-- 32.uzemna samosprava -->
<?php $top=221; ?>
<input type="text" name="znis01" id="znis01" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:295px;"/>
<input type="text" name="znis02" id="znis02" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:388px;"/>
<input type="text" name="znis03" id="znis03" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:472px;"/>
<input type="text" name="znis04" id="znis04" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:556px;"/>
<input type="text" name="znis05" id="znis05" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:640px;"/>
<input type="text" name="znis06" id="znis06" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:725px;"/>
<input type="text" name="znis07" id="znis07" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:817px;"/>
<input type="text" name="znis08" id="znis08" onkeyup="CiarkaNaBodku(this);" style="width:98px; top:<?php echo $top; ?>px; left:902px;"/>
<input type="text" name="znis09" id="znis09" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:1011px;"/>
<input type="text" name="znis10" id="znis10" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:1095px;"/>

<!-- 37.ZMENY V OCENENI -->
<?php $top=357; ?>
<input type="text" name="oces01" id="oces01" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:295px;"/>
<input type="text" name="oces02" id="oces02" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:388px;"/>
<input type="text" name="oces03" id="oces03" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:472px;"/>
<input type="text" name="oces04" id="oces04" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:556px;"/>
<input type="text" name="oces05" id="oces05" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:640px;"/>
<input type="text" name="oces06" id="oces06" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:725px;"/>
<input type="text" name="oces07" id="oces07" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:817px;"/>
<input type="text" name="oces08" id="oces08" onkeyup="CiarkaNaBodku(this);" style="width:98px; top:<?php echo $top; ?>px; left:902px;"/>
<input type="text" name="oces09" id="oces09" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:1011px;"/>
<input type="text" name="oces10" id="oces10" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:1095px;"/>

<!-- 38.OSTATNE ZMENY -->
<?php $top=393; ?>
<input type="text" name="osts01" id="osts01" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:295px;"/>
<input type="text" name="osts02" id="osts02" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:388px;"/>
<input type="text" name="osts03" id="osts03" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:472px;"/>
<input type="text" name="osts04" id="osts04" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:556px;"/>
<input type="text" name="osts05" id="osts05" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:640px;"/>
<input type="text" name="osts06" id="osts06" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:725px;"/>
<input type="text" name="osts07" id="osts07" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:817px;"/>
<input type="text" name="osts08" id="osts08" onkeyup="CiarkaNaBodku(this);" style="width:98px; top:<?php echo $top; ?>px; left:902px;"/>
<input type="text" name="osts09" id="osts09" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:1011px;"/>
<input type="text" name="osts10" id="osts10" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:1095px;"/>

<!-- 39.STAV k 31.12. -->
<span class="text-echo" style="top:452px; right:868px;"><?php echo $r39s01; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:452px; right:784px;"><?php echo $r39s02; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:452px; right:700px;"><?php echo $r39s03; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:452px; right:616px;"><?php echo $r39s04; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:452px; right:532px;"><?php echo $r39s05; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:452px; right:439px;"><?php echo $r39s06; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:452px; right:355px;"><?php echo $r39s07; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:452px; right:246px;"><?php echo $r39s08; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:452px; right:162px;"><?php echo $r39s09; ?></span> <!-- dopyt, rozbeha -->
<span class="text-echo" style="top:452px; right:70px;"><?php echo $r39s10; ?></span> <!-- dopyt, rozbeha -->
<!-- 46.uzemna samosprava -->
<?php $top=633; ?>
<input type="text" name="zoss01" id="zoss01" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:295px;"/>
<input type="text" name="zoss02" id="zoss02" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:388px;"/>
<input type="text" name="zoss03" id="zoss03" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:472px;"/>
<input type="text" name="zoss04" id="zoss04" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:556px;"/>
<input type="text" name="zoss05" id="zoss05" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:640px;"/>
<input type="text" name="zoss06" id="zoss06" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:725px;"/>
<input type="text" name="zoss07" id="zoss07" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:817px;"/>
<input type="text" name="zoss08" id="zoss08" onkeyup="CiarkaNaBodku(this);" style="width:98px; top:<?php echo $top; ?>px; left:902px;"/>
<input type="text" name="zoss09" id="zoss09" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:1011px;"/>
<input type="text" name="zoss10" id="zoss10" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:<?php echo $top; ?>px; left:1095px;"/>
<?php                     } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloži zmeny" class="btn-bottom-formsave">
</div>

</FORM>
</div> <!-- #content -->
<?php
     }
//koniec uprav
?>

<?php
/////////////////////////////////////////////////VYTLAC
if ( $copern == 10 )
{
if ( File_Exists("../tmp/vykazfin.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/vykazfin.$kli_uzid.pdf"); }
   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin304".
" WHERE F$kli_vxcf"."_uctvykaz_fin304.oc = $cislo_oc  ORDER BY oc";

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
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str1.jpg') )
{
$pdf->Image($jpg_cesta.'_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//obdobie k
$text=$datum;
$pdf->Cell(195,19," ","$rmc1",1,"L");
$pdf->Cell(78,6," ","$rmc1",0,"R");$pdf->Cell(22,4,"$text","$rmc",1,"C");

//druh vykazu krizik
$text="x";
$pdf->Cell(195,24," ","$rmc1",1,"L");
$pdf->Cell(20,4," ","$rmc1",0,"R");$pdf->Cell(4,3,"$text","$rmc",1,"C");

//ico
$text=$fir_fico;
$textx="12345678";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(195,52," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"R");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(4,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
//mesiac
$text=$mesiac;
$textx="12345678";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
//rok
$text=$kli_vrok;
$textx="1234";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",1,"C");

//nazov subjektu
$text=$fir_fnaz;
$textx="0123456789abcdefghijklmnoprstuv";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(195,8.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");
//
$text=substr($fir_fnaz,31,30);;
$text="Èý0123456789abcdefghijklmnoprstuv";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//pravna forma
$text=$fir_uctt02;
$textx="0123456789abcdefghijklmnoprstuv";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(195,8.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//ulica a cislo
$text=$fir_fuli." ".$fir_fcdm;
$textx="0123456789abcdefghijklmnoprstuv";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(195,13.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");
//
$text=" ";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//psc
$fir_fpsc=str_replace(" ","",$fir_fpsc);
$text=$fir_fpsc;
$textx="123456";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(195,8.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");
//obec
$text=$fir_fmes;
$textx="123456789abcdefghijklmnov";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(4,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",1,"C");
//
$text=" ";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$pdf->Cell(49,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(4,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",1,"C");

//email
$text=$fir_fem1;
$textx="0123456789abcdefghijklmnoprstuv";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(195,8.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//datum zostavenia
$daz= SkDatum($hlavicka->daz);
if ( $daz == '00.00.0000' ) $daz="";
$pdf->Cell(195,12," ","$rmc1",1,"L");
$pdf->Cell(40,5," ","$rmc1",0,"C");$pdf->Cell(22,4,"$daz","$rmc",1,"C");
                                       }

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',8);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str2.jpg') )
{
$pdf->Image($jpg_cesta.'_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//zostatok k
$pdf->Cell(195,17," ","$rmc1",1,"L");
$pdf->Cell(136,3," ","$rmc1",0,"R");$pdf->Cell(10,4,"$skutku","$rmc",1,"C");

//VYBRANE AKTIVA 
$r01=$hlavicka->r01; if ( $hlavicka->r01 == 0 ) $r01="";
$r02=$hlavicka->r02; if ( $hlavicka->r02 == 0 ) $r02="";
$r03=$hlavicka->r03; if ( $hlavicka->r03 == 0 ) $r03="";
$r04=$hlavicka->r04; if ( $hlavicka->r04 == 0 ) $r04="";
$r05=$hlavicka->r05; if ( $hlavicka->r05 == 0 ) $r05="";
$r06=$hlavicka->r06; if ( $hlavicka->r06 == 0 ) $r06="";
$r07=$hlavicka->r07; if ( $hlavicka->r07 == 0 ) $r07="";
$r08=$hlavicka->r08; if ( $hlavicka->r08 == 0 ) $r08="";
$r09=$hlavicka->r09; if ( $hlavicka->r09 == 0 ) $r09="";
$r10=$hlavicka->r10; if ( $hlavicka->r10 == 0 ) $r10="";
$r11=$hlavicka->r11; if ( $hlavicka->r11 == 0 ) $r11="";
$r12=$hlavicka->r12; if ( $hlavicka->r12 == 0 ) $r12="";
$r13=$hlavicka->r13; if ( $hlavicka->r13 == 0 ) $r13="";
$r14=$hlavicka->r14; if ( $hlavicka->r14 == 0 ) $r14="";
$r15=$hlavicka->r15; if ( $hlavicka->r15 == 0 ) $r15="";
$r16=$hlavicka->r16; if ( $hlavicka->r16 == 0 ) $r16="";
$r17=$hlavicka->r17; if ( $hlavicka->r17 == 0 ) $r17="";
$r18=$hlavicka->r18; if ( $hlavicka->r18 == 0 ) $r18="";
$r19=$hlavicka->r19; if ( $hlavicka->r19 == 0 ) $r19="";
$r20=$hlavicka->r20; if ( $hlavicka->r20 == 0 ) $r20="";
$r21=$hlavicka->r21; if ( $hlavicka->r21 == 0 ) $r21="";
$r22=$hlavicka->r22; if ( $hlavicka->r22 == 0 ) $r22="";
$r23=$hlavicka->r23; if ( $hlavicka->r23 == 0 ) $r23="";
$r24=$hlavicka->r24; if ( $hlavicka->r24 == 0 ) $r24="";
$r25=$hlavicka->r25; if ( $hlavicka->r25 == 0 ) $r25="";
$r26=$hlavicka->r26; if ( $hlavicka->r26 == 0 ) $r26="";
$r27=$hlavicka->r27; if ( $hlavicka->r27 == 0 ) $r27="";
$r28=$hlavicka->r28; if ( $hlavicka->r28 == 0 ) $r28="";
$r29=$hlavicka->r29; if ( $hlavicka->r29 == 0 ) $r29="";
$r30=$hlavicka->r30; if ( $hlavicka->r30 == 0 ) $r30="";
$r31=$hlavicka->r31; if ( $hlavicka->r31 == 0 ) $r31="";
$r32=$hlavicka->r32; if ( $hlavicka->r32 == 0 ) $r32="";
$r33=$hlavicka->r33; if ( $hlavicka->r33 == 0 ) $r33="";
$r34=$hlavicka->r34; if ( $hlavicka->r34 == 0 ) $r34="";
$r35=$hlavicka->r35; if ( $hlavicka->r35 == 0 ) $r35="";
$r36=$hlavicka->r36; if ( $hlavicka->r36 == 0 ) $r36="";
$r37=$hlavicka->r37; if ( $hlavicka->r37 == 0 ) $r37="";
$r38=$hlavicka->r38; if ( $hlavicka->r38 == 0 ) $r38="";
$r39=$hlavicka->r39; if ( $hlavicka->r39 == 0 ) $r39="";
$r40=$hlavicka->r40; if ( $hlavicka->r40 == 0 ) $r40="";
$r41=$hlavicka->r41; if ( $hlavicka->r41 == 0 ) $r41="";
$r42=$hlavicka->r42; if ( $hlavicka->r42 == 0 ) $r42="";
$r43=$hlavicka->r43; if ( $hlavicka->r43 == 0 ) $r43="";

$rk01=$hlavicka->rk01; if ( $hlavicka->rk01 == 0 ) $rk01="";
$rk02=$hlavicka->rk02; if ( $hlavicka->rk02 == 0 ) $rk02="";
$rk03=$hlavicka->rk03; if ( $hlavicka->rk03 == 0 ) $rk03="";
$rk04=$hlavicka->rk04; if ( $hlavicka->rk04 == 0 ) $rk04="";
$rk05=$hlavicka->rk05; if ( $hlavicka->rk05 == 0 ) $rk05="";
$rk06=$hlavicka->rk06; if ( $hlavicka->rk06 == 0 ) $rk06="";
$rk07=$hlavicka->rk07; if ( $hlavicka->rk07 == 0 ) $rk07="";
$rk08=$hlavicka->rk08; if ( $hlavicka->rk08 == 0 ) $rk08="";
$rk09=$hlavicka->rk09; if ( $hlavicka->rk09 == 0 ) $rk09="";
$rk10=$hlavicka->rk10; if ( $hlavicka->rk10 == 0 ) $rk10="";
$rk11=$hlavicka->rk11; if ( $hlavicka->rk11 == 0 ) $rk11="";
$rk12=$hlavicka->rk12; if ( $hlavicka->rk12 == 0 ) $rk12="";
$rk13=$hlavicka->rk13; if ( $hlavicka->rk13 == 0 ) $rk13="";
$rk14=$hlavicka->rk14; if ( $hlavicka->rk14 == 0 ) $rk14="";
$rk15=$hlavicka->rk15; if ( $hlavicka->rk15 == 0 ) $rk15="";
$rk16=$hlavicka->rk16; if ( $hlavicka->rk16 == 0 ) $rk16="";
$rk17=$hlavicka->rk17; if ( $hlavicka->rk17 == 0 ) $rk17="";
$rk18=$hlavicka->rk18; if ( $hlavicka->rk18 == 0 ) $rk18="";
$rk19=$hlavicka->rk19; if ( $hlavicka->rk19 == 0 ) $rk19="";
$rk20=$hlavicka->rk20; if ( $hlavicka->rk20 == 0 ) $rk20="";
$rk21=$hlavicka->rk21; if ( $hlavicka->rk21 == 0 ) $rk21="";
$rk22=$hlavicka->rk22; if ( $hlavicka->rk22 == 0 ) $rk22="";
$rk23=$hlavicka->rk23; if ( $hlavicka->rk23 == 0 ) $rk23="";
$rk24=$hlavicka->rk24; if ( $hlavicka->rk24 == 0 ) $rk24="";
$rk25=$hlavicka->rk25; if ( $hlavicka->rk25 == 0 ) $rk25="";
$rk26=$hlavicka->rk26; if ( $hlavicka->rk26 == 0 ) $rk26="";
$rk27=$hlavicka->rk27; if ( $hlavicka->rk27 == 0 ) $rk27="";
$rk28=$hlavicka->rk28; if ( $hlavicka->rk28 == 0 ) $rk28="";
$rk29=$hlavicka->rk29; if ( $hlavicka->rk29 == 0 ) $rk29="";
$rk30=$hlavicka->rk30; if ( $hlavicka->rk30 == 0 ) $rk30="";
$rk31=$hlavicka->rk31; if ( $hlavicka->rk31 == 0 ) $rk31="";
$rk32=$hlavicka->rk32; if ( $hlavicka->rk32 == 0 ) $rk32="";
$rk33=$hlavicka->rk33; if ( $hlavicka->rk33 == 0 ) $rk33="";
$rk34=$hlavicka->rk34; if ( $hlavicka->rk34 == 0 ) $rk34="";
$rk35=$hlavicka->rk35; if ( $hlavicka->rk35 == 0 ) $rk35="";
$rk36=$hlavicka->rk36; if ( $hlavicka->rk36 == 0 ) $rk36="";
$rk37=$hlavicka->rk37; if ( $hlavicka->rk37 == 0 ) $rk37="";
$rk38=$hlavicka->rk38; if ( $hlavicka->rk38 == 0 ) $rk38="";
$rk39=$hlavicka->rk39; if ( $hlavicka->rk39 == 0 ) $rk39="";
$rk40=$hlavicka->rk40; if ( $hlavicka->rk40 == 0 ) $rk40="";
$rk41=$hlavicka->rk41; if ( $hlavicka->rk41 == 0 ) $rk41="";
$rk42=$hlavicka->rk42; if ( $hlavicka->rk42 == 0 ) $rk42="";
$rk43=$hlavicka->rk43; if ( $hlavicka->rk43 == 0 ) $rk43="";

$rn01=$hlavicka->rn01; if ( $hlavicka->rn01 == 0 ) $rn01="";
$rn02=$hlavicka->rn02; if ( $hlavicka->rn02 == 0 ) $rn02="";
$rn03=$hlavicka->rn03; if ( $hlavicka->rn03 == 0 ) $rn03="";
$rn04=$hlavicka->rn04; if ( $hlavicka->rn04 == 0 ) $rn04="";
$rn05=$hlavicka->rn05; if ( $hlavicka->rn05 == 0 ) $rn05="";
$rn06=$hlavicka->rn06; if ( $hlavicka->rn06 == 0 ) $rn06="";
$rn07=$hlavicka->rn07; if ( $hlavicka->rn07 == 0 ) $rn07="";
$rn08=$hlavicka->rn08; if ( $hlavicka->rn08 == 0 ) $rn08="";
$rn09=$hlavicka->rn09; if ( $hlavicka->rn09 == 0 ) $rn09="";
$rn10=$hlavicka->rn10; if ( $hlavicka->rn10 == 0 ) $rn10="";
$rn11=$hlavicka->rn11; if ( $hlavicka->rn11 == 0 ) $rn11="";
$rn12=$hlavicka->rn12; if ( $hlavicka->rn12 == 0 ) $rn12="";
$rn13=$hlavicka->rn13; if ( $hlavicka->rn13 == 0 ) $rn13="";
$rn14=$hlavicka->rn14; if ( $hlavicka->rn14 == 0 ) $rn14="";
$rn15=$hlavicka->rn15; if ( $hlavicka->rn15 == 0 ) $rn15="";
$rn16=$hlavicka->rn16; if ( $hlavicka->rn16 == 0 ) $rn16="";
$rn17=$hlavicka->rn17; if ( $hlavicka->rn17 == 0 ) $rn17="";
$rn18=$hlavicka->rn18; if ( $hlavicka->rn18 == 0 ) $rn18="";
$rn19=$hlavicka->rn19; if ( $hlavicka->rn19 == 0 ) $rn19="";
$rn20=$hlavicka->rn20; if ( $hlavicka->rn20 == 0 ) $rn20="";
$rn21=$hlavicka->rn21; if ( $hlavicka->rn21 == 0 ) $rn21="";
$rn22=$hlavicka->rn22; if ( $hlavicka->rn22 == 0 ) $rn22="";
$rn23=$hlavicka->rn23; if ( $hlavicka->rn23 == 0 ) $rn23="";
$rn24=$hlavicka->rn24; if ( $hlavicka->rn24 == 0 ) $rn24="";
$rn25=$hlavicka->rn25; if ( $hlavicka->rn25 == 0 ) $rn25="";
$rn26=$hlavicka->rn26; if ( $hlavicka->rn26 == 0 ) $rn26="";
$rn27=$hlavicka->rn27; if ( $hlavicka->rn27 == 0 ) $rn27="";
$rn28=$hlavicka->rn28; if ( $hlavicka->rn28 == 0 ) $rn28="";
$rn29=$hlavicka->rn29; if ( $hlavicka->rn29 == 0 ) $rn29="";
$rn30=$hlavicka->rn30; if ( $hlavicka->rn30 == 0 ) $rn30="";
$rn31=$hlavicka->rn31; if ( $hlavicka->rn31 == 0 ) $rn31="";
$rn32=$hlavicka->rn32; if ( $hlavicka->rn32 == 0 ) $rn32="";
$rn33=$hlavicka->rn33; if ( $hlavicka->rn33 == 0 ) $rn33="";
$rn34=$hlavicka->rn34; if ( $hlavicka->rn34 == 0 ) $rn34="";
$rn35=$hlavicka->rn35; if ( $hlavicka->rn35 == 0 ) $rn35="";
$rn36=$hlavicka->rn36; if ( $hlavicka->rn36 == 0 ) $rn36="";
$rn37=$hlavicka->rn37; if ( $hlavicka->rn37 == 0 ) $rn37="";
$rn38=$hlavicka->rn38; if ( $hlavicka->rn38 == 0 ) $rn38="";
$rn39=$hlavicka->rn39; if ( $hlavicka->rn39 == 0 ) $rn39="";
$rn40=$hlavicka->rn40; if ( $hlavicka->rn40 == 0 ) $rn40="";
$rn41=$hlavicka->rn41; if ( $hlavicka->rn41 == 0 ) $rn41="";
$rn42=$hlavicka->rn42; if ( $hlavicka->rn42 == 0 ) $rn42="";
$rn43=$hlavicka->rn43; if ( $hlavicka->rn43 == 0 ) $rn43="";

$rm01=$hlavicka->rm01; if ( $hlavicka->rm01 == 0 ) $rm01="";
$rm02=$hlavicka->rm02; if ( $hlavicka->rm02 == 0 ) $rm02="";
$rm03=$hlavicka->rm03; if ( $hlavicka->rm03 == 0 ) $rm03="";
$rm04=$hlavicka->rm04; if ( $hlavicka->rm04 == 0 ) $rm04="";
$rm05=$hlavicka->rm05; if ( $hlavicka->rm05 == 0 ) $rm05="";
$rm06=$hlavicka->rm06; if ( $hlavicka->rm06 == 0 ) $rm06="";
$rm07=$hlavicka->rm07; if ( $hlavicka->rm07 == 0 ) $rm07="";
$rm08=$hlavicka->rm08; if ( $hlavicka->rm08 == 0 ) $rm08="";
$rm09=$hlavicka->rm09; if ( $hlavicka->rm09 == 0 ) $rm09="";
$rm10=$hlavicka->rm10; if ( $hlavicka->rm10 == 0 ) $rm10="";
$rm11=$hlavicka->rm11; if ( $hlavicka->rm11 == 0 ) $rm11="";
$rm12=$hlavicka->rm12; if ( $hlavicka->rm12 == 0 ) $rm12="";
$rm13=$hlavicka->rm13; if ( $hlavicka->rm13 == 0 ) $rm13="";
$rm14=$hlavicka->rm14; if ( $hlavicka->rm14 == 0 ) $rm14="";
$rm15=$hlavicka->rm15; if ( $hlavicka->rm15 == 0 ) $rm15="";
$rm16=$hlavicka->rm16; if ( $hlavicka->rm16 == 0 ) $rm16="";
$rm17=$hlavicka->rm17; if ( $hlavicka->rm17 == 0 ) $rm17="";
$rm18=$hlavicka->rm18; if ( $hlavicka->rm18 == 0 ) $rm18="";
$rm19=$hlavicka->rm19; if ( $hlavicka->rm19 == 0 ) $rm19="";
$rm20=$hlavicka->rm20; if ( $hlavicka->rm20 == 0 ) $rm20="";
$rm21=$hlavicka->rm21; if ( $hlavicka->rm21 == 0 ) $rm21="";
$rm22=$hlavicka->rm22; if ( $hlavicka->rm22 == 0 ) $rm22="";
$rm23=$hlavicka->rm23; if ( $hlavicka->rm23 == 0 ) $rm23="";
$rm24=$hlavicka->rm24; if ( $hlavicka->rm24 == 0 ) $rm24="";
$rm25=$hlavicka->rm25; if ( $hlavicka->rm25 == 0 ) $rm25="";
$rm26=$hlavicka->rm26; if ( $hlavicka->rm26 == 0 ) $rm26="";
$rm27=$hlavicka->rm27; if ( $hlavicka->rm27 == 0 ) $rm27="";
$rm28=$hlavicka->rm28; if ( $hlavicka->rm28 == 0 ) $rm28="";
$rm29=$hlavicka->rm29; if ( $hlavicka->rm29 == 0 ) $rm29="";
$rm30=$hlavicka->rm30; if ( $hlavicka->rm30 == 0 ) $rm30="";
$rm31=$hlavicka->rm31; if ( $hlavicka->rm31 == 0 ) $rm31="";
$rm32=$hlavicka->rm32; if ( $hlavicka->rm32 == 0 ) $rm32="";
$rm33=$hlavicka->rm33; if ( $hlavicka->rm33 == 0 ) $rm33="";
$rm34=$hlavicka->rm34; if ( $hlavicka->rm34 == 0 ) $rm34="";
$rm35=$hlavicka->rm35; if ( $hlavicka->rm35 == 0 ) $rm35="";
$rm36=$hlavicka->rm36; if ( $hlavicka->rm36 == 0 ) $rm36="";
$rm37=$hlavicka->rm37; if ( $hlavicka->rm37 == 0 ) $rm37="";
$rm38=$hlavicka->rm38; if ( $hlavicka->rm38 == 0 ) $rm38="";
$rm39=$hlavicka->rm39; if ( $hlavicka->rm39 == 0 ) $rm39="";
$rm40=$hlavicka->rm40; if ( $hlavicka->rm40 == 0 ) $rm40="";
$rm41=$hlavicka->rm41; if ( $hlavicka->rm41 == 0 ) $rm41="";
$rm42=$hlavicka->rm42; if ( $hlavicka->rm42 == 0 ) $rm42="";
$rm43=$hlavicka->rm43; if ( $hlavicka->rm43 == 0 ) $rm43="";
$pdf->Cell(195,15," ","$rmc1",1,"L");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r01","$rmc",0,"R");$pdf->Cell(17,6,"$rk01","$rmc",0,"R");
$pdf->Cell(17,6,"$rn01","$rmc",0,"R");$pdf->Cell(30,6,"$rm01","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r02","$rmc",0,"R");$pdf->Cell(17,6,"$rk02","$rmc",0,"R");
$pdf->Cell(17,6,"$rn02","$rmc",0,"R");$pdf->Cell(30,6,"$rm02","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r03","$rmc",0,"R");$pdf->Cell(17,5,"$rk03","$rmc",0,"R");
$pdf->Cell(17,5,"$rn03","$rmc",0,"R");$pdf->Cell(30,5,"$rm03","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r04","$rmc",0,"R");$pdf->Cell(17,6,"$rk04","$rmc",0,"R");
$pdf->Cell(17,6,"$rn04","$rmc",0,"R");$pdf->Cell(30,6,"$rm04","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r05","$rmc",0,"R");$pdf->Cell(17,6,"$rk05","$rmc",0,"R");
$pdf->Cell(17,6,"$rn05","$rmc",0,"R");$pdf->Cell(30,6,"$rm05","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r06","$rmc",0,"R");$pdf->Cell(17,5,"$rk06","$rmc",0,"R");
$pdf->Cell(17,5,"$rn06","$rmc",0,"R");$pdf->Cell(30,5,"$rm06","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r07","$rmc",0,"R");$pdf->Cell(17,6,"$rk07","$rmc",0,"R");
$pdf->Cell(17,6,"$rn07","$rmc",0,"R");$pdf->Cell(30,6,"$rm07","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r08","$rmc",0,"R");$pdf->Cell(17,6,"$rk08","$rmc",0,"R");
$pdf->Cell(17,6,"$rn08","$rmc",0,"R");$pdf->Cell(30,6,"$rm08","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r09","$rmc",0,"R");$pdf->Cell(17,6,"$rk09","$rmc",0,"R");
$pdf->Cell(17,6,"$rn09","$rmc",0,"R");$pdf->Cell(30,6,"$rm09","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r10","$rmc",0,"R");$pdf->Cell(17,6,"$rk10","$rmc",0,"R");
$pdf->Cell(17,6,"$rn10","$rmc",0,"R");$pdf->Cell(30,6,"$rm10","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r11","$rmc",0,"R");$pdf->Cell(17,6,"$rk11","$rmc",0,"R");
$pdf->Cell(17,6,"$rn11","$rmc",0,"R");$pdf->Cell(30,6,"$rm11","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r12","$rmc",0,"R");$pdf->Cell(17,5,"$rk12","$rmc",0,"R");
$pdf->Cell(17,5,"$rn12","$rmc",0,"R");$pdf->Cell(30,5,"$rm12","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r13","$rmc",0,"R");$pdf->Cell(17,6,"$rk13","$rmc",0,"R");
$pdf->Cell(17,6,"$rn13","$rmc",0,"R");$pdf->Cell(30,6,"$rm13","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r14","$rmc",0,"R");$pdf->Cell(17,5,"$rk14","$rmc",0,"R");
$pdf->Cell(17,5,"$rn14","$rmc",0,"R");$pdf->Cell(30,5,"$rm14","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r15","$rmc",0,"R");$pdf->Cell(17,6,"$rk15","$rmc",0,"R");
$pdf->Cell(17,6,"$rn15","$rmc",0,"R");$pdf->Cell(30,6,"$rm15","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r16","$rmc",0,"R");$pdf->Cell(17,6,"$rk16","$rmc",0,"R");
$pdf->Cell(17,6,"$rn16","$rmc",0,"R");$pdf->Cell(30,6,"$rm16","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r17","$rmc",0,"R");$pdf->Cell(17,5,"$rk17","$rmc",0,"R");
$pdf->Cell(17,5,"$rn17","$rmc",0,"R");$pdf->Cell(30,5,"$rm17","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r18","$rmc",0,"R");$pdf->Cell(17,6,"$rk18","$rmc",0,"R");
$pdf->Cell(17,6,"$rn18","$rmc",0,"R");$pdf->Cell(30,6,"$rm18","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r19","$rmc",0,"R");$pdf->Cell(17,6,"$rk19","$rmc",0,"R");
$pdf->Cell(17,6,"$rn19","$rmc",0,"R");$pdf->Cell(30,6,"$rm19","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r20","$rmc",0,"R");$pdf->Cell(17,5,"$rk20","$rmc",0,"R");
$pdf->Cell(17,5,"$rn20","$rmc",0,"R");$pdf->Cell(30,5,"$rm20","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r21","$rmc",0,"R");$pdf->Cell(17,6,"$rk21","$rmc",0,"R");
$pdf->Cell(17,6,"$rn21","$rmc",0,"R");$pdf->Cell(30,6,"$rm21","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r22","$rmc",0,"R");$pdf->Cell(17,6,"$rk22","$rmc",0,"R");
$pdf->Cell(17,6,"$rn22","$rmc",0,"R");$pdf->Cell(30,6,"$rm22","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r23","$rmc",0,"R");$pdf->Cell(17,5,"$rk23","$rmc",0,"R");
$pdf->Cell(17,5,"$rn23","$rmc",0,"R");$pdf->Cell(30,5,"$rm23","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r24","$rmc",0,"R");$pdf->Cell(17,6,"$rk24","$rmc",0,"R");
$pdf->Cell(17,6,"$rn24","$rmc",0,"R");$pdf->Cell(30,6,"$rm24","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r25","$rmc",0,"R");$pdf->Cell(17,6,"$rk25","$rmc",0,"R");
$pdf->Cell(17,6,"$rn25","$rmc",0,"R");$pdf->Cell(30,6,"$rm25","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r26","$rmc",0,"R");$pdf->Cell(17,5,"$rk26","$rmc",0,"R");
$pdf->Cell(17,5,"$rn26","$rmc",0,"R");$pdf->Cell(30,5,"$rm26","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r27","$rmc",0,"R");$pdf->Cell(17,6,"$rk27","$rmc",0,"R");
$pdf->Cell(17,6,"$rn27","$rmc",0,"R");$pdf->Cell(30,6,"$rm27","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r28","$rmc",0,"R");$pdf->Cell(17,6,"$rk28","$rmc",0,"R");
$pdf->Cell(17,6,"$rn28","$rmc",0,"R");$pdf->Cell(30,6,"$rm28","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r29","$rmc",0,"R");$pdf->Cell(17,6,"$rk29","$rmc",0,"R");
$pdf->Cell(17,6,"$rn29","$rmc",0,"R");$pdf->Cell(30,6,"$rm29","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r30","$rmc",0,"R");$pdf->Cell(17,5,"$rk30","$rmc",0,"R");
$pdf->Cell(17,5,"$rn30","$rmc",0,"R");$pdf->Cell(30,5,"$rm30","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r31","$rmc",0,"R");$pdf->Cell(17,6,"$rk31","$rmc",0,"R");
$pdf->Cell(17,6,"$rn31","$rmc",0,"R");$pdf->Cell(30,6,"$rm31","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r32","$rmc",0,"R");$pdf->Cell(17,6,"$rk32","$rmc",0,"R");
$pdf->Cell(17,6,"$rn32","$rmc",0,"R");$pdf->Cell(30,6,"$rm32","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r33","$rmc",0,"R");$pdf->Cell(17,5,"$rk33","$rmc",0,"R");
$pdf->Cell(17,5,"$rn33","$rmc",0,"R");$pdf->Cell(30,5,"$rm33","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,7,"$r34","$rmc",0,"R");$pdf->Cell(17,7,"$rk34","$rmc",0,"R");
$pdf->Cell(17,7,"$rn34","$rmc",0,"R");$pdf->Cell(30,7,"$rm34","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r35","$rmc",0,"R");$pdf->Cell(17,6,"$rk35","$rmc",0,"R");
$pdf->Cell(17,6,"$rn35","$rmc",0,"R");$pdf->Cell(30,6,"$rm35","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r36","$rmc",0,"R");$pdf->Cell(17,5,"$rk36","$rmc",0,"R");
$pdf->Cell(17,5,"$rn36","$rmc",0,"R");$pdf->Cell(30,5,"$rm36","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r37","$rmc",0,"R");$pdf->Cell(17,6,"$rk37","$rmc",0,"R");
$pdf->Cell(17,6,"$rn37","$rmc",0,"R");$pdf->Cell(30,6,"$rm37","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r38","$rmc",0,"R");$pdf->Cell(17,5,"$rk38","$rmc",0,"R");
$pdf->Cell(17,5,"$rn38","$rmc",0,"R");$pdf->Cell(30,5,"$rm38","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r39","$rmc",0,"R");$pdf->Cell(17,6,"$rk39","$rmc",0,"R");
$pdf->Cell(17,6,"$rn39","$rmc",0,"R");$pdf->Cell(30,6,"$rm39","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r40","$rmc",0,"R");$pdf->Cell(17,6,"$rk40","$rmc",0,"R");
$pdf->Cell(17,6,"$rn40","$rmc",0,"R");$pdf->Cell(30,6,"$rm40","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r41","$rmc",0,"R");$pdf->Cell(17,6,"$rk41","$rmc",0,"R");
$pdf->Cell(17,6,"$rn41","$rmc",0,"R");$pdf->Cell(30,6,"$rm41","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r42","$rmc",0,"R");$pdf->Cell(17,5,"$rk42","$rmc",0,"R");
$pdf->Cell(17,5,"$rn42","$rmc",0,"R");$pdf->Cell(30,5,"$rm42","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r43","$rmc",0,"R");$pdf->Cell(17,6,"$rk43","$rmc",0,"R");
$pdf->Cell(17,6,"$rn43","$rmc",0,"R");$pdf->Cell(30,6,"$rm43","$rmc",1,"R");
                                       }

if ( $strana == 3 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',8);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str3.jpg') )
{
$pdf->Image($jpg_cesta.'_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);

//zostatok k
$pdf->Cell(195,6," ","$rmc1",1,"L");
$pdf->Cell(137,4," ","$rmc1",0,"R");$pdf->Cell(10,4,"$skutku","$rmc",1,"C");

//VYBRANE PASIVA
$r44=$hlavicka->r44; if ( $hlavicka->r44 == 0 ) $r44="";
$r45=$hlavicka->r45; if ( $hlavicka->r45 == 0 ) $r45="";
$r46=$hlavicka->r46; if ( $hlavicka->r46 == 0 ) $r46="";
$r47=$hlavicka->r47; if ( $hlavicka->r47 == 0 ) $r47="";
$r48=$hlavicka->r48; if ( $hlavicka->r48 == 0 ) $r48="";
$r49=$hlavicka->r49; if ( $hlavicka->r49 == 0 ) $r49="";
$r50=$hlavicka->r50; if ( $hlavicka->r50 == 0 ) $r50="";
$r51=$hlavicka->r51; if ( $hlavicka->r51 == 0 ) $r51="";
$r52=$hlavicka->r52; if ( $hlavicka->r52 == 0 ) $r52="";
$r53=$hlavicka->r53; if ( $hlavicka->r53 == 0 ) $r53="";
$r54=$hlavicka->r54; if ( $hlavicka->r54 == 0 ) $r54="";
$r55=$hlavicka->r55; if ( $hlavicka->r55 == 0 ) $r55="";
$r56=$hlavicka->r56; if ( $hlavicka->r56 == 0 ) $r56="";
$r57=$hlavicka->r57; if ( $hlavicka->r57 == 0 ) $r57="";
$r58=$hlavicka->r58; if ( $hlavicka->r58 == 0 ) $r58="";
$r59=$hlavicka->r59; if ( $hlavicka->r59 == 0 ) $r59="";
$r60=$hlavicka->r60; if ( $hlavicka->r60 == 0 ) $r60="";
$r61=$hlavicka->r61; if ( $hlavicka->r61 == 0 ) $r61="";
$r62=$hlavicka->r62; if ( $hlavicka->r62 == 0 ) $r62="";
$r63=$hlavicka->r63; if ( $hlavicka->r63 == 0 ) $r63="";
$r64=$hlavicka->r64; if ( $hlavicka->r64 == 0 ) $r64="";
$r65=$hlavicka->r65; if ( $hlavicka->r65 == 0 ) $r65="";
$r66=$hlavicka->r66; if ( $hlavicka->r66 == 0 ) $r66="";
$r67=$hlavicka->r67; if ( $hlavicka->r67 == 0 ) $r67="";
$r68=$hlavicka->r68; if ( $hlavicka->r68 == 0 ) $r68="";
$r69=$hlavicka->r69; if ( $hlavicka->r69 == 0 ) $r69="";
$r70=$hlavicka->r70; if ( $hlavicka->r70 == 0 ) $r70="";
$r71=$hlavicka->r71; if ( $hlavicka->r71 == 0 ) $r71="";
$r72=$hlavicka->r72; if ( $hlavicka->r72 == 0 ) $r72="";
$r73=$hlavicka->r73; if ( $hlavicka->r73 == 0 ) $r73="";
$r74=$hlavicka->r74; if ( $hlavicka->r74 == 0 ) $r74="";
$r75=$hlavicka->r75; if ( $hlavicka->r75 == 0 ) $r75="";
$r76=$hlavicka->r76; if ( $hlavicka->r76 == 0 ) $r76="";
$r77=$hlavicka->r77; if ( $hlavicka->r77 == 0 ) $r77="";
$r78=$hlavicka->r78; if ( $hlavicka->r78 == 0 ) $r78="";
$r79=$hlavicka->r79; if ( $hlavicka->r79 == 0 ) $r79="";

$rm44=$hlavicka->rm44; if ( $hlavicka->rm44 == 0 ) $rm44="";
$rm45=$hlavicka->rm45; if ( $hlavicka->rm45 == 0 ) $rm45="";
$rm46=$hlavicka->rm46; if ( $hlavicka->rm46 == 0 ) $rm46="";
$rm47=$hlavicka->rm47; if ( $hlavicka->rm47 == 0 ) $rm47="";
$rm48=$hlavicka->rm48; if ( $hlavicka->rm48 == 0 ) $rm48="";
$rm49=$hlavicka->rm49; if ( $hlavicka->rm49 == 0 ) $rm49="";
$rm50=$hlavicka->rm50; if ( $hlavicka->rm50 == 0 ) $rm50="";
$rm51=$hlavicka->rm51; if ( $hlavicka->rm51 == 0 ) $rm51="";
$rm52=$hlavicka->rm52; if ( $hlavicka->rm52 == 0 ) $rm52="";
$rm53=$hlavicka->rm53; if ( $hlavicka->rm53 == 0 ) $rm53="";
$rm54=$hlavicka->rm54; if ( $hlavicka->rm54 == 0 ) $rm54="";
$rm55=$hlavicka->rm55; if ( $hlavicka->rm55 == 0 ) $rm55="";
$rm56=$hlavicka->rm56; if ( $hlavicka->rm56 == 0 ) $rm56="";
$rm57=$hlavicka->rm57; if ( $hlavicka->rm57 == 0 ) $rm57="";
$rm58=$hlavicka->rm58; if ( $hlavicka->rm58 == 0 ) $rm58="";
$rm59=$hlavicka->rm59; if ( $hlavicka->rm59 == 0 ) $rm59="";
$rm60=$hlavicka->rm60; if ( $hlavicka->rm60 == 0 ) $rm60="";
$rm61=$hlavicka->rm61; if ( $hlavicka->rm61 == 0 ) $rm61="";
$rm62=$hlavicka->rm62; if ( $hlavicka->rm62 == 0 ) $rm62="";
$rm63=$hlavicka->rm63; if ( $hlavicka->rm63 == 0 ) $rm63="";
$rm64=$hlavicka->rm64; if ( $hlavicka->rm64 == 0 ) $rm64="";
$rm65=$hlavicka->rm65; if ( $hlavicka->rm65 == 0 ) $rm65="";
$rm66=$hlavicka->rm66; if ( $hlavicka->rm66 == 0 ) $rm66="";
$rm67=$hlavicka->rm67; if ( $hlavicka->rm67 == 0 ) $rm67="";
$rm68=$hlavicka->rm68; if ( $hlavicka->rm68 == 0 ) $rm68="";
$rm69=$hlavicka->rm69; if ( $hlavicka->rm69 == 0 ) $rm69="";
$rm70=$hlavicka->rm70; if ( $hlavicka->rm70 == 0 ) $rm70="";
$rm71=$hlavicka->rm71; if ( $hlavicka->rm71 == 0 ) $rm71="";
$rm72=$hlavicka->rm72; if ( $hlavicka->rm72 == 0 ) $rm72="";
$rm73=$hlavicka->rm73; if ( $hlavicka->rm73 == 0 ) $rm73="";
$rm74=$hlavicka->rm74; if ( $hlavicka->rm74 == 0 ) $rm74="";
$rm75=$hlavicka->rm75; if ( $hlavicka->rm75 == 0 ) $rm75="";
$rm76=$hlavicka->rm76; if ( $hlavicka->rm76 == 0 ) $rm76="";
$rm77=$hlavicka->rm77; if ( $hlavicka->rm77 == 0 ) $rm77="";
$rm78=$hlavicka->rm78; if ( $hlavicka->rm78 == 0 ) $rm78="";
$rm79=$hlavicka->rm79; if ( $hlavicka->rm79 == 0 ) $rm79="";
$pdf->Cell(195,12," ","$rmc1",1,"L");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r44","$rmc",0,"R");$pdf->Cell(30,6,"$rm44","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,5,"$r45","$rmc",0,"R");$pdf->Cell(30,5,"$rm45","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,7,"$r46","$rmc",0,"R");$pdf->Cell(30,7,"$rm46","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r47","$rmc",0,"R");$pdf->Cell(30,6,"$rm47","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r48","$rmc",0,"R");$pdf->Cell(30,6,"$rm48","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,5,"$r49","$rmc",0,"R");$pdf->Cell(30,5,"$rm49","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r50","$rmc",0,"R");$pdf->Cell(30,6,"$rm50","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r51","$rmc",0,"R");$pdf->Cell(30,6,"$rm51","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,5,"$r52","$rmc",0,"R");$pdf->Cell(30,5,"$rm52","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r53","$rmc",0,"R");$pdf->Cell(30,6,"$rm53","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r54","$rmc",0,"R");$pdf->Cell(30,6,"$rm54","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,5,"$r55","$rmc",0,"R");$pdf->Cell(30,5,"$rm55","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r56","$rmc",0,"R");$pdf->Cell(30,6,"$rm56","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r57","$rmc",0,"R");$pdf->Cell(30,6,"$rm57","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,5,"$r58","$rmc",0,"R");$pdf->Cell(30,5,"$rm58","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r59","$rmc",0,"R");$pdf->Cell(30,6,"$rm59","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r60","$rmc",0,"R");$pdf->Cell(30,6,"$rm60","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,5,"$r61","$rmc",0,"R");$pdf->Cell(30,5,"$rm61","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r62","$rmc",0,"R");$pdf->Cell(30,6,"$rm62","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r63","$rmc",0,"R");$pdf->Cell(30,6,"$rm63","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r64","$rmc",0,"R");$pdf->Cell(30,6,"$rm64","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r65","$rmc",0,"R");$pdf->Cell(30,6,"$rm65","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r66","$rmc",0,"R");$pdf->Cell(30,6,"$rm66","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r67","$rmc",0,"R");$pdf->Cell(30,6,"$rm67","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,5,"$r68","$rmc",0,"R");$pdf->Cell(30,5,"$rm68","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r69","$rmc",0,"R");$pdf->Cell(30,6,"$rm69","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,7,"$r70","$rmc",0,"R");$pdf->Cell(30,7,"$rm70","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r71","$rmc",0,"R");$pdf->Cell(30,6,"$rm71","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r72","$rmc",0,"R");$pdf->Cell(30,6,"$rm72","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,5,"$r73","$rmc",0,"R");$pdf->Cell(30,5,"$rm73","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r74","$rmc",0,"R");$pdf->Cell(30,6,"$rm74","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r75","$rmc",0,"R");$pdf->Cell(30,6,"$rm75","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r76","$rmc",0,"R");$pdf->Cell(30,6,"$rm76","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r77","$rmc",0,"R");$pdf->Cell(30,6,"$rm77","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r78","$rmc",0,"R");$pdf->Cell(30,6,"$rm78","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r79","$rmc",0,"R");$pdf->Cell(30,6,"$rm79","$rmc",1,"R");
                                          }
}
$i = $i + 1;
  }
$pdf->Output("../tmp/vykazfin.$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/vykazfin.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA 
?>

<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec
$cislista = include("uct_lista_norm.php");
} while (false);
?>
</BODY>
</HTML>