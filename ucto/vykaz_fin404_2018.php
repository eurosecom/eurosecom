<!doctype html>
<HTML>
<?php
//celkovy zaciatok FIN 404 v.2018
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
$jpg_cesta="../dokumenty/tlacivo2018/fin4-04/fin4-04_v18";
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
$pocs13 = 1*$_REQUEST['pocs13'];
$pocs14 = 1*$_REQUEST['pocs14'];
$pocs15 = 1*$_REQUEST['pocs15'];
$pocs16 = 1*$_REQUEST['pocs16'];
$pocs17 = 1*$_REQUEST['pocs17'];
$pocs18 = 1*$_REQUEST['pocs18'];
$pocs19 = 1*$_REQUEST['pocs19'];
$pocs20 = 1*$_REQUEST['pocs20'];
$pocs21 = 1*$_REQUEST['pocs21'];
$pocs22 = 1*$_REQUEST['pocs22'];
$pocs23 = 1*$_REQUEST['pocs23'];
$pocs24 = 1*$_REQUEST['pocs24'];
$pocs25 = 1*$_REQUEST['pocs25'];
$pocs26 = 1*$_REQUEST['pocs26'];
$pocs27 = 1*$_REQUEST['pocs27'];
$pocs28 = 1*$_REQUEST['pocs28'];


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
$zvys13 = 1*$_REQUEST['zvys13'];
$zvys14 = 1*$_REQUEST['zvys14'];
$zvys15 = 1*$_REQUEST['zvys15'];
$zvys16 = 1*$_REQUEST['zvys16'];
$zvys17 = 1*$_REQUEST['zvys17'];
$zvys18 = 1*$_REQUEST['zvys18'];
$zvys19 = 1*$_REQUEST['zvys19'];
$zvys10 = 1*$_REQUEST['zvys20'];
$zvys21 = 1*$_REQUEST['zvys21'];
$zvys22 = 1*$_REQUEST['zvys22'];
$zvys23 = 1*$_REQUEST['zvys23'];
$zvys24 = 1*$_REQUEST['zvys24'];
$zvys25 = 1*$_REQUEST['zvys25'];
$zvys26 = 1*$_REQUEST['zvys26'];
$zvys27 = 1*$_REQUEST['zvys27'];
$zvys28 = 1*$_REQUEST['zvys28'];


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
$znis13 = 1*$_REQUEST['znis13'];
$znis14 = 1*$_REQUEST['znis14'];
$znis15 = 1*$_REQUEST['znis15'];
$znis16 = 1*$_REQUEST['znis16'];
$znis17 = 1*$_REQUEST['znis17'];
$znis18 = 1*$_REQUEST['znis18'];
$znis19 = 1*$_REQUEST['znis19'];
$znis10 = 1*$_REQUEST['znis20'];
$znis21 = 1*$_REQUEST['znis21'];
$znis22 = 1*$_REQUEST['znis22'];
$znis23 = 1*$_REQUEST['znis23'];
$znis24 = 1*$_REQUEST['znis24'];
$znis25 = 1*$_REQUEST['znis25'];
$znis26 = 1*$_REQUEST['znis26'];
$znis27 = 1*$_REQUEST['znis27'];
$znis28 = 1*$_REQUEST['znis28'];


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
$oces13 = 1*$_REQUEST['oces13'];
$oces14 = 1*$_REQUEST['oces14'];
$oces15 = 1*$_REQUEST['oces15'];
$oces16 = 1*$_REQUEST['oces16'];
$oces17 = 1*$_REQUEST['oces17'];
$oces18 = 1*$_REQUEST['oces18'];
$oces19 = 1*$_REQUEST['oces19'];
$oces10 = 1*$_REQUEST['oces20'];
$oces21 = 1*$_REQUEST['oces21'];
$oces22 = 1*$_REQUEST['oces22'];
$oces23 = 1*$_REQUEST['oces23'];
$oces24 = 1*$_REQUEST['oces24'];
$oces25 = 1*$_REQUEST['oces25'];
$oces26 = 1*$_REQUEST['oces26'];
$oces27 = 1*$_REQUEST['oces27'];
$oces28 = 1*$_REQUEST['oces28'];


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
$osts13 = 1*$_REQUEST['osts13'];
$osts14 = 1*$_REQUEST['osts14'];
$osts15 = 1*$_REQUEST['osts15'];
$osts16 = 1*$_REQUEST['osts16'];
$osts17 = 1*$_REQUEST['osts17'];
$osts18 = 1*$_REQUEST['osts18'];
$osts19 = 1*$_REQUEST['osts19'];
$osts10 = 1*$_REQUEST['osts20'];
$osts21 = 1*$_REQUEST['osts21'];
$osts22 = 1*$_REQUEST['osts22'];
$osts23 = 1*$_REQUEST['osts23'];
$osts24 = 1*$_REQUEST['osts24'];
$osts25 = 1*$_REQUEST['osts25'];
$osts26 = 1*$_REQUEST['osts26'];
$osts27 = 1*$_REQUEST['osts27'];
$osts28 = 1*$_REQUEST['osts28'];




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
$zoss13 = 1*$_REQUEST['zoss13'];
$zoss14 = 1*$_REQUEST['zoss14'];
$zoss15 = 1*$_REQUEST['zoss15'];
$zoss16 = 1*$_REQUEST['zoss16'];
$zoss17 = 1*$_REQUEST['zoss17'];
$zoss18 = 1*$_REQUEST['zoss18'];
$zoss19 = 1*$_REQUEST['zoss19'];
$zoss10 = 1*$_REQUEST['zoss20'];
$zoss21 = 1*$_REQUEST['zoss21'];
$zoss22 = 1*$_REQUEST['zoss22'];
$zoss23 = 1*$_REQUEST['zoss23'];
$zoss24 = 1*$_REQUEST['zoss24'];
$zoss25 = 1*$_REQUEST['zoss25'];
$zoss26 = 1*$_REQUEST['zoss26'];
$zoss27 = 1*$_REQUEST['zoss27'];
$zoss28 = 1*$_REQUEST['zoss28'];

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin404 SET ".
" pocs01='$pocs01', pocs02='$pocs02', pocs03='$pocs03', pocs04='$pocs04', pocs05='$pocs05', ".
" pocs06='$pocs06', pocs07='$pocs07', pocs08='$pocs08', pocs09='$pocs09', pocs10='$pocs10', ".
" pocs11='$pocs11', pocs12='$pocs12', pocs13='$pocs13', pocs14='$pocs14', ".
" pocs15='$pocs15', pocs16='$pocs16', pocs17='$pocs17', pocs18='$pocs18', pocs19='$pocs19', pocs20='$pocs20', ".
" pocs21='$pocs21', pocs22='$pocs22', pocs23='$pocs23', pocs24='$pocs24', pocs25='$pocs25', pocs26='$pocs26', ".
" pocs27='$pocs27', pocs28='$pocs28', ".

" zvys01='$zvys01', zvys02='$zvys02', zvys03='$zvys03', zvys04='$zvys04', zvys05='$zvys05', ".
" zvys06='$zvys06', zvys07='$zvys07', zvys08='$zvys08', zvys09='$zvys09', zvys10='$zvys10', ".
" zvys11='$zvys11', zvys12='$zvys12', zvys13='$zvys13', zvys14='$zvys14', ".
" zvys15='$zvys15', zvys16='$zvys16', zvys17='$zvys17', zvys18='$zvys18', zvys19='$zvys19', zvys20='$zvys20', ".
" zvys21='$zvys21', zvys22='$zvys22', zvys23='$zvys23', zvys24='$zvys24', zvys25='$zvys25', zvys26='$zvys26', ".
" zvys27='$zvys27', zvys28='$zvys28', ".

" znis01='$znis01', znis02='$znis02', znis03='$znis03', znis04='$znis04', znis05='$znis05', ".
" znis06='$znis06', znis07='$znis07', znis08='$znis08', znis09='$znis09', znis10='$znis10', ".
" znis11='$znis11', znis12='$znis12', znis13='$znis13', znis14='$znis14', ".
" znis15='$znis15', znis16='$znis16', znis17='$znis17', znis18='$znis18', znis19='$znis19', znis20='$znis20', ".
" znis21='$znis21', znis22='$znis22', znis23='$znis23', znis24='$znis24', znis25='$znis25', znis26='$znis26', ".
" znis27='$znis27', znis28='$znis28', ".

" oces01='$oces01', oces02='$oces02', oces03='$oces03', oces04='$oces04', oces05='$oces05', ".
" oces06='$oces06', oces07='$oces07', oces08='$oces08', oces09='$oces09', oces10='$oces10', ".
" oces11='$oces11', oces12='$oces12', oces13='$oces13', oces14='$oces14', ".
" oces15='$oces15', oces16='$oces16', oces17='$oces17', oces18='$oces18', oces19='$oces19', oces20='$oces20', ".
" oces21='$oces21', oces22='$oces22', oces23='$oces23', oces24='$oces24', oces25='$oces25', oces26='$oces26', ".
" oces27='$oces27', oces28='$oces28', ".

" osts01='$osts01', osts02='$osts02', osts03='$osts03', osts04='$osts04', osts05='$osts05', ".
" osts06='$osts06', osts07='$osts07', osts08='$osts08', osts09='$osts09', osts10='$osts10', ".
" osts11='$osts11', osts12='$osts12', osts13='$osts13', osts14='$osts14', ".
" osts15='$osts15', osts16='$osts16', osts17='$osts17', osts18='$osts18', osts19='$osts19', osts20='$osts20', ".
" osts21='$osts21', osts22='$osts22', osts23='$osts23', osts24='$osts24', osts25='$osts25', osts26='$osts26', ".
" osts27='$osts27', osts28='$osts28', ".


