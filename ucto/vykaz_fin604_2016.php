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
if ( $kli_vrok < 2018 ) {
$jpg_cesta="../dokumenty/statistika2016/fin604/fin6-04_v16";
                        }
if ( $kli_vrok >= 2018 ) {
$jpg_cesta="../dokumenty/tlacivo2018/fin6-04/fin6-04_v18";
                         }
$jpg_popis="Finanèný výkaz o bankových úètoch a záväzkoch obcí, VÚC a nimi zriadených rozpoètových organizácií FIN 6-04 za rok ".$kli_vrok;

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
$sql = "SELECT * FROM F".$kli_vxcf."_genfin604 ";
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

$sql = "DROP TABLE F$kli_vxcf"."_genfin604";
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

$sql = 'CREATE TABLE F'.$kli_vxcf.'_genfin604'.$sqlt;
$vysledek = mysql_query("$sql");


$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '221', '1' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '211', '1' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '261', '1' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '231', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '232', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '241', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '249', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '321', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '322', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '323', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '324', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '325', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '326', '4' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '331', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '333', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '336', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '341', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '342', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '343', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '345', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '346', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '348', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '367', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '368', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '373', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '379', '4' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '395', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '398', '4' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '461', '4' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '472', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '473', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '474', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '475', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '476', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '478', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 ( uce,crs ) VALUES ( '479', '4' ); "; $ulozene = mysql_query("$sqult");


//sumar za ucet=ak jeden ucet v dvoch riadkoch tak zober jeden
$sqult = "UPDATE F$kli_vxcf"."_genfin604 SET cpl01=1 "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin604 SELECT 0,uce,crs,0 FROM F$kli_vxcf"."_genfin604 GROUP BY uce "; $ulozene = mysql_query("$sqult");
$sqult = "DELETE FROM F$kli_vxcf"."_genfin604 WHERE cpl01 != 0 "; $ulozene = mysql_query("$sqult");

$nacitajgen = 1*$_REQUEST['nacitajgen'];
if ( $nacitajgen == 1 ) {
?>
<script type="text/javascript">
  window.open('../ucto/fin_cis.php?copern=308&drupoh=96&page=1&sysx=UCT', '_self');
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

$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin604 WHERE oc = $cislo_oc ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $nasielvyplnene=1;

  $riaddok=mysql_fetch_object($sqldok);
  $xokres=1*$riaddok->okres;
  $xobec=1*$riaddok->obec;
  }

$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin604 WHERE oc = $cislo_oc";
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

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin604 SET ".
" daz='$daz_sql' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 2 ) {
$r01 = 1*$_REQUEST['r01']; $rm01 = 1*$_REQUEST['rm01'];
$r02 = 1*$_REQUEST['r02']; $rm02 = 1*$_REQUEST['rm02'];
$r03 = 1*$_REQUEST['r03']; $rm03 = 1*$_REQUEST['rm03'];
$r04 = 1*$_REQUEST['r04']; $rm04 = 1*$_REQUEST['rm04'];
$r05 = 1*$_REQUEST['r05']; $rm05 = 1*$_REQUEST['rm05'];
$r06 = 1*$_REQUEST['r06']; $rm06 = 1*$_REQUEST['rm06'];
$r07 = 1*$_REQUEST['r07']; $rm07 = 1*$_REQUEST['rm07'];
$r08 = 1*$_REQUEST['r08']; $rm08 = 1*$_REQUEST['rm08'];
$r09 = 1*$_REQUEST['r09']; $rm09 = 1*$_REQUEST['rm09'];
$r10 = 1*$_REQUEST['r10']; $rm10 = 1*$_REQUEST['rm10'];
$r11 = 1*$_REQUEST['r11']; $rm11 = 1*$_REQUEST['rm11'];
$r12 = 1*$_REQUEST['r12']; $rm12 = 1*$_REQUEST['rm12'];
$r13 = 1*$_REQUEST['r13']; $rm13 = 1*$_REQUEST['rm13'];
$r14 = 1*$_REQUEST['r14']; $rm14 = 1*$_REQUEST['rm14'];

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin604 SET ".
" r01='$r01', rm01='$rm01', r02='$r02', rm02='$rm02', r03='$r03', rm03='$rm03',
  r04='$r04', rm04='$rm04', r05='$r05', rm05='$rm05', r06='$r06', rm06='$rm06',
  r07='$r07', rm07='$rm07', r08='$r08', rm08='$rm08', r09='$r09', rm09='$rm09',
  r10='$r10', rm10='$rm10', r11='$r11', rm11='$rm11', r12='$r12', rm12='$rm12',
  r13='$r13', rm13='$rm13', r14='$r14', rm14='$rm14' ".
