<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu ZAV101 2016
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

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");

//.jpg podklad
$jpg_cesta="../dokumenty/statistika2016/roc_zav101/roc_zav101_v16";
$jpg_popis="tlaèivo Roèný závodný výkaz produkèných odvetví Roè Zav 1-01 ".$kli_vrok;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$mesiac=$kli_vmes;
$vyb_ump="1.".$kli_vrok; $vyb_umk=$kli_vmes.".".$kli_vrok;

//cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$modul = 1*$_REQUEST['modul'];


$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 AND $copern == 11 ) $strana=9999;
if ( $strana == 0 ) $strana=1;

if ( $copern == 1 ) { $copern=102; };

//vsetky moduly z obratovky
$citajvsetkymoduly=0;
if( $modul == 9200 )
{
$citajvsetkymoduly=1;
$modul=178;
}

//modul 592
if( $modul == 592 )
{
$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 041 OR LEFT(uce,3) = 042 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd;
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET m592r12='$prir'  WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");



$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 641 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce3=substr($polozka->uce,0,3);
if( $uce3 == '641' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET m592r16='$ubyt'  WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$strana=2;
}
//koniec modul592

//modul 179
if( $modul == 179 )
{
$r05=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 531 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r05=$r05+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }

$r06=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 532 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r06=$r06+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET m179r5='$r05', m179r6='$r06'  WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$strana=4;
}
//koniec modul179

//modul 178
if( $modul == 178 )
{
$r01=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 501 OR LEFT(uce,3) = 502 OR LEFT(uce,3) = 503 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01=$r01+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }


$r02=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,2) = 51 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02=$r02+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }


$r04=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 549 OR LEFT(uce,3) = 582 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r04=$r04+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }


$r08=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 524 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r08=$r08+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }


$r10=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 525 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r10=$r10+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }




$r14=0; $r15=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 112 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) {
$polozka=mysql_fetch_object($sql);
$r14=$r14+$polozka->pmd-$polozka->pdl;
$r15=$r15+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }

$r16=0; $r17=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 123 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) {
$polozka=mysql_fetch_object($sql);
$r16=$r16+$polozka->pmd-$polozka->pdl;
$r17=$r17+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }


$r18=0; $r19=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 132 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) {
$polozka=mysql_fetch_object($sql);
$r18=$r18+$polozka->pmd-$polozka->pdl;
$r19=$r19+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".
" m178r1='$r01', m178r2='$r02', m178r4='$r04', m178r8='$r08', m178r10='$r10', m178r14='$r14', m178r15='$r15', ".
" m178r16='$r16', m178r17='$r17', m178r18='$r18', m178r19='$r19' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

//prenos na stranu5
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET m182r16=m178r16, m182r17=m178r17  WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");
//prenos na stranu6
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET m183r12=m178r2  WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");
//prenos na stranu7
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET m184r12=m178r1, m184r15=m178r14, m184r16=m178r15  WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");
//prenos na stranu8
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET m185r16=m178r18, m185r17=m178r19  WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


$strana=3;
}
//koniec modul178

//modul 177
if( $modul == 177 )
{

$r01=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 601 OR LEFT(uce,3) = 602 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01=$r01+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }

$r03=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 604 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r03=$r03+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }


$r05=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 504 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r05=$r05+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }


$r07=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,2) = 62 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r07=$r07+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }


$r08=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,2) = 61 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r08=$r08+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }



$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".
" m177r1='$r01', m177r3='$r03', m177r5='$r05', m177r7='$r07', m177r8='$r08' WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

//prenos na stranu5
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET m182r12=m177r1, m182r14=m177r7 WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");
//prenos na stranu8
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET m185r12=m177r3, m185r15=m177r5 WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$strana=3;
}
//koniec modul177




//vytvor tabulku v databaze
$sql = "SELECT konx FROM F$kli_vxcf"."_statistika_zav101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = 'DROP TABLE F'.$kli_vxcf.'_statistika_zav101';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   psys         INT DEFAULT 0,
   cinnost      VARCHAR(100) not null,
   konx         DECIMAL(10,0) DEFAULT 0,
   ico          DECIMAL(8,0) DEFAULT 0
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statistika_zav101'.$sqlt;
$vytvor = mysql_query("$vsql");

$ttvv = "INSERT INTO F$kli_vxcf"."_statistika_zav101 ( ico ) VALUES ( '0' )";
$ttqq = mysql_query("$ttvv");

}

//sem pojdu definicie tabulky
$sql = "SELECT odoslane FROM F$kli_vxcf"."_statistika_zav101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def1<br />";
//1.strana
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD odoslane DATE NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m592r996 FROM F$kli_vxcf"."_statistika_zav101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def2<br />";
//2.strana
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r24 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r25 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r26 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r31 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r32 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r33 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r34 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r35 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r36 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r41 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r42 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r43 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r44 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r45 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r46 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r51 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r52 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r53 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r54 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r55 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r56 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r61 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r62 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r63 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r64 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r65 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r66 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r71 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r72 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r73 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r74 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r75 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r76 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r81 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r82 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r83 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r84 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r85 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r86 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r91 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r92 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r93 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r94 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r95 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r96 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r101 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r102 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r103 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r104 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r105 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r106 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r112 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r113 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r114 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r115 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r116 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r121 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r122 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r123 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r124 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r125 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r126 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r131 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r132 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r133 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r134 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r135 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r136 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r141 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r142 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r143 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r144 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r145 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r146 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r151 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r152 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r153 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r154 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r155 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r156 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r161 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r162 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r163 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r164 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r165 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r166 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r171 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r172 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r173 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r174 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r175 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r176 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r181 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r182 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r183 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r184 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r185 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r186 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r191 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r192 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r193 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r194 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r195 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r196 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r212 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r213 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r214 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r215 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r216 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r221 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r222 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r223 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r224 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r225 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r226 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r231 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r232 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r233 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r234 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r235 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r236 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r241 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r242 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r243 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r244 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r245 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r246 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r251 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r252 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r253 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r254 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r255 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r256 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r993 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r994 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r995 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m592r996 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m178r99 FROM F$kli_vxcf"."_statistika_zav101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def3<br />";
//3.strana
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m177r1 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m177r2 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m177r3 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m177r4 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m177r5 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m177r6 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m177r7 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m177r8 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m177r9 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m177r10 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m177r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r1 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r2 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r3 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r4 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r5 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r6 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r7 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r8 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r9 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r10 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r17 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r18 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r19 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m178r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m179r99 FROM F$kli_vxcf"."_statistika_zav101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def4<br />";
//4.strana
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m179r1 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m179r2 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m179r3 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m179r4 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m179r5 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m179r6 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m179r7 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m179r8 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m179r9 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m179r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m182r997 FROM F$kli_vxcf"."_statistika_zav101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def5<br />";
//5.strana
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r17 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r24 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r25 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r26 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r27 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r31 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r32 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r33 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r34 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r35 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r36 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r37 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r41 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r42 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r43 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r44 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r45 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r46 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r47 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r51 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r52 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r53 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r54 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r55 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r56 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r57 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r61 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r62 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r63 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r64 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r65 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r66 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r67 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r71 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r72 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r73 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r74 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r75 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r76 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r77 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r81 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r82 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r83 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r84 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r85 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r86 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r87 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r91 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r92 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r93 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r94 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r95 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r96 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r97 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r101 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r102 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r103 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r104 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r105 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r106 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r107 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r112 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r113 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r114 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r115 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r116 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r117 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r121 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r122 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r123 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r124 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r125 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r126 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r127 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r131 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r132 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r133 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r134 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r135 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r136 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r137 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r141 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r142 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r143 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r144 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r145 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r146 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r147 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r151 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r152 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r153 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r154 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r155 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r156 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r157 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r161 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r162 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r163 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r164 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r165 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r166 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r167 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r171 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r172 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r173 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r174 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r175 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r176 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r177 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r181 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r182 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r183 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r184 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r185 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r186 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r187 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r191 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r192 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r193 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r194 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r195 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r196 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r197 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r212 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r213 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r214 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r215 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r216 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r217 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r221 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r222 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r223 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r224 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r225 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r226 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r227 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r231 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r232 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r233 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r234 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r235 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r236 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r237 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r241 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r242 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r243 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r244 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r245 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r246 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r247 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r251 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r252 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r253 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r254 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r255 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r256 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r257 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r261 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r262 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r263 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r264 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r265 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r266 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r267 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r271 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r272 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r273 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r274 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r275 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r276 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r277 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r281 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r282 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r283 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r284 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r285 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r286 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r287 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r291 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r292 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r293 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r294 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r295 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r296 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r297 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r301 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r302 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r303 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r304 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r305 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r306 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r307 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r311 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r312 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r313 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r314 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r315 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r316 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r317 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r321 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r322 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r323 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r324 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r325 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r326 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r327 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r331 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r332 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r333 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r334 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r335 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r336 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r337 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r993 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r994 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r995 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r996 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m182r997 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m183r994 FROM F$kli_vxcf"."_statistika_zav101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def6<br />";
//6.strana
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r24 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r31 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r32 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r33 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r34 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r41 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r42 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r43 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r44 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r51 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r52 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r53 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r54 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r61 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r62 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r63 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r64 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r71 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r72 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r73 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r74 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r81 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r82 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r83 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r84 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r91 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r92 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r93 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r94 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r101 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r102 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r103 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r104 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r112 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r113 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r114 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r121 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r122 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r123 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r124 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r131 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r132 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r133 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r134 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r141 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r142 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r143 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r144 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r151 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r152 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r153 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r154 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r161 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r162 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r163 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r164 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r171 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r172 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r173 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r174 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r181 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r182 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r183 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r184 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r191 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r192 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r193 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r194 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r212 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r213 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r214 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r221 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r222 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r223 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r224 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r231 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r232 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r233 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r234 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r241 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r242 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r243 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r244 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r251 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r252 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r253 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r254 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r261 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r262 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r263 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r264 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r271 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r272 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r273 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r274 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r281 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r282 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r283 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r284 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r291 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r292 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r293 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r294 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r301 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r302 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r303 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r304 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r993 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m183r994 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m184r996 FROM F$kli_vxcf"."_statistika_zav101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def7<br />";
//7.strana
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r24 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r25 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r26 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r31 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r32 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r33 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r34 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r35 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r36 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r41 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r42 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r43 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r44 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r45 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r46 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r51 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r52 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r53 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r54 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r55 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r56 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r61 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r62 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r63 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r64 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r65 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r66 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r71 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r72 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r73 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r74 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r75 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r76 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r81 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r82 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r83 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r84 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r85 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r86 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r91 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r92 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r93 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r94 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r95 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r96 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r101 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r102 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r103 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r104 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r105 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r106 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r112 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r113 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r114 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r115 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r116 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r121 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r122 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r123 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r124 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r125 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r126 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r131 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r132 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r133 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r134 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r135 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r136 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r141 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r142 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r143 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r144 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r145 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r146 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r151 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r152 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r153 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r154 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r155 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r156 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r161 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r162 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r163 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r164 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r165 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r166 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r171 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r172 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r173 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r174 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r175 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r176 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r181 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r182 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r183 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r184 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r185 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r186 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r191 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r192 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r193 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r194 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r195 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r196 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r212 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r213 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r214 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r215 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r216 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r221 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r222 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r223 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r224 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r225 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r226 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r231 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r232 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r233 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r234 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r235 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r236 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r241 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r242 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r243 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r244 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r245 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r246 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r251 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r252 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r253 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r254 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r255 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r256 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r261 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r262 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r263 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r264 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r265 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r266 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r271 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r272 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r273 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r274 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r275 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r276 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r281 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r282 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r283 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r284 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r285 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r286 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r291 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r292 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r293 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r294 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r295 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r296 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r301 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r302 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r303 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r304 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r305 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r306 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r311 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r312 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r313 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r314 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r315 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r316 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r321 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r322 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r323 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r324 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r325 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r326 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r993 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r994 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r995 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m184r996 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m185r997 FROM F$kli_vxcf"."_statistika_zav101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def8<br />";
//8.strana
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r17 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r24 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r25 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r26 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r27 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r31 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r32 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r33 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r34 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r35 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r36 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r37 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r41 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r42 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r43 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r44 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r45 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r46 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r47 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r51 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r52 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r53 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r54 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r55 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r56 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r57 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r61 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r62 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r63 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r64 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r65 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r66 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r67 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r71 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r72 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r73 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r74 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r75 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r76 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r77 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r81 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r82 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r83 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r84 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r85 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r86 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r87 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r91 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r92 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r93 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r94 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r95 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r96 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r97 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r101 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r102 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r103 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r104 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r105 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r106 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r107 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r112 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r113 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r114 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r115 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r116 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r117 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r121 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r122 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r123 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r124 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r125 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r126 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r127 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r131 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r132 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r133 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r134 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r135 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r136 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r137 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r141 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r142 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r143 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r144 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r145 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r146 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r147 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r151 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r152 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r153 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r154 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r155 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r156 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r157 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r161 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r162 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r163 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r164 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r165 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r166 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r167 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r171 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r172 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r173 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r174 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r175 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r176 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r177 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r181 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r182 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r183 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r184 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r185 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r186 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r187 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r191 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r192 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r193 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r194 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r195 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r196 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r197 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r212 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r213 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r214 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r215 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r216 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r217 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r221 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r222 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r223 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r224 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r225 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r226 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r227 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r231 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r232 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r233 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r234 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r235 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r236 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r237 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r241 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r242 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r243 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r244 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r245 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r246 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r247 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r251 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r252 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r253 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r254 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r255 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r256 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r257 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r261 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r262 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r263 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r264 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r265 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r266 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r267 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r271 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r272 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r273 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r274 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r275 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r276 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r277 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r281 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r282 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r283 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r284 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r285 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r286 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r287 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r291 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r292 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r293 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r294 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r295 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r296 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r297 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r301 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r302 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r303 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r304 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r305 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r306 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r307 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r993 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r994 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r995 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r996 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101 ADD m185r997 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}


$sql = "SELECT konx FROM F$kli_vxcf"."_statistika_zav101s2 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = 'DROP TABLE F'.$kli_vxcf.'_statistika_zav101s2';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   psys         INT DEFAULT 0,
   cinnost      VARCHAR(100) not null,
   konx         DECIMAL(10,0) DEFAULT 0,
   ico          DECIMAL(8,0) DEFAULT 0
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statistika_zav101s2'.$sqlt;
$vytvor = mysql_query("$vsql");

$ttvv = "INSERT INTO F$kli_vxcf"."_statistika_zav101s2 ( ico ) VALUES ( '0' )";
$ttqq = mysql_query("$ttvv");

}

$sql = "SELECT m186r997 FROM F$kli_vxcf"."_statistika_zav101s2 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def9<br />";
//9.strana
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r17 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r24 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r25 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r26 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r27 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r31 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r32 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r33 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r34 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r35 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r36 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r37 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r41 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r42 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r43 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r44 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r45 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r46 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r47 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r51 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r52 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r53 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r54 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r55 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r56 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r57 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r61 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r62 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r63 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r64 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r65 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r66 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r67 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r71 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r72 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r73 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r74 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r75 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r76 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r77 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r81 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r82 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r83 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r84 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r85 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r86 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r87 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r91 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r92 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r93 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r94 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r95 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r96 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r97 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r101 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r102 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r103 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r104 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r105 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r106 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r107 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r112 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r113 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r114 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r115 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r116 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r117 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r121 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r122 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r123 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r124 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r125 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r126 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r127 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r131 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r132 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r133 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r134 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r135 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r136 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r137 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r141 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r142 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r143 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r144 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r145 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r146 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r147 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r151 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r152 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r153 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r154 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r155 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r156 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r157 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r161 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r162 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r163 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r164 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r165 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r166 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r167 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r171 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r172 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r173 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r174 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r175 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r176 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r177 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r181 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r182 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r183 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r184 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r185 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r186 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r187 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r191 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r192 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r193 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r194 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r195 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r196 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r197 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r212 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r213 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r214 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r215 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r216 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r217 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r221 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r222 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r223 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r224 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r225 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r226 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r227 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r231 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r232 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r233 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r234 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r235 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r236 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r237 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r241 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r242 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r243 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r244 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r245 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r246 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r247 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r251 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r252 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r253 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r254 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r255 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r256 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r257 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r261 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r262 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r263 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r264 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r265 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r266 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r267 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r271 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r272 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r273 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r274 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r275 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r276 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r277 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r281 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r282 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r283 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r284 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r285 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r286 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r287 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r291 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r292 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r293 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r294 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r295 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r296 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r297 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r301 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r302 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r303 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r304 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r305 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r306 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r307 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r993 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r994 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r995 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r996 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m186r997 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m1590r2b FROM F$kli_vxcf"."_statistika_zav101s2 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def10<br />";
//10.strana
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m187r1 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m187r2 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m187r3 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m187r4 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m187r5 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m187r6 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m187r7 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m187r8 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m187r9 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m187r10 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m187r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m187r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m1590r1a DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m1590r1b DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m1590r2a DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m1590r2b DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m304r99 FROM F$kli_vxcf"."_statistika_zav101s2 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def11<br />";
//11.strana
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r24 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r25 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r31 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r32 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r33 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r34 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r35 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r41 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r42 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r43 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r44 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r45 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r51 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r52 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r53 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r54 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r55 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r61 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r62 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r63 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r64 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r65 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r71 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r72 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r73 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r74 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r75 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r81 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r82 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r83 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r84 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r85 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r91 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r92 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r93 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r94 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r95 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r101 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r102 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r103 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r104 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r105 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r112 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r113 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r114 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r115 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r121 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r122 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r123 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r124 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r125 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r131 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r132 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r133 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r134 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r135 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r141 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r142 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r143 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r144 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r145 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r151 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r152 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r153 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r154 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r155 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r161 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r162 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r163 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r164 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r165 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r171 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r172 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r173 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r174 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r175 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r181 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r182 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r183 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r184 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r185 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r191 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r192 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r193 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r194 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r195 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r993 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r994 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m590r995 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r1 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r2 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r3 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r4 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r5 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r6 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r7 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r8 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r9 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r10 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m304r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m110r999 FROM F$kli_vxcf"."_statistika_zav101s2 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def12<br />";
//12.strana
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r13 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r15 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r17 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r18 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r19 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r23 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r24 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r25 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r26 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r27 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r28 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r29 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r32 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r33 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r34 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r35 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r36 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r37 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r38 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r39 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r42 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r43 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r44 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r45 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r46 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r47 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r48 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r49 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r52 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r53 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r54 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r55 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r56 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r57 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r58 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r59 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r62 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r63 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r64 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r65 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r66 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r67 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r68 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r69 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r72 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r73 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r74 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r75 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r76 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r77 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r78 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r79 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r82 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r83 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r84 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r85 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r86 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r87 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r88 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r89 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r92 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r93 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r94 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r95 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r96 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r97 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r98 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r99 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r102 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r103 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r104 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r105 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r106 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r107 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r108 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r109 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r112 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r113 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r114 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r115 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r116 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r117 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r118 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r119 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r122 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r123 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r124 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r125 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r126 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r127 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r128 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r129 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r132 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r133 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r134 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r135 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r136 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r137 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r138 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r139 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r142 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r143 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r144 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r145 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r146 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r147 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r148 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r149 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r152 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r153 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r154 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r155 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r156 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r157 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r158 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r159 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r162 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r163 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r164 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r165 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r166 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r167 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r168 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r169 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r172 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r173 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r174 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r175 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r176 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r177 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r178 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r179 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r182 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r183 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r184 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r185 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r186 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r187 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r188 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r189 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r192 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r193 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r194 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r195 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r196 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r197 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r198 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r199 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r203 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r205 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r207 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r208 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r209 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r212 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r213 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r214 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r215 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r216 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r217 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r218 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r219 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r222 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r223 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r224 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r225 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r226 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r227 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r228 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r229 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r232 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r233 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r234 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r235 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r236 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r237 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r238 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r239 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r242 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r243 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r244 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r245 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r246 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r247 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r248 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r249 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r252 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r253 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r254 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r255 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r256 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r257 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r258 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r259 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r262 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r263 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r264 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r265 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r266 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r267 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r268 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r269 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r272 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r273 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r274 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r275 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r276 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r277 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r278 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r279 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r282 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r283 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r284 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r285 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r286 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r287 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r288 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r289 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r292 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r293 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r294 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r295 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r296 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r297 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r298 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r299 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r302 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r303 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r304 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r305 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r306 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r307 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r308 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r309 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r312 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r313 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r314 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r315 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r316 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r317 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r318 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r319 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r322 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r323 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r324 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r325 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r326 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r327 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r328 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r329 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r332 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r333 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r334 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r335 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r336 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r337 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r338 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r339 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r342 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r343 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r344 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r345 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r346 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r347 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r348 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r349 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r993 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r994 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r995 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r996 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r997 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r998 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_zav101s2 ADD m110r999 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}


//koniec vytvor tabulku v databaze

//nacitaj mzdy modul 304
if ( $copern == 200 )
{
$h_mfir = $kli_vxcf;
$vyb_ume = $kli_vume;
$vyb_ump = "1.".$kli_vrok;
$vyb_umk = "12.".$kli_vrok;

$vsql = 'DROP TABLE F'.$kli_vxcf.'_statprac';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statprac
(
   drh          DECIMAL(3,0) DEFAULT 0,
   oc           INT(5),
   ume          DECIMAL(7,4) DEFAULT 0,
   rodc         VARCHAR(6),
   zena         INT(1),
   pom          DECIMAL(3,0) DEFAULT 0,
   dhpom        DECIMAL(3,0) DEFAULT 0,
   pocet        DECIMAL(10,0) DEFAULT 0,
   dm           INT(5),
   dni          DECIMAL(10,2) DEFAULT 0,
   hod          DECIMAL(10,2) DEFAULT 0,
   kc           DECIMAL(10,2) DEFAULT 0,
   ico          DECIMAL(8,0),
   uvap         DECIMAL(10,2) DEFAULT 0,
   uvax         DECIMAL(10,2) DEFAULT 0,
   skrat        DECIMAL(3,0) DEFAULT 0
);
statprac;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statprac'.$sqlt;
$vytvor = mysql_query("$vsql");

//pocet zamestnancov

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 0,oc,ume,rdc,0,pom,0,1, ".
"0,0,0,0,$fir_fico,0,uva,0 ".
" FROM F$kli_vxcf"."_mzdzalkun".
" WHERE pom != 9 AND ume >= $vyb_ump AND ume <= $vyb_umk".
"";
$dsql = mysql_query("$dsqlt");

//echo $dsqlt;
//exit;

$uprtxt = "UPDATE F$kli_vxcf"."_statprac,F$kli_vxcf"."_mzdpomer SET ".
" dhpom=pm_doh, zena=SUBSTRING(rodc,3,2) ".
" WHERE F$kli_vxcf"."_statprac.pom = F$kli_vxcf"."_mzdpomer.pm";
$upravene = mysql_query("$uprtxt");

/////////////NACITANIE prac.uvazku standartneho
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uva_hod=$riaddok->uva_hod;
  }

$uprtxt = "UPDATE F$kli_vxcf"."_statprac SET uvap=uvax/$uva_hod ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_statprac SET skrat=1 WHERE uvap < 0.8 AND uvax < $uva_hod";
$upravene = mysql_query("$uprtxt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 999,oc,ume,rodc,zena,pom,dhpom,SUM(pocet), ".
"dm,dni,hod,kc,$fir_fico,uvap,0,skrat".
" FROM F$kli_vxcf"."_statprac".
" WHERE dhpom >= 0".
" GROUP BY ume,dhpom";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 998,oc,ume,rodc,zena,pom,dhpom,SUM(pocet), ".
"dm,dni,hod,kc,$fir_fico,uvap,0,skrat".
" FROM F$kli_vxcf"."_statprac".
" WHERE dhpom = 1".
" GROUP BY oc";
$dsql = mysql_query("$dsqlt");

//pocet zamestnancov

$r02=0; $r02m1=0; $r02m2=0; $r02m3=0; $r02m4=0; $r02m5=0; $r02m6=0; $r02m7=0; $r02m8=0; $r02m9=0; $r02m10=0; $r02m11=0; $r02m12=0;
$r03=0; $r04=0; $r07=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 1.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m1=$r02m1+$polozka->pocet; }
$i=$i+1;                   }

//echo $r02m1;
//exit;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 2.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m2=$r02m2+$polozka->pocet; }
$i=$i+1;                   }


$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 3.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m3=$r02m3+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 4.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m4=$r02m4+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 5.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m5=$r02m5+$polozka->pocet; }
$i=$i+1;                   }


$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 6.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m6=$r02m6+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 7.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m7=$r02m7+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 8.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m8=$r02m8+$polozka->pocet; }
$i=$i+1;                   }


$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 9.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m9=$r02m9+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 10.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m10=$r02m10+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 11.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m11=$r02m11+$polozka->pocet; }
$i=$i+1;                   }


$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 12.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m12=$r02m12+$polozka->pocet; }
$i=$i+1;                   }

$r02=($r02m1+$r02m2+$r02m3+$r02m4+$r02m5+$r02m6+$r02m7+$r02m8+$r02m9+$r02m10+$r02m11+$r02m12)/12;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 0 AND ume = $vyb_umk AND zena > 12 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r04=$r04+1; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 0 AND ume = $vyb_umk AND dhpom = 1";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r07=$r07+1; }
$i=$i+1;                   }


$r01=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 0 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01=$r01+($polozka->pocet*$polozka->uvap); }
$i=$i+1;                   }

$r01=($r01)/12;



//odpracovane hodiny a eur a odvody

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 0,oc,ume,'',0,vpom,0,1, ".
"dm,dni,hod,kc,$fir_fico,0,0,0 ".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume >= $vyb_ump AND ume <= $vyb_umk".
"";
$dsql = mysql_query("$dsqlt");

$uprtxt = "UPDATE F$kli_vxcf"."_statprac,F$kli_vxcf"."_mzdpomer SET ".
" dhpom=pm_doh ".
" WHERE F$kli_vxcf"."_statprac.pom = F$kli_vxcf"."_mzdpomer.pm";
$upravene = mysql_query("$uprtxt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 555,oc,ume,rodc,zena,pom,dhpom,pocet, ".
"dm,SUM(dni),SUM(hod),SUM(kc),$fir_fico,0,0,0 ".
" FROM F$kli_vxcf"."_statprac".
" WHERE dhpom >= 0".
" GROUP BY ume,dhpom,dm";
$dsql = mysql_query("$dsqlt");

$r05=0; $r08=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( ( dm > 100 AND dm < 111 ) OR dm = 132 OR dm = 209 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r05=$r05+$polozka->hod; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 1 AND ( ( dm > 100 AND dm < 111 ) OR dm = 132 OR dm = 209 ) ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r08=$r08+$polozka->hod; }
$i=$i+1;                   }

$r10=0; $r12=0; $r13=0; $r14=0; $r15=0; $r16=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( dm > 100 AND dm < 599 AND dm != 209 AND dm != 130 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r10=$r10+$polozka->kc;  }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( dm >= 803 AND dm <= 804 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r10=$r10+$polozka->kc;  }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND dm = 209";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r12=$r12+$polozka->kc;  }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 1 AND ( dm > 100 AND dm < 599 AND dm != 209 AND dm != 130 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r15=$r15+$polozka->kc;  }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND dm = 130";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r16=$r16+$polozka->kc;  }
$i=$i+1;                   }

//zapis do statistiky

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101s2 SET ".
" m304r2='$r02', m304r4='$r04', m304r3='$r02m12', m304r7='$r07', m304r1='$r01', ".
" m304r5='$r05', m304r8='$r08', ".
" m304r10='$r10', m304r12='$r12', m304r13='$r13', m304r14='$r14', m304r15='$r15', m304r16='$r16', ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");



$vsql = 'DROP TABLE F'.$kli_vxcf.'_statprac';
$vytvor = mysql_query("$vsql");

$copern=102;
$strana=11;
}
//koniec copern=200 nacitaj statistiku z miezd UDAJE Z MIEZD

//zapis upravene udaje
if ( $copern == 103 )
     {
//1.strana
$odoslane = strip_tags($_REQUEST['odoslane']);
$odoslane_sql=SqlDatum($odoslane);
//2.strana
$m592r11 = strip_tags($_REQUEST['m592r11']);
$m592r12 = strip_tags($_REQUEST['m592r12']);
$m592r13 = strip_tags($_REQUEST['m592r13']);
$m592r14 = strip_tags($_REQUEST['m592r14']);
$m592r15 = strip_tags($_REQUEST['m592r15']);
$m592r16 = strip_tags($_REQUEST['m592r16']);
$m592r21 = strip_tags($_REQUEST['m592r21']);
$m592r22 = strip_tags($_REQUEST['m592r22']);
$m592r23 = strip_tags($_REQUEST['m592r23']);
$m592r24 = strip_tags($_REQUEST['m592r24']);
$m592r25 = strip_tags($_REQUEST['m592r25']);
$m592r26 = strip_tags($_REQUEST['m592r26']);
$m592r31 = strip_tags($_REQUEST['m592r31']);
$m592r32 = strip_tags($_REQUEST['m592r32']);
$m592r33 = strip_tags($_REQUEST['m592r33']);
$m592r34 = strip_tags($_REQUEST['m592r34']);
$m592r35 = strip_tags($_REQUEST['m592r35']);
$m592r36 = strip_tags($_REQUEST['m592r36']);
$m592r41 = strip_tags($_REQUEST['m592r41']);
$m592r42 = strip_tags($_REQUEST['m592r42']);
$m592r43 = strip_tags($_REQUEST['m592r43']);
$m592r44 = strip_tags($_REQUEST['m592r44']);
$m592r45 = strip_tags($_REQUEST['m592r45']);
$m592r46 = strip_tags($_REQUEST['m592r46']);
$m592r51 = strip_tags($_REQUEST['m592r51']);
$m592r52 = strip_tags($_REQUEST['m592r52']);
$m592r53 = strip_tags($_REQUEST['m592r53']);
$m592r54 = strip_tags($_REQUEST['m592r54']);
$m592r55 = strip_tags($_REQUEST['m592r55']);
$m592r56 = strip_tags($_REQUEST['m592r56']);
$m592r61 = strip_tags($_REQUEST['m592r61']);
$m592r62 = strip_tags($_REQUEST['m592r62']);
$m592r63 = strip_tags($_REQUEST['m592r63']);
$m592r64 = strip_tags($_REQUEST['m592r64']);
$m592r65 = strip_tags($_REQUEST['m592r65']);
$m592r66 = strip_tags($_REQUEST['m592r66']);
$m592r71 = strip_tags($_REQUEST['m592r71']);
$m592r72 = strip_tags($_REQUEST['m592r72']);
$m592r73 = strip_tags($_REQUEST['m592r73']);
$m592r74 = strip_tags($_REQUEST['m592r74']);
$m592r75 = strip_tags($_REQUEST['m592r75']);
$m592r76 = strip_tags($_REQUEST['m592r76']);
$m592r81 = strip_tags($_REQUEST['m592r81']);
$m592r82 = strip_tags($_REQUEST['m592r82']);
$m592r83 = strip_tags($_REQUEST['m592r83']);
$m592r84 = strip_tags($_REQUEST['m592r84']);
$m592r85 = strip_tags($_REQUEST['m592r85']);
$m592r86 = strip_tags($_REQUEST['m592r86']);
$m592r91 = strip_tags($_REQUEST['m592r91']);
$m592r92 = strip_tags($_REQUEST['m592r92']);
$m592r93 = strip_tags($_REQUEST['m592r93']);
$m592r94 = strip_tags($_REQUEST['m592r94']);
$m592r95 = strip_tags($_REQUEST['m592r95']);
$m592r96 = strip_tags($_REQUEST['m592r96']);
$m592r101 = strip_tags($_REQUEST['m592r101']);
$m592r102 = strip_tags($_REQUEST['m592r102']);
$m592r103 = strip_tags($_REQUEST['m592r103']);
$m592r104 = strip_tags($_REQUEST['m592r104']);
$m592r105 = strip_tags($_REQUEST['m592r105']);
$m592r106 = strip_tags($_REQUEST['m592r106']);
$m592r111 = strip_tags($_REQUEST['m592r111']);
$m592r112 = strip_tags($_REQUEST['m592r112']);
$m592r113 = strip_tags($_REQUEST['m592r113']);
$m592r114 = strip_tags($_REQUEST['m592r114']);
$m592r115 = strip_tags($_REQUEST['m592r115']);
$m592r116 = strip_tags($_REQUEST['m592r116']);
$m592r121 = strip_tags($_REQUEST['m592r121']);
$m592r122 = strip_tags($_REQUEST['m592r122']);
$m592r123 = strip_tags($_REQUEST['m592r123']);
$m592r124 = strip_tags($_REQUEST['m592r124']);
$m592r125 = strip_tags($_REQUEST['m592r125']);
$m592r126 = strip_tags($_REQUEST['m592r126']);
$m592r131 = strip_tags($_REQUEST['m592r131']);
$m592r132 = strip_tags($_REQUEST['m592r132']);
$m592r133 = strip_tags($_REQUEST['m592r133']);
$m592r134 = strip_tags($_REQUEST['m592r134']);
$m592r135 = strip_tags($_REQUEST['m592r135']);
$m592r136 = strip_tags($_REQUEST['m592r136']);
$m592r141 = strip_tags($_REQUEST['m592r141']);
$m592r142 = strip_tags($_REQUEST['m592r142']);
$m592r143 = strip_tags($_REQUEST['m592r143']);
$m592r144 = strip_tags($_REQUEST['m592r144']);
$m592r145 = strip_tags($_REQUEST['m592r145']);
$m592r146 = strip_tags($_REQUEST['m592r146']);
$m592r151 = strip_tags($_REQUEST['m592r151']);
$m592r152 = strip_tags($_REQUEST['m592r152']);
$m592r153 = strip_tags($_REQUEST['m592r153']);
$m592r154 = strip_tags($_REQUEST['m592r154']);
$m592r155 = strip_tags($_REQUEST['m592r155']);
$m592r156 = strip_tags($_REQUEST['m592r156']);
$m592r161 = strip_tags($_REQUEST['m592r161']);
$m592r162 = strip_tags($_REQUEST['m592r162']);
$m592r163 = strip_tags($_REQUEST['m592r163']);
$m592r164 = strip_tags($_REQUEST['m592r164']);
$m592r165 = strip_tags($_REQUEST['m592r165']);
$m592r166 = strip_tags($_REQUEST['m592r166']);
$m592r171 = strip_tags($_REQUEST['m592r171']);
$m592r172 = strip_tags($_REQUEST['m592r172']);
$m592r173 = strip_tags($_REQUEST['m592r173']);
$m592r174 = strip_tags($_REQUEST['m592r174']);
$m592r175 = strip_tags($_REQUEST['m592r175']);
$m592r176 = strip_tags($_REQUEST['m592r176']);
$m592r181 = strip_tags($_REQUEST['m592r181']);
$m592r182 = strip_tags($_REQUEST['m592r182']);
$m592r183 = strip_tags($_REQUEST['m592r183']);
$m592r184 = strip_tags($_REQUEST['m592r184']);
$m592r185 = strip_tags($_REQUEST['m592r185']);
$m592r186 = strip_tags($_REQUEST['m592r186']);
$m592r191 = strip_tags($_REQUEST['m592r191']);
$m592r192 = strip_tags($_REQUEST['m592r192']);
$m592r193 = strip_tags($_REQUEST['m592r193']);
$m592r194 = strip_tags($_REQUEST['m592r194']);
$m592r195 = strip_tags($_REQUEST['m592r195']);
$m592r196 = strip_tags($_REQUEST['m592r196']);
$m592r201 = strip_tags($_REQUEST['m592r201']);
$m592r202 = strip_tags($_REQUEST['m592r202']);
$m592r203 = strip_tags($_REQUEST['m592r203']);
$m592r204 = strip_tags($_REQUEST['m592r204']);
$m592r205 = strip_tags($_REQUEST['m592r205']);
$m592r206 = strip_tags($_REQUEST['m592r206']);
$m592r211 = strip_tags($_REQUEST['m592r211']);
$m592r212 = strip_tags($_REQUEST['m592r212']);
$m592r213 = strip_tags($_REQUEST['m592r213']);
$m592r214 = strip_tags($_REQUEST['m592r214']);
$m592r215 = strip_tags($_REQUEST['m592r215']);
$m592r216 = strip_tags($_REQUEST['m592r216']);
$m592r221 = strip_tags($_REQUEST['m592r221']);
$m592r222 = strip_tags($_REQUEST['m592r222']);
$m592r223 = strip_tags($_REQUEST['m592r223']);
$m592r224 = strip_tags($_REQUEST['m592r224']);
$m592r225 = strip_tags($_REQUEST['m592r225']);
$m592r226 = strip_tags($_REQUEST['m592r226']);
$m592r231 = strip_tags($_REQUEST['m592r231']);
$m592r232 = strip_tags($_REQUEST['m592r232']);
$m592r233 = strip_tags($_REQUEST['m592r233']);
$m592r234 = strip_tags($_REQUEST['m592r234']);
$m592r235 = strip_tags($_REQUEST['m592r235']);
$m592r236 = strip_tags($_REQUEST['m592r236']);
$m592r241 = strip_tags($_REQUEST['m592r241']);
$m592r242 = strip_tags($_REQUEST['m592r242']);
$m592r243 = strip_tags($_REQUEST['m592r243']);
$m592r244 = strip_tags($_REQUEST['m592r244']);
$m592r245 = strip_tags($_REQUEST['m592r245']);
$m592r246 = strip_tags($_REQUEST['m592r246']);
$m592r251 = strip_tags($_REQUEST['m592r251']);
$m592r252 = strip_tags($_REQUEST['m592r252']);
$m592r253 = strip_tags($_REQUEST['m592r253']);
$m592r254 = strip_tags($_REQUEST['m592r254']);
$m592r255 = strip_tags($_REQUEST['m592r255']);
$m592r256 = strip_tags($_REQUEST['m592r256']);
$m592r992 = strip_tags($_REQUEST['m592r992']);
$m592r993 = strip_tags($_REQUEST['m592r993']);
$m592r994 = strip_tags($_REQUEST['m592r994']);
$m592r995 = strip_tags($_REQUEST['m592r995']);
$m592r996 = strip_tags($_REQUEST['m592r996']);
//3.strana
$m177r1 = strip_tags($_REQUEST['m177r1']);
$m177r2 = strip_tags($_REQUEST['m177r2']);
$m177r3 = strip_tags($_REQUEST['m177r3']);
$m177r4 = strip_tags($_REQUEST['m177r4']);
$m177r5 = strip_tags($_REQUEST['m177r5']);
$m177r6 = strip_tags($_REQUEST['m177r6']);
$m177r7 = strip_tags($_REQUEST['m177r7']);
$m177r8 = strip_tags($_REQUEST['m177r8']);
$m177r9 = strip_tags($_REQUEST['m177r9']);
$m177r10 = strip_tags($_REQUEST['m177r10']);
$m177r99 = strip_tags($_REQUEST['m177r99']);
$m178r1 = strip_tags($_REQUEST['m178r1']);
$m178r2 = strip_tags($_REQUEST['m178r2']);
$m178r3 = strip_tags($_REQUEST['m178r3']);
$m178r4 = strip_tags($_REQUEST['m178r4']);
$m178r5 = strip_tags($_REQUEST['m178r5']);
$m178r6 = strip_tags($_REQUEST['m178r6']);
$m178r7 = strip_tags($_REQUEST['m178r7']);
$m178r8 = strip_tags($_REQUEST['m178r8']);
$m178r9 = strip_tags($_REQUEST['m178r9']);
$m178r10 = strip_tags($_REQUEST['m178r10']);
$m178r11 = strip_tags($_REQUEST['m178r11']);
$m178r12 = strip_tags($_REQUEST['m178r12']);
$m178r13 = strip_tags($_REQUEST['m178r13']);
$m178r14 = strip_tags($_REQUEST['m178r14']);
$m178r15 = strip_tags($_REQUEST['m178r15']);
$m178r16 = strip_tags($_REQUEST['m178r16']);
$m178r17 = strip_tags($_REQUEST['m178r17']);
$m178r18 = strip_tags($_REQUEST['m178r18']);
$m178r19 = strip_tags($_REQUEST['m178r19']);
$m178r99 = strip_tags($_REQUEST['m178r99']);
//4.strana
$m179r1 = strip_tags($_REQUEST['m179r1']);
$m179r2 = strip_tags($_REQUEST['m179r2']);
$m179r3 = strip_tags($_REQUEST['m179r3']);
$m179r4 = strip_tags($_REQUEST['m179r4']);
$m179r5 = strip_tags($_REQUEST['m179r5']);
$m179r6 = strip_tags($_REQUEST['m179r6']);
$m179r7 = strip_tags($_REQUEST['m179r7']);
$m179r8 = strip_tags($_REQUEST['m179r8']);
$m179r9 = strip_tags($_REQUEST['m179r9']);
$m179r99 = strip_tags($_REQUEST['m179r99']);
//5.strana
$m182r11 = strip_tags($_REQUEST['m182r11']);
$m182r12 = strip_tags($_REQUEST['m182r12']);
$m182r13 = strip_tags($_REQUEST['m182r13']);
$m182r14 = strip_tags($_REQUEST['m182r14']);
$m182r15 = strip_tags($_REQUEST['m182r15']);
$m182r16 = strip_tags($_REQUEST['m182r16']);
$m182r17 = strip_tags($_REQUEST['m182r17']);
$m182r21 = strip_tags($_REQUEST['m182r21']);
$m182r22 = strip_tags($_REQUEST['m182r22']);
$m182r23 = strip_tags($_REQUEST['m182r23']);
$m182r24 = strip_tags($_REQUEST['m182r24']);
$m182r25 = strip_tags($_REQUEST['m182r25']);
$m182r26 = strip_tags($_REQUEST['m182r26']);
$m182r27 = strip_tags($_REQUEST['m182r27']);
$m182r31 = strip_tags($_REQUEST['m182r31']);
$m182r32 = strip_tags($_REQUEST['m182r32']);
$m182r33 = strip_tags($_REQUEST['m182r33']);
$m182r34 = strip_tags($_REQUEST['m182r34']);
$m182r35 = strip_tags($_REQUEST['m182r35']);
$m182r36 = strip_tags($_REQUEST['m182r36']);
$m182r37 = strip_tags($_REQUEST['m182r37']);
$m182r41 = strip_tags($_REQUEST['m182r41']);
$m182r42 = strip_tags($_REQUEST['m182r42']);
$m182r43 = strip_tags($_REQUEST['m182r43']);
$m182r44 = strip_tags($_REQUEST['m182r44']);
$m182r45 = strip_tags($_REQUEST['m182r45']);
$m182r46 = strip_tags($_REQUEST['m182r46']);
$m182r47 = strip_tags($_REQUEST['m182r47']);
$m182r51 = strip_tags($_REQUEST['m182r51']);
$m182r52 = strip_tags($_REQUEST['m182r52']);
$m182r53 = strip_tags($_REQUEST['m182r53']);
$m182r54 = strip_tags($_REQUEST['m182r54']);
$m182r55 = strip_tags($_REQUEST['m182r55']);
$m182r56 = strip_tags($_REQUEST['m182r56']);
$m182r57 = strip_tags($_REQUEST['m182r57']);
$m182r61 = strip_tags($_REQUEST['m182r61']);
$m182r62 = strip_tags($_REQUEST['m182r62']);
$m182r63 = strip_tags($_REQUEST['m182r63']);
$m182r64 = strip_tags($_REQUEST['m182r64']);
$m182r65 = strip_tags($_REQUEST['m182r65']);
$m182r66 = strip_tags($_REQUEST['m182r66']);
$m182r67 = strip_tags($_REQUEST['m182r67']);
$m182r71 = strip_tags($_REQUEST['m182r71']);
$m182r72 = strip_tags($_REQUEST['m182r72']);
$m182r73 = strip_tags($_REQUEST['m182r73']);
$m182r74 = strip_tags($_REQUEST['m182r74']);
$m182r75 = strip_tags($_REQUEST['m182r75']);
$m182r76 = strip_tags($_REQUEST['m182r76']);
$m182r77 = strip_tags($_REQUEST['m182r77']);
$m182r81 = strip_tags($_REQUEST['m182r81']);
$m182r82 = strip_tags($_REQUEST['m182r82']);
$m182r83 = strip_tags($_REQUEST['m182r83']);
$m182r84 = strip_tags($_REQUEST['m182r84']);
$m182r85 = strip_tags($_REQUEST['m182r85']);
$m182r86 = strip_tags($_REQUEST['m182r86']);
$m182r87 = strip_tags($_REQUEST['m182r87']);
$m182r91 = strip_tags($_REQUEST['m182r91']);
$m182r92 = strip_tags($_REQUEST['m182r92']);
$m182r93 = strip_tags($_REQUEST['m182r93']);
$m182r94 = strip_tags($_REQUEST['m182r94']);
$m182r95 = strip_tags($_REQUEST['m182r95']);
$m182r96 = strip_tags($_REQUEST['m182r96']);
$m182r97 = strip_tags($_REQUEST['m182r97']);
$m182r101 = strip_tags($_REQUEST['m182r101']);
$m182r102 = strip_tags($_REQUEST['m182r102']);
$m182r103 = strip_tags($_REQUEST['m182r103']);
$m182r104 = strip_tags($_REQUEST['m182r104']);
$m182r105 = strip_tags($_REQUEST['m182r105']);
$m182r106 = strip_tags($_REQUEST['m182r106']);
$m182r107 = strip_tags($_REQUEST['m182r107']);
$m182r111 = strip_tags($_REQUEST['m182r111']);
$m182r112 = strip_tags($_REQUEST['m182r112']);
$m182r113 = strip_tags($_REQUEST['m182r113']);
$m182r114 = strip_tags($_REQUEST['m182r114']);
$m182r115 = strip_tags($_REQUEST['m182r115']);
$m182r116 = strip_tags($_REQUEST['m182r116']);
$m182r117 = strip_tags($_REQUEST['m182r117']);
$m182r121 = strip_tags($_REQUEST['m182r121']);
$m182r122 = strip_tags($_REQUEST['m182r122']);
$m182r123 = strip_tags($_REQUEST['m182r123']);
$m182r124 = strip_tags($_REQUEST['m182r124']);
$m182r125 = strip_tags($_REQUEST['m182r125']);
$m182r126 = strip_tags($_REQUEST['m182r126']);
$m182r127 = strip_tags($_REQUEST['m182r127']);
$m182r131 = strip_tags($_REQUEST['m182r131']);
$m182r132 = strip_tags($_REQUEST['m182r132']);
$m182r133 = strip_tags($_REQUEST['m182r133']);
$m182r134 = strip_tags($_REQUEST['m182r134']);
$m182r135 = strip_tags($_REQUEST['m182r135']);
$m182r136 = strip_tags($_REQUEST['m182r136']);
$m182r137 = strip_tags($_REQUEST['m182r137']);
$m182r141 = strip_tags($_REQUEST['m182r141']);
$m182r142 = strip_tags($_REQUEST['m182r142']);
$m182r143 = strip_tags($_REQUEST['m182r143']);
$m182r144 = strip_tags($_REQUEST['m182r144']);
$m182r145 = strip_tags($_REQUEST['m182r145']);
$m182r146 = strip_tags($_REQUEST['m182r146']);
$m182r147 = strip_tags($_REQUEST['m182r147']);
$m182r151 = strip_tags($_REQUEST['m182r151']);
$m182r152 = strip_tags($_REQUEST['m182r152']);
$m182r153 = strip_tags($_REQUEST['m182r153']);
$m182r154 = strip_tags($_REQUEST['m182r154']);
$m182r155 = strip_tags($_REQUEST['m182r155']);
$m182r156 = strip_tags($_REQUEST['m182r156']);
$m182r157 = strip_tags($_REQUEST['m182r157']);
$m182r161 = strip_tags($_REQUEST['m182r161']);
$m182r162 = strip_tags($_REQUEST['m182r162']);
$m182r163 = strip_tags($_REQUEST['m182r163']);
$m182r164 = strip_tags($_REQUEST['m182r164']);
$m182r165 = strip_tags($_REQUEST['m182r165']);
$m182r166 = strip_tags($_REQUEST['m182r166']);
$m182r167 = strip_tags($_REQUEST['m182r167']);
$m182r171 = strip_tags($_REQUEST['m182r171']);
$m182r172 = strip_tags($_REQUEST['m182r172']);
$m182r173 = strip_tags($_REQUEST['m182r173']);
$m182r174 = strip_tags($_REQUEST['m182r174']);
$m182r175 = strip_tags($_REQUEST['m182r175']);
$m182r176 = strip_tags($_REQUEST['m182r176']);
$m182r177 = strip_tags($_REQUEST['m182r177']);
$m182r181 = strip_tags($_REQUEST['m182r181']);
$m182r182 = strip_tags($_REQUEST['m182r182']);
$m182r183 = strip_tags($_REQUEST['m182r183']);
$m182r184 = strip_tags($_REQUEST['m182r184']);
$m182r185 = strip_tags($_REQUEST['m182r185']);
$m182r186 = strip_tags($_REQUEST['m182r186']);
$m182r187 = strip_tags($_REQUEST['m182r187']);
$m182r191 = strip_tags($_REQUEST['m182r191']);
$m182r192 = strip_tags($_REQUEST['m182r192']);
$m182r193 = strip_tags($_REQUEST['m182r193']);
$m182r194 = strip_tags($_REQUEST['m182r194']);
$m182r195 = strip_tags($_REQUEST['m182r195']);
$m182r196 = strip_tags($_REQUEST['m182r196']);
$m182r197 = strip_tags($_REQUEST['m182r197']);
$m182r201 = strip_tags($_REQUEST['m182r201']);
$m182r202 = strip_tags($_REQUEST['m182r202']);
$m182r203 = strip_tags($_REQUEST['m182r203']);
$m182r204 = strip_tags($_REQUEST['m182r204']);
$m182r205 = strip_tags($_REQUEST['m182r205']);
$m182r206 = strip_tags($_REQUEST['m182r206']);
$m182r207 = strip_tags($_REQUEST['m182r207']);
$m182r211 = strip_tags($_REQUEST['m182r211']);
$m182r212 = strip_tags($_REQUEST['m182r212']);
$m182r213 = strip_tags($_REQUEST['m182r213']);
$m182r214 = strip_tags($_REQUEST['m182r214']);
$m182r215 = strip_tags($_REQUEST['m182r215']);
$m182r216 = strip_tags($_REQUEST['m182r216']);
$m182r217 = strip_tags($_REQUEST['m182r217']);
$m182r221 = strip_tags($_REQUEST['m182r221']);
$m182r222 = strip_tags($_REQUEST['m182r222']);
$m182r223 = strip_tags($_REQUEST['m182r223']);
$m182r224 = strip_tags($_REQUEST['m182r224']);
$m182r225 = strip_tags($_REQUEST['m182r225']);
$m182r226 = strip_tags($_REQUEST['m182r226']);
$m182r227 = strip_tags($_REQUEST['m182r227']);
$m182r231 = strip_tags($_REQUEST['m182r231']);
$m182r232 = strip_tags($_REQUEST['m182r232']);
$m182r233 = strip_tags($_REQUEST['m182r233']);
$m182r234 = strip_tags($_REQUEST['m182r234']);
$m182r235 = strip_tags($_REQUEST['m182r235']);
$m182r236 = strip_tags($_REQUEST['m182r236']);
$m182r237 = strip_tags($_REQUEST['m182r237']);
$m182r241 = strip_tags($_REQUEST['m182r241']);
$m182r242 = strip_tags($_REQUEST['m182r242']);
$m182r243 = strip_tags($_REQUEST['m182r243']);
$m182r244 = strip_tags($_REQUEST['m182r244']);
$m182r245 = strip_tags($_REQUEST['m182r245']);
$m182r246 = strip_tags($_REQUEST['m182r246']);
$m182r247 = strip_tags($_REQUEST['m182r247']);
$m182r251 = strip_tags($_REQUEST['m182r251']);
$m182r252 = strip_tags($_REQUEST['m182r252']);
$m182r253 = strip_tags($_REQUEST['m182r253']);
$m182r254 = strip_tags($_REQUEST['m182r254']);
$m182r255 = strip_tags($_REQUEST['m182r255']);
$m182r256 = strip_tags($_REQUEST['m182r256']);
$m182r257 = strip_tags($_REQUEST['m182r257']);
$m182r261 = strip_tags($_REQUEST['m182r261']);
$m182r262 = strip_tags($_REQUEST['m182r262']);
$m182r263 = strip_tags($_REQUEST['m182r263']);
$m182r264 = strip_tags($_REQUEST['m182r264']);
$m182r265 = strip_tags($_REQUEST['m182r265']);
$m182r266 = strip_tags($_REQUEST['m182r266']);
$m182r267 = strip_tags($_REQUEST['m182r267']);
$m182r271 = strip_tags($_REQUEST['m182r271']);
$m182r272 = strip_tags($_REQUEST['m182r272']);
$m182r273 = strip_tags($_REQUEST['m182r273']);
$m182r274 = strip_tags($_REQUEST['m182r274']);
$m182r275 = strip_tags($_REQUEST['m182r275']);
$m182r276 = strip_tags($_REQUEST['m182r276']);
$m182r277 = strip_tags($_REQUEST['m182r277']);
$m182r281 = strip_tags($_REQUEST['m182r281']);
$m182r282 = strip_tags($_REQUEST['m182r282']);
$m182r283 = strip_tags($_REQUEST['m182r283']);
$m182r284 = strip_tags($_REQUEST['m182r284']);
$m182r285 = strip_tags($_REQUEST['m182r285']);
$m182r286 = strip_tags($_REQUEST['m182r286']);
$m182r287 = strip_tags($_REQUEST['m182r287']);
$m182r291 = strip_tags($_REQUEST['m182r291']);
$m182r292 = strip_tags($_REQUEST['m182r292']);
$m182r293 = strip_tags($_REQUEST['m182r293']);
$m182r294 = strip_tags($_REQUEST['m182r294']);
$m182r295 = strip_tags($_REQUEST['m182r295']);
$m182r296 = strip_tags($_REQUEST['m182r296']);
$m182r297 = strip_tags($_REQUEST['m182r297']);
$m182r301 = strip_tags($_REQUEST['m182r301']);
$m182r302 = strip_tags($_REQUEST['m182r302']);
$m182r303 = strip_tags($_REQUEST['m182r303']);
$m182r304 = strip_tags($_REQUEST['m182r304']);
$m182r305 = strip_tags($_REQUEST['m182r305']);
$m182r306 = strip_tags($_REQUEST['m182r306']);
$m182r307 = strip_tags($_REQUEST['m182r307']);
$m182r311 = strip_tags($_REQUEST['m182r311']);
$m182r312 = strip_tags($_REQUEST['m182r312']);
$m182r313 = strip_tags($_REQUEST['m182r313']);
$m182r314 = strip_tags($_REQUEST['m182r314']);
$m182r315 = strip_tags($_REQUEST['m182r315']);
$m182r316 = strip_tags($_REQUEST['m182r316']);
$m182r317 = strip_tags($_REQUEST['m182r317']);
$m182r321 = strip_tags($_REQUEST['m182r321']);
$m182r322 = strip_tags($_REQUEST['m182r322']);
$m182r323 = strip_tags($_REQUEST['m182r323']);
$m182r324 = strip_tags($_REQUEST['m182r324']);
$m182r325 = strip_tags($_REQUEST['m182r325']);
$m182r326 = strip_tags($_REQUEST['m182r326']);
$m182r327 = strip_tags($_REQUEST['m182r327']);
$m182r331 = strip_tags($_REQUEST['m182r331']);
$m182r332 = strip_tags($_REQUEST['m182r332']);
$m182r333 = strip_tags($_REQUEST['m182r333']);
$m182r334 = strip_tags($_REQUEST['m182r334']);
$m182r335 = strip_tags($_REQUEST['m182r335']);
$m182r336 = strip_tags($_REQUEST['m182r336']);
$m182r337 = strip_tags($_REQUEST['m182r337']);
$m182r992 = strip_tags($_REQUEST['m182r992']);
$m182r993 = strip_tags($_REQUEST['m182r993']);
$m182r994 = strip_tags($_REQUEST['m182r994']);
$m182r995 = strip_tags($_REQUEST['m182r995']);
$m182r996 = strip_tags($_REQUEST['m182r996']);
$m182r997 = strip_tags($_REQUEST['m182r997']);
//6.strana
$m183r11 = strip_tags($_REQUEST['m183r11']);
$m183r12 = strip_tags($_REQUEST['m183r12']);
$m183r13 = strip_tags($_REQUEST['m183r13']);
$m183r14 = strip_tags($_REQUEST['m183r14']);
$m183r21 = strip_tags($_REQUEST['m183r21']);
$m183r22 = strip_tags($_REQUEST['m183r22']);
$m183r23 = strip_tags($_REQUEST['m183r23']);
$m183r24 = strip_tags($_REQUEST['m183r24']);
$m183r31 = strip_tags($_REQUEST['m183r31']);
$m183r32 = strip_tags($_REQUEST['m183r32']);
$m183r33 = strip_tags($_REQUEST['m183r33']);
$m183r34 = strip_tags($_REQUEST['m183r34']);
$m183r41 = strip_tags($_REQUEST['m183r41']);
$m183r42 = strip_tags($_REQUEST['m183r42']);
$m183r43 = strip_tags($_REQUEST['m183r43']);
$m183r44 = strip_tags($_REQUEST['m183r44']);
$m183r51 = strip_tags($_REQUEST['m183r51']);
$m183r52 = strip_tags($_REQUEST['m183r52']);
$m183r53 = strip_tags($_REQUEST['m183r53']);
$m183r54 = strip_tags($_REQUEST['m183r54']);
$m183r61 = strip_tags($_REQUEST['m183r61']);
$m183r62 = strip_tags($_REQUEST['m183r62']);
$m183r63 = strip_tags($_REQUEST['m183r63']);
$m183r64 = strip_tags($_REQUEST['m183r64']);
$m183r71 = strip_tags($_REQUEST['m183r71']);
$m183r72 = strip_tags($_REQUEST['m183r72']);
$m183r73 = strip_tags($_REQUEST['m183r73']);
$m183r74 = strip_tags($_REQUEST['m183r74']);
$m183r81 = strip_tags($_REQUEST['m183r81']);
$m183r82 = strip_tags($_REQUEST['m183r82']);
$m183r83 = strip_tags($_REQUEST['m183r83']);
$m183r84 = strip_tags($_REQUEST['m183r84']);
$m183r91 = strip_tags($_REQUEST['m183r91']);
$m183r92 = strip_tags($_REQUEST['m183r92']);
$m183r93 = strip_tags($_REQUEST['m183r93']);
$m183r94 = strip_tags($_REQUEST['m183r94']);
$m183r101 = strip_tags($_REQUEST['m183r101']);
$m183r102 = strip_tags($_REQUEST['m183r102']);
$m183r103 = strip_tags($_REQUEST['m183r103']);
$m183r104 = strip_tags($_REQUEST['m183r104']);
$m183r111 = strip_tags($_REQUEST['m183r111']);
$m183r112 = strip_tags($_REQUEST['m183r112']);
$m183r113 = strip_tags($_REQUEST['m183r113']);
$m183r114 = strip_tags($_REQUEST['m183r114']);
$m183r121 = strip_tags($_REQUEST['m183r121']);
$m183r122 = strip_tags($_REQUEST['m183r122']);
$m183r123 = strip_tags($_REQUEST['m183r123']);
$m183r124 = strip_tags($_REQUEST['m183r124']);
$m183r131 = strip_tags($_REQUEST['m183r131']);
$m183r132 = strip_tags($_REQUEST['m183r132']);
$m183r133 = strip_tags($_REQUEST['m183r133']);
$m183r134 = strip_tags($_REQUEST['m183r134']);
$m183r141 = strip_tags($_REQUEST['m183r141']);
$m183r142 = strip_tags($_REQUEST['m183r142']);
$m183r143 = strip_tags($_REQUEST['m183r143']);
$m183r144 = strip_tags($_REQUEST['m183r144']);
$m183r151 = strip_tags($_REQUEST['m183r151']);
$m183r152 = strip_tags($_REQUEST['m183r152']);
$m183r153 = strip_tags($_REQUEST['m183r153']);
$m183r154 = strip_tags($_REQUEST['m183r154']);
$m183r161 = strip_tags($_REQUEST['m183r161']);
$m183r162 = strip_tags($_REQUEST['m183r162']);
$m183r163 = strip_tags($_REQUEST['m183r163']);
$m183r164 = strip_tags($_REQUEST['m183r164']);
$m183r171 = strip_tags($_REQUEST['m183r171']);
$m183r172 = strip_tags($_REQUEST['m183r172']);
$m183r173 = strip_tags($_REQUEST['m183r173']);
$m183r174 = strip_tags($_REQUEST['m183r174']);
$m183r181 = strip_tags($_REQUEST['m183r181']);
$m183r182 = strip_tags($_REQUEST['m183r182']);
$m183r183 = strip_tags($_REQUEST['m183r183']);
$m183r184 = strip_tags($_REQUEST['m183r184']);
$m183r191 = strip_tags($_REQUEST['m183r191']);
$m183r192 = strip_tags($_REQUEST['m183r192']);
$m183r193 = strip_tags($_REQUEST['m183r193']);
$m183r194 = strip_tags($_REQUEST['m183r194']);
$m183r201 = strip_tags($_REQUEST['m183r201']);
$m183r202 = strip_tags($_REQUEST['m183r202']);
$m183r203 = strip_tags($_REQUEST['m183r203']);
$m183r204 = strip_tags($_REQUEST['m183r204']);
$m183r211 = strip_tags($_REQUEST['m183r211']);
$m183r212 = strip_tags($_REQUEST['m183r212']);
$m183r213 = strip_tags($_REQUEST['m183r213']);
$m183r214 = strip_tags($_REQUEST['m183r214']);
$m183r221 = strip_tags($_REQUEST['m183r221']);
$m183r222 = strip_tags($_REQUEST['m183r222']);
$m183r223 = strip_tags($_REQUEST['m183r223']);
$m183r224 = strip_tags($_REQUEST['m183r224']);
$m183r231 = strip_tags($_REQUEST['m183r231']);
$m183r232 = strip_tags($_REQUEST['m183r232']);
$m183r233 = strip_tags($_REQUEST['m183r233']);
$m183r234 = strip_tags($_REQUEST['m183r234']);
$m183r241 = strip_tags($_REQUEST['m183r241']);
$m183r242 = strip_tags($_REQUEST['m183r242']);
$m183r243 = strip_tags($_REQUEST['m183r243']);
$m183r244 = strip_tags($_REQUEST['m183r244']);
$m183r251 = strip_tags($_REQUEST['m183r251']);
$m183r252 = strip_tags($_REQUEST['m183r252']);
$m183r253 = strip_tags($_REQUEST['m183r253']);
$m183r254 = strip_tags($_REQUEST['m183r254']);
$m183r261 = strip_tags($_REQUEST['m183r261']);
$m183r262 = strip_tags($_REQUEST['m183r262']);
$m183r263 = strip_tags($_REQUEST['m183r263']);
$m183r264 = strip_tags($_REQUEST['m183r264']);
$m183r271 = strip_tags($_REQUEST['m183r271']);
$m183r272 = strip_tags($_REQUEST['m183r272']);
$m183r273 = strip_tags($_REQUEST['m183r273']);
$m183r274 = strip_tags($_REQUEST['m183r274']);
$m183r281 = strip_tags($_REQUEST['m183r281']);
$m183r282 = strip_tags($_REQUEST['m183r282']);
$m183r283 = strip_tags($_REQUEST['m183r283']);
$m183r284 = strip_tags($_REQUEST['m183r284']);
$m183r291 = strip_tags($_REQUEST['m183r291']);
$m183r292 = strip_tags($_REQUEST['m183r292']);
$m183r293 = strip_tags($_REQUEST['m183r293']);
$m183r294 = strip_tags($_REQUEST['m183r294']);
$m183r301 = strip_tags($_REQUEST['m183r301']);
$m183r302 = strip_tags($_REQUEST['m183r302']);
$m183r303 = strip_tags($_REQUEST['m183r303']);
$m183r304 = strip_tags($_REQUEST['m183r304']);
$m183r992 = strip_tags($_REQUEST['m183r992']);
$m183r993 = strip_tags($_REQUEST['m183r993']);
$m183r994 = strip_tags($_REQUEST['m183r994']);
//7.strana
$m184r11 = strip_tags($_REQUEST['m184r11']);
$m184r12 = strip_tags($_REQUEST['m184r12']);
$m184r13 = strip_tags($_REQUEST['m184r13']);
$m184r14 = strip_tags($_REQUEST['m184r14']);
$m184r15 = strip_tags($_REQUEST['m184r15']);
$m184r16 = strip_tags($_REQUEST['m184r16']);
$m184r21 = strip_tags($_REQUEST['m184r21']);
$m184r22 = strip_tags($_REQUEST['m184r22']);
$m184r23 = strip_tags($_REQUEST['m184r23']);
$m184r24 = strip_tags($_REQUEST['m184r24']);
$m184r25 = strip_tags($_REQUEST['m184r25']);
$m184r26 = strip_tags($_REQUEST['m184r26']);
$m184r31 = strip_tags($_REQUEST['m184r31']);
$m184r32 = strip_tags($_REQUEST['m184r32']);
$m184r33 = strip_tags($_REQUEST['m184r33']);
$m184r34 = strip_tags($_REQUEST['m184r34']);
$m184r35 = strip_tags($_REQUEST['m184r35']);
$m184r36 = strip_tags($_REQUEST['m184r36']);
$m184r41 = strip_tags($_REQUEST['m184r41']);
$m184r42 = strip_tags($_REQUEST['m184r42']);
$m184r43 = strip_tags($_REQUEST['m184r43']);
$m184r44 = strip_tags($_REQUEST['m184r44']);
$m184r45 = strip_tags($_REQUEST['m184r45']);
$m184r46 = strip_tags($_REQUEST['m184r46']);
$m184r51 = strip_tags($_REQUEST['m184r51']);
$m184r52 = strip_tags($_REQUEST['m184r52']);
$m184r53 = strip_tags($_REQUEST['m184r53']);
$m184r54 = strip_tags($_REQUEST['m184r54']);
$m184r55 = strip_tags($_REQUEST['m184r55']);
$m184r56 = strip_tags($_REQUEST['m184r56']);
$m184r61 = strip_tags($_REQUEST['m184r61']);
$m184r62 = strip_tags($_REQUEST['m184r62']);
$m184r63 = strip_tags($_REQUEST['m184r63']);
$m184r64 = strip_tags($_REQUEST['m184r64']);
$m184r65 = strip_tags($_REQUEST['m184r65']);
$m184r66 = strip_tags($_REQUEST['m184r66']);
$m184r71 = strip_tags($_REQUEST['m184r71']);
$m184r72 = strip_tags($_REQUEST['m184r72']);
$m184r73 = strip_tags($_REQUEST['m184r73']);
$m184r74 = strip_tags($_REQUEST['m184r74']);
$m184r75 = strip_tags($_REQUEST['m184r75']);
$m184r76 = strip_tags($_REQUEST['m184r76']);
$m184r81 = strip_tags($_REQUEST['m184r81']);
$m184r82 = strip_tags($_REQUEST['m184r82']);
$m184r83 = strip_tags($_REQUEST['m184r83']);
$m184r84 = strip_tags($_REQUEST['m184r84']);
$m184r85 = strip_tags($_REQUEST['m184r85']);
$m184r86 = strip_tags($_REQUEST['m184r86']);
$m184r91 = strip_tags($_REQUEST['m184r91']);
$m184r92 = strip_tags($_REQUEST['m184r92']);
$m184r93 = strip_tags($_REQUEST['m184r93']);
$m184r94 = strip_tags($_REQUEST['m184r94']);
$m184r95 = strip_tags($_REQUEST['m184r95']);
$m184r96 = strip_tags($_REQUEST['m184r96']);
$m184r101 = strip_tags($_REQUEST['m184r101']);
$m184r102 = strip_tags($_REQUEST['m184r102']);
$m184r103 = strip_tags($_REQUEST['m184r103']);
$m184r104 = strip_tags($_REQUEST['m184r104']);
$m184r105 = strip_tags($_REQUEST['m184r105']);
$m184r106 = strip_tags($_REQUEST['m184r106']);
$m184r111 = strip_tags($_REQUEST['m184r111']);
$m184r112 = strip_tags($_REQUEST['m184r112']);
$m184r113 = strip_tags($_REQUEST['m184r113']);
$m184r114 = strip_tags($_REQUEST['m184r114']);
$m184r115 = strip_tags($_REQUEST['m184r115']);
$m184r116 = strip_tags($_REQUEST['m184r116']);
$m184r121 = strip_tags($_REQUEST['m184r121']);
$m184r122 = strip_tags($_REQUEST['m184r122']);
$m184r123 = strip_tags($_REQUEST['m184r123']);
$m184r124 = strip_tags($_REQUEST['m184r124']);
$m184r125 = strip_tags($_REQUEST['m184r125']);
$m184r126 = strip_tags($_REQUEST['m184r126']);
$m184r131 = strip_tags($_REQUEST['m184r131']);
$m184r132 = strip_tags($_REQUEST['m184r132']);
$m184r133 = strip_tags($_REQUEST['m184r133']);
$m184r134 = strip_tags($_REQUEST['m184r134']);
$m184r135 = strip_tags($_REQUEST['m184r135']);
$m184r136 = strip_tags($_REQUEST['m184r136']);
$m184r141 = strip_tags($_REQUEST['m184r141']);
$m184r142 = strip_tags($_REQUEST['m184r142']);
$m184r143 = strip_tags($_REQUEST['m184r143']);
$m184r144 = strip_tags($_REQUEST['m184r144']);
$m184r145 = strip_tags($_REQUEST['m184r145']);
$m184r146 = strip_tags($_REQUEST['m184r146']);
$m184r151 = strip_tags($_REQUEST['m184r151']);
$m184r152 = strip_tags($_REQUEST['m184r152']);
$m184r153 = strip_tags($_REQUEST['m184r153']);
$m184r154 = strip_tags($_REQUEST['m184r154']);
$m184r155 = strip_tags($_REQUEST['m184r155']);
$m184r156 = strip_tags($_REQUEST['m184r156']);
$m184r161 = strip_tags($_REQUEST['m184r161']);
$m184r162 = strip_tags($_REQUEST['m184r162']);
$m184r163 = strip_tags($_REQUEST['m184r163']);
$m184r164 = strip_tags($_REQUEST['m184r164']);
$m184r165 = strip_tags($_REQUEST['m184r165']);
$m184r166 = strip_tags($_REQUEST['m184r166']);
$m184r171 = strip_tags($_REQUEST['m184r171']);
$m184r172 = strip_tags($_REQUEST['m184r172']);
$m184r173 = strip_tags($_REQUEST['m184r173']);
$m184r174 = strip_tags($_REQUEST['m184r174']);
$m184r175 = strip_tags($_REQUEST['m184r175']);
$m184r176 = strip_tags($_REQUEST['m184r176']);
$m184r181 = strip_tags($_REQUEST['m184r181']);
$m184r182 = strip_tags($_REQUEST['m184r182']);
$m184r183 = strip_tags($_REQUEST['m184r183']);
$m184r184 = strip_tags($_REQUEST['m184r184']);
$m184r185 = strip_tags($_REQUEST['m184r185']);
$m184r186 = strip_tags($_REQUEST['m184r186']);
$m184r191 = strip_tags($_REQUEST['m184r191']);
$m184r192 = strip_tags($_REQUEST['m184r192']);
$m184r193 = strip_tags($_REQUEST['m184r193']);
$m184r194 = strip_tags($_REQUEST['m184r194']);
$m184r195 = strip_tags($_REQUEST['m184r195']);
$m184r196 = strip_tags($_REQUEST['m184r196']);
$m184r201 = strip_tags($_REQUEST['m184r201']);
$m184r202 = strip_tags($_REQUEST['m184r202']);
$m184r203 = strip_tags($_REQUEST['m184r203']);
$m184r204 = strip_tags($_REQUEST['m184r204']);
$m184r205 = strip_tags($_REQUEST['m184r205']);
$m184r206 = strip_tags($_REQUEST['m184r206']);
$m184r211 = strip_tags($_REQUEST['m184r211']);
$m184r212 = strip_tags($_REQUEST['m184r212']);
$m184r213 = strip_tags($_REQUEST['m184r213']);
$m184r214 = strip_tags($_REQUEST['m184r214']);
$m184r215 = strip_tags($_REQUEST['m184r215']);
$m184r216 = strip_tags($_REQUEST['m184r216']);
$m184r221 = strip_tags($_REQUEST['m184r221']);
$m184r222 = strip_tags($_REQUEST['m184r222']);
$m184r223 = strip_tags($_REQUEST['m184r223']);
$m184r224 = strip_tags($_REQUEST['m184r224']);
$m184r225 = strip_tags($_REQUEST['m184r225']);
$m184r226 = strip_tags($_REQUEST['m184r226']);
$m184r231 = strip_tags($_REQUEST['m184r231']);
$m184r232 = strip_tags($_REQUEST['m184r232']);
$m184r233 = strip_tags($_REQUEST['m184r233']);
$m184r234 = strip_tags($_REQUEST['m184r234']);
$m184r235 = strip_tags($_REQUEST['m184r235']);
$m184r236 = strip_tags($_REQUEST['m184r236']);
$m184r241 = strip_tags($_REQUEST['m184r241']);
$m184r242 = strip_tags($_REQUEST['m184r242']);
$m184r243 = strip_tags($_REQUEST['m184r243']);
$m184r244 = strip_tags($_REQUEST['m184r244']);
$m184r245 = strip_tags($_REQUEST['m184r245']);
$m184r246 = strip_tags($_REQUEST['m184r246']);
$m184r251 = strip_tags($_REQUEST['m184r251']);
$m184r252 = strip_tags($_REQUEST['m184r252']);
$m184r253 = strip_tags($_REQUEST['m184r253']);
$m184r254 = strip_tags($_REQUEST['m184r254']);
$m184r255 = strip_tags($_REQUEST['m184r255']);
$m184r256 = strip_tags($_REQUEST['m184r256']);
$m184r261 = strip_tags($_REQUEST['m184r261']);
$m184r262 = strip_tags($_REQUEST['m184r262']);
$m184r263 = strip_tags($_REQUEST['m184r263']);
$m184r264 = strip_tags($_REQUEST['m184r264']);
$m184r265 = strip_tags($_REQUEST['m184r265']);
$m184r266 = strip_tags($_REQUEST['m184r266']);
$m184r271 = strip_tags($_REQUEST['m184r271']);
$m184r272 = strip_tags($_REQUEST['m184r272']);
$m184r273 = strip_tags($_REQUEST['m184r273']);
$m184r274 = strip_tags($_REQUEST['m184r274']);
$m184r275 = strip_tags($_REQUEST['m184r275']);
$m184r276 = strip_tags($_REQUEST['m184r276']);
$m184r281 = strip_tags($_REQUEST['m184r281']);
$m184r282 = strip_tags($_REQUEST['m184r282']);
$m184r283 = strip_tags($_REQUEST['m184r283']);
$m184r284 = strip_tags($_REQUEST['m184r284']);
$m184r285 = strip_tags($_REQUEST['m184r285']);
$m184r286 = strip_tags($_REQUEST['m184r286']);
$m184r291 = strip_tags($_REQUEST['m184r291']);
$m184r292 = strip_tags($_REQUEST['m184r292']);
$m184r293 = strip_tags($_REQUEST['m184r293']);
$m184r294 = strip_tags($_REQUEST['m184r294']);
$m184r295 = strip_tags($_REQUEST['m184r295']);
$m184r296 = strip_tags($_REQUEST['m184r296']);
$m184r301 = strip_tags($_REQUEST['m184r301']);
$m184r302 = strip_tags($_REQUEST['m184r302']);
$m184r303 = strip_tags($_REQUEST['m184r303']);
$m184r304 = strip_tags($_REQUEST['m184r304']);
$m184r305 = strip_tags($_REQUEST['m184r305']);
$m184r306 = strip_tags($_REQUEST['m184r306']);
$m184r311 = strip_tags($_REQUEST['m184r311']);
$m184r312 = strip_tags($_REQUEST['m184r312']);
$m184r313 = strip_tags($_REQUEST['m184r313']);
$m184r314 = strip_tags($_REQUEST['m184r314']);
$m184r315 = strip_tags($_REQUEST['m184r315']);
$m184r316 = strip_tags($_REQUEST['m184r316']);
$m184r321 = strip_tags($_REQUEST['m184r321']);
$m184r322 = strip_tags($_REQUEST['m184r322']);
$m184r323 = strip_tags($_REQUEST['m184r323']);
$m184r324 = strip_tags($_REQUEST['m184r324']);
$m184r325 = strip_tags($_REQUEST['m184r325']);
$m184r326 = strip_tags($_REQUEST['m184r326']);
$m184r992 = strip_tags($_REQUEST['m184r992']);
$m184r993 = strip_tags($_REQUEST['m184r993']);
$m184r994 = strip_tags($_REQUEST['m184r994']);
$m184r995 = strip_tags($_REQUEST['m184r995']);
$m184r996 = strip_tags($_REQUEST['m184r996']);
//8.strana
$m185r11 = strip_tags($_REQUEST['m185r11']);
$m185r12 = strip_tags($_REQUEST['m185r12']);
$m185r13 = strip_tags($_REQUEST['m185r13']);
$m185r14 = strip_tags($_REQUEST['m185r14']);
$m185r15 = strip_tags($_REQUEST['m185r15']);
$m185r16 = strip_tags($_REQUEST['m185r16']);
$m185r17 = strip_tags($_REQUEST['m185r17']);
$m185r21 = strip_tags($_REQUEST['m185r21']);
$m185r22 = strip_tags($_REQUEST['m185r22']);
$m185r23 = strip_tags($_REQUEST['m185r23']);
$m185r24 = strip_tags($_REQUEST['m185r24']);
$m185r25 = strip_tags($_REQUEST['m185r25']);
$m185r26 = strip_tags($_REQUEST['m185r26']);
$m185r27 = strip_tags($_REQUEST['m185r27']);
$m185r31 = strip_tags($_REQUEST['m185r31']);
$m185r32 = strip_tags($_REQUEST['m185r32']);
$m185r33 = strip_tags($_REQUEST['m185r33']);
$m185r34 = strip_tags($_REQUEST['m185r34']);
$m185r35 = strip_tags($_REQUEST['m185r35']);
$m185r36 = strip_tags($_REQUEST['m185r36']);
$m185r37 = strip_tags($_REQUEST['m185r37']);
$m185r41 = strip_tags($_REQUEST['m185r41']);
$m185r42 = strip_tags($_REQUEST['m185r42']);
$m185r43 = strip_tags($_REQUEST['m185r43']);
$m185r44 = strip_tags($_REQUEST['m185r44']);
$m185r45 = strip_tags($_REQUEST['m185r45']);
$m185r46 = strip_tags($_REQUEST['m185r46']);
$m185r47 = strip_tags($_REQUEST['m185r47']);
$m185r51 = strip_tags($_REQUEST['m185r51']);
$m185r52 = strip_tags($_REQUEST['m185r52']);
$m185r53 = strip_tags($_REQUEST['m185r53']);
$m185r54 = strip_tags($_REQUEST['m185r54']);
$m185r55 = strip_tags($_REQUEST['m185r55']);
$m185r56 = strip_tags($_REQUEST['m185r56']);
$m185r57 = strip_tags($_REQUEST['m185r57']);
$m185r61 = strip_tags($_REQUEST['m185r61']);
$m185r62 = strip_tags($_REQUEST['m185r62']);
$m185r63 = strip_tags($_REQUEST['m185r63']);
$m185r64 = strip_tags($_REQUEST['m185r64']);
$m185r65 = strip_tags($_REQUEST['m185r65']);
$m185r66 = strip_tags($_REQUEST['m185r66']);
$m185r67 = strip_tags($_REQUEST['m185r67']);
$m185r71 = strip_tags($_REQUEST['m185r71']);
$m185r72 = strip_tags($_REQUEST['m185r72']);
$m185r73 = strip_tags($_REQUEST['m185r73']);
$m185r74 = strip_tags($_REQUEST['m185r74']);
$m185r75 = strip_tags($_REQUEST['m185r75']);
$m185r76 = strip_tags($_REQUEST['m185r76']);
$m185r77 = strip_tags($_REQUEST['m185r77']);
$m185r81 = strip_tags($_REQUEST['m185r81']);
$m185r82 = strip_tags($_REQUEST['m185r82']);
$m185r83 = strip_tags($_REQUEST['m185r83']);
$m185r84 = strip_tags($_REQUEST['m185r84']);
$m185r85 = strip_tags($_REQUEST['m185r85']);
$m185r86 = strip_tags($_REQUEST['m185r86']);
$m185r87 = strip_tags($_REQUEST['m185r87']);
$m185r91 = strip_tags($_REQUEST['m185r91']);
$m185r92 = strip_tags($_REQUEST['m185r92']);
$m185r93 = strip_tags($_REQUEST['m185r93']);
$m185r94 = strip_tags($_REQUEST['m185r94']);
$m185r95 = strip_tags($_REQUEST['m185r95']);
$m185r96 = strip_tags($_REQUEST['m185r96']);
$m185r97 = strip_tags($_REQUEST['m185r97']);
$m185r101 = strip_tags($_REQUEST['m185r101']);
$m185r102 = strip_tags($_REQUEST['m185r102']);
$m185r103 = strip_tags($_REQUEST['m185r103']);
$m185r104 = strip_tags($_REQUEST['m185r104']);
$m185r105 = strip_tags($_REQUEST['m185r105']);
$m185r106 = strip_tags($_REQUEST['m185r106']);
$m185r107 = strip_tags($_REQUEST['m185r107']);
$m185r111 = strip_tags($_REQUEST['m185r111']);
$m185r112 = strip_tags($_REQUEST['m185r112']);
$m185r113 = strip_tags($_REQUEST['m185r113']);
$m185r114 = strip_tags($_REQUEST['m185r114']);
$m185r115 = strip_tags($_REQUEST['m185r115']);
$m185r116 = strip_tags($_REQUEST['m185r116']);
$m185r117 = strip_tags($_REQUEST['m185r117']);
$m185r121 = strip_tags($_REQUEST['m185r121']);
$m185r122 = strip_tags($_REQUEST['m185r122']);
$m185r123 = strip_tags($_REQUEST['m185r123']);
$m185r124 = strip_tags($_REQUEST['m185r124']);
$m185r125 = strip_tags($_REQUEST['m185r125']);
$m185r126 = strip_tags($_REQUEST['m185r126']);
$m185r127 = strip_tags($_REQUEST['m185r127']);
$m185r131 = strip_tags($_REQUEST['m185r131']);
$m185r132 = strip_tags($_REQUEST['m185r132']);
$m185r133 = strip_tags($_REQUEST['m185r133']);
$m185r134 = strip_tags($_REQUEST['m185r134']);
$m185r135 = strip_tags($_REQUEST['m185r135']);
$m185r136 = strip_tags($_REQUEST['m185r136']);
$m185r137 = strip_tags($_REQUEST['m185r137']);
$m185r141 = strip_tags($_REQUEST['m185r141']);
$m185r142 = strip_tags($_REQUEST['m185r142']);
$m185r143 = strip_tags($_REQUEST['m185r143']);
$m185r144 = strip_tags($_REQUEST['m185r144']);
$m185r145 = strip_tags($_REQUEST['m185r145']);
$m185r146 = strip_tags($_REQUEST['m185r146']);
$m185r147 = strip_tags($_REQUEST['m185r147']);
$m185r151 = strip_tags($_REQUEST['m185r151']);
$m185r152 = strip_tags($_REQUEST['m185r152']);
$m185r153 = strip_tags($_REQUEST['m185r153']);
$m185r154 = strip_tags($_REQUEST['m185r154']);
$m185r155 = strip_tags($_REQUEST['m185r155']);
$m185r156 = strip_tags($_REQUEST['m185r156']);
$m185r157 = strip_tags($_REQUEST['m185r157']);
$m185r161 = strip_tags($_REQUEST['m185r161']);
$m185r162 = strip_tags($_REQUEST['m185r162']);
$m185r163 = strip_tags($_REQUEST['m185r163']);
$m185r164 = strip_tags($_REQUEST['m185r164']);
$m185r165 = strip_tags($_REQUEST['m185r165']);
$m185r166 = strip_tags($_REQUEST['m185r166']);
$m185r167 = strip_tags($_REQUEST['m185r167']);
$m185r171 = strip_tags($_REQUEST['m185r171']);
$m185r172 = strip_tags($_REQUEST['m185r172']);
$m185r173 = strip_tags($_REQUEST['m185r173']);
$m185r174 = strip_tags($_REQUEST['m185r174']);
$m185r175 = strip_tags($_REQUEST['m185r175']);
$m185r176 = strip_tags($_REQUEST['m185r176']);
$m185r177 = strip_tags($_REQUEST['m185r177']);
$m185r181 = strip_tags($_REQUEST['m185r181']);
$m185r182 = strip_tags($_REQUEST['m185r182']);
$m185r183 = strip_tags($_REQUEST['m185r183']);
$m185r184 = strip_tags($_REQUEST['m185r184']);
$m185r185 = strip_tags($_REQUEST['m185r185']);
$m185r186 = strip_tags($_REQUEST['m185r186']);
$m185r187 = strip_tags($_REQUEST['m185r187']);
$m185r191 = strip_tags($_REQUEST['m185r191']);
$m185r192 = strip_tags($_REQUEST['m185r192']);
$m185r193 = strip_tags($_REQUEST['m185r193']);
$m185r194 = strip_tags($_REQUEST['m185r194']);
$m185r195 = strip_tags($_REQUEST['m185r195']);
$m185r196 = strip_tags($_REQUEST['m185r196']);
$m185r197 = strip_tags($_REQUEST['m185r197']);
$m185r201 = strip_tags($_REQUEST['m185r201']);
$m185r202 = strip_tags($_REQUEST['m185r202']);
$m185r203 = strip_tags($_REQUEST['m185r203']);
$m185r204 = strip_tags($_REQUEST['m185r204']);
$m185r205 = strip_tags($_REQUEST['m185r205']);
$m185r206 = strip_tags($_REQUEST['m185r206']);
$m185r207 = strip_tags($_REQUEST['m185r207']);
$m185r211 = strip_tags($_REQUEST['m185r211']);
$m185r212 = strip_tags($_REQUEST['m185r212']);
$m185r213 = strip_tags($_REQUEST['m185r213']);
$m185r214 = strip_tags($_REQUEST['m185r214']);
$m185r215 = strip_tags($_REQUEST['m185r215']);
$m185r216 = strip_tags($_REQUEST['m185r216']);
$m185r217 = strip_tags($_REQUEST['m185r217']);
$m185r221 = strip_tags($_REQUEST['m185r221']);
$m185r222 = strip_tags($_REQUEST['m185r222']);
$m185r223 = strip_tags($_REQUEST['m185r223']);
$m185r224 = strip_tags($_REQUEST['m185r224']);
$m185r225 = strip_tags($_REQUEST['m185r225']);
$m185r226 = strip_tags($_REQUEST['m185r226']);
$m185r227 = strip_tags($_REQUEST['m185r227']);
$m185r231 = strip_tags($_REQUEST['m185r231']);
$m185r232 = strip_tags($_REQUEST['m185r232']);
$m185r233 = strip_tags($_REQUEST['m185r233']);
$m185r234 = strip_tags($_REQUEST['m185r234']);
$m185r235 = strip_tags($_REQUEST['m185r235']);
$m185r236 = strip_tags($_REQUEST['m185r236']);
$m185r237 = strip_tags($_REQUEST['m185r237']);
$m185r241 = strip_tags($_REQUEST['m185r241']);
$m185r242 = strip_tags($_REQUEST['m185r242']);
$m185r243 = strip_tags($_REQUEST['m185r243']);
$m185r244 = strip_tags($_REQUEST['m185r244']);
$m185r245 = strip_tags($_REQUEST['m185r245']);
$m185r246 = strip_tags($_REQUEST['m185r246']);
$m185r247 = strip_tags($_REQUEST['m185r247']);
$m185r251 = strip_tags($_REQUEST['m185r251']);
$m185r252 = strip_tags($_REQUEST['m185r252']);
$m185r253 = strip_tags($_REQUEST['m185r253']);
$m185r254 = strip_tags($_REQUEST['m185r254']);
$m185r255 = strip_tags($_REQUEST['m185r255']);
$m185r256 = strip_tags($_REQUEST['m185r256']);
$m185r257 = strip_tags($_REQUEST['m185r257']);
$m185r261 = strip_tags($_REQUEST['m185r261']);
$m185r262 = strip_tags($_REQUEST['m185r262']);
$m185r263 = strip_tags($_REQUEST['m185r263']);
$m185r264 = strip_tags($_REQUEST['m185r264']);
$m185r265 = strip_tags($_REQUEST['m185r265']);
$m185r266 = strip_tags($_REQUEST['m185r266']);
$m185r267 = strip_tags($_REQUEST['m185r267']);
$m185r271 = strip_tags($_REQUEST['m185r271']);
$m185r272 = strip_tags($_REQUEST['m185r272']);
$m185r273 = strip_tags($_REQUEST['m185r273']);
$m185r274 = strip_tags($_REQUEST['m185r274']);
$m185r275 = strip_tags($_REQUEST['m185r275']);
$m185r276 = strip_tags($_REQUEST['m185r276']);
$m185r277 = strip_tags($_REQUEST['m185r277']);
$m185r281 = strip_tags($_REQUEST['m185r281']);
$m185r282 = strip_tags($_REQUEST['m185r282']);
$m185r283 = strip_tags($_REQUEST['m185r283']);
$m185r284 = strip_tags($_REQUEST['m185r284']);
$m185r285 = strip_tags($_REQUEST['m185r285']);
$m185r286 = strip_tags($_REQUEST['m185r286']);
$m185r287 = strip_tags($_REQUEST['m185r287']);
$m185r291 = strip_tags($_REQUEST['m185r291']);
$m185r292 = strip_tags($_REQUEST['m185r292']);
$m185r293 = strip_tags($_REQUEST['m185r293']);
$m185r294 = strip_tags($_REQUEST['m185r294']);
$m185r295 = strip_tags($_REQUEST['m185r295']);
$m185r296 = strip_tags($_REQUEST['m185r296']);
$m185r297 = strip_tags($_REQUEST['m185r297']);
$m185r301 = strip_tags($_REQUEST['m185r301']);
$m185r302 = strip_tags($_REQUEST['m185r302']);
$m185r303 = strip_tags($_REQUEST['m185r303']);
$m185r304 = strip_tags($_REQUEST['m185r304']);
$m185r305 = strip_tags($_REQUEST['m185r305']);
$m185r306 = strip_tags($_REQUEST['m185r306']);
$m185r307 = strip_tags($_REQUEST['m185r307']);
$m185r992 = strip_tags($_REQUEST['m185r992']);
$m185r993 = strip_tags($_REQUEST['m185r993']);
$m185r994 = strip_tags($_REQUEST['m185r994']);
$m185r995 = strip_tags($_REQUEST['m185r995']);
$m185r996 = strip_tags($_REQUEST['m185r996']);
$m185r997 = strip_tags($_REQUEST['m185r997']);
//9.strana
$m186r11 = strip_tags($_REQUEST['m186r11']);
$m186r12 = strip_tags($_REQUEST['m186r12']);
$m186r13 = strip_tags($_REQUEST['m186r13']);
$m186r14 = strip_tags($_REQUEST['m186r14']);
$m186r15 = strip_tags($_REQUEST['m186r15']);
$m186r16 = strip_tags($_REQUEST['m186r16']);
$m186r17 = strip_tags($_REQUEST['m186r17']);
$m186r21 = strip_tags($_REQUEST['m186r21']);
$m186r22 = strip_tags($_REQUEST['m186r22']);
$m186r23 = strip_tags($_REQUEST['m186r23']);
$m186r24 = strip_tags($_REQUEST['m186r24']);
$m186r25 = strip_tags($_REQUEST['m186r25']);
$m186r26 = strip_tags($_REQUEST['m186r26']);
$m186r27 = strip_tags($_REQUEST['m186r27']);
$m186r31 = strip_tags($_REQUEST['m186r31']);
$m186r32 = strip_tags($_REQUEST['m186r32']);
$m186r33 = strip_tags($_REQUEST['m186r33']);
$m186r34 = strip_tags($_REQUEST['m186r34']);
$m186r35 = strip_tags($_REQUEST['m186r35']);
$m186r36 = strip_tags($_REQUEST['m186r36']);
$m186r37 = strip_tags($_REQUEST['m186r37']);
$m186r41 = strip_tags($_REQUEST['m186r41']);
$m186r42 = strip_tags($_REQUEST['m186r42']);
$m186r43 = strip_tags($_REQUEST['m186r43']);
$m186r44 = strip_tags($_REQUEST['m186r44']);
$m186r45 = strip_tags($_REQUEST['m186r45']);
$m186r46 = strip_tags($_REQUEST['m186r46']);
$m186r47 = strip_tags($_REQUEST['m186r47']);
$m186r51 = strip_tags($_REQUEST['m186r51']);
$m186r52 = strip_tags($_REQUEST['m186r52']);
$m186r53 = strip_tags($_REQUEST['m186r53']);
$m186r54 = strip_tags($_REQUEST['m186r54']);
$m186r55 = strip_tags($_REQUEST['m186r55']);
$m186r56 = strip_tags($_REQUEST['m186r56']);
$m186r57 = strip_tags($_REQUEST['m186r57']);
$m186r61 = strip_tags($_REQUEST['m186r61']);
$m186r62 = strip_tags($_REQUEST['m186r62']);
$m186r63 = strip_tags($_REQUEST['m186r63']);
$m186r64 = strip_tags($_REQUEST['m186r64']);
$m186r65 = strip_tags($_REQUEST['m186r65']);
$m186r66 = strip_tags($_REQUEST['m186r66']);
$m186r67 = strip_tags($_REQUEST['m186r67']);
$m186r71 = strip_tags($_REQUEST['m186r71']);
$m186r72 = strip_tags($_REQUEST['m186r72']);
$m186r73 = strip_tags($_REQUEST['m186r73']);
$m186r74 = strip_tags($_REQUEST['m186r74']);
$m186r75 = strip_tags($_REQUEST['m186r75']);
$m186r76 = strip_tags($_REQUEST['m186r76']);
$m186r77 = strip_tags($_REQUEST['m186r77']);
$m186r81 = strip_tags($_REQUEST['m186r81']);
$m186r82 = strip_tags($_REQUEST['m186r82']);
$m186r83 = strip_tags($_REQUEST['m186r83']);
$m186r84 = strip_tags($_REQUEST['m186r84']);
$m186r85 = strip_tags($_REQUEST['m186r85']);
$m186r86 = strip_tags($_REQUEST['m186r86']);
$m186r87 = strip_tags($_REQUEST['m186r87']);
$m186r91 = strip_tags($_REQUEST['m186r91']);
$m186r92 = strip_tags($_REQUEST['m186r92']);
$m186r93 = strip_tags($_REQUEST['m186r93']);
$m186r94 = strip_tags($_REQUEST['m186r94']);
$m186r95 = strip_tags($_REQUEST['m186r95']);
$m186r96 = strip_tags($_REQUEST['m186r96']);
$m186r97 = strip_tags($_REQUEST['m186r97']);
$m186r101 = strip_tags($_REQUEST['m186r101']);
$m186r102 = strip_tags($_REQUEST['m186r102']);
$m186r103 = strip_tags($_REQUEST['m186r103']);
$m186r104 = strip_tags($_REQUEST['m186r104']);
$m186r105 = strip_tags($_REQUEST['m186r105']);
$m186r106 = strip_tags($_REQUEST['m186r106']);
$m186r107 = strip_tags($_REQUEST['m186r107']);
$m186r111 = strip_tags($_REQUEST['m186r111']);
$m186r112 = strip_tags($_REQUEST['m186r112']);
$m186r113 = strip_tags($_REQUEST['m186r113']);
$m186r114 = strip_tags($_REQUEST['m186r114']);
$m186r115 = strip_tags($_REQUEST['m186r115']);
$m186r116 = strip_tags($_REQUEST['m186r116']);
$m186r117 = strip_tags($_REQUEST['m186r117']);
$m186r121 = strip_tags($_REQUEST['m186r121']);
$m186r122 = strip_tags($_REQUEST['m186r122']);
$m186r123 = strip_tags($_REQUEST['m186r123']);
$m186r124 = strip_tags($_REQUEST['m186r124']);
$m186r125 = strip_tags($_REQUEST['m186r125']);
$m186r126 = strip_tags($_REQUEST['m186r126']);
$m186r127 = strip_tags($_REQUEST['m186r127']);
$m186r131 = strip_tags($_REQUEST['m186r131']);
$m186r132 = strip_tags($_REQUEST['m186r132']);
$m186r133 = strip_tags($_REQUEST['m186r133']);
$m186r134 = strip_tags($_REQUEST['m186r134']);
$m186r135 = strip_tags($_REQUEST['m186r135']);
$m186r136 = strip_tags($_REQUEST['m186r136']);
$m186r137 = strip_tags($_REQUEST['m186r137']);
$m186r141 = strip_tags($_REQUEST['m186r141']);
$m186r142 = strip_tags($_REQUEST['m186r142']);
$m186r143 = strip_tags($_REQUEST['m186r143']);
$m186r144 = strip_tags($_REQUEST['m186r144']);
$m186r145 = strip_tags($_REQUEST['m186r145']);
$m186r146 = strip_tags($_REQUEST['m186r146']);
$m186r147 = strip_tags($_REQUEST['m186r147']);
$m186r151 = strip_tags($_REQUEST['m186r151']);
$m186r152 = strip_tags($_REQUEST['m186r152']);
$m186r153 = strip_tags($_REQUEST['m186r153']);
$m186r154 = strip_tags($_REQUEST['m186r154']);
$m186r155 = strip_tags($_REQUEST['m186r155']);
$m186r156 = strip_tags($_REQUEST['m186r156']);
$m186r157 = strip_tags($_REQUEST['m186r157']);
$m186r161 = strip_tags($_REQUEST['m186r161']);
$m186r162 = strip_tags($_REQUEST['m186r162']);
$m186r163 = strip_tags($_REQUEST['m186r163']);
$m186r164 = strip_tags($_REQUEST['m186r164']);
$m186r165 = strip_tags($_REQUEST['m186r165']);
$m186r166 = strip_tags($_REQUEST['m186r166']);
$m186r167 = strip_tags($_REQUEST['m186r167']);
$m186r171 = strip_tags($_REQUEST['m186r171']);
$m186r172 = strip_tags($_REQUEST['m186r172']);
$m186r173 = strip_tags($_REQUEST['m186r173']);
$m186r174 = strip_tags($_REQUEST['m186r174']);
$m186r175 = strip_tags($_REQUEST['m186r175']);
$m186r176 = strip_tags($_REQUEST['m186r176']);
$m186r177 = strip_tags($_REQUEST['m186r177']);
$m186r181 = strip_tags($_REQUEST['m186r181']);
$m186r182 = strip_tags($_REQUEST['m186r182']);
$m186r183 = strip_tags($_REQUEST['m186r183']);
$m186r184 = strip_tags($_REQUEST['m186r184']);
$m186r185 = strip_tags($_REQUEST['m186r185']);
$m186r186 = strip_tags($_REQUEST['m186r186']);
$m186r187 = strip_tags($_REQUEST['m186r187']);
$m186r191 = strip_tags($_REQUEST['m186r191']);
$m186r192 = strip_tags($_REQUEST['m186r192']);
$m186r193 = strip_tags($_REQUEST['m186r193']);
$m186r194 = strip_tags($_REQUEST['m186r194']);
$m186r195 = strip_tags($_REQUEST['m186r195']);
$m186r196 = strip_tags($_REQUEST['m186r196']);
$m186r197 = strip_tags($_REQUEST['m186r197']);
$m186r201 = strip_tags($_REQUEST['m186r201']);
$m186r202 = strip_tags($_REQUEST['m186r202']);
$m186r203 = strip_tags($_REQUEST['m186r203']);
$m186r204 = strip_tags($_REQUEST['m186r204']);
$m186r205 = strip_tags($_REQUEST['m186r205']);
$m186r206 = strip_tags($_REQUEST['m186r206']);
$m186r207 = strip_tags($_REQUEST['m186r207']);
$m186r211 = strip_tags($_REQUEST['m186r211']);
$m186r212 = strip_tags($_REQUEST['m186r212']);
$m186r213 = strip_tags($_REQUEST['m186r213']);
$m186r214 = strip_tags($_REQUEST['m186r214']);
$m186r215 = strip_tags($_REQUEST['m186r215']);
$m186r216 = strip_tags($_REQUEST['m186r216']);
$m186r217 = strip_tags($_REQUEST['m186r217']);
$m186r221 = strip_tags($_REQUEST['m186r221']);
$m186r222 = strip_tags($_REQUEST['m186r222']);
$m186r223 = strip_tags($_REQUEST['m186r223']);
$m186r224 = strip_tags($_REQUEST['m186r224']);
$m186r225 = strip_tags($_REQUEST['m186r225']);
$m186r226 = strip_tags($_REQUEST['m186r226']);
$m186r227 = strip_tags($_REQUEST['m186r227']);
$m186r231 = strip_tags($_REQUEST['m186r231']);
$m186r232 = strip_tags($_REQUEST['m186r232']);
$m186r233 = strip_tags($_REQUEST['m186r233']);
$m186r234 = strip_tags($_REQUEST['m186r234']);
$m186r235 = strip_tags($_REQUEST['m186r235']);
$m186r236 = strip_tags($_REQUEST['m186r236']);
$m186r237 = strip_tags($_REQUEST['m186r237']);
$m186r241 = strip_tags($_REQUEST['m186r241']);
$m186r242 = strip_tags($_REQUEST['m186r242']);
$m186r243 = strip_tags($_REQUEST['m186r243']);
$m186r244 = strip_tags($_REQUEST['m186r244']);
$m186r245 = strip_tags($_REQUEST['m186r245']);
$m186r246 = strip_tags($_REQUEST['m186r246']);
$m186r247 = strip_tags($_REQUEST['m186r247']);
$m186r251 = strip_tags($_REQUEST['m186r251']);
$m186r252 = strip_tags($_REQUEST['m186r252']);
$m186r253 = strip_tags($_REQUEST['m186r253']);
$m186r254 = strip_tags($_REQUEST['m186r254']);
$m186r255 = strip_tags($_REQUEST['m186r255']);
$m186r256 = strip_tags($_REQUEST['m186r256']);
$m186r257 = strip_tags($_REQUEST['m186r257']);
$m186r261 = strip_tags($_REQUEST['m186r261']);
$m186r262 = strip_tags($_REQUEST['m186r262']);
$m186r263 = strip_tags($_REQUEST['m186r263']);
$m186r264 = strip_tags($_REQUEST['m186r264']);
$m186r265 = strip_tags($_REQUEST['m186r265']);
$m186r266 = strip_tags($_REQUEST['m186r266']);
$m186r267 = strip_tags($_REQUEST['m186r267']);
$m186r271 = strip_tags($_REQUEST['m186r271']);
$m186r272 = strip_tags($_REQUEST['m186r272']);
$m186r273 = strip_tags($_REQUEST['m186r273']);
$m186r274 = strip_tags($_REQUEST['m186r274']);
$m186r275 = strip_tags($_REQUEST['m186r275']);
$m186r276 = strip_tags($_REQUEST['m186r276']);
$m186r277 = strip_tags($_REQUEST['m186r277']);
$m186r281 = strip_tags($_REQUEST['m186r281']);
$m186r282 = strip_tags($_REQUEST['m186r282']);
$m186r283 = strip_tags($_REQUEST['m186r283']);
$m186r284 = strip_tags($_REQUEST['m186r284']);
$m186r285 = strip_tags($_REQUEST['m186r285']);
$m186r286 = strip_tags($_REQUEST['m186r286']);
$m186r287 = strip_tags($_REQUEST['m186r287']);
$m186r291 = strip_tags($_REQUEST['m186r291']);
$m186r292 = strip_tags($_REQUEST['m186r292']);
$m186r293 = strip_tags($_REQUEST['m186r293']);
$m186r294 = strip_tags($_REQUEST['m186r294']);
$m186r295 = strip_tags($_REQUEST['m186r295']);
$m186r296 = strip_tags($_REQUEST['m186r296']);
$m186r297 = strip_tags($_REQUEST['m186r297']);
$m186r301 = strip_tags($_REQUEST['m186r301']);
$m186r302 = strip_tags($_REQUEST['m186r302']);
$m186r303 = strip_tags($_REQUEST['m186r303']);
$m186r304 = strip_tags($_REQUEST['m186r304']);
$m186r305 = strip_tags($_REQUEST['m186r305']);
$m186r306 = strip_tags($_REQUEST['m186r306']);
$m186r307 = strip_tags($_REQUEST['m186r307']);
$m186r992 = strip_tags($_REQUEST['m186r992']);
$m186r993 = strip_tags($_REQUEST['m186r993']);
$m186r994 = strip_tags($_REQUEST['m186r994']);
$m186r995 = strip_tags($_REQUEST['m186r995']);
$m186r996 = strip_tags($_REQUEST['m186r996']);
$m186r997 = strip_tags($_REQUEST['m186r997']);
//10.strana
$m187r1 = strip_tags($_REQUEST['m187r1']);
//$m187r2 = strip_tags($_REQUEST['m187r2']);
//$m187r3 = strip_tags($_REQUEST['m187r3']);
//$m187r4 = strip_tags($_REQUEST['m187r4']);
//$m187r5 = strip_tags($_REQUEST['m187r5']);
//$m187r6 = strip_tags($_REQUEST['m187r6']);
//$m187r7 = strip_tags($_REQUEST['m187r7']);
//$m187r8 = strip_tags($_REQUEST['m187r8']);
//$m187r9 = strip_tags($_REQUEST['m187r9']);
//$m187r10 = strip_tags($_REQUEST['m187r10']);
//$m187r11 = strip_tags($_REQUEST['m187r11']);
//$m187r99 = strip_tags($_REQUEST['m187r99']);
$m1590r1a = strip_tags($_REQUEST['m1590r1a']);
$m1590r1b = strip_tags($_REQUEST['m1590r1b']);
$m1590r2a = strip_tags($_REQUEST['m1590r2a']);
$m1590r2b = strip_tags($_REQUEST['m1590r2b']);
$m590r11 = strip_tags($_REQUEST['m590r11']);
$m590r12 = strip_tags($_REQUEST['m590r12']);
$m590r13 = strip_tags($_REQUEST['m590r13']);
$m590r14 = strip_tags($_REQUEST['m590r14']);
$m590r15 = strip_tags($_REQUEST['m590r15']);
$m590r21 = strip_tags($_REQUEST['m590r21']);
$m590r22 = strip_tags($_REQUEST['m590r22']);
$m590r23 = strip_tags($_REQUEST['m590r23']);
$m590r24 = strip_tags($_REQUEST['m590r24']);
$m590r25 = strip_tags($_REQUEST['m590r25']);
$m590r31 = strip_tags($_REQUEST['m590r31']);
$m590r32 = strip_tags($_REQUEST['m590r32']);
$m590r33 = strip_tags($_REQUEST['m590r33']);
$m590r34 = strip_tags($_REQUEST['m590r34']);
$m590r35 = strip_tags($_REQUEST['m590r35']);
$m590r41 = strip_tags($_REQUEST['m590r41']);
$m590r42 = strip_tags($_REQUEST['m590r42']);
$m590r43 = strip_tags($_REQUEST['m590r43']);
$m590r44 = strip_tags($_REQUEST['m590r44']);
$m590r45 = strip_tags($_REQUEST['m590r45']);
$m590r51 = strip_tags($_REQUEST['m590r51']);
$m590r52 = strip_tags($_REQUEST['m590r52']);
$m590r53 = strip_tags($_REQUEST['m590r53']);
$m590r54 = strip_tags($_REQUEST['m590r54']);
$m590r55 = strip_tags($_REQUEST['m590r55']);
$m590r61 = strip_tags($_REQUEST['m590r61']);
$m590r62 = strip_tags($_REQUEST['m590r62']);
$m590r63 = strip_tags($_REQUEST['m590r63']);
$m590r64 = strip_tags($_REQUEST['m590r64']);
$m590r65 = strip_tags($_REQUEST['m590r65']);
$m590r71 = strip_tags($_REQUEST['m590r71']);
$m590r72 = strip_tags($_REQUEST['m590r72']);
$m590r73 = strip_tags($_REQUEST['m590r73']);
$m590r74 = strip_tags($_REQUEST['m590r74']);
$m590r75 = strip_tags($_REQUEST['m590r75']);
$m590r81 = strip_tags($_REQUEST['m590r81']);
$m590r82 = strip_tags($_REQUEST['m590r82']);
$m590r83 = strip_tags($_REQUEST['m590r83']);
$m590r84 = strip_tags($_REQUEST['m590r84']);
$m590r85 = strip_tags($_REQUEST['m590r85']);
$m590r91 = strip_tags($_REQUEST['m590r91']);
$m590r92 = strip_tags($_REQUEST['m590r92']);
$m590r93 = strip_tags($_REQUEST['m590r93']);
$m590r94 = strip_tags($_REQUEST['m590r94']);
$m590r95 = strip_tags($_REQUEST['m590r95']);
$m590r101 = strip_tags($_REQUEST['m590r101']);
$m590r102 = strip_tags($_REQUEST['m590r102']);
$m590r103 = strip_tags($_REQUEST['m590r103']);
$m590r104 = strip_tags($_REQUEST['m590r104']);
$m590r105 = strip_tags($_REQUEST['m590r105']);
$m590r111 = strip_tags($_REQUEST['m590r111']);
$m590r112 = strip_tags($_REQUEST['m590r112']);
$m590r113 = strip_tags($_REQUEST['m590r113']);
$m590r114 = strip_tags($_REQUEST['m590r114']);
$m590r115 = strip_tags($_REQUEST['m590r115']);
$m590r121 = strip_tags($_REQUEST['m590r121']);
$m590r122 = strip_tags($_REQUEST['m590r122']);
$m590r123 = strip_tags($_REQUEST['m590r123']);
$m590r124 = strip_tags($_REQUEST['m590r124']);
$m590r125 = strip_tags($_REQUEST['m590r125']);
$m590r131 = strip_tags($_REQUEST['m590r131']);
$m590r132 = strip_tags($_REQUEST['m590r132']);
$m590r133 = strip_tags($_REQUEST['m590r133']);
$m590r134 = strip_tags($_REQUEST['m590r134']);
$m590r135 = strip_tags($_REQUEST['m590r135']);
$m590r141 = strip_tags($_REQUEST['m590r141']);
$m590r142 = strip_tags($_REQUEST['m590r142']);
$m590r143 = strip_tags($_REQUEST['m590r143']);
$m590r144 = strip_tags($_REQUEST['m590r144']);
$m590r145 = strip_tags($_REQUEST['m590r145']);
$m590r151 = strip_tags($_REQUEST['m590r151']);
$m590r152 = strip_tags($_REQUEST['m590r152']);
$m590r153 = strip_tags($_REQUEST['m590r153']);
$m590r154 = strip_tags($_REQUEST['m590r154']);
$m590r155 = strip_tags($_REQUEST['m590r155']);
$m590r161 = strip_tags($_REQUEST['m590r161']);
$m590r162 = strip_tags($_REQUEST['m590r162']);
$m590r163 = strip_tags($_REQUEST['m590r163']);
$m590r164 = strip_tags($_REQUEST['m590r164']);
$m590r165 = strip_tags($_REQUEST['m590r165']);
$m590r171 = strip_tags($_REQUEST['m590r171']);
$m590r172 = strip_tags($_REQUEST['m590r172']);
$m590r173 = strip_tags($_REQUEST['m590r173']);
$m590r174 = strip_tags($_REQUEST['m590r174']);
$m590r175 = strip_tags($_REQUEST['m590r175']);
$m590r181 = strip_tags($_REQUEST['m590r181']);
$m590r182 = strip_tags($_REQUEST['m590r182']);
$m590r183 = strip_tags($_REQUEST['m590r183']);
$m590r184 = strip_tags($_REQUEST['m590r184']);
$m590r185 = strip_tags($_REQUEST['m590r185']);
$m590r191 = strip_tags($_REQUEST['m590r191']);
$m590r192 = strip_tags($_REQUEST['m590r192']);
$m590r193 = strip_tags($_REQUEST['m590r193']);
$m590r194 = strip_tags($_REQUEST['m590r194']);
$m590r195 = strip_tags($_REQUEST['m590r195']);
$m590r201 = strip_tags($_REQUEST['m590r201']);
$m590r202 = strip_tags($_REQUEST['m590r202']);
$m590r203 = strip_tags($_REQUEST['m590r203']);
$m590r204 = strip_tags($_REQUEST['m590r204']);
$m590r205 = strip_tags($_REQUEST['m590r205']);
$m590r992 = strip_tags($_REQUEST['m590r992']);
$m590r993 = strip_tags($_REQUEST['m590r993']);
$m590r994 = strip_tags($_REQUEST['m590r994']);
$m590r995 = strip_tags($_REQUEST['m590r995']);
//11.strana
$m304r1 = strip_tags($_REQUEST['m304r1']);
$m304r2 = strip_tags($_REQUEST['m304r2']);
$m304r3 = strip_tags($_REQUEST['m304r3']);
$m304r4 = strip_tags($_REQUEST['m304r4']);
$m304r5 = strip_tags($_REQUEST['m304r5']);
$m304r6 = strip_tags($_REQUEST['m304r6']);
$m304r7 = strip_tags($_REQUEST['m304r7']);
$m304r8 = strip_tags($_REQUEST['m304r8']);
$m304r9 = strip_tags($_REQUEST['m304r9']);
$m304r10 = strip_tags($_REQUEST['m304r10']);
$m304r11 = strip_tags($_REQUEST['m304r11']);
$m304r12 = strip_tags($_REQUEST['m304r12']);
$m304r13 = strip_tags($_REQUEST['m304r13']);
$m304r14 = strip_tags($_REQUEST['m304r14']);
$m304r15 = strip_tags($_REQUEST['m304r15']);
$m304r16 = strip_tags($_REQUEST['m304r16']);
$m304r99 = strip_tags($_REQUEST['m304r99']);
//12.strana
$m110r12 = strip_tags($_REQUEST['m110r12']);
$m110r13 = strip_tags($_REQUEST['m110r13']);
$m110r14 = strip_tags($_REQUEST['m110r14']);
$m110r15 = strip_tags($_REQUEST['m110r15']);
$m110r16 = strip_tags($_REQUEST['m110r16']);
$m110r17 = strip_tags($_REQUEST['m110r17']);
$m110r18 = strip_tags($_REQUEST['m110r18']);
$m110r19 = strip_tags($_REQUEST['m110r19']);
$m110r22 = strip_tags($_REQUEST['m110r22']);
$m110r23 = strip_tags($_REQUEST['m110r23']);
$m110r24 = strip_tags($_REQUEST['m110r24']);
$m110r25 = strip_tags($_REQUEST['m110r25']);
$m110r26 = strip_tags($_REQUEST['m110r26']);
$m110r27 = strip_tags($_REQUEST['m110r27']);
$m110r28 = strip_tags($_REQUEST['m110r28']);
$m110r29 = strip_tags($_REQUEST['m110r29']);
$m110r32 = strip_tags($_REQUEST['m110r32']);
$m110r33 = strip_tags($_REQUEST['m110r33']);
$m110r34 = strip_tags($_REQUEST['m110r34']);
$m110r35 = strip_tags($_REQUEST['m110r35']);
$m110r36 = strip_tags($_REQUEST['m110r36']);
$m110r37 = strip_tags($_REQUEST['m110r37']);
$m110r38 = strip_tags($_REQUEST['m110r38']);
$m110r39 = strip_tags($_REQUEST['m110r39']);
$m110r42 = strip_tags($_REQUEST['m110r42']);
$m110r43 = strip_tags($_REQUEST['m110r43']);
$m110r44 = strip_tags($_REQUEST['m110r44']);
$m110r45 = strip_tags($_REQUEST['m110r45']);
$m110r46 = strip_tags($_REQUEST['m110r46']);
$m110r47 = strip_tags($_REQUEST['m110r47']);
$m110r48 = strip_tags($_REQUEST['m110r48']);
$m110r49 = strip_tags($_REQUEST['m110r49']);
$m110r52 = strip_tags($_REQUEST['m110r52']);
$m110r53 = strip_tags($_REQUEST['m110r53']);
$m110r54 = strip_tags($_REQUEST['m110r54']);
$m110r55 = strip_tags($_REQUEST['m110r55']);
$m110r56 = strip_tags($_REQUEST['m110r56']);
$m110r57 = strip_tags($_REQUEST['m110r57']);
$m110r58 = strip_tags($_REQUEST['m110r58']);
$m110r59 = strip_tags($_REQUEST['m110r59']);
$m110r62 = strip_tags($_REQUEST['m110r62']);
$m110r63 = strip_tags($_REQUEST['m110r63']);
$m110r64 = strip_tags($_REQUEST['m110r64']);
$m110r65 = strip_tags($_REQUEST['m110r65']);
$m110r66 = strip_tags($_REQUEST['m110r66']);
$m110r67 = strip_tags($_REQUEST['m110r67']);
$m110r68 = strip_tags($_REQUEST['m110r68']);
$m110r69 = strip_tags($_REQUEST['m110r69']);
$m110r72 = strip_tags($_REQUEST['m110r72']);
$m110r73 = strip_tags($_REQUEST['m110r73']);
$m110r74 = strip_tags($_REQUEST['m110r74']);
$m110r75 = strip_tags($_REQUEST['m110r75']);
$m110r76 = strip_tags($_REQUEST['m110r76']);
$m110r77 = strip_tags($_REQUEST['m110r77']);
$m110r78 = strip_tags($_REQUEST['m110r78']);
$m110r79 = strip_tags($_REQUEST['m110r79']);
$m110r82 = strip_tags($_REQUEST['m110r82']);
$m110r83 = strip_tags($_REQUEST['m110r83']);
$m110r84 = strip_tags($_REQUEST['m110r84']);
$m110r85 = strip_tags($_REQUEST['m110r85']);
$m110r86 = strip_tags($_REQUEST['m110r86']);
$m110r87 = strip_tags($_REQUEST['m110r87']);
$m110r88 = strip_tags($_REQUEST['m110r88']);
$m110r89 = strip_tags($_REQUEST['m110r89']);
$m110r92 = strip_tags($_REQUEST['m110r92']);
$m110r93 = strip_tags($_REQUEST['m110r93']);
$m110r94 = strip_tags($_REQUEST['m110r94']);
$m110r95 = strip_tags($_REQUEST['m110r95']);
$m110r96 = strip_tags($_REQUEST['m110r96']);
$m110r97 = strip_tags($_REQUEST['m110r97']);
$m110r98 = strip_tags($_REQUEST['m110r98']);
$m110r99 = strip_tags($_REQUEST['m110r99']);
$m110r102 = strip_tags($_REQUEST['m110r102']);
$m110r103 = strip_tags($_REQUEST['m110r103']);
$m110r104 = strip_tags($_REQUEST['m110r104']);
$m110r105 = strip_tags($_REQUEST['m110r105']);
$m110r106 = strip_tags($_REQUEST['m110r106']);
$m110r107 = strip_tags($_REQUEST['m110r107']);
$m110r108 = strip_tags($_REQUEST['m110r108']);
$m110r109 = strip_tags($_REQUEST['m110r109']);
$m110r112 = strip_tags($_REQUEST['m110r112']);
$m110r113 = strip_tags($_REQUEST['m110r113']);
$m110r114 = strip_tags($_REQUEST['m110r114']);
$m110r115 = strip_tags($_REQUEST['m110r115']);
$m110r116 = strip_tags($_REQUEST['m110r116']);
$m110r117 = strip_tags($_REQUEST['m110r117']);
$m110r118 = strip_tags($_REQUEST['m110r118']);
$m110r119 = strip_tags($_REQUEST['m110r119']);
$m110r122 = strip_tags($_REQUEST['m110r122']);
$m110r123 = strip_tags($_REQUEST['m110r123']);
$m110r124 = strip_tags($_REQUEST['m110r124']);
$m110r125 = strip_tags($_REQUEST['m110r125']);
$m110r126 = strip_tags($_REQUEST['m110r126']);
$m110r127 = strip_tags($_REQUEST['m110r127']);
$m110r128 = strip_tags($_REQUEST['m110r128']);
$m110r129 = strip_tags($_REQUEST['m110r129']);
$m110r132 = strip_tags($_REQUEST['m110r132']);
$m110r133 = strip_tags($_REQUEST['m110r133']);
$m110r134 = strip_tags($_REQUEST['m110r134']);
$m110r135 = strip_tags($_REQUEST['m110r135']);
$m110r136 = strip_tags($_REQUEST['m110r136']);
$m110r137 = strip_tags($_REQUEST['m110r137']);
$m110r138 = strip_tags($_REQUEST['m110r138']);
$m110r139 = strip_tags($_REQUEST['m110r139']);
$m110r142 = strip_tags($_REQUEST['m110r142']);
$m110r143 = strip_tags($_REQUEST['m110r143']);
$m110r144 = strip_tags($_REQUEST['m110r144']);
$m110r145 = strip_tags($_REQUEST['m110r145']);
$m110r146 = strip_tags($_REQUEST['m110r146']);
$m110r147 = strip_tags($_REQUEST['m110r147']);
$m110r148 = strip_tags($_REQUEST['m110r148']);
$m110r149 = strip_tags($_REQUEST['m110r149']);
$m110r152 = strip_tags($_REQUEST['m110r152']);
$m110r153 = strip_tags($_REQUEST['m110r153']);
$m110r154 = strip_tags($_REQUEST['m110r154']);
$m110r155 = strip_tags($_REQUEST['m110r155']);
$m110r156 = strip_tags($_REQUEST['m110r156']);
$m110r157 = strip_tags($_REQUEST['m110r157']);
$m110r158 = strip_tags($_REQUEST['m110r158']);
$m110r159 = strip_tags($_REQUEST['m110r159']);
$m110r162 = strip_tags($_REQUEST['m110r162']);
$m110r163 = strip_tags($_REQUEST['m110r163']);
$m110r164 = strip_tags($_REQUEST['m110r164']);
$m110r165 = strip_tags($_REQUEST['m110r165']);
$m110r166 = strip_tags($_REQUEST['m110r166']);
$m110r167 = strip_tags($_REQUEST['m110r167']);
$m110r168 = strip_tags($_REQUEST['m110r168']);
$m110r169 = strip_tags($_REQUEST['m110r169']);
$m110r172 = strip_tags($_REQUEST['m110r172']);
$m110r173 = strip_tags($_REQUEST['m110r173']);
$m110r174 = strip_tags($_REQUEST['m110r174']);
$m110r175 = strip_tags($_REQUEST['m110r175']);
$m110r176 = strip_tags($_REQUEST['m110r176']);
$m110r177 = strip_tags($_REQUEST['m110r177']);
$m110r178 = strip_tags($_REQUEST['m110r178']);
$m110r179 = strip_tags($_REQUEST['m110r179']);
$m110r182 = strip_tags($_REQUEST['m110r182']);
$m110r183 = strip_tags($_REQUEST['m110r183']);
$m110r184 = strip_tags($_REQUEST['m110r184']);
$m110r185 = strip_tags($_REQUEST['m110r185']);
$m110r186 = strip_tags($_REQUEST['m110r186']);
$m110r187 = strip_tags($_REQUEST['m110r187']);
$m110r188 = strip_tags($_REQUEST['m110r188']);
$m110r189 = strip_tags($_REQUEST['m110r189']);
$m110r192 = strip_tags($_REQUEST['m110r192']);
$m110r193 = strip_tags($_REQUEST['m110r193']);
$m110r194 = strip_tags($_REQUEST['m110r194']);
$m110r195 = strip_tags($_REQUEST['m110r195']);
$m110r196 = strip_tags($_REQUEST['m110r196']);
$m110r197 = strip_tags($_REQUEST['m110r197']);
$m110r198 = strip_tags($_REQUEST['m110r198']);
$m110r199 = strip_tags($_REQUEST['m110r199']);
$m110r202 = strip_tags($_REQUEST['m110r202']);
$m110r203 = strip_tags($_REQUEST['m110r203']);
$m110r204 = strip_tags($_REQUEST['m110r204']);
$m110r205 = strip_tags($_REQUEST['m110r205']);
$m110r206 = strip_tags($_REQUEST['m110r206']);
$m110r207 = strip_tags($_REQUEST['m110r207']);
$m110r208 = strip_tags($_REQUEST['m110r208']);
$m110r209 = strip_tags($_REQUEST['m110r209']);
$m110r212 = strip_tags($_REQUEST['m110r212']);
$m110r213 = strip_tags($_REQUEST['m110r213']);
$m110r214 = strip_tags($_REQUEST['m110r214']);
$m110r215 = strip_tags($_REQUEST['m110r215']);
$m110r216 = strip_tags($_REQUEST['m110r216']);
$m110r217 = strip_tags($_REQUEST['m110r217']);
$m110r218 = strip_tags($_REQUEST['m110r218']);
$m110r219 = strip_tags($_REQUEST['m110r219']);
$m110r222 = strip_tags($_REQUEST['m110r222']);
//$m110r223 = strip_tags($_REQUEST['m110r223']);
$m110r224 = strip_tags($_REQUEST['m110r224']);
//$m110r225 = strip_tags($_REQUEST['m110r225']);
$m110r226 = strip_tags($_REQUEST['m110r226']);
//$m110r227 = strip_tags($_REQUEST['m110r227']);
$m110r228 = strip_tags($_REQUEST['m110r228']);
//$m110r229 = strip_tags($_REQUEST['m110r229']);
$m110r232 = strip_tags($_REQUEST['m110r232']);
//$m110r233 = strip_tags($_REQUEST['m110r233']);
$m110r234 = strip_tags($_REQUEST['m110r234']);
//$m110r235 = strip_tags($_REQUEST['m110r235']);
$m110r236 = strip_tags($_REQUEST['m110r236']);
//$m110r237 = strip_tags($_REQUEST['m110r237']);
$m110r238 = strip_tags($_REQUEST['m110r238']);
//$m110r239 = strip_tags($_REQUEST['m110r239']);
$m110r242 = strip_tags($_REQUEST['m110r242']);
$m110r243 = strip_tags($_REQUEST['m110r243']);
$m110r244 = strip_tags($_REQUEST['m110r244']);
$m110r245 = strip_tags($_REQUEST['m110r245']);
$m110r246 = strip_tags($_REQUEST['m110r246']);
$m110r247 = strip_tags($_REQUEST['m110r247']);
$m110r248 = strip_tags($_REQUEST['m110r248']);
$m110r249 = strip_tags($_REQUEST['m110r249']);
$m110r252 = strip_tags($_REQUEST['m110r252']);
$m110r253 = strip_tags($_REQUEST['m110r253']);
$m110r254 = strip_tags($_REQUEST['m110r254']);
$m110r255 = strip_tags($_REQUEST['m110r255']);
$m110r256 = strip_tags($_REQUEST['m110r256']);
$m110r257 = strip_tags($_REQUEST['m110r257']);
$m110r258 = strip_tags($_REQUEST['m110r258']);
$m110r259 = strip_tags($_REQUEST['m110r259']);
$m110r262 = strip_tags($_REQUEST['m110r262']);
$m110r263 = strip_tags($_REQUEST['m110r263']);
$m110r264 = strip_tags($_REQUEST['m110r264']);
$m110r265 = strip_tags($_REQUEST['m110r265']);
$m110r266 = strip_tags($_REQUEST['m110r266']);
$m110r267 = strip_tags($_REQUEST['m110r267']);
$m110r268 = strip_tags($_REQUEST['m110r268']);
$m110r269 = strip_tags($_REQUEST['m110r269']);
$m110r272 = strip_tags($_REQUEST['m110r272']);
$m110r273 = strip_tags($_REQUEST['m110r273']);
$m110r274 = strip_tags($_REQUEST['m110r274']);
$m110r275 = strip_tags($_REQUEST['m110r275']);
$m110r276 = strip_tags($_REQUEST['m110r276']);
$m110r277 = strip_tags($_REQUEST['m110r277']);
$m110r278 = strip_tags($_REQUEST['m110r278']);
$m110r279 = strip_tags($_REQUEST['m110r279']);
$m110r282 = strip_tags($_REQUEST['m110r282']);
$m110r283 = strip_tags($_REQUEST['m110r283']);
$m110r284 = strip_tags($_REQUEST['m110r284']);
$m110r285 = strip_tags($_REQUEST['m110r285']);
$m110r286 = strip_tags($_REQUEST['m110r286']);
$m110r287 = strip_tags($_REQUEST['m110r287']);
$m110r288 = strip_tags($_REQUEST['m110r288']);
$m110r289 = strip_tags($_REQUEST['m110r289']);
$m110r292 = strip_tags($_REQUEST['m110r292']);
$m110r293 = strip_tags($_REQUEST['m110r293']);
$m110r294 = strip_tags($_REQUEST['m110r294']);
$m110r295 = strip_tags($_REQUEST['m110r295']);
$m110r296 = strip_tags($_REQUEST['m110r296']);
$m110r297 = strip_tags($_REQUEST['m110r297']);
$m110r298 = strip_tags($_REQUEST['m110r298']);
$m110r299 = strip_tags($_REQUEST['m110r299']);
$m110r302 = strip_tags($_REQUEST['m110r302']);
$m110r303 = strip_tags($_REQUEST['m110r303']);
$m110r304 = strip_tags($_REQUEST['m110r304']);
$m110r305 = strip_tags($_REQUEST['m110r305']);
$m110r306 = strip_tags($_REQUEST['m110r306']);
$m110r307 = strip_tags($_REQUEST['m110r307']);
$m110r308 = strip_tags($_REQUEST['m110r308']);
$m110r309 = strip_tags($_REQUEST['m110r309']);
$m110r312 = strip_tags($_REQUEST['m110r312']);
$m110r313 = strip_tags($_REQUEST['m110r313']);
$m110r314 = strip_tags($_REQUEST['m110r314']);
$m110r315 = strip_tags($_REQUEST['m110r315']);
$m110r316 = strip_tags($_REQUEST['m110r316']);
$m110r317 = strip_tags($_REQUEST['m110r317']);
$m110r318 = strip_tags($_REQUEST['m110r318']);
$m110r319 = strip_tags($_REQUEST['m110r319']);
$m110r322 = strip_tags($_REQUEST['m110r322']);
$m110r323 = strip_tags($_REQUEST['m110r323']);
$m110r324 = strip_tags($_REQUEST['m110r324']);
$m110r325 = strip_tags($_REQUEST['m110r325']);
$m110r326 = strip_tags($_REQUEST['m110r326']);
$m110r327 = strip_tags($_REQUEST['m110r327']);
$m110r328 = strip_tags($_REQUEST['m110r328']);
$m110r329 = strip_tags($_REQUEST['m110r329']);
$m110r332 = strip_tags($_REQUEST['m110r332']);
//$m110r333 = strip_tags($_REQUEST['m110r333']);
$m110r334 = strip_tags($_REQUEST['m110r334']);
//$m110r335 = strip_tags($_REQUEST['m110r335']);
$m110r336 = strip_tags($_REQUEST['m110r336']);
//$m110r337 = strip_tags($_REQUEST['m110r337']);
$m110r338 = strip_tags($_REQUEST['m110r338']);
//$m110r339 = strip_tags($_REQUEST['m110r339']);
$m110r342 = strip_tags($_REQUEST['m110r342']);
//$m110r343 = strip_tags($_REQUEST['m110r343']);
$m110r344 = strip_tags($_REQUEST['m110r344']);
//$m110r345 = strip_tags($_REQUEST['m110r345']);
$m110r346 = strip_tags($_REQUEST['m110r346']);
//$m110r347 = strip_tags($_REQUEST['m110r347']);
$m110r348 = strip_tags($_REQUEST['m110r348']);
//$m110r349 = strip_tags($_REQUEST['m110r349']);
$m110r992 = strip_tags($_REQUEST['m110r992']);
$m110r993 = strip_tags($_REQUEST['m110r993']);
$m110r994 = strip_tags($_REQUEST['m110r994']);
$m110r995 = strip_tags($_REQUEST['m110r995']);
$m110r996 = strip_tags($_REQUEST['m110r996']);
$m110r997 = strip_tags($_REQUEST['m110r997']);
$m110r998 = strip_tags($_REQUEST['m110r998']);
$m110r999 = strip_tags($_REQUEST['m110r999']);
$uprav="NO";

if ( $strana == 1 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".
" odoslane='$odoslane_sql' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 2 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".
" m592r11='$m592r11', m592r12='$m592r12', m592r13='$m592r13', m592r14='$m592r14', m592r15='$m592r15', m592r16='$m592r16',
  m592r21='$m592r21', m592r22='$m592r22', m592r23='$m592r23', m592r24='$m592r24', m592r25='$m592r25', m592r26='$m592r26',
  m592r31='$m592r31', m592r32='$m592r32', m592r33='$m592r33', m592r34='$m592r34', m592r35='$m592r35', m592r36='$m592r36',
  m592r41='$m592r41', m592r42='$m592r42', m592r43='$m592r43', m592r44='$m592r44', m592r45='$m592r45', m592r46='$m592r46',
  m592r51='$m592r51', m592r52='$m592r52', m592r53='$m592r53', m592r54='$m592r54', m592r55='$m592r55', m592r56='$m592r56',
  m592r61='$m592r61', m592r62='$m592r62', m592r63='$m592r63', m592r64='$m592r64', m592r65='$m592r65', m592r66='$m592r66',
  m592r71='$m592r71', m592r72='$m592r72', m592r73='$m592r73', m592r74='$m592r74', m592r75='$m592r75', m592r76='$m592r76',
  m592r81='$m592r81', m592r82='$m592r82', m592r83='$m592r83', m592r84='$m592r84', m592r85='$m592r85', m592r86='$m592r86',
  m592r91='$m592r91', m592r92='$m592r92', m592r93='$m592r93', m592r94='$m592r94', m592r95='$m592r95', m592r96='$m592r96',
  m592r101='$m592r101', m592r102='$m592r102', m592r103='$m592r103', m592r104='$m592r104', m592r105='$m592r105', m592r106='$m592r106',
  m592r111='$m592r111', m592r112='$m592r112', m592r113='$m592r113', m592r114='$m592r114', m592r115='$m592r115', m592r116='$m592r116',
  m592r121='$m592r121', m592r122='$m592r122', m592r123='$m592r123', m592r124='$m592r124', m592r125='$m592r125', m592r126='$m592r126',
  m592r131='$m592r131', m592r132='$m592r132', m592r133='$m592r133', m592r134='$m592r134', m592r135='$m592r135', m592r136='$m592r136',
  m592r141='$m592r141', m592r142='$m592r142', m592r143='$m592r143', m592r144='$m592r144', m592r145='$m592r145', m592r146='$m592r146',
  m592r151='$m592r151', m592r152='$m592r152', m592r153='$m592r153', m592r154='$m592r154', m592r155='$m592r155', m592r156='$m592r156',
  m592r161='$m592r161', m592r162='$m592r162', m592r163='$m592r163', m592r164='$m592r164', m592r165='$m592r165', m592r166='$m592r166',
  m592r171='$m592r171', m592r172='$m592r172', m592r173='$m592r173', m592r174='$m592r174', m592r175='$m592r175', m592r176='$m592r176',
  m592r181='$m592r181', m592r182='$m592r182', m592r183='$m592r183', m592r184='$m592r184', m592r185='$m592r185', m592r186='$m592r186',
  m592r191='$m592r191', m592r192='$m592r192', m592r193='$m592r193', m592r194='$m592r194', m592r195='$m592r195', m592r196='$m592r196',
  m592r201='$m592r201', m592r202='$m592r202', m592r203='$m592r203', m592r204='$m592r204', m592r205='$m592r205', m592r206='$m592r206',
  m592r211='$m592r211', m592r212='$m592r212', m592r213='$m592r213', m592r214='$m592r214', m592r215='$m592r215', m592r216='$m592r216',
  m592r221='$m592r221', m592r222='$m592r222', m592r223='$m592r223', m592r224='$m592r224', m592r225='$m592r225', m592r226='$m592r226',
  m592r231='$m592r231', m592r232='$m592r232', m592r233='$m592r233', m592r234='$m592r234', m592r235='$m592r235', m592r236='$m592r236',
  m592r241='$m592r241', m592r242='$m592r242', m592r243='$m592r243', m592r244='$m592r244', m592r245='$m592r245', m592r246='$m592r246',
  m592r251='$m592r251', m592r252='$m592r252', m592r253='$m592r253', m592r254='$m592r254', m592r255='$m592r255', m592r256='$m592r256',
  m592r992='$m592r992', m592r993='$m592r993', m592r994='$m592r994', m592r995='$m592r995', m592r996='$m592r996' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 3 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".
" m177r1='$m177r1', m177r2='$m177r2', m177r3='$m177r3', m177r4='$m177r4', m177r5='$m177r5', m177r6='$m177r6',
  m177r7='$m177r7', m177r8='$m177r8', m177r9='$m177r9', m177r10='$m177r10', m177r99='$m177r99',
  m178r1='$m178r1', m178r2='$m178r2', m178r3='$m178r3', m178r4='$m178r4', m178r5='$m178r5', m178r6='$m178r6',
  m178r7='$m178r7', m178r8='$m178r8', m178r9='$m178r9', m178r10='$m178r10', m178r11='$m178r11', m178r12='$m178r12',
  m178r13='$m178r13', m178r14='$m178r14', m178r15='$m178r15', m178r16='$m178r16', m178r17='$m178r17', m178r18='$m178r18',
  m178r19='$m178r19', m178r99='$m178r99' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 4 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".
" m179r1='$m179r1', m179r2='$m179r2', m179r3='$m179r3', m179r4='$m179r4', m179r5='$m179r5', m179r6='$m179r6',
  m179r7='$m179r7', m179r8='$m179r8', m179r9='$m179r9', m179r99='$m179r99' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 5 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".
" m182r11='$m182r11', m182r12='$m182r12', m182r13='$m182r13', m182r14='$m182r14',
  m182r15='$m182r15', m182r16='$m182r16', m182r17='$m182r17',
  m182r21='$m182r21', m182r22='$m182r22', m182r23='$m182r23', m182r24='$m182r24',
  m182r25='$m182r25', m182r26='$m182r26', m182r27='$m182r27',
  m182r31='$m182r31', m182r32='$m182r32', m182r33='$m182r33', m182r34='$m182r34',
  m182r35='$m182r35', m182r36='$m182r36', m182r37='$m182r37',
  m182r41='$m182r41', m182r42='$m182r42', m182r43='$m182r43', m182r44='$m182r44',
  m182r45='$m182r45', m182r46='$m182r46', m182r47='$m182r47',
  m182r51='$m182r51', m182r52='$m182r52', m182r53='$m182r53', m182r54='$m182r54',
  m182r55='$m182r55', m182r56='$m182r56', m182r57='$m182r57',
  m182r61='$m182r61', m182r62='$m182r62', m182r63='$m182r63', m182r64='$m182r64',
  m182r65='$m182r65', m182r66='$m182r66', m182r67='$m182r67',
  m182r71='$m182r71', m182r72='$m182r72', m182r73='$m182r73', m182r74='$m182r74',
  m182r75='$m182r75', m182r76='$m182r76', m182r77='$m182r77',
  m182r81='$m182r81', m182r82='$m182r82', m182r83='$m182r83', m182r84='$m182r84',
  m182r85='$m182r85', m182r86='$m182r86', m182r87='$m182r87',
  m182r91='$m182r91', m182r92='$m182r92', m182r93='$m182r93', m182r94='$m182r94',
  m182r95='$m182r95', m182r96='$m182r96', m182r97='$m182r97',
  m182r101='$m182r101', m182r102='$m182r102', m182r103='$m182r103', m182r104='$m182r104',
  m182r105='$m182r105', m182r106='$m182r106', m182r107='$m182r107',
  m182r111='$m182r111', m182r112='$m182r112', m182r113='$m182r113', m182r114='$m182r114',
  m182r115='$m182r115', m182r116='$m182r116', m182r117='$m182r117',
  m182r121='$m182r121', m182r122='$m182r122', m182r123='$m182r123', m182r124='$m182r124',
  m182r125='$m182r125', m182r126='$m182r126', m182r127='$m182r127',
  m182r131='$m182r131', m182r132='$m182r132', m182r133='$m182r133', m182r134='$m182r134',
  m182r135='$m182r135', m182r136='$m182r136', m182r137='$m182r137',
  m182r141='$m182r141', m182r142='$m182r142', m182r143='$m182r143', m182r144='$m182r144',
  m182r145='$m182r145', m182r146='$m182r146', m182r147='$m182r147',
  m182r151='$m182r151', m182r152='$m182r152', m182r153='$m182r153', m182r154='$m182r154',
  m182r155='$m182r155', m182r156='$m182r156', m182r157='$m182r157',
  m182r161='$m182r161', m182r162='$m182r162', m182r163='$m182r163', m182r164='$m182r164',
  m182r165='$m182r165', m182r166='$m182r166', m182r167='$m182r167',
  m182r171='$m182r171', m182r172='$m182r172', m182r173='$m182r173', m182r174='$m182r174',
  m182r175='$m182r175', m182r176='$m182r176', m182r177='$m182r177',
  m182r181='$m182r181', m182r182='$m182r182', m182r183='$m182r183', m182r184='$m182r184',
  m182r185='$m182r185', m182r186='$m182r186', m182r187='$m182r187',
  m182r191='$m182r191', m182r192='$m182r192', m182r193='$m182r193', m182r194='$m182r194',
  m182r195='$m182r195', m182r196='$m182r196', m182r197='$m182r197',
  m182r201='$m182r201', m182r202='$m182r202', m182r203='$m182r203', m182r204='$m182r204',
  m182r205='$m182r205', m182r206='$m182r206', m182r207='$m182r207',
  m182r211='$m182r211', m182r212='$m182r212', m182r213='$m182r213', m182r214='$m182r214',
  m182r215='$m182r215', m182r216='$m182r216', m182r217='$m182r217',
  m182r221='$m182r221', m182r222='$m182r222', m182r223='$m182r223', m182r224='$m182r224',
  m182r225='$m182r225', m182r226='$m182r226', m182r227='$m182r227',
  m182r231='$m182r231', m182r232='$m182r232', m182r233='$m182r233', m182r234='$m182r234',
  m182r235='$m182r235', m182r236='$m182r236', m182r237='$m182r237',
  m182r241='$m182r241', m182r242='$m182r242', m182r243='$m182r243', m182r244='$m182r244',
  m182r245='$m182r245', m182r246='$m182r246', m182r247='$m182r247',
  m182r251='$m182r251', m182r252='$m182r252', m182r253='$m182r253', m182r254='$m182r254',
  m182r255='$m182r255', m182r256='$m182r256', m182r257='$m182r257',
  m182r261='$m182r261', m182r262='$m182r262', m182r263='$m182r263', m182r264='$m182r264',
  m182r265='$m182r265', m182r266='$m182r266', m182r267='$m182r267',
  m182r271='$m182r271', m182r272='$m182r272', m182r273='$m182r273', m182r274='$m182r274',
  m182r275='$m182r275', m182r276='$m182r276', m182r277='$m182r277',
  m182r281='$m182r281', m182r282='$m182r282', m182r283='$m182r283', m182r284='$m182r284',
  m182r285='$m182r285', m182r286='$m182r286', m182r287='$m182r287',
  m182r291='$m182r291', m182r292='$m182r292', m182r293='$m182r293', m182r294='$m182r294',
  m182r295='$m182r295', m182r296='$m182r296', m182r297='$m182r297',
  m182r301='$m182r301', m182r302='$m182r302', m182r303='$m182r303', m182r304='$m182r304',
  m182r305='$m182r305', m182r306='$m182r306', m182r307='$m182r307',
  m182r311='$m182r311', m182r312='$m182r312', m182r313='$m182r313', m182r314='$m182r314',
  m182r315='$m182r315', m182r316='$m182r316', m182r317='$m182r317',
  m182r321='$m182r321', m182r322='$m182r322', m182r323='$m182r323', m182r324='$m182r324',
  m182r325='$m182r325', m182r326='$m182r326', m182r327='$m182r327',
  m182r331='$m182r331', m182r332='$m182r332', m182r333='$m182r333', m182r334='$m182r334',
  m182r335='$m182r335', m182r336='$m182r336', m182r337='$m182r337',
  m182r992='$m182r992', m182r993='$m182r993', m182r994='$m182r994', m182r995='$m182r995',
  m182r996='$m182r996', m182r997='$m182r997' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 6 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".
" m183r11='$m183r11', m183r12='$m183r12', m183r13='$m183r13', m183r14='$m183r14', m183r21='$m183r21', m183r22='$m183r22',
  m183r23='$m183r23', m183r24='$m183r24', m183r31='$m183r31', m183r32='$m183r32', m183r33='$m183r33', m183r34='$m183r34',
  m183r41='$m183r41', m183r42='$m183r42', m183r43='$m183r43', m183r44='$m183r44', m183r51='$m183r51', m183r52='$m183r52',
  m183r53='$m183r53', m183r54='$m183r54', m183r61='$m183r61', m183r62='$m183r62', m183r63='$m183r63', m183r64='$m183r64',
  m183r71='$m183r71', m183r72='$m183r72', m183r73='$m183r73', m183r74='$m183r74', m183r81='$m183r81', m183r82='$m183r82',
  m183r83='$m183r83', m183r84='$m183r84', m183r91='$m183r91', m183r92='$m183r92', m183r93='$m183r93', m183r94='$m183r94',
  m183r101='$m183r101', m183r102='$m183r102', m183r103='$m183r103', m183r104='$m183r104', m183r111='$m183r111', m183r112='$m183r112',
  m183r113='$m183r113', m183r114='$m183r114', m183r121='$m183r121', m183r122='$m183r122', m183r123='$m183r123', m183r124='$m183r124',
  m183r131='$m183r131', m183r132='$m183r132', m183r133='$m183r133', m183r134='$m183r134', m183r141='$m183r141', m183r142='$m183r142',
  m183r143='$m183r143', m183r144='$m183r144', m183r151='$m183r151', m183r152='$m183r152', m183r153='$m183r153', m183r154='$m183r154',
  m183r161='$m183r161', m183r162='$m183r162', m183r163='$m183r163', m183r164='$m183r164', m183r171='$m183r171', m183r172='$m183r172',
  m183r173='$m183r173', m183r174='$m183r174', m183r181='$m183r181', m183r182='$m183r182', m183r183='$m183r183', m183r184='$m183r184',
  m183r191='$m183r191', m183r192='$m183r192', m183r193='$m183r193', m183r194='$m183r194', m183r201='$m183r201', m183r202='$m183r202',
  m183r203='$m183r203', m183r204='$m183r204', m183r211='$m183r211', m183r212='$m183r212', m183r213='$m183r213', m183r214='$m183r214',
  m183r221='$m183r221', m183r222='$m183r222', m183r223='$m183r223', m183r224='$m183r224', m183r231='$m183r231', m183r232='$m183r232',
  m183r233='$m183r233', m183r234='$m183r234', m183r241='$m183r241', m183r242='$m183r242', m183r243='$m183r243', m183r244='$m183r244',
  m183r251='$m183r251', m183r252='$m183r252', m183r253='$m183r253', m183r254='$m183r254', m183r261='$m183r261', m183r262='$m183r262',
  m183r263='$m183r263', m183r264='$m183r264', m183r271='$m183r271', m183r272='$m183r272', m183r273='$m183r273', m183r274='$m183r274',
  m183r281='$m183r281', m183r282='$m183r282', m183r283='$m183r283', m183r284='$m183r284', m183r291='$m183r291', m183r292='$m183r292',
  m183r293='$m183r293', m183r294='$m183r294', m183r301='$m183r301', m183r302='$m183r302', m183r303='$m183r303', m183r304='$m183r304',
  m183r992='$m183r992', m183r993='$m183r993', m183r994='$m183r994' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 7 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".
" m184r11='$m184r11', m184r12='$m184r12', m184r13='$m184r13', m184r14='$m184r14', m184r15='$m184r15', m184r16='$m184r16',
  m184r21='$m184r21', m184r22='$m184r22', m184r23='$m184r23', m184r24='$m184r24', m184r25='$m184r25', m184r26='$m184r26',
  m184r31='$m184r31', m184r32='$m184r32', m184r33='$m184r33', m184r34='$m184r34', m184r35='$m184r35', m184r36='$m184r36',
  m184r41='$m184r41', m184r42='$m184r42', m184r43='$m184r43', m184r44='$m184r44', m184r45='$m184r45', m184r46='$m184r46',
  m184r51='$m184r51', m184r52='$m184r52', m184r53='$m184r53', m184r54='$m184r54', m184r55='$m184r55', m184r56='$m184r56',
  m184r61='$m184r61', m184r62='$m184r62', m184r63='$m184r63', m184r64='$m184r64', m184r65='$m184r65', m184r66='$m184r66',
  m184r71='$m184r71', m184r72='$m184r72', m184r73='$m184r73', m184r74='$m184r74', m184r75='$m184r75', m184r76='$m184r76',
  m184r81='$m184r81', m184r82='$m184r82', m184r83='$m184r83', m184r84='$m184r84', m184r85='$m184r85', m184r86='$m184r86',
  m184r91='$m184r91', m184r92='$m184r92', m184r93='$m184r93', m184r94='$m184r94', m184r95='$m184r95', m184r96='$m184r96',
  m184r101='$m184r101', m184r102='$m184r102', m184r103='$m184r103', m184r104='$m184r104', m184r105='$m184r105', m184r106='$m184r106',
  m184r111='$m184r111', m184r112='$m184r112', m184r113='$m184r113', m184r114='$m184r114', m184r115='$m184r115', m184r116='$m184r116',
  m184r121='$m184r121', m184r122='$m184r122', m184r123='$m184r123', m184r124='$m184r124', m184r125='$m184r125', m184r126='$m184r126',
  m184r131='$m184r131', m184r132='$m184r132', m184r133='$m184r133', m184r134='$m184r134', m184r135='$m184r135', m184r136='$m184r136',
  m184r141='$m184r141', m184r142='$m184r142', m184r143='$m184r143', m184r144='$m184r144', m184r145='$m184r145', m184r146='$m184r146',
  m184r151='$m184r151', m184r152='$m184r152', m184r153='$m184r153', m184r154='$m184r154', m184r155='$m184r155', m184r156='$m184r156',
  m184r161='$m184r161', m184r162='$m184r162', m184r163='$m184r163', m184r164='$m184r164', m184r165='$m184r165', m184r166='$m184r166',
  m184r171='$m184r171', m184r172='$m184r172', m184r173='$m184r173', m184r174='$m184r174', m184r175='$m184r175', m184r176='$m184r176',
  m184r181='$m184r181', m184r182='$m184r182', m184r183='$m184r183', m184r184='$m184r184', m184r185='$m184r185', m184r186='$m184r186',
  m184r191='$m184r191', m184r192='$m184r192', m184r193='$m184r193', m184r194='$m184r194', m184r195='$m184r195', m184r196='$m184r196',
  m184r201='$m184r201', m184r202='$m184r202', m184r203='$m184r203', m184r204='$m184r204', m184r205='$m184r205', m184r206='$m184r206',
  m184r211='$m184r211', m184r212='$m184r212', m184r213='$m184r213', m184r214='$m184r214', m184r215='$m184r215', m184r216='$m184r216',
  m184r221='$m184r221', m184r222='$m184r222', m184r223='$m184r223', m184r224='$m184r224', m184r225='$m184r225', m184r226='$m184r226',
  m184r231='$m184r231', m184r232='$m184r232', m184r233='$m184r233', m184r234='$m184r234', m184r235='$m184r235', m184r236='$m184r236',
  m184r241='$m184r241', m184r242='$m184r242', m184r243='$m184r243', m184r244='$m184r244', m184r245='$m184r245', m184r246='$m184r246',
  m184r251='$m184r251', m184r252='$m184r252', m184r253='$m184r253', m184r254='$m184r254', m184r255='$m184r255', m184r256='$m184r256',
  m184r261='$m184r261', m184r262='$m184r262', m184r263='$m184r263', m184r264='$m184r264', m184r265='$m184r265', m184r266='$m184r266',
  m184r271='$m184r271', m184r272='$m184r272', m184r273='$m184r273', m184r274='$m184r274', m184r275='$m184r275', m184r276='$m184r276',
  m184r281='$m184r281', m184r282='$m184r282', m184r283='$m184r283', m184r284='$m184r284', m184r285='$m184r285', m184r286='$m184r286',
  m184r291='$m184r291', m184r292='$m184r292', m184r293='$m184r293', m184r294='$m184r294', m184r295='$m184r295', m184r296='$m184r296',
  m184r301='$m184r301', m184r302='$m184r302', m184r303='$m184r303', m184r304='$m184r304', m184r305='$m184r305', m184r306='$m184r306',
  m184r311='$m184r311', m184r312='$m184r312', m184r313='$m184r313', m184r314='$m184r314', m184r315='$m184r315', m184r316='$m184r316',
  m184r321='$m184r321', m184r322='$m184r322', m184r323='$m184r323', m184r324='$m184r324', m184r325='$m184r325', m184r326='$m184r326',
  m184r992='$m184r992', m184r993='$m184r993', m184r994='$m184r994', m184r995='$m184r995', m184r996='$m184r996' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 8 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".
" m185r11='$m185r11', m185r12='$m185r12', m185r13='$m185r13', m185r14='$m185r14', m185r15='$m185r15', m185r16='$m185r16', m185r17='$m185r17',
  m185r21='$m185r21', m185r22='$m185r22', m185r23='$m185r23', m185r24='$m185r24', m185r25='$m185r25', m185r26='$m185r26', m185r27='$m185r27',
  m185r31='$m185r31', m185r32='$m185r32', m185r33='$m185r33', m185r34='$m185r34', m185r35='$m185r35', m185r36='$m185r36', m185r37='$m185r37',
  m185r41='$m185r41', m185r42='$m185r42', m185r43='$m185r43', m185r44='$m185r44', m185r45='$m185r45', m185r46='$m185r46', m185r47='$m185r47',
  m185r51='$m185r51', m185r52='$m185r52', m185r53='$m185r53', m185r54='$m185r54', m185r55='$m185r55', m185r56='$m185r56', m185r57='$m185r57',
  m185r61='$m185r61', m185r62='$m185r62', m185r63='$m185r63', m185r64='$m185r64', m185r65='$m185r65', m185r66='$m185r66', m185r67='$m185r67',
  m185r71='$m185r71', m185r72='$m185r72', m185r73='$m185r73', m185r74='$m185r74', m185r75='$m185r75', m185r76='$m185r76', m185r77='$m185r77',
  m185r81='$m185r81', m185r82='$m185r82', m185r83='$m185r83', m185r84='$m185r84', m185r85='$m185r85', m185r86='$m185r86', m185r87='$m185r87',
  m185r91='$m185r91', m185r92='$m185r92', m185r93='$m185r93', m185r94='$m185r94', m185r95='$m185r95', m185r96='$m185r96', m185r97='$m185r97',
  m185r101='$m185r101', m185r102='$m185r102', m185r103='$m185r103', m185r104='$m185r104', m185r105='$m185r105', m185r106='$m185r106', m185r107='$m185r107',
  m185r111='$m185r111', m185r112='$m185r112', m185r113='$m185r113', m185r114='$m185r114', m185r115='$m185r115', m185r116='$m185r116', m185r117='$m185r117',
  m185r121='$m185r121', m185r122='$m185r122', m185r123='$m185r123', m185r124='$m185r124', m185r125='$m185r125', m185r126='$m185r126', m185r127='$m185r127',
  m185r131='$m185r131', m185r132='$m185r132', m185r133='$m185r133', m185r134='$m185r134', m185r135='$m185r135', m185r136='$m185r136', m185r137='$m185r137',
  m185r141='$m185r141', m185r142='$m185r142', m185r143='$m185r143', m185r144='$m185r144', m185r145='$m185r145', m185r146='$m185r146', m185r147='$m185r147',
  m185r151='$m185r151', m185r152='$m185r152', m185r153='$m185r153', m185r154='$m185r154', m185r155='$m185r155', m185r156='$m185r156', m185r157='$m185r157',
  m185r161='$m185r161', m185r162='$m185r162', m185r163='$m185r163', m185r164='$m185r164', m185r165='$m185r165', m185r166='$m185r166', m185r167='$m185r167',
  m185r171='$m185r171', m185r172='$m185r172', m185r173='$m185r173', m185r174='$m185r174', m185r175='$m185r175', m185r176='$m185r176', m185r177='$m185r177',
  m185r181='$m185r181', m185r182='$m185r182', m185r183='$m185r183', m185r184='$m185r184', m185r185='$m185r185', m185r186='$m185r186', m185r187='$m185r187',
  m185r191='$m185r191', m185r192='$m185r192', m185r193='$m185r193', m185r194='$m185r194', m185r195='$m185r195', m185r196='$m185r196', m185r197='$m185r197',
  m185r201='$m185r201', m185r202='$m185r202', m185r203='$m185r203', m185r204='$m185r204', m185r205='$m185r205', m185r206='$m185r206', m185r207='$m185r207',
  m185r211='$m185r211', m185r212='$m185r212', m185r213='$m185r213', m185r214='$m185r214', m185r215='$m185r215', m185r216='$m185r216', m185r217='$m185r217',
  m185r221='$m185r221', m185r222='$m185r222', m185r223='$m185r223', m185r224='$m185r224', m185r225='$m185r225', m185r226='$m185r226', m185r227='$m185r227',
  m185r231='$m185r231', m185r232='$m185r232', m185r233='$m185r233', m185r234='$m185r234', m185r235='$m185r235', m185r236='$m185r236', m185r237='$m185r237',
  m185r241='$m185r241', m185r242='$m185r242', m185r243='$m185r243', m185r244='$m185r244', m185r245='$m185r245', m185r246='$m185r246', m185r247='$m185r247',
  m185r251='$m185r251', m185r252='$m185r252', m185r253='$m185r253', m185r254='$m185r254', m185r255='$m185r255', m185r256='$m185r256', m185r257='$m185r257',
  m185r261='$m185r261', m185r262='$m185r262', m185r263='$m185r263', m185r264='$m185r264', m185r265='$m185r265', m185r266='$m185r266', m185r267='$m185r267',
  m185r271='$m185r271', m185r272='$m185r272', m185r273='$m185r273', m185r274='$m185r274', m185r275='$m185r275', m185r276='$m185r276', m185r277='$m185r277',
  m185r281='$m185r281', m185r282='$m185r282', m185r283='$m185r283', m185r284='$m185r284', m185r285='$m185r285', m185r286='$m185r286', m185r287='$m185r287',
  m185r291='$m185r291', m185r292='$m185r292', m185r293='$m185r293', m185r294='$m185r294', m185r295='$m185r295', m185r296='$m185r296', m185r297='$m185r297',
  m185r301='$m185r301', m185r302='$m185r302', m185r303='$m185r303', m185r304='$m185r304', m185r305='$m185r305', m185r306='$m185r306', m185r307='$m185r307',
  m185r992='$m185r992', m185r993='$m185r993', m185r994='$m185r994', m185r995='$m185r995', m185r996='$m185r996', m185r997='$m185r997' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 9 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101s2 SET ".
" m186r11='$m186r11', m186r12='$m186r12', m186r13='$m186r13', m186r14='$m186r14', m186r15='$m186r15', m186r16='$m186r16', m186r17='$m186r17',
  m186r21='$m186r21', m186r22='$m186r22', m186r23='$m186r23', m186r24='$m186r24', m186r25='$m186r25', m186r26='$m186r26', m186r27='$m186r27',
  m186r31='$m186r31', m186r32='$m186r32', m186r33='$m186r33', m186r34='$m186r34', m186r35='$m186r35', m186r36='$m186r36', m186r37='$m186r37',
  m186r41='$m186r41', m186r42='$m186r42', m186r43='$m186r43', m186r44='$m186r44', m186r45='$m186r45', m186r46='$m186r46', m186r47='$m186r47',
  m186r51='$m186r51', m186r52='$m186r52', m186r53='$m186r53', m186r54='$m186r54', m186r55='$m186r55', m186r56='$m186r56', m186r57='$m186r57',
  m186r61='$m186r61', m186r62='$m186r62', m186r63='$m186r63', m186r64='$m186r64', m186r65='$m186r65', m186r66='$m186r66', m186r67='$m186r67',
  m186r71='$m186r71', m186r72='$m186r72', m186r73='$m186r73', m186r74='$m186r74', m186r75='$m186r75', m186r76='$m186r76', m186r77='$m186r77',
  m186r81='$m186r81', m186r82='$m186r82', m186r83='$m186r83', m186r84='$m186r84', m186r85='$m186r85', m186r86='$m186r86', m186r87='$m186r87',
  m186r91='$m186r91', m186r92='$m186r92', m186r93='$m186r93', m186r94='$m186r94', m186r95='$m186r95', m186r96='$m186r96', m186r97='$m186r97',
  m186r101='$m186r101', m186r102='$m186r102', m186r103='$m186r103', m186r104='$m186r104', m186r105='$m186r105', m186r106='$m186r106', m186r107='$m186r107',
  m186r111='$m186r111', m186r112='$m186r112', m186r113='$m186r113', m186r114='$m186r114', m186r115='$m186r115', m186r116='$m186r116', m186r117='$m186r117',
  m186r121='$m186r121', m186r122='$m186r122', m186r123='$m186r123', m186r124='$m186r124', m186r125='$m186r125', m186r126='$m186r126', m186r127='$m186r127',
  m186r131='$m186r131', m186r132='$m186r132', m186r133='$m186r133', m186r134='$m186r134', m186r135='$m186r135', m186r136='$m186r136', m186r137='$m186r137',
  m186r141='$m186r141', m186r142='$m186r142', m186r143='$m186r143', m186r144='$m186r144', m186r145='$m186r145', m186r146='$m186r146', m186r147='$m186r147',
  m186r151='$m186r151', m186r152='$m186r152', m186r153='$m186r153', m186r154='$m186r154', m186r155='$m186r155', m186r156='$m186r156', m186r157='$m186r157',
  m186r161='$m186r161', m186r162='$m186r162', m186r163='$m186r163', m186r164='$m186r164', m186r165='$m186r165', m186r166='$m186r166', m186r167='$m186r167',
  m186r171='$m186r171', m186r172='$m186r172', m186r173='$m186r173', m186r174='$m186r174', m186r175='$m186r175', m186r176='$m186r176', m186r177='$m186r177',
  m186r181='$m186r181', m186r182='$m186r182', m186r183='$m186r183', m186r184='$m186r184', m186r185='$m186r185', m186r186='$m186r186', m186r187='$m186r187',
  m186r191='$m186r191', m186r192='$m186r192', m186r193='$m186r193', m186r194='$m186r194', m186r195='$m186r195', m186r196='$m186r196', m186r197='$m186r197',
  m186r201='$m186r201', m186r202='$m186r202', m186r203='$m186r203', m186r204='$m186r204', m186r205='$m186r205', m186r206='$m186r206', m186r207='$m186r207',
  m186r211='$m186r211', m186r212='$m186r212', m186r213='$m186r213', m186r214='$m186r214', m186r215='$m186r215', m186r216='$m186r216', m186r217='$m186r217',
  m186r221='$m186r221', m186r222='$m186r222', m186r223='$m186r223', m186r224='$m186r224', m186r225='$m186r225', m186r226='$m186r226', m186r227='$m186r227',
  m186r231='$m186r231', m186r232='$m186r232', m186r233='$m186r233', m186r234='$m186r234', m186r235='$m186r235', m186r236='$m186r236', m186r237='$m186r237',
  m186r241='$m186r241', m186r242='$m186r242', m186r243='$m186r243', m186r244='$m186r244', m186r245='$m186r245', m186r246='$m186r246', m186r247='$m186r247',
  m186r251='$m186r251', m186r252='$m186r252', m186r253='$m186r253', m186r254='$m186r254', m186r255='$m186r255', m186r256='$m186r256', m186r257='$m186r257',
  m186r261='$m186r261', m186r262='$m186r262', m186r263='$m186r263', m186r264='$m186r264', m186r265='$m186r265', m186r266='$m186r266', m186r267='$m186r267',
  m186r271='$m186r271', m186r272='$m186r272', m186r273='$m186r273', m186r274='$m186r274', m186r275='$m186r275', m186r276='$m186r276', m186r277='$m186r277',
  m186r281='$m186r281', m186r282='$m186r282', m186r283='$m186r283', m186r284='$m186r284', m186r285='$m186r285', m186r286='$m186r286', m186r287='$m186r287',
  m186r291='$m186r291', m186r292='$m186r292', m186r293='$m186r293', m186r294='$m186r294', m186r295='$m186r295', m186r296='$m186r296', m186r297='$m186r297',
  m186r301='$m186r301', m186r302='$m186r302', m186r303='$m186r303', m186r304='$m186r304', m186r305='$m186r305', m186r306='$m186r306', m186r307='$m186r307',
  m186r992='$m186r992', m186r993='$m186r993', m186r994='$m186r994', m186r995='$m186r995', m186r996='$m186r996', m186r997='$m186r997' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 10 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101s2 SET ".
" m187r1='$m187r1', m1590r1a='$m1590r1a', m1590r1b='$m1590r1b', m1590r2a='$m1590r2a', m1590r2b='$m1590r2b', ".
" m590r11='$m590r11', m590r12='$m590r12', m590r13='$m590r13', m590r14='$m590r14', m590r15='$m590r15',
  m590r21='$m590r21', m590r22='$m590r22', m590r23='$m590r23', m590r24='$m590r24', m590r25='$m590r25',
  m590r31='$m590r31', m590r32='$m590r32', m590r33='$m590r33', m590r34='$m590r34', m590r35='$m590r35',
  m590r41='$m590r41', m590r42='$m590r42', m590r43='$m590r43', m590r44='$m590r44', m590r45='$m590r45',
  m590r51='$m590r51', m590r52='$m590r52', m590r53='$m590r53', m590r54='$m590r54', m590r55='$m590r55',
  m590r61='$m590r61', m590r62='$m590r62', m590r63='$m590r63', m590r64='$m590r64', m590r65='$m590r65',
  m590r71='$m590r71', m590r72='$m590r72', m590r73='$m590r73', m590r74='$m590r74', m590r75='$m590r75',
  m590r81='$m590r81', m590r82='$m590r82', m590r83='$m590r83', m590r84='$m590r84', m590r85='$m590r85',
  m590r91='$m590r91', m590r92='$m590r92', m590r93='$m590r93', m590r94='$m590r94', m590r95='$m590r95',
  m590r101='$m590r101', m590r102='$m590r102', m590r103='$m590r103', m590r104='$m590r104', m590r105='$m590r105',
  m590r111='$m590r111', m590r112='$m590r112', m590r113='$m590r113', m590r114='$m590r114', m590r115='$m590r115',
  m590r121='$m590r121', m590r122='$m590r122', m590r123='$m590r123', m590r124='$m590r124', m590r125='$m590r125',
  m590r131='$m590r131', m590r132='$m590r132', m590r133='$m590r133', m590r134='$m590r134', m590r135='$m590r135',
  m590r141='$m590r141', m590r142='$m590r142', m590r143='$m590r143', m590r144='$m590r144', m590r145='$m590r145',
  m590r151='$m590r151', m590r152='$m590r152', m590r153='$m590r153', m590r154='$m590r154', m590r155='$m590r155',
  m590r161='$m590r161', m590r162='$m590r162', m590r163='$m590r163', m590r164='$m590r164', m590r165='$m590r165',
  m590r171='$m590r171', m590r172='$m590r172', m590r173='$m590r173', m590r174='$m590r174', m590r175='$m590r175',
  m590r181='$m590r181', m590r182='$m590r182', m590r183='$m590r183', m590r184='$m590r184', m590r185='$m590r185',
  m590r191='$m590r191', m590r192='$m590r192', m590r193='$m590r193', m590r194='$m590r194', m590r195='$m590r195',
  m590r201='$m590r201', m590r202='$m590r202', m590r203='$m590r203', m590r204='$m590r204', m590r205='$m590r205',
  m590r992='$m590r992', m590r993='$m590r993', m590r994='$m590r994', m590r995='$m590r995' ".
" WHERE ico >= 0 ";
                     }

if ( $strana == 11 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101s2 SET ".
" m304r1='$m304r1', m304r2='$m304r2', m304r3='$m304r3', m304r4='$m304r4', m304r5='$m304r5', m304r6='$m304r6', m304r7='$m304r7',
  m304r8='$m304r8', m304r9='$m304r9', m304r10='$m304r10', m304r11='$m304r11', m304r12='$m304r12', m304r13='$m304r13',
  m304r14='$m304r14', m304r15='$m304r15', m304r16='$m304r16', m304r99='$m304r99' ".
" WHERE ico >= 0 ";
                     }

if ( $strana == 12 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101s2 SET ".
" m110r12='$m110r12', m110r13='$m110r13', m110r14='$m110r14', m110r15='$m110r15', m110r16='$m110r16',
  m110r17='$m110r17', m110r18='$m110r18', m110r19='$m110r19',
  m110r22='$m110r22', m110r23='$m110r23', m110r24='$m110r24', m110r25='$m110r25', m110r26='$m110r26',
  m110r27='$m110r27', m110r28='$m110r28', m110r29='$m110r29',
  m110r32='$m110r32', m110r33='$m110r33', m110r34='$m110r34', m110r35='$m110r35', m110r36='$m110r36',
  m110r37='$m110r37', m110r38='$m110r38', m110r39='$m110r39',
  m110r42='$m110r42', m110r43='$m110r43', m110r44='$m110r44', m110r45='$m110r45', m110r46='$m110r46',
  m110r47='$m110r47', m110r48='$m110r48', m110r49='$m110r49',
  m110r52='$m110r52', m110r53='$m110r53', m110r54='$m110r54', m110r55='$m110r55', m110r56='$m110r56',
  m110r57='$m110r57', m110r58='$m110r58', m110r59='$m110r59',
  m110r62='$m110r62', m110r63='$m110r63', m110r64='$m110r64', m110r65='$m110r65', m110r66='$m110r66',
  m110r67='$m110r67', m110r68='$m110r68', m110r69='$m110r69',
  m110r72='$m110r72', m110r73='$m110r73', m110r74='$m110r74', m110r75='$m110r75', m110r76='$m110r76',
  m110r77='$m110r77', m110r78='$m110r78', m110r79='$m110r79',
  m110r82='$m110r82', m110r83='$m110r83', m110r84='$m110r84', m110r85='$m110r85', m110r86='$m110r86',
  m110r87='$m110r87', m110r88='$m110r88', m110r89='$m110r89',
  m110r92='$m110r92', m110r93='$m110r93', m110r94='$m110r94', m110r95='$m110r95', m110r96='$m110r96',
  m110r97='$m110r97', m110r98='$m110r98', m110r99='$m110r99',
  m110r102='$m110r102', m110r103='$m110r103', m110r104='$m110r104', m110r105='$m110r105', m110r106='$m110r106',
  m110r107='$m110r107', m110r108='$m110r108', m110r109='$m110r109',
  m110r112='$m110r112', m110r113='$m110r113', m110r114='$m110r114', m110r115='$m110r115', m110r116='$m110r116',
  m110r117='$m110r117', m110r118='$m110r118', m110r119='$m110r119',
  m110r122='$m110r122', m110r123='$m110r123', m110r124='$m110r124', m110r125='$m110r125', m110r126='$m110r126',
  m110r127='$m110r127', m110r128='$m110r128', m110r129='$m110r129',
  m110r132='$m110r132', m110r133='$m110r133', m110r134='$m110r134', m110r135='$m110r135', m110r136='$m110r136',
  m110r137='$m110r137', m110r138='$m110r138', m110r139='$m110r139',
  m110r142='$m110r142', m110r143='$m110r143', m110r144='$m110r144', m110r145='$m110r145', m110r146='$m110r146',
  m110r147='$m110r147', m110r148='$m110r148', m110r149='$m110r149',
  m110r152='$m110r152', m110r153='$m110r153', m110r154='$m110r154', m110r155='$m110r155', m110r156='$m110r156',
  m110r157='$m110r157', m110r158='$m110r158', m110r159='$m110r159',
  m110r162='$m110r162', m110r163='$m110r163', m110r164='$m110r164', m110r165='$m110r165', m110r166='$m110r166',
  m110r167='$m110r167', m110r168='$m110r168', m110r169='$m110r169',
  m110r172='$m110r172', m110r173='$m110r173', m110r174='$m110r174', m110r175='$m110r175', m110r176='$m110r176',
  m110r177='$m110r177', m110r178='$m110r178', m110r179='$m110r179',
  m110r182='$m110r182', m110r183='$m110r183', m110r184='$m110r184', m110r185='$m110r185', m110r186='$m110r186',
  m110r187='$m110r187', m110r188='$m110r188', m110r189='$m110r189',
  m110r192='$m110r192', m110r193='$m110r193', m110r194='$m110r194', m110r195='$m110r195', m110r196='$m110r196',
  m110r197='$m110r197', m110r198='$m110r198', m110r199='$m110r199',
  m110r202='$m110r202', m110r203='$m110r203', m110r204='$m110r204', m110r205='$m110r205', m110r206='$m110r206',
  m110r207='$m110r207', m110r208='$m110r208', m110r209='$m110r209',
  m110r212='$m110r212', m110r213='$m110r213', m110r214='$m110r214', m110r215='$m110r215', m110r216='$m110r216',
  m110r217='$m110r217', m110r218='$m110r218', m110r219='$m110r219',
  m110r222='$m110r222', m110r224='$m110r224', m110r226='$m110r226', m110r228='$m110r228',
  m110r232='$m110r232', m110r234='$m110r234', m110r236='$m110r236', m110r238='$m110r238',
  m110r242='$m110r242', m110r243='$m110r243', m110r244='$m110r244', m110r245='$m110r245', m110r246='$m110r246',
  m110r247='$m110r247', m110r248='$m110r248', m110r249='$m110r249',
  m110r252='$m110r252', m110r253='$m110r253', m110r254='$m110r254', m110r255='$m110r255', m110r256='$m110r256',
  m110r257='$m110r257', m110r258='$m110r258', m110r259='$m110r259',
  m110r262='$m110r262', m110r263='$m110r263', m110r264='$m110r264', m110r265='$m110r265', m110r266='$m110r266',
  m110r267='$m110r267', m110r268='$m110r268', m110r269='$m110r269',
  m110r272='$m110r272', m110r273='$m110r273', m110r274='$m110r274', m110r275='$m110r275', m110r276='$m110r276',
  m110r277='$m110r277', m110r278='$m110r278', m110r279='$m110r279',
  m110r282='$m110r282', m110r283='$m110r283', m110r284='$m110r284', m110r285='$m110r285', m110r286='$m110r286',
  m110r287='$m110r287', m110r288='$m110r288', m110r289='$m110r289',
  m110r292='$m110r292', m110r293='$m110r293', m110r294='$m110r294', m110r295='$m110r295', m110r296='$m110r296',
  m110r297='$m110r297', m110r298='$m110r298', m110r299='$m110r299',
  m110r302='$m110r302', m110r303='$m110r303', m110r304='$m110r304', m110r305='$m110r305', m110r306='$m110r306',
  m110r307='$m110r307', m110r308='$m110r308', m110r309='$m110r309',
  m110r312='$m110r312', m110r313='$m110r313', m110r314='$m110r314', m110r315='$m110r315', m110r316='$m110r316',
  m110r317='$m110r317', m110r318='$m110r318', m110r319='$m110r319',
  m110r322='$m110r322', m110r323='$m110r323', m110r324='$m110r324', m110r325='$m110r325', m110r326='$m110r326',
  m110r327='$m110r327', m110r328='$m110r328', m110r329='$m110r329',
  m110r332='$m110r332', m110r334='$m110r334', m110r336='$m110r336', m110r338='$m110r338',
  m110r342='$m110r342', m110r344='$m110r344', m110r346='$m110r346', m110r348='$m110r348',
  m110r992='$m110r992', m110r993='$m110r993', m110r994='$m110r994', m110r995='$m110r995', m110r996='$m110r996',
  m110r997='$m110r997', m110r998='$m110r998', m110r999='$m110r999' ".
" WHERE ico >= 0 ";
                     }

//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
$copern=102;
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


//vypocty
//2.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".

" m592r996=m592r16+m592r26+m592r36+m592r46+m592r56+m592r66+m592r76+m592r86+m592r96+m592r106+m592r116+m592r126+m592r136+m592r146+m592r156+m592r166+m592r176+m592r186+m592r196+m592r206+m592r216+m592r226+m592r236+m592r246+m592r256, ".
" m592r995=m592r15+m592r25+m592r35+m592r45+m592r55+m592r65+m592r75+m592r85+m592r95+m592r105+m592r115+m592r125+m592r135+m592r145+m592r155+m592r165+m592r175+m592r185+m592r195+m592r205+m592r215+m592r225+m592r235+m592r245+m592r255, ".
" m592r994=m592r14+m592r24+m592r34+m592r44+m592r54+m592r64+m592r74+m592r84+m592r94+m592r104+m592r114+m592r124+m592r134+m592r144+m592r154+m592r164+m592r174+m592r184+m592r194+m592r204+m592r214+m592r224+m592r234+m592r244+m592r254, ".
" m592r993=m592r13+m592r23+m592r33+m592r43+m592r53+m592r63+m592r73+m592r83+m592r93+m592r103+m592r113+m592r123+m592r133+m592r143+m592r153+m592r163+m592r173+m592r183+m592r193+m592r203+m592r213+m592r223+m592r233+m592r243+m592r253, ".
" m592r992=m592r12+m592r22+m592r32+m592r42+m592r52+m592r62+m592r72+m592r82+m592r92+m592r102+m592r112+m592r122+m592r132+m592r142+m592r152+m592r162+m592r172+m592r182+m592r192+m592r202+m592r212+m592r222+m592r232+m592r242+m592r252  ";
$upravene = mysql_query("$uprtxt");

//3.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".
" m177r9=m177r1+m177r2+m177r3+m177r4-m177r5-m177r6+m177r7+m177r8, ".
" m177r99=m177r1+m177r2+m177r3+m177r4+m177r5+m177r6+m177r7+m177r8+m177r9+m177r10 ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".
" m178r7=m178r1+m178r2+m178r3+m178r4+m178r5+m178r6, ".
" m178r99=m178r1+m178r2+m178r3+m178r4+m178r5+m178r6+m178r7+m178r8+m178r9+m178r10+m178r11+m178r12+m178r13+m178r14+m178r15+m178r16+m178r17+m178r18+m178r19 ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");

//4.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".
" m179r99=m179r1+m179r2+m179r3+m179r4+m179r5+m179r6+m179r7+m179r8+m179r9 ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");

//5.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".

" m182r997=m182r17+m182r27+m182r37+m182r47+m182r57+m182r67+m182r77+m182r87+m182r97+m182r107+m182r117+m182r127+m182r137+m182r147+m182r157+m182r167".
"+m182r177+m182r187+m182r197+m182r207+m182r217+m182r227+m182r237+m182r247+m182r257+m182r267".
"+m182r277+m182r287+m182r297+m182r307+m182r317+m182r327+m182r337, ".
" m182r996=m182r16+m182r26+m182r36+m182r46+m182r56+m182r66+m182r76+m182r86+m182r96+m182r106+m182r116+m182r126+m182r136+m182r146+m182r156+m182r166".
"+m182r176+m182r186+m182r196+m182r206+m182r216+m182r226+m182r236+m182r246+m182r256+m182r266".
"+m182r276+m182r286+m182r296+m182r306+m182r316+m182r326+m182r336, ".
" m182r995=m182r15+m182r25+m182r35+m182r45+m182r55+m182r65+m182r75+m182r85+m182r95+m182r105+m182r115+m182r125+m182r135+m182r145+m182r155+m182r165".
"+m182r175+m182r185+m182r195+m182r205+m182r215+m182r225+m182r235+m182r245+m182r255+m182r265".
"+m182r275+m182r285+m182r295+m182r305+m182r315+m182r325+m182r335, ".
" m182r994=m182r14+m182r24+m182r34+m182r44+m182r54+m182r64+m182r74+m182r84+m182r94+m182r104+m182r114+m182r124+m182r134+m182r144+m182r154+m182r164".
"+m182r174+m182r184+m182r194+m182r204+m182r214+m182r224+m182r234+m182r244+m182r254+m182r264".
"+m182r274+m182r284+m182r294+m182r304+m182r314+m182r324+m182r334, ".
" m182r993=m182r13+m182r23+m182r33+m182r43+m182r53+m182r63+m182r73+m182r83+m182r93+m182r103+m182r113+m182r123+m182r133+m182r143+m182r153+m182r163".
"+m182r173+m182r183+m182r193+m182r203+m182r213+m182r223+m182r233+m182r243+m182r253+m182r263".
"+m182r273+m182r283+m182r293+m182r303+m182r313+m182r323+m182r333, ".
" m182r992=m182r12+m182r22+m182r32+m182r42+m182r52+m182r62+m182r72+m182r82+m182r92+m182r102+m182r112+m182r122+m182r132+m182r142+m182r152+m182r162".
"+m182r172+m182r182+m182r192+m182r202+m182r212+m182r222+m182r232+m182r242+m182r252+m182r262".
"+m182r272+m182r282+m182r292+m182r302+m182r312+m182r322+m182r332  ";
$upravene = mysql_query("$uprtxt");


//6.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".

" m183r994=m183r14+m183r24+m183r34+m183r44+m183r54+m183r64+m183r74+m183r84+m183r94+m183r104+m183r114+m183r124+m183r134+m183r144+m183r154+m183r164".
"+m183r174+m183r184+m183r194+m183r204+m183r214+m183r224+m183r234+m183r244+m183r254+m183r264".
"+m183r274+m183r284+m183r294+m183r304, ".
" m183r993=m183r13+m183r23+m183r33+m183r43+m183r53+m183r63+m183r73+m183r83+m183r93+m183r103+m183r113+m183r123+m183r133+m183r143+m183r153+m183r163".
"+m183r173+m183r183+m183r193+m183r203+m183r213+m183r223+m183r233+m183r243+m183r253+m183r263".
"+m183r273+m183r283+m183r293+m183r303, ".
" m183r992=m183r12+m183r22+m183r32+m183r42+m183r52+m183r62+m183r72+m183r82+m183r92+m183r102+m183r112+m183r122+m183r132+m183r142+m183r152+m183r162".
"+m183r172+m183r182+m183r192+m183r202+m183r212+m183r222+m183r232+m183r242+m183r252+m183r262".
"+m183r272+m183r282+m183r292+m183r302  ";
$upravene = mysql_query("$uprtxt");

//7.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".

" m184r996=m184r16+m184r26+m184r36+m184r46+m184r56+m184r66+m184r76+m184r86+m184r96+m184r106+m184r116+m184r126+m184r136+m184r146+m184r156+m184r166".
"+m184r176+m184r186+m184r196+m184r206+m184r216+m184r226+m184r236+m184r246+m184r256+m184r266".
"+m184r276+m184r286+m184r296+m184r306+m184r316+m184r326, ".
" m184r995=m184r15+m184r25+m184r35+m184r45+m184r55+m184r65+m184r75+m184r85+m184r95+m184r105+m184r115+m184r125+m184r135+m184r145+m184r155+m184r165".
"+m184r175+m184r185+m184r195+m184r205+m184r215+m184r225+m184r235+m184r245+m184r255+m184r265".
"+m184r275+m184r285+m184r295+m184r305+m184r315+m184r325, ".
" m184r994=m184r14+m184r24+m184r34+m184r44+m184r54+m184r64+m184r74+m184r84+m184r94+m184r104+m184r114+m184r124+m184r134+m184r144+m184r154+m184r164".
"+m184r174+m184r184+m184r194+m184r204+m184r214+m184r224+m184r234+m184r244+m184r254+m184r264".
"+m184r274+m184r284+m184r294+m184r304+m184r314+m184r324, ".
" m184r993=m184r13+m184r23+m184r33+m184r43+m184r53+m184r63+m184r73+m184r83+m184r93+m184r103+m184r113+m184r123+m184r133+m184r143+m184r153+m184r163".
"+m184r173+m184r183+m184r193+m184r203+m184r213+m184r223+m184r233+m184r243+m184r253+m184r263".
"+m184r273+m184r283+m184r293+m184r303+m184r313+m184r323, ".
" m184r992=m184r12+m184r22+m184r32+m184r42+m184r52+m184r62+m184r72+m184r82+m184r92+m184r102+m184r112+m184r122+m184r132+m184r142+m184r152+m184r162".
"+m184r172+m184r182+m184r192+m184r202+m184r212+m184r222+m184r232+m184r242+m184r252+m184r262".
"+m184r272+m184r282+m184r292+m184r302+m184r312+m184r322  ";

$upravene = mysql_query("$uprtxt");


//8strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101 SET ".

" m185r997=m185r17+m185r27+m185r37+m185r47+m185r57+m185r67+m185r77+m185r87+m185r97+m185r107+m185r117+m185r127+m185r137+m185r147+m185r157+m185r167".
"+m185r177+m185r187+m185r197+m185r207+m185r217+m185r227+m185r237+m185r247+m185r257+m185r267".
"+m185r277+m185r287+m185r297+m185r307, ".
" m185r996=m185r16+m185r26+m185r36+m185r46+m185r56+m185r66+m185r76+m185r86+m185r96+m185r106+m185r116+m185r126+m185r136+m185r146+m185r156+m185r166".
"+m185r176+m185r186+m185r196+m185r206+m185r216+m185r226+m185r236+m185r246+m185r256+m185r266".
"+m185r276+m185r286+m185r296+m185r306, ".
" m185r995=m185r15+m185r25+m185r35+m185r45+m185r55+m185r65+m185r75+m185r85+m185r95+m185r105+m185r115+m185r125+m185r135+m185r145+m185r155+m185r165".
"+m185r175+m185r185+m185r195+m185r205+m185r215+m185r225+m185r235+m185r245+m185r255+m185r265".
"+m185r275+m185r285+m185r295+m185r305, ".
" m185r994=m185r14+m185r24+m185r34+m185r44+m185r54+m185r64+m185r74+m185r84+m185r94+m185r104+m185r114+m185r124+m185r134+m185r144+m185r154+m185r164".
"+m185r174+m185r184+m185r194+m185r204+m185r214+m185r224+m185r234+m185r244+m185r254+m185r264".
"+m185r274+m185r284+m185r294+m185r304, ".
" m185r993=m185r13+m185r23+m185r33+m185r43+m185r53+m185r63+m185r73+m185r83+m185r93+m185r103+m185r113+m185r123+m185r133+m185r143+m185r153+m185r163".
"+m185r173+m185r183+m185r193+m185r203+m185r213+m185r223+m185r233+m185r243+m185r253+m185r263".
"+m185r273+m185r283+m185r293+m185r303, ".
" m185r992=m185r12+m185r22+m185r32+m185r42+m185r52+m185r62+m185r72+m185r82+m185r92+m185r102+m185r112+m185r122+m185r132+m185r142+m185r152+m185r162".
"+m185r172+m185r182+m185r192+m185r202+m185r212+m185r222+m185r232+m185r242+m185r252+m185r262".
"+m185r272+m185r282+m185r292+m185r302  ";
$upravene = mysql_query("$uprtxt");

//9.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101s2 SET ".

" m186r997=m186r17+m186r27+m186r37+m186r47+m186r57+m186r67+m186r77+m186r87+m186r97+m186r107+m186r117+m186r127+m186r137+m186r147+m186r157+m186r167".
"+m186r177+m186r187+m186r197+m186r207+m186r217+m186r227+m186r237+m186r247+m186r257+m186r267".
"+m186r277+m186r287+m186r297+m186r307, ".
" m186r996=m186r16+m186r26+m186r36+m186r46+m186r56+m186r66+m186r76+m186r86+m186r96+m186r106+m186r116+m186r126+m186r136+m186r146+m186r156+m186r166".
"+m186r176+m186r186+m186r196+m186r206+m186r216+m186r226+m186r236+m186r246+m186r256+m186r266".
"+m186r276+m186r286+m186r296+m186r306, ".
" m186r995=m186r15+m186r25+m186r35+m186r45+m186r55+m186r65+m186r75+m186r85+m186r95+m186r105+m186r115+m186r125+m186r135+m186r145+m186r155+m186r165".
"+m186r175+m186r185+m186r195+m186r205+m186r215+m186r225+m186r235+m186r245+m186r255+m186r265".
"+m186r275+m186r285+m186r295+m186r305, ".
" m186r994=m186r14+m186r24+m186r34+m186r44+m186r54+m186r64+m186r74+m186r84+m186r94+m186r104+m186r114+m186r124+m186r134+m186r144+m186r154+m186r164".
"+m186r174+m186r184+m186r194+m186r204+m186r214+m186r224+m186r234+m186r244+m186r254+m186r264".
"+m186r274+m186r284+m186r294+m186r304, ".
" m186r993=m186r13+m186r23+m186r33+m186r43+m186r53+m186r63+m186r73+m186r83+m186r93+m186r103+m186r113+m186r123+m186r133+m186r143+m186r153+m186r163".
"+m186r173+m186r183+m186r193+m186r203+m186r213+m186r223+m186r233+m186r243+m186r253+m186r263".
"+m186r273+m186r283+m186r293+m186r303, ".
" m186r992=m186r12+m186r22+m186r32+m186r42+m186r52+m186r62+m186r72+m186r82+m186r92+m186r102+m186r112+m186r122+m186r132+m186r142+m186r152+m186r162".
"+m186r172+m186r182+m186r192+m186r202+m186r212+m186r222+m186r232+m186r242+m186r252+m186r262".
"+m186r272+m186r282+m186r292+m186r302  ";
$upravene = mysql_query("$uprtxt");


//10.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101s2 SET ".
" m187r99=m187r1+m187r2+m187r3+m187r4+m187r5+m187r6+m187r7+m187r8+m187r9+m187r10+m187r11 ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");

//11.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101s2 SET ".

" m590r995=m590r15+m590r25+m590r35+m590r45+m590r55+m590r65+m590r75+m590r85+m590r95+m590r105+m590r115+m590r125+m590r135+m590r145+m590r155+m590r165".
"+m590r175+m590r185+m590r195+m590r205,".
" m590r994=m590r14+m590r24+m590r34+m590r44+m590r54+m590r64+m590r74+m590r84+m590r94+m590r104+m590r114+m590r124+m590r134+m590r144+m590r154+m590r164".
"+m590r174+m590r184+m590r194+m590r204, ".
" m590r993=m590r13+m590r23+m590r33+m590r43+m590r53+m590r63+m590r73+m590r83+m590r93+m590r103+m590r113+m590r123+m590r133+m590r143+m590r153+m590r163".
"+m590r173+m590r183+m590r193+m590r203, ".
" m590r992=m590r12+m590r22+m590r32+m590r42+m590r52+m590r62+m590r72+m590r82+m590r92+m590r102+m590r112+m590r122+m590r132+m590r142+m590r152+m590r162".
"+m590r172+m590r182+m590r192+m590r202  ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101s2 SET ".
" m304r99=m304r1+m304r2+m304r3+m304r4+m304r5+m304r6+m304r7+m304r8+m304r9+m304r10+m304r11+m304r12+m304r13+m304r14+m304r15+m304r16 ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");


//12strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_zav101s2 SET ".

" m110r999=m110r19+m110r29+m110r39+m110r49+m110r59+m110r69+m110r79+m110r89+m110r99+m110r109+m110r119+m110r129+m110r139+m110r149+m110r159+m110r169".
"+m110r179+m110r189+m110r199+m110r209+m110r219+m110r229+m110r239+m110r249+m110r259+m110r269".
"+m110r279+m110r289+m110r299+m110r309+m110r319+m110r329+m110r339+m110r349, ".
" m110r998=m110r18+m110r28+m110r38+m110r48+m110r58+m110r68+m110r78+m110r88+m110r98+m110r108+m110r118+m110r128+m110r138+m110r148+m110r158+m110r168".
"+m110r178+m110r188+m110r198+m110r208+m110r218+m110r228+m110r238+m110r248+m110r258+m110r268".
"+m110r278+m110r288+m110r298+m110r308+m110r318+m110r328+m110r338+m110r348, ".


" m110r997=m110r17+m110r27+m110r37+m110r47+m110r57+m110r67+m110r77+m110r87+m110r97+m110r107+m110r117+m110r127+m110r137+m110r147+m110r157+m110r167".
"+m110r177+m110r187+m110r197+m110r207+m110r217+m110r227+m110r237+m110r247+m110r257+m110r267".
"+m110r277+m110r287+m110r297+m110r307+m110r317+m110r327+m110r337+m110r347, ".
" m110r996=m110r16+m110r26+m110r36+m110r46+m110r56+m110r66+m110r76+m110r86+m110r96+m110r106+m110r116+m110r126+m110r136+m110r146+m110r156+m110r166".
"+m110r176+m110r186+m110r196+m110r206+m110r216+m110r226+m110r236+m110r246+m110r256+m110r266".
"+m110r276+m110r286+m110r296+m110r306+m110r316+m110r326+m110r336+m110r346, ".
" m110r995=m110r15+m110r25+m110r35+m110r45+m110r55+m110r65+m110r75+m110r85+m110r95+m110r105+m110r115+m110r125+m110r135+m110r145+m110r155+m110r165".
"+m110r175+m110r185+m110r195+m110r205+m110r215+m110r225+m110r235+m110r245+m110r255+m110r265".
"+m110r275+m110r285+m110r295+m110r305+m110r315+m110r325+m110r335+m110r345, ".
" m110r994=m110r14+m110r24+m110r34+m110r44+m110r54+m110r64+m110r74+m110r84+m110r94+m110r104+m110r114+m110r124+m110r134+m110r144+m110r154+m110r164".
"+m110r174+m110r184+m110r194+m110r204+m110r214+m110r224+m110r234+m110r244+m110r254+m110r264".
"+m110r274+m110r284+m110r294+m110r304+m110r314+m110r324+m110r334+m110r344, ".
" m110r993=m110r13+m110r23+m110r33+m110r43+m110r53+m110r63+m110r73+m110r83+m110r93+m110r103+m110r113+m110r123+m110r133+m110r143+m110r153+m110r163".
"+m110r173+m110r183+m110r193+m110r203+m110r213+m110r223+m110r233+m110r243+m110r253+m110r263".
"+m110r273+m110r283+m110r293+m110r303+m110r313+m110r323+m110r333+m110r343, ".
" m110r992=m110r12+m110r22+m110r32+m110r42+m110r52+m110r62+m110r72+m110r82+m110r92+m110r102+m110r112+m110r122+m110r132+m110r142+m110r152+m110r162".
"+m110r172+m110r182+m110r192+m110r202+m110r212+m110r222+m110r232+m110r242+m110r252+m110r262".
"+m110r272+m110r282+m110r292+m110r302+m110r312+m110r322+m110r332+m110r342  ";
$upravene = mysql_query("$uprtxt");


//koniec vypocty

//nacitaj udaje
if ( $copern >= 1 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_statistika_zav101 WHERE ico >= 0";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
//1.strana
$odoslane_sk = SkDatum($fir_riadok->odoslane);
//2.strana
$m592r11 = $fir_riadok->m592r11;
$m592r12 = $fir_riadok->m592r12;
$m592r13 = $fir_riadok->m592r13;
$m592r14 = $fir_riadok->m592r14;
$m592r15 = $fir_riadok->m592r15;
$m592r16 = $fir_riadok->m592r16;
$m592r21 = $fir_riadok->m592r21;
$m592r22 = $fir_riadok->m592r22;
$m592r23 = $fir_riadok->m592r23;
$m592r24 = $fir_riadok->m592r24;
$m592r25 = $fir_riadok->m592r25;
$m592r26 = $fir_riadok->m592r26;
$m592r31 = $fir_riadok->m592r31;
$m592r32 = $fir_riadok->m592r32;
$m592r33 = $fir_riadok->m592r33;
$m592r34 = $fir_riadok->m592r34;
$m592r35 = $fir_riadok->m592r35;
$m592r36 = $fir_riadok->m592r36;
$m592r41 = $fir_riadok->m592r41;
$m592r42 = $fir_riadok->m592r42;
$m592r43 = $fir_riadok->m592r43;
$m592r44 = $fir_riadok->m592r44;
$m592r45 = $fir_riadok->m592r45;
$m592r46 = $fir_riadok->m592r46;
$m592r51 = $fir_riadok->m592r51;
$m592r52 = $fir_riadok->m592r52;
$m592r53 = $fir_riadok->m592r53;
$m592r54 = $fir_riadok->m592r54;
$m592r55 = $fir_riadok->m592r55;
$m592r56 = $fir_riadok->m592r56;
$m592r61 = $fir_riadok->m592r61;
$m592r62 = $fir_riadok->m592r62;
$m592r63 = $fir_riadok->m592r63;
$m592r64 = $fir_riadok->m592r64;
$m592r65 = $fir_riadok->m592r65;
$m592r66 = $fir_riadok->m592r66;
$m592r71 = $fir_riadok->m592r71;
$m592r72 = $fir_riadok->m592r72;
$m592r73 = $fir_riadok->m592r73;
$m592r74 = $fir_riadok->m592r74;
$m592r75 = $fir_riadok->m592r75;
$m592r76 = $fir_riadok->m592r76;
$m592r81 = $fir_riadok->m592r81;
$m592r82 = $fir_riadok->m592r82;
$m592r83 = $fir_riadok->m592r83;
$m592r84 = $fir_riadok->m592r84;
$m592r85 = $fir_riadok->m592r85;
$m592r86 = $fir_riadok->m592r86;
$m592r91 = $fir_riadok->m592r91;
$m592r92 = $fir_riadok->m592r92;
$m592r93 = $fir_riadok->m592r93;
$m592r94 = $fir_riadok->m592r94;
$m592r95 = $fir_riadok->m592r95;
$m592r96 = $fir_riadok->m592r96;
$m592r101 = $fir_riadok->m592r101;
$m592r102 = $fir_riadok->m592r102;
$m592r103 = $fir_riadok->m592r103;
$m592r104 = $fir_riadok->m592r104;
$m592r105 = $fir_riadok->m592r105;
$m592r106 = $fir_riadok->m592r106;
$m592r111 = $fir_riadok->m592r111;
$m592r112 = $fir_riadok->m592r112;
$m592r113 = $fir_riadok->m592r113;
$m592r114 = $fir_riadok->m592r114;
$m592r115 = $fir_riadok->m592r115;
$m592r116 = $fir_riadok->m592r116;
$m592r121 = $fir_riadok->m592r121;
$m592r122 = $fir_riadok->m592r122;
$m592r123 = $fir_riadok->m592r123;
$m592r124 = $fir_riadok->m592r124;
$m592r125 = $fir_riadok->m592r125;
$m592r126 = $fir_riadok->m592r126;
$m592r131 = $fir_riadok->m592r131;
$m592r132 = $fir_riadok->m592r132;
$m592r133 = $fir_riadok->m592r133;
$m592r134 = $fir_riadok->m592r134;
$m592r135 = $fir_riadok->m592r135;
$m592r136 = $fir_riadok->m592r136;
$m592r141 = $fir_riadok->m592r141;
$m592r142 = $fir_riadok->m592r142;
$m592r143 = $fir_riadok->m592r143;
$m592r144 = $fir_riadok->m592r144;
$m592r145 = $fir_riadok->m592r145;
$m592r146 = $fir_riadok->m592r146;
$m592r151 = $fir_riadok->m592r151;
$m592r152 = $fir_riadok->m592r152;
$m592r153 = $fir_riadok->m592r153;
$m592r154 = $fir_riadok->m592r154;
$m592r155 = $fir_riadok->m592r155;
$m592r156 = $fir_riadok->m592r156;
$m592r161 = $fir_riadok->m592r161;
$m592r162 = $fir_riadok->m592r162;
$m592r163 = $fir_riadok->m592r163;
$m592r164 = $fir_riadok->m592r164;
$m592r165 = $fir_riadok->m592r165;
$m592r166 = $fir_riadok->m592r166;
$m592r171 = $fir_riadok->m592r171;
$m592r172 = $fir_riadok->m592r172;
$m592r173 = $fir_riadok->m592r173;
$m592r174 = $fir_riadok->m592r174;
$m592r175 = $fir_riadok->m592r175;
$m592r176 = $fir_riadok->m592r176;
$m592r181 = $fir_riadok->m592r181;
$m592r182 = $fir_riadok->m592r182;
$m592r183 = $fir_riadok->m592r183;
$m592r184 = $fir_riadok->m592r184;
$m592r185 = $fir_riadok->m592r185;
$m592r186 = $fir_riadok->m592r186;
$m592r191 = $fir_riadok->m592r191;
$m592r192 = $fir_riadok->m592r192;
$m592r193 = $fir_riadok->m592r193;
$m592r194 = $fir_riadok->m592r194;
$m592r195 = $fir_riadok->m592r195;
$m592r196 = $fir_riadok->m592r196;
$m592r201 = $fir_riadok->m592r201;
$m592r202 = $fir_riadok->m592r202;
$m592r203 = $fir_riadok->m592r203;
$m592r204 = $fir_riadok->m592r204;
$m592r205 = $fir_riadok->m592r205;
$m592r206 = $fir_riadok->m592r206;
$m592r211 = $fir_riadok->m592r211;
$m592r212 = $fir_riadok->m592r212;
$m592r213 = $fir_riadok->m592r213;
$m592r214 = $fir_riadok->m592r214;
$m592r215 = $fir_riadok->m592r215;
$m592r216 = $fir_riadok->m592r216;
$m592r221 = $fir_riadok->m592r221;
$m592r222 = $fir_riadok->m592r222;
$m592r223 = $fir_riadok->m592r223;
$m592r224 = $fir_riadok->m592r224;
$m592r225 = $fir_riadok->m592r225;
$m592r226 = $fir_riadok->m592r226;
$m592r231 = $fir_riadok->m592r231;
$m592r232 = $fir_riadok->m592r232;
$m592r233 = $fir_riadok->m592r233;
$m592r234 = $fir_riadok->m592r234;
$m592r235 = $fir_riadok->m592r235;
$m592r236 = $fir_riadok->m592r236;
$m592r241 = $fir_riadok->m592r241;
$m592r242 = $fir_riadok->m592r242;
$m592r243 = $fir_riadok->m592r243;
$m592r244 = $fir_riadok->m592r244;
$m592r245 = $fir_riadok->m592r245;
$m592r246 = $fir_riadok->m592r246;
$m592r251 = $fir_riadok->m592r251;
$m592r252 = $fir_riadok->m592r252;
$m592r253 = $fir_riadok->m592r253;
$m592r254 = $fir_riadok->m592r254;
$m592r255 = $fir_riadok->m592r255;
$m592r256 = $fir_riadok->m592r256;
$m592r992 = $fir_riadok->m592r992;
$m592r993 = $fir_riadok->m592r993;
$m592r994 = $fir_riadok->m592r994;
$m592r995 = $fir_riadok->m592r995;
$m592r996 = $fir_riadok->m592r996;
//3.strana
$m177r1 = $fir_riadok->m177r1;
$m177r2 = $fir_riadok->m177r2;
$m177r3 = $fir_riadok->m177r3;
$m177r4 = $fir_riadok->m177r4;
$m177r5 = $fir_riadok->m177r5;
$m177r6 = $fir_riadok->m177r6;
$m177r7 = $fir_riadok->m177r7;
$m177r8 = $fir_riadok->m177r8;
$m177r9 = $fir_riadok->m177r9;
$m177r10 = $fir_riadok->m177r10;
$m177r99 = $fir_riadok->m177r99;
$m178r1 = $fir_riadok->m178r1;
$m178r2 = $fir_riadok->m178r2;
$m178r3 = $fir_riadok->m178r3;
$m178r4 = $fir_riadok->m178r4;
$m178r5 = $fir_riadok->m178r5;
$m178r6 = $fir_riadok->m178r6;
$m178r7 = $fir_riadok->m178r7;
$m178r8 = $fir_riadok->m178r8;
$m178r9 = $fir_riadok->m178r9;
$m178r10 = $fir_riadok->m178r10;
$m178r11 = $fir_riadok->m178r11;
$m178r12 = $fir_riadok->m178r12;
$m178r13 = $fir_riadok->m178r13;
$m178r14 = $fir_riadok->m178r14;
$m178r15 = $fir_riadok->m178r15;
$m178r16 = $fir_riadok->m178r16;
$m178r17 = $fir_riadok->m178r17;
$m178r18 = $fir_riadok->m178r18;
$m178r19 = $fir_riadok->m178r19;
$m178r99 = $fir_riadok->m178r99;
//4.strana
$m179r1 = $fir_riadok->m179r1;
$m179r2 = $fir_riadok->m179r2;
$m179r3 = $fir_riadok->m179r3;
$m179r4 = $fir_riadok->m179r4;
$m179r5 = $fir_riadok->m179r5;
$m179r6 = $fir_riadok->m179r6;
$m179r7 = $fir_riadok->m179r7;
$m179r8 = $fir_riadok->m179r8;
$m179r9 = $fir_riadok->m179r9;
$m179r99 = $fir_riadok->m179r99;
//5.strana
$m182r11 = $fir_riadok->m182r11;
$m182r12 = $fir_riadok->m182r12;
$m182r13 = $fir_riadok->m182r13;
$m182r14 = $fir_riadok->m182r14;
$m182r15 = $fir_riadok->m182r15;
$m182r16 = $fir_riadok->m182r16;
$m182r17 = $fir_riadok->m182r17;
$m182r21 = $fir_riadok->m182r21;
$m182r22 = $fir_riadok->m182r22;
$m182r23 = $fir_riadok->m182r23;
$m182r24 = $fir_riadok->m182r24;
$m182r25 = $fir_riadok->m182r25;
$m182r26 = $fir_riadok->m182r26;
$m182r27 = $fir_riadok->m182r27;
$m182r31 = $fir_riadok->m182r31;
$m182r32 = $fir_riadok->m182r32;
$m182r33 = $fir_riadok->m182r33;
$m182r34 = $fir_riadok->m182r34;
$m182r35 = $fir_riadok->m182r35;
$m182r36 = $fir_riadok->m182r36;
$m182r37 = $fir_riadok->m182r37;
$m182r41 = $fir_riadok->m182r41;
$m182r42 = $fir_riadok->m182r42;
$m182r43 = $fir_riadok->m182r43;
$m182r44 = $fir_riadok->m182r44;
$m182r45 = $fir_riadok->m182r45;
$m182r46 = $fir_riadok->m182r46;
$m182r47 = $fir_riadok->m182r47;
$m182r51 = $fir_riadok->m182r51;
$m182r52 = $fir_riadok->m182r52;
$m182r53 = $fir_riadok->m182r53;
$m182r54 = $fir_riadok->m182r54;
$m182r55 = $fir_riadok->m182r55;
$m182r56 = $fir_riadok->m182r56;
$m182r57 = $fir_riadok->m182r57;
$m182r61 = $fir_riadok->m182r61;
$m182r62 = $fir_riadok->m182r62;
$m182r63 = $fir_riadok->m182r63;
$m182r64 = $fir_riadok->m182r64;
$m182r65 = $fir_riadok->m182r65;
$m182r66 = $fir_riadok->m182r66;
$m182r67 = $fir_riadok->m182r67;
$m182r71 = $fir_riadok->m182r71;
$m182r72 = $fir_riadok->m182r72;
$m182r73 = $fir_riadok->m182r73;
$m182r74 = $fir_riadok->m182r74;
$m182r75 = $fir_riadok->m182r75;
$m182r76 = $fir_riadok->m182r76;
$m182r77 = $fir_riadok->m182r77;
$m182r81 = $fir_riadok->m182r81;
$m182r82 = $fir_riadok->m182r82;
$m182r83 = $fir_riadok->m182r83;
$m182r84 = $fir_riadok->m182r84;
$m182r85 = $fir_riadok->m182r85;
$m182r86 = $fir_riadok->m182r86;
$m182r87 = $fir_riadok->m182r87;
$m182r91 = $fir_riadok->m182r91;
$m182r92 = $fir_riadok->m182r92;
$m182r93 = $fir_riadok->m182r93;
$m182r94 = $fir_riadok->m182r94;
$m182r95 = $fir_riadok->m182r95;
$m182r96 = $fir_riadok->m182r96;
$m182r97 = $fir_riadok->m182r97;
$m182r101 = $fir_riadok->m182r101;
$m182r102 = $fir_riadok->m182r102;
$m182r103 = $fir_riadok->m182r103;
$m182r104 = $fir_riadok->m182r104;
$m182r105 = $fir_riadok->m182r105;
$m182r106 = $fir_riadok->m182r106;
$m182r107 = $fir_riadok->m182r107;
$m182r111 = $fir_riadok->m182r111;
$m182r112 = $fir_riadok->m182r112;
$m182r113 = $fir_riadok->m182r113;
$m182r114 = $fir_riadok->m182r114;
$m182r115 = $fir_riadok->m182r115;
$m182r116 = $fir_riadok->m182r116;
$m182r117 = $fir_riadok->m182r117;
$m182r121 = $fir_riadok->m182r121;
$m182r122 = $fir_riadok->m182r122;
$m182r123 = $fir_riadok->m182r123;
$m182r124 = $fir_riadok->m182r124;
$m182r125 = $fir_riadok->m182r125;
$m182r126 = $fir_riadok->m182r126;
$m182r127 = $fir_riadok->m182r127;
$m182r131 = $fir_riadok->m182r131;
$m182r132 = $fir_riadok->m182r132;
$m182r133 = $fir_riadok->m182r133;
$m182r134 = $fir_riadok->m182r134;
$m182r135 = $fir_riadok->m182r135;
$m182r136 = $fir_riadok->m182r136;
$m182r137 = $fir_riadok->m182r137;
$m182r141 = $fir_riadok->m182r141;
$m182r142 = $fir_riadok->m182r142;
$m182r143 = $fir_riadok->m182r143;
$m182r144 = $fir_riadok->m182r144;
$m182r145 = $fir_riadok->m182r145;
$m182r146 = $fir_riadok->m182r146;
$m182r147 = $fir_riadok->m182r147;
$m182r151 = $fir_riadok->m182r151;
$m182r152 = $fir_riadok->m182r152;
$m182r153 = $fir_riadok->m182r153;
$m182r154 = $fir_riadok->m182r154;
$m182r155 = $fir_riadok->m182r155;
$m182r156 = $fir_riadok->m182r156;
$m182r157 = $fir_riadok->m182r157;
$m182r161 = $fir_riadok->m182r161;
$m182r162 = $fir_riadok->m182r162;
$m182r163 = $fir_riadok->m182r163;
$m182r164 = $fir_riadok->m182r164;
$m182r165 = $fir_riadok->m182r165;
$m182r166 = $fir_riadok->m182r166;
$m182r167 = $fir_riadok->m182r167;
$m182r171 = $fir_riadok->m182r171;
$m182r172 = $fir_riadok->m182r172;
$m182r173 = $fir_riadok->m182r173;
$m182r174 = $fir_riadok->m182r174;
$m182r175 = $fir_riadok->m182r175;
$m182r176 = $fir_riadok->m182r176;
$m182r177 = $fir_riadok->m182r177;
$m182r181 = $fir_riadok->m182r181;
$m182r182 = $fir_riadok->m182r182;
$m182r183 = $fir_riadok->m182r183;
$m182r184 = $fir_riadok->m182r184;
$m182r185 = $fir_riadok->m182r185;
$m182r186 = $fir_riadok->m182r186;
$m182r187 = $fir_riadok->m182r187;
$m182r191 = $fir_riadok->m182r191;
$m182r192 = $fir_riadok->m182r192;
$m182r193 = $fir_riadok->m182r193;
$m182r194 = $fir_riadok->m182r194;
$m182r195 = $fir_riadok->m182r195;
$m182r196 = $fir_riadok->m182r196;
$m182r197 = $fir_riadok->m182r197;
$m182r201 = $fir_riadok->m182r201;
$m182r202 = $fir_riadok->m182r202;
$m182r203 = $fir_riadok->m182r203;
$m182r204 = $fir_riadok->m182r204;
$m182r205 = $fir_riadok->m182r205;
$m182r206 = $fir_riadok->m182r206;
$m182r207 = $fir_riadok->m182r207;
$m182r211 = $fir_riadok->m182r211;
$m182r212 = $fir_riadok->m182r212;
$m182r213 = $fir_riadok->m182r213;
$m182r214 = $fir_riadok->m182r214;
$m182r215 = $fir_riadok->m182r215;
$m182r216 = $fir_riadok->m182r216;
$m182r217 = $fir_riadok->m182r217;
$m182r221 = $fir_riadok->m182r221;
$m182r222 = $fir_riadok->m182r222;
$m182r223 = $fir_riadok->m182r223;
$m182r224 = $fir_riadok->m182r224;
$m182r225 = $fir_riadok->m182r225;
$m182r226 = $fir_riadok->m182r226;
$m182r227 = $fir_riadok->m182r227;
$m182r231 = $fir_riadok->m182r231;
$m182r232 = $fir_riadok->m182r232;
$m182r233 = $fir_riadok->m182r233;
$m182r234 = $fir_riadok->m182r234;
$m182r235 = $fir_riadok->m182r235;
$m182r236 = $fir_riadok->m182r236;
$m182r237 = $fir_riadok->m182r237;
$m182r241 = $fir_riadok->m182r241;
$m182r242 = $fir_riadok->m182r242;
$m182r243 = $fir_riadok->m182r243;
$m182r244 = $fir_riadok->m182r244;
$m182r245 = $fir_riadok->m182r245;
$m182r246 = $fir_riadok->m182r246;
$m182r247 = $fir_riadok->m182r247;
$m182r251 = $fir_riadok->m182r251;
$m182r252 = $fir_riadok->m182r252;
$m182r253 = $fir_riadok->m182r253;
$m182r254 = $fir_riadok->m182r254;
$m182r255 = $fir_riadok->m182r255;
$m182r256 = $fir_riadok->m182r256;
$m182r257 = $fir_riadok->m182r257;
$m182r261 = $fir_riadok->m182r261;
$m182r262 = $fir_riadok->m182r262;
$m182r263 = $fir_riadok->m182r263;
$m182r264 = $fir_riadok->m182r264;
$m182r265 = $fir_riadok->m182r265;
$m182r266 = $fir_riadok->m182r266;
$m182r267 = $fir_riadok->m182r267;
$m182r271 = $fir_riadok->m182r271;
$m182r272 = $fir_riadok->m182r272;
$m182r273 = $fir_riadok->m182r273;
$m182r274 = $fir_riadok->m182r274;
$m182r275 = $fir_riadok->m182r275;
$m182r276 = $fir_riadok->m182r276;
$m182r277 = $fir_riadok->m182r277;
$m182r281 = $fir_riadok->m182r281;
$m182r282 = $fir_riadok->m182r282;
$m182r283 = $fir_riadok->m182r283;
$m182r284 = $fir_riadok->m182r284;
$m182r285 = $fir_riadok->m182r285;
$m182r286 = $fir_riadok->m182r286;
$m182r287 = $fir_riadok->m182r287;
$m182r291 = $fir_riadok->m182r291;
$m182r292 = $fir_riadok->m182r292;
$m182r293 = $fir_riadok->m182r293;
$m182r294 = $fir_riadok->m182r294;
$m182r295 = $fir_riadok->m182r295;
$m182r296 = $fir_riadok->m182r296;
$m182r297 = $fir_riadok->m182r297;
$m182r301 = $fir_riadok->m182r301;
$m182r302 = $fir_riadok->m182r302;
$m182r303 = $fir_riadok->m182r303;
$m182r304 = $fir_riadok->m182r304;
$m182r305 = $fir_riadok->m182r305;
$m182r306 = $fir_riadok->m182r306;
$m182r307 = $fir_riadok->m182r307;
$m182r311 = $fir_riadok->m182r311;
$m182r312 = $fir_riadok->m182r312;
$m182r313 = $fir_riadok->m182r313;
$m182r314 = $fir_riadok->m182r314;
$m182r315 = $fir_riadok->m182r315;
$m182r316 = $fir_riadok->m182r316;
$m182r317 = $fir_riadok->m182r317;
$m182r321 = $fir_riadok->m182r321;
$m182r322 = $fir_riadok->m182r322;
$m182r323 = $fir_riadok->m182r323;
$m182r324 = $fir_riadok->m182r324;
$m182r325 = $fir_riadok->m182r325;
$m182r326 = $fir_riadok->m182r326;
$m182r327 = $fir_riadok->m182r327;
$m182r331 = $fir_riadok->m182r331;
$m182r332 = $fir_riadok->m182r332;
$m182r333 = $fir_riadok->m182r333;
$m182r334 = $fir_riadok->m182r334;
$m182r335 = $fir_riadok->m182r335;
$m182r336 = $fir_riadok->m182r336;
$m182r337 = $fir_riadok->m182r337;
$m182r992 = $fir_riadok->m182r992;
$m182r993 = $fir_riadok->m182r993;
$m182r994 = $fir_riadok->m182r994;
$m182r995 = $fir_riadok->m182r995;
$m182r996 = $fir_riadok->m182r996;
$m182r997 = $fir_riadok->m182r997;
//6.strana
$m183r11 = $fir_riadok->m183r11;
$m183r12 = $fir_riadok->m183r12;
$m183r13 = $fir_riadok->m183r13;
$m183r14 = $fir_riadok->m183r14;
$m183r21 = $fir_riadok->m183r21;
$m183r22 = $fir_riadok->m183r22;
$m183r23 = $fir_riadok->m183r23;
$m183r24 = $fir_riadok->m183r24;
$m183r31 = $fir_riadok->m183r31;
$m183r32 = $fir_riadok->m183r32;
$m183r33 = $fir_riadok->m183r33;
$m183r34 = $fir_riadok->m183r34;
$m183r41 = $fir_riadok->m183r41;
$m183r42 = $fir_riadok->m183r42;
$m183r43 = $fir_riadok->m183r43;
$m183r44 = $fir_riadok->m183r44;
$m183r51 = $fir_riadok->m183r51;
$m183r52 = $fir_riadok->m183r52;
$m183r53 = $fir_riadok->m183r53;
$m183r54 = $fir_riadok->m183r54;
$m183r61 = $fir_riadok->m183r61;
$m183r62 = $fir_riadok->m183r62;
$m183r63 = $fir_riadok->m183r63;
$m183r64 = $fir_riadok->m183r64;
$m183r71 = $fir_riadok->m183r71;
$m183r72 = $fir_riadok->m183r72;
$m183r73 = $fir_riadok->m183r73;
$m183r74 = $fir_riadok->m183r74;
$m183r81 = $fir_riadok->m183r81;
$m183r82 = $fir_riadok->m183r82;
$m183r83 = $fir_riadok->m183r83;
$m183r84 = $fir_riadok->m183r84;
$m183r91 = $fir_riadok->m183r91;
$m183r92 = $fir_riadok->m183r92;
$m183r93 = $fir_riadok->m183r93;
$m183r94 = $fir_riadok->m183r94;
$m183r101 = $fir_riadok->m183r101;
$m183r102 = $fir_riadok->m183r102;
$m183r103 = $fir_riadok->m183r103;
$m183r104 = $fir_riadok->m183r104;
$m183r111 = $fir_riadok->m183r111;
$m183r112 = $fir_riadok->m183r112;
$m183r113 = $fir_riadok->m183r113;
$m183r114 = $fir_riadok->m183r114;
$m183r121 = $fir_riadok->m183r121;
$m183r122 = $fir_riadok->m183r122;
$m183r123 = $fir_riadok->m183r123;
$m183r124 = $fir_riadok->m183r124;
$m183r131 = $fir_riadok->m183r131;
$m183r132 = $fir_riadok->m183r132;
$m183r133 = $fir_riadok->m183r133;
$m183r134 = $fir_riadok->m183r134;
$m183r141 = $fir_riadok->m183r141;
$m183r142 = $fir_riadok->m183r142;
$m183r143 = $fir_riadok->m183r143;
$m183r144 = $fir_riadok->m183r144;
$m183r151 = $fir_riadok->m183r151;
$m183r152 = $fir_riadok->m183r152;
$m183r153 = $fir_riadok->m183r153;
$m183r154 = $fir_riadok->m183r154;
$m183r161 = $fir_riadok->m183r161;
$m183r162 = $fir_riadok->m183r162;
$m183r163 = $fir_riadok->m183r163;
$m183r164 = $fir_riadok->m183r164;
$m183r171 = $fir_riadok->m183r171;
$m183r172 = $fir_riadok->m183r172;
$m183r173 = $fir_riadok->m183r173;
$m183r174 = $fir_riadok->m183r174;
$m183r181 = $fir_riadok->m183r181;
$m183r182 = $fir_riadok->m183r182;
$m183r183 = $fir_riadok->m183r183;
$m183r184 = $fir_riadok->m183r184;
$m183r191 = $fir_riadok->m183r191;
$m183r192 = $fir_riadok->m183r192;
$m183r193 = $fir_riadok->m183r193;
$m183r194 = $fir_riadok->m183r194;
$m183r201 = $fir_riadok->m183r201;
$m183r202 = $fir_riadok->m183r202;
$m183r203 = $fir_riadok->m183r203;
$m183r204 = $fir_riadok->m183r204;
$m183r211 = $fir_riadok->m183r211;
$m183r212 = $fir_riadok->m183r212;
$m183r213 = $fir_riadok->m183r213;
$m183r214 = $fir_riadok->m183r214;
$m183r221 = $fir_riadok->m183r221;
$m183r222 = $fir_riadok->m183r222;
$m183r223 = $fir_riadok->m183r223;
$m183r224 = $fir_riadok->m183r224;
$m183r231 = $fir_riadok->m183r231;
$m183r232 = $fir_riadok->m183r232;
$m183r233 = $fir_riadok->m183r233;
$m183r234 = $fir_riadok->m183r234;
$m183r241 = $fir_riadok->m183r241;
$m183r242 = $fir_riadok->m183r242;
$m183r243 = $fir_riadok->m183r243;
$m183r244 = $fir_riadok->m183r244;
$m183r251 = $fir_riadok->m183r251;
$m183r252 = $fir_riadok->m183r252;
$m183r253 = $fir_riadok->m183r253;
$m183r254 = $fir_riadok->m183r254;
$m183r261 = $fir_riadok->m183r261;
$m183r262 = $fir_riadok->m183r262;
$m183r263 = $fir_riadok->m183r263;
$m183r264 = $fir_riadok->m183r264;
$m183r271 = $fir_riadok->m183r271;
$m183r272 = $fir_riadok->m183r272;
$m183r273 = $fir_riadok->m183r273;
$m183r274 = $fir_riadok->m183r274;
$m183r281 = $fir_riadok->m183r281;
$m183r282 = $fir_riadok->m183r282;
$m183r283 = $fir_riadok->m183r283;
$m183r284 = $fir_riadok->m183r284;
$m183r291 = $fir_riadok->m183r291;
$m183r292 = $fir_riadok->m183r292;
$m183r293 = $fir_riadok->m183r293;
$m183r294 = $fir_riadok->m183r294;
$m183r301 = $fir_riadok->m183r301;
$m183r302 = $fir_riadok->m183r302;
$m183r303 = $fir_riadok->m183r303;
$m183r304 = $fir_riadok->m183r304;
$m183r992 = $fir_riadok->m183r992;
$m183r993 = $fir_riadok->m183r993;
$m183r994 = $fir_riadok->m183r994;
//7.strana
$m184r11 = $fir_riadok->m184r11;
$m184r12 = $fir_riadok->m184r12;
$m184r13 = $fir_riadok->m184r13;
$m184r14 = $fir_riadok->m184r14;
$m184r15 = $fir_riadok->m184r15;
$m184r16 = $fir_riadok->m184r16;
$m184r21 = $fir_riadok->m184r21;
$m184r22 = $fir_riadok->m184r22;
$m184r23 = $fir_riadok->m184r23;
$m184r24 = $fir_riadok->m184r24;
$m184r25 = $fir_riadok->m184r25;
$m184r26 = $fir_riadok->m184r26;
$m184r31 = $fir_riadok->m184r31;
$m184r32 = $fir_riadok->m184r32;
$m184r33 = $fir_riadok->m184r33;
$m184r34 = $fir_riadok->m184r34;
$m184r35 = $fir_riadok->m184r35;
$m184r36 = $fir_riadok->m184r36;
$m184r41 = $fir_riadok->m184r41;
$m184r42 = $fir_riadok->m184r42;
$m184r43 = $fir_riadok->m184r43;
$m184r44 = $fir_riadok->m184r44;
$m184r45 = $fir_riadok->m184r45;
$m184r46 = $fir_riadok->m184r46;
$m184r51 = $fir_riadok->m184r51;
$m184r52 = $fir_riadok->m184r52;
$m184r53 = $fir_riadok->m184r53;
$m184r54 = $fir_riadok->m184r54;
$m184r55 = $fir_riadok->m184r55;
$m184r56 = $fir_riadok->m184r56;
$m184r61 = $fir_riadok->m184r61;
$m184r62 = $fir_riadok->m184r62;
$m184r63 = $fir_riadok->m184r63;
$m184r64 = $fir_riadok->m184r64;
$m184r65 = $fir_riadok->m184r65;
$m184r66 = $fir_riadok->m184r66;
$m184r71 = $fir_riadok->m184r71;
$m184r72 = $fir_riadok->m184r72;
$m184r73 = $fir_riadok->m184r73;
$m184r74 = $fir_riadok->m184r74;
$m184r75 = $fir_riadok->m184r75;
$m184r76 = $fir_riadok->m184r76;
$m184r81 = $fir_riadok->m184r81;
$m184r82 = $fir_riadok->m184r82;
$m184r83 = $fir_riadok->m184r83;
$m184r84 = $fir_riadok->m184r84;
$m184r85 = $fir_riadok->m184r85;
$m184r86 = $fir_riadok->m184r86;
$m184r91 = $fir_riadok->m184r91;
$m184r92 = $fir_riadok->m184r92;
$m184r93 = $fir_riadok->m184r93;
$m184r94 = $fir_riadok->m184r94;
$m184r95 = $fir_riadok->m184r95;
$m184r96 = $fir_riadok->m184r96;
$m184r101 = $fir_riadok->m184r101;
$m184r102 = $fir_riadok->m184r102;
$m184r103 = $fir_riadok->m184r103;
$m184r104 = $fir_riadok->m184r104;
$m184r105 = $fir_riadok->m184r105;
$m184r106 = $fir_riadok->m184r106;
$m184r111 = $fir_riadok->m184r111;
$m184r112 = $fir_riadok->m184r112;
$m184r113 = $fir_riadok->m184r113;
$m184r114 = $fir_riadok->m184r114;
$m184r115 = $fir_riadok->m184r115;
$m184r116 = $fir_riadok->m184r116;
$m184r121 = $fir_riadok->m184r121;
$m184r122 = $fir_riadok->m184r122;
$m184r123 = $fir_riadok->m184r123;
$m184r124 = $fir_riadok->m184r124;
$m184r125 = $fir_riadok->m184r125;
$m184r126 = $fir_riadok->m184r126;
$m184r131 = $fir_riadok->m184r131;
$m184r132 = $fir_riadok->m184r132;
$m184r133 = $fir_riadok->m184r133;
$m184r134 = $fir_riadok->m184r134;
$m184r135 = $fir_riadok->m184r135;
$m184r136 = $fir_riadok->m184r136;
$m184r141 = $fir_riadok->m184r141;
$m184r142 = $fir_riadok->m184r142;
$m184r143 = $fir_riadok->m184r143;
$m184r144 = $fir_riadok->m184r144;
$m184r145 = $fir_riadok->m184r145;
$m184r146 = $fir_riadok->m184r146;
$m184r151 = $fir_riadok->m184r151;
$m184r152 = $fir_riadok->m184r152;
$m184r153 = $fir_riadok->m184r153;
$m184r154 = $fir_riadok->m184r154;
$m184r155 = $fir_riadok->m184r155;
$m184r156 = $fir_riadok->m184r156;
$m184r161 = $fir_riadok->m184r161;
$m184r162 = $fir_riadok->m184r162;
$m184r163 = $fir_riadok->m184r163;
$m184r164 = $fir_riadok->m184r164;
$m184r165 = $fir_riadok->m184r165;
$m184r166 = $fir_riadok->m184r166;
$m184r171 = $fir_riadok->m184r171;
$m184r172 = $fir_riadok->m184r172;
$m184r173 = $fir_riadok->m184r173;
$m184r174 = $fir_riadok->m184r174;
$m184r175 = $fir_riadok->m184r175;
$m184r176 = $fir_riadok->m184r176;
$m184r181 = $fir_riadok->m184r181;
$m184r182 = $fir_riadok->m184r182;
$m184r183 = $fir_riadok->m184r183;
$m184r184 = $fir_riadok->m184r184;
$m184r185 = $fir_riadok->m184r185;
$m184r186 = $fir_riadok->m184r186;
$m184r191 = $fir_riadok->m184r191;
$m184r192 = $fir_riadok->m184r192;
$m184r193 = $fir_riadok->m184r193;
$m184r194 = $fir_riadok->m184r194;
$m184r195 = $fir_riadok->m184r195;
$m184r196 = $fir_riadok->m184r196;
$m184r201 = $fir_riadok->m184r201;
$m184r202 = $fir_riadok->m184r202;
$m184r203 = $fir_riadok->m184r203;
$m184r204 = $fir_riadok->m184r204;
$m184r205 = $fir_riadok->m184r205;
$m184r206 = $fir_riadok->m184r206;
$m184r211 = $fir_riadok->m184r211;
$m184r212 = $fir_riadok->m184r212;
$m184r213 = $fir_riadok->m184r213;
$m184r214 = $fir_riadok->m184r214;
$m184r215 = $fir_riadok->m184r215;
$m184r216 = $fir_riadok->m184r216;
$m184r221 = $fir_riadok->m184r221;
$m184r222 = $fir_riadok->m184r222;
$m184r223 = $fir_riadok->m184r223;
$m184r224 = $fir_riadok->m184r224;
$m184r225 = $fir_riadok->m184r225;
$m184r226 = $fir_riadok->m184r226;
$m184r231 = $fir_riadok->m184r231;
$m184r232 = $fir_riadok->m184r232;
$m184r233 = $fir_riadok->m184r233;
$m184r234 = $fir_riadok->m184r234;
$m184r235 = $fir_riadok->m184r235;
$m184r236 = $fir_riadok->m184r236;
$m184r241 = $fir_riadok->m184r241;
$m184r242 = $fir_riadok->m184r242;
$m184r243 = $fir_riadok->m184r243;
$m184r244 = $fir_riadok->m184r244;
$m184r245 = $fir_riadok->m184r245;
$m184r246 = $fir_riadok->m184r246;
$m184r251 = $fir_riadok->m184r251;
$m184r252 = $fir_riadok->m184r252;
$m184r253 = $fir_riadok->m184r253;
$m184r254 = $fir_riadok->m184r254;
$m184r255 = $fir_riadok->m184r255;
$m184r256 = $fir_riadok->m184r256;
$m184r261 = $fir_riadok->m184r261;
$m184r262 = $fir_riadok->m184r262;
$m184r263 = $fir_riadok->m184r263;
$m184r264 = $fir_riadok->m184r264;
$m184r265 = $fir_riadok->m184r265;
$m184r266 = $fir_riadok->m184r266;
$m184r271 = $fir_riadok->m184r271;
$m184r272 = $fir_riadok->m184r272;
$m184r273 = $fir_riadok->m184r273;
$m184r274 = $fir_riadok->m184r274;
$m184r275 = $fir_riadok->m184r275;
$m184r276 = $fir_riadok->m184r276;
$m184r281 = $fir_riadok->m184r281;
$m184r282 = $fir_riadok->m184r282;
$m184r283 = $fir_riadok->m184r283;
$m184r284 = $fir_riadok->m184r284;
$m184r285 = $fir_riadok->m184r285;
$m184r286 = $fir_riadok->m184r286;
$m184r291 = $fir_riadok->m184r291;
$m184r292 = $fir_riadok->m184r292;
$m184r293 = $fir_riadok->m184r293;
$m184r294 = $fir_riadok->m184r294;
$m184r295 = $fir_riadok->m184r295;
$m184r296 = $fir_riadok->m184r296;
$m184r301 = $fir_riadok->m184r301;
$m184r302 = $fir_riadok->m184r302;
$m184r303 = $fir_riadok->m184r303;
$m184r304 = $fir_riadok->m184r304;
$m184r305 = $fir_riadok->m184r305;
$m184r306 = $fir_riadok->m184r306;
$m184r311 = $fir_riadok->m184r311;
$m184r312 = $fir_riadok->m184r312;
$m184r313 = $fir_riadok->m184r313;
$m184r314 = $fir_riadok->m184r314;
$m184r315 = $fir_riadok->m184r315;
$m184r316 = $fir_riadok->m184r316;
$m184r321 = $fir_riadok->m184r321;
$m184r322 = $fir_riadok->m184r322;
$m184r323 = $fir_riadok->m184r323;
$m184r324 = $fir_riadok->m184r324;
$m184r325 = $fir_riadok->m184r325;
$m184r326 = $fir_riadok->m184r326;
$m184r992 = $fir_riadok->m184r992;
$m184r993 = $fir_riadok->m184r993;
$m184r994 = $fir_riadok->m184r994;
$m184r995 = $fir_riadok->m184r995;
$m184r996 = $fir_riadok->m184r996;
//8.strana
$m185r11 = $fir_riadok->m185r11;
$m185r12 = $fir_riadok->m185r12;
$m185r13 = $fir_riadok->m185r13;
$m185r14 = $fir_riadok->m185r14;
$m185r15 = $fir_riadok->m185r15;
$m185r16 = $fir_riadok->m185r16;
$m185r17 = $fir_riadok->m185r17;
$m185r21 = $fir_riadok->m185r21;
$m185r22 = $fir_riadok->m185r22;
$m185r23 = $fir_riadok->m185r23;
$m185r24 = $fir_riadok->m185r24;
$m185r25 = $fir_riadok->m185r25;
$m185r26 = $fir_riadok->m185r26;
$m185r27 = $fir_riadok->m185r27;
$m185r31 = $fir_riadok->m185r31;
$m185r32 = $fir_riadok->m185r32;
$m185r33 = $fir_riadok->m185r33;
$m185r34 = $fir_riadok->m185r34;
$m185r35 = $fir_riadok->m185r35;
$m185r36 = $fir_riadok->m185r36;
$m185r37 = $fir_riadok->m185r37;
$m185r41 = $fir_riadok->m185r41;
$m185r42 = $fir_riadok->m185r42;
$m185r43 = $fir_riadok->m185r43;
$m185r44 = $fir_riadok->m185r44;
$m185r45 = $fir_riadok->m185r45;
$m185r46 = $fir_riadok->m185r46;
$m185r47 = $fir_riadok->m185r47;
$m185r51 = $fir_riadok->m185r51;
$m185r52 = $fir_riadok->m185r52;
$m185r53 = $fir_riadok->m185r53;
$m185r54 = $fir_riadok->m185r54;
$m185r55 = $fir_riadok->m185r55;
$m185r56 = $fir_riadok->m185r56;
$m185r57 = $fir_riadok->m185r57;
$m185r61 = $fir_riadok->m185r61;
$m185r62 = $fir_riadok->m185r62;
$m185r63 = $fir_riadok->m185r63;
$m185r64 = $fir_riadok->m185r64;
$m185r65 = $fir_riadok->m185r65;
$m185r66 = $fir_riadok->m185r66;
$m185r67 = $fir_riadok->m185r67;
$m185r71 = $fir_riadok->m185r71;
$m185r72 = $fir_riadok->m185r72;
$m185r73 = $fir_riadok->m185r73;
$m185r74 = $fir_riadok->m185r74;
$m185r75 = $fir_riadok->m185r75;
$m185r76 = $fir_riadok->m185r76;
$m185r77 = $fir_riadok->m185r77;
$m185r81 = $fir_riadok->m185r81;
$m185r82 = $fir_riadok->m185r82;
$m185r83 = $fir_riadok->m185r83;
$m185r84 = $fir_riadok->m185r84;
$m185r85 = $fir_riadok->m185r85;
$m185r86 = $fir_riadok->m185r86;
$m185r87 = $fir_riadok->m185r87;
$m185r91 = $fir_riadok->m185r91;
$m185r92 = $fir_riadok->m185r92;
$m185r93 = $fir_riadok->m185r93;
$m185r94 = $fir_riadok->m185r94;
$m185r95 = $fir_riadok->m185r95;
$m185r96 = $fir_riadok->m185r96;
$m185r97 = $fir_riadok->m185r97;
$m185r101 = $fir_riadok->m185r101;
$m185r102 = $fir_riadok->m185r102;
$m185r103 = $fir_riadok->m185r103;
$m185r104 = $fir_riadok->m185r104;
$m185r105 = $fir_riadok->m185r105;
$m185r106 = $fir_riadok->m185r106;
$m185r107 = $fir_riadok->m185r107;
$m185r111 = $fir_riadok->m185r111;
$m185r112 = $fir_riadok->m185r112;
$m185r113 = $fir_riadok->m185r113;
$m185r114 = $fir_riadok->m185r114;
$m185r115 = $fir_riadok->m185r115;
$m185r116 = $fir_riadok->m185r116;
$m185r117 = $fir_riadok->m185r117;
$m185r121 = $fir_riadok->m185r121;
$m185r122 = $fir_riadok->m185r122;
$m185r123 = $fir_riadok->m185r123;
$m185r124 = $fir_riadok->m185r124;
$m185r125 = $fir_riadok->m185r125;
$m185r126 = $fir_riadok->m185r126;
$m185r127 = $fir_riadok->m185r127;
$m185r131 = $fir_riadok->m185r131;
$m185r132 = $fir_riadok->m185r132;
$m185r133 = $fir_riadok->m185r133;
$m185r134 = $fir_riadok->m185r134;
$m185r135 = $fir_riadok->m185r135;
$m185r136 = $fir_riadok->m185r136;
$m185r137 = $fir_riadok->m185r137;
$m185r141 = $fir_riadok->m185r141;
$m185r142 = $fir_riadok->m185r142;
$m185r143 = $fir_riadok->m185r143;
$m185r144 = $fir_riadok->m185r144;
$m185r145 = $fir_riadok->m185r145;
$m185r146 = $fir_riadok->m185r146;
$m185r147 = $fir_riadok->m185r147;
$m185r151 = $fir_riadok->m185r151;
$m185r152 = $fir_riadok->m185r152;
$m185r153 = $fir_riadok->m185r153;
$m185r154 = $fir_riadok->m185r154;
$m185r155 = $fir_riadok->m185r155;
$m185r156 = $fir_riadok->m185r156;
$m185r157 = $fir_riadok->m185r157;
$m185r161 = $fir_riadok->m185r161;
$m185r162 = $fir_riadok->m185r162;
$m185r163 = $fir_riadok->m185r163;
$m185r164 = $fir_riadok->m185r164;
$m185r165 = $fir_riadok->m185r165;
$m185r166 = $fir_riadok->m185r166;
$m185r167 = $fir_riadok->m185r167;
$m185r171 = $fir_riadok->m185r171;
$m185r172 = $fir_riadok->m185r172;
$m185r173 = $fir_riadok->m185r173;
$m185r174 = $fir_riadok->m185r174;
$m185r175 = $fir_riadok->m185r175;
$m185r176 = $fir_riadok->m185r176;
$m185r177 = $fir_riadok->m185r177;
$m185r181 = $fir_riadok->m185r181;
$m185r182 = $fir_riadok->m185r182;
$m185r183 = $fir_riadok->m185r183;
$m185r184 = $fir_riadok->m185r184;
$m185r185 = $fir_riadok->m185r185;
$m185r186 = $fir_riadok->m185r186;
$m185r187 = $fir_riadok->m185r187;
$m185r191 = $fir_riadok->m185r191;
$m185r192 = $fir_riadok->m185r192;
$m185r193 = $fir_riadok->m185r193;
$m185r194 = $fir_riadok->m185r194;
$m185r195 = $fir_riadok->m185r195;
$m185r196 = $fir_riadok->m185r196;
$m185r197 = $fir_riadok->m185r197;
$m185r201 = $fir_riadok->m185r201;
$m185r202 = $fir_riadok->m185r202;
$m185r203 = $fir_riadok->m185r203;
$m185r204 = $fir_riadok->m185r204;
$m185r205 = $fir_riadok->m185r205;
$m185r206 = $fir_riadok->m185r206;
$m185r207 = $fir_riadok->m185r207;
$m185r211 = $fir_riadok->m185r211;
$m185r212 = $fir_riadok->m185r212;
$m185r213 = $fir_riadok->m185r213;
$m185r214 = $fir_riadok->m185r214;
$m185r215 = $fir_riadok->m185r215;
$m185r216 = $fir_riadok->m185r216;
$m185r217 = $fir_riadok->m185r217;
$m185r221 = $fir_riadok->m185r221;
$m185r222 = $fir_riadok->m185r222;
$m185r223 = $fir_riadok->m185r223;
$m185r224 = $fir_riadok->m185r224;
$m185r225 = $fir_riadok->m185r225;
$m185r226 = $fir_riadok->m185r226;
$m185r227 = $fir_riadok->m185r227;
$m185r231 = $fir_riadok->m185r231;
$m185r232 = $fir_riadok->m185r232;
$m185r233 = $fir_riadok->m185r233;
$m185r234 = $fir_riadok->m185r234;
$m185r235 = $fir_riadok->m185r235;
$m185r236 = $fir_riadok->m185r236;
$m185r237 = $fir_riadok->m185r237;
$m185r241 = $fir_riadok->m185r241;
$m185r242 = $fir_riadok->m185r242;
$m185r243 = $fir_riadok->m185r243;
$m185r244 = $fir_riadok->m185r244;
$m185r245 = $fir_riadok->m185r245;
$m185r246 = $fir_riadok->m185r246;
$m185r247 = $fir_riadok->m185r247;
$m185r251 = $fir_riadok->m185r251;
$m185r252 = $fir_riadok->m185r252;
$m185r253 = $fir_riadok->m185r253;
$m185r254 = $fir_riadok->m185r254;
$m185r255 = $fir_riadok->m185r255;
$m185r256 = $fir_riadok->m185r256;
$m185r257 = $fir_riadok->m185r257;
$m185r261 = $fir_riadok->m185r261;
$m185r262 = $fir_riadok->m185r262;
$m185r263 = $fir_riadok->m185r263;
$m185r264 = $fir_riadok->m185r264;
$m185r265 = $fir_riadok->m185r265;
$m185r266 = $fir_riadok->m185r266;
$m185r267 = $fir_riadok->m185r267;
$m185r271 = $fir_riadok->m185r271;
$m185r272 = $fir_riadok->m185r272;
$m185r273 = $fir_riadok->m185r273;
$m185r274 = $fir_riadok->m185r274;
$m185r275 = $fir_riadok->m185r275;
$m185r276 = $fir_riadok->m185r276;
$m185r277 = $fir_riadok->m185r277;
$m185r281 = $fir_riadok->m185r281;
$m185r282 = $fir_riadok->m185r282;
$m185r283 = $fir_riadok->m185r283;
$m185r284 = $fir_riadok->m185r284;
$m185r285 = $fir_riadok->m185r285;
$m185r286 = $fir_riadok->m185r286;
$m185r287 = $fir_riadok->m185r287;
$m185r291 = $fir_riadok->m185r291;
$m185r292 = $fir_riadok->m185r292;
$m185r293 = $fir_riadok->m185r293;
$m185r294 = $fir_riadok->m185r294;
$m185r295 = $fir_riadok->m185r295;
$m185r296 = $fir_riadok->m185r296;
$m185r297 = $fir_riadok->m185r297;
$m185r301 = $fir_riadok->m185r301;
$m185r302 = $fir_riadok->m185r302;
$m185r303 = $fir_riadok->m185r303;
$m185r304 = $fir_riadok->m185r304;
$m185r305 = $fir_riadok->m185r305;
$m185r306 = $fir_riadok->m185r306;
$m185r307 = $fir_riadok->m185r307;
$m185r992 = $fir_riadok->m185r992;
$m185r993 = $fir_riadok->m185r993;
$m185r994 = $fir_riadok->m185r994;
$m185r995 = $fir_riadok->m185r995;
$m185r996 = $fir_riadok->m185r996;
$m185r997 = $fir_riadok->m185r997;


$sqlfir = "SELECT * FROM F$kli_vxcf"."_statistika_zav101s2 WHERE ico >= 0";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
//9.strana
$m186r11 = $fir_riadok->m186r11;
$m186r12 = $fir_riadok->m186r12;
$m186r13 = $fir_riadok->m186r13;
$m186r14 = $fir_riadok->m186r14;
$m186r15 = $fir_riadok->m186r15;
$m186r16 = $fir_riadok->m186r16;
$m186r17 = $fir_riadok->m186r17;
$m186r21 = $fir_riadok->m186r21;
$m186r22 = $fir_riadok->m186r22;
$m186r23 = $fir_riadok->m186r23;
$m186r24 = $fir_riadok->m186r24;
$m186r25 = $fir_riadok->m186r25;
$m186r26 = $fir_riadok->m186r26;
$m186r27 = $fir_riadok->m186r27;
$m186r31 = $fir_riadok->m186r31;
$m186r32 = $fir_riadok->m186r32;
$m186r33 = $fir_riadok->m186r33;
$m186r34 = $fir_riadok->m186r34;
$m186r35 = $fir_riadok->m186r35;
$m186r36 = $fir_riadok->m186r36;
$m186r37 = $fir_riadok->m186r37;
$m186r41 = $fir_riadok->m186r41;
$m186r42 = $fir_riadok->m186r42;
$m186r43 = $fir_riadok->m186r43;
$m186r44 = $fir_riadok->m186r44;
$m186r45 = $fir_riadok->m186r45;
$m186r46 = $fir_riadok->m186r46;
$m186r47 = $fir_riadok->m186r47;
$m186r51 = $fir_riadok->m186r51;
$m186r52 = $fir_riadok->m186r52;
$m186r53 = $fir_riadok->m186r53;
$m186r54 = $fir_riadok->m186r54;
$m186r55 = $fir_riadok->m186r55;
$m186r56 = $fir_riadok->m186r56;
$m186r57 = $fir_riadok->m186r57;
$m186r61 = $fir_riadok->m186r61;
$m186r62 = $fir_riadok->m186r62;
$m186r63 = $fir_riadok->m186r63;
$m186r64 = $fir_riadok->m186r64;
$m186r65 = $fir_riadok->m186r65;
$m186r66 = $fir_riadok->m186r66;
$m186r67 = $fir_riadok->m186r67;
$m186r71 = $fir_riadok->m186r71;
$m186r72 = $fir_riadok->m186r72;
$m186r73 = $fir_riadok->m186r73;
$m186r74 = $fir_riadok->m186r74;
$m186r75 = $fir_riadok->m186r75;
$m186r76 = $fir_riadok->m186r76;
$m186r77 = $fir_riadok->m186r77;
$m186r81 = $fir_riadok->m186r81;
$m186r82 = $fir_riadok->m186r82;
$m186r83 = $fir_riadok->m186r83;
$m186r84 = $fir_riadok->m186r84;
$m186r85 = $fir_riadok->m186r85;
$m186r86 = $fir_riadok->m186r86;
$m186r87 = $fir_riadok->m186r87;
$m186r91 = $fir_riadok->m186r91;
$m186r92 = $fir_riadok->m186r92;
$m186r93 = $fir_riadok->m186r93;
$m186r94 = $fir_riadok->m186r94;
$m186r95 = $fir_riadok->m186r95;
$m186r96 = $fir_riadok->m186r96;
$m186r97 = $fir_riadok->m186r97;
$m186r101 = $fir_riadok->m186r101;
$m186r102 = $fir_riadok->m186r102;
$m186r103 = $fir_riadok->m186r103;
$m186r104 = $fir_riadok->m186r104;
$m186r105 = $fir_riadok->m186r105;
$m186r106 = $fir_riadok->m186r106;
$m186r107 = $fir_riadok->m186r107;
$m186r111 = $fir_riadok->m186r111;
$m186r112 = $fir_riadok->m186r112;
$m186r113 = $fir_riadok->m186r113;
$m186r114 = $fir_riadok->m186r114;
$m186r115 = $fir_riadok->m186r115;
$m186r116 = $fir_riadok->m186r116;
$m186r117 = $fir_riadok->m186r117;
$m186r121 = $fir_riadok->m186r121;
$m186r122 = $fir_riadok->m186r122;
$m186r123 = $fir_riadok->m186r123;
$m186r124 = $fir_riadok->m186r124;
$m186r125 = $fir_riadok->m186r125;
$m186r126 = $fir_riadok->m186r126;
$m186r127 = $fir_riadok->m186r127;
$m186r131 = $fir_riadok->m186r131;
$m186r132 = $fir_riadok->m186r132;
$m186r133 = $fir_riadok->m186r133;
$m186r134 = $fir_riadok->m186r134;
$m186r135 = $fir_riadok->m186r135;
$m186r136 = $fir_riadok->m186r136;
$m186r137 = $fir_riadok->m186r137;
$m186r141 = $fir_riadok->m186r141;
$m186r142 = $fir_riadok->m186r142;
$m186r143 = $fir_riadok->m186r143;
$m186r144 = $fir_riadok->m186r144;
$m186r145 = $fir_riadok->m186r145;
$m186r146 = $fir_riadok->m186r146;
$m186r147 = $fir_riadok->m186r147;
$m186r151 = $fir_riadok->m186r151;
$m186r152 = $fir_riadok->m186r152;
$m186r153 = $fir_riadok->m186r153;
$m186r154 = $fir_riadok->m186r154;
$m186r155 = $fir_riadok->m186r155;
$m186r156 = $fir_riadok->m186r156;
$m186r157 = $fir_riadok->m186r157;
$m186r161 = $fir_riadok->m186r161;
$m186r162 = $fir_riadok->m186r162;
$m186r163 = $fir_riadok->m186r163;
$m186r164 = $fir_riadok->m186r164;
$m186r165 = $fir_riadok->m186r165;
$m186r166 = $fir_riadok->m186r166;
$m186r167 = $fir_riadok->m186r167;
$m186r171 = $fir_riadok->m186r171;
$m186r172 = $fir_riadok->m186r172;
$m186r173 = $fir_riadok->m186r173;
$m186r174 = $fir_riadok->m186r174;
$m186r175 = $fir_riadok->m186r175;
$m186r176 = $fir_riadok->m186r176;
$m186r177 = $fir_riadok->m186r177;
$m186r181 = $fir_riadok->m186r181;
$m186r182 = $fir_riadok->m186r182;
$m186r183 = $fir_riadok->m186r183;
$m186r184 = $fir_riadok->m186r184;
$m186r185 = $fir_riadok->m186r185;
$m186r186 = $fir_riadok->m186r186;
$m186r187 = $fir_riadok->m186r187;
$m186r191 = $fir_riadok->m186r191;
$m186r192 = $fir_riadok->m186r192;
$m186r193 = $fir_riadok->m186r193;
$m186r194 = $fir_riadok->m186r194;
$m186r195 = $fir_riadok->m186r195;
$m186r196 = $fir_riadok->m186r196;
$m186r197 = $fir_riadok->m186r197;
$m186r201 = $fir_riadok->m186r201;
$m186r202 = $fir_riadok->m186r202;
$m186r203 = $fir_riadok->m186r203;
$m186r204 = $fir_riadok->m186r204;
$m186r205 = $fir_riadok->m186r205;
$m186r206 = $fir_riadok->m186r206;
$m186r207 = $fir_riadok->m186r207;
$m186r211 = $fir_riadok->m186r211;
$m186r212 = $fir_riadok->m186r212;
$m186r213 = $fir_riadok->m186r213;
$m186r214 = $fir_riadok->m186r214;
$m186r215 = $fir_riadok->m186r215;
$m186r216 = $fir_riadok->m186r216;
$m186r217 = $fir_riadok->m186r217;
$m186r221 = $fir_riadok->m186r221;
$m186r222 = $fir_riadok->m186r222;
$m186r223 = $fir_riadok->m186r223;
$m186r224 = $fir_riadok->m186r224;
$m186r225 = $fir_riadok->m186r225;
$m186r226 = $fir_riadok->m186r226;
$m186r227 = $fir_riadok->m186r227;
$m186r231 = $fir_riadok->m186r231;
$m186r232 = $fir_riadok->m186r232;
$m186r233 = $fir_riadok->m186r233;
$m186r234 = $fir_riadok->m186r234;
$m186r235 = $fir_riadok->m186r235;
$m186r236 = $fir_riadok->m186r236;
$m186r237 = $fir_riadok->m186r237;
$m186r241 = $fir_riadok->m186r241;
$m186r242 = $fir_riadok->m186r242;
$m186r243 = $fir_riadok->m186r243;
$m186r244 = $fir_riadok->m186r244;
$m186r245 = $fir_riadok->m186r245;
$m186r246 = $fir_riadok->m186r246;
$m186r247 = $fir_riadok->m186r247;
$m186r251 = $fir_riadok->m186r251;
$m186r252 = $fir_riadok->m186r252;
$m186r253 = $fir_riadok->m186r253;
$m186r254 = $fir_riadok->m186r254;
$m186r255 = $fir_riadok->m186r255;
$m186r256 = $fir_riadok->m186r256;
$m186r257 = $fir_riadok->m186r257;
$m186r261 = $fir_riadok->m186r261;
$m186r262 = $fir_riadok->m186r262;
$m186r263 = $fir_riadok->m186r263;
$m186r264 = $fir_riadok->m186r264;
$m186r265 = $fir_riadok->m186r265;
$m186r266 = $fir_riadok->m186r266;
$m186r267 = $fir_riadok->m186r267;
$m186r271 = $fir_riadok->m186r271;
$m186r272 = $fir_riadok->m186r272;
$m186r273 = $fir_riadok->m186r273;
$m186r274 = $fir_riadok->m186r274;
$m186r275 = $fir_riadok->m186r275;
$m186r276 = $fir_riadok->m186r276;
$m186r277 = $fir_riadok->m186r277;
$m186r281 = $fir_riadok->m186r281;
$m186r282 = $fir_riadok->m186r282;
$m186r283 = $fir_riadok->m186r283;
$m186r284 = $fir_riadok->m186r284;
$m186r285 = $fir_riadok->m186r285;
$m186r286 = $fir_riadok->m186r286;
$m186r287 = $fir_riadok->m186r287;
$m186r291 = $fir_riadok->m186r291;
$m186r292 = $fir_riadok->m186r292;
$m186r293 = $fir_riadok->m186r293;
$m186r294 = $fir_riadok->m186r294;
$m186r295 = $fir_riadok->m186r295;
$m186r296 = $fir_riadok->m186r296;
$m186r297 = $fir_riadok->m186r297;
$m186r301 = $fir_riadok->m186r301;
$m186r302 = $fir_riadok->m186r302;
$m186r303 = $fir_riadok->m186r303;
$m186r304 = $fir_riadok->m186r304;
$m186r305 = $fir_riadok->m186r305;
$m186r306 = $fir_riadok->m186r306;
$m186r307 = $fir_riadok->m186r307;
$m186r992 = $fir_riadok->m186r992;
$m186r993 = $fir_riadok->m186r993;
$m186r994 = $fir_riadok->m186r994;
$m186r995 = $fir_riadok->m186r995;
$m186r996 = $fir_riadok->m186r996;
$m186r997 = $fir_riadok->m186r997;
//10.strana
$m187r1 = $fir_riadok->m187r1;
$m1590r1a = $fir_riadok->m1590r1a;
$m1590r1b = $fir_riadok->m1590r1b;
$m1590r2a = $fir_riadok->m1590r2a;
$m1590r2b = $fir_riadok->m1590r2b;
$m590r11 = $fir_riadok->m590r11;
$m590r12 = $fir_riadok->m590r12;
$m590r13 = $fir_riadok->m590r13;
$m590r14 = $fir_riadok->m590r14;
$m590r15 = $fir_riadok->m590r15;
$m590r21 = $fir_riadok->m590r21;
$m590r22 = $fir_riadok->m590r22;
$m590r23 = $fir_riadok->m590r23;
$m590r24 = $fir_riadok->m590r24;
$m590r25 = $fir_riadok->m590r25;
$m590r31 = $fir_riadok->m590r31;
$m590r32 = $fir_riadok->m590r32;
$m590r33 = $fir_riadok->m590r33;
$m590r34 = $fir_riadok->m590r34;
$m590r35 = $fir_riadok->m590r35;
$m590r41 = $fir_riadok->m590r41;
$m590r42 = $fir_riadok->m590r42;
$m590r43 = $fir_riadok->m590r43;
$m590r44 = $fir_riadok->m590r44;
$m590r45 = $fir_riadok->m590r45;
$m590r51 = $fir_riadok->m590r51;
$m590r52 = $fir_riadok->m590r52;
$m590r53 = $fir_riadok->m590r53;
$m590r54 = $fir_riadok->m590r54;
$m590r55 = $fir_riadok->m590r55;
$m590r61 = $fir_riadok->m590r61;
$m590r62 = $fir_riadok->m590r62;
$m590r63 = $fir_riadok->m590r63;
$m590r64 = $fir_riadok->m590r64;
$m590r65 = $fir_riadok->m590r65;
$m590r71 = $fir_riadok->m590r71;
$m590r72 = $fir_riadok->m590r72;
$m590r73 = $fir_riadok->m590r73;
$m590r74 = $fir_riadok->m590r74;
$m590r75 = $fir_riadok->m590r75;
$m590r81 = $fir_riadok->m590r81;
$m590r82 = $fir_riadok->m590r82;
$m590r83 = $fir_riadok->m590r83;
$m590r84 = $fir_riadok->m590r84;
$m590r85 = $fir_riadok->m590r85;
$m590r91 = $fir_riadok->m590r91;
$m590r92 = $fir_riadok->m590r92;
$m590r93 = $fir_riadok->m590r93;
$m590r94 = $fir_riadok->m590r94;
$m590r95 = $fir_riadok->m590r95;
$m590r101 = $fir_riadok->m590r101;
$m590r102 = $fir_riadok->m590r102;
$m590r103 = $fir_riadok->m590r103;
$m590r104 = $fir_riadok->m590r104;
$m590r105 = $fir_riadok->m590r105;
$m590r111 = $fir_riadok->m590r111;
$m590r112 = $fir_riadok->m590r112;
$m590r113 = $fir_riadok->m590r113;
$m590r114 = $fir_riadok->m590r114;
$m590r115 = $fir_riadok->m590r115;
$m590r121 = $fir_riadok->m590r121;
$m590r122 = $fir_riadok->m590r122;
$m590r123 = $fir_riadok->m590r123;
$m590r124 = $fir_riadok->m590r124;
$m590r125 = $fir_riadok->m590r125;
$m590r131 = $fir_riadok->m590r131;
$m590r132 = $fir_riadok->m590r132;
$m590r133 = $fir_riadok->m590r133;
$m590r134 = $fir_riadok->m590r134;
$m590r135 = $fir_riadok->m590r135;
$m590r141 = $fir_riadok->m590r141;
$m590r142 = $fir_riadok->m590r142;
$m590r143 = $fir_riadok->m590r143;
$m590r144 = $fir_riadok->m590r144;
$m590r145 = $fir_riadok->m590r145;
$m590r151 = $fir_riadok->m590r151;
$m590r152 = $fir_riadok->m590r152;
$m590r153 = $fir_riadok->m590r153;
$m590r154 = $fir_riadok->m590r154;
$m590r155 = $fir_riadok->m590r155;
$m590r161 = $fir_riadok->m590r161;
$m590r162 = $fir_riadok->m590r162;
$m590r163 = $fir_riadok->m590r163;
$m590r164 = $fir_riadok->m590r164;
$m590r165 = $fir_riadok->m590r165;
$m590r171 = $fir_riadok->m590r171;
$m590r172 = $fir_riadok->m590r172;
$m590r173 = $fir_riadok->m590r173;
$m590r174 = $fir_riadok->m590r174;
$m590r175 = $fir_riadok->m590r175;
$m590r181 = $fir_riadok->m590r181;
$m590r182 = $fir_riadok->m590r182;
$m590r183 = $fir_riadok->m590r183;
$m590r184 = $fir_riadok->m590r184;
$m590r185 = $fir_riadok->m590r185;
$m590r191 = $fir_riadok->m590r191;
$m590r192 = $fir_riadok->m590r192;
$m590r193 = $fir_riadok->m590r193;
$m590r194 = $fir_riadok->m590r194;
$m590r195 = $fir_riadok->m590r195;
$m590r201 = $fir_riadok->m590r201;
$m590r202 = $fir_riadok->m590r202;
$m590r203 = $fir_riadok->m590r203;
$m590r204 = $fir_riadok->m590r204;
$m590r205 = $fir_riadok->m590r205;
$m590r992 = $fir_riadok->m590r992;
$m590r993 = $fir_riadok->m590r993;
$m590r994 = $fir_riadok->m590r994;
$m590r995 = $fir_riadok->m590r995;
//11.strana
$m304r1 = $fir_riadok->m304r1;
$m304r2 = $fir_riadok->m304r2;
$m304r3 = $fir_riadok->m304r3;
$m304r4 = $fir_riadok->m304r4;
$m304r5 = $fir_riadok->m304r5;
$m304r6 = $fir_riadok->m304r6;
$m304r7 = $fir_riadok->m304r7;
$m304r8 = $fir_riadok->m304r8;
$m304r9 = $fir_riadok->m304r9;
$m304r10 = $fir_riadok->m304r10;
$m304r11 = $fir_riadok->m304r11;
$m304r12 = $fir_riadok->m304r12;
$m304r13 = $fir_riadok->m304r13;
$m304r14 = $fir_riadok->m304r14;
$m304r15 = $fir_riadok->m304r15;
$m304r16 = $fir_riadok->m304r16;
$m304r99 = $fir_riadok->m304r99;
//12.strana
$m110r12 = $fir_riadok->m110r12;
$m110r13 = $fir_riadok->m110r13;
$m110r14 = $fir_riadok->m110r14;
$m110r15 = $fir_riadok->m110r15;
$m110r16 = $fir_riadok->m110r16;
$m110r17 = $fir_riadok->m110r17;
$m110r18 = $fir_riadok->m110r18;
$m110r19 = $fir_riadok->m110r19;
$m110r22 = $fir_riadok->m110r22;
$m110r23 = $fir_riadok->m110r23;
$m110r24 = $fir_riadok->m110r24;
$m110r25 = $fir_riadok->m110r25;
$m110r26 = $fir_riadok->m110r26;
$m110r27 = $fir_riadok->m110r27;
$m110r28 = $fir_riadok->m110r28;
$m110r29 = $fir_riadok->m110r29;
$m110r32 = $fir_riadok->m110r32;
$m110r33 = $fir_riadok->m110r33;
$m110r34 = $fir_riadok->m110r34;
$m110r35 = $fir_riadok->m110r35;
$m110r36 = $fir_riadok->m110r36;
$m110r37 = $fir_riadok->m110r37;
$m110r38 = $fir_riadok->m110r38;
$m110r39 = $fir_riadok->m110r39;
$m110r42 = $fir_riadok->m110r42;
$m110r43 = $fir_riadok->m110r43;
$m110r44 = $fir_riadok->m110r44;
$m110r45 = $fir_riadok->m110r45;
$m110r46 = $fir_riadok->m110r46;
$m110r47 = $fir_riadok->m110r47;
$m110r48 = $fir_riadok->m110r48;
$m110r49 = $fir_riadok->m110r49;
$m110r52 = $fir_riadok->m110r52;
$m110r53 = $fir_riadok->m110r53;
$m110r54 = $fir_riadok->m110r54;
$m110r55 = $fir_riadok->m110r55;
$m110r56 = $fir_riadok->m110r56;
$m110r57 = $fir_riadok->m110r57;
$m110r58 = $fir_riadok->m110r58;
$m110r59 = $fir_riadok->m110r59;
$m110r62 = $fir_riadok->m110r62;
$m110r63 = $fir_riadok->m110r63;
$m110r64 = $fir_riadok->m110r64;
$m110r65 = $fir_riadok->m110r65;
$m110r66 = $fir_riadok->m110r66;
$m110r67 = $fir_riadok->m110r67;
$m110r68 = $fir_riadok->m110r68;
$m110r69 = $fir_riadok->m110r69;
$m110r72 = $fir_riadok->m110r72;
$m110r73 = $fir_riadok->m110r73;
$m110r74 = $fir_riadok->m110r74;
$m110r75 = $fir_riadok->m110r75;
$m110r76 = $fir_riadok->m110r76;
$m110r77 = $fir_riadok->m110r77;
$m110r78 = $fir_riadok->m110r78;
$m110r79 = $fir_riadok->m110r79;
$m110r82 = $fir_riadok->m110r82;
$m110r83 = $fir_riadok->m110r83;
$m110r84 = $fir_riadok->m110r84;
$m110r85 = $fir_riadok->m110r85;
$m110r86 = $fir_riadok->m110r86;
$m110r87 = $fir_riadok->m110r87;
$m110r88 = $fir_riadok->m110r88;
$m110r89 = $fir_riadok->m110r89;
$m110r92 = $fir_riadok->m110r92;
$m110r93 = $fir_riadok->m110r93;
$m110r94 = $fir_riadok->m110r94;
$m110r95 = $fir_riadok->m110r95;
$m110r96 = $fir_riadok->m110r96;
$m110r97 = $fir_riadok->m110r97;
$m110r98 = $fir_riadok->m110r98;
$m110r99 = $fir_riadok->m110r99;
$m110r102 = $fir_riadok->m110r102;
$m110r103 = $fir_riadok->m110r103;
$m110r104 = $fir_riadok->m110r104;
$m110r105 = $fir_riadok->m110r105;
$m110r106 = $fir_riadok->m110r106;
$m110r107 = $fir_riadok->m110r107;
$m110r108 = $fir_riadok->m110r108;
$m110r109 = $fir_riadok->m110r109;
$m110r112 = $fir_riadok->m110r112;
$m110r113 = $fir_riadok->m110r113;
$m110r114 = $fir_riadok->m110r114;
$m110r115 = $fir_riadok->m110r115;
$m110r116 = $fir_riadok->m110r116;
$m110r117 = $fir_riadok->m110r117;
$m110r118 = $fir_riadok->m110r118;
$m110r119 = $fir_riadok->m110r119;
$m110r122 = $fir_riadok->m110r122;
$m110r123 = $fir_riadok->m110r123;
$m110r124 = $fir_riadok->m110r124;
$m110r125 = $fir_riadok->m110r125;
$m110r126 = $fir_riadok->m110r126;
$m110r127 = $fir_riadok->m110r127;
$m110r128 = $fir_riadok->m110r128;
$m110r129 = $fir_riadok->m110r129;
$m110r132 = $fir_riadok->m110r132;
$m110r133 = $fir_riadok->m110r133;
$m110r134 = $fir_riadok->m110r134;
$m110r135 = $fir_riadok->m110r135;
$m110r136 = $fir_riadok->m110r136;
$m110r137 = $fir_riadok->m110r137;
$m110r138 = $fir_riadok->m110r138;
$m110r139 = $fir_riadok->m110r139;
$m110r142 = $fir_riadok->m110r142;
$m110r143 = $fir_riadok->m110r143;
$m110r144 = $fir_riadok->m110r144;
$m110r145 = $fir_riadok->m110r145;
$m110r146 = $fir_riadok->m110r146;
$m110r147 = $fir_riadok->m110r147;
$m110r148 = $fir_riadok->m110r148;
$m110r149 = $fir_riadok->m110r149;
$m110r152 = $fir_riadok->m110r152;
$m110r153 = $fir_riadok->m110r153;
$m110r154 = $fir_riadok->m110r154;
$m110r155 = $fir_riadok->m110r155;
$m110r156 = $fir_riadok->m110r156;
$m110r157 = $fir_riadok->m110r157;
$m110r158 = $fir_riadok->m110r158;
$m110r159 = $fir_riadok->m110r159;
$m110r162 = $fir_riadok->m110r162;
$m110r163 = $fir_riadok->m110r163;
$m110r164 = $fir_riadok->m110r164;
$m110r165 = $fir_riadok->m110r165;
$m110r166 = $fir_riadok->m110r166;
$m110r167 = $fir_riadok->m110r167;
$m110r168 = $fir_riadok->m110r168;
$m110r169 = $fir_riadok->m110r169;
$m110r172 = $fir_riadok->m110r172;
$m110r173 = $fir_riadok->m110r173;
$m110r174 = $fir_riadok->m110r174;
$m110r175 = $fir_riadok->m110r175;
$m110r176 = $fir_riadok->m110r176;
$m110r177 = $fir_riadok->m110r177;
$m110r178 = $fir_riadok->m110r178;
$m110r179 = $fir_riadok->m110r179;
$m110r182 = $fir_riadok->m110r182;
$m110r183 = $fir_riadok->m110r183;
$m110r184 = $fir_riadok->m110r184;
$m110r185 = $fir_riadok->m110r185;
$m110r186 = $fir_riadok->m110r186;
$m110r187 = $fir_riadok->m110r187;
$m110r188 = $fir_riadok->m110r188;
$m110r189 = $fir_riadok->m110r189;
$m110r192 = $fir_riadok->m110r192;
$m110r193 = $fir_riadok->m110r193;
$m110r194 = $fir_riadok->m110r194;
$m110r195 = $fir_riadok->m110r195;
$m110r196 = $fir_riadok->m110r196;
$m110r197 = $fir_riadok->m110r197;
$m110r198 = $fir_riadok->m110r198;
$m110r199 = $fir_riadok->m110r199;
$m110r202 = $fir_riadok->m110r202;
$m110r203 = $fir_riadok->m110r203;
$m110r204 = $fir_riadok->m110r204;
$m110r205 = $fir_riadok->m110r205;
$m110r206 = $fir_riadok->m110r206;
$m110r207 = $fir_riadok->m110r207;
$m110r208 = $fir_riadok->m110r208;
$m110r209 = $fir_riadok->m110r209;
$m110r212 = $fir_riadok->m110r212;
$m110r213 = $fir_riadok->m110r213;
$m110r214 = $fir_riadok->m110r214;
$m110r215 = $fir_riadok->m110r215;
$m110r216 = $fir_riadok->m110r216;
$m110r217 = $fir_riadok->m110r217;
$m110r218 = $fir_riadok->m110r218;
$m110r219 = $fir_riadok->m110r219;
$m110r222 = $fir_riadok->m110r222;
$m110r224 = $fir_riadok->m110r224;
$m110r226 = $fir_riadok->m110r226;
$m110r228 = $fir_riadok->m110r228;
$m110r232 = $fir_riadok->m110r232;
$m110r234 = $fir_riadok->m110r234;
$m110r236 = $fir_riadok->m110r236;
$m110r238 = $fir_riadok->m110r238;
$m110r242 = $fir_riadok->m110r242;
$m110r243 = $fir_riadok->m110r243;
$m110r244 = $fir_riadok->m110r244;
$m110r245 = $fir_riadok->m110r245;
$m110r246 = $fir_riadok->m110r246;
$m110r247 = $fir_riadok->m110r247;
$m110r248 = $fir_riadok->m110r248;
$m110r249 = $fir_riadok->m110r249;
$m110r252 = $fir_riadok->m110r252;
$m110r253 = $fir_riadok->m110r253;
$m110r254 = $fir_riadok->m110r254;
$m110r255 = $fir_riadok->m110r255;
$m110r256 = $fir_riadok->m110r256;
$m110r257 = $fir_riadok->m110r257;
$m110r258 = $fir_riadok->m110r258;
$m110r259 = $fir_riadok->m110r259;
$m110r262 = $fir_riadok->m110r262;
$m110r263 = $fir_riadok->m110r263;
$m110r264 = $fir_riadok->m110r264;
$m110r265 = $fir_riadok->m110r265;
$m110r266 = $fir_riadok->m110r266;
$m110r267 = $fir_riadok->m110r267;
$m110r268 = $fir_riadok->m110r268;
$m110r269 = $fir_riadok->m110r269;
$m110r272 = $fir_riadok->m110r272;
$m110r273 = $fir_riadok->m110r273;
$m110r274 = $fir_riadok->m110r274;
$m110r275 = $fir_riadok->m110r275;
$m110r276 = $fir_riadok->m110r276;
$m110r277 = $fir_riadok->m110r277;
$m110r278 = $fir_riadok->m110r278;
$m110r279 = $fir_riadok->m110r279;
$m110r282 = $fir_riadok->m110r282;
$m110r283 = $fir_riadok->m110r283;
$m110r284 = $fir_riadok->m110r284;
$m110r285 = $fir_riadok->m110r285;
$m110r286 = $fir_riadok->m110r286;
$m110r287 = $fir_riadok->m110r287;
$m110r288 = $fir_riadok->m110r288;
$m110r289 = $fir_riadok->m110r289;
$m110r292 = $fir_riadok->m110r292;
$m110r293 = $fir_riadok->m110r293;
$m110r294 = $fir_riadok->m110r294;
$m110r295 = $fir_riadok->m110r295;
$m110r296 = $fir_riadok->m110r296;
$m110r297 = $fir_riadok->m110r297;
$m110r298 = $fir_riadok->m110r298;
$m110r299 = $fir_riadok->m110r299;
$m110r302 = $fir_riadok->m110r302;
$m110r303 = $fir_riadok->m110r303;
$m110r304 = $fir_riadok->m110r304;
$m110r305 = $fir_riadok->m110r305;
$m110r306 = $fir_riadok->m110r306;
$m110r307 = $fir_riadok->m110r307;
$m110r308 = $fir_riadok->m110r308;
$m110r309 = $fir_riadok->m110r309;
$m110r312 = $fir_riadok->m110r312;
$m110r313 = $fir_riadok->m110r313;
$m110r314 = $fir_riadok->m110r314;
$m110r315 = $fir_riadok->m110r315;
$m110r316 = $fir_riadok->m110r316;
$m110r317 = $fir_riadok->m110r317;
$m110r318 = $fir_riadok->m110r318;
$m110r319 = $fir_riadok->m110r319;
$m110r322 = $fir_riadok->m110r322;
$m110r323 = $fir_riadok->m110r323;
$m110r324 = $fir_riadok->m110r324;
$m110r325 = $fir_riadok->m110r325;
$m110r326 = $fir_riadok->m110r326;
$m110r327 = $fir_riadok->m110r327;
$m110r328 = $fir_riadok->m110r328;
$m110r329 = $fir_riadok->m110r329;
$m110r332 = $fir_riadok->m110r332;
$m110r334 = $fir_riadok->m110r334;
$m110r336 = $fir_riadok->m110r336;
$m110r338 = $fir_riadok->m110r338;
$m110r342 = $fir_riadok->m110r342;
$m110r344 = $fir_riadok->m110r344;
$m110r346 = $fir_riadok->m110r346;
$m110r348 = $fir_riadok->m110r348;
$m110r992 = $fir_riadok->m110r992;
$m110r993 = $fir_riadok->m110r993;
$m110r994 = $fir_riadok->m110r994;
$m110r995 = $fir_riadok->m110r995;
$m110r996 = $fir_riadok->m110r996;
$m110r997 = $fir_riadok->m110r997;
$m110r998 = $fir_riadok->m110r998;
$m110r999 = $fir_riadok->m110r999;

mysql_free_result($fir_vysledok);
     }
//koniec nacitania

//kod okresu z treximy
$okres="";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_treximafir ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $okres=$riaddok->uzemie;
  }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - výkaz Roè ZAV 1-01</title>
<style type="text/css">
img.btn-row-tool {
  width: 20px;
  height: 20px;
}
form input[type=text] {
  position: absolute;
  height: 18px;
  line-height: 18px;
  padding-left: 4px;
  border: 1px solid #39f;
  font-size: 14px;
}
</style>

<script type="text/javascript">
<?php
//uprava
  if ( $copern == 102 )
  {
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
   document.formv1.odoslane.value = '<?php echo "$odoslane_sk";?>';
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
   document.formv1.m592r11.value = '<?php echo "$m592r11";?>';
   document.formv1.m592r12.value = '<?php echo "$m592r12";?>';
   document.formv1.m592r13.value = '<?php echo "$m592r13";?>';
   document.formv1.m592r14.value = '<?php echo "$m592r14";?>';
   document.formv1.m592r15.value = '<?php echo "$m592r15";?>';
   document.formv1.m592r16.value = '<?php echo "$m592r16";?>';
   document.formv1.m592r21.value = '<?php echo "$m592r21";?>';
   document.formv1.m592r22.value = '<?php echo "$m592r22";?>';
   document.formv1.m592r23.value = '<?php echo "$m592r23";?>';
   document.formv1.m592r24.value = '<?php echo "$m592r24";?>';
   document.formv1.m592r25.value = '<?php echo "$m592r25";?>';
   document.formv1.m592r26.value = '<?php echo "$m592r26";?>';
   document.formv1.m592r31.value = '<?php echo "$m592r31";?>';
   document.formv1.m592r32.value = '<?php echo "$m592r32";?>';
   document.formv1.m592r33.value = '<?php echo "$m592r33";?>';
   document.formv1.m592r34.value = '<?php echo "$m592r34";?>';
   document.formv1.m592r35.value = '<?php echo "$m592r35";?>';
   document.formv1.m592r36.value = '<?php echo "$m592r36";?>';
   document.formv1.m592r41.value = '<?php echo "$m592r41";?>';
   document.formv1.m592r42.value = '<?php echo "$m592r42";?>';
   document.formv1.m592r43.value = '<?php echo "$m592r43";?>';
   document.formv1.m592r44.value = '<?php echo "$m592r44";?>';
   document.formv1.m592r45.value = '<?php echo "$m592r45";?>';
   document.formv1.m592r46.value = '<?php echo "$m592r46";?>';
   document.formv1.m592r51.value = '<?php echo "$m592r51";?>';
   document.formv1.m592r52.value = '<?php echo "$m592r52";?>';
   document.formv1.m592r53.value = '<?php echo "$m592r53";?>';
   document.formv1.m592r54.value = '<?php echo "$m592r54";?>';
   document.formv1.m592r55.value = '<?php echo "$m592r55";?>';
   document.formv1.m592r56.value = '<?php echo "$m592r56";?>';
   document.formv1.m592r61.value = '<?php echo "$m592r61";?>';
   document.formv1.m592r62.value = '<?php echo "$m592r62";?>';
   document.formv1.m592r63.value = '<?php echo "$m592r63";?>';
   document.formv1.m592r64.value = '<?php echo "$m592r64";?>';
   document.formv1.m592r65.value = '<?php echo "$m592r65";?>';
   document.formv1.m592r66.value = '<?php echo "$m592r66";?>';
   document.formv1.m592r71.value = '<?php echo "$m592r71";?>';
   document.formv1.m592r72.value = '<?php echo "$m592r72";?>';
   document.formv1.m592r73.value = '<?php echo "$m592r73";?>';
   document.formv1.m592r74.value = '<?php echo "$m592r74";?>';
   document.formv1.m592r75.value = '<?php echo "$m592r75";?>';
   document.formv1.m592r76.value = '<?php echo "$m592r76";?>';
   document.formv1.m592r81.value = '<?php echo "$m592r81";?>';
   document.formv1.m592r82.value = '<?php echo "$m592r82";?>';
   document.formv1.m592r83.value = '<?php echo "$m592r83";?>';
   document.formv1.m592r84.value = '<?php echo "$m592r84";?>';
   document.formv1.m592r85.value = '<?php echo "$m592r85";?>';
   document.formv1.m592r86.value = '<?php echo "$m592r86";?>';
   document.formv1.m592r91.value = '<?php echo "$m592r91";?>';
   document.formv1.m592r92.value = '<?php echo "$m592r92";?>';
   document.formv1.m592r93.value = '<?php echo "$m592r93";?>';
   document.formv1.m592r94.value = '<?php echo "$m592r94";?>';
   document.formv1.m592r95.value = '<?php echo "$m592r95";?>';
   document.formv1.m592r96.value = '<?php echo "$m592r96";?>';
   document.formv1.m592r101.value = '<?php echo "$m592r101";?>';
   document.formv1.m592r102.value = '<?php echo "$m592r102";?>';
   document.formv1.m592r103.value = '<?php echo "$m592r103";?>';
   document.formv1.m592r104.value = '<?php echo "$m592r104";?>';
   document.formv1.m592r105.value = '<?php echo "$m592r105";?>';
   document.formv1.m592r106.value = '<?php echo "$m592r106";?>';
   document.formv1.m592r111.value = '<?php echo "$m592r111";?>';
   document.formv1.m592r112.value = '<?php echo "$m592r112";?>';
   document.formv1.m592r113.value = '<?php echo "$m592r113";?>';
   document.formv1.m592r114.value = '<?php echo "$m592r114";?>';
   document.formv1.m592r115.value = '<?php echo "$m592r115";?>';
   document.formv1.m592r116.value = '<?php echo "$m592r116";?>';
   document.formv1.m592r121.value = '<?php echo "$m592r121";?>';
   document.formv1.m592r122.value = '<?php echo "$m592r122";?>';
   document.formv1.m592r123.value = '<?php echo "$m592r123";?>';
   document.formv1.m592r124.value = '<?php echo "$m592r124";?>';
   document.formv1.m592r125.value = '<?php echo "$m592r125";?>';
   document.formv1.m592r126.value = '<?php echo "$m592r126";?>';
   document.formv1.m592r131.value = '<?php echo "$m592r131";?>';
   document.formv1.m592r132.value = '<?php echo "$m592r132";?>';
   document.formv1.m592r133.value = '<?php echo "$m592r133";?>';
   document.formv1.m592r134.value = '<?php echo "$m592r134";?>';
   document.formv1.m592r135.value = '<?php echo "$m592r135";?>';
   document.formv1.m592r136.value = '<?php echo "$m592r136";?>';
   document.formv1.m592r141.value = '<?php echo "$m592r141";?>';
   document.formv1.m592r142.value = '<?php echo "$m592r142";?>';
   document.formv1.m592r143.value = '<?php echo "$m592r143";?>';
   document.formv1.m592r144.value = '<?php echo "$m592r144";?>';
   document.formv1.m592r145.value = '<?php echo "$m592r145";?>';
   document.formv1.m592r146.value = '<?php echo "$m592r146";?>';
   document.formv1.m592r151.value = '<?php echo "$m592r151";?>';
   document.formv1.m592r152.value = '<?php echo "$m592r152";?>';
   document.formv1.m592r153.value = '<?php echo "$m592r153";?>';
   document.formv1.m592r154.value = '<?php echo "$m592r154";?>';
   document.formv1.m592r155.value = '<?php echo "$m592r155";?>';
   document.formv1.m592r156.value = '<?php echo "$m592r156";?>';
   document.formv1.m592r161.value = '<?php echo "$m592r161";?>';
   document.formv1.m592r162.value = '<?php echo "$m592r162";?>';
   document.formv1.m592r163.value = '<?php echo "$m592r163";?>';
   document.formv1.m592r164.value = '<?php echo "$m592r164";?>';
   document.formv1.m592r165.value = '<?php echo "$m592r165";?>';
   document.formv1.m592r166.value = '<?php echo "$m592r166";?>';
   document.formv1.m592r171.value = '<?php echo "$m592r171";?>';
   document.formv1.m592r172.value = '<?php echo "$m592r172";?>';
   document.formv1.m592r173.value = '<?php echo "$m592r173";?>';
   document.formv1.m592r174.value = '<?php echo "$m592r174";?>';
   document.formv1.m592r175.value = '<?php echo "$m592r175";?>';
   document.formv1.m592r176.value = '<?php echo "$m592r176";?>';
   document.formv1.m592r181.value = '<?php echo "$m592r181";?>';
   document.formv1.m592r182.value = '<?php echo "$m592r182";?>';
   document.formv1.m592r183.value = '<?php echo "$m592r183";?>';
   document.formv1.m592r184.value = '<?php echo "$m592r184";?>';
   document.formv1.m592r185.value = '<?php echo "$m592r185";?>';
   document.formv1.m592r186.value = '<?php echo "$m592r186";?>';
   document.formv1.m592r191.value = '<?php echo "$m592r191";?>';
   document.formv1.m592r192.value = '<?php echo "$m592r192";?>';
   document.formv1.m592r193.value = '<?php echo "$m592r193";?>';
   document.formv1.m592r194.value = '<?php echo "$m592r194";?>';
   document.formv1.m592r195.value = '<?php echo "$m592r195";?>';
   document.formv1.m592r196.value = '<?php echo "$m592r196";?>';
   document.formv1.m592r201.value = '<?php echo "$m592r201";?>';
   document.formv1.m592r202.value = '<?php echo "$m592r202";?>';
   document.formv1.m592r203.value = '<?php echo "$m592r203";?>';
   document.formv1.m592r204.value = '<?php echo "$m592r204";?>';
   document.formv1.m592r205.value = '<?php echo "$m592r205";?>';
   document.formv1.m592r206.value = '<?php echo "$m592r206";?>';
   document.formv1.m592r211.value = '<?php echo "$m592r211";?>';
   document.formv1.m592r212.value = '<?php echo "$m592r212";?>';
   document.formv1.m592r213.value = '<?php echo "$m592r213";?>';
   document.formv1.m592r214.value = '<?php echo "$m592r214";?>';
   document.formv1.m592r215.value = '<?php echo "$m592r215";?>';
   document.formv1.m592r216.value = '<?php echo "$m592r216";?>';
   document.formv1.m592r221.value = '<?php echo "$m592r221";?>';
   document.formv1.m592r222.value = '<?php echo "$m592r222";?>';
   document.formv1.m592r223.value = '<?php echo "$m592r223";?>';
   document.formv1.m592r224.value = '<?php echo "$m592r224";?>';
   document.formv1.m592r225.value = '<?php echo "$m592r225";?>';
   document.formv1.m592r226.value = '<?php echo "$m592r226";?>';
   document.formv1.m592r231.value = '<?php echo "$m592r231";?>';
   document.formv1.m592r232.value = '<?php echo "$m592r232";?>';
   document.formv1.m592r233.value = '<?php echo "$m592r233";?>';
   document.formv1.m592r234.value = '<?php echo "$m592r234";?>';
   document.formv1.m592r235.value = '<?php echo "$m592r235";?>';
   document.formv1.m592r236.value = '<?php echo "$m592r236";?>';
   document.formv1.m592r241.value = '<?php echo "$m592r241";?>';
   document.formv1.m592r242.value = '<?php echo "$m592r242";?>';
   document.formv1.m592r243.value = '<?php echo "$m592r243";?>';
   document.formv1.m592r244.value = '<?php echo "$m592r244";?>';
   document.formv1.m592r245.value = '<?php echo "$m592r245";?>';
   document.formv1.m592r246.value = '<?php echo "$m592r246";?>';
   document.formv1.m592r251.value = '<?php echo "$m592r251";?>';
   document.formv1.m592r252.value = '<?php echo "$m592r252";?>';
   document.formv1.m592r253.value = '<?php echo "$m592r253";?>';
   document.formv1.m592r254.value = '<?php echo "$m592r254";?>';
   document.formv1.m592r255.value = '<?php echo "$m592r255";?>';
   document.formv1.m592r256.value = '<?php echo "$m592r256";?>';
 //document.formv1.m592r992.value = '<?php echo "$m592r992";?>';
 //document.formv1.m592r993.value = '<?php echo "$m592r993";?>';
 //document.formv1.m592r994.value = '<?php echo "$m592r994";?>';
 //document.formv1.m592r995.value = '<?php echo "$m592r995";?>';
 //document.formv1.m592r996.value = '<?php echo "$m592r996";?>';
<?php                     } ?>

<?php if ( $strana == 3 ) { ?>
   document.formv1.m177r1.value = '<?php echo "$m177r1";?>';
   document.formv1.m177r2.value = '<?php echo "$m177r2";?>';
   document.formv1.m177r3.value = '<?php echo "$m177r3";?>';
   document.formv1.m177r4.value = '<?php echo "$m177r4";?>';
   document.formv1.m177r5.value = '<?php echo "$m177r5";?>';
   document.formv1.m177r6.value = '<?php echo "$m177r6";?>';
   document.formv1.m177r7.value = '<?php echo "$m177r7";?>';
   document.formv1.m177r8.value = '<?php echo "$m177r8";?>';
   document.formv1.m177r9.value = '<?php echo "$m177r9";?>';
   document.formv1.m177r10.value = '<?php echo "$m177r10";?>';
 //document.formv1.m177r99.value = '<?php echo "$m177r99";?>';
   document.formv1.m178r1.value = '<?php echo "$m178r1";?>';
   document.formv1.m178r2.value = '<?php echo "$m178r2";?>';
   document.formv1.m178r3.value = '<?php echo "$m178r3";?>';
   document.formv1.m178r4.value = '<?php echo "$m178r4";?>';
   document.formv1.m178r5.value = '<?php echo "$m178r5";?>';
   document.formv1.m178r6.value = '<?php echo "$m178r6";?>';
   document.formv1.m178r7.value = '<?php echo "$m178r7";?>';
   document.formv1.m178r8.value = '<?php echo "$m178r8";?>';
   document.formv1.m178r9.value = '<?php echo "$m178r9";?>';
   document.formv1.m178r10.value = '<?php echo "$m178r10";?>';
   document.formv1.m178r11.value = '<?php echo "$m178r11";?>';
   document.formv1.m178r12.value = '<?php echo "$m178r12";?>';
   document.formv1.m178r13.value = '<?php echo "$m178r13";?>';
   document.formv1.m178r14.value = '<?php echo "$m178r14";?>';
   document.formv1.m178r15.value = '<?php echo "$m178r15";?>';
   document.formv1.m178r16.value = '<?php echo "$m178r16";?>';
   document.formv1.m178r17.value = '<?php echo "$m178r17";?>';
   document.formv1.m178r18.value = '<?php echo "$m178r18";?>';
   document.formv1.m178r19.value = '<?php echo "$m178r19";?>';
 //document.formv1.m178r99.value = '<?php echo "$m178r99";?>';
<?php                     } ?>

<?php if ( $strana == 4 ) { ?>
   document.formv1.m179r1.value = '<?php echo "$m179r1";?>';
   document.formv1.m179r2.value = '<?php echo "$m179r2";?>';
   document.formv1.m179r3.value = '<?php echo "$m179r3";?>';
   document.formv1.m179r4.value = '<?php echo "$m179r4";?>';
   document.formv1.m179r5.value = '<?php echo "$m179r5";?>';
   document.formv1.m179r6.value = '<?php echo "$m179r6";?>';
   document.formv1.m179r7.value = '<?php echo "$m179r7";?>';
   document.formv1.m179r8.value = '<?php echo "$m179r8";?>';
   document.formv1.m179r9.value = '<?php echo "$m179r9";?>';
 //document.formv1.m179r99.value = '<?php echo "$m179r99";?>';
<?php                     } ?>

<?php if ( $strana == 5 ) { ?>
   document.formv1.m182r11.value = '<?php echo "$m182r11";?>';
   document.formv1.m182r12.value = '<?php echo "$m182r12";?>';
   document.formv1.m182r13.value = '<?php echo "$m182r13";?>';
   document.formv1.m182r14.value = '<?php echo "$m182r14";?>';
   document.formv1.m182r15.value = '<?php echo "$m182r15";?>';
   document.formv1.m182r16.value = '<?php echo "$m182r16";?>';
   document.formv1.m182r17.value = '<?php echo "$m182r17";?>';
   document.formv1.m182r21.value = '<?php echo "$m182r21";?>';
   document.formv1.m182r22.value = '<?php echo "$m182r22";?>';
   document.formv1.m182r23.value = '<?php echo "$m182r23";?>';
   document.formv1.m182r24.value = '<?php echo "$m182r24";?>';
   document.formv1.m182r25.value = '<?php echo "$m182r25";?>';
   document.formv1.m182r26.value = '<?php echo "$m182r26";?>';
   document.formv1.m182r27.value = '<?php echo "$m182r27";?>';
   document.formv1.m182r31.value = '<?php echo "$m182r31";?>';
   document.formv1.m182r32.value = '<?php echo "$m182r32";?>';
   document.formv1.m182r33.value = '<?php echo "$m182r33";?>';
   document.formv1.m182r34.value = '<?php echo "$m182r34";?>';
   document.formv1.m182r35.value = '<?php echo "$m182r35";?>';
   document.formv1.m182r36.value = '<?php echo "$m182r36";?>';
   document.formv1.m182r37.value = '<?php echo "$m182r37";?>';
   document.formv1.m182r41.value = '<?php echo "$m182r41";?>';
   document.formv1.m182r42.value = '<?php echo "$m182r42";?>';
   document.formv1.m182r43.value = '<?php echo "$m182r43";?>';
   document.formv1.m182r44.value = '<?php echo "$m182r44";?>';
   document.formv1.m182r45.value = '<?php echo "$m182r45";?>';
   document.formv1.m182r46.value = '<?php echo "$m182r46";?>';
   document.formv1.m182r47.value = '<?php echo "$m182r47";?>';
   document.formv1.m182r51.value = '<?php echo "$m182r51";?>';
   document.formv1.m182r52.value = '<?php echo "$m182r52";?>';
   document.formv1.m182r53.value = '<?php echo "$m182r53";?>';
   document.formv1.m182r54.value = '<?php echo "$m182r54";?>';
   document.formv1.m182r55.value = '<?php echo "$m182r55";?>';
   document.formv1.m182r56.value = '<?php echo "$m182r56";?>';
   document.formv1.m182r57.value = '<?php echo "$m182r57";?>';
   document.formv1.m182r61.value = '<?php echo "$m182r61";?>';
   document.formv1.m182r62.value = '<?php echo "$m182r62";?>';
   document.formv1.m182r63.value = '<?php echo "$m182r63";?>';
   document.formv1.m182r64.value = '<?php echo "$m182r64";?>';
   document.formv1.m182r65.value = '<?php echo "$m182r65";?>';
   document.formv1.m182r66.value = '<?php echo "$m182r66";?>';
   document.formv1.m182r67.value = '<?php echo "$m182r67";?>';
   document.formv1.m182r71.value = '<?php echo "$m182r71";?>';
   document.formv1.m182r72.value = '<?php echo "$m182r72";?>';
   document.formv1.m182r73.value = '<?php echo "$m182r73";?>';
   document.formv1.m182r74.value = '<?php echo "$m182r74";?>';
   document.formv1.m182r75.value = '<?php echo "$m182r75";?>';
   document.formv1.m182r76.value = '<?php echo "$m182r76";?>';
   document.formv1.m182r77.value = '<?php echo "$m182r77";?>';
   document.formv1.m182r81.value = '<?php echo "$m182r81";?>';
   document.formv1.m182r82.value = '<?php echo "$m182r82";?>';
   document.formv1.m182r83.value = '<?php echo "$m182r83";?>';
   document.formv1.m182r84.value = '<?php echo "$m182r84";?>';
   document.formv1.m182r85.value = '<?php echo "$m182r85";?>';
   document.formv1.m182r86.value = '<?php echo "$m182r86";?>';
   document.formv1.m182r87.value = '<?php echo "$m182r87";?>';
   document.formv1.m182r91.value = '<?php echo "$m182r91";?>';
   document.formv1.m182r92.value = '<?php echo "$m182r92";?>';
   document.formv1.m182r93.value = '<?php echo "$m182r93";?>';
   document.formv1.m182r94.value = '<?php echo "$m182r94";?>';
   document.formv1.m182r95.value = '<?php echo "$m182r95";?>';
   document.formv1.m182r96.value = '<?php echo "$m182r96";?>';
   document.formv1.m182r97.value = '<?php echo "$m182r97";?>';
   document.formv1.m182r101.value = '<?php echo "$m182r101";?>';
   document.formv1.m182r102.value = '<?php echo "$m182r102";?>';
   document.formv1.m182r103.value = '<?php echo "$m182r103";?>';
   document.formv1.m182r104.value = '<?php echo "$m182r104";?>';
   document.formv1.m182r105.value = '<?php echo "$m182r105";?>';
   document.formv1.m182r106.value = '<?php echo "$m182r106";?>';
   document.formv1.m182r107.value = '<?php echo "$m182r107";?>';
   document.formv1.m182r111.value = '<?php echo "$m182r111";?>';
   document.formv1.m182r112.value = '<?php echo "$m182r112";?>';
   document.formv1.m182r113.value = '<?php echo "$m182r113";?>';
   document.formv1.m182r114.value = '<?php echo "$m182r114";?>';
   document.formv1.m182r115.value = '<?php echo "$m182r115";?>';
   document.formv1.m182r116.value = '<?php echo "$m182r116";?>';
   document.formv1.m182r117.value = '<?php echo "$m182r117";?>';
   document.formv1.m182r121.value = '<?php echo "$m182r121";?>';
   document.formv1.m182r122.value = '<?php echo "$m182r122";?>';
   document.formv1.m182r123.value = '<?php echo "$m182r123";?>';
   document.formv1.m182r124.value = '<?php echo "$m182r124";?>';
   document.formv1.m182r125.value = '<?php echo "$m182r125";?>';
   document.formv1.m182r126.value = '<?php echo "$m182r126";?>';
   document.formv1.m182r127.value = '<?php echo "$m182r127";?>';
   document.formv1.m182r131.value = '<?php echo "$m182r131";?>';
   document.formv1.m182r132.value = '<?php echo "$m182r132";?>';
   document.formv1.m182r133.value = '<?php echo "$m182r133";?>';
   document.formv1.m182r134.value = '<?php echo "$m182r134";?>';
   document.formv1.m182r135.value = '<?php echo "$m182r135";?>';
   document.formv1.m182r136.value = '<?php echo "$m182r136";?>';
   document.formv1.m182r137.value = '<?php echo "$m182r137";?>';
   document.formv1.m182r141.value = '<?php echo "$m182r141";?>';
   document.formv1.m182r142.value = '<?php echo "$m182r142";?>';
   document.formv1.m182r143.value = '<?php echo "$m182r143";?>';
   document.formv1.m182r144.value = '<?php echo "$m182r144";?>';
   document.formv1.m182r145.value = '<?php echo "$m182r145";?>';
   document.formv1.m182r146.value = '<?php echo "$m182r146";?>';
   document.formv1.m182r147.value = '<?php echo "$m182r147";?>';
   document.formv1.m182r151.value = '<?php echo "$m182r151";?>';
   document.formv1.m182r152.value = '<?php echo "$m182r152";?>';
   document.formv1.m182r153.value = '<?php echo "$m182r153";?>';
   document.formv1.m182r154.value = '<?php echo "$m182r154";?>';
   document.formv1.m182r155.value = '<?php echo "$m182r155";?>';
   document.formv1.m182r156.value = '<?php echo "$m182r156";?>';
   document.formv1.m182r157.value = '<?php echo "$m182r157";?>';
   document.formv1.m182r161.value = '<?php echo "$m182r161";?>';
   document.formv1.m182r162.value = '<?php echo "$m182r162";?>';
   document.formv1.m182r163.value = '<?php echo "$m182r163";?>';
   document.formv1.m182r164.value = '<?php echo "$m182r164";?>';
   document.formv1.m182r165.value = '<?php echo "$m182r165";?>';
   document.formv1.m182r166.value = '<?php echo "$m182r166";?>';
   document.formv1.m182r167.value = '<?php echo "$m182r167";?>';
   document.formv1.m182r171.value = '<?php echo "$m182r171";?>';
   document.formv1.m182r172.value = '<?php echo "$m182r172";?>';
   document.formv1.m182r173.value = '<?php echo "$m182r173";?>';
   document.formv1.m182r174.value = '<?php echo "$m182r174";?>';
   document.formv1.m182r175.value = '<?php echo "$m182r175";?>';
   document.formv1.m182r176.value = '<?php echo "$m182r176";?>';
   document.formv1.m182r177.value = '<?php echo "$m182r177";?>';
   document.formv1.m182r181.value = '<?php echo "$m182r181";?>';
   document.formv1.m182r182.value = '<?php echo "$m182r182";?>';
   document.formv1.m182r183.value = '<?php echo "$m182r183";?>';
   document.formv1.m182r184.value = '<?php echo "$m182r184";?>';
   document.formv1.m182r185.value = '<?php echo "$m182r185";?>';
   document.formv1.m182r186.value = '<?php echo "$m182r186";?>';
   document.formv1.m182r187.value = '<?php echo "$m182r187";?>';
   document.formv1.m182r191.value = '<?php echo "$m182r191";?>';
   document.formv1.m182r192.value = '<?php echo "$m182r192";?>';
   document.formv1.m182r193.value = '<?php echo "$m182r193";?>';
   document.formv1.m182r194.value = '<?php echo "$m182r194";?>';
   document.formv1.m182r195.value = '<?php echo "$m182r195";?>';
   document.formv1.m182r196.value = '<?php echo "$m182r196";?>';
   document.formv1.m182r197.value = '<?php echo "$m182r197";?>';
   document.formv1.m182r201.value = '<?php echo "$m182r201";?>';
   document.formv1.m182r202.value = '<?php echo "$m182r202";?>';
   document.formv1.m182r203.value = '<?php echo "$m182r203";?>';
   document.formv1.m182r204.value = '<?php echo "$m182r204";?>';
   document.formv1.m182r205.value = '<?php echo "$m182r205";?>';
   document.formv1.m182r206.value = '<?php echo "$m182r206";?>';
   document.formv1.m182r207.value = '<?php echo "$m182r207";?>';
   document.formv1.m182r211.value = '<?php echo "$m182r211";?>';
   document.formv1.m182r212.value = '<?php echo "$m182r212";?>';
   document.formv1.m182r213.value = '<?php echo "$m182r213";?>';
   document.formv1.m182r214.value = '<?php echo "$m182r214";?>';
   document.formv1.m182r215.value = '<?php echo "$m182r215";?>';
   document.formv1.m182r216.value = '<?php echo "$m182r216";?>';
   document.formv1.m182r217.value = '<?php echo "$m182r217";?>';
   document.formv1.m182r221.value = '<?php echo "$m182r221";?>';
   document.formv1.m182r222.value = '<?php echo "$m182r222";?>';
   document.formv1.m182r223.value = '<?php echo "$m182r223";?>';
   document.formv1.m182r224.value = '<?php echo "$m182r224";?>';
   document.formv1.m182r225.value = '<?php echo "$m182r225";?>';
   document.formv1.m182r226.value = '<?php echo "$m182r226";?>';
   document.formv1.m182r227.value = '<?php echo "$m182r227";?>';
   document.formv1.m182r231.value = '<?php echo "$m182r231";?>';
   document.formv1.m182r232.value = '<?php echo "$m182r232";?>';
   document.formv1.m182r233.value = '<?php echo "$m182r233";?>';
   document.formv1.m182r234.value = '<?php echo "$m182r234";?>';
   document.formv1.m182r235.value = '<?php echo "$m182r235";?>';
   document.formv1.m182r236.value = '<?php echo "$m182r236";?>';
   document.formv1.m182r237.value = '<?php echo "$m182r237";?>';
   document.formv1.m182r241.value = '<?php echo "$m182r241";?>';
   document.formv1.m182r242.value = '<?php echo "$m182r242";?>';
   document.formv1.m182r243.value = '<?php echo "$m182r243";?>';
   document.formv1.m182r244.value = '<?php echo "$m182r244";?>';
   document.formv1.m182r245.value = '<?php echo "$m182r245";?>';
   document.formv1.m182r246.value = '<?php echo "$m182r246";?>';
   document.formv1.m182r247.value = '<?php echo "$m182r247";?>';
   document.formv1.m182r251.value = '<?php echo "$m182r251";?>';
   document.formv1.m182r252.value = '<?php echo "$m182r252";?>';
   document.formv1.m182r253.value = '<?php echo "$m182r253";?>';
   document.formv1.m182r254.value = '<?php echo "$m182r254";?>';
   document.formv1.m182r255.value = '<?php echo "$m182r255";?>';
   document.formv1.m182r256.value = '<?php echo "$m182r256";?>';
   document.formv1.m182r257.value = '<?php echo "$m182r257";?>';
   document.formv1.m182r261.value = '<?php echo "$m182r261";?>';
   document.formv1.m182r262.value = '<?php echo "$m182r262";?>';
   document.formv1.m182r263.value = '<?php echo "$m182r263";?>';
   document.formv1.m182r264.value = '<?php echo "$m182r264";?>';
   document.formv1.m182r265.value = '<?php echo "$m182r265";?>';
   document.formv1.m182r266.value = '<?php echo "$m182r266";?>';
   document.formv1.m182r267.value = '<?php echo "$m182r267";?>';
   document.formv1.m182r271.value = '<?php echo "$m182r271";?>';
   document.formv1.m182r272.value = '<?php echo "$m182r272";?>';
   document.formv1.m182r273.value = '<?php echo "$m182r273";?>';
   document.formv1.m182r274.value = '<?php echo "$m182r274";?>';
   document.formv1.m182r275.value = '<?php echo "$m182r275";?>';
   document.formv1.m182r276.value = '<?php echo "$m182r276";?>';
   document.formv1.m182r277.value = '<?php echo "$m182r277";?>';
   document.formv1.m182r281.value = '<?php echo "$m182r281";?>';
   document.formv1.m182r282.value = '<?php echo "$m182r282";?>';
   document.formv1.m182r283.value = '<?php echo "$m182r283";?>';
   document.formv1.m182r284.value = '<?php echo "$m182r284";?>';
   document.formv1.m182r285.value = '<?php echo "$m182r285";?>';
   document.formv1.m182r286.value = '<?php echo "$m182r286";?>';
   document.formv1.m182r287.value = '<?php echo "$m182r287";?>';
   document.formv1.m182r291.value = '<?php echo "$m182r291";?>';
   document.formv1.m182r292.value = '<?php echo "$m182r292";?>';
   document.formv1.m182r293.value = '<?php echo "$m182r293";?>';
   document.formv1.m182r294.value = '<?php echo "$m182r294";?>';
   document.formv1.m182r295.value = '<?php echo "$m182r295";?>';
   document.formv1.m182r296.value = '<?php echo "$m182r296";?>';
   document.formv1.m182r297.value = '<?php echo "$m182r297";?>';
   document.formv1.m182r301.value = '<?php echo "$m182r301";?>';
   document.formv1.m182r302.value = '<?php echo "$m182r302";?>';
   document.formv1.m182r303.value = '<?php echo "$m182r303";?>';
   document.formv1.m182r304.value = '<?php echo "$m182r304";?>';
   document.formv1.m182r305.value = '<?php echo "$m182r305";?>';
   document.formv1.m182r306.value = '<?php echo "$m182r306";?>';
   document.formv1.m182r307.value = '<?php echo "$m182r307";?>';
   document.formv1.m182r311.value = '<?php echo "$m182r311";?>';
   document.formv1.m182r312.value = '<?php echo "$m182r312";?>';
   document.formv1.m182r313.value = '<?php echo "$m182r313";?>';
   document.formv1.m182r314.value = '<?php echo "$m182r314";?>';
   document.formv1.m182r315.value = '<?php echo "$m182r315";?>';
   document.formv1.m182r316.value = '<?php echo "$m182r316";?>';
   document.formv1.m182r317.value = '<?php echo "$m182r317";?>';
   document.formv1.m182r321.value = '<?php echo "$m182r321";?>';
   document.formv1.m182r322.value = '<?php echo "$m182r322";?>';
   document.formv1.m182r323.value = '<?php echo "$m182r323";?>';
   document.formv1.m182r324.value = '<?php echo "$m182r324";?>';
   document.formv1.m182r325.value = '<?php echo "$m182r325";?>';
   document.formv1.m182r326.value = '<?php echo "$m182r326";?>';
   document.formv1.m182r327.value = '<?php echo "$m182r327";?>';
   document.formv1.m182r331.value = '<?php echo "$m182r331";?>';
   document.formv1.m182r332.value = '<?php echo "$m182r332";?>';
   document.formv1.m182r333.value = '<?php echo "$m182r333";?>';
   document.formv1.m182r334.value = '<?php echo "$m182r334";?>';
   document.formv1.m182r335.value = '<?php echo "$m182r335";?>';
   document.formv1.m182r336.value = '<?php echo "$m182r336";?>';
   document.formv1.m182r337.value = '<?php echo "$m182r337";?>';
 //document.formv1.m182r992.value = '<?php echo "$m182r992";?>';
 //document.formv1.m182r993.value = '<?php echo "$m182r993";?>';
 //document.formv1.m182r994.value = '<?php echo "$m182r994";?>';
 //document.formv1.m182r995.value = '<?php echo "$m182r995";?>';
 //document.formv1.m182r996.value = '<?php echo "$m182r996";?>';
 //document.formv1.m182r997.value = '<?php echo "$m182r997";?>';
<?php                     } ?>

<?php if (  $strana == 6 ) { ?>
   document.formv1.m183r11.value = '<?php echo "$m183r11";?>';
   document.formv1.m183r12.value = '<?php echo "$m183r12";?>';
   document.formv1.m183r13.value = '<?php echo "$m183r13";?>';
   document.formv1.m183r14.value = '<?php echo "$m183r14";?>';
   document.formv1.m183r21.value = '<?php echo "$m183r21";?>';
   document.formv1.m183r22.value = '<?php echo "$m183r22";?>';
   document.formv1.m183r23.value = '<?php echo "$m183r23";?>';
   document.formv1.m183r24.value = '<?php echo "$m183r24";?>';
   document.formv1.m183r31.value = '<?php echo "$m183r31";?>';
   document.formv1.m183r32.value = '<?php echo "$m183r32";?>';
   document.formv1.m183r33.value = '<?php echo "$m183r33";?>';
   document.formv1.m183r34.value = '<?php echo "$m183r34";?>';
   document.formv1.m183r41.value = '<?php echo "$m183r41";?>';
   document.formv1.m183r42.value = '<?php echo "$m183r42";?>';
   document.formv1.m183r43.value = '<?php echo "$m183r43";?>';
   document.formv1.m183r44.value = '<?php echo "$m183r44";?>';
   document.formv1.m183r51.value = '<?php echo "$m183r51";?>';
   document.formv1.m183r52.value = '<?php echo "$m183r52";?>';
   document.formv1.m183r53.value = '<?php echo "$m183r53";?>';
   document.formv1.m183r54.value = '<?php echo "$m183r54";?>';
   document.formv1.m183r61.value = '<?php echo "$m183r61";?>';
   document.formv1.m183r62.value = '<?php echo "$m183r62";?>';
   document.formv1.m183r63.value = '<?php echo "$m183r63";?>';
   document.formv1.m183r64.value = '<?php echo "$m183r64";?>';
   document.formv1.m183r71.value = '<?php echo "$m183r71";?>';
   document.formv1.m183r72.value = '<?php echo "$m183r72";?>';
   document.formv1.m183r73.value = '<?php echo "$m183r73";?>';
   document.formv1.m183r74.value = '<?php echo "$m183r74";?>';
   document.formv1.m183r81.value = '<?php echo "$m183r81";?>';
   document.formv1.m183r82.value = '<?php echo "$m183r82";?>';
   document.formv1.m183r83.value = '<?php echo "$m183r83";?>';
   document.formv1.m183r84.value = '<?php echo "$m183r84";?>';
   document.formv1.m183r91.value = '<?php echo "$m183r91";?>';
   document.formv1.m183r92.value = '<?php echo "$m183r92";?>';
   document.formv1.m183r93.value = '<?php echo "$m183r93";?>';
   document.formv1.m183r94.value = '<?php echo "$m183r94";?>';
   document.formv1.m183r101.value = '<?php echo "$m183r101";?>';
   document.formv1.m183r102.value = '<?php echo "$m183r102";?>';
   document.formv1.m183r103.value = '<?php echo "$m183r103";?>';
   document.formv1.m183r104.value = '<?php echo "$m183r104";?>';
   document.formv1.m183r111.value = '<?php echo "$m183r111";?>';
   document.formv1.m183r112.value = '<?php echo "$m183r112";?>';
   document.formv1.m183r113.value = '<?php echo "$m183r113";?>';
   document.formv1.m183r114.value = '<?php echo "$m183r114";?>';
   document.formv1.m183r121.value = '<?php echo "$m183r121";?>';
   document.formv1.m183r122.value = '<?php echo "$m183r122";?>';
   document.formv1.m183r123.value = '<?php echo "$m183r123";?>';
   document.formv1.m183r124.value = '<?php echo "$m183r124";?>';
   document.formv1.m183r131.value = '<?php echo "$m183r131";?>';
   document.formv1.m183r132.value = '<?php echo "$m183r132";?>';
   document.formv1.m183r133.value = '<?php echo "$m183r133";?>';
   document.formv1.m183r134.value = '<?php echo "$m183r134";?>';
   document.formv1.m183r141.value = '<?php echo "$m183r141";?>';
   document.formv1.m183r142.value = '<?php echo "$m183r142";?>';
   document.formv1.m183r143.value = '<?php echo "$m183r143";?>';
   document.formv1.m183r144.value = '<?php echo "$m183r144";?>';
   document.formv1.m183r151.value = '<?php echo "$m183r151";?>';
   document.formv1.m183r152.value = '<?php echo "$m183r152";?>';
   document.formv1.m183r153.value = '<?php echo "$m183r153";?>';
   document.formv1.m183r154.value = '<?php echo "$m183r154";?>';
   document.formv1.m183r161.value = '<?php echo "$m183r161";?>';
   document.formv1.m183r162.value = '<?php echo "$m183r162";?>';
   document.formv1.m183r163.value = '<?php echo "$m183r163";?>';
   document.formv1.m183r164.value = '<?php echo "$m183r164";?>';
   document.formv1.m183r171.value = '<?php echo "$m183r171";?>';
   document.formv1.m183r172.value = '<?php echo "$m183r172";?>';
   document.formv1.m183r173.value = '<?php echo "$m183r173";?>';
   document.formv1.m183r174.value = '<?php echo "$m183r174";?>';
   document.formv1.m183r181.value = '<?php echo "$m183r181";?>';
   document.formv1.m183r182.value = '<?php echo "$m183r182";?>';
   document.formv1.m183r183.value = '<?php echo "$m183r183";?>';
   document.formv1.m183r184.value = '<?php echo "$m183r184";?>';
   document.formv1.m183r191.value = '<?php echo "$m183r191";?>';
   document.formv1.m183r192.value = '<?php echo "$m183r192";?>';
   document.formv1.m183r193.value = '<?php echo "$m183r193";?>';
   document.formv1.m183r194.value = '<?php echo "$m183r194";?>';
   document.formv1.m183r201.value = '<?php echo "$m183r201";?>';
   document.formv1.m183r202.value = '<?php echo "$m183r202";?>';
   document.formv1.m183r203.value = '<?php echo "$m183r203";?>';
   document.formv1.m183r204.value = '<?php echo "$m183r204";?>';
   document.formv1.m183r211.value = '<?php echo "$m183r211";?>';
   document.formv1.m183r212.value = '<?php echo "$m183r212";?>';
   document.formv1.m183r213.value = '<?php echo "$m183r213";?>';
   document.formv1.m183r214.value = '<?php echo "$m183r214";?>';
   document.formv1.m183r221.value = '<?php echo "$m183r221";?>';
   document.formv1.m183r222.value = '<?php echo "$m183r222";?>';
   document.formv1.m183r223.value = '<?php echo "$m183r223";?>';
   document.formv1.m183r224.value = '<?php echo "$m183r224";?>';
   document.formv1.m183r231.value = '<?php echo "$m183r231";?>';
   document.formv1.m183r232.value = '<?php echo "$m183r232";?>';
   document.formv1.m183r233.value = '<?php echo "$m183r233";?>';
   document.formv1.m183r234.value = '<?php echo "$m183r234";?>';
   document.formv1.m183r241.value = '<?php echo "$m183r241";?>';
   document.formv1.m183r242.value = '<?php echo "$m183r242";?>';
   document.formv1.m183r243.value = '<?php echo "$m183r243";?>';
   document.formv1.m183r244.value = '<?php echo "$m183r244";?>';
   document.formv1.m183r251.value = '<?php echo "$m183r251";?>';
   document.formv1.m183r252.value = '<?php echo "$m183r252";?>';
   document.formv1.m183r253.value = '<?php echo "$m183r253";?>';
   document.formv1.m183r254.value = '<?php echo "$m183r254";?>';
   document.formv1.m183r261.value = '<?php echo "$m183r261";?>';
   document.formv1.m183r262.value = '<?php echo "$m183r262";?>';
   document.formv1.m183r263.value = '<?php echo "$m183r263";?>';
   document.formv1.m183r264.value = '<?php echo "$m183r264";?>';
   document.formv1.m183r271.value = '<?php echo "$m183r271";?>';
   document.formv1.m183r272.value = '<?php echo "$m183r272";?>';
   document.formv1.m183r273.value = '<?php echo "$m183r273";?>';
   document.formv1.m183r274.value = '<?php echo "$m183r274";?>';
   document.formv1.m183r281.value = '<?php echo "$m183r281";?>';
   document.formv1.m183r282.value = '<?php echo "$m183r282";?>';
   document.formv1.m183r283.value = '<?php echo "$m183r283";?>';
   document.formv1.m183r284.value = '<?php echo "$m183r284";?>';
   document.formv1.m183r291.value = '<?php echo "$m183r291";?>';
   document.formv1.m183r292.value = '<?php echo "$m183r292";?>';
   document.formv1.m183r293.value = '<?php echo "$m183r293";?>';
   document.formv1.m183r294.value = '<?php echo "$m183r294";?>';
   document.formv1.m183r301.value = '<?php echo "$m183r301";?>';
   document.formv1.m183r302.value = '<?php echo "$m183r302";?>';
   document.formv1.m183r303.value = '<?php echo "$m183r303";?>';
   document.formv1.m183r304.value = '<?php echo "$m183r304";?>';
 //document.formv1.m183r992.value = '<?php echo "$m183r992";?>';
 //document.formv1.m183r993.value = '<?php echo "$m183r993";?>';
 //document.formv1.m183r994.value = '<?php echo "$m183r994";?>';
<?php                     } ?>

<?php if (  $strana == 7 ) { ?>
   document.formv1.m184r11.value = '<?php echo "$m184r11";?>';
   document.formv1.m184r12.value = '<?php echo "$m184r12";?>';
   document.formv1.m184r13.value = '<?php echo "$m184r13";?>';
   document.formv1.m184r14.value = '<?php echo "$m184r14";?>';
   document.formv1.m184r15.value = '<?php echo "$m184r15";?>';
   document.formv1.m184r16.value = '<?php echo "$m184r16";?>';
   document.formv1.m184r21.value = '<?php echo "$m184r21";?>';
   document.formv1.m184r22.value = '<?php echo "$m184r22";?>';
   document.formv1.m184r23.value = '<?php echo "$m184r23";?>';
   document.formv1.m184r24.value = '<?php echo "$m184r24";?>';
   document.formv1.m184r25.value = '<?php echo "$m184r25";?>';
   document.formv1.m184r26.value = '<?php echo "$m184r26";?>';
   document.formv1.m184r31.value = '<?php echo "$m184r31";?>';
   document.formv1.m184r32.value = '<?php echo "$m184r32";?>';
   document.formv1.m184r33.value = '<?php echo "$m184r33";?>';
   document.formv1.m184r34.value = '<?php echo "$m184r34";?>';
   document.formv1.m184r35.value = '<?php echo "$m184r35";?>';
   document.formv1.m184r36.value = '<?php echo "$m184r36";?>';
   document.formv1.m184r41.value = '<?php echo "$m184r41";?>';
   document.formv1.m184r42.value = '<?php echo "$m184r42";?>';
   document.formv1.m184r43.value = '<?php echo "$m184r43";?>';
   document.formv1.m184r44.value = '<?php echo "$m184r44";?>';
   document.formv1.m184r45.value = '<?php echo "$m184r45";?>';
   document.formv1.m184r46.value = '<?php echo "$m184r46";?>';
   document.formv1.m184r51.value = '<?php echo "$m184r51";?>';
   document.formv1.m184r52.value = '<?php echo "$m184r52";?>';
   document.formv1.m184r53.value = '<?php echo "$m184r53";?>';
   document.formv1.m184r54.value = '<?php echo "$m184r54";?>';
   document.formv1.m184r55.value = '<?php echo "$m184r55";?>';
   document.formv1.m184r56.value = '<?php echo "$m184r56";?>';
   document.formv1.m184r61.value = '<?php echo "$m184r61";?>';
   document.formv1.m184r62.value = '<?php echo "$m184r62";?>';
   document.formv1.m184r63.value = '<?php echo "$m184r63";?>';
   document.formv1.m184r64.value = '<?php echo "$m184r64";?>';
   document.formv1.m184r65.value = '<?php echo "$m184r65";?>';
   document.formv1.m184r66.value = '<?php echo "$m184r66";?>';
   document.formv1.m184r71.value = '<?php echo "$m184r71";?>';
   document.formv1.m184r72.value = '<?php echo "$m184r72";?>';
   document.formv1.m184r73.value = '<?php echo "$m184r73";?>';
   document.formv1.m184r74.value = '<?php echo "$m184r74";?>';
   document.formv1.m184r75.value = '<?php echo "$m184r75";?>';
   document.formv1.m184r76.value = '<?php echo "$m184r76";?>';
   document.formv1.m184r81.value = '<?php echo "$m184r81";?>';
   document.formv1.m184r82.value = '<?php echo "$m184r82";?>';
   document.formv1.m184r83.value = '<?php echo "$m184r83";?>';
   document.formv1.m184r84.value = '<?php echo "$m184r84";?>';
   document.formv1.m184r85.value = '<?php echo "$m184r85";?>';
   document.formv1.m184r86.value = '<?php echo "$m184r86";?>';
   document.formv1.m184r91.value = '<?php echo "$m184r91";?>';
   document.formv1.m184r92.value = '<?php echo "$m184r92";?>';
   document.formv1.m184r93.value = '<?php echo "$m184r93";?>';
   document.formv1.m184r94.value = '<?php echo "$m184r94";?>';
   document.formv1.m184r95.value = '<?php echo "$m184r95";?>';
   document.formv1.m184r96.value = '<?php echo "$m184r96";?>';
   document.formv1.m184r101.value = '<?php echo "$m184r101";?>';
   document.formv1.m184r102.value = '<?php echo "$m184r102";?>';
   document.formv1.m184r103.value = '<?php echo "$m184r103";?>';
   document.formv1.m184r104.value = '<?php echo "$m184r104";?>';
   document.formv1.m184r105.value = '<?php echo "$m184r105";?>';
   document.formv1.m184r106.value = '<?php echo "$m184r106";?>';
   document.formv1.m184r111.value = '<?php echo "$m184r111";?>';
   document.formv1.m184r112.value = '<?php echo "$m184r112";?>';
   document.formv1.m184r113.value = '<?php echo "$m184r113";?>';
   document.formv1.m184r114.value = '<?php echo "$m184r114";?>';
   document.formv1.m184r115.value = '<?php echo "$m184r115";?>';
   document.formv1.m184r116.value = '<?php echo "$m184r116";?>';
   document.formv1.m184r121.value = '<?php echo "$m184r121";?>';
   document.formv1.m184r122.value = '<?php echo "$m184r122";?>';
   document.formv1.m184r123.value = '<?php echo "$m184r123";?>';
   document.formv1.m184r124.value = '<?php echo "$m184r124";?>';
   document.formv1.m184r125.value = '<?php echo "$m184r125";?>';
   document.formv1.m184r126.value = '<?php echo "$m184r126";?>';
   document.formv1.m184r131.value = '<?php echo "$m184r131";?>';
   document.formv1.m184r132.value = '<?php echo "$m184r132";?>';
   document.formv1.m184r133.value = '<?php echo "$m184r133";?>';
   document.formv1.m184r134.value = '<?php echo "$m184r134";?>';
   document.formv1.m184r135.value = '<?php echo "$m184r135";?>';
   document.formv1.m184r136.value = '<?php echo "$m184r136";?>';
   document.formv1.m184r141.value = '<?php echo "$m184r141";?>';
   document.formv1.m184r142.value = '<?php echo "$m184r142";?>';
   document.formv1.m184r143.value = '<?php echo "$m184r143";?>';
   document.formv1.m184r144.value = '<?php echo "$m184r144";?>';
   document.formv1.m184r145.value = '<?php echo "$m184r145";?>';
   document.formv1.m184r146.value = '<?php echo "$m184r146";?>';
   document.formv1.m184r151.value = '<?php echo "$m184r151";?>';
   document.formv1.m184r152.value = '<?php echo "$m184r152";?>';
   document.formv1.m184r153.value = '<?php echo "$m184r153";?>';
   document.formv1.m184r154.value = '<?php echo "$m184r154";?>';
   document.formv1.m184r155.value = '<?php echo "$m184r155";?>';
   document.formv1.m184r156.value = '<?php echo "$m184r156";?>';
   document.formv1.m184r161.value = '<?php echo "$m184r161";?>';
   document.formv1.m184r162.value = '<?php echo "$m184r162";?>';
   document.formv1.m184r163.value = '<?php echo "$m184r163";?>';
   document.formv1.m184r164.value = '<?php echo "$m184r164";?>';
   document.formv1.m184r165.value = '<?php echo "$m184r165";?>';
   document.formv1.m184r166.value = '<?php echo "$m184r166";?>';
   document.formv1.m184r171.value = '<?php echo "$m184r171";?>';
   document.formv1.m184r172.value = '<?php echo "$m184r172";?>';
   document.formv1.m184r173.value = '<?php echo "$m184r173";?>';
   document.formv1.m184r174.value = '<?php echo "$m184r174";?>';
   document.formv1.m184r175.value = '<?php echo "$m184r175";?>';
   document.formv1.m184r176.value = '<?php echo "$m184r176";?>';
   document.formv1.m184r181.value = '<?php echo "$m184r181";?>';
   document.formv1.m184r182.value = '<?php echo "$m184r182";?>';
   document.formv1.m184r183.value = '<?php echo "$m184r183";?>';
   document.formv1.m184r184.value = '<?php echo "$m184r184";?>';
   document.formv1.m184r185.value = '<?php echo "$m184r185";?>';
   document.formv1.m184r186.value = '<?php echo "$m184r186";?>';
   document.formv1.m184r191.value = '<?php echo "$m184r191";?>';
   document.formv1.m184r192.value = '<?php echo "$m184r192";?>';
   document.formv1.m184r193.value = '<?php echo "$m184r193";?>';
   document.formv1.m184r194.value = '<?php echo "$m184r194";?>';
   document.formv1.m184r195.value = '<?php echo "$m184r195";?>';
   document.formv1.m184r196.value = '<?php echo "$m184r196";?>';
   document.formv1.m184r201.value = '<?php echo "$m184r201";?>';
   document.formv1.m184r202.value = '<?php echo "$m184r202";?>';
   document.formv1.m184r203.value = '<?php echo "$m184r203";?>';
   document.formv1.m184r204.value = '<?php echo "$m184r204";?>';
   document.formv1.m184r205.value = '<?php echo "$m184r205";?>';
   document.formv1.m184r206.value = '<?php echo "$m184r206";?>';
   document.formv1.m184r211.value = '<?php echo "$m184r211";?>';
   document.formv1.m184r212.value = '<?php echo "$m184r212";?>';
   document.formv1.m184r213.value = '<?php echo "$m184r213";?>';
   document.formv1.m184r214.value = '<?php echo "$m184r214";?>';
   document.formv1.m184r215.value = '<?php echo "$m184r215";?>';
   document.formv1.m184r216.value = '<?php echo "$m184r216";?>';
   document.formv1.m184r221.value = '<?php echo "$m184r221";?>';
   document.formv1.m184r222.value = '<?php echo "$m184r222";?>';
   document.formv1.m184r223.value = '<?php echo "$m184r223";?>';
   document.formv1.m184r224.value = '<?php echo "$m184r224";?>';
   document.formv1.m184r225.value = '<?php echo "$m184r225";?>';
   document.formv1.m184r226.value = '<?php echo "$m184r226";?>';
   document.formv1.m184r231.value = '<?php echo "$m184r231";?>';
   document.formv1.m184r232.value = '<?php echo "$m184r232";?>';
   document.formv1.m184r233.value = '<?php echo "$m184r233";?>';
   document.formv1.m184r234.value = '<?php echo "$m184r234";?>';
   document.formv1.m184r235.value = '<?php echo "$m184r235";?>';
   document.formv1.m184r236.value = '<?php echo "$m184r236";?>';
   document.formv1.m184r241.value = '<?php echo "$m184r241";?>';
   document.formv1.m184r242.value = '<?php echo "$m184r242";?>';
   document.formv1.m184r243.value = '<?php echo "$m184r243";?>';
   document.formv1.m184r244.value = '<?php echo "$m184r244";?>';
   document.formv1.m184r245.value = '<?php echo "$m184r245";?>';
   document.formv1.m184r246.value = '<?php echo "$m184r246";?>';
   document.formv1.m184r251.value = '<?php echo "$m184r251";?>';
   document.formv1.m184r252.value = '<?php echo "$m184r252";?>';
   document.formv1.m184r253.value = '<?php echo "$m184r253";?>';
   document.formv1.m184r254.value = '<?php echo "$m184r254";?>';
   document.formv1.m184r255.value = '<?php echo "$m184r255";?>';
   document.formv1.m184r256.value = '<?php echo "$m184r256";?>';
   document.formv1.m184r261.value = '<?php echo "$m184r261";?>';
   document.formv1.m184r262.value = '<?php echo "$m184r262";?>';
   document.formv1.m184r263.value = '<?php echo "$m184r263";?>';
   document.formv1.m184r264.value = '<?php echo "$m184r264";?>';
   document.formv1.m184r265.value = '<?php echo "$m184r265";?>';
   document.formv1.m184r266.value = '<?php echo "$m184r266";?>';
   document.formv1.m184r271.value = '<?php echo "$m184r271";?>';
   document.formv1.m184r272.value = '<?php echo "$m184r272";?>';
   document.formv1.m184r273.value = '<?php echo "$m184r273";?>';
   document.formv1.m184r274.value = '<?php echo "$m184r274";?>';
   document.formv1.m184r275.value = '<?php echo "$m184r275";?>';
   document.formv1.m184r276.value = '<?php echo "$m184r276";?>';
   document.formv1.m184r281.value = '<?php echo "$m184r281";?>';
   document.formv1.m184r282.value = '<?php echo "$m184r282";?>';
   document.formv1.m184r283.value = '<?php echo "$m184r283";?>';
   document.formv1.m184r284.value = '<?php echo "$m184r284";?>';
   document.formv1.m184r285.value = '<?php echo "$m184r285";?>';
   document.formv1.m184r286.value = '<?php echo "$m184r286";?>';
   document.formv1.m184r291.value = '<?php echo "$m184r291";?>';
   document.formv1.m184r292.value = '<?php echo "$m184r292";?>';
   document.formv1.m184r293.value = '<?php echo "$m184r293";?>';
   document.formv1.m184r294.value = '<?php echo "$m184r294";?>';
   document.formv1.m184r295.value = '<?php echo "$m184r295";?>';
   document.formv1.m184r296.value = '<?php echo "$m184r296";?>';
   document.formv1.m184r301.value = '<?php echo "$m184r301";?>';
   document.formv1.m184r302.value = '<?php echo "$m184r302";?>';
   document.formv1.m184r303.value = '<?php echo "$m184r303";?>';
   document.formv1.m184r304.value = '<?php echo "$m184r304";?>';
   document.formv1.m184r305.value = '<?php echo "$m184r305";?>';
   document.formv1.m184r306.value = '<?php echo "$m184r306";?>';
   document.formv1.m184r311.value = '<?php echo "$m184r311";?>';
   document.formv1.m184r312.value = '<?php echo "$m184r312";?>';
   document.formv1.m184r313.value = '<?php echo "$m184r313";?>';
   document.formv1.m184r314.value = '<?php echo "$m184r314";?>';
   document.formv1.m184r315.value = '<?php echo "$m184r315";?>';
   document.formv1.m184r316.value = '<?php echo "$m184r316";?>';
   document.formv1.m184r321.value = '<?php echo "$m184r321";?>';
   document.formv1.m184r322.value = '<?php echo "$m184r322";?>';
   document.formv1.m184r323.value = '<?php echo "$m184r323";?>';
   document.formv1.m184r324.value = '<?php echo "$m184r324";?>';
   document.formv1.m184r325.value = '<?php echo "$m184r325";?>';
   document.formv1.m184r326.value = '<?php echo "$m184r326";?>';
 //document.formv1.m184r992.value = '<?php echo "$m184r992";?>';
 //document.formv1.m184r993.value = '<?php echo "$m184r993";?>';
 //document.formv1.m184r994.value = '<?php echo "$m184r994";?>';
 //document.formv1.m184r995.value = '<?php echo "$m184r995";?>';
 //document.formv1.m184r996.value = '<?php echo "$m184r996";?>';
<?php                     } ?>

<?php if ( $strana == 8 ) { ?>
   document.formv1.m185r11.value = '<?php echo "$m185r11";?>';
   document.formv1.m185r12.value = '<?php echo "$m185r12";?>';
   document.formv1.m185r13.value = '<?php echo "$m185r13";?>';
   document.formv1.m185r14.value = '<?php echo "$m185r14";?>';
   document.formv1.m185r15.value = '<?php echo "$m185r15";?>';
   document.formv1.m185r16.value = '<?php echo "$m185r16";?>';
   document.formv1.m185r17.value = '<?php echo "$m185r17";?>';
   document.formv1.m185r21.value = '<?php echo "$m185r21";?>';
   document.formv1.m185r22.value = '<?php echo "$m185r22";?>';
   document.formv1.m185r23.value = '<?php echo "$m185r23";?>';
   document.formv1.m185r24.value = '<?php echo "$m185r24";?>';
   document.formv1.m185r25.value = '<?php echo "$m185r25";?>';
   document.formv1.m185r26.value = '<?php echo "$m185r26";?>';
   document.formv1.m185r27.value = '<?php echo "$m185r27";?>';
   document.formv1.m185r31.value = '<?php echo "$m185r31";?>';
   document.formv1.m185r32.value = '<?php echo "$m185r32";?>';
   document.formv1.m185r33.value = '<?php echo "$m185r33";?>';
   document.formv1.m185r34.value = '<?php echo "$m185r34";?>';
   document.formv1.m185r35.value = '<?php echo "$m185r35";?>';
   document.formv1.m185r36.value = '<?php echo "$m185r36";?>';
   document.formv1.m185r37.value = '<?php echo "$m185r37";?>';
   document.formv1.m185r41.value = '<?php echo "$m185r41";?>';
   document.formv1.m185r42.value = '<?php echo "$m185r42";?>';
   document.formv1.m185r43.value = '<?php echo "$m185r43";?>';
   document.formv1.m185r44.value = '<?php echo "$m185r44";?>';
   document.formv1.m185r45.value = '<?php echo "$m185r45";?>';
   document.formv1.m185r46.value = '<?php echo "$m185r46";?>';
   document.formv1.m185r47.value = '<?php echo "$m185r47";?>';
   document.formv1.m185r51.value = '<?php echo "$m185r51";?>';
   document.formv1.m185r52.value = '<?php echo "$m185r52";?>';
   document.formv1.m185r53.value = '<?php echo "$m185r53";?>';
   document.formv1.m185r54.value = '<?php echo "$m185r54";?>';
   document.formv1.m185r55.value = '<?php echo "$m185r55";?>';
   document.formv1.m185r56.value = '<?php echo "$m185r56";?>';
   document.formv1.m185r57.value = '<?php echo "$m185r57";?>';
   document.formv1.m185r61.value = '<?php echo "$m185r61";?>';
   document.formv1.m185r62.value = '<?php echo "$m185r62";?>';
   document.formv1.m185r63.value = '<?php echo "$m185r63";?>';
   document.formv1.m185r64.value = '<?php echo "$m185r64";?>';
   document.formv1.m185r65.value = '<?php echo "$m185r65";?>';
   document.formv1.m185r66.value = '<?php echo "$m185r66";?>';
   document.formv1.m185r67.value = '<?php echo "$m185r67";?>';
   document.formv1.m185r71.value = '<?php echo "$m185r71";?>';
   document.formv1.m185r72.value = '<?php echo "$m185r72";?>';
   document.formv1.m185r73.value = '<?php echo "$m185r73";?>';
   document.formv1.m185r74.value = '<?php echo "$m185r74";?>';
   document.formv1.m185r75.value = '<?php echo "$m185r75";?>';
   document.formv1.m185r76.value = '<?php echo "$m185r76";?>';
   document.formv1.m185r77.value = '<?php echo "$m185r77";?>';
   document.formv1.m185r81.value = '<?php echo "$m185r81";?>';
   document.formv1.m185r82.value = '<?php echo "$m185r82";?>';
   document.formv1.m185r83.value = '<?php echo "$m185r83";?>';
   document.formv1.m185r84.value = '<?php echo "$m185r84";?>';
   document.formv1.m185r85.value = '<?php echo "$m185r85";?>';
   document.formv1.m185r86.value = '<?php echo "$m185r86";?>';
   document.formv1.m185r87.value = '<?php echo "$m185r87";?>';
   document.formv1.m185r91.value = '<?php echo "$m185r91";?>';
   document.formv1.m185r92.value = '<?php echo "$m185r92";?>';
   document.formv1.m185r93.value = '<?php echo "$m185r93";?>';
   document.formv1.m185r94.value = '<?php echo "$m185r94";?>';
   document.formv1.m185r95.value = '<?php echo "$m185r95";?>';
   document.formv1.m185r96.value = '<?php echo "$m185r96";?>';
   document.formv1.m185r97.value = '<?php echo "$m185r97";?>';
   document.formv1.m185r101.value = '<?php echo "$m185r101";?>';
   document.formv1.m185r102.value = '<?php echo "$m185r102";?>';
   document.formv1.m185r103.value = '<?php echo "$m185r103";?>';
   document.formv1.m185r104.value = '<?php echo "$m185r104";?>';
   document.formv1.m185r105.value = '<?php echo "$m185r105";?>';
   document.formv1.m185r106.value = '<?php echo "$m185r106";?>';
   document.formv1.m185r107.value = '<?php echo "$m185r107";?>';
   document.formv1.m185r111.value = '<?php echo "$m185r111";?>';
   document.formv1.m185r112.value = '<?php echo "$m185r112";?>';
   document.formv1.m185r113.value = '<?php echo "$m185r113";?>';
   document.formv1.m185r114.value = '<?php echo "$m185r114";?>';
   document.formv1.m185r115.value = '<?php echo "$m185r115";?>';
   document.formv1.m185r116.value = '<?php echo "$m185r116";?>';
   document.formv1.m185r117.value = '<?php echo "$m185r117";?>';
   document.formv1.m185r121.value = '<?php echo "$m185r121";?>';
   document.formv1.m185r122.value = '<?php echo "$m185r122";?>';
   document.formv1.m185r123.value = '<?php echo "$m185r123";?>';
   document.formv1.m185r124.value = '<?php echo "$m185r124";?>';
   document.formv1.m185r125.value = '<?php echo "$m185r125";?>';
   document.formv1.m185r126.value = '<?php echo "$m185r126";?>';
   document.formv1.m185r127.value = '<?php echo "$m185r127";?>';
   document.formv1.m185r131.value = '<?php echo "$m185r131";?>';
   document.formv1.m185r132.value = '<?php echo "$m185r132";?>';
   document.formv1.m185r133.value = '<?php echo "$m185r133";?>';
   document.formv1.m185r134.value = '<?php echo "$m185r134";?>';
   document.formv1.m185r135.value = '<?php echo "$m185r135";?>';
   document.formv1.m185r136.value = '<?php echo "$m185r136";?>';
   document.formv1.m185r137.value = '<?php echo "$m185r137";?>';
   document.formv1.m185r141.value = '<?php echo "$m185r141";?>';
   document.formv1.m185r142.value = '<?php echo "$m185r142";?>';
   document.formv1.m185r143.value = '<?php echo "$m185r143";?>';
   document.formv1.m185r144.value = '<?php echo "$m185r144";?>';
   document.formv1.m185r145.value = '<?php echo "$m185r145";?>';
   document.formv1.m185r146.value = '<?php echo "$m185r146";?>';
   document.formv1.m185r147.value = '<?php echo "$m185r147";?>';
   document.formv1.m185r151.value = '<?php echo "$m185r151";?>';
   document.formv1.m185r152.value = '<?php echo "$m185r152";?>';
   document.formv1.m185r153.value = '<?php echo "$m185r153";?>';
   document.formv1.m185r154.value = '<?php echo "$m185r154";?>';
   document.formv1.m185r155.value = '<?php echo "$m185r155";?>';
   document.formv1.m185r156.value = '<?php echo "$m185r156";?>';
   document.formv1.m185r157.value = '<?php echo "$m185r157";?>';
   document.formv1.m185r161.value = '<?php echo "$m185r161";?>';
   document.formv1.m185r162.value = '<?php echo "$m185r162";?>';
   document.formv1.m185r163.value = '<?php echo "$m185r163";?>';
   document.formv1.m185r164.value = '<?php echo "$m185r164";?>';
   document.formv1.m185r165.value = '<?php echo "$m185r165";?>';
   document.formv1.m185r166.value = '<?php echo "$m185r166";?>';
   document.formv1.m185r167.value = '<?php echo "$m185r167";?>';
   document.formv1.m185r171.value = '<?php echo "$m185r171";?>';
   document.formv1.m185r172.value = '<?php echo "$m185r172";?>';
   document.formv1.m185r173.value = '<?php echo "$m185r173";?>';
   document.formv1.m185r174.value = '<?php echo "$m185r174";?>';
   document.formv1.m185r175.value = '<?php echo "$m185r175";?>';
   document.formv1.m185r176.value = '<?php echo "$m185r176";?>';
   document.formv1.m185r177.value = '<?php echo "$m185r177";?>';
   document.formv1.m185r181.value = '<?php echo "$m185r181";?>';
   document.formv1.m185r182.value = '<?php echo "$m185r182";?>';
   document.formv1.m185r183.value = '<?php echo "$m185r183";?>';
   document.formv1.m185r184.value = '<?php echo "$m185r184";?>';
   document.formv1.m185r185.value = '<?php echo "$m185r185";?>';
   document.formv1.m185r186.value = '<?php echo "$m185r186";?>';
   document.formv1.m185r187.value = '<?php echo "$m185r187";?>';
   document.formv1.m185r191.value = '<?php echo "$m185r191";?>';
   document.formv1.m185r192.value = '<?php echo "$m185r192";?>';
   document.formv1.m185r193.value = '<?php echo "$m185r193";?>';
   document.formv1.m185r194.value = '<?php echo "$m185r194";?>';
   document.formv1.m185r195.value = '<?php echo "$m185r195";?>';
   document.formv1.m185r196.value = '<?php echo "$m185r196";?>';
   document.formv1.m185r197.value = '<?php echo "$m185r197";?>';
   document.formv1.m185r201.value = '<?php echo "$m185r201";?>';
   document.formv1.m185r202.value = '<?php echo "$m185r202";?>';
   document.formv1.m185r203.value = '<?php echo "$m185r203";?>';
   document.formv1.m185r204.value = '<?php echo "$m185r204";?>';
   document.formv1.m185r205.value = '<?php echo "$m185r205";?>';
   document.formv1.m185r206.value = '<?php echo "$m185r206";?>';
   document.formv1.m185r207.value = '<?php echo "$m185r207";?>';
   document.formv1.m185r211.value = '<?php echo "$m185r211";?>';
   document.formv1.m185r212.value = '<?php echo "$m185r212";?>';
   document.formv1.m185r213.value = '<?php echo "$m185r213";?>';
   document.formv1.m185r214.value = '<?php echo "$m185r214";?>';
   document.formv1.m185r215.value = '<?php echo "$m185r215";?>';
   document.formv1.m185r216.value = '<?php echo "$m185r216";?>';
   document.formv1.m185r217.value = '<?php echo "$m185r217";?>';
   document.formv1.m185r221.value = '<?php echo "$m185r221";?>';
   document.formv1.m185r222.value = '<?php echo "$m185r222";?>';
   document.formv1.m185r223.value = '<?php echo "$m185r223";?>';
   document.formv1.m185r224.value = '<?php echo "$m185r224";?>';
   document.formv1.m185r225.value = '<?php echo "$m185r225";?>';
   document.formv1.m185r226.value = '<?php echo "$m185r226";?>';
   document.formv1.m185r227.value = '<?php echo "$m185r227";?>';
   document.formv1.m185r231.value = '<?php echo "$m185r231";?>';
   document.formv1.m185r232.value = '<?php echo "$m185r232";?>';
   document.formv1.m185r233.value = '<?php echo "$m185r233";?>';
   document.formv1.m185r234.value = '<?php echo "$m185r234";?>';
   document.formv1.m185r235.value = '<?php echo "$m185r235";?>';
   document.formv1.m185r236.value = '<?php echo "$m185r236";?>';
   document.formv1.m185r237.value = '<?php echo "$m185r237";?>';
   document.formv1.m185r241.value = '<?php echo "$m185r241";?>';
   document.formv1.m185r242.value = '<?php echo "$m185r242";?>';
   document.formv1.m185r243.value = '<?php echo "$m185r243";?>';
   document.formv1.m185r244.value = '<?php echo "$m185r244";?>';
   document.formv1.m185r245.value = '<?php echo "$m185r245";?>';
   document.formv1.m185r246.value = '<?php echo "$m185r246";?>';
   document.formv1.m185r247.value = '<?php echo "$m185r247";?>';
   document.formv1.m185r251.value = '<?php echo "$m185r251";?>';
   document.formv1.m185r252.value = '<?php echo "$m185r252";?>';
   document.formv1.m185r253.value = '<?php echo "$m185r253";?>';
   document.formv1.m185r254.value = '<?php echo "$m185r254";?>';
   document.formv1.m185r255.value = '<?php echo "$m185r255";?>';
   document.formv1.m185r256.value = '<?php echo "$m185r256";?>';
   document.formv1.m185r257.value = '<?php echo "$m185r257";?>';
   document.formv1.m185r261.value = '<?php echo "$m185r261";?>';
   document.formv1.m185r262.value = '<?php echo "$m185r262";?>';
   document.formv1.m185r263.value = '<?php echo "$m185r263";?>';
   document.formv1.m185r264.value = '<?php echo "$m185r264";?>';
   document.formv1.m185r265.value = '<?php echo "$m185r265";?>';
   document.formv1.m185r266.value = '<?php echo "$m185r266";?>';
   document.formv1.m185r267.value = '<?php echo "$m185r267";?>';
   document.formv1.m185r271.value = '<?php echo "$m185r271";?>';
   document.formv1.m185r272.value = '<?php echo "$m185r272";?>';
   document.formv1.m185r273.value = '<?php echo "$m185r273";?>';
   document.formv1.m185r274.value = '<?php echo "$m185r274";?>';
   document.formv1.m185r275.value = '<?php echo "$m185r275";?>';
   document.formv1.m185r276.value = '<?php echo "$m185r276";?>';
   document.formv1.m185r277.value = '<?php echo "$m185r277";?>';
   document.formv1.m185r281.value = '<?php echo "$m185r281";?>';
   document.formv1.m185r282.value = '<?php echo "$m185r282";?>';
   document.formv1.m185r283.value = '<?php echo "$m185r283";?>';
   document.formv1.m185r284.value = '<?php echo "$m185r284";?>';
   document.formv1.m185r285.value = '<?php echo "$m185r285";?>';
   document.formv1.m185r286.value = '<?php echo "$m185r286";?>';
   document.formv1.m185r287.value = '<?php echo "$m185r287";?>';
   document.formv1.m185r291.value = '<?php echo "$m185r291";?>';
   document.formv1.m185r292.value = '<?php echo "$m185r292";?>';
   document.formv1.m185r293.value = '<?php echo "$m185r293";?>';
   document.formv1.m185r294.value = '<?php echo "$m185r294";?>';
   document.formv1.m185r295.value = '<?php echo "$m185r295";?>';
   document.formv1.m185r296.value = '<?php echo "$m185r296";?>';
   document.formv1.m185r297.value = '<?php echo "$m185r297";?>';
   document.formv1.m185r301.value = '<?php echo "$m185r301";?>';
   document.formv1.m185r302.value = '<?php echo "$m185r302";?>';
   document.formv1.m185r303.value = '<?php echo "$m185r303";?>';
   document.formv1.m185r304.value = '<?php echo "$m185r304";?>';
   document.formv1.m185r305.value = '<?php echo "$m185r305";?>';
   document.formv1.m185r306.value = '<?php echo "$m185r306";?>';
   document.formv1.m185r307.value = '<?php echo "$m185r307";?>';
 //document.formv1.m185r992.value = '<?php echo "$m185r992";?>';
 //document.formv1.m185r993.value = '<?php echo "$m185r993";?>';
 //document.formv1.m185r994.value = '<?php echo "$m185r994";?>';
 //document.formv1.m185r995.value = '<?php echo "$m185r995";?>';
 //document.formv1.m185r996.value = '<?php echo "$m185r996";?>';
 //document.formv1.m185r997.value = '<?php echo "$m185r997";?>';
<?php                     } ?>

<?php if ( $strana == 9 ) { ?>
   document.formv1.m186r11.value = '<?php echo "$m186r11";?>';
   document.formv1.m186r12.value = '<?php echo "$m186r12";?>';
   document.formv1.m186r13.value = '<?php echo "$m186r13";?>';
   document.formv1.m186r14.value = '<?php echo "$m186r14";?>';
   document.formv1.m186r15.value = '<?php echo "$m186r15";?>';
   document.formv1.m186r16.value = '<?php echo "$m186r16";?>';
   document.formv1.m186r17.value = '<?php echo "$m186r17";?>';
   document.formv1.m186r21.value = '<?php echo "$m186r21";?>';
   document.formv1.m186r22.value = '<?php echo "$m186r22";?>';
   document.formv1.m186r23.value = '<?php echo "$m186r23";?>';
   document.formv1.m186r24.value = '<?php echo "$m186r24";?>';
   document.formv1.m186r25.value = '<?php echo "$m186r25";?>';
   document.formv1.m186r26.value = '<?php echo "$m186r26";?>';
   document.formv1.m186r27.value = '<?php echo "$m186r27";?>';
   document.formv1.m186r31.value = '<?php echo "$m186r31";?>';
   document.formv1.m186r32.value = '<?php echo "$m186r32";?>';
   document.formv1.m186r33.value = '<?php echo "$m186r33";?>';
   document.formv1.m186r34.value = '<?php echo "$m186r34";?>';
   document.formv1.m186r35.value = '<?php echo "$m186r35";?>';
   document.formv1.m186r36.value = '<?php echo "$m186r36";?>';
   document.formv1.m186r37.value = '<?php echo "$m186r37";?>';
   document.formv1.m186r41.value = '<?php echo "$m186r41";?>';
   document.formv1.m186r42.value = '<?php echo "$m186r42";?>';
   document.formv1.m186r43.value = '<?php echo "$m186r43";?>';
   document.formv1.m186r44.value = '<?php echo "$m186r44";?>';
   document.formv1.m186r45.value = '<?php echo "$m186r45";?>';
   document.formv1.m186r46.value = '<?php echo "$m186r46";?>';
   document.formv1.m186r47.value = '<?php echo "$m186r47";?>';
   document.formv1.m186r51.value = '<?php echo "$m186r51";?>';
   document.formv1.m186r52.value = '<?php echo "$m186r52";?>';
   document.formv1.m186r53.value = '<?php echo "$m186r53";?>';
   document.formv1.m186r54.value = '<?php echo "$m186r54";?>';
   document.formv1.m186r55.value = '<?php echo "$m186r55";?>';
   document.formv1.m186r56.value = '<?php echo "$m186r56";?>';
   document.formv1.m186r57.value = '<?php echo "$m186r57";?>';
   document.formv1.m186r61.value = '<?php echo "$m186r61";?>';
   document.formv1.m186r62.value = '<?php echo "$m186r62";?>';
   document.formv1.m186r63.value = '<?php echo "$m186r63";?>';
   document.formv1.m186r64.value = '<?php echo "$m186r64";?>';
   document.formv1.m186r65.value = '<?php echo "$m186r65";?>';
   document.formv1.m186r66.value = '<?php echo "$m186r66";?>';
   document.formv1.m186r67.value = '<?php echo "$m186r67";?>';
   document.formv1.m186r71.value = '<?php echo "$m186r71";?>';
   document.formv1.m186r72.value = '<?php echo "$m186r72";?>';
   document.formv1.m186r73.value = '<?php echo "$m186r73";?>';
   document.formv1.m186r74.value = '<?php echo "$m186r74";?>';
   document.formv1.m186r75.value = '<?php echo "$m186r75";?>';
   document.formv1.m186r76.value = '<?php echo "$m186r76";?>';
   document.formv1.m186r77.value = '<?php echo "$m186r77";?>';
   document.formv1.m186r81.value = '<?php echo "$m186r81";?>';
   document.formv1.m186r82.value = '<?php echo "$m186r82";?>';
   document.formv1.m186r83.value = '<?php echo "$m186r83";?>';
   document.formv1.m186r84.value = '<?php echo "$m186r84";?>';
   document.formv1.m186r85.value = '<?php echo "$m186r85";?>';
   document.formv1.m186r86.value = '<?php echo "$m186r86";?>';
   document.formv1.m186r87.value = '<?php echo "$m186r87";?>';
   document.formv1.m186r91.value = '<?php echo "$m186r91";?>';
   document.formv1.m186r92.value = '<?php echo "$m186r92";?>';
   document.formv1.m186r93.value = '<?php echo "$m186r93";?>';
   document.formv1.m186r94.value = '<?php echo "$m186r94";?>';
   document.formv1.m186r95.value = '<?php echo "$m186r95";?>';
   document.formv1.m186r96.value = '<?php echo "$m186r96";?>';
   document.formv1.m186r97.value = '<?php echo "$m186r97";?>';
   document.formv1.m186r101.value = '<?php echo "$m186r101";?>';
   document.formv1.m186r102.value = '<?php echo "$m186r102";?>';
   document.formv1.m186r103.value = '<?php echo "$m186r103";?>';
   document.formv1.m186r104.value = '<?php echo "$m186r104";?>';
   document.formv1.m186r105.value = '<?php echo "$m186r105";?>';
   document.formv1.m186r106.value = '<?php echo "$m186r106";?>';
   document.formv1.m186r107.value = '<?php echo "$m186r107";?>';
   document.formv1.m186r111.value = '<?php echo "$m186r111";?>';
   document.formv1.m186r112.value = '<?php echo "$m186r112";?>';
   document.formv1.m186r113.value = '<?php echo "$m186r113";?>';
   document.formv1.m186r114.value = '<?php echo "$m186r114";?>';
   document.formv1.m186r115.value = '<?php echo "$m186r115";?>';
   document.formv1.m186r116.value = '<?php echo "$m186r116";?>';
   document.formv1.m186r117.value = '<?php echo "$m186r117";?>';
   document.formv1.m186r121.value = '<?php echo "$m186r121";?>';
   document.formv1.m186r122.value = '<?php echo "$m186r122";?>';
   document.formv1.m186r123.value = '<?php echo "$m186r123";?>';
   document.formv1.m186r124.value = '<?php echo "$m186r124";?>';
   document.formv1.m186r125.value = '<?php echo "$m186r125";?>';
   document.formv1.m186r126.value = '<?php echo "$m186r126";?>';
   document.formv1.m186r127.value = '<?php echo "$m186r127";?>';
   document.formv1.m186r131.value = '<?php echo "$m186r131";?>';
   document.formv1.m186r132.value = '<?php echo "$m186r132";?>';
   document.formv1.m186r133.value = '<?php echo "$m186r133";?>';
   document.formv1.m186r134.value = '<?php echo "$m186r134";?>';
   document.formv1.m186r135.value = '<?php echo "$m186r135";?>';
   document.formv1.m186r136.value = '<?php echo "$m186r136";?>';
   document.formv1.m186r137.value = '<?php echo "$m186r137";?>';
   document.formv1.m186r141.value = '<?php echo "$m186r141";?>';
   document.formv1.m186r142.value = '<?php echo "$m186r142";?>';
   document.formv1.m186r143.value = '<?php echo "$m186r143";?>';
   document.formv1.m186r144.value = '<?php echo "$m186r144";?>';
   document.formv1.m186r145.value = '<?php echo "$m186r145";?>';
   document.formv1.m186r146.value = '<?php echo "$m186r146";?>';
   document.formv1.m186r147.value = '<?php echo "$m186r147";?>';
   document.formv1.m186r151.value = '<?php echo "$m186r151";?>';
   document.formv1.m186r152.value = '<?php echo "$m186r152";?>';
   document.formv1.m186r153.value = '<?php echo "$m186r153";?>';
   document.formv1.m186r154.value = '<?php echo "$m186r154";?>';
   document.formv1.m186r155.value = '<?php echo "$m186r155";?>';
   document.formv1.m186r156.value = '<?php echo "$m186r156";?>';
   document.formv1.m186r157.value = '<?php echo "$m186r157";?>';
   document.formv1.m186r161.value = '<?php echo "$m186r161";?>';
   document.formv1.m186r162.value = '<?php echo "$m186r162";?>';
   document.formv1.m186r163.value = '<?php echo "$m186r163";?>';
   document.formv1.m186r164.value = '<?php echo "$m186r164";?>';
   document.formv1.m186r165.value = '<?php echo "$m186r165";?>';
   document.formv1.m186r166.value = '<?php echo "$m186r166";?>';
   document.formv1.m186r167.value = '<?php echo "$m186r167";?>';
   document.formv1.m186r171.value = '<?php echo "$m186r171";?>';
   document.formv1.m186r172.value = '<?php echo "$m186r172";?>';
   document.formv1.m186r173.value = '<?php echo "$m186r173";?>';
   document.formv1.m186r174.value = '<?php echo "$m186r174";?>';
   document.formv1.m186r175.value = '<?php echo "$m186r175";?>';
   document.formv1.m186r176.value = '<?php echo "$m186r176";?>';
   document.formv1.m186r177.value = '<?php echo "$m186r177";?>';
   document.formv1.m186r181.value = '<?php echo "$m186r181";?>';
   document.formv1.m186r182.value = '<?php echo "$m186r182";?>';
   document.formv1.m186r183.value = '<?php echo "$m186r183";?>';
   document.formv1.m186r184.value = '<?php echo "$m186r184";?>';
   document.formv1.m186r185.value = '<?php echo "$m186r185";?>';
   document.formv1.m186r186.value = '<?php echo "$m186r186";?>';
   document.formv1.m186r187.value = '<?php echo "$m186r187";?>';
   document.formv1.m186r191.value = '<?php echo "$m186r191";?>';
   document.formv1.m186r192.value = '<?php echo "$m186r192";?>';
   document.formv1.m186r193.value = '<?php echo "$m186r193";?>';
   document.formv1.m186r194.value = '<?php echo "$m186r194";?>';
   document.formv1.m186r195.value = '<?php echo "$m186r195";?>';
   document.formv1.m186r196.value = '<?php echo "$m186r196";?>';
   document.formv1.m186r197.value = '<?php echo "$m186r197";?>';
   document.formv1.m186r201.value = '<?php echo "$m186r201";?>';
   document.formv1.m186r202.value = '<?php echo "$m186r202";?>';
   document.formv1.m186r203.value = '<?php echo "$m186r203";?>';
   document.formv1.m186r204.value = '<?php echo "$m186r204";?>';
   document.formv1.m186r205.value = '<?php echo "$m186r205";?>';
   document.formv1.m186r206.value = '<?php echo "$m186r206";?>';
   document.formv1.m186r207.value = '<?php echo "$m186r207";?>';
   document.formv1.m186r211.value = '<?php echo "$m186r211";?>';
   document.formv1.m186r212.value = '<?php echo "$m186r212";?>';
   document.formv1.m186r213.value = '<?php echo "$m186r213";?>';
   document.formv1.m186r214.value = '<?php echo "$m186r214";?>';
   document.formv1.m186r215.value = '<?php echo "$m186r215";?>';
   document.formv1.m186r216.value = '<?php echo "$m186r216";?>';
   document.formv1.m186r217.value = '<?php echo "$m186r217";?>';
   document.formv1.m186r221.value = '<?php echo "$m186r221";?>';
   document.formv1.m186r222.value = '<?php echo "$m186r222";?>';
   document.formv1.m186r223.value = '<?php echo "$m186r223";?>';
   document.formv1.m186r224.value = '<?php echo "$m186r224";?>';
   document.formv1.m186r225.value = '<?php echo "$m186r225";?>';
   document.formv1.m186r226.value = '<?php echo "$m186r226";?>';
   document.formv1.m186r227.value = '<?php echo "$m186r227";?>';
   document.formv1.m186r231.value = '<?php echo "$m186r231";?>';
   document.formv1.m186r232.value = '<?php echo "$m186r232";?>';
   document.formv1.m186r233.value = '<?php echo "$m186r233";?>';
   document.formv1.m186r234.value = '<?php echo "$m186r234";?>';
   document.formv1.m186r235.value = '<?php echo "$m186r235";?>';
   document.formv1.m186r236.value = '<?php echo "$m186r236";?>';
   document.formv1.m186r237.value = '<?php echo "$m186r237";?>';
   document.formv1.m186r241.value = '<?php echo "$m186r241";?>';
   document.formv1.m186r242.value = '<?php echo "$m186r242";?>';
   document.formv1.m186r243.value = '<?php echo "$m186r243";?>';
   document.formv1.m186r244.value = '<?php echo "$m186r244";?>';
   document.formv1.m186r245.value = '<?php echo "$m186r245";?>';
   document.formv1.m186r246.value = '<?php echo "$m186r246";?>';
   document.formv1.m186r247.value = '<?php echo "$m186r247";?>';
   document.formv1.m186r251.value = '<?php echo "$m186r251";?>';
   document.formv1.m186r252.value = '<?php echo "$m186r252";?>';
   document.formv1.m186r253.value = '<?php echo "$m186r253";?>';
   document.formv1.m186r254.value = '<?php echo "$m186r254";?>';
   document.formv1.m186r255.value = '<?php echo "$m186r255";?>';
   document.formv1.m186r256.value = '<?php echo "$m186r256";?>';
   document.formv1.m186r257.value = '<?php echo "$m186r257";?>';
   document.formv1.m186r261.value = '<?php echo "$m186r261";?>';
   document.formv1.m186r262.value = '<?php echo "$m186r262";?>';
   document.formv1.m186r263.value = '<?php echo "$m186r263";?>';
   document.formv1.m186r264.value = '<?php echo "$m186r264";?>';
   document.formv1.m186r265.value = '<?php echo "$m186r265";?>';
   document.formv1.m186r266.value = '<?php echo "$m186r266";?>';
   document.formv1.m186r267.value = '<?php echo "$m186r267";?>';
   document.formv1.m186r271.value = '<?php echo "$m186r271";?>';
   document.formv1.m186r272.value = '<?php echo "$m186r272";?>';
   document.formv1.m186r273.value = '<?php echo "$m186r273";?>';
   document.formv1.m186r274.value = '<?php echo "$m186r274";?>';
   document.formv1.m186r275.value = '<?php echo "$m186r275";?>';
   document.formv1.m186r276.value = '<?php echo "$m186r276";?>';
   document.formv1.m186r277.value = '<?php echo "$m186r277";?>';
   document.formv1.m186r281.value = '<?php echo "$m186r281";?>';
   document.formv1.m186r282.value = '<?php echo "$m186r282";?>';
   document.formv1.m186r283.value = '<?php echo "$m186r283";?>';
   document.formv1.m186r284.value = '<?php echo "$m186r284";?>';
   document.formv1.m186r285.value = '<?php echo "$m186r285";?>';
   document.formv1.m186r286.value = '<?php echo "$m186r286";?>';
   document.formv1.m186r287.value = '<?php echo "$m186r287";?>';
   document.formv1.m186r291.value = '<?php echo "$m186r291";?>';
   document.formv1.m186r292.value = '<?php echo "$m186r292";?>';
   document.formv1.m186r293.value = '<?php echo "$m186r293";?>';
   document.formv1.m186r294.value = '<?php echo "$m186r294";?>';
   document.formv1.m186r295.value = '<?php echo "$m186r295";?>';
   document.formv1.m186r296.value = '<?php echo "$m186r296";?>';
   document.formv1.m186r297.value = '<?php echo "$m186r297";?>';
   document.formv1.m186r301.value = '<?php echo "$m186r301";?>';
   document.formv1.m186r302.value = '<?php echo "$m186r302";?>';
   document.formv1.m186r303.value = '<?php echo "$m186r303";?>';
   document.formv1.m186r304.value = '<?php echo "$m186r304";?>';
   document.formv1.m186r305.value = '<?php echo "$m186r305";?>';
   document.formv1.m186r306.value = '<?php echo "$m186r306";?>';
   document.formv1.m186r307.value = '<?php echo "$m186r307";?>';
 //document.formv1.m186r992.value = '<?php echo "$m186r992";?>';
 //document.formv1.m186r993.value = '<?php echo "$m186r993";?>';
 //document.formv1.m186r994.value = '<?php echo "$m186r994";?>';
 //document.formv1.m186r995.value = '<?php echo "$m186r995";?>';
 //document.formv1.m186r996.value = '<?php echo "$m186r996";?>';
 //document.formv1.m186r997.value = '<?php echo "$m186r997";?>';
<?php                     } ?>

<?php if ( $strana == 10 ) { ?>
   document.formv1.m187r1.value = '<?php echo "$m187r1";?>';
// document.formv1.m187r2.value = '<?php echo "$m187r2";?>';
// document.formv1.m187r3.value = '<?php echo "$m187r3";?>';
// document.formv1.m187r4.value = '<?php echo "$m187r4";?>';
// document.formv1.m187r5.value = '<?php echo "$m187r5";?>';
// document.formv1.m187r6.value = '<?php echo "$m187r6";?>';
// document.formv1.m187r7.value = '<?php echo "$m187r7";?>';
// document.formv1.m187r8.value = '<?php echo "$m187r8";?>';
// document.formv1.m187r9.value = '<?php echo "$m187r9";?>';
// document.formv1.m187r10.value = '<?php echo "$m187r10";?>';
// document.formv1.m187r11.value = '<?php echo "$m187r11";?>';
// document.formv1.m187r99.value = '<?php echo "$m187r99";?>';
<?php if ( $m1590r1a == 1 ) { echo "document.formv1.m1590r1a.checked='checked';"; } ?>
<?php if ( $m1590r1b == 1 ) { echo "document.formv1.m1590r1b.checked='checked';"; } ?>
<?php if ( $m1590r2a == 1 ) { echo "document.formv1.m1590r2a.checked='checked';"; } ?>
<?php if ( $m1590r2b == 1 ) { echo "document.formv1.m1590r2b.checked='checked';"; } ?>
   document.formv1.m590r11.value = '<?php echo "$m590r11";?>';
   document.formv1.m590r12.value = '<?php echo "$m590r12";?>';
   document.formv1.m590r13.value = '<?php echo "$m590r13";?>';
   document.formv1.m590r14.value = '<?php echo "$m590r14";?>';
   document.formv1.m590r15.value = '<?php echo "$m590r15";?>';
   document.formv1.m590r21.value = '<?php echo "$m590r21";?>';
   document.formv1.m590r22.value = '<?php echo "$m590r22";?>';
   document.formv1.m590r23.value = '<?php echo "$m590r23";?>';
   document.formv1.m590r24.value = '<?php echo "$m590r24";?>';
   document.formv1.m590r25.value = '<?php echo "$m590r25";?>';
   document.formv1.m590r31.value = '<?php echo "$m590r31";?>';
   document.formv1.m590r32.value = '<?php echo "$m590r32";?>';
   document.formv1.m590r33.value = '<?php echo "$m590r33";?>';
   document.formv1.m590r34.value = '<?php echo "$m590r34";?>';
   document.formv1.m590r35.value = '<?php echo "$m590r35";?>';
   document.formv1.m590r41.value = '<?php echo "$m590r41";?>';
   document.formv1.m590r42.value = '<?php echo "$m590r42";?>';
   document.formv1.m590r43.value = '<?php echo "$m590r43";?>';
   document.formv1.m590r44.value = '<?php echo "$m590r44";?>';
   document.formv1.m590r45.value = '<?php echo "$m590r45";?>';
   document.formv1.m590r51.value = '<?php echo "$m590r51";?>';
   document.formv1.m590r52.value = '<?php echo "$m590r52";?>';
   document.formv1.m590r53.value = '<?php echo "$m590r53";?>';
   document.formv1.m590r54.value = '<?php echo "$m590r54";?>';
   document.formv1.m590r55.value = '<?php echo "$m590r55";?>';
   document.formv1.m590r61.value = '<?php echo "$m590r61";?>';
   document.formv1.m590r62.value = '<?php echo "$m590r62";?>';
   document.formv1.m590r63.value = '<?php echo "$m590r63";?>';
   document.formv1.m590r64.value = '<?php echo "$m590r64";?>';
   document.formv1.m590r65.value = '<?php echo "$m590r65";?>';
   document.formv1.m590r71.value = '<?php echo "$m590r71";?>';
   document.formv1.m590r72.value = '<?php echo "$m590r72";?>';
   document.formv1.m590r73.value = '<?php echo "$m590r73";?>';
   document.formv1.m590r74.value = '<?php echo "$m590r74";?>';
   document.formv1.m590r75.value = '<?php echo "$m590r75";?>';
   document.formv1.m590r81.value = '<?php echo "$m590r81";?>';
   document.formv1.m590r82.value = '<?php echo "$m590r82";?>';
   document.formv1.m590r83.value = '<?php echo "$m590r83";?>';
   document.formv1.m590r84.value = '<?php echo "$m590r84";?>';
   document.formv1.m590r85.value = '<?php echo "$m590r85";?>';
   document.formv1.m590r91.value = '<?php echo "$m590r91";?>';
   document.formv1.m590r92.value = '<?php echo "$m590r92";?>';
   document.formv1.m590r93.value = '<?php echo "$m590r93";?>';
   document.formv1.m590r94.value = '<?php echo "$m590r94";?>';
   document.formv1.m590r95.value = '<?php echo "$m590r95";?>';
   document.formv1.m590r101.value = '<?php echo "$m590r101";?>';
   document.formv1.m590r102.value = '<?php echo "$m590r102";?>';
   document.formv1.m590r103.value = '<?php echo "$m590r103";?>';
   document.formv1.m590r104.value = '<?php echo "$m590r104";?>';
   document.formv1.m590r105.value = '<?php echo "$m590r105";?>';
   document.formv1.m590r111.value = '<?php echo "$m590r111";?>';
   document.formv1.m590r112.value = '<?php echo "$m590r112";?>';
   document.formv1.m590r113.value = '<?php echo "$m590r113";?>';
   document.formv1.m590r114.value = '<?php echo "$m590r114";?>';
   document.formv1.m590r115.value = '<?php echo "$m590r115";?>';
   document.formv1.m590r121.value = '<?php echo "$m590r121";?>';
   document.formv1.m590r122.value = '<?php echo "$m590r122";?>';
   document.formv1.m590r123.value = '<?php echo "$m590r123";?>';
   document.formv1.m590r124.value = '<?php echo "$m590r124";?>';
   document.formv1.m590r125.value = '<?php echo "$m590r125";?>';
   document.formv1.m590r131.value = '<?php echo "$m590r131";?>';
   document.formv1.m590r132.value = '<?php echo "$m590r132";?>';
   document.formv1.m590r133.value = '<?php echo "$m590r133";?>';
   document.formv1.m590r134.value = '<?php echo "$m590r134";?>';
   document.formv1.m590r135.value = '<?php echo "$m590r135";?>';
   document.formv1.m590r141.value = '<?php echo "$m590r141";?>';
   document.formv1.m590r142.value = '<?php echo "$m590r142";?>';
   document.formv1.m590r143.value = '<?php echo "$m590r143";?>';
   document.formv1.m590r144.value = '<?php echo "$m590r144";?>';
   document.formv1.m590r145.value = '<?php echo "$m590r145";?>';
   document.formv1.m590r151.value = '<?php echo "$m590r151";?>';
   document.formv1.m590r152.value = '<?php echo "$m590r152";?>';
   document.formv1.m590r153.value = '<?php echo "$m590r153";?>';
   document.formv1.m590r154.value = '<?php echo "$m590r154";?>';
   document.formv1.m590r155.value = '<?php echo "$m590r155";?>';
   document.formv1.m590r161.value = '<?php echo "$m590r161";?>';
   document.formv1.m590r162.value = '<?php echo "$m590r162";?>';
   document.formv1.m590r163.value = '<?php echo "$m590r163";?>';
   document.formv1.m590r164.value = '<?php echo "$m590r164";?>';
   document.formv1.m590r165.value = '<?php echo "$m590r165";?>';
   document.formv1.m590r171.value = '<?php echo "$m590r171";?>';
   document.formv1.m590r172.value = '<?php echo "$m590r172";?>';
   document.formv1.m590r173.value = '<?php echo "$m590r173";?>';
   document.formv1.m590r174.value = '<?php echo "$m590r174";?>';
   document.formv1.m590r175.value = '<?php echo "$m590r175";?>';
   document.formv1.m590r181.value = '<?php echo "$m590r181";?>';
   document.formv1.m590r182.value = '<?php echo "$m590r182";?>';
   document.formv1.m590r183.value = '<?php echo "$m590r183";?>';
   document.formv1.m590r184.value = '<?php echo "$m590r184";?>';
   document.formv1.m590r185.value = '<?php echo "$m590r185";?>';
   document.formv1.m590r191.value = '<?php echo "$m590r191";?>';
   document.formv1.m590r192.value = '<?php echo "$m590r192";?>';
   document.formv1.m590r193.value = '<?php echo "$m590r193";?>';
   document.formv1.m590r194.value = '<?php echo "$m590r194";?>';
   document.formv1.m590r195.value = '<?php echo "$m590r195";?>';
   document.formv1.m590r201.value = '<?php echo "$m590r201";?>';
   document.formv1.m590r202.value = '<?php echo "$m590r202";?>';
   document.formv1.m590r203.value = '<?php echo "$m590r203";?>';
   document.formv1.m590r204.value = '<?php echo "$m590r204";?>';
   document.formv1.m590r205.value = '<?php echo "$m590r205";?>';
 //document.formv1.m590r992.value = '<?php echo "$m590r992";?>';
 //document.formv1.m590r993.value = '<?php echo "$m590r993";?>';
 //document.formv1.m590r994.value = '<?php echo "$m590r994";?>';
 //document.formv1.m590r995.value = '<?php echo "$m590r995";?>';
<?php                      } ?>

<?php if ( $strana == 11 ) { ?>
   document.formv1.m304r1.value = '<?php echo "$m304r1";?>';
   document.formv1.m304r2.value = '<?php echo "$m304r2";?>';
   document.formv1.m304r3.value = '<?php echo "$m304r3";?>';
   document.formv1.m304r4.value = '<?php echo "$m304r4";?>';
   document.formv1.m304r5.value = '<?php echo "$m304r5";?>';
   document.formv1.m304r6.value = '<?php echo "$m304r6";?>';
   document.formv1.m304r7.value = '<?php echo "$m304r7";?>';
   document.formv1.m304r8.value = '<?php echo "$m304r8";?>';
   document.formv1.m304r9.value = '<?php echo "$m304r9";?>';
   document.formv1.m304r10.value = '<?php echo "$m304r10";?>';
   document.formv1.m304r11.value = '<?php echo "$m304r11";?>';
   document.formv1.m304r12.value = '<?php echo "$m304r12";?>';
   document.formv1.m304r13.value = '<?php echo "$m304r13";?>';
   document.formv1.m304r14.value = '<?php echo "$m304r14";?>';
   document.formv1.m304r15.value = '<?php echo "$m304r15";?>';
   document.formv1.m304r16.value = '<?php echo "$m304r16";?>';
 //document.formv1.m304r99.value = '<?php echo "$m304r99";?>';
<?php                      } ?>

<?php if ( $strana == 12 ) { ?>
   document.formv1.m110r12.value = '<?php echo "$m110r12";?>';
   document.formv1.m110r13.value = '<?php echo "$m110r13";?>';
   document.formv1.m110r14.value = '<?php echo "$m110r14";?>';
   document.formv1.m110r15.value = '<?php echo "$m110r15";?>';
   document.formv1.m110r16.value = '<?php echo "$m110r16";?>';
   document.formv1.m110r17.value = '<?php echo "$m110r17";?>';
   document.formv1.m110r18.value = '<?php echo "$m110r18";?>';
   document.formv1.m110r19.value = '<?php echo "$m110r19";?>';
   document.formv1.m110r22.value = '<?php echo "$m110r22";?>';
   document.formv1.m110r23.value = '<?php echo "$m110r23";?>';
   document.formv1.m110r24.value = '<?php echo "$m110r24";?>';
   document.formv1.m110r25.value = '<?php echo "$m110r25";?>';
   document.formv1.m110r26.value = '<?php echo "$m110r26";?>';
   document.formv1.m110r27.value = '<?php echo "$m110r27";?>';
   document.formv1.m110r28.value = '<?php echo "$m110r28";?>';
   document.formv1.m110r29.value = '<?php echo "$m110r29";?>';
   document.formv1.m110r32.value = '<?php echo "$m110r32";?>';
   document.formv1.m110r33.value = '<?php echo "$m110r33";?>';
   document.formv1.m110r34.value = '<?php echo "$m110r34";?>';
   document.formv1.m110r35.value = '<?php echo "$m110r35";?>';
   document.formv1.m110r36.value = '<?php echo "$m110r36";?>';
   document.formv1.m110r37.value = '<?php echo "$m110r37";?>';
   document.formv1.m110r38.value = '<?php echo "$m110r38";?>';
   document.formv1.m110r39.value = '<?php echo "$m110r39";?>';
   document.formv1.m110r42.value = '<?php echo "$m110r42";?>';
   document.formv1.m110r43.value = '<?php echo "$m110r43";?>';
   document.formv1.m110r44.value = '<?php echo "$m110r44";?>';
   document.formv1.m110r45.value = '<?php echo "$m110r45";?>';
   document.formv1.m110r46.value = '<?php echo "$m110r46";?>';
   document.formv1.m110r47.value = '<?php echo "$m110r47";?>';
   document.formv1.m110r48.value = '<?php echo "$m110r48";?>';
   document.formv1.m110r49.value = '<?php echo "$m110r49";?>';
   document.formv1.m110r52.value = '<?php echo "$m110r52";?>';
   document.formv1.m110r53.value = '<?php echo "$m110r53";?>';
   document.formv1.m110r54.value = '<?php echo "$m110r54";?>';
   document.formv1.m110r55.value = '<?php echo "$m110r55";?>';
   document.formv1.m110r56.value = '<?php echo "$m110r56";?>';
   document.formv1.m110r57.value = '<?php echo "$m110r57";?>';
   document.formv1.m110r58.value = '<?php echo "$m110r58";?>';
   document.formv1.m110r59.value = '<?php echo "$m110r59";?>';
   document.formv1.m110r62.value = '<?php echo "$m110r62";?>';
   document.formv1.m110r63.value = '<?php echo "$m110r63";?>';
   document.formv1.m110r64.value = '<?php echo "$m110r64";?>';
   document.formv1.m110r65.value = '<?php echo "$m110r65";?>';
   document.formv1.m110r66.value = '<?php echo "$m110r66";?>';
   document.formv1.m110r67.value = '<?php echo "$m110r67";?>';
   document.formv1.m110r68.value = '<?php echo "$m110r68";?>';
   document.formv1.m110r69.value = '<?php echo "$m110r69";?>';
   document.formv1.m110r72.value = '<?php echo "$m110r72";?>';
   document.formv1.m110r73.value = '<?php echo "$m110r73";?>';
   document.formv1.m110r74.value = '<?php echo "$m110r74";?>';
   document.formv1.m110r75.value = '<?php echo "$m110r75";?>';
   document.formv1.m110r76.value = '<?php echo "$m110r76";?>';
   document.formv1.m110r77.value = '<?php echo "$m110r77";?>';
   document.formv1.m110r78.value = '<?php echo "$m110r78";?>';
   document.formv1.m110r79.value = '<?php echo "$m110r79";?>';
   document.formv1.m110r82.value = '<?php echo "$m110r82";?>';
   document.formv1.m110r83.value = '<?php echo "$m110r83";?>';
   document.formv1.m110r84.value = '<?php echo "$m110r84";?>';
   document.formv1.m110r85.value = '<?php echo "$m110r85";?>';
   document.formv1.m110r86.value = '<?php echo "$m110r86";?>';
   document.formv1.m110r87.value = '<?php echo "$m110r87";?>';
   document.formv1.m110r88.value = '<?php echo "$m110r88";?>';
   document.formv1.m110r89.value = '<?php echo "$m110r89";?>';
   document.formv1.m110r92.value = '<?php echo "$m110r92";?>';
   document.formv1.m110r93.value = '<?php echo "$m110r93";?>';
   document.formv1.m110r94.value = '<?php echo "$m110r94";?>';
   document.formv1.m110r95.value = '<?php echo "$m110r95";?>';
   document.formv1.m110r96.value = '<?php echo "$m110r96";?>';
   document.formv1.m110r97.value = '<?php echo "$m110r97";?>';
   document.formv1.m110r98.value = '<?php echo "$m110r98";?>';
   document.formv1.m110r99.value = '<?php echo "$m110r99";?>';
   document.formv1.m110r102.value = '<?php echo "$m110r102";?>';
   document.formv1.m110r103.value = '<?php echo "$m110r103";?>';
   document.formv1.m110r104.value = '<?php echo "$m110r104";?>';
   document.formv1.m110r105.value = '<?php echo "$m110r105";?>';
   document.formv1.m110r106.value = '<?php echo "$m110r106";?>';
   document.formv1.m110r107.value = '<?php echo "$m110r107";?>';
   document.formv1.m110r108.value = '<?php echo "$m110r108";?>';
   document.formv1.m110r109.value = '<?php echo "$m110r109";?>';
   document.formv1.m110r112.value = '<?php echo "$m110r112";?>';
   document.formv1.m110r113.value = '<?php echo "$m110r113";?>';
   document.formv1.m110r114.value = '<?php echo "$m110r114";?>';
   document.formv1.m110r115.value = '<?php echo "$m110r115";?>';
   document.formv1.m110r116.value = '<?php echo "$m110r116";?>';
   document.formv1.m110r117.value = '<?php echo "$m110r117";?>';
   document.formv1.m110r118.value = '<?php echo "$m110r118";?>';
   document.formv1.m110r119.value = '<?php echo "$m110r119";?>';
   document.formv1.m110r122.value = '<?php echo "$m110r122";?>';
   document.formv1.m110r123.value = '<?php echo "$m110r123";?>';
   document.formv1.m110r124.value = '<?php echo "$m110r124";?>';
   document.formv1.m110r125.value = '<?php echo "$m110r125";?>';
   document.formv1.m110r126.value = '<?php echo "$m110r126";?>';
   document.formv1.m110r127.value = '<?php echo "$m110r127";?>';
   document.formv1.m110r128.value = '<?php echo "$m110r128";?>';
   document.formv1.m110r129.value = '<?php echo "$m110r129";?>';
   document.formv1.m110r132.value = '<?php echo "$m110r132";?>';
   document.formv1.m110r133.value = '<?php echo "$m110r133";?>';
   document.formv1.m110r134.value = '<?php echo "$m110r134";?>';
   document.formv1.m110r135.value = '<?php echo "$m110r135";?>';
   document.formv1.m110r136.value = '<?php echo "$m110r136";?>';
   document.formv1.m110r137.value = '<?php echo "$m110r137";?>';
   document.formv1.m110r138.value = '<?php echo "$m110r138";?>';
   document.formv1.m110r139.value = '<?php echo "$m110r139";?>';
   document.formv1.m110r142.value = '<?php echo "$m110r142";?>';
   document.formv1.m110r143.value = '<?php echo "$m110r143";?>';
   document.formv1.m110r144.value = '<?php echo "$m110r144";?>';
   document.formv1.m110r145.value = '<?php echo "$m110r145";?>';
   document.formv1.m110r146.value = '<?php echo "$m110r146";?>';
   document.formv1.m110r147.value = '<?php echo "$m110r147";?>';
   document.formv1.m110r148.value = '<?php echo "$m110r148";?>';
   document.formv1.m110r149.value = '<?php echo "$m110r149";?>';
   document.formv1.m110r152.value = '<?php echo "$m110r152";?>';
   document.formv1.m110r153.value = '<?php echo "$m110r153";?>';
   document.formv1.m110r154.value = '<?php echo "$m110r154";?>';
   document.formv1.m110r155.value = '<?php echo "$m110r155";?>';
   document.formv1.m110r156.value = '<?php echo "$m110r156";?>';
   document.formv1.m110r157.value = '<?php echo "$m110r157";?>';
   document.formv1.m110r158.value = '<?php echo "$m110r158";?>';
   document.formv1.m110r159.value = '<?php echo "$m110r159";?>';
   document.formv1.m110r162.value = '<?php echo "$m110r162";?>';
   document.formv1.m110r163.value = '<?php echo "$m110r163";?>';
   document.formv1.m110r164.value = '<?php echo "$m110r164";?>';
   document.formv1.m110r165.value = '<?php echo "$m110r165";?>';
   document.formv1.m110r166.value = '<?php echo "$m110r166";?>';
   document.formv1.m110r167.value = '<?php echo "$m110r167";?>';
   document.formv1.m110r168.value = '<?php echo "$m110r168";?>';
   document.formv1.m110r169.value = '<?php echo "$m110r169";?>';
   document.formv1.m110r172.value = '<?php echo "$m110r172";?>';
   document.formv1.m110r173.value = '<?php echo "$m110r173";?>';
   document.formv1.m110r174.value = '<?php echo "$m110r174";?>';
   document.formv1.m110r175.value = '<?php echo "$m110r175";?>';
   document.formv1.m110r176.value = '<?php echo "$m110r176";?>';
   document.formv1.m110r177.value = '<?php echo "$m110r177";?>';
   document.formv1.m110r178.value = '<?php echo "$m110r178";?>';
   document.formv1.m110r179.value = '<?php echo "$m110r179";?>';
   document.formv1.m110r182.value = '<?php echo "$m110r182";?>';
   document.formv1.m110r183.value = '<?php echo "$m110r183";?>';
   document.formv1.m110r184.value = '<?php echo "$m110r184";?>';
   document.formv1.m110r185.value = '<?php echo "$m110r185";?>';
   document.formv1.m110r186.value = '<?php echo "$m110r186";?>';
   document.formv1.m110r187.value = '<?php echo "$m110r187";?>';
   document.formv1.m110r188.value = '<?php echo "$m110r188";?>';
   document.formv1.m110r189.value = '<?php echo "$m110r189";?>';
   document.formv1.m110r192.value = '<?php echo "$m110r192";?>';
   document.formv1.m110r193.value = '<?php echo "$m110r193";?>';
   document.formv1.m110r194.value = '<?php echo "$m110r194";?>';
   document.formv1.m110r195.value = '<?php echo "$m110r195";?>';
   document.formv1.m110r196.value = '<?php echo "$m110r196";?>';
   document.formv1.m110r197.value = '<?php echo "$m110r197";?>';
   document.formv1.m110r198.value = '<?php echo "$m110r198";?>';
   document.formv1.m110r199.value = '<?php echo "$m110r199";?>';
   document.formv1.m110r202.value = '<?php echo "$m110r202";?>';
   document.formv1.m110r203.value = '<?php echo "$m110r203";?>';
   document.formv1.m110r204.value = '<?php echo "$m110r204";?>';
   document.formv1.m110r205.value = '<?php echo "$m110r205";?>';
   document.formv1.m110r206.value = '<?php echo "$m110r206";?>';
   document.formv1.m110r207.value = '<?php echo "$m110r207";?>';
   document.formv1.m110r208.value = '<?php echo "$m110r208";?>';
   document.formv1.m110r209.value = '<?php echo "$m110r209";?>';
   document.formv1.m110r212.value = '<?php echo "$m110r212";?>';
   document.formv1.m110r213.value = '<?php echo "$m110r213";?>';
   document.formv1.m110r214.value = '<?php echo "$m110r214";?>';
   document.formv1.m110r215.value = '<?php echo "$m110r215";?>';
   document.formv1.m110r216.value = '<?php echo "$m110r216";?>';
   document.formv1.m110r217.value = '<?php echo "$m110r217";?>';
   document.formv1.m110r218.value = '<?php echo "$m110r218";?>';
   document.formv1.m110r219.value = '<?php echo "$m110r219";?>';
   document.formv1.m110r222.value = '<?php echo "$m110r222";?>';
// document.formv1.m110r223.value = '<?php echo "$m110r223";?>';
   document.formv1.m110r224.value = '<?php echo "$m110r224";?>';
// document.formv1.m110r225.value = '<?php echo "$m110r225";?>';
   document.formv1.m110r226.value = '<?php echo "$m110r226";?>';
// document.formv1.m110r227.value = '<?php echo "$m110r227";?>';
   document.formv1.m110r228.value = '<?php echo "$m110r228";?>';
// document.formv1.m110r229.value = '<?php echo "$m110r229";?>';
   document.formv1.m110r232.value = '<?php echo "$m110r232";?>';
// document.formv1.m110r233.value = '<?php echo "$m110r233";?>';
   document.formv1.m110r234.value = '<?php echo "$m110r234";?>';
// document.formv1.m110r235.value = '<?php echo "$m110r235";?>';
   document.formv1.m110r236.value = '<?php echo "$m110r236";?>';
// document.formv1.m110r237.value = '<?php echo "$m110r237";?>';
   document.formv1.m110r238.value = '<?php echo "$m110r238";?>';
// document.formv1.m110r239.value = '<?php echo "$m110r239";?>';
   document.formv1.m110r242.value = '<?php echo "$m110r242";?>';
   document.formv1.m110r243.value = '<?php echo "$m110r243";?>';
   document.formv1.m110r244.value = '<?php echo "$m110r244";?>';
   document.formv1.m110r245.value = '<?php echo "$m110r245";?>';
   document.formv1.m110r246.value = '<?php echo "$m110r246";?>';
   document.formv1.m110r247.value = '<?php echo "$m110r247";?>';
   document.formv1.m110r248.value = '<?php echo "$m110r248";?>';
   document.formv1.m110r249.value = '<?php echo "$m110r249";?>';
   document.formv1.m110r252.value = '<?php echo "$m110r252";?>';
   document.formv1.m110r253.value = '<?php echo "$m110r253";?>';
   document.formv1.m110r254.value = '<?php echo "$m110r254";?>';
   document.formv1.m110r255.value = '<?php echo "$m110r255";?>';
   document.formv1.m110r256.value = '<?php echo "$m110r256";?>';
   document.formv1.m110r257.value = '<?php echo "$m110r257";?>';
   document.formv1.m110r258.value = '<?php echo "$m110r258";?>';
   document.formv1.m110r259.value = '<?php echo "$m110r259";?>';
   document.formv1.m110r262.value = '<?php echo "$m110r262";?>';
   document.formv1.m110r263.value = '<?php echo "$m110r263";?>';
   document.formv1.m110r264.value = '<?php echo "$m110r264";?>';
   document.formv1.m110r265.value = '<?php echo "$m110r265";?>';
   document.formv1.m110r266.value = '<?php echo "$m110r266";?>';
   document.formv1.m110r267.value = '<?php echo "$m110r267";?>';
   document.formv1.m110r268.value = '<?php echo "$m110r268";?>';
   document.formv1.m110r269.value = '<?php echo "$m110r269";?>';
   document.formv1.m110r272.value = '<?php echo "$m110r272";?>';
   document.formv1.m110r273.value = '<?php echo "$m110r273";?>';
   document.formv1.m110r274.value = '<?php echo "$m110r274";?>';
   document.formv1.m110r275.value = '<?php echo "$m110r275";?>';
   document.formv1.m110r276.value = '<?php echo "$m110r276";?>';
   document.formv1.m110r277.value = '<?php echo "$m110r277";?>';
   document.formv1.m110r278.value = '<?php echo "$m110r278";?>';
   document.formv1.m110r279.value = '<?php echo "$m110r279";?>';
   document.formv1.m110r282.value = '<?php echo "$m110r282";?>';
   document.formv1.m110r283.value = '<?php echo "$m110r283";?>';
   document.formv1.m110r284.value = '<?php echo "$m110r284";?>';
   document.formv1.m110r285.value = '<?php echo "$m110r285";?>';
   document.formv1.m110r286.value = '<?php echo "$m110r286";?>';
   document.formv1.m110r287.value = '<?php echo "$m110r287";?>';
   document.formv1.m110r288.value = '<?php echo "$m110r288";?>';
   document.formv1.m110r289.value = '<?php echo "$m110r289";?>';
   document.formv1.m110r292.value = '<?php echo "$m110r292";?>';
   document.formv1.m110r293.value = '<?php echo "$m110r293";?>';
   document.formv1.m110r294.value = '<?php echo "$m110r294";?>';
   document.formv1.m110r295.value = '<?php echo "$m110r295";?>';
   document.formv1.m110r296.value = '<?php echo "$m110r296";?>';
   document.formv1.m110r297.value = '<?php echo "$m110r297";?>';
   document.formv1.m110r298.value = '<?php echo "$m110r298";?>';
   document.formv1.m110r299.value = '<?php echo "$m110r299";?>';
   document.formv1.m110r302.value = '<?php echo "$m110r302";?>';
   document.formv1.m110r303.value = '<?php echo "$m110r303";?>';
   document.formv1.m110r304.value = '<?php echo "$m110r304";?>';
   document.formv1.m110r305.value = '<?php echo "$m110r305";?>';
   document.formv1.m110r306.value = '<?php echo "$m110r306";?>';
   document.formv1.m110r307.value = '<?php echo "$m110r307";?>';
   document.formv1.m110r308.value = '<?php echo "$m110r308";?>';
   document.formv1.m110r309.value = '<?php echo "$m110r309";?>';
   document.formv1.m110r312.value = '<?php echo "$m110r312";?>';
   document.formv1.m110r313.value = '<?php echo "$m110r313";?>';
   document.formv1.m110r314.value = '<?php echo "$m110r314";?>';
   document.formv1.m110r315.value = '<?php echo "$m110r315";?>';
   document.formv1.m110r316.value = '<?php echo "$m110r316";?>';
   document.formv1.m110r317.value = '<?php echo "$m110r317";?>';
   document.formv1.m110r318.value = '<?php echo "$m110r318";?>';
   document.formv1.m110r319.value = '<?php echo "$m110r319";?>';
   document.formv1.m110r322.value = '<?php echo "$m110r322";?>';
   document.formv1.m110r323.value = '<?php echo "$m110r323";?>';
   document.formv1.m110r324.value = '<?php echo "$m110r324";?>';
   document.formv1.m110r325.value = '<?php echo "$m110r325";?>';
   document.formv1.m110r326.value = '<?php echo "$m110r326";?>';
   document.formv1.m110r327.value = '<?php echo "$m110r327";?>';
   document.formv1.m110r328.value = '<?php echo "$m110r328";?>';
   document.formv1.m110r329.value = '<?php echo "$m110r329";?>';
   document.formv1.m110r332.value = '<?php echo "$m110r332";?>';
// document.formv1.m110r333.value = '<?php echo "$m110r333";?>';
   document.formv1.m110r334.value = '<?php echo "$m110r334";?>';
// document.formv1.m110r335.value = '<?php echo "$m110r335";?>';
   document.formv1.m110r336.value = '<?php echo "$m110r336";?>';
// document.formv1.m110r337.value = '<?php echo "$m110r337";?>';
   document.formv1.m110r338.value = '<?php echo "$m110r338";?>';
// document.formv1.m110r339.value = '<?php echo "$m110r339";?>';
   document.formv1.m110r342.value = '<?php echo "$m110r342";?>';
// document.formv1.m110r343.value = '<?php echo "$m110r343";?>';
   document.formv1.m110r344.value = '<?php echo "$m110r344";?>';
// document.formv1.m110r345.value = '<?php echo "$m110r345";?>';
   document.formv1.m110r346.value = '<?php echo "$m110r346";?>';
// document.formv1.m110r347.value = '<?php echo "$m110r347";?>';
   document.formv1.m110r348.value = '<?php echo "$m110r348";?>';
// document.formv1.m110r349.value = '<?php echo "$m110r349";?>';
 //document.formv1.m110r992.value = '<?php echo "$m110r992";?>';
 //document.formv1.m110r993.value = '<?php echo "$m110r993";?>';
 //document.formv1.m110r994.value = '<?php echo "$m110r994";?>';
 //document.formv1.m110r995.value = '<?php echo "$m110r995";?>';
 //document.formv1.m110r996.value = '<?php echo "$m110r996";?>';
 //document.formv1.m110r997.value = '<?php echo "$m110r997";?>';
 //document.formv1.m110r998.value = '<?php echo "$m110r998";?>';
 //document.formv1.m110r999.value = '<?php echo "$m110r999";?>';
<?php                      } ?>
  }
<?php
//koniec uprava
  }
?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function CisCPAp2()
  {
   window.open('../dokumenty/statistika2016/cpa_ciselnik_pril2_v16.pdf',
'_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
  function CisCPAp1()
  {
   window.open('../dokumenty/statistika2016/cpa_ciselnik_pril1_v16.pdf',
'_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
  function MetodVypln()
  {
   window.open('<?php echo $jpg_cesta; ?>_metodika.pdf',
'_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
  function TlacVykaz()
  {
   window.open('../ucto/statistika_zav101.php?copern=11&strana=9999', '_blank');
  }
  function StatUdajeFirma()
  {
   window.open('../mzdy/trexima.php?cislo_oc=1&copern=1&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0',
'_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMzdy()
  {
   window.open('../ucto/statistika_zav101.php?copern=200&drupoh=1&page=1', '_self');
  }
  function NacitajZobratovky(modul)
  {
   window.open('../ucto/uobrat.php?modul=' + modul + '&copern=200&drupoh=1&page=1&typ=PDF&cstat=30201&vyb_ume=<?php echo "12.".$kli_vrok; ?>', '_self');
  }

//bud alebo checkbox v module 100101
  function klikm1590r1ano()
  {
   document.formv1.m1590r1b.checked = false;
  }
  function klikm1590r1nie()
  {
   document.formv1.m1590r1a.checked = false;
  }
//bud alebo checkbox v module 100102
  function klikm1590r2ano()
  {
   document.formv1.m1590r2b.checked = false;
  }
  function klikm1590r2nie()
  {
   document.formv1.m1590r2a.checked = false;
  }
</script>
</HEAD>
<BODY onload="ObnovUI();">
<?php
//uprav udaje
if ( $copern == 102 )
     {
?>
<div id="wrap-heading">
 <table id="heading">
 <tr>
  <td class="ilogin">EuroSecom</td>
  <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
 </tr>
 <tr>
  <td class="header">Roèný závodný výkaz vo ve¾kých podnikoch ZAV 1-01</td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/infocloud_blue_icon.png" onclick="CisCPAp2();" title="Èíselník CPA - príloha è.2" class="btn-form-tool">
    <img src="../obr/ikony/infocloud_blue_icon.png" onclick="CisCPAp1();" title="Èíselník CPA - príloha è.1" class="btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();" title="Metodické vysvetlivky k obsahu výkazu" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();" title="Zobrazi všetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="statistika_zav101.php?copern=103&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive";
$clas5="noactive"; $clas6="noactive"; $clas7="noactive"; $clas8="noactive";
$clas9="noactive"; $clas10="noactive"; $clas11="noactive"; $clas12="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
if ( $strana == 3 ) $clas3="active"; if ( $strana == 4 ) $clas4="active";
if ( $strana == 5 ) $clas5="active"; if ( $strana == 6 ) $clas6="active";
if ( $strana == 7 ) $clas7="active"; if ( $strana == 8 ) $clas8="active";
if ( $strana == 9 ) $clas9="active"; if ( $strana == 10 ) $clas10="active";
if ( $strana == 11 ) $clas11="active"; if ( $strana == 12 ) $clas12="active";
$source="statistika_zav101.php?";
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
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=11', '_self');" class="<?php echo $clas11; ?> toleft">11</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=12', '_self');" class="<?php echo $clas12; ?> toleft">12</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=12', '_blank');" class="<?php echo $clas12; ?> toright">12</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=11', '_blank');" class="<?php echo $clas11; ?> toright">11</a>
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
 <h6 class="toright">Tlaèi:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloži zmeny" class="btn-top-formsave">
</div>
<?php
$fir_ficox=$fir_fico; if ( $fir_ficox < 999999 ) { $fir_ficox="00".$fir_ficox; }
?>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str1.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 1.strana 237kB">

<span class="text-echo" style="top:380px; left:467px; font-size:18px; letter-spacing:24px;"><?php echo $fir_ficox; ?></span>
<!-- ORGANIZACIA -->
<span class="text-echo" style="top:923px; left:55px; line-height: 20px;"><?php echo "$fir_fnaz<br>$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc"; ?></span>
<span class="text-echo" style="top:940px; left:806px;"><?php echo $okres; ?></span>
<img src="../obr/ikony/pencil_blue_icon.png" onclick="StatUdajeFirma();" title="Nastavi kód okresu" class="btn-row-tool" style="top:937px; left:839px;">

<!-- Vyplnil -->
<span class="text-echo" style="top:1022px; left:55px;"><?php echo $fir_mzdt05; ?></span>
<span class="text-echo" style="width:499px; top:1038px; left:390px;"><?php echo $fir_mzdt04; ?></span>
<span class="text-echo" style="width:499px; top:1087px; left:55px;"><?php echo $fir_fem1; ?></span>
<input type="text" name="odoslane" id="odoslane" onkeyup="CiarkaNaBodku(this);" style="width:90px; top:1085px; left:390px;"/>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str2.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 2.strana 225kB">
<span class="text-echo" style="top:79px; left:480px; font-size:16px; letter-spacing:25px;"><?php echo $fir_ficox; ?></span>

<!-- modul 592 -->
<img src="../obr/ikony/download_blue_icon.png" title="Naèíta údaje z Obratovky" onclick="NacitajZobratovky(592);" style="top:157px; left:670px;" class="btn-row-tool">
<input type="text" name="m592r11" id="m592r11" style="width:91px; top:358px; left:98px;"/>
<input type="text" name="m592r12" id="m592r12" style="width:131px; top:358px; left:202px;"/>
<input type="text" name="m592r13" id="m592r13" style="width:112px; top:358px; left:345px;"/>
<input type="text" name="m592r14" id="m592r14" style="width:135px; top:358px; left:470px;"/>
<input type="text" name="m592r15" id="m592r15" style="width:135px; top:358px; left:617px;"/>
<input type="text" name="m592r16" id="m592r16" style="width:123px; top:358px; left:764px;"/>
<input type="text" name="m592r21" id="m592r21" style="width:91px; top:390px; left:98px;"/>
<input type="text" name="m592r22" id="m592r22" style="width:131px; top:390px; left:202px;"/>
<input type="text" name="m592r23" id="m592r23" style="width:112px; top:390px; left:345px;"/>
<input type="text" name="m592r24" id="m592r24" style="width:135px; top:390px; left:470px;"/>
<input type="text" name="m592r25" id="m592r25" style="width:135px; top:390px; left:617px;"/>
<input type="text" name="m592r26" id="m592r26" style="width:123px; top:390px; left:764px;"/>
<input type="text" name="m592r31" id="m592r31" style="width:91px; top:422px; left:98px;"/>
<input type="text" name="m592r32" id="m592r32" style="width:131px; top:422px; left:202px;"/>
<input type="text" name="m592r33" id="m592r33" style="width:112px; top:422px; left:345px;"/>
<input type="text" name="m592r34" id="m592r34" style="width:135px; top:422px; left:470px;"/>
<input type="text" name="m592r35" id="m592r35" style="width:135px; top:422px; left:617px;"/>
<input type="text" name="m592r36" id="m592r36" style="width:123px; top:422px; left:764px;"/>
<input type="text" name="m592r41" id="m592r41" style="width:91px; top:454px; left:98px;"/>
<input type="text" name="m592r42" id="m592r42" style="width:131px; top:454px; left:202px;"/>
<input type="text" name="m592r43" id="m592r43" style="width:112px; top:454px; left:345px;"/>
<input type="text" name="m592r44" id="m592r44" style="width:135px; top:454px; left:470px;"/>
<input type="text" name="m592r45" id="m592r45" style="width:135px; top:454px; left:617px;"/>
<input type="text" name="m592r46" id="m592r46" style="width:123px; top:454px; left:764px;"/>
<input type="text" name="m592r51" id="m592r51" style="width:91px; top:486px; left:98px;"/>
<input type="text" name="m592r52" id="m592r52" style="width:131px; top:486px; left:202px;"/>
<input type="text" name="m592r53" id="m592r53" style="width:112px; top:486px; left:345px;"/>
<input type="text" name="m592r54" id="m592r54" style="width:135px; top:486px; left:470px;"/>
<input type="text" name="m592r55" id="m592r55" style="width:135px; top:486px; left:617px;"/>
<input type="text" name="m592r56" id="m592r56" style="width:123px; top:486px; left:764px;"/>
<input type="text" name="m592r61" id="m592r61" style="width:91px; top:517px; left:98px;"/>
<input type="text" name="m592r62" id="m592r62" style="width:131px; top:517px; left:202px;"/>
<input type="text" name="m592r63" id="m592r63" style="width:112px; top:517px; left:345px;"/>
<input type="text" name="m592r64" id="m592r64" style="width:135px; top:517px; left:470px;"/>
<input type="text" name="m592r65" id="m592r65" style="width:135px; top:517px; left:617px;"/>
<input type="text" name="m592r66" id="m592r66" style="width:123px; top:517px; left:764px;"/>
<input type="text" name="m592r71" id="m592r71" style="width:91px; top:549px; left:98px;"/>
<input type="text" name="m592r72" id="m592r72" style="width:131px; top:549px; left:202px;"/>
<input type="text" name="m592r73" id="m592r73" style="width:112px; top:549px; left:345px;"/>
<input type="text" name="m592r74" id="m592r74" style="width:135px; top:549px; left:470px;"/>
<input type="text" name="m592r75" id="m592r75" style="width:135px; top:549px; left:617px;"/>
<input type="text" name="m592r76" id="m592r76" style="width:123px; top:549px; left:764px;"/>
<input type="text" name="m592r81" id="m592r81" style="width:91px; top:581px; left:98px;"/>
<input type="text" name="m592r82" id="m592r82" style="width:131px; top:581px; left:202px;"/>
<input type="text" name="m592r83" id="m592r83" style="width:112px; top:581px; left:345px;"/>
<input type="text" name="m592r84" id="m592r84" style="width:135px; top:581px; left:470px;"/>
<input type="text" name="m592r85" id="m592r85" style="width:135px; top:581px; left:617px;"/>
<input type="text" name="m592r86" id="m592r86" style="width:123px; top:581px; left:764px;"/>
<input type="text" name="m592r91" id="m592r91" style="width:91px; top:613px; left:98px;"/>
<input type="text" name="m592r92" id="m592r92" style="width:131px; top:613px; left:202px;"/>
<input type="text" name="m592r93" id="m592r93" style="width:112px; top:613px; left:345px;"/>
<input type="text" name="m592r94" id="m592r94" style="width:135px; top:613px; left:470px;"/>
<input type="text" name="m592r95" id="m592r95" style="width:135px; top:613px; left:617px;"/>
<input type="text" name="m592r96" id="m592r96" style="width:123px; top:613px; left:764px;"/>
<input type="text" name="m592r101" id="m592r101" style="width:91px; top:644px; left:98px;"/>
<input type="text" name="m592r102" id="m592r102" style="width:131px; top:644px; left:202px;"/>
<input type="text" name="m592r103" id="m592r103" style="width:112px; top:644px; left:345px;"/>
<input type="text" name="m592r104" id="m592r104" style="width:135px; top:644px; left:470px;"/>
<input type="text" name="m592r105" id="m592r105" style="width:135px; top:644px; left:617px;"/>
<input type="text" name="m592r106" id="m592r106" style="width:123px; top:644px; left:764px;"/>
<input type="text" name="m592r111" id="m592r111" style="width:91px; top:677px; left:98px;"/>
<input type="text" name="m592r112" id="m592r112" style="width:131px; top:677px; left:202px;"/>
<input type="text" name="m592r113" id="m592r113" style="width:112px; top:677px; left:345px;"/>
<input type="text" name="m592r114" id="m592r114" style="width:135px; top:677px; left:470px;"/>
<input type="text" name="m592r115" id="m592r115" style="width:135px; top:677px; left:617px;"/>
<input type="text" name="m592r116" id="m592r116" style="width:123px; top:677px; left:764px;"/>
<input type="text" name="m592r121" id="m592r121" style="width:91px; top:708px; left:98px;"/>
<input type="text" name="m592r122" id="m592r122" style="width:131px; top:708px; left:202px;"/>
<input type="text" name="m592r123" id="m592r123" style="width:112px; top:708px; left:345px;"/>
<input type="text" name="m592r124" id="m592r124" style="width:135px; top:708px; left:470px;"/>
<input type="text" name="m592r125" id="m592r125" style="width:135px; top:708px; left:617px;"/>
<input type="text" name="m592r126" id="m592r126" style="width:123px; top:708px; left:764px;"/>
<input type="text" name="m592r131" id="m592r131" style="width:91px; top:740px; left:98px;"/>
<input type="text" name="m592r132" id="m592r132" style="width:131px; top:740px; left:202px;"/>
<input type="text" name="m592r133" id="m592r133" style="width:112px; top:740px; left:345px;"/>
<input type="text" name="m592r134" id="m592r134" style="width:135px; top:740px; left:470px;"/>
<input type="text" name="m592r135" id="m592r135" style="width:135px; top:740px; left:617px;"/>
<input type="text" name="m592r136" id="m592r136" style="width:123px; top:740px; left:764px;"/>
<input type="text" name="m592r141" id="m592r141" style="width:91px; top:772px; left:98px;"/>
<input type="text" name="m592r142" id="m592r142" style="width:131px; top:772px; left:202px;"/>
<input type="text" name="m592r143" id="m592r143" style="width:112px; top:772px; left:345px;"/>
<input type="text" name="m592r144" id="m592r144" style="width:135px; top:772px; left:470px;"/>
<input type="text" name="m592r145" id="m592r145" style="width:135px; top:772px; left:617px;"/>
<input type="text" name="m592r146" id="m592r146" style="width:123px; top:772px; left:764px;"/>
<input type="text" name="m592r151" id="m592r151" style="width:91px; top:804px; left:98px;"/>
<input type="text" name="m592r152" id="m592r152" style="width:131px; top:804px; left:202px;"/>
<input type="text" name="m592r153" id="m592r153" style="width:112px; top:804px; left:345px;"/>
<input type="text" name="m592r154" id="m592r154" style="width:135px; top:804px; left:470px;"/>
<input type="text" name="m592r155" id="m592r155" style="width:135px; top:804px; left:617px;"/>
<input type="text" name="m592r156" id="m592r156" style="width:123px; top:804px; left:764px;"/>
<input type="text" name="m592r161" id="m592r161" style="width:91px; top:836px; left:98px;"/>
<input type="text" name="m592r162" id="m592r162" style="width:131px; top:836px; left:202px;"/>
<input type="text" name="m592r163" id="m592r163" style="width:112px; top:836px; left:345px;"/>
<input type="text" name="m592r164" id="m592r164" style="width:135px; top:836px; left:470px;"/>
<input type="text" name="m592r165" id="m592r165" style="width:135px; top:836px; left:617px;"/>
<input type="text" name="m592r166" id="m592r166" style="width:123px; top:836px; left:764px;"/>
<input type="text" name="m592r171" id="m592r171" style="width:91px; top:867px; left:98px;"/>
<input type="text" name="m592r172" id="m592r172" style="width:131px; top:867px; left:202px;"/>
<input type="text" name="m592r173" id="m592r173" style="width:112px; top:867px; left:345px;"/>
<input type="text" name="m592r174" id="m592r174" style="width:135px; top:867px; left:470px;"/>
<input type="text" name="m592r175" id="m592r175" style="width:135px; top:867px; left:617px;"/>
<input type="text" name="m592r176" id="m592r176" style="width:123px; top:867px; left:764px;"/>
<input type="text" name="m592r181" id="m592r181" style="width:91px; top:899px; left:98px;"/>
<input type="text" name="m592r182" id="m592r182" style="width:131px; top:899px; left:202px;"/>
<input type="text" name="m592r183" id="m592r183" style="width:112px; top:899px; left:345px;"/>
<input type="text" name="m592r184" id="m592r184" style="width:135px; top:899px; left:470px;"/>
<input type="text" name="m592r185" id="m592r185" style="width:135px; top:899px; left:617px;"/>
<input type="text" name="m592r186" id="m592r186" style="width:123px; top:899px; left:764px;"/>
<input type="text" name="m592r191" id="m592r191" style="width:91px; top:931px; left:98px;"/>
<input type="text" name="m592r192" id="m592r192" style="width:131px; top:931px; left:202px;"/>
<input type="text" name="m592r193" id="m592r193" style="width:112px; top:931px; left:345px;"/>
<input type="text" name="m592r194" id="m592r194" style="width:135px; top:931px; left:470px;"/>
<input type="text" name="m592r195" id="m592r195" style="width:135px; top:931px; left:617px;"/>
<input type="text" name="m592r196" id="m592r196" style="width:123px; top:931px; left:764px;"/>
<input type="text" name="m592r201" id="m592r201" style="width:91px; top:963px; left:98px;"/>
<input type="text" name="m592r202" id="m592r202" style="width:131px; top:963px; left:202px;"/>
<input type="text" name="m592r203" id="m592r203" style="width:112px; top:963px; left:345px;"/>
<input type="text" name="m592r204" id="m592r204" style="width:135px; top:963px; left:470px;"/>
<input type="text" name="m592r205" id="m592r205" style="width:135px; top:963px; left:617px;"/>
<input type="text" name="m592r206" id="m592r206" style="width:123px; top:963px; left:764px;"/>
<input type="text" name="m592r211" id="m592r211" style="width:91px; top:994px; left:98px;"/>
<input type="text" name="m592r212" id="m592r212" style="width:131px; top:994px; left:202px;"/>
<input type="text" name="m592r213" id="m592r213" style="width:112px; top:994px; left:345px;"/>
<input type="text" name="m592r214" id="m592r214" style="width:135px; top:994px; left:470px;"/>
<input type="text" name="m592r215" id="m592r215" style="width:135px; top:994px; left:617px;"/>
<input type="text" name="m592r216" id="m592r216" style="width:123px; top:994px; left:764px;"/>
<input type="text" name="m592r221" id="m592r221" style="width:91px; top:1026px; left:98px;"/>
<input type="text" name="m592r222" id="m592r222" style="width:131px; top:1026px; left:202px;"/>
<input type="text" name="m592r223" id="m592r223" style="width:112px; top:1026px; left:345px;"/>
<input type="text" name="m592r224" id="m592r224" style="width:135px; top:1026px; left:470px;"/>
<input type="text" name="m592r225" id="m592r225" style="width:135px; top:1026px; left:617px;"/>
<input type="text" name="m592r226" id="m592r226" style="width:123px; top:1026px; left:764px;"/>
<input type="text" name="m592r231" id="m592r231" style="width:91px; top:1058px; left:98px;"/>
<input type="text" name="m592r232" id="m592r232" style="width:131px; top:1058px; left:202px;"/>
<input type="text" name="m592r233" id="m592r233" style="width:112px; top:1058px; left:345px;"/>
<input type="text" name="m592r234" id="m592r234" style="width:135px; top:1058px; left:470px;"/>
<input type="text" name="m592r235" id="m592r235" style="width:135px; top:1058px; left:617px;"/>
<input type="text" name="m592r236" id="m592r236" style="width:123px; top:1058px; left:764px;"/>
<input type="text" name="m592r241" id="m592r241" style="width:91px; top:1090px; left:98px;"/>
<input type="text" name="m592r242" id="m592r242" style="width:131px; top:1090px; left:202px;"/>
<input type="text" name="m592r243" id="m592r243" style="width:112px; top:1090px; left:345px;"/>
<input type="text" name="m592r244" id="m592r244" style="width:135px; top:1090px; left:470px;"/>
<input type="text" name="m592r245" id="m592r245" style="width:135px; top:1090px; left:617px;"/>
<input type="text" name="m592r246" id="m592r246" style="width:123px; top:1090px; left:764px;"/>
<input type="text" name="m592r251" id="m592r251" style="width:91px; top:1122px; left:98px;"/>
<input type="text" name="m592r252" id="m592r252" style="width:131px; top:1122px; left:202px;"/>
<input type="text" name="m592r253" id="m592r253" style="width:112px; top:1122px; left:345px;"/>
<input type="text" name="m592r254" id="m592r254" style="width:135px; top:1122px; left:470px;"/>
<input type="text" name="m592r255" id="m592r255" style="width:135px; top:1122px; left:617px;"/>
<input type="text" name="m592r256" id="m592r256" style="width:123px; top:1122px; left:764px;"/>
<span class="text-echo" style="top:1160px; right:615px;"><?php echo $m592r992; ?></span>
<span class="text-echo" style="top:1160px; right:490px;"><?php echo $m592r993; ?></span>
<span class="text-echo" style="top:1160px; right:344px;"><?php echo $m592r994; ?></span>
<span class="text-echo" style="top:1160px; right:196px;"><?php echo $m592r995; ?></span>
<span class="text-echo" style="top:1160px; right:60px;"><?php echo $m592r996; ?></span>
<?php                                        } ?>


<?php if ( $strana == 3 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str3.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 3.strana 269kB">
<span class="text-echo" style="top:79px; left:480px; font-size:16px; letter-spacing:25px;"><?php echo $fir_ficox; ?></span>

<!-- modul 177 -->
<img src="../obr/ikony/download_blue_icon.png" title="Naèíta údaje z Obratovky" onclick="NacitajZobratovky(177);" style="top:103px; left:315px;" class="btn-row-tool">
<input type="text" name="m177r1" id="m177r1" style="width:100px; top:196px; left:735px;"/>
<input type="text" name="m177r2" id="m177r2" style="width:100px; top:227px; left:735px;"/>
<input type="text" name="m177r3" id="m177r3" style="width:100px; top:257px; left:735px;"/>
<input type="text" name="m177r4" id="m177r4" style="width:100px; top:282px; left:735px;"/>
<input type="text" name="m177r5" id="m177r5" style="width:100px; top:307px; left:735px;"/>
<input type="text" name="m177r6" id="m177r6" style="width:100px; top:331px; left:735px;"/>
<input type="text" name="m177r7" id="m177r7" style="width:100px; top:356px; left:735px;"/>
<input type="text" name="m177r8" id="m177r8" style="width:100px; top:381px; left:735px;"/>
<input type="text" name="m177r9" id="m177r9" style="width:100px; top:406px; left:735px;"/>
<input type="text" name="m177r10" id="m177r10" style="width:100px; top:431px; left:735px;"/>
<span class="text-echo" style="top:460px; right:110px;"><?php echo $m177r99; ?></span>

<!-- modul 178 -->
<img src="../obr/ikony/download_blue_icon.png" title="Naèíta údaje z Obratovky" onclick="NacitajZobratovky(178);" style="top:557px; left:531px;" class="btn-row-tool">
<input type="text" name="m178r1" id="m178r1" style="width:100px; top:652px; left:680px;"/>
<input type="text" name="m178r2" id="m178r2" style="width:100px; top:677px; left:680px;"/>
<input type="text" name="m178r3" id="m178r3" style="width:100px; top:717px; left:680px;"/>
<input type="text" name="m178r4" id="m178r4" style="width:100px; top:756px; left:680px;"/>
<input type="text" name="m178r5" id="m178r5" style="width:100px; top:782px; left:680px;"/>
<input type="text" name="m178r6" id="m178r6" style="width:100px; top:807px; left:680px;"/>
<input type="text" name="m178r7" id="m178r7" style="width:100px; top:832px; left:680px;"/>
<input type="text" name="m178r8" id="m178r8" style="width:100px; top:863px; left:680px;"/>
<input type="text" name="m178r9" id="m178r9" style="width:100px; top:894px; left:680px;"/>
<input type="text" name="m178r10" id="m178r10" style="width:100px; top:920px; left:680px;"/>
<input type="text" name="m178r11" id="m178r11" style="width:100px; top:945px; left:680px;"/>
<input type="text" name="m178r12" id="m178r12" style="width:100px; top:970px; left:680px;"/>
<input type="text" name="m178r13" id="m178r13" style="width:100px; top:995px; left:680px;"/>
<input type="text" name="m178r14" id="m178r14" style="width:100px; top:1020px; left:680px;"/>
<input type="text" name="m178r15" id="m178r15" style="width:100px; top:1046px; left:680px;"/>
<input type="text" name="m178r16" id="m178r16" style="width:100px; top:1071px; left:680px;"/>
<input type="text" name="m178r17" id="m178r17" style="width:100px; top:1096px; left:680px;"/>
<input type="text" name="m178r18" id="m178r18" style="width:100px; top:1121px; left:680px;"/>
<input type="text" name="m178r19" id="m178r19" style="width:100px; top:1147px; left:680px;"/>
<span class="text-echo" style="top:1176px; right:165px;"><?php echo $m178r99; ?></span>
<?php                                        } ?>


<?php if ( $strana == 4 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str4.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 4.strana 160kB">
<span class="text-echo" style="top:95px; left:480px; font-size:16px; letter-spacing:25px;"><?php echo $fir_ficox; ?></span>

<!-- modul 179 -->
<img src="../obr/ikony/download_blue_icon.png" title="Naèíta údaje z Obratovky" onclick="NacitajZobratovky(179);" style="top:155px; left:432px;" class="btn-row-tool">
<input type="text" name="m179r1" id="m179r1" style="width:100px; top:267px; left:675px;"/>
<input type="text" name="m179r2" id="m179r2" style="width:100px; top:304px; left:675px;"/>
<input type="text" name="m179r3" id="m179r3" style="width:100px; top:340px; left:675px;"/>
<input type="text" name="m179r4" id="m179r4" style="width:100px; top:375px; left:675px;"/>
<input type="text" name="m179r5" id="m179r5" style="width:100px; top:406px; left:675px;"/>
<input type="text" name="m179r6" id="m179r6" style="width:100px; top:438px; left:675px;"/>
<input type="text" name="m179r7" id="m179r7" style="width:100px; top:470px; left:675px;"/>
<input type="text" name="m179r8" id="m179r8" style="width:100px; top:502px; left:675px;"/>
<input type="text" name="m179r9" id="m179r9" style="width:100px; top:533px; left:675px;"/>
<span class="text-echo" style="top:570px; right:170px;"><?php echo $m179r99; ?></span>
<?php                                        } ?>


<?php if ( $strana == 5 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str5.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 5.strana 270kB">
<span class="text-echo" style="top:75px; left:485px; font-size:16px; letter-spacing:25px;"><?php echo $fir_ficox; ?></span>

<!-- modul 182 -->
<input type="text" name="m182r11" id="m182r11" style="width:101px; top:297px; left:91px;"/>
<input type="text" name="m182r12" id="m182r12" style="width:101px; top:297px; left:204px;"/>
<input type="text" name="m182r13" id="m182r13" style="width:102px; top:297px; left:317px;"/>
<input type="text" name="m182r14" id="m182r14" style="width:129px; top:297px; left:430px;"/>
<input type="text" name="m182r15" id="m182r15" style="width:101px; top:297px; left:572px;"/>
<input type="text" name="m182r16" id="m182r16" style="width:101px; top:297px; left:685px;"/>
<input type="text" name="m182r17" id="m182r17" style="width:101px; top:297px; left:798px;"/>
<input type="text" name="m182r21" id="m182r21" style="width:101px; top:324px; left:91px;"/>
<input type="text" name="m182r22" id="m182r22" style="width:101px; top:324px; left:204px;"/>
<input type="text" name="m182r23" id="m182r23" style="width:102px; top:324px; left:317px;"/>
<input type="text" name="m182r24" id="m182r24" style="width:129px; top:324px; left:430px;"/>
<input type="text" name="m182r25" id="m182r25" style="width:101px; top:324px; left:572px;"/>
<input type="text" name="m182r26" id="m182r26" style="width:101px; top:324px; left:685px;"/>
<input type="text" name="m182r27" id="m182r27" style="width:101px; top:324px; left:798px;"/>
<input type="text" name="m182r31" id="m182r31" style="width:101px; top:351px; left:91px;"/>
<input type="text" name="m182r32" id="m182r32" style="width:101px; top:351px; left:204px;"/>
<input type="text" name="m182r33" id="m182r33" style="width:102px; top:351px; left:317px;"/>
<input type="text" name="m182r34" id="m182r34" style="width:129px; top:351px; left:430px;"/>
<input type="text" name="m182r35" id="m182r35" style="width:101px; top:351px; left:572px;"/>
<input type="text" name="m182r36" id="m182r36" style="width:101px; top:351px; left:685px;"/>
<input type="text" name="m182r37" id="m182r37" style="width:101px; top:351px; left:798px;"/>
<input type="text" name="m182r41" id="m182r41" style="width:101px; top:377px; left:91px;"/>
<input type="text" name="m182r42" id="m182r42" style="width:101px; top:377px; left:204px;"/>
<input type="text" name="m182r43" id="m182r43" style="width:102px; top:377px; left:317px;"/>
<input type="text" name="m182r44" id="m182r44" style="width:129px; top:377px; left:430px;"/>
<input type="text" name="m182r45" id="m182r45" style="width:101px; top:377px; left:572px;"/>
<input type="text" name="m182r46" id="m182r46" style="width:101px; top:377px; left:685px;"/>
<input type="text" name="m182r47" id="m182r47" style="width:101px; top:377px; left:798px;"/>
<input type="text" name="m182r51" id="m182r51" style="width:101px; top:404px; left:91px;"/>
<input type="text" name="m182r52" id="m182r52" style="width:101px; top:404px; left:204px;"/>
<input type="text" name="m182r53" id="m182r53" style="width:102px; top:404px; left:317px;"/>
<input type="text" name="m182r54" id="m182r54" style="width:129px; top:404px; left:430px;"/>
<input type="text" name="m182r55" id="m182r55" style="width:101px; top:404px; left:572px;"/>
<input type="text" name="m182r56" id="m182r56" style="width:101px; top:404px; left:685px;"/>
<input type="text" name="m182r57" id="m182r57" style="width:101px; top:404px; left:798px;"/>
<input type="text" name="m182r61" id="m182r61" style="width:101px; top:430px; left:91px;"/>
<input type="text" name="m182r62" id="m182r62" style="width:101px; top:430px; left:204px;"/>
<input type="text" name="m182r63" id="m182r63" style="width:102px; top:430px; left:317px;"/>
<input type="text" name="m182r64" id="m182r64" style="width:129px; top:430px; left:430px;"/>
<input type="text" name="m182r65" id="m182r65" style="width:101px; top:430px; left:572px;"/>
<input type="text" name="m182r66" id="m182r66" style="width:101px; top:430px; left:685px;"/>
<input type="text" name="m182r67" id="m182r67" style="width:101px; top:430px; left:798px;"/>
<input type="text" name="m182r71" id="m182r71" style="width:101px; top:457px; left:91px;"/>
<input type="text" name="m182r72" id="m182r72" style="width:101px; top:457px; left:204px;"/>
<input type="text" name="m182r73" id="m182r73" style="width:102px; top:457px; left:317px;"/>
<input type="text" name="m182r74" id="m182r74" style="width:129px; top:457px; left:430px;"/>
<input type="text" name="m182r75" id="m182r75" style="width:101px; top:457px; left:572px;"/>
<input type="text" name="m182r76" id="m182r76" style="width:101px; top:457px; left:685px;"/>
<input type="text" name="m182r77" id="m182r77" style="width:101px; top:457px; left:798px;"/>
<input type="text" name="m182r81" id="m182r81" style="width:101px; top:484px; left:91px;"/>
<input type="text" name="m182r82" id="m182r82" style="width:101px; top:484px; left:204px;"/>
<input type="text" name="m182r83" id="m182r83" style="width:102px; top:484px; left:317px;"/>
<input type="text" name="m182r84" id="m182r84" style="width:129px; top:484px; left:430px;"/>
<input type="text" name="m182r85" id="m182r85" style="width:101px; top:484px; left:572px;"/>
<input type="text" name="m182r86" id="m182r86" style="width:101px; top:484px; left:685px;"/>
<input type="text" name="m182r87" id="m182r87" style="width:101px; top:484px; left:798px;"/>
<input type="text" name="m182r91" id="m182r91" style="width:101px; top:510px; left:91px;"/>
<input type="text" name="m182r92" id="m182r92" style="width:101px; top:510px; left:204px;"/>
<input type="text" name="m182r93" id="m182r93" style="width:102px; top:510px; left:317px;"/>
<input type="text" name="m182r94" id="m182r94" style="width:129px; top:510px; left:430px;"/>
<input type="text" name="m182r95" id="m182r95" style="width:101px; top:510px; left:572px;"/>
<input type="text" name="m182r96" id="m182r96" style="width:101px; top:510px; left:685px;"/>
<input type="text" name="m182r97" id="m182r97" style="width:101px; top:510px; left:798px;"/>
<input type="text" name="m182r101" id="m182r101" style="width:101px; top:537px; left:91px;"/>
<input type="text" name="m182r102" id="m182r102" style="width:101px; top:537px; left:204px;"/>
<input type="text" name="m182r103" id="m182r103" style="width:102px; top:537px; left:317px;"/>
<input type="text" name="m182r104" id="m182r104" style="width:129px; top:537px; left:430px;"/>
<input type="text" name="m182r105" id="m182r105" style="width:101px; top:537px; left:572px;"/>
<input type="text" name="m182r106" id="m182r106" style="width:101px; top:537px; left:685px;"/>
<input type="text" name="m182r107" id="m182r107" style="width:101px; top:537px; left:798px;"/>
<input type="text" name="m182r111" id="m182r111" style="width:101px; top:563px; left:91px;"/>
<input type="text" name="m182r112" id="m182r112" style="width:101px; top:563px; left:204px;"/>
<input type="text" name="m182r113" id="m182r113" style="width:102px; top:563px; left:317px;"/>
<input type="text" name="m182r114" id="m182r114" style="width:129px; top:563px; left:430px;"/>
<input type="text" name="m182r115" id="m182r115" style="width:101px; top:563px; left:572px;"/>
<input type="text" name="m182r116" id="m182r116" style="width:101px; top:563px; left:685px;"/>
<input type="text" name="m182r117" id="m182r117" style="width:101px; top:563px; left:798px;"/>
<input type="text" name="m182r121" id="m182r121" style="width:101px; top:590px; left:91px;"/>
<input type="text" name="m182r122" id="m182r122" style="width:101px; top:590px; left:204px;"/>
<input type="text" name="m182r123" id="m182r123" style="width:102px; top:590px; left:317px;"/>
<input type="text" name="m182r124" id="m182r124" style="width:129px; top:590px; left:430px;"/>
<input type="text" name="m182r125" id="m182r125" style="width:101px; top:590px; left:572px;"/>
<input type="text" name="m182r126" id="m182r126" style="width:101px; top:590px; left:685px;"/>
<input type="text" name="m182r127" id="m182r127" style="width:101px; top:590px; left:798px;"/>
<input type="text" name="m182r131" id="m182r131" style="width:101px; top:617px; left:91px;"/>
<input type="text" name="m182r132" id="m182r132" style="width:101px; top:617px; left:204px;"/>
<input type="text" name="m182r133" id="m182r133" style="width:102px; top:617px; left:317px;"/>
<input type="text" name="m182r134" id="m182r134" style="width:129px; top:617px; left:430px;"/>
<input type="text" name="m182r135" id="m182r135" style="width:101px; top:617px; left:572px;"/>
<input type="text" name="m182r136" id="m182r136" style="width:101px; top:617px; left:685px;"/>
<input type="text" name="m182r137" id="m182r137" style="width:101px; top:617px; left:798px;"/>
<input type="text" name="m182r141" id="m182r141" style="width:101px; top:643px; left:91px;"/>
<input type="text" name="m182r142" id="m182r142" style="width:101px; top:643px; left:204px;"/>
<input type="text" name="m182r143" id="m182r143" style="width:102px; top:643px; left:317px;"/>
<input type="text" name="m182r144" id="m182r144" style="width:129px; top:643px; left:430px;"/>
<input type="text" name="m182r145" id="m182r145" style="width:101px; top:643px; left:572px;"/>
<input type="text" name="m182r146" id="m182r146" style="width:101px; top:643px; left:685px;"/>
<input type="text" name="m182r147" id="m182r147" style="width:101px; top:643px; left:798px;"/>
<input type="text" name="m182r151" id="m182r151" style="width:101px; top:670px; left:91px;"/>
<input type="text" name="m182r152" id="m182r152" style="width:101px; top:670px; left:204px;"/>
<input type="text" name="m182r153" id="m182r153" style="width:102px; top:670px; left:317px;"/>
<input type="text" name="m182r154" id="m182r154" style="width:129px; top:670px; left:430px;"/>
<input type="text" name="m182r155" id="m182r155" style="width:101px; top:670px; left:572px;"/>
<input type="text" name="m182r156" id="m182r156" style="width:101px; top:670px; left:685px;"/>
<input type="text" name="m182r157" id="m182r157" style="width:101px; top:670px; left:798px;"/>
<input type="text" name="m182r161" id="m182r161" style="width:101px; top:696px; left:91px;"/>
<input type="text" name="m182r162" id="m182r162" style="width:101px; top:696px; left:204px;"/>
<input type="text" name="m182r163" id="m182r163" style="width:102px; top:696px; left:317px;"/>
<input type="text" name="m182r164" id="m182r164" style="width:129px; top:696px; left:430px;"/>
<input type="text" name="m182r165" id="m182r165" style="width:101px; top:696px; left:572px;"/>
<input type="text" name="m182r166" id="m182r166" style="width:101px; top:696px; left:685px;"/>
<input type="text" name="m182r167" id="m182r167" style="width:101px; top:696px; left:798px;"/>
<input type="text" name="m182r171" id="m182r171" style="width:101px; top:723px; left:91px;"/>
<input type="text" name="m182r172" id="m182r172" style="width:101px; top:723px; left:204px;"/>
<input type="text" name="m182r173" id="m182r173" style="width:102px; top:723px; left:317px;"/>
<input type="text" name="m182r174" id="m182r174" style="width:129px; top:723px; left:430px;"/>
<input type="text" name="m182r175" id="m182r175" style="width:101px; top:723px; left:572px;"/>
<input type="text" name="m182r176" id="m182r176" style="width:101px; top:723px; left:685px;"/>
<input type="text" name="m182r177" id="m182r177" style="width:101px; top:723px; left:798px;"/>
<input type="text" name="m182r181" id="m182r181" style="width:101px; top:749px; left:91px;"/>
<input type="text" name="m182r182" id="m182r182" style="width:101px; top:749px; left:204px;"/>
<input type="text" name="m182r183" id="m182r183" style="width:102px; top:749px; left:317px;"/>
<input type="text" name="m182r184" id="m182r184" style="width:129px; top:749px; left:430px;"/>
<input type="text" name="m182r185" id="m182r185" style="width:101px; top:749px; left:572px;"/>
<input type="text" name="m182r186" id="m182r186" style="width:101px; top:749px; left:685px;"/>
<input type="text" name="m182r187" id="m182r187" style="width:101px; top:749px; left:798px;"/>
<input type="text" name="m182r191" id="m182r191" style="width:101px; top:776px; left:91px;"/>
<input type="text" name="m182r192" id="m182r192" style="width:101px; top:776px; left:204px;"/>
<input type="text" name="m182r193" id="m182r193" style="width:102px; top:776px; left:317px;"/>
<input type="text" name="m182r194" id="m182r194" style="width:129px; top:776px; left:430px;"/>
<input type="text" name="m182r195" id="m182r195" style="width:101px; top:776px; left:572px;"/>
<input type="text" name="m182r196" id="m182r196" style="width:101px; top:776px; left:685px;"/>
<input type="text" name="m182r197" id="m182r197" style="width:101px; top:776px; left:798px;"/>
<input type="text" name="m182r201" id="m182r201" style="width:101px; top:802px; left:91px;"/>
<input type="text" name="m182r202" id="m182r202" style="width:101px; top:802px; left:204px;"/>
<input type="text" name="m182r203" id="m182r203" style="width:102px; top:802px; left:317px;"/>
<input type="text" name="m182r204" id="m182r204" style="width:129px; top:802px; left:430px;"/>
<input type="text" name="m182r205" id="m182r205" style="width:101px; top:802px; left:572px;"/>
<input type="text" name="m182r206" id="m182r206" style="width:101px; top:802px; left:685px;"/>
<input type="text" name="m182r207" id="m182r207" style="width:101px; top:802px; left:798px;"/>
<input type="text" name="m182r211" id="m182r211" style="width:101px; top:829px; left:91px;"/>
<input type="text" name="m182r212" id="m182r212" style="width:101px; top:829px; left:204px;"/>
<input type="text" name="m182r213" id="m182r213" style="width:102px; top:829px; left:317px;"/>
<input type="text" name="m182r214" id="m182r214" style="width:129px; top:829px; left:430px;"/>
<input type="text" name="m182r215" id="m182r215" style="width:101px; top:829px; left:572px;"/>
<input type="text" name="m182r216" id="m182r216" style="width:101px; top:829px; left:685px;"/>
<input type="text" name="m182r217" id="m182r217" style="width:101px; top:829px; left:798px;"/>
<input type="text" name="m182r221" id="m182r221" style="width:101px; top:855px; left:91px;"/>
<input type="text" name="m182r222" id="m182r222" style="width:101px; top:855px; left:204px;"/>
<input type="text" name="m182r223" id="m182r223" style="width:102px; top:855px; left:317px;"/>
<input type="text" name="m182r224" id="m182r224" style="width:129px; top:855px; left:430px;"/>
<input type="text" name="m182r225" id="m182r225" style="width:101px; top:855px; left:572px;"/>
<input type="text" name="m182r226" id="m182r226" style="width:101px; top:855px; left:685px;"/>
<input type="text" name="m182r227" id="m182r227" style="width:101px; top:855px; left:798px;"/>
<input type="text" name="m182r231" id="m182r231" style="width:101px; top:882px; left:91px;"/>
<input type="text" name="m182r232" id="m182r232" style="width:101px; top:882px; left:204px;"/>
<input type="text" name="m182r233" id="m182r233" style="width:102px; top:882px; left:317px;"/>
<input type="text" name="m182r234" id="m182r234" style="width:129px; top:882px; left:430px;"/>
<input type="text" name="m182r235" id="m182r235" style="width:101px; top:882px; left:572px;"/>
<input type="text" name="m182r236" id="m182r236" style="width:101px; top:882px; left:685px;"/>
<input type="text" name="m182r237" id="m182r237" style="width:101px; top:882px; left:798px;"/>
<input type="text" name="m182r241" id="m182r241" style="width:101px; top:909px; left:91px;"/>
<input type="text" name="m182r242" id="m182r242" style="width:101px; top:909px; left:204px;"/>
<input type="text" name="m182r243" id="m182r243" style="width:102px; top:909px; left:317px;"/>
<input type="text" name="m182r244" id="m182r244" style="width:129px; top:909px; left:430px;"/>
<input type="text" name="m182r245" id="m182r245" style="width:101px; top:909px; left:572px;"/>
<input type="text" name="m182r246" id="m182r246" style="width:101px; top:909px; left:685px;"/>
<input type="text" name="m182r247" id="m182r247" style="width:101px; top:909px; left:798px;"/>
<input type="text" name="m182r251" id="m182r251" style="width:101px; top:935px; left:91px;"/>
<input type="text" name="m182r252" id="m182r252" style="width:101px; top:935px; left:204px;"/>
<input type="text" name="m182r253" id="m182r253" style="width:102px; top:935px; left:317px;"/>
<input type="text" name="m182r254" id="m182r254" style="width:129px; top:935px; left:430px;"/>
<input type="text" name="m182r255" id="m182r255" style="width:101px; top:935px; left:572px;"/>
<input type="text" name="m182r256" id="m182r256" style="width:101px; top:935px; left:685px;"/>
<input type="text" name="m182r257" id="m182r257" style="width:101px; top:935px; left:798px;"/>
<input type="text" name="m182r261" id="m182r261" style="width:101px; top:962px; left:91px;"/>
<input type="text" name="m182r262" id="m182r262" style="width:101px; top:962px; left:204px;"/>
<input type="text" name="m182r263" id="m182r263" style="width:102px; top:962px; left:317px;"/>
<input type="text" name="m182r264" id="m182r264" style="width:129px; top:962px; left:430px;"/>
<input type="text" name="m182r265" id="m182r265" style="width:101px; top:962px; left:572px;"/>
<input type="text" name="m182r266" id="m182r266" style="width:101px; top:962px; left:685px;"/>
<input type="text" name="m182r267" id="m182r267" style="width:101px; top:962px; left:798px;"/>
<input type="text" name="m182r271" id="m182r271" style="width:101px; top:988px; left:91px;"/>
<input type="text" name="m182r272" id="m182r272" style="width:101px; top:988px; left:204px;"/>
<input type="text" name="m182r273" id="m182r273" style="width:102px; top:988px; left:317px;"/>
<input type="text" name="m182r274" id="m182r274" style="width:129px; top:988px; left:430px;"/>
<input type="text" name="m182r275" id="m182r275" style="width:101px; top:988px; left:572px;"/>
<input type="text" name="m182r276" id="m182r276" style="width:101px; top:988px; left:685px;"/>
<input type="text" name="m182r277" id="m182r277" style="width:101px; top:988px; left:798px;"/>
<input type="text" name="m182r281" id="m182r281" style="width:101px; top:1015px; left:91px;"/>
<input type="text" name="m182r282" id="m182r282" style="width:101px; top:1015px; left:204px;"/>
<input type="text" name="m182r283" id="m182r283" style="width:102px; top:1015px; left:317px;"/>
<input type="text" name="m182r284" id="m182r284" style="width:129px; top:1015px; left:430px;"/>
<input type="text" name="m182r285" id="m182r285" style="width:101px; top:1015px; left:572px;"/>
<input type="text" name="m182r286" id="m182r286" style="width:101px; top:1015px; left:685px;"/>
<input type="text" name="m182r287" id="m182r287" style="width:101px; top:1015px; left:798px;"/>
<input type="text" name="m182r291" id="m182r291" style="width:101px; top:1041px; left:91px;"/>
<input type="text" name="m182r292" id="m182r292" style="width:101px; top:1041px; left:204px;"/>
<input type="text" name="m182r293" id="m182r293" style="width:102px; top:1041px; left:317px;"/>
<input type="text" name="m182r294" id="m182r294" style="width:129px; top:1041px; left:430px;"/>
<input type="text" name="m182r295" id="m182r295" style="width:101px; top:1041px; left:572px;"/>
<input type="text" name="m182r296" id="m182r296" style="width:101px; top:1041px; left:685px;"/>
<input type="text" name="m182r297" id="m182r297" style="width:101px; top:1041px; left:798px;"/>
<input type="text" name="m182r301" id="m182r301" style="width:101px; top:1068px; left:91px;"/>
<input type="text" name="m182r302" id="m182r302" style="width:101px; top:1068px; left:204px;"/>
<input type="text" name="m182r303" id="m182r303" style="width:102px; top:1068px; left:317px;"/>
<input type="text" name="m182r304" id="m182r304" style="width:129px; top:1068px; left:430px;"/>
<input type="text" name="m182r305" id="m182r305" style="width:101px; top:1068px; left:572px;"/>
<input type="text" name="m182r306" id="m182r306" style="width:101px; top:1068px; left:685px;"/>
<input type="text" name="m182r307" id="m182r307" style="width:101px; top:1068px; left:798px;"/>
<input type="text" name="m182r311" id="m182r311" style="width:101px; top:1094px; left:91px;"/>
<input type="text" name="m182r312" id="m182r312" style="width:101px; top:1094px; left:204px;"/>
<input type="text" name="m182r313" id="m182r313" style="width:102px; top:1094px; left:317px;"/>
<input type="text" name="m182r314" id="m182r314" style="width:129px; top:1094px; left:430px;"/>
<input type="text" name="m182r315" id="m182r315" style="width:101px; top:1094px; left:572px;"/>
<input type="text" name="m182r316" id="m182r316" style="width:101px; top:1094px; left:685px;"/>
<input type="text" name="m182r317" id="m182r317" style="width:101px; top:1094px; left:798px;"/>
<input type="text" name="m182r321" id="m182r321" style="width:101px; top:1121px; left:91px;"/>
<input type="text" name="m182r322" id="m182r322" style="width:101px; top:1121px; left:204px;"/>
<input type="text" name="m182r323" id="m182r323" style="width:102px; top:1121px; left:317px;"/>
<input type="text" name="m182r324" id="m182r324" style="width:129px; top:1121px; left:430px;"/>
<input type="text" name="m182r325" id="m182r325" style="width:101px; top:1121px; left:572px;"/>
<input type="text" name="m182r326" id="m182r326" style="width:101px; top:1121px; left:685px;"/>
<input type="text" name="m182r327" id="m182r327" style="width:101px; top:1121px; left:798px;"/>
<input type="text" name="m182r331" id="m182r331" style="width:101px; top:1148px; left:91px;"/>
<input type="text" name="m182r332" id="m182r332" style="width:101px; top:1148px; left:204px;"/>
<input type="text" name="m182r333" id="m182r333" style="width:102px; top:1148px; left:317px;"/>
<input type="text" name="m182r334" id="m182r334" style="width:129px; top:1148px; left:430px;"/>
<input type="text" name="m182r335" id="m182r335" style="width:101px; top:1148px; left:572px;"/>
<input type="text" name="m182r336" id="m182r336" style="width:101px; top:1148px; left:685px;"/>
<input type="text" name="m182r337" id="m182r337" style="width:101px; top:1148px; left:798px;"/>
<span class="text-echo" style="top:1178px; right:642px;"><?php echo $m182r992; ?></span>
<span class="text-echo" style="top:1178px; right:529px;"><?php echo $m182r993; ?></span>
<span class="text-echo" style="top:1178px; right:387px;"><?php echo $m182r994; ?></span>
<span class="text-echo" style="top:1178px; right:274px;"><?php echo $m182r995; ?></span>
<span class="text-echo" style="top:1178px; right:160px;"><?php echo $m182r996; ?></span>
<span class="text-echo" style="top:1178px; right:48px;"><?php echo $m182r997; ?></span>
<?php                                        } ?>


<?php if ( $strana == 6 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str6.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 6.strana 237kB">
<span class="text-echo" style="top:95px; left:480px; font-size:16px; letter-spacing:25px;"><?php echo $fir_ficox; ?></span>

<!-- modul 183 -->
<input type="text" name="m183r11" id="m183r11" style="width:138px; top:319px; left:91px;"/>
<input type="text" name="m183r12" id="m183r12" style="width:138px; top:319px; left:240px;"/>
<input type="text" name="m183r13" id="m183r13" style="width:138px; top:319px; left:389px;"/>
<input type="text" name="m183r14" id="m183r14" style="width:349px; top:319px; left:539px;"/>
<input type="text" name="m183r21" id="m183r21" style="width:138px; top:347px; left:91px;"/>
<input type="text" name="m183r22" id="m183r22" style="width:138px; top:347px; left:240px;"/>
<input type="text" name="m183r23" id="m183r23" style="width:138px; top:347px; left:389px;"/>
<input type="text" name="m183r24" id="m183r24" style="width:349px; top:347px; left:539px;"/>
<input type="text" name="m183r31" id="m183r31" style="width:138px; top:374px; left:91px;"/>
<input type="text" name="m183r32" id="m183r32" style="width:138px; top:374px; left:240px;"/>
<input type="text" name="m183r33" id="m183r33" style="width:138px; top:374px; left:389px;"/>
<input type="text" name="m183r34" id="m183r34" style="width:349px; top:374px; left:539px;"/>
<input type="text" name="m183r41" id="m183r41" style="width:138px; top:401px; left:91px;"/>
<input type="text" name="m183r42" id="m183r42" style="width:138px; top:401px; left:240px;"/>
<input type="text" name="m183r43" id="m183r43" style="width:138px; top:401px; left:389px;"/>
<input type="text" name="m183r44" id="m183r44" style="width:349px; top:401px; left:539px;"/>
<input type="text" name="m183r51" id="m183r51" style="width:138px; top:429px; left:91px;"/>
<input type="text" name="m183r52" id="m183r52" style="width:138px; top:429px; left:240px;"/>
<input type="text" name="m183r53" id="m183r53" style="width:138px; top:429px; left:389px;"/>
<input type="text" name="m183r54" id="m183r54" style="width:349px; top:429px; left:539px;"/>
<input type="text" name="m183r61" id="m183r61" style="width:138px; top:456px; left:91px;"/>
<input type="text" name="m183r62" id="m183r62" style="width:138px; top:456px; left:240px;"/>
<input type="text" name="m183r63" id="m183r63" style="width:138px; top:456px; left:389px;"/>
<input type="text" name="m183r64" id="m183r64" style="width:349px; top:456px; left:539px;"/>
<input type="text" name="m183r71" id="m183r71" style="width:138px; top:483px; left:91px;"/>
<input type="text" name="m183r72" id="m183r72" style="width:138px; top:483px; left:240px;"/>
<input type="text" name="m183r73" id="m183r73" style="width:138px; top:483px; left:389px;"/>
<input type="text" name="m183r74" id="m183r74" style="width:349px; top:483px; left:539px;"/>
<input type="text" name="m183r81" id="m183r81" style="width:138px; top:511px; left:91px;"/>
<input type="text" name="m183r82" id="m183r82" style="width:138px; top:511px; left:240px;"/>
<input type="text" name="m183r83" id="m183r83" style="width:138px; top:511px; left:389px;"/>
<input type="text" name="m183r84" id="m183r84" style="width:349px; top:511px; left:539px;"/>
<input type="text" name="m183r91" id="m183r91" style="width:138px; top:539px; left:91px;"/>
<input type="text" name="m183r92" id="m183r92" style="width:138px; top:539px; left:240px;"/>
<input type="text" name="m183r93" id="m183r93" style="width:138px; top:539px; left:389px;"/>
<input type="text" name="m183r94" id="m183r94" style="width:349px; top:539px; left:539px;"/>
<input type="text" name="m183r101" id="m183r101" style="width:138px; top:566px; left:91px;"/>
<input type="text" name="m183r102" id="m183r102" style="width:138px; top:566px; left:240px;"/>
<input type="text" name="m183r103" id="m183r103" style="width:138px; top:566px; left:389px;"/>
<input type="text" name="m183r104" id="m183r104" style="width:349px; top:566px; left:539px;"/>
<input type="text" name="m183r111" id="m183r111" style="width:138px; top:593px; left:91px;"/>
<input type="text" name="m183r112" id="m183r112" style="width:138px; top:593px; left:240px;"/>
<input type="text" name="m183r113" id="m183r113" style="width:138px; top:593px; left:389px;"/>
<input type="text" name="m183r114" id="m183r114" style="width:349px; top:593px; left:539px;"/>
<input type="text" name="m183r121" id="m183r121" style="width:138px; top:621px; left:91px;"/>
<input type="text" name="m183r122" id="m183r122" style="width:138px; top:621px; left:240px;"/>
<input type="text" name="m183r123" id="m183r123" style="width:138px; top:621px; left:389px;"/>
<input type="text" name="m183r124" id="m183r124" style="width:349px; top:621px; left:539px;"/>
<input type="text" name="m183r131" id="m183r131" style="width:138px; top:648px; left:91px;"/>
<input type="text" name="m183r132" id="m183r132" style="width:138px; top:648px; left:240px;"/>
<input type="text" name="m183r133" id="m183r133" style="width:138px; top:648px; left:389px;"/>
<input type="text" name="m183r134" id="m183r134" style="width:349px; top:648px; left:539px;"/>
<input type="text" name="m183r141" id="m183r141" style="width:138px; top:676px; left:91px;"/>
<input type="text" name="m183r142" id="m183r142" style="width:138px; top:676px; left:240px;"/>
<input type="text" name="m183r143" id="m183r143" style="width:138px; top:676px; left:389px;"/>
<input type="text" name="m183r144" id="m183r144" style="width:349px; top:676px; left:539px;"/>
<input type="text" name="m183r151" id="m183r151" style="width:138px; top:703px; left:91px;"/>
<input type="text" name="m183r152" id="m183r152" style="width:138px; top:703px; left:240px;"/>
<input type="text" name="m183r153" id="m183r153" style="width:138px; top:703px; left:389px;"/>
<input type="text" name="m183r154" id="m183r154" style="width:349px; top:703px; left:539px;"/>
<input type="text" name="m183r161" id="m183r161" style="width:138px; top:730px; left:91px;"/>
<input type="text" name="m183r162" id="m183r162" style="width:138px; top:730px; left:240px;"/>
<input type="text" name="m183r163" id="m183r163" style="width:138px; top:730px; left:389px;"/>
<input type="text" name="m183r164" id="m183r164" style="width:349px; top:730px; left:539px;"/>
<input type="text" name="m183r171" id="m183r171" style="width:138px; top:758px; left:91px;"/>
<input type="text" name="m183r172" id="m183r172" style="width:138px; top:758px; left:240px;"/>
<input type="text" name="m183r173" id="m183r173" style="width:138px; top:758px; left:389px;"/>
<input type="text" name="m183r174" id="m183r174" style="width:349px; top:758px; left:539px;"/>
<input type="text" name="m183r181" id="m183r181" style="width:138px; top:785px; left:91px;"/>
<input type="text" name="m183r182" id="m183r182" style="width:138px; top:785px; left:240px;"/>
<input type="text" name="m183r183" id="m183r183" style="width:138px; top:785px; left:389px;"/>
<input type="text" name="m183r184" id="m183r184" style="width:349px; top:785px; left:539px;"/>
<input type="text" name="m183r191" id="m183r191" style="width:138px; top:813px; left:91px;"/>
<input type="text" name="m183r192" id="m183r192" style="width:138px; top:813px; left:240px;"/>
<input type="text" name="m183r193" id="m183r193" style="width:138px; top:813px; left:389px;"/>
<input type="text" name="m183r194" id="m183r194" style="width:349px; top:813px; left:539px;"/>
<input type="text" name="m183r201" id="m183r201" style="width:138px; top:840px; left:91px;"/>
<input type="text" name="m183r202" id="m183r202" style="width:138px; top:840px; left:240px;"/>
<input type="text" name="m183r203" id="m183r203" style="width:138px; top:840px; left:389px;"/>
<input type="text" name="m183r204" id="m183r204" style="width:349px; top:840px; left:539px;"/>
<input type="text" name="m183r211" id="m183r211" style="width:138px; top:867px; left:91px;"/>
<input type="text" name="m183r212" id="m183r212" style="width:138px; top:867px; left:240px;"/>
<input type="text" name="m183r213" id="m183r213" style="width:138px; top:867px; left:389px;"/>
<input type="text" name="m183r214" id="m183r214" style="width:349px; top:867px; left:539px;"/>
<input type="text" name="m183r221" id="m183r221" style="width:138px; top:895px; left:91px;"/>
<input type="text" name="m183r222" id="m183r222" style="width:138px; top:895px; left:240px;"/>
<input type="text" name="m183r223" id="m183r223" style="width:138px; top:895px; left:389px;"/>
<input type="text" name="m183r224" id="m183r224" style="width:349px; top:895px; left:539px;"/>
<input type="text" name="m183r231" id="m183r231" style="width:138px; top:922px; left:91px;"/>
<input type="text" name="m183r232" id="m183r232" style="width:138px; top:922px; left:240px;"/>
<input type="text" name="m183r233" id="m183r233" style="width:138px; top:922px; left:389px;"/>
<input type="text" name="m183r234" id="m183r234" style="width:349px; top:922px; left:539px;"/>
<input type="text" name="m183r241" id="m183r241" style="width:138px; top:950px; left:91px;"/>
<input type="text" name="m183r242" id="m183r242" style="width:138px; top:950px; left:240px;"/>
<input type="text" name="m183r243" id="m183r243" style="width:138px; top:950px; left:389px;"/>
<input type="text" name="m183r244" id="m183r244" style="width:349px; top:950px; left:539px;"/>
<input type="text" name="m183r251" id="m183r251" style="width:138px; top:977px; left:91px;"/>
<input type="text" name="m183r252" id="m183r252" style="width:138px; top:977px; left:240px;"/>
<input type="text" name="m183r253" id="m183r253" style="width:138px; top:977px; left:389px;"/>
<input type="text" name="m183r254" id="m183r254" style="width:349px; top:977px; left:539px;"/>
<input type="text" name="m183r261" id="m183r261" style="width:138px; top:1005px; left:91px;"/>
<input type="text" name="m183r262" id="m183r262" style="width:138px; top:1005px; left:240px;"/>
<input type="text" name="m183r263" id="m183r263" style="width:138px; top:1005px; left:389px;"/>
<input type="text" name="m183r264" id="m183r264" style="width:349px; top:1005px; left:539px;"/>
<input type="text" name="m183r271" id="m183r271" style="width:138px; top:1032px; left:91px;"/>
<input type="text" name="m183r272" id="m183r272" style="width:138px; top:1032px; left:240px;"/>
<input type="text" name="m183r273" id="m183r273" style="width:138px; top:1032px; left:389px;"/>
<input type="text" name="m183r274" id="m183r274" style="width:349px; top:1032px; left:539px;"/>
<input type="text" name="m183r281" id="m183r281" style="width:138px; top:1059px; left:91px;"/>
<input type="text" name="m183r282" id="m183r282" style="width:138px; top:1059px; left:240px;"/>
<input type="text" name="m183r283" id="m183r283" style="width:138px; top:1059px; left:389px;"/>
<input type="text" name="m183r284" id="m183r284" style="width:349px; top:1059px; left:539px;"/>
<input type="text" name="m183r291" id="m183r291" style="width:138px; top:1087px; left:91px;"/>
<input type="text" name="m183r292" id="m183r292" style="width:138px; top:1087px; left:240px;"/>
<input type="text" name="m183r293" id="m183r293" style="width:138px; top:1087px; left:389px;"/>
<input type="text" name="m183r294" id="m183r294" style="width:349px; top:1087px; left:539px;"/>
<input type="text" name="m183r301" id="m183r301" style="width:138px; top:1114px; left:91px;"/>
<input type="text" name="m183r302" id="m183r302" style="width:138px; top:1114px; left:240px;"/>
<input type="text" name="m183r303" id="m183r303" style="width:138px; top:1114px; left:389px;"/>
<input type="text" name="m183r304" id="m183r304" style="width:349px; top:1114px; left:539px;"/>
<span class="text-echo" style="top:1146px; right:572px;"><?php echo $m183r992; ?></span>
<span class="text-echo" style="top:1146px; right:422px;"><?php echo $m183r993; ?></span>
<span class="text-echo" style="top:1146px; right:61px;"><?php echo $m183r994; ?></span>
<?php                                        } ?>


<?php if ( $strana == 7 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str7.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 7.strana 267kB">
<span class="text-echo" style="top:97px; left:480px; font-size:16px; letter-spacing:25px;"><?php echo $fir_ficox; ?></span>

<!-- modul 184 -->
<input type="text" name="m184r11" id="m184r11" style="width:92px; top:299px; left:98px;"/>
<input type="text" name="m184r12" id="m184r12" style="width:99px; top:299px; left:201px;"/>
<input type="text" name="m184r13" id="m184r13" style="width:102px; top:299px; left:311px;"/>
<input type="text" name="m184r14" id="m184r14" style="width:227px; top:299px; left:424px;"/>
<input type="text" name="m184r15" id="m184r15" style="width:113px; top:299px; left:662px;"/>
<input type="text" name="m184r16" id="m184r16" style="width:102px; top:299px; left:786px;"/>
<input type="text" name="m184r21" id="m184r21" style="width:92px; top:325px; left:98px;"/>
<input type="text" name="m184r22" id="m184r22" style="width:99px; top:325px; left:201px;"/>
<input type="text" name="m184r23" id="m184r23" style="width:102px; top:325px; left:311px;"/>
<input type="text" name="m184r24" id="m184r24" style="width:227px; top:325px; left:424px;"/>
<input type="text" name="m184r25" id="m184r25" style="width:113px; top:325px; left:662px;"/>
<input type="text" name="m184r26" id="m184r26" style="width:102px; top:325px; left:786px;"/>
<input type="text" name="m184r31" id="m184r31" style="width:92px; top:352px; left:98px;"/>
<input type="text" name="m184r32" id="m184r32" style="width:99px; top:352px; left:201px;"/>
<input type="text" name="m184r33" id="m184r33" style="width:102px; top:352px; left:311px;"/>
<input type="text" name="m184r34" id="m184r34" style="width:227px; top:352px; left:424px;"/>
<input type="text" name="m184r35" id="m184r35" style="width:113px; top:352px; left:662px;"/>
<input type="text" name="m184r36" id="m184r36" style="width:102px; top:352px; left:786px;"/>
<input type="text" name="m184r41" id="m184r41" style="width:92px; top:377px; left:98px;"/>
<input type="text" name="m184r42" id="m184r42" style="width:99px; top:377px; left:201px;"/>
<input type="text" name="m184r43" id="m184r43" style="width:102px; top:377px; left:311px;"/>
<input type="text" name="m184r44" id="m184r44" style="width:227px; top:377px; left:424px;"/>
<input type="text" name="m184r45" id="m184r45" style="width:113px; top:377px; left:662px;"/>
<input type="text" name="m184r46" id="m184r46" style="width:102px; top:377px; left:786px;"/>
<input type="text" name="m184r51" id="m184r51" style="width:92px; top:404px; left:98px;"/>
<input type="text" name="m184r52" id="m184r52" style="width:99px; top:404px; left:201px;"/>
<input type="text" name="m184r53" id="m184r53" style="width:102px; top:404px; left:311px;"/>
<input type="text" name="m184r54" id="m184r54" style="width:227px; top:404px; left:424px;"/>
<input type="text" name="m184r55" id="m184r55" style="width:113px; top:404px; left:662px;"/>
<input type="text" name="m184r56" id="m184r56" style="width:102px; top:404px; left:786px;"/>
<input type="text" name="m184r61" id="m184r61" style="width:92px; top:430px; left:98px;"/>
<input type="text" name="m184r62" id="m184r62" style="width:99px; top:430px; left:201px;"/>
<input type="text" name="m184r63" id="m184r63" style="width:102px; top:430px; left:311px;"/>
<input type="text" name="m184r64" id="m184r64" style="width:227px; top:430px; left:424px;"/>
<input type="text" name="m184r65" id="m184r65" style="width:113px; top:430px; left:662px;"/>
<input type="text" name="m184r66" id="m184r66" style="width:102px; top:430px; left:786px;"/>
<input type="text" name="m184r71" id="m184r71" style="width:92px; top:456px; left:98px;"/>
<input type="text" name="m184r72" id="m184r72" style="width:99px; top:456px; left:201px;"/>
<input type="text" name="m184r73" id="m184r73" style="width:102px; top:456px; left:311px;"/>
<input type="text" name="m184r74" id="m184r74" style="width:227px; top:456px; left:424px;"/>
<input type="text" name="m184r75" id="m184r75" style="width:113px; top:456px; left:662px;"/>
<input type="text" name="m184r76" id="m184r76" style="width:102px; top:456px; left:786px;"/>
<input type="text" name="m184r81" id="m184r81" style="width:92px; top:482px; left:98px;"/>
<input type="text" name="m184r82" id="m184r82" style="width:99px; top:482px; left:201px;"/>
<input type="text" name="m184r83" id="m184r83" style="width:102px; top:482px; left:311px;"/>
<input type="text" name="m184r84" id="m184r84" style="width:227px; top:482px; left:424px;"/>
<input type="text" name="m184r85" id="m184r85" style="width:113px; top:482px; left:662px;"/>
<input type="text" name="m184r86" id="m184r86" style="width:102px; top:482px; left:786px;"/>
<input type="text" name="m184r91" id="m184r91" style="width:92px; top:508px; left:98px;"/>
<input type="text" name="m184r92" id="m184r92" style="width:99px; top:508px; left:201px;"/>
<input type="text" name="m184r93" id="m184r93" style="width:102px; top:508px; left:311px;"/>
<input type="text" name="m184r94" id="m184r94" style="width:227px; top:508px; left:424px;"/>
<input type="text" name="m184r95" id="m184r95" style="width:113px; top:508px; left:662px;"/>
<input type="text" name="m184r96" id="m184r96" style="width:102px; top:508px; left:786px;"/>
<input type="text" name="m184r101" id="m184r101" style="width:92px; top:534px; left:98px;"/>
<input type="text" name="m184r102" id="m184r102" style="width:99px; top:534px; left:201px;"/>
<input type="text" name="m184r103" id="m184r103" style="width:102px; top:534px; left:311px;"/>
<input type="text" name="m184r104" id="m184r104" style="width:227px; top:534px; left:424px;"/>
<input type="text" name="m184r105" id="m184r105" style="width:113px; top:534px; left:662px;"/>
<input type="text" name="m184r106" id="m184r106" style="width:102px; top:534px; left:786px;"/>
<input type="text" name="m184r111" id="m184r111" style="width:92px; top:560px; left:98px;"/>
<input type="text" name="m184r112" id="m184r112" style="width:99px; top:560px; left:201px;"/>
<input type="text" name="m184r113" id="m184r113" style="width:102px; top:560px; left:311px;"/>
<input type="text" name="m184r114" id="m184r114" style="width:227px; top:560px; left:424px;"/>
<input type="text" name="m184r115" id="m184r115" style="width:113px; top:560px; left:662px;"/>
<input type="text" name="m184r116" id="m184r116" style="width:102px; top:560px; left:786px;"/>
<input type="text" name="m184r121" id="m184r121" style="width:92px; top:586px; left:98px;"/>
<input type="text" name="m184r122" id="m184r122" style="width:99px; top:586px; left:201px;"/>
<input type="text" name="m184r123" id="m184r123" style="width:102px; top:586px; left:311px;"/>
<input type="text" name="m184r124" id="m184r124" style="width:227px; top:586px; left:424px;"/>
<input type="text" name="m184r125" id="m184r125" style="width:113px; top:586px; left:662px;"/>
<input type="text" name="m184r126" id="m184r126" style="width:102px; top:586px; left:786px;"/>
<input type="text" name="m184r131" id="m184r131" style="width:92px; top:612px; left:98px;"/>
<input type="text" name="m184r132" id="m184r132" style="width:99px; top:612px; left:201px;"/>
<input type="text" name="m184r133" id="m184r133" style="width:102px; top:612px; left:311px;"/>
<input type="text" name="m184r134" id="m184r134" style="width:227px; top:612px; left:424px;"/>
<input type="text" name="m184r135" id="m184r135" style="width:113px; top:612px; left:662px;"/>
<input type="text" name="m184r136" id="m184r136" style="width:102px; top:612px; left:786px;"/>
<input type="text" name="m184r141" id="m184r141" style="width:92px; top:638px; left:98px;"/>
<input type="text" name="m184r142" id="m184r142" style="width:99px; top:638px; left:201px;"/>
<input type="text" name="m184r143" id="m184r143" style="width:102px; top:638px; left:311px;"/>
<input type="text" name="m184r144" id="m184r144" style="width:227px; top:638px; left:424px;"/>
<input type="text" name="m184r145" id="m184r145" style="width:113px; top:638px; left:662px;"/>
<input type="text" name="m184r146" id="m184r146" style="width:102px; top:638px; left:786px;"/>
<input type="text" name="m184r151" id="m184r151" style="width:92px; top:665px; left:98px;"/>
<input type="text" name="m184r152" id="m184r152" style="width:99px; top:665px; left:201px;"/>
<input type="text" name="m184r153" id="m184r153" style="width:102px; top:665px; left:311px;"/>
<input type="text" name="m184r154" id="m184r154" style="width:227px; top:665px; left:424px;"/>
<input type="text" name="m184r155" id="m184r155" style="width:113px; top:665px; left:662px;"/>
<input type="text" name="m184r156" id="m184r156" style="width:102px; top:665px; left:786px;"/>
<input type="text" name="m184r161" id="m184r161" style="width:92px; top:691px; left:98px;"/>
<input type="text" name="m184r162" id="m184r162" style="width:99px; top:691px; left:201px;"/>
<input type="text" name="m184r163" id="m184r163" style="width:102px; top:691px; left:311px;"/>
<input type="text" name="m184r164" id="m184r164" style="width:227px; top:691px; left:424px;"/>
<input type="text" name="m184r165" id="m184r165" style="width:113px; top:691px; left:662px;"/>
<input type="text" name="m184r166" id="m184r166" style="width:102px; top:691px; left:786px;"/>
<input type="text" name="m184r171" id="m184r171" style="width:92px; top:717px; left:98px;"/>
<input type="text" name="m184r172" id="m184r172" style="width:99px; top:717px; left:201px;"/>
<input type="text" name="m184r173" id="m184r173" style="width:102px; top:717px; left:311px;"/>
<input type="text" name="m184r174" id="m184r174" style="width:227px; top:717px; left:424px;"/>
<input type="text" name="m184r175" id="m184r175" style="width:113px; top:717px; left:662px;"/>
<input type="text" name="m184r176" id="m184r176" style="width:102px; top:717px; left:786px;"/>
<input type="text" name="m184r181" id="m184r181" style="width:92px; top:743px; left:98px;"/>
<input type="text" name="m184r182" id="m184r182" style="width:99px; top:743px; left:201px;"/>
<input type="text" name="m184r183" id="m184r183" style="width:102px; top:743px; left:311px;"/>
<input type="text" name="m184r184" id="m184r184" style="width:227px; top:743px; left:424px;"/>
<input type="text" name="m184r185" id="m184r185" style="width:113px; top:743px; left:662px;"/>
<input type="text" name="m184r186" id="m184r186" style="width:102px; top:743px; left:786px;"/>
<input type="text" name="m184r191" id="m184r191" style="width:92px; top:769px; left:98px;"/>
<input type="text" name="m184r192" id="m184r192" style="width:99px; top:769px; left:201px;"/>
<input type="text" name="m184r193" id="m184r193" style="width:102px; top:769px; left:311px;"/>
<input type="text" name="m184r194" id="m184r194" style="width:227px; top:769px; left:424px;"/>
<input type="text" name="m184r195" id="m184r195" style="width:113px; top:769px; left:662px;"/>
<input type="text" name="m184r196" id="m184r196" style="width:102px; top:769px; left:786px;"/>
<input type="text" name="m184r201" id="m184r201" style="width:92px; top:795px; left:98px;"/>
<input type="text" name="m184r202" id="m184r202" style="width:99px; top:795px; left:201px;"/>
<input type="text" name="m184r203" id="m184r203" style="width:102px; top:795px; left:311px;"/>
<input type="text" name="m184r204" id="m184r204" style="width:227px; top:795px; left:424px;"/>
<input type="text" name="m184r205" id="m184r205" style="width:113px; top:795px; left:662px;"/>
<input type="text" name="m184r206" id="m184r206" style="width:102px; top:795px; left:786px;"/>
<input type="text" name="m184r211" id="m184r211" style="width:92px; top:821px; left:98px;"/>
<input type="text" name="m184r212" id="m184r212" style="width:99px; top:821px; left:201px;"/>
<input type="text" name="m184r213" id="m184r213" style="width:102px; top:821px; left:311px;"/>
<input type="text" name="m184r214" id="m184r214" style="width:227px; top:821px; left:424px;"/>
<input type="text" name="m184r215" id="m184r215" style="width:113px; top:821px; left:662px;"/>
<input type="text" name="m184r216" id="m184r216" style="width:102px; top:821px; left:786px;"/>
<input type="text" name="m184r221" id="m184r221" style="width:92px; top:847px; left:98px;"/>
<input type="text" name="m184r222" id="m184r222" style="width:99px; top:847px; left:201px;"/>
<input type="text" name="m184r223" id="m184r223" style="width:102px; top:847px; left:311px;"/>
<input type="text" name="m184r224" id="m184r224" style="width:227px; top:847px; left:424px;"/>
<input type="text" name="m184r225" id="m184r225" style="width:113px; top:847px; left:662px;"/>
<input type="text" name="m184r226" id="m184r226" style="width:102px; top:847px; left:786px;"/>
<input type="text" name="m184r231" id="m184r231" style="width:92px; top:873px; left:98px;"/>
<input type="text" name="m184r232" id="m184r232" style="width:99px; top:873px; left:201px;"/>
<input type="text" name="m184r233" id="m184r233" style="width:102px; top:873px; left:311px;"/>
<input type="text" name="m184r234" id="m184r234" style="width:227px; top:873px; left:424px;"/>
<input type="text" name="m184r235" id="m184r235" style="width:113px; top:873px; left:662px;"/>
<input type="text" name="m184r236" id="m184r236" style="width:102px; top:873px; left:786px;"/>
<input type="text" name="m184r241" id="m184r241" style="width:92px; top:899px; left:98px;"/>
<input type="text" name="m184r242" id="m184r242" style="width:99px; top:899px; left:201px;"/>
<input type="text" name="m184r243" id="m184r243" style="width:102px; top:899px; left:311px;"/>
<input type="text" name="m184r244" id="m184r244" style="width:227px; top:899px; left:424px;"/>
<input type="text" name="m184r245" id="m184r245" style="width:113px; top:899px; left:662px;"/>
<input type="text" name="m184r246" id="m184r246" style="width:102px; top:899px; left:786px;"/>
<input type="text" name="m184r251" id="m184r251" style="width:92px; top:926px; left:98px;"/>
<input type="text" name="m184r252" id="m184r252" style="width:99px; top:926px; left:201px;"/>
<input type="text" name="m184r253" id="m184r253" style="width:102px; top:926px; left:311px;"/>
<input type="text" name="m184r254" id="m184r254" style="width:227px; top:926px; left:424px;"/>
<input type="text" name="m184r255" id="m184r255" style="width:113px; top:926px; left:662px;"/>
<input type="text" name="m184r256" id="m184r256" style="width:102px; top:926px; left:786px;"/>
<input type="text" name="m184r261" id="m184r261" style="width:92px; top:951px; left:98px;"/>
<input type="text" name="m184r262" id="m184r262" style="width:99px; top:951px; left:201px;"/>
<input type="text" name="m184r263" id="m184r263" style="width:102px; top:951px; left:311px;"/>
<input type="text" name="m184r264" id="m184r264" style="width:227px; top:951px; left:424px;"/>
<input type="text" name="m184r265" id="m184r265" style="width:113px; top:951px; left:662px;"/>
<input type="text" name="m184r266" id="m184r266" style="width:102px; top:951px; left:786px;"/>
<input type="text" name="m184r271" id="m184r271" style="width:92px; top:978px; left:98px;"/>
<input type="text" name="m184r272" id="m184r272" style="width:99px; top:978px; left:201px;"/>
<input type="text" name="m184r273" id="m184r273" style="width:102px; top:978px; left:311px;"/>
<input type="text" name="m184r274" id="m184r274" style="width:227px; top:978px; left:424px;"/>
<input type="text" name="m184r275" id="m184r275" style="width:113px; top:978px; left:662px;"/>
<input type="text" name="m184r276" id="m184r276" style="width:102px; top:978px; left:786px;"/>
<input type="text" name="m184r281" id="m184r281" style="width:92px; top:1004px; left:98px;"/>
<input type="text" name="m184r282" id="m184r282" style="width:99px; top:1004px; left:201px;"/>
<input type="text" name="m184r283" id="m184r283" style="width:102px; top:1004px; left:311px;"/>
<input type="text" name="m184r284" id="m184r284" style="width:227px; top:1004px; left:424px;"/>
<input type="text" name="m184r285" id="m184r285" style="width:113px; top:1004px; left:662px;"/>
<input type="text" name="m184r286" id="m184r286" style="width:102px; top:1004px; left:786px;"/>
<input type="text" name="m184r291" id="m184r291" style="width:92px; top:1030px; left:98px;"/>
<input type="text" name="m184r292" id="m184r292" style="width:99px; top:1030px; left:201px;"/>
<input type="text" name="m184r293" id="m184r293" style="width:102px; top:1030px; left:311px;"/>
<input type="text" name="m184r294" id="m184r294" style="width:227px; top:1030px; left:424px;"/>
<input type="text" name="m184r295" id="m184r295" style="width:113px; top:1030px; left:662px;"/>
<input type="text" name="m184r296" id="m184r296" style="width:102px; top:1030px; left:786px;"/>
<input type="text" name="m184r301" id="m184r301" style="width:92px; top:1056px; left:98px;"/>
<input type="text" name="m184r302" id="m184r302" style="width:99px; top:1056px; left:201px;"/>
<input type="text" name="m184r303" id="m184r303" style="width:102px; top:1056px; left:311px;"/>
<input type="text" name="m184r304" id="m184r304" style="width:227px; top:1056px; left:424px;"/>
<input type="text" name="m184r305" id="m184r305" style="width:113px; top:1056px; left:662px;"/>
<input type="text" name="m184r306" id="m184r306" style="width:102px; top:1056px; left:786px;"/>
<input type="text" name="m184r311" id="m184r311" style="width:92px; top:1082px; left:98px;"/>
<input type="text" name="m184r312" id="m184r312" style="width:99px; top:1082px; left:201px;"/>
<input type="text" name="m184r313" id="m184r313" style="width:102px; top:1082px; left:311px;"/>
<input type="text" name="m184r314" id="m184r314" style="width:227px; top:1082px; left:424px;"/>
<input type="text" name="m184r315" id="m184r315" style="width:113px; top:1082px; left:662px;"/>
<input type="text" name="m184r316" id="m184r316" style="width:102px; top:1082px; left:786px;"/>
<input type="text" name="m184r321" id="m184r321" style="width:92px; top:1108px; left:98px;"/>
<input type="text" name="m184r322" id="m184r322" style="width:99px; top:1108px; left:201px;"/>
<input type="text" name="m184r323" id="m184r323" style="width:102px; top:1108px; left:311px;"/>
<input type="text" name="m184r324" id="m184r324" style="width:227px; top:1108px; left:424px;"/>
<input type="text" name="m184r325" id="m184r325" style="width:113px; top:1108px; left:662px;"/>
<input type="text" name="m184r326" id="m184r326" style="width:102px; top:1108px; left:786px;"/>
<span class="text-echo" style="top:1139px; right:649px;"><?php echo $m184r992; ?></span>
<span class="text-echo" style="top:1139px; right:536px;"><?php echo $m184r993; ?></span>
<span class="text-echo" style="top:1139px; right:299px;"><?php echo $m184r994; ?></span>
<span class="text-echo" style="top:1139px; right:175px;"><?php echo $m184r995; ?></span>
<span class="text-echo" style="top:1139px; right:62px;"><?php echo $m184r996; ?></span>
<?php                                        } ?>


<?php if ( $strana == 8 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str8.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 8.strana 254kB">
<span class="text-echo" style="top:78px; left:480px; font-size:16px; letter-spacing:25px;"><?php echo $fir_ficox; ?></span>

<!-- modul 185 -->
<input type="text" name="m185r11" id="m185r11" style="width:87px; top:289px; left:100px;"/>
<input type="text" name="m185r12" id="m185r12" style="width:103px; top:289px; left:197px;"/>
<input type="text" name="m185r13" id="m185r13" style="width:102px; top:289px; left:311px;"/>
<input type="text" name="m185r14" id="m185r14" style="width:113px; top:289px; left:424px;"/>
<input type="text" name="m185r15" id="m185r15" style="width:113px; top:289px; left:549px;"/>
<input type="text" name="m185r16" id="m185r16" style="width:102px; top:289px; left:673px;"/>
<input type="text" name="m185r17" id="m185r17" style="width:101px; top:289px; left:787px;"/>
<input type="text" name="m185r21" id="m185r21" style="width:87px; top:317px; left:100px;"/>
<input type="text" name="m185r22" id="m185r22" style="width:103px; top:317px; left:197px;"/>
<input type="text" name="m185r23" id="m185r23" style="width:102px; top:317px; left:311px;"/>
<input type="text" name="m185r24" id="m185r24" style="width:113px; top:317px; left:424px;"/>
<input type="text" name="m185r25" id="m185r25" style="width:113px; top:317px; left:549px;"/>
<input type="text" name="m185r26" id="m185r26" style="width:102px; top:317px; left:673px;"/>
<input type="text" name="m185r27" id="m185r27" style="width:101px; top:317px; left:787px;"/>
<input type="text" name="m185r31" id="m185r31" style="width:87px; top:344px; left:100px;"/>
<input type="text" name="m185r32" id="m185r32" style="width:103px; top:344px; left:197px;"/>
<input type="text" name="m185r33" id="m185r33" style="width:102px; top:344px; left:311px;"/>
<input type="text" name="m185r34" id="m185r34" style="width:113px; top:344px; left:424px;"/>
<input type="text" name="m185r35" id="m185r35" style="width:113px; top:344px; left:549px;"/>
<input type="text" name="m185r36" id="m185r36" style="width:102px; top:344px; left:673px;"/>
<input type="text" name="m185r37" id="m185r37" style="width:101px; top:344px; left:787px;"/>
<input type="text" name="m185r41" id="m185r41" style="width:87px; top:371px; left:100px;"/>
<input type="text" name="m185r42" id="m185r42" style="width:103px; top:371px; left:197px;"/>
<input type="text" name="m185r43" id="m185r43" style="width:102px; top:371px; left:311px;"/>
<input type="text" name="m185r44" id="m185r44" style="width:113px; top:371px; left:424px;"/>
<input type="text" name="m185r45" id="m185r45" style="width:113px; top:371px; left:549px;"/>
<input type="text" name="m185r46" id="m185r46" style="width:102px; top:371px; left:673px;"/>
<input type="text" name="m185r47" id="m185r47" style="width:101px; top:371px; left:787px;"/>
<input type="text" name="m185r51" id="m185r51" style="width:87px; top:399px; left:100px;"/>
<input type="text" name="m185r52" id="m185r52" style="width:103px; top:399px; left:197px;"/>
<input type="text" name="m185r53" id="m185r53" style="width:102px; top:399px; left:311px;"/>
<input type="text" name="m185r54" id="m185r54" style="width:113px; top:399px; left:424px;"/>
<input type="text" name="m185r55" id="m185r55" style="width:113px; top:399px; left:549px;"/>
<input type="text" name="m185r56" id="m185r56" style="width:102px; top:399px; left:673px;"/>
<input type="text" name="m185r57" id="m185r57" style="width:101px; top:399px; left:787px;"/>
<input type="text" name="m185r61" id="m185r61" style="width:87px; top:426px; left:100px;"/>
<input type="text" name="m185r62" id="m185r62" style="width:103px; top:426px; left:197px;"/>
<input type="text" name="m185r63" id="m185r63" style="width:102px; top:426px; left:311px;"/>
<input type="text" name="m185r64" id="m185r64" style="width:113px; top:426px; left:424px;"/>
<input type="text" name="m185r65" id="m185r65" style="width:113px; top:426px; left:549px;"/>
<input type="text" name="m185r66" id="m185r66" style="width:102px; top:426px; left:673px;"/>
<input type="text" name="m185r67" id="m185r67" style="width:101px; top:426px; left:787px;"/>
<input type="text" name="m185r71" id="m185r71" style="width:87px; top:454px; left:100px;"/>
<input type="text" name="m185r72" id="m185r72" style="width:103px; top:454px; left:197px;"/>
<input type="text" name="m185r73" id="m185r73" style="width:102px; top:454px; left:311px;"/>
<input type="text" name="m185r74" id="m185r74" style="width:113px; top:454px; left:424px;"/>
<input type="text" name="m185r75" id="m185r75" style="width:113px; top:454px; left:549px;"/>
<input type="text" name="m185r76" id="m185r76" style="width:102px; top:454px; left:673px;"/>
<input type="text" name="m185r77" id="m185r77" style="width:101px; top:454px; left:787px;"/>
<input type="text" name="m185r81" id="m185r81" style="width:87px; top:481px; left:100px;"/>
<input type="text" name="m185r82" id="m185r82" style="width:103px; top:481px; left:197px;"/>
<input type="text" name="m185r83" id="m185r83" style="width:102px; top:481px; left:311px;"/>
<input type="text" name="m185r84" id="m185r84" style="width:113px; top:481px; left:424px;"/>
<input type="text" name="m185r85" id="m185r85" style="width:113px; top:481px; left:549px;"/>
<input type="text" name="m185r86" id="m185r86" style="width:102px; top:481px; left:673px;"/>
<input type="text" name="m185r87" id="m185r87" style="width:101px; top:481px; left:787px;"/>
<input type="text" name="m185r91" id="m185r91" style="width:87px; top:508px; left:100px;"/>
<input type="text" name="m185r92" id="m185r92" style="width:103px; top:508px; left:197px;"/>
<input type="text" name="m185r93" id="m185r93" style="width:102px; top:508px; left:311px;"/>
<input type="text" name="m185r94" id="m185r94" style="width:113px; top:508px; left:424px;"/>
<input type="text" name="m185r95" id="m185r95" style="width:113px; top:508px; left:549px;"/>
<input type="text" name="m185r96" id="m185r96" style="width:102px; top:508px; left:673px;"/>
<input type="text" name="m185r97" id="m185r97" style="width:101px; top:508px; left:787px;"/>
<input type="text" name="m185r101" id="m185r101" style="width:87px; top:535px; left:100px;"/>
<input type="text" name="m185r102" id="m185r102" style="width:103px; top:535px; left:197px;"/>
<input type="text" name="m185r103" id="m185r103" style="width:102px; top:535px; left:311px;"/>
<input type="text" name="m185r104" id="m185r104" style="width:113px; top:535px; left:424px;"/>
<input type="text" name="m185r105" id="m185r105" style="width:113px; top:535px; left:549px;"/>
<input type="text" name="m185r106" id="m185r106" style="width:102px; top:535px; left:673px;"/>
<input type="text" name="m185r107" id="m185r107" style="width:101px; top:535px; left:787px;"/>
<input type="text" name="m185r111" id="m185r111" style="width:87px; top:563px; left:100px;"/>
<input type="text" name="m185r112" id="m185r112" style="width:103px; top:563px; left:197px;"/>
<input type="text" name="m185r113" id="m185r113" style="width:102px; top:563px; left:311px;"/>
<input type="text" name="m185r114" id="m185r114" style="width:113px; top:563px; left:424px;"/>
<input type="text" name="m185r115" id="m185r115" style="width:113px; top:563px; left:549px;"/>
<input type="text" name="m185r116" id="m185r116" style="width:102px; top:563px; left:673px;"/>
<input type="text" name="m185r117" id="m185r117" style="width:101px; top:563px; left:787px;"/>
<input type="text" name="m185r121" id="m185r121" style="width:87px; top:590px; left:100px;"/>
<input type="text" name="m185r122" id="m185r122" style="width:103px; top:590px; left:197px;"/>
<input type="text" name="m185r123" id="m185r123" style="width:102px; top:590px; left:311px;"/>
<input type="text" name="m185r124" id="m185r124" style="width:113px; top:590px; left:424px;"/>
<input type="text" name="m185r125" id="m185r125" style="width:113px; top:590px; left:549px;"/>
<input type="text" name="m185r126" id="m185r126" style="width:102px; top:590px; left:673px;"/>
<input type="text" name="m185r127" id="m185r127" style="width:101px; top:590px; left:787px;"/>
<input type="text" name="m185r131" id="m185r131" style="width:87px; top:618px; left:100px;"/>
<input type="text" name="m185r132" id="m185r132" style="width:103px; top:618px; left:197px;"/>
<input type="text" name="m185r133" id="m185r133" style="width:102px; top:618px; left:311px;"/>
<input type="text" name="m185r134" id="m185r134" style="width:113px; top:618px; left:424px;"/>
<input type="text" name="m185r135" id="m185r135" style="width:113px; top:618px; left:549px;"/>
<input type="text" name="m185r136" id="m185r136" style="width:102px; top:618px; left:673px;"/>
<input type="text" name="m185r137" id="m185r137" style="width:101px; top:618px; left:787px;"/>
<input type="text" name="m185r141" id="m185r141" style="width:87px; top:646px; left:100px;"/>
<input type="text" name="m185r142" id="m185r142" style="width:103px; top:646px; left:197px;"/>
<input type="text" name="m185r143" id="m185r143" style="width:102px; top:646px; left:311px;"/>
<input type="text" name="m185r144" id="m185r144" style="width:113px; top:646px; left:424px;"/>
<input type="text" name="m185r145" id="m185r145" style="width:113px; top:646px; left:549px;"/>
<input type="text" name="m185r146" id="m185r146" style="width:102px; top:646px; left:673px;"/>
<input type="text" name="m185r147" id="m185r147" style="width:101px; top:646px; left:787px;"/>
<input type="text" name="m185r151" id="m185r151" style="width:87px; top:673px; left:100px;"/>
<input type="text" name="m185r152" id="m185r152" style="width:103px; top:673px; left:197px;"/>
<input type="text" name="m185r153" id="m185r153" style="width:102px; top:673px; left:311px;"/>
<input type="text" name="m185r154" id="m185r154" style="width:113px; top:673px; left:424px;"/>
<input type="text" name="m185r155" id="m185r155" style="width:113px; top:673px; left:549px;"/>
<input type="text" name="m185r156" id="m185r156" style="width:102px; top:673px; left:673px;"/>
<input type="text" name="m185r157" id="m185r157" style="width:101px; top:673px; left:787px;"/>
<input type="text" name="m185r161" id="m185r161" style="width:87px; top:700px; left:100px;"/>
<input type="text" name="m185r162" id="m185r162" style="width:103px; top:700px; left:197px;"/>
<input type="text" name="m185r163" id="m185r163" style="width:102px; top:700px; left:311px;"/>
<input type="text" name="m185r164" id="m185r164" style="width:113px; top:700px; left:424px;"/>
<input type="text" name="m185r165" id="m185r165" style="width:113px; top:700px; left:549px;"/>
<input type="text" name="m185r166" id="m185r166" style="width:102px; top:700px; left:673px;"/>
<input type="text" name="m185r167" id="m185r167" style="width:101px; top:700px; left:787px;"/>
<input type="text" name="m185r171" id="m185r171" style="width:87px; top:727px; left:100px;"/>
<input type="text" name="m185r172" id="m185r172" style="width:103px; top:727px; left:197px;"/>
<input type="text" name="m185r173" id="m185r173" style="width:102px; top:727px; left:311px;"/>
<input type="text" name="m185r174" id="m185r174" style="width:113px; top:727px; left:424px;"/>
<input type="text" name="m185r175" id="m185r175" style="width:113px; top:727px; left:549px;"/>
<input type="text" name="m185r176" id="m185r176" style="width:102px; top:727px; left:673px;"/>
<input type="text" name="m185r177" id="m185r177" style="width:101px; top:727px; left:787px;"/>
<input type="text" name="m185r181" id="m185r181" style="width:87px; top:755px; left:100px;"/>
<input type="text" name="m185r182" id="m185r182" style="width:103px; top:755px; left:197px;"/>
<input type="text" name="m185r183" id="m185r183" style="width:102px; top:755px; left:311px;"/>
<input type="text" name="m185r184" id="m185r184" style="width:113px; top:755px; left:424px;"/>
<input type="text" name="m185r185" id="m185r185" style="width:113px; top:755px; left:549px;"/>
<input type="text" name="m185r186" id="m185r186" style="width:102px; top:755px; left:673px;"/>
<input type="text" name="m185r187" id="m185r187" style="width:101px; top:755px; left:787px;"/>
<input type="text" name="m185r191" id="m185r191" style="width:87px; top:782px; left:100px;"/>
<input type="text" name="m185r192" id="m185r192" style="width:103px; top:782px; left:197px;"/>
<input type="text" name="m185r193" id="m185r193" style="width:102px; top:782px; left:311px;"/>
<input type="text" name="m185r194" id="m185r194" style="width:113px; top:782px; left:424px;"/>
<input type="text" name="m185r195" id="m185r195" style="width:113px; top:782px; left:549px;"/>
<input type="text" name="m185r196" id="m185r196" style="width:102px; top:782px; left:673px;"/>
<input type="text" name="m185r197" id="m185r197" style="width:101px; top:782px; left:787px;"/>
<input type="text" name="m185r201" id="m185r201" style="width:87px; top:810px; left:100px;"/>
<input type="text" name="m185r202" id="m185r202" style="width:103px; top:810px; left:197px;"/>
<input type="text" name="m185r203" id="m185r203" style="width:102px; top:810px; left:311px;"/>
<input type="text" name="m185r204" id="m185r204" style="width:113px; top:810px; left:424px;"/>
<input type="text" name="m185r205" id="m185r205" style="width:113px; top:810px; left:549px;"/>
<input type="text" name="m185r206" id="m185r206" style="width:102px; top:810px; left:673px;"/>
<input type="text" name="m185r207" id="m185r207" style="width:101px; top:810px; left:787px;"/>
<input type="text" name="m185r211" id="m185r211" style="width:87px; top:837px; left:100px;"/>
<input type="text" name="m185r212" id="m185r212" style="width:103px; top:837px; left:197px;"/>
<input type="text" name="m185r213" id="m185r213" style="width:102px; top:837px; left:311px;"/>
<input type="text" name="m185r214" id="m185r214" style="width:113px; top:837px; left:424px;"/>
<input type="text" name="m185r215" id="m185r215" style="width:113px; top:837px; left:549px;"/>
<input type="text" name="m185r216" id="m185r216" style="width:102px; top:837px; left:673px;"/>
<input type="text" name="m185r217" id="m185r217" style="width:101px; top:837px; left:787px;"/>
<input type="text" name="m185r221" id="m185r221" style="width:87px; top:865px; left:100px;"/>
<input type="text" name="m185r222" id="m185r222" style="width:103px; top:865px; left:197px;"/>
<input type="text" name="m185r223" id="m185r223" style="width:102px; top:865px; left:311px;"/>
<input type="text" name="m185r224" id="m185r224" style="width:113px; top:865px; left:424px;"/>
<input type="text" name="m185r225" id="m185r225" style="width:113px; top:865px; left:549px;"/>
<input type="text" name="m185r226" id="m185r226" style="width:102px; top:865px; left:673px;"/>
<input type="text" name="m185r227" id="m185r227" style="width:101px; top:865px; left:787px;"/>
<input type="text" name="m185r231" id="m185r231" style="width:87px; top:892px; left:100px;"/>
<input type="text" name="m185r232" id="m185r232" style="width:103px; top:892px; left:197px;"/>
<input type="text" name="m185r233" id="m185r233" style="width:102px; top:892px; left:311px;"/>
<input type="text" name="m185r234" id="m185r234" style="width:113px; top:892px; left:424px;"/>
<input type="text" name="m185r235" id="m185r235" style="width:113px; top:892px; left:549px;"/>
<input type="text" name="m185r236" id="m185r236" style="width:102px; top:892px; left:673px;"/>
<input type="text" name="m185r237" id="m185r237" style="width:101px; top:892px; left:787px;"/>
<input type="text" name="m185r241" id="m185r241" style="width:87px; top:919px; left:100px;"/>
<input type="text" name="m185r242" id="m185r242" style="width:103px; top:919px; left:197px;"/>
<input type="text" name="m185r243" id="m185r243" style="width:102px; top:919px; left:311px;"/>
<input type="text" name="m185r244" id="m185r244" style="width:113px; top:919px; left:424px;"/>
<input type="text" name="m185r245" id="m185r245" style="width:113px; top:919px; left:549px;"/>
<input type="text" name="m185r246" id="m185r246" style="width:102px; top:919px; left:673px;"/>
<input type="text" name="m185r247" id="m185r247" style="width:101px; top:919px; left:787px;"/>
<input type="text" name="m185r251" id="m185r251" style="width:87px; top:947px; left:100px;"/>
<input type="text" name="m185r252" id="m185r252" style="width:103px; top:947px; left:197px;"/>
<input type="text" name="m185r253" id="m185r253" style="width:102px; top:947px; left:311px;"/>
<input type="text" name="m185r254" id="m185r254" style="width:113px; top:947px; left:424px;"/>
<input type="text" name="m185r255" id="m185r255" style="width:113px; top:947px; left:549px;"/>
<input type="text" name="m185r256" id="m185r256" style="width:102px; top:947px; left:673px;"/>
<input type="text" name="m185r257" id="m185r257" style="width:101px; top:947px; left:787px;"/>
<input type="text" name="m185r261" id="m185r261" style="width:87px; top:974px; left:100px;"/>
<input type="text" name="m185r262" id="m185r262" style="width:103px; top:974px; left:197px;"/>
<input type="text" name="m185r263" id="m185r263" style="width:102px; top:974px; left:311px;"/>
<input type="text" name="m185r264" id="m185r264" style="width:113px; top:974px; left:424px;"/>
<input type="text" name="m185r265" id="m185r265" style="width:113px; top:974px; left:549px;"/>
<input type="text" name="m185r266" id="m185r266" style="width:102px; top:974px; left:673px;"/>
<input type="text" name="m185r267" id="m185r267" style="width:101px; top:974px; left:787px;"/>
<input type="text" name="m185r271" id="m185r271" style="width:87px; top:1002px; left:100px;"/>
<input type="text" name="m185r272" id="m185r272" style="width:103px; top:1002px; left:197px;"/>
<input type="text" name="m185r273" id="m185r273" style="width:102px; top:1002px; left:311px;"/>
<input type="text" name="m185r274" id="m185r274" style="width:113px; top:1002px; left:424px;"/>
<input type="text" name="m185r275" id="m185r275" style="width:113px; top:1002px; left:549px;"/>
<input type="text" name="m185r276" id="m185r276" style="width:102px; top:1002px; left:673px;"/>
<input type="text" name="m185r277" id="m185r277" style="width:101px; top:1002px; left:787px;"/>
<input type="text" name="m185r281" id="m185r281" style="width:87px; top:1029px; left:100px;"/>
<input type="text" name="m185r282" id="m185r282" style="width:103px; top:1029px; left:197px;"/>
<input type="text" name="m185r283" id="m185r283" style="width:102px; top:1029px; left:311px;"/>
<input type="text" name="m185r284" id="m185r284" style="width:113px; top:1029px; left:424px;"/>
<input type="text" name="m185r285" id="m185r285" style="width:113px; top:1029px; left:549px;"/>
<input type="text" name="m185r286" id="m185r286" style="width:102px; top:1029px; left:673px;"/>
<input type="text" name="m185r287" id="m185r287" style="width:101px; top:1029px; left:787px;"/>
<input type="text" name="m185r291" id="m185r291" style="width:87px; top:1057px; left:100px;"/>
<input type="text" name="m185r292" id="m185r292" style="width:103px; top:1057px; left:197px;"/>
<input type="text" name="m185r293" id="m185r293" style="width:102px; top:1057px; left:311px;"/>
<input type="text" name="m185r294" id="m185r294" style="width:113px; top:1057px; left:424px;"/>
<input type="text" name="m185r295" id="m185r295" style="width:113px; top:1057px; left:549px;"/>
<input type="text" name="m185r296" id="m185r296" style="width:102px; top:1057px; left:673px;"/>
<input type="text" name="m185r297" id="m185r297" style="width:101px; top:1057px; left:787px;"/>
<input type="text" name="m185r301" id="m185r301" style="width:87px; top:1084px; left:100px;"/>
<input type="text" name="m185r302" id="m185r302" style="width:103px; top:1084px; left:197px;"/>
<input type="text" name="m185r303" id="m185r303" style="width:102px; top:1084px; left:311px;"/>
<input type="text" name="m185r304" id="m185r304" style="width:113px; top:1084px; left:424px;"/>
<input type="text" name="m185r305" id="m185r305" style="width:113px; top:1084px; left:549px;"/>
<input type="text" name="m185r306" id="m185r306" style="width:102px; top:1084px; left:673px;"/>
<input type="text" name="m185r307" id="m185r307" style="width:101px; top:1084px; left:787px;"/>
<span class="text-echo" style="top:1116px; right:648px;"><?php echo $m185r992; ?></span>
<span class="text-echo" style="top:1116px; right:535px;"><?php echo $m185r993; ?></span>
<span class="text-echo" style="top:1116px; right:410px;"><?php echo $m185r994; ?></span>
<span class="text-echo" style="top:1116px; right:285px;"><?php echo $m185r995; ?></span>
<span class="text-echo" style="top:1116px; right:173px;"><?php echo $m185r996; ?></span>
<span class="text-echo" style="top:1116px; right:60px;"><?php echo $m185r997; ?></span>
<?php                                        } ?>


<?php if ( $strana == 9 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str9.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 9.strana 254kB">
<span class="text-echo" style="top:97px; left:480px; font-size:16px; letter-spacing:25px;"><?php echo $fir_ficox; ?></span>

<!-- modul 186 -->
<input type="text" name="m186r11" id="m186r11" style="width:87px; top:289px; left:100px;"/>
<input type="text" name="m186r12" id="m186r12" style="width:103px; top:289px; left:197px;"/>
<input type="text" name="m186r13" id="m186r13" style="width:102px; top:289px; left:311px;"/>
<input type="text" name="m186r14" id="m186r14" style="width:114px; top:289px; left:424px;"/>
<input type="text" name="m186r15" id="m186r15" style="width:115px; top:289px; left:548px;"/>
<input type="text" name="m186r16" id="m186r16" style="width:102px; top:289px; left:673px;"/>
<input type="text" name="m186r17" id="m186r17" style="width:101px; top:289px; left:787px;"/>
<input type="text" name="m186r21" id="m186r21" style="width:87px; top:316px; left:100px;"/>
<input type="text" name="m186r22" id="m186r22" style="width:103px; top:316px; left:197px;"/>
<input type="text" name="m186r23" id="m186r23" style="width:102px; top:316px; left:311px;"/>
<input type="text" name="m186r24" id="m186r24" style="width:114px; top:316px; left:424px;"/>
<input type="text" name="m186r25" id="m186r25" style="width:115px; top:316px; left:548px;"/>
<input type="text" name="m186r26" id="m186r26" style="width:102px; top:316px; left:673px;"/>
<input type="text" name="m186r27" id="m186r27" style="width:101px; top:316px; left:787px;"/>
<input type="text" name="m186r31" id="m186r31" style="width:87px; top:344px; left:100px;"/>
<input type="text" name="m186r32" id="m186r32" style="width:103px; top:344px; left:197px;"/>
<input type="text" name="m186r33" id="m186r33" style="width:102px; top:344px; left:311px;"/>
<input type="text" name="m186r34" id="m186r34" style="width:114px; top:344px; left:424px;"/>
<input type="text" name="m186r35" id="m186r35" style="width:115px; top:344px; left:548px;"/>
<input type="text" name="m186r36" id="m186r36" style="width:102px; top:344px; left:673px;"/>
<input type="text" name="m186r37" id="m186r37" style="width:101px; top:344px; left:787px;"/>
<input type="text" name="m186r41" id="m186r41" style="width:87px; top:371px; left:100px;"/>
<input type="text" name="m186r42" id="m186r42" style="width:103px; top:371px; left:197px;"/>
<input type="text" name="m186r43" id="m186r43" style="width:102px; top:371px; left:311px;"/>
<input type="text" name="m186r44" id="m186r44" style="width:114px; top:371px; left:424px;"/>
<input type="text" name="m186r45" id="m186r45" style="width:115px; top:371px; left:548px;"/>
<input type="text" name="m186r46" id="m186r46" style="width:102px; top:371px; left:673px;"/>
<input type="text" name="m186r47" id="m186r47" style="width:101px; top:371px; left:787px;"/>
<input type="text" name="m186r51" id="m186r51" style="width:87px; top:399px; left:100px;"/>
<input type="text" name="m186r52" id="m186r52" style="width:103px; top:399px; left:197px;"/>
<input type="text" name="m186r53" id="m186r53" style="width:102px; top:399px; left:311px;"/>
<input type="text" name="m186r54" id="m186r54" style="width:114px; top:399px; left:424px;"/>
<input type="text" name="m186r55" id="m186r55" style="width:115px; top:399px; left:548px;"/>
<input type="text" name="m186r56" id="m186r56" style="width:102px; top:399px; left:673px;"/>
<input type="text" name="m186r57" id="m186r57" style="width:101px; top:399px; left:787px;"/>
<input type="text" name="m186r61" id="m186r61" style="width:87px; top:426px; left:100px;"/>
<input type="text" name="m186r62" id="m186r62" style="width:103px; top:426px; left:197px;"/>
<input type="text" name="m186r63" id="m186r63" style="width:102px; top:426px; left:311px;"/>
<input type="text" name="m186r64" id="m186r64" style="width:114px; top:426px; left:424px;"/>
<input type="text" name="m186r65" id="m186r65" style="width:115px; top:426px; left:548px;"/>
<input type="text" name="m186r66" id="m186r66" style="width:102px; top:426px; left:673px;"/>
<input type="text" name="m186r67" id="m186r67" style="width:101px; top:426px; left:787px;"/>
<input type="text" name="m186r71" id="m186r71" style="width:87px; top:454px; left:100px;"/>
<input type="text" name="m186r72" id="m186r72" style="width:103px; top:454px; left:197px;"/>
<input type="text" name="m186r73" id="m186r73" style="width:102px; top:454px; left:311px;"/>
<input type="text" name="m186r74" id="m186r74" style="width:114px; top:454px; left:424px;"/>
<input type="text" name="m186r75" id="m186r75" style="width:115px; top:454px; left:548px;"/>
<input type="text" name="m186r76" id="m186r76" style="width:102px; top:454px; left:673px;"/>
<input type="text" name="m186r77" id="m186r77" style="width:101px; top:454px; left:787px;"/>
<input type="text" name="m186r81" id="m186r81" style="width:87px; top:481px; left:100px;"/>
<input type="text" name="m186r82" id="m186r82" style="width:103px; top:481px; left:197px;"/>
<input type="text" name="m186r83" id="m186r83" style="width:102px; top:481px; left:311px;"/>
<input type="text" name="m186r84" id="m186r84" style="width:114px; top:481px; left:424px;"/>
<input type="text" name="m186r85" id="m186r85" style="width:115px; top:481px; left:548px;"/>
<input type="text" name="m186r86" id="m186r86" style="width:102px; top:481px; left:673px;"/>
<input type="text" name="m186r87" id="m186r87" style="width:101px; top:481px; left:787px;"/>
<input type="text" name="m186r91" id="m186r91" style="width:87px; top:508px; left:100px;"/>
<input type="text" name="m186r92" id="m186r92" style="width:103px; top:508px; left:197px;"/>
<input type="text" name="m186r93" id="m186r93" style="width:102px; top:508px; left:311px;"/>
<input type="text" name="m186r94" id="m186r94" style="width:114px; top:508px; left:424px;"/>
<input type="text" name="m186r95" id="m186r95" style="width:115px; top:508px; left:548px;"/>
<input type="text" name="m186r96" id="m186r96" style="width:102px; top:508px; left:673px;"/>
<input type="text" name="m186r97" id="m186r97" style="width:101px; top:508px; left:787px;"/>
<input type="text" name="m186r101" id="m186r101" style="width:87px; top:536px; left:100px;"/>
<input type="text" name="m186r102" id="m186r102" style="width:103px; top:536px; left:197px;"/>
<input type="text" name="m186r103" id="m186r103" style="width:102px; top:536px; left:311px;"/>
<input type="text" name="m186r104" id="m186r104" style="width:114px; top:536px; left:424px;"/>
<input type="text" name="m186r105" id="m186r105" style="width:115px; top:536px; left:548px;"/>
<input type="text" name="m186r106" id="m186r106" style="width:102px; top:536px; left:673px;"/>
<input type="text" name="m186r107" id="m186r107" style="width:101px; top:536px; left:787px;"/>
<input type="text" name="m186r111" id="m186r111" style="width:87px; top:563px; left:100px;"/>
<input type="text" name="m186r112" id="m186r112" style="width:103px; top:563px; left:197px;"/>
<input type="text" name="m186r113" id="m186r113" style="width:102px; top:563px; left:311px;"/>
<input type="text" name="m186r114" id="m186r114" style="width:114px; top:563px; left:424px;"/>
<input type="text" name="m186r115" id="m186r115" style="width:115px; top:563px; left:548px;"/>
<input type="text" name="m186r116" id="m186r116" style="width:102px; top:563px; left:673px;"/>
<input type="text" name="m186r117" id="m186r117" style="width:101px; top:563px; left:787px;"/>
<input type="text" name="m186r121" id="m186r121" style="width:87px; top:591px; left:100px;"/>
<input type="text" name="m186r122" id="m186r122" style="width:103px; top:591px; left:197px;"/>
<input type="text" name="m186r123" id="m186r123" style="width:102px; top:591px; left:311px;"/>
<input type="text" name="m186r124" id="m186r124" style="width:114px; top:591px; left:424px;"/>
<input type="text" name="m186r125" id="m186r125" style="width:115px; top:591px; left:548px;"/>
<input type="text" name="m186r126" id="m186r126" style="width:102px; top:591px; left:673px;"/>
<input type="text" name="m186r127" id="m186r127" style="width:101px; top:591px; left:787px;"/>
<input type="text" name="m186r131" id="m186r131" style="width:87px; top:618px; left:100px;"/>
<input type="text" name="m186r132" id="m186r132" style="width:103px; top:618px; left:197px;"/>
<input type="text" name="m186r133" id="m186r133" style="width:102px; top:618px; left:311px;"/>
<input type="text" name="m186r134" id="m186r134" style="width:114px; top:618px; left:424px;"/>
<input type="text" name="m186r135" id="m186r135" style="width:115px; top:618px; left:548px;"/>
<input type="text" name="m186r136" id="m186r136" style="width:102px; top:618px; left:673px;"/>
<input type="text" name="m186r137" id="m186r137" style="width:101px; top:618px; left:787px;"/>
<input type="text" name="m186r141" id="m186r141" style="width:87px; top:645px; left:100px;"/>
<input type="text" name="m186r142" id="m186r142" style="width:103px; top:645px; left:197px;"/>
<input type="text" name="m186r143" id="m186r143" style="width:102px; top:645px; left:311px;"/>
<input type="text" name="m186r144" id="m186r144" style="width:114px; top:645px; left:424px;"/>
<input type="text" name="m186r145" id="m186r145" style="width:115px; top:645px; left:548px;"/>
<input type="text" name="m186r146" id="m186r146" style="width:102px; top:645px; left:673px;"/>
<input type="text" name="m186r147" id="m186r147" style="width:101px; top:645px; left:787px;"/>
<input type="text" name="m186r151" id="m186r151" style="width:87px; top:673px; left:100px;"/>
<input type="text" name="m186r152" id="m186r152" style="width:103px; top:673px; left:197px;"/>
<input type="text" name="m186r153" id="m186r153" style="width:102px; top:673px; left:311px;"/>
<input type="text" name="m186r154" id="m186r154" style="width:114px; top:673px; left:424px;"/>
<input type="text" name="m186r155" id="m186r155" style="width:115px; top:673px; left:548px;"/>
<input type="text" name="m186r156" id="m186r156" style="width:102px; top:673px; left:673px;"/>
<input type="text" name="m186r157" id="m186r157" style="width:101px; top:673px; left:787px;"/>
<input type="text" name="m186r161" id="m186r161" style="width:87px; top:700px; left:100px;"/>
<input type="text" name="m186r162" id="m186r162" style="width:103px; top:700px; left:197px;"/>
<input type="text" name="m186r163" id="m186r163" style="width:102px; top:700px; left:311px;"/>
<input type="text" name="m186r164" id="m186r164" style="width:114px; top:700px; left:424px;"/>
<input type="text" name="m186r165" id="m186r165" style="width:115px; top:700px; left:548px;"/>
<input type="text" name="m186r166" id="m186r166" style="width:102px; top:700px; left:673px;"/>
<input type="text" name="m186r167" id="m186r167" style="width:101px; top:700px; left:787px;"/>
<input type="text" name="m186r171" id="m186r171" style="width:87px; top:728px; left:100px;"/>
<input type="text" name="m186r172" id="m186r172" style="width:103px; top:728px; left:197px;"/>
<input type="text" name="m186r173" id="m186r173" style="width:102px; top:728px; left:311px;"/>
<input type="text" name="m186r174" id="m186r174" style="width:114px; top:728px; left:424px;"/>
<input type="text" name="m186r175" id="m186r175" style="width:115px; top:728px; left:548px;"/>
<input type="text" name="m186r176" id="m186r176" style="width:102px; top:728px; left:673px;"/>
<input type="text" name="m186r177" id="m186r177" style="width:101px; top:728px; left:787px;"/>
<input type="text" name="m186r181" id="m186r181" style="width:87px; top:755px; left:100px;"/>
<input type="text" name="m186r182" id="m186r182" style="width:103px; top:755px; left:197px;"/>
<input type="text" name="m186r183" id="m186r183" style="width:102px; top:755px; left:311px;"/>
<input type="text" name="m186r184" id="m186r184" style="width:114px; top:755px; left:424px;"/>
<input type="text" name="m186r185" id="m186r185" style="width:115px; top:755px; left:548px;"/>
<input type="text" name="m186r186" id="m186r186" style="width:102px; top:755px; left:673px;"/>
<input type="text" name="m186r187" id="m186r187" style="width:101px; top:755px; left:787px;"/>
<input type="text" name="m186r191" id="m186r191" style="width:87px; top:782px; left:100px;"/>
<input type="text" name="m186r192" id="m186r192" style="width:103px; top:782px; left:197px;"/>
<input type="text" name="m186r193" id="m186r193" style="width:102px; top:782px; left:311px;"/>
<input type="text" name="m186r194" id="m186r194" style="width:114px; top:782px; left:424px;"/>
<input type="text" name="m186r195" id="m186r195" style="width:115px; top:782px; left:548px;"/>
<input type="text" name="m186r196" id="m186r196" style="width:102px; top:782px; left:673px;"/>
<input type="text" name="m186r197" id="m186r197" style="width:101px; top:782px; left:787px;"/>
<input type="text" name="m186r201" id="m186r201" style="width:87px; top:810px; left:100px;"/>
<input type="text" name="m186r202" id="m186r202" style="width:103px; top:810px; left:197px;"/>
<input type="text" name="m186r203" id="m186r203" style="width:102px; top:810px; left:311px;"/>
<input type="text" name="m186r204" id="m186r204" style="width:114px; top:810px; left:424px;"/>
<input type="text" name="m186r205" id="m186r205" style="width:115px; top:810px; left:548px;"/>
<input type="text" name="m186r206" id="m186r206" style="width:102px; top:810px; left:673px;"/>
<input type="text" name="m186r207" id="m186r207" style="width:101px; top:810px; left:787px;"/>
<input type="text" name="m186r211" id="m186r211" style="width:87px; top:837px; left:100px;"/>
<input type="text" name="m186r212" id="m186r212" style="width:103px; top:837px; left:197px;"/>
<input type="text" name="m186r213" id="m186r213" style="width:102px; top:837px; left:311px;"/>
<input type="text" name="m186r214" id="m186r214" style="width:114px; top:837px; left:424px;"/>
<input type="text" name="m186r215" id="m186r215" style="width:115px; top:837px; left:548px;"/>
<input type="text" name="m186r216" id="m186r216" style="width:102px; top:837px; left:673px;"/>
<input type="text" name="m186r217" id="m186r217" style="width:101px; top:837px; left:787px;"/>
<input type="text" name="m186r221" id="m186r221" style="width:87px; top:865px; left:100px;"/>
<input type="text" name="m186r222" id="m186r222" style="width:103px; top:865px; left:197px;"/>
<input type="text" name="m186r223" id="m186r223" style="width:102px; top:865px; left:311px;"/>
<input type="text" name="m186r224" id="m186r224" style="width:114px; top:865px; left:424px;"/>
<input type="text" name="m186r225" id="m186r225" style="width:115px; top:865px; left:548px;"/>
<input type="text" name="m186r226" id="m186r226" style="width:102px; top:865px; left:673px;"/>
<input type="text" name="m186r227" id="m186r227" style="width:101px; top:865px; left:787px;"/>
<input type="text" name="m186r231" id="m186r231" style="width:87px; top:892px; left:100px;"/>
<input type="text" name="m186r232" id="m186r232" style="width:103px; top:892px; left:197px;"/>
<input type="text" name="m186r233" id="m186r233" style="width:102px; top:892px; left:311px;"/>
<input type="text" name="m186r234" id="m186r234" style="width:114px; top:892px; left:424px;"/>
<input type="text" name="m186r235" id="m186r235" style="width:115px; top:892px; left:548px;"/>
<input type="text" name="m186r236" id="m186r236" style="width:102px; top:892px; left:673px;"/>
<input type="text" name="m186r237" id="m186r237" style="width:101px; top:892px; left:787px;"/>
<input type="text" name="m186r241" id="m186r241" style="width:87px; top:920px; left:100px;"/>
<input type="text" name="m186r242" id="m186r242" style="width:103px; top:920px; left:197px;"/>
<input type="text" name="m186r243" id="m186r243" style="width:102px; top:920px; left:311px;"/>
<input type="text" name="m186r244" id="m186r244" style="width:114px; top:920px; left:424px;"/>
<input type="text" name="m186r245" id="m186r245" style="width:115px; top:920px; left:548px;"/>
<input type="text" name="m186r246" id="m186r246" style="width:102px; top:920px; left:673px;"/>
<input type="text" name="m186r247" id="m186r247" style="width:101px; top:920px; left:787px;"/>
<input type="text" name="m186r251" id="m186r251" style="width:87px; top:947px; left:100px;"/>
<input type="text" name="m186r252" id="m186r252" style="width:103px; top:947px; left:197px;"/>
<input type="text" name="m186r253" id="m186r253" style="width:102px; top:947px; left:311px;"/>
<input type="text" name="m186r254" id="m186r254" style="width:114px; top:947px; left:424px;"/>
<input type="text" name="m186r255" id="m186r255" style="width:115px; top:947px; left:548px;"/>
<input type="text" name="m186r256" id="m186r256" style="width:102px; top:947px; left:673px;"/>
<input type="text" name="m186r257" id="m186r257" style="width:101px; top:947px; left:787px;"/>
<input type="text" name="m186r261" id="m186r261" style="width:87px; top:974px; left:100px;"/>
<input type="text" name="m186r262" id="m186r262" style="width:103px; top:974px; left:197px;"/>
<input type="text" name="m186r263" id="m186r263" style="width:102px; top:974px; left:311px;"/>
<input type="text" name="m186r264" id="m186r264" style="width:114px; top:974px; left:424px;"/>
<input type="text" name="m186r265" id="m186r265" style="width:115px; top:974px; left:548px;"/>
<input type="text" name="m186r266" id="m186r266" style="width:102px; top:974px; left:673px;"/>
<input type="text" name="m186r267" id="m186r267" style="width:101px; top:974px; left:787px;"/>
<input type="text" name="m186r271" id="m186r271" style="width:87px; top:1002px; left:100px;"/>
<input type="text" name="m186r272" id="m186r272" style="width:103px; top:1002px; left:197px;"/>
<input type="text" name="m186r273" id="m186r273" style="width:102px; top:1002px; left:311px;"/>
<input type="text" name="m186r274" id="m186r274" style="width:114px; top:1002px; left:424px;"/>
<input type="text" name="m186r275" id="m186r275" style="width:115px; top:1002px; left:548px;"/>
<input type="text" name="m186r276" id="m186r276" style="width:102px; top:1002px; left:673px;"/>
<input type="text" name="m186r277" id="m186r277" style="width:101px; top:1002px; left:787px;"/>
<input type="text" name="m186r281" id="m186r281" style="width:87px; top:1029px; left:100px;"/>
<input type="text" name="m186r282" id="m186r282" style="width:103px; top:1029px; left:197px;"/>
<input type="text" name="m186r283" id="m186r283" style="width:102px; top:1029px; left:311px;"/>
<input type="text" name="m186r284" id="m186r284" style="width:114px; top:1029px; left:424px;"/>
<input type="text" name="m186r285" id="m186r285" style="width:115px; top:1029px; left:548px;"/>
<input type="text" name="m186r286" id="m186r286" style="width:102px; top:1029px; left:673px;"/>
<input type="text" name="m186r287" id="m186r287" style="width:101px; top:1029px; left:787px;"/>
<input type="text" name="m186r291" id="m186r291" style="width:87px; top:1056px; left:100px;"/>
<input type="text" name="m186r292" id="m186r292" style="width:103px; top:1056px; left:197px;"/>
<input type="text" name="m186r293" id="m186r293" style="width:102px; top:1056px; left:311px;"/>
<input type="text" name="m186r294" id="m186r294" style="width:114px; top:1056px; left:424px;"/>
<input type="text" name="m186r295" id="m186r295" style="width:115px; top:1056px; left:548px;"/>
<input type="text" name="m186r296" id="m186r296" style="width:102px; top:1056px; left:673px;"/>
<input type="text" name="m186r297" id="m186r297" style="width:101px; top:1056px; left:787px;"/>
<input type="text" name="m186r301" id="m186r301" style="width:87px; top:1084px; left:100px;"/>
<input type="text" name="m186r302" id="m186r302" style="width:103px; top:1084px; left:197px;"/>
<input type="text" name="m186r303" id="m186r303" style="width:102px; top:1084px; left:311px;"/>
<input type="text" name="m186r304" id="m186r304" style="width:114px; top:1084px; left:424px;"/>
<input type="text" name="m186r305" id="m186r305" style="width:115px; top:1084px; left:548px;"/>
<input type="text" name="m186r306" id="m186r306" style="width:102px; top:1084px; left:673px;"/>
<input type="text" name="m186r307" id="m186r307" style="width:101px; top:1084px; left:787px;"/>
<span class="text-echo" style="top:1116px; right:648px;"><?php echo $m186r992; ?></span>
<span class="text-echo" style="top:1116px; right:536px;"><?php echo $m186r993; ?></span>
<span class="text-echo" style="top:1116px; right:411px;"><?php echo $m186r994; ?></span>
<span class="text-echo" style="top:1116px; right:285px;"><?php echo $m186r995; ?></span>
<span class="text-echo" style="top:1116px; right:173px;"><?php echo $m186r996; ?></span>
<span class="text-echo" style="top:1116px; right:60px;"><?php echo $m186r997; ?></span>
<?php                                        } ?>


<?php if ( $strana == 10 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str10.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 10.strana 240kB">
<span class="text-echo" style="top:79px; left:480px; font-size:16px; letter-spacing:25px;"><?php echo $fir_ficox; ?></span>

<!-- modul 187 -->
<input type="text" name="m187r1" id="m187r1" style="width:100px; top:208px; left:675px;"/>

<!-- modul 100101 -->
<input type="checkbox" name="m1590r1a" value="1" onclick="klikm1590r1ano();" style="top:322px; left:839px;"/>
<input type="checkbox" name="m1590r1b" value="1" onclick="klikm1590r1nie();" style="top:342px; left:839px;"/>

<!-- modul 100102 -->
<input type="checkbox" name="m1590r2a" value="1" onclick="klikm1590r2ano();" style="top:469px; left:839px;"/>
<input type="checkbox" name="m1590r2b" value="1" onclick="klikm1590r2nie();" style="top:490px; left:839px;"/>

<!-- modul 590 -->
<input type="text" name="m590r11" id="m590r11" style="width:124px; top:707px; left:100px;"/>
<input type="text" name="m590r12" id="m590r12" style="width:178px; top:707px; left:235px;"/>
<input type="text" name="m590r13" id="m590r13" style="width:159px; top:707px; left:424px;"/>
<input type="text" name="m590r14" id="m590r14" style="width:147px; top:707px; left:594px;"/>
<input type="text" name="m590r15" id="m590r15" style="width:136px; top:707px; left:752px;"/>
<input type="text" name="m590r21" id="m590r21" style="width:124px; top:732px; left:100px;"/>
<input type="text" name="m590r22" id="m590r22" style="width:178px; top:732px; left:235px;"/>
<input type="text" name="m590r23" id="m590r23" style="width:159px; top:732px; left:424px;"/>
<input type="text" name="m590r24" id="m590r24" style="width:147px; top:732px; left:594px;"/>
<input type="text" name="m590r25" id="m590r25" style="width:136px; top:732px; left:752px;"/>
<input type="text" name="m590r31" id="m590r31" style="width:124px; top:758px; left:100px;"/>
<input type="text" name="m590r32" id="m590r32" style="width:178px; top:758px; left:235px;"/>
<input type="text" name="m590r33" id="m590r33" style="width:159px; top:758px; left:424px;"/>
<input type="text" name="m590r34" id="m590r34" style="width:147px; top:758px; left:594px;"/>
<input type="text" name="m590r35" id="m590r35" style="width:136px; top:758px; left:752px;"/>
<input type="text" name="m590r41" id="m590r41" style="width:124px; top:783px; left:100px;"/>
<input type="text" name="m590r42" id="m590r42" style="width:178px; top:783px; left:235px;"/>
<input type="text" name="m590r43" id="m590r43" style="width:159px; top:783px; left:424px;"/>
<input type="text" name="m590r44" id="m590r44" style="width:147px; top:783px; left:594px;"/>
<input type="text" name="m590r45" id="m590r45" style="width:136px; top:783px; left:752px;"/>
<input type="text" name="m590r51" id="m590r51" style="width:124px; top:808px; left:100px;"/>
<input type="text" name="m590r52" id="m590r52" style="width:178px; top:808px; left:235px;"/>
<input type="text" name="m590r53" id="m590r53" style="width:159px; top:808px; left:424px;"/>
<input type="text" name="m590r54" id="m590r54" style="width:147px; top:808px; left:594px;"/>
<input type="text" name="m590r55" id="m590r55" style="width:136px; top:808px; left:752px;"/>
<input type="text" name="m590r61" id="m590r61" style="width:124px; top:833px; left:100px;"/>
<input type="text" name="m590r62" id="m590r62" style="width:178px; top:833px; left:235px;"/>
<input type="text" name="m590r63" id="m590r63" style="width:159px; top:833px; left:424px;"/>
<input type="text" name="m590r64" id="m590r64" style="width:147px; top:833px; left:594px;"/>
<input type="text" name="m590r65" id="m590r65" style="width:136px; top:833px; left:752px;"/>
<input type="text" name="m590r71" id="m590r71" style="width:124px; top:859px; left:100px;"/>
<input type="text" name="m590r72" id="m590r72" style="width:178px; top:859px; left:235px;"/>
<input type="text" name="m590r73" id="m590r73" style="width:159px; top:859px; left:424px;"/>
<input type="text" name="m590r74" id="m590r74" style="width:147px; top:859px; left:594px;"/>
<input type="text" name="m590r75" id="m590r75" style="width:136px; top:859px; left:752px;"/>
<input type="text" name="m590r81" id="m590r81" style="width:124px; top:884px; left:100px;"/>
<input type="text" name="m590r82" id="m590r82" style="width:178px; top:884px; left:235px;"/>
<input type="text" name="m590r83" id="m590r83" style="width:159px; top:884px; left:424px;"/>
<input type="text" name="m590r84" id="m590r84" style="width:147px; top:884px; left:594px;"/>
<input type="text" name="m590r85" id="m590r85" style="width:136px; top:884px; left:752px;"/>
<input type="text" name="m590r91" id="m590r91" style="width:124px; top:909px; left:100px;"/>
<input type="text" name="m590r92" id="m590r92" style="width:178px; top:909px; left:235px;"/>
<input type="text" name="m590r93" id="m590r93" style="width:159px; top:909px; left:424px;"/>
<input type="text" name="m590r94" id="m590r94" style="width:147px; top:909px; left:594px;"/>
<input type="text" name="m590r95" id="m590r95" style="width:136px; top:909px; left:752px;"/>
<input type="text" name="m590r101" id="m590r101" style="width:124px; top:934px; left:100px;"/>
<input type="text" name="m590r102" id="m590r102" style="width:178px; top:934px; left:235px;"/>
<input type="text" name="m590r103" id="m590r103" style="width:159px; top:934px; left:424px;"/>
<input type="text" name="m590r104" id="m590r104" style="width:147px; top:934px; left:594px;"/>
<input type="text" name="m590r105" id="m590r105" style="width:136px; top:934px; left:752px;"/>
<input type="text" name="m590r111" id="m590r111" style="width:124px; top:960px; left:100px;"/>
<input type="text" name="m590r112" id="m590r112" style="width:178px; top:960px; left:235px;"/>
<input type="text" name="m590r113" id="m590r113" style="width:159px; top:960px; left:424px;"/>
<input type="text" name="m590r114" id="m590r114" style="width:147px; top:960px; left:594px;"/>
<input type="text" name="m590r115" id="m590r115" style="width:136px; top:960px; left:752px;"/>
<input type="text" name="m590r121" id="m590r121" style="width:124px; top:985px; left:100px;"/>
<input type="text" name="m590r122" id="m590r122" style="width:178px; top:985px; left:235px;"/>
<input type="text" name="m590r123" id="m590r123" style="width:159px; top:985px; left:424px;"/>
<input type="text" name="m590r124" id="m590r124" style="width:147px; top:985px; left:594px;"/>
<input type="text" name="m590r125" id="m590r125" style="width:136px; top:985px; left:752px;"/>
<input type="text" name="m590r131" id="m590r131" style="width:124px; top:1010px; left:100px;"/>
<input type="text" name="m590r132" id="m590r132" style="width:178px; top:1010px; left:235px;"/>
<input type="text" name="m590r133" id="m590r133" style="width:159px; top:1010px; left:424px;"/>
<input type="text" name="m590r134" id="m590r134" style="width:147px; top:1010px; left:594px;"/>
<input type="text" name="m590r135" id="m590r135" style="width:136px; top:1010px; left:752px;"/>
<input type="text" name="m590r141" id="m590r141" style="width:124px; top:1035px; left:100px;"/>
<input type="text" name="m590r142" id="m590r142" style="width:178px; top:1035px; left:235px;"/>
<input type="text" name="m590r143" id="m590r143" style="width:159px; top:1035px; left:424px;"/>
<input type="text" name="m590r144" id="m590r144" style="width:147px; top:1035px; left:594px;"/>
<input type="text" name="m590r145" id="m590r145" style="width:136px; top:1035px; left:752px;"/>
<input type="text" name="m590r151" id="m590r151" style="width:124px; top:1061px; left:100px;"/>
<input type="text" name="m590r152" id="m590r152" style="width:178px; top:1061px; left:235px;"/>
<input type="text" name="m590r153" id="m590r153" style="width:159px; top:1061px; left:424px;"/>
<input type="text" name="m590r154" id="m590r154" style="width:147px; top:1061px; left:594px;"/>
<input type="text" name="m590r155" id="m590r155" style="width:136px; top:1061px; left:752px;"/>
<input type="text" name="m590r161" id="m590r161" style="width:124px; top:1086px; left:100px;"/>
<input type="text" name="m590r162" id="m590r162" style="width:178px; top:1086px; left:235px;"/>
<input type="text" name="m590r163" id="m590r163" style="width:159px; top:1086px; left:424px;"/>
<input type="text" name="m590r164" id="m590r164" style="width:147px; top:1086px; left:594px;"/>
<input type="text" name="m590r165" id="m590r165" style="width:136px; top:1086px; left:752px;"/>
<input type="text" name="m590r171" id="m590r171" style="width:124px; top:1111px; left:100px;"/>
<input type="text" name="m590r172" id="m590r172" style="width:178px; top:1111px; left:235px;"/>
<input type="text" name="m590r173" id="m590r173" style="width:159px; top:1111px; left:424px;"/>
<input type="text" name="m590r174" id="m590r174" style="width:147px; top:1111px; left:594px;"/>
<input type="text" name="m590r175" id="m590r175" style="width:136px; top:1111px; left:752px;"/>
<input type="text" name="m590r181" id="m590r181" style="width:124px; top:1136px; left:100px;"/>
<input type="text" name="m590r182" id="m590r182" style="width:178px; top:1136px; left:235px;"/>
<input type="text" name="m590r183" id="m590r183" style="width:159px; top:1136px; left:424px;"/>
<input type="text" name="m590r184" id="m590r184" style="width:147px; top:1136px; left:594px;"/>
<input type="text" name="m590r185" id="m590r185" style="width:136px; top:1136px; left:752px;"/>
<input type="text" name="m590r191" id="m590r191" style="width:124px; top:1162px; left:100px;"/>
<input type="text" name="m590r192" id="m590r192" style="width:178px; top:1162px; left:235px;"/>
<input type="text" name="m590r193" id="m590r193" style="width:159px; top:1162px; left:424px;"/>
<input type="text" name="m590r194" id="m590r194" style="width:147px; top:1162px; left:594px;"/>
<input type="text" name="m590r195" id="m590r195" style="width:136px; top:1162px; left:752px;"/>
<input type="text" name="m590r201" id="m590r201" style="width:124px; top:1187px; left:100px;"/>
<input type="text" name="m590r202" id="m590r202" style="width:178px; top:1187px; left:235px;"/>
<input type="text" name="m590r203" id="m590r203" style="width:159px; top:1187px; left:424px;"/>
<input type="text" name="m590r204" id="m590r204" style="width:147px; top:1187px; left:594px;"/>
<input type="text" name="m590r205" id="m590r205" style="width:136px; top:1187px; left:752px;"/>
<span class="text-echo" style="top:1218px; right:535px;"><?php echo $m590r992; ?></span>
<span class="text-echo" style="top:1218px; right:376px;"><?php echo $m590r993; ?></span>
<span class="text-echo" style="top:1218px; right:218px;"><?php echo $m590r994; ?></span>
<span class="text-echo" style="top:1218px; right:60px;"><?php echo $m590r995; ?></span>
<?php                                        } ?>


<?php if ( $strana == 11 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str11.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 11.strana 277kB">
<span class="text-echo" style="top:79px; left:480px; font-size:16px; letter-spacing:25px;"><?php echo $fir_ficox; ?></span>

<!-- modul 304 -->
<img src="../obr/ikony/download_blue_icon.png" title="Naèíta údaje z miezd" onclick="NacitajMzdy();" style="top:158px; left:378px;" class="btn-row-tool">
<input type="text" name="m304r1" id="m304r1" style="width:100px; top:282px; left:755px;"/>
<input type="text" name="m304r2" id="m304r2" style="width:100px; top:314px; left:755px;"/>
<input type="text" name="m304r3" id="m304r3" style="width:100px; top:346px; left:755px;"/>
<input type="text" name="m304r4" id="m304r4" style="width:100px; top:378px; left:755px;"/>
<input type="text" name="m304r5" id="m304r5" style="width:100px; top:410px; left:755px;"/>
<input type="text" name="m304r6" id="m304r6" style="width:100px; top:442px; left:755px;"/>
<input type="text" name="m304r7" id="m304r7" style="width:100px; top:476px; left:755px;"/>
<input type="text" name="m304r8" id="m304r8" style="width:100px; top:512px; left:755px;"/>
<input type="text" name="m304r9" id="m304r9" style="width:100px; top:547px; left:755px;"/>
<input type="text" name="m304r10" id="m304r10" style="width:100px; top:579px; left:755px;"/>
<input type="text" name="m304r11" id="m304r11" style="width:100px; top:610px; left:755px;"/>
<input type="text" name="m304r12" id="m304r12" style="width:100px; top:642px; left:755px;"/>
<input type="text" name="m304r13" id="m304r13" style="width:100px; top:674px; left:755px;"/>
<input type="text" name="m304r14" id="m304r14" style="width:100px; top:706px; left:755px;"/>
<input type="text" name="m304r15" id="m304r15" style="width:100px; top:737px; left:755px;"/>
<input type="text" name="m304r16" id="m304r16" style="width:100px; top:769px; left:755px;"/>
<span class="text-echo" style="top:805px; right:95px;"><?php echo $m304r99; ?></span>
<?php                                        } ?>


<?php if ( $strana == 12 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str12.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 12.strana 274kB">
<span class="text-echo" style="top:77px; left:480px; font-size:16px; letter-spacing:25px;"><?php echo $fir_ficox; ?></span>

<!-- modul 110 -->
<input type="text" name="m110r12" id="m110r12" style="width:58px; top:297px; left:344px;"/>
<input type="text" name="m110r13" id="m110r13" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:297px; left:413px;"/>
<input type="text" name="m110r14" id="m110r14" style="width:68px; top:297px; left:481px;"/>
<input type="text" name="m110r15" id="m110r15" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:297px; left:560px;"/>
<input type="text" name="m110r16" id="m110r16" style="width:57px; top:297px; left:628px;"/>
<input type="text" name="m110r17" id="m110r17" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:297px; left:696px;"/>
<input type="text" name="m110r18" id="m110r18" style="width:68px; top:297px; left:775px;"/>
<input type="text" name="m110r19" id="m110r19" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:297px; left:854px;"/>
<input type="text" name="m110r22" id="m110r22" style="width:58px; top:320px; left:344px;"/>
<input type="text" name="m110r23" id="m110r23" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:320px; left:413px;"/>
<input type="text" name="m110r24" id="m110r24" style="width:68px; top:320px; left:481px;"/>
<input type="text" name="m110r25" id="m110r25" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:320px; left:560px;"/>
<input type="text" name="m110r26" id="m110r26" style="width:57px; top:320px; left:628px;"/>
<input type="text" name="m110r27" id="m110r27" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:320px; left:696px;"/>
<input type="text" name="m110r28" id="m110r28" style="width:68px; top:320px; left:775px;"/>
<input type="text" name="m110r29" id="m110r29" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:320px; left:854px;"/>
<input type="text" name="m110r32" id="m110r32" style="width:58px; top:343px; left:344px;"/>
<input type="text" name="m110r33" id="m110r33" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:343px; left:413px;"/>
<input type="text" name="m110r34" id="m110r34" style="width:68px; top:343px; left:481px;"/>
<input type="text" name="m110r35" id="m110r35" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:343px; left:560px;"/>
<input type="text" name="m110r36" id="m110r36" style="width:57px; top:343px; left:628px;"/>
<input type="text" name="m110r37" id="m110r37" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:343px; left:696px;"/>
<input type="text" name="m110r38" id="m110r38" style="width:68px; top:343px; left:775px;"/>
<input type="text" name="m110r39" id="m110r39" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:343px; left:854px;"/>
<input type="text" name="m110r42" id="m110r42" style="width:58px; top:366px; left:344px;"/>
<input type="text" name="m110r43" id="m110r43" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:366px; left:413px;"/>
<input type="text" name="m110r44" id="m110r44" style="width:68px; top:366px; left:481px;"/>
<input type="text" name="m110r45" id="m110r45" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:366px; left:560px;"/>
<input type="text" name="m110r46" id="m110r46" style="width:57px; top:366px; left:628px;"/>
<input type="text" name="m110r47" id="m110r47" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:366px; left:696px;"/>
<input type="text" name="m110r48" id="m110r48" style="width:68px; top:366px; left:775px;"/>
<input type="text" name="m110r49" id="m110r49" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:366px; left:854px;"/>
<input type="text" name="m110r52" id="m110r52" style="width:58px; top:389px; left:344px;"/>
<input type="text" name="m110r53" id="m110r53" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:389px; left:413px;"/>
<input type="text" name="m110r54" id="m110r54" style="width:68px; top:389px; left:481px;"/>
<input type="text" name="m110r55" id="m110r55" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:389px; left:560px;"/>
<input type="text" name="m110r56" id="m110r56" style="width:57px; top:389px; left:628px;"/>
<input type="text" name="m110r57" id="m110r57" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:389px; left:696px;"/>
<input type="text" name="m110r58" id="m110r58" style="width:68px; top:389px; left:775px;"/>
<input type="text" name="m110r59" id="m110r59" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:389px; left:854px;"/>
<input type="text" name="m110r62" id="m110r62" style="width:58px; top:412px; left:344px;"/>
<input type="text" name="m110r63" id="m110r63" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:412px; left:413px;"/>
<input type="text" name="m110r64" id="m110r64" style="width:68px; top:412px; left:481px;"/>
<input type="text" name="m110r65" id="m110r65" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:412px; left:560px;"/>
<input type="text" name="m110r66" id="m110r66" style="width:57px; top:412px; left:628px;"/>
<input type="text" name="m110r67" id="m110r67" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:412px; left:696px;"/>
<input type="text" name="m110r68" id="m110r68" style="width:68px; top:412px; left:775px;"/>
<input type="text" name="m110r69" id="m110r69" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:412px; left:854px;"/>
<input type="text" name="m110r72" id="m110r72" style="width:58px; top:435px; left:344px;"/>
<input type="text" name="m110r73" id="m110r73" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:435px; left:413px;"/>
<input type="text" name="m110r74" id="m110r74" style="width:68px; top:435px; left:481px;"/>
<input type="text" name="m110r75" id="m110r75" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:435px; left:560px;"/>
<input type="text" name="m110r76" id="m110r76" style="width:57px; top:435px; left:628px;"/>
<input type="text" name="m110r77" id="m110r77" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:435px; left:696px;"/>
<input type="text" name="m110r78" id="m110r78" style="width:68px; top:435px; left:775px;"/>
<input type="text" name="m110r79" id="m110r79" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:435px; left:854px;"/>
<input type="text" name="m110r82" id="m110r82" style="width:58px; top:458px; left:344px;"/>
<input type="text" name="m110r83" id="m110r83" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:458px; left:413px;"/>
<input type="text" name="m110r84" id="m110r84" style="width:68px; top:458px; left:481px;"/>
<input type="text" name="m110r85" id="m110r85" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:458px; left:560px;"/>
<input type="text" name="m110r86" id="m110r86" style="width:57px; top:458px; left:628px;"/>
<input type="text" name="m110r87" id="m110r87" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:458px; left:696px;"/>
<input type="text" name="m110r88" id="m110r88" style="width:68px; top:458px; left:775px;"/>
<input type="text" name="m110r89" id="m110r89" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:458px; left:854px;"/>
<input type="text" name="m110r92" id="m110r92" style="width:58px; top:481px; left:344px;"/>
<input type="text" name="m110r93" id="m110r93" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:481px; left:413px;"/>
<input type="text" name="m110r94" id="m110r94" style="width:68px; top:481px; left:481px;"/>
<input type="text" name="m110r95" id="m110r95" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:481px; left:560px;"/>
<input type="text" name="m110r96" id="m110r96" style="width:57px; top:481px; left:628px;"/>
<input type="text" name="m110r97" id="m110r97" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:481px; left:696px;"/>
<input type="text" name="m110r98" id="m110r98" style="width:68px; top:481px; left:775px;"/>
<input type="text" name="m110r99" id="m110r99" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:481px; left:854px;"/>
<input type="text" name="m110r102" id="m110r102" style="width:58px; top:509px; left:344px;"/>
<input type="text" name="m110r103" id="m110r103" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:509px; left:413px;"/>
<input type="text" name="m110r104" id="m110r104" style="width:68px; top:509px; left:481px;"/>
<input type="text" name="m110r105" id="m110r105" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:509px; left:560px;"/>
<input type="text" name="m110r106" id="m110r106" style="width:57px; top:509px; left:628px;"/>
<input type="text" name="m110r107" id="m110r107" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:509px; left:696px;"/>
<input type="text" name="m110r108" id="m110r108" style="width:68px; top:509px; left:775px;"/>
<input type="text" name="m110r109" id="m110r109" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:509px; left:854px;"/>
<input type="text" name="m110r112" id="m110r112" style="width:58px; top:536px; left:344px;"/>
<input type="text" name="m110r113" id="m110r113" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:536px; left:413px;"/>
<input type="text" name="m110r114" id="m110r114" style="width:68px; top:536px; left:481px;"/>
<input type="text" name="m110r115" id="m110r115" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:536px; left:560px;"/>
<input type="text" name="m110r116" id="m110r116" style="width:57px; top:536px; left:628px;"/>
<input type="text" name="m110r117" id="m110r117" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:536px; left:696px;"/>
<input type="text" name="m110r118" id="m110r118" style="width:68px; top:536px; left:775px;"/>
<input type="text" name="m110r119" id="m110r119" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:536px; left:854px;"/>
<input type="text" name="m110r122" id="m110r122" style="width:58px; top:560px; left:344px;"/>
<input type="text" name="m110r123" id="m110r123" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:560px; left:413px;"/>
<input type="text" name="m110r124" id="m110r124" style="width:68px; top:560px; left:481px;"/>
<input type="text" name="m110r125" id="m110r125" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:560px; left:560px;"/>
<input type="text" name="m110r126" id="m110r126" style="width:57px; top:560px; left:628px;"/>
<input type="text" name="m110r127" id="m110r127" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:560px; left:696px;"/>
<input type="text" name="m110r128" id="m110r128" style="width:68px; top:560px; left:775px;"/>
<input type="text" name="m110r129" id="m110r129" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:560px; left:854px;"/>
<input type="text" name="m110r132" id="m110r132" style="width:58px; top:583px; left:344px;"/>
<input type="text" name="m110r133" id="m110r133" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:583px; left:413px;"/>
<input type="text" name="m110r134" id="m110r134" style="width:68px; top:583px; left:481px;"/>
<input type="text" name="m110r135" id="m110r135" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:583px; left:560px;"/>
<input type="text" name="m110r136" id="m110r136" style="width:57px; top:583px; left:628px;"/>
<input type="text" name="m110r137" id="m110r137" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:583px; left:696px;"/>
<input type="text" name="m110r138" id="m110r138" style="width:68px; top:583px; left:775px;"/>
<input type="text" name="m110r139" id="m110r139" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:583px; left:854px;"/>
<input type="text" name="m110r142" id="m110r142" style="width:58px; top:611px; left:344px;"/>
<input type="text" name="m110r143" id="m110r143" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:611px; left:413px;"/>
<input type="text" name="m110r144" id="m110r144" style="width:68px; top:611px; left:481px;"/>
<input type="text" name="m110r145" id="m110r145" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:611px; left:560px;"/>
<input type="text" name="m110r146" id="m110r146" style="width:57px; top:611px; left:628px;"/>
<input type="text" name="m110r147" id="m110r147" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:611px; left:696px;"/>
<input type="text" name="m110r148" id="m110r148" style="width:68px; top:611px; left:775px;"/>
<input type="text" name="m110r149" id="m110r149" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:611px; left:854px;"/>
<input type="text" name="m110r152" id="m110r152" style="width:58px; top:639px; left:344px;"/>
<input type="text" name="m110r153" id="m110r153" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:639px; left:413px;"/>
<input type="text" name="m110r154" id="m110r154" style="width:68px; top:639px; left:481px;"/>
<input type="text" name="m110r155" id="m110r155" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:639px; left:560px;"/>
<input type="text" name="m110r156" id="m110r156" style="width:57px; top:639px; left:628px;"/>
<input type="text" name="m110r157" id="m110r157" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:639px; left:696px;"/>
<input type="text" name="m110r158" id="m110r158" style="width:68px; top:639px; left:775px;"/>
<input type="text" name="m110r159" id="m110r159" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:639px; left:854px;"/>
<input type="text" name="m110r162" id="m110r162" style="width:58px; top:662px; left:344px;"/>
<input type="text" name="m110r163" id="m110r163" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:662px; left:413px;"/>
<input type="text" name="m110r164" id="m110r164" style="width:68px; top:662px; left:481px;"/>
<input type="text" name="m110r165" id="m110r165" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:662px; left:560px;"/>
<input type="text" name="m110r166" id="m110r166" style="width:57px; top:662px; left:628px;"/>
<input type="text" name="m110r167" id="m110r167" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:662px; left:696px;"/>
<input type="text" name="m110r168" id="m110r168" style="width:68px; top:662px; left:775px;"/>
<input type="text" name="m110r169" id="m110r169" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:662px; left:854px;"/>
<input type="text" name="m110r172" id="m110r172" style="width:58px; top:685px; left:344px;"/>
<input type="text" name="m110r173" id="m110r173" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:685px; left:413px;"/>
<input type="text" name="m110r174" id="m110r174" style="width:68px; top:685px; left:481px;"/>
<input type="text" name="m110r175" id="m110r175" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:685px; left:560px;"/>
<input type="text" name="m110r176" id="m110r176" style="width:57px; top:685px; left:628px;"/>
<input type="text" name="m110r177" id="m110r177" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:685px; left:696px;"/>
<input type="text" name="m110r178" id="m110r178" style="width:68px; top:685px; left:775px;"/>
<input type="text" name="m110r179" id="m110r179" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:685px; left:854px;"/>
<input type="text" name="m110r182" id="m110r182" style="width:58px; top:708px; left:344px;"/>
<input type="text" name="m110r183" id="m110r183" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:708px; left:413px;"/>
<input type="text" name="m110r184" id="m110r184" style="width:68px; top:708px; left:481px;"/>
<input type="text" name="m110r185" id="m110r185" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:708px; left:560px;"/>
<input type="text" name="m110r186" id="m110r186" style="width:57px; top:708px; left:628px;"/>
<input type="text" name="m110r187" id="m110r187" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:708px; left:696px;"/>
<input type="text" name="m110r188" id="m110r188" style="width:68px; top:708px; left:775px;"/>
<input type="text" name="m110r189" id="m110r189" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:708px; left:854px;"/>
<input type="text" name="m110r192" id="m110r192" style="width:58px; top:731px; left:344px;"/>
<input type="text" name="m110r193" id="m110r193" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:731px; left:413px;"/>
<input type="text" name="m110r194" id="m110r194" style="width:68px; top:731px; left:481px;"/>
<input type="text" name="m110r195" id="m110r195" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:731px; left:560px;"/>
<input type="text" name="m110r196" id="m110r196" style="width:57px; top:731px; left:628px;"/>
<input type="text" name="m110r197" id="m110r197" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:731px; left:696px;"/>
<input type="text" name="m110r198" id="m110r198" style="width:68px; top:731px; left:775px;"/>
<input type="text" name="m110r199" id="m110r199" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:731px; left:854px;"/>
<input type="text" name="m110r202" id="m110r202" style="width:58px; top:754px; left:344px;"/>
<input type="text" name="m110r203" id="m110r203" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:754px; left:413px;"/>
<input type="text" name="m110r204" id="m110r204" style="width:68px; top:754px; left:481px;"/>
<input type="text" name="m110r205" id="m110r205" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:754px; left:560px;"/>
<input type="text" name="m110r206" id="m110r206" style="width:57px; top:754px; left:628px;"/>
<input type="text" name="m110r207" id="m110r207" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:754px; left:696px;"/>
<input type="text" name="m110r208" id="m110r208" style="width:68px; top:754px; left:775px;"/>
<input type="text" name="m110r209" id="m110r209" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:754px; left:854px;"/>
<input type="text" name="m110r212" id="m110r212" style="width:58px; top:777px; left:344px;"/>
<input type="text" name="m110r213" id="m110r213" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:777px; left:413px;"/>
<input type="text" name="m110r214" id="m110r214" style="width:68px; top:777px; left:481px;"/>
<input type="text" name="m110r215" id="m110r215" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:777px; left:560px;"/>
<input type="text" name="m110r216" id="m110r216" style="width:57px; top:777px; left:628px;"/>
<input type="text" name="m110r217" id="m110r217" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:777px; left:696px;"/>
<input type="text" name="m110r218" id="m110r218" style="width:68px; top:777px; left:775px;"/>
<input type="text" name="m110r219" id="m110r219" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:777px; left:854px;"/>
<input type="text" name="m110r222" id="m110r222" style="width:58px; top:800px; left:344px;"/>
<input type="text" name="m110r224" id="m110r224" style="width:68px; top:800px; left:481px;"/>
<input type="text" name="m110r226" id="m110r226" style="width:57px; top:800px; left:628px;"/>
<input type="text" name="m110r228" id="m110r228" style="width:68px; top:800px; left:775px;"/>
<input type="text" name="m110r232" id="m110r232" style="width:58px; top:823px; left:344px;"/>
<input type="text" name="m110r234" id="m110r234" style="width:68px; top:823px; left:481px;"/>
<input type="text" name="m110r236" id="m110r236" style="width:57px; top:823px; left:628px;"/>
<input type="text" name="m110r238" id="m110r238" style="width:68px; top:823px; left:775px;"/>
<input type="text" name="m110r242" id="m110r242" style="width:58px; top:846px; left:344px;"/>
<input type="text" name="m110r243" id="m110r243" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:846px; left:413px;"/>
<input type="text" name="m110r244" id="m110r244" style="width:68px; top:846px; left:481px;"/>
<input type="text" name="m110r245" id="m110r245" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:846px; left:560px;"/>
<input type="text" name="m110r246" id="m110r246" style="width:57px; top:846px; left:628px;"/>
<input type="text" name="m110r247" id="m110r247" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:846px; left:696px;"/>
<input type="text" name="m110r248" id="m110r248" style="width:68px; top:846px; left:775px;"/>
<input type="text" name="m110r249" id="m110r249" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:846px; left:854px;"/>
<input type="text" name="m110r252" id="m110r252" style="width:58px; top:869px; left:344px;"/>
<input type="text" name="m110r253" id="m110r253" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:869px; left:413px;"/>
<input type="text" name="m110r254" id="m110r254" style="width:68px; top:869px; left:481px;"/>
<input type="text" name="m110r255" id="m110r255" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:869px; left:560px;"/>
<input type="text" name="m110r256" id="m110r256" style="width:57px; top:869px; left:628px;"/>
<input type="text" name="m110r257" id="m110r257" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:869px; left:696px;"/>
<input type="text" name="m110r258" id="m110r258" style="width:68px; top:869px; left:775px;"/>
<input type="text" name="m110r259" id="m110r259" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:869px; left:854px;"/>
<input type="text" name="m110r262" id="m110r262" style="width:58px; top:892px; left:344px;"/>
<input type="text" name="m110r263" id="m110r263" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:892px; left:413px;"/>
<input type="text" name="m110r264" id="m110r264" style="width:68px; top:892px; left:481px;"/>
<input type="text" name="m110r265" id="m110r265" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:892px; left:560px;"/>
<input type="text" name="m110r266" id="m110r266" style="width:57px; top:892px; left:628px;"/>
<input type="text" name="m110r267" id="m110r267" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:892px; left:696px;"/>
<input type="text" name="m110r268" id="m110r268" style="width:68px; top:892px; left:775px;"/>
<input type="text" name="m110r269" id="m110r269" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:892px; left:854px;"/>
<input type="text" name="m110r272" id="m110r272" style="width:58px; top:915px; left:344px;"/>
<input type="text" name="m110r273" id="m110r273" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:915px; left:413px;"/>
<input type="text" name="m110r274" id="m110r274" style="width:68px; top:915px; left:481px;"/>
<input type="text" name="m110r275" id="m110r275" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:915px; left:560px;"/>
<input type="text" name="m110r276" id="m110r276" style="width:57px; top:915px; left:628px;"/>
<input type="text" name="m110r277" id="m110r277" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:915px; left:696px;"/>
<input type="text" name="m110r278" id="m110r278" style="width:68px; top:915px; left:775px;"/>
<input type="text" name="m110r279" id="m110r279" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:915px; left:854px;"/>
<input type="text" name="m110r282" id="m110r282" style="width:58px; top:938px; left:344px;"/>
<input type="text" name="m110r283" id="m110r283" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:938px; left:413px;"/>
<input type="text" name="m110r284" id="m110r284" style="width:68px; top:938px; left:481px;"/>
<input type="text" name="m110r285" id="m110r285" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:938px; left:560px;"/>
<input type="text" name="m110r286" id="m110r286" style="width:57px; top:938px; left:628px;"/>
<input type="text" name="m110r287" id="m110r287" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:938px; left:696px;"/>
<input type="text" name="m110r288" id="m110r288" style="width:68px; top:938px; left:775px;"/>
<input type="text" name="m110r289" id="m110r289" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:938px; left:854px;"/>
<input type="text" name="m110r292" id="m110r292" style="width:58px; top:961px; left:344px;"/>
<input type="text" name="m110r293" id="m110r293" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:961px; left:413px;"/>
<input type="text" name="m110r294" id="m110r294" style="width:68px; top:961px; left:481px;"/>
<input type="text" name="m110r295" id="m110r295" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:961px; left:560px;"/>
<input type="text" name="m110r296" id="m110r296" style="width:57px; top:961px; left:628px;"/>
<input type="text" name="m110r297" id="m110r297" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:961px; left:696px;"/>
<input type="text" name="m110r298" id="m110r298" style="width:68px; top:961px; left:775px;"/>
<input type="text" name="m110r299" id="m110r299" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:961px; left:854px;"/>
<input type="text" name="m110r302" id="m110r302" style="width:58px; top:984px; left:344px;"/>
<input type="text" name="m110r303" id="m110r303" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:984px; left:413px;"/>
<input type="text" name="m110r304" id="m110r304" style="width:68px; top:984px; left:481px;"/>
<input type="text" name="m110r305" id="m110r305" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:984px; left:560px;"/>
<input type="text" name="m110r306" id="m110r306" style="width:57px; top:984px; left:628px;"/>
<input type="text" name="m110r307" id="m110r307" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:984px; left:696px;"/>
<input type="text" name="m110r308" id="m110r308" style="width:68px; top:984px; left:775px;"/>
<input type="text" name="m110r309" id="m110r309" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:984px; left:854px;"/>
<input type="text" name="m110r312" id="m110r312" style="width:58px; top:1007px; left:344px;"/>
<input type="text" name="m110r313" id="m110r313" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:1007px; left:413px;"/>
<input type="text" name="m110r314" id="m110r314" style="width:68px; top:1007px; left:481px;"/>
<input type="text" name="m110r315" id="m110r315" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:1007px; left:560px;"/>
<input type="text" name="m110r316" id="m110r316" style="width:57px; top:1007px; left:628px;"/>
<input type="text" name="m110r317" id="m110r317" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:1007px; left:696px;"/>
<input type="text" name="m110r318" id="m110r318" style="width:68px; top:1007px; left:775px;"/>
<input type="text" name="m110r319" id="m110r319" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:1007px; left:854px;"/>
<input type="text" name="m110r322" id="m110r322" style="width:58px; top:1030px; left:344px;"/>
<input type="text" name="m110r323" id="m110r323" onkeyup="CiarkaNaBodku(this);" style="width:56px; top:1030px; left:413px;"/>
<input type="text" name="m110r324" id="m110r324" style="width:68px; top:1030px; left:481px;"/>
<input type="text" name="m110r325" id="m110r325" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:1030px; left:560px;"/>
<input type="text" name="m110r326" id="m110r326" style="width:57px; top:1030px; left:628px;"/>
<input type="text" name="m110r327" id="m110r327" onkeyup="CiarkaNaBodku(this);" style="width:68px; top:1030px; left:696px;"/>
<input type="text" name="m110r328" id="m110r328" style="width:68px; top:1030px; left:775px;"/>
<input type="text" name="m110r329" id="m110r329" onkeyup="CiarkaNaBodku(this);" style="width:57px; top:1030px; left:854px;"/>
<input type="text" name="m110r332" id="m110r332" style="width:58px; top:1053px; left:344px;"/>
<input type="text" name="m110r334" id="m110r334" style="width:68px; top:1053px; left:481px;"/>
<input type="text" name="m110r336" id="m110r336" style="width:57px; top:1053px; left:628px;"/>
<input type="text" name="m110r338" id="m110r338" style="width:68px; top:1053px; left:775px;"/>
<input type="text" name="m110r342" id="m110r342" style="width:58px; top:1076px; left:344px;"/>
<input type="text" name="m110r344" id="m110r344" style="width:68px; top:1076px; left:481px;"/>
<input type="text" name="m110r346" id="m110r346" style="width:57px; top:1076px; left:628px;"/>
<input type="text" name="m110r348" id="m110r348" style="width:68px; top:1076px; left:775px;"/>
<span class="text-echo" style="top:1103px; right:544px;"><?php echo $m110r992; ?></span>
<span class="text-echo" style="top:1103px; right:475px;"><?php echo $m110r993; ?></span>
<span class="text-echo" style="top:1103px; right:395px;"><?php echo $m110r994; ?></span>
<span class="text-echo" style="top:1103px; right:327px;"><?php echo $m110r995; ?></span>
<span class="text-echo" style="top:1103px; right:260px;"><?php echo $m110r996; ?></span>
<span class="text-echo" style="top:1103px; right:181px;"><?php echo $m110r997; ?></span>
<span class="text-echo" style="top:1103px; right:102px;"><?php echo $m110r998; ?></span>
<span class="text-echo" style="top:1103px; right:35px;"><?php echo $m110r999; ?></span>
<?php                                        } ?>

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
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=11', '_self');" class="<?php echo $clas11; ?> toleft">11</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=12', '_self');" class="<?php echo $clas12; ?> toleft">12</a>

 <INPUT type="submit" id="uloz" name="uloz" value="Uloži zmeny" class="btn-bottom-formsave">
</div>

</FORM>
</div> <!-- koniec #content -->
<?php
     }
//koniec uprav
?>


<?php
/////////////////////////////////////////////////VYTLAC VYKAZ
if ( $copern == 11 )
{
if ( File_Exists("../tmp/statistika.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/statistika.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_zav101 WHERE ico >= 0 "."";
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

if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str1.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//ico
$fir_ficx=$fir_fico;
$cfico=1*$fir_fico;
if ( $cfico < 999999 ) $fir_ficx="00".$fir_fico;
$A=substr($fir_ficx,0,1);
$B=substr($fir_ficx,1,1);
$C=substr($fir_ficx,2,1);
$D=substr($fir_ficx,3,1);
$E=substr($fir_ficx,4,1);
$F=substr($fir_ficx,5,1);
$G=substr($fir_ficx,6,1);
$H=substr($fir_ficx,7,1);
$pdf->Cell(190,58," ","$rmc1",1,"L");
$pdf->Cell(85,5," ","$rmc1",0,"L");
$pdf->Cell(9,8,"$A","$rmc",0,"C");$pdf->Cell(8,8,"$B","$rmc",0,"C");
$pdf->Cell(8,8,"$C","$rmc",0,"C");$pdf->Cell(8,8,"$D","$rmc",0,"C");
$pdf->Cell(8,8,"$E","$rmc",0,"C");$pdf->Cell(8,8,"$F","$rmc",0,"C");
$pdf->Cell(9,8,"$G","$rmc",0,"C");$pdf->Cell(8,8,"$H","$rmc",0,"C");
//p.c.zav.jednotky
$pdf->Cell(10,8,"0","$rmc",0,"C");$pdf->Cell(10,8,"0","$rmc",0,"C");
$pdf->Cell(10,8,"1","$rmc",1,"C");

//ORGANIZACIA
$pdf->Cell(190,119," ","$rmc1",1,"L");
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(153,5,"$fir_fnaz","$rmc",0,"L");
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(34,5,"$okres","$rmc",1,"C");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(153,6,"$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc","$rmc",1,"L");

//VYPLNIL
$pdf->Cell(195,9," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(70,5,"$fir_mzdt05","$rmc",0,"L");
$pdf->Cell(4,5," ","$rmc1",0,"L");$pdf->Cell(43,13,"$fir_mzdt04","$rmc",1,"L");
$pdf->Cell(195,1," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(72,6,"$fir_fem1","$rmc",0,"L");
//odoslane
$pdf->Cell(2,5," ","$rmc1",0,"L");$pdf->Cell(43,6,"$odoslane_sk","$rmc",1,"C");
                                       }

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str2.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//modul 592
$m592r11=$hlavicka->m592r11; if ( $m592r11 == 0 ) $m592r11="";
$m592r12=$hlavicka->m592r12; if ( $m592r12 == 0 ) $m592r12="";
$m592r13=$hlavicka->m592r13; if ( $m592r13 == 0 ) $m592r13="";
$m592r14=$hlavicka->m592r14; if ( $m592r14 == 0 ) $m592r14="";
$m592r15=$hlavicka->m592r15; if ( $m592r15 == 0 ) $m592r15="";
$m592r16=$hlavicka->m592r16; if ( $m592r16 == 0 ) $m592r16="";
$m592r21=$hlavicka->m592r21; if ( $m592r21 == 0 ) $m592r21="";
$m592r22=$hlavicka->m592r22; if ( $m592r22 == 0 ) $m592r22="";
$m592r23=$hlavicka->m592r23; if ( $m592r23 == 0 ) $m592r23="";
$m592r24=$hlavicka->m592r24; if ( $m592r24 == 0 ) $m592r24="";
$m592r25=$hlavicka->m592r25; if ( $m592r25 == 0 ) $m592r25="";
$m592r26=$hlavicka->m592r26; if ( $m592r26 == 0 ) $m592r26="";
$m592r31=$hlavicka->m592r31; if ( $m592r31 == 0 ) $m592r31="";
$m592r32=$hlavicka->m592r32; if ( $m592r32 == 0 ) $m592r32="";
$m592r33=$hlavicka->m592r33; if ( $m592r33 == 0 ) $m592r33="";
$m592r34=$hlavicka->m592r34; if ( $m592r34 == 0 ) $m592r34="";
$m592r35=$hlavicka->m592r35; if ( $m592r35 == 0 ) $m592r35="";
$m592r36=$hlavicka->m592r36; if ( $m592r36 == 0 ) $m592r36="";
$m592r41=$hlavicka->m592r41; if ( $m592r41 == 0 ) $m592r41="";
$m592r42=$hlavicka->m592r42; if ( $m592r42 == 0 ) $m592r42="";
$m592r43=$hlavicka->m592r43; if ( $m592r43 == 0 ) $m592r43="";
$m592r44=$hlavicka->m592r44; if ( $m592r44 == 0 ) $m592r44="";
$m592r45=$hlavicka->m592r45; if ( $m592r45 == 0 ) $m592r45="";
$m592r46=$hlavicka->m592r46; if ( $m592r46 == 0 ) $m592r46="";
$m592r51=$hlavicka->m592r51; if ( $m592r51 == 0 ) $m592r51="";
$m592r52=$hlavicka->m592r52; if ( $m592r52 == 0 ) $m592r52="";
$m592r53=$hlavicka->m592r53; if ( $m592r53 == 0 ) $m592r53="";
$m592r54=$hlavicka->m592r54; if ( $m592r54 == 0 ) $m592r54="";
$m592r55=$hlavicka->m592r55; if ( $m592r55 == 0 ) $m592r55="";
$m592r56=$hlavicka->m592r56; if ( $m592r56 == 0 ) $m592r56="";
$m592r61=$hlavicka->m592r61; if ( $m592r61 == 0 ) $m592r61="";
$m592r62=$hlavicka->m592r62; if ( $m592r62 == 0 ) $m592r62="";
$m592r63=$hlavicka->m592r63; if ( $m592r63 == 0 ) $m592r63="";
$m592r64=$hlavicka->m592r64; if ( $m592r64 == 0 ) $m592r64="";
$m592r65=$hlavicka->m592r65; if ( $m592r65 == 0 ) $m592r65="";
$m592r66=$hlavicka->m592r66; if ( $m592r66 == 0 ) $m592r66="";
$m592r71=$hlavicka->m592r71; if ( $m592r71 == 0 ) $m592r71="";
$m592r72=$hlavicka->m592r72; if ( $m592r72 == 0 ) $m592r72="";
$m592r73=$hlavicka->m592r73; if ( $m592r73 == 0 ) $m592r73="";
$m592r74=$hlavicka->m592r74; if ( $m592r74 == 0 ) $m592r74="";
$m592r75=$hlavicka->m592r75; if ( $m592r75 == 0 ) $m592r75="";
$m592r76=$hlavicka->m592r76; if ( $m592r76 == 0 ) $m592r76="";
$m592r81=$hlavicka->m592r81; if ( $m592r81 == 0 ) $m592r81="";
$m592r82=$hlavicka->m592r82; if ( $m592r82 == 0 ) $m592r82="";
$m592r83=$hlavicka->m592r83; if ( $m592r83 == 0 ) $m592r83="";
$m592r84=$hlavicka->m592r84; if ( $m592r84 == 0 ) $m592r84="";
$m592r85=$hlavicka->m592r85; if ( $m592r85 == 0 ) $m592r85="";
$m592r86=$hlavicka->m592r86; if ( $m592r86 == 0 ) $m592r86="";
$m592r91=$hlavicka->m592r91; if ( $m592r91 == 0 ) $m592r91="";
$m592r92=$hlavicka->m592r92; if ( $m592r92 == 0 ) $m592r92="";
$m592r93=$hlavicka->m592r93; if ( $m592r93 == 0 ) $m592r93="";
$m592r94=$hlavicka->m592r94; if ( $m592r94 == 0 ) $m592r94="";
$m592r95=$hlavicka->m592r95; if ( $m592r95 == 0 ) $m592r95="";
$m592r96=$hlavicka->m592r96; if ( $m592r96 == 0 ) $m592r96="";
$m592r101=$hlavicka->m592r101; if ( $m592r101 == 0 ) $m592r101="";
$m592r102=$hlavicka->m592r102; if ( $m592r102 == 0 ) $m592r102="";
$m592r103=$hlavicka->m592r103; if ( $m592r103 == 0 ) $m592r103="";
$m592r104=$hlavicka->m592r104; if ( $m592r104 == 0 ) $m592r104="";
$m592r105=$hlavicka->m592r105; if ( $m592r105 == 0 ) $m592r105="";
$m592r106=$hlavicka->m592r106; if ( $m592r106 == 0 ) $m592r106="";
$m592r111=$hlavicka->m592r111; if ( $m592r111 == 0 ) $m592r111="";
$m592r112=$hlavicka->m592r112; if ( $m592r112 == 0 ) $m592r112="";
$m592r113=$hlavicka->m592r113; if ( $m592r113 == 0 ) $m592r113="";
$m592r114=$hlavicka->m592r114; if ( $m592r114 == 0 ) $m592r114="";
$m592r115=$hlavicka->m592r115; if ( $m592r115 == 0 ) $m592r115="";
$m592r116=$hlavicka->m592r116; if ( $m592r116 == 0 ) $m592r116="";
$m592r121=$hlavicka->m592r121; if ( $m592r121 == 0 ) $m592r121="";
$m592r122=$hlavicka->m592r122; if ( $m592r122 == 0 ) $m592r122="";
$m592r123=$hlavicka->m592r123; if ( $m592r123 == 0 ) $m592r123="";
$m592r124=$hlavicka->m592r124; if ( $m592r124 == 0 ) $m592r124="";
$m592r125=$hlavicka->m592r125; if ( $m592r125 == 0 ) $m592r125="";
$m592r126=$hlavicka->m592r126; if ( $m592r126 == 0 ) $m592r126="";
$m592r131=$hlavicka->m592r131; if ( $m592r131 == 0 ) $m592r131="";
$m592r132=$hlavicka->m592r132; if ( $m592r132 == 0 ) $m592r132="";
$m592r133=$hlavicka->m592r133; if ( $m592r133 == 0 ) $m592r133="";
$m592r134=$hlavicka->m592r134; if ( $m592r134 == 0 ) $m592r134="";
$m592r135=$hlavicka->m592r135; if ( $m592r135 == 0 ) $m592r135="";
$m592r136=$hlavicka->m592r136; if ( $m592r136 == 0 ) $m592r136="";
$m592r141=$hlavicka->m592r141; if ( $m592r141 == 0 ) $m592r141="";
$m592r142=$hlavicka->m592r142; if ( $m592r142 == 0 ) $m592r142="";
$m592r143=$hlavicka->m592r143; if ( $m592r143 == 0 ) $m592r143="";
$m592r144=$hlavicka->m592r144; if ( $m592r144 == 0 ) $m592r144="";
$m592r145=$hlavicka->m592r145; if ( $m592r145 == 0 ) $m592r145="";
$m592r146=$hlavicka->m592r146; if ( $m592r146 == 0 ) $m592r146="";
$m592r151=$hlavicka->m592r151; if ( $m592r151 == 0 ) $m592r151="";
$m592r152=$hlavicka->m592r152; if ( $m592r152 == 0 ) $m592r152="";
$m592r153=$hlavicka->m592r153; if ( $m592r153 == 0 ) $m592r153="";
$m592r154=$hlavicka->m592r154; if ( $m592r154 == 0 ) $m592r154="";
$m592r155=$hlavicka->m592r155; if ( $m592r155 == 0 ) $m592r155="";
$m592r156=$hlavicka->m592r156; if ( $m592r156 == 0 ) $m592r156="";
$m592r161=$hlavicka->m592r161; if ( $m592r161 == 0 ) $m592r161="";
$m592r162=$hlavicka->m592r162; if ( $m592r162 == 0 ) $m592r162="";
$m592r163=$hlavicka->m592r163; if ( $m592r163 == 0 ) $m592r163="";
$m592r164=$hlavicka->m592r164; if ( $m592r164 == 0 ) $m592r164="";
$m592r165=$hlavicka->m592r165; if ( $m592r165 == 0 ) $m592r165="";
$m592r166=$hlavicka->m592r166; if ( $m592r166 == 0 ) $m592r166="";
$m592r171=$hlavicka->m592r171; if ( $m592r171 == 0 ) $m592r171="";
$m592r172=$hlavicka->m592r172; if ( $m592r172 == 0 ) $m592r172="";
$m592r173=$hlavicka->m592r173; if ( $m592r173 == 0 ) $m592r173="";
$m592r174=$hlavicka->m592r174; if ( $m592r174 == 0 ) $m592r174="";
$m592r175=$hlavicka->m592r175; if ( $m592r175 == 0 ) $m592r175="";
$m592r176=$hlavicka->m592r176; if ( $m592r176 == 0 ) $m592r176="";
$m592r181=$hlavicka->m592r181; if ( $m592r181 == 0 ) $m592r181="";
$m592r182=$hlavicka->m592r182; if ( $m592r182 == 0 ) $m592r182="";
$m592r183=$hlavicka->m592r183; if ( $m592r183 == 0 ) $m592r183="";
$m592r184=$hlavicka->m592r184; if ( $m592r184 == 0 ) $m592r184="";
$m592r185=$hlavicka->m592r185; if ( $m592r185 == 0 ) $m592r185="";
$m592r186=$hlavicka->m592r186; if ( $m592r186 == 0 ) $m592r186="";
$m592r191=$hlavicka->m592r191; if ( $m592r191 == 0 ) $m592r191="";
$m592r192=$hlavicka->m592r192; if ( $m592r192 == 0 ) $m592r192="";
$m592r193=$hlavicka->m592r193; if ( $m592r193 == 0 ) $m592r193="";
$m592r194=$hlavicka->m592r194; if ( $m592r194 == 0 ) $m592r194="";
$m592r195=$hlavicka->m592r195; if ( $m592r195 == 0 ) $m592r195="";
$m592r196=$hlavicka->m592r196; if ( $m592r196 == 0 ) $m592r196="";
$m592r201=$hlavicka->m592r201; if ( $m592r201 == 0 ) $m592r201="";
$m592r202=$hlavicka->m592r202; if ( $m592r202 == 0 ) $m592r202="";
$m592r203=$hlavicka->m592r203; if ( $m592r203 == 0 ) $m592r203="";
$m592r204=$hlavicka->m592r204; if ( $m592r204 == 0 ) $m592r204="";
$m592r205=$hlavicka->m592r205; if ( $m592r205 == 0 ) $m592r205="";
$m592r206=$hlavicka->m592r206; if ( $m592r206 == 0 ) $m592r206="";
$m592r211=$hlavicka->m592r211; if ( $m592r211 == 0 ) $m592r211="";
$m592r212=$hlavicka->m592r212; if ( $m592r212 == 0 ) $m592r212="";
$m592r213=$hlavicka->m592r213; if ( $m592r213 == 0 ) $m592r213="";
$m592r214=$hlavicka->m592r214; if ( $m592r214 == 0 ) $m592r214="";
$m592r215=$hlavicka->m592r215; if ( $m592r215 == 0 ) $m592r215="";
$m592r216=$hlavicka->m592r216; if ( $m592r216 == 0 ) $m592r216="";
$m592r221=$hlavicka->m592r221; if ( $m592r221 == 0 ) $m592r221="";
$m592r222=$hlavicka->m592r222; if ( $m592r222 == 0 ) $m592r222="";
$m592r223=$hlavicka->m592r223; if ( $m592r223 == 0 ) $m592r223="";
$m592r224=$hlavicka->m592r224; if ( $m592r224 == 0 ) $m592r224="";
$m592r225=$hlavicka->m592r225; if ( $m592r225 == 0 ) $m592r225="";
$m592r226=$hlavicka->m592r226; if ( $m592r226 == 0 ) $m592r226="";
$m592r231=$hlavicka->m592r231; if ( $m592r231 == 0 ) $m592r231="";
$m592r232=$hlavicka->m592r232; if ( $m592r232 == 0 ) $m592r232="";
$m592r233=$hlavicka->m592r233; if ( $m592r233 == 0 ) $m592r233="";
$m592r234=$hlavicka->m592r234; if ( $m592r234 == 0 ) $m592r234="";
$m592r235=$hlavicka->m592r235; if ( $m592r235 == 0 ) $m592r235="";
$m592r236=$hlavicka->m592r236; if ( $m592r236 == 0 ) $m592r236="";
$m592r241=$hlavicka->m592r241; if ( $m592r241 == 0 ) $m592r241="";
$m592r242=$hlavicka->m592r242; if ( $m592r242 == 0 ) $m592r242="";
$m592r243=$hlavicka->m592r243; if ( $m592r243 == 0 ) $m592r243="";
$m592r244=$hlavicka->m592r244; if ( $m592r244 == 0 ) $m592r244="";
$m592r245=$hlavicka->m592r245; if ( $m592r245 == 0 ) $m592r245="";
$m592r246=$hlavicka->m592r246; if ( $m592r246 == 0 ) $m592r246="";
$m592r251=$hlavicka->m592r251; if ( $m592r251 == 0 ) $m592r251="";
$m592r252=$hlavicka->m592r252; if ( $m592r252 == 0 ) $m592r252="";
$m592r253=$hlavicka->m592r253; if ( $m592r253 == 0 ) $m592r253="";
$m592r254=$hlavicka->m592r254; if ( $m592r254 == 0 ) $m592r254="";
$m592r255=$hlavicka->m592r255; if ( $m592r255 == 0 ) $m592r255="";
$m592r256=$hlavicka->m592r256; if ( $m592r256 == 0 ) $m592r256="";
$m592r992=$hlavicka->m592r992;
//if ( $m592r992 == 0 ) $m592r992="";
$m592r993=$hlavicka->m592r993;
//if ( $m592r993 == 0 ) $m592r993="";
$m592r994=$hlavicka->m592r994;
//if ( $m592r994 == 0 ) $m592r994="";
$m592r995=$hlavicka->m592r995;
//if ( $m592r995 == 0 ) $m592r995="";
$m592r996=$hlavicka->m592r996;
//if ( $m592r996 == 0 ) $m592r996="";
$pdf->Cell(195,56," ","$rmc1",1,"L");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m592r11","$rmc",0,"R");$pdf->Cell(27,6,"$m592r12","$rmc",0,"R");
$pdf->Cell(25,6,"$m592r13","$rmc",0,"R");$pdf->Cell(35,6,"$m592r14","$rmc",0,"R");
$pdf->Cell(35,6,"$m592r15","$rmc",0,"R");$pdf->Cell(32,6,"$m592r16","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r21","$rmc",0,"R");$pdf->Cell(27,7,"$m592r22","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r23","$rmc",0,"R");$pdf->Cell(35,7,"$m592r24","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r25","$rmc",0,"R");$pdf->Cell(32,7,"$m592r26","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r31","$rmc",0,"R");$pdf->Cell(27,7,"$m592r32","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r33","$rmc",0,"R");$pdf->Cell(35,7,"$m592r34","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r35","$rmc",0,"R");$pdf->Cell(32,7,"$m592r36","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r41","$rmc",0,"R");$pdf->Cell(27,7,"$m592r42","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r43","$rmc",0,"R");$pdf->Cell(35,7,"$m592r44","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r45","$rmc",0,"R");$pdf->Cell(32,7,"$m592r46","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r51","$rmc",0,"R");$pdf->Cell(27,7,"$m592r52","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r53","$rmc",0,"R");$pdf->Cell(35,7,"$m592r54","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r55","$rmc",0,"R");$pdf->Cell(32,7,"$m592r56","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r61","$rmc",0,"R");$pdf->Cell(27,7,"$m592r62","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r63","$rmc",0,"R");$pdf->Cell(35,7,"$m592r64","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r65","$rmc",0,"R");$pdf->Cell(32,7,"$m592r66","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r71","$rmc",0,"R");$pdf->Cell(27,7,"$m592r72","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r73","$rmc",0,"R");$pdf->Cell(35,7,"$m592r74","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r75","$rmc",0,"R");$pdf->Cell(32,7,"$m592r76","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r81","$rmc",0,"R");$pdf->Cell(27,7,"$m592r82","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r83","$rmc",0,"R");$pdf->Cell(35,7,"$m592r84","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r85","$rmc",0,"R");$pdf->Cell(32,7,"$m592r86","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,8,"$m592r91","$rmc",0,"R");$pdf->Cell(27,8,"$m592r92","$rmc",0,"R");
$pdf->Cell(25,8,"$m592r93","$rmc",0,"R");$pdf->Cell(35,8,"$m592r94","$rmc",0,"R");
$pdf->Cell(35,8,"$m592r95","$rmc",0,"R");$pdf->Cell(32,8,"$m592r96","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r101","$rmc",0,"R");$pdf->Cell(27,7,"$m592r102","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r103","$rmc",0,"R");$pdf->Cell(35,7,"$m592r104","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r105","$rmc",0,"R");$pdf->Cell(32,7,"$m592r106","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r111","$rmc",0,"R");$pdf->Cell(27,7,"$m592r112","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r113","$rmc",0,"R");$pdf->Cell(35,7,"$m592r114","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r115","$rmc",0,"R");$pdf->Cell(32,7,"$m592r116","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r121","$rmc",0,"R");$pdf->Cell(27,7,"$m592r122","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r123","$rmc",0,"R");$pdf->Cell(35,7,"$m592r124","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r125","$rmc",0,"R");$pdf->Cell(32,7,"$m592r126","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r131","$rmc",0,"R");$pdf->Cell(27,7,"$m592r132","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r133","$rmc",0,"R");$pdf->Cell(35,7,"$m592r134","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r135","$rmc",0,"R");$pdf->Cell(32,7,"$m592r136","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r141","$rmc",0,"R");$pdf->Cell(27,7,"$m592r142","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r143","$rmc",0,"R");$pdf->Cell(35,7,"$m592r144","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r145","$rmc",0,"R");$pdf->Cell(32,7,"$m592r146","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r151","$rmc",0,"R");$pdf->Cell(27,7,"$m592r152","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r153","$rmc",0,"R");$pdf->Cell(35,7,"$m592r154","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r155","$rmc",0,"R");$pdf->Cell(32,7,"$m592r156","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r161","$rmc",0,"R");$pdf->Cell(27,7,"$m592r162","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r163","$rmc",0,"R");$pdf->Cell(35,7,"$m592r164","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r165","$rmc",0,"R");$pdf->Cell(32,7,"$m592r166","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r171","$rmc",0,"R");$pdf->Cell(27,7,"$m592r172","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r173","$rmc",0,"R");$pdf->Cell(35,7,"$m592r174","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r175","$rmc",0,"R");$pdf->Cell(32,7,"$m592r176","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r181","$rmc",0,"R");$pdf->Cell(27,7,"$m592r182","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r183","$rmc",0,"R");$pdf->Cell(35,7,"$m592r184","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r185","$rmc",0,"R");$pdf->Cell(32,7,"$m592r186","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r191","$rmc",0,"R");$pdf->Cell(27,7,"$m592r192","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r193","$rmc",0,"R");$pdf->Cell(35,7,"$m592r194","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r195","$rmc",0,"R");$pdf->Cell(32,7,"$m592r196","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r201","$rmc",0,"R");$pdf->Cell(27,7,"$m592r202","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r203","$rmc",0,"R");$pdf->Cell(35,7,"$m592r204","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r205","$rmc",0,"R");$pdf->Cell(32,7,"$m592r206","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r211","$rmc",0,"R");$pdf->Cell(27,7,"$m592r212","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r213","$rmc",0,"R");$pdf->Cell(35,7,"$m592r214","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r215","$rmc",0,"R");$pdf->Cell(32,7,"$m592r216","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r221","$rmc",0,"R");$pdf->Cell(27,7,"$m592r222","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r223","$rmc",0,"R");$pdf->Cell(35,7,"$m592r224","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r225","$rmc",0,"R");$pdf->Cell(32,7,"$m592r226","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r231","$rmc",0,"R");$pdf->Cell(27,7,"$m592r232","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r233","$rmc",0,"R");$pdf->Cell(35,7,"$m592r234","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r235","$rmc",0,"R");$pdf->Cell(32,7,"$m592r236","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r241","$rmc",0,"R");$pdf->Cell(27,7,"$m592r242","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r243","$rmc",0,"R");$pdf->Cell(35,7,"$m592r244","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r245","$rmc",0,"R");$pdf->Cell(32,7,"$m592r246","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m592r251","$rmc",0,"R");$pdf->Cell(27,7,"$m592r252","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r253","$rmc",0,"R");$pdf->Cell(35,7,"$m592r254","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r255","$rmc",0,"R");$pdf->Cell(32,7,"$m592r256","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"","$rmc",0,"R");$pdf->Cell(27,7,"$m592r992","$rmc",0,"R");
$pdf->Cell(25,7,"$m592r993","$rmc",0,"R");$pdf->Cell(35,7,"$m592r994","$rmc",0,"R");
$pdf->Cell(35,7,"$m592r995","$rmc",0,"R");$pdf->Cell(32,7,"$m592r996","$rmc",1,"R");
                                       }

if ( $strana == 3 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str3.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);

//ico
$pdf->Cell(190,0," ","$rmc1",1,"L");
$fir_ficx=$fir_fico;
$cfico=1*$fir_fico;
if ( $cfico < 999999 ) $fir_ficx="00".$fir_fico;
$A=substr($fir_ficx,0,1);
$B=substr($fir_ficx,1,1);
$C=substr($fir_ficx,2,1);
$D=substr($fir_ficx,3,1);
$E=substr($fir_ficx,4,1);
$F=substr($fir_ficx,5,1);
$G=substr($fir_ficx,6,1);
$H=substr($fir_ficx,7,1);
$pdf->Cell(93,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"$A","$rmc",0,"C");$pdf->Cell(7,7,"$B","$rmc",0,"C");
$pdf->Cell(8,7,"$C","$rmc",0,"C");$pdf->Cell(7,7,"$D","$rmc",0,"C");
$pdf->Cell(8,7,"$E","$rmc",0,"C");$pdf->Cell(7,7,"$F","$rmc",0,"C");
$pdf->Cell(8,7,"$G","$rmc",0,"C");$pdf->Cell(7,7,"$H","$rmc",1,"C");

//modul 177
$m177r1=$hlavicka->m177r1; if ( $m177r1 == 0 ) $m177r1="";
$m177r2=$hlavicka->m177r2; if ( $m177r2 == 0 ) $m177r2="";
$m177r3=$hlavicka->m177r3; if ( $m177r3 == 0 ) $m177r3="";
$m177r4=$hlavicka->m177r4; if ( $m177r4 == 0 ) $m177r4="";
$m177r5=$hlavicka->m177r5; if ( $m177r5 == 0 ) $m177r5="";
$m177r6=$hlavicka->m177r6; if ( $m177r6 == 0 ) $m177r6="";
$m177r7=$hlavicka->m177r7; if ( $m177r7 == 0 ) $m177r7="";
$m177r8=$hlavicka->m177r8; if ( $m177r8 == 0 ) $m177r8="";
$m177r9=$hlavicka->m177r9; if ( $m177r9 == 0 ) $m177r9="";
$m177r10=$hlavicka->m177r10; if ( $m177r10 == 0 ) $m177r10="";
$m177r99=$hlavicka->m177r99;
//if ( $m177r99 == 0 ) $m177r99="";
$pdf->Cell(195,22," ","$rmc1",1,"L");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m177r1","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,9,"$m177r2","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m177r3","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m177r4","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m177r5","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m177r6","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m177r7","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m177r8","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,5,"$m177r9","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m177r10","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m177r99","$rmc",1,"R");

//modul 178
$m178r1=$hlavicka->m178r1; if ( $m178r1 == 0 ) $m178r1="";
$m178r2=$hlavicka->m178r2; if ( $m178r2 == 0 ) $m178r2="";
$m178r3=$hlavicka->m178r3; if ( $m178r3 == 0 ) $m178r3="";
$m178r4=$hlavicka->m178r4; if ( $m178r4 == 0 ) $m178r4="";
$m178r5=$hlavicka->m178r5; if ( $m178r5 == 0 ) $m178r5="";
$m178r6=$hlavicka->m178r6; if ( $m178r6 == 0 ) $m178r6="";
$m178r7=$hlavicka->m178r7; if ( $m178r7 == 0 ) $m178r7="";
$m178r8=$hlavicka->m178r8; if ( $m178r8 == 0 ) $m178r8="";
$m178r9=$hlavicka->m178r9; if ( $m178r9 == 0 ) $m178r9="";
$m178r10=$hlavicka->m178r10; if ( $m178r10 == 0 ) $m178r10="";
$m178r11=$hlavicka->m178r11; if ( $m178r11 == 0 ) $m178r11="";
$m178r12=$hlavicka->m178r12; if ( $m178r12 == 0 ) $m178r12="";
$m178r13=$hlavicka->m178r13; if ( $m178r13 == 0 ) $m178r13="";
$m178r14=$hlavicka->m178r14; if ( $m178r14 == 0 ) $m178r14="";
$m178r15=$hlavicka->m178r15; if ( $m178r15 == 0 ) $m178r15="";
$m178r16=$hlavicka->m178r16; if ( $m178r16 == 0 ) $m178r16="";
$m178r17=$hlavicka->m178r17; if ( $m178r17 == 0 ) $m178r17="";
$m178r18=$hlavicka->m178r18; if ( $m178r18 == 0 ) $m178r18="";
$m178r19=$hlavicka->m178r19; if ( $m178r19 == 0 ) $m178r19="";
$m178r99=$hlavicka->m178r99;
//if ( $m178r99 == 0 ) $m178r99="";
$pdf->Cell(195,34," ","$rmc1",1,"L");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r1","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r2","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,13,"$m178r3","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r4","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r5","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r6","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r7","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,8,"$m178r8","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r9","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r10","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r11","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r12","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r13","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,5,"$m178r14","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r15","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r16","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r17","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r18","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r19","$rmc",1,"R");
$pdf->Cell(138,5," ","$rmc1",0,"R");$pdf->Cell(49,6,"$m178r99","$rmc",1,"R");
                                       }

if ( $strana == 4 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str4.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str4.jpg',0,0,210,297);
}
$pdf->SetY(10);

//modul 179
$m179r1=$hlavicka->m179r1; if ( $m179r1 == 0 ) $m179r1="";
$m179r2=$hlavicka->m179r2; if ( $m179r2 == 0 ) $m179r2="";
$m179r3=$hlavicka->m179r3; if ( $m179r3 == 0 ) $m179r3="";
$m179r4=$hlavicka->m179r4; if ( $m179r4 == 0 ) $m179r4="";
$m179r5=$hlavicka->m179r5; if ( $m179r5 == 0 ) $m179r5="";
$m179r6=$hlavicka->m179r6; if ( $m179r6 == 0 ) $m179r6="";
$m179r7=$hlavicka->m179r7; if ( $m179r7 == 0 ) $m179r7="";
$m179r8=$hlavicka->m179r8; if ( $m179r8 == 0 ) $m179r8="";
$m179r9=$hlavicka->m179r9; if ( $m179r9 == 0 ) $m179r9="";
$m179r99=$hlavicka->m179r99;
//if ( $m179r99 == 0 ) $m179r99="";
$pdf->Cell(195,30," ","$rmc1",1,"L");
$pdf->Cell(128,5," ","$rmc1",0,"R");$pdf->Cell(60,7,"$m179r1","$rmc",1,"R");
$pdf->Cell(128,5," ","$rmc1",0,"R");$pdf->Cell(60,8,"$m179r2","$rmc",1,"R");
$pdf->Cell(128,5," ","$rmc1",0,"R");$pdf->Cell(60,7,"$m179r3","$rmc",1,"R");
$pdf->Cell(128,5," ","$rmc1",0,"R");$pdf->Cell(60,7,"$m179r4","$rmc",1,"R");
$pdf->Cell(128,5," ","$rmc1",0,"R");$pdf->Cell(60,7,"$m179r5","$rmc",1,"R");
$pdf->Cell(128,5," ","$rmc1",0,"R");$pdf->Cell(60,8,"$m179r6","$rmc",1,"R");
$pdf->Cell(128,5," ","$rmc1",0,"R");$pdf->Cell(60,7,"$m179r7","$rmc",1,"R");
$pdf->Cell(128,5," ","$rmc1",0,"R");$pdf->Cell(60,7,"$m179r8","$rmc",1,"R");
$pdf->Cell(128,5," ","$rmc1",0,"R");$pdf->Cell(60,7,"$m179r9","$rmc",1,"R");
$pdf->Cell(128,5," ","$rmc1",0,"R");$pdf->Cell(60,7,"$m179r99","$rmc",1,"R");
                                       }

if ( $strana == 5 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str5.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str5.jpg',0,0,210,297);
}
$pdf->SetY(10);

//ico
$pdf->Cell(190,2," ","$rmc1",1,"L");
$fir_ficx=$fir_fico;
$cfico=1*$fir_fico;
if ( $cfico < 999999 ) $fir_ficx="00".$fir_fico;
$A=substr($fir_ficx,0,1);
$B=substr($fir_ficx,1,1);
$C=substr($fir_ficx,2,1);
$D=substr($fir_ficx,3,1);
$E=substr($fir_ficx,4,1);
$F=substr($fir_ficx,5,1);
$G=substr($fir_ficx,6,1);
$H=substr($fir_ficx,7,1);
$pdf->Cell(93,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"$A","$rmc",0,"C");$pdf->Cell(7,7,"$B","$rmc",0,"C");
$pdf->Cell(8,7,"$C","$rmc",0,"C");$pdf->Cell(7,7,"$D","$rmc",0,"C");
$pdf->Cell(8,7,"$E","$rmc",0,"C");$pdf->Cell(7,7,"$F","$rmc",0,"C");
$pdf->Cell(8,7,"$G","$rmc",0,"C");$pdf->Cell(7,7,"$H","$rmc",1,"C");

//modul 182
$m182r11=$hlavicka->m182r11; if ( $m182r11 == 0 ) $m182r11="";
$m182r12=$hlavicka->m182r12; if ( $m182r12 == 0 ) $m182r12="";
$m182r13=$hlavicka->m182r13; if ( $m182r13 == 0 ) $m182r13="";
$m182r14=$hlavicka->m182r14; if ( $m182r14 == 0 ) $m182r14="";
$m182r15=$hlavicka->m182r15; if ( $m182r15 == 0 ) $m182r15="";
$m182r16=$hlavicka->m182r16; if ( $m182r16 == 0 ) $m182r16="";
$m182r17=$hlavicka->m182r17; if ( $m182r17 == 0 ) $m182r17="";
$m182r21=$hlavicka->m182r21; if ( $m182r21 == 0 ) $m182r21="";
$m182r22=$hlavicka->m182r22; if ( $m182r22 == 0 ) $m182r22="";
$m182r23=$hlavicka->m182r23; if ( $m182r23 == 0 ) $m182r23="";
$m182r24=$hlavicka->m182r24; if ( $m182r24 == 0 ) $m182r24="";
$m182r25=$hlavicka->m182r25; if ( $m182r25 == 0 ) $m182r25="";
$m182r26=$hlavicka->m182r26; if ( $m182r26 == 0 ) $m182r26="";
$m182r27=$hlavicka->m182r27; if ( $m182r27 == 0 ) $m182r27="";
$m182r31=$hlavicka->m182r31; if ( $m182r31 == 0 ) $m182r31="";
$m182r32=$hlavicka->m182r32; if ( $m182r32 == 0 ) $m182r32="";
$m182r33=$hlavicka->m182r33; if ( $m182r33 == 0 ) $m182r33="";
$m182r34=$hlavicka->m182r34; if ( $m182r34 == 0 ) $m182r34="";
$m182r35=$hlavicka->m182r35; if ( $m182r35 == 0 ) $m182r35="";
$m182r36=$hlavicka->m182r36; if ( $m182r36 == 0 ) $m182r36="";
$m182r37=$hlavicka->m182r37; if ( $m182r37 == 0 ) $m182r37="";
$m182r41=$hlavicka->m182r41; if ( $m182r41 == 0 ) $m182r41="";
$m182r42=$hlavicka->m182r42; if ( $m182r42 == 0 ) $m182r42="";
$m182r43=$hlavicka->m182r43; if ( $m182r43 == 0 ) $m182r43="";
$m182r44=$hlavicka->m182r44; if ( $m182r44 == 0 ) $m182r44="";
$m182r45=$hlavicka->m182r45; if ( $m182r45 == 0 ) $m182r45="";
$m182r46=$hlavicka->m182r46; if ( $m182r46 == 0 ) $m182r46="";
$m182r47=$hlavicka->m182r47; if ( $m182r47 == 0 ) $m182r47="";
$m182r51=$hlavicka->m182r51; if ( $m182r51 == 0 ) $m182r51="";
$m182r52=$hlavicka->m182r52; if ( $m182r52 == 0 ) $m182r52="";
$m182r53=$hlavicka->m182r53; if ( $m182r53 == 0 ) $m182r53="";
$m182r54=$hlavicka->m182r54; if ( $m182r54 == 0 ) $m182r54="";
$m182r55=$hlavicka->m182r55; if ( $m182r55 == 0 ) $m182r55="";
$m182r56=$hlavicka->m182r56; if ( $m182r56 == 0 ) $m182r56="";
$m182r57=$hlavicka->m182r57; if ( $m182r57 == 0 ) $m182r57="";
$m182r61=$hlavicka->m182r61; if ( $m182r61 == 0 ) $m182r61="";
$m182r62=$hlavicka->m182r62; if ( $m182r62 == 0 ) $m182r62="";
$m182r63=$hlavicka->m182r63; if ( $m182r63 == 0 ) $m182r63="";
$m182r64=$hlavicka->m182r64; if ( $m182r64 == 0 ) $m182r64="";
$m182r65=$hlavicka->m182r65; if ( $m182r65 == 0 ) $m182r65="";
$m182r66=$hlavicka->m182r66; if ( $m182r66 == 0 ) $m182r66="";
$m182r67=$hlavicka->m182r67; if ( $m182r67 == 0 ) $m182r67="";
$m182r71=$hlavicka->m182r71; if ( $m182r71 == 0 ) $m182r71="";
$m182r72=$hlavicka->m182r72; if ( $m182r72 == 0 ) $m182r72="";
$m182r73=$hlavicka->m182r73; if ( $m182r73 == 0 ) $m182r73="";
$m182r74=$hlavicka->m182r74; if ( $m182r74 == 0 ) $m182r74="";
$m182r75=$hlavicka->m182r75; if ( $m182r75 == 0 ) $m182r75="";
$m182r76=$hlavicka->m182r76; if ( $m182r76 == 0 ) $m182r76="";
$m182r77=$hlavicka->m182r77; if ( $m182r77 == 0 ) $m182r77="";
$m182r81=$hlavicka->m182r81; if ( $m182r81 == 0 ) $m182r81="";
$m182r82=$hlavicka->m182r82; if ( $m182r82 == 0 ) $m182r82="";
$m182r83=$hlavicka->m182r83; if ( $m182r83 == 0 ) $m182r83="";
$m182r84=$hlavicka->m182r84; if ( $m182r84 == 0 ) $m182r84="";
$m182r85=$hlavicka->m182r85; if ( $m182r85 == 0 ) $m182r85="";
$m182r86=$hlavicka->m182r86; if ( $m182r86 == 0 ) $m182r86="";
$m182r87=$hlavicka->m182r87; if ( $m182r87 == 0 ) $m182r87="";
$m182r91=$hlavicka->m182r91; if ( $m182r91 == 0 ) $m182r91="";
$m182r92=$hlavicka->m182r92; if ( $m182r92 == 0 ) $m182r92="";
$m182r93=$hlavicka->m182r93; if ( $m182r93 == 0 ) $m182r93="";
$m182r94=$hlavicka->m182r94; if ( $m182r94 == 0 ) $m182r94="";
$m182r95=$hlavicka->m182r95; if ( $m182r95 == 0 ) $m182r95="";
$m182r96=$hlavicka->m182r96; if ( $m182r96 == 0 ) $m182r96="";
$m182r97=$hlavicka->m182r97; if ( $m182r97 == 0 ) $m182r97="";
$m182r101=$hlavicka->m182r101; if ( $m182r101 == 0 ) $m182r101="";
$m182r102=$hlavicka->m182r102; if ( $m182r102 == 0 ) $m182r102="";
$m182r103=$hlavicka->m182r103; if ( $m182r103 == 0 ) $m182r103="";
$m182r104=$hlavicka->m182r104; if ( $m182r104 == 0 ) $m182r104="";
$m182r105=$hlavicka->m182r105; if ( $m182r105 == 0 ) $m182r105="";
$m182r106=$hlavicka->m182r106; if ( $m182r106 == 0 ) $m182r106="";
$m182r107=$hlavicka->m182r107; if ( $m182r107 == 0 ) $m182r107="";
$m182r111=$hlavicka->m182r111; if ( $m182r111 == 0 ) $m182r111="";
$m182r112=$hlavicka->m182r112; if ( $m182r112 == 0 ) $m182r112="";
$m182r113=$hlavicka->m182r113; if ( $m182r113 == 0 ) $m182r113="";
$m182r114=$hlavicka->m182r114; if ( $m182r114 == 0 ) $m182r114="";
$m182r115=$hlavicka->m182r115; if ( $m182r115 == 0 ) $m182r115="";
$m182r116=$hlavicka->m182r116; if ( $m182r116 == 0 ) $m182r116="";
$m182r117=$hlavicka->m182r117; if ( $m182r117 == 0 ) $m182r117="";
$m182r121=$hlavicka->m182r121; if ( $m182r121 == 0 ) $m182r121="";
$m182r122=$hlavicka->m182r122; if ( $m182r122 == 0 ) $m182r122="";
$m182r123=$hlavicka->m182r123; if ( $m182r123 == 0 ) $m182r123="";
$m182r124=$hlavicka->m182r124; if ( $m182r124 == 0 ) $m182r124="";
$m182r125=$hlavicka->m182r125; if ( $m182r125 == 0 ) $m182r125="";
$m182r126=$hlavicka->m182r126; if ( $m182r126 == 0 ) $m182r126="";
$m182r127=$hlavicka->m182r127; if ( $m182r127 == 0 ) $m182r127="";
$m182r131=$hlavicka->m182r131; if ( $m182r131 == 0 ) $m182r131="";
$m182r132=$hlavicka->m182r132; if ( $m182r132 == 0 ) $m182r132="";
$m182r133=$hlavicka->m182r133; if ( $m182r133 == 0 ) $m182r133="";
$m182r134=$hlavicka->m182r134; if ( $m182r134 == 0 ) $m182r134="";
$m182r135=$hlavicka->m182r135; if ( $m182r135 == 0 ) $m182r135="";
$m182r136=$hlavicka->m182r136; if ( $m182r136 == 0 ) $m182r136="";
$m182r137=$hlavicka->m182r137; if ( $m182r137 == 0 ) $m182r137="";
$m182r141=$hlavicka->m182r141; if ( $m182r141 == 0 ) $m182r141="";
$m182r142=$hlavicka->m182r142; if ( $m182r142 == 0 ) $m182r142="";
$m182r143=$hlavicka->m182r143; if ( $m182r143 == 0 ) $m182r143="";
$m182r144=$hlavicka->m182r144; if ( $m182r144 == 0 ) $m182r144="";
$m182r145=$hlavicka->m182r145; if ( $m182r145 == 0 ) $m182r145="";
$m182r146=$hlavicka->m182r146; if ( $m182r146 == 0 ) $m182r146="";
$m182r147=$hlavicka->m182r147; if ( $m182r147 == 0 ) $m182r147="";
$m182r151=$hlavicka->m182r151; if ( $m182r151 == 0 ) $m182r151="";
$m182r152=$hlavicka->m182r152; if ( $m182r152 == 0 ) $m182r152="";
$m182r153=$hlavicka->m182r153; if ( $m182r153 == 0 ) $m182r153="";
$m182r154=$hlavicka->m182r154; if ( $m182r154 == 0 ) $m182r154="";
$m182r155=$hlavicka->m182r155; if ( $m182r155 == 0 ) $m182r155="";
$m182r156=$hlavicka->m182r156; if ( $m182r156 == 0 ) $m182r156="";
$m182r157=$hlavicka->m182r157; if ( $m182r157 == 0 ) $m182r157="";
$m182r161=$hlavicka->m182r161; if ( $m182r161 == 0 ) $m182r161="";
$m182r162=$hlavicka->m182r162; if ( $m182r162 == 0 ) $m182r162="";
$m182r163=$hlavicka->m182r163; if ( $m182r163 == 0 ) $m182r163="";
$m182r164=$hlavicka->m182r164; if ( $m182r164 == 0 ) $m182r164="";
$m182r165=$hlavicka->m182r165; if ( $m182r165 == 0 ) $m182r165="";
$m182r166=$hlavicka->m182r166; if ( $m182r166 == 0 ) $m182r166="";
$m182r167=$hlavicka->m182r167; if ( $m182r167 == 0 ) $m182r167="";
$m182r171=$hlavicka->m182r171; if ( $m182r171 == 0 ) $m182r171="";
$m182r172=$hlavicka->m182r172; if ( $m182r172 == 0 ) $m182r172="";
$m182r173=$hlavicka->m182r173; if ( $m182r173 == 0 ) $m182r173="";
$m182r174=$hlavicka->m182r174; if ( $m182r174 == 0 ) $m182r174="";
$m182r175=$hlavicka->m182r175; if ( $m182r175 == 0 ) $m182r175="";
$m182r176=$hlavicka->m182r176; if ( $m182r176 == 0 ) $m182r176="";
$m182r177=$hlavicka->m182r177; if ( $m182r177 == 0 ) $m182r177="";
$m182r181=$hlavicka->m182r181; if ( $m182r181 == 0 ) $m182r181="";
$m182r182=$hlavicka->m182r182; if ( $m182r182 == 0 ) $m182r182="";
$m182r183=$hlavicka->m182r183; if ( $m182r183 == 0 ) $m182r183="";
$m182r184=$hlavicka->m182r184; if ( $m182r184 == 0 ) $m182r184="";
$m182r185=$hlavicka->m182r185; if ( $m182r185 == 0 ) $m182r185="";
$m182r186=$hlavicka->m182r186; if ( $m182r186 == 0 ) $m182r186="";
$m182r187=$hlavicka->m182r187; if ( $m182r187 == 0 ) $m182r187="";
$m182r191=$hlavicka->m182r191; if ( $m182r191 == 0 ) $m182r191="";
$m182r192=$hlavicka->m182r192; if ( $m182r192 == 0 ) $m182r192="";
$m182r193=$hlavicka->m182r193; if ( $m182r193 == 0 ) $m182r193="";
$m182r194=$hlavicka->m182r194; if ( $m182r194 == 0 ) $m182r194="";
$m182r195=$hlavicka->m182r195; if ( $m182r195 == 0 ) $m182r195="";
$m182r196=$hlavicka->m182r196; if ( $m182r196 == 0 ) $m182r196="";
$m182r197=$hlavicka->m182r197; if ( $m182r197 == 0 ) $m182r197="";
$m182r201=$hlavicka->m182r201; if ( $m182r201 == 0 ) $m182r201="";
$m182r202=$hlavicka->m182r202; if ( $m182r202 == 0 ) $m182r202="";
$m182r203=$hlavicka->m182r203; if ( $m182r203 == 0 ) $m182r203="";
$m182r204=$hlavicka->m182r204; if ( $m182r204 == 0 ) $m182r204="";
$m182r205=$hlavicka->m182r205; if ( $m182r205 == 0 ) $m182r205="";
$m182r206=$hlavicka->m182r206; if ( $m182r206 == 0 ) $m182r206="";
$m182r207=$hlavicka->m182r207; if ( $m182r207 == 0 ) $m182r207="";
$m182r211=$hlavicka->m182r211; if ( $m182r211 == 0 ) $m182r211="";
$m182r212=$hlavicka->m182r212; if ( $m182r212 == 0 ) $m182r212="";
$m182r213=$hlavicka->m182r213; if ( $m182r213 == 0 ) $m182r213="";
$m182r214=$hlavicka->m182r214; if ( $m182r214 == 0 ) $m182r214="";
$m182r215=$hlavicka->m182r215; if ( $m182r215 == 0 ) $m182r215="";
$m182r216=$hlavicka->m182r216; if ( $m182r216 == 0 ) $m182r216="";
$m182r217=$hlavicka->m182r217; if ( $m182r217 == 0 ) $m182r217="";
$m182r221=$hlavicka->m182r221; if ( $m182r221 == 0 ) $m182r221="";
$m182r222=$hlavicka->m182r222; if ( $m182r222 == 0 ) $m182r222="";
$m182r223=$hlavicka->m182r223; if ( $m182r223 == 0 ) $m182r223="";
$m182r224=$hlavicka->m182r224; if ( $m182r224 == 0 ) $m182r224="";
$m182r225=$hlavicka->m182r225; if ( $m182r225 == 0 ) $m182r225="";
$m182r226=$hlavicka->m182r226; if ( $m182r226 == 0 ) $m182r226="";
$m182r227=$hlavicka->m182r227; if ( $m182r227 == 0 ) $m182r227="";
$m182r231=$hlavicka->m182r231; if ( $m182r231 == 0 ) $m182r231="";
$m182r232=$hlavicka->m182r232; if ( $m182r232 == 0 ) $m182r232="";
$m182r233=$hlavicka->m182r233; if ( $m182r233 == 0 ) $m182r233="";
$m182r234=$hlavicka->m182r234; if ( $m182r234 == 0 ) $m182r234="";
$m182r235=$hlavicka->m182r235; if ( $m182r235 == 0 ) $m182r235="";
$m182r236=$hlavicka->m182r236; if ( $m182r236 == 0 ) $m182r236="";
$m182r237=$hlavicka->m182r237; if ( $m182r237 == 0 ) $m182r237="";
$m182r241=$hlavicka->m182r241; if ( $m182r241 == 0 ) $m182r241="";
$m182r242=$hlavicka->m182r242; if ( $m182r242 == 0 ) $m182r242="";
$m182r243=$hlavicka->m182r243; if ( $m182r243 == 0 ) $m182r243="";
$m182r244=$hlavicka->m182r244; if ( $m182r244 == 0 ) $m182r244="";
$m182r245=$hlavicka->m182r245; if ( $m182r245 == 0 ) $m182r245="";
$m182r246=$hlavicka->m182r246; if ( $m182r246 == 0 ) $m182r246="";
$m182r247=$hlavicka->m182r247; if ( $m182r247 == 0 ) $m182r247="";
$m182r251=$hlavicka->m182r251; if ( $m182r251 == 0 ) $m182r251="";
$m182r252=$hlavicka->m182r252; if ( $m182r252 == 0 ) $m182r252="";
$m182r253=$hlavicka->m182r253; if ( $m182r253 == 0 ) $m182r253="";
$m182r254=$hlavicka->m182r254; if ( $m182r254 == 0 ) $m182r254="";
$m182r255=$hlavicka->m182r255; if ( $m182r255 == 0 ) $m182r255="";
$m182r256=$hlavicka->m182r256; if ( $m182r256 == 0 ) $m182r256="";
$m182r257=$hlavicka->m182r257; if ( $m182r257 == 0 ) $m182r257="";
$m182r261=$hlavicka->m182r261; if ( $m182r261 == 0 ) $m182r261="";
$m182r262=$hlavicka->m182r262; if ( $m182r262 == 0 ) $m182r262="";
$m182r263=$hlavicka->m182r263; if ( $m182r263 == 0 ) $m182r263="";
$m182r264=$hlavicka->m182r264; if ( $m182r264 == 0 ) $m182r264="";
$m182r265=$hlavicka->m182r265; if ( $m182r265 == 0 ) $m182r265="";
$m182r266=$hlavicka->m182r266; if ( $m182r266 == 0 ) $m182r266="";
$m182r267=$hlavicka->m182r267; if ( $m182r267 == 0 ) $m182r267="";
$m182r271=$hlavicka->m182r271; if ( $m182r271 == 0 ) $m182r271="";
$m182r272=$hlavicka->m182r272; if ( $m182r272 == 0 ) $m182r272="";
$m182r273=$hlavicka->m182r273; if ( $m182r273 == 0 ) $m182r273="";
$m182r274=$hlavicka->m182r274; if ( $m182r274 == 0 ) $m182r274="";
$m182r275=$hlavicka->m182r275; if ( $m182r275 == 0 ) $m182r275="";
$m182r276=$hlavicka->m182r276; if ( $m182r276 == 0 ) $m182r276="";
$m182r277=$hlavicka->m182r277; if ( $m182r277 == 0 ) $m182r277="";
$m182r281=$hlavicka->m182r281; if ( $m182r281 == 0 ) $m182r281="";
$m182r282=$hlavicka->m182r282; if ( $m182r282 == 0 ) $m182r282="";
$m182r283=$hlavicka->m182r283; if ( $m182r283 == 0 ) $m182r283="";
$m182r284=$hlavicka->m182r284; if ( $m182r284 == 0 ) $m182r284="";
$m182r285=$hlavicka->m182r285; if ( $m182r285 == 0 ) $m182r285="";
$m182r286=$hlavicka->m182r286; if ( $m182r286 == 0 ) $m182r286="";
$m182r287=$hlavicka->m182r287; if ( $m182r287 == 0 ) $m182r287="";
$m182r291=$hlavicka->m182r291; if ( $m182r291 == 0 ) $m182r291="";
$m182r292=$hlavicka->m182r292; if ( $m182r292 == 0 ) $m182r292="";
$m182r293=$hlavicka->m182r293; if ( $m182r293 == 0 ) $m182r293="";
$m182r294=$hlavicka->m182r294; if ( $m182r294 == 0 ) $m182r294="";
$m182r295=$hlavicka->m182r295; if ( $m182r295 == 0 ) $m182r295="";
$m182r296=$hlavicka->m182r296; if ( $m182r296 == 0 ) $m182r296="";
$m182r297=$hlavicka->m182r297; if ( $m182r297 == 0 ) $m182r297="";
$m182r301=$hlavicka->m182r301; if ( $m182r301 == 0 ) $m182r301="";
$m182r302=$hlavicka->m182r302; if ( $m182r302 == 0 ) $m182r302="";
$m182r303=$hlavicka->m182r303; if ( $m182r303 == 0 ) $m182r303="";
$m182r304=$hlavicka->m182r304; if ( $m182r304 == 0 ) $m182r304="";
$m182r305=$hlavicka->m182r305; if ( $m182r305 == 0 ) $m182r305="";
$m182r306=$hlavicka->m182r306; if ( $m182r306 == 0 ) $m182r306="";
$m182r307=$hlavicka->m182r307; if ( $m182r307 == 0 ) $m182r307="";
$m182r311=$hlavicka->m182r311; if ( $m182r311 == 0 ) $m182r311="";
$m182r312=$hlavicka->m182r312; if ( $m182r312 == 0 ) $m182r312="";
$m182r313=$hlavicka->m182r313; if ( $m182r313 == 0 ) $m182r313="";
$m182r314=$hlavicka->m182r314; if ( $m182r314 == 0 ) $m182r314="";
$m182r315=$hlavicka->m182r315; if ( $m182r315 == 0 ) $m182r315="";
$m182r316=$hlavicka->m182r316; if ( $m182r316 == 0 ) $m182r316="";
$m182r317=$hlavicka->m182r317; if ( $m182r317 == 0 ) $m182r317="";
$m182r321=$hlavicka->m182r321; if ( $m182r321 == 0 ) $m182r321="";
$m182r322=$hlavicka->m182r322; if ( $m182r322 == 0 ) $m182r322="";
$m182r323=$hlavicka->m182r323; if ( $m182r323 == 0 ) $m182r323="";
$m182r324=$hlavicka->m182r324; if ( $m182r324 == 0 ) $m182r324="";
$m182r325=$hlavicka->m182r325; if ( $m182r325 == 0 ) $m182r325="";
$m182r326=$hlavicka->m182r326; if ( $m182r326 == 0 ) $m182r326="";
$m182r327=$hlavicka->m182r327; if ( $m182r327 == 0 ) $m182r327="";
$m182r331=$hlavicka->m182r331; if ( $m182r331 == 0 ) $m182r331="";
$m182r332=$hlavicka->m182r332; if ( $m182r332 == 0 ) $m182r332="";
$m182r333=$hlavicka->m182r333; if ( $m182r333 == 0 ) $m182r333="";
$m182r334=$hlavicka->m182r334; if ( $m182r334 == 0 ) $m182r334="";
$m182r335=$hlavicka->m182r335; if ( $m182r335 == 0 ) $m182r335="";
$m182r336=$hlavicka->m182r336; if ( $m182r336 == 0 ) $m182r336="";
$m182r337=$hlavicka->m182r337; if ( $m182r337 == 0 ) $m182r337="";
$m182r992=$hlavicka->m182r992;
//if ( $m182r992 == 0 ) $m182r992="";
$m182r993=$hlavicka->m182r993;
//if ( $m182r993 == 0 ) $m182r993="";
$m182r994=$hlavicka->m182r994;
//if ( $m182r994 == 0 ) $m182r994="";
$m182r995=$hlavicka->m182r995;
//if ( $m182r995 == 0 ) $m182r995="";
$m182r996=$hlavicka->m182r996;
//if ( $m182r996 == 0 ) $m182r996="";
$m182r997=$hlavicka->m182r997;
//if ( $m182r997 == 0 ) $m182r997="";
$pdf->Cell(195,38," ","$rmc1",1,"L");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r11","$rmc",0,"R");$pdf->Cell(27,6,"$m182r12","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r13","$rmc",0,"R");$pdf->Cell(32,6,"$m182r14","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r15","$rmc",0,"R");$pdf->Cell(23,6,"$m182r16","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r17","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r21","$rmc",0,"R");$pdf->Cell(27,6,"$m182r22","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r23","$rmc",0,"R");$pdf->Cell(32,6,"$m182r24","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r25","$rmc",0,"R");$pdf->Cell(23,6,"$m182r26","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r27","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r31","$rmc",0,"R");$pdf->Cell(27,6,"$m182r32","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r33","$rmc",0,"R");$pdf->Cell(32,6,"$m182r34","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r35","$rmc",0,"R");$pdf->Cell(23,6,"$m182r36","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r37","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r41","$rmc",0,"R");$pdf->Cell(27,6,"$m182r42","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r43","$rmc",0,"R");$pdf->Cell(32,6,"$m182r44","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r45","$rmc",0,"R");$pdf->Cell(23,6,"$m182r46","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r47","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r51","$rmc",0,"R");$pdf->Cell(27,6,"$m182r52","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r53","$rmc",0,"R");$pdf->Cell(32,6,"$m182r54","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r55","$rmc",0,"R");$pdf->Cell(23,6,"$m182r56","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r57","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r61","$rmc",0,"R");$pdf->Cell(27,6,"$m182r62","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r63","$rmc",0,"R");$pdf->Cell(32,6,"$m182r64","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r65","$rmc",0,"R");$pdf->Cell(23,6,"$m182r66","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r67","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r71","$rmc",0,"R");$pdf->Cell(27,6,"$m182r72","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r73","$rmc",0,"R");$pdf->Cell(32,6,"$m182r74","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r75","$rmc",0,"R");$pdf->Cell(23,6,"$m182r76","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r77","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r81","$rmc",0,"R");$pdf->Cell(27,6,"$m182r82","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r83","$rmc",0,"R");$pdf->Cell(32,6,"$m182r84","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r85","$rmc",0,"R");$pdf->Cell(23,6,"$m182r86","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r87","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r91","$rmc",0,"R");$pdf->Cell(27,6,"$m182r92","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r93","$rmc",0,"R");$pdf->Cell(32,6,"$m182r94","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r95","$rmc",0,"R");$pdf->Cell(23,6,"$m182r96","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r97","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r101","$rmc",0,"R");$pdf->Cell(27,6,"$m182r102","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r103","$rmc",0,"R");$pdf->Cell(32,6,"$m182r104","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r105","$rmc",0,"R");$pdf->Cell(23,6,"$m182r106","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r107","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r111","$rmc",0,"R");$pdf->Cell(27,6,"$m182r112","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r113","$rmc",0,"R");$pdf->Cell(32,6,"$m182r114","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r115","$rmc",0,"R");$pdf->Cell(23,6,"$m182r116","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r117","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r121","$rmc",0,"R");$pdf->Cell(27,6,"$m182r122","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r123","$rmc",0,"R");$pdf->Cell(32,6,"$m182r124","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r125","$rmc",0,"R");$pdf->Cell(23,6,"$m182r126","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r127","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r131","$rmc",0,"R");$pdf->Cell(27,6,"$m182r132","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r133","$rmc",0,"R");$pdf->Cell(32,6,"$m182r134","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r135","$rmc",0,"R");$pdf->Cell(23,6,"$m182r136","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r137","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r141","$rmc",0,"R");$pdf->Cell(27,6,"$m182r142","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r143","$rmc",0,"R");$pdf->Cell(32,6,"$m182r144","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r145","$rmc",0,"R");$pdf->Cell(23,6,"$m182r146","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r147","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r151","$rmc",0,"R");$pdf->Cell(27,6,"$m182r152","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r153","$rmc",0,"R");$pdf->Cell(32,6,"$m182r154","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r155","$rmc",0,"R");$pdf->Cell(23,6,"$m182r156","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r157","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r161","$rmc",0,"R");$pdf->Cell(27,6,"$m182r162","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r163","$rmc",0,"R");$pdf->Cell(32,6,"$m182r164","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r165","$rmc",0,"R");$pdf->Cell(23,6,"$m182r166","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r167","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r171","$rmc",0,"R");$pdf->Cell(27,6,"$m182r172","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r173","$rmc",0,"R");$pdf->Cell(32,6,"$m182r174","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r175","$rmc",0,"R");$pdf->Cell(23,6,"$m182r176","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r177","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r181","$rmc",0,"R");$pdf->Cell(27,6,"$m182r182","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r183","$rmc",0,"R");$pdf->Cell(32,6,"$m182r184","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r185","$rmc",0,"R");$pdf->Cell(23,6,"$m182r186","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r187","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r191","$rmc",0,"R");$pdf->Cell(27,6,"$m182r192","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r193","$rmc",0,"R");$pdf->Cell(32,6,"$m182r194","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r195","$rmc",0,"R");$pdf->Cell(23,6,"$m182r196","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r197","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r201","$rmc",0,"R");$pdf->Cell(27,6,"$m182r202","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r203","$rmc",0,"R");$pdf->Cell(32,6,"$m182r204","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r205","$rmc",0,"R");$pdf->Cell(23,6,"$m182r206","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r207","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r211","$rmc",0,"R");$pdf->Cell(27,6,"$m182r212","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r213","$rmc",0,"R");$pdf->Cell(32,6,"$m182r214","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r215","$rmc",0,"R");$pdf->Cell(23,6,"$m182r216","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r217","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r221","$rmc",0,"R");$pdf->Cell(27,6,"$m182r222","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r223","$rmc",0,"R");$pdf->Cell(32,6,"$m182r224","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r225","$rmc",0,"R");$pdf->Cell(23,6,"$m182r226","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r227","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r231","$rmc",0,"R");$pdf->Cell(27,6,"$m182r232","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r233","$rmc",0,"R");$pdf->Cell(32,6,"$m182r234","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r235","$rmc",0,"R");$pdf->Cell(23,6,"$m182r236","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r237","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r241","$rmc",0,"R");$pdf->Cell(27,6,"$m182r242","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r243","$rmc",0,"R");$pdf->Cell(32,6,"$m182r244","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r245","$rmc",0,"R");$pdf->Cell(23,6,"$m182r246","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r247","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r251","$rmc",0,"R");$pdf->Cell(27,6,"$m182r252","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r253","$rmc",0,"R");$pdf->Cell(32,6,"$m182r254","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r255","$rmc",0,"R");$pdf->Cell(23,6,"$m182r256","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r257","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r261","$rmc",0,"R");$pdf->Cell(27,6,"$m182r262","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r263","$rmc",0,"R");$pdf->Cell(32,6,"$m182r264","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r265","$rmc",0,"R");$pdf->Cell(23,6,"$m182r266","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r267","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r271","$rmc",0,"R");$pdf->Cell(27,6,"$m182r272","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r273","$rmc",0,"R");$pdf->Cell(32,6,"$m182r274","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r275","$rmc",0,"R");$pdf->Cell(23,6,"$m182r276","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r277","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r281","$rmc",0,"R");$pdf->Cell(27,6,"$m182r282","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r283","$rmc",0,"R");$pdf->Cell(32,6,"$m182r284","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r285","$rmc",0,"R");$pdf->Cell(23,6,"$m182r286","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r287","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r291","$rmc",0,"R");$pdf->Cell(27,6,"$m182r292","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r293","$rmc",0,"R");$pdf->Cell(32,6,"$m182r294","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r295","$rmc",0,"R");$pdf->Cell(23,6,"$m182r296","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r297","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r301","$rmc",0,"R");$pdf->Cell(27,6,"$m182r302","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r303","$rmc",0,"R");$pdf->Cell(32,6,"$m182r304","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r305","$rmc",0,"R");$pdf->Cell(23,6,"$m182r306","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r307","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r311","$rmc",0,"R");$pdf->Cell(27,6,"$m182r312","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r313","$rmc",0,"R");$pdf->Cell(32,6,"$m182r314","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r315","$rmc",0,"R");$pdf->Cell(23,6,"$m182r316","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r317","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r321","$rmc",0,"R");$pdf->Cell(27,6,"$m182r322","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r323","$rmc",0,"R");$pdf->Cell(32,6,"$m182r324","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r325","$rmc",0,"R");$pdf->Cell(23,6,"$m182r326","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r327","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m182r331","$rmc",0,"R");$pdf->Cell(27,6,"$m182r332","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r333","$rmc",0,"R");$pdf->Cell(32,6,"$m182r334","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r335","$rmc",0,"R");$pdf->Cell(23,6,"$m182r336","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r337","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(25,6," ","$rmc",0,"R");$pdf->Cell(27,6,"$m182r992","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r993","$rmc",0,"R");$pdf->Cell(32,6,"$m182r994","$rmc",0,"R");
$pdf->Cell(25,6,"$m182r995","$rmc",0,"R");$pdf->Cell(23,6,"$m182r996","$rmc",0,"R");
$pdf->Cell(22,6,"$m182r997","$rmc",1,"R");
                                       }

if ( $strana == 6 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str6.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str6.jpg',0,0,210,297);
}
$pdf->SetY(10);

//modul 183
$m183r11=$hlavicka->m183r11; if ( $m183r11 == 0 ) $m183r11="";
$m183r12=$hlavicka->m183r12; if ( $m183r12 == 0 ) $m183r12="";
$m183r13=$hlavicka->m183r13; if ( $m183r13 == 0 ) $m183r13="";
$m183r14=$hlavicka->m183r14; if ( $m183r14 == 0 ) $m183r14="";
$m183r21=$hlavicka->m183r21; if ( $m183r21 == 0 ) $m183r21="";
$m183r22=$hlavicka->m183r22; if ( $m183r22 == 0 ) $m183r22="";
$m183r23=$hlavicka->m183r23; if ( $m183r23 == 0 ) $m183r23="";
$m183r24=$hlavicka->m183r24; if ( $m183r24 == 0 ) $m183r24="";
$m183r31=$hlavicka->m183r31; if ( $m183r31 == 0 ) $m183r31="";
$m183r32=$hlavicka->m183r32; if ( $m183r32 == 0 ) $m183r32="";
$m183r33=$hlavicka->m183r33; if ( $m183r33 == 0 ) $m183r33="";
$m183r34=$hlavicka->m183r34; if ( $m183r34 == 0 ) $m183r34="";
$m183r41=$hlavicka->m183r41; if ( $m183r41 == 0 ) $m183r41="";
$m183r42=$hlavicka->m183r42; if ( $m183r42 == 0 ) $m183r42="";
$m183r43=$hlavicka->m183r43; if ( $m183r43 == 0 ) $m183r43="";
$m183r44=$hlavicka->m183r44; if ( $m183r44 == 0 ) $m183r44="";
$m183r51=$hlavicka->m183r51; if ( $m183r51 == 0 ) $m183r51="";
$m183r52=$hlavicka->m183r52; if ( $m183r52 == 0 ) $m183r52="";
$m183r53=$hlavicka->m183r53; if ( $m183r53 == 0 ) $m183r53="";
$m183r54=$hlavicka->m183r54; if ( $m183r54 == 0 ) $m183r54="";
$m183r61=$hlavicka->m183r61; if ( $m183r61 == 0 ) $m183r61="";
$m183r62=$hlavicka->m183r62; if ( $m183r62 == 0 ) $m183r62="";
$m183r63=$hlavicka->m183r63; if ( $m183r63 == 0 ) $m183r63="";
$m183r64=$hlavicka->m183r64; if ( $m183r64 == 0 ) $m183r64="";
$m183r71=$hlavicka->m183r71; if ( $m183r71 == 0 ) $m183r71="";
$m183r72=$hlavicka->m183r72; if ( $m183r72 == 0 ) $m183r72="";
$m183r73=$hlavicka->m183r73; if ( $m183r73 == 0 ) $m183r73="";
$m183r74=$hlavicka->m183r74; if ( $m183r74 == 0 ) $m183r74="";
$m183r81=$hlavicka->m183r81; if ( $m183r81 == 0 ) $m183r81="";
$m183r82=$hlavicka->m183r82; if ( $m183r82 == 0 ) $m183r82="";
$m183r83=$hlavicka->m183r83; if ( $m183r83 == 0 ) $m183r83="";
$m183r84=$hlavicka->m183r84; if ( $m183r84 == 0 ) $m183r84="";
$m183r91=$hlavicka->m183r91; if ( $m183r91 == 0 ) $m183r91="";
$m183r92=$hlavicka->m183r92; if ( $m183r92 == 0 ) $m183r92="";
$m183r93=$hlavicka->m183r93; if ( $m183r93 == 0 ) $m183r93="";
$m183r94=$hlavicka->m183r94; if ( $m183r94 == 0 ) $m183r94="";
$m183r101=$hlavicka->m183r101; if ( $m183r101 == 0 ) $m183r101="";
$m183r102=$hlavicka->m183r102; if ( $m183r102 == 0 ) $m183r102="";
$m183r103=$hlavicka->m183r103; if ( $m183r103 == 0 ) $m183r103="";
$m183r104=$hlavicka->m183r104; if ( $m183r104 == 0 ) $m183r104="";
$m183r111=$hlavicka->m183r111; if ( $m183r111 == 0 ) $m183r111="";
$m183r112=$hlavicka->m183r112; if ( $m183r112 == 0 ) $m183r112="";
$m183r113=$hlavicka->m183r113; if ( $m183r113 == 0 ) $m183r113="";
$m183r114=$hlavicka->m183r114; if ( $m183r114 == 0 ) $m183r114="";
$m183r121=$hlavicka->m183r121; if ( $m183r121 == 0 ) $m183r121="";
$m183r122=$hlavicka->m183r122; if ( $m183r122 == 0 ) $m183r122="";
$m183r123=$hlavicka->m183r123; if ( $m183r123 == 0 ) $m183r123="";
$m183r124=$hlavicka->m183r124; if ( $m183r124 == 0 ) $m183r124="";
$m183r131=$hlavicka->m183r131; if ( $m183r131 == 0 ) $m183r131="";
$m183r132=$hlavicka->m183r132; if ( $m183r132 == 0 ) $m183r132="";
$m183r133=$hlavicka->m183r133; if ( $m183r133 == 0 ) $m183r133="";
$m183r134=$hlavicka->m183r134; if ( $m183r134 == 0 ) $m183r134="";
$m183r141=$hlavicka->m183r141; if ( $m183r141 == 0 ) $m183r141="";
$m183r142=$hlavicka->m183r142; if ( $m183r142 == 0 ) $m183r142="";
$m183r143=$hlavicka->m183r143; if ( $m183r143 == 0 ) $m183r143="";
$m183r144=$hlavicka->m183r144; if ( $m183r144 == 0 ) $m183r144="";
$m183r151=$hlavicka->m183r151; if ( $m183r151 == 0 ) $m183r151="";
$m183r152=$hlavicka->m183r152; if ( $m183r152 == 0 ) $m183r152="";
$m183r153=$hlavicka->m183r153; if ( $m183r153 == 0 ) $m183r153="";
$m183r154=$hlavicka->m183r154; if ( $m183r154 == 0 ) $m183r154="";
$m183r161=$hlavicka->m183r161; if ( $m183r161 == 0 ) $m183r161="";
$m183r162=$hlavicka->m183r162; if ( $m183r162 == 0 ) $m183r162="";
$m183r163=$hlavicka->m183r163; if ( $m183r163 == 0 ) $m183r163="";
$m183r164=$hlavicka->m183r164; if ( $m183r164 == 0 ) $m183r164="";
$m183r171=$hlavicka->m183r171; if ( $m183r171 == 0 ) $m183r171="";
$m183r172=$hlavicka->m183r172; if ( $m183r172 == 0 ) $m183r172="";
$m183r173=$hlavicka->m183r173; if ( $m183r173 == 0 ) $m183r173="";
$m183r174=$hlavicka->m183r174; if ( $m183r174 == 0 ) $m183r174="";
$m183r181=$hlavicka->m183r181; if ( $m183r181 == 0 ) $m183r181="";
$m183r182=$hlavicka->m183r182; if ( $m183r182 == 0 ) $m183r182="";
$m183r183=$hlavicka->m183r183; if ( $m183r183 == 0 ) $m183r183="";
$m183r184=$hlavicka->m183r184; if ( $m183r184 == 0 ) $m183r184="";
$m183r191=$hlavicka->m183r191; if ( $m183r191 == 0 ) $m183r191="";
$m183r192=$hlavicka->m183r192; if ( $m183r192 == 0 ) $m183r192="";
$m183r193=$hlavicka->m183r193; if ( $m183r193 == 0 ) $m183r193="";
$m183r194=$hlavicka->m183r194; if ( $m183r194 == 0 ) $m183r194="";
$m183r201=$hlavicka->m183r201; if ( $m183r201 == 0 ) $m183r201="";
$m183r202=$hlavicka->m183r202; if ( $m183r202 == 0 ) $m183r202="";
$m183r203=$hlavicka->m183r203; if ( $m183r203 == 0 ) $m183r203="";
$m183r204=$hlavicka->m183r204; if ( $m183r204 == 0 ) $m183r204="";
$m183r211=$hlavicka->m183r211; if ( $m183r211 == 0 ) $m183r211="";
$m183r212=$hlavicka->m183r212; if ( $m183r212 == 0 ) $m183r212="";
$m183r213=$hlavicka->m183r213; if ( $m183r213 == 0 ) $m183r213="";
$m183r214=$hlavicka->m183r214; if ( $m183r214 == 0 ) $m183r214="";
$m183r221=$hlavicka->m183r221; if ( $m183r221 == 0 ) $m183r221="";
$m183r222=$hlavicka->m183r222; if ( $m183r222 == 0 ) $m183r222="";
$m183r223=$hlavicka->m183r223; if ( $m183r223 == 0 ) $m183r223="";
$m183r224=$hlavicka->m183r224; if ( $m183r224 == 0 ) $m183r224="";
$m183r231=$hlavicka->m183r231; if ( $m183r231 == 0 ) $m183r231="";
$m183r232=$hlavicka->m183r232; if ( $m183r232 == 0 ) $m183r232="";
$m183r233=$hlavicka->m183r233; if ( $m183r233 == 0 ) $m183r233="";
$m183r234=$hlavicka->m183r234; if ( $m183r234 == 0 ) $m183r234="";
$m183r241=$hlavicka->m183r241; if ( $m183r241 == 0 ) $m183r241="";
$m183r242=$hlavicka->m183r242; if ( $m183r242 == 0 ) $m183r242="";
$m183r243=$hlavicka->m183r243; if ( $m183r243 == 0 ) $m183r243="";
$m183r244=$hlavicka->m183r244; if ( $m183r244 == 0 ) $m183r244="";
$m183r251=$hlavicka->m183r251; if ( $m183r251 == 0 ) $m183r251="";
$m183r252=$hlavicka->m183r252; if ( $m183r252 == 0 ) $m183r252="";
$m183r253=$hlavicka->m183r253; if ( $m183r253 == 0 ) $m183r253="";
$m183r254=$hlavicka->m183r254; if ( $m183r254 == 0 ) $m183r254="";
$m183r261=$hlavicka->m183r261; if ( $m183r261 == 0 ) $m183r261="";
$m183r262=$hlavicka->m183r262; if ( $m183r262 == 0 ) $m183r262="";
$m183r263=$hlavicka->m183r263; if ( $m183r263 == 0 ) $m183r263="";
$m183r264=$hlavicka->m183r264; if ( $m183r264 == 0 ) $m183r264="";
$m183r271=$hlavicka->m183r271; if ( $m183r271 == 0 ) $m183r271="";
$m183r272=$hlavicka->m183r272; if ( $m183r272 == 0 ) $m183r272="";
$m183r273=$hlavicka->m183r273; if ( $m183r273 == 0 ) $m183r273="";
$m183r274=$hlavicka->m183r274; if ( $m183r274 == 0 ) $m183r274="";
$m183r281=$hlavicka->m183r281; if ( $m183r281 == 0 ) $m183r281="";
$m183r282=$hlavicka->m183r282; if ( $m183r282 == 0 ) $m183r282="";
$m183r283=$hlavicka->m183r283; if ( $m183r283 == 0 ) $m183r283="";
$m183r284=$hlavicka->m183r284; if ( $m183r284 == 0 ) $m183r284="";
$m183r291=$hlavicka->m183r291; if ( $m183r291 == 0 ) $m183r291="";
$m183r292=$hlavicka->m183r292; if ( $m183r292 == 0 ) $m183r292="";
$m183r293=$hlavicka->m183r293; if ( $m183r293 == 0 ) $m183r293="";
$m183r294=$hlavicka->m183r294; if ( $m183r294 == 0 ) $m183r294="";
$m183r301=$hlavicka->m183r301; if ( $m183r301 == 0 ) $m183r301="";
$m183r302=$hlavicka->m183r302; if ( $m183r302 == 0 ) $m183r302="";
$m183r303=$hlavicka->m183r303; if ( $m183r303 == 0 ) $m183r303="";
$m183r304=$hlavicka->m183r304; if ( $m183r304 == 0 ) $m183r304="";
$m183r992=$hlavicka->m183r992;
//if ( $m183r992 == 0 ) $m183r992="";
$m183r993=$hlavicka->m183r993;
//if ( $m183r993 == 0 ) $m183r993="";
$m183r994=$hlavicka->m183r994;
//if ( $m183r994 == 0 ) $m183r994="";
$pdf->Cell(195,30," ","$rmc1",1,"L");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,7,"$m183r11","$rmc",0,"R");$pdf->Cell(39,7,"$m183r12","$rmc",0,"R");
$pdf->Cell(35,7,"$m183r13","$rmc",0,"R");$pdf->Cell(72,7,"$m183r14","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,6,"$m183r21","$rmc",0,"R");$pdf->Cell(39,6,"$m183r22","$rmc",0,"R");
$pdf->Cell(35,6,"$m183r23","$rmc",0,"R");$pdf->Cell(72,6,"$m183r24","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,6,"$m183r31","$rmc",0,"R");$pdf->Cell(39,6,"$m183r32","$rmc",0,"R");
$pdf->Cell(35,6,"$m183r33","$rmc",0,"R");$pdf->Cell(72,6,"$m183r34","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,7,"$m183r41","$rmc",0,"R");$pdf->Cell(39,7,"$m183r42","$rmc",0,"R");
$pdf->Cell(35,7,"$m183r43","$rmc",0,"R");$pdf->Cell(72,7,"$m183r44","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,6,"$m183r51","$rmc",0,"R");$pdf->Cell(39,6,"$m183r52","$rmc",0,"R");
$pdf->Cell(35,6,"$m183r53","$rmc",0,"R");$pdf->Cell(72,6,"$m183r54","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,7,"$m183r61","$rmc",0,"R");$pdf->Cell(39,7,"$m183r62","$rmc",0,"R");
$pdf->Cell(35,7,"$m183r63","$rmc",0,"R");$pdf->Cell(72,7,"$m183r64","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,6,"$m183r71","$rmc",0,"R");$pdf->Cell(39,6,"$m183r72","$rmc",0,"R");
$pdf->Cell(35,6,"$m183r73","$rmc",0,"R");$pdf->Cell(72,6,"$m183r74","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,7,"$m183r81","$rmc",0,"R");$pdf->Cell(39,7,"$m183r82","$rmc",0,"R");
$pdf->Cell(35,7,"$m183r83","$rmc",0,"R");$pdf->Cell(72,7,"$m183r84","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,7,"$m183r91","$rmc",0,"R");$pdf->Cell(39,7,"$m183r92","$rmc",0,"R");
$pdf->Cell(35,7,"$m183r93","$rmc",0,"R");$pdf->Cell(72,7,"$m183r94","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,6,"$m183r101","$rmc",0,"R");$pdf->Cell(39,6,"$m183r102","$rmc",0,"R");
$pdf->Cell(35,6,"$m183r103","$rmc",0,"R");$pdf->Cell(72,6,"$m183r104","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,6,"$m183r111","$rmc",0,"R");$pdf->Cell(39,6,"$m183r112","$rmc",0,"R");
$pdf->Cell(35,6,"$m183r113","$rmc",0,"R");$pdf->Cell(72,6,"$m183r114","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,7,"$m183r121","$rmc",0,"R");$pdf->Cell(39,7,"$m183r122","$rmc",0,"R");
$pdf->Cell(35,7,"$m183r123","$rmc",0,"R");$pdf->Cell(72,7,"$m183r124","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,7,"$m183r131","$rmc",0,"R");$pdf->Cell(39,7,"$m183r132","$rmc",0,"R");
$pdf->Cell(35,7,"$m183r133","$rmc",0,"R");$pdf->Cell(72,7,"$m183r134","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,6,"$m183r141","$rmc",0,"R");$pdf->Cell(39,6,"$m183r142","$rmc",0,"R");
$pdf->Cell(35,6,"$m183r143","$rmc",0,"R");$pdf->Cell(72,6,"$m183r144","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,7,"$m183r151","$rmc",0,"R");$pdf->Cell(39,7,"$m183r152","$rmc",0,"R");
$pdf->Cell(35,7,"$m183r153","$rmc",0,"R");$pdf->Cell(72,7,"$m183r154","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,6,"$m183r161","$rmc",0,"R");$pdf->Cell(39,6,"$m183r162","$rmc",0,"R");
$pdf->Cell(35,6,"$m183r163","$rmc",0,"R");$pdf->Cell(72,6,"$m183r164","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,7,"$m183r171","$rmc",0,"R");$pdf->Cell(39,7,"$m183r172","$rmc",0,"R");
$pdf->Cell(35,7,"$m183r173","$rmc",0,"R");$pdf->Cell(72,7,"$m183r174","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,6,"$m183r181","$rmc",0,"R");$pdf->Cell(39,6,"$m183r182","$rmc",0,"R");
$pdf->Cell(35,6,"$m183r183","$rmc",0,"R");$pdf->Cell(72,6,"$m183r184","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,7,"$m183r191","$rmc",0,"R");$pdf->Cell(39,7,"$m183r192","$rmc",0,"R");
$pdf->Cell(35,7,"$m183r193","$rmc",0,"R");$pdf->Cell(72,7,"$m183r194","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,6,"$m183r201","$rmc",0,"R");$pdf->Cell(39,6,"$m183r202","$rmc",0,"R");
$pdf->Cell(35,6,"$m183r203","$rmc",0,"R");$pdf->Cell(72,6,"$m183r204","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,7,"$m183r211","$rmc",0,"R");$pdf->Cell(39,7,"$m183r212","$rmc",0,"R");
$pdf->Cell(35,7,"$m183r213","$rmc",0,"R");$pdf->Cell(72,7,"$m183r214","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,6,"$m183r221","$rmc",0,"R");$pdf->Cell(39,6,"$m183r222","$rmc",0,"R");
$pdf->Cell(35,6,"$m183r223","$rmc",0,"R");$pdf->Cell(72,6,"$m183r224","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,7,"$m183r231","$rmc",0,"R");$pdf->Cell(39,7,"$m183r232","$rmc",0,"R");
$pdf->Cell(35,7,"$m183r233","$rmc",0,"R");$pdf->Cell(72,7,"$m183r234","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,6,"$m183r241","$rmc",0,"R");$pdf->Cell(39,6,"$m183r242","$rmc",0,"R");
$pdf->Cell(35,6,"$m183r243","$rmc",0,"R");$pdf->Cell(72,6,"$m183r244","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,7,"$m183r251","$rmc",0,"R");$pdf->Cell(39,7,"$m183r252","$rmc",0,"R");
$pdf->Cell(35,7,"$m183r253","$rmc",0,"R");$pdf->Cell(72,7,"$m183r254","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,6,"$m183r261","$rmc",0,"R");$pdf->Cell(39,6,"$m183r262","$rmc",0,"R");
$pdf->Cell(35,6,"$m183r263","$rmc",0,"R");$pdf->Cell(72,6,"$m183r264","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,7,"$m183r271","$rmc",0,"R");$pdf->Cell(39,7,"$m183r272","$rmc",0,"R");
$pdf->Cell(35,7,"$m183r273","$rmc",0,"R");$pdf->Cell(72,7,"$m183r274","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,6,"$m183r281","$rmc",0,"R");$pdf->Cell(39,6,"$m183r282","$rmc",0,"R");
$pdf->Cell(35,6,"$m183r283","$rmc",0,"R");$pdf->Cell(72,6,"$m183r284","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,7,"$m183r291","$rmc",0,"R");$pdf->Cell(39,7,"$m183r292","$rmc",0,"R");
$pdf->Cell(35,7,"$m183r293","$rmc",0,"R");$pdf->Cell(72,7,"$m183r294","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,6,"$m183r301","$rmc",0,"R");$pdf->Cell(39,6,"$m183r302","$rmc",0,"R");
$pdf->Cell(35,6,"$m183r303","$rmc",0,"R");$pdf->Cell(72,6,"$m183r304","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(33,7,"","$rmc",0,"R");$pdf->Cell(39,7,"$m183r992","$rmc",0,"R");
$pdf->Cell(35,7,"$m183r993","$rmc",0,"R");$pdf->Cell(72,7,"$m183r994","$rmc",1,"R");
                                       }

if ( $strana == 7 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str7.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str7.jpg',0,0,210,297);
}
$pdf->SetY(10);

//modul 184
$m184r11=$hlavicka->m184r11; if ( $m184r11 == 0 ) $m184r11="";
$m184r12=$hlavicka->m184r12; if ( $m184r12 == 0 ) $m184r12="";
$m184r13=$hlavicka->m184r13; if ( $m184r13 == 0 ) $m184r13="";
$m184r14=$hlavicka->m184r14; if ( $m184r14 == 0 ) $m184r14="";
$m184r15=$hlavicka->m184r15; if ( $m184r15 == 0 ) $m184r15="";
$m184r16=$hlavicka->m184r16; if ( $m184r16 == 0 ) $m184r16="";
$m184r21=$hlavicka->m184r21; if ( $m184r21 == 0 ) $m184r21="";
$m184r22=$hlavicka->m184r22; if ( $m184r22 == 0 ) $m184r22="";
$m184r23=$hlavicka->m184r23; if ( $m184r23 == 0 ) $m184r23="";
$m184r24=$hlavicka->m184r24; if ( $m184r24 == 0 ) $m184r24="";
$m184r25=$hlavicka->m184r25; if ( $m184r25 == 0 ) $m184r25="";
$m184r26=$hlavicka->m184r26; if ( $m184r26 == 0 ) $m184r26="";
$m184r31=$hlavicka->m184r31; if ( $m184r31 == 0 ) $m184r31="";
$m184r32=$hlavicka->m184r32; if ( $m184r32 == 0 ) $m184r32="";
$m184r33=$hlavicka->m184r33; if ( $m184r33 == 0 ) $m184r33="";
$m184r34=$hlavicka->m184r34; if ( $m184r34 == 0 ) $m184r34="";
$m184r35=$hlavicka->m184r35; if ( $m184r35 == 0 ) $m184r35="";
$m184r36=$hlavicka->m184r36; if ( $m184r36 == 0 ) $m184r36="";
$m184r41=$hlavicka->m184r41; if ( $m184r41 == 0 ) $m184r41="";
$m184r42=$hlavicka->m184r42; if ( $m184r42 == 0 ) $m184r42="";
$m184r43=$hlavicka->m184r43; if ( $m184r43 == 0 ) $m184r43="";
$m184r44=$hlavicka->m184r44; if ( $m184r44 == 0 ) $m184r44="";
$m184r45=$hlavicka->m184r45; if ( $m184r45 == 0 ) $m184r45="";
$m184r46=$hlavicka->m184r46; if ( $m184r46 == 0 ) $m184r46="";
$m184r51=$hlavicka->m184r51; if ( $m184r51 == 0 ) $m184r51="";
$m184r52=$hlavicka->m184r52; if ( $m184r52 == 0 ) $m184r52="";
$m184r53=$hlavicka->m184r53; if ( $m184r53 == 0 ) $m184r53="";
$m184r54=$hlavicka->m184r54; if ( $m184r54 == 0 ) $m184r54="";
$m184r55=$hlavicka->m184r55; if ( $m184r55 == 0 ) $m184r55="";
$m184r56=$hlavicka->m184r56; if ( $m184r56 == 0 ) $m184r56="";
$m184r61=$hlavicka->m184r61; if ( $m184r61 == 0 ) $m184r61="";
$m184r62=$hlavicka->m184r62; if ( $m184r62 == 0 ) $m184r62="";
$m184r63=$hlavicka->m184r63; if ( $m184r63 == 0 ) $m184r63="";
$m184r64=$hlavicka->m184r64; if ( $m184r64 == 0 ) $m184r64="";
$m184r65=$hlavicka->m184r65; if ( $m184r65 == 0 ) $m184r65="";
$m184r66=$hlavicka->m184r66; if ( $m184r66 == 0 ) $m184r66="";
$m184r71=$hlavicka->m184r71; if ( $m184r71 == 0 ) $m184r71="";
$m184r72=$hlavicka->m184r72; if ( $m184r72 == 0 ) $m184r72="";
$m184r73=$hlavicka->m184r73; if ( $m184r73 == 0 ) $m184r73="";
$m184r74=$hlavicka->m184r74; if ( $m184r74 == 0 ) $m184r74="";
$m184r75=$hlavicka->m184r75; if ( $m184r75 == 0 ) $m184r75="";
$m184r76=$hlavicka->m184r76; if ( $m184r76 == 0 ) $m184r76="";
$m184r81=$hlavicka->m184r81; if ( $m184r81 == 0 ) $m184r81="";
$m184r82=$hlavicka->m184r82; if ( $m184r82 == 0 ) $m184r82="";
$m184r83=$hlavicka->m184r83; if ( $m184r83 == 0 ) $m184r83="";
$m184r84=$hlavicka->m184r84; if ( $m184r84 == 0 ) $m184r84="";
$m184r85=$hlavicka->m184r85; if ( $m184r85 == 0 ) $m184r85="";
$m184r86=$hlavicka->m184r86; if ( $m184r86 == 0 ) $m184r86="";
$m184r91=$hlavicka->m184r91; if ( $m184r91 == 0 ) $m184r91="";
$m184r92=$hlavicka->m184r92; if ( $m184r92 == 0 ) $m184r92="";
$m184r93=$hlavicka->m184r93; if ( $m184r93 == 0 ) $m184r93="";
$m184r94=$hlavicka->m184r94; if ( $m184r94 == 0 ) $m184r94="";
$m184r95=$hlavicka->m184r95; if ( $m184r95 == 0 ) $m184r95="";
$m184r96=$hlavicka->m184r96; if ( $m184r96 == 0 ) $m184r96="";
$m184r101=$hlavicka->m184r101; if ( $m184r101 == 0 ) $m184r101="";
$m184r102=$hlavicka->m184r102; if ( $m184r102 == 0 ) $m184r102="";
$m184r103=$hlavicka->m184r103; if ( $m184r103 == 0 ) $m184r103="";
$m184r104=$hlavicka->m184r104; if ( $m184r104 == 0 ) $m184r104="";
$m184r105=$hlavicka->m184r105; if ( $m184r105 == 0 ) $m184r105="";
$m184r106=$hlavicka->m184r106; if ( $m184r106 == 0 ) $m184r106="";
$m184r111=$hlavicka->m184r111; if ( $m184r111 == 0 ) $m184r111="";
$m184r112=$hlavicka->m184r112; if ( $m184r112 == 0 ) $m184r112="";
$m184r113=$hlavicka->m184r113; if ( $m184r113 == 0 ) $m184r113="";
$m184r114=$hlavicka->m184r114; if ( $m184r114 == 0 ) $m184r114="";
$m184r115=$hlavicka->m184r115; if ( $m184r115 == 0 ) $m184r115="";
$m184r116=$hlavicka->m184r116; if ( $m184r116 == 0 ) $m184r116="";
$m184r121=$hlavicka->m184r121; if ( $m184r121 == 0 ) $m184r121="";
$m184r122=$hlavicka->m184r122; if ( $m184r122 == 0 ) $m184r122="";
$m184r123=$hlavicka->m184r123; if ( $m184r123 == 0 ) $m184r123="";
$m184r124=$hlavicka->m184r124; if ( $m184r124 == 0 ) $m184r124="";
$m184r125=$hlavicka->m184r125; if ( $m184r125 == 0 ) $m184r125="";
$m184r126=$hlavicka->m184r126; if ( $m184r126 == 0 ) $m184r126="";
$m184r131=$hlavicka->m184r131; if ( $m184r131 == 0 ) $m184r131="";
$m184r132=$hlavicka->m184r132; if ( $m184r132 == 0 ) $m184r132="";
$m184r133=$hlavicka->m184r133; if ( $m184r133 == 0 ) $m184r133="";
$m184r134=$hlavicka->m184r134; if ( $m184r134 == 0 ) $m184r134="";
$m184r135=$hlavicka->m184r135; if ( $m184r135 == 0 ) $m184r135="";
$m184r136=$hlavicka->m184r136; if ( $m184r136 == 0 ) $m184r136="";
$m184r141=$hlavicka->m184r141; if ( $m184r141 == 0 ) $m184r141="";
$m184r142=$hlavicka->m184r142; if ( $m184r142 == 0 ) $m184r142="";
$m184r143=$hlavicka->m184r143; if ( $m184r143 == 0 ) $m184r143="";
$m184r144=$hlavicka->m184r144; if ( $m184r144 == 0 ) $m184r144="";
$m184r145=$hlavicka->m184r145; if ( $m184r145 == 0 ) $m184r145="";
$m184r146=$hlavicka->m184r146; if ( $m184r146 == 0 ) $m184r146="";
$m184r151=$hlavicka->m184r151; if ( $m184r151 == 0 ) $m184r151="";
$m184r152=$hlavicka->m184r152; if ( $m184r152 == 0 ) $m184r152="";
$m184r153=$hlavicka->m184r153; if ( $m184r153 == 0 ) $m184r153="";
$m184r154=$hlavicka->m184r154; if ( $m184r154 == 0 ) $m184r154="";
$m184r155=$hlavicka->m184r155; if ( $m184r155 == 0 ) $m184r155="";
$m184r156=$hlavicka->m184r156; if ( $m184r156 == 0 ) $m184r156="";
$m184r161=$hlavicka->m184r161; if ( $m184r161 == 0 ) $m184r161="";
$m184r162=$hlavicka->m184r162; if ( $m184r162 == 0 ) $m184r162="";
$m184r163=$hlavicka->m184r163; if ( $m184r163 == 0 ) $m184r163="";
$m184r164=$hlavicka->m184r164; if ( $m184r164 == 0 ) $m184r164="";
$m184r165=$hlavicka->m184r165; if ( $m184r165 == 0 ) $m184r165="";
$m184r166=$hlavicka->m184r166; if ( $m184r166 == 0 ) $m184r166="";
$m184r171=$hlavicka->m184r171; if ( $m184r171 == 0 ) $m184r171="";
$m184r172=$hlavicka->m184r172; if ( $m184r172 == 0 ) $m184r172="";
$m184r173=$hlavicka->m184r173; if ( $m184r173 == 0 ) $m184r173="";
$m184r174=$hlavicka->m184r174; if ( $m184r174 == 0 ) $m184r174="";
$m184r175=$hlavicka->m184r175; if ( $m184r175 == 0 ) $m184r175="";
$m184r176=$hlavicka->m184r176; if ( $m184r176 == 0 ) $m184r176="";
$m184r181=$hlavicka->m184r181; if ( $m184r181 == 0 ) $m184r181="";
$m184r182=$hlavicka->m184r182; if ( $m184r182 == 0 ) $m184r182="";
$m184r183=$hlavicka->m184r183; if ( $m184r183 == 0 ) $m184r183="";
$m184r184=$hlavicka->m184r184; if ( $m184r184 == 0 ) $m184r184="";
$m184r185=$hlavicka->m184r185; if ( $m184r185 == 0 ) $m184r185="";
$m184r186=$hlavicka->m184r186; if ( $m184r186 == 0 ) $m184r186="";
$m184r191=$hlavicka->m184r191; if ( $m184r191 == 0 ) $m184r191="";
$m184r192=$hlavicka->m184r192; if ( $m184r192 == 0 ) $m184r192="";
$m184r193=$hlavicka->m184r193; if ( $m184r193 == 0 ) $m184r193="";
$m184r194=$hlavicka->m184r194; if ( $m184r194 == 0 ) $m184r194="";
$m184r195=$hlavicka->m184r195; if ( $m184r195 == 0 ) $m184r195="";
$m184r196=$hlavicka->m184r196; if ( $m184r196 == 0 ) $m184r196="";
$m184r201=$hlavicka->m184r201; if ( $m184r201 == 0 ) $m184r201="";
$m184r202=$hlavicka->m184r202; if ( $m184r202 == 0 ) $m184r202="";
$m184r203=$hlavicka->m184r203; if ( $m184r203 == 0 ) $m184r203="";
$m184r204=$hlavicka->m184r204; if ( $m184r204 == 0 ) $m184r204="";
$m184r205=$hlavicka->m184r205; if ( $m184r205 == 0 ) $m184r205="";
$m184r206=$hlavicka->m184r206; if ( $m184r206 == 0 ) $m184r206="";
$m184r211=$hlavicka->m184r211; if ( $m184r211 == 0 ) $m184r211="";
$m184r212=$hlavicka->m184r212; if ( $m184r212 == 0 ) $m184r212="";
$m184r213=$hlavicka->m184r213; if ( $m184r213 == 0 ) $m184r213="";
$m184r214=$hlavicka->m184r214; if ( $m184r214 == 0 ) $m184r214="";
$m184r215=$hlavicka->m184r215; if ( $m184r215 == 0 ) $m184r215="";
$m184r216=$hlavicka->m184r216; if ( $m184r216 == 0 ) $m184r216="";
$m184r221=$hlavicka->m184r221; if ( $m184r221 == 0 ) $m184r221="";
$m184r222=$hlavicka->m184r222; if ( $m184r222 == 0 ) $m184r222="";
$m184r223=$hlavicka->m184r223; if ( $m184r223 == 0 ) $m184r223="";
$m184r224=$hlavicka->m184r224; if ( $m184r224 == 0 ) $m184r224="";
$m184r225=$hlavicka->m184r225; if ( $m184r225 == 0 ) $m184r225="";
$m184r226=$hlavicka->m184r226; if ( $m184r226 == 0 ) $m184r226="";
$m184r231=$hlavicka->m184r231; if ( $m184r231 == 0 ) $m184r231="";
$m184r232=$hlavicka->m184r232; if ( $m184r232 == 0 ) $m184r232="";
$m184r233=$hlavicka->m184r233; if ( $m184r233 == 0 ) $m184r233="";
$m184r234=$hlavicka->m184r234; if ( $m184r234 == 0 ) $m184r234="";
$m184r235=$hlavicka->m184r235; if ( $m184r235 == 0 ) $m184r235="";
$m184r236=$hlavicka->m184r236; if ( $m184r236 == 0 ) $m184r236="";
$m184r241=$hlavicka->m184r241; if ( $m184r241 == 0 ) $m184r241="";
$m184r242=$hlavicka->m184r242; if ( $m184r242 == 0 ) $m184r242="";
$m184r243=$hlavicka->m184r243; if ( $m184r243 == 0 ) $m184r243="";
$m184r244=$hlavicka->m184r244; if ( $m184r244 == 0 ) $m184r244="";
$m184r245=$hlavicka->m184r245; if ( $m184r245 == 0 ) $m184r245="";
$m184r246=$hlavicka->m184r246; if ( $m184r246 == 0 ) $m184r246="";
$m184r251=$hlavicka->m184r251; if ( $m184r251 == 0 ) $m184r251="";
$m184r252=$hlavicka->m184r252; if ( $m184r252 == 0 ) $m184r252="";
$m184r253=$hlavicka->m184r253; if ( $m184r253 == 0 ) $m184r253="";
$m184r254=$hlavicka->m184r254; if ( $m184r254 == 0 ) $m184r254="";
$m184r255=$hlavicka->m184r255; if ( $m184r255 == 0 ) $m184r255="";
$m184r256=$hlavicka->m184r256; if ( $m184r256 == 0 ) $m184r256="";
$m184r261=$hlavicka->m184r261; if ( $m184r261 == 0 ) $m184r261="";
$m184r262=$hlavicka->m184r262; if ( $m184r262 == 0 ) $m184r262="";
$m184r263=$hlavicka->m184r263; if ( $m184r263 == 0 ) $m184r263="";
$m184r264=$hlavicka->m184r264; if ( $m184r264 == 0 ) $m184r264="";
$m184r265=$hlavicka->m184r265; if ( $m184r265 == 0 ) $m184r265="";
$m184r266=$hlavicka->m184r266; if ( $m184r266 == 0 ) $m184r266="";
$m184r271=$hlavicka->m184r271; if ( $m184r271 == 0 ) $m184r271="";
$m184r272=$hlavicka->m184r272; if ( $m184r272 == 0 ) $m184r272="";
$m184r273=$hlavicka->m184r273; if ( $m184r273 == 0 ) $m184r273="";
$m184r274=$hlavicka->m184r274; if ( $m184r274 == 0 ) $m184r274="";
$m184r275=$hlavicka->m184r275; if ( $m184r275 == 0 ) $m184r275="";
$m184r276=$hlavicka->m184r276; if ( $m184r276 == 0 ) $m184r276="";
$m184r281=$hlavicka->m184r281; if ( $m184r281 == 0 ) $m184r281="";
$m184r282=$hlavicka->m184r282; if ( $m184r282 == 0 ) $m184r282="";
$m184r283=$hlavicka->m184r283; if ( $m184r283 == 0 ) $m184r283="";
$m184r284=$hlavicka->m184r284; if ( $m184r284 == 0 ) $m184r284="";
$m184r285=$hlavicka->m184r285; if ( $m184r285 == 0 ) $m184r285="";
$m184r286=$hlavicka->m184r286; if ( $m184r286 == 0 ) $m184r286="";
$m184r291=$hlavicka->m184r291; if ( $m184r291 == 0 ) $m184r291="";
$m184r292=$hlavicka->m184r292; if ( $m184r292 == 0 ) $m184r292="";
$m184r293=$hlavicka->m184r293; if ( $m184r293 == 0 ) $m184r293="";
$m184r294=$hlavicka->m184r294; if ( $m184r294 == 0 ) $m184r294="";
$m184r295=$hlavicka->m184r295; if ( $m184r295 == 0 ) $m184r295="";
$m184r296=$hlavicka->m184r296; if ( $m184r296 == 0 ) $m184r296="";
$m184r301=$hlavicka->m184r301; if ( $m184r301 == 0 ) $m184r301="";
$m184r302=$hlavicka->m184r302; if ( $m184r302 == 0 ) $m184r302="";
$m184r303=$hlavicka->m184r303; if ( $m184r303 == 0 ) $m184r303="";
$m184r304=$hlavicka->m184r304; if ( $m184r304 == 0 ) $m184r304="";
$m184r305=$hlavicka->m184r305; if ( $m184r305 == 0 ) $m184r305="";
$m184r306=$hlavicka->m184r306; if ( $m184r306 == 0 ) $m184r306="";
$m184r311=$hlavicka->m184r311; if ( $m184r311 == 0 ) $m184r311="";
$m184r312=$hlavicka->m184r312; if ( $m184r312 == 0 ) $m184r312="";
$m184r313=$hlavicka->m184r313; if ( $m184r313 == 0 ) $m184r313="";
$m184r314=$hlavicka->m184r314; if ( $m184r314 == 0 ) $m184r314="";
$m184r315=$hlavicka->m184r315; if ( $m184r315 == 0 ) $m184r315="";
$m184r316=$hlavicka->m184r316; if ( $m184r316 == 0 ) $m184r316="";
$m184r321=$hlavicka->m184r321; if ( $m184r321 == 0 ) $m184r321="";
$m184r322=$hlavicka->m184r322; if ( $m184r322 == 0 ) $m184r322="";
$m184r323=$hlavicka->m184r323; if ( $m184r323 == 0 ) $m184r323="";
$m184r324=$hlavicka->m184r324; if ( $m184r324 == 0 ) $m184r324="";
$m184r325=$hlavicka->m184r325; if ( $m184r325 == 0 ) $m184r325="";
$m184r326=$hlavicka->m184r326; if ( $m184r326 == 0 ) $m184r326="";
$m184r992=$hlavicka->m184r992;
//if ( $m184r992 == 0 ) $m184r992="";
$m184r993=$hlavicka->m184r993;
//if ( $m184r993 == 0 ) $m184r993="";
$m184r994=$hlavicka->m184r994;
//if ( $m184r994 == 0 ) $m184r994="";
$m184r995=$hlavicka->m184r995;
//if ( $m184r995 == 0 ) $m184r995="";
$m184r996=$hlavicka->m184r996;
//if ( $m184r996 == 0 ) $m184r996="";
$pdf->Cell(195,38," ","$rmc1",1,"L");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"$m184r11","$rmc",0,"R");$pdf->Cell(25,7,"$m184r12","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r13","$rmc",0,"R");$pdf->Cell(48,7,"$m184r14","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r15","$rmc",0,"R");$pdf->Cell(27,7,"$m184r16","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$m184r21","$rmc",0,"R");$pdf->Cell(25,6,"$m184r22","$rmc",0,"R");
$pdf->Cell(25,6,"$m184r23","$rmc",0,"R");$pdf->Cell(48,6,"$m184r24","$rmc",0,"R");
$pdf->Cell(28,6,"$m184r25","$rmc",0,"R");$pdf->Cell(27,6,"$m184r26","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"$m184r31","$rmc",0,"R");$pdf->Cell(25,7,"$m184r32","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r33","$rmc",0,"R");$pdf->Cell(48,7,"$m184r34","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r35","$rmc",0,"R");$pdf->Cell(27,7,"$m184r36","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$m184r41","$rmc",0,"R");$pdf->Cell(25,6,"$m184r42","$rmc",0,"R");
$pdf->Cell(25,6,"$m184r43","$rmc",0,"R");$pdf->Cell(48,6,"$m184r44","$rmc",0,"R");
$pdf->Cell(28,6,"$m184r45","$rmc",0,"R");$pdf->Cell(27,6,"$m184r46","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"$m184r51","$rmc",0,"R");$pdf->Cell(25,7,"$m184r52","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r53","$rmc",0,"R");$pdf->Cell(48,7,"$m184r54","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r55","$rmc",0,"R");$pdf->Cell(27,7,"$m184r56","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$m184r61","$rmc",0,"R");$pdf->Cell(25,6,"$m184r62","$rmc",0,"R");
$pdf->Cell(25,6,"$m184r63","$rmc",0,"R");$pdf->Cell(48,6,"$m184r64","$rmc",0,"R");
$pdf->Cell(28,6,"$m184r65","$rmc",0,"R");$pdf->Cell(27,6,"$m184r66","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"$m184r71","$rmc",0,"R");$pdf->Cell(25,7,"$m184r72","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r73","$rmc",0,"R");$pdf->Cell(48,7,"$m184r74","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r75","$rmc",0,"R");$pdf->Cell(27,7,"$m184r76","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$m184r81","$rmc",0,"R");$pdf->Cell(25,6,"$m184r82","$rmc",0,"R");
$pdf->Cell(25,6,"$m184r83","$rmc",0,"R");$pdf->Cell(48,6,"$m184r84","$rmc",0,"R");
$pdf->Cell(28,6,"$m184r85","$rmc",0,"R");$pdf->Cell(27,6,"$m184r86","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"$m184r91","$rmc",0,"R");$pdf->Cell(25,7,"$m184r92","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r93","$rmc",0,"R");$pdf->Cell(48,7,"$m184r94","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r95","$rmc",0,"R");$pdf->Cell(27,7,"$m184r96","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$m184r101","$rmc",0,"R");$pdf->Cell(25,6,"$m184r102","$rmc",0,"R");
$pdf->Cell(25,6,"$m184r103","$rmc",0,"R");$pdf->Cell(48,6,"$m184r104","$rmc",0,"R");
$pdf->Cell(28,6,"$m184r105","$rmc",0,"R");$pdf->Cell(27,6,"$m184r106","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"$m184r111","$rmc",0,"R");$pdf->Cell(25,7,"$m184r112","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r113","$rmc",0,"R");$pdf->Cell(48,7,"$m184r114","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r115","$rmc",0,"R");$pdf->Cell(27,7,"$m184r116","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$m184r121","$rmc",0,"R");$pdf->Cell(25,6,"$m184r122","$rmc",0,"R");
$pdf->Cell(25,6,"$m184r123","$rmc",0,"R");$pdf->Cell(48,6,"$m184r124","$rmc",0,"R");
$pdf->Cell(28,6,"$m184r125","$rmc",0,"R");$pdf->Cell(27,6,"$m184r126","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"$m184r131","$rmc",0,"R");$pdf->Cell(25,7,"$m184r132","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r133","$rmc",0,"R");$pdf->Cell(48,7,"$m184r134","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r135","$rmc",0,"R");$pdf->Cell(27,7,"$m184r136","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$m184r141","$rmc",0,"R");$pdf->Cell(25,6,"$m184r142","$rmc",0,"R");
$pdf->Cell(25,6,"$m184r143","$rmc",0,"R");$pdf->Cell(48,6,"$m184r144","$rmc",0,"R");
$pdf->Cell(28,6,"$m184r145","$rmc",0,"R");$pdf->Cell(27,6,"$m184r146","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"$m184r151","$rmc",0,"R");$pdf->Cell(25,7,"$m184r152","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r153","$rmc",0,"R");$pdf->Cell(48,7,"$m184r154","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r155","$rmc",0,"R");$pdf->Cell(27,7,"$m184r156","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$m184r161","$rmc",0,"R");$pdf->Cell(25,6,"$m184r162","$rmc",0,"R");
$pdf->Cell(25,6,"$m184r163","$rmc",0,"R");$pdf->Cell(48,6,"$m184r164","$rmc",0,"R");
$pdf->Cell(28,6,"$m184r165","$rmc",0,"R");$pdf->Cell(27,6,"$m184r166","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"$m184r171","$rmc",0,"R");$pdf->Cell(25,7,"$m184r172","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r173","$rmc",0,"R");$pdf->Cell(48,7,"$m184r174","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r175","$rmc",0,"R");$pdf->Cell(27,7,"$m184r176","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$m184r181","$rmc",0,"R");$pdf->Cell(25,6,"$m184r182","$rmc",0,"R");
$pdf->Cell(25,6,"$m184r183","$rmc",0,"R");$pdf->Cell(48,6,"$m184r184","$rmc",0,"R");
$pdf->Cell(28,6,"$m184r185","$rmc",0,"R");$pdf->Cell(27,6,"$m184r186","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"$m184r191","$rmc",0,"R");$pdf->Cell(25,7,"$m184r192","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r193","$rmc",0,"R");$pdf->Cell(48,7,"$m184r194","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r195","$rmc",0,"R");$pdf->Cell(27,7,"$m184r196","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$m184r201","$rmc",0,"R");$pdf->Cell(25,6,"$m184r202","$rmc",0,"R");
$pdf->Cell(25,6,"$m184r203","$rmc",0,"R");$pdf->Cell(48,6,"$m184r204","$rmc",0,"R");
$pdf->Cell(28,6,"$m184r205","$rmc",0,"R");$pdf->Cell(27,6,"$m184r206","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"$m184r211","$rmc",0,"R");$pdf->Cell(25,7,"$m184r212","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r213","$rmc",0,"R");$pdf->Cell(48,7,"$m184r214","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r215","$rmc",0,"R");$pdf->Cell(27,7,"$m184r216","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$m184r221","$rmc",0,"R");$pdf->Cell(25,6,"$m184r222","$rmc",0,"R");
$pdf->Cell(25,6,"$m184r223","$rmc",0,"R");$pdf->Cell(48,6,"$m184r224","$rmc",0,"R");
$pdf->Cell(28,6,"$m184r225","$rmc",0,"R");$pdf->Cell(27,6,"$m184r226","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"$m184r231","$rmc",0,"R");$pdf->Cell(25,7,"$m184r232","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r233","$rmc",0,"R");$pdf->Cell(48,7,"$m184r234","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r235","$rmc",0,"R");$pdf->Cell(27,7,"$m184r236","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$m184r241","$rmc",0,"R");$pdf->Cell(25,6,"$m184r242","$rmc",0,"R");
$pdf->Cell(25,6,"$m184r243","$rmc",0,"R");$pdf->Cell(48,6,"$m184r244","$rmc",0,"R");
$pdf->Cell(28,6,"$m184r245","$rmc",0,"R");$pdf->Cell(27,6,"$m184r246","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"$m184r251","$rmc",0,"R");$pdf->Cell(25,7,"$m184r252","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r253","$rmc",0,"R");$pdf->Cell(48,7,"$m184r254","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r255","$rmc",0,"R");$pdf->Cell(27,7,"$m184r256","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$m184r261","$rmc",0,"R");$pdf->Cell(25,6,"$m184r262","$rmc",0,"R");
$pdf->Cell(25,6,"$m184r263","$rmc",0,"R");$pdf->Cell(48,6,"$m184r264","$rmc",0,"R");
$pdf->Cell(28,6,"$m184r265","$rmc",0,"R");$pdf->Cell(27,6,"$m184r266","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"$m184r271","$rmc",0,"R");$pdf->Cell(25,7,"$m184r272","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r273","$rmc",0,"R");$pdf->Cell(48,7,"$m184r274","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r275","$rmc",0,"R");$pdf->Cell(27,7,"$m184r276","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$m184r281","$rmc",0,"R");$pdf->Cell(25,6,"$m184r282","$rmc",0,"R");
$pdf->Cell(25,6,"$m184r283","$rmc",0,"R");$pdf->Cell(48,6,"$m184r284","$rmc",0,"R");
$pdf->Cell(28,6,"$m184r285","$rmc",0,"R");$pdf->Cell(27,6,"$m184r286","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"$m184r291","$rmc",0,"R");$pdf->Cell(25,7,"$m184r292","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r293","$rmc",0,"R");$pdf->Cell(48,7,"$m184r294","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r295","$rmc",0,"R");$pdf->Cell(27,7,"$m184r296","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$m184r301","$rmc",0,"R");$pdf->Cell(25,6,"$m184r302","$rmc",0,"R");
$pdf->Cell(25,6,"$m184r303","$rmc",0,"R");$pdf->Cell(48,6,"$m184r304","$rmc",0,"R");
$pdf->Cell(28,6,"$m184r305","$rmc",0,"R");$pdf->Cell(27,6,"$m184r306","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"$m184r311","$rmc",0,"R");$pdf->Cell(25,7,"$m184r312","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r313","$rmc",0,"R");$pdf->Cell(48,7,"$m184r314","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r315","$rmc",0,"R");$pdf->Cell(27,7,"$m184r316","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$m184r321","$rmc",0,"R");$pdf->Cell(25,6,"$m184r322","$rmc",0,"R");
$pdf->Cell(25,6,"$m184r323","$rmc",0,"R");$pdf->Cell(48,6,"$m184r324","$rmc",0,"R");
$pdf->Cell(28,6,"$m184r325","$rmc",0,"R");$pdf->Cell(27,6,"$m184r326","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(26,7,"","$rmc",0,"R");$pdf->Cell(25,7,"$m184r992","$rmc",0,"R");
$pdf->Cell(25,7,"$m184r993","$rmc",0,"R");$pdf->Cell(48,7,"$m184r994","$rmc",0,"R");
$pdf->Cell(28,7,"$m184r995","$rmc",0,"R");$pdf->Cell(27,7,"$m184r996","$rmc",1,"R");
                                       }

if ( $strana == 8 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str8.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str8.jpg',0,0,210,297);
}
$pdf->SetY(10);

//modul 185
$m185r11=$hlavicka->m185r11; if ( $m185r11 == 0 ) $m185r11="";
$m185r12=$hlavicka->m185r12; if ( $m185r12 == 0 ) $m185r12="";
$m185r13=$hlavicka->m185r13; if ( $m185r13 == 0 ) $m185r13="";
$m185r14=$hlavicka->m185r14; if ( $m185r14 == 0 ) $m185r14="";
$m185r15=$hlavicka->m185r15; if ( $m185r15 == 0 ) $m185r15="";
$m185r16=$hlavicka->m185r16; if ( $m185r16 == 0 ) $m185r16="";
$m185r17=$hlavicka->m185r17; if ( $m185r17 == 0 ) $m185r17="";
$m185r21=$hlavicka->m185r21; if ( $m185r21 == 0 ) $m185r21="";
$m185r22=$hlavicka->m185r22; if ( $m185r22 == 0 ) $m185r22="";
$m185r23=$hlavicka->m185r23; if ( $m185r23 == 0 ) $m185r23="";
$m185r24=$hlavicka->m185r24; if ( $m185r24 == 0 ) $m185r24="";
$m185r25=$hlavicka->m185r25; if ( $m185r25 == 0 ) $m185r25="";
$m185r26=$hlavicka->m185r26; if ( $m185r26 == 0 ) $m185r26="";
$m185r27=$hlavicka->m185r27; if ( $m185r27 == 0 ) $m185r27="";
$m185r31=$hlavicka->m185r31; if ( $m185r31 == 0 ) $m185r31="";
$m185r32=$hlavicka->m185r32; if ( $m185r32 == 0 ) $m185r32="";
$m185r33=$hlavicka->m185r33; if ( $m185r33 == 0 ) $m185r33="";
$m185r34=$hlavicka->m185r34; if ( $m185r34 == 0 ) $m185r34="";
$m185r35=$hlavicka->m185r35; if ( $m185r35 == 0 ) $m185r35="";
$m185r36=$hlavicka->m185r36; if ( $m185r36 == 0 ) $m185r36="";
$m185r37=$hlavicka->m185r37; if ( $m185r37 == 0 ) $m185r37="";
$m185r41=$hlavicka->m185r41; if ( $m185r41 == 0 ) $m185r41="";
$m185r42=$hlavicka->m185r42; if ( $m185r42 == 0 ) $m185r42="";
$m185r43=$hlavicka->m185r43; if ( $m185r43 == 0 ) $m185r43="";
$m185r44=$hlavicka->m185r44; if ( $m185r44 == 0 ) $m185r44="";
$m185r45=$hlavicka->m185r45; if ( $m185r45 == 0 ) $m185r45="";
$m185r46=$hlavicka->m185r46; if ( $m185r46 == 0 ) $m185r46="";
$m185r47=$hlavicka->m185r47; if ( $m185r47 == 0 ) $m185r47="";
$m185r51=$hlavicka->m185r51; if ( $m185r51 == 0 ) $m185r51="";
$m185r52=$hlavicka->m185r52; if ( $m185r52 == 0 ) $m185r52="";
$m185r53=$hlavicka->m185r53; if ( $m185r53 == 0 ) $m185r53="";
$m185r54=$hlavicka->m185r54; if ( $m185r54 == 0 ) $m185r54="";
$m185r55=$hlavicka->m185r55; if ( $m185r55 == 0 ) $m185r55="";
$m185r56=$hlavicka->m185r56; if ( $m185r56 == 0 ) $m185r56="";
$m185r57=$hlavicka->m185r57; if ( $m185r57 == 0 ) $m185r57="";
$m185r61=$hlavicka->m185r61; if ( $m185r61 == 0 ) $m185r61="";
$m185r62=$hlavicka->m185r62; if ( $m185r62 == 0 ) $m185r62="";
$m185r63=$hlavicka->m185r63; if ( $m185r63 == 0 ) $m185r63="";
$m185r64=$hlavicka->m185r64; if ( $m185r64 == 0 ) $m185r64="";
$m185r65=$hlavicka->m185r65; if ( $m185r65 == 0 ) $m185r65="";
$m185r66=$hlavicka->m185r66; if ( $m185r66 == 0 ) $m185r66="";
$m185r67=$hlavicka->m185r67; if ( $m185r67 == 0 ) $m185r67="";
$m185r71=$hlavicka->m185r71; if ( $m185r71 == 0 ) $m185r71="";
$m185r72=$hlavicka->m185r72; if ( $m185r72 == 0 ) $m185r72="";
$m185r73=$hlavicka->m185r73; if ( $m185r73 == 0 ) $m185r73="";
$m185r74=$hlavicka->m185r74; if ( $m185r74 == 0 ) $m185r74="";
$m185r75=$hlavicka->m185r75; if ( $m185r75 == 0 ) $m185r75="";
$m185r76=$hlavicka->m185r76; if ( $m185r76 == 0 ) $m185r76="";
$m185r77=$hlavicka->m185r77; if ( $m185r77 == 0 ) $m185r77="";
$m185r81=$hlavicka->m185r81; if ( $m185r81 == 0 ) $m185r81="";
$m185r82=$hlavicka->m185r82; if ( $m185r82 == 0 ) $m185r82="";
$m185r83=$hlavicka->m185r83; if ( $m185r83 == 0 ) $m185r83="";
$m185r84=$hlavicka->m185r84; if ( $m185r84 == 0 ) $m185r84="";
$m185r85=$hlavicka->m185r85; if ( $m185r85 == 0 ) $m185r85="";
$m185r86=$hlavicka->m185r86; if ( $m185r86 == 0 ) $m185r86="";
$m185r87=$hlavicka->m185r87; if ( $m185r87 == 0 ) $m185r87="";
$m185r91=$hlavicka->m185r91; if ( $m185r91 == 0 ) $m185r91="";
$m185r92=$hlavicka->m185r92; if ( $m185r92 == 0 ) $m185r92="";
$m185r93=$hlavicka->m185r93; if ( $m185r93 == 0 ) $m185r93="";
$m185r94=$hlavicka->m185r94; if ( $m185r94 == 0 ) $m185r94="";
$m185r95=$hlavicka->m185r95; if ( $m185r95 == 0 ) $m185r95="";
$m185r96=$hlavicka->m185r96; if ( $m185r96 == 0 ) $m185r96="";
$m185r97=$hlavicka->m185r97; if ( $m185r97 == 0 ) $m185r97="";
$m185r101=$hlavicka->m185r101; if ( $m185r101 == 0 ) $m185r101="";
$m185r102=$hlavicka->m185r102; if ( $m185r102 == 0 ) $m185r102="";
$m185r103=$hlavicka->m185r103; if ( $m185r103 == 0 ) $m185r103="";
$m185r104=$hlavicka->m185r104; if ( $m185r104 == 0 ) $m185r104="";
$m185r105=$hlavicka->m185r105; if ( $m185r105 == 0 ) $m185r105="";
$m185r106=$hlavicka->m185r106; if ( $m185r106 == 0 ) $m185r106="";
$m185r107=$hlavicka->m185r107; if ( $m185r107 == 0 ) $m185r107="";
$m185r111=$hlavicka->m185r111; if ( $m185r111 == 0 ) $m185r111="";
$m185r112=$hlavicka->m185r112; if ( $m185r112 == 0 ) $m185r112="";
$m185r113=$hlavicka->m185r113; if ( $m185r113 == 0 ) $m185r113="";
$m185r114=$hlavicka->m185r114; if ( $m185r114 == 0 ) $m185r114="";
$m185r115=$hlavicka->m185r115; if ( $m185r115 == 0 ) $m185r115="";
$m185r116=$hlavicka->m185r116; if ( $m185r116 == 0 ) $m185r116="";
$m185r117=$hlavicka->m185r117; if ( $m185r117 == 0 ) $m185r117="";
$m185r121=$hlavicka->m185r121; if ( $m185r121 == 0 ) $m185r121="";
$m185r122=$hlavicka->m185r122; if ( $m185r122 == 0 ) $m185r122="";
$m185r123=$hlavicka->m185r123; if ( $m185r123 == 0 ) $m185r123="";
$m185r124=$hlavicka->m185r124; if ( $m185r124 == 0 ) $m185r124="";
$m185r125=$hlavicka->m185r125; if ( $m185r125 == 0 ) $m185r125="";
$m185r126=$hlavicka->m185r126; if ( $m185r126 == 0 ) $m185r126="";
$m185r127=$hlavicka->m185r127; if ( $m185r127 == 0 ) $m185r127="";
$m185r131=$hlavicka->m185r131; if ( $m185r131 == 0 ) $m185r131="";
$m185r132=$hlavicka->m185r132; if ( $m185r132 == 0 ) $m185r132="";
$m185r133=$hlavicka->m185r133; if ( $m185r133 == 0 ) $m185r133="";
$m185r134=$hlavicka->m185r134; if ( $m185r134 == 0 ) $m185r134="";
$m185r135=$hlavicka->m185r135; if ( $m185r135 == 0 ) $m185r135="";
$m185r136=$hlavicka->m185r136; if ( $m185r136 == 0 ) $m185r136="";
$m185r137=$hlavicka->m185r137; if ( $m185r137 == 0 ) $m185r137="";
$m185r141=$hlavicka->m185r141; if ( $m185r141 == 0 ) $m185r141="";
$m185r142=$hlavicka->m185r142; if ( $m185r142 == 0 ) $m185r142="";
$m185r143=$hlavicka->m185r143; if ( $m185r143 == 0 ) $m185r143="";
$m185r144=$hlavicka->m185r144; if ( $m185r144 == 0 ) $m185r144="";
$m185r145=$hlavicka->m185r145; if ( $m185r145 == 0 ) $m185r145="";
$m185r146=$hlavicka->m185r146; if ( $m185r146 == 0 ) $m185r146="";
$m185r147=$hlavicka->m185r147; if ( $m185r147 == 0 ) $m185r147="";
$m185r151=$hlavicka->m185r151; if ( $m185r151 == 0 ) $m185r151="";
$m185r152=$hlavicka->m185r152; if ( $m185r152 == 0 ) $m185r152="";
$m185r153=$hlavicka->m185r153; if ( $m185r153 == 0 ) $m185r153="";
$m185r154=$hlavicka->m185r154; if ( $m185r154 == 0 ) $m185r154="";
$m185r155=$hlavicka->m185r155; if ( $m185r155 == 0 ) $m185r155="";
$m185r156=$hlavicka->m185r156; if ( $m185r156 == 0 ) $m185r156="";
$m185r157=$hlavicka->m185r157; if ( $m185r157 == 0 ) $m185r157="";
$m185r161=$hlavicka->m185r161; if ( $m185r161 == 0 ) $m185r161="";
$m185r162=$hlavicka->m185r162; if ( $m185r162 == 0 ) $m185r162="";
$m185r163=$hlavicka->m185r163; if ( $m185r163 == 0 ) $m185r163="";
$m185r164=$hlavicka->m185r164; if ( $m185r164 == 0 ) $m185r164="";
$m185r165=$hlavicka->m185r165; if ( $m185r165 == 0 ) $m185r165="";
$m185r166=$hlavicka->m185r166; if ( $m185r166 == 0 ) $m185r166="";
$m185r167=$hlavicka->m185r167; if ( $m185r167 == 0 ) $m185r167="";
$m185r171=$hlavicka->m185r171; if ( $m185r171 == 0 ) $m185r171="";
$m185r172=$hlavicka->m185r172; if ( $m185r172 == 0 ) $m185r172="";
$m185r173=$hlavicka->m185r173; if ( $m185r173 == 0 ) $m185r173="";
$m185r174=$hlavicka->m185r174; if ( $m185r174 == 0 ) $m185r174="";
$m185r175=$hlavicka->m185r175; if ( $m185r175 == 0 ) $m185r175="";
$m185r176=$hlavicka->m185r176; if ( $m185r176 == 0 ) $m185r176="";
$m185r177=$hlavicka->m185r177; if ( $m185r177 == 0 ) $m185r177="";
$m185r181=$hlavicka->m185r181; if ( $m185r181 == 0 ) $m185r181="";
$m185r182=$hlavicka->m185r182; if ( $m185r182 == 0 ) $m185r182="";
$m185r183=$hlavicka->m185r183; if ( $m185r183 == 0 ) $m185r183="";
$m185r184=$hlavicka->m185r184; if ( $m185r184 == 0 ) $m185r184="";
$m185r185=$hlavicka->m185r185; if ( $m185r185 == 0 ) $m185r185="";
$m185r186=$hlavicka->m185r186; if ( $m185r186 == 0 ) $m185r186="";
$m185r187=$hlavicka->m185r187; if ( $m185r187 == 0 ) $m185r187="";
$m185r191=$hlavicka->m185r191; if ( $m185r191 == 0 ) $m185r191="";
$m185r192=$hlavicka->m185r192; if ( $m185r192 == 0 ) $m185r192="";
$m185r193=$hlavicka->m185r193; if ( $m185r193 == 0 ) $m185r193="";
$m185r194=$hlavicka->m185r194; if ( $m185r194 == 0 ) $m185r194="";
$m185r195=$hlavicka->m185r195; if ( $m185r195 == 0 ) $m185r195="";
$m185r196=$hlavicka->m185r196; if ( $m185r196 == 0 ) $m185r196="";
$m185r197=$hlavicka->m185r197; if ( $m185r197 == 0 ) $m185r197="";
$m185r201=$hlavicka->m185r201; if ( $m185r201 == 0 ) $m185r201="";
$m185r202=$hlavicka->m185r202; if ( $m185r202 == 0 ) $m185r202="";
$m185r203=$hlavicka->m185r203; if ( $m185r203 == 0 ) $m185r203="";
$m185r204=$hlavicka->m185r204; if ( $m185r204 == 0 ) $m185r204="";
$m185r205=$hlavicka->m185r205; if ( $m185r205 == 0 ) $m185r205="";
$m185r206=$hlavicka->m185r206; if ( $m185r206 == 0 ) $m185r206="";
$m185r207=$hlavicka->m185r207; if ( $m185r207 == 0 ) $m185r207="";
$m185r211=$hlavicka->m185r211; if ( $m185r211 == 0 ) $m185r211="";
$m185r212=$hlavicka->m185r212; if ( $m185r212 == 0 ) $m185r212="";
$m185r213=$hlavicka->m185r213; if ( $m185r213 == 0 ) $m185r213="";
$m185r214=$hlavicka->m185r214; if ( $m185r214 == 0 ) $m185r214="";
$m185r215=$hlavicka->m185r215; if ( $m185r215 == 0 ) $m185r215="";
$m185r216=$hlavicka->m185r216; if ( $m185r216 == 0 ) $m185r216="";
$m185r217=$hlavicka->m185r217; if ( $m185r217 == 0 ) $m185r217="";
$m185r221=$hlavicka->m185r221; if ( $m185r221 == 0 ) $m185r221="";
$m185r222=$hlavicka->m185r222; if ( $m185r222 == 0 ) $m185r222="";
$m185r223=$hlavicka->m185r223; if ( $m185r223 == 0 ) $m185r223="";
$m185r224=$hlavicka->m185r224; if ( $m185r224 == 0 ) $m185r224="";
$m185r225=$hlavicka->m185r225; if ( $m185r225 == 0 ) $m185r225="";
$m185r226=$hlavicka->m185r226; if ( $m185r226 == 0 ) $m185r226="";
$m185r227=$hlavicka->m185r227; if ( $m185r227 == 0 ) $m185r227="";
$m185r231=$hlavicka->m185r231; if ( $m185r231 == 0 ) $m185r231="";
$m185r232=$hlavicka->m185r232; if ( $m185r232 == 0 ) $m185r232="";
$m185r233=$hlavicka->m185r233; if ( $m185r233 == 0 ) $m185r233="";
$m185r234=$hlavicka->m185r234; if ( $m185r234 == 0 ) $m185r234="";
$m185r235=$hlavicka->m185r235; if ( $m185r235 == 0 ) $m185r235="";
$m185r236=$hlavicka->m185r236; if ( $m185r236 == 0 ) $m185r236="";
$m185r237=$hlavicka->m185r237; if ( $m185r237 == 0 ) $m185r237="";
$m185r241=$hlavicka->m185r241; if ( $m185r241 == 0 ) $m185r241="";
$m185r242=$hlavicka->m185r242; if ( $m185r242 == 0 ) $m185r242="";
$m185r243=$hlavicka->m185r243; if ( $m185r243 == 0 ) $m185r243="";
$m185r244=$hlavicka->m185r244; if ( $m185r244 == 0 ) $m185r244="";
$m185r245=$hlavicka->m185r245; if ( $m185r245 == 0 ) $m185r245="";
$m185r246=$hlavicka->m185r246; if ( $m185r246 == 0 ) $m185r246="";
$m185r247=$hlavicka->m185r247; if ( $m185r247 == 0 ) $m185r247="";
$m185r251=$hlavicka->m185r251; if ( $m185r251 == 0 ) $m185r251="";
$m185r252=$hlavicka->m185r252; if ( $m185r252 == 0 ) $m185r252="";
$m185r253=$hlavicka->m185r253; if ( $m185r253 == 0 ) $m185r253="";
$m185r254=$hlavicka->m185r254; if ( $m185r254 == 0 ) $m185r254="";
$m185r255=$hlavicka->m185r255; if ( $m185r255 == 0 ) $m185r255="";
$m185r256=$hlavicka->m185r256; if ( $m185r256 == 0 ) $m185r256="";
$m185r257=$hlavicka->m185r257; if ( $m185r257 == 0 ) $m185r257="";
$m185r261=$hlavicka->m185r261; if ( $m185r261 == 0 ) $m185r261="";
$m185r262=$hlavicka->m185r262; if ( $m185r262 == 0 ) $m185r262="";
$m185r263=$hlavicka->m185r263; if ( $m185r263 == 0 ) $m185r263="";
$m185r264=$hlavicka->m185r264; if ( $m185r264 == 0 ) $m185r264="";
$m185r265=$hlavicka->m185r265; if ( $m185r265 == 0 ) $m185r265="";
$m185r266=$hlavicka->m185r266; if ( $m185r266 == 0 ) $m185r266="";
$m185r267=$hlavicka->m185r267; if ( $m185r267 == 0 ) $m185r267="";
$m185r271=$hlavicka->m185r271; if ( $m185r271 == 0 ) $m185r271="";
$m185r272=$hlavicka->m185r272; if ( $m185r272 == 0 ) $m185r272="";
$m185r273=$hlavicka->m185r273; if ( $m185r273 == 0 ) $m185r273="";
$m185r274=$hlavicka->m185r274; if ( $m185r274 == 0 ) $m185r274="";
$m185r275=$hlavicka->m185r275; if ( $m185r275 == 0 ) $m185r275="";
$m185r276=$hlavicka->m185r276; if ( $m185r276 == 0 ) $m185r276="";
$m185r277=$hlavicka->m185r277; if ( $m185r277 == 0 ) $m185r277="";
$m185r281=$hlavicka->m185r281; if ( $m185r281 == 0 ) $m185r281="";
$m185r282=$hlavicka->m185r282; if ( $m185r282 == 0 ) $m185r282="";
$m185r283=$hlavicka->m185r283; if ( $m185r283 == 0 ) $m185r283="";
$m185r284=$hlavicka->m185r284; if ( $m185r284 == 0 ) $m185r284="";
$m185r285=$hlavicka->m185r285; if ( $m185r285 == 0 ) $m185r285="";
$m185r286=$hlavicka->m185r286; if ( $m185r286 == 0 ) $m185r286="";
$m185r287=$hlavicka->m185r287; if ( $m185r287 == 0 ) $m185r287="";
$m185r291=$hlavicka->m185r291; if ( $m185r291 == 0 ) $m185r291="";
$m185r292=$hlavicka->m185r292; if ( $m185r292 == 0 ) $m185r292="";
$m185r293=$hlavicka->m185r293; if ( $m185r293 == 0 ) $m185r293="";
$m185r294=$hlavicka->m185r294; if ( $m185r294 == 0 ) $m185r294="";
$m185r295=$hlavicka->m185r295; if ( $m185r295 == 0 ) $m185r295="";
$m185r296=$hlavicka->m185r296; if ( $m185r296 == 0 ) $m185r296="";
$m185r297=$hlavicka->m185r297; if ( $m185r297 == 0 ) $m185r297="";
$m185r301=$hlavicka->m185r301; if ( $m185r301 == 0 ) $m185r301="";
$m185r302=$hlavicka->m185r302; if ( $m185r302 == 0 ) $m185r302="";
$m185r303=$hlavicka->m185r303; if ( $m185r303 == 0 ) $m185r303="";
$m185r304=$hlavicka->m185r304; if ( $m185r304 == 0 ) $m185r304="";
$m185r305=$hlavicka->m185r305; if ( $m185r305 == 0 ) $m185r305="";
$m185r306=$hlavicka->m185r306; if ( $m185r306 == 0 ) $m185r306="";
$m185r307=$hlavicka->m185r307; if ( $m185r307 == 0 ) $m185r307="";
$m185r992=$hlavicka->m185r992;
//if ( $m185r992 == 0 ) $m185r992="";
$m185r993=$hlavicka->m185r993;
//if ( $m185r993 == 0 ) $m185r993="";
$m185r994=$hlavicka->m185r994;
//if ( $m185r994 == 0 ) $m185r994="";
$m185r995=$hlavicka->m185r995;
//if ( $m185r995 == 0 ) $m185r995="";
$m185r996=$hlavicka->m185r996;
//if ( $m185r996 == 0 ) $m185r996="";
$m185r997=$hlavicka->m185r997;
//if ( $m185r997 == 0 ) $m185r997="";
$pdf->Cell(195,34," ","$rmc1",1,"L");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m185r11","$rmc",0,"R");$pdf->Cell(27,6,"$m185r12","$rmc",0,"R");
$pdf->Cell(25,6,"$m185r13","$rmc",0,"R");$pdf->Cell(28,6,"$m185r14","$rmc",0,"R");
$pdf->Cell(27,6,"$m185r15","$rmc",0,"R");$pdf->Cell(23,6,"$m185r16","$rmc",0,"R");
$pdf->Cell(22,6,"$m185r17","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m185r21","$rmc",0,"R");$pdf->Cell(27,7,"$m185r22","$rmc",0,"R");
$pdf->Cell(25,7,"$m185r23","$rmc",0,"R");$pdf->Cell(28,7,"$m185r24","$rmc",0,"R");
$pdf->Cell(27,7,"$m185r25","$rmc",0,"R");$pdf->Cell(23,7,"$m185r26","$rmc",0,"R");
$pdf->Cell(22,7,"$m185r27","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m185r31","$rmc",0,"R");$pdf->Cell(27,6,"$m185r32","$rmc",0,"R");
$pdf->Cell(25,6,"$m185r33","$rmc",0,"R");$pdf->Cell(28,6,"$m185r34","$rmc",0,"R");
$pdf->Cell(27,6,"$m185r35","$rmc",0,"R");$pdf->Cell(23,6,"$m185r36","$rmc",0,"R");
$pdf->Cell(22,6,"$m185r37","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m185r41","$rmc",0,"R");$pdf->Cell(27,7,"$m185r42","$rmc",0,"R");
$pdf->Cell(25,7,"$m185r43","$rmc",0,"R");$pdf->Cell(28,7,"$m185r44","$rmc",0,"R");
$pdf->Cell(27,7,"$m185r45","$rmc",0,"R");$pdf->Cell(23,7,"$m185r46","$rmc",0,"R");
$pdf->Cell(22,7,"$m185r47","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m185r51","$rmc",0,"R");$pdf->Cell(27,6,"$m185r52","$rmc",0,"R");
$pdf->Cell(25,6,"$m185r53","$rmc",0,"R");$pdf->Cell(28,6,"$m185r54","$rmc",0,"R");
$pdf->Cell(27,6,"$m185r55","$rmc",0,"R");$pdf->Cell(23,6,"$m185r56","$rmc",0,"R");
$pdf->Cell(22,6,"$m185r57","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m185r61","$rmc",0,"R");$pdf->Cell(27,7,"$m185r62","$rmc",0,"R");
$pdf->Cell(25,7,"$m185r63","$rmc",0,"R");$pdf->Cell(28,7,"$m185r64","$rmc",0,"R");
$pdf->Cell(27,7,"$m185r65","$rmc",0,"R");$pdf->Cell(23,7,"$m185r66","$rmc",0,"R");
$pdf->Cell(22,7,"$m185r67","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m185r71","$rmc",0,"R");$pdf->Cell(27,6,"$m185r72","$rmc",0,"R");
$pdf->Cell(25,6,"$m185r73","$rmc",0,"R");$pdf->Cell(28,6,"$m185r74","$rmc",0,"R");
$pdf->Cell(27,6,"$m185r75","$rmc",0,"R");$pdf->Cell(23,6,"$m185r76","$rmc",0,"R");
$pdf->Cell(22,6,"$m185r77","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m185r81","$rmc",0,"R");$pdf->Cell(27,7,"$m185r82","$rmc",0,"R");
$pdf->Cell(25,7,"$m185r83","$rmc",0,"R");$pdf->Cell(28,7,"$m185r84","$rmc",0,"R");
$pdf->Cell(27,7,"$m185r85","$rmc",0,"R");$pdf->Cell(23,7,"$m185r86","$rmc",0,"R");
$pdf->Cell(22,7,"$m185r87","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m185r91","$rmc",0,"R");$pdf->Cell(27,6,"$m185r92","$rmc",0,"R");
$pdf->Cell(25,6,"$m185r93","$rmc",0,"R");$pdf->Cell(28,6,"$m185r94","$rmc",0,"R");
$pdf->Cell(27,6,"$m185r95","$rmc",0,"R");$pdf->Cell(23,6,"$m185r96","$rmc",0,"R");
$pdf->Cell(22,6,"$m185r97","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m185r101","$rmc",0,"R");$pdf->Cell(27,7,"$m185r102","$rmc",0,"R");
$pdf->Cell(25,7,"$m185r103","$rmc",0,"R");$pdf->Cell(28,7,"$m185r104","$rmc",0,"R");
$pdf->Cell(27,7,"$m185r105","$rmc",0,"R");$pdf->Cell(23,7,"$m185r106","$rmc",0,"R");
$pdf->Cell(22,7,"$m185r107","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m185r111","$rmc",0,"R");$pdf->Cell(27,6,"$m185r112","$rmc",0,"R");
$pdf->Cell(25,6,"$m185r113","$rmc",0,"R");$pdf->Cell(28,6,"$m185r114","$rmc",0,"R");
$pdf->Cell(27,6,"$m185r115","$rmc",0,"R");$pdf->Cell(23,6,"$m185r116","$rmc",0,"R");
$pdf->Cell(22,6,"$m185r117","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m185r121","$rmc",0,"R");$pdf->Cell(27,7,"$m185r122","$rmc",0,"R");
$pdf->Cell(25,7,"$m185r123","$rmc",0,"R");$pdf->Cell(28,7,"$m185r124","$rmc",0,"R");
$pdf->Cell(27,7,"$m185r125","$rmc",0,"R");$pdf->Cell(23,7,"$m185r126","$rmc",0,"R");
$pdf->Cell(22,7,"$m185r127","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m185r131","$rmc",0,"R");$pdf->Cell(27,6,"$m185r132","$rmc",0,"R");
$pdf->Cell(25,6,"$m185r133","$rmc",0,"R");$pdf->Cell(28,6,"$m185r134","$rmc",0,"R");
$pdf->Cell(27,6,"$m185r135","$rmc",0,"R");$pdf->Cell(23,6,"$m185r136","$rmc",0,"R");
$pdf->Cell(22,6,"$m185r137","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m185r141","$rmc",0,"R");$pdf->Cell(27,7,"$m185r142","$rmc",0,"R");
$pdf->Cell(25,7,"$m185r143","$rmc",0,"R");$pdf->Cell(28,7,"$m185r144","$rmc",0,"R");
$pdf->Cell(27,7,"$m185r145","$rmc",0,"R");$pdf->Cell(23,7,"$m185r146","$rmc",0,"R");
$pdf->Cell(22,7,"$m185r147","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m185r151","$rmc",0,"R");$pdf->Cell(27,6,"$m185r152","$rmc",0,"R");
$pdf->Cell(25,6,"$m185r153","$rmc",0,"R");$pdf->Cell(28,6,"$m185r154","$rmc",0,"R");
$pdf->Cell(27,6,"$m185r155","$rmc",0,"R");$pdf->Cell(23,6,"$m185r156","$rmc",0,"R");
$pdf->Cell(22,6,"$m185r157","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m185r161","$rmc",0,"R");$pdf->Cell(27,7,"$m185r162","$rmc",0,"R");
$pdf->Cell(25,7,"$m185r163","$rmc",0,"R");$pdf->Cell(28,7,"$m185r164","$rmc",0,"R");
$pdf->Cell(27,7,"$m185r165","$rmc",0,"R");$pdf->Cell(23,7,"$m185r166","$rmc",0,"R");
$pdf->Cell(22,7,"$m185r167","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m185r171","$rmc",0,"R");$pdf->Cell(27,6,"$m185r172","$rmc",0,"R");
$pdf->Cell(25,6,"$m185r173","$rmc",0,"R");$pdf->Cell(28,6,"$m185r174","$rmc",0,"R");
$pdf->Cell(27,6,"$m185r175","$rmc",0,"R");$pdf->Cell(23,6,"$m185r176","$rmc",0,"R");
$pdf->Cell(22,6,"$m185r177","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m185r181","$rmc",0,"R");$pdf->Cell(27,7,"$m185r182","$rmc",0,"R");
$pdf->Cell(25,7,"$m185r183","$rmc",0,"R");$pdf->Cell(28,7,"$m185r184","$rmc",0,"R");
$pdf->Cell(27,7,"$m185r185","$rmc",0,"R");$pdf->Cell(23,7,"$m185r186","$rmc",0,"R");
$pdf->Cell(22,7,"$m185r187","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m185r191","$rmc",0,"R");$pdf->Cell(27,6,"$m185r192","$rmc",0,"R");
$pdf->Cell(25,6,"$m185r193","$rmc",0,"R");$pdf->Cell(28,6,"$m185r194","$rmc",0,"R");
$pdf->Cell(27,6,"$m185r195","$rmc",0,"R");$pdf->Cell(23,6,"$m185r196","$rmc",0,"R");
$pdf->Cell(22,6,"$m185r197","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m185r201","$rmc",0,"R");$pdf->Cell(27,7,"$m185r202","$rmc",0,"R");
$pdf->Cell(25,7,"$m185r203","$rmc",0,"R");$pdf->Cell(28,7,"$m185r204","$rmc",0,"R");
$pdf->Cell(27,7,"$m185r205","$rmc",0,"R");$pdf->Cell(23,7,"$m185r206","$rmc",0,"R");
$pdf->Cell(22,7,"$m185r207","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m185r211","$rmc",0,"R");$pdf->Cell(27,6,"$m185r212","$rmc",0,"R");
$pdf->Cell(25,6,"$m185r213","$rmc",0,"R");$pdf->Cell(28,6,"$m185r214","$rmc",0,"R");
$pdf->Cell(27,6,"$m185r215","$rmc",0,"R");$pdf->Cell(23,6,"$m185r216","$rmc",0,"R");
$pdf->Cell(22,6,"$m185r217","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m185r221","$rmc",0,"R");$pdf->Cell(27,7,"$m185r222","$rmc",0,"R");
$pdf->Cell(25,7,"$m185r223","$rmc",0,"R");$pdf->Cell(28,7,"$m185r224","$rmc",0,"R");
$pdf->Cell(27,7,"$m185r225","$rmc",0,"R");$pdf->Cell(23,7,"$m185r226","$rmc",0,"R");
$pdf->Cell(22,7,"$m185r227","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m185r231","$rmc",0,"R");$pdf->Cell(27,6,"$m185r232","$rmc",0,"R");
$pdf->Cell(25,6,"$m185r233","$rmc",0,"R");$pdf->Cell(28,6,"$m185r234","$rmc",0,"R");
$pdf->Cell(27,6,"$m185r235","$rmc",0,"R");$pdf->Cell(23,6,"$m185r236","$rmc",0,"R");
$pdf->Cell(22,6,"$m185r237","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m185r241","$rmc",0,"R");$pdf->Cell(27,7,"$m185r242","$rmc",0,"R");
$pdf->Cell(25,7,"$m185r243","$rmc",0,"R");$pdf->Cell(28,7,"$m185r244","$rmc",0,"R");
$pdf->Cell(27,7,"$m185r245","$rmc",0,"R");$pdf->Cell(23,7,"$m185r246","$rmc",0,"R");
$pdf->Cell(22,7,"$m185r247","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m185r251","$rmc",0,"R");$pdf->Cell(27,6,"$m185r252","$rmc",0,"R");
$pdf->Cell(25,6,"$m185r253","$rmc",0,"R");$pdf->Cell(28,6,"$m185r254","$rmc",0,"R");
$pdf->Cell(27,6,"$m185r255","$rmc",0,"R");$pdf->Cell(23,6,"$m185r256","$rmc",0,"R");
$pdf->Cell(22,6,"$m185r257","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m185r261","$rmc",0,"R");$pdf->Cell(27,7,"$m185r262","$rmc",0,"R");
$pdf->Cell(25,7,"$m185r263","$rmc",0,"R");$pdf->Cell(28,7,"$m185r264","$rmc",0,"R");
$pdf->Cell(27,7,"$m185r265","$rmc",0,"R");$pdf->Cell(23,7,"$m185r266","$rmc",0,"R");
$pdf->Cell(22,7,"$m185r267","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m185r271","$rmc",0,"R");$pdf->Cell(27,6,"$m185r272","$rmc",0,"R");
$pdf->Cell(25,6,"$m185r273","$rmc",0,"R");$pdf->Cell(28,6,"$m185r274","$rmc",0,"R");
$pdf->Cell(27,6,"$m185r275","$rmc",0,"R");$pdf->Cell(23,6,"$m185r276","$rmc",0,"R");
$pdf->Cell(22,6,"$m185r277","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m185r281","$rmc",0,"R");$pdf->Cell(27,7,"$m185r282","$rmc",0,"R");
$pdf->Cell(25,7,"$m185r283","$rmc",0,"R");$pdf->Cell(28,7,"$m185r284","$rmc",0,"R");
$pdf->Cell(27,7,"$m185r285","$rmc",0,"R");$pdf->Cell(23,7,"$m185r286","$rmc",0,"R");
$pdf->Cell(22,7,"$m185r287","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m185r291","$rmc",0,"R");$pdf->Cell(27,7,"$m185r292","$rmc",0,"R");
$pdf->Cell(25,7,"$m185r293","$rmc",0,"R");$pdf->Cell(28,7,"$m185r294","$rmc",0,"R");
$pdf->Cell(27,7,"$m185r295","$rmc",0,"R");$pdf->Cell(23,7,"$m185r296","$rmc",0,"R");
$pdf->Cell(22,7,"$m185r297","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m185r301","$rmc",0,"R");$pdf->Cell(27,6,"$m185r302","$rmc",0,"R");
$pdf->Cell(25,6,"$m185r303","$rmc",0,"R");$pdf->Cell(28,6,"$m185r304","$rmc",0,"R");
$pdf->Cell(27,6,"$m185r305","$rmc",0,"R");$pdf->Cell(23,6,"$m185r306","$rmc",0,"R");
$pdf->Cell(22,6,"$m185r307","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"","$rmc",0,"R");$pdf->Cell(27,7,"$m185r992","$rmc",0,"R");
$pdf->Cell(25,7,"$m185r993","$rmc",0,"R");$pdf->Cell(28,7,"$m185r994","$rmc",0,"R");
$pdf->Cell(27,7,"$m185r995","$rmc",0,"R");$pdf->Cell(23,7,"$m185r996","$rmc",0,"R");
$pdf->Cell(22,7,"$m185r997","$rmc",1,"R");
                                       }
}
$i = $i + 1;
  }
//koniec tlac strana 1 az 8


//vytlac strana 9 az 12
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_zav101s2 WHERE ico >= 0 "."";
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

if ( $strana == 9 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str9.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str9.jpg',0,0,210,297);
}
$pdf->SetY(10);

//modul 186
$m186r11=$hlavicka->m186r11; if ( $m186r11 == 0 ) $m186r11="";
$m186r12=$hlavicka->m186r12; if ( $m186r12 == 0 ) $m186r12="";
$m186r13=$hlavicka->m186r13; if ( $m186r13 == 0 ) $m186r13="";
$m186r14=$hlavicka->m186r14; if ( $m186r14 == 0 ) $m186r14="";
$m186r15=$hlavicka->m186r15; if ( $m186r15 == 0 ) $m186r15="";
$m186r16=$hlavicka->m186r16; if ( $m186r16 == 0 ) $m186r16="";
$m186r17=$hlavicka->m186r17; if ( $m186r17 == 0 ) $m186r17="";
$m186r21=$hlavicka->m186r21; if ( $m186r21 == 0 ) $m186r21="";
$m186r22=$hlavicka->m186r22; if ( $m186r22 == 0 ) $m186r22="";
$m186r23=$hlavicka->m186r23; if ( $m186r23 == 0 ) $m186r23="";
$m186r24=$hlavicka->m186r24; if ( $m186r24 == 0 ) $m186r24="";
$m186r25=$hlavicka->m186r25; if ( $m186r25 == 0 ) $m186r25="";
$m186r26=$hlavicka->m186r26; if ( $m186r26 == 0 ) $m186r26="";
$m186r27=$hlavicka->m186r27; if ( $m186r27 == 0 ) $m186r27="";
$m186r31=$hlavicka->m186r31; if ( $m186r31 == 0 ) $m186r31="";
$m186r32=$hlavicka->m186r32; if ( $m186r32 == 0 ) $m186r32="";
$m186r33=$hlavicka->m186r33; if ( $m186r33 == 0 ) $m186r33="";
$m186r34=$hlavicka->m186r34; if ( $m186r34 == 0 ) $m186r34="";
$m186r35=$hlavicka->m186r35; if ( $m186r35 == 0 ) $m186r35="";
$m186r36=$hlavicka->m186r36; if ( $m186r36 == 0 ) $m186r36="";
$m186r37=$hlavicka->m186r37; if ( $m186r37 == 0 ) $m186r37="";
$m186r41=$hlavicka->m186r41; if ( $m186r41 == 0 ) $m186r41="";
$m186r42=$hlavicka->m186r42; if ( $m186r42 == 0 ) $m186r42="";
$m186r43=$hlavicka->m186r43; if ( $m186r43 == 0 ) $m186r43="";
$m186r44=$hlavicka->m186r44; if ( $m186r44 == 0 ) $m186r44="";
$m186r45=$hlavicka->m186r45; if ( $m186r45 == 0 ) $m186r45="";
$m186r46=$hlavicka->m186r46; if ( $m186r46 == 0 ) $m186r46="";
$m186r47=$hlavicka->m186r47; if ( $m186r47 == 0 ) $m186r47="";
$m186r51=$hlavicka->m186r51; if ( $m186r51 == 0 ) $m186r51="";
$m186r52=$hlavicka->m186r52; if ( $m186r52 == 0 ) $m186r52="";
$m186r53=$hlavicka->m186r53; if ( $m186r53 == 0 ) $m186r53="";
$m186r54=$hlavicka->m186r54; if ( $m186r54 == 0 ) $m186r54="";
$m186r55=$hlavicka->m186r55; if ( $m186r55 == 0 ) $m186r55="";
$m186r56=$hlavicka->m186r56; if ( $m186r56 == 0 ) $m186r56="";
$m186r57=$hlavicka->m186r57; if ( $m186r57 == 0 ) $m186r57="";
$m186r61=$hlavicka->m186r61; if ( $m186r61 == 0 ) $m186r61="";
$m186r62=$hlavicka->m186r62; if ( $m186r62 == 0 ) $m186r62="";
$m186r63=$hlavicka->m186r63; if ( $m186r63 == 0 ) $m186r63="";
$m186r64=$hlavicka->m186r64; if ( $m186r64 == 0 ) $m186r64="";
$m186r65=$hlavicka->m186r65; if ( $m186r65 == 0 ) $m186r65="";
$m186r66=$hlavicka->m186r66; if ( $m186r66 == 0 ) $m186r66="";
$m186r67=$hlavicka->m186r67; if ( $m186r67 == 0 ) $m186r67="";
$m186r71=$hlavicka->m186r71; if ( $m186r71 == 0 ) $m186r71="";
$m186r72=$hlavicka->m186r72; if ( $m186r72 == 0 ) $m186r72="";
$m186r73=$hlavicka->m186r73; if ( $m186r73 == 0 ) $m186r73="";
$m186r74=$hlavicka->m186r74; if ( $m186r74 == 0 ) $m186r74="";
$m186r75=$hlavicka->m186r75; if ( $m186r75 == 0 ) $m186r75="";
$m186r76=$hlavicka->m186r76; if ( $m186r76 == 0 ) $m186r76="";
$m186r77=$hlavicka->m186r77; if ( $m186r77 == 0 ) $m186r77="";
$m186r81=$hlavicka->m186r81; if ( $m186r81 == 0 ) $m186r81="";
$m186r82=$hlavicka->m186r82; if ( $m186r82 == 0 ) $m186r82="";
$m186r83=$hlavicka->m186r83; if ( $m186r83 == 0 ) $m186r83="";
$m186r84=$hlavicka->m186r84; if ( $m186r84 == 0 ) $m186r84="";
$m186r85=$hlavicka->m186r85; if ( $m186r85 == 0 ) $m186r85="";
$m186r86=$hlavicka->m186r86; if ( $m186r86 == 0 ) $m186r86="";
$m186r87=$hlavicka->m186r87; if ( $m186r87 == 0 ) $m186r87="";
$m186r91=$hlavicka->m186r91; if ( $m186r91 == 0 ) $m186r91="";
$m186r92=$hlavicka->m186r92; if ( $m186r92 == 0 ) $m186r92="";
$m186r93=$hlavicka->m186r93; if ( $m186r93 == 0 ) $m186r93="";
$m186r94=$hlavicka->m186r94; if ( $m186r94 == 0 ) $m186r94="";
$m186r95=$hlavicka->m186r95; if ( $m186r95 == 0 ) $m186r95="";
$m186r96=$hlavicka->m186r96; if ( $m186r96 == 0 ) $m186r96="";
$m186r97=$hlavicka->m186r97; if ( $m186r97 == 0 ) $m186r97="";
$m186r101=$hlavicka->m186r101; if ( $m186r101 == 0 ) $m186r101="";
$m186r102=$hlavicka->m186r102; if ( $m186r102 == 0 ) $m186r102="";
$m186r103=$hlavicka->m186r103; if ( $m186r103 == 0 ) $m186r103="";
$m186r104=$hlavicka->m186r104; if ( $m186r104 == 0 ) $m186r104="";
$m186r105=$hlavicka->m186r105; if ( $m186r105 == 0 ) $m186r105="";
$m186r106=$hlavicka->m186r106; if ( $m186r106 == 0 ) $m186r106="";
$m186r107=$hlavicka->m186r107; if ( $m186r107 == 0 ) $m186r107="";
$m186r111=$hlavicka->m186r111; if ( $m186r111 == 0 ) $m186r111="";
$m186r112=$hlavicka->m186r112; if ( $m186r112 == 0 ) $m186r112="";
$m186r113=$hlavicka->m186r113; if ( $m186r113 == 0 ) $m186r113="";
$m186r114=$hlavicka->m186r114; if ( $m186r114 == 0 ) $m186r114="";
$m186r115=$hlavicka->m186r115; if ( $m186r115 == 0 ) $m186r115="";
$m186r116=$hlavicka->m186r116; if ( $m186r116 == 0 ) $m186r116="";
$m186r117=$hlavicka->m186r117; if ( $m186r117 == 0 ) $m186r117="";
$m186r121=$hlavicka->m186r121; if ( $m186r121 == 0 ) $m186r121="";
$m186r122=$hlavicka->m186r122; if ( $m186r122 == 0 ) $m186r122="";
$m186r123=$hlavicka->m186r123; if ( $m186r123 == 0 ) $m186r123="";
$m186r124=$hlavicka->m186r124; if ( $m186r124 == 0 ) $m186r124="";
$m186r125=$hlavicka->m186r125; if ( $m186r125 == 0 ) $m186r125="";
$m186r126=$hlavicka->m186r126; if ( $m186r126 == 0 ) $m186r126="";
$m186r127=$hlavicka->m186r127; if ( $m186r127 == 0 ) $m186r127="";
$m186r131=$hlavicka->m186r131; if ( $m186r131 == 0 ) $m186r131="";
$m186r132=$hlavicka->m186r132; if ( $m186r132 == 0 ) $m186r132="";
$m186r133=$hlavicka->m186r133; if ( $m186r133 == 0 ) $m186r133="";
$m186r134=$hlavicka->m186r134; if ( $m186r134 == 0 ) $m186r134="";
$m186r135=$hlavicka->m186r135; if ( $m186r135 == 0 ) $m186r135="";
$m186r136=$hlavicka->m186r136; if ( $m186r136 == 0 ) $m186r136="";
$m186r137=$hlavicka->m186r137; if ( $m186r137 == 0 ) $m186r137="";
$m186r141=$hlavicka->m186r141; if ( $m186r141 == 0 ) $m186r141="";
$m186r142=$hlavicka->m186r142; if ( $m186r142 == 0 ) $m186r142="";
$m186r143=$hlavicka->m186r143; if ( $m186r143 == 0 ) $m186r143="";
$m186r144=$hlavicka->m186r144; if ( $m186r144 == 0 ) $m186r144="";
$m186r145=$hlavicka->m186r145; if ( $m186r145 == 0 ) $m186r145="";
$m186r146=$hlavicka->m186r146; if ( $m186r146 == 0 ) $m186r146="";
$m186r147=$hlavicka->m186r147; if ( $m186r147 == 0 ) $m186r147="";
$m186r151=$hlavicka->m186r151; if ( $m186r151 == 0 ) $m186r151="";
$m186r152=$hlavicka->m186r152; if ( $m186r152 == 0 ) $m186r152="";
$m186r153=$hlavicka->m186r153; if ( $m186r153 == 0 ) $m186r153="";
$m186r154=$hlavicka->m186r154; if ( $m186r154 == 0 ) $m186r154="";
$m186r155=$hlavicka->m186r155; if ( $m186r155 == 0 ) $m186r155="";
$m186r156=$hlavicka->m186r156; if ( $m186r156 == 0 ) $m186r156="";
$m186r157=$hlavicka->m186r157; if ( $m186r157 == 0 ) $m186r157="";
$m186r161=$hlavicka->m186r161; if ( $m186r161 == 0 ) $m186r161="";
$m186r162=$hlavicka->m186r162; if ( $m186r162 == 0 ) $m186r162="";
$m186r163=$hlavicka->m186r163; if ( $m186r163 == 0 ) $m186r163="";
$m186r164=$hlavicka->m186r164; if ( $m186r164 == 0 ) $m186r164="";
$m186r165=$hlavicka->m186r165; if ( $m186r165 == 0 ) $m186r165="";
$m186r166=$hlavicka->m186r166; if ( $m186r166 == 0 ) $m186r166="";
$m186r167=$hlavicka->m186r167; if ( $m186r167 == 0 ) $m186r167="";
$m186r171=$hlavicka->m186r171; if ( $m186r171 == 0 ) $m186r171="";
$m186r172=$hlavicka->m186r172; if ( $m186r172 == 0 ) $m186r172="";
$m186r173=$hlavicka->m186r173; if ( $m186r173 == 0 ) $m186r173="";
$m186r174=$hlavicka->m186r174; if ( $m186r174 == 0 ) $m186r174="";
$m186r175=$hlavicka->m186r175; if ( $m186r175 == 0 ) $m186r175="";
$m186r176=$hlavicka->m186r176; if ( $m186r176 == 0 ) $m186r176="";
$m186r177=$hlavicka->m186r177; if ( $m186r177 == 0 ) $m186r177="";
$m186r181=$hlavicka->m186r181; if ( $m186r181 == 0 ) $m186r181="";
$m186r182=$hlavicka->m186r182; if ( $m186r182 == 0 ) $m186r182="";
$m186r183=$hlavicka->m186r183; if ( $m186r183 == 0 ) $m186r183="";
$m186r184=$hlavicka->m186r184; if ( $m186r184 == 0 ) $m186r184="";
$m186r185=$hlavicka->m186r185; if ( $m186r185 == 0 ) $m186r185="";
$m186r186=$hlavicka->m186r186; if ( $m186r186 == 0 ) $m186r186="";
$m186r187=$hlavicka->m186r187; if ( $m186r187 == 0 ) $m186r187="";
$m186r191=$hlavicka->m186r191; if ( $m186r191 == 0 ) $m186r191="";
$m186r192=$hlavicka->m186r192; if ( $m186r192 == 0 ) $m186r192="";
$m186r193=$hlavicka->m186r193; if ( $m186r193 == 0 ) $m186r193="";
$m186r194=$hlavicka->m186r194; if ( $m186r194 == 0 ) $m186r194="";
$m186r195=$hlavicka->m186r195; if ( $m186r195 == 0 ) $m186r195="";
$m186r196=$hlavicka->m186r196; if ( $m186r196 == 0 ) $m186r196="";
$m186r197=$hlavicka->m186r197; if ( $m186r197 == 0 ) $m186r197="";
$m186r201=$hlavicka->m186r201; if ( $m186r201 == 0 ) $m186r201="";
$m186r202=$hlavicka->m186r202; if ( $m186r202 == 0 ) $m186r202="";
$m186r203=$hlavicka->m186r203; if ( $m186r203 == 0 ) $m186r203="";
$m186r204=$hlavicka->m186r204; if ( $m186r204 == 0 ) $m186r204="";
$m186r205=$hlavicka->m186r205; if ( $m186r205 == 0 ) $m186r205="";
$m186r206=$hlavicka->m186r206; if ( $m186r206 == 0 ) $m186r206="";
$m186r207=$hlavicka->m186r207; if ( $m186r207 == 0 ) $m186r207="";
$m186r211=$hlavicka->m186r211; if ( $m186r211 == 0 ) $m186r211="";
$m186r212=$hlavicka->m186r212; if ( $m186r212 == 0 ) $m186r212="";
$m186r213=$hlavicka->m186r213; if ( $m186r213 == 0 ) $m186r213="";
$m186r214=$hlavicka->m186r214; if ( $m186r214 == 0 ) $m186r214="";
$m186r215=$hlavicka->m186r215; if ( $m186r215 == 0 ) $m186r215="";
$m186r216=$hlavicka->m186r216; if ( $m186r216 == 0 ) $m186r216="";
$m186r217=$hlavicka->m186r217; if ( $m186r217 == 0 ) $m186r217="";
$m186r221=$hlavicka->m186r221; if ( $m186r221 == 0 ) $m186r221="";
$m186r222=$hlavicka->m186r222; if ( $m186r222 == 0 ) $m186r222="";
$m186r223=$hlavicka->m186r223; if ( $m186r223 == 0 ) $m186r223="";
$m186r224=$hlavicka->m186r224; if ( $m186r224 == 0 ) $m186r224="";
$m186r225=$hlavicka->m186r225; if ( $m186r225 == 0 ) $m186r225="";
$m186r226=$hlavicka->m186r226; if ( $m186r226 == 0 ) $m186r226="";
$m186r227=$hlavicka->m186r227; if ( $m186r227 == 0 ) $m186r227="";
$m186r231=$hlavicka->m186r231; if ( $m186r231 == 0 ) $m186r231="";
$m186r232=$hlavicka->m186r232; if ( $m186r232 == 0 ) $m186r232="";
$m186r233=$hlavicka->m186r233; if ( $m186r233 == 0 ) $m186r233="";
$m186r234=$hlavicka->m186r234; if ( $m186r234 == 0 ) $m186r234="";
$m186r235=$hlavicka->m186r235; if ( $m186r235 == 0 ) $m186r235="";
$m186r236=$hlavicka->m186r236; if ( $m186r236 == 0 ) $m186r236="";
$m186r237=$hlavicka->m186r237; if ( $m186r237 == 0 ) $m186r237="";
$m186r241=$hlavicka->m186r241; if ( $m186r241 == 0 ) $m186r241="";
$m186r242=$hlavicka->m186r242; if ( $m186r242 == 0 ) $m186r242="";
$m186r243=$hlavicka->m186r243; if ( $m186r243 == 0 ) $m186r243="";
$m186r244=$hlavicka->m186r244; if ( $m186r244 == 0 ) $m186r244="";
$m186r245=$hlavicka->m186r245; if ( $m186r245 == 0 ) $m186r245="";
$m186r246=$hlavicka->m186r246; if ( $m186r246 == 0 ) $m186r246="";
$m186r247=$hlavicka->m186r247; if ( $m186r247 == 0 ) $m186r247="";
$m186r251=$hlavicka->m186r251; if ( $m186r251 == 0 ) $m186r251="";
$m186r252=$hlavicka->m186r252; if ( $m186r252 == 0 ) $m186r252="";
$m186r253=$hlavicka->m186r253; if ( $m186r253 == 0 ) $m186r253="";
$m186r254=$hlavicka->m186r254; if ( $m186r254 == 0 ) $m186r254="";
$m186r255=$hlavicka->m186r255; if ( $m186r255 == 0 ) $m186r255="";
$m186r256=$hlavicka->m186r256; if ( $m186r256 == 0 ) $m186r256="";
$m186r257=$hlavicka->m186r257; if ( $m186r257 == 0 ) $m186r257="";
$m186r261=$hlavicka->m186r261; if ( $m186r261 == 0 ) $m186r261="";
$m186r262=$hlavicka->m186r262; if ( $m186r262 == 0 ) $m186r262="";
$m186r263=$hlavicka->m186r263; if ( $m186r263 == 0 ) $m186r263="";
$m186r264=$hlavicka->m186r264; if ( $m186r264 == 0 ) $m186r264="";
$m186r265=$hlavicka->m186r265; if ( $m186r265 == 0 ) $m186r265="";
$m186r266=$hlavicka->m186r266; if ( $m186r266 == 0 ) $m186r266="";
$m186r267=$hlavicka->m186r267; if ( $m186r267 == 0 ) $m186r267="";
$m186r271=$hlavicka->m186r271; if ( $m186r271 == 0 ) $m186r271="";
$m186r272=$hlavicka->m186r272; if ( $m186r272 == 0 ) $m186r272="";
$m186r273=$hlavicka->m186r273; if ( $m186r273 == 0 ) $m186r273="";
$m186r274=$hlavicka->m186r274; if ( $m186r274 == 0 ) $m186r274="";
$m186r275=$hlavicka->m186r275; if ( $m186r275 == 0 ) $m186r275="";
$m186r276=$hlavicka->m186r276; if ( $m186r276 == 0 ) $m186r276="";
$m186r277=$hlavicka->m186r277; if ( $m186r277 == 0 ) $m186r277="";
$m186r281=$hlavicka->m186r281; if ( $m186r281 == 0 ) $m186r281="";
$m186r282=$hlavicka->m186r282; if ( $m186r282 == 0 ) $m186r282="";
$m186r283=$hlavicka->m186r283; if ( $m186r283 == 0 ) $m186r283="";
$m186r284=$hlavicka->m186r284; if ( $m186r284 == 0 ) $m186r284="";
$m186r285=$hlavicka->m186r285; if ( $m186r285 == 0 ) $m186r285="";
$m186r286=$hlavicka->m186r286; if ( $m186r286 == 0 ) $m186r286="";
$m186r287=$hlavicka->m186r287; if ( $m186r287 == 0 ) $m186r287="";
$m186r291=$hlavicka->m186r291; if ( $m186r291 == 0 ) $m186r291="";
$m186r292=$hlavicka->m186r292; if ( $m186r292 == 0 ) $m186r292="";
$m186r293=$hlavicka->m186r293; if ( $m186r293 == 0 ) $m186r293="";
$m186r294=$hlavicka->m186r294; if ( $m186r294 == 0 ) $m186r294="";
$m186r295=$hlavicka->m186r295; if ( $m186r295 == 0 ) $m186r295="";
$m186r296=$hlavicka->m186r296; if ( $m186r296 == 0 ) $m186r296="";
$m186r297=$hlavicka->m186r297; if ( $m186r297 == 0 ) $m186r297="";
$m186r301=$hlavicka->m186r301; if ( $m186r301 == 0 ) $m186r301="";
$m186r302=$hlavicka->m186r302; if ( $m186r302 == 0 ) $m186r302="";
$m186r303=$hlavicka->m186r303; if ( $m186r303 == 0 ) $m186r303="";
$m186r304=$hlavicka->m186r304; if ( $m186r304 == 0 ) $m186r304="";
$m186r305=$hlavicka->m186r305; if ( $m186r305 == 0 ) $m186r305="";
$m186r306=$hlavicka->m186r306; if ( $m186r306 == 0 ) $m186r306="";
$m186r307=$hlavicka->m186r307; if ( $m186r307 == 0 ) $m186r307="";
$m186r992=$hlavicka->m186r992;
//if ( $m186r992 == 0 ) $m186r992="";
$m186r993=$hlavicka->m186r993;
//if ( $m186r993 == 0 ) $m186r993="";
$m186r994=$hlavicka->m186r994;
//if ( $m186r994 == 0 ) $m186r994="";
$m186r995=$hlavicka->m186r995;
//if ( $m186r995 == 0 ) $m186r995="";
$m186r996=$hlavicka->m186r996;
//if ( $m186r996 == 0 ) $m186r996="";
$m186r997=$hlavicka->m186r997;
//if ( $m186r997 == 0 ) $m186r997="";
$pdf->Cell(195,36," ","$rmc1",1,"L");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m186r11","$rmc",0,"R");$pdf->Cell(27,6,"$m186r12","$rmc",0,"R");
$pdf->Cell(25,6,"$m186r13","$rmc",0,"R");$pdf->Cell(28,6,"$m186r14","$rmc",0,"R");
$pdf->Cell(27,6,"$m186r15","$rmc",0,"R");$pdf->Cell(23,6,"$m186r16","$rmc",0,"R");
$pdf->Cell(22,6,"$m186r17","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m186r21","$rmc",0,"R");$pdf->Cell(27,7,"$m186r22","$rmc",0,"R");
$pdf->Cell(25,7,"$m186r23","$rmc",0,"R");$pdf->Cell(28,7,"$m186r24","$rmc",0,"R");
$pdf->Cell(27,7,"$m186r25","$rmc",0,"R");$pdf->Cell(23,7,"$m186r26","$rmc",0,"R");
$pdf->Cell(22,7,"$m186r27","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m186r31","$rmc",0,"R");$pdf->Cell(27,6,"$m186r32","$rmc",0,"R");
$pdf->Cell(25,6,"$m186r33","$rmc",0,"R");$pdf->Cell(28,6,"$m186r34","$rmc",0,"R");
$pdf->Cell(27,6,"$m186r35","$rmc",0,"R");$pdf->Cell(23,6,"$m186r36","$rmc",0,"R");
$pdf->Cell(22,6,"$m186r37","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m186r41","$rmc",0,"R");$pdf->Cell(27,7,"$m186r42","$rmc",0,"R");
$pdf->Cell(25,7,"$m186r43","$rmc",0,"R");$pdf->Cell(28,7,"$m186r44","$rmc",0,"R");
$pdf->Cell(27,7,"$m186r45","$rmc",0,"R");$pdf->Cell(23,7,"$m186r46","$rmc",0,"R");
$pdf->Cell(22,7,"$m186r47","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m186r51","$rmc",0,"R");$pdf->Cell(27,6,"$m186r52","$rmc",0,"R");
$pdf->Cell(25,6,"$m186r53","$rmc",0,"R");$pdf->Cell(28,6,"$m186r54","$rmc",0,"R");
$pdf->Cell(27,6,"$m186r55","$rmc",0,"R");$pdf->Cell(23,6,"$m186r56","$rmc",0,"R");
$pdf->Cell(22,6,"$m186r57","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m186r61","$rmc",0,"R");$pdf->Cell(27,7,"$m186r62","$rmc",0,"R");
$pdf->Cell(25,7,"$m186r63","$rmc",0,"R");$pdf->Cell(28,7,"$m186r64","$rmc",0,"R");
$pdf->Cell(27,7,"$m186r65","$rmc",0,"R");$pdf->Cell(23,7,"$m186r66","$rmc",0,"R");
$pdf->Cell(22,7,"$m186r67","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m186r71","$rmc",0,"R");$pdf->Cell(27,6,"$m186r72","$rmc",0,"R");
$pdf->Cell(25,6,"$m186r73","$rmc",0,"R");$pdf->Cell(28,6,"$m186r74","$rmc",0,"R");
$pdf->Cell(27,6,"$m186r75","$rmc",0,"R");$pdf->Cell(23,6,"$m186r76","$rmc",0,"R");
$pdf->Cell(22,6,"$m186r77","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m186r81","$rmc",0,"R");$pdf->Cell(27,7,"$m186r82","$rmc",0,"R");
$pdf->Cell(25,7,"$m186r83","$rmc",0,"R");$pdf->Cell(28,7,"$m186r84","$rmc",0,"R");
$pdf->Cell(27,7,"$m186r85","$rmc",0,"R");$pdf->Cell(23,7,"$m186r86","$rmc",0,"R");
$pdf->Cell(22,7,"$m186r87","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m186r91","$rmc",0,"R");$pdf->Cell(27,6,"$m186r92","$rmc",0,"R");
$pdf->Cell(25,6,"$m186r93","$rmc",0,"R");$pdf->Cell(28,6,"$m186r94","$rmc",0,"R");
$pdf->Cell(27,6,"$m186r95","$rmc",0,"R");$pdf->Cell(23,6,"$m186r96","$rmc",0,"R");
$pdf->Cell(22,6,"$m186r97","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m186r101","$rmc",0,"R");$pdf->Cell(27,7,"$m186r102","$rmc",0,"R");
$pdf->Cell(25,7,"$m186r103","$rmc",0,"R");$pdf->Cell(28,7,"$m186r104","$rmc",0,"R");
$pdf->Cell(27,7,"$m186r105","$rmc",0,"R");$pdf->Cell(23,7,"$m186r106","$rmc",0,"R");
$pdf->Cell(22,7,"$m186r107","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m186r111","$rmc",0,"R");$pdf->Cell(27,6,"$m186r112","$rmc",0,"R");
$pdf->Cell(25,6,"$m186r113","$rmc",0,"R");$pdf->Cell(28,6,"$m186r114","$rmc",0,"R");
$pdf->Cell(27,6,"$m186r115","$rmc",0,"R");$pdf->Cell(23,6,"$m186r116","$rmc",0,"R");
$pdf->Cell(22,6,"$m186r117","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m186r121","$rmc",0,"R");$pdf->Cell(27,7,"$m186r122","$rmc",0,"R");
$pdf->Cell(25,7,"$m186r123","$rmc",0,"R");$pdf->Cell(28,7,"$m186r124","$rmc",0,"R");
$pdf->Cell(27,7,"$m186r125","$rmc",0,"R");$pdf->Cell(23,7,"$m186r126","$rmc",0,"R");
$pdf->Cell(22,7,"$m186r127","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m186r131","$rmc",0,"R");$pdf->Cell(27,6,"$m186r132","$rmc",0,"R");
$pdf->Cell(25,6,"$m186r133","$rmc",0,"R");$pdf->Cell(28,6,"$m186r134","$rmc",0,"R");
$pdf->Cell(27,6,"$m186r135","$rmc",0,"R");$pdf->Cell(23,6,"$m186r136","$rmc",0,"R");
$pdf->Cell(22,6,"$m186r137","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m186r141","$rmc",0,"R");$pdf->Cell(27,7,"$m186r142","$rmc",0,"R");
$pdf->Cell(25,7,"$m186r143","$rmc",0,"R");$pdf->Cell(28,7,"$m186r144","$rmc",0,"R");
$pdf->Cell(27,7,"$m186r145","$rmc",0,"R");$pdf->Cell(23,7,"$m186r146","$rmc",0,"R");
$pdf->Cell(22,7,"$m186r147","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m186r151","$rmc",0,"R");$pdf->Cell(27,6,"$m186r152","$rmc",0,"R");
$pdf->Cell(25,6,"$m186r153","$rmc",0,"R");$pdf->Cell(28,6,"$m186r154","$rmc",0,"R");
$pdf->Cell(27,6,"$m186r155","$rmc",0,"R");$pdf->Cell(23,6,"$m186r156","$rmc",0,"R");
$pdf->Cell(22,6,"$m186r157","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m186r161","$rmc",0,"R");$pdf->Cell(27,7,"$m186r162","$rmc",0,"R");
$pdf->Cell(25,7,"$m186r163","$rmc",0,"R");$pdf->Cell(28,7,"$m186r164","$rmc",0,"R");
$pdf->Cell(27,7,"$m186r165","$rmc",0,"R");$pdf->Cell(23,7,"$m186r166","$rmc",0,"R");
$pdf->Cell(22,7,"$m186r167","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m186r171","$rmc",0,"R");$pdf->Cell(27,6,"$m186r172","$rmc",0,"R");
$pdf->Cell(25,6,"$m186r173","$rmc",0,"R");$pdf->Cell(28,6,"$m186r174","$rmc",0,"R");
$pdf->Cell(27,6,"$m186r175","$rmc",0,"R");$pdf->Cell(23,6,"$m186r176","$rmc",0,"R");
$pdf->Cell(22,6,"$m186r177","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m186r181","$rmc",0,"R");$pdf->Cell(27,7,"$m186r182","$rmc",0,"R");
$pdf->Cell(25,7,"$m186r183","$rmc",0,"R");$pdf->Cell(28,7,"$m186r184","$rmc",0,"R");
$pdf->Cell(27,7,"$m186r185","$rmc",0,"R");$pdf->Cell(23,7,"$m186r186","$rmc",0,"R");
$pdf->Cell(22,7,"$m186r187","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m186r191","$rmc",0,"R");$pdf->Cell(27,6,"$m186r192","$rmc",0,"R");
$pdf->Cell(25,6,"$m186r193","$rmc",0,"R");$pdf->Cell(28,6,"$m186r194","$rmc",0,"R");
$pdf->Cell(27,6,"$m186r195","$rmc",0,"R");$pdf->Cell(23,6,"$m186r196","$rmc",0,"R");
$pdf->Cell(22,6,"$m186r197","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m186r201","$rmc",0,"R");$pdf->Cell(27,7,"$m186r202","$rmc",0,"R");
$pdf->Cell(25,7,"$m186r203","$rmc",0,"R");$pdf->Cell(28,7,"$m186r204","$rmc",0,"R");
$pdf->Cell(27,7,"$m186r205","$rmc",0,"R");$pdf->Cell(23,7,"$m186r206","$rmc",0,"R");
$pdf->Cell(22,7,"$m186r207","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m186r211","$rmc",0,"R");$pdf->Cell(27,6,"$m186r212","$rmc",0,"R");
$pdf->Cell(25,6,"$m186r213","$rmc",0,"R");$pdf->Cell(28,6,"$m186r214","$rmc",0,"R");
$pdf->Cell(27,6,"$m186r215","$rmc",0,"R");$pdf->Cell(23,6,"$m186r216","$rmc",0,"R");
$pdf->Cell(22,6,"$m186r217","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m186r221","$rmc",0,"R");$pdf->Cell(27,7,"$m186r222","$rmc",0,"R");
$pdf->Cell(25,7,"$m186r223","$rmc",0,"R");$pdf->Cell(28,7,"$m186r224","$rmc",0,"R");
$pdf->Cell(27,7,"$m186r225","$rmc",0,"R");$pdf->Cell(23,7,"$m186r226","$rmc",0,"R");
$pdf->Cell(22,7,"$m186r227","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m186r231","$rmc",0,"R");$pdf->Cell(27,6,"$m186r232","$rmc",0,"R");
$pdf->Cell(25,6,"$m186r233","$rmc",0,"R");$pdf->Cell(28,6,"$m186r234","$rmc",0,"R");
$pdf->Cell(27,6,"$m186r235","$rmc",0,"R");$pdf->Cell(23,6,"$m186r236","$rmc",0,"R");
$pdf->Cell(22,6,"$m186r237","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m186r241","$rmc",0,"R");$pdf->Cell(27,7,"$m186r242","$rmc",0,"R");
$pdf->Cell(25,7,"$m186r243","$rmc",0,"R");$pdf->Cell(28,7,"$m186r244","$rmc",0,"R");
$pdf->Cell(27,7,"$m186r245","$rmc",0,"R");$pdf->Cell(23,7,"$m186r246","$rmc",0,"R");
$pdf->Cell(22,7,"$m186r247","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m186r251","$rmc",0,"R");$pdf->Cell(27,6,"$m186r252","$rmc",0,"R");
$pdf->Cell(25,6,"$m186r253","$rmc",0,"R");$pdf->Cell(28,6,"$m186r254","$rmc",0,"R");
$pdf->Cell(27,6,"$m186r255","$rmc",0,"R");$pdf->Cell(23,6,"$m186r256","$rmc",0,"R");
$pdf->Cell(22,6,"$m186r257","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m186r261","$rmc",0,"R");$pdf->Cell(27,7,"$m186r262","$rmc",0,"R");
$pdf->Cell(25,7,"$m186r263","$rmc",0,"R");$pdf->Cell(28,7,"$m186r264","$rmc",0,"R");
$pdf->Cell(27,7,"$m186r265","$rmc",0,"R");$pdf->Cell(23,7,"$m186r266","$rmc",0,"R");
$pdf->Cell(22,7,"$m186r267","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m186r271","$rmc",0,"R");$pdf->Cell(27,6,"$m186r272","$rmc",0,"R");
$pdf->Cell(25,6,"$m186r273","$rmc",0,"R");$pdf->Cell(28,6,"$m186r274","$rmc",0,"R");
$pdf->Cell(27,6,"$m186r275","$rmc",0,"R");$pdf->Cell(23,6,"$m186r276","$rmc",0,"R");
$pdf->Cell(22,6,"$m186r277","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m186r281","$rmc",0,"R");$pdf->Cell(27,7,"$m186r282","$rmc",0,"R");
$pdf->Cell(25,7,"$m186r283","$rmc",0,"R");$pdf->Cell(28,7,"$m186r284","$rmc",0,"R");
$pdf->Cell(27,7,"$m186r285","$rmc",0,"R");$pdf->Cell(23,7,"$m186r286","$rmc",0,"R");
$pdf->Cell(22,7,"$m186r287","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"$m186r291","$rmc",0,"R");$pdf->Cell(27,7,"$m186r292","$rmc",0,"R");
$pdf->Cell(25,7,"$m186r293","$rmc",0,"R");$pdf->Cell(28,7,"$m186r294","$rmc",0,"R");
$pdf->Cell(27,7,"$m186r295","$rmc",0,"R");$pdf->Cell(23,7,"$m186r296","$rmc",0,"R");
$pdf->Cell(22,7,"$m186r297","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,6,"$m186r301","$rmc",0,"R");$pdf->Cell(27,6,"$m186r302","$rmc",0,"R");
$pdf->Cell(25,6,"$m186r303","$rmc",0,"R");$pdf->Cell(28,6,"$m186r304","$rmc",0,"R");
$pdf->Cell(27,6,"$m186r305","$rmc",0,"R");$pdf->Cell(23,6,"$m186r306","$rmc",0,"R");
$pdf->Cell(22,6,"$m186r307","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(27,7,"","$rmc",0,"R");$pdf->Cell(27,7,"$m186r992","$rmc",0,"R");
$pdf->Cell(25,7,"$m186r993","$rmc",0,"R");$pdf->Cell(28,7,"$m186r994","$rmc",0,"R");
$pdf->Cell(27,7,"$m186r995","$rmc",0,"R");$pdf->Cell(23,7,"$m186r996","$rmc",0,"R");
$pdf->Cell(22,7,"$m186r997","$rmc",1,"R");
                                       }

if ( $strana == 10 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str10.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str10.jpg',0,0,210,297);
}
$pdf->SetY(10);

//modul 187
$m187r1=$hlavicka->m187r1; if ( $m187r1 == 0 ) $m187r1="";
$pdf->Cell(195,22," ","$rmc1",1,"L");
$pdf->Cell(113,5," ","$rmc1",0,"R");$pdf->Cell(72,7,"$m187r1","$rmc",1,"R");

//modul 100101
$m1590r1a=" ";
$m1590r1b=" ";
if ( $hlavicka->m1590r1a == 1 ) { $m1590r1a="x"; }
if ( $hlavicka->m1590r1b == 1 ) { $m1590r1b="x"; }
$pdf->Cell(190,22," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$m1590r1a","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$m1590r1b","$rmc",1,"C");

//modul 100102
$m1590r2a=" ";
$m1590r2b=" ";
if ( $hlavicka->m1590r2a == 1 ) { $m1590r2a="x"; }
if ( $hlavicka->m1590r2b == 1 ) { $m1590r2b="x"; }
$pdf->Cell(190,24," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$m1590r2a","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$m1590r2b","$rmc",1,"C");

//modul 590
$m590r11=$hlavicka->m590r11; if ( $m590r11 == 0 ) $m590r11="";
$m590r12=$hlavicka->m590r12; if ( $m590r12 == 0 ) $m590r12="";
$m590r13=$hlavicka->m590r13; if ( $m590r13 == 0 ) $m590r13="";
$m590r14=$hlavicka->m590r14; if ( $m590r14 == 0 ) $m590r14="";
$m590r15=$hlavicka->m590r15; if ( $m590r15 == 0 ) $m590r15="";
$m590r21=$hlavicka->m590r21; if ( $m590r21 == 0 ) $m590r21="";
$m590r22=$hlavicka->m590r22; if ( $m590r22 == 0 ) $m590r22="";
$m590r23=$hlavicka->m590r23; if ( $m590r23 == 0 ) $m590r23="";
$m590r24=$hlavicka->m590r24; if ( $m590r24 == 0 ) $m590r24="";
$m590r25=$hlavicka->m590r25; if ( $m590r25 == 0 ) $m590r25="";
$m590r31=$hlavicka->m590r31; if ( $m590r31 == 0 ) $m590r31="";
$m590r32=$hlavicka->m590r32; if ( $m590r32 == 0 ) $m590r32="";
$m590r33=$hlavicka->m590r33; if ( $m590r33 == 0 ) $m590r33="";
$m590r34=$hlavicka->m590r34; if ( $m590r34 == 0 ) $m590r34="";
$m590r35=$hlavicka->m590r35; if ( $m590r35 == 0 ) $m590r35="";
$m590r41=$hlavicka->m590r41; if ( $m590r41 == 0 ) $m590r41="";
$m590r42=$hlavicka->m590r42; if ( $m590r42 == 0 ) $m590r42="";
$m590r43=$hlavicka->m590r43; if ( $m590r43 == 0 ) $m590r43="";
$m590r44=$hlavicka->m590r44; if ( $m590r44 == 0 ) $m590r44="";
$m590r45=$hlavicka->m590r45; if ( $m590r45 == 0 ) $m590r45="";
$m590r51=$hlavicka->m590r51; if ( $m590r51 == 0 ) $m590r51="";
$m590r52=$hlavicka->m590r52; if ( $m590r52 == 0 ) $m590r52="";
$m590r53=$hlavicka->m590r53; if ( $m590r53 == 0 ) $m590r53="";
$m590r54=$hlavicka->m590r54; if ( $m590r54 == 0 ) $m590r54="";
$m590r55=$hlavicka->m590r55; if ( $m590r55 == 0 ) $m590r55="";
$m590r61=$hlavicka->m590r61; if ( $m590r61 == 0 ) $m590r61="";
$m590r62=$hlavicka->m590r62; if ( $m590r62 == 0 ) $m590r62="";
$m590r63=$hlavicka->m590r63; if ( $m590r63 == 0 ) $m590r63="";
$m590r64=$hlavicka->m590r64; if ( $m590r64 == 0 ) $m590r64="";
$m590r65=$hlavicka->m590r65; if ( $m590r65 == 0 ) $m590r65="";
$m590r71=$hlavicka->m590r71; if ( $m590r71 == 0 ) $m590r71="";
$m590r72=$hlavicka->m590r72; if ( $m590r72 == 0 ) $m590r72="";
$m590r73=$hlavicka->m590r73; if ( $m590r73 == 0 ) $m590r73="";
$m590r74=$hlavicka->m590r74; if ( $m590r74 == 0 ) $m590r74="";
$m590r75=$hlavicka->m590r75; if ( $m590r75 == 0 ) $m590r75="";
$m590r81=$hlavicka->m590r81; if ( $m590r81 == 0 ) $m590r81="";
$m590r82=$hlavicka->m590r82; if ( $m590r82 == 0 ) $m590r82="";
$m590r83=$hlavicka->m590r83; if ( $m590r83 == 0 ) $m590r83="";
$m590r84=$hlavicka->m590r84; if ( $m590r84 == 0 ) $m590r84="";
$m590r85=$hlavicka->m590r85; if ( $m590r85 == 0 ) $m590r85="";
$m590r91=$hlavicka->m590r91; if ( $m590r91 == 0 ) $m590r91="";
$m590r92=$hlavicka->m590r92; if ( $m590r92 == 0 ) $m590r92="";
$m590r93=$hlavicka->m590r93; if ( $m590r93 == 0 ) $m590r93="";
$m590r94=$hlavicka->m590r94; if ( $m590r94 == 0 ) $m590r94="";
$m590r95=$hlavicka->m590r95; if ( $m590r95 == 0 ) $m590r95="";
$m590r101=$hlavicka->m590r101; if ( $m590r101 == 0 ) $m590r101="";
$m590r102=$hlavicka->m590r102; if ( $m590r102 == 0 ) $m590r102="";
$m590r103=$hlavicka->m590r103; if ( $m590r103 == 0 ) $m590r103="";
$m590r104=$hlavicka->m590r104; if ( $m590r104 == 0 ) $m590r104="";
$m590r105=$hlavicka->m590r105; if ( $m590r105 == 0 ) $m590r105="";
$m590r111=$hlavicka->m590r111; if ( $m590r111 == 0 ) $m590r111="";
$m590r112=$hlavicka->m590r112; if ( $m590r112 == 0 ) $m590r112="";
$m590r113=$hlavicka->m590r113; if ( $m590r113 == 0 ) $m590r113="";
$m590r114=$hlavicka->m590r114; if ( $m590r114 == 0 ) $m590r114="";
$m590r115=$hlavicka->m590r115; if ( $m590r115 == 0 ) $m590r115="";
$m590r121=$hlavicka->m590r121; if ( $m590r121 == 0 ) $m590r121="";
$m590r122=$hlavicka->m590r122; if ( $m590r122 == 0 ) $m590r122="";
$m590r123=$hlavicka->m590r123; if ( $m590r123 == 0 ) $m590r123="";
$m590r124=$hlavicka->m590r124; if ( $m590r124 == 0 ) $m590r124="";
$m590r125=$hlavicka->m590r125; if ( $m590r125 == 0 ) $m590r125="";
$m590r131=$hlavicka->m590r131; if ( $m590r131 == 0 ) $m590r131="";
$m590r132=$hlavicka->m590r132; if ( $m590r132 == 0 ) $m590r132="";
$m590r133=$hlavicka->m590r133; if ( $m590r133 == 0 ) $m590r133="";
$m590r134=$hlavicka->m590r134; if ( $m590r134 == 0 ) $m590r134="";
$m590r135=$hlavicka->m590r135; if ( $m590r135 == 0 ) $m590r135="";
$m590r141=$hlavicka->m590r141; if ( $m590r141 == 0 ) $m590r141="";
$m590r142=$hlavicka->m590r142; if ( $m590r142 == 0 ) $m590r142="";
$m590r143=$hlavicka->m590r143; if ( $m590r143 == 0 ) $m590r143="";
$m590r144=$hlavicka->m590r144; if ( $m590r144 == 0 ) $m590r144="";
$m590r145=$hlavicka->m590r145; if ( $m590r145 == 0 ) $m590r145="";
$m590r151=$hlavicka->m590r151; if ( $m590r151 == 0 ) $m590r151="";
$m590r152=$hlavicka->m590r152; if ( $m590r152 == 0 ) $m590r152="";
$m590r153=$hlavicka->m590r153; if ( $m590r153 == 0 ) $m590r153="";
$m590r154=$hlavicka->m590r154; if ( $m590r154 == 0 ) $m590r154="";
$m590r155=$hlavicka->m590r155; if ( $m590r155 == 0 ) $m590r155="";
$m590r161=$hlavicka->m590r161; if ( $m590r161 == 0 ) $m590r161="";
$m590r162=$hlavicka->m590r162; if ( $m590r162 == 0 ) $m590r162="";
$m590r163=$hlavicka->m590r163; if ( $m590r163 == 0 ) $m590r163="";
$m590r164=$hlavicka->m590r164; if ( $m590r164 == 0 ) $m590r164="";
$m590r165=$hlavicka->m590r165; if ( $m590r165 == 0 ) $m590r165="";
$m590r171=$hlavicka->m590r171; if ( $m590r171 == 0 ) $m590r171="";
$m590r172=$hlavicka->m590r172; if ( $m590r172 == 0 ) $m590r172="";
$m590r173=$hlavicka->m590r173; if ( $m590r173 == 0 ) $m590r173="";
$m590r174=$hlavicka->m590r174; if ( $m590r174 == 0 ) $m590r174="";
$m590r175=$hlavicka->m590r175; if ( $m590r175 == 0 ) $m590r175="";
$m590r181=$hlavicka->m590r181; if ( $m590r181 == 0 ) $m590r181="";
$m590r182=$hlavicka->m590r182; if ( $m590r182 == 0 ) $m590r182="";
$m590r183=$hlavicka->m590r183; if ( $m590r183 == 0 ) $m590r183="";
$m590r184=$hlavicka->m590r184; if ( $m590r184 == 0 ) $m590r184="";
$m590r185=$hlavicka->m590r185; if ( $m590r185 == 0 ) $m590r185="";
$m590r191=$hlavicka->m590r191; if ( $m590r191 == 0 ) $m590r191="";
$m590r192=$hlavicka->m590r192; if ( $m590r192 == 0 ) $m590r192="";
$m590r193=$hlavicka->m590r193; if ( $m590r193 == 0 ) $m590r193="";
$m590r194=$hlavicka->m590r194; if ( $m590r194 == 0 ) $m590r194="";
$m590r195=$hlavicka->m590r195; if ( $m590r195 == 0 ) $m590r195="";
$m590r201=$hlavicka->m590r201; if ( $m590r201 == 0 ) $m590r201="";
$m590r202=$hlavicka->m590r202; if ( $m590r202 == 0 ) $m590r202="";
$m590r203=$hlavicka->m590r203; if ( $m590r203 == 0 ) $m590r203="";
$m590r204=$hlavicka->m590r204; if ( $m590r204 == 0 ) $m590r204="";
$m590r205=$hlavicka->m590r205; if ( $m590r205 == 0 ) $m590r205="";
$m590r992=$hlavicka->m590r992;
//if ( $m590r992 == 0 ) $m590r992="";
$m590r993=$hlavicka->m590r993;
//if ( $m590r993 == 0 ) $m590r993="";
$m590r994=$hlavicka->m590r994;
//if ( $m590r994 == 0 ) $m590r994="";
$m590r995=$hlavicka->m590r995;
//if ( $m590r995 == 0 ) $m590r995="";
$pdf->Cell(195,45," ","$rmc1",1,"L");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r11","$rmc",0,"R");$pdf->Cell(37,6,"$m590r12","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r13","$rmc",0,"R");$pdf->Cell(35,6,"$m590r14","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r15","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r21","$rmc",0,"R");$pdf->Cell(37,6,"$m590r22","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r23","$rmc",0,"R");$pdf->Cell(35,6,"$m590r24","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r25","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r31","$rmc",0,"R");$pdf->Cell(37,6,"$m590r32","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r33","$rmc",0,"R");$pdf->Cell(35,6,"$m590r34","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r35","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r41","$rmc",0,"R");$pdf->Cell(37,6,"$m590r42","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r43","$rmc",0,"R");$pdf->Cell(35,6,"$m590r44","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r45","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r51","$rmc",0,"R");$pdf->Cell(37,6,"$m590r52","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r53","$rmc",0,"R");$pdf->Cell(35,6,"$m590r54","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r55","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r61","$rmc",0,"R");$pdf->Cell(37,6,"$m590r62","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r63","$rmc",0,"R");$pdf->Cell(35,6,"$m590r64","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r65","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r71","$rmc",0,"R");$pdf->Cell(37,6,"$m590r72","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r73","$rmc",0,"R");$pdf->Cell(35,6,"$m590r74","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r75","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r81","$rmc",0,"R");$pdf->Cell(37,6,"$m590r82","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r83","$rmc",0,"R");$pdf->Cell(35,6,"$m590r84","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r85","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r91","$rmc",0,"R");$pdf->Cell(37,6,"$m590r92","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r93","$rmc",0,"R");$pdf->Cell(35,6,"$m590r94","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r95","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r101","$rmc",0,"R");$pdf->Cell(37,6,"$m590r102","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r103","$rmc",0,"R");$pdf->Cell(35,6,"$m590r104","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r105","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r111","$rmc",0,"R");$pdf->Cell(37,6,"$m590r112","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r113","$rmc",0,"R");$pdf->Cell(35,6,"$m590r114","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r115","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r121","$rmc",0,"R");$pdf->Cell(37,6,"$m590r122","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r123","$rmc",0,"R");$pdf->Cell(35,6,"$m590r124","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r125","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r131","$rmc",0,"R");$pdf->Cell(37,6,"$m590r132","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r133","$rmc",0,"R");$pdf->Cell(35,6,"$m590r134","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r135","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r141","$rmc",0,"R");$pdf->Cell(37,6,"$m590r142","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r143","$rmc",0,"R");$pdf->Cell(35,6,"$m590r144","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r145","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r151","$rmc",0,"R");$pdf->Cell(37,6,"$m590r152","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r153","$rmc",0,"R");$pdf->Cell(35,6,"$m590r154","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r155","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r161","$rmc",0,"R");$pdf->Cell(37,6,"$m590r162","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r163","$rmc",0,"R");$pdf->Cell(35,6,"$m590r164","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r165","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r171","$rmc",0,"R");$pdf->Cell(37,6,"$m590r172","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r173","$rmc",0,"R");$pdf->Cell(35,6,"$m590r174","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r175","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r181","$rmc",0,"R");$pdf->Cell(37,6,"$m590r182","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r183","$rmc",0,"R");$pdf->Cell(35,6,"$m590r184","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r185","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r191","$rmc",0,"R");$pdf->Cell(37,6,"$m590r192","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r193","$rmc",0,"R");$pdf->Cell(35,6,"$m590r194","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r195","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"$m590r201","$rmc",0,"R");$pdf->Cell(37,6,"$m590r202","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r203","$rmc",0,"R");$pdf->Cell(35,6,"$m590r204","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r205","$rmc",1,"R");
$pdf->Cell(9,4," ","$rmc1",0,"L");
$pdf->Cell(37,6,"","$rmc",0,"R");$pdf->Cell(37,6,"$m590r992","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r993","$rmc",0,"R");$pdf->Cell(35,6,"$m590r994","$rmc",0,"R");
$pdf->Cell(35,6,"$m590r995","$rmc",1,"R");
                                        }

if ( $strana == 11 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str11.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str11.jpg',0,0,210,297);
}
$pdf->SetY(10);

//modul 304
$m304r1=$hlavicka->m304r1; if ( $m304r1 == 0 ) $m304r1="";
$m304r2=$hlavicka->m304r2; if ( $m304r2 == 0 ) $m304r2="";
$m304r3=$hlavicka->m304r3; if ( $m304r3 == 0 ) $m304r3="";
$m304r4=$hlavicka->m304r4; if ( $m304r4 == 0 ) $m304r4="";
$m304r5=$hlavicka->m304r5; if ( $m304r5 == 0 ) $m304r5="";
$m304r6=$hlavicka->m304r6; if ( $m304r6 == 0 ) $m304r6="";
$m304r7=$hlavicka->m304r7; if ( $m304r7 == 0 ) $m304r7="";
$m304r8=$hlavicka->m304r8; if ( $m304r8 == 0 ) $m304r8="";
$m304r9=$hlavicka->m304r9; if ( $m304r9 == 0 ) $m304r9="";
$m304r10=$hlavicka->m304r10; if ( $m304r10 == 0 ) $m304r10="";
$m304r11=$hlavicka->m304r11; if ( $m304r11 == 0 ) $m304r11="";
$m304r12=$hlavicka->m304r12; if ( $m304r12 == 0 ) $m304r12="";
$m304r13=$hlavicka->m304r13; if ( $m304r13 == 0 ) $m304r13="";
$m304r14=$hlavicka->m304r14; if ( $m304r14 == 0 ) $m304r14="";
$m304r15=$hlavicka->m304r15; if ( $m304r15 == 0 ) $m304r15="";
$m304r16=$hlavicka->m304r16; if ( $m304r16 == 0 ) $m304r16="";
$m304r99=$hlavicka->m304r99;
//if ( $m304r99 == 0 ) $m304r99="";
$pdf->Cell(195,31," ","$rmc1",1,"L");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,6,"$m304r1","$rmc",1,"R");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,7,"$m304r2","$rmc",1,"R");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,7,"$m304r3","$rmc",1,"R");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,7,"$m304r4","$rmc",1,"R");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,7,"$m304r5","$rmc",1,"R");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,7,"$m304r6","$rmc",1,"R");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,7,"$m304r7","$rmc",1,"R");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,11,"$m304r8","$rmc",1,"R");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,7,"$m304r9","$rmc",1,"R");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,7,"$m304r10","$rmc",1,"R");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,7,"$m304r11","$rmc",1,"R");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,7,"$m304r12","$rmc",1,"R");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,7,"$m304r13","$rmc",1,"R");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,7,"$m304r14","$rmc",1,"R");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,7,"$m304r15","$rmc",1,"R");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,7,"$m304r16","$rmc",1,"R");
$pdf->Cell(143,5," ","$rmc1",0,"R");$pdf->Cell(45,7,"$m304r99","$rmc",1,"R");
                                        }

if ( $strana == 12 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str12.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str12.jpg',0,0,210,297);
}
$pdf->SetY(10);

//modul 110
$m110r12=$hlavicka->m110r12; if ( $m110r12 == 0 ) $m110r12="";
$m110r13=$hlavicka->m110r13; if ( $m110r13 == 0 ) $m110r13="";
$m110r14=$hlavicka->m110r14; if ( $m110r14 == 0 ) $m110r14="";
$m110r15=$hlavicka->m110r15; if ( $m110r15 == 0 ) $m110r15="";
$m110r16=$hlavicka->m110r16; if ( $m110r16 == 0 ) $m110r16="";
$m110r17=$hlavicka->m110r17; if ( $m110r17 == 0 ) $m110r17="";
$m110r18=$hlavicka->m110r18; if ( $m110r18 == 0 ) $m110r18="";
$m110r19=$hlavicka->m110r19; if ( $m110r19 == 0 ) $m110r19="";
$m110r22=$hlavicka->m110r22; if ( $m110r22 == 0 ) $m110r22="";
$m110r23=$hlavicka->m110r23; if ( $m110r23 == 0 ) $m110r23="";
$m110r24=$hlavicka->m110r24; if ( $m110r24 == 0 ) $m110r24="";
$m110r25=$hlavicka->m110r25; if ( $m110r25 == 0 ) $m110r25="";
$m110r26=$hlavicka->m110r26; if ( $m110r26 == 0 ) $m110r26="";
$m110r27=$hlavicka->m110r27; if ( $m110r27 == 0 ) $m110r27="";
$m220r28=$hlavicka->m220r28; if ( $m220r28 == 0 ) $m220r28="";
$m220r29=$hlavicka->m220r29; if ( $m220r29 == 0 ) $m220r29="";
$m110r32=$hlavicka->m110r32; if ( $m110r32 == 0 ) $m110r32="";
$m110r33=$hlavicka->m110r33; if ( $m110r33 == 0 ) $m110r33="";
$m110r34=$hlavicka->m110r34; if ( $m110r34 == 0 ) $m110r34="";
$m110r35=$hlavicka->m110r35; if ( $m110r35 == 0 ) $m110r35="";
$m110r36=$hlavicka->m110r36; if ( $m110r36 == 0 ) $m110r36="";
$m110r37=$hlavicka->m110r37; if ( $m110r37 == 0 ) $m110r37="";
$m330r38=$hlavicka->m330r38; if ( $m330r38 == 0 ) $m330r38="";
$m330r39=$hlavicka->m330r39; if ( $m330r39 == 0 ) $m330r39="";
$m110r42=$hlavicka->m110r42; if ( $m110r42 == 0 ) $m110r42="";
$m110r43=$hlavicka->m110r43; if ( $m110r43 == 0 ) $m110r43="";
$m110r44=$hlavicka->m110r44; if ( $m110r44 == 0 ) $m110r44="";
$m110r45=$hlavicka->m110r45; if ( $m110r45 == 0 ) $m110r45="";
$m110r46=$hlavicka->m110r46; if ( $m110r46 == 0 ) $m110r46="";
$m110r47=$hlavicka->m110r47; if ( $m110r47 == 0 ) $m110r47="";
$m440r48=$hlavicka->m440r48; if ( $m440r48 == 0 ) $m440r48="";
$m440r49=$hlavicka->m440r49; if ( $m440r49 == 0 ) $m440r49="";
$m110r52=$hlavicka->m110r52; if ( $m110r52 == 0 ) $m110r52="";
$m110r53=$hlavicka->m110r53; if ( $m110r53 == 0 ) $m110r53="";
$m110r54=$hlavicka->m110r54; if ( $m110r54 == 0 ) $m110r54="";
$m110r55=$hlavicka->m110r55; if ( $m110r55 == 0 ) $m110r55="";
$m110r56=$hlavicka->m110r56; if ( $m110r56 == 0 ) $m110r56="";
$m110r57=$hlavicka->m110r57; if ( $m110r57 == 0 ) $m110r57="";
$m110r58=$hlavicka->m110r58; if ( $m110r58 == 0 ) $m110r58="";
$m110r59=$hlavicka->m110r59; if ( $m110r59 == 0 ) $m110r59="";
$m110r62=$hlavicka->m110r62; if ( $m110r62 == 0 ) $m110r62="";
$m110r63=$hlavicka->m110r63; if ( $m110r63 == 0 ) $m110r63="";
$m110r64=$hlavicka->m110r64; if ( $m110r64 == 0 ) $m110r64="";
$m110r65=$hlavicka->m110r65; if ( $m110r65 == 0 ) $m110r65="";
$m110r66=$hlavicka->m110r66; if ( $m110r66 == 0 ) $m110r66="";
$m110r67=$hlavicka->m110r67; if ( $m110r67 == 0 ) $m110r67="";
$m110r68=$hlavicka->m110r68; if ( $m110r68 == 0 ) $m110r68="";
$m110r69=$hlavicka->m110r69; if ( $m110r69 == 0 ) $m110r69="";
$m110r72=$hlavicka->m110r72; if ( $m110r72 == 0 ) $m110r72="";
$m110r73=$hlavicka->m110r73; if ( $m110r73 == 0 ) $m110r73="";
$m110r74=$hlavicka->m110r74; if ( $m110r74 == 0 ) $m110r74="";
$m110r75=$hlavicka->m110r75; if ( $m110r75 == 0 ) $m110r75="";
$m110r76=$hlavicka->m110r76; if ( $m110r76 == 0 ) $m110r76="";
$m110r77=$hlavicka->m110r77; if ( $m110r77 == 0 ) $m110r77="";
$m110r78=$hlavicka->m110r78; if ( $m110r78 == 0 ) $m110r78="";
$m110r79=$hlavicka->m110r79; if ( $m110r79 == 0 ) $m110r79="";
$m110r82=$hlavicka->m110r82; if ( $m110r82 == 0 ) $m110r82="";
$m110r83=$hlavicka->m110r83; if ( $m110r83 == 0 ) $m110r83="";
$m110r84=$hlavicka->m110r84; if ( $m110r84 == 0 ) $m110r84="";
$m110r85=$hlavicka->m110r85; if ( $m110r85 == 0 ) $m110r85="";
$m110r86=$hlavicka->m110r86; if ( $m110r86 == 0 ) $m110r86="";
$m110r87=$hlavicka->m110r87; if ( $m110r87 == 0 ) $m110r87="";
$m110r88=$hlavicka->m110r88; if ( $m110r88 == 0 ) $m110r88="";
$m110r89=$hlavicka->m110r89; if ( $m110r89 == 0 ) $m110r89="";
$m110r92=$hlavicka->m110r92; if ( $m110r92 == 0 ) $m110r92="";
$m110r93=$hlavicka->m110r93; if ( $m110r93 == 0 ) $m110r93="";
$m110r94=$hlavicka->m110r94; if ( $m110r94 == 0 ) $m110r94="";
$m110r95=$hlavicka->m110r95; if ( $m110r95 == 0 ) $m110r95="";
$m110r96=$hlavicka->m110r96; if ( $m110r96 == 0 ) $m110r96="";
$m110r97=$hlavicka->m110r97; if ( $m110r97 == 0 ) $m110r97="";
$m110r18=$hlavicka->m110r18; if ( $m110r18 == 0 ) $m110r18="";
$m110r19=$hlavicka->m110r19; if ( $m110r19 == 0 ) $m110r19="";
$m110r102=$hlavicka->m110r102; if ( $m110r102 == 0 ) $m110r102="";
$m110r103=$hlavicka->m110r103; if ( $m110r103 == 0 ) $m110r103="";
$m110r104=$hlavicka->m110r104; if ( $m110r104 == 0 ) $m110r104="";
$m110r105=$hlavicka->m110r105; if ( $m110r105 == 0 ) $m110r105="";
$m110r106=$hlavicka->m110r106; if ( $m110r106 == 0 ) $m110r106="";
$m110r107=$hlavicka->m110r107; if ( $m110r107 == 0 ) $m110r107="";
$m110r108=$hlavicka->m110r108; if ( $m110r108 == 0 ) $m110r108="";
$m110r109=$hlavicka->m110r109; if ( $m110r109 == 0 ) $m110r109="";
$m110r112=$hlavicka->m110r112; if ( $m110r112 == 0 ) $m110r112="";
$m110r113=$hlavicka->m110r113; if ( $m110r113 == 0 ) $m110r113="";
$m110r114=$hlavicka->m110r114; if ( $m110r114 == 0 ) $m110r114="";
$m110r115=$hlavicka->m110r115; if ( $m110r115 == 0 ) $m110r115="";
$m110r116=$hlavicka->m110r116; if ( $m110r116 == 0 ) $m110r116="";
$m110r117=$hlavicka->m110r117; if ( $m110r117 == 0 ) $m110r117="";
$m110r118=$hlavicka->m110r118; if ( $m110r118 == 0 ) $m110r118="";
$m110r119=$hlavicka->m110r119; if ( $m110r119 == 0 ) $m110r119="";
$m110r122=$hlavicka->m110r122; if ( $m110r122 == 0 ) $m110r122="";
$m110r123=$hlavicka->m110r123; if ( $m110r123 == 0 ) $m110r123="";
$m110r124=$hlavicka->m110r124; if ( $m110r124 == 0 ) $m110r124="";
$m110r125=$hlavicka->m110r125; if ( $m110r125 == 0 ) $m110r125="";
$m110r126=$hlavicka->m110r126; if ( $m110r126 == 0 ) $m110r126="";
$m110r127=$hlavicka->m110r127; if ( $m110r127 == 0 ) $m110r127="";
$m110r128=$hlavicka->m110r128; if ( $m110r128 == 0 ) $m110r128="";
$m110r129=$hlavicka->m110r129; if ( $m110r129 == 0 ) $m110r129="";
$m110r132=$hlavicka->m110r132; if ( $m110r132 == 0 ) $m110r132="";
$m110r133=$hlavicka->m110r133; if ( $m110r133 == 0 ) $m110r133="";
$m110r134=$hlavicka->m110r134; if ( $m110r134 == 0 ) $m110r134="";
$m110r135=$hlavicka->m110r135; if ( $m110r135 == 0 ) $m110r135="";
$m110r136=$hlavicka->m110r136; if ( $m110r136 == 0 ) $m110r136="";
$m110r137=$hlavicka->m110r137; if ( $m110r137 == 0 ) $m110r137="";
$m110r138=$hlavicka->m110r138; if ( $m110r138 == 0 ) $m110r138="";
$m110r139=$hlavicka->m110r139; if ( $m110r139 == 0 ) $m110r139="";
$m110r142=$hlavicka->m110r142; if ( $m110r142 == 0 ) $m110r142="";
$m110r143=$hlavicka->m110r143; if ( $m110r143 == 0 ) $m110r143="";
$m110r144=$hlavicka->m110r144; if ( $m110r144 == 0 ) $m110r144="";
$m110r145=$hlavicka->m110r145; if ( $m110r145 == 0 ) $m110r145="";
$m110r146=$hlavicka->m110r146; if ( $m110r146 == 0 ) $m110r146="";
$m110r147=$hlavicka->m110r147; if ( $m110r147 == 0 ) $m110r147="";
$m110r148=$hlavicka->m110r148; if ( $m110r148 == 0 ) $m110r148="";
$m110r149=$hlavicka->m110r149; if ( $m110r149 == 0 ) $m110r149="";
$m110r152=$hlavicka->m110r152; if ( $m110r152 == 0 ) $m110r152="";
$m110r153=$hlavicka->m110r153; if ( $m110r153 == 0 ) $m110r153="";
$m110r154=$hlavicka->m110r154; if ( $m110r154 == 0 ) $m110r154="";
$m110r155=$hlavicka->m110r155; if ( $m110r155 == 0 ) $m110r155="";
$m110r156=$hlavicka->m110r156; if ( $m110r156 == 0 ) $m110r156="";
$m110r157=$hlavicka->m110r157; if ( $m110r157 == 0 ) $m110r157="";
$m110r158=$hlavicka->m110r158; if ( $m110r158 == 0 ) $m110r158="";
$m110r159=$hlavicka->m110r159; if ( $m110r159 == 0 ) $m110r159="";
$m110r162=$hlavicka->m110r162; if ( $m110r162 == 0 ) $m110r162="";
$m110r163=$hlavicka->m110r163; if ( $m110r163 == 0 ) $m110r163="";
$m110r164=$hlavicka->m110r164; if ( $m110r164 == 0 ) $m110r164="";
$m110r165=$hlavicka->m110r165; if ( $m110r165 == 0 ) $m110r165="";
$m110r166=$hlavicka->m110r166; if ( $m110r166 == 0 ) $m110r166="";
$m110r167=$hlavicka->m110r167; if ( $m110r167 == 0 ) $m110r167="";
$m110r168=$hlavicka->m110r168; if ( $m110r168 == 0 ) $m110r168="";
$m110r169=$hlavicka->m110r169; if ( $m110r169 == 0 ) $m110r169="";
$m110r172=$hlavicka->m110r172; if ( $m110r172 == 0 ) $m110r172="";
$m110r173=$hlavicka->m110r173; if ( $m110r173 == 0 ) $m110r173="";
$m110r174=$hlavicka->m110r174; if ( $m110r174 == 0 ) $m110r174="";
$m110r175=$hlavicka->m110r175; if ( $m110r175 == 0 ) $m110r175="";
$m110r176=$hlavicka->m110r176; if ( $m110r176 == 0 ) $m110r176="";
$m110r177=$hlavicka->m110r177; if ( $m110r177 == 0 ) $m110r177="";
$m110r178=$hlavicka->m110r178; if ( $m110r178 == 0 ) $m110r178="";
$m110r179=$hlavicka->m110r179; if ( $m110r179 == 0 ) $m110r179="";
$m110r182=$hlavicka->m110r182; if ( $m110r182 == 0 ) $m110r182="";
$m110r183=$hlavicka->m110r183; if ( $m110r183 == 0 ) $m110r183="";
$m110r184=$hlavicka->m110r184; if ( $m110r184 == 0 ) $m110r184="";
$m110r185=$hlavicka->m110r185; if ( $m110r185 == 0 ) $m110r185="";
$m110r186=$hlavicka->m110r186; if ( $m110r186 == 0 ) $m110r186="";
$m110r187=$hlavicka->m110r187; if ( $m110r187 == 0 ) $m110r187="";
$m110r188=$hlavicka->m110r188; if ( $m110r188 == 0 ) $m110r188="";
$m110r189=$hlavicka->m110r189; if ( $m110r189 == 0 ) $m110r189="";
$m110r192=$hlavicka->m110r192; if ( $m110r192 == 0 ) $m110r192="";
$m110r193=$hlavicka->m110r193; if ( $m110r193 == 0 ) $m110r193="";
$m110r194=$hlavicka->m110r194; if ( $m110r194 == 0 ) $m110r194="";
$m110r195=$hlavicka->m110r195; if ( $m110r195 == 0 ) $m110r195="";
$m110r196=$hlavicka->m110r196; if ( $m110r196 == 0 ) $m110r196="";
$m110r197=$hlavicka->m110r197; if ( $m110r197 == 0 ) $m110r197="";
$m110r198=$hlavicka->m110r198; if ( $m110r198 == 0 ) $m110r198="";
$m110r199=$hlavicka->m110r199; if ( $m110r199 == 0 ) $m110r199="";
$m110r202=$hlavicka->m110r202; if ( $m110r202 == 0 ) $m110r202="";
$m110r203=$hlavicka->m110r203; if ( $m110r203 == 0 ) $m110r203="";
$m110r204=$hlavicka->m110r204; if ( $m110r204 == 0 ) $m110r204="";
$m110r205=$hlavicka->m110r205; if ( $m110r205 == 0 ) $m110r205="";
$m110r206=$hlavicka->m110r206; if ( $m110r206 == 0 ) $m110r206="";
$m110r207=$hlavicka->m110r207; if ( $m110r207 == 0 ) $m110r207="";
$m110r208=$hlavicka->m110r208; if ( $m110r208 == 0 ) $m110r208="";
$m110r209=$hlavicka->m110r209; if ( $m110r209 == 0 ) $m110r209="";
$m110r212=$hlavicka->m110r212; if ( $m110r212 == 0 ) $m110r212="";
$m110r213=$hlavicka->m110r213; if ( $m110r213 == 0 ) $m110r213="";
$m110r214=$hlavicka->m110r214; if ( $m110r214 == 0 ) $m110r214="";
$m110r215=$hlavicka->m110r215; if ( $m110r215 == 0 ) $m110r215="";
$m110r216=$hlavicka->m110r216; if ( $m110r216 == 0 ) $m110r216="";
$m110r217=$hlavicka->m110r217; if ( $m110r217 == 0 ) $m110r217="";
$m110r218=$hlavicka->m110r218; if ( $m110r218 == 0 ) $m110r218="";
$m110r219=$hlavicka->m110r219; if ( $m110r219 == 0 ) $m110r219="";
$m110r222=$hlavicka->m110r222; if ( $m110r222 == 0 ) $m110r222="";
$m110r223=$hlavicka->m110r223; if ( $m110r223 == 0 ) $m110r223="";
$m110r224=$hlavicka->m110r224; if ( $m110r224 == 0 ) $m110r224="";
$m110r225=$hlavicka->m110r225; if ( $m110r225 == 0 ) $m110r225="";
$m110r226=$hlavicka->m110r226; if ( $m110r226 == 0 ) $m110r226="";
$m110r227=$hlavicka->m110r227; if ( $m110r227 == 0 ) $m110r227="";
$m110r228=$hlavicka->m110r228; if ( $m110r228 == 0 ) $m110r228="";
$m110r229=$hlavicka->m110r229; if ( $m110r229 == 0 ) $m110r229="";
$m110r232=$hlavicka->m110r232; if ( $m110r232 == 0 ) $m110r232="";
$m110r233=$hlavicka->m110r233; if ( $m110r233 == 0 ) $m110r233="";
$m110r234=$hlavicka->m110r234; if ( $m110r234 == 0 ) $m110r234="";
$m110r235=$hlavicka->m110r235; if ( $m110r235 == 0 ) $m110r235="";
$m110r236=$hlavicka->m110r236; if ( $m110r236 == 0 ) $m110r236="";
$m110r237=$hlavicka->m110r237; if ( $m110r237 == 0 ) $m110r237="";
$m110r238=$hlavicka->m110r238; if ( $m110r238 == 0 ) $m110r238="";
$m110r239=$hlavicka->m110r239; if ( $m110r239 == 0 ) $m110r239="";
$m110r242=$hlavicka->m110r242; if ( $m110r242 == 0 ) $m110r242="";
$m110r243=$hlavicka->m110r243; if ( $m110r243 == 0 ) $m110r243="";
$m110r244=$hlavicka->m110r244; if ( $m110r244 == 0 ) $m110r244="";
$m110r245=$hlavicka->m110r245; if ( $m110r245 == 0 ) $m110r245="";
$m110r246=$hlavicka->m110r246; if ( $m110r246 == 0 ) $m110r246="";
$m110r247=$hlavicka->m110r247; if ( $m110r247 == 0 ) $m110r247="";
$m110r248=$hlavicka->m110r248; if ( $m110r248 == 0 ) $m110r248="";
$m110r249=$hlavicka->m110r249; if ( $m110r249 == 0 ) $m110r249="";
$m110r252=$hlavicka->m110r252; if ( $m110r252 == 0 ) $m110r252="";
$m110r253=$hlavicka->m110r253; if ( $m110r253 == 0 ) $m110r253="";
$m110r254=$hlavicka->m110r254; if ( $m110r254 == 0 ) $m110r254="";
$m110r255=$hlavicka->m110r255; if ( $m110r255 == 0 ) $m110r255="";
$m110r256=$hlavicka->m110r256; if ( $m110r256 == 0 ) $m110r256="";
$m110r257=$hlavicka->m110r257; if ( $m110r257 == 0 ) $m110r257="";
$m110r258=$hlavicka->m110r258; if ( $m110r258 == 0 ) $m110r258="";
$m110r259=$hlavicka->m110r259; if ( $m110r259 == 0 ) $m110r259="";
$m110r262=$hlavicka->m110r262; if ( $m110r262 == 0 ) $m110r262="";
$m110r263=$hlavicka->m110r263; if ( $m110r263 == 0 ) $m110r263="";
$m110r264=$hlavicka->m110r264; if ( $m110r264 == 0 ) $m110r264="";
$m110r265=$hlavicka->m110r265; if ( $m110r265 == 0 ) $m110r265="";
$m110r266=$hlavicka->m110r266; if ( $m110r266 == 0 ) $m110r266="";
$m110r267=$hlavicka->m110r267; if ( $m110r267 == 0 ) $m110r267="";
$m110r268=$hlavicka->m110r268; if ( $m110r268 == 0 ) $m110r268="";
$m110r269=$hlavicka->m110r269; if ( $m110r269 == 0 ) $m110r269="";
$m110r272=$hlavicka->m110r272; if ( $m110r272 == 0 ) $m110r272="";
$m110r273=$hlavicka->m110r273; if ( $m110r273 == 0 ) $m110r273="";
$m110r274=$hlavicka->m110r274; if ( $m110r274 == 0 ) $m110r274="";
$m110r275=$hlavicka->m110r275; if ( $m110r275 == 0 ) $m110r275="";
$m110r276=$hlavicka->m110r276; if ( $m110r276 == 0 ) $m110r276="";
$m110r277=$hlavicka->m110r277; if ( $m110r277 == 0 ) $m110r277="";
$m110r278=$hlavicka->m110r278; if ( $m110r278 == 0 ) $m110r278="";
$m110r279=$hlavicka->m110r279; if ( $m110r279 == 0 ) $m110r279="";
$m110r282=$hlavicka->m110r282; if ( $m110r282 == 0 ) $m110r282="";
$m110r283=$hlavicka->m110r283; if ( $m110r283 == 0 ) $m110r283="";
$m110r284=$hlavicka->m110r284; if ( $m110r284 == 0 ) $m110r284="";
$m110r285=$hlavicka->m110r285; if ( $m110r285 == 0 ) $m110r285="";
$m110r286=$hlavicka->m110r286; if ( $m110r286 == 0 ) $m110r286="";
$m110r287=$hlavicka->m110r287; if ( $m110r287 == 0 ) $m110r287="";
$m110r288=$hlavicka->m110r288; if ( $m110r288 == 0 ) $m110r288="";
$m110r289=$hlavicka->m110r289; if ( $m110r289 == 0 ) $m110r289="";
$m110r292=$hlavicka->m110r292; if ( $m110r292 == 0 ) $m110r292="";
$m110r293=$hlavicka->m110r293; if ( $m110r293 == 0 ) $m110r293="";
$m110r294=$hlavicka->m110r294; if ( $m110r294 == 0 ) $m110r294="";
$m110r295=$hlavicka->m110r295; if ( $m110r295 == 0 ) $m110r295="";
$m110r296=$hlavicka->m110r296; if ( $m110r296 == 0 ) $m110r296="";
$m110r297=$hlavicka->m110r297; if ( $m110r297 == 0 ) $m110r297="";
$m110r298=$hlavicka->m110r298; if ( $m110r298 == 0 ) $m110r298="";
$m110r299=$hlavicka->m110r299; if ( $m110r299 == 0 ) $m110r299="";
$m110r302=$hlavicka->m110r302; if ( $m110r302 == 0 ) $m110r302="";
$m110r303=$hlavicka->m110r303; if ( $m110r303 == 0 ) $m110r303="";
$m110r304=$hlavicka->m110r304; if ( $m110r304 == 0 ) $m110r304="";
$m110r305=$hlavicka->m110r305; if ( $m110r305 == 0 ) $m110r305="";
$m110r306=$hlavicka->m110r306; if ( $m110r306 == 0 ) $m110r306="";
$m110r307=$hlavicka->m110r307; if ( $m110r307 == 0 ) $m110r307="";
$m110r308=$hlavicka->m110r308; if ( $m110r308 == 0 ) $m110r308="";
$m110r309=$hlavicka->m110r309; if ( $m110r309 == 0 ) $m110r309="";
$m110r312=$hlavicka->m110r312; if ( $m110r312 == 0 ) $m110r312="";
$m110r313=$hlavicka->m110r313; if ( $m110r313 == 0 ) $m110r313="";
$m110r314=$hlavicka->m110r314; if ( $m110r314 == 0 ) $m110r314="";
$m110r315=$hlavicka->m110r315; if ( $m110r315 == 0 ) $m110r315="";
$m110r316=$hlavicka->m110r316; if ( $m110r316 == 0 ) $m110r316="";
$m110r317=$hlavicka->m110r317; if ( $m110r317 == 0 ) $m110r317="";
$m110r318=$hlavicka->m110r318; if ( $m110r318 == 0 ) $m110r318="";
$m110r319=$hlavicka->m110r319; if ( $m110r319 == 0 ) $m110r319="";
$m110r322=$hlavicka->m110r322; if ( $m110r322 == 0 ) $m110r322="";
$m110r323=$hlavicka->m110r323; if ( $m110r323 == 0 ) $m110r323="";
$m110r324=$hlavicka->m110r324; if ( $m110r324 == 0 ) $m110r324="";
$m110r325=$hlavicka->m110r325; if ( $m110r325 == 0 ) $m110r325="";
$m110r326=$hlavicka->m110r326; if ( $m110r326 == 0 ) $m110r326="";
$m110r327=$hlavicka->m110r327; if ( $m110r327 == 0 ) $m110r327="";
$m110r328=$hlavicka->m110r328; if ( $m110r328 == 0 ) $m110r328="";
$m110r329=$hlavicka->m110r329; if ( $m110r329 == 0 ) $m110r329="";
$m110r332=$hlavicka->m110r332; if ( $m110r332 == 0 ) $m110r332="";
$m110r333=$hlavicka->m110r333; if ( $m110r333 == 0 ) $m110r333="";
$m110r334=$hlavicka->m110r334; if ( $m110r334 == 0 ) $m110r334="";
$m110r335=$hlavicka->m110r335; if ( $m110r335 == 0 ) $m110r335="";
$m110r336=$hlavicka->m110r336; if ( $m110r336 == 0 ) $m110r336="";
$m110r337=$hlavicka->m110r337; if ( $m110r337 == 0 ) $m110r337="";
$m110r338=$hlavicka->m110r338; if ( $m110r338 == 0 ) $m110r338="";
$m110r339=$hlavicka->m110r339; if ( $m110r339 == 0 ) $m110r339="";
$m110r342=$hlavicka->m110r342; if ( $m110r342 == 0 ) $m110r342="";
$m110r343=$hlavicka->m110r343; if ( $m110r343 == 0 ) $m110r343="";
$m110r344=$hlavicka->m110r344; if ( $m110r344 == 0 ) $m110r344="";
$m110r345=$hlavicka->m110r345; if ( $m110r345 == 0 ) $m110r345="";
$m110r346=$hlavicka->m110r346; if ( $m110r346 == 0 ) $m110r346="";
$m110r347=$hlavicka->m110r347; if ( $m110r347 == 0 ) $m110r347="";
$m110r348=$hlavicka->m110r348; if ( $m110r348 == 0 ) $m110r348="";
$m110r349=$hlavicka->m110r349; if ( $m110r349 == 0 ) $m110r349="";
$m110r992=$hlavicka->m110r992;
//if ( $m110r992 == 0 ) $m110r992="";
$m110r993=$hlavicka->m110r993;
//if ( $m110r993 == 0 ) $m110r993="";
$m110r994=$hlavicka->m110r994;
//if ( $m110r994 == 0 ) $m110r994="";
$m110r995=$hlavicka->m110r995;
//if ( $m110r995 == 0 ) $m110r995="";
$m110r996=$hlavicka->m110r996;
//if ( $m110r996 == 0 ) $m110r996="";
$m110r997=$hlavicka->m110r997;
//if ( $m110r997 == 0 ) $m110r997="";
$pdf->Cell(195,39," ","$rmc1",1,"L");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r12","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r13","$rmc",0,"R");$pdf->Cell(15,6,"$m110r14","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r15","$rmc",0,"R");$pdf->Cell(15,6,"$m110r16","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r17","$rmc",0,"R");$pdf->Cell(15,6,"$m110r18","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r19","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r22","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r23","$rmc",0,"R");$pdf->Cell(15,6,"$m110r24","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r25","$rmc",0,"R");$pdf->Cell(15,6,"$m110r26","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r27","$rmc",0,"R");$pdf->Cell(15,6,"$m110r28","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r29","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r32","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r33","$rmc",0,"R");$pdf->Cell(15,6,"$m110r34","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r35","$rmc",0,"R");$pdf->Cell(15,6,"$m110r36","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r37","$rmc",0,"R");$pdf->Cell(15,6,"$m110r38","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r39","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r42","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r43","$rmc",0,"R");$pdf->Cell(15,6,"$m110r44","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r45","$rmc",0,"R");$pdf->Cell(15,6,"$m110r46","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r47","$rmc",0,"R");$pdf->Cell(15,6,"$m110r48","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r49","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r52","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r53","$rmc",0,"R");$pdf->Cell(15,6,"$m110r54","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r55","$rmc",0,"R");$pdf->Cell(15,6,"$m110r56","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r57","$rmc",0,"R");$pdf->Cell(15,6,"$m110r58","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r59","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r62","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r63","$rmc",0,"R");$pdf->Cell(15,6,"$m110r64","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r65","$rmc",0,"R");$pdf->Cell(15,6,"$m110r66","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r67","$rmc",0,"R");$pdf->Cell(15,6,"$m110r68","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r69","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r72","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r73","$rmc",0,"R");$pdf->Cell(15,6,"$m110r74","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r75","$rmc",0,"R");$pdf->Cell(15,6,"$m110r76","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r77","$rmc",0,"R");$pdf->Cell(15,6,"$m110r78","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r79","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r82","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r83","$rmc",0,"R");$pdf->Cell(15,6,"$m110r84","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r85","$rmc",0,"R");$pdf->Cell(15,6,"$m110r86","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r87","$rmc",0,"R");$pdf->Cell(15,6,"$m110r88","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r89","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r92","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r93","$rmc",0,"R");$pdf->Cell(15,6,"$m110r94","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r95","$rmc",0,"R");$pdf->Cell(15,6,"$m110r96","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r97","$rmc",0,"R");$pdf->Cell(15,6,"$m110r98","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r99","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,8,"","$rmc",0,"R");$pdf->Cell(15,8,"$m110r102","$rmc",0,"R");
$pdf->Cell(15,8,"$m110r103","$rmc",0,"R");$pdf->Cell(15,8,"$m110r104","$rmc",0,"R");
$pdf->Cell(15,8,"$m110r105","$rmc",0,"R");$pdf->Cell(15,8,"$m110r106","$rmc",0,"R");
$pdf->Cell(15,8,"$m110r107","$rmc",0,"R");$pdf->Cell(15,8,"$m110r108","$rmc",0,"R");
$pdf->Cell(15,8,"$m110r109","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r112","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r113","$rmc",0,"R");$pdf->Cell(15,6,"$m110r114","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r115","$rmc",0,"R");$pdf->Cell(15,6,"$m110r116","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r117","$rmc",0,"R");$pdf->Cell(15,6,"$m110r118","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r119","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r122","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r123","$rmc",0,"R");$pdf->Cell(15,6,"$m110r124","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r125","$rmc",0,"R");$pdf->Cell(15,6,"$m110r126","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r127","$rmc",0,"R");$pdf->Cell(15,6,"$m110r128","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r129","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r132","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r133","$rmc",0,"R");$pdf->Cell(15,6,"$m110r134","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r135","$rmc",0,"R");$pdf->Cell(15,6,"$m110r136","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r137","$rmc",0,"R");$pdf->Cell(15,6,"$m110r138","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r139","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,7,"","$rmc",0,"R");$pdf->Cell(15,7,"$m110r142","$rmc",0,"R");
$pdf->Cell(15,7,"$m110r143","$rmc",0,"R");$pdf->Cell(15,7,"$m110r144","$rmc",0,"R");
$pdf->Cell(15,7,"$m110r145","$rmc",0,"R");$pdf->Cell(15,7,"$m110r146","$rmc",0,"R");
$pdf->Cell(15,7,"$m110r147","$rmc",0,"R");$pdf->Cell(15,7,"$m110r148","$rmc",0,"R");
$pdf->Cell(15,7,"$m110r149","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r152","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r153","$rmc",0,"R");$pdf->Cell(15,6,"$m110r154","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r155","$rmc",0,"R");$pdf->Cell(15,6,"$m110r156","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r157","$rmc",0,"R");$pdf->Cell(15,6,"$m110r158","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r159","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r162","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r163","$rmc",0,"R");$pdf->Cell(15,6,"$m110r164","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r165","$rmc",0,"R");$pdf->Cell(15,6,"$m110r166","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r167","$rmc",0,"R");$pdf->Cell(15,6,"$m110r168","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r169","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r172","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r173","$rmc",0,"R");$pdf->Cell(15,6,"$m110r174","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r175","$rmc",0,"R");$pdf->Cell(15,6,"$m110r176","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r177","$rmc",0,"R");$pdf->Cell(15,6,"$m110r178","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r179","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r182","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r183","$rmc",0,"R");$pdf->Cell(15,6,"$m110r184","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r185","$rmc",0,"R");$pdf->Cell(15,6,"$m110r186","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r187","$rmc",0,"R");$pdf->Cell(15,6,"$m110r188","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r189","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r192","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r193","$rmc",0,"R");$pdf->Cell(15,6,"$m110r194","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r195","$rmc",0,"R");$pdf->Cell(15,6,"$m110r196","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r197","$rmc",0,"R");$pdf->Cell(15,6,"$m110r198","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r199","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r202","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r203","$rmc",0,"R");$pdf->Cell(15,6,"$m110r204","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r205","$rmc",0,"R");$pdf->Cell(15,6,"$m110r206","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r207","$rmc",0,"R");$pdf->Cell(15,6,"$m110r208","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r209","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r212","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r213","$rmc",0,"R");$pdf->Cell(15,6,"$m110r214","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r215","$rmc",0,"R");$pdf->Cell(15,6,"$m110r216","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r217","$rmc",0,"R");$pdf->Cell(15,6,"$m110r218","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r219","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r222","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r223","$rmc",0,"R");$pdf->Cell(15,6,"$m110r224","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r225","$rmc",0,"R");$pdf->Cell(15,6,"$m110r226","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r227","$rmc",0,"R");$pdf->Cell(15,6,"$m110r228","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r229","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r232","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r233","$rmc",0,"R");$pdf->Cell(15,6,"$m110r234","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r235","$rmc",0,"R");$pdf->Cell(15,6,"$m110r236","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r237","$rmc",0,"R");$pdf->Cell(15,6,"$m110r238","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r239","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r242","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r243","$rmc",0,"R");$pdf->Cell(15,6,"$m110r244","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r245","$rmc",0,"R");$pdf->Cell(15,6,"$m110r246","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r247","$rmc",0,"R");$pdf->Cell(15,6,"$m110r248","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r249","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r252","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r253","$rmc",0,"R");$pdf->Cell(15,6,"$m110r254","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r255","$rmc",0,"R");$pdf->Cell(15,6,"$m110r256","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r257","$rmc",0,"R");$pdf->Cell(15,6,"$m110r258","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r259","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r262","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r263","$rmc",0,"R");$pdf->Cell(15,6,"$m110r264","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r265","$rmc",0,"R");$pdf->Cell(15,6,"$m110r266","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r267","$rmc",0,"R");$pdf->Cell(15,6,"$m110r268","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r269","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r272","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r273","$rmc",0,"R");$pdf->Cell(15,6,"$m110r274","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r275","$rmc",0,"R");$pdf->Cell(15,6,"$m110r276","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r277","$rmc",0,"R");$pdf->Cell(15,6,"$m110r278","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r279","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r282","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r283","$rmc",0,"R");$pdf->Cell(15,6,"$m110r284","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r285","$rmc",0,"R");$pdf->Cell(15,6,"$m110r286","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r287","$rmc",0,"R");$pdf->Cell(15,6,"$m110r288","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r289","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r292","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r293","$rmc",0,"R");$pdf->Cell(15,6,"$m110r294","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r295","$rmc",0,"R");$pdf->Cell(15,6,"$m110r296","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r297","$rmc",0,"R");$pdf->Cell(15,6,"$m110r298","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r299","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r302","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r303","$rmc",0,"R");$pdf->Cell(15,6,"$m110r304","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r305","$rmc",0,"R");$pdf->Cell(15,6,"$m110r306","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r307","$rmc",0,"R");$pdf->Cell(15,6,"$m110r308","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r309","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r312","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r313","$rmc",0,"R");$pdf->Cell(15,6,"$m110r314","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r315","$rmc",0,"R");$pdf->Cell(15,6,"$m110r316","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r317","$rmc",0,"R");$pdf->Cell(15,6,"$m110r318","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r319","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r322","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r323","$rmc",0,"R");$pdf->Cell(15,6,"$m110r324","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r325","$rmc",0,"R");$pdf->Cell(15,6,"$m110r326","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r327","$rmc",0,"R");$pdf->Cell(15,6,"$m110r328","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r329","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r332","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r333","$rmc",0,"R");$pdf->Cell(15,6,"$m110r334","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r335","$rmc",0,"R");$pdf->Cell(15,6,"$m110r336","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r337","$rmc",0,"R");$pdf->Cell(15,6,"$m110r338","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r339","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,5,"","$rmc",0,"R");$pdf->Cell(15,5,"$m110r342","$rmc",0,"R");
$pdf->Cell(15,5,"$m110r343","$rmc",0,"R");$pdf->Cell(15,5,"$m110r344","$rmc",0,"R");
$pdf->Cell(15,5,"$m110r345","$rmc",0,"R");$pdf->Cell(15,5,"$m110r346","$rmc",0,"R");
$pdf->Cell(15,5,"$m110r347","$rmc",0,"R");$pdf->Cell(15,5,"$m110r348","$rmc",0,"R");
$pdf->Cell(15,5,"$m110r349","$rmc",1,"R");
$pdf->Cell(54,4," ","$rmc1",0,"L");
$pdf->Cell(15,6,"","$rmc",0,"R");$pdf->Cell(15,6,"$m110r992","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r993","$rmc",0,"R");$pdf->Cell(15,6,"$m110r994","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r995","$rmc",0,"R");$pdf->Cell(15,6,"$m110r996","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r997","$rmc",0,"R");$pdf->Cell(15,6,"$m110r998","$rmc",0,"R");
$pdf->Cell(15,6,"$m110r999","$rmc",1,"R");
                                        }
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
//koniec vytlac

$cislista = include("uct_lista_norm.php");
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>