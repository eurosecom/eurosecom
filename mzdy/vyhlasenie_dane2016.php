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
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) { $strana=9999; }

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
$rmc=1;
$rmc1=0;

//.jpg podklad
$jpg_cesta="../dokumenty/dan_z_prijmov2016/dan_zo_zavislej2016/vyhlasenie_nazdanenie/vyhlasenie_nczd_v16";
$jpg_popis="Vyhl·senie na uplatnenie N»ZD v roku ".$kli_vrok;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");

$cislo_oc = $_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];

//priezvisko,meno,titul FO
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";

$fir_vysledok = mysql_query($sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
if ( $fir_uctt03 == 999 )
{
$fnazov = $fir_riadok->dmeno." ".$fir_riadok->dprie." ".$fir_riadok->dtitl." ".$fir_riadok->dtitz;
$dadresa = $fir_riadok->duli." "." ".$fir_riadok->dcdm." ".$fir_riadok->dmes;
}
if ( $fir_uctt03 != 999 )
{
$fadresa = $fir_fnaz." ".$fir_fuli." ".$fir_fcdm." ".$fir_fmes;
$fnazov = $fir_fnaz;
}

//nacitaj z minul.roka
if ( $copern == 2055 )
     {
?>
<script type="text/javascript">
if ( !confirm ("Chcete naËÌtaù deti z ˙dajov o zamestnancovi ?") )
     { window.close() }
else
     { location.href='vyhlasenie_dane2016.php?copern=4156&page=1&drupoh=1&cislo_oc=<?php echo $cislo_oc; ?>' }
</script>
<?php
     }

    if ( $copern == 4156 )
    {

//deti
$sqldttt = "SELECT * FROM F$kli_vxcf"."_mzddeti WHERE oc = $cislo_oc ORDER BY dr";

$sqldt = mysql_query("$sqldttt");
$poldt = mysql_num_rows($sqldt);

$idt=0;
  while ($idt <= $poldt )
  {
  if (@$zaznam=mysql_data_seek($sqldt,$idt))
{
$deti=mysql_fetch_object($sqldt);

$dr_sk=SkDatum($deti->dr);

if ( $idt == 0 ) { $det01=$deti->md; $nar01=$deti->dr; }
if ( $idt == 1 ) { $det02=$deti->md; $nar02=$deti->dr; }
if ( $idt == 2 ) { $det03=$deti->md; $nar03=$deti->dr; }
if ( $idt == 3 ) { $det04=$deti->md; $nar04=$deti->dr; }
if ( $idt == 4 ) { $det05=$deti->md; $nar05=$deti->dr; }
if ( $idt == 5 ) { $det06=$deti->md; $nar06=$deti->dr; }
if ( $idt == 6 ) { $det07=$deti->md; $nar07=$deti->dr; }
if ( $idt == 7 ) { $det08=$deti->md; $nar08=$deti->dr; }
if ( $idt == 8 ) { $det09=$deti->md; $nar09=$deti->dr; }
if ( $idt == 9 ) { $det10=$deti->md; $nar10=$deti->dr; }
}
$idt = $idt + 1;
  }

$sqtoz = "UPDATE F$kli_vxcf"."_vyhlaseniedane SET ".
" det01='$det01', det02='$det02', det03='$det03', det04='$det04', det05='$det05', det06='$det06', det07='$det07', det08='$det08', det09='$det09', det10='$det10', ".  
" nar01='$nar01', nar02='$nar02', nar03='$nar03', nar04='$nar04', nar05='$nar05', nar06='$nar06', nar07='$nar07', nar08='$nar08', nar09='$nar09', nar10='$nar10' ".
" WHERE F$kli_vxcf"."_vyhlaseniedane.oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$copern=20;
$subor=0;
    }
//koniec nacitaj deti

//nacitaj z minul.roka
if ( $copern == 1055 )
     {
?>
<script type="text/javascript">
if ( !confirm ("Chcete naËÌtaù ˙daje do vyhl·senia z firmy minulÈho roka ?") )
     { window.close() }
else
     { location.href='vyhlasenie_dane2016.php?copern=3156&page=1&drupoh=1&cislo_oc=<?php echo $cislo_oc; ?>' }
</script>
<?php
     }

    if ( $copern == 3156 )
    {
$kli_vmcf=$fir_allx11;
$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");

if ( $kli_vrok == 2014 ) {
$sqtoz = "UPDATE F$kli_vxcf"."_vyhlaseniedane,".$databaza."F$kli_vmcf"."_vyhlaseniedane SET ".
"F$kli_vxcf"."_vyhlaseniedane.pracov=".$databaza."F$kli_vmcf"."_vyhlaseniedane.pracov,  ".
"F$kli_vxcf"."_vyhlaseniedane.nezd=".$databaza."F$kli_vmcf"."_vyhlaseniedane.nezd,  ".
"F$kli_vxcf"."_vyhlaseniedane.bonus=".$databaza."F$kli_vmcf"."_vyhlaseniedane.bonus,  ".
"F$kli_vxcf"."_vyhlaseniedane.det01=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m1det01,  ".
"F$kli_vxcf"."_vyhlaseniedane.det02=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m1det02,  ".
"F$kli_vxcf"."_vyhlaseniedane.det03=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m1det03,  ".
"F$kli_vxcf"."_vyhlaseniedane.det04=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m1det04,  ".
"F$kli_vxcf"."_vyhlaseniedane.det05=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m1det05,  ".
"F$kli_vxcf"."_vyhlaseniedane.det06=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m2det01,  ".
"F$kli_vxcf"."_vyhlaseniedane.det07=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m2det02,  ".
"F$kli_vxcf"."_vyhlaseniedane.det08=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m2det03,  ".
"F$kli_vxcf"."_vyhlaseniedane.det09=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m2det04,  ".
"F$kli_vxcf"."_vyhlaseniedane.det10=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m2det05,  ".
"F$kli_vxcf"."_vyhlaseniedane.nar01=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m1nar01,  ".
"F$kli_vxcf"."_vyhlaseniedane.nar02=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m1nar02,  ".
"F$kli_vxcf"."_vyhlaseniedane.nar03=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m1nar03,  ".
"F$kli_vxcf"."_vyhlaseniedane.nar04=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m1nar04,  ".
"F$kli_vxcf"."_vyhlaseniedane.nar05=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m1nar05,  ".
"F$kli_vxcf"."_vyhlaseniedane.nar06=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m2nar01,  ".
"F$kli_vxcf"."_vyhlaseniedane.nar07=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m2nar02,  ".
"F$kli_vxcf"."_vyhlaseniedane.nar08=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m2nar03,  ".
"F$kli_vxcf"."_vyhlaseniedane.nar09=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m2nar04,  ".
"F$kli_vxcf"."_vyhlaseniedane.nar10=".$databaza."F$kli_vmcf"."_vyhlaseniedane.m2nar05,  ".
"F$kli_vxcf"."_vyhlaseniedane.docx=".$databaza."F$kli_vmcf"."_vyhlaseniedane.docx,  ".
"F$kli_vxcf"."_vyhlaseniedane.str2=".$databaza."F$kli_vmcf"."_vyhlaseniedane.str2,  ".
"F$kli_vxcf"."_vyhlaseniedane.rdstav=".$databaza."F$kli_vmcf"."_vyhlaseniedane.rdstav  ".
" WHERE F$kli_vxcf"."_vyhlaseniedane.oc = $cislo_oc AND F$kli_vxcf"."_vyhlaseniedane.oc=".$databaza."F$kli_vmcf"."_vyhlaseniedane.oc ";
                         }

if ( $kli_vrok > 2014 ) {
$sqtoz = "UPDATE F$kli_vxcf"."_vyhlaseniedane,".$databaza."F$kli_vmcf"."_vyhlaseniedane SET ".
"F$kli_vxcf"."_vyhlaseniedane.ztitl=".$databaza."F$kli_vmcf"."_vyhlaseniedane.ztitl, ".
"F$kli_vxcf"."_vyhlaseniedane.rdstav=".$databaza."F$kli_vmcf"."_vyhlaseniedane.rdstav, ".
"F$kli_vxcf"."_vyhlaseniedane.stat=".$databaza."F$kli_vmcf"."_vyhlaseniedane.stat, ".
"F$kli_vxcf"."_vyhlaseniedane.pracov=".$databaza."F$kli_vmcf"."_vyhlaseniedane.pracov, ".
"F$kli_vxcf"."_vyhlaseniedane.nezd=".$databaza."F$kli_vmcf"."_vyhlaseniedane.nezd, ".
"F$kli_vxcf"."_vyhlaseniedane.docx=".$databaza."F$kli_vmcf"."_vyhlaseniedane.docx, ".
"F$kli_vxcf"."_vyhlaseniedane.bonus=".$databaza."F$kli_vmcf"."_vyhlaseniedane.bonus, ".
"F$kli_vxcf"."_vyhlaseniedane.det01=".$databaza."F$kli_vmcf"."_vyhlaseniedane.det01, ".
"F$kli_vxcf"."_vyhlaseniedane.det02=".$databaza."F$kli_vmcf"."_vyhlaseniedane.det02, ".
"F$kli_vxcf"."_vyhlaseniedane.det03=".$databaza."F$kli_vmcf"."_vyhlaseniedane.det03, ".
"F$kli_vxcf"."_vyhlaseniedane.det04=".$databaza."F$kli_vmcf"."_vyhlaseniedane.det04, ".
"F$kli_vxcf"."_vyhlaseniedane.det05=".$databaza."F$kli_vmcf"."_vyhlaseniedane.det05, ".
"F$kli_vxcf"."_vyhlaseniedane.det06=".$databaza."F$kli_vmcf"."_vyhlaseniedane.det06, ".
"F$kli_vxcf"."_vyhlaseniedane.det07=".$databaza."F$kli_vmcf"."_vyhlaseniedane.det07, ".
"F$kli_vxcf"."_vyhlaseniedane.det08=".$databaza."F$kli_vmcf"."_vyhlaseniedane.det08, ".
"F$kli_vxcf"."_vyhlaseniedane.det09=".$databaza."F$kli_vmcf"."_vyhlaseniedane.det09, ".
"F$kli_vxcf"."_vyhlaseniedane.det10=".$databaza."F$kli_vmcf"."_vyhlaseniedane.det10, ".
"F$kli_vxcf"."_vyhlaseniedane.nar01=".$databaza."F$kli_vmcf"."_vyhlaseniedane.nar01, ".
"F$kli_vxcf"."_vyhlaseniedane.nar02=".$databaza."F$kli_vmcf"."_vyhlaseniedane.nar02, ".
"F$kli_vxcf"."_vyhlaseniedane.nar03=".$databaza."F$kli_vmcf"."_vyhlaseniedane.nar03, ".
"F$kli_vxcf"."_vyhlaseniedane.nar04=".$databaza."F$kli_vmcf"."_vyhlaseniedane.nar04, ".
"F$kli_vxcf"."_vyhlaseniedane.nar05=".$databaza."F$kli_vmcf"."_vyhlaseniedane.nar05, ".
"F$kli_vxcf"."_vyhlaseniedane.nar06=".$databaza."F$kli_vmcf"."_vyhlaseniedane.nar06, ".
"F$kli_vxcf"."_vyhlaseniedane.nar07=".$databaza."F$kli_vmcf"."_vyhlaseniedane.nar07, ".
"F$kli_vxcf"."_vyhlaseniedane.nar08=".$databaza."F$kli_vmcf"."_vyhlaseniedane.nar08, ".
"F$kli_vxcf"."_vyhlaseniedane.nar09=".$databaza."F$kli_vmcf"."_vyhlaseniedane.nar09, ".
"F$kli_vxcf"."_vyhlaseniedane.nar10=".$databaza."F$kli_vmcf"."_vyhlaseniedane.nar10, ".
"F$kli_vxcf"."_vyhlaseniedane.str3=".$databaza."F$kli_vmcf"."_vyhlaseniedane.str3  ".

" WHERE F$kli_vxcf"."_vyhlaseniedane.oc = $cislo_oc AND F$kli_vxcf"."_vyhlaseniedane.oc=".$databaza."F$kli_vmcf"."_vyhlaseniedane.oc ";
                        }

//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
$copern=20;
$subor=0;
    }
//koniec nacitaj z minul.roka

// znovu nacitaj
if ( $copern == 26 )
     {
$sqtoz = "DELETE FROM F$kli_vxcf"."_vyhlaseniedane WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");
$copern=10;
$subor=1;
     }
