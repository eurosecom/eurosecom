<!doctype html>
<html>
<?php
//celkovy zaciatok dokumentu DPPO v.2018
  do
  {
$sys = 'UCT';
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

$zablokovane=0;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("DaÚovÈ priznanie bude pripravenÈ v priebehu janu·ra 2019. Aktu·lne info n·jdete na vstupnej str·nke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

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

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$strana = 1*$_REQUEST['strana'];
$stranax = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=1;
if ( $copern == 101 ) { $copern=102; }
$xml = 1*$_REQUEST['xml'];
$prepocitaj = 1*$_REQUEST['prepocitaj'];

//jpg source
$jpg_source="../dokumenty/tlacivo2018/dppo/dppo_v18";
$jpg_title="tlaËivo DaÚ z prÌjmov PO pre rok $kli_vrok $strana.strana";

//nacitanie minuleho roka do PO
  if ( $copern == 3155 ) { ?>
<script type="text/javascript">
if ( !confirm ("Chcete naËÌtaù ˙daje do DPPO z firmy minulÈho roka ?") )
         { window.close() }
else
         { location.href='priznanie_po2018.php?copern=3156&drupoh=1&cislo_oc=<?php echo $cislo_oc; ?>' }
</script>
<?php                    }

    if ( $copern == 3156 )
    {
$h_ycf=0;
if ( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");

//nerezident  zahrprep  pruli  prcdm  prpsc  prmes  prpoc
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po,".$databaza."F$h_ycf"."_uctpriznanie_po SET ".
" F$kli_vxcf"."_uctpriznanie_po.ooprie=".$databaza."F$h_ycf"."_uctpriznanie_po.ooprie, ".
" F$kli_vxcf"."_uctpriznanie_po.oomeno=".$databaza."F$h_ycf"."_uctpriznanie_po.oomeno, ".
" F$kli_vxcf"."_uctpriznanie_po.ootitl=".$databaza."F$h_ycf"."_uctpriznanie_po.ootitl, ".
" F$kli_vxcf"."_uctpriznanie_po.oopost=".$databaza."F$h_ycf"."_uctpriznanie_po.oopost, ".

" F$kli_vxcf"."_uctpriznanie_po.oouli=".$databaza."F$h_ycf"."_uctpriznanie_po.oouli, ".
" F$kli_vxcf"."_uctpriznanie_po.oocdm=".$databaza."F$h_ycf"."_uctpriznanie_po.oocdm, ".
" F$kli_vxcf"."_uctpriznanie_po.oomes=".$databaza."F$h_ycf"."_uctpriznanie_po.oomes, ".
" F$kli_vxcf"."_uctpriznanie_po.oopsc=".$databaza."F$h_ycf"."_uctpriznanie_po.oopsc, ".
" F$kli_vxcf"."_uctpriznanie_po.ootel=".$databaza."F$h_ycf"."_uctpriznanie_po.ootel, ".
" F$kli_vxcf"."_uctpriznanie_po.oofax=".$databaza."F$h_ycf"."_uctpriznanie_po.oofax, ".
" F$kli_vxcf"."_uctpriznanie_po.oostat=".$databaza."F$h_ycf"."_uctpriznanie_po.oostat, ".

" F$kli_vxcf"."_uctpriznanie_po.pril=".$databaza."F$h_ycf"."_uctpriznanie_po.pril, ".
" F$kli_vxcf"."_uctpriznanie_po.vypprie=".$databaza."F$h_ycf"."_uctpriznanie_po.vypprie, ".
" F$kli_vxcf"."_uctpriznanie_po.vyptel=".$databaza."F$h_ycf"."_uctpriznanie_po.vyptel, ".

" F$kli_vxcf"."_uctpriznanie_po.xstat=".$databaza."F$h_ycf"."_uctpriznanie_po.xstat, ".
" F$kli_vxcf"."_uctpriznanie_po.prpoc=".$databaza."F$h_ycf"."_uctpriznanie_po.prpoc, ".
" F$kli_vxcf"."_uctpriznanie_po.prmes=".$databaza."F$h_ycf"."_uctpriznanie_po.prmes, ".
" F$kli_vxcf"."_uctpriznanie_po.prpsc=".$databaza."F$h_ycf"."_uctpriznanie_po.prpsc, ".
" F$kli_vxcf"."_uctpriznanie_po.prcdm=".$databaza."F$h_ycf"."_uctpriznanie_po.prcdm, ".
" F$kli_vxcf"."_uctpriznanie_po.pruli=".$databaza."F$h_ycf"."_uctpriznanie_po.pruli, ".
" F$kli_vxcf"."_uctpriznanie_po.zahrprep=".$databaza."F$h_ycf"."_uctpriznanie_po.zahrprep, ".
" F$kli_vxcf"."_uctpriznanie_po.nerezident=".$databaza."F$h_ycf"."_uctpriznanie_po.nerezident, ".
" F$kli_vxcf"."_uctpriznanie_po.cinnost=".$databaza."F$h_ycf"."_uctpriznanie_po.cinnost  ".
" WHERE F$kli_vxcf"."_uctpriznanie_po.psys >= 0 ";
$upravene = mysql_query("$uprtxt");
//echo $uprtxt;

$copern=102;
//koniec nacitania celeho minuleho roka do PO
    }

//pracovny subor
$sql = "SELECT fstat FROM F".$kli_vxcf."_ufirdalsie";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD fstat VARCHAR(30) DEFAULT 'SR' AFTER kkx";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT d7r01 FROM F$kli_vxcf"."_uctpriznanie_po WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_uctpriznanie_po';
$vytvor = mysql_query("$vsql");
$sqlt = <<<priznaniepo
(
   psys         INT DEFAULT 0,
   druh         INT DEFAULT 0,
   cinnost      VARCHAR(80) NOT NULL,
   oznucet      INT DEFAULT 0,
   nerezident   INT DEFAULT 0,
   zahrprep     INT DEFAULT 0,
   pruli        VARCHAR(80) NOT NULL,
   prcdm        VARCHAR(20) NOT NULL,
   prpsc        VARCHAR(10) NOT NULL,
   prmes        VARCHAR(80) NOT NULL,
   prpoc        INT DEFAULT 0,
   str2         INT DEFAULT 0,
   r100         DECIMAL(10,2) DEFAULT 0,
   r110         DECIMAL(10,2) DEFAULT 0,
   r120         DECIMAL(10,2) DEFAULT 0,
   r130         DECIMAL(10,2) DEFAULT 0,
   r140         DECIMAL(10,2) DEFAULT 0,
   r150         DECIMAL(10,2) DEFAULT 0,
   r160         DECIMAL(10,2) DEFAULT 0,
   r170         DECIMAL(10,2) DEFAULT 0,
   r180         DECIMAL(10,2) DEFAULT 0,
   r190         DECIMAL(10,2) DEFAULT 0,
   r200         DECIMAL(10,2) DEFAULT 0,
   r210         DECIMAL(10,2) DEFAULT 0,
   r220         DECIMAL(10,2) DEFAULT 0,
   r230         DECIMAL(10,2) DEFAULT 0,
   r240         DECIMAL(10,2) DEFAULT 0,
   r250         DECIMAL(10,2) DEFAULT 0,
   r260         DECIMAL(10,2) DEFAULT 0,
   r270         DECIMAL(10,2) DEFAULT 0,
   r280         DECIMAL(10,2) DEFAULT 0,
   r290         DECIMAL(10,2) DEFAULT 0,
   r300         DECIMAL(10,2) DEFAULT 0,
   r310         DECIMAL(10,2) DEFAULT 0,
   r320         DECIMAL(10,2) DEFAULT 0,
   r330         DECIMAL(10,2) DEFAULT 0,
   r400         DECIMAL(10,2) DEFAULT 0,
   str3         INT DEFAULT 0,
   r410         DECIMAL(10,2) DEFAULT 0,
   r500         DECIMAL(10,2) DEFAULT 0,
   r510         DECIMAL(10,2) DEFAULT 0,
   r600         DECIMAL(10,2) DEFAULT 0,
   r610         DECIMAL(10,2) DEFAULT 0,
   r700         DECIMAL(10,2) DEFAULT 0,
   r710         DECIMAL(10,2) DEFAULT 0,
   r800         DECIMAL(10,2) DEFAULT 0,
   r810         DECIMAL(10,2) DEFAULT 0,
   r820         DECIMAL(10,2) DEFAULT 0,
   r830         DECIMAL(10,2) DEFAULT 0,
   r840         DECIMAL(10,2) DEFAULT 0,
   r850         DECIMAL(10,2) DEFAULT 0,
   r900         DECIMAL(10,2) DEFAULT 0,
   r901         DECIMAL(10,2) DEFAULT 0,
   r910         DECIMAL(10,2) DEFAULT 0,
   r920         DECIMAL(10,2) DEFAULT 0,
   r930         DECIMAL(10,2) DEFAULT 0,
   r940         DECIMAL(10,2) DEFAULT 0,
   r950         DECIMAL(10,2) DEFAULT 0,
   r960         DECIMAL(10,2) DEFAULT 0,
   r970         DECIMAL(10,2) DEFAULT 0,
   str4         INT DEFAULT 0,
   a1r01        DECIMAL(10,2) DEFAULT 0,
   a1r02        DECIMAL(10,2) DEFAULT 0,
   a1r03        DECIMAL(10,2) DEFAULT 0,
   a1r04        DECIMAL(10,2) DEFAULT 0,
   a1r05        DECIMAL(10,2) DEFAULT 0,
   a1r06        DECIMAL(10,2) DEFAULT 0,
   a1r07        DECIMAL(10,2) DEFAULT 0,
   a1r08        DECIMAL(10,2) DEFAULT 0,
   a1r09        DECIMAL(10,2) DEFAULT 0,
   a1r10        DECIMAL(10,2) DEFAULT 0,
   a1r11        DECIMAL(10,2) DEFAULT 0,
   a1r12        DECIMAL(10,2) DEFAULT 0,
   a1r13        DECIMAL(10,2) DEFAULT 0,
   a1r14        DECIMAL(10,2) DEFAULT 0,
   a1r15        DECIMAL(10,2) DEFAULT 0,
   b1r01        DECIMAL(10,2) DEFAULT 0,
   b1r02        DECIMAL(10,2) DEFAULT 0,
   b1r03        DECIMAL(10,2) DEFAULT 0,
   c1r01        DECIMAL(10,2) DEFAULT 0,
   c1r02        DECIMAL(10,2) DEFAULT 0,
   c1r03        DECIMAL(10,2) DEFAULT 0,
   c1r04        DECIMAL(10,2) DEFAULT 0,
   c1r05        DECIMAL(10,2) DEFAULT 0,
   str5         INT DEFAULT 0,
   c2r01        DECIMAL(10,2) DEFAULT 0,
   c2r02        DECIMAL(10,2) DEFAULT 0,
   c2r03        DECIMAL(10,2) DEFAULT 0,
   c2r04        DECIMAL(10,2) DEFAULT 0,
   c2r05        DECIMAL(10,2) DEFAULT 0,
   d1r01        DECIMAL(4,0)  DEFAULT 0,
   d1r02        DECIMAL(10,2) DEFAULT 0,
   d1r03        DECIMAL(10,2) DEFAULT 0,
   d1r04        DECIMAL(10,2) DEFAULT 0,
   d1r05        DECIMAL(10,2) DEFAULT 0,
   d2r01        DECIMAL(4,0)  DEFAULT 0,
   d2r02        DECIMAL(10,2) DEFAULT 0,
   d2r03        DECIMAL(10,2) DEFAULT 0,
   d2r04        DECIMAL(10,2) DEFAULT 0,
   d2r05        DECIMAL(10,2) DEFAULT 0,
   d3r01        DECIMAL(4,0)  DEFAULT 0,
   d3r02        DECIMAL(10,2) DEFAULT 0,
   d3r03        DECIMAL(10,2) DEFAULT 0,
   d3r04        DECIMAL(10,2) DEFAULT 0,
   d3r05        DECIMAL(10,2) DEFAULT 0,
   d4r01        DECIMAL(4,0)  DEFAULT 0,
   d4r02        DECIMAL(10,2) DEFAULT 0,
   d4r03        DECIMAL(10,2) DEFAULT 0,
   d4r04        DECIMAL(10,2) DEFAULT 0,
   d4r05        DECIMAL(10,2) DEFAULT 0,
   d5r01        DECIMAL(4,0)  DEFAULT 0,
   d5r02        DECIMAL(10,2) DEFAULT 0,
   d5r03        DECIMAL(10,2) DEFAULT 0,
   d5r04        DECIMAL(10,2) DEFAULT 0,
   d5r05        DECIMAL(10,2) DEFAULT 0,
   d6r01        DECIMAL(4,0)  DEFAULT 0,
   d6r02        DECIMAL(10,2) DEFAULT 0,
   d6r03        DECIMAL(10,2) DEFAULT 0,
   d6r04        DECIMAL(10,2) DEFAULT 0,
   d6r05        DECIMAL(10,2) DEFAULT 0,
   d7r01        DECIMAL(4,0)  DEFAULT 0,
   d7r02        DECIMAL(10,2) DEFAULT 0,
   d7r03        DECIMAL(10,2) DEFAULT 0,
   d7r04        DECIMAL(10,2) DEFAULT 0,
   d7r05        DECIMAL(10,2) DEFAULT 0,
   e1r01        DECIMAL(10,2) DEFAULT 0,
   e1r02        DECIMAL(10,2) DEFAULT 0,
   e1r03        DECIMAL(10,2) DEFAULT 0,
   str6         INT DEFAULT 0,
   e1r04        DECIMAL(10,2) DEFAULT 0,
   e1r05        DECIMAL(10,2) DEFAULT 0,
   e1r06        DECIMAL(10,2) DEFAULT 0,
   f1r01        DECIMAL(10,2) DEFAULT 0,
   f1r02        DECIMAL(10,2) DEFAULT 0,
   f1r03        DECIMAL(10,2) DEFAULT 0,
   g1r01        DECIMAL(10,2) DEFAULT 0,
   g1r02        DECIMAL(10,2) DEFAULT 0,
   g1r03        DECIMAL(10,2) DEFAULT 0,
   g2r01        DECIMAL(10,2) DEFAULT 0,
   g2r02        DECIMAL(10,2) DEFAULT 0,
   g2r03        DECIMAL(10,2) DEFAULT 0,
   g3r01        DECIMAL(10,2) DEFAULT 0,
   g3r02        DECIMAL(10,2) DEFAULT 0,
   g3r03        DECIMAL(10,2) DEFAULT 0,
   g3r04        DECIMAL(10,2) DEFAULT 0,
   str7         INT DEFAULT 0,
   h1r01        DECIMAL(4,0)  DEFAULT 0,
   h1r02        DECIMAL(10,2) DEFAULT 0,
   h1r03        DECIMAL(10,2) DEFAULT 0,
   h1r04        DECIMAL(10,2) DEFAULT 0,
   h1r05        DECIMAL(10,2) DEFAULT 0,
   h1r06        DECIMAL(10,2) DEFAULT 0,
   h1r07        DECIMAL(10,2) DEFAULT 0,
   h2r01        DECIMAL(4,0)  DEFAULT 0,
   h2r02        DECIMAL(10,2) DEFAULT 0,
   h2r03        DECIMAL(10,2) DEFAULT 0,
   h2r04        DECIMAL(10,2) DEFAULT 0,
   h2r05        DECIMAL(10,2) DEFAULT 0,
   h2r06        DECIMAL(10,2) DEFAULT 0,
   h2r07        DECIMAL(10,2) DEFAULT 0,
   pcpod        DECIMAL(10,2) DEFAULT 0,
   pcpoc        DECIMAL(2,0) DEFAULT 0,
   pcsum        DECIMAL(10,2) DEFAULT 0,
   p1ico        DECIMAL(10,0) DEFAULT 0,
   p1sid        DECIMAL(4,0) DEFAULT 0,
   p1pfr        VARCHAR(60) NOT NULL,
   p1men        VARCHAR(60) NOT NULL,
   p1uli        VARCHAR(60) NOT NULL,
   p1cdm        VARCHAR(20) NOT NULL,
   p1psc        VARCHAR(10) NOT NULL,
   p1mes        VARCHAR(60) NOT NULL,
   str8         INT DEFAULT 0,
   osobit       TEXT,
   ooprie       VARCHAR(60) NOT NULL,
   oomeno       VARCHAR(60) NOT NULL,
   ootitl       VARCHAR(20) NOT NULL,
   oopost       VARCHAR(60) NOT NULL,
   oouli        VARCHAR(60) NOT NULL,
   oocdm        VARCHAR(20) NOT NULL,
   oopsc        VARCHAR(10) NOT NULL,
   oomes        VARCHAR(60) NOT NULL,
   ootel        VARCHAR(30) NOT NULL,
   oofax        VARCHAR(30) NOT NULL,
   pril         DECIMAL(2,0)  DEFAULT 0,
   datum        DATE,
   datup        DATE,
   vrat         DECIMAL(1,0)  DEFAULT 0,
   vrpp         DECIMAL(1,0)  DEFAULT 0,
   vruc         DECIMAL(1,0)  DEFAULT 0,
   datuk        DATE,
   ico          DECIMAL(8,0)  DEFAULT 0
);
priznaniepo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctpriznanie_po'.$sqlt;
$vytvor = mysql_query("$vsql");
$ttvv = "INSERT INTO F$kli_vxcf"."_uctpriznanie_po ( ico ) VALUES ( '0' )";
$ttqq = mysql_query("$ttvv");
}
$sql = "SELECT konx3 FROM F$kli_vxcf"."_uctpriznanie_po WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r610text VARCHAR(60) NOT NULL AFTER r610";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD dadod DATE AFTER r910";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzano INT DEFAULT 0 AFTER h2r07";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY h1r01 DECIMAL(10,2)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY h2r01 DECIMAL(10,2)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzanox INT DEFAULT 0 AFTER h2r07";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD vypprie VARCHAR(30) NOT NULL AFTER datup";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD vyptel VARCHAR(30) NOT NULL AFTER datup";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY r510 DECIMAL(2,0)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD konx3 VARCHAR(30) NOT NULL AFTER datuk";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT konx4 FROM F$kli_vxcf"."_uctpriznanie_po WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD konx4 VARCHAR(30) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u14 VARCHAR(30) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u13 VARCHAR(30) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u12 VARCHAR(30) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u11 VARCHAR(30) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u10 VARCHAR(30) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u09 VARCHAR(30) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u01 VARCHAR(30) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u08 VARCHAR(30) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u07 VARCHAR(30) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u06 VARCHAR(30) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u05 VARCHAR(30) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u04 VARCHAR(30) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u03 VARCHAR(30) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u02 VARCHAR(30) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u01 VARCHAR(30) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT obdd1 FROM F$kli_vxcf"."_uctpriznanie_po WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD obmr2 VARCHAR(2) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD obmm2 VARCHAR(2) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD obmd2 VARCHAR(2) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD obmr1 VARCHAR(2) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD obmm1 VARCHAR(2) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD obmd1 VARCHAR(2) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD obdr2 VARCHAR(2) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD obdm2 VARCHAR(2) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD obdd2 VARCHAR(2) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD obdr1 VARCHAR(2) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD obdm1 VARCHAR(2) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD obdd1 VARCHAR(2) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT xstat FROM F$kli_vxcf"."_uctpriznanie_po WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD xstat VARCHAR(20) NOT NULL AFTER konx3";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT rzzaklad FROM F$kli_vxcf"."_uctpriznanie_po WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD rzstala DECIMAL(10,2) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD rz1r02 DECIMAL(10,2) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD rz2r02 DECIMAL(10,2) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD rz1r03 DECIMAL(10,2) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD rz2r03 DECIMAL(10,2) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD rz1r04 DECIMAL(10,2) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD rz2r04 DECIMAL(10,2) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD rz1r05 DECIMAL(10,2) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD rz2r05 DECIMAL(10,2) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD rzzaklad DECIMAL(10,2) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT pcdar FROM F$kli_vxcf"."_uctpriznanie_po WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pc15 DECIMAL(10,2) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pcdar DECIMAL(10,2) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT oostat FROM F$kli_vxcf"."_uctpriznanie_po WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD oostat VARCHAR(20) NOT NULL AFTER oofax";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT j1r08 FROM F$kli_vxcf"."_uctpriznanie_po WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD b1r04 DECIMAL(10,2) DEFAULT 0 AFTER oofax";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD j1r01 DECIMAL(10,2) DEFAULT 0 AFTER oofax";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD j1r02 DECIMAL(10,2) DEFAULT 0 AFTER oofax";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD j1r03 DECIMAL(10,2) DEFAULT 0 AFTER oofax";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD j1r06 DECIMAL(10,2) DEFAULT 0 AFTER oofax";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD j1r07 DECIMAL(10,2) DEFAULT 0 AFTER oofax";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD j1r08 DECIMAL(10,2) DEFAULT 0 AFTER oofax";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT vrnum FROM F$kli_vxcf"."_uctpriznanie_po WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD vrucet VARCHAR(20) NOT NULL AFTER oofax";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD vrnum VARCHAR(4) NOT NULL AFTER oofax";
$vysledek = mysql_query("$sql");
}
//zmeny 2013
$sql = "SELECT dbic FROM F$kli_vxcf"."_uctpriznanie_po WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD new2013 DECIMAL(2,0) DEFAULT 0 AFTER rzstala";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD dbic VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT pzs01 FROM F".$kli_vxcf."_uctpriznanie_po";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
//str1
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD uoskr DECIMAL(4,0) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD koskr DECIMAL(4,0) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD dmailfax VARCHAR(50) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
//str5
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d8r01 DECIMAL(4,0) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d8r02 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d8r03 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d8r04 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d8r05 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
//str9
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD diban VARCHAR(40) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD otitz VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD omailfax VARCHAR(50) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
//cela10
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzdat DATE NOT NULL AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzr16 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzr15 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzr14 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzr13 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzr12 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzr11 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzr10 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzr09 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzr08 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzr07 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzr06 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzr05 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzd04 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzd03 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzd02 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzs04 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzs03 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzs02 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pzs01 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT r860 FROM F".$kli_vxcf."_uctpriznanie_po";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD obod DATE NOT NULL AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD obdo DATE NOT NULL AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r860 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT hr06 FROM F".$kli_vxcf."_uctpriznanie_po";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD i1r01 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD i1r02 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD i1r03 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD i1r04 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD i1r05 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD i1r06 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD i1r07 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD i2r01 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD i2r02 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD i2r03 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD i2r04 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD i2r05 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD i2r06 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD i2r07 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD hr01 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD hr06 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
}
//zmeny 2014
$sql = "SELECT opr01 FROM F".$kli_vxcf."_uctpriznanie_po";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD new2014 DECIMAL(2,0) NOT NULL AFTER pzdat";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD chpld DECIMAL(2,0) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD cho5k DECIMAL(2,0) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD chpdl DECIMAL(2,0) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD chndl DECIMAL(2,0) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1000 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1001 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1010 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1020 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1030 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1040 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1050 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1060 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1070 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
//str5
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d1r06 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d1r07 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d2r06 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d2r07 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
//str6
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d3od DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d3do DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d4od DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d4do DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d5od DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d5do DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d3r06 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d4r06 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d5r06 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d6r06 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
//str7
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD h1r06 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD h2r06 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD h1r07 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD h2r07 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD h1r08 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD h2r08 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD h1r09 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD h2r09 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD hr10 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");

//str8
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD jl1r01 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD jl1r02 DECIMAL(10,0) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD jl1r03 DECIMAL(10,0) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD jl1r04 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD jl1r05 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k1od DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k1do DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k2od DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k2do DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k3od DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k3do DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k4od DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k4do DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k2r01 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k5r01 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k2r02 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k4r02 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k5r02 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k2r03 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k3r03 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k4r03 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k5r03 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k2r04 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k3r04 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k4r04 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k5r04 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");;
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k4r05 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k5r05 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");

//str9
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pc155 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pcdar5 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pcpod5 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");

//opravy
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY r810 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY r820 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY r840 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY r900 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD opr01 DECIMAL(2,0) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
}
//zmeny 2015
$sql = "SELECT zmx1 FROM F".$kli_vxcf."_uctpriznanie_po";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD new2015 DECIMAL(2,0) NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r301 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r302 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r303 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r304 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r305 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r501 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r550 DECIMAL(10,0) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1100 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1101 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1110 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1120 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1130 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1140 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1150 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1r16 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1r17 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u15 VARCHAR(30) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD a1u16 VARCHAR(30) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD b1r05 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD b1r06 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d2od DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d2do DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d6od DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d6do DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD jr01 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD jr02 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k3r01 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k4r01 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD k3r02 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY r510 DECIMAL(10,2) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY r820 DECIMAL(10,2) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY r830 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY d1r01 DECIMAL(10,2) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY d2r01 DECIMAL(10,2) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY d3r01 DECIMAL(10,2) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY d4r01 DECIMAL(10,2) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY d5r01 DECIMAL(10,2) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY d6r01 DECIMAL(10,2) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY pcpoc DECIMAL(4,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD zapdl DECIMAL(2,0) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD zslu DECIMAL(2,0) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD zmx1 DECIMAL(2,0) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
}
//zmeny 2017
$sql = "SELECT alla2017 FROM F".$kli_vxcf."_uctpriznanie_po";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD new2017 DECIMAL(2,0) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r306 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r307 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1061 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1062 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1080 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1090 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1160 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1170 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1180 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r1190 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d7od DATE NOT NULL AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d7do DATE NOT NULL AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d8od DATE NOT NULL AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d8do DATE NOT NULL AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d9r02 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d9r03 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps1r01 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps2r01 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps1r02 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps2r02 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps1r03 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps2r03 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps1r04 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps2r04 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps1r05 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps2r05 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps1r06 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps2r06 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr07 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr08 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr09 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr10 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr11 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr12 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr13 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps1r14 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps2r14 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps1r15 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps2r15 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps1r16 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps2r16 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps1r17 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps2r17 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps1r18 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps2r18 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps1r19 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ps2r19 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr20 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr21 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr22 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr23 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr24 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr25 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr26 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr27 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr29 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr30 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD psr31 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozd1r01 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozd1r02 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozd1r03 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozd1r04 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozd2r04 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozd1r05 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozd2r05 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozd1r06 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozd2r06 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozdr07 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozdr09 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pcdan DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD osldan DECIMAL(1,0) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozdspl DECIMAL(1,0) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozdspl1dat DATE NOT NULL AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozdspl1sum DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozdspl2dat DATE NOT NULL AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozdspl2sum DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozdspl3dat DATE NOT NULL AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozdspl3sum DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozdspl4dat DATE NOT NULL AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozdspl4sum DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozdspl5dat DATE NOT NULL AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozdspl5sum DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD ozdspldat DATE NOT NULL AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY d7r01 DECIMAL(10,2) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY d8r01 DECIMAL(10,2) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po MODIFY p1ico DECIMAL(12,0) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD alla2017 DECIMAL(1,0) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
}
//zmeny 2018
$sql = "SELECT vosspl FROM F".$kli_vxcf."_uctpriznanie_po";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD new2018 DECIMAL(2,0) NOT NULL AFTER chpld";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD osl13 DECIMAL(2,0) NOT NULL AFTER new2018";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD r308 DECIMAL(10,2) DEFAULT 0 AFTER new2018";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD d9r01 DECIMAL(10,2) DEFAULT 0 AFTER new2018";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD vos13a DECIMAL(10,2) DEFAULT 0 AFTER new2018";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD vos13b DECIMAL(10,2) DEFAULT 0 AFTER new2018";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pat13a TEXT NOT NULL AFTER new2018";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD pat13b TEXT NOT NULL AFTER new2018";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_po ADD vosspl DECIMAL(10,2) DEFAULT 0 AFTER new2018";
$vysledek = mysql_query("$sql");

}
//koniec pracovny def subor

//nacitanie udajov do riadkov tab III
if ( $copern == 266 )
{
$h_riadok = strip_tags($_REQUEST['h_riadok']);

$vsql = 'DROP TABLE F'.$kli_vxcf.'_prizprac'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$sqlt = <<<prizprac
(
   drh          DECIMAL(3,0) DEFAULT 0,
   ucx          VARCHAR(11),
   hox          DECIMAL(10,2),
   ico          DECIMAL(10,0)
);
prizprac;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prizprac'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctpriznanie_po");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  if ( $h_riadok == 1 ) { $ucetx=$riaddok->a1u01; }
  if ( $h_riadok == 2 ) { $ucetx=$riaddok->a1u02; }
  if ( $h_riadok == 3 ) { $ucetx=$riaddok->a1u03; }
  if ( $h_riadok == 4 ) { $ucetx=$riaddok->a1u04; }
  if ( $h_riadok == 5 ) { $ucetx=$riaddok->a1u05; }
  if ( $h_riadok == 6 ) { $ucetx=$riaddok->a1u06; }
  if ( $h_riadok == 7 ) { $ucetx=$riaddok->a1u07; }
  if ( $h_riadok == 8 ) { $ucetx=$riaddok->a1u08; }
  if ( $h_riadok == 9 ) { $ucetx=$riaddok->a1u09; }
  if ( $h_riadok == 10 ) { $ucetx=$riaddok->a1u10; }
  if ( $h_riadok == 11 ) { $ucetx=$riaddok->a1u11; }
  if ( $h_riadok == 12 ) { $ucetx=$riaddok->a1u12; }
  if ( $h_riadok == 13 ) { $ucetx=$riaddok->a1u13; }
  if ( $h_riadok == 14 ) { $ucetx=$riaddok->a1u14; }
  if ( $h_riadok == 15 ) { $ucetx=$riaddok->a1u15; }
  if ( $h_riadok == 16 ) { $ucetx=$riaddok->a1u16; }
  }

$podmmd="( ucm > 0 )";
$podmdl="( ucd > 0 )";

$pole = explode(",", $ucetx);

$cislo=1*$pole[0]; if ( $cislo > 0 ) { $podmmd=$podmmd." AND ( ucm = $pole[0] "; $podmdl=$podmdl." AND ( ucd = $pole[0] "; }
$cislo=1*$pole[1]; if ( $cislo > 0 ) { $podmmd=$podmmd." OR ucm = $pole[1] "; $podmdl=$podmdl." OR ucd = $pole[1] "; }
$cislo=1*$pole[2]; if ( $cislo > 0 ) { $podmmd=$podmmd." OR ucm = $pole[2] "; $podmdl=$podmdl." OR ucd = $pole[2] "; }
$cislo=1*$pole[3]; if ( $cislo > 0 ) { $podmmd=$podmmd." OR ucm = $pole[3] "; $podmdl=$podmdl." OR ucd = $pole[3] "; }
$cislo=1*$pole[4]; if ( $cislo > 0 ) { $podmmd=$podmmd." OR ucm = $pole[4] "; $podmdl=$podmdl." OR ucd = $pole[4] "; }

