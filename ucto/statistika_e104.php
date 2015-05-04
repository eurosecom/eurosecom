<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 2000;
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

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$stvrtrok=1;
$vyb_ump="1.".$kli_vrok;
$vyb_ums="2.".$kli_vrok;
$vyb_umk="3.".$kli_vrok;
$mesiac="03";
//vzdy napocitat udaje od 1.2009 do konca obdobia
if( $kli_vmes > 3 ) { $stvrtrok=2; $vyb_ump="1.".$kli_vrok; $vyb_ums="5.".$kli_vrok; $vyb_umk="6.".$kli_vrok; $mesiac="06"; }
if( $kli_vmes > 6 ) { $stvrtrok=3; $vyb_ump="1.".$kli_vrok; $vyb_ums="8.".$kli_vrok; $vyb_umk="9.".$kli_vrok; $mesiac="09"; }
if( $kli_vmes > 9 ) { $stvrtrok=4; $vyb_ump="1.".$kli_vrok; $vyb_ums="11.".$kli_vrok; $vyb_umk="12.".$kli_vrok; $mesiac="12"; }

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);

//pracovny subor statistika_e104
$sql = "SELECT * FROM F$kli_vxcf"."_statistika_e104 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = 'DROP TABLE F'.$kli_vxcf.'_statistika_e104';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_e104
(
   psys             INT,
   cinnost          VARCHAR(80),
   mod4103r01str    DECIMAL(10,0) DEFAULT 0,
   mod4103r02str    DECIMAL(10,0) DEFAULT 0,
   mod4103r03str    DECIMAL(10,0) DEFAULT 0,
   mod4103r04str    DECIMAL(10,0) DEFAULT 0,
   mod4103r05str    DECIMAL(10,0) DEFAULT 0,
   mod4103r06str    DECIMAL(10,0) DEFAULT 0,
   mod4103r07str    DECIMAL(10,0) DEFAULT 0,
   mod4103r08str    DECIMAL(10,0) DEFAULT 0,
   mod4103r09str    DECIMAL(10,0) DEFAULT 0,
   mod4103r10str    DECIMAL(10,0) DEFAULT 0,
   mod4103r11str    DECIMAL(10,0) DEFAULT 0,
   mod4103r12str    DECIMAL(10,0) DEFAULT 0,
   mod4103r13str    DECIMAL(10,0) DEFAULT 0,
   mod4103r14str    DECIMAL(10,0) DEFAULT 0,
   mod4103r15str    DECIMAL(10,0) DEFAULT 0,
   mod4103r01s1     DECIMAL(10,0) DEFAULT 0,
   mod4103r02s1     DECIMAL(10,0) DEFAULT 0,
   mod4103r03s1     DECIMAL(10,0) DEFAULT 0,
   mod4103r04s1     DECIMAL(10,0) DEFAULT 0,
   mod4103r05s1     DECIMAL(10,0) DEFAULT 0,
   mod4103r06s1     DECIMAL(10,0) DEFAULT 0,
   mod4103r07s1     DECIMAL(10,0) DEFAULT 0,
   mod4103r08s1     DECIMAL(10,0) DEFAULT 0,
   mod4103r09s1     DECIMAL(10,0) DEFAULT 0,
   mod4103r10s1     DECIMAL(10,0) DEFAULT 0,
   mod4103r11s1     DECIMAL(10,0) DEFAULT 0,
   mod4103r12s1     DECIMAL(10,0) DEFAULT 0,
   mod4103r13s1     DECIMAL(10,0) DEFAULT 0,
   mod4103r14s1     DECIMAL(10,0) DEFAULT 0,
   mod4103r15s1     DECIMAL(10,0) DEFAULT 0,
   mod4103r01s2     DECIMAL(10,0) DEFAULT 0,
   mod4103r02s2     DECIMAL(10,0) DEFAULT 0,
   mod4103r03s2     DECIMAL(10,0) DEFAULT 0,
   mod4103r04s2     DECIMAL(10,0) DEFAULT 0,
   mod4103r05s2     DECIMAL(10,0) DEFAULT 0,
   mod4103r06s2     DECIMAL(10,0) DEFAULT 0,
   mod4103r07s2     DECIMAL(10,0) DEFAULT 0,
   mod4103r08s2     DECIMAL(10,0) DEFAULT 0,
   mod4103r09s2     DECIMAL(10,0) DEFAULT 0,
   mod4103r10s2     DECIMAL(10,0) DEFAULT 0,
   mod4103r11s2     DECIMAL(10,0) DEFAULT 0,
   mod4103r12s2     DECIMAL(10,0) DEFAULT 0,
   mod4103r13s2     DECIMAL(10,0) DEFAULT 0,
   mod4103r14s2     DECIMAL(10,0) DEFAULT 0,
   mod4103r15s2     DECIMAL(10,0) DEFAULT 0,
   mod4103r01s3     DECIMAL(10,0) DEFAULT 0,
   mod4103r02s3     DECIMAL(10,0) DEFAULT 0,
   mod4103r03s3     DECIMAL(10,0) DEFAULT 0,
   mod4103r04s3     DECIMAL(10,0) DEFAULT 0,
   mod4103r05s3     DECIMAL(10,0) DEFAULT 0,
   mod4103r06s3     DECIMAL(10,0) DEFAULT 0,
   mod4103r07s3     DECIMAL(10,0) DEFAULT 0,
   mod4103r08s3     DECIMAL(10,0) DEFAULT 0,
   mod4103r09s3     DECIMAL(10,0) DEFAULT 0,
   mod4103r10s3     DECIMAL(10,0) DEFAULT 0,
   mod4103r11s3     DECIMAL(10,0) DEFAULT 0,
   mod4103r12s3     DECIMAL(10,0) DEFAULT 0,
   mod4103r13s3     DECIMAL(10,0) DEFAULT 0,
   mod4103r14s3     DECIMAL(10,0) DEFAULT 0,
   mod4103r15s3     DECIMAL(10,0) DEFAULT 0,
   mod4103r01s4     DECIMAL(10,0) DEFAULT 0,
   mod4103r02s4     DECIMAL(10,0) DEFAULT 0,
   mod4103r03s4     DECIMAL(10,0) DEFAULT 0,
   mod4103r04s4     DECIMAL(10,0) DEFAULT 0,
   mod4103r05s4     DECIMAL(10,0) DEFAULT 0,
   mod4103r06s4     DECIMAL(10,0) DEFAULT 0,
   mod4103r07s4     DECIMAL(10,0) DEFAULT 0,
   mod4103r08s4     DECIMAL(10,0) DEFAULT 0,
   mod4103r09s4     DECIMAL(10,0) DEFAULT 0,
   mod4103r10s4     DECIMAL(10,0) DEFAULT 0,
   mod4103r11s4     DECIMAL(10,0) DEFAULT 0,
   mod4103r12s4     DECIMAL(10,0) DEFAULT 0,
   mod4103r13s4     DECIMAL(10,0) DEFAULT 0,
   mod4103r14s4     DECIMAL(10,0) DEFAULT 0,
   mod4103r15s4     DECIMAL(10,0) DEFAULT 0,
   mod4103r01s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r02s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r03s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r04s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r05s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r06s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r07s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r08s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r09s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r10s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r11s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r12s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r13s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r14s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r15s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r16s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r17s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r18s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r19s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r20s5     DECIMAL(10,0) DEFAULT 0,
   mod4103r01s6     DECIMAL(10,0) DEFAULT 0,
   mod4103r02s6     DECIMAL(10,0) DEFAULT 0,
   mod4103r03s6     DECIMAL(10,0) DEFAULT 0,
   mod4103r04s6     DECIMAL(10,0) DEFAULT 0,
   mod4103r05s6     DECIMAL(10,0) DEFAULT 0,
   mod4103r06s6     DECIMAL(10,0) DEFAULT 0,
   mod4103r07s6     DECIMAL(10,0) DEFAULT 0,
   mod4103r08s6     DECIMAL(10,0) DEFAULT 0,
   mod4103r09s6     DECIMAL(10,0) DEFAULT 0,
   mod4103r10s6     DECIMAL(10,0) DEFAULT 0,
   mod4103r11s6     DECIMAL(10,0) DEFAULT 0,
   mod4103r12s6     DECIMAL(10,0) DEFAULT 0,
   mod4103r13s6     DECIMAL(10,0) DEFAULT 0,
   mod4103r14s6     DECIMAL(10,0) DEFAULT 0,
   mod4103r15s6     DECIMAL(10,0) DEFAULT 0,
   mod4103r01s7     DECIMAL(10,0) DEFAULT 0,
   mod4103r02s7     DECIMAL(10,0) DEFAULT 0,
   mod4103r03s7     DECIMAL(10,0) DEFAULT 0,
   mod4103r04s7     DECIMAL(10,0) DEFAULT 0,
   mod4103r05s7     DECIMAL(10,0) DEFAULT 0,
   mod4103r06s7     DECIMAL(10,0) DEFAULT 0,
   mod4103r07s7     DECIMAL(10,0) DEFAULT 0,
   mod4103r08s7     DECIMAL(10,0) DEFAULT 0,
   mod4103r09s7     DECIMAL(10,0) DEFAULT 0,
   mod4103r10s7     DECIMAL(10,0) DEFAULT 0,
   mod4103r11s7     DECIMAL(10,0) DEFAULT 0,
   mod4103r12s7     DECIMAL(10,0) DEFAULT 0,
   mod4103r13s7     DECIMAL(10,0) DEFAULT 0,
   mod4103r14s7     DECIMAL(10,0) DEFAULT 0,
   mod4103r15s7     DECIMAL(10,0) DEFAULT 0,
   mod4104r01s1     DECIMAL(10,2) DEFAULT 0,
   mod4104r02s1     DECIMAL(10,2) DEFAULT 0,
   mod4104r03s1     DECIMAL(10,2) DEFAULT 0,
   mod4104r04s1     DECIMAL(10,2) DEFAULT 0,
   mod4101s01       VARCHAR(90), 
   mod4101s02       VARCHAR(90), 
   mod4101s03       VARCHAR(90), 
   mod4101s04       VARCHAR(90), 
   mod4101s05       VARCHAR(90), 
   mod4101s06       VARCHAR(90), 
   mod4101s07       VARCHAR(90), 
   mod4101s08       VARCHAR(90), 
   mod4101s09       VARCHAR(90), 
   mod4101s10       VARCHAR(90), 
   mod4101s11       VARCHAR(90), 
   mod4101s12       VARCHAR(90), 
   mod4101s13       VARCHAR(90), 
   mod4101s14       VARCHAR(90), 
   mod4101s15       VARCHAR(90), 
   mod4101s16       VARCHAR(90), 
   mod4102s01       VARCHAR(90), 
   mod4102s02       VARCHAR(90), 
   mod4102s03       VARCHAR(90), 
   mod4102s04       VARCHAR(90), 
   mod4102s05       VARCHAR(90), 
   mod4102s06       VARCHAR(90), 
   mod4102s07       VARCHAR(90), 
   mod4102s08       VARCHAR(90), 
   mod4102s09       VARCHAR(90), 
   mod4102s10       VARCHAR(90), 
   mod4102s11       VARCHAR(90), 
   mod4102s12       VARCHAR(90), 
   mod4102s13       VARCHAR(90), 
   mod4102s14       VARCHAR(90), 
   ico              DECIMAL(8,0)
);  
statistika_e104;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statistika_e104'.$sqlt;
$vytvor = mysql_query("$vsql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_e104 ADD stvrtrok DECIMAL(2,0) DEFAULT 0 AFTER ico";
$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_statistika_e104 ( ico,stvrtrok ) VALUES ( '0',1 )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_statistika_e104 ( ico,stvrtrok ) VALUES ( '0',2 )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_statistika_e104 ( ico,stvrtrok ) VALUES ( '0',3 )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_statistika_e104 ( ico,stvrtrok ) VALUES ( '0',4 )";
$ttqq = mysql_query("$ttvv");

}
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_e104 MODIFY mod4104r01s1 DECIMAL(10,2) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_e104 MODIFY mod4104r02s1 DECIMAL(10,2) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_e104 MODIFY mod4104r03s1 DECIMAL(10,2) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_e104 MODIFY mod4104r04s1 DECIMAL(10,2) DEFAULT 0";
$vysledek = mysql_query("$sql");
//koniec pracovny subor