//koniec znovu nacitaj

// zapis upravene udaje
if ( $copern == 23 )
     {
//$ztitl = strip_tags($_REQUEST['ztitl']);
$rdstav = strip_tags($_REQUEST['rdstav']);
//$stat = strip_tags($_REQUEST['stat']);
//$pracov = strip_tags($_REQUEST['pracov']);
$nezd = 1*$_REQUEST['nezd'];
$docx = 1*$_REQUEST['docx'];
$bonus = 1*$_REQUEST['bonus'];
$det01 = strip_tags($_REQUEST['det01']);
$nar01 = strip_tags($_REQUEST['nar01']);
$nar01_sql=SqlDatum($nar01);
$det02 = strip_tags($_REQUEST['det02']);
$nar02 = strip_tags($_REQUEST['nar02']);
$nar02_sql=SqlDatum($nar02);
$det03 = strip_tags($_REQUEST['det03']);
$nar03 = strip_tags($_REQUEST['nar03']);
$nar03_sql=SqlDatum($nar03);
$det04 = strip_tags($_REQUEST['det04']);
$nar04 = strip_tags($_REQUEST['nar04']);
$nar04_sql=SqlDatum($nar04);
$det05 = strip_tags($_REQUEST['det05']);
$nar05 = strip_tags($_REQUEST['nar05']);
$nar05_sql=SqlDatum($nar05);
$det06 = strip_tags($_REQUEST['det06']);
$nar06 = strip_tags($_REQUEST['nar06']);
$nar06_sql=SqlDatum($nar06);
$det07 = strip_tags($_REQUEST['det07']);
$nar07 = strip_tags($_REQUEST['nar07']);
$nar07_sql=SqlDatum($nar07);
$det08 = strip_tags($_REQUEST['det08']);
$nar08 = strip_tags($_REQUEST['nar08']);
$nar08_sql=SqlDatum($nar08);
$det09 = strip_tags($_REQUEST['det09']);
$nar09 = strip_tags($_REQUEST['nar09']);
$nar09_sql=SqlDatum($nar09);
$det10 = strip_tags($_REQUEST['det10']);
$nar10 = strip_tags($_REQUEST['nar10']);
$nar10_sql=SqlDatum($nar10);
//$m2det01 = strip_tags($_REQUEST['m2det01']);
//$m2nar01 = strip_tags($_REQUEST['m2nar01']);
//$m2det02 = strip_tags($_REQUEST['m2det02']);
//$m2nar02 = strip_tags($_REQUEST['m2nar02']);
//$m2det03 = strip_tags($_REQUEST['m2det03']);
//$m2nar03 = strip_tags($_REQUEST['m2nar03']);
//$m2det04 = strip_tags($_REQUEST['m2det04']);
//$m2nar04 = strip_tags($_REQUEST['m2nar04']);
//$m2det05 = strip_tags($_REQUEST['m2det05']);
//$m2nar05 = strip_tags($_REQUEST['m2nar05']);
//$m2nar01_sql=SqlDatum($m2nar01);
//$m2nar02_sql=SqlDatum($m2nar02);
//$m2nar03_sql=SqlDatum($m2nar03);
//$m2nar04_sql=SqlDatum($m2nar04);
//$m2nar05_sql=SqlDatum($m2nar05);
//$m3det01 = strip_tags($_REQUEST['m3det01']);
//$m3nar01 = strip_tags($_REQUEST['m3nar01']);
//$m3det02 = strip_tags($_REQUEST['m3det02']);
//$m3nar02 = strip_tags($_REQUEST['m3nar02']);
//$m3det03 = strip_tags($_REQUEST['m3det03']);
//$m3nar03 = strip_tags($_REQUEST['m3nar03']);
//$m3det04 = strip_tags($_REQUEST['m3det04']);
//$m3nar04 = strip_tags($_REQUEST['m3nar04']);
//$m3det05 = strip_tags($_REQUEST['m3det05']);
//$m3nar05 = strip_tags($_REQUEST['m3nar05']);
//$m3nar01_sql=SqlDatum($m3nar01);
//$m3nar02_sql=SqlDatum($m3nar02);
//$m3nar03_sql=SqlDatum($m3nar03);
//$m3nar04_sql=SqlDatum($m3nar04);
//$m3nar05_sql=SqlDatum($m3nar05);
$datum = strip_tags($_REQUEST['datum']);
$datum_sql=SqlDatum($datum);
//$str3 = strip_tags($_REQUEST['str3']);
//$pozn = strip_tags($_REQUEST['pozn']);
//$str3 = strip_tags($_REQUEST['str3']);
//$str4 = strip_tags($_REQUEST['str4']);
//$manzel = strip_tags($_REQUEST['manzel']);
//$mannar = strip_tags($_REQUEST['mannar']);
//$mannar_sql=SqlDatum($mannar);
//$manadr = strip_tags($_REQUEST['manadr']);
//$manpsc = strip_tags($_REQUEST['manpsc']);
//$manzam = strip_tags($_REQUEST['manzam']);
//$ineuda = strip_tags($_REQUEST['ineuda']);
//$ostat = strip_tags($_REQUEST['ostat']);
$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_vyhlaseniedane SET ".
" rdstav='$rdstav', nezd='$nezd', bonus='$bonus', docx='$docx', datum='$datum_sql', ".
" det01='$det01', nar01='$nar01_sql', det02='$det02', nar02='$nar02_sql', det03='$det03', nar03='$nar03_sql', det04='$det04', nar04='$nar04_sql', ".
" det05='$det05', nar05='$nar05_sql', det06='$det06', nar06='$nar06_sql', det07='$det07', nar07='$nar07_sql', det08='$det08', nar08='$nar08_sql', ".
" det09='$det09', nar09='$nar09_sql', det10='$det10', nar10='$nar10_sql' ".
" WHERE oc = $cislo_oc";
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


//prac.subor a subor vytvorenych potvrdeni
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
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

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_vyhlaseniedane'.$sqlt;
$vytvor = mysql_query("$vsql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD str4 DECIMAL(4,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD str3 DECIMAL(4,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");

//zmeny pre rok 2014
$sql = "SELECT nar10 FROM F".$kli_vxcf."_vyhlaseniedane";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD new2014 DECIMAL(2,0) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD ztitl VARCHAR(10) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD stat VARCHAR(30) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD det01 VARCHAR(80) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD nar01 DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD det02 VARCHAR(80) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD nar02 DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD det03 VARCHAR(80) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD nar03 DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD det04 VARCHAR(80) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD nar04 DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD det05 VARCHAR(80) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD nar05 DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD det06 VARCHAR(80) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD nar06 DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD det07 VARCHAR(80) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD nar07 DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD det08 VARCHAR(80) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD nar08 DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD det09 VARCHAR(80) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD nar09 DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD det10 VARCHAR(80) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyhlaseniedane ADD nar10 DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
}
$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvypl$kli_uzid SELECT * FROM F".$kli_vxcf."_vyhlaseniedane WHERE oc < 0 ";
$vytvor = mysql_query("$vsql");
$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvyplx$kli_uzid SELECT * FROM F".$kli_vxcf."_vyhlaseniedane WHERE oc < 0 ";
$vytvor = mysql_query("$vsql");

