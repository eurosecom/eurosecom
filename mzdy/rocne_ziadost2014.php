<!doctype html>
<HTML>
<?php
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
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_oc = $_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=1;
//echo $cislo_oc;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//$zablokovane=1;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("éiadosù bude pripraven· v priebehu janu·ra 2015. Aktu·lne info n·jdete na vstupnej str·nke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

//priezvisko,meno,titul FO
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";

$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
if ( $fir_uctt03 == 999 )
{
$fnazov = $fir_riadok->dmeno." ".$fir_riadok->dprie." ".$fir_riadok->dtitl;
$dadresa = $fir_riadok->duli." "." ".$fir_riadok->dcdm." ".$fir_riadok->dmes;
}
if( $fir_uctt03 != 999 )
{
$fadresa = $fir_fuli." ".$fir_fcdm." ".$fir_fmes;
$fnazov = $fir_fnaz;
}

// znovu nacitaj
if ( $copern == 26 )
     {
$sqtoz = "DELETE FROM F$kli_vxcf"."_rocneziadost WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");
$copern=20;
$subor=1;
     }
//koniec znovu nacitaj

//zapis upravene udaje
if ( $copern == 23 )
     {
//$ztitl = strip_tags($_REQUEST['ztitl']);
$uplman = 1*$_REQUEST['uplman'];
$manprie = strip_tags($_REQUEST['manprie']);
$manmeno = strip_tags($_REQUEST['manmeno']);
$manrodne = strip_tags($_REQUEST['manrodne']);
$manuli = strip_tags($_REQUEST['manuli']);
$mancdm = strip_tags($_REQUEST['mancdm']);
$manpsc = strip_tags($_REQUEST['manpsc']);
$manmes = strip_tags($_REQUEST['manmes']);
$manstat = strip_tags($_REQUEST['manstat']);
$manpes = strip_tags($_REQUEST['manpes']);
$manzam = strip_tags($_REQUEST['manzam']);
$maneur = 1*$_REQUEST['maneur'];
$prisknczd = 1*$_REQUEST['prisknczd'];
$upldoc = 1*$_REQUEST['upldoc'];
$docx = 1*$_REQUEST['docx'];
$doceur = 1*$_REQUEST['doceur'];
$uplsds = 1*$_REQUEST['uplsds'];
$sdseur = 1*$_REQUEST['sdseur'];
$upldds = 1*$_REQUEST['upldds'];
$ddseur = 1*$_REQUEST['ddseur'];
$uprav="NO";

if ( $strana == 1 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_rocneziadost SET ".
" uplman='$uplman', manprie='$manprie', manmeno='$manmeno', manrodne='$manrodne', manuli='$manuli', ".
" mancdm='$mancdm', manpsc='$manpsc', manmes='$manmes', manstat='$manstat', manpes='$manpes', manzam='$manzam', maneur='$maneur', ".
" prisknczd='$prisknczd', upldoc='$upldoc', docx='$docx', doceur='$doceur', uplsds='$uplsds', sdseur='$sdseur', upldds='$upldds', ddseur='$ddseur' ".
" WHERE oc = $cislo_oc";
                    }

$bonus = 1*$_REQUEST['bonus'];
$det01 = strip_tags($_REQUEST['det01']);
$rod01 = strip_tags($_REQUEST['rod01']);
$mes01 = strip_tags($_REQUEST['mes01']);
$det02 = strip_tags($_REQUEST['det02']);
$rod02 = strip_tags($_REQUEST['rod02']);
$mes02 = strip_tags($_REQUEST['mes02']);
$det03 = strip_tags($_REQUEST['det03']);
$rod03 = strip_tags($_REQUEST['rod03']);
$mes03 = strip_tags($_REQUEST['mes03']);
$det04 = strip_tags($_REQUEST['det04']);
$rod04 = strip_tags($_REQUEST['rod04']);
$mes04 = strip_tags($_REQUEST['mes04']);
$det05 = strip_tags($_REQUEST['det05']);
$rod05 = strip_tags($_REQUEST['rod05']);
$mes05 = strip_tags($_REQUEST['mes05']);
$det06 = strip_tags($_REQUEST['det06']);
$rod06 = strip_tags($_REQUEST['rod06']);
$mes06 = strip_tags($_REQUEST['mes06']);
$det07 = strip_tags($_REQUEST['det07']);
$rod07 = strip_tags($_REQUEST['rod07']);
$mes07 = strip_tags($_REQUEST['mes07']);
$det08 = strip_tags($_REQUEST['det08']);
$rod08 = strip_tags($_REQUEST['rod08']);
$mes08 = strip_tags($_REQUEST['mes08']);
$det09 = strip_tags($_REQUEST['det09']);
$rod09 = strip_tags($_REQUEST['rod09']);
$mes09 = strip_tags($_REQUEST['mes09']);
$det10 = strip_tags($_REQUEST['det10']);
$rod10 = strip_tags($_REQUEST['rod10']);
$mes10 = strip_tags($_REQUEST['mes10']);
$priskbonus = 1*$_REQUEST['priskbonus'];
$uplpoist = 1*$_REQUEST['uplpoist'];
$zappoistne = 1*$_REQUEST['zappoistne'];
$ziad5 = 1*$_REQUEST['ziad5'];
$ziad3 = 1*$_REQUEST['ziad3'];
$ziad3eur = strip_tags($_REQUEST['ziad3eur']);
$ziad9 = 1*$_REQUEST['ziad9'];
$ineuda = strip_tags($_REQUEST['ineuda']);
$datum = strip_tags($_REQUEST['datum']);
$datum_sql=SqlDatum($datum);
$uprav="NO";

if ( $strana == 2 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_rocneziadost SET ".
" bonus='$bonus', priskbonus='$priskbonus', ziad9='$ziad9', ineuda='$ineuda', datum='$datum_sql', ".
" det01='$det01', rod01='$rod01', mes01='$mes01', det02='$det02', rod02='$rod02', mes02='$mes02', det03='$det03', rod03='$rod03', mes03='$mes03', ".
" det04='$det04', rod04='$rod04', mes04='$mes04', det05='$det05', rod05='$rod05', mes05='$mes05', det06='$det06', rod06='$rod06', mes06='$mes06', ".
" det07='$det07', rod07='$rod07', mes07='$mes07', det08='$det08', rod08='$rod08', mes08='$mes08', det09='$det09', rod09='$rod09', mes09='$mes09', ".
" det10='$det10', rod10='$rod10', mes10='$mes10', uplpoist='$uplpoist', zappoistne='$zappoistne', ziad5='$ziad5', ziad3='$ziad3', ziad3eur='$ziad3eur' ".
" WHERE oc = $cislo_oc";
                    }
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");  

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

//vytvor ak nie je
$sql = "SELECT konx FROM F$kli_vxcf"."_rocneziadost ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//prac.subor a subor vytvorenych potvrdeni
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_rocneziadost';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   ume          DECIMAL(7,4) DEFAULT 0,
   oc           INT(7) DEFAULT 0,
   rdstav       INT(1) DEFAULT 0,
   pracov       VARCHAR(80),
   manzel       VARCHAR(80),
   mannar       DATE,
   manadr       VARCHAR(80),
   manpsc       VARCHAR(6),
   manzam       VARCHAR(80),
   ineuda       VARCHAR(80),
   nezd         INT(1) DEFAULT 0,
   bonus        INT(1) DEFAULT 0,
   m1det01      VARCHAR(80),
   m1nar01      DATE,
   m1det02      VARCHAR(80),
   m1nar02      DATE,
   m1det03      VARCHAR(80),
   m1nar03      DATE,
   m1det04      VARCHAR(80),
   m1nar04      DATE,
   m1det05      VARCHAR(80),
   m1nar05      DATE,
   m2det01      VARCHAR(80),
   m2nar01      DATE,
   m2det02      VARCHAR(80),
   m2nar02      DATE,
   m2det03      VARCHAR(80),
   m2nar03      DATE,
   m2det04      VARCHAR(80),
   m2nar04      DATE,
   m2det05      VARCHAR(80),
   m2nar05      DATE,
   m3det01      VARCHAR(80),
   m3nar01      DATE,
   m3det02      VARCHAR(80),
   m3nar02      DATE,
   m3det03      VARCHAR(80),
   m3nar03      DATE,
   m3det04      VARCHAR(80),
   m3nar04      DATE,
   m3det05      VARCHAR(80),
   m3nar05      DATE,
   docx         INT(1) DEFAULT 0,
   ostat        VARCHAR(80),
   datum        DATE,
   pozn         VARCHAR(80),
   str2         TEXT,
   konx         INT(4) DEFAULT 0
);
mzdprc;
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_rocneziadost'.$sqlt;
$vytvor = mysql_query("$vsql");
}
$sql = "SELECT vpmanzel FROM F$kli_vxcf"."_rocneziadost ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD ziad9 DECIMAL(4,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD ziv3eur DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD ziv2eur DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD ziv1eur DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD doceur DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD docobd VARCHAR(20) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD maneur DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD manpes VARCHAR(20) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD manobd VARCHAR(20) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD vzdeleur DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD ziad6beur DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD ziad6b DECIMAL(4,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD ziad6eur DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD ziad6 DECIMAL(4,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD ziad5 DECIMAL(4,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD prisk DECIMAL(4,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD ziad3eur DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD ziad3 DECIMAL(4,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD manrodne VARCHAR(11) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD zappoistne DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m1rod01 VARCHAR(11) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m1rod02 VARCHAR(11) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m1rod03 VARCHAR(11) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m1rod04 VARCHAR(11) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m1rod05 VARCHAR(11) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m1det06 VARCHAR(80) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m1rod06 VARCHAR(11) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m2det06 VARCHAR(80) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m1det07 VARCHAR(80) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m1rod07 VARCHAR(11) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m2det07 VARCHAR(80) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m1det08 VARCHAR(80) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m1rod08 VARCHAR(11) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m2det08 VARCHAR(80) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m1det09 VARCHAR(80) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m1rod09 VARCHAR(11) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m2det09 VARCHAR(80) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m1det10 VARCHAR(80) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m1rod10 VARCHAR(11) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD m2det10 VARCHAR(80) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD vpmanzel DECIMAL(4,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//koniec vytvor ak nie je