$podmmd=$podmmd." ) ";
$podmdl=$podmdl." ) ";
//echo $podmmd;
//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucm,hod,0 FROM F$kli_vxcf"."_uctodb WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucd,-hod,0 FROM F$kli_vxcf"."_uctodb WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucm,hod,0 FROM F$kli_vxcf"."_uctdod WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucd,-hod,0 FROM F$kli_vxcf"."_uctdod WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucm,hod,0 FROM F$kli_vxcf"."_uctpokuct WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucd,-hod,0 FROM F$kli_vxcf"."_uctpokuct WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucm,hod,0 FROM F$kli_vxcf"."_uctban WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucd,-hod,0 FROM F$kli_vxcf"."_uctban WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucm,hod,0 FROM F$kli_vxcf"."_uctvsdp WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucd,-hod,0 FROM F$kli_vxcf"."_uctvsdp WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucm,hod,0 FROM F$kli_vxcf"."_uctmzd WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucd,-hod,0 FROM F$kli_vxcf"."_uctmzd WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucm,hod,0 FROM F$kli_vxcf"."_uctskl WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucd,-hod,0 FROM F$kli_vxcf"."_uctskl WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucm,hod,0 FROM F$kli_vxcf"."_uctmaj WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucd,-hod,0 FROM F$kli_vxcf"."_uctmaj WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid "." SELECT".
" 998,0,SUM(hox),0 ".
" FROM F$kli_vxcf"."_prizprac$kli_uzid".
" WHERE drh = 0 ".
" GROUP BY drh";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

$a1r01=0; $a1r02=0; $a1r03=0; $a1r04=0; $a1r05=0; $a1r06=0; $a1r07=0; $a1r08=0; $a1r09=0; $a1r10=0;
$a1r11=0; $a1r12=0; $a1r13=0; $a1r14=0; $a1r15=0; $a1r16=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prizprac$kli_uzid WHERE drh = 998";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql);

if ( $h_riadok == 1 ) { $a1r01=$a1r01+$polozka->hox; }
if ( $h_riadok == 2 ) { $a1r02=$a1r02+$polozka->hox; }
if ( $h_riadok == 3 ) { $a1r03=$a1r03+$polozka->hox; }
if ( $h_riadok == 4 ) { $a1r04=$a1r04+$polozka->hox; }
if ( $h_riadok == 5 ) { $a1r05=$a1r05+$polozka->hox; }
if ( $h_riadok == 6 ) { $a1r06=$a1r06+$polozka->hox; }
if ( $h_riadok == 7 ) { $a1r07=$a1r07+$polozka->hox; }
if ( $h_riadok == 8 ) { $a1r08=$a1r08+$polozka->hox; }
if ( $h_riadok == 9 ) { $a1r09=$a1r09+$polozka->hox; }
if ( $h_riadok == 10 ) { $a1r10=$a1r10+$polozka->hox; }
if ( $h_riadok == 11 ) { $a1r11=$a1r11+$polozka->hox; }
if ( $h_riadok == 12 ) { $a1r12=$a1r12+$polozka->hox; }
if ( $h_riadok == 13 ) { $a1r13=$a1r13+$polozka->hox; }
if ( $h_riadok == 14 ) { $a1r14=$a1r14+$polozka->hox; }
if ( $h_riadok == 15 ) { $a1r15=$a1r15+$polozka->hox; }
if ( $h_riadok == 16 ) { $a1r16=$a1r16+$polozka->hox; }
                                       }
$i=$i+1;                  }