// zapis upravene udaje strana 1
if ( $copern == 3 )
    {
$mod4101s01 = strip_tags($_REQUEST['mod4101s01']);
$mod4101s02 = strip_tags($_REQUEST['mod4101s02']);
$mod4101s03 = strip_tags($_REQUEST['mod4101s03']);
$mod4101s04 = strip_tags($_REQUEST['mod4101s04']);
$mod4101s05 = strip_tags($_REQUEST['mod4101s05']);
$mod4101s06 = strip_tags($_REQUEST['mod4101s06']);
$mod4101s07 = strip_tags($_REQUEST['mod4101s07']);
$mod4101s08 = strip_tags($_REQUEST['mod4101s08']);
$mod4101s09 = strip_tags($_REQUEST['mod4101s09']);
$mod4101s10 = strip_tags($_REQUEST['mod4101s10']);
$mod4101s11 = strip_tags($_REQUEST['mod4101s11']);
$mod4101s12 = strip_tags($_REQUEST['mod4101s12']);
$mod4101s13 = strip_tags($_REQUEST['mod4101s13']);
$mod4101s14 = strip_tags($_REQUEST['mod4101s14']);
$mod4101s15 = strip_tags($_REQUEST['mod4101s15']);
$mod4101s16 = strip_tags($_REQUEST['mod4101s16']);

$mod4102s01 = strip_tags($_REQUEST['mod4102s01']);
$mod4102s02 = strip_tags($_REQUEST['mod4102s02']);
$mod4102s03 = strip_tags($_REQUEST['mod4102s03']);
$mod4102s04 = strip_tags($_REQUEST['mod4102s04']);
$mod4102s05 = strip_tags($_REQUEST['mod4102s05']);
$mod4102s06 = strip_tags($_REQUEST['mod4102s06']);
$mod4102s07 = strip_tags($_REQUEST['mod4102s07']);
$mod4102s08 = strip_tags($_REQUEST['mod4102s08']);
$mod4102s09 = strip_tags($_REQUEST['mod4102s09']);
$mod4102s10 = strip_tags($_REQUEST['mod4102s10']);
$mod4102s11 = strip_tags($_REQUEST['mod4102s11']);
$mod4102s12 = strip_tags($_REQUEST['mod4102s12']);
$mod4102s13 = strip_tags($_REQUEST['mod4102s13']);
$mod4102s14 = strip_tags($_REQUEST['mod4102s14']);


$uprav="NO";


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_e104 SET ".
" mod4101s01='$mod4101s01',mod4101s02='$mod4101s02',mod4101s03='$mod4101s03',mod4101s04='$mod4101s04',mod4101s05='$mod4101s05',  ".
" mod4101s06='$mod4101s06',mod4101s07='$mod4101s07',mod4101s08='$mod4101s08',mod4101s09='$mod4101s09',mod4101s10='$mod4101s10',  ".
" mod4101s11='$mod4101s11',mod4101s12='$mod4101s12',mod4101s13='$mod4101s13',mod4101s14='$mod4101s14',mod4101s15='$mod4101s15',  ".
" mod4101s16='$mod4101s16', ".
" mod4102s01='$mod4102s01',mod4102s02='$mod4102s02',mod4102s03='$mod4102s03',mod4102s04='$mod4102s04',mod4102s05='$mod4102s05',  ".
" mod4102s06='$mod4102s06',mod4102s07='$mod4102s07',mod4102s08='$mod4102s08',mod4102s09='$mod4102s09',mod4102s10='$mod4102s10',  ".
" mod4102s11='$mod4102s11',mod4102s12='$mod4102s12',mod4102s13='$mod4102s13',mod4102s14='$mod4102s14' ".
" WHERE stvrtrok = $stvrtrok"; 

//echo $uprtxt;

$upravene = mysql_query("$uprtxt");  
$copern=1;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenych udajov strana 1


// zapis upravene udaje strana 2
if ( $copern == 103 )
    {

$mod4103r01s1 = strip_tags($_REQUEST['mod4103r01s1']);
$mod4103r02s1 = strip_tags($_REQUEST['mod4103r02s1']);
$mod4103r03s1 = strip_tags($_REQUEST['mod4103r03s1']);
$mod4103r04s1 = strip_tags($_REQUEST['mod4103r04s1']);
$mod4103r05s1 = strip_tags($_REQUEST['mod4103r05s1']);
$mod4103r06s1 = strip_tags($_REQUEST['mod4103r06s1']);
$mod4103r07s1 = strip_tags($_REQUEST['mod4103r07s1']);
$mod4103r08s1 = strip_tags($_REQUEST['mod4103r08s1']);
$mod4103r09s1 = strip_tags($_REQUEST['mod4103r09s1']);
$mod4103r10s1 = strip_tags($_REQUEST['mod4103r10s1']);
$mod4103r11s1 = strip_tags($_REQUEST['mod4103r11s1']);
$mod4103r12s1 = strip_tags($_REQUEST['mod4103r12s1']);
$mod4103r13s1 = strip_tags($_REQUEST['mod4103r13s1']);
$mod4103r14s1 = strip_tags($_REQUEST['mod4103r14s1']);
$mod4103r15s1 = strip_tags($_REQUEST['mod4103r15s1']);
$mod4103r01s2 = strip_tags($_REQUEST['mod4103r01s2']);
$mod4103r02s2 = strip_tags($_REQUEST['mod4103r02s2']);
$mod4103r03s2 = strip_tags($_REQUEST['mod4103r03s2']);
$mod4103r04s2 = strip_tags($_REQUEST['mod4103r04s2']);
$mod4103r05s2 = strip_tags($_REQUEST['mod4103r05s2']);
$mod4103r06s2 = strip_tags($_REQUEST['mod4103r06s2']);
$mod4103r07s2 = strip_tags($_REQUEST['mod4103r07s2']);
$mod4103r08s2 = strip_tags($_REQUEST['mod4103r08s2']);
$mod4103r09s2 = strip_tags($_REQUEST['mod4103r09s2']);
$mod4103r10s2 = strip_tags($_REQUEST['mod4103r10s2']);
$mod4103r11s2 = strip_tags($_REQUEST['mod4103r11s2']);
$mod4103r12s2 = strip_tags($_REQUEST['mod4103r12s2']);
$mod4103r13s2 = strip_tags($_REQUEST['mod4103r13s2']);
$mod4103r14s2 = strip_tags($_REQUEST['mod4103r14s2']);
$mod4103r15s2 = strip_tags($_REQUEST['mod4103r15s2']);
$mod4103r01s3 = strip_tags($_REQUEST['mod4103r01s3']);
$mod4103r02s3 = strip_tags($_REQUEST['mod4103r02s3']);
$mod4103r03s3 = strip_tags($_REQUEST['mod4103r03s3']);
$mod4103r04s3 = strip_tags($_REQUEST['mod4103r04s3']);
$mod4103r05s3 = strip_tags($_REQUEST['mod4103r05s3']);
$mod4103r06s3 = strip_tags($_REQUEST['mod4103r06s3']);
$mod4103r07s3 = strip_tags($_REQUEST['mod4103r07s3']);
$mod4103r08s3 = strip_tags($_REQUEST['mod4103r08s3']);
$mod4103r09s3 = strip_tags($_REQUEST['mod4103r09s3']);
$mod4103r10s3 = strip_tags($_REQUEST['mod4103r10s3']);
$mod4103r11s3 = strip_tags($_REQUEST['mod4103r11s3']);
$mod4103r12s3 = strip_tags($_REQUEST['mod4103r12s3']);
$mod4103r13s3 = strip_tags($_REQUEST['mod4103r13s3']);
$mod4103r14s3 = strip_tags($_REQUEST['mod4103r14s3']);
$mod4103r15s3 = strip_tags($_REQUEST['mod4103r15s3']);
$mod4103r01s4 = strip_tags($_REQUEST['mod4103r01s4']);
$mod4103r02s4 = strip_tags($_REQUEST['mod4103r02s4']);
$mod4103r03s4 = strip_tags($_REQUEST['mod4103r03s4']);
$mod4103r04s4 = strip_tags($_REQUEST['mod4103r04s4']);
$mod4103r05s4 = strip_tags($_REQUEST['mod4103r05s4']);
$mod4103r06s4 = strip_tags($_REQUEST['mod4103r06s4']);
$mod4103r07s4 = strip_tags($_REQUEST['mod4103r07s4']);
$mod4103r08s4 = strip_tags($_REQUEST['mod4103r08s4']);
$mod4103r09s4 = strip_tags($_REQUEST['mod4103r09s4']);
$mod4103r10s4 = strip_tags($_REQUEST['mod4103r10s4']);
$mod4103r11s4 = strip_tags($_REQUEST['mod4103r11s4']);
$mod4103r12s4 = strip_tags($_REQUEST['mod4103r12s4']);
$mod4103r13s4 = strip_tags($_REQUEST['mod4103r13s4']);
$mod4103r14s4 = strip_tags($_REQUEST['mod4103r14s4']);
$mod4103r15s4 = strip_tags($_REQUEST['mod4103r15s4']);
$mod4103r01s5 = strip_tags($_REQUEST['mod4103r01s5']);
$mod4103r02s5 = strip_tags($_REQUEST['mod4103r02s5']);
$mod4103r03s5 = strip_tags($_REQUEST['mod4103r03s5']);
$mod4103r04s5 = strip_tags($_REQUEST['mod4103r04s5']);
$mod4103r05s5 = strip_tags($_REQUEST['mod4103r05s5']);
$mod4103r06s5 = strip_tags($_REQUEST['mod4103r06s5']);
$mod4103r07s5 = strip_tags($_REQUEST['mod4103r07s5']);
$mod4103r08s5 = strip_tags($_REQUEST['mod4103r08s5']);
$mod4103r09s5 = strip_tags($_REQUEST['mod4103r09s5']);
$mod4103r10s5 = strip_tags($_REQUEST['mod4103r10s5']);
$mod4103r11s5 = strip_tags($_REQUEST['mod4103r11s5']);
$mod4103r12s5 = strip_tags($_REQUEST['mod4103r12s5']);
$mod4103r13s5 = strip_tags($_REQUEST['mod4103r13s5']);
$mod4103r14s5 = strip_tags($_REQUEST['mod4103r14s5']);
$mod4103r15s5 = strip_tags($_REQUEST['mod4103r15s5']);
$mod4103r01s6 = strip_tags($_REQUEST['mod4103r01s6']);
$mod4103r02s6 = strip_tags($_REQUEST['mod4103r02s6']);
$mod4103r03s6 = strip_tags($_REQUEST['mod4103r03s6']);
$mod4103r04s6 = strip_tags($_REQUEST['mod4103r04s6']);
$mod4103r05s6 = strip_tags($_REQUEST['mod4103r05s6']);
$mod4103r06s6 = strip_tags($_REQUEST['mod4103r06s6']);
$mod4103r07s6 = strip_tags($_REQUEST['mod4103r07s6']);
$mod4103r08s6 = strip_tags($_REQUEST['mod4103r08s6']);
$mod4103r09s6 = strip_tags($_REQUEST['mod4103r09s6']);
$mod4103r10s6 = strip_tags($_REQUEST['mod4103r10s6']);
$mod4103r11s6 = strip_tags($_REQUEST['mod4103r11s6']);
$mod4103r12s6 = strip_tags($_REQUEST['mod4103r12s6']);
$mod4103r13s6 = strip_tags($_REQUEST['mod4103r13s6']);
$mod4103r14s6 = strip_tags($_REQUEST['mod4103r14s6']);
$mod4103r15s6 = strip_tags($_REQUEST['mod4103r15s6']);
$mod4103r01s7 = strip_tags($_REQUEST['mod4103r01s7']);
$mod4103r02s7 = strip_tags($_REQUEST['mod4103r02s7']);
$mod4103r03s7 = strip_tags($_REQUEST['mod4103r03s7']);
$mod4103r04s7 = strip_tags($_REQUEST['mod4103r04s7']);
$mod4103r05s7 = strip_tags($_REQUEST['mod4103r05s7']);
$mod4103r06s7 = strip_tags($_REQUEST['mod4103r06s7']);
$mod4103r07s7 = strip_tags($_REQUEST['mod4103r07s7']);
$mod4103r08s7 = strip_tags($_REQUEST['mod4103r08s7']);
$mod4103r09s7 = strip_tags($_REQUEST['mod4103r09s7']);
$mod4103r10s7 = strip_tags($_REQUEST['mod4103r10s7']);
$mod4103r11s7 = strip_tags($_REQUEST['mod4103r11s7']);
$mod4103r12s7 = strip_tags($_REQUEST['mod4103r12s7']);
$mod4103r13s7 = strip_tags($_REQUEST['mod4103r13s7']);
$mod4103r14s7 = strip_tags($_REQUEST['mod4103r14s7']);
$mod4103r15s7 = strip_tags($_REQUEST['mod4103r15s7']);

$mod4104r01s1 = strip_tags($_REQUEST['mod4104r01s1']);
$mod4104r02s1 = strip_tags($_REQUEST['mod4104r02s1']);
$mod4104r03s1 = strip_tags($_REQUEST['mod4104r03s1']);
$mod4104r04s1 = strip_tags($_REQUEST['mod4104r04s1']);

$mod4103r01str = strip_tags($_REQUEST['mod4103r01str']);
$mod4103r02str = strip_tags($_REQUEST['mod4103r02str']);
$mod4103r03str = strip_tags($_REQUEST['mod4103r03str']);
$mod4103r04str = strip_tags($_REQUEST['mod4103r04str']);
$mod4103r05str = strip_tags($_REQUEST['mod4103r05str']);
$mod4103r06str = strip_tags($_REQUEST['mod4103r06str']);
$mod4103r07str = strip_tags($_REQUEST['mod4103r07str']);
$mod4103r08str = strip_tags($_REQUEST['mod4103r08str']);
$mod4103r09str = strip_tags($_REQUEST['mod4103r09str']);
$mod4103r10str = strip_tags($_REQUEST['mod4103r10str']);
$mod4103r11str = strip_tags($_REQUEST['mod4103r11str']);
$mod4103r12str = strip_tags($_REQUEST['mod4103r12str']);
$mod4103r13str = strip_tags($_REQUEST['mod4103r13str']);
$mod4103r14str = strip_tags($_REQUEST['mod4103r14str']);
$mod4103r15str = strip_tags($_REQUEST['mod4103r15str']);




$uprav="NO";


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_e104 SET ".
" mod4103r01s1='$mod4103r01s1', mod4103r02s1='$mod4103r02s1', mod4103r03s1='$mod4103r03s1', mod4103r04s1='$mod4103r04s1', mod4103r05s1='$mod4103r05s1',  ".
" mod4103r06s1='$mod4103r06s1', mod4103r07s1='$mod4103r07s1', mod4103r08s1='$mod4103r08s1', mod4103r09s1='$mod4103r09s1', mod4103r10s1='$mod4103r10s1',  ".
" mod4103r11s1='$mod4103r11s1', mod4103r12s1='$mod4103r12s1', mod4103r13s1='$mod4103r13s1', mod4103r14s1='$mod4103r14s1', mod4103r15s1='$mod4103r15s1',  ".
" mod4103r01s2='$mod4103r01s2', mod4103r02s2='$mod4103r02s2', mod4103r03s2='$mod4103r03s2', mod4103r04s2='$mod4103r04s2', mod4103r05s2='$mod4103r05s2',  ".
" mod4103r06s2='$mod4103r06s2', mod4103r07s2='$mod4103r07s2', mod4103r08s2='$mod4103r08s2', mod4103r09s2='$mod4103r09s2', mod4103r10s2='$mod4103r10s2',  ".
" mod4103r11s2='$mod4103r11s2', mod4103r12s2='$mod4103r12s2', mod4103r13s2='$mod4103r13s2', mod4103r14s2='$mod4103r14s2', mod4103r15s2='$mod4103r15s2',  ".
" mod4103r01s3='$mod4103r01s3', mod4103r02s3='$mod4103r02s3', mod4103r03s3='$mod4103r03s3', mod4103r04s3='$mod4103r04s3', mod4103r05s3='$mod4103r05s3',  ".
" mod4103r06s3='$mod4103r06s3', mod4103r07s3='$mod4103r07s3', mod4103r08s3='$mod4103r08s3', mod4103r09s3='$mod4103r09s3', mod4103r10s3='$mod4103r10s3',  ".
" mod4103r11s3='$mod4103r11s3', mod4103r12s3='$mod4103r12s3', mod4103r13s3='$mod4103r13s3', mod4103r14s3='$mod4103r14s3', mod4103r15s3='$mod4103r15s3',  ".
" mod4103r01s4='$mod4103r01s4', mod4103r02s4='$mod4103r02s4', mod4103r03s4='$mod4103r03s4', mod4103r04s4='$mod4103r04s4', mod4103r05s4='$mod4103r05s4',  ".
" mod4103r06s4='$mod4103r06s4', mod4103r07s4='$mod4103r07s4', mod4103r08s4='$mod4103r08s4', mod4103r09s4='$mod4103r09s4', mod4103r10s4='$mod4103r10s4',  ".
" mod4103r11s4='$mod4103r11s4', mod4103r12s4='$mod4103r12s4', mod4103r13s4='$mod4103r13s4', mod4103r14s4='$mod4103r14s4', mod4103r15s4='$mod4103r15s4',  ".
" mod4103r01s5='$mod4103r01s5', mod4103r02s5='$mod4103r02s5', mod4103r03s5='$mod4103r03s5', mod4103r04s5='$mod4103r04s5', mod4103r05s5='$mod4103r05s5',  ".
" mod4103r06s5='$mod4103r06s5', mod4103r07s5='$mod4103r07s5', mod4103r08s5='$mod4103r08s5', mod4103r09s5='$mod4103r09s5', mod4103r10s5='$mod4103r10s5',  ".
" mod4103r11s5='$mod4103r11s5', mod4103r12s5='$mod4103r12s5', mod4103r13s5='$mod4103r13s5', mod4103r14s5='$mod4103r14s5', mod4103r15s5='$mod4103r15s5',  ".
" mod4103r01s6='$mod4103r01s6', mod4103r02s6='$mod4103r02s6', mod4103r03s6='$mod4103r03s6', mod4103r04s6='$mod4103r04s6', mod4103r05s6='$mod4103r05s6',  ".
" mod4103r06s6='$mod4103r06s6', mod4103r07s6='$mod4103r07s6', mod4103r08s6='$mod4103r08s6', mod4103r09s6='$mod4103r09s6', mod4103r10s6='$mod4103r10s6',  ".
" mod4103r11s6='$mod4103r11s6', mod4103r12s6='$mod4103r12s6', mod4103r13s6='$mod4103r13s6', mod4103r14s6='$mod4103r14s6', mod4103r15s6='$mod4103r15s6',  ".
" mod4103r01s7='$mod4103r01s7', mod4103r02s7='$mod4103r02s7', mod4103r03s7='$mod4103r03s7', mod4103r04s7='$mod4103r04s7', mod4103r05s7='$mod4103r05s7',  ".
" mod4103r06s7='$mod4103r06s7', mod4103r07s7='$mod4103r07s7', mod4103r08s7='$mod4103r08s7', mod4103r09s7='$mod4103r09s7', mod4103r10s7='$mod4103r10s7',  ".
" mod4103r11s7='$mod4103r11s7', mod4103r12s7='$mod4103r12s7', mod4103r13s7='$mod4103r13s7', mod4103r14s7='$mod4103r14s7', mod4103r15s7='$mod4103r15s7',  ".
" mod4103r01str='$mod4103r01str', mod4103r02str='$mod4103r02str', mod4103r03str='$mod4103r03str', mod4103r04str='$mod4103r04str', mod4103r05str='$mod4103r05str',  ".
" mod4103r06str='$mod4103r06str', mod4103r07str='$mod4103r07str', mod4103r08str='$mod4103r08str', mod4103r09str='$mod4103r09str', mod4103r10str='$mod4103r10str',  ".
" mod4103r11str='$mod4103r11str', mod4103r12str='$mod4103r12str', mod4103r13str='$mod4103r13str', mod4103r14str='$mod4103r14str', mod4103r15str='$mod4103r15str',  ".
" mod4104r01s1='$mod4104r01s1', mod4104r02s1='$mod4104r02s1', mod4104r03s1='$mod4104r03s1', mod4104r04s1='$mod4104r04s1' ".
" WHERE stvrtrok = $stvrtrok"; 

//echo $uprtxt;

$upravene = mysql_query("$uprtxt");  
$copern=101;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenych udajov strana 2

//nacitaj udaje
if ( $copern >= 1 )
    {

$sqlfir = "SELECT * FROM F$kli_vxcf"."_statistika_e104 WHERE stvrtrok = $stvrtrok";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$mod4101s01 = $fir_riadok->mod4101s01;
$mod4101s02 = $fir_riadok->mod4101s02;
$mod4101s03 = $fir_riadok->mod4101s03;
$mod4101s04 = $fir_riadok->mod4101s04;
$mod4101s05 = $fir_riadok->mod4101s05;
$mod4101s06 = $fir_riadok->mod4101s06;
$mod4101s07 = $fir_riadok->mod4101s07;
$mod4101s08 = $fir_riadok->mod4101s08;
$mod4101s09 = $fir_riadok->mod4101s09;
$mod4101s10 = $fir_riadok->mod4101s10;
$mod4101s11 = $fir_riadok->mod4101s11;
$mod4101s12 = $fir_riadok->mod4101s12;
$mod4101s13 = $fir_riadok->mod4101s13;
$mod4101s14 = $fir_riadok->mod4101s14;
$mod4101s15 = $fir_riadok->mod4101s15;
$mod4101s16 = $fir_riadok->mod4101s16;

$mod4102s01 = $fir_riadok->mod4102s01;
$mod4102s02 = $fir_riadok->mod4102s02;
$mod4102s03 = $fir_riadok->mod4102s03;
$mod4102s04 = $fir_riadok->mod4102s04;
$mod4102s05 = $fir_riadok->mod4102s05;
$mod4102s06 = $fir_riadok->mod4102s06;
$mod4102s07 = $fir_riadok->mod4102s07;
$mod4102s08 = $fir_riadok->mod4102s08;
$mod4102s09 = $fir_riadok->mod4102s09;
$mod4102s10 = $fir_riadok->mod4102s10;
$mod4102s11 = $fir_riadok->mod4102s11;
$mod4102s12 = $fir_riadok->mod4102s12;
$mod4102s13 = $fir_riadok->mod4102s13;
$mod4102s14 = $fir_riadok->mod4102s14;


$mod4103r01s1 = $fir_riadok->mod4103r01s1;
$mod4103r02s1 = $fir_riadok->mod4103r02s1;
$mod4103r03s1 = $fir_riadok->mod4103r03s1;
$mod4103r04s1 = $fir_riadok->mod4103r04s1;
$mod4103r05s1 = $fir_riadok->mod4103r05s1;
$mod4103r06s1 = $fir_riadok->mod4103r06s1;
$mod4103r07s1 = $fir_riadok->mod4103r07s1;
$mod4103r08s1 = $fir_riadok->mod4103r08s1;
$mod4103r09s1 = $fir_riadok->mod4103r09s1;
$mod4103r10s1 = $fir_riadok->mod4103r10s1;
$mod4103r11s1 = $fir_riadok->mod4103r11s1;
$mod4103r12s1 = $fir_riadok->mod4103r12s1;
$mod4103r13s1 = $fir_riadok->mod4103r13s1;
$mod4103r14s1 = $fir_riadok->mod4103r14s1;
$mod4103r15s1 = $fir_riadok->mod4103r15s1;
$mod4103r01s2 = $fir_riadok->mod4103r01s2;
$mod4103r02s2 = $fir_riadok->mod4103r02s2;
$mod4103r03s2 = $fir_riadok->mod4103r03s2;
$mod4103r04s2 = $fir_riadok->mod4103r04s2;
$mod4103r05s2 = $fir_riadok->mod4103r05s2;
$mod4103r06s2 = $fir_riadok->mod4103r06s2;
$mod4103r07s2 = $fir_riadok->mod4103r07s2;
$mod4103r08s2 = $fir_riadok->mod4103r08s2;
$mod4103r09s2 = $fir_riadok->mod4103r09s2;
$mod4103r10s2 = $fir_riadok->mod4103r10s2;
$mod4103r11s2 = $fir_riadok->mod4103r11s2;
$mod4103r12s2 = $fir_riadok->mod4103r12s2;
$mod4103r13s2 = $fir_riadok->mod4103r13s2;
$mod4103r14s2 = $fir_riadok->mod4103r14s2;
$mod4103r15s2 = $fir_riadok->mod4103r15s2;
$mod4103r01s3 = $fir_riadok->mod4103r01s3;
$mod4103r02s3 = $fir_riadok->mod4103r02s3;
$mod4103r03s3 = $fir_riadok->mod4103r03s3;
$mod4103r04s3 = $fir_riadok->mod4103r04s3;
$mod4103r05s3 = $fir_riadok->mod4103r05s3;
$mod4103r06s3 = $fir_riadok->mod4103r06s3;
$mod4103r07s3 = $fir_riadok->mod4103r07s3;
$mod4103r08s3 = $fir_riadok->mod4103r08s3;
$mod4103r09s3 = $fir_riadok->mod4103r09s3;
$mod4103r10s3 = $fir_riadok->mod4103r10s3;
$mod4103r11s3 = $fir_riadok->mod4103r11s3;
$mod4103r12s3 = $fir_riadok->mod4103r12s3;
$mod4103r13s3 = $fir_riadok->mod4103r13s3;
$mod4103r14s3 = $fir_riadok->mod4103r14s3;
$mod4103r15s3 = $fir_riadok->mod4103r15s3;
$mod4103r01s4 = $fir_riadok->mod4103r01s4;
$mod4103r02s4 = $fir_riadok->mod4103r02s4;
$mod4103r03s4 = $fir_riadok->mod4103r03s4;
$mod4103r04s4 = $fir_riadok->mod4103r04s4;
$mod4103r05s4 = $fir_riadok->mod4103r05s4;
$mod4103r06s4 = $fir_riadok->mod4103r06s4;
$mod4103r07s4 = $fir_riadok->mod4103r07s4;
$mod4103r08s4 = $fir_riadok->mod4103r08s4;
$mod4103r09s4 = $fir_riadok->mod4103r09s4;
$mod4103r10s4 = $fir_riadok->mod4103r10s4;
$mod4103r11s4 = $fir_riadok->mod4103r11s4;
$mod4103r12s4 = $fir_riadok->mod4103r12s4;
$mod4103r13s4 = $fir_riadok->mod4103r13s4;
$mod4103r14s4 = $fir_riadok->mod4103r14s4;
$mod4103r15s4 = $fir_riadok->mod4103r15s4;
$mod4103r01s5 = $fir_riadok->mod4103r01s5;
$mod4103r02s5 = $fir_riadok->mod4103r02s5;
$mod4103r03s5 = $fir_riadok->mod4103r03s5;
$mod4103r04s5 = $fir_riadok->mod4103r04s5;
$mod4103r05s5 = $fir_riadok->mod4103r05s5;
$mod4103r06s5 = $fir_riadok->mod4103r06s5;
$mod4103r07s5 = $fir_riadok->mod4103r07s5;
$mod4103r08s5 = $fir_riadok->mod4103r08s5;
$mod4103r09s5 = $fir_riadok->mod4103r09s5;
$mod4103r10s5 = $fir_riadok->mod4103r10s5;
$mod4103r11s5 = $fir_riadok->mod4103r11s5;
$mod4103r12s5 = $fir_riadok->mod4103r12s5;
$mod4103r13s5 = $fir_riadok->mod4103r13s5;
$mod4103r14s5 = $fir_riadok->mod4103r14s5;
$mod4103r15s5 = $fir_riadok->mod4103r15s5;
$mod4103r01s6 = $fir_riadok->mod4103r01s6;
$mod4103r02s6 = $fir_riadok->mod4103r02s6;
$mod4103r03s6 = $fir_riadok->mod4103r03s6;
$mod4103r04s6 = $fir_riadok->mod4103r04s6;
$mod4103r05s6 = $fir_riadok->mod4103r05s6;
$mod4103r06s6 = $fir_riadok->mod4103r06s6;
$mod4103r07s6 = $fir_riadok->mod4103r07s6;
$mod4103r08s6 = $fir_riadok->mod4103r08s6;
$mod4103r09s6 = $fir_riadok->mod4103r09s6;
$mod4103r10s6 = $fir_riadok->mod4103r10s6;
$mod4103r11s6 = $fir_riadok->mod4103r11s6;
$mod4103r12s6 = $fir_riadok->mod4103r12s6;
$mod4103r13s6 = $fir_riadok->mod4103r13s6;
$mod4103r14s6 = $fir_riadok->mod4103r14s6;
$mod4103r15s6 = $fir_riadok->mod4103r15s6;
$mod4103r01s7 = $fir_riadok->mod4103r01s7;
$mod4103r02s7 = $fir_riadok->mod4103r02s7;
$mod4103r03s7 = $fir_riadok->mod4103r03s7;
$mod4103r04s7 = $fir_riadok->mod4103r04s7;
$mod4103r05s7 = $fir_riadok->mod4103r05s7;
$mod4103r06s7 = $fir_riadok->mod4103r06s7;
$mod4103r07s7 = $fir_riadok->mod4103r07s7;
$mod4103r08s7 = $fir_riadok->mod4103r08s7;
$mod4103r09s7 = $fir_riadok->mod4103r09s7;
$mod4103r10s7 = $fir_riadok->mod4103r10s7;
$mod4103r11s7 = $fir_riadok->mod4103r11s7;
$mod4103r12s7 = $fir_riadok->mod4103r12s7;
$mod4103r13s7 = $fir_riadok->mod4103r13s7;
$mod4103r14s7 = $fir_riadok->mod4103r14s7;
$mod4103r15s7 = $fir_riadok->mod4103r15s7;

$mod4103r01str = $fir_riadok->mod4103r01str;
$mod4103r02str = $fir_riadok->mod4103r02str;
$mod4103r03str = $fir_riadok->mod4103r03str;
$mod4103r04str = $fir_riadok->mod4103r04str;
$mod4103r05str = $fir_riadok->mod4103r05str;
$mod4103r06str = $fir_riadok->mod4103r06str;
$mod4103r07str = $fir_riadok->mod4103r07str;
$mod4103r08str = $fir_riadok->mod4103r08str;
$mod4103r09str = $fir_riadok->mod4103r09str;
$mod4103r10str = $fir_riadok->mod4103r10str;
$mod4103r11str = $fir_riadok->mod4103r11str;
$mod4103r12str = $fir_riadok->mod4103r12str;
$mod4103r13str = $fir_riadok->mod4103r13str;
$mod4103r14str = $fir_riadok->mod4103r14str;
$mod4103r15str = $fir_riadok->mod4103r15str;

$mod4104r01s1 = $fir_riadok->mod4104r01s1;
$mod4104r02s1 = $fir_riadok->mod4104r02s1;
$mod4104r03s1 = $fir_riadok->mod4104r03s1;
$mod4104r04s1 = $fir_riadok->mod4104r04s1;

mysql_free_result($fir_vysledok);

    }
//koniec nacitania




?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>ätatistika E(MZSR) 1-04</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

<?php
//uprava sadzby strana 1
  if ( $copern == 2 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.mod4101s01.value = '<?php echo "$mod4101s01";?>';
    document.formv1.mod4101s02.value = '<?php echo "$mod4101s02";?>';
    document.formv1.mod4101s03.value = '<?php echo "$mod4101s03";?>';
    document.formv1.mod4101s04.value = '<?php echo "$mod4101s04";?>';
    document.formv1.mod4101s05.value = '<?php echo "$mod4101s05";?>';
    document.formv1.mod4101s06.value = '<?php echo "$mod4101s06";?>';
    document.formv1.mod4101s07.value = '<?php echo "$mod4101s07";?>';
    document.formv1.mod4101s08.value = '<?php echo "$mod4101s08";?>';
    document.formv1.mod4101s09.value = '<?php echo "$mod4101s09";?>';
    document.formv1.mod4101s10.value = '<?php echo "$mod4101s10";?>';
    document.formv1.mod4101s11.value = '<?php echo "$mod4101s11";?>';
    document.formv1.mod4101s12.value = '<?php echo "$mod4101s12";?>';
    document.formv1.mod4101s13.value = '<?php echo "$mod4101s13";?>';
    document.formv1.mod4101s14.value = '<?php echo "$mod4101s14";?>';
    document.formv1.mod4101s15.value = '<?php echo "$mod4101s15";?>';
    document.formv1.mod4101s16.value = '<?php echo "$mod4101s16";?>';

    document.formv1.mod4102s01.value = '<?php echo "$mod4102s01";?>';
    document.formv1.mod4102s02.value = '<?php echo "$mod4102s02";?>';
    document.formv1.mod4102s03.value = '<?php echo "$mod4102s03";?>';
    document.formv1.mod4102s04.value = '<?php echo "$mod4102s04";?>';
    document.formv1.mod4102s05.value = '<?php echo "$mod4102s05";?>';
    document.formv1.mod4102s06.value = '<?php echo "$mod4102s06";?>';
    document.formv1.mod4102s07.value = '<?php echo "$mod4102s07";?>';
    document.formv1.mod4102s08.value = '<?php echo "$mod4102s08";?>';
    document.formv1.mod4102s09.value = '<?php echo "$mod4102s09";?>';
    document.formv1.mod4102s10.value = '<?php echo "$mod4102s10";?>';
    document.formv1.mod4102s11.value = '<?php echo "$mod4102s11";?>';
    document.formv1.mod4102s12.value = '<?php echo "$mod4102s12";?>';
    document.formv1.mod4102s13.value = '<?php echo "$mod4102s13";?>';
    document.formv1.mod4102s14.value = '<?php echo "$mod4102s14";?>';

    }
<?php
//koniec uprava
  }
?>

<?php
//uprava sadzby strana 2
  if ( $copern == 102 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.mod4103r01s1.value = '<?php echo "$mod4103r01s1";?>';
    document.formv1.mod4103r02s1.value = '<?php echo "$mod4103r02s1";?>';
    document.formv1.mod4103r03s1.value = '<?php echo "$mod4103r03s1";?>';
    document.formv1.mod4103r04s1.value = '<?php echo "$mod4103r04s1";?>';
    document.formv1.mod4103r05s1.value = '<?php echo "$mod4103r05s1";?>';
    document.formv1.mod4103r06s1.value = '<?php echo "$mod4103r06s1";?>';
    document.formv1.mod4103r07s1.value = '<?php echo "$mod4103r07s1";?>';
    document.formv1.mod4103r08s1.value = '<?php echo "$mod4103r08s1";?>';
    document.formv1.mod4103r09s1.value = '<?php echo "$mod4103r09s1";?>';
    document.formv1.mod4103r10s1.value = '<?php echo "$mod4103r10s1";?>';
    document.formv1.mod4103r11s1.value = '<?php echo "$mod4103r11s1";?>';
    document.formv1.mod4103r12s1.value = '<?php echo "$mod4103r12s1";?>';
    document.formv1.mod4103r13s1.value = '<?php echo "$mod4103r13s1";?>';
    document.formv1.mod4103r14s1.value = '<?php echo "$mod4103r14s1";?>';
    document.formv1.mod4103r15s1.value = '<?php echo "$mod4103r15s1";?>';

    document.formv1.mod4103r01s2.value = '<?php echo "$mod4103r01s2";?>';
    document.formv1.mod4103r02s2.value = '<?php echo "$mod4103r02s2";?>';
    document.formv1.mod4103r03s2.value = '<?php echo "$mod4103r03s2";?>';
    document.formv1.mod4103r04s2.value = '<?php echo "$mod4103r04s2";?>';
    document.formv1.mod4103r05s2.value = '<?php echo "$mod4103r05s2";?>';
    document.formv1.mod4103r06s2.value = '<?php echo "$mod4103r06s2";?>';
    document.formv1.mod4103r07s2.value = '<?php echo "$mod4103r07s2";?>';
    document.formv1.mod4103r08s2.value = '<?php echo "$mod4103r08s2";?>';
    document.formv1.mod4103r09s2.value = '<?php echo "$mod4103r09s2";?>';
    document.formv1.mod4103r10s2.value = '<?php echo "$mod4103r10s2";?>';
    document.formv1.mod4103r11s2.value = '<?php echo "$mod4103r11s2";?>';
    document.formv1.mod4103r12s2.value = '<?php echo "$mod4103r12s2";?>';
    document.formv1.mod4103r13s2.value = '<?php echo "$mod4103r13s2";?>';
    document.formv1.mod4103r14s2.value = '<?php echo "$mod4103r14s2";?>';
    document.formv1.mod4103r15s2.value = '<?php echo "$mod4103r15s2";?>';
    document.formv1.mod4103r01s3.value = '<?php echo "$mod4103r01s3";?>';
    document.formv1.mod4103r02s3.value = '<?php echo "$mod4103r02s3";?>';
    document.formv1.mod4103r03s3.value = '<?php echo "$mod4103r03s3";?>';
    document.formv1.mod4103r04s3.value = '<?php echo "$mod4103r04s3";?>';
    document.formv1.mod4103r05s3.value = '<?php echo "$mod4103r05s3";?>';
    document.formv1.mod4103r06s3.value = '<?php echo "$mod4103r06s3";?>';
    document.formv1.mod4103r07s3.value = '<?php echo "$mod4103r07s3";?>';
    document.formv1.mod4103r08s3.value = '<?php echo "$mod4103r08s3";?>';
    document.formv1.mod4103r09s3.value = '<?php echo "$mod4103r09s3";?>';
    document.formv1.mod4103r10s3.value = '<?php echo "$mod4103r10s3";?>';
    document.formv1.mod4103r11s3.value = '<?php echo "$mod4103r11s3";?>';
    document.formv1.mod4103r12s3.value = '<?php echo "$mod4103r12s3";?>';
    document.formv1.mod4103r13s3.value = '<?php echo "$mod4103r13s3";?>';
    document.formv1.mod4103r14s3.value = '<?php echo "$mod4103r14s3";?>';
    document.formv1.mod4103r15s3.value = '<?php echo "$mod4103r15s3";?>';
    document.formv1.mod4103r01s4.value = '<?php echo "$mod4103r01s4";?>';
    document.formv1.mod4103r02s4.value = '<?php echo "$mod4103r02s4";?>';
    document.formv1.mod4103r03s4.value = '<?php echo "$mod4103r03s4";?>';
    document.formv1.mod4103r04s4.value = '<?php echo "$mod4103r04s4";?>';
    document.formv1.mod4103r05s4.value = '<?php echo "$mod4103r05s4";?>';
    document.formv1.mod4103r06s4.value = '<?php echo "$mod4103r06s4";?>';
    document.formv1.mod4103r07s4.value = '<?php echo "$mod4103r07s4";?>';
    document.formv1.mod4103r08s4.value = '<?php echo "$mod4103r08s4";?>';
    document.formv1.mod4103r09s4.value = '<?php echo "$mod4103r09s4";?>';
    document.formv1.mod4103r10s4.value = '<?php echo "$mod4103r10s4";?>';
    document.formv1.mod4103r11s4.value = '<?php echo "$mod4103r11s4";?>';
    document.formv1.mod4103r12s4.value = '<?php echo "$mod4103r12s4";?>';
    document.formv1.mod4103r13s4.value = '<?php echo "$mod4103r13s4";?>';
    document.formv1.mod4103r14s4.value = '<?php echo "$mod4103r14s4";?>';
    document.formv1.mod4103r15s4.value = '<?php echo "$mod4103r15s4";?>';
    document.formv1.mod4103r01s5.value = '<?php echo "$mod4103r01s5";?>';
    document.formv1.mod4103r02s5.value = '<?php echo "$mod4103r02s5";?>';
    document.formv1.mod4103r03s5.value = '<?php echo "$mod4103r03s5";?>';
    document.formv1.mod4103r04s5.value = '<?php echo "$mod4103r04s5";?>';
    document.formv1.mod4103r05s5.value = '<?php echo "$mod4103r05s5";?>';
    document.formv1.mod4103r06s5.value = '<?php echo "$mod4103r06s5";?>';
    document.formv1.mod4103r07s5.value = '<?php echo "$mod4103r07s5";?>';
    document.formv1.mod4103r08s5.value = '<?php echo "$mod4103r08s5";?>';
    document.formv1.mod4103r09s5.value = '<?php echo "$mod4103r09s5";?>';
    document.formv1.mod4103r10s5.value = '<?php echo "$mod4103r10s5";?>';
    document.formv1.mod4103r11s5.value = '<?php echo "$mod4103r11s5";?>';
    document.formv1.mod4103r12s5.value = '<?php echo "$mod4103r12s5";?>';
    document.formv1.mod4103r13s5.value = '<?php echo "$mod4103r13s5";?>';
    document.formv1.mod4103r14s5.value = '<?php echo "$mod4103r14s5";?>';
    document.formv1.mod4103r15s5.value = '<?php echo "$mod4103r15s5";?>';
    document.formv1.mod4103r01s6.value = '<?php echo "$mod4103r01s6";?>';
    document.formv1.mod4103r02s6.value = '<?php echo "$mod4103r02s6";?>';
    document.formv1.mod4103r03s6.value = '<?php echo "$mod4103r03s6";?>';
    document.formv1.mod4103r04s6.value = '<?php echo "$mod4103r04s6";?>';
    document.formv1.mod4103r05s6.value = '<?php echo "$mod4103r05s6";?>';
    document.formv1.mod4103r06s6.value = '<?php echo "$mod4103r06s6";?>';
    document.formv1.mod4103r07s6.value = '<?php echo "$mod4103r07s6";?>';
    document.formv1.mod4103r08s6.value = '<?php echo "$mod4103r08s6";?>';
    document.formv1.mod4103r09s6.value = '<?php echo "$mod4103r09s6";?>';
    document.formv1.mod4103r10s6.value = '<?php echo "$mod4103r10s6";?>';
    document.formv1.mod4103r11s6.value = '<?php echo "$mod4103r11s6";?>';
    document.formv1.mod4103r12s6.value = '<?php echo "$mod4103r12s6";?>';
    document.formv1.mod4103r13s6.value = '<?php echo "$mod4103r13s6";?>';
    document.formv1.mod4103r14s6.value = '<?php echo "$mod4103r14s6";?>';
    document.formv1.mod4103r15s6.value = '<?php echo "$mod4103r15s6";?>';
    document.formv1.mod4103r01s7.value = '<?php echo "$mod4103r01s7";?>';
    document.formv1.mod4103r02s7.value = '<?php echo "$mod4103r02s7";?>';
    document.formv1.mod4103r03s7.value = '<?php echo "$mod4103r03s7";?>';
    document.formv1.mod4103r04s7.value = '<?php echo "$mod4103r04s7";?>';
    document.formv1.mod4103r05s7.value = '<?php echo "$mod4103r05s7";?>';
    document.formv1.mod4103r06s7.value = '<?php echo "$mod4103r06s7";?>';
    document.formv1.mod4103r07s7.value = '<?php echo "$mod4103r07s7";?>';
    document.formv1.mod4103r08s7.value = '<?php echo "$mod4103r08s7";?>';
    document.formv1.mod4103r09s7.value = '<?php echo "$mod4103r09s7";?>';
    document.formv1.mod4103r10s7.value = '<?php echo "$mod4103r10s7";?>';
    document.formv1.mod4103r11s7.value = '<?php echo "$mod4103r11s7";?>';
    document.formv1.mod4103r12s7.value = '<?php echo "$mod4103r12s7";?>';
    document.formv1.mod4103r13s7.value = '<?php echo "$mod4103r13s7";?>';
    document.formv1.mod4103r14s7.value = '<?php echo "$mod4103r14s7";?>';
    document.formv1.mod4103r15s7.value = '<?php echo "$mod4103r15s7";?>';

    document.formv1.mod4103r01str.value = '<?php echo "$mod4103r01str";?>';
    document.formv1.mod4103r02str.value = '<?php echo "$mod4103r02str";?>';
    document.formv1.mod4103r03str.value = '<?php echo "$mod4103r03str";?>';
    document.formv1.mod4103r04str.value = '<?php echo "$mod4103r04str";?>';
    document.formv1.mod4103r05str.value = '<?php echo "$mod4103r05str";?>';
    document.formv1.mod4103r06str.value = '<?php echo "$mod4103r06str";?>';
    document.formv1.mod4103r07str.value = '<?php echo "$mod4103r07str";?>';
    document.formv1.mod4103r08str.value = '<?php echo "$mod4103r08str";?>';
    document.formv1.mod4103r09str.value = '<?php echo "$mod4103r09str";?>';
    document.formv1.mod4103r10str.value = '<?php echo "$mod4103r10str";?>';
    document.formv1.mod4103r11str.value = '<?php echo "$mod4103r11str";?>';
    document.formv1.mod4103r12str.value = '<?php echo "$mod4103r12str";?>';
    document.formv1.mod4103r13str.value = '<?php echo "$mod4103r13str";?>';
    document.formv1.mod4103r14str.value = '<?php echo "$mod4103r14str";?>';
    document.formv1.mod4103r15str.value = '<?php echo "$mod4103r15str";?>';

    document.formv1.mod4104r01s1.value = '<?php echo "$mod4104r01s1";?>';
    document.formv1.mod4104r02s1.value = '<?php echo "$mod4104r02s1";?>';
    document.formv1.mod4104r03s1.value = '<?php echo "$mod4104r03s1";?>';
    document.formv1.mod4104r04s1.value = '<?php echo "$mod4104r04s1";?>';

    }
<?php
//koniec uprava
  }
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
//koniec uprava
  }