//zmeny pre rok 2013
$sql = "SELECT priskbonus FROM F$kli_vxcf"."_rocneziadost ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD new2013 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD ztitl VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD stat VARCHAR(30) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD uplman DECIMAL(2,0) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD manprie VARCHAR(30) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD manmeno VARCHAR(30) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD manuli VARCHAR(80) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD mancdm VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD manmes VARCHAR(30) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD manstat VARCHAR(30) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD prisknczd DECIMAL(2,0) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD upldoc DECIMAL(2,0) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD uplsds DECIMAL(2,0) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD sdseur DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD bonus DECIMAL(2,0) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD det01 VARCHAR(80) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD rod01 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD mes01 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD det02 VARCHAR(80) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD rod02 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD mes02 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD det03 VARCHAR(80) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD rod03 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD mes03 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD det04 VARCHAR(80) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD rod04 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD mes04 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD det05 VARCHAR(80) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD rod05 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD mes05 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD det06 VARCHAR(80) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD rod06 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD mes06 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD det07 VARCHAR(80) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD rod07 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD mes07 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD det08 VARCHAR(80) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD rod08 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD mes08 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD det09 VARCHAR(80) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD rod09 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD mes09 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD det10 VARCHAR(80) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD rod10 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD mes10 VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD uplpoist DECIMAL(2,0) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD priskbonus DECIMAL(2,0) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
}
//zmeny pre rok 2014
$sql = "SELECT ddseur FROM F$kli_vxcf"."_rocneziadost ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD new2014 DECIMAL(2,0) DEFAULT 0 AFTER ziad9";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD upldds DECIMAL(2,0) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_rocneziadost ADD ddseur DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
}
//koniec zmeny2014

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = "CREATE TABLE F$kli_vxcf"."_mzdprcvypl$kli_uzid SELECT * FROM F$kli_vxcf"."_rocneziadost WHERE oc < 0 ";
$vysledok = mysql_query("$sqlt");
$sqlt = "CREATE TABLE F$kli_vxcf"."_mzdprcvyplx$kli_uzid SELECT * FROM F$kli_vxcf"."_rocneziadost WHERE oc < 0 ";
$vysledok = mysql_query("$sqlt");
$sqlt = "CREATE TABLE F$kli_vxcf"."_mzdprcvyplz$kli_uzid SELECT * FROM F$kli_vxcf"."_rocneziadost WHERE oc < 0 ";
$vysledok = mysql_query("$sqlt");

