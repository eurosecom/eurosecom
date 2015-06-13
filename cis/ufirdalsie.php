<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
$urov = 3000;
if( $_SERVER['SERVER_NAME'] == "www.medosro.sk" ) { $urov=5000; }
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//subor uctov danoveho uradu
$sql = "SELECT kkx FROM F$kli_vxcf"."_ufirdalsie";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = "DROP TABLE F$kli_vxcf"."_ufirdalsie "; 
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdkun
(
   ucdpfo1           VARCHAR(25) not null,
   ucdpfo2           VARCHAR(25) not null,
   ucdppo1           VARCHAR(25) not null,
   ucdppo2           VARCHAR(25) not null,
   ucdph             VARCHAR(25) not null,
   ucdpzc            VARCHAR(25) not null,
   ucdpzr            VARCHAR(25) not null,
   ucdmv             VARCHAR(25) not null,
   nmdpfo1           VARCHAR(6) not null,
   nmdpfo2           VARCHAR(6) not null,
   nmdppo1           VARCHAR(6) not null,
   nmdppo2           VARCHAR(6) not null,
   nmdph             VARCHAR(6) not null,
   nmdpzc            VARCHAR(6) not null,
   nmdpzr            VARCHAR(6) not null,
   nmdmv             VARCHAR(6) not null,
   ksdpfo1           VARCHAR(4) not null,
   ksdpfo2           VARCHAR(4) not null,
   ksdppo1           VARCHAR(4) not null,
   ksdppo2           VARCHAR(4) not null,
   ksdph             VARCHAR(4) not null,
   ksdpzc            VARCHAR(4) not null,
   ksdpzr            VARCHAR(4) not null,
   ksdmv             VARCHAR(4) not null,
   ssdpfo1           VARCHAR(10) not null,
   ssdpfo2           VARCHAR(10) not null,
   ssdppo1           VARCHAR(10) not null,
   ssdppo2           VARCHAR(10) not null,
   ssdph             VARCHAR(10) not null,
   ssdpzc            VARCHAR(10) not null,
   ssdpzr            VARCHAR(10) not null,
   ssdmv             VARCHAR(10) not null,
   kkx               DECIMAL(10,0) DEFAULT 0,
   icox              DECIMAL(10,0) DEFAULT 0
);
mzdkun;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_ufirdalsie'.$sqlt;
$vysledok = mysql_query("$sql");

$sql = 'INSERT INTO F'.$kli_vxcf.'_ufirdalsie (icox) VALUES (0) ';
$vysledok = mysql_query("$sql");

}
//koniec subor uctov danoveho uradu

//miesto podnikania
$sql = "SELECT prfax FROM F".$kli_vxcf."_ufirdalsie";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD pruli VARCHAR(35) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD prcdm VARCHAR(15) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD prpsc VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD prmes VARCHAR(35) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD prtel VARCHAR(20) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD prfax VARCHAR(20) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
}
//uzavierka k, datum od do bezne predchadzajuce obdobie
$sql = "SELECT tpuj FROM F".$kli_vxcf."_ufirdalsie";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD datbod DATE NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD datbdo DATE NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD datmod DATE NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD datmdo DATE NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD datk DATE NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD druz DECIMAL(2,0) DEFAULT 0 AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD tpuj VARCHAR(2) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
}
//fOsoba plni povinnosti SP
$sql = "SELECT fospmail FROM F".$kli_vxcf."_ufirdalsie";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD fospprie VARCHAR(35) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD fospmeno VARCHAR(35) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD fosptel VARCHAR(35) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD fospmail VARCHAR(45) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
}

//iban dane sp a odbory
$sql = "SELECT ibod FROM F".$kli_vxcf."_ufirdalsie";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdpfo1 VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdpfo2 VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdppo1 VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdppo2 VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdph VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdpzc VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdpzr VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdpdmv VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdpfo1 VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ucsp VARCHAR(25) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD nmsp VARCHAR(6) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD kssp VARCHAR(4) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD sssp VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD vssp VARCHAR(20) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibsp VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ucod VARCHAR(25) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD nmod VARCHAR(6) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ksod VARCHAR(4) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ssod VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD vsod VARCHAR(20) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibod VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
}
//FO danovnik
$sql = "SELECT dstat FROM F".$kli_vxcf."_ufirdalsie";
$vysledok = mysql_query($sql);
if (!$vysledok)
{

$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD dprie VARCHAR(30) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD dmeno VARCHAR(30) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD dtitl VARCHAR(20) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD dtitz VARCHAR(30) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD duli VARCHAR(30) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD dcdm VARCHAR(15) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD dpsc VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD dmes VARCHAR(30) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD dtel VARCHAR(30) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD dfax VARCHAR(30) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD dstat VARCHAR(30) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");


$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob ";
$fir_vysledok = mysql_query($sqlfir);
if($fir_vysledok)
    { 
$fir_riadok=mysql_fetch_object($fir_vysledok);

$dprie = $fir_riadok->dprie;
$dmeno = $fir_riadok->dmeno;
$dtitl = $fir_riadok->dtitl;
$dtitz = $fir_riadok->dtitz;
$duli = $fir_riadok->duli;
$dcdm = $fir_riadok->dcdm;
$dpsc = $fir_riadok->dpsc;
$dmes = $fir_riadok->dmes;
$dstat = $fir_riadok->xstat;
$dtel = $fir_riadok->dtel;

$upravttt = "UPDATE F$kli_vxcf"."_ufirdalsie SET ".
" dprie='$dprie', dmeno='$dmeno', dtitl='$dtitl', dtitz='$dtitz', duli='$duli', dcdm='$dcdm', dpsc='$dpsc', dmes='$dmes', dstat='$dstat', ".
" dtel='$dtel' ".
" WHERE dprie = '' ";
$upravene = mysql_query("$upravttt"); 

    }

}
//koniec FO danovnik
//Schvalil na pokladnicnych dokladoch
$sql = "SELECT schvvp FROM F".$kli_vxcf."_ufirdalsie";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD schval VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD schvpp DECIMAL(1,0) DEFAULT 0 AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD schvvp DECIMAL(1,0) DEFAULT 0 AFTER kkx";
$vysledek = mysql_query("$sql");
}
//kriziky zostavena a schvalena natvrdo
$sql = "SELECT kzos FROM F".$kli_vxcf."_ufirdalsie";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ksch DECIMAL(1,0) DEFAULT 0 AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD kzos DECIMAL(1,0) DEFAULT 0 AFTER kkx";
$vysledek = mysql_query("$sql");
}
//bic dane sp a odbory
$sql = "SELECT bicod FROM F".$kli_vxcf."_ufirdalsie";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdpfo1 VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdpfo2 VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdppo1 VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdppo2 VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdph VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdpzc VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdpzr VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdpdmv VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdpfo1 VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicsp VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicod VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
}
//koniec upravy