" zoss01='$zoss01', zoss02='$zoss02', zoss03='$zoss03', zoss04='$zoss04', zoss05='$zoss05', ".
" zoss06='$zoss06', zoss07='$zoss07', zoss08='$zoss08', zoss09='$zoss09', zoss10='$zoss10', ".
" zoss11='$zoss11', zoss12='$zoss12', zoss13='$zoss13', zoss14='$zoss14', ".
" zoss15='$zoss15', zoss16='$zoss16', zoss17='$zoss17', zoss18='$zoss18', zoss19='$zoss19', zoss20='$zoss20', ".
" zoss21='$zoss21', zoss22='$zoss22', zoss23='$zoss23', zoss24='$zoss24', zoss25='$zoss25', zoss26='$zoss26', ".
" zoss27='$zoss27', zoss28='$zoss28'  ".
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


$sql = "SELECT px18 FROM F".$kli_vxcf."_uctvykaz_fin404";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin404';
$vysledok = mysql_query("$sqlt");

$pocdes="10,2";
$sqlt = <<<mzdprc
(
   px18         DECIMAL($pocdes) DEFAULT 0,
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
   pocs13       DECIMAL($pocdes),
   pocs14       DECIMAL($pocdes),
   pocs15       DECIMAL($pocdes),
   pocs16       DECIMAL($pocdes),
   pocs17       DECIMAL($pocdes),
   pocs18       DECIMAL($pocdes),
   pocs19       DECIMAL($pocdes),
   pocs20       DECIMAL($pocdes),
   pocs21       DECIMAL($pocdes),
   pocs22       DECIMAL($pocdes),
   pocs23       DECIMAL($pocdes),
   pocs24       DECIMAL($pocdes),
   pocs25       DECIMAL($pocdes),
   pocs26       DECIMAL($pocdes),
   pocs27       DECIMAL($pocdes),
   pocs28       DECIMAL($pocdes),

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
   zvys13       DECIMAL($pocdes),
   zvys14       DECIMAL($pocdes),
   zvys15       DECIMAL($pocdes),
   zvys16       DECIMAL($pocdes),
   zvys17       DECIMAL($pocdes),
   zvys18       DECIMAL($pocdes),
   zvys19       DECIMAL($pocdes),
   zvys20       DECIMAL($pocdes),
   zvys21       DECIMAL($pocdes),
   zvys22       DECIMAL($pocdes),
   zvys23       DECIMAL($pocdes),
   zvys24       DECIMAL($pocdes),
   zvys25       DECIMAL($pocdes),
   zvys26       DECIMAL($pocdes),
   zvys27       DECIMAL($pocdes),
   zvys28       DECIMAL($pocdes),

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
   znis13       DECIMAL($pocdes),
   znis14       DECIMAL($pocdes),
   znis15       DECIMAL($pocdes),
   znis16       DECIMAL($pocdes),
   znis17       DECIMAL($pocdes),
   znis18       DECIMAL($pocdes),
   znis19       DECIMAL($pocdes),
   znis20       DECIMAL($pocdes),
   znis21       DECIMAL($pocdes),
   znis22       DECIMAL($pocdes),
   znis23       DECIMAL($pocdes),
   znis24       DECIMAL($pocdes),
   znis25       DECIMAL($pocdes),
   znis26       DECIMAL($pocdes),
   znis27       DECIMAL($pocdes),
   znis28       DECIMAL($pocdes),

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
   oces13       DECIMAL($pocdes),
   oces14       DECIMAL($pocdes),
   oces15       DECIMAL($pocdes),
   oces16       DECIMAL($pocdes),
   oces17       DECIMAL($pocdes),
   oces18       DECIMAL($pocdes),
   oces19       DECIMAL($pocdes),
   oces20       DECIMAL($pocdes),
   oces21       DECIMAL($pocdes),
   oces22       DECIMAL($pocdes),
   oces23       DECIMAL($pocdes),
   oces24       DECIMAL($pocdes),
   oces25       DECIMAL($pocdes),
   oces26       DECIMAL($pocdes),
   oces27       DECIMAL($pocdes),
   oces28       DECIMAL($pocdes),

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
   osts13       DECIMAL($pocdes),
   osts14       DECIMAL($pocdes),
   osts15       DECIMAL($pocdes),
   osts16       DECIMAL($pocdes),
   osts17       DECIMAL($pocdes),
   osts18       DECIMAL($pocdes),
   osts19       DECIMAL($pocdes),
   osts20       DECIMAL($pocdes),
   osts21       DECIMAL($pocdes),
   osts22       DECIMAL($pocdes),
   osts23       DECIMAL($pocdes),
   osts24       DECIMAL($pocdes),
   osts25       DECIMAL($pocdes),
   osts26       DECIMAL($pocdes),
   osts27       DECIMAL($pocdes),
   osts28       DECIMAL($pocdes),

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
   zoss13       DECIMAL($pocdes),
   zoss14       DECIMAL($pocdes),
   zoss15       DECIMAL($pocdes),
   zoss16       DECIMAL($pocdes),
   zoss17       DECIMAL($pocdes),
   zoss18       DECIMAL($pocdes),
   zoss19       DECIMAL($pocdes),
   zoss20       DECIMAL($pocdes),
   zoss21       DECIMAL($pocdes),
   zoss22       DECIMAL($pocdes),
   zoss23       DECIMAL($pocdes),
   zoss24       DECIMAL($pocdes),
   zoss25       DECIMAL($pocdes),
   zoss26       DECIMAL($pocdes),
   zoss27       DECIMAL($pocdes),
   zoss28       DECIMAL($pocdes),

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
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pmd != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" -pda,$cislo_oc,0,'','','0000-00-00',".
"1,0,uce,uce,0,0,0,0,0,pda,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
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
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucm > 0 AND ume <= $kli_vume";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
"3,0,ucd,0,ucd,0,0,0,0,F$kli_vxcf"."_$uctovanie.hod,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
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
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie".
" WHERE ( ucm > 0 AND ume <= $kli_vume ) GROUP BY F$kli_vxcf"."_$uctovanie.ucm";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
"3,0,ucd,0,ucd,0,0,0,0,SUM(hod),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
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
"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),".
"SUM(pocs11),SUM(pocs12),SUM(pocs13),SUM(pocs14),SUM(pocs15),SUM(pocs16),SUM(pocs17),SUM(pocs18),SUM(pocs19),SUM(pocs20),".
"SUM(pocs21),SUM(pocs22),SUM(pocs23),SUM(pocs24),SUM(pocs25),SUM(pocs26),SUM(pocs27),SUM(pocs28),".

"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),".
"SUM(zvys11),SUM(zvys12),SUM(zvys13),SUM(zvys14),SUM(zvys15),SUM(zvys16),SUM(zvys17),SUM(zvys18),SUM(zvys19),SUM(zvys20),".
"SUM(zvys21),SUM(zvys22),SUM(zvys23),SUM(zvys24),SUM(zvys25),SUM(zvys26),SUM(zvys27),SUM(zvys28),".

"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10),".
"SUM(znis11),SUM(znis12),SUM(znis13),SUM(znis14),SUM(znis15),SUM(znis16),SUM(znis17),SUM(znis18),SUM(znis19),SUM(znis20),".
"SUM(znis21),SUM(znis22),SUM(znis23),SUM(znis24),SUM(znis25),SUM(znis26),SUM(znis27),SUM(znis28),".

"SUM(oces01),SUM(oces02),SUM(oces03),SUM(oces04),SUM(oces05),SUM(oces06),SUM(oces07),SUM(oces08),SUM(oces09),SUM(oces10),".
"SUM(oces11),SUM(oces12),SUM(oces13),SUM(oces14),SUM(oces15),SUM(oces16),SUM(oces17),SUM(oces18),SUM(oces19),SUM(oces20),".
"SUM(oces21),SUM(oces22),SUM(oces23),SUM(oces24),SUM(oces25),SUM(oces26),SUM(oces27),SUM(oces28),".

"SUM(osts01),SUM(osts02),SUM(osts03),SUM(osts04),SUM(osts05),SUM(osts06),SUM(osts07),SUM(osts08),SUM(osts09),SUM(osts10),".
"SUM(osts11),SUM(osts12),SUM(osts13),SUM(osts14),SUM(osts15),SUM(osts16),SUM(osts17),SUM(osts18),SUM(osts19),SUM(osts20),".
"SUM(osts21),SUM(osts22),SUM(osts23),SUM(osts24),SUM(osts25),SUM(osts26),SUM(osts27),SUM(osts28),".

"SUM(zoss01),SUM(zoss02),SUM(zoss03),SUM(zoss04),SUM(zoss05),SUM(zoss06),SUM(zoss07),SUM(zoss08),SUM(zoss09),SUM(zoss10),".
"SUM(zoss11),SUM(zoss12),SUM(zoss13),SUM(zoss14),SUM(zoss15),SUM(zoss16),SUM(zoss17),SUM(zoss18),SUM(zoss19),SUM(zoss20),".
"SUM(zoss21),SUM(zoss22),SUM(zoss23),SUM(zoss24),SUM(zoss25),SUM(zoss26),SUM(zoss27),SUM(zoss28),".

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
" zoss12=pocs12+zvys12-znis12+oces12+osts12,  ".
" zoss13=pocs13+zvys13-znis13+oces13+osts13,  ".
" zoss14=pocs14+zvys14-znis14+oces14+osts14,  ".
" zoss15=pocs15+zvys15-znis15+oces15+osts15,  ".
" zoss16=pocs16+zvys16-znis16+oces16+osts16,  ".
" zoss17=pocs17+zvys17-znis17+oces17+osts17,  ".
" zoss18=pocs18+zvys18-znis18+oces18+osts18,  ".
" zoss19=pocs19+zvys19-znis19+oces19+osts19,  ".
" zoss20=pocs20+zvys20-znis20+oces20+osts20,  ".

" zoss21=pocs21+zvys21-znis21+oces21+osts21,  ".
" zoss22=pocs22+zvys22-znis22+oces22+osts22,  ".
" zoss23=pocs23+zvys23-znis23+oces23+osts23,  ".
" zoss24=pocs24+zvys24-znis24+oces24+osts24,  ".
" zoss25=pocs25+zvys25-znis25+oces25+osts25,  ".
" zoss26=pocs26+zvys26-znis26+oces26+osts26,  ".
" zoss27=pocs27+zvys27-znis27+oces27+osts27,  ".
" zoss28=pocs28+zvys28-znis28+oces28+osts28  ".

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
$pocs05 = $fir_riadok->pocs05;
$pocs06 = $fir_riadok->pocs06;
$pocs07 = $fir_riadok->pocs07;
$pocs08 = $fir_riadok->pocs08;
$pocs09 = $fir_riadok->pocs09;
$pocs10 = $fir_riadok->pocs10;
$pocs11 = $fir_riadok->pocs11;
$pocs12 = $fir_riadok->pocs12;
$pocs13 = $fir_riadok->pocs13;
$pocs14 = $fir_riadok->pocs14;

$pocs15 = $fir_riadok->pocs15;
$pocs16 = $fir_riadok->pocs16;
$pocs17 = $fir_riadok->pocs17;
$pocs18 = $fir_riadok->pocs18;
$pocs19 = $fir_riadok->pocs19;
$pocs20 = $fir_riadok->pocs20;
$pocs21 = $fir_riadok->pocs21;
$pocs22 = $fir_riadok->pocs22;
$pocs23 = $fir_riadok->pocs23;
$pocs24 = $fir_riadok->pocs24;
$pocs25 = $fir_riadok->pocs25;
$pocs26 = $fir_riadok->pocs26;
$pocs27 = $fir_riadok->pocs27;
$pocs28 = $fir_riadok->pocs28;

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
$zvys11 = $fir_riadok->zvys11;
$zvys12 = $fir_riadok->zvys12;
$zvys13 = $fir_riadok->zvys13;
$zvys14 = $fir_riadok->zvys14;

$zvys15 = $fir_riadok->zvys15;
$zvys16 = $fir_riadok->zvys16;
$zvys17 = $fir_riadok->zvys17;
$zvys18 = $fir_riadok->zvys18;
$zvys19 = $fir_riadok->zvys19;
$zvys10 = $fir_riadok->zvys20;
$zvys21 = $fir_riadok->zvys21;
$zvys22 = $fir_riadok->zvys22;
$zvys23 = $fir_riadok->zvys23;
$zvys24 = $fir_riadok->zvys24;
$zvys25 = $fir_riadok->zvys25;
$zvys26 = $fir_riadok->zvys26;
$zvys27 = $fir_riadok->zvys27;
$zvys28 = $fir_riadok->zvys28;

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
$znis11 = $fir_riadok->znis11;
$znis12 = $fir_riadok->znis12;
$znis13 = $fir_riadok->znis13;
$znis14 = $fir_riadok->znis14;

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
$oces13 = $fir_riadok->oces13;
$oces14 = $fir_riadok->oces14;

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
$osts13 = $fir_riadok->osts13;
$osts14 = $fir_riadok->osts14;

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
$zoss11 = $fir_riadok->zoss11;
$zoss12 = $fir_riadok->zoss12;
$zoss13 = $fir_riadok->zoss13;
$zoss14 = $fir_riadok->zoss14;

$znis15 = $fir_riadok->znis15;
$znis16 = $fir_riadok->znis16;
$znis17 = $fir_riadok->znis17;
$znis18 = $fir_riadok->znis18;
$znis19 = $fir_riadok->znis19;
$znis10 = $fir_riadok->znis20;
$znis21 = $fir_riadok->znis21;
$znis22 = $fir_riadok->znis22;
$znis23 = $fir_riadok->znis23;
$znis24 = $fir_riadok->znis24;
$znis25 = $fir_riadok->znis25;
$znis26 = $fir_riadok->znis26;
$znis27 = $fir_riadok->znis27;
$znis28 = $fir_riadok->znis28;

$oces15 = $fir_riadok->oces15;
$oces16 = $fir_riadok->oces16;
$oces17 = $fir_riadok->oces17;
$oces18 = $fir_riadok->oces18;
$oces19 = $fir_riadok->oces19;
$oces10 = $fir_riadok->oces20;
$oces21 = $fir_riadok->oces21;
$oces22 = $fir_riadok->oces22;
$oces23 = $fir_riadok->oces23;
$oces24 = $fir_riadok->oces24;
$oces25 = $fir_riadok->oces25;
$oces26 = $fir_riadok->oces26;
$oces27 = $fir_riadok->oces27;
$oces28 = $fir_riadok->oces28;

$osts15 = $fir_riadok->osts15;
$osts16 = $fir_riadok->osts16;
$osts17 = $fir_riadok->osts17;
$osts18 = $fir_riadok->osts18;
$osts19 = $fir_riadok->osts19;
$osts10 = $fir_riadok->osts20;
$osts21 = $fir_riadok->osts21;
$osts22 = $fir_riadok->osts22;
$osts23 = $fir_riadok->osts23;
$osts24 = $fir_riadok->osts24;
$osts25 = $fir_riadok->osts25;
$osts26 = $fir_riadok->osts26;
$osts27 = $fir_riadok->osts27;
$osts28 = $fir_riadok->osts28;

$zoss15 = $fir_riadok->zoss15;
$zoss16 = $fir_riadok->zoss16;
$zoss17 = $fir_riadok->zoss17;
$zoss18 = $fir_riadok->zoss18;
$zoss19 = $fir_riadok->zoss19;
$zoss10 = $fir_riadok->zoss20;
$zoss21 = $fir_riadok->zoss21;
$zoss22 = $fir_riadok->zoss22;
$zoss23 = $fir_riadok->zoss23;
$zoss24 = $fir_riadok->zoss24;
$zoss25 = $fir_riadok->zoss25;
$zoss26 = $fir_riadok->zoss26;
$zoss27 = $fir_riadok->zoss27;
$zoss28 = $fir_riadok->zoss28;
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
   document.formv1.pocs13.value = '<?php echo $pocs13; ?>';
   document.formv1.pocs14.value = '<?php echo $pocs14; ?>';

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
   document.formv1.zvys13.value = '<?php echo $zvys13; ?>';
   document.formv1.zvys14.value = '<?php echo $zvys14; ?>';


   document.formv1.znis01.value = '<?php echo $znis01; ?>';
   document.formv1.znis02.value = '<?php echo $znis02; ?>';
   document.formv1.znis03.value = '<?php echo $znis03; ?>';
   document.formv1.znis04.value = '<?php echo $znis04; ?>';
//   document.formv1.znis05.value = '<?php echo $znis05; ?>';
//   document.formv1.znis06.value = '<?php echo $znis06; ?>';
   document.formv1.znis07.value = '<?php echo $znis07; ?>';
   document.formv1.znis08.value = '<?php echo $znis08; ?>';
   document.formv1.znis09.value = '<?php echo $znis09; ?>';
   document.formv1.znis10.value = '<?php echo $znis10; ?>';
   document.formv1.znis11.value = '<?php echo $znis11; ?>';
   document.formv1.znis12.value = '<?php echo $znis12; ?>';
   document.formv1.znis13.value = '<?php echo $znis13; ?>';
   document.formv1.znis14.value = '<?php echo $znis14; ?>';


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
   document.formv1.oces13.value = '<?php echo $oces13; ?>';
   document.formv1.oces14.value = '<?php echo $oces14; ?>';

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
   document.formv1.osts13.value = '<?php echo $osts13; ?>';
   document.formv1.osts14.value = '<?php echo $osts14; ?>';

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
   document.formv1.zoss13.value = '<?php echo $zoss13; ?>';
   document.formv1.zoss14.value = '<?php echo $zoss14; ?>';


   document.formv1.pocs15.value = '<?php echo $pocs15; ?>';
   document.formv1.pocs16.value = '<?php echo $pocs16; ?>';
   document.formv1.pocs17.value = '<?php echo $pocs17; ?>';
   document.formv1.pocs18.value = '<?php echo $pocs18; ?>';
//   document.formv1.pocs19.value = '<?php echo $pocs19; ?>';
//   document.formv1.pocs20.value = '<?php echo $pocs20; ?>';
   document.formv1.pocs21.value = '<?php echo $pocs21; ?>';
   document.formv1.pocs22.value = '<?php echo $pocs22; ?>';
   document.formv1.pocs23.value = '<?php echo $pocs23; ?>';
   document.formv1.pocs24.value = '<?php echo $pocs24; ?>';
   document.formv1.pocs25.value = '<?php echo $pocs25; ?>';
   document.formv1.pocs26.value = '<?php echo $pocs26; ?>';
   document.formv1.pocs27.value = '<?php echo $pocs27; ?>';
   document.formv1.pocs28.value = '<?php echo $pocs28; ?>';

   document.formv1.zvys15.value = '<?php echo $zvys15; ?>';
   document.formv1.zvys16.value = '<?php echo $zvys16; ?>';
   document.formv1.zvys17.value = '<?php echo $zvys17; ?>';
   document.formv1.zvys18.value = '<?php echo $zvys18; ?>';
//   document.formv1.zvys19.value = '<?php echo $zvys19; ?>';
//   document.formv1.zvys20.value = '<?php echo $zvys20; ?>';
   document.formv1.zvys21.value = '<?php echo $zvys21; ?>';
   document.formv1.zvys22.value = '<?php echo $zvys22; ?>';
   document.formv1.zvys23.value = '<?php echo $zvys23; ?>';
   document.formv1.zvys24.value = '<?php echo $zvys24; ?>';
   document.formv1.zvys25.value = '<?php echo $zvys25; ?>';
   document.formv1.zvys26.value = '<?php echo $zvys26; ?>';
   document.formv1.zvys27.value = '<?php echo $zvys27; ?>';
   document.formv1.zvys28.value = '<?php echo $zvys28; ?>';

   document.formv1.znis15.value = '<?php echo $znis15; ?>';
   document.formv1.znis16.value = '<?php echo $znis16; ?>';
   document.formv1.znis17.value = '<?php echo $znis17; ?>';
   document.formv1.znis18.value = '<?php echo $znis18; ?>';
//   document.formv1.znis19.value = '<?php echo $znis19; ?>';
//   document.formv1.znis20.value = '<?php echo $znis20; ?>';
   document.formv1.znis21.value = '<?php echo $znis21; ?>';
   document.formv1.znis22.value = '<?php echo $znis22; ?>';
   document.formv1.znis23.value = '<?php echo $znis23; ?>';
   document.formv1.znis24.value = '<?php echo $znis24; ?>';
   document.formv1.znis25.value = '<?php echo $znis25; ?>';
   document.formv1.znis26.value = '<?php echo $znis26; ?>';
   document.formv1.znis27.value = '<?php echo $znis27; ?>';
   document.formv1.znis28.value = '<?php echo $znis28; ?>';

   document.formv1.oces15.value = '<?php echo $oces15; ?>';
   document.formv1.oces16.value = '<?php echo $oces16; ?>';
   document.formv1.oces17.value = '<?php echo $oces17; ?>';
   document.formv1.oces18.value = '<?php echo $oces18; ?>';
   document.formv1.oces19.value = '<?php echo $oces19; ?>';
   document.formv1.oces20.value = '<?php echo $oces20; ?>';
   document.formv1.oces21.value = '<?php echo $oces21; ?>';
   document.formv1.oces22.value = '<?php echo $oces22; ?>';
   document.formv1.oces23.value = '<?php echo $oces23; ?>';
   document.formv1.oces24.value = '<?php echo $oces24; ?>';
   document.formv1.oces25.value = '<?php echo $oces25; ?>';
   document.formv1.oces26.value = '<?php echo $oces26; ?>';
   document.formv1.oces27.value = '<?php echo $oces27; ?>';
   document.formv1.oces28.value = '<?php echo $oces28; ?>';

   document.formv1.osts15.value = '<?php echo $osts15; ?>';
   document.formv1.osts16.value = '<?php echo $osts16; ?>';
   document.formv1.osts17.value = '<?php echo $osts17; ?>';
   document.formv1.osts18.value = '<?php echo $osts18; ?>';
   document.formv1.osts19.value = '<?php echo $osts19; ?>';
   document.formv1.osts20.value = '<?php echo $osts20; ?>';
   document.formv1.osts21.value = '<?php echo $osts21; ?>';
   document.formv1.osts22.value = '<?php echo $osts22; ?>';
   document.formv1.osts23.value = '<?php echo $osts23; ?>';
   document.formv1.osts24.value = '<?php echo $osts24; ?>';
   document.formv1.osts25.value = '<?php echo $osts25; ?>';
   document.formv1.osts26.value = '<?php echo $osts26; ?>';
   document.formv1.osts27.value = '<?php echo $osts27; ?>';
   document.formv1.osts28.value = '<?php echo $osts28; ?>';

   document.formv1.zoss15.value = '<?php echo $zoss15; ?>';
   document.formv1.zoss16.value = '<?php echo $zoss16; ?>';
   document.formv1.zoss17.value = '<?php echo $zoss17; ?>';
   document.formv1.zoss18.value = '<?php echo $zoss18; ?>';
//   document.formv1.zoss19.value = '<?php echo $zoss19; ?>';
//   document.formv1.zoss20.value = '<?php echo $zoss20; ?>';
   document.formv1.zoss21.value = '<?php echo $zoss21; ?>';
   document.formv1.zoss22.value = '<?php echo $zoss22; ?>';
   document.formv1.zoss23.value = '<?php echo $zoss23; ?>';
   document.formv1.zoss24.value = '<?php echo $zoss24; ?>';
   document.formv1.zoss25.value = '<?php echo $zoss25; ?>';
   document.formv1.zoss26.value = '<?php echo $zoss26; ?>';
   document.formv1.zoss27.value = '<?php echo $zoss27; ?>';
   document.formv1.zoss28.value = '<?php echo $zoss28; ?>';


<?php                     } ?>