" WHERE oc = $cislo_oc";
                    }
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

$nepoc = 1*$_REQUEST['nepoc'];
$vsetkyprepocty=1;
if( $nepoc == 1 ) $vsetkyprepocty=0;

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


$sql = "SELECT rm14 FROM F".$kli_vxcf."_uctvykaz_fin604";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin604';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin604d2';
//$vysledok = mysql_query("$sqlt");


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
   r01          DECIMAL($pocdes),
   r02          DECIMAL($pocdes),
   r03          DECIMAL($pocdes),
   r04          DECIMAL($pocdes),
   r05          DECIMAL($pocdes),
   r06          DECIMAL($pocdes),
   r07          DECIMAL($pocdes),
   r08          DECIMAL($pocdes),
   r09          DECIMAL($pocdes),
   r10          DECIMAL($pocdes),
   r11          DECIMAL($pocdes),
   r12          DECIMAL($pocdes),
   r13          DECIMAL($pocdes),
   r14          DECIMAL($pocdes),
   rm01          DECIMAL($pocdes),
   rm02          DECIMAL($pocdes),
   rm03          DECIMAL($pocdes),
   rm04          DECIMAL($pocdes),
   rm05          DECIMAL($pocdes),
   rm06          DECIMAL($pocdes),
   rm07          DECIMAL($pocdes),
   rm08          DECIMAL($pocdes),
   rm09          DECIMAL($pocdes),
   rm10          DECIMAL($pocdes),
   rm11          DECIMAL($pocdes),
   rm12          DECIMAL($pocdes),
   rm13          DECIMAL($pocdes),
   rm14          DECIMAL($pocdes),
   ico           INT
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctvykaz_fin604'.$sqlt;
$vytvor = mysql_query("$vsql");
}
//koniec vytvorenie


$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_fin604";
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_fin604";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
//exit;


$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin604 WHERE oc = $cislo_oc";
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
" 0,0,uce,uce,0,0,0,0,pmd,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pmd != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" -pda,$cislo_oc,0,'','','0000-00-00',".
" 0,0,uce,uce,0,0,0,0,0,pda,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
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
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucm > 0 AND ume <= $kli_vume";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
" 0,0,ucd,0,ucd,0,0,0,0,F$kli_vxcf"."_$uctovanie.hod,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
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
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie".
" WHERE ( ucm > 0 AND ume <= $kli_vume ) GROUP BY F$kli_vxcf"."_$uctovanie.ucm";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
" 0,0,ucd,0,ucd,0,0,0,0,SUM(hod),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie".
" WHERE ( ucd > 0 AND ume <= $kli_vume ) GROUP BY F$kli_vxcf"."_$uctovanie.ucd";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid,F$kli_vxcf"."_genfin604".
" SET rdk=F$kli_vxcf"."_genfin604.crs".
" WHERE LEFT(F$kli_vxcf"."_uctprcvykaz$kli_uzid.uce,3) = LEFT(F$kli_vxcf"."_genfin604.uce,3) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid,F$kli_vxcf"."_genfin604".
" SET rdk=F$kli_vxcf"."_genfin604.crs".
" WHERE F$kli_vxcf"."_uctprcvykaz$kli_uzid.uce = F$kli_vxcf"."_genfin604.uce ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
//exit;