// cislo operacie
$copern = 1*$_REQUEST['copern'];
if( $copern == 1 ) { $copern=2; }

//zapis upravene udaje o firme
if ( $copern == 3 )
    {
$fir_fico = strip_tags($_REQUEST['fir_fico']);

$ucdppo1 = strip_tags($_REQUEST['ucdppo1']);
$nmdppo1 = strip_tags($_REQUEST['nmdppo1']);
$ucdppo2 = strip_tags($_REQUEST['ucdppo2']);
$nmdppo2 = strip_tags($_REQUEST['nmdppo2']);
$ucdph = strip_tags($_REQUEST['ucdph']);
$nmdph = strip_tags($_REQUEST['nmdph']);
$ucdpzc = strip_tags($_REQUEST['ucdpzc']);
$nmdpzc = strip_tags($_REQUEST['nmdpzc']);
$ucdpzr = strip_tags($_REQUEST['ucdpzr']);
$nmdpzr = strip_tags($_REQUEST['nmdpzr']);
$ucdmv = strip_tags($_REQUEST['ucdmv']);
$nmdmv = strip_tags($_REQUEST['nmdmv']);
$ucdpfo1 = strip_tags($_REQUEST['ucdpfo1']);
$nmdpfo1 = strip_tags($_REQUEST['nmdpfo1']);
$ucdpfo2 = strip_tags($_REQUEST['ucdpfo2']);
$nmdpfo2 = strip_tags($_REQUEST['nmdpfo2']);

$ksdppo1 = strip_tags($_REQUEST['ksdppo1']);
$ksdppo2 = strip_tags($_REQUEST['ksdppo2']);
$ksdph = strip_tags($_REQUEST['ksdph']);
$ksdpzc = strip_tags($_REQUEST['ksdpzc']);
$ksdpzr = strip_tags($_REQUEST['ksdpzr']);
$ksdmv = strip_tags($_REQUEST['ksdmv']);
$ksdpfo1 = strip_tags($_REQUEST['ksdpfo1']);
$ksdpfo2 = strip_tags($_REQUEST['ksdpfo2']);
$ssdppo1 = strip_tags($_REQUEST['ssdppo1']);
$ssdppo2 = strip_tags($_REQUEST['ssdppo2']);
$ssdph = strip_tags($_REQUEST['ssdph']);
$ssdpzc = strip_tags($_REQUEST['ssdpzc']);
$ssdpzr = strip_tags($_REQUEST['ssdpzr']);
$ssdmv = strip_tags($_REQUEST['ssdmv']);
$ssdpfo1 = strip_tags($_REQUEST['ssdpfo1']);
$ssdpfo2 = strip_tags($_REQUEST['ssdpfo2']);

$ibdpfo1 = strip_tags($_REQUEST['ibdpfo1']);
$ibdpfo2 = strip_tags($_REQUEST['ibdpfo2']);
$ibdppo1 = strip_tags($_REQUEST['ibdppo1']);
$ibdppo2 = strip_tags($_REQUEST['ibdppo2']);
$ibdph = strip_tags($_REQUEST['ibdph']);
$ibdpzc = strip_tags($_REQUEST['ibdpzc']);
$ibdpzr = strip_tags($_REQUEST['ibdpzr']);
$ibdpdmv = strip_tags($_REQUEST['ibdpdmv']);
$ibsp = strip_tags($_REQUEST['ibsp']);
$ibod = strip_tags($_REQUEST['ibod']);

$bicdpfo1 = strip_tags($_REQUEST['bicdpfo1']);
$bicdpfo2 = strip_tags($_REQUEST['bicdpfo2']);
$bicdppo1 = strip_tags($_REQUEST['bicdppo1']);
$bicdppo2 = strip_tags($_REQUEST['bicdppo2']);
$bicdph = strip_tags($_REQUEST['bicdph']);
$bicdpzc = strip_tags($_REQUEST['bicdpzc']);
$bicdpzr = strip_tags($_REQUEST['bicdpzr']);
$bicdpdmv = strip_tags($_REQUEST['bicdpdmv']);
$bicsp = strip_tags($_REQUEST['bicsp']);
$bicod = strip_tags($_REQUEST['bicod']);

$ucsp = strip_tags($_REQUEST['ucsp']);
$nmsp = strip_tags($_REQUEST['nmsp']);
$kssp = strip_tags($_REQUEST['kssp']);
$sssp = strip_tags($_REQUEST['sssp']);
$vssp = strip_tags($_REQUEST['vssp']);

$ucod = strip_tags($_REQUEST['ucod']);
$nmod = strip_tags($_REQUEST['nmod']);
$ksod = strip_tags($_REQUEST['ksod']);
$ssod = strip_tags($_REQUEST['ssod']);
$vsod = strip_tags($_REQUEST['vsod']);


$upravttt = "UPDATE F$kli_vxcf"."_ufirdalsie SET ".
" bicdpfo1='$bicdpfo1', bicdpfo2='$bicdpfo2', bicdppo1='$bicdppo1', bicdppo2='$bicdppo2', bicdph='$bicdph', bicdpzc='$bicdpzc', bicdpzr='$bicdpzr', ".
" bicsp='$bicsp', bicod='$bicod', bicdpdmv='$bicdpdmv', ".
" ibdpfo1='$ibdpfo1', ibdpfo2='$ibdpfo2', ibdppo1='$ibdppo1', ibdppo2='$ibdppo2', ibdph='$ibdph', ibdpzc='$ibdpzc', ibdpzr='$ibdpzr', ibsp='$ibsp', ibod='$ibod', ". 
" ibdpdmv='$ibdpdmv', ucsp='$ucsp', nmsp='$nmsp', kssp='$kssp', sssp='$sssp', vssp='$vssp', ".
" ucod='$ucod', nmod='$nmod', ksod='$ksod', ssod='$ssod', vsod='$vsod', ".
" ssdppo1='$ssdppo1', ssdppo2='$ssdppo2', ssdph='$ssdph', ssdpzc='$ssdpzc', ssdpzr='$ssdpzr', ssdmv='$kdmv', ssdpfo1='$ssdpfo1', ssdpfo2='$ssdpfo2', ".
" ksdppo1='$ksdppo1', ksdppo2='$ksdppo2', ksdph='$ksdph', ksdpzc='$ksdpzc', ksdpzr='$ksdpzr', ksdmv='$kdmv', ksdpfo1='$ksdpfo1', ksdpfo2='$ksdpfo2', ".
" ucdppo1='$ucdppo1', nmdppo1='$nmdppo1', ucdppo2='$ucdppo2', nmdppo2='$nmdppo2', ".
" ucdph='$ucdph', nmdph='$nmdph', ucdpzc='$ucdpzc', nmdpzc='$nmdpzc', ucdpzr='$ucdpzr', nmdpzr='$nmdpzr', ucdmv='$ucdmv', nmdmv='$nmdmv', ".
" ucdpfo1='$ucdpfo1', nmdpfo1='$nmdpfo1', ucdpfo2='$ucdpfo2', nmdpfo2='$nmdpfo2'  WHERE icox=0";  
//echo $upravttt;
$upravene = mysql_query("$upravttt"); 
$copern=2;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu uprav udaje o firme


//zapis upravene miesto podnikania
if ( $copern == 103 )
    {
$pruli = strip_tags($_REQUEST['pruli']);
$prcdm = strip_tags($_REQUEST['prcdm']);
$prpsc = strip_tags($_REQUEST['prpsc']);
$prmes = strip_tags($_REQUEST['prmes']);
$prtel = strip_tags($_REQUEST['prtel']);
$prfax = strip_tags($_REQUEST['prfax']);

$upravttt = "UPDATE F$kli_vxcf"."_ufirdalsie SET ".
" pruli='$pruli', prcdm='$prcdm', prpsc='$prpsc', prmes='$prmes', prtel='$prtel', prfax='$prfax'  WHERE icox=0 "; 
$upravene = mysql_query("$upravttt"); 
$copern=102;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu uprav miesto podnikania

//zapis upravene datumy uzavierky
if ( $copern == 203 )
    {
$datk = strip_tags($_REQUEST['datk']);
$druz = 1*$_REQUEST['druz'];
$tpuj = $_REQUEST['tpuj'];
$datbod = strip_tags($_REQUEST['datbod']);
$datbdo = strip_tags($_REQUEST['datbdo']);
$datmod = strip_tags($_REQUEST['datmod']);
$datmdo = strip_tags($_REQUEST['datmdo']);
$datksql = SqlDatum($datk);
$datbodsql = SqlDatum($datbod);
$datbdosql = SqlDatum($datbdo);
$datmodsql = SqlDatum($datmod);
$datmdosql = SqlDatum($datmdo);

$kzos = strip_tags($_REQUEST['kzos']);
$ksch = strip_tags($_REQUEST['ksch']);

$upravttt = "UPDATE F$kli_vxcf"."_ufirdalsie SET ".
" datk='$datksql', druz='$druz', tpuj='$tpuj', datbod='$datbodsql', datbdo='$datbdosql', datmod='$datmodsql', datmdo='$datmdosql', ".
" kzos='$kzos', ksch='$ksch' WHERE icox=0 "; 
$upravene = mysql_query("$upravttt"); 
$copern=202;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu uprav datumy uzavierky

//zapis upravene fosp aschvalil pokl
if ( $copern == 303 )
    {
$fospprie= strip_tags($_REQUEST['fospprie']);
$fospmeno= strip_tags($_REQUEST['fospmeno']);
$fosptel= strip_tags($_REQUEST['fosptel']);
$fospmail= strip_tags($_REQUEST['fospmail']);

$schval = strip_tags($_REQUEST['schval']);
$schvpp = strip_tags($_REQUEST['schvpp']);
$schvvp = strip_tags($_REQUEST['schvvp']);

$upravttt = "UPDATE F$kli_vxcf"."_ufirdalsie SET schval='$schval', schvpp='$schvpp', schvvp='$schvvp', ".
" fospprie='$fospprie', fospmeno='$fospmeno', fosptel='$fosptel', fospmail='$fospmail'  WHERE icox=0 "; 
$upravene = mysql_query("$upravttt"); 
$copern=302;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec fosp

//zapis upravene fo danovnik
if ( $copern == 403 )
    {
$dprie = strip_tags($_REQUEST['dprie']);
$dmeno = strip_tags($_REQUEST['dmeno']);
$dtitl = strip_tags($_REQUEST['dtitl']);
$dtitz = strip_tags($_REQUEST['dtitz']);
$duli = strip_tags($_REQUEST['duli']);
$dcdm = strip_tags($_REQUEST['dcdm']);
$dpsc = strip_tags($_REQUEST['dpsc']);
$dmes = strip_tags($_REQUEST['dmes']);
$dtel = strip_tags($_REQUEST['dtel']);
$dfax = strip_tags($_REQUEST['dfax']);
$dstat = strip_tags($_REQUEST['dstat']);

$upravttt = "UPDATE F$kli_vxcf"."_ufirdalsie SET ".
" dprie='$dprie', dmeno='$dmeno', dtitl='$dtitl', dtitz='$dtitz', duli='$duli', dcdm='$dcdm', dpsc='$dpsc', dmes='$dmes', dstat='$dstat', ".
" dtel='$dtel', dfax='$dfax' ".
" WHERE icox=0 ";
//echo $upravttt; 
$upravene = mysql_query("$upravttt"); 
$copern=402;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec fo danovnik


//nacitaj udaje
if ( $copern >= 1 )
    {

$sql = "SELECT * FROM F$kli_vxcf"."_ufirdalsie WHERE icox = 0";
$vysledok = mysql_query($sql);
$riadok=mysql_fetch_object($vysledok);

if( $copern == 2 ) {
$ucdppo1=$riadok->ucdppo1;
$nmdppo1=$riadok->nmdppo1;
$ucdppo2=$riadok->ucdppo2;
$nmdppo2=$riadok->nmdppo2;
$ucdph=$riadok->ucdph;
$nmdph=$riadok->nmdph;
$ucdpzc=$riadok->ucdpzc;
$nmdpzc=$riadok->nmdpzc;
$ucdpzr=$riadok->ucdpzr;
$nmdpzr=$riadok->nmdpzr;
$ucdmv=$riadok->ucdmv;
$nmdmv=$riadok->nmdmv;
$ucdpfo1=$riadok->ucdpfo1;
$nmdpfo1=$riadok->nmdpfo1;
$ucdpfo2=$riadok->ucdpfo2;
$nmdpfo2=$riadok->nmdpfo2;

$ksdppo1=$riadok->ksdppo1;
$ksdppo2=$riadok->ksdppo2;
$ksdph=$riadok->ksdph;
$ksdpzc=$riadok->ksdpzc;
$ksdpzr=$riadok->ksdpzr;
$ksdmv=$riadok->ksdmv;
$ksdpfo1=$riadok->ksdpfo1;
$ksdpfo2=$riadok->ksdpfo2;
$ssdppo1=$riadok->ssdppo1;
$ssdppo2=$riadok->ssdppo2;
$ssdph=$riadok->ssdph;
$ssdpzc=$riadok->ssdpzc;
$ssdpzr=$riadok->ssdpzr;
$ssdmv=$riadok->ssdmv;
$ssdpfo1=$riadok->ssdpfo1;
$ssdpfo2=$riadok->ssdpfo2;

$ibdpfo1=$riadok->ibdpfo1;
$ibdpfo2=$riadok->ibdpfo2;
$ibdppo1=$riadok->ibdppo1;
$ibdppo2=$riadok->ibdppo2;
$ibdph=$riadok->ibdph;
$ibdpzc=$riadok->ibdpzc;
$ibdpzr=$riadok->ibdpzr;
$ibdpdmv=$riadok->ibdpdmv;
$ibsp=$riadok->ibsp;
$ibod=$riadok->ibod;

$bicdpfo1=$riadok->bicdpfo1;
$bicdpfo2=$riadok->bicdpfo2;
$bicdppo1=$riadok->bicdppo1;
$bicdppo2=$riadok->bicdppo2;
$bicdph=$riadok->bicdph;
$bicdpzc=$riadok->bicdpzc;
$bicdpzr=$riadok->bicdpzr;
$bicdpdmv=$riadok->bicdpdmv;
$bicsp=$riadok->bicsp;
$bicod=$riadok->bicod;

$ucsp=$riadok->ucsp;
$nmsp=$riadok->nmsp;
$kssp=$riadok->kssp;
$sssp=$riadok->sssp;
$vssp=$riadok->vssp;

$ucod=$riadok->ucod;
$nmod=$riadok->nmod;
$ksod=$riadok->ksod;
$ssod=$riadok->ssod;
$vsod=$riadok->vsod;

                   }

if( $copern == 102 ) {
$pruli = $riadok->pruli;
$prcdm = $riadok->prcdm;
$prpsc = $riadok->prpsc;
$prmes = $riadok->prmes;
$prtel = $riadok->prtel;
$prfax = $riadok->prfax;
                     }

if( $copern == 202 ) {
$datksk = SkDatum($riadok->datk);
$datbodsk = SkDatum($riadok->datbod);
$datbdosk = SkDatum($riadok->datbdo);
$datmodsk = SkDatum($riadok->datmod);
$datmdosk = SkDatum($riadok->datmdo);
$druz = $riadok->druz;
$tpuj = $riadok->tpuj;
$kzos = 1*$riadok->kzos;
$ksch = 1*$riadok->ksch;
                     }

if( $copern == 302 ) {
$fospprie = $riadok->fospprie;
$fospmeno = $riadok->fospmeno;
$fosptel = $riadok->fosptel;
$fospmail = $riadok->fospmail;
$schval = $riadok->schval;
$schvpp = $riadok->schvpp;
$schvvp = $riadok->schvvp;
                     }

if( $copern == 402 ) {
$dprie = $riadok->dprie;
$dmeno = $riadok->dmeno;
$dtitl = $riadok->dtitl;
$dtitz = $riadok->dtitz;
$duli = $riadok->duli;
$dcdm = $riadok->dcdm;
$dpsc = $riadok->dpsc;
$dmes = $riadok->dmes;
$dstat = $riadok->dstat;
$dtel = $riadok->dtel;
$dfax = $riadok->dfax;
                     }


    }
//koniec nacitania



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>⁄daje o firme</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
<?php
//uprava udaje o firme
  if ( $copern == 2 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.ucdppo1.value = '<?php echo "$ucdppo1";?>';
    document.formv1.nmdppo1.value = '<?php echo "$nmdppo1";?>';
    document.formv1.ucdppo2.value = '<?php echo "$ucdppo2";?>';
    document.formv1.nmdppo2.value = '<?php echo "$nmdppo2";?>';
    document.formv1.ucdph.value = '<?php echo "$ucdph";?>';
    document.formv1.nmdph.value = '<?php echo "$nmdph";?>';
    document.formv1.ucdpzc.value = '<?php echo "$ucdpzc";?>';
    document.formv1.nmdpzc.value = '<?php echo "$nmdpzc";?>';
    document.formv1.ucdpzr.value = '<?php echo "$ucdpzr";?>';
    document.formv1.nmdpzr.value = '<?php echo "$nmdpzr";?>';
    document.formv1.ucdmv.value = '<?php echo "$ucdmv";?>';
    document.formv1.nmdmv.value = '<?php echo "$nmdmv";?>';
    document.formv1.ucdpfo1.value = '<?php echo "$ucdpfo1";?>';
    document.formv1.nmdpfo1.value = '<?php echo "$nmdpfo1";?>';
    document.formv1.ucdpfo2.value = '<?php echo "$ucdpfo2";?>';
    document.formv1.nmdpfo2.value = '<?php echo "$nmdpfo2";?>';


    document.formv1.ksdppo1.value = '<?php echo "$ksdppo1";?>';
    document.formv1.ksdppo2.value = '<?php echo "$ksdppo2";?>';
    document.formv1.ksdph.value = '<?php echo "$ksdph";?>';
    document.formv1.ksdpzc.value = '<?php echo "$ksdpzc";?>';
    document.formv1.ksdpzr.value = '<?php echo "$ksdpzr";?>';
    document.formv1.ksdmv.value = '<?php echo "$ksdmv";?>';
    document.formv1.ksdpfo1.value = '<?php echo "$ksdpfo1";?>';
    document.formv1.ksdpfo2.value = '<?php echo "$ksdpfo2";?>';
    document.formv1.ssdppo1.value = '<?php echo "$ssdppo1";?>';
    document.formv1.ssdppo2.value = '<?php echo "$ssdppo2";?>';
    document.formv1.ssdph.value = '<?php echo "$ssdph";?>';
    document.formv1.ssdpzc.value = '<?php echo "$ssdpzc";?>';
    document.formv1.ssdpzr.value = '<?php echo "$ssdpzr";?>';
    document.formv1.ssdmv.value = '<?php echo "$ssdmv";?>';
    document.formv1.ssdpfo1.value = '<?php echo "$ssdpfo1";?>';
    document.formv1.ssdpfo2.value = '<?php echo "$ssdpfo2";?>';

    document.formv1.ibdpfo1.value = '<?php echo "$ibdpfo1";?>';
    document.formv1.ibdpfo2.value = '<?php echo "$ibdpfo2";?>';
    document.formv1.ibdppo1.value = '<?php echo "$ibdppo1";?>';
    document.formv1.ibdppo2.value = '<?php echo "$ibdppo2";?>';
    document.formv1.ibdph.value = '<?php echo "$ibdph";?>';
    document.formv1.ibdpzc.value = '<?php echo "$ibdpzc";?>';
    document.formv1.ibdpzr.value = '<?php echo "$ibdpzr";?>';
    document.formv1.ibdpdmv.value = '<?php echo "$ibdpdmv";?>';
    document.formv1.ibsp.value = '<?php echo "$ibsp";?>';
    document.formv1.ibod.value = '<?php echo "$ibod";?>';

    document.formv1.bicdpfo1.value = '<?php echo "$bicdpfo1";?>';
    document.formv1.bicdpfo2.value = '<?php echo "$bicdpfo2";?>';
    document.formv1.bicdppo1.value = '<?php echo "$bicdppo1";?>';
    document.formv1.bicdppo2.value = '<?php echo "$bicdppo2";?>';
    document.formv1.bicdph.value = '<?php echo "$bicdph";?>';
    document.formv1.bicdpzc.value = '<?php echo "$bicdpzc";?>';
    document.formv1.bicdpzr.value = '<?php echo "$bicdpzr";?>';
    document.formv1.bicdpdmv.value = '<?php echo "$bicdpdmv";?>';
    document.formv1.bicsp.value = '<?php echo "$bicsp";?>';
    document.formv1.bicod.value = '<?php echo "$bicod";?>';

    document.formv1.ucsp.value = '<?php echo "$ucsp";?>';
    document.formv1.nmsp.value = '<?php echo "$nmsp";?>';
    document.formv1.kssp.value = '<?php echo "$kssp";?>';
    document.formv1.sssp.value = '<?php echo "$sssp";?>';
    document.formv1.vssp.value = '<?php echo "$vssp";?>';

    document.formv1.ucod.value = '<?php echo "$ucod";?>';
    document.formv1.nmod.value = '<?php echo "$nmod";?>';
    document.formv1.ksod.value = '<?php echo "$ksod";?>';
    document.formv1.ssod.value = '<?php echo "$ssod";?>';
    document.formv1.vsod.value = '<?php echo "$vsod";?>';

    }
<?php
//koniec uprava
  }
?>

<?php
//uprava miesto podnikania
  if ( $copern == 102 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.pruli.value = '<?php echo "$pruli";?>';
    document.formv1.prcdm.value = '<?php echo "$prcdm";?>';
    document.formv1.prpsc.value = '<?php echo "$prpsc";?>';
    document.formv1.prmes.value = '<?php echo "$prmes";?>';
    document.formv1.prtel.value = '<?php echo "$prtel";?>';
    document.formv1.prfax.value = '<?php echo "$prfax";?>';
    }
<?php
//koniec uprava
  }
?>

<?php
  if ( $copern == 202 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.datk.value = '<?php echo "$datksk";?>';
    document.formv1.druz.value = '<?php echo "$druz";?>';
    document.formv1.tpuj.value = '<?php echo "$tpuj";?>';
    document.formv1.datbod.value = '<?php echo "$datbodsk";?>';
    document.formv1.datbdo.value = '<?php echo "$datbdosk";?>';
    document.formv1.datmod.value = '<?php echo "$datmodsk";?>';
    document.formv1.datmdo.value = '<?php echo "$datmdosk";?>';
<?php if ( $ksch == 1 ) { ?> document.formv1.ksch.checked = 'true'; <?php } ?>
<?php if ( $kzos == 1 ) { ?> document.formv1.kzos.checked = 'true'; <?php } ?>
    }
<?php
//koniec uprava
  }
?>

<?php
  if ( $copern == 302 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.fospprie.value = '<?php echo "$fospprie";?>';
    document.formv1.fospmeno.value = '<?php echo "$fospmeno";?>';
    document.formv1.fosptel.value = '<?php echo "$fosptel";?>';
    document.formv1.fospmail.value = '<?php echo "$fospmail";?>';
    document.formv1.schval.value = '<?php echo "$schval";?>';
<?php if ( $schvpp == 1 ) { ?> document.formv1.schvpp.checked = "checked"; <?php } ?>
<?php if ( $schvvp == 1 ) { ?> document.formv1.schvvp.checked = "checked"; <?php } ?>
    }
<?php
//koniec uprava
  }
?>

<?php
  if ( $copern == 402 )
  { 
?>
    function ObnovUI()
    {
   document.formv1.dprie.value = '<?php echo "$dprie";?>';
   document.formv1.dmeno.value = '<?php echo "$dmeno";?>';
   document.formv1.dtitl.value = '<?php echo "$dtitl";?>';
   document.formv1.dtitz.value = '<?php echo "$dtitz";?>';
   document.formv1.duli.value = '<?php echo "$duli";?>';
   document.formv1.dcdm.value = '<?php echo "$dcdm";?>';
   document.formv1.dpsc.value = '<?php echo "$dpsc";?>';
   document.formv1.dmes.value = '<?php echo "$dmes";?>';
   document.formv1.dstat.value = '<?php echo "$dstat";?>';
   document.formv1.dtel.value = '<?php echo "$dtel";?>';
   document.formv1.dfax.value = '<?php echo "$dfax";?>';
    }
<?php
//koniec uprava
  }
?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1 ) { Vstup.value=Vstup.value.replace(",","."); }
  }

    function danoveUcty()
    {
window.open('../cis/ufirdalsie.php?copern=1&drupoh=1&page=1','_self' )
    }
    function mpodnikania()
    {
window.open('../cis/ufirdalsie.php?copern=102&drupoh=1&page=1','_self' )
    }
    function datumy()
    {
window.open('../cis/ufirdalsie.php?copern=202&drupoh=1&page=1','_self' )
    }
    function fosp()
    {
window.open('../cis/ufirdalsie.php?copern=302&drupoh=1&page=1','_self' )
    }
    function fotrv()
    {
window.open('../cis/ufirdalsie.php?copern=402&drupoh=1&page=1','_self' )
    }

