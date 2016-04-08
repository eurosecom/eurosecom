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
$jpg_cesta="../dokumenty/statistika2016/fin704/fin7-04_v16";
$jpg_popis="Finanèný výkaz o vybraných údajoch z úètovníctva ostatných subjektov verejnej správy FIN 7-04 za rok ".$kli_vrok;

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
$sql = "SELECT * FROM F".$kli_vxcf."_genfin704 ";
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

$sql = "DROP TABLE F$kli_vxcf"."_genfin704";
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

$sql = 'CREATE TABLE F'.$kli_vxcf.'_genfin704'.$sqlt;
$vysledek = mysql_query("$sql");


$sqult = "INSERT INTO F$kli_vxcf"."_genfin704 ( uce,crs ) VALUES ( '012', '2' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin704 ( uce,crs ) VALUES ( '014', '2' ); "; $ulozene = mysql_query("$sqult");

//sumar za ucet=ak jeden ucet v dvoch riadkoch tak zober jeden
$sqult = "UPDATE F$kli_vxcf"."_genfin704 SET cpl01=1 "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin704 SELECT 0,uce,crs,0 FROM F$kli_vxcf"."_genfin704 GROUP BY uce "; $ulozene = mysql_query("$sqult");
$sqult = "DELETE FROM F$kli_vxcf"."_genfin704 WHERE cpl01 != 0 "; $ulozene = mysql_query("$sqult");

$nacitajgen = 1*$_REQUEST['nacitajgen'];
if ( $nacitajgen == 1 ) {
?>
<script type="text/javascript">
window.open('../ucto/fin_cis.php?copern=308&drupoh=97&page=1&sysx=UCT', '_self');
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

$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin704 WHERE oc = $cislo_oc ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $nasielvyplnene=1;

  $riaddok=mysql_fetch_object($sqldok);
  $xokres=1*$riaddok->okres;
  $xobec=1*$riaddok->obec;
  }