//rozdel do riadkov , vypocitaj netto

$rdk=1;
while ($rdk <= 14 )
  {
$crdk=$rdk;
if( $rdk < 10 ) $crdk="0".$rdk;

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET r$crdk=mdt-dal WHERE rdk = $rdk ";
if( $rdk >= 4 ) { $sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET r$crdk=dal-mdt WHERE rdk = $rdk "; }
$oznac = mysql_query("$sqtoz");



$rdk=$rdk+1;
  }



//sumar za riadky
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid "." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
" 0,1,uce,ucm,ucd,rdk,prv,hod,mdt,dal,".
"SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),SUM(r11),SUM(r12),SUM(r13),SUM(r14), ".
"SUM(rm01),SUM(rm02),SUM(rm03),SUM(rm04),SUM(rm05),SUM(rm06),SUM(rm07),SUM(rm08),SUM(rm09),SUM(rm10),SUM(rm11),SUM(rm12),SUM(rm13),SUM(rm14), ".
"$fir_fico".
" FROM F$kli_vxcf"."_uctprcvykaz$kli_uzid".
" WHERE rdk >= 0".
" GROUP BY prx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

/////////////////////////////////koniec naCITAJ HODNOTY

//uloz
$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin604 WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");


$dsqlt = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin604".
" SELECT * FROM F$kli_vxcf"."_uctprcvykaz".$kli_uzid." WHERE oc = $cislo_oc AND prx = 1 ".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


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
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin604 WHERE oc = $cislo_oc ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

if ( $strana == 1 OR $strana == 9999 )
{
$daz = $fir_riadok->daz;
$daz_sk=SkDatum($daz);
}

if ( $strana == 2 )
{
$r01 = $fir_riadok->r01;
$rm01 = $fir_riadok->rm01;
$r02 = $fir_riadok->r02;
$rm02 = $fir_riadok->rm02;
$r03 = $fir_riadok->r03;
$rm03 = $fir_riadok->rm03;
$r04 = $fir_riadok->r04;
$rm04 = $fir_riadok->rm04;
$r05 = $fir_riadok->r05;
$rm05 = $fir_riadok->rm05;
$r06 = $fir_riadok->r06;
$rm06 = $fir_riadok->rm06;
$r07 = $fir_riadok->r07;
$rm07 = $fir_riadok->rm07;
$r08 = $fir_riadok->r08;
$rm08 = $fir_riadok->rm08;
$r09 = $fir_riadok->r09;
$rm09 = $fir_riadok->rm09;
$r10 = $fir_riadok->r10;
$rm10 = $fir_riadok->rm10;
$r11 = $fir_riadok->r11;
$rm11 = $fir_riadok->rm11;
$r12 = $fir_riadok->r12;
$rm12 = $fir_riadok->rm12;
$r13 = $fir_riadok->r13;
$rm13 = $fir_riadok->rm13;
$r14 = $fir_riadok->r14;
$rm14 = $fir_riadok->rm14;
}
mysql_free_result($fir_vysledok);
    }
//koniec nacitania

//6-miestne ico
$fir_ficox=$fir_fico; if ( $fir_ficox < 999999 ) { $fir_ficox="00".$fir_ficox; }