</script>
</HEAD>
<BODY class="white" onload="ObnovUI();">

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  œalöie ˙daje o firme</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<a href="#" onClick="danoveUcty();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Nastavenie ˙Ëtov pre ˙hradu danÌ, SP a odborov" >bank.˙Ëty D⁄,SP...</a>

<a href="#" onClick="mpodnikania();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Nastavenie miesta podnikania" >Miesto Podnikania</a>

<a href="#" onClick="datumy();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Nastavenie d·tumov uz·vierky" >D·tumy na uz·vierke</a>

<a href="#" onClick="fosp();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Nastavenie Fosoby SP" >Fosoba SP</a>

<a href="#" onClick="fotrv();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Nastavenie FO daÚovnÌk" >FO daÚovnÌk</a>

<?php
//upravy  udaje o firme
if ( $copern == 2 )
    {
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufirdalsie.php?copern=3" >
<tr>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
</tr>

<tr><td class="bmenu" colspan="10">»Ìsla ˙Ëtov pre ˙hradu najpouûÌvanejöÌch danÌ, SP a odborov ( tvar 500208-8028547880 / 8180 ) </tr>
<tr><td class="bmenu" colspan="10"></tr>


<tr>
<td class="bmenu" colspan="3">»Ìslo ˙Ëtu pre DaÚ z prÌjmov FO ( trval˝ pobyt tuzemsko )</td>
<td class="fmenu" colspan="7"><input type="text" name="ucdpfo1" id="ucdpfo1" size="15"/> / <input type="text" name="nmdpfo1" id="nmdpfo1" size="4"/>
 IBAN <input type="text" name="ibdpfo1" id="ibdpfo1" size="28"/> BIC <input type="text" name="bicdpfo1" id="bicdpfo1" size="10"/>
 KSY <input type="text" name="ksdpfo1" id="ksdpfo1" size="4"/> SSY <input type="text" name="ssdpfo1" id="ssdpfo1" size="10"/></td>
</tr>
<tr>
<td class="bmenu" colspan="3">»Ìslo ˙Ëtu pre DaÚ z prÌjmov FO ( nerezident )</td>
<td class="fmenu" colspan="7"><input type="text" name="ucdpfo2" id="ucdpfo2" size="15"/> / <input type="text" name="nmdpfo2" id="nmdpfo2" size="4"/>
 IBAN <input type="text" name="ibdpfo2" id="ibdpfo2" size="28"/> BIC <input type="text" name="bicdpfo2" id="bicdpfo2" size="10"/> 
 KSY <input type="text" name="ksdpfo2" id="ksdpfo2" size="4"/> SSY <input type="text" name="ssdpfo2" id="ssdpfo2" size="10"/></td>
</tr>

<tr>
<td class="bmenu" colspan="3">»Ìslo ˙Ëtu pre DaÚ z prÌjmov PO ( so sÌdlom v tuzemsku )</td>
<td class="fmenu" colspan="7"><input type="text" name="ucdppo1" id="ucdppo1" size="15"/> / <input type="text" name="nmdppo1" id="nmdppo1" size="4"/>
 IBAN <input type="text" name="ibdppo1" id="ibdppo1" size="28"/> BIC <input type="text" name="bicdppo1" id="bicdppo1" size="10"/> 
 KSY <input type="text" name="ksdppo1" id="ksdppo1" size="4"/> SSY <input type="text" name="ssdppo1" id="ssdppo1" size="10"/></td>
</tr>
<tr>
<td class="bmenu" colspan="3">»Ìslo ˙Ëtu pre DaÚ z prÌjmov PO ( so sÌdlom v zahraniËÌ )</td>
<td class="fmenu" colspan="7"><input type="text" name="ucdppo2" id="ucdppo2" size="15"/> / <input type="text" name="nmdppo2" id="nmdppo2" size="4"/>
 IBAN <input type="text" name="ibdppo2" id="ibdppo2" size="28"/> BIC <input type="text" name="bicdppo2" id="bicdppo2" size="10"/> 
 KSY <input type="text" name="ksdppo2" id="ksdppo2" size="4"/> SSY <input type="text" name="ssdppo2" id="ssdppo2" size="10"/></td>
</tr>
<tr>
<td class="bmenu" colspan="3">»Ìslo ˙Ëtu pre DaÚ z pridanej hodnoty</td>
<td class="fmenu" colspan="7"><input type="text" name="ucdph" id="ucdph" size="15"/> / <input type="text" name="nmdph" id="nmdph" size="4"/>
 IBAN <input type="text" name="ibdph" id="ibdph" size="28"/> BIC <input type="text" name="bicdph" id="bicdph" size="10"/> 
 KSY <input type="text" name="ksdph" id="ksdph" size="4"/> SSY <input type="text" name="ssdph" id="ssdph" size="10"/></td>
</tr>
<tr>
<td class="bmenu" colspan="3">»Ìslo ˙Ëtu pre DaÚ z prÌjmov zo z·vislej Ëinnosti</td>
<td class="fmenu" colspan="7"><input type="text" name="ucdpzc" id="ucdpzc" size="15"/> / <input type="text" name="nmdpzc" id="nmdpzc" size="4"/>
 IBAN <input type="text" name="ibdpzc" id="ibdpzc" size="28"/> BIC <input type="text" name="bicdpzc" id="bicdpzc" size="10"/> 
 KSY <input type="text" name="ksdpzc" id="ksdpzc" size="4"/> SSY <input type="text" name="ssdpzc" id="ssdpzc" size="10"/></td>
</tr>
<tr>
<td class="bmenu" colspan="3">»Ìslo ˙Ëtu pre DaÚ z prÌjmov vyberan· zr·ûkou</td>
<td class="fmenu" colspan="7"><input type="text" name="ucdpzr" id="ucdpzr" size="15"/> / <input type="text" name="nmdpzr" id="nmdpzr" size="4"/>
 IBAN <input type="text" name="ibdpzr" id="ibdpzr" size="28"/> BIC <input type="text" name="bicdpzr" id="bicdpzr" size="10"/> 
 KSY <input type="text" name="ksdpzr" id="ksdpzr" size="4"/> SSY <input type="text" name="ssdpzr" id="ssdpzr" size="10"/></td>
</tr>
<tr>
<td class="bmenu" colspan="3">»Ìslo ˙Ëtu pre DaÚ z motorov˝ch vozidiel</td>
<td class="fmenu" colspan="7"><input type="text" name="ucdmv" id="ucdmv" size="15"/> / <input type="text" name="nmdmv" id="nmdmv" size="4"/>
 IBAN <input type="text" name="ibdpdmv" id="ibdpdmv" size="28"/> BIC <input type="text" name="bicdpdmv" id="bicdpdmv" size="10"/> 
 KSY <input type="text" name="ksdmv" id="ksdmv" size="4"/> SSY <input type="text" name="ssdmv" id="ssdmv" size="10"/></td>
</tr>
<tr>
<tr></tr>
<td class="bmenu" colspan="3">»Ìslo ˙Ëtu pre Soci·lnu poisùovÚu</td>
<td class="fmenu" colspan="7"><input type="text" name="ucsp" id="ucsp" size="15"/> / <input type="text" name="nmsp" id="nmsp" size="4"/>
 IBAN <input type="text" name="ibsp" id="ibsp" size="28"/> BIC <input type="text" name="bicsp" id="bicsp" size="10"/> 
 KSY <input type="text" name="kssp" id="kssp" size="4"/> SSY <input type="text" name="sssp" id="sssp" size="10"/>
 VSY <input type="text" name="vssp" id="vssp" size="10"/></td>
</tr>
<tr>
<td class="bmenu" colspan="3">»Ìslo ˙Ëtu pre prÌspevky do odborov</td>
<td class="fmenu" colspan="7"><input type="text" name="ucod" id="ucod" size="15"/> / <input type="text" name="nmod" id="nmod" size="4"/>
 IBAN <input type="text" name="ibod" id="ibod" size="28"/> BIC <input type="text" name="bicod" id="bicod" size="10"/> 
 KSY <input type="text" name="ksod" id="ksod" size="4"/> SSY <input type="text" name="ssod" id="ssod" size="10"/>
 VSY <input type="text" name="vsod" id="vsod" size="10"/></td>
</tr>
<tr><td class="bmenu" colspan="10"></tr>

<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù ˙pravy"></td>
</tr>
</FORM>

</table>
<?php
    }