$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_vyhlaseniedane WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $jepotvrd=1;
  }
if ( $jepotvrd == 0 ) $subor=1;

//pre potvrdenie vytvor pracovny subor
if ( $subor == 1 )
{
$pracovx=$fir_fnaz." ".$fir_fuli." ".$fir_fcdm.", ".$fir_fmes.", ".$fir_fpsc;

//uloz do vyhlasenia
$sqtoz = "DELETE FROM F$kli_vxcf"."_vyhlaseniedane WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_vyhlaseniedane ( oc, pracov ) VALUES ( '$cislo_oc', '$pracovx') ";
$dsql = mysql_query("$dsqlt");
}
//koniec pracovneho suboru pre potvrdenie 

/////////////NACITANIE UDAJOV Z PARAMETROV
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  }

//nacitaj udaje pre upravu
if ( $copern == 20 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_vyhlaseniedane".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_vyhlaseniedane.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_vyhlaseniedane.oc = $cislo_oc ORDER BY konx,prie,meno";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
//$zamestnanec = $fir_riadok->oc." ".$fir_riadok->titl." ".$fir_riadok->meno." ".$fir_riadok->prie;
$prie = $fir_riadok->prie;
$meno = $fir_riadok->meno;
$rodne = $fir_riadok->rdc."/".$fir_riadok->rdk;
$dar=SkDatum($fir_riadok->dar);
if ( $rodne == "0/" ) { $rodne="$dar"; }
$ptitl = $fir_riadok->titl;
$rdstav = $fir_riadok->rdstav;
$uli = $fir_riadok->zuli;
$cdm = $fir_riadok->zcdm;
$psc = $fir_riadok->zpsc;
$mes = $fir_riadok->zmes;
$zamestnavatel = $fir_fnaz.", ".$fir_fuli." ".$fir_fcdm.", ".$fir_fmes;
$nezd = $fir_riadok->nezd;
$docx = $fir_riadok->docx;
$bonus = $fir_riadok->bonus;
$det01 = $fir_riadok->det01;
$nar01 = $fir_riadok->nar01;
$nar01_sk=SkDatum($nar01);
$det02 = $fir_riadok->det02;
$nar02 = $fir_riadok->nar02;
$nar02_sk=SkDatum($nar02);
$det03 = $fir_riadok->det03;
$nar03 = $fir_riadok->nar03;
$nar03_sk=SkDatum($nar03);
$det04 = $fir_riadok->det04;
$nar04 = $fir_riadok->nar04;
$nar04_sk=SkDatum($nar04);
$det05 = $fir_riadok->det05;
$nar05 = $fir_riadok->nar05;
$nar05_sk=SkDatum($nar05);
$det06 = $fir_riadok->det06;
$nar06 = $fir_riadok->nar06;
$nar06_sk=SkDatum($nar06);
$det07 = $fir_riadok->det07;
$nar07 = $fir_riadok->nar07;
$nar07_sk=SkDatum($nar07);
$det08 = $fir_riadok->det08;
$nar08 = $fir_riadok->nar08;
$nar08_sk=SkDatum($nar08);
$det09 = $fir_riadok->det09;
$nar09 = $fir_riadok->nar09;
$nar09_sk=SkDatum($nar09);
$det10 = $fir_riadok->det10;
$nar10 = $fir_riadok->nar10;
$nar10_sk=SkDatum($nar10);
$datum = $fir_riadok->datum;
$datum_sk=SkDatum($datum);
mysql_free_result($fir_vysledok);

//stat z udajov o zamestn.
$zstat="Slovensko"; $zstak="703";
$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_mzdtextmzd WHERE invt = $cislo_oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zstat=$riaddok->zstat;
  }