?>



</script>



</HEAD>
<BODY class="white" onload="ObnovUI();" >

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  
<?php
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 OR $copern == 11 OR $copern == 12 ) { echo " V˝kaz o ekonomike organiz·ciÌ v zdravotnÌctve E(MZSR) 1-04 ";
}
?>
<?php
  if ( $copern == 101 OR $copern == 102 OR $copern == 103 ) { echo " V˝kaz o ekonomike organiz·ciÌ v zdravotnÌctve E(MZSR) 1-04 ";
}
?>
  <a href="#" onClick="window.open('../ucto/statistika_e104.php?copern=11&drupoh=1&page=1&typ=PDF', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='VytlaËiù cel˝ v˝kaz vo form·te PDF' ></a>
  <a href="#" onClick="window.open('../ucto/statistika_e104.php?copern=12&drupoh=1&page=1&typ=PDF', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/orig.png' width=20 height=15 border=0 alt='Vytvoriù XMLs˙bor na odoslanie' ></a>
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//zobraz nastavene udaje strana 1
if ( $copern == 1 OR $copern == 3 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 2 desatinnÈ miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 4 desatinnÈ miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 1 desatinnÈ miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_oc;?> spr·vne uloûen·</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="statistika_e104.php?copern=2" >
<tr>
<td class="bmenu" width="10%">
<a href="#" onClick="window.open('../ucto/statistika_e104.php?copern=101&drupoh=1&page=1&typ=PDF', '_self', '<?php echo $tlcswin; ?>' )">
4103.,4104.modul</a>
</td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
</tr>


<tr><td class="bmenu" colspan="5">4101. modul N·klady v EUR - n·kladovÈ ˙Ëty zapoËÌtanÈ do stÂpcov</td>
<td class="bmenu" colspan="3">⁄Ëty v tvare : 501010,502020,504002 </td>
<td class="obyc" colspan="2" align="right"><INPUT type="submit" id="uloz" name="uloz" value="Upraviù ˙daje"></td>
</tr>

<tr><td class="fmenu" colspan="3">1. N·klady na mzdy</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4101s01";?></td></tr>

<tr><td class="fmenu" colspan="3">2. N·klady na odvody</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4101s02";?></td></tr>

<tr><td class="fmenu" colspan="3">3. N·klady na lieky</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4101s03";?></td></tr>

<tr><td class="fmenu" colspan="3">4. N·klady na zdravotnÌcke pomÙcky</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4101s04";?></td></tr>

<tr><td class="fmenu" colspan="3">5. N·klady na doplnkov˝ sortiment lek·rnÌ</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4101s05";?></td></tr>

<tr><td class="fmenu" colspan="3">6. N·klady na krv a krvnÈ v˝robky</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4101s06";?></td></tr>

<tr><td class="fmenu" colspan="3">7. N·klady na odpisy zdravotnÌckej techniky</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4101s07";?></td></tr>

<tr><td class="fmenu" colspan="3">8. N·klady na odpisy ostatnÈ</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4101s08";?></td></tr>

<tr><td class="fmenu" colspan="3">9. N·klady na stravovanie pacientov</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4101s09";?></td></tr>

<tr><td class="fmenu" colspan="3">10. N·klady na spotrebu energie</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4101s10";?></td></tr>

<tr><td class="fmenu" colspan="3">11. N·klady na opravy a ˙drûbu ZT</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4101s11";?></td></tr>

<tr><td class="fmenu" colspan="3">12. N·klady na ostatnÈ opravy a ˙drûbu</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4101s12";?></td></tr>

<tr><td class="fmenu" colspan="3">13. N·klady na ostatn˙ hosp.technick˙ spr·vu</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4101s13";?></td></tr>

<tr><td class="fmenu" colspan="3">14. N·klady na zdravotnÌcku dopravu</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4101s14";?></td></tr>

<tr><td class="fmenu" colspan="3">15. N·klady na hospod·rsku dopravu</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4101s15";?></td></tr>

<tr><td class="fmenu" colspan="3">16. OstatnÈ n·klady</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4101s16";?></td></tr>




<tr><td class="bmenu" colspan="5">4102. modul V˝nosy v EUR - trûbovÈ ˙Ëty zapoËÌtanÈ do stÂpcov</td>
<td class="bmenu" colspan="5">⁄Ëty v tvare : 601010,602020,604002 </td>
</tr>

<tr><td class="fmenu" colspan="3">1. Trûby od ZP za ukonËenÈ hospitaliz·cie</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4102s01";?></td></tr>

<tr><td class="fmenu" colspan="3">2. Trûby od ZP za oöetrovacie dni</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4102s02";?></td></tr>

<tr><td class="fmenu" colspan="3">3. Trûby od ZP za pripoË.poloûky</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4102s03";?></td></tr>

<tr><td class="fmenu" colspan="3">4. Trûby od ZP za deÚ pobytu v stacion·ry</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4102s04";?></td></tr>

<tr><td class="fmenu" colspan="3">5. Trûby od ZP za v˝kony jednodnÚovej starostlivosti</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4102s05";?></td></tr>

<tr><td class="fmenu" colspan="3">6. Trûby od ZP za body</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4102s06";?></td></tr>

<tr><td class="fmenu" colspan="3">7. Trûby od ZP za kapit·ciu/pauö·l</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4102s07";?></td></tr>

<tr><td class="fmenu" colspan="3">8. Trûby od ZP za inÈ</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4102s08";?></td></tr>

<tr><td class="fmenu" colspan="3">9. Trûby od obyv. za lieky</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4102s09";?></td></tr>

<tr><td class="fmenu" colspan="3">10. Trûby od obyv. za zdravotnÌcke pomÙcky</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4102s10";?></td></tr>

<tr><td class="fmenu" colspan="3">11. Trûby od obyv. za doplnkov˝ sortiment lek·rnÌ</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4102s11";?></td></tr>

<tr><td class="fmenu" colspan="3">12. Trûby od obyv. za inÈ</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4102s12";?></td></tr>

<tr><td class="fmenu" colspan="3">13. Prev·dzkovÈ dot·cie od zriaÔovateæa</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4102s13";?></td></tr>

<tr><td class="fmenu" colspan="3">14. OstatnÈ v˝nosy</td>
<td class="fmenu" colspan="6" align="left"><?php echo "$mod4102s14";?></td></tr>

</FORM>

</table>
<?php
    }
//koniec zobrazenia udajov strana 1
?>

<?php
//zobraz nastavene udaje strana 2
if ( $copern == 101 OR $copern == 103 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 2 desatinnÈ miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 4 desatinnÈ miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 1 desatinnÈ miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_oc;?> spr·vne uloûen·</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="statistika_e104.php?copern=102" >
<tr>
<td class="bmenu" width="10%">
<a href="#" onClick="window.open('../ucto/statistika_e104.php?copern=1&drupoh=1&page=1&typ=PDF', '_self', '<?php echo $tlcswin; ?>' )">
4101.,4102.modul</a>
</td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
</tr>

<tr><td class="bmenu" colspan="5">4103. modul VybranÈ ukazovatele</td>
<td class="obyc" colspan="4" align="right"><INPUT type="submit" id="uloz" name="uloz" value="Upraviù ˙daje"></td>
</tr>

<tr>
<td class="fmenu" colspan="1">KÛd n·kladovÈho strediska</td>
<td class="fmenu" colspan="1" align="center">l.r.</td>
<td class="fmenu" colspan="1">1. PoËet bodov</td>
<td class="fmenu" colspan="1">2. PoËet v˝konov</td>
<td class="fmenu" colspan="1">3. PoËet oöetrovacÌch dnÌ</td>
<td class="fmenu" colspan="1">4. PoËet pacientov na dohodu</td>
<td class="fmenu" colspan="1">5. SkutoËn· posteæov· kapacita</td>
<td class="fmenu" colspan="1">6. PoËet ukonËen˝ch hospitaliz·ciÌ</td>
<td class="fmenu" colspan="1">7. PoËet km v DZS</td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r01str";?></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r01s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r01s2";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r01s3";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r01s4";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r01s5";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r01s6";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r01s7";?></td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r02str";?></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r02s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r02s2";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r02s3";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r02s4";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r02s5";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r02s6";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r02s7";?></td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r03str";?></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r03s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r03s2";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r03s3";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r03s4";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r03s5";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r03s6";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r03s7";?></td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r04str";?></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r04s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r04s2";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r04s3";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r04s4";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r04s5";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r04s6";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r04s7";?></td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r05str";?></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r05s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r05s2";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r05s3";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r05s4";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r05s5";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r05s6";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r05s7";?></td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r06str";?></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r06s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r06s2";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r06s3";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r06s4";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r06s5";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r06s6";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r06s7";?></td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r07str";?></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r07s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r07s2";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r07s3";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r07s4";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r07s5";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r07s6";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r07s7";?></td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r08str";?></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r08s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r08s2";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r08s3";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r08s4";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r08s5";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r08s6";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r08s7";?></td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r09str";?></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r09s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r09s2";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r09s3";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r09s4";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r09s5";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r09s6";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r09s7";?></td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r10str";?></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r10s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r10s2";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r10s3";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r10s4";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r10s5";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r10s6";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r10s7";?></td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r11str";?></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r11s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r11s2";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r11s3";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r11s4";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r11s5";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r11s6";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r11s7";?></td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r12str";?></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r12s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r12s2";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r12s3";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r12s4";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r12s5";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r12s6";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r12s7";?></td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r13str";?></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r13s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r13s2";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r13s3";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r13s4";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r13s5";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r13s6";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r13s7";?></td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r14str";?></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r14s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r14s2";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r14s3";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r14s4";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r14s5";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r14s6";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r14s7";?></td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r15str";?></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r15s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r15s2";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r15s3";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r15s4";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r15s5";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r15s6";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4103r15s7";?></td>
</tr>





<tr><td class="bmenu" colspan="5">4104. modul PrijatÈ dary a nesplatenÈ z·v‰zky za poskytovateæa ZS v Eur</td>
</tr>

<tr>
<td class="fmenu" colspan="1"> </td>
<td class="fmenu" colspan="1" align="center">l.r.</td>
<td class="fmenu" colspan="1">1. PrijatÈ dary finanËne</td>
<td class="fmenu" colspan="1">2. Nesplaten˝ bank.˙ver</td>
<td class="fmenu" colspan="1">3. Nesplaten˝ in˝ ˙ver</td>
<td class="fmenu" colspan="1">4. Nesplaten˝ lÌzing</td>
</tr>

<tr>
<td class="fmenu" colspan="1">Dary a z·v‰zky</td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4104r01s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4104r02s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4104r03s1";?></td>
<td class="fmenu" colspan="1" align="right"><?php echo "$mod4104r04s1";?></td>
</tr>

</FORM>

</table>
<?php
    }
//koniec zobrazenia udajov strana 2
?>

<?php
//upravy  udaje strana 1
if ( $copern == 2 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 2 desatinnÈ miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 4 desatinnÈ miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 1 desatinnÈ miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_oc;?> spr·vne uloûen·</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="statistika_e104.php?copern=3" >
<tr>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
</tr>


<tr><td class="bmenu" colspan="5">4101. modul N·klady v EUR - n·kladovÈ ˙Ëty zapoËÌtanÈ do stÂpcov</td>
<td class="bmenu" colspan="3">⁄Ëty v tvare : 501010,502020,504002 </td>
</tr>

<tr><td class="fmenu" colspan="3">1. N·klady na mzdy</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4101s01" id="mod4101s01" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">2. N·klady na odvody</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4101s02" id="mod4101s02" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">3. N·klady na lieky</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4101s03" id="mod4101s03" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">4. N·klady na zdravotnÌcke pomÙcky</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4101s04" id="mod4101s04" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">5. N·klady na doplnkov˝ sortiment lek·rnÌ</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4101s05" id="mod4101s05" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">6. N·klady na krv a krvnÈ v˝robky</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4101s06" id="mod4101s06" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">7. N·klady na odpisy zdravotnÌckej techniky</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4101s07" id="mod4101s07" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">8. N·klady na odpisy ostatnÈ</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4101s08" id="mod4101s08" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">9. N·klady na stravovanie pacientov</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4101s09" id="mod4101s09" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">10. N·klady na spotrebu energie</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4101s10" id="mod4101s10" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">11. N·klady na opravy a ˙drûbu ZT</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4101s11" id="mod4101s11" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">12. N·klady na ostatnÈ opravy a ˙drûbu</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4101s12" id="mod4101s12" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">13. N·klady na ostatn˙ hosp.technick˙ spr·vu</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4101s13" id="mod4101s13" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">14. N·klady na zdravotnÌcku dopravu</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4101s14" id="mod4101s14" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">15. N·klady na hospod·rsku dopravu</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4101s15" id="mod4101s15" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">16. OstatnÈ n·klady</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4101s16" id="mod4101s16" size="90"/></td></tr>




<tr><td class="bmenu" colspan="5">4102. modul V˝nosy v EUR - trûbovÈ ˙Ëty zapoËÌtanÈ do stÂpcov</td>
<td class="bmenu" colspan="5">⁄Ëty v tvare : 601010,602020,604002 </td>
</tr>

<tr><td class="fmenu" colspan="3">1. Trûby od ZP za ukonËenÈ hospitaliz·cie</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4102s01" id="mod4102s01" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">2. Trûby od ZP za oöetrovacie dni</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4102s02" id="mod4102s02" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">3. Trûby od ZP za pripoË.poloûky</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4102s03" id="mod4102s03" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">4. Trûby od ZP za deÚ pobytu v stacion·ry</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4102s04" id="mod4102s04" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">5. Trûby od ZP za v˝kony jednodnÚovej starostlivosti</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4102s05" id="mod4102s05" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">6. Trûby od ZP za body</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4102s06" id="mod4102s06" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">7. Trûby od ZP za kapit·ciu/pauö·l</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4102s07" id="mod4102s07" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">8. Trûby od ZP za inÈ</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4102s08" id="mod4102s08" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">9. Trûby od obyv. za lieky</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4102s09" id="mod4102s09" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">10. Trûby od obyv. za zdravotnÌcke pomÙcky</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4102s10" id="mod4102s10" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">11. Trûby od obyv. za doplnkov˝ sortiment lek·rnÌ</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4102s11" id="mod4102s11" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">12. Trûby od obyv. za inÈ</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4102s12" id="mod4102s12" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">13. Prev·dzkovÈ dot·cie od zriaÔovateæa</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4102s13" id="mod4102s13" size="90"/></td></tr>

<tr><td class="fmenu" colspan="3">14. OstatnÈ v˝nosy</td>
<td class="fmenu" colspan="6" align="left"><input type="text" name="mod4102s14" id="mod4102s14" size="90"/></td></tr>


<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù ˙pravy"></td>
</tr>
</FORM>

<FORM name="formv2" class="obyc" method="post" action="statistika_e104.php?copern=1" >
<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Koniec neuloûiù"></td>
</tr>
</FORM>

</table>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>


<script type="text/javascript">

</script>

<?php
//mysql_free_result($vysledok);
    }