//zapis
if ( $h_riadok == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET a1r01='$a1r01', psys=0  WHERE ico >= 0"; }
if ( $h_riadok == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET a1r02='$a1r02', psys=0  WHERE ico >= 0"; }
if ( $h_riadok == 3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET a1r03='$a1r03', psys=0  WHERE ico >= 0"; }
if ( $h_riadok == 4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET a1r04='$a1r04', psys=0  WHERE ico >= 0"; }
if ( $h_riadok == 5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET a1r05='$a1r05', psys=0  WHERE ico >= 0"; }
if ( $h_riadok == 6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET a1r06='$a1r06', psys=0  WHERE ico >= 0"; }
if ( $h_riadok == 7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET a1r07='$a1r07', psys=0  WHERE ico >= 0"; }
if ( $h_riadok == 8 ) { $uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET a1r08='$a1r08', psys=0  WHERE ico >= 0"; }
if ( $h_riadok == 9 ) { $uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET a1r09='$a1r09', psys=0  WHERE ico >= 0"; }
if ( $h_riadok == 10 ) { $uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET a1r10='$a1r10', psys=0  WHERE ico >= 0"; }
if ( $h_riadok == 11 ) { $uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET a1r11='$a1r11', psys=0  WHERE ico >= 0"; }
if ( $h_riadok == 12 ) { $uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET a1r12='$a1r12', psys=0  WHERE ico >= 0"; }
if ( $h_riadok == 13 ) { $uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET a1r13='$a1r13', psys=0  WHERE ico >= 0"; }
if ( $h_riadok == 14 ) { $uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET a1r14='$a1r14', psys=0  WHERE ico >= 0"; }
if ( $h_riadok == 15 ) { $uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET a1r15='$a1r15', psys=0  WHERE ico >= 0"; }
if ( $h_riadok == 16 ) { $uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET a1r16='$a1r16', psys=0  WHERE ico >= 0"; }
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" a1r17=a1r01+a1r02+a1r03+a1r04+a1r05+a1r06+a1r07+a1r08+a1r09+a1r10+a1r11+a1r12+a1r13+a1r14+a1r15+a1r16, r130=a1r17 WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");
//echo $uprtxt;
//exit;

$vsql = 'DROP TABLE F'.$kli_vxcf.'_prizprac'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$prepocitaj=1;
$copern=102;
$strana=5;
}
//koniec nacitania

//zapis a prepni do zostavy
$dppo = strip_tags($_REQUEST['dppo']);
if ( $copern == 200 AND $dppo == 1 )
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_prizprac'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$sqlt = <<<prizprac
(
   drh          DECIMAL(3,0) DEFAULT 0,
   ucx          VARCHAR(11),
   hox          DECIMAL(10,2),
   ico          DECIMAL(10,0)
);
prizprac;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prizprac'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$podmmd="( ( LEFT(ucm,1) = 5 OR LEFT(ucm,1) = 6 ) AND ( LEFT(ucm,2) != 59 ) ) ";
$podmdl="( ( LEFT(ucd,1) = 5 OR LEFT(ucd,1) = 6 ) AND ( LEFT(ucd,2) != 59 ) ) ";

$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucm,-hod,0 FROM F$kli_vxcf"."_uctodb WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucd,hod,0 FROM F$kli_vxcf"."_uctodb WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucm,-hod,0 FROM F$kli_vxcf"."_uctdod WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucd,hod,0 FROM F$kli_vxcf"."_uctdod WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucm,-hod,0 FROM F$kli_vxcf"."_uctpokuct WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucd,hod,0 FROM F$kli_vxcf"."_uctpokuct WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucm,-hod,0 FROM F$kli_vxcf"."_uctban WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucd,hod,0 FROM F$kli_vxcf"."_uctban WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucm,-hod,0 FROM F$kli_vxcf"."_uctvsdp WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucd,hod,0 FROM F$kli_vxcf"."_uctvsdp WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucm,-hod,0 FROM F$kli_vxcf"."_uctmzd WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucd,hod,0 FROM F$kli_vxcf"."_uctmzd WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucm,-hod,0 FROM F$kli_vxcf"."_uctskl WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucd,hod,0 FROM F$kli_vxcf"."_uctskl WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucm,-hod,0 FROM F$kli_vxcf"."_uctmaj WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 0,ucd,hod,0 FROM F$kli_vxcf"."_uctmaj WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid "." SELECT".
" 998,0,SUM(hox),0 ".
" FROM F$kli_vxcf"."_prizprac$kli_uzid".
" WHERE drh = 0 AND LEFT(ucx,1) = 6 ".
" GROUP BY drh";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid "." SELECT".
" 999,0,SUM(hox),0 ".
" FROM F$kli_vxcf"."_prizprac$kli_uzid".
" WHERE drh = 0 AND LEFT(ucx,1) = 5 ".
" GROUP BY drh";
$dsql = mysql_query("$dsqlt");
//exit;

$f1r01x=0; $f1r02x=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prizprac$kli_uzid WHERE drh = 998";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $f1r01x=$f1r01x+$polozka->hox; }
$i=$i+1;                  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prizprac$kli_uzid WHERE drh = 999";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $f1r02x=$f1r02x+$polozka->hox; }
$i=$i+1;                  }

//zapis
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" f1r01='$f1r01x', f1r02=-'$f1r02x',  f1r03=f1r01-f1r02, r100=f1r03, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");
//echo $uprtxt;
//exit;

$vsql = 'DROP TABLE F'.$kli_vxcf.'_prizprac'.$kli_uzid;
$vytvor = mysql_query("$vsql");
?>
<script type="text/javascript">
window.open('../ucto/priznanie_po2018.php?strana=<?php echo $strana; ?>&copern=102&drupoh=1&prepocitaj=1', '_self')
</script>
<?php
}
//koniec copern=200 nacitaj data dppo=1

//zapis a prepni do zostavy odpisy HIM
$dppo = strip_tags($_REQUEST['dppo']);
if ( $copern == 200 AND $dppo == 2 )
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_prizprac'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$sqlt = <<<prizprac
(
   drh          DECIMAL(3,0) DEFAULT 0,
   ucx          VARCHAR(11),
   hox          DECIMAL(10,2),
   ico          DECIMAL(10,0)
);
prizprac;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prizprac'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$podmmd="( inv >= 0 ) ";
$podmdl="( inv >= 0 ) ";

$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 1,0,ros,0 FROM F$kli_vxcf"."_majmaj WHERE $podmmd ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid"." SELECT 2,0,hd5,0 FROM F$kli_vxcf"."_majmaj WHERE $podmdl ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid "." SELECT".
" 998,0,SUM(hox),0 ".
" FROM F$kli_vxcf"."_prizprac$kli_uzid".
" WHERE drh = 1 ".
" GROUP BY drh";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prizprac$kli_uzid "." SELECT".
" 999,0,SUM(hox),0 ".
" FROM F$kli_vxcf"."_prizprac$kli_uzid".
" WHERE drh = 2 ".
" GROUP BY drh";
$dsql = mysql_query("$dsqlt");
//exit;

$b1r01x=0; $b1r02x=0; $b1r04x=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prizprac$kli_uzid WHERE drh = 999";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $b1r01x=$b1r01x+$polozka->hox; }
$i=$i+1;                  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prizprac$kli_uzid WHERE drh = 998";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $b1r02x=$b1r02x+$polozka->hox; }
$i=$i+1;                  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_zozprcneu$kli_uzid WHERE druh = 999 ";
$sql = mysql_query("$sqltt");
$i=0; while ($i <= 0 ) {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $b1r04x=$b1r04x+$polozka->zosdx; }
$i=$i+1;               }

//zapis
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" b1r01='$b1r02x', b1r02='$b1r01x', b1r04='$b1r04x', r150=b1r01-b1r02, r250=0, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

//danove-uctovne
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET r250=-r150, r150=0, psys=0  WHERE r150 < 0";
$upravene = mysql_query("$uprtxt");
//echo $uprtxt;
//exit;

$vsql = 'DROP TABLE F'.$kli_vxcf.'_prizprac'.$kli_uzid;
//$vytvor = mysql_query("$vsql");
?>
<script type="text/javascript">
window.open('../ucto/priznanie_po2018.php?strana=<?php echo $strana; ?>&copern=102&drupoh=1&prepocitaj=1', '_self')
</script>
<?php
}
//koniec copern=200 nacitaj data dppo=2

// zapis upravene udaje
if ( $copern == 103 OR $copern == 5103 )
     {
if ( $strana == 1 ) {
$druh = 1*$_REQUEST['druh'];
//$obod = $_REQUEST['obod'];
//$obodsql=SqlDatum($obod);
//$obdo = $_REQUEST['obdo'];
//$obdosql=SqlDatum($obdo);

//if ( $obodsql == '0000-00-00' ) { $obodsql=$kli_vrok."-01-01"; }
//if ( $obdosql == '0000-00-00' ) { $obdosql=$kli_vrok."-12-31"; }

//$obdd1 = strip_tags($_REQUEST['obdd1']);
//$obdm1 = strip_tags($_REQUEST['obdm1']);
//$obdr1 = strip_tags($_REQUEST['obdr1']);
//$obdd2 = strip_tags($_REQUEST['obdd2']);
//$obdm2 = strip_tags($_REQUEST['obdm2']);
//$obdr2 = strip_tags($_REQUEST['obdr2']);
//$obmd1 = strip_tags($_REQUEST['obmd1']);
//$obmm1 = strip_tags($_REQUEST['obmm1']);
//$obmr1 = strip_tags($_REQUEST['obmr1']);
//$obmd2 = strip_tags($_REQUEST['obmd2']);
//$obmm2 = strip_tags($_REQUEST['obmm2']);
//$obmr2 = strip_tags($_REQUEST['obmr2']);
$cinnost = strip_tags($_REQUEST['cinnost']);
//$oznucet = 1*$_REQUEST['oznucet'];
//$xstat = strip_tags($_REQUEST['xstat']);
//$dmailfax = strip_tags($_REQUEST['dmailfax']);
$uoskr = 1*$_REQUEST['uoskr'];
$koskr = 1*$_REQUEST['koskr'];
$nerezident = 1*$_REQUEST['nerezident'];
$zahrprep = 1*$_REQUEST['zahrprep'];
$pruli = strip_tags($_REQUEST['pruli']);
$prcdm = strip_tags($_REQUEST['prcdm']);
$prpsc = strip_tags($_REQUEST['prpsc']);
$prmes = strip_tags($_REQUEST['prmes']);
$prpoc = strip_tags($_REQUEST['prpoc']);

$chpld = 1*$_REQUEST['chpld'];
$cho5k = 1*$_REQUEST['cho5k'];
$chpdl = 1*$_REQUEST['chpdl'];
$chndl = 1*$_REQUEST['chndl'];
$zapdl = 1*$_REQUEST['zapdl'];

$osl13 = 1*$_REQUEST['osl13'];

//obod='$obodsql', obdo='$obdosql',
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" chpld='$chpld', cho5k='$cho5k', chpdl='$chpdl', chndl='$chndl', zapdl='$zapdl', osl13='$osl13', ".
" druh='$druh',  cinnost='$cinnost', uoskr='$uoskr', koskr='$koskr', ".
" nerezident='$nerezident', zahrprep='$zahrprep', pruli='$pruli', prcdm='$prcdm', prpsc='$prpsc', prmes='$prmes', prpoc='$prpoc' ".
" WHERE ico >= 0";
                    }

if ( $strana == 2 ) {
$r100 = strip_tags($_REQUEST['r100']);
$r110 = strip_tags($_REQUEST['r110']);
$r120 = strip_tags($_REQUEST['r120']);
$r130 = strip_tags($_REQUEST['r130']);
$r140 = strip_tags($_REQUEST['r140']);
$r150 = strip_tags($_REQUEST['r150']);
$r160 = strip_tags($_REQUEST['r160']);
$r170 = strip_tags($_REQUEST['r170']);
$r180 = strip_tags($_REQUEST['r180']);
//$r190 = strip_tags($_REQUEST['r190']);
$r200 = strip_tags($_REQUEST['r200']);
$r210 = strip_tags($_REQUEST['r210']);
$r220 = strip_tags($_REQUEST['r220']);
$r230 = strip_tags($_REQUEST['r230']);
$r240 = strip_tags($_REQUEST['r240']);
$r250 = strip_tags($_REQUEST['r250']);
$r260 = strip_tags($_REQUEST['r260']);
$r270 = strip_tags($_REQUEST['r270']);
$r280 = strip_tags($_REQUEST['r280']);
$r290 = strip_tags($_REQUEST['r290']);
$r300 = strip_tags($_REQUEST['r300']);
$r301 = strip_tags($_REQUEST['r301']);
$r302 = strip_tags($_REQUEST['r302']);
$r303 = strip_tags($_REQUEST['r303']);
$r304 = strip_tags($_REQUEST['r304']);

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET  ".
" r100='$r100', r110='$r110', r120='$r120', r130='$r130', r140='$r140', r150='$r150', r160='$r160', r170='$r170', r180='$r180', ".
" r200='$r200', r210='$r210', r220='$r220', r230='$r230', r240='$r240', r250='$r250', r260='$r260', r270='$r270', r280='$r280', r290='$r290', ".
" r300='$r300', r301='$r301', r302='$r302', r303='$r303', r304='$r304' ".
" WHERE ico >= 0";
                    }

if ( $strana == 3 ) {

$r305 = strip_tags($_REQUEST['r305']);
$r306 = strip_tags($_REQUEST['r306']);
$r307 = strip_tags($_REQUEST['r307']);
$r308 = strip_tags($_REQUEST['r308']);
$r310 = strip_tags($_REQUEST['r310']);
$r320 = strip_tags($_REQUEST['r320']);
$r330 = strip_tags($_REQUEST['r330']);
$r400 = strip_tags($_REQUEST['r400']);
$r410 = strip_tags($_REQUEST['r410']);
$r500 = strip_tags($_REQUEST['r500']);
$r501 = strip_tags($_REQUEST['r501']);
$r510 = strip_tags($_REQUEST['r510']);
$r550 = strip_tags($_REQUEST['r550']);
$r600 = strip_tags($_REQUEST['r600']);
$r610text = strip_tags($_REQUEST['r610text']);
$r610 = strip_tags($_REQUEST['r610']);
$r700 = strip_tags($_REQUEST['r700']);
$r710 = strip_tags($_REQUEST['r710']);
$r800 = strip_tags($_REQUEST['r800']);
$r810 = strip_tags($_REQUEST['r810']);
$r820 = strip_tags($_REQUEST['r820']);
//$r830 = strip_tags($_REQUEST['r830']);
//$r840 = strip_tags($_REQUEST['r840']);
//$r850 = strip_tags($_REQUEST['r850']);
//$r860 = strip_tags($_REQUEST['r860']);
$r900 = strip_tags($_REQUEST['r900']);
$r910 = strip_tags($_REQUEST['r910']);
$r920 = strip_tags($_REQUEST['r920']);
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" r305='$r305', r306='$r306', r307='$r307', r308='$r308', r310='$r310', r320='$r320', r330='$r330', r400='$r400', r410='$r410', ".
" r500='$r500', r501='$r501', r510='$r510', r550='$r550', r600='$r600', r610='$r610', r610text='$r610text', ".
" r700='$r700', r710='$r710', r800='$r800', r810='$r810', r820='$r820', r910='$r910', r920='$r920', ".
" r900='$r900' ".
" WHERE ico >= 0";
//echo $uprtxt;
                    }

if ( $strana == 4 ) {
//$r901 = strip_tags($_REQUEST['r901']);

//$r930 = strip_tags($_REQUEST['r930']);
//$r940 = strip_tags($_REQUEST['r940']);
//$r950 = strip_tags($_REQUEST['r950']);
//$r960 = strip_tags($_REQUEST['r960']);
//$r970 = strip_tags($_REQUEST['r970']);

$r1000 = strip_tags($_REQUEST['r1000']);
//$r1001 = strip_tags($_REQUEST['r1001']);
$r1010 = strip_tags($_REQUEST['r1010']);
$r1020 = strip_tags($_REQUEST['r1020']);
$r1030 = strip_tags($_REQUEST['r1030']);
$r1040 = strip_tags($_REQUEST['r1040']);
$r1050 = strip_tags($_REQUEST['r1050']);
$r1060 = strip_tags($_REQUEST['r1060']);
$r1061 = strip_tags($_REQUEST['r1061']);
$r1062 = strip_tags($_REQUEST['r1062']);
$r1070 = strip_tags($_REQUEST['r1070']);
$r1080 = strip_tags($_REQUEST['r1080']);
$r1090 = strip_tags($_REQUEST['r1090']);
$r1100 = strip_tags($_REQUEST['r1100']);
$r1101 = strip_tags($_REQUEST['r1101']);
$r1110 = strip_tags($_REQUEST['r1110']);
$r1120 = strip_tags($_REQUEST['r1120']);
$r1130 = strip_tags($_REQUEST['r1130']);
$r1140 = strip_tags($_REQUEST['r1140']);
$r1150 = strip_tags($_REQUEST['r1150']);
$r1160 = strip_tags($_REQUEST['r1160']);
$r1170 = strip_tags($_REQUEST['r1170']);
$r1180 = strip_tags($_REQUEST['r1180']);
$r1190 = strip_tags($_REQUEST['r1190']);
$dadod = strip_tags($_REQUEST['dadod']);
$dadod_sql=SqlDatum($dadod);
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" r1000='$r1000', r1010='$r1010', r1020='$r1020', r1030='$r1030', r1040='$r1040', r1050='$r1050', ".
" r1060='$r1060', r1061='$r1061', r1062='$r1062', r1070='$r1070', r1080='$r1080', r1090='$r1090', ".
" r1100='$r1100', r1101='$r1101', r1110='$r1110', r1120='$r1120', r1130='$r1130', r1140='$r1140', r1150='$r1150', ".
" r1160='$r1160', r1170='$r1170', r1180='$r1180', r1190='$r1190', ".
" dadod='$dadod_sql' ".
" WHERE ico >= 0";

                    }

if ( $strana == 5 ) {
$a1r01 = strip_tags($_REQUEST['a1r01']);
$a1r02 = strip_tags($_REQUEST['a1r02']);
$a1r03 = strip_tags($_REQUEST['a1r03']);
$a1r04 = strip_tags($_REQUEST['a1r04']);
$a1u01 = strip_tags($_REQUEST['a1u01']);
$a1u02 = strip_tags($_REQUEST['a1u02']);
$a1u03 = strip_tags($_REQUEST['a1u03']);
$a1u04 = strip_tags($_REQUEST['a1u04']);

$a1r05 = strip_tags($_REQUEST['a1r05']);
$a1r06 = strip_tags($_REQUEST['a1r06']);
$a1r07 = strip_tags($_REQUEST['a1r07']);
$a1r08 = strip_tags($_REQUEST['a1r08']);
$a1r09 = strip_tags($_REQUEST['a1r09']);
$a1r10 = strip_tags($_REQUEST['a1r10']);
$a1r11 = strip_tags($_REQUEST['a1r11']);
$a1r12 = strip_tags($_REQUEST['a1r12']);
$a1r13 = strip_tags($_REQUEST['a1r13']);
$a1r14 = strip_tags($_REQUEST['a1r14']);
$a1r15 = strip_tags($_REQUEST['a1r15']);
$a1r16 = strip_tags($_REQUEST['a1r16']);
$a1u05 = strip_tags($_REQUEST['a1u05']);
$a1u06 = strip_tags($_REQUEST['a1u06']);
$a1u07 = strip_tags($_REQUEST['a1u07']);
$a1u08 = strip_tags($_REQUEST['a1u08']);
$a1u09 = strip_tags($_REQUEST['a1u09']);
$a1u10 = strip_tags($_REQUEST['a1u10']);
$a1u11 = strip_tags($_REQUEST['a1u11']);
$a1u12 = strip_tags($_REQUEST['a1u12']);
$a1u13 = strip_tags($_REQUEST['a1u13']);
$a1u14 = strip_tags($_REQUEST['a1u14']);
$a1u15 = strip_tags($_REQUEST['a1u15']);
$a1u16 = strip_tags($_REQUEST['a1u16']);
$b1r01 = strip_tags($_REQUEST['b1r01']);
$b1r02 = strip_tags($_REQUEST['b1r02']);
$b1r03 = strip_tags($_REQUEST['b1r03']);
$b1r04 = strip_tags($_REQUEST['b1r04']);
$b1r05 = strip_tags($_REQUEST['b1r05']);
$b1r06 = strip_tags($_REQUEST['b1r06']);


if ( $copern == 103 )
     {
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" a1r01='$a1r01', a1r02='$a1r02', a1r03='$a1r03', a1r04='$a1r04', a1r05='$a1r05', a1r06='$a1r06', a1r07='$a1r07', a1r08='$a1r08', a1r09='$a1r09', a1r10='$a1r10', ".
" a1r11='$a1r11', a1r12='$a1r12', a1r13='$a1r13', a1r14='$a1r14', a1r15='$a1r15', a1r16='$a1r16', ".
" b1r01='$b1r01', b1r02='$b1r02', b1r03='$b1r03', b1r04='$b1r04', b1r05='$b1r05', b1r06='$b1r06' ".

" WHERE ico >= 0";
     }
if ( $copern == 5103 )
     {
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" a1u01='$a1u01', a1u02='$a1u02', a1u03='$a1u03', a1u04='$a1u04', a1u05='$a1u05', a1u06='$a1u06', a1u07='$a1u07', a1u08='$a1u08', a1u09='$a1u09', ".
" a1u10='$a1u10', a1u11='$a1u11', a1u12='$a1u12', a1u13='$a1u13', a1u14='$a1u14', ".
" a1u15='$a1u15', a1u16='$a1u16' ".
" WHERE ico >= 0";
$copern=103;
     }
                    }

if ( $strana == 6 ) {
$c1r01 = strip_tags($_REQUEST['c1r01']);
$c1r02 = strip_tags($_REQUEST['c1r02']);
$c1r03 = strip_tags($_REQUEST['c1r03']);
$c1r04 = strip_tags($_REQUEST['c1r04']);
$c1r05 = strip_tags($_REQUEST['c1r05']);
$c2r01 = strip_tags($_REQUEST['c2r01']);
$c2r02 = strip_tags($_REQUEST['c2r02']);
$c2r03 = strip_tags($_REQUEST['c2r03']);
$c2r04 = strip_tags($_REQUEST['c2r04']);
$c2r05 = strip_tags($_REQUEST['c2r05']);
$d1r01 = strip_tags($_REQUEST['d1r01']);
$d1r02 = strip_tags($_REQUEST['d1r02']);
$d1r03 = strip_tags($_REQUEST['d1r03']);
//$d1r04 = strip_tags($_REQUEST['d1r04']);
//$d1r05 = strip_tags($_REQUEST['d1r05']);
//$d1r06 = strip_tags($_REQUEST['d1r06']);
//$d1r07 = strip_tags($_REQUEST['d1r07']);
$d2od = strip_tags($_REQUEST['d2od']);
$d2odsql = SqlDatum($d2od);
$d2do = strip_tags($_REQUEST['d2do']);
$d2dosql = SqlDatum($d2do);
$d3od = strip_tags($_REQUEST['d3od']);
$d3odsql = SqlDatum($d3od);
$d3do = strip_tags($_REQUEST['d3do']);
$d3dosql = SqlDatum($d3do);


$d2r01 = strip_tags($_REQUEST['d2r01']);
$d2r02 = strip_tags($_REQUEST['d2r02']);
$d2r03 = strip_tags($_REQUEST['d2r03']);
//$d2r04 = strip_tags($_REQUEST['d2r04']);
//$d2r05 = strip_tags($_REQUEST['d2r05']);
//$d2r06 = strip_tags($_REQUEST['d2r06']);
//$d2r07 = strip_tags($_REQUEST['d2r07']);
$d3r01 = strip_tags($_REQUEST['d3r01']);
$d3r02 = strip_tags($_REQUEST['d3r02']);
$d3r03 = strip_tags($_REQUEST['d3r03']);
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" c1r01='$c1r01', c1r02='$c1r02', c1r03='$c1r03', c1r04='$c1r04', c1r05='$c1r05', ".
" c2r01='$c2r01', c2r02='$c2r02', c2r03='$c2r03', c2r04='$c2r04', c2r05='$c2r05', ".
" d1r01='$d1r01', d1r02='$d1r02', d1r03='$d1r03', ".
" d2od='$d2odsql', d2do='$d2dosql', d2r01='$d2r01', d2r02='$d2r02', d2r03='$d2r03', ".
" d3od='$d3odsql', d3do='$d3dosql', d3r01='$d3r01', d3r02='$d3r02', d3r03='$d3r03' ".
" WHERE ico >= 0";
                    }

if ( $strana == 7 ) {
$d4od = strip_tags($_REQUEST['d4od']);
$d4odsql = SqlDatum($d4od);
$d4do = strip_tags($_REQUEST['d4do']);
$d4dosql = SqlDatum($d4do);
$d4r01 = strip_tags($_REQUEST['d4r01']);
$d4r02 = strip_tags($_REQUEST['d4r02']);
$d4r03 = strip_tags($_REQUEST['d4r03']);
$d5od = strip_tags($_REQUEST['d5od']);
$d5odsql = SqlDatum($d5od);
$d5do = strip_tags($_REQUEST['d5do']);
$d5dosql = SqlDatum($d5do);
$d5r01 = strip_tags($_REQUEST['d5r01']);
$d5r02 = strip_tags($_REQUEST['d5r02']);
$d5r03 = strip_tags($_REQUEST['d5r03']);
$d6od = strip_tags($_REQUEST['d6od']);
$d6odsql = SqlDatum($d6od);
$d6do = strip_tags($_REQUEST['d6do']);
$d6dosql = SqlDatum($d6do);
$d6r01 = strip_tags($_REQUEST['d6r01']);
$d6r02 = strip_tags($_REQUEST['d6r02']);
$d6r03 = strip_tags($_REQUEST['d6r03']);
$d7od = strip_tags($_REQUEST['d7od']);
$d7odsql = SqlDatum($d7od);
$d7do = strip_tags($_REQUEST['d7do']);
$d7dosql = SqlDatum($d7do);
$d7r01 = strip_tags($_REQUEST['d7r01']);
$d7r02 = strip_tags($_REQUEST['d7r02']);
$d7r03 = strip_tags($_REQUEST['d7r03']);
$d8od = strip_tags($_REQUEST['d8od']);
$d8odsql = SqlDatum($d8od);
$d8do = strip_tags($_REQUEST['d8do']);
$d8dosql = SqlDatum($d8do);
$d8r01 = strip_tags($_REQUEST['d8r01']);
$d8r02 = strip_tags($_REQUEST['d8r02']);
$d8r03 = strip_tags($_REQUEST['d8r03']);
$d9r01 = strip_tags($_REQUEST['d9r01']);
$d9r02 = strip_tags($_REQUEST['d9r02']);
$d9r03 = strip_tags($_REQUEST['d9r03']);
$e1r01 = strip_tags($_REQUEST['e1r01']);
$e1r02 = strip_tags($_REQUEST['e1r02']);
$e1r03 = strip_tags($_REQUEST['e1r03']);
$e1r04 = strip_tags($_REQUEST['e1r04']);
$e1r05 = strip_tags($_REQUEST['e1r05']);
$e1r06 = strip_tags($_REQUEST['e1r06']);
$f1r01 = strip_tags($_REQUEST['f1r01']);
$f1r02 = strip_tags($_REQUEST['f1r02']);
$f1r03 = strip_tags($_REQUEST['f1r03']);
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" d4od='$d4odsql', d4do='$d4dosql', d4r01='$d4r01', d4r02='$d4r02', d4r03='$d4r03', ".
" d5od='$d5odsql', d5do='$d5dosql', d5r01='$d5r01', d5r02='$d5r02', d5r03='$d5r03', ".
" d6od='$d6odsql', d6do='$d6dosql', d6r01='$d6r01', d6r02='$d6r02', d6r03='$d6r03', ".
" d7od='$d7odsql', d7do='$d7dosql', d7r01='$d7r01', d7r02='$d7r02', d7r03='$d7r03', ".
" d8od='$d8odsql', d8do='$d8dosql', d8r01='$d8r01', d8r02='$d8r02', d8r03='$d8r03', ".
" d9r01='$d9r01', d9r02='$d9r02', d9r03='$d9r03', ".
" e1r01='$e1r01', e1r02='$e1r02', e1r03='$e1r03', e1r04='$e1r04', e1r05='$e1r05', e1r06='$e1r06', ".
" f1r01='$f1r01', f1r02='$f1r02', f1r03='$f1r03' ".
" WHERE ico >= 0";
                    }

if ( $strana == 8 ) {
$g1r01 = strip_tags($_REQUEST['g1r01']);
$g1r02 = strip_tags($_REQUEST['g1r02']);
$g1r03 = strip_tags($_REQUEST['g1r03']);
$g2r01 = strip_tags($_REQUEST['g2r01']);
$g2r02 = strip_tags($_REQUEST['g2r02']);
$g2r03 = strip_tags($_REQUEST['g2r03']);
$g3r01 = strip_tags($_REQUEST['g3r01']);
$g3r02 = strip_tags($_REQUEST['g3r02']);
$g3r03 = strip_tags($_REQUEST['g3r03']);
$g3r04 = strip_tags($_REQUEST['g3r04']);
$hr01 = strip_tags($_REQUEST['hr01']);
$h1r02 = strip_tags($_REQUEST['h1r02']);
$h2r02 = strip_tags($_REQUEST['h2r02']);
$h1r03 = strip_tags($_REQUEST['h1r03']);
$h2r03 = strip_tags($_REQUEST['h2r03']);
$h1r04 = strip_tags($_REQUEST['h1r04']);
$h2r04 = strip_tags($_REQUEST['h2r04']);
$h1r05 = strip_tags($_REQUEST['h1r05']);
$h2r05 = strip_tags($_REQUEST['h2r05']);
$h1r06 = strip_tags($_REQUEST['h1r06']);
$h2r06 = strip_tags($_REQUEST['h2r06']);
$h1r07 = strip_tags($_REQUEST['h1r07']);
$h2r07 = strip_tags($_REQUEST['h2r07']);
$h1r08 = strip_tags($_REQUEST['h1r08']);
$h2r08 = strip_tags($_REQUEST['h2r08']);
$h1r09 = strip_tags($_REQUEST['h1r09']);
$h2r09 = strip_tags($_REQUEST['h2r09']);
$hr10 = strip_tags($_REQUEST['hr10']);
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" g1r01='$g1r01', g1r02='$g1r02', g1r03='$g1r03', ".
" g2r01='$g2r01', g2r02='$g2r02', g2r03='$g2r03', ".
" g3r01='$g3r01', g3r02='$g3r02', g3r03='$g3r03', g3r04='$g3r04', ".
" hr01='$hr01', ".
" h1r02='$h1r02', h2r02='$h2r02', h1r03='$h1r03', h2r03='$h2r03', h1r04='$h1r04', h2r04='$h2r04', ".
" h1r05='$h1r05', h2r05='$h2r05', h1r06='$h1r06', h2r06='$h2r06', h1r07='$h1r07', h2r07='$h2r07', ".
" h1r08='$h1r08', h2r08='$h2r08', h1r09='$h1r09', h2r09='$h2r09', ".
" hr10='$hr10' ".
" WHERE ico >= 0";
                    }

if ( $strana == 9 ) {
$i1r01 = strip_tags($_REQUEST['i1r01']);
$i1r02 = strip_tags($_REQUEST['i1r02']);
$i1r03 = strip_tags($_REQUEST['i1r03']);
$i1r04 = strip_tags($_REQUEST['i1r04']);
$i1r05 = strip_tags($_REQUEST['i1r05']);
$i1r06 = strip_tags($_REQUEST['i1r06']);
$i1r07 = strip_tags($_REQUEST['i1r07']);
$i2r01 = strip_tags($_REQUEST['i2r01']);
$i2r02 = strip_tags($_REQUEST['i2r02']);
$i2r03 = strip_tags($_REQUEST['i2r03']);
$i2r04 = strip_tags($_REQUEST['i2r04']);
$i2r05 = strip_tags($_REQUEST['i2r05']);
$i2r06 = strip_tags($_REQUEST['i2r06']);
$i2r07 = strip_tags($_REQUEST['i2r07']);
$jr01 = strip_tags($_REQUEST['jr01']);
$jr02 = strip_tags($_REQUEST['jr02']);
$k1od = strip_tags($_REQUEST['k1od']);
$k1odsql = SqlDatum($k1od);
$k1do = strip_tags($_REQUEST['k1do']);
$k1dosql = SqlDatum($k1do);
$k2od = strip_tags($_REQUEST['k2od']);
$k2odsql = SqlDatum($k2od);
$k2do = strip_tags($_REQUEST['k2do']);
$k2dosql = SqlDatum($k2do);
$k3od = strip_tags($_REQUEST['k3od']);
$k3odsql = SqlDatum($k3od);
$k3do = strip_tags($_REQUEST['k3do']);
$k3dosql = SqlDatum($k3do);
$k4od = strip_tags($_REQUEST['k4od']);
$k4odsql = SqlDatum($k4od);
$k4do = strip_tags($_REQUEST['k4do']);
$k4dosql = SqlDatum($k4do);
$k2r01 = strip_tags($_REQUEST['k2r01']);
$k3r01 = strip_tags($_REQUEST['k3r01']);
$k4r01 = strip_tags($_REQUEST['k4r01']);
$k5r01 = strip_tags($_REQUEST['k5r01']);
$k2r02 = strip_tags($_REQUEST['k2r02']);
$k3r02 = strip_tags($_REQUEST['k3r02']);
$k4r02 = strip_tags($_REQUEST['k4r02']);
$k5r02 = strip_tags($_REQUEST['k5r02']);
$k2r03 = strip_tags($_REQUEST['k2r03']);
$k3r03 = strip_tags($_REQUEST['k3r03']);
$k4r03 = strip_tags($_REQUEST['k4r03']);
$k5r03 = strip_tags($_REQUEST['k5r03']);
$k2r04 = strip_tags($_REQUEST['k2r04']);
$k3r04 = strip_tags($_REQUEST['k3r04']);
$k4r04 = strip_tags($_REQUEST['k4r04']);
$k5r04 = strip_tags($_REQUEST['k5r04']);
$k4r05 = strip_tags($_REQUEST['k4r05']);
$k5r05 = strip_tags($_REQUEST['k5r05']);
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" i1r01='$i1r01', i1r02='$i1r02', i1r03='$i1r03', i1r04='$i1r04', i1r05='$i1r05', i1r06='$i1r06', i1r07='$i1r07', ".
" i2r01='$i2r01', i2r02='$i2r02', i2r03='$i2r03', i2r04='$i2r04', i2r05='$i2r05', i2r06='$i2r06', i2r07='$i2r07', ".
" jr01='$jr01', jr02='$jr02', ".
" k1od='$k1odsql', k1do='$k1dosql', k2r01='$k2r01', k3r01='$k3r01', k4r01='$k4r01', k5r01='$k5r01',  ".
" k2od='$k2odsql', k2do='$k2dosql', k2r02='$k2r02', k3r02='$k3r02', k4r02='$k4r02', k5r02='$k5r02', ".
" k3od='$k3odsql', k3do='$k3dosql', k2r03='$k2r03',  k3r03='$k3r03', k4r03='$k4r03', k5r03='$k5r03', ".
" k4od='$k4odsql', k4do='$k4dosql', k2r04='$k2r04', k3r04='$k3r04',  k4r04='$k4r04', k5r04='$k5r04', ".
" k4r05='$k4r05', k5r05='$k5r05' ".
" WHERE ico >= 0";
                    }

if ( $strana == 10 ) {
$ps1r01 = strip_tags($_REQUEST['ps1r01']);
$ps2r01 = strip_tags($_REQUEST['ps2r01']);
$ps1r02 = strip_tags($_REQUEST['ps1r02']);
$ps2r02 = strip_tags($_REQUEST['ps2r02']);
$ps1r03 = strip_tags($_REQUEST['ps1r03']);
$ps2r03 = strip_tags($_REQUEST['ps2r03']);
$ps1r04 = strip_tags($_REQUEST['ps1r04']);
$ps2r04 = strip_tags($_REQUEST['ps2r04']);
$ps1r05 = strip_tags($_REQUEST['ps1r05']);
$ps2r05 = strip_tags($_REQUEST['ps2r05']);
$ps1r06 = strip_tags($_REQUEST['ps1r06']);
$ps2r06 = strip_tags($_REQUEST['ps2r06']);
$psr07 = strip_tags($_REQUEST['psr07']);
$psr08 = strip_tags($_REQUEST['psr08']);
$psr09 = strip_tags($_REQUEST['psr09']);
$psr10 = strip_tags($_REQUEST['psr10']);
$psr11 = strip_tags($_REQUEST['psr11']);
$psr12 = strip_tags($_REQUEST['psr12']);
$psr13 = strip_tags($_REQUEST['psr13']);
$ps1r14 = strip_tags($_REQUEST['ps1r14']);
$ps2r14 = strip_tags($_REQUEST['ps2r14']);
$ps1r15 = strip_tags($_REQUEST['ps1r15']);
$ps2r15 = strip_tags($_REQUEST['ps2r15']);
$ps1r16 = strip_tags($_REQUEST['ps1r16']);
$ps2r16 = strip_tags($_REQUEST['ps2r16']);
$ps1r17 = strip_tags($_REQUEST['ps1r17']);
$ps2r17 = strip_tags($_REQUEST['ps2r17']);
$ps1r18 = strip_tags($_REQUEST['ps1r18']);
$ps2r18 = strip_tags($_REQUEST['ps2r18']);
$ps1r19 = strip_tags($_REQUEST['ps1r19']);
$ps2r19 = strip_tags($_REQUEST['ps2r19']);
$psr20 = strip_tags($_REQUEST['psr20']);
$psr21 = strip_tags($_REQUEST['psr21']);
$psr22 = strip_tags($_REQUEST['psr22']);
$psr23 = strip_tags($_REQUEST['psr23']);
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" ps1r01='$ps1r01', ps2r01='$ps2r01', ps1r02='$ps1r02', ps2r02='$ps2r02', ps1r03='$ps1r03', ps2r03='$ps2r03', ".
" ps1r04='$ps1r04', ps2r04='$ps2r04', ps1r05='$ps1r05', ps2r05='$ps2r05', ps1r06='$ps1r06', ps2r06='$ps2r06', ".
" psr07='$psr07', psr08='$psr08', psr09='$psr09', psr10='$psr10', psr11='$psr11', psr12='$psr12', psr13='$psr13', ".
" ps1r14='$ps1r14', ps2r14='$ps2r14', ps1r15='$ps1r15', ps2r15='$ps2r15', ps1r16='$ps1r16', ps2r16='$ps2r16', ".
" ps1r17='$ps1r17', ps2r17='$ps2r17', ps1r18='$ps1r18', ps2r18='$ps2r18', ps1r19='$ps1r19', ps2r19='$ps2r19', ".
" psr20='$psr20', psr21='$psr21', psr22='$psr22', psr23='$psr23' ".
" WHERE ico >= 0";
                     }

if ( $strana == 11 ) {
$psr24 = strip_tags($_REQUEST['psr24']);
$psr25 = strip_tags($_REQUEST['psr25']);
$psr26 = strip_tags($_REQUEST['psr26']);
$psr27 = strip_tags($_REQUEST['psr27']);
$psr29 = strip_tags($_REQUEST['psr29']);
$psr30 = strip_tags($_REQUEST['psr30']);
$psr31 = strip_tags($_REQUEST['psr31']);
$ozd1r01 = strip_tags($_REQUEST['ozd1r01']);
$ozd1r02 = strip_tags($_REQUEST['ozd1r02']);
$ozd1r03 = strip_tags($_REQUEST['ozd1r03']);
$ozd1r04 = strip_tags($_REQUEST['ozd1r04']);
$ozd2r04 = strip_tags($_REQUEST['ozd2r04']);
$ozd1r05 = strip_tags($_REQUEST['ozd1r05']);
$ozd2r05 = strip_tags($_REQUEST['ozd2r05']);
$ozd1r06 = strip_tags($_REQUEST['ozd1r06']);
$ozd2r06 = strip_tags($_REQUEST['ozd2r06']);
$ozdr07 = strip_tags($_REQUEST['ozdr07']);
$ozdr09 = strip_tags($_REQUEST['ozdr09']);
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" psr24='$psr24', psr25='$psr25', psr26='$psr26', psr27='$psr27', psr29='$psr29', psr30='$psr30', psr31='$psr31', ".
" ozd1r01='$ozd1r01', ozd1r02='$ozd1r02', ozd1r03='$ozd1r03', ".
" ozd1r04='$ozd1r04', ozd2r04='$ozd2r04', ozd1r05='$ozd1r05', ozd2r05='$ozd2r05', ozd1r06='$ozd1r06', ozd2r06='$ozd2r06', ".
" ozdr07='$ozdr07', ozdr09='$ozdr09' ".
" WHERE ico >= 0";
                     }

if ( $strana == 12 ) {
$pzano = strip_tags($_REQUEST['pzano']);
$zslu = strip_tags($_REQUEST['zslu']);
$pcdan = strip_tags($_REQUEST['pcdan']);
$pcpod = strip_tags($_REQUEST['pcpod']);
$pcdar = strip_tags($_REQUEST['pcdar']);
$pc155 = strip_tags($_REQUEST['pc155']);
$pcpoc = strip_tags($_REQUEST['pcpoc']);
$pcsum = strip_tags($_REQUEST['pcsum']);
$p1ico = strip_tags($_REQUEST['p1ico']);
//$p1sid = strip_tags($_REQUEST['p1sid']);
$p1pfr = strip_tags($_REQUEST['p1pfr']);
$p1men = strip_tags($_REQUEST['p1men']);
$p1uli = strip_tags($_REQUEST['p1uli']);
$p1cdm = strip_tags($_REQUEST['p1cdm']);
$p1psc = strip_tags($_REQUEST['p1psc']);
$p1mes = strip_tags($_REQUEST['p1mes']);
$osldan = strip_tags($_REQUEST['osldan']);
$osobit = strip_tags($_REQUEST['osobit']);
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" pzano='$pzano', zslu='$zslu', ".
" pcdan='$pcdan', pcpod='$pcpod', pcdar='$pcdar', pc155='$pc155', pcpoc='$pcpoc', pcsum='$pcsum', ".
" p1ico='$p1ico', p1pfr='$p1pfr', p1men='$p1men', p1uli='$p1uli', p1cdm='$p1cdm', p1psc='$p1psc', p1mes='$p1mes', ".
" osldan='$osldan', osobit='$osobit' ".
" WHERE ico >= 0";
                     }

if ( $strana == 13 ) {
$ooprie = strip_tags($_REQUEST['ooprie']);
$oomeno = strip_tags($_REQUEST['oomeno']);
$ootitl = strip_tags($_REQUEST['ootitl']);
$otitz = strip_tags($_REQUEST['otitz']);
$oopost = strip_tags($_REQUEST['oopost']);
$oouli = strip_tags($_REQUEST['oouli']);
$oocdm = strip_tags($_REQUEST['oocdm']);
$oopsc = strip_tags($_REQUEST['oopsc']);
$oomes = strip_tags($_REQUEST['oomes']);
$ootel = strip_tags($_REQUEST['ootel']);
$oofax = strip_tags($_REQUEST['oofax']);
$oostat = strip_tags($_REQUEST['oostat']);
$pril = strip_tags($_REQUEST['pril']);
$datum = strip_tags($_REQUEST['datum']);
$datum_sql = SqlDatum($datum);
$ozdspl = strip_tags($_REQUEST['ozdspl']);
$ozdspl1dat = strip_tags($_REQUEST['ozdspl1dat']);
$ozdspl1dat_sql = SqlDatum($ozdspl1dat);
$ozdspl1sum = strip_tags($_REQUEST['ozdspl1sum']);
$ozdspl2dat = strip_tags($_REQUEST['ozdspl2dat']);
$ozdspl2dat_sql = SqlDatum($ozdspl2dat);
$ozdspl2sum = strip_tags($_REQUEST['ozdspl2sum']);
$ozdspl3dat = strip_tags($_REQUEST['ozdspl3dat']);
$ozdspl3dat_sql = SqlDatum($ozdspl3dat);
$ozdspl3sum = strip_tags($_REQUEST['ozdspl3sum']);
$ozdspl4dat = strip_tags($_REQUEST['ozdspl4dat']);
$ozdspl4dat_sql = SqlDatum($ozdspl4dat);
$ozdspl4sum = strip_tags($_REQUEST['ozdspl4sum']);
$ozdspl5dat = strip_tags($_REQUEST['ozdspl5dat']);
$ozdspl5dat_sql = SqlDatum($ozdspl5dat);
$ozdspl5sum = strip_tags($_REQUEST['ozdspl5sum']);
$ozdspldat = strip_tags($_REQUEST['ozdspldat']);
$ozdspldat_sql = SqlDatum($ozdspldat);
$vrat = strip_tags($_REQUEST['vrat']);
$vrpp = strip_tags($_REQUEST['vrpp']);
$vruc = strip_tags($_REQUEST['vruc']);
$datuk = strip_tags($_REQUEST['datuk']);
$datuk_sql = SqlDatum($datuk);
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" ooprie='$ooprie', oomeno='$oomeno', ootitl='$ootitl', otitz='$otitz', oopost='$oopost', oouli='$oouli', oocdm='$oocdm', ".
" oopsc='$oopsc', oomes='$oomes', ootel='$ootel', oofax='$oofax', oostat='$oostat', ".
" pril='$pril', datum='$datum_sql', ozdspl='$ozdspl', ".
" ozdspl1dat='$ozdspl1dat_sql', ozdspl1sum='$ozdspl1sum', ozdspl2dat='$ozdspl2dat_sql', ozdspl2sum='$ozdspl2sum', ".
" ozdspl3dat='$ozdspl3dat_sql', ozdspl3sum='$ozdspl3sum', ozdspl4dat='$ozdspl4dat_sql', ozdspl4sum='$ozdspl4sum',  ".
" ozdspl5dat='$ozdspl5dat_sql', ozdspl5sum='$ozdspl5sum', ozdspldat='$ozdspldat_sql', ".
" vrat='$vrat', vrpp='$vrpp', vruc='$vruc', datuk='$datuk_sql' ".
" WHERE ico >= 0";
                     }

if ( $strana == 14 ) {
$vos13a = 1*$_REQUEST['vos13a'];
$vos13b = 1*$_REQUEST['vos13b'];
$vosspl = 1*$_REQUEST['vosspl'];
$pat13a = strip_tags($_REQUEST['pat13a']);
$pat13b = strip_tags($_REQUEST['pat13b']);

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" vos13a='$vos13a', vos13b='$vos13b', vosspl='$vosspl', pat13a='$pat13a', pat13b='$pat13b'  ".
" WHERE ico >= 0";
                     }

$uprav="NO";
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

$rozdielodpisov = 1*$_REQUEST['rozdielodpisov'];
if ( $rozdielodpisov == 1 ) { $prepocitaj=1; }
$nedanovevydavky = 1*$_REQUEST['nedanovevydavky'];
if ( $nedanovevydavky == 1 ) { $prepocitaj=1; }
$odpocetstraty = 1*$_REQUEST['odpocetstraty'];
if ( $odpocetstraty == 1 ) { $prepocitaj=1; }
$zapocetdane = 1*$_REQUEST['zapocetdane'];
if ( $zapocetdane == 1 ) { $prepocitaj=1; }
$odpocetvyskum = 1*$_REQUEST['odpocetvyskum'];
if ( $odpocetvyskum == 1 ) { $prepocitaj=1; }
$licenciatabk = 1*$_REQUEST['licenciatabk'];
if ( $licenciatabk == 1 ) { $prepocitaj=1; }
$preddavky = 1*$_REQUEST['preddavky'];
if ( $preddavky == 1 ) { $prepocitaj=1; }
$nacitajdanlicencia = 1*$_REQUEST['nacitajdanlicencia'];
if ( $nacitajdanlicencia == 1 ) { $prepocitaj=1; }

//nacitaj udaje
if ( $copern >= 1 )
     {
//prepocitaj
//$prepocitaj=0;
$alertprepocet="";
if ( $prepocitaj == 1 ) {
$alertprepocet="!!! PrepoËÌtavam hodnoty v riadkoch !!!";

//vsetky strany vypocty su upravene pre 2018
//////////////////////strana 2 2018

if ( $rozdielodpisov == 1 )
  {
//danove-uctovne prerobim na kliknutie na ikonku
//upravene na rok 2018
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r150=b1r01-b1r06, r250=0, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

//danove-uctovne prerobim na kliknutie na ikonku
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET r250=-r150, r150=0, psys=0  WHERE r150 < 0";
$upravene = mysql_query("$uprtxt");
  }


if ( $nedanovevydavky == 1 )
  {
//danove-uctovne prerobim na kliknutie na ikonku
//upravene na rok 2018
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r130=a1r17, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

  }

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r200=r110+r130+r140+r150+r170+r180, r300=r210+r220+r230+r240+r250+r260+r270+r280+r290, r301=r100+r200-r300+hr10, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

/////////////////////strana 3 2018
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r310=r301+r302+r303+r304+r305+r306-r307+r308, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r400=r310-r320-r330, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

if ( $odpocetstraty == 1 )
  {
//upravene na rok 2018
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r410=d9r02, ".
" psys=0 ".
" WHERE ico >= 0 AND r400 > 0 ";
$upravene = mysql_query("$uprtxt");
  }

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET r410=r400, psys=0 WHERE ico >= 0 AND r410 > r400 AND r400 > 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r500=r400-r410, psys=0 WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r500=0 WHERE ico >= 0 AND r500 < 0 ";
$upravene = mysql_query("$uprtxt");

if ( $odpocetvyskum == 1 )
  {
//upravene na rok 2018
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dpprilpro SET prpods=prpod1+prpod2+prpod3+prpod4+prpod5, prppp=1, prpodv=prpodv1+prpodv2 WHERE prcpl > 0 ";
$sqldok = mysql_query("$sqlttt");


$prpodv=0;
$sqlttt = "SELECT SUM(prpods) AS sums, SUM(prppp) AS sump, SUM(prpodv) AS sumv FROM F$kli_vxcf"."_uctpriznanie_dpprilpro WHERE prcpl > 0 ";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $prpodv=$riaddok->sumv;
 $prppp=$riaddok->sump;
 }

$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dpprilpro SET prpodv='$prpodv', prppp='$prppp' WHERE prcpl > 0 ";
$sqldok = mysql_query("$sqlttt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r501='$prpodv' WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");
  }

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r510=r500-r501 WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r510=0 WHERE ico >= 0 AND r510 < 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r550=21, r600=(r550*r510), psys=0 WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r600=FLOOR(r600)  WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r600=r600/100  WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r600=0 WHERE r510 <= 0";
$upravene = mysql_query("$uprtxt");

//upravene na rok 2018
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r700=r600-r610, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r700=0 WHERE r700 <= 0";
$upravene = mysql_query("$uprtxt");

if ( $zapocetdane == 1 )
  {
//upravene na rok 2017
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r710=e1r06 WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");
  }

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r800=r700-r710, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r800=0 WHERE r800 <= 0";
$upravene = mysql_query("$uprtxt");

//danova licencia 2018
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET r810=0      WHERE chndl = 1 ";
//$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET r810=480    WHERE chndl = 0 ";
//$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET r810=960    WHERE chndl = 0 AND chpld = 1 ";
//$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET r810=2880   WHERE chndl = 0 AND chpld = 1 AND cho5k = 1 ";
//$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET r810=r810/2 WHERE chndl = 0 AND chpdl = 1 ";
//$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r820=0, r830=0, r900=0, ".
" psys=0 ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r820=r810-r800, ".
" psys=0 ".
" WHERE ico >= 0 AND r810 > 0 AND r810 > r800 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r900=r810+r830, ".
" psys=0 ".
" WHERE ico >= 0 AND r810 > r800 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r900=r830, ".
" psys=0 ".
" WHERE ico >= 0 AND r810 <= r800 ";
$upravene = mysql_query("$uprtxt");

//////////////////strana 3,4 2018

if ( $licenciatabk == 1 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r910=0, r920=0, r1000=0, ".
" psys=0 ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r920=k4r05, ".
" psys=0 ".
" WHERE ico >= 0 AND k4r05 > 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r910=r800-r810, ".
" psys=0 ".
" WHERE ico >= 0 AND r800 > r810 AND r920 > 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r920=r910, ".
" psys=0 ".
" WHERE ico >= 0 AND r920 > r910 AND r920 > 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r1000=r800-r920, ".
" psys=0 ".
" WHERE ico >= 0 AND r920 > 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r1000=0, ".
" psys=0 ".
" WHERE r1000 <= 0 AND r920 > 0 ";
$upravene = mysql_query("$uprtxt");
  }


$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r1040=r1010+r1020+r1030, ".
" psys=0 ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r1050=r800, ".
" psys=0 ".
" WHERE ico >= 0 AND r900 = 0 AND r1000 = 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r1050=r900, ".
" psys=0 ".
" WHERE ico >= 0 AND r810 > r800  ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r1050=r800+r900, ".
" psys=0 ".
" WHERE ico >= 0 AND r900 = r830 AND r1000 = 0  ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r1050=r1000, ".
" psys=0 ".
" WHERE ico >= 0 AND r1000 > 0  ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r1080=r1050+r1060+r1070, ".
" psys=0 ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r1100=r1080-r1090-r1040, r1101=0, ".
" psys=0 ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r1101=-r1100, r1100=0, ".
" psys=0 ".
" WHERE ico >= 0 AND r1100 < 0 ";
$upravene = mysql_query("$uprtxt");

if ( $preddavky == 1 )
  {
//upravene na rok 2018
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET r1110=r510*21, psys=0 WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r1110=FLOOR(r1110)  WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r1110=r1110/100  WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r1110=r1110-r610-r710-r1030  WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r1110=0 WHERE r1110 <= 0";
$upravene = mysql_query("$uprtxt");

  }


//////////////////strana 5 tabulky 2018
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" a1r17=a1r01+a1r02+a1r03+a1r04+a1r05+a1r06+a1r07+a1r08+a1r09+a1r10+a1r11+a1r12+a1r13+a1r14+a1r15+a1r16, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" b1r06=b1r02-b1r03-b1r04+b1r05, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


//////////////////strana 7 2018
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET f1r03=f1r01-f1r02, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

//////////////////strana 8 2018
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET g3r04=g3r01+g3r02-g3r03, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET hr10=hr01+h1r02-h2r02+h1r03-h2r03+h1r04-h2r04+h1r05-h2r05+h1r06-h2r06+h1r07-h2r07+h1r08-h2r08+h1r09-h2r09, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

//////////////////strana 9 2018
if ( $nacitajdanlicencia == 1 )
  {
$licencia2016 = 1*$_REQUEST['licencia2016'];


$h_ycf=0;
if ( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");

$dl2014=0; $dl2015=0; $k2r01=0; $k3r01=0; $k4r01=0; $k5r01=0;
$sqlttt = "SELECT r830, r820, obdo, obod, k2r01, k3r01, k4r01, k5r01, k1od, k1do, k2r02, k3r02, k4r02, k5r02, k2od, k2do, k3od, k3do ".
" FROM ".$databaza."F$h_ycf"."_uctpriznanie_po ";
$sqldok = mysql_query("$sqlttt");
//echo $sqlttt;
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $r830=1*$riaddok->r830;
 $r820=1*$riaddok->r820;

 $obod=$riaddok->obod;
 $obdo=$riaddok->obdo;

 $k1od=$riaddok->k1od;
 $k1do=$riaddok->k1do;
 $k2r01=1*$riaddok->k2r01;
 $k3r01=1*$riaddok->k3r01;
 $k4r01=1*$riaddok->k4r01;
 $k5r01=1*$riaddok->k5r01;

 $k2od=$riaddok->k2od;
 $k2do=$riaddok->k2do;
 $k2r02=1*$riaddok->k2r02;
 $k3r02=1*$riaddok->k3r02;
 $k4r02=1*$riaddok->k4r02;
 $k5r02=1*$riaddok->k5r02;
 }


if( $licencia2016 == 1 )
    {
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" k2r01='$k2r01', k3r01='$k3r01'+'$k4r01', k4r01=0, k1od='$k1od', k1do='$k1do', ".
" psys=0  ".
" WHERE ico >= 0";

$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" k2r02='$k2r02', k3r02='$k3r02'+'$k4r02', k4r02=0, k2od='$k2od', k2do='$k2do', ".
" psys=0  ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" k2r03='$r820', k3od='$obod', k3do='$obdo',  ".
" psys=0  ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

    }

  }

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET k5r01=k2r01-k3r01-k4r01, k5r02=k2r02-k3r02-k4r02, k5r03=k2r03-k3r03-k4r03, k5r04=k2r04-k3r04-k4r04, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET k4r05=k4r01+k4r02+k4r03+k4r04, k5r05=k5r01+k5r02+k5r03+k5r04, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


//////////////////strana 10 2018

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ps1r06=ps1r01+ps1r02+ps1r03+ps1r04+ps1r05, ps2r06=ps2r01+ps2r02+ps2r03+ps2r04+ps2r05, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET psr12=psr07+psr08+psr09+psr10+psr11, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET psr13=ps1r06-ps2r06+psr12, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ps1r19=ps1r14+ps1r15+ps1r16+ps1r17+ps1r18, ps2r19=ps2r14+ps2r15+ps2r16+ps2r17+ps2r18, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

//////////////////strana 11 2018
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET psr25=psr20+psr21+psr22+psr23+psr24, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ozd1r06=ozd1r01+ozd1r02+ozd1r03+ozd1r04+ozd1r05, ozd2r06=ozd2r04+ozd2r05,".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


//////////////////strana 14 2018
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET vosspl=vos13a+vos13b, ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


//koniec prepocitaj, len ak prepocitaj=1
                        }
//////////////////koniec vypoctov

//nacitaj udaje pre upravu

$dnessk = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_po WHERE ico >= 0";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$druh = $fir_riadok->druh;
//$obod = $fir_riadok->obod;
//$obodsk=SkDatum($obod);
//$obdo = $fir_riadok->obdo;
//$obdosk=SkDatum($obdo);
$cinnost = $fir_riadok->cinnost;
$uoskr = $fir_riadok->uoskr;
$koskr = $fir_riadok->koskr;
$nerezident = $fir_riadok->nerezident;
$zahrprep = $fir_riadok->zahrprep;
$pruli = $fir_riadok->pruli;
$prcdm = $fir_riadok->prcdm;
$prpsc = $fir_riadok->prpsc;
$prmes = $fir_riadok->prmes;
$prpoc = $fir_riadok->prpoc;
$obdd1 = $fir_riadok->obdd1;
$obdm1 = $fir_riadok->obdm1;
$obdr1 = $fir_riadok->obdr1;
$obdd2 = $fir_riadok->obdd2;
$obdm2 = $fir_riadok->obdm2;
$obdr2 = $fir_riadok->obdr2;
$obmd1 = $fir_riadok->obmd1;
$obmm1 = $fir_riadok->obmm1;
$obmr1 = $fir_riadok->obmr1;
$obmd2 = $fir_riadok->obmd2;
$obmm2 = $fir_riadok->obmm2;
$obmr2 = $fir_riadok->obmr2;
$chpld = 1*$fir_riadok->chpld;
$cho5k = 1*$fir_riadok->cho5k;
$chpdl = 1*$fir_riadok->chpdl;
$chndl = 1*$fir_riadok->chndl;
$zapdl = 1*$fir_riadok->zapdl;
$osl13 = 1*$fir_riadok->osl13;

if ( $strana == 2 OR $strana == 999 ) {
$r100 = $fir_riadok->r100;
$r110 = $fir_riadok->r110;
$r120 = $fir_riadok->r120;
$r130 = $fir_riadok->r130;
$r140 = $fir_riadok->r140;
$r150 = $fir_riadok->r150;
$r160 = $fir_riadok->r160;
$r170 = $fir_riadok->r170;
$r180 = $fir_riadok->r180;
$r200 = $fir_riadok->r200;
$r210 = $fir_riadok->r210;
$r220 = $fir_riadok->r220;
$r230 = $fir_riadok->r230;
$r240 = $fir_riadok->r240;
$r250 = $fir_riadok->r250;
$r260 = $fir_riadok->r260;
$r270 = $fir_riadok->r270;
$r280 = $fir_riadok->r280;
$r290 = $fir_riadok->r290;
$r300 = $fir_riadok->r300;
$r301 = $fir_riadok->r301;
$r302 = $fir_riadok->r302;
$r303 = $fir_riadok->r303;
$r304 = $fir_riadok->r304;
                                      }

if ( $strana == 3 OR $strana == 999 ) {

$r305 = $fir_riadok->r305;
$r306 = $fir_riadok->r306;
$r307 = $fir_riadok->r307;
$r308 = $fir_riadok->r308;
$r310 = $fir_riadok->r310;
$r320 = $fir_riadok->r320;
$r330 = $fir_riadok->r330;
$r400 = $fir_riadok->r400;
$r410 = $fir_riadok->r410;
$r500 = $fir_riadok->r500;
$r501 = $fir_riadok->r501;
$r510 = $fir_riadok->r510;
$r550 = $fir_riadok->r550;
$r600 = $fir_riadok->r600;
$r610text = $fir_riadok->r610text;
$r610 = $fir_riadok->r610;
$r700 = $fir_riadok->r700;
$r710 = $fir_riadok->r710;
$r800 = $fir_riadok->r800;
$r810 = $fir_riadok->r810;
$r820 = $fir_riadok->r820;
$r900 = $fir_riadok->r900;
$r910 = $fir_riadok->r910;
$r920 = $fir_riadok->r920;
                                      }

if ( $strana == 4 OR $strana == 999 ) {
$r1000 = $fir_riadok->r1000;
$r1010 = $fir_riadok->r1010;
$r1020 = $fir_riadok->r1020;
$r1030 = $fir_riadok->r1030;
$r1040 = $fir_riadok->r1040;
$r1050 = $fir_riadok->r1050;
$r1060 = $fir_riadok->r1060;
$r1061 = $fir_riadok->r1061;
$r1062 = $fir_riadok->r1062;
$r1070 = $fir_riadok->r1070;
$r1080 = $fir_riadok->r1080;
$r1090 = $fir_riadok->r1090;
$r1100 = $fir_riadok->r1100;
$r1101 = $fir_riadok->r1101;
$r1110 = $fir_riadok->r1110;
$r1120 = $fir_riadok->r1120;
$r1130 = $fir_riadok->r1130;
$r1140 = $fir_riadok->r1140;
$r1150 = $fir_riadok->r1150;
$r1160 = $fir_riadok->r1160;
$r1170 = $fir_riadok->r1170;
$r1180 = $fir_riadok->r1180;
$r1190 = $fir_riadok->r1190;
$dadod_sk = SkDatum($fir_riadok->dadod);
                                      }

if ( $strana == 5 OR $strana == 999 ) {
$a1r01 = $fir_riadok->a1r01;
$a1r02 = $fir_riadok->a1r02;
$a1r03 = $fir_riadok->a1r03;
$a1r04 = $fir_riadok->a1r04;
$a1u01 = $fir_riadok->a1u01;
$a1u02 = $fir_riadok->a1u02;
$a1u03 = $fir_riadok->a1u03;
$a1u04 = $fir_riadok->a1u04;
$a1r05 = $fir_riadok->a1r05;
$a1r06 = $fir_riadok->a1r06;
$a1r07 = $fir_riadok->a1r07;
$a1r08 = $fir_riadok->a1r08;
$a1r09 = $fir_riadok->a1r09;
$a1r10 = $fir_riadok->a1r10;
$a1r11 = $fir_riadok->a1r11;
$a1r12 = $fir_riadok->a1r12;
$a1r13 = $fir_riadok->a1r13;
$a1r14 = $fir_riadok->a1r14;
$a1r15 = $fir_riadok->a1r15;
$a1r16 = $fir_riadok->a1r16;
$a1r17 = $fir_riadok->a1r17;
$a1u05 = $fir_riadok->a1u05;
$a1u06 = $fir_riadok->a1u06;
$a1u07 = $fir_riadok->a1u07;
$a1u08 = $fir_riadok->a1u08;
$a1u09 = $fir_riadok->a1u09;
$a1u10 = $fir_riadok->a1u10;
$a1u11 = $fir_riadok->a1u11;
$a1u12 = $fir_riadok->a1u12;
$a1u13 = $fir_riadok->a1u13;
$a1u14 = $fir_riadok->a1u14;
$a1u15 = $fir_riadok->a1u15;
$a1u16 = $fir_riadok->a1u16;
$b1r01 = $fir_riadok->b1r01;
$b1r02 = $fir_riadok->b1r02;
$b1r03 = $fir_riadok->b1r03;
$b1r04 = $fir_riadok->b1r04;
$b1r05 = $fir_riadok->b1r05;
$b1r06 = $fir_riadok->b1r06;
                                      }

if ( $strana == 6 OR $strana == 999 ) {
$c1r01 = $fir_riadok->c1r01;
$c1r02 = $fir_riadok->c1r02;
$c1r03 = $fir_riadok->c1r03;
$c1r04 = $fir_riadok->c1r04;
$c1r05 = $fir_riadok->c1r05;
$c2r01 = $fir_riadok->c2r01;
$c2r02 = $fir_riadok->c2r02;
$c2r03 = $fir_riadok->c2r03;
$c2r04 = $fir_riadok->c2r04;
$c2r05 = $fir_riadok->c2r05;
$d1r01 = $fir_riadok->d1r01;
$d1r02 = $fir_riadok->d1r02;
$d1r03 = $fir_riadok->d1r03;
$d2odsk = SkDatum($fir_riadok->d2od);
$d2dosk = SkDatum($fir_riadok->d2do);
$d2r01 = $fir_riadok->d2r01;
$d2r02 = $fir_riadok->d2r02;
$d2r03 = $fir_riadok->d2r03;
$d3odsk = SkDatum($fir_riadok->d3od);
$d3dosk = SkDatum($fir_riadok->d3do);
$d3r01 = $fir_riadok->d3r01;
$d3r02 = $fir_riadok->d3r02;
$d3r03 = $fir_riadok->d3r03;
                                      }

if ( $strana == 7 OR $strana == 999 ) {
$d4odsk = SkDatum($fir_riadok->d4od);
$d4dosk = SkDatum($fir_riadok->d4do);
$d4r01 = $fir_riadok->d4r01;
$d4r02 = $fir_riadok->d4r02;
$d4r03 = $fir_riadok->d4r03;
$d5odsk = SkDatum($fir_riadok->d5od);
$d5dosk = SkDatum($fir_riadok->d5do);
$d5r01 = $fir_riadok->d5r01;
$d5r02 = $fir_riadok->d5r02;
$d5r03 = $fir_riadok->d5r03;
$d6odsk = SkDatum($fir_riadok->d6od);
$d6dosk = SkDatum($fir_riadok->d6do);
$d6r01 = $fir_riadok->d6r01;
$d6r02 = $fir_riadok->d6r02;
$d6r03 = $fir_riadok->d6r03;
$d7odsk = SkDatum($fir_riadok->d7od);
$d7dosk = SkDatum($fir_riadok->d7do);
$d7r01 = $fir_riadok->d7r01;
$d7r02 = $fir_riadok->d7r02;
$d7r03 = $fir_riadok->d7r03;
$d8odsk = SkDatum($fir_riadok->d8od);
$d8dosk = SkDatum($fir_riadok->d8do);
$d8r01 = $fir_riadok->d8r01;
$d8r02 = $fir_riadok->d8r02;
$d8r03 = $fir_riadok->d8r03;
$d9r01 = $fir_riadok->d9r01;
$d9r02 = $fir_riadok->d9r02;
$d9r03 = $fir_riadok->d9r03;
$e1r01 = $fir_riadok->e1r01;
$e1r02 = $fir_riadok->e1r02;
$e1r03 = $fir_riadok->e1r03;
$e1r04 = $fir_riadok->e1r04;
$e1r05 = $fir_riadok->e1r05;
$e1r06 = $fir_riadok->e1r06;
$f1r01 = $fir_riadok->f1r01;
$f1r02 = $fir_riadok->f1r02;
$f1r03 = $fir_riadok->f1r03;
                                      }

if ( $strana == 8 OR $strana == 999 ) {
$g1r01 = $fir_riadok->g1r01;
$g1r02 = $fir_riadok->g1r02;
$g1r03 = $fir_riadok->g1r03;
$g2r01 = $fir_riadok->g2r01;
$g2r02 = $fir_riadok->g2r02;
$g2r03 = $fir_riadok->g2r03;
$g3r01 = $fir_riadok->g3r01;
$g3r02 = $fir_riadok->g3r02;
$g3r03 = $fir_riadok->g3r03;
$g3r04 = $fir_riadok->g3r04;
$hr01 = $fir_riadok->hr01;
$h1r02 = $fir_riadok->h1r02;
$h2r02 = $fir_riadok->h2r02;
$h1r03 = $fir_riadok->h1r03;
$h2r03 = $fir_riadok->h2r03;
$h1r04 = $fir_riadok->h1r04;
$h2r04 = $fir_riadok->h2r04;
$h1r05 = $fir_riadok->h1r05;
$h2r05 = $fir_riadok->h2r05;
$h1r06 = $fir_riadok->h1r06;
$h2r06 = $fir_riadok->h2r06;
$h1r07 = $fir_riadok->h1r07;
$h2r07 = $fir_riadok->h2r07;
$h1r08 = $fir_riadok->h1r08;
$h2r08 = $fir_riadok->h2r08;
$h1r09 = $fir_riadok->h1r09;
$h2r09 = $fir_riadok->h2r09;
$hr10 = $fir_riadok->hr10;
                                      }

if ( $strana == 9 OR $strana == 999 ) {
$i1r01 = $fir_riadok->i1r01;
$i2r01 = $fir_riadok->i2r01;
$i1r02 = $fir_riadok->i1r02;
$i2r02 = $fir_riadok->i2r02;
$i1r03 = $fir_riadok->i1r03;
$i2r03 = $fir_riadok->i2r03;
$i1r04 = $fir_riadok->i1r04;
$i2r04 = $fir_riadok->i2r04;
$i1r05 = $fir_riadok->i1r05;
$i2r05 = $fir_riadok->i2r05;
$i1r06 = $fir_riadok->i1r06;
$i2r06 = $fir_riadok->i2r06;
$i1r07 = $fir_riadok->i1r07;
$i2r07 = $fir_riadok->i2r07;
$jr01 = $fir_riadok->jr01;
$jr02 = $fir_riadok->jr02;
$k1odsk = SkDatum($fir_riadok->k1od);
$k1dosk = SkDatum($fir_riadok->k1do);
$k2r01 = $fir_riadok->k2r01;
$k3r01 = $fir_riadok->k3r01;
$k4r01 = $fir_riadok->k4r01;
$k5r01 = $fir_riadok->k5r01;
$k2odsk = SkDatum($fir_riadok->k2od);
$k2dosk = SkDatum($fir_riadok->k2do);
$k2r02 = $fir_riadok->k2r02;
$k3r02 = $fir_riadok->k3r02;
$k4r02 = $fir_riadok->k4r02;
$k5r02 = $fir_riadok->k5r02;
$k3odsk = SkDatum($fir_riadok->k3od);
$k3dosk = SkDatum($fir_riadok->k3do);
$k2r03 = $fir_riadok->k2r03;
$k3r03 = $fir_riadok->k3r03;
$k4r03 = $fir_riadok->k4r03;
$k5r03 = $fir_riadok->k5r03;
$k4odsk = SkDatum($fir_riadok->k4od);
$k4dosk = SkDatum($fir_riadok->k4do);
$k2r04 = $fir_riadok->k2r04;
$k3r04 = $fir_riadok->k3r04;
$k4r04 = $fir_riadok->k4r04;
$k5r04 = $fir_riadok->k5r04;
$k4r05 = $fir_riadok->k4r05;
$k5r05 = $fir_riadok->k5r05;
                                      }

if ( $strana == 10 OR $strana == 999 ) {
$ps1r01 = $fir_riadok->ps1r01;
$ps2r01 = $fir_riadok->ps2r01;
$ps1r02 = $fir_riadok->ps1r02;
$ps2r02 = $fir_riadok->ps2r02;
$ps1r03 = $fir_riadok->ps1r03;
$ps2r03 = $fir_riadok->ps2r03;
$ps1r04 = $fir_riadok->ps1r04;
$ps2r04 = $fir_riadok->ps2r04;
$ps1r05 = $fir_riadok->ps1r05;
$ps2r05 = $fir_riadok->ps2r05;
$ps1r06 = $fir_riadok->ps1r06;
$ps2r06 = $fir_riadok->ps2r06;
$psr07 = $fir_riadok->psr07;
$psr08 = $fir_riadok->psr08;
$psr09 = $fir_riadok->psr09;
$psr10 = $fir_riadok->psr10;
$psr11 = $fir_riadok->psr11;
$psr12 = $fir_riadok->psr12;
$psr13 = $fir_riadok->psr13;
$ps1r14 = $fir_riadok->ps1r14;
$ps2r14 = $fir_riadok->ps2r14;
$ps1r15 = $fir_riadok->ps1r15;
$ps2r15 = $fir_riadok->ps2r15;
$ps1r16 = $fir_riadok->ps1r16;
$ps2r16 = $fir_riadok->ps2r16;
$ps1r17 = $fir_riadok->ps1r17;
$ps2r17 = $fir_riadok->ps2r17;
$ps1r18 = $fir_riadok->ps1r18;
$ps2r18 = $fir_riadok->ps2r18;
$ps1r19 = $fir_riadok->ps1r19;
$ps2r19 = $fir_riadok->ps2r19;
$psr20 = $fir_riadok->psr20;
$psr21 = $fir_riadok->psr21;
$psr22 = $fir_riadok->psr22;
$psr23 = $fir_riadok->psr23;
                                      }

if ( $strana == 11 OR $strana == 999 ) {
$psr24 = $fir_riadok->psr24;
$psr25 = $fir_riadok->psr25;
$psr26 = $fir_riadok->psr26;
$psr27 = $fir_riadok->psr27;
$psr29 = $fir_riadok->psr29;
$psr30 = $fir_riadok->psr30;
$psr31 = $fir_riadok->psr31;
$ozd1r01 = $fir_riadok->ozd1r01;
$ozd1r02 = $fir_riadok->ozd1r02;
$ozd1r03 = $fir_riadok->ozd1r03;
$ozd1r04 = $fir_riadok->ozd1r04;
$ozd2r04 = $fir_riadok->ozd2r04;
$ozd1r05 = $fir_riadok->ozd1r05;
$ozd2r05 = $fir_riadok->ozd2r05;
$ozd1r06 = $fir_riadok->ozd1r06;
$ozd2r06 = $fir_riadok->ozd2r06;
$ozdr07 = $fir_riadok->ozdr07;
$ozdr09 = $fir_riadok->ozdr09;
                                      }

if ( $strana == 12 OR $strana == 999 ) {
$pzano = $fir_riadok->pzano;
$zslu = $fir_riadok->zslu;
$pcdan = $fir_riadok->pcdan;
$pcdar = $fir_riadok->pcdar;
$pcpod = $fir_riadok->pcpod;
$pc155 = $fir_riadok->pc155;
$pcpoc = $fir_riadok->pcpoc;
$pcsum = $fir_riadok->pcsum;
$p1ico = $fir_riadok->p1ico;
$p1pfr = $fir_riadok->p1pfr;
$p1men = $fir_riadok->p1men;
$p1uli = $fir_riadok->p1uli;
$p1cdm = $fir_riadok->p1cdm;
$p1psc = $fir_riadok->p1psc;
$p1mes = $fir_riadok->p1mes;
$osldan = $fir_riadok->osldan;
$osobit = $fir_riadok->osobit;
                                      }


if ( $strana == 13 OR $strana == 999 ) {
$ooprie = $fir_riadok->ooprie;
$oomeno = $fir_riadok->oomeno;
$ootitl = $fir_riadok->ootitl;
$otitz = $fir_riadok->otitz;
$oopost = $fir_riadok->oopost;
$oouli = $fir_riadok->oouli;
$oocdm = $fir_riadok->oocdm;
$oopsc = $fir_riadok->oopsc;
$oomes = $fir_riadok->oomes;
$ootel = $fir_riadok->ootel;
$oofax = $fir_riadok->oofax;
$oostat = $fir_riadok->oostat;
$pril = $fir_riadok->pril;
$datum = $fir_riadok->datum;
$datum_sk = SkDatum($datum);
// if ( $datum_sk == '00.00.0000' )
// {
// $datum_sk=Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
// $datum_sql=SqlDatum($datum_sk);
// $sqlx = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET datum='$datum_sql' ";
// $vysledekx = mysql_query("$sqlx");
// }
$ozdspl = $fir_riadok->ozdspl;
$ozdspl1dat = $fir_riadok->ozdspl1dat;
$ozdspl1dat_sk = SkDatum($ozdspl1dat);
$ozdspl1sum = $fir_riadok->ozdspl1sum;
$ozdspl2dat = $fir_riadok->ozdspl2dat;
$ozdspl2dat_sk = SkDatum($ozdspl2dat);
$ozdspl2sum = $fir_riadok->ozdspl2sum;
$ozdspl3dat = $fir_riadok->ozdspl3dat;
$ozdspl3dat_sk = SkDatum($ozdspl3dat);
$ozdspl3sum = $fir_riadok->ozdspl3sum;
$ozdspl4dat = $fir_riadok->ozdspl4dat;
$ozdspl4dat_sk = SkDatum($ozdspl4dat);
$ozdspl4sum = $fir_riadok->ozdspl4sum;
$ozdspl5dat = $fir_riadok->ozdspl5dat;
$ozdspl5dat_sk = SkDatum($ozdspl5dat);
$ozdspl5sum = $fir_riadok->ozdspl5sum;
$ozdspldat = $fir_riadok->ozdspldat;
$ozdspldat_sk = SkDatum($ozdspldat);
$vrat = $fir_riadok->vrat;
$vrpp = $fir_riadok->vrpp;
$vruc = $fir_riadok->vruc;
$datuk = $fir_riadok->datuk;
$datuk_sk = SkDatum($datuk);
                                      }

if ( $strana == 14 OR $strana == 999 ) {
$vos13a = $fir_riadok->vos13a;
$vos13b = $fir_riadok->vos13b;
$vosspl = $fir_riadok->vosspl;
$pat13a = $fir_riadok->pat13a;
$pat13b = $fir_riadok->pat13b;
                                      }

mysql_free_result($fir_vysledok);
     }
//koniec nacitania

//obdobia z ufirdalsie
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
if ( $kli_mdph < 10 ) $kli_mdph="0".$kli_mdph;

$pole = explode(".", $kli_vume);
$mesp_dph=$pole[0];
$mesk_dph=$pole[0];
$rokp_dph=$pole[1];

$datp_dph=$rokp_dph.'-'.$mesp_dph.'-01';
$datk_dph=$rokp_dph.'-'.$mesk_dph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datp_dph', 0 )";
$ttqq = mysql_query("$ttvv");


$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$datp_dph',  datk=LAST_DAY('$datk_dph')".
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

$datp_sk=SkDatum($datp_dph);
$datk_sk=SkDatum($datk_dph);

//nacitaj obdobia z ufirdalsie
$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];
if( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
$kli_mrokx=$kli_vrokx-1;

$datbodsk="01.01.".$kli_vrokx; $datbdosk="31.".$kli_vmesx.".".$kli_vrokx; $datmodsk="01.01.".$kli_mrokx; $datmdosk="31.12.".$kli_mrokx;
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

if ( $riadok->datbod != '0000-00-00' )
     {
  $datbodsk=SkDatum($riadok->datbod);
  $datbdosk=SkDatum($riadok->datbdo);
//  $datmodsk=SkDatum($riadok->datmod);
//  $datmdosk=SkDatum($riadok->datmdo);
//  if( $datmodsk == '00.00.0000' ) { $datmodsk=""; $datmdosk=""; }
     }
  }//koniec blok okolo obdobi uzavierky

//za obdobie nasekanie
$datbodskdni = substr($datbodsk,0,2);
$datbodskmes = substr($datbodsk,3,2);
$datbodskrok = substr($datbodsk,8,9);
$datbdoskdni = substr($datbdosk,0,2);
$datbdoskmes = substr($datbdosk,3,2);
$datbdoskrok = substr($datbdosk,8,9);

//6-miestne ico
if ( $fir_uctt03 != 999 )
{
$ico=$fir_fico;
if ( $fir_fico < 1000000 ) { $ico="00".$fir_fico; }
}

//sidlo-stat z ufir
$sql = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$vysledok = mysql_query($sql);
if ( $vysledok ) {
$riadok=mysql_fetch_object($vysledok);
$fstat = $riadok->fstat;
if ( $fstat == "" ) { $fstat="Slovensko"; }
                 }
?>
<head>
<meta charset="cp1250">
<link rel="stylesheet" href="../css/reset.css">
<link rel="stylesheet" href="../css/tlaciva.css">
<title>DPPO | EuroSecom</title>
<style type="text/css">
span.text-echo {
  font-size: 18px;
  letter-spacing: 13px;
}
div.input-echo {
  position: absolute;
  font-size: 18px;
  background-color: #fff;
}
</style>
</head>
<body onload="ObnovUI(); <?php if ( $copern == 102 AND ( $strana == 2 OR $strana == 4 OR $strana == 6 ) ) ?>">
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">DaÚ z prÌjmov PO
<?php if ( $copern == 10 ) { ?>
    <span class="subheader">/ export xml</span>
<?php } ?>
   </td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/info_blue_icon.png" onclick="FormPoucenie();" title="PouËenie na vyplnenie" class="btn-form-tool">
     <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajMinRok();" title="NaËÌtaù ˙daje z minulÈho roka" class="btn-form-tool">
     <img src="../obr/ikony/upbox_blue_icon.png" onclick="FormXML();" title="Export do XML" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="FormPDF(999);" title="Zobraziù vöetky strany bez prÌloh v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<?php
//uprav udaje
if ( $copern == 102 )
    {
$prepocitaj=1;
?>
<form name="formv1" method="post" action="priznanie_po2018.php?strana=<?php echo $strana; ?>&copern=103">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive"; $clas5="noactive";
$clas6="noactive"; $clas7="noactive"; $clas8="noactive"; $clas9="noactive"; $clas10="noactive";
$clas11="noactive"; $clas12="noactive"; $clas13="noactive"; $clas14="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active"; if ( $strana == 3 ) $clas3="active";
if ( $strana == 4 ) $clas4="active"; if ( $strana == 5 ) $clas5="active"; if ( $strana == 6 ) $clas6="active";
if ( $strana == 7 ) $clas7="active"; if ( $strana == 8 ) $clas8="active"; if ( $strana == 9 ) $clas9="active";
if ( $strana == 10 ) $clas10="active"; if ( $strana == 11 ) $clas11="active"; if ( $strana == 12 ) $clas12="active";
if ( $strana == 13 ) $clas13="active";
if ( $strana == 14 ) $clas14="active";
?>
<div class="navbar">
  <a href="#" onclick="editForm(1);" class="<?php echo $clas1; ?> toleft">1</a>
  <a href="#" onclick="editForm(2);" class="<?php echo $clas2; ?> toleft">2</a>
  <a href="#" onclick="editForm(3);" class="<?php echo $clas3; ?> toleft">3</a>
  <a href="#" onclick="editForm(4);" class="<?php echo $clas4; ?> toleft">4</a>
  <a href="#" onclick="editForm(5);" class="<?php echo $clas5; ?> toleft">5</a>
  <a href="#" onclick="editForm(6);" class="<?php echo $clas6; ?> toleft">6</a>
  <a href="#" onclick="editForm(7);" class="<?php echo $clas7; ?> toleft">7</a>
  <a href="#" onclick="editForm(8);" class="<?php echo $clas8; ?> toleft">8</a>
  <a href="#" onclick="editForm(9);" class="<?php echo $clas9; ?> toleft">9</a>
  <a href="#" onclick="editForm(10);" class="<?php echo $clas10; ?> toleft">10</a>
  <a href="#" onclick="editForm(11);" class="<?php echo $clas11; ?> toleft">11</a>
  <a href="#" onclick="editForm(12);" class="<?php echo $clas12; ?> toleft">12</a>
  <a href="#" onclick="editForm(13);" class="<?php echo $clas13; ?> toleft">13</a>
  <a href="#" onclick="editForm(14);" class="<?php echo $clas14; ?> toleft">14</a>
<a href="#" onclick="window.open('priznanie_dppriloha2018.php?copern=1101&drupoh=1', '_self')" class="toleft">V˝zkum</a>
<a href="#" onclick="window.open('priznanie_dppriloha2018.php?copern=101&drupoh=1', '_self')" class="toleft">PrÌj2%</a>
<!--
<a href="#" onclick="window.open('priznanie_dppriloha2018.php?copern=11&drupoh=1', '_blank')" class="toright">PrÌj2%</a>
<a href="#" onclick="window.open('priznanie_dppriloha2018.php?copern=1011&drupoh=1', '_blank')" class="toright">V˝zkum</a>
  <a href="#" onclick="FormPDF(14);" class="<?php echo $clas14; ?> toright">14</a>
  <a href="#" onclick="FormPDF(13);" class="<?php echo $clas13; ?> toright">13</a>
  <a href="#" onclick="FormPDF(12);" class="<?php echo $clas12; ?> toright">12</a>
  <a href="#" onclick="FormPDF(11);" class="<?php echo $clas11; ?> toright">11</a>
  <a href="#" onclick="FormPDF(10);" class="<?php echo $clas10; ?> toright">10</a>
  <a href="#" onclick="FormPDF(9);" class="<?php echo $clas9; ?> toright">9</a>
  <a href="#" onclick="FormPDF(8);" class="<?php echo $clas8; ?> toright">8</a>
  <a href="#" onclick="FormPDF(7);" class="<?php echo $clas7; ?> toright">7</a>
  <a href="#" onclick="FormPDF(6);" class="<?php echo $clas6; ?> toright">6</a>
  <a href="#" onclick="FormPDF(5);" class="<?php echo $clas5; ?> toright">5</a>
  <a href="#" onclick="FormPDF(4);" class="<?php echo $clas4; ?> toright">4</a>
  <a href="#" onclick="FormPDF(3);" class="<?php echo $clas3; ?> toright">3</a>
  <a href="#" onclick="FormPDF(2);" class="<?php echo $clas2; ?> toright">2</a>
  <a href="#" onclick="FormPDF(1);" class="<?php echo $clas1; ?> toright">1</a>
  <h6 class="toright">TlaËiù:</h6>-->
  <input type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
  <input type="checkbox" name="prepocitaj" value="1" class="btn-prepocet"/>
<?php if ( $prepocitaj == 1 ) { ?>
  <script type="text/javascript">document.formv1.prepocitaj.checked = "checked";</script>
<?php                         } ?>
  <h5 class="btn-prepocet-title">PrepoËÌtaù hodnoty</h5>
  <div class="alert-pocitam"><?php echo $alertprepocet; ?></div>
</div><!-- .navbar -->

<?php if ( $strana == 1 ) { ?>
<img src="<?php echo $jpg_source; ?>_str1.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">

<span class="text-echo" style="top:263px; left:57px;"><?php echo $fir_fdic; ?></span>
<span class="text-echo" style="top:320px; left:57px;"><?php echo $ico; ?></span>
<?php
$fir_uctt03x=$fir_uctt03;
if ( $fir_uctt03 == 999 ) { $fir_uctt03x=""; }
?>
<span class="text-echo" style="top:320px; left:263px;"><?php echo $fir_uctt03x; ?></span>
<!-- Druh priznania -->
<input type="radio" id="druh1" name="druh" value="1" style="top:260px; left:417px;"/>
<input type="radio" id="druh2" name="druh" value="2" style="top:285px; left:417px;"/>
<input type="radio" id="druh3" name="druh" value="3" style="top:310px; left:417px;"/>
<!-- Za obdobie -->
<span class="text-echo" style="top:272px; left:696px;"><?php echo $datbodskdni; ?></span>
<span class="text-echo" style="top:272px; left:753px;"><?php echo $datbodskmes; ?></span>
<span class="text-echo" style="top:272px; left:855px;"><?php echo $datbodskrok; ?></span>
<span class="text-echo" style="top:310px; left:696px;"><?php echo $datbdoskdni; ?></span>
<span class="text-echo" style="top:310px; left:753px;"><?php echo $datbdoskmes; ?></span>
<span class="text-echo" style="top:310px; left:855px;"><?php echo $datbdoskrok; ?></span>



<!-- <input type="text" name="obod" id="obod" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:265px; left:690px;"/>
<input type="text" name="obdo" id="obdo" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:304px; left:690px;"/> -->
<?php
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sn1a=substr($sknacea,0,1);
$sn2a=substr($sknacea,1,1);
$sknaceb=$pole[1];
$sn1b=substr($sknaceb,0,1);
$sn2b=substr($sknaceb,1,1);
$sknacec=$pole[2];
$sn1c=substr($sknacec,0,1);
?>
<span class="text-echo" style="top:380px; left:57px;"><?php echo "$sn1a$sn2a"; ?></span>
<span class="text-echo" style="top:380px; left:114px;"><?php echo "$sn1b$sn2b"; ?></span>
<span class="text-echo" style="top:380px; left:170px;"><?php echo "$sn1c"; ?></span>
<input type="text" name="cinnost" id="cinnost" style="width:624px; height:46px; top:354px; left:267px;"/>

<!-- I.CAST -->
<div class="input-echo" style="width:843px; height:100px; top:469px; left:52px;"><?php echo $fir_fnaz; ?></div>
<div class="input-echo" style="width:635px; top:619px; left:52px;"><?php echo $fir_fuli; ?></div>
<div class="input-echo" style="width:163px; top:619px; left:718px;"><?php echo $fir_fcdm; ?></div>
<div class="input-echo" style="width:110px; top:674px; left:52px;"><?php echo $fir_fpsc; ?></div>
<div class="input-echo" style="width:440px; top:674px; left:180px;"><?php echo $fir_fmes; ?></div>
<div class="input-echo" style="width:240px; top:674px; left:648px;"><?php echo $fstat; ?></div>
<div class="input-echo" style="width:280px; top:730px; left:52px;"><?php echo $fir_ftel; ?></div>
<div class="input-echo" style="width:363px; top:730px; left:377px;"><?php echo $fir_fem1; ?></div>

<input type="checkbox" name="uoskr" value="1" style="top:769px; left:51px;"/>
<input type="checkbox" name="koskr" value="1" style="top:802px; left:51px;"/>
<input type="checkbox" name="nerezident" value="1" style="top:844px; left:51px;"/>
<input type="checkbox" name="zapdl" value="1" style="top:875px; left:51px;"/>

<input type="checkbox" name="zahrprep" value="1" style="top:768px; left:499px;"/>
<input type="checkbox" name="chpld" value="1" style="top:799px; left:499px;"/>
<input type="checkbox" name="cho5k" value="1" style="top:824px; left:499px;"/>
<input type="checkbox" name="chpdl" value="1" style="top:846px; left:499px;"/>
<input type="checkbox" name="chndl" value="1" style="top:868px; left:499px;"/>
<input type="checkbox" name="osl13" value="1" style="top:889px; left:499px;"/>

<!-- Stala prevadzkaren -->
<input type="text" name="pruli" id="pruli" style="width:633px; top:953px; left:52px;"/>
<input type="text" name="prcdm" id="prcdm" style="width:175px; top:953px; left:718px;"/>
<input type="text" name="prpsc" id="prpsc" style="width:107px; top:1009px; left:51px;"/>
<input type="text" name="prmes" id="prmes" style="width:451px; top:1009px; left:178px;"/>
<input type="text" name="prpoc" id="prpoc" style="width:59px; top:1009px; left:649px;"/>
<?php                     } ?>


<?php if ( $strana == 2 ) { ?>
<img src="<?php echo $jpg_source; ?>_str2.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>

<!-- II.CAST -->
<input type="text" name="r100" id="r100" onkeyup="CiarkaNaBodku(this);" style="width:310px; top:183px; left:508px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitajVHpredDanou();"
      title="NaËÌtaù VH pred zdanenÌm do r.100 a do tabuæky F (III.Ëasù PO 7. strana)"
      class="btn-row-tool" style="top:183px; left:833px;">
<input type="text" name="r110" id="r110" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:255px; left:529px;"/>
<input type="text" name="r130" id="r130" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:300px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitajNedVyd();"
      title="NaËÌtaù nedaÚovÈ v˝davky (n·klady) z tabuæky A (III.Ëasù PO 5.strana)"
      class="btn-row-tool" style="top:300px; left:833px;">
<input type="text" name="r140" id="r140" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:343px; left:529px;"/>
<input type="text" name="r150" id="r150" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:382px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitajRozdielOdpisov();"
      title="NaËÌtaù rozdiel daÚov˝ch a ˙Ëtovn˝ch odpisov z tabuæky B (III.Ëasù PO 5.strana)"
      class="btn-row-tool" style="top:382px; left:833px;">
<input type="text" name="r170" id="r170" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:438px; left:529px;"/>
<input type="text" name="r180" id="r180" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:482px; left:529px;"/>
<div class="input-echo right" style="width:290px; top:522px; left:530px;"><?php echo $r200; ?>&nbsp;</div>

<input type="text" name="r210" id="r210" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:590px; left:529px;"/>
<input type="text" name="r220" id="r220" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:633px; left:529px;"/>
<input type="text" name="r230" id="r230" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:675px; left:529px;"/>
<input type="text" name="r240" id="r240" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:717px; left:529px;"/>
<input type="text" name="r250" id="r250" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:756px; left:529px;"/>
<input type="text" name="r260" id="r260" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:798px; left:529px;"/>
<input type="text" name="r270" id="r270" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:840px; left:529px;"/>
<input type="text" name="r280" id="r280" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:890px; left:529px;"/>
<input type="text" name="r290" id="r290" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:938px; left:529px;"/>
<div class="input-echo right" style="width:290px; top:979px; left:530px;"><?php echo $r300; ?>&nbsp;</div>

<div class="input-echo right" style="width:290px; top:1047px; left:530px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $r301; ?>&nbsp;</div>
<input type="text" name="r302" id="r302" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1083px; left:529px;"/>
<input type="text" name="r303" id="r303" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1133px; left:529px;"/>
<input type="text" name="r304" id="r304" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1185px; left:529px;"/>
<script>
  function NacitajVHpredDanou()
  {
   window.open('../ucto/priznanie_po2018.php?strana=2&copern=200&drupoh=1&typ=PDF&dppo=1', '_self');
  }
  function NacitajRozdielOdpisov()
  {
   window.open('priznanie_po2018.php?copern=101&strana=<?php echo $strana; ?>&rozdielodpisov=1', '_self');
  }
  function NacitajNedVyd()
  {
   window.open('priznanie_po2018.php?copern=101&strana=<?php echo $strana; ?>&nedanovevydavky=1', '_self');
  }
</script>
<?php                     } ?>

<?php if ( $strana == 3 ) { ?>
<img src="<?php echo $jpg_source; ?>_str3.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>
<!-- II.CAST pokracovanie -->
<input type="text" name="r305" id="r305" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:118px; left:529px;"/>
<input type="text" name="r306" id="r306" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:157px; left:529px;"/>
<input type="text" name="r307" id="r307" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:198px; left:529px;"/>
<input type="text" name="r308" id="r308" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:236px; left:529px;"/>

<div class="input-echo right" style="width:290px; top:305px; left:530px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $r310; ?>&nbsp;</div>
<input type="text" name="r320" id="r320" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:350px; left:529px;"/>
<input type="text" name="r330" id="r330" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:391px; left:529px;"/>
<div class="input-echo right" style="width:290px; top:430px; left:530px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $r400; ?>&nbsp;</div>

<input type="text" name="r410" id="r410" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:498px; left:530px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="OdpocetStraty();" title="NaËÌtaù odpoËet straty z tabuæky D stÂpec 9 riadok 2 na str.7" class="btn-row-tool" style="top:498px; left:833px;">
<div class="input-echo right" style="width:290px; top:538px; left:530px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $r500; ?>&nbsp;</div>
<input type="text" name="r501" id="r501" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:602px; left:530px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="OdpocetVyskum();" title="NaËÌtaù odpoËet v˝davkov na v˝skum a v˝voj z r.7 PrÌlohy P1" class="btn-row-tool" style="top:601px; left:833px;">
<div class="input-echo right" style="width:290px; top:641px; left:530px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $r510; ?>&nbsp;</div>
<div class="input-echo right" style="width:36px; top:707px; left:530px;"><?php echo $r550; ?>&nbsp;</div>
<div class="input-echo right" style="width:290px; top:746px; left:530px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $r600; ?>&nbsp;</div>
<select size="1" id="r610text" name="r610text" style="width:426px; top:821px; left:55px;">
  <option value=""></option>
  <option value="ß 30a z·kona Ë. 595/2003 Z.z.">ß 30a z·kona Ë. 595/2003 Z.z.</option>
  <option value="ß 30b z·kona Ë. 595/2003 Z.z.">ß 30b z·kona Ë. 595/2003 Z.z.</option>
  <option value="ß 35 z·kona Ë. 366/1999 Z.z.">ß 35 z·kona Ë. 366/1999 Z.z.</option>
  <option value="ß 35a z·kona Ë. 366/1999 Z.z.">ß 35a z·kona Ë. 366/1999 Z.z.</option>
  <option value="ß 35a ods. 9 z·kona Ë. 366/1999 Z.z.">ß 35a ods. 9 z·kona Ë. 366/1999 Z.z.</option>
  <option value="ß 35b z·kona Ë. 366/1999 Z.z.">ß 35b z·kona Ë. 366/1999 Z.z.</option>
  <option value="ß 35c z·kona Ë. 366/1999 Z.z.">ß 35c z·kona Ë. 366/1999 Z.z.</option>
</select>
<input type="text" name="r610" id="r610" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:814px; left:529px;"/>
<div class="input-echo right" style="width:290px; top:859px; left:530px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $r700; ?>&nbsp;</div>
<input type="text" name="r710" id="r710" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:923px; left:530px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="ZapocetDane();" title="NaËÌtaù z·poËet dane z tabuæky E riadok 6 na str.7" class="btn-row-tool" style="top:922px; left:833px;">
<div class="input-echo right" style="width:290px; top:962px; left:530px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $r800; ?>&nbsp;</div>
<input type="text" name="r810" id="r810" style="width:82px; top:1027px; left:667px;"/>
<div class="input-echo right" style="width:150px; top:1067px; left:667px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $r820; ?>&nbsp;</div>
<div class="input-echo right" style="width:290px; top:1107px; left:530px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $r900; ?>&nbsp;</div>
<input type="text" name="r910" id="r910" style="width:290px; top:1172px; left:530px;"/>
<input type="text" name="r920" id="r920" style="width:290px; top:1214px; left:530px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="LicenciaTabK();" title="Kladn˝ rozdiel medzi daÚovou licenciou a daÚou z predch. obdobÌ z r.5 stÂpec 4. tabuæky K na 9.strane max. do v˝öky na riadku 910" class="btn-row-tool" style="top:1214px; left:833px;">
<script>
  function OdpocetVyskum()
  {
   window.open('priznanie_po2018.php?copern=101&strana=<?php echo $strana; ?>&odpocetvyskum=1', '_self');
  }
  function ZapocetDane()
  {
   window.open('priznanie_po2018.php?copern=101&strana=<?php echo $strana; ?>&zapocetdane=1', '_self');
  }
  function OdpocetStraty()
  {
   window.open('priznanie_po2018.php?copern=101&strana=<?php echo $strana; ?>&odpocetstraty=1', '_self');
  }
  function LicenciaTabK()
  {
   window.open('priznanie_po2018.php?copern=101&strana=<?php echo $strana; ?>&licenciatabk=1', '_self');
  }
</script>
<?php                     } ?>


<?php if ( $strana == 4 ) { ?>
<img src="<?php echo $jpg_source; ?>_str4.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>
<!-- II.CAST pokracovanie -->
<input type="text" name="r1000" id="r1000" style="width:290px; top:115px; left:530px;"/>
<input type="text" name="r1010" id="r1010" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:196px; left:529px;"/>
<input type="text" name="r1020" id="r1020" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:235px; left:529px;"/>
<input type="text" name="r1030" id="r1030" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:274px; left:529px;"/>
<div class="input-echo right" style="width:290px; top:313px; left:530px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $r1040; ?>&nbsp;</div>
<input type="text" name="r1050" id="r1050" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:352px; left:529px;"/>
<input type="text" name="r1060" id="r1060" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:391px; left:530px;"/>
<input type="text" name="r1061" id="r1061" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:434px; left:530px;"/>
<input type="text" name="r1062" id="r1062" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:482px; left:530px;"/>
<input type="text" name="r1070" id="r1070" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:525px; left:530px;"/>
<div class="input-echo right" style="width:290px; top:564px; left:530px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $r1080; ?>&nbsp;</div>
<input type="text" name="r1090" id="r1090" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:603px; left:530px;"/>
<div class="input-echo right" style="width:290px; top:642px; left:530px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $r1100; ?>&nbsp;</div>
<div class="input-echo right" style="width:290px; top:681px; left:530px;  title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $r1101; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="SpÙsob v˝poËtu preddavku" onclick="InfoPreddDane();" class="btn-row-tool" style="top:817px; left:440px;">
<input type="text" name="r1110" id="r1110" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:817px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="Preddavky();" title="VypoËÌtaù v˝öku preddavku na daÚ" class="btn-row-tool" style="top:817px; left:833px;">
<input type="text" name="dadod" id="dadod" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:882px; left:529px;"/>
<input type="text" name="r1120" id="r1120" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:920px; left:529px;"/>
<input type="text" name="r1130" id="r1130" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:959px; left:529px;"/>
<input type="text" name="r1140" id="r1140" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:998px; left:529px;"/>
<input type="text" name="r1150" id="r1150" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1038px; left:529px;"/>
<input type="text" name="r1160" id="r1160" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1077px; left:529px;"/> <!-- dopyt, new -->
<input type="text" name="r1170" id="r1170" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1115px; left:529px;"/> <!-- dopyt, new -->
<input type="text" name="r1180" id="r1180" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1154px; left:529px;"/> <!-- dopyt, new -->
<input type="text" name="r1190" id="r1190" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1194px; left:529px;"/> <!-- dopyt, new -->
<script>
  function InfoPreddDane()
  {
   window.open('../dokumenty/dan_z_prijmov2015/dppo2015/dppo_v15_r1110_vypocet.pdf',
'_blank', 'width=1080, height=540, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function Preddavky()
  {
   window.open('priznanie_po2018.php?copern=101&strana=<?php echo $strana; ?>&preddavky=1', '_self');
  }
</script>
<?php                     } ?>


<?php if ( $strana == 5 ) { ?>
<img src="<?php echo $jpg_source; ?>_str5.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>
<!-- III.CAST -->
<!-- A -->
<span id="pripoknobtn1" onclick="pripokno1.style.display='block'; pripoknobtn1.style.display='none';" title="Nastaviù ˙Ëty PripoËÌtateæn˝ch poloûiek" class="pripo-btn" style="position:absolute; top:113px; left:836px; color:#39f; cursor:pointer;
font-weight:bold; font-size:14px;">Nastaviù</span>
<input type="text" name="a1r01" id="a1r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:180px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(1);" title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:180px; left:832px;">
<input type="text" name="a1r02" id="a1r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:255px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(2);" title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:255px; left:832px;">
<input type="text" name="a1r03" id="a1r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:316px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(3);" title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:316px; left:832px;">
<input type="text" name="a1r04" id="a1r04" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:376px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(4);" title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:376px; left:832px;">
<input type="text" name="a1r05" id="a1r05" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:444px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(5);" title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:444px; left:832px;">
<input type="text" name="a1r06" id="a1r06" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:486px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(6);" title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:486px; left:832px;">
<input type="text" name="a1r07" id="a1r07" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:527px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(7);" title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:527px; left:832px;">
<input type="text" name="a1r08" id="a1r08" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:567px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(8);" title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:568px; left:832px;">
<input type="text" name="a1r09" id="a1r09" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:605px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(9);" title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:605px; left:832px;">
<input type="text" name="a1r10" id="a1r10" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:645px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(10);" title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:645px; left:832px;">
<input type="text" name="a1r11" id="a1r11" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:683px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(11);" title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:683px; left:832px;">
<input type="text" name="a1r12" id="a1r12" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:723px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(12);" title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:723px; left:832px;">
<input type="text" name="a1r13" id="a1r13" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:761px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(13);" title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:761px; left:832px;">
<input type="text" name="a1r14" id="a1r14" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:800px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(14);" title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:800px; left:832px;">
<input type="text" name="a1r15" id="a1r15" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:839px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(15);" title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:839px; left:832px;">
<input type="text" name="a1r16" id="a1r16" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:877px; left:529px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(16);" title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:877px; left:832px;">
<div class="input-echo right" style="width:289px; top:918px; left:530px;"><?php echo $a1r17; ?>&nbsp;</div>
<!-- B -->
<input type="text" name="b1r01" id="b1r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:986px; left:529px;"/>
<img src="../obr/ikony/info_blue_icon.png" class="btn-row-tool" style="top:986px; left:839px; cursor:default;" title="Musia byù spracovanÈ mesaËnÈ ˙ËtovnÈ odpisy za 12.<?php echo $kli_vrok; ?>, daÚovÈ odpisy a zostava neuplatnenÈho odpisu v 1.roku odpisovania">
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitajOdpisy();" title="Z podsystÈmu majetok naËÌtaù ˙ËtovnÈ, daÚovÈ odpisy a pomern˙ Ëasù z roËnÈho odpisu neuplatnen˙ v 1.roku odpisovania" class="btn-row-tool" style="top:986px; left:870px;">
<input type="text" name="b1r02" id="b1r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1025px; left:529px;"/>
<input type="text" name="b1r03" id="b1r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1064px; left:529px;"/>
<input type="text" name="b1r04" id="b1r04" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1103px; left:529px;"/>
<input type="text" name="b1r05" id="b1r05" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1142px; left:529px;"/>
<div class="input-echo right" style="width:290px; top:1182px; left:530px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $b1r06; ?>&nbsp;</div>
<script>
  function NacitajOdpisy()
  {
   window.open('../ucto/priznanie_po2018.php?strana=<?php echo $strana; ?>&copern=200&drupoh=1&typ=PDF&dppo=2', '_self');
  }
</script>
<!-- <a href="#" id="pripoknobtn" onclick="pripokno.style.display='block'; pripoknobtn.style.display='none';"
   title="Nastaviù ˙Ëty PripoËÌtateæn˝ch poloûiek" class="pripo-btn hidden">Nastaviù</a> -->
<?php                     } ?>


<?php if ( $strana == 6 ) { ?>
<img src="<?php echo $jpg_source; ?>_str6.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>
<!-- III.CAST pokracovanie -->
<!-- C1 -->
<input type="text" name="c1r01" id="c1r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:149px; left:529px;"/>
<input type="text" name="c1r02" id="c1r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:188px; left:529px;"/>
<input type="text" name="c1r03" id="c1r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:228px; left:529px;"/>
<input type="text" name="c1r04" id="c1r04" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:266px; left:529px;"/>
<input type="text" name="c1r05" id="c1r05" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:305px; left:529px;"/>
<!-- C2 -->
<input type="text" name="c2r01" id="c2r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:482px; left:529px;"/>
<input type="text" name="c2r02" id="c2r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:521px; left:529px;"/>
<input type="text" name="c2r03" id="c2r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:560px; left:529px;"/>
<input type="text" name="c2r04" id="c2r04" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:598px; left:529px;"/>
<input type="text" name="c2r05" id="c2r05" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:638px; left:529px;"/>
<!-- D-1 -->
<input type="text" name="d1r01" id="d1r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:781px; left:604px;"/>
<input type="text" name="d1r02" id="d1r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:820px; left:604px;"/>
<input type="text" name="d1r03" id="d1r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:860px; left:604px;"/>
<!-- D-2 -->
<input type="text" name="d2od" id="d2od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:927px; left:340px;"/>
<input type="text" name="d2do" id="d2do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:966px; left:340px;"/>
<input type="text" name="d2r01" id="d2r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1005px; left:293px;"/>
<input type="text" name="d2r02" id="d2r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1044px; left:293px;"/>
<input type="text" name="d2r03" id="d2r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1083px; left:293px;"/>
<!-- D-3 -->
<input type="text" name="d3od" id="d3od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:927px; left:650px;"/>
<input type="text" name="d3do" id="d3do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:966px; left:650px;"/>
<input type="text" name="d3r01" id="d3r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1005px; left:604px;"/>
<input type="text" name="d3r02" id="d3r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1044px; left:604px;"/>
<input type="text" name="d3r03" id="d3r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1083px; left:604px;"/>
<?php                     } ?>


<?php if ( $strana == 7 ) { ?>
<img src="<?php echo $jpg_source; ?>_str7.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>
<!-- III.CAST pokracovanie -->
<!-- D-4 -->
<input type="text" name="d4od" id="d4od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:147px; left:340px;"/>
<input type="text" name="d4do" id="d4do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:185px; left:340px;"/>
<input type="text" name="d4r01" id="d4r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:224px; left:293px;"/>
<input type="text" name="d4r02" id="d4r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:264px; left:293px;"/>
<input type="text" name="d4r03" id="d4r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:302px; left:293px;"/>
<!-- D-5 -->
<input type="text" name="d5od" id="d5od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:147px; left:650px;"/>
<input type="text" name="d5do" id="d5do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:185px; left:650px;"/>
<input type="text" name="d5r01" id="d5r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:224px; left:604px;"/>
<input type="text" name="d5r02" id="d5r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:264px; left:604px;"/>
<input type="text" name="d5r03" id="d5r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:302px; left:604px;"/>
<!-- D-6 -->
<input type="text" name="d6od" id="d6od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:368px; left:340px;"/>
<input type="text" name="d6do" id="d6do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:406px; left:340px;"/>
<input type="text" name="d6r01" id="d6r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:445px; left:293px;"/>
<input type="text" name="d6r02" id="d6r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:484px; left:293px;"/>
<input type="text" name="d6r03" id="d6r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:523px; left:293px;"/>
<!-- D-7 -->
<input type="text" name="d7od" id="d7od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:368px; left:650px;"/>
<input type="text" name="d7do" id="d7do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:406px; left:650px;"/>
<input type="text" name="d7r01" id="d7r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:445px; left:604px;"/>
<input type="text" name="d7r02" id="d7r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:484px; left:604px;"/>
<input type="text" name="d7r03" id="d7r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:523px; left:604px;"/>

<!-- SPOLU -->
<input type="text" name="d9r01" id="d9r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:588px; left:293px;"/>
<input type="text" name="d9r02" id="d9r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:627px; left:293px;"/>
<input type="text" name="d9r03" id="d9r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:666px; left:293px;"/>

<!-- E -->
<input type="text" name="e1r01" id="e1r01" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:770px; left:530px;"/>
<input type="text" name="e1r02" id="e1r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:810px; left:529px;"/>
<input type="text" name="e1r03" id="e1r03" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:850px; left:530px;"/>
<input type="text" name="e1r04" id="e1r04" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:890px; left:530px;"/>
<input type="text" name="e1r05" id="e1r05" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:930px; left:529px;"/>
<input type="text" name="e1r06" id="e1r06" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:968px; left:530px;"/>
<!-- F -->
<input type="text" name="f1r01" id="f1r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1035px; left:529px;"/>
<input type="text" name="f1r02" id="f1r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1075px; left:529px;"/>
<div class="input-echo right" style="width:290px; top:1115px; left:530px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $f1r03; ?>&nbsp;</div>
<?php                     } ?>


<?php if ( $strana == 8 ) { ?>
<img src="<?php echo $jpg_source; ?>_str8.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>
<!-- III.CAST pokracovanie -->
<!-- G1 -->
<input type="text" name="g1r01" id="g1r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:140px; left:529px;"/>
<input type="text" name="g1r02" id="g1r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:179px; left:529px;"/>
<input type="text" name="g1r03" id="g1r03" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:219px; left:530px;"/>
<!-- G2 -->
<input type="text" name="g2r01" id="g2r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:332px; left:529px;"/>
<input type="text" name="g2r02" id="g2r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:371px; left:529px;"/>
<input type="text" name="g2r03" id="g2r03" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:413px; left:530px;"/>
<!-- G3 -->
<input type="text" name="g3r01" id="g3r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:535px; left:529px;"/>
<input type="text" name="g3r02" id="g3r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:576px; left:529px;"/>
<input type="text" name="g3r03" id="g3r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:615px; left:529px;"/>
<div class="input-echo right" style="width:290px; top:654px; left:530px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $g3r04; ?>&nbsp;</div>
<!-- H -->
<input type="text" name="hr01" id="hr01" onkeyup="CiarkaNaBodku(this);" style="width:309px; top:814px; left:394px;"/>
<input type="text" name="h1r02" id="h1r02" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:877px; left:293px;"/>
<input type="text" name="h2r02" id="h2r02" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:877px; left:603px;"/>
<input type="text" name="h1r03" id="h1r03" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:916px; left:293px;"/>
<input type="text" name="h2r03" id="h2r03" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:916px; left:603px;"/>
<input type="text" name="h1r04" id="h1r04" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:955px; left:293px;"/>
<input type="text" name="h2r04" id="h2r04" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:955px; left:603px;"/>
<input type="text" name="h1r05" id="h1r05" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:994px; left:293px;"/>
<input type="text" name="h2r05" id="h2r05" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:994px; left:603px;"/>
<input type="text" name="h1r06" id="h1r06" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:1033px; left:293px;"/>
<input type="text" name="h2r06" id="h2r06" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:1033px; left:603px;"/>
<input type="text" name="h1r07" id="h1r07" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:1072px; left:293px;"/>
<input type="text" name="h2r07" id="h2r07" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:1072px; left:603px;"/>
<input type="text" name="h1r08" id="h1r08" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:1111px; left:293px;"/>
<input type="text" name="h2r08" id="h2r08" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:1111px; left:603px;"/>
<input type="text" name="h1r09" id="h1r09" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:1150px; left:293px;"/>
<input type="text" name="h2r09" id="h2r09" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:1150px; left:603px;"/>
<div class="input-echo right" style="width:312px; top:1194px; left:394px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $hr10; ?>&nbsp;</div>
<?php                     } ?>


<?php if ( $strana == 9 ) { ?>
<img src="<?php echo $jpg_source; ?>_str9.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>
<!-- III.CAST pokracovanie -->
<!-- I -->
<input type="text" name="i1r01" id="i1r01" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:179px; left:293px;"/>
<input type="text" name="i2r01" id="i2r01" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:179px; left:603px;"/>
<input type="text" name="i1r02" id="i1r02" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:218px; left:293px;"/>
<input type="text" name="i2r02" id="i2r02" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:218px; left:603px;"/>
<input type="text" name="i1r03" id="i1r03" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:257px; left:293px;"/>
<input type="text" name="i2r03" id="i2r03" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:257px; left:603px;"/>
<input type="text" name="i1r04" id="i1r04" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:334px; left:293px;"/>
<input type="text" name="i2r04" id="i2r04" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:334px; left:603px;"/>
<input type="text" name="i1r05" id="i1r05" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:373px; left:293px;"/>
<input type="text" name="i2r05" id="i2r05" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:373px; left:603px;"/>
<input type="text" name="i1r06" id="i1r06" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:411px; left:293px;"/>
<input type="text" name="i2r06" id="i2r06" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:411px; left:603px;"/>
<input type="text" name="i1r07" id="i1r07" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:451px; left:293px;"/>
<input type="text" name="i2r07" id="i2r07" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:451px; left:603px;"/>
<!-- J -->
<input type="text" name="jr01" id="jr01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:522px; left:529px;"/>
<input type="text" name="jr02" id="jr02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:561px; left:529px;"/>
<!-- K-1 -->
<input type="text" name="k1od" id="k1od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:736px; left:62px;"/>
<input type="text" name="k1do" id="k1do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:775px; left:62px;"/>
<?php if ( $kli_vrok == 2015 ) { ?>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitajDanLicencia();" title="NaËÌtaù v˝öku kladnÈho rozdielu medzi daÚovou licenciou a daÚou, ktor˙ moûno zapoËÌtaù v roku 2017 z r.830 Priznania DPPO 2016" class="btn-row-tool" style="top:776px; left:280px;">
<?php                          } ?>
<input type="text" name="k2r01" id="k2r01" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:736px; left:276px;"/>
<input type="text" name="k3r01" id="k3r01" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:736px; left:436px;"/>
<input type="text" name="k4r01" id="k4r01" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:736px; left:595px;"/>
<input type="text" name="k5r01" id="k5r01" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:736px; left:753px;"/>
<!-- K-2 -->
<input type="text" name="k2od" id="k2od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:814px; left:62px;"/>
<input type="text" name="k2do" id="k2do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:852px; left:62px;"/>
<?php if ( $kli_vrok >= 2016 ) { ?>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitajDanLicencia2016();" title="NaËÌtaù v˝öku kladnÈho rozdielu medzi daÚovou licenciou a daÚou, ktor˙ moûno zapoËÌtaù v roku 2016 z r.820 a tabuæky K z Priznania DPPO 2015" class="btn-row-tool" style="top:853px; left:280px;">
<?php                          } ?>
<input type="text" name="k2r02" id="k2r02" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:814px; left:276px;"/>
<input type="text" name="k3r02" id="k3r02" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:814px; left:436px;"/>
<input type="text" name="k4r02" id="k4r02" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:814px; left:595px;"/>
<input type="text" name="k5r02" id="k5r02" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:814px; left:753px;"/>
<!-- K-3 -->
<input type="text" name="k3od" id="k3od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:892px; left:62px;"/>
<input type="text" name="k3do" id="k3do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:930px; left:62px;"/>
<input type="text" name="k2r03" id="k2r03" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:892px; left:276px;"/>
<input type="text" name="k3r03" id="k3r03" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:892px; left:436px;"/>
<input type="text" name="k4r03" id="k4r03" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:892px; left:595px;"/>
<input type="text" name="k5r03" id="k5r03" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:892px; left:753px;"/>
<!-- K-4 -->
<input type="text" name="k4od" id="k4od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:970px; left:62px;"/>
<input type="text" name="k4do" id="k4do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:1009px; left:62px;"/>
<input type="text" name="k2r04" id="k2r04" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:970px; left:276px;"/>
<input type="text" name="k3r04" id="k3r04" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:970px; left:436px;"/>
<input type="text" name="k4r04" id="k4r04" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:970px; left:595px;"/>
<input type="text" name="k5r04" id="k5r04" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:970px; left:753px;"/>
<!-- K-5 -->
<div class="input-echo right" style="width:140px; top:1048px; left:596px;"><?php echo $k4r05; ?>&nbsp;</div>
<div class="input-echo right" style="width:140px; top:1048px; left:754px;"><?php echo $k5r05; ?>&nbsp;</div>
<script>


  function NacitajDanLicencia2016()
  {
   window.open('priznanie_po2018.php?copern=101&strana=<?php echo $strana; ?>&nacitajdanlicencia=1&licencia2016=1', '_self');
  }
</script>
<?php                     } ?>


<?php if ( $strana == 10 ) { ?>
<img src="<?php echo $jpg_source; ?>_str10.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>
<!-- IV.CAST -->
<input type="text" name="ps1r01" id="ps1r01" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:230px; left:293px;"/>
<input type="text" name="ps2r01" id="ps2r01" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:230px; left:603px;"/>
<input type="text" name="ps1r02" id="ps1r02" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:268px; left:293px;"/>
<input type="text" name="ps2r02" id="ps2r02" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:268px; left:603px;"/>
<input type="text" name="ps1r03" id="ps1r03" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:307px; left:293px;"/>
<input type="text" name="ps2r03" id="ps2r03" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:307px; left:603px;"/>
<input type="text" name="ps1r04" id="ps1r04" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:347px; left:293px;"/>
<input type="text" name="ps2r04" id="ps2r04" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:347px; left:603px;"/>
<input type="text" name="ps1r05" id="ps1r05" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:385px; left:293px;"/>
<input type="text" name="ps2r05" id="ps2r05" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:385px; left:603px;"/>
<div class="input-echo right" style="width:290px; top:425px; left:293px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $ps1r06; ?>&nbsp;</div>
<div class="input-echo right" style="width:290px; top:425px; left:603px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $ps2r06; ?>&nbsp;</div>
<input type="text" name="psr07" id="psr07" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:484px; left:385px;"/>
<input type="text" name="psr08" id="psr08" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:524px; left:385px;"/>
<input type="text" name="psr09" id="psr09" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:562px; left:385px;"/>
<input type="text" name="psr10" id="psr10" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:601px; left:385px;"/>
<input type="text" name="psr11" id="psr11" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:640px; left:385px;"/>
<div class="input-echo right" style="width:290px; top:680px; left:384px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $psr12; ?>&nbsp;</div>
<div class="input-echo right" style="width:290px; top:719px; left:384px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $psr13; ?>&nbsp;</div>
<input type="text" name="ps1r14" id="ps1r14" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:823px; left:293px;"/>
<input type="text" name="ps2r14" id="ps2r14" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:823px; left:603px;"/>
<input type="text" name="ps1r15" id="ps1r15" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:862px; left:293px;"/>
<input type="text" name="ps2r15" id="ps2r15" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:862px; left:603px;"/>
<input type="text" name="ps1r16" id="ps1r16" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:901px; left:293px;"/>
<input type="text" name="ps2r16" id="ps2r16" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:901px; left:603px;"/>
<input type="text" name="ps1r17" id="ps1r17" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:940px; left:293px;"/>
<input type="text" name="ps2r17" id="ps2r17" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:940px; left:603px;"/>
<input type="text" name="ps1r18" id="ps1r18" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:979px; left:293px;"/>
<input type="text" name="ps2r18" id="ps2r18" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:979px; left:603px;"/>
<div class="input-echo right" style="width:290px; top:1018px; left:293px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $ps1r19; ?>&nbsp;</div>
<div class="input-echo right" style="width:290px; top:1018px; left:603px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $ps2r19; ?>&nbsp;</div>
<input type="text" name="psr20" id="psr20" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:1078px; left:385px;"/>
<input type="text" name="psr21" id="psr21" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:1117px; left:385px;"/>
<input type="text" name="psr22" id="psr22" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:1155px; left:385px;"/>
<input type="text" name="psr23" id="psr23" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:1195px; left:385px;"/>
<?php                     } ?>


<?php if ( $strana == 11 ) { ?>
<img src="<?php echo $jpg_source; ?>_str11.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>
<!-- IV.CAST pokracovanie -->

<input type="text" name="psr24" id="psr24" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:114px; left:500px;"/>
<div class="input-echo right" style="width:290px; top:154px; left:500px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $psr25; ?>&nbsp;</div>

<input type="text" name="psr26" id="psr26" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:193px; left:500px;"/>
<input type="text" name="psr27" id="psr27" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:232px; left:500px;"/>
<input type="text" name="psr29" id="psr29" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:310px; left:500px;"/>

<input type="text" name="psr30" id="psr30" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:359px; left:500px;"/>
<input type="text" name="psr31" id="psr31" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:421px; left:500px;"/>
<!-- V.CAST -->
<input type="text" name="ozd1r01" id="ozd1r01" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:608px; left:293px;"/>
<input type="text" name="ozd1r02" id="ozd1r02" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:648px; left:293px;"/>
<input type="text" name="ozd1r03" id="ozd1r03" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:690px; left:293px;"/>
<input type="text" name="ozd1r04" id="ozd1r04" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:729px; left:293px;"/>
<input type="text" name="ozd2r04" id="ozd2r04" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:729px; left:603px;"/>
<input type="text" name="ozd1r05" id="ozd1r05" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:768px; left:293px;"/>
<input type="text" name="ozd2r05" id="ozd2r05" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:768px; left:603px;"/>
<div class="input-echo right" style="width:290px; top:808px; left:294px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $ozd1r06; ?>&nbsp;</div>
<div class="input-echo right" style="width:290px; top:808px; left:605px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $ozd2r06; ?>&nbsp;</div>

<input type="text" name="ozdr07" id="ozdr07" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:919px; left:385px;"/>
<input type="text" name="ozdr09" id="ozdr09" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:996px; left:385px;"/>

<?php                     } ?>


<?php if ( $strana == 12 ) { ?>
<img src="<?php echo $jpg_source; ?>_str12.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>
<!-- VI.CAST -->
<input type="checkbox" name="pzano" value="1" style="top:144px; left:59px;"/>
<input type="checkbox" name="zslu" value="1" style="top:144px; left:318px;"/>
<input type="text" name="pcdan" id="pcdan" onkeyup="CiarkaNaBodku(this);" style="width:268px; top:183px; left:626px;"/> <!-- dopyt, new -->
<input type="text" name="pcdar" id="pcdar" onkeyup="CiarkaNaBodku(this);" style="width:268px; top:224px; left:626px;"/>
<input type="text" name="pcpod" id="pcpod" onkeyup="CiarkaNaBodku(this);" style="width:268px; top:266px; left:626px;"/>
<input type="text" name="pc155" id="pc155" onkeyup="CiarkaNaBodku(this);" style="width:268px; top:307px; left:626px;"/>
<input type="text" name="pcpoc" id="pcpoc" style="width:84px; top:348px; left:626px;"/>
<!-- Prijimatel 1 -->
<input type="text" name="pcsum" id="pcsum" onkeyup="CiarkaNaBodku(this);" style="width:268px; top:482px; left:201px;"/>
<input type="text" name="p1ico" id="p1ico" maxlength="12" style="width:266px; top:539px; left:51px;"/>
<input type="text" name="p1pfr" id="p1pfr" style="width:519px; top:539px; left:374px;"/>
<input type="text" name="p1men" id="p1men" style="width:842px; height:60px; top:590px; left:51px;"/>
<input type="text" name="p1uli" id="p1uli" style="width:635px; top:697px; left:51px;"/>
<input type="text" name="p1cdm" id="p1cdm" style="width:174px; top:697px; left:719px;"/>
<input type="text" name="p1psc" id="p1psc" style="width:106px; top:751px; left:51px;"/>
<input type="text" name="p1mes" id="p1mes" style="width:703px; top:751px; left:190px;"/>
<!-- VII.CAST -->
<textarea name="osobit" id="osobit" style="width:838px; height:327px; top:900px; left:53px;"><?php echo $osobit; ?></textarea>
<?php                     } ?>

<?php if ( $strana == 13 ) { ?>
<img src="<?php echo $jpg_source; ?>_str13.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>
<!-- Osoba opravnena -->
<input type="text" name="ooprie" id="ooprie" style="width:358px; top:153px; left:52px;"/>
<input type="text" name="oomeno" id="oomeno" style="width:243px; top:153px; left:430px;"/>
<input type="text" name="ootitl" id="ootitl" style="width:112px; top:153px; left:695px;"/>
<input type="text" name="otitz" id="otitz" style="width:66px; top:153px; left:827px;"/>
<input type="text" name="oopost" id="oopost" style="width:841px; top:206px; left:52px;"/>
<input type="text" name="oouli" id="oouli" style="width:634px; top:282px; left:52px;"/>
<input type="text" name="oocdm" id="oocdm" style="width:177px; top:282px; left:717px;"/>
<input type="text" name="oopsc" id="oopsc" style="width:105px; top:338px; left:52px;"/>
<input type="text" name="oomes" id="oomes" style="width:450px; top:338px; left:178px;"/>
<input type="text" name="oostat" id="oostat" style="width:245px; top:338px; left:649px;"/>
<input type="text" name="ootel" id="ootel" style="width:289px; top:393px; left:52px;"/>
<input type="text" name="oofax" id="oofax" style="width:521px; top:393px; left:373px;"/>
<input type="text" name="pril" id="pril" style="width:59px; top:443px; left:143px;"/>
<input type="text" name="datum" id="datum" onclick="dajDnes();" onkeyup="CiarkaNaBodku(this);" style="width:198px; top:543px; left:63px;"/>
<!-- VIII.CAST -->
<input type="checkbox" name="ozdspl" value="1" style="top:624px; left:59px;"/>
<input type="text" name="ozdspl1dat" id="ozdspl1dat" onkeyup="CiarkaNaBodku(this);" style="width:198px; top:677px; left:189px;"/>
<input type="text" name="ozdspl1sum" id="ozdspl1sum" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:677px; left:471px;"/>
<input type="text" name="ozdspl2dat" id="ozdspl2dat" onkeyup="CiarkaNaBodku(this);" style="width:198px; top:715px; left:189px;"/>
<input type="text" name="ozdspl2sum" id="ozdspl2sum" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:715px; left:471px;"/>
<input type="text" name="ozdspl3dat" id="ozdspl3dat" onkeyup="CiarkaNaBodku(this);" style="width:198px; top:754px; left:189px;"/>
<input type="text" name="ozdspl3sum" id="ozdspl3sum" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:754px; left:471px;"/>
<input type="text" name="ozdspl4dat" id="ozdspl4dat" onkeyup="CiarkaNaBodku(this);" style="width:198px; top:793px; left:189px;"/>
<input type="text" name="ozdspl4sum" id="ozdspl4sum" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:793px; left:471px;"/>
<input type="text" name="ozdspl5dat" id="ozdspl5dat" onkeyup="CiarkaNaBodku(this);" style="width:198px; top:833px; left:189px;"/>
<input type="text" name="ozdspl5sum" id="ozdspl5sum" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:833px; left:471px;"/>
<input type="text" name="ozdspldat" id="ozdspldat" onkeyup="CiarkaNaBodku(this);" style="width:198px; top:942px; left:63px;"/>
<!-- IX.CAST -->
<input type="checkbox" name="vrat" value="1" style="top:1025px; left:59px;"/>
<input type="checkbox" name="vrpp" value="1" onchange="klikpost();" style="top:1065px; left:122px;"/>
<input type="checkbox" name="vruc" value="1" onchange="klikucet();" style="top:1065px; left:324px;"/>
<!-- iban a ucet -->
<div class="input-echo" style="width:773px; top:1095px; left:117px;"><?php echo $fir_fib1; ?></div>
<input type="text" name="datuk" id="datuk" onkeyup="CiarkaNaBodku(this);" style="width:197px; top:1208px; left:63px;"/>
<script>
  function klikpost()
  {
   document.formv1.vruc.checked = false;
  }
  function klikucet()
  {
   document.formv1.vrpp.checked = false;
  }
</script>
<?php                     } ?>

<?php if ( $strana == 14 ) { ?>
<img src="<?php echo $jpg_source; ?>_str14.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>

<input type="text" name="vos13a" id="vos13a" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:150px; left:500px;"/>
<textarea name="pat13a" id="pat13a" style="width:838px; height:160px; top:220px; left:53px;"><?php echo $pat13a; ?></textarea>
<input type="text" name="vos13b" id="vos13b" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:404px; left:500px;"/>
<textarea name="pat13b" id="pat13b" style="width:838px; height:160px; top:474px; left:53px;"><?php echo $pat13b; ?></textarea>
<div class="input-echo right" style="width:290px; top:660px; left:500px;" title="Hodnota sa prepoËÌta po uloûenÌ zmien na strane"><?php echo $vosspl; ?>&nbsp;</div>


<?php                     } ?>

<div class="navbar">
  <a href="#" onclick="editForm(1);" class="<?php echo $clas1; ?> toleft">1</a>
  <a href="#" onclick="editForm(2);" class="<?php echo $clas2; ?> toleft">2</a>
  <a href="#" onclick="editForm(3);" class="<?php echo $clas3; ?> toleft">3</a>
  <a href="#" onclick="editForm(4);" class="<?php echo $clas4; ?> toleft">4</a>
  <a href="#" onclick="editForm(5);" class="<?php echo $clas5; ?> toleft">5</a>
  <a href="#" onclick="editForm(6);" class="<?php echo $clas6; ?> toleft">6</a>
  <a href="#" onclick="editForm(7);" class="<?php echo $clas7; ?> toleft">7</a>
  <a href="#" onclick="editForm(8);" class="<?php echo $clas8; ?> toleft">8</a>
  <a href="#" onclick="editForm(9);" class="<?php echo $clas9; ?> toleft">9</a>
  <a href="#" onclick="editForm(10);" class="<?php echo $clas10; ?> toleft">10</a>
  <a href="#" onclick="editForm(11);" class="<?php echo $clas11; ?> toleft">11</a>
  <a href="#" onclick="editForm(12);" class="<?php echo $clas12; ?> toleft">12</a>
  <a href="#" onclick="editForm(13);" class="<?php echo $clas13; ?> toleft">13</a>
  <a href="#" onclick="editForm(14);" class="<?php echo $clas14; ?> toleft">14</a>
<a href="#" onclick="window.open('priznanie_dppriloha2018.php?copern=1101&drupoh=1', '_self')" class="toleft">V˝zkum</a>
<a href="#" onclick="window.open('priznanie_dppriloha2018.php?copern=101&drupoh=1', '_self')" class="toleft">PrÌj2%</a>
<input type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>
</form>

<?php if ( $strana == 5 ) { ?>
<!-- pripocitalne nastavenie -->
<style>
form.pripo-area {
  position: absolute;
  left: 524px;
  width: 385px;
  padding: 5px 7px;
  background-color: #ffff90;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); /* prefixy */
}
form.pripo-area > img {
  position: absolute;
  top: 6px;
  right: 7px;
  width: 22px;
  height: 22px;
  cursor: pointer;
  opacity: 1; /* prefixy */
}
form.pripo-area > img:hover {
  opacity: 0.8; /* prefixy */
}
form.pripo-area > input[type=submit] {
  float: right;
  width: 70px;
  height: 24px;
}
table.pripo-box {
  width: 100%;
  background-color: #add8e6;
  border-radius: 1px;
  margin-bottom: 4px;
}
table.pripo-box > caption {
  height: 48px;
  line-height: 48px;
  font-size: 11px;
  text-align: left;
  letter-spacing: .02em;
}
table.pripo-box > caption > strong {
  font-size: 14px;
  padding-right: 4px;
}
table.pripo-box input[type=text] {
  position: relative;
  left: 7px;
  width: 94%;
}
</style>
<form id="pripokno1" method="post" action="priznanie_po2018.php?strana=5&copern=5103" class="pripo-area" style="display:none; top:105px; height:832px;">
<img src="../obr/ikony/turnoff_blue_icon.png" title="Skryù" onclick="pripokno1.style.display='none'; pripoknobtn1.style.display='block';" >
<table class="pripo-box">
<caption><strong>Nastavenie ˙Ëtov</strong>( VyplÚte v plnom tvare, napr. 51301,51302 )</caption>
<tr>
 <td style="height:74px; line-height:74px;">
  <input type="text" name="a1u01" id="a1u01" value="<?php echo $a1u01; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:74px; line-height:74px;">
  <input type="text" name="a1u02" id="a1u02" value="<?php echo $a1u02; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:44px; line-height:44px;">
  <input type="text" name="a1u03" id="a1u03" value="<?php echo $a1u03; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:86px; line-height:86px;">
  <input type="text" name="a1u04" id="a1u04" value="<?php echo $a1u04; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:44px; line-height:44px;">
  <input type="text" name="a1u05" id="a1u05" value="<?php echo $a1u05; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:38px; line-height:38px;">
  <input type="text" name="a1u06" id="a1u06" value="<?php echo $a1u06; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:48px; line-height:48px;">
  <input type="text" name="a1u07" id="a1u07" value="<?php echo $a1u07; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:28px; line-height:28px;">
  <input type="text" name="a1u08" id="a1u08" value="<?php echo $a1u08; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:52px; line-height:52px;">
  <input type="text" name="a1u09" id="a1u09" value="<?php echo $a1u09; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:28px; line-height:28px;">
  <input type="text" name="a1u10" id="a1u10" value="<?php echo $a1u10; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:48px; line-height:48px;">
  <input type="text" name="a1u11" id="a1u11" value="<?php echo $a1u11; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:28px; line-height:28px;">
  <input type="text" name="a1u12" id="a1u12" value="<?php echo $a1u12; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:48px; line-height:48px;">
  <input type="text" name="a1u13" id="a1u13" value="<?php echo $a1u13; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:32px; line-height:32px;">
  <input type="text" name="a1u14" id="a1u14" value="<?php echo $a1u14; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:44px; line-height:44px;">
  <input type="text" name="a1u15" id="a1u15" value="<?php echo $a1u15; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:38px; line-height:32px;">
  <input type="text" name="a1u16" id="a1u16" value="<?php echo $a1u16; ?>"/>
 </td>
</tr>
</table>
<input type="submit" id="uloz" name="uloz" value="Uloûiù">
</form>
<?php                     } ?>
<?php
//mysql_free_result($vysledok);
    } //$copern==102
?>


<?php
//xml
if ( $copern == 10 )
     {


$zablokovane=1;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=1; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("Export do XML DaÚovÈho priznania DPPO 2018 bude pripraven˝ hneÔ po zverejnenÌ novÈho formul·ra na port·le DRSR. Aktu·lne info n·jdete na vstupnej str·nke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }



?>
<?php
$hhmm = Date( "Hi", MkTime( date("H"),date("i"),date("s"),date("m"),date("d"),date("Y") ) );
//$idx=$kli_uzid.$hhmm;
$kli_nxcf10 = substr($kli_nxcf,0,10);
$kli_nxcf10=trim(str_replace(" ","",$kli_nxcf10));
$kli_nxcf10=trim(str_replace(".","",$kli_nxcf10));
$kli_nxcf10=trim(str_replace(",","",$kli_nxcf10));
$kli_nxcf10=trim(str_replace("-","",$kli_nxcf10));
$kli_nxcf10=trim(str_replace("%","",$kli_nxcf10));
$kli_nxcf10 = StrTr($kli_nxcf10, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é","aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

$nazsub="../tmp/dppo".$kli_vrok."_id".$kli_uzid."_".$kli_nxcf10."_".$hhmm.".xml";
//dopyt, eöte typ priznania

?>
<?php
//prva strana

$outfilexdel="../tmp/dppo".$kli_vrok."_id".$kli_uzid."_*.*";
foreach (glob("$outfilexdel") as $filename) { unlink($filename); }
$outfilex=$nazsub;
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

     $soubor = fopen("$nazsub", "a+");

//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_po ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$obdobie=$kli_vmes;
$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $j == 0 )
     {
  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n"; fwrite($soubor, $text);
  $text = "<dokument>"."\r\n"; fwrite($soubor, $text);

  $text = " <hlavicka>"."\r\n"; fwrite($soubor, $text);

$dic=$fir_fdic;
  $text = "  <dic><![CDATA[".$dic."]]></dic>"."\r\n"; fwrite($soubor, $text);
$ico=$fir_fico;
if ( $fir_fico < 1000000 ) { $ico="00".$fir_fico; }
  $text = "  <ico><![CDATA[".$ico."]]></ico>"."\r\n"; fwrite($soubor, $text);
$pravnaforma=$fir_uctt03;
  $text = "  <pravnaForma><![CDATA[".$pravnaforma."]]></pravnaForma>"."\r\n"; fwrite($soubor, $text);

  $text = "  <typDP>"."\r\n"; fwrite($soubor, $text);
$rdp="1"; $odp="0"; $ddp="0";
if ( $hlavicka->druh == 2 ) { $rdp="0"; $odp="1"; $ddp="0"; }
if ( $hlavicka->druh == 3 ) { $rdp="0"; $odp="0"; $ddp="1"; }
  $text = "   <rdp><![CDATA[".$rdp."]]></rdp>"."\r\n"; fwrite($soubor, $text);
  $text = "   <odp><![CDATA[".$odp."]]></odp>"."\r\n"; fwrite($soubor, $text);
  $text = "   <ddp><![CDATA[".$ddp."]]></ddp>"."\r\n"; fwrite($soubor, $text);
  $text = "  </typDP>"."\r\n"; fwrite($soubor, $text);

$textod=SkDatum($hlavicka->obod);
if ( $textod == '00.00.0000' ) { $textod="01.01.".$kli_vrok; }
$textdo=SkDatum($hlavicka->obdo);
if ( $textdo == '00.00.0000' ) { $textdo="31.12.".$kli_vrok; }

  $text = "  <zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "   <od><![CDATA[".$textod."]]></od>"."\r\n"; fwrite($soubor, $text);
  $text = "   <do><![CDATA[".$textdo."]]></do>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);

  $text = "  <skNace>"."\r\n"; fwrite($soubor, $text);
$fir_sknace=trim($fir_sknace);
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sknaceb=$pole[1];
$sknacec=$pole[2];
$k1=$sknacea;
  $text = "   <k1><![CDATA[".$k1."]]></k1>"."\r\n"; fwrite($soubor, $text);
$k2=$sknaceb;
  $text = "   <k2><![CDATA[".$k2."]]></k2>"."\r\n"; fwrite($soubor, $text);
$k3=$sknacec;
  $text = "   <k3><![CDATA[".$k3."]]></k3>"."\r\n"; fwrite($soubor, $text);
$cinnost=iconv("CP1250", "UTF-8", $hlavicka->cinnost);
  $text = "   <cinnost><![CDATA[".$cinnost."]]></cinnost>"."\r\n"; fwrite($soubor, $text);
  $text = "  </skNace>"."\r\n"; fwrite($soubor, $text);

  $text = "  <obchodneMeno>"."\r\n"; fwrite($soubor, $text);
$obchodneMeno = iconv("CP1250", "UTF-8", $fir_fnaz);
  $text = "   <riadok><![CDATA[".$obchodneMeno."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "   <riadok></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "   <riadok></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "  </obchodneMeno>"."\r\n";   fwrite($soubor, $text);

  $text = "  <sidlo>"."\r\n"; fwrite($soubor, $text);
$ulica= iconv("CP1250", "UTF-8", $fir_fuli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$fir_fcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$fir_fpsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec = iconv("CP1250", "UTF-8", $fir_fmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$sql = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$vysledok = mysql_query($sql);
if ( $vysledok ) {
$riadok=mysql_fetch_object($vysledok);
$fstat = $riadok->fstat;
                 }
$stat = iconv("CP1250", "UTF-8", $fstat);
  $text = "   <stat><![CDATA[".$stat."]]></stat>"."\r\n"; fwrite($soubor, $text);
$telefon=$fir_ftel;
  $text = "   <tel><![CDATA[".$telefon."]]></tel>"."\r\n"; fwrite($soubor, $text);
$mailfax=iconv("CP1250", "UTF-8", $fir_fem1);
  $text = "   <emailFax><![CDATA[".$mailfax."]]></emailFax>"."\r\n"; fwrite($soubor, $text);
  $text = "  </sidlo>"."\r\n"; fwrite($soubor, $text);

$text=$hlavicka->uoskr;
  $text = "  <uplatnujemPar17><![CDATA[".$text."]]></uplatnujemPar17>"."\r\n"; fwrite($soubor, $text);
$text=$hlavicka->koskr;
  $text = "  <ukoncujemUplatnovaniePar17><![CDATA[".$text."]]></ukoncujemUplatnovaniePar17>"."\r\n"; fwrite($soubor, $text);
$obmedzenie=$hlavicka->nerezident;
  $text = "  <obmedzenie><![CDATA[".$obmedzenie."]]></obmedzenie>"."\r\n"; fwrite($soubor, $text);
$zapdl=$hlavicka->zapdl;
  $text = "  <zapocitaniePar46bAPar52zk><![CDATA[".$zapdl."]]></zapocitaniePar46bAPar52zk>"."\r\n"; fwrite($soubor, $text);
$prepojenie=$hlavicka->zahrprep;
  $text = "  <prepojenie><![CDATA[".$prepojenie."]]></prepojenie>"."\r\n"; fwrite($soubor, $text);
$platiteldph=$hlavicka->chpld;
  $text = "  <somPlatitel><![CDATA[".$platiteldph."]]></somPlatitel>"."\r\n"; fwrite($soubor, $text);
$obrat=$hlavicka->cho5k;
  $text = "  <rocnyObratPresiahol500tis><![CDATA[".$obrat."]]></rocnyObratPresiahol500tis>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->chpdl;
  $text = "  <polVyskaDanovejLicPar46bods3><![CDATA[".$riadok."]]></polVyskaDanovejLicPar46bods3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->chndl;
  $text = "  <neplatimDanLicenciu><![CDATA[".$riadok."]]></neplatimDanLicenciu>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->osl13;
  $text = "  <uplatnenieOslobodeniaPar13ab><![CDATA[".$riadok."]]></uplatnenieOslobodeniaPar13ab>"."\r\n"; fwrite($soubor, $text);

  $text = "  <stalaPrevadzkaren>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->pruli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->prcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->prpsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->prmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$pocetSp=1*$hlavicka->prpoc;
if ( $pocetSp == 0 ) { $pocetSp=""; }
  $text = "   <pocetSp><![CDATA[".$pocetSp."]]></pocetSp>"."\r\n"; fwrite($soubor, $text);
  $text = "  </stalaPrevadzkaren>"."\r\n"; fwrite($soubor, $text);

  $text = " </hlavicka>"."\r\n"; fwrite($soubor, $text);

//hlavicka OK podla definicie pre rok 2018

  $text = " <telo>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r100;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r100><![CDATA[".$riadok."]]></r100>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r110;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r110><![CDATA[".$riadok."]]></r110>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r130;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r130><![CDATA[".$riadok."]]></r130>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r140;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r140><![CDATA[".$riadok."]]></r140>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r150;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r150><![CDATA[".$riadok."]]></r150>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r170;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r170><![CDATA[".$riadok."]]></r170>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r180;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r180><![CDATA[".$riadok."]]></r180>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r200;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r200><![CDATA[".$riadok."]]></r200>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r210;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r210><![CDATA[".$riadok."]]></r210>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r220;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r220><![CDATA[".$riadok."]]></r220>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r230;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r230><![CDATA[".$riadok."]]></r230>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r240;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r240><![CDATA[".$riadok."]]></r240>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r250;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r250><![CDATA[".$riadok."]]></r250>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r260;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r260><![CDATA[".$riadok."]]></r260>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r270;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r270><![CDATA[".$riadok."]]></r270>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r280;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r280><![CDATA[".$riadok."]]></r280>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r290;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r290><![CDATA[".$riadok."]]></r290>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r300;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r300><![CDATA[".$riadok."]]></r300>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r301;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r301><![CDATA[".$riadok."]]></r301>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r302;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r302><![CDATA[".$riadok."]]></r302>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r303;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r303><![CDATA[".$riadok."]]></r303>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r304;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r304><![CDATA[".$riadok."]]></r304>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r305;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r305><![CDATA[".$riadok."]]></r305>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r306;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r306><![CDATA[".$riadok."]]></r306>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r306;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r307><![CDATA[".$riadok."]]></r307>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r308;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r308><![CDATA[".$riadok."]]></r308>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r310;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r310><![CDATA[".$riadok."]]></r310>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r320;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r320><![CDATA[".$riadok."]]></r320>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r330;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r330><![CDATA[".$riadok."]]></r330>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r400;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r400><![CDATA[".$riadok."]]></r400>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r410;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r410><![CDATA[".$riadok."]]></r410>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r500;
if ( $riadok == 0 ) $riadok="0.00";
  $text = "  <r500><![CDATA[".$riadok."]]></r500>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavicka->r510;
$riadok=$hlavicka->r501;
if ( $riadok == 0 ) $riadok="0";
  $text = "  <r501><![CDATA[".$riadok."]]></r501>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavicka->r510;
if ( $riadok == 0 ) $riadok="0";
  $text = "  <r510><![CDATA[".$riadok."]]></r510>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavicka->r550;
if ( $riadok == 0 ) $riadok="0";
  $text = "  <r550><![CDATA[".$riadok."]]></r550>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r600;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r600><![CDATA[".$riadok."]]></r600>"."\r\n"; fwrite($soubor, $text);
  $text = "  <r610>"."\r\n"; fwrite($soubor, $text);
$text=iconv("CP1250", "UTF-8", $hlavicka->r610text);
  $text = "   <text><![CDATA[".$text."]]></text>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r610;
if ( $riadok == 0 ) $riadok="";
  $text = "   <suma><![CDATA[".$riadok."]]></suma>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r610>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r700;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r700><![CDATA[".$riadok."]]></r700>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r710;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r710><![CDATA[".$riadok."]]></r710>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r800;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r800><![CDATA[".$riadok."]]></r800>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r810;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r810><![CDATA[".$riadok."]]></r810>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r820;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r820><![CDATA[".$riadok."]]></r820>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r900;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r900><![CDATA[".$riadok."]]></r900>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r910;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r910><![CDATA[".$riadok."]]></r910>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r920;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r920><![CDATA[".$riadok."]]></r920>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1000;
if ( $riadok == 0 ) $riadok="0.00";
  $text = "  <r1000><![CDATA[".$riadok."]]></r1000>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1010;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1010><![CDATA[".$riadok."]]></r1010>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1020;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1020><![CDATA[".$riadok."]]></r1020>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1030;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1030><![CDATA[".$riadok."]]></r1030>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1040;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1040><![CDATA[".$riadok."]]></r1040>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1050;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1050><![CDATA[".$riadok."]]></r1050>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1060;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1060><![CDATA[".$riadok."]]></r1060>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1061;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1061><![CDATA[".$riadok."]]></r1061>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1062;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1062><![CDATA[".$riadok."]]></r1062>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1070;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1070><![CDATA[".$riadok."]]></r1070>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1080;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1080><![CDATA[".$riadok."]]></r1080>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1090;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1090><![CDATA[".$riadok."]]></r1090>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1100;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1100><![CDATA[".$riadok."]]></r1100>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1101;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1101><![CDATA[".$riadok."]]></r1101>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1110;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1110><![CDATA[".$riadok."]]></r1110>"."\r\n"; fwrite($soubor, $text);

$ddpDatum=SkDatum($hlavicka->dadod);
if ( $ddp == 0 ) $ddpDatum="";
  $text = "  <ddpDatum><![CDATA[".$ddpDatum."]]></ddpDatum>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1120;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1120><![CDATA[".$riadok."]]></r1120>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1130;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1130><![CDATA[".$riadok."]]></r1130>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1140;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1140><![CDATA[".$riadok."]]></r1140>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1150;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1150><![CDATA[".$riadok."]]></r1150>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1160;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1160><![CDATA[".$riadok."]]></r1160>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1170;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1170><![CDATA[".$riadok."]]></r1170>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1180;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1180><![CDATA[".$riadok."]]></r1180>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1190;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1190><![CDATA[".$riadok."]]></r1190>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabA>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r04;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r05;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r06;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r07;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r08;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r08><![CDATA[".$riadok."]]></r08>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r09;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r09><![CDATA[".$riadok."]]></r09>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r10;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r10><![CDATA[".$riadok."]]></r10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r11;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r11><![CDATA[".$riadok."]]></r11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r12;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r12><![CDATA[".$riadok."]]></r12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r13;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r13><![CDATA[".$riadok."]]></r13>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r14;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r14><![CDATA[".$riadok."]]></r14>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r15;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r15><![CDATA[".$riadok."]]></r15>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r16;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r16><![CDATA[".$riadok."]]></r16>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r17;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r17><![CDATA[".$riadok."]]></r17>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabA>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabB>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->b1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->b1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->b1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->b1r04;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
//zmena 2015
$riadok=$hlavicka->b1r05;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->b1r06;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabB>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabC1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c1r04;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c1r05;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabC1>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabC2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c2r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c2r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c2r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c2r04;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c2r05;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabC2>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabD>"."\r\n"; fwrite($soubor, $text);
  $text = "   <tabDs01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d1r01;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d1r02;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d1r03;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs01>"."\r\n"; fwrite($soubor, $text);

  $text = "   <tabDs02>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d2od);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumOd><![CDATA[".$riadok."]]></datumOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d2do);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumDo><![CDATA[".$riadok."]]></datumDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d2r01;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d2r02;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d2r03;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs02>"."\r\n"; fwrite($soubor, $text);

  $text = "   <tabDs03>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d3od);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumOd><![CDATA[".$riadok."]]></datumOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d3do);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumDo><![CDATA[".$riadok."]]></datumDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d3r01;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d3r02;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d3r03;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs03>"."\r\n"; fwrite($soubor, $text);

  $text = "   <tabDs04>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d4od);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumOd><![CDATA[".$riadok."]]></datumOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d4do);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumDo><![CDATA[".$riadok."]]></datumDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d4r01;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d4r02;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d4r03;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs04>"."\r\n"; fwrite($soubor, $text);

  $text = "   <tabDs05>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d5od);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumOd><![CDATA[".$riadok."]]></datumOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d5do);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumDo><![CDATA[".$riadok."]]></datumDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d5r01;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d5r02;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d5r03;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs05>"."\r\n"; fwrite($soubor, $text);

  $text = "   <tabDs06>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d6od);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumOd><![CDATA[".$riadok."]]></datumOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d6do);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumDo><![CDATA[".$riadok."]]></datumDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d6r01;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d6r02;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d6r03;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs06>"."\r\n"; fwrite($soubor, $text);

  $text = "   <tabDs07>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d7od);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumOd><![CDATA[".$riadok."]]></datumOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d7do);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumDo><![CDATA[".$riadok."]]></datumDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d7r01;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d7r02;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d7r03;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs07>"."\r\n"; fwrite($soubor, $text);

//tuto mam d9r01.. ako posledny
  $text = "   <tabDs08>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d9r01;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d9r02;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d9r03;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs08>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabD>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabE>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->e1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->e1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->e1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->e1r04;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->e1r05;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->e1r06;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabE>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabF>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->f1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->f1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->f1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabF>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabG1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabG1>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabG2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g2r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g2r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g2r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabG2>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabG3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g3r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g3r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g3r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g3r04;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabG3>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabH>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->hr01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
  $text = "   <prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h1r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h1r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h1r06;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h1r07;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h1r08;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r08><![CDATA[".$riadok."]]></r08>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h1r09;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r09><![CDATA[".$riadok."]]></r09>"."\r\n"; fwrite($soubor, $text);
  $text = "   </prijmy>"."\r\n"; fwrite($soubor, $text);

  $text = "   <vydavky>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->h2r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h2r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h2r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h2r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h2r06;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h2r07;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h2r08;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r08><![CDATA[".$riadok."]]></r08>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h2r09;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r09><![CDATA[".$riadok."]]></r09>"."\r\n"; fwrite($soubor, $text);
  $text = "   </vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->hr10;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r10><![CDATA[".$riadok."]]></r10>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabH>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabI>"."\r\n"; fwrite($soubor, $text);
  $text = "   <vynosy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i1r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i1r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i1r06;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i1r07;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);
  $text = "   </vynosy>"."\r\n"; fwrite($soubor, $text);

  $text = "   <naklady>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i2r01;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i2r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i2r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i2r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i2r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i2r06;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i2r07;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);
  $text = "   </naklady>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabI>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabJ>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->jl1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->jl1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabJ>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabK>"."\r\n"; fwrite($soubor, $text);
  $text = "   <tabKs01>"."\r\n"; fwrite($soubor, $text);
$datumk1od=SkDatum($hlavicka->k1od);
if ( $datumk1od == '00.00.0000' ) $datumk1od="";
  $text = "    <r01s01od><![CDATA[".$datumk1od."]]></r01s01od>"."\r\n"; fwrite($soubor, $text);
$datumk1do=SkDatum($hlavicka->k1do);
if ( $datumk1do == '00.00.0000' ) $datumk1do="";
  $text = "    <r01s01do><![CDATA[".$datumk1do."]]></r01s01do>"."\r\n"; fwrite($soubor, $text);
$datumk2od=SkDatum($hlavicka->k2od);
if ( $datumk2od == '00.00.0000' ) $datumk2od="";
  $text = "    <r02s01od><![CDATA[".$datumk2od."]]></r02s01od>"."\r\n"; fwrite($soubor, $text);
$datumk2do=SkDatum($hlavicka->k2do);
if ( $datumk2do == '00.00.0000' ) $datumk2do="";
  $text = "    <r02s01do><![CDATA[".$datumk2do."]]></r02s01do>"."\r\n"; fwrite($soubor, $text);
$datumk3od=SkDatum($hlavicka->k3od);
if ( $datumk3od == '00.00.0000' ) $datumk3od="";
  $text = "    <r03s01od><![CDATA[".$datumk3od."]]></r03s01od>"."\r\n"; fwrite($soubor, $text);
$datumk3do=SkDatum($hlavicka->k3do);
if ( $datumk3do == '00.00.0000' ) $datumk3do="";
  $text = "    <r03s01do><![CDATA[".$datumk3do."]]></r03s01do>"."\r\n"; fwrite($soubor, $text);
$datumk4od=SkDatum($hlavicka->k4od);
if ( $datumk4od == '00.00.0000' ) $datumk4od="";
  $text = "    <r04s01od><![CDATA[".$datumk4od."]]></r04s01od>"."\r\n"; fwrite($soubor, $text);
$datumk4do=SkDatum($hlavicka->k4do);
if ( $datumk4do == '00.00.0000' ) $datumk4do="";
  $text = "    <r04s01do><![CDATA[".$datumk4do."]]></r04s01do>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabKs01>"."\r\n"; fwrite($soubor, $text);

  $text = "   <tabKs02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k2r01;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r01s02><![CDATA[".$riadok."]]></r01s02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k2r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02s02><![CDATA[".$riadok."]]></r02s02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k2r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03s02><![CDATA[".$riadok."]]></r03s02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k2r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04s02><![CDATA[".$riadok."]]></r04s02>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabKs02>"."\r\n"; fwrite($soubor, $text);

  $text = "   <tabKs03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k3r01;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r01s03><![CDATA[".$riadok."]]></r01s03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k3r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02s03><![CDATA[".$riadok."]]></r02s03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k3r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03s03><![CDATA[".$riadok."]]></r03s03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k3r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04s03><![CDATA[".$riadok."]]></r04s03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabKs03>"."\r\n"; fwrite($soubor, $text);


  $text = "   <tabKs04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k4r01;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r01s04><![CDATA[".$riadok."]]></r01s04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k4r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02s04><![CDATA[".$riadok."]]></r02s04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k4r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03s04><![CDATA[".$riadok."]]></r03s04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k4r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04s04><![CDATA[".$riadok."]]></r04s04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k4r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05s04><![CDATA[".$riadok."]]></r05s04>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabKs04>"."\r\n"; fwrite($soubor, $text);

  $text = "   <tabKs05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k5r01;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r01s05><![CDATA[".$riadok."]]></r01s05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k5r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02s05><![CDATA[".$riadok."]]></r02s05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k5r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03s05><![CDATA[".$riadok."]]></r03s05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k5r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04s05><![CDATA[".$riadok."]]></r04s05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k5r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05s05><![CDATA[".$riadok."]]></r05s05>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabKs05>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabK>"."\r\n"; fwrite($soubor, $text);

  $text = "  <zdaneniePar17f>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps1r01; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps2r01; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</r01>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps1r02; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps2r02; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</r02>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps1r03; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps2r03; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</r03>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps1r04; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps2r04; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</r04>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps1r05; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps2r05; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</r05>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps1r06; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps2r06; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</r06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr07; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr08; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r08><![CDATA[".$riadok."]]></r08>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr09; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r09><![CDATA[".$riadok."]]></r09>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr10; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r10><![CDATA[".$riadok."]]></r10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr11; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r11><![CDATA[".$riadok."]]></r11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr12; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r12><![CDATA[".$riadok."]]></r12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr13; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r13><![CDATA[".$riadok."]]></r13>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r14>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps1r14; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps2r14; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</r14>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r15>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps1r15; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps2r15; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</r15>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r16>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps1r16; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps2r16; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</r16>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r17>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps1r17; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps2r17; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</r17>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r18>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps1r18; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps2r18; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</r18>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r19>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps1r19; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ps2r19; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</r19>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr20; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r20><![CDATA[".$riadok."]]></r20>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr21; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r21><![CDATA[".$riadok."]]></r21>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr22; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r22><![CDATA[".$riadok."]]></r22>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr23; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r23><![CDATA[".$riadok."]]></r23>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr24; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r24><![CDATA[".$riadok."]]></r24>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr25; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r25><![CDATA[".$riadok."]]></r25>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr26; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r26><![CDATA[".$riadok."]]></r26>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr27; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r27><![CDATA[".$riadok."]]></r27>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r28>21</r28>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr29; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r29><![CDATA[".$riadok."]]></r29>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr30; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r30><![CDATA[".$riadok."]]></r30>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->psr31; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r31><![CDATA[".$riadok."]]></r31>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zdaneniePar17f>"."\r\n"; fwrite($soubor, $text);

  $text = "  <podielyNaZisku>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r01; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r02; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r03; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r04; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd2r04; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</r04>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r05; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd2r05; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</r05>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r06; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd2r06; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</r06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r07; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<r08>35</r08>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r09; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	<r09><![CDATA[".$riadok."]]></r09>"."\r\n"; fwrite($soubor, $text);
  $text = "  </podielyNaZisku>"."\r\n"; fwrite($soubor, $text);

$paragraf50=1*$hlavicka->pzano;
  $text = "  <c4paragraf50><![CDATA[".$paragraf50."]]></c4paragraf50>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->zslu;
  $text = "    <suhlasZasl><![CDATA[".$riadok."]]></suhlasZasl>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->pcdan;
if ( $riadok == 0 ) $riadok="";
  $text = "  <c4r1><![CDATA[".$riadok."]]></c4r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pcdar;
if ( $riadok == 0 ) $riadok="";
  $text = "  <c4r2><![CDATA[".$riadok."]]></c4r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pcpod;
if ( $riadok == 0 ) $riadok="";
  $text = "  <c4r3><![CDATA[".$riadok."]]></c4r3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pc155;
if ( $riadok == 0 ) $riadok="";
  $text = "  <c4r4><![CDATA[".$riadok."]]></c4r4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pcpoc;
if ( $riadok == 0 ) $riadok="";
  $text = "  <c4r5><![CDATA[".$riadok."]]></c4r5>"."\r\n"; fwrite($soubor, $text);

  $text = "  <c4prijimatel1>"."\r\n"; fwrite($soubor, $text);
$suma=$hlavicka->pcsum;
if ( $suma == 0 ) $suma="";
  $text = "   <suma><![CDATA[".$suma."]]></suma>"."\r\n"; fwrite($soubor, $text);
$pico1=$hlavicka->p1ico;
if ( $pico1 == 0 ) $pico1="";
if ( $hlavicka->p1ico < 1000000 AND $hlavicka->p1ico > 1 ) { $pico1="00".$hlavicka->p1ico; }
  $text = "   <ico><![CDATA[".$pico1."]]></ico>"."\r\n"; fwrite($soubor, $text);
$pravnaForma=iconv("CP1250", "UTF-8", $hlavicka->p1pfr);
  $text = "   <pravnaForma><![CDATA[".$pravnaForma."]]></pravnaForma>"."\r\n"; fwrite($soubor, $text);
  $text = "   <obchodneMeno>"."\r\n"; fwrite($soubor, $text);
$obchodneMeno=iconv("CP1250", "UTF-8", substr($hlavicka->p1men,0,37));
$obchodneMeno2=iconv("CP1250", "UTF-8", substr($hlavicka->p1men,37,36));
  $text = "    <riadok><![CDATA[".$obchodneMeno."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "    <riadok><![CDATA[".$obchodneMeno2."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "   </obchodneMeno>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->p1uli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->p1cdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->p1psc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->p1mes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
  $text = "  </c4prijimatel1>"."\r\n"; fwrite($soubor, $text);

$osobitneZaznamy=iconv("CP1250", "UTF-8", $hlavicka->osobit);
  $text = "  <osobitneZaznamy><![CDATA[".$osobitneZaznamy."]]></osobitneZaznamy>"."\r\n"; fwrite($soubor, $text);

  $text = "  <opravnenaOsoba>"."\r\n"; fwrite($soubor, $text);
$priezvisko=iconv("CP1250", "UTF-8", $hlavicka->ooprie);
  $text = "   <priezvisko><![CDATA[".$priezvisko."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
$meno=iconv("CP1250", "UTF-8", $hlavicka->oomeno);
  $text = "   <meno><![CDATA[".$meno."]]></meno>"."\r\n"; fwrite($soubor, $text);
$titul=$hlavicka->ootitl;
  $text = "   <titul><![CDATA[".$titul."]]></titul>"."\r\n"; fwrite($soubor, $text);
$titul=$hlavicka->otitz;
  $text = "   <titulZa><![CDATA[".$titul."]]></titulZa>"."\r\n"; fwrite($soubor, $text);
$postavenie=iconv("CP1250", "UTF-8", $hlavicka->oopost);
  $text = "   <postavenie><![CDATA[".$postavenie."]]></postavenie>"."\r\n"; fwrite($soubor, $text);

  $text = "   <trvalyPobyt>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->oouli);
  $text = "    <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->oocdm;
  $text = "    <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->oopsc;
  $text = "    <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->oomes);
  $text = "    <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$stat=iconv("CP1250", "UTF-8", $hlavicka->oostat);
  $text = "    <stat><![CDATA[".$stat."]]></stat>"."\r\n"; fwrite($soubor, $text);
$otelefon=$hlavicka->ootel;
  $text = "    <tel><![CDATA[".$otelefon."]]></tel>"."\r\n"; fwrite($soubor, $text);
$oemailfax=iconv("CP1250", "UTF-8", $hlavicka->oofax);
  $text = "    <emailFax><![CDATA[".$oemailfax."]]></emailFax>"."\r\n"; fwrite($soubor, $text);
  $text = "   </trvalyPobyt>"."\r\n"; fwrite($soubor, $text);
  $text = "  </opravnenaOsoba>"."\r\n"; fwrite($soubor, $text);

$pocetPriloh=$hlavicka->pril;
if ( $pocetPriloh == 0 ) $pocetPriloh="";
  $text = "  <pocetPriloh><![CDATA[".$pocetPriloh."]]></pocetPriloh>"."\r\n"; fwrite($soubor, $text);
$datumvyhl=SkDatum($hlavicka->datum);
if ( $datumvyhl == '00.00.0000' ) $datumvyhl="";
  $text = "  <datumVyhlasenia><![CDATA[".$datumvyhl."]]></datumVyhlasenia>"."\r\n"; fwrite($soubor, $text);


  $text = "  <platenieDanePar17f>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavicka->ozdspl;
  $text = "  	<ziadam17f><![CDATA[".$riadok."]]></ziadam17f>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<splatka>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->ozdspl1dat); if ( $riadok == '00.00.0000' ) { $riadok=""; }
  $text = "  		<datumSplat><![CDATA[".$riadok."]]></datumSplat>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdspl1sum; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<suma><![CDATA[".$riadok."]]></suma>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</splatka>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<splatka>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->ozdspl2dat); if ( $riadok == '00.00.0000' ) { $riadok=""; }
  $text = "  		<datumSplat><![CDATA[".$riadok."]]></datumSplat>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdspl2sum; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<suma><![CDATA[".$riadok."]]></suma>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</splatka>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<splatka>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->ozdspl3dat); if ( $riadok == '00.00.0000' ) { $riadok=""; }
  $text = "  		<datumSplat><![CDATA[".$riadok."]]></datumSplat>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdspl3sum; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<suma><![CDATA[".$riadok."]]></suma>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</splatka>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<splatka>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->ozdspl4dat); if ( $riadok == '00.00.0000' ) { $riadok=""; }
  $text = "  		<datumSplat><![CDATA[".$riadok."]]></datumSplat>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdspl4sum; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  		<suma><![CDATA[".$riadok."]]></suma>"."\r\n"; fwrite($soubor, $text);
  $text = "  	</splatka>"."\r\n"; fwrite($soubor, $text);
  $text = "  	<splatka>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->ozdspl5dat); if ( $riadok == '00.00.0000' ) { $riadok=""; }
  $text = "  		<datumSplat><![CDATA[".$riadok."]]></datumSplat>"."\r\n"; fwrite($soubor, $text);
  $text = "  		<suma><![CDATA[".$riadok."]]></suma>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdspl5sum; if ( $riadok == 0 ) { $riadok=""; }
  $text = "  	</splatka>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->ozdspldat); if ( $riadok == '00.00.0000' ) { $riadok=""; }
  $text = "  	<datum><![CDATA[".$riadok."]]></datum>"."\r\n"; fwrite($soubor, $text);
  $text = "  </platenieDanePar17f>"."\r\n"; fwrite($soubor, $text);


  $text = "  <vrateniePreplatku>"."\r\n"; fwrite($soubor, $text);
$vratit=$hlavicka->vrat;
  $text = "   <vratit><![CDATA[".$vratit."]]></vratit>"."\r\n"; fwrite($soubor, $text);
  $text = "   <sposobPlatby>"."\r\n";   fwrite($soubor, $text);
$poukazka=$hlavicka->vrpp;
if ( $vratit == 0 OR $hlavicka->vruc == 1 ) $poukazka="0";
  $text = "    <poukazka><![CDATA[".$poukazka."]]></poukazka>"."\r\n"; fwrite($soubor, $text);
$ucet=$hlavicka->vruc;
if ( $vratit == 0 ) $ucet="0";
  $text = "    <ucet><![CDATA[".$ucet."]]></ucet>"."\r\n"; fwrite($soubor, $text);
  $text = "   </sposobPlatby>"."\r\n"; fwrite($soubor, $text);

  $text = "   <bankovyUcet>"."\r\n"; fwrite($soubor, $text);
$iban="";
if ( $hlavicka->vruc == 1 AND $hlavicka->vrat == 1 ) { $iban=$fir_fib1; }
  $text = "    <IBAN><![CDATA[".$iban."]]></IBAN>"."\r\n"; fwrite($soubor, $text);

  $text = "   </bankovyUcet>"."\r\n"; fwrite($soubor, $text);

$datum_sk=SkDatum($hlavicka->datuk);
if ( $datum_sk == '00.00.0000' ) $datum_sk="";
  $text = "   <datum><![CDATA[".$datum_sk."]]></datum>"."\r\n"; fwrite($soubor, $text);
  $text = "  </vrateniePreplatku>"."\r\n"; fwrite($soubor, $text);

//prilPar13aA13b nove 2018
  $text = "  <prilPar13aA13b>"."\r\n"; fwrite($soubor, $text);
$hodnota=1*$hlavicka->vos13a;
if ( $hodnota == 0 ) $$hodnota="";
  $text = "   <r01><![CDATA[".$hodnota."]]></r01>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->pat13a;
  $text = "   <cisloPatentuSoftver><![CDATA[".$hodnota."]]></cisloPatentuSoftver>"."\r\n"; fwrite($soubor, $text);
$hodnota=1*$hlavicka->vos13b;
if ( $hodnota == 0 ) $$hodnota="";
  $text = "   <r02><![CDATA[".$hodnota."]]></r02>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->pat13b;
  $text = "   <cisloPatentu><![CDATA[".$hodnota."]]></cisloPatentu>"."\r\n"; fwrite($soubor, $text);
$hodnota=1*$hlavicka->vosspl;
if ( $hodnota == 0 ) $$hodnota="";
  $text = "   <r03><![CDATA[".$hodnota."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "  </prilPar13aA13b>"."\r\n"; fwrite($soubor, $text);

//vytlac prilohu o projektoch

$sqlttp = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dpprilpro WHERE prcpr > 0 ORDER BY prcpr ";
$sqlp = mysql_query("$sqlttp");
if ($sqlp) { $polp = mysql_num_rows($sqlp); }
$strxx=$polp/1;
$polp=ceil($strxx);

$ip=0;
$stranap=0;
$stlpecp=1;
  while ( $ip < $polp )
  {
@$zaznam=mysql_data_seek($sqlp,$ip);
$hlavickap=mysql_fetch_object($sqlp);

  $text = "  <prilPar30cOdpocetVydavkov>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavickap->prcpr;
if ( $riadok == 0 ) $riadok="";
  $text = "    <projektCislo><![CDATA[".$riadok."]]></projektCislo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prppp;
if ( $riadok == 0 ) $riadok="";
  $text = "    <pocetProjektov><![CDATA[".$riadok."]]></pocetProjektov>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpdzc);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumRealizacie><![CDATA[".$riadok."]]></datumRealizacie>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r01>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzo1);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Od><![CDATA[".$riadok."]]></s01Od>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzd1);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Do><![CDATA[".$riadok."]]></s01Do>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpvz1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s02><![CDATA[".$riadok."]]></s02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpod1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s03><![CDATA[".$riadok."]]></s03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r01>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r02>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzo2);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Od><![CDATA[".$riadok."]]></s01Od>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzd2);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Do><![CDATA[".$riadok."]]></s01Do>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpvz2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s02><![CDATA[".$riadok."]]></s02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpod2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s03><![CDATA[".$riadok."]]></s03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r02>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r03>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzo3);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Od><![CDATA[".$riadok."]]></s01Od>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzd3);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Do><![CDATA[".$riadok."]]></s01Do>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpvz3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s02><![CDATA[".$riadok."]]></s02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpod3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s03><![CDATA[".$riadok."]]></s03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r03>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r04>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzo4);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Od><![CDATA[".$riadok."]]></s01Od>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzd4);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Do><![CDATA[".$riadok."]]></s01Do>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpvz4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s02><![CDATA[".$riadok."]]></s02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpod4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s03><![CDATA[".$riadok."]]></s03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r04>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r05>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzo5);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Od><![CDATA[".$riadok."]]></s01Od>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzd5);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Do><![CDATA[".$riadok."]]></s01Do>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpvz5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s02><![CDATA[".$riadok."]]></s02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpod5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s03><![CDATA[".$riadok."]]></s03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r05>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavickap->prpods;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavickap->prptxt);
  $text = "    <ciele><![CDATA[".$riadok."]]></ciele>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpodv1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpodv2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r08><![CDATA[".$riadok."]]></r08>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpodv;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r09><![CDATA[".$riadok."]]></r09>"."\r\n"; fwrite($soubor, $text);

  $text = "  </prilPar30cOdpocetVydavkov>"."\r\n"; fwrite($soubor, $text);

$ip = $ip + 1;
  }

//koniec vytlac prilohu o projektoch

//vytlac prilohu o prijimateloch
$sqlttp = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dppriloha WHERE p1cis > 0 ORDER BY p1cis";
$sqlp = mysql_query("$sqlttp");
if ($sqlp) { $polp = mysql_num_rows($sqlp); }
$strxx=$polp/3;
$polp=ceil($strxx);
$polp=$polp*3;

$ip=0;
$stranap=0;
$stlpecp=1;
  while ( $ip < $polp )
  {
@$zaznam=mysql_data_seek($sqlp,$ip);
$hlavickap=mysql_fetch_object($sqlp);

if ( $stlpecp == 1 ) {
$stranap=$stranap+1;

  $text = "  <priloha>"."\r\n"; fwrite($soubor, $text);
                     }

$sumaxx=$hlavickap->pcsum;

if( $sumaxx > 0 ) {

  $text = "   <prijimatel>"."\r\n"; fwrite($soubor, $text);

//p1cpl  psys  druh  p1cis  pcsum  p1ico  p1pfr  p1men  p1uli  p1cdm  p1psc  p1mes  ico

$poradoveCislo=$hlavickap->p1cis;
$suma=$hlavickap->pcsum;
$pico=$hlavickap->p1ico;
if ( $hlavickap->p1ico < 1000000 AND $hlavickap->p1ico > 0 ) { $pico="00".$hlavickap->p1ico; }
//$psid=$hlavickap->p1sid;
$pravnaForma=iconv("CP1250", "UTF-8", $hlavickap->p1pfr);
$obchodneMeno=iconv("CP1250", "UTF-8", $hlavickap->p1men);
$ulica=iconv("CP1250", "UTF-8", $hlavickap->p1uli);
$cislo=$hlavickap->p1cdm;
$psc=$hlavickap->p1psc;
$obec=iconv("CP1250", "UTF-8", $hlavickap->p1mes);
if ( $suma == 0 ) { $suma=""; $poradoveCislo=""; $icosid=""; $pravnaForma=""; $obchodneMeno=""; $ulica=""; $cislo="";  $psc=""; $obec=""; }

  $text = "    <poradoveCislo><![CDATA[".$poradoveCislo."]]></poradoveCislo>"."\r\n"; fwrite($soubor, $text);
  $text = "    <suma><![CDATA[".$suma."]]></suma>"."\r\n"; fwrite($soubor, $text);
  $text = "    <ico><![CDATA[".$pico."]]></ico>"."\r\n"; fwrite($soubor, $text);
  $text = "    <pravnaForma><![CDATA[".$pravnaForma."]]></pravnaForma>"."\r\n"; fwrite($soubor, $text);

  $text = "    <obchodneMeno>"."\r\n"; fwrite($soubor, $text);
  $text = "     <riadok><![CDATA[".$obchodneMeno."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "     <riadok></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "    </obchodneMeno>"."\r\n"; fwrite($soubor, $text);

  $text = "    <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
  $text = "    <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
  $text = "    <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
  $text = "    <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
  $text = "   </prijimatel>"."\r\n"; fwrite($soubor, $text);

                  }
//koniec ak if( $sumaxx > 0 )

if ( $stlpecp == 3 ) {
  $text = "  </priloha>"."\r\n"; fwrite($soubor, $text);
                     }

$ip = $ip + 1;
$stlpecp = $stlpecp + 1;
if ( $stlpecp == 4 ) $stlpecp=1;
  }
//koniec vytlac prilohu o prijimateloch


//ukonci cely dokument a telo
  $text = " </telo>"."\r\n"; fwrite($soubor, $text);
  $text = "</dokument>"."\r\n"; fwrite($soubor, $text);
     }
//koniec ak j=0

}
$i = $i + 1;
$j = $j + 1;
  }
fclose($soubor);
?>
<div style="background-color: white; padding: 16px 24px; border-radius: 2px;">
  <p style="line-height: 32px;">Stiahnite si niûöie uveden˝ s˙bor XML na V·ö lok·lny disk a naËÌtajte na www.financnasprava.sk alebo do aplik·cie eDane:
  </p>
  <p style="line-height: 48px;"><a href="<?php echo $nazsub; ?>"><?php echo $nazsub; ?></a></p>
</div>
<?php
//mysql_free_result($vysledok);
     }
//koniec xml

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt"); //dopyt, musÌ tu byù?
?>
</div><!-- #content -->

<?php
$cislista = include("uct_lista_norm.php");
//celkovy koniec dokumentu
  } while (false);
?>
<script language="JavaScript" src="../js/cookies.js"></script>
<script type="text/javascript">
//dimensions blank
var blank_param = 'scrollbars=yes, resizable=yes, top=0, left=0, width=1080, height=900';

<?php
//uprava sadzby
if ( $copern == 102 )
{
?>
  function ObnovUI()
  {

<?php if ( $strana == 1 ) { ?>
//   document.formv1.obod.value = '<?php echo "$obodsk";?>';
//   document.formv1.obdo.value = '<?php echo "$obdosk";?>';
<?php if ( $druh == 0 ) { ?> document.formv1.druh1.checked = 'true'; <?php } ?>
<?php if ( $druh == 1 ) { ?> document.formv1.druh1.checked = 'true'; <?php } ?>
<?php if ( $druh == 2 ) { ?> document.formv1.druh2.checked = 'true'; <?php } ?>
<?php if ( $druh == 3 ) { ?> document.formv1.druh3.checked = 'true'; <?php } ?>
   document.formv1.cinnost.value = '<?php echo $cinnost; ?>';
<?php if ( $uoskr == 1 ) { ?> document.formv1.uoskr.checked = 'true'; <?php } ?>
<?php if ( $koskr == 1 ) { ?> document.formv1.koskr.checked = 'true'; <?php } ?>
<?php if ( $nerezident == 1 ) { ?> document.formv1.nerezident.checked = 'true'; <?php } ?>
<?php if ( $zahrprep == 1 ) { ?> document.formv1.zahrprep.checked = 'true'; <?php } ?>

<?php if ( $chpld == 1 ) { ?> document.formv1.chpld.checked = 'true'; <?php } ?>
<?php if ( $cho5k == 1 ) { ?> document.formv1.cho5k.checked = 'true'; <?php } ?>
<?php if ( $chpdl == 1 ) { ?> document.formv1.chpdl.checked = 'true'; <?php } ?>
<?php if ( $chndl == 1 ) { ?> document.formv1.chndl.checked = 'true'; <?php } ?>
<?php if ( $zapdl == 1 ) { ?> document.formv1.zapdl.checked = 'true'; <?php } ?>
<?php if ( $osl13 == 1 ) { ?> document.formv1.osl13.checked = 'true'; <?php } ?>

   document.formv1.pruli.value = '<?php echo $pruli; ?>';
   document.formv1.prcdm.value = '<?php echo $prcdm; ?>';
   document.formv1.prpsc.value = '<?php echo $prpsc; ?>';
   document.formv1.prmes.value = '<?php echo $prmes; ?>';
   document.formv1.prpoc.value = '<?php echo $prpoc; ?>';

<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
   document.formv1.r100.value = '<?php echo $r100; ?>';
   document.formv1.r110.value = '<?php echo $r110; ?>';
//   document.formv1.r120.value = '<?php echo $r120; ?>';
   document.formv1.r130.value = '<?php echo $r130; ?>';
   document.formv1.r140.value = '<?php echo $r140; ?>';
   document.formv1.r150.value = '<?php echo $r150; ?>';
//   document.formv1.r160.value = '<?php echo $r160; ?>';
   document.formv1.r170.value = '<?php echo $r170; ?>';
   document.formv1.r180.value = '<?php echo $r180; ?>';
   document.formv1.r210.value = '<?php echo $r210; ?>';
   document.formv1.r220.value = '<?php echo $r220; ?>';
   document.formv1.r230.value = '<?php echo $r230; ?>';
   document.formv1.r240.value = '<?php echo $r240; ?>';
   document.formv1.r250.value = '<?php echo $r250; ?>';
   document.formv1.r260.value = '<?php echo $r260; ?>';
   document.formv1.r270.value = '<?php echo $r270; ?>';
   document.formv1.r280.value = '<?php echo $r280; ?>';
   document.formv1.r290.value = '<?php echo $r290; ?>';
//   document.formv1.r301.value = '<?php echo $r301; ?>';
   document.formv1.r302.value = '<?php echo $r302; ?>';
   document.formv1.r303.value = '<?php echo $r303; ?>';
   document.formv1.r304.value = '<?php echo $r304; ?>';
<?php                     } ?>

<?php if ( $strana == 3 ) { ?>
   document.formv1.r305.value = '<?php echo $r305; ?>';
   document.formv1.r306.value = '<?php echo $r306; ?>';
   document.formv1.r307.value = '<?php echo $r307; ?>';
   document.formv1.r308.value = '<?php echo $r308; ?>';
//   document.formv1.r310.value = '<?php echo $r310; ?>';
   document.formv1.r320.value = '<?php echo $r320; ?>';
   document.formv1.r330.value = '<?php echo $r330; ?>';
//   document.formv1.r400.value = '<?php echo $r400; ?>';
   document.formv1.r410.value = '<?php echo $r410; ?>';
//   document.formv1.r500.value = '<?php echo $r500; ?>';
   document.formv1.r501.value = '<?php echo $r501; ?>';
//   document.formv1.r510.value = '<?php echo $r510; ?>';
//   document.formv1.r550.value = '<?php echo $r550; ?>';
//   document.formv1.r600.value = '<?php echo $r600; ?>';
   document.formv1.r610.value = '<?php echo $r610; ?>';
   document.formv1.r610text.value = '<?php echo $r610text; ?>';
//   document.formv1.r700.value = '<?php echo $r700; ?>';
   document.formv1.r710.value = '<?php echo $r710; ?>';
//   document.formv1.r800.value = '<?php echo $r800; ?>';
   document.formv1.r810.value = '<?php echo $r810; ?>';
//   document.formv1.r820.value = '<?php echo $r820; ?>';
//   document.formv1.r900.value = '<?php echo $r900; ?>';
   document.formv1.r910.value = '<?php echo $r910; ?>';
   document.formv1.r920.value = '<?php echo $r920; ?>';
<?php                     } ?>

<?php if ( $strana == 4 ) { ?>
   document.formv1.r1000.value = '<?php echo $r1000; ?>';
   document.formv1.r1010.value = '<?php echo $r1010; ?>';
   document.formv1.r1020.value = '<?php echo $r1020; ?>';
   document.formv1.r1030.value = '<?php echo $r1030; ?>';
//   document.formv1.r1040.value = '<?php echo $r1040; ?>';
   document.formv1.r1050.value = '<?php echo $r1050; ?>';
   document.formv1.r1060.value = '<?php echo $r1060; ?>';
   document.formv1.r1061.value = '<?php echo $r1061; ?>';
   document.formv1.r1062.value = '<?php echo $r1062; ?>';
   document.formv1.r1070.value = '<?php echo $r1070; ?>';
//   document.formv1.r1080.value = '<?php echo $r1080; ?>';
   document.formv1.r1090.value = '<?php echo $r1090; ?>';
//   document.formv1.r1100.value = '<?php echo $r1100; ?>';
//   document.formv1.r1101.value = '<?php echo $r1101; ?>';
   document.formv1.r1110.value = '<?php echo $r1110; ?>';
   document.formv1.dadod.value = '<?php echo $dadod_sk; ?>';
   document.formv1.r1120.value = '<?php echo $r1120; ?>';
   document.formv1.r1130.value = '<?php echo $r1130; ?>';
   document.formv1.r1140.value = '<?php echo $r1140; ?>';
   document.formv1.r1150.value = '<?php echo $r1150; ?>';
   document.formv1.r1160.value = '<?php echo $r1160; ?>';
   document.formv1.r1170.value = '<?php echo $r1170; ?>';
   document.formv1.r1180.value = '<?php echo $r1180; ?>';
   document.formv1.r1190.value = '<?php echo $r1190; ?>';
<?php                     } ?>

<?php if ( $strana == 5 ) { ?>
   pripokno1.style.display='none';
   document.formv1.a1r01.value = '<?php echo $a1r01; ?>';
   document.formv1.a1r02.value = '<?php echo $a1r02; ?>';
   document.formv1.a1r03.value = '<?php echo $a1r03; ?>';
   document.formv1.a1r04.value = '<?php echo $a1r04; ?>';
   document.formv1.a1r05.value = '<?php echo $a1r05; ?>';
   document.formv1.a1r06.value = '<?php echo $a1r06; ?>';
   document.formv1.a1r07.value = '<?php echo $a1r07; ?>';
   document.formv1.a1r08.value = '<?php echo $a1r08; ?>';
   document.formv1.a1r09.value = '<?php echo $a1r09; ?>';
   document.formv1.a1r10.value = '<?php echo $a1r10; ?>';
   document.formv1.a1r11.value = '<?php echo $a1r11; ?>';
   document.formv1.a1r12.value = '<?php echo $a1r12; ?>';
   document.formv1.a1r13.value = '<?php echo $a1r13; ?>';
   document.formv1.a1r14.value = '<?php echo $a1r14; ?>';
   document.formv1.a1r15.value = '<?php echo $a1r15; ?>';
   document.formv1.a1r16.value = '<?php echo $a1r16; ?>';
   document.formv1.b1r01.value = '<?php echo $b1r01; ?>';
   document.formv1.b1r02.value = '<?php echo $b1r02; ?>';
   document.formv1.b1r03.value = '<?php echo $b1r03; ?>';
   document.formv1.b1r04.value = '<?php echo $b1r04; ?>';
   document.formv1.b1r05.value = '<?php echo $b1r05; ?>';
//   document.formv1.b1r06.value = '<?php echo $b1r06; ?>';
<?php                     } ?>

<?php if ( $strana == 6 ) { ?>
   document.formv1.c1r01.value = '<?php echo $c1r01; ?>';
   document.formv1.c1r02.value = '<?php echo $c1r02; ?>';
   document.formv1.c1r03.value = '<?php echo $c1r03; ?>';
   document.formv1.c1r04.value = '<?php echo $c1r04; ?>';
   document.formv1.c1r05.value = '<?php echo $c1r05; ?>';
   document.formv1.c2r01.value = '<?php echo $c2r01; ?>';
   document.formv1.c2r02.value = '<?php echo $c2r02; ?>';
   document.formv1.c2r03.value = '<?php echo $c2r03; ?>';
   document.formv1.c2r04.value = '<?php echo $c2r04; ?>';
   document.formv1.c2r05.value = '<?php echo $c2r05; ?>';
   document.formv1.d1r01.value = '<?php echo $d1r01; ?>';
   document.formv1.d1r02.value = '<?php echo $d1r02; ?>';
   document.formv1.d1r03.value = '<?php echo $d1r03; ?>';
   document.formv1.d2od.value = '<?php echo $d2odsk; ?>';
   document.formv1.d2do.value = '<?php echo $d2dosk; ?>';
   document.formv1.d2r01.value = '<?php echo $d2r01; ?>';
   document.formv1.d2r02.value = '<?php echo $d2r02; ?>';
   document.formv1.d2r03.value = '<?php echo $d2r03; ?>';
   document.formv1.d3od.value = '<?php echo $d3odsk; ?>';
   document.formv1.d3do.value = '<?php echo $d3dosk; ?>';
   document.formv1.d3r01.value = '<?php echo $d3r01; ?>';
   document.formv1.d3r02.value = '<?php echo $d3r02; ?>';
   document.formv1.d3r03.value = '<?php echo $d3r03; ?>';
<?php                     } ?>

<?php if ( $strana == 7 ) { ?>
   document.formv1.d4od.value = '<?php echo $d4odsk; ?>';
   document.formv1.d4do.value = '<?php echo $d4dosk; ?>';
   document.formv1.d4r01.value = '<?php echo $d4r01; ?>';
   document.formv1.d4r02.value = '<?php echo $d4r02; ?>';
   document.formv1.d4r03.value = '<?php echo $d4r03; ?>';
   document.formv1.d5od.value = '<?php echo $d5odsk; ?>';
   document.formv1.d5do.value = '<?php echo $d5dosk; ?>';
   document.formv1.d5r01.value = '<?php echo $d5r01; ?>';
   document.formv1.d5r02.value = '<?php echo $d5r02; ?>';
   document.formv1.d5r03.value = '<?php echo $d5r03; ?>';
   document.formv1.d6od.value = '<?php echo $d6odsk; ?>';
   document.formv1.d6do.value = '<?php echo $d6dosk; ?>';
   document.formv1.d6r01.value = '<?php echo $d6r01; ?>';
   document.formv1.d6r02.value = '<?php echo $d6r02; ?>';
   document.formv1.d6r03.value = '<?php echo $d6r03; ?>';
   document.formv1.d7od.value = '<?php echo $d7odsk; ?>';
   document.formv1.d7do.value = '<?php echo $d7dosk; ?>';
   document.formv1.d7r01.value = '<?php echo $d7r01; ?>';
   document.formv1.d7r02.value = '<?php echo $d7r02; ?>';
   document.formv1.d7r03.value = '<?php echo $d7r03; ?>';
//   document.formv1.d8od.value = '<?php echo $d8odsk; ?>';
//   document.formv1.d8do.value = '<?php echo $d8dosk; ?>';
//   document.formv1.d8r01.value = '<?php echo $d8r01; ?>';
//   document.formv1.d8r02.value = '<?php echo $d8r02; ?>';
//   document.formv1.d8r03.value = '<?php echo $d8r03; ?>';
   document.formv1.d9r01.value = '<?php echo $d9r01; ?>';
   document.formv1.d9r02.value = '<?php echo $d9r02; ?>';
   document.formv1.d9r03.value = '<?php echo $d9r03; ?>';
   document.formv1.e1r01.value = '<?php echo $e1r01; ?>';
   document.formv1.e1r02.value = '<?php echo $e1r02; ?>';
   document.formv1.e1r03.value = '<?php echo $e1r03; ?>';
   document.formv1.e1r04.value = '<?php echo $e1r04; ?>';
   document.formv1.e1r05.value = '<?php echo $e1r05; ?>';
   document.formv1.e1r06.value = '<?php echo $e1r06; ?>';
   document.formv1.f1r01.value = '<?php echo $f1r01; ?>';
   document.formv1.f1r02.value = '<?php echo $f1r02; ?>';
//   document.formv1.f1r03.value = '<?php echo $f1r03; ?>';
<?php                     } ?>

<?php if ( $strana == 8 ) { ?>
   document.formv1.g1r01.value = '<?php echo $g1r01; ?>';
   document.formv1.g1r02.value = '<?php echo $g1r02; ?>';
   document.formv1.g1r03.value = '<?php echo $g1r03; ?>';
   document.formv1.g2r01.value = '<?php echo $g2r01; ?>';
   document.formv1.g2r02.value = '<?php echo $g2r02; ?>';
   document.formv1.g2r03.value = '<?php echo $g2r03; ?>';
   document.formv1.g3r01.value = '<?php echo $g3r01; ?>';
   document.formv1.g3r02.value = '<?php echo $g3r02; ?>';
   document.formv1.g3r03.value = '<?php echo $g3r03; ?>';
//   document.formv1.g3r04.value = '<?php echo $g3r04; ?>';
   document.formv1.hr01.value = '<?php echo $hr01; ?>';
   document.formv1.h1r02.value = '<?php echo $h1r02; ?>';
   document.formv1.h2r02.value = '<?php echo $h2r02; ?>';
   document.formv1.h1r03.value = '<?php echo $h1r03; ?>';
   document.formv1.h2r03.value = '<?php echo $h2r03; ?>';
   document.formv1.h1r04.value = '<?php echo $h1r04; ?>';
   document.formv1.h2r04.value = '<?php echo $h2r04; ?>';
   document.formv1.h1r05.value = '<?php echo $h1r05; ?>';
   document.formv1.h2r05.value = '<?php echo $h2r05; ?>';
   document.formv1.h1r06.value = '<?php echo $h1r06; ?>';
   document.formv1.h2r06.value = '<?php echo $h2r06; ?>';
   document.formv1.h1r07.value = '<?php echo $h1r07; ?>';
   document.formv1.h2r07.value = '<?php echo $h2r07; ?>';
   document.formv1.h1r08.value = '<?php echo $h1r08; ?>';
   document.formv1.h2r08.value = '<?php echo $h2r08; ?>';
   document.formv1.h1r09.value = '<?php echo $h1r09; ?>';
   document.formv1.h2r09.value = '<?php echo $h2r09; ?>';
//   document.formv1.hr10.value = '<?php echo $hr10; ?>';
<?php                     } ?>

<?php if ( $strana == 9 ) { ?>
   document.formv1.i1r01.value = '<?php echo $i1r01; ?>';
   document.formv1.i2r01.value = '<?php echo $i2r01; ?>';
   document.formv1.i1r02.value = '<?php echo $i1r02; ?>';
   document.formv1.i2r02.value = '<?php echo $i2r02; ?>';
   document.formv1.i1r03.value = '<?php echo $i1r03; ?>';
   document.formv1.i2r03.value = '<?php echo $i2r03; ?>';
   document.formv1.i1r04.value = '<?php echo $i1r04; ?>';
   document.formv1.i2r04.value = '<?php echo $i2r04; ?>';
   document.formv1.i1r05.value = '<?php echo $i1r05; ?>';
   document.formv1.i2r05.value = '<?php echo $i2r05; ?>';
   document.formv1.i1r06.value = '<?php echo $i1r06; ?>';
   document.formv1.i2r06.value = '<?php echo $i2r06; ?>';
   document.formv1.i1r07.value = '<?php echo $i1r07; ?>';
   document.formv1.i2r07.value = '<?php echo $i2r07; ?>';
   document.formv1.jr01.value = '<?php echo $jr01; ?>';
   document.formv1.jr02.value = '<?php echo $jr02; ?>';
   document.formv1.k1od.value = '<?php echo $k1odsk; ?>';
   document.formv1.k1do.value = '<?php echo $k1dosk; ?>';
   document.formv1.k2r01.value = '<?php echo $k2r01; ?>';
   document.formv1.k3r01.value = '<?php echo $k3r01; ?>';
   document.formv1.k4r01.value = '<?php echo $k4r01; ?>';
   document.formv1.k5r01.value = '<?php echo $k5r01; ?>';
   document.formv1.k2od.value = '<?php echo $k2odsk; ?>';
   document.formv1.k2do.value = '<?php echo $k2dosk; ?>';
   document.formv1.k2r02.value = '<?php echo $k2r02; ?>';
   document.formv1.k3r02.value = '<?php echo $k3r02; ?>';
   document.formv1.k4r02.value = '<?php echo $k4r02; ?>';
   document.formv1.k5r02.value = '<?php echo $k5r02; ?>';
   document.formv1.k3od.value = '<?php echo $k3odsk; ?>';
   document.formv1.k3do.value = '<?php echo $k3dosk; ?>';
   document.formv1.k2r03.value = '<?php echo $k2r03; ?>';
   document.formv1.k3r03.value = '<?php echo $k3r03; ?>';
   document.formv1.k4r03.value = '<?php echo $k4r03; ?>';
   document.formv1.k5r03.value = '<?php echo $k5r03; ?>';
   document.formv1.k4od.value = '<?php echo $k4odsk; ?>';
   document.formv1.k4do.value = '<?php echo $k4dosk; ?>';
   document.formv1.k2r04.value = '<?php echo $k2r04; ?>';
   document.formv1.k3r04.value = '<?php echo $k3r04; ?>';
   document.formv1.k4r04.value = '<?php echo $k4r04; ?>';
   document.formv1.k5r04.value = '<?php echo $k5r04; ?>';
<?php                     } ?>

<?php if ( $strana == 10 ) { ?>
   document.formv1.ps1r01.value = '<?php echo $ps1r01; ?>';
   document.formv1.ps2r01.value = '<?php echo $ps2r01; ?>';
   document.formv1.ps1r02.value = '<?php echo $ps1r02; ?>';
   document.formv1.ps2r02.value = '<?php echo $ps2r02; ?>';
   document.formv1.ps1r03.value = '<?php echo $ps1r03; ?>';
   document.formv1.ps2r03.value = '<?php echo $ps2r03; ?>';
   document.formv1.ps1r04.value = '<?php echo $ps1r04; ?>';
   document.formv1.ps2r04.value = '<?php echo $ps2r04; ?>';
   document.formv1.ps1r05.value = '<?php echo $ps1r05; ?>';
   document.formv1.ps2r05.value = '<?php echo $ps2r05; ?>';
//   document.formv1.ps1r06.value = '<?php echo $ps1r06; ?>';
//   document.formv1.ps2r06.value = '<?php echo $ps2r06; ?>';
   document.formv1.psr07.value = '<?php echo $psr07; ?>';
   document.formv1.psr08.value = '<?php echo $psr08; ?>';
   document.formv1.psr09.value = '<?php echo $psr09; ?>';
   document.formv1.psr10.value = '<?php echo $psr10; ?>';
   document.formv1.psr11.value = '<?php echo $psr11; ?>';
//   document.formv1.psr12.value = '<?php echo $psr12; ?>';
//   document.formv1.psr13.value = '<?php echo $psr13; ?>';
   document.formv1.ps1r14.value = '<?php echo $ps1r14; ?>';
   document.formv1.ps2r14.value = '<?php echo $ps2r14; ?>';
   document.formv1.ps1r15.value = '<?php echo $ps1r15; ?>';
   document.formv1.ps2r15.value = '<?php echo $ps2r15; ?>';
   document.formv1.ps1r16.value = '<?php echo $ps1r16; ?>';
   document.formv1.ps2r16.value = '<?php echo $ps2r16; ?>';
   document.formv1.ps1r17.value = '<?php echo $ps1r17; ?>';
   document.formv1.ps2r17.value = '<?php echo $ps2r17; ?>';
   document.formv1.ps1r18.value = '<?php echo $ps1r18; ?>';
   document.formv1.ps2r18.value = '<?php echo $ps2r18; ?>';
//   document.formv1.ps1r19.value = '<?php echo $ps1r19; ?>';
//   document.formv1.ps2r19.value = '<?php echo $ps2r19; ?>';
   document.formv1.psr20.value = '<?php echo $psr20; ?>';
   document.formv1.psr21.value = '<?php echo $psr21; ?>';
   document.formv1.psr22.value = '<?php echo $psr22; ?>';
   document.formv1.psr23.value = '<?php echo $psr23; ?>';
<?php                      } ?>

<?php if ( $strana == 11 ) { ?>
   document.formv1.psr24.value = '<?php echo $psr24; ?>';
//   document.formv1.psr25.value = '<?php echo $psr25; ?>';
   document.formv1.psr26.value = '<?php echo $psr26; ?>';
   document.formv1.psr27.value = '<?php echo $psr27; ?>';
   document.formv1.psr29.value = '<?php echo $psr29; ?>';
   document.formv1.psr30.value = '<?php echo $psr30; ?>';
   document.formv1.psr31.value = '<?php echo $psr31; ?>';
   document.formv1.ozd1r01.value = '<?php echo $ozd1r01; ?>';
   document.formv1.ozd1r02.value = '<?php echo $ozd1r02; ?>';
   document.formv1.ozd1r03.value = '<?php echo $ozd1r03; ?>';
   document.formv1.ozd1r04.value = '<?php echo $ozd1r04; ?>';
   document.formv1.ozd2r04.value = '<?php echo $ozd2r04; ?>';
   document.formv1.ozd1r05.value = '<?php echo $ozd1r05; ?>';
   document.formv1.ozd2r05.value = '<?php echo $ozd2r05; ?>';
//   document.formv1.ozd1r06.value = '<?php echo $ozd1r06; ?>';
//   document.formv1.ozd2r06.value = '<?php echo $ozd2r06; ?>';
   document.formv1.ozdr07.value = '<?php echo $ozdr07; ?>';
   document.formv1.ozdr09.value = '<?php echo $ozdr09; ?>';
<?php                      } ?>

<?php if ( $strana == 12 ) { ?>
<?php if ( $pzano == 1 ) { ?> document.formv1.pzano.checked = "checked"; <?php } ?>
<?php if ( $zslu == 1 ) { ?> document.formv1.zslu.checked = "checked"; <?php } ?>
   document.formv1.pcdan.value = '<?php echo $pcdan; ?>';
   document.formv1.pcdar.value = '<?php echo $pcdar; ?>';
   document.formv1.pcpod.value = '<?php echo $pcpod; ?>';
   document.formv1.pc155.value = '<?php echo $pc155; ?>';
   document.formv1.pcpoc.value = '<?php echo $pcpoc; ?>';
   document.formv1.pcsum.value = '<?php echo $pcsum; ?>';
   document.formv1.p1ico.value = '<?php echo $p1ico; ?>';
//   document.formv1.p1sid.value = '<?php echo $p1sid; ?>';
   document.formv1.p1pfr.value = '<?php echo $p1pfr; ?>';
   document.formv1.p1men.value = '<?php echo $p1men; ?>';
   document.formv1.p1uli.value = '<?php echo $p1uli; ?>';
   document.formv1.p1cdm.value = '<?php echo $p1cdm; ?>';
   document.formv1.p1psc.value = '<?php echo $p1psc; ?>';
   document.formv1.p1mes.value = '<?php echo $p1mes; ?>';
//<?php if ( $osldan == 1 ) { ?> document.formv1.osldan.checked = "checked"; <?php } ?>
<?php                      } ?>

<?php if ( $strana == 13 ) { ?>
   document.formv1.ooprie.value = '<?php echo $ooprie; ?>';
   document.formv1.oomeno.value = '<?php echo $oomeno; ?>';
   document.formv1.ootitl.value = '<?php echo $ootitl; ?>';
   document.formv1.otitz.value = '<?php echo $otitz; ?>';
   document.formv1.oopost.value = '<?php echo $oopost; ?>';
   document.formv1.oouli.value = '<?php echo $oouli; ?>';
   document.formv1.oocdm.value = '<?php echo $oocdm; ?>';
   document.formv1.oopsc.value = '<?php echo $oopsc; ?>';
   document.formv1.oomes.value = '<?php echo $oomes; ?>';
   document.formv1.ootel.value = '<?php echo $ootel; ?>';
   document.formv1.oofax.value = '<?php echo $oofax; ?>';
   document.formv1.oostat.value = '<?php echo $oostat; ?>';
   document.formv1.pril.value = '<?php echo $pril; ?>';
   document.formv1.datum.value = '<?php echo $datum_sk; ?>';
<?php if ( $ozdspl == 1 ) { ?> document.formv1.ozdspl.checked = "checked"; <?php } ?>
   document.formv1.ozdspl1dat.value = '<?php echo $ozdspl1dat_sk; ?>';
   document.formv1.ozdspl1sum.value = '<?php echo $ozdspl1sum; ?>';
   document.formv1.ozdspl2dat.value = '<?php echo $ozdspl2dat_sk; ?>';
   document.formv1.ozdspl2sum.value = '<?php echo $ozdspl2sum; ?>';
   document.formv1.ozdspl3dat.value = '<?php echo $ozdspl3dat_sk; ?>';
   document.formv1.ozdspl3sum.value = '<?php echo $ozdspl3sum; ?>';
   document.formv1.ozdspl4dat.value = '<?php echo $ozdspl4dat_sk; ?>';
   document.formv1.ozdspl4sum.value = '<?php echo $ozdspl4sum; ?>';
   document.formv1.ozdspl5dat.value = '<?php echo $ozdspl5dat_sk; ?>';
   document.formv1.ozdspl5sum.value = '<?php echo $ozdspl5sum; ?>';
   document.formv1.ozdspldat.value = '<?php echo $ozdspldat_sk; ?>';
<?php if ( $vrat == 1 ) { ?> document.formv1.vrat.checked = "checked"; <?php } ?>
<?php if ( $vrpp == 1 ) { ?> document.formv1.vrpp.checked = "checked"; <?php } ?>
<?php if ( $vruc == 1 ) { ?> document.formv1.vruc.checked = "checked"; <?php } ?>
   document.formv1.datuk.value = '<?php echo $datuk_sk; ?>';
<?php                      } ?>

<?php if ( $strana == 14 ) { ?>
   document.formv1.vos13a.value = '<?php echo $vos13a; ?>';
   document.formv1.vos13b.value = '<?php echo $vos13b; ?>';
   //document.formv1.vosspl.value = '<?php echo $vosspl; ?>';
<?php                      } ?>

  }
<?php
}
//koniec uprava
?>

<?php
//nie uprava
  if ( $copern != 2 AND $copern != 102 )
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

  function NacitajMinRok()
  {
   window.open('../ucto/priznanie_po2018.php?cislo_oc=<?php echo $cislo_oc; ?>&copern=3155&drupoh=1', '_self');
  }
  function FormPoucenie()
  {
   window.open('<?php echo $jpg_source; ?>_poucenie.pdf', '_blank', blank_param);
  }
  function NacitatUdaje(riadok)
  {
   var h_riadok = riadok;
   window.open('priznanie_po2018.php?h_riadok=' + h_riadok + '&copern=266&drupoh=1', '_self');
  }
  function editForm(strana)
  {
    window.open('priznanie_po2018.php?copern=102&strana=' + strana + '&drupoh=1', '_self');
  }
  function FormPDF(strana)
  {
    window.open('priznanie_po2018_pdf.php?copern=11&strana=' + strana + '&drupoh=1', '_blank', blank_param);
  }
  function FormXML()
  {
   window.open('priznanie_po2018.php?copern=10&drupoh=1', '_blank', blank_param);
  }
  function dajDnes()
  {
  if( document.formv1.datum.value == '00.00.0000' ) { document.formv1.datum.value = '<?php echo $dnessk; ?>' }
  if( document.formv1.datum.value == '' ) { document.formv1.datum.value = '<?php echo $dnessk; ?>' }
  }
</script>
</body>
</html>
<!--
TODO





- input=date vysk˙öaù v d·tumoch
- input=number vysk˙öaù v ËÌslach



- predplnenie d·tumu vyhl·senia po kliknutÌ do inputu

- aktualiz·cia xml, Ëo som menil = aû keÔ budem robiù .xml
- zaremovanÈ obdo a obod vyzer·, ûe s˙ naviazanÈ na obdobie daÚovej licencie = preveriù
- ûiadam v ix.Ëasti bude disable checkbox pouk·ûka/˙Ëet a neuk·ûe iban z ufir
- pri dodatoËnom priznanÌ daù disable dadod,1120-1190, blokovaù pri generovanÌ v pdf, html cez disable
  nemusel bych v tlaËi, ale oöetril pri generovanÌ, Ôalöie disable pozrieù v pdf, kde s˙ obmedzenia



-->