$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_rocneziadost WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $jepotvrd=1;
  }
if ( $jepotvrd == 0 ) $subor=1;

//pre potvrdenie vytvor pracovny subor
if ( $subor == 1 )
{
$pracovx=$fir_fuli." ".$fir_fcdm.", ".$fir_fmes.", ".$fir_fpsc;

$dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 

$sqtoz = "DELETE FROM F$kli_vxcf"."_rocneziadost WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");
$sqtoz = "INSERT INTO F$kli_vxcf"."_rocneziadost ( oc ) VALUES ( $cislo_oc )";
$oznac = mysql_query("$sqtoz");
}
//koniec pracovneho suboru pre potvrdenie 
?>


<?php
//nacitaj udaje pre upravu
if ( $copern == 20 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_rocneziadost".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_rocneziadost.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_rocneziadost.oc = $cislo_oc ORDER BY konx,prie,meno";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$oc = $fir_riadok->oc;
$meno = $fir_riadok->meno;
$prie = $fir_riadok->prie;
$rodne = $fir_riadok->rdc."/".$fir_riadok->rdk;
$dar=SkDatum($fir_riadok->dar);
if ( $rodne == "0/" ) { $rodne="$dar"; }
$ptitl = $fir_riadok->titl;
$uli = $fir_riadok->zuli;
$cdm = $fir_riadok->zcdm;
$psc = $fir_riadok->zpsc;
$mes = $fir_riadok->zmes;
$zamestnavatel = $fir_fnaz.", ".$fir_fuli." ".$fir_fcdm.", ".$fir_fmes;
$uplman = $fir_riadok->uplman;
$manprie = $fir_riadok->manprie;
$manmeno = $fir_riadok->manmeno;
$manrodne = $fir_riadok->manrodne;
$manuli = $fir_riadok->manuli;
$mancdm = $fir_riadok->mancdm;
$manpsc = $fir_riadok->manpsc;
$manmes = $fir_riadok->manmes;
$manstat = $fir_riadok->manstat;
$manpes = $fir_riadok->manpes;
$manzam = $fir_riadok->manzam;
$maneur = $fir_riadok->maneur;
$prisknczd = $fir_riadok->prisknczd;
$upldoc = $fir_riadok->upldoc;
$docx = $fir_riadok->docx;
$doceur = $fir_riadok->doceur;
$uplsds = $fir_riadok->uplsds;
$sdseur = $fir_riadok->sdseur;
$upldds = $fir_riadok->upldds;
$ddseur = $fir_riadok->ddseur;

if ( $strana == 2 ) {
$bonus = $fir_riadok->bonus;
$det01 = $fir_riadok->det01;
$rod01 = $fir_riadok->rod01;
$mes01 = $fir_riadok->mes01;
$det02 = $fir_riadok->det02;
$rod02 = $fir_riadok->rod02;
$mes02 = $fir_riadok->mes02;
$det03 = $fir_riadok->det03;
$rod03 = $fir_riadok->rod03;
$mes03 = $fir_riadok->mes03;
$det04 = $fir_riadok->det04;
$rod04 = $fir_riadok->rod04;
$mes04 = $fir_riadok->mes04;
$det05 = $fir_riadok->det05;
$rod05 = $fir_riadok->rod05;
$mes05 = $fir_riadok->mes05;
$det06 = $fir_riadok->det06;
$rod06 = $fir_riadok->rod06;
$mes06 = $fir_riadok->mes06;
$det07 = $fir_riadok->det07;
$rod07 = $fir_riadok->rod07;
$mes07 = $fir_riadok->mes07;
$det08 = $fir_riadok->det08;
$rod08 = $fir_riadok->rod08;
$mes08 = $fir_riadok->mes08;
$det09 = $fir_riadok->det09;
$rod09 = $fir_riadok->rod09;
$mes09 = $fir_riadok->mes09;
$det10 = $fir_riadok->det10;
$rod10 = $fir_riadok->rod10;
$mes10 = $fir_riadok->mes10;
$priskbonus = $fir_riadok->priskbonus;
$uplpoist = $fir_riadok->uplpoist;
$zappoistne = $fir_riadok->zappoistne;
$ziad5 = $fir_riadok->ziad5;
$ziad3 = $fir_riadok->ziad3;
$ziad3eur = $fir_riadok->ziad3eur;
$ziad9 = $fir_riadok->ziad9;
$ineuda = $fir_riadok->ineuda;
$datum = $fir_riadok->datum;
$datum_sk=SkDatum($datum);
                    }
mysql_free_result($fir_vysledok);
     }
//koniec nacitania

//titulza z udajov o zamestn.
$ztitz=" ";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $cislo_oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ztitz=$riaddok->ztitz;
  }

//stat z udajov o zamestn.
$zstat="Slovensko"; $zstak="703";
$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_mzdtextmzd WHERE invt = $cislo_oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zstat=$riaddok->zstat;
  }
if ( $zstat == '' ) { $zstat="Slovensko"; }