//skrateny datum k
$skutku=substr($datum,0,6);
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
<link rel="stylesheet" href="../css/reset.css">
<link rel="stylesheet" href="../css/tlaciva.css">
<title>Výkaz FIN 6-04</title>
<style type="text/css">
img.btn-row-tool {
  width: 20px;
  height: 20px;
}
form input[type=text] {
  height: 20px;
  line-height: 20px;
  padding-left: 4px;
  border: 1px solid #39f;
  font-size: 14px;
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
   document.formv1.daz.value = '<?php echo $daz_sk; ?>';
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
   document.formv1.r01.value = '<?php echo $r01;?>';
   document.formv1.rm01.value = '<?php echo $rm01;?>';
   document.formv1.r02.value = '<?php echo $r02;?>';
   document.formv1.rm02.value = '<?php echo $rm02;?>';
   document.formv1.r03.value = '<?php echo $r03;?>';
   document.formv1.rm03.value = '<?php echo $rm03;?>';
   document.formv1.r04.value = '<?php echo $r04;?>';
   document.formv1.rm04.value = '<?php echo $rm04;?>';
   document.formv1.r05.value = '<?php echo $r05;?>';
   document.formv1.rm05.value = '<?php echo $rm05;?>';
   document.formv1.r06.value = '<?php echo $r06;?>';
   document.formv1.rm06.value = '<?php echo $rm06;?>';
   document.formv1.r07.value = '<?php echo $r07;?>';
   document.formv1.rm07.value = '<?php echo $rm07;?>';
   document.formv1.r08.value = '<?php echo $r08;?>';
   document.formv1.rm08.value = '<?php echo $rm08;?>';
   document.formv1.r09.value = '<?php echo $r09;?>';
   document.formv1.rm09.value = '<?php echo $rm09;?>';
   document.formv1.r10.value = '<?php echo $r10;?>';
   document.formv1.rm10.value = '<?php echo $rm10;?>';
   document.formv1.r11.value = '<?php echo $r11;?>';
   document.formv1.rm11.value = '<?php echo $rm11;?>';
   document.formv1.r12.value = '<?php echo $r12;?>';
   document.formv1.rm12.value = '<?php echo $rm12;?>';
   document.formv1.r13.value = '<?php echo $r13;?>';
   document.formv1.rm13.value = '<?php echo $rm13;?>';
   document.formv1.r14.value = '<?php echo $r14;?>';
   document.formv1.rm14.value = '<?php echo $rm14;?>';
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
   window.open('vykaz_fin604_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999',
 '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function Nacitaj()
  {
   window.open('vykaz_fin604_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=0&strana=1',
'_self', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }

function DbfFin604()
                {
window.open('fin604dbf_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function CsvFin604()
                {
window.open('vykaz_fin604_csv.php?cislo_oc=<?php echo $cislo_oc;?>&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
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
  <td class="header">FIN 6-04 Bankové úèty a záväzky obcí, VÚC a nimi zriadených rozpoèt. organ. za
   <span style="color:#39f;"><?php echo "$cislo_oc. štvrrok";?></span>
  </td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();" title="Vysvetlivky na vyplnenie výkazu" class="btn-form-tool">
<?php if ( $kli_vrok < 2018 ) { ?>
    <button type="button" onclick="DbfFin604();" title="Export do DBF" class="btn-text toright" style="position: relative; top: -4px;">DBF</button>
<?php } ?>
<?php if ( $kli_vrok >= 2018 ) { ?>
    <button type="button" onclick="CsvFin604();" title="Export do CSV" class="btn-text toright" style="position: relative; top: -4px;">CSV</button>
<?php } ?>
    <img src="../obr/ikony/download_blue_icon.png" onclick="Nacitaj();" title="Naèíta údaje" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();" title="Zobrazi všetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>
<?php if ( $strana < 1 OR $strana > 3 ) $strana=1; ?>

<div id="content">
<FORM name="formv1" method="post" action="../ucto/vykaz_fin604_2016.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive";
if ( $strana == 1 ) $clas1="active";
if ( $strana == 2 ) $clas2="active";
$source="vykaz_fin604_2016.php";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=1&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=2&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas2; ?> toleft">2</a>

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
<span class="text-echo" style="top:392px; left:141px;">x</span>
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
     alt="<?php echo $jpg_popis; ?> 2.strana 265kB">

<input type="text" name="r01" id="r01" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:232px; left:614px;"/>
<input type="text" name="rm01" id="rm01" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:232px; left:750px;"/>
<input type="text" name="r02" id="r02" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:263px; left:614px;"/>
<input type="text" name="rm02" id="rm02" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:263px; left:750px;"/>
<input type="text" name="r03" id="r03" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:293px; left:614px;"/>
<input type="text" name="rm03" id="rm03" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:293px; left:750px;"/>
<input type="text" name="r04" id="r04" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:324px; left:614px;"/>
<input type="text" name="rm04" id="rm04" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:324px; left:750px;"/>
<input type="text" name="r05" id="r05" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:354px; left:614px;"/>
<input type="text" name="rm05" id="rm05" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:354px; left:750px;"/>
<input type="text" name="r06" id="r06" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:385px; left:614px;"/>
<input type="text" name="rm06" id="rm06" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:385px; left:750px;"/>
<input type="text" name="r07" id="r07" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:416px; left:614px;"/>
<input type="text" name="rm07" id="rm07" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:416px; left:750px;"/>
<input type="text" name="r08" id="r08" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:446px; left:614px;"/>
<input type="text" name="rm08" id="rm08" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:446px; left:750px;"/>
<input type="text" name="r09" id="r09" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:477px; left:614px;"/>
<input type="text" name="rm09" id="rm09" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:477px; left:750px;"/>
<input type="text" name="r10" id="r10" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:508px; left:614px;"/>
<input type="text" name="rm10" id="rm10" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:508px; left:750px;"/>
<input type="text" name="r11" id="r11" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:538px; left:614px;"/>
<input type="text" name="rm11" id="rm11" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:538px; left:750px;"/>
<input type="text" name="r12" id="r12" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:569px; left:614px;"/>
<input type="text" name="rm12" id="rm12" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:569px; left:750px;"/>
<input type="text" name="r13" id="r13" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:600px; left:614px;"/>
<input type="text" name="rm13" id="rm13" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:600px; left:750px;"/>
<input type="text" name="r14" id="r14" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:631px; left:614px;"/>
<input type="text" name="rm14" id="rm14" onkeyup="CiarkaNaBodku(this);" style="width:123px; top:631px; left:750px;"/>
<?php                     } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=1&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=2&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
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

$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/vykfin_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/vykfin_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin604".
" WHERE F$kli_vxcf"."_uctvykaz_fin604.oc = $cislo_oc  ORDER BY oc";

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
$pdf->Cell(195,51.5," ","$rmc1",1,"L");
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
$pdf->Cell(195,24.5," ","$rmc1",1,"L");
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
$pdf->AddPage();
$pdf->SetFont('arial','',8);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str2.jpg') )
{
$pdf->Image($jpg_cesta.'_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

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
$pdf->Cell(195,37," ","$rmc1",1,"L");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,7,"$r01","$rmc",0,"R");$pdf->Cell(30,7,"$rm01","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,7,"$r02","$rmc",0,"R");$pdf->Cell(30,7,"$rm02","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,7,"$r03","$rmc",0,"R");$pdf->Cell(30,7,"$rm03","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,7,"$r04","$rmc",0,"R");$pdf->Cell(30,7,"$rm04","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,7,"$r05","$rmc",0,"R");$pdf->Cell(30,7,"$rm05","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,7,"$r06","$rmc",0,"R");$pdf->Cell(30,7,"$rm06","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,7,"$r07","$rmc",0,"R");$pdf->Cell(30,7,"$rm07","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,7,"$r08","$rmc",0,"R");$pdf->Cell(30,7,"$rm08","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,7,"$r09","$rmc",0,"R");$pdf->Cell(30,7,"$rm09","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,7,"$r10","$rmc",0,"R");$pdf->Cell(30,7,"$rm10","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,7,"$r11","$rmc",0,"R");$pdf->Cell(30,7,"$rm11","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,7,"$r12","$rmc",0,"R");$pdf->Cell(30,7,"$rm12","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,7,"$r13","$rmc",0,"R");$pdf->Cell(30,7,"$rm13","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,7,"$r14","$rmc",0,"R");$pdf->Cell(30,7,"$rm14","$rmc",1,"R");
                                       }
}
$i = $i + 1;
  }
$pdf->Output("$outfilex");
?>

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>", "_self");
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