<?php if ( $strana == 3 ) { ?>

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
   window.open('vykaz_fin404_2018.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999',
'_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function Nacitaj()
  {
   window.open('vykaz_fin404_2018.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=0&strana=1',
'_self', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }

  function DbfFin404()
  {
   window.open('fin404dbf_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=1&drupoh=1&page=1&subor=0',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

function CsvFin404()
                {
window.open('vykaz_fin404_csv.php?cislo_oc=<?php echo $cislo_oc;?>&copern=1&drupoh=1&page=1&subor=0',
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
  <td class="header">FIN 4-04 Finanèné pasíva pod¾a sektorov za
   <span style="color:#39f;"><?php echo "$cislo_oc. štvrrok";?></span>
  </td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();" title="Vysvetlivky na vyplnenie výkazu" class="btn-form-tool">
<?php if ( $kli_vrok < 2018 ) { ?>
    <button type="button" onclick="DbfFin404();" title="Export do DBF" class="btn-text toright" style="position: relative; top: -4px;">DBF</button>
<?php } ?>
<?php if ( $kli_vrok >= 2017 ) { ?>
    <button type="button" onclick="CsvFin404();" title="Export do CSV" class="btn-text toright" style="position: relative; top: -4px;">CSV</button>
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
<FORM name="formv1" method="post" action="../ucto/vykaz_fin404_2018.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
if ( $strana == 3 ) $clas3="active";
$source="vykaz_fin404_2018.php";
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
<img src="<?php echo $jpg_cesta; ?>_str2_form.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 2.strana 265kB" style="width:1250px; height:1000px;">


<!-- poc.stav  -->
<?php $top=270; ?>
<input type="text" name="pocs01" id="pocs01" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:320px;"/>
<input type="text" name="pocs02" id="pocs02" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:390px;"/>
<input type="text" name="pocs03" id="pocs03" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:450px;"/>
<input type="text" name="pocs04" id="pocs04" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:520px;"/>
<input type="text" name="pocs07" id="pocs07" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:710px;"/>
<input type="text" name="pocs08" id="pocs08" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:780px;"/>
<input type="text" name="pocs09" id="pocs09" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:840px;"/>
<input type="text" name="pocs10" id="pocs10" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:910px;"/>
<input type="text" name="pocs11" id="pocs11" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:970px;"/>
<input type="text" name="pocs12" id="pocs12" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1040px;"/>
<input type="text" name="pocs13" id="pocs13" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:1100px;"/>
<input type="text" name="pocs14" id="pocs14" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1170px;"/>

<!-- zvysenie -->
<?php $top=339; ?>
<input type="text" name="zvys01" id="zvys01" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:320px;"/>
<input type="text" name="zvys02" id="zvys02" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:390px;"/>
<input type="text" name="zvys03" id="zvys03" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:450px;"/>
<input type="text" name="zvys04" id="zvys04" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:520px;"/>
<input type="text" name="zvys07" id="zvys07" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:710px;"/>
<input type="text" name="zvys08" id="zvys08" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:780px;"/>
<input type="text" name="zvys09" id="zvys09" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:840px;"/>
<input type="text" name="zvys10" id="zvys10" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:910px;"/>
<input type="text" name="zvys11" id="zvys11" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:970px;"/>
<input type="text" name="zvys12" id="zvys12" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1040px;"/>
<input type="text" name="zvys13" id="zvys13" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:1100px;"/>
<input type="text" name="zvys14" id="zvys14" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1170px;"/>

<!-- znizenie -->
<?php $top=377; ?>
<input type="text" name="znis01" id="znis01" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:320px;"/>
<input type="text" name="znis02" id="znis02" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:390px;"/>
<input type="text" name="znis03" id="znis03" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:450px;"/>
<input type="text" name="znis04" id="znis04" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:520px;"/>
<input type="text" name="znis07" id="znis07" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:710px;"/>
<input type="text" name="znis08" id="znis08" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:780px;"/>
<input type="text" name="znis09" id="znis09" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:840px;"/>
<input type="text" name="znis10" id="znis10" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:910px;"/>
<input type="text" name="znis11" id="znis11" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:970px;"/>
<input type="text" name="znis12" id="znis12" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1040px;"/>
<input type="text" name="znis13" id="znis13" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:1100px;"/>
<input type="text" name="znis14" id="znis14" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1170px;"/>

<!-- ocenenie -->
<?php $top=414; ?>
<input type="text" name="oces01" id="oces01" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:320px;"/>
<input type="text" name="oces02" id="oces02" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:390px;"/>
<input type="text" name="oces03" id="oces03" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:450px;"/>
<input type="text" name="oces04" id="oces04" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:520px;"/>
<input type="text" name="oces05" id="oces05" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:580px;"/>
<input type="text" name="oces06" id="oces06" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:650px;"/>
<input type="text" name="oces07" id="oces07" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:710px;"/>
<input type="text" name="oces08" id="oces08" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:780px;"/>
<input type="text" name="oces09" id="oces09" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:840px;"/>
<input type="text" name="oces10" id="oces10" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:910px;"/>
<input type="text" name="oces11" id="oces11" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:970px;"/>
<input type="text" name="oces12" id="oces12" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1040px;"/>
<input type="text" name="oces13" id="oces13" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:1100px;"/>
<input type="text" name="oces14" id="oces14" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1170px;"/>

<!-- ostatne -->
<?php $top=450; ?>
<input type="text" name="osts01" id="osts01" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:320px;"/>
<input type="text" name="osts02" id="osts02" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:390px;"/>
<input type="text" name="osts03" id="osts03" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:450px;"/>
<input type="text" name="osts04" id="osts04" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:520px;"/>
<input type="text" name="osts05" id="osts05" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:580px;"/>
<input type="text" name="osts06" id="osts06" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:650px;"/>
<input type="text" name="osts07" id="osts07" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:710px;"/>
<input type="text" name="osts08" id="osts08" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:780px;"/>
<input type="text" name="osts09" id="osts09" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:840px;"/>
<input type="text" name="osts10" id="osts10" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:910px;"/>
<input type="text" name="osts11" id="osts11" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:970px;"/>
<input type="text" name="osts12" id="osts12" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1040px;"/>
<input type="text" name="osts13" id="osts13" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:1100px;"/>
<input type="text" name="osts14" id="osts14" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1170px;"/>

<!-- zostatok -->
<?php $top=487; ?>
<input type="text" name="zoss01" id="zoss01" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:320px;"/>
<input type="text" name="zoss02" id="zoss02" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:390px;"/>
<input type="text" name="zoss03" id="zoss03" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:450px;"/>
<input type="text" name="zoss04" id="zoss04" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:520px;"/>
<input type="text" name="zoss07" id="zoss07" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:710px;"/>
<input type="text" name="zoss08" id="zoss08" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:780px;"/>
<input type="text" name="zoss09" id="zoss09" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:840px;"/>
<input type="text" name="zoss10" id="zoss10" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:910px;"/>
<input type="text" name="zoss11" id="zoss11" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:970px;"/>
<input type="text" name="zoss12" id="zoss12" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1040px;"/>
<input type="text" name="zoss13" id="zoss13" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:1100px;"/>
<input type="text" name="zoss14" id="zoss14" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1170px;"/>


<!-- stlpce 15 az 28 -->


<!-- poc.stav  -->
<?php $top=724; ?>
<input type="text" name="pocs15" id="pocs15" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:320px;"/>
<input type="text" name="pocs16" id="pocs16" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:390px;"/>
<input type="text" name="pocs17" id="pocs17" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:450px;"/>
<input type="text" name="pocs18" id="pocs18" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:520px;"/>
<input type="text" name="pocs21" id="pocs21" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:710px;"/>
<input type="text" name="pocs22" id="pocs22" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:780px;"/>
<input type="text" name="pocs23" id="pocs23" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:840px;"/>
<input type="text" name="pocs24" id="pocs24" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:910px;"/>
<input type="text" name="pocs25" id="pocs25" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:970px;"/>
<input type="text" name="pocs26" id="pocs26" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1040px;"/>
<input type="text" name="pocs27" id="pocs27" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:1100px;"/>
<input type="text" name="pocs28" id="pocs28" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1170px;"/>

<!-- zvysenie -->
<?php $top=795; ?>
<input type="text" name="zvys15" id="zvys15" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:320px;"/>
<input type="text" name="zvys16" id="zvys16" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:390px;"/>
<input type="text" name="zvys17" id="zvys17" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:450px;"/>
<input type="text" name="zvys18" id="zvys18" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:520px;"/>
<input type="text" name="zvys21" id="zvys21" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:710px;"/>
<input type="text" name="zvys22" id="zvys22" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:780px;"/>
<input type="text" name="zvys23" id="zvys23" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:840px;"/>
<input type="text" name="zvys24" id="zvys24" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:910px;"/>
<input type="text" name="zvys25" id="zvys25" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:970px;"/>
<input type="text" name="zvys26" id="zvys26" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1040px;"/>
<input type="text" name="zvys27" id="zvys27" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:1100px;"/>
<input type="text" name="zvys28" id="zvys28" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1170px;"/>

<!-- znizenie -->
<?php $top=831; ?>
<input type="text" name="znis15" id="znis15" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:320px;"/>
<input type="text" name="znis16" id="znis16" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:390px;"/>
<input type="text" name="znis17" id="znis17" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:450px;"/>
<input type="text" name="znis18" id="znis18" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:520px;"/>
<input type="text" name="znis21" id="znis21" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:710px;"/>
<input type="text" name="znis22" id="znis22" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:780px;"/>
<input type="text" name="znis23" id="znis23" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:840px;"/>
<input type="text" name="znis24" id="znis24" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:910px;"/>
<input type="text" name="znis25" id="znis25" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:970px;"/>
<input type="text" name="znis26" id="znis26" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1040px;"/>
<input type="text" name="znis27" id="znis27" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:1100px;"/>
<input type="text" name="znis28" id="znis28" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1170px;"/>

<!-- ocenenie -->
<?php $top=868; ?>
<input type="text" name="oces15" id="oces15" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:320px;"/>
<input type="text" name="oces16" id="oces16" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:390px;"/>
<input type="text" name="oces17" id="oces17" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:450px;"/>
<input type="text" name="oces18" id="oces18" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:520px;"/>
<input type="text" name="oces19" id="oces19" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:580px;"/>
<input type="text" name="oces20" id="oces20" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:650px;"/>
<input type="text" name="oces21" id="oces21" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:710px;"/>
<input type="text" name="oces22" id="oces22" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:780px;"/>
<input type="text" name="oces23" id="oces23" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:840px;"/>
<input type="text" name="oces24" id="oces24" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:910px;"/>
<input type="text" name="oces25" id="oces25" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:970px;"/>
<input type="text" name="oces26" id="oces26" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1040px;"/>
<input type="text" name="oces27" id="oces27" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:1100px;"/>
<input type="text" name="oces28" id="oces28" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1170px;"/>

<!-- ostatne -->
<?php $top=902; ?>
<input type="text" name="osts15" id="osts15" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:320px;"/>
<input type="text" name="osts16" id="osts16" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:390px;"/>
<input type="text" name="osts17" id="osts17" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:450px;"/>
<input type="text" name="osts18" id="osts18" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:520px;"/>
<input type="text" name="osts19" id="osts19" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:580px;"/>
<input type="text" name="osts20" id="osts20" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:650px;"/>
<input type="text" name="osts21" id="osts21" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:710px;"/>
<input type="text" name="osts22" id="osts22" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:780px;"/>
<input type="text" name="osts23" id="osts23" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:840px;"/>
<input type="text" name="osts24" id="osts24" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:910px;"/>
<input type="text" name="osts25" id="osts25" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:970px;"/>
<input type="text" name="osts26" id="osts26" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1040px;"/>
<input type="text" name="osts27" id="osts27" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:1100px;"/>
<input type="text" name="osts28" id="osts28" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1170px;"/>

<!-- zostatok -->
<?php $top=936; ?>
<input type="text" name="zoss15" id="zoss15" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:320px;"/>
<input type="text" name="zoss16" id="zoss16" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:390px;"/>
<input type="text" name="zoss17" id="zoss17" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:450px;"/>
<input type="text" name="zoss18" id="zoss18" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:520px;"/>
<input type="text" name="zoss21" id="zoss21" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:710px;"/>
<input type="text" name="zoss22" id="zoss22" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:780px;"/>
<input type="text" name="zoss23" id="zoss23" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:840px;"/>
<input type="text" name="zoss24" id="zoss24" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:910px;"/>
<input type="text" name="zoss25" id="zoss25" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:970px;"/>
<input type="text" name="zoss26" id="zoss26" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1040px;"/>
<input type="text" name="zoss27" id="zoss27" onkeyup="CiarkaNaBodku(this);" style="width:60px; top:<?php echo $top; ?>px; left:1100px;"/>
<input type="text" name="zoss28" id="zoss28" onkeyup="CiarkaNaBodku(this);" style="width:50px; top:<?php echo $top; ?>px; left:1170px;"/>





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

$hhmmss = Date ("mdHi", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/vykfin_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/vykfin_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

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
if ( File_Exists($jpg_cesta.'_str2_form.jpg') )
{
$pdf->Image($jpg_cesta.'_str2_form.jpg',5,0,305,200);
}
$pdf->SetY(10);

//$rmc=1; $rmc1=1;
$pocs01=$hlavicka->pocs01; if ( $hlavicka->pocs01 == 0 ) $pocs01="";
$pocs02=$hlavicka->pocs02; if ( $hlavicka->pocs02 == 0 ) $pocs02="";
$pocs03=$hlavicka->pocs03; if ( $hlavicka->pocs03 == 0 ) $pocs03="";
$pocs04=$hlavicka->pocs04; if ( $hlavicka->pocs04 == 0 ) $pocs04="";
$pocs05=$hlavicka->pocs05; if ( $hlavicka->pocs05 == 0 ) $pocs05="";
$pocs06=$hlavicka->pocs06; if ( $hlavicka->pocs06 == 0 ) $pocs06="";
$pocs07=$hlavicka->pocs07; if ( $hlavicka->pocs07 == 0 ) $pocs07="";
$pocs08=$hlavicka->pocs08; if ( $hlavicka->pocs08 == 0 ) $pocs08="";
$pocs09=$hlavicka->pocs09; if ( $hlavicka->pocs09 == 0 ) $pocs09="";
$pocs10=$hlavicka->pocs10; if ( $hlavicka->pocs10 == 0 ) $pocs10="";
$pocs11=$hlavicka->pocs11; if ( $hlavicka->pocs11 == 0 ) $pocs11="";
$pocs12=$hlavicka->pocs12; if ( $hlavicka->pocs12 == 0 ) $pocs12="";
$pocs13=$hlavicka->pocs13; if ( $hlavicka->pocs13 == 0 ) $pocs13="";
$pocs14=$hlavicka->pocs14; if ( $hlavicka->pocs14 == 0 ) $pocs14="";
$pocs15=$hlavicka->pocs15; if ( $hlavicka->pocs15 == 0 ) $pocs15="";
$pocs16=$hlavicka->pocs16; if ( $hlavicka->pocs16 == 0 ) $pocs16="";
$pocs17=$hlavicka->pocs17; if ( $hlavicka->pocs17 == 0 ) $pocs17="";
$pocs18=$hlavicka->pocs18; if ( $hlavicka->pocs18 == 0 ) $pocs18="";
$pocs19=$hlavicka->pocs19; if ( $hlavicka->pocs19 == 0 ) $pocs19="";
$pocs20=$hlavicka->pocs20; if ( $hlavicka->pocs20 == 0 ) $pocs20="";
$pocs21=$hlavicka->pocs21; if ( $hlavicka->pocs21 == 0 ) $pocs21="";
$pocs22=$hlavicka->pocs22; if ( $hlavicka->pocs22 == 0 ) $pocs22="";
$pocs23=$hlavicka->pocs23; if ( $hlavicka->pocs23 == 0 ) $pocs23="";
$pocs24=$hlavicka->pocs24; if ( $hlavicka->pocs24 == 0 ) $pocs24="";
$pocs25=$hlavicka->pocs25; if ( $hlavicka->pocs25 == 0 ) $pocs25="";
$pocs26=$hlavicka->pocs26; if ( $hlavicka->pocs26 == 0 ) $pocs26="";
$pocs27=$hlavicka->pocs27; if ( $hlavicka->pocs27 == 0 ) $pocs27="";
$pocs28=$hlavicka->pocs28; if ( $hlavicka->pocs28 == 0 ) $pocs28="";


$zvys01=$hlavicka->zvys01; if ( $hlavicka->zvys01 == 0 ) $zvys01="";
$zvys02=$hlavicka->zvys02; if ( $hlavicka->zvys02 == 0 ) $zvys02="";
$zvys03=$hlavicka->zvys03; if ( $hlavicka->zvys03 == 0 ) $zvys03="";
$zvys04=$hlavicka->zvys04; if ( $hlavicka->zvys04 == 0 ) $zvys04="";
$zvys05=$hlavicka->zvys05; if ( $hlavicka->zvys05 == 0 ) $zvys05="";
$zvys06=$hlavicka->zvys06; if ( $hlavicka->zvys06 == 0 ) $zvys06="";
$zvys07=$hlavicka->zvys07; if ( $hlavicka->zvys07 == 0 ) $zvys07="";
$zvys08=$hlavicka->zvys08; if ( $hlavicka->zvys08 == 0 ) $zvys08="";
$zvys09=$hlavicka->zvys09; if ( $hlavicka->zvys09 == 0 ) $zvys09="";
$zvys10=$hlavicka->zvys10; if ( $hlavicka->zvys10 == 0 ) $zvys10="";
$zvys11=$hlavicka->zvys11; if ( $hlavicka->zvys11 == 0 ) $zvys11="";
$zvys12=$hlavicka->zvys12; if ( $hlavicka->zvys12 == 0 ) $zvys12="";
$zvys13=$hlavicka->zvys13; if ( $hlavicka->zvys13 == 0 ) $zvys13="";
$zvys14=$hlavicka->zvys14; if ( $hlavicka->zvys14 == 0 ) $zvys14="";
$zvys15=$hlavicka->zvys15; if ( $hlavicka->zvys15 == 0 ) $zvys15="";
$zvys16=$hlavicka->zvys16; if ( $hlavicka->zvys16 == 0 ) $zvys16="";
$zvys17=$hlavicka->zvys17; if ( $hlavicka->zvys17 == 0 ) $zvys17="";
$zvys18=$hlavicka->zvys18; if ( $hlavicka->zvys18 == 0 ) $zvys18="";
$zvys19=$hlavicka->zvys19; if ( $hlavicka->zvys19 == 0 ) $zvys19="";
$zvys20=$hlavicka->zvys20; if ( $hlavicka->zvys20 == 0 ) $zvys20="";
$zvys21=$hlavicka->zvys21; if ( $hlavicka->zvys21 == 0 ) $zvys21="";
$zvys22=$hlavicka->zvys22; if ( $hlavicka->zvys22 == 0 ) $zvys22="";
$zvys23=$hlavicka->zvys23; if ( $hlavicka->zvys23 == 0 ) $zvys23="";
$zvys24=$hlavicka->zvys24; if ( $hlavicka->zvys24 == 0 ) $zvys24="";
$zvys25=$hlavicka->zvys25; if ( $hlavicka->zvys25 == 0 ) $zvys25="";
$zvys26=$hlavicka->zvys26; if ( $hlavicka->zvys26 == 0 ) $zvys26="";
$zvys27=$hlavicka->zvys27; if ( $hlavicka->zvys27 == 0 ) $zvys27="";
$zvys28=$hlavicka->zvys28; if ( $hlavicka->zvys28 == 0 ) $zvys28="";


$znis01=$hlavicka->znis01; if ( $hlavicka->znis01 == 0 ) $znis01="";
$znis02=$hlavicka->znis02; if ( $hlavicka->znis02 == 0 ) $znis02="";
$znis03=$hlavicka->znis03; if ( $hlavicka->znis03 == 0 ) $znis03="";
$znis04=$hlavicka->znis04; if ( $hlavicka->znis04 == 0 ) $znis04="";
$znis05=$hlavicka->znis05; if ( $hlavicka->znis05 == 0 ) $znis05="";
$znis06=$hlavicka->znis06; if ( $hlavicka->znis06 == 0 ) $znis06="";
$znis07=$hlavicka->znis07; if ( $hlavicka->znis07 == 0 ) $znis07="";
$znis08=$hlavicka->znis08; if ( $hlavicka->znis08 == 0 ) $znis08="";
$znis09=$hlavicka->znis09; if ( $hlavicka->znis09 == 0 ) $znis09="";
$znis10=$hlavicka->znis10; if ( $hlavicka->znis10 == 0 ) $znis10="";
$znis11=$hlavicka->znis11; if ( $hlavicka->znis11 == 0 ) $znis11="";
$znis12=$hlavicka->znis12; if ( $hlavicka->znis12 == 0 ) $znis12="";
$znis13=$hlavicka->znis13; if ( $hlavicka->znis13 == 0 ) $znis13="";
$znis14=$hlavicka->znis14; if ( $hlavicka->znis14 == 0 ) $znis14="";
$znis15=$hlavicka->znis15; if ( $hlavicka->znis15 == 0 ) $znis15="";
$znis16=$hlavicka->znis16; if ( $hlavicka->znis16 == 0 ) $znis16="";
$znis17=$hlavicka->znis17; if ( $hlavicka->znis17 == 0 ) $znis17="";
$znis18=$hlavicka->znis18; if ( $hlavicka->znis18 == 0 ) $znis18="";
$znis19=$hlavicka->znis19; if ( $hlavicka->znis19 == 0 ) $znis19="";
$znis20=$hlavicka->znis20; if ( $hlavicka->znis20 == 0 ) $znis20="";
$znis21=$hlavicka->znis21; if ( $hlavicka->znis21 == 0 ) $znis21="";
$znis22=$hlavicka->znis22; if ( $hlavicka->znis22 == 0 ) $znis22="";
$znis23=$hlavicka->znis23; if ( $hlavicka->znis23 == 0 ) $znis23="";
$znis24=$hlavicka->znis24; if ( $hlavicka->znis24 == 0 ) $znis24="";
$znis25=$hlavicka->znis25; if ( $hlavicka->znis25 == 0 ) $znis25="";
$znis26=$hlavicka->znis26; if ( $hlavicka->znis26 == 0 ) $znis26="";
$znis27=$hlavicka->znis27; if ( $hlavicka->znis27 == 0 ) $znis27="";
$znis28=$hlavicka->znis28; if ( $hlavicka->znis28 == 0 ) $znis28="";


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
$oces13=$hlavicka->oces13; if ( $hlavicka->oces13 == 0 ) $oces13="";
$oces14=$hlavicka->oces14; if ( $hlavicka->oces14 == 0 ) $oces14="";
$oces15=$hlavicka->oces15; if ( $hlavicka->oces15 == 0 ) $oces15="";
$oces16=$hlavicka->oces16; if ( $hlavicka->oces16 == 0 ) $oces16="";
$oces17=$hlavicka->oces17; if ( $hlavicka->oces17 == 0 ) $oces17="";
$oces18=$hlavicka->oces18; if ( $hlavicka->oces18 == 0 ) $oces18="";
$oces19=$hlavicka->oces19; if ( $hlavicka->oces19 == 0 ) $oces19="";
$oces20=$hlavicka->oces20; if ( $hlavicka->oces20 == 0 ) $oces20="";
$oces21=$hlavicka->oces21; if ( $hlavicka->oces21 == 0 ) $oces21="";
$oces22=$hlavicka->oces22; if ( $hlavicka->oces22 == 0 ) $oces22="";
$oces23=$hlavicka->oces23; if ( $hlavicka->oces23 == 0 ) $oces23="";
$oces24=$hlavicka->oces24; if ( $hlavicka->oces24 == 0 ) $oces24="";
$oces25=$hlavicka->oces25; if ( $hlavicka->oces25 == 0 ) $oces25="";
$oces26=$hlavicka->oces26; if ( $hlavicka->oces26 == 0 ) $oces26="";
$oces27=$hlavicka->oces27; if ( $hlavicka->oces27 == 0 ) $oces27="";
$oces28=$hlavicka->oces28; if ( $hlavicka->oces28 == 0 ) $oces28="";


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
$osts13=$hlavicka->osts13; if ( $hlavicka->osts13 == 0 ) $osts13="";
$osts14=$hlavicka->osts14; if ( $hlavicka->osts14 == 0 ) $osts14="";
$osts15=$hlavicka->osts15; if ( $hlavicka->osts15 == 0 ) $osts15="";
$osts16=$hlavicka->osts16; if ( $hlavicka->osts16 == 0 ) $osts16="";
$osts17=$hlavicka->osts17; if ( $hlavicka->osts17 == 0 ) $osts17="";
$osts18=$hlavicka->osts18; if ( $hlavicka->osts18 == 0 ) $osts18="";
$osts19=$hlavicka->osts19; if ( $hlavicka->osts19 == 0 ) $osts19="";
$osts20=$hlavicka->osts20; if ( $hlavicka->osts20 == 0 ) $osts20="";
$osts21=$hlavicka->osts21; if ( $hlavicka->osts21 == 0 ) $osts21="";
$osts22=$hlavicka->osts22; if ( $hlavicka->osts22 == 0 ) $osts22="";
$osts23=$hlavicka->osts23; if ( $hlavicka->osts23 == 0 ) $osts23="";
$osts24=$hlavicka->osts24; if ( $hlavicka->osts24 == 0 ) $osts24="";
$osts25=$hlavicka->osts25; if ( $hlavicka->osts25 == 0 ) $osts25="";
$osts26=$hlavicka->osts26; if ( $hlavicka->osts26 == 0 ) $osts26="";
$osts27=$hlavicka->osts27; if ( $hlavicka->osts27 == 0 ) $osts27="";
$osts28=$hlavicka->osts28; if ( $hlavicka->osts28 == 0 ) $osts28="";


$zoss01=$hlavicka->zoss01; if ( $hlavicka->zoss01 == 0 ) $zoss01="";
$zoss02=$hlavicka->zoss02; if ( $hlavicka->zoss02 == 0 ) $zoss02="";
$zoss03=$hlavicka->zoss03; if ( $hlavicka->zoss03 == 0 ) $zoss03="";
$zoss04=$hlavicka->zoss04; if ( $hlavicka->zoss04 == 0 ) $zoss04="";
$zoss05=$hlavicka->zoss05; if ( $hlavicka->zoss05 == 0 ) $zoss05="";
$zoss06=$hlavicka->zoss06; if ( $hlavicka->zoss06 == 0 ) $zoss06="";
$zoss07=$hlavicka->zoss07; if ( $hlavicka->zoss07 == 0 ) $zoss07="";
$zoss08=$hlavicka->zoss08; if ( $hlavicka->zoss08 == 0 ) $zoss08="";
$zoss09=$hlavicka->zoss09; if ( $hlavicka->zoss09 == 0 ) $zoss09="";
$zoss10=$hlavicka->zoss10; if ( $hlavicka->zoss10 == 0 ) $zoss10="";
$zoss11=$hlavicka->zoss11; if ( $hlavicka->zoss11 == 0 ) $zoss11="";
$zoss12=$hlavicka->zoss12; if ( $hlavicka->zoss12 == 0 ) $zoss12="";
$zoss13=$hlavicka->zoss13; if ( $hlavicka->zoss13 == 0 ) $zoss13="";
$zoss14=$hlavicka->zoss14; if ( $hlavicka->zoss14 == 0 ) $zoss14="";
$zoss15=$hlavicka->zoss15; if ( $hlavicka->zoss15 == 0 ) $zoss15="";
$zoss16=$hlavicka->zoss16; if ( $hlavicka->zoss16 == 0 ) $zoss16="";
$zoss17=$hlavicka->zoss17; if ( $hlavicka->zoss17 == 0 ) $zoss17="";
$zoss18=$hlavicka->zoss18; if ( $hlavicka->zoss18 == 0 ) $zoss18="";
$zoss19=$hlavicka->zoss19; if ( $hlavicka->zoss19 == 0 ) $zoss19="";
$zoss20=$hlavicka->zoss20; if ( $hlavicka->zoss20 == 0 ) $zoss20="";
$zoss21=$hlavicka->zoss21; if ( $hlavicka->zoss21 == 0 ) $zoss21="";
$zoss22=$hlavicka->zoss22; if ( $hlavicka->zoss22 == 0 ) $zoss22="";
$zoss23=$hlavicka->zoss23; if ( $hlavicka->zoss23 == 0 ) $zoss23="";
$zoss24=$hlavicka->zoss24; if ( $hlavicka->zoss24 == 0 ) $zoss24="";
$zoss25=$hlavicka->zoss25; if ( $hlavicka->zoss25 == 0 ) $zoss25="";
$zoss26=$hlavicka->zoss26; if ( $hlavicka->zoss26 == 0 ) $zoss26="";
$zoss27=$hlavicka->zoss27; if ( $hlavicka->zoss27 == 0 ) $zoss27="";
$zoss28=$hlavicka->zoss28; if ( $hlavicka->zoss28 == 0 ) $zoss28="";


$pdf->SetY(48);
$pdf->Cell(72,3," ","$rmc1",0,"R");
$pdf->Cell(18,7,"$pocs01","$rmc",0,"R");$pdf->Cell(14,7,"$pocs02","$rmc",0,"R");
$pdf->Cell(17,7,"$pocs03","$rmc",0,"R");$pdf->Cell(14,7,"$pocs04","$rmc",0,"R");
$pdf->Cell(18,7,"$pocs05","$rmc",0,"R");$pdf->Cell(14,7,"$pocs06","$rmc",0,"R");
$pdf->Cell(18,7,"$pocs07","$rmc",0,"R");$pdf->Cell(14,7,"$pocs08","$rmc",0,"R");
$pdf->Cell(18,7,"$pocs09","$rmc",0,"R");$pdf->Cell(14,7,"$pocs10","$rmc",0,"R");
$pdf->Cell(17,7,"$pocs11","$rmc",0,"R");$pdf->Cell(14,7,"$pocs12","$rmc",0,"R");
$pdf->Cell(18,7,"$pocs13","$rmc",0,"R");$pdf->Cell(14,7,"$pocs14","$rmc",1,"R");


$pdf->SetY(62);
$pdf->Cell(72,3," ","$rmc1",0,"R");
$pdf->Cell(18,7,"$zvys01","$rmc",0,"R");$pdf->Cell(14,7,"$zvys02","$rmc",0,"R");
$pdf->Cell(17,7,"$zvys03","$rmc",0,"R");$pdf->Cell(14,7,"$zvys04","$rmc",0,"R");
$pdf->Cell(18,7,"$zvys05","$rmc",0,"R");$pdf->Cell(14,7,"$zvys06","$rmc",0,"R");
$pdf->Cell(18,7,"$zvys07","$rmc",0,"R");$pdf->Cell(14,7,"$zvys08","$rmc",0,"R");
$pdf->Cell(18,7,"$zvys09","$rmc",0,"R");$pdf->Cell(14,7,"$zvys10","$rmc",0,"R");
$pdf->Cell(17,7,"$zvys11","$rmc",0,"R");$pdf->Cell(14,7,"$zvys12","$rmc",0,"R");
$pdf->Cell(18,7,"$zvys13","$rmc",0,"R");$pdf->Cell(14,7,"$zvys14","$rmc",1,"R");


$pdf->SetY(69);
$pdf->Cell(72,3," ","$rmc1",0,"R");
$pdf->Cell(18,7,"$znis01","$rmc",0,"R");$pdf->Cell(14,7,"$znis02","$rmc",0,"R");
$pdf->Cell(17,7,"$znis03","$rmc",0,"R");$pdf->Cell(14,7,"$znis04","$rmc",0,"R");
$pdf->Cell(18,7,"$znis05","$rmc",0,"R");$pdf->Cell(14,7,"$znis06","$rmc",0,"R");
$pdf->Cell(18,7,"$znis07","$rmc",0,"R");$pdf->Cell(14,7,"$znis08","$rmc",0,"R");
$pdf->Cell(18,7,"$znis09","$rmc",0,"R");$pdf->Cell(14,7,"$znis10","$rmc",0,"R");
$pdf->Cell(17,7,"$znis11","$rmc",0,"R");$pdf->Cell(14,7,"$znis12","$rmc",0,"R");
$pdf->Cell(18,7,"$znis13","$rmc",0,"R");$pdf->Cell(14,7,"$znis14","$rmc",1,"R");


$pdf->SetY(76);
$pdf->Cell(72,3," ","$rmc1",0,"R");
$pdf->Cell(18,7,"$oces01","$rmc",0,"R");$pdf->Cell(14,7,"$oces02","$rmc",0,"R");
$pdf->Cell(17,7,"$oces03","$rmc",0,"R");$pdf->Cell(14,7,"$oces04","$rmc",0,"R");
$pdf->Cell(18,7,"$oces05","$rmc",0,"R");$pdf->Cell(14,7,"$oces06","$rmc",0,"R");
$pdf->Cell(18,7,"$oces07","$rmc",0,"R");$pdf->Cell(14,7,"$oces08","$rmc",0,"R");
$pdf->Cell(18,7,"$oces09","$rmc",0,"R");$pdf->Cell(14,7,"$oces10","$rmc",0,"R");
$pdf->Cell(17,7,"$oces11","$rmc",0,"R");$pdf->Cell(14,7,"$oces12","$rmc",0,"R");
$pdf->Cell(18,7,"$oces13","$rmc",0,"R");$pdf->Cell(14,7,"$oces14","$rmc",1,"R");


$pdf->SetY(83);
$pdf->Cell(72,3," ","$rmc1",0,"R");
$pdf->Cell(18,7,"$osts01","$rmc",0,"R");$pdf->Cell(14,7,"$osts02","$rmc",0,"R");
$pdf->Cell(17,7,"$osts03","$rmc",0,"R");$pdf->Cell(14,7,"$osts04","$rmc",0,"R");
$pdf->Cell(18,7,"$osts05","$rmc",0,"R");$pdf->Cell(14,7,"$osts06","$rmc",0,"R");
$pdf->Cell(18,7,"$osts07","$rmc",0,"R");$pdf->Cell(14,7,"$osts08","$rmc",0,"R");
$pdf->Cell(18,7,"$osts09","$rmc",0,"R");$pdf->Cell(14,7,"$osts10","$rmc",0,"R");
$pdf->Cell(17,7,"$osts11","$rmc",0,"R");$pdf->Cell(14,7,"$osts12","$rmc",0,"R");
$pdf->Cell(18,7,"$osts13","$rmc",0,"R");$pdf->Cell(14,7,"$osts14","$rmc",1,"R");


$pdf->SetY(90);
$pdf->Cell(72,3," ","$rmc1",0,"R");
$pdf->Cell(18,7,"$zoss01","$rmc",0,"R");$pdf->Cell(14,7,"$zoss02","$rmc",0,"R");
$pdf->Cell(17,7,"$zoss03","$rmc",0,"R");$pdf->Cell(14,7,"$zoss04","$rmc",0,"R");
$pdf->Cell(18,7,"$zoss05","$rmc",0,"R");$pdf->Cell(14,7,"$zoss06","$rmc",0,"R");
$pdf->Cell(18,7,"$zoss07","$rmc",0,"R");$pdf->Cell(14,7,"$zoss08","$rmc",0,"R");
$pdf->Cell(18,7,"$zoss09","$rmc",0,"R");$pdf->Cell(14,7,"$zoss10","$rmc",0,"R");
$pdf->Cell(17,7,"$zoss11","$rmc",0,"R");$pdf->Cell(14,7,"$zoss12","$rmc",0,"R");
$pdf->Cell(18,7,"$zoss13","$rmc",0,"R");$pdf->Cell(14,7,"$zoss14","$rmc",1,"R");


$pdf->SetY(139);
$pdf->Cell(72,3," ","$rmc1",0,"R");
$pdf->Cell(18,7,"$pocs15","$rmc",0,"R");$pdf->Cell(14,7,"$pocs16","$rmc",0,"R");
$pdf->Cell(17,7,"$pocs17","$rmc",0,"R");$pdf->Cell(14,7,"$pocs18","$rmc",0,"R");
$pdf->Cell(18,7,"$pocs19","$rmc",0,"R");$pdf->Cell(14,7,"$pocs20","$rmc",0,"R");
$pdf->Cell(18,7,"$pocs21","$rmc",0,"R");$pdf->Cell(14,7,"$pocs22","$rmc",0,"R");
$pdf->Cell(18,7,"$pocs23","$rmc",0,"R");$pdf->Cell(14,7,"$pocs24","$rmc",0,"R");
$pdf->Cell(17,7,"$pocs25","$rmc",0,"R");$pdf->Cell(14,7,"$pocs26","$rmc",0,"R");
$pdf->Cell(18,7,"$pocs27","$rmc",0,"R");$pdf->Cell(14,7,"$pocs28","$rmc",1,"R");


$pdf->SetY(153);
$pdf->Cell(72,3," ","$rmc1",0,"R");
$pdf->Cell(18,7,"$zvys15","$rmc",0,"R");$pdf->Cell(14,7,"$zvys16","$rmc",0,"R");
$pdf->Cell(17,7,"$zvys17","$rmc",0,"R");$pdf->Cell(14,7,"$zvys18","$rmc",0,"R");
$pdf->Cell(18,7,"$zvys19","$rmc",0,"R");$pdf->Cell(14,7,"$zvys20","$rmc",0,"R");
$pdf->Cell(18,7,"$zvys21","$rmc",0,"R");$pdf->Cell(14,7,"$zvys22","$rmc",0,"R");
$pdf->Cell(18,7,"$zvys23","$rmc",0,"R");$pdf->Cell(14,7,"$zvys24","$rmc",0,"R");
$pdf->Cell(17,7,"$zvys25","$rmc",0,"R");$pdf->Cell(14,7,"$zvys26","$rmc",0,"R");
$pdf->Cell(18,7,"$zvys27","$rmc",0,"R");$pdf->Cell(14,7,"$zvys28","$rmc",1,"R");


$pdf->SetY(160);
$pdf->Cell(72,3," ","$rmc1",0,"R");
$pdf->Cell(18,7,"$znis15","$rmc",0,"R");$pdf->Cell(14,7,"$znis16","$rmc",0,"R");
$pdf->Cell(17,7,"$znis17","$rmc",0,"R");$pdf->Cell(14,7,"$znis18","$rmc",0,"R");
$pdf->Cell(18,7,"$znis19","$rmc",0,"R");$pdf->Cell(14,7,"$znis20","$rmc",0,"R");
$pdf->Cell(18,7,"$znis21","$rmc",0,"R");$pdf->Cell(14,7,"$znis22","$rmc",0,"R");
$pdf->Cell(18,7,"$znis23","$rmc",0,"R");$pdf->Cell(14,7,"$znis24","$rmc",0,"R");
$pdf->Cell(17,7,"$znis25","$rmc",0,"R");$pdf->Cell(14,7,"$znis26","$rmc",0,"R");
$pdf->Cell(18,7,"$znis27","$rmc",0,"R");$pdf->Cell(14,7,"$znis28","$rmc",1,"R");


$pdf->SetY(167);
$pdf->Cell(72,3," ","$rmc1",0,"R");
$pdf->Cell(18,7,"$oces15","$rmc",0,"R");$pdf->Cell(14,7,"$oces16","$rmc",0,"R");
$pdf->Cell(17,7,"$oces17","$rmc",0,"R");$pdf->Cell(14,7,"$oces18","$rmc",0,"R");
$pdf->Cell(18,7,"$oces19","$rmc",0,"R");$pdf->Cell(14,7,"$oces20","$rmc",0,"R");
$pdf->Cell(18,7,"$oces21","$rmc",0,"R");$pdf->Cell(14,7,"$oces22","$rmc",0,"R");
$pdf->Cell(18,7,"$oces23","$rmc",0,"R");$pdf->Cell(14,7,"$oces24","$rmc",0,"R");
$pdf->Cell(17,7,"$oces25","$rmc",0,"R");$pdf->Cell(14,7,"$oces26","$rmc",0,"R");
$pdf->Cell(18,7,"$oces27","$rmc",0,"R");$pdf->Cell(14,7,"$oces28","$rmc",1,"R");


$pdf->SetY(174);
$pdf->Cell(72,3," ","$rmc1",0,"R");
$pdf->Cell(18,7,"$osts15","$rmc",0,"R");$pdf->Cell(14,7,"$osts16","$rmc",0,"R");
$pdf->Cell(17,7,"$osts17","$rmc",0,"R");$pdf->Cell(14,7,"$osts18","$rmc",0,"R");
$pdf->Cell(18,7,"$osts19","$rmc",0,"R");$pdf->Cell(14,7,"$osts20","$rmc",0,"R");
$pdf->Cell(18,7,"$osts21","$rmc",0,"R");$pdf->Cell(14,7,"$osts22","$rmc",0,"R");
$pdf->Cell(18,7,"$osts23","$rmc",0,"R");$pdf->Cell(14,7,"$osts24","$rmc",0,"R");
$pdf->Cell(17,7,"$osts25","$rmc",0,"R");$pdf->Cell(14,7,"$osts26","$rmc",0,"R");
$pdf->Cell(18,7,"$osts27","$rmc",0,"R");$pdf->Cell(14,7,"$osts28","$rmc",1,"R");


$pdf->SetY(181);
$pdf->Cell(72,3," ","$rmc1",0,"R");
$pdf->Cell(18,7,"$zoss15","$rmc",0,"R");$pdf->Cell(14,7,"$zoss16","$rmc",0,"R");
$pdf->Cell(17,7,"$zoss17","$rmc",0,"R");$pdf->Cell(14,7,"$zoss18","$rmc",0,"R");
$pdf->Cell(18,7,"$zoss19","$rmc",0,"R");$pdf->Cell(14,7,"$zoss20","$rmc",0,"R");
$pdf->Cell(18,7,"$zoss21","$rmc",0,"R");$pdf->Cell(14,7,"$zoss22","$rmc",0,"R");
$pdf->Cell(18,7,"$zoss23","$rmc",0,"R");$pdf->Cell(14,7,"$zoss24","$rmc",0,"R");
$pdf->Cell(17,7,"$zoss25","$rmc",0,"R");$pdf->Cell(14,7,"$zoss26","$rmc",0,"R");
$pdf->Cell(18,7,"$zoss27","$rmc",0,"R");$pdf->Cell(14,7,"$zoss28","$rmc",1,"R");



                                          }
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