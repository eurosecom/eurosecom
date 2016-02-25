<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu
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

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

//$zablokovane=1;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("DaÚovÈ priznanie bude pripravenÈ v priebehu janu·ra 2015. Aktu·lne info n·jdete na vstupnej str·nke v bode Novinky, tipy, triky.");
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

//.jpg podklad
$jpg_cesta="../dokumenty/dan_z_prijmov2015/dppo2015/dppo_v15";
$jpg_popis="tlaËivo DaÚ z prÌjmov PO pre rok ".$kli_vrok;

//cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$modul = 1*$_REQUEST['modul'];
$strana = 1*$_REQUEST['strana'];
$stranax = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=1;
if ( $copern == 101 ) { $copern=102; }
$xml = 1*$_REQUEST['xml'];
$prepocitaj = 1*$_REQUEST['prepocitaj'];

//nacitanie minuleho roka do PO
  if ( $copern == 3155 ) { ?>
<script type="text/javascript">
if ( !confirm ("Chcete naËÌtaù ˙daje do DPPO z firmy minulÈho roka ?") )
         { window.close() }
else
         { location.href='priznanie_po2015.php?copern=3156&page=1&drupoh=1&cislo_oc=<?php echo $cislo_oc; ?>' }
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


//zmeny pre rok 2013
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
//zmeny pre rok 2014
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
//zmeny pre rok 2015
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

$a1r01=0; $a1r02=0; $a1r03=0; $a1r04=0; $a1r05=0; $a1r06=0; $a1r07=0; $a1r08=0; $a1r09=0; $a1r10=0; $a1r11=0; $a1r12=0; $a1r13=0; $a1r14=0; 

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
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" a1r15=a1r01+a1r02+a1r03+a1r04+a1r05+a1r06+a1r07+a1r08+a1r09+a1r10+a1r11+a1r12+a1r13+a1r14, r130=a1r15 WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");  
//echo $uprtxt;
//exit;

$vsql = 'DROP TABLE F'.$kli_vxcf.'_prizprac'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$prepocitaj=1;
$copern=102;
$strana=4;
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
window.open('../ucto/priznanie_po2015.php?strana=<?php echo $strana; ?>&copern=102&drupoh=1&page=1&prepocitaj=1', '_self')
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
" b1r01='$b1r01x', b1r02='$b1r02x', b1r04='$b1r04x', r150=b1r02-b1r01, r250=0, ".
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
window.open('../ucto/priznanie_po2015.php?strana=<?php echo $strana; ?>&copern=102&drupoh=1&page=1&prepocitaj=1', '_self')
</script>
<?php
}
//koniec copern=200 nacitaj data dppo=2

// zapis upravene udaje
if ( $copern == 103 OR $copern == 4103 OR $copern == 5103 )
     {
if ( $strana == 1 ) {
$druh = 1*$_REQUEST['druh'];
$obod = $_REQUEST['obod'];
$obodsql=SqlDatum($obod);
$obdo = $_REQUEST['obdo'];
$obdosql=SqlDatum($obdo);

if ( $obodsql == '0000-00-00' ) { $obodsql=$kli_vrok."-01-01"; }
if ( $obdosql == '0000-00-00' ) { $obdosql=$kli_vrok."-12-31"; }

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

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" chpld='$chpld', cho5k='$cho5k', chpdl='$chpdl', chndl='$chndl', zapdl='$zapdl', ".
" druh='$druh', obod='$obodsql', obdo='$obdosql', cinnost='$cinnost', uoskr='$uoskr', koskr='$koskr', ".
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

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET  ".
" r100='$r100', r110='$r110', r120='$r120', r130='$r130', r140='$r140', r150='$r150', r160='$r160', r170='$r170', r180='$r180', ".
" r200='$r200', r210='$r210', r220='$r220', r230='$r230', r240='$r240', r250='$r250', r260='$r260', r270='$r270', r280='$r280', r290='$r290', ".
" r300='$r300', r301='$r301', r302='$r302', r303='$r303' ".
" WHERE ico >= 0";
                    }

if ( $strana == 3 ) {
$r304 = strip_tags($_REQUEST['r304']);
$r305 = strip_tags($_REQUEST['r305']);
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
$r830 = strip_tags($_REQUEST['r830']);
//$r840 = strip_tags($_REQUEST['r840']);
//$r850 = strip_tags($_REQUEST['r850']);
//$r860 = strip_tags($_REQUEST['r860']);
$r900 = strip_tags($_REQUEST['r900']);

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET  ".
" r304='$r304', r305='$r305', r310='$r310', r320='$r320', r330='$r330', r400='$r400', r410='$r410', ".
" r500='$r500', r501='$r501', r510='$r510', r550='$r550', r600='$r600', r610='$r610', r610text='$r610text', ".
" r700='$r700', r710='$r710', r800='$r800', r810='$r810', r820='$r820', r830='$r830', ".
" r900='$r900' ".
" WHERE ico >= 0";
                    }

if ( $strana == 4 ) {
//$r901 = strip_tags($_REQUEST['r901']);
$r910 = strip_tags($_REQUEST['r910']);
$r920 = strip_tags($_REQUEST['r920']);
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
//$r1060 = strip_tags($_REQUEST['r1060']);
//$r1070 = strip_tags($_REQUEST['r1070']);
$r1100 = strip_tags($_REQUEST['r1100']);
$r1101 = strip_tags($_REQUEST['r1101']);
$r1110 = strip_tags($_REQUEST['r1110']);
$r1120 = strip_tags($_REQUEST['r1120']);
$r1130 = strip_tags($_REQUEST['r1130']);
$r1140 = strip_tags($_REQUEST['r1140']);
$r1150 = strip_tags($_REQUEST['r1150']);
$dadod = strip_tags($_REQUEST['dadod']);
$dadod_sql=SqlDatum($dadod);

$a1r01 = strip_tags($_REQUEST['a1r01']);
$a1r02 = strip_tags($_REQUEST['a1r02']);
$a1r03 = strip_tags($_REQUEST['a1r03']);
$a1r04 = strip_tags($_REQUEST['a1r04']);
$a1u01 = strip_tags($_REQUEST['a1u01']);
$a1u02 = strip_tags($_REQUEST['a1u02']);
$a1u03 = strip_tags($_REQUEST['a1u03']);
$a1u04 = strip_tags($_REQUEST['a1u04']);

if ( $copern == 103 )
     {
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET  ".
" r910='$r910', r920='$r920', ".
" r1000='$r1000', r1010='$r1010', r1020='$r1020', r1030='$r1030', r1040='$r1040', r1050='$r1050', ".
" r1100='$r1100', r1101='$r1101', r1110='$r1110', r1120='$r1120', r1130='$r1130', r1140='$r1140', r1150='$r1150', ".
" dadod='$dadod_sql', ".
" a1r01='$a1r01', a1r02='$a1r02', a1r03='$a1r03', a1r04='$a1r04' ".
" WHERE ico >= 0";
     }
if ( $copern == 4103 )
     {
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET  ".
" a1u01='$a1u01', a1u02='$a1u02', a1u03='$a1u03', a1u04='$a1u04' ".
" WHERE ico >= 0";
$copern=103;
     }
                    }

if ( $strana == 5 ) {
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
$c1r01 = strip_tags($_REQUEST['c1r01']);
$c1r02 = strip_tags($_REQUEST['c1r02']);
$c1r03 = strip_tags($_REQUEST['c1r03']);
$c1r04 = strip_tags($_REQUEST['c1r04']);
$c1r05 = strip_tags($_REQUEST['c1r05']);

if ( $copern == 103 )
     {
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" a1r05='$a1r05', a1r06='$a1r06', a1r07='$a1r07', a1r08='$a1r08', a1r09='$a1r09', a1r10='$a1r10', ".
" a1r11='$a1r11', a1r12='$a1r12', a1r13='$a1r13', a1r14='$a1r14', a1r15='$a1r15', a1r16='$a1r16', ".
" b1r01='$b1r01', b1r02='$b1r02', b1r03='$b1r03', b1r04='$b1r04', b1r05='$b1r05', b1r06='$b1r06', ".
" c1r01='$c1r01', c1r02='$c1r02', c1r03='$c1r03', c1r04='$c1r04', c1r05='$c1r05' ".
" WHERE ico >= 0";
     }
if ( $copern == 5103 )
     {
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" a1u05='$a1u05', a1u06='$a1u06', a1u07='$a1u07', a1u08='$a1u08', a1u09='$a1u09', ".
" a1u10='$a1u10', a1u11='$a1u11', a1u12='$a1u12', a1u13='$a1u13', a1u14='$a1u14', ".
" a1u15='$a1u15', a1u16='$a1u16' ".
" WHERE ico >= 0";
$copern=103;
     }
                    }

if ( $strana == 6 ) {
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
$d4od = strip_tags($_REQUEST['d4od']);
$d4odsql = SqlDatum($d4od);
$d4do = strip_tags($_REQUEST['d4do']);
$d4dosql = SqlDatum($d4do);
$d5od = strip_tags($_REQUEST['d5od']);
$d5odsql = SqlDatum($d5od);
$d5do = strip_tags($_REQUEST['d5do']);
$d5dosql = SqlDatum($d5do);
$d6od = strip_tags($_REQUEST['d6od']);
$d6odsql = SqlDatum($d6od);
$d6do = strip_tags($_REQUEST['d6do']);
$d6dosql = SqlDatum($d6do);
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
//$d3r04 = strip_tags($_REQUEST['d3r04']);
//$d3r05 = strip_tags($_REQUEST['d3r05']);
//$d3r06 = strip_tags($_REQUEST['d3r06']);
$d4r01 = strip_tags($_REQUEST['d4r01']);
$d4r02 = strip_tags($_REQUEST['d4r02']);
$d4r03 = strip_tags($_REQUEST['d4r03']);
//$d4r04 = strip_tags($_REQUEST['d4r04']);
//$d4r05 = strip_tags($_REQUEST['d4r05']);
//$d4r06 = strip_tags($_REQUEST['d4r06']);
$d5r01 = strip_tags($_REQUEST['d5r01']);
$d5r02 = strip_tags($_REQUEST['d5r02']);
$d5r03 = strip_tags($_REQUEST['d5r03']);
//$d5r04 = strip_tags($_REQUEST['d5r04']);
//$d5r05 = strip_tags($_REQUEST['d5r05']);
//$d5r06 = strip_tags($_REQUEST['d5r06']);
$d6r01 = strip_tags($_REQUEST['d6r01']);
$d6r02 = strip_tags($_REQUEST['d6r02']);
$d6r03 = strip_tags($_REQUEST['d6r03']);
//$d6r04 = strip_tags($_REQUEST['d6r04']);
//$d6r05 = strip_tags($_REQUEST['d6r05']);
//$d6r06 = strip_tags($_REQUEST['d6r06']);
//$d7r01 = strip_tags($_REQUEST['d7r01']);
$d7r02 = strip_tags($_REQUEST['d7r02']);
$d7r03 = strip_tags($_REQUEST['d7r03']);
//$d7r04 = strip_tags($_REQUEST['d7r04']);
//$d7r05 = strip_tags($_REQUEST['d7r05']);
//$d8r01 = strip_tags($_REQUEST['d8r01']);
//$d8r02 = strip_tags($_REQUEST['d8r02']);
//$d8r03 = strip_tags($_REQUEST['d8r03']);
//$d8r04 = strip_tags($_REQUEST['d8r04']);
//$d8r05 = strip_tags($_REQUEST['d8r05']);



$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET  ".
" c2r01='$c2r01', c2r02='$c2r02', c2r03='$c2r03', c2r04='$c2r04', c2r05='$c2r05', ".
" d1r01='$d1r01', d1r02='$d1r02', d1r03='$d1r03', d2r01='$d2r01', d2r02='$d2r02', d2r03='$d2r03', ".
" d2od='$d2odsql', d2do='$d2dosql', d3od='$d3odsql', d3do='$d3dosql', d4od='$d4odsql', d4do='$d4dosql',".
" d5od='$d5odsql', d5do='$d5dosql', d6od='$d6odsql', d6do='$d6dosql', ".
" d3r01='$d3r01', d3r02='$d3r02', d3r03='$d3r03', d4r01='$d4r01', d4r02='$d4r02', d4r03='$d4r03', ".
" d5r01='$d5r01', d5r02='$d5r02', d5r03='$d5r03', d6r01='$d6r01', d6r02='$d6r02', d6r03='$d6r03', ".
" d7r02='$d7r02', d7r03='$d7r03' ".
" WHERE ico >= 0";
                    }

if ( $strana == 7 ) {
$e1r01 = strip_tags($_REQUEST['e1r01']);
$e1r02 = strip_tags($_REQUEST['e1r02']);
$e1r03 = strip_tags($_REQUEST['e1r03']);
$e1r04 = strip_tags($_REQUEST['e1r04']);
$e1r05 = strip_tags($_REQUEST['e1r05']);
$e1r06 = strip_tags($_REQUEST['e1r06']);
$f1r01 = strip_tags($_REQUEST['f1r01']);
$f1r02 = strip_tags($_REQUEST['f1r02']);
$f1r03 = strip_tags($_REQUEST['f1r03']);
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

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET  ".
" e1r01='$e1r01', e1r02='$e1r02', e1r03='$e1r03', e1r04='$e1r04', e1r05='$e1r05', e1r06='$e1r06', ".
" f1r01='$f1r01', f1r02='$f1r02', f1r03='$f1r03', ".
" g1r01='$g1r01', g1r02='$g1r02', g1r03='$g1r03', g2r01='$g2r01', g2r02='$g2r02', g2r03='$g2r03', ".
" g3r01='$g3r01', g3r02='$g3r02', g3r03='$g3r03', g3r04='$g3r04' ".
" WHERE ico >= 0";
                    }

if ( $strana == 8 ) {
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
//$hr06 = strip_tags($_REQUEST['hr06']);
$hr10 = strip_tags($_REQUEST['hr10']);
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
//$jl1r01 = strip_tags($_REQUEST['jl1r01']);
//$jl1r02 = strip_tags($_REQUEST['jl1r02']);
//$jl1r03 = strip_tags($_REQUEST['jl1r03']);
//$jl1r04 = strip_tags($_REQUEST['jl1r04']);
//$jl1r05 = strip_tags($_REQUEST['jl1r05']);
$jr01 = strip_tags($_REQUEST['jr01']);
$jr02 = strip_tags($_REQUEST['jr02']);

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" hr01='$hr01', ".
" h1r02='$h1r02', h2r02='$h2r02', h1r03='$h1r03', h2r03='$h2r03', h1r04='$h1r04', h2r04='$h2r04', ".
" h1r05='$h1r05', h2r05='$h2r05', h1r06='$h1r06', h2r06='$h2r06', h1r07='$h1r07', h2r07='$h2r07', ".
" h1r08='$h1r08', h2r08='$h2r08', h1r09='$h1r09', h2r09='$h2r09', ".
" hr10='$hr10', ".
" i1r01='$i1r01', i1r02='$i1r02', i1r03='$i1r03', i1r04='$i1r04', i1r05='$i1r05', i1r06='$i1r06', i1r07='$i1r07', ".
" i2r01='$i2r01', i2r02='$i2r02', i2r03='$i2r03', i2r04='$i2r04', i2r05='$i2r05', i2r06='$i2r06', i2r07='$i2r07', ".
" jr01='$jr01', jr02='$jr02' ".
" WHERE ico >= 0";
                    }

if ( $strana == 9 ) {
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

$pzano = strip_tags($_REQUEST['pzano']);
$zslu = strip_tags($_REQUEST['zslu']);
$pcpod = strip_tags($_REQUEST['pcpod']);
$pcdar = strip_tags($_REQUEST['pcdar']);
//$pc15 = strip_tags($_REQUEST['pc15']);
//$pcpod5 = strip_tags($_REQUEST['pcpod5']);
//$pcdar5 = strip_tags($_REQUEST['pcdar5']);
$pc155 = strip_tags($_REQUEST['pc155']);
$pcpoc = strip_tags($_REQUEST['pcpoc']);
$pcsum = strip_tags($_REQUEST['pcsum']);
$p1ico = strip_tags($_REQUEST['p1ico']);
$p1sid = strip_tags($_REQUEST['p1sid']);
$p1pfr = strip_tags($_REQUEST['p1pfr']);
$p1men = strip_tags($_REQUEST['p1men']);
$p1uli = strip_tags($_REQUEST['p1uli']);
$p1cdm = strip_tags($_REQUEST['p1cdm']);
$p1psc = strip_tags($_REQUEST['p1psc']);
$p1mes = strip_tags($_REQUEST['p1mes']);


$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET".
" k1od='$k1odsql', k1do='$k1dosql', k2od='$k2odsql', k2do='$k2dosql', k3od='$k3odsql', k3do='$k3dosql', k4od='$k4odsql', k4do='$k4dosql',".
" k2r01='$k2r01', k3r01='$k3r01', k4r01='$k4r01', k5r01='$k5r01', ".
" k2r02='$k2r02', k3r02='$k3r02', k4r02='$k4r02', k5r02='$k5r02', ".
" k2r03='$k2r03', k3r03='$k3r03', k4r03='$k4r03', k5r03='$k5r03', ".
" k2r04='$k2r04', k3r04='$k3r04', k4r04='$k4r04', k5r04='$k5r04', ".
" k4r05='$k4r05', k5r05='$k5r05', ".
" pzano='$pzano', zslu='$zslu', ".
" pcpod='$pcpod', pcdar='$pcdar', pc155='$pc155', pcpoc='$pcpoc', pcsum='$pcsum', ".
" p1ico='$p1ico', p1sid='$p1sid', p1pfr='$p1pfr', p1men='$p1men', p1uli='$p1uli', p1cdm='$p1cdm', p1psc='$p1psc', p1mes='$p1mes' ".
" WHERE ico >= 0";
                    }

if ( $strana == 10 ) {
$osobit = strip_tags($_REQUEST['osobit']);
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
//$datup = strip_tags($_REQUEST['datup']);
//$datup_sql = SqlDatum($datup);
//$vypprie = strip_tags($_REQUEST['vypprie']);
//$vyptel = strip_tags($_REQUEST['vyptel']);
$datuk = strip_tags($_REQUEST['datuk']);
$datuk_sql = SqlDatum($datuk);
$vrat = strip_tags($_REQUEST['vrat']);
$vrpp = strip_tags($_REQUEST['vrpp']);
$vruc = strip_tags($_REQUEST['vruc']);
//$diban = strip_tags($_REQUEST['diban']);
//$vrucet = strip_tags($_REQUEST['vrucet']);
//$vrnum = strip_tags($_REQUEST['vrnum']);

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET  ".
" osobit='$osobit', ooprie='$ooprie', oomeno='$oomeno', ootitl='$ootitl', otitz='$otitz', oopost='$oopost', oouli='$oouli', oocdm='$oocdm', ".
" oopsc='$oopsc', oomes='$oomes', ootel='$ootel', oofax='$oofax', oostat='$oostat', ".
" pril='$pril', datum='$datum_sql', datuk='$datuk_sql', vrat='$vrat', vrpp='$vrpp', vruc='$vruc' ".
" WHERE ico >= 0";
                     }

if ( $strana == 11 ) {
$pzs01 = strip_tags($_REQUEST['pzs01']);
$pzs02 = strip_tags($_REQUEST['pzs02']);
$pzs03 = strip_tags($_REQUEST['pzs03']);
$pzs04 = strip_tags($_REQUEST['pzs04']);
$pzd02 = strip_tags($_REQUEST['pzd02']);
$pzd03 = strip_tags($_REQUEST['pzd03']);
$pzd04 = strip_tags($_REQUEST['pzd04']);
$pzr05 = strip_tags($_REQUEST['pzr05']);
//$pzr06 = strip_tags($_REQUEST['pzr06']);
$pzr07 = strip_tags($_REQUEST['pzr07']);
$pzr08 = strip_tags($_REQUEST['pzr08']);
$pzr09 = strip_tags($_REQUEST['pzr09']);
$pzr10 = strip_tags($_REQUEST['pzr10']);
$pzr11 = strip_tags($_REQUEST['pzr11']);
$pzr12 = strip_tags($_REQUEST['pzr12']);
$pzr13 = strip_tags($_REQUEST['pzr13']);
$pzr14 = strip_tags($_REQUEST['pzr14']);
$pzr15 = strip_tags($_REQUEST['pzr15']);
$pzr16 = strip_tags($_REQUEST['pzr16']);
$pzdat = strip_tags($_REQUEST['pzdat']);
$pzdat_sql = SqlDatum($pzdat);

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET  ".
" pzs01='$pzs01', pzs02='$pzs02', pzs03='$pzs03', pzs04='$pzs04', pzd02='$pzd02', pzd03='$pzd03', pzd04='$pzd04', ".
" pzr05='$pzr05', pzr07='$pzr07', pzr08='$pzr08', pzr09='$pzr09', pzr10='$pzr10', pzr11='$pzr11', pzr12='$pzr12', pzr13='$pzr13', pzr14='$pzr14', ".
" pzr15='$pzr15', pzr16='$pzr16', pzdat='$pzdat_sql' ".
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

//vsetky strany vypocty su upravene pre 2015
//////////////////////strana 2 2015

if ( $rozdielodpisov == 1 )
  {
//danove-uctovne prerobim na kliknutie na ikonku
//upravene na rok 2015
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r150=b1r02-b1r01, r250=0, ".
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
//upravene na rok 2015
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r130=a1r17, ".
" psys=0 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");  

  }

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r200=r110+r120+r130+r140+r150+r160+r170+r180, r300=r210+r220+r230+r240+r250+r260+r270+r280+r290, r301=r100+r200-r300+hr10, ".
" psys=0 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");  

