<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
$urov = 3000;
if( $_SERVER['SERVER_NAME'] == "www.medosro.sk" ) { $urov=5000; }
$cslm=101901;
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

$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;

$sql = "ALTER TABLE F$kli_vxcf"."_ufir MODIFY obreg VARCHAR(50) ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir MODIFY uctt05 VARCHAR(40) ";
$vysledek = mysql_query("$sql");

//nove polozky parametrov
$sql = "SELECT uctx15 FROM F$vyb_xcf"."_ufir";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx11 DECIMAL(8,0) AFTER uctx10";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx12 DECIMAL(8,0) AFTER uctx10";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx13 DECIMAL(8,0) AFTER uctx10";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx14 DECIMAL(8,0) AFTER uctx10";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx15 DECIMAL(8,0) AFTER uctx10";
$vysledek = mysql_query("$sql");

}
//nove polozky parametrov


//nove polozky parametrov
$sql = "SELECT allx15 FROM F$vyb_xcf"."_ufir";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD allx11 DECIMAL(8,0) AFTER uctx15";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD allx12 DECIMAL(8,0) AFTER uctx15";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD allx13 DECIMAL(8,0) AFTER uctx15";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD allx14 DECIMAL(8,0) AFTER uctx15";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD allx15 DECIMAL(8,0) AFTER uctx15";
$vysledek = mysql_query("$sql");

}
//nove polozky parametrov

//nove polozky parametrov
$sql = "SELECT xsk05 FROM F$vyb_xcf"."_ufir";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xsk09 DECIMAL(8,0) AFTER uctx15";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xsk08 DECIMAL(8,0) AFTER uctx15";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xsk07 DECIMAL(8,0) AFTER uctx15";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xsk06 DECIMAL(8,0) AFTER uctx15";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xsk05 DECIMAL(8,0) AFTER uctx15";
$vysledek = mysql_query("$sql");

}
//nove polozky parametrov


//nove polozky parametrov
$sql = "SELECT xvr05 FROM F$vyb_xcf"."_ufir";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xvr01 DECIMAL(8,0) AFTER uctx15";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xvr02 DECIMAL(8,0) AFTER uctx15";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xvr03 DECIMAL(8,0) AFTER uctx15";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xvr04 DECIMAL(8,0) AFTER uctx15";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xvr05 DECIMAL(8,0) AFTER uctx15";
$vysledek = mysql_query("$sql");

}
//nove polozky parametrov

//nove polozky parametrov
$sql = "SELECT fsw1 FROM F$vyb_xcf"."_ufir";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD fsw3 VARCHAR(15) NOT NULL AFTER fib3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD fsw2 VARCHAR(15) NOT NULL AFTER fib2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD fsw1 VARCHAR(15) NOT NULL AFTER fib1";
$vysledek = mysql_query("$sql");

}
//nove polozky parametrov

//subor uctov danoveho uradu
$sql = "SELECT ucdpfo1 FROM F$kli_vxcf"."_ufirdalsie";
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
   icox              DECIMAL(10,0) DEFAULT 0
);
mzdkun;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_ufirdalsie'.$sqlt;
$vysledok = mysql_query("$sql");

$sql = 'INSERT INTO F'.$kli_vxcf.'_ufirdalsie (icox) VALUES (0) ';
$vysledok = mysql_query("$sql");

}
//koniec subor uctov danoveho uradu

$sql = "SELECT fstat FROM F".$kli_vxcf."_ufirdalsie";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD fstat VARCHAR(30) DEFAULT 'SR' AFTER kkx";
$vysledek = mysql_query("$sql");
}

// cislo operacie
$copern = 1*$_REQUEST['copern'];

//dovol rusit ostre spracovanie miezd aj dozadu
if ( $copern == 10191 )
    {
 $sqlt = "DROP TABLE F$kli_vxcf"."_mzddovolrusit "; 
 $vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdkun
(
   oc           INT(7)
);
mzdkun;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_mzddovolrusit'.$sqlt;
$vysledok = mysql_query("$sql");

$copern=191;
    }
//koniec dovol rusit ostre spracovanie miezd aj dozadu


//zapis upravene udaje o firme
if ( $copern == 3 )
    {
$fir_fico = strip_tags($_REQUEST['fir_fico']);
$fir_fdic = trim($_REQUEST['fir_fdic']);
$fir_ficd = trim($_REQUEST['fir_ficd']);
$fir_fnaz = strip_tags($_REQUEST['fir_fnaz']);
$fir_fuli = strip_tags($_REQUEST['fir_fuli']);
$fir_fcdm = strip_tags($_REQUEST['fir_fcdm']);
$fir_fmes = strip_tags($_REQUEST['fir_fmes']);
$fir_fstat = strip_tags($_REQUEST['fir_fstat']);
$fir_fpsc = strip_tags($_REQUEST['fir_fpsc']);
$fir_ftel = strip_tags($_REQUEST['fir_ftel']);
$fir_ffax = strip_tags($_REQUEST['fir_ffax']);
$fir_fwww = strip_tags($_REQUEST['fir_fwww']);
$fir_fem1 = strip_tags($_REQUEST['fir_fem1']);
$fir_fem2 = strip_tags($_REQUEST['fir_fem2']);
$fir_fem3 = strip_tags($_REQUEST['fir_fem3']);
$fir_fuc1 = strip_tags($_REQUEST['fir_fuc1']);
$fir_uc1fk = strip_tags($_REQUEST['fir_uc1fk']);
$fir_uc2fk = strip_tags($_REQUEST['fir_uc2fk']);
$fir_uc3fk = strip_tags($_REQUEST['fir_uc3fk']);
$fir_fib1 = strip_tags($_REQUEST['fir_fib1']);
$fir_fnm1 = strip_tags($_REQUEST['fir_fnm1']);
$fir_fnb1 = strip_tags($_REQUEST['fir_fnb1']);
$fir_fsb1 = strip_tags($_REQUEST['fir_fsb1']);
$fir_fuc2 = strip_tags($_REQUEST['fir_fuc2']);
$fir_fib2 = strip_tags($_REQUEST['fir_fib2']);
$fir_fnm2 = strip_tags($_REQUEST['fir_fnm2']);
$fir_fnb2 = strip_tags($_REQUEST['fir_fnb2']);
$fir_fsb2 = strip_tags($_REQUEST['fir_fsb2']);
$fir_fuc3 = strip_tags($_REQUEST['fir_fuc3']);
$fir_fib3 = strip_tags($_REQUEST['fir_fib3']);
$fir_fnm3 = strip_tags($_REQUEST['fir_fnm3']);
$fir_fnb3 = strip_tags($_REQUEST['fir_fnb3']);
$fir_fsb3 = strip_tags($_REQUEST['fir_fsb3']);
$fir_obreg = strip_tags($_REQUEST['fir_obreg']);
$fir_uctt01 = strip_tags($_REQUEST['fir_uctt01']);
$fir_uctt02 = strip_tags($_REQUEST['fir_uctt02']);
$fir_uctt03 = strip_tags($_REQUEST['fir_uctt03']);
$fir_uctt04 = strip_tags($_REQUEST['fir_uctt04']);
$fir_uctt05 = strip_tags($_REQUEST['fir_uctt05']);
$fir_mzdt03 = trim(strip_tags($_REQUEST['fir_mzdt03']));
$fir_mzdt04 = strip_tags($_REQUEST['fir_mzdt04']);
$fir_mzdt05 = strip_tags($_REQUEST['fir_mzdt05']);
$fir_fsw1 = strip_tags($_REQUEST['fir_fsw1']);
$fir_fsw2 = strip_tags($_REQUEST['fir_fsw2']);
$fir_fsw3 = strip_tags($_REQUEST['fir_fsw3']);

$fir_allx11 = strip_tags($_REQUEST['fir_allx11']);
$fir_allx12 = 1*$_REQUEST['fir_allx12'];
$uprav="NO";

$upravttd = "UPDATE F$kli_vxcf"."_ufirdalsie SET fstat='$fir_fstat' ";  
$upravend = mysql_query("$upravttd");

$upravttt = "UPDATE F$kli_vxcf"."_ufir SET fico='$fir_fico', fdic='$fir_fdic', ficd='$fir_ficd'".
", fnaz='$fir_fnaz', fuli='$fir_fuli', fpsc='$fir_fpsc', fmes='$fir_fmes', ftel='$fir_ftel', ffax='$fir_ffax'".
", fwww='$fir_fwww', fem1='$fir_fem1', fem2='$fir_fem2', fem3='$fir_fem3', fcdm='$fir_fcdm', allx12='$fir_allx12'".
", fuc1='$fir_fuc1', fib1='$fir_fib1', fnm1='$fir_fnm1', fnb1='$fir_fnb1', fsb1='$fir_fsb1'".
", fuc2='$fir_fuc2', fib2='$fir_fib2', fnm2='$fir_fnm2', fnb2='$fir_fnb2', fsb2='$fir_fsb2'".
", fuc3='$fir_fuc3', fib3='$fir_fib3', fnm3='$fir_fnm3', fnb3='$fir_fnb3', fsb3='$fir_fsb3', obreg='$fir_obreg'".
", uc1fk='$fir_uc1fk', uc2fk='$fir_uc2fk', uc3fk='$fir_uc3fk', uctt01='$fir_uctt01', uctt02='$fir_uctt02', uctt03='$fir_uctt03' ".
", fsw1='$fir_fsw1', fsw2='$fir_fsw2', fsw3='$fir_fsw3' ".
", uctt04='$fir_uctt04', uctt05='$fir_uctt05', mzdt04='$fir_mzdt04', mzdt05='$fir_mzdt05', mzdt03='$fir_mzdt03', allx11='$fir_allx11' WHERE udaje=1";  
//echo $upravttt;
$upravene = mysql_query("$upravttt"); 
$copern=1;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";

$sqult = "INSERT INTO F$kli_vxcf"."_ico ( ico,nai ) VALUES ( '$fir_fico', '$fir_fnaz'  );";
if( $fir_fico != 31213121 ) { $ulozene = mysql_query("$sqult"); }

$fir_fulix=$fir_fuli." ".$fir_fcdm;

$sqult = "UPDATE F$kli_vxcf"."_ico SET icd='$fir_ficd', dic='$fir_fdic', nai='$fir_fnaz', uli='$fir_fulix', mes='$fir_fmes', psc='$fir_fpsc',  ".
" tel='$fir_ftel', fax='$fir_ffax', em1='$fir_fem1', www='$fir_fwww', nm1='$fir_fnm1', uc1='$fir_fuc1', dns=0 ".
" WHERE ico = $fir_fico ";
if( $fir_fico != 31213121 ) { $ulozene = mysql_query("$sqult"); }

endif;
    }
//koniec zapisu uprav udaje o firme