if ( $zstat == '' ) { $zstat="Slovensko"; }
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

//osobne cislo prepinanie
$prepoc=1;
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
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Vyhl·senie na uplatnenie N»ZD</title>

<script type="text/javascript">
<?php
//uprava sadzby
  if ( $copern == 20 )
  { 
?>
  function ObnovUI()
  {
   document.formv1.rdstav.value = '<?php echo "$rdstav";?>';
<?php if ( $nezd == 1 ) { ?> document.formv1.nezd.checked = "checked"; <?php } ?>
<?php if ( $docx == 1 ) { ?> document.formv1.docx.checked = "checked"; <?php } ?>
<?php if ( $bonus == 1 ) { ?> document.formv1.bonus.checked = "checked"; <?php } ?>
   document.formv1.det01.value = '<?php echo "$det01";?>';
   document.formv1.nar01.value = '<?php echo "$nar01_sk";?>';
   document.formv1.det02.value = '<?php echo "$det02";?>';
   document.formv1.nar02.value = '<?php echo "$nar02_sk";?>';
   document.formv1.det03.value = '<?php echo "$det03";?>';
   document.formv1.nar03.value = '<?php echo "$nar03_sk";?>';
   document.formv1.det04.value = '<?php echo "$det04";?>';
   document.formv1.nar04.value = '<?php echo "$nar04_sk";?>';
   document.formv1.det05.value = '<?php echo "$det05";?>';
   document.formv1.nar05.value = '<?php echo "$nar05_sk";?>';
   document.formv1.det06.value = '<?php echo "$det06";?>';
   document.formv1.nar06.value = '<?php echo "$nar06_sk";?>';
   document.formv1.det07.value = '<?php echo "$det07";?>';
   document.formv1.nar07.value = '<?php echo "$nar07_sk";?>';
   document.formv1.det08.value = '<?php echo "$det08";?>';
   document.formv1.nar08.value = '<?php echo "$nar08_sk";?>';
   document.formv1.det09.value = '<?php echo "$det09";?>';
   document.formv1.nar09.value = '<?php echo "$nar09_sk";?>';
   document.formv1.det10.value = '<?php echo "$det10";?>';
   document.formv1.nar10.value = '<?php echo "$nar10_sk";?>';
   document.formv1.datum.value = '<?php echo "$datum_sk";?>';
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
   window.open('vyhlasenie_dane2016.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $prev_oc;?>', '_self');
  }
  function nextOC()
  {
   window.open('vyhlasenie_dane2016.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $next_oc;?>', '_self');
  }
  function TlacVyhlNCZD()
  {
   window.open('../mzdy/vyhlasenie_dane2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=1', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMinRok()
  {
   window.open('../mzdy/vyhlasenie_dane2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=1055&drupoh=1&page=1&subor=1', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function UpravZamestnanca()
  {
   window.open('zamestnanci.php?sys=<?php echo $sys; ?>&copern=8&page=1&cislo_oc=<?php echo $cislo_oc;?>&h_oc=<?php echo $cislo_oc;?>', '_blank','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajDeti()
  {
   window.open('../mzdy/vyhlasenie_dane2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=2055&drupoh=1&page=1&subor=1', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
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
   <td class="header">Vyhl·senie na uplatnenie N»ZD - <span class="subheader"><?php echo "$cislo_oc $meno $prie ";?></span>
<?php if ( $novy == 0 ) { ?>
    <img src="../obr/prev.png" onclick="prevOC();" title="Os.Ë. <?php echo $prev_oc; ?>" class="navoc-icon">
    <img src="../obr/next.png" onclick="nextOC();" title="Os.Ë. <?php echo $next_oc; ?>" class="navoc-icon">
<?php                   } ?>
   </td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajMinRok();" title="NaËÌtaù ˙daje z minulÈho roka" class="btn-form-tool"> <!-- dopyt, rozchodiù -->
     <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVyhlNCZD();" title="Zobraziù v PDF" class="btn-form-tool">
     <img src="../obr/ikony/usertwo_blue_icon.png" onclick="NacitajDeti();" title="NaËÌtaù deti z ˙dajov o zamestnancovi" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="vyhlasenie_dane2016.php?copern=23&cislo_oc=<?php echo $cislo_oc; ?>">
<div class="navbar">
<?php
$clas1="active";
$source="../mzdy/vyhlasenie_dane2016.php?cislo_oc=".$cislo_oc."&drupoh=1&page=1&subor=0";
?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>
<img src="<?php echo $jpg_cesta; ?>_str1_form.jpg"
     alt="<?php echo $jpg_popis; ?> 1.strana 264kB" class="form-background">

<!-- ZAMESTNANEC -->
<img src="../obr/ikony/pencil_blue_icon.png" onclick="UpravZamestnanca();"
     title="Upraviù ˙daje o zamestnancovi" class="btn-row-tool"
     style="top:248px; left:330px; width:16px; height:16px;">
<span class="text-echo" style="top:310px; left:122px;"><?php echo $prie; ?></span>
<span class="text-echo" style="top:310px; left:410px;"><?php echo $meno; ?></span>
<span class="text-echo" style="top:310px; left:590px;"><?php echo $rodne; ?></span>
<span class="text-echo" style="top:347px; left:230px;"><?php echo $ptitl; ?></span>
<span class="text-echo" style="top:347px; left:465px;"><?php echo $ptitz; ?></span>
<select size="1" name="rdstav" id="rdstav" style="top:338px; left:669px;">
 <option value="0">slobodn˝/slobodn·</option>
 <option value="1">ûenat˝/vydat·</option>
 <option value="2">vdovec/vdova</option>
 <option value="3">rozveden˝/rozveden·</option>
</select>
<span class="text-echo" style="top:399px; left:160px;"><?php echo $uli; ?></span>
<span class="text-echo" style="top:399px; left:538px;"><?php echo $cdm; ?></span>
<span class="text-echo" style="top:399px; left:702px;"><?php echo $psc; ?></span>
<span class="text-echo" style="top:435px; left:160px;"><?php echo $mes; ?></span>
<span class="text-echo" style="top:435px; left:530px;"><?php echo $zstat; ?></span>
<span class="text-echo" style="top:488px; left:122px;">»˝<?php echo $zamestnavatel; ?></span>

<!-- UPLATNENIE NCZD -->
<input type="checkbox" name="nezd" value="1" style="top:581px; left:803px;"/>
<input type="checkbox" name="docx" value="1" style="top:634px; left:803px;"/>

<!-- UPLATNENIE BONUS -->
<input type="checkbox" name="bonus" value="1" style="top:736px; left:803px;"/>
<input type="text" name="det01" id="det01" style="width:250px; top:833px; left:116px;"/>
<input type="text" name="nar01" id="nar01" onkeyup="CiarkaNaBodku(this);" style="width:95px; top:833px; left:378px;"/>
<input type="text" name="det02" id="det02" style="width:250px; top:868px; left:116px;"/>
<input type="text" name="nar02" id="nar02" onkeyup="CiarkaNaBodku(this);" style="width:95px; top:868px; left:378px;"/>
<input type="text" name="det03" id="det03" style="width:250px; top:903px; left:116px;"/>
<input type="text" name="nar03" id="nar03" onkeyup="CiarkaNaBodku(this);" style="width:95px; top:903px; left:378px;"/>
<input type="text" name="det04" id="det04" style="width:250px; top:938px; left:116px;"/>
<input type="text" name="nar04" id="nar04" onkeyup="CiarkaNaBodku(this);" style="width:95px; top:938px; left:378px;"/>
<input type="text" name="det05" id="det05" style="width:250px; top:974px; left:116px;"/>
<input type="text" name="nar05" id="nar05" onkeyup="CiarkaNaBodku(this);" style="width:95px; top:974px; left:378px;"/>
<input type="text" name="det06" id="det06" style="width:250px; top:833px; left:486px;"/>
<input type="text" name="nar06" id="nar06" onkeyup="CiarkaNaBodku(this);" style="width:95px; top:833px; left:746px;"/>
<input type="text" name="det07" id="det07" style="width:250px; top:868px; left:486px;"/>
<input type="text" name="nar07" id="nar07" onkeyup="CiarkaNaBodku(this);" style="width:95px; top:868px; left:746px;"/>
<input type="text" name="det08" id="det08" style="width:250px; top:903px; left:486px;"/>
<input type="text" name="nar08" id="nar08" onkeyup="CiarkaNaBodku(this);" style="width:95px; top:903px; left:746px;"/>
<input type="text" name="det09" id="det09" style="width:250px; top:938px; left:486px;"/>
<input type="text" name="nar09" id="nar09" onkeyup="CiarkaNaBodku(this);" style="width:95px; top:938px; left:746px;"/>
<input type="text" name="det10" id="det10" style="width:250px; top:974px; left:486px;"/>
<input type="text" name="nar10" id="nar10" onkeyup="CiarkaNaBodku(this);" style="width:95px; top:974px; left:746px;"/>
<input type="text" name="datum" id="datum" onkeyup="CiarkaNaBodku(this);" style="width:110px; top:1225px; left:141px;" />

 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
     }
//koniec uprav
?>

<?php
/////////////////////////////////////////////////VYTLAC VYHLASENIE
if ( $copern == 10 )
{
//urob sucet
$sqtoz = "UPDATE F$kli_vxcf"."_vyhlaseniedane".
" SET ".
" vyldni1=TO_DAYS(vyldo1)-TO_DAYS(vylod1)+1, vyldni2=TO_DAYS(vyldo2)-TO_DAYS(vylod2)+1, vyldni3=TO_DAYS(vyldo3)-TO_DAYS(vylod3)+1, ".
" vyldni4=TO_DAYS(vyldo4)-TO_DAYS(vylod4)+1, vyldni5=TO_DAYS(vyldo5)-TO_DAYS(vylod5)+1, ".
" vyl2dni1=TO_DAYS(vyl2do1)-TO_DAYS(vyl2od1)+1, vyl2dni2=TO_DAYS(vyl2do2)-TO_DAYS(vyl2od2)+1, vyl2dni3=TO_DAYS(vyl2do3)-TO_DAYS(vyl2od3)+1, ".
" vyl2dni4=TO_DAYS(vyl2do4)-TO_DAYS(vyl2od4)+1, vyl2dni5=TO_DAYS(vyl2do5)-TO_DAYS(vyl2od5)+1, ".
" vyl3dni1=TO_DAYS(vyl3do1)-TO_DAYS(vyl3od1)+1, vyl3dni2=TO_DAYS(vyl3do2)-TO_DAYS(vyl3od2)+1, vyl3dni3=TO_DAYS(vyl3do3)-TO_DAYS(vyl3od3)+1, ".
" vyl3dni4=TO_DAYS(vyl3do4)-TO_DAYS(vyl3od4)+1, vyl3dni5=TO_DAYS(vyl3do5)-TO_DAYS(vyl3od5)+1 ".
" WHERE oc >= 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

if ( File_Exists("../tmp/vyhlasenie.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/vyhlasenie.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_vyhlaseniedane".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_vyhlaseniedane.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_vyhlaseniedane.oc = $cislo_oc ORDER BY konx,prie,meno";
//echo $sqltt;
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

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str1.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

$zstat="Slovensko"; $zstak="703";
$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_mzdtextmzd WHERE invt = $cislo_oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zstat=$riaddok->zstat;
  $zstak=$riaddok->zstak;
  }
if ( $zstat == '' ) { $zstat="Slovensko"; }

//zamestnanec
$pdf->Cell(190,64," ","$rmc1",1,"L");
$pdf->Cell(18,4," ","$rmc1",0,"L");$pdf->Cell(63,6,"$hlavicka->prie","$rmc",0,"L");
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(38,6,"$hlavicka->meno","$rmc",0,"L");
$dar=SkDatum($hlavicka->dar);
$tlacrd="$hlavicka->rdc / $hlavicka->rdk";
if ( $tlacrd == "0 / " ) { $tlacrd="$dar"; }
$pdf->Cell(34,4," ","$rmc1",0,"L");$pdf->Cell(24,6,"$tlacrd","$rmc",1,"L");
//titul a stav
$pdf->SetFont('arial','',8);
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(45,4," ","$rmc1",0,"L");$pdf->Cell(22,5,"$hlavicka->titl","$rmc",0,"L");
$pdf->Cell(31,4," ","$rmc1",0,"L");$pdf->Cell(23,5,"$ztitz","$rmc",0,"L");
$pdf->Cell(22,4," ","$rmc1",0,"L");
if ( $hlavicka->rdstav == 0 ) { $pdf->Cell(36,5,"slobodn˝/slobodn·","$rmc",1,"L"); }
if ( $hlavicka->rdstav == 1 ) { $pdf->Cell(36,5,"ûenat˝/vydat·","$rmc",1,"L"); }
if ( $hlavicka->rdstav == 2 ) { $pdf->Cell(36,5,"vdovec/vdova","$rmc",1,"L"); }
if ( $hlavicka->rdstav == 3 ) { $pdf->Cell(36,5,"rozveden˝/rozveden·","$rmc",1,"L"); }
//adresa
$pdf->Cell(190,4," ","$rmc1",1,"L");
$pdf->Cell(27,5," ","$rmc1",0,"L");$pdf->Cell(74,4,"$hlavicka->zuli","$rmc",0,"L");
$pdf->Cell(10,5," ","$rmc1",0,"L");$pdf->Cell(28,4,"$hlavicka->zcdm","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"L");$pdf->Cell(31,4,"$hlavicka->zpsc","$rmc",1,"L");
$pdf->Cell(27,5," ","$rmc1",0,"L");$pdf->Cell(74,4,"$hlavicka->zmes","$rmc",0,"L");
$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(70,4,"$zstat","$rmc",1,"L");
$pdf->SetFont('arial','',10);

//zamestnavatel
$pdf->Cell(190,5," ","$rmc1",1,"L");
$pdf->Cell(18,5," ","$rmc1",0,"L");$pdf->Cell(161,7,"$fir_fnaz, $fir_fuli $fir_fcdm $fir_fmes","$rmc",1,"L");

//udaje NCZD
$pdf->Cell(190,17," ","$rmc1",1,"L");
$nezdx=" "; if ( $hlavicka->nezd == 1 ) { $nezdx="x"; }
$doch=" "; if ( $hlavicka->docx == 1 ) { $doch="x"; }
$pdf->Cell(170,5," ","$rmc1",0,"L");$pdf->Cell(3,3,"$nezdx","$rmc",1,"C");
$pdf->Cell(190,11," ","$rmc1",1,"L");
$pdf->Cell(170,5," ","$rmc1",0,"L");$pdf->Cell(3,4,"$doch","$rmc",1,"C");

//udaje BONUS
$pdf->Cell(190,21," ","$rmc1",1,"L");
$bonusx=" "; if ( $hlavicka->bonus == 1 ) { $bonusx="x"; }
$pdf->Cell(170,5," ","$rmc1",0,"L");$pdf->Cell(3,5,"$bonusx","$rmc",1,"C");
$pdf->SetFont('arial','',8);

$pdf->Cell(190,20," ","$rmc1",1,"L");
$nar01=SkDatum($hlavicka->nar01); if ( $nar01 == '00.00.0000' ) $nar01="";
$nar02=SkDatum($hlavicka->nar02); if ( $nar02 == '00.00.0000' ) $nar02="";
$nar03=SkDatum($hlavicka->nar03); if ( $nar03 == '00.00.0000' ) $nar03="";
$nar04=SkDatum($hlavicka->nar04); if ( $nar04 == '00.00.0000' ) $nar04="";
$nar05=SkDatum($hlavicka->nar05); if ( $nar05 == '00.00.0000' ) $nar05="";
$nar06=SkDatum($hlavicka->nar06); if ( $nar06 == '00.00.0000' ) $nar06="";
$nar07=SkDatum($hlavicka->nar07); if ( $nar07 == '00.00.0000' ) $nar07="";
$nar08=SkDatum($hlavicka->nar08); if ( $nar08 == '00.00.0000' ) $nar08="";
$nar09=SkDatum($hlavicka->nar09); if ( $nar09 == '00.00.0000' ) $nar09="";
$nar10=SkDatum($hlavicka->nar10); if ( $nar10 == '00.00.0000' ) $nar10="";
$pdf->Cell(17,4," ","$rmc1",0,"L");
$pdf->Cell(58,4,"$hlavicka->det01","$rmc",0,"L");$pdf->Cell(24,4,"$nar01","$rmc",0,"C");
$pdf->Cell(58,4,"$hlavicka->det06","$rmc",0,"L");$pdf->Cell(23,4,"$nar06","$rmc",1,"C");
$pdf->Cell(17,4," ","$rmc1",0,"L");
$pdf->Cell(58,4,"$hlavicka->det02","$rmc",0,"L");$pdf->Cell(24,4,"$nar02","$rmc",0,"C");
$pdf->Cell(58,4,"$hlavicka->det07","$rmc",0,"L");$pdf->Cell(23,4,"$nar07","$rmc",1,"C");
$pdf->Cell(17,4," ","$rmc1",0,"L");
$pdf->Cell(58,5,"$hlavicka->det03","$rmc",0,"L");$pdf->Cell(24,5,"$nar03","$rmc",0,"C");
$pdf->Cell(58,5,"$hlavicka->det08","$rmc",0,"L");$pdf->Cell(23,5,"$nar08","$rmc",1,"C");
$pdf->Cell(17,4," ","$rmc1",0,"L");
$pdf->Cell(58,4,"$hlavicka->det04","$rmc",0,"L");$pdf->Cell(24,4,"$nar04","$rmc",0,"C");
$pdf->Cell(58,4,"$hlavicka->det09","$rmc",0,"L");$pdf->Cell(23,4,"$nar09","$rmc",1,"C");
$pdf->Cell(17,4," ","$rmc1",0,"L");
$pdf->Cell(58,4,"$hlavicka->det05","$rmc",0,"L");$pdf->Cell(24,4,"$nar05","$rmc",0,"C");
$pdf->Cell(58,4,"$hlavicka->det10","$rmc",0,"L");$pdf->Cell(23,4,"$nar10","$rmc",1,"C");
$pdf->SetFont('arial','',10);

//Dna
$pdf->Cell(190,56," ","$rmc1",1,"L");
$datum=SkDatum($hlavicka->datum);
if ( $datum == '00.00.0000' ) $datum="";
$pdf->Cell(24,3," ","$rmc1",0,"L");$pdf->Cell(60,6,"$datum","$rmc",1,"C");
                                       } //koniec 1.strany

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