//osobne cislo prepinanie
$novy=0;
if ( $novy == 0 )
{
$prev_oc=$cislo_oc-1;
$next_oc=$cislo_oc+1;
if ( $prev_oc == 0 ) $prev_oc=1;
if ( $next_oc > 9999 ) $next_oc=9999;

$nasieloc=0;
$i=0;
while ( $i <= 9999 AND $nasieloc == 0 )
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
while ( $i <= 9999 AND $nasieloc == 0 AND $next_oc <= $maxoc )
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
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - éiadosù o RZ</title>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height-20;
var sirkawic = screen.width-10;

<?php
//uprava sadzby
  if ( $copern == 20 )
  { 
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<?php if ( $uplman == 1 ) { ?> document.formv1.uplman.checked = "checked"; <?php } ?>
   document.formv1.manprie.value = '<?php echo "$manprie";?>';
   document.formv1.manmeno.value = '<?php echo "$manmeno";?>';
   document.formv1.manrodne.value = '<?php echo "$manrodne";?>';
   document.formv1.manuli.value = '<?php echo "$manuli";?>';
   document.formv1.mancdm.value = '<?php echo "$mancdm";?>';
   document.formv1.manpsc.value = '<?php echo "$manpsc";?>';
   document.formv1.manmes.value = '<?php echo "$manmes";?>';
   document.formv1.manstat.value = '<?php echo "$manstat";?>';
   document.formv1.manpes.value = '<?php echo "$manpes";?>';
   document.formv1.manzam.value = '<?php echo "$manzam";?>';
   document.formv1.maneur.value = '<?php echo "$maneur";?>';
<?php if ( $prisknczd == 1 ) { ?> document.formv1.prisknczd.checked = "checked"; <?php } ?>
<?php if ( $upldoc == 1 ) { ?> document.formv1.upldoc.checked = "checked"; <?php } ?>
<?php if ( $docx == 1 ) { ?> document.formv1.docx.checked = "checked"; <?php } ?>
   document.formv1.doceur.value = '<?php echo "$doceur";?>';
<?php if ( $uplsds == 1 ) { ?> document.formv1.uplsds.checked = "checked"; <?php } ?>
   document.formv1.sdseur.value = '<?php echo "$sdseur";?>';
<?php if ( $upldds == 1 ) { ?> document.formv1.upldds.checked = "checked"; <?php } ?>
   document.formv1.ddseur.value = '<?php echo "$ddseur";?>';
<?php                                        } ?>

<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<?php if ( $bonus == 1 ) { ?> document.formv1.bonus.checked = "checked"; <?php } ?>
   document.formv1.det01.value = '<?php echo "$det01";?>';
   document.formv1.rod01.value = '<?php echo "$rod01";?>';
   document.formv1.mes01.value = '<?php echo "$mes01";?>';
   document.formv1.det02.value = '<?php echo "$det02";?>';
   document.formv1.rod02.value = '<?php echo "$rod02";?>';
   document.formv1.mes02.value = '<?php echo "$mes02";?>';
   document.formv1.det03.value = '<?php echo "$det03";?>';
   document.formv1.rod03.value = '<?php echo "$rod03";?>';
   document.formv1.mes03.value = '<?php echo "$mes03";?>';
   document.formv1.det04.value = '<?php echo "$det04";?>';
   document.formv1.rod04.value = '<?php echo "$rod04";?>';
   document.formv1.mes04.value = '<?php echo "$mes04";?>';
   document.formv1.det05.value = '<?php echo "$det05";?>';
   document.formv1.rod05.value = '<?php echo "$rod05";?>';
   document.formv1.mes05.value = '<?php echo "$mes05";?>';
   document.formv1.det06.value = '<?php echo "$det06";?>';
   document.formv1.rod06.value = '<?php echo "$rod06";?>';
   document.formv1.mes06.value = '<?php echo "$mes06";?>';
   document.formv1.det07.value = '<?php echo "$det07";?>';
   document.formv1.rod07.value = '<?php echo "$rod07";?>';
   document.formv1.mes07.value = '<?php echo "$mes07";?>';
   document.formv1.det08.value = '<?php echo "$det08";?>';
   document.formv1.rod08.value = '<?php echo "$rod08";?>';
   document.formv1.mes08.value = '<?php echo "$mes08";?>';
   document.formv1.det09.value = '<?php echo "$det09";?>';
   document.formv1.rod09.value = '<?php echo "$rod09";?>';
   document.formv1.mes09.value = '<?php echo "$mes09";?>';
   document.formv1.det10.value = '<?php echo "$det10";?>';
   document.formv1.rod10.value = '<?php echo "$rod10";?>';
   document.formv1.mes10.value = '<?php echo "$mes10";?>';
<?php if ( $priskbonus == 1 ) { ?> document.formv1.priskbonus.checked = "checked"; <?php } ?>
<?php if ( $uplpoist == 1 ) { ?> document.formv1.uplpoist.checked = "checked"; <?php } ?>
   document.formv1.zappoistne.value = '<?php echo "$zappoistne";?>';
<?php if ( $ziad5 == 1 ) { ?> document.formv1.ziad5.checked = "checked"; <?php } ?>
<?php if ( $ziad3 == 1 ) { ?> document.formv1.ziad3.checked = "checked"; <?php } ?>
   document.formv1.ziad3eur.value = '<?php echo "$ziad3eur";?>';
<?php if ( $ziad9 == 1 ) { ?> document.formv1.ziad9.checked = "checked"; <?php } ?>
   document.formv1.ineuda.value = '<?php echo "$ineuda";?>';
   document.formv1.datum.value = '<?php echo "$datum_sk";?>';
<?php                                        } ?>
  }
<?php
//koniec uprava
  }
?>