//zapis upravene parametre skladu
if ( $copern == 13 )
    {
$fir_dph1 = strip_tags($_REQUEST['fir_dph1']);
$fir_dph2 = strip_tags($_REQUEST['fir_dph2']);
$fir_dph3 = strip_tags($_REQUEST['fir_dph3']);
$fir_dph4 = strip_tags($_REQUEST['fir_dph4']);
$fir_sklcpr = strip_tags($_REQUEST['fir_sklcpr']);
$fir_sklcvd = strip_tags($_REQUEST['fir_sklcvd']);
$fir_sklcps = strip_tags($_REQUEST['fir_sklcps']);
$fir_mena1 = strip_tags($_REQUEST['fir_mena1']);
$fir_mena2 = strip_tags($_REQUEST['fir_mena2']);
$fir_kurz12 = strip_tags($_REQUEST['fir_kurz12']);
$fir_kurz12=str_replace(",",".",$fir_kurz12);
$fir_sklcis = strip_tags($_REQUEST['fir_sklcis']);
$fir_sklstr = strip_tags($_REQUEST['fir_sklstr']);
$fir_sklzak = strip_tags($_REQUEST['fir_sklzak']);
$fir_xsk03 = strip_tags($_REQUEST['fir_xsk03']);
$fir_xsk04 = strip_tags($_REQUEST['fir_xsk04']);
$fir_xsk02 = strip_tags($_REQUEST['fir_xsk02']);
$fir_xsk05 = strip_tags($_REQUEST['fir_xsk05']);

$uprav="NO";

$upravene = mysql_query("UPDATE F$kli_vxcf"."_ufir SET dph1='$fir_dph1', dph2='$fir_dph2',
 dph3='$fir_dph3', dph4='$fir_dph4', sklcpr='$fir_sklcpr', sklcvd='$fir_sklcvd', sklcis='$fir_sklcis',
 sklcps='$fir_sklcps', mena1='$fir_mena1', mena2='$fir_mena2', kurz12='$fir_kurz12', sklstr='$fir_sklstr',
 sklzak='$fir_sklzak', xsk03='$fir_xsk03', xsk04='$fir_xsk04', xsk02='$fir_xsk02', xsk05='$fir_xsk05'  WHERE udaje=1");  
$copern=11;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu uprav parametre skladu

//zapis upravene parametre fakturacie
if ( $copern == 23 )
    {
$fir_dph1 = strip_tags($_REQUEST['fir_dph1']);
$fir_dph2 = strip_tags($_REQUEST['fir_dph2']);
$fir_dph3 = strip_tags($_REQUEST['fir_dph3']);
$fir_dph4 = strip_tags($_REQUEST['fir_dph4']);
$fir_pokpri = strip_tags($_REQUEST['fir_pokpri']);
$fir_pokvyd = strip_tags($_REQUEST['fir_pokvyd']);
$fir_fakodb = strip_tags($_REQUEST['fir_fakodb']);
$fir_fakdod = strip_tags($_REQUEST['fir_fakdod']);
$fir_fakobj = strip_tags($_REQUEST['fir_fakobj']);
$fir_fakdol = strip_tags($_REQUEST['fir_fakdol']);
$fir_fakprf = strip_tags($_REQUEST['fir_fakprf']);
$fir_fakvnp = strip_tags($_REQUEST['fir_fakvnp']);
$fir_fakstr = strip_tags($_REQUEST['fir_fakstr']);
$fir_fakzak = strip_tags($_REQUEST['fir_fakzak']);
$fir_mena1 = strip_tags($_REQUEST['fir_mena1']);
$fir_mena2 = strip_tags($_REQUEST['fir_mena2']);
$fir_kurz12 = strip_tags($_REQUEST['fir_kurz12']);
$fir_kurz12=str_replace(",",".",$fir_kurz12);
$fir_xfa01 = strip_tags($_REQUEST['fir_xfa01']);
$fir_xfa02 = strip_tags($_REQUEST['fir_xfa02']);
$fir_xfa03 = strip_tags($_REQUEST['fir_xfa03']);
$fir_xfa04 = strip_tags($_REQUEST['fir_xfa04']);
$fir_xfa05 = strip_tags($_REQUEST['fir_xfa05']);
$fir_xfa06 = strip_tags($_REQUEST['fir_xfa06']);
$uprav="NO";

$upravene = mysql_query("UPDATE F$kli_vxcf"."_ufir SET dph1='$fir_dph1', dph2='$fir_dph2',
 dph3='$fir_dph3', dph4='$fir_dph4', pokpri='$fir_pokpri', pokvyd='$fir_pokvyd', 
 fakodb='$fir_fakodb', fakdod='$fir_fakdod', fakobj='$fir_fakobj', fakprf='$fir_fakprf',
 fakdol='$fir_fakdol', fakstr='$fir_fakstr', fakzak='$fir_fakzak', fakvnp='$fir_fakvnp',
 mena1='$fir_mena1', mena2='$fir_mena2', kurz12='$fir_kurz12', xfa01='$fir_xfa01', xfa02='$fir_xfa02', xfa03='$fir_xfa03', xfa04='$fir_xfa04',
 xfa05='$fir_xfa05', xfa06='$fir_xfa06' WHERE udaje=1");  
$copern=21;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu uprav parametre fakturacie


//zapis upravene parametre doprava
if ( $copern == 33 )
    {
$fir_dph1 = strip_tags($_REQUEST['fir_dph1']);
$fir_dph2 = strip_tags($_REQUEST['fir_dph2']);
$fir_dph3 = strip_tags($_REQUEST['fir_dph3']);
$fir_dph4 = strip_tags($_REQUEST['fir_dph4']);
//$fir_pokpri = strip_tags($_REQUEST['fir_pokpri']);
//$fir_pokvyd = strip_tags($_REQUEST['fir_pokvyd']);
$fir_dopfak = strip_tags($_REQUEST['fir_dopfak']);
$fir_dopobj = strip_tags($_REQUEST['fir_dopobj']);
$fir_dopdol = strip_tags($_REQUEST['fir_dopdol']);
$fir_dopvnp = strip_tags($_REQUEST['fir_dopvnp']);
$fir_dopstz = strip_tags($_REQUEST['fir_dopstz']);
$fir_dopreg = strip_tags($_REQUEST['fir_dopreg']);
$fir_dopstr = strip_tags($_REQUEST['fir_dopstr']);
$fir_dopzak = strip_tags($_REQUEST['fir_dopzak']);
$fir_mena1 = strip_tags($_REQUEST['fir_mena1']);
$fir_mena2 = strip_tags($_REQUEST['fir_mena2']);
$fir_kurz12 = strip_tags($_REQUEST['fir_kurz12']);
$fir_kurz12=str_replace(",",".",$fir_kurz12);
$fir_xdp01 = strip_tags($_REQUEST['fir_xdp01']);
$fir_xdp02 = strip_tags($_REQUEST['fir_xdp02']);
$fir_xdp03 = strip_tags($_REQUEST['fir_xdp03']);
$fir_xdp04 = strip_tags($_REQUEST['fir_xdp04']);
$fir_xdp05 = strip_tags($_REQUEST['fir_xdp05']);
$fir_xdp06 = strip_tags($_REQUEST['fir_xdp06']);
$fir_fakprf = strip_tags($_REQUEST['fir_fakprf']);
$uprav="NO";

$upravene = mysql_query("UPDATE F$kli_vxcf"."_ufir SET dph1='$fir_dph1', dph2='$fir_dph2',
 dph3='$fir_dph3', dph4='$fir_dph4', 
 dopfak='$fir_dopfak', dopobj='$fir_dopobj', dopzak='$fir_dopzak', dopvnp='$fir_dopvnp', fakprf='$fir_fakprf',
 dopdol='$fir_dopdol', dopstr='$fir_dopstr', dopstz='$fir_dopstz', dopreg='$fir_dopreg',
 mena1='$fir_mena1', mena2='$fir_mena2', kurz12='$fir_kurz12', xdp01='1', xdp02='$fir_xdp02', xdp03='$fir_xdp03',
 xdp04='$fir_xdp04', xdp05='$fir_xdp05', xdp06='$fir_xdp06' WHERE udaje=1");  
$copern=31;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu uprav parametre doprava


//zapis upravene parametre majetok
if ( $copern == 83 )
    {
$fir_dph1 = strip_tags($_REQUEST['fir_dph1']);
$fir_dph2 = strip_tags($_REQUEST['fir_dph2']);
$fir_dph3 = strip_tags($_REQUEST['fir_dph3']);
$fir_dph4 = strip_tags($_REQUEST['fir_dph4']);
$fir_mena1 = strip_tags($_REQUEST['fir_mena1']);
$fir_mena2 = strip_tags($_REQUEST['fir_mena2']);
$fir_kurz12 = strip_tags($_REQUEST['fir_kurz12']);
$fir_kurz12=str_replace(",",".",$fir_kurz12);
$fir_majx01 = strip_tags($_REQUEST['fir_majx01']);
$fir_majx02 = strip_tags($_REQUEST['fir_majx02']);
$fir_majx03 = strip_tags($_REQUEST['fir_majx03']);
$fir_majx04 = strip_tags($_REQUEST['fir_majx04']);
$fir_majx05 = strip_tags($_REQUEST['fir_majx05']);
$uprav="NO";

$upravene = mysql_query("UPDATE F$kli_vxcf"."_ufir SET dph1='$fir_dph1', dph2='$fir_dph2',
 dph3='$fir_dph3', dph4='$fir_dph4', 
 mena1='$fir_mena1', mena2='$fir_mena2', kurz12='$fir_kurz12', majx01='$fir_majx01', majx02='$fir_majx02', majx03='$fir_majx03',
 majx04='$fir_majx04', majx05='$fir_majx03' WHERE udaje=1");  
$copern=81;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu uprav parametre majetok

//zapis upravene parametre vyroba
if ( $copern == 43 )
    {

$fir_xvr01 = strip_tags($_REQUEST['fir_xvr01']);

$uprav="NO";

$upravene = mysql_query("UPDATE F$kli_vxcf"."_ufir SET xvr01='$fir_xvr01'  WHERE udaje=1");  
$copern=41;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu uprav parametre vyroba

//zapis upravene parametre ucto
if ( $copern == 93 )
    {
$fir_dph1 = strip_tags($_REQUEST['fir_dph1']);
$fir_dph2 = strip_tags($_REQUEST['fir_dph2']);
$fir_dph3 = strip_tags($_REQUEST['fir_dph3']);
$fir_dph4 = strip_tags($_REQUEST['fir_dph4']);
$fir_pokpri = strip_tags($_REQUEST['fir_pokpri']);
$fir_pokvyd = strip_tags($_REQUEST['fir_pokvyd']);
$fir_mena1 = strip_tags($_REQUEST['fir_mena1']);
$fir_mena2 = strip_tags($_REQUEST['fir_mena2']);
$fir_kurz12 = strip_tags($_REQUEST['fir_kurz12']);
$fir_kurz12=str_replace(",",".",$fir_kurz12);
$fir_uctx01 = strip_tags($_REQUEST['fir_uctx01']);
$fir_uctx02 = strip_tags($_REQUEST['fir_uctx02']);
$fir_uctx03 = strip_tags($_REQUEST['fir_uctx03']);
$fir_uctx04 = strip_tags($_REQUEST['fir_uctx04']);
$fir_uctx05 = strip_tags($_REQUEST['fir_uctx05']);
$fir_uctx06 = strip_tags($_REQUEST['fir_uctx06']);
$fir_uctx07 = strip_tags($_REQUEST['fir_uctx07']);
$fir_uctx08 = strip_tags($_REQUEST['fir_uctx08']);
$fir_uctx09 = strip_tags($_REQUEST['fir_uctx09']);
$fir_uctx10 = strip_tags($_REQUEST['fir_uctx10']);
$fir_uctx11 = strip_tags($_REQUEST['fir_uctx11']);
$fir_uctx12 = strip_tags($_REQUEST['fir_uctx12']);
$fir_uctx13 = strip_tags($_REQUEST['fir_uctx13']);
$fir_uctx14 = strip_tags($_REQUEST['fir_uctx14']);
$fir_uctx15 = strip_tags($_REQUEST['fir_uctx15']);
$fir_xvr05 = strip_tags($_REQUEST['fir_xvr05']);
$fir_allx15 = strip_tags($_REQUEST['fir_allx15']);
$fir_allx14 = strip_tags($_REQUEST['fir_allx14']);
$fir_allx13 = strip_tags($_REQUEST['fir_allx13']);

$fir_fakodb = strip_tags($_REQUEST['fir_fakodb']);
$fir_fakdod = strip_tags($_REQUEST['fir_fakdod']);

$uprav="NO";


if( $fir_uctx03 == 1 )
           {
//ak neexistuje uctpohyby tak ju vytvor
$sql = "SELECT * FROM F$kli_vxcf"."_uctpohyby";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$nuctpoh="";
if( $_SESSION['kli_vrok'] < 2011 ) { $nuctpoh="2010"; }

$sql = "CREATE TABLE F".$kli_vxcf."_uctpohyby SELECT * FROM uctpohyby$nuctpoh ";
$vysledek = mysql_query("$sql");

}
          }

$upravene = mysql_query("UPDATE F$kli_vxcf"."_ufir SET dph1='$fir_dph1', dph2='$fir_dph2', xvr05='$fir_xvr05',
 dph3='$fir_dph3', dph4='$fir_dph4', pokpri='$fir_pokpri', pokvyd='$fir_pokvyd', fakodb='$fir_fakodb', fakdod='$fir_fakdod', allx13='$fir_allx13',  
 mena1='$fir_mena1', mena2='$fir_mena2', kurz12='$fir_kurz12', uctx01='$fir_uctx01', uctx02='$fir_uctx02', uctx03='$fir_uctx03', allx14='$fir_allx14',
 uctx04='$fir_uctx04', uctx05='$fir_uctx05', uctx06='$fir_uctx06', uctx07='$fir_uctx07', uctx08='$fir_uctx08', uctx15='$fir_uctx15', allx15='$fir_allx15', 
 uctx09='$fir_uctx09', uctx10='$fir_uctx10', uctx11='$fir_uctx11', uctx12='$fir_uctx12', uctx13='$fir_uctx13', uctx14='$fir_uctx14' WHERE udaje=1");  
$copern=91;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu uprav parametre ucto

//zapis upravene parametre mzdy
if ( $copern == 193 )
    {
$fir_dph1 = strip_tags($_REQUEST['fir_dph1']);
$fir_dph2 = strip_tags($_REQUEST['fir_dph2']);
$fir_dph3 = strip_tags($_REQUEST['fir_dph3']);
$fir_dph4 = strip_tags($_REQUEST['fir_dph4']);
$fir_mena1 = strip_tags($_REQUEST['fir_mena1']);
$fir_mena2 = strip_tags($_REQUEST['fir_mena2']);
$fir_kurz12 = strip_tags($_REQUEST['fir_kurz12']);
$fir_kurz12=str_replace(",",".",$fir_kurz12);
$fir_mzdx01 = strip_tags($_REQUEST['fir_mzdx01']);
$fir_mzdx02 = strip_tags($_REQUEST['fir_mzdx02']);
$fir_mzdx03 = strip_tags($_REQUEST['fir_mzdx03']);
$fir_mzdx04 = strip_tags($_REQUEST['fir_mzdx04']);
$fir_mzdx05 = strip_tags($_REQUEST['fir_mzdx05']);
$fir_mzdx06 = strip_tags($_REQUEST['fir_mzdx06']);
$fir_mzdx07 = strip_tags($_REQUEST['fir_mzdx07']);
$uprav="NO";

$upravttt = "UPDATE F$kli_vxcf"."_ufir SET dph1='$fir_dph1', dph2='$fir_dph2', dph3='$fir_dph3', dph4='$fir_dph4', mzdx04='$fir_mzdx04',  
 mena1='$fir_mena1', mena2='$fir_mena2', kurz12='$fir_kurz12', mzdx01='$fir_mzdx01', mzdx02='$fir_mzdx02', mzdx03='$fir_mzdx03', mzdx06='$fir_mzdx06'
 , mzdx07='$fir_mzdx07' WHERE udaje=1";  
//echo $upravttt;
$upravene = mysql_query("$upravttt"); 
$copern=191;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu uprav parametre mzdy

//nacitaj udaje
if ( $copern >= 1 )
    {

$citfir = include("../cis/citaj_fir.php");

    }
//koniec nacitania

//ak neexistuje uctpohyby vytvor
if( $fir_uctx03 == 1 )
           {
//ak neexistuje uctpohyby tak ju vytvor
$sql = "SELECT * FROM F$kli_vxcf"."_uctpohyby";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$nuctpoh="";
if( $_SESSION['kli_vrok'] < 2011 ) { $nuctpoh="2010"; }

$sql = "CREATE TABLE F".$kli_vxcf."_uctpohyby SELECT * FROM uctpohyby$nuctpoh ";
$vysledek = mysql_query("$sql");

}
          }
//koniec ak neexistuje uctpohyby vytvor

//hlavicka
if ( $copern == 30191 )
    {
$h_odb = 1*$_REQUEST['h_odb'];
if( $h_odb == 1 ) 
  {
if (File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickaodb.nie"))
 { $soubor = unlink("../dokumenty/FIR$kli_vxcf/hlavickaodb.nie"); }
  }
if( $h_odb == 0 ) 
  {
$soubor = fopen("../dokumenty/FIR$kli_vxcf/hlavickaodb.nie", "a+");
  $text = "<?php ?>";
  fwrite($soubor, $text);
fclose($soubor);
  }

$h_dod = 1*$_REQUEST['h_dod'];
if( $h_dod == 1 ) 
  {
if (File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickadod.nie"))
 { $soubor = unlink("../dokumenty/FIR$kli_vxcf/hlavickadod.nie"); }
  }
if( $h_dod == 0 ) 
  {
$soubor = fopen("../dokumenty/FIR$kli_vxcf/hlavickadod.nie", "a+");
  $text = "<?php ?>";
  fwrite($soubor, $text);
fclose($soubor);
  }

$h_pok = 1*$_REQUEST['h_pok'];
if( $h_pok == 1 ) 
  {
if (File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickapok.nie"))
 { $soubor = unlink("../dokumenty/FIR$kli_vxcf/hlavickapok.nie"); }
  }
if( $h_pok == 0 ) 
  {
$soubor = fopen("../dokumenty/FIR$kli_vxcf/hlavickapok.nie", "a+");
  $text = "<?php ?>";
  fwrite($soubor, $text);
fclose($soubor);
  }

$h_ban = 1*$_REQUEST['h_ban'];
if( $h_ban == 1 ) 
  {
if (File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickaban.nie"))
 { $soubor = unlink("../dokumenty/FIR$kli_vxcf/hlavickaban.nie"); }
  }
if( $h_ban == 0 ) 
  {
$soubor = fopen("../dokumenty/FIR$kli_vxcf/hlavickaban.nie", "a+");
  $text = "<?php ?>";
  fwrite($soubor, $text);
fclose($soubor);
  }

$h_vse = 1*$_REQUEST['h_vse'];
if( $h_vse == 1 ) 
  {
if (File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickavse.nie"))
 { $soubor = unlink("../dokumenty/FIR$kli_vxcf/hlavickavse.nie"); }
  }
if( $h_vse == 0 ) 
  {
$soubor = fopen("../dokumenty/FIR$kli_vxcf/hlavickavse.nie", "a+");
  $text = "<?php ?>";
  fwrite($soubor, $text);
fclose($soubor);
  }

$copern=1;
    }
//koniec hlavicka

//prepocet na Sk prepni
if ( $copern == 20191 )
    {
//echo $ajprepocetnask;

$ajprepocetnaskx=$ajprepocetnask;
if( $ajprepocetnaskx == 0 ) 
  {
//echo "dam ANO";
if (File_Exists ("../dokumenty/FIR$kli_vxcf/ajprepocetnask.nie"))
 { $soubor = unlink("../dokumenty/FIR$kli_vxcf/ajprepocetnask.nie"); }
$ajprepocetnask=1;
  }
if( $ajprepocetnaskx == 1 ) 
  {
//echo "dam NIE";
$soubor = fopen("../dokumenty/FIR$kli_vxcf/ajprepocetnask.nie", "a+");
  $text = "<?php ?>";
  fwrite($soubor, $text);
fclose($soubor);
$ajprepocetnask=0;
  }

$copern=1;
    }
//koniec prepocet na Sk prepni

//tabulka skluzid
$sql = "SELECT uzix FROM F$kli_vxcf"."_skluzid ";
$vysledok = mysql_query($sql);
if (!$vysledok AND $fir_xsk05 == 1 )
{
//echo "idem";

$sql = "DROP TABLE F$kli_vxcf"."_skluzid ";
$vysledok = mysql_query($sql);

$sqlt = <<<uctcrv
(
   uzix          DECIMAL(5,0) DEFAULT 0,
   xsklp         VARCHAR(60) NOT NULL,
   xsklv         DECIMAL(10,0) DEFAULT 0,
   xcpri         DECIMAL(10,0) DEFAULT 0,
   xvpri         DECIMAL(10,0) DEFAULT 0,
   xcvyd         DECIMAL(10,0) DEFAULT 0,
   xvvyd         DECIMAL(10,0) DEFAULT 0,
   xcpre         DECIMAL(10,0) DEFAULT 0,
   xvpre         DECIMAL(10,0) DEFAULT 0,
   xucto         DECIMAL(10,0) DEFAULT 0,
   xzost         DECIMAL(10,0) DEFAULT 0,
   datm          TIMESTAMP(14)
);
uctcrv;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_skluzid'.$sqlt;
$vytvor = mysql_query("$vsql");
}
//koniec skluzid

//tabulka sklxskl
$sql = "SELECT sklx FROM F$kli_vxcf"."_sklxskl ";
$vysledok = mysql_query($sql);
if (!$vysledok AND $fir_xsk05 == 1 )
{
//echo "idem";

$sql = "DROP TABLE F$kli_vxcf"."_sklxskl ";
$vysledok = mysql_query($sql);

$sqlt = <<<uctcrv
(
   sklx          DECIMAL(5,0) DEFAULT 0,
   xsklp         VARCHAR(60) NOT NULL,
   xsklv         DECIMAL(10,0) DEFAULT 0,
   xcpri         DECIMAL(10,0) DEFAULT 0,
   xvpri         DECIMAL(10,0) DEFAULT 0,
   xcvyd         DECIMAL(10,0) DEFAULT 0,
   xvvyd         DECIMAL(10,0) DEFAULT 0,
   xcpre         DECIMAL(10,0) DEFAULT 0,
   xvpre         DECIMAL(10,0) DEFAULT 0,
   xucto         DECIMAL(10,0) DEFAULT 0,
   xzost         DECIMAL(10,0) DEFAULT 0,
   datm          TIMESTAMP(14)
);
uctcrv;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklxskl'.$sqlt;
$vytvor = mysql_query("$vsql");
}
//koniec sklxskl

//tabulka vyruzid
$sql = "SELECT xcaspr1 FROM F$kli_vxcf"."_vyruzid ";
$vysledok = mysql_query($sql);
if (!$vysledok AND $fir_xvr01 == 1 )
{
//echo "idem";

$sql = "DROP TABLE F$kli_vxcf"."_vyruzid ";
//$vysledok = mysql_query($sql);

$sqlt = <<<uctcrv
(
   uzix          DECIMAL(5,0) DEFAULT 0,
   xnewzak       DECIMAL(10,0) DEFAULT 0,
   xedizak       DECIMAL(10,0) DEFAULT 0,
   xvyrzak       DECIMAL(10,0) DEFAULT 0,
   xekoinf       DECIMAL(10,0) DEFAULT 0,
   xvyrinf       DECIMAL(10,0) DEFAULT 0,
   xprcprk       DECIMAL(10,0) DEFAULT 0,
   xciszam       DECIMAL(10,0) DEFAULT 0,
   xcisrcp       DECIMAL(10,0) DEFAULT 0,
   xciskmp       DECIMAL(10,0) DEFAULT 0,
   xcisopr       DECIMAL(10,0) DEFAULT 0,
   xprmvyr       DECIMAL(10,0) DEFAULT 0,
   xuprda1       DECIMAL(10,0) DEFAULT 0,
   xuprda2       DECIMAL(10,0) DEFAULT 0,
   xuprda3       DECIMAL(10,0) DEFAULT 0,
   xuprda4       DECIMAL(10,0) DEFAULT 0,
   xuprda5       DECIMAL(10,0) DEFAULT 0,
   xuprda6       DECIMAL(10,0) DEFAULT 0,
   xuprda7       DECIMAL(10,0) DEFAULT 0,
   xuprda8       DECIMAL(10,0) DEFAULT 0,
   xuprpoz       DECIMAL(10,0) DEFAULT 0,
   xuprtx1       DECIMAL(10,0) DEFAULT 0,
   xuprtx2       DECIMAL(10,0) DEFAULT 0,
   xuprtx3       DECIMAL(10,0) DEFAULT 0,
   xuprob1       DECIMAL(10,0) DEFAULT 0,
   xuprob2       DECIMAL(10,0) DEFAULT 0,
   xuprob3       DECIMAL(10,0) DEFAULT 0,
   xuprob4       DECIMAL(10,0) DEFAULT 0,
   xchtpoz       DECIMAL(10,0) DEFAULT 0,
   xchtpis       DECIMAL(10,0) DEFAULT 0,
   xchtsub       DECIMAL(10,0) DEFAULT 0,
   xchtvi1       DECIMAL(10,0) DEFAULT 0,
   xchtvi2       DECIMAL(10,0) DEFAULT 0,
   xchnick       VARCHAR(30) NOT NULL,
   datm          TIMESTAMP(14)
);
uctcrv;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_vyruzid'.$sqlt;
$vytvor = mysql_query("$vsql");

$sql = "ALTER TABLE F$kli_vxcf"."_vyruzid ADD xchnick VARCHAR(30) NOT NULL AFTER xchtvi2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyruzid ADD xmodzak DECIMAL(10,0) DEFAULT 0 AFTER xvyrzak";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyruzid ADD xcaspoz DECIMAL(10,0) DEFAULT 0 AFTER xvyrzak";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyruzid ADD xcasupr DECIMAL(10,0) DEFAULT 0 AFTER xvyrzak";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyruzid ADD xcaspr1 DECIMAL(10,0) DEFAULT 0 AFTER xvyrzak";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_vyruzid SET xcaspoz=1, xcasupr=1 ";
$vysledek = mysql_query("$sql");
}
//koniec vyruzid


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Údaje o firme</title>
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
    document.formv1.fir_fico.value = '<?php echo "$fir_fico";?>';
    document.formv1.fir_fdic.value = '<?php echo "$fir_fdic";?>';
    document.formv1.fir_ficd.value = '<?php echo "$fir_ficd";?>';
    document.formv1.fir_fnaz.value = '<?php echo "$fir_fnaz";?>';
    document.formv1.fir_fuli.value = '<?php echo "$fir_fuli";?>';
    document.formv1.fir_fcdm.value = '<?php echo "$fir_fcdm";?>';
    document.formv1.fir_fpsc.value = '<?php echo "$fir_fpsc";?>';
    document.formv1.fir_fmes.value = '<?php echo "$fir_fmes";?>';
    document.formv1.fir_ftel.value = '<?php echo "$fir_ftel";?>';
    document.formv1.fir_ffax.value = '<?php echo "$fir_ffax";?>';
    document.formv1.fir_fwww.value = '<?php echo "$fir_fwww";?>';
    document.formv1.fir_fem1.value = '<?php echo "$fir_fem1";?>';
    document.formv1.fir_fem2.value = '<?php echo "$fir_fem2";?>';
    document.formv1.fir_fem3.value = '<?php echo "$fir_fem3";?>';
    document.formv1.fir_fuc1.value = '<?php echo "$fir_fuc1";?>';
    document.formv1.fir_fib1.value = '<?php echo "$fir_fib1";?>';
    document.formv1.fir_fnm1.value = '<?php echo "$fir_fnm1";?>';
    document.formv1.fir_fnb1.value = '<?php echo "$fir_fnb1";?>';
    document.formv1.fir_fsb1.value = '<?php echo "$fir_fsb1";?>';
    document.formv1.fir_fuc2.value = '<?php echo "$fir_fuc2";?>';
    document.formv1.fir_fib2.value = '<?php echo "$fir_fib2";?>';
    document.formv1.fir_fnm2.value = '<?php echo "$fir_fnm2";?>';
    document.formv1.fir_fnb2.value = '<?php echo "$fir_fnb2";?>';
    document.formv1.fir_fsb2.value = '<?php echo "$fir_fsb2";?>';
    document.formv1.fir_fuc3.value = '<?php echo "$fir_fuc3";?>';
    document.formv1.fir_fib3.value = '<?php echo "$fir_fib3";?>';
    document.formv1.fir_fnm3.value = '<?php echo "$fir_fnm3";?>';
    document.formv1.fir_fnb3.value = '<?php echo "$fir_fnb3";?>';
    document.formv1.fir_fsb3.value = '<?php echo "$fir_fsb3";?>';
    document.formv1.fir_obreg.value = '<?php echo "$fir_obreg";?>';
    document.formv1.fir_uctt01.value = '<?php echo "$fir_uctt01";?>';
    document.formv1.fir_uctt02.value = '<?php echo "$fir_uctt02";?>';
    document.formv1.fir_uctt03.value = '<?php echo "$fir_uctt03";?>';
    document.formv1.fir_uctt04.value = '<?php echo "$fir_uctt04";?>';
    document.formv1.fir_uctt05.value = '<?php echo "$fir_uctt05";?>';
    document.formv1.fir_mzdt04.value = '<?php echo "$fir_mzdt04";?>';
    document.formv1.fir_mzdt05.value = '<?php echo "$fir_mzdt05";?>';
    document.formv1.fir_mzdt03.value = '<?php echo "$fir_sknace";?>';
    document.formv1.fir_fsw1.value = '<?php echo "$fir_fsw1";?>';
    document.formv1.fir_fsw2.value = '<?php echo "$fir_fsw2";?>';
    document.formv1.fir_fsw3.value = '<?php echo "$fir_fsw3";?>';
    document.formv1.fir_allx11.value = '<?php echo "$fir_allx11";?>';
    document.formv1.fir_allx12.value = '<?php echo "$fir_allx12";?>';
    }
<?php
//koniec uprava
  }
?>

<?php
//uprava udaje sklad
  if ( $copern == 12 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.fir_dph1.value = '<?php echo "$fir_dph1";?>';
    document.formv1.fir_dph2.value = '<?php echo "$fir_dph2";?>';
    document.formv1.fir_dph3.value = '<?php echo "$fir_dph3";?>';
    document.formv1.fir_dph4.value = '<?php echo "$fir_dph4";?>';
    document.formv1.fir_sklcpr.value = '<?php echo "$fir_sklcpr";?>';
    document.formv1.fir_sklcps.value = '<?php echo "$fir_sklcps";?>';
    document.formv1.fir_sklcvd.value = '<?php echo "$fir_sklcvd";?>';
    document.formv1.fir_mena1.value = '<?php echo "$fir_mena1";?>';
    document.formv1.fir_mena2.value = '<?php echo "$fir_mena2";?>';
    document.formv1.fir_kurz12.value = '<?php echo "$fir_kurz12";?>';
    document.formv1.fir_sklcis.value = '<?php echo "$fir_sklcis";?>';
    document.formv1.fir_sklstr.value = '<?php echo "$fir_sklstr";?>';
    document.formv1.fir_sklzak.value = '<?php echo "$fir_sklzak";?>';
    document.formv1.fir_xsk03.value = '<?php echo "$fir_xsk03";?>';
    document.formv1.fir_xsk04.value = '<?php echo "$fir_xsk04";?>';
    document.formv1.fir_xsk02.value = '<?php echo "$fir_xsk02";?>';
    document.formv1.fir_xsk05.value = '<?php echo "$fir_xsk05";?>';
    }
<?php
//koniec uprava
  }
?>

<?php
//uprava udaje fakturacia
  if ( $copern == 22 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.fir_dph1.value = '<?php echo "$fir_dph1";?>';
    document.formv1.fir_dph2.value = '<?php echo "$fir_dph2";?>';
    document.formv1.fir_dph3.value = '<?php echo "$fir_dph3";?>';
    document.formv1.fir_dph4.value = '<?php echo "$fir_dph4";?>';
    document.formv1.fir_pokpri.value = '<?php echo "$fir_pokpri";?>';
    document.formv1.fir_pokvyd.value = '<?php echo "$fir_pokvyd";?>';
    document.formv1.fir_fakodb.value = '<?php echo "$fir_fakodb";?>';
    document.formv1.fir_fakdod.value = '<?php echo "$fir_fakdod";?>';
    document.formv1.fir_fakobj.value = '<?php echo "$fir_fakobj";?>';
    document.formv1.fir_fakdol.value = '<?php echo "$fir_fakdol";?>';
    document.formv1.fir_fakprf.value = '<?php echo "$fir_fakprf";?>';
    document.formv1.fir_fakvnp.value = '<?php echo "$fir_fakvnp";?>';
    document.formv1.fir_fakstr.value = '<?php echo "$fir_fakstr";?>';
    document.formv1.fir_fakzak.value = '<?php echo "$fir_fakzak";?>';
    document.formv1.fir_mena1.value = '<?php echo "$fir_mena1";?>';
    document.formv1.fir_mena2.value = '<?php echo "$fir_mena2";?>';
    document.formv1.fir_kurz12.value = '<?php echo "$fir_kurz12";?>';
    document.formv1.fir_xfa01.value = '<?php echo "$fir_xfa01";?>';
    document.formv1.fir_xfa02.value = '<?php echo "$fir_xfa02";?>';
    document.formv1.fir_xfa03.value = '<?php echo "$fir_xfa03";?>';
    document.formv1.fir_xfa04.value = '<?php echo "$fir_xfa04";?>';
    document.formv1.fir_xfa05.value = '<?php echo "$fir_xfa05";?>';
    document.formv1.fir_xfa06.value = '<?php echo "$fir_xfa06";?>';
    }
<?php
//koniec uprava
  }
?>

<?php
//uprava udaje doprava
  if ( $copern == 32 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.fir_dph1.value = '<?php echo "$fir_dph1";?>';
    document.formv1.fir_dph2.value = '<?php echo "$fir_dph2";?>';
    document.formv1.fir_dph3.value = '<?php echo "$fir_dph3";?>';
    document.formv1.fir_dph4.value = '<?php echo "$fir_dph4";?>';
//    document.formv1.fir_pokpri.value = '<?php echo "$fir_pokpri";?>';
//    document.formv1.fir_pokvyd.value = '<?php echo "$fir_pokvyd";?>';
    document.formv1.fir_dopfak.value = '<?php echo "$fir_dopfak";?>';
    document.formv1.fir_dopobj.value = '<?php echo "$fir_dopobj";?>';
    document.formv1.fir_dopdol.value = '<?php echo "$fir_dopdol";?>';
    document.formv1.fir_dopvnp.value = '<?php echo "$fir_dopvnp";?>';
    document.formv1.fir_dopstr.value = '<?php echo "$fir_dopstr";?>';
    document.formv1.fir_dopzak.value = '<?php echo "$fir_dopzak";?>';
    document.formv1.fir_dopstz.value = '<?php echo "$fir_dopstz";?>';
    document.formv1.fir_dopreg.value = '<?php echo "$fir_dopreg";?>';
    document.formv1.fir_mena1.value = '<?php echo "$fir_mena1";?>';
    document.formv1.fir_mena2.value = '<?php echo "$fir_mena2";?>';
    document.formv1.fir_kurz12.value = '<?php echo "$fir_kurz12";?>';
    document.formv1.fir_xdp01.value = '1';
    document.formv1.fir_xdp02.value = '<?php echo "$fir_xdp02";?>';
    document.formv1.fir_xdp03.value = '<?php echo "$fir_xdp03";?>';
    document.formv1.fir_xdp04.value = '<?php echo "$fir_xdp04";?>';
    document.formv1.fir_xdp05.value = '<?php echo "$fir_xdp05";?>';
    document.formv1.fir_xdp06.value = '<?php echo "$fir_xdp06";?>';
    document.formv1.fir_fakprf.value = '<?php echo "$fir_fakprf";?>';
    }
<?php
//koniec uprava
  }
?>

<?php
//uprava udaje majetok
  if ( $copern == 82 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.fir_dph1.value = '<?php echo "$fir_dph1";?>';
    document.formv1.fir_dph2.value = '<?php echo "$fir_dph2";?>';
    document.formv1.fir_dph3.value = '<?php echo "$fir_dph3";?>';
    document.formv1.fir_dph4.value = '<?php echo "$fir_dph4";?>';
    document.formv1.fir_mena1.value = '<?php echo "$fir_mena1";?>';
    document.formv1.fir_mena2.value = '<?php echo "$fir_mena2";?>';
    document.formv1.fir_kurz12.value = '<?php echo "$fir_kurz12";?>';
    document.formv1.fir_majx01.value = '<?php echo "$fir_majx01";?>';
    document.formv1.fir_majx02.value = '<?php echo "$fir_majx02";?>';
    document.formv1.fir_majx03.value = '<?php echo "$fir_majx03";?>';
    document.formv1.fir_majx04.value = '<?php echo "$fir_majx04";?>';
    document.formv1.fir_majx05.value = '<?php echo "$fir_majx05";?>';
    }
<?php
//koniec uprava
  }
?>

<?php
//uprava udaje vyroba
  if ( $copern == 42 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.fir_xvr01.value = '<?php echo "$fir_xvr01";?>';

    }
<?php
//koniec uprava
  }
?>


<?php
//uprava udaje ucto
  if ( $copern == 92 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.fir_dph1.value = '<?php echo "$fir_dph1";?>';
    document.formv1.fir_dph2.value = '<?php echo "$fir_dph2";?>';
    document.formv1.fir_dph3.value = '<?php echo "$fir_dph3";?>';
    document.formv1.fir_dph4.value = '<?php echo "$fir_dph4";?>';
    document.formv1.fir_pokpri.value = '<?php echo "$fir_pokpri";?>';
    document.formv1.fir_pokvyd.value = '<?php echo "$fir_pokvyd";?>';
    document.formv1.fir_mena1.value = '<?php echo "$fir_mena1";?>';
    document.formv1.fir_mena2.value = '<?php echo "$fir_mena2";?>';
    document.formv1.fir_kurz12.value = '<?php echo "$fir_kurz12";?>';
    document.formv1.fir_uctx01.value = '<?php echo "$fir_uctx01";?>';
    document.formv1.fir_uctx02.value = '<?php echo "$fir_uctx02";?>';
    document.formv1.fir_uctx03.value = '<?php echo "$fir_uctx03";?>';
    document.formv1.fir_uctx04.value = '<?php echo "$fir_uctx04";?>';
    document.formv1.fir_uctx05.value = '<?php echo "$fir_uctx05";?>';
    document.formv1.fir_uctx06.value = '<?php echo "$fir_uctx06";?>';
    document.formv1.fir_uctx07.value = '<?php echo "$fir_uctx07";?>';
    document.formv1.fir_uctx08.value = '<?php echo "$fir_uctx08";?>';
    document.formv1.fir_uctx09.value = '<?php echo "$fir_uctx09h";?>';
    document.formv1.fir_uctx10.value = '<?php echo "$fir_uctx10";?>';
    document.formv1.fir_uctx11.value = '<?php echo "$fir_uctx11";?>';
    document.formv1.fir_uctx12.value = '<?php echo "$fir_uctx12";?>';
    document.formv1.fir_uctx13.value = '<?php echo "$fir_uctx13";?>';
    document.formv1.fir_uctx14.value = '<?php echo "$fir_uctx14";?>';
    document.formv1.fir_uctx15.value = '<?php echo "$fir_uctx15";?>';
    document.formv1.fir_xvr05.value = '<?php echo "$fir_xvr05";?>';
    document.formv1.fir_allx15.value = '<?php echo "$fir_allx15";?>';
    document.formv1.fir_allx14.value = '<?php echo "$fir_allx14";?>';
    document.formv1.fir_allx13.value = '<?php echo "$fir_allx13";?>';

    document.formv1.fir_fakodb.value = '<?php echo "$fir_fakodb";?>';
    document.formv1.fir_fakdod.value = '<?php echo "$fir_fakdod";?>';
    }
<?php
//koniec uprava
  }
?>

<?php
//uprava udaje mzdy
  if ( $copern == 192 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.fir_dph1.value = '<?php echo "$fir_dph1";?>';
    document.formv1.fir_dph2.value = '<?php echo "$fir_dph2";?>';
    document.formv1.fir_dph3.value = '<?php echo "$fir_dph3";?>';
    document.formv1.fir_dph4.value = '<?php echo "$fir_dph4";?>';
    document.formv1.fir_mena1.value = '<?php echo "$fir_mena1";?>';
    document.formv1.fir_mena2.value = '<?php echo "$fir_mena2";?>';
    document.formv1.fir_kurz12.value = '<?php echo "$fir_kurz12";?>';
    document.formv1.fir_mzdx01.value = '<?php echo "$fir_mzdx01";?>';
    document.formv1.fir_mzdx02.value = '<?php echo "$fir_mzdx02";?>';
    document.formv1.fir_mzdx03.value = '<?php echo "$fir_mzdx03";?>';
    document.formv1.fir_mzdx04.value = '<?php echo "$fir_mzdx04";?>';
    document.formv1.fir_mzdx06.value = '<?php echo "$fir_mzdx06";?>';
    document.formv1.fir_mzdx07.value = '<?php echo "$fir_mzdx07";?>';
    }
<?php
//koniec uprava
  }
?>

<?php
//nie uprava
  if ( $copern != 2 AND $copern != 12 AND $copern != 22 AND $copern != 32 AND $copern != 82 AND $copern != 92 AND $copern != 192 AND $copern != 42)
  { 
?>
    function ObnovUI()
    {


    }
<?php
//koniec uprava
  }
?>

    function UlozHlav()
    {
  var h_odb = 0;
  if( document.formv1.h_odb.checked ) h_odb=1;
  var h_dod = 0;
  if( document.formv1.h_dod.checked ) h_dod=1;
  var h_pok = 0;
  if( document.formv1.h_pok.checked ) h_pok=1;
  var h_ban = 0;
  if( document.formv1.h_ban.checked ) h_ban=1;
  var h_vse = 0;
  if( document.formv1.h_vse.checked ) h_vse=1;

window.open('../cis/ufir.php?copern=30191&drupoh=1&page=1&h_odb=' + h_odb + '&h_dod=' + h_dod + '&h_pok=' + h_pok + '&h_ban=' + h_ban + '&h_vse=' + h_vse + '&xxx=1','_self')
    }

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1 ) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function danoveUcty()
  {
   window.open('../cis/ufirdalsie.php?copern=1&drupoh=1&page=1','_blank', 'width=1180, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')
  }
</script>
</HEAD>
<BODY class="white" onload="ObnovUI();">

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  
<?php
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 ) echo " Údaje o firme";
  if ( $copern == 11 OR $copern == 12 OR $copern == 13  ) echo " Parametre programu sklad";
  if ( $copern == 21 OR $copern == 22 OR $copern == 23  ) echo " Parametre programu faktúry";
  if ( $copern == 31 OR $copern == 32 OR $copern == 33  ) echo " Parametre programu doprava";
  if ( $copern == 81 OR $copern == 82 OR $copern == 83  ) echo " Parametre programu majetok";
  if ( $copern == 41 OR $copern == 42 OR $copern == 43  ) echo " Parametre programu vıroba";
  if ( $copern == 91 OR $copern == 92 OR $copern == 93  ) echo " Parametre programu úètovníctvo";
  if ( $copern == 191 OR $copern == 192 OR $copern == 193  ) echo " Parametre programu Mzdy a personalistika";
?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//zobraz nastavene udaje o firme
if ( $copern == 1 OR $copern == 3 )
    {
$sqd = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$vysledod = mysql_query($sqd);
$riadod=mysql_fetch_object($vysledod);

$sql = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
$vysledok = mysql_query($sql);
$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufir.php?copern=2" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="bmenu" colspan="3" align="right">
JPG hlavièka
<a href="#" onClick="window.open('ulozhlavicku.php?copern=999&drupoh=1&page=1','_self')">
<img src='../obr/import.png' width=10 height=10 border=1 title='Uloi JPG hlavièku' ></a>

ODB<input type="checkbox" name="h_odb" value="1" />
DOD<input type="checkbox" name="h_dod" value="1" />
POK<input type="checkbox" name="h_pok" value="1" />
BAN<input type="checkbox" name="h_ban" value="1" />
VSE<input type="checkbox" name="h_vse" value="1" />

<?php
if (!File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickaodb.nie"))
 { 
?>
<script type="text/javascript">
document.formv1.h_odb.checked = "checked";
</script>
<?php 
 }
?>
<?php
if (!File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickadod.nie"))
 { 
?>
<script type="text/javascript">
document.formv1.h_dod.checked = "checked";
</script>
<?php 
 }
?>
<?php
if (!File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickapok.nie"))
 { 
?>
<script type="text/javascript">
document.formv1.h_pok.checked = "checked";
</script>
<?php 
 }
?>
<?php
if (!File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickaban.nie"))
 { 
?>
<script type="text/javascript">
document.formv1.h_ban.checked = "checked";
</script>
<?php 
 }
?>
<?php
if (!File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickavse.nie"))
 { 
?>
<script type="text/javascript">
document.formv1.h_vse.checked = "checked";
</script>
<?php 
 }
?>

<a href="#" onClick="UlozHlav();">
<img src='../obr/ok.png' width=10 height=10 border=1 title='Uloi nastavenie JPG hlavièiek dokladov' ></a>
</td>
<td class="bmenu" colspan="3" align="right">
<?php if ( $ajprepocetnask != 1  ) { echo "Prepoèet na Sk NIE na dokladoch"; } ?>
<?php if ( $ajprepocetnask == 1  ) { echo "Prepoèet na Sk ÁNO na dokladoch"; } ?>
<a href="#" onClick="window.open('../cis/ufir.php?copern=20191&drupoh=1&page=1','_self')">
<img src='../obr/ok.png' width=10 height=10 border=1 title='Prepoèet na Sk na pokladniènıch dokladoch a faktúrach' ></a>
</td>
</tr>
<tr>
<td class="fmenu" width="10%">IÈO:</td>
<td class="fmenu" width="24%"><?php echo $riadok->fico;?></td>
<td class="fmenu" width="10%">DIÈ:</td>
<td class="fmenu" width="23%"><?php echo $riadok->fdic;?></td>
<td class="fmenu" width="10%">IÈDPH:</td>
<td class="fmenu" width="23%"><?php echo $riadok->ficd;?></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Názov firmy:</td>
<td class="fmenu"><?php echo $riadok->fnaz;?></td>
</tr>
<tr>
<td class="fmenu">Sídlo ulica:</td>
<td class="fmenu"><?php echo $riadok->fuli;?></td>
<td class="fmenu">Èíslo:</td>
<td class="fmenu"><?php echo $riadok->fcdm;?></td>
</tr>
<tr>
<td class="fmenu">Sídlo PSÈ:</td>
<td class="fmenu"><?php echo $riadok->fpsc;?></td>
<td class="fmenu">Sídlo mesto:</td>
<td class="fmenu"><?php echo $riadok->fmes;?></td>
<td class="fmenu">Sídlo štát:</td>
<td class="fmenu"><?php echo $riadod->fstat;?></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Telefón:</td>
<td class="fmenu"><?php echo $riadok->ftel;?></td>
<td class="fmenu">Fax:</td>
<td class="fmenu"><?php echo $riadok->ffax;?></td>
<td class="fmenu">Web:</td>
<td class="fmenu"><?php echo $riadok->fwww;?></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Email 1:</td>
<td class="fmenu"><?php echo $riadok->fem1;?></td>
<td class="fmenu">Email 2</td>
<td class="fmenu"><?php echo $riadok->fem2;?></td>
<td class="fmenu">Email 3</td>
<td class="fmenu"><?php echo $riadok->fem3;?></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Banka 1 úèet:</td>
<td class="fmenu"><?php echo $riadok->fuc1;?></td>
<td class="fmenu">Banka 1 IBAN:</td>
<td class="fmenu"><?php echo $riadok->fib1;?></td>
<td class="fmenu">NUM1:<?php echo $riadok->fnm1;?></td>
<td class="fmenu">F<?php echo $riadok->uc1fk;?></td>
</tr>
<tr>
<td class="fmenu">Banka 1 názov:</td>
<td class="fmenu"><?php echo $riadok->fnb1;?></td>
<td class="fmenu">Banka 1 sídlo:</td>
<td class="fmenu"><?php echo $riadok->fsb1;?></td>
<td class="fmenu">swift1:<?php echo $riadok->fsw1;?></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Banka 2 úèet:</td>
<td class="fmenu"><?php echo $riadok->fuc2;?></td>
<td class="fmenu">Banka 2 IBAN:</td>
<td class="fmenu"><?php echo $riadok->fib2;?></td>
<td class="fmenu">NUM2:<?php echo $riadok->fnm2;?></td>
<td class="fmenu">F<?php echo $riadok->uc2fk;?></td>
</tr>
<tr>
<td class="fmenu">Banka 2 názov:</td>
<td class="fmenu"><?php echo $riadok->fnb2;?></td>
<td class="fmenu">Banka 2 sídlo:</td>
<td class="fmenu"><?php echo $riadok->fsb2;?></td>
<td class="fmenu">swift2:<?php echo $riadok->fsw2;?></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Banka 3 úèet:</td>
<td class="fmenu"><?php echo $riadok->fuc3;?></td>
<td class="fmenu">Banka 3 IBAN:</td>
<td class="fmenu"><?php echo $riadok->fib3;?></td>
<td class="fmenu">NUM3:<?php echo $riadok->fnm3;?></td>
<td class="fmenu">F<?php echo $riadok->uc3fk;?></td>
</tr>
<tr>
<td class="fmenu">Banka 3 názov:</td>
<td class="fmenu"><?php echo $riadok->fnb3;?></td>
<td class="fmenu">Banka 3 sídlo:</td>
<td class="fmenu"><?php echo $riadok->fsb3;?></td>
<td class="fmenu">swift3:<?php echo $riadok->fsw3;?></td>
</tr>
<tr>
<td class="fmenu" colspan="1">Registrovanı:
<td class="fmenu" colspan="2"><?php echo $riadok->obreg;?></td>
</tr>
<tr>
<td class="fmenu" colspan="1">Daòovı úrad:
<td class="fmenu" colspan="2"><?php echo $riadok->uctt01;?></td>
<td class="fmenu" colspan="1">SK NACE: <?php echo $riadok->mzdt03;?></td>
</tr>
<tr>
<td class="fmenu" colspan="1">Právna forma :
<td class="fmenu" colspan="3"> text <?php echo $riadok->uctt02;?> - èíslo <?php echo $riadok->uctt03;?></td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="4">Konate¾ meno,priezvisko: 
<?php echo $riadok->uctt05;?> a jeho telefón:
<?php echo $riadok->uctt04;?></td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="4">Vıkazy zostavil meno,priezvisko: 
<?php echo $riadok->mzdt05;?> a jeho telefón:
<?php echo $riadok->mzdt04;?></td>
</tr>

<td class="fmenu" colspan="2">Èíslo firmy minulı rok: <?php echo $riadok->allx11;?> / rok <?php echo $riadok->allx12;?></td>
<td class="bmenu" colspan="2">0=iadna</td>
</tr>


<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Upravi údaje"></td>
<td class="bmenu" colspan="3" align="right">
<a href="#" onClick="danoveUcty();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Nastavenie úètov pre úhradu daní a ïalších údajov o firme." >úèty DÚ a ïalšie údaje</a>
</td>
</tr>
</FORM>

</table>
<?php
mysql_free_result($vysledok);
    }
//koniec zobrazenia  udaje o firme
?>



<?php
//upravy  udaje o firme
if ( $copern == 2 )
    {
$sqd = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$vysledod = mysql_query($sqd);
$riadod=mysql_fetch_object($vysledod);

//$sql = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
//$vysledok = mysql_query($sql);
//$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufir.php?copern=3" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">IÈO:</td>
<td class="fmenu" width="24%">
<input type="text" name="fir_fico" id="fir_fico" /></td>
<td class="fmenu" width="10%">DIÈ:</td>
<td class="fmenu" width="23%">
<input type="text" name="fir_fdic" id="fir_fdic" /></td>
<td class="fmenu" width="10%">IÈDPH:</td>
<td class="fmenu" width="23%">
<input type="text" name="fir_ficd" id="fir_ficd" /></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Názov firmy:</td>
<td class="fmenu">
<input type="text" name="fir_fnaz" id="fir_fnaz" /></td>
</tr>
<tr>
<td class="fmenu">Sídlo ulica:</td>
<td class="fmenu">
<input type="text" name="fir_fuli" id="fir_fuli" /></td>
<td class="fmenu">Èíslo:</td>
<td class="fmenu">
<input type="text" name="fir_fcdm" id="fir_fcdm" /></td>
</tr>
<tr>
<td class="fmenu">Sídlo PSÈ:</td>
<td class="fmenu">
<input type="text" name="fir_fpsc" id="fir_fpsc" /></td>
<td class="fmenu">Sídlo mesto:</td>
<td class="fmenu">
<input type="text" name="fir_fmes" id="fir_fmes" /></td>
<td class="fmenu">Sídlo štát:</td>
<td class="fmenu">
<input type="text" name="fir_fstat" id="fir_fstat" value="<?php echo $riadod->fstat; ?>"/></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Telefón:</td>
<td class="fmenu">
<input type="text" name="fir_ftel" id="fir_ftel" /></td>
<td class="fmenu">Fax:</td>
<td class="fmenu">
<input type="text" name="fir_ffax" id="fir_ffax" /></td>
<td class="fmenu">Web:</td>
<td class="fmenu">
<input type="text" name="fir_fwww" id="fir_fwww" /></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Email 1:</td>
<td class="fmenu">
<input type="text" name="fir_fem1" id="fir_fem1" /></td>
<td class="fmenu">Email 2</td>
<td class="fmenu">
<input type="text" name="fir_fem2" id="fir_fem2" /></td>
<td class="fmenu">Email 3</td>
<td class="fmenu">
<input type="text" name="fir_fem3" id="fir_fem3" /></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Banka 1 úèet:</td>
<td class="fmenu">
<input type="text" name="fir_fuc1" id="fir_fuc1" size="38" maxsize="30" /></td>
<td class="fmenu">Banka 1 IBAN:</td>
<td class="fmenu">
<input type="text" name="fir_fib1" id="fir_fib1" size="38" maxsize="30" /></td>
<td class="fmenu">NUM1:<input type="text" name="fir_fnm1" id="fir_fnm1" size="5"/></td>
<td class="fmenu">
F<input type="checkbox" name="fir_uc1fk" value="1"  />
<?php
if ( $fir_uc1fk == 1 )
   {
?>
<script type="text/javascript">
document.formv1.fir_uc1fk.checked = "checked";
</script>
<?php
   }
?>
</td>
</tr>
<tr>
<td class="fmenu">Banka 1 názov:</td>
<td class="fmenu">
<input type="text" name="fir_fnb1" id="fir_fnb1" /></td>
<td class="fmenu">Banka 1 sídlo:</td>
<td class="fmenu">
<input type="text" name="fir_fsb1" id="fir_fsb1" /></td>
<td class="fmenu">swift1:<input type="text" name="fir_fsw1" id="fir_fsw1" size="10"/></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Banka 2 úèet:</td>
<td class="fmenu">
<input type="text" name="fir_fuc2" id="fir_fuc2" size="38" maxsize="30" /></td>
<td class="fmenu">Banka 2 IBAN:</td>
<td class="fmenu">
<input type="text" name="fir_fib2" id="fir_fib2" size="38" maxsize="30" /></td>
<td class="fmenu">NUM2:<input type="text" name="fir_fnm2" id="fir_fnm2"  size="5"/></td>
<td class="fmenu">
F<input type="checkbox" name="fir_uc2fk" value="1"  />
<?php
if ( $fir_uc2fk == 1 )
   {
?>
<script type="text/javascript">
document.formv1.fir_uc2fk.checked = "checked";
</script>
<?php
   }
?>
</td>
</tr>
<tr>
<td class="fmenu">Banka 2 názov:</td>
<td class="fmenu">
<input type="text" name="fir_fnb2" id="fir_fnb2" /></td>
<td class="fmenu">Banka 2 sídlo:</td>
<td class="fmenu">
<input type="text" name="fir_fsb2" id="fir_fsb2" /></td>
<td class="fmenu">swift2:<input type="text" name="fir_fsw2" id="fir_fsw2" size="10"/></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Banka 3 úèet:</td>
<td class="fmenu">
<input type="text" name="fir_fuc3" id="fir_fuc3" size="38" maxsize="30" /></td>
<td class="fmenu">Banka 3 IBAN:</td>
<td class="fmenu">
<input type="text" name="fir_fib3" id="fir_fib3" size="38" maxsize="30" /></td>
<td class="fmenu">NUM3:<input type="text" name="fir_fnm3" id="fir_fnm3"  size="5"/></td>
<td class="fmenu">
F<input type="checkbox" name="fir_uc3fk" value="1"  />
<?php
if ( $fir_uc3fk == 1 )
   {
?>
<script type="text/javascript">
document.formv1.fir_uc3fk.checked = "checked";
</script>
<?php
   }
?>
</td>
</tr>
<tr>
<td class="fmenu">Banka 3 názov:</td>
<td class="fmenu">
<input type="text" name="fir_fnb3" id="fir_fnb3" /></td>
<td class="fmenu">Banka 3 sídlo:</td>
<td class="fmenu">
<input type="text" name="fir_fsb3" id="fir_fsb3" /></td>
<td class="fmenu">swift3:<input type="text" name="fir_fsw3" id="fir_fsw3" size="10"/></td>
</tr>
<tr>
<td class="fmenu" colspan="1">Registrovanı:
<td class="fmenu" colspan="2"><input type="text" name="fir_obreg" id="fir_obreg" size="60"/></td>
</tr>
<tr>
<td class="fmenu" colspan="1">Daòovı úrad:
<td class="fmenu" colspan="2"><input type="text" name="fir_uctt01" id="fir_uctt01" size="40"/></td>
<td class="fmenu" colspan="1">SK NACE: <input type="text" name="fir_mzdt03" id="fir_mzdt03" onkeyup="CiarkaNaBodku(this);" size="20"/> zadávajte v tvare napr. 95.11.0</td>
</tr>
<tr>
<td class="fmenu" colspan="1">Právna forma :
<td class="fmenu" colspan="3"> text <input type="text" name="fir_uctt02" id="fir_uctt02" size="40"/> - èíslo <input type="text" name="fir_uctt03" id="fir_uctt03" size="3"/>
<img src="../obr/info.png" title="Èíselník právnych foriem" onclick="window.open('../cis/pravne_formy_ciselnik.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');" height="18" width="18">
</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="4">Konate¾ meno,priezvisko: 
<input type="text" name="fir_uctt05" id="fir_uctt05" size="30"/> a jeho telefón:
<input type="text" name="fir_uctt04" id="fir_uctt04" /> v tvare 0905/665881 alebo 034/6512227</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="4">Vıkazy zostavil meno,priezvisko: 
<input type="text" name="fir_mzdt05" id="fir_mzdt05" size="30"/> a jeho telefón:
<input type="text" name="fir_mzdt04" id="fir_mzdt04" /> v tvare 0905/665881 alebo 034/6512227</td>
</tr>

<tr>
<td class="fmenu" colspan="2">Èíslo firmy minulı rok: <input type="text" name="fir_allx11" id="fir_allx11" size="4"/>
 / rok <input type="text" name="fir_allx12" id="fir_allx12" size="4"/>
</td>
<td class="bmenu" colspan="2">0=iadna</td>
</tr>

<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloi úpravy"></td>
</tr>
</FORM>

<FORM name="formv2" class="obyc" method="post" action="ufir.php?copern=1" >
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Koniec neuloi"></td>
</tr>
</FORM>

</table>
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav  udaje o firme
?>


<?php
//zobraz nastavene parametre skladu
if ( $copern == 11 OR $copern == 13 )
    {
$sql = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
$vysledok = mysql_query($sql);
$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufir.php?copern=12" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">DPH è.1:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph1;?></td>
<td class="fmenu" width="10%">DPH è.2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph2;?></td>
<td class="fmenu" width="10%">DPH è.3:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph3;?></td>
<td class="fmenu" width="10%">DPH è.4:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph4;?></td>
</tr>
<tr>
<td class="fmenu" width="10%">Mena è.1:</td>
<td class="fmenu" width="15%"><?php echo $riadok->mena1;?></td>
<td class="fmenu" width="10%">Mena è.2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->mena2;?></td>
<td class="fmenu" width="10%">Kurz 1/2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->kurz12;?></td>
</tr>
<tr></tr><tr></tr>
<tr>
<td class="fmenu" colspan="8">Následujúce èíslo:</td>
</tr>
<tr>
<td class="fmenu" width="10%">Príjemky:</td>
<td class="fmenu" width="15%"><?php echo $riadok->sklcpr;?></td>
<td class="fmenu" width="10%">Vıdajky:</td>
<td class="fmenu" width="15%"><?php echo $riadok->sklcvd;?></td>
<td class="fmenu" width="10%">Presunky:</td>
<td class="fmenu" width="15%"><?php echo $riadok->sklcps;?></td>
</tr>
<tr></tr><tr></tr>
<tr>
<td class="fmenu" colspan="2">Minimálne èíslo materiálu:</td>
<td class="fmenu"><?php echo $riadok->sklcis;?></td>
</tr>
<tr>
<td class="fmenu" colspan="2">Skladové stredisko:</td>
<td class="fmenu" width="5%"><?php echo $riadok->sklstr;?></td>
</tr>
<tr>
<td class="fmenu" colspan="2">Skladová zákazka:</td>
<td class="fmenu" width="5%"><?php echo $riadok->sklzak;?></td>
</tr>
<tr>
<td class="fmenu" colspan="2">Ceny pri vıdaji:</td>
<td class="fmenu" ><?php echo "$riadok->xsk04";?><td class="bmenu" colspan="2">0=skutoèné, 1=priemerné</td>
</tr>
<tr>
<td class="fmenu" colspan="2">Ponuka materiálu pri vıdaji:</td>
<td class="fmenu" ><?php echo "$riadok->xsk02";?><td class="bmenu" colspan="2">0=aj nulové mnostvá, 1=len nenulové mnostvá</td>
</tr>
<tr>
<td class="fmenu" colspan="2">SKL pod¾a uívate¾a:</td>
<td class="fmenu" ><?php echo "$riadok->xsk05";?><td class="bmenu" colspan="2">0=nie, 1=prístup k skladom pod¾a prihlásenia uívate¾a</td>
</tr>
<tr>
<td class="fmenu" colspan="2">Èíslo firmy Úètovníctvo/Sklad</td>
<td class="fmenu" ><?php echo "$riadok->xsk03";?><td class="bmenu" colspan="2">0=rovnaké ako Sklad</td>
</tr>
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Upravi údaje"></td>
</tr>
</FORM>

</table>
<?php
mysql_free_result($vysledok);
    }
//koniec zobrazenia parametre skladu
?>

<?php
//upravy  parametre skladu
if ( $copern == 12 )
    {
//$sql = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
//$vysledok = mysql_query($sql);
//$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufir.php?copern=13" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">DPH è.1:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph1" id="fir_dph1" /></td>
<td class="fmenu" width="10%">DPH è.2:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph2" id="fir_dph2" /></td>
<td class="fmenu" width="10%">DPH è.3:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph3" id="fir_dph3" /></td>
<td class="fmenu" width="10%">DPH è.4:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph4" id="fir_dph4" /></td>
</tr>
<tr>
<td class="fmenu" width="10%">Mena è.1:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_mena1" id="fir_mena1" /></td>
<td class="fmenu" width="10%">Mena è.2:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_mena2" id="fir_mena2" /></td>
<td class="fmenu" width="10%">Kurz 1/2:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_kurz12" id="fir_kurz12" /></td>
</tr>
<tr></tr><tr></tr>
<tr>
<td class="fmenu" colspan="8">Následujúce èíslo:</td>
</tr>
<tr>
<td class="fmenu" width="10%">Príjemky:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_sklcpr" id="fir_sklcpr" /></td>
<td class="fmenu" width="10%">Vıdajky:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_sklcvd" id="fir_sklcvd" /></td>
<td class="fmenu" width="10%">Presunky:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_sklcps" id="fir_sklcps" /></td>
</tr>
<tr></tr><tr></tr>
<tr>
<td class="fmenu" colspan="2">Minimálne èíslo materiálu:</td>
<td class="fmenu"><input type="text" name="fir_sklcis" id="fir_sklcis" /></td>
</tr>
<tr>
<td class="fmenu" colspan="2"">Skladové stredisko:</td>
<td class="fmenu" width="5%"><input type="text" name="fir_sklstr" id="fir_sklstr" /></td>
</tr>
<tr>
<td class="fmenu" colspan="2">Skladová zákazka:</td>
<td class="fmenu" width="5%"><input type="text" name="fir_sklzak" id="fir_sklzak" /></td>
</tr>
<tr>
<td class="fmenu" colspan="2">Ceny pri vıdaji:</td>
<td class="fmenu" ><input type="text" name="fir_xsk04" id="fir_xsk04" /><td class="bmenu" colspan="2">0=skutoèné, 1=priemerné</td>
</tr>

<tr>
<td class="fmenu" colspan="2">Ponuka materiálu pri vıdaji:</td>
<td class="fmenu" ><input type="text" name="fir_xsk02" id="fir_xsk02" /><td class="bmenu" colspan="2">0=aj nulové mnostvá, 1=len nenulové mnostvá</td>
</tr>
<tr>
<td class="fmenu" colspan="2">SKL pod¾a uívate¾a:</td>
<td class="fmenu" ><input type="text" name="fir_xsk05" id="fir_xsk05" /><td class="bmenu" colspan="2">0=nie, 1=prístup k skladom pod¾a prihlásenia uívate¾a</td>
</tr>
<tr>
<td class="fmenu" colspan="2">Èíslo firmy Úètovníctvo/Sklad</td>
<td class="fmenu" width="5%"><input type="text" name="fir_xsk03" id="fir_xsk03" /><td class="bmenu" colspan="2">0=rovnaké ako Sklad</td>
</tr>

<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloi úpravy"></td>
</tr>
</FORM>

<FORM name="formv2" class="obyc" method="post" action="ufir.php?copern=11" >
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Koniec neuloi"></td>
</tr>
</FORM>

</table>
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav parametre skladu
?>

<?php
//zobraz nastavene parametre fakturacie
if ( $copern == 21 OR $copern == 23 )
    {
$sql = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
$vysledok = mysql_query($sql);
$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufir.php?copern=22" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">DPH è.1:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph1;?></td>
<td class="fmenu" width="10%">DPH è.2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph2;?></td>
<td class="fmenu" width="10%">DPH è.3:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph3;?></td>
<td class="fmenu" width="10%">DPH è.4:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph4;?></td>
</tr>
<tr>
<td class="fmenu" width="10%">Mena è.1:</td>
<td class="fmenu" width="15%"><?php echo $riadok->mena1;?></td>
<td class="fmenu" width="10%">Mena è.2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->mena2;?></td>
<td class="fmenu" width="10%">Kurz 1/2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->kurz12;?></td>
</tr>
<tr></tr><tr></tr>
<tr>
<td class="fmenu" colspan="8">Následujúce èíslo:</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Príjmového pokl.dokladu:</td>
<td class="fmenu" width="15%" colspan="2"><?php echo $riadok->pokpri;?></td>
<td class="fmenu" width="10%" colspan="2">Vıdavkového pokl.dokladu:</td>
<td class="fmenu" width="15%" colspan="2"><?php echo $riadok->pokvyd;?></td>
</tr>
<tr></tr><tr></tr>
<tr>
<td class="fmenu" colspan="8">Následujúce èíslo:</td>
</tr>
<tr>
<td class="fmenu" width="10%">Odber.faktúry:</td>
<td class="fmenu" width="15%"><?php echo $riadok->fakodb;?></td>
<td class="fmenu" width="10%">Dodav.faktúry:</td>
<td class="fmenu" width="15%"><?php echo $riadok->fakdod;?></td>
<td class="fmenu" width="10%">Objednávky:</td>
<td class="fmenu" width="15%"><?php echo $riadok->fakobj;?></td>
<td class="fmenu" width="10%">Predfaktúry:</td>
<td class="fmenu" width="15%"><?php echo $riadok->fakprf;?></td>
</tr>
<tr>
<td class="fmenu" width="10%">Dodacieho listu:</td>
<td class="fmenu" width="15%"><?php echo $riadok->fakdol;?></td>
<td class="fmenu" width="10%">Vnútropodnikovej faktúry:</td>
<td class="fmenu" width="15%"><?php echo $riadok->fakvnp;?></td>
</tr>
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">Druh faktúry:</td>
<td class="fmenu" width="15%"><?php echo $riadok->xfa01;?></td>
<td class="fmenu" colspan="2">0=textová, 1=slubová, 2=tovarová</td>
</tr>
<tr>
<td class="fmenu" width="15%">Zaokrúhlenie faktúry:</td>
<td class="fmenu" width="5%"><?php echo $riadok->xfa02;?></td>
<td class="fmenu" colspan="3">0=zaokrúhli na 1, 1=zaokrúhli na 0.1, 2=zaokrúhli na 0.01</td>
</tr>
<tr>
<td class="fmenu" width="15%">Hlavná pokladnica:</td>
<td class="fmenu" width="5%"><?php echo $riadok->xfa03;?></td>
<td class="fmenu" colspan="3">zadajte èíslo úètu</td>
</tr>
<tr>
<td class="fmenu" width="15%">Totoné èíslo Dokladu a Faktúry,Dodacieho listu...</td>
<td class="fmenu" width="5%"><?php echo $riadok->xfa04;?></td>
<td class="fmenu" colspan="3">1=áno,0=nie</td>
</tr>
<tr>
<td class="fmenu" width="10%">Fak.stredisko:</td>
<td class="fmenu" width="15%"><?php echo $riadok->fakstr;?></td>
</tr>
<tr>
<td class="fmenu" width="10%">Fak.zákazka:</td>
<td class="fmenu" width="15%"><?php echo $riadok->fakzak;?></td>
</tr>
<tr>
<td class="fmenu" width="10%">Fak.sklad:</td>
<td class="fmenu" width="15%"><?php echo $riadok->xfa05;?></td>
</tr>
<tr>
<td class="fmenu" width="10%">Fak.firma skladu:</td>
<td class="fmenu" width="15%"><?php echo $riadok->xfa06;?></td>
</tr>
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Upravi údaje"></td>
</tr>
</FORM>

</table>
<?php
mysql_free_result($vysledok);
    }
//koniec zobrazenia parametre fakturacie
?>

<?php
//upravy  parametre fakturacie
if ( $copern == 22 )
    {
//$sql = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
//$vysledok = mysql_query($sql);
//$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufir.php?copern=23" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">DPH è.1:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph1" id="fir_dph1" /></td>
<td class="fmenu" width="10%">DPH è.2:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph2" id="fir_dph2" /></td>
<td class="fmenu" width="10%">DPH è.3:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph3" id="fir_dph3" /></td>
<td class="fmenu" width="10%">DPH è.4:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph4" id="fir_dph4" /></td>
</tr>
<tr>
<td class="fmenu" width="10%">Mena è.1:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_mena1" id="fir_mena1" /></td>
<td class="fmenu" width="10%">Mena è.2:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_mena2" id="fir_mena2" /></td>
<td class="fmenu" width="10%">Kurz 1/2:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_kurz12" id="fir_kurz12" /></td>
</tr>
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" colspan="8">Následujúce èíslo:</td>
</tr>
<tr>
<td class="fmenu" width="10%">Príjmového pokl.dokladu:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_pokpri" id="fir_pokpri" /></td>
<td class="fmenu" width="10%">Vıdavkového pokl.dokladu:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_pokvyd" id="fir_pokvyd" /></td>
</tr>
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" colspan="8">Následujúce èíslo:</td>
</tr>
<tr>
<td class="fmenu" width="10%">Odber.faktúry:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_fakodb" id="fir_fakodb" /></td>
<td class="fmenu" width="10%">Dodáv.faktúry:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_fakdod" id="fir_fakdod" /></td>
<td class="fmenu" width="10%">Objednávky:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_fakobj" id="fir_fakobj" /></td>
<td class="fmenu" width="10%">Predfaktúry:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_fakprf" id="fir_fakprf" /></td>
</tr>
<tr>
<td class="fmenu" width="10%">Dodacieho listu:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_fakdol" id="fir_fakdol" /></td>
<td class="fmenu" width="10%">Vnútropodnikovej faktúry:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_fakvnp" id="fir_fakvnp" /></td>
</tr>

<tr>
<td class="fmenu" width="15%">Druh faktúry:</td>
<td class="fmenu" width="5%"><input type="text" name="fir_xfa01" id="fir_xfa01" /></td>
<td class="fmenu" colspan="2">0=textová, 1=slubová, 2=tovarová</td>
</tr>
<tr>
<td class="fmenu" width="15%">Zaokrúhlenie faktúry:</td>
<td class="fmenu" width="5%"><input type="text" name="fir_xfa02" id="fir_xfa02" /></td>
<td class="fmenu" colspan="3">0=zaokrúhli na 1, 1=zaokrúhli na 0.1, 2=zaokrúhli na 0.01</td>
</tr>
<tr>
<td class="fmenu" width="15%">Hlavná pokladnica:</td>
<td class="fmenu" width="5%"><input type="text" name="fir_xfa03" id="fir_xfa03" /></td>
<td class="fmenu" colspan="3">zadajte èíslo úètu</td>
</tr>
<tr>
<td class="fmenu" width="15%">Totoné èíslo Dokladu a Faktúry,Dodacieho listu...</td>
<td class="fmenu" width="5%"><input type="text" name="fir_xfa04" id="fir_xfa04" /></td>
<td class="fmenu" colspan="3">1=áno,0=nie</td>
</tr>
<tr>
<td class="fmenu" width="15%">Fak.stredisko:</td>
<td class="fmenu" width="5%"><input type="text" name="fir_fakstr" id="fir_fakstr" /></td>
</tr>
<tr>
<td class="fmenu" width="15%">Fak.zákazka:</td>
<td class="fmenu" width="5%"><input type="text" name="fir_fakzak" id="fir_fakzak" /></td>
</tr>
<tr>
<td class="fmenu" width="15%">Fak.sklad:</td>
<td class="fmenu" width="5%"><input type="text" name="fir_xfa05" id="fir_xfa05" /></td>
</tr>
<tr>
<td class="fmenu" width="15%">Fak.firma skladu:</td>
<td class="fmenu" width="5%"><input type="text" name="fir_xfa06" id="fir_xfa06" /></td>
</tr>
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloi úpravy"></td>
</tr>
</FORM>

<FORM name="formv2" class="obyc" method="post" action="ufir.php?copern=21" >
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Koniec neuloi"></td>
</tr>
</FORM>

</table>
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav parametre fakturacie
?>

<?php
//zobraz nastavene parametre doprava
if ( $copern == 31 OR $copern == 33 )
    {
$sql = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
$vysledok = mysql_query($sql);
$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufir.php?copern=32" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">DPH è.1:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph1;?></td>
<td class="fmenu" width="10%">DPH è.2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph2;?></td>
<td class="fmenu" width="10%">DPH è.3:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph3;?></td>
<td class="fmenu" width="10%">DPH è.4:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph4;?></td>
</tr>
<tr>
<td class="fmenu" width="10%">Mena è.1:</td>
<td class="fmenu" width="15%"><?php echo $riadok->mena1;?></td>
<td class="fmenu" width="10%">Mena è.2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->mena2;?></td>
<td class="fmenu" width="10%">Kurz 1/2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->kurz12;?></td>
</tr>
<tr></tr><tr></tr>
<tr>
<td class="fmenu" colspan="8">Následujúce èíslo:</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Príjmového pokl.dokladu:</td>
<td class="fmenu" width="15%" colspan="2"><?php echo $riadok->xdp05;?></td>
<td class="fmenu" width="10%" colspan="2">Vıdavkového pokl.dokladu:</td>
<td class="fmenu" width="15%" colspan="2"><?php echo $riadok->xdp06;?></td>
</tr>
<tr></tr><tr></tr>
<tr>
<td class="fmenu" colspan="8">Následujúce èíslo:</td>
</tr>
<tr>
<td class="fmenu" width="10%">Odber.faktúry:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dopfak;?></td>
<td class="fmenu" width="10%">Dodacieho listu:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dopdol;?></td>
<td class="fmenu" width="10%">Vnútropodnikovej faktúry:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dopvnp;?></td>
</tr>
<tr>
<td class="fmenu" width="10%">Záznamu o prev.vozidla:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dopstz;?></td>
<td class="fmenu" width="10%">Reg.pokladnice:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dopreg;?></td>
<td class="fmenu" width="10%">Objednávky:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dopobj;?></td>
<td class="fmenu" width="10%">Predfaktúry:</td>
<td class="fmenu" width="15%"><?php echo $riadok->fakprf;?></td>
</tr>
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">Druh faktúry:</td>
<td class="fmenu" width="15%"><?php echo $riadok->xdp01;?></td>
<td class="fmenu" colspan="2">0=textová, 1=slubová, 2=tovarová</td>
</tr>
<tr>
<td class="fmenu" width="15%">Zaokrúhlenie faktúry:</td>
<td class="fmenu" width="5%"><?php echo $riadok->xdp02;?></td>
<td class="fmenu" colspan="3">0=zaokrúhli na 1, 1=zaokrúhli na 0.1, 2=zaokrúhli na 0.01</td>
</tr>
<tr>
<td class="fmenu" width="15%">Hlavná pokladnica:</td>
<td class="fmenu" width="5%"><?php echo $riadok->xdp03;?></td>
<td class="fmenu" colspan="3">zadajte èíslo úètu</td>
</tr>
<tr>
<td class="fmenu" width="15%">Popis riadku v STZ:</td>
<td class="fmenu" width="5%"><?php echo $riadok->xdp04;?></td>
<td class="fmenu" colspan="3">0=nie,1=áno</td>
</tr>
<tr>
<td class="fmenu" width="10%">Dop.stredisko:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dopstr;?></td>
</tr>
<tr>
<td class="fmenu" width="10%">Dop.zákazka:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dopzak;?></td>
</tr>
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Upravi údaje"></td>
</tr>
</FORM>

</table>
<?php
mysql_free_result($vysledok);
    }
//koniec zobrazenia parametre doprava
?>

<?php
//upravy  parametre doprava
if ( $copern == 32 )
    {
//$sql = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
//$vysledok = mysql_query($sql);
//$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufir.php?copern=33" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">DPH è.1:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph1" id="fir_dph1" /></td>
<td class="fmenu" width="10%">DPH è.2:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph2" id="fir_dph2" /></td>
<td class="fmenu" width="10%">DPH è.3:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph3" id="fir_dph3" /></td>
<td class="fmenu" width="10%">DPH è.4:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph4" id="fir_dph4" /></td>
</tr>
<tr>
<td class="fmenu" width="10%">Mena è.1:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_mena1" id="fir_mena1" /></td>
<td class="fmenu" width="10%">Mena è.2:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_mena2" id="fir_mena2" /></td>
<td class="fmenu" width="10%">Kurz 1/2:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_kurz12" id="fir_kurz12" /></td>
</tr>
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" colspan="8">Následujúce èíslo:</td>
</tr>
<tr>
<td class="fmenu" width="10%">Príjmového pokl.dokladu:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_xdp05" id="fir_xdp05" /></td>
<td class="fmenu" width="10%">Vıdavkového pokl.dokladu:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_xdp06" id="fir_xdp06" /></td>
</tr>
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" colspan="8">Následujúce èíslo:</td>
</tr>
<tr>
<td class="fmenu" width="10%">Odber.faktúry:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dopfak" id="fir_dopfak" /></td>
<td class="fmenu" width="10%">Dodacieho listu:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dopdol" id="fir_dopdol" /></td>
<td class="fmenu" width="10%">Vnútropodnikovej faktúry:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dopvnp" id="fir_dopvnp" /></td>
</tr>
<tr>
<td class="fmenu" width="10%">Záznamu o prev.vozidla:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dopstz" id="fir_dopstz" /></td>
<td class="fmenu" width="10%">Reg.pokladnice:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dopreg" id="fir_dopreg" /></td>
<td class="fmenu" width="10%">Objednávky:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dopobj" id="fir_dopobj" /></td>
<td class="fmenu" width="10%">Predfaktúry:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_fakprf" id="fir_fakprf" /></td>
</tr>

<tr>
<td class="fmenu" width="15%">Druh faktúry:</td>
<td class="fmenu" width="5%"><input type="text" name="fir_xdp01" id="fir_xdp01" disabled="disabled"/></td>
<td class="fmenu" colspan="2">0=textová, 1=slubová, 2=tovarová</td>
</tr>
<tr>
<td class="fmenu" width="15%">Zaokrúhlenie faktúry:</td>
<td class="fmenu" width="5%"><input type="text" name="fir_xdp02" id="fir_xdp02" /></td>
<td class="fmenu" colspan="3">0=zaokrúhli na 1, 1=zaokrúhli na 0.1, 2=zaokrúhli na 0.01</td>
</tr>
<tr>
<td class="fmenu" width="15%">Hlavná pokladnica:</td>
<td class="fmenu" width="5%"><input type="text" name="fir_xdp03" id="fir_xdp03" /></td>
<td class="fmenu" colspan="3">zadajte èíslo úètu</td>
</tr>
<tr>
<td class="fmenu" width="15%">Popis riadku v STZ:</td>
<td class="fmenu" width="5%"><input type="text" name="fir_xdp04" id="fir_xdp04" /></td>
<td class="fmenu" colspan="3">0=nie,1=áno</td>
</tr>
<tr>
<td class="fmenu" width="15%">Fak.stredisko:</td>
<td class="fmenu" width="5%"><input type="text" name="fir_dopstr" id="fir_dopstr" /></td>
</tr>
<tr>
<td class="fmenu" width="15%">Fak.zákazka:</td>
<td class="fmenu" width="5%"><input type="text" name="fir_dopzak" id="fir_dopzak" /></td>
</tr>

<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloi úpravy"></td>
</tr>
</FORM>

<FORM name="formv2" class="obyc" method="post" action="ufir.php?copern=31" >
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Koniec neuloi"></td>
</tr>
</FORM>

</table>
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav parametre doprava
?>

<?php
//zobraz nastavene parametre majetok
if ( $copern == 81 OR $copern == 83 )
    {
$sql = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
$vysledok = mysql_query($sql);
$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufir.php?copern=82" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">DPH è.1:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph1;?></td>
<td class="fmenu" width="10%">DPH è.2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph2;?></td>
<td class="fmenu" width="10%">DPH è.3:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph3;?></td>
<td class="fmenu" width="10%">DPH è.4:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph4;?></td>
</tr>
<tr>
<td class="fmenu" width="10%">Mena è.1:</td>
<td class="fmenu" width="15%"><?php echo $riadok->mena1;?></td>
<td class="fmenu" width="10%">Mena è.2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->mena2;?></td>
<td class="fmenu" width="10%">Kurz 1/2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->kurz12;?></td>
</tr>
<tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Druh úèt.odpisov:</td>
<td class="fmenu" width="15%" colspan="2"><?php echo $riadok->majx01;?></td>
<td class="bmenu" width="15%" colspan="4">0=pri zaradení mesaènı odpis je roènı / poèet mesiacov do konca roka<br />1=pri zaradení mesaènı odpis je roènı / 12mesiacov</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Èíslo firmy Úètovníctvo/Majetok</td>
<td class="fmenu" width="15%" colspan="2"><?php echo "$riadok->majx02";?><td class="bmenu" colspan="2">0=rovnaké ako Majetok</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Parameter3:</td>
<td class="fmenu" width="15%" colspan="2"><?php echo $riadok->majx03;?></td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Parameter4:</td>
<td class="fmenu" width="15%" colspan="2"><?php echo $riadok->majx04;?></td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Parameter5:</td>
<td class="fmenu" width="15%" colspan="2"><?php echo $riadok->majx05;?></td>
</tr>

<tr></tr><tr></tr>
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Upravi údaje"></td>
</tr>
</FORM>

</table>
<?php
mysql_free_result($vysledok);
    }
//koniec zobrazenia parametre majetok
?>

<?php
//upravy  parametre majetok
if ( $copern == 82 )
    {
//$sql = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
//$vysledok = mysql_query($sql);
//$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufir.php?copern=83" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">DPH è.1:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph1" id="fir_dph1" /></td>
<td class="fmenu" width="10%">DPH è.2:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph2" id="fir_dph2" /></td>
<td class="fmenu" width="10%">DPH è.3:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph3" id="fir_dph3" /></td>
<td class="fmenu" width="10%">DPH è.4:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph4" id="fir_dph4" /></td>
</tr>
<tr>
<td class="fmenu" width="10%">Mena è.1:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_mena1" id="fir_mena1" /></td>
<td class="fmenu" width="10%">Mena è.2:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_mena2" id="fir_mena2" /></td>
<td class="fmenu" width="10%">Kurz 1/2:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_kurz12" id="fir_kurz12" /></td>
</tr>
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Druh úèt.odpisov:</td>
<td class="fmenu" width="15%" colspan="2"><input type="text" name="fir_majx01" id="fir_majx01" /></td>
<td class="bmenu" width="15%" colspan="4">0=pri zaradení mesaènı odpis je roènı / poèet mesiacov do konca roka<br />1=pri zaradení mesaènı odpis je roènı / 12mesiacov</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Èíslo firmy Úètovníctvo/Majetok:</td>
<td class="fmenu" width="15%" colspan="2"><input type="text" name="fir_majx02" id="fir_majx02" /></td>
<td class="bmenu" colspan="2">0=rovnaké ako Majetok</td>
</tr>

<tr>
<td class="fmenu" width="10%" colspan="2">Parameter3:</td>
<td class="fmenu" width="15%" colspan="2"><input type="text" name="fir_majx03" id="fir_majx03" /></td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Parameter4:</td>
<td class="fmenu" width="15%" colspan="2"><input type="text" name="fir_majx04" id="fir_majx04" /></td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Parameter5:</td>
<td class="fmenu" width="15%" colspan="2"><input type="text" name="fir_majx05" id="fir_majx05" /></td>
</tr>

<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloi úpravy"></td>
</tr>
</FORM>

<FORM name="formv2" class="obyc" method="post" action="ufir.php?copern=81" >
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Koniec neuloi"></td>
</tr>
</FORM>

</table>
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav parametre majetok
?>

<?php
//zobraz nastavene parametre vyroba
if ( $copern == 41 OR $copern == 43 )
    {
$sql = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
$vysledok = mysql_query($sql);
$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufir.php?copern=42" >

<tr>
<td class="bmenu" width="10%"> </td>
<td class="bmenu" width="15%"> </td>
<td class="bmenu" width="10%"> </td>
<td class="bmenu" width="15%"> </td>
<td class="bmenu" width="10%"> </td>
<td class="bmenu" width="15%"> </td>
<td class="bmenu" width="10%"> </td>
<td class="bmenu" width="15%"> </td>
</tr>
<tr>
<td class="bmenu" colspan="1">VYR pod¾a uívate¾a:</td>
<td class="fmenu" colspan="1"><?php echo "$riadok->xvr01";?></td>
<td class="bmenu" colspan="3">0=nie, 1=prístup k vırobe pod¾a prihlásenia uívate¾a</td>
</tr>

<tr><tr><tr><tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Upravi údaje"></td>
</tr>
</FORM>

</table>
<?php
mysql_free_result($vysledok);
    }
//koniec zobrazenia parametre vyroba
?>

<?php
//upravy  parametre vyroba
if ( $copern == 42 )
    {
//$sql = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
//$vysledok = mysql_query($sql);
//$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufir.php?copern=43" >

<tr>
<td class="bmenu" width="10%"> </td>
<td class="bmenu" width="15%"> </td>
<td class="bmenu" width="10%"> </td>
<td class="bmenu" width="15%"> </td>
<td class="bmenu" width="10%"> </td>
<td class="bmenu" width="15%"> </td>
<td class="bmenu" width="10%"> </td>
<td class="bmenu" width="15%"> </td>
</tr>

<tr>
<td class="bmenu" colspan="1">VYR pod¾a uívate¾a:</td>
<td class="fmenu" colspan="1"><input type="text" name="fir_xvr01" id="fir_xvr01" size="10" /></td>
<td class="bmenu" colspan="4">0=nie, 1=prístup k vırobe pod¾a prihlásenia uívate¾a</td>

</tr>

<tr><tr><tr><tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloi úpravy"></td>
</tr>
</FORM>

<FORM name="formv2" class="obyc" method="post" action="ufir.php?copern=41" >
<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Koniec neuloi"></td>
</tr>
</FORM>

</table>
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav parametre vyroba
?>


<?php
//zobraz nastavene parametre ucto
if ( $copern == 91 OR $copern == 93 )
    {
$sql = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
$vysledok = mysql_query($sql);
$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufir.php?copern=92" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">DPH è.1:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph1;?></td>
<td class="fmenu" width="10%">DPH è.2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph2;?></td>
<td class="fmenu" width="10%">DPH è.3:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph3;?></td>
<td class="fmenu" width="10%">DPH è.4:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph4;?></td>
</tr>
<tr>
<td class="fmenu" width="10%">Mena è.1:</td>
<td class="fmenu" width="15%"><?php echo $riadok->mena1;?></td>
<td class="fmenu" width="10%">Mena è.2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->mena2;?></td>
<td class="fmenu" width="10%">Kurz 1/2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->kurz12;?></td>
</tr>
<tr></tr><tr></tr>
<tr>
<td class="fmenu" colspan="8">Následujúce èíslo:</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Odber.faktúry:</td>
<td class="fmenu" width="15%" colspan="2"><?php echo $riadok->fakodb;?></td>
<td class="fmenu" width="10%" colspan="2">Dodav.faktúry:</td>
<td class="fmenu" width="15%" colspan="2"><?php echo $riadok->fakdod;?></td>
</tr>

<tr>
<td class="fmenu" width="10%" colspan="2">Príjmového pokl.dokladu:</td>
<td class="fmenu" width="15%" colspan="2"><?php echo $riadok->pokpri;?></td>
<td class="fmenu" width="10%" colspan="2">Vıdavkového pokl.dokladu:</td>
<td class="fmenu" width="15%" colspan="2"><?php echo $riadok->pokvyd;?></td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Bankového vıpisu:</td>
<td class="fmenu" width="15%" colspan="2"><?php echo $riadok->uctx04;?></td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Všeobecného dokladu druh1:</td>
<td class="fmenu" width="15%" colspan="2"><?php echo $riadok->uctx05;?></td>
<td class="fmenu" width="10%" colspan="2">Všeobecného dokladu druh2:</td>
<td class="fmenu" width="15%" colspan="2"><?php echo $riadok->uctx13;?></td>
</tr>


<tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Plátca DPH:</td>
<td class="fmenu" ><?php echo $riadok->uctx01;?></td><td class="bmenu" >0=nie,1=mesaènı,2=štvrroènı</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Text pri poloke POK,BAN,VŠE:</td>
<td class="fmenu" ><?php echo $riadok->uctx02;?></td><td class="bmenu" >0=nie,1=áno</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Úètovné pohyby EkoRobota:</td>
<td class="fmenu"><?php echo $riadok->uctx03;?></td><td class="bmenu" colspan="5"> 0=pre všetky firmy spoloèné, 1=pre kadú firmu samostatne</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">È.r. VZ pre rozdiel HV:</td>
<td class="fmenu"><?php echo $riadok->uctx06;?></td><td class="bmenu" colspan="5"> zadajte èíslo nákladového riadku vo Vıkaze ziskov kam má program zúètova rozdiel HV po zaokrúhlení Súvahy a VZ</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">È.r. Súvahy pre rozdiel HV po zaokrúhlení:</td>
<td class="fmenu"><?php echo $riadok->uctx15;?></td><td class="bmenu" colspan="5"> zadajte èíslo riadku aktív v Súvahe kam má program zúètova rozdiel HV po zaokrúhlení Súvahy </td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Dovoz z 3.krajín JCD:</td>
<td class="fmenu" ><?php echo $riadok->uctx07;?></td><td class="bmenu" >0=nie,1=áno</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Dodávate¾skı úèet pre JCD:</td>
<td class="fmenu" ><?php echo $riadok->uctx08;?></td><td class="bmenu" colspan="3"> zadajte èíslo úètu, na ktorı úètujete JCD ( 32160,37830... )</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Èíslovanie dokladov pod¾a analytiky:</td>
<td class="fmenu" ><?php echo $riadok->uctx09;?></td><td class="bmenu" colspan="5">
0=nie,1=následujúce èíslo dokladu pod¾a nastavenia v druhoch faktúr a pokl. a bankovıch dokladov, 
 2=ako 1 plus príjmové a vıdavkové pokladnièné doklady èíslované v jednej rade</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Èíslovanie pokladnice pod¾a úèt.mesiaca:</td>
<td class="fmenu" ><?php echo $riadok->uctx10;?></td><td class="bmenu" colspan="5">0=nie,x=(miesto sprava v rozsahu 3 a 7, kde v èísle dokladu bude èíslo mesiaca )</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Èíslovanie dodáv.faktúr pod¾a úèt.mesiaca:</td>
<td class="fmenu" ><?php echo $riadok->uctx11;?></td><td class="bmenu" colspan="5">0=nie,x=(miesto sprava v rozsahu 3 a 7, kde v èísle dokladu bude èíslo mesiaca )</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Èíslovanie všeob.dokladov pod¾a úèt.mesiaca:</td>
<td class="fmenu" ><?php echo $riadok->uctx12;?></td><td class="bmenu" colspan="5">0=nie,x=(miesto sprava v rozsahu 3 a 7, kde v èísle dokladu bude èíslo mesiaca )</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Viac èíselnıch radov pre jednu analytiku ODB,DOD:</td>
<td class="fmenu" ><?php echo $riadok->uctx14;?></td><td class="bmenu" >0=nie,1=áno</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Dátum pri poloke bank.dokladu:</td>
<td class="fmenu" ><?php echo $riadok->allx15;?></td><td class="bmenu" >0=nie,1=áno</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Tlaè rozpoètovej klasifikácie na dokladoch:</td>
<td class="fmenu" ><?php echo $riadok->allx14;?></td><td class="bmenu" >0=nie,1=áno</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Nahrávanie dátumov dodávate¾skıch faktúr:</td>
<td class="fmenu" ><?php echo $riadok->allx13;?></td><td class="bmenu" colspan="5" >0=Dátum_vyhotovenia-Enter-Dátum_odpoètu, 1=Dátum_vyhotovenia-Enter-Dátum_dodania-Enter-Dátum_odpoètu</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Odpoèet a odvod DPH po úhrade faktúry:</td>
<td class="fmenu" ><?php echo $riadok->xvr05;?></td><td class="bmenu" colspan="5" >0=nie, 1=áno</td>
</tr>
<tr></tr><tr></tr>

<tr></tr><tr></tr>
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Upravi údaje"></td>
</tr>
</FORM>

</table>
<?php
mysql_free_result($vysledok);
    }
//koniec zobrazenia parametre ucto
?>

<?php
//upravy  parametre ucto
if ( $copern == 92 )
    {
//$sql = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
//$vysledok = mysql_query($sql);
//$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufir.php?copern=93" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">DPH è.1:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph1" id="fir_dph1" /></td>
<td class="fmenu" width="10%">DPH è.2:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph2" id="fir_dph2" /></td>
<td class="fmenu" width="10%">DPH è.3:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph3" id="fir_dph3" /></td>
<td class="fmenu" width="10%">DPH è.4:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph4" id="fir_dph4" /></td>
</tr>
<tr>
<td class="fmenu" width="10%">Mena è.1:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_mena1" id="fir_mena1" /></td>
<td class="fmenu" width="10%">Mena è.2:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_mena2" id="fir_mena2" /></td>
<td class="fmenu" width="10%">Kurz 1/2:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_kurz12" id="fir_kurz12" /></td>
</tr>
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" colspan="8">Následujúce èíslo:</td>
</tr>
<tr>
<td class="fmenu" width="10%">Odber.faktúry:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_fakodb" id="fir_fakodb" /></td>
<td class="fmenu" width="10%">Dodáv.faktúry:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_fakdod" id="fir_fakdod" /></td>
</tr>
<tr>
<td class="fmenu" width="10%">Príjmového pokl.dokladu:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_pokpri" id="fir_pokpri" /></td>
<td class="fmenu" width="10%">Vıdavkového pokl.dokladu:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_pokvyd" id="fir_pokvyd" /></td>
</tr>
<tr>
<td class="fmenu" width="10%">Bankového vıpisu:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_uctx04" id="fir_uctx04" /></td>
</tr>
<tr>
<td class="fmenu" width="10%" >Všeobecného dokladu druh1:</td>
<td class="fmenu" width="15%" ><input type="text" name="fir_uctx05" id="fir_uctx05" /></td>
<td class="fmenu" width="10%" >Všeobecného dokladu druh2:</td>
<td class="fmenu" width="15%" ><input type="text" name="fir_uctx13" id="fir_uctx13" /></td>
</tr>
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Plátca DPH:</td>
<td class="fmenu" ><input type="text" name="fir_uctx01" id="fir_uctx01" /></td><td class="bmenu" >0=nie,1=mesaènı,2=štvrroènı</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Text pri poloke POK,BAN,VŠE:</td>
<td class="fmenu" ><input type="text" name="fir_uctx02" id="fir_uctx02" /></td><td class="bmenu" >0=nie,1=áno</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Úètovné pohyby EkoRobota:</td>
<td class="fmenu" ><input type="text" name="fir_uctx03" id="fir_uctx03" /></td>
<td class="bmenu" colspan="5"> 0=pre všetky firmy spoloèné, 1=pre kadú firmu samostatne</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">È.r. VZ pre rozdiel HV:</td>
<td class="fmenu"><input type="text" name="fir_uctx06" id="fir_uctx06" /></td><td class="bmenu" colspan="5"> zadajte èíslo nákladového riadku vo Vıkaze ziskov kam má program zúètova rozdiel HV po zaokrúhlení Súvahy a VZ</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">È.r. Súvahy pre rozdiel HV po zaokrúhlení:</td>
<td class="fmenu"><input type="text" name="fir_uctx15" id="fir_uctx15" /></td><td class="bmenu" colspan="5"> zadajte èíslo riadku aktív v Súvahe kam má program zúètova rozdiel HV po zaokrúhlení Súvahy </td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Dovoz z 3.krajín JCD:</td>
<td class="fmenu" ><input type="text" name="fir_uctx07" id="fir_uctx07" /></td><td class="bmenu" >0=nie,1=áno</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Dodávate¾skı úèet pre JCD:</td>
<td class="fmenu" ><input type="text" name="fir_uctx08" id="fir_uctx08" /></td><td class="bmenu" colspan="3"> zadajte èíslo úètu, na ktorı úètujete JCD ( 32160,37830... )</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Èíslovanie dokladov pod¾a analytiky:</td>
<td class="fmenu" ><input type="text" name="fir_uctx09" id="fir_uctx09" /></td><td class="bmenu" colspan="5">
0=nie,1=následujúce èíslo dokladu pod¾a nastavenia v druhoch faktúr a pokl. a bankovıch dokladov, 
 2=ako 1 plus príjmové a vıdavkové pokladnièné doklady èíslované v jednej rade</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Èíslovanie pokladnice pod¾a úèt.mesiaca:</td>
<td class="fmenu" ><input type="text" name="fir_uctx10" id="fir_uctx10" /></td><td class="bmenu" colspan="5">0=nie,x=(miesto sprava v rozsahu 3 a 7, kde v èísle dokladu bude èíslo mesiaca )</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Èíslovanie dodáv.faktúr pod¾a úèt.mesiaca:</td>
<td class="fmenu" ><input type="text" name="fir_uctx11" id="fir_uctx11" /></td><td class="bmenu" colspan="5">0=nie,x=(miesto sprava v rozsahu 3 a 7, kde v èísle dokladu bude èíslo mesiaca )</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Èíslovanie všeob.dokladov pod¾a úèt.mesiaca:</td>
<td class="fmenu" ><input type="text" name="fir_uctx12" id="fir_uctx12" /></td><td class="bmenu" colspan="5">0=nie,x=(miesto sprava v rozsahu 3 a 7, kde v èísle dokladu bude èíslo mesiaca )</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Viac èíselnıch radov pre jednu analytiku ODB,DOD:</td>
<td class="fmenu" ><input type="text" name="fir_uctx14" id="fir_uctx14" /></td><td class="bmenu" colspan="5">0=nie,1=áno</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Dátum pri poloke bank.dokladu:</td>
<td class="fmenu" ><input type="text" name="fir_allx15" id="fir_allx15" /></td><td class="bmenu" colspan="5">0=nie,1=áno</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Tlaè rozpoètovej klasifikácie na dokladoch:</td>
<td class="fmenu" ><input type="text" name="fir_allx14" id="fir_allx14" /></td><td class="bmenu" colspan="5">0=nie,1=áno</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Nahrávanie dátumov dodávate¾skıch faktúr:</td>
<td class="fmenu" ><input type="text" name="fir_allx13" id="fir_allx13" /></td><td class="bmenu" colspan="5">0=Dátum_vyhotovenia-Enter-Dátum_odpoètu, 1=Dátum_vyhotovenia-Enter-Dátum_dodania-Enter-Dátum_odpoètu</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Odpoèet a odvod DPH po úhrade faktúry:</td>
<td class="fmenu" ><input type="text" name="fir_xvr05" id="fir_xvr05" /></td><td class="bmenu" colspan="5" >0=nie, 1=áno</td>
</tr>
<tr></tr><tr></tr>

<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloi úpravy"></td>
</tr>
</FORM>

<FORM name="formv2" class="obyc" method="post" action="ufir.php?copern=91" >
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Koniec neuloi"></td>
</tr>
</FORM>

</table>
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav parametre ucto
?>

<?php
//zobraz nastavene parametre mzdy
if ( $copern == 191 OR $copern == 193 )
    {
$sql = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
$vysledok = mysql_query($sql);
$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufir.php?copern=192" >
<tr></tr><tr></tr>
<tr>
<td class="bmenu" colspan="8" align="right">
<a href="#" onClick="window.open('../cis/ufir.php?copern=10191&drupoh=1&page=1','_self')">
<img src='../obr/ok.png' width=10 height=10 border=0 title='Povol rušenie ostrého spracovania minulıch mesiacov' ></a>
</td>
</tr>
<tr>
<td class="fmenu" width="10%">DPH è.1:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph1;?></td>
<td class="fmenu" width="10%">DPH è.2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph2;?></td>
<td class="fmenu" width="10%">DPH è.3:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph3;?></td>
<td class="fmenu" width="10%">DPH è.4:</td>
<td class="fmenu" width="15%"><?php echo $riadok->dph4;?></td>
</tr>
<tr>
<td class="fmenu" width="10%">Mena è.1:</td>
<td class="fmenu" width="15%"><?php echo $riadok->mena1;?></td>
<td class="fmenu" width="10%">Mena è.2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->mena2;?></td>
<td class="fmenu" width="10%">Kurz 1/2:</td>
<td class="fmenu" width="15%"><?php echo $riadok->kurz12;?></td>
</tr>
<tr></tr><tr></tr>
<tr>
<td class="fmenu" colspan="8">Následujúce èíslo:</td>
</tr>

<tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Prepoèet mzdy z Trv.poloiek na odpracované:</td>
<td class="fmenu" ><?php echo $riadok->mzdx01;?></td><td class="bmenu" >0=hodiny,1=dni</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Sumár na vıpl.páske:</td>
<td class="fmenu" ><?php echo $riadok->mzdx02;?></td>
<td class="bmenu" colspan="4">0=nie,1=áno sumarizova dni,hodiny aj Eur DM 104a108,302 na vıpl.páske</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Zamestnanci s nepravidelnım príjmom:</td>
<td class="fmenu" ><?php echo $riadok->mzdx03;?></td><td class="bmenu" >0=nie,1=áno</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Neprepoèítava sumy v páske na Sk:</td>
<td class="fmenu" ><?php echo $riadok->mzdx04;?></td><td class="bmenu" >0=prepoèítava,1=neprepoèitáva</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Vıplatnı deò v mesiaci:</td>
<td class="fmenu" ><?php echo $riadok->mzdx06;?></td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Triedi pásky a vıplatnú listinu pod¾a vıplatného miesta:</td>
<td class="fmenu" ><?php echo $riadok->mzdx07;?></td><td class="bmenu" >0=nie,1=áno</td>
</tr>


<tr></tr><tr></tr>
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Upravi údaje"></td>
</tr>
</FORM>

</table>
<?php
mysql_free_result($vysledok);
    }
//koniec zobrazenia parametre mzdy
?>

<?php
//upravy  parametre mzdy
if ( $copern == 192 )
    {
//$sql = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
//$vysledok = mysql_query($sql);
//$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="ufir.php?copern=193" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">DPH è.1:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph1" id="fir_dph1" /></td>
<td class="fmenu" width="10%">DPH è.2:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph2" id="fir_dph2" /></td>
<td class="fmenu" width="10%">DPH è.3:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph3" id="fir_dph3" /></td>
<td class="fmenu" width="10%">DPH è.4:</td>
<td class="fmenu" width="15%">
<input type="text" name="fir_dph4" id="fir_dph4" /></td>
</tr>
<tr>
<td class="fmenu" width="10%">Mena è.1:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_mena1" id="fir_mena1" /></td>
<td class="fmenu" width="10%">Mena è.2:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_mena2" id="fir_mena2" /></td>
<td class="fmenu" width="10%">Kurz 1/2:</td>
<td class="fmenu" width="15%"><input type="text" name="fir_kurz12" id="fir_kurz12" /></td>
</tr>
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" colspan="8">Následujúce èíslo:</td>
</tr>

<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Prepoèet mzdy z Trv.poloiek na odpracované:</td>
<td class="fmenu" ><input type="text" name="fir_mzdx01" id="fir_mzdx01" /></td><td class="bmenu" >0=hodiny,1=dni</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Sumár na vıpl.páske:</td>
<td class="fmenu" ><input type="text" name="fir_mzdx02" id="fir_mzdx02" /></td>
<td class="bmenu" colspan="4">0=nie,1=áno sumarizova dni,hodiny aj Eur DM 104a108,302 na vıpl.páske</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Zamestnanci s nepravidelnım príjmom:</td>
<td class="fmenu" ><input type="text" name="fir_mzdx03" id="fir_mzdx03" /></td><td class="bmenu" >0=nie,1=áno</td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Neprepoèítava sumy v páske na Sk:</td>
<td class="fmenu" ><input type="text" name="fir_mzdx04" id="fir_mzdx04" /></td><td class="bmenu" >0=prepoèítava,1=neprepoèitáva</td>
</tr>

<tr>
<td class="fmenu" width="10%" colspan="2">Vıplatnı deò v mesiaci:</td>
<td class="fmenu" ><input type="text" name="fir_mzdx06" id="fir_mzdx06" /></td>
</tr>
<tr>
<td class="fmenu" width="10%" colspan="2">Triedi pásky a vıplatnú listinu pod¾a vıplatného miesta:</td>
<td class="fmenu" ><input type="text" name="fir_mzdx07" id="fir_mzdx07" /></td><td class="bmenu" >0=nie,1=áno</td>
</tr>
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloi úpravy"></td>
</tr>
</FORM>

<FORM name="formv2" class="obyc" method="post" action="ufir.php?copern=191" >
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Koniec neuloi"></td>
</tr>
</FORM>

</table>
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav parametre mzdy
?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