$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin704 WHERE oc = $cislo_oc";
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

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin704 SET ".
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
$r15 = 1*$_REQUEST['r15']; $rm15 = 1*$_REQUEST['rm15'];
$r16 = 1*$_REQUEST['r16']; $rm16 = 1*$_REQUEST['rm16'];
$r17 = 1*$_REQUEST['r17']; $rm17 = 1*$_REQUEST['rm17'];
$r18 = 1*$_REQUEST['r18']; $rm18 = 1*$_REQUEST['rm18'];
$r19 = 1*$_REQUEST['r19']; $rm19 = 1*$_REQUEST['rm19'];
$r20 = 1*$_REQUEST['r20']; $rm20 = 1*$_REQUEST['rm20'];
$r21 = 1*$_REQUEST['r21']; $rm21 = 1*$_REQUEST['rm21'];
$r22 = 1*$_REQUEST['r22']; $rm22 = 1*$_REQUEST['rm22'];
$r23 = 1*$_REQUEST['r23']; $rm23 = 1*$_REQUEST['rm23'];
$r24 = 1*$_REQUEST['r24']; $rm24 = 1*$_REQUEST['rm24'];
$r25 = 1*$_REQUEST['r25']; $rm25 = 1*$_REQUEST['rm25'];
$r26 = 1*$_REQUEST['r26']; $rm26 = 1*$_REQUEST['rm26'];
$r27 = 1*$_REQUEST['r27']; $rm27 = 1*$_REQUEST['rm27'];
$r28 = 1*$_REQUEST['r28']; $rm28 = 1*$_REQUEST['rm28'];
$r29 = 1*$_REQUEST['r29']; $rm29 = 1*$_REQUEST['rm29'];
$r30 = 1*$_REQUEST['r30']; $rm30 = 1*$_REQUEST['rm30'];
$r31 = 1*$_REQUEST['r31']; $rm31 = 1*$_REQUEST['rm31'];
$r32 = 1*$_REQUEST['r32']; $rm32 = 1*$_REQUEST['rm32'];
$r33 = 1*$_REQUEST['r33']; $rm33 = 1*$_REQUEST['rm33'];
$r34 = 1*$_REQUEST['r34']; $rm34 = 1*$_REQUEST['rm34'];
$r35 = 1*$_REQUEST['r35']; $rm35 = 1*$_REQUEST['rm35'];
$r36 = 1*$_REQUEST['r36']; $rm36 = 1*$_REQUEST['rm36'];
$r37 = 1*$_REQUEST['r37']; $rm37 = 1*$_REQUEST['rm37'];
$r38 = 1*$_REQUEST['r38']; $rm38 = 1*$_REQUEST['rm38'];

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin704 SET ".
" r01='$r01', rm01='$rm01', r02='$r02', rm02='$rm02', r03='$r03', rm03='$rm03',
  r04='$r04', rm04='$rm04', r05='$r05', rm05='$rm05', r06='$r06', rm06='$rm06',
  r07='$r07', rm07='$rm07', r08='$r08', rm08='$rm08', r09='$r09', rm09='$rm09',
  r10='$r10', rm10='$rm10', r11='$r11', rm11='$rm11', r12='$r12', rm12='$rm12',
  r13='$r13', rm13='$rm13', r14='$r14', rm14='$rm14', r15='$r15', rm15='$rm15',
  r16='$r16', rm16='$rm16', r17='$r17', rm17='$rm17', r18='$r18', rm18='$rm18',
  r19='$r19', rm19='$rm19', r20='$r20', rm20='$rm20', r21='$r21', rm21='$rm21',
  r22='$r22', rm22='$rm22', r23='$r23', rm23='$rm23', r24='$r24', rm24='$rm24',
  r25='$r25', rm25='$rm25', r26='$r26', rm26='$rm26', r27='$r27', rm27='$rm27',
  r28='$r28', rm28='$rm28', r29='$r29', rm29='$rm29', r30='$r30', rm30='$rm30',
  r31='$r31', rm31='$rm31', r32='$r32', rm32='$rm32', r33='$r33', rm33='$rm33',
  r34='$r34', rm34='$rm34', r35='$r35', rm35='$rm35', r36='$r36', rm36='$rm36',
  r37='$r37', rm37='$rm37', r38='$r38', rm38='$rm38' ".
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


$sql = "SELECT px08 FROM F".$kli_vxcf."_uctvykaz_fin704";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin704';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin704d2';
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
   r15          DECIMAL($pocdes),
   r16          DECIMAL($pocdes),
   r17          DECIMAL($pocdes),
   r18          DECIMAL($pocdes),
   r19          DECIMAL($pocdes),
   r20          DECIMAL($pocdes),
   r21          DECIMAL($pocdes),
   r22          DECIMAL($pocdes),
   r23          DECIMAL($pocdes),
   r24          DECIMAL($pocdes),
   r25          DECIMAL($pocdes),
   r26          DECIMAL($pocdes),
   r27          DECIMAL($pocdes),
   r28          DECIMAL($pocdes),
   r29          DECIMAL($pocdes),
   r30          DECIMAL($pocdes),
   r31          DECIMAL($pocdes),
   r32          DECIMAL($pocdes),
   r33          DECIMAL($pocdes),
   r34          DECIMAL($pocdes),
   r35          DECIMAL($pocdes),
   r36          DECIMAL($pocdes),
   r37          DECIMAL($pocdes),
   r38          DECIMAL($pocdes),

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
   rm15          DECIMAL($pocdes),
   rm16          DECIMAL($pocdes),
   rm17          DECIMAL($pocdes),
   rm18          DECIMAL($pocdes),
   rm19          DECIMAL($pocdes),
   rm20          DECIMAL($pocdes),
   rm21          DECIMAL($pocdes),
   rm22          DECIMAL($pocdes),
   rm23          DECIMAL($pocdes),
   rm24          DECIMAL($pocdes),
   rm25          DECIMAL($pocdes),
   rm26          DECIMAL($pocdes),
   rm27          DECIMAL($pocdes),
   rm28          DECIMAL($pocdes),
   rm29          DECIMAL($pocdes),
   rm30          DECIMAL($pocdes),
   rm31          DECIMAL($pocdes),
   rm32          DECIMAL($pocdes),
   rm33          DECIMAL($pocdes),
   rm34          DECIMAL($pocdes),
   rm35          DECIMAL($pocdes),
   rm36          DECIMAL($pocdes),
   rm37          DECIMAL($pocdes),
   rm38          DECIMAL($pocdes),
   ico           INT
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctvykaz_fin704'.$sqlt;
$vytvor = mysql_query("$vsql");
}
//koniec vytvorenie 