//koniec uprav  udaje strana 1
?>


<?php
//upravy  udaje strana 2
if ( $copern == 102 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 2 desatinnÈ miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 4 desatinnÈ miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 1 desatinnÈ miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_oc;?> spr·vne uloûen·</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="statistika_e104.php?copern=103" >
<tr>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
</tr>

<tr><td class="bmenu" colspan="5">4103. modul VybranÈ ukazovatele</td>
</tr>

<tr>
<td class="fmenu" colspan="1">KÛd n·kladovÈho strediska</td>
<td class="fmenu" colspan="1" align="center">l.r.</td>
<td class="fmenu" colspan="1">1. PoËet bodov</td>
<td class="fmenu" colspan="1">2. PoËet v˝konov</td>
<td class="fmenu" colspan="1">3. PoËet oöetrovacÌch dnÌ</td>
<td class="fmenu" colspan="1">4. PoËet pacientov na dohodu</td>
<td class="fmenu" colspan="1">5. SkutoËn· posteæov· kapacita</td>
<td class="fmenu" colspan="1">6. PoËet ukonËen˝ch hospitaliz·ciÌ</td>
<td class="fmenu" colspan="1">7. PoËet km v DZS</td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r01str" id="mod4103r01str" size="8"/></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r01s1" id="mod4103r01s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r01s2" id="mod4103r01s2" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r01s3" id="mod4103r01s3" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r01s4" id="mod4103r01s4" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r01s5" id="mod4103r01s5" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r01s6" id="mod4103r01s6" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r01s7" id="mod4103r01s7" size="8"/></td>
</tr>

<tr>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r02str" id="mod4103r02str" size="8"/></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r02s1" id="mod4103r02s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r02s2" id="mod4103r02s2" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r02s3" id="mod4103r02s3" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r02s4" id="mod4103r02s4" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r02s5" id="mod4103r02s5" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r02s6" id="mod4103r02s6" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r02s7" id="mod4103r02s7" size="8"/></td>
</tr>
<tr>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r03str" id="mod4103r03str" size="8"/></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r03s1" id="mod4103r03s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r03s2" id="mod4103r03s2" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r03s3" id="mod4103r03s3" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r03s4" id="mod4103r03s4" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r03s5" id="mod4103r03s5" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r03s6" id="mod4103r03s6" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r03s7" id="mod4103r03s7" size="8"/></td>
</tr>
<tr>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r04str" id="mod4103r04str" size="8"/></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r04s1" id="mod4103r04s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r04s2" id="mod4103r04s2" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r04s3" id="mod4103r04s3" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r04s4" id="mod4103r04s4" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r04s5" id="mod4103r04s5" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r04s6" id="mod4103r04s6" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r04s7" id="mod4103r04s7" size="8"/></td>
</tr>
<tr>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r05str" id="mod4103r05str" size="8"/></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r05s1" id="mod4103r05s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r05s2" id="mod4103r05s2" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r05s3" id="mod4103r05s3" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r05s4" id="mod4103r05s4" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r05s5" id="mod4103r05s5" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r05s6" id="mod4103r05s6" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r05s7" id="mod4103r05s7" size="8"/></td>
</tr>
<tr>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r06str" id="mod4103r06str" size="8"/></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r06s1" id="mod4103r06s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r06s2" id="mod4103r06s2" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r06s3" id="mod4103r06s3" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r06s4" id="mod4103r06s4" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r06s5" id="mod4103r06s5" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r06s6" id="mod4103r06s6" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r06s7" id="mod4103r06s7" size="8"/></td>
</tr>
<tr>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r07str" id="mod4103r07str" size="8"/></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r07s1" id="mod4103r07s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r07s2" id="mod4103r07s2" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r07s3" id="mod4103r07s3" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r07s4" id="mod4103r07s4" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r07s5" id="mod4103r07s5" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r07s6" id="mod4103r07s6" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r07s7" id="mod4103r07s7" size="8"/></td>
</tr>
<tr>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r08str" id="mod4103r08str" size="8"/></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r08s1" id="mod4103r08s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r08s2" id="mod4103r08s2" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r08s3" id="mod4103r08s3" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r08s4" id="mod4103r08s4" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r08s5" id="mod4103r08s5" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r08s6" id="mod4103r08s6" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r08s7" id="mod4103r08s7" size="8"/></td>
</tr>
<tr>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r09str" id="mod4103r09str" size="8"/></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r09s1" id="mod4103r09s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r09s2" id="mod4103r09s2" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r09s3" id="mod4103r09s3" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r09s4" id="mod4103r09s4" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r09s5" id="mod4103r09s5" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r09s6" id="mod4103r09s6" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r09s7" id="mod4103r09s7" size="8"/></td>
</tr>
<tr>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r10str" id="mod4103r10str" size="8"/></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r10s1" id="mod4103r10s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r10s2" id="mod4103r10s2" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r10s3" id="mod4103r10s3" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r10s4" id="mod4103r10s4" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r10s5" id="mod4103r10s5" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r10s6" id="mod4103r10s6" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r10s7" id="mod4103r10s7" size="8"/></td>
</tr>
<tr>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r11str" id="mod4103r11str" size="8"/></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r11s1" id="mod4103r11s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r11s2" id="mod4103r11s2" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r11s3" id="mod4103r11s3" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r11s4" id="mod4103r11s4" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r11s5" id="mod4103r11s5" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r11s6" id="mod4103r11s6" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r11s7" id="mod4103r11s7" size="8"/></td>
</tr>
<tr>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r12str" id="mod4103r12str" size="8"/></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r12s1" id="mod4103r12s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r12s2" id="mod4103r12s2" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r12s3" id="mod4103r12s3" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r12s4" id="mod4103r12s4" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r12s5" id="mod4103r12s5" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r12s6" id="mod4103r12s6" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r12s7" id="mod4103r12s7" size="8"/></td>
</tr>
<tr>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r13str" id="mod4103r13str" size="8"/></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r13s1" id="mod4103r13s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r13s2" id="mod4103r13s2" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r13s3" id="mod4103r13s3" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r13s4" id="mod4103r13s4" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r13s5" id="mod4103r13s5" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r13s6" id="mod4103r13s6" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r13s7" id="mod4103r13s7" size="8"/></td>
</tr>
<tr>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r14str" id="mod4103r14str" size="8"/></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r14s1" id="mod4103r14s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r14s2" id="mod4103r14s2" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r14s3" id="mod4103r14s3" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r14s4" id="mod4103r14s4" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r14s5" id="mod4103r14s5" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r14s6" id="mod4103r14s6" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r14s7" id="mod4103r14s7" size="8"/></td>
</tr>
<tr>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r15str" id="mod4103r15str" size="8"/></td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r15s1" id="mod4103r15s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r15s2" id="mod4103r15s2" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r15s3" id="mod4103r15s3" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r15s4" id="mod4103r15s4" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r15s5" id="mod4103r15s5" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r15s6" id="mod4103r15s6" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4103r15s7" id="mod4103r15s7" size="8"/></td>
</tr>



<tr><td class="bmenu" colspan="5">4104. modul PrijatÈ dary a nesplatenÈ z·v‰zky za poskytovateæa ZS v Eur</td>
</tr>

<tr>
<td class="fmenu" colspan="1"> </td>
<td class="fmenu" colspan="1" align="center">l.r.</td>
<td class="fmenu" colspan="1">1. PrijatÈ dary finanËne</td>
<td class="fmenu" colspan="1">2. Nesplaten˝ bank.˙ver</td>
<td class="fmenu" colspan="1">3. Nesplaten˝ in˝ ˙ver</td>
<td class="fmenu" colspan="1">4. Nesplaten˝ lÌzing</td>
</tr>

<tr>
<td class="fmenu" colspan="1">Dary a z·v‰zky</td>
<td class="fmenu" colspan="1" align="center">a</td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4104r01s1" id="mod4104r01s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4104r02s1" id="mod4104r02s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4104r03s1" id="mod4104r03s1" size="8"/></td>
<td class="fmenu" colspan="1" align="right"><input type="text" name="mod4104r04s1" id="mod4104r04s1" size="8"/></td>
</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù ˙pravy"></td>
</tr>
</FORM>

<FORM name="formv2" class="obyc" method="post" action="statistika_e104.php?copern=101" >
<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Koniec neuloûiù"></td>
</tr>
</FORM>

</table>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>


<script type="text/javascript">

</script>

<?php
//mysql_free_result($vysledok);
    }
//koniec uprav  udaje strana 2
?>



