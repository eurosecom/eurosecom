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
$rmc=0;
$rmc1=0;

//.jpg podklad
$jpg_cesta="../dokumenty/statistika2016/fin404/fin4-04_v16";
$jpg_popis="Finanèný výkaz o finanèných pasívach pod¾a sektorov subjektu verejnej správy FIN 4-04 za rok ".$kli_vrok;

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

//ak nie je generovanie daj standardne
$niejegen=0;
$sql = "SELECT * FROM F".$kli_vxcf."_genfin404 ";
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
$sql = "DROP TABLE F$kli_vxcf"."_genfin404";
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

$sql = 'CREATE TABLE F'.$kli_vxcf.'_genfin404'.$sqlt;
$vysledek = mysql_query("$sql");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin404 ( uce,crs ) VALUES ( '241', '1' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin404 ( uce,crs ) VALUES ( '473', '1' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin404 ( uce,crs ) VALUES ( '322', '3' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin404 ( uce,crs ) VALUES ( '473', '3' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin404 ( uce,crs ) VALUES ( '461', '7' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin404 ( uce,crs ) VALUES ( '231', '7' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin404 ( uce,crs ) VALUES ( '232', '7' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin404 ( uce,crs ) VALUES ( '562', '8' ); "; $ulozene = mysql_query("$sqult");

$nacitajgen = 1*$_REQUEST['nacitajgen'];
if ( $nacitajgen == 1 ) {
?>
<script type="text/javascript">
 window.open('../ucto/fin_cis.php?copern=308&drupoh=94&page=1&sysx=UCT', '_self');
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


$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin404 WHERE oc = $cislo_oc";
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

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin404 SET ".
" daz='$daz_sql' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 2 ) {
$pocs01 = 1*$_REQUEST['pocs01'];
$pocs02 = 1*$_REQUEST['pocs02'];
$pocs03 = 1*$_REQUEST['pocs03'];
$pocs04 = 1*$_REQUEST['pocs04'];
//$pocs05 = 1*$_REQUEST['pocs05'];
//$pocs06 = 1*$_REQUEST['pocs06'];
$pocs07 = 1*$_REQUEST['pocs07'];
$pocs08 = 1*$_REQUEST['pocs08'];
$pocs09 = 1*$_REQUEST['pocs09'];
$pocs10 = 1*$_REQUEST['pocs10'];
$pocs11 = 1*$_REQUEST['pocs11'];
$pocs12 = 1*$_REQUEST['pocs12'];
$zvys01 = 1*$_REQUEST['zvys01'];
$zvys02 = 1*$_REQUEST['zvys02'];
$zvys03 = 1*$_REQUEST['zvys03'];
$zvys04 = 1*$_REQUEST['zvys04'];
//$zvys05 = 1*$_REQUEST['zvys05'];
//$zvys06 = 1*$_REQUEST['zvys06'];
$zvys07 = 1*$_REQUEST['zvys07'];
$zvys08 = 1*$_REQUEST['zvys08'];
$zvys09 = 1*$_REQUEST['zvys09'];
$zvys10 = 1*$_REQUEST['zvys10'];
$zvys11 = 1*$_REQUEST['zvys11'];
$zvys12 = 1*$_REQUEST['zvys12'];
$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin404 SET ".
" pocs01='$pocs01', pocs02='$pocs02', pocs03='$pocs03', pocs04='$pocs04',
  pocs07='$pocs07', pocs08='$pocs08', pocs09='$pocs09', pocs10='$pocs10',
  pocs11='$pocs11', pocs12='$pocs12',
  zvys01='$zvys01', zvys02='$zvys02', zvys03='$zvys03', zvys04='$zvys04',
  zvys07='$zvys07', zvys08='$zvys08', zvys09='$zvys09', zvys10='$zvys10',
  zvys11='$zvys11', zvys12='$zvys12' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 3 ) {
$znis01 = 1*$_REQUEST['znis01'];
$znis02 = 1*$_REQUEST['znis02'];
$znis03 = 1*$_REQUEST['znis03'];
$znis04 = 1*$_REQUEST['znis04'];
//$znis05 = 1*$_REQUEST['znis05'];
//$znis06 = 1*$_REQUEST['znis06'];
$znis07 = 1*$_REQUEST['znis07'];
$znis08 = 1*$_REQUEST['znis08'];
$znis09 = 1*$_REQUEST['znis09'];
$znis10 = 1*$_REQUEST['znis10'];
$znis11 = 1*$_REQUEST['znis11'];
$znis12 = 1*$_REQUEST['znis12'];
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
$oces11 = 1*$_REQUEST['oces11'];
$oces12 = 1*$_REQUEST['oces12'];
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
$osts11 = 1*$_REQUEST['osts11'];
$osts12 = 1*$_REQUEST['osts12'];
$zoss01 = 1*$_REQUEST['zoss01'];
$zoss02 = 1*$_REQUEST['zoss02'];
$zoss03 = 1*$_REQUEST['zoss03'];
$zoss04 = 1*$_REQUEST['zoss04'];
//$zoss05 = 1*$_REQUEST['zoss05'];
//$zoss06 = 1*$_REQUEST['zoss06'];
$zoss07 = 1*$_REQUEST['zoss07'];
$zoss08 = 1*$_REQUEST['zoss08'];
$zoss09 = 1*$_REQUEST['zoss09'];
$zoss10 = 1*$_REQUEST['zoss10'];
$zoss11 = 1*$_REQUEST['zoss11'];
$zoss12 = 1*$_REQUEST['zoss12'];
$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin404 SET ".
" znis01='$znis01', znis02='$znis02', znis03='$znis03', znis04='$znis04',
  znis07='$znis07', znis08='$znis08', znis09='$znis09', znis10='$znis10',
  znis11='$znis11', znis12='$znis12',
  oces01='$oces01', oces02='$oces02', oces03='$oces03', oces04='$oces04', oces05='$oces05',
  oces06='$oces06', oces07='$oces07', oces08='$oces08', oces09='$oces09', oces10='$oces10',
  oces11='$oces11', oces12='$oces12',
  osts01='$osts01', osts02='$osts02', osts03='$osts03', osts04='$osts04', osts05='$osts05',
  osts06='$osts06', osts07='$osts07', osts08='$osts08', osts09='$osts09', osts10='$osts10',
  osts11='$osts11', osts12='$osts12',
  zoss01='$zoss01', zoss02='$zoss02', zoss03='$zoss03', zoss04='$zoss04',
  zoss07='$zoss07', zoss08='$zoss08', zoss09='$zoss09', zoss10='$zoss10',
  zoss11='$zoss11', zoss12='$zoss12' ".
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


$sql = "SELECT oces12 FROM F".$kli_vxcf."_uctvykaz_fin404";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin404';
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
   pocs11       DECIMAL($pocdes),
   pocs12       DECIMAL($pocdes),

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
   zvys11       DECIMAL($pocdes),
   zvys12       DECIMAL($pocdes),

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
   znis11       DECIMAL($pocdes),
   znis12       DECIMAL($pocdes),

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
   oces11       DECIMAL($pocdes),
   oces12       DECIMAL($pocdes),

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
   osts11       DECIMAL($pocdes),
   osts12       DECIMAL($pocdes),

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
   zoss11       DECIMAL($pocdes),
   zoss12       DECIMAL($pocdes),

   ico           INT
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctvykaz_fin404'.$sqlt;
$vytvor = mysql_query("$vsql");
}
//koniec vytvorenie


$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_fin404";
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_fin404";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
//exit;


$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin404 WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $jepotvrd=1;
  }
if ( $jepotvrd == 0 ) $subor=1;

$nacitavamhodnoty=0;
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
$nacitavamhodnoty=1;

//zober pociatocny stav uctov
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" pmd,$cislo_oc,0,'','','0000-00-00',".
"1,0,uce,uce,0,0,0,0,pmd,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pmd != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" -pda,$cislo_oc,0,'','','0000-00-00',".
"1,0,uce,uce,0,0,0,0,0,pda,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
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
"2,0,ucm,ucm,0,0,0,0,F$kli_vxcf"."_$uctovanie.hod,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucm > 0 AND ume <= $kli_vume";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
"3,0,ucd,0,ucd,0,0,0,0,F$kli_vxcf"."_$uctovanie.hod,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucd > 0 AND ume <= $kli_vume";
$dsql = mysql_query("$dsqlt");

}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
"2,0,ucm,ucm,0,0,0,0,SUM(hod),0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie".
" WHERE ( ucm > 0 AND ume <= $kli_vume ) GROUP BY F$kli_vxcf"."_$uctovanie.ucm";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
"3,0,ucd,0,ucd,0,0,0,0,SUM(hod),".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie".
" WHERE ( ucd > 0 AND ume <= $kli_vume ) GROUP BY F$kli_vxcf"."_$uctovanie.ucd";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid,F$kli_vxcf"."_genfin404".
" SET rdk=F$kli_vxcf"."_genfin404.crs".
" WHERE LEFT(F$kli_vxcf"."_uctprcvykaz$kli_uzid.uce,3) = LEFT(F$kli_vxcf"."_genfin404.uce,3) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid,F$kli_vxcf"."_genfin404".
" SET rdk=F$kli_vxcf"."_genfin404.crs".
" WHERE F$kli_vxcf"."_uctprcvykaz$kli_uzid.uce = F$kli_vxcf"."_genfin404.uce ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
//exit;


//rozdel do riadkov

$rdk=1;
while ($rdk <= 12 )
  {
$crdk=$rdk;
if( $rdk < 10 ) $crdk="0".$rdk;

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET pocs$crdk=dal-mdt WHERE rdk = $rdk AND kor = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET znis$crdk=mdt-dal WHERE rdk = $rdk AND kor = 2 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET zvys$crdk=dal-mdt WHERE rdk = $rdk AND kor = 3 ";
$oznac = mysql_query("$sqtoz");

$rdk=$rdk+1;
  }



//sumar za riadky
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx$kli_uzid "." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
" 0,1,uce,ucm,ucd,rdk,prv,hod,mdt,dal,".
"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),SUM(pocs11),SUM(pocs12),".
"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),SUM(zvys11),SUM(zvys12),".
"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10),SUM(znis11),SUM(znis12),".
"SUM(oces01),SUM(oces02),SUM(oces03),SUM(oces04),SUM(oces05),SUM(oces06),SUM(oces07),SUM(oces08),SUM(oces09),SUM(oces10),SUM(oces11),SUM(oces12),".
"SUM(osts01),SUM(osts02),SUM(osts03),SUM(osts04),SUM(osts05),SUM(osts06),SUM(osts07),SUM(osts08),SUM(osts09),SUM(osts10),SUM(osts11),SUM(osts12),".
"SUM(zoss01),SUM(zoss02),SUM(zoss03),SUM(zoss04),SUM(zoss05),SUM(zoss06),SUM(zoss07),SUM(zoss08),SUM(zoss09),SUM(zoss10),SUM(zoss11),SUM(zoss12),".
"$fir_fico".
" FROM F$kli_vxcf"."_uctprcvykaz$kli_uzid".
" WHERE rdk >= 0".
" GROUP BY prx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");




/////////////////////////////////koniec naCITAJ HODNOTY

//uloz
$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin404 WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");


$dsqlt = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin404".
" SELECT * FROM F$kli_vxcf"."_uctprcvykazx".$kli_uzid." WHERE oc = $cislo_oc AND prx = 1 ".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;
}
//koniec pracovneho suboru pre rocne

//vypocty
if ( $copern == 10 OR $copern == 20 )
{


$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin404 SET ".
" zoss01=pocs01+zvys01-znis01+oces01+osts01,  ".
" zoss02=pocs02+zvys02-znis02+oces02+osts02,  ".
" zoss03=pocs03+zvys03-znis03+oces03+osts03,  ".
" zoss04=pocs04+zvys04-znis04+oces04+osts04,  ".
" zoss05=pocs05+zvys05-znis05+oces05+osts05,  ".
" zoss06=pocs06+zvys06-znis06+oces06+osts06,  ".
" zoss07=pocs07+zvys07-znis07+oces07+osts07,  ".
" zoss08=pocs08+zvys08-znis08+oces08+osts08,  ".
" zoss09=pocs09+zvys09-znis09+oces09+osts09,  ".
" zoss10=pocs10+zvys10-znis10+oces10+osts10,  ".
" zoss11=pocs11+zvys11-znis11+oces11+osts11,  ".
" zoss12=pocs12+zvys12-znis12+oces12+osts12   ".
" WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

}
//koniec vypocty


//nacitaj udaje pre upravu
if ( $copern == 10 OR $copern == 20 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin404 WHERE oc = $cislo_oc ";

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
$pocs07 = $fir_riadok->pocs07;
$pocs08 = $fir_riadok->pocs08;
$pocs09 = $fir_riadok->pocs09;
$pocs10 = $fir_riadok->pocs10;
$pocs11 = $fir_riadok->pocs11;
$pocs12 = $fir_riadok->pocs12;
$zvys01 = $fir_riadok->zvys01;
$zvys02 = $fir_riadok->zvys02;
$zvys03 = $fir_riadok->zvys03;
$zvys04 = $fir_riadok->zvys04;
$zvys07 = $fir_riadok->zvys07;
$zvys08 = $fir_riadok->zvys08;
$zvys09 = $fir_riadok->zvys09;
$zvys10 = $fir_riadok->zvys10;
$zvys11 = $fir_riadok->zvys11;
$zvys12 = $fir_riadok->zvys12;

$r01s01 = $fir_riadok->pocs01;
$r01s02 = $fir_riadok->pocs02;
$r01s03 = $fir_riadok->pocs03;
$r01s04 = $fir_riadok->pocs04;
$r01s07 = $fir_riadok->pocs07;
$r01s08 = $fir_riadok->pocs08;
$r01s09 = $fir_riadok->pocs09;
$r01s10 = $fir_riadok->pocs10;
$r01s11 = $fir_riadok->pocs11;
$r01s12 = $fir_riadok->pocs12;

$r06s01 = $fir_riadok->pocs01;
$r06s02 = $fir_riadok->pocs02;
$r06s03 = $fir_riadok->pocs03;
$r06s04 = $fir_riadok->pocs04;
$r06s07 = $fir_riadok->pocs07;
$r06s08 = $fir_riadok->pocs08;
$r06s09 = $fir_riadok->pocs09;
$r06s10 = $fir_riadok->pocs10;
$r06s11 = $fir_riadok->pocs11;
$r06s12 = $fir_riadok->pocs12;

$r13s01 = $fir_riadok->zvys01;
$r13s02 = $fir_riadok->zvys02;
$r13s03 = $fir_riadok->zvys03;
$r13s04 = $fir_riadok->zvys04;
$r13s07 = $fir_riadok->zvys07;
$r13s08 = $fir_riadok->zvys08;
$r13s09 = $fir_riadok->zvys09;
$r13s10 = $fir_riadok->zvys10;
$r13s11 = $fir_riadok->zvys11;
$r13s12 = $fir_riadok->zvys12;

$r18s01 = $fir_riadok->zvys01;
$r18s02 = $fir_riadok->zvys02;
$r18s03 = $fir_riadok->zvys03;
$r18s04 = $fir_riadok->zvys04;
$r18s07 = $fir_riadok->zvys07;
$r18s08 = $fir_riadok->zvys08;
$r18s09 = $fir_riadok->zvys09;
$r18s10 = $fir_riadok->zvys10;
$r18s11 = $fir_riadok->zvys11;
$r18s12 = $fir_riadok->zvys12;

$r25s01 = $fir_riadok->znis01;
$r25s02 = $fir_riadok->znis02;
$r25s03 = $fir_riadok->znis03;
$r25s04 = $fir_riadok->znis04;
$r25s07 = $fir_riadok->znis07;
$r25s08 = $fir_riadok->znis08;
$r25s09 = $fir_riadok->znis09;
$r25s10 = $fir_riadok->znis10;
$r25s11 = $fir_riadok->znis11;
$r25s12 = $fir_riadok->znis12;
}

if ( $strana == 3 )
{
$znis01 = $fir_riadok->znis01;
$znis02 = $fir_riadok->znis02;
$znis03 = $fir_riadok->znis03;
$znis04 = $fir_riadok->znis04;
$znis07 = $fir_riadok->znis07;
$znis08 = $fir_riadok->znis08;
$znis09 = $fir_riadok->znis09;
$znis10 = $fir_riadok->znis10;
$znis11 = $fir_riadok->znis11;
$znis12 = $fir_riadok->znis12;
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
$oces11 = $fir_riadok->oces11;
$oces12 = $fir_riadok->oces12;
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
$osts11 = $fir_riadok->osts11;
$osts12 = $fir_riadok->osts12;
$zoss01 = $fir_riadok->zoss01;
$zoss02 = $fir_riadok->zoss02;
$zoss03 = $fir_riadok->zoss03;
$zoss04 = $fir_riadok->zoss04;
$zoss07 = $fir_riadok->zoss07;
$zoss08 = $fir_riadok->zoss08;
$zoss09 = $fir_riadok->zoss09;
$zoss10 = $fir_riadok->zoss10;
$zoss11 = $fir_riadok->zoss11;
$zoss12 = $fir_riadok->zoss12;

$r30s01 = $fir_riadok->znis01;
$r30s02 = $fir_riadok->znis02;
$r30s03 = $fir_riadok->znis03;
$r30s04 = $fir_riadok->znis04;
$r30s07 = $fir_riadok->znis07;
$r30s08 = $fir_riadok->znis08;
$r30s09 = $fir_riadok->znis09;
$r30s10 = $fir_riadok->znis10;
$r30s11 = $fir_riadok->znis11;
$r30s12 = $fir_riadok->znis12;

$r39s01 = $fir_riadok->zoss01;
$r39s02 = $fir_riadok->zoss02;
$r39s03 = $fir_riadok->zoss03;
$r39s04 = $fir_riadok->zoss04;
$r39s07 = $fir_riadok->zoss07;
$r39s08 = $fir_riadok->zoss08;
$r39s09 = $fir_riadok->zoss09;
$r39s10 = $fir_riadok->zoss10;
$r39s11 = $fir_riadok->zoss11;
$r39s12 = $fir_riadok->zoss12;

$r44s01 = $fir_riadok->zoss01;
$r44s02 = $fir_riadok->zoss02;
$r44s03 = $fir_riadok->zoss03;
$r44s04 = $fir_riadok->zoss04;
$r44s07 = $fir_riadok->zoss07;
$r44s08 = $fir_riadok->zoss08;
$r44s09 = $fir_riadok->zoss09;
$r44s10 = $fir_riadok->zoss10;
$r44s11 = $fir_riadok->zoss11;
$r44s12 = $fir_riadok->zoss12;
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
<title>Výkaz FIN 4-04</title>
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
img.btn-form-tool {
  margin: 0 8px;
}
.btn-text {
  border: 0;
  box-sizing: border-box;
  color: #39f;
  cursor: pointer;
  display: inline-block;
  font-size: 14px;
  font-weight: 500;
  height: 28px;
  line-height: 28px;
  padding: 0 6px;
  text-align: center;
  text-transform: uppercase;
  /*vertical-align: middle;*/
  background-color: transparent;
  border-radius: 2px;
}
.btn-text:hover {
  background-color: rgba(158,158,158,.2);
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
//   document.formv1.pocs05.value = '<?php echo $pocs05; ?>';
//   document.formv1.pocs06.value = '<?php echo $pocs06; ?>';
   document.formv1.pocs07.value = '<?php echo $pocs07; ?>';
   document.formv1.pocs08.value = '<?php echo $pocs08; ?>';
   document.formv1.pocs09.value = '<?php echo $pocs09; ?>';
   document.formv1.pocs10.value = '<?php echo $pocs10; ?>';
   document.formv1.pocs11.value = '<?php echo $pocs11; ?>';
   document.formv1.pocs12.value = '<?php echo $pocs12; ?>';
   document.formv1.zvys01.value = '<?php echo $zvys01; ?>';
   document.formv1.zvys02.value = '<?php echo $zvys02; ?>';
   document.formv1.zvys03.value = '<?php echo $zvys03; ?>';
   document.formv1.zvys04.value = '<?php echo $zvys04; ?>';
//   document.formv1.zvys05.value = '<?php echo $zvys05; ?>';
//   document.formv1.zvys06.value = '<?php echo $zvys06; ?>';
   document.formv1.zvys07.value = '<?php echo $zvys07; ?>';
   document.formv1.zvys08.value = '<?php echo $zvys08; ?>';
   document.formv1.zvys09.value = '<?php echo $zvys09; ?>';
   document.formv1.zvys10.value = '<?php echo $zvys10; ?>';
   document.formv1.zvys11.value = '<?php echo $zvys11; ?>';
   document.formv1.zvys12.value = '<?php echo $zvys12; ?>';
<?php                     } ?>

<?php if ( $strana == 3 ) { ?>
   document.formv1.znis01.value = '<?php echo $znis01; ?>';
   document.formv1.znis02.value = '<?php echo $znis02; ?>';
   document.formv1.znis03.value = '<?php echo $znis03; ?>';
   document.formv1.znis04.value = '<?php echo $znis04; ?>';
   document.formv1.znis07.value = '<?php echo $znis07; ?>';
   document.formv1.znis08.value = '<?php echo $znis08; ?>';
   document.formv1.znis09.value = '<?php echo $znis09; ?>';
   document.formv1.znis10.value = '<?php echo $znis10; ?>';
   document.formv1.znis11.value = '<?php echo $znis11; ?>';
   document.formv1.znis12.value = '<?php echo $znis12; ?>';
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
   document.formv1.oces11.value = '<?php echo $oces11; ?>';
   document.formv1.oces12.value = '<?php echo $oces12; ?>';
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
   document.formv1.osts11.value = '<?php echo $osts11; ?>';
   document.formv1.osts12.value = '<?php echo $osts12; ?>';
   document.formv1.zoss01.value = '<?php echo $zoss01; ?>';
   document.formv1.zoss02.value = '<?php echo $zoss02; ?>';
   document.formv1.zoss03.value = '<?php echo $zoss03; ?>';
   document.formv1.zoss04.value = '<?php echo $zoss04; ?>';
//   document.formv1.zoss05.value = '<?php echo $zoss05; ?>';
//   document.formv1.zoss06.value = '<?php echo $zoss06; ?>';
   document.formv1.zoss07.value = '<?php echo $zoss07; ?>';
   document.formv1.zoss08.value = '<?php echo $zoss08; ?>';
   document.formv1.zoss09.value = '<?php echo $zoss09; ?>';
   document.formv1.zoss10.value = '<?php echo $zoss10; ?>';
   document.formv1.zoss11.value = '<?php echo $zoss11; ?>';
   document.formv1.zoss12.value = '<?php echo $zoss12; ?>';
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
   window.open('vykaz_fin404_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999',
'_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function Nacitaj()
  {
   window.open('vykaz_fin404_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=0&strana=1',
'_self', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }

  function DbfFin404()
  {
   window.open('fin404dbf_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=1&drupoh=1&page=1&subor=0',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
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
  <td class="header">FIN 4-04 Finanèné pasíva pod¾a sektorov za
   <span style="color:#39f;"><?php echo "$cislo_oc. štvrrok";?></span>
  </td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();" title="Vysvetlivky na vyplnenie výkazu" class="btn-form-tool">
    <button type="button" onclick="DbfFin404();" title="Export do DBF" class="btn-text toright" style="position: relative; top: -4px;">DBF</button>
<?php if ( $kli_vrok >= 2018 ) { ?>
    <button type="button" onclick="" title="Export do CSV" class="btn-text toright" style="position: relative; top: -4px;">CSV</button>
<?php } ?>
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
<FORM name="formv1" method="post" action="../ucto/vykaz_fin404_2016.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
if ( $strana == 3 ) $clas3="active";
$source="vykaz_fin404_2016.php";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=1&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=2&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=3&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas3; ?> toleft">3</a>

<?php
$alertnacitaj="";
if ( $nacitavamhodnoty == 1 ) { $alertnacitaj="!!! Údaje sú naèítané !!!"; }
?>
 <div class="alert-pocitam"><?php echo $alertnacitaj; ?></div>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloži zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str1.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 1.strana 265kB">

<span class="text-echo" style="top:153px; left:403px;"><?php echo $datum; ?></span>
<span class="text-echo" style="top:331px; left:141px;">x</span>
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
<span class="text-echo" style="top:262px; right:893px;"><?php echo $r01s01; ?></span>
<span class="text-echo" style="top:262px; right:822px;"><?php echo $r01s02; ?></span>
<span class="text-echo" style="top:262px; right:738px;"><?php echo $r01s03; ?></span>
<span class="text-echo" style="top:262px; right:666px;"><?php echo $r01s04; ?></span>
<span class="text-echo" style="top:262px; right:426px;"><?php echo $r01s07; ?></span>
<span class="text-echo" style="top:262px; right:354px;"><?php echo $r01s08; ?></span>
<span class="text-echo" style="top:262px; right:270px;"><?php echo $r01s09; ?></span>
<span class="text-echo" style="top:262px; right:198px;"><?php echo $r01s10; ?></span>
<span class="text-echo" style="top:262px; right:114px;"><?php echo $r01s11; ?></span>
<span class="text-echo" style="top:262px; right:43px;"><?php echo $r01s12; ?></span>
<!-- 6.verejna sprava spolu -->
<span class="text-echo" style="top:392px; right:893px;"><?php echo $r06s01; ?></span>
<span class="text-echo" style="top:392px; right:822px;"><?php echo $r06s02; ?></span>
<span class="text-echo" style="top:392px; right:738px;"><?php echo $r06s03; ?></span>
<span class="text-echo" style="top:392px; right:666px;"><?php echo $r06s04; ?></span>
<span class="text-echo" style="top:392px; right:426px;"><?php echo $r06s07; ?></span>
<span class="text-echo" style="top:392px; right:354px;"><?php echo $r06s08; ?></span>
<span class="text-echo" style="top:392px; right:270px;"><?php echo $r06s09; ?></span>
<span class="text-echo" style="top:392px; right:198px;"><?php echo $r06s10; ?></span>
<span class="text-echo" style="top:392px; right:114px;"><?php echo $r06s11; ?></span>
<span class="text-echo" style="top:392px; right:43px;"><?php echo $r06s12; ?></span>
<!-- 8.uzemna samosprava -->
<?php $top=440; ?>
<input type="text" name="pocs01" id="pocs01" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:279px;"/>
<input type="text" name="pocs02" id="pocs02" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:363px;"/>
<input type="text" name="pocs03" id="pocs03" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:435px;"/>
<input type="text" name="pocs04" id="pocs04" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:519px;"/>
<input type="text" name="pocs07" id="pocs07" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:746px;"/>
<input type="text" name="pocs08" id="pocs08" onkeyup="CiarkaNaBodku(this);" style="width:62px; top:<?php echo $top; ?>px; left:830px;"/>
<input type="text" name="pocs09" id="pocs09" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:902px;"/>
<input type="text" name="pocs10" id="pocs10" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:986px;"/>
<input type="text" name="pocs11" id="pocs11" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:1058px;"/>
<input type="text" name="pocs12" id="pocs12" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:1142px;"/>

<!-- 13.ZVYSENIE -->
<span class="text-echo" style="top:621px; right:893px;"><?php echo $r13s01; ?></span>
<span class="text-echo" style="top:621px; right:822px;"><?php echo $r13s02; ?></span>
<span class="text-echo" style="top:621px; right:738px;"><?php echo $r13s03; ?></span>
<span class="text-echo" style="top:621px; right:666px;"><?php echo $r13s04; ?></span>
<span class="text-echo" style="top:621px; right:426px;"><?php echo $r13s07; ?></span>
<span class="text-echo" style="top:621px; right:354px;"><?php echo $r13s08; ?></span>
<span class="text-echo" style="top:621px; right:270px;"><?php echo $r13s09; ?></span>
<span class="text-echo" style="top:621px; right:198px;"><?php echo $r13s10; ?></span>
<span class="text-echo" style="top:621px; right:114px;"><?php echo $r13s11; ?></span>
<span class="text-echo" style="top:621px; right:43px;"><?php echo $r13s12; ?></span>
<!-- 18.verejna sprava spolu -->
<span class="text-echo" style="top:753px; right:893px;"><?php echo $r18s01; ?></span>
<span class="text-echo" style="top:753px; right:822px;"><?php echo $r18s02; ?></span>
<span class="text-echo" style="top:753px; right:738px;"><?php echo $r18s03; ?></span>
<span class="text-echo" style="top:753px; right:666px;"><?php echo $r18s04; ?></span>
<span class="text-echo" style="top:753px; right:426px;"><?php echo $r18s07; ?></span>
<span class="text-echo" style="top:753px; right:354px;"><?php echo $r18s08; ?></span>
<span class="text-echo" style="top:753px; right:270px;"><?php echo $r18s09; ?></span>
<span class="text-echo" style="top:753px; right:198px;"><?php echo $r18s10; ?></span>
<span class="text-echo" style="top:753px; right:114px;"><?php echo $r18s11; ?></span>
<span class="text-echo" style="top:753px; right:43px;"><?php echo $r18s12; ?></span>
<!-- 20.uzemna samosprava -->
<?php $top=800; ?>
<input type="text" name="zvys01" id="zvys01" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:279px;"/>
<input type="text" name="zvys02" id="zvys02" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:363px;"/>
<input type="text" name="zvys03" id="zvys03" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:435px;"/>
<input type="text" name="zvys04" id="zvys04" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:519px;"/>
<input type="text" name="zvys07" id="zvys07" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:746px;"/>
<input type="text" name="zvys08" id="zvys08" onkeyup="CiarkaNaBodku(this);" style="width:62px; top:<?php echo $top; ?>px; left:830px;"/>
<input type="text" name="zvys09" id="zvys09" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:902px;"/>
<input type="text" name="zvys10" id="zvys10" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:986px;"/>
<input type="text" name="zvys11" id="zvys11" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:1058px;"/>
<input type="text" name="zvys12" id="zvys12" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:1142px;"/>

<!-- 25.ZNIZENIE -->
<span class="text-echo" style="top:945px; right:893px;"><?php echo $r25s01; ?></span>
<span class="text-echo" style="top:945px; right:822px;"><?php echo $r25s02; ?></span>
<span class="text-echo" style="top:945px; right:738px;"><?php echo $r25s03; ?></span>
<span class="text-echo" style="top:945px; right:666px;"><?php echo $r25s04; ?></span>
<span class="text-echo" style="top:945px; right:426px;"><?php echo $r25s07; ?></span>
<span class="text-echo" style="top:945px; right:354px;"><?php echo $r25s08; ?></span>
<span class="text-echo" style="top:945px; right:270px;"><?php echo $r25s09; ?></span>
<span class="text-echo" style="top:945px; right:198px;"><?php echo $r25s10; ?></span>
<span class="text-echo" style="top:945px; right:114px;"><?php echo $r25s11; ?></span>
<span class="text-echo" style="top:945px; right:43px;"><?php echo $r25s12; ?></span>
<?php                     } ?>


<?php if ( $strana == 3 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str3.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 3.strana 265kB" style="width:1250px; height:1000px;">

<!-- 30.verejna sprava spolu -->
<span class="text-echo" style="top:184px; right:893px;"><?php echo $r30s01; ?></span>
<span class="text-echo" style="top:184px; right:822px;"><?php echo $r30s02; ?></span>
<span class="text-echo" style="top:184px; right:738px;"><?php echo $r30s03; ?></span>
<span class="text-echo" style="top:184px; right:666px;"><?php echo $r30s04; ?></span>
<span class="text-echo" style="top:184px; right:426px;"><?php echo $r30s07; ?></span>
<span class="text-echo" style="top:184px; right:354px;"><?php echo $r30s08; ?></span>
<span class="text-echo" style="top:184px; right:270px;"><?php echo $r30s09; ?></span>
<span class="text-echo" style="top:184px; right:198px;"><?php echo $r30s10; ?></span>
<span class="text-echo" style="top:184px; right:114px;"><?php echo $r30s11; ?></span>
<span class="text-echo" style="top:184px; right:43px;"><?php echo $r30s12; ?></span>
<!-- 32.uzemna samosprava -->
<?php $top=232; ?>
<input type="text" name="znis01" id="znis01" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:279px;"/>
<input type="text" name="znis02" id="znis02" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:363px;"/>
<input type="text" name="znis03" id="znis03" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:435px;"/>
<input type="text" name="znis04" id="znis04" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:519px;"/>
<input type="text" name="znis07" id="znis07" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:746px;"/>
<input type="text" name="znis08" id="znis08" onkeyup="CiarkaNaBodku(this);" style="width:62px; top:<?php echo $top; ?>px; left:830px;"/>
<input type="text" name="znis09" id="znis09" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:902px;"/>
<input type="text" name="znis10" id="znis10" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:986px;"/>
<input type="text" name="znis11" id="znis11" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:1058px;"/>
<input type="text" name="znis12" id="znis12" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:1142px;"/>

<!-- 37.ZMENY V OCENENI -->
<?php $top=368; ?>
<input type="text" name="oces01" id="oces01" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:279px;"/>
<input type="text" name="oces02" id="oces02" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:363px;"/>
<input type="text" name="oces03" id="oces03" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:435px;"/>
<input type="text" name="oces04" id="oces04" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:519px;"/>
<input type="text" name="oces05" id="oces05" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:590px;"/>
<input type="text" name="oces06" id="oces06" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:675px;"/>
<input type="text" name="oces07" id="oces07" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:746px;"/>
<input type="text" name="oces08" id="oces08" onkeyup="CiarkaNaBodku(this);" style="width:62px; top:<?php echo $top; ?>px; left:830px;"/>
<input type="text" name="oces09" id="oces09" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:902px;"/>
<input type="text" name="oces10" id="oces10" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:986px;"/>
<input type="text" name="oces11" id="oces11" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:1058px;"/>
<input type="text" name="oces12" id="oces12" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:1142px;"/>

<!-- 38.OSTATNE ZMENY -->
<?php $top=405; ?>
<input type="text" name="osts01" id="osts01" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:279px;"/>
<input type="text" name="osts02" id="osts02" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:363px;"/>
<input type="text" name="osts03" id="osts03" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:435px;"/>
<input type="text" name="osts04" id="osts04" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:519px;"/>
<input type="text" name="osts05" id="osts05" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:590px;"/>
<input type="text" name="osts06" id="osts06" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:675px;"/>
<input type="text" name="osts07" id="osts07" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:746px;"/>
<input type="text" name="osts08" id="osts08" onkeyup="CiarkaNaBodku(this);" style="width:62px; top:<?php echo $top; ?>px; left:830px;"/>
<input type="text" name="osts09" id="osts09" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:902px;"/>
<input type="text" name="osts10" id="osts10" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:986px;"/>
<input type="text" name="osts11" id="osts11" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:1058px;"/>
<input type="text" name="osts12" id="osts12" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:1142px;"/>

<!-- 39.STAV k 31.12. -->
<span class="text-echo" style="top:465px; right:893px;"><?php echo $r39s01; ?></span>
<span class="text-echo" style="top:465px; right:822px;"><?php echo $r39s02; ?></span>
<span class="text-echo" style="top:465px; right:738px;"><?php echo $r39s03; ?></span>
<span class="text-echo" style="top:465px; right:666px;"><?php echo $r39s04; ?></span>
<span class="text-echo" style="top:465px; right:426px;"><?php echo $r39s07; ?></span>
<span class="text-echo" style="top:465px; right:354px;"><?php echo $r39s08; ?></span>
<span class="text-echo" style="top:465px; right:270px;"><?php echo $r39s09; ?></span>
<span class="text-echo" style="top:465px; right:198px;"><?php echo $r39s10; ?></span>
<span class="text-echo" style="top:465px; right:114px;"><?php echo $r39s11; ?></span>
<span class="text-echo" style="top:465px; right:43px;"><?php echo $r39s12; ?></span>
<!-- 44.verejna sprava spolu -->
<span class="text-echo" style="top:596px; right:893px;"><?php echo $r44s01; ?></span>
<span class="text-echo" style="top:596px; right:822px;"><?php echo $r44s02; ?></span>
<span class="text-echo" style="top:596px; right:738px;"><?php echo $r44s03; ?></span>
<span class="text-echo" style="top:596px; right:666px;"><?php echo $r44s04; ?></span>
<span class="text-echo" style="top:596px; right:426px;"><?php echo $r44s07; ?></span>
<span class="text-echo" style="top:596px; right:354px;"><?php echo $r44s08; ?></span>
<span class="text-echo" style="top:596px; right:270px;"><?php echo $r44s09; ?></span>
<span class="text-echo" style="top:596px; right:198px;"><?php echo $r44s10; ?></span>
<span class="text-echo" style="top:596px; right:114px;"><?php echo $r44s11; ?></span>
<span class="text-echo" style="top:596px; right:43px;"><?php echo $r44s12; ?></span>
<!-- 46.uzemna samosprava -->
<?php $top=645; ?>
<input type="text" name="zoss01" id="zoss01" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:279px;"/>
<input type="text" name="zoss02" id="zoss02" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:363px;"/>
<input type="text" name="zoss03" id="zoss03" onkeyup="CiarkaNaBodku(this);" style="width:73px; top:<?php echo $top; ?>px; left:435px;"/>
<input type="text" name="zoss04" id="zoss04" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:519px;"/>
<input type="text" name="zoss07" id="zoss07" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:746px;"/>
<input type="text" name="zoss08" id="zoss08" onkeyup="CiarkaNaBodku(this);" style="width:62px; top:<?php echo $top; ?>px; left:830px;"/>
<input type="text" name="zoss09" id="zoss09" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:902px;"/>
<input type="text" name="zoss10" id="zoss10" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:986px;"/>
<input type="text" name="zoss11" id="zoss11" onkeyup="CiarkaNaBodku(this);" style="width:74px; top:<?php echo $top; ?>px; left:1058px;"/>
<input type="text" name="zoss12" id="zoss12" onkeyup="CiarkaNaBodku(this);" style="width:61px; top:<?php echo $top; ?>px; left:1142px;"/>
<?php                     } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=1&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=2&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=3&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
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
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin404".
" WHERE F$kli_vxcf"."_uctvykaz_fin404.oc = $cislo_oc  ORDER BY oc";

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
$pdf->Cell(195,37.5," ","$rmc1",1,"L");
$pdf->Cell(20,4," ","$rmc1",0,"R");$pdf->Cell(4,3,"$text","$rmc",1,"C");

//ico
$text=$fir_ficox;
$textx="12345678";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(195,38.5," ","$rmc1",1,"L");
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
//$text="Èý0123456789abcdefghijklmnoprstuv";
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
$pdf->AddPage(L);
$pdf->SetFont('arial','',8);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str2.jpg') )
{
$pdf->Image($jpg_cesta.'_str2.jpg',5,0,305,200);
}
$pdf->SetY(10);

//VYBRANE AKTIVA
$pocs01=$hlavicka->pocs01; if ( $hlavicka->pocs01 == 0 ) $pocs01="";
$pocs02=$hlavicka->pocs02; if ( $hlavicka->pocs02 == 0 ) $pocs02="";
$pocs03=$hlavicka->pocs03; if ( $hlavicka->pocs03 == 0 ) $pocs03="";
$pocs04=$hlavicka->pocs04; if ( $hlavicka->pocs04 == 0 ) $pocs04="";
//$pocs05=$hlavicka->pocs05; if ( $hlavicka->pocs05 == 0 ) $pocs05="";
//$pocs06=$hlavicka->pocs06; if ( $hlavicka->pocs06 == 0 ) $pocs06="";
$pocs07=$hlavicka->pocs07; if ( $hlavicka->pocs07 == 0 ) $pocs07="";
$pocs08=$hlavicka->pocs08; if ( $hlavicka->pocs08 == 0 ) $pocs08="";
$pocs09=$hlavicka->pocs09; if ( $hlavicka->pocs09 == 0 ) $pocs09="";
$pocs10=$hlavicka->pocs10; if ( $hlavicka->pocs10 == 0 ) $pocs10="";
$pocs11=$hlavicka->pocs11; if ( $hlavicka->pocs11 == 0 ) $pocs11="";
$pocs12=$hlavicka->pocs12; if ( $hlavicka->pocs12 == 0 ) $pocs12="";
$r01s01=$pocs01;
$r01s02=$pocs02;
$r01s03=$pocs03;
$r01s04=$pocs04;
//$r01s05=$pocs05;
//$r01s06=$pocs06;
$r01s07=$pocs07;
$r01s08=$pocs08;
$r01s09=$pocs09;
$r01s10=$pocs10;
$r01s11=$pocs11;
$r01s12=$pocs12;
$r06s01=$pocs01; if ( $pocs01 == 0 ) $r06s01="";
$r06s02=$pocs02; if ( $pocs02 == 0 ) $r06s02="";
$r06s03=$pocs03; if ( $pocs03 == 0 ) $r06s03="";
$r06s04=$pocs04; if ( $pocs04 == 0 ) $r06s04="";
//$r06s05=$pocs05; if ( $pocs05 == 0 ) $r06s05="";
//$r06s06=$pocs06; if ( $pocs06 == 0 ) $r06s06="";
$r06s07=$pocs07; if ( $pocs07 == 0 ) $r06s07="";
$r06s08=$pocs08; if ( $pocs08 == 0 ) $r06s08="";
$r06s09=$pocs09; if ( $pocs09 == 0 ) $r06s09="";
$r06s10=$pocs10; if ( $pocs10 == 0 ) $r06s10="";
$r06s11=$pocs11; if ( $pocs11 == 0 ) $r06s11="";
$r06s12=$pocs12; if ( $pocs12 == 0 ) $r06s12="";
$zvys01=$hlavicka->zvys01; if ( $hlavicka->zvys01 == 0 ) $zvys01="";
$zvys02=$hlavicka->zvys02; if ( $hlavicka->zvys02 == 0 ) $zvys02="";
$zvys03=$hlavicka->zvys03; if ( $hlavicka->zvys03 == 0 ) $zvys03="";
$zvys04=$hlavicka->zvys04; if ( $hlavicka->zvys04 == 0 ) $zvys04="";
//$zvys05=$hlavicka->zvys05; if ( $hlavicka->zvys05 == 0 ) $zvys05="";
//$zvys06=$hlavicka->zvys06; if ( $hlavicka->zvys06 == 0 ) $zvys06="";
$zvys07=$hlavicka->zvys07; if ( $hlavicka->zvys07 == 0 ) $zvys07="";
$zvys08=$hlavicka->zvys08; if ( $hlavicka->zvys08 == 0 ) $zvys08="";
$zvys09=$hlavicka->zvys09; if ( $hlavicka->zvys09 == 0 ) $zvys09="";
$zvys10=$hlavicka->zvys10; if ( $hlavicka->zvys10 == 0 ) $zvys10="";
$zvys11=$hlavicka->zvys11; if ( $hlavicka->zvys11 == 0 ) $zvys11="";
$zvys12=$hlavicka->zvys12; if ( $hlavicka->zvys12 == 0 ) $zvys12="";
$r13s01=$zvys01;
$r13s02=$zvys02;
$r13s03=$zvys03;
$r13s04=$zvys04;
//$r13s05=$zvys05;
//$r13s06=$zvys06;
$r13s07=$zvys07;
$r13s08=$zvys08;
$r13s09=$zvys09;
$r13s10=$zvys10;
$r13s11=$zvys11;
$r13s12=$zvys12;
$r18s01=$zvys01; if ( $zvys01 == 0 ) $r18s01="";
$r18s02=$zvys02; if ( $zvys02 == 0 ) $r18s02="";
$r18s03=$zvys03; if ( $zvys03 == 0 ) $r18s03="";
$r18s04=$zvys04; if ( $zvys04 == 0 ) $r18s04="";
//$r18s05=$zvys05; if ( $zvys05 == 0 ) $r18s05="";
//$r18s06=$zvys06; if ( $zvys06 == 0 ) $r18s06="";
$r18s07=$zvys07; if ( $zvys07 == 0 ) $r18s07="";
$r18s08=$zvys08; if ( $zvys08 == 0 ) $r18s08="";
$r18s09=$zvys09; if ( $zvys09 == 0 ) $r18s09="";
$r18s10=$zvys10; if ( $zvys10 == 0 ) $r18s10="";
$r18s11=$zvys11; if ( $zvys11 == 0 ) $r18s11="";
$r18s12=$zvys12; if ( $zvys12 == 0 ) $r18s12="";
$znis01=$hlavicka->znis01; if ( $hlavicka->znis01 == 0 ) $znis01="";
$znis02=$hlavicka->znis02; if ( $hlavicka->znis02 == 0 ) $znis02="";
$znis03=$hlavicka->znis03; if ( $hlavicka->znis03 == 0 ) $znis03="";
$znis04=$hlavicka->znis04; if ( $hlavicka->znis04 == 0 ) $znis04="";
//$znis05=$hlavicka->znis05; if ( $hlavicka->znis05 == 0 ) $znis05="";
//$znis06=$hlavicka->znis06; if ( $hlavicka->znis06 == 0 ) $znis06="";
$znis07=$hlavicka->znis07; if ( $hlavicka->znis07 == 0 ) $znis07="";
$znis08=$hlavicka->znis08; if ( $hlavicka->znis08 == 0 ) $znis08="";
$znis09=$hlavicka->znis09; if ( $hlavicka->znis09 == 0 ) $znis09="";
$znis10=$hlavicka->znis10; if ( $hlavicka->znis10 == 0 ) $znis10="";
$znis11=$hlavicka->znis11; if ( $hlavicka->znis11 == 0 ) $znis11="";
$znis12=$hlavicka->znis12; if ( $hlavicka->znis12 == 0 ) $znis12="";
$r25s01=$znis01;
$r25s02=$znis02;
$r25s03=$znis03;
$r25s04=$znis04;
//$r25s05=$znis05;
//$r25s06=$znis06;
$r25s07=$znis07;
$r25s08=$znis08;
$r25s09=$znis09;
$r25s10=$znis10;
$r25s11=$znis11;
$r25s12=$znis12;

//1.STAV k 1.1.
$pdf->SetY(44.5);
$pdf->Cell(62,3," ","$rmc1",0,"R");
$pdf->Cell(21,7,"$r01s01","$rmc",0,"R");$pdf->Cell(17,7,"$r01s02","$rmc",0,"R");
$pdf->Cell(21,7,"$r01s03","$rmc",0,"R");$pdf->Cell(17,7,"$r01s04","$rmc",0,"R");
$pdf->Cell(21,7," ","$rmc",0,"R");$pdf->Cell(17.5,7," ","$rmc",0,"R");
$pdf->Cell(20.5,7,"$r01s07","$rmc",0,"R");$pdf->Cell(17.5,7,"$r01s08","$rmc",0,"R");
$pdf->Cell(20.5,7,"$r01s09","$rmc",0,"R");$pdf->Cell(17.5,7,"$r01s10","$rmc",0,"R");
$pdf->Cell(20.5,7,"$r01s11","$rmc",0,"R");$pdf->Cell(17,7,"$r01s12","$rmc",1,"R");
//6.verejna sprava spolu
$pdf->SetY(72);
$pdf->Cell(62,3," ","$rmc1",0,"R");
$pdf->Cell(21,6,"$r06s01","$rmc",0,"R");$pdf->Cell(17,6,"$r06s02","$rmc",0,"R");
$pdf->Cell(21,6,"$r06s03","$rmc",0,"R");$pdf->Cell(17,6,"$r06s04","$rmc",0,"R");
$pdf->Cell(21,6," ","$rmc",0,"R");$pdf->Cell(17.5,6," ","$rmc",0,"R");
$pdf->Cell(20.5,6,"$r06s07","$rmc",0,"R");$pdf->Cell(17.5,6,"$r06s08","$rmc",0,"R");
$pdf->Cell(20.5,6,"$r06s09","$rmc",0,"R");$pdf->Cell(17.5,6,"$r06s10","$rmc",0,"R");
$pdf->Cell(20.5,6,"$r06s11","$rmc",0,"R");$pdf->Cell(17,6,"$r06s12","$rmc",1,"R");
//8.uzemna samosprava
$pdf->SetY(82.5);
$pdf->Cell(62,3," ","$rmc1",0,"R");
$pdf->Cell(21,6,"$pocs01","$rmc",0,"R");$pdf->Cell(17,6,"$pocs02","$rmc",0,"R");
$pdf->Cell(21,6,"$pocs03","$rmc",0,"R");$pdf->Cell(17,6,"$pocs04","$rmc",0,"R");
$pdf->Cell(21,6," ","$rmc",0,"R");$pdf->Cell(17.5,6," ","$rmc",0,"R");
$pdf->Cell(20.5,6,"$pocs07","$rmc",0,"R");$pdf->Cell(17.5,6,"$pocs08","$rmc",0,"R");
$pdf->Cell(20.5,6,"$pocs09","$rmc",0,"R");$pdf->Cell(17.5,6,"$pocs10","$rmc",0,"R");
$pdf->Cell(20.5,6,"$pocs11","$rmc",0,"R");$pdf->Cell(17,6,"$pocs12","$rmc",1,"R");

//13.ZVYSENIE
$pdf->SetY(116);
$pdf->Cell(62,3," ","$rmc1",0,"R");
$pdf->Cell(21,7,"$r13s01","$rmc",0,"R");$pdf->Cell(17,7,"$r13s02","$rmc",0,"R");
$pdf->Cell(21,7,"$r13s03","$rmc",0,"R");$pdf->Cell(17,7,"$r13s04","$rmc",0,"R");
$pdf->Cell(21,7," ","$rmc",0,"R");$pdf->Cell(17.5,7," ","$rmc",0,"R");
$pdf->Cell(20.5,7,"$r13s07","$rmc",0,"R");$pdf->Cell(17.5,7,"$r13s08","$rmc",0,"R");
$pdf->Cell(20.5,7,"$r13s09","$rmc",0,"R");$pdf->Cell(17.5,7,"$r13s10","$rmc",0,"R");
$pdf->Cell(20.5,7,"$r13s11","$rmc",0,"R");$pdf->Cell(17,7,"$r13s12","$rmc",1,"R");
//18.verejna sprava spolu
$pdf->SetY(144);
$pdf->Cell(62,3," ","$rmc1",0,"R");
$pdf->Cell(21,6,"$r18s01","$rmc",0,"R");$pdf->Cell(17,6,"$r18s02","$rmc",0,"R");
$pdf->Cell(21,6,"$r18s03","$rmc",0,"R");$pdf->Cell(17,6,"$r18s04","$rmc",0,"R");
$pdf->Cell(21,6," ","$rmc",0,"R");$pdf->Cell(17.5,6," ","$rmc",0,"R");
$pdf->Cell(20.5,6,"$r18s07","$rmc",0,"R");$pdf->Cell(17.5,6,"$r18s08","$rmc",0,"R");
$pdf->Cell(20.5,6,"$r18s09","$rmc",0,"R");$pdf->Cell(17.5,6,"$r18s10","$rmc",0,"R");
$pdf->Cell(20.5,6,"$r18s11","$rmc",0,"R");$pdf->Cell(17,6,"$r18s12","$rmc",1,"R");
//20.uzemna samosprava
$pdf->SetY(155);
$pdf->Cell(62,3," ","$rmc1",0,"R");
$pdf->Cell(21,6,"$zvys01","$rmc",0,"R");$pdf->Cell(17,6,"$zvys02","$rmc",0,"R");
$pdf->Cell(21,6,"$zvys03","$rmc",0,"R");$pdf->Cell(17,6,"$zvys04","$rmc",0,"R");
$pdf->Cell(21,6," ","$rmc",0,"R");$pdf->Cell(17.5,6," ","$rmc",0,"R");
$pdf->Cell(20.5,6,"$zvys07","$rmc",0,"R");$pdf->Cell(17.5,6,"$zvys08","$rmc",0,"R");
$pdf->Cell(20.5,6,"$zvys09","$rmc",0,"R");$pdf->Cell(17.5,6,"$zvys10","$rmc",0,"R");
$pdf->Cell(20.5,6,"$zvys11","$rmc",0,"R");$pdf->Cell(17,6,"$zvys12","$rmc",1,"R");

//25.ZNIZENIE
$pdf->SetY(181);
$pdf->Cell(62,3," ","$rmc1",0,"R");
$pdf->Cell(21,7,"$r25s01","$rmc",0,"R");$pdf->Cell(17,7,"$r25s02","$rmc",0,"R");
$pdf->Cell(21,7,"$r25s03","$rmc",0,"R");$pdf->Cell(17,7,"$r25s04","$rmc",0,"R");
$pdf->Cell(21,7," ","$rmc",0,"R");$pdf->Cell(17.5,7," ","$rmc",0,"R");
$pdf->Cell(20.5,7,"$r25s07","$rmc",0,"R");$pdf->Cell(17.5,7,"$r25s08","$rmc",0,"R");
$pdf->Cell(20.5,7,"$r25s09","$rmc",0,"R");$pdf->Cell(17.5,7,"$r25s10","$rmc",0,"R");
$pdf->Cell(20.5,7,"$r25s11","$rmc",0,"R");$pdf->Cell(17,7,"$r25s12","$rmc",1,"R");
                                       }

if ( $strana == 3 OR $strana == 9999 ) {
$pdf->AddPage(L);
$pdf->SetFont('arial','',8);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str3.jpg') )
{
$pdf->Image($jpg_cesta.'_str3.jpg',5,0,305,200);
}
$pdf->SetY(10);

//VYBRANE AKTIVA
$znis01=$hlavicka->znis01; if ( $hlavicka->znis01 == 0 ) $znis01="";
$znis02=$hlavicka->znis02; if ( $hlavicka->znis02 == 0 ) $znis02="";
$znis03=$hlavicka->znis03; if ( $hlavicka->znis03 == 0 ) $znis03="";
$znis04=$hlavicka->znis04; if ( $hlavicka->znis04 == 0 ) $znis04="";
//$znis05=$hlavicka->znis05; if ( $hlavicka->znis05 == 0 ) $znis05="";
//$znis06=$hlavicka->znis06; if ( $hlavicka->znis06 == 0 ) $znis06="";
$znis07=$hlavicka->znis07; if ( $hlavicka->znis07 == 0 ) $znis07="";
$znis08=$hlavicka->znis08; if ( $hlavicka->znis08 == 0 ) $znis08="";
$znis09=$hlavicka->znis09; if ( $hlavicka->znis09 == 0 ) $znis09="";
$znis10=$hlavicka->znis10; if ( $hlavicka->znis10 == 0 ) $znis10="";
$znis11=$hlavicka->znis11; if ( $hlavicka->znis11 == 0 ) $znis11="";
$znis12=$hlavicka->znis12; if ( $hlavicka->znis12 == 0 ) $znis12="";
$r30s01=$znis01; if ( $znis01 == 0 ) $r30s01="";
$r30s02=$znis02; if ( $znis02 == 0 ) $r30s02="";
$r30s03=$znis03; if ( $znis03 == 0 ) $r30s03="";
$r30s04=$znis04; if ( $znis04 == 0 ) $r30s04="";
//$r30s05=$znis05; if ( $znis05 == 0 ) $r30s05="";
//$r30s06=$znis06; if ( $znis06 == 0 ) $r30s06="";
$r30s07=$znis07; if ( $znis07 == 0 ) $r30s07="";
$r30s08=$znis08; if ( $znis08 == 0 ) $r30s08="";
$r30s09=$znis09; if ( $znis09 == 0 ) $r30s09="";
$r30s10=$znis10; if ( $znis10 == 0 ) $r30s10="";
$r30s11=$znis11; if ( $znis11 == 0 ) $r30s11="";
$r30s12=$znis12; if ( $znis12 == 0 ) $r30s12="";
$oces01=$hlavicka->oces01; if ( $hlavicka->oces01 == 0 ) $oces01="";
$oces02=$hlavicka->oces02; if ( $hlavicka->oces02 == 0 ) $oces02="";
$oces03=$hlavicka->oces03; if ( $hlavicka->oces03 == 0 ) $oces03="";
$oces04=$hlavicka->oces04; if ( $hlavicka->oces04 == 0 ) $oces04="";
$oces05=$hlavicka->oces05; if ( $hlavicka->oces05 == 0 ) $oces05="";
$oces06=$hlavicka->oces06; if ( $hlavicka->oces06 == 0 ) $oces06="";
$oces07=$hlavicka->oces07; if ( $hlavicka->oces07 == 0 ) $oces07="";
$oces08=$hlavicka->oces08; if ( $hlavicka->oces08 == 0 ) $oces08="";
$oces09=$hlavicka->oces09; if ( $hlavicka->oces09 == 0 ) $oces09="";
$oces10=$hlavicka->oces10; if ( $hlavicka->oces10 == 0 ) $oces10="";
$oces11=$hlavicka->oces11; if ( $hlavicka->oces11 == 0 ) $oces11="";
$oces12=$hlavicka->oces12; if ( $hlavicka->oces12 == 0 ) $oces12="";
$osts01=$hlavicka->osts01; if ( $hlavicka->osts01 == 0 ) $osts01="";
$osts02=$hlavicka->osts02; if ( $hlavicka->osts02 == 0 ) $osts02="";
$osts03=$hlavicka->osts03; if ( $hlavicka->osts03 == 0 ) $osts03="";
$osts04=$hlavicka->osts04; if ( $hlavicka->osts04 == 0 ) $osts04="";
$osts05=$hlavicka->osts05; if ( $hlavicka->osts05 == 0 ) $osts05="";
$osts06=$hlavicka->osts06; if ( $hlavicka->osts06 == 0 ) $osts06="";
$osts07=$hlavicka->osts07; if ( $hlavicka->osts07 == 0 ) $osts07="";
$osts08=$hlavicka->osts08; if ( $hlavicka->osts08 == 0 ) $osts08="";
$osts09=$hlavicka->osts09; if ( $hlavicka->osts09 == 0 ) $osts09="";
$osts10=$hlavicka->osts10; if ( $hlavicka->osts10 == 0 ) $osts10="";
$osts11=$hlavicka->osts11; if ( $hlavicka->osts11 == 0 ) $osts11="";
$osts12=$hlavicka->osts12; if ( $hlavicka->osts12 == 0 ) $osts12="";
$zoss01=$hlavicka->zoss01; if ( $hlavicka->zoss01 == 0 ) $zoss01="";
$zoss02=$hlavicka->zoss02; if ( $hlavicka->zoss02 == 0 ) $zoss02="";
$zoss03=$hlavicka->zoss03; if ( $hlavicka->zoss03 == 0 ) $zoss03="";
$zoss04=$hlavicka->zoss04; if ( $hlavicka->zoss04 == 0 ) $zoss04="";
//$zoss05=$hlavicka->zoss05; if ( $hlavicka->zoss05 == 0 ) $zoss05="";
//$zoss06=$hlavicka->zoss06; if ( $hlavicka->zoss06 == 0 ) $zoss06="";
$zoss07=$hlavicka->zoss07; if ( $hlavicka->zoss07 == 0 ) $zoss07="";
$zoss08=$hlavicka->zoss08; if ( $hlavicka->zoss08 == 0 ) $zoss08="";
$zoss09=$hlavicka->zoss09; if ( $hlavicka->zoss09 == 0 ) $zoss09="";
$zoss10=$hlavicka->zoss10; if ( $hlavicka->zoss10 == 0 ) $zoss10="";
$zoss11=$hlavicka->zoss11; if ( $hlavicka->zoss11 == 0 ) $zoss11="";
$zoss12=$hlavicka->zoss12; if ( $hlavicka->zoss12 == 0 ) $zoss12="";
$r39s01=$zoss01;
$r39s02=$zoss02;
$r39s03=$zoss03;
$r39s04=$zoss04;
//$r39s05=$zoss05;
//$r39s06=$zoss06;
$r39s07=$zoss07;
$r39s08=$zoss08;
$r39s09=$zoss09;
$r39s10=$zoss10;
$r39s11=$zoss11;
$r39s12=$zoss12;
$r44s01=$zoss01; if ( $zoss01 == 0 ) $r44s01="";
$r44s02=$zoss02; if ( $zoss02 == 0 ) $r44s02="";
$r44s03=$zoss03; if ( $zoss03 == 0 ) $r44s03="";
$r44s04=$zoss04; if ( $zoss04 == 0 ) $r44s04="";
//$r44s05=$zoss05; if ( $zoss05 == 0 ) $r44s05="";
//$r44s06=$zoss06; if ( $zoss06 == 0 ) $r44s06="";
$r44s07=$zoss07; if ( $zoss07 == 0 ) $r44s07="";
$r44s08=$zoss08; if ( $zoss08 == 0 ) $r44s08="";
$r44s09=$zoss09; if ( $zoss09 == 0 ) $r44s09="";
$r44s10=$zoss10; if ( $zoss10 == 0 ) $r44s10="";
$r44s11=$zoss11; if ( $zoss11 == 0 ) $r44s11="";
$r44s12=$zoss12; if ( $zoss12 == 0 ) $r44s12="";

//30.verejna sprava spolu
$pdf->SetY(30.5);
$pdf->Cell(62,3," ","$rmc1",0,"R");
$pdf->Cell(21,6,"$r30s01","$rmc",0,"R");$pdf->Cell(17,6,"$r30s02","$rmc",0,"R");
$pdf->Cell(21,6,"$r30s03","$rmc",0,"R");$pdf->Cell(17,6,"$r30s04","$rmc",0,"R");
$pdf->Cell(21,6," ","$rmc",0,"R");$pdf->Cell(17.5,6," ","$rmc",0,"R");
$pdf->Cell(20.5,6,"$r30s07","$rmc",0,"R");$pdf->Cell(17.5,6,"$r30s08","$rmc",0,"R");
$pdf->Cell(20.5,6,"$r30s09","$rmc",0,"R");$pdf->Cell(17.5,6,"$r30s10","$rmc",0,"R");
$pdf->Cell(20.5,6,"$r30s11","$rmc",0,"R");$pdf->Cell(17,6,"$r30s12","$rmc",1,"R");
//32.uzemna samosprava
$pdf->SetY(41);
$pdf->Cell(62,3," ","$rmc1",0,"R");
$pdf->Cell(21,6,"$znis01","$rmc",0,"R");$pdf->Cell(17,6,"$znis02","$rmc",0,"R");
$pdf->Cell(21,6,"$znis03","$rmc",0,"R");$pdf->Cell(17,6,"$znis04","$rmc",0,"R");
$pdf->Cell(21,6," ","$rmc",0,"R");$pdf->Cell(17.5,6," ","$rmc",0,"R");
$pdf->Cell(20.5,6,"$znis07","$rmc",0,"R");$pdf->Cell(17.5,6,"$znis08","$rmc",0,"R");
$pdf->Cell(20.5,6,"$znis09","$rmc",0,"R");$pdf->Cell(17.5,6,"$znis10","$rmc",0,"R");
$pdf->Cell(20.5,6,"$znis11","$rmc",0,"R");$pdf->Cell(17,6,"$znis12","$rmc",1,"R");

//37.ZMENY V OCENENI
$pdf->SetY(67.5);
$pdf->Cell(62,3," ","$rmc1",0,"R");
$pdf->Cell(21,7,"$oces01","$rmc",0,"R");$pdf->Cell(17,7,"$oces02","$rmc",0,"R");
$pdf->Cell(21,7,"$oces03","$rmc",0,"R");$pdf->Cell(17,7,"$oces04","$rmc",0,"R");
$pdf->Cell(21,7,"$oces05","$rmc",0,"R");$pdf->Cell(17.5,7,"$oces06","$rmc",0,"R");
$pdf->Cell(20.5,7,"$oces07","$rmc",0,"R");$pdf->Cell(17.5,7,"$oces08","$rmc",0,"R");
$pdf->Cell(20.5,7,"$oces09","$rmc",0,"R");$pdf->Cell(17.5,7,"$oces10","$rmc",0,"R");
$pdf->Cell(20.5,7,"$oces11","$rmc",0,"R");$pdf->Cell(17,7,"$oces12","$rmc",1,"R");

//38.OSTATNE ZMENY
$pdf->SetY(75);
$pdf->Cell(62,3," ","$rmc1",0,"R");
$pdf->Cell(21,7,"$osts01","$rmc",0,"R");$pdf->Cell(17,7,"$osts02","$rmc",0,"R");
$pdf->Cell(21,7,"$osts03","$rmc",0,"R");$pdf->Cell(17,7,"$osts04","$rmc",0,"R");
$pdf->Cell(21,7,"$osts05","$rmc",0,"R");$pdf->Cell(17.5,7,"$osts06","$rmc",0,"R");
$pdf->Cell(20.5,7,"$osts07","$rmc",0,"R");$pdf->Cell(17.5,7,"$osts08","$rmc",0,"R");
$pdf->Cell(20.5,7,"$osts09","$rmc",0,"R");$pdf->Cell(17.5,7,"$osts10","$rmc",0,"R");
$pdf->Cell(20.5,7,"$osts11","$rmc",0,"R");$pdf->Cell(17,7,"$osts12","$rmc",1,"R");

//39.STAV k 31.12.
$pdf->SetY(82);
$pdf->Cell(62,3," ","$rmc1",0,"R");
$pdf->Cell(21,10,"$r39s01","$rmc",0,"R");$pdf->Cell(17,10,"$r39s02","$rmc",0,"R");
$pdf->Cell(21,10,"$r39s03","$rmc",0,"R");$pdf->Cell(17,10,"$r39s04","$rmc",0,"R");
$pdf->Cell(21,10," ","$rmc",0,"R");$pdf->Cell(17.5,10," ","$rmc",0,"R");
$pdf->Cell(20.5,10,"$r39s07","$rmc",0,"R");$pdf->Cell(17.5,10,"$r39s08","$rmc",0,"R");
$pdf->Cell(20.5,10,"$r39s09","$rmc",0,"R");$pdf->Cell(17.5,10,"$r39s10","$rmc",0,"R");
$pdf->Cell(20.5,10,"$r39s11","$rmc",0,"R");$pdf->Cell(17,10,"$r39s12","$rmc",1,"R");
//44.verejna sprava spolu
$pdf->SetY(113);
$pdf->Cell(62,3," ","$rmc1",0,"R");
$pdf->Cell(21,6,"$r44s01","$rmc",0,"R");$pdf->Cell(17,6,"$r44s02","$rmc",0,"R");
$pdf->Cell(21,6,"$r44s03","$rmc",0,"R");$pdf->Cell(17,6,"$r44s04","$rmc",0,"R");
$pdf->Cell(21,6," ","$rmc",0,"R");$pdf->Cell(17.5,6," ","$rmc",0,"R");
$pdf->Cell(20.5,6,"$r44s07","$rmc",0,"R");$pdf->Cell(17.5,6,"$r44s08","$rmc",0,"R");
$pdf->Cell(20.5,6,"$r44s09","$rmc",0,"R");$pdf->Cell(17.5,6,"$r44s10","$rmc",0,"R");
$pdf->Cell(20.5,6,"$r44s11","$rmc",0,"R");$pdf->Cell(17,6,"$r44s12","$rmc",1,"R");
//46.uzemna samosprava
$pdf->SetY(123.5);
$pdf->Cell(62,3," ","$rmc1",0,"R");
$pdf->Cell(21,6,"$zoss01","$rmc",0,"R");$pdf->Cell(17,6,"$zoss02","$rmc",0,"R");
$pdf->Cell(21,6,"$zoss03","$rmc",0,"R");$pdf->Cell(17,6,"$zoss04","$rmc",0,"R");
$pdf->Cell(21,6," ","$rmc",0,"R");$pdf->Cell(17.5,6," ","$rmc",0,"R");
$pdf->Cell(20.5,6,"$zoss07","$rmc",0,"R");$pdf->Cell(17.5,6,"$zoss08","$rmc",0,"R");
$pdf->Cell(20.5,6,"$zoss09","$rmc",0,"R");$pdf->Cell(17.5,6,"$zoss10","$rmc",0,"R");
$pdf->Cell(20.5,6,"$zoss11","$rmc",0,"R");$pdf->Cell(17,6,"$zoss12","$rmc",1,"R");
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