$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_fin704";
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_fin704";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
//exit;


$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin704 WHERE oc = $cislo_oc";
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
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
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
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
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
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
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
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
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
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
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
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie".
" WHERE ( ucd > 0 AND ume <= $kli_vume ) GROUP BY F$kli_vxcf"."_$uctovanie.ucd";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid,F$kli_vxcf"."_genfin704".
" SET rdk=F$kli_vxcf"."_genfin704.crs".
" WHERE LEFT(F$kli_vxcf"."_uctprcvykaz$kli_uzid.uce,3) = LEFT(F$kli_vxcf"."_genfin704.uce,3) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid,F$kli_vxcf"."_genfin704".
" SET rdk=F$kli_vxcf"."_genfin704.crs".
" WHERE F$kli_vxcf"."_uctprcvykaz$kli_uzid.uce = F$kli_vxcf"."_genfin704.uce ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
//exit;



//rozdel do riadkov , vypocitaj netto

$rdk=1;
while ($rdk <= 79 ) 
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
"SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10), ".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20), ".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30), ".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38), ".
"SUM(rm01),SUM(rm02),SUM(rm03),SUM(rm04),SUM(rm05),SUM(rm06),SUM(rm07),SUM(rm08),SUM(rm09),SUM(rm10), ".
"SUM(rm11),SUM(rm12),SUM(rm13),SUM(rm14),SUM(rm15),SUM(rm16),SUM(rm17),SUM(rm18),SUM(rm19),SUM(rm20), ".
"SUM(rm21),SUM(rm22),SUM(rm23),SUM(rm24),SUM(rm25),SUM(rm26),SUM(rm27),SUM(rm28),SUM(rm29),SUM(rm30), ".
"SUM(rm31),SUM(rm32),SUM(rm33),SUM(rm34),SUM(rm35),SUM(rm36),SUM(rm37),SUM(rm38), ".
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
$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin704 WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");