/////////////////////strana 3 2015
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r310=r301+r302+r303+r304-r305, ".
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
//upravene na rok 2015
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r410=d7r02, ".
" psys=0 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");
  }

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET r410=r400, psys=0 WHERE ico >= 0 AND r410 > r400 "; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r500=r400-r410, psys=0 WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r500=0 WHERE ico >= 0 AND r500 < 0 "; 
$upravene = mysql_query("$uprtxt");

if ( $odpocetvyskum == 1 )
  {
//upravene na rok 2015
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dpprilpro SET prpods=prpod1+prpod2+prpod3+prpod4+prpod5 WHERE prcpl > 0 ";
$sqldok = mysql_query("$sqlttt");

$prpodv=0;
$sqlttt = "SELECT SUM(prpods) AS sums FROM F$kli_vxcf"."_uctpriznanie_dpprilpro WHERE prcpl > 0 ";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $prpodv=$riaddok->sums;
 }

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
" r550=22, r600=(r550*r510), psys=0 WHERE ico >= 0";
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
//upravene na rok 2015
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

//danova licencia 2015
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

//////////////////strana 4 2015

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
" r1100=r1050-r1040, r1101=0, ".
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
//upravene na rok 2015

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" r1110=r510*22, psys=0 WHERE ico >= 0";
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


//////////////////strana 4 tabulky 2015
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" a1r17=a1r01+a1r02+a1r03+a1r04+a1r05+a1r06+a1r07+a1r08+a1r09+a1r10+a1r11+a1r12+a1r13+a1r14+a1r15+a1r16, ".
" psys=0 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

//////////////////strana 5 2015
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET ".
" b1r06=b1r02-b1r03-b1r04+b1r05, ".
" psys=0 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");


//////////////////strana 7 2015
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET f1r03=f1r01-f1r02, ".
" psys=0 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

//////////////////strana 7 2015
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET g1r03=g1r01-g1r02, ".
" psys=0 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET g2r03=g2r01-g2r02, ".
" psys=0 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET g3r04=g3r01+g3r02-g3r03, ".
" psys=0 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

//////////////////strana 8 2015
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET hr10=hr01+h1r02-h2r02+h1r03-h2r03+h1r04-h2r04+h1r05-h2r05+h1r06-h2r06+h1r07-h2r07+h1r08-h2r08+h1r09-h2r09, ".
" psys=0 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

//////////////////strana 9 2015
if ( $nacitajdanlicencia == 1 )
  {

$h_ycf=0;
if ( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");

$dl2014=0;
$sqlttt = "SELECT r830, obdo, obod FROM ".$databaza."F$h_ycf"."_uctpriznanie_po ";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $dl2014=1*$riaddok->r830;
 $obod=$riaddok->obod;
 $obdo=$riaddok->obdo;
 }

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET k2r01='$dl2014', k1od='$obod', k1do='$obdo', ".
" psys=0 ".
" WHERE ico >= 0"; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");


  }

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET k5r01=k2r01-k3r01-k4r01, k5r02=k2r02-k3r02-k4r02, k5r03=k2r03-k3r03-k4r03, k5r04=k2r04-k3r04-k4r04, ".
" psys=0 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET k4r05=k4r01+k4r02+k4r03+k4r04, k5r05=k5r01+k5r02+k5r03+k5r04, ".
" psys=0 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");


//koniec prepocitaj, len ak prepocitaj=1
                        }
//////////////////koniec vypoctov

//nacitaj udaje pre upravu
if ( $copern == 102 OR $copern == 11 )
     {
$sql = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$vysledok = mysql_query($sql);
if ( $vysledok ) {
$riadok=mysql_fetch_object($vysledok);
$fstat = $riadok->fstat;
                 }
     }
//koniec nacitania

$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_po WHERE ico >= 0";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$druh = $fir_riadok->druh;
$obod = $fir_riadok->obod;
$obodsk=SkDatum($obod);
$obdo = $fir_riadok->obdo;
$obdosk=SkDatum($obdo);
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
                                      }

if ( $strana == 3 OR $strana == 999 ) {
$r304 = $fir_riadok->r304;
$r305 = $fir_riadok->r305;
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
$r830 = $fir_riadok->r830;
$r900 = $fir_riadok->r900;
                                      }

if ( $strana == 4 OR $strana == 999 ) {
$r910 = $fir_riadok->r910;
$r920 = $fir_riadok->r920;
$r1000 = $fir_riadok->r1000;
$r1010 = $fir_riadok->r1010;
$r1020 = $fir_riadok->r1020;
$r1030 = $fir_riadok->r1030;
$r1040 = $fir_riadok->r1040;
$r1050 = $fir_riadok->r1050;
$r1100 = $fir_riadok->r1100;
$r1101 = $fir_riadok->r1101;
$r1110 = $fir_riadok->r1110;
$r1120 = $fir_riadok->r1120;
$r1130 = $fir_riadok->r1130;
$r1140 = $fir_riadok->r1140;
$r1150 = $fir_riadok->r1150;
$dadod_sk = SkDatum($fir_riadok->dadod);
$a1r01 = $fir_riadok->a1r01;
$a1r02 = $fir_riadok->a1r02;
$a1r03 = $fir_riadok->a1r03;
$a1r04 = $fir_riadok->a1r04;
$a1u01 = $fir_riadok->a1u01;
$a1u02 = $fir_riadok->a1u02;
$a1u03 = $fir_riadok->a1u03;
$a1u04 = $fir_riadok->a1u04;
                                      }

if ( $strana == 5 OR $strana == 999 ) {
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
$c1r01 = $fir_riadok->c1r01;
$c1r02 = $fir_riadok->c1r02;
$c1r03 = $fir_riadok->c1r03;
$c1r04 = $fir_riadok->c1r04;
$c1r05 = $fir_riadok->c1r05;
                                      }

if ( $strana == 6 OR $strana == 999 ) {
$c2r01 = $fir_riadok->c2r01;
$c2r02 = $fir_riadok->c2r02;
$c2r03 = $fir_riadok->c2r03;
$c2r04 = $fir_riadok->c2r04;
$c2r05 = $fir_riadok->c2r05;
$d1r01 = $fir_riadok->d1r01;
$d1r02 = $fir_riadok->d1r02;
$d1r03 = $fir_riadok->d1r03;
$d2r01 = $fir_riadok->d2r01;
$d2r02 = $fir_riadok->d2r02;
$d2r03 = $fir_riadok->d2r03;
$d3r01 = $fir_riadok->d3r01;
$d3r02 = $fir_riadok->d3r02;
$d3r03 = $fir_riadok->d3r03;
$d4r01 = $fir_riadok->d4r01;
$d4r02 = $fir_riadok->d4r02;
$d4r03 = $fir_riadok->d4r03;
$d5r01 = $fir_riadok->d5r01;
$d5r02 = $fir_riadok->d5r02;
$d5r03 = $fir_riadok->d5r03;
$d6r01 = $fir_riadok->d6r01;
$d6r02 = $fir_riadok->d6r02;
$d6r03 = $fir_riadok->d6r03;
$d7r02 = $fir_riadok->d7r02;
$d7r03 = $fir_riadok->d7r03;
$d2odsk = SkDatum($fir_riadok->d2od);
$d2dosk = SkDatum($fir_riadok->d2do);
$d3odsk = SkDatum($fir_riadok->d3od);
$d3dosk = SkDatum($fir_riadok->d3do);
$d4odsk = SkDatum($fir_riadok->d4od);
$d4dosk = SkDatum($fir_riadok->d4do);
$d5odsk = SkDatum($fir_riadok->d5od);
$d5dosk = SkDatum($fir_riadok->d5do);
$d6odsk = SkDatum($fir_riadok->d6od);
$d6dosk = SkDatum($fir_riadok->d6do);
                                      }

if ( $strana == 7 OR $strana == 999 ) {
$e1r01 = $fir_riadok->e1r01;
$e1r02 = $fir_riadok->e1r02;
$e1r03 = $fir_riadok->e1r03;
$e1r04 = $fir_riadok->e1r04;
$e1r05 = $fir_riadok->e1r05;
$e1r06 = $fir_riadok->e1r06;
$f1r01 = $fir_riadok->f1r01;
$f1r02 = $fir_riadok->f1r02;
$f1r03 = $fir_riadok->f1r03;

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
                                      }

if ( $strana == 8 OR $strana == 999 ) {
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
$i1r01 = $fir_riadok->i1r01;
$i1r02 = $fir_riadok->i1r02;
$i1r03 = $fir_riadok->i1r03;
$i1r04 = $fir_riadok->i1r04;
$i1r05 = $fir_riadok->i1r05;
$i1r06 = $fir_riadok->i1r06;
$i1r07 = $fir_riadok->i1r07;
$i2r01 = $fir_riadok->i2r01;
$i2r02 = $fir_riadok->i2r02;
$i2r03 = $fir_riadok->i2r03;
$i2r04 = $fir_riadok->i2r04;
$i2r05 = $fir_riadok->i2r05;
$i2r06 = $fir_riadok->i2r06;
$i2r07 = $fir_riadok->i2r07;
$jr01 = $fir_riadok->jr01;
$jr02 = $fir_riadok->jr02;
                                      }

if ( $strana == 9 OR $strana == 999 ) {
$k1odsk = SkDatum($fir_riadok->k1od);
$k1dosk = SkDatum($fir_riadok->k1do);
$k2odsk = SkDatum($fir_riadok->k2od);
$k2dosk = SkDatum($fir_riadok->k2do);
$k3odsk = SkDatum($fir_riadok->k3od);
$k3dosk = SkDatum($fir_riadok->k3do);
$k4odsk = SkDatum($fir_riadok->k4od);
$k4dosk = SkDatum($fir_riadok->k4do);

$k2r01 = $fir_riadok->k2r01;
$k3r01 = $fir_riadok->k3r01;
$k4r01 = $fir_riadok->k4r01;
$k5r01 = $fir_riadok->k5r01;
$k2r02 = $fir_riadok->k2r02;
$k3r02 = $fir_riadok->k3r02;
$k4r02 = $fir_riadok->k4r02;
$k5r02 = $fir_riadok->k5r02;
$k2r03 = $fir_riadok->k2r03;
$k3r03 = $fir_riadok->k3r03;
$k4r03 = $fir_riadok->k4r03;
$k5r03 = $fir_riadok->k5r03;
$k2r04 = $fir_riadok->k2r04;
$k3r04 = $fir_riadok->k3r04;
$k4r04 = $fir_riadok->k4r04;
$k5r04 = $fir_riadok->k5r04;
$k4r05 = $fir_riadok->k4r05;
$k5r05 = $fir_riadok->k5r05;

$pzano = $fir_riadok->pzano;
$zslu = $fir_riadok->zslu;
$pcpod = $fir_riadok->pcpod;
$pcdar = $fir_riadok->pcdar;
$pc155 = $fir_riadok->pc155;
$pcpoc = $fir_riadok->pcpoc;
$pcsum = $fir_riadok->pcsum;
$p1ico = $fir_riadok->p1ico;
$p1sid = $fir_riadok->p1sid;
$p1pfr = $fir_riadok->p1pfr;
$p1men = $fir_riadok->p1men;
$p1uli = $fir_riadok->p1uli;
$p1cdm = $fir_riadok->p1cdm;
$p1psc = $fir_riadok->p1psc;
$p1mes = $fir_riadok->p1mes;
                                      }

if ( $strana == 10 OR $strana == 999 ) {
$osobit = $fir_riadok->osobit;
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
if ( $datum_sk == '00.00.0000' ) 
{ 
$datum_sk=Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$datum_sql=SqlDatum($datum_sk);
$sqlx = "UPDATE F$kli_vxcf"."_uctpriznanie_po SET datum='$datum_sql' ";
$vysledekx = mysql_query("$sqlx");
}
$datuk = $fir_riadok->datuk;
$datuk_sk = SkDatum($datuk);
$vrat = $fir_riadok->vrat;
$vrpp = $fir_riadok->vrpp;
$vruc = $fir_riadok->vruc;
                                      }

if ( $strana == 11 OR $strana == 999 ) {
$pzs01 = $fir_riadok->pzs01;
$pzs02 = $fir_riadok->pzs02;
$pzs03 = $fir_riadok->pzs03;
$pzs04 = $fir_riadok->pzs04;
$pzd02 = $fir_riadok->pzd02;
$pzd03 = $fir_riadok->pzd03;
$pzd04 = $fir_riadok->pzd04;
$pzr05 = $fir_riadok->pzr05;
$pzr07 = $fir_riadok->pzr07;
$pzr08 = $fir_riadok->pzr08;
$pzr09 = $fir_riadok->pzr09;
$pzr10 = $fir_riadok->pzr10;
$pzr11 = $fir_riadok->pzr11;
$pzr12 = $fir_riadok->pzr12;
$pzr13 = $fir_riadok->pzr13;
$pzr14 = $fir_riadok->pzr14;
$pzr15 = $fir_riadok->pzr15;
$pzr16 = $fir_riadok->pzr16;
$pzdat = $fir_riadok->pzdat;
$pzdat_sk = SkDatum($pzdat);
                                      }