//koniec uprav  udaje o firme
?>


<?php
//upravy  udaje o firme
if ( $copern == 102 )
    {
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufirdalsie.php?copern=103" >
<tr>
<td class="pvstuz" colspan="10">Miesto podnikania (ak sa lÌöi od miesta trvalÈho pobytu) - ! <i>VypÂÚaù iba pri V˝kaze o prÌjmoch a v˝davkoch a pri V˝kaze o majetku a z·v‰zkov</i>&nbsp;!</td>
</tr>
<tr>
<td class="bmenu" colspan="1">Ulica:</td>
<td class="bmenu" colspan="1"><input type="text" name="pruli" id="pruli" size="30" /></td>
<td class="bmenu" colspan="1">»Ìslo:</td>
<td class="bmenu" colspan="1"><input type="text" name="prcdm" id="prcdm" size="10" /></td>
</tr>
<tr>
<td class="bmenu" colspan="1">PS»:</td>
<td class="bmenu" colspan="1"><input type="text" name="prpsc" id="prpsc" size="10" /></td>
<td class="bmenu" colspan="1">Obec:</td>
<td class="bmenu" colspan="1"><input type="text" name="prmes" id="prmes" size="30" /></td>
</tr>
<tr>
<td class="bmenu" colspan="1">TelefÛn:</td>
<td class="bmenu" colspan="1"><input type="text" name="prtel" id="prtel" size="30" /></td>
<td class="bmenu" colspan="1">Fax:</td>
<td class="bmenu" colspan="1"><input type="text" name="prfax" id="prfax" size="30" /></td>
</tr>
<tr><td class="bmenu" colspan="10"></tr>

<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù ˙pravy"></td>
</tr>
</FORM>

</table>
<?php
    }