$dsqlt = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin704".
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
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin704 WHERE oc = $cislo_oc ";

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
$r15 = $fir_riadok->r15;
$rm15 = $fir_riadok->rm15;
$r16 = $fir_riadok->r16;
$rm16 = $fir_riadok->rm16;
$r17 = $fir_riadok->r17;
$rm17 = $fir_riadok->rm17;
$r18 = $fir_riadok->r18;
$rm18 = $fir_riadok->rm18;
$r19 = $fir_riadok->r19;
$rm19 = $fir_riadok->rm19;
$r20 = $fir_riadok->r20;
$rm20 = $fir_riadok->rm20;
$r21 = $fir_riadok->r21;
$rm21 = $fir_riadok->rm21;
$r22 = $fir_riadok->r22;
$rm22 = $fir_riadok->rm22;
$r23 = $fir_riadok->r23;
$rm23 = $fir_riadok->rm23;
$r24 = $fir_riadok->r24;
$rm24 = $fir_riadok->rm24;
$r25 = $fir_riadok->r25;
$rm25 = $fir_riadok->rm25;
$r26 = $fir_riadok->r26;
$rm26 = $fir_riadok->rm26;
$r27 = $fir_riadok->r27;
$rm27 = $fir_riadok->rm27;
$r28 = $fir_riadok->r28;
$rm28 = $fir_riadok->rm28;
$r29 = $fir_riadok->r29;
$rm29 = $fir_riadok->rm29;
$r30 = $fir_riadok->r30;
$rm30 = $fir_riadok->rm30;
$r31 = $fir_riadok->r31;
$rm31 = $fir_riadok->rm31;
$r32 = $fir_riadok->r32;
$rm32 = $fir_riadok->rm32;
$r33 = $fir_riadok->r33;
$rm33 = $fir_riadok->rm33;
$r34 = $fir_riadok->r34;
$rm34 = $fir_riadok->rm34;
$r35 = $fir_riadok->r35;
$rm35 = $fir_riadok->rm35;
$r36 = $fir_riadok->r36;
$rm36 = $fir_riadok->rm36;
$r37 = $fir_riadok->r37;
$rm37 = $fir_riadok->rm37;
$r38 = $fir_riadok->r38;
$rm38 = $fir_riadok->rm38;
$r39 = $fir_riadok->r39;
$rm39 = $fir_riadok->rm39;
$r40 = $fir_riadok->r40;
$rm40 = $fir_riadok->rm40;
$r41 = $fir_riadok->r41;
$rm41 = $fir_riadok->rm41;
$r42 = $fir_riadok->r42;
$rm42 = $fir_riadok->rm42;
$r43 = $fir_riadok->r43;
$rm43 = $fir_riadok->rm43;
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
<title>Výkaz FIN 7-04</title>
<style type="text/css">
img.btn-row-tool {
  width: 20px;
  height: 20px;
}
form input[type=text] {
  height: 16px;
  line-height: 16px;
  padding-left: 3px;
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
   document.formv1.r15.value = '<?php echo $r15;?>';
   document.formv1.rm15.value = '<?php echo $rm15;?>';
   document.formv1.r16.value = '<?php echo $r16;?>';
   document.formv1.rm16.value = '<?php echo $rm16;?>';
   document.formv1.r17.value = '<?php echo $r17;?>';
   document.formv1.rm17.value = '<?php echo $rm17;?>';
   document.formv1.r18.value = '<?php echo $r18;?>';
   document.formv1.rm18.value = '<?php echo $rm18;?>';
   document.formv1.r19.value = '<?php echo $r19;?>';
   document.formv1.rm19.value = '<?php echo $rm19;?>';
   document.formv1.r20.value = '<?php echo $r20;?>';
   document.formv1.rm20.value = '<?php echo $rm20;?>';
   document.formv1.r21.value = '<?php echo $r21;?>';
   document.formv1.rm21.value = '<?php echo $rm21;?>';
   document.formv1.r22.value = '<?php echo $r22;?>';
   document.formv1.rm22.value = '<?php echo $rm22;?>';
   document.formv1.r23.value = '<?php echo $r23;?>';
   document.formv1.rm23.value = '<?php echo $rm23;?>';
   document.formv1.r24.value = '<?php echo $r24;?>';
   document.formv1.rm24.value = '<?php echo $rm24;?>';
   document.formv1.r25.value = '<?php echo $r25;?>';
   document.formv1.rm25.value = '<?php echo $rm25;?>';
   document.formv1.r26.value = '<?php echo $r26;?>';
   document.formv1.rm26.value = '<?php echo $rm26;?>';
   document.formv1.r27.value = '<?php echo $r27;?>';
   document.formv1.rm27.value = '<?php echo $rm27;?>';
   document.formv1.r28.value = '<?php echo $r28;?>';
   document.formv1.rm28.value = '<?php echo $rm28;?>';
   document.formv1.r29.value = '<?php echo $r29;?>';
   document.formv1.rm29.value = '<?php echo $rm29;?>';
   document.formv1.r30.value = '<?php echo $r30;?>';
   document.formv1.rm30.value = '<?php echo $rm30;?>';
   document.formv1.r31.value = '<?php echo $r31;?>';
   document.formv1.rm31.value = '<?php echo $rm31;?>';
   document.formv1.r32.value = '<?php echo $r32;?>';
   document.formv1.rm32.value = '<?php echo $rm32;?>';
   document.formv1.r33.value = '<?php echo $r33;?>';
   document.formv1.rm33.value = '<?php echo $rm33;?>';
   document.formv1.r34.value = '<?php echo $r34;?>';
   document.formv1.rm34.value = '<?php echo $rm34;?>';
   document.formv1.r35.value = '<?php echo $r35;?>';
   document.formv1.rm35.value = '<?php echo $rm35;?>';
   document.formv1.r36.value = '<?php echo $r36;?>';
   document.formv1.rm36.value = '<?php echo $rm36;?>';
   document.formv1.r37.value = '<?php echo $r37;?>';
   document.formv1.rm37.value = '<?php echo $rm37;?>';
   document.formv1.r38.value = '<?php echo $r38;?>';
   document.formv1.rm38.value = '<?php echo $rm38;?>';
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
   window.open('vykaz_fin704_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999',
 '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function Nacitaj()
  {
   window.open('vykaz_fin704_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=0&strana=1',
'_self', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }

function DbfFin704()
                {
window.open('fin704dbf_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=1&drupoh=1&page=1&subor=0',
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
  <td class="header">FIN 7-04 Vybrané údaje z úètovníctva za
   <span style="color:#39f;"><?php echo "$cislo_oc. štvrrok";?></span>
  </td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();" title="Vysvetlivky na vyplnenie výkazu" class="btn-form-tool">
    <img src="../obr/ikony/download_blue_icon.png" onclick="Nacitaj();" title="Naèíta údaje" class="btn-form-tool">
    <img src="../obr/ikony/upbox_blue_icon.png" onclick="DbfFin704();" title="Export do DBF" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();" title="Zobrazi všetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>
<?php if ( $strana < 1 OR $strana > 3 ) $strana=1; ?>

<div id="content">
<FORM name="formv1" method="post" action="../ucto/vykaz_fin704_2016.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
if ( $strana == 3 ) $clas3="active";
$source="vykaz_fin704_2016.php";
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
<span class="text-echo" style="top:430px; left:141px;">x</span>
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

<input type="text" name="r01" id="r01" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:233px; left:614px;"/>
<input type="text" name="rm01" id="rm01" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:233px; left:750px;"/>
<input type="text" name="r02" id="r02" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:259px; left:614px;"/>
<input type="text" name="rm02" id="rm02" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:259px; left:750px;"/>
<input type="text" name="r03" id="r03" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:285px; left:614px;"/>
<input type="text" name="rm03" id="rm03" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:285px; left:750px;"/>
<input type="text" name="r04" id="r04" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:311px; left:614px;"/>
<input type="text" name="rm04" id="rm04" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:311px; left:750px;"/>
<input type="text" name="r05" id="r05" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:338px; left:614px;"/>
<input type="text" name="rm05" id="rm05" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:338px; left:750px;"/>
<input type="text" name="r06" id="r06" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:364px; left:614px;"/>
<input type="text" name="rm06" id="rm06" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:364px; left:750px;"/>
<input type="text" name="r07" id="r07" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:390px; left:614px;"/>
<input type="text" name="rm07" id="rm07" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:390px; left:750px;"/>
<input type="text" name="r08" id="r08" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:416px; left:614px;"/>
<input type="text" name="rm08" id="rm08" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:416px; left:750px;"/>
<input type="text" name="r09" id="r09" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:443px; left:614px;"/>
<input type="text" name="rm09" id="rm09" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:443px; left:750px;"/>
<input type="text" name="r10" id="r10" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:469px; left:614px;"/>
<input type="text" name="rm10" id="rm10" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:469px; left:750px;"/>
<input type="text" name="r11" id="r11" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:495px; left:614px;"/>
<input type="text" name="rm11" id="rm11" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:495px; left:750px;"/>
<input type="text" name="r12" id="r12" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:521px; left:614px;"/>
<input type="text" name="rm12" id="rm12" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:521px; left:750px;"/>
<input type="text" name="r13" id="r13" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:548px; left:614px;"/>
<input type="text" name="rm13" id="rm13" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:548px; left:750px;"/>
<input type="text" name="r14" id="r14" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:574px; left:614px;"/>
<input type="text" name="rm14" id="rm14" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:574px; left:750px;"/>
<input type="text" name="r15" id="r15" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:600px; left:614px;"/>
<input type="text" name="rm15" id="rm15" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:600px; left:750px;"/>
<input type="text" name="r16" id="r16" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:626px; left:614px;"/>
<input type="text" name="rm16" id="rm16" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:626px; left:750px;"/>
<input type="text" name="r17" id="r17" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:653px; left:614px;"/>
<input type="text" name="rm17" id="rm17" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:653px; left:750px;"/>
<input type="text" name="r18" id="r18" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:679px; left:614px;"/>
<input type="text" name="rm18" id="rm18" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:679px; left:750px;"/>
<input type="text" name="r19" id="r19" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:705px; left:614px;"/>
<input type="text" name="rm19" id="rm19" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:705px; left:750px;"/>
<input type="text" name="r20" id="r20" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:731px; left:614px;"/>
<input type="text" name="rm20" id="rm20" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:731px; left:750px;"/>
<input type="text" name="r21" id="r21" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:758px; left:614px;"/>
<input type="text" name="rm21" id="rm21" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:758px; left:750px;"/>
<input type="text" name="r22" id="r22" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:784px; left:614px;"/>
<input type="text" name="rm22" id="rm22" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:784px; left:750px;"/>
<input type="text" name="r23" id="r23" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:810px; left:614px;"/>
<input type="text" name="rm23" id="rm23" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:810px; left:750px;"/>
<input type="text" name="r24" id="r24" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:836px; left:614px;"/>
<input type="text" name="rm24" id="rm24" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:836px; left:750px;"/>
<input type="text" name="r25" id="r25" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:863px; left:614px;"/>
<input type="text" name="rm25" id="rm25" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:863px; left:750px;"/>
<input type="text" name="r26" id="r26" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:889px; left:614px;"/>
<input type="text" name="rm26" id="rm26" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:889px; left:750px;"/>
<input type="text" name="r27" id="r27" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:915px; left:614px;"/>
<input type="text" name="rm27" id="rm27" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:915px; left:750px;"/>
<input type="text" name="r28" id="r28" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:941px; left:614px;"/>
<input type="text" name="rm28" id="rm28" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:941px; left:750px;"/>
<input type="text" name="r29" id="r29" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:968px; left:614px;"/>
<input type="text" name="rm29" id="rm29" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:968px; left:750px;"/>
<input type="text" name="r30" id="r30" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:994px; left:614px;"/>
<input type="text" name="rm30" id="rm30" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:994px; left:750px;"/>
<input type="text" name="r31" id="r31" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1020px; left:614px;"/>
<input type="text" name="rm31" id="rm31" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1020px; left:750px;"/>
<input type="text" name="r32" id="r32" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1047px; left:614px;"/>
<input type="text" name="rm32" id="rm32" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1047px; left:750px;"/>
<input type="text" name="r33" id="r33" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1073px; left:614px;"/>
<input type="text" name="rm33" id="rm33" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1073px; left:750px;"/>
<input type="text" name="r34" id="r34" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1099px; left:614px;"/>
<input type="text" name="rm34" id="rm34" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1099px; left:750px;"/>
<input type="text" name="r35" id="r35" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1125px; left:614px;"/>
<input type="text" name="rm35" id="rm35" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1125px; left:750px;"/>
<input type="text" name="r36" id="r36" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1151px; left:614px;"/>
<input type="text" name="rm36" id="rm36" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1151px; left:750px;"/>
<input type="text" name="r37" id="r37" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1178px; left:614px;"/>
<input type="text" name="rm37" id="rm37" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1178px; left:750px;"/>
<input type="text" name="r38" id="r38" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1204px; left:614px;"/>
<input type="text" name="rm38" id="rm38" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1204px; left:750px;"/>
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
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin704".
" WHERE F$kli_vxcf"."_uctvykaz_fin704.oc = $cislo_oc  ORDER BY oc";

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
$pdf->Cell(195,60," ","$rmc1",1,"L");
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
$pdf->Cell(195,16," ","$rmc1",1,"L");
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
$pdf->Cell(195,37," ","$rmc1",1,"L");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r01","$rmc",0,"R");$pdf->Cell(30,6,"$rm01","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r02","$rmc",0,"R");$pdf->Cell(30,6,"$rm02","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r03","$rmc",0,"R");$pdf->Cell(30,6,"$rm03","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r04","$rmc",0,"R");$pdf->Cell(30,6,"$rm04","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r05","$rmc",0,"R");$pdf->Cell(30,6,"$rm05","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r06","$rmc",0,"R");$pdf->Cell(30,6,"$rm06","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r07","$rmc",0,"R");$pdf->Cell(30,6,"$rm07","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r08","$rmc",0,"R");$pdf->Cell(30,6,"$rm08","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r09","$rmc",0,"R");$pdf->Cell(30,6,"$rm09","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r10","$rmc",0,"R");$pdf->Cell(30,6,"$rm10","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r11","$rmc",0,"R");$pdf->Cell(30,6,"$rm11","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r12","$rmc",0,"R");$pdf->Cell(30,6,"$rm12","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r13","$rmc",0,"R");$pdf->Cell(30,6,"$rm13","$rmc",1,"R");

$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r14","$rmc",0,"R");$pdf->Cell(30,6,"$rm14","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r15","$rmc",0,"R");$pdf->Cell(30,6,"$rm15","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r16","$rmc",0,"R");$pdf->Cell(30,6,"$rm16","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r17","$rmc",0,"R");$pdf->Cell(30,6,"$rm17","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r18","$rmc",0,"R");$pdf->Cell(30,6,"$rm18","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r19","$rmc",0,"R");$pdf->Cell(30,6,"$rm19","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r20","$rmc",0,"R");$pdf->Cell(30,6,"$rm20","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r21","$rmc",0,"R");$pdf->Cell(30,6,"$rm21","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r22","$rmc",0,"R");$pdf->Cell(30,6,"$rm22","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r23","$rmc",0,"R");$pdf->Cell(30,6,"$rm23","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r24","$rmc",0,"R");$pdf->Cell(30,6,"$rm24","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r25","$rmc",0,"R");$pdf->Cell(30,6,"$rm25","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r26","$rmc",0,"R");$pdf->Cell(30,6,"$rm26","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r27","$rmc",0,"R");$pdf->Cell(30,6,"$rm27","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r28","$rmc",0,"R");$pdf->Cell(30,6,"$rm28","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r29","$rmc",0,"R");$pdf->Cell(30,6,"$rm29","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r30","$rmc",0,"R");$pdf->Cell(30,6,"$rm30","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r31","$rmc",0,"R");$pdf->Cell(30,6,"$rm31","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r32","$rmc",0,"R");$pdf->Cell(30,6,"$rm32","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r33","$rmc",0,"R");$pdf->Cell(30,6,"$rm33","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r34","$rmc",0,"R");$pdf->Cell(30,6,"$rm34","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r35","$rmc",0,"R");$pdf->Cell(30,6,"$rm35","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r36","$rmc",0,"R");$pdf->Cell(30,6,"$rm36","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r37","$rmc",0,"R");$pdf->Cell(30,6,"$rm37","$rmc",1,"R");
$pdf->Cell(125,4," ","$rmc1",0,"C");$pdf->Cell(30,6,"$r38","$rmc",0,"R");$pdf->Cell(30,6,"$rm38","$rmc",1,"R");
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