mysql_free_result($fir_vysledok);
     }
//koniec nacitania

//6-miestne ico
$fir_fico6=$fir_fico;
if ( $fir_fico < 1000000 ) { $fir_fico6="00".$fir_fico; }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - DaÚ z prÌjmov PO</title>
<style type="text/css">
span.pripo-btn {
  position: absolute;
  left: 836px;
  color: #39f;
  cursor: pointer;
  font-weight: bold;
  font-size: 14px;
}
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
  height: 30px;
  line-height: 26px;
  font-size: 11px;
  text-align: left;
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

<script language="JavaScript" src="../js/cookies.js"></script>
<script type="text/javascript">
<?php
//uprava sadzby
if ( $copern == 102 )
{
?>
  function ObnovUI()
  {

<?php if ( $strana == 1 ) { ?>
   document.formv1.obod.value = '<?php echo "$obodsk";?>';
   document.formv1.obdo.value = '<?php echo "$obdosk";?>';
<?php if ( $druh == 0 ) { ?> document.formv1.druh1.checked = 'true'; <?php } ?>
<?php if ( $druh == 1 ) { ?> document.formv1.druh1.checked = 'true'; <?php } ?>
<?php if ( $druh == 2 ) { ?> document.formv1.druh2.checked = 'true'; <?php } ?>
<?php if ( $druh == 3 ) { ?> document.formv1.druh3.checked = 'true'; <?php } ?>
   document.formv1.cinnost.value = '<?php echo "$cinnost";?>';
<?php if ( $uoskr == 1 ) { ?> document.formv1.uoskr.checked = 'true'; <?php } ?>
<?php if ( $koskr == 1 ) { ?> document.formv1.koskr.checked = 'true'; <?php } ?>
<?php if ( $nerezident == 1 ) { ?> document.formv1.nerezident.checked = 'true'; <?php } ?>
<?php if ( $zahrprep == 1 ) { ?> document.formv1.zahrprep.checked = 'true'; <?php } ?>

<?php if ( $chpld == 1 ) { ?> document.formv1.chpld.checked = 'true'; <?php } ?>
<?php if ( $cho5k == 1 ) { ?> document.formv1.cho5k.checked = 'true'; <?php } ?>
<?php if ( $chpdl == 1 ) { ?> document.formv1.chpdl.checked = 'true'; <?php } ?>
<?php if ( $chndl == 1 ) { ?> document.formv1.chndl.checked = 'true'; <?php } ?>
<?php if ( $zapdl == 1 ) { ?> document.formv1.zapdl.checked = 'true'; <?php } ?>
   document.formv1.pruli.value = '<?php echo "$pruli";?>';
   document.formv1.prcdm.value = '<?php echo "$prcdm";?>';
   document.formv1.prpsc.value = '<?php echo "$prpsc";?>';
   document.formv1.prmes.value = '<?php echo "$prmes";?>';
   document.formv1.prpoc.value = '<?php echo "$prpoc";?>';

<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
   document.formv1.r100.value = '<?php echo "$r100";?>';
   document.formv1.r110.value = '<?php echo "$r110";?>';
   document.formv1.r120.value = '<?php echo "$r120";?>';
   document.formv1.r130.value = '<?php echo "$r130";?>';
   document.formv1.r140.value = '<?php echo "$r140";?>';
   document.formv1.r150.value = '<?php echo "$r150";?>';
   document.formv1.r160.value = '<?php echo "$r160";?>';
   document.formv1.r170.value = '<?php echo "$r170";?>';
   document.formv1.r180.value = '<?php echo "$r180";?>';
   document.formv1.r210.value = '<?php echo "$r210";?>';
   document.formv1.r220.value = '<?php echo "$r220";?>';
   document.formv1.r230.value = '<?php echo "$r230";?>';
   document.formv1.r240.value = '<?php echo "$r240";?>';
   document.formv1.r250.value = '<?php echo "$r250";?>';
   document.formv1.r260.value = '<?php echo "$r260";?>';
   document.formv1.r270.value = '<?php echo "$r270";?>';
   document.formv1.r280.value = '<?php echo "$r280";?>';
   document.formv1.r290.value = '<?php echo "$r290";?>';
   document.formv1.r301.value = '<?php echo "$r301";?>';
   document.formv1.r302.value = '<?php echo "$r302";?>';
   document.formv1.r303.value = '<?php echo "$r303";?>';
<?php                     } ?>

<?php if ( $strana == 3 ) { ?>
   document.formv1.r304.value = '<?php echo "$r304";?>';
   document.formv1.r305.value = '<?php echo "$r305";?>';
   document.formv1.r310.value = '<?php echo "$r310";?>';
   document.formv1.r320.value = '<?php echo "$r320";?>';
   document.formv1.r330.value = '<?php echo "$r330";?>';
   document.formv1.r400.value = '<?php echo "$r400";?>';
   document.formv1.r410.value = '<?php echo "$r410";?>';
   document.formv1.r500.value = '<?php echo "$r500";?>';
   document.formv1.r501.value = '<?php echo "$r501";?>';
   document.formv1.r510.value = '<?php echo "$r510";?>';
   document.formv1.r550.value = '<?php echo "$r550";?>';
   document.formv1.r600.value = '<?php echo "$r600";?>';
   document.formv1.r610text.value = '<?php echo "$r610text";?>';
   document.formv1.r610.value = '<?php echo "$r610";?>';
   document.formv1.r700.value = '<?php echo "$r700";?>';
   document.formv1.r710.value = '<?php echo "$r710";?>';
   document.formv1.r800.value = '<?php echo "$r800";?>';
   document.formv1.r810.value = '<?php echo "$r810";?>';
   document.formv1.r820.value = '<?php echo "$r820";?>';
   document.formv1.r830.value = '<?php echo "$r830";?>';
   document.formv1.r900.value = '<?php echo "$r900";?>';
<?php                     } ?>

<?php if ( $strana == 4 ) { ?>
   pripokno1.style.display='none';
   document.formv1.r910.value = '<?php echo "$r910";?>';
   document.formv1.r920.value = '<?php echo "$r920";?>';
   document.formv1.r1000.value = '<?php echo "$r1000";?>';
   document.formv1.r1010.value = '<?php echo "$r1010";?>';
   document.formv1.r1020.value = '<?php echo "$r1020";?>';
   document.formv1.r1030.value = '<?php echo "$r1030";?>';
   document.formv1.r1040.value = '<?php echo "$r1040";?>';
   document.formv1.r1050.value = '<?php echo "$r1050";?>';
   document.formv1.r1100.value = '<?php echo "$r1100";?>';
   document.formv1.r1101.value = '<?php echo "$r1101";?>';
   document.formv1.r1110.value = '<?php echo "$r1110";?>';
   document.formv1.dadod.value = '<?php echo "$dadod_sk";?>';
   document.formv1.r1120.value = '<?php echo "$r1120";?>';
   document.formv1.r1130.value = '<?php echo "$r1130";?>';
   document.formv1.r1140.value = '<?php echo "$r1140";?>';
   document.formv1.r1150.value = '<?php echo "$r1150";?>';
   document.formv1.a1r01.value = '<?php echo "$a1r01";?>';
   document.formv1.a1r02.value = '<?php echo "$a1r02";?>';
   document.formv1.a1r03.value = '<?php echo "$a1r03";?>';
   document.formv1.a1r04.value = '<?php echo "$a1r04";?>';
<?php                     } ?>

<?php if ( $strana == 5 ) { ?>
   pripokno2.style.display='none';
   document.formv1.a1r05.value = '<?php echo "$a1r05";?>';
   document.formv1.a1r06.value = '<?php echo "$a1r06";?>';
   document.formv1.a1r07.value = '<?php echo "$a1r07";?>';
   document.formv1.a1r08.value = '<?php echo "$a1r08";?>';
   document.formv1.a1r09.value = '<?php echo "$a1r09";?>';
   document.formv1.a1r10.value = '<?php echo "$a1r10";?>';
   document.formv1.a1r11.value = '<?php echo "$a1r11";?>';
   document.formv1.a1r12.value = '<?php echo "$a1r12";?>';
   document.formv1.a1r13.value = '<?php echo "$a1r13";?>';
   document.formv1.a1r14.value = '<?php echo "$a1r14";?>';
   document.formv1.a1r15.value = '<?php echo "$a1r15";?>';
   document.formv1.a1r16.value = '<?php echo "$a1r16";?>';

   document.formv1.b1r01.value = '<?php echo "$b1r01";?>';
   document.formv1.b1r02.value = '<?php echo "$b1r02";?>';
   document.formv1.b1r03.value = '<?php echo "$b1r03";?>';
   document.formv1.b1r04.value = '<?php echo "$b1r04";?>';
   document.formv1.b1r05.value = '<?php echo "$b1r05";?>';
   document.formv1.b1r06.value = '<?php echo "$b1r06";?>';

   document.formv1.c1r01.value = '<?php echo "$c1r01";?>';
   document.formv1.c1r02.value = '<?php echo "$c1r02";?>';
   document.formv1.c1r03.value = '<?php echo "$c1r03";?>';
   document.formv1.c1r04.value = '<?php echo "$c1r04";?>';
   document.formv1.c1r05.value = '<?php echo "$c1r05";?>';
<?php                     } ?>

<?php if ( $strana == 6 ) { ?>
   document.formv1.c2r01.value = '<?php echo "$c2r01";?>';
   document.formv1.c2r02.value = '<?php echo "$c2r02";?>';
   document.formv1.c2r03.value = '<?php echo "$c2r03";?>';
   document.formv1.c2r04.value = '<?php echo "$c2r04";?>';
   document.formv1.c2r05.value = '<?php echo "$c2r05";?>';
   document.formv1.d1r01.value = '<?php echo "$d1r01";?>';
   document.formv1.d1r02.value = '<?php echo "$d1r02";?>';
   document.formv1.d1r03.value = '<?php echo "$d1r03";?>';
   document.formv1.d2od.value = '<?php echo "$d2odsk";?>';
   document.formv1.d2do.value = '<?php echo "$d2dosk";?>';
   document.formv1.d3od.value = '<?php echo "$d3odsk";?>';
   document.formv1.d3do.value = '<?php echo "$d3dosk";?>';
   document.formv1.d4od.value = '<?php echo "$d4odsk";?>';
   document.formv1.d4do.value = '<?php echo "$d4dosk";?>';
   document.formv1.d5od.value = '<?php echo "$d5odsk";?>';
   document.formv1.d5do.value = '<?php echo "$d5dosk";?>';
   document.formv1.d6od.value = '<?php echo "$d6odsk";?>';
   document.formv1.d6do.value = '<?php echo "$d6dosk";?>';

   document.formv1.d2r01.value = '<?php echo "$d2r01";?>';
   document.formv1.d2r02.value = '<?php echo "$d2r02";?>';
   document.formv1.d2r03.value = '<?php echo "$d2r03";?>';
   document.formv1.d3r01.value = '<?php echo "$d3r01";?>';
   document.formv1.d3r02.value = '<?php echo "$d3r02";?>';
   document.formv1.d3r03.value = '<?php echo "$d3r03";?>';
   document.formv1.d4r01.value = '<?php echo "$d4r01";?>';
   document.formv1.d4r02.value = '<?php echo "$d4r02";?>';
   document.formv1.d4r03.value = '<?php echo "$d4r03";?>';
   document.formv1.d5r01.value = '<?php echo "$d5r01";?>';
   document.formv1.d5r02.value = '<?php echo "$d5r02";?>';
   document.formv1.d5r03.value = '<?php echo "$d5r03";?>';
   document.formv1.d6r01.value = '<?php echo "$d6r01";?>';
   document.formv1.d6r02.value = '<?php echo "$d6r02";?>';
   document.formv1.d6r03.value = '<?php echo "$d6r03";?>';
   document.formv1.d7r02.value = '<?php echo "$d7r02";?>';
   document.formv1.d7r03.value = '<?php echo "$d7r03";?>';
<?php                     } ?>

<?php if ( $strana == 7 ) { ?>
   document.formv1.e1r01.value = '<?php echo "$e1r01";?>';
   document.formv1.e1r02.value = '<?php echo "$e1r02";?>';
   document.formv1.e1r03.value = '<?php echo "$e1r03";?>';
   document.formv1.e1r04.value = '<?php echo "$e1r04";?>';
   document.formv1.e1r05.value = '<?php echo "$e1r05";?>';
   document.formv1.e1r06.value = '<?php echo "$e1r06";?>';
   document.formv1.f1r01.value = '<?php echo "$f1r01";?>';
   document.formv1.f1r02.value = '<?php echo "$f1r02";?>';
   document.formv1.f1r03.value = '<?php echo "$f1r03";?>';

   document.formv1.g1r01.value = '<?php echo "$g1r01";?>';
   document.formv1.g1r02.value = '<?php echo "$g1r02";?>';
   document.formv1.g1r03.value = '<?php echo "$g1r03";?>';
   document.formv1.g2r01.value = '<?php echo "$g2r01";?>';
   document.formv1.g2r02.value = '<?php echo "$g2r02";?>';
   document.formv1.g2r03.value = '<?php echo "$g2r03";?>';
   document.formv1.g3r01.value = '<?php echo "$g3r01";?>';
   document.formv1.g3r02.value = '<?php echo "$g3r02";?>';
   document.formv1.g3r03.value = '<?php echo "$g3r03";?>';
   document.formv1.g3r04.value = '<?php echo "$g3r04";?>';
<?php                     } ?>

<?php if ( $strana == 8 ) { ?>
   document.formv1.hr01.value = '<?php echo "$hr01";?>';
   document.formv1.h1r02.value = '<?php echo "$h1r02";?>';
   document.formv1.h2r02.value = '<?php echo "$h2r02";?>';
   document.formv1.h1r03.value = '<?php echo "$h1r03";?>';
   document.formv1.h2r03.value = '<?php echo "$h2r03";?>';
   document.formv1.h1r04.value = '<?php echo "$h1r04";?>';
   document.formv1.h2r04.value = '<?php echo "$h2r04";?>';
   document.formv1.h1r05.value = '<?php echo "$h1r05";?>';
   document.formv1.h2r05.value = '<?php echo "$h2r05";?>';
   document.formv1.h1r06.value = '<?php echo "$h1r06";?>';
   document.formv1.h2r06.value = '<?php echo "$h2r06";?>';
   document.formv1.h1r07.value = '<?php echo "$h1r07";?>';
   document.formv1.h2r07.value = '<?php echo "$h2r07";?>';
   document.formv1.h1r08.value = '<?php echo "$h1r08";?>';
   document.formv1.h2r08.value = '<?php echo "$h2r08";?>';
   document.formv1.h1r09.value = '<?php echo "$h1r09";?>';
   document.formv1.h2r09.value = '<?php echo "$h2r09";?>';
   document.formv1.hr10.value = '<?php echo "$hr10";?>';
   document.formv1.i1r01.value = '<?php echo "$i1r01";?>';
   document.formv1.i1r02.value = '<?php echo "$i1r02";?>';
   document.formv1.i1r03.value = '<?php echo "$i1r03";?>';
   document.formv1.i1r04.value = '<?php echo "$i1r04";?>';
   document.formv1.i1r05.value = '<?php echo "$i1r05";?>';
   document.formv1.i1r06.value = '<?php echo "$i1r06";?>';
   document.formv1.i1r07.value = '<?php echo "$i1r07";?>';
   document.formv1.i2r01.value = '<?php echo "$i2r01";?>';
   document.formv1.i2r02.value = '<?php echo "$i2r02";?>';
   document.formv1.i2r03.value = '<?php echo "$i2r03";?>';
   document.formv1.i2r04.value = '<?php echo "$i2r04";?>';
   document.formv1.i2r05.value = '<?php echo "$i2r05";?>';
   document.formv1.i2r06.value = '<?php echo "$i2r06";?>';
   document.formv1.i2r07.value = '<?php echo "$i2r07";?>';
   document.formv1.jr01.value = '<?php echo "$jr01";?>';
   document.formv1.jr02.value = '<?php echo "$jr02";?>';
<?php                     } ?>

<?php if ( $strana == 9 ) { ?>
   document.formv1.k1od.value = '<?php echo "$k1odsk";?>';
   document.formv1.k1do.value = '<?php echo "$k1dosk";?>';
   document.formv1.k2od.value = '<?php echo "$k2odsk";?>';
   document.formv1.k2do.value = '<?php echo "$k2dosk";?>';
   document.formv1.k3od.value = '<?php echo "$k3odsk";?>';
   document.formv1.k3do.value = '<?php echo "$k3dosk";?>';
   document.formv1.k4od.value = '<?php echo "$k4odsk";?>';
   document.formv1.k4do.value = '<?php echo "$k4dosk";?>';
   document.formv1.k2r01.value = '<?php echo "$k2r01";?>';
   document.formv1.k3r01.value = '<?php echo "$k3r01";?>';
   document.formv1.k4r01.value = '<?php echo "$k4r01";?>';
   document.formv1.k5r01.value = '<?php echo "$k5r01";?>';
   document.formv1.k2r02.value = '<?php echo "$k2r02";?>';
   document.formv1.k3r02.value = '<?php echo "$k3r02";?>';
   document.formv1.k4r02.value = '<?php echo "$k4r02";?>';
   document.formv1.k5r02.value = '<?php echo "$k5r02";?>';
   document.formv1.k2r03.value = '<?php echo "$k2r03";?>';
   document.formv1.k3r03.value = '<?php echo "$k3r03";?>';
   document.formv1.k4r03.value = '<?php echo "$k4r03";?>';
   document.formv1.k5r03.value = '<?php echo "$k5r03";?>';
   document.formv1.k2r04.value = '<?php echo "$k2r04";?>';
   document.formv1.k3r04.value = '<?php echo "$k3r04";?>';
   document.formv1.k4r04.value = '<?php echo "$k4r04";?>';
   document.formv1.k5r04.value = '<?php echo "$k5r04";?>';
<?php if ( $pzano == 1 ) { ?> document.formv1.pzano.checked = "checked"; <?php } ?>
<?php if ( $zslu == 1 ) { ?> document.formv1.zslu.checked = "checked"; <?php } ?>
   document.formv1.pcdar.value = '<?php echo "$pcdar";?>';
   document.formv1.pcpod.value = '<?php echo "$pcpod";?>';
   document.formv1.pc155.value = '<?php echo "$pc155";?>';
   document.formv1.pcpoc.value = '<?php echo "$pcpoc";?>';
   document.formv1.pcsum.value = '<?php echo "$pcsum";?>';
   document.formv1.p1ico.value = '<?php echo "$p1ico";?>';
   document.formv1.p1sid.value = '<?php echo "$p1sid";?>';
   document.formv1.p1pfr.value = '<?php echo "$p1pfr";?>';
   document.formv1.p1men.value = '<?php echo "$p1men";?>';
   document.formv1.p1uli.value = '<?php echo "$p1uli";?>';
   document.formv1.p1cdm.value = '<?php echo "$p1cdm";?>';
   document.formv1.p1psc.value = '<?php echo "$p1psc";?>';
   document.formv1.p1mes.value = '<?php echo "$p1mes";?>';
<?php                     } ?>

<?php if ( $strana == 10 ) { ?>
   document.formv1.ooprie.value = '<?php echo "$ooprie";?>';
   document.formv1.oomeno.value = '<?php echo "$oomeno";?>';
   document.formv1.ootitl.value = '<?php echo "$ootitl";?>';
   document.formv1.otitz.value = '<?php echo "$otitz";?>';
   document.formv1.oopost.value = '<?php echo "$oopost";?>';
   document.formv1.oouli.value = '<?php echo "$oouli";?>';
   document.formv1.oocdm.value = '<?php echo "$oocdm";?>';
   document.formv1.oopsc.value = '<?php echo "$oopsc";?>';
   document.formv1.oomes.value = '<?php echo "$oomes";?>';
   document.formv1.ootel.value = '<?php echo "$ootel";?>';
   document.formv1.oofax.value = '<?php echo "$oofax";?>';
   document.formv1.oostat.value = '<?php echo "$oostat";?>';
   document.formv1.pril.value = '<?php echo "$pril";?>';
   document.formv1.datum.value = '<?php echo "$datum_sk";?>';
   document.formv1.datuk.value = '<?php echo "$datuk_sk";?>';
<?php if ( $vrat == 1 ) { ?> document.formv1.vrat.checked = "checked"; <?php } ?>
<?php if ( $vrpp == 1 ) { ?> document.formv1.vrpp.checked = "checked"; <?php } ?>
<?php if ( $vruc == 1 ) { ?> document.formv1.vruc.checked = "checked"; <?php } ?>
<?php                      } ?>

<?php if ( $strana == 11 ) { ?>
   document.formv1.pzs01.value = '<?php echo "$pzs01";?>';
   document.formv1.pzs02.value = '<?php echo "$pzs02";?>';
   document.formv1.pzs03.value = '<?php echo "$pzs03";?>';
   document.formv1.pzs04.value = '<?php echo "$pzs04";?>';
   document.formv1.pzd02.value = '<?php echo "$pzd02";?>';
   document.formv1.pzd03.value = '<?php echo "$pzd03";?>';
   document.formv1.pzd04.value = '<?php echo "$pzd04";?>';
   document.formv1.pzr05.value = '<?php echo "$pzr05";?>';
   document.formv1.pzr07.value = '<?php echo "$pzr07";?>';
   document.formv1.pzr08.value = '<?php echo "$pzr08";?>';
   document.formv1.pzr09.value = '<?php echo "$pzr09";?>';
   document.formv1.pzr10.value = '<?php echo "$pzr10";?>';
   document.formv1.pzr11.value = '<?php echo "$pzr11";?>';
   document.formv1.pzr12.value = '<?php echo "$pzr12";?>';
   document.formv1.pzr13.value = '<?php echo "$pzr13";?>';
   document.formv1.pzr14.value = '<?php echo "$pzr14";?>';
   document.formv1.pzr15.value = '<?php echo "$pzr15";?>';
   document.formv1.pzr16.value = '<?php echo "$pzr16";?>';
   document.formv1.pzdat.value = '<?php echo "$pzdat_sk";?>';
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

  function TlacPO()
  {
   window.open('../ucto/priznanie_po2015.php?strana=999&copern=11&drupoh=1&page=1&typ=PDF',
'_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMinRok()
  {
   window.open('../ucto/priznanie_po2015.php?cislo_oc=<?php echo $cislo_oc;?>&copern=3155&drupoh=1&page=1', '_self','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes');
  }
  function PoucVyplnenie()
  {
   window.open('../dokumenty/dan_z_prijmov2015/dppo2015/dppo_v15_poucenie.pdf',
'_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajVHpredDanou()
  {
   window.open('../ucto/priznanie_po2015.php?strana=2&copern=200&drupoh=1&page=1&typ=PDF&dppo=1', '_self');
  }
  function NacitajRozdielOdpisov()
  {
   window.open('priznanie_po2015.php?copern=101&strana=<?php echo $strana; ?>&rozdielodpisov=1', '_self');
  }
  function NacitajOdpisy()
  {
   window.open('../ucto/priznanie_po2015.php?strana=<?php echo $strana; ?>&copern=200&drupoh=1&page=1&typ=PDF&dppo=2', '_self');
  }
  function NacitajNedVyd()
  {
   window.open('priznanie_po2015.php?copern=101&strana=<?php echo $strana; ?>&nedanovevydavky=1', '_self');
  }
  function OdpocetStraty()
  {
   window.open('priznanie_po2015.php?copern=101&strana=<?php echo $strana; ?>&odpocetstraty=1', '_self');
  }
  function ZapocetDane()
  {
   window.open('priznanie_po2015.php?copern=101&strana=<?php echo $strana; ?>&zapocetdane=1', '_self');
  }
  function OdpocetVyskum()
  {
   window.open('priznanie_po2015.php?copern=101&strana=<?php echo $strana; ?>&odpocetvyskum=1', '_self');
  }

  function LicenciaTabK()
  {
   window.open('priznanie_po2015.php?copern=101&strana=<?php echo $strana; ?>&licenciatabk=1', '_self');
  }
  function Preddavky()
  {
   window.open('priznanie_po2015.php?copern=101&strana=<?php echo $strana; ?>&preddavky=1', '_self');
  }

//bud alebo checkbox v vi.cast
  function klikpost()
  {
   document.formv1.vruc.checked = false;
  }
  function klikucet()
  {
   document.formv1.vrpp.checked = false;
  }

  function NacitatUdaje(riadok)
  {
   var h_riadok = riadok;
   window.open('priznanie_po2015.php?h_riadok=' + h_riadok + '&copern=266&drupoh=1&page=1', '_self');
  }
  function POdoXML()
  {
   window.open('../ucto/priznaniepo_xml2015.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function InfoPreddDane()
  {
   window.open('../dokumenty/dan_z_prijmov2015/dppo2015/dppo_v15_r1110_vypocet.pdf',
'_blank', 'width=1080, height=540, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }

  function NacitajDanLicencia()
  {
   window.open('priznanie_po2015.php?copern=101&strana=<?php echo $strana; ?>&nacitajdanlicencia=1', '_self');
  }

</script>
</HEAD>
<BODY onload="ObnovUI(); <?php if ( $copern == 102 AND ( $strana == 2 OR $strana == 4 OR $strana == 6 ) ) ?>">
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">DaÚ z prÌjmov PO</td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/info_blue_icon.png" onclick="PoucVyplnenie();" title="PouËenie na vyplnenie" class="btn-form-tool">
     <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajMinRok();" title="NaËÌtaù ˙daje z minulÈho roka" class="btn-form-tool">
     <img src="../obr/ikony/upbox_blue_icon.png" onclick="POdoXML();" title="Export do XML" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacPO();" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
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
<FORM name="formv1" method="post" action="priznanie_po2015.php?strana=<?php echo $strana; ?>&copern=103">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive"; $clas5="noactive";
$clas6="noactive"; $clas7="noactive"; $clas8="noactive"; $clas9="noactive"; $clas10="noactive"; $clas11="noactive"; $clas12="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active"; if ( $strana == 3 ) $clas3="active";
if ( $strana == 4 ) $clas4="active"; if ( $strana == 5 ) $clas5="active"; if ( $strana == 6 ) $clas6="active";
if ( $strana == 7 ) $clas7="active"; if ( $strana == 8 ) $clas8="active"; if ( $strana == 9 ) $clas9="active";
if ( $strana == 10 ) $clas10="active";

$source="../ucto/priznanie_po2015.php?cislo_oc=".$cislo_oc."&drupoh=1&page=1&subor=0";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=4', '_self');" class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=6', '_self');" class="<?php echo $clas6; ?> toleft">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=7', '_self');" class="<?php echo $clas7; ?> toleft">7</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=8', '_self');" class="<?php echo $clas8; ?> toleft">8</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=9', '_self');" class="<?php echo $clas9; ?> toleft">9</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=10', '_self');" class="<?php echo $clas10; ?> toleft">10</a>
 <a href="#" onclick="window.open('priznanie_dppriloha2015.php?copern=1101&drupoh=1&page=1&volapo=1', '_self')" class="toleft">P1</a>
 <a href="#" onclick="window.open('priznanie_dppriloha2015.php?copern=101&drupoh=1&page=1&volapo=1', '_self')" class="toleft">P2</a>
 <a href="#" onclick="window.open('priznanie_dppriloha2015.php?copern=11&drupoh=1&page=1', '_blank')" class="toright">P2</a>
 <a href="#" onclick="window.open('priznanie_dppriloha2015.php?copern=1011&drupoh=1&page=1', '_blank')" class="toright">P1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=10', '_blank');" class="<?php echo $clas10; ?> toright">10</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=9', '_blank');" class="<?php echo $clas9; ?> toright">9</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=8', '_blank');" class="<?php echo $clas8; ?> toright">8</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=7', '_blank');" class="<?php echo $clas7; ?> toright">7</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=6', '_blank');" class="<?php echo $clas6; ?> toright">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=5', '_blank');" class="<?php echo $clas5; ?> toright">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=4', '_blank');" class="<?php echo $clas4; ?> toright">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=3', '_blank');" class="<?php echo $clas3; ?> toright">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">

 <input type="checkbox" name="prepocitaj" value="1" class="btn-prepocet"/>
<?php if ( $prepocitaj == 1 ) { ?>
 <script type="text/javascript">document.formv1.prepocitaj.checked = "checked";</script>
<?php                         } ?>
 <h5 class="btn-prepocet-title">PrepoËÌtaù hodnoty</h5>
 <div class="alert-pocitam"><?php echo $alertprepocet; ?></div>
</div>

<?php if ( $strana == 1 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str1.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 1.strana 240kB">

<span class="text-echo" style="top:263px; left:57px;"><?php echo $fir_fdic; ?></span>
<span class="text-echo" style="top:320px; left:57px;"><?php echo $fir_fico6; ?></span>
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
<input type="text" name="obod" id="obod" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:265px; left:690px;"/>
<input type="text" name="obdo" id="obdo" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:304px; left:690px;"/>
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
<div class="input-echo" style="width:843px; top:469px; left:52px;"><?php echo $fir_fnaz; ?></div>
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
<input type="checkbox" name="zahrprep" value="1" style="top:769px; left:499px;"/>
<input type="checkbox" name="chpld" value="1" style="top:800px; left:499px;"/>
<input type="checkbox" name="cho5k" value="1" style="top:825px; left:499px;"/>
<input type="checkbox" name="chpdl" value="1" style="top:850px; left:499px;"/>
<input type="checkbox" name="chndl" value="1" style="top:875px; left:499px;"/>

<!-- Stala prevadzkaren -->
<input type="text" name="pruli" id="pruli" style="width:633px; top:943px; left:52px;"/>
<input type="text" name="prcdm" id="prcdm" style="width:175px; top:943px; left:718px;"/>
<input type="text" name="prpsc" id="prpsc" style="width:107px; top:999px; left:51px;"/>
<input type="text" name="prmes" id="prmes" style="width:451px; top:999px; left:178px;"/>
<input type="text" name="prpoc" id="prpoc" style="width:59px; top:999px; left:649px;"/>
<?php                     } ?>


<?php if ( $strana == 2 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str2.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 2.strana 233kB">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>

<!-- II.CAST -->
<input type="text" name="r100" id="r100" onkeyup="CiarkaNaBodku(this);" style="width:310px; top:183px; left:508px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitajVHpredDanou();"
      title="NaËÌtaù VH pred zdanenÌm do r.100 a do tabuæky F (III.Ëasù PO 7. strana)"
      class="btn-row-tool" style="top:183px; left:833px;">
<input type="text" name="r110" id="r110" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:255px; left:529px;"/>
<input type="text" name="r120" id="r120" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:296px; left:529px;"/>
<input type="text" name="r130" id="r130" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:340px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitajNedVyd();"
      title="NaËÌtaù nedaÚovÈ v˝davky (n·klady) z tabuæky A (III.Ëasù PO 4. a 5.strana)"
      class="btn-row-tool" style="top:339px; left:833px;">
<input type="text" name="r140" id="r140" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:382px; left:529px;"/>
<input type="text" name="r150" id="r150" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:421px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitajRozdielOdpisov();"
      title="NaËÌtaù rozdiel daÚov˝ch a ˙Ëtovn˝ch odpisov z tabuæky B (III.Ëasù PO 5.strana)"
      class="btn-row-tool" style="top:421px; left:833px;">
<input type="text" name="r160" id="r160" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:460px; left:529px;"/>
<input type="text" name="r170" id="r170" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:508px; left:529px;"/>
<input type="text" name="r180" id="r180" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:554px; left:529px;"/>
<div class="input-echo right" style="width:290px; top:594px; left:530px;"><?php echo $r200; ?>&nbsp;</div>
<input type="text" name="r210" id="r210" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:660px; left:529px;"/>
<input type="text" name="r220" id="r220" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:702px; left:529px;"/>
<input type="text" name="r230" id="r230" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:744px; left:529px;"/>
<input type="text" name="r240" id="r240" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:783px; left:529px;"/>
<input type="text" name="r250" id="r250" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:822px; left:529px;"/>
<input type="text" name="r260" id="r260" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:864px; left:529px;"/>
<input type="text" name="r270" id="r270" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:908px; left:529px;"/>
<input type="text" name="r280" id="r280" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:961px; left:529px;"/>
<input type="text" name="r290" id="r290" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1011px; left:529px;"/>
<div class="input-echo right" style="width:290px; top:1050px; left:530px;"><?php echo $r300; ?>&nbsp;</div>
<input type="text" name="r301" id="r301" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1117px; left:529px;"/>
<input type="text" name="r302" id="r302" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1156px; left:529px;"/>
<input type="text" name="r303" id="r303" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1204px; left:529px;"/>
<?php                     } ?>


<?php if ( $strana == 3 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str3.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 3.strana 233kB">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>

<!-- II.CAST pokracovanie -->
<input type="text" name="r304" id="r304" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:119px; left:529px;"/>
<input type="text" name="r305" id="r305" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:162px; left:529px;"/>
<input type="text" name="r310" id="r310" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:228px; left:529px;"/>
<input type="text" name="r320" id="r320" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:270px; left:529px;"/>
<input type="text" name="r330" id="r330" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:312px; left:529px;"/>
<input type="text" name="r400" id="r400" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:351px; left:529px;"/>

<input type="text" name="r410" id="r410" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:416px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="OdpocetStraty();"
      title="NaËÌtaù odpoËet straty z tabuæky D stÂpec 7 riadok 2 na str.6"
      class="btn-row-tool" style="top:416px; left:833px;">
<input type="text" name="r500" id="r500" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:455px; left:529px;"/>
<input type="text" name="r501" id="r501" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:520px; left:529px;"/>

 <img src="../obr/ikony/calculator_blue_icon.png" onclick="OdpocetVyskum();"
      title="NaËÌtaù odpoËet v˝davkov na v˝skum a v˝voj z r.7 PrÌlohy P1"
      class="btn-row-tool" style="top:520px; left:833px;">

<input type="text" name="r510" id="r510" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:559px; left:529px;"/>
<input type="text" name="r550" id="r550" onkeyup="CiarkaNaBodku(this);" style="width:36px; top:624px; left:529px;"/>
<input type="text" name="r600" id="r600" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:663px; left:529px;"/>
<select size="1" id="r610text" name="r610text" style="width:426px; top:740px; left:55px;">
 <option value=""></option>
 <option value="ß 30a z·kona Ë. 595/2003 Z.z.">ß 30a z·kona Ë. 595/2003 Z.z.</option>
 <option value="ß 30b z·kona Ë. 595/2003 Z.z.">ß 30b z·kona Ë. 595/2003 Z.z.</option>
 <option value="ß 35 z·kona Ë. 366/1999 Z. z.">ß 35 z·kona Ë. 366/1999 Z. z.</option>
 <option value="ß 35a z·kona Ë. 366/1999 Z. z.">ß 35a z·kona Ë. 366/1999 Z. z.</option>
 <option value="ß 35a ods. 9 z·kona Ë. 366/1999 Z. z.">ß 35a ods. 9 z·kona Ë. 366/1999 Z. z.</option>
 <option value="ß 35b z·kona Ë. 366/1999 Z. z.">ß 35b z·kona Ë. 366/1999 Z. z.</option>
 <option value="ß 35c z·kona Ë. 366/1999 Z. z.">ß 35c z·kona Ë. 366/1999 Z. z.</option>
</select>
<input type="text" name="r610" id="r610" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:734px; left:529px;"/>
<input type="text" name="r700" id="r700" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:776px; left:529px;"/>
<input type="text" name="r710" id="r710" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:841px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="ZapocetDane();"
      title="NaËÌtaù z·poËet dane z tabuæky E riadok 6 na str.7"
      class="btn-row-tool" style="top:841px; left:833px;">
<input type="text" name="r800" id="r800" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:881px; left:529px;"/>
<input type="text" name="r810" id="r810" style="width:82px; top:945px; left:667px;"/>
<input type="text" name="r820" id="r820" onkeyup="CiarkaNaBodku(this);" style="width:150px; top:984px; left:667px;"/>
<input type="text" name="r830" id="r830" style="width:82px; top:1029px; left:667px;"/>
<input type="text" name="r900" id="r900" style="width:82px; top:1073px; left:667px;"/>
<?php                     } ?>


<?php if ( $strana == 4 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str4.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 4.strana 224kB">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>

<!-- II.CAST pokracovanie -->
<input type="text" name="r910" id="r910" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:136px; left:529px;"/>
<input type="text" name="r920" id="r920" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:177px; left:529px;"/>

 <img src="../obr/ikony/calculator_blue_icon.png" onclick="LicenciaTabK();"
      title="Kladn˝ rozdiel medzi daÚovou licenciou a daÚou z predch. obdobÌ z r.5 stÂpec 4. tabuæky K na 9.strane max. do v˝öky na riadku 910"
      class="btn-row-tool" style="top:177px; left:833px;">

<input type="text" name="r1000" id="r1000" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:219px; left:529px;"/>
<input type="text" name="r1010" id="r1010" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:304px; left:529px;"/>
<input type="text" name="r1020" id="r1020" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:343px; left:529px;"/>
<input type="text" name="r1030" id="r1030" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:382px; left:529px;"/>
<input type="text" name="r1040" id="r1040" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:421px; left:529px;"/>
<input type="text" name="r1050" id="r1050" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:462px; left:529px;"/>
<input type="text" name="r1100" id="r1100" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:504px; left:529px;"/>
<input type="text" name="r1101" id="r1101" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:543px; left:529px;"/>

 <img src="../obr/ikony/info_blue_icon.png" title="SpÙsob v˝poËtu preddavku"
      onclick="InfoPreddDane();" class="btn-row-tool" style="top:627px; left:440px;">
<input type="text" name="r1110" id="r1110" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:627px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="Preddavky();"
      title="VypoËÌtaù v˝öku preddavku na daÚ" class="btn-row-tool" style="top:627px; left:833px;">

<input type="text" name="dadod" id="dadod" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:695px; left:529px;"/>
<input type="text" name="r1120" id="r1120" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:735px; left:529px;"/>
<input type="text" name="r1130" id="r1130" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:773px; left:529px;"/>
<input type="text" name="r1140" id="r1140" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:812px; left:529px;"/>
<input type="text" name="r1150" id="r1150" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:851px; left:529px;"/>

<!-- III.CAST -->
<!-- A-Pripocitatelne polozky -->
<span id="pripoknobtn1" onclick="pripokno1.style.display='block'; pripoknobtn1.style.display='none';"
   title="Nastaviù ˙Ëty PripoËÌtateæn˝ch poloûiek" class="pripo-btn" style="top:952px;">Nastaviù</span>
<input type="text" name="a1r01" id="a1r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:991px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(1);"
      title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:991px; left:832px;">
<input type="text" name="a1r02" id="a1r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1067px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(2);"
      title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:1067px; left:832px;">
<input type="text" name="a1r03" id="a1r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1127px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(3);"
      title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:1127px; left:832px;">
<input type="text" name="a1r04" id="a1r04" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1189px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(4);"
      title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:1189px; left:832px;">
<?php                     } ?>


<?php if ( $strana == 5 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str5.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 5.strana 225kB">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>

<!-- III.CAST -->
<!-- A-Pripocitatelne polozky pokracovanie -->
<span id="pripoknobtn2" onclick="pripokno2.style.display='block'; pripoknobtn2.style.display='none';"
   title="Nastaviù ˙Ëty PripoËÌtateæn˝ch poloûiek" class="pripo-btn" style="top:94px;">Nastaviù</span>
<input type="text" name="a1r05" id="a1r05" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:115px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(5);"
      title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:115px; left:832px;">
<input type="text" name="a1r06" id="a1r06" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:157px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(6);"
      title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:157px; left:832px;">
<input type="text" name="a1r07" id="a1r07" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:199px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(7);"
      title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:199px; left:832px;">
<input type="text" name="a1r08" id="a1r08" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:237px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(8);"
      title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:237px; left:832px;">
<input type="text" name="a1r09" id="a1r09" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:275px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(9);"
      title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:275px; left:832px;">
<input type="text" name="a1r10" id="a1r10" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:315px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(10);"
      title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:315px; left:832px;">
<input type="text" name="a1r11" id="a1r11" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:353px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(11);"
      title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:353px; left:832px;">
<input type="text" name="a1r12" id="a1r12" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:392px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(12);"
      title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:392px; left:832px;">
<input type="text" name="a1r13" id="a1r13" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:431px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(13);"
      title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:431px; left:832px;">
<input type="text" name="a1r14" id="a1r14" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:470px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(14);"
      title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:470px; left:832px;">
<input type="text" name="a1r15" id="a1r15" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:509px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(15);"
      title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:510px; left:832px;">
<input type="text" name="a1r16" id="a1r16" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:548px; left:529px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitatUdaje(16);"
      title="NaËÌtaù odpoËÌtateæn˙" class="btn-row-tool" style="top:548px; left:832px;">
<div class="input-echo right" style="width:289px; top:588px; left:530px;"><?php echo $a1r17; ?>&nbsp;</div>

<!-- B-Odpisy HM -->
<input type="text" name="b1r01" id="b1r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:657px; left:529px;"/>
 <img src="../obr/ikony/info_blue_icon.png" class="btn-row-tool" style="top:658px; left:839px; cursor:default;"
      title="Musia byù spracovanÈ mesaËnÈ ˙ËtovnÈ odpisy za 12.<?php echo $kli_vrok; ?>,
             daÚovÈ odpisy a zostava neuplatnenÈho odpisu v 1.roku odpisovania">
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitajOdpisy();"
      title="Z podsystÈmu majetok naËÌtaù ˙ËtovnÈ, daÚovÈ odpisy a pomern˙ Ëasù z roËnÈho odpisu neuplatnen˙ v 1.roku odpisovania"
      class="btn-row-tool" style="top:658px; left:870px;">
<input type="text" name="b1r02" id="b1r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:695px; left:529px;"/>
<input type="text" name="b1r03" id="b1r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:735px; left:529px;"/>
<input type="text" name="b1r04" id="b1r04" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:774px; left:529px;"/>
<input type="text" name="b1r05" id="b1r05" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:812px; left:529px;"/>
<input type="text" name="b1r06" id="b1r06" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:851px; left:529px;"/>

<!-- C1 -->
<input type="text" name="c1r01" id="c1r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:935px; left:529px;"/>
<input type="text" name="c1r02" id="c1r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:974px; left:529px;"/>
<input type="text" name="c1r03" id="c1r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1012px; left:529px;"/>
<input type="text" name="c1r04" id="c1r04" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1052px; left:529px;"/>
<input type="text" name="c1r05" id="c1r05" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1090px; left:529px;"/>


<a href="#" id="pripoknobtn" onclick="pripokno.style.display='block'; pripoknobtn.style.display='none';"
   title="Nastaviù ˙Ëty PripoËÌtateæn˝ch poloûiek" class="pripo-btn hidden">Nastaviù</a>
<?php                     } ?>


<?php if ( $strana == 6 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str6.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 6.strana 195kB">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>

<!-- III.CAST pokracovanie -->
<!-- C2 -->
<input type="text" name="c2r01" id="c2r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:149px; left:529px;"/>
<input type="text" name="c2r02" id="c2r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:187px; left:529px;"/>
<input type="text" name="c2r03" id="c2r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:226px; left:529px;"/>
<input type="text" name="c2r04" id="c2r04" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:266px; left:529px;"/>
<input type="text" name="c2r05" id="c2r05" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:305px; left:529px;"/>

<!-- D-Strata -->
<!-- bod 1 -->
<input type="text" name="d1r01" id="d1r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:447px; left:604px;"/>
<input type="text" name="d1r02" id="d1r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:486px; left:604px;"/>
<input type="text" name="d1r03" id="d1r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:525px; left:604px;"/>
<!-- bod 2 -->
<input type="text" name="d2od" id="d2od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:590px; left:340px;"/>
<input type="text" name="d2do" id="d2do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:628px; left:340px;"/>
<input type="text" name="d2r01" id="d2r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:668px; left:293px;"/>
<input type="text" name="d2r02" id="d2r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:707px; left:293px;"/>
<input type="text" name="d2r03" id="d2r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:745px; left:293px;"/>
<!-- bod 3 -->
<input type="text" name="d3od" id="d3od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:590px; left:650px;"/>
<input type="text" name="d3do" id="d3do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:628px; left:650px;"/>
<input type="text" name="d3r01" id="d3r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:668px; left:604px;"/>
<input type="text" name="d3r02" id="d3r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:707px; left:604px;"/>
<input type="text" name="d3r03" id="d3r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:745px; left:604px;"/>
<!-- bod 4 -->
<input type="text" name="d4od" id="d4od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:821px; left:340px;"/>
<input type="text" name="d4do" id="d4do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:860px; left:340px;"/>
<input type="text" name="d4r01" id="d4r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:900px; left:293px;"/>
<input type="text" name="d4r02" id="d4r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:938px; left:293px;"/>
<input type="text" name="d4r03" id="d4r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:976px; left:293px;"/>
<!-- bod 5 -->
<input type="text" name="d5od" id="d5od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:821px; left:650px;"/>
<input type="text" name="d5do" id="d5do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:860px; left:650px;"/>
<input type="text" name="d5r01" id="d5r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:900px; left:604px;"/>
<input type="text" name="d5r02" id="d5r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:938px; left:604px;"/>
<input type="text" name="d5r03" id="d5r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:976px; left:604px;"/>
<!-- bod 6 -->
<input type="text" name="d6od" id="d6od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:1042px; left:340px;"/>
<input type="text" name="d6do" id="d6do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:1081px; left:340px;"/>
<input type="text" name="d6r01" id="d6r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1120px; left:293px;"/>
<input type="text" name="d6r02" id="d6r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1159px; left:293px;"/>
<input type="text" name="d6r03" id="d6r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1198px; left:293px;"/>
<!-- bod 7 -->
<input type="text" name="d7r02" id="d7r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1159px; left:604px;"/>
<input type="text" name="d7r03" id="d7r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1198px; left:604px;"/>
<?php                     } ?>


<?php if ( $strana == 7 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str7.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 7.strana 219kB">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>

<!-- III.CAST pokracovanie -->
<!-- E -->
<input type="text" name="e1r01" id="e1r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:139px; left:529px;"/>
<input type="text" name="e1r02" id="e1r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:178px; left:529px;"/>
<input type="text" name="e1r03" id="e1r03" onkeyup="CiarkaNaBodku(this);" style="width:128px; top:217px; left:529px;"/>
<input type="text" name="e1r04" id="e1r04" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:255px; left:529px;"/>
<input type="text" name="e1r05" id="e1r05" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:295px; left:529px;"/>
<input type="text" name="e1r06" id="e1r06" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:334px; left:529px;"/>
<!-- F -->
<input type="text" name="f1r01" id="f1r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:405px; left:529px;"/>
<input type="text" name="f1r02" id="f1r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:444px; left:529px;"/>
<input type="text" name="f1r03" id="f1r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:483px; left:529px;"/>
<!-- G1 -->
<input type="text" name="g1r01" id="g1r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:554px; left:529px;"/>
<input type="text" name="g1r02" id="g1r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:592px; left:529px;"/>
<input type="text" name="g1r03" id="g1r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:631px; left:529px;"/>
<!-- G2 -->
<input type="text" name="g2r01" id="g2r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:745px; left:529px;"/>
<input type="text" name="g2r02" id="g2r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:784px; left:529px;"/>
<input type="text" name="g2r03" id="g2r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:825px; left:529px;"/>
<!-- G3 -->
<input type="text" name="g3r01" id="g3r01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:947px; left:529px;"/>
<input type="text" name="g3r02" id="g3r02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:989px; left:529px;"/>
<input type="text" name="g3r03" id="g3r03" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1028px; left:529px;"/>
<input type="text" name="g3r04" id="g3r04" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1067px; left:529px;"/>
<?php                     } ?>


<?php if ( $strana == 8 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str8.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 8.strana 207kB">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>

<!-- III.CAST pokracovanie -->
<!-- H -->
<input type="text" name="hr01" id="hr01" onkeyup="CiarkaNaBodku(this);" style="width:309px; top:159px; left:394px;"/>
<input type="text" name="h1r02" id="h1r02" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:221px; left:293px;"/>
<input type="text" name="h2r02" id="h2r02" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:221px; left:603px;"/>
<input type="text" name="h1r03" id="h1r03" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:260px; left:293px;"/>
<input type="text" name="h2r03" id="h2r03" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:260px; left:603px;"/>
<input type="text" name="h1r04" id="h1r04" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:300px; left:293px;"/>
<input type="text" name="h2r04" id="h2r04" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:300px; left:603px;"/>
<input type="text" name="h1r05" id="h1r05" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:337px; left:293px;"/>
<input type="text" name="h2r05" id="h2r05" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:337px; left:603px;"/>
<input type="text" name="h1r06" id="h1r06" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:377px; left:293px;"/>
<input type="text" name="h2r06" id="h2r06" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:377px; left:603px;"/>
<input type="text" name="h1r07" id="h1r07" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:416px; left:293px;"/>
<input type="text" name="h2r07" id="h2r07" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:416px; left:603px;"/>
<input type="text" name="h1r08" id="h1r08" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:455px; left:293px;"/>
<input type="text" name="h2r08" id="h2r08" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:455px; left:603px;"/>
<input type="text" name="h1r09" id="h1r09" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:494px; left:293px;"/>
<input type="text" name="h2r09" id="h2r09" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:494px; left:603px;"/>
<input type="text" name="hr10" id="hr10" onkeyup="CiarkaNaBodku(this);" style="width:309px; top:537px; left:394px;"/>
<!-- I -->
<input type="text" name="i1r01" id="i1r01" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:649px; left:293px;"/>
<input type="text" name="i2r01" id="i2r01" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:649px; left:603px;"/>
<input type="text" name="i1r02" id="i1r02" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:688px; left:293px;"/>
<input type="text" name="i2r02" id="i2r02" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:688px; left:603px;"/>
<input type="text" name="i1r03" id="i1r03" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:726px; left:293px;"/>
<input type="text" name="i2r03" id="i2r03" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:726px; left:603px;"/>
<input type="text" name="i1r04" id="i1r04" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:804px; left:293px;"/>
<input type="text" name="i2r04" id="i2r04" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:804px; left:603px;"/>
<input type="text" name="i1r05" id="i1r05" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:843px; left:293px;"/>
<input type="text" name="i2r05" id="i2r05" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:843px; left:603px;"/>
<input type="text" name="i1r06" id="i1r06" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:881px; left:293px;"/>
<input type="text" name="i2r06" id="i2r06" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:881px; left:603px;"/>
<input type="text" name="i1r07" id="i1r07" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:920px; left:293px;"/>
<input type="text" name="i2r07" id="i2r07" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:920px; left:603px;"/>
<!-- J -->
<input type="text" name="jr01" id="jr01" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:992px; left:529px;"/>
<input type="text" name="jr02" id="jr02" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:1031px; left:529px;"/>
<?php                     } ?>


<?php if ( $strana == 9 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str9.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 9.strana 240kB">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>

<!-- III.CAST pokracovanie -->
<!-- K -->
<!-- riadok 1 -->
<input type="text" name="k1od" id="k1od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:244px; left:62px;"/>
<input type="text" name="k1do" id="k1do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:282px; left:62px;"/>

 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitajDanLicencia();"
      title="NaËÌtaù v˝öku kladnÈho rozdielu medzi daÚovou licenciou a daÚou, ktor˙ moûno zapoËÌtaù v roku 2015 z r.830 Priznania DPPO 2014"
      class="btn-row-tool" style="top:282px; left:280px;">

<input type="text" name="k2r01" id="k2r01" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:244px; left:276px;"/>
<input type="text" name="k3r01" id="k3r01" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:244px; left:436px;"/>
<input type="text" name="k4r01" id="k4r01" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:244px; left:595px;"/>
<input type="text" name="k5r01" id="k5r01" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:244px; left:753px;"/>
<!-- riadok 2 -->
<input type="text" name="k2od" id="k2od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:321px; left:62px;"/>
<input type="text" name="k2do" id="k2do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:360px; left:62px;"/>
<input type="text" name="k2r02" id="k2r02" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:321px; left:276px;"/>
<input type="text" name="k3r02" id="k3r02" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:321px; left:436px;"/>
<input type="text" name="k4r02" id="k4r02" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:321px; left:595px;"/>
<input type="text" name="k5r02" id="k5r02" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:321px; left:753px;"/>
<!-- riadok 3 -->
<input type="text" name="k3od" id="k3od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:399px; left:62px;"/>
<input type="text" name="k3do" id="k3do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:438px; left:62px;"/>
<input type="text" name="k2r03" id="k2r03" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:399px; left:276px;"/>
<input type="text" name="k3r03" id="k3r03" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:399px; left:436px;"/>
<input type="text" name="k4r03" id="k4r03" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:399px; left:595px;"/>
<input type="text" name="k5r03" id="k5r03" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:399px; left:753px;"/>
<!-- riadok 4 -->
<input type="text" name="k4od" id="k4od" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:477px; left:62px;"/>
<input type="text" name="k4do" id="k4do" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:515px; left:62px;"/>
<input type="text" name="k2r04" id="k2r04" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:477px; left:276px;"/>
<input type="text" name="k3r04" id="k3r04" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:477px; left:436px;"/>
<input type="text" name="k4r04" id="k4r04" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:477px; left:595px;"/>
<input type="text" name="k5r04" id="k5r04" onkeyup="CiarkaNaBodku(this);" style="width:140px; top:477px; left:753px;"/>
<!-- riadok 5 -->
<div class="input-echo right" style="width:140px; top:555px; left:596px;"><?php echo $k4r05; ?>&nbsp;</div>
<div class="input-echo right" style="width:140px; top:555px; left:754px;"><?php echo $k5r05; ?>&nbsp;</div>

<!-- IV.CAST -->
<input type="checkbox" name="pzano" value="1" style="top:657px; left:59px;"/>
<input type="checkbox" name="zslu" value="1" style="top:657px; left:318px;"/>
<input type="text" name="pcdar" id="pcdar" onkeyup="CiarkaNaBodku(this);" style="width:268px; top:697px; left:626px;"/>
<input type="text" name="pcpod" id="pcpod" onkeyup="CiarkaNaBodku(this);" style="width:268px; top:742px; left:626px;"/>
<input type="text" name="pc155" id="pc155" onkeyup="CiarkaNaBodku(this);" style="width:268px; top:786px; left:626px;"/>
<input type="text" name="pcpoc" id="pcpoc" style="width:84px; top:829px; left:626px;"/>
<!-- Prijimatel 1 -->
<input type="text" name="pcsum" id="pcsum" onkeyup="CiarkaNaBodku(this);" style="width:268px; top:938px; left:201px;"/>
<input type="text" name="p1ico" id="p1ico" style="width:175px; top:993px; left:51px;"/>
<input type="text" name="p1sid" id="p1sid" style="width:84px; top:993px; left:258px;"/>
<input type="text" name="p1pfr" id="p1pfr" style="width:519px; top:993px; left:374px;"/>
<input type="text" name="p1men" id="p1men" style="width:842px; top:1044px; left:51px;"/>
<input type="text" name="p1uli" id="p1uli" style="width:635px; top:1150px; left:51px;"/>
<input type="text" name="p1cdm" id="p1cdm" style="width:174px; top:1150px; left:719px;"/>
<input type="text" name="p1psc" id="p1psc" style="width:106px; top:1205px; left:51px;"/>
<input type="text" name="p1mes" id="p1mes" style="width:703px; top:1205px; left:190px;"/>
<?php                     } ?>


<?php if ( $strana == 10 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str10.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 10.strana 146kB">
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>

<!-- V.CAST -->
<textarea name="osobit" id="osobit" style="width:838px; height:280px; top:199px; left:53px;"><?php echo $osobit; ?></textarea>
<!-- Osoba opravnena -->
<input type="text" name="ooprie" id="ooprie" style="width:358px; top:552px; left:52px;"/>
<input type="text" name="oomeno" id="oomeno" style="width:243px; top:552px; left:430px;"/>
<input type="text" name="ootitl" id="ootitl" style="width:112px; top:552px; left:695px;"/>
<input type="text" name="otitz" id="otitz" style="width:66px; top:552px; left:827px;"/>
<input type="text" name="oopost" id="oopost" style="width:841px; top:605px; left:52px;"/>
<input type="text" name="oouli" id="oouli" style="width:634px; top:680px; left:52px;"/>
<input type="text" name="oocdm" id="oocdm" style="width:177px; top:680px; left:717px;"/>
<input type="text" name="oopsc" id="oopsc" style="width:105px; top:736px; left:52px;"/>
<input type="text" name="oomes" id="oomes" style="width:450px; top:736px; left:178px;"/>
<input type="text" name="oostat" id="oostat" style="width:245px; top:736px; left:649px;"/>
<input type="text" name="ootel" id="ootel" style="width:289px; top:791px; left:52px;"/>
<input type="text" name="oofax" id="oofax" style="width:521px; top:791px; left:373px;"/>

<input type="text" name="pril" id="pril" style="width:36px; top:841px; left:167px;"/>
<input type="text" name="datum" id="datum" onkeyup="CiarkaNaBodku(this);" style="width:198px; top:920px; left:74px;"/>

<!-- VI. CAST -->
<input type="checkbox" name="vrat" value="1" style="top:1004px; left:59px;"/>
<input type="checkbox" name="vrpp" value="1" onchange="klikpost();" style="top:1044px; left:122px;"/>
<input type="checkbox" name="vruc" value="1" onchange="klikucet();" style="top:1044px; left:324px;"/>
<!-- iban a ucet -->
<div class="input-echo" style="width:773px; top:1074px; left:117px;"><?php echo $fir_fib1; ?></div>
<div class="input-echo" style="width:381px; top:1127px; left:59px;"><?php echo $fir_fuc1; ?></div>
<div class="input-echo" style="width:81px; top:1127px; left:483px;"><?php echo $fir_fnm1; ?></div>
<input type="text" name="datuk" id="datuk" onkeyup="CiarkaNaBodku(this);" style="width:197px; top:1196px; left:75px;"/>
<?php                     } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=4', '_self');" class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=6', '_self');" class="<?php echo $clas6; ?> toleft">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=7', '_self');" class="<?php echo $clas7; ?> toleft">7</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=8', '_self');" class="<?php echo $clas8; ?> toleft">8</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=9', '_self');" class="<?php echo $clas9; ?> toleft">9</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=10', '_self');" class="<?php echo $clas10; ?> toleft">10</a>
 <a href="#" onclick="window.open('priznanie_dppriloha2015.php?copern=1101&drupoh=1&page=1&volapo=1', '_self')" class="toleft">P1</a>
 <a href="#" onclick="window.open('priznanie_dppriloha2015.php?copern=101&drupoh=1&page=1&volapo=1', '_self')" class="toleft">P2</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>
</FORM>

<?php if ( $strana == 4 ) { ?>
<!-- pripocitalne nastavenie -->
<FORM id="pripokno1" method="post" action="priznanie_po2015.php?strana=4&copern=4103"
      class="pripo-area" style="display:none; top:935px; height:336px;">
 <img src="../obr/ikony/turnoff_blue_icon.png" title="Skryù"
      onclick="pripokno1.style.display='none'; pripoknobtn1.style.display='block';" >
<table class="pripo-box">
<caption><strong>Nastavenie ˙Ëtov</strong>(v plnom tvare, napr. 51301,51302)</caption>
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
</table>
<INPUT type="submit" id="uloz" name="uloz" value="Uloûiù">
</FORM>
<?php                     } ?>

<?php if ( $strana == 5 ) { ?>
<FORM id="pripokno2" method="post" action="priznanie_po2015.php?strana=5&copern=5103"
      class="pripo-area" style="display:none; top:70px; height:536px;">
 <img src="../obr/ikony/turnoff_blue_icon.png" title="Skryù"
      onclick="pripokno2.style.display='none'; pripoknobtn2.style.display='block';" >
<table class="pripo-box">
<caption><strong>Nastavenie ˙Ëtov</strong>(v plnom tvare, napr. 51301,51302)</caption>
<tr>
 <td style="height:46px; line-height:46px;">
  <input type="text" name="a1u05" id="a1u05" value="<?php echo $a1u05; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:42px; line-height:42px;">
  <input type="text" name="a1u06" id="a1u06" value="<?php echo $a1u06; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:38px; line-height:38px;">
  <input type="text" name="a1u07" id="a1u07" value="<?php echo $a1u07; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:40px; line-height:40px;">
  <input type="text" name="a1u08" id="a1u08" value="<?php echo $a1u08; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:40px; line-height:40px;">
  <input type="text" name="a1u09" id="a1u09" value="<?php echo $a1u09; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:38px; line-height:38px;">
  <input type="text" name="a1u10" id="a1u10" value="<?php echo $a1u10; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:40px; line-height:40px;">
  <input type="text" name="a1u11" id="a1u11" value="<?php echo $a1u11; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:38px; line-height:38px;">
  <input type="text" name="a1u12" id="a1u12" value="<?php echo $a1u12; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:38px; line-height:38px;">
  <input type="text" name="a1u13" id="a1u13" value="<?php echo $a1u13; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:38px; line-height:38px;">
  <input type="text" name="a1u14" id="a1u14" value="<?php echo $a1u14; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:40px; line-height:40px;">
  <input type="text" name="a1u15" id="a1u15" value="<?php echo $a1u15; ?>"/>
 </td>
</tr>
<tr>
 <td style="height:40px; line-height:40px;">
  <input type="text" name="a1u16" id="a1u16" value="<?php echo $a1u16; ?>"/>
 </td>
</tr>
</table>
<INPUT type="submit" id="uloz" name="uloz" value="Uloûiù">
</FORM>
<?php                     } ?>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
    }
?>


<?php
//zostava PDF
if ( $copern == 11 )
     {

$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/priznaniepo_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/priznaniepo_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_po WHERE ico >= 0 "."";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$hlavicka=mysql_fetch_object($sql);

if ( $strana == 1 OR $strana == 999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str1.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,44," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//ico
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text=$fir_fico;
if ( $fir_fico < 1000000 ) { $text="00".$fir_fico; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");

//pravna forma
$fir_uctt03x=$fir_uctt03;
if( $fir_uctt03 == 999 ) { $fir_uctt03x=""; }
$A=substr($fir_uctt03x,0,1);
$B=substr($fir_uctt03x,1,1);
$C=substr($fir_uctt03x,2,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(5,6," ","$rmc",1,"C");

//druh priznania
$riadne="x"; $opravne=""; $dodat="";
if ( $hlavicka->druh == 2 ) { $riadne=""; $opravne="x"; $dodat=""; }
if ( $hlavicka->druh == 3 ) { $riadne=""; $opravne=""; $dodat="x"; }
$pdf->SetY(54);
$pdf->Cell(83,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$riadne","$rmc",1,"C");
$pdf->SetY(60);
$pdf->Cell(83,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$opravne","$rmc",1,"C");
$pdf->SetY(66);
$pdf->Cell(83,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$dodat","$rmc",1,"C");

//za zdanovacie obdobie
$textod=SkDatum($hlavicka->obod);
if ( $textod == '00.00.0000' ) { $textod="01.01.".$kli_vrok; }
$textdo=SkDatum($hlavicka->obdo);
if ( $textdo == '00.00.0000' ) { $textdo="31.12.".$kli_vrok; }
$t01=substr($textod,0,1);
$t02=substr($textod,1,1);
$t03=substr($textod,3,1);
$t04=substr($textod,4,1);
$t05=substr($textod,8,1);
$t06=substr($textod,9,1);
$pdf->SetY(56);
$pdf->Cell(143,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(14,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");
$t01=substr($textdo,0,1);
$t02=substr($textdo,1,1);
$t03=substr($textdo,3,1);
$t04=substr($textdo,4,1);
$t05=substr($textdo,8,1);
$t06=substr($textdo,9,1);
$pdf->SetY(65);
$pdf->Cell(143,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(14,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//sknace
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sn1a=substr($sknacea,0,1);
$sn2a=substr($sknacea,1,1);
$sknaceb=$pole[1];
$sn1b=substr($sknaceb,0,1);
$sn2b=substr($sknaceb,1,1);
$sknacec=$pole[2];
$sn1c=substr($sknacec,0,1);
//$sn2c=substr($sknacec,1,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$sn1a","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$sn2a","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn1b","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$sn2b","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn1c","$rmc",1,"C");//$pdf->Cell(4,6,"$sn2c","$rmc",0,"C");

//cinnost
$pdf->SetY(76);
$pdf->Cell(49,6," ","$rmc1",0,"C");$pdf->Cell(138,11,"$hlavicka->cinnost","$rmc",1,"L");

//I. CAST
//nazov
$pdf->Cell(190,15," ","$rmc1",1,"L");
$A=substr($fir_fnaz,0,1);
$B=substr($fir_fnaz,1,1);
$C=substr($fir_fnaz,2,1);
$D=substr($fir_fnaz,3,1);
$E=substr($fir_fnaz,4,1);
$F=substr($fir_fnaz,5,1);
$G=substr($fir_fnaz,6,1);
$H=substr($fir_fnaz,7,1);
$I=substr($fir_fnaz,8,1);
$J=substr($fir_fnaz,9,1);
$K=substr($fir_fnaz,10,1);
$L=substr($fir_fnaz,11,1);
$M=substr($fir_fnaz,12,1);
$N=substr($fir_fnaz,13,1);
$O=substr($fir_fnaz,14,1);
$P=substr($fir_fnaz,15,1);
$R=substr($fir_fnaz,16,1);
$S=substr($fir_fnaz,17,1);
$T=substr($fir_fnaz,18,1);
$U=substr($fir_fnaz,19,1);
$V=substr($fir_fnaz,20,1);
$W=substr($fir_fnaz,21,1);
$X=substr($fir_fnaz,22,1);
$Y=substr($fir_fnaz,23,1);
$Z=substr($fir_fnaz,24,1);
$A1=substr($fir_fnaz,25,1);
$B1=substr($fir_fnaz,26,1);
$C1=substr($fir_fnaz,27,1);
$D1=substr($fir_fnaz,28,1);
$E1=substr($fir_fnaz,29,1);
$F1=substr($fir_fnaz,30,1);
$G1=substr($fir_fnaz,31,1);
$H1=substr($fir_fnaz,32,1);
$I1=substr($fir_fnaz,33,1);
$J1=substr($fir_fnaz,34,1);
$K1=substr($fir_fnaz,35,1);
$L1=substr($fir_fnaz,36,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$L1","$rmc",1,"C");

//ulica
$pdf->Cell(190,28," ","$rmc1",1,"L");
$A=substr($fir_fuli,0,1);
$B=substr($fir_fuli,1,1);
$C=substr($fir_fuli,2,1);
$D=substr($fir_fuli,3,1);
$E=substr($fir_fuli,4,1);
$F=substr($fir_fuli,5,1);
$G=substr($fir_fuli,6,1);
$H=substr($fir_fuli,7,1);
$I=substr($fir_fuli,8,1);
$J=substr($fir_fuli,9,1);
$K=substr($fir_fuli,10,1);
$L=substr($fir_fuli,11,1);
$M=substr($fir_fuli,12,1);
$N=substr($fir_fuli,13,1);
$O=substr($fir_fuli,14,1);
$P=substr($fir_fuli,15,1);
$R=substr($fir_fuli,16,1);
$S=substr($fir_fuli,17,1);
$T=substr($fir_fuli,18,1);
$U=substr($fir_fuli,19,1);
$V=substr($fir_fuli,20,1);
$W=substr($fir_fuli,21,1);
$X=substr($fir_fuli,22,1);
$Y=substr($fir_fuli,23,1);
$Z=substr($fir_fuli,24,1);
$A1=substr($fir_fuli,25,1);
$B1=substr($fir_fuli,26,1);
$C1=substr($fir_fuli,27,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");

//cislo
$A=substr($fir_fcdm,0,1);
$B=substr($fir_fcdm,1,1);
$C=substr($fir_fcdm,2,1);
$D=substr($fir_fcdm,3,1);
$E=substr($fir_fcdm,4,1);
$F=substr($fir_fcdm,5,1);
$G=substr($fir_fcdm,6,1);
$H=substr($fir_fcdm,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");

//psc
$pdf->Cell(190,7," ","$rmc1",1,"L");
$A=substr($fir_fpsc,0,1);
$B=substr($fir_fpsc,1,1);
$C=substr($fir_fpsc,2,1);
$D=substr($fir_fpsc,3,1);
$E=substr($fir_fpsc,4,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");

//obec
$text=$fir_fmes;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);
$P=substr($text,15,1);
$R=substr($text,16,1);
$S=substr($text,17,1);
$T=substr($text,18,1);
$U=substr($text,19,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");

//stat
$text=$fstat;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//telefon
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text=$fir_ftel;
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t13","$rmc",0,"C");

//email / fax
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(115,6,"$fir_fem1","$rmc",1,"L");

//kriziky 1.stlpec
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text1="x"; if ( $uoskr == 0 ) $text1=" ";
$text2="x"; if ( $koskr == 0 ) $text2=" ";
$nerezidenttext="x"; if ( $nerezident == 0 ) $nerezidenttext=" ";
$text7="x"; if ( $zapdl == 0 ) $text7=" ";
$pdf->Cell(2,7," ","$rmc1",0,"C");$pdf->Cell(3,3,"$text1","$rmc",1,"C");
$pdf->Cell(190,4," ","$rmc1",1,"L");
$pdf->Cell(2,7," ","$rmc1",0,"C");$pdf->Cell(3,4,"$text2","$rmc",1,"C");
$pdf->Cell(190,6," ","$rmc1",1,"L");
$pdf->Cell(2,7," ","$rmc1",0,"C");$pdf->Cell(3,3,"$nerezidenttext","$rmc",1,"C");
$pdf->Cell(190,4," ","$rmc1",1,"L");
$pdf->Cell(2,7," ","$rmc1",0,"C");$pdf->Cell(3,3,"$text7","$rmc",1,"C");

//kriziky 2.stlpec
$pdf->SetY(171);
$zahrpreptext="x"; if ( $zahrprep == 0 ) $zahrpreptext=" ";
$pdf->Cell(101,7," ","$rmc1",0,"C");$pdf->Cell(3,3,"$zahrpreptext","$rmc",1,"C");
$pdf->SetY(178);
$text3="x"; if ( $chpld == 0 ) $text3=" ";
$pdf->Cell(101,7," ","$rmc1",0,"C");$pdf->Cell(3,3,"$text3","$rmc",1,"C");
$pdf->SetY(183);
$text4="x"; if ( $cho5k == 0 ) $text4=" ";
$pdf->Cell(101,7," ","$rmc1",0,"C");$pdf->Cell(3,4,"$text4","$rmc",1,"C");
$pdf->SetY(189);
$text5="x"; if ( $chpdl == 0 ) $text5=" ";
$pdf->Cell(101,7," ","$rmc1",0,"C");$pdf->Cell(3,3,"$text5","$rmc",1,"C");
$pdf->SetY(195);
$text6="x"; if ( $chndl == 0 ) $text6=" ";
$pdf->Cell(101,7," ","$rmc1",0,"C");$pdf->Cell(3,3,"$text6","$rmc",1,"C");

//prevadzkarne
//ulica
$pdf->Cell(190,12.5," ","$rmc1",1,"L");
$A=substr($pruli,0,1);
$B=substr($pruli,1,1);
$C=substr($pruli,2,1);
$D=substr($pruli,3,1);
$E=substr($pruli,4,1);
$F=substr($pruli,5,1);
$G=substr($pruli,6,1);
$H=substr($pruli,7,1);
$I=substr($pruli,8,1);
$J=substr($pruli,9,1);
$K=substr($pruli,10,1);
$L=substr($pruli,11,1);
$M=substr($pruli,12,1);
$N=substr($pruli,13,1);
$O=substr($pruli,14,1);
$P=substr($pruli,15,1);
$R=substr($pruli,16,1);
$S=substr($pruli,17,1);
$T=substr($pruli,18,1);
$U=substr($pruli,19,1);
$V=substr($pruli,20,1);
$W=substr($pruli,21,1);
$X=substr($pruli,22,1);
$Y=substr($pruli,23,1);
$Z=substr($pruli,24,1);
$A1=substr($pruli,25,1);
$B1=substr($pruli,26,1);
$C1=substr($pruli,27,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");

//cislo
$A=substr($prcdm,0,1);
$B=substr($prcdm,1,1);
$C=substr($prcdm,2,1);
$D=substr($prcdm,3,1);
$E=substr($prcdm,4,1);
$F=substr($prcdm,5,1);
$G=substr($prcdm,6,1);
$H=substr($prcdm,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");

//psc
$pdf->Cell(190,7," ","$rmc1",1,"L");
$A=substr($prpsc,0,1);
$B=substr($prpsc,1,1);
$C=substr($prpsc,2,1);
$D=substr($prpsc,3,1);
$E=substr($prpsc,4,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");

//obec
$A=substr($prmes,0,1);
$B=substr($prmes,1,1);
$C=substr($prmes,2,1);
$D=substr($prmes,3,1);
$E=substr($prmes,4,1);
$F=substr($prmes,5,1);
$G=substr($prmes,6,1);
$H=substr($prmes,7,1);
$I=substr($prmes,8,1);
$J=substr($prmes,9,1);
$K=substr($prmes,10,1);
$L=substr($prmes,11,1);
$M=substr($prmes,12,1);
$N=substr($prmes,13,1);
$O=substr($prmes,14,1);
$P=substr($prmes,15,1);
$R=substr($prmes,16,1);
$S=substr($prmes,17,1);
$T=substr($prmes,18,1);
$U=substr($prmes,19,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");

//pocet prevadzkarni
$hodx=10*$hlavicka->prpoc;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 4s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",1,"C");
                                      } //koniec 1.strana

if ( $strana == 2 OR $strana == 999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str2.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(63,5," ","$rmc1",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$J","$rmc",1,"C");

//II.CAST
//polozka100
$pdf->Cell(190,21," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r100;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf('% 12s',$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka110
$pdf->Cell(190,10," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r110;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka120
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r120;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka130
$pdf->Cell(190,5," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r130;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka140
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r140;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka150
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r150;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka160
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r160;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka170
$pdf->Cell(190,5," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r170;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka180
$pdf->Cell(190,5," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r180;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka200
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r200;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka210
$pdf->Cell(190,9," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r210;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka220
$pdf->Cell(190,4," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r220;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka230
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r230;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka240
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r240;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka250
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r250;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka260
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r260;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka270
$pdf->Cell(190,4," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r270;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka280
$pdf->Cell(190,6," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r280;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka290
$pdf->Cell(190,6," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r290;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka300
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r300;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka301
$pdf->Cell(190,9," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r301;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf('% 12s',$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka302
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r302;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka303
$pdf->Cell(190,5," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r303;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
                                      } //koniec 2.strana

if ( $strana == 3 OR $strana == 999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str3.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(63,5," ","$rmc1",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$J","$rmc",1,"C");

//II.CAST pokracovanie
//polozka304
$pdf->Cell(190,6," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r304;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka305
$pdf->Cell(190,4," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r305;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka310
$pdf->Cell(190,9," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r310;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka320
$pdf->Cell(190,4," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r320;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka330
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r330;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka400
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r400;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka410
$pdf->Cell(190,9," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r410;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka500
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r500;
if ( $hodx == 0 ) $hodx="000";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka501
$pdf->Cell(190,9," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r501;
if ( $hodx == 0 ) $hodx="000";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka510
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r510;
if ( $hodx == 0 ) $hodx="000";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka550
$pdf->Cell(190,8," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r550;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 2s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",1,"C");

//polozka600
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r600;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok610
$pdf->Cell(190,11," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r610;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(2,7," ","$rmc1",0,"R");$pdf->Cell(95,9,"$r610text","$rmc",0,"L");
$pdf->Cell(10,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka700
$pdf->Cell(190,4," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r700;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka710
$pdf->Cell(190,8," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r710;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka800
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r800;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka810
$pdf->Cell(190,9," ","$rmc1",1,"L");
$hodx=$hlavicka->r810;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 4s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$pdf->Cell(138,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

//polozka820
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r820;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka830
$pdf->Cell(190,4," ","$rmc1",1,"L");
$hodx=$hlavicka->r830;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 4s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$pdf->Cell(138,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

//polozka900
$pdf->Cell(190,4," ","$rmc1",1,"L");
$hodx=$hlavicka->r900;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 4s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$pdf->Cell(138,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");
                                      } //koniec 3.strana

if ( $strana == 4 OR $strana == 999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str4.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str4.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(63,5," ","$rmc1",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$J","$rmc",1,"C");

//II.CAST pokracovanie
//polozka910
$pdf->Cell(190,10," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r910;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka920
$pdf->Cell(190,4," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r920;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka1000
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r1000;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka1010
$pdf->Cell(190,13," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r1010;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka1020
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r1020;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka1030
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r1030;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka1040
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r1040;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka1050
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r1050;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka1100
$pdf->Cell(190,4," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r1100;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka1101
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r1101;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka1110
$pdf->Cell(190,13," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r1110;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//Dodatocne danove priznanie
//datum
$pdf->Cell(190,10," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->dadod);
if ( $text == '00.00.0000' ) { $text=""; }
if ( $druh != 3 ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//polozka1120
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r1120;
if ( $hodx == 0 ) $hodx="000";
$text=sprintf("% 12s",$hodx);
if ( $druh != 3 ) { $text=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka1130
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r1130;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
if ( $druh != 3 ) { $text=""; $znamienko=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//polozka1140
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r1140;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
if ( $druh != 3 ) { $text=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok 1150
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->r1150;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
if ( $druh != 3 ) { $text=""; $znamienko=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//III.CAST
//Tab.A
//riadok1
$pdf->Cell(190,26," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok2
$pdf->Cell(190,11," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok3
$pdf->Cell(190,8," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok4
$pdf->Cell(190,8," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r04;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
                                      } //koniec 4.strana

if ( $strana == 5 OR $strana == 999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str5.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str5.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(63,5," ","$rmc1",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$J","$rmc",1,"C");

//III.CAST
//Tab.A pokracovanie
//riadok5
$pdf->Cell(190,6," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r05;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok6
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r06;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok7
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r07;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok8
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r08;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok9
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r09;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok10
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r10;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok11
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r11;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok12
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r12;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok13
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r13;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok14
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r14;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok15
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r15;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok16
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r16;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok17
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->a1r17;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//Tab.B
//riadok1
$pdf->Cell(190,9," ","$rmc1",1,"L");
$hodx=100*$hlavicka->b1r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->b1r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->b1r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok4
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->b1r04;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok5
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->b1r05;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok6
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->b1r06;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//Tab.C1
//riadok1
$pdf->Cell(190,12," ","$rmc1",1,"L");
$hodx=100*$hlavicka->c1r01;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->c1r02;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->c1r03;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok4
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->c1r04;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok5
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->c1r05;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
                                      } //koniec 5.strana

if ( $strana == 6 OR $strana == 999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str6.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str6.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(63,5," ","$rmc1",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$J","$rmc",1,"C");

//III.CAST
//Tab.C2 pokracovanie
//riadok1
$pdf->Cell(190,13," ","$rmc1",1,"L");
$hodx=100*$hlavicka->c2r01;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->c2r02;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->c2r03;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok4
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->c2r04;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//riadok5
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->c2r05;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//Tab.D bod1
//riadok1
$pdf->Cell(190,26," ","$rmc1",1,"L");
$hodx=100*$hlavicka->d1r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(123,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$L","$rmc",1,"C");
//riadok2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->d1r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(123,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$L","$rmc",1,"C");
//riadok3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->d1r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(123,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$L","$rmc",1,"C");

//Tab.D
//od2
$pdf->Cell(190,9," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->d2od);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
//od3
$text=SkDatum($hlavicka->d3od);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(25,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");
//do2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->d2do);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
//do3
$text=SkDatum($hlavicka->d3do);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(25,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");
//bod2 riadok1
$pdf->Cell(190,2," ","$rmc1",1,"L");
$hodx=100*$hlavicka->d2r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//bod3 riadok1
$hodx=100*$hlavicka->d3r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$L","$rmc",1,"C");
//bod2 riadok2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->d2r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//bod3 riadok2
$hodx=100*$hlavicka->d3r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$L","$rmc",1,"C");
//bod2 riadok3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->d2r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//bod3 riadok3
$hodx=100*$hlavicka->d3r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$L","$rmc",1,"C");

//od4
$pdf->Cell(190,12," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->d4od);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
//od5
$text=SkDatum($hlavicka->d5od);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(25,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");
//do4
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->d4do);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
//do5
$text=SkDatum($hlavicka->d5do);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(25,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");
//bod4 riadok1
$pdf->Cell(190,2," ","$rmc1",1,"L");
$hodx=100*$hlavicka->d4r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//bod5 riadok1
$hodx=100*$hlavicka->d5r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$L","$rmc",1,"C");
//bod4 riadok2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->d4r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//bod5 riadok2
$hodx=100*$hlavicka->d5r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$L","$rmc",1,"C");
//bod4 riadok3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->d4r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//bod5 riadok3
$hodx=100*$hlavicka->d5r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$L","$rmc",1,"C");

//od6
$pdf->Cell(190,9," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->d6od);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");
//do6
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->d6do);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");
//bod6 riadok1
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->d6r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//bod6 riadok2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->d6r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//bod7 riadok2
$hodx=100*$hlavicka->d7r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$L","$rmc",1,"C");
//bod6 riadok3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->d6r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//bod7 riadok3
$hodx=100*$hlavicka->d7r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$L","$rmc",1,"C");
                                      } //koniec 6.strana

if ( $strana == 7 OR $strana == 999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str7.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str7.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(63,5," ","$rmc1",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$J","$rmc",1,"C");

//III.CAST pokracovanie
//tab.E
//riadok1
$pdf->Cell(190,11," ","$rmc1",1,"L");
$hodx=100*$hlavicka->e1r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//riadok2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->e1r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//riadok3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->e1r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 5s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",1,"C");
//riadok4
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->e1r04;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//riadok5
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->e1r05;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//riadok6
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->e1r06;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//Tab.F
//riadok1
$pdf->Cell(190,10," ","$rmc1",1,"L");
$hodx=100*$hlavicka->f1r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//riadok2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->f1r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//riadok3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->f1r03;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//Tab.G1
//riadok1
$pdf->Cell(190,10," ","$rmc1",1,"L");
$hodx=100*$hlavicka->g1r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//riadok2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->g1r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//riadok3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->g1r03;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//Tab.G2
//riadok1
$pdf->Cell(190,20," ","$rmc1",1,"L");
$hodx=100*$hlavicka->g2r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//riadok2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->g2r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//riadok3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->g2r03;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//Tab.G3
//riadok1
$pdf->Cell(190,22," ","$rmc1",1,"L");
$hodx=100*$hlavicka->g3r01;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//riadok2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->g3r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//riadok3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->g3r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//riadok4
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->g3r04;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
                                      } //koniec 7.strana

if ( $strana == 8 OR $strana == 999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str8.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str8.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(63,5," ","$rmc1",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$J","$rmc",1,"C");

//III.CAST pokracovanie
//Tab.H
//riadok1
$pdf->Cell(190,15," ","$rmc1",1,"L");
$hodx=100*$hlavicka->hr01;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(77,6," ","$rmc1",0,"R");$pdf->Cell(3,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");
//riadok2
$pdf->Cell(190,8," ","$rmc1",1,"L");
$hodx=100*$hlavicka->h1r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//
$hodx=100*$hlavicka->h2r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");
//riadok3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->h1r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//
$hodx=100*$hlavicka->h2r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");
//riadok4
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->h1r04;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//
$hodx=100*$hlavicka->h2r04;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");
//riadok5
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->h1r05;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//
$hodx=100*$hlavicka->h2r05;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");
//riadok6
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->h1r06;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//
$hodx=100*$hlavicka->h2r06;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");
//riadok7
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->h1r07;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//
$hodx=100*$hlavicka->h2r07;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");
//riadok8
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->h1r08;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//
$hodx=100*$hlavicka->h2r08;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");
//riadok9
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->h1r09;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//
$hodx=100*$hlavicka->h2r09;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");
//riadok10
$pdf->Cell(190,4," ","$rmc1",1,"L");
$hodx=100*$hlavicka->hr10;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(77,6," ","$rmc1",0,"R");$pdf->Cell(3,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");

//Tab.I
//riadok1
$pdf->Cell(190,19," ","$rmc1",1,"L");
$hodx=100*$hlavicka->i1r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//
$hodx=100*$hlavicka->i2r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");
//riadok2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->i1r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//
$hodx=100*$hlavicka->i2r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");
//riadok3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->i1r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//
$hodx=100*$hlavicka->i2r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");
//riadok4
$pdf->Cell(190,11," ","$rmc1",1,"L");
$hodx=100*$hlavicka->i1r04;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//
$hodx=100*$hlavicka->i2r04;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");
//riadok5
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->i1r05;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//
$hodx=100*$hlavicka->i2r05;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");
//riadok6
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->i1r06;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//
$hodx=100*$hlavicka->i2r06;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");
//riadok7
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->i1r07;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(55,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//
$hodx=100*$hlavicka->i2r07;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",1,"C");

//Tab.J
//riadok1
$pdf->Cell(190,11," ","$rmc1",1,"L");
$hodx=100*$hlavicka->jr01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//riadok2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->jr02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$pdf->Cell(107,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
                                      } //koniec 8.strana

if ( $strana == 9 OR $strana == 999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str9.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str9.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(63,5," ","$rmc1",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$J","$rmc",1,"C");

//tab.K
//riadok1
$pdf->Cell(190,34," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->k1od);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
//
$hodx=100*$hlavicka->k2r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
//
$hodx=100*$hlavicka->k3r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
//
$hodx=100*$hlavicka->k4r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
//
$hodx=100*$hlavicka->k5r01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",1,"C");
//
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->k1do);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");

//riadok2
$pdf->Cell(190,9," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->k2od);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
//
$hodx=100*$hlavicka->k2r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
//
$hodx=100*$hlavicka->k3r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
//
$hodx=100*$hlavicka->k4r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
//
$hodx=100*$hlavicka->k5r02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",1,"C");
//
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->k2do);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//riadok3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->k3od);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
//
$hodx=100*$hlavicka->k2r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
//
$hodx=100*$hlavicka->k3r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
//
$hodx=100*$hlavicka->k4r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
//
$hodx=100*$hlavicka->k5r03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",1,"C");
//
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->k3do);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//riadok4
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->k4od);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
//
$hodx=100*$hlavicka->k2r04;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
//
$hodx=100*$hlavicka->k3r04;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
//
$hodx=100*$hlavicka->k4r04;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
//
$hodx=100*$hlavicka->k5r04;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",1,"C");
//
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->k4do);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//riadok5
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$hlavicka->k4r05;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(122,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
//
$hodx=100*$hlavicka->k5r05;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",1,"C");

//IV.CAST
//neuplat. postup ß50zak
$pdf->Cell(190,17," ","$rmc1",1,"L");
$text="x";
if ( $pzano != 1 ) { $text=""; }
$pdf->Cell(4,3," ","$rmc1",0,"L");$pdf->Cell(3,3,"$text","$rmc",0,"C");
//suhlas udaje
$text1="x";
if ( $zslu != 1 ) { $text1=""; }
$pdf->Cell(54,3," ","$rmc1",0,"L");$pdf->Cell(3,3,"$text1","$rmc",1,"C");

//riadok1
$pdf->Cell(190,6," ","$rmc1",1,"L");
$hodx=100*$hlavicka->pcdar;
if ( $hodx == 0 ) $hodx="";
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $hodx=""; }
$text=sprintf("% 11s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$pdf->Cell(128,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//riadok2
$pdf->Cell(190,5," ","$rmc1",1,"L");
$hodx=100*$hlavicka->pcpod;
if ( $hodx == 0 ) $hodx="";
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $hodx=""; }
$text=sprintf("% 11s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$pdf->Cell(128,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//riadok3
$pdf->Cell(190,4," ","$rmc1",1,"L");
$hodx=100*$hlavicka->pc155;
if ( $hodx == 0 ) $hodx="";
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $hodx=""; }
$text=sprintf("% 11s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$pdf->Cell(128,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
//riadok4
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=$hlavicka->pcpoc;
if ( $hodx == 0 ) $hodx="";
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $hodx=""; }
$text=sprintf("% 4s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$pdf->Cell(129,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

//PRIJIMATEL 1
//suma
$pdf->Cell(190,19," ","$rmc1",1,"L");
$hodx=100*$hlavicka->pcsum;
if ( $hodx == 0 ) $hodx="";
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $hodx=""; }
$text=sprintf("% 11s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$pdf->Cell(34,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$K","$rmc",1,"C");
//ico
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text=$hlavicka->p1ico;
if ( $text == 0 ) { $text=""; }
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
if ( $hlavicka->p1ico < 1000000 AND $hlavicka->p1ico > 1 ) { $text="00".$hlavicka->p1ico; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
//sid
$text=$hlavicka->p1sid;
if ( $text == 0 ) { $text=""; }
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
//forma
$text=$hlavicka->p1pfr;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);
$P=substr($text,15,1);
$R=substr($text,16,1);
$S=substr($text,17,1);
$T=substr($text,18,1);
$U=substr($text,19,1);
$V=substr($text,20,1);
$W=substr($text,21,1);
$X=substr($text,22,1);
$pdf->Cell(6,6," ","$rmc1",0,"L");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$X","$rmc",1,"C");
//obchodne meno
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text=$hlavicka->p1men;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);
$P=substr($text,15,1);
$R=substr($text,16,1);
$S=substr($text,17,1);
$T=substr($text,18,1);
$U=substr($text,19,1);
$V=substr($text,20,1);
$W=substr($text,21,1);
$X=substr($text,22,1);
$Y=substr($text,23,1);
$Z=substr($text,24,1);
$A1=substr($text,25,1);
$B1=substr($text,26,1);
$C1=substr($text,27,1);
$D1=substr($text,28,1);
$E1=substr($text,29,1);
$F1=substr($text,30,1);
$G1=substr($text,31,1);
$H1=substr($text,32,1);
$I1=substr($text,33,1);
$J1=substr($text,34,1);
$K1=substr($text,35,1);
$L1=substr($text,36,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L1","$rmc",1,"C");
//
$pdf->Cell(190,2," ","$rmc1",1,"L");
$text=substr($hlavicka->p1men,37,36);
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);
$P=substr($text,15,1);
$R=substr($text,16,1);
$S=substr($text,17,1);
$T=substr($text,18,1);
$U=substr($text,19,1);
$V=substr($text,20,1);
$W=substr($text,21,1);
$X=substr($text,22,1);
$Y=substr($text,23,1);
$Z=substr($text,24,1);
$A1=substr($text,25,1);
$B1=substr($text,26,1);
$C1=substr($text,27,1);
$D1=substr($text,28,1);
$E1=substr($text,29,1);
$F1=substr($text,30,1);
$G1=substr($text,31,1);
$H1=substr($text,32,1);
$I1=substr($text,33,1);
$J1=substr($text,34,1);
$K1=substr($text,35,1);
$L1=substr($text,36,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L1","$rmc",1,"C");
//ulica
$pdf->Cell(190,10," ","$rmc1",1,"L");
$text=$hlavicka->p1uli;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);
$P=substr($text,15,1);
$R=substr($text,16,1);
$S=substr($text,17,1);
$T=substr($text,18,1);
$U=substr($text,19,1);
$V=substr($text,20,1);
$W=substr($text,21,1);
$X=substr($text,22,1);
$Y=substr($text,23,1);
$Z=substr($text,24,1);
$A1=substr($text,25,1);
$B1=substr($text,26,1);
$C1=substr($text,27,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
//cislo
$text=$hlavicka->p1cdm;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",1,"C");
//psc
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text=$hlavicka->p1psc;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
//obec
$text=$hlavicka->p1mes;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);
$P=substr($text,15,1);
$R=substr($text,16,1);
$S=substr($text,17,1);
$T=substr($text,18,1);
$U=substr($text,19,1);
$V=substr($text,20,1);
$W=substr($text,21,1);
$X=substr($text,22,1);
$Y=substr($text,23,1);
$Z=substr($text,24,1);
$A1=substr($text,25,1);
$B1=substr($text,26,1);
$C1=substr($text,27,1);
$D1=substr($text,28,1);
$E1=substr($text,29,1);
$F1=substr($text,30,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$F1","$rmc",1,"C");
                                      } //koniec 9.strana

if ( $strana == 10 OR $strana == 999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str10.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str10.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(63,5," ","$rmc1",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,5,"$J","$rmc",1,"C");

//V.CAST
//osobitne zaznamy
$pdf->Cell(190,24," ","$rmc1",1,"L");
$pole = explode("\r\n", $hlavicka->osobit);
$ipole=1;
foreach( $pole as $hodnota ) {
$pdf->Cell(2,5," ","$rmc1",0,"L");$pdf->Cell(186,7,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                             }

//OPRAVNENA OSOBA
//priezvisko
$pdf->SetY(121);
$text=$hlavicka->ooprie;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);
$P=substr($text,15,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
//meno
$text=$hlavicka->oomeno;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
//tituly opravnenej
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(26,6,"$ootitl","$rmc",0,"L");$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(16,6,"$otitz","$rmc",1,"L");
//postavenie k PO
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text=$hlavicka->oopost;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);
$P=substr($text,15,1);
$R=substr($text,16,1);
$S=substr($text,17,1);
$T=substr($text,18,1);
$U=substr($text,19,1);
$V=substr($text,20,1);
$W=substr($text,21,1);
$X=substr($text,22,1);
$Y=substr($text,23,1);
$Z=substr($text,24,1);
$A1=substr($text,25,1);
$B1=substr($text,26,1);
$C1=substr($text,27,1);
$D1=substr($text,28,1);
$E1=substr($text,29,1);
$F1=substr($text,30,1);
$G1=substr($text,31,1);
$H1=substr($text,32,1);
$I1=substr($text,33,1);
$J1=substr($text,34,1);
$K1=substr($text,35,1);
$L1=substr($text,36,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L1","$rmc",1,"C");
//ulica
$pdf->Cell(190,11," ","$rmc1",1,"L");
$text=$hlavicka->oouli;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);
$P=substr($text,15,1);
$R=substr($text,16,1);
$S=substr($text,17,1);
$T=substr($text,18,1);
$U=substr($text,19,1);
$V=substr($text,20,1);
$W=substr($text,21,1);
$X=substr($text,22,1);
$Y=substr($text,23,1);
$Z=substr($text,24,1);
$A1=substr($text,25,1);
$B1=substr($text,26,1);
$C1=substr($text,27,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
//cislo
$text=$hlavicka->oocdm;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",1,"C");
//psc
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text=$hlavicka->oopsc;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
//obec
$text=$hlavicka->oomes;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);
$P=substr($text,15,1);
$R=substr($text,16,1);
$S=substr($text,17,1);
$T=substr($text,18,1);
$U=substr($text,19,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
//stat
$text=$hlavicka->oostat;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$K","$rmc",1,"C");
//telefon opravnenej
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text=$hlavicka->ootel;
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t13","$rmc",0,"C");
//email / fax
$text=$hlavicka->oofax;
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(115,6,"$oofax","$rmc",1,"L");

//pocet priloh
$pdf->Cell(190,6," ","$rmc1",1,"L");
$hodx=1*$hlavicka->pril;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 2s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$pdf->Cell(27,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",1,"C");
//datum vyhlasujem
$pdf->Cell(190,11," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->datum);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$t04","$rmc",0,"C");
$pdf->Cell(14,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//VI.CAST
//ziadam o
$pdf->Cell(190,13," ","$rmc1",1,"L");
$vrattext="x";
if ( $vrat == 0 ) $vrattext=" ";
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,4,"$vrattext","$rmc",1,"C");

//postovou poukazkou ci na ucet
$pdf->Cell(190,5," ","$rmc1",1,"L");
$vructext="x";
if ( $vruc == 0 OR $vrat == 0 ) $vructext=" ";
$vrpptext="x";
if ( $vrpp == 0 OR $vrat == 0 OR $vruc == 1 ) $vrpptext=" ";
$pdf->Cell(17,4," ","$rmc1",0,"C");$pdf->Cell(4,4,"$vrpptext","$rmc",0,"C");$pdf->Cell(41,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$vructext","$rmc",1,"C");

//iban
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=$fir_fib1;
if ( $hlavicka->vruc == 0 ) $text="";
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
$t32=substr($text,31,1);
$t33=substr($text,32,1);
$t34=substr($text,33,1);
$pdf->Cell(16,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t31","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t32","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t33","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t34","$rmc",1,"C");

//cislo uctu
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text="SK0123456789+-ab";
$text=$fir_fuc1;
if ( $hlavicka->vruc == 0 ) $text="";
$pole = explode("-", $text);
$textp=$pole[0];
$textu=$pole[1];
if( $textu == '' ) { $textu=$textp; $textp=""; }
$t01=substr($textp,0,1);
$t02=substr($textp,1,1);
$t03=substr($textp,2,1);
$t04=substr($textp,3,1);
$t05=substr($textp,4,1);
$t06=substr($textp,5,1);
$t07=substr($textp,6,1);
$t08=substr($textu,0,1);
$t09=substr($textu,1,1);
$t10=substr($textu,2,1);
$t11=substr($textu,3,1);
$t12=substr($textu,4,1);
$t13=substr($textu,5,1);
$t14=substr($textu,6,1);
$t15=substr($textu,7,1);
$t16=substr($textu,8,1);
$t17=substr($textu,9,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t09","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t11","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t17","$rmc",0,"R");
//kod banky
$text=$fir_fnm1;
if ( $hlavicka->vruc == 0 ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"L");
//datum ziadosti o vratenie
$pdf->Cell(190,10," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->datuk);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(14,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");
                                       } //koniec 10.strana
  }
$i = $i + 1;
  }

$pdf->Output("$outfilex");
//koniec zostava PDF

//potvrdenie o podani
if ( $copern == 11 )
     {
if ( File_Exists("../tmp/potvrddpo.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/potvrddpo.$kli_uzid.pdf"); }
     $sirka_vyska="210,320";
     $velkost_strany = explode(",", $sirka_vyska);
     $pdf=new FPDF("P","mm", $velkost_strany );

$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(13);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_potvrdenie.jpg') )
{
$pdf->Image($jpg_cesta.'_potvrdenie.jpg',0,0,210,297);
}
$pdf->SetY(10);

//za obdobie
$pdf->Cell(190,25," ","$rmc1",1,"L");
$pdf->Cell(98,6," ","$rmc1",0,"C");$pdf->Cell(34,6,"$kli_vrok","$rmc",1,"C");

//nazov
$pdf->Cell(190,27," ","$rmc1",1,"L");
$pdf->Cell(11,7," ","$rmc1",0,"L");$pdf->Cell(141,7,"$fir_fnaz","$rmc",1,"L");

//dic
$pdf->Cell(190,6," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(11,8," ","$rmc1",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(5,5,"$B","$rmc",0,"C");$pdf->Cell(5,5,"$C","$rmc",0,"C");
$pdf->Cell(5,5,"$D","$rmc",0,"C");$pdf->Cell(6,5,"$E","$rmc",0,"C");$pdf->Cell(5,5,"$F","$rmc",0,"C");$pdf->Cell(5,5,"$G","$rmc",0,"C");
$pdf->Cell(5,5,"$H","$rmc",0,"C");$pdf->Cell(6,5,"$I","$rmc",0,"C");$pdf->Cell(5,5,"$J","$rmc",1,"C");

//ulica
$pdf->Cell(190,13," ","$rmc1",1,"L");
$pdf->Cell(11,6," ","$rmc1",0,"L");$pdf->Cell(141,8,"$fir_fuli $fir_fcdm","$rmc",1,"L");

//psc a obec
$pdf->Cell(190,5," ","$rmc1",1,"L");
$pdf->Cell(11,6," ","$rmc1",0,"L");$pdf->Cell(26,8,"$fir_fpsc","$rmc",0,"L");$pdf->Cell(20,6," ","$rmc1",0,"L");$pdf->Cell(95,8,"$fir_fmes","$rmc",1,"L");

//stat
$pdf->Cell(190,6," ","$rmc1",1,"L");
$pdf->Cell(11,6," ","$rmc1",0,"L");$pdf->Cell(46,6,"$fstat","$rmc",1,"L");

//udaje o danovom priznani
$pdf->Cell(190,16," ","$rmc1",1,"L");
if ( $r500 == 0 ) $r500="0.00";
if ( $r1100 == 0 ) $r1100="";
if ( $r1101 == 0 ) $r1101="";
$pdf->Cell(122,7," ","$rmc1",0,"L");$pdf->Cell(51,7,"$kli_vrok","$rmc",1,"C");
$pdf->Cell(122,7," ","$rmc1",0,"L");$pdf->Cell(51,8,"$r510","$rmc",1,"R");
$pdf->Cell(122,7," ","$rmc1",0,"L");$pdf->Cell(51,7,"$r1100","$rmc",1,"R");
$pdf->Cell(122,8," ","$rmc1",0,"L");$pdf->Cell(51,8,"$r1101","$rmc",1,"R");

$pdf->Output("../tmp/potvrddpo.$kli_uzid.pdf");
     }
//koniec potvrdenia o podani
?>

<?php if ( $xml == 0 ) { ?>
 <script type="text/javascript"> var okno = window.open("<?php echo $outfilex; ?>","_self"); </script>
<?php                  }
     }
?>

<?php
$cislista = include("uct_lista_norm.php");
//celkovy koniec dokumentu
  } while (false);
?>
</BODY>
</HTML>