//koniec uprav miesto podnikania
?>

<?php
//upravy datumy uzav
if ( $copern == 202 )
    {
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufirdalsie.php?copern=203" >
<tr>
<td class="pvstuz" colspan="10">D·tumy na uz·vierkach&nbsp;</td>
</tr>
<tr>
<td class="bmenu" colspan="5">Uz·vierka k d·tumu:</td>
<td class="bmenu" colspan="5"><input type="text" name="datk" id="datk" onkeyup="CiarkaNaBodku(this);" size="12" /></td>
</tr>
<tr>
<td class="bmenu" colspan="5">Druh uz·vierky ( nastavenie v S˙vahe, V˝kaze ziskov a Pozn·mkach ):</td>
<td class="bmenu" colspan="5">
<select size="1" name="druz" id="druz" >
<option value="0" >riadna</option>
<option value="1" >mimoriadna</option>
</select></td>
</tr>
<tr>
<td class="bmenu" colspan="5">Druh ˙Ëtovnej jednotky ( nastavenie v Uz·vierke ):</td>
<td class="bmenu" colspan="5">
<select size="1" name="tpuj" id="tpuj" >
<option value=" " >nenastavenÈ</option>
<option value="1" >POD mal·</option>
<option value="2" >POD velk·</option>
<option value="3" >MUJ mikro</option>
</select></td>
</tr>
<tr>
<td class="bmenu" colspan="5">BeûnÈ ˙ËtovnÈ obdobie od d·tumu:</td>
<td class="bmenu" colspan="5"><input type="text" name="datbod" id="datbod" onkeyup="CiarkaNaBodku(this);" size="12" /></td>
</tr>
<tr>
<td class="bmenu" colspan="5">BeûnÈ ˙ËtovnÈ obdobie do d·tumu:</td>
<td class="bmenu" colspan="5"><input type="text" name="datbdo" id="datbdo" onkeyup="CiarkaNaBodku(this);" size="12" /></td>
</tr>
<tr>
<td class="bmenu" colspan="5">Bezprostredne predch·dzaj˙ce ˙ËtovnÈ obdobie od d·tumu:</td>
<td class="bmenu" colspan="5"><input type="text" name="datmod" id="datmod" onkeyup="CiarkaNaBodku(this);" size="12" /></td>
</tr>
<tr>
<td class="bmenu" colspan="5">Bezprostredne predch·dzaj˙ce ˙ËtovnÈ obdobie do d·tumu:</td>
<td class="bmenu" colspan="5"><input type="text" name="datmdo" id="datmdo" onkeyup="CiarkaNaBodku(this);" size="12" /></td>
</tr>
<tr>
<td class="bmenu" colspan="5">KrÌûik zostaven· ( ⁄Ëtovn· z·vierka NUJ 2014 ):</td>
<td class="bmenu" colspan="5"><input type="checkbox" name="kzos" value="1" /></td>
</tr>
<tr>
<td class="bmenu" colspan="5">KrÌûik schv·len· ( ⁄Ëtovn· z·vierka NUJ 2014 ):</td>
<td class="bmenu" colspan="5"><input type="checkbox" name="ksch" value="1" /></td>
</tr>
<tr><td class="bmenu" colspan="10"></tr>

<tr>
<td></td>
<td class="bmenu"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù ˙pravy"></td>
</tr>
</FORM>

</table>
<?php
    }