<?php if ( $copern != 20 ) { ?>
  function ObnovUI()
  {
  }
<?php                      } ?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function prevOC()
  {
   window.open('rocne_ziadost2014.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $prev_oc;?>', '_self');
  }
  function nextOC()
  {
   window.open('rocne_ziadost2014.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $next_oc;?>', '_self');
  }
  function TlacZiadostRZ()
  {
   window.open('../mzdy/rocne_ziadost2014.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function reNacitajMzdy()
  {
   window.open('../mzdy/rocne_ziadost2014.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=0', '_self', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function UpravZamestnanca()
  {
   window.open('zamestnanci.php?sys=<?php echo $sys; ?>&copern=8&page=1&cislo_oc=<?php echo $cislo_oc;?>&h_oc=<?php echo $cislo_oc;?>', '_blank','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes');
  }
  function DetiZamestnanca()
  {
   window.open('../mzdy/deti.php?copern=1&drupoh=1&page=1&zkun=1&cislo_oc=<?php echo $cislo_oc;?>', '_blank','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes');
  }
  function TlacMzdovyList()
  {
   window.open('../mzdy/mzdevid.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1', '_blank','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes');
  }
  function PoucVyplnenie()
  {
   window.open('../dokumenty/dan_z_prijmov2013/dan_zo_zavislej2013/ziadost_o_rz/Ziadost_RZv2013_poucenie_na_vyplnenie.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
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
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">éiadosù o vykonanie RZ dane z prÌjmov - <span class="subheader"><?php echo "$oc $meno $prie ";?></span>
<?php if ( $novy == 0 ) { ?>
    <img src='../obr/prev.png' onclick="prevOC();" title="Os.Ë. <?php echo $prev_oc; ?>" class="navoc-icon">
    <img src='../obr/next.png' onclick="nextOC();" title="Os.Ë. <?php echo $next_oc; ?>" class="navoc-icon">
<?php                   } ?>
   </td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/info_blue_icon.png" onclick="PoucVyplnenie();" title="PouËenie na vyplnenie" class="btn-form-tool">
     <img src="../obr/ikony/reload_blue_icon.png" onclick="reNacitajMzdy();" title="Znovu naËÌtaù hodnoty z miezd" class="btn-form-tool">
     <img src="../obr/ikony/usertwo_blue_icon.png" onclick="DetiZamestnanca();" title="Deti zamestnanca" class="btn-form-tool">
     <img src="../obr/ikony/list_blue_icon.png" onclick="TlacMzdovyList();" title="Zobraziù mzdov˝ list v PDF" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacZiadostRZ();" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="rocne_ziadost2014.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana;?>">
<?php
$clas1="noactive"; $clas2="noactive"; if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
$source="../mzdy/rocne_ziadost2014.php?cislo_oc=".$cislo_oc."&drupoh=1&page=1&subor=0";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/rz_ziadost/rz_ziadost_v14-1.jpg" alt="tlaËivo éiadosù o RZ FO pre rok 2013 1.strana 282kB" class="form-background">
<input type="text" name="vrok" id="vrok" value="<?php echo $kli_vrok;?>" disabled="disabled" class="nofill center" style="width:135px; top:104px; left:710px; padding:0;"/>

<!-- I. ZAMESTNANEC -->
 <img src="../obr/ikony/pencil_blue_icon.png" onclick="UpravZamestnanca();" title="Upraviù ˙daje o zamestnancovi" class="btn-row-tool" style="top:180px; left:330px; width:18px; height:18px;">
<input type="text" name="prie" id="prie" value="<?php echo $prie; ?>" disabled="disabled" class="nofill" style="width:280px; top:231px; left:116px;"/>
<input type="text" name="meno" id="meno" value="<?php echo $meno; ?>" disabled="disabled" class="nofill" style="width:156px; top:231px; left:408px;"/>
<input type="text" name="rodne" id="rodne" value="<?php echo $rodne; ?>" disabled="disabled" class="nofill" style="width:100px; top:231px; left:576px;"/>
<input type="text" name="ptitl" id="ptitl" value="<?php echo $ptitl; ?>" disabled="disabled" class="nofill" style="width:96px; top:267px; left:230px;"/>
<input type="text" name="ztitz" id="ztitz" value="<?php echo $ztitz; ?>" disabled="disabled" class="nofill" style="width:106px; top:267px; left:630px;"/>
<input type="text" name="uli" id="uli" value="<?php echo $uli; ?>" disabled="disabled" class="nofill" style="width:328px; top:320px; left:158px;"/>
<input type="text" name="cdm" id="cdm" value="<?php echo $cdm; ?>" disabled="disabled" class="nofill" style="width:115px; top:320px; left:540px;"/>
<input type="text" name="psc" id="psc" value="<?php echo $psc; ?>" disabled="disabled" class="nofill" style="width:70px; top:320px; left:705px;"/>
<input type="text" name="mes" id="mes" value="<?php echo $mes; ?>" disabled="disabled" class="nofill" style="width:328px; top:356px; left:158px;"/>
<input type="text" name="zstat" id="zstat" value="<?php echo $zstat; ?>" disabled="disabled" class="nofill" style="width:220px; top:356px; left:535px;"/>
<input type="text" name="zamestnavatel" id="zamestnavatel" value="<?php echo $zamestnavatel; ?>" disabled="disabled" class="nofill" style="width:724px; top:408px; left:116px;"/>

<!-- 90% prijmov SR -->
<input type="checkbox" name="prisknczd" value="1" style="top:450px; left:790px;"/>

<!-- II. UPLATNENIE NCZD -->
<!-- 1. na manzel/ku -->
<input type="checkbox" name="uplman" value="1" style="top:494px; left:790px;"/>
<input type="text" name="manprie" id="manprie" style="width:334px; top:595px; left:116px;"/>
<input type="text" name="manmeno" id="manmeno" style="width:196px; top:595px; left:461px;"/>
<input type="text" name="manrodne" id="manrodne" style="width:100px; top:595px; left:668px;"/>
<input type="text" name="manuli" id="manuli" style="width:392px; top:630px; left:158px;"/>
<input type="text" name="mancdm" id="mancdm" style="width:94px; top:630px; left:605px;"/>
<input type="text" name="manpsc" id="manpsc" style="width:90px; top:630px; left:750px;"/>
<input type="text" name="manmes" id="manmes" style="width:392px; top:665px; left:158px;"/>
<input type="text" name="manstat" id="manstat" style="width:240px; top:665px; left:600px;"/>
<input type="text" name="manpes" id="manpes" style="width:45px; top:700px; left:795px;"/>
<input type="text" name="manzam" id="manzam" style="width:724px; top:752px; left:116px;"/>
<input type="text" name="maneur" id="maneur" onkeyup="CiarkaNaBodku(this);" style="width:150px; top:820px; left:559px;"/>

<!-- 2. na dochodok -->
<input type="checkbox" name="upldoc" value="1" style="top:971px; left:790px;"/>
<input type="checkbox" name="docx" value="1" style="top:1026px; left:790px;"/>
<input type="text" name="doceur" id="doceur" onkeyup="CiarkaNaBodku(this);" style="width:150px; top:1067px; left:559px;"/>
<!-- 3. na SDS -->
<input type="checkbox" name="uplsds" value="1" style="top:1149px; left:791px;"/>
<input type="text" name="sdseur" id="sdseur" onkeyup="CiarkaNaBodku(this);" style="width:150px; top:1212px; left:560px;"/>

<!-- 4. na DDS -->
<input type="checkbox" name="upldds" value="1" style="top:1240px; left:791px;"/>
<input type="text" name="ddseur" id="ddseur" onkeyup="CiarkaNaBodku(this);" style="width:150px; top:1260px; left:560px;"/>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/rz_ziadost/rz_ziadost_v14-2.jpg" alt="tlaËivo éiadosù o RZ FO pre rok 2013 2.strana 282kB" class="form-background">

<!-- III. BONUS -->
<input type="checkbox" name="bonus" value="1" style="top:110px; left:795px;"/>
<input type="text" name="det01" id="det01" style="width:186px; top:200px; left:116px;"/>
<input type="text" name="rod01" id="rod01" style="width:77px; top:200px; left:314px;"/>
<input type="text" name="mes01" id="mes01" style="width:70px; top:200px; left:402px;"/>
<input type="text" name="det02" id="det02" style="width:186px; top:235px; left:116px;"/>
<input type="text" name="rod02" id="rod02" style="width:77px; top:235px; left:314px;"/>
<input type="text" name="mes02" id="mes02" style="width:70px; top:235px; left:402px;"/>
<input type="text" name="det03" id="det03" style="width:186px; top:270px; left:116px;"/>
<input type="text" name="rod03" id="rod03" style="width:77px; top:270px; left:314px;"/>
<input type="text" name="mes03" id="mes03" style="width:70px; top:270px; left:402px;"/>
<input type="text" name="det04" id="det04" style="width:186px; top:305px; left:116px;"/>
<input type="text" name="rod04" id="rod04" style="width:77px; top:305px; left:314px;"/>
<input type="text" name="mes04" id="mes04" style="width:70px; top:305px; left:402px;"/>
<input type="text" name="det05" id="det05" style="width:186px; top:340px; left:116px;"/>
<input type="text" name="rod05" id="rod05" style="width:77px; top:340px; left:314px;"/>
<input type="text" name="mes05" id="mes05" style="width:70px; top:340px; left:402px;"/>
<input type="text" name="det06" id="det06" style="width:185px; top:200px; left:485px;"/>
<input type="text" name="rod06" id="rod06" style="width:78px; top:200px; left:681px;"/>
<input type="text" name="mes06" id="mes06" style="width:70px; top:200px; left:770px;"/>
<input type="text" name="det07" id="det07" style="width:185px; top:235px; left:485px;"/>
<input type="text" name="rod07" id="rod07" style="width:78px; top:235px; left:681px;"/>
<input type="text" name="mes07" id="mes07" style="width:70px; top:235px; left:770px;"/>
<input type="text" name="det08" id="det08" style="width:185px; top:270px; left:485px;"/>
<input type="text" name="rod08" id="rod08" style="width:78px; top:270px; left:681px;"/>
<input type="text" name="mes08" id="mes08" style="width:70px; top:270px; left:770px;"/>
<input type="text" name="det09" id="det09" style="width:185px; top:305px; left:485px;"/>
<input type="text" name="rod09" id="rod09" style="width:78px; top:305px; left:681px;"/>
<input type="text" name="mes09" id="mes09" style="width:70px; top:305px; left:770px;"/>
<input type="text" name="det10" id="det10" style="width:185px; top:340px; left:485px;"/>
<input type="text" name="rod10" id="rod10" style="width:78px; top:340px; left:681px;"/>
<input type="text" name="mes10" id="mes10" style="width:70px; top:340px; left:770px;"/>
<input type="checkbox" name="priskbonus" value="1" style="top:386px; left:795px;"/>

<!-- IV. POISTNE -->
<input type="checkbox" name="uplpoist" value="1" style="top:488px; left:798px;"/>
<input type="text" name="zappoistne" id="zappoistne" onkeyup="CiarkaNaBodku(this);" style="width:150px; top:531px; left:560px;"/>

<!-- V. ZAM.PREMIA -->
<input type="checkbox" name="ziad5" value="1" style="top:636px; left:798px;"/>

<!-- VI. ZDRAVOTNIK -->
<input type="checkbox" name="ziad3" value="1" style="top:739px; left:798px;"/>
<input type="text" name="ziad3eur" id="ziad3eur" onkeyup="CiarkaNaBodku(this);" style="width:150px; top:786px; left:560px;"/>

<!-- VII. POTVRDENIE -->
<input type="checkbox" name="ziad9" value="1" style="top:856px; left:799px;"/>
<input type="text" name="ineuda" id="ineuda" style="width:70px; top:930px; left:100px;"/>
<input type="text" name="miesto" id="miesto" value="<?php echo $fir_fmes; ?>" disabled="disabled" class="nofill" style="width:222px; top:1083px; left:112px;"/>
<input type="text" name="datum" id="datum" onkeyup="CiarkaNaBodku(this);" style="width:129px; top:1083px; left:378px;"/>
<?php                                        } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
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
/////////////////////////////////////////////////VYTLAC VYHLASENIE
if ( $copern == 10 )
{
if ( File_Exists("../tmp/vyhlasenie.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/vyhlasenie.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_rocneziadost".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_rocneziadost.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_rocneziadost.oc = $cislo_oc ORDER BY konx,prie,meno";

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

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/rz_ziadost/rz_ziadost_v14-1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/rz_ziadost/rz_ziadost_v14-1.jpg',0,0,210,297);
}

//za zdanovacie obdobie
$pdf->Cell(190,13,"                          ","$rmc1",1,"L");
$obdobie=$kli_vrok;
$pdf->Cell(149,4," ","$rmc1",0,"L");$pdf->Cell(30,4,"$kli_vrok","$rmc",1,"C");

//I. ZAMESTNANEC
$pdf->Cell(190,27,"                          ","$rmc1",1,"L");
$pdf->Cell(18,4," ","$rmc1",0,"L");$pdf->Cell(63,6,"$hlavicka->prie","$rmc",0,"L");
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(35,6,"$hlavicka->meno","$rmc",0,"L");
$dar=SkDatum($hlavicka->dar);
$tlacrd="$hlavicka->rdc / $hlavicka->rdk";
if ( $tlacrd == "0 / " ) { $tlacrd="$dar"; }
$pdf->Cell(24,4," ","$rmc1",0,"L");$pdf->Cell(34,6,"$tlacrd","$rmc",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(190,1,"                          ","$rmc1",1,"L");
$pdf->Cell(42,4," ","$rmc1",0,"L");$pdf->Cell(25,4,"$hlavicka->titl","$rmc",0,"L");$pdf->Cell(63,4," ","$rmc1",0,"L");$pdf->Cell(27,4,"$ztitz","$rmc",1,"L");
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$pdf->Cell(26,5," ","$rmc1",0,"L");$pdf->Cell(75,5,"$hlavicka->zuli","$rmc",0,"L");$pdf->Cell(9,5," ","$rmc1",0,"L");$pdf->Cell(29,5,"$hlavicka->zcdm","$rmc",0,"L");
$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(32,5,"$hlavicka->zpsc","$rmc",1,"L");
$pdf->Cell(27,5," ","$rmc1",0,"L");$pdf->Cell(74,4,"$hlavicka->zmes","$rmc",0,"L");$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(70,4,"$zstat","$rmc",1,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$pdf->Cell(18,5," ","$rmc1",0,"L");$pdf->Cell(161,6,"$fir_fnaz, $fir_fuli $fir_fcdm $fir_fmes","$rmc",1,"L");

//II. NCZD
//1. na manzel/ku
$pdf->Cell(190,14,"                          ","$rmc1",1,"L");
$uplmanx=" ";
if ( $hlavicka->uplman == 1 ) { $uplmanx="x"; }
$pdf->Cell(167,5," ","$rmc1",0,"L");$pdf->Cell(4,4,"$uplmanx","$rmc",1,"L");

//1.udaje o manzel-ke/ovi
$pdf->Cell(190,22,"                          ","$rmc1",1,"L");

$pdf->Cell(18,3," ","$rmc1",0,"L");$pdf->Cell(75,5,"$hlavicka->manprie","$rmc",0,"L");
$pdf->Cell(1,3," ","$rmc1",0,"L");$pdf->Cell(45,5,"$hlavicka->manmeno","$rmc",0,"L");
$pdf->Cell(2,3," ","$rmc1",0,"L");$pdf->Cell(38,5,"$hlavicka->manrodne","$rmc",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(26,3," ","$rmc1",0,"L");$pdf->Cell(90,4,"$hlavicka->manuli","$rmc",0,"L");
$pdf->Cell(8,3," ","$rmc1",0,"L");$pdf->Cell(24,4,"$hlavicka->mancdm","$rmc",0,"L");
$pdf->Cell(8,3," ","$rmc1",0,"L");$pdf->Cell(23,4,"$hlavicka->manpsc","$rmc",1,"L");
$pdf->Cell(26,3," ","$rmc1",0,"L");$pdf->Cell(90,5,"$hlavicka->manmes","$rmc",0,"L");
$pdf->Cell(8,3," ","$rmc1",0,"L");$pdf->Cell(55,5,"$hlavicka->manstat","$rmc",1,"L");
$pdf->Cell(167,3," ","$rmc1",0,"L");$pdf->Cell(12,4,"$hlavicka->manpes","$rmc",1,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$pdf->Cell(18,5," ","$rmc1",0,"L");$pdf->Cell(161,6,"$hlavicka->manzam","$rmc",1,"L");

//1.prijmy manzel-a/ky
$pdf->Cell(190,18,"                          ","$rmc1",1,"L");
$hodx=100*$hlavicka->maneur;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(116,6," ","$rmc1",0,"R");$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(4,5,"$t03","$rmc",0,"C");
$pdf->Cell(5,5,"$t04","$rmc",0,"C");$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",1,"C");

$pdf->Cell(190,10,"                          ","$rmc1",1,"L");
$prisknczdx=" ";
if ( $hlavicka->prisknczd == 1 ) { $prisknczdx="x"; }
$pdf->Cell(168,5," ","$rmc1",0,"L");$pdf->Cell(3,4,"$prisknczdx","$rmc",1,"C");

//2.dochodok
$pdf->Cell(190,21,"                          ","$rmc1",1,"L");
$upldocx=" ";
if ( $hlavicka->upldoc == 1 ) { $upldocx="x"; }
$pdf->Cell(167,5," ","$rmc1",0,"L");$pdf->Cell(4,3,"$upldocx","$rmc",1,"C");
if ( $hlavicka->upldoc == 0 )
{
$hlavicka->docx=" "; $hlavicka->doceur=" ";
}

$pdf->Cell(190,9,"                          ","$rmc1",1,"L");
$docxx=" ";
if ( $hlavicka->docx == 1 ) { $docxx="x"; }
$pdf->Cell(168,5," ","$rmc1",0,"L");$pdf->Cell(3,3,"$docxx","$rmc",1,"C");

$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$hodx=100*$hlavicka->doceur;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(119,6," ","$rmc1",0,"R");$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");
$pdf->Cell(6,5,"$t04","$rmc",0,"C");$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",1,"C");

//3.starobne doch.
$pdf->Cell(190,10,"                          ","$rmc1",1,"L");
$uplsdsx=" ";
if ( $hlavicka->uplsds == 1 ) { $uplsdsx="x"; }
$pdf->Cell(167,5," ","$rmc1",0,"L");$pdf->Cell(4,3,"$uplsdsx","$rmc",1,"C");

$pdf->Cell(190,11,"                          ","$rmc1",1,"L");
$hodx=100*$hlavicka->sdseur;
if ( $hodx == 0 OR $hlavicka->uplsds == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(121,6," ","$rmc1",0,"R");$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");
$pdf->Cell(6,5,"$t04","$rmc",0,"C");$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",1,"C");
                                       } //koniec 1.strany

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/rz_ziadost/rz_ziadost_v14-2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/rz_ziadost/rz_ziadost_v14-2.jpg',0,0,210,297);
}

//III. BONUS
$pdf->Cell(190,2,"                          ","$rmc1",1,"L");
$bonusx=" ";
if ( $hlavicka->bonus == 1 ) { $bonusx="x"; }
$pdf->Cell(168,5," ","$rmc1",0,"L");$pdf->Cell(4,4,"$bonusx","$rmc",1,"C");
$pdf->SetFont('arial','',8);
if ( $hlavicka->bonus == 0 )
{
$hlavicka->det01=" "; $hlavicka->rod01=" "; $hlavicka->mes01=" ";
$hlavicka->det02=" "; $hlavicka->rod02=" "; $hlavicka->mes02=" ";
$hlavicka->det03=" "; $hlavicka->rod03=" "; $hlavicka->mes03=" ";
$hlavicka->det04=" "; $hlavicka->rod04=" "; $hlavicka->mes04=" ";
$hlavicka->det05=" "; $hlavicka->rod05=" "; $hlavicka->mes05=" ";
$hlavicka->det06=" "; $hlavicka->rod06=" "; $hlavicka->mes06=" ";
$hlavicka->det07=" "; $hlavicka->rod07=" "; $hlavicka->mes07=" ";
$hlavicka->det08=" "; $hlavicka->rod08=" "; $hlavicka->mes08=" ";
$hlavicka->det09=" "; $hlavicka->rod09=" "; $hlavicka->mes09=" ";
$hlavicka->det10=" "; $hlavicka->rod10=" "; $hlavicka->mes10=" ";
$hlavicka->priskbonus=" "; $hlavicka->doceur=" ";
}

$pdf->Cell(190,19,"                          ","$rmc1",1,"L");
$pdf->Cell(17,5," ","$rmc1",0,"L");
$pdf->Cell(45,5,"$hlavicka->det01","$rmc",0,"L");$pdf->Cell(20,5,"$hlavicka->rod01","$rmc",0,"C");$pdf->Cell(17,5,"$hlavicka->mes01","$rmc",0,"L");
$pdf->Cell(45,5,"$hlavicka->det06","$rmc",0,"L");$pdf->Cell(20,5,"$hlavicka->rod06","$rmc",0,"C");$pdf->Cell(16,5,"$hlavicka->mes06","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc1",0,"L");
$pdf->Cell(45,4,"$hlavicka->det02","$rmc",0,"L");$pdf->Cell(20,4,"$hlavicka->rod02","$rmc",0,"C");$pdf->Cell(17,4,"$hlavicka->mes02","$rmc",0,"L");
$pdf->Cell(45,4,"$hlavicka->det07","$rmc",0,"L");$pdf->Cell(20,4,"$hlavicka->rod07","$rmc",0,"C");$pdf->Cell(16,4,"$hlavicka->mes07","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc1",0,"L");
$pdf->Cell(45,4,"$hlavicka->det03","$rmc",0,"L");$pdf->Cell(20,4,"$hlavicka->rod03","$rmc",0,"C");$pdf->Cell(17,4,"$hlavicka->mes03","$rmc",0,"L");
$pdf->Cell(45,4,"$hlavicka->det08","$rmc",0,"L");$pdf->Cell(20,4,"$hlavicka->rod08","$rmc",0,"C");$pdf->Cell(16,4,"$hlavicka->mes08","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc1",0,"L");
$pdf->Cell(45,4,"$hlavicka->det04","$rmc",0,"L");$pdf->Cell(20,4,"$hlavicka->rod04","$rmc",0,"C");$pdf->Cell(17,4,"$hlavicka->mes04","$rmc",0,"L");
$pdf->Cell(45,4,"$hlavicka->det09","$rmc",0,"L");$pdf->Cell(20,4,"$hlavicka->rod09","$rmc",0,"C");$pdf->Cell(16,4,"$hlavicka->mes09","$rmc",1,"L");
$pdf->Cell(17,5," ","$rmc1",0,"L");
$pdf->Cell(45,5,"$hlavicka->det05","$rmc",0,"L");$pdf->Cell(20,5,"$hlavicka->rod05","$rmc",0,"C");$pdf->Cell(17,5,"$hlavicka->mes05","$rmc",0,"L");
$pdf->Cell(45,5,"$hlavicka->det10","$rmc",0,"L");$pdf->Cell(20,5,"$hlavicka->rod10","$rmc",0,"C");$pdf->Cell(16,5,"$hlavicka->mes10","$rmc",1,"L");
$pdf->SetFont('arial','',10);

$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$priskbonusx=" ";
if ( $hlavicka->priskbonus == 1 ) { $priskbonusx="x"; }
$pdf->Cell(170,5," ","$rmc1",0,"L");$pdf->Cell(5,3,"$priskbonusx","$rmc",1,"C");

//IV. POISTNE
$pdf->Cell(190,17,"                          ","$rmc1",1,"L");
$uplpoistx=" ";
if ( $hlavicka->uplpoist == 1 ) { $uplpoistx="x"; }
$pdf->Cell(167,5," ","$rmc1",0,"L");$pdf->Cell(4,3,"$uplpoistx","$rmc",1,"C");

$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$hodx=100*$hlavicka->zappoistne;
if ( $hodx == 0 OR $hlavicka->uplpoist ==  0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(118,6," ","$rmc1",0,"R");$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");
$pdf->Cell(6,5,"$t04","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",1,"C");

//V. ZAM.PREMIA
$pdf->Cell(190,18,"                          ","$rmc1",1,"L");
$ziad5x=" ";
if ( $hlavicka->ziad5 == 1 ) { $ziad5x="x"; }
$pdf->Cell(167,5," ","$rmc1",0,"L");$pdf->Cell(4,3,"$ziad5x","$rmc",1,"C");

//VI. ZDRAVOTNIK
$pdf->Cell(190,25,"                          ","$rmc1",1,"L");
$ziad3x=" ";
if ( $hlavicka->ziad3 == 1 ) { $ziad3x="x"; }
$pdf->Cell(167,5," ","$rmc1",0,"L");$pdf->Cell(4,4,"$ziad3x","$rmc",1,"C");

$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$hodx=100*$hlavicka->ziad3eur;
if ( $hodx == 0 OR $hlavicka->ziad3 == 0 ) $hodx="";
$text=sprintf("% 5s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(119,6," ","$rmc1",0,"R");$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");$pdf->Cell(5,5,"$t05","$rmc",1,"C");

//VII. POTVRDENIE
$pdf->Cell(190,12,"                          ","$rmc1",1,"L");
$ziad9x=" ";
if ( $hlavicka->ziad9 == 1 ) { $ziad9x="x"; }
$pdf->Cell(168,5," ","$rmc1",0,"L");$pdf->Cell(4,3,"$ziad9x","$rmc",1,"C");

$pdf->Cell(190,13,"                          ","$rmc1",1,"L");
$pdf->Cell(17,3," ","$rmc1",0,"L");$pdf->Cell(13,5,"$hlavicka->ineuda","$rmc",1,"C");

//V a Dna vystavenia
$pdf->Cell(190,31,"                          ","$rmc1",1,"L");
$datum=SkDatum($hlavicka->datum);
if ( $datum == '00.00.0000' ) $datum="";
$pdf->Cell(19,3," ","$rmc1",0,"L");$pdf->Cell(48,5,"$fir_fmes","$rmc",0,"L");$pdf->Cell(8,3," ","$rmc1",0,"L");$pdf->Cell(30,5,"$datum","$rmc",1,"C");
                                       } //koniec 2.strany
  }
$i = $i + 1;
  }
$pdf->Output("../tmp/vyhlasenie.$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/vyhlasenie.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA VZHLASENIA
?>

<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
$cislista = include("mzd_lista_norm.php");
} while (false);
?>
</BODY>
</HTML>