<?php
//zostava PDF a odoslanie
if( $copern == 11 OR $copern == 12 )
          {
if (File_Exists ("../tmp/statistika.$kli_uzid.pdf")) { $soubor = unlink("../tmp/statistika.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$pdf=new FPDF("L","mm", "A4" );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//pracovny subor
$vsql = 'DROP TABLE F'.$kli_vxcf.'_statistika_e104prac';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_e104
(
   prx              INT,
   strx             VARCHAR(10),
   zakx             VARCHAR(10),
   nstr             VARCHAR(10),
   ucmx             VARCHAR(10),
   ucdx             VARCHAR(10),
   hodx             DECIMAL(10,2) DEFAULT 0,
   mod4101s01       DECIMAL(10,2) DEFAULT 0,
   mod4101s02       DECIMAL(10,2) DEFAULT 0,
   mod4101s03       DECIMAL(10,2) DEFAULT 0,
   mod4101s04       DECIMAL(10,2) DEFAULT 0,
   mod4101s05       DECIMAL(10,2) DEFAULT 0,
   mod4101s06       DECIMAL(10,2) DEFAULT 0,
   mod4101s07       DECIMAL(10,2) DEFAULT 0,
   mod4101s08       DECIMAL(10,2) DEFAULT 0,
   mod4101s09       DECIMAL(10,2) DEFAULT 0,
   mod4101s10       DECIMAL(10,2) DEFAULT 0,
   mod4101s11       DECIMAL(10,2) DEFAULT 0,
   mod4101s12       DECIMAL(10,2) DEFAULT 0,
   mod4101s13       DECIMAL(10,2) DEFAULT 0,
   mod4101s14       DECIMAL(10,2) DEFAULT 0,
   mod4101s15       DECIMAL(10,2) DEFAULT 0,
   mod4101s16       DECIMAL(10,2) DEFAULT 0,
   mod4102s01       DECIMAL(10,2) DEFAULT 0,
   mod4102s02       DECIMAL(10,2) DEFAULT 0,
   mod4102s03       DECIMAL(10,2) DEFAULT 0,
   mod4102s04       DECIMAL(10,2) DEFAULT 0,
   mod4102s05       DECIMAL(10,2) DEFAULT 0,
   mod4102s06       DECIMAL(10,2) DEFAULT 0,
   mod4102s07       DECIMAL(10,2) DEFAULT 0,
   mod4102s08       DECIMAL(10,2) DEFAULT 0,
   mod4102s09       DECIMAL(10,2) DEFAULT 0,
   mod4102s10       DECIMAL(10,2) DEFAULT 0,
   mod4102s11       DECIMAL(10,2) DEFAULT 0,
   mod4102s12       DECIMAL(10,2) DEFAULT 0,
   mod4102s13       DECIMAL(10,2) DEFAULT 0,
   mod4102s14       DECIMAL(10,2) DEFAULT 0,
   mod4101n01       DECIMAL(10,2) DEFAULT 0,
   mod4101n02       DECIMAL(10,2) DEFAULT 0,
   mod4101n03       DECIMAL(10,2) DEFAULT 0,
   mod4101n04       DECIMAL(10,2) DEFAULT 0,
   mod4101n05       DECIMAL(10,2) DEFAULT 0,
   mod4101n06       DECIMAL(10,2) DEFAULT 0,
   mod4101n07       DECIMAL(10,2) DEFAULT 0,
   mod4101n08       DECIMAL(10,2) DEFAULT 0,
   mod4101n09       DECIMAL(10,2) DEFAULT 0,
   mod4101n10       DECIMAL(10,2) DEFAULT 0,
   mod4101n11       DECIMAL(10,2) DEFAULT 0,
   mod4101n12       DECIMAL(10,2) DEFAULT 0,
   mod4101n13       DECIMAL(10,2) DEFAULT 0,
   mod4101n14       DECIMAL(10,2) DEFAULT 0,
   mod4101n15       DECIMAL(10,2) DEFAULT 0,
   mod4101n16       DECIMAL(10,2) DEFAULT 0,
   mod4102n01       DECIMAL(10,2) DEFAULT 0,
   mod4102n02       DECIMAL(10,2) DEFAULT 0,
   mod4102n03       DECIMAL(10,2) DEFAULT 0,
   mod4102n04       DECIMAL(10,2) DEFAULT 0,
   mod4102n05       DECIMAL(10,2) DEFAULT 0,
   mod4102n06       DECIMAL(10,2) DEFAULT 0,
   mod4102n07       DECIMAL(10,2) DEFAULT 0,
   mod4102n08       DECIMAL(10,2) DEFAULT 0,
   mod4102n09       DECIMAL(10,2) DEFAULT 0,
   mod4102n10       DECIMAL(10,2) DEFAULT 0,
   mod4102n11       DECIMAL(10,2) DEFAULT 0,
   mod4102n12       DECIMAL(10,2) DEFAULT 0,
   mod4102n13       DECIMAL(10,2) DEFAULT 0,
   mod4102n14       DECIMAL(10,2) DEFAULT 0,
   icox             DECIMAL(8,0)
);  
statistika_e104;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statistika_e104prac'.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statistika_e104prac SELECT".
" 1,F$kli_vxcf"."_uctpokuct.str,F$kli_vxcf"."_uctpokuct.zak,F$kli_vxcf"."_uctpokuct.zak,ucm,ucd,F$kli_vxcf"."_uctpokuct.hod,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0".
" FROM F$kli_vxcf"."_pokpri,F$kli_vxcf"."_uctpokuct".
" WHERE F$kli_vxcf"."_pokpri.dok=F$kli_vxcf"."_uctpokuct.dok AND ume >= $vyb_ump AND ume <= $vyb_umk AND F$kli_vxcf"."_uctpokuct.zak > 0".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statistika_e104prac SELECT".
" 1,F$kli_vxcf"."_uctpokuct.str,F$kli_vxcf"."_uctpokuct.zak,F$kli_vxcf"."_uctpokuct.zak,ucm,ucd,F$kli_vxcf"."_uctpokuct.hod,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0".
" FROM F$kli_vxcf"."_pokvyd,F$kli_vxcf"."_uctpokuct".
" WHERE F$kli_vxcf"."_pokvyd.dok=F$kli_vxcf"."_uctpokuct.dok AND ume >= $vyb_ump AND ume <= $vyb_umk AND F$kli_vxcf"."_uctpokuct.zak > 0".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statistika_e104prac SELECT".
" 1,F$kli_vxcf"."_uctban.str,F$kli_vxcf"."_uctban.zak,F$kli_vxcf"."_uctban.zak,ucm,ucd,F$kli_vxcf"."_uctban.hod,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0".
" FROM F$kli_vxcf"."_banvyp,F$kli_vxcf"."_uctban".
" WHERE F$kli_vxcf"."_banvyp.dok=F$kli_vxcf"."_uctban.dok AND ume >= $vyb_ump AND ume <= $vyb_umk AND F$kli_vxcf"."_uctban.zak > 0".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statistika_e104prac SELECT".
" 1,F$kli_vxcf"."_uctvsdp.str,F$kli_vxcf"."_uctvsdp.zak,F$kli_vxcf"."_uctvsdp.zak,ucm,ucd,F$kli_vxcf"."_uctvsdp.hod,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0".
" FROM F$kli_vxcf"."_uctvsdh,F$kli_vxcf"."_uctvsdp".
" WHERE F$kli_vxcf"."_uctvsdh.dok=F$kli_vxcf"."_uctvsdp.dok AND ume >= $vyb_ump AND ume <= $vyb_umk AND F$kli_vxcf"."_uctvsdp.zak > 0".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statistika_e104prac SELECT".
" 1,F$kli_vxcf"."_uctdod.str,F$kli_vxcf"."_uctdod.zak,F$kli_vxcf"."_uctdod.zak,ucm,ucd,F$kli_vxcf"."_uctdod.hod,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0".
" FROM F$kli_vxcf"."_fakdod,F$kli_vxcf"."_uctdod".
" WHERE F$kli_vxcf"."_fakdod.dok=F$kli_vxcf"."_uctdod.dok AND ume >= $vyb_ump AND ume <= $vyb_umk AND F$kli_vxcf"."_uctdod.zak > 0".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statistika_e104prac SELECT".
" 1,F$kli_vxcf"."_uctodb.str,F$kli_vxcf"."_uctodb.zak,F$kli_vxcf"."_uctodb.zak,ucm,ucd,F$kli_vxcf"."_uctodb.hod,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0".
" FROM F$kli_vxcf"."_fakodb,F$kli_vxcf"."_uctodb".
" WHERE F$kli_vxcf"."_fakodb.dok=F$kli_vxcf"."_uctodb.dok AND ume >= $vyb_ump AND ume <= $vyb_umk AND F$kli_vxcf"."_uctodb.zak > 0".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statistika_e104prac SELECT".
" 1,str,zak,zak,ucm,ucd,hod,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0".
" FROM F$kli_vxcf"."_uctskl".
" WHERE ume >= $vyb_ump AND ume <= $vyb_umk AND zak > 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statistika_e104prac SELECT".
" 1,str,zak,zak,ucm,ucd,hod,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0".
" FROM F$kli_vxcf"."_uctmaj".
" WHERE ume >= $vyb_ump AND ume <= $vyb_umk AND zak > 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statistika_e104prac SELECT".
" 1,str,zak,zak,ucm,ucd,hod,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0".
" FROM F$kli_vxcf"."_uctmzd".
" WHERE ume >= $vyb_ump AND ume <= $vyb_umk AND zak > 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_statistika_e104prac WHERE LEFT(ucm,1) != 5 AND LEFT(ucm,1) != 6 AND LEFT(ucd,1) != 5 AND LEFT(ucd,1) != 6 ";
$dsql = mysql_query("$dsqlt");

//vypocitaj nstr
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET nstr=LEFT(zakx,4) WHERE zakx > 99999"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET nstr=LEFT(zakx,3) WHERE zakx <= 99999"; 
$oznac = mysql_query("$sqtoz");

if( $copern == 12 )
          {
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET strx=0"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET strx=SUBSTRING(zakx,5,2) WHERE zakx > 99999"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET strx=SUBSTRING(zakx,4,2) WHERE zakx <= 99999"; 
$oznac = mysql_query("$sqtoz");
          }

//exit;

//nastav do stlpca
//naklady

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n01=hodx WHERE LEFT(ucmx,3) = 521 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n01=-hodx WHERE LEFT(ucdx,3) = 521 "; $oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n02=hodx WHERE LEFT(ucmx,3) = 524 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n02=-hodx WHERE LEFT(ucdx,3) = 524 "; $oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n03=hodx WHERE ( LEFT(ucmx,3) = 504 OR LEFT(ucmx,6) = 501311 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n03=-hodx WHERE ( LEFT(ucdx,3) = 504 OR LEFT(ucdx,6) = 501311 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n04=hodx WHERE ( LEFT(ucmx,6) = 501510 OR LEFT(ucmx,6) = 501520 OR LEFT(ucmx,6) = 501550".
" OR LEFT(ucmx,6) = 501560 OR LEFT(ucmx,6) = 501570 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n04=-hodx WHERE ( LEFT(ucdx,6) = 501510 OR LEFT(ucdx,6) = 501520 OR LEFT(ucdx,6) = 501550".
" OR LEFT(ucdx,6) = 501560 OR LEFT(ucdx,6) = 501570 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n07=hodx WHERE ( LEFT(ucmx,6) = 551110 OR LEFT(ucmx,6) = 551210 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n07=-hodx WHERE ( LEFT(ucdx,6) = 551110 OR LEFT(ucdx,6) = 551210 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n08=hodx WHERE ( LEFT(ucmx,6) = 551120 OR LEFT(ucmx,6) = 551220 OR LEFT(ucmx,6) = 551300 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n08=-hodx WHERE ( LEFT(ucdx,6) = 551120 OR LEFT(ucdx,6) = 551220 OR LEFT(ucdx,6) = 551300 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n10=hodx WHERE ( LEFT(ucmx,3) = 502 OR LEFT(ucmx,6) = 501100 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n10=-hodx WHERE ( LEFT(ucdx,3) = 502 OR LEFT(ucdx,6) = 501100 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n11=hodx WHERE ( LEFT(ucmx,6) = 511300 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n11=-hodx WHERE ( LEFT(ucdx,6) = 511300 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n12=hodx WHERE ( LEFT(ucmx,6) = 511100 OR LEFT(ucmx,6) = 511400 OR LEFT(ucmx,6) = 511200 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n12=-hodx WHERE ( LEFT(ucdx,6) = 511100 OR LEFT(ucdx,6) = 511400 OR LEFT(ucdx,6) = 511200 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n14=hodx WHERE ( LEFT(ucmx,6) = 501221 OR LEFT(ucmx,6) = 501241 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n14=-hodx WHERE ( LEFT(ucdx,6) = 501221 OR LEFT(ucdx,6) = 501241  )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n15=hodx WHERE ( LEFT(ucmx,6) = 501212 OR LEFT(ucmx,6) = 501222 OR LEFT(ucmx,6) = 501232 OR LEFT(ucmx,6) = 501241 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n15=-hodx WHERE ( LEFT(ucdx,6) = 501212 OR LEFT(ucdx,6) = 501222 OR LEFT(ucdx,6) = 501232 OR LEFT(ucdx,6) = 501241 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n16=hodx WHERE ( LEFT(ucmx,1) = 5 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4101n16=-hodx WHERE ( LEFT(ucdx,1) = 5 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET ".
" mod4101n16=mod4101n16-mod4101n15-mod4101n14-mod4101n13-mod4101n12-mod4101n11-mod4101n10-mod4101n09-mod4101n08-mod4101n07, ".
" mod4101n16=mod4101n16-mod4101n06-mod4101n05-mod4101n04-mod4101n03-mod4101n02-mod4101n01 ".
" WHERE icox >= 0"; 
$oznac = mysql_query("$sqtoz");

//vynosy

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4102n04=-hodx WHERE ( LEFT(ucmx,6) = 602101 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4102n04=hodx WHERE ( LEFT(ucdx,6) = 602101 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4102n06=-hodx WHERE ( LEFT(ucmx,6) = 602103 OR LEFT(ucmx,6) = 602113 OR LEFT(ucmx,6) = 602203".
" OR LEFT(ucmx,6) = 602303 OR LEFT(ucmx,6) = 602403 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4102n06=hodx WHERE ( LEFT(ucdx,6) = 602103 OR LEFT(ucdx,6) = 602113 OR LEFT(ucdx,6) = 602203".
" OR LEFT(ucdx,6) = 602303 OR LEFT(ucdx,6) = 602403 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4102n07=-hodx WHERE ( LEFT(ucmx,6) = 602104 OR LEFT(ucmx,6) = 602114 OR LEFT(ucmx,6) = 602204".
" OR LEFT(ucmx,6) = 602304 OR LEFT(ucmx,6) = 602404 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4102n07=hodx WHERE ( LEFT(ucdx,6) = 602104 OR LEFT(ucdx,6) = 602114 OR LEFT(ucdx,6) = 602204".
" OR LEFT(ucdx,6) = 602304 OR LEFT(ucdx,6) = 602404 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4102n08=-hodx WHERE ( LEFT(ucmx,6) = 602105 OR LEFT(ucmx,6) = 602115 OR LEFT(ucmx,6) = 602205".
" OR LEFT(ucmx,6) = 602305 OR LEFT(ucmx,6) = 602405 OR LEFT(ucmx,6) = 602106 OR LEFT(ucmx,6) = 602107 OR LEFT(ucmx,6) = 6024116 OR LEFT(ucmx,6) = 602117".
" OR LEFT(ucmx,6) = 602206 OR LEFT(ucmx,6) = 602207 OR LEFT(ucmx,6) = 602306 OR LEFT(ucmx,6) = 602307 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4102n08=hodx WHERE ( LEFT(ucdx,6) = 602105 OR LEFT(ucdx,6) = 602115 OR LEFT(ucdx,6) = 602205".
" OR LEFT(ucdx,6) = 602305 OR LEFT(ucdx,6) = 602405 OR LEFT(ucdx,6) = 602106 OR LEFT(ucdx,6) = 602107 OR LEFT(ucdx,6) = 6024116 OR LEFT(ucdx,6) = 602117".
" OR LEFT(ucdx,6) = 602206 OR LEFT(ucdx,6) = 602207 OR LEFT(ucdx,6) = 602306 OR LEFT(ucdx,6) = 602307 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4102n12=-hodx WHERE ( LEFT(ucmx,6) = 602097 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4102n12=hodx WHERE ( LEFT(ucdx,6) = 602097 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4102n13=-hodx WHERE ( LEFT(ucmx,6) = 691100 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4102n13=hodx WHERE ( LEFT(ucdx,6) = 691100 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4102n14=-hodx WHERE ( LEFT(ucmx,1) = 6 )"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET mod4102n14=hodx WHERE ( LEFT(ucdx,1) = 6 )"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET ".
" mod4102n14=mod4102n14-mod4102n13-mod4102n12-mod4102n11-mod4102n10-mod4102n09-mod4102n08-mod4102n07, ".
" mod4102n14=mod4102n14-mod4102n06-mod4102n05-mod4102n04-mod4102n03-mod4102n02-mod4102n01 ".
" WHERE icox >= 0"; 
$oznac = mysql_query("$sqtoz");

//exit;

if( $copern == 11 )
          {
$dsqlt = "INSERT INTO F$kli_vxcf"."_statistika_e104prac SELECT".
" 2,strx,zakx,nstr,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"SUM(mod4101n01),SUM(mod4101n02),SUM(mod4101n03),SUM(mod4101n04),SUM(mod4101n05),SUM(mod4101n06),SUM(mod4101n07),SUM(mod4101n08),".
"SUM(mod4101n09),SUM(mod4101n10),SUM(mod4101n11),SUM(mod4101n12),SUM(mod4101n13),SUM(mod4101n14),SUM(mod4101n15),SUM(mod4101n16),".
"SUM(mod4102n01),SUM(mod4102n02),SUM(mod4102n03),SUM(mod4102n04),SUM(mod4102n05),SUM(mod4102n06),SUM(mod4102n07),SUM(mod4102n08),".
"SUM(mod4102n09),SUM(mod4102n10),SUM(mod4102n11),SUM(mod4102n12),SUM(mod4102n13),SUM(mod4102n14),".
"icox".
" FROM F$kli_vxcf"."_statistika_e104prac".
" WHERE nstr >= 0 ".
" GROUP BY nstr".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
          }

if( $copern == 12 )
          {
$dsqlt = "INSERT INTO F$kli_vxcf"."_statistika_e104prac SELECT".
" 2,strx,zakx,nstr,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"SUM(mod4101n01),SUM(mod4101n02),SUM(mod4101n03),SUM(mod4101n04),SUM(mod4101n05),SUM(mod4101n06),SUM(mod4101n07),SUM(mod4101n08),".
"SUM(mod4101n09),SUM(mod4101n10),SUM(mod4101n11),SUM(mod4101n12),SUM(mod4101n13),SUM(mod4101n14),SUM(mod4101n15),SUM(mod4101n16),".
"SUM(mod4102n01),SUM(mod4102n02),SUM(mod4102n03),SUM(mod4102n04),SUM(mod4102n05),SUM(mod4102n06),SUM(mod4102n07),SUM(mod4102n08),".
"SUM(mod4102n09),SUM(mod4102n10),SUM(mod4102n11),SUM(mod4102n12),SUM(mod4102n13),SUM(mod4102n14),".
"icox".
" FROM F$kli_vxcf"."_statistika_e104prac".
" WHERE nstr >= 0 ".
" GROUP BY nstr,strx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
          }

$dsqlt = "INSERT INTO F$kli_vxcf"."_statistika_e104prac SELECT".
" 2,strx,zakx,99999999,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"SUM(mod4101n01),SUM(mod4101n02),SUM(mod4101n03),SUM(mod4101n04),SUM(mod4101n05),SUM(mod4101n06),SUM(mod4101n07),SUM(mod4101n08),".
"SUM(mod4101n09),SUM(mod4101n10),SUM(mod4101n11),SUM(mod4101n12),SUM(mod4101n13),SUM(mod4101n14),SUM(mod4101n15),SUM(mod4101n16),".
"SUM(mod4102n01),SUM(mod4102n02),SUM(mod4102n03),SUM(mod4102n04),SUM(mod4102n05),SUM(mod4102n06),SUM(mod4102n07),SUM(mod4102n08),".
"SUM(mod4102n09),SUM(mod4102n10),SUM(mod4102n11),SUM(mod4102n12),SUM(mod4102n13),SUM(mod4102n14),".
"icox".
" FROM F$kli_vxcf"."_statistika_e104prac".
" WHERE prx = 2 ".
" GROUP BY icox".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_e104prac SET ".
" mod4101s01=mod4101n01, mod4101s02=mod4101n02, mod4101s03=mod4101n03, mod4101s04=mod4101n04, mod4101s05=mod4101n05, mod4101s06=mod4101n06, ".
" mod4101s07=mod4101n07, mod4101s08=mod4101n08, mod4101s09=mod4101n09, mod4101s10=mod4101n10, ".
" mod4101s11=mod4101n11, mod4101s12=mod4101n12, mod4101s13=mod4101n13, mod4101s14=mod4101n14, mod4101s15=mod4101n15, mod4101s16=mod4101n16, ".
" mod4102s01=mod4102n01, mod4102s02=mod4102n02, mod4102s03=mod4102n03, mod4102s04=mod4102n04, mod4102s05=mod4102n05, mod4102s06=mod4102n06, ".
" mod4102s07=mod4102n07, mod4102s08=mod4102n08, mod4102s09=mod4102n09, mod4102s10=mod4102n10, ".
" mod4102s11=mod4102n11, mod4102s12=mod4102n12, mod4102s13=mod4102n13, mod4102s14=mod4102n14 ".
" WHERE prx = 2 ";
$oznac = mysql_query("$sqtoz");

          }
//koniec pracovny subor copern=11,12

//tlac strana 1
if( $copern == 11 )
          {

$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_e104prac WHERE prx = 2 ORDER BY nstr ".""; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$mod4101s01=$hlavicka->mod4101s01; if( $mod4101s01 == 0 ) { $mod4101s01=""; }
$mod4101s02=$hlavicka->mod4101s02; if( $mod4101s02 == 0 ) { $mod4101s02=""; }
$mod4101s03=$hlavicka->mod4101s03; if( $mod4101s03 == 0 ) { $mod4101s03=""; }
$mod4101s04=$hlavicka->mod4101s04; if( $mod4101s04 == 0 ) { $mod4101s04=""; }
$mod4101s05=$hlavicka->mod4101s05; if( $mod4101s05 == 0 ) { $mod4101s05=""; }
$mod4101s06=$hlavicka->mod4101s06; if( $mod4101s06 == 0 ) { $mod4101s06=""; }
$mod4101s07=$hlavicka->mod4101s07; if( $mod4101s07 == 0 ) { $mod4101s07=""; }
$mod4101s08=$hlavicka->mod4101s08; if( $mod4101s08 == 0 ) { $mod4101s08=""; }
$mod4101s09=$hlavicka->mod4101s09; if( $mod4101s09 == 0 ) { $mod4101s09=""; }
$mod4101s10=$hlavicka->mod4101s10; if( $mod4101s10 == 0 ) { $mod4101s10=""; }
$mod4101s11=$hlavicka->mod4101s11; if( $mod4101s11 == 0 ) { $mod4101s11=""; }
$mod4101s12=$hlavicka->mod4101s12; if( $mod4101s12 == 0 ) { $mod4101s12=""; }
$mod4101s13=$hlavicka->mod4101s13; if( $mod4101s13 == 0 ) { $mod4101s13=""; }
$mod4101s14=$hlavicka->mod4101s14; if( $mod4101s14 == 0 ) { $mod4101s14=""; }
$mod4101s15=$hlavicka->mod4101s15; if( $mod4101s15 == 0 ) { $mod4101s15=""; }
$mod4101s16=$hlavicka->mod4101s16; if( $mod4101s16 == 0 ) { $mod4101s16=""; }
$nstr=1*$hlavicka->nstr; if( $nstr == 0 ) { $nstr=""; }

//hlavicka
if( $i == 0 )
     {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

$pdf->SetY(10);
$pdf->SetFont('arial','',12);
$pdf->Cell(190,6,"E(MZSR) 1-04 V˝kaz o ekonomike organiz·ciÌ v zdravotnÌctve za rok $kli_vrok","0",1,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(40,5,"$stvrtrok.ötrvrùrok ","1",1,"L");
$pdf->Cell(40,5,"  ","0",1,"L");

$pdf->Cell(190,6,"4101. modul N·klady v EUR","0",1,"L");
$pdf->SetFont('arial','',7);
$pdf->Cell(15,5,"STR","1",0,"C");$pdf->Cell(5,5,"l.r.","1",0,"C");$pdf->Cell(15,5,"Mzdy","1",0,"C");
$pdf->Cell(15,5,"Odvody","1",0,"C");$pdf->Cell(15,5,"Lieky","1",0,"C");$pdf->Cell(15,5,"Zdr.pom.","1",0,"C");
$pdf->Cell(15,5,"Dopl.lek·rne","1",0,"C");$pdf->Cell(15,5,"Krv","1",0,"C");$pdf->Cell(15,5,"Odpisy ZT","1",0,"C");
$pdf->Cell(15,5,"Odpisy ost.","1",0,"C");$pdf->Cell(15,5,"Strava pac.","1",0,"C");$pdf->Cell(15,5,"Energie","1",0,"C");
$pdf->Cell(15,5,"Opravy ZT","1",0,"C");$pdf->Cell(15,5,"Opravy ost.","1",0,"C");$pdf->Cell(15,5,"Ostatn· spr.","1",0,"C");
$pdf->Cell(15,5,"Zdr.doprava","1",0,"C");$pdf->Cell(15,5,"Hosp.dopr.","1",0,"C");
$pdf->Cell(15,5,"OstatnÈ","1",1,"C");

$pdf->Cell(15,5,"  ","1",0,"C");$pdf->Cell(5,5,"a","1",0,"C");$pdf->Cell(15,5,"1","1",0,"C");
$pdf->Cell(15,5,"2","1",0,"C");$pdf->Cell(15,5,"3","1",0,"C");$pdf->Cell(15,5,"4","1",0,"C");
$pdf->Cell(15,5,"5","1",0,"C");$pdf->Cell(15,5,"6","1",0,"C");$pdf->Cell(15,5,"7","1",0,"C");
$pdf->Cell(15,5,"8","1",0,"C");$pdf->Cell(15,5,"9","1",0,"C");$pdf->Cell(15,5,"10","1",0,"C");
$pdf->Cell(15,5,"11","1",0,"C");$pdf->Cell(15,5,"12","1",0,"C");$pdf->Cell(15,5,"13","1",0,"C");
$pdf->Cell(15,5,"14","1",0,"C");$pdf->Cell(15,5,"15","1",0,"C");
$pdf->Cell(15,5,"16","1",1,"C");

     }

$pol=$i+1;

if( $nstr != 99999999 ) $pdf->Cell(15,5,"$nstr","1",0,"R");
if( $nstr == 99999999 ) $pdf->Cell(15,5,"Spolu","1",0,"R");

$pdf->Cell(5,5,"$pol","1",0,"C");$pdf->Cell(15,5,"$mod4101s01","1",0,"R");
$pdf->Cell(15,5,"$mod4101s02","1",0,"R");$pdf->Cell(15,5,"$mod4101s03","1",0,"R");$pdf->Cell(15,5,"$mod4101s04","1",0,"R");
$pdf->Cell(15,5,"$mod4101s05","1",0,"R");$pdf->Cell(15,5,"$mod4101s06","1",0,"R");$pdf->Cell(15,5,"$mod4101s07","1",0,"R");
$pdf->Cell(15,5,"$mod4101s08","1",0,"R");$pdf->Cell(15,5,"$mod4101s09","1",0,"R");$pdf->Cell(15,5,"$mod4101s10","1",0,"R");
$pdf->Cell(15,5,"$mod4101s11","1",0,"R");$pdf->Cell(15,5,"$mod4101s12","1",0,"R");$pdf->Cell(15,5,"$mod4101s13","1",0,"R");
$pdf->Cell(15,5,"$mod4101s14","1",0,"R");$pdf->Cell(15,5,"$mod4101s15","1",0,"R");
$pdf->Cell(15,5,"$mod4101s16","1",1,"R");

if( $nstr == 99999999 ) {

$celknaklady=$hlavicka->mod4101s01+$hlavicka->mod4101s02+$hlavicka->mod4101s03+$hlavicka->mod4101s04+$hlavicka->mod4101s05+$hlavicka->mod4101s06;
$celknaklady=$celknaklady+$hlavicka->mod4101s07+$hlavicka->mod4101s08+$hlavicka->mod4101s09+$hlavicka->mod4101s10+$hlavicka->mod4101s11;
$celknaklady=$celknaklady+$hlavicka->mod4101s12+$hlavicka->mod4101s13+$hlavicka->mod4101s14+$hlavicka->mod4101s15+$hlavicka->mod4101s16;

$pdf->Cell(35,5,"Celkom n·klady","1",0,"R");$pdf->Cell(15,5,"$celknaklady","1",1,"R");

                        }

}
$i = $i + 1;

  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_e104prac WHERE prx = 2 ORDER BY nstr ".""; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$mod4102s01=$hlavicka->mod4102s01; if( $mod4102s01 == 0 ) { $mod4102s01=""; }
$mod4102s02=$hlavicka->mod4102s02; if( $mod4102s02 == 0 ) { $mod4102s02=""; }
$mod4102s03=$hlavicka->mod4102s03; if( $mod4102s03 == 0 ) { $mod4102s03=""; }
$mod4102s04=$hlavicka->mod4102s04; if( $mod4102s04 == 0 ) { $mod4102s04=""; }
$mod4102s05=$hlavicka->mod4102s05; if( $mod4102s05 == 0 ) { $mod4102s05=""; }
$mod4102s06=$hlavicka->mod4102s06; if( $mod4102s06 == 0 ) { $mod4102s06=""; }
$mod4102s07=$hlavicka->mod4102s07; if( $mod4102s07 == 0 ) { $mod4102s07=""; }
$mod4102s08=$hlavicka->mod4102s08; if( $mod4102s08 == 0 ) { $mod4102s08=""; }
$mod4102s09=$hlavicka->mod4102s09; if( $mod4102s09 == 0 ) { $mod4102s09=""; }
$mod4102s10=$hlavicka->mod4102s10; if( $mod4102s10 == 0 ) { $mod4102s10=""; }
$mod4102s11=$hlavicka->mod4102s11; if( $mod4102s11 == 0 ) { $mod4102s11=""; }
$mod4102s12=$hlavicka->mod4102s12; if( $mod4102s12 == 0 ) { $mod4102s12=""; }
$mod4102s13=$hlavicka->mod4102s13; if( $mod4102s13 == 0 ) { $mod4102s13=""; }
$mod4102s14=$hlavicka->mod4102s14; if( $mod4102s14 == 0 ) { $mod4102s14=""; }

$nstr=1*$hlavicka->nstr; if( $nstr == 0 ) { $nstr=""; }

//hlavicka
if( $i == 0 )
     {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

$pdf->SetY(10);
$pdf->SetFont('arial','',12);
$pdf->Cell(190,6,"E(MZSR) 1-04 V˝kaz o ekonomike organiz·ciÌ v zdravotnÌctve za rok $kli_vrok","0",1,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(40,5,"$stvrtrok.ötrvrùrok ","1",1,"L");
$pdf->Cell(40,5,"  ","0",1,"L");

$pdf->Cell(190,6,"4102. modul V˝nosy v EUR","0",1,"L");
$pdf->SetFont('arial','',7);
$pdf->Cell(15,5,"STR","1",0,"C");$pdf->Cell(5,5,"l.r.","1",0,"C");$pdf->Cell(15,5,"ukon.hosp.","1",0,"C");
$pdf->Cell(15,5,"oö.dni","1",0,"C");$pdf->Cell(15,5,"prip.pol.","1",0,"C");$pdf->Cell(15,5,"deÚ v stac.","1",0,"C");
$pdf->Cell(15,5,"jednodÚ.star.","1",0,"C");$pdf->Cell(15,5,"body","1",0,"C");$pdf->Cell(15,5,"kapit·cia","1",0,"C");
$pdf->Cell(15,5,"inÈ","1",0,"C");$pdf->Cell(15,5,"lieky","1",0,"C");$pdf->Cell(15,5,"zdr.pom.","1",0,"C");
$pdf->Cell(15,5,"dopl.lek.","1",0,"C");$pdf->Cell(15,5,"inÈ","1",0,"C");$pdf->Cell(15,5,"dot·cie","1",0,"C");
$pdf->Cell(15,5,"OstatnÈ","1",1,"C");

$pdf->Cell(15,5,"  ","1",0,"C");$pdf->Cell(5,5,"a","1",0,"C");$pdf->Cell(15,5,"1","1",0,"C");
$pdf->Cell(15,5,"2","1",0,"C");$pdf->Cell(15,5,"3","1",0,"C");$pdf->Cell(15,5,"4","1",0,"C");
$pdf->Cell(15,5,"5","1",0,"C");$pdf->Cell(15,5,"6","1",0,"C");$pdf->Cell(15,5,"7","1",0,"C");
$pdf->Cell(15,5,"8","1",0,"C");$pdf->Cell(15,5,"9","1",0,"C");$pdf->Cell(15,5,"10","1",0,"C");
$pdf->Cell(15,5,"11","1",0,"C");$pdf->Cell(15,5,"12","1",0,"C");$pdf->Cell(15,5,"13","1",0,"C");
$pdf->Cell(15,5,"14","1",1,"C");

     }

$pol=$i+1;

if( $nstr != 99999999 ) $pdf->Cell(15,5,"$nstr","1",0,"R");
if( $nstr == 99999999 ) $pdf->Cell(15,5,"Spolu","1",0,"R");

$pdf->Cell(5,5,"$pol","1",0,"C");$pdf->Cell(15,5,"$mod4102s01","1",0,"R");
$pdf->Cell(15,5,"$mod4102s02","1",0,"R");$pdf->Cell(15,5,"$mod4102s03","1",0,"R");$pdf->Cell(15,5,"$mod4102s04","1",0,"R");
$pdf->Cell(15,5,"$mod4102s05","1",0,"R");$pdf->Cell(15,5,"$mod4102s06","1",0,"R");$pdf->Cell(15,5,"$mod4102s07","1",0,"R");
$pdf->Cell(15,5,"$mod4102s08","1",0,"R");$pdf->Cell(15,5,"$mod4102s09","1",0,"R");$pdf->Cell(15,5,"$mod4102s10","1",0,"R");
$pdf->Cell(15,5,"$mod4102s11","1",0,"R");$pdf->Cell(15,5,"$mod4102s12","1",0,"R");$pdf->Cell(15,5,"$mod4102s13","1",0,"R");
$pdf->Cell(15,5,"$mod4102s14","1",1,"R");


if( $nstr == 99999999 ) {

$celkvynosy=$hlavicka->mod4102s01+$hlavicka->mod4102s02+$hlavicka->mod4102s03+$hlavicka->mod4102s04+$hlavicka->mod4102s05+$hlavicka->mod4102s06;
$celkvynosy=$celkvynosy+$hlavicka->mod4102s07+$hlavicka->mod4102s08+$hlavicka->mod4102s09+$hlavicka->mod4102s10+$hlavicka->mod4102s11;
$celkvynosy=$celkvynosy+$hlavicka->mod4102s12+$hlavicka->mod4102s13+$hlavicka->mod4102s14;

$pdf->Cell(35,5,"Celkom v˝nosy","1",0,"R");$pdf->Cell(15,5,"$celkvynosy","1",1,"R");

                        }

}
$i = $i + 1;

  }

//tlac strana 2
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_e104 WHERE stvrtrok = $stvrtrok ".""; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$mod4103r01str=$hlavicka->mod4103r01str; if( $mod4103r01str == 0 ) { $mod4103r01str=""; }
$mod4103r01s1=$hlavicka->mod4103r01s1; if( $mod4103r01s1 == 0 ) { $mod4103r01s1=""; }
$mod4103r01s2=$hlavicka->mod4103r01s2; if( $mod4103r01s2 == 0 ) { $mod4103r01s2=""; }
$mod4103r01s3=$hlavicka->mod4103r01s3; if( $mod4103r01s3 == 0 ) { $mod4103r01s3=""; }
$mod4103r01s4=$hlavicka->mod4103r01s4; if( $mod4103r01s4 == 0 ) { $mod4103r01s4=""; }
$mod4103r01s5=$hlavicka->mod4103r01s5; if( $mod4103r01s5 == 0 ) { $mod4103r01s5=""; }
$mod4103r01s6=$hlavicka->mod4103r01s6; if( $mod4103r01s6 == 0 ) { $mod4103r01s6=""; }
$mod4103r01s7=$hlavicka->mod4103r01s7; if( $mod4103r01s7 == 0 ) { $mod4103r01s7=""; }

$mod4103r02str=$hlavicka->mod4103r02str; if( $mod4103r02str == 0 ) { $mod4103r02str=""; }
$mod4103r02s1=$hlavicka->mod4103r02s1; if( $mod4103r02s1 == 0 ) { $mod4103r02s1=""; }
$mod4103r02s2=$hlavicka->mod4103r02s2; if( $mod4103r02s2 == 0 ) { $mod4103r02s2=""; }
$mod4103r02s3=$hlavicka->mod4103r02s3; if( $mod4103r02s3 == 0 ) { $mod4103r02s3=""; }
$mod4103r02s4=$hlavicka->mod4103r02s4; if( $mod4103r02s4 == 0 ) { $mod4103r02s4=""; }
$mod4103r02s5=$hlavicka->mod4103r02s5; if( $mod4103r02s5 == 0 ) { $mod4103r02s5=""; }
$mod4103r02s6=$hlavicka->mod4103r02s6; if( $mod4103r02s6 == 0 ) { $mod4103r02s6=""; }
$mod4103r02s7=$hlavicka->mod4103r02s7; if( $mod4103r02s7 == 0 ) { $mod4103r02s7=""; }
$mod4103r03str=$hlavicka->mod4103r03str; if( $mod4103r03str == 0 ) { $mod4103r03str=""; }
$mod4103r03s1=$hlavicka->mod4103r03s1; if( $mod4103r03s1 == 0 ) { $mod4103r03s1=""; }
$mod4103r03s2=$hlavicka->mod4103r03s2; if( $mod4103r03s2 == 0 ) { $mod4103r03s2=""; }
$mod4103r03s3=$hlavicka->mod4103r03s3; if( $mod4103r03s3 == 0 ) { $mod4103r03s3=""; }
$mod4103r03s4=$hlavicka->mod4103r03s4; if( $mod4103r03s4 == 0 ) { $mod4103r03s4=""; }
$mod4103r03s5=$hlavicka->mod4103r03s5; if( $mod4103r03s5 == 0 ) { $mod4103r03s5=""; }
$mod4103r03s6=$hlavicka->mod4103r03s6; if( $mod4103r03s6 == 0 ) { $mod4103r03s6=""; }
$mod4103r03s7=$hlavicka->mod4103r03s7; if( $mod4103r03s7 == 0 ) { $mod4103r03s7=""; }
$mod4103r04str=$hlavicka->mod4103r04str; if( $mod4103r04str == 0 ) { $mod4103r04str=""; }
$mod4103r04s1=$hlavicka->mod4103r04s1; if( $mod4103r04s1 == 0 ) { $mod4103r04s1=""; }
$mod4103r04s2=$hlavicka->mod4103r04s2; if( $mod4103r04s2 == 0 ) { $mod4103r04s2=""; }
$mod4103r04s3=$hlavicka->mod4103r04s3; if( $mod4103r04s3 == 0 ) { $mod4103r04s3=""; }
$mod4103r04s4=$hlavicka->mod4103r04s4; if( $mod4103r04s4 == 0 ) { $mod4103r04s4=""; }
$mod4103r04s5=$hlavicka->mod4103r04s5; if( $mod4103r04s5 == 0 ) { $mod4103r04s5=""; }
$mod4103r04s6=$hlavicka->mod4103r04s6; if( $mod4103r04s6 == 0 ) { $mod4103r04s6=""; }
$mod4103r04s7=$hlavicka->mod4103r04s7; if( $mod4103r04s7 == 0 ) { $mod4103r04s7=""; }
$mod4103r05str=$hlavicka->mod4103r05str; if( $mod4103r05str == 0 ) { $mod4103r05str=""; }
$mod4103r05s1=$hlavicka->mod4103r05s1; if( $mod4103r05s1 == 0 ) { $mod4103r05s1=""; }
$mod4103r05s2=$hlavicka->mod4103r05s2; if( $mod4103r05s2 == 0 ) { $mod4103r05s2=""; }
$mod4103r05s3=$hlavicka->mod4103r05s3; if( $mod4103r05s3 == 0 ) { $mod4103r05s3=""; }
$mod4103r05s4=$hlavicka->mod4103r05s4; if( $mod4103r05s4 == 0 ) { $mod4103r05s4=""; }
$mod4103r05s5=$hlavicka->mod4103r05s5; if( $mod4103r05s5 == 0 ) { $mod4103r05s5=""; }
$mod4103r05s6=$hlavicka->mod4103r05s6; if( $mod4103r05s6 == 0 ) { $mod4103r05s6=""; }
$mod4103r05s7=$hlavicka->mod4103r05s7; if( $mod4103r05s7 == 0 ) { $mod4103r05s7=""; }
$mod4103r06str=$hlavicka->mod4103r06str; if( $mod4103r06str == 0 ) { $mod4103r06str=""; }
$mod4103r06s1=$hlavicka->mod4103r06s1; if( $mod4103r06s1 == 0 ) { $mod4103r06s1=""; }
$mod4103r06s2=$hlavicka->mod4103r06s2; if( $mod4103r06s2 == 0 ) { $mod4103r06s2=""; }
$mod4103r06s3=$hlavicka->mod4103r06s3; if( $mod4103r06s3 == 0 ) { $mod4103r06s3=""; }
$mod4103r06s4=$hlavicka->mod4103r06s4; if( $mod4103r06s4 == 0 ) { $mod4103r06s4=""; }
$mod4103r06s5=$hlavicka->mod4103r06s5; if( $mod4103r06s5 == 0 ) { $mod4103r06s5=""; }
$mod4103r06s6=$hlavicka->mod4103r06s6; if( $mod4103r06s6 == 0 ) { $mod4103r06s6=""; }
$mod4103r06s7=$hlavicka->mod4103r06s7; if( $mod4103r06s7 == 0 ) { $mod4103r06s7=""; }
$mod4103r07str=$hlavicka->mod4103r07str; if( $mod4103r07str == 0 ) { $mod4103r07str=""; }
$mod4103r07s1=$hlavicka->mod4103r07s1; if( $mod4103r07s1 == 0 ) { $mod4103r07s1=""; }
$mod4103r07s2=$hlavicka->mod4103r07s2; if( $mod4103r07s2 == 0 ) { $mod4103r07s2=""; }
$mod4103r07s3=$hlavicka->mod4103r07s3; if( $mod4103r07s3 == 0 ) { $mod4103r07s3=""; }
$mod4103r07s4=$hlavicka->mod4103r07s4; if( $mod4103r07s4 == 0 ) { $mod4103r07s4=""; }
$mod4103r07s5=$hlavicka->mod4103r07s5; if( $mod4103r07s5 == 0 ) { $mod4103r07s5=""; }
$mod4103r07s6=$hlavicka->mod4103r07s6; if( $mod4103r07s6 == 0 ) { $mod4103r07s6=""; }
$mod4103r07s7=$hlavicka->mod4103r07s7; if( $mod4103r07s7 == 0 ) { $mod4103r07s7=""; }
$mod4103r08str=$hlavicka->mod4103r08str; if( $mod4103r08str == 0 ) { $mod4103r08str=""; }
$mod4103r08s1=$hlavicka->mod4103r08s1; if( $mod4103r08s1 == 0 ) { $mod4103r08s1=""; }
$mod4103r08s2=$hlavicka->mod4103r08s2; if( $mod4103r08s2 == 0 ) { $mod4103r08s2=""; }
$mod4103r08s3=$hlavicka->mod4103r08s3; if( $mod4103r08s3 == 0 ) { $mod4103r08s3=""; }
$mod4103r08s4=$hlavicka->mod4103r08s4; if( $mod4103r08s4 == 0 ) { $mod4103r08s4=""; }
$mod4103r08s5=$hlavicka->mod4103r08s5; if( $mod4103r08s5 == 0 ) { $mod4103r08s5=""; }
$mod4103r08s6=$hlavicka->mod4103r08s6; if( $mod4103r08s6 == 0 ) { $mod4103r08s6=""; }
$mod4103r08s7=$hlavicka->mod4103r08s7; if( $mod4103r08s7 == 0 ) { $mod4103r08s7=""; }
$mod4103r09str=$hlavicka->mod4103r09str; if( $mod4103r09str == 0 ) { $mod4103r09str=""; }
$mod4103r09s1=$hlavicka->mod4103r09s1; if( $mod4103r09s1 == 0 ) { $mod4103r09s1=""; }
$mod4103r09s2=$hlavicka->mod4103r09s2; if( $mod4103r09s2 == 0 ) { $mod4103r09s2=""; }
$mod4103r09s3=$hlavicka->mod4103r09s3; if( $mod4103r09s3 == 0 ) { $mod4103r09s3=""; }
$mod4103r09s4=$hlavicka->mod4103r09s4; if( $mod4103r09s4 == 0 ) { $mod4103r09s4=""; }
$mod4103r09s5=$hlavicka->mod4103r09s5; if( $mod4103r09s5 == 0 ) { $mod4103r09s5=""; }
$mod4103r09s6=$hlavicka->mod4103r09s6; if( $mod4103r09s6 == 0 ) { $mod4103r09s6=""; }
$mod4103r09s7=$hlavicka->mod4103r09s7; if( $mod4103r09s7 == 0 ) { $mod4103r09s7=""; }
$mod4103r10str=$hlavicka->mod4103r10str; if( $mod4103r10str == 0 ) { $mod4103r10str=""; }
$mod4103r10s1=$hlavicka->mod4103r10s1; if( $mod4103r10s1 == 0 ) { $mod4103r10s1=""; }
$mod4103r10s2=$hlavicka->mod4103r10s2; if( $mod4103r10s2 == 0 ) { $mod4103r10s2=""; }
$mod4103r10s3=$hlavicka->mod4103r10s3; if( $mod4103r10s3 == 0 ) { $mod4103r10s3=""; }
$mod4103r10s4=$hlavicka->mod4103r10s4; if( $mod4103r10s4 == 0 ) { $mod4103r10s4=""; }
$mod4103r10s5=$hlavicka->mod4103r10s5; if( $mod4103r10s5 == 0 ) { $mod4103r10s5=""; }
$mod4103r10s6=$hlavicka->mod4103r10s6; if( $mod4103r10s6 == 0 ) { $mod4103r10s6=""; }
$mod4103r10s7=$hlavicka->mod4103r10s7; if( $mod4103r10s7 == 0 ) { $mod4103r10s7=""; }
$mod4103r11str=$hlavicka->mod4103r11str; if( $mod4103r11str == 0 ) { $mod4103r11str=""; }
$mod4103r11s1=$hlavicka->mod4103r11s1; if( $mod4103r11s1 == 0 ) { $mod4103r11s1=""; }
$mod4103r11s2=$hlavicka->mod4103r11s2; if( $mod4103r11s2 == 0 ) { $mod4103r11s2=""; }
$mod4103r11s3=$hlavicka->mod4103r11s3; if( $mod4103r11s3 == 0 ) { $mod4103r11s3=""; }
$mod4103r11s4=$hlavicka->mod4103r11s4; if( $mod4103r11s4 == 0 ) { $mod4103r11s4=""; }
$mod4103r11s5=$hlavicka->mod4103r11s5; if( $mod4103r11s5 == 0 ) { $mod4103r11s5=""; }
$mod4103r11s6=$hlavicka->mod4103r11s6; if( $mod4103r11s6 == 0 ) { $mod4103r11s6=""; }
$mod4103r11s7=$hlavicka->mod4103r11s7; if( $mod4103r11s7 == 0 ) { $mod4103r11s7=""; }
$mod4103r12str=$hlavicka->mod4103r12str; if( $mod4103r12str == 0 ) { $mod4103r12str=""; }
$mod4103r12s1=$hlavicka->mod4103r12s1; if( $mod4103r12s1 == 0 ) { $mod4103r12s1=""; }
$mod4103r12s2=$hlavicka->mod4103r12s2; if( $mod4103r12s2 == 0 ) { $mod4103r12s2=""; }
$mod4103r12s3=$hlavicka->mod4103r12s3; if( $mod4103r12s3 == 0 ) { $mod4103r12s3=""; }
$mod4103r12s4=$hlavicka->mod4103r12s4; if( $mod4103r12s4 == 0 ) { $mod4103r12s4=""; }
$mod4103r12s5=$hlavicka->mod4103r12s5; if( $mod4103r12s5 == 0 ) { $mod4103r12s5=""; }
$mod4103r12s6=$hlavicka->mod4103r12s6; if( $mod4103r12s6 == 0 ) { $mod4103r12s6=""; }
$mod4103r12s7=$hlavicka->mod4103r12s7; if( $mod4103r12s7 == 0 ) { $mod4103r12s7=""; }
$mod4103r13str=$hlavicka->mod4103r13str; if( $mod4103r13str == 0 ) { $mod4103r13str=""; }
$mod4103r13s1=$hlavicka->mod4103r13s1; if( $mod4103r13s1 == 0 ) { $mod4103r13s1=""; }
$mod4103r13s2=$hlavicka->mod4103r13s2; if( $mod4103r13s2 == 0 ) { $mod4103r13s2=""; }
$mod4103r13s3=$hlavicka->mod4103r13s3; if( $mod4103r13s3 == 0 ) { $mod4103r13s3=""; }
$mod4103r13s4=$hlavicka->mod4103r13s4; if( $mod4103r13s4 == 0 ) { $mod4103r13s4=""; }
$mod4103r13s5=$hlavicka->mod4103r13s5; if( $mod4103r13s5 == 0 ) { $mod4103r13s5=""; }
$mod4103r13s6=$hlavicka->mod4103r13s6; if( $mod4103r13s6 == 0 ) { $mod4103r13s6=""; }
$mod4103r13s7=$hlavicka->mod4103r13s7; if( $mod4103r13s7 == 0 ) { $mod4103r13s7=""; }
$mod4103r14str=$hlavicka->mod4103r14str; if( $mod4103r14str == 0 ) { $mod4103r14str=""; }
$mod4103r14s1=$hlavicka->mod4103r14s1; if( $mod4103r14s1 == 0 ) { $mod4103r14s1=""; }
$mod4103r14s2=$hlavicka->mod4103r14s2; if( $mod4103r14s2 == 0 ) { $mod4103r14s2=""; }
$mod4103r14s3=$hlavicka->mod4103r14s3; if( $mod4103r14s3 == 0 ) { $mod4103r14s3=""; }
$mod4103r14s4=$hlavicka->mod4103r14s4; if( $mod4103r14s4 == 0 ) { $mod4103r14s4=""; }
$mod4103r14s5=$hlavicka->mod4103r14s5; if( $mod4103r14s5 == 0 ) { $mod4103r14s5=""; }
$mod4103r14s6=$hlavicka->mod4103r14s6; if( $mod4103r14s6 == 0 ) { $mod4103r14s6=""; }
$mod4103r14s7=$hlavicka->mod4103r14s7; if( $mod4103r14s7 == 0 ) { $mod4103r14s7=""; }
$mod4103r15str=$hlavicka->mod4103r15str; if( $mod4103r15str == 0 ) { $mod4103r15str=""; }
$mod4103r15s1=$hlavicka->mod4103r15s1; if( $mod4103r15s1 == 0 ) { $mod4103r15s1=""; }
$mod4103r15s2=$hlavicka->mod4103r15s2; if( $mod4103r15s2 == 0 ) { $mod4103r15s2=""; }
$mod4103r15s3=$hlavicka->mod4103r15s3; if( $mod4103r15s3 == 0 ) { $mod4103r15s3=""; }
$mod4103r15s4=$hlavicka->mod4103r15s4; if( $mod4103r15s4 == 0 ) { $mod4103r15s4=""; }
$mod4103r15s5=$hlavicka->mod4103r15s5; if( $mod4103r15s5 == 0 ) { $mod4103r15s5=""; }
$mod4103r15s6=$hlavicka->mod4103r15s6; if( $mod4103r15s6 == 0 ) { $mod4103r15s6=""; }
$mod4103r15s7=$hlavicka->mod4103r15s7; if( $mod4103r15s7 == 0 ) { $mod4103r15s7=""; }


$mod4104r01s1=$hlavicka->mod4104r01s1; if( $mod4104r01s1 == 0 ) { $mod4104r01s1=""; }
$mod4104r02s1=$hlavicka->mod4104r02s1; if( $mod4104r02s1 == 0 ) { $mod4104r02s1=""; }
$mod4104r03s1=$hlavicka->mod4104r03s1; if( $mod4104r03s1 == 0 ) { $mod4104r03s1=""; }
$mod4104r04s1=$hlavicka->mod4104r04s1; if( $mod4104r04s1 == 0 ) { $mod4104r04s1=""; }


$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

$pdf->SetY(10);
$pdf->SetFont('arial','',12);
$pdf->Cell(190,6,"E(MZSR) 1-04 V˝kaz o ekonomike organiz·ciÌ v zdravotnÌctve za rok $kli_vrok","0",1,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(40,5,"$stvrtrok.ötrvrùrok ","1",1,"L");
$pdf->Cell(40,5,"  ","0",1,"L");

$pdf->Cell(190,6,"4103. modul VybranÈ ukazovatele","0",1,"L");
$pdf->SetFont('arial','',7);
$pdf->Cell(20,5,"N·kladovÈ STR","1",0,"C");$pdf->Cell(10,5,"l.r.","1",0,"C");$pdf->Cell(30,5,"Body","1",0,"C");
$pdf->Cell(30,5,"V˝kony","1",0,"C");$pdf->Cell(30,5,"Oöetrovacie dni","1",0,"C");$pdf->Cell(30,5,"Pacienti na dohodu","1",0,"C");
$pdf->Cell(30,5,"Posteæov· kapacita","1",0,"C");$pdf->Cell(30,5,"UkonËenÈ hospitaliz·cie","1",0,"C");$pdf->Cell(30,5,"Km v DZS","1",1,"C");
$pdf->Cell(20,5,"  ","1",0,"C");$pdf->Cell(10,5,"a","1",0,"C");$pdf->Cell(30,5,"1","1",0,"C");
$pdf->Cell(30,5,"2","1",0,"C");$pdf->Cell(30,5,"3","1",0,"C");$pdf->Cell(30,5,"4","1",0,"C");
$pdf->Cell(30,5,"5","1",0,"C");$pdf->Cell(30,5,"6","1",0,"C");$pdf->Cell(30,5,"7","1",1,"C");

$pdf->SetFont('arial','',9);
$pdf->Cell(20,5,"$mod4103r01str","1",0,"R");$pdf->Cell(10,5,"01","1",0,"C");$pdf->Cell(30,5,"$mod4103r01s1","1",0,"R");
$pdf->Cell(30,5,"$mod4103r01s2","1",0,"R");$pdf->Cell(30,5,"$mod4103r01s3","1",0,"R");$pdf->Cell(30,5,"$mod4103r01s4","1",0,"R");
$pdf->Cell(30,5,"$mod4103r01s5","1",0,"R");$pdf->Cell(30,5,"$mod4103r01s6","1",0,"R");$pdf->Cell(30,5,"$mod4103r01s7","1",1,"R");

$pdf->Cell(20,5,"$mod4103r02str","1",0,"R");$pdf->Cell(10,5,"02","1",0,"C");$pdf->Cell(30,5,"$mod4103r02s1","1",0,"R");
$pdf->Cell(30,5,"$mod4103r02s2","1",0,"R");$pdf->Cell(30,5,"$mod4103r02s3","1",0,"R");$pdf->Cell(30,5,"$mod4103r02s4","1",0,"R");
$pdf->Cell(30,5,"$mod4103r02s5","1",0,"R");$pdf->Cell(30,5,"$mod4103r02s6","1",0,"R");$pdf->Cell(30,5,"$mod4103r02s7","1",1,"R");
$pdf->Cell(20,5,"$mod4103r03str","1",0,"R");$pdf->Cell(10,5,"03","1",0,"C");$pdf->Cell(30,5,"$mod4103r03s1","1",0,"R");
$pdf->Cell(30,5,"$mod4103r03s2","1",0,"R");$pdf->Cell(30,5,"$mod4103r03s3","1",0,"R");$pdf->Cell(30,5,"$mod4103r03s4","1",0,"R");
$pdf->Cell(30,5,"$mod4103r03s5","1",0,"R");$pdf->Cell(30,5,"$mod4103r03s6","1",0,"R");$pdf->Cell(30,5,"$mod4103r03s7","1",1,"R");
$pdf->Cell(20,5,"$mod4103r04str","1",0,"R");$pdf->Cell(10,5,"04","1",0,"C");$pdf->Cell(30,5,"$mod4103r04s1","1",0,"R");
$pdf->Cell(30,5,"$mod4103r04s2","1",0,"R");$pdf->Cell(30,5,"$mod4103r04s3","1",0,"R");$pdf->Cell(30,5,"$mod4103r04s4","1",0,"R");
$pdf->Cell(30,5,"$mod4103r04s5","1",0,"R");$pdf->Cell(30,5,"$mod4103r04s6","1",0,"R");$pdf->Cell(30,5,"$mod4103r04s7","1",1,"R");
$pdf->Cell(20,5,"$mod4103r05str","1",0,"R");$pdf->Cell(10,5,"05","1",0,"C");$pdf->Cell(30,5,"$mod4103r05s1","1",0,"R");
$pdf->Cell(30,5,"$mod4103r05s2","1",0,"R");$pdf->Cell(30,5,"$mod4103r05s3","1",0,"R");$pdf->Cell(30,5,"$mod4103r05s4","1",0,"R");
$pdf->Cell(30,5,"$mod4103r05s5","1",0,"R");$pdf->Cell(30,5,"$mod4103r05s6","1",0,"R");$pdf->Cell(30,5,"$mod4103r05s7","1",1,"R");
$pdf->Cell(20,5,"$mod4103r06str","1",0,"R");$pdf->Cell(10,5,"06","1",0,"C");$pdf->Cell(30,5,"$mod4103r06s1","1",0,"R");
$pdf->Cell(30,5,"$mod4103r06s2","1",0,"R");$pdf->Cell(30,5,"$mod4103r06s3","1",0,"R");$pdf->Cell(30,5,"$mod4103r06s4","1",0,"R");
$pdf->Cell(30,5,"$mod4103r06s5","1",0,"R");$pdf->Cell(30,5,"$mod4103r06s6","1",0,"R");$pdf->Cell(30,5,"$mod4103r06s7","1",1,"R");
$pdf->Cell(20,5,"$mod4103r07str","1",0,"R");$pdf->Cell(10,5,"07","1",0,"C");$pdf->Cell(30,5,"$mod4103r07s1","1",0,"R");
$pdf->Cell(30,5,"$mod4103r07s2","1",0,"R");$pdf->Cell(30,5,"$mod4103r07s3","1",0,"R");$pdf->Cell(30,5,"$mod4103r07s4","1",0,"R");
$pdf->Cell(30,5,"$mod4103r07s5","1",0,"R");$pdf->Cell(30,5,"$mod4103r07s6","1",0,"R");$pdf->Cell(30,5,"$mod4103r07s7","1",1,"R");
$pdf->Cell(20,5,"$mod4103r08str","1",0,"R");$pdf->Cell(10,5,"08","1",0,"C");$pdf->Cell(30,5,"$mod4103r08s1","1",0,"R");
$pdf->Cell(30,5,"$mod4103r08s2","1",0,"R");$pdf->Cell(30,5,"$mod4103r08s3","1",0,"R");$pdf->Cell(30,5,"$mod4103r08s4","1",0,"R");
$pdf->Cell(30,5,"$mod4103r08s5","1",0,"R");$pdf->Cell(30,5,"$mod4103r08s6","1",0,"R");$pdf->Cell(30,5,"$mod4103r08s7","1",1,"R");
$pdf->Cell(20,5,"$mod4103r09str","1",0,"R");$pdf->Cell(10,5,"09","1",0,"C");$pdf->Cell(30,5,"$mod4103r09s1","1",0,"R");
$pdf->Cell(30,5,"$mod4103r09s2","1",0,"R");$pdf->Cell(30,5,"$mod4103r09s3","1",0,"R");$pdf->Cell(30,5,"$mod4103r09s4","1",0,"R");
$pdf->Cell(30,5,"$mod4103r09s5","1",0,"R");$pdf->Cell(30,5,"$mod4103r09s6","1",0,"R");$pdf->Cell(30,5,"$mod4103r09s7","1",1,"R");
$pdf->Cell(20,5,"$mod4103r10str","1",0,"R");$pdf->Cell(10,5,"10","1",0,"C");$pdf->Cell(30,5,"$mod4103r10s1","1",0,"R");
$pdf->Cell(30,5,"$mod4103r10s2","1",0,"R");$pdf->Cell(30,5,"$mod4103r10s3","1",0,"R");$pdf->Cell(30,5,"$mod4103r10s4","1",0,"R");
$pdf->Cell(30,5,"$mod4103r10s5","1",0,"R");$pdf->Cell(30,5,"$mod4103r10s6","1",0,"R");$pdf->Cell(30,5,"$mod4103r10s7","1",1,"R");
$pdf->Cell(20,5,"$mod4103r11str","1",0,"R");$pdf->Cell(10,5,"11","1",0,"C");$pdf->Cell(30,5,"$mod4103r11s1","1",0,"R");
$pdf->Cell(30,5,"$mod4103r11s2","1",0,"R");$pdf->Cell(30,5,"$mod4103r11s3","1",0,"R");$pdf->Cell(30,5,"$mod4103r11s4","1",0,"R");
$pdf->Cell(30,5,"$mod4103r11s5","1",0,"R");$pdf->Cell(30,5,"$mod4103r11s6","1",0,"R");$pdf->Cell(30,5,"$mod4103r11s7","1",1,"R");
$pdf->Cell(20,5,"$mod4103r12str","1",0,"R");$pdf->Cell(10,5,"12","1",0,"C");$pdf->Cell(30,5,"$mod4103r12s1","1",0,"R");
$pdf->Cell(30,5,"$mod4103r12s2","1",0,"R");$pdf->Cell(30,5,"$mod4103r12s3","1",0,"R");$pdf->Cell(30,5,"$mod4103r12s4","1",0,"R");
$pdf->Cell(30,5,"$mod4103r12s5","1",0,"R");$pdf->Cell(30,5,"$mod4103r12s6","1",0,"R");$pdf->Cell(30,5,"$mod4103r12s7","1",1,"R");
$pdf->Cell(20,5,"$mod4103r13str","1",0,"R");$pdf->Cell(10,5,"13","1",0,"C");$pdf->Cell(30,5,"$mod4103r13s1","1",0,"R");
$pdf->Cell(30,5,"$mod4103r13s2","1",0,"R");$pdf->Cell(30,5,"$mod4103r13s3","1",0,"R");$pdf->Cell(30,5,"$mod4103r13s4","1",0,"R");
$pdf->Cell(30,5,"$mod4103r13s5","1",0,"R");$pdf->Cell(30,5,"$mod4103r13s6","1",0,"R");$pdf->Cell(30,5,"$mod4103r13s7","1",1,"R");
$pdf->Cell(20,5,"$mod4103r14str","1",0,"R");$pdf->Cell(10,5,"14","1",0,"C");$pdf->Cell(30,5,"$mod4103r14s1","1",0,"R");
$pdf->Cell(30,5,"$mod4103r14s2","1",0,"R");$pdf->Cell(30,5,"$mod4103r14s3","1",0,"R");$pdf->Cell(30,5,"$mod4103r14s4","1",0,"R");
$pdf->Cell(30,5,"$mod4103r14s5","1",0,"R");$pdf->Cell(30,5,"$mod4103r14s6","1",0,"R");$pdf->Cell(30,5,"$mod4103r14s7","1",1,"R");
$pdf->Cell(20,5,"$mod4103r15str","1",0,"R");$pdf->Cell(10,5,"15","1",0,"C");$pdf->Cell(30,5,"$mod4103r15s1","1",0,"R");
$pdf->Cell(30,5,"$mod4103r15s2","1",0,"R");$pdf->Cell(30,5,"$mod4103r15s3","1",0,"R");$pdf->Cell(30,5,"$mod4103r15s4","1",0,"R");
$pdf->Cell(30,5,"$mod4103r15s5","1",0,"R");$pdf->Cell(30,5,"$mod4103r15s6","1",0,"R");$pdf->Cell(30,5,"$mod4103r15s7","1",1,"R");

$pdf->Cell(40,5,"  ","0",1,"L");

$pdf->SetFont('arial','',9);
$pdf->Cell(190,6,"4104. modul PrijatÈ dary a nesplatenÈ z·v‰zky za poskytovateæa ZS v EUR","0",1,"L");
$pdf->SetFont('arial','',7);
$pdf->Cell(20,5," ","1",0,"C");$pdf->Cell(10,5,"l.r.","1",0,"C");$pdf->Cell(30,5,"PrijatÈ dary","1",0,"C");
$pdf->Cell(30,5,"Nespl.bankov˝ ˙ver","1",0,"C");$pdf->Cell(30,5,"Nespl. in˝ ˙ver","1",0,"C");$pdf->Cell(30,5,"Nesplaten˝ lÌzing","1",1,"C");
$pdf->Cell(20,5,"  ","1",0,"C");$pdf->Cell(10,5,"a","1",0,"C");$pdf->Cell(30,5,"1","1",0,"C");
$pdf->Cell(30,5,"2","1",0,"C");$pdf->Cell(30,5,"3","1",0,"C");$pdf->Cell(30,5,"4","1",1,"C");


$pdf->Cell(20,5,"Dary a z·v‰zky","1",0,"R");
$pdf->SetFont('arial','',9);
$pdf->Cell(10,5,"01","1",0,"C");$pdf->Cell(30,5,"$mod4104r01s1","1",0,"R");
$pdf->Cell(30,5,"$mod4104r02s1","1",0,"R");$pdf->Cell(30,5,"$mod4104r03s1","1",0,"R");$pdf->Cell(30,5,"$mod4104r04s1","1",1,"R");


}
$i = $i + 1;

  }

$pdf->Output("../tmp/statistika.$kli_uzid.pdf");

?> 
<script type="text/javascript">
  var okno = window.open("../tmp/statistika.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php
          }
//koniec tlac zostava PDF copern==11


//subor XML
if( $copern == 12 )
          {

$nazsub=$fir_fico."_".$kli_vrok."_".$stvrtrok;


if (File_Exists ("../tmp/$nazsub.xml")) { $soubor = unlink("../tmp/$nazsub.xml"); }

$soubor = fopen("../tmp/$nazsub.xml", "a+");


//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_e104 WHERE stvrtrok = $stvrtrok ".""; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


  $text = "<?xml version = \"1.0\" encoding=\"UTF-8\" ?>"."\r\n";
  fwrite($soubor, $text);

  $text = "<vykazy kodRozhrania=\"E01_04\" xsi:noNamespaceSchemaLocation=\"iszi_E01_04.xsd\""."\r\n";
  fwrite($soubor, $text);

  $text = "xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\""."\r\n";
  fwrite($soubor, $text);

  $text = "xmlns:xs=\"http://www.w3.org/2001/XMLSchema\">"."\r\n";
  fwrite($soubor, $text);

  $text = "<vykaz>"."\r\n";
  fwrite($soubor, $text);


  $text = "<ROK_SPRAC>".$kli_vrok."</ROK_SPRAC>"."\r\n";
  fwrite($soubor, $text);
  $text = "<MESIAC_SPRAC>".$mesiac."</MESIAC_SPRAC>"."\r\n";
  fwrite($soubor, $text);
  $text = "<ICO>".$fir_fico."</ICO>"."\r\n";
  fwrite($soubor, $text);

//ukoncene k 31.12.2011
//  $identifpzs="P81961";

//  $text = "<IDENTIFPZS>".$identifpzs."</IDENTIFPZS>"."\r\n";
//  fwrite($soubor, $text);

$fir_fnazutf = $retezec = iconv("CP1250", "UTF-8", $fir_fnaz); 

  $text = "<NAZOV>".$fir_fnazutf."</NAZOV>"."\r\n";
  fwrite($soubor, $text);

$fir_fmesutf = $retezec = iconv("CP1250", "UTF-8", $fir_fmes); 

  $text = "<OBEC>504203</OBEC>"."\r\n";
  fwrite($soubor, $text);

$fir_fuliutf = $retezec = iconv("CP1250", "UTF-8", $fir_fuli); 

  $text = "<ULNAM>".$fir_fmesutf."</ULNAM>"."\r\n";
  fwrite($soubor, $text);
  $text = "<SOCID>".$fir_fcdm."</SOCID>"."\r\n";
  fwrite($soubor, $text);
  $text = "<PSC>".$fir_fpsc."</PSC>"."\r\n";
  fwrite($soubor, $text);

$kli_uzprieutf = iconv("CP1250", "UTF-8", $fir_mzdt05); 
$kli_telutf = iconv("CP1250", "UTF-8", $fir_mzdt04);

  $text = "<PRIEZVISKO_ZOST>".$kli_uzprieutf."</PRIEZVISKO_ZOST>"."\r\n";
  fwrite($soubor, $text);
  $text = "<TEL>".$kli_telutf."</TEL>"."\r\n";
  fwrite($soubor, $text);
  $text = "<EMAIL>".$fir_fem1."</EMAIL>"."\r\n";
  fwrite($soubor, $text);
  $text = "<POZNAMKA>Poznamka</POZNAMKA>"."\r\n";
  fwrite($soubor, $text);

  $text = "<DARY>".$hlavicka->mod4104r01s1."</DARY>"."\r\n";
  fwrite($soubor, $text);
  $text = "<ZAVAZKY_UVER_BANK>".$hlavicka->mod4104r02s1."</ZAVAZKY_UVER_BANK>"."\r\n";
  fwrite($soubor, $text);
  $text = "<ZAVAZKY_UVER_INY>".$hlavicka->mod4104r03s1."</ZAVAZKY_UVER_INY>"."\r\n";
  fwrite($soubor, $text);
  $text = "<ZAVAZKY_LIZING>".$hlavicka->mod4104r04s1."</ZAVAZKY_LIZING>"."\r\n";
  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }
//koniec hlavicky

//modul 4101

  $text = "<OM_OE_01_01>"."\r\n";
  fwrite($soubor, $text);

$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_e104prac WHERE prx = 2 AND nstr != 99999999 ORDER BY nstr,strx ".""; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//ak nenulove tlac
if( $hlavicka->mod4101s01 != 0 OR $hlavicka->mod4101s02 != 0 OR $hlavicka->mod4101s03 != 0 OR $hlavicka->mod4101s04 != 0 OR
 $hlavicka->mod4101s05 != 0 OR $hlavicka->mod4101s06 != 0 OR $hlavicka->mod4101s07 != 0 OR $hlavicka->mod4101s08 != 0 OR
 $hlavicka->mod4101s09 != 0 OR $hlavicka->mod4101s10 != 0 OR $hlavicka->mod4101s11 != 0 OR $hlavicka->mod4101s12 != 0 OR
 $hlavicka->mod4101s13 != 0 OR $hlavicka->mod4101s14 != 0 OR $hlavicka->mod4101s15 != 0 OR $hlavicka->mod4101s16 != 0 )
          {

  $text = "<OE_01_01>"."\r\n";
  fwrite($soubor, $text);

//$por_cis1=$i+1;
//if ( $por_cis1 < 10 ) $por_cis1="0".$por_cis1;
$por_cis1=$hlavicka->strx."";

  $text = "<POR_CIS1>".$por_cis1."</POR_CIS1>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($hlavicka->nstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV1>".$druhstr."</CISR_DUTV1>"."\r\n";
  fwrite($soubor, $text);

$cislostrediska=$hlavicka->nstr;
if( $hlavicka->nstr < 1000 ) $cislostrediska="0".$hlavicka->nstr;

  $text = "<CISR_NAKL_STREDISKA1>".$cislostrediska."</CISR_NAKL_STREDISKA1>"."\r\n";
  fwrite($soubor, $text);

  $text = "<NAKLADY_MZDY>".$hlavicka->mod4101s01."</NAKLADY_MZDY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<NAKLADY_ODVODY_FOND>".$hlavicka->mod4101s02."</NAKLADY_ODVODY_FOND>"."\r\n";
  fwrite($soubor, $text);

  $text = "<NAKLADY_LIEKY>".$hlavicka->mod4101s03."</NAKLADY_LIEKY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<NAKLADY_ZDRAV_POM>".$hlavicka->mod4101s04."</NAKLADY_ZDRAV_POM>"."\r\n";
  fwrite($soubor, $text);

  $text = "<NAKLADY_DOPL_SOR>".$hlavicka->mod4101s05."</NAKLADY_DOPL_SOR>"."\r\n";
  fwrite($soubor, $text);

  $text = "<NAKLADY_KRV>".$hlavicka->mod4101s06."</NAKLADY_KRV>"."\r\n";
  fwrite($soubor, $text);

  $text = "<NAKLADY_ODPISY_ZDRT>".$hlavicka->mod4101s07."</NAKLADY_ODPISY_ZDRT>"."\r\n";
  fwrite($soubor, $text);

  $text = "<NAKLADY_ODPISY_OST>".$hlavicka->mod4101s08."</NAKLADY_ODPISY_OST>"."\r\n";
  fwrite($soubor, $text);

  $text = "<NAKLADY_STRAV_PAC>".$hlavicka->mod4101s09."</NAKLADY_STRAV_PAC>"."\r\n";
  fwrite($soubor, $text);

  $text = "<NAKLADY_ENERGIA>".$hlavicka->mod4101s10."</NAKLADY_ENERGIA>"."\r\n";
  fwrite($soubor, $text);

  $text = "<NAKLADY_UDRZB__ZDRT>".$hlavicka->mod4101s11."</NAKLADY_UDRZB__ZDRT>"."\r\n";
  fwrite($soubor, $text);

  $text = "<NAKLADY_UDRZB__OST>".$hlavicka->mod4101s12."</NAKLADY_UDRZB__OST>"."\r\n";
  fwrite($soubor, $text);

  $text = "<NAKLADY_HTS_OST>".$hlavicka->mod4101s13."</NAKLADY_HTS_OST>"."\r\n";
  fwrite($soubor, $text);

  $text = "<NAKLADY_DOPR_ZDRAV>".$hlavicka->mod4101s14."</NAKLADY_DOPR_ZDRAV>"."\r\n";
  fwrite($soubor, $text);

  $text = "<NAKLADY_DOPR_HOSP>".$hlavicka->mod4101s15."</NAKLADY_DOPR_HOSP>"."\r\n";
  fwrite($soubor, $text);

  $text = "<NAKLADY_OST>".$hlavicka->mod4101s16."</NAKLADY_OST>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_01>"."\r\n";
  fwrite($soubor, $text);

          }
//koniec ak nenulove tlac

}
$i = $i + 1;
$j = $j + 1;
  }

  $text = "</OM_OE_01_01>"."\r\n";
  fwrite($soubor, $text);

//koniec modul 4101

//modul 4102

  $text = "<OM_OE_01_02>"."\r\n";
  fwrite($soubor, $text);

$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_e104prac WHERE prx = 2 AND nstr != 99999999 ORDER BY nstr,strx ".""; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//ak nenulove tlac
if( $hlavicka->mod4102s01 != 0 OR $hlavicka->mod4102s02 != 0 OR $hlavicka->mod4102s03 != 0 OR $hlavicka->mod4102s04 != 0 OR
 $hlavicka->mod4102s05 != 0 OR $hlavicka->mod4102s06 != 0 OR $hlavicka->mod4102s07 != 0 OR $hlavicka->mod4102s08 != 0 OR
 $hlavicka->mod4102s09 != 0 OR $hlavicka->mod4102s10 != 0 OR $hlavicka->mod4102s11 != 0 OR $hlavicka->mod4102s12 != 0 OR
 $hlavicka->mod4102s13 != 0 OR $hlavicka->mod4102s14 != 0 )
          {


  $text = "<OE_01_02>"."\r\n";
  fwrite($soubor, $text);

$por_cis1=$hlavicka->strx."";
//$por_cis1=$i+1;
//if ( $por_cis1 < 10 ) $por_cis1="0".$por_cis1;

  $text = "<POR_CIS2>".$por_cis1."</POR_CIS2>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($hlavicka->nstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV2>".$druhstr."</CISR_DUTV2>"."\r\n";
  fwrite($soubor, $text);

$cislostrediska=$hlavicka->nstr;
if( $hlavicka->nstr < 1000 ) $cislostrediska="0".$hlavicka->nstr;

  $text = "<CISR_NAKL_STREDISKA2>".$cislostrediska."</CISR_NAKL_STREDISKA2>"."\r\n";
  fwrite($soubor, $text);

  $text = "<TRZBY_ZP_HOSPITAL>".$hlavicka->mod4102s01."</TRZBY_ZP_HOSPITAL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<TRZBY_ZP_OSET_DNI>".$hlavicka->mod4102s02."</TRZBY_ZP_OSET_DNI>"."\r\n";
  fwrite($soubor, $text);

  $text = "<TRZBY_ZP_PRIP_POL>".$hlavicka->mod4102s03."</TRZBY_ZP_PRIP_POL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<TRZBY_ZP_STAC_DEN>".$hlavicka->mod4102s04."</TRZBY_ZP_STAC_DEN>"."\r\n";
  fwrite($soubor, $text);

//tuto polozku od 1.1.2015 zrusili
//$text = "<TRZBY_ZP_JEDEN_ST>".$hlavicka->mod4102s05."</TRZBY_ZP_JEDEN_ST>"."\r\n";
//fwrite($soubor, $text);

  $text = "<TRZBY_ZP_BODY>".$hlavicka->mod4102s06."</TRZBY_ZP_BODY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<TRZBY_ZP_KAP_PAUS>".$hlavicka->mod4102s07."</TRZBY_ZP_KAP_PAUS>"."\r\n";
  fwrite($soubor, $text);

  $text = "<TRZBY_ZP_INE>".$hlavicka->mod4102s08."</TRZBY_ZP_INE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<TRZBY_OB_LIEKY>".$hlavicka->mod4102s09."</TRZBY_OB_LIEKY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<TRZBY_OB_ZDR_POM>".$hlavicka->mod4102s10."</TRZBY_OB_ZDR_POM>"."\r\n";
  fwrite($soubor, $text);

  $text = "<TRZBY_OB_DOP_SORT>".$hlavicka->mod4102s11."</TRZBY_OB_DOP_SORT>"."\r\n";
  fwrite($soubor, $text);

  $text = "<TRZBY_OB_INE>".$hlavicka->mod4102s12."</TRZBY_OB_INE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<PREVADZ_DOTACIE_ZR>".$hlavicka->mod4102s13."</PREVADZ_DOTACIE_ZR>"."\r\n";
  fwrite($soubor, $text);

  $text = "<VYNOSY_OST>".$hlavicka->mod4102s14."</VYNOSY_OST>"."\r\n";
  fwrite($soubor, $text);

//nova polozka TRZBY_ZP_KM_MIN pridana od 1.1.2012 ale kedze Poliklinika SE ich urcite nema (trzby za letove hodiny ??? ) dam nulu nerozsirujem tabulku

  $text = "<TRZBY_ZP_KM_MIN>0</TRZBY_ZP_KM_MIN>"."\r\n";
  fwrite($soubor, $text);

//nova polozka TRZBY_ZP_VYKON pridana od 1.1.2015 

  $text = "<TRZBY_ZP_VYKON>0</TRZBY_ZP_VYKON>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_02>"."\r\n";
  fwrite($soubor, $text);

          }
//koniec ak nenulove tlac

}
$i = $i + 1;
$j = $j + 1;
  }

  $text = "</OM_OE_01_02>"."\r\n";
  fwrite($soubor, $text);

//koniec modul 4102


//modul 4103

  $text = "<OM_OE_01_03>"."\r\n";
  fwrite($soubor, $text);

$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_e104 WHERE stvrtrok = $stvrtrok ".""; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$cnstr=1*$hlavicka->mod4103r01str;

//ak nenulove tlac
if( $hlavicka->mod4103r01s1 != 0 OR $hlavicka->mod4103r01s2 != 0 OR $hlavicka->mod4103r01s3 != 0 OR $hlavicka->mod4103r01s4 != 0 OR
 $hlavicka->mod4103r01s5 != 0 OR $hlavicka->mod4103r01s6 != 0 OR $hlavicka->mod4103r01s7 != 0 )
        {

if( $cnstr > 0 )
          {

  $text = "<OE_01_03>"."\r\n";
  fwrite($soubor, $text);

  $text = "<POR_CIS3>01</POR_CIS3>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($cnstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV3>".$druhstr."</CISR_DUTV3>"."\r\n";
  fwrite($soubor, $text);


$cislostrediska=$cnstr;
if( $cnstr < 1000 ) $cislostrediska="0".$cnstr;

  $text = "<CISR_NAKL_STREDISKA3>".$cislostrediska."</CISR_NAKL_STREDISKA3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<BODY>".$hlavicka->mod4103r01s1."</BODY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<VYKONY>".$hlavicka->mod4103r01s2."</VYKONY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI>".$hlavicka->mod4103r01s3."</OS_DNI>"."\r\n";
  fwrite($soubor, $text);

  $text = "<PAC_NA_DOHODU>".$hlavicka->mod4103r01s4."</PAC_NA_DOHODU>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI_KAP_POSTEL>".$hlavicka->mod4103r01s5."</OS_DNI_KAP_POSTEL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<HOSP_UKONCENE>".$hlavicka->mod4103r01s6."</HOSP_UKONCENE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<DOPR_ZDRAV_KM>".$hlavicka->mod4103r01s7."</DOPR_ZDRAV_KM>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_03>"."\r\n";
  fwrite($soubor, $text);
          }

//koniec ak nenulove tlac
        }

$cnstr=1*$hlavicka->mod4103r02str;

//ak nenulove tlac
if( $hlavicka->mod4103r02s1 != 0 OR $hlavicka->mod4103r02s2 != 0 OR $hlavicka->mod4103r02s3 != 0 OR $hlavicka->mod4103r02s4 != 0 OR
 $hlavicka->mod4103r02s5 != 0 OR $hlavicka->mod4103r02s6 != 0 OR $hlavicka->mod4103r02s7 != 0 )
        {

if( $cnstr > 0 )
          {

  $text = "<OE_01_03>"."\r\n";
  fwrite($soubor, $text);

  $text = "<POR_CIS3>01</POR_CIS3>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($cnstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV3>".$druhstr."</CISR_DUTV3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<CISR_NAKL_STREDISKA3>".$cnstr."</CISR_NAKL_STREDISKA3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<BODY>".$hlavicka->mod4103r02s1."</BODY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<VYKONY>".$hlavicka->mod4103r02s2."</VYKONY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI>".$hlavicka->mod4103r02s3."</OS_DNI>"."\r\n";
  fwrite($soubor, $text);

  $text = "<PAC_NA_DOHODU>".$hlavicka->mod4103r02s4."</PAC_NA_DOHODU>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI_KAP_POSTEL>".$hlavicka->mod4103r02s5."</OS_DNI_KAP_POSTEL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<HOSP_UKONCENE>".$hlavicka->mod4103r02s6."</HOSP_UKONCENE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<DOPR_ZDRAV_KM>".$hlavicka->mod4103r02s7."</DOPR_ZDRAV_KM>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_03>"."\r\n";
  fwrite($soubor, $text);
          }

//koniec ak nenulove tlac
        }

$cnstr=1*$hlavicka->mod4103r03str;

//ak nenulove tlac
if( $hlavicka->mod4103r03s1 != 0 OR $hlavicka->mod4103r03s2 != 0 OR $hlavicka->mod4103r03s3 != 0 OR $hlavicka->mod4103r03s4 != 0 OR
 $hlavicka->mod4103r03s5 != 0 OR $hlavicka->mod4103r03s6 != 0 OR $hlavicka->mod4103r03s7 != 0 )
        {


if( $cnstr > 0 )
          {

  $text = "<OE_01_03>"."\r\n";
  fwrite($soubor, $text);

  $text = "<POR_CIS3>01</POR_CIS3>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($cnstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV3>".$druhstr."</CISR_DUTV3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<CISR_NAKL_STREDISKA3>".$cnstr."</CISR_NAKL_STREDISKA3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<BODY>".$hlavicka->mod4103r03s1."</BODY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<VYKONY>".$hlavicka->mod4103r03s2."</VYKONY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI>".$hlavicka->mod4103r03s3."</OS_DNI>"."\r\n";
  fwrite($soubor, $text);

  $text = "<PAC_NA_DOHODU>".$hlavicka->mod4103r03s4."</PAC_NA_DOHODU>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI_KAP_POSTEL>".$hlavicka->mod4103r03s5."</OS_DNI_KAP_POSTEL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<HOSP_UKONCENE>".$hlavicka->mod4103r03s6."</HOSP_UKONCENE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<DOPR_ZDRAV_KM>".$hlavicka->mod4103r03s7."</DOPR_ZDRAV_KM>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_03>"."\r\n";
  fwrite($soubor, $text);
          }

//koniec ak nenulove tlac
        }

$cnstr=1*$hlavicka->mod4103r04str;

//ak nenulove tlac
if( $hlavicka->mod4103r04s1 != 0 OR $hlavicka->mod4103r04s2 != 0 OR $hlavicka->mod4103r04s3 != 0 OR $hlavicka->mod4103r04s4 != 0 OR
 $hlavicka->mod4103r04s5 != 0 OR $hlavicka->mod4103r04s6 != 0 OR $hlavicka->mod4103r04s7 != 0 )
        {

if( $cnstr > 0 )
          {

  $text = "<OE_01_03>"."\r\n";
  fwrite($soubor, $text);

  $text = "<POR_CIS3>01</POR_CIS3>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($cnstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV3>".$druhstr."</CISR_DUTV3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<CISR_NAKL_STREDISKA3>".$cnstr."</CISR_NAKL_STREDISKA3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<BODY>".$hlavicka->mod4103r04s1."</BODY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<VYKONY>".$hlavicka->mod4103r04s2."</VYKONY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI>".$hlavicka->mod4103r04s3."</OS_DNI>"."\r\n";
  fwrite($soubor, $text);

  $text = "<PAC_NA_DOHODU>".$hlavicka->mod4103r04s4."</PAC_NA_DOHODU>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI_KAP_POSTEL>".$hlavicka->mod4103r04s5."</OS_DNI_KAP_POSTEL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<HOSP_UKONCENE>".$hlavicka->mod4103r04s6."</HOSP_UKONCENE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<DOPR_ZDRAV_KM>".$hlavicka->mod4103r04s7."</DOPR_ZDRAV_KM>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_03>"."\r\n";
  fwrite($soubor, $text);
          }

//koniec ak nenulove tlac
        }

$cnstr=1*$hlavicka->mod4103r05str;

//ak nenulove tlac
if( $hlavicka->mod4103r05s1 != 0 OR $hlavicka->mod4103r05s2 != 0 OR $hlavicka->mod4103r05s3 != 0 OR $hlavicka->mod4103r05s4 != 0 OR
 $hlavicka->mod4103r05s5 != 0 OR $hlavicka->mod4103r05s6 != 0 OR $hlavicka->mod4103r05s7 != 0 )
        {


if( $cnstr > 0 )
          {

  $text = "<OE_01_03>"."\r\n";
  fwrite($soubor, $text);

  $text = "<POR_CIS3>01</POR_CIS3>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($cnstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV3>".$druhstr."</CISR_DUTV3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<CISR_NAKL_STREDISKA3>".$cnstr."</CISR_NAKL_STREDISKA3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<BODY>".$hlavicka->mod4103r05s1."</BODY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<VYKONY>".$hlavicka->mod4103r05s2."</VYKONY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI>".$hlavicka->mod4103r05s3."</OS_DNI>"."\r\n";
  fwrite($soubor, $text);

  $text = "<PAC_NA_DOHODU>".$hlavicka->mod4103r05s4."</PAC_NA_DOHODU>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI_KAP_POSTEL>".$hlavicka->mod4103r05s5."</OS_DNI_KAP_POSTEL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<HOSP_UKONCENE>".$hlavicka->mod4103r05s6."</HOSP_UKONCENE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<DOPR_ZDRAV_KM>".$hlavicka->mod4103r05s7."</DOPR_ZDRAV_KM>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_03>"."\r\n";
  fwrite($soubor, $text);
          }

//koniec ak nenulove tlac
        }

$cnstr=1*$hlavicka->mod4103r06str;

//ak nenulove tlac
if( $hlavicka->mod4103r06s1 != 0 OR $hlavicka->mod4103r06s2 != 0 OR $hlavicka->mod4103r06s3 != 0 OR $hlavicka->mod4103r06s4 != 0 OR
 $hlavicka->mod4103r06s5 != 0 OR $hlavicka->mod4103r06s6 != 0 OR $hlavicka->mod4103r06s7 != 0 )
        {

if( $cnstr > 0 )
          {

  $text = "<OE_01_03>"."\r\n";
  fwrite($soubor, $text);

  $text = "<POR_CIS3>01</POR_CIS3>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($cnstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV3>".$druhstr."</CISR_DUTV3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<CISR_NAKL_STREDISKA3>".$cnstr."</CISR_NAKL_STREDISKA3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<BODY>".$hlavicka->mod4103r06s1."</BODY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<VYKONY>".$hlavicka->mod4103r06s2."</VYKONY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI>".$hlavicka->mod4103r06s3."</OS_DNI>"."\r\n";
  fwrite($soubor, $text);

  $text = "<PAC_NA_DOHODU>".$hlavicka->mod4103r06s4."</PAC_NA_DOHODU>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI_KAP_POSTEL>".$hlavicka->mod4103r06s5."</OS_DNI_KAP_POSTEL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<HOSP_UKONCENE>".$hlavicka->mod4103r06s6."</HOSP_UKONCENE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<DOPR_ZDRAV_KM>".$hlavicka->mod4103r06s7."</DOPR_ZDRAV_KM>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_03>"."\r\n";
  fwrite($soubor, $text);
          }

//koniec ak nenulove tlac
        }

$cnstr=1*$hlavicka->mod4103r07str;

//ak nenulove tlac
if( $hlavicka->mod4103r07s1 != 0 OR $hlavicka->mod4103r07s2 != 0 OR $hlavicka->mod4103r07s3 != 0 OR $hlavicka->mod4103r07s4 != 0 OR
 $hlavicka->mod4103r07s5 != 0 OR $hlavicka->mod4103r07s6 != 0 OR $hlavicka->mod4103r07s7 != 0 )
        {

if( $cnstr > 0 )
          {

  $text = "<OE_01_03>"."\r\n";
  fwrite($soubor, $text);

  $text = "<POR_CIS3>01</POR_CIS3>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($cnstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV3>".$druhstr."</CISR_DUTV3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<CISR_NAKL_STREDISKA3>".$cnstr."</CISR_NAKL_STREDISKA3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<BODY>".$hlavicka->mod4103r07s1."</BODY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<VYKONY>".$hlavicka->mod4103r07s2."</VYKONY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI>".$hlavicka->mod4103r07s3."</OS_DNI>"."\r\n";
  fwrite($soubor, $text);

  $text = "<PAC_NA_DOHODU>".$hlavicka->mod4103r07s4."</PAC_NA_DOHODU>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI_KAP_POSTEL>".$hlavicka->mod4103r07s5."</OS_DNI_KAP_POSTEL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<HOSP_UKONCENE>".$hlavicka->mod4103r07s6."</HOSP_UKONCENE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<DOPR_ZDRAV_KM>".$hlavicka->mod4103r07s7."</DOPR_ZDRAV_KM>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_03>"."\r\n";
  fwrite($soubor, $text);
          }

//koniec ak nenulove tlac
        }

$cnstr=1*$hlavicka->mod4103r08str;

//ak nenulove tlac
if( $hlavicka->mod4103r08s1 != 0 OR $hlavicka->mod4103r08s2 != 0 OR $hlavicka->mod4103r08s3 != 0 OR $hlavicka->mod4103r08s4 != 0 OR
 $hlavicka->mod4103r08s5 != 0 OR $hlavicka->mod4103r08s6 != 0 OR $hlavicka->mod4103r08s7 != 0 )
        {


if( $cnstr > 0 )
          {

  $text = "<OE_01_03>"."\r\n";
  fwrite($soubor, $text);

  $text = "<POR_CIS3>01</POR_CIS3>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($cnstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV3>".$druhstr."</CISR_DUTV3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<CISR_NAKL_STREDISKA3>".$cnstr."</CISR_NAKL_STREDISKA3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<BODY>".$hlavicka->mod4103r08s1."</BODY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<VYKONY>".$hlavicka->mod4103r08s2."</VYKONY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI>".$hlavicka->mod4103r08s3."</OS_DNI>"."\r\n";
  fwrite($soubor, $text);

  $text = "<PAC_NA_DOHODU>".$hlavicka->mod4103r08s4."</PAC_NA_DOHODU>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI_KAP_POSTEL>".$hlavicka->mod4103r08s5."</OS_DNI_KAP_POSTEL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<HOSP_UKONCENE>".$hlavicka->mod4103r08s6."</HOSP_UKONCENE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<DOPR_ZDRAV_KM>".$hlavicka->mod4103r08s7."</DOPR_ZDRAV_KM>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_03>"."\r\n";
  fwrite($soubor, $text);
          }

//koniec ak nenulove tlac
        }

$cnstr=1*$hlavicka->mod4103r09str;

//ak nenulove tlac
if( $hlavicka->mod4103r09s1 != 0 OR $hlavicka->mod4103r09s2 != 0 OR $hlavicka->mod4103r09s3 != 0 OR $hlavicka->mod4103r09s4 != 0 OR
 $hlavicka->mod4103r09s5 != 0 OR $hlavicka->mod4103r09s6 != 0 OR $hlavicka->mod4103r09s7 != 0 )
        {

if( $cnstr > 0 )
          {

  $text = "<OE_01_03>"."\r\n";
  fwrite($soubor, $text);

  $text = "<POR_CIS3>01</POR_CIS3>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($cnstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV3>".$druhstr."</CISR_DUTV3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<CISR_NAKL_STREDISKA3>".$cnstr."</CISR_NAKL_STREDISKA3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<BODY>".$hlavicka->mod4103r09s1."</BODY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<VYKONY>".$hlavicka->mod4103r09s2."</VYKONY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI>".$hlavicka->mod4103r09s3."</OS_DNI>"."\r\n";
  fwrite($soubor, $text);

  $text = "<PAC_NA_DOHODU>".$hlavicka->mod4103r09s4."</PAC_NA_DOHODU>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI_KAP_POSTEL>".$hlavicka->mod4103r09s5."</OS_DNI_KAP_POSTEL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<HOSP_UKONCENE>".$hlavicka->mod4103r09s6."</HOSP_UKONCENE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<DOPR_ZDRAV_KM>".$hlavicka->mod4103r09s7."</DOPR_ZDRAV_KM>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_03>"."\r\n";
  fwrite($soubor, $text);
          }

//koniec ak nenulove tlac
        }

$cnstr=1*$hlavicka->mod4103r10str;

//ak nenulove tlac
if( $hlavicka->mod4103r10s1 != 0 OR $hlavicka->mod4103r10s2 != 0 OR $hlavicka->mod4103r10s3 != 0 OR $hlavicka->mod4103r10s4 != 0 OR
 $hlavicka->mod4103r10s5 != 0 OR $hlavicka->mod4103r10s6 != 0 OR $hlavicka->mod4103r10s7 != 0 )
        {

if( $cnstr > 0 )
          {

  $text = "<OE_01_03>"."\r\n";
  fwrite($soubor, $text);

  $text = "<POR_CIS3>01</POR_CIS3>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($cnstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV3>".$druhstr."</CISR_DUTV3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<CISR_NAKL_STREDISKA3>".$cnstr."</CISR_NAKL_STREDISKA3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<BODY>".$hlavicka->mod4103r10s1."</BODY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<VYKONY>".$hlavicka->mod4103r10s2."</VYKONY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI>".$hlavicka->mod4103r10s3."</OS_DNI>"."\r\n";
  fwrite($soubor, $text);

  $text = "<PAC_NA_DOHODU>".$hlavicka->mod4103r10s4."</PAC_NA_DOHODU>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI_KAP_POSTEL>".$hlavicka->mod4103r10s5."</OS_DNI_KAP_POSTEL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<HOSP_UKONCENE>".$hlavicka->mod4103r10s6."</HOSP_UKONCENE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<DOPR_ZDRAV_KM>".$hlavicka->mod4103r10s7."</DOPR_ZDRAV_KM>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_03>"."\r\n";
  fwrite($soubor, $text);
          }

//koniec ak nenulove tlac
        }

$cnstr=1*$hlavicka->mod4103r11str;

//ak nenulove tlac
if( $hlavicka->mod4103r11s1 != 0 OR $hlavicka->mod4103r11s2 != 0 OR $hlavicka->mod4103r11s3 != 0 OR $hlavicka->mod4103r11s4 != 0 OR
 $hlavicka->mod4103r11s5 != 0 OR $hlavicka->mod4103r11s6 != 0 OR $hlavicka->mod4103r11s7 != 0 )
        {

if( $cnstr > 0 )
          {

  $text = "<OE_01_03>"."\r\n";
  fwrite($soubor, $text);

  $text = "<POR_CIS3>01</POR_CIS3>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($cnstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV3>".$druhstr."</CISR_DUTV3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<CISR_NAKL_STREDISKA3>".$cnstr."</CISR_NAKL_STREDISKA3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<BODY>".$hlavicka->mod4103r11s1."</BODY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<VYKONY>".$hlavicka->mod4103r11s2."</VYKONY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI>".$hlavicka->mod4103r11s3."</OS_DNI>"."\r\n";
  fwrite($soubor, $text);

  $text = "<PAC_NA_DOHODU>".$hlavicka->mod4103r11s4."</PAC_NA_DOHODU>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI_KAP_POSTEL>".$hlavicka->mod4103r11s5."</OS_DNI_KAP_POSTEL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<HOSP_UKONCENE>".$hlavicka->mod4103r11s6."</HOSP_UKONCENE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<DOPR_ZDRAV_KM>".$hlavicka->mod4103r11s7."</DOPR_ZDRAV_KM>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_03>"."\r\n";
  fwrite($soubor, $text);
          }

//koniec ak nenulove tlac
        }

$cnstr=1*$hlavicka->mod4103r12str;

//ak nenulove tlac
if( $hlavicka->mod4103r12s1 != 0 OR $hlavicka->mod4103r12s2 != 0 OR $hlavicka->mod4103r12s3 != 0 OR $hlavicka->mod4103r12s4 != 0 OR
 $hlavicka->mod4103r12s5 != 0 OR $hlavicka->mod4103r12s6 != 0 OR $hlavicka->mod4103r12s7 != 0 )
        {

if( $cnstr > 0 )
          {

  $text = "<OE_01_03>"."\r\n";
  fwrite($soubor, $text);

  $text = "<POR_CIS3>01</POR_CIS3>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($cnstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV3>".$druhstr."</CISR_DUTV3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<CISR_NAKL_STREDISKA3>".$cnstr."</CISR_NAKL_STREDISKA3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<BODY>".$hlavicka->mod4103r12s1."</BODY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<VYKONY>".$hlavicka->mod4103r12s2."</VYKONY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI>".$hlavicka->mod4103r12s3."</OS_DNI>"."\r\n";
  fwrite($soubor, $text);

  $text = "<PAC_NA_DOHODU>".$hlavicka->mod4103r12s4."</PAC_NA_DOHODU>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI_KAP_POSTEL>".$hlavicka->mod4103r12s5."</OS_DNI_KAP_POSTEL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<HOSP_UKONCENE>".$hlavicka->mod4103r12s6."</HOSP_UKONCENE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<DOPR_ZDRAV_KM>".$hlavicka->mod4103r12s7."</DOPR_ZDRAV_KM>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_03>"."\r\n";
  fwrite($soubor, $text);
          }

//koniec ak nenulove tlac
        }

$cnstr=1*$hlavicka->mod4103r13str;

//ak nenulove tlac
if( $hlavicka->mod4103r13s1 != 0 OR $hlavicka->mod4103r13s2 != 0 OR $hlavicka->mod4103r13s3 != 0 OR $hlavicka->mod4103r13s4 != 0 OR
 $hlavicka->mod4103r13s5 != 0 OR $hlavicka->mod4103r13s6 != 0 OR $hlavicka->mod4103r13s7 != 0 )
        {

if( $cnstr > 0 )
          {

  $text = "<OE_01_03>"."\r\n";
  fwrite($soubor, $text);

  $text = "<POR_CIS3>01</POR_CIS3>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($cnstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV3>".$druhstr."</CISR_DUTV3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<CISR_NAKL_STREDISKA3>".$cnstr."</CISR_NAKL_STREDISKA3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<BODY>".$hlavicka->mod4103r13s1."</BODY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<VYKONY>".$hlavicka->mod4103r13s2."</VYKONY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI>".$hlavicka->mod4103r13s3."</OS_DNI>"."\r\n";
  fwrite($soubor, $text);

  $text = "<PAC_NA_DOHODU>".$hlavicka->mod4103r13s4."</PAC_NA_DOHODU>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI_KAP_POSTEL>".$hlavicka->mod4103r13s5."</OS_DNI_KAP_POSTEL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<HOSP_UKONCENE>".$hlavicka->mod4103r13s6."</HOSP_UKONCENE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<DOPR_ZDRAV_KM>".$hlavicka->mod4103r13s7."</DOPR_ZDRAV_KM>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_03>"."\r\n";
  fwrite($soubor, $text);
          }

//koniec ak nenulove tlac
        }

$cnstr=1*$hlavicka->mod4103r14str;

//ak nenulove tlac
if( $hlavicka->mod4103r14s1 != 0 OR $hlavicka->mod4103r14s2 != 0 OR $hlavicka->mod4103r14s3 != 0 OR $hlavicka->mod4103r14s4 != 0 OR
 $hlavicka->mod4103r14s5 != 0 OR $hlavicka->mod4103r14s6 != 0 OR $hlavicka->mod4103r14s7 != 0 )
        {

if( $cnstr > 0 )
          {

  $text = "<OE_01_03>"."\r\n";
  fwrite($soubor, $text);

  $text = "<POR_CIS3>01</POR_CIS3>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($cnstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV3>".$druhstr."</CISR_DUTV3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<CISR_NAKL_STREDISKA3>".$cnstr."</CISR_NAKL_STREDISKA3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<BODY>".$hlavicka->mod4103r14s1."</BODY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<VYKONY>".$hlavicka->mod4103r14s2."</VYKONY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI>".$hlavicka->mod4103r14s3."</OS_DNI>"."\r\n";
  fwrite($soubor, $text);

  $text = "<PAC_NA_DOHODU>".$hlavicka->mod4103r14s4."</PAC_NA_DOHODU>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI_KAP_POSTEL>".$hlavicka->mod4103r14s5."</OS_DNI_KAP_POSTEL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<HOSP_UKONCENE>".$hlavicka->mod4103r14s6."</HOSP_UKONCENE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<DOPR_ZDRAV_KM>".$hlavicka->mod4103r14s7."</DOPR_ZDRAV_KM>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_03>"."\r\n";
  fwrite($soubor, $text);
          }

//koniec ak nenulove tlac
        }

$cnstr=1*$hlavicka->mod4103r15str;

//ak nenulove tlac
if( $hlavicka->mod4103r15s1 != 0 OR $hlavicka->mod4103r15s2 != 0 OR $hlavicka->mod4103r15s3 != 0 OR $hlavicka->mod4103r15s4 != 0 OR
 $hlavicka->mod4103r15s5 != 0 OR $hlavicka->mod4103r15s6 != 0 OR $hlavicka->mod4103r15s7 != 0 )
        {

if( $cnstr > 0 )
          {

  $text = "<OE_01_03>"."\r\n";
  fwrite($soubor, $text);

  $text = "<POR_CIS3>01</POR_CIS3>"."\r\n";
  fwrite($soubor, $text);

$druhstr=substr($cnstr,0,1);
if( $druhstr == 9 ) $druhstr="0";

  $text = "<CISR_DUTV3>".$druhstr."</CISR_DUTV3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<CISR_NAKL_STREDISKA3>".$cnstr."</CISR_NAKL_STREDISKA3>"."\r\n";
  fwrite($soubor, $text);

  $text = "<BODY>".$hlavicka->mod4103r15s1."</BODY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<VYKONY>".$hlavicka->mod4103r15s2."</VYKONY>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI>".$hlavicka->mod4103r15s3."</OS_DNI>"."\r\n";
  fwrite($soubor, $text);

  $text = "<PAC_NA_DOHODU>".$hlavicka->mod4103r15s4."</PAC_NA_DOHODU>"."\r\n";
  fwrite($soubor, $text);

  $text = "<OS_DNI_KAP_POSTEL>".$hlavicka->mod4103r15s5."</OS_DNI_KAP_POSTEL>"."\r\n";
  fwrite($soubor, $text);

  $text = "<HOSP_UKONCENE>".$hlavicka->mod4103r15s6."</HOSP_UKONCENE>"."\r\n";
  fwrite($soubor, $text);

  $text = "<DOPR_ZDRAV_KM>".$hlavicka->mod4103r15s7."</DOPR_ZDRAV_KM>"."\r\n";
  fwrite($soubor, $text);

  $text = "</OE_01_03>"."\r\n";
  fwrite($soubor, $text);
          }

//koniec ak nenulove tlac
        }

}
$i = $i + 1;
$j = $j + 1;
  }

  $text = "</OM_OE_01_03>"."\r\n";
  fwrite($soubor, $text);

//koniec modul 4103

//uplny koniec vykazu

  $text = "</vykaz>"."\r\n";
  fwrite($soubor, $text);

  $text = "</vykazy>"."\r\n";
  fwrite($soubor, $text);


fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.xml">../tmp/<?php echo $nazsub; ?>.xml</a>


<?php

          }
//koniec subor XML
?>

<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 200; top: 200; left: 40; width:60; height:100;">
<img border=0 src='../obr/robot/robot3.jpg' style='' onClick="zobraz_robotmenu();"
 alt='Dobr˝ deÚ , ja som V·ö EkoRobot , ak m·te ot·zku alebo nejakÈ ûelanie kliknite na mÚa prosÌm 1x myöou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 alt='Zhasni EkoRobota' >
</div>
<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 160; left: 90; width:200; height:100;">
zobrazene menu
</div>

<?php

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