//koniec datumy uzav
?>

<?php
//upravy fosp
if ( $copern == 302 )
    {
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufirdalsie.php?copern=303" >
<tr>
<td class="pvstuz" colspan="10">FO, ktor· plnÌ povinnosti voËi SP (mzdov· uËt·reÚ).&nbsp;</td>
</tr>
<tr>
<td class="bmenu" colspan="1">Priezvisko:</td>
<td class="bmenu" colspan="1"><input type="text" name="fospprie" id="fospprie" size="35" /></td>
</tr>
<tr>
<td class="bmenu" colspan="1">Meno:</td>
<td class="bmenu" colspan="1"><input type="text" name="fospmeno" id="fospmeno" size="35" /></td>
</tr>
<tr>
<td class="bmenu" colspan="1">TelefÛn:</td>
<td class="bmenu" colspan="1"><input type="text" name="fosptel" id="fosptel" size="35" /></td>
</tr>
<tr>
<td class="bmenu" colspan="1">Mail:</td>
<td class="bmenu" colspan="1"><input type="text" name="fospmail" id="fospmail" size="35" /></td>
</tr>
<tr><td class="bmenu" colspan="10"></tr>
<tr>
<td class="pvstuz" colspan="10">Schv·lil: ( na pokladniËn˝ch dokladoch ).&nbsp;</td>
</tr>
<tr>
<td class="bmenu" colspan="1">Schv·lil:</td>
<td class="bmenu" colspan="1"><input type="text" name="schval" id="schval" size="50" /></td>
</tr>
<tr>
<td class="bmenu" colspan="2"><input type="checkbox" name="schvpp" value="1" /> TlaËiù na prÌjmov˝ch pokladniËn˝ch dokladoch</td>
</tr>
<tr>
<td class="bmenu" colspan="2"><input type="checkbox" name="schvvp" value="1" /> TlaËiù na v˝davkov˝ch pokladniËn˝ch dokladoch</td>
</tr>
<tr><td class="bmenu" colspan="10"></tr>
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù ˙pravy"></td>
</tr>
</FORM>

</table>
<?php
    }
//koniec fosp
?>

<?php
//upravy fo meno,trvale
if ( $copern == 402 )
    {
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufirdalsie.php?copern=403" >

<tr><td colspan="10" height="4px"></td></tr>
<tr><td class="pvstuz" colspan="10">⁄DAJE O DA“OVNÕKOVI FO</td></tr>
<tr>
<td class="bmenu" colspan="1">Priezvisko:</td>
<td class="bmenu" colspan="1"><input type="text" name="dprie" id="dprie" size="30" /></td>
<td class="bmenu" colspan="1">Meno:</td>
<td class="bmenu" colspan="1"><input type="text" name="dmeno" id="dmeno" size="30" /></td>
<td class="bmenu" colspan="1">Titul pred:</td>
<td class="bmenu" colspan="1"><input type="text" name="dtitl" id="dtitl" size="10" /></td>
<td class="bmenu" colspan="1">Titul za:</td>
<td class="bmenu" colspan="1"><input type="text" name="dtitz" id="dtitz" size="10" /></td>
</tr>
<tr><td colspan="10" height="4px"></td></tr>
<tr><td class="pvstuz" colspan="10">Adresa trvalÈho pobytu</td></tr>
<tr>
<td class="bmenu" colspan="1">Ulica:</td>
<td class="bmenu" colspan="1"><input type="text" name="duli" id="duli" size="30" /></td>
<td class="bmenu" colspan="1">»Ìslo:</td>
<td class="bmenu" colspan="1"><input type="text" name="dcdm" id="dcdm" size="10" /></td>
</tr>
<tr>
<td class="bmenu" colspan="1">PS»:</td>
<td class="bmenu" colspan="1"><input type="text" name="dpsc" id="dpsc" size="10" /></td>
<td class="bmenu" colspan="1">Obec:</td>
<td class="bmenu" colspan="1"><input type="text" name="dmes" id="dmes" size="30" /></td>
<td class="bmenu" colspan="1">ät·t:</td>
<td class="bmenu" colspan="1"><input type="text" name="dstat" id="dstat" size="20" /></td>
</tr>
<tr>
<td class="bmenu" colspan="1">TelefÛn:</td>
<td class="bmenu" colspan="1"><input type="text" name="dtel" id="dtel" size="30" /></td>
<td class="bmenu" colspan="1">Fax:</td>
<td class="bmenu" colspan="1"><input type="text" name="dfax" id="dfax" size="30" /></td>
</tr>

<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù ˙pravy"></td>
</tr>
</FORM>

</table>
<?php
    }
//koniec fo meno,trvale
